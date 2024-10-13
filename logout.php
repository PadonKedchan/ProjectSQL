<?php
// เริ่ม session
session_start();

// ทำลาย session
session_destroy();

// เปลี่ยนเส้นทางไปยังหน้า login
header("Location: login.html");
exit();
?>
