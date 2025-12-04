@extends('admin.layout')

@section('title', 'Quản lý Ghi danh')
@section('page-title', 'Quản lý Ghi danh')

@section('content')
<div class="row mb-4">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Tổng ghi danh
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalEnrollments) }}</div>
                    </div>
                    <div class="text-primary" style="font-size: 2rem; opacity: 0.3;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Doanh thu
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalRevenue) }}đ</div>
                    </div>
                    <div class="text-success" style="font-size: 2rem; opacity: 0.3;">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Học viên duy nhất
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($uniqueStudents) }}</div>
                    </div>
                    <div class="text-info" style="font-size: 2rem; opacity: 0.3;">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Ghi danh hôm nay
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($todayEnrollments) }}</div>
                    </div>
                    <div class="text-warning" style="font-size: 2rem; opacity: 0.3;">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter and Search -->
<div class="card mb-4">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Bộ lọc và Tìm kiếm</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.enrollments.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Tìm theo tên, email, khóa học..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="course_id" class="form-select">
                        <option value="">Tất cả khóa học</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ Str::limit($course->title, 30) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="date_from" 
                           placeholder="Từ ngày" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="date_to" 
                           placeholder="Đến ngày" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                    <a href="{{ route('admin.enrollments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Enrollments Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Ghi danh</h6>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary">{{ $enrollments->total() }} ghi danh</span>
            <a href="{{ route('admin.enrollments.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Tạo ghi danh mới
            </a>
        </div>
    </div>
    <div class="card-body">
        @if($enrollments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Học viên</th>
                            <th>Email</th>
                            <th>Khóa học</th>
                            <th>Giảng viên</th>
                            <th>Giá khóa học</th>
                            <th>Ngày ghi danh</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $index => $enrollment)
                        <tr>
                            <td>{{ $enrollments->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold">{{ $enrollment->user_name }}</div>
                                <small class="text-muted">ID: {{ $enrollment->user_id }}</small>
                            </td>
                            <td>{{ $enrollment->user_email }}</td>
                            <td>
                                <div class="fw-bold">{{ Str::limit($enrollment->course_title, 40) }}</div>
                                <small class="text-muted">ID: {{ $enrollment->course_id }}</small>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $enrollment->instructor_name ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ number_format($enrollment->course_price) }}đ</span>
                            </td>
                            <td>
                                <div>{{ $enrollment->enrollment_date->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $enrollment->enrollment_date->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.enrollments.show', [$enrollment->user_id, $enrollment->course_id]) }}" 
                                       class="btn btn-outline-primary" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" 
                                            onclick="confirmDelete({{ $enrollment->user_id }}, {{ $enrollment->course_id }})"
                                            title="Hủy ghi danh">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($enrollments->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Hiển thị {{ $enrollments->firstItem() }} đến {{ $enrollments->lastItem() }} 
                        trong tổng số {{ $enrollments->total() }} kết quả
                    </div>
                    <nav aria-label="Phân trang ghi danh">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            @if ($enrollments->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">‹ Trước</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $enrollments->appends(request()->query())->previousPageUrl() }}">‹ Trước</a></li>
                            @endif

                            {{-- Pagination Elements --}}
                            @php
                                $start = max($enrollments->currentPage() - 2, 1);
                                $end = min($start + 4, $enrollments->lastPage());
                                $start = max($end - 4, 1);
                            @endphp

                            @if($start > 1)
                                <li class="page-item"><a class="page-link" href="{{ $enrollments->appends(request()->query())->url(1) }}">1</a></li>
                                @if($start > 2)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                            @endif

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $enrollments->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $enrollments->appends(request()->query())->url($i) }}">{{ $i }}</a></li>
                                @endif
                            @endfor

                            @if($end < $enrollments->lastPage())
                                @if($end < $enrollments->lastPage() - 1)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                                <li class="page-item"><a class="page-link" href="{{ $enrollments->appends(request()->query())->url($enrollments->lastPage()) }}">{{ $enrollments->lastPage() }}</a></li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($enrollments->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $enrollments->appends(request()->query())->nextPageUrl() }}">Tiếp ›</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Tiếp ›</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Không có ghi danh nào</h5>
                <p class="text-muted">Chưa có học viên nào ghi danh khóa học.</p>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận hủy ghi danh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn hủy ghi danh này?</p>
                <p class="text-danger"><strong>Lưu ý:</strong> Hành động này sẽ xóa toàn bộ tiến độ học tập của học viên!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(userId, courseId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/enrollments/${userId}/${courseId}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endpush
