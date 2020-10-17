<?php

include_once "database.php";

$db = new database('localhost', 'root', '', 'project1', 'utf8');

// Insert data into database
if (isset($_POST['signUp'])){

  $firstname = ucwords($_POST['firstname']);
  $middlename = $_POST['middlename'];
  $lastname = ucwords($_POST['lastname']);
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password_confirm = $_POST['password_confirm'];

  if ($password === $password_confirm){
    $db->signUp($firstname, $middlename, $lastname, $email, $password, $username);

  } else {

    echo "An error occured!";
    
  }
  
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <h2>Sign Up</h2><br>
    <form action="" method="post">

    <div class="form-group">
      <label for="firstname">Firstname</label>
      <input type="text" id="firstname" name="firstname" class="form-control" required>
      <span class="help-block"></span>
    </div>

    <div class="form-group">
      <label for="middlename">Middlename</label>
      <input type="text" name="middlename" class="form-control">
      <span class="help-block"></span>
    </div>

    <div class="form-group">
      <label for="lastname">Lastname</label>
      <input type="text" name="lastname" class="form-control" required>
      <span class="help-block"></span>
    </div>

    <div class="form-group">
      <label for="email">E-mail</label>
      <input type="text" name="email" class="form-control" required>
      <span class="help-block"></span>
    </div>

    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" name="username" class="form-control" required>
      <span class="help-block"></span>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="password" class="form-control" required>
      <span class="help-block"></span>
    </div>

    <div class="form-group">
      <label for="password_confirm">Confirm Password</label>
      <input type="password" name="password_confirm" class="form-control" required>
      <span class="help-block"></span>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-light btn-block btn-lg" name="signUp" value="Submit">
    </div>

    <span class="help-block"></span>
    <p>Already have an account? <a href="index.php">Login here</a></p>

    </form>
  </div>    
</body>
</html>