<<<<<<< HEAD
<?php
include 'db.php';
$id = (int)$_GET['id'];

// Lấy dữ liệu hiện tại để ghi lịch sử
$result = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $result->fetch_assoc();

if ($product) {
    // Chuyển dữ liệu thành JSON
=======
<?php 
include 'db.php';

// Kiểm tra có ID hợp lệ không
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin.php?page=product");
    exit;
}

$id = (int)$_GET['id'];

// Lấy dữ liệu hiện tại để ghi lịch sử
$result = $conn->query("SELECT * FROM products WHERE id = $id");
$product = $result->fetch_assoc();

if ($product) {
    // Chuyển dữ liệu sang JSON
>>>>>>> de1ef0a (init project)
    $old_json = $conn->real_escape_string(json_encode([
        'name' => $product['name'],
        'price' => $product['price'],
        'category' => $product['category'],
        'image' => $product['image']
    ]));

<<<<<<< HEAD
    // Ghi vào bảng product_log trước khi xóa
    $conn->query("INSERT INTO product_log (product_id, action, old_value, user_name) 
                  VALUES ($id, 'Xóa', '$old_json', 'Admin')");

    // Xóa sản phẩm
    $conn->query("DELETE FROM products WHERE id=$id");
}

header("Location: manage_product.php");
exit;
=======
    // Ghi log hành động XÓA
    $conn->query("
        INSERT INTO product_log (product_id, action, old_value, user_name) 
        VALUES ($id, 'Xóa', '$old_json', 'Admin')
    ");

    // Xóa sản phẩm trong bảng chính
    $conn->query("DELETE FROM products WHERE id = $id");

    // Thông báo & quay lại trang danh sách
    echo "<script>
        alert('✅ Đã xóa sản phẩm thành công!');
        window.location = 'admin.php?page=product';
    </script>";
    exit;
} else {
    echo "<script>
        alert('⚠️ Không tìm thấy sản phẩm!');
        window.location = 'admin.php?page=product';
    </script>";
    exit;
}
>>>>>>> de1ef0a (init project)
?>
