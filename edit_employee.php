<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $shift = $_POST['shift'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "UPDATE EMPLOYEE SET ชื่อ = ?, รหัสแผนก = ?, รหัสกะ = ?, อีเมล = ?, เบอร์โทร = ? WHERE รหัสพนักงาน = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $department, $shift, $email, $phone, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    $stmt->close();
}
$conn->close();
?>
