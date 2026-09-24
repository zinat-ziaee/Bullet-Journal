<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function create()
    {
        return view('collections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $collection = Collection::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'is_fixed' => false,
        ]);

        return redirect()
            ->route('collections.show', $collection)
            ->with('success', 'مجموعه با موفقیت ایجاد شد.');
    }

    public function show(Collection $collection)
    {
        abort_unless(
            $collection->user_id === auth()->id(),
            403
        );

        $tasks = $collection->tasks()->latest()->get();
        $events = $collection->events()->latest()->get();
        $notes = $collection->notes()->latest()->get();

        return view('collections.show', compact(
            'collection',
            'tasks',
            'events',
            'notes'
        ));
    }

    public function destroy(Collection $collection)
    {
        abort_unless(
            $collection->user_id === auth()->id(),
            403
        );

        $collection->delete();

        return redirect()
            ->route('home')
            ->with('success', 'مجموعه حذف شد.');
    }
}