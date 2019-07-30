<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_status extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('auth');
        $this->user = $this->auth->user();
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('Status Activity');		
		$grid->setTable('plc2.plc2_status');		
		$grid->setUrl('master_status');
		// $grid->addList('idplc2_activity','vCaption','iNilai','isActived');
		$grid->addList('idplc2_activity','vCaption','isActived');
		$grid->setSortBy('vCaption');
		$grid->setSortOrder('ASC');
		//$grid->setWidth('idplc_activity', '50');
		$grid->setWidth('iNilai', '75');
		$grid->setWidth('isActived', '75');
		// $grid->addFields('idplc2_activity','vCaption','iNilai','isActived','t1stCreatedAt','c1stCreatedBy','tUpdatedAt','cUpdatedBy');
		$grid->addFields('idplc2_activity','vCaption','isActived','t1stCreatedAt','c1stCreatedBy','tUpdatedAt','cUpdatedBy');
		$grid->setLabel('idplc2_activity', 'Activity');
		$grid->setLabel('vCaption', 'Status');
		// $grid->setLabel('iNilai', 'Nilai');
		$grid->setLabel('isActived', 'Aktif');
		$grid->setLabel('idplc2_activity', 'Activity');
		$grid->setSearch('idplc2_activity','vCaption','iNilai');
		$grid->setRequired('idplc2_activity','vCaption','iNilai');
		// $grid->setAlign('iNilai', 'right');
		$grid->setAlign('isActived', 'center');		
		$grid->setRelation('idplc2_activity', 'plc2.plc2_activity', 'idplc2_activity','vActivityName','activity_name','inner');
		$grid->changeFieldType('t1stCreatedAt','hidden');
		$grid->changeFieldType('c1stCreatedBy','hidden');
		$grid->changeFieldType('tUpdatedAt','hidden');
		$grid->changeFieldType('cUpdatedBy','hidden');
		$grid->changeFieldType('isActived','combobox', '', array(''=>'--Select--',1=>'Aktif',0=>'Tidak Aktif'));
		$grid->setQuery('plc2.plc2_status.isDeleted', 0);		
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
			//tambah delete
			case 'delete':
				echo $grid->delete_row();
			break;
			default:
				$grid->render_grid();
				break;
		}
    }
    // function insertBox_master_status_iNilai($field, $id) {
    	// $return = '<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1" size="7" onkeypress="return isNumberKey(event)"/>';
    	
    	// return $return;
    // }
    
    // function updateBox_master_status_iNilai($field, $id, $value) {
    	// $return = '<input type="text" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1" size="7" onkeypress="return isNumberKey(event)"/>';
    	
    	// return $return;
    // }
	function before_insert_processor($row, $postData) {
		//print_r($postData); exit;
		$postData['t1stCreatedAt'] = date('Y-m-d H:i:s');
		$postData['c1stCreatedBy'] =$this->user->gNIP;
		//$postData['c1stCreatedBy'] = $this->session->userdata('userID');
		return $postData;
	}
	function before_update_processor($row, $postData) {
		$postData['tUpdatedAt'] = date('Y-m-d H:i:s');
		$postData['cUpdatedBy'] =$this->user->gNIP;
		//$postData['cUpdatedBy'] = $this->session->userdata('userID');
		return $postData;
	}

	function output(){
    	$this->index($this->input->get('action'));
    }
}
