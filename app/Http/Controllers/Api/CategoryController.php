<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Category;
class CategoryController extends Controller
{
    //
        public function index(){
            return response()->json(Category::get());
        }




    }




