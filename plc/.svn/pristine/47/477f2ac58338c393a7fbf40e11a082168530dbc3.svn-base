<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_divisi_team_struktur extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
    }
    function index($action = '') {
    	$grid = new Grid;
    	$grid->setTitle('Stackholder Team Structure');
		$grid->setTable('plc2.plc2_div_team_structure');
		$grid->setUrl('master_divisi_team_struktur');
		$grid->addList('idplc2_div_structure','idplc2_div_team','vName','iSuperior');
		$grid->setSortBy('idplc2_div_structure');
		$grid->setSortOrder('ASC');
		$grid->addFields('idplc2_div_team','idplc2_div_structure','vName','iSuperior','member','tCreatedAt','cCreatedBy','tUpdatedAt','cUpdatedBy');
		$grid->setLabel('idplc2_div_team', 'Stackholder Team');
		$grid->setLabel('idplc2_div_structure', 'Stakeholder Structure');
		$grid->setLabel('vName', 'Stackholder Team Structure Name');
		$grid->setLabel('iSuperior', 'Superior');
		$grid->setSearch('idplc2_div_team','idplc2_div_structure','vName','iSuperior');
		$grid->setRequired('idplc2_div_team','idplc2_div_structure','vName');
		$grid->changeFieldType('tCreatedAt','hidden');
		$grid->changeFieldType('cCreatedBy','hidden');
		$grid->changeFieldType('tUpdatedAt','hidden');
		$grid->changeFieldType('cUpdatedBy','hidden');
		//$grid->setQuery('isDeleted', 0);
		//$grid->setRelation('idplc2_div_team', 'plc2.plc2_div_team', 'idplc2_div_team', 'vName','divName','INNER','isDeleted=0','vName=ASC');
		$grid->setRelation('idplc2_div_structure', 'plc2.plc2_div_structure', 'idplc2_div_structure', 'vCaption','divStrukName','INNER','isDeleted=0','vCaption=ASC');
		//$grid->setPopUp('member', 'div_structure', 'idplc_div_structure', 'vCaption','divStrukName','INNER','isDeleted=0','vCaption=ASC');
		
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
			
			case 'member':
				$this->member_popup();
				break;
			case 'employee_list':
				$this->employee_list();
			default:
				//echo '<pre>';print_r($grid->pre_render_grid());echo '</pre>';
				$grid->render_grid();
				break;
		}
		/*if($this->uri->segment(5)) {
			$this->member_popup('json');
		}*/
    }
    
    function listBox_master_divisi_team_struktur_idplc2_div_team($value) {
    	$sql = "SELECT * FROM plc2.plc2_div_team t LEFT JOIN plc2.plc2_div d
    			ON t.idplc2_div = d.idplc2_div WHERE t.idplc2_div_team = '".$value."'";
    	$name = $this->db_plc0->query($sql)->row_array();
    	return $name['vName'].' > '.$name['vCaption'];
    }
    
    function searchBox_master_divisi_team_struktur_idplc2_div_team($fields, $id) {
    	$echo = '<select id="'.$id.'">';
    	$echo .= '<option value="">-- None --</option>';
    	
    	$sql = "SELECT * FROM plc2.plc2_div_team t LEFT JOIN plc2.plc2_div d
    			ON t.idplc2_div = d.idplc2_div WHERE t.isDeleted = 0 ORDER BY t.vName";
    	$users = $this->db_plc0->query($sql)->result_array();
    	
    	foreach($users as $u) {
    		$echo .= '<option value="'.$u['idplc2_div_team'].'">'.$u['vName'].' > '.$u['vCaption'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }
    
    function insertBox_master_divisi_team_struktur_idplc2_div_team($field, $id) {
    	$echo = '<select name="'.$field.'" id="'.$id.'">';
    	$echo .= '<option value="">-- None --</option>';
    	$sql = "SELECT * FROM plc2.plc2_div_team t LEFT JOIN plc2.plc2_div d
    			ON t.idplc2_div = d.idplc2_div WHERE t.isDeleted = 0 ORDER BY t.vName";
    	$users = $this->db_plc0->query($sql)->result_array();
    	foreach($users as $u) {
    		$echo .= '<option value="'.$u['idplc2_div_team'].'">'.$u['vName'].' > '.$u['vCaption'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }
    
    function updateBox_master_divisi_team_struktur_idplc2_div_team($field, $id, $value) {
    	$echo = '<select name="'.$field.'" id="'.$id.'">';
    	$echo .= '<option value="">-- None --</option>';
    	$sql = "SELECT * FROM plc2.plc2_div_team t LEFT JOIN plc2.plc2_div d
    			ON t.idplc2_div = d.idplc2_div WHERE t.isDeleted = 0 ORDER BY t.vName";
    	$users = $this->db_plc0->query($sql)->result_array();
    	foreach($users as $u) {
    		$selected = $u['idplc2_div_team'] == $value ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$u['idplc2_div_team'].'">'.$u['vName'].' > '.$u['vCaption'].'</option>';    		
    	}
    	$echo .= '</select>';
    	return $echo;
    }

	function listBox_master_divisi_team_struktur_iSuperior($value) {
		if($value != 0) {
			$new_value = $this->db_plc0->get_where('plc2.plc2_div_team_structure', array('idplc2_div_team_structure' => $value))->row_array();
			return $new_value['vName'];
		}
		else {
			return 'NONE';
		}
	}
	function searchBox_master_divisi_team_struktur_iSuperior($fields, $id) {
		$echo = '<select id="'.$id.'">';
		$echo .= '<option value="">-- None --</option>';
		$this->db_plc0->where('isDeleted', 0);
		$this->db_plc0->order_by('vName', 'ASC');
		$users = $this->db_plc0->get('plc2.plc2_div_team_structure')->result_array();
		foreach($users as $u) {
			$echo .= '<option value="'.$u['idplc2_div_team_structure'].'">'.$u['vName'].'</option>';
		}		
		$echo .= '</select>';
		return $echo;
	}
	function insertBox_master_divisi_team_struktur_iSuperior($field, $id) {
		$echo = '<select name="'.$field.'" id="'.$id.'">';
		$echo .= '<option value="">-- None --</option>';
		$this->db_plc0->where('isDeleted', 0);
		$this->db_plc0->order_by('vName', 'ASC');
		$users = $this->db_plc0->get('plc2.plc2_div_team_structure')->result_array();
		foreach($users as $u) {
			$echo .= '<option value="'.$u['idplc2_div_team_structure'].'">'.$u['vName'].'</option>';
		}		
		$echo .= '</select>';
		return $echo;
	}
	function updateBox_master_divisi_team_struktur_iSuperior($field, $id, $value) {
		$echo = '<select name="'.$field.'" id="'.$id.'">';
		$echo .= '<option value="">-- None --</option>';
		$this->db_plc0->where('isDeleted', 0);
		$this->db_plc0->order_by('vName', 'ASC');
		$users = $this->db_plc0->get('plc2.plc2_div_team_structure')->result_array();
		foreach($users as $u) {
			$selected = $u['idplc2_div_team_structure'] == $value ? 'selected' : '';
			$echo .= '<option '.$selected.' value="'.$u['idplc2_div_team_structure'].'">'.$u['vName'].'</option>';
		}		
		$echo .= '</select>';
		return $echo;
	}
	function insertBox_master_divisi_team_struktur_member($field, $id) {
		return $this->load->view('master_divisi_team_struktur_member','',TRUE);
	}
	function updateBox_master_divisi_team_struktur_member($field, $id, $value, $rowData) {
		$rowId = $rowData['idplc2_div_team_structure'];
		$this->db_plc0->select(array('plc2.plc2_div_team_member.*', 'hrd.employee.vName'), false);
		$this->db_plc0->where(array('idplc2_div_team_structure' => $rowId, 'plc2.plc2_div_team_member.isDeleted' => 0));
		$this->db_plc0->order_by('plc2.plc2_div_team_member.idplc2_div_team_member', 'ASC');
		$this->db_plc0->join('hrd.employee', 'plc2.plc2_div_team_member.cNip = hrd.employee.cNip', 'inner');
		$data['member'] = $this->db_plc0->get('plc2.plc2_div_team_member')->result_array();
		return $this->load->view('master_divisi_team_struktur_member',$data,TRUE); 
	}
	function employee_list() {
		$term = $this->input->get('term');
		$return_arr = array();
		$this->db_plc0->like('cNip',$term);
		$this->db_plc0->or_like('vName',$term);
		$this->db_plc0->limit(50);
		$lines = $this->db_plc0->get('employee')->result_array();
		$i=0;
		foreach($lines as $line) {
			$row_array["value"] = trim($line["vName"]).' - '.trim($line["cNip"]);
			$row_array["id"] = trim($line["cNip"]);
			array_push($return_arr, $row_array);
		}
		echo json_encode($return_arr);exit();
	}
	function member_popup($action = 'index') {
		$grid = new Grid;		
		$grid->setTitle('Employee');
		$grid->setTable('employee');
		$grid->setUrl('master_divisi_team_struktur/index/member');
		$grid->addList('cNip','vName','vNickName');
		$grid->setSortBy('vName');
		$grid->setSortOrder('ASC');
		$grid->addFields('cNip','vName','vNickName');
		$grid->setLabel('cNip', 'NIP');
		$grid->setLabel('vName', 'Name');
		$grid->setLabel('vNickName', 'Nick Name');
		//$grid->setSearch('cNip','vName','vNickName');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;
			case 'member':
				$this->member_popup('json');
				break;
			
			default:
				//echo '<pre>';print_r($grid->pre_render_grid());echo '</pre>';
				$grid->render_grid();
				break;
		}
	}
	function before_insert_processor ($row, $postData) {
		unset($postData['nip']);
		unset($postData['name']);
		return $postData;
	}
	function after_insert_processor ($row, $insertId, $postData) {
		$nip = $postData['nip'];
		foreach($nip as $v) {
			$this->db_plc0->insert('plc2.plc2_div_team_member', array('idplc2_div_team_structure'=>$insertId,'cNip'=>$v));
		}
		return TRUE;
	}
	function before_update_processor ($row, $postData) {
		unset($postData['nip']);
		unset($postData['name']);
		return $postData;
	}
	function after_update_processor ($row, $updateId, $postData) {
		$nip = $postData['nip'];		
		$this->db_plc0->where('idplc2_div_team_structure', $updateId);
		if($this->db_plc0->update('plc2.plc2_div_team_member', array('isDeleted'=>1))) {
			foreach($nip as $v) {
				$this->db_plc0->insert('plc2.plc2_div_team_member', array('idplc2_div_team_structure'=>$updateId,'cNip'=>$v));
			}
		}
		return TRUE;
	}
	function output(){
    	$this->index($this->input->get('action'));
    }
}