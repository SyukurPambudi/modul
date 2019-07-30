<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_raw_material extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('Raw Material');		
		$grid->setTable('plc2.plc2_raw_material');		
		$grid->setUrl('master_raw_material');
		$grid->addList('vraw','vnama','ldeleted');
		$grid->setSortBy('vraw');
		$grid->setSortOrder('desc');
		$grid->addFields('vraw','vnama','vsatuan','ldeleted');
		$grid->setLabel('vraw', 'Kode');
		$grid->setLabel('vnama', 'Nama Raw Material');
		$grid->setLabel('vsatuan', 'Satuan');
		$grid->setLabel('ldeleted','Aktif');
		$grid->setSearch('vraw','vnama','ldeleted');
		$grid->setRequired('vraw','vnama','vsatuan','ldeleted');
		$grid->changeFieldType('ldeleted', 'combobox', '', array(''=>'-', 0=>'Aktif', 1=>'Tidak Aktif'));
		
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

	function insertBox_master_raw_material_vraw($name, $id) {
		return 'this number would be generate automatically';
	}
	
	function updateBox_master_raw_material_vraw($name, $id, $value) {
		return '<input type="hidden" value="'.$value.'" name="'.$name.'" id="'.$id.'" />'.$value;
	}

	function before_insert_processor($row, $postData) {
		$now = date('Y-m-d H:i:s');
		$user = $this->auth->user();		
		$query = "select max(vraw) as std from plc2.plc2_raw_material";
		$rs = $this->db_plc0->query($query)->row_array();
		$nomor = intval($rs['std']) + 1;
		$nomor = str_pad($nomor, 5, "0", STR_PAD_LEFT);		
		$postData['vraw']=$nomor;		
		$postData['tupdate'] = $now;
		$postData['cnip'] = $user->gNIP;
		return $postData;
	}

	function before_update_processor($row, $postData) {
		$now = date('Y-m-d H:i:s');
		$user = $this->auth->user();
		$postData['tupdate'] = $now;
		$postData['cupdate'] = $user->gNIP;
		return $postData;
	}

	function output(){		
    	$this->index($this->input->get('action'));
    }
}