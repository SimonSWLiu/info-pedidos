<?php
// 配置文件
date_default_timezone_set('Asia/Shanghai');
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL | E_STRICT);
session_start();

/**
 * 管理权限（默认4，普通会员）
 * @param int $level
 */
function permission($level = 4) {
	$userLevel = isset($_SESSION['login']['level'])? $_SESSION['login']['level'] : 4;
	if ($userLevel > $level) exit('No permission');
}
?>