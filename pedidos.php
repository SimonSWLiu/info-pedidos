<?php 
include 'config.php';
include 'db.php';
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
</body>
</html>