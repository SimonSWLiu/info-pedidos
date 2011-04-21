<?php
include 'config.php';
include 'db.php';
permission(2);

if (!isset($_SESSION['login']) || $_SESSION['login']['level'] == 3) {
	exit('没有权限');
}

// 列出所有餐厅（筛选项）
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

// 获取今日的餐单
$sql = "SELECT pedidos_log.*,members.name
				FROM pedidos_log,members
				WHERE pedidos_log.mid=members.mid AND year='$todayYear' AND month='$todayMonth' AND day='$todayDay' AND type_tag=0";

// 找出今天订单中的餐厅id
$sql2 = "SELECT DISTINCT rid
				 FROM pedidos_log
				 WHERE year='$todayYear' AND month='$todayMonth' AND day='$todayDay' AND type_tag=0";

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

//$result = mysqli_query($db, $sql2); // 找出点了餐的餐厅（不重复）
//$deliveryCharges = 0;
//while($row = mysqli_fetch_assoc($result)) {
//	$sql = "SELECT delivery_charges FROM restaurant WHERE rid='{$row['rid']}'";
//	$result2 = mysqli_query($db, $sql);
//	$row2 = mysqli_fetch_assoc($result2);
//	$deliveryCharges += $row2['delivery_charges'];
//}
//$totalPrice += $deliveryCharges;

// 生成以菜名归类的表格
$menuList = array();
$count = array();
if ($logArr) {
	$menuList[0]['r_name'] = $logArr[0]['r_name'];
	$menuList[0]['c_name'] = $logArr[0]['c_name'];
	$menuList[0]['dish_name'] = $logArr[0]['dish_name'];
	$menuList[0]['unit_price'] = $logArr[0]['unit_price'];
	$menuList[0]['dish_count'] = $logArr[0]['dish_count'];
	$menuList[0]['total_price'] = $logArr[0]['total_price'];
	$menuList[0]['menu_id'] = $logArr[0]['menu_id'];
}
for ($j = 1; $j < count($logArr); $j++) {
	$row = $logArr[$j];
	$menuId = $row['menu_id'];
	$tag = 0;
	for ($i = 0; $i < count($menuList); $i++) {
		if ($menuList[$i]['menu_id'] == $menuId) { // 相同的菜式，数量加一
			$menuList[$i]['dish_count'] += $row['dish_count'];
			$menuList[$i]['total_price'] += $row['total_price'];
			$tag = 1;
			break;
		}
	}
	if ($tag == 0)
	$menuList[] = array('r_name'=>$row['r_name'], 'c_name'=>$row['c_name'], 'dish_name'=>$row['dish_name'],
											'unit_price'=>$row['unit_price'], 'dish_count'=>$row['dish_count'], 'total_price'=>$row['total_price'], 'menu_id'=>$menuId);
}
asort($menuList);

// 找出负责本次外卖费的用户
$sql = "SELECT DISTINCT(mid) FROM pedidos_log WHERE year='$todayYear' AND month='$todayMonth' AND day='$todayDay' AND rid='1'";
$result = mysqli_query($db, $sql);
$midStr = '';
while ($row = mysqli_fetch_assoc($result)) {
	$midStr .= $row['mid'] . ',';
}
$strBuf = '';
for ($i = 0; $i < strlen($midStr) - 1; $i++) {
	$strBuf .= $midStr[$i];
}

$sql = "SELECT * FROM members WHERE mid IN($strBuf) ORDER BY delivery_ratio";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
$deliveryUser = $row['name'];
$deliveryId = $row['mid'];



mysqli_close($db);
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
<!--			<th><label><input type="checkbox" name="allLogs" onClick="selectAll(this)" />全选</label></th>-->
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
<!--			<td><input type="checkbox" name="selectLog" value="<?php echo $row['log_id']; ?>" /></td>-->
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
						echo '未订餐';
						break;
					case '1':
						echo '订餐成功';
						break;
					case '2':
						echo '订餐失败';
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
			<!--<td>外卖费：</td>
			<td><?php echo $deliveryCharges; ?></td>
			--><td>总价：</td>
			<td colspan="3">￥<?php echo number_format($totalPrice, 2, '.', ','); ?></td>
		</tr>
	</table>
	<div>
		<form action="delivery.php" method="post">
			<span style="background-color: #FF0;"><?php echo $deliveryUser; ?></span>
			<input type="hidden" name="delivery_user_id" value="<?php echo $deliveryId; ?>" />
			外卖费: <input type="text" name="delivery_charge" value="1" />
			<input type="submit" name="" value="确定" />
		</form>
	</div>
<!--	<input type="button" value="通过" onClick="selectLogs();" />-->
	<div class="menu-list">
		<table style="text-align: left; clear: both;" border="1">
			<tr>
				<th>餐厅</th>
				<th>类别</th>
				<th>菜名</th>
				<th>单价</th>
				<th>数量</th>
				<th>总价</th>
			</tr>
			<?php foreach($menuList as $row): ?>
			<tr>
				<td><?php echo $row['r_name']; ?></td>
				<td><?php echo $row['c_name']; ?></td>
				<td><?php echo $row['dish_name']; ?></td>
				<td><?php echo $row['unit_price']; ?></td>
				<td><?php echo $row['dish_count']; ?></td>
				<td><?php echo $row['total_price']; ?></td>
			</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan="2">总价</td>
				<td colspan="4"><?php echo $totalPrice; ?></td>
			</tr>
		</table>
	</div>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
<script type="text/javascript">
//function selectAll(_this) {
//	var all = _this.checked;
//	var logs = document.getElementsByName('selectLog');
//	for (var i = 0; i < logs.length; i++) {
//		if (all == true) {
//			logs[i].checked = true;
//		} else {
//			logs[i].checked = false;
//		}
//	}
//}
//
//function selectLogs() {
//	var logs = document.getElementsByName('selectLog');
//	var logsStr = '';
//	var tag = 0;
//	for (var i = 0; i < logs.length; i++) {
//		if (logs[i].checked == true) {
//			logsStr += logs[i].value + ';';
//			tag = 1;
//		}
//	}
//	if (tag == 0) { // 一个都没有勾选
//		alert('没有勾选任何菜单.');
//		return false;
//	}
//	window.location.href="allmenuspass.php?logs=" + logsStr;
//}
</script>
</body>
</html>