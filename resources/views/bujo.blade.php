@extends('layouts.master')

@section('title','home')

@push('styles')
<!-- <link rel="stylesheet" href="/assets/css/style.css" /> -->
<style>
  /* css code */
</style>
@endpush

@section('container')
@section('sidebar')
@include('partials.sidebar')
@parent
<!-- Includes parent sidebar -->
<!-- <p>Aboute us page sidebar</p> -->
@if(Auth::user())
  @php
    \Artisan::call('db:seed', [
      '--class' => 'CollectionsTableSeeder',
      '--force'   => true
    ]);
  @endphp
@endif
@stop

<!-- <div class="">
	<div class="item item1 header">header</div>
	<div class="item item2 aside aside1">aside1</div>
	<div class="item item3 main">main</div>
	<div class="item item4 aside aside2">aside2</div>
	<div class="item item5 footer">footer</div>
</div> -->


