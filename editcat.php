<?php
include 'config.php';
include 'db.php';
if ($_POST) {
	$cName = $_POST['category'];
	$cid = $_POST['cid'];
	$sql = "UPDATE category SET c_name='$cName' WHERE cid='$cid'";
	$result = $db->query($sql);
	mysqli_close($db);
	header('location:' . $_SERVER['HTTP_REFERER']);
}
?>