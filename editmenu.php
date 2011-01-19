<?php 
include 'config.php';
include 'db.php';
$menu_id = $_GET['menuid'];
$sql = "SELECT * FROM ";
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>编辑菜单</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
<h3>编辑菜单</h3>
<div>
	
</div>
<div id="category">
	<table border="1">
		<tr>
			<th>分类</th>
			<th>操作</th>
		</tr>
	<?php foreach ($cat_arr as $row): ?>
		<tr>
			<td><a href="getmenus.php?cid=<?php echo $row['cid']; ?>"><?php echo $row['c_name']; ?></a></td>
		</tr>
	<?php endforeach; ?>
	</table>
</div>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
</body>
</html>