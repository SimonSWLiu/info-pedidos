<?php
include 'config.php';
include 'db.php';
if ($_POST) {
	$mName = $_POST['mName'];
	$mPrice = $_POST['mPrice'];
	$mNote = $_POST['mNote'];
	$catId = $_POST['catId'];
	$rid = $_POST['rid'];
	$sql = "INSERT INTO menu(m_name,m_price,m_note,cat_id,restaurant_id) VALUES('$mName','$mPrice','$mNote','$catId','$rid')";
	$result = $db->query($sql);
	mysqli_close($db);
	header('location: getmenus.php?cid=' . $catId);
}
?>