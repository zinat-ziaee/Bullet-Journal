@extends('layouts.app')

@section('content')
<div class="container py-4" dir="rtl">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0">🎯 اهداف من</h5>
          <a href="{{ route('goals.create') }}" class="btn btn-light btn-sm fw-bold shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> افزودن هدف جدید
          </a>
        </div>

        <div class="card-body bg-light">

          {{-- پیام موفقیت --}}
          @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show text-center fw-bold">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          @endif

          {{-- جدول اهداف --}}
          @if($goals->count())
          <div class="table-responsive">
            <table class="table table-hover text-center align-middle bg-white rounded">
              <thead class="table-success">
                <tr>
                  <th>🎯 کوتاه‌مدت</th>
                  <th>⏳ میان‌مدت</th>
                  <th>🚀 بلندمدت</th>
                  <th>عملیات</th>
                </tr>
              </thead>
              <tbody>
                @foreach($goals as $goal)
                <tr>
                  <td>{{ $goal->short_term_goals }}</td>
                  <td>{{ $goal->medium_term_goals }}</td>
                  <td>{{ $goal->long_term_goals }}</td>
                  <td>
                    <a href="{{ route('goals.show',$goal->id) }}" class="btn btn-outline-success btn-sm">نمایش</a>
                    <a href="{{ route('goals.edit',$goal->id) }}" class="btn btn-outline-primary btn-sm">ویرایش</a>
                    <form action="{{ route('goals.destroy',$goal->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('از حذف این هدف مطمئن هستید؟')">حذف</button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
          <div class="alert alert-warning text-center fw-bold py-3">
            ⚠️ هیچ هدفی ثبت نشده است.
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
