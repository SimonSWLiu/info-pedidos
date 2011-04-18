<?php
include 'config.php';
include 'db.php';
if ($_GET) {
	$lid = trim($_GET['lid']);
	$lid = intval($lid);
	$result = mysqli_query($db, "SELECT * FROM pedidos_log WHERE log_id='$lid'");
	$logRow = mysqli_fetch_assoc($result);
} elseif ($_POST) {
	$unitPrice = floatval($_POST['unit_price']);
	$dishCount = intval($_POST['dish_count']);
	$totalPrice = floatval($_POST['total_price']);
	$note = strip_tags(trim($_POST['note']));
	$lid = intval(trim($_POST['lid']));
	$sql = "SELECT * FROM pedidos_log WHERE log_id='$lid'";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_assoc($result); // 原总价
	$total_price = $row['total_price'];
	$mid = $row['mid'];
	
	$different = $totalPrice - $total_price; // 总价修改前后差
	
	$sql = "UPDATE pedidos_log
					SET `unit_price`='$unitPrice',`dish_count`='$dishCount',`total_price`='$totalPrice',`note`='$note'
					WHERE log_id='$lid'";
	mysqli_query($db, $sql);
	$affectedRow = mysqli_affected_rows($db);
	if ($affectedRow == 1) {
		// 更新日志成功，修改用户的余额
		$update = "UPDATE members SET balance=balance-'$different' WHERE mid='$mid'";
		mysqli_query($db, $update);
		$affectedRows = mysqli_affected_rows($db);
		if ($affectedRows == 1) {
			header('location: pmanage.php');
			exit;
		}
	} else {
		exit('操作失败');
	}
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>会员管理</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
	<form action="editlog.php" method="post">
		<table>
			<tr>
				<th>订餐人</th>
				<th>餐厅</th>
				<th>菜色类别</th>
				<th>菜名</th>
				<th>单价</th>
				<th>数量</th>
				<th>总价</th>
				<th>备注</th>
			</tr>
			<tr>
				<td><?php echo $logRow['mid']; ?></td>
				<td><?php echo $logRow['r_name']?></td>
				<td><?php echo $logRow['c_name']?></td>
				<td><?php echo $logRow['dish_name']?></td>
				<td><input type="text" name="unit_price" value="<?php echo $logRow['unit_price']?>" /></td>
				<td><input type="text" name="dish_count" value="<?php echo $logRow['dish_count']?>" /></td>
				<td><input type="text" name="total_price" value="<?php echo $logRow['total_price']?>" /></td>
				<td><input type="text" name="note" value="<?php echo $logRow['note']; ?>" /></td>
			</tr>
		</table>
		<input type="hidden" name="lid" value="<?php echo $logRow['log_id']; ?>" />
		<input type="submit" value="Save" />
	</form>
	<script type="text/javascript" src="scripts/jquery.js"></script>
</body>
</html>