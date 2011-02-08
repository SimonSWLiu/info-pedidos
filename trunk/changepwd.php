<?php
include 'config.php';
include 'db.php';
if ($_POST) {
	$oldPwd = $_POST['oldpwd'];
	$newPwd = $_POST['newpwd'];
	$retypePwd = $_POST['retypepwd'];
	if ($oldPwd != '' && $newPwd != '' && $retypePwd != '' && $newPwd == $retypePwd) {
		$sql = "SELECT pwd FROM members WHERE mid='{$_SESSION['login']['mid']}'";
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		if ($row['pwd'] != md5($oldPwd)) exit('原密码不同');
		$pwd = md5($newPwd);
		$sql = "UPDATE members SET pwd='$pwd' WHERE mid='{$_SESSION['login']['mid']}'";
		$rowAffected = $db->query($sql);
		if ($rowAffected == 1) {
			exit('修改成功');
		}
		mysqli_close($db);
	}
	exit('fail');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改密码</title>
</head>

<body>
<div>
	<form action="" method="post">
		<label>原密码：<input type="text" name="oldpwd" /></label><br />
		<label>新密码：<input type="text" name="newpwd" /></label><br />
		<label>确认新密码：<input type="text" name="retypepwd" /></label><br />
		<input type="submit" value="保存" />
	</form>
</div>
</body>
</html>