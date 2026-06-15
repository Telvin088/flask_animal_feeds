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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <title>Dashboard</title>
    <style>
        .main-section {
            height: 100vh;
        }
    </style>
</head>

<body>
    <div class="navigation-section">
        <ul>
            <li>
                <a href="dashboard.php">
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
                <a href="new.php">
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
                <h1 style="font-size: 27px; margin: 10px 0 0 20px;"><?php echo $finalId; ?></h1>
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
        <div style="margin-left: 20px; margin-top: 20px;">
            <div style="display: flex;">
                <button style="display: flex; align-items: center; margin-bottom: 20px;" id="printButton">
                    <span style="font-size: 17px;" class="material-symbols-outlined">print</span>
                    <span>Print</span>
                </button>
                <div class="dropdown">
                    <button style="height: 23px; display: flex; align-items: center; margin-left: 730px;" class="dropbtn">
                        <span style="font-size: 17px; font-weight: bold;" class="material-symbols-outlined">filter_alt</span>
                        <span>Filter</span>
                    </button>
                    <div class="dropdown-content">
                        <a href="#" data-filter="Today">Today</a>
                        <a href="#" data-filter="Yesterday">Yesterday</a>
                        <a href="#" data-filter="Last Week">Last Week</a>
                    </div>
                </div>
            </div>
            <span style="margin-top: 20px;">
                <button style="height: 25px; background-color: #44c4c4; width: auto; cursor: pointer; border: 1px solid #888; border-radius: 10px; font-weight: bold; font-family: 'Nunito Sans', sans-serif;" id="available">Available</button>
                <button style="height: 25px; width: auto; cursor: pointer; border: 1px solid #888; background-color: inherit; border-radius: 10px; font-weight: bold; font-family: 'Nunito Sans', sans-serif; margin-left: 10px; margin-right: 310px;" id="unavailable">Not Available</button>
            </span>
            <div style="margin-top: 40px; margin-left: -297px;" class="available-section">
                <!-- <h2>AVAILABLE</h2> -->
                <?php include 'fetch_update.php'; ?>
            </div>
            <div style="margin-top: 40px; margin-left: -297px; display: none;" class="missing-section">
                <!-- <h2>NOT AVAILABLE</h2> -->
                <?php include 'missing_status.php'; ?>
            </div>

            <script>
                $(document).ready(function() {
                    $(".dropdown-content a").click(function() {
                        var option = $(this).data('filter');
                        $.ajax({
                            type: "POST",
                            url: "fetch_update.php",
                            data: {
                                filter_option: option
                            },
                            success: function(response) {
                                // Clear existing content in the sections
                                $(".available-section").empty();
                                $(".missing-section").empty();

                                // Iterate through each item in the response and append to the respective section
                                $.each(response, function(index, item) {
                                    var row = $("<tr>");
                                    row.append($("<td>").text(item.name));
                                    row.append($("<td>").text(item.phone));
                                    row.append($("<td>").text(item.email));
                                    row.append($("<td>").text(item.location));
                                    row.append($("<td>").text(item.products));
                                    row.append($("<td>").text(item.status));

                                    if (item.status === "Available") {
                                        $(".available-section").append(row);
                                    } else {
                                        $(".missing-section").append(row);
                                    }
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    });
                });
            </script>

            <script>
                // Function to handle the print button click
                document.getElementById('printButton').addEventListener('click', function() {
                    var availableSectionEl = document.querySelector(".available-section");
                    var missingSectionEl = document.querySelector(".missing-section");

                    // Check the visibility state of the sections
                    var isAvailableVisible = window.getComputedStyle(availableSectionEl).display !== 'none';
                    var isMissingVisible = window.getComputedStyle(missingSectionEl).display !== 'none';

                    // Determine which section to print based on the visibility state
                    var sectionToPrint = isAvailableVisible ? availableSectionEl : missingSectionEl;

                    // Create a new window for the print view
                    var printWindow = window.open('', '_blank');
                    // Write the content of the selected section to the new window
                    printWindow.document.write('<h1>' + (isAvailableVisible ? 'AVAILABLE' : 'NOT AVAILABLE') + '</h1>');
                    printWindow.document.write(sectionToPrint.innerHTML);
                    // Trigger the print functionality for the new window
                    printWindow.print();
                    // Close the document stream
                    printWindow.document.close();
                });

                // Function to handle section visibility based on button clicks
                const availableBtn = document.getElementById("available");
                const unavailableBtn = document.getElementById("unavailable");
                const availableSectionEl = document.querySelector(".available-section");
                const missingSectionEl = document.querySelector(".missing-section");

                availableBtn.addEventListener("click", () => {
                    availableSectionEl.style.display = "block";
                    missingSectionEl.style.display = "none";
                    availableBtn.style.backgroundColor = "#44c4c4";
                    unavailableBtn.style.backgroundColor = "inherit";
                });

                unavailableBtn.addEventListener("click", () => {
                    availableSectionEl.style.display = "none";
                    missingSectionEl.style.display = "block";
                    unavailableBtn.style.backgroundColor = "#44c4c4";
                    availableBtn.style.backgroundColor = "inherit";
                });
            </script>


</body>

</html>