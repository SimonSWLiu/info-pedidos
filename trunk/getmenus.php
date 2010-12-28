<?php
include 'config.php';
include 'db.php';
if ($_GET) {
	$cid = $_GET['cid'];
	$sql = "SELECT c_name,r_name FROM restaurant,category WHERE category.rid=restaurant.rid AND cid='$cid'";
	$result = $db->query($sql);
	$detail = $result->fetch_assoc();
	$rName = $detail['r_name'];
	$catName = $detail['c_name'];
	unset($result);
	$sql = "SELECT * FROM menu WHERE cat_id='$cid'";
	$result = $db->query($sql);
	$menus = array();
	while ($row = $result->fetch_assoc()) {
		$menus[] = $row;
	}
	mysqli_close($db);
} elseif ($_POST) {
	$mName = $_POST['mName'];
	$mPrice = $_POST['mPrice'];
	$mNote = $_POST['mNote'];
	$catId = $_POST['catId'];
	$sql = "INSERT INTO menu(m_name,m_price,m_note,cat_id) VALUE('$mName','$mPrice','$mNote','$catId')";
	echo $sql;
	exit;
	$result = $db->query($sql);
	mysqli_close($db);
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>菜单</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
<div><?php echo $rName; ?> --> <?php echo $catName; ?></div>
<div>
	<table border="1">
		<?php foreach ($menus as $row): ?>
		<tr>
			<td><?php echo $row['m_name']; ?></td>
			<td><?php echo $row['m_price']; ?></td>
			<td><?php echo $row['m_note']; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>
<div>新增</div>
<form action="addmenu.php" method="post">
	<input type="hidden" name="catId" value="<?php echo $cid; ?>" />
	<label for="mName">菜式名称：</label><input type="text" name="mName" />
	<label for="mName">菜式价钱：</label><input type="text" name="mPrice" />
	<label for="mName">菜式介绍：</label><input type="text" name="mNote" />
	<input type="submit" value="Save" />
</form>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
</body>
</html>