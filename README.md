# Ứng dụng Laravel & Vue với Docker

Dự án này bao gồm Backend Laravel và Frontend Vue.js, được đóng gói bằng Docker.

## Yêu cầu cài đặt
- Đã cài đặt Docker & Docker Desktop.
- Đã cài đặt Git.

## Hướng dẫn cài đặt (Trên máy mới)

1. **Tải source code về máy**
   ```bash
   git clone https://github.com/ngothithuynhi/Docker.git
   cd Docker
   ```

2. **Cấu hình môi trường cho Backend**
   - Copy file môi trường mẫu:
     ```bash
     cp be/.env.example be/.env
     ```
   - *Lưu ý: Docker sẽ tự động nhận các biến môi trường cấu hình database nếu bạn sử dụng file `docker-compose.yml` có sẵn.*

3. **Khởi chạy ứng dụng**
   - Chạy các container (chế độ chạy ngầm):
     ```bash
     docker compose up -d --build
     ```

4. **Khởi tạo Backend** (Chỉ cần làm lần đầu)
   - Cài đặt các thư viện PHP:
     ```bash
     docker compose exec backend composer install
     ```
   - Tạo Key cho ứng dụng:
     ```bash
     docker compose exec backend php artisan key:generate
     ```
   - Chạy Migrations để khởi tạo Database:
     ```bash
     docker compose exec backend php artisan migrate
     ```

5. **Truy cập ứng dụng**
   - **Frontend (Web)**: http://localhost:5173
   - **Backend API**: http://localhost:8000

## Tính năng
- **Upload ảnh bằng URL**: Dán link ảnh vào để lưu vào database và xem trong thư viện ảnh.
