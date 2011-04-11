<?php 
include 'config.php';
include 'db.php';
if ($_GET) {
	$cid = $_GET['cid'];
	$sql = "DELETE FROM category WHERE cid='$cid'";
	$row_affected = $db->query($sql);
	if ($row_affected == 1) header('location: ' . $_SERVER['HTTP_REFERER']);
	else exit('操作出错');
}
?>