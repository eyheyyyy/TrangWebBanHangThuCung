<?php
session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
  header("Location: dangnhap.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang quản trị - PetShop</title>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .admin-container {
      display: flex;
      margin-top: 20px;
    }

    /* Sidebar */
    .sidebar {
      width: 220px;
      background-color: #f8bfcf;
      padding: 20px;
      min-height: 85vh;
      border-radius: 10px;
      margin-left: 30px;
    }

    .sidebar h3 {
      color: #6a3c55;
      text-align: center;
      margin-bottom: 25px;
    }

    .sidebar a {
      display: block;
      color: #6a3c55;
      text-decoration: none;
      margin: 12px 0;
      font-weight: 600;
      transition: 0.3s;
    }

    .sidebar a:hover {
      color: #fff;
      background-color: #e07a9a;
      border-radius: 8px;
      padding: 8px;
    }

    /* Nội dung chính */
    .admin-content {
      flex: 1;
      padding: 30px;
      background-color: #fff;
      border-radius: 15px;
      margin: 0 30px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .admin-content h2 {
      color: #6a3c55;
      margin-bottom: 20px;
    }

    .dashboard-cards {
      display: flex;
      gap: 25px;
      flex-wrap: wrap;
    }

    .card {
      flex: 1;
      min-width: 200px;
      background-color: #ffd6e0;
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      color: #6a3c55;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      transition: 0.3s;
    }

    .card:hover {
      background-color: #ffb8cb;
      transform: translateY(-4px);
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo">
      <img src="../petshop-logo.png" alt="PetShop Logo">
    </div>

    <div class="search-bar">
      <div class="box">
        <input type="text" placeholder="Tìm kiếm trong quản lý...">
        <i class="fas fa-search"></i>
      </div>
    </div>

    <div class="header-right">
      <a href="../dangxuat.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
    </div>
  </header>

  <!-- Menu -->
  <nav>
    <a href="#">Bảng điều khiển</a>
    <a href="#">Quản lý tài khoản</a>
    <a href="#">Quản lý sản phẩm</a>
    <a href="#">Đơn hàng</a>
  </nav>

  <!-- Nội dung chính -->
  <div class="admin-container">
    <div class="sidebar">
      <h3>Menu Admin</h3>
      <a href="#"><i class="fas fa-users"></i> Quản lý tài khoản</a>
      <a href="#"><i class="fas fa-paw"></i> Quản lý sản phẩm</a>
      <a href="#"><i class="fas fa-shopping-bag"></i> Quản lý đơn hàng</a>
      <a href="#"><i class="fas fa-chart-bar"></i> Báo cáo doanh thu</a>
      <a href="../dangxuat.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
    </div>

    <div class="admin-content">
      <h2>Chào mừng, <?php echo $_SESSION['user']['name']; ?> 👋</h2>
      <p>Đây là bảng điều khiển quản trị PetShop.</p>

      <div class="dashboard-cards">
        <div class="card">
          <i class="fas fa-users fa-2x"></i>
          <h3>120</h3>
          <p>Tài khoản người dùng</p>
        </div>
        <div class="card">
          <i class="fas fa-paw fa-2x"></i>
          <h3>58</h3>
          <p>Sản phẩm hiện có</p>
        </div>
        <div class="card">
          <i class="fas fa-shopping-cart fa-2x"></i>
          <h3>25</h3>
          <p>Đơn hàng mới</p>
        </div>
        <div class="card">
          <i class="fas fa-dollar-sign fa-2x"></i>
          <h3>8.2M</h3>
          <p>Doanh thu tháng</p>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
