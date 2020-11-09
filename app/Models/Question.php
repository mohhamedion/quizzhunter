<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Answer;
use App\Models\Test;
class Question extends Model
{
    use HasFactory;
    protected $fillable = ['question','user_id','test_id','code'];


    public function answers(){
        return $this->hasMany(Answer::class,'question_id');
    }
    public function test(){
        return $this->belongsTo(Test::class,'test_id');
    }
}
