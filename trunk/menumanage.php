<?php
// 菜单管理页面
include 'config.php';
include 'db.php';
permission(2);

if (!isset($_SESSION['login']) || $_SESSION['login']['level'] > 3) {
	exit('没有权限');
}

if ($_GET) {
	$name = trim($_GET['restaurant_name']);
	$delivery = floatval($_GET['delivery_changes']);
	$phone = trim($_GET['phone']);
	if ($name == '') {
		echo "You have not entered all the required details.<br />Please go back and try again.";
		exit;
	}
	if (!get_magic_quotes_gpc()) {
		$name = addslashes($name);
	}
	$sql = "SELECT COUNT(*) FROM restaurant WHERE `r_name`='$name'";
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	if ($row['COUNT(*)'] > 0) exit('该餐厅名已存在');
	unset($result);
	$sql = "INSERT INTO restaurant(`r_name`,`delivery_charges`,`phone`) VALUES('$name','$delivery','$phone')";
	$row_affected = $db->query($sql);
	if ($row_affected == 0) exit('操作失败');
}
$sql = "SELECT * FROM restaurant";
$result = $db->query($sql);
mysqli_close($db);
$restaurant = array();
while($row = $result->fetch_assoc()) {
	$restaurant[] = $row;
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>菜单管理</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
</head>
<body>
<div class="restaurant-div">
	<table border="1">
		<tr>
			<th>餐厅名</th>
			<th>外卖费</th>
			<th>电话</th>
			<th>操作</th>
		</tr>
		<?php foreach ($restaurant as $row): ?>
		<tr>
			<td><a href="editrestaurant.php?rid=<?php echo $row['rid']; ?>" rid="<?php echo $row['rid']; ?>"><?php echo $row['r_name']; ?></a></td>
			<td>￥<?php echo number_format($row['delivery_charges'], 2, '.', ''); ?></td>
			<td><?php echo $row['phone']; ?></td>
			<td><a href="delr.php?restaurant=<?php echo $row['rid']; ?>" class="del-restaurant" rid="<?php echo $row['rid']; ?>">删除</a></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<br /><hr /><br />
	<form action="" method="get">
		<table>
			<tr>
				<td>新增：</td>
				<td><input type="text" name="restaurant_name" /></td>
			</tr>
			<tr>
				<td>电话：</td>
				<td><input type="text" name="phone" /></td>
			</tr>
			<tr>
				<td>外卖费：</td>
				<td><input type="text" name="delivery_changes" value="0" /></td>
			</tr>
			<tr><td colspan="2"><input type="submit" value="保 存" style="width: 100%;" /></td></tr>
		</table>
	</form>
</div>
<div id="category">
</div>
</body>
</html>