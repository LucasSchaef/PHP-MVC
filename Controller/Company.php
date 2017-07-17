<?php

class Company extends Controller {
	
	public function __construct() {
		parent::__construct();	
	}
	
	public function index() {
		$model = $this->loadModel("Company");
		$this->view->list = $model->createCompanyList();
		$this->view->render('Company/index');	
	}
	
	public function Create() {
		if(piane('company_name')) {
			
		} else {
			$this->view->render('Company/Create');
		}
	}
	
}

?>