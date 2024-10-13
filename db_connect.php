<?php
// ข้อมูลการเชื่อมต่อ
$servername = "localhost"; // หรือชื่อของเซิร์ฟเวอร์ MySQL ของคุณ
$username = "root"; // ชื่อผู้ใช้ MySQL (ค่าเริ่มต้นคือ root)
$password = ""; // รหัสผ่าน (ค่าเริ่มต้นคือค่าว่าง)
$dbname = "myprojectsql"; // ชื่อฐานข้อมูลที่คุณสร้าง

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully"; // ใช้ในการตรวจสอบว่าเชื่อมต่อสำเร็จ

// ไม่ควรปิดการเชื่อมต่อที่นี่
// $conn->close();
?>
