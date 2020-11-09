<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Hash;
use App\Models\Level;
class LevelController extends Controller
{
    //
        public function index(){
            return response()->json(Level::get());
        }




    }




