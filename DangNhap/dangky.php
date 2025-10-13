<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký | Pet Shop</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #ffe6ef;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #f8c6d4;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 60px;
        }

        header img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
        }

        .search-box input {
            width: 220px;
            padding: 8px;
            border: none;
            border-radius: 5px;
        }

        .menu {
            background-color: #f4a8be;
            padding: 8px;
            text-align: center;
        }

        .menu a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            margin: 0 25px;
            background-color: #f9c3d1;
            padding: 8px 15px;
            border-radius: 5px;
        }

        .register-container {
            background-color: #ffdce8;
            width: 400px;
            margin: 60px auto;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 0 10px #f4a8be;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        input[type="text"],
        input[type="password"],
        input[type="date"] {
            width: 90%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #f08dad;
            color: white;
            margin-bottom: 15px;
        }

        input::placeholder {
            color: white;
        }

        .gender {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 15px;
        }

        .gender label {
            color: black;
        }

        button {
            background-color: #f08dad;
            color: white;
            border: none;
            padding: 10px 40px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 5px;
        }

        button:hover {
            background-color: #f2749d;
        }

        p {
            margin-top: 15px;
        }

        a {
            color: #c2185b;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <img src="petshop-logo.png" alt="Pet Shop">
        <div class="search-box">
            <input type="text" placeholder="Tìm kiếm trong shop">
        </div>
        <div>
            <span>🛒 Giỏ hàng</span> &nbsp;&nbsp;
            <span>👤 Đăng nhập</span>
        </div>
    </header>

    <div class="menu">
        <a href="#">Trang chủ</a>
        <a href="#">Giới thiệu</a>
        <a href="#">Sản phẩm</a>
        <a href="#">Danh mục</a>
    </div>

    <div class="register-container">
        <h2>Đăng nhập | Đăng ký</h2>
        <form>
            <input type="text" placeholder="Vui lòng nhập mail hoặc sđt" required>
            <input type="password" placeholder="Mật khẩu" required>

            <div class="gender">
                <label><input type="radio" name="gender" value="nam"> Nam</label>
                <label><input type="radio" name="gender" value="nu"> Nữ</label>
            </div>

            <input type="text" placeholder="Tên hiển thị" required>
            <input type="date" placeholder="mm/dd/yyyy">

            <button type="submit">Đăng ký</button>

            <p>Bạn đã có tài khoản? <a href="index.html">Đăng nhập</a></p>
        </form>
    </div>
</body>
</html>
