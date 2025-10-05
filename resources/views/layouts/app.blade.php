<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DevStark - Học Lập Trình Để Đi Làm')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0BBAF4;
            --primary-dark: #5CB3D9;
            --secondary-color: #FF6B35;
            --gradient-1: linear-gradient(135deg, #4fa8da 0%, #7dd3fc 100%);
            --gradient-2: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
            --gradient-3: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
            --border-radius: 12px;
            --box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            --sidebar-width: 250px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.5;
            color: var(--text-dark);
            font-size: 14px;
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - 70px);
            background: white;
            border-right: 1px solid #e9ecef;
            z-index: 10;
            overflow-y: auto;
            padding: 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            border-bottom: 1px solid #f0f0f0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(11, 186, 244, 0.1);
            color: var(--primary-dark);
            border-right: 3px solid var(--primary-color);
        }

        .sidebar-menu i {
            width: 20px;
            margin-right: 12px;
            font-size: 16px;
        }

        /* Header */
        .navbar {
            background: white;
            border-bottom: 1px solid #e9ecef;
            padding: 0.5rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            height: 70px;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-dark) !important;
            display: flex;
            align-items: center;
        }

        .navbar-brand .logo {
            width: 35px;
            height: 35px;
            background: var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            font-weight: 700;
            color: var(--text-dark);
            font-size: 1rem;
            overflow: hidden;
        }

        .navbar-brand .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .search-container {
            flex: 1;
            max-width: 500px;
            margin: 0 20px;
        }

        .search-form {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 10px 45px 10px 15px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: white;
            box-shadow: 0 0 0 3px rgba(11, 186, 244, 0.1);
        }

        .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--primary-color);
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background: var(--primary-dark);
            color: white;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 20px;
            padding: 8px 20px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-dark);
            border-radius: 20px;
            padding: 6px 18px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: 70px;
            min-height: calc(100vh - 70px);
        }

        /* Hero Section */
        .hero-section {
            min-height: 35vh;
            position: relative;
            overflow: hidden;
        }

        .hero-slide {
            min-height: 35vh;
            display: flex;
            align-items: center;
            position: relative;
            border-radius: 0 0 30px 30px;
            overflow: hidden;
            padding: 20px 0;
        }

        .hero-slide.slide-1 {
            background: var(--gradient-1);
        }

        .hero-slide.slide-2 {
            background: var(--gradient-2);
        }

        .hero-slide.slide-3 {
            background: var(--gradient-3);
        }

        .hero-content {
            padding: 10px 0;
            margin-left: 40px;
            padding-left: 20px;
        }

        .hero-content h1 {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
            line-height: 1.3;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .hero-content p {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 1.5rem;
            line-height: 1.5;
            max-width: 90%;
        }

        .hero-content .learning-outcomes {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-content .learning-outcomes h6 {
            font-size: 1rem;
            margin-bottom: 15px;
            color: white;
        }

        .hero-content .learning-outcomes ul li {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 8px;
        }

        .hero-image {
            position: relative;
            z-index: 2;
            padding: 10px;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            max-height: 220px;
            object-fit: cover;
        }

        .placeholder-image {
            background: rgba(255, 255, 255, 0.15) !important;
            border: 2px solid rgba(255, 255, 255, 0.3) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 1.5rem;
        }

        .hero-buttons .btn {
            font-size: 0.9rem;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .hero-buttons .btn-primary {
            background: rgba(255, 255, 255, 0.9);
            color: var(--text-dark);
            border-color: rgba(255, 255, 255, 0.9);
        }

        .hero-buttons .btn-primary:hover {
            background: white;
            color: var(--text-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .hero-buttons .btn-outline-light {
            background: transparent;
            color: white;
            border-color: rgba(255, 255, 255, 0.7);
        }

        .hero-buttons .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-color: white;
            transform: translateY(-2px);
        }

        /* Course Cards */
        .course-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .course-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--secondary-color);
            color: white !important;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 600;
            z-index: 1;
        }

        .course-badge * {
            color: white !important;
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
            background: none;
        }

        .course-gradient-2 {
            background: none;
        }

        .course-gradient-3 {
            background: none;
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

        .price-original {
            text-decoration: line-through;
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        .price-current {
            color: var(--secondary-color);
            font-weight: 700;
            font-size: 1rem;
        }

        /* Section Styles */
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

        /* Carousel Controls */
        .carousel-control-prev,
        .carousel-control-next {
            width: 4%;
            opacity: 0.7;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 1;
        }

        .carousel-indicators button {
            background-color: var(--primary-color);
            border: none;
            border-radius: 50%;
            width: 8px;
            height: 8px;
            margin: 0 3px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .search-container {
                display: none;
            }

            .hero-section {
                min-height: 30vh;
            }

            .hero-slide {
                min-height: 30vh;
                padding: 15px 0;
            }

            .hero-content {
                text-align: center;
                margin-bottom: 15px;
                margin-left: 0;
                padding-left: 0;
            }

            .hero-content h1 {
                font-size: 1.6rem;
                margin-bottom: 0.8rem;
            }

            .hero-content p {
                font-size: 0.9rem;
                max-width: 100%;
                margin-bottom: 1.2rem;
            }

            .hero-buttons {
                justify-content: center;
                flex-direction: column;
                align-items: center;
                margin-top: 1rem;
            }

            .hero-buttons .btn {
                width: 100%;
                max-width: 250px;
                font-size: 0.85rem;
                padding: 8px 18px;
            }

            .hero-image {
                padding: 5px;
                margin-top: 15px;
            }

            .hero-image img,
            .placeholder-image {
                max-height: 160px !important;
                width: 100% !important;
                max-width: 250px !important;
            }

            .section-title {
                font-size: 1.3rem;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Footer */
        .footer {
            background: var(--text-dark);
            color: white;
            padding: 2rem 0 1rem;
            margin-top: 3rem;
            margin-left: 0;
            width: 100%;
            position: relative;
            z-index: 50;
        }

        .footer h5 {
            color: white;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .footer p {
            color: rgba(255, 255, 255, 0.8) !important;
            font-size: 14px;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 14px;
        }

        .footer a:hover {
            color: var(--primary-color);
        }

        .footer-brand {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .footer-logo {
            width: 30px;
            height: 30px;
            background: var(--primary-color);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            overflow: hidden;
        }

        .footer-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 6px;
        }

        /* Mobile menu toggle */
        .mobile-menu-toggle {
            display: none;
        }

        /* Dropdown customization */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 12px;
            padding: 0.5rem 0;
            min-width: 200px;
        }

        .dropdown-item {
            padding: 0.75rem 1.25rem;
            font-size: 14px;
            border-radius: 0;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: rgba(11, 186, 244, 0.1);
            color: var(--primary-dark);
        }

        .dropdown-header {
            font-size: 12px;
            color: var(--text-muted);
            padding: 0.5rem 1.25rem;
            margin-bottom: 0;
        }

        /* Flash messages */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-size: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(40, 167, 69, 0.05) 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error, .alert-danger {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-warning {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 193, 7, 0.05) 100%);
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        .alert-info {
            background: linear-gradient(135deg, rgba(23, 162, 184, 0.1) 0%, rgba(23, 162, 184, 0.05) 100%);
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }

            .footer {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Header -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="d-flex align-items-center w-100">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    <div class="logo">
                        <img src="{{ asset('images/logo.jpg ') }}" alt="DevStark Logo">
                    </div>
                    DevStark
                </a>

                <!-- Mobile menu toggle -->
                <button class="btn mobile-menu-toggle d-md-none ms-2" type="button" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Search Bar -->
                <div class="search-container d-none d-md-block">
                    <form class="search-form">
                        <input type="text" class="search-input" placeholder="Tìm kiếm khóa học...">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- User Actions -->
                <div class="ms-auto d-flex align-items-center gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Đăng ký</a>
                    @else
                        <!-- User Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-2"></i>
                                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <h6 class="dropdown-header">
                                        <i class="fas fa-user me-2"></i>
                                        {{ Auth::user()->name }}
                                    </h6>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user me-2"></i>
                                        Thông tin cá nhân
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-book me-2"></i>
                                        Khóa học của tôi
                                    </a>
                                </li>
                                @if(Auth::user()->role === 'admin')
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-cog me-2"></i>
                                            Quản trị hệ thống
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>
                                            Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('home') }}" class="active">
                    <i class="fas fa-home"></i>
                    Trang chủ
                </a>
            </li>
            <li>
                <a href="#roadmap">
                    <i class="fas fa-road"></i>
                    Lộ trình
                </a>
            </li>
            <li>
                <a href="#articles">
                    <i class="fas fa-newspaper"></i>
                    Bài viết
                </a>
            </li>
            <li>
                <a href="#about">
                    <i class="fas fa-info-circle"></i>
                    Giới thiệu
                </a>
            </li>
            <li>
                <a href="#contact">
                    <i class="fas fa-phone"></i>
                    Liên hệ
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="container mt-3">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="container mt-3">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="footer-brand">
                        <div class="footer-logo">
                            <img src="{{ asset('images/logo.jpg') }}" alt="DevStark Logo">
                        </div>
                        <h5 class="mb-0">DevStark Academy</h5>
                    </div>
                    <p class="text-muted">Nền tảng học lập trình trực tuyến hàng đầu với các khóa học chất lượng cao.</p>
                </div>
                <div class="col-md-2 mb-3">
                    <h5>Khóa học</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Frontend</a></li>
                        <li><a href="#">Backend</a></li>
                        <li><a href="#">Mobile</a></li>
                        <li><a href="#">DevOps</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-3">
                    <h5>Lộ trình</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Web Developer</a></li>
                        <li><a href="#">Full Stack</a></li>
                        <li><a href="#">Data Science</a></li>
                        <li><a href="#">AI Engineer</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-3">
                    <h5>Hỗ trợ</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Trung tâm trợ giúp</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Liên hệ</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-3">
                    <h5>Theo dõi</h5>
                    <div class="d-flex gap-2">
                        <a href="#" class="text-decoration-none">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="my-3">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; 2025 DevStark Academy. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Active menu item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.sidebar-menu a');

            menuItems.forEach(item => {
                if (item.getAttribute('href') === currentPath) {
                    menuItems.forEach(i => i.classList.remove('active'));
                    item.classList.add('active');
                }
            });
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

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
