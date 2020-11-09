<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Comment extends Model
{
    use HasFactory;
    protected $fillable = ["user_id",'test_id','comment'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
