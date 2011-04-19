<?php
include 'config.php';
include 'db.php';
permission(2);
if ($_GET) {
	$mid = isset($_GET['mid'])? $_GET['mid'] : 0;
	if ($mid == 0) exit('Param error.');
	$mid = intval($mid);
	$update = "UPDATE members SET status=0 WHERE mid='$mid'";
	mysqli_query($db, $update);
	header('location: members.php');
}
?>