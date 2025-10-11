<?php
include 'db.php';
$id = (int)$_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $conn->real_escape_string($_POST['name']);
  $price = $conn->real_escape_string($_POST['price']);
  $image = $product['image'];

  // Xử lý upload ảnh mới
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
  $old_json = $conn->real_escape_string(json_encode($old_arr));
  $new_json = $conn->real_escape_string(json_encode($new_arr));

  $conn->query("INSERT INTO product_log (product_id, action, old_value, new_value, user_name) 
                VALUES ($id, 'Cập nhật', '$old_json', '$new_json', 'Admin')");

  // Cập nhật sản phẩm
  $conn->query("UPDATE products SET name='$name', price='$price', image='$image' WHERE id=$id");

  header("Location: manage_product.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Sửa sản phẩm</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:#fff6f6;">
<div class="container py-4">
  <h3 class="text-danger mb-4">✏️ Sửa sản phẩm</h3>
  <form method="post" enctype="multipart/form-data">
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
      <img src="uploads/<?= $product['image'] ?>" width="100" height="100"><br><br>
      <input type="file" name="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-danger">💾 Cập nhật</button>
    <a href="manage_product.php" class="btn btn-secondary">⬅️ Quay lại</a>
  </form>
</div>
</body>
</html>
