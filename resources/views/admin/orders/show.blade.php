@extends('admin.layout')

@section('title', 'Chi tiết Đơn hàng #' . ($order->order_code ?? $order->id))
@section('page-title', 'Chi tiết Đơn hàng #' . ($order->order_code ?? $order->id))

@section('content')
    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Thông tin đơn hàng</h5>
                    <div>
                        @if($order->status == 'completed' || $order->status == 'paid')
                            <span class="badge bg-success fs-6">Đã thanh toán</span>
                        @elseif($order->status == 'pending')
                            <span class="badge bg-warning fs-6">Chờ thanh toán</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge bg-danger fs-6">Đã hủy</span>
                        @else
                            <span class="badge bg-secondary fs-6">{{ ucfirst($order->status) }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Mã đơn hàng:</td>
                                    <td>#{{ $order->order_code ?? $order->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Ngày tạo:</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Phương thức thanh toán:</td>
                                    <td>
                                        <span class="badge bg-info">Chuyển khoản</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Tổng tiền:</td>
                                    <td class="text-primary fw-bold fs-5">{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Trạng thái:</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                                                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Danh sách khóa học</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Khóa học</th>
                                    <th>Giảng viên</th>
                                    <th class="text-end">Giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->course && $item->course->thumbnail)
                                                <img src="{{ asset('storage/' . $item->course->thumbnail) }}"
                                                     alt="{{ $item->course->title }}"
                                                     class="rounded me-3" style="width: 60px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center"
                                                     style="width: 60px; height: 40px;">
                                                    <i class="fas fa-book text-white"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $item->course->title ?? 'Khóa học đã bị xóa' }}</div>
                                                @if($item->course)
                                                    <small class="text-muted">{{ Str::limit($item->course->description, 60) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->course && $item->course->instructor)
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user-tie me-2 text-muted"></i>
                                                {{ $item->course->instructor->name }}
                                            </div>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold">{{ number_format($item->price, 0, ',', '.') }} đ</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        Không có khóa học nào trong đơn hàng này
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($order->orderItems->count() > 0)
                            <tfoot>
                                <tr class="table-active">
                                    <th colspan="2" class="text-end">Tổng cộng:</th>
                                    <th class="text-end text-primary">{{ number_format($order->total_amount, 0, ',', '.') }} đ</th>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Thông tin khách hàng</h5>
                </div>
                <div class="card-body">
                    @if($order->user)
                        <!-- <div class="text-center mb-3">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center"
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-user text-white fa-2x"></i>
                            </div>
                        </div> -->

                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Tên:</td>
                                <td>{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email:</td>
                                <td>{{ $order->user->email }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Vai trò:</td>
                                <td>
                                    @if($order->user->role == 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif($order->user->role == 'instructor')
                                        <span class="badge bg-warning">Giảng viên</span>
                                    @else
                                        <span class="badge bg-success">Học viên</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Ngày tham gia:</td>
                                <td>{{ $order->user->created_at->format('d/m/Y') }}</td>
                            </tr>
                        </table>

                        <!-- <div class="d-grid gap-2 mt-3">
                            <a href="{{ route('admin.users.show', $order->user) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>Xem hồ sơ khách hàng
                            </a>
                        </div> -->
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-user-slash fa-2x mb-2"></i><br>
                            Thông tin khách hàng không khả dụng
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Information -->
            @if($order->payment)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Thông tin thanh toán</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-bold">Mã giao dịch:</td>
                            <td>{{ $order->payment->transaction_id ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Phương thức:</td>
                            <td>Chuyển khoản</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Trạng thái:</td>
                            <td>
                                @if($order->payment->status == 'completed')
                                    <span class="badge bg-success">Thành công</span>
                                @elseif($order->payment->status == 'pending')
                                    <span class="badge bg-warning">Đang xử lý</span>
                                @else
                                    <span class="badge bg-danger">Thất bại</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Ngày thanh toán:</td>
                            <td>{{ $order->payment->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Hành động</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Quay lại danh sách
                        </a>

                        @if($order->status == 'cancelled')
                            <button type="button" class="btn btn-danger" onclick="deleteOrder()">
                                <i class="fas fa-trash me-1"></i>Xóa đơn hàng
                            </button>
                        @endif

                        <button type="button" class="btn btn-info" onclick="printOrder()">
                            <i class="fas fa-print me-1"></i>In đơn hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Form -->
    <form id="deleteForm" method="POST" action="{{ route('admin.orders.destroy', $order) }}" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
<script>
    function deleteOrder() {
        if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này? Hành động này không thể hoàn tác!')) {
            document.getElementById('deleteForm').submit();
        }
    }

    function printOrder() {
        window.print();
    }
</script>

<style>
@media print {
    .card-header, .btn, .sidebar, .navbar {
        display: none !important;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
    }

    .main-content {
        margin-left: 0 !important;
        margin-top: 0 !important;
    }
}
</style>
@endpush
