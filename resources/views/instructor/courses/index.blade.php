@extends('layouts.app')

@section('title', 'Quản Lý Khóa Học')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">Quản Lý Khóa Học</h2>
            </div>
        </div>
    </div>

    @if($courses->count() > 0)
        <div class="row">
            @foreach($courses as $course)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                 class="card-img-top"
                                 alt="{{ $course->title }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary" style="height: 200px;"></div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $course->title }}</h5>
                            <p class="card-text text-muted">
                                {{ Str::limit($course->description, 100) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-list"></i> {{ $course->sections_count }} sections
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-users"></i> {{ $course->enrollments_count }} học viên
                                </small>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0 text-primary">
                                    @if($course->price > 0)
                                        {{ number_format($course->price, 0, ',', '.') }}đ
                                    @else
                                        <span class="badge bg-success">Miễn phí</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <a href="{{ route('instructor.courses.detail', $course->id) }}"
                               class="btn btn-primary w-100">
                                <i class="fas fa-eye"></i> Chi Tiết
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-book fa-4x text-muted mb-3"></i>
                        <h4>Chưa Có Khóa Học</h4>
                        <p class="text-muted">Bạn chưa tạo khóa học nào.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
