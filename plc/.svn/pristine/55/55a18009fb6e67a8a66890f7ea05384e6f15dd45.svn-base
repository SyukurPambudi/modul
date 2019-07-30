<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_divisi_team extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
    }
    function index($action = '') {
    	$grid = new Grid('plc');
    	set_db('plc', true);
		$grid->setTitle('Stackholder Structure');		
		$grid->setTable('plc2.plc2_div_team');		
		$grid->setUrl('master_divisi_team');
		$grid->addList('idplc2_div','vName');
		$grid->setSortBy('vName');
		$grid->setSortOrder('ASC');
		$grid->setWidth('idplc2_div', '100');
		$grid->addFields('idplc2_div','vName','tCreatedAt','cCreatedBy','tUpdatedAt','cUpdatedBy');
		$grid->setLabel('idplc2_div', 'Code Stackholder');
		$grid->setLabel('vName', 'Stackholder Team');
		$grid->setSearch('idplc2_div','vName');
		$grid->setRequired('idplc2_div','vName');
		$grid->changeFieldType('tCreatedAt','hidden');
		$grid->changeFieldType('cCreatedBy','hidden');
		$grid->changeFieldType('tUpdatedAt','hidden');
		$grid->changeFieldType('cUpdatedBy','hidden');
		//$grid->setQuery('isDeleted', 0);		
		$grid->setRelation('idplc2_div', 'plc2.plc2_div', 'idplc2_div', 'vCode','','inner');
		
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
			default:
				$grid->render_grid();
				break;
		}
    }
	function output(){
    	$this->index($this->input->get('action'));
    }
}