<?php
require 'phpmailer/PHPMailer-PHPMailer-dd01c56/src/Exception.php';
require 'phpmailer/PHPMailer-PHPMailer-dd01c56/src/PHPMailer.php';
require 'phpmailer/PHPMailer-PHPMailer-dd01c56/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrikenya_clients";

$emailUsername = 'karimicharity086@gmail.com';
$emailPassword = 'muah dkwz nvxc hiwr';

try {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $emailUsername;
    $mail->Password = $emailPassword;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom($emailUsername, 'Feeds Kenya');

    // Extract data from the POST request
    $requestID = $_POST["request_id"];
    $message = $_POST["message"];

    // Retrieve record details from the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT name, email, phone, location, products FROM recent_requests WHERE request_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $requestID);

    if ($stmt->execute()) {
        $stmt->bind_result($name, $email, $phone, $location, $product);
        $stmt->fetch();

        $mail->addAddress($email);

        $mail->Subject = "Approval/Rejection";
        $body = "Name: $name\n";
        $body .= "Phone: $phone\n";
        $body .= "Location: $location\n";
        $body .= "Product: $product\n";
        $body .= "Message: $message\n";

        $mail->Body = $body;

        $stmt->close();
        $conn->close();

        $mail->send();
        echo "Email sent successfully.";
    } else {
        echo "Error retrieving data from the database: " . $stmt->error;
    }
} catch (Exception $e) {
    echo "Email could not be sent. Error: " . $mail->ErrorInfo;
}
