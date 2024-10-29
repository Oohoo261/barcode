<?php include('check_login.php'); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Header Bar -->
    <div class="container-header">
        <div class="header-bar">
            <a href="logout.php" class="logout-button" style="display: flex; align-items: center; justify-content: center; background-color:
                 red; color: white; border: none; padding: 0; cursor: pointer; text-decoration: none; width: 60px; margin: 0; height: 60px; font-size: 1.1em;">Logout</a>
            <h1>Main</h1>
            <button class="list-button">List</button>
        </div>
    </div>

    <div class="container-main">
        <form id="poForm">
            <div class="form-group">
                <label for="po-id">PO-ID:</label>
                <input type="text" id="po-id" placeholder="ENTER ID" required>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>

    <div class="container-footer">
        <button class="footer-button">SEARCH</button>
        <button class="footer-button">HOME</button>
        <button class="footer-button">BACK</button>
    </div>

    <script>
        // Handle the form submission
        document.getElementById('poForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            const poId = document.getElementById('po-id').value; // Get the PO-ID value
            // Redirect to form.html with the PO-ID as a URL parameter
            window.location.href = `form.php?po_no=${encodeURIComponent(poId)}`;
        });
    </script>

</body>
</html>
