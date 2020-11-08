<?php
session_start();
require_once("pdo.php");

if (! isset($_SESSION['name'])){
  die('Not logged in');
}

if (isset($_POST['cancel'])) {
  $_SESSION['cancel'] = $_POST['cancel'];
  header("Location: add.php");
  return;
}

if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
  $_SESSION['make'] = $_POST['make'];
  $_SESSION['year'] = $_POST['year'];
  $_SESSION['mileage'] = $_POST['mileage'];

  if (strlen($_SESSION['make']) < 1) {
    $_SESSION['error'] = "Make is required";
    header("Location: add.php");
    return;
  } 
  elseif (! is_numeric($_SESSION['year']) || ! is_numeric($_SESSION['mileage'])) {
    $_SESSION['error'] = "Mileage and year must be numeric";
    header("Location: add.php");
    return;
  }
  else {
    $query = "INSERT INTO autos (make, year, mileage)
    VALUES (:mk, :yr, :mlg)";
    $stmt = $pdo->prepare($query);
    $xec = $stmt->execute(array(
      ':mk' => $_SESSION['make'],
      ':yr' => $_SESSION['year'],
      ':mlg' => $_SESSION['mileage']
    ));

    if ($xec) {
      $_SESSION['success'] = "Vehicle added";
      header("Location: view.php");
      return;
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Automobiles</title>
  <?php require_once("bootstrap.php"); ?>
</head>
<body>
<div class="container">
  <h1>Edwin's Autos Database</h1>
  <?php
  echo "<h1>";
  echo "Tracking autos for ".htmlentities($_SESSION['name'])."\n";
  echo "</h1>";
  ?>
  <p>Please add a vehicle</p>
  <?php
  if (isset($_SESSION['message'])) {
    echo '<p style="color:green">'.htmlentities($_SESSION['message'])."</p>\n";
    unset($_SESSION['message']);
  }
  if (isset($_SESSION['error'])) {
    echo '<p style="color:red">'.htmlentities($_SESSION['error'])."</p>\n";
    unset($_SESSION['error']);
  }
  ?>
  <form method="post">
    <label for="mke">Make:</label><br>
    <input type="text" name="make" id="mke" size="50"><br>
    <label for="yom">Year:</label><br>
    <input type="text" name="year" id="yom"><br>
    <label for="mlge">Mileage:</label><br>
    <input type="text" name="mileage" id="mlge"><br><br>
    <input type="submit" name="" value="Add">
    <input type="submit" name="cancel" value="Cancel">
  </form>
  <br>
  <a href="add.php">Add New</a>

  <p>Go to <a href="view.php">view.php</a> to see the automobiles record</p>
</div>


</body>
</html>

<?php

?>
