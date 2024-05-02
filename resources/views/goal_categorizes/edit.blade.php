@extends('layouts.app')
@section('content')
<form action="{{ route('goal_categorizes.update',$goalCat->id)}}" method="POST">
    @csrf
    @method('PUT')

    @if(! empty($goalCat))
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>عنوان</strong>
                <input  type="text" name="title" value="{{$goalCat->title}}" class="form-control">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
           <button  type"submit" class="btn btn-success">ویرایش</button>
        </div>
    </div>
    @endif
</form>
@endsection