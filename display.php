<?php
include('check_login.php'); 
include('db_connection.php'); 
include('phpqrcode/qrlib.php'); // Include the QR code library

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
        // Generate the QR code based on the form data
        $formData = http_build_query($_GET); // Convert GET parameters to a query string
        $qrCodeFile = createQRCode($formData); // Create QR code
        echo '<img src="' . $qrCodeFile . '" alt="QR Code" class="qr-code">'; // Display QR code image
        ?>
        <table border="1" class="data-table">
            <tr>
                <th>TYPE</th><td><?php echo htmlspecialchars($_GET['TYPE']); ?></td>
            </tr>
            <tr>
                <th>THICKNESS</th><td><?php echo htmlspecialchars($_GET['THICKNESS']); ?></td>
            </tr>
            <tr>
                <th>WIDTH</th><td><?php echo htmlspecialchars($_GET['WIDTH']); ?></td>
            </tr>
            <tr>
                <th>LENGTH</th><td><?php echo htmlspecialchars($_GET['LENGTH']); ?></td>
            </tr>
            <tr>
                <th>WEIGHT</th><td><?php echo htmlspecialchars($_GET['WEIGHT']); ?></td>
            </tr>
            <tr>
                <th>LOT NO</th><td><?php echo htmlspecialchars($_GET['LOT_NO']); ?></td>
            </tr>
            <tr>
                <th>PO NO</th><td><?php echo htmlspecialchars($_GET['PO_NO']); ?></td>
            </tr>
            <tr>
                <th>VENDOR</th><td><?php echo htmlspecialchars($_GET['VENDOR']); ?></td>
            </tr>
            <tr>
                <th>PRINT DATE</th><td><?php echo htmlspecialchars($_GET['PRINT_DATE']); ?></td>
            </tr>
            <tr>
                <th>EXPIRE DATE</th><td><?php echo htmlspecialchars($_GET['EXPIRE_DATE']); ?></td>
            </tr>
            <tr>
                <th>REMARK</th><td><?php echo htmlspecialchars($_GET['REMARK']); ?></td>
            </tr>
            <tr>
                <th>STATUS</th><td><?php echo htmlspecialchars($_GET['STATUS']); ?></td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>
