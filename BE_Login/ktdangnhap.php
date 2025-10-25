<?php
include("connect.php");

$email = 'admin@petshop.com';
$password = '123456';

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    echo "Hash trong database: <br>" . $row['password'] . "<br><br>";
    if (password_verify($password, $row['password'])) {
        echo "✅ Mật khẩu đúng!";
    } else {
        echo "❌ Sai mật khẩu hoặc hash bị lỗi!";
    }
} else {
    echo "❌ Không tìm thấy tài khoản admin!";
}
?>
