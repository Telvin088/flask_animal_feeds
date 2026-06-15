<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "agrikenya_admin";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data
$sql = "SELECT profile_picture, username, email FROM users";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div style='width: 90%;'>";

    while ($row = $result->fetch_assoc()) {
        echo "<div style='width: 100%; height: 7px; display: flex; align-items: center; padding: 10px; margin: 10px; text-align: center;'>";
        echo "<img style='height: 25px; width: 25px; border-radius: 50%; object-fit: cover; margin-left: -15px;' src='" . $row["profile_picture"] . "' alt='Profile Picture'>";
        echo "<p style='font-size: 10px; width: 150px; text-align: left; margin: 5px; font-weight: bold; width: 150px;'>" . $row["username"] . "</p>";
        echo "<p style='font-size: 10px; margin-left: 25px; text-decoration: underline; font-weight: bold;'>" . $row["email"] . "</p>";
        echo "</div>";
    }

    echo "</div>";
} else {
    echo "No data found.";
}


// Close the database connection
$conn->close();
?>
