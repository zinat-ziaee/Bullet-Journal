<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Note;
use App\Models\Task;
use Carbon\Carbon;

class DashboardService
{
    public function getData($collectionId): array
    {
        $today = Carbon::today();

        $tasks = Task::where('collection_id', $collectionId)
            ->whereDate('log_date', $today)
            ->get();

        $notes = Note::where('collection_id', $collectionId)
            ->whereDate('log_date', $today)
            ->count();

        $events = Event::where('collection_id', $collectionId)
            ->whereDate('start', $today)
            ->count();

        return [
            'tasks' => $tasks,
            'notesCount' => $notes,
            'eventsCount' => $events,
            'completedTasks' => $tasks
                ->where('completed', true)
                ->count(),
        ];
    }
}