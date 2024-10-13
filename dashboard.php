<?php
session_start();

// ตรวจสอบว่าผู้ใช้ล็อกอินอยู่
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

// เชื่อมต่อกับฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "myprojectsql");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลการเข้าใช้งาน
$email = $_SESSION['email'];

// ใช้ Prepared Statement เพื่อป้องกัน SQL Injection
$stmt = $conn->prepare("SELECT * FROM attendance WHERE employee_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Welcome to Your Dashboard</h2>
        <h4 class="text-center">Attendance Records for <?php echo htmlspecialchars($email); ?></h4>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Clock In</th>
                    <th>Clock Out</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['employee_email']); ?></td>
                            <td><?php echo htmlspecialchars($row['clock_in']); ?></td>
                            <td><?php echo $row['clock_out'] ? htmlspecialchars($row['clock_out']) : 'Not yet clocked out'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No attendance records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close(); // ปิด Prepared Statement
$conn->close(); // ปิดการเชื่อมต่อ
?>
