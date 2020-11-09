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
use App\Models\Answer;
class QuestionController extends Controller
{
    //


   

    
     
    
    public function store(Request $request){

        $validator = Validator::make($request->all(), [ 
            'question'=>'required|max:255',
            'test_id'=>'required|int|max:255',
            'answers'=>'required|array|min:2'
         ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);
        
        }

        $test = Test::find($request->test_id)->where('user_id',Auth::user('api')->id);
        if(!$test){
            return response()->json(['error'=>'error'], 401);
 
        }
        $question = $request->post();
        $question['user_id'] = Auth::user('api')->id;
        $question = Question::create($question);
        $question->answers()->createMany($request->answers);
        $lastquestion =  Question::where('id',$question->id)->with('answers')->get();
    
        return response()->json($lastquestion);

    }


    public function deleteQuestion($question_id){

     $question=   Question::where('id',$question_id)->get()->last();
     if(!$question){
         return response(500);
     }

     $test = $question->test;

     if($test->user_id==Auth::user('api')->id&&$test->published==0){
        $this->deleteAnswersByQuestionId($question->id);
        $question->delete();
        return response(200);
     }
     return response('error');

    }



    private function deleteAnswersByQuestionId($question_id){
          Answer::where('question_id',$question_id)->delete();
    }

    }




