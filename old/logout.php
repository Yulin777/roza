<?php

// Initialize the session
session_start();

if (isset($_COOKIE['rozacafe'])) {
    echo "\nroza cookie is in the house\n";
    unset($_COOKIE['rozacafe']);
    setcookie("rozacafe", null, -1, "/");/*final num setes the num of days*/
}
// Unset all of the session variables - append empty array
$_SESSION = array();
// Destroy the session.
session_destroy();
// Redirect to login page
header("location: login.php");
exit;
?>
