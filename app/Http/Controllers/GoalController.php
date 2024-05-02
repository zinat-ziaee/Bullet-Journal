<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use App\Models\GoalCategorize;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreGoalRequest;
use App\Http\Requests\UpdateGoalRequest;

class GoalController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $goals = Goal::all();
    return view('goals.index', ['goals' => $goals]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $user = Auth()->user();
    $goalCategorizes = GoalCategorize::where('user_id', $user->id)->get();
    return view('goals.create', compact('goalCategorizes'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreGoalRequest $request)
  {
    $userId = Auth::id();
    $goal = Goal::create(array_merge($request->all(), ['user_id' => $userId]));
    return redirect()->route('goals.index')->with('success', 'با موفقیت ثبت شد');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $userId = Auth::id();
    $goal = Goal::findOrFail($id);
    $goalCategorizes = GoalCategorize::whereUserId($userId)->pluck('title', 'id')->all();
    return view('goals.edit', compact('id', 'goal', 'goalCategorizes'));
  }

  /**     
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateGoalRequest $request, $id)
  {
    $userId = auth::id();
    $goal = Goal::findOrFail($id);
    $goal->update(array_merge($request->all(), ['user_id' => $userId]));
    return redirect()->route('goals.index')->with('success', 'با موفقیت ویرایش شد');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    goal::findOrFail($id)->delete();
    return redirect()->route('goals.index')->with('success','با موفقیت حذف شد');
  }
}
