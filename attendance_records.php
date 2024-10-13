<?php
// รวมไฟล์เชื่อมต่อฐานข้อมูล
include 'db_connect.php';

// ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT 
            tr.รหัสบันทึก AS RecordID,
            tr.เวลาเข้างาน AS CheckInTime,
            tr.เวลาออกงาน AS CheckOutTime,
            e.รหัสพนักงาน AS EmployeeID,
            e.ชื่อ AS EmployeeName,
            tr.รหัสกะ AS ShiftID,
            tr.จำนวนชั่วโมงทำงาน AS HoursWorked,
            d.ชื่อแผนก AS Department
        FROM 
            TIME_RECORD tr
        JOIN 
            EMPLOYEE e ON tr.รหัสพนักงาน = e.รหัสพนักงาน
        JOIN 
            DEPARTMENT d ON e.รหัสแผนก = d.รหัสแผนก;";

$result = $conn->query($sql);

// ตรวจสอบผลลัพธ์ SQL
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<pre>";
        print_r($row); // แสดงผลข้อมูลที่ดึงออกมา
        echo "</pre>";
        $attendanceRecords[] = $row;
    }
} else {
    echo "No records found";
}

$conn->close();
?>
