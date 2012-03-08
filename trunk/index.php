<?php
exit('b');
define('APP_PATH', realpath(dirname(__FILE__)));
set_include_path(get_include_path() . PATH_SEPARATOR . DIRECTORY_SEPARATOR . 'pedidos');

header('location: login.php');
exit;
?>
