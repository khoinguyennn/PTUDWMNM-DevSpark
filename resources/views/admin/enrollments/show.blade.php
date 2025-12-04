@extends('admin.layout')

@section('title', 'Chi tiết Ghi danh')
@section('page-title', 'Chi tiết Ghi danh')

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Enrollment Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Thông tin Ghi danh</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Thông tin Học viên</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Tên:</strong></td>
                                <td>{{ $enrollment->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $enrollment->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>ID:</strong></td>
                                <td>{{ $enrollment->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Ngày tạo tài khoản:</strong></td>
                                <td>{{ \Carbon\Carbon::parse($enrollment->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Thông tin Khóa học</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Tên khóa học:</strong></td>
                                <td>{{ $enrollment->course_title }}</td>
                            </tr>
                            <tr>
                                <td><strong>Mô tả:</strong></td>
                                <td>{{ Str::limit($enrollment->course_description, 100) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Giá khóa học:</strong></td>
                                <td>
                                    @if($enrollment->course_price > 0)
                                        <span class="badge bg-info">{{ number_format($enrollment->course_price) }}đ</span>
                                    @else
                                        <span class="badge bg-success">Miễn phí</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Giảng viên:</strong></td>
                                <td>{{ $enrollment->instructor_name ?? 'Chưa có thông tin' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrollment Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Thông tin Ghi Danh</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Ngày ghi danh:</strong></td>
                                <td>{{ \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Loại ghi danh:</strong></td>
                                <td>
                                    @if($enrollment->course_price > 0)
                                        <span class="badge bg-warning">Có phí</span>
                                    @else
                                        <span class="badge bg-success">Miễn phí</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Mã ghi danh:</strong></td>
                                <td><code>#{{ $enrollment->enrollment_id }}</code></td>
                            </tr>
                            <tr>
                                <td><strong>Trạng thái:</strong></td>
                                <td><span class="badge bg-success">Đang hoạt động</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Learning Progress -->
        @if($progress)
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Tiến độ Học tập</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="50%"><strong>Bài học đã hoàn thành:</strong></td>
                                <td>{{ $progress->completed_lessons }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tổng số bài học:</strong></td>
                                <td>{{ $progress->total_lessons }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="50%"><strong>Tiến độ:</strong></td>
                                <td>
                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar"
                                             style="width: {{ $progress->progress_percentage }}%">
                                            {{ $progress->progress_percentage }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Cập nhật cuối:</strong></td>
                                <td>
                                    @if($progress->last_completed_at)
                                        {{ \Carbon\Carbon::parse($progress->last_completed_at)->format('d/m/Y H:i') }}
                                    @else
                                        Chưa có dữ liệu
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Tiến độ Học tập</h6>
            </div>
            <div class="card-body">
                <div class="text-center py-3">
                    <i class="fas fa-clock fa-2x text-muted mb-2"></i>
                    <p class="text-muted">Học viên chưa bắt đầu học khóa học này</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Hành động</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.enrollments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại danh sách
                    </a>
                    <a href="{{ route('admin.courses.show', $courseId) }}" class="btn btn-primary">
                        <i class="fas fa-book"></i> Xem khóa học
                    </a>
                    <!-- <a href="{{ route('admin.users.show', $enrollment->id) }}" class="btn btn-info">
                        <i class="fas fa-user"></i> Xem hồ sơ học viên
                    </a> -->
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                        <i class="fas fa-trash"></i> Hủy ghi danh
                    </button>
                </div>
            </div>
        </div>

        <!-- Enrollment Timeline -->
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Thống kê</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-calendar-alt fa-2x text-primary mb-2"></i>
                        <h6>Thời gian ghi danh</h6>
                        <p class="text-muted mb-0">
                            {{ \Carbon\Carbon::parse($enrollment->enrollment_date)->diffForHumans() }}
                        </p>
                    </div>

                    @if($progress)
                    <hr>
                    <div class="mb-3">
                        <i class="fas fa-chart-line fa-2x text-success mb-2"></i>
                        <h6>Hoạt động học tập</h6>
                        <p class="text-muted mb-0">
                            @if($progress->last_completed_at)
                                Cập nhật {{ \Carbon\Carbon::parse($progress->last_completed_at)->diffForHumans() }}
                            @else
                                Chưa có hoạt động
                            @endif
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
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
                <p>Bạn có chắc chắn muốn hủy ghi danh của <strong>{{ $enrollment->name }}</strong>
                   cho khóa học <strong>{{ $enrollment->course_title }}</strong>?</p>
                <p class="text-danger"><strong>Lưu ý:</strong> Hành động này sẽ xóa toàn bộ tiến độ học tập của học viên!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form action="{{ route('admin.enrollments.destroy', [$enrollment->id, request()->route('courseId')]) }}"
                      method="POST" style="display: inline;">
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
function confirmDelete() {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endpush
