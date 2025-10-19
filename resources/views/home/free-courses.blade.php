@extends('layouts.app')

@section('title', 'Khóa học miễn phí - DevStark')

@section('content')
<!-- Page Header Section -->
<section class="hero-section">
    <div class="hero-slide slide-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="hero-content animate-fade-in">
                        <h1>Khóa học miễn phí <i class="fas fa-gift text-warning"></i></h1>
                        <p>Học lập trình miễn phí với các khóa học chất lượng cao từ những chuyên gia hàng đầu</p>
                        
                        <!-- Search Form in Hero -->
                        <div class="hero-search mt-4">
                            <form method="GET" action="{{ route('courses.free') }}" class="search-form">
                                <div class="input-group hero-search-group">
                                    <input type="text" name="search" class="form-control hero-search-input" 
                                           placeholder="Tìm kiếm khóa học miễn phí..." 
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
                            <div class="text-white text-center">
                                <h3 class="text-white mb-2">{{ $courses->total() }}</h3>
                                <p class="text-white mb-2">Khóa học miễn phí</p>
                                <div class="free-badge">
                                    <span class="badge bg-success fs-6 px-3 py-2">
                                        <i class="fas fa-gift me-1"></i>100% FREE
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Courses Section -->
<section class="py-4" style="background-color: #f8f9fa;" id="courses">
    <div class="container">
        <!-- Filter and Sort Row -->
        <div class="row mb-4">
            <div class="col-md-6">
                @if(request('search'))
                    <div class="search-results-info">
                        <h5 class="mb-1">Kết quả tìm kiếm cho: "<span class="text-success">{{ request('search') }}</span>"</h5>
                        <p class="text-muted mb-0">Tìm thấy {{ $courses->total() }} khóa học miễn phí</p>
                    </div>
                @else
                    <div>
                        <h2 class="section-title">
                            Khóa học miễn phí
                            <span class="badge rounded-pill bg-success" style="font-size: 0.6em;">{{ $courses->total() }} khóa học</span>
                        </h2>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-3 justify-content-md-end">
                    @if(request('search'))
                        <a href="{{ route('courses.free') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Xóa tìm kiếm
                        </a>
                    @endif
                    
                    <form method="GET" action="{{ route('courses.free') }}" id="sortForm" class="d-inline">
                        <select name="sort" class="form-select" onchange="document.getElementById('sortForm').submit()" style="min-width: 150px;">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
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
                                        <i class="fas fa-gift fa-4x mb-3"></i>
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
                        <h4 class="text-muted">
                            @if(request('search'))
                                Không tìm thấy khóa học miễn phí nào
                            @else
                                Chưa có khóa học miễn phí nào
                            @endif
                        </h4>
                        <p class="text-muted">
                            @if(request('search'))
                                Thử tìm kiếm với từ khóa khác hoặc <a href="{{ route('courses.free') }}">xem tất cả khóa học miễn phí</a>
                            @else
                                Hiện tại chưa có khóa học miễn phí nào trong hệ thống.
                            @endif
                        </p>
                        @if(!request('search'))
                            <div class="mt-3">
                                <a href="{{ route('courses.all') }}" class="btn btn-primary">
                                    <i class="fas fa-graduation-cap me-2"></i>Xem khóa học có phí
                                </a>
                            </div>
                        @endif
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

        <!-- Call to Action -->
        @if($courses->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <div class="cta-section bg-white rounded p-4 text-center border">
                        <h4 class="mb-3">Muốn học thêm nhiều khóa học chuyên sâu?</h4>
                        <p class="text-muted mb-3">Khám phá các khóa học có phí với nội dung chuyên nghiệp và chi tiết hơn</p>
                        <a href="{{ route('courses.all') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-star me-2"></i>Xem khóa học có phí
                        </a>
                    </div>
                </div>
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
        background: #28a745 !important;
        color: white !important;
        border-radius: 0 50px 50px 0;
    }

    .hero-search-btn:hover {
        background: #218838 !important;
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
        background: #28a745;
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

    .price-free {
        color: #28a745 !important;
        font-size: 1.2rem !important;
        font-weight: 700 !important;
    }

    /* Form Styling */
    .form-select {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 14px;
    }

    .form-select:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }

    .cta-section {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    /* Pagination */
    .pagination {
        justify-content: center;
    }

    .page-link {
        color: #28a745;
        border: 1px solid #dee2e6;
        padding: 8px 12px;
        border-radius: 6px;
        margin: 0 2px;
    }

    .page-link:hover {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
    }

    .page-item.active .page-link {
        background-color: #28a745;
        border-color: #28a745;
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
