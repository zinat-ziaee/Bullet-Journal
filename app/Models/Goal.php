<?php

namespace App\Models;

use App\Models\GoalCategorize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Goal extends Model
{
  use HasFactory;

  protected $table = 'goals';
  protected  $primaryKey = 'id';
  protected $fillable = [
    'short_term_goals',
    'medium_term_goals',
    'long_term_goals',
    'goal_categorizes_id',
    'user_id',
];


  public function goalCat()
  {
    return $this->belongsTo(GoalCategorize::class, 'goal_categorizes_id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}
