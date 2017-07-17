<?php

class ToDo extends Controller {
	
	public function __construct() {
		parent::__construct();	
	}
	
	public function index() {
		$model = $this->loadModel('ToDo');
		$this->view->tasks = $model->loadTaskList($this->view->user['user_ID']);
		$this->view->render('ToDo/index');	
	}
	
	public function create() {
		if(piane('task_name')) {
			$insert = array(
						'task_name' => $_POST['task_name'],
						'task_start' =>  strtotime($_POST['task_start_date']),
						'task_end' =>  strtotime($_POST['task_end_date']),
						'task_importance' =>  $_POST['task_importance'],
						'task_short_desc' =>  $_POST['task_short_desc'],
						'task_long_desc' =>  $_POST['task_short_desc']);
			
			$this->db->insert('tasks', $insert);
			$this->db->insert('users_tasks', array('user_ID'=>$this->view->user['user_ID'], 'task_ID'=>$this->db->getInsertId()));
		}
		$this->view->render('ToDo/create');	
	}
	
	public function updateProgress() {
		if(riane('task_ID', 'task_progress')) {
			$model = $this->loadModel('ToDo');
			if($model->setProgress(intval($_REQUEST['task_ID']), intval($_REQUEST['task_progress']))) {
				return true;
			}
		}
		header('HTTP/1.1 500 Internal Server Booboo');
	}
	
	public function edit($params) {
		$task_ID = intval($params[0]);
		$model = $this->loadModel('ToDo');
		if($this->view->task = $model->loadSingleTask($task_ID, $this->view->user['user_ID'])) {
			$this->view->render('ToDo/Edit');
		} else {
			$_SESSION['feedback_negative'][] = 'You either do not have access to this task or it does not exist.';
			header('Location: '.URL.getCurrentController());
		}
	}
	
	public function saveChanges() {
		$model = $this->loadModel('ToDo');
		if($model->saveChanges($this->view->user['user_ID'])) {
			return true;	
		}
		header('HTTP/1.1 500 Internal Server Booboo');
	}
	
}

?>