@extends('layouts.master')

@section('content')
<x-modal.info-modal id="infoModal" />

<div class="month-log">

    {{-- Header --}}
    <div class="month-log-header">

        <a class="month-nav-btn"
            href="{{ route('month_logs',[
            'year'=>$calendar->previous()->getYear(),
            'month'=>$calendar->previous()->getMonth()
            ]) }}">
            ‹
        </a>

        <div class="month-title">
            <h2> {{ fa($calendar->title()) }}</h2>
        </div>

        <a class="month-nav-btn"
            href="{{ route('month_logs',[
            'year'=>$calendar->next()->getYear(),
            'month'=>$calendar->next()->getMonth()
            ]) }}">
            ›
        </a>

    </div>


    {{-- Main --}}
    <div class="month-log-layout">
        
        {{-- Monthly tasks --}}
        <aside class="month-sidebar">

            <div class="month-side-card">

                <div class="section-header">
                    <h3>وظایف و اهداف ماه</h3>
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

                <button type="button" class="add-monthly-item">
                    + افزودن
                </button>

            </div>

        </aside>

        {{-- Days --}}
        <section class="month-days-card">

            <div class="section-header">
                <h3>روزهای ماه</h3>
            </div>

            <div class="week-days">
                <div>شنبه</div>
                <div>یکشنبه</div>
                <div>دوشنبه</div>
                <div>سه‌شنبه</div>
                <div>چهارشنبه</div>
                <div>پنجشنبه</div>
                <div>جمعه</div>
            </div>

            <div class="month-days">


                @for($i=0; $i<$calendar->emptyDays(); $i++)

                <div class="empty-day"></div>

                @endfor

                
                @foreach($days as $item)

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

                    @if(
                        $item['event_count'] ||
                        $item['task_count'] ||
                        $item['note_count']
                    )

                        <span class="day-summary">

                            @if($item['event_count'])
                                رویداد: {{ fa($item['event_count']) }}
                            @endif

                            @if($item['task_count'])
                                وظیفه: {{ fa($item['task_count']) }}
                            @endif

                            @if($item['note_count'])
                                یادداشت: {{ fa($item['note_count']) }}
                            @endif

                        </span>

                    @endif

                </button>

                @endforeach

            </div>


        </section>

        
    </div>


    {{-- Monthly review --}}
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
@endpush