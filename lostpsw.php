<?php
 
include_once 'database.php';

$db = new database('localhost', 'root', '', 'project1', 'utf8');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Recovery</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper">
        <h2>Password Recovery</h2>
        <p>Please fill in your e-mail to recover password.</p>
        <form action="" method="post">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="text" name="email" class="form-control" value="">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="recover" value="Recover">
            </div>
            <p>Don't have an account? <a href="signup.php">Sign up now</a></p>
        </form>
    </div>
</body>
</html>