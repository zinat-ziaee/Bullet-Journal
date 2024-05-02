@extends('layouts.app')

@section('content')
<form action="{{ route('goal_categorizes.store') }}" method="POST">
  @csrf
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
        <strong>عنوان</strong>
        <input type="text" name="title" class="form-control" placeholder="Enter Title">
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" class="btn btn-success">ثبت</button>
    </div>
  </div>
</form>
@endsection