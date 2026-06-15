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
$sql = "SELECT username, profile_picture, phone_number FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $name = $row["username"];
        $profilePicture = $row["profile_picture"];
        $phone_number = $row["phone_number"];
        
        // Construct the image path
        $imagePath = "profile_pictures/" . $name; // You can adjust the file extension as needed
        echo "<div style='display: flex; align-items: center; border: 1px solid #ffffff; margin-top: 5px; height: 30px; margin-left: 13px;'>";
        echo '<script src="https://cdn.lordicon.com/lordicon-1.1.0.js"></script>
        <lord-icon
            src="https://cdn.lordicon.com/xzalkbkz.json"
            trigger="loop"
            delay="2000"
            style="width:20px;height:20px;">
        </lord-icon>';
        echo "<p style='font-size: 12px; width: 90px; margin-left: 5px; font-weight: bold;'>$name</p>";
        echo "<p style='font-size: 11px; color: #08a88a; text-decoration: underline; font-weight: bold;'>$phone_number</p>";
        echo "</div>";
    }
} else {
    echo "No records found.";
}

$conn->close();
?>
