@extends('layouts.app')

@section('title', 'Thanh toán thành công')

@section('content')
<div class="container" style="margin-top: 100px;">
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
                        @if(isset($course) && $course)
                            <br><strong>{{ $course->title }}</strong>
                        @endif
                    </p>

                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>Về trang chủ
                        </a>
                        @if(isset($course) && $course)
                            <a href="{{ route('course.learn', $course->id) }}" class="btn btn-primary">
                                <i class="fas fa-play me-2"></i>Học ngay
                            </a>
                        @else
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-book me-2"></i>Khóa học của tôi
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('payment_success'))
        // Auto-trigger SweetAlert for payment success
        Swal.fire({
            title: 'Thanh toán thành công! 🎉',
            text: 'Bạn đã được đăng ký vào khóa học thành công. Chúc bạn học tập hiệu quả!',
            icon: 'success',
            showCancelButton: false,
            confirmButtonText: '{{ isset($course) && $course ? "Học ngay" : "Về trang chủ" }}',
            confirmButtonColor: '#0BBAF4',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                @if(isset($course) && $course)
                    window.location.href = "{{ route('course.learn', $course->id ?? '') }}";
                @else
                    window.location.href = "{{ route('home') }}";
                @endif
            }
        });
    @endif
});
</script>


@endpush
