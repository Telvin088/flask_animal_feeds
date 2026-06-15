<?php
$mysqli = new mysqli("localhost", "root", "", "agrikenya_clients");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the AJAX request to update the database
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];

    // You should add appropriate error handling here

    $updateQuery = "UPDATE missing_requests SET status = ? WHERE request_id = ?";
    $stmt = $mysqli->prepare($updateQuery);
    $stmt->bind_param("si", $status, $request_id);

    if ($stmt->execute()) {
        echo "Updated status to $status successfully";
    } else {
        echo "Failed to update status";
    }

    // End the script to prevent further HTML rendering
    exit();
}

$query = "SELECT request_id, name, phone, email, location, products, status FROM missing_requests";
$result = $mysqli->query($query);

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $mysqli->close();
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo "<table style='font-size: 13px; margin-top: 40px; width: 950px; border: 1px solid #ddd; border-radius: 5px; margin-top: -23px;' border='1'>";
    echo "<tr><th style='border: 1px solid #ddd;'>Name</th><th style='border: 1px solid #ddd;'>Phone</th><th style='border: 1px solid #ddd;'>Email</th><th style='border: 1px solid #ddd;'>Location</th><th style='border: 1px solid #ddd;'>Product</th><th style='border: 1px solid #ddd;'>Status</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='height: 30px; border: 1px solid #ddd;'>" . $row['name'] . "</td>";
        echo "<td style='border: 1px solid #ddd;'>" . $row['phone'] . "</td>";
        echo "<td style='border: 1px solid #ddd;'>" . $row['email'] . "</td>";
        echo "<td style='border: 1px solid #ddd;'>" . $row['location'] . "</td>";
        echo "<td style='border: 1px solid #ddd;'>" . $row['products'] . "</td>";
        echo "<td style='border: 1px solid #ddd;'>" . $row['status'] . "</td>";

        // Inside the while loop that displays the table
        echo "<td style='border: 1px solid #ddd;'><input type='button' value='Approve' class='approve-button' data-id='" . $row['request_id'] . "'></td>";
        echo "<td style='border: 1px solid #ddd;'><input type='button' value='Reject' class='reject-button' data-id='" . $row['request_id'] . "'></td>";

        echo "</tr>";
    }
    echo "</table>";

    $mysqli->close();
}
?>
