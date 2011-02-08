<?php
include 'config.php';
include 'db.php';
$today = time() % 86400;
$halfEleven = $today + 41400;
//$sql = "SELECT * FROM pedidos_log WHERE edit_time>$today AND edit_time<$halfEleven";
$sql = "SELECT * FROM pedidos_log WHERE edit_time>$today";
$result = $db->query($sql);
$logArr = array();
while($row = $result->fetch_assoc()) {
	// 逐行数据处理
	$logArr[] = $row;
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>会员管理</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
	<table style="text-align: left;" border="1">
		<tr>
			<th><label><input type="checkbox" name="allLogs" />全选</label></th>
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
			<td><?php echo $row['r_name']; ?></td>
			<td><?php echo $row['c_name']; ?></td>
			<td><?php echo $row['dish_name']; ?></td>
			<td><?php echo $row['unit_price']; ?></td>
			<td><?php echo $row['dish_count']; ?></td>
			<td><?php echo $row['total_price']; ?></td>
			<td><?php echo $row['status']; ?></td>
		</tr>
		<?php endforeach; ?>
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
//	alert(logsStr);
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