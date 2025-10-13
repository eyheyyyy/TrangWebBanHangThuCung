<?php
include 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy thông tin sản phẩm theo id
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
  die("<h4 class='text-center text-danger mt-5'>Không tìm thấy sản phẩm!</h4>");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($product['name']); ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body { background-color: #fff6f6; }
  .btn-pink { background-color: #ffb6c1; color: white; border: none; }
  .btn-pink:hover { background-color: #f68a9e; color: white; }
</style>
</head>
<body>

<div class="container py-4">
  <a href="index.php" class="btn btn-outline-secondary mb-3"> ← Quay lại</a>

  <div class="row">
    <div class="col-md-5 text-center">
      <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" 
           class="img-fluid border rounded p-3 bg-white shadow-sm" alt="Ảnh sản phẩm">
    </div>

    <div class="col-md-7">
      <h3 class="fw-bold text-danger"><?php echo htmlspecialchars($product['name']); ?></h3>
      <p class="fs-5 text-success fw-bold">
        <?php echo number_format($product['price'], 0, ',', '.'); ?> đ
      </p>
      <p><strong>Danh mục:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
      <p><strong>Mô tả:</strong> <?php echo nl2br(htmlspecialchars($product['description'] ?? 'Đang cập nhật...')); ?></p>

      <div class="mt-4">
        <form method="post" action="cart_add.php" class="d-inline">
          <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
          <button type="submit" class="btn btn-outline-danger">🛒 Thêm vào giỏ hàng</button>
        </form>
        <a href="checkout.php?id=<?php echo $product['id']; ?>" class="btn btn-pink">💖 Mua ngay</a>
      </div>
    </div>
  </div>
</div>

</body>
</html>
