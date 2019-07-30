<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_kategori_upb extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('Kategori UPB');		
		$grid->setTable('plc2.plc2_upb_master_kategori_upb');		
		$grid->setUrl('master_kategori_upb');
		$grid->addList('vkategori','ldeleted');
		$grid->setSortBy('vkategori');
		$grid->setSortOrder('asc');
		$grid->addFields('vkategori','ldeleted');
		$grid->setLabel('vkategori', 'Kategori');
		$grid->setLabel('ldeleted','Aktif');
		$grid->setSearch('vkategori','ldeleted');
		//$grid->setRequired('vsediaan','Test UDT');
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
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));
    }
}