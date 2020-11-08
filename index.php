<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <title>Autos DB</title>
  <?php require_once("bootstrap.php"); ?>
</head>
<body>
<div class="container">
  <h1>Welcome to Autos Database</h1>
  <p>
  <a href="login.php">Please Log In</a>
  </p>

  <p>Any attempts to <a href="add.php">Add a vehicle</a>
  	or <a href="view.php">View the vehicle list</a> without
    logging in will fail and give an error message.</p>
</div>
</body>
</html>