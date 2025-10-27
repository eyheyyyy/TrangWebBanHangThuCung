<?php
include 'db.php';

// Lấy danh sách danh mục
$result = $conn->query("SELECT * FROM categories ORDER BY id DESC");

// Lấy lịch sử thao tác danh mục
$logs = $conn->query("SELECT * FROM category_logs ORDER BY action_time DESC");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý danh mục sản phẩm</title>
<style>
body{font-family:Inter,Arial;background:#fff3f8;color:#3a2b34;margin:0;padding:0;}
h2{text-align:center;margin:20px 0;color:#e280a6;}
.container{width:90%;margin:auto;background:#ffe9f2;border-radius:12px;box-shadow:0 0 12px #f3a8c2;padding:20px;}
a.btn{padding:6px 10px;border-radius:6px;text-decoration:none;font-size:14px;}
.btn-add{background:#e280a6;color:#fff;margin-bottom:10px;display:inline-block;}
.btn-edit{background:#4e89ff;color:#fff;}
.btn-del{background:#ff5c5c;color:#fff;}
.btn-log{background:#888;color:#fff;}
table{width:100%;border-collapse:collapse;margin-top:10px;}
th,td{border:1px solid #f3a8c2;padding:10px;text-align:center;}
th{background:#f7c1d9;}
tr:hover{background:#fff3f8;}
.section-title{color:#d44a7e;margin-top:40px;margin-bottom:10px;text-align:center;}
pre{white-space:pre-wrap;text-align:left;background:#fff;border:1px solid #f3a8c2;border-radius:6px;padding:5px;}
</style>
</head>
<body>
<h2>📚 Quản lý danh mục sản phẩm</h2>
<div class="container">
  <a href="add_category.php" class="btn btn-add">➕ Thêm danh mục</a>

  <!-- Bảng danh mục -->
  <table>
    <tr>
      <th>ID</th>
      <th>Tên danh mục</th>
      <th>Slug</th>
      <th>Mô tả</th>
      <th>Ngày tạo</th>
      <th>Hành động</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['slug']) ?></td>
      <td><?= htmlspecialchars($row['description']) ?></td>
      <td><?= $row['created_at'] ?></td>
      <td>
        <a href="edit_category.php?id=<?= $row['id'] ?>" class="btn btn-edit">✏️ Sửa</a>
        <a href="delete_category.php?id=<?= $row['id'] ?>" onclick="return confirm('Xóa danh mục này?')" class="btn btn-del">🗑️ Xóa</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>

  <!-- Bảng lịch sử thao tác -->
  <h3 class="section-title">📜 Lịch sử thao tác danh mục</h3>
  <table>
    <tr>
      <th>Thời gian</th>
      <th>ID danh mục</th>
      <th>Hành động</th>
      <th>Giá trị cũ</th>
      <th>Giá trị mới</th>
      <th>Người thao tác</th>
    </tr>
    <?php if ($logs->num_rows > 0): ?>
      <?php while ($log = $logs->fetch_assoc()): ?>
      <tr>
        <td><?= $log['action_time'] ?></td>
        <td><?= $log['category_id'] ?></td>
        <td><?= $log['action'] ?></td>
        <td><pre><?= htmlspecialchars($log['old_value']) ?></pre></td>
        <td><pre><?= htmlspecialchars($log['new_value']) ?></pre></td>
        <td><?= htmlspecialchars($log['user_name']) ?></td>
      </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="6">Chưa có lịch sử thao tác nào.</td></tr>
    <?php endif; ?>
  </table>
</div>
</body>
</html>
