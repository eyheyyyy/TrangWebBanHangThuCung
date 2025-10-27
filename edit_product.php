<?php
include 'db.php';
<<<<<<< HEAD
=======

// Kiểm tra ID hợp lệ
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<script>
          alert('❌ ID sản phẩm không hợp lệ!');
          window.location='admin.php?page=product';
        </script>";
  exit;
}

>>>>>>> de1ef0a (init project)
$id = (int)$_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $result->fetch_assoc();

<<<<<<< HEAD
=======
if (!$product) {
  echo "<script>
          alert('⚠️ Không tìm thấy sản phẩm!');
          window.location='admin.php?page=product';
        </script>";
  exit;
}

// Khi người dùng bấm Cập nhật
>>>>>>> de1ef0a (init project)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $conn->real_escape_string($_POST['name']);
  $price = $conn->real_escape_string($_POST['price']);
  $image = $product['image'];

<<<<<<< HEAD
  // Xử lý upload ảnh mới
=======
  // Nếu có tải ảnh mới
>>>>>>> de1ef0a (init project)
  if (!empty($_FILES['image']['name'])) {
    $image = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/$image");
  }

  // ==== Ghi lịch sử trước khi cập nhật ====
  $old_arr = [
      'name' => $product['name'],
      'price' => $product['price'],
      'image' => $product['image']
  ];
  $new_arr = [
      'name' => $name,
      'price' => $price,
      'image' => $image
  ];
<<<<<<< HEAD
  $old_json = $conn->real_escape_string(json_encode($old_arr));
  $new_json = $conn->real_escape_string(json_encode($new_arr));
=======
  $old_json = $conn->real_escape_string(json_encode($old_arr, JSON_UNESCAPED_UNICODE));
  $new_json = $conn->real_escape_string(json_encode($new_arr, JSON_UNESCAPED_UNICODE));
>>>>>>> de1ef0a (init project)

  $conn->query("INSERT INTO product_log (product_id, action, old_value, new_value, user_name) 
                VALUES ($id, 'Cập nhật', '$old_json', '$new_json', 'Admin')");

<<<<<<< HEAD
  // Cập nhật sản phẩm
  $conn->query("UPDATE products SET name='$name', price='$price', image='$image' WHERE id=$id");

  header("Location: manage_product.php");
=======
  // Cập nhật dữ liệu sản phẩm
  $conn->query("UPDATE products SET name='$name', price='$price', image='$image' WHERE id=$id");

  echo "<script>
          alert('✅ Cập nhật sản phẩm thành công!');
          window.location='admin.php?page=product';
        </script>";
>>>>>>> de1ef0a (init project)
  exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
<<<<<<< HEAD
  <title>Sửa sản phẩm</title>
=======
  <title>✏️ Sửa sản phẩm</title>
>>>>>>> de1ef0a (init project)
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:#fff6f6;">
<div class="container py-4">
<<<<<<< HEAD
  <h3 class="text-danger mb-4">✏️ Sửa sản phẩm</h3>
  <form method="post" enctype="multipart/form-data">
=======
  <h3 class="text-danger mb-4">✏️ Sửa sản phẩm #<?= $product['id'] ?></h3>
  <form method="post" enctype="multipart/form-data" class="w-50">
>>>>>>> de1ef0a (init project)
    <div class="mb-3">
      <label class="form-label">Tên sản phẩm</label>
      <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Giá (đ)</label>
      <input type="number" name="price" value="<?= $product['price'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Ảnh hiện tại</label><br>
<<<<<<< HEAD
      <img src="uploads/<?= $product['image'] ?>" width="100" height="100"><br><br>
      <input type="file" name="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-danger">💾 Cập nhật</button>
    <a href="manage_product.php" class="btn btn-secondary">⬅️ Quay lại</a>
=======
      <img src="uploads/<?= htmlspecialchars($product['image']) ?>" width="120" height="120" class="border rounded"><br><br>
      <input type="file" name="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-danger">💾 Lưu thay đổi</button>
    <a href="admin.php?page=product" class="btn btn-secondary">⬅️ Quay lại</a>
>>>>>>> de1ef0a (init project)
  </form>
</div>
</body>
</html>
