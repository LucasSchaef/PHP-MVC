<?php
class login extends Controller {
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$model = $this->loadModel('login');
		if(!$model->loggedin) {
			$this->view->render('login/index', true);	
		} else {
			header("Location: ".URL."overview");	
		}
	}
	
	public function noAccess($to = array()) {
		$model = $this->loadModel('login');
		$_SESSION['feedback_negative'][] = NO_ACCESS_ERROR;
		if(!$model->loggedin) {
			$this->view->to = implode("/", $to);
			$this->view->render('login/index', true);	
		} else {
			header("Location: ".URL."overview");	
		}
	}
	
	public function DoLogin($to = array()) {
		$model = $this->loadModel('login');
		if($model->loggedin) {
			$_SESSION['feedback_positive'][] = array(LOGIN_SUCCESS, "Yay", "success", "fa fa-refresh fa-spin", false);
			if(!isArrayEmpty($to)) {
				$this->view->to = implode("/", $to);
			}
			$this->view->render('login/success', true);
		} else {
			if(!isArrayEmpty($to)) {
				$path = URL."Login/noAccess/".implode("/", $to);
			} else {
				$path = URL."Login";
			}
			header("Location: ".$path);
		}
	}
}
?>