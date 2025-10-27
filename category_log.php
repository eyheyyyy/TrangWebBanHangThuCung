<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Lịch sử danh mục</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4" style="background-color:#fff6f6;">
<h3 class="text-danger mb-4">📜 Lịch sử thao tác danh mục</h3>

<table class="table table-bordered table-hover text-center align-middle">
  <thead class="table-danger">
    <tr>
      <th>Thời gian</th>
      <th>ID danh mục</th>
      <th>Hành động</th>
      <th>Giá trị cũ</th>
      <th>Giá trị mới</th>
      <th>Người thao tác</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $logs = $conn->query("SELECT * FROM category_logs ORDER BY action_time DESC");
  while ($log = $logs->fetch_assoc()):
  ?>
    <tr>
      <td><?= $log['action_time'] ?></td>
      <td><?= $log['category_id'] ?></td>
      <td><?= $log['action'] ?></td>
      <td><pre><?= htmlspecialchars($log['old_value']) ?></pre></td>
      <td><pre><?= htmlspecialchars($log['new_value']) ?></pre></td>
      <td><?= $log['user_name'] ?></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>

<a href="admin.php?page=category" class="btn btn-secondary">⬅️ Quay lại</a>
</body>
</html>
