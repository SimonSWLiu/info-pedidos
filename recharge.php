<?php 
include 'config.php';
include 'db.php';
if ($_POST) {
	$mid = $_POST['mid'];
	$sql = "SELECT * FROM members WHERE mid='$mid'";
	$result = $db->query($sql);
	$member = $result->fetch_assoc();
	$balance = $member['balance'] + $_POST['recharge'];
	$sql = "UPDATE members SET balance='$balance' WHERE mid='$mid'";
	$result = $db->query($sql);
	$_GET['mid'] = $mid;
}
$mid = $_GET['mid'];
$sql = "SELECT * FROM members WHERE mid='$mid'";
$result = $db->query($sql);
$member = $result->fetch_assoc();
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>会员管理</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
<div>会员: <span><?php echo $member['name']; ?></span></div>
<div>余额: <span><?php echo $member['balance']; ?></span></div>
<form action="" method="post">
	<input type="hidden" name="mid" value="<?php echo $mid; ?>" />
	<label>充值: <input type="text" name="recharge" />元</label>
	<input type="submit" value="充值" />
</form>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
</body>
</html>