<?php
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password != $confirm_password) {
        die("Passwords do not match");
    }

    $check_query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $check_stmt = $pdo->prepare($check_query);
    $check_stmt->execute([$username, $email]);

    if ($check_stmt->rowCount() > 0) {
        die("Username or email already exists");
    }
    else {
        echo "Account Created.";
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $profile_picture_path = "";
    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
        $upload_dir = "profile_pictures/";
        $profile_picture_name = $_FILES["profile_picture"]["name"];
        $profile_picture_path = $upload_dir . $profile_picture_name;

        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $profile_picture_path);
    }

    $insert_query = "INSERT INTO users (username, email, profile_picture, phone_number, password) VALUES (?, ?, ?, ?, ?)";
    $insert_stmt = $pdo->prepare($insert_query);
    $insert_stmt->execute([$username, $email, $profile_picture_path, $phone_number, $hashed_password]);

    header("Location: login.php");
    exit;
}
?>
