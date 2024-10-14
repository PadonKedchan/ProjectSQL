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
    echo "<script>alert('Email and password are required.'); window.location.href='register.html';</script>";
    exit();
}

// ตรวจสอบว่ารหัสผ่านและการยืนยันรหัสผ่านตรงกัน
if ($password !== $confirm_password) {
    echo "<script>alert('Passwords do not match.'); window.location.href='register.html';</script>";
    exit();
}

// ตรวจสอบว่ามีอีเมลนี้อยู่ในฐานข้อมูลหรือไม่
$sql_check = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    echo "<script>alert('Email is already registered. Please use a different email.'); window.location.href='login.html';</script>";
    exit();
}

// เข้ารหัสรหัสผ่าน
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// สร้างคำสั่ง SQL เพื่อเพิ่มผู้ใช้ใหม่
$sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Registration successful! Redirecting to login.'); window.location.href='login.html';</script>";
    exit();
} else {
    echo "<script>alert('Error: " . $conn->error . "'); window.location.href='register.html';</script>";
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
