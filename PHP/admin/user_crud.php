<?php
session_start();
require_once '../connect.php'; // ตรวจสอบ path ไฟล์ connect ให้ถูกต้อง

// ------------------------------------
// 1. เพิ่มข้อมูล (CREATE)
// ------------------------------------
if (isset($_POST['save_add'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; // ถ้าต้องการเข้ารหัสให้ใช้ password_hash($password, PASSWORD_DEFAULT);
    $fullname = $_POST['fullname'];
    $phone    = $_POST['phone'];    // เปลี่ยนจาก email เป็น phone
    $status   = $_POST['status'];   // เปลี่ยนจาก position เป็น status

    $sql = "INSERT INTO users (username, password, fullname, phone, status) 
            VALUES ('$username', '$password', '$fullname', '$phone', '$status')";
            
    if ($conn->query($sql) === TRUE) {
        $_SESSION['msg'] = "เพิ่มข้อมูลสำเร็จ!";
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
    }
    header("Location: user.php");
    exit();
}

// ------------------------------------
// 2. แก้ไขข้อมูล (UPDATE)
// ------------------------------------
if (isset($_POST['save_edit'])) {
    $id       = $_POST['id'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $phone    = $_POST['phone'];    // เปลี่ยนจาก email เป็น phone
    $status   = $_POST['status'];   // เปลี่ยนจาก position เป็น status

    // อัปเดตข้อมูล (ไม่รวมรหัสผ่าน เพื่อความปลอดภัย)
    $sql = "UPDATE users SET username='$username', fullname='$fullname', phone='$phone', status='$status' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['msg'] = "แก้ไขข้อมูลสำเร็จ!";
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
    }
    header("Location: user.php");
    exit();
}

// ------------------------------------
// 3. ลบข้อมูล (DELETE)
// ------------------------------------
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['msg'] = "ลบข้อมูลเรียบร้อย!";
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
    }
    header("Location: user.php");
    exit();
}

header("Location: user.php");
?>