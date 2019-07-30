<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class plc_master_divisi extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Stackholder');		
		$grid->setTable('plc_div');		
		$grid->setUrl('plc_master_divisi');
		$grid->addList('vCode','vCaption');
		$grid->setSortBy('vCode');
		$grid->setSortOrder('ASC'); //sort ordernya
		$grid->setAlign('vCode', 'center'); //Align nya
		$grid->setWidth('vCode', '100'); // width nya
		$grid->addFields('vCode','vCaption','tCreatedAt','cCreatedBy','tUpdatedAt','cUpdatedBy');
		$grid->setLabel('vCode', 'Code Stackholder'); //Ganti Label
		$grid->setLabel('vCaption','Caption Stackholder');
		$grid->setSearch('vCode','vCaption');
		$grid->setRequired('vCode','vCaption');	//Field yg mandatori
		$grid->changeFieldType('tCreatedAt','hidden');
		$grid->changeFieldType('cCreatedBy','hidden');
		$grid->changeFieldType('tUpdatedAt','hidden');
		$grid->changeFieldType('cUpdatedBy','hidden');
		$grid->setQuery('isDeleted', 0);
		
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