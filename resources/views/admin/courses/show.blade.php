@extends('admin.layout')

@section('title', 'Chi tiết Khóa học')
@section('page-title', 'Chi tiết Khóa học')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Course Info -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-book me-2"></i>Thông tin Khóa học</span>
                    <div>
                        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" 
                                     alt="{{ $course->title }}" 
                                     class="img-fluid rounded">
                            @else
                                <div class="bg-light rounded p-5 text-center">
                                    <i class="fas fa-image fa-5x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h3>{{ $course->title }}</h3>
                            <p class="text-muted">
                                <i class="fas fa-user me-2"></i>Giảng viên: <strong>{{ $course->instructor->name }}</strong>
                            </p>
                            <p class="text-muted">
                                <i class="fas fa-tag me-2"></i>Giá: <strong class="text-primary">{{ number_format($course->price, 0, ',', '.') }} đ</strong>
                            </p>
                            <p class="text-muted">
                                <i class="fas fa-calendar me-2"></i>Ngày tạo: {{ $course->created_at->format('d/m/Y H:i') }}
                            </p>
                            <hr>
                            <h5>Mô tả:</h5>
                            <p>{{ $course->description }}</p>
                            <hr>
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h4 class="text-primary">{{ $course->sections->count() }}</h4>
                                            <p class="mb-0 text-muted">Chương học</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h4 class="text-success">{{ $course->total_lessons }}</h4>
                                            <p class="mb-0 text-muted">Bài học</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h4 class="text-info">{{ floor($course->total_duration / 60) }}h {{ $course->total_duration % 60 }}m</h4>
                                            <p class="mb-0 text-muted">Thời lượng</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sections & Lessons -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-list me-2"></i>Nội dung Khóa học</span>
                    <a href="{{ route('admin.sections.create', $course) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Thêm chương mới
                    </a>
                </div>
                <div class="card-body">
                    @forelse($course->sections as $index => $section)
                        <div class="mb-4 border rounded p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">
                                    <span class="badge bg-primary me-2">{{ $index + 1 }}</span>
                                    {{ $section->title }}
                                    <small class="text-muted">({{ $section->lessons->count() }} bài học)</small>
                                </h5>
                                <div>
                                    <a href="{{ route('admin.lessons.create', $section) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus"></i> Thêm bài học
                                    </a>
                                    <a href="{{ route('admin.sections.edit', $section) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.sections.destroy', $section) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa chương này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            @if($section->lessons->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th width="50">#</th>
                                                <th>Tên bài học</th>
                                                <th>URL Video</th>
                                                <th width="100">Thời lượng</th>
                                                <th width="150">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($section->lessons as $lessonIndex => $lesson)
                                            <tr>
                                                <td>{{ $lessonIndex + 1 }}</td>
                                                <td>{{ $lesson->title }}</td>
                                                <td>
                                                    <a href="{{ $lesson->youtube_url }}" target="_blank" class="text-primary">
                                                        <i class="fab fa-youtube"></i> Xem video
                                                    </a>
                                                </td>
                                                <td>{{ $lesson->duration }} phút</td>
                                                <td>
                                                    <a href="{{ route('admin.lessons.edit', $lesson) }}" 
                                                       class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.lessons.destroy', $lesson) }}" 
                                                          method="POST" 
                                                          style="display: inline;"
                                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài học này?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Chưa có bài học nào. 
                                    <a href="{{ route('admin.lessons.create', $section) }}">Thêm bài học mới</a>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>
                            Chưa có chương học nào. 
                            <a href="{{ route('admin.sections.create', $course) }}">Thêm chương mới</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
