@extends('layouts.app')

@section('title', 'Dashboard Giảng Viên')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="fw-bold">Dashboard Giảng Viên</h2>
            <p class="text-muted">Xin chào, {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-5">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-book fa-3x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Tổng Khóa Học</h6>
                            <h2 class="mb-0">{{ $totalCourses }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users fa-3x text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Tổng Ghi Danh</h6>
                            <h2 class="mb-0">{{ $totalEnrollments }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-dollar-sign fa-3x text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Doanh Thu</h6>
                            <h2 class="mb-0">{{ number_format($totalRevenue, 0, ',', '.') }}đ</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Courses -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Khóa Học Của Bạn</h5>
                        <a href="{{ route('instructor.courses') }}" class="btn btn-primary btn-sm">
                            Xem Tất Cả
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($courses->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Khóa Học</th>
                                        <th>Giá</th>
                                        <th>Sections</th>
                                        <th>Ghi Danh</th>
                                        <th>Ngày Tạo</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses->take(5) as $course)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($course->thumbnail)
                                                        <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                                             alt="{{ $course->title }}"
                                                             class="rounded me-2"
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $course->title }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($course->price > 0)
                                                    {{ number_format($course->price, 0, ',', '.') }}đ
                                                @else
                                                    <span class="badge bg-success">Miễn phí</span>
                                                @endif
                                            </td>
                                            <td>{{ $course->sections_count }}</td>
                                            <td>{{ $course->enrollments_count }}</td>
                                            <td>{{ $course->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('instructor.courses.detail', $course->id) }}"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Chi Tiết
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Bạn chưa có khóa học nào.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
