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
    <title>Dashboard</title>
    <style>
        .profile-picture-container img {
            height: 30px;
            width: 30px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo $username; ?></h1>
    
    <div class="profile-picture-container">
        <img src="<?php echo $profile_picture_path; ?>" alt="Profile">
    </div>
    
    
    <a href="logout.php">Logout</a>
</body>
</html>
