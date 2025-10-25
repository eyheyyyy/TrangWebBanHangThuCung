<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng xuất - PetShop</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo">
      <img src="petshop-logo.png" alt="PetShop Logo">
    </div>

    <div class="search-bar">
      <div class="box">
        <input type="text" placeholder="Tìm kiếm trong shop">
        <i class="fas fa-search"></i>
      </div>
    </div>

    <div class="header-right">
      <a href="#"><i class="fas fa-shopping-cart"></i> giỏ hàng</a>
      <a href="dangnhap.php"><i class="fas fa-user"></i> Đăng nhập</a>
    </div>
  </header>

  <!-- Menu -->
  <nav>
    <a href="index.php">Trang chủ</a>
    <a href="#">giới thiệu</a>
    <a href="#">sản phẩm</a>
    <a href="#">Danh mục ▼</a>
  </nav>

  <!-- Nội dung -->
  <div class="login-container">
    <div class="login-box">
      <h2>Đăng xuất thành công!</h2>
      <p>Bạn đã đăng xuất khỏi hệ thống PetShop.</p>
      <a href="dangnhap.php"><button>Quay lại trang đăng nhập</button></a>
    </div>
  </div>

</body>
</html>
