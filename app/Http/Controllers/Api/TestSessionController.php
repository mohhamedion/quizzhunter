<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Hash;
use App\Models\User;
use Auth;
use App\Models\Test;
use App\Models\Question;
use App\Models\TestSession;
use Carbon\Carbon;
use App\Models\SessionAnswer;
use App\Models\SessionQuestion;
use App\Models\Answer;
use App\Models\TestRate;
use Illuminate\Support\Facades\DB;

class TestSessionController extends Controller
{
    //




    public function getTestSessionResult(Request $request,$session_id){
        $sessionResult = TestSession::where("id",$session_id)->where(function($q){
            $q->orWhere('going',false)->orWhere('end_at','<=',Carbon::now());
        })
        ->with('sessionQuestions.sessionAnswers')
        ->with('sessionQuestions.question.answers')
        ->with('test.category')->with('test.level')->with('mark')
        ->get()->last();
        $showRate = false;
        if($request->user('api')&&$request->user('api')->id==$sessionResult->user_id){
            $showRate = (TestRate::where('user_id',$request->user('api')->id)->where('test_id',$sessionResult->test_id)->count()==0) ? true : false;
        }

        $sessionResult['showRate'] =$showRate; 
        return response()->json($sessionResult);

   }





   
    public function answerQuestion(Request $request){
        //
        $validator = Validator::make($request->all(), [ 
            'session_question_id'=>'required|int',
            'answer_ids'=>'required|array',
            'answer_ids.*'=>'int',
            ]);
            if($validator->fails()){
                return response()->json(['error'=>$validator->errors()], 401);
            }
            $session = $this->getCurrentSession();
            $sessionQuestion= SessionQuestion::find($request->session_question_id);
            
            $this->ifLastQuestionEndSession($session);

            if($this->checkIfSessionQuestionBelongsToSessionTest($session,$sessionQuestion)){
                return response()->json(['error'], 401);
            }
            
            //WRITE LOGIN TO PREVENT PEOPLE FROM  ANSWERING ANSWERS OF ANOTHER QUESTIONS

            if($this->createSessionAnswers($request,$session)){
                $sessionQuestion->answered  = true;
                $sessionQuestion->save();
                // $sessionQuestion->question->answers()->where('correct')
                $this->signMarksForQuestions($sessionQuestion,$request->answer_ids);
            }

          return response(200);

    }




        private function signMarksForQuestions($sessionQuestion,$answerIds){
            $correctAnswers  = Answer::select('id')->where("question_id",$sessionQuestion->question_id)->where('correct',true)->get();
           
            if(count($correctAnswers)>0){

          
                $correctAnswers = $this->objectToIndexArray($correctAnswers);
                $mark   = 1/count($correctAnswers);
                $countCorrectAnswersByUser = count(array_intersect($correctAnswers,$answerIds));
                $countIncorrectAnswersByUser = count($answerIds)- $countCorrectAnswersByUser; 
                // $countMissedCorrectAnswers = count($correctAnswers) -  $countCorrectAnswersByUser ; 
                // $countIncorrectAnswers = $countIncorrectAnswersByUser +  $countMissedCorrectAnswers  ;
                $diffrence = ($countCorrectAnswersByUser-$countIncorrectAnswersByUser) ;
                if($diffrence<0){
                    $diffrence=0;
                }

                $finalMark =   $mark *  $diffrence;

                $sessionQuestion->mark  = $finalMark;
                $sessionQuestion->save();
            }
    
             
        }


        private function objectToIndexArray($assArray){
            $result=[];
            foreach($assArray as $array){
                $result[]=$array->id;
            }
            return $result;
        }
        private function ifLastQuestionEndSession($session){
            $questionLeft = SessionQuestion::where('answered',false)->where('session_id',$session->id)->count();
            if($questionLeft<=1){
                $session->going=false;
                $session->save();
            }

        }

        private function createSessionAnswers($request,$session){
            
            foreach($request->answer_ids as $answerId):
                SessionAnswer::create([
                    'session_question_id'=>$request->session_question_id,
                    'answer_id'=>$answerId,
                    'session_id'=>$session->id,
                    'choosen'=>true
                ]);
            endforeach;

            return true;
        }

        private function checkIfSessionQuestionBelongsToSessionTest($session,$sessionQuestion){
            if($session->test_id==$sessionQuestion->test_id){
                return true;
            }
            return false;
        }


    public function show(){


        $testSession = $this->getCurrentSession();
       
        if($testSession){
              extract($this->countLeftTimeForSession($testSession));
              return response()->json(["session"=>$testSession,'timeString'=> $timeString ,'timeInteger'=>$timeInteger]);
        }
        return response('status',404);
    }

    private function countLeftTimeForSession($testSession){
            $endTime =  new Carbon($testSession->end_at);
            $timer = $endTime->diffInSeconds(Carbon::now());
            $timeInteger = $timer;
            $timeString = gmdate('H:i:s', $timer);

            return  ['timeString'=> $timeString ,'timeInteger'=>$timeInteger];
    }

    public function store(Request $request){

    $validator = Validator::make($request->all(), [ 
        'test_id'=>'int',
        ]);
    if($validator->fails()){
        return response()->json(['error'=>$validator->errors()], 401);
    
    }


    //add logic
    //check if dose not have another session
    //points
    //can't test your self
    $oldTests = TestSession::where('going',true)->where('user_id',Auth::user('api')->id)->update(['going'=>false]);
    
    $test = Test::find($request->post('test_id'));
    
    if($test){

  
        DB::transaction(function () use ($test) {
            $start_at = Carbon::now();
            $ends_at =  Carbon::now();
            $ends_at->addSeconds($test->questions()->count()*$test->second_per_question);
             $session  = TestSession::create([
                "test_id"=>$test->id,
                "start_at"=>$start_at,
                'user_id'=>Auth::user('api')->id,
                "end_at"=>$ends_at,
                "going"=>true,
              ]);
           $this->createSessionQuestions($session);
    });

    return Response('status',200);

    }

    return Response('status',404);

    }


    private function createSessionQuestions($session){

        foreach($session->test->questions as $question){
            $sessionQuestion = SessionQuestion::create([
                "question_id"=>$question->id,
                "session_id"=>$session->id
            ]);

        }

    }

    private function getCurrentSession(){

        $testSession = TestSession::where('user_id',Auth::user('api')->id)
        ->with('sessionQuestions.question.answers')
        ->with("test.category")
        ->where("end_at",'>',Carbon::now())
        ->where("going",true)
        ->limit(1)->get()->last();
        return $testSession;
    }


    }




