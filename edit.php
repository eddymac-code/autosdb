<?php
require_once("pdo.php");
session_start();

if (! isset($_SESSION['name'])) {
	die("ACCESS DENIED");
}

if (isset($_POST['cancel'])) {
	$_SESSION['cancel'] = $_POST['cancel'];
	header("Location: index.php");
	return;
}

if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && 
	isset($_POST['mileage']) && isset($_POST['autos_id'])) {
	$_SESSION['make'] = $_POST['make'];
	$_SESSION['model'] = $_POST['model'];
	$_SESSION['year'] = $_POST['year'];
	$_SESSION['mileage'] = $_POST['mileage'];
	$_SESSION['autos_id'] = $_POST['autos_id'];

	if (strlen($_SESSION['make']) < 0 || strlen($_SESSION['model']) < 0 || strlen($_SESSION['year']) < 0 || 
	strlen($_SESSION['mileage']) < 0) {
		$_SESSION['error'] = "All values are required";
		header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
		return;
	}
	elseif (! is_numeric($_SESSION['year'])) {
		$_SESSION['error'] = "Bad data";
		header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
		return;
	}
	elseif (! is_numeric($_SESSION['mileage'])) {
		$_SESSION['error'] = "Mileage must be an integer";
		header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
		return;
	}
	else {
		$sql = "UPDATE autos SET make = :mk,
		model = :mdl, year = :yr, mileage = :mlg
		WHERE autos_id = :autos_id";
		$stmt = $pdo->prepare($sql);
		$exec = $stmt->execute(array(
			':mk' => $_SESSION['make'],
			':mdl' => $_SESSION['model'],
			':yr' => $_SESSION['year'],
			':mlg' => $_SESSION['mileage'],
			':autos_id' => $_SESSION['autos_id']
		));
		$_SESSION['success'] = "Record Updated!";
		header("Location: index.php");
		return;
	}
}

if (! isset($_GET['autos_id'])) {
	$_SESSION['error'] = "Missing autos_id";
	header("Location: add.php");
	return;
}

$stmt = $pdo->prepare("SELECT * FROM autos WHERE autos_id = :atsid");
$stmt->execute(array(
	':atsid' => $_GET['autos_id']
));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row === false) {
	$_SESSION['error'] = "Bad value for user_id";
	header("Location: add.php");
	return;
}

$m = htmlentities($row['make']);
$md = htmlentities($row['model']);
$y = htmlentities($row['year']);
$ml = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];

?>
<!DOCTYPE html>
<html>
<head>
	<title>Autos - Edit</title>
	<?php require_once("bootstrap.php"); ?>
</head>
<body>
<div class="container">
<h1>Update Your Record</h1>
<?php
if (isset($_SESSION['error'])) {
	echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
}
?>
<form method="post">
	Make:   <input type="text" name="make" value="<?= $m ?>"><br/>
	Model:  <input type="text" name="model" value="<?= $md ?>"><br/>
	Year:   <input type="text" name="year" value="<?= $y ?>"><br/>
	Mileage:<input type="text" name="mileage" value="<?= $ml ?>"><br/>
	<input type="hidden" name="autos_id" value="<?= $autos_id ?>">
	<input type="submit" name="add" value="Save">
	<input type="submit" name="cancel" value="Cancel">
</form>
<br>
<a href="logout.php">Logout</a>
</div>
</body>
</html>