<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AttendEase</title>
    <link rel="icon" type="image/x-icon" href="photos\logo.png">
    <script src="https://kit.fontawesome.com/8751abb40d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/dashboard.css">
    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("dashboard-table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td_name = tr[i].getElementsByTagName("td")[2]; 
                td_usn = tr[i].getElementsByTagName("td")[0]; 
                if (td_name || td_usn) {
                    txtValue_name = td_name.textContent || td_name.innerText;
                    txtValue_usn = td_usn.textContent || td_usn.innerText;
                    if (txtValue_name.toUpperCase().indexOf(filter) > -1 || txtValue_usn.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";                    
                    }
                }
            }
        }
        function filterTable() {
            var select, filter, table, tr, td, i;
            select = document.getElementById("filterSelect");
            filter = select.value.toUpperCase();
            table = document.getElementById("dashboard-table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[3]; 
                if (td) {
                    if (filter === "" || td.textContent.toUpperCase() === filter) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function updateAttendance() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("dashboard-body").innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", "update_attendance.php", true);
            xhr.send();
        }

        setInterval(updateAttendance, 20000);
    </script>
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
    <div class="main">
        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search by name,usn...">
        <select id="filterSelect" onchange="filterTable()">
            <option value="">Filter by department...</option>
            <option value="AIML">AIML</option>
            <option value="CSE">CSE</option>
            <option value="EC">EC</option>
            <option value="EEE">EEE</option>
            <option value="MECH">MECH</option>

        </select>
        <button class="btn1" onclick="window.location.href='add_user_form.php'">Add New User</button>
        <button class="btn1" onclick="window.location.href='delete_user.php'">Delete User</button>
        <button class="btn1" onclick="window.location.href='attendance.html'">Scanner</button>
        <table id="dashboard-table">
            <thead>
                <tr>
                    <th>USN</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Attendance</th>
                    <th>Updated at</th>
                </tr>
            </thead>
            <tbody id="dashboard-body">
                <?php
                // PHP code to connect to database and retrieve data
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
                // Close connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <footer>
        <p>&copy; 2024 Attendance Monitoring System.</p>
    </footer>
</body>
</html>
