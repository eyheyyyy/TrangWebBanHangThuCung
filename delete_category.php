<?php
include 'db.php';

$id = (int)$_GET['id'];

// 🔹 Lấy dữ liệu cũ để ghi log
$res = $conn->query("SELECT * FROM categories WHERE id=$id");
if ($res && $res->num_rows > 0) {
    $old = $res->fetch_assoc();
    $old_json = $conn->real_escape_string(json_encode($old, JSON_UNESCAPED_UNICODE));

    // 🔹 Tạo bảng category_logs nếu chưa có
    $conn->query("
        CREATE TABLE IF NOT EXISTS category_logs (
          id INT AUTO_INCREMENT PRIMARY KEY,
          category_id INT NOT NULL,
          action VARCHAR(50) NOT NULL,
          old_value JSON DEFAULT NULL,
          new_value JSON DEFAULT NULL,
          user_name VARCHAR(100) DEFAULT 'Admin',
          action_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
        )
    ");

    // 🔹 Ghi log hành động xóa
    $conn->query("INSERT INTO category_logs (category_id, action, old_value, user_name)
                  VALUES ($id, 'Xóa', '$old_json', 'Admin')");
}

// 🔹 Xóa danh mục
$conn->query("DELETE FROM categories WHERE id=$id");

// 🔹 Thông báo và quay lại trang quản lý
echo "<script>alert('🗑️ Đã xóa danh mục và ghi lại lịch sử!');window.location='manage_category.php';</script>";
exit;
?>
