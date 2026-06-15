<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrikenya_admin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM new_events LIMIT 3";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        echo "<div style='display: flex; height: 100px; width: 90%; margin-left: 5%; margin-top: 25px;'>";
        echo "<div style='display: flex; justify-content: center; align-items: center;'>";
        echo "<img style='height: fill-content; object-fit: cover; width: 100px;' src='" . $row["image_path"] . "' width='100' height='100'>";
        echo "</div>";
        echo "<div style='min-width: 185px; text-align: left; display: flex; flex-direction: column;'>";
        echo "<p style='margin-top: -1px; text-align: left; color: #22b2b2; font-size: 13px; font-weight: bold;'>" . $row["date"] . "</p>";
        echo "<p style='font-size: 13px; font-weight: bold; text-decoration: underline; margin-top: -17px;'>" . $row["topic"] . "</p>";
        echo "<p style='font-size: 10px; margin-top: -15px; font-weight: bold; color: #888;'>" . $row["text"] . "</p>";
        echo "</div>";
        echo "</div>";
    }

    echo "</table>";
} else {
    echo "No data found.";
}

$conn->close();
?>
