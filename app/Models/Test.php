<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Question;
use App\Models\Comment;
use App\Models\TestRate;
use App\Models\TestSession;
class Test extends Model
{
    use HasFactory;
    protected $fillable = ['level','description','second_per_question','category','user_id'];

    public function category(){
        return $this->belongsTo(Category::class,'category');
    }
    public function level(){
        return $this->belongsTo(Level::class,'level');
    }
    public function questions(){
        return $this->hasMany(Question::class,'test_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'test_id');
    }

    public function rates(){
        return $this->hasMany(TestRate::class,'test_id');
    }

    public function sessions(){
        return $this->hasMany(TestSession::class,'test_id');
    }
    public function user(){
        return $this->belongsTo(user::class,'user_id');
    }
}
