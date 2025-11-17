@extends('layouts.app')

@section('title', $course->title . ' - Học tập')

@push('styles')
<style>
    /* Hide main sidebar on learning page */
    .sidebar {
        display: block;
    }

    /* Adjust main content to full width */
    .main-content {
        margin-left: var(--sidebar-width);
    }

    /* Learning page specific styles */
    .learning-container {
        display: flex;
        height: calc(100vh - 70px);
        margin-top: 0;
    }

    .video-and-content {
        display: flex;
        flex: 1;
    }

    /* Video section */
    .video-section {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        position: relative;
        max-height: none; /* Bỏ giới hạn chiều cao */
    }

    .video-player {
        width: 100%;
        height: 400px; /* Chiều cao cố định cho video */
        max-width: 700px; /* Giới hạn chiều rộng */
        background: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        margin: 20px;
    }

    .video-placeholder {
        text-align: center;
        color: #888;
    }

    /* Course content sidebar */
    .course-content-sidebar {
        width: 400px;
        background: white;
        border-left: 1px solid #e9ecef;
        overflow-y: auto;
        height: calc(100vh - 70px);
    }

    .course-description {
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
        background: white;
    }

    .video-description {
        padding: 20px 20px;
        width: 100%;
        margin-top: 0;
    }

    .description-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--text-dark);
    }

    .description-text {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    .content-sidebar-header {
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
        background: #f8f9fa;
    }

    .content-sidebar-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text-dark);
    }

    .course-progress {
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .lesson-section {
        border-bottom: 1px solid #f0f0f0;
    }

    .section-header {
        padding: 15px 20px;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        flex: 1;
        color: var(--text-dark);
    }

    .section-toggle {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .lessons-list {
        background: white;
        display: none;
    }

    .lesson-item {
        padding: 12px 20px;
        border-bottom: 1px solid #f5f5f5;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .lesson-item:hover {
        background: #f8f9fa;
    }

    .lesson-item.active {
        background: rgba(11, 186, 244, 0.1);
        border-left: 3px solid var(--primary-color);
    }

    .lesson-icon {
        width: 30px;
        height: 30px;
        background: #f0f0f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .lesson-item.active .lesson-icon {
        background: var(--primary-color);
        color: white;
    }

    .lesson-content {
        flex: 1;
    }

    .lesson-title {
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 2px;
        color: var(--text-dark);
    }

    .lesson-duration {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    /* Responsive for mobile */
    @media (max-width: 768px) {
        .learning-container {
            flex-direction: column;
        }

        .video-section {
            height: 60vh;
        }

        .course-content-sidebar {
            width: 100%;
            height: 40vh;
        }
    }


</style>
@endpush

@section('content')
    <div class="learning-container">
        <!-- Video Section -->
        <div class="video-section">
            <!-- Course Title Above Video -->
            <div style="width: 100%; max-width: 700px; padding: 20px 20px 0 20px; margin-bottom: 10px;">
                <h2 style="color: var(--text-dark); font-size: 1.5rem; font-weight: 600; margin: 0; text-align: center;">{{ $course->title }}</h2>
            </div>

            <div class="video-player">
                @if($currentLesson && $currentLesson->youtube_url)
                    @php
                        // Extract YouTube video ID from various URL formats
                        $youtube_url = $currentLesson->youtube_url;
                        $video_id = '';

                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $youtube_url, $matches)) {
                            $video_id = $matches[1];
                        } else {
                            // If it's already just the video ID
                            $video_id = $youtube_url;
                        }
                    @endphp

                    @if($video_id)
                        <!-- YouTube Video Player -->
                        <iframe
                            width="100%"
                            height="100%"
                            src="https://www.youtube.com/embed/{{ $video_id }}?rel=0&modestbranding=1"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                    @else
                        <div class="video-placeholder">
                            <i class="fab fa-youtube fa-3x mb-3" style="color: #666;"></i>
                            <h3>Video không hợp lệ</h3>
                            <p>URL YouTube không đúng định dạng</p>
                        </div>
                    @endif
                @else
                    <div class="video-placeholder">
                        <i class="fab fa-youtube fa-3x mb-3" style="color: #666;"></i>
                        <h3>Video youtube</h3>
                        <p>Chọn một bài học để bắt đầu</p>
                    </div>
                @endif
            </div>

            <!-- Course Description Below Video -->
            <div class="video-description">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                    <h3 class="description-title" style="margin-bottom: 0;">Về khóa học</h3>
                    @if($currentLesson)
                        <button id="markCompleteBtn" class="btn btn-sm" 
                                style="background: {{ $isCurrentLessonCompleted ?? false ? '#28a745' : 'var(--primary-color)' }}; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem;"
                                data-lesson-id="{{ $currentLesson->id }}"
                                {{ $isCurrentLessonCompleted ?? false ? 'disabled' : '' }}>
                            <i class="fas fa-check-circle me-1"></i>
                            <span id="markCompleteText">{{ $isCurrentLessonCompleted ?? false ? 'Đã hoàn thành' : 'Đánh dấu hoàn thành' }}</span>
                        </button>
                    @endif
                </div>
                <p class="description-text">{{ $course->description ?? 'Tổng quan về khóa học ' . $course->title }}</p>
            </div>
        </div>

        <!-- Course Content Sidebar -->
        <div class="course-content-sidebar">
                <!-- Sidebar Header -->
                <div class="content-sidebar-header">
                    <h3 class="content-sidebar-title">Nội dung khóa học</h3>
                    <div class="course-progress">
                        @php
                            $totalLessons = $course->sections->sum(function($section) {
                                return $section->lessons->count();
                            });
                        @endphp
                        {{ $totalLessons }} bài học
                    </div>
                </div>

            <!-- Course Sections -->
            @foreach($course->sections as $sectionIndex => $section)
                <div class="lesson-section">
                    <div class="section-header" onclick="toggleSection(this)">
                        <h4 class="section-title">{{ $sectionIndex + 1 }}. {{ $section->title }}</h4>
                        <div class="section-toggle">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="lessons-list">
                        @foreach($section->lessons as $lessonIndex => $lesson)
                            @php
                                $isLessonCompleted = in_array($lesson->id, $completedLessons ?? []);
                            @endphp
                            <div class="lesson-item {{ $currentLesson && $currentLesson->id == $lesson->id ? 'active' : '' }}" 
                                 data-lesson-id="{{ $lesson->id }}"
                                 data-video-url="{{ $lesson->youtube_url }}"
                                 data-is-completed="{{ $isLessonCompleted ? 'true' : 'false' }}"
                                 onclick="selectLesson(this)">
                                <div class="lesson-icon" style="background: {{ $isLessonCompleted ? '#28a745' : '#f0f0f0' }};">
                                    @if($currentLesson && $currentLesson->id == $lesson->id)
                                        <i class="fas {{ $isLessonCompleted ? 'fa-check' : 'fa-play' }}" style="color: {{ $isLessonCompleted ? 'white' : 'var(--text-muted)' }};"></i>
                                    @else
                                        <i class="fas {{ $isLessonCompleted ? 'fa-check' : 'fa-play-circle' }}" style="color: {{ $isLessonCompleted ? 'white' : 'var(--text-muted)' }};"></i>
                                    @endif
                                </div>
                                <div class="lesson-content">
                                    <div class="lesson-title">
                                        {{ $sectionIndex + 1 }}.{{ $lessonIndex + 1 }} {{ $lesson->title }}
                                    </div>
                                    @if($lesson->duration)
                                        <div class="lesson-duration">{{ $lesson->duration }} phút</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            @if($course->sections->isEmpty())
                <div class="text-center p-4">
                    <i class="fas fa-book fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Chưa có nội dung bài học</p>
                    <p class="text-muted small">Khóa học này chưa có sections và lessons được thêm vào.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Section toggle functionality
    function toggleSection(header) {
        const lessonsList = header.nextElementSibling;
        const toggle = header.querySelector('.section-toggle i');

        if (lessonsList.style.display === 'none' || lessonsList.style.display === '') {
            lessonsList.style.display = 'block';
            toggle.classList.remove('fa-chevron-down');
            toggle.classList.add('fa-chevron-up');
        } else {
            lessonsList.style.display = 'none';
            toggle.classList.remove('fa-chevron-up');
            toggle.classList.add('fa-chevron-down');
        }
    }

    // Lesson selection functionality
    function selectLesson(lesson) {
        // Remove active from all lessons and restore their original icons
        document.querySelectorAll('.lesson-item').forEach(l => {
            l.classList.remove('active');
            const icon = l.querySelector('.lesson-icon i');
            const isCompleted = l.dataset.isCompleted === 'true';
            
            if (isCompleted) {
                icon.className = 'fas fa-check';
            } else {
                icon.className = 'fas fa-play-circle';
            }
        });

        // Add active to clicked lesson and update its icon
        lesson.classList.add('active');
        const lessonIcon = lesson.querySelector('.lesson-icon i');
        const isCompleted = lesson.dataset.isCompleted === 'true';
        
        if (isCompleted) {
            lessonIcon.className = 'fas fa-check';
        } else {
            lessonIcon.className = 'fas fa-play';
        }

        // Update mark complete button
        updateMarkCompleteButton(lesson);

        // Get video URL
        const videoUrl = lesson.dataset.videoUrl;
        const videoPlayer = document.querySelector('.video-player');

        if (videoUrl) {
            // Extract YouTube video ID from various URL formats
            function getYouTubeVideoId(url) {
                const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
                const matches = url.match(regex);
                return matches ? matches[1] : url; // Return the ID or original if it's already an ID
            }
            
            const videoId = getYouTubeVideoId(videoUrl);
            
            // Create YouTube embed
            videoPlayer.innerHTML = `
                <iframe
                    width="100%"
                    height="100%"
                    src="https://www.youtube.com/embed/${videoId}?rel=0&modestbranding=1"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen>
                </iframe>
            `;
        } else {
            // Show placeholder
            videoPlayer.innerHTML = `
                <div class="video-placeholder">
                    <i class="fab fa-youtube fa-3x mb-3" style="color: #666;"></i>
                    <h3>Video youtube</h3>
                    <p>Video chưa được thêm cho bài học này</p>
                </div>
            `;
        }
    }

    // Function to update mark complete button
    function updateMarkCompleteButton(lessonElement) {
        const markCompleteBtn = document.getElementById('markCompleteBtn');
        const markCompleteText = document.getElementById('markCompleteText');
        
        if (!markCompleteBtn) return;
        
        const lessonId = lessonElement.dataset.lessonId;
        const isCompleted = lessonElement.dataset.isCompleted === 'true';
        
        markCompleteBtn.dataset.lessonId = lessonId;
        
        if (isCompleted) {
            markCompleteBtn.style.background = '#28a745';
            markCompleteBtn.disabled = true;
            markCompleteText.textContent = 'Đã hoàn thành';
        } else {
            markCompleteBtn.style.background = 'var(--primary-color)';
            markCompleteBtn.disabled = false;
            markCompleteText.textContent = 'Đánh dấu hoàn thành';
        }
    }    // Auto-expand first section on load
    document.addEventListener('DOMContentLoaded', function() {
        const firstSection = document.querySelector('.lesson-section');
        if (firstSection) {
            const header = firstSection.querySelector('.section-header');
            toggleSection(header);
        }
        
        // Handle mark complete button
        const markCompleteBtn = document.getElementById('markCompleteBtn');
        if (markCompleteBtn) {
            markCompleteBtn.addEventListener('click', function() {
                markLessonComplete();
            });
        }
    });

    // Function to mark lesson as complete
    function markLessonComplete() {
        const markCompleteBtn = document.getElementById('markCompleteBtn');
        if (!markCompleteBtn) {
            alert('Không tìm thấy nút đánh dấu hoàn thành');
            return;
        }
        
        const lessonId = markCompleteBtn.dataset.lessonId;
        if (!lessonId) {
            alert('Vui lòng chọn một bài học để đánh dấu hoàn thành');
            return;
        }
        
        const markCompleteText = document.getElementById('markCompleteText');
        
        // Disable button during request
        markCompleteBtn.disabled = true;
        markCompleteText.textContent = 'Đang xử lý...';
        
        // Send AJAX request
        fetch('/lesson/mark-complete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                lesson_id: lessonId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI
                markCompleteText.textContent = 'Đã hoàn thành';
                markCompleteBtn.style.background = '#28a745';
                
                // Update current lesson item
                const currentLessonItem = document.querySelector('.lesson-item.active');
                if (currentLessonItem) {
                    // Update data attribute
                    currentLessonItem.dataset.isCompleted = 'true';
                    
                    // Update lesson icon
                    const lessonIcon = currentLessonItem.querySelector('.lesson-icon i');
                    lessonIcon.className = 'fas fa-check';
                    lessonIcon.style.color = 'white';
                    currentLessonItem.querySelector('.lesson-icon').style.background = '#28a745';
                }
                
                // Show success message using Toastr
                if (typeof toastr !== 'undefined') {
                    toastr.success('Đã đánh dấu bài học hoàn thành!');
                } else {
                    showMessage('Đã đánh dấu bài học hoàn thành!', 'success');
                }
            } else {
                throw new Error(data.message || 'Có lỗi xảy ra');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof toastr !== 'undefined') {
                toastr.error('Có lỗi xảy ra: ' + error.message);
            } else {
                showMessage('Có lỗi xảy ra: ' + error.message, 'error');
            }
            
            // Reset button
            markCompleteText.textContent = 'Đánh dấu hoàn thành';
            markCompleteBtn.style.background = 'var(--primary-color)';
            markCompleteBtn.disabled = false;
        });
    }

    // Function to show message
    function showMessage(message, type) {
        const messageDiv = document.createElement('div');
        messageDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            border-radius: 6px;
            color: white;
            font-weight: 500;
            z-index: 1000;
            background: ${type === 'success' ? '#28a745' : '#dc3545'};
        `;
        messageDiv.textContent = message;
        
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            messageDiv.remove();
        }, 3000);
    }

    // Check if user just enrolled (for free course success alert)
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('enrollment_success'))
            Swal.fire({
                title: 'Đăng ký thành công! 🎉',
                text: 'Bạn đã đăng ký khóa học miễn phí thành công. Chúc bạn học tập hiệu quả!',
                icon: 'success',
                confirmButtonText: 'Bắt đầu học ngay!',
                confirmButtonColor: '#28a745',
                showCancelButton: false,
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Focus on the first lesson or scroll to video player
                    const videoPlayer = document.querySelector('.video-player');
                    if (videoPlayer) {
                        videoPlayer.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            });
        @endif
    });
</script>
@endpush
