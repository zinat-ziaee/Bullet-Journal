@extends('layouts.master')

@section('content')

<x-modal.info-modal id="infoModal" />

<div class="month-log">

    {{-- Header --}}
    <div class="month-log-header">

        <a
            class="month-nav-btn"
            href="{{ route('month_logs', [
                'year' => $calendar->previous()->getYear(),
                'month' => $calendar->previous()->getMonth()
            ]) }}"
        >
            ‹
        </a>

        <div class="month-title">
            <h2>{{ fa($calendar->title()) }}</h2>
        </div>

        <a
            class="month-nav-btn"
            href="{{ route('month_logs', [
                'year' => $calendar->next()->getYear(),
                'month' => $calendar->next()->getMonth()
            ]) }}"
        >
            ›
        </a>

    </div>


    {{-- Main --}}
    <div class="month-log-layout sidebar-closed">

        {{-- Days --}}
        <section class="month-days-card">

            <div class="section-header month-days-header">
                
                <button
                    type="button"
                    class="month-sidebar-toggle"
                    id="openMonthSidebar"
                >
                    🎯 اهداف و وظایف
                </button>

            </div>


            {{-- Week days --}}
            <div class="week-days">

                <div>شنبه</div>
                <div>یکشنبه</div>
                <div>دوشنبه</div>
                <div>سه‌شنبه</div>
                <div>چهارشنبه</div>
                <div>پنجشنبه</div>
                <div>جمعه</div>

            </div>


            {{-- Month days --}}
            <div class="month-days">

                @for($i = 0; $i < $calendar->emptyDays(); $i++)
                    <div class="empty-day"></div>
                @endfor


                @foreach($days as $item)

                    @php
                    $allItems = collect()
                        ->merge(
                            $item['tasks']->map(function ($task) {
                                $task->item_type = 'task';
                                return $task;
                            })
                        )
                        ->merge(
                            $item['events']->map(function ($event) {
                                $event->item_type = 'event';
                                return $event;
                            })
                        )
                        ->merge(
                            $item['notes']->map(function ($note) {
                                $note->item_type = 'note';
                                return $note;
                            })
                        );

                    $visibleItems = $allItems->take(3);

                    $remainingItems =
                        $allItems->count() -
                        $visibleItems->count();
                    @endphp

                    <button
                        type="button"
                        class="month-day {{ $item['is_today'] ? 'today' : '' }}"
                        data-day="{{ $item['day'] }}"
                        data-date="{{ $item['date'] }}"
                        data-collection-id="{{ $collectionId }}"
                    >

                        <span class="day-number">
                            {{ fa($item['day']) }}
                        </span>


                        @if($visibleItems->count())

                            <span class="day-items">

                                @foreach($visibleItems as $entry)

                                    @if($entry->item_type === 'task')
                                        <span class="day-item-title">
                                            • {{ $entry->title }}
                                        </span>

                                    @elseif($entry->item_type === 'event')
                                        <span class="day-item-title">
                                            ○ {{ $entry->title }}
                                        </span>

                                    @elseif($entry->item_type === 'note')
                                        <span class="day-item-title">
                                            - {{ $entry->title }}
                                        </span>

                                    @endif

                                @endforeach


                                @if($remainingItems > 0)

                                    <span class="day-more">
                                        + {{ fa($remainingItems) }} موارد دیگر...
                                    </span>

                                @endif

                            </span>

                        @endif

                    </button>

                @endforeach

            </div>

        </section>


        {{-- Goals Sidebar --}}
        <aside
            class="month-sidebar"
            id="monthSidebar"
        >

            <div class="month-side-card">

                <div class="section-header month-sidebar-header">

                    <h3>اهداف و وظایف ماه</h3>

                    <button
                        type="button"
                        class="month-sidebar-close"
                        id="closeMonthSidebar"
                    >
                        ×
                    </button>

                </div>


                <div class="monthly-items">

                    <div class="monthly-item">
                        <span>□</span>
                        <span>مطالعه کتاب</span>
                    </div>

                    <div class="monthly-item">
                        <span>□</span>
                        <span>تکمیل پروژه</span>
                    </div>

                </div>


                <button
                    type="button"
                    class="add-monthly-item"
                >
                    + افزودن
                </button>

            </div>

        </aside>

    </div>


    {{-- Monthly Review --}}
    <section class="monthly-review">

        <div class="section-header">
            <h3>ارزیابی ماهانه</h3>
        </div>

        <textarea
            class="monthly-review-input"
            placeholder="این ماه چگونه گذشت؟ چه چیزهایی خوب بود؟ چه چیزهایی نیاز به تغییر دارد؟"
        ></textarea>

    </section>

</div>

@endsection


@push('scripts')

<script src="{{ asset('js/month-log.js') }}"></script>

<script>

    window.monthLogDayDataUrl =
        "{{ route('month_logs.day_data') }}";

    window.monthLogYear =
        "{{ request('year') }}";

    window.monthLogMonth =
        "{{ request('month') }}";

</script>

@endpush