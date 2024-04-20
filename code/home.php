<?php
// Establishing a connection to the database
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

// Querying the database
$sql = "SELECT attendance, COUNT(*) AS count 
        FROM students 
        GROUP BY attendance";

$result = $conn->query($sql);

// Initializing variables to store counts
$presentCount = 0;
$absentCount = 0;

// Processing query results
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if($row['attendance'] == 'Present') {
            $presentCount = $row['count'];
        } else {
            $absentCount = $row['count'];
        }
    }
} 
// Closing the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AttendEase</title>
    <link rel="icon" type="image/x-icon" href="photos\logo.png">
    <script src="https://kit.fontawesome.com/8751abb40d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/dashboard.css">
</head>

<header class="header">
    <div id="logo-container">
    <h1 style="color:aliceblue">AttendEase <i class="fa-solid fa-qrcode"></i></h1>
    </div>
    <nav class="navibar">  
        <a href="home.php"><strong>Home</strong></a>
        <a href="dashboard.php"><strong>Dashboard</strong></a>
        <a href="about.html"><strong>About</strong></a>
        <div class="dropdown">
            <a style="cursor: pointer;"><i class="fa-solid fa-ellipsis-vertical"></i></a>
            <div class="dropdown-content">
                <a href="index.html"><i class="fa-solid fa-user"></i>&ThickSpace; Logout</a>
            </div>
        </div>
    </nav>
</header> 

<body>
    <div class="container1">
        <div class="main1">
        <!-- <h1>Attendance:</h1> -->
            <div id="donut_chart" style="width: 700px; height: 550px"></div>
    </div>
    <div class="aside">
        <h2>Welcome to AttendEase!<br> CLASS OF 2024 <br><span>"The way to monitor attendance, stay ahead, stay efficient"</span></h2>
        
    </div>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Attendance', 'Count'],
                ['Present', <?php echo $presentCount; ?>],
                ['Absent', <?php echo $absentCount; ?>]
            ]);

            var options = {
                title: 'Overall Attendance Status',
                pieHole: 0.4,
                backgroundColor: 'transparent', // Set background color to transparent
                colors: ['#CF0A0A', '#387ADF'], // Set custom colors for Present and Absent
                legend: {
                    position: 'bottom', // Position legend at the bottom
                    textStyle: {color: 'black'} // Set legend text color
                },
                titleTextStyle: {
                    fontName: 'Times New Roman', // Set font family to Times New Roman
                    color: 'black', // Set title text color
                    fontSize: 30 // Set title font size
                }

        };

            var chart = new google.visualization.PieChart(document.getElementById('donut_chart'));

            chart.draw(data, options);
        }
    </script>

    </div>
</body>
<footer>
    <p>&copy; 2024 Attendance Monitoring System.</p>
</footer>
<script>
        // Function to reload the page every 1 minute
        setInterval(function() {
            location.reload();
        }, 60000); // 60000 milliseconds = 1 minute
    </script>

</html>