<?php 
include 'config.php';
include 'db.php';
permission(2);

if (!isset($_SESSION['login']) || $_SESSION['login']['level'] > 2) {
	exit('没有权限');
}
if ($_POST) {
	$mid = intval($_POST['mid']);
	$recharge = floatval($_POST['recharge']);
	$note = addslashes(trim($_POST['note']));
	$sql = "SELECT * FROM members WHERE mid='$mid'";
	$result = $db->query($sql);
	$member = $result->fetch_assoc();
	$balance = $member['balance'] + $recharge;
	$sql = "UPDATE members SET balance='$balance' WHERE mid='$mid'";
	$db->query($sql);
	$affectedRows = mysqli_affected_rows($db);
	if ($affectedRows == 1) {
		// 写入日志
		$editTime = time();
		$operator = $_SESSION['login']['mid'];
		$insert = "INSERT INTO log(mid,money,operate,edit_time,operator_id,note) VALUES('$mid','$recharge','收入','$editTime',$operator,'$note')";
		mysqli_query($db, $insert);
	}
	
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
	<label>备注: <input type="text" name="note" value="充值" /></label>
	<input type="submit" value="充值" />
</form>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
</body>
</html>