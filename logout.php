<?php

session_start();

unset($_SESSION["username"]);
unset($_SESSION["password"]);

// Redirect user to index page
header("Location: index.php");

exit;

?>