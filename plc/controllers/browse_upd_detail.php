<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_upd_detail extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPD');		
		$grid->setTable('dossier.dossier_upd');		
		$grid->setUrl('browse_upd_detail');
		$grid->addList('pilih','vUpd_no','vNama_usulan','cNip_pengusul','dTanggal_upd');
		$grid->setSortBy('vUpd_no');
		$grid->setSortOrder('DESC');
		$grid->setWidth('vUpd_no', '55');
		$grid->setLabel('vUpd_no', 'No. UPD');
		$grid->setLabel('vNama_usulan', 'Nama Usulan');
		$grid->setWidth('cNip_pengusul', '150');
		$grid->setLabel('cNip_pengusul', 'Pengusul');
		$grid->setWidth('dTanggal_upd', '150');
		$grid->setLabel('dTanggal_upd', 'Tanggal UPD');
		$grid->setWidth('pilih', '55');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setRelation('cNip_pengusul', 'hrd.employee', 'cNip', 'vName','pengusulName','inner',array('lDeleted'=>0));
		
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

	function listBox_browse_upd_detail_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->vUpd_no.'\',\''.$rowData->vNama_usulan.'\') ;" />
<script type="text/javascript">
		function pilih_upb_detail (id, vUpd_no, vNama_usulan){					
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_idossier_upd_id").val(id);
				$("#'.$this->input->get('field').'_idossier_upd_id_dis").val(vUpd_no+" - "+vNama_usulan);
				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}
}
