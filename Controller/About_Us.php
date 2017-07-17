<?php

class About_Us extends Controller {
	
	public function __construct() {
		parent::__construct();	
	}
	
	public function index() {
		$this->view->render('About_Us/index');	
	}
	
}

?>