<?php
// รวมไฟล์เชื่อมต่อฐานข้อมูล
include 'db_connect.php';

// ตั้งค่าหมายเหตุเป็น JSON
header('Content-Type: application/json');

// ตรวจสอบว่ามีข้อมูลถูกส่งมาไหม
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
    // รับค่าที่ส่งมาจาก AJAX
    $name = $_POST['name'];
    $department = $_POST['department'];
    $shift = $_POST['shift'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // เตรียมคำสั่ง SQL เพื่อเพิ่มพนักงาน
    $sql = "INSERT INTO EMPLOYEE (ชื่อ, รหัสแผนก, รหัสกะ, อีเมล, เบอร์โทร) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // ตรวจสอบว่ามีข้อผิดพลาดในการเตรียมคำสั่ง SQL หรือไม่
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Statement preparation failed: ' . $conn->error]);
        exit;
    }

    // แก้ไขตรงนี้:
    $stmt->bind_param("sssss", $name, $department, $shift, $email, $phone);

    // ประมวลผลคำสั่ง
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();