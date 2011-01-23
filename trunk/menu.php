<?php 
include 'config.php';
include 'db.php';
$sql = "SELECT * FROM restaurant";
$result = $db->query($sql);
while(($row = $result->fetch_assoc()) == true) {
	$rest[$row['rid']] = $row['r_name'];
}
unset($row);
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>点餐</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
<?php
	switch ($_GET['step']) {
		case '1':
			include 'step1.php';
			break;
		case '2':
			include 'step2.php';
			break;
		case '3':
			include 'step3.php';
			break;
		case '4':
			include 'stpe4.php';
			break;
	}
?>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
</body>
</html>
<?php
mysqli_close($db);
?>