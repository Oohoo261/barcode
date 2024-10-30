<?php
$servername = "45.91.135.68";
$username = "root";
$password = "5K,google";
$db_name = "pcs_uat";

session_start(); // เริ่ม session

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the JSON data from the request
    $data = json_decode(file_get_contents("php://input"));

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM `01_user_profile` WHERE user_name = :username AND user_password = :password");
    $stmt->bindParam(':username', $data->username);
    $stmt->bindParam(':password', $data->password);
    $stmt->execute();

    // Check if a user was found
    if ($stmt->rowCount() > 0) {
        // User found, set session variable to username
        $_SESSION['loggedin'] = $data->username; // เก็บชื่อ username ใน session
        echo json_encode(['success' => true]);
    } else {
        // User not found
        echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
