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

if (isset($_POST['delete']) && isset($_POST['autos_id'])) {
	$_SESSION['delete'] = $_POST['delete'];
	$_SESSION['autos_id'] = $_POST['autos_id'];

	$sql = "DELETE FROM autos WHERE autos_id = :atsid";
	$stmt = $pdo->prepare($sql);
	$res = $stmt->execute(array(
		':atsid' => $_SESSION['autos_id']
	));
	$_SESSION['success'] = "Record deleted";
	header("Location: index.php");
	return;
}

// Guardian - Make sure autos_id is present
if (! isset($_GET['autos_id'])) {
	$_SESSION['error'] = "Missing autos_id";
	header("Location: add.php");
	return;
}

$stmt = $pdo->prepare("SELECT make, autos_id FROM autos WHERE
	autos_id = :atsid");
$stmt->execute(array(':atsid' => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
	$_SESSION['error'] = "Missing autos_id";
	header("Location: add.php");
	return;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Autos - Delete record</title>
	<?php require_once("bootstrap.php"); ?>
</head>
<body>
<div class="container">

<p>Confirm: Deleting <?= htmlentities($row['make']); ?></p>
<form method="post">
	<input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
	<input type="submit" name="delete" value="Delete">
	<input type="submit" name="cancel" value="Cancel">
</form>
<br>
<a href="logout.php">Logout</a>
</div>
</body>
</html>