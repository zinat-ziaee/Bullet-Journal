<?php

namespace App\Models;

use App\Models\NoteCategorize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
  use HasFactory;

  protected $table = 'notes';
  protected $guarded = ['id'];

  public function collection()
  {
    return $this->belongsTo(Collection::class, 'collection_id');
  }
}
