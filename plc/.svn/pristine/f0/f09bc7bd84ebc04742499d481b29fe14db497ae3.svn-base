<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_activity extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('Activity');		
		$grid->setTable('plc2.plc2_activity');		
		$grid->setUrl('master_activity');
		$grid->addList('idplc2_activity','vActivityName');
		$grid->setSortBy('vActivityName');
		$grid->setSortOrder('ASC');
		$grid->setWidth('idplc2_activity', '50');
		$grid->addFields('vActivityName','tCreatedAt','cCreatedBy','tUpdatedAt','cUpdatedBy');
		$grid->setLabel('vActivityName', 'Activity Name');
		$grid->setLabel('idplc2_activity', 'Activity ID');
		$grid->setSearch('vActivityName');
		$grid->setRequired('vActivityName');
		$grid->setAlign('idplc_activity', 'center');
		$grid->changeFieldType('tCreatedAt','hidden');
		$grid->changeFieldType('cCreatedBy','hidden');
		$grid->changeFieldType('tUpdatedAt','hidden');
		$grid->changeFieldType('cUpdatedBy','hidden');
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
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));
    }
}
