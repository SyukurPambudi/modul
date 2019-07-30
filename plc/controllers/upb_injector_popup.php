<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class upb_injector_popup extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->_field = $this->input->get('field');
		$this->_irefor = $this->input->get('irefor');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('upb_injector_popup');
		$grid->addList('pilih','vupb_nomor','vupb_nama','ttanggal');
		$grid->setSortBy('vupb_nomor');
		$grid->setSortOrder('DESC');
		$grid->setWidth('vupb_nomor', '100');
		$grid->setWidth('vupb_nama', '300');
		$grid->setWidth('ttanggal', '100');
		$grid->setWidth('pilih', '25');
		$grid->setLabel('vupb_nomor', 'No. Usulan');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('ttanggal', 'Tanggal Usulan');
		$grid->setSearch('vupb_nomor','vupb_nama');
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setAlign('ttanggal', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->setInputGet('irefor',$this->_irefor);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		
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

	function listBox_upb_injector_popup_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_std_popup(\''.$rowData->iupb_id.'\',\''.$rowData->vupb_nomor.'\') ;" />';
		$o.='<script>
				function pilih_upb_std_popup(iupb_id,vupb_nomor){
					custom_confirm("Yakin ?", function(){
						$("#id").val(iupb_id);
						$("#id_dis").val(vupb_nomor);
						$("#rkotak").html("-");
						$("#alert_dialog_form").dialog("close");
					});
				}
			</script>';
		return $o;
	}
}
