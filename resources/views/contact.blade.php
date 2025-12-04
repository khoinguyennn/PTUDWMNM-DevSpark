@extends('layouts.app')

@section('title', 'Liên hệ - DevStark')

@section('content')
<!-- Contact Hero Section -->
<section class="py-5 px-3 px-md-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h1 class="display-4 fw-bold mb-3">Liên hệ với chúng tôi</h1>
                <p class="lead mb-0">
                    Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info Section -->
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6">
                <div class="card course-card h-100 text-center">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-map-marker-alt fa-3x text-primary"></i>
                        </div>
                        <h5 class="mb-3">Địa chỉ</h5>
                        <p class="text-muted mb-0">
                            123 Đường ABC, Quận XYZ<br>
                            Thành phố Hồ Chí Minh<br>
                            Việt Nam
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card course-card h-100 text-center">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-phone fa-3x text-success"></i>
                        </div>
                        <h5 class="mb-3">Điện thoại</h5>
                        <p class="text-muted mb-2">
                            <strong>Hotline:</strong> 1900 xxxx
                        </p>
                        <p class="text-muted mb-0">
                            <strong>Zalo:</strong> 0123 456 789
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card course-card h-100 text-center">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-envelope fa-3x text-danger"></i>
                        </div>
                        <h5 class="mb-3">Email</h5>
                        <p class="text-muted mb-2">
                            <strong>Hỗ trợ:</strong> support@devstark.vn
                        </p>
                        <p class="text-muted mb-0">
                            <strong>Hợp tác:</strong> contact@devstark.vn
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card course-card">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold mb-4 text-center">Gửi tin nhắn cho chúng tôi</h3>
                        
                        <form id="contactForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="fullName" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="fullName" name="fullName" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="col-md-6">
                                    <label for="subject" class="form-label">Chủ đề <span class="text-danger">*</span></label>
                                    <select class="form-select" id="subject" name="subject" required>
                                        <option value="">Chọn chủ đề</option>
                                        <option value="support">Hỗ trợ kỹ thuật</option>
                                        <option value="course">Thông tin khóa học</option>
                                        <option value="payment">Thanh toán</option>
                                        <option value="cooperation">Hợp tác</option>
                                        <option value="other">Khác</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Nội dung <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-paper-plane me-2"></i>Gửi tin nhắn
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Social Media Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h3 class="fw-bold mb-4">Kết nối với chúng tôi</h3>
                <p class="text-muted mb-4">Theo dõi DevStark trên các nền tảng mạng xã hội</p>
            </div>
        </div>
        <div class="row justify-content-center g-3">
            <div class="col-auto">
                <a href="https://www.facebook.com/groups/devstark.community" target="_blank" class="btn btn-primary btn-lg">
                    <i class="fab fa-facebook-f me-2"></i>Facebook
                </a>
            </div>
            <div class="col-auto">
                <a href="#" class="btn btn-danger btn-lg">
                    <i class="fab fa-youtube me-2"></i>YouTube
                </a>
            </div>
            <div class="col-auto">
                <a href="#" class="btn btn-info btn-lg text-white">
                    <i class="fab fa-twitter me-2"></i>Twitter
                </a>
            </div>
            <div class="col-auto">
                <a href="#" class="btn btn-dark btn-lg">
                    <i class="fab fa-github me-2"></i>GitHub
                </a>
            </div>
            <div class="col-auto">
                <a href="#" class="btn btn-warning btn-lg text-white">
                    <i class="fab fa-telegram me-2"></i>Telegram
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Map Section (Optional) -->
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h3 class="fw-bold mb-3">Vị trí của chúng tôi</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="ratio ratio-21x9">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.324845163739!2d106.66408931533397!3d10.786834992311543!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ed23c0f0000%3A0x302510cc53c7a727!2zSOG7jWMgVmnhu4duIENodXnDqm4gTW9uIENpxaF1IENIT01!5e0!3m2!1svi!2s!4v1635000000000!5m2!1svi!2s" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h3 class="fw-bold mb-3">Câu hỏi thường gặp</h3>
                <p class="text-muted">Một số câu hỏi thường gặp từ học viên</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <i class="fas fa-question-circle me-2 text-primary"></i>
                                Làm thế nào để đăng ký khóa học?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Bạn có thể đăng ký tài khoản, sau đó truy cập trang khóa học và nhấn vào nút "Đăng ký học". Với các khóa học miễn phí, bạn có thể học ngay. Với khóa học trả phí, bạn cần thanh toán trước khi truy cập nội dung.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <i class="fas fa-question-circle me-2 text-primary"></i>
                                Các hình thức thanh toán được hỗ trợ?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Chúng tôi hỗ trợ thanh toán qua thẻ ATM, thẻ tín dụng, ví điện tử (Momo, ZaloPay), và chuyển khoản ngân hàng. Tất cả các giao dịch đều được bảo mật an toàn.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <i class="fas fa-question-circle me-2 text-primary"></i>
                                Tôi có thể học mọi lúc mọi nơi không?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Có, bạn có thể truy cập khóa học 24/7 trên mọi thiết bị (máy tính, điện thoại, máy tính bảng). Nội dung khóa học không giới hạn thời gian truy cập.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                <i class="fas fa-question-circle me-2 text-primary"></i>
                                Tôi có nhận được chứng chỉ sau khi hoàn thành khóa học không?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Có, sau khi hoàn thành 100% nội dung khóa học, bạn sẽ nhận được chứng chỉ hoàn thành có thể tải xuống và chia sẻ trên LinkedIn hoặc CV của bạn.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                <i class="fas fa-question-circle me-2 text-primary"></i>
                                Tôi cần hỗ trợ thêm, liên hệ như thế nào?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Bạn có thể gửi tin nhắn qua form liên hệ trên trang này, hoặc liên hệ trực tiếp qua email support@devstark.vn hoặc hotline 1900 xxxx. Chúng tôi sẽ phản hồi trong vòng 24h.
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
    .course-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .accordion-button:not(.collapsed) {
        background-color: #f8f9fa;
        color: #667eea;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0, 0, 0, 0.125);
    }

    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .display-4 {
            font-size: 2.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Simple form validation
        const form = e.target;
        const formData = new FormData(form);
        
        // Here you would typically send the data to your backend
        // For now, we'll just show a success message
        
        alert('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.');
        form.reset();
    });
</script>
@endpush
