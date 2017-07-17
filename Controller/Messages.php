<?php

class Messages extends Controller {
	
	public function __construct() {
		parent::__construct();	
	}
	
	public function index($params = array()) {
		$msgs = $this->loadModel('Messages');
		$this->view->conversations = $msgs->getMsgs($this->view->user['user_ID']);
		$this->view->render('Messages/index');	
	}
	
	public function Conversation($params = array()) {
		if(!isArrayEmpty($params)) {
			$name = $params[0];
			$msgs = $this->loadModel('Messages');
			$conv = $msgs->getConv($this->view->user['user_ID'], $name);
			echo $conv;
		} else {
			echo '<div class="no_msg_selected text-center">No message selected</div>';
		}
	}
	
	public function compose() {
		$this->view->render('Messages/compose');
	}
	
	public function send() {
		$model = $this->loadModel('messages');
		$model->sendMsg($this->view->user['user_ID'], $_POST['msg_to'], $_POST['msg_msg']);
		header('Location: '.URL.getCurrentController().'/'.$_POST['msg_to']);
	}
	
	public function reply() {
		$model = $this->loadModel('messages');
		echo $model->sendMsg($this->view->user['user_ID'], $_REQUEST['msg_to'], $_REQUEST['msg_msg'], true);
	}
	
	public function getUsers() {
		$model = $this->loadModel("Messages");
		echo $model->getUsers($_REQUEST['to'], $this->view->user['user_name']);
	}
	
	public function __call($name, $arguments) {
		$this->index();	
	}
}

?>