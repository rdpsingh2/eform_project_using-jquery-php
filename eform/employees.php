<?php
// index.php

// Database connection
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "employees";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all employee names and profile images
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='5'>";
    
    $count = 0;
    while($row = $result->fetch_assoc()) {
        // Start a new row for the first profile or after every 5 profiles
        if ($count % 5 == 0) {
            if ($count != 0) {
                echo "</tr>"; // Close previous row
            }
            echo "<tr>"; // Start new row
        }
        
        $name = htmlspecialchars($row['name']);
        $img_url = htmlspecialchars($row['img_url']);
        $userId = htmlspecialchars($row['id']);
        $img_url="uploads/profile/". $userId . ".png";
        
        echo "<td style='text-align: center;'>";
        echo "<a href='profile.php?name=$name'>$name</a><br>";
        echo "<a href='profile.php?name=$name'><img src=' $img_url' alt='Profile Image' width='100' height='100'></a>";
        echo "</td>";
        
        
        $count++;
    }
    
    // Close the last row if it was not closed
    if ($count % 5 != 0) {
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "No employees found.";
}

$conn->close();
?>
