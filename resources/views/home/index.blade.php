@extends('layouts.app')

@section('title', 'DevStark - Học Lập Trình Để Đi Làm')

@section('content')
<!-- Hero Banner -->
<section class="hero-section">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
            <!-- Slide 1: Web Development -->
            <div class="carousel-item active">
                <div class="hero-slide slide-1">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="hero-content animate-fade-in">
                                    <h1>Trở thành Web Developer chuyên nghiệp <i class="fas fa-rocket text-warning"></i></h1>
                                    <p>Học từ cơ bản đến nâng cao với các dự án thực tế. Được hướng dẫn bởi các chuyên gia hàng đầu trong ngành.</p>

                                    <div class="hero-buttons">
                                        <a href="#" class="btn btn-primary">
                                            <i class="fas fa-play me-2"></i>Học thử miễn phí
                                        </a>
                                        <a href="#courses" class="btn btn-outline-light">
                                            <i class="fas fa-book me-2"></i>Xem khóa học
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="hero-image text-center">
                                    <div class="placeholder-image d-inline-block"
                                         style="width: 350px; height: 220px; background: rgba(255,255,255,0.15);
                                                border-radius: 20px; display: flex; align-items: center;
                                                justify-content: center; color: white; font-size: 3.5rem;">
                                        <i class="fas fa-code"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Mobile Development -->
            <div class="carousel-item">
                <div class="hero-slide slide-2">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="hero-content animate-fade-in">
                                    <h1>Phát triển ứng dụng Mobile <i class="fas fa-mobile-alt text-warning"></i></h1>
                                    <p>Tạo ra những ứng dụng mobile đẳng cấp với React Native, Flutter và các công nghệ hàng đầu.</p>

                                    <div class="hero-buttons">
                                        <a href="#" class="btn btn-primary">
                                            <i class="fas fa-download me-2"></i>Tải app demo
                                        </a>
                                        <a href="#courses" class="btn btn-outline-light">
                                            <i class="fas fa-graduation-cap me-2"></i>Bắt đầu học
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="hero-image text-center">
                                    <div class="placeholder-image d-inline-block"
                                         style="width: 350px; height: 220px; background: rgba(255,255,255,0.15);
                                                border-radius: 20px; display: flex; align-items: center;
                                                justify-content: center; color: white; font-size: 3.5rem;">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3: AI & Data Science -->
            <div class="carousel-item">
                <div class="hero-slide slide-3">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="hero-content animate-fade-in">
                                    <h1>AI & Data Science cho tương lai <i class="fas fa-brain text-warning"></i></h1>
                                    <p>Khám phá thế giới trí tuệ nhân tạo và khoa học dữ liệu với Python, Machine Learning và Deep Learning.</p>

                                    <div class="hero-buttons">
                                        <a href="#" class="btn btn-primary">
                                            <i class="fas fa-robot me-2"></i>Thử AI Demo
                                        </a>
                                        <a href="#courses" class="btn btn-outline-light">
                                            <i class="fas fa-chart-line me-2"></i>Khám phá ngay
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="hero-image text-center">
                                    <div class="placeholder-image d-inline-block"
                                         style="width: 350px; height: 220px; background: rgba(255,255,255,0.15);
                                                border-radius: 20px; display: flex; align-items: center;
                                                justify-content: center; color: white; font-size: 3.5rem;">
                                        <i class="fas fa-brain"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>

<!-- Featured Courses Section -->
<section class="py-4" id="courses">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">
                    Khóa học nổi bật
                    <span class="badge rounded-pill" style="background: var(--primary-color); color: white; font-size: 0.6em;">MỚI</span>
                </h2>
            </div>
        </div>

        <div class="row g-4">
            @forelse($featuredCourses as $index => $course)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('course.show', $course->id) }}" class="text-decoration-none">
                        <div class="card course-card">
                            <div class="course-image course-gradient-{{ ($index % 3) + 1 }} d-flex align-items-center justify-content-center">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                     alt="{{ $course->title }}"
                                     class="img-fluid"
                                     style="max-height: 150px; border-radius: 10px;">
                            @else
                                <div class="text-white text-center">
                                    <i class="fas fa-laptop-code fa-4x mb-3"></i>
                                    <h4 class="text-white">{{ Str::limit($course->title, 20) }}</h4>
                                </div>
                            @endif
                        </div>

                        <div class="course-body d-flex flex-column">
                            <h5 class="course-title">{{ $course->title }}</h5>
                            <p class="course-subtitle">
                                @if($course->instructor)
                                    <i class="fas fa-user me-1"></i>{{ $course->instructor->name }}
                                @endif
                            </p>

                            @if($course->learning_outcomes && count($course->learning_outcomes) > 0)
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-check-circle me-1"></i>
                                        {{ count($course->learning_outcomes) }} mục tiêu học tập
                                    </small>
                                </div>
                            @endif

                            <div class="course-price mt-auto">
                                @if($course->price > 0)
                                    <span class="price-current">{{ number_format($course->price, 0, ',', '.') }}đ</span>
                                @else
                                    <span class="price-current price-free">Miễn phí</span>
                                @endif
                            </div>
                        </div>
                        </div>
                    </a>
                </div>
            @empty
                <!-- Default courses when no data -->
                <div class="col-lg-4 col-md-6">
                    <div class="card course-card">
                        <div class="course-image course-gradient-1 d-flex align-items-center justify-content-center">
                            <div class="text-white text-center">
                                <i class="fas fa-code fa-4x mb-3"></i>
                                <h4 class="text-white">HTML CSS</h4>
                                <p class="text-white mb-0">Cho người mới bắt đầu</p>
                            </div>
                        </div>
                        <div class="course-body">
                            <h5 class="course-title">HTML CSS</h5>
                            <p class="course-subtitle">Cho người mới bắt đầu</p>
                            <div class="course-price">
                                <span class="price-current">1.299.000đ</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card course-card">
                        <div class="course-image course-gradient-2 d-flex align-items-center justify-content-center">
                            <div class="text-white text-center">
                                <i class="fab fa-js-square fa-4x mb-3"></i>
                                <h4 class="text-white">JavaScript</h4>
                                <p class="text-white mb-0">Cho người mới bắt đầu</p>
                            </div>
                        </div>
                        <div class="course-body">
                            <h5 class="course-title">JavaScript</h5>
                            <p class="course-subtitle">Cho người mới bắt đầu</p>
                            <div class="course-price">
                                <span class="price-current">1.399.000đ</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card course-card">
                        <div class="course-image course-gradient-3 d-flex align-items-center justify-content-center">
                            <div class="text-white text-center">
                                <i class="fab fa-sass fa-4x mb-3"></i>
                                <h4 class="text-white">Ngôn ngữ Sass</h4>
                                <p class="text-white mb-0">Cho Frontend Developer</p>
                            </div>
                        </div>
                        <div class="course-body">
                            <h5 class="course-title">Ngôn ngữ Sass</h5>
                            <p class="course-subtitle">Cho Frontend Developer</p>
                            <div class="course-price">
                                <span class="price-current">299.000đ</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        @if($featuredCourses->count() > 0)
            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-th-large me-2"></i>Xem tất cả khóa học
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Free Courses Section -->
<section class="py-4" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">
                    Khóa học miễn phí
                    <span class="badge rounded-pill" style="background: #28a745; color: white; font-size: 0.6em;">0đ</span>
                </h2>
            </div>
        </div>

        <div class="row g-4">
            @forelse($freeCourses as $index => $course)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('course.show', $course->id) }}" class="text-decoration-none">
                        <div class="card course-card">
                            <div class="course-image course-gradient-{{ ($index % 3) + 1 }} d-flex align-items-center justify-content-center">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                     alt="{{ $course->title }}"
                                     class="img-fluid"
                                     style="max-height: 150px; border-radius: 10px;">
                            @else
                                <div class="text-white text-center">
                                    <i class="fas fa-laptop-code fa-4x mb-3"></i>
                                    <h4 class="text-white">{{ Str::limit($course->title, 20) }}</h4>
                                </div>
                            @endif
                        </div>

                        <div class="course-body d-flex flex-column">
                            <h5 class="course-title">{{ $course->title }}</h5>
                            <p class="course-subtitle">
                                @if($course->instructor)
                                    <i class="fas fa-user me-1"></i>{{ $course->instructor->name }}
                                @endif
                            </p>

                            @if($course->learning_outcomes && count($course->learning_outcomes) > 0)
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-check-circle me-1"></i>
                                        {{ count($course->learning_outcomes) }} mục tiêu học tập
                                    </small>
                                </div>
                            @endif

                            <div class="course-price mt-auto">
                                <span class="price-current price-free">Miễn phí</span>
                            </div>
                        </div>
                        </div>
                    </a>
                </div>
            @empty
                <!-- Default free courses when no data -->
                <div class="col-lg-4 col-md-6">
                    <div class="card course-card">
                        <div class="course-image course-gradient-1 d-flex align-items-center justify-content-center">
                            <div class="text-white text-center">
                                <i class="fab fa-html5 fa-4x mb-3"></i>
                                <h4 class="text-white">HTML cơ bản</h4>
                                <p class="text-white mb-0">Khởi đầu với web</p>
                            </div>
                        </div>
                        <div class="course-body">
                            <h5 class="course-title">HTML cơ bản</h5>
                            <p class="course-subtitle">Khởi đầu với web development</p>
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-check-circle me-1"></i>
                                    5 bài học cơ bản
                                </small>
                            </div>
                            <div class="course-price">
                                <span class="price-current price-free">Miễn phí</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card course-card">
                        <div class="course-image course-gradient-2 d-flex align-items-center justify-content-center">
                            <div class="text-white text-center">
                                <i class="fab fa-css3-alt fa-4x mb-3"></i>
                                <h4 class="text-white">CSS cơ bản</h4>
                                <p class="text-white mb-0">Tạo giao diện đẹp</p>
                            </div>
                        </div>
                        <div class="course-body">
                            <h5 class="course-title">CSS cơ bản</h5>
                            <p class="course-subtitle">Tạo giao diện đẹp mắt</p>
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-check-circle me-1"></i>
                                    6 bài học styling
                                </small>
                            </div>
                            <div class="course-price">
                                <span class="price-current" class="price-free">Miễn phí</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card course-card">
                        <div class="course-image course-gradient-3 d-flex align-items-center justify-content-center">
                            <div class="text-white text-center">
                                <i class="fas fa-code fa-4x mb-3"></i>
                                <h4 class="text-white">Lập trình cơ bản</h4>
                                <p class="text-white mb-0">Tư duy lập trình</p>
                            </div>
                        </div>
                        <div class="course-body">
                            <h5 class="course-title">Lập trình cơ bản</h5>
                            <p class="course-subtitle">Tư duy và logic lập trình</p>
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-check-circle me-1"></i>
                                    8 bài học tư duy
                                </small>
                            </div>
                            <div class="course-price">
                                <span class="price-current" class="price-free">Miễn phí</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        @if($freeCourses->count() > 0)
            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-graduation-cap me-2"></i>Xem tất cả khóa học miễn phí
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Add animation when elements come into view
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);

    // Observe all course cards
    document.querySelectorAll('.course-card').forEach(card => {
        observer.observe(card);
    });
</script>
@endpush
