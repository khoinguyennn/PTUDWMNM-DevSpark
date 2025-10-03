@extends('admin.layout')

@section('title', 'Quản lý Khóa học')
@section('page-title', 'Quản lý Khóa học')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-book me-2"></i>Danh sách Khóa học</span>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Thêm khóa học mới
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Thumbnail</th>
                            <th>Tên khóa học</th>
                            <th>Giảng viên</th>
                            <th>Giá</th>
                            <th>Chương</th>
                            <th>Bài học</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                        <tr>
                            <td>{{ $course->id }}</td>
                            <td>
                                @if($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                         alt="{{ $course->title }}"
                                         style="width: 60px; height: 40px; object-fit: cover; border-radius: 5px;">
                                @else
                                    <div style="width: 60px; height: 40px; background: #e9ecef; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $course->title }}</strong>
                            </td>
                            <td>{{ $course->instructor->name ?? 'N/A' }}</td>
                            <td>{{ number_format($course->price, 0, ',', '.') }} đ</td>
                            <td>
                                <span class="badge bg-info">{{ $course->sections->count() }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success">{{ $course->total_lessons }}</span>
                            </td>
                            <td>{{ $course->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.courses.show', $course) }}"
                                       class="btn btn-sm btn-info"
                                       title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.courses.edit', $course) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.courses.destroy', $course) }}"
                                          method="POST"
                                          style="display: inline;"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa khóa học này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                Chưa có khóa học nào.
                                <a href="{{ route('admin.courses.create') }}">Tạo khóa học mới</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($courses->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
