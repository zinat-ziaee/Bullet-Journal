<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NoteController extends Controller
{
  public function index(){
    
  }

  public function store(Request $request)
  {
    $note=Note::updateOrCreate(
      [
        'id' => $request->note_id
      ],
      [
        'collection_id' => $request->collection_id,
        'title' => $request->title,
        'description' => $request->description,
        'log_date' => $this->isGregorian($request->log_date)
                ? $request->log_date
                : Carbon::miladi($request->log_date),
      ]);

    return response()->json(['note' => $note]);
  }

  public function destroy($noteId){
    Note::find($noteId)->delete();
    return response()->json([
      'success' => 'Record deleted successfully!'
    ]);
  }
}
