# 🐾 Trang Web Bán Hàng Thú Cưng

Dự án web bán hàng thú cưng – xây dựng bằng **Node.js + Express**.  
Mục tiêu: cung cấp một hệ thống web cơ bản cho phép người dùng xem, thêm sản phẩm thú cưng và quản lý đặt hàng.

---

## 📁 Cấu trúc thư mục

```bash
TrangWebBanHangThuCung/
│
├── src/                    # Source code chính
│   ├── routes/             # Định nghĩa route (API endpoint)
│   │   ├── app.js
│   │   └── index.js
│   └── ...
│
├── test/                   # Nơi để viết các file test
│
├── .env                    # Biến môi trường (port, DB,...)
├── .gitignore              # File cấu hình git
├── Dockerfile              # Dùng để build docker container (tùy chọn)
├── package.json            # Thông tin dự án & dependencies
├── package-lock.json
└── README.md               # File hướng dẫn này
