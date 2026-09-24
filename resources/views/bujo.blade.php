@extends('layouts.master')

@section('title', 'خانه')

@section('content')

<div class="dashboard">

    {{-- خوش‌آمدگویی --}}
    <section class="dashboard-welcome">
        <h1>
            سلام {{ Auth::user()->name }} 🌱
        </h1>

        <p>
            امروزت را از اینجا شروع کن.
        </p>
    </section>


    {{-- محتوای اصلی --}}
    <div class="dashboard-grid">

        {{-- امروز --}}
        <section class="dashboard-card">
            <h2>امروز</h2>

            <p class="dashboard-empty">
                هنوز چیزی برای امروز ثبت نکرده‌ای.
            </p>

            <button type="button" class="dashboard-action">
                + ثبت اولین یادداشت
            </button>
        </section>


        {{-- کارهای امروز --}}
        <section class="dashboard-card">
            <h2>کارهای امروز</h2>

            <p class="dashboard-empty">
                هنوز کاری برای امروز ثبت نشده است.
            </p>

            <button type="button" class="dashboard-action">
                + افزودن کار
            </button>
        </section>


        {{-- مجموعه‌ها --}}
        <section class="dashboard-card dashboard-card-wide">
            <h2>مجموعه‌های من</h2>

            <p class="dashboard-empty">
                مجموعه‌های خودت را از منوی کناری مدیریت کن.
            </p>
        </section>

    </div>

</div>

@endsection