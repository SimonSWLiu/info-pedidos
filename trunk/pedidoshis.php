<?php
include 'config.php';
include 'db.php';
permission(2);

$sql = "SELECT * FROM pedidos_log LEFT OUTER JOIN members ON pedidos_log.mid=members.mid WHERE pedidos_log.status=1 ORDER BY log_id DESC";
$result = mysqli_query($db, $sql);
$arr = array();
while ($row = mysqli_fetch_assoc($result)) {
	$arr[] = $row;
}
mysqli_close($db);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>点餐历史</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
	<table border="1">
		<tr>
			<th>用户</th>
			<th>餐单</th>
			<th>金额</th>
			<th>时间</th>
			<th>备注</th>
		</tr>
		<?php foreach ($arr as $row): ?>
		<tr>
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['dish_name']; ?></td>
			<td><?php echo '￥' . number_format($row['total_price'], 2, '.', ','); ?></td>
			<td><?php echo $row['year'] . '-' . $row['month'] . '-' . $row['day']; ?></td>
			<td><?php echo $row['note']; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/global.js"></script>
</body>
</html>