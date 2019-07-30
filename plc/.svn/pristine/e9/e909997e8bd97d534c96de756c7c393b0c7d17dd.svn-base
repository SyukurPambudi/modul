<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Browse_doksas extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->_field = $this->input->get('field');
		$this->dbset = $this->load->database('plc', true);
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Dokumen SAS');		
		$grid->setTable('dossier.dossier_dok_sas');		
		$grid->setUrl('browse_doksas');
		$grid->addList('vNo_req_sas','plc2_upb.dosis','mnf_sediaan.vSediaan','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb_team.vteam','dossier_upd.cNip_pengusul','dossier_upd.vNama_usulan','dossier_upd.vUpd_no','dossier_komparator.vNo_req_komparator','pilih');
		$grid->setSortBy('vNo_req_komparator');
		$grid->setSortOrder('DESC');

		$grid->setWidth('vNo_req_sas', '50');//iya
		$grid->setWidth('dossier_komparatorv.No_req_komparator', '50');//iya
		$grid->setWidth('dossier_upd.Upd_no', '50'); //iya//ya dossier_bahan_komparator
		$grid->setWidth('plc2_upb.dosis', '-5');//ya plc2_upb
		$grid->setWidth('plc2_upb.vupb_nomor', '-5');//iya
		$grid->setWidth('plc2_upb.vupb_nama', '200');
		$grid->setWidth('mnf_sediaan.vSediaan', '100');//ya mnf_sediaan
		$grid->setWidth('plc2_upb_team.vteam', '100');
		$grid->setWidth('dossier_upd.cNip_pengusul', '-5');
		$grid->setWidth('dossier_upd.vNama_usulan', '-5');
		$grid->setWidth('pilih', '50');

		$grid->setLabel('vNo_req_sas', 'No Req. SAS'); //iya
		$grid->setLabel('dossier_komparator.vNo_req_komparator', 'No Req. Komparator'); 
		$grid->setLabel('dossier_upd.vUpd_no', 'No Dossier');//iya dossier_upd			
		$grid->setLabel('plc2_upb.dosis', 'Kekuatan');
		$grid->setLabel('plc2_upb.vupb_nomor', 'Upb Ref');//iya vUpb_Ref plc2_upb
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Eksisting');//iya vEksisting plc2_upb
		$grid->setLabel('plc2_upb_team.vteam', 'Team Andev'); //iya plc2_upb_team
		$grid->setLabel('dossier_upd.cNip_pengusul', 'NIP');//iya vProduk_komparator dossier_upd
		$grid->setLabel('dossier_upd.vNama_usulan', 'Nama');//iya vProduk_komparator dossier_upd
		$grid->setLabel('mnf_sediaan.vSediaan', 'Sediaan');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setSearch('vNo_req_sas','dossier_upd.vUpd_no','dossier_komparator.vNo_req_komparator');
		
		//$grid->setRelation('iteambusdev_id', 'plc2.plc2_div_team', 'idplc2_div_team', 'vName','bdTeamName','inner');
		//$grid->changeFieldType('iDok_sas','combobox','',array(''=>'Pilih',0=>'Tidak',1=>'Ya'));
		// join table
		//$grid->setJoinTable('hrd.mnf_sediaan', 'mnf_sediaan.isediaan_id = plc2.plc2_upb.isediaan_id', 'inner');
		$grid->setJoinTable('dossier.dossier_komparator', 'dossier_komparator.idossier_komparator_id = dossier_dok_sas.idossier_komparator_id', 'inner');
		$grid->setJoinTable('dossier.dossier_upd', 'dossier.dossier_upd.idossier_upd_id = dossier.dossier_komparator.idossier_upd_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_team', 'plc2.plc2_upb_team.iteam_id = dossier.dossier_upd.iTeam_andev', 'inner');
		//$grid->setJoinTable('dossier.dossier_bahan_komparator', 'dossier.dossier_bahan_komparator.idossier_bahan_komparator_id = dossier.dossier_komparator.idossier_bahan_komparator_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = dossier.dossier_upd.iupb_id', 'inner');
		$grid->setJoinTable('hrd.mnf_sediaan', 'mnf_sediaan.isediaan_id = plc2.plc2_upb.isediaan_id', 'inner');
		$grid->setQuery('dossier_dok_sas.idossier_dok_sas_id not in (select d.idossier_dok_sas_id from dossier.dossier_dok_td_sas d where d.iDeleted=0 and d.iAccept=0)', null);
		$grid->setQuery('iDok_td',1);
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setGridView('grid');

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
	
function listBox_browse_doksas_pilih($value, $pk, $name, $rowData) {
		$url_header = base_url()."processor/plc_export/dokumen/sas/?action=getdetil"; 
			$o = '<input type="radio" name="pilih" onClick="javascript:pilih_komparator_detail('.$pk.',\''.$rowData->vNo_req_sas.'\',\''.$rowData->plc2_upb__dosis.'\',\''.$rowData->mnf_sediaan__vSediaan.'\',\''.$rowData->plc2_upb__vupb_nomor.'\',\''.$rowData->plc2_upb__vupb_nama.'\',\''.$rowData->plc2_upb_team__vteam.'\',\''.$rowData->dossier_upd__cNip_pengusul.'\',\''.$rowData->dossier_upd__vNama_usulan.'\',\''.$rowData->dossier_upd__vUpd_no.'\',\''.$rowData->dossier_komparator__vNo_req_komparator.'\');" />
			<script type="text/javascript">
		function pilih_komparator_detail (id, vNo_req_sas, dosis, vSediaan, vUpbNo, vUpbNama, vTeam, vNIP, vNmKop, VupdNo, vNoReqKomp){				
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_idossier_dok_sas_id").val(id);
				$("#'.$this->input->get('field').'_idossier_dok_sas_id_dis").val(vNo_req_sas);
				
				return $.ajax({
				url: "'.$url_header.'",
				type: "post",
				data: {
						idossier_komparator_id: id,
						},
				beforeSend: function(){

				},
				success: function(data){
					$("#dokumen_dt_sas_vNama_bahan").val(vNmKop);
					$("#dokumen_dt_sas_dosis").val(dosis);
					$("#dokumen_dt_sas_vSediaan").val(vSediaan);
					$("#dokumen_dt_sas_vUpb_Ref").val(vUpbNo);
					$("#dokumen_dt_sas_vEksisting").val(vUpbNama);
					$("#dokumen_dt_sas_team_andev").val(vTeam);
					$("#dokumen_dt_sas_vProduk_komparator").val(vNIP+" - "+vNmKop);
					$("#dokumen_dt_sas_vUpd_no").val(VupdNo);
					$("#dokumen_dt_sas_vNo_req_komparator").val(vNoReqKomp);
					$("#alert_dialog_form").dialog("close");
				},
				}).responseText;

				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}
}
