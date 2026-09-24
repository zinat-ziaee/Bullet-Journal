<?php

namespace App\Services;

use App\Models\Collection;
use App\Models\Event;
use App\Models\Note;
use App\Models\Task;
use Carbon\Carbon;

class DayLogService
{
    public function getDayData($collectionId, Carbon $date)
    {
        $date = $date->toDateString();

        $tasks = Task::query()
            ->where('collection_id', $collectionId)
            ->whereDate('log_date', $date)
            ->get();

        $notes = Note::query()
            ->where('collection_id', $collectionId)
            ->whereDate('log_date', $date)
            ->get();

        $events = Event::query()
            ->where('collection_id', $collectionId)
            ->whereDate('start', '<=', $date)
            ->whereDate('end', '>=', $date)
            ->get();

        return compact(
            'tasks',
            'notes',
            'events'
        );
    }
}