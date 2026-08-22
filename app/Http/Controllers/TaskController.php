<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $task = Task::updateOrCreate(
            [
                'id' => $request->task_id
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
            ]
        );

        return response()->json([
            'task' => $task
        ]);
    }

    public function destroy($taskId){
      $task = Task::find($taskId);
      if (!$task) {
          return response()->json([
              'response' => 'task not found',
              'task_id' => $taskId
          ], 404);
      }

      $task->delete();

      return response()->json([
          'response' => 'Record deleted successfully!'
      ]);
    }
}
