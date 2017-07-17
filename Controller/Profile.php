<?php

class Profile extends Controller {
	
	public function __construct() {
		parent::__construct();	
	}
	
	public function index() {
		$this->view->render('Profile/index');	
	}
	
	public function saveAvatar() {
		echo json_encode($_REQUEST);
	}
	
	public function save() {
		$model = $this->loadModel('register');
		$input = array();
			
		if(!empty($_REQUEST['usr_email'])) {
			$input['user_email'] = $_REQUEST['usr_email'];
		}
			
		if(!empty($_REQUEST['usr_pw'])) {
			if($model->pwMatchMinimum($_REQUEST['usr_pw'])) {
				$input['user_password_hash'] = $model->pwHash($_REQUEST['usr_pw']);	
			} else {
				echo Alert::error('The password does not match our minimum criteria!');
				return false;
			}
		}
			
		$this->db->where('user_ID', $this->view->user['user_ID']);
		if($this->db->update('users', $input)) {
			echo Alert::success('Changes were successfully saved!');
		}
	}
}

?>