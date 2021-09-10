<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoalCategorize;
use App\Http\Requests\StoreGoalCategorizeRequest;
use App\Http\Requests\UpdateGoalCategorizeRequest;

class GoalCategorizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goal_categorizes = GoalCategorize::all();
        return view('goal_categorizes.index',["goal_categorizes"=>$goal_categorizes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('goal_categorizes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGoalCategorizeRequest $request)
    {
        GoalCategorize::create([
            'title' => $request->title,
            'user_id' => auth()->user()->id
        ]);
        return redirect()->route('goal_categorizes.index')->with('success','با موفقیت درج شد');
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
        $goalCat = GoalCategorize::find($id);
        return view('goal_categorizes.edit',['goalCat' => $goalCat]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGoalCategorizeRequest $request, $id)
    {
        $goalCat = GoalCategorize::whereId($id)->update(['title'=>$request->title]);
        return redirect()->route('goal_categorizes.index')->with('success','باموفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        GoalCategorize::find($id)->delete();
        return redirect()->route('goal_categorizes.index')->with('success','با موفقیت حذف شد');
    }
}
