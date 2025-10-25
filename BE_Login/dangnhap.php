<?php
session_start();
include("connect.php");

if (isset($_POST['login'])) {
    $email = trim($_POST['username']);
    $password = trim($_POST['password']);

    // 1️⃣ Lấy thông tin user theo email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // 2️⃣ Nếu tìm thấy user
    if ($row = mysqli_fetch_assoc($result)) {
        // 3️⃣ Kiểm tra mật khẩu
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row; // Lưu session

            // 4️⃣ Phân quyền
            if ($row['role'] === 'admin') {
                header("Location: admin/admin_home.php");
            } else {
                header("Location: user_home.php");
            }
            exit();
        } else {
            echo "<script>alert('Mật khẩu không đúng!');</script>";
        }
    } else {
        echo "<script>alert('Email không tồn tại!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập - PetShop</title>
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
      <a href="#"><i class="fas fa-shopping-cart"></i> Giỏ hàng</a>
      <a href="dangnhap.php"><i class="fas fa-user"></i> Đăng nhập</a>
    </div>
  </header>

  <!-- Menu -->
  <nav>
    <a href="index.php">Trang chủ</a>
    <a href="#">Giới thiệu</a>
    <a href="#">Sản phẩm</a>
    <a href="#">Danh mục ▼</a>
  </nav>

  <!-- Form đăng nhập -->
  <div class="login-container">
    <div class="login-box">
      <h2>Đăng nhập | Đăng ký</h2>

      <form method="POST" action="">
        <input type="text" name="username" placeholder="Nhập email của bạn" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit" name="login">Đăng nhập</button>
      </form>

      <p><a href="#">Bạn quên mật khẩu?</a> Lấy lại mật khẩu</p>
      <p>Bạn chưa có tài khoản? <a href="dangky.php">Đăng ký</a></p>

      <div class="social-login">
        <button class="facebook"><i class="fab fa-facebook-f"></i> FACEBOOK</button>
        <button class="gmail"><i class="fab fa-google"></i> GMAIL</button>
      </div>
    </div>
  </div>

</body>
</html>
