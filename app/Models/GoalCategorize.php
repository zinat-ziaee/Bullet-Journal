<?php

namespace App\Models;

use App\Models\Goal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoalCategorize extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable
     * @var array
     */
    protected $table = 'goal_categorizes';
    protected $guarded = ['id'];

    public function goals()
    {
        return $this->hasmany(Goal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
