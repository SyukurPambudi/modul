<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Browse_po extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Permintaan Bahan Baku');		
		$grid->setTable('plc2.plc2_upb_po');		
		$grid->setUrl('browse_po');
		$grid->addList('vpo_nomor','trequest','pilih');
		$grid->setSortBy('vpo_nomor');
		$grid->setSortOrder('asc');
		$grid->setWidth('plc2_upb_po.vpo_nomor', '120');
		$grid->setWidth('pilih', '25');
		$grid->setSearch('vpo_nomor','trequest');
		$grid->setAlign('ijumlah', 'right');
		$grid->setAlign('plc2_upb_po.vpo_nomor', 'center');
		$grid->setAlign('plc2_upb_po.trequest', 'center');
		$grid->setAlign('pilih', 'center');
		// $grid->setLabel('plc2_upb_po.vpo_nomor', 'No. PO');
		// $grid->setLabel('plc2_upb_po.trequest', 'Tanggal PO');
		$grid->setLabel('vpo_nomor', 'No. PO');
		$grid->setLabel('trequest', 'Tanggal PO');
		$grid->setInputGet('field', $this->input->get('field'));
		$grid->setInputGet('col', $this->input->get('col'));
		$grid->setQuery('plc2_upb_po.ldeleted', 0);		
		$grid->setQuery('plc2_upb_po.iapppr', 2);
		$grid->setQuery('plc2.plc2_upb_po.ipo_id not in
		(select plc2_upb_ro.ipo_id from plc2.plc2_upb_ro)',null);
		
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

	function listBox_browse_po_plc2_upb_po_trequest($value) {
		return date('d M Y', strtotime($value));
	}

	function listBox_browse_po_pilih($value, $pk, $name, $rowData) {
		$f = $this->input->get('col') ? $this->input->get('field').'_'.$this->input->get('col') : $this->input->get('field').'_vpo_nomor';
		$fd = $this->input->get('col') ? $this->input->get('field').'_'.$this->input->get('col').'_dis' : $this->input->get('field').'_vpo_nomor_dis';
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_bb('.$pk.',\''.$rowData->vpo_nomor.'\') ;" />
				<script type="text/javascript">
					var ix = "'.$this->input->get('index').'";
					function pilih_bb (id, nama) {					
						custom_confirm("Yakin", function() {
							$("#'.$f.'").val(id);
							$("#'.$fd.'").val(nama);
							$("#alert_dialog_form").dialog("close");
						});
					}
				</script>';
		//'.$pk.','.$rowData->cNamaSup.'
		return $o;
	}
}
