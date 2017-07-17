<?php

class Logout extends Controller {
	
	public function __construct() {
		parent::__construct();	
	}
	
	public function index() {
		$logout = $this->loadModel('Logout');
		$logout->logout();
	}
	
	public function Done() {
		$_SESSION['feedback_positive'][] = array(LOGOUT_SUCCESS, "Yay", "success", "fa fa-refresh fa-spin", false);
		$this->view->render('logout/done');	
	}
	
}

?>