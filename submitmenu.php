<?php
include 'config.php';
include 'db.php';
$menuCookie = isset($_COOKIE['pedidos'])? $_COOKIE['pedidos'] : '';
if ($menuCookie == '') {
	header('location: ' . $_SERVER['HTTP_REFERER']);
	exit;
}
if ($_POST) {
	$mid = $_SESSION['login']['mid'];
	$menusArr = explode(';', $menuCookie);
	array_pop($menusArr);
	foreach ($menusArr as $row) {
		$menuArr = explode(':', $row);
		$menuId = $menuArr[0];
		$menuCount = $menuArr[1];
		$sql = "SELECT * FROM menu,restaurant,category WHERE menu_id='$menuId' AND cat_id=cid AND restaurant_id=restaurant.rid";
		$result = $db->query($sql);
		
		$dateArr = getdate();
		$year = $dateArr['year'];
		$month = $dateArr['mon'];
		$day = $dateArr['mday'];
		$hour = $dateArr['hours'];
		$minute = $dateArr['minutes'];
		while($menuRow = $result->fetch_assoc()) {
			$editTime = time();
			$total = $menuCount * $menuRow['m_price'];
			$sql = "INSERT INTO pedidos_log(mid,edit_time,year,month,day,hour,minute,rid,r_name,cid,c_name,menu_id,dish_name,unit_price,dish_count,total_price,note,status)
							VALUES('$mid','$editTime','$year','$month','$day','$hour','$minute','{$menuRow['rid']}','{$menuRow['r_name']}','{$menuRow['cid']}','{$menuRow['c_name']}','{$menuRow['menu_id']}','{$menuRow['m_name']}','{$menuRow['m_price']}','$menuCount','$total','',0)";
			$insertResult = $db->query($sql);
			$affected_row = mysqli_affected_rows($db);
			if ($affected_row == 1) {
				$totalPrice = $menuCount * $menuRow['m_price'];
				$sql = "UPDATE members SET balance=balance-$totalPrice,ordering_count=ordering_count+1,delivery_ratio=delivery_count/ordering_count WHERE mid='$mid'";
				mysqli_query($db, $sql);
				$affected_num = mysqli_affected_rows($db);
				$update = "UPDATE members SET delivery_ratio=delivery_count/ordering_count WHERE mid='$mid'";
				mysqli_query($db, $update);
			}
		}
	}
	setcookie('pedidos','',0); // 清空cookie
	header('location: ' . $_SERVER['HTTP_REFERER']);
}
?>