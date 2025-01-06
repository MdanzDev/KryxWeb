<?php
$to = "nightmaremoon297@gmail.com";
$subject = "Test Email";
$message = "This is a test email sent from the server!";
$headers = "From: no-reply@kryxclan.com";

if (mail($to, $subject, $message, $headers)) {
    echo "Mail sent successfully!";
} else {
    echo "Failed to send mail.";
}
?>
