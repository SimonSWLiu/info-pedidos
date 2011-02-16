<?php
include 'config.php';
include 'db.php';
if ($_GET) {
	$lid = trim($_GET['lid']);
	$lid = intval($lid);
	$result = mysqli_query($db, "SELECT * FROM pedidos_log WHERE log_id='$lid'");
	$logRow = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>会员管理</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
	<form action="" method="post">
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
			<?php foreach($logRow as $row): ?>
			<tr>
				<td><?php echo $row['mid']; ?></td>
				<td><?php echo $row['r_name']?></td>
				<td><?php echo $row['c_name']?></td>
				<td><?php echo $row['dish_name']?></td>
				<td><?php echo $row['unit_price']?></td>
				<td><?php echo $row['dish_count']?></td>
				<td><?php echo $row['total_price']?></td>
				<td><?php echo $row['note']; ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</form>
	<script type="text/javascript" src="/scripts/jquery.js"></script>
</body>
</html>