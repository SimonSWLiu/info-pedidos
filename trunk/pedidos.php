<?php 
include 'config.php';
include 'db.php';

if (!isset($_SESSION['login'])) {
	header('location: /pedidos/login.php');
}
if ($_POST) {
	$menuArr = $_POST['menu'];
	foreach ($menuArr as $row) {
		$logArr = explode(':', $row);
		$menu_id = $logArr[0];
		$count = $logArr[1];
		$sql = "INSERT INTO pedidos_log(mid,edit_time,rid,r_name,cid,c_name,menu_id,dish_name,unit_price,dish_count,total_price,note,status)
						VALUES()";
		$result = $db->query($sql);
	}
}
$level = $_SESSION['login']['level'];
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pedidos - 点餐系统</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
<link type="/images/x-icon" rel="shortcut icon" href="/images/favicon.ico" />
</head>
<body>
<?php include 'header.php'; ?>
<?php include 'leftbar.php'; ?>
<?php include 'main.php'; ?>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/global.js"></script>
<script type="text/javascript" src="scripts/cookies.js"></script>
</body>
</html>