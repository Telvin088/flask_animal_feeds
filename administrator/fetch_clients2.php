<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "agrikenya_clients";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch user details
$sql = "SELECT username, profile_picture, email, phone_number, quantities FROM users";
$result = $conn->query($sql);

// Output the table structure
echo "<table border='1' cellspacing='0' cellpadding='5'>";
echo "<tr>";
echo "<th>Name</th>";
echo "<th>Quantities</th>";
echo "<th>Email</th>";
echo "<th>Phone Number</th>";
echo "</tr>";

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $name = $row["username"];
        $quantities = $row["quantities"];
        $email = $row["email"];
        $phone_number = $row["phone_number"];

        echo "<tr>";
        echo "<td>$name</td>";
        echo "<td>$quantities</td>";
        echo "<td>$email</td>";
        echo "<td style='color: red;'>$phone_number</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No records found.</td></tr>";
}

echo "</table>";

$conn->close();
?>
