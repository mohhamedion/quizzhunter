<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Hash;
use App\Models\User;
use App\Models\Comment;
use Auth;
class CommentController extends Controller
{
    //


        public function store(Request $request){
            $validator = Validator::make($request->all(), [ 
                'comment'=>'required|max:500',
                'test_id'=>'required|int|max:255',
             ]);
            if($validator->fails()){
                return response()->json(['error'=>$validator->errors()], 401);  
            }

            $comment = $request->post();
            $comment['user_id'] = Auth::user('api')->id;
            $comment= Comment::create($comment);
            $comment['user']=$request->user();
            return response()->json($comment);

        }




    }




