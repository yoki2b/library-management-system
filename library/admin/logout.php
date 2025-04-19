<?php
session_start();

// Destroy all session data
$_SESSION = array();
session_destroy();

// Set headers to prevent back navigation
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// Redirect to login page
header("Location: index.php");
exit;
?>
