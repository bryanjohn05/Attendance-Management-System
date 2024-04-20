
<?php
// Check if the delete button is clicked and USN is provided
if (isset($_POST['delete']) && isset($_POST['usn_to_delete'])) {
    $usn_to_delete = $_POST['usn_to_delete'];

    // Your database connection details
    $servername = "localhost";
    $username = "aimlg06";
    $password = "aimlg06";
    $database = "aimlg06";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to delete user by USN
    $delete = $conn->prepare("DELETE FROM students WHERE usn = ?");

    // Bind parameters
    $delete->bind_param("s", $usn_to_delete);

    // Execute the statement
    $delete_success = $delete->execute();

    if ($delete_success) {
        // Show a popup message after successful deletion
        echo '<script>alert("User with USN ' . $usn_to_delete . ' deleted successfully!");</script>';
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Error: " . $delete->error;
    }

    // Close prepared statement
    $delete->close();

    // Close database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="icon" type="image/x-icon" href="photos\logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/about.css">
</head>
<body> 
<header>
        <a href="dashboard.php" style="float: left;color: white;"><i class="fa-solid fa-circle-left" style="font-size: 30px;"></i></a>
        <h1>AttendEase <i class="fa-solid fa-qrcode"></i></h1>
    </header> 
    <section class="form-container1">
        <form action="" method="POST" class="usn_to_delete">
        <label class="del">Enter USN to delete:</label>
        <input class="delt" type="text" name="usn_to_delete" id="usn_to_delete" required>
        <input type="submit" value="Delete" class="btn3" name="delete">
    </form>
    </section>
    <footer>
        <p>&copy; 2024 Attendance Monitoring System.</p>
    </footer>
</body>
</html>
