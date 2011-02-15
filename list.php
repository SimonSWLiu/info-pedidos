<?php 
$mid = $_SESSION['login']['mid'];
$menuArr = isset($_COOKIE['pedidos'])? $_COOKIE['pedidos'] : '';
$list = explode(';', $menuArr);
array_pop($list);

foreach ($list as $row) {
	$cache = explode(':', $row);
	$menu['menu_id'] = $cache[0];
	$menu['menu_count'] = $cache[1];
	$menus[] = $menu;
}
//print_r($menus);
//exit;

$price = 0;
$pedidos = array();
$sql = "SELECT balance FROM members WHERE mid='{$_SESSION['login']['mid']}'";
$result = $db->query($sql);
$balanceArr = $result->fetch_assoc();
$balance = $balanceArr['balance'];
if ($list) {
	foreach ($list as $row) {
		$sql = "SELECT * FROM menu WHERE menu_id='{$row['menu_id']}'";
		$result = $db->query($sql);
		$menu = $result->fetch_assoc();
		$menuArr = explode(':', $row);
		$pArr['name'] = $menu['m_name'];
		$pArr['price'] = $menu['m_price'];
		$pArr['count'] = $menuArr[1];
		$pedidos[] = $pArr;
		$price += $pArr['count'] * $menu['m_price'];
	}
}
?>
<div style="color: #FFFFFF; float: left; margin: 30px 0; width: 100%;">
	<div>我的餐单</div>
	<form method="post" action="submitmenu.php" onsubmit="return menuValidate()" style="background-color: #F00;">
		<table>
			<tr>
				<td>菜名</td>
				<td>数量</td>
				<td>单价</td>
			</tr>
		<?php 
		if ($list):
			foreach ($pedidos as $row): ?>
			<input type="hidden" name="menu" value="<?php echo $row['menu_id'] . ':' . $count[$row['menu_id']]; ?>" />
			<tr>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['count']; ?></td>
				<td><?php echo $row['price']; ?></td>
			</tr>
		<?php endforeach;
		endif; ?>
		</table>
		<div>外卖费：<span></span></div>
		<div>总价: <span id="total"><?php echo $price; ?></span> 余额：<span id="balance"><?php echo $balance; ?></span></div>
		<input type="submit" value="提交" /><input type="button" value="清空" onclick="document.cookie = 'pedidos=\'\';expires=0'; parent.history.go(0);" />
	</form>
</div>
<script type="text/javascript">
function menuValidate() {
	var myBalance = Number(document.getElementById('balance').innerHTML);
	var total = Number(document.getElementById('total').innerHTML);
	if (total <= 0) {
		alert('请先下单');
		return false;
	}
	if (myBalance < total) {
		alert('余额不足，请先充值');
		return false;
	}
	return true;
}
</script>