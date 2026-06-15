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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard</title>
    <style>
        .main-section {
            height: 270vh;
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
            <!-- <h3>Shopping Place Dashboard</h3> -->
            <!-- <div style="width: 80%; max-width: 600px; margin: 0 auto; border-radius: 10px; margin-left: 25px;" class="chart-container">
                <canvas style="padding: 10px; background-color: #ffffff; padding: 10px; border-radius: 10px;" id="line-chart"></canvas>
            </div> -->
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
            <div class="second-cards">
                <div style="margin-top: 10px;" class="second-card1">
                    <div style="display: flex; align-items: center;" class="second-card1-top">
                        <h3>Recent Requests</h3>
                        <span style="margin-left: 40px;">
                            <button style="height: 25px; background-color: #44c4c4; width: auto; cursor: pointer; border: 1px solid #888; border-radius: 10px; font-weight: bold; font-family: 'Nunito Sans', sans-serif;" id="available">Available</button>
                            <button style="height: 25px; width: auto; cursor: pointer; border: 1px solid #888; background-color: inherit; border-radius: 10px; font-weight: bold; font-family: 'Nunito Sans', sans-serif; margin-left: 10px; margin-right: 310px;" id="unavailable">Not Available</button>
                        </span>
                    </div>
                    <div style="margin-top: -30px; display: block;" class="available-section">
                        <?php include 'fetch_requests.php'; ?>
                    </div>
                    <div style="margin-top: -30px; display: none;" class="missing-section">
                        <?php include 'fetch_missing.php'; ?>
                    </div>
                </div>
                <div class="second-card2">
                    <div style="margin-top: 10px; margin-left: 0; border-radius: 5px;" class="second-card-top">
                        <h3 style="margin-top: 20px;">Recent Accounts</h3>
                        <div class="profile-images">
                            <?php include 'fetch_adminProfile.php'; ?>
                            <file>+5</file>
                        </div>
                        <a style="color: #27aeaf;" href="mail.php">View More...</a>
                    </div>
                    <div style="margin-left: 0; border: 1px solid #ffffff; border-radius: 5px;" class="second-card-bottom">
                        <h3>Top Requested Product</h3>
                        <div style="display: flex; background-color: #e6f7f7; height: 130px; width: 90%; margin-left: 5%; margin-top: -10px; border-radius: 10px;" class="product-mini-card">
                            <?php include 'fetchDashtop.php'; ?>
                            <span style="margin-top: 10px; margin-left: -20px;">
                                <p style='display: none;'><?php echo $eventId; ?></p>
                                <!-- <p style='margin-left: -80px; margin-top: 30px;'>Lorem ipsum dolor sit amet<br>4.5<span style="font-size: 17px; margin-top: 2px; color: salmon;" class="material-symbols-rounded">
                                        star_half
                                    </span></p> -->
                            </span>
                        </div>
                    </div>
                </div>
                <div style="margin-top: -169px; margin-left: 15px; border-radius: 5px;" class="second-card3">
                    <div style="border: 1px solid #ffffff; border-radius: 5px;">
                        <h3>Added Product</h3>
                    </div>
                    <div style="margin-top: -20px; background-color: #ffffff; height: 410px; border-radius: 5px;">
                        <?php include 'fetch_featured.php'; ?>
                    </div>
                </div>
            </div>

            <div class="third-cards">
                <div style="margin-top: -90px; height: 440px; border-radius: 5px;" class="third-card-map">
                    <h3>Top Countries</h3>
                    <div class="east-africa">
                        <div class="east-africa-top">
                            <div class="kenya">
                                <img src="https://content.r9cdn.net/rimg/dimg/c6/b2/7e865843-city-26243-164a4a25d83.jpg?crop=true&width=1020&height=498" alt="">
                                <span>
                                    <h5><span id="dot" class="material-symbols-outlined">
                                            location_on
                                        </span>Kenya</h5>
                                    <p>60%</p>
                                </span>
                            </div>
                            <div class="uganda">
                                <img src="https://ugandasafaristours.com/wp-content/uploads/2017/07/Kampala-city.jpg" alt="">
                                <span>
                                    <h5><span id="dot" class="material-symbols-outlined">
                                            location_on
                                        </span>Uganda</h5>
                                    <p>57%</p>
                                </span>
                            </div>
                        </div>
                        <div class="east-africa-bottom">
                            <div class="tanzania">
                                <img src="https://www.karibuafricasafaris.com/wp-content/uploads/2022/02/tanzania-facts-4.jpg" alt="">
                                <span>
                                    <h5><span id="dot" class="material-symbols-outlined">
                                            location_on
                                        </span>Tanzania</h5>
                                    <p>44%</p>
                                </span>
                            </div>
                            <div class="somalia">
                                <img src="https://cdn.britannica.com/85/123585-004-7C941845/Mogadishu-Som.jpg" alt="">
                                <span>
                                    <h5><span id="dot" class="material-symbols-outlined">
                                            location_on
                                        </span>Somalia</h5>
                                    <p>41%</p>
                                </span>
                            </div>
                        </div>
                        <div id="east-africa-map" class="east-africa-map">
                            <div id="slider-images">
                                <img style="height: 200px; width: 330px;" class="slider-image" src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/963c1628-fd8a-4ce1-b662-998d4d9cbf9f/d4mn50d-02f61985-b411-41ac-ba3b-2942f784c0e3.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcLzk2M2MxNjI4LWZkOGEtNGNlMS1iNjYyLTk5OGQ0ZDljYmY5ZlwvZDRtbjUwZC0wMmY2MTk4NS1iNDExLTQxYWMtYmEzYi0yOTQyZjc4NGMwZTMucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.IZyjA3p3JuEjdniXtZSlvQwCiiEKYWIyrJmnExwNjto" alt="Country 1">
                                <!-- Add more images as needed -->
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top: -60px; border-radius: 5px;" class="third-card-activities">
                    <h3>Upcoming Events</h3>
                    <p>2023/2024 upcoming events</p>
                    <?php include 'fetch_events.php'; ?>
                </div>
                <div style="margin-top: -110px; border-radius: 5px; width: 320px;" class="third-card-expenses">
                    <h3 style="margin-left: 40px;">Top Requested Products</h3>
                    <?php include 'fetch_topordered.php'; ?>
                </div>
            </div>

            <div class="forth-cards">
                <div style="margin-top: -150px; border-radius: 5px; width: 500px;" class="invoice-card">
                    <div style="border-bottom: 1px dotted #ddd;" class="invoice-card-top">
                        <h3 style="font-size: 23px;">Client Messages</h3>
                        <!-- <form action="">
                            <label for="">Search:</label>
                            <input type="text">
                        </form> -->
                    </div>
                    <table style="margin-left: 50px; margin-top: -20px;" class="invoice-table">
                        <?php include 'fetch_messages.php'; ?>
                    </table>
                </div>
                <div style="height: 500px; margin-left: -200px; width: 600px;" class="extra-card">
                    <div style="height: 50px; display: flex; justify-content: space-between; align-items: center; width: 100%; border-bottom: 1px dotted #dddddd;" class="extra-card-header">
                        <h3 style="font-size: 23px;">User Accounts</h3>
                        <!-- Print button -->
    <button style="height: 30px; width: 70px; margin-right: 20px; cursor: pointer;" id="printButton" onclick="printContent()">Print</button>
                    </div>
                    <div id="fetch_clients2_content">
                        <?php include 'fetch_clients2.php'; ?>
                    </div>

                </div>

                <script>
    function printContent() {
        // Get the content to print
        var content = document.getElementById("fetch_clients2_content").innerHTML;
        // Create a new window to print the content
        var printWindow = window.open('', '_blank');
        // Write the content into the new window
        printWindow.document.write('<html><head><title>User Accounts</title></head><body>');
        printWindow.document.write('<h1>User Accounts</h1>'); // Add the heading
        printWindow.document.write(content);
        printWindow.document.write('</body></html>');
        // Close the new window after printing
        printWindow.document.close();
        printWindow.print();
    }
</script>


                <script src="dashboard.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    var data = {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                                label: 'Clients',
                                data: [10, 20, 15, 25, 30, 18],
                                borderColor: 'rgb(75, 192, 192)',
                                tension: 0.4,
                            },
                            {
                                label: 'Expenses',
                                data: [5, 10, 5, 15, 25, 10],
                                borderColor: 'rgb(255, 99, 132)',
                                tension: 0.4,
                            },
                            {
                                label: 'Products',
                                data: [12, 18, 22, 28, 24, 32],
                                borderColor: 'rgb(54, 162, 235)',
                                tension: 0.4,
                            }
                        ]
                    };

                    var config = {
                        type: 'line',
                        data: data,
                        options: {
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.dataset.label + ': ' + context.parsed.y;
                                        }
                                    }
                                }
                            }
                        }
                    };

                    var ctx = document.getElementById('line-chart').getContext('2d');
                    new Chart(ctx, config);
                </script>


                <script>
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