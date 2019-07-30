<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_bisnis_proses_type extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('Business Process Type');		
		$grid->setTable('plc2.plc2_biz_process_type');		
		$grid->setUrl('master_bisnis_proses_type');
		$grid->addList('vName');
		//$grid->addList('vName','isDynamic');
		$grid->setSortBy('vName');
		$grid->setSortOrder('ASC'); //sort ordernya
		$grid->addFields('vName','tCreatedAt','bussiness_step','cCreatedBy','tUpdatedAt','cUpdatedBy');
		// $grid->addFields('vName','isDynamic','tCreatedAt','bussiness_step','cCreatedBy','tUpdatedAt','cUpdatedBy');
		$grid->setLabel('vName', 'Type Name'); //Ganti Label
		// $grid->setLabel('isDynamic','Dynamic');
		$grid->setLabel('bussiness_step','Business Step');
		$grid->setSearch('vName');
		// $grid->setSearch('vName','isDynamic');
		$grid->setRequired('vName');	//Field yg mandatori
		$grid->changeFieldType('tCreatedAt','hidden');
		$grid->changeFieldType('cCreatedBy','hidden');
		$grid->changeFieldType('tUpdatedAt','hidden');
		$grid->changeFieldType('cUpdatedBy','hidden');
		// $grid->changeFieldType('isDynamic','combobox','',array('' => '--Pilih--', 0=>'No',1=>"Yes"));
		$grid->setQuery('isDeleted', 0);
		$grid->setDeletedKey('isDeleted');
		
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
			case 'delete':
				echo $grid->delete_row();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }
	function insertBox_master_bisnis_proses_type_bussiness_step($field, $id) {
		$this->db_plc0->where('isDeleted', 0);
		$this->db_plc0->order_by('idplc2_biz_has_steps', 'ASC');
		$steps = $this->db_plc0->get('plc2.plc2_biz_has_steps')->result_array();
		foreach($steps as $s) {
			$st[] = array('idplc2_biz_has_steps'=>$s['idplc2_biz_has_steps'],'vStepName'=>$s['vStepName'],'selected'=>'');
		}
		$data['steps'] = $st;
		return $this->load->view('master_bisnis_proses_type/step_proses',$data,TRUE);
	}
	function updateBox_master_bisnis_proses_type_bussiness_step($field, $id, $value, $rowData) {
		$rowId = $rowData['idplc2_biz_process_type'];
		$this->db_plc0->where(array('isDeleted'=>0, 'idplc2_biz_process_type'=>$rowId));
		$this->db_plc0->order_by('iUrutan', 'ASC');
		$proses = $this->db_plc0->get('plc2.plc2_biz_process')->result_array();
		
		$this->db_plc0->where('isDeleted', 0);
		$this->db_plc0->order_by('idplc2_biz_has_steps', 'ASC');
		$steps = $this->db_plc0->get('plc2.plc2_biz_has_steps')->result_array();
		
		foreach($steps as $s) {
			$step[$s['idplc2_biz_has_steps']] = $s['vStepName'];
		}
		$st = array();
		foreach($proses as $pro) {
			if(array_key_exists($pro['idplc2_biz_has_steps'], $step)) {
				$st[$pro['idplc2_biz_has_steps']] = array('idplc2_biz_has_steps'=>$pro['idplc2_biz_has_steps'],'vStepName'=>$step[$pro['idplc2_biz_has_steps']],'selected'=>'selected');
			}
		}
		foreach($step as $s => $v) {
			if(!array_key_exists($s, $st)) {
				$st[$s] = array('idplc2_biz_has_steps'=>$s,'vStepName'=>$v,'selected'=>'');
			}
		}
		//echo '<pre>';print_r($st);echo '</pre>';
		$data['steps'] = $st;
		return $this->load->view('master_bisnis_proses_type/step_proses',$data,TRUE);
	}
	
	function after_insert_processor ($row, $insertId, $postData) {
		$steps = $postData['steps'];
		$i=1;
		foreach($steps as $v) {
			$this->db_plc0->insert('plc2.plc2_biz_process', array('idplc2_biz_process_type'=>$insertId,'idplc2_biz_has_steps'=>$v,'iUrutan'=>$i,'tCreatedAt'=>date('Y-m-d H:i:s'), 'cCreatedBy'=>$this->sess_auth->get_nip()));
			$i++;
		}
		return TRUE;
	}

	function after_update_processor ($row, $updateId, $postData, $old_data) {
		$this->db_plc0->where('idplc2_biz_process_type', $updateId);
		$bis = $this->db_plc0->get('plc2.plc2_biz_process')->result_array();
		$bp = array();
		foreach($bis as $b) {
			$bp[$b['idplc2_biz_has_steps']] = $b;
		}		
		$steps = $postData['steps'];
		//print_r($postData);
		$i = 1;
		foreach($steps as $k => $v) {
			if(array_key_exists($v, $bp)) {
				$this->db_plc0->where('idplc2_biz_process', $bp[$v]['idplc2_biz_process']);
				if($this->db_plc0->update('plc2.plc2_biz_process', array('iUrutan'=>$i, 'isDeleted'=>0, 'tUpdatedAt'=>date('Y-m-d H:i:s'), 'cUpdatedBy'=>$this->sess_auth->get_nip()))) {}
			}
			else {
				$this->db_plc0->insert('plc2.plc2_biz_process', array('idplc2_biz_process_type'=>$updateId,'idplc2_biz_has_steps'=>$v, 'iUrutan'=>$i,'tCreatedAt'=>date('Y-m-d H:i:s'), 'cCreatedBy'=>$this->sess_auth->get_nip(), 'tUpdatedAt'=>date('Y-m-d H:i:s'), 'cUpdatedBy'=>$this->sess_auth->get_nip()));
			}
			$i++;
		}
		//print_r($bp);
		//print_r($steps);
		//yg ada di kiri itu yg isDeleted=1
		foreach($bp as $k => $v) {
			if(!in_array($k, $steps)) {
				$this->db_plc0->where('idplc2_biz_process', $v['idplc2_biz_process']);
				$this->db_plc0->update('plc2.plc2_biz_process', array('isDeleted'=>1, 'tUpdatedAt'=>date('Y-m-d H:i:s'), 'cUpdatedBy'=>$this->sess_auth->get_nip()));
			}
		}
		return TRUE;
	}
	function output(){
    	$this->index($this->input->get('action'));
    }
}