<?php
session_start(); // เริ่ม session

// ตรวจสอบการเข้าสู่ระบบ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "45.91.135.68";
    $username = "root";
    $password = "5K,google";
    $db_name = "pcs_uat";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$db_name;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // รับข้อมูลจากฟอร์ม
        $data = json_decode(file_get_contents("php://input"));
        $userName = $data->username;
        $userPassword = $data->password;

        // เตรียมคำสั่ง SQL
        $stmt = $conn->prepare("SELECT * FROM `01_user_profile` WHERE user_name = :username");
        $stmt->bindParam(':username', $userName);
        $stmt->execute();

        // ตรวจสอบผู้ใช้
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($userPassword, $user['user_password'])) {
                $_SESSION['user_id'] = $user['id']; // บันทึก user ID ใน session
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Connection failed. Please try again later.']);
    } finally {
        $conn = null; // ปิดการเชื่อมต่อ
    }
}
?>
