<?php 
include 'config.php';
include 'db.php';
if ($_POST) {
	$cid = $_POST['cid'];
	$menuId = $_POST['menuId'];
	$mName = $_POST['mName'];
	$mPrice = $_POST['mPrice'];
	$mNote = $_POST['mNote'];
	$sql = "UPDATE menu SET m_name='$mName',m_price='$mPrice',m_note='$mNote' WHERE menu_id='$menuId'";
	$result = $db->query($sql);
	header('location: getmenus.php?cid=' . $cid);
}
$menu_id = $_GET['menuid'];
$sql = "SELECT menu.*,category.cid,category.c_name,restaurant.r_name
				FROM menu,category,restaurant
				WHERE menu_id='$menu_id' AND menu.cat_id=category.cid AND menu.restaurant_id=restaurant.rid";
$result = $db->query($sql);
$menu = $result->fetch_assoc();
mysqli_close($db);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>编辑菜单</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
<h3>编辑菜单</h3>
<div>
	<?php echo $menu['r_name']; ?> --> <?php echo $menu['c_name']; ?>
</div>
<form method="post" action="editmenu.php">
<input type="hidden" name="cid" value="<?php echo $menu['cid']; ?>" />
<input type="hidden" name="menuId" value="<?php echo $menu['menu_id']; ?>" />
名称：<input type="text" name="mName" value="<?php echo $menu['m_name']; ?>" /><br />
单价：<input type="text" name="mPrice" value="<?php echo $menu['m_price']; ?>" /><br />
说明：<input type="text" name="mNote" value="<?php echo $menu['m_note']; ?>" /><br />
<input type="submit" value="保存" />
</form>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
</body>
</html>