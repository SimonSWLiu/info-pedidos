<?php
include 'config.php';
include 'db.php';

if ($_POST) {
	
	$menuId = $_POST ['menu_id'];
	$listStr = isset ( $_COOKIE ['pedidos'] ) ? $_COOKIE ['pedidos'] : ''; // cookie中已点菜单
	
	$listArr = array ();
	$menus = array ();
	$listArr = explode ( ';', $listStr );
	array_pop ( $listArr );
	
	foreach ( $listArr as $row ) { // 将已点菜单字符串分解成数组
		$rows = explode ( ':', $row );
		$menu ['menu_id'] = $rows [0];
		$menu ['menu_count'] = $rows [1];
		$menus [] = $menu;
	}
	
	$arrCount = $count = count ( $menus );
	$tag = 0;
	for($i = 0; $i < $arrCount; $i ++) {
		if ($menuId == $menus [$i] ['menu_id']) {
			$menus [$i] ['menu_count'] += 1;
			$i = $arrCount;
			$tag = 1;
		}
	}
	if ($tag == 0) {
		$menu ['menu_id'] = $menuId;
		$menu ['menu_count'] = 1;
		$menus [] = $menu;
	}
	
	$pedidos = '';
	foreach ( $menus as $row ) {
		$pedidos .= $row ['menu_id'] . ':' . $row ['menu_count'] . ';';
	}
	setcookie ( 'pedidos', $pedidos, time () + 41400 );
	exit ( '<script>parent.location.href="pedidos.php"</script>' );
	
	
	
	
	
//	if ($_POST ['step'] == 4) {
//		$menuArr = ( array ) $_POST ['selectMenu']; // 获取提交的菜式
//		
//
//		$listStr = isset ( $_COOKIE ['pedidos'] ) ? $_COOKIE ['pedidos'] : ''; // cookie中已点菜单
//		
//
//		$listArr = array ();
//		$menus = array ();
//		$listArr = explode ( ';', $listStr );
//		array_pop ( $listArr );
//		
//		foreach ( $listArr as $row ) { // 将已点菜单字符串分解成数组
//			$rows = explode ( ':', $row );
//			$menu ['menu_id'] = $rows [0];
//			$menu ['menu_count'] = $rows [1];
//			$menus [] = $menu;
//		}
//		
//		$arrCount = $count = count ( $menus );
//		foreach ( $menuArr as $row ) {
//			$tag = 0;
//			for($i = 0; $i < $arrCount; $i ++) {
//				if ($row == $menus [$i] ['menu_id']) {
//					$menus [$i] ['menu_count'] += 1;
//					$i = $arrCount;
//					$tag = 1;
//				}
//			}
//			if ($tag == 0) {
//				$menu ['menu_id'] = $row;
//				$menu ['menu_count'] = 1;
//				$menus [] = $menu;
//			}
//		}
//		
//		$pedidos = '';
//		foreach ( $menus as $row ) {
//			$pedidos .= $row ['menu_id'] . ':' . $row ['menu_count'] . ';';
//		}
//		
//		setcookie ( 'pedidos', $pedidos, time () + 41400, '/' );
//		exit ( '<script>parent.location.href="/pedidos.php"</script>' );
//	}

}

$sql = "SELECT * FROM restaurant";
$result = $db->query ( $sql );
while ( ($row = $result->fetch_assoc ()) == true ) {
	$rest [$row ['rid']] = $row ['r_name'];
}

$sql1 = "SELECT * FROM category";
$result1 = mysqli_query ( $db, $sql1 );
while ( $row = mysqli_fetch_assoc ( $result1 ) ) {
	$category [$row ['cid']] = array ('c_name' => $row ['c_name'], 'rid' => $row ['rid'] );
}

$sql2 = "SELECT * FROM menu";
$result2 = mysqli_query ( $db, $sql2 );
while ( $row = mysqli_fetch_assoc ( $result2 ) ) {
	$menus [$row ['menu_id']] = array ('m_name' => $row ['m_name'], 'm_price' => $row ['m_price'], 'm_note' => $row ['m_note'], 'cat_id' => $row ['cat_id'], 'restaurant_id' => $row ['restaurant_id'] );
}

$sql = 'SELECT * FROM notice WHERE notice_status=1 ORDER BY notice_date DESC LIMIT 0,1';
$result = mysqli_query($db, $sql);
$notice_arr = mysqli_fetch_assoc($result);
$notice_content = $notice_arr['notice_content'];
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>点餐</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
	<?php if ($notice_content) echo '<div class="notice">'.nl2br($notice_content).'</div>'; ?>
	<div>
	<table border="1" style="border-collapse: collapse; width: 700px; border-color: #D2E8FF;">
		<?php foreach ( $rest as $key => $row ) : ?>
		<tr class="t-title">
			<th colspan="4"><?php echo $row; ?></th>
		</tr>
		<?php	foreach ( $category as $catKey => $cat ) :
		if ($key == $cat ['rid']) : ?>
		<tr class="t-title">
			<th colspan="4"><?php	echo $cat ['c_name'];	?></th>
		</tr>
		<tr class="t-title">
			<th>菜名</th>
			<th>单价</th>
			<th>说明</th>
			<th>操作</th>
		</tr>
		<?php foreach ( $menus as $mKey => $mArr ) :
		if ($catKey == $mArr ['cat_id']) : ?>
		<tr>
			<td><?php echo $mArr ['m_name']; ?></td>
			<td><?php echo '￥' . number_format($mArr ['m_price'], 2, '.', ','); ?></td>
			<td><?php echo $mArr ['m_note']; ?></td>
			<td><form action="menu.php" method="post"><input type="hidden" name="menu_id" value="<?php echo $mKey; ?>" /><input type="submit" value="提交" /></td></form>
		</tr>
		<?php endif;
					endforeach;
				endif;
			endforeach;
		endforeach; ?>
	</table>
	</div>
	
	<?php
	//	switch ($_GET['step']) {
	//		case '1':
	//			include 'step1.php';
	//			break;
	//		case '2':
	//			include 'step2.php';
	//			break;
	//		case '3':
	//			include 'step3.php';
	//			break;
	//		case '4':
	//			include 'stpe4.php';
	//			break;
	//	}
	?>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/global.js"></script>
</body>
</html>
<?php
mysqli_close ( $db );
?>