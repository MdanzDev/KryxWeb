<?php
require 'vendor/env-loader.php';
$pdo = new PDO('sqlite:db/applications.db');
$stmt = $pdo->prepare("INSERT INTO applications (name, age, state, phone, email) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$_POST['name'], $_POST['age'], $_POST['state'], $_POST['phone'], $_POST['email']]);
echo "Application submitted successfully!";
?>
