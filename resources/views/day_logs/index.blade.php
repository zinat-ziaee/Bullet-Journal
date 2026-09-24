@extends('layouts.master')

@section('content')

<div class="day-log">

    {{-- Header --}}
    <div class="day-log-header">

    <button
        type="button"
        class="day-log-nav"
        id="previousDay"
        title="روز قبل"
        aria-label="روز قبل">
        ‹
    </button>


    <div class="day-log-date">

        <div class="day-log-date-main">
            <span id="dayLogTitle">
                {{ \Carbon\Carbon::shamsi($date) }}
            </span>
        </div>

        <div
            class="day-log-date-weekday"
            id="dayOfWeek">
            {{ $date->translatedFormat('l') }}
        </div>

    </div>


    <button
        type="button"
        class="day-log-nav"
        id="nextDay"
        title="روز بعد"
        aria-label="روز بعد">
        ›
    </button>

    </div>


    {{-- Actions --}}
    <div class="day-log-actions">

        <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#infoModal"
            id="dayLogCreate">

            + بنویس

        </button>

    </div>


    <div class="day-log-stream" id="dayLogStream"></div>

</div>


{{-- Modal --}}
<x-modal.info-modal id="infoModal" />


@endsection


@push('scripts')

<script>
    window.dayLogContext = {
        date: @json($date->toDateString()),
        collectionId: @json($collection->id),
        dayDataUrl: @json(route('day_log.day_data'))
    };
</script>

<script src="{{ asset('js/day-log.js') }}?v={{ filemtime(public_path('js/day-log.js')) }}"></script>

@endpush