<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_export_rpt_browse_upd_progress extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_plcexport');
		$this->_field = $this->input->get('field');
		$this->dbset = $this->load->database('dosier', true);
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPD');		
		$grid->setTable('dossier.dossier_upd');		
		$grid->setUrl('browse_export_rpt_browse_upd_progress');
		$grid->addList('pilih','vUpd_no','vNama_usulan','employee.vName','itemas.C_ITENO','itemas.C_ITNAM','iTeam_andev','istandar_dok_id');
		$grid->setSortBy('vUpd_no');
		$grid->setSortOrder('DESC'); //sort ordernya
		$grid->setWidth('vupb_nomor', '55');
		$grid->setWidth('pilih', '25');
		//modif label
		$grid->setLabel('vUpd_no','No UPD');  
		$grid->setLabel('vNama_usulan','Nama Usulan'); 
		$grid->setLabel('employee.vName','Nama Pengusul');
		$grid->setLabel('itemas.C_ITENO','No Produk'); 
		$grid->setLabel('itemas.C_ITNAM','Nama Produk'); 
		$grid->setLabel('iTeam_andev','Team Andev');  
		$grid->setLabel('istandar_dok_id','Standar Dokumen'); 

		$grid->setSearch('vUpd_no','vNama_usulan');

		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');;
		$grid->changeFieldType('iTeam_andev','combobox','',array(''=>'Pilih','17'=>'Andev Export 1','40'=>'Andev Export 2'));
		
		$grid->setJoinTable('hrd.employee', 'employee.cNip = dossier_upd.cNip_pengusul', 'inner');
		$grid->setJoinTable('plc2.itemas', 'itemas.C_ITENO=dossier_upd.iupb_id','inner');

		$grid->setJoinTable('dossier.dossier_review', 'dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id', 'inner');		
		$grid->setJoinTable('dossier.dossier_prioritas_detail', 'dossier_prioritas_detail.idossier_upd_id = dossier_upd.idossier_upd_id', 'inner');
		$grid->setJoinTable('dossier.dossier_prioritas', 'dossier_prioritas.idossier_prioritas_id = dossier_prioritas_detail.idossier_prioritas_id', 'inner');
		$grid->setJoinTable('dossier.dossier_dok_list', 'dossier_dok_list.idossier_review_id = dossier_review.idossier_review_id', 'inner');
		$grid->setJoinTable('dossier.dossier_dokumen', 'dossier_dokumen.idossier_dokumen_id = dossier_dok_list.idossier_dokumen_id', 'inner');
		$grid->setJoinTable('dossier.dossier_kat_dok_details', 'dossier_kat_dok_details.idossier_kat_dok_details_id = dossier_dokumen.idossier_kat_dok_details_id', 'inner');
		

		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_review.lDeleted', 0);
		$grid->setQuery('dossier_review.iApprove_review', 2);
		$grid->setQuery('dossier_review.iApprove_keb != 1',NULL);
		$grid->setQuery('dossier_review.iApprove_review != 1',NULL);
		$grid->setQuery('dossier_review.iApprove_verify != 1',NULL);
		$grid->setQuery('dossier_review.iApprove_confirm != 1',NULL);
		
		
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

	function listBox_browse_export_rpt_browse_upd_progress_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_fst('.$pk.',\''.$rowData->vUpd_no.'\') ;" />
		<script type="text/javascript">
		function pilih_upb_fst (id, vUpd_no){					
			custom_confirm("Yakin ?", function(){
				$("#search_grid_'.$this->input->get('field').'_idossier_upd_id").val(id);
				$("#search_grid_'.$this->input->get('field').'_idossier_upd_id_dis").val(vUpd_no);
				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}
}
