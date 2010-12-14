<?php
include 'config.php';
if ($_GET) {
	$rid = $_GET['rid'];
	$sql = "SELECT * FROM category WHERE rid='$rid'";
	$result = $db->query($sql);
	mysqli_close($db);
	$category = array();
	while ($row = $result->fetch_assoc()) {
		$category[] = $row;
	}
}
?>