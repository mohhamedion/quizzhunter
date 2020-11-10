<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Hash;
use App\Models\User;
use Auth;
use App\Models\Test;
use App\Models\TestSession;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TestController extends Controller
{
    //


    public function index(Request $request){
     

                $result= Test::select(DB::raw("*,(select sum(test_rate.rate) from test_rate where test_rate.test_id=tests.id) as totalRate"))
                ->where("published",1)
                ->with('level')
                ->with('user')
                ->with('category');

                if($request->level>0){
                    $result = $result->where('level',$request->level);
                }
                if($request->category>0){
                    $result = $result->where('category',$request->category);
                }

                return response()->json($result->get());
    }




    
    public function show($test_id){
         $test = Test::where("id",$test_id)->where('published',1)->with('level')->with('category')->with('user')->withCount('questions')->with("comments.user")->get();
         $bestIn30Days = $this->getBestIn30Days($test_id);
         
        $lastSessions =$this->getLastSessions($test_id);
        
        
        //  $testSessions =  DB::select("select*, 
        //  (select sum(mark) from session_questions where session_questions.session_id=test_sessions.id ) 
        //  as totalPoints 
        //  from `test_sessions`where `test_id` = ? and month(`created_at`) = ?
        //  GROUP BY test_sessions.user_id ORDER BY totalPoints DESC ",[$test_id,Carbon::now()->month]);
         
        $test['bestIn30Days'] = $bestIn30Days;
        $test['lastSessions'] = $lastSessions;
         return response()->json($test);

    }


    private function getLastSessions($test_id){
        return TestSession::where('test_id',$test_id)
        ->with('user')
        ->where(function($q){
            $q->orWhere("going",0)->orWhere('end_at','<',Carbon::now());
        })->select(DB::Raw("*,
        (select sum(mark)  from session_questions where session_questions.session_id=test_sessions.id ) as totalPoints"))
        ->withCount('sessionQuestions')
        ->limit(4)->orderBy('created_at','DESC')->get();
  
    }
    

    private function getBestIn30Days($test_id){
       return TestSession::where('test_id',$test_id)
        ->with('user')
        ->whereMonth("created_at",Carbon::now()->month)
        ->where(function($q){
        $q->orWhere("going",0)->orWhere('end_at','<',Carbon::now());
        })
        ->select(DB::Raw(" *,
        (select sum(mark) from session_questions where session_questions.session_id=test_sessions.id ) as totalPoints 
        ,
        (updated_at-created_at) as inTime
        "))->orderBy('totalPoints','DESC')->groupBy('test_sessions.user_id')->withCount('sessionQuestions')->limit(3)->get();

        
    }
    
    
    public function getDraftTests(){
        // return response(404);
        $draftTests  = Test::where("user_id",Auth::user('api')->id)
        ->where('published',0)
        ->with('category')
        ->with('level')
        ->get();
        return response()->json($draftTests);
        
    }

    public function getDraftTestsById($test_id){
        $test = Test::where("user_id",Auth::user('api')->id)->where("id",$test_id)->where('published',0)->with('level')->with('category')->with('questions.answers')->get();
        return response()->json($test);        
    }
   public function deleteDraftTest($test_id){
        
        $test = Test::where('id',$test_id)->where('published',0)->where('user_id',Auth::user('api')->id);
        if($test){
            $this->deleteQuestionsAndAnswersByTestId($test_id);
            $test->delete();
            return response(200);
        }
        return response(500);
    }





    private function deleteQuestionsAndAnswersByTestId($test_id){
        $questions = Question::where('test_id',$test_id)->get();
          foreach($questions as $question){
              $question->answers()->delete();
              $question->delete();
          }
    }
    
    
    public function publishTest($test_id){
            $test = Test::where('id',$test_id)->where('user_id',Auth::user('api')->id)->get()->last();
            $test->published = true;
            $test->save();
            return response(200);
     }
    
    public function store(Request $request){

        $validator = Validator::make($request->all(), [ 
            'level'=>'required|int|max:11',
            'description'=>'required|max:500',
            'category'=>'required|int|max:11',
            'second_per_question'=>'required|max:255',
         ]);
    if($validator->fails()){
        return response()->json(['error'=>$validator->errors()], 401);
    
    }

    $test = $request->post();
    $test['user_id'] = Auth::user('api')->id;
    $test = Test::create($test);
    $lastTest = Test::where('id',$test->id)->with('category')->with('level')->get();
   
    return response()->json($lastTest);

    }



    public function getBestFive(){

       $bestfive  = Test::select(DB::raw("*,(select sum(test_rate.rate) from test_rate where test_rate.test_id=tests.id) as totalRate"))
       ->where("published",1)
       ->with('level')
       ->with('user')
       ->with('category')->limit(5)->orderBy('totalRate','DESC')
       ->get();

        return response()->json($bestfive);
     }



    }




