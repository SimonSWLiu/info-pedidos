<?php 
$sql = "SELECT * FROM restaurant";
$result = $db->query($sql);
$restaurants = array();
while ($row = $result->fetch_assoc()) {
	$restaurants[] = $row;
}
?>
<h2>1.选择餐厅</h2>
<ul>
<?php foreach ($restaurants as $row): ?>
<!--<h3><?php echo $row['r_name']; ?> <span style="margin-left: 10px;"><a href="?step=2&rid=<?php echo $row['rid']; ?>"></a></span></h3>-->
	<li><span><?php echo $row['r_name']; ?></span><input type="button" value="进入" onclick="window.location = '?step=2&rid=<?php echo $row['rid']; ?>'" /></li>
<?php endforeach; ?>
</ul>