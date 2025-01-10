<?php
// Start the session
session_start();
session_destroy(); // Destroy the session
header("Location: index.html"); // Redirect to login2.php after logging out
exit();
?>
