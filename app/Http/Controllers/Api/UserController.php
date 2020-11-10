<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Hash;
use App\Models\User; 
use App\Models\TestSession;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //

        public function register(Request $request){     
            $validator = Validator::make($request->all(), [ 
                    'email' => 'required|email|unique:users', 
                    'firstname' => 'required|max:255', 
                    'lastname' => 'required|max:255', 
                    'password' => 'required|max:255', 
                    'c_password' => 'required|max:255|same:password', 
                 ]);
            if($validator->fails()){
                return response()->json(['error'=>$validator->errors()], 401);
            
            }



            $user['email'] = $request->email;
            $user['firstname'] = $request->firstname;
            $user['lastname'] = $request->lastname;
            $user['password'] = Hash::make($request->password);
            
            $user = User::create($user);
            
            $token = $user->createToken('ProgHunt')->accessToken;

            return response()->json(['token'=>$token,'user'=>$user]);
        }

        public function login(Request $request){     
            $validator = Validator::make($request->all(), [ 
                    'email' => 'required|email', 
                    'password' => 'required|max:255', 
                  ]);
            if($validator->fails()){
                return response()->json(['error'=>$validator->errors()], 401);
            
            }

            $user = User::where('email',$request->email)->first();
            if($user){
                if(Hash::check($request->password, $user->password)){
                    $token=  $user->createToken('ProgHunt')->accessToken;
                    return response()->json(['token'=>$token,'user'=>$user]);
  
                  } 
            }
            
            return response()->json(['error'=>422]);
        }


        public function show($user_id){
            $user = User::where('id',$user_id)
            ->with('tests.category')
            ->with('tests.user')
            ->get()->last();

            $user['test_sessions'] =TestSession::select(DB::Raw("*,  (select sum(mark)  from session_questions where session_questions.session_id=test_sessions.id ) as totalPoints"))
            ->where('user_id',$user_id)
            ->with('test.category')->withCount('sessionQuestions')
            ->get();
            return response()->json($user);


        }
        
    }




