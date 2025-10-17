@extends('layouts.app')

@section('title', 'Thông tin cá nhân')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-user text-white fa-2x"></i>
                    </div>
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="card-text text-muted">{{ $user->email }}</p>
                    <span class="badge bg-success">
                        @if($user->role == 'admin')
                            Quản trị viên
                        @elseif($user->role == 'instructor')
                            Giảng viên
                        @else
                            Học viên
                        @endif
                    </span>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Thống kê</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-12 mb-3">
                            <div class="border-bottom pb-2">
                                <h4 class="text-primary mb-0">{{ $enrolledCoursesCount }}</h4>
                                <small class="text-muted">Khóa học đã đăng ký</small>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="border-bottom pb-2">
                                <h4 class="text-success mb-0">{{ $ordersCount }}</h4>
                                <small class="text-muted">Đơn hàng thành công</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <h4 class="text-info mb-0">{{ number_format($totalSpent, 0, ',', '.') }} đ</h4>
                            <small class="text-muted">Tổng chi tiêu</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Profile Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Thông tin cá nhân</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Vai trò</label>
                                <input type="text" class="form-control" value="
                                    @if($user->role == 'admin')
                                        Quản trị viên
                                    @elseif($user->role == 'instructor')
                                        Giảng viên
                                    @else
                                        Học viên
                                    @endif
                                " readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="created_at" class="form-label">Ngày tham gia</label>
                                <input type="text" class="form-control"
                                       value="{{ $user->created_at->format('d/m/Y') }}" readonly>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Cập nhật thông tin
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Đổi mật khẩu</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="current_password" class="form-label">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                       id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="password" class="form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ và số.</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" class="form-control"
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key me-1"></i>Đổi mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Orders -->
            <!-- @if($recentOrders->count() > 0)
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Đơn hàng gần đây</h5>
                    <a href="{{ route('orders.history') }}" class="btn btn-outline-primary btn-sm">
                        Xem tất cả
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Khóa học</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày mua</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td><strong>#{{ $order->order_code ?? $order->id }}</strong></td>
                                    <td>
                                        @foreach($order->orderItems as $item)
                                            <div>{{ $item->course->title ?? 'N/A' }}</div>
                                        @endforeach
                                    </td>
                                    <td><strong>{{ number_format($order->total_amount, 0, ',', '.') }} đ</strong></td>
                                    <td>
                                        @if($order->status == 'completed' || $order->status == 'paid')
                                            <span class="badge bg-success">Thành công</span>
                                        @elseif($order->status == 'pending')
                                            <span class="badge bg-warning">Chờ thanh toán</span>
                                        @else
                                            <span class="badge bg-danger">Đã hủy</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif -->
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    .bg-primary {
        background-color: #007bff !important;
    }

    .text-primary {
        color: #007bff !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .text-info {
        color: #17a2b8 !important;
    }

    .border-bottom {
        border-bottom: 1px solid #dee2e6 !important;
    }

    .form-text {
        font-size: 0.875em;
        color: #6c757d;
    }
</style>
@endpush
