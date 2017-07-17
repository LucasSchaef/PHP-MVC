<?php
class loginModel {
	private $db;
	public $loggedin = false;
	private $maxTries = 5;
	private $waitingTime = 10; // in Minutes
	
	
	public function __construct(Database $db) {
		$this->db = $db;
		if(!$this->isLoggedIn()) {
			if(isset($_POST['login'])) {
				$this->loginFromPostData();
			} elseif(isset($_COOKIE[PREFIX.'user_id'])) {
				$this->loginFromCookieData();
			} 
		} elseif(isset($_GET['logout'])) {
			$this->logout();
		}
	}
	
	public function isLoggedIn() {
		if(isset($_SESSION[PREFIX.'user_id']) && !empty($_SESSION[PREFIX.'user_id'])) {
			if(isset($_SESSION[PREFIX.'logged_in']) && !empty($_SESSION[PREFIX.'logged_in'])) {
				$this->loggedin = true;
				return true;
			}
		}
		return false;
	}
	
	private function loginFromPostData() {
		if($this->checkFormData()) {
			$this->db->where('user_name', $_POST['user_name']);
			$this->db->orWhere('user_email', $_POST['user_name']);
			$user = $this->db->getOne('users');
			if(count($user)>0) {
				if($this->checkLoginCount($user)) {
					if($this->verifyPW($_POST['user_password'], $user['user_password_hash'])) {
						$this->setLoginCount($user['user_unique_ID'], true);
						$_SESSION[PREFIX.'user_id'] = $user['user_unique_ID'];
						$_SESSION[PREFIX.'logged_in'] = true;
						$this->loggedin = true;
						if(isset($_POST['user_remember'])) {
							$this->remember($user);	
						}
					} else {
						$this->setLoginCount($user['user_unique_ID']);
						$_SESSION['feedback_negative'][] = LOGIN_FAILED;
						return false;
					}
				} else {
					$until = date("g:i:s A", (time()+($this->waitingTime*60)));
					$_SESSION['feedback_negative'][] = LOGIN_TO_MANY_TRIES.$until."!";
					return false;	
				}
			} else {
				$_SESSION['feedback_negative'][] = LOGIN_FAILED;
				return false;	
			}
		} else {
			return false;	
		}
	}
	
	private function remember(array $user) {
		$rem_time = time();
		$update = array('user_remember'=>TRUE, 'user_remember_time'=>$rem_time);
		$this->db->where('user_unique_ID', $user['user_unique_ID']);
		$this->db->update('users', $update);
		
		setcookie(PREFIX.'user_id', $user['user_unique_ID']);
		setcookie(PREFIX.'logged_in', TRUE);
	}
	
	private function verifyPW($password, $hash) {
		return password_verify($password, $hash);
	}
	
	private function checkFormData() {
		if(isset($_POST['user_name']) && empty($_POST['user_name'])) {
			$_SESSION['feedback_negative'][] = "Username".LOGIN_FIELD_EMPTY;	
			return false;
		}
		
		if(isset($_POST['user_password']) && empty($_POST['user_password'])) {
			$_SESSION['feedback_negative'][] = "Password".LOGIN_FIELD_EMPTY;
			return false;
		}
		
		return true;
	}
	
	private function SessHash($data, $key) {
		return mcrypt_encrypt(HASH_ALGO, $key, $data, HASH_TYPE);
	}
	
	private function SessUnHash($hash, $key) {
		return mcrypt_decrypt(HASH_ALGO, $key, $hash, HASH_TYPE);
	}
	
	private function getLoginCount($uniqueId) {
		$this->db->where('user_unique_ID', $uniqueId);
		$info = $this->db->getOne('users');
		return $info['user_login_count'];
	}
	
	private function setLoginCount($uniqueId, $to_zero = false) {
		if($to_zero) {
			$count = 0;
		} else {
			$count = $this->getLoginCount($uniqueId)+1;
		}
		$update = array('user_login_count'=>$count, 'user_last_login_try'=>time());
		$this->db->where('user_unique_ID', $uniqueId);
		return $this->db->update('users', $update);
	}
	
	private function checkLoginCount($user) {
		$lastTry = (time()-$user['user_last_login_try'])/60;
		if($user['user_login_count']>$this->maxTries) {
			if($lastTry > $this->waitingTime) {
				$this->setLoginCount($user['user_unique_ID'], true);
				return true;
			} else {
				return false;
			}
		}
		return true;
	}
	
}

?>