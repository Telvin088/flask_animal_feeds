<?php
// Connect to your MySQL database
$servername = "localhost"; // Your MySQL server address
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "agrikenya_admin"; // Your MySQL database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a product ID is provided in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    // Query to retrieve the units value from the 'new_products' table based on the provided product ID
    $sql = "SELECT units FROM new_products WHERE id = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row["units"];
    } else {
        echo "0"; // Assuming the product is not found, return 0.
    }
} else {
    echo "Product ID not provided in the URL.";
}

$conn->close();
?>
