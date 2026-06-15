<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "agrikenya_clients";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch user details
$sql = "SELECT name, email, subject FROM client_messages";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div style=' height: 15px; margin-top: -15px; margin: 10px; padding: 10px; display: flex; align-items: center;'>";
        echo "<script src='https://cdn.lordicon.com/lordicon-1.1.0.js'></script>";
        echo "<lord-icon src='https://cdn.lordicon.com/lddlaptj.json' trigger='loop' delay='2000' style='width: 25px; height: 25px'></lord-icon>";
        echo "<div style='font-size: 13px; margin-left: 30px; margin-left: 2px;  width: 120px; font-weight: bold;'>" . $row['name'] . "</div>";
        echo "<div style='font-size: 13px; margin-left: 10px;  width: 150px; text-decoration: underline; font-weight: bold; font-style: italic;'>" . $row['email'] . "</div>";
        echo "<div style='font-size: 13px; color: #333; margin-left: 10px; font-weight: bold;  width: auto;'>" . $row['subject'] . "</div>";
        echo "</div>";
    }
} else {
    echo "No records found.";
}

$conn->close();
?>
