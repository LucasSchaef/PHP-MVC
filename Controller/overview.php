<?php
class overview extends Controller {
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$model = $this->loadModel('overview');
		$this->view->newMsg = $model->newMsgs();
		$this->view->StatsChart = $model->userStatistics();
		$this->view->render('overview/index');	
	}
}
?>