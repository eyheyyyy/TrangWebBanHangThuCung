<?php
session_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký - PetShop</title>
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

  <!-- Form đăng ký -->
  <div class="login-container">
    <div class="login-box">
      <h2>Đăng ký</h2>

      <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="hoten" placeholder="Họ và tên" required>

        <select name="gioitinh" required>
          <option value="">-- Giới tính --</option>
          <option value="Nam">Nam</option>
          <option value="Nữ">Nữ</option>
        </select>

        <input type="date" name="ngaysinh" required>
        <input type="password" name="matkhau" placeholder="Mật khẩu" required>

        <button type="submit" name="register">Đăng ký</button>
      </form>

      <p>Đã có tài khoản? <a href="dangnhap.php">Đăng nhập</a></p>
    </div>
  </div>

</body>
</html>
