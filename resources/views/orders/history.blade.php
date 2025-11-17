@extends('layouts.app')

@section('title', 'Lịch sử đơn hàng')

@section('content')
<div class="container py-5 px-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-history me-2"></i>Lịch sử đơn hàng</h2>
                    @if($orders->total() > 0)
                        <p class="text-muted mb-0">Tổng cộng {{ $orders->total() }} đơn hàng</p>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    @if($orders->total() > 10)
                        <form method="GET" action="{{ route('orders.history') }}" class="d-flex align-items-center">
                            <label class="form-label me-2 mb-0 small">Hiển thị:</label>
                            <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            </select>
                        </form>
                    @endif
                    <!-- <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Quay lại hồ sơ
                    </a> -->
                </div>
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
                            <div class="pagination-wrapper">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">
                                        Hiển thị {{ $orders->firstItem() }} - {{ $orders->lastItem() }}
                                        trong tổng số {{ $orders->total() }} đơn hàng
                                    </div>
                                    <nav aria-label="Phân trang đơn hàng">
                                        {{ $orders->links('pagination::bootstrap-4') }}
                                    </nav>
                                </div>
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

@push('styles')
<style>
    .table th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
        background-color: #f8f9fa;
    }

    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }

    .badge {
        font-size: 0.75em;
        padding: 0.375rem 0.75rem;
    }

    /* Pagination Styling */
    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        color: #0BBAF4;
        border: 1px solid #dee2e6;
        padding: 8px 12px;
        margin: 0 2px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background-color: #0BBAF4;
        border-color: #0BBAF4;
        color: white;
        text-decoration: none;
    }

    .page-item.active .page-link {
        background-color: #0BBAF4;
        border-color: #0BBAF4;
        color: white;
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #fff;
        border-color: #dee2e6;
    }

    .pagination-wrapper {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-top: 20px;
    }
</style>
@endpush

@push('scripts')
<script>
    // Removed payOrder function since action column is no longer needed
</script>
@endpush
