<?php 
include 'config.php';
include 'db.php';
$sql = "SELECT * FROM restaurant";
$result = $db->query($sql);
while(($row = $result->fetch_assoc()) == true) {
	$rest[$row['rid']] = $row['r_name'];
}
unset($row);
mysqli_close($db);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>点餐</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
</head>
<body>
<div>
	<ul>
	<?php foreach ($rest as $key=>$row): ?>
		<li><?php echo $row; ?></li>
	<?php endforeach; ?>
	</ul>
</div>
</body>
</html>