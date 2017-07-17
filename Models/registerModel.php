<?php

class RegisterModel {
	
	private $postRequired = array(
								'user_name'=>"Username",
								'user_pw'=>"Password",
								'user_pw_repeat'=>"Repeat-Password",
								'user_email'=>"E-Mail",
								'user_email_repeat'=>"Repeat-E-Mail");
	private $pwRequired = array('A-Z', 'a-z', '0-9', '\@\&\%\-\_\$\#\+\~\?\!');
	private $pwLength = 8;
	private $regMail = true;
	private $db, $userData;
	private $mailTmpl = '_templates/mail/register.txt';
	public $regSucc = false;
								
	public function __construct(Database $db) {
		$this->db = $db;
		if(isset($_POST['register'])) {
			$this->RegisterFromPost();
		}
	}
	
	private function RegisterFromPost() {
		if($this->checkPostData() && $this->pwMatchMinimum($_POST['user_pw']) && $this->isMail($_POST['user_email'])) {
			if(!$this->userExists($_POST['user_name']) && !$this->userExists($_POST['user_email'])) {
				$this->userData = array(
								'user_name'=>$_POST['user_name'], 
								'user_password_hash'=>$this->pwHash($_POST['user_pw']),
								'user_email'=>$_POST['user_email'],
								'user_key'=>$this->genKey(32),
								'user_unique_id'=>$this->uniqueID(),
								'user_registration'=>time());
				if(!$this->regMail) {
					$this->userData['user_activated'] = true;
				} else {
					$this->userData['user_activated'] = false;
				}
				
				if($this->db->insert('users', $this->userData)) {
					$this->db->insert('users_usergroups', array('user_ID'=>$this->db->getInsertId(), 'usergroup_ID'=>DEFAULT_USERGROUP));
					if($this->regMail) {
						$this->sendMail();	
					}
					$this->regSucc = true;
					$_SESSION['feedback_positive'][] = REGISTER_SUCCESS;
				} else {
					echo $this->db->getLastError();
					$_SESSION['feedback_negative'][] = REGISTER_DEFAULT_ERROR;
				}
			}
		}
	}
	
	private function checkPostData() {
		foreach($this->postRequired as $post => $name) {
			if(!isset($_POST[$post]) OR empty($_POST[$post])) {
				$_SESSION['feedback_negative'][] = $name.REGISTER_FIELD_MISSING;
				return false;
			}
		}
		
		if($_POST['user_pw'] != $_POST['user_pw_repeat']) {
			$_SESSION['feedback_negative'][] = REGISTER_PASSWORD_REPEAT_ERROR;
			return false;
		}
		
		if($_POST['user_email'] != $_POST['user_email_repeat']) {
			$_SESSION['feedback_negative'][] = REGISTER_EMAIL_REPEAT_ERROR;
			return false;
		}
		
		return true;
	}
	
	private function userExists($username) {
		$this->db->where('user_name', $username);
		$this->db->orWhere('user_email', $username);
		$ret = $this->db->getOne('users');
		if($this->db->count > 0) {
			$_SESSION['feedback_negative'][] = REGISTER_USER_EXISTS;
			return true;	
		}
		return false;
	}
	
	private function isMail($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);	
	}
	
	public function pwMatchMinimum($password) {
		foreach($this->pwRequired as $regex) {
			if(!preg_match('$['.$regex.']+$', $password)) {
				$_SESSION['feedback_negative'][] = REGISTER_PASSWORD_CRITERIA;
				return false;	
			}
		}
		return true;
	}
	
	public function pwHash($password) {
		return password_hash($password, PASSWORD_DEFAULT);	
	}
	
	private function genKey($length, $md5 = false) {
		if(function_exists('openssl_random_pseudo_bytes')) {
			$key = openssl_random_pseudo_bytes($length);
		} elseif(is_defined(MCRYPT_DEV_RANDOM)) {
			$key = mcrypt_create_iv($length, MCRYPT_DEV_RANDOM);	
		}
		
		if($md5) {
			$key = substr(md5($key), 0, $length);	
		}
		
		return $key;
	}
	
	private function uniqueID() {
		do {
			$parts = array();
			for($i=1;$i<=5;$i++) {
				$parts[] = $this->genKey(5, true);
			}
			$id = implode('-', $parts);
			$this->db->where('user_unique_id', $id);
		} while(count($this->db->getOne('users'))>0);
		return $id;
	}
	
	private function sendMail() {
		if(isset($this->userData['user_email'])) {
			$text = $this->prepareMailTmpl();
			$subject = "Registration on ".APPLICATION_NAME;
			$header = "From: ".REGISTER_EMAIL_FROM;
			if(mail($this->userData['user_email'], $subject, $text, $header)) {
				$_SESSION['feedback_positive'][] = REGISTER_EMAIL_SUCCESS;	
			} else {
				$_SESSION['feedback_negative'][] = REGISTER_EMAIL_ERROR;
			}
		} else {
			$_SESSION['feedback_negative'][] = REGISTER_EMAIL_ERROR;
		}
	}
	
	private function prepareMailTmpl() {
		if(isset($this->userData['user_name']) && ($tmpl = file_get_contents(URL.VIEWS_PATH.$this->mailTmpl))) {
			$tmpl = str_replace("{{USERNAME}}", $this->userData['user_name'], $tmpl);
			$tmpl = str_replace("{{APPLICATION_NAME}}", APPLICATION_NAME, $tmpl);
			$tmpl = str_replace("{{VERIFICATION_LINK}}", URL."Register/Activate/".$this->userData['user_unique_id'], $tmpl);
			return $tmpl;
		}
	}
	
	public function activateUser($uniqueId) {
		$this->db->where('user_unique_id', $uniqueId);
		$exist = $this->db->getOne('users');
		if(count($exist)>0) {
			if($exist['user_activated'] == false) {
				$this->db->where('user_unique_id', $uniqueId);
				if($this->db->update('users', array('user_activated'=>true))) {
					return true;	
				} else {
					return false;
				}
			} else {
				$_SESSION['feedback_neutral'][] = ALREADY_ACTIVATED_ERROR;
				return false;
			}
		} else {
			$_SESSION['feedback_warning'][] = USER_DOES_NOT_EXIST;
			return false;
		}
	}
}

?>