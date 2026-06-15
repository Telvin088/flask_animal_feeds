<?php
$mysqli = new mysqli("localhost", "root", "", "agrikenya_clients");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$filter_option = $_POST['filter_option'] ?? '';

// Construct SQL query based on the filter option
switch ($filter_option) {
    case 'Today':
        $query = "SELECT request_id, name, phone, email, location, products, status FROM recent_requests WHERE DATE(request_date) = CURDATE()";
        break;
    case 'Yesterday':
        $query = "SELECT request_id, name, phone, email, location, products, status FROM recent_requests WHERE DATE(request_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
        break;
    case 'Last Week':
        $query = "SELECT request_id, name, phone, email, location, products, status FROM recent_requests WHERE request_date >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
        break;
    default:
        $query = "SELECT request_id, name, phone, email, location, products, status FROM recent_requests";
}

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
    echo "<table style='font-size: 13px; margin-top: 40px; width: 950px; border: 1px solid #ddd; border-radius: 5px; margin-top: -23px; margin-top: 20px;' border='1'>";
    echo "<tr><th style='border: 1px solid #ddd;'>Name</th><th style='border: 1px solid #ddd;'>Phone</th><th style='border: 1px solid #ddd;'>Email</th><th style='border: 1px solid #ddd;'>Location</th><th style='border: 1px solid #ddd;'>Product</th><th style='border: 1px solid #ddd;'>Status</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='height: 30px; border: 1px solid #ddd;'>" . $row['name'] . "</td>";
        echo "<td style='border: 1px solid #ddd;'>" . $row['phone'] . "</td>";
        echo "<td style='border: 1px solid #ddd;'>" . $row['email'] . "</td>";
        echo "<td style='border: 1px solid #ddd;'>" . $row['location'] . "</td>";
        echo "<td style='border: 1px solid #ddd;'>" . $row['products'] . "</td>";
        echo "<td style='border: 1px solid #ddd; font-weight: bold;'>" . $row['status'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";

    $mysqli->close();
}
?>
