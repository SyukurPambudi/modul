<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_request_batch extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Batch');		
		$grid->setTable('kanban.kbn_mbr');		
		$grid->setUrl('browse_request_batch');
		$grid->addList('pilih','vBatch_no','vNama','vKode_obat');
		$grid->setSortBy('kbn_mbr.vBatch_no');
		$grid->setSortOrder('DESC');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setWidth('pilih', '55');
		$grid->setAlign('pilih', 'center');
		$grid->setSearch('vBatch_no','vNama','vKode_obat');

		$grid->setLabel('vNama','Nama Produk');
		$grid->setLabel('vKode_obat','Kode Produk');
		$grid->setLabel('vBatch_no','No Batch');
		$grid->setWidth('vNama', '300');
		$grid->setWidth('vBatch_no', '100');
		$grid->setWidth('vKode_obat', '100');

		$grid->setQuery('iDeleted = 0 ', null); 
		$grid->setQuery('vBatch_no <> "" ', null); 

		$grid->setSortBy('dTanggal_mbr');
        $grid->setSortOrder('DESC');  



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
    	$this->index($this->input->get('action'));//test komen
    }

    

	function listBox_browse_request_batch_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->vBatch_no.'\',\''.$rowData->vNama.'\') ;" />
<script type="text/javascript">
		function pilih_upb_detail (id, vBatch_no,vNama){					
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_vbatch_no_dis").val(vBatch_no+" - "+vNama);
				$("#'.$this->input->get('field').'_vbatch_no").val(vBatch_no);
				$("#alert_dialog_form").dialog("destroy");
			});
		}
		</script>';
		return $o;
	}
}
