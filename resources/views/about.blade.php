@extends('layouts.app')

@section('title', 'Giới thiệu - DevStark')

@section('content')
<!-- About Hero Section -->
<section class="py-5 px-3 px-md-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-white">
                <h1 class="display-4 fw-bold mb-4">Về DevStark</h1>
                <p class="lead mb-4">
                    Nền tảng học lập trình trực tuyến hàng đầu Việt Nam, giúp hàng nghìn học viên 
                    thành công trong sự nghiệp lập trình viên.
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('courses.all') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-graduation-cap me-2"></i>Khám phá khóa học
                    </a>
                    <a href="{{ route('blog.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-newspaper me-2"></i>Bài viết
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center mt-4 mt-lg-0">
                <img src="{{ asset('images/logo.jpg') }}" 
                     alt="DevStark Logo" 
                     class="img-fluid rounded shadow-lg"
                     style="max-height: 300px;">
            </div>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-bold">Sứ mệnh của chúng tôi</h2>
                <p class="text-muted lead">
                    Mang đến cơ hội học tập lập trình chất lượng cao cho mọi người
                </p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card course-card h-100 text-center">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-bullseye fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-3">Chất lượng đào tạo</h4>
                        <p class="text-muted">
                            Các khóa học được thiết kế bài bản, từ cơ bản đến nâng cao, 
                            phù hợp với mọi trình độ học viên.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card course-card h-100 text-center">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-users fa-3x text-success"></i>
                        </div>
                        <h4 class="mb-3">Cộng đồng học tập</h4>
                        <p class="text-muted">
                            Kết nối với hàng nghìn học viên khác, trao đổi kiến thức và 
                            cùng nhau phát triển.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card course-card h-100 text-center">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-briefcase fa-3x text-warning"></i>
                        </div>
                        <h4 class="mb-3">Định hướng nghề nghiệp</h4>
                        <p class="text-muted">
                            Hỗ trợ định hướng lộ trình học tập và phát triển sự nghiệp 
                            trong ngành công nghệ.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-lg-3 col-md-6">
                <div class="p-4">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h2 class="fw-bold mb-2">10,000+</h2>
                    <p class="text-muted">Học viên</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="p-4">
                    <i class="fas fa-book fa-3x text-success mb-3"></i>
                    <h2 class="fw-bold mb-2">100+</h2>
                    <p class="text-muted">Khóa học</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="p-4">
                    <i class="fas fa-chalkboard-teacher fa-3x text-warning mb-3"></i>
                    <h2 class="fw-bold mb-2">50+</h2>
                    <p class="text-muted">Giảng viên</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="p-4">
                    <i class="fas fa-star fa-3x text-danger mb-3"></i>
                    <h2 class="fw-bold mb-2">4.8/5</h2>
                    <p class="text-muted">Đánh giá</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-bold">Tại sao chọn DevStark?</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="d-flex align-items-start mb-4">
                    <div class="me-3">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <div>
                        <h5 class="mb-2">Học mọi lúc, mọi nơi</h5>
                        <p class="text-muted">
                            Truy cập khóa học 24/7 trên mọi thiết bị. Học theo lịch trình của riêng bạn.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex align-items-start mb-4">
                    <div class="me-3">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <div>
                        <h5 class="mb-2">Giảng viên kinh nghiệm</h5>
                        <p class="text-muted">
                            Học từ các chuyên gia hàng đầu với nhiều năm kinh nghiệm thực chiến.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex align-items-start mb-4">
                    <div class="me-3">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <div>
                        <h5 class="mb-2">Thực hành dự án thực tế</h5>
                        <p class="text-muted">
                            Mỗi khóa học đều có dự án thực tế giúp bạn áp dụng kiến thức vào thực tiễn.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex align-items-start mb-4">
                    <div class="me-3">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <div>
                        <h5 class="mb-2">Hỗ trợ tận tình</h5>
                        <p class="text-muted">
                            Đội ngũ hỗ trợ sẵn sàng giải đáp mọi thắc mắc của bạn trong quá trình học.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex align-items-start mb-4">
                    <div class="me-3">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <div>
                        <h5 class="mb-2">Chứng chỉ hoàn thành</h5>
                        <p class="text-muted">
                            Nhận chứng chỉ sau khi hoàn thành khóa học để chứng minh năng lực của bạn.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex align-items-start mb-4">
                    <div class="me-3">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <div>
                        <h5 class="mb-2">Cập nhật liên tục</h5>
                        <p class="text-muted">
                            Nội dung khóa học được cập nhật thường xuyên theo xu hướng công nghệ mới nhất.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-bold">Đội ngũ của chúng tôi</h2>
                <p class="text-muted lead">
                    Những người đam mê công nghệ và giáo dục
                </p>
            </div>
        </div>
        <div class="row g-4">
            @php
            $team = [
                [
                    'name' => 'Nguyễn Văn A',
                    'position' => 'Founder & CEO',
                    'avatar' => 'https://ui-avatars.com/api/?name=Nguyen+Van+A&size=200&background=667eea&color=fff',
                    'description' => '10+ năm kinh nghiệm trong lĩnh vực công nghệ'
                ],
                [
                    'name' => 'Trần Thị B',
                    'position' => 'Chief Technology Officer',
                    'avatar' => 'https://ui-avatars.com/api/?name=Tran+Thi+B&size=200&background=f093fb&color=fff',
                    'description' => 'Chuyên gia về phát triển web và mobile'
                ],
                [
                    'name' => 'Lê Văn C',
                    'position' => 'Head of Education',
                    'avatar' => 'https://ui-avatars.com/api/?name=Le+Van+C&size=200&background=4facfe&color=fff',
                    'description' => 'Giảng viên cao cấp với nhiều năm kinh nghiệm'
                ],
                [
                    'name' => 'Phạm Thị D',
                    'position' => 'Marketing Director',
                    'avatar' => 'https://ui-avatars.com/api/?name=Pham+Thi+D&size=200&background=43e97b&color=fff',
                    'description' => 'Chuyên gia marketing và phát triển thương hiệu'
                ]
            ];
            @endphp

            @foreach($team as $member)
            <div class="col-lg-3 col-md-6">
                <div class="card course-card h-100 text-center">
                    <div class="card-body p-4">
                        <img src="{{ $member['avatar'] }}" 
                             alt="{{ $member['name'] }}" 
                             class="rounded-circle mb-3"
                             style="width: 120px; height: 120px; object-fit: cover;">
                        <h5 class="mb-1">{{ $member['name'] }}</h5>
                        <p class="text-primary mb-2">{{ $member['position'] }}</p>
                        <p class="text-muted small">{{ $member['description'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Contact CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center text-white">
                <h2 class="mb-4">Sẵn sàng bắt đầu hành trình học tập?</h2>
                <p class="lead mb-4">
                    Tham gia cùng hàng nghìn học viên đã và đang học tập tại DevStark. 
                    Bắt đầu ngay hôm nay và thay đổi tương lai của bạn!
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Đăng ký ngay
                    </a>
                    <a href="{{ route('courses.all') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-book me-2"></i>Xem khóa học
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .course-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }

    .display-4 {
        font-size: 3.5rem;
    }

    @media (max-width: 768px) {
        .display-4 {
            font-size: 2.5rem;
        }
    }
</style>
@endpush
