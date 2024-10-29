<?php 
// db_connection.php
$host = '45.91.135.68';
$dbUser = 'root';
$dbPass = '5K,google';
$dbName = 'pcs_uat';

$conn = new mysqli($host, $dbUser, $dbPass, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>