<?php
include 'config.php';
include 'db.php';
permission(2);
$sql = "SELECT * FROM log LEFT OUTER JOIN members ON log.mid=members.mid ORDER BY edit_time DESC";
$result = mysqli_query($db, $sql);
$detailArr = array();
while($row = mysqli_fetch_assoc($result)) {
	$date = date("Y-m-d H:i:s", $row['edit_time']);
	$detailArr[] = array('memberName'=>$row['name'], 'operate'=>$row['operate'], 'money'=>$row['money'], 'time'=>$date, 'note'=>$row['note']);
}
mysqli_close($db);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>交易明细</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
	<table border="1">
		<tr>
			<th>用户</th>
			<th>操作</th>
			<th>金额</th>
			<th>时间</th>
			<th>备注</th>
		</tr>
		<?php foreach ($detailArr as $row): ?>
		<tr>
			<td><?php echo $row['memberName']; ?></td>
			<td><?php echo $row['operate']; ?></td>
			<td><?php echo $row['money']; ?></td>
			<td><?php echo $row['time']; ?></td>
			<td><?php echo $row['note']; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/global.js"></script>
</body>
</html>