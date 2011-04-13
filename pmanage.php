<?php
include 'config.php';
include 'db.php';

if (!isset($_SESSION['login']) || $_SESSION['login']['level'] == 3) {
	exit('没有权限');
}

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

$result = mysqli_query($db, $sql2);
$deliveryCharges = 0;
while($row = mysqli_fetch_assoc($result)) {
	$sql = "SELECT delivery_charges FROM restaurant WHERE rid='{$row['rid']}'";
	$result2 = mysqli_query($db, $sql);
	$row2 = mysqli_fetch_assoc($result2);
	$deliveryCharges += $row2['delivery_charges'];
}
$totalPrice += $deliveryCharges;

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

// 找出不重复的今天下订单的会员id
//$sql = "SELECT DISTINCT mid FROM pedidos_log
//				WHERE year='$todayYear' AND month='$todayMonth' AND day='$todayDay' AND (hour<11 OR (hour=11 AND minute<30))";
//$result = mysqli_query($db, $sql);
//$ratio_arr = array();
//while ($row = mysqli_fetch_assoc($result)) {
//	$sql1 = "SELECT delivery_ratio FROM members WHERE mid='{$row['mid']}'";
//	$result1 = mysqli_query($db, $sql1);
//	$ratio = mysqli_fetch_assoc($result1);
////	$ratio_arr[$row['mid']] = $ratio['delivery_ratio'];
//	$ratio_arr[] = array('mid'=>$row['mid'], 'ratio'=>$ratio['delivery_ratio']);
//}
// 找出ratio最少的家伙，他负责付这次的外卖费
//for ($i = 0; $i < count($ratio_arr) - 1; $i++) {
//	for ($j = 1; $j < count($ratio_arr); $j++) {
//		if ($ratio_arr[$i]['ratio'] > $ratio_arr[$j]['ratio']) {
//			$max = $ratio_arr[$i]['mid'];
//		} else {
//			$max = $ratio_arr[$j]['mid'];
//		}
//	}
//}
//$update = "UPDATE members SET balance=balance-1 WHERE mid='$max'"; // 扣除外卖费
//$result3 = mysqli_query($db, $update);
//$affected_rows = mysqli_affected_rows($db);
//if ($affected_rows == 1) {
//	// 扣除外卖费成功
//	// 写入日志
//	$mid = $_SESSION['login']['mid'];
//	$edit_time = time();
//	
//	$insert = "INSERT INTO pedidos_log(`mid`,`edit_time`,`year`,`month`,`day`,`hour`,`minute`,`rid`,`r_name`,`cid`,`c_name`,`menu_id`,`dish_name`,`unit_price`,`dish_count`,`total_price`,`note`,`status`,`type_tag`)
//						 VALUES('{$_SESSION['login']}','')";
//}

$totalPrice = 0;
foreach($menuList as $row){
	$totalPrice += $row['total_price'];
}

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
			<th><label><input type="checkbox" name="allLogs" onClick="selectAll(this)" />全选</label></th>
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
function selectAll(_this) {
	var all = _this.checked;
	var logs = document.getElementsByName('selectLog');
	for (var i = 0; i < logs.length; i++) {
		if (all == true) {
			logs[i].checked = true;
		} else {
			logs[i].checked = false;
		}
	}
}

function selectLogs() {
	var logs = document.getElementsByName('selectLog');
	var logsStr = '';
	var tag = 0;
	for (var i = 0; i < logs.length; i++) {
		if (logs[i].checked == true) {
			logsStr += logs[i].value + ';';
			tag = 1;
		}
	}
	if (tag == 0) { // 一个都没有勾选
		alert('没有勾选任何菜单.');
		return false;
	}
	window.location.href="allmenuspass.php?logs=" + logsStr;
//	$.get('/allmenuspass.php', {
//		logs: logsStr
//	}, function(data) {
//		if (data == '1') {
//			window.location.href = 'pmanage.php';
//		}
//	});
}
</script>
</body>
</html>