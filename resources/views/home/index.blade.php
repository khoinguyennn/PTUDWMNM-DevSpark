@extends('layouts.app')

@section('title', 'DevStark - Học Lập Trình Để Đi Làm')

@section('content')
<!-- Hero Banner -->
@if(!isset($query) || empty($query))
<section class="hero-section">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
            <!-- Slide 1: ReactJS -->
            <div class="carousel-item active">
                <div class="hero-slide slide-1">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="hero-content animate-fade-in">
                                    <h1>Học ReactJS Miễn phí</h1>
                                    <p>Khóa học ReactJS từ cơ bản đến nâng cao. Kết quả của khóa học này là bạn có thể làm hầu hết các dự án thường gặp với ReactJS</p>

                                    <div class="hero-buttons">
                                        <a href="#" class="btn btn-primary">
                                            <i class="fas fa-play me-2"></i>Học thử miễn phí
                                        </a>
                                        <a href="#courses" class="btn btn-outline-light">
                                            <i class="fas fa-graduation-cap me-2"></i>Bắt đầu học
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="hero-image text-center">
                                    <img src="{{ asset('images/Banner_web_ReactJS.png') }}"
                                         alt="ReactJS">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Javascript Pro -->
            <div class="carousel-item">
                <div class="hero-slide slide-2">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="hero-content animate-fade-in">
                                    <h1>Mở bán khóa Javascript Pro <i class="fas fa-rocket text-warning"></i></h1>
                                    <p>Từ ngày 17/10/2025 khóa học sẽ có giá 1.399k</p>

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
                                    <img src="{{ asset('images/Banner_web_Javascript.png') }}"
                                         alt="JavaScript Pro">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3: HTML/CSS -->
            <div class="carousel-item">
                <div class="hero-slide slide-3">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="hero-content animate-fade-in">
                                    <h1>Học HTML CSS cho người mới</h1>
                                    <p>Thực hành dự án với Figma, hàng trăm bài tập, hướng dẫn 100% bởi chuyên gia, tặng kèm Flashcard, v.v</p>

                                    <div class="hero-buttons">
                                        <a href="#" class="btn btn-primary">
                                            <i class="fas fa-play me-2"></i>Học thử miễn phí
                                        </a>
                                        <a href="#courses" class="btn btn-outline-light">
                                            <i class="fas fa-graduation-cap me-2"></i>Bắt đầu học
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="hero-image text-center">
                                    <img src="{{ asset('images/Banner_web_Figma.png') }}"
                                         alt="HTML CSS">
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
@endif

<!-- Search Results or Featured Courses Section -->
<section class="py-4" id="courses">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(isset($query) && !empty($query))
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h2 class="section-title">
                            Kết quả tìm kiếm cho: "<span class="text-primary">{{ $query }}</span>"
                        </h2>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-times me-1"></i>Xóa tìm kiếm
                        </a>
                    </div>
                    
                    @if($featuredCourses->count() > 0)
                        <div class="alert alert-info">
                            <i class="fas fa-search me-2"></i>
                            Tìm thấy <strong>{{ $featuredCourses->count() }}</strong> khóa học phù hợp
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Không tìm thấy khóa học nào phù hợp với từ khóa "<strong>{{ $query }}</strong>"
                        </div>
                        <div class="text-center mt-4">
                            <p class="text-muted">Thử tìm kiếm với từ khóa khác hoặc xem các khóa học phổ biến:</p>
                            <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                                <a href="{{ route('home', ['search' => 'JavaScript']) }}" class="btn btn-outline-primary btn-sm">JavaScript</a>
                                <a href="{{ route('home', ['search' => 'HTML']) }}" class="btn btn-outline-primary btn-sm">HTML</a>
                                <a href="{{ route('home', ['search' => 'CSS']) }}" class="btn btn-outline-primary btn-sm">CSS</a>
                                <a href="{{ route('home', ['search' => 'React']) }}" class="btn btn-outline-primary btn-sm">React</a>
                                <a href="{{ route('home', ['search' => 'PHP']) }}" class="btn btn-outline-primary btn-sm">PHP</a>
                            </div>
                        </div>
                    @endif
                @else
                    <h2 class="section-title">
                        Khóa học nổi bật
                        <span class="badge rounded-pill" style="background: var(--primary-color); color: white; font-size: 0.6em;">MỚI</span>
                    </h2>
                @endif
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
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Chưa có khóa học nào</h4>
                        <p class="text-muted">Hiện tại chưa có khóa học nào trong hệ thống.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($featuredCourses->count() > 0)
            <div class="text-center mt-4">
                <a href="{{ route('courses.all') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-th-large me-2"></i>Xem tất cả khóa học
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Free Courses Section -->
@if(!isset($query) || empty($query))
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
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-gift fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Chưa có khóa học miễn phí</h4>
                        <p class="text-muted">Hiện tại chưa có khóa học miễn phí nào trong hệ thống.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($freeCourses->count() > 0)
            <div class="text-center mt-4">
                <a href="{{ route('courses.free') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-graduation-cap me-2"></i>Xem tất cả khóa học miễn phí
                </a>
            </div>
        @endif
    </div>
</section>
@endif
@endsection

@push('styles')
<style>
    /* Hero section spacing for indicators */
    .hero-section {
        margin-bottom: 30px;
        position: relative;
    }

    /* Smooth carousel transitions */
    .carousel-inner {
        overflow: hidden;
    }

    .carousel-item {
        transition: transform 0.8s ease-in-out;
    }

    /* Custom slide animation */
    .carousel-item-next,
    .carousel-item-prev,
    .carousel-item.active {
        display: block;
    }

    .carousel-item-next:not(.carousel-item-start),
    .active.carousel-item-end {
        transform: translateX(100%);
    }

    .carousel-item-prev:not(.carousel-item-end),
    .active.carousel-item-start {
        transform: translateX(-100%);
    }

    /* Fade in animation for content */
    .hero-content {
        opacity: 0;
        transform: translateX(-30px);
        animation: slideInLeft 1s ease-out 0.5s forwards;
    }

    .hero-image {
        opacity: 0;
        transform: translateX(30px);
        animation: slideInRight 1s ease-out 0.7s forwards;
    }

    @keyframes slideInLeft {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Carousel controls styling */
    .carousel-control-prev,
    .carousel-control-next {
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1;
    }

    /* Carousel indicators */
    .carousel-indicators {
        bottom: -20px;
        margin-bottom: 0;
        z-index: 15;
        position: absolute;
    }
    
    .carousel-indicators [data-bs-target] {
        transition: opacity 0.3s ease;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: rgba(0, 0, 0, 0.4);
        border: 2px solid white;
        margin: 0 4px;
    }
    
    .carousel-indicators [data-bs-target].active {
        background-color: #007bff;
        border-color: #007bff;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize carousel with smooth transitions
    document.addEventListener('DOMContentLoaded', function() {
        var heroCarousel = new bootstrap.Carousel(document.getElementById('heroCarousel'), {
            interval: 4000,
            ride: 'carousel',
            pause: 'hover',
            wrap: true,
            touch: true
        });

        // Add custom slide event listeners for smooth animations
        const carousel = document.getElementById('heroCarousel');
        
        carousel.addEventListener('slide.bs.carousel', function (e) {
            // Reset animations for new slide
            const newSlide = e.relatedTarget;
            const heroContent = newSlide.querySelector('.hero-content');
            const heroImage = newSlide.querySelector('.hero-image');
            
            if (heroContent) {
                heroContent.style.animation = 'none';
                heroContent.offsetHeight; // Trigger reflow
                heroContent.style.animation = 'slideInLeft 1s ease-out 0.3s forwards';
            }
            
            if (heroImage) {
                heroImage.style.animation = 'none';
                heroImage.offsetHeight; // Trigger reflow
                heroImage.style.animation = 'slideInRight 1s ease-out 0.5s forwards';
            }
        });
    });

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
