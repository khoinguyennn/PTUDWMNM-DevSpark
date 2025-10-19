@extends('layouts.app')

@section('title', 'Tất cả khóa học - DevStark')

@section('content')
<!-- Page Header Section -->
<section class="hero-section">
    <div class="hero-slide slide-1">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="hero-content animate-fade-in">
                        <h1>Tất cả khóa học</h1>
                        <p>Khám phá bộ sưu tập đầy đủ các khóa học lập trình chất lượng cao từ cơ bản đến nâng cao</p>
                        
                        <!-- Search Form in Hero -->
                        <div class="hero-search mt-4">
                            <form method="GET" action="{{ route('courses.all') }}" class="search-form">
                                <div class="input-group hero-search-group">
                                    <input type="text" name="search" class="form-control hero-search-input" 
                                           placeholder="Tìm kiếm khóa học..." 
                                           value="{{ request('search') }}">
                                    <button class="btn btn-light hero-search-btn" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="hero-image text-center">
                        <div class="hero-stats bg-white bg-opacity-10 rounded p-4 backdrop-blur">
                            <div class="text-white">
                                <h3 class="text-white mb-2">{{ $courses->total() }}</h3>
                                <p class="text-white mb-0">Khóa học có sẵn</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Courses Section -->
<section class="py-4" id="courses">
    <div class="container">
        <!-- Filter and Sort Row -->
        <div class="row mb-4">
            <div class="col-md-6">
                @if(request('search'))
                    <div class="search-results-info">
                        <h5 class="mb-1">Kết quả tìm kiếm cho: "<span class="text-primary">{{ request('search') }}</span>"</h5>
                        <p class="text-muted mb-0">Tìm thấy {{ $courses->total() }} khóa học</p>
                    </div>
                @else
                    <div>
                        <h2 class="section-title">
                            Danh sách khóa học
                            <span class="badge rounded-pill" style="background: var(--primary-color); color: white; font-size: 0.6em;">{{ $courses->total() }}</span>
                        </h2>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-3 justify-content-md-end">
                    @if(request('search'))
                        <a href="{{ route('courses.all') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Xóa tìm kiếm
                        </a>
                    @endif
                    
                    <form method="GET" action="{{ route('courses.all') }}" id="sortForm" class="d-inline">
                        <select name="sort" class="form-select" onchange="document.getElementById('sortForm').submit()" style="min-width: 180px;">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Giá thấp → cao</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Giá cao → thấp</option>
                        </select>
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    </form>
                </div>
            </div>
        </div>

        <!-- Courses Grid -->
        <div class="row g-4">
            @forelse($courses as $index => $course)
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
                                    <span class="price-current">{{ number_format($course->price, 0, ',', '.') }}đ</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">
                            @if(request('search'))
                                Không tìm thấy khóa học nào
                            @else
                                Chưa có khóa học nào
                            @endif
                        </h4>
                        <p class="text-muted">
                            @if(request('search'))
                                Thử tìm kiếm với từ khóa khác hoặc <a href="{{ route('courses.all') }}">xem tất cả khóa học</a>
                            @else
                                Hiện tại chưa có khóa học nào trong hệ thống.
                            @endif
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($courses->hasPages())
            <div class="text-center mt-5">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Hero Search Styling */
    .hero-search-group {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        backdrop-filter: blur(10px);
    }

    .hero-search-input {
        border: none;
        padding: 15px 25px;
        font-size: 16px;
        background: transparent;
    }

    .hero-search-input:focus {
        box-shadow: none;
        background: transparent;
    }

    .hero-search-btn {
        border: none;
        padding: 15px 25px;
        background: var(--primary-color) !important;
        color: white !important;
        border-radius: 0 50px 50px 0;
    }

    .hero-search-btn:hover {
        background: var(--primary-dark) !important;
    }

    .hero-stats {
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .backdrop-blur {
        backdrop-filter: blur(10px);
    }

    .search-results-info h5 {
        color: var(--text-dark);
        font-weight: 600;
    }

    /* Section Title */
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: var(--text-dark);
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    /* Course Cards - Same as home page */
    .course-card {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--box-shadow);
        transition: all 0.3s ease;
        border: none;
        height: 100%;
    }

    .course-card:hover,
    a:hover .course-card {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .course-image {
        height: 150px;
        background-size: cover;
        background-position: center;
        position: relative;
        background-color: #f8f9fa;
        width: 100%;
        background-repeat: no-repeat;
    }

    .course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .course-gradient-1 {
        background: var(--gradient-1);
    }

    .course-gradient-2 {
        background: var(--gradient-2);
    }

    .course-gradient-3 {
        background: var(--gradient-3);
    }

    .course-body {
        padding: 1rem;
    }

    .course-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
        line-height: 1.3;
    }

    .course-subtitle {
        color: var(--text-muted);
        font-size: 0.8rem;
        margin-bottom: 0.8rem;
    }

    .course-price {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: auto;
    }

    .price-current {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1rem;
    }

    /* Form Styling */
    .form-select {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 14px;
    }

    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(11, 186, 244, 0.25);
    }

    /* Pagination */
    .pagination {
        justify-content: center;
    }

    .page-link {
        color: var(--primary-color);
        border: 1px solid #dee2e6;
        padding: 8px 12px;
        border-radius: 6px;
        margin: 0 2px;
    }

    .page-link:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-submit search on Enter
    document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            this.closest('form').submit();
        }
    });

    // Course card animations
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

    document.querySelectorAll('.course-card').forEach(card => {
        observer.observe(card);
    });
</script>
@endpush
