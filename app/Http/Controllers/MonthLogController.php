<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Services\CalendarService;
use App\Services\MonthLogService;
use Illuminate\Http\Request;


class MonthLogController extends Controller
{
    public function index(Request $request,MonthLogService $monthLogService)
    {
        $calendar = new CalendarService(
            $request->year,
            $request->month
        );

        /*
        | فعلاً collection را همان روشی که
        | در پروژه خودت برای Month Log پیدا می‌کنی قرار بده.
        */
        $current_collection_name = Collection::getNameCollection($request->route()->getName());

        $collectionId = Collection::where('user_id', auth()->user()->id)
            ->where('name', $current_collection_name)
            ->value('id');

        $days = $monthLogService->getMonthData(
            $calendar,
            $collectionId
        );

        return view('month_logs.index', compact(
            'calendar',
            'days',
            'collectionId'
        ));
    }
    public function dayData(Request $request, MonthLogService $monthLogService)
    {
        $calendar = new CalendarService(
            $request->year,
            $request->month
        );

        $days = $monthLogService->getMonthData(
            $calendar,
            $request->collection_id
        );

        $day = collect($days)->firstWhere(
            'date',
            $request->date
        );

        if (!$day) {
            return response()->json([
                'message' => 'اطلاعات این روز پیدا نشد.'
            ], 404);
        }

        return response()->json([
            'date' => $day['date'],
            'day' => $day['day'],
            'tasks' => $day['tasks']->values(),
            'notes' => $day['notes']->values(),
            'events' => $day['events']->values(),
        ]);
    }
}