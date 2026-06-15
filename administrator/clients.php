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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <title>Dashboard</title>
</head>

<body>
    <div class="navigation-section">
        <ul>
            <li>
                <a href="">
                    <img src="https://admin.pixelstrap.com/cion/assets/images/logo/logo.png" alt="">
                </a>
            </li>
            <li>
                <a href="">
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
                <a href="new.php">
                    <span class="material-symbols-rounded">
                        library_add
                    </span>
                    <span>New</span>
                </a>
            </li>
            <li>
                <a href="events.php">
                    <span class="material-symbols-rounded">
                        event
                    </span>
                    <span>Events</span>
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
                <a href="">
                    <span class="material-symbols-rounded">
                        account_circle
                    </span>
                    <span>Account</span>
                </a>
            </li>
            <li>
                <a href="">
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
            <h3>Shopping Place Dashboard</h3>
            <div class="first-cards">
                <div class="first-card">
                    <div class="first-card-left">
                        <p>
                            <span style="background-color: #e3e4e5; color: black;" class="material-symbols-rounded">
                                shopping_cart
                            </span>
                            <span>Total Expenses</span>
                        </p>
                        <p>Ksh 650.340</p>
                        <p>
                            <span style="color: black;" class="material-symbols-outlined">
                                arrow_drop_up
                            </span>
                            <span style="color: black;">-90.28%</span>
                        </p>
                    </div>
                    <div class="first-card-right">
                        <img src="https://www.chartle.com/pics/charts/line.png" alt="">
                    </div>
                </div>
                <div class="first-card">
                    <div class="first-card-left">
                        <p>
                            <span style="background-color: #ffecea; color: #ff6150;" class="material-symbols-rounded">
                                group
                            </span>
                            <span>Total Visitors</span>
                        </p>
                        <p>2875</p>
                        <p>
                            <span style="color: red;" class="material-symbols-outlined">
                                arrow_drop_down
                            </span>
                            <span style="color: red;">-25.28%</span>
                        </p>
                    </div>
                    <div class="first-card-right">
                        <img style="height: 150px; width: 200px; border-radius: 10px" src="/images/imageonline-co-donutchart.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="clients-containerr">
            <?php include 'fetch_users.php';?>
        </div>
    </div>
</body>

</html>