<?php

class CompanyModel {
	private $db;
	
	public function __construct(Database $db) {
		$this->db = $db;
	}
	
	public function createCompanyList() {
		$comp = $this->db->get("companies");
		return mkCrudList($comp, array("ID", "Company Name"), "company_unique_ID");
	}
}

?>