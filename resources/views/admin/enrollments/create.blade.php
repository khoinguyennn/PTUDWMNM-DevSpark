@extends('admin.layout')

@section('title', 'Ghi danh mới')
@section('page-title', 'Tạo ghi danh mới')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Có lỗi xảy ra:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-plus me-2"></i>
                    Ghi danh học viên vào khóa học
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.enrollments.store') }}" method="POST" id="enrollmentForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">
                                    <i class="fas fa-user me-1"></i>
                                    Chọn học viên <span class="text-danger">*</span>
                                </label>
                                <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                    <option value="">-- Chọn học viên --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Chỉ hiển thị các tài khoản có vai trò "Học viên"
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="course_id" class="form-label">
                                    <i class="fas fa-book me-1"></i>
                                    Chọn khóa học <span class="text-danger">*</span>
                                </label>
                                <select name="course_id" id="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                                    <option value="">-- Chọn khóa học --</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->title }} ({{ number_format($course->price) }}đ)
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Lưu ý:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Ghi danh sẽ được tạo trực tiếp vào hệ thống</li>
                                <li>Học viên sẽ có thể truy cập khóa học ngay lập tức</li>
                                <li>Kiểm tra kỹ thông tin trước khi xác nhận</li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.enrollments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Quay lại
                        </a>
                        <div>
                            <button type="reset" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-undo me-1"></i>
                                Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus me-1"></i>
                                Tạo ghi danh
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('enrollmentForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function(e) {
        const userId = document.getElementById('user_id').value;
        const courseId = document.getElementById('course_id').value;
        
        if (!userId || !courseId) {
            e.preventDefault();
            alert('Vui lòng chọn đầy đủ học viên và khóa học');
            return false;
        }
        
        // Disable submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang xử lý...';
    });
});
</script>
@endpush
