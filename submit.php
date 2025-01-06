<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $age = htmlspecialchars($_POST['age']);
    $state = htmlspecialchars($_POST['state']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);

    $to = "nightmaremoon297@gmail.com";
    $subject = "New Application for Kryx Clan";
    $message = "Name: $name\nAge: $age\nState of Living: $state\nPhone: $phone\nEmail: $email";
    $headers = "From: $email";

    if (mail($to, $subject, $message, $headers)) {
        echo "Application submitted successfully!";
    } else {
        echo "Failed to send application. Please try again.";
    }
}
?>
