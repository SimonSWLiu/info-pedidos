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
$sql = "SELECT *,members.name FROM pedidos_log,members WHERE pedidos_log.mid=members.mid AND year='$todayYear' AND month='$todayMonth' AND day='$todayDay' AND (hour<11 OR (hour=11 AND minute<30))";
$sql2 = "SELECT DISTINCT rid FROM pedidos_log WHERE year='$todayYear' AND month='$todayMonth' AND day='$todayDay' AND (hour<11 OR (hour=11 AND minute<30))";
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
print_r($rid);

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
echo '<br />';
print_r($restaurant_count);

for($i = 0; $i < count($restaurant_count); $i++) {
	$rid = $row['rid'];
	$sql = "SELECT delivery_charges FROM restaurant WHERE rid='$rid'";
	$result = mysqli_query($db, $sql);
	$charge_row = mysqli_fetch_assoc($result);
	$charge = $charge_row['delivery_charges'];
	$averageCharge = (float)$charge / $restaurant_count[$i]['count'];
	$averageCharge = ceil($averageCharge * 100) / 100;
	$restaurant_count[$i]['averageCharge'] = $averageCharge;
}

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
			<td><?php echo $row['status']; ?></td>
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
	<input type="button" value="全部通过" onClick="selectLogs();" />
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
<script type="text/javascript">
function selectLogs() {
	var logs = document.getElementsByName('selectLog');
	var logsStr = '';
	for (var i = 0; i < logs.length; i++) {
		logsStr += logs[i].value + ';';
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