<?php 
include 'config.php';
include 'db.php';

if ($_POST) {
	if ($_POST['step'] == 4) {
		$menuArr = (array)$_POST['selectMenu'];
		$value = isset($_COOKIE['pedidos'])? json_decode($_COOKIE['pedidos']) : array();
		foreach ($menuArr as $row) {
			$sql = "SELECT menu.*,category.c_name,restaurant.r_name FROM menu,category,restaurant WHERE menu_id='$row' AND menu.cat_id=category.cid AND menu.restaurant_id=restaurant.rid";
			$result = $db->query($sql);
			$menu = $result->fetch_assoc();
			$mid = $_SESSION['login']['mid'];
			$rid = $menu['restaurant_id'];
			$rName = $menu['r_name'];
			$cid = $menu['cat_id'];
			$cName = $menu['c_name'];
			$mName = $menu['m_name'];
			$mPrice = $menu['m_price'];
//			print_r($value);
//			exit;
//			$value[] = array('menu'=>$row, 'count'=>1);
			
			foreach ($value as $row2) {
				if (isset($row2->menu) && ($row2->menu == $row)) {
					$row2->count += 1;
				} else {
					$value[] = array('menu'=>$row, 'count'=>1);
				}
			}
			
//			$sql = "INSERT INTO pedidos_log(`mid`,`edit_time`,`rid`,`r_name`,`cid`,`c_name`,`menu_id`,`dish_name`,`unit_price`,`dish_count`,`total_price`,`note`)
//							VALUES('$mid','{time()}','$rid','$rName','$cid','$cName','$row','$mName','$mPrice','1','$mPrice','')";
		}
		$pedidos = json_encode($value);
		setcookie('pedidos', $pedidos, time() + 41400, '/');
		exit('<script>parent.location.href="/pedidos.php"</script>');
	}
}
$sql = "SELECT * FROM restaurant";
$result = $db->query($sql);
while(($row = $result->fetch_assoc()) == true) {
	$rest[$row['rid']] = $row['r_name'];
}
unset($row);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>点餐</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
<?php
	switch ($_GET['step']) {
		case '1':
			include 'step1.php';
			break;
		case '2':
			include 'step2.php';
			break;
		case '3':
			include 'step3.php';
			break;
		case '4':
			include 'stpe4.php';
			break;
	}
?>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
</body>
</html>
<?php
mysqli_close($db);
?>