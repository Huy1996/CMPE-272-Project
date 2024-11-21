<?php
// Start the session
session_start();

// Clear the session
session_unset();
session_destroy();

// Clear the JWT cookie
setcookie("auth_token", "", time() - 3600, "/"); // Set the cookie to expire in the past

// Redirect to the login page or homepage
header("Location: login.php");
exit();
?>