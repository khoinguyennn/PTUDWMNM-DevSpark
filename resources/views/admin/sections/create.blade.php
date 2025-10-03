@extends('admin.layout')

@section('title', 'Thêm Chương mới')
@section('page-title', 'Thêm Chương mới')

@section('content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-plus me-2"></i>Thêm Chương mới cho: <strong>{{ $course->title }}</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sections.store', $course) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Tên chương <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title"
                                   name="title"
                                   value="{{ old('title') }}"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label">Vị trí <span class="text-danger">*</span></label>
                            <input type="number"
                                   class="form-control @error('position') is-invalid @enderror"
                                   id="position"
                                   name="position"
                                   value="{{ old('position', $course->sections->count() + 1) }}"
                                   min="1"
                                   required>
                            <small class="text-muted">Thứ tự hiển thị của chương trong khóa học</small>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Lưu chương
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
