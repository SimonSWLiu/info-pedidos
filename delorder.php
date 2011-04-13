<?php
include 'config.php';
include 'db.php';
$log_id = $_GET['lid'];
$sql = "SELECT * FROM pedidos_log WHERE log_id='$log_id'";
$result = $db->query($sql);
$log = $result->fetch_assoc();
$mid = $log['mid'];
$total_price = $log['total_price'];
$result->free();
$update = "UPDATE members SET balance=balance+'$total_price' WHERE mid='$mid'";
$row_affected = $db->query($update);
if ($row_affected == 1) {
	// 更新成功
	$del = "DELETE FROM pedidos_log WHERE log_id='$log_id'";
	$del_affected = $db->query($del);
	if ($del_affected == 1) {
		header('location:' . $_SERVER['HTTP_REFERER']);
		exit;
	}
}
?>