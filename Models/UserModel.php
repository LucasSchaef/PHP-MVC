<?php

class UserModel {
	private $db;
	
	
	public function __construct(Database $db) {
		$this->db = $db;
	}
	
	public function listUsers() {
		$user = $this->db->get("users", NULL, array("user_name", "user_email", "user_unique_ID"));
		return mkCrudList($user, array("Username", "E-Mail"), "user_unique_ID");	
	}
	
	public function listUserGroups() {
		$usergroups = $this->db->get("usergroups");
		return mkCrudList($usergroups, array("Name"), "usergroup_ID");	
	}
	
	public function createUsergroup($name) {
		$this->db->where('usergroup_name', $name);
		$res = $this->db->getOne('usergroups');
		if(count($res)>0) {
			$_SESSION['feedback_negative'][] = USERGROUP_ALREADY_EXISTS;
			return false;
		}
		if($this->db->insert('usergroups', array('usergroup_name'=>$name))) {
			$_SESSION['feedback_positive'][] = USERGROUP_SUCCESSFULLY_CREATED;
			return true;
		}
		$_SESSION['feedback_negative'][] = COULDNT_CREATE_USERGROUP;
		return false;
	}
	
	public function userInfo($uniqueID) {
		$this->db->where('user_unique_ID', $uniqueID);
		$user = $this->db->getOne('users');
		return $user;	
	}
	
	public function userAjaxSearch() {
		if(piane('AjaxSearch_user_name')) {
			$ret = "No matches found.";
			
			$val = strtolower($_POST['AjaxSearch_user_name']);
			$this->db->where('LCASE(user_name)', '%'.$val.'%', "LIKE");
			
			$users = $this->db->get("users", NULL, array("user_name", "user_email", "user_unique_ID"));
			
			
			if(!isArrayEmpty($users)) {
				return mkCrudList($users, array("Username", "E-Mail"), "user_unique_ID");
			} 
			return $ret;
		} else {
			return $this->listUsers();
		}
	}
}

?>