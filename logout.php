<?php

session_start();

unset($_SESSION["username"]);
unset($_SESSION["password"]);

// Destroy user session
session_destroy();

// Redirect user to index page
header("Location: index.php");

exit();

?>