<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\TestSessionController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\RateTestController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

 

// Route::get('/user',[UserController::class,'index']);
Route::get('/profile/{user_id}',[UserController::class,'show']);
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
Route::get('/result/{session_id}',[TestSessionController::class,'getTestSessionResult']);


Route::group(['prefix'=>"/tests"],function(){

    Route::group(['middleware'=>'auth:api'],function(){
        Route::post('/',[TestController::class,'store']);
        Route::get('/getDraftTests',[TestController::class,'getDraftTests']);
        Route::get('/getDraftTestsById/{test_id}',[TestController::class,'getDraftTestsById']);
        Route::patch('/publish/{test_id}',[TestController::class,'publishTest']);
        Route::delete('/deleteDraftTest/{test_id}',[TestController::class,'deleteDraftTest']);
    });

    Route::get('',[TestController::class,'index']);
    Route::get('/bestfive',[TestController::class,'getBestFive']);
    Route::get('/{test_id}',[TestController::class,'show']);
    

});






Route::group(['prefix'=>"/testSessions",'middleware'=>'auth:api'],function(){
    Route::get('',[TestSessionController::class,'show']);
    Route::post('/',[TestSessionController::class,'store']);
    Route::post('/answerQuestion',[TestSessionController::class,'answerQuestion']);
});


Route::group(['prefix'=>"/rate",'middleware'=>'auth:api'],function(){
    Route::post('/',[RateTestController::class,'store']);
});



Route::group(['prefix'=>"/questions",'middleware'=>'auth:api'],function(){
    Route::post('/',[QuestionController::class,'store']);
    Route::delete('/delete/{question_id}',[QuestionController::class,'deleteQuestion']);
 
});


Route::group(['prefix'=>"/comments",'middleware'=>'auth:api'],function(){
    Route::post('/',[CommentController::class,'store']);
 
});
 
 
Route::group(['prefix'=>"/categories"],function(){
    Route::get('/',[CategoryController::class,'index']);

});

Route::group(['prefix'=>"/levels"],function(){
    Route::get('/',[LevelController::class,'index']);

});
 