<?php
include 'config.php';
include 'db.php';
$pwd = md5('123456');
$sql = "UPDATE members SET pwd='$pwd' WHERE mid='{$_GET['mid']}'";
$result = $db->query($sql);
if ($result == 1) header('location: ' . $_SERVER['HTTP_REFERER']);
else exit('操作失败');
?>