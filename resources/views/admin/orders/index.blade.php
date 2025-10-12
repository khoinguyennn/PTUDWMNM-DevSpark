@extends('admin.layout')

@section('title', 'Quản lý Đơn hàng')
@section('page-title', 'Quản lý Đơn hàng')

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng đơn hàng
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total'] }}
                            </div>
                        </div>
                        <div class="text-primary" style="font-size: 2rem; opacity: 0.3;">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Đã thanh toán
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['paid'] }}
                            </div>
                        </div>
                        <div class="text-success" style="font-size: 2rem; opacity: 0.3;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Chờ thanh toán
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['pending'] }}
                            </div>
                        </div>
                        <div class="text-warning" style="font-size: 2rem; opacity: 0.3;">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tổng doanh thu
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total_revenue'], 0, ',', '.') }} đ
                            </div>
                        </div>
                        <div class="text-info" style="font-size: 2rem; opacity: 0.3;">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Mã đơn, tên khách hàng, email...">
                </div>
                
                <div class="col-md-2">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="user_id" class="form-label">Khách hàng</label>
                    <select class="form-select" id="user_id" name="user_id">
                        <option value="">Tất cả</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="start_date" class="form-label">Từ ngày</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" 
                           value="{{ request('start_date') }}">
                </div>

                <div class="col-md-2">
                    <label for="end_date" class="form-label">Đến ngày</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" 
                           value="{{ request('end_date') }}">
                </div>

                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list me-2"></i>Danh sách đơn hàng</span>
            <div class="d-flex gap-2">
                <button class="btn btn-success btn-sm" onclick="exportOrders()">
                    <i class="fas fa-download me-1"></i>Xuất Excel
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Khóa học</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Phương thức</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>
                                <strong>#{{ $order->order_code ?? $order->id }}</strong>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $order->user->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>
                                @if($order->orderItems->count() > 0)
                                    @foreach($order->orderItems as $item)
                                        <div class="mb-1">
                                            <small>{{ $item->course->title ?? 'N/A' }}</small>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-muted">Không có khóa học</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ number_format($order->total_amount, 0, ',', '.') }} đ</strong>
                            </td>
                            <td>
                                @if($order->status == 'completed' || $order->status == 'paid')
                                    <span class="badge bg-success">Đã thanh toán</span>
                                @elseif($order->status == 'pending')
                                    <span class="badge bg-warning">Chờ thanh toán</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="badge bg-danger">Đã hủy</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">Chuyển khoản</span>
                            </td>
                            <td>
                                <div>
                                    {{ $order->created_at->format('d/m/Y') }}<br>
                                    <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="btn btn-sm btn-info" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-warning dropdown-toggle" 
                                                data-bs-toggle="dropdown" title="Cập nhật trạng thái">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $order->id }}, 'pending')">Chờ thanh toán</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $order->id }}, 'paid')">Đã thanh toán</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $order->id }}, 'completed')">Hoàn thành</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $order->id }}, 'cancelled')">Đã hủy</a></li>
                                        </ul>
                                    </div>

                                    @if($order->status == 'cancelled')
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="deleteOrder({{ $order->id }})" title="Xóa đơn hàng">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                Không có đơn hàng nào
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Hiển thị {{ $orders->firstItem() }} đến {{ $orders->lastItem() }} 
                        trong tổng số {{ $orders->total() }} kết quả
                    </div>
                    <nav aria-label="Phân trang đơn hàng">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            @if ($orders->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">‹ Trước</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $orders->appends(request()->query())->previousPageUrl() }}">‹ Trước</a></li>
                            @endif

                            {{-- Pagination Elements --}}
                            @php
                                $start = max($orders->currentPage() - 2, 1);
                                $end = min($start + 4, $orders->lastPage());
                                $start = max($end - 4, 1);
                            @endphp

                            @if($start > 1)
                                <li class="page-item"><a class="page-link" href="{{ $orders->appends(request()->query())->url(1) }}">1</a></li>
                                @if($start > 2)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                            @endif

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $orders->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $orders->appends(request()->query())->url($i) }}">{{ $i }}</a></li>
                                @endif
                            @endfor

                            @if($end < $orders->lastPage())
                                @if($end < $orders->lastPage() - 1)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                                <li class="page-item"><a class="page-link" href="{{ $orders->appends(request()->query())->url($orders->lastPage()) }}">{{ $orders->lastPage() }}</a></li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($orders->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $orders->appends(request()->query())->nextPageUrl() }}">Tiếp ›</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Tiếp ›</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>

    <!-- Hidden Forms for Actions -->
    <form id="updateStatusForm" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" id="statusInput">
    </form>

    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('styles')
<style>
    /* Custom pagination styles */
    .pagination {
        margin: 0;
        --bs-pagination-padding-x: 0.75rem;
        --bs-pagination-padding-y: 0.375rem;
        --bs-pagination-font-size: 0.875rem;
        --bs-pagination-color: #4e73df;
        --bs-pagination-bg: #fff;
        --bs-pagination-border-width: 1px;
        --bs-pagination-border-color: #dee2e6;
        --bs-pagination-border-radius: 0.25rem;
        --bs-pagination-hover-color: #224abe;
        --bs-pagination-hover-bg: #e9ecef;
        --bs-pagination-hover-border-color: #dee2e6;
        --bs-pagination-focus-color: #224abe;
        --bs-pagination-focus-bg: #e9ecef;
        --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        --bs-pagination-active-color: #fff;
        --bs-pagination-active-bg: #4e73df;
        --bs-pagination-active-border-color: #4e73df;
        --bs-pagination-disabled-color: #6c757d;
        --bs-pagination-disabled-bg: #fff;
        --bs-pagination-disabled-border-color: #dee2e6;
    }
    
    .pagination .page-link {
        position: relative;
        display: block;
        color: var(--bs-pagination-color);
        text-decoration: none;
        background-color: var(--bs-pagination-bg);
        border: var(--bs-pagination-border-width) solid var(--bs-pagination-border-color);
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .pagination .page-link:hover {
        z-index: 2;
        color: var(--bs-pagination-hover-color);
        background-color: var(--bs-pagination-hover-bg);
        border-color: var(--bs-pagination-hover-border-color);
    }
    
    .pagination .page-link:focus {
        z-index: 3;
        color: var(--bs-pagination-focus-color);
        background-color: var(--bs-pagination-focus-bg);
        outline: 0;
        box-shadow: var(--bs-pagination-focus-box-shadow);
    }
    
    .pagination .page-item:not(:first-child) .page-link {
        margin-left: -1px;
    }
    
    .pagination .page-item.active .page-link {
        z-index: 3;
        color: var(--bs-pagination-active-color);
        background-color: var(--bs-pagination-active-bg);
        border-color: var(--bs-pagination-active-border-color);
    }
    
    .pagination .page-item.disabled .page-link {
        color: var(--bs-pagination-disabled-color);
        pointer-events: none;
        background-color: var(--bs-pagination-disabled-bg);
        border-color: var(--bs-pagination-disabled-border-color);
    }
    
    .pagination .page-item:first-child .page-link {
        border-top-left-radius: var(--bs-pagination-border-radius);
        border-bottom-left-radius: var(--bs-pagination-border-radius);
    }
    
    .pagination .page-item:last-child .page-link {
        border-top-right-radius: var(--bs-pagination-border-radius);
        border-bottom-right-radius: var(--bs-pagination-border-radius);
    }
    
    .pagination-sm {
        --bs-pagination-padding-x: 0.5rem;
        --bs-pagination-padding-y: 0.25rem;
        --bs-pagination-font-size: 0.75rem;
        --bs-pagination-border-radius: 0.2rem;
    }
    
    /* Remove any unwanted SVG icons */
    .pagination .page-link svg {
        display: none !important;
    }
</style>
@endpush

@push('scripts')
<script>
    function updateStatus(orderId, status) {
        if (confirm('Bạn có chắc chắn muốn cập nhật trạng thái đơn hàng này?')) {
            const form = document.getElementById('updateStatusForm');
            const statusInput = document.getElementById('statusInput');
            
            form.action = `/admin/orders/${orderId}/status`;
            statusInput.value = status;
            form.submit();
        }
    }

    function deleteOrder(orderId) {
        if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này? Hành động này không thể hoàn tác!')) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/orders/${orderId}`;
            form.submit();
        }
    }

    function exportOrders() {
        // Add export functionality here
        alert('Tính năng xuất Excel sẽ được phát triển trong phiên bản tiếp theo.');
    }
</script>
@endpush
