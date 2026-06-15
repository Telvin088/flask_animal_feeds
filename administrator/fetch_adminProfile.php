<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrikenya_admin";

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch profile pictures from the users table with a limit of 5
    $stmt = $conn->prepare("SELECT profile_picture FROM users LIMIT 5");
    $stmt->execute();

    // Display fetched profile pictures
    while ($row = $stmt->fetch()) {
        // Assuming profile_picture contains file paths or URLs
        echo '<img style="border: 2px solid #33bfbf; object-fit: cover;" src="' . $row['profile_picture'] . '" alt="Profile Picture">';
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
