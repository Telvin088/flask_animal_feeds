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

$sql = "SELECT * FROM top_ordered LIMIT 4";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div style='display: flex; justify-content: space-around;'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div style='margin: 10px; text-align: center; '>";
        echo "<img style='height: 250px; width: 250px; object-fit: cover;' src='" . $imageFolder . $row["image"] . "' width='100' height='100'>";
        echo "<p style='font-weight: bold; font-size: 15px; margin-top: -5px;'>" . $row["name"] . "</p>";
        echo "<p style='width: 180px; margin-left: 43px; font-size: 13px; margin-top: -15px;'>" . substr($row["description"], 0, 200) . "</p>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "No data found.";
}

$conn->close();
?>
