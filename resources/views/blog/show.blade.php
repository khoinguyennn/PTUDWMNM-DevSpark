@extends('layouts.app')

@section('title', 'Chi tiết bài viết - DevStark')

@section('content')
<!-- Blog Detail Section -->
<section class="py-4 px-2 px-md-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Bài viết</a></li>
                        <li class="breadcrumb-item active">Chi tiết bài viết</li>
                    </ol>
                </nav>

                <!-- Article Header -->
                <div class="mb-4">
                    <span class="badge bg-primary mb-2">Lộ trình học</span>
                    <h1 class="mb-3">Lộ trình học lập trình Frontend từ zero đến hero</h1>
                    
                    <div class="d-flex align-items-center text-muted mb-3">
                        <div class="me-4">
                            <i class="fas fa-user me-2"></i>Admin DevStark
                        </div>
                        <div class="me-4">
                            <i class="fas fa-calendar-alt me-2"></i>01/12/2025
                        </div>
                        <div class="me-4">
                            <i class="fas fa-eye me-2"></i>1,250 lượt xem
                        </div>
                        <div>
                            <i class="fas fa-clock me-2"></i>10 phút đọc
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="mb-4">
                    <img src="{{ asset('images/Banner_web_ReactJS.png') }}" 
                         alt="Featured Image" 
                         class="img-fluid rounded"
                         style="width: 100%; height: 400px; object-fit: cover;">
                </div>

                <!-- Article Content -->
                <div class="article-content">
                    <h2>Giới thiệu</h2>
                    <p>
                        Lập trình Frontend là một trong những lĩnh vực thu hút nhiều người học lập trình nhất hiện nay. 
                        Với sự phát triển mạnh mẽ của công nghệ web, nhu cầu tuyển dụng lập trình viên Frontend ngày càng tăng cao.
                    </p>

                    <h2>Tại sao nên học Frontend?</h2>
                    <p>
                        Frontend là phần giao diện mà người dùng tương tác trực tiếp, do đó vai trò của Frontend Developer rất quan trọng. 
                        Dưới đây là một số lý do tại sao bạn nên học Frontend:
                    </p>
                    <ul>
                        <li><strong>Dễ dàng bắt đầu:</strong> Frontend có ngưỡng vào thấp, bạn có thể bắt đầu với HTML, CSS cơ bản.</li>
                        <li><strong>Cơ hội việc làm cao:</strong> Nhu cầu tuyển dụng Frontend Developer rất lớn trên thị trường.</li>
                        <li><strong>Thu nhập tốt:</strong> Mức lương của Frontend Developer khá hấp dẫn, đặc biệt với các vị trí senior.</li>
                        <li><strong>Sáng tạo:</strong> Bạn có thể thoải mái sáng tạo và thể hiện ý tưởng của mình qua giao diện.</li>
                    </ul>

                    <h2>Lộ trình học Frontend chi tiết</h2>
                    
                    <h3>1. Nền tảng cơ bản (2-3 tháng)</h3>
                    <p>
                        Bước đầu tiên, bạn cần nắm vững các kiến thức nền tảng:
                    </p>
                    <ul>
                        <li><strong>HTML5:</strong> Hiểu về cấu trúc web, các thẻ HTML cơ bản và semantic HTML.</li>
                        <li><strong>CSS3:</strong> Styling, Flexbox, Grid, Responsive Design, Animation.</li>
                        <li><strong>JavaScript cơ bản:</strong> Biến, kiểu dữ liệu, vòng lặp, hàm, DOM manipulation.</li>
                    </ul>

                    <h3>2. JavaScript nâng cao (2-3 tháng)</h3>
                    <p>
                        Sau khi đã nắm vững cơ bản, bạn cần học sâu hơn về JavaScript:
                    </p>
                    <ul>
                        <li>ES6+ features: Arrow function, Destructuring, Spread/Rest operator, Promises, Async/Await</li>
                        <li>OOP trong JavaScript</li>
                        <li>Xử lý bất đồng bộ</li>
                        <li>Fetch API và làm việc với RESTful API</li>
                    </ul>

                    <h3>3. Framework/Library (3-4 tháng)</h3>
                    <p>
                        Học ít nhất một framework/library phổ biến:
                    </p>
                    <ul>
                        <li><strong>ReactJS:</strong> Component, Props, State, Hooks, Router, Redux</li>
                        <li><strong>Vue.js:</strong> Hoặc Vue nếu bạn thích cú pháp đơn giản hơn</li>
                        <li><strong>Angular:</strong> Phù hợp cho các dự án enterprise lớn</li>
                    </ul>

                    <h3>4. Công cụ và kỹ năng bổ sung</h3>
                    <ul>
                        <li><strong>Version Control:</strong> Git, GitHub/GitLab</li>
                        <li><strong>Package Manager:</strong> NPM, Yarn</li>
                        <li><strong>Build Tools:</strong> Webpack, Vite</li>
                        <li><strong>CSS Preprocessor:</strong> SASS/SCSS</li>
                        <li><strong>UI Framework:</strong> Bootstrap, Tailwind CSS, Material-UI</li>
                    </ul>

                    <h2>Lời khuyên cho người mới bắt đầu</h2>
                    <p>
                        Dưới đây là một số lời khuyên hữu ích dành cho bạn:
                    </p>
                    <ol>
                        <li><strong>Học đều đặn mỗi ngày:</strong> Dành ít nhất 2-3 giờ mỗi ngày để học và thực hành.</li>
                        <li><strong>Làm dự án thực tế:</strong> Áp dụng kiến thức vào các dự án cá nhân để tích lũy kinh nghiệm.</li>
                        <li><strong>Đọc tài liệu chính thức:</strong> Luôn tham khảo documentation của các công nghệ bạn đang học.</li>
                        <li><strong>Tham gia cộng đồng:</strong> Kết nối với các developer khác để học hỏi và giải đáp thắc mắc.</li>
                        <li><strong>Đừng học quá nhiều thứ cùng lúc:</strong> Tập trung vào một công nghệ, học thật kỹ trước khi chuyển sang cái khác.</li>
                    </ol>

                    <h2>Kết luận</h2>
                    <p>
                        Học lập trình Frontend không khó, chỉ cần bạn có lộ trình rõ ràng và kiên trì thực hành. 
                        Hy vọng bài viết này đã cung cấp cho bạn cái nhìn tổng quan về lộ trình học Frontend. 
                        Chúc bạn thành công trên con đường trở thành một Frontend Developer!
                    </p>
                </div>

                <!-- Tags -->
                <div class="mt-5 mb-4">
                    <h5 class="mb-3">Tags:</h5>
                    <a href="#" class="badge bg-secondary me-2 mb-2 text-decoration-none">Frontend</a>
                    <a href="#" class="badge bg-secondary me-2 mb-2 text-decoration-none">Lộ trình học</a>
                    <a href="#" class="badge bg-secondary me-2 mb-2 text-decoration-none">HTML</a>
                    <a href="#" class="badge bg-secondary me-2 mb-2 text-decoration-none">CSS</a>
                    <a href="#" class="badge bg-secondary me-2 mb-2 text-decoration-none">JavaScript</a>
                    <a href="#" class="badge bg-secondary me-2 mb-2 text-decoration-none">ReactJS</a>
                </div>

                <!-- Share Buttons -->
                <div class="mb-5 pb-5 border-bottom">
                    <h5 class="mb-3">Chia sẻ bài viết:</h5>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-primary btn-sm">
                            <i class="fab fa-facebook-f me-2"></i>Facebook
                        </a>
                        <a href="#" class="btn btn-info btn-sm text-white">
                            <i class="fab fa-twitter me-2"></i>Twitter
                        </a>
                        <a href="#" class="btn btn-success btn-sm">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                        </a>
                        <a href="#" class="btn btn-secondary btn-sm">
                            <i class="fas fa-link me-2"></i>Copy Link
                        </a>
                    </div>
                </div>

                <!-- Related Posts -->
                <div class="mt-5">
                    <h3 class="mb-4">Bài viết liên quan</h3>
                    <div class="row g-3">
                        @for($i = 1; $i <= 3; $i++)
                        <div class="col-md-4">
                            <a href="#" class="text-decoration-none">
                                <div class="card h-100">
                                    <img src="{{ asset('images/Banner_web_Javascript.png') }}" 
                                         class="card-img-top" 
                                         alt="Related post"
                                         style="height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        <h6 class="card-title">JavaScript ES6+ - Những tính năng bạn cần biết</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>28/11/2025
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .article-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
    }

    .article-content h2 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #2c3e50;
        font-weight: 600;
    }

    .article-content h3 {
        margin-top: 1.5rem;
        margin-bottom: 0.8rem;
        color: #34495e;
        font-weight: 600;
    }

    .article-content p {
        margin-bottom: 1.2rem;
    }

    .article-content ul, .article-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }

    .article-content li {
        margin-bottom: 0.8rem;
    }

    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }

    .breadcrumb-item a {
        color: #007bff;
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        text-decoration: underline;
    }

    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
        font-size: 0.9rem;
    }
</style>
@endpush
