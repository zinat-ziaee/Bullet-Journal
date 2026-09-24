@extends('layouts.master')

@section('content')

<div class="dashboard">

    <div class="dashboard-header">

        <h1>امروز</h1>

        <a
            href="{{ route('day_log') }}"
            class="btn btn-primary">
            رفتن به روزنگار
        </a>

    </div>


    <div class="dashboard-stats">

        <div class="dashboard-card">
            <span>تسک‌ها</span>
            <strong>{{ $tasks->count() }}</strong>
        </div>

        <div class="dashboard-card">
            <span>انجام‌شده</span>
            <strong>{{ $completedTasks }}</strong>
        </div>

        <div class="dashboard-card">
            <span>رویدادها</span>
            <strong>{{ $eventsCount }}</strong>
        </div>

        <div class="dashboard-card">
            <span>یادداشت‌ها</span>
            <strong>{{ $notesCount }}</strong>
        </div>

    </div>


    <div class="dashboard-section">

        <h3>کارهای امروز</h3>

        @forelse($tasks as $task)

            <div class="dashboard-task">

                <span>
                    {{ $task->completed ? '✓' : '□' }}
                </span>

                <span>
                    {{ $task->title }}
                </span>

            </div>

        @empty

            <p>
                امروز کاری ثبت نشده.
            </p>

        @endforelse

    </div>

</div>

@endsection