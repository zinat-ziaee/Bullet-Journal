<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EventController extends Controller
{
  public function index()
  {
  }

  public function store(Request $request)
  {
    $events = Event::updateOrCreate(
      [
        'id' => $request->event_id
      ],
      [
        'title' => $request->title,
        'start' => Carbon::miladi($request->start),
        'end' => Carbon::miladi($request->end),
        'collection_id' => $request->col_id 
      ]
    );
    
    return response()->json(['events' => $events]);
  }

  public function destroy($eventId){
    Event::find($eventId)->delete();
    return response()->json([
      'success' => 'Record deleted successfully!'
    ]);
  }
}
