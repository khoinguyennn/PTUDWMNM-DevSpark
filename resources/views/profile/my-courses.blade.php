@extends('layouts.app')

@section('title', 'Khóa học của tôi')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-graduation-cap me-2"></i>Khóa học của tôi</h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Khám phá thêm
                    </a>
                </div>
            </div>

            @if($purchasedCourses->count() > 0)
                <!-- Course Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 class="text-primary mb-1">{{ $purchasedCourses->count() }}</h3>
                                <small class="text-muted">Khóa học đã mua</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 class="text-success mb-1">{{ $purchasedCourses->where('progress_percentage', 100)->count() }}</h3>
                                <small class="text-muted">Đã hoàn thành</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 class="text-warning mb-1">{{ $purchasedCourses->where('progress_percentage', '>', 0)->where('progress_percentage', '<', 100)->count() }}</h3>
                                <small class="text-muted">Đang học</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 class="text-info mb-1">{{ round($purchasedCourses->avg('progress_percentage')) }}%</h3>
                                <small class="text-muted">Tiến độ trung bình</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter and Sort -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="btn-group" role="group" aria-label="Filter courses">
                                    <button type="button" class="btn btn-outline-primary active" onclick="filterCourses('all')">
                                        Tất cả ({{ $purchasedCourses->count() }})
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" onclick="filterCourses('in-progress')">
                                        Đang học ({{ $purchasedCourses->where('progress_percentage', '>', 0)->where('progress_percentage', '<', 100)->count() }})
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" onclick="filterCourses('completed')">
                                        Hoàn thành ({{ $purchasedCourses->where('progress_percentage', 100)->count() }})
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" onclick="filterCourses('not-started')">
                                        Chưa bắt đầu ({{ $purchasedCourses->where('progress_percentage', 0)->count() }})
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <select class="form-select d-inline-block w-auto" onchange="sortCourses(this.value)">
                                    <option value="recent">Mua gần đây</option>
                                    <option value="progress">Tiến độ cao nhất</option>
                                    <option value="name">Tên A-Z</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Courses Grid -->
                <div class="row" id="coursesGrid">
                    @foreach($purchasedCourses as $course)
                    <div class="col-lg-4 col-md-6 mb-4 course-item"
                         data-progress="{{ $course->progress_percentage }}"
                         data-name="{{ strtolower($course->title) }}"
                         data-date="{{ $course->purchase_date->timestamp }}">
                        <div class="card course-card h-100">
                            <!-- Course Image -->
                            <div class="position-relative">
                                @if($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                         class="card-img-top" alt="{{ $course->title }}"
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                                         style="height: 200px;">
                                        <i class="fas fa-book fa-3x text-muted"></i>
                                    </div>
                                @endif

                                <!-- Progress Badge -->
                                <div class="position-absolute top-0 end-0 m-2">
                                    @if($course->progress_percentage == 100)
                                        <span class="badge bg-success">Hoàn thành</span>
                                    @elseif($course->progress_percentage > 0)
                                        <span class="badge bg-warning">{{ $course->progress_percentage }}%</span>
                                    @else
                                        <span class="badge bg-secondary">Chưa bắt đầu</span>
                                    @endif
                                </div>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <!-- Course Title -->
                                <h5 class="card-title mb-2">{{ $course->title }}</h5>

                                <!-- Instructor -->
                                <p class="text-muted mb-2">
                                    <i class="fas fa-user-tie me-1"></i>
                                    {{ $course->instructor->name ?? 'N/A' }}
                                </p>

                                <!-- Course Stats -->
                                <div class="row text-center mb-3">
                                    <div class="col-6">
                                        <small class="text-muted">Bài học</small>
                                        <div class="fw-bold">{{ $course->total_lessons }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Đã học</small>
                                        <div class="fw-bold text-success">{{ $course->completed_lessons }}</div>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Tiến độ học tập</small>
                                        <small class="text-muted">{{ $course->progress_percentage }}%</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar
                                            @if($course->progress_percentage == 100) bg-success
                                            @elseif($course->progress_percentage > 50) bg-info
                                            @elseif($course->progress_percentage > 0) bg-warning
                                            @else bg-secondary
                                            @endif"
                                             role="progressbar"
                                             style="width: {{ $course->progress_percentage }}%">
                                        </div>
                                    </div>
                                </div>

                                <!-- Purchase Date -->
                                <div class="text-muted mb-3">
                                    <i class="fas fa-calendar me-1"></i>
                                    Mua ngày {{ $course->purchase_date->format('d/m/Y') }}
                                </div>

                                <!-- Action Button -->
                                <div class="mt-auto">
                                    <a href="{{ route('course.learn', $course->id) }}"
                                       class="btn btn-primary w-100">
                                        @if($course->progress_percentage == 0)
                                            <i class="fas fa-play me-1"></i>Bắt đầu học
                                        @elseif($course->progress_percentage == 100)
                                            <i class="fas fa-redo me-1"></i>Học lại
                                        @else
                                            <i class="fas fa-play me-1"></i>Tiếp tục học
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Continue Learning Section -->
                @php
                    $inProgressCourses = $purchasedCourses->where('progress_percentage', '>', 0)->where('progress_percentage', '<', 100)->take(3);
                @endphp

                @if($inProgressCourses->count() > 0)
                <div class="mt-5">
                    <h4 class="mb-4"><i class="fas fa-clock me-2"></i>Tiếp tục học</h4>
                    <div class="row">
                        @foreach($inProgressCourses as $course)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @if($course->thumbnail)
                                                <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                                     alt="{{ $course->title }}"
                                                     style="width: 60px; height: 60px; object-fit: cover;"
                                                     class="rounded">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                     style="width: 60px; height: 60px;">
                                                    <i class="fas fa-book text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ Str::limit($course->title, 30) }}</h6>
                                            <div class="progress mb-2" style="height: 4px;">
                                                <div class="progress-bar bg-warning"
                                                     style="width: {{ $course->progress_percentage }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ $course->progress_percentage }}% hoàn thành</small>
                                        </div>
                                        <a href="{{ route('course.learn', $course->id) }}"
                                           class="btn btn-outline-primary btn-sm ms-3">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-graduation-cap fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Bạn chưa có khóa học nào</h4>
                        <p class="text-muted">Khám phá và mua các khóa học để bắt đầu hành trình học tập của bạn!</p>
                    </div>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Khám phá khóa học
                        </a>
                        <a href="{{ route('orders.history') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-history me-1"></i>Lịch sử đơn hàng
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .course-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        border: 1px solid #dee2e6;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .progress {
        background-color: #e9ecef;
    }

    .progress-bar {
        transition: width 0.3s ease;
    }

    .card {
        overflow: hidden;
    }

    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
    let allCourses = [];

    document.addEventListener('DOMContentLoaded', function() {
        // Store all course items for filtering
        allCourses = Array.from(document.querySelectorAll('.course-item'));
    });

    function filterCourses(filter) {
        // Remove active class from all buttons
        document.querySelectorAll('.btn-group .btn').forEach(btn => {
            btn.classList.remove('active');
        });

        // Add active class to clicked button
        event.target.classList.add('active');

        const coursesGrid = document.getElementById('coursesGrid');

        allCourses.forEach(course => {
            const progress = parseInt(course.dataset.progress);
            let show = false;

            switch(filter) {
                case 'all':
                    show = true;
                    break;
                case 'in-progress':
                    show = progress > 0 && progress < 100;
                    break;
                case 'completed':
                    show = progress === 100;
                    break;
                case 'not-started':
                    show = progress === 0;
                    break;
            }

            if (show) {
                course.style.display = 'block';
                course.classList.add('animate__fadeIn');
            } else {
                course.style.display = 'none';
                course.classList.remove('animate__fadeIn');
            }
        });
    }

    function sortCourses(sortBy) {
        const coursesGrid = document.getElementById('coursesGrid');
        const courses = Array.from(coursesGrid.children);

        courses.sort((a, b) => {
            switch(sortBy) {
                case 'recent':
                    return parseInt(b.dataset.date) - parseInt(a.dataset.date);
                case 'progress':
                    return parseInt(b.dataset.progress) - parseInt(a.dataset.progress);
                case 'name':
                    return a.dataset.name.localeCompare(b.dataset.name);
                default:
                    return 0;
            }
        });

        // Re-append sorted courses
        courses.forEach(course => {
            coursesGrid.appendChild(course);
        });
    }
</script>
@endpush
