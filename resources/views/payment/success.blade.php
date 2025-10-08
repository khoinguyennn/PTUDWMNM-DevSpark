@extends('layouts.app')

@section('title', 'Thanh toán thành công')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h2 class="text-success mb-3">Thanh toán thành công!</h2>
                    
                    <p class="text-muted mb-4">
                        Cảm ơn bạn đã thanh toán. Bạn đã được đăng ký vào khóa học thành công.
                    </p>

                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>Về trang chủ
                        </a>
                        <a href="#" class="btn btn-primary" onclick="goToMyCourses()">
                            <i class="fas fa-book me-2"></i>Khóa học của tôi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function goToMyCourses() {
    // Redirect to user's enrolled courses page
    // You can implement this based on your routing structure
    window.location.href = "{{ route('home') }}";
}
</script>
@endsection
