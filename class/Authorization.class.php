<?php
class Authorization {
	public static function loggedIn() {
		if(isset($_SESSION[PREFIX.'logged_in'])) {
			return true;
		} else {
			return false;	
		}
	}
}
?>