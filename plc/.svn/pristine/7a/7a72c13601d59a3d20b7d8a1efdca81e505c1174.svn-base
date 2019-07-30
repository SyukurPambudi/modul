<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_standar_mutu extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('Standar Mutu');		
		$grid->setTable('plc2.plc2_upb_master_dokumen_sm');		
		$grid->setUrl('master_standar_mutu');
		$grid->addList('vdokumen','ldeleted');
		$grid->setSortBy('vdokumen');
		$grid->setSortOrder('asc');
		$grid->addFields('vdokumen','ldeleted');
		$grid->setLabel('vdokumen', 'Dokumen');
		$grid->setLabel('ldeleted','Status');
		$grid->setSearch('vdokumen','ldeleted');
		$grid->setRequired('vdokumen','ldeleted');
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

	function output(){
    	$this->index($this->input->get('action'));
    }
}