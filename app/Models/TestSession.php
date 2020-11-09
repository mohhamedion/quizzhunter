<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Test;
use App\Models\User;
use App\Models\SessionQuestion;
class TestSession extends Model
{
    use HasFactory;
    protected $fillable = ['test_id','start_at','end_at','going','user_id'];

    public function test(){
        return $this->belongsTo(Test::class,'test_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function sessionQuestions(){
        return $this->hasMany(SessionQuestion::class,'session_id');
    }
    
    public function mark(){
        return $this->sessionQuestions()->selectRaw('sum(mark) as totalPoints');
    }
}
