<div class="login-win">
	<span><?php echo isset($_GET['msg'])? $_GET['msg']:''; ?></span>
	<form action="" method="post">
		<label for="user">用户名或邮箱: </label><br /><input type="text" name="user" id="user" /><br />
		<label for="user">密码: </label><br /><input type="password" name="pwd" id="pwd" /><br />
		<input type="submit" value="登 录" />
		<a href="reg.php">注册</a>
	</form>
</div>