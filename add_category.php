<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $slug = trim($_POST['slug']);
  $desc = trim($_POST['description']);

  if ($name !== '') {
    // Thêm danh mục vào bảng categories
    $stmt = $conn->prepare("INSERT INTO categories (name, slug, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $slug, $desc);
    $stmt->execute();

    // Ghi lịch sử thêm danh mục vào bảng category_logs
    $cid = $conn->insert_id; // Lấy ID danh mục vừa thêm
    $new_data = json_encode([
      'name' => $name,
      'slug' => $slug,
      'description' => $desc
    ], JSON_UNESCAPED_UNICODE);
    $new_data = $conn->real_escape_string($new_data);

    // Nếu chưa có bảng category_logs thì tạo tự động
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

    // Thêm bản ghi log
    $conn->query("INSERT INTO category_logs (category_id, action, new_value, user_name)
                  VALUES ($cid, 'Thêm', '$new_data', 'Admin')");

    echo "<script>alert('✅ Thêm danh mục thành công!');window.location='manage_category.php';</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm danh mục</title>
<style>
body{background:#fff3f8;font-family:Inter,Arial;}
form{width:480px;margin:40px auto;background:#ffe9f2;padding:20px;border-radius:12px;box-shadow:0 0 12px #f3a8c2;}
label{display:block;margin-top:10px;font-weight:600;color:#3a2b34;}
input,textarea{width:100%;padding:8px;border:1px solid #f3a8c2;border-radius:8px;}
button{margin-top:15px;padding:10px 18px;border:0;border-radius:8px;cursor:pointer;font-weight:600;}
.btn-save{background:#e280a6;color:white;}
.btn-back{background:gray;color:white;}
</style>
</head>
<body>
<h2 style="text-align:center;color:#e280a6;">➕ Thêm danh mục</h2>
<form method="POST">
  <label>Tên danh mục</label>
  <input type="text" name="name" required>

  <label>Slug (đường dẫn)</label>
  <input type="text" name="slug" placeholder="vd: pate-cho-meo">

  <label>Mô tả</label>
  <textarea name="description" rows="3"></textarea>

  <button type="submit" class="btn-save">💾 Lưu</button>
  <a href="manage_category.php"><button type="button" class="btn-back">🏠 Quay lại</button></a>
</form>
</body>
</html>
