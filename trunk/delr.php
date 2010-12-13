<?php
include 'config.php';
if ($_GET) {
	$rid = $_GET['restaurant'];
	$sql = "DELETE FROM restaurant WHERE rid='$rid'"; // 删除一条餐厅名记录
	$db->query($sql);
}
?>