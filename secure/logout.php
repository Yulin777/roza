<?php

// Initialize the session
session_start();

// Unset all of the session variables - append empty array
$_SESSION = array();
// Destroy the session.
session_destroy();
// Redirect to login page
header("location: login.php");
exit;
?>