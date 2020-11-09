<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['answer_id','session_question_id','choosen','session_id'];

}
