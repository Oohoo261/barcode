<?php
include('check_login.php'); 
include('db_connection.php'); 
include('phpqrcode/qrlib.php'); // Include the QR code library

// Check if PO_NO is provided in the URL
if (!isset($_GET['PO_NO'])) {
    die("No PO_NO provided.");
}

// Retrieve PO_NO from the URL
$PO_NO = $_GET['PO_NO'];

// Prepare SQL to retrieve data based on PO_NO
$sql = "SELECT * FROM qrcode_printing WHERE PO_NO = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $PO_NO);
$stmt->execute();
$result = $stmt->get_result();

// Check if data was found
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Concatenate data for QR code generation
    $formDataValues = [
        $row['TYPE'],
        $row['THICKNESS'],
        $row['WIDTH'],
        $row['LENGTH'],
        $row['WEIGHT'],
        $row['LOT_NO'],
        $row['PO_NO'],
        $row['VENDOR'],
        $row['PRINT_DATE'],
        $row['EXPIRE_DATE'],
        $row['REMARK'],
        $row['STATUS']
    ];
    $formDataString = implode(", ", $formDataValues); // Concatenate with commas
    $qrCodeFile = createQRCode($formDataString); // Create QR code
} else {
    die("No data found for the provided PO_NO.");
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Function to create QR code
function createQRCode($data) {
    $filename = 'qrcodes/qrcode_' . md5($data) . '.png'; // Create a unique filename
    QRcode::png($data, $filename, QR_ECLEVEL_L, 4); // Generate the QR code
    return $filename; // Return the path to the generated QR code
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Data</title>
    <link rel="stylesheet" href="styles-result.css">
</head>
<body>

    <div class="container-result">
        <div class="result-content">
            <?php
            // Display QR code image
            echo '<img src="' . $qrCodeFile . '" alt="QR Code" class="qr-code">';
            ?>
            <table border="1" class="data-table">
                <tr><th>TYPE</th><td><?php echo htmlspecialchars($row['TYPE']); ?></td></tr>
                <tr><th>THICKNESS</th><td><?php echo htmlspecialchars($row['THICKNESS']); ?></td></tr>
                <tr><th>WIDTH</th><td><?php echo htmlspecialchars($row['WIDTH']); ?></td></tr>
                <tr><th>LENGTH</th><td><?php echo htmlspecialchars($row['LENGTH']); ?></td></tr>
                <tr><th>WEIGHT</th><td><?php echo htmlspecialchars($row['WEIGHT']); ?></td></tr>
                <tr><th>LOT NO</th><td><?php echo htmlspecialchars($row['LOT_NO']); ?></td></tr>
                <tr><th>PO NO</th><td><?php echo htmlspecialchars($row['PO_NO']); ?></td></tr>
                <tr><th>VENDOR</th><td><?php echo htmlspecialchars($row['VENDOR']); ?></td></tr>
                <tr><th>PRINT DATE</th><td><?php echo htmlspecialchars($row['PRINT_DATE']); ?></td></tr>
                <tr><th>EXPIRE DATE</th><td><?php echo htmlspecialchars($row['EXPIRE_DATE']); ?></td></tr>
                <tr><th>REMARK</th><td><?php echo htmlspecialchars($row['REMARK']); ?></td></tr>
                <tr><th>STATUS</th><td><?php echo htmlspecialchars($row['STATUS']); ?></td></tr>
            </table>
        </div>
    </div>

</body>
</html>
