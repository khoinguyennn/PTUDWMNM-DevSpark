@extends('layouts.app')

@section('title', 'Quản Lý Ghi Danh')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Quản Lý Ghi Danh</h2>
            <p class="text-muted">Danh sách học viên đã ghi danh các khóa học của bạn</p>
        </div>
    </div>

    @if($enrollments->count() > 0)
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Học Viên</th>
                                <th>Email</th>
                                <th>Khóa Học</th>
                                <th>Ngày Ghi Danh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrollments as $enrollment)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                                 style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($enrollment->student_name, 0, 1)) }}
                                            </div>
                                            <strong>{{ $enrollment->student_name }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $enrollment->student_email }}</td>
                                    <td>{{ $enrollment->course_title }}</td>
                                    <td>{{ \Carbon\Carbon::parse($enrollment->enrolled_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $enrollments->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-users fa-4x text-muted mb-3"></i>
                <h4>Chưa Có Ghi Danh</h4>
                <p class="text-muted">Chưa có học viên nào ghi danh khóa học của bạn.</p>
            </div>
        </div>
    @endif
</div>
@endsection
