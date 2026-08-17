<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
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
        'description' => $request->description,
        'log_date' => $this->isGregorian($request->log_date)
                ? $request->log_date
                : Carbon::miladi($request->log_date),
      ]);
      return response()->json(['task'=>$task]);
    }

    public function destroy($taskId){
      Task::find($taskId)->delete();
      return response()->json(['success'=>'Record deleted successfully']);
    }
}
