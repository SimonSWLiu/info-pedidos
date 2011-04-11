<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>用户登录</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/global.js"></script>
</head>
<body>
<div class="login-win">
	<span><?= isset($_GET['msg'])? $_GET['msg']:''; ?></span>
	<form action="" method="post">
		<label for="user">用户名或邮箱: </label><br /><input type="text" name="user" id="user" /><br />
		<label for="user">密码: </label><br /><input type="password" name="pwd" id="pwd" /><br />
<!--		<input type="checkbox" id="remember" /><label for="remember">下次记住我</label><br />-->
		<input type="submit" value="登 录" />
		<a href="reg.php">注册</a>
	</form>
</div>
</body>
</html>