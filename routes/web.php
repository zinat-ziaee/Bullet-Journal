<?php
use App\Http\Controllers\EventController;
use App\Http\Controllers\FutureLogController;
use App\Http\Controllers\GoalCategorizeController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\MonthLogController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TaskController;
use App\Models\Collection;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Request;
use function PHPSTORM_META\exitPoint;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
  
  // dd(Collection::getItems());
  // dd(auth()->user()->collections());
  return view('bujo');
})->middleware('auth')->name('home');

Route::post('/convert_to_shamsi',function(Request $request){
  $covertMiladiToShamsi = Carbon::shamsi($request->date);
  return response()->json(['covertMiladiToShansi'=>$covertMiladiToShamsi]);
})->middleware('auth')->name('convert_to_shamsi');

// Route::resource('goal_categorizes', GoalCategorizeController::class, [
//   'names' => [
//     'create' => 'goal_categorizes.create',
//     'store' => 'goal_categorizes.store',
//     'edit' => 'goal_categorizes.edit',
//     'update' => 'goal_categorizes.update',
//   ]
// ]);


route::group(['middleware' => 'auth'], function () {
  Route::resource('goal_categorizes', GoalCategorizeController::class);
  Route::resource('goals', GoalController::class);

  Route::prefix('future_log')->group(function () {
    Route::get('/', [FutureLogController::class, 'index'])->name('future_log');
    // Route::post('/info_note/store',[FutureLogController::class, 'storeNote'])->name('info_note');
    // Route::post('/info_event/store', [FutureLogController::class, 'storeEvent'])->name('info_event');
  });

  Route::prefix('month_logs')->group(function () {
    Route::get('/', [MonthLogController::class, 'index'])->name('month_logs');
  });

  Route::resource('notes',NoteController::class,['only'=>['index','store','destroy']]);
  Route::resource('events',EventController::class,['only'=>['index','store','destroy']]);
  Route::resource('tasks',TaskController::class,['only'=>['index','store','destroy']]);
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
