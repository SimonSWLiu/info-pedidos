<?php
include 'config.php';
include 'db.php';
if (!isset($_SESSION['login']) || $_SESSION['login']['level'] > 3) {
	exit('没有权限');
}
$sql = "SELECT * FROM members";
$result = $db->query($sql);
$members = array();
while ($row = $result->fetch_assoc()) {
	$members[] = $row;
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>会员管理</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
<div id="category">
	<table border="1">
		<tr>
			<th>姓名</th>
			<th>电子邮箱</th>
			<th>状态</th>
			<th>等级</th>
			<th>余额</th>
			<th>操作</th>
		</tr>
	<?php foreach ($members as $row): ?>
		<tr>
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['email']; ?></td>
			<td><?php echo $row['status']; ?></td>
			<td><?php echo $row['level']; ?></td>
			<td><?php echo $row['balance']; ?></td>
			<td><a href="recharge.php?mid=<?php echo $row['mid']; ?>">充值</a> <a href="resetpwd.php?mid=<?php echo $row['mid']; ?>" onClick="if (!confirm('确定要重置密码?')) return false;">重置密码</a> <a href=".php?mid=<?php echo $row['mid']; ?>">冻结</a></td>
		</tr>
	<?php endforeach; ?>
	</table>
</div>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
</body>
</html>