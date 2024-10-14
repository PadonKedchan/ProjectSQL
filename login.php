<?php
session_start();

// เชื่อมต่อกับฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "myprojectsql");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลจากฟอร์ม
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo "<script>alert('Email and password are required.'); window.location.href='login.html';</script>";
    exit();
}

// ตรวจสอบการล็อกอิน
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // ตรวจสอบรหัสผ่านที่เข้ารหัส
    if (password_verify($password, $row['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        $loginMessage = "Login successful!";
    } else {
        $loginMessage = "Invalid email or password!";
    }
} else {
    $loginMessage = "Invalid email or password!";
}

// เริ่มแสดงผล HTML
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212; /* สีพื้นหลัง */
            color: #ffffff; /* สีตัวอักษร */
        }
        .container {
            margin-top: 5rem; /* ระยะห่างด้านบน */
            padding: 2rem;
            background-color: #1f1f1f; /* สีพื้นหลังของกล่องผลลัพธ์ */
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5); /* เงา */
        }
        .btn-primary {
            background-color: #4caf50; /* สีปุ่มหลัก */
            border: none; /* ไม่มีขอบ */
        }
        .btn-primary:hover {
            background-color: #45a049; /* สีปุ่มเมื่อเลื่อนเมาส์ */
        }
        .alert {
            background-color: #333; /* สีพื้นหลังของการแจ้งเตือน */
            color: #fff; /* สีตัวอักษรของการแจ้งเตือน */
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($loginMessage)): ?>
            <div class="alert alert-<?php echo strpos($loginMessage, 'successful') !== false ? 'success' : 'danger'; ?>" role="alert">
                <?php echo $loginMessage; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
            <h2 class="text-center">Welcome, <?php echo $_SESSION['email']; ?>!</h2>
            <p class="text-center">You are now logged in.</p>
            <div class="text-center">
                <a href="dashboard.html" class="btn btn-primary">Go to Dashboard</a>
            </div>
        <?php else: ?>
            <h2 class="text-center">Login Failed</h2>
            <p class="text-center">Please try again.</p>
            <div class="text-center">
                <a href="login.html" class="btn btn-secondary">Back to Login</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

