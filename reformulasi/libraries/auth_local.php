<?php
class auth_local { 	
	private $_ci;
    private $sess_auth;
    function __construct() {
        $this->_ci=&get_instance();
        $this->_ci->load->library('Zend', 'Zend/Session/Namespace');
        $this->sess_auth = new Zend_Session_Namespace('auth');
    }
    function user() {
		return $this->sess_auth;
	}
	function struktur() {
		$sql = "SELECT s.idplc2_div_structure FROM plc2.plc2_div_team_member m
				INNER JOIN plc2.plc2_div_team_structure s ON m.idplc2_div_team_structure = s.idplc2_div_team_structure  
				WHERE m.cNip = '".$this->sess_auth->gNIP."'
				";
		$u = $this->_ci->db->query($sql)->row_array();
		if(count($u) > 0) {
			return $u['idplc2_div_structure'];
		}
		return 0;
	}
	function is_manager() {
		$sqlmgr = "SELECT COUNT(1) c FROM reformulasi.reformulasi_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0 and t.iTipe=1";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}
	function is_managerdept($dept) {
		$sqlmgr = "SELECT COUNT(1) c FROM reformulasi.reformulasi_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.vtipe='".$dept."'  and t.ldeleted=0 and t.iTipe=1";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}

	function is_managerdept_id($dept,$id) {
		$sqlmgr = "SELECT COUNT(1) c FROM reformulasi.reformulasi_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.vtipe='".$dept."' and t.ireformulasi_team='".$id."'  and t.ldeleted=0 and t.iTipe=1";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}

	function is_dir() {
		$sqlmgr = "SELECT COUNT(1) c FROM reformulasi.reformulasi_team t
					join reformulasi.reformulasi_master_departement rmd on rmd.ireformulasi_master_departement=t.cDeptId
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' 
				   and rmd.vkode_departement='DR' and t.ldeleted=0 and t.iTipe=1";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}
	function is_andev() {
		$sqlmgr = "SELECT COUNT(1) c FROM reformulasi.reformulasi_team t
				   join reformulasi.reformulasi_master_departement rmd on rmd.ireformulasi_master_departement=t.cDeptId
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and rmd.vkode_departement='AD' and t.ldeleted=0 and t.iTipe=1";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}
	function is_bdirm() {
		$sqlmgr = "SELECT COUNT(1) c FROM reformulasi.reformulasi_team t
					join reformulasi.reformulasi_master_departement rmd on rmd.ireformulasi_master_departement=t.cDeptId
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and rmd.vkode_departement='BDI' and t.ldeleted=0 and t.iTipe=1";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}
	function team() {
		$return = array();
		$sqlmgr = "SELECT t.ireformulasi_team FROM reformulasi.reformulasi_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0 and t.iTipe=1";
		$ms = $this->_ci->db->query($sqlmgr)->result_array();
		foreach($ms as $m) {
			$return['manager'][$m['ireformulasi_team']] = $m['ireformulasi_team'];
		}
		
		$sql = "SELECT t.ireformulasi_team FROM reformulasi.reformulasi_team_item t
				join reformulasi.reformulasi_team te on te.ireformulasi_team=t.ireformulasi_team
			   	WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0 and te.iTipe=1";
		$us = $this->_ci->db->query($sql)->result_array();
		foreach($us as $m) {
			$return['team'][$m['ireformulasi_team']] = $m['ireformulasi_team'];
		}
		
		return $return;
	}
	function myteam_id() {
		
		$sql = "SELECT t.ireformulasi_team FROM reformulasi.reformulasi_team t
			   	WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0 and t.iTipe=1
				";
		$data = $this->_ci->db->query($sql)->row_array();
		if(count($data) > 0) {
			return $data['ireformulasi_team'];
		}else{
			return 0;	
		}
		
		
	}
	function myteamdep_id($dep) {
		 

		$sql = "SELECT t.ireformulasi_team FROM reformulasi.reformulasi_team_item t
				 join reformulasi.reformulasi_team h on h.ireformulasi_team=t.ireformulasi_team
				wHERE t.vnip = '".$this->sess_auth->gNIP."'  and h.vtipe ='".$dep."' and t.ldeleted=0 and h.ldeleted=0
				and t.iTipe=1
				";
		$data = $this->_ci->db->query($sql)->row_array();
		if(count($data) > 0) {
			return $data['ireformulasi_team'];
		}else{
			return 0;	
		}
		
		
	}
	function myteam_item_id() {
		
		$sql = "SELECT t.ireformulasi_team FROM reformulasi.reformulasi_team_item t
			   	WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0 and t.iTipe=1
				";
		$data = $this->_ci->db->query($sql)->row_array();
		if(count($data) > 0) {
			return $data['ireformulasi_team'];
		}else{
			return 0;	
		}
		
		
	}
	function my_teams($as_array = FALSE) {
		if($as_array == TRUE) {
			$teams = $this->team();
			$my_teams = '';			
			$i = 1;
			if(!empty($teams['manager'])) {
				foreach($teams['manager'] as $k => $m) {
					$my_teams[] = $m;							
				}
			}
			if(!empty($teams['team'])) {
				foreach($teams['team'] as $k => $m) {
					$my_teams[] = $m;			
				}
			}
			return $my_teams;
		}
		else {
			$teams = $this->team();
			$mteams = '';
			$tteams = '';
			$i = 1;
			if(!empty($teams['manager'])) {
				$i = 1;
				foreach($teams['manager'] as $k => $m) {
					if($i==1) {
						$mteams .= $m;
					}
					else {
						$mteams .= ','.$m;
					}
					$i++;		
				}
			}
			if(!empty($teams['team'])) {
				$i = 1;
				foreach($teams['team'] as $k => $m) {
					if($i==1) {
						$tteams .= $m;
					}
					else {
						$tteams .= ','.$m;
					}
					$i++;			
				}
			}
			$tteams = $tteams == '' ? 0 : $tteams;
			$mteams = $mteams == '' ? 0 : $mteams;
			return $tteams.','.$mteams;
		}
	}
	function dept() {
		$return = array();
		$sqlmgr = "SELECT rmd.vkode_departement FROM reformulasi.reformulasi_team t
					join reformulasi.reformulasi_master_departement rmd on rmd.ireformulasi_master_departement=t.cDeptId
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0 and t.iTipe=1";
		$ms = $this->_ci->db->query($sqlmgr)->result_array();
		foreach($ms as $m) {
			$return['manager'][$m['vkode_departement']] = $m['vkode_departement'];
		}
		
		$sql = "SELECT rmd.vkode_departement FROM reformulasi.reformulasi_team_item t
				INNER JOIN reformulasi.reformulasi_team ut ON t.ireformulasi_team = ut.ireformulasi_team
				join reformulasi.reformulasi_master_departement rmd on rmd.ireformulasi_master_departement=ut.cDeptId
			   	WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0 and ut.iTipe=1";
		$us = $this->_ci->db->query($sql)->result_array();
		foreach($us as $m) {
			$return['team'][$m['vkode_departement']] = $m['vkode_departement'];
		}
		//return $ms
		return $return;
	}
	
	function tipe() {
		$return = array();
		$sqlmgr = "SELECT t.vtipe FROM reformulasi.reformulasi_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.iTipe=1";
		$ms = $this->_ci->db->query($sqlmgr)->result_array();
		foreach($ms as $m) {
			$return['manager'][$m['vtipe']] = $m['vtipe'];
		}
	
		$sql = "SELECT ut.vtipe FROM reformulasi.reformulasi_team_item t
				INNER JOIN reformulasi.reformulasi_team ut ON t.ireformulasi_team = ut.ireformulasi_team
			   	WHERE t.vnip = '".$this->sess_auth->gNIP."' and ut.iTipe=1";
		$us = $this->_ci->db->query($sql)->result_array();
		foreach($us as $m) {
			$return['team'][$m['vtipe']] = $m['vtipe'];
		}
		//return $ms
		return $return;
	}
	
	function my_tipes($as_array = FALSE) {
		if($as_array == TRUE) {
			$teams = $this->tipe();
			$my_depts = '';
			$i = 1;
			if(!empty($teams['manager'])) {
				foreach($teams['manager'] as $k => $m) {
					$my_depts[] = $m;
				}
			}
			if(!empty($teams['team'])) {
				foreach($teams['team'] as $k => $m) {
					$my_depts[] = $m;
				}
			}
			return $my_depts;
		}
		else {
			$teams = $this->tipe();
			$mteams = '';
			$tteams = '';
			$i = 1;
			if(!empty($teams['manager'])) {
				$i = 1;
				foreach($teams['manager'] as $k => $m) {
					if($i==1) {
						$mteams .= $m;
					}
					else {
						$mteams .= ','.$m;
					}
					$i++;
				}
			}
			if(!empty($teams['team'])) {
				$i = 1;
				foreach($teams['team'] as $k => $m) {
					if($i==1) {
						$tteams .= $m;
					}
					else {
						$tteams .= ','.$m;
					}
					$i++;
				}
			}
			$tteams = $tteams == '' ? 0 : $tteams;
			$mteams = $mteams == '' ? 0 : $mteams;
			return $tteams.','.$mteams;
		}
	}
	
	function my_depts($as_array = FALSE) {
		if($as_array == TRUE) {
			$teams = $this->dept();
			$my_depts = '';			
			$i = 1;
			if(!empty($teams['manager'])) {
				foreach($teams['manager'] as $k => $m) {
					$my_depts[] = $m;							
				}
			}
			if(!empty($teams['team'])) {
				foreach($teams['team'] as $k => $m) {
					$my_depts[] = $m;			
				}
			}
			return $my_depts;
		}
		else {
			$teams = $this->dept();
			$mteams = '';
			$tteams = '';
			$i = 1;
			if(!empty($teams['manager'])) {
				$i = 1;
				foreach($teams['manager'] as $k => $m) {
					if($i==1) {
						$mteams .= $m;
					}
					else {
						$mteams .= ','.$m;
					}
					$i++;		
				}
			}
			if(!empty($teams['team'])) {
				$i = 1;
				foreach($teams['team'] as $k => $m) {
					if($i==1) {
						$tteams .= $m;
					}
					else {
						$tteams .= ','.$m;
					}
					$i++;			
				}
			}
			$tteams = $tteams == '' ? 0 : $tteams;
			$mteams = $mteams == '' ? 0 : $mteams;
			return $tteams.','.$mteams;
		}
	}
	
}
