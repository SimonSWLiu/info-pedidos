<?php 
$cid = $_GET['cid'];
$sql = "SELECT * FROM menu WHERE cat_id='$cid'";
$result = $db->query($sql);
$cat = array();
while ($row = $result->fetch_assoc()) {
	$cat[] = $row;
}
?>
<h1>菜式</h1>
<form action="" method="post">
	<?php foreach ($cat as $row): ?>
	<label><input type="checkbox" name="selectMenu" value="<?php echo $row['menu_id']; ?>" /><?php echo $row['m_name']; ?></label>
	<?php endforeach; ?>
	<div><input type="submit" value="提交" /></div>
</form>