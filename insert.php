<?php
include('check_login.php'); // Ensure the user is logged in
include('connect.php'); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $type = $_POST['TYPE'];
    $thickness = $_POST['THICKNESS'];
    $width = $_POST['WIDTH'];
    $length = $_POST['LENGTH'];
    $weight = $_POST['WEIGHT'];
    $lot_no = $_POST['LOT_NO'];
    $po_no = $_POST['PO_NO'];
    $vendor = $_POST['VENDOR'];
    $print_date = $_POST['PRINT_DATE'];
    $expire_date = $_POST['EXPIRE_DATE'];
    $remark = $_POST['REMARK'];

    // Prepare and execute SQL statement
    $sql = "INSERT INTO qrcode_printing (TYPE, THICKNESS, WIDTH, LENGTH, WEIGHT, LOT_NO, PO_NO, VENDOR, PRINT_DATE, EXPIRE_DATE, REMARK) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Create a prepared statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssssss", $type, $thickness, $width, $length, $weight, $lot_no, $po_no, $vendor, $print_date, $expire_date, $remark);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "Data inserted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
