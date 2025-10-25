<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>PetShop - Trang chủ</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h2>Xin chào, <?php echo $user['name']; ?>!</h2>
  <p>Bạn đang đăng nhập với quyền: <b><?php echo $user['role']; ?></b></p>
  <a href="logout.php">Đăng xuất</a>
</div>
</body>
</html>
