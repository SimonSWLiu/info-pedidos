<?php
$rid = $_GET['rid'];
$sql = "SELECT * FROM category WHERE rid='$rid'";
$result = $db->query($sql);
$category = array();
while($row = $result->fetch_assoc()) {
	$category[] = $row;
}
?>
<h1>第二步</h1>
<?php foreach ($category as $row): ?>
<h3><?php echo $row['c_name']; ?> <span style="margin-left: 10px"><a href="?step=3&cid=<?php echo $row['cid']; ?>">--></a></span></h3>
<?php endforeach; ?>