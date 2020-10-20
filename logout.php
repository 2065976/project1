<?php

// Initialize the session.
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy user session
session_destroy();

// Redirect user to index page
header("Location: index.php");

exit();

?>