<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_po_export extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List PO');		
		$grid->setTable('reformulasi.export_po');		
		$grid->setUrl('browse_po_export');
		$grid->addList('pilih','vpo_nomor','trequest','isupplier_id');
		$grid->setSortBy('export_po.ipo_id');
		$grid->setSortOrder('DESC');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setWidth('pilih', '55');
		$grid->setAlign('pilih', 'center');
		$grid->setSearch('vpo_nomor','trequest','isupplier_id');

		$grid->setLabel('trequest','Tgl Request');
		$grid->setLabel('isupplier_id','Supplier');
		$grid->setLabel('vpo_nomor','No PO');
		$grid->setWidth('trequest', '300');
		$grid->setWidth('vpo_nomor', '100');
		$grid->setWidth('isupplier_id', '100');

		$grid->setQuery('export_po.ldeleted = 0 ', null); 
		$grid->setQuery('vpo_nomor <> "" ', null); 

		$grid->setQuery('export_po.ipo_id not in (select ro.ipo_id 
													from reformulasi.export_ro ro 
													where ro.ldeleted=0 ) ', null); 
		

        $grid->setRelation('isupplier_id','hrd.mnf_supplier','isupplier_id','vnmsupp','','inner',array('ldeleted'=>0),array('vnmsupp'=>'asc'));


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

    

	function listBox_browse_po_export_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->vpo_nomor.'\',\''.$rowData->trequest.'\',\''.$rowData->isupplier_id.'\',\''.$rowData->vnmsupp.'\') ;" />
<script type="text/javascript">
		function pilih_upb_detail (id, vpo_nomor,trequest,isupplier_id,vnmsupp){					
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_ipo_id_dis").val(vpo_nomor);
				$("#'.$this->input->get('field').'_ipo_id").val(id);
				$("#'.$this->input->get('field').'_isupplier_id").val(isupplier_id);
				$("#'.$this->input->get('field').'_isupplier_id_dis").text(vnmsupp);
				
				

				$("#alert_dialog_form").dialog("destroy");
			});
		}
		</script>';
		return $o;
	}
}
