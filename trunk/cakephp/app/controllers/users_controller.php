<?php
class UsersController extends AppController {
	var $name = 'Users';
	var $helpers = array ('Html', 'Form' );
	
	function register() {
		//    if (!empty($this->params['form']))		//    {		//      if ($this->User->save($this->params['form']))		//      {		//        $this->flash('Your registration information was accepted.', '/users/register');		//      } else {		//        $this->flash('There was a problem with your registration', '/users/register');		//      }		//    }		

		if (! empty ( $this->data )) {
			if ($this->User->save ( $this->data )) {
				$this->Session->setFlash ( 'Your registration information was accepted.' );
			}
		}
	}
	
	function knownusers() {
		$this->set ( 'knownusers', $this->User->find ( 'all', array ('fields' => array ('id', 'username', 'first_name', 'last_name' ), 'order' => 'id DESC' ) ) );
	}
}
?>