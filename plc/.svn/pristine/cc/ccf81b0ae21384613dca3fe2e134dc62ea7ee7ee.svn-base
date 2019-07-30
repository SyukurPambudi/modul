<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Browse_komparator_export extends MX_Controller {
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
		$grid->setTitle('List Komparator');		
		$grid->setTable('dossier.dossier_komparator');		
		$grid->setUrl('browse_komparator_export');
		$grid->addList('vNo_req_komparator','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','plc2_upb.dosis','mnf_sediaan.vSediaan','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb_team.vteam','dossier_upd.cNip_pengusul','dossier_upd.vNama_usulan','iHarga','dTgl_expired','iJumlah_sample','vNo_Batch','iDok_sas','pilih');
		$grid->setSortBy('vNo_req_komparator');
		$grid->setSortOrder('DESC');
		$grid->setWidth('vNo_req_komparator', '50');
		$grid->setWidth('dossier_upd.vUpd_no', '50');
		$grid->setWidth('dossier_upd.vNama_usulan', '140');
		$grid->setWidth('plc2_upb.dosis', '-5');
		$grid->setWidth('plc2_upb.vupb_nomor', '-5');
		$grid->setWidth('plc2_upb.vupb_nama', '200');
		$grid->setWidth('mnf_sediaan.vSediaan', '100');
		$grid->setWidth('plc2_upb_team.vteam', '100');
		$grid->setWidth('dossier_upd.cNip_pengusul', '-5');
		$grid->setWidth('dossier_upd.vNama_usulan', '-5');
		$grid->setWidth('vNo_Batch', '-5');
		$grid->setWidth('iJumlah_sample', '-5');
		$grid->setWidth('iDok_sas', '-5');
		$grid->setWidth('iHarga', '50');
		$grid->setWidth('dTgl_expired', '100');
		$grid->setWidth('pilih', '50');
		$grid->setLabel('vNo_req_komparator', 'No Req. Komparator');
		$grid->setLabel('dossier_upd.vUpd_no', 'No Dossier');
		$grid->setLabel('dossier_upd.vNama_usulan', 'Bahan Komparator');				
		$grid->setLabel('plc2_upb.dosis', 'Kekuatan');
		$grid->setLabel('plc2_upb.vupb_nomor', 'Upb Ref');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Eksisting');
		$grid->setLabel('plc2_upb_team.vteam', 'Team Andev');
		$grid->setLabel('dossier_upd.cNip_pengusul', 'NIP');
		$grid->setLabel('dossier_upd.vNama_usulan', 'Nama');
		$grid->setLabel('iHarga', 'Harga');
		$grid->setLabel('vNo_Batch', 'No Batch');
		$grid->setLabel('iJumlah_sample', 'Jml Sample');
		$grid->setLabel('iDok_sas', 'Dok SAS');
		$grid->setLabel('dTgl_expired', 'Expaired');
		$grid->setLabel('mnf_sediaan.vSediaan', 'Sediaan');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setSearch('vNo_req_komparator','dossier_upd.vUpd_no','dossier_upd.vNama_usulan');
		
		//$grid->setRelation('iteambusdev_id', 'plc2.plc2_div_team', 'idplc2_div_team', 'vName','bdTeamName','inner');
		$grid->changeFieldType('iDok_sas','combobox','',array(''=>'Pilih',0=>'Tidak',1=>'Ya'));
		// join table
		//$grid->setJoinTable('hrd.mnf_sediaan', 'mnf_sediaan.isediaan_id = plc2.plc2_upb.isediaan_id', 'inner');
		$grid->setJoinTable('dossier.dossier_upd', 'dossier.dossier_upd.idossier_upd_id = dossier.dossier_komparator.idossier_upd_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_team', 'plc2.plc2_upb_team.iteam_id = dossier.dossier_upd.iTeam_andev', 'inner');
		/*$que=mysql_query("select c.idossier_upd_id as iup from dossier.dossier_dok_sas as a
						left join dossier.dossier_komparator as b on a.idossier_komparator_id=b.idossier_komparator_id
						inner join dossier.dossier_upd as c on c.idossier_upd_id=b.idossier_upd_id");
		$dat=0;
		$i=0;
		while($qda=mysql_fetch_array($que)){
			if($i==0){
				$dat = $qda['iup'];
			}
			else{
				$dat .=",".$qda['iup'];
			}
			$i++;
		}
		$grid->setQuery('dossier.dossier_upd.idossier_upd_id not in ('.$dat.')',NULL);*/
		//$grid->setJoinTable('dossier.dossier_bahan_komparator', 'dossier.dossier_bahan_komparator.idossier_bahan_komparator_id = dossier.dossier_komparator.idossier_bahan_komparator_id', 'inner');
		/*
		$log=$this->user->gNIP;
		$que="select b.iteam_id as item, b.vtipe as vtipe from plc2.plc2_upb_team_item as a
			join plc2.plc2_upb_team as b on b.iteam_id=a.iteam_id
			where a.vnip='".$log."' or b.vnip='".$log."' group by a.iteam_id";
		$rupd = $this->db_plc0->query($que)->row_array();
		$id_team=$rupd['item'];
		if ($id_team==74){
			$grid->setQuery('dossier_upd.iTeam_andev',74);
		}
		else if ($id_team==75){
			$grid->setQuery('dossier_upd.iTeam_andev',75);
		}
		else{
			$grid->setQuery('dossier_upd.iTeam_andev',0);
		}
		*/
		//$grid->setQuery('dossier_upd.iTeam_andev IN ('.$this->auth->my_teams().')', null);
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = dossier.dossier_upd.iupb_id', 'inner');
		$grid->setJoinTable('hrd.mnf_sediaan', 'mnf_sediaan.isediaan_id = plc2.plc2_upb.isediaan_id', 'inner');
		$grid->setQuery('iDok_sas',1);
		$grid->setQuery('dossier.dossier_komparator.lDeleted',0);
		$grid->setQuery('dossier.dossier_komparator.iDok_Submit_Beli',1);
		$grid->setQuery('dossier.dossier_komparator.iApprove_plan',1); //Approval pembelian komparator
		$grid->setQuery('dossier_komparator.idossier_komparator_id not in (select dok.idossier_komparator_id from dossier.dossier_dok_sas dok)',NULL);
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_upd.lDeleted', 0);
		//$grid->setQuery('istatus_launching = "2" ', null);
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
	
function listBox_browse_komparator_export_pilih($value, $pk, $name, $rowData) {
		$url_header = base_url()."processor/plc/dokumen/sas/export?action=getdetil"; 
			$o = '<input type="radio" name="pilih" onClick="javascript:pilih_komparator_detail('.$pk.',\''.$rowData->vNo_req_komparator.'\',\''.$rowData->dossier_upd__vUpd_no.'\',\''.$rowData->dossier_upd__vNama_usulan.'\',\''.$rowData->plc2_upb__dosis.'\',\''.$rowData->mnf_sediaan__vSediaan.'\',\''.$rowData->plc2_upb__vupb_nomor.'\',\''.$rowData->plc2_upb__vupb_nama.'\',\''.$rowData->plc2_upb_team__vteam.'\',\''.$rowData->dossier_upd__cNip_pengusul.'\',\''.$rowData->dossier_upd__vNama_usulan.'\',\''.$rowData->iHarga.'\',\''.$rowData->dTgl_expired.'\',\''.$rowData->iJumlah_sample.'\',\''.$rowData->vNo_Batch.'\',\''.$rowData->iDok_sas.'\') ;" />
<script type="text/javascript">
		function pilih_komparator_detail (id, vNo_req_komparator, Upd_no, Nm_Bahan, dosis, vSediaan, vUpbNo, vUpbNama, vTeam, vNIP, vNmKop, vHarga, vJmlSample, vExpaired, vNoBatch, vDokSas){				
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_idossier_komparator_id").val(id);
				$("#'.$this->input->get('field').'_idossier_komparator_id_dis").val(vNo_req_komparator);
				
				if (vDokSas==1){
					dt="Ya";
				}
				else{
					dt="Tidak";
				}

				return $.ajax({
				url: "'.$url_header.'",
				type: "post",
				data: {
						idossier_komparator_id: id,
						},
				beforeSend: function(){

				},
				success: function(data){
					$("#dokumen_sas_export_vUpd_no").val(Upd_no);
					$("#dokumen_sas_export_vNama_Bahan").val(Nm_Bahan);
					$("#dokumen_sas_export_dosis").val(dosis);
					$("#dokumen_sas_export_vUpb_Ref").val(vUpbNo);
					$("#dokumen_sas_export_vEksisting").val(vUpbNama);
					$("#dokumen_sas_export_vSediaan").val(vSediaan);
					$("#dokumen_sas_export_team_andev").val(vTeam);
					$("#dokumen_sas_export_vProduk_komparator").val(vNIP+" - "+vNmKop);
					$("#dokumen_sas_export_harga").val(vHarga);
					$("#dokumen_sas_export_Tgl_Expired").val(vExpaired);
					$("#dokumen_sas_export_jml_sample_tersedia").val(vJmlSample);
					$("#dokumen_sas_export_no_batch_id").val(vNoBatch);
					$("#dokumen_sas_export_iDok_sas").val(dt);
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
