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
        'log_date' => empty($request->log_date)
                    ? null
                    : (
                        Carbon::hasFormat($request->log_date, 'Y-m-d')
                            ? $request->log_date
                            : Carbon::miladi($request->log_date)
                    ),
      ]);

    return response()->json(['note' => $note]);
  }

  public function destroy($noteId)
  {
      $note = Note::find($noteId);

      if (!$note) {
          return response()->json([
              'response' => 'Note not found',
              'note_id' => $noteId
          ], 404);
      }

      $note->delete();

      return response()->json([
          'response' => 'Record deleted successfully!'
      ]);
  }
}
