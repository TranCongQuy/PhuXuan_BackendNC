# phu-xuan-blog

Blog app xây dựng với Laravel 10 – Bài tập môn IT3042 Đại học Phú Xuân.

## Tính năng

- Quản lý bài viết (CRUD)
- Danh mục, Tag, Comments
- Tìm kiếm, lọc danh mục, sắp xếp (mới nhất / phổ biến nhất)
- Phân trang 10 bài/trang
- Soft Delete và khôi phục bài viết
- Hiển thị thời gian đọc ước tính (reading time)
- Đếm số bình luận cho mỗi bài viết

## Cài đặt

```bash
# Clone repository
git clone https://github.com/TranCongQuy/PhuXuan_BackendNC.git
cd phu-xuan-blog

# Cài dependencies
composer install

# Copy file .env và tạo key
cp .env.example .env
php artisan key:generate

# Cập nhật DB_DATABASE, DB_USERNAME, DB_PASSWORD trong .env
# Sau đó chạy migration và seed
php artisan migrate:fresh --seed

# Chạy server
php artisan serve
```
