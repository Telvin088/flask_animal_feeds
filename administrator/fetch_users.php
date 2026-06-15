<?php
$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "agrikenya_clients";

$conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT username, email, phone_number FROM users";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table style='border: none; font-size: 14px;' border='1'>";
    echo "<tr style='background-color: #23b3b3;'><th style='color: black;'>Name</th><th style='color: black;'>Email</th><th style='color: black;'>Phone</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["phone_number"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No records found.";
}

mysqli_close($conn);
?>
