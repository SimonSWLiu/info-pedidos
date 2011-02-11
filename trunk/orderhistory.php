<?php
include 'config.php';
include 'db.php';
$mid = $_SESSION['login']['mid'];
$sql = "SELECT * FROM pedidos_log WHERE mid='$mid' ORDER BY log_id";
$result = mysqli_query($db, $sql);
$logArr = array();
while($row = mysqli_fetch_assoc($result)) $logArr[] = $row;
unset($row);
mysqli_free_result($result);
mysqli_close($db);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的点餐历史</title>
</head>

<body>
<table>
	<tr>
		<th>时间</th>
		<th>餐厅</th>
		<th>类别</th>
		<th>菜式</th>
		<th>单价</th>
		<th>数量</th>
		<th>总价</th>
		<th>备注</th>
		<th>状态</th>
	</tr>
	<?php foreach ($logArr as $row): ?>
	<tr>
		<td><?php echo "{$row['year']}-{$row['month']}-{$row['day']} {$row['hour']}:{$row['minute']}"; ?></td>
		<td><?php echo $row['r_name']; ?></td>
		<td><?php echo $row['c_name']; ?></td>
		<td><?php echo $row['dish_name']; ?></td>
		<td><?php echo $row['unit_price']; ?></td>
		<td><?php echo $row['dish_count']; ?></td>
		<td><?php echo $row['total_price']; ?></td>
		<td><?php echo $row['note']; ?></td>
		<td><?php echo $row['status']; ?></td>
	</tr>
	<?php endforeach; ?>
</table>
</body>
</html>