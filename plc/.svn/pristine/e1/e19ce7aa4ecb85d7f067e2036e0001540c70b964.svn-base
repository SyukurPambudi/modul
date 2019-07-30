<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_negara extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('Negara');		
		$grid->setTable('hrd.mnf_negara');		
		$grid->setUrl('master_negara');
		$grid->addList('vnegara','vnmnegara','ldeleted');
		$grid->setSortBy('vnegara');
		$grid->setSortOrder('desc');
		$grid->addFields('vnegara','vnmnegara','vkode','ldeleted');
		$grid->setLabel('vnegara', 'Kode Id');
		$grid->setLabel('vnmnegara', 'Nama Negara');
		$grid->setLabel('vkode', 'Kode');
		$grid->setLabel('ldeleted','Aktif');
		$grid->setSearch('vnegara','vnmnegara','ldeleted');
		$grid->setRequired('vnegara','vnmnegara','vkode','ldeleted');
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

	function before_insert_processor($row, $postData) {
		$now = date('Y-m-d H:i:s');
		$user = $this->auth->user();
		$postData['vnmnegara'] = strtoupper($postData['vnmnegara']);
		$postData['tupdate'] = $now;
		$postData['cnip'] = $user->gNIP;
		return $postData;
	}

	function before_update_processor($row, $postData) {
		$now = date('Y-m-d H:i:s');
		$user = $this->auth->user();
		$postData['vnmnegara'] = strtoupper($postData['vnmnegara']);
		$postData['tupdate'] = $now;
		$postData['cupdate'] = $user->gNIP;
		return $postData;
	}

	function output(){		
    	$this->index($this->input->get('action'));
    }
}