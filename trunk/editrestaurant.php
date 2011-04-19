<?php
// 编辑餐馆信息
include 'config.php';
include 'db.php';
permission(2);
if ($_POST) {
	$rName = $_POST['rName'];
	$rId = $_POST['rId'];
	$delivery = floatval($_POST['delivery']);
	$sql = "UPDATE restaurant SET r_name='$rName',delivery_charges='$delivery' WHERE rid='$rId'";
	$db->query($sql);
}
$rid = $_GET['rid'];
$sql = "SELECT * FROM restaurant WHERE `rid`='$rid'";
$result = $db->query($sql);
$r_arr = $result->fetch_assoc(); // 指定餐馆的数据
$sql = "SELECT * FROM category WHERE rid='$rid'";
$cat_result = $db->query($sql);
$cat_arr = array();
while ($row = $cat_result->fetch_assoc()) {
	$cat_arr[] = $row;
}
mysqli_close($db);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>编辑餐馆</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
<div>
	<form action="" method="post" name="editrName">
		<input type="hidden" name="rId" value="<?php echo $r_arr['rid']; ?>" />
		<label for="rName">餐馆：</label><input type="text" name="rName" value="<?php echo $r_arr['r_name']; ?>" /><br />
		外卖费: <input type="text" name="delivery" value="<?php echo $r_arr['delivery_charges']; ?>" /><br />
		<input type="submit" value="保存" />
	</form>
</div>
<div id="category">
	<table border="1">
		<tr>
			<th>分类</th>
			<th>操作</th>
		</tr>
	<?php foreach ($cat_arr as $row): ?>
		<tr>
			<td><a href="getmenus.php?cid=<?php echo $row['cid']; ?>"><?php echo $row['c_name']; ?></a></td>
			<td><a href="delcat.php?cid=<?php echo $row['cid']; ?>">删除</a></td>
		</tr>
	<?php endforeach; ?>
	</table>
</div>
<form action="addcategory.php" method="get">
	新增分类 : <input type="text" name="category_name" />
	<input type="hidden" name="rid" value="<?php echo $rid; ?>" />
	<input type="submit" value="保存" />
</form>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
</body>
</html>