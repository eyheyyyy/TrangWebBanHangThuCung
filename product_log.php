<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<<<<<<< HEAD
<title>Lịch sử quản lý sản phẩm</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4" style="background-color:#fff6f6;">
<h3 class="text-danger mb-4">📜 Lịch sử quản lý sản phẩm</h3>

<table class="table table-bordered table-hover">
  <thead class="table-danger">
    <tr>
      <th>Thời gian</th>
      <th>ID sản phẩm</th>
      <th>Hành động</th>
      <th>Giá trị cũ</th>
      <th>Giá trị mới</th>
      <th>Người thao tác</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $logs = $conn->query("SELECT * FROM product_log ORDER BY action_time DESC");
  while ($log = $logs->fetch_assoc()):
  ?>
    <tr>
      <td><?= $log['action_time'] ?></td>
      <td><?= $log['product_id'] ?></td>
      <td><?= $log['action'] ?></td>
      <td><pre><?= htmlspecialchars($log['old_value']) ?></pre></td>
      <td><pre><?= htmlspecialchars($log['new_value']) ?></pre></td>
      <td><?= $log['user_name'] ?></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>

<a href="index.php" class="btn btn-secondary">← Quay lại trang chủ</a>
=======
<title>📜 Lịch sử quản lý sản phẩm</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4" style="background-color:#fff6f6;">
<div class="container">
  <h3 class="text-center text-danger mb-4 fw-bold">📜 Lịch sử quản lý sản phẩm</h3>

  <div class="text-end mb-3">
    <a href="admin.php?page=product" class="btn btn-secondary">⬅️ Quay lại quản lý sản phẩm</a>
  </div>

  <table class="table table-bordered table-hover align-middle text-center">
    <thead class="table-danger">
      <tr>
        <th width="160">⏰ Thời gian</th>
        <th>ID sản phẩm</th>
        <th>Hành động</th>
        <th>Giá trị cũ</th>
        <th>Giá trị mới</th>
        <th>Người thao tác</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $logs = $conn->query("SELECT * FROM product_log ORDER BY action_time DESC");
      if ($logs->num_rows > 0):
        while ($log = $logs->fetch_assoc()):
      ?>
      <tr>
        <td><?= $log['action_time'] ?></td>
        <td><?= $log['product_id'] ?></td>
        <td>
          <?php
          $action = $log['action'];
          if ($action == 'Thêm') echo "<span class='badge bg-success'>$action</span>";
          elseif ($action == 'Cập nhật') echo "<span class='badge bg-warning text-dark'>$action</span>";
          elseif ($action == 'Xóa') echo "<span class='badge bg-danger'>$action</span>";
          else echo htmlspecialchars($action);
          ?>
        </td>
        <td class="text-start"><pre><?= htmlspecialchars($log['old_value']) ?></pre></td>
        <td class="text-start"><pre><?= htmlspecialchars($log['new_value']) ?></pre></td>
        <td><?= htmlspecialchars($log['user_name']) ?></td>
      </tr>
      <?php endwhile; else: ?>
        <tr><td colspan="6" class="text-muted">⚠️ Chưa có dữ liệu lịch sử nào.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
>>>>>>> de1ef0a (init project)
</body>
</html>
