<?php
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DayLogController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FutureLogController;
use App\Http\Controllers\GoalCategorizeController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\MonthLogController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TaskController;
use App\Models\Collection;
use Carbon\Carbon;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    
Route::post('/convert_to_shamsi',function(Request $request){
  $covertMiladiToShamsi = Carbon::shamsi($request->date);
  return response()->json(['covertMiladiToShansi'=>$covertMiladiToShamsi]);
})->middleware('auth')->name('convert_to_shamsi');


route::group(['middleware' => 'auth'], function () {
  Route::resource('goal_categorizes', GoalCategorizeController::class);

  Route::resource('goals', GoalController::class);


  Route::prefix('future_log')->group(function () {
    Route::get('/', [FutureLogController::class, 'index'])->name('future_log');
  });

  Route::prefix('month_logs')->group(function () {
    Route::get('/', [MonthLogController::class, 'index'])->name('month_logs');
    Route::get('/day-data',[MonthLogController::class, 'dayData'])->name('month_logs.day_data');
  });


  Route::prefix('dashboard')->group(function () {

      Route::get('/', [DashboardController::class, 'index'])
          ->name('dashboard');
  
  });
    
  Route::prefix('day-log')->group(function () {

    Route::get('/', [DayLogController::class, 'index'])
        ->name('day_log');

    Route::get('/day-data', [DayLogController::class, 'dayData'])
        ->name('day_log.day_data');

  });
  
  Route::resource('collections', CollectionController::class)
    ->only(['create', 'store', 'show', 'destroy']);

  Route::resource('notes',NoteController::class,['only'=>['index','store','destroy']]);
  Route::resource('events',EventController::class,['only'=>['index','store','destroy']]);
  Route::resource('tasks',TaskController::class,['only'=>['index','store','destroy']]);
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
