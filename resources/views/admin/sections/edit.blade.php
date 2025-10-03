@extends('admin.layout')

@section('title', 'Chỉnh sửa Chương')
@section('page-title', 'Chỉnh sửa Chương')

@section('content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Chỉnh sửa Chương
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sections.update', $section) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Tên chương <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title"
                                   name="title"
                                   value="{{ old('title', $section->title) }}"
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
                                   value="{{ old('position', $section->position) }}"
                                   min="1"
                                   required>
                            <small class="text-muted">Thứ tự hiển thị của chương trong khóa học</small>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.courses.show', $section->course) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Cập nhật chương
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
