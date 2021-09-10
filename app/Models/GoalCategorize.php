<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalCategorize extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable
     * @var array
     */
    protected $table = 'goal_categorizes';
    protected $fillable = [
        'title',
        'user_id'
    ];

    public function goals(){
        return $this->hasmany(Goal::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
