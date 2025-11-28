<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request){
     $task = Task::updateOrCreate(
      [
        'id' => $request->task_id
      ],
      [
        'collection_id' => $request->collection_id,
        'title' => $request->title,
        'description' => $request->description
      ]);
      return response()->json(['task'=>$task]);
    }

    public function destroy($taskId){
      Task::find($taskId)->delete();
      return response()->json(['success'=>'Record deleted successfully']);
    }
}
