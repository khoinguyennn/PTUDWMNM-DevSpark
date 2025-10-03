@extends('admin.layout')

@section('title', 'Chỉnh sửa Khóa học')
@section('page-title', 'Chỉnh sửa Khóa học')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Chỉnh sửa Khóa học
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Tên khóa học <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $course->title) }}" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="instructor_id" class="form-label">Giảng viên <span class="text-danger">*</span></label>
                            <select class="form-select @error('instructor_id') is-invalid @enderror" 
                                    id="instructor_id" 
                                    name="instructor_id" 
                                    required>
                                <option value="">-- Chọn giảng viên --</option>
                                @foreach($instructors as $instructor)
                                    <option value="{{ $instructor->id }}" 
                                            {{ old('instructor_id', $course->instructor_id) == $instructor->id ? 'selected' : '' }}>
                                        {{ $instructor->name }} ({{ $instructor->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('instructor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="5" 
                                      required>{{ old('description', $course->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('price') is-invalid @enderror" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price', $course->price) }}" 
                                   min="0" 
                                   step="1000" 
                                   required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            
                            @if($course->thumbnail)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" 
                                         alt="{{ $course->title }}" 
                                         style="max-width: 200px; border-radius: 5px;">
                                </div>
                            @endif
                            
                            <input type="file" 
                                   class="form-control @error('thumbnail') is-invalid @enderror" 
                                   id="thumbnail" 
                                   name="thumbnail" 
                                   accept="image/*">
                            <small class="text-muted">Để trống nếu không muốn thay đổi. Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB</small>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Cập nhật khóa học
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
