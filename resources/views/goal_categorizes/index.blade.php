@extends('layouts.app')
@section('content')
@foreach($goal_categorizes as $goal_categorize)
<a href="{{ route('goal_categorizes.edit', $goal_categorize->id) }}">ویرایش</a> <a href=""> نمایش</a> {{$goal_categorize->title}} <br>
<form action="{{ route('goal_categorizes.destroy',$goal_categorize->id)}}" method="POST">
   @csrf
   @method('DELETE')
   <button class="btn btn-link">حذف</button> 
</form>
@endforeach
@endsection