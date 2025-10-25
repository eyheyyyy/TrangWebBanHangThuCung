<?php
include("../connect.php");
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM users");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quản lý tài khoản - PetShop</title>
<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo">
      <img src="../petshop-logo.png" alt="PetShop Logo">
    </div>

    <div class="search-bar">
      <div class="box">
        <input type="text" placeholder="Tìm kiếm trong shop">
        <i class="fas fa-search"></i>
      </div>
    </div>

    <div class="header-right">
      <a href="#"><i class="fas fa-shopping-cart"></i> giỏ hàng</a>
      <a href="../dangxuat.php"><i class="fas fa-user"></i> Đăng xuất</a>
    </div>
  </header>

  <!-- Menu -->
  <nav>
    <a href="../index.php">Trang chủ</a>
    <a href="#">giới thiệu</a>
    <a href="#">sản phẩm</a>
    <a href="#">Danh mục ▼</a>
  </nav>

  <!-- Nội dung quản lý -->
  <div class="login-container">
    <div class="login-box" style="width:90%; max-width:900px;">
      <h2>Danh sách tài khoản</h2>
      <table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <tr style="background-color:#f8bfcf; color:#6a3c55;">
          <th>ID</th>
          <th>Email</th>
          <th>Họ tên</th>
          <th>Giới tính</th>
          <th>Ngày sinh</th>
          <th>Vai trò</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['gender']; ?></td>
          <td><?php echo $row['birthday']; ?></td>
          <td><?php echo $row['role']; ?></td>
        </tr>
        <?php } ?>
      </table>
      <br>
      <a href="../dangxuat.php">
        <button>Đăng xuất</button>
      </a>
    </div>
  </div>

</body>
</html>
