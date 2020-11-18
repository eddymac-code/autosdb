<?php
require_once("pdo.php");
session_start();

if (! isset($_SESSION['name'])) {
	die("ACCESS DENIED");
}

if (isset($_POST['cancel'])) {
	header("Location: index.php");
	return;
}

if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])) {
	$_SESSION['make'] = $_POST['make'];
	$_SESSION['model'] = $_POST['model'];
	$_SESSION['year'] = $_POST['year'];
	$_SESSION['mileage'] = $_POST['mileage'];

	if (strlen($_SESSION['make']) == 0 || strlen($_SESSION['model']) == 0 || strlen($_SESSION['year']) == 0 || 
	strlen($_SESSION['mileage']) == 0) {
		$_SESSION['error'] = "All values are required";
		header("Location: add.php");
		return;
	}
	elseif (! is_numeric($_SESSION['year'])) {
		$_SESSION['error'] = "Year must be an integer";
		header("Location: add.php");
		return;
	}
	elseif (! is_numeric($_SESSION['mileage'])) {
		$_SESSION['error'] = "Mileage must be an integer";
		header("Location: add.php");
		return;
	}
	else {
		$sql = "INSERT INTO autos (make, model, year, mileage)
		VALUES (:mk, :mdl, :yr, :mlg)";
		$stmt = $pdo->prepare($sql);
		$exec = $stmt->execute(array(
			':mk' => $_SESSION['make'],
			':mdl' => $_SESSION['model'],
			':yr' => $_SESSION['year'],
			':mlg' => $_SESSION['mileage']
		));
		$_SESSION['success'] = "Record added";
		header("Location: index.php");
		return;
	}
}



?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Vehicles</title>
	<?php require_once("bootstrap.php"); ?>
</head>
<body>
<div class="container">

<!-- <h1>Automobiles List</h1> -->
<?php
/*if (isset($_SESSION['success'])) {
	echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
	unset($_SESSION['success']);
}

$row = "";
$show = $pdo->query("SELECT * FROM autos");
echo '<table border="1">'."\n";
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
while ($row = $show->fetch(PDO::FETCH_ASSOC)) {
	
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
	
}*/	
?>
<!-- </table> -->

<h1>Tracking automobiles for <?php echo htmlentities($_SESSION['name']); ?></h1>
<?php
if (isset($_SESSION['error'])) {
	echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
	unset($_SESSION['error']);
}
?>
<form method="post">
	Make:   <input type="text" name="make"><br/>
	Model:  <input type="text" name="model"><br/>
	Year:   <input type="text" name="year"><br/>
	Mileage:<input type="text" name="mileage"><br/>
	<input type="submit" name="add" value="Add">
	<input type="submit" name="cancel" value="Cancel">
</form>
<br>
<a href="logout.php">Logout</a>
</div>
</body>
</html>