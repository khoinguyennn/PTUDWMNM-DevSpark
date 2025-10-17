@extends('layouts.app')

@section('title', 'Lịch sử đơn hàng')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-history me-2"></i>Lịch sử đơn hàng</h2>
                <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Quay lại hồ sơ
                </a>
            </div>

            <!-- Orders List -->
            <div class="card">
                <div class="card-body">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <th>Khóa học</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày mua</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <strong>#{{ $order->order_code ?? $order->id }}</strong>
                                        </td>
                                        <td>
                                            @foreach($order->orderItems as $item)
                                                <div class="mb-1">
                                                    <i class="fas fa-book me-1"></i>
                                                    {{ $item->course->title ?? 'Khóa học không tồn tại' }}
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>
                                            <strong class="text-primary">{{ number_format($order->total_amount, 0, ',', '.') }} đ</strong>
                                        </td>
                                        <td>
                                            @if($order->status == 'completed' || $order->status == 'paid')
                                                <span class="badge bg-success">Thành công</span>
                                            @elseif($order->status == 'pending')
                                                <span class="badge bg-warning">Chờ thanh toán</span>
                                            @else
                                                <span class="badge bg-danger">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($orders->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $orders->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Chưa có đơn hàng nào</h4>
                            <p class="text-muted">Bạn chưa có đơn hàng nào. Hãy khám phá các khóa học của chúng tôi!</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>Khám phá khóa học
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Removed payOrder function since action column is no longer needed
</script>
@endpush
