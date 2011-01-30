<?php 
$mid = $_SESSION['login']['mid'];
$json = isset($_COOKIE['pedidos'])? $_COOKIE['pedidos'] : '';
$list = array();
$count = array();
$list = json_decode($json);
$price = 0;
$pedidos = array();
if ($list) {
	foreach ($list as $row) {
		$sql = "SELECT * FROM menu WHERE menu_id='{$row->menu}'";
		$result = $db->query($sql);
		$menu = $result->fetch_assoc();
		$pedidos[]['name'] = $menu['m_name'];
		$pedidos[]['price'] = $menu['m_price'];
		$pedidos[]['count'] = $row->count;
//		$count[$row->menu] = $row->count;
		$price += $row->count * $menu['m_price'];
	}
}
?>
<div style="float: left; margin-top: 10px; color: #FFF;">
	<div>我的餐单</div>
	<form method="post" action="">
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
		<div>总价: <span><?php echo $price; ?></span></div>
		<input type="submit" value="提交" /><input type="button" value="清空" onclick="document.cookie = 'pedidos=\'\';expires=0'; parent.history.go(0);" />
	</form>
</div>