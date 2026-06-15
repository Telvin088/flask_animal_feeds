<?php
$conn = new mysqli("localhost", "root", "", "agrikenya_admin");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, units FROM new_products LIMIT 4";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table style='font-size: 13px; width: 80%; margin-left: 15px;'>";
    echo "<tr style='text-align: left;'><th style='text-align: left; height: 15px;'>Name</th><th style='text-align: center; height: 15px;'>Units</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td style='text-align: left; border: none;'>" . $row["name"] . "</td><td style='border: none;'>" . $row["units"] . "</td></tr>";
    }
    
    echo "</table>";
} else {
    echo "No data found.";
}

$conn->close();
?>
