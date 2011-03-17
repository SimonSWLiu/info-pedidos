<?php
include 'pedidos/config.php';
include 'pedidos/db.php';
if ($_GET) {
	$logsStr = $_GET['logs'];
	$logArr = explode(';', $logsStr);
	array_pop($logArr);
	// 遍历勾选了的菜式
	foreach($logArr as $row) {
		$sql = "SELECT mid,total_price,status FROM pedidos_log WHERE log_id='$row' LIMIT 1"; // 只拿一条记录
		$result = $db->query($sql);
		$log = $result->fetch_assoc();
		$result->free();
		$mid = $log['mid']; // 点餐者的id
		$totalPrice = $log['total_price'];
		$status = $log['status'];
		if ($status != 1) { // 未通过或不通过的情况
			$sql = "UPDATE pedidos_log SET status='1' WHERE log_id='$row'"; // 设为通过
			$affected_row = $db->query($sql);
			if ($affected_row == 1) { // 点餐次数加一
				$sql = "UPDATE members SET ordering_count=ordering_count+1 WHERE mid='$mid'";
				$db->query($sql);
			}
		}
		$sql1 = "SELECT * FROM members WHERE mid='$mid'";
		$result1 = mysqli_query($db, $sql1);
		$deliveryRatio = mysqli_fetch_assoc($result1);
		$memberArr[$mid] = $deliveryRatio; // 获取今天点餐的会员信息
	}
	// 判断今日的点餐谁需要缴付外卖费
	$min = 2;
	$minId = 0;
	foreach ($memberArr as $key=>$row) {
		if ($row['delivery_ratio'] < $min) {
			$min = $row['delivery_ratio'];
			$minId = $key;
		}
	}
	
	// 显示被扣外卖费的用户
	$sql4 = "SELECT * FROM members WHERE mid='$minId'";
	$result4 = mysqli_query($db, $sql4);
	$member = mysqli_fetch_assoc($result4);
	
//	$delivery = 1; // 外卖费一元
//	$sql2 = "UPDATE members
//					 SET delivery_count=delivery_count+1,delivery_ratio=delivery_count/ordering_count,balance=balance-$delivery
//					 WHERE mid='$minId'";
//	$result2 = mysqli_query($db, $sql2);
//	$affected_rows = mysqli_affected_rows($db);
//	if ($affected_rows == 1) {
//		$editTime = time();
//		$dateArr = getdate();
//		$todayYear = $dateArr['year'];
//		$todayMonth = $dateArr['mon'];
//		$todayDay = $dateArr['mday'];
//		$todayHour = $dateArr['hours'];
//		$todayMin = $dateArr['minutes'];
//		$sql3 = "INSERT INTO pedidos_log(`mid`,`edit_time`,`year`,`month`,`day`,`hour`,`minute`,`rid`,
//						 `r_name`,`cid`,`c_name`,`menu_id`,`dish_name`,`unit_price`,`dish_count`,`total_price`,`note`,`status`,`type_tag`)
//						 VALUES('$minId','$editTime','$todayYear','$todayMonth','$todayDay','$todayHour','$todayMin',
//						 '0','0','0','0','0','0','0','0','$delivery','外卖费','1','1')";
//		$result3 = mysqli_query($db, $sql3);
//		if (mysqli_affected_rows($db) == 1) {
//			
//		}
//	}
}

if ($_POST) {
	$mid = $_POST['mid'];
	$delivery = $_POST['delivery'];
	
	$sql2 = "UPDATE members
					 SET delivery_count=delivery_count+1,delivery_ratio=delivery_count/ordering_count,balance=balance-$delivery
					 WHERE mid='$mid'";
	$result2 = mysqli_query($db, $sql2);
	if (mysqli_affected_rows($db) == 1) {
		$editTime = time();
		$dateArr = getdate();
		$todayYear = $dateArr['year'];
		$todayMonth = $dateArr['mon'];
		$todayDay = $dateArr['mday'];
		$todayHour = $dateArr['hours'];
		$todayMin = $dateArr['minutes'];
		$sql = "INSERT INTO pedidos_log(`mid`,`edit_time`,`year`,`month`,`day`,`hour`,`minute`,`rid`,
						`r_name`,`cid`,`c_name`,`menu_id`,`dish_name`,`unit_price`,`dish_count`,`total_price`,`note`,`status`,`type_tag`)
						VALUES('$mid','$editTime','$todayYear','$todayMonth','$todayDay','$todayHour','$todayMin',
						'0','0','0','0','0','0','0','0','$delivery','外卖费','1','1')";
		$result = mysqli_query($db, $sql);
		if (mysqli_affected_rows($db) == 1) {
			exit('操作成功');
		} else {
			exit('外卖费处理失败.');
		}
	}
}

mysqli_close($db);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>点餐管理</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
	<div>
		<h4>负责外卖费的人：</h4>
		<div><?php echo $member['name']; ?></div>
		<form action="/allmenuspass.php" method="post">
			<input type="hidden" name="mid" value="<?php echo $member['mid']; ?>" />
			<input type="text" name="delivery" value="1" />
			<input type="submit" value="提交" />
		</form>
	</div>
</body>
</html>