<?php
$host = "localhost";
$user = "root"; // thay bằng user MySQL của bạn
$pass = "";
$dbname = "pet_sp";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
