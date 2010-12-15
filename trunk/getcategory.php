<?php
include 'config.php';
if ($_GET) {
	$rid = $_GET['rid'];
	$sql = "SELECT * FROM category WHERE rid='$rid'";
	$result = $db->query($sql);
	mysqli_close($db);
	$category = array();
	while ($row = $result->fetch_assoc()) {
		$category[] = $row;
	}
}
?>
<div class="category-div">
	<table border="1">
		<tr>
			<th>类别</th>
			<th>操作</th>
		</tr>
		<?php foreach ($category as $row): ?>
		<tr>
			<td><a href="#" class="category-name"><?php echo $row['c_name']; ?></a></td>
			<td><a href="#">修改</a><a href="#">删除</a></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<form action="/addcategory.php" method="get">新增 : <input type="text" name="category_name" /><input type="hidden" name="rid" value="<?php echo $rid; ?>" /><input type="submit" value="保存" /></form>
</div>