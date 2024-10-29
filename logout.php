<?php
session_start(); // เริ่ม session
session_destroy(); // ทำลาย session
header("Location: login.html"); // ส่งผู้ใช้ไปที่หน้า login
exit;
?>
