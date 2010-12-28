<?php
// 菜单管理页面
include 'config.php';
include 'db.php';
if ($_GET) {
	$name = $_GET['restaurant_name'];
	$sql = "INSERT INTO restaurant(`r_name`) VALUES('$name')";
	$db->query($sql);
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
			<th>操作</th>
		</tr>
		<?php foreach ($restaurant as $row): ?>
		<tr>
			<td><a href="editrestaurant.php?rid=<?php echo $row['rid']; ?>" rid="<?php echo $row['rid']; ?>"><?php echo $row['r_name']; ?></a></td>
			<td><a href="#" class="del-restaurant" rid="<?php echo $row['rid']; ?>">删除</a></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<form action="" method="get">新增 : <input type="text" name="restaurant_name" /><input type="submit" value="保存" /></form>
</div>
<div id="category">
</div>
</body>
</html>