<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}
$pdo = new PDO('sqlite:applications.db');
$stmt = $pdo->query("SELECT * FROM applications");
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
    </header>
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>State</th>
                <th>Phone</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($applications as $app): ?>
                <tr>
                    <td><?php echo $app['id']; ?></td>
                    <td><?php echo $app['name']; ?></td>
                    <td><?php echo $app['age']; ?></td>
                    <td><?php echo $app['state']; ?></td>
                    <td><?php echo $app['phone']; ?></td>
                    <td><?php echo $app['email']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="logout.php">Logout</a>
        <a href="annouce.php">Annouce</a>
</body>
</html>
