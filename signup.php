<?php

include_once "database.php";

$alert = "";

// Check all fields
if (isset($_POST['signUp'])){

  $fieldnames = array('firstname', 'lastname', 'username', 'email', 'password', 'password_confirm');

  $error = false;

  // Loop fieldnames in $_POST[]
  foreach ($fieldnames as $data) {
    if(empty($_POST[$data])){
      $error = true;
    }
  }

  // Alert when required fields are empty
  if ($error) {  
    $alert = '<div class="alert alert-warning"><a href="#" class="close" alert-block data-dismiss="alert" aria-label="close">&times;</a>'.'Please fill in all required fields' .'</div>';    
  }

  // Insert data into database if everything is OK
  else {

    $db = new database("localhost", "root", "", "project1", "utf8");

    $firstname = ucwords($_POST['firstname']);
    $middlename = $_POST['middlename'];
    $lastname = ucwords($_POST['lastname']);
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

  }

  // Alert when passwords do not match
  if ($password != $password_confirm) {
    $alert = '<div class="alert alert-warning"><a href="#" class="close" alert-block data-dismiss="alert" aria-label="close">&times;</a>'.'Passwords do not match' .'</div>';

  }else {
    $db->signUp($firstname, $middlename, $lastname, $email, $password, $username);
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
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container">
    <h2>Sign Up</h2><br>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">

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
    <?php echo $alert; ?>
  </div>
</body>
</html>