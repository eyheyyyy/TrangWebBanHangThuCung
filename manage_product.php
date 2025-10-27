<<<<<<< HEAD
<?php include 'db.php'; ?>
=======
<?php include 'db.php'; ?> 
>>>>>>> de1ef0a (init project)
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý sản phẩm</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:#fff6f6;">
<div class="container py-4">
  <h3 class="text-center text-danger fw-bold mb-4">🛠️ Quản lý sản phẩm</h3>
<<<<<<< HEAD
  <div class="text-end mb-3">
    <a href="add_product.php" class="btn btn-success">➕ Thêm sản phẩm</a>
=======

  <div class="text-end mb-3">
    <a href="admin.php?page=product&action=add" class="btn btn-success">➕ Thêm sản phẩm</a>
>>>>>>> de1ef0a (init project)
  </div>

  <table class="table table-bordered table-hover text-center align-middle">
    <thead class="table-danger">
      <tr>
        <th>ID</th>
        <th>Ảnh</th>
        <th>Tên sản phẩm</th>
        <th>Giá</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
      while($row = $result->fetch_assoc()):
      ?>
      <tr>
        <td><?= $row['id'] ?></td>
<<<<<<< HEAD
        <td><img src="uploads/<?= $row['image'] ?>" width="80" height="80"></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= number_format($row['price'], 0, ',', '.') ?> đ</td>
        <td>
          <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏️ Sửa</a>
          <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" 
             onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')">🗑️ Xóa</a>
=======
        <td><img src="uploads/<?= htmlspecialchars($row['image']) ?>" width="80" height="80"></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= number_format($row['price'], 0, ',', '.') ?> đ</td>
        <td>
          <!-- Các nút hành động: dùng onclick để chắc chắn chuyển trang -->
          <button class="btn btn-warning btn-sm"
                  onclick="window.location='admin.php?page=product&action=edit&id=<?= $row['id'] ?>'">✏️ Sửa</button>

          <button class="btn btn-danger btn-sm"
                  onclick="if(confirm('Bạn có chắc muốn xóa sản phẩm này không?')) 
                           window.location='admin.php?page=product&action=delete&id=<?= $row['id'] ?>';">🗑️ Xóa</button>

          <button class="btn btn-secondary btn-sm"
                  onclick="window.location='admin.php?page=product&action=log&id=<?= $row['id'] ?>'">📜 Lịch sử</button>
>>>>>>> de1ef0a (init project)
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
