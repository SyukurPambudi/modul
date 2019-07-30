<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Browse_mnf extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Bahan Baku');		
		$grid->setTable('hrd.mnf_manufacturer');		
		$grid->setUrl('browse_mnf');
		$grid->addList('vmanufacture','vnmmanufacture','vcontact','pilih');
		$grid->setSortBy('vnmmanufacture');
		$grid->setSortOrder('asc');
		$grid->setWidth('vmanufacture', '100');
		$grid->setWidth('vnmmanufacture', '370');
		$grid->setWidth('vcontact', '330');
		//$grid->setWidth('iteampd_id', '115');
		//$grid->setWidth('ikategoriupb_id', '120');
		//$grid->setWidth('ttanggal', '100');
		$grid->setWidth('pilih', '25');
		$grid->setLabel('vmanufacture', 'Kode');
		$grid->setLabel('vnmmanufacture', 'Nama');
		$grid->setLabel('vcontact', 'Contact Person');
		$grid->setSearch('vmanufacture','vnmmanufacture','vcontact');
		$grid->setAlign('vmanufacture', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field', $this->input->get('field'));
		$grid->setInputGet('col', $this->input->get('col'));
		$grid->setQuery('mnf_manufacturer.ldeleted', 0);		
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));
    }

	function listBox_browse_mnf_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_bb('.$pk.',\''.$rowData->vnmmanufacture.'\') ;" />
<script type="text/javascript">
	var ix = "'.$this->input->get('index').'";
	function pilih_bb (id, vnama) {					
		custom_confirm("Yakin", function() {
			$(".'.$this->input->get('col').'").eq(ix).val(id);
			$(".'.$this->input->get('col').'_dis").eq(ix).val(vnama);
			$("#alert_dialog_form").dialog("close");
		});
	}
</script>';
		//'.$pk.','.$rowData->cNamaSup.'
		return $o;
	}
}
