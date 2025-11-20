<?php
// 1. เริ่ม Session
session_start();

// 2. Include connect.php
include_once 'connect.php';

/*
 * ฟังก์ชันช่วยสำหรับพิมพ์ HTML และ SweetAlert2
 */
function show_alert($script_content) {
    echo "<!DOCTYPE html>
    <html lang='th' data-bs-theme='dark'>
    <head>
        <meta charset='UTF-8'><title>Login Status</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <style>
            body { background-color: #0a0a0a; display: flex;
                   align-items: center; justify-content: center; height: 100vh; }
        </style>
    </head>
    <body><script>$script_content</script></body>
    </html>";
}

// 3. ตรวจสอบว่าส่งมาแบบ POST หรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // รับค่าจากฟอร์ม
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // รหัสผ่านที่กรอกมา (ยังไม่ Hash)

    // 4. ดึงข้อมูล User จากฐานข้อมูล (แก้ชื่อคอลัมน์ให้ตรงกับ DB ของคุณ)
    // เลือก id, username, password, fullname, status
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        // 5. ตรวจสอบรหัสผ่าน
        // หมายเหตุ: ถ้าใน DB เป็นรหัสผ่านธรรมดา (เช่น 1234) ให้ใช้: if ($password == $hashed_password) {
        // ถ้าใน DB เป็น Hash (เช่น $2y$10$...) ให้ใช้: if (password_verify($password, $hashed_password)) {
        
        // ใช้ password_verify เพื่อรองรับทั้ง admin (hash) และ user (plain text)
        // หรือถ้า user เก่ายังเป็น plain text ให้เช็คแบบผสม:
        $is_valid = false;
        if (password_verify($password, $hashed_password)) {
            $is_valid = true;
        } elseif ($password == $hashed_password) {
             // กรณีรหัสใน DB ยังไม่ได้ Hash (เช่น user: cust01)
            $is_valid = true;
        }

        if ($is_valid) {
            // --- Login สำเร็จ ---

            // แก้ไข: ใช้ $row['id'] ให้ตรงกับฐานข้อมูล (เดิมเขียน cus_id ผิด)
            $_SESSION['cus_id'] = $row['id']; 
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['status'] = $row['status']; // เก็บสถานะไว้ใช้งาน

            // ** ตรวจสอบ Status เพื่อแยกหน้าที่จะไป **
            $redirect_page = 'profile.php'; // ค่าเริ่มต้น (User)
            if ($row['status'] == 'admin') {
                $redirect_page = 'admin/index.php'; // ถ้าเป็น Admin ไปหน้า Index
            }

            // เตรียมข้อมูลสำหรับแสดงผล
            $fullname_safe = htmlspecialchars($row['fullname'], ENT_QUOTES);
            
            $script = "
            Swal.fire({
                title: 'Login สำเร็จ!', 
                text: 'ยินดีต้อนรับคุณ $fullname_safe ($row[status])', 
                icon: 'success',
                timer: 2000, 
                showConfirmButton: false,
                background: '#1a1a1a', 
                color: '#eee'
            }).then(() => {
                // ส่งไปยังหน้าที่กำหนดตาม Status
                window.location.href = '$redirect_page'; 
            });
            ";
            show_alert($script);

        } else {
            // --- รหัสผ่านผิด ---
            $script = "
            Swal.fire({
                title: 'Login ล้มเหลว', 
                text: 'รหัสผ่านไม่ถูกต้อง', 
                icon: 'error',
                confirmButtonText: 'ลองใหม่', 
                background: '#1a1a1a', 
                color: '#eee'
            }).then(() => { window.history.back(); });
            ";
            show_alert($script);
        }

    } else {
        // --- ไม่พบ Username ---
        $script = "
        Swal.fire({
            title: 'ไม่พบผู้ใช้', 
            text: 'ไม่พบชื่อผู้ใช้นี้ในระบบ', 
            icon: 'warning',
            confirmButtonText: 'ตรวจสอบ', 
            background: '#1a1a1a', 
            color: '#eee'
        }).then(() => { window.history.back(); });
        ";
        show_alert($script);
    }

} else {
    // ไม่ได้เข้าผ่าน POST
    header("Location: login.php");
    exit();
}
?>  