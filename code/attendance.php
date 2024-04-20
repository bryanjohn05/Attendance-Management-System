<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  
    $data = json_decode(file_get_contents("php://input"));

   
    if (isset($data->qrData)) {
        // Extract the qrData
        $qrData = $data->qrData;

        // Database configuration
        $servername = "localhost";
        $username = "aimlg06";
        $password = "aimlg06";
        $dbname = "aimlg06";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

       
        $sql = "UPDATE students SET attendance = 'Present' WHERE usn = ?";

       
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $qrData);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Attendance updated successfully<br>";
        } else {
            echo "Error updating attendance: " . $stmt->error . "<br>";
        }

        // Close the connection
        $conn->close();

        echo "Scanned QR code data: " . $qrData;
    } else {
       
        http_response_code(400); // Bad Request
        echo "Error: qrData not found in the request<br>";
    }
} else {
   
    http_response_code(405); 
    echo "Error: Only POST requests are allowed<br>";
}
?>
