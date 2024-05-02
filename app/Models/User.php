<?php

namespace App\Models;

use App\Models\Event;
use App\Models\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function goals()
  {
    return $this->hasmany(Goal::class);
  }

  public function goalCat()
  {
    return $this->hasmany(GoalCategorize::class);
  }

  public function collections()
  {
    return $this->hasMany(Collection::class);
  }

  public function events()
  {
    return $this->hasManyThrough(
      Event::class,
      Collection::class,
      'user_id',
      'collection_id',
      'id',
      'id'
    );
  }
}
