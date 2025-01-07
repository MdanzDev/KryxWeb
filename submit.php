<?php
ob_start(); // Start output buffering

require 'env-loader.php';

$pdo = new PDO('sqlite:applications.db');
$stmt = $pdo->prepare("INSERT INTO applications (name, age, state, phone, email) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$_POST['name'], $_POST['age'], $_POST['state'], $_POST['phone'], $_POST['email']]);

// Success message
echo "<p>Success! We will email you soon.</p>";

// Redirect to index.html after 3 seconds
header("refresh:3; url=index.html");
exit();

ob_end_flush(); // Flush and send output to the browser
?>
