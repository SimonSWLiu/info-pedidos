<?php 
include 'config.php';
include 'db.php';
permission(2);
$menu_id = $_GET['menuid'];
$sql = "DELETE FROM `menu` WHERE menu_id='$menu_id'";
$row_affected = $db->query($sql);
$db->close();
if ($row_affected == 1) header('location:' . $_SERVER['HTTP_REFERER']);
else exit('操作错误');
?>