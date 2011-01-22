<?php 
$sql = "SELECT * FROM restaurant";
$result = $db->query($sql);
$restaurants = array();
while ($row = $result->fetch_assoc()) {
	$restaurants[] = $row;
}
?>
<div>
	<table border="1">
		<tr>
			<th>餐厅名</th>
		</tr>
		<?php foreach ($restaurants as $row): ?>
		<tr>
			<td><?php echo $row['r_name']; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>