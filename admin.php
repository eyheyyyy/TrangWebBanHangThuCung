<?php
// Xác định trang & hành động đang gọi
$page = $_GET['page'] ?? 'category'; // category | product | log
$action = $_GET['action'] ?? 'list'; // list | add | edit | delete | log
$id = $_GET['id'] ?? 0;

// Kết nối CSDL
include 'db.php';

// 🩻 Bật hiển thị lỗi PHP để dễ kiểm tra vấn đề
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>PetShop Admin</title>
    <style>
        body {
            margin: 0;
            font-family: Inter, Arial;
            background: #fff3f8;
            color: #3a2b34;
        }
        nav {
            background: #e280a6;
            padding: 12px;
            text-align: center;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 18px;
            font-weight: bold;
            font-size: 16px;
        }
        nav a.active {
            text-decoration: underline;
        }
        .container {
            padding: 20px;
        }
    </style>
</head>
<body>

<nav>
    <a href="admin.php?page=category" class="<?= ($page=='category'?'active':'') ?>">📚 Danh mục</a>
    <a href="admin.php?page=product" class="<?= ($page=='product'?'active':'') ?>">🛒 Sản phẩm</a>
    <a href="admin.php?page=log" class="<?= ($page=='log'?'active':'') ?>">🧾 Lịch sử</a>
</nav>

<div class="container">
<?php
// Hiển thị nội dung tương ứng
switch ($page) {

    // =================== DANH MỤC ===================
    case 'category':
        if ($action == 'add') include 'add_category.php';
        elseif ($action == 'edit') include 'edit_category.php';
        elseif ($action == 'delete') include 'delete_category.php';
        else include 'manage_category.php';
        break;

    // =================== SẢN PHẨM ===================
    case 'product':
        if ($action == 'add') include 'add_product.php';
        elseif ($action == 'edit') include 'edit_product.php';
        elseif ($action == 'delete') include 'delete_product.php';
        elseif ($action == 'log') include 'product_log.php'; // ✅ Thêm phần xem lịch sử sản phẩm
        else include 'manage_product.php';
        break;

    // =================== LỊCH SỬ (Tổng hợp) ===================
    case 'log':
        include 'product_log.php';
        break;

    // =================== MẶC ĐỊNH ===================
    default:
        echo "<h3>Trang không tồn tại!</h3>";
}
?>
</div>

</body>
</html>
