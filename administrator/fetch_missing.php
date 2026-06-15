<?php
$mysqli = new mysqli("localhost", "root", "", "agrikenya_clients");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT name, phone, email, quantity, location, products FROM missing_requests LIMIT 5";

$result = $mysqli->query($query);

if (!$result) {
    die("Error: " . $mysqli->error);
}

echo "<table style='font-size: 13px;'>";
echo "<tr><th style='text-align: left;'>Name</th><th style='text-align: left;'>Phone</th><th style='text-align: left;'>Email</th><th style='text-align: left;'>Quantity</th><th style='text-align: left;'>Location</th><th style='text-align: left;'>Product</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr style='border: none;'>";
    echo "<td style='border: none; font-weight: bold; color: #888; text-align: left;'>" . $row['name'] . "</td>";
    echo "<td style='border: none; font-weight: bold; color: #888; text-align: left;'>" . $row['phone'] . "</td>";
    echo "<td style='border: none; font-weight: bold; color: #888; text-align: left;'>" . $row['email'] . "</td>";
    echo "<td style='border: none; font-weight: bold; color: #888; text-align: center;'>" . $row['quantity'] . "</td>";
    echo "<td style='border: none; font-weight: bold; color: #888; text-align: left;'>" . $row['location'] . "</td>";
    echo "<td style='border: none; font-weight: bold; color: #888; text-align: left;'>" . $row['products'] . "</td>";
    echo "</tr>";
}

echo "</table>";

$mysqli->close();
?>
