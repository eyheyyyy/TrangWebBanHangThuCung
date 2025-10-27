<?php
$host = "localhost";
$user = "root"; // thay bằng user MySQL của bạn
$pass = "";
<<<<<<< HEAD
$dbname = "pet_sp";
=======
$dbname = "shop";
>>>>>>> de1ef0a (init project)

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
