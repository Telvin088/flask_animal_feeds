<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "agrikenya_admin"; 

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM new_events";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
    
    
        echo '<div class="details">';
        echo '<img style="height: 85px; width: 85px; border: 1px solid red; object-fit: cover; margin-right: 10px;" src="https://i0.wp.com/blog.inevent.com/wp-content/uploads/2021/05/Pre-event_checklist.png?resize=725%2C649&ssl=1" alt="Event Image" width="300">';
        echo "<p style='font-size: 14px; color: #33bfbf; font-style: italic; margin-bottom: -5px;'>" . $row["date"] . "</p>";
        echo "<p style='font-size: 14px; font-weight: bold; margin-bottom: -5px;'>" . $row["topic"] . "</p>";
        echo "<p style='font-size: 14px; height: auto; width: 280px; border: 1px solid red;'>" . $row["text"] . "</p>";
        echo '</div>'; 
    
        echo "<hr>";
    }
    
} else {
    echo "No events found in the database.";
}

$result->close();
$conn->close();
?>