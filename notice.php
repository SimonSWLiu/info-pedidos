<?php
include 'config.php';
include 'db.php';
if ($_POST) {
	$content = isset($_POST['notice_content'])? $_POST['notice_content'] : '';
	if (!$content) exit('内容不完整');
	$mid = $_SESSION['login']['mid'];
	$time = time();
	$insert = "INSERT INTO notice(`notice_member`,`notice_content`,`notice_date`,`notice_status`) VALUES('$mid','$content','$time','1')";
	mysqli_query($db, $insert);
	if (mysqli_affected_rows($db) == 1) exit('发布公告成功。');
	else exit('发布失败。');
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>点餐</title>
<link type="text/css" rel="stylesheet" href="styles/global.css" />
</head>
<body>
	<form action="" method="post">
		<textarea name="notice_content" rows="10" cols="100"></textarea>
		<input type="submit" value="发布公告" />
	</form>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/global.js"></script>
</body>
</html>

<?php
mysqli_close ( $db );
?>