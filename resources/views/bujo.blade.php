@extends('layouts.app')

@section('title','Goals')

@push('styles')
    <link rel="stylesheet" href="/assets/css/style.css"/>
    <style>
        /* css code */
    </style>
@endpush

@section('sidebar')
    @parent<!-- Includes parent sidebar -->
    <!-- <p>Aboute us page sidebar</p> -->
@stop

@section('content')
{hello}
    @include('partials.slider')
    <!-- <p>This ia abuate us content page.</p> -->
@stop

@push('scripts')
    <script src="/assets/js/script.js"></script>
    <script>
        // ..custum js code
    </script>
@endpush    