<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Hash;
use App\Models\User;
use Auth;
use App\Models\Test;
use App\Models\TestRate;
class RateTestController extends Controller
{
    public function store(Request $request){

        $validator = Validator::make($request->all(), [ 
            'test_id'=>'required|int|max:255',
            'rate'=>'required|int|min:0|max:5'
         ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);
        
        }
        
        $existRate = TestRate::where('user_id',Auth::user('api')->id)->where("test_id",$request->test_id)->count();

        if($existRate>0){
            return response()->json(['error'=>true],500);
        }

        $rate = $request->post();
        $rate['user_id']= Auth::user('api')->id;
        $rate = TestRate::create($rate);
 
        if(!$rate){
            return response()->json(['error'=>true],500);
        }
      return response()->json(200);


    }




    }




