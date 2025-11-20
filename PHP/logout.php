<?php
// 1. ต้องวาง session_start(); ไว้ บรรทัดบนสุด
session_start();

// 2. ทำลาย Session ทั้งหมด:
session_unset();    // ลบตัวแปร Session ทั้งหมด
session_destroy();  // ทำลาย Session

// 3. ส่งกลับไปหน้าล็อกอิน
// (เราจะส่งกลับไปที่ 'login_form.php' ซึ่งเป็นฟอร์ม Glassmorphism สวยๆ)
header('Location: login.php');
exit();
?>