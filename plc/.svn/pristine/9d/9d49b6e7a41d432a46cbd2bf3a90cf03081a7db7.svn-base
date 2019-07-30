<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_kategori_produk extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('Kategori Produk');		
		$grid->setTable('hrd.mnf_kategori');		
		$grid->setUrl('master_kategori_produk');
		$grid->addList('vkategori','ldeleted');
		$grid->setSortBy('vkategori');
		$grid->setSortOrder('asc');
		$grid->addFields('vkategori','ldeleted');
		//$grid->addFields('vkategori','itarget_prareg','itarget_hpr','itarget_registrasi','itarget_noreg','ldeleted');
		$grid->setLabel('vkategori', 'Kategori');
		// $grid->setLabel('itarget_prareg','Target Prareg');
		// $grid->setLabel('itarget_hpr','Target Terima HPR');
		// $grid->setLabel('itarget_registrasi','Target Registrasi');
		// $grid->setLabel('itarget_noreg','Target Terima No. Registrasi');
		$grid->setLabel('ldeleted','Status');
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