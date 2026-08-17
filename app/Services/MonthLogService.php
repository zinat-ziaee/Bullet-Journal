<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Task;
use App\Models\Note;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class MonthLogService
{
    /**
     * آماده‌سازی اطلاعات آیتم‌های یک ماه
     */
    public function getMonthData(CalendarService $calendar, $collectionId)
    {
        /*
        |--------------------------------------------------------------------------
        | محدوده میلادی ماه
        |--------------------------------------------------------------------------
        */

        $monthStart = $calendar->current()
            ->toCarbon()
            ->startOfDay();

        $monthEnd = $calendar->current()
            ->toCarbon()
            ->addMonth()
            ->subDay()
            ->endOfDay();


        /*
        |--------------------------------------------------------------------------
        | Events
        |--------------------------------------------------------------------------
        |
        | Eventهایی که با بازه این ماه هم‌پوشانی دارند.
        |
        */

        $events = Event::query()
            ->where('collection_id', $collectionId)
            ->where('start', '<=', $monthEnd)
            ->where('end', '>=', $monthStart)
            ->select([
                'id',
                'title',
                'start',
                'end',
                'collection_id',
            ])
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Tasks
        |--------------------------------------------------------------------------
        */

        $tasks = Task::query()
            ->where('collection_id', $collectionId)
            ->whereBetween('log_date', [
                $monthStart->toDateString(),
                $monthEnd->toDateString(),
            ])
            ->select([
                'id',
                'title',
                'description',
                'log_date',
                'collection_id',
            ])
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Notes
        |--------------------------------------------------------------------------
        */

        $notes = Note::query()
            ->where('collection_id', $collectionId)
            ->whereBetween('log_date', [
                $monthStart->toDateString(),
                $monthEnd->toDateString(),
            ])
            ->select([
                'id',
                'title',
                'description',
                'log_date',
                'collection_id',
            ])
            ->get();


        /*
        |--------------------------------------------------------------------------
        | گروه‌بندی Task و Note بر اساس تاریخ
        |--------------------------------------------------------------------------
        */

        $tasksByDate = $tasks->groupBy(function ($task) {
            return Carbon::parse($task->log_date)->toDateString();
        });

        $notesByDate = $notes->groupBy(function ($note) {
            return Carbon::parse($note->log_date)->toDateString();
        });


        /*
        |--------------------------------------------------------------------------
        | آماده‌سازی روزهای ماه
        |--------------------------------------------------------------------------
        */

        $days = [];

        foreach ($calendar->days() as $day) {

            $date = $day['date']
                ->toCarbon()
                ->startOfDay();

            $dateKey = $date->toDateString();


            $days[$day['day']] = [
                'day' => $day['day'],

                'date' => $dateKey,

                'jalali_date' => $day['date'],

                'is_today' => $day['is_today'],

                'events' => collect(),
                'tasks' => $tasksByDate->get($dateKey, collect()),
                'notes' => $notesByDate->get($dateKey, collect()),

                'event_count' => 0,
                'task_count' => $tasksByDate->get($dateKey, collect())->count(),
                'note_count' => $notesByDate->get($dateKey, collect())->count(),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | قرار دادن Event در روزهای مربوطه
        |--------------------------------------------------------------------------
        |
        | Event می‌تواند چندروزه باشد.
        |
        */

        foreach ($events as $event) {

            $eventStart = Carbon::parse($event->start)
                ->startOfDay();

            $eventEnd = Carbon::parse($event->end)
                ->startOfDay();


            /*
            | فقط قسمت مشترک Event با این ماه
            */

            if ($eventStart->lt($monthStart)) {
                $eventStart = $monthStart->copy()->startOfDay();
            }

            if ($eventEnd->gt($monthEnd)) {
                $eventEnd = $monthEnd->copy()->startOfDay();
            }


            /*
            | تمام روزهایی که Event پوشش می‌دهد
            */

            foreach (CarbonPeriod::create(
                $eventStart,
                $eventEnd
            ) as $date) {

                $dateKey = $date->toDateString();


                foreach ($days as $dayNumber => &$day) {

                    if ($day['date'] === $dateKey) {

                        $day['events']->push($event);

                        $day['event_count']++;
                    }
                }

                unset($day);
            }
        }

        return $days;
    }
}