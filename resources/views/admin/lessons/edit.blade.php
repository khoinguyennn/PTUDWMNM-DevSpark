@extends('admin.layout')

@section('title', 'Chỉnh sửa Bài học')
@section('page-title', 'Chỉnh sửa Bài học')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Chỉnh sửa Bài học
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.lessons.update', $lesson) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Tên bài học <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $lesson->title) }}" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="youtube_url" class="form-label">URL Video YouTube <span class="text-danger">*</span></label>
                            <input type="url" 
                                   class="form-control @error('youtube_url') is-invalid @enderror" 
                                   id="youtube_url" 
                                   name="youtube_url" 
                                   value="{{ old('youtube_url', $lesson->youtube_url) }}" 
                                   placeholder="https://www.youtube.com/watch?v=..." 
                                   required>
                            <small class="text-muted">Nhập URL video từ YouTube</small>
                            @error('youtube_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="duration" class="form-label">Thời lượng (phút) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('duration') is-invalid @enderror" 
                                   id="duration" 
                                   name="duration" 
                                   value="{{ old('duration', $lesson->duration) }}" 
                                   min="1" 
                                   required>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label">Vị trí <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('position') is-invalid @enderror" 
                                   id="position" 
                                   name="position" 
                                   value="{{ old('position', $lesson->position) }}" 
                                   min="1" 
                                   required>
                            <small class="text-muted">Thứ tự hiển thị của bài học trong chương</small>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.courses.show', $lesson->section->course) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Cập nhật bài học
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
