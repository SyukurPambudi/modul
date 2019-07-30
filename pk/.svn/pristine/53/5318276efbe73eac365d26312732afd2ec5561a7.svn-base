<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class master_notifikasi extends MX_Controller { 
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
		$grid->setTitle('Master Notifikasi');		
		$grid->setTable('plc2.notifikasi_h');		
		$grid->setUrl('master_notifikasi');
		$grid->addList('vNama', 'vSubject','lDeleted');
		$grid->setSortBy('id');
		$grid->setSortOrder('desc'); //sort ordernya
		$grid->setWidth('vNama', '150'); // width nya
		$grid->addFields('vNama','vSubject','To', 'Cc', 'vTemplate');
		
		$grid->setLabel('vNama','Nama Notifikasi');
		$grid->setLabel('vSubject','Subject');
		$grid->setLabel('vTemplate','Template Notifikasi');
		$grid->setLabel('lDeleted','Status');
		
		$grid->setSearch('vNama','vSubject','lDeleted');
		$grid->setRequired('vNama','vTemplate');	//Field yg mandatori
		$grid->setQuery('ldeleted', 0);
		$grid->setDeletedKey('ldeleted');
		
		$grid->changeFieldType('lDeleted','combobox','',array(''=>'Pilih',0=>'Aktif',1=>'Tidak aktif'));
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
	function searchBox_master_notifikasi_vNama($name, $id) {
		return '<input id="'.$id.'" type="text" />';
	}

	function insertCheck_master_notifikasi_vNama($value, $field, $rows) {
		$this->db_plc0->where('vNama', $value);
		$j = $this->db_plc0->count_all_results('plc2.notifikasi_h');
		if($j > 0) {
			return 'Nama Notifikasi '.$value.' sudah ada yg insert!';
		} 
		else {
			return TRUE;
		}
	}

	function insertBox_master_notifikasi_To($field, $id) {
		// $this->load->config('plc_config');
		// $conf_level = $this->config->item('plc_level');
		// $level = '<select name="iLevel[]" class="master_notifikasi_iLevel">';
		// $level .= '<option value="">--select--</option>';
		// foreach($conf_level as $d) {
			// $level .= '<option value="'.$d.'">'.$d.'</option>';
		// }
		// $level .= '</select>';
		// $data['level'] = $level;
		
		return $this->load->view('v_master_notifikasi','',TRUE);
	}
	function insertBox_master_notifikasi_Cc($field, $id) {
		// $this->load->config('plc_config');
		// $conf_level = $this->config->item('plc_level');
		// $level = '<select name="iLevel[]" class="master_notifikasi_iLevel">';
		// $level .= '<option value="">--select--</option>';
		// foreach($conf_level as $d) {
			// $level .= '<option value="'.$d.'">'.$d.'</option>';
		// }
		// $level .= '</select>';
		// $data['level'] = $level;
		
		return $this->load->view('v_master_notifikasi_cc','',TRUE);
	}
	
	function insertBox_master_notifikasi_vTemplate($field, $id) {
        $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250"></textarea>';
        return $return;
    }

	function updateBox_master_notifikasi_To($field, $id, $value, $rowData) {		
		$rowId = $rowData['id'];
		$this->db_plc0->select(array('plc2.notifikasi_d.*', 'hrd.employee.vName'), false);
		$this->db_plc0->where(array('iHeader_Id' => $rowId, 'plc2.notifikasi_d.lDeleted' => 0, 'plc2.notifikasi_d.iTipe' => 1));
		$this->db_plc0->order_by('plc2.notifikasi_d.id', 'ASC');
		$this->db_plc0->join('hrd.employee', 'plc2.notifikasi_d.vNip = hrd.employee.cNip', 'inner');
		$data['member'] = $this->db_plc0->get('plc2.notifikasi_d')->result_array();
		
		// $this->load->config('plc_config');
		// $conf_level = $this->config->item('plc_level');
		// $level = '<select name="iLevel[]" class="master_divisi_iLevel">';
		// $level .= '<option value="">--select--</option>';
		// foreach($conf_level as $d) {
			// $level .= '<option value="'.$d.'">'.$d.'</option>';
		// }
		// $level .= '</select>';
		// $data['level'] = $level;
		
		return $this->load->view('v_master_notifikasi',$data,TRUE); 
	}
	function updateBox_master_notifikasi_Cc($field, $id, $value, $rowData) {		
		$rowId = $rowData['id'];
		$this->db_plc0->select(array('plc2.notifikasi_d.*', 'hrd.employee.vName'), false);
		$this->db_plc0->where(array('iHeader_Id' => $rowId, 'plc2.notifikasi_d.lDeleted' => 0, 'plc2.notifikasi_d.iTipe' => 2));
		$this->db_plc0->order_by('plc2.notifikasi_d.id', 'ASC');
		$this->db_plc0->join('hrd.employee', 'plc2.notifikasi_d.vNip = hrd.employee.cNip', 'inner');
		$data['member'] = $this->db_plc0->get('plc2.notifikasi_d')->result_array();
		
		// $this->load->config('plc_config');
		// $conf_level = $this->config->item('plc_level');
		// $level = '<select name="iLevel[]" class="master_divisi_iLevel">';
		// $level .= '<option value="">--select--</option>';
		// foreach($conf_level as $d) {
			// $level .= '<option value="'.$d.'">'.$d.'</option>';
		// }
		// $level .= '</select>';
		// $data['level'] = $level;
		
		return $this->load->view('v_master_notifikasi_cc',$data,TRUE); 
	}
	
	
	function before_insert_processor($row, $postData) { 
		$user = $this->auth->user();
		unset($postData['nip']);
		unset($postData['iTipe']);
		//unset($postData['iLevel']);
		unset($postData['To']);
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = date('Y-m-d H:i:s');
		return $postData; 
	}
	
    function after_insert_processor ($row, $insertId, $postData) { 
        	$user = $this->auth->user();
			$nip = $postData['nip'];
			$nipcc = $postData['nipcc'];
			//$varIpprove = $postData['iapprove'];
			//$level = $postData['iLevel'];
			//$level = $postData['iLevel'];
			foreach($nip as $k => $v) {
				$this->db_plc0->insert('plc2.notifikasi_d', array('iHeader_Id'=>$insertId,'vNip'=>$v,'iTipe'=>1,'cCreated'=>$user->gNIP,'dCreate'=>date('Y-m-d H:i:s')));
			
			}

			foreach($nipcc as $k => $v) {
				$this->db_plc0->insert('plc2.notifikasi_d', array('iHeader_Id'=>$insertId,'vNip'=>$v,'iTipe'=>2,'cCreated'=>$user->gNIP,'dCreate'=>date('Y-m-d H:i:s')));
			
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
		unset($postData['nipcc']);
		//unset($postData['iLevel']);
		unset($postData['Nama']);
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = date('Y-m-d H:i:s');
		return $postData;
	}
	
	function after_update_processor ($row, $updateId, $postData) {
		$user = $this->auth->user();
		$nip = $postData['nip'];
		$nipcc = $postData['nipcc'];
		//$nipcc = $postData['nipcc'];
		//$varIpprove = $postData['iapprove'];
		//$level = $postData['iLevel'];
		$this->db_plc0->where('iHeader_Id', $updateId);
		if($this->db_plc0->update('plc2.notifikasi_d', array('lDeleted'=>1,'cUpdate'=>$user->gNIP,'dupdate'=>date('Y-m-d H:i:s')))) {
			foreach($nip as $k => $v) {
				$this->db_plc0->insert('plc2.notifikasi_d', array('iHeader_Id'=>$updateId,'vNip'=>$v,'iTipe'=>1,'cCreated'=>$user->gNIP,'dCreate'=>date('Y-m-d H:i:s')));
				//$this->db_plc0->insert('plc2.plc2_upb_team_item', array('iteam_id'=>$updateId,'vnip'=>$v,'iLevel'=>$level[$k],'ccreated'=>$user->gNIP,'tcreated'=>date('Y-m-d H:i:s')));
			}
			foreach($nipcc as $k => $v) {
				$this->db_plc0->insert('plc2.notifikasi_d', array('iHeader_Id'=>$updateId,'vNip'=>$v,'iTipe'=>2,'cCreated'=>$user->gNIP,'dCreate'=>date('Y-m-d H:i:s')));
			
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

/*
    public function listBox_Action($row, $actions) {
    	$teamid= $row->id;
    	

		if($this->auth->is_manager()   ){
			$x=$this->auth->Nama();
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
		
    }*/




	function manipulate_update_button($buttons) {
        if ($this->input->get('action') == 'view') {unset($buttons['update']);}

        else{

        }
        return $buttons;
    }


}