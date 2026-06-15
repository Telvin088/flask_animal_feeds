<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrikenya_admin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imageFolder = "uploads/";
    $targetFile = $imageFolder . basename($_FILES["image"]["name"]);

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "No file was uploaded or an error occurred.";
    }

    $date = $_POST["date"];
    $topic = $_POST["topic"];
    $text = $_POST["text"];

    $sql = "INSERT INTO new_events (image_path, date, topic, text) VALUES ('$targetFile', '$date', '$topic', '$text')";

    if ($conn->query($sql) === TRUE) {
        echo "Data saved successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
