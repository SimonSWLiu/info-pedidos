<?php 
include 'config.php';
include 'db.php';

if ($_POST) {
	if ($_POST['step'] == 4) {
		$menuArr = (array)$_POST['selectMenu']; // 获取提交的菜式
		
		$listStr = isset($_COOKIE['pedidos'])? $_COOKIE['pedidos'] : ''; // cookie中已点菜单
		
		$listArr = array();
		$munus = array();
		$listArr = explode(';', $listStr);
		array_pop($listArr);
		
		foreach ($listArr as $row) { // 将已点菜单字符串分解成数组
			$rows = explode(':', $row);
			$menus[]['menu_id'] = $rows[0];
			$menus[]['menu_count'] = $rows[1];
		}
		
		
		$arrCount = $count = count($menus);
		foreach ($menuArr as $row) {
			$tag = 0;
			for ($i = 0; $i < $arrCount; $i++) {
				if ($row == $menus[$i]['menu_id']) {
					$menus[$i]['menu_count'] += 1;
					$i = $arrCount;
					$tag = 1;
				}
			}
			if ($tag == 0) {
				$menus[]['menu_id'] = $row;
				$menus[]['menu_count'] = 1;
			}
		}
		
		$pedios = '';
		foreach ($menus as $row) {
			$pedidos .= $row['menu_id'] . ':' . $row['menu_count'] . ';';
		}
		
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