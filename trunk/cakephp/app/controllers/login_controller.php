<?php
class LoginController extends AppController {
	var $name = 'members';
	
	function index() {
		print_r($this->Session);
		echo '<br /><br />';
		$this->Session->write('user', 'benson');
		print_r($this->Session);
		exit;
	}
}