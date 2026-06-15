<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrikenya_admin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM approved_report";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table style='width: 80%; font-size: 14px;' border='1'>";
    echo "<tr><th style='border: 1px solid black;'>Name</th><th style='border: 1px solid black;'>Email</th><th style='border: 1px solid black;'>Phone</th><th style='border: 1px solid black;'>Location</th><th style='border: 1px solid black;'>Product</th><th style='border: 1px solid black;'>Message</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='border: 1px solid black; height: 20px;'>" . $row["name"] . "</td>";
        echo "<td style='border: 1px solid black; height: 20px;'>" . $row["email"] . "</td>";
        echo "<td style='border: 1px solid black; height: 20px;'>" . $row["phone"] . "</td>";
        echo "<td style='border: 1px solid black; height: 20px;'>" . $row["location"] . "</td>";
        echo "<td style='border: 1px solid black; height: 20px;'>" . $row["product"] . "</td>";
        echo "<td style='border: 1px solid black; height: 20px; color: green; font-weight: bold;'>" . $row["message"] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "No records found.";
}

$conn->close();
?>
