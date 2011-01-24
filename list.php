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
		$pedidos[] = $menu;
		$count[$row->menu] = $row->count;
		$price += $row->count * $menu['m_price'];
	}
}
?>
<div style="float: right;">
	<div>我的餐单</div>
	<form>
		<table>
			<tr>
				<td>菜名</td>
				<td>数量</td>
				<td>单价</td>
			</tr>
		<?php 
		if ($list):
			foreach ($pedidos as $row): ?>
			<tr>
				<td><?php echo $row['m_name']; ?></td>
				<td><?php echo $count[$row['menu_id']]; ?></td>
				<td><?php echo $row['m_price']; ?></td>
			</tr>
		<?php endforeach;
		endif; ?>
		</table>
		<div>总价: <span><?php echo $price; ?></span></div>
		<input type="submit" value="提交" />
	</form>
</div>