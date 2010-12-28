<?php
include 'config.php';
include 'db.php';
if ($_POST) {
	$mName = $_POST['mName'];
	$mPrice = $_POST['mPrice'];
	$mNote = $_POST['mNote'];
	$catId = $_POST['catId'];
	$sql = "INSERT INTO menu(m_name,m_price,m_note,cat_id) VALUE('$mName','$mPrice','$mNote','$catId')";
	$result = $db->query($sql);
	mysqli_close($db);
	header('location:getmenus.php?cid=' . $catId);
}
?>