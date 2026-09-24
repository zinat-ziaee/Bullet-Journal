<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Services\DayLogService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DayLogController extends Controller
{
    public function index(
        Request $request,
        DayLogService $dayLogService
    ) {
        $collection = Collection::getFixedByRoute(
            $request->route()->getName()
        );

        abort_unless($collection, 404);

        // اگر تاریخ در URL بود همان را بگیر،
        // در غیر این صورت امروز
        $date = $request->filled('date')
            ? Carbon::parse($request->date)
            : today();

        $data = $dayLogService->getDayData(
            $collection->id,
            $date
        );

        return view('day_logs.index', compact(
            'collection',
            'date',
            'data'
        ));
    }


    public function dayData(
        Request $request,
        DayLogService $dayLogService
    ) {
        $collection = Collection::getFixedByRoute('day_log');

        abort_unless($collection, 404);

        $request->validate([
            'date' => ['required', 'date'],
        ]);

        $date = Carbon::parse($request->date);

        $data = $dayLogService->getDayData(
            $collection->id,
            $date
        );

        return response()->json([
            'date' => $date->toDateString(),

            'tasks' => $data['tasks']->values(),

            'notes' => $data['notes']->values(),

            'events' => $data['events']->values(),
        ]);
    }
}