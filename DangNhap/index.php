<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập | Đăng ký</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* thêm phần icon phóng to chữ X */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <div class="header-top">
            <img src="petshop-logo.png" class="logo" alt="logo">
            <div class="search-box">
                <input type="text" placeholder="Tìm kiếm trong shop">
                <button>🔍</button>
            </div>
            <div class="header-icons">
                <span>🛒 giỏ hàng</span>
                <span>👤 Đăng nhập</span>
            </div>
        </div>

        <nav class="navbar">
            <a href="#">Trang chủ</a>
            <a href="#">giới thiệu</a>
            <a href="#">sản phẩm</a>
            <select>
                <option>Danh mục</option>
                <option>Thức ăn</option>
                <option>Phụ kiện</option>
            </select>
        </nav>
    </header>

    <!-- FORM -->
    <div class="login-container">
        <div class="login-box">
            <span class="close-btn">×</span>
            <h2>Đăng nhập | Đăng ký</h2>

            <form>
                <input type="text" placeholder="Vui lòng nhập mail hoặc sđt" required>
                <input type="password" placeholder="Mật khẩu" required>

                <button class="btn-login">Đăng nhập</button>

                <p class="small-text">
                    Bạn quên mật khẩu? Lấy lại mật khẩu <br>
                    Bạn chưa có tài khoản? <a href="#">Đăng ký</a>
                </p>

                <div class="social-login">
                    <button class="social-btn fb-btn">
                        <img src="facebook.png" alt="facebook"> FACEBOOK
                    </button>
                    <button class="social-btn gg-btn">
                        <img src="google.png" alt="google"> GMAIL
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
