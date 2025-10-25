<?php
// ==============================
// 🔗 CẤU HÌNH KẾT NỐI DATABASE
// ==============================

// Tên máy chủ MySQL (thường là localhost nếu chạy XAMPP)
$servername = "localhost";

// Tên tài khoản MySQL (mặc định của XAMPP là root)
$username = "root";

// Mật khẩu MySQL (nếu bạn không đặt thì để trống "")
$password = "";

// Tên cơ sở dữ liệu bạn đã tạo trong phpMyAdmin
$database = "petshop";

// ==============================
// ⚙️ THỰC HIỆN KẾT NỐI
// ==============================

$conn = mysqli_connect($servername, $username, $password, $database);

// Kiểm tra kết nối
if (!$conn) {
    die("❌ Kết nối thất bại: " . mysqli_connect_error());
}

// Thiết lập mã hóa UTF-8 để tránh lỗi tiếng Việt
mysqli_set_charset($conn, "utf8mb4");

// ✅ Thông báo kết nối thành công (tắt dòng này nếu không cần debug)
// echo "✅ Kết nối database thành công!";
?>
