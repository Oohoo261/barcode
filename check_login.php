<?php
session_start(); // เริ่ม session

// ตรวจสอบว่า session 'loggedin' ถูกตั้งค่าหรือไม่
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // ถ้าไม่เข้าสู่ระบบ ส่งผู้ใช้ไปที่หน้า login
    header("Location: login.html");
    exit;
}
?>
