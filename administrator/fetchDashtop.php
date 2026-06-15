<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrikenya_admin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM top_ordered LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div style='display: flex; background-color: #e6f7f7; margin-top: 7px; border-radius: 5px; width: 90%; height: auto; margin-left: 5%;'>";
        echo "<div style='display: flex; align-items: center; justify-content: center;'>";
        echo "<p><img style='height: fill-content; width: 70px; objec-fit: cover; margin-left: -1px;' src='" . $row["image"] . "' width='100' height='100'></p>";
        echo "</div>";
        echo "<div style='min-width: 240px;  margin-left: -5px; margin-top: 8px;'>";
        echo "<p style='font-weight: bold; font-size: 15px; margin-top: 10px;'>" . $row["name"] . "</p>";
        
        // Limit the description to 5 words
        $description = $row["description"];
        $words = explode(" ", $description);
        $limitedDescription = implode(" ", array_slice($words, 0, 12));
        echo "<p style='font-size: 12px; width: 55%; margin-right: 10px; padding-right: 10px; margin-top: -15px; font-weight: bold; color: #888;'>" . $limitedDescription . "</p>";
        
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No data found.";
}

$conn->close();
?>
