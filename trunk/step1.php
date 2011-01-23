<?php 
$sql = "SELECT * FROM restaurant";
$result = $db->query($sql);
$restaurants = array();
while ($row = $result->fetch_assoc()) {
	$restaurants[] = $row;
}
?>
<h1>第一步</h1>
<div>
<?php foreach ($restaurants as $row): ?>
<h3><?php echo $row['r_name']; ?> <span style="margin-left: 10px;"><a href="?step=2&rid=<?php echo $row['rid']; ?>">--></a></span></h3>
<?php endforeach; ?>
</div>