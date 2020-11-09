<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\sessionAnswer;
class SessionQuestion extends Model
{
    use HasFactory;
    protected $fillable = ['session_id','question_id'];


    public function question(){
        return $this->belongsTo(Question::class,'question_id');
    }


    public function sessionAnswers(){
        return $this->hasMany(sessionAnswer::class,'session_question_id');
    }
}
