@extends('layouts.app')

@section('title', $course->title . ' - DevStark')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Course Content (Left Side) -->
        <div class="col-lg-8">
            <!-- Course Header -->
            <div class="course-header mb-4">
                <h1 class="course-title mb-3">{{ $course->title }}</h1>
                <p class="course-description text-muted mb-3">{{ $course->description }}</p>

                <!-- Course Meta Info -->
                <div class="course-meta d-flex flex-wrap gap-4 mb-4">
                    <div class="meta-item">
                        <i class="fas fa-book text-primary me-2"></i>
                        <span><strong>{{ $course->sections->count() }}</strong> chương</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-play-circle text-primary me-2"></i>
                        <span><strong>{{ $totalLessons }}</strong> bài học</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-clock text-primary me-2"></i>
                        <span>Thời lượng <strong>{{ gmdate('H:i', $totalDuration * 60) }}</strong></span>
                    </div>
                </div>

                <!-- What You'll Learn -->
                <div class="learning-outcomes mb-4">
                    <h3 class="section-subtitle mb-3">Bạn sẽ học được gì?</h3>
                    @if($course->learning_outcomes && count($course->learning_outcomes) > 0)
                        <div class="row">
                            @php
                                $outcomes = $course->learning_outcomes;
                                $halfCount = ceil(count($outcomes) / 2);
                                $leftColumn = array_slice($outcomes, 0, $halfCount);
                                $rightColumn = array_slice($outcomes, $halfCount);
                            @endphp

                            <div class="col-md-6">
                                <ul class="learning-list">
                                    @foreach($leftColumn as $outcome)
                                        <li><i class="fas fa-check text-success me-2"></i>{{ $outcome }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            @if(count($rightColumn) > 0)
                            <div class="col-md-6">
                                <ul class="learning-list">
                                    @foreach($rightColumn as $outcome)
                                        <li><i class="fas fa-check text-success me-2"></i>{{ $outcome }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Thông tin mục tiêu học tập sẽ được cập nhật sớm.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Course Content -->
            <div class="course-content">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="section-subtitle">Nội dung khóa học</h3>
                    <button class="btn btn-link text-danger" onclick="toggleAllSections()">
                        <span id="toggleText">Mở rộng tất cả</span>
                    </button>
                </div>

                <div class="course-curriculum">
                    @foreach($course->sections as $index => $section)
                    <div class="section-item mb-3">
                        <div class="section-header" onclick="toggleSection({{ $index }})">
                            <div class="d-flex justify-content-between align-items-center p-3 bg-light border rounded cursor-pointer">
                                <div class="section-info">
                                    <h5 class="mb-1">
                                        <i class="fas fa-chevron-right section-toggle me-2" id="toggle-{{ $index }}"></i>
                                        {{ $loop->iteration }}. {{ $section->title }}
                                    </h5>
                                </div>
                                <div class="section-meta text-muted">
                                    <span>{{ $section->lessons->count() }} bài học</span>
                                </div>
                            </div>
                        </div>

                        <div class="section-content collapse" id="section-{{ $index }}">
                            <div class="lessons-list border-start border-end border-bottom">
                                @foreach($section->lessons as $lesson)
                                <div class="lesson-item p-3 border-bottom d-flex justify-content-between align-items-center">
                                    <div class="lesson-info">
                                        <i class="fas fa-play-circle text-muted me-2"></i>
                                        <span>{{ $loop->iteration }}. {{ $lesson->title }}</span>
                                    </div>
                                    <div class="lesson-duration text-muted">
                                        {{ gmdate('i:s', $lesson->duration * 60) }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Course Sidebar (Right Side) -->
        <div class="col-lg-4">
            <div class="course-sidebar">
                <!-- Course Image -->
                <div class="course-image-container mb-4">
                    <div class="course-preview-image position-relative">
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                 alt="{{ $course->title }}"
                                 class="img-fluid rounded border">
                        @else
                            <div class="placeholder-course-image d-flex align-items-center justify-content-center bg-light rounded border" style="height: 200px;">
                                <div class="text-center text-muted">
                                    <i class="fas fa-image fa-3x mb-2"></i>
                                    <p class="mb-0">ẢNH KHÓA HỌC</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Course Price and Enroll -->
                <div class="course-enroll-card border rounded p-4 mb-4">
                    @if($course->price > 0)
                        <div class="price-section text-center mb-3">
                            <h3 class="price text-primary mb-0">{{ number_format($course->price, 0, ',', '.') }}đ</h3>
                        </div>
                    @else
                        <div class="price-section text-center mb-3">
                            <h3 class="price text-success mb-0">Miễn phí</h3>
                        </div>
                    @endif

                    <button class="btn btn-primary btn-lg w-100 mb-3">
                        <i class="fas fa-graduation-cap me-2"></i>ĐĂNG KÝ HỌC
                    </button>

                    <!-- Course Features -->
                    <div class="course-features">
                        <div class="feature-item d-flex align-items-center mb-2">
                            <i class="fas fa-book text-muted me-3"></i>
                            <span>Tổng số {{ $totalLessons }} bài học</span>
                        </div>
                        <div class="feature-item d-flex align-items-center mb-2">
                            <i class="fas fa-clock text-muted me-3"></i>
                            <span>Thời lượng {{ gmdate('H \g\i\ờ i \p\h\ú\t', $totalDuration * 60) }}</span>
                        </div>
                        <div class="feature-item d-flex align-items-center mb-2">
                            <i class="fas fa-infinity text-muted me-3"></i>
                            <span>Học mọi lúc, mọi nơi</span>
                        </div>
                        <div class="feature-item d-flex align-items-center">
                            <i class="fas fa-certificate text-muted me-3"></i>
                            <span>Cấp chứng chỉ hoàn thành</span>
                        </div>
                    </div>
                </div>

                <!-- Instructor Info -->
                @if($course->instructor)
                <div class="instructor-card border rounded p-4">
                    <h5 class="mb-3">Giảng viên</h5>
                    <div class="instructor-info d-flex align-items-center">
                        <div class="instructor-avatar me-3">
                            <div class="avatar bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                        </div>
                        <div class="instructor-details">
                            <h6 class="mb-1">{{ $course->instructor->name }}</h6>
                            <p class="text-muted mb-0 small">Chuyên gia IT</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.course-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-dark);
}

.section-subtitle {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.course-meta .meta-item {
    display: flex;
    align-items: center;
    font-size: 0.9rem;
}

.learning-list {
    list-style: none;
    padding: 0;
}

.learning-list li {
    padding: 0.5rem 0;
    display: flex;
    align-items: flex-start;
}

.section-header {
    cursor: pointer;
    transition: all 0.3s ease;
}

.section-header:hover {
    background-color: #f8f9fa !important;
}

.section-toggle {
    transition: transform 0.3s ease;
}

.section-toggle.rotated {
    transform: rotate(90deg);
}

.lesson-item:hover {
    background-color: #f8f9fa;
}

.course-enroll-card {
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.price {
    font-weight: 700;
    font-size: 2rem;
}

.course-features .feature-item {
    font-size: 0.9rem;
    color: var(--text-muted);
}

.instructor-card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.cursor-pointer {
    cursor: pointer;
}
</style>

<script>
function toggleSection(index) {
    const content = document.getElementById('section-' + index);
    const toggle = document.getElementById('toggle-' + index);

    if (content.classList.contains('show')) {
        content.classList.remove('show');
        toggle.classList.remove('rotated');
    } else {
        content.classList.add('show');
        toggle.classList.add('rotated');
    }
}

function toggleAllSections() {
    const allSections = document.querySelectorAll('.section-content');
    const allToggles = document.querySelectorAll('.section-toggle');
    const toggleText = document.getElementById('toggleText');

    let allExpanded = true;
    allSections.forEach(section => {
        if (!section.classList.contains('show')) {
            allExpanded = false;
        }
    });

    if (allExpanded) {
        // Collapse all
        allSections.forEach(section => section.classList.remove('show'));
        allToggles.forEach(toggle => toggle.classList.remove('rotated'));
        toggleText.textContent = 'Mở rộng tất cả';
    } else {
        // Expand all
        allSections.forEach(section => section.classList.add('show'));
        allToggles.forEach(toggle => toggle.classList.add('rotated'));
        toggleText.textContent = 'Thu gọn tất cả';
    }
}
</script>
@endsection
