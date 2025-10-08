@extends('layouts.app')

@section('title', 'Thanh toán bị hủy')

@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-times-circle text-warning" style="font-size: 4rem;"></i>
                    </div>

                    <h2 class="text-warning mb-3">Thanh toán bị hủy</h2>

                    <p class="text-muted mb-4">
                        Bạn đã hủy quá trình thanh toán. Không có giao dịch nào được thực hiện.
                    </p>

                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>Về trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
