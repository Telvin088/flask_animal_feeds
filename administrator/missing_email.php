<?php
$mysqli = new mysqli("localhost", "root", "", "agrikenya_clients");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT request_id, name, phone, email, location, products FROM missing_requests";

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
    echo "<tr><th style='border: 1px solid #ddd;'>Name</th><th style='border: 1px solid #ddd;'>Phone</th><th style='border: 1px solid #ddd;'>Email</th><th style='border: 1px solid #ddd;'>Location</th><th style='border: 1px solid #ddd;'>Product</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='height: 30px; border: 1px solid #ddd;'>" . $row['name'] . "</td>";
        echo "<td style='border: 1px solid #ddd;'>" . $row['phone'] . "</td>";
        echo "<td style='border: 1px solid #ddd;'>" . $row['email'] . "</td>";
        echo "<td style='border: 1px solid #ddd;'>" . $row['location'] . "</td>";
        echo "<td style='border: 1px solid #ddd;'>" . $row['products'] . "</td>";
        // Inside the while loop that displays the table
        // echo "<td style='border: 1px solid #ddd;'><input type='button' value='Approve' class='approve-button' data-id='" . $row['request_id'] . "'></td>";
        echo "<td style='border: 1px solid #ddd;'><input type='button' value='Reject' class='reject-button' data-id='" . $row['request_id'] . "'></td>";
        echo "<input type='hidden' class='message-field' value='approved'>";

        echo "</tr>";

        echo "</tr>";
    }

    echo "</table>";

    $mysqli->close();
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Handle the Approve button click
    $('.approve-button').click(function() {
        var request_id = $(this).data('id');
        updateStatus(request_id, 'Approved');
    });

    // Handle the Reject button click
    $('.reject-button').click(function() {
        var request_id = $(this).data('id');
        updateStatus(request_id, 'Rejected');
    });

    // Function to send an AJAX request to update the status
    function updateStatus(request_id, status) {
        $.ajax({
            type: 'POST',
            url: 'save_missing.php',
            data: { request_id: request_id, status: status },
            success: function(response) {
                // Handle the response from the server, e.g., show a success message
                console.log(response);
            },
            error: function() {
                // Handle errors
                console.log('Error updating status');
            }
        });
    }
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Add your jQuery library -->
<script>
    $(document).on('click', '.approve-button', function() {
        var requestID = $(this).data('id');
        var message = 'Approved';

        sendApprovalEmail(requestID, message);
    });

    $(document).on('click', '.reject-button', function() {
        var requestID = $(this).data('id');
        var message = 'Rejected';

        sendApprovalEmail(requestID, message);
    });

    function sendApprovalEmail(requestID, message) {
        $.ajax({
            url: 'send_email.php',
            method: 'POST',
            data: { request_id: requestID, message: message },
            success: function(response) {
                // Handle the response
                console.log(response);

                // Check if the email was sent successfully
                if (response === "Email sent successfully.") {
                    // Redirect to the success page
                    window.location.href = 'success_page.php';
                } else {
                    // Handle any other responses, e.g., display an error message
                    console.error("Email not sent: " + response);
                }
            },
            error: function(error) {
                // Handle any errors that occur during the AJAX request
                console.error(error);
            }
        });
    }
</script>
