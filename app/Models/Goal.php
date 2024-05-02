<?php

namespace App\Models;

use App\Models\GoalCategorize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Goal extends Model
{
  use HasFactory;

  protected $table = 'goals';
  protected $guarded = ['id'];
  protected  $primaryKey = 'id';


  public function goalCat()
  {
    return $this->belongsTo(GoalCategorize::class, 'goal_categorizes_id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}
