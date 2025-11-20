<?php
// 1. Include connect.php
// (ไฟล์นี้ต้องสร้างตัวแปร $con สำหรับเชื่อมต่อฐานข้อมูล)
require 'connect.php';

// ตรวจสอบว่ามีการส่งข้อมูลมาแบบ POST หรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. รับค่าทั้งหมดจาก $_POST
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $fullname = $_POST['full-name']; // รับค่าจากฟอร์มที่มีชื่อ 'fullname'
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 3. ใช้ if-else (ตรวจสอบข้อมูล)

    // 3.1 ตรวจสอบว่ากรอกครบหรือไม่
    if (empty($username) || empty($phone) || empty($fullname) || empty($password) || empty($confirm_password)) {
        
        // else (ถ้าข้อมูลผิดพลาด):
        echo "กรุณากรอกข้อมูลให้ครบ";
        
    } 
    // 3.2 ตรวจสอบว่ารหัสผ่านตรงกันหรือไม่
    else if ($password != $confirm_password) {
        
        // else (ถ้าข้อมูลผิดพลาด):
        echo "รหัสผ่านไม่ตรงกัน";

    } 
    // 3.3 if (ถ้าทุกอย่างถูกต้อง):
    else {
        
        // --- เริ่มกระบวนการบันทึกข้อมูล ---

        // NEW SKILL (Hashing): สร้างรหัสผ่านที่ปลอดภัย
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // NEW SKILL (Prevent SQL Injection): ใช้ Prepared Statements

        // 1. เตรียมคำสั่ง (ใช้ ? placeholder)
        // (สมมติว่าตารางชื่อ 'customers' และคอลัมน์ชื่อ 'full-name' ตามโจทย์)
        $sql = "INSERT INTO users (username, phone, `fullname`, password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        // 2. ผูกค่า (s = string)
        // ผูกตัวแปร 4 ตัว ($username, $phone, $fullname, $hashed_password) เข้ากับ ? 4 ตัว
        mysqli_stmt_bind_param($stmt, "ssss", $username, $phone, $fullname, $hashed_password);

        // 3. สั่งทำงาน
        if (mysqli_stmt_execute($stmt)) {
            // ผลลัพธ์ : สำเร็จ
            echo "สมัครสมาชิกสำเร็จ! รหัสผ่านของคุณถูกเข้ารหัสเรียบร้อย";
        } else {
            // ถ้าเกิดข้อผิดพลาด (เช่น Username ซ้ำ)
            echo "เกิดข้อผิดพลาดในการบันทึก: " . mysqli_stmt_error($stmt);
        }

        // ปิด statement
        mysqli_stmt_close($stmt);
    }
    
    // ปิดการเชื่อมต่อ
    mysqli_close($conn);

} else {
    // ถ้าไม่ได้เข้ามาหน้านี้ผ่าน POST
    echo "วิธีการเข้าถึงไม่ถูกต้อง";
}
?>