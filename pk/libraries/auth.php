<?php
class auth { 	
	private $_ci;
    private $sess_auth;

    function __construct() {
        $this->_ci=&get_instance();
        $this->_ci->load->library('Zend', 'Zend/Session/Namespace');
        $this->sess_auth = new Zend_Session_Namespace('auth');
        $this->resignDate = date('Y-m-d');
        $this->divisionId = null;
        $this->sortType = 'SORT_ASC';
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
	function is_holiday($date){
		//$sql = $this->db->query("SELECT * FROM hrd.holiday WHERE DDATE='$date'");
		$sql = "SELECT * FROM hrd.holiday WHERE DDATE='$date'";
		$query = $this->_ci->db->query( $sql );
		$ret = ($query->num_rows() > 0 ) ? TRUE : FALSE;
		return $ret;
	}
	function is_manager() {
		$sqlmgr = "SELECT COUNT(1) c FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}
	function is_managerdept($dept) {
		$sqlmgr = "SELECT COUNT(1) c FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.vtipe='".$dept."'  and t.ldeleted=0";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}

	function is_managerdept_id($dept,$id) {
		$sqlmgr = "SELECT COUNT(1) c FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.vtipe='".$dept."' and t.iteam_id='".$id."'  and t.ldeleted=0";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}

	function is_dir() {
		$sqlmgr = "SELECT COUNT(1) c FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.cDeptId='DR' and t.ldeleted=0";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}
	function is_bdirm() {
		$sqlmgr = "SELECT COUNT(1) c FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.cDeptId='BDI' and t.ldeleted=0";
		$ms = $this->_ci->db->query($sqlmgr)->row_array();
		return $ms['c'] > 0;
	}
	function team() {
		$return = array();
		$sqlmgr = "SELECT t.iteam_id FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0";
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
			   	WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0
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
			   	WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0
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
				   WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0";
		$ms = $this->_ci->db->query($sqlmgr)->result_array();
		foreach($ms as $m) {
			$return['manager'][$m['cDeptId']] = $m['cDeptId'];
		}
		
		$sql = "SELECT ut.cDeptId FROM plc2.plc2_upb_team_item t
				INNER JOIN plc2.plc2_upb_team ut ON t.iteam_id = ut.iteam_id
			   	WHERE t.vnip = '".$this->sess_auth->gNIP."' and t.ldeleted=0";
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
				   WHERE t.vnip = '".$this->sess_auth->gNIP."'";
		$ms = $this->_ci->db->query($sqlmgr)->result_array();
		foreach($ms as $m) {
			$return['manager'][$m['vtipe']] = $m['vtipe'];
		}
	
		$sql = "SELECT ut.vtipe FROM plc2.plc2_upb_team_item t
				INNER JOIN plc2.plc2_upb_team ut ON t.iteam_id = ut.iteam_id
			   	WHERE t.vnip = '".$this->sess_auth->gNIP."'";
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


    function setNip( $nip = null ) {
        $this->nip = $nip;
    }
    function setResignDate( $date = null ) {
        $date_ = strtotime($date);
        $this->resignDate = ($date_)?date('Y-m-d',$date_): null;
    }
    function setDivision( $division = null ) {
        if( is_array($division) && count($division) > 0 ) $this->divisionId = $division;
    }
    function setSortBy( $sortBy = null ) {
        $this->sortBy = $sortBy;
    }

	function getSelf($arrInf = array()) {
		
        $sql = "SELECT cNip, vName FROM hrd.employee WHERE cNip = '".$this->sess_auth->gNIP."'";

        $whereResign = ($this->resignDate) ? " AND ( dResign = '0000-00-00' OR dResign >= '$this->resignDate' ) ": "";
        $whereDivision = ($this->divisionId) ? " AND iDivisionID IN ( ".implode( ",", $this->sess_auth->gDivId )." ) ": "";

        $sql.= $whereResign;
        $sql.= $whereDivision;

      //  echo $sql;
        $us = $this->_ci->db->query($sql)->result_array();
        $rows = $this->_ci->db->query($sql)->result_array();
       // print_r($us);
        if( !empty($rows) ) {
        //	echo "ataaass";
            foreach($rows as $row) {
                $arrInf[] = array( 'cNip'=>$row['cNip'], 'vName'=>$row['vName'] );
            }
        }else{
        //	echo "bawaaah";
        }
       // print_r($arrInf);
        return $arrInf;
    }

    function getInferior( $nip = null, $arrInf = array() ) {
        $nip = ( is_array($nip) && count($nip) > 0 ) ? $nip : array( $this->nip );
        $sql = "SELECT cNip,vName, dResign FROM hrd.employee WHERE cUpper IN ('".implode("','",$nip)."')";

        $whereDivision = ($this->divisionId) ? " AND iDivisionID IN ( ".implode( ",", $this->divisionId )." ) ": "";

        $sql.= $whereDivision;

        
        $arrTmp = array();
        $query = $this->_ci->db->query( $sql );
        if( $query->num_rows() > 0 ) {
            $rows = $query->result_array();
            foreach($rows as $row) {
                $arrTmp[] = $row['cNip'];
                if ($this->resignDate ? $row['dResign']=='0000-00-00' || $row['dResign']>=$this->resignDate : TRUE) {
                    //$return['team'][$m['vtipe']] = $m['vtipe'];
                    $arrInf[] = array( 'cNip'=>$row['cNip'], 'vName'=>$row['vName'] );
                }
            }
        }

        if( count($arrTmp) > 0 ) {
        	//echo 'masuk sini';
            return $this->getInferior( $arrTmp, $arrInf );
        }else{
        	//echo "masuk dimari";
        } 

        if($this->sortBy) {
        	//echo "atas";
            return $this->multisort( $arrInf );
        } else {
        	//echo "bawah";
            return $arrInf;
        }
    }

    function multisort( $array = null ) {
        if(is_array($array) && count($array)>0) {
            $sortArray = array();

            foreach($array as $arr){
                foreach($arr as $key=>$value){
                    if(!isset($sortArray[$key])){
                        $sortArray[$key] = array();
                    }
                    $sortArray[$key][] = $value;
                }
            }

            array_multisort($sortArray[ $this->sortBy ],constant( $this->sortType ),$array); 

            return $array;
        }
    }


	
}
