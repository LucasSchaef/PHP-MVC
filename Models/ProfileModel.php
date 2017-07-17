<?php

class ProfileModel {
	private $db;
	
	
	public function __construct(Database $db) {
		$this->db = $db;
	}
	
}

?>