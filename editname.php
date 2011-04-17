<?php
include 'config.php';
include 'db.php';
if (!isset($_SESSION['login'])) {
	exit('Please login first.');
}

if ($_POST) {
	$name = trim($_POST['name']);
	if (!$name) {
		exit('Please input your name.');
	}
	$mid = $_SESSION['login']['mid'];
	$sql2 = "SELECT COUNT(*) count FROM members WHERE name='$name'";
	$result2 = mysqli_query($db, $sql2);
	$count = mysqli_fetch_assoc($result2);
	if ($count['count'] != 0) { // 已经有人改了这个名字
		header('location: editname.php?msg=名称已存在');
	}
	$sql = "UPDATE members SET name='$name' WHERE mid='$mid'";
	$result = mysqli_query($db, $sql);
	if (mysqli_affected_rows($db) == 1) {
		$_SESSION['login']['name'] = $name;
		exit('success!<script>parent.location.href="pedidos.php"</script>');
	}
}
?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>点餐</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>

<body>
	<div><?php echo isset($_GET['msg'])? $_GET['msg'] : ''; ?></div>
	<form action="" method="post">
		输入姓名：<input type="text" name="name" value="<?php echo $_SESSION['login']['name']; ?>" />
		<input type="submit" value="保存" />
	</form>
</body>
</html>