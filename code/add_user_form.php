<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usn = $_POST['usn'];
    $usn = filter_var($usn, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $dept = $_POST['dept'];
    $dept = filter_var($dept, FILTER_SANITIZE_STRING);

    

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

    // Prepare SQL statement to insert data into the database
    $insert = $conn->prepare("INSERT INTO students (usn, photo, fname, dept) VALUES (?, ?, ?, ?)");

    // Bind parameters
    $insert->bind_param("ssss", $usn, $image, $name, $dept);

    // Execute the statement
    $insert_success = $insert->execute();

    if ($insert_success) {
        // Check image size
        if ($image_size > 2000000) {
            echo 'Image size is too large!';
        } else {
                echo 'Student added successfully!';
                // Redirect to dashboard.php
                header('Location: dashboard.php');
                exit();
            
        }
    } else {
        echo "Error: " . $insert->error;
    }

    // Close prepared statement
    $insert->close();

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
    <title>New User</title>
    <link rel="icon" type="image/x-icon" href="photos\logo.png">
    <script src="https://kit.fontawesome.com/8751abb40d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/about.css">
</head>
<body> 
<header>
        <a href="dashboard.php" style="float: left;color: white;"><i class="fa-solid fa-circle-left" style="font-size: 30px;"></i></a>
        <h1>AttendEase <i class="fa-solid fa-qrcode"></i></h1>

    </header> 
    <section class="form-container">
        <form action="" enctype="multipart/form-data" method="POST">
            <h3>Add New Student</h3>
            <input type="text" name="usn" class="box" placeholder="Enter USN" required><br>
            <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png"><br>
            <input type="text" name="name" class="box" placeholder="Enter name" required><br>
            <input type="text" name="dept" class="box" placeholder="Enter Department" required><br>
            <input type="submit" value="ADD STUDENT" class="btn" name="submit"><br>
        </form>
    </section>
    <footer>
        <p>&copy; 2024 Attendance Monitoring System.</p>
    </footer>
</body>
</body>
</html>
