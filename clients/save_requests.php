<?php
$mysqli_admin = new mysqli("localhost", "root", "", "agrikenya_admin");
$mysqli_clients = new mysqli("localhost", "root", "", "agrikenya_clients");

if ($mysqli_admin->connect_error || $mysqli_clients->connect_error) {
    die("Connection failed: " . $mysqli_admin->connect_error . " / " . $mysqli_clients->connect_error);
}

// Retrieve user inputs from the form
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$requestedQuantity = intval($_POST['quantity']);
$location = $_POST['location'];
$productName = $_POST['product'];
$status = $_POST['status'];

// Fetch the current quantity of the product from the admin database
$query_admin = "SELECT units FROM new_products WHERE name = ?";
$stmt_admin = $mysqli_admin->prepare($query_admin);
if (!$stmt_admin) {
    die("Error preparing statement: " . $mysqli_admin->error);
}
$stmt_admin->bind_param("s", $productName);
$stmt_admin->execute();
$result_admin = $stmt_admin->get_result();

if ($result_admin) {
    if ($result_admin->num_rows > 0) {
        $row_admin = $result_admin->fetch_assoc();
        $currentQuantity = intval($row_admin['units']);

        // Check if requested quantity is available
        if ($requestedQuantity <= $currentQuantity) {
            // Subtract the requested quantity from the current quantity
            $newQuantity = $currentQuantity - $requestedQuantity;

            // Update the quantity in the admin database
            $updateQuery = "UPDATE new_products SET units = ? WHERE name = ?";
            $stmt_update = $mysqli_admin->prepare($updateQuery);
            if (!$stmt_update) {
                die("Error preparing statement: " . $mysqli_admin->error);
            }
            $stmt_update->bind_param("is", $newQuantity, $productName);
            $stmt_update->execute();
            if ($stmt_update->affected_rows > 0) {
                // Insert the request into the clients database
                $query_clients = "INSERT INTO recent_requests (name, phone, email, quantity, location, products, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt_clients = $mysqli_clients->prepare($query_clients);
                if (!$stmt_clients) {
                    die("Error preparing statement: " . $mysqli_clients->error);
                }
                $stmt_clients->bind_param("sssssss", $name, $phone, $email, $requestedQuantity, $location, $productName, $status);
                $stmt_clients->execute();
                if ($stmt_clients->affected_rows > 0) {
                    // Redirect to success page
                    header("Location: success_page.php");
                    exit;
                } else {
                    echo "Error inserting request into clients database.";
                }
            } else {
                echo "Error updating quantity in admin database.";
            }
        } else {
            // Handle case where requested quantity exceeds available quantity
            echo "Requested quantity exceeds available quantity.";
        }
    } else {
        // Handle case where product is not found in the admin database
        echo "Product not found.";
    }
} else {
    echo "Error executing query: " . $mysqli_admin->error;
}

// Close connections
$stmt_admin->close();
// Close $stmt_update only if it's set
if (isset($stmt_update)) {
    $stmt_update->close();
}
$stmt_clients->close();
$mysqli_admin->close();
$mysqli_clients->close();
?>
