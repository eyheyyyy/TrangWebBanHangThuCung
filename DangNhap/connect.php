<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petshop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];

    $sql = "INSERT INTO users (email, password, name, gender, birthday) 
            VALUES ('$email', '$pass', '$name', '$gender', '$birthday')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Đăng ký thành công!'); window.location='index.html';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Đăng nhập thành công!');</script>";
    } else {
        echo "<script>alert('Sai tài khoản hoặc mật khẩu!'); window.location='index.html';</script>";
    }
}
$conn->close();
?>
