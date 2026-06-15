<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrikenya_admin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$imageFolder = "/administrator/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetFile = $imageFolder . basename($_FILES["image"]["name"]);

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
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
    } else {
        echo "No file was uploaded or an error occurred.";
    }
}

$sql = "SELECT * FROM new_events LIMIT 3";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div style='display: flex; width: 1400px; height: 500px; justify-content: space-between; margin-top: -100px;'>"; // Open a flex container

    while ($row = $result->fetch_assoc()) {
        echo "<div style='display: flex; background-color: #ffffff; box-shadow: 0px -1px 5px 0px rgba(0,0,0,0.75);
        -webkit-box-shadow: 0px -1px 5px 0px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px -1px 5px 0px rgba(0,0,0,0.75); flex-direction: column; height: 500px; width: 400px; margin: 10px;'>";
        echo "<div style='display: flex; justify-content: center; align-items: center;'>";
        echo "<img style='height: 350px; width: 400px; object-fit: cover;' src='" . $imageFolder . $row["image_path"] . "' width='100' height='100'>";
        echo "</div>";
        echo "<div style='min-width: 185px; margin-left: 10px; text-align: left; height: 150px; display: flex; flex-direction: column;'>";
        echo "<p style='margin-top: 5px; text-align: left; color: #22b2b2; font-style: italic; font-size: 16x;'>" . $row["date"] . "</p>";
        echo "<p style='font-size: 16px; font-weight: bold; text-decoration: underline; margin-top: -17px;'>" . $row["topic"] . "</p>";
        echo "<p style='font-size: 15px; margin-top: -15px;'>" . $row["text"] . "</p>";
        echo "</div>";
        echo "</div>";
    }

    echo "</div>";
} else {
    echo "No data found.";
}

$conn->close();
