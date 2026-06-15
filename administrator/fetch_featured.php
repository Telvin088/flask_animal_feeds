<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrikenya_admin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM new_products LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div style='width: 90%; margin: 0 auto;'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div style='height: 10px; display: flex; border: 1px solid #ffffff; padding: 10px; margin: 10px; align-items: center;'>";
        echo "<div style='height: 25px; border-radius: 50%;'>";
        echo "<img style='height: 20px; margin-left: -10px; margin-top: 3px; border-radius: 50%; object-fit: cover; width: 20px; object-fit: cover;' src='/administrator/products/" . basename($row["image"]) . "' />";
        echo "</div>";
        echo "<div style='font-size: 12px; font-weight: bold; width: 145px; margin-left: 8px;'>" . $row["name"] . "</div>";
        echo "<div style='font-size: 12px; font-weight: bold;'>" . $row["units"] . "</div>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "No data found.";
}



$conn->close();
?>
