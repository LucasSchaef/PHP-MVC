<?php
class Controller {
	public $db, $view;
	
	public function __construct() {
		Session::start();
		
		$this->db = new Database(DB_HOST, DB_USER, DB_PW, DB_DB);
		$this->db->setPrefix(DB_PREFIX);
		$this->statistics();
		$this->view = new View();
		$this->db->where('mvc_nav IS NOT NULL');
		$this->db->orderby('mvc_nav', 'ASC');
		$this->view->mvcs = $this->db->get('mvcs');
		
		if(Authorization::loggedIn()) {
			$this->view->user =	$this->userArray();
			$this->view->loggedIn = true;	
		} else {
			$this->view->user = array();
			$this->view->loggedIn = false;
		}
		
		if($this->Access(get_called_class(), $this->view->user, $this->view->loggedIn) == false) {
			header("Location: ".URL."Login/noAccess/".get_called_class());
		}
	}
	
	private function Access($mvc_name, $user, $loggedIn) {
		$this->db->where('UPPER(mvc_name)', strtoupper($mvc_name));
		$mvc = $this->db->getOne('mvcs', array('mvc_restricted'));
		if($mvc['mvc_restricted'] == true && $loggedIn == true) {
			if(in_array(strtoupper($mvc_name), $user['mvcs'])) {
				return true;
			}
		} elseif($mvc['mvc_restricted'] == false) {
			return true;
		}
		return false;
	}
	
	public function loadModel($name) {
		$path = MODELS_PATH.strtolower($name).'Model.php';
		
		if(file_exists($path)) {
			require_once($path);
			$modelName = $name.'Model';
			return new $modelName($this->db);	
		}
	}
	
	private function userArray() {
		$unique_id = $_SESSION[PREFIX.'user_id'];
		$this->db->where('user_unique_ID', $unique_id);
		$user = $this->db->getOne('users');
		
		$this->db->where(PREFIX.'users_usergroups.user_ID', $user['user_ID']);
		$this->db->join('usergroups', PREFIX.'usergroups.usergroup_ID = '.PREFIX.'users_usergroups.usergroup_ID', 'LEFT');
		$usergroups = $this->db->get('users_usergroups', NULL, array(PREFIX.'usergroups.usergroup_ID', PREFIX.'usergroups.usergroup_name'));
		$user['usergroups'] = $usergroups;
		foreach($usergroups as $ug) {
			$this->db->orWhere('usergroup_ID', $ug['usergroup_ID']);	
		}
		$this->db->join('mvcs', PREFIX.'mvcs.mvc_ID = '.PREFIX.'usergroups_mvcs.mvc_ID', 'LEFT');
		$mvcs = $this->db->get('usergroups_mvcs', NULL, array(PREFIX.'mvcs.mvc_ID', 'UPPER('.PREFIX.'mvcs.mvc_name) AS mvc_name'));
		foreach($mvcs as $mvc) {
				$user['mvcs'][$mvc['mvc_ID']] = $mvc['mvc_name'];
		}
		
		$this->db->where('message_to', $user['user_ID']);
		$this->db->where('message_read', 0);
		$msgs = $this->db->get('messages');
		$user['msg_count'] = $this->db->count;
		return $user;
	}
	
	private function statistics() {
		/*
		// Get IP's
		$ip = $_SERVER['REMOTE_ADDR'];
		$ip_type = "ipv4";
		if(preg_match("/^[0-9a-f]{1,4}:([0-9a-f]{0,4}:){1,6}[0-9a-f]{1,4}$/", $ip)) {
			$insert = array('visitor_ipv6'=>$ip);
			$ip_type = "ipv6";
		} else {
			$insert = array('visitor_ipv4'=>$ip);
		}
		$insert['visitor_time'] = time();
		
		$this->db->where('visitor_'.$ip_type, $insert['visitor_'.$ip_type]);
		if(count($this->db->getOne('visitors'))>0) {
			$this->db->where('visitor_'.$ip_type, $insert['visitor_'.$ip_type]);
			$this->db->update('visitors', $insert);
		} else {
			$this->db->insert('visitors', $insert);
		}*/
	}
}
?>