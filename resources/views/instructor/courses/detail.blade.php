@extends('layouts.app')

@section('title', 'Chi Tiết Khóa Học')

@section('content')
<div class="container my-5">
    <!-- Back Button -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('instructor.courses') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Quay Lại
            </a>
        </div>
    </div>

    <!-- Course Header -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                @if($course->thumbnail)
                    <img src="{{ asset('storage/' . $course->thumbnail) }}"
                         class="card-img-top"
                         alt="{{ $course->title }}"
                         style="height: 300px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h2 class="fw-bold">{{ $course->title }}</h2>
                    <p class="text-muted">{{ $course->description }}</p>

                    <div class="d-flex gap-3 mb-3">
                        <span class="badge bg-primary">{{ $course->sections->count() }} Sections</span>
                        <span class="badge bg-info">{{ $course->sections->sum(fn($s) => $s->lessons->count()) }} Bài Học</span>
                        <span class="badge bg-success">{{ $course->enrollments->count() }} Học Viên</span>
                    </div>

                    <h4 class="text-primary">
                        @if($course->price > 0)
                            {{ number_format($course->price, 0, ',', '.') }}đ
                        @else
                            Miễn Phí
                        @endif
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Enrollment Statistics -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Thống Kê Ghi Danh</h5>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tổng:</span>
                            <strong>{{ $enrollmentStats['total'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tháng này:</span>
                            <strong>{{ $enrollmentStats['this_month'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Tuần này:</span>
                            <strong>{{ $enrollmentStats['this_week'] }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Thông Tin Khóa Học</h5>
                    <div class="mb-2">
                        <small class="text-muted">Ngày tạo:</small>
                        <div>{{ $course->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Giảng viên:</small>
                        <div>{{ $course->instructor->name }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Content -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Nội Dung Khóa Học</h5>
                </div>
                <div class="card-body">
                    @if($course->sections->count() > 0)
                        <div class="accordion" id="sectionsAccordion">
                            @foreach($course->sections as $index => $section)
                                <div class="accordion-item border mb-2">
                                    <h2 class="accordion-header" id="heading{{ $section->id }}">
                                        <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $section->id }}"
                                                aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                                aria-controls="collapse{{ $section->id }}">
                                            <strong>Section {{ $section->position }}: {{ $section->title }}</strong>
                                            <span class="ms-auto me-3 badge bg-primary">
                                                {{ $section->lessons->count() }} bài học
                                            </span>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $section->id }}"
                                         class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                         aria-labelledby="heading{{ $section->id }}"
                                         data-bs-parent="#sectionsAccordion">
                                        <div class="accordion-body">
                                            @if($section->lessons->count() > 0)
                                                <ul class="list-group list-group-flush">
                                                    @foreach($section->lessons as $lesson)
                                                        <li class="list-group-item">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-play-circle text-primary me-2"></i>
                                                                <div class="flex-grow-1">
                                                                    <strong>{{ $lesson->title }}</strong>
                                                                    @if($lesson->duration)
                                                                        <br>
                                                                        <small class="text-muted">
                                                                            <i class="fas fa-clock"></i> {{ gmdate('H:i:s', $lesson->duration) }}
                                                                        </small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="text-muted mb-0">Chưa có bài học nào.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-list fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Khóa học chưa có section nào.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
