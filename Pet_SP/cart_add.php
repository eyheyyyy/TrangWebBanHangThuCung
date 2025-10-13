<?php
session_start();
include 'db.php';

if (!isset($_POST['product_id'])) {
  die("Thiếu dữ liệu sản phẩm.");
}

$id = (int)$_POST['product_id'];

// Lấy thông tin sản phẩm
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
  die("Sản phẩm không tồn tại.");
}

$product = $result->fetch_assoc();

// Lưu giỏ hàng vào session
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Nếu đã có sản phẩm trong giỏ → tăng số lượng
if (isset($_SESSION['cart'][$id])) {
  $_SESSION['cart'][$id]['quantity']++;
} else {
  $_SESSION['cart'][$id] = [
    'id' => $product['id'],
    'name' => $product['name'],
    'price' => $product['price'],
    'image' => $product['image'],
    'quantity' => 1
  ];
}

// Quay lại giỏ hàng
header("Location: cart.php");
exit;
?>
