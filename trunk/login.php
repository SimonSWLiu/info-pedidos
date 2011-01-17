<?php
include 'config.php';
include 'db.php';
if (isset($_SESSION['login'])) header('location: /pedidos.php');
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
	$row = $result->fetch_assoc();
	if ($row) { // success
		// 写入session
		$_SESSION['login'] = array('mid'=>$row['mid'], 'email'=>$row['email'], 'name'=>$row['name'], 'status'=>$row['status'], 'level'=>$row['level']);
		header('location: /pedidos.php');
		exit('login success');
	} else {
		$msg = '用户名或密码错误';
		header('location: /login.php?msg=' . $msg);
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
		<label for="user">用户名: </label><br /><input type="text" name="user" id="user" /><br />
		<label for="user">密码: </label><br /><input type="password" name="pwd" id="pwd" /><br />
		<input type="checkbox" id="remember" /><label for="remember">下次记住我</label><br />
		<input type="submit" value="登 录" />
	</form>
</div>
</body>
</html>