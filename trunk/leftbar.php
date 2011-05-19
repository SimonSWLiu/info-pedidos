<!--左边栏-->
<div class="leftbar">
	<ul>
		<li><a href="menu.php?step=1" target="main_frame">点餐</a></li>
		<li id="myAccount">
			<a href="myaccount.php" target="main_frame">我的账户</a>
			<ul style="display: none;">
				<li><a href="editname.php" target="main_frame" id="editName">修改姓名</a></li>
				<li><a href="changepwd.php" target="main_frame" id="changePwd">修改密码</a></li>
				<li><a href="balance.php" target="main_frame" id="myBalance">我的余额</a></li>
				<li><a href="orderhistory.php" target="main_frame" id="orderHistory">我的点餐历史</a></li>
			</ul>
		</li>
		<li><a href="today.php" target="main_frame">今日点餐</a></li>
		<?php if ($level < 3): ?>
		<li><a href="pmanage.php" target="main_frame">点餐管理</a></li>
		<li><a href="menumanage.php" target="main_frame">菜单管理</a></li>
		<li><a href="members.php" target="main_frame">会员管理</a></li>
		<li><a href="detail.php" target="main_frame">交易明细</a></li>
		<li><a href="pedidoshis.php" target="main_frame">点餐历史</a></li>
		<?php endif; ?>
	</ul>
	<?php include 'list.php'; ?>
</div>