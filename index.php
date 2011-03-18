<?php
include './config.php';
include './db.php';
$uri = $_SERVER['REQUEST_URI'];
if ($uri == '/') {
	include '.' . $uri . 'login.php';
} else {
	include '.' . $uri . '.php';
}
mysqli_close($db);
//header('location: login.php');
?>