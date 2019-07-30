<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_jenis_bahankemas extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('Jenis Bahan Kemas');		
		$grid->setTable('plc2.plc2_master_jenis_bk');		
		$grid->setUrl('master_jenis_bahankemas');
		$grid->addList('vjenis_bk','itipe_bk','ldeleted');
		$grid->setSortBy('itipe_bk');
		$grid->setSortOrder('asc');
		$grid->addFields('vjenis_bk','itipe_bk','ldeleted');
		$grid->setLabel('vjenis_bk', 'Jenis Bahan Kemas');
		$grid->setLabel('itipe_bk', 'Tipe Bahan Kemas');
		$grid->setLabel('ldeleted','Status');
		$grid->setSearch('vjenis_bk','itipe_bk','ldeleted');
		$grid->setRequired('vjenis_bk','itipe_bk','ldeleted');
		$grid->changeFieldType('ldeleted', 'combobox', '', array(''=>'-', 0=>'Aktif', 1=>'Tidak Aktif'));
		$grid->changeFieldType('itipe_bk', 'combobox', '', array(''=>'-', 1=>'Primer', 2=>'Sekunder', 3=>'Tersier'));
		
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
	function before_update_processor($row, $postData, $newUpdateData) {
		$user = $this->auth->user();
		$skrg = date('Y-m-d H:i:s');
		$postData['cnip']=$user->gNIP;
		$postData['tupdate']=$skrg;
		return $postData;
	}
	function output(){
    	$this->index($this->input->get('action'));
    }
}