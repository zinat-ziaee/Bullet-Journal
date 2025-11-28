@extends('layouts.app')

@section('content')
<form action="{{route('goals.update',$id)}}" method="POST">
  @csrf
  @method('PUT')
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
        <strong>گروه</strong>
        <select name="goal_categorizes_id" class="form-control custom-select">
          @if(!empty($goalCategorizes))
            @foreach($goalCategorizes as $key=>$value)
            <option value="{{$key}}" {{ (isset($goal) && $goal->goal_categorizes_id == $key ) ? 'selected' : '' }}>
              {{$value}}
            </option>
            @endforeach
          @endif
        </select>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
        <strong>اهداف کوتاه مدت</strong>
        <input type="text" name="short_term_goals" value="{{$goal['short_term_goals']}}" class="form-control" placeholder="اهداف کوتاه مدت">
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
        <strong>اهداف میان مدت</strong>
        <input type="text" name="medium_term_goals" value="{{$goal['medium_term_goals']}}" class="form-control" placeholder="اهداف میان مدت">
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
        <strong>اهداف بلند مدت</strong>
        <input type="text" name="long_term_goals" value="{{$goal['long_term_goals']}}" class="form-control" placeholder="اهداف بلند مدت">
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" class="btn btn-success">ویرایش</button>
    </div>
  </div>
</form>
@endsection