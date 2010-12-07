<div class="header">
<style type="text/css">
.header { position: absolute; top: 0; height: 30px; width: 100%; background-color: #CCC; }
ul { margin: 0; padding: 0; }
li { list-style: none; }
.herizontal-list li { float: right; padding: 2px 5px; }
</style>
<ul class="herizontal-list">
	<li><a href="/signout.php">退出</a></li>
	<li>欢迎，<?php echo $_SESSION['member']['name']; ?></li>
</ul>
</div>