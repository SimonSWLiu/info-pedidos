<?php
include 'config.php';
include 'db.php';

$sql = "SELECT * FROM restaurant";
$result = mysqli_query($db, $sql);
$restaurant = array();
while($row = mysqli_fetch_assoc($result)) {
	$restaurant[] = $row;
}

$dateArr = getdate();
$todayYear = $dateArr['year'];
$todayMonth = $dateArr['mon'];
$todayDay = $dateArr['mday'];
$sql = "SELECT pedidos_log.*,members.name
				FROM pedidos_log,members
				WHERE pedidos_log.mid=members.mid AND year='$todayYear' AND month='$todayMonth' AND day='$todayDay' AND (hour<11 OR (hour=11 AND minute<30))";
$sql2 = "SELECT DISTINCT rid
				 FROM pedidos_log
				 WHERE year='$todayYear' AND month='$todayMonth' AND day='$todayDay' AND (hour<11 OR (hour=11 AND minute<30))";
if ($_GET) {
	$rid = addslashes($_GET['rid']);
	$sql .= " AND rid='$rid'";
	$sql2 .= " AND rid='$rid'";
}
$result = $db->query($sql);
$logArr = array();
$totalCount = 0;
$totalPrice = 0;
while($row = $result->fetch_assoc()) {
	// 逐行数据处理
	$logArr[] = $row;
	$totalCount += $row['dish_count'];
	$totalPrice += $row['total_price'];
}
mysqli_free_result($result);

$result = mysqli_query($db, $sql2);
$deliveryCharges = 0;
while($row = mysqli_fetch_assoc($result)) {
	$sql = "SELECT delivery_charges FROM restaurant WHERE rid='{$row['rid']}'";
	$result2 = mysqli_query($db, $sql);
	$row2 = mysqli_fetch_assoc($result2);
	$deliveryCharges += $row2['delivery_charges'];
}
$totalPrice += $deliveryCharges;
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>会员管理</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
<style type="text/css">
.r_filter li { float: left; }
</style>
</head>
<body>
	<ul class="r_filter">
		<li><a href="pmanage.php">全部</a></li>
		<?php foreach ($restaurant as $row): ?>
		<li><a href="?rid=<?php echo $row['rid']; ?>"><?php echo $row['r_name']; ?></a></li>
		<?php endforeach; ?>
	</ul>
	<table style="text-align: left; clear: both;" border="1">
		<tr>
			<th><label><input type="checkbox" name="allLogs" />全选</label></th>
			<th>点餐人</th>
			<th>餐厅</th>
			<th>类别</th>
			<th>菜名</th>
			<th>单价</th>
			<th>数量</th>
			<th>总价</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
		<?php foreach ($logArr as $row): ?>
		<tr>
			<td><input type="checkbox" name="selectLog" value="<?php echo $row['log_id']; ?>" /></td>
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['r_name']; ?></td>
			<td><?php echo $row['c_name']; ?></td>
			<td><?php echo $row['dish_name']; ?></td>
			<td><?php echo $row['unit_price']; ?></td>
			<td><?php echo $row['dish_count']; ?></td>
			<td><?php echo $row['total_price']; ?></td>
			<td>
			<?php
				switch ($row['status']) {
					case '0':
						echo '未审核';
						break;
					case '1':
						echo '通过';
						break;
					case '2':
						echo '不通过';
						break;
				} 
			?>
			</td>
			
			<td><a href="editlog.php?lid=<?php echo $row['log_id']; ?>">修改</a> <a href="delorder.php?lid=<?php echo $row['log_id']; ?>">删除</a></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td>总数量：</td>
			<td><?php echo $totalCount; ?></td>
			<td>外卖费：</td>
			<td><?php echo $deliveryCharges; ?></td>
			<td>总价：</td>
			<td colspan="3">￥<?php echo number_format($totalPrice, 2, '.', ','); ?></td>
		</tr>
	</table>
	<input type="button" value="通过" onClick="selectLogs();" />
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
<script type="text/javascript">
function selectLogs() {
	var logs = document.getElementsByName('selectLog');
	var logsStr = '';
	for (var i = 0; i < logs.length; i++) {
		if (logs[i].checked == true) {
			logsStr += logs[i].value + ';';
		}
	}
	$.get('/allmenuspass.php', {
		logs: logsStr
	}, function(data) {
		if (data == '1') {
			window.location.href = 'pmanage.php';
		}
	});
}
</script>
</body>
</html>