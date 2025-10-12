<?php
include 'db.php';
$id = (int)$_GET['id'];

// Lấy dữ liệu hiện tại để ghi lịch sử
$result = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $result->fetch_assoc();

if ($product) {
    // Chuyển dữ liệu thành JSON
    $old_json = $conn->real_escape_string(json_encode([
        'name' => $product['name'],
        'price' => $product['price'],
        'category' => $product['category'],
        'image' => $product['image']
    ]));

    // Ghi vào bảng product_log trước khi xóa
    $conn->query("INSERT INTO product_log (product_id, action, old_value, user_name) 
                  VALUES ($id, 'Xóa', '$old_json', 'Admin')");

    // Xóa sản phẩm
    $conn->query("DELETE FROM products WHERE id=$id");
}

header("Location: manage_product.php");
exit;
?>
