<?php

class {{NAME}} extends Controller {
	
	public function __construct() {
		parent::__construct();	
	}
	
	public function index() {
		$this->view->render('{{NAME}}/index');	
	}
	
}

?>