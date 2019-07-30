<?php
class User_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	function get_user_info($cnip) {
		$this->dbset = $this->load->database('hrd', true);
		$sql = "SELECT e.*, d.vDescription divisi FROM employee e
				LEFT JOIN msdivision d ON e.iDivID = d.iDivID 
				WHERE e.cNip = '".$cnip."'";
		return $this->dbset->query($sql)->row_array();
	}
}
