<?php
$mysqli = new mysqli("localhost", "root", "", "agrikenya_clients");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$query = "INSERT INTO client_messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);

$stmt->bind_param("ssss", $name, $email, $subject, $message);
if ($stmt->execute()) {
    echo "Message saved successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
