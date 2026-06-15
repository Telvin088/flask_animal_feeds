<?php
$mysqli = new mysqli("localhost", "root", "", "agrikenya_clients");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$quantity = $_POST['quantity'];
$location = $_POST['location'];
$product = $_POST['product'];
$status = $_POST['status'];

$query = "INSERT INTO missing_requests (name, phone, email, quantity, location, products, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);

$stmt->bind_param("sssssss", $name, $phone, $email, $quantity, $location, $product, $status);

if ($stmt->execute()) {
    header("Location: success_page.php"); // Redirect to the appropriate success page
    exit; // Important to stop further execution
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
