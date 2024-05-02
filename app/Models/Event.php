<?php

namespace App\Models;

use Morilog\Jalali\CalendarUtils;
use Illuminate\Database\Eloquent\Model;
use App\Traits\PersianDateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
  use HasFactory;
  protected $dates = ['start', 'end'];
  protected $fillable = ['name', 'start', 'end' ,'collection_id'];

  public function collection(){
    return $this->belongsTo(Collection::class, 'collection_id');
  }
}
