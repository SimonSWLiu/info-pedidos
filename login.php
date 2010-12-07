<?php
include 'config.php';
if (isset($_SESSION['member'])) header('location: /loginsuccess.php');
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
	mysqli_close($db);
	if ($result) { // 登录成功
		// 写入session
		$row = $result->fetch_assoc();
		$_SESSION['member'] = array('mid'=>$row['mid'], 'email'=>$row['email'], 'name'=>$row['name'], 'status'=>$row['status'], 'level'=>$row['level']);
		header('location: /loginsuccess.php');
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
<link type="text/css" rel="stylesheet" href="styles/global.css" />
<script type="text/javascript" src="/scripts/jquery.js"></script>
<script type="text/javascript" src="/scripts/global.js"></script>
</head>
<body>
<div class="login-win">
	<span><?= isset($_GET['msg'])? $_GET['msg']:''; ?></span>
	<form action="" method="post">
		<label for="user">用户名: </label><input type="text" name="user" id="user" /><br />
		<label for="user">密码: </label><input type="password" name="pwd" id="pwd" /><br />
		<input type="checkbox" /><label for="remember">下次记住我</label><br />
		<input type="submit" value="登 录" />
	</form>
</div>
</body>
</html>