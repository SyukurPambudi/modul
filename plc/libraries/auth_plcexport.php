<?php
class auth_plcexport { 	
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
		$sqlmgr = "SELECT COUNT(1) c FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0 and t.iTipe=2";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}
	function is_managerdept($dept) {
		$sqlmgr = "SELECT COUNT(1) c FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.vtipe='".$dept."'  and t.ldeleted=0 and t.iTipe=2";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}

	function is_managerdept_id($dept,$id) {
		$sqlmgr = "SELECT COUNT(1) c FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.vtipe='".$dept."' and t.iteam_id='".$id."'  and t.ldeleted=0 and t.iTipe=2";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}

	function is_dir() {
		$sqlmgr = "SELECT COUNT(1) c FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.cDeptId='DR' and t.ldeleted=0 and t.iTipe=2";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}
	function is_andev() {
		$sqlmgr = "SELECT COUNT(1) c FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.cDeptId='AD' and t.ldeleted=0 and t.iTipe=2";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}
	function is_bdirm() {
		$sqlmgr = "SELECT COUNT(1) c FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.cDeptId='BDI' and t.ldeleted=0 and t.iTipe=2";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}
	function team() {
		$return = array();
		$sqlmgr = "SELECT t.iteam_id FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0 and t.iTipe=2";
		$ms = $this->_ci->db->query($sqlmgr)->result_array();
		foreach($ms as $m) {
			$return['manager'][$m['iteam_id']] = $m['iteam_id'];
		}
		
		$sql = "SELECT t.iteam_id FROM plc2.plc2_upb_team_item t
			   	WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0";
		$us = $this->_ci->db->query($sql)->result_array();
		foreach($us as $m) {
			$return['team'][$m['iteam_id']] = $m['iteam_id'];
		}
		
		return $return;
	}
	function myteam_id() {
		
		$sql = "SELECT t.iteam_id FROM plc2.plc2_upb_team t
			   	WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0 and t.iTipe=2
				";
		$data = $this->_ci->db->query($sql)->row_array();
		if(count($data) > 0) {
			return $data['iteam_id'];
		}else{
			return 0;	
		}
		
		
	}
	function myteamdep_id($dep) {
		 

		$sql = "SELECT t.iteam_id FROM plc2.plc2_upb_team_item t
				 join plc2.plc2_upb_team h on h.iteam_id=t.iteam_id
				wHERE t.vnip = '".$this->sess_auth->gNIP."'  and h.vtipe ='".$dep."' and t.ldeleted=0 and h.ldeleted=0
				and t.iTipe=2
				";
		$data = $this->_ci->db->query($sql)->row_array();
		if(count($data) > 0) {
			return $data['iteam_id'];
		}else{
			return 0;	
		}
		
		
	}
	function myteam_item_id() {
		
		$sql = "SELECT t.iteam_id FROM plc2.plc2_upb_team_item t
			   	WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0 and t.iTipe=2
				";
		$data = $this->_ci->db->query($sql)->row_array();
		if(count($data) > 0) {
			return $data['iteam_id'];
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
		$sqlmgr = "SELECT t.cDeptId FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0 and t.iTipe=2";
		$ms = $this->_ci->db->query($sqlmgr)->result_array();
		foreach($ms as $m) {
			$return['manager'][$m['cDeptId']] = $m['cDeptId'];
		}
		
		$sql = "SELECT ut.cDeptId FROM plc2.plc2_upb_team_item t
				INNER JOIN plc2.plc2_upb_team ut ON t.iteam_id = ut.iteam_id
			   	WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0 and ut.iTipe=2";
		$us = $this->_ci->db->query($sql)->result_array();
		foreach($us as $m) {
			$return['team'][$m['cDeptId']] = $m['cDeptId'];
		}
		//return $ms
		return $return;
	}
	
	function tipe() {
		$return = array();
		$sqlmgr = "SELECT t.vtipe FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.iTipe=2";
		$ms = $this->_ci->db->query($sqlmgr)->result_array();
		foreach($ms as $m) {
			$return['manager'][$m['vtipe']] = $m['vtipe'];
		}
	
		$sql = "SELECT ut.vtipe FROM plc2.plc2_upb_team_item t
				INNER JOIN plc2.plc2_upb_team ut ON t.iteam_id = ut.iteam_id
			   	WHERE t.vnip = '".$this->sess_auth->gNIP."' and ut.iTipe=2";
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
	function prepare_mail($vkode){
		$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
		$dt=$this->_ci->db->query($sql)->row_array();
		return $dt;
	}

	function search_teamandev($id){
		$sql="select * from dossier.dossier_upd u where u.idossier_upd_id=".$id;
		$dt=$this->_ci->db->query($sql)->row_array();
		if($dt['is_old']){
			return '40';
		}else{
			return $dt['iTeam_andev'];
		}
	}
	
}
