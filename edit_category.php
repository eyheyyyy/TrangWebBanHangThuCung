<?php
include 'db.php';
$id = (int)$_GET['id'];
$category = $conn->query("SELECT * FROM categories WHERE id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $slug = trim($_POST['slug']);
  $desc = trim($_POST['description']);

  // 🔹 Lấy dữ liệu cũ để ghi log
  $old_data = $conn->query("SELECT * FROM categories WHERE id=$id")->fetch_assoc();
  $old_json = $conn->real_escape_string(json_encode($old_data, JSON_UNESCAPED_UNICODE));

  // 🔹 Cập nhật danh mục
  $stmt = $conn->prepare("UPDATE categories SET name=?, slug=?, description=? WHERE id=?");
  $stmt->bind_param("sssi", $name, $slug, $desc, $id);
  $stmt->execute();

  // 🔹 Dữ liệu mới sau khi cập nhật
  $new_data = [
    'name' => $name,
    'slug' => $slug,
    'description' => $desc
  ];
  $new_json = $conn->real_escape_string(json_encode($new_data, JSON_UNESCAPED_UNICODE));

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

  // 🔹 Ghi log hành động cập nhật
  $conn->query("INSERT INTO category_logs (category_id, action, old_value, new_value, user_name)
                VALUES ($id, 'Cập nhật', '$old_json', '$new_json', 'Admin')");

  echo "<script>alert('✅ Cập nhật danh mục thành công!');window.location='manage_category.php';</script>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Sửa danh mục</title>
<style>
body{background:#fff3f8;font-family:Inter,Arial;}
form{width:480px;margin:40px auto;background:#ffe9f2;padding:20px;border-radius:12px;box-shadow:0 0 12px #f3a8c2;}
label{display:block;margin-top:10px;font-weight:600;color:#3a2b34;}
input,textarea{width:100%;padding:8px;border:1px solid #f3a8c2;border-radius:8px;}
button{margin-top:15px;padding:10px 18px;border:0;border-radius:8px;cursor:pointer;font-weight:600;}
.btn-save{background:#4e89ff;color:white;}
.btn-back{background:gray;color:white;}
</style>
</head>
<body>
<h2 style="text-align:center;color:#e280a6;">✏️ Sửa danh mục</h2>
<form method="POST">
  <label>Tên danh mục</label>
  <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" required>

  <label>Slug (đường dẫn)</label>
  <input type="text" name="slug" value="<?= htmlspecialchars($category['slug']) ?>">

  <label>Mô tả</label>
  <textarea name="description" rows="3"><?= htmlspecialchars($category['description']) ?></textarea>

  <button type="submit" class="btn-save">💾 Lưu thay đổi</button>
  <a href="manage_category.php"><button type="button" class="btn-back">🏠 Quay lại</button></a>
</form>
</body>
</html>
