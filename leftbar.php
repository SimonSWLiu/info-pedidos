<!--左边栏-->
<?php 
define('ONE_DAY', 86400);
$mid = $_SESSION['login']['mid'];
$today = (int)(time() / ONE_DAY);
$sql = "SELECT * FROM pedidos_log WHERE mid='$mid' AND edit_time<='$today'";
//$result = $db->query($sql);

$json = $_COOKIE['pedidos'];

$list = array();
$count = array();
$list = json_decode($json);
$price = 0;
$pedidos = array();
foreach ($list as $row) {
	$sql = "SELECT * FROM menu WHERE menu_id='{$row->menu}'";
	$result = $db->query($sql);
	$menu = $result->fetch_assoc();
	$pedidos[] = $menu;
	$count[$row->menu] = $row->count;
	$price += $row->count * $menu['m_price'];
}
//while ($row = $result->fetch_assoc()) {
//	$list[] = $row;
//}
?>
<div class="leftbar">
	<ul>
		<li><a href="menu.php?step=1" target="main_frame">点餐</a></li>
		<li id="myAccount">
			<a href="myaccount.php" target="main_frame">我的账户</a>
			<ul style="display: none;">
				<li><a href="changepwd.php" target="main_frame" id="changePwd">修改密码</a></li>
				<li><a href="balance.php" target="main_frame" id="myBalance">我的余额</a></li>
				<li><a href="orderhistory.php" target="main_frame" id="orderHistory">我的点餐历史</a></li>
			</ul>
		</li>
		<?php if ($level < 3): ?>
		<li><a href="menumanage.php" target="main_frame">菜单管理</a></li>
		<li><a href="members.php" target="main_frame">会员管理</a></li>
		<?php endif; ?>
	</ul>
	<div style="color: #fff;">
		<div>我的餐单</div>
		<form>
			<table>
				<tr>
					<td>菜名</td>
					<td>数量</td>
					<td>单价</td>
				</tr>
			<?php foreach ($pedidos as $row): ?>
				<tr>
					<td><?php echo $row['m_name']; ?></td>
					<td><?php echo $count[$row['menu_id']]; ?></td>
					<td><?php echo $row['m_price']; ?></td>
				</tr>
			<?php endforeach; ?>
			</table>
			<div>总价: <span><?php echo $price; ?></span></div>
			<input type="submit" value="提交" />
		</form>
	</div>
</div>