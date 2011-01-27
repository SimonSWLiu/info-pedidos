<?php 
$cid = $_GET['cid'];
$sql = "SELECT * FROM menu WHERE cat_id='$cid'";
$result = $db->query($sql);
$cat = array();
while ($row = $result->fetch_assoc()) {
	$cat[] = $row;
}
?>
<h2>3.菜式</h2>
<form action="" method="post">
	<input type="hidden" name="step" value="4" />
	<?php foreach ($cat as $row): ?>
	<div><label><input type="checkbox" name="selectMenu" value="<?php echo $row['menu_id']; ?>" /><?php echo $row['m_name']; ?> <?php echo $row['m_price']; ?></label></div>
	<?php endforeach; ?>
	<div><input type="submit" value="提交" /></div>
</form>