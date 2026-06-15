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


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="mail.css">
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
            height: 128vh;
        }

        .main-messages {
            height: 500px;
            width: 90%;
            margin-left: 5%;
            /* border: 1px solid red; */
        }

        .main-left {
            height: 500px;
            width: 450px;
            /* border: 1px solid red; */
        }

        .main-right {
            height: 500px;
            width: 650px;
            /* border: 1px solid red; */
            background-color: #ffffff;
            border-radius: 10px;
            overflow-y: scroll;
            overflow-x: hidden;
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
        <div style="display: flex; width: 95%; margin-left: 2.5%;" class="main-messages">
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
            <div class="message-containerr">
                <div style="height: 150px; width: 650px; display: flex; justify-content: space-between;" class="cards">
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
                </div>
                <div style="margin-top: 10px; display: flex; border-radius: 5px 5px 0 0; align-items: center; height: 70px; width: 650px; background-color: #ffffff; border-bottom: 1px dotted #ddd;" class="message-header">
                    <h2 style="margin-left: 20px;">Messages</h2>
                </div>
                <div style="border-radius: 0 0 5px 5px; height: 450px;" class="main-right">
                    <?php include 'fetch_messages2.php'; ?>
                </div>
            </div>
            <div class="second-card2">
                <div style="margin-top: 0px; margin-left: 5px; border-radius: 5px; height: 295px; width: 280px;" class="second-card-top">
                    <div style="border-bottom: 1px dotted #ddd; height: 40px; display: flex; align-items: center;">
                        <h3 style="margin-top: 20px; margin-left: 20px;">Administrator Account</h3>
                    </div>
                    <?php include 'fetch_admin.php'; ?>
                </div>
                <div style="margin-left: 5px; margin-top: 10px; border: 1px solid #ffffff; border-radius: 5px;" class="second-card-bottom">
                    <h3 style="margin-left: 20px;">Top Ordered Product</h3>
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
            <div class="admin-container">
                <div  style="width: 220px; margin-bottom: 20px; height: 60px; margin-left: 55px; background-color: #ffffff; border-radius: 5px 5px 0 0; display: flex; align-items: center;" class="admin-header">
                    <h3 style="margin-left: 20px;">Recent Users</h3>
                </div>
                <div style="margin-top: -30px; margin-left: 55px; width: 220px; height: 350px; border-radius: none; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;" class="second-card3">
                    <!-- <h3 style="margin-left: 20px;">Admin Accounts</h3> -->
                    <div style="margin-top: -20px;">
                        <?php include 'fetch_clients.php'; ?>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>