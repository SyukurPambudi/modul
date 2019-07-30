<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_divisi_struktur extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
    }
    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle('Stackholder Structure');		
		$grid->setTable('plc2.plc2_div_structure');		
		$grid->setUrl('master_divisi_struktur');
		$grid->addList('idplc2_div','vCode','vCaption');
		$grid->setSortBy('vCode');
		$grid->setSortOrder('ASC'); //sort ordernya
		$grid->setAlign('vCode', 'center'); //Align nya
		$grid->setAlign('idplc2_div', 'center'); //Align nya
		$grid->setWidth('idplc2_div', '100'); // width nya
		$grid->addFields('idplc2_div','vCode','vCaption','tCreatedAt','cCreatedBy','tUpdatedAt','cUpdatedBy');
		$grid->setLabel('idplc2_div', 'Code Stackholder'); //Ganti Label
		$grid->setLabel('vCode', 'Code Stackholder Structure'); //Ganti Label
		$grid->setLabel('vCaption','Caption Stackholder Structure');
		$grid->setSearch('idplc2_div','vCode','vCaption');
		$grid->setRequired('idplc2_div','vCode','vCaption');	//Field yg mandatori
		$grid->changeFieldType('tCreatedAt','hidden');
		$grid->changeFieldType('cCreatedBy','hidden');
		$grid->changeFieldType('tUpdatedAt','hidden');
		$grid->changeFieldType('cUpdatedBy','hidden');
		
		$grid->changeSearch('vCaption','between');
		//$grid->setQuery('isDeleted', 0);		
		$grid->setRelation('idplc2_div', 'plc2.plc2_div', 'idplc2_div', 'vCode','icName','inner');
		
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
				echo $grid->delete_form($this->input->get('id'));
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
