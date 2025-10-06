<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Học tập - DevStark')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0BBAF4;
            --primary-dark: #5CB3D9;
            --secondary-color: #FF6B35;
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
            --border-radius: 12px;
            --box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.5;
            color: var(--text-dark);
            font-size: 14px;
            background-color: #f8f9fa;
        }

        /* Header cố định */
        .learning-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: white;
            border-bottom: 1px solid #e9ecef;
            z-index: 1000;
            height: 60px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .course-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .back-button {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 1.2rem;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: #f8f9fa;
            color: var(--primary-color);
        }

        .course-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .progress-info {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Layout chính */
        .learning-container {
            display: flex;
            height: 100vh;
            padding-top: 60px;
        }

        /* Video player */
        .video-section {
            flex: 1;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .video-player {
            width: 100%;
            height: 100%;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .video-placeholder {
            text-align: center;
            color: #888;
        }

        /* Sidebar nội dung khóa học */
        .course-sidebar {
            width: 400px;
            background: white;
            border-left: 1px solid #e9ecef;
            overflow-y: auto;
            height: calc(100vh - 60px);
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
            background: #f8f9fa;
        }

        .sidebar-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
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
        }

        .section-toggle {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .lessons-list {
            background: white;
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
        }

        .lesson-duration {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Course description section */
        .course-description {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
            background: white;
        }

        .description-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .description-text {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .course-sidebar {
                position: fixed;
                right: -400px;
                top: 60px;
                z-index: 999;
                transition: right 0.3s ease;
                box-shadow: -2px 0 10px rgba(0,0,0,0.1);
            }

            .course-sidebar.show {
                right: 0;
            }

            .learning-container {
                flex-direction: column;
            }

            .video-section {
                height: 60vh;
            }

            .toggle-sidebar {
                display: block;
                background: var(--primary-color);
                color: white;
                border: none;
                padding: 8px 12px;
                border-radius: 6px;
                font-size: 0.9rem;
            }
        }

        .toggle-sidebar {
            display: none;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Header -->
    <div class="learning-header">
        <div class="course-info">
            <button class="back-button" onclick="history.back()">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div>
                <h1 class="course-title">@yield('course-title')</h1>
                <div class="progress-info">@yield('progress-info')</div>
            </div>
        </div>
        <div class="user-actions">
            <button class="toggle-sidebar d-md-none">
                <i class="fas fa-bars"></i> Nội dung
            </button>
            @auth
                <div class="user-avatar">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endauth
        </div>
    </div>

    <!-- Main content -->
    <div class="learning-container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.querySelector('.toggle-sidebar')?.addEventListener('click', function() {
            const sidebar = document.querySelector('.course-sidebar');
            sidebar.classList.toggle('show');
        });

        // Section toggle functionality
        document.querySelectorAll('.section-header').forEach(header => {
            header.addEventListener('click', function() {
                const lessonsList = this.nextElementSibling;
                const toggle = this.querySelector('.section-toggle i');

                lessonsList.style.display = lessonsList.style.display === 'none' ? 'block' : 'none';
                toggle.classList.toggle('fa-chevron-down');
                toggle.classList.toggle('fa-chevron-up');
            });
        });

        // Lesson click functionality
        document.querySelectorAll('.lesson-item').forEach(lesson => {
            lesson.addEventListener('click', function() {
                // Remove active from all lessons
                document.querySelectorAll('.lesson-item').forEach(l => l.classList.remove('active'));
                // Add active to clicked lesson
                this.classList.add('active');

                // Here you can add logic to load the lesson content
                const lessonId = this.dataset.lessonId;
                console.log('Loading lesson:', lessonId);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
