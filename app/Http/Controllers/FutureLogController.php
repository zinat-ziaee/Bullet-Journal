<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Collection;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Illuminate\Routing\Route;
use Yajra\DataTables\DataTables;
use Morilog\Jalali\CalendarUtils;
use Illuminate\Support\Facades\Config;

class FutureLogController extends Controller
{
  public function index(Request $request)
  {
    $current_collection_name = Collection::getNameCollection(request()->route()->getName());

    $current_collection = Collection::where('user_id', auth()->user()->id)->where(function($query)use($current_collection_name){
      $query->where('name',$current_collection_name);
    })->first();
    
    // merge collect info
    $info = Collection::where([
      ['user_id', auth()->user()->id],
      ['id', $current_collection->id]
    ])->with([
      'events' => function ($query) {
        $query->pluck('title');
      } ,
      'notes' => function ($query) {
        $query->pluck('title','description');
      },
      'tasks' => function($query){
        $query->pluck('title');
      }
    ])->get();


    $data = Event::get(['id', 'title', 'start', 'end']);

    return view('future_logs.index', compact('data','info'));
  }
}
