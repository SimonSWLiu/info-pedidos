<!--左边栏-->
<?php 
define('ONE_DAY', 86400);
$mid = $_SESSION['login']['id'];
$today = (int)(time() / ONE_DAY);
$sql = "SELECT * FROM pedidos_log WHERE mid='$mid' AND edit_time<='$today'";
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
	<div>
	</div>
</div>