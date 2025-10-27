<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin.php?page=product');
    exit;
}

$name         = trim($_POST['name'] ?? '');
$category_id  = (int)($_POST['category_id'] ?? 0);
$sku          = trim($_POST['sku'] ?? '');
$price        = (float)($_POST['price'] ?? 0);
$qty          = (int)($_POST['qty'] ?? 0);
$description  = trim($_POST['description'] ?? '');
$performed_by = $_POST['performed_by'] ?? 'admin';

// Ảnh sản phẩm
$imagePath = null;
if (!empty($_FILES['image']['name'])) {
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_\-]/','',basename($_FILES['image']['name'], ".$ext")) . '.' . $ext;
    $target = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $imagePath = 'uploads/' . $filename;
    }
}

// Thêm sản phẩm
$stmt = $conn->prepare("INSERT INTO products (category_id, name, sku, price, qty, description, image, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("issdiss", $category_id, $name, $sku, $price, $qty, $description, $imagePath);
$ok = $stmt->execute();

if ($ok) {
    $product_id = $stmt->insert_id;

    // Ghi log
    $new_value = json_encode([
        'name' => $name,
        'price' => $price,
        'qty' => $qty,
        'sku' => $sku,
        'category_id' => $category_id,
        'description' => $description,
        'image' => $imagePath
    ], JSON_UNESCAPED_UNICODE);

    $conn->query("INSERT INTO product_log (product_id, action, new_value, user_name, action_time)
                  VALUES ($product_id, 'Thêm', '$new_value', '$performed_by', NOW())");

    echo "<script>
        alert('✅ Đã thêm sản phẩm thành công!');
        window.location='admin.php?page=product';
    </script>";
} else {
    echo "<script>
        alert('❌ Lỗi khi thêm sản phẩm!');
        window.location='admin.php?page=product';
    </script>";
}
