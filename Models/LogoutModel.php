<?php

class LogoutModel {
	private $db;
	
	public function __construct(Database $db) {
		$this->db = $db;
	}
	
	public function logout() {
		$unique_id = $_SESSION[PREFIX.'user_id'];
		$update = array('user_remember'=>false, 'user_remember_time'=>0);
		$this->db->where('user_unique_ID', $unique_id);
		$this->db->update('users', $update);
		$_SESSION = array();
		Session::destroy();
		header("Location: ".URL.getCurrentController()."/Done");
	}
	
}

?>