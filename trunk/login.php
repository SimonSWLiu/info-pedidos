<?php
include 'config.php';
if ($_POST) {
	$user = isset($_POST['user'])? $_POST['user']:'';
	$pwd = isset($_POST['pwd'])? $_POST['pwd']:'';
	if ($user == '' || $pwd == '') {
		header('location: /login.php?msg=用户名或密码不能为空');
		exit;
	}
	$md5_pwd = md5($pwd);
	$sql = "SELECT * FROM members WHERE (email='$user' AND pwd='$md5_pwd') OR (name='$user' AND pwd='$md5_pwd')";
	$result = $db->query($sql);
	if ($result) { // 登录成功
		exit('login success');
	} else { // 登录失败
		exit('login fail');
	}
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>用户登录</title>
</head>
<body>
<div>
<span><?= isset($_GET['msg'])? $_GET['msg']:''; ?></span>
<form action="" method="post">
	<label for="user">用户名: </label><input type="text" name="user" id="user" />
    <label for="user">密码: </label><input type="password" name="pwd" id="pwd" />
    <input type="checkbox" /><label for="remember">下次记住我</label>
    <input type="submit" value="登 录" />
</form>
</div>
</body>
</html>