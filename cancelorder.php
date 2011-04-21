<?php
include 'config.php';
include 'db.php';
permission(4);
if ($_GET) {
	$pid = $_GET['pid'];
	$sql = "SELECT * FROM pedidos_log WHERE log_id='$pid'";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_assoc($result);
	$mid = $row['mid'];
	$totalPrice = $row['total_price'];
	
	$update = "UPDATE members SET balance=balance+'$totalPrice' WHERE mid='$mid'";
	mysqli_query($db, $update);
	if (mysqli_affected_rows($db) == 1) {
		$sql = "DELETE FROM pedidos_log WHERE log_id='$pid'";
		mysqli_query($db, $sql);
	}
}
?>