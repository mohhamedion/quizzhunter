<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Test;
use App\Models\User;
class TestRate extends Model
{
    protected $table= 'test_rate';
    use HasFactory;
    protected $fillable = ['rate','test_id','user_id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
 
    public function test(){
        return $this->belongsTo(Test::class,'test_id');
    }

}
