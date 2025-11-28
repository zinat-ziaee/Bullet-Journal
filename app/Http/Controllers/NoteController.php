<?php

namespace App\Http\Controllers;

use App\Models\Note;
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
        'description' => $request->description
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
