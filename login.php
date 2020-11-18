<?php
session_start();

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

if (isset($_POST['cancel'])) {
	$_SESSION['cancel'] = $_POST['cancel'];
	session_destroy();
	header("Location: index.php");
	return;
}

if (isset($_POST['email']) && isset($_POST['pass'])) {
	unset($_SESSION['name']);
	$_SESSION['name'] = $_POST['email'];
	$_SESSION['pass'] = $_POST['pass'];

	// Check whether email and password are empty
	if ( strlen($_SESSION['name']) < 1 || strlen($_SESSION['pass']) < 1) {
		$_SESSION['error'] = "User name and password are required";
		header("Location: login.php");
		return;
	}
	elseif (strpos($_SESSION['name'], '@') === false) {
		$_SESSION['error'] = "Username must have an at-sign (@)";
		header("Location: login.php");
		return;
	}
	else {
		$check = hash('md5', $salt.$_SESSION['pass']);
		if ($check == $stored_hash) {
			error_log("Login success ". $_SESSION['name']);
			header("Location: index.php?");
			return;
		}
		else {
			error_log("Login fail ". $_SESSION['name']. "$check");
			$_SESSION['error'] = "Incorrect Password";
			header("Location: login.php");
			return;
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Autos Login</title>
	<?php require_once("bootstrap.php"); ?>
</head>
<body>
<div class="container">
	<h1>Please Log in</h1>
	<?php
	if (isset($_SESSION['error'])) {
		echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
		unset($_SESSION['error']);
	}
	?>
	<form method="post">
		User Name <input type="text" name="email"><br/>
		Password <input type="password" name="pass"><br/>
		<input type="submit" name="login" value="Log In">
		<input type="submit" name="cancel" value="Cancel">
	</form>
</div>
</body>
</html>