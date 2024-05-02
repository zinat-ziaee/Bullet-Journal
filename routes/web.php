<?php
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Collection;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use function PHPSTORM_META\exitPoint;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
// use Illuminate\Support\Facades\Request;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FutureLogController;
use App\Http\Controllers\GoalCategorizeController;

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
  $covertMiladiToShansi = Carbon::shamsi($request->date);
  return response()->json(['covertMiladiToShansi'=>$covertMiladiToShansi]);
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

  Route::resource('notes',NoteController::class,['only'=>['index','store','destroy']]);
  Route::resource('events',EventController::class,['only'=>['index','store','destroy']]);
  Route::resource('tasks',TaskController::class,['only'=>['index','store','destroy']]);
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
