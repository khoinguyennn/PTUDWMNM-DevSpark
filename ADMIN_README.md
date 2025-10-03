# Hệ thống Quản lý Admin - Bán Khóa học Online

Hệ thống admin đã được tạo thành công với đầy đủ các tính năng quản lý khóa học online.

## 🎯 Tính năng đã triển khai

### 1. Dashboard (Trang tổng quan)
- Thống kê tổng quan: số lượng khóa học, học viên, giảng viên, doanh thu
- Hiển thị khóa học mới nhất
- Hiển thị người dùng mới
- Hiển thị đơn hàng gần đây

### 2. Quản lý Khóa học
- **Danh sách khóa học**: Xem tất cả khóa học với thumbnail, giá, số chương, số bài học
- **Thêm khóa học mới**: Form tạo khóa học với upload thumbnail
- **Chỉnh sửa khóa học**: Cập nhật thông tin khóa học
- **Xóa khóa học**: Xóa khóa học (có xác nhận)
- **Chi tiết khóa học**: Xem chi tiết với danh sách chương và bài học

### 3. Quản lý Chương học (Sections)
- **Thêm chương mới**: Tạo chương cho khóa học với vị trí sắp xếp
- **Chỉnh sửa chương**: Cập nhật tên và vị trí chương
- **Xóa chương**: Xóa chương (có xác nhận)

### 4. Quản lý Bài học (Lessons)
- **Thêm bài học mới**: Tạo bài học với YouTube URL, thời lượng, vị trí
- **Chỉnh sửa bài học**: Cập nhật thông tin bài học
- **Xóa bài học**: Xóa bài học (có xác nhận)

### 5. Quản lý Người dùng
- **Danh sách người dùng**: Xem tất cả người dùng với vai trò (Admin, Giảng viên, Học viên)
- **Thêm người dùng mới**: Tạo tài khoản mới với vai trò
- **Chỉnh sửa người dùng**: Cập nhật thông tin và vai trò
- **Xóa người dùng**: Xóa người dùng (có xác nhận)

## 📂 Cấu trúc File

### Models
- `app/Models/Course.php` - Model Khóa học
- `app/Models/Section.php` - Model Chương học
- `app/Models/Lesson.php` - Model Bài học
- `app/Models/User.php` - Model Người dùng
- `app/Models/Order.php` - Model Đơn hàng
- `app/Models/OrderItem.php` - Model Chi tiết đơn hàng
- `app/Models/Payment.php` - Model Thanh toán
- `app/Models/UserProgress.php` - Model Tiến độ học

### Controllers
- `app/Http/Controllers/Admin/DashboardController.php`
- `app/Http/Controllers/Admin/CourseController.php`
- `app/Http/Controllers/Admin/SectionController.php`
- `app/Http/Controllers/Admin/LessonController.php`
- `app/Http/Controllers/Admin/UserController.php`

### Views
```
resources/views/admin/
├── layout.blade.php           # Layout chung cho admin
├── dashboard.blade.php         # Trang dashboard
├── courses/
│   ├── index.blade.php        # Danh sách khóa học
│   ├── create.blade.php       # Tạo khóa học mới
│   ├── edit.blade.php         # Chỉnh sửa khóa học
│   └── show.blade.php         # Chi tiết khóa học
├── sections/
│   ├── create.blade.php       # Tạo chương mới
│   └── edit.blade.php         # Chỉnh sửa chương
├── lessons/
│   ├── create.blade.php       # Tạo bài học mới
│   └── edit.blade.php         # Chỉnh sửa bài học
└── users/
    ├── index.blade.php        # Danh sách người dùng
    ├── create.blade.php       # Tạo người dùng mới
    └── edit.blade.php         # Chỉnh sửa người dùng
```

## 🚀 Hướng dẫn chạy

### 1. Tạo symbolic link cho storage (để upload thumbnail)
```bash
php artisan storage:link
```

### 2. Chạy migrations (nếu chưa chạy)
```bash
php artisan migrate
```

### 3. Tạo dữ liệu mẫu (tùy chọn)
Bạn có thể tạo một số user mẫu:
```bash
php artisan tinker
```

Sau đó chạy:
```php
// Tạo Admin
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin'
]);

// Tạo Giảng viên
\App\Models\User::create([
    'name' => 'Giảng viên 1',
    'email' => 'gv1@example.com',
    'password' => bcrypt('password'),
    'role' => 'instructor'
]);

// Tạo Học viên
\App\Models\User::create([
    'name' => 'Học viên 1',
    'email' => 'hv1@example.com',
    'password' => bcrypt('password'),
    'role' => 'student'
]);
```

### 4. Chạy server
```bash
php artisan serve
```

### 5. Truy cập Admin Panel
```
http://localhost:8000/admin
```

## 🎨 Giao diện

- **Framework CSS**: Bootstrap 5.3
- **Icons**: Font Awesome 6.4
- **Design**: Modern, responsive, user-friendly
- **Color Scheme**: Blue gradient sidebar với white content area

## 📋 Routes Admin

```
GET  /admin                           -> Dashboard
GET  /admin/courses                   -> Danh sách khóa học
GET  /admin/courses/create            -> Form tạo khóa học
POST /admin/courses                   -> Lưu khóa học mới
GET  /admin/courses/{id}              -> Chi tiết khóa học
GET  /admin/courses/{id}/edit         -> Form chỉnh sửa khóa học
PUT  /admin/courses/{id}              -> Cập nhật khóa học
DELETE /admin/courses/{id}            -> Xóa khóa học

GET  /admin/courses/{id}/sections/create  -> Form tạo chương
POST /admin/courses/{id}/sections         -> Lưu chương mới
GET  /admin/sections/{id}/edit            -> Form chỉnh sửa chương
PUT  /admin/sections/{id}                 -> Cập nhật chương
DELETE /admin/sections/{id}               -> Xóa chương

GET  /admin/sections/{id}/lessons/create  -> Form tạo bài học
POST /admin/sections/{id}/lessons         -> Lưu bài học mới
GET  /admin/lessons/{id}/edit             -> Form chỉnh sửa bài học
PUT  /admin/lessons/{id}                  -> Cập nhật bài học
DELETE /admin/lessons/{id}                -> Xóa bài học

GET  /admin/users                     -> Danh sách người dùng
GET  /admin/users/create              -> Form tạo người dùng
POST /admin/users                     -> Lưu người dùng mới
GET  /admin/users/{id}/edit           -> Form chỉnh sửa người dùng
PUT  /admin/users/{id}                -> Cập nhật người dùng
DELETE /admin/users/{id}              -> Xóa người dùng
```

## ✅ Validation

Tất cả các form đều có validation:
- Khóa học: title, instructor_id, description, price, thumbnail (optional)
- Chương: title, position
- Bài học: title, youtube_url, duration, position
- Người dùng: name, email (unique), password, role

## 🔒 Bảo mật

- Password được hash bằng bcrypt
- CSRF protection cho tất cả forms
- Validation đầu vào
- Xác nhận trước khi xóa

## 📝 Ghi chú

- Thumbnail được lưu trong `storage/app/public/thumbnails`
- Cần chạy `php artisan storage:link` để tạo symbolic link
- Database đã được thiết kế sẵn với relationships đầy đủ
- Hỗ trợ pagination cho danh sách dài

## 🔜 Tính năng có thể mở rộng

1. **Authentication & Authorization**: Thêm middleware kiểm tra quyền admin
2. **File Upload**: Hỗ trợ upload video, tài liệu
3. **Rich Text Editor**: Sử dụng TinyMCE hoặc CKEditor cho mô tả
4. **Export/Import**: Excel cho dữ liệu khóa học
5. **Statistics & Reports**: Báo cáo chi tiết hơn
6. **Email Notifications**: Thông báo khi có đơn hàng mới
7. **Search & Filter**: Tìm kiếm và lọc nâng cao
8. **Bulk Actions**: Thao tác hàng loạt

## 🐛 Troubleshooting

### Lỗi 404 khi upload ảnh
```bash
php artisan storage:link
```

### Lỗi Class not found
```bash
composer dump-autoload
```

### Lỗi database
```bash
php artisan migrate:fresh
```

---

**Chúc bạn phát triển thành công! 🎉**
