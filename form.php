<?php 
include('check_login.php'); 
include('db_connection.php'); // Assuming you have a db_connection.php file for your DB connection

// Check if user_name is set in the session
if (!isset($_SESSION['loggedin'])) {
    die("User not logged in");
}

// Initialize an empty message variable
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from the form
    $TYPE = $_POST['TYPE'];
    $THICKNESS = $_POST['THICKNESS'];
    $WIDTH = $_POST['WIDTH'];
    $LENGTH = $_POST['LENGTH'];
    $WEIGHT = $_POST['WEIGHT'];
    $LOT_NO = $_POST['LOT_NO'];
    $PO_NO = $_POST['PO_NO'];
    $VENDOR = $_POST['VENDOR'];
    $PRINT_DATE = $_POST['PRINT_DATE'];
    $EXPIRE_DATE = $_POST['EXPIRE_DATE'];
    $REMARK = $_POST['REMARK'];
    $STATUS = $_POST['STATUS'];
    $UPDATE_DATE = date('Y-m-d H:i:s'); // Current datetime
    $UPDATED_BY = $_SESSION['loggedin']; // Get the username from the session

    // Prepare SQL statement
    $sql = "INSERT INTO qrcode_printing (TYPE, THICKNESS, WIDTH, LENGTH, WEIGHT, LOT_NO, PO_NO, VENDOR, PRINT_DATE, EXPIRE_DATE, REMARK, STATUS, UPDATE_DATE, UPDATED_BY) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Create a prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param('ssssssssssssss', $TYPE, $THICKNESS, $WIDTH, $LENGTH, $WEIGHT, $LOT_NO, $PO_NO, $VENDOR, $PRINT_DATE, $EXPIRE_DATE, $REMARK, $STATUS, $UPDATE_DATE, $UPDATED_BY);

        // Execute the statement
        if ($stmt->execute()) {
            $message = "Record added successfully."; // Set success message
        } else {
            $message = "Error: " . $stmt->error; // Set error message
        }
        
        // Close statement
        $stmt->close();
    } else {
        $message = "Error preparing statement: " . $conn->error; // Set error message
    }

    // Close connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Header Bar -->
    <div class="container-header">
        <div class="header-bar">
            <a href="logout.php" class="logout-button" style="display: flex; align-items: center; justify-content: center; background-color:
                 red; color: white; border: none; padding: 0; cursor: pointer; text-decoration: none; width: 60px; margin: 0; height: 60px; font-size: 1.1em;">Logout</a>
            <h1>Form</h1>
            <button class="list-button">List</button>
        </div>
    </div>

    <div class="container-form">
        <form method="POST" action="">
            <div class="form-group">
                <label for="TYPE">TYPE:</label>
                <input type="text" name="TYPE" id="TYPE" placeholder="">
            </div>
            <div class="form-group">
                <label for="THICKNESS">THICKNESS:</label>
                <input type="text" name="THICKNESS" id="THICKNESS" placeholder="">
            </div>
            <div class="form-group">
                <label for="WIDTH">WIDTH:</label>
                <input type="text" name="WIDTH" id="WIDTH" placeholder="">
            </div>
            <div class="form-group">
                <label for="LENGTH">LENGTH:</label>
                <input type="text" name="LENGTH" id="LENGTH" placeholder="">
            </div>
            <div class="form-group">
                <label for="WEIGHT">WEIGHT:</label>
                <input type="text" name="WEIGHT" id="WEIGHT" placeholder="">
            </div>
            <div class="form-group">
                <label for="LOT_NO">LOT NO:</label>
                <input type="text" name="LOT_NO" id="LOT_NO" placeholder="">
            </div>
            <div class="form-group">
                <label for="PO_NO">PO NO:</label>
                <input type="text" name="PO_NO" id="PO_NO" placeholder="" readonly>
            </div>
            <div class="form-group">
                <label for="VENDOR">VENDOR:</label>
                <input type="text" name="VENDOR" id="VENDOR" placeholder="">
            </div>
            <div class="form-group">
                <label for="PRINT_DATE">PRINT DATE:</label>
                <input type="date" name="PRINT_DATE" id="PRINT_DATE" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="EXPIRE_DATE">EXPIRE DATE:</label>
                <input type="date" name="EXPIRE_DATE" id="EXPIRE_DATE" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="REMARK">REMARK:</label>
                <input type="text" name="REMARK" id="REMARK" placeholder="">
            </div>
            <div class="form-group">
                <label for="STATUS">STATUS:</label>
                <input type="text" name="STATUS" id="STATUS" placeholder="" required>
            </div>
            <button type="submit">Submit</button>
        </form>

        <!-- Display the message below the submit button -->
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>

    <div class="container-footer">
        <button class="footer-button">SEARCH</button>
        <button class="footer-button" onclick="window.location.href='main.php';">HOME</button>
        <button class="footer-button" onclick="window.history.back();">BACK</button>
    </div>

    <script>
        // Function to get URL parameters
        function getUrlParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // Set the value of PO_NO from the URL parameter
        document.addEventListener('DOMContentLoaded', function() {
            const poNo = getUrlParameter('po_no');
            if (poNo) {
                document.getElementById('PO_NO').value = poNo; // Set the PO NO field
            }
        });
    </script>

</body>
</html>
