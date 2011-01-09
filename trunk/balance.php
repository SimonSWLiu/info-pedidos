<?php
include 'config.php';
include 'db.php';
$sql = "SELECT balance FROM members WHERE mid='{$_SESSION['login']['mid']}'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
$myBalance = $row['balance'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的余额</title>
</head>

<body>
<div>我的余额：<span><?php echo $myBalance; ?></span></div>
</body>
</html>
