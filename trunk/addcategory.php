<?php
// 增加类别
include 'config.php';
include 'db.php';
if ($_GET) {
	$rid = $_GET['rid'];
	$category_name = $_GET['category_name'];
	$sql = "INSERT INTO category(`c_name`,`rid`) VALUES('$category_name','$rid')";
	$db->query($sql);
	header('location: /editrestaurant.php?rid=' . $rid);
}
?>