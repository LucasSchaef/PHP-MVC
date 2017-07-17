<?php

class Index extends Controller {
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		if(isset($_GET['admin'])) { 
			if($this->view->loggedIn) {
				$this->view->render('index/index');
			} else {
				$this->view->render('login/index', true);
			}
		} else {
			$this->view->render('index/frontend-index', true);
		}
	}
}

?>