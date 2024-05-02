@extends('layouts.app')

@section('content')
<form action="{{ route('goals.store') }}" method="POST">
  @csrf
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
        <strong>اهداف کوتاه مدت</strong>
        <input type="text" name="short-term-goals" class="form-control" placeholder="اهداف کوتاه مدت">
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
        <strong>اهداف میان مدت</strong>
        <input type="text" name="medium-term-goals" class="form-control" placeholder="اهداف میان مدت">
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
        <strong>اهداف بلند مدت</strong>
        <input type="text" name="long-term-goals" class="form-control" placeholder="اهداف بلند مدت">
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
        <strong>گروه</strong>
        <select name="goal_categorizes_id" class="form-control custom-select">
          <option value=""></option>
          @foreach($goalCategorizes as $goalCategorize)
          <option value="{{ $goalCategorize->id }}">{{ $goalCategorize->title }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" class="btn btn-success">ثبت</button>
    </div>
  </div>
</form>
@endsection