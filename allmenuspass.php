<?php
include 'config.php';
include 'db.php';
if ($_GET) {
	$logsStr = $_GET['logs'];
	$logArr = explode(';', $logsStr);
	array_pop($logArr);
	foreach($logArr as $row) {
		$sql = "SELECT mid,total_price,status FROM pedidos_log WHERE log_id='$row'";
		$result = $db->query($sql);
		unset($result);
		$log = $result->fetch_assoc();
		$mid = $log['mid'];
		$totalPrice = $log['total_price'];
		$status = $log['status'];
		if ($status != 1) {
//			$sql = "UPDATE members SET balance=balance-$totalPrice WHERE mid='$mid'";
//			$result = $db->query($sql);
//			unset($result);
			$sql = "UPDATE pedidos_log SET status='1' WHERE log_id='$row'";
			$result = $db->query($sql);
			unset($result);
		}
	}
	$dateArr = getdate();
	$todayYear = $dateArr['year'];
	$todayMonth = $dateArr['mon'];
	$todayDay = $dateArr['mday'];
	$sql = "SELECT DISTINCT mid FROM pedidos_log WHERE year='$todayYear' AND month='$todayMonth' AND day='$todayDay' AND (hour<11 OR (hour=11 AND minute<30))";
	$result = mysqli_query($db, $sql);
	echo '1';
	exit;
}
?>