@extends('layouts.app')

@section('title', 'Bài viết - DevStark')

@section('content')
<!-- Blog Section -->
<section class="py-5 px-3 px-md-5" style="background-color: #f8f9fa;">
    <div class="container">
        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Bài viết nổi bật</h2>
                <p class="text-muted mb-4">
                    Những bài viết hữu ích về lập trình, công nghệ và kinh nghiệm học tập từ DevStark.
                </p>
            </div>
        </div>

        <!-- Blog Posts Grid -->
        <div class="row g-4">
            @php
            $posts = [
                [
                    'id' => 1,
                    'title' => 'Lộ trình học lập trình Frontend từ zero đến hero',
                    'excerpt' => 'Hướng dẫn chi tiết lộ trình học lập trình Frontend từ cơ bản đến nâng cao, giúp bạn có thể tự tin xin việc sau 6 tháng học tập.',
                    'thumbnail' => 'Banner_web_ReactJS.png',
                    'author' => 'Admin DevStark',
                    'date' => '2025-12-01',
                    'category' => 'Lộ trình học',
                    'views' => 1250,
                    'reading_time' => '10 phút đọc'
                ],
                [
                    'id' => 2,
                    'title' => 'JavaScript ES6+ - Những tính năng bạn cần biết',
                    'excerpt' => 'Tổng hợp những tính năng quan trọng nhất của JavaScript ES6+ mà mọi lập trình viên cần nắm vững để viết code hiện đại và hiệu quả.',
                    'thumbnail' => 'Banner_web_Javascript.png',
                    'author' => 'Admin DevStark',
                    'date' => '2025-11-28',
                    'category' => 'JavaScript',
                    'views' => 980,
                    'reading_time' => '8 phút đọc'
                ],
                [
                    'id' => 3,
                    'title' => 'Tips & Tricks khi làm việc với ReactJS',
                    'excerpt' => 'Những mẹo và thủ thuật hữu ích giúp bạn code ReactJS hiệu quả hơn, tối ưu performance và tránh những lỗi thường gặp.',
                    'thumbnail' => 'Banner_01_2.png',
                    'author' => 'Admin DevStark',
                    'date' => '2025-11-25',
                    'category' => 'ReactJS',
                    'views' => 856,
                    'reading_time' => '7 phút đọc'
                ],
                [
                    'id' => 4,
                    'title' => 'Backend với Laravel - Framework PHP mạnh mẽ',
                    'excerpt' => 'Tại sao Laravel là lựa chọn hàng đầu cho phát triển Backend? Cùng tìm hiểu những ưu điểm và cách bắt đầu với Laravel.',
                    'thumbnail' => 'Banner_web_Figma.png',
                    'author' => 'Admin DevStark',
                    'date' => '2025-11-22',
                    'category' => 'Backend',
                    'views' => 1120,
                    'reading_time' => '12 phút đọc'
                ],
                [
                    'id' => 5,
                    'title' => 'Cách tối ưu hiệu suất website với HTML & CSS',
                    'excerpt' => 'Những kỹ thuật tối ưu hóa hiệu suất website chỉ với HTML và CSS, giúp trang web load nhanh hơn và cải thiện trải nghiệm người dùng.',
                    'thumbnail' => 'Banner_web_Figma.png',
                    'author' => 'Admin DevStark',
                    'date' => '2025-11-20',
                    'category' => 'HTML/CSS',
                    'views' => 745,
                    'reading_time' => '6 phút đọc'
                ],
                [
                    'id' => 6,
                    'title' => 'Git & GitHub - Quản lý source code hiệu quả',
                    'excerpt' => 'Hướng dẫn sử dụng Git và GitHub từ cơ bản đến nâng cao, giúp bạn quản lý source code chuyên nghiệp như một developer thực thụ.',
                    'thumbnail' => 'Banner_01_2.png',
                    'author' => 'Admin DevStark',
                    'date' => '2025-11-18',
                    'category' => 'Tools',
                    'views' => 1340,
                    'reading_time' => '15 phút đọc'
                ]
            ];
            @endphp

            @foreach($posts as $index => $post)
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('blog.show', $post['id']) }}" class="text-decoration-none">
                    <div class="card course-card h-100">
                        <div class="course-image course-gradient-{{ ($index % 3) + 1 }} d-flex align-items-center justify-content-center" style="height: 200px;">
                            <img src="{{ asset('images/' . $post['thumbnail']) }}"
                                 alt="{{ $post['title'] }}"
                                 class="img-fluid"
                                 style="max-height: 180px; border-radius: 10px;"
                                 onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'text-white text-center\'><i class=\'fas fa-newspaper fa-4x mb-3\'></i><h5 class=\'text-white\'>{{ Str::limit($post['title'], 30) }}</h5></div>'">
                        </div>

                        <div class="course-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-primary me-2">{{ $post['category'] }}</span>
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($post['date'])->format('d/m/Y') }}
                                </small>
                            </div>

                            <h5 class="course-title">{{ $post['title'] }}</h5>
                            
                            <p class="text-muted mb-3" style="font-size: 0.9rem; line-height: 1.5;">
                                {{ $post['excerpt'] }}
                            </p>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 0.85rem;">
                                    <div>
                                        <i class="fas fa-user me-1"></i>{{ $post['author'] }}
                                    </div>
                                    <div>
                                        <i class="fas fa-eye me-1"></i>{{ number_format($post['views']) }} lượt xem
                                    </div>
                                </div>
                                <div class="text-muted mt-2" style="font-size: 0.85rem;">
                                    <i class="fas fa-clock me-1"></i>{{ $post['reading_time'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Blog pagination">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="mb-4">Danh mục bài viết</h3>
            </div>
        </div>
        <div class="row g-3">
            @php
            $categories = [
                ['name' => 'Lộ trình học', 'icon' => 'fa-map-marked-alt', 'count' => 15, 'color' => 'primary', 'iconType' => 'fas'],
                ['name' => 'JavaScript', 'icon' => 'fa-js-square', 'count' => 23, 'color' => 'warning', 'iconType' => 'fab'],
                ['name' => 'ReactJS', 'icon' => 'fa-react', 'count' => 18, 'color' => 'info', 'iconType' => 'fab'],
                ['name' => 'Backend', 'icon' => 'fa-server', 'count' => 12, 'color' => 'success', 'iconType' => 'fas'],
                ['name' => 'HTML/CSS', 'icon' => 'fa-html5', 'count' => 20, 'color' => 'danger', 'iconType' => 'fab'],
                ['name' => 'Tools', 'icon' => 'fa-tools', 'count' => 10, 'color' => 'secondary', 'iconType' => 'fas']
            ];
            @endphp

            @foreach($categories as $category)
            <div class="col-lg-2 col-md-4 col-6">
                <a href="#" class="text-decoration-none">
                    <div class="card text-center h-100 category-card">
                        <div class="card-body">
                            <i class="{{ $category['iconType'] }} {{ $category['icon'] }} fa-2x text-{{ $category['color'] }} mb-2"></i>
                            <h6 class="mb-1">{{ $category['name'] }}</h6>
                            <small class="text-muted">{{ $category['count'] }} bài viết</small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .category-card {
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-color: #007bff;
    }

    .course-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }

    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }

    .pagination .page-link {
        color: #007bff;
        border-radius: 5px;
        margin: 0 3px;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }

    .pagination .page-link:hover {
        background-color: #e9ecef;
    }
</style>
@endpush
