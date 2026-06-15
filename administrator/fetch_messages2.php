<?php
$mysqli = new mysqli("localhost", "root", "", "agrikenya_clients");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT name, email, subject, message FROM client_messages";
$result = $mysqli->query($query);

if (!$result) {
    die("Error in query: " . $mysqli->error);
    // echo"no data found";
}

echo "<div class='parent'>";

while ($row = $result->fetch_assoc()) {
    echo '<div style="border-bottom: 1px solid #ddd; height: auto; padding: 10px; margin: 10px;">';

    echo '<div style="float: left; margin-right: 10px;"><script src="https://cdn.lordicon.com/lordicon-1.1.0.js"></script><lord-icon src="https://cdn.lordicon.com/wzrwaorf.json" trigger="loop" delay="2000" style="width:35px;height:35px;"></lord-icon></div>';

    echo '<div>';
    // echo '<div style="font-weight: bold; font-size: 13px;">' . $row['name'] . '</div>';
    echo '<div style="font-size: 13px; margin-top: -5px; font-weight: bold; text-decoration: underline;">' . $row['email'] . '</div>';
    echo '<div style="font-size: 13px; font-weight: bold; color: #33bfbf;">' . $row['subject'] . '</div>';
    echo '<div style="font-size: 13px; margin-left: 40px; color: #333; height: auto;">' . $row['message'] . '</div>';
    echo '</div>';

    echo '</div>';
}



echo "</div>";

$mysqli->close();
