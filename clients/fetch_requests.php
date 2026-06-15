<?php
$mysqli = new mysqli("localhost", "root", "", "agrikenya_clients");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT name, phone, email, location, products FROM recent_requests";

$result = $mysqli->query($query);

if (!$result) {
    die("Error: " . $mysqli->error);
}

echo "<table border='1'>";
echo "<tr><th>Name</th><th>Phone</th><th>Email</th><th>Location</th><th>Product</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['phone'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['location'] . "</td>";
    echo "<td>" . $row['products'] . "</td>";
    echo "</tr>";
}

echo "</table>";

$mysqli->close();
?>
