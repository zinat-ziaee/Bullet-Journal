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
}