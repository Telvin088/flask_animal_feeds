<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

include("db_connection.php");

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$profile_picture_path = "";

$select_query = "SELECT profile_picture FROM users WHERE id = ?";
$select_stmt = $pdo->prepare($select_query);
$select_stmt->execute([$user_id]);
$user_data = $select_stmt->fetch();

if ($user_data) {
    $profile_picture_path = $user_data["profile_picture"];
}

if (empty($profile_picture_path)) {
    $profile_picture_path = "default_profile_picture.jpg";
}
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrikenya_clients";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the very last 'id' from the 'users' table
$sql = "SELECT id FROM users ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastId = $row["id"];
    // echo "The last ID is: " . $lastId;
}
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrikenya_clients";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the very last 'id' from the 'users' table
$sql = "SELECT request_id FROM recent_requests ORDER BY request_id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $finalId = $row["request_id"];
    // echo "The last ID is: " . $lastId;
}
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrikenya_admin";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the very last 'id' from the 'users' table
$sql = "SELECT event_id FROM new_events ORDER BY event_id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $eventId = $row["event_id"];
    // echo "The last ID is: " . $lastId;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="new.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <title>NEW</title>
    <style>
        .main-section {
            height: 125vh;
        }
    </style>
</head>

<body>
    <div class="navigation-section">
        <ul>
            <li>
                <a href="dashbaord.php">
                <img style="object-fit: cover; height: 50px; width: 100px;" src="https://saniroundtable.co.za/media/com_jbusinessdirectory/pictures/companies/39/AFGRI_Animal_Feeds_Logo_head_1649654527.png" alt="">
                </a>
            </li>
            <li>
                <a href="dashboard.php">
                    <span class="material-symbols-rounded">
                        home
                    </span>
                    <span>General</span>
                </a>
            </li>
            <li>
                <a href="requests.php">
                    <span class="material-symbols-rounded">
                        assignment
                    </span>
                    <span>Requests</span>
                </a>
            </li>
            <li>
                <a href="mail.php">
                    <span class="material-symbols-rounded">
                        mail
                    </span>
                    <span>Mail</span>
                </a>
            </li>
            <li>
                <a href="new.php">
                    <span class="material-symbols-rounded">
                        library_add
                    </span>
                    <span>New</span>
                </a>
            </li>
            <li>
                <a href="report.php">
                    <span class="material-symbols-rounded">
                        report
                    </span>
                    <span>Report</span>
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <span class="material-symbols-rounded">
                        logout
                    </span>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="main-section">
        <div class="top-section">
            <div class="search-section">
                <div class="menu-section">
                    <a href="">
                        <span class="material-symbols-rounded">
                            browse
                        </span>
                    </a>
                </div>
                <div class="search-container">
                    <input type="text" id="search-input" placeholder="Search...">
                    <i class="fa fa-search" id="search-icon"></i>
                </div>
            </div>
            <div class="profile-section">
                <a href="">
                    <span class="material-symbols-rounded">
                        notifications
                    </span>
                </a>
                <div class="vertical-rule"></div>
                <a href="">
                    <span class="material-symbols-rounded">
                        star
                    </span>
                </a>
                <div class="vertical-rule"></div>
                <a href="">
                    <span class="material-symbols-rounded">
                        mail
                    </span>
                </a>
                <div class="vertical-rule"></div>
                <a href="">
                    <span class="material-symbols-rounded">
                        shopping_cart
                    </span>
                </a>
                <div class="vertical-rule"></div>
                <a href="">
                    <span class="material-symbols-rounded">
                        lightbulb
                    </span>
                </a>
                <div class="vertical-rule"></div>
                <img style="width: 30px; height: 20px;" src="https://cdn.britannica.com/15/15-004-B5D6BF80/Flag-Kenya.jpg" alt=""><span style="font-size: 15px; margin-left: -10px;">KEN</span>
                <div class="vertical-rule"></div>
                <a href="">
                    <img class="main-profile-image" src="<?php echo $profile_picture_path; ?>" alt="">
                </a>
                <div class="main-profile-card">
                    <a href="">
                        <h5><?php echo $username; ?></h5>
                    </a>
                    <a href="">
                        <p>Admin</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="bottom-section">
            <div style="height: 150px; width: 950px; display: flex; justify-content: space-between; margin: 20px 0 0 20px;" class="cards">
                <div style="height: 150px; width: 310px; background-color: #ffffff; border-radius: 5px;" class="card">
                    <h3 style="font-size: 17px; margin-left: 20px;">Total Requests</h3>
                    <p style="font-size: 12px; color: #888; margin: -17px 0 0 20px;">Lorem ipsum dolor sit amet consectetur.</p>
                    <h1 style="font-size: 27px; margin: 10px 0 0 20px;"><?php echo $finalId; ?></h1>
                    <span style="display: flex; align-items: center;">
                        <span style="color: #33bfbf; font-size: 11px; margin: 0 0 0 20px;">32% </span><span style="color: #888; font-size: 11px; margin-left: 3px;">Increase</span><span style="margin-left: 170px; background-color: #ddd; border-radius: 50%; padding: 3px;" class="material-symbols-outlined">
                            universal_currency_alt
                        </span>
                    </span>
                </div>
                <div style="height: 150px; width: 310px; background-color: #ffffff; border-radius: 5px;" class="card">
                    <h3 style="font-size: 17px; margin-left: 20px;">Total Clients</h3>
                    <p style="font-size: 12px; color: #888; margin: -17px 0 0 20px;">Lorem ipsum dolor sit amet consectetur.</p>
                    <h1 style="font-size: 27px; margin: 10px 0 0 20px;"><?php echo $lastId; ?></h1>
                    <span style="display: flex; align-items: center;">
                        <span style="color: #33bfbf; font-size: 11px; margin: 0 0 0 20px;">32% </span><span style="color: #888; font-size: 11px; margin-left: 3px;">Increase</span><span style="margin-left: 170px; background-color: #ddd; border-radius: 50%; padding: 3px;" class="material-symbols-outlined">
                            groups
                        </span>
                    </span>
                </div>
                <div style="height: 150px; width: 310px; background-color: #ffffff; border-radius: 5px;" class="card">
                    <h3 style="font-size: 17px; margin-left: 20px;">Hosted Events</h3>
                    <p style="font-size: 12px; color: #888; margin: -17px 0 0 20px;">Lorem ipsum dolor sit amet consectetur.</p>
                    <h1 style="font-size: 27px; margin: 10px 0 0 20px;"><?php echo $eventId; ?></h1>
                    <span style="display: flex; align-items: center;">
                        <span style="color: #33bfbf; font-size: 11px; margin: 0 0 0 20px;">32% </span><span style="color: #888; font-size: 11px; margin-left: 3px;">Increase</span><span style="margin-left: 170px; background-color: #ddd; border-radius: 50%; padding: 3px;" class="material-symbols-outlined">
                            emoji_events
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <div style="display: flex;" class="add-container">
            <div style="width: 350px; margin-top: 30px; margin-left: 20px; background-color: #ffffff; height: 410px; border-radius: 5px; border: 1px solid #ffffff;" class="new-product">
                <h4 style="margin-left: 10px;">Add New Products</h4>
                <form action="save_product.php" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <th style="border: none;"><label for="name">Name:</label></th>
                            <td style="border: none;"><input type="text" id="name" name="name" required></td>
                        </tr>
                        <tr>
                            <th style="border: none;"><label for="units">Units:</label></th>
                            <td style="border: none;"><input type="text" id="units" name="units" required></td>
                        </tr>
                        <tr>
                            <th style="border: none;"><label for="description">Desc:</label></th>
                            <td style="border: none;"><input type="text" id="units" name="description" required></td>
                        </tr>
                        <tr>
                            <th style="border: none;"><label for="image">Image:</label></th>
                            <td style="border: none;"><input style="margin-left: 75px;" type="file" id="image" name="image" accept="image/*" required></td>
                        </tr>
                    </table>

                    <input style="margin-left: 10px; margin-bottom: 20px; width: 100px;" type="submit" value="Post">
                </form>

                <form style="margin-top: 6px;" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <!-- <label style="margin-left: 70px;" for="name">Enter record name</label> -->
                    <input style="margin-left: 10px;" type="text" name="name" id="name" required>
                    <input type="submit" name="deleteRecord" value="Delete Record">
                </form>
            </div>
            <?php
            // Handle record deletion in the same PHP file
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteRecord"])) {
                // Establish a database connection (replace these values with your database credentials)
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "agrikenya_admin";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check the connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Get the name to delete from the form
                $recordNameToDelete = $_POST["name"];

                // Define and execute the SQL query to delete the record with the specified name
                $deleteSql = "DELETE FROM new_products WHERE name = ?";
                $stmt = $conn->prepare($deleteSql);
                $stmt->bind_param("s", $recordNameToDelete);

                if ($stmt->execute()) {
                    // Show the "Record Deleted" message
                    echo '<script>document.getElementById("message").style.display = "block";</script>';

                    // Hide the message after 4 seconds
                    echo '<script>setTimeout(function(){document.getElementById("message").style.display = "none";}, 4000);</script>';
                } else {
                    echo "Error deleting record: " . $stmt->error;
                }

                $stmt->close();
                $conn->close();
            }
            ?>
            <div style="width: 350px; background-color: #ffffff; margin-left: 10px; height: 410px; border-radius: 5px; border: 1px solid #ffffff;" class="new-event-section">
                <h4 style="margin-left: 15px;">Add New Events</h4>
                <form action="save_events.php" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <th><label for="image">Image:</label></th>
                            <td><input type="file" id="image" name="image" class="image-input"></td>
                        </tr>
                        <tr>
                            <th><label for="date">Date:</label></th>
                            <td><input style="margin-left: -130px;" type="date" id="date" name="date" required></td>
                        </tr>
                        <tr>
                            <th><label for="topic">Topic:</label></th>
                            <td><input style="margin-left: -70px;" type="text" id="topic" name="topic" required></td>
                        </tr>
                        <tr>
                            <th><label for="text">Text:</label></th>
                            <td><textarea style="margin-left: -70px;" id="text" name="text" rows="4" required></textarea></td>
                        </tr>
                    </table>

                    <input style="margin-left: 15px; margin-bottom: 20px;" type="submit" value="Submit">
                </form>
                <!-- <h4 style="margin-top: 20px;">Remove Event</h4> -->
                <?php
                // Establish a database connection (replace these values with your database credentials)
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "agrikenya_admin";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check the connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $imageFolder = "/administrator/";

                // Check if the form for deleting by topic is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteTopic"])) {
                    // Get the topic to delete from the form
                    $topicToDelete = $_POST["topicToDelete"];

                    // Define and execute the SQL query to delete the row with the specified topic
                    $deleteSql = "DELETE FROM new_events WHERE topic = ?";
                    $stmt = $conn->prepare($deleteSql);
                    $stmt->bind_param("s", $topicToDelete);

                    // if ($stmt->execute()) {
                    //     echo "Row with topic '$topicToDelete' has been deleted.";
                    // } else {
                    //     echo "Error deleting row: " . $stmt->error;
                    // }

                    $stmt->close();
                }

                // ... (your existing code for displaying the data)

                // Close the database connection
                $conn->close();
                ?>

                <!-- Add a form for deleting by topic -->
                <form action="new.php" method="post">
                    <!-- <label style="margin-left:70px;" for="topicToDelete">Enter the topic to delete:</label> -->
                    <input style="margin-left: 15px;" type="text" name="topicToDelete" id="topicToDelete" required>
                    <input type="submit" name="deleteTopic" value="Delete">
                </form>
            </div>


            <div style="width: 350px; background-color: #ffffff; margin-left: -150px; margin-top: 30px; height: 410px; border-radius: 5px; border: 1px solid #ffffff;" class="top-ordered-product">
                <h4 style="margin-left: 15px;">Top Ordered Product</h4>
                <form action="save_topordered.php" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <th><label for="image">Image:</label></th>
                            <td><input type="file" id="image" name="image" class="image-input"></td>
                        </tr>
                        <tr>
                            <th><label for="name">Name:</label></th>
                            <td><input style="margin-left: -70px;" type="name" id="name" name="name" required></td>
                        </tr>
                        <tr>
                            <th><label for="description">Topic:</label></th>
                            <td><input style="margin-left: -70px;" type="text" id="description" name="description" required></td>
                        </tr>
                    </table>

                    <input style="margin-left: 15px; margin-bottom: 20px;" type="submit" value="Submit">
                </form>
                <form style="margin-left: 70px; margin-top: 40px;" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <!-- <label for="itemName">Enter item name:</label> -->
                    <input style="margin-left: -55px;" type="text" name="itemName" id="itemName" required>
                    <input type="submit" name="deleteItem" value="Delete Item">
                </form>
                <?php
                // Establish a database connection (replace these values with your database credentials)
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "agrikenya_admin";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check the connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Check if the form for deleting by item name is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteItem"])) {
                    // Get the item name to delete from the form
                    $itemNameToDelete = $_POST["itemName"];

                    // Define and execute the SQL query to delete the item with the specified name
                    $deleteSql = "DELETE FROM top_ordered WHERE name = ?";
                    $stmt = $conn->prepare($deleteSql);
                    $stmt->bind_param("s", $itemNameToDelete);

                    if ($stmt->execute()) {
                        // Show the "Item Deleted" message
                        echo '<script>document.getElementById("message").style.display = "block";</script>';

                        // Hide the message after 4 seconds
                        echo '<script>setTimeout(function(){document.getElementById("message").style.display = "none";}, 4000);</script>';
                    } else {
                        echo "Error deleting item: " . $stmt->error;
                    }

                    $stmt->close();
                }

                // Close the database connection
                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <script>
    // Get today's date
    var today = new Date().toISOString().split('T')[0];
    
    // Set the minimum date attribute to today
    document.getElementById("date").setAttribute("min", today);
</script>
</body>

</html>