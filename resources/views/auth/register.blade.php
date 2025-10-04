@extends('layouts.auth')

@section('title', 'Đăng ký - DevStark')

@section('content')
<div class="auth-content">
    <!-- Left Panel - Brand -->
    <div class="auth-brand" style="background: var(--gradient-2);">
        <div class="brand-logo">
            <img src="{{ asset('images/logo.jpg') }}" alt="DevStark Logo">
        </div>
        
        <h1 class="brand-title">Tham gia DevStark</h1>
        <p class="brand-subtitle">Bắt đầu hành trình lập trình của bạn ngay hôm nay!</p>
        
        <ul class="brand-features">
            <li>
                <i class="fas fa-play-circle"></i>
                Truy cập miễn phí hàng trăm khóa học
            </li>
            <li>
                <i class="fas fa-trophy"></i>
                Nhận phần thưởng khi hoàn thành
            </li>
        </ul>
    </div>

    <!-- Right Panel - Register Form -->
    <div class="auth-form">
        <div class="form-header">
            <h2 class="form-title">Đăng ký tài khoản</h2>
            <p class="form-subtitle">Tạo tài khoản để bắt đầu học lập trình</p>
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

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">Họ và tên</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-user"></i>
                    </span>
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        placeholder="Nhập họ tên"
                        required
                        autocomplete="name"
                    >
                </div>
            </div>

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
                        placeholder="Nhập email"
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
                        placeholder="Mật khẩu (tối thiểu 6 ký tự)"
                        required
                        autocomplete="new-password"
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password', 'togglePasswordIcon')">
                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password_confirmation" 
                        name="password_confirmation"
                        placeholder="Nhập lại mật khẩu"
                        required
                        autocomplete="new-password"
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'togglePasswordConfirmIcon')">
                        <i class="fas fa-eye" id="togglePasswordConfirmIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                    <label class="form-check-label" for="terms">
                        Tôi đồng ý với 
                        <a href="#" class="auth-link">Điều khoản dịch vụ</a> 
                        và 
                        <a href="#" class="auth-link">Chính sách bảo mật</a>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-auth">
                <i class="fas fa-user-plus me-2"></i>
                Đăng ký
            </button>

            <!-- Login Link -->
            <div class="text-center">
                <span class="text-muted" style="font-size: 0.9rem;">Đã có tài khoản? </span>
                <a href="{{ route('login') }}" class="auth-link">
                    Đăng nhập ngay
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
