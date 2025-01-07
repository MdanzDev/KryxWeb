<?php
require 'env-loader.php';

$pdo = new PDO('sqlite:applications.db');
$stmt = $pdo->prepare("INSERT INTO applications (name, age, state, phone, email) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$_POST['name'], $_POST['age'], $_POST['state'], $_POST['phone'], $_POST['email']]);

// Redirect to index.html after 3 seconds
header("refresh:3; url=index.html");
exit();

// Success message will now be printed after the redirect
echo "<p>Success! We will email you soon.</p>";
?>
