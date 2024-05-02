<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
  use HasFactory;
  protected $table = 'collections';
  protected $guarded = ['id'];

  // const Event = 1;
  // const Note = 2;
  // // const Task = 3;
  // // const Evaluation = 4;

  // public static function getInfoTypeList()
  // {
  //   return [
  //     self::Event => 'رویداد',
  //     self::Note => 'یادداشت',
  //     // self::Task => 'وظیفه',
  //     // self::Evaluation => 'ارزیابی'
  //   ];
  // }

  // public function getInfoTypeNameAttribute()
  // {
  //   return (isset(self::getInfoTypeList()[$this->type]) ? self::getInfoTypeList()[$this->type] : 'نامشخص');
  // }

  protected static function getItems(){
    return self::where('user_id', auth()->user()->id)->get();
  }

  protected static function getNameCollection($route_name)
  {
    $fixed_collections = collect(Config::get('settings.fixed_collections'));
    return $fixed_collections->where('route_name','=', $route_name)->pluck('name')->first();
  }

  protected static function getRouteName($name)
  {
    $fixed_collections = collect(Config::get('settings.fixed_collections'));
    return $fixed_collections->where('name','=', $name)->pluck('route_name')->first();

    // $collection = self::all();
    // $fixed_collections = collect(Config::get('app.settings.fixed_collections'))->where(function ($query) use ($collection) {
    //   return $query['name'] == $collection['name'];
    // })->first();
  }

  public function getTitleAttribute($key)
  {
  }

  public function notes()
  {
    return $this->hasMany(Note::class);
  }

  public function events()
  {
    return $this->hasMany(Event::class);
  }

  public function tasks(){
    return $this->hasMany(Task::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}
