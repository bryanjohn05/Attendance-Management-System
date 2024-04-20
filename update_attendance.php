<?php
// Establish connection to the database
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

// Update attendance records to "Absent" where necessary
$sql = "UPDATE students SET attendance = 'Absent' WHERE updated_at < DATE_SUB(NOW(), INTERVAL 20 SECOND) AND attendance = 'Present'";
if ($conn->query($sql) === TRUE) {
    // SQL query to retrieve data from the database
    $sql = "SELECT usn, photo, fname, dept, attendance,updated_at FROM students";
    $result = $conn->query($sql);

    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["usn"]."</td>";
        echo "<td><img src='".$row["photo"]."' alt='Student Photo' style='width: 100px;'></td>";
        echo "<td>".$row["fname"]."</td>";
        echo "<td>".$row["dept"]."</td>";
        echo "<td>".$row["attendance"]."</td>";
        echo "<td>".$row["updated_at"]."</td>";
        echo "</tr>";
    }
} else {
    // echo "Error updating attendance: " . $conn->error;
}

// Close connection
$conn->close();
?>
