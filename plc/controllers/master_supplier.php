<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class master_supplier extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle(' Supplier ');		
		$grid->setTable('hrd.mnf_supplier');		
		$grid->setUrl('master_supplier');
		$grid->addList('vnmsupp','valamat','ldeleted');
		$grid->setSortBy('vnmsupp');
		$grid->setSortOrder('asc');
		$grid->addFields('vnmsupp','valamat','valamat2','vzip');
		$grid->addFields('vkota','inegara_id','vtelp1','vtelp2','vfax','vcontact','vemail1','vemail2','vurl','ldeleted');
		$grid->setLabel('vnmsupp', 'Nama');
		$grid->setLabel('valamat', 'Alamat1');
		$grid->setLabel('valamat2', 'Alamat2');
		$grid->setLabel('vzip', 'Kode Pos');
		$grid->setLabel('vkota', 'Kota');
		$grid->setLabel('inegara_id', 'Negara');
		$grid->setLabel('vtelp1', 'Telp1');
		$grid->setLabel('vtelp2', 'Telp2');
		$grid->setLabel('vfax', 'Fax');
		$grid->setLabel('vemail1', 'Email1');
		$grid->setLabel('vemail2', 'Email2');
		$grid->setLabel('vurl', 'Website');
		$grid->setLabel('vcontact', 'Contact Person');
		$grid->setLabel('ldeleted','Aktif');
		$grid->setSearch('vnmsupp','vcontact','ldeleted');
		$grid->setRequired('vnmsupp','valamat');
		$grid->setRelation('inegara_id','hrd.mnf_negara','inegara_id','vnmnegara');
		$grid->changeFieldType('ldeleted', 'combobox', '', array(''=>'-', 0=>'Aktif', 1=>'Tidak Aktif'));
		$grid->changeFieldType('valamat2', 'text');
		
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

	function output(){
    	$this->index($this->input->get('action'));
	}
	
	function manipulate_update_button($buttons, $rowData){
		if($this->input->get("action")=="view"){
			unset($buttons["update"]);
		}
		return $buttons;
	}
}