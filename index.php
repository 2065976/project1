<?php

// Initialize the session.
session_start();

include_once 'database.php';

$alert = '';

// Check all fields
if (isset($_POST['login'])) {

	$fieldnames = array('username', 'password');

	$error = false;

  // Loop fieldnames in $_POST[]
  foreach ($fieldnames as $data) {

    if(!isset($_POST[$data]) || empty($_POST[$data])){

      $error = true;

    }

	}
	
	// Alert when required fields are empty
  if ($error) { 
 
    $alert = '<div class="alert alert-warning"><a href="#" class="close" alert-block data-dismiss="alert" aria-label="close">&times;</a>'.'Please fill in all required fields' .'</div>';

  }

  // Login if everything is OK
  else {

		$username = strtolower($_POST['username']);
		$password = $_POST['password'];

		$alert = $_SESSION['alert'];

		$db = new database('localhost', 'root', '', 'project1', 'utf8');

		$db->login($username, $password);

	}

}
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
		<link rel="stylesheet" href="css/style.css">
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="container">
		<h2>Login</h2><hr>

			<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
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
					<a href="signup.php"><input type="button" class="btn btn-default btn-sm" value="Sign Up"></a>
					<a href="lostpsw.php"><input type="button" class="btn btn-default btn-sm" value="Recover Password"></a><br><br>
					<input type="submit" class="btn btn-light btn-block btn-lg" name="login" value="Login">
				</div>
			</form>

			<?php echo $alert; ?>

		</div>
	</body>
</html>