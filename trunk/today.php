<?php
// 今日点餐
include 'config.php';
include 'db.php';
$myId = $_SESSION['login']['mid'];
$dateArr = getdate();
$year = $dateArr['year'];
$mon = $dateArr['mon'];
$day = $dateArr['mday'];
$sql = "SELECT * FROM pedidos_log WHERE mid='$myId' AND year='$year' AND month='$mon' AND day='$day'";
$result = mysqli_query($db, $sql);
$menuArr = array();
while ($row = mysqli_fetch_assoc($result)) $menuArr[] = $row;
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>今日点餐</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
	<table border="1">
		<tr>
			<th>餐厅</th>
			<th>类别</th>
			<th>菜式</th>
			<th>下单时间</th>
			<th>单价</th>
			<th>数量</th>
			<th>总价</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
		<?php foreach ($menuArr as $row): ?>
		<tr>
			<td><?php echo $row['r_name']; ?></td>
			<td><?php echo $row['c_name']; ?></td>
			<td><?php echo $row['dish_name']; ?></td>
			<td><?php echo date("Y-m-d H:i:s", $row['edit_time']); ?></td>
			<td><?php echo $row['unit_price']; ?></td>
			<td><?php echo $row['dish_count']; ?></td>
			<td><?php echo $row['total_price']; ?></td>
			<td>
			<?php switch ($row['status']) {
				case '0':
					echo '未下单';
					break;
				case '1':
					echo '下单成功';
					break;
			}?>
			</td>
			<td>
			<?php if ($row['status'] == 0): ?>
				<a href="cancelorder.php?pid=<?php echo $row['log_id']; ?>">取消</a>
			<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</body>
</html>