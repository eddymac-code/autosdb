<?php
session_start();
require_once("pdo.php");

if (! isset($_SESSION['name'])) {
	die('Not logged in');
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>View Automobiles</title>
	<?php require_once("bootstrap.php") ?>
</head>
<body>
<div class="container">
<h1>Automobiles</h1>

<?php
if (isset($_SESSION['success'])) {
	echo '<p style="color:green">' . htmlentities($_SESSION['success']) . "</p>\n";
	unset($_SESSION['success']);
}
?>

<?php
$sql = "SELECT * FROM autos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll();

foreach ($rows as $row) {
	echo "<ul>";
	echo "<li>";
	echo htmlentities($row['year'] . " " . $row['make'] . " / " . $row['mileage']) . "\n";
	echo "</li>";
	echo "</ul>";
}
?>

<p>You can <a href="add.php">Add New Vehicle here</a></p>

<p>You can <a href="logout.php">Logout Here</a></p>
</div>
</body>
</html>