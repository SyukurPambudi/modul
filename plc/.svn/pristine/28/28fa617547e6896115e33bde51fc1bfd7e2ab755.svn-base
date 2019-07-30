<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_divisi extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->user = $this->auth->user(); 
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Stakeholder');		
		$grid->setTable('plc2.plc2_upb_team');		
		$grid->setUrl('master_divisi');
		$grid->addList('vteam','vnip','cDeptId','iStatus');
		$grid->setSortBy('vteam');
		$grid->setSortOrder('asc'); //sort ordernya
		$grid->setWidth('vnip', '100'); // width nya
		$grid->addFields('vteam','vnip','cDeptId','iStatus','team');
		$grid->setLabel('vnip', 'Manager'); //Ganti Label
		$grid->setLabel('vteam','Nama Team');
		$grid->setLabel('cDeptId','Departemen');
		$grid->setLabel('iStatus','Status');
		$grid->setSearch('vteam','vnip','cDeptId','iStatus');
		$grid->setRequired('vteam','vnip','cDeptId','iStatus');	//Field yg mandatori
		$grid->setQuery('ldeleted', 0);
		$grid->setDeletedKey('ldeleted');
		
		$grid->changeFieldType('iStatus','combobox','',array(''=>'Pilih',1=>'Aktif',0=>'Tidak aktif'));
	//	$grid->changeFieldType('iapprove','combobox','',array(''=>'Pilih',1=>'Ya',0=>'Tidak'));
	//	$grid->setMultiSelect(true);
		
		//Set View Gridnya (Default = grid)
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				
				echo $grid->saved_form();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }

	function searchBox_master_divisi_vteam($name, $id) {
		return '<input id="'.$id.'" type="text" />';
	}

	function insertCheck_master_divisi_vteam($value, $field, $rows) {
		$this->db_plc0->where('vteam', $value);
		$j = $this->db_plc0->count_all_results('plc2.plc2_upb_team');
		if($j > 0) {
			return 'Nama Team '.$value.' sudah ada yg insert!';
		} 
		else {
			return TRUE;
		}
	}

	function insertBox_master_divisi_team($field, $id) {
		// $this->load->config('plc_config');
		// $conf_level = $this->config->item('plc_level');
		// $level = '<select name="iLevel[]" class="master_divisi_iLevel">';
		// $level .= '<option value="">--select--</option>';
		// foreach($conf_level as $d) {
			// $level .= '<option value="'.$d.'">'.$d.'</option>';
		// }
		// $level .= '</select>';
		// $data['level'] = $level;
		
		return $this->load->view('master_divisi_team_struktur_member','',TRUE);
	}
	
	function updateBox_master_divisi_team($field, $id, $value, $rowData) {		
		$rowId = $rowData['iteam_id'];
		$this->db_plc0->select(array('plc2.plc2_upb_team_item.*', 'hrd.employee.vName'), false);
		$this->db_plc0->where(array('iteam_id' => $rowId, 'plc2.plc2_upb_team_item.ldeleted' => 0));
		$this->db_plc0->order_by('plc2.plc2_upb_team_item.iteami_id', 'ASC');
		$this->db_plc0->join('hrd.employee', 'plc2.plc2_upb_team_item.vnip = hrd.employee.cNip', 'inner');
		$data['member'] = $this->db_plc0->get('plc2.plc2_upb_team_item')->result_array();
		
		// $this->load->config('plc_config');
		// $conf_level = $this->config->item('plc_level');
		// $level = '<select name="iLevel[]" class="master_divisi_iLevel">';
		// $level .= '<option value="">--select--</option>';
		// foreach($conf_level as $d) {
			// $level .= '<option value="'.$d.'">'.$d.'</option>';
		// }
		// $level .= '</select>';
		// $data['level'] = $level;
		
		return $this->load->view('master_divisi_team_struktur_member',$data,TRUE); 
	}
	
	function insertBox_master_divisi_cDeptId($field, $id) {
		$this->load->config('plc_config');
		$conf_dept = $this->config->item('plc_dept');
		$return = '<select name="'.$id.'" id="'.$id.'">';
		$return .= '<option value="">--select--</option>';
		foreach($conf_dept as $d) {
			$return .= '<option value="'.$d.'">'.$d.'</option>';
		}
		$return .= '</select>';
		return $return;
	}
	
	function updateBox_master_divisi_cDeptId($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') { 
            $sql='select * from plc2.plc2_upb_team a where a.iteam_id="'.$rowData['iteam_id'].'" ';
            //echo $sql;
            $data = $this->db->query($sql)->row_array();
            //print_r($rowData) ;
            return $data['vtipe'];
            
        }else{
        	$this->load->config('plc_config');
			$conf_dept = $this->config->item('plc_dept');
			$return = '<select name="'.$id.'" id="'.$id.'">';
			$return .= '<option value="">--select--</option>';
			foreach($conf_dept as $d) {
			$selected = $value == $d ? 'selected' : '';
			$return .= '<option '.$selected.' value="'.$d.'">'.$d.'</option>';
			}

			$return .= '</select>';
			return $return;

        }

		
	}
	
	function searchBox_master_divisi_cDeptId($field, $id) {
		$this->load->config('plc_config');
		$conf_dept = $this->config->item('plc_dept');
		$return = '<select name="'.$id.'" id="'.$id.'">';
		$return .= '<option value="">--select--</option>';
		foreach($conf_dept as $d) {
			$return .= '<option value="'.$d.'">'.$d.'</option>';
		}
		$return .= '</select>';
		return $return;
	}
	
	function before_insert_processor($row, $postData) {
		$user = $this->auth->user();
		unset($postData['nip']);
		unset($postData['name']);
		//unset($postData['iLevel']);
		unset($postData['team']);
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = date('Y-m-d H:i:s');
		return $postData;
	}
	
	function after_insert_processor ($row, $insertId, $postData) {
        	$user = $this->auth->user();
			$nip = $postData['nip'];
			$varIpprove = $postData['iapprove'];
			//$level = $postData['iLevel'];		
			foreach($nip as $k => $v) {
			$this->db_plc0->insert('plc2.plc2_upb_team_item', array('iteam_id'=>$insertId,'vnip'=>$v,'iapprove'=>$varIpprove[$k],'iLevel'=>0,'ccreated'=>$user->gNIP,'tcreated'=>date('Y-m-d H:i:s')));
			//$this->db_plc0->insert('plc2.plc2_upb_team_item', array('iteam_id'=>$insertId,'vnip'=>$v,'iLevel'=>$level[$k],'ccreated'=>$user->gNIP,'tcreated'=>date('Y-m-d H:i:s')));
		}
			return TRUE;
	

        }

		/*$user = $this->auth->user();
		$nip = $postData['nip'];
		$varIpprove = $postData['iapprove'];
		//$level = $postData['iLevel'];		
		foreach($nip as $k => $v) {
			$this->db_plc0->insert('plc2.plc2_upb_team_item', array('iteam_id'=>$insertId,'vnip'=>$v,'iapprove'=>$varIpprove[$k],'iLevel'=>0,'ccreated'=>$user->gNIP,'tcreated'=>date('Y-m-d H:i:s')));
			//$this->db_plc0->insert('plc2.plc2_upb_team_item', array('iteam_id'=>$insertId,'vnip'=>$v,'iLevel'=>$level[$k],'ccreated'=>$user->gNIP,'tcreated'=>date('Y-m-d H:i:s')));
		}
		return TRUE;
	}*/
	
	function before_update_processor($row, $postData) {
		//print_r($postData);
		$user = $this->auth->user();
		unset($postData['nip']);
		unset($postData['name']);
		//unset($postData['iLevel']);
		unset($postData['team']);
		$postData['cupdate'] = $user->gNIP;
		$postData['tupdate'] = date('Y-m-d H:i:s');
		return $postData;
	}
	
	function after_update_processor ($row, $updateId, $postData) {
		$user = $this->auth->user();
		$nip = $postData['nip'];
		$varIpprove = $postData['iapprove'];
		//$level = $postData['iLevel'];
		$this->db_plc0->where('iteam_id', $updateId);
		if($this->db_plc0->update('plc2.plc2_upb_team_item', array('ldeleted'=>1,'cupdated'=>$user->gNIP,'tupdated'=>date('Y-m-d H:i:s')))) {
			foreach($nip as $k => $v) {
				$this->db_plc0->insert('plc2.plc2_upb_team_item', array('iteam_id'=>$updateId,'vnip'=>$v,'iapprove'=>$varIpprove[$k],'iLevel'=>'','ccreated'=>$user->gNIP,'tcreated'=>date('Y-m-d H:i:s')));
				//$this->db_plc0->insert('plc2.plc2_upb_team_item', array('iteam_id'=>$updateId,'vnip'=>$v,'iLevel'=>$level[$k],'ccreated'=>$user->gNIP,'tcreated'=>date('Y-m-d H:i:s')));
			}
		}
		return TRUE;
	}

	function employee_list() {
		$term = $this->input->get('term');
		$return_arr = array();
		$this->db_plc0->like('cNip',$term);
		$this->db_plc0->or_like('vName',$term);
		$this->db_plc0->limit(50);
		$lines = $this->db_plc0->get('hrd.employee')->result_array();
		$i=0;
		foreach($lines as $line) {
			$row_array["value"] = trim($line["vName"]).' - '.trim($line["cNip"]);
			$row_array["id"] = trim($line["cNip"]);
			array_push($return_arr, $row_array);
		}
		echo json_encode($return_arr);exit();
	}
	
    function output(){
    	$this->index($this->input->get('action'));
    }


    public function listBox_Action($row, $actions) {
    	$teamid= $row->iteam_id;
    	

//		unset($actions['edit']);
//		unset($actions['view']);
//		unset($actions['delete']);
		if($this->auth->is_manager()   ){
			$x=$this->auth->team();
			$manager=$x['manager'];
			if(in_array($teamid, $manager)  ){
				
				
			}else{
				unset($actions['edit']);
			}
			
			
		}else if($this->user->gDivId == 6){



		}else{
			unset($actions['edit']);
		}


		return $actions;
		
    }




	function manipulate_update_button($buttons) {
        if ($this->input->get('action') == 'view') {unset($buttons['update']);}

        else{

        }
        return $buttons;
    }


}