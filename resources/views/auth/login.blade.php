@extends('layouts.auth')

@section('title', 'Đăng nhập - DevStark')

@section('content')
<div class="auth-content">
    <!-- Left Panel - Brand -->
    <div class="auth-brand">
        <div class="brand-logo">
            <img src="{{ asset('images/logo.jpg') }}" alt="DevStark Logo">
        </div>

        <h1 class="brand-title">DevStark</h1>
        <p class="brand-subtitle">Nền tảng học lập trình hàng đầu Việt Nam</p>

        <ul class="brand-features">
            <li>
                <i class="fas fa-graduation-cap"></i>
                Học từ các chuyên gia hàng đầu
            </li>
            <li>
                <i class="fas fa-users"></i>
                Tham gia cộng đồng 10,000+ học viên
            </li>
            <li>
                <i class="fas fa-laptop-code"></i>
                Học thực hành với dự án thực tế
            </li>
        </ul>
    </div>

    <!-- Right Panel - Login Form -->
    <div class="auth-form">
        <div class="form-header">
            <h2 class="form-title">Đăng nhập</h2>
            <p class="form-subtitle">Chào mừng bạn quay trở lại!</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong><i class="fas fa-exclamation-triangle me-2"></i>Có lỗi xảy ra:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Nhập email của bạn"
                        required
                        autocomplete="email"
                    >
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="password"
                        name="password"
                        placeholder="Nhập mật khẩu"
                        required
                        autocomplete="current-password"
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password', 'togglePasswordIcon')">
                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Ghi nhớ đăng nhập
                    </label>
                </div>
                <a href="#" class="auth-link" style="font-size: 0.85rem;">
                    Quên mật khẩu?
                </a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-auth">
                <i class="fas fa-sign-in-alt me-2"></i>
                Đăng nhập
            </button>

            <!-- Register Link -->
            <div class="text-center">
                <span class="text-muted" style="font-size: 0.9rem;">Chưa có tài khoản? </span>
                <a href="{{ route('register') }}" class="auth-link">
                    Đăng ký ngay
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
