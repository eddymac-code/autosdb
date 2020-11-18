<?php
require_once("pdo.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Autos Index</title>
  <?php require_once("bootstrap.php"); ?>
</head>
<body>
<div class="container">
 	<h1>Welcome to the Automobiles Database</h1>
<?php
if (! isset($_SESSION['name'])) {
	echo '<a href="login.php">Please log in'."</a>\n";
	echo "<br>";
	echo 'Attempt to <a href="add.php">add data'."</a> without logging in\n";
}
else {
	if (isset($_SESSION['success'])) {
	echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
	unset($_SESSION['success']);
	}

	$query = "SELECT * FROM autos";
	echo '<table border="1">'."\n";
	$stmt = $pdo->query($query);
	// return only field names
	$fields = $stmt->fetch(PDO::FETCH_ASSOC);

	if (! $fields) {
		echo "<p>No records found</p>\n";
	}
	else
	{
		echo "<tr><th>";
		echo "<strong>Make</strong>";
		echo "</th><th>";
		echo "<strong>Model</strong>";
		echo "</th><th>";
		echo "<strong>Year</strong>";
		echo "</th><th>";
		echo "<strong>Mileage</strong>";
		echo "</th><th>";
		echo "<strong>Action</strong>";
		echo "</th></tr>";

		// another query to get table data
		$data = $pdo->query($query);
		$row = false;

		while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
			echo "<tr><td>";
			echo htmlentities($row['make']);
			echo "</td><td>";
			echo htmlentities($row['model']);
			echo "</td><td>";
			echo htmlentities($row['year']);
			echo "</td><td>";
			echo htmlentities($row['mileage']);
			echo "</td><td>";
			echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
			echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
			echo "</td></tr>\n";
		}
		echo "</table>\n";
	}
	echo "<br>";
	echo '<a href="add.php">Add New Entry'."</a>\n";
	echo "<br>";
	echo '<a href="logout.php">Logout'."</a>\n";
}	
?>
</div> 
</body>
</html>