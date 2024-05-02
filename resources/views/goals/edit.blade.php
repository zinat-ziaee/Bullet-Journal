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
          @empty(!$goalCategorizes)
          @foreach($goalCategorizes as $key=>$value)
          <option value="{{$key}}" {{($key == $id)?'selected':''}}>{{$value}}</option>
          @endforeach
          @endempty
        </select>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
        <strong>اهداف کوتاه مدت</strong>
        <input type="text" name="short-term-goals" value="{{$goal['short-term-goals']}}" class="form-control" placeholder="اهداف کوتاه مدت">
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
        <strong>اهداف میان مدت</strong>
        <input type="text" name="medium-term-goals" value="{{$goal['medium-term-goals']}}" class="form-control" placeholder="اهداف میان مدت">
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
        <strong>اهداف بلند مدت</strong>
        <input type="text" name="long-term-goals" value="{{$goal['long-term-goals']}}" class="form-control" placeholder="اهداف بلند مدت">
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" class="btn btn-success">ویرایش</button>
    </div>
  </div>
</form>
@endsection