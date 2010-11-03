<?php
include 'config.php';


if ($_POST) {
	$email = isset($_POST['email'])? $_POST['email']:'';
	$name = isset($_POST['name'])? $_POST['name']:'';
	$pwd = isset($_POST['pwd'])? $_POST['pwd']:'';
	$repwd = isset($_POST['repwd'])? $_POST['repwd']:'';
	if ($email == '' || $name == '' || $pwd == '' || $repwd == '') {
		header('Location: /reg.php?msg=资料不完整');
		exit;
	}
	$name_len = strlen($name);
	$pattern = '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/'; // 电子邮箱的正则匹配
	preg_match($pattern, $email);
	if ($name_len < 6 || $name_len > 16) {
		header('Location: /reg.php?msg=姓名不能少于6个字符或超过16个字符');
		exit;
	} elseif ($pwd != $repwd) {
		header('location: /reg.php?msg=两次密码输入不相同');
		exit;
	} elseif (preg_match($pattern, $email) == 0) {
		header('location: /reg.php?msg=请输入正确的电子邮箱');
		exit;
	}
	$sql = "SELECT COUNT(*) FROM members WHERE email=$email OR name=$name";
	$result = $db->query($sql);
	if ($result) {
		header('location: /reg.php?msg=帐号已存在');
		exit;
	}
	$sql = "INSERT INTO members(email,name,pwd) VALUES('$email','$name','" . md5($pwd) . "')";
	$result = $db->query($sql);
	if ($result) exit('success');
	else exit('注册失败');
	header('location: /login.php');
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>注册</title>
</head>
<body>
<!--<header>
	<h1>这是header，测试</h1>
</header>
<nav>
	<ul>
    	<li>test1</li>
        <li>test2</li>
    </ul>
</nav>
--><span><?php if(isset($_GET['msg'])) echo $_GET['msg']; ?></span>
<div>
<form action="" method="post">
	<label for="email">电子邮箱: </label><input type="text" name="email" id="email" />
    <label for="name">用户姓名: </label><input type="text" name="name" id="name" />
    <label for="pwd">登录密码: </label><input type="password" name="pwd" id="pwd" />
    <label for="repwd">再次输入密码: </label><input type="password" name="repwd" id="repwd" />
    <input type="submit" value="注 册" />
</form>
</div>
<!--<footer>
	<h2>这是footer</h2>
</footer>
--></body>
</html>