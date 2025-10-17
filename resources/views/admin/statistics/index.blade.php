@extends('admin.layout')

@section('title', 'Thống kê')
@section('page-title', 'Thống kê Tổng quan')

@section('content')
<!-- Period Filter -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.statistics.index') }}">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h6 class="m-0 font-weight-bold text-primary">Chọn khoảng thời gian</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <select name="period" class="form-select" onchange="this.form.submit()">
                                    <option value="week" {{ $period === 'week' ? 'selected' : '' }}>Theo tuần</option>
                                    <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Theo tháng</option>
                                    <option value="quarter" {{ $period === 'quarter' ? 'selected' : '' }}>Theo quý</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Overview -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Tổng ghi danh
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($enrollmentStats->sum('count')) }}
                        </div>
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
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($revenueStats->sum('revenue')) }}đ
                        </div>
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
                            Khóa học phổ biến
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $topCourses->count() }}
                        </div>
                    </div>
                    <div class="text-info" style="font-size: 2rem; opacity: 0.3;">
                        <i class="fas fa-trophy"></i>
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
                            Tăng trưởng user
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($userGrowth->sum('count')) }}
                        </div>
                    </div>
                    <div class="text-warning" style="font-size: 2rem; opacity: 0.3;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <!-- Enrollment Trend Chart -->
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Xu hướng Ghi danh</h6>
            </div>
            <div class="card-body">
                <canvas id="enrollmentChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Revenue Donut Chart -->
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Phân bố Doanh thu</h6>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Top Courses and Completion Stats -->
<div class="row mb-4">
    <!-- Top Courses -->
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Khóa học được mua nhiều nhất</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Khóa học</th>
                                <th>Giảng viên</th>
                                <th>Lượt mua</th>
                                <th>Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topCourses as $index => $course)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-bold">{{ Str::limit($course->title, 40) }}</div>
                                    <small class="text-muted">{{ number_format($course->price) }}đ</small>
                                </td>
                                <td>{{ $course->instructor_name }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $course->enrollment_count }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ number_format($course->total_revenue) }}đ</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Completion Stats -->
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Tỷ lệ Hoàn thành</h6>
            </div>
            <div class="card-body">
                @foreach($completionStats->take(5) as $course)
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">{{ Str::limit($course->title, 25) }}</span>
                        <span class="small">{{ $course->completion_rate ?? 0 }}%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary"
                             style="width: {{ $course->completion_rate ?? 0 }}%"></div>
                    </div>
                    <small class="text-muted">{{ $course->total_enrollments }} học viên</small>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- User Growth Chart -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Tăng trưởng Người dùng</h6>
            </div>
            <div class="card-body">
                <canvas id="userGrowthChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Enrollment Trend Chart
const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
const enrollmentChart = new Chart(enrollmentCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($enrollmentChartData['labels']) !!},
        datasets: [{
            label: 'Ghi danh',
            data: {!! json_encode($enrollmentChartData['values']) !!},
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Revenue Donut Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($topCourses->take(5)->pluck('title')->map(function($title) { return \Str::limit($title, 20); })) !!},
        datasets: [{
            data: {!! json_encode($topCourses->take(5)->pluck('total_revenue')) !!},
            backgroundColor: [
                '#4e73df',
                '#1cc88a',
                '#36b9cc',
                '#f6c23e',
                '#e74a3b'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// User Growth Chart
const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
const userGrowthChart = new Chart(userGrowthCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($userGrowthChartData['labels']) !!},
        datasets: [{
            label: 'Người dùng mới',
            data: {!! json_encode($userGrowthChartData['values']) !!},
            backgroundColor: '#f6c23e',
            borderColor: '#f6c23e',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endpush
