<?php
require 'env-loader.php';
session_start();

if ($_POST) {
    if ($_POST['username'] === getenv('ADMIN_USER') && $_POST['password'] === getenv('ADMIN_PASS')) {
        $_SESSION['logged_in'] = true;
        header('Location: admin.php');
        exit();
    } else {
        echo "Invalid credentials!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Admin Login</h1>
    </header>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
