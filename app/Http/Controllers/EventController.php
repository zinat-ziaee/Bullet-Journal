<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Morilog\Jalali\CalendarUtils;

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
        'start' => $this->isGregorian($request->start)?($request->start):Carbon::miladi($request->start),
        'end' => $this->isGregorian($request->end)?($request->end):Carbon::miladi($request->end),
        'collection_id' => $request->col_id 
      ]
    );
    
    return response()->json(['events' => $events]);
  }

  public function destroy($eventId){
    Event::find($eventId)->delete();
    return response()->json([
      'response' => 'Record deleted successfully!'
    ]);
  }

  private function isGregorian($date){
    return Carbon::hasFormat($date,'Y-m-d');
  }
}
