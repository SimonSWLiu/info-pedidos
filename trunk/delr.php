<?php
include 'config.php';
include 'db.php';
if ($_GET) {
	$rid = $_GET['restaurant'];
	$sql = "DELETE FROM restaurant WHERE rid='$rid'"; // 删除一条餐厅名记录
	$row_affected = $db->query($sql);
	if ($row_affected == 1) header('location:' . $_SERVER['HTTP_REFERER']);
	else exit('出错');
}
?>