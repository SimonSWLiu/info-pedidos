<?php
$rid = $_GET['rid'];
$sql = "SELECT * FROM category WHERE rid='$rid'";
$result = $db->query($sql);
$category = array();
while($row = $result->fetch_assoc()) {
	$category[] = $row;
}
?>
<h2>2.类别</h2>
<ul>
<?php foreach ($category as $row): ?>
<!--<h3><?php echo $row['c_name']; ?> <span style="margin-left: 10px"><a href="?step=3&cid=<?php echo $row['cid']; ?>"></a></span></h3>-->
	<li><span><?php echo $row['c_name']; ?></span><input type="button" value="进入" onclick="window.location = '?step=3&cid=<?php echo $row['cid']; ?>'" /></li>
<?php endforeach; ?>
</li>