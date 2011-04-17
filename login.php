<?php
define('APP_PATH', realpath(dirname(__FILE__)));
include APP_PATH . '/config.php';
include APP_PATH . '/db.php';

if (isset($_SESSION['login'])) header('location: pedidos.php'); // 已登录的跳转到pedidos.php页面

if ($_POST) {
	$user = isset($_POST['user'])? $_POST['user']:'';
	$pwd = isset($_POST['pwd'])? $_POST['pwd']:'';
	if ($user == '' || $pwd == '') {
		header('location: login.php?msg=用户名或密码不能为空');
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
		header('location: pedidos.php');
		exit('login success');
	} else {
		$msg = '用户名或密码错误';
		header('location: login.php?msg=' . $msg);
	}
}
?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>用户登录</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
<script type="text/javascript" src="scripts/cookies.js"></script>
<!--<script type="text/javascript" src="scripts/jquery.js"></script>-->
<!--<script type="text/javascript" src="scripts/global.js"></script>-->
</head>
<body>
<div class="login-win">
	<span><?php echo isset($_GET['msg'])? $_GET['msg']:''; ?></span>
	<form action="" method="post" onsubmit="return beforeSubmit()">
		<label for="user">用户名或邮箱: </label><br /><input type="text" name="user" id="user" /><br />
		<label for="pwd">密码: </label><br /><input type="password" name="pwd" id="pwd" /><br />
		<label for="remember_user"><input type="checkbox" name="remember_user" id="remember_user" checked="checked" value="1" />记住用户名</label><br />
		<input type="submit" value="登 录" />
		<a href="reg.php">注册</a>
	</form>
</div>
<script type="text/javascript">
window.onload = function() {
	var user = document.getElementById('user');
	var pwd = document.getElementById('pwd');
	
	// 判断cookie中是否已存在用户名
	user.value = getCookie('pedidos_user');
	if(user.value != '') pwd.focus();
	else user.focus();
}

/**
 * 登录表单提交前执行
 */
function beforeSubmit() {
	// 判断是否需要记住用户名
	var remember = document.getElementById('remember_user');
	if (remember.checked == true && remember.value == 1) {
		// 选中，写入cookie
		setCookie('pedidos_user', document.getElementById('user').value);
	} else {
		// 没有选中，则不记录用户名，且删除原来的用户名
		delCookie('pedidos_user');
	}
}
</script>
</body>
</html>