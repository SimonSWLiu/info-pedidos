<?php
include 'config.php';
include 'db.php';
if ($_GET) {
	$logsStr = $_GET['logs'];
	$logArr = explode(';', $logsStr);
	array_pop($logArr);
	foreach($logArr as $row) {
		$sql = "SELECT mid,total_price,status FROM pedidos_log WHERE log_id='$row'";
		$result = $db->query($sql);
		$log = $result->fetch_assoc();
		unset($result);
		$mid = $log['mid'];
		$totalPrice = $log['total_price'];
		$status = $log['status'];
		if ($status != 1) {
//			$sql = "UPDATE members SET balance=balance-$totalPrice WHERE mid='$mid'";
//			$result = $db->query($sql);
//			unset($result);
			$sql = "UPDATE pedidos_log SET status='1' WHERE log_id='$row'";
			$result = $db->query($sql);
			unset($result);
		}
	}
	$dateArr = getdate();
	$todayYear = $dateArr['year'];
	$todayMonth = $dateArr['mon'];
	$todayDay = $dateArr['mday'];
	$sql = "SELECT DISTINCT mid FROM pedidos_log WHERE year='$todayYear' AND month='$todayMonth' AND day='$todayDay' AND (hour<11 OR (hour=11 AND minute<30))";
	$result = mysqli_query($db, $sql);
	
	
	
	
	
	
	
// 计算每人的外卖费
$rid = array();
foreach($logArr as $row) { // 遍历今日的点餐日志
	if($rid) {
		for($i = 0; $i < count($rid); $i++) {
			if($rid[$i]['rid'] == $row['rid'] && $rid[$i]['mid'] == $row['mid']) {
				$rid[$i]['count']++;
				break;
			} else {
				$rid[] = array('rid'=>$row['rid'], 'mid'=>$row['mid'], 'count'=>1);
				break;
			}
		}
	} else {
		$rid[] = array('rid'=>$row['rid'], 'mid'=>$row['mid'], 'count'=>1);
	}
}

//$restaurant_log = array();
//for($i = 0; $i < count($rid); $i++) {
//	$rid = $rid[$i]['rid'];
//	$sql = "SELECT delivery_charges FROM restaurant WHERE rid='$rid'";
//	$result = mysqli_query($db, $sql);
//	$charge_row = mysqli_fetch_assoc($result);
//	$rid[$i]['charge'] = $charge_row['delivery_charges']; // 该餐厅的外卖费
//}

$restaurant_count = array(); // 点了指定餐厅的人数
foreach($rid as $row) {
	if($restaurant_count) {
		for($i = 0; $i < count($restaurant_count); $i++) {
			if($row['rid'] == $restaurant_count[$i]['rid']) {
				$restaurant_count[$i]['count']++;
				break;
			} else {
				$restaurant_count[] = array('rid'=>$row['rid'], 'count'=>1);
				break;
			}
		}
	} else {
		$restaurant_count[] = array('rid'=>$row['rid'], 'count'=>1);
	}
}

for($i = 0; $i < count($restaurant_count); $i++) {
	$r_id = $row['rid'];
	$sql = "SELECT delivery_charges FROM restaurant WHERE rid='$r_id'";
	$result = mysqli_query($db, $sql);
	$charge_row = mysqli_fetch_assoc($result);
	$charge = $charge_row['delivery_charges'];
	$averageCharge = (float)$charge / $restaurant_count[$i]['count'];
	$averageCharge = ceil($averageCharge * 100) / 100;
	$restaurant_count[$i]['averageCharge'] = $averageCharge; // 平均每人的外卖费
}
foreach($restaurant_count as $row) {
	foreach($rid as $row2) {
		if($row['rid'] == $row2['rid']) {
			$averageCharge = $row['averageCharge'];
			$mid = $row2['mid'];
			$sql = "UPDATE members SET balance=balance-'$averageCharge' WHERE mid='$mid'";
			$result = mysqli_query($db, $sql);
			$affectedRow = mysqli_affected_rows($db);
			if($affectedRow == 1) {
				$time = time();
				$timeArr = getdate();
				$sql = "SELECT * FROM restaurant WHERE rid='{$row['rid']}'";
				$result = mysqli_query($db, $sql);
				$restaurantRow = mysqli_fetch_assoc($result);
				$rName = $restaurantRow['r_name'];
				$sql = "INSERT INTO pedidos_log(`mid`,`edit_time`,`year`,`month`,`day`,`hour`,`minute`,`rid`,`r_name`,`cid`,`c_name`,`menu_id`,`dish_name`,`unit_price`,`dish_count`,`total_price`,`note`,`status`)
								VALUES('$mid','$time','{$timeArr['year']}','{$timeArr['mon']}','{$timeArr['mday']}','{$timeArr['hours']}','{$timeArr['minutes']}','{$row2['rid']}','$rName','0','','0','','$averageCharge','1','$averageCharge','外卖费','1')";
				echo $sql;
				exit;
				$result = mysqli_query($db, $sql);
				$affectedRow = mysqli_affected_rows($db);
			}
		}
	}
}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	echo '1';
	exit;
}
?>