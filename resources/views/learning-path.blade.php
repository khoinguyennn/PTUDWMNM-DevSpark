@extends('layouts.app')

@section('title', 'Lộ trình học')

@section('content')
<!-- Learning Path Section -->
<section class="py-5 px-3 px-md-4" style="background-color: #f8f9fa;">
    <div class="container">
        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Lộ trình học</h2>
                <p class="text-muted mb-4">
                    Để bắt đầu một cách thuận lợi, bạn nên tập trung vào một lộ trình học. Ví dụ: Để đi làm với vị trí "Lập trình viên Front-end" bạn nên tập trung vào lộ trình "Front-end".
                </p>
            </div>
        </div>

        <!-- Learning Paths -->
        <div class="row g-4">
            <!-- Front-end Path -->
            <div class="col-lg-6">
                <div class="card course-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="path-icon me-3">
                                <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                                    <circle cx="30" cy="30" r="30" fill="#E8F4FD"/>
                                    <path d="M20 25L30 20L40 25M20 25V35L30 40M20 25L30 30M40 25V35L30 40M40 25L30 30M30 40V30" stroke="#1E88E5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="30" cy="20" r="2" fill="#1E88E5"/>
                                    <circle cx="20" cy="25" r="2" fill="#1E88E5"/>
                                    <circle cx="40" cy="25" r="2" fill="#1E88E5"/>
                                    <circle cx="20" cy="35" r="2" fill="#1E88E5"/>
                                    <circle cx="40" cy="35" r="2" fill="#1E88E5"/>
                                    <circle cx="30" cy="40" r="2" fill="#1E88E5"/>
                                </svg>
                            </div>
                            <div>
                                <h5 class="course-title">Lộ trình học Front-end</h5>
                                <p class="text-muted mb-3">
                                    Lập trình viên Front-end là người xây dựng ra giao diện websites. Trong phần này DevSpark sẽ chia sẻ cho bạn lộ trình để trở thành lập trình viên Front-end nhé.
                                </p>
                                <a href="#" class="btn btn-primary">
                                    <i class="fas fa-play-circle me-2"></i>XEM CHI TIẾT
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back-end Path -->
            <div class="col-lg-6">
                <div class="card course-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="path-icon me-3">
                                <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                                    <circle cx="30" cy="30" r="30" fill="#FFF4E6"/>
                                    <rect x="18" y="15" width="24" height="4" rx="2" fill="#FF9800"/>
                                    <rect x="18" y="22" width="24" height="4" rx="2" fill="#FF9800"/>
                                    <rect x="18" y="29" width="24" height="4" rx="2" fill="#FF9800"/>
                                    <rect x="18" y="36" width="24" height="4" rx="2" fill="#FF9800"/>
                                    <rect x="18" y="43" width="24" height="4" rx="2" fill="#FF9800"/>
                                    <circle cx="15" cy="17" r="2" fill="#FF5722"/>
                                    <circle cx="15" cy="24" r="2" fill="#FF5722"/>
                                    <circle cx="15" cy="31" r="2" fill="#FF5722"/>
                                    <circle cx="15" cy="38" r="2" fill="#FF5722"/>
                                    <circle cx="15" cy="45" r="2" fill="#FF5722"/>
                                </svg>
                            </div>
                            <div>
                                <h5 class="course-title">Lộ trình học Back-end</h5>
                                <p class="text-muted mb-3">
                                    Trái với Front-end thì lập trình viên Back-end là người làm việc với dữ liệu, công việc thường nằm trong việc xử lý dữ liệu, nghiệp vụ của ứng dụng, website. Chúng ta sẽ tìm hiểu thêm về Back-end tại đây nhé.
                                </p>
                                <a href="#" class="btn btn-primary">
                                    <i class="fas fa-play-circle me-2"></i>XEM CHI TIẾT
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Facebook Learning Community -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card course-card">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h4 class="fw-bold mb-3">Tham gia cộng đồng học viên DevSpark trên Facebook</h4>
                                <p class="text-muted mb-4">
                                    Hàng nghìn người đang học lộ trình giống như bạn. Hãy tham gia hỏi đáp, chia sẻ và hỗ trợ nhau trong quá trình học nhé.
                                </p>
                                <a href="https://www.facebook.com/groups/devstark.community" target="_blank" class="btn btn-outline-primary">
                                    <i class="fab fa-facebook me-2"></i>Tham gia nhóm
                                </a>
                            </div>
                            <div class="col-lg-6 text-center">
                                <img src="{{ asset('images/logo.jpg') }}"
                                     alt="Community"
                                     class="img-fluid"
                                     style="max-height: 300px;"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 400 300\'%3E%3Crect fill=\'%23f0f0f0\' width=\'400\' height=\'300\'/%3E%3Cg fill=\'%23999\'%3E%3Ccircle cx=\'100\' cy=\'150\' r=\'40\'/%3E%3Ccircle cx=\'200\' cy=\'150\' r=\'40\'/%3E%3Ccircle cx=\'300\' cy=\'150\' r=\'40\'/%3E%3Cpath d=\'M80 200 Q 100 180, 120 200\' stroke=\'%23666\' fill=\'none\' stroke-width=\'2\'/%3E%3Cpath d=\'M180 200 Q 200 180, 220 200\' stroke=\'%23666\' fill=\'none\' stroke-width=\'2\'/%3E%3Cpath d=\'M280 200 Q 300 180, 320 200\' stroke=\'%23666\' fill=\'none\' stroke-width=\'2\'/%3E%3Ctext x=\'200\' y=\'50\' text-anchor=\'middle\' font-size=\'20\' fill=\'%23666\'%3ECommunity%3C/text%3E%3C/g%3E%3C/svg%3E'">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .path-icon {
        flex-shrink: 0;
    }

    .course-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }

    @media (max-width: 991px) {
        .learning-path-card .d-flex {
            flex-direction: column;
            text-align: center;
        }

        .path-icon {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush
