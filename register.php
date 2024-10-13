<?php
// เชื่อมต่อกับฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "myprojectsql");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลจากฟอร์ม
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm-password']) ? $_POST['confirm-password'] : '';

if (empty($email) || empty($password) || empty($confirm_password)) {
    echo "Email and password are required.";
    exit();
}

// ตรวจสอบว่ารหัสผ่านและการยืนยันรหัสผ่านตรงกัน
if ($password !== $confirm_password) {
    echo "Passwords do not match.";
    exit();
}

// เข้ารหัสรหัสผ่าน
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// สร้างคำสั่ง SQL เพื่อเพิ่มผู้ใช้ใหม่
$sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    // เปลี่ยนเส้นทางไปยังหน้า login.html หรือ dashboard.html หลังจากลงทะเบียนเสร็จ
    header("Location: login.html");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
