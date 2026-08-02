<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Collection;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Yajra\DataTables\DataTables;

class FutureLogController extends Controller
{
    public function index(Request $request)
    {
        $current_collection_name = Collection::getNameCollection($request->route()->getName());

        // پیدا کردن همه‌ی مجموعه‌های کاربر که نامشون مطابق اینده نگار هست
        $current_collection = Collection::where('user_id', auth()->user()->id)
            ->where('name', $current_collection_name)
            ->firstOrFail();

        // واکشی اطلاعات مربوط به هر مجموعه با روابطش
        $info = $current_collection->load([
                'events' => function($query) {
                    $query->select('id', 'title', 'start', 'end', 'collection_id');
                },
                'notes' => function ($query) {
                    $query->select('id', 'title', 'description', 'collection_id');
                },
                'tasks' => function ($query) {
                    $query->select('id', 'title', 'description', 'collection_id');
                }
            ])->get();

        // فقط برای کلندر (همه ایونت‌ها)
        $data = $current_collection->events()
        ->select('id', 'title', 'start', 'end')
        ->get();

        return view('future_logs.index', compact('data', 'info'));
    }
}
