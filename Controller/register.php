<?php

class Register extends Controller {
	public function __construct() {
		parent::__construct();	
	}
	
	public function index() {
		$this->view->render('register/index');	
	}
	
	public function DoRegistration() {
		$model = $this->loadModel("Register");
		if($model->regSucc) {
			$this->view->render('register/success');
		} else {
			$this->view->formData = $_POST;
			$this->view->render('register/index');
		}
	}
	
	public function activate($post) {
		$model = $this->loadModel("Register");
		if($model->activateUser($post[0])) {
			$this->view->render('register/activationSuccess');
		} else {
			$this->view->render('register/activationError');
		}
	}
}
?>