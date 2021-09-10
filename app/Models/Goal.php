<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $table = 'Goals';
    protected $fillable = [
        'short-term-goals',
        'medium-term-goals',
        'long-term-goals',
        'goal_categorizes_id',
        'user_id',
    ];

    public function GoalCat(){
        return $this->belongsTo(GoalCategorizes::class,'goal_categorizes_id');
    }
}
