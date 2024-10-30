<?php
session_start(); // เริ่ม session

// ตรวจสอบว่า session 'loggedin' ถูกตั้งค่าและไม่ว่างเปล่า
if (!isset($_SESSION['loggedin']) || empty($_SESSION['loggedin'])) {
    // ถ้าไม่ได้เข้าสู่ระบบ ส่งผู้ใช้ไปที่หน้า login
    header("Location: login.html");
    exit;
}
?>
