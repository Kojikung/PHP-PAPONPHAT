<?php
// 1. ต้องวาง session_start(); ไว้ บรรทัดบนสุด
session_start();

// 2. ตรวจสอบสิทธิ์ (check if logged in)
if (!isset($_SESSION['cus_id'])) {
    // 3. ถ้ายังไม่ได้ล็อกอิน:
    // (เราจะใช้ header() เพื่อ redirect ซึ่งดีกว่าการ echo)
    // (สำคัญ: header() ต้องถูกเรียกก่อนที่จะมี HTML/text ใดๆ ถูกส่งออกไป)
    header("Location: login.php");
    exit(); // จบการทำงานทันที
}

// 4. ถ้าโค้ดวิ่งมาถึงตรงนี้ได้ แสดงว่าล็อกอินแล้ว
// ดึงข้อมูล session มาเก็บในตัวแปร (และป้องกัน XSS)
$fullname = htmlspecialchars($_SESSION['fullname']);
$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าสมาชิก</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0; /* ลบ margin เริ่มต้น */
            background-color: #f4f4f4;
        }
        
        /* === 🎨 ส่วนของ Navbar (ที่เพิ่มเข้ามา) === */
        .navbar {
            display: flex; /* 1. สั่งให้เป็น Flexbox */
            justify-content: space-between; /* 2. จัดให้ "brand" อยู่ซ้าย และ "user" อยู่ขวา */
            align-items: center; /* 3. จัดให้อยู่กึ่งกลางแนวตั้ง */
            background-color: #333;
            padding: 10px 20px;
            color: white;
        }
        
        .navbar-brand a {
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            font-weight: bold;
        }

        .navbar-user {
            display: flex; /* 4. ใช้ Flexbox ซ้อน เพื่อจัดชื่อกับปุ่ม */
            align-items: center; /* 5. จัดให้ "ชื่อ" และ "ปุ่ม" อยู่กลาง */
        }

        .navbar-user span {
            margin-right: 15px; /* เว้นวรรคระหว่างชื่อกับปุ่ม */
        }

        .navbar-user a.logout-button {
            display: inline-block;
            padding: 8px 12px;
            background-color: #d9534f;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9em;
        }

        .navbar-user a.logout-button:hover {
            background-color: #c9302c;
        }
        /* === สิ้นสุดส่วน Navbar === */


        /* ส่วนเนื้อหาของหน้า (เพื่อให้ไม่ติดขอบ) */
        .content {
            padding: 20px;
        }
        
        h1 {
            color: #333;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="navbar-brand">  
            <a href="index.php">My Website</a> 
        </div>
        <div class="navbar-user">
            <span>สวัสดีคุณ, <?php echo $fullname; ?></span>
            
            <a href="logout.php" class="logout-button">ออกจากระบบ</a>
        </div>
    </nav>

    <div class="content">
        <h1>ยินดีต้อนรับสู่หน้าสมาชิก</h1>
        <p>Username ของคุณ: <?php echo $username; ?></p>
        <hr>
        <p>นี่คือเนื้อหาสำหรับสมาชิกที่ล็อกอินแล้วเท่านั้น</p>
    </div>

</body>
</html>