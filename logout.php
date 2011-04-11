<?php
// 用户登出
session_start();
unset($_SESSION['login']);
header('location: login.php');
?>