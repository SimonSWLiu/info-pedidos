<?php
date_default_timezone_set('Asia/Shanghai');
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL | E_STRICT);
$HOST = 'localhost';
$DB_USER = 'root';
$DB_PWD = '123456';
$DB_NAME = 'pedidos';
//$db = new mysqli($HOST, $DB_USER, $DB_PWD, $DB_NAME);
$db = mysqli_connect($HOST, $DB_USER, $DB_PWD, $DB_NAME);
if (mysqli_connect_errno()) {
	exit('Error: Could not connect to database. Please try again later.');
}
mysqli_set_charset($db, 'utf8');
session_start();
?>