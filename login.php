<?php
session_start();

if (isset($_SESSION['cancel'])) {
  header("Location: index.php");
  return;
}

if (isset($_POST['cancel'])) {
  $_SESSION['cancel'] = $_POST['cancel'];
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

if (isset($_POST['email']) && isset($_POST['pass'])) {
  unset($_SESSION['name']);
  $_SESSION['name'] = $_POST['email'];
  $_SESSION['pass'] = $_POST['pass'];

  if (strlen($_SESSION['name']) < 1 || strlen($_SESSION['pass']) < 1) {
    $_SESSION['error'] = "Email and Password required";
    header("Location: login.php");
    return;
  }
  elseif (strpos($_SESSION['name'], "@") < 1) {
    $_SESSION['error'] = "Email must have an at-sign (@)";
    header("Location: login.php");
    return;
  }
  else {
    $check = hash('md5', $salt.$_SESSION['pass']);
    if ($check == $stored_hash) {
      error_log("Login success ". $_SESSION['name']);
      header("Location: add.php?name=".urlencode($_SESSION['name']));
      return;
    }
    else {
      error_log("Login fail ". $_SESSION['name'] . "$check");
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
  <title>Login page</title>
  <?php require_once("bootstrap.php"); ?>
</head>
<body>
<div class="container">
  <h1>Please Log in here</h1>
  <?php
  if (isset($_SESSION['error'])) {
    echo '<p style="color:red">' . htmlentities($_SESSION['error']) . "</p>\n";
    unset($_SESSION['error']);
  }
  ?>
  <form method="post">
    <label for="eml">Email:</label><br>
    <input type="text" name="email" id="eml"><br>
    <label for="pwd">Password:</label><br>
    <input type="password" name="pass" id="pwd"><br><br>
    <input type="submit" value="Log In">
    <input type="submit" name="cancel" value="Cancel">
  </form>
</div>
</body>  

<!-- Password hard-coded to php123 for now -->
</html>
