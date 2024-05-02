@extends('layouts.app')
@section('content')
@forelse($goals as $goal)
{{ $goal->id}}
<a href="{{route('goals.edit',$goal->id)}}">ویرایش</a> <a href="{{route('goals.show',$goal->id)}}">نمایش</a><br>
<form action="{{route('goals.destroy',$goal->id)}}" method="POST">
  @csrf
  @method('DELETE')
  <button class="btn btn-link">حذف</button>
</form>
@empty
'هدفی یافت نشد'
@endforelse
@endsection