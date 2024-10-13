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

if (empty($email) || empty($password)) {
    echo "Email and password are required.";
    exit();
}

// ค้นหาผู้ใช้ในฐานข้อมูล
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

// ตรวจสอบว่าพบผู้ใช้หรือไม่
if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $row['password'])) {
            // ถ้ารหัสผ่านถูกต้อง ให้เริ่ม session
            session_start();
            $_SESSION['email'] = $email; // บันทึกอีเมลใน session

            // เปลี่ยนเส้นทางไปยังหน้า dashboard
            header("Location: dashboard.html");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email address.";
    }
} else {
    echo "Error executing query: " . $conn->error; // แสดงข้อผิดพลาดในการค้นหา
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
