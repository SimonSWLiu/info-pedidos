<?php
include 'config.php';
include 'db.php';

if ($_POST) {
	if ($_POST['delivery_charge'] == '' || $_POST['delivery_user_id'] == '') {
		exit('参数错误');
	}
	// 今日点外卖的用户全部ordering_count 都加一
	$dateArr = getdate();
	$todayYear = $dateArr['year'];
	$todayMonth = $dateArr['mon'];
	$todayDay = $dateArr['mday'];
	
	$updatePedidos = "UPDATE pedidos_log SET status='1' WHERE year='$todayYear' AND month='$todayMonth' AND day='$todayDay'";
	mysqli_query($db, $updatePedidos);
	
	$sql = "SELECT DISTINCT(mid) FROM pedidos_log WHERE year='$todayYear' AND month='$todayMonth' AND day='$todayDay'";
	$result = mysqli_query($db, $sql);
	while ($row = mysqli_fetch_assoc($result)) {
		$mid = addslashes($row['mid']);
		$update = "UPDATE members SET ordering_count=ordering_count+1 WHERE mid='$mid'";
		mysqli_query($db, $update);
	}
	
	$deliveryCharge = floatval($_POST['delivery_charge']);
	$deliveryUserId = intval($_POST['delivery_user_id']);
	// 修改余额
	$sql = "UPDATE members SET balance=balance-'$deliveryCharge',delivery_count=delivery_count+1 WHERE mid='$deliveryUserId'";
	mysqli_query($db, $sql);
	$affected_rows = mysqli_affected_rows($db);
	if ($affected_rows == 1) {
		$sql = "UPDATE members SET delivery_ratio=delivery_count/ordering_count WHERE mid='$deliveryUserId'";
		mysqli_query($db, $sql);
		$affected_rows2 = mysqli_affected_rows($db);
		if ($affected_rows2 == 1) {
			// 写入日志
			$time = time();
			$sql = "INSERT INTO pedidos_log(mid,edit_time,year,month,day,hour,minute,rid,r_name,cid,c_name,menu_id,dish_name,unit_price,dish_count,total_price,note,status,type_tag)
							VALUES('$deliveryUserId','$time','$todayYear','$todayMonth','$todayDay','{$dateArr['hours']}','{$dateArr['minutes']}',0,'',0,'',0,'',0,0,'$deliveryCharge','外卖费',1,1)";
			mysqli_query($db, $sql);
//			$insert_row = mysqli_affected_rows($db);
		}
	}
	header('location: pmanage.php');
}
mysqli_close($db);