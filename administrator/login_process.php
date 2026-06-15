<?php
session_start();

include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $select_query = "SELECT * FROM users WHERE username = ?";
    $select_stmt = $pdo->prepare($select_query);
    $select_stmt->execute([$username]);
    $user = $select_stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Invalid username or password";
    }
}
?>
