<?php

class User extends Controller {
	
	public function __construct() {
		parent::__construct();	
	}
	
	public function index() {
		$model = $this->loadModel('User');
		$this->view->UserList = $model->listUsers();
		$this->view->render('User/index');	
	}
	
	public function Details($params) {
		$model = $this->loadModel('User');
		$this->view->userInfo = $model->userInfo($params[0]);
		$this->view->render('User/Details');	
	}
	
	public function Groups($params = NULL) {
		$model = $this->loadModel('User');
		if(is_null($params) OR !isset($params[0]) OR empty($params[0])) {
			$this->view->userGroupList = $model->listUserGroups();
			$this->view->render('User/Groups');	
		} elseif($params[0] == "Create") {
			if(!piane('group_name')) {
				$this->view->render('User/CreateGroup');	
			} else {
				$model->createUsergroup($_POST['group_name']);
				header("Location: ".URL.getCurrentController()."/Groups");
			}
		}
	}
	
	public function Create() {
		$model = $this->loadModel('User');
		$this->view->render("User/createUser");
	}
	
	public function AjaxUserSearch() {
		$model = $this->loadModel('User');
		$user_list = $model->userAjaxSearch();
		echo $user_list;
	}
		
}

?>