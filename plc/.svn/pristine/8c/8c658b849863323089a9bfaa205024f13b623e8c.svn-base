<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class master_jenis_panel extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('Jenis Panel');		
		$grid->setTable('plc2.plc2_upb_jenis_panel');		
		$grid->setUrl('master_jenis_panel');
		$grid->addList('vNmJenis','lDeleted');
		$grid->setSortBy('vNmJenis');
		$grid->setSortOrder('asc');
		$grid->addFields('vNmJenis','lDeleted');
		$grid->setLabel('vNmJenis', 'Jenis');
		$grid->setLabel('lDeleted','Aktif');
		$grid->setSearch('vNmJenis','lDeleted');
		//$grid->setRequired('vsediaan','Test UDT');
		$grid->changeFieldType('lDeleted', 'combobox', '', array(''=>'-', 0=>'Aktif', 1=>'Tidak Aktif'));
		
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
			default:
				$grid->render_grid();
				break;
		}
    }

    function before_insert_processor($row, $postData) {
		$postData['dcreate'] = date('Y-m-d H:i:s');
		$postData['cCreated'] =$this->user->gNIP;
		return $postData;

	}

	function before_update_processor($row, $postData) {
		$postData['dupdate'] = date('Y-m-d H:i:s');
		$postData['cUpdate'] =$this->user->gNIP;
		return $postData;

	}

	function output(){
    	$this->index($this->input->get('action'));
    }
}