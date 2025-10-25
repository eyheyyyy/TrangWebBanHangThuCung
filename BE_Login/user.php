<?php
session_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PetShop - Trang chủ</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .banner {
      width: 100%;
      height: 280px;
      background: url('pet-banner.jpg') center/cover no-repeat;
      border-radius: 15px;
      margin: 25px auto;
      max-width: 1000px;
    }

    .content {
      text-align: center;
      margin: 40px auto;
      color: #6a3c55;
      max-width: 1000px;
    }

    .products {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 25px;
      margin-bottom: 50px;
    }

    .product-card {
      background-color: #ffd6e0;
      border-radius: 15px;
      width: 200px;
      padding: 15px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
      transition: 0.3s;
    }

    .product-card:hover {
      background-color: #ffb8cb;
      transform: translateY(-5px);
    }

    .product-card img {
      width: 100%;
      height: 160px;
      border-radius: 12px;
      object-fit: cover;
    }

    .product-card h4 {
      margin: 10px 0 5px;
    }

    .product-card p {
      margin: 0;
      font-size: 14px;
      color: #6a3c55;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo">
      <img src="petshop-logo.png" alt="PetShop Logo">
    </div>

    <div class="search-bar">
      <div class="box">
        <input type="text" placeholder="Tìm kiếm sản phẩm...">
        <i class="fas fa-search"></i>
      </div>
    </div>

    <div class="header-right">
      <a href="#"><i class="fas fa-shopping-cart"></i> Giỏ hàng</a>
      <a href="dangnhap.php"><i class="fas fa-user"></i> Tài khoản</a>
    </div>
  </header>

  <!-- Menu -->
  <nav>
    <a href="#">Trang chủ</a>
    <a href="#">Thú cưng</a>
    <a href="#">Phụ kiện</a>
    <a href="#">Dịch vụ</a>
    <a href="#">Liên hệ</a>
  </nav>

  <!-- Banner -->
  <div class="banner"></div>

  <!-- Nội dung -->
  <div class="content">
    <h2>Chào mừng đến với PetShop 🐾</h2>
    <p>Nơi bạn tìm thấy mọi thứ cho thú cưng yêu quý!</p>

    <div class="products">
      <div class="product-card">
        <img src="pet1.jpg" alt="">
        <h4>Áo cho chó</h4>
        <p>120.000đ</p>
      </div>
      <div class="product-card">
        <img src="pet2.jpg" alt="">
        <h4>Dây dắt mèo</h4>
        <p>90.000đ</p>
      </div>
      <div class="product-card">
        <img src="pet3.jpg" alt="">
        <h4>Thức ăn hạt</h4>
        <p>250.000đ</p>
      </div>
      <div class="product-card">
        <img src="pet4.jpg" alt="">
        <h4>Ổ ngủ mềm</h4>
        <p>300.000đ</p>
      </div>
    </div>
  </div>

</body>
</html>
