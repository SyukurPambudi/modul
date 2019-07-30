<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_dok_td extends MX_Controller {
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
		$grid->setTitle('List UPD');		
		$grid->setTable('dossier.dossier_upd');		
		$grid->setUrl('browse_dok_td');
		$grid->addList('vUpd_no','vNama_usulan','plc2_upb.dosis','mnf_sediaan.vSediaan','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb_team.vteam','cNip_pengusul','vNama_usulan','pilih','dossier_review.idossier_review_id');

		$grid->setSortOrder('DESC');
		$grid->setWidth('dossier_review.idossier_review_id','0');
		$grid->setAlign('dossier_review.idossier_review_id', 'right');
		$grid->setWidth('vNo_req_komparator', '50');
		$grid->setWidth('vUpd_no', '50');
		$grid->setWidth('vNama_usulan', '140');
		$grid->setWidth('plc2_upb.dosis', '-5');
		$grid->setWidth('plc2_upb.vupb_nomor', '-5');
		$grid->setWidth('plc2_upb.vupb_nama', '200');
		$grid->setWidth('mnf_sediaan.vSediaan', '100');
		$grid->setWidth('plc2_upb_team.vteam', '100');
		$grid->setWidth('cNip_pengusul', '-5');
		$grid->setWidth('vNama_usulan', '-5');
		$grid->setWidth('vNo_Batch', '-5');
		$grid->setWidth('iJumlah_sample', '-5');
		$grid->setWidth('iDok_sas', '-5');
		$grid->setWidth('iHarga', '50');
		$grid->setWidth('dTgl_expired', '100');
		$grid->setWidth('pilih', '50');
		$grid->setLabel('vNo_req_komparator', 'No Req. Komparator');
		$grid->setLabel('vUpd_no', 'No Dossier');
		$grid->setLabel('vNama_usulan', 'Bahan Komparator');				
		$grid->setLabel('plc2_upb.dosis', 'Kekuatan');
		$grid->setLabel('plc2_upb.vupb_nomor', 'Upb Ref');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Eksisting');
		$grid->setLabel('plc2_upb_team.vteam', 'Team Andev');
		$grid->setLabel('cNip_pengusul', 'NIP');
		$grid->setLabel('vNama_usulan', 'Nama');
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
		$grid->setSearch('vUpd_no','vNama_usulan');
		
		//$grid->setRelation('iteambusdev_id', 'plc2.plc2_div_team', 'idplc2_div_team', 'vName','bdTeamName','inner');
		$grid->changeFieldType('iDok_sas','combobox','',array(''=>'Pilih',0=>'Tidak',1=>'Ya'));
		// join table
		//$grid->setJoinTable('hrd.mnf_sediaan', 'mnf_sediaan.isediaan_id = plc2.plc2_upb.isediaan_id', 'inner');
		//$grid->setJoinTable('dossier.dossier_komparator', 'dossier.idossier_upd_id = dossier.dossier_komparator.idossier_upd_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_team', 'plc2.plc2_upb_team.iteam_id = dossier_upd.iTeam_andev', 'inner');
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
		$grid->setQuery('dossier.idossier_upd_id not in ('.$dat.')',NULL);*/
		//$grid->setJoinTable('dossier.dossier_bahan_komparator', 'dossier.dossier_bahan_komparator.idossier_bahan_komparator_id = dossier.dossier_komparator.idossier_bahan_komparator_id', 'inner');
		/*
		$log=$this->user->gNIP;
		$que="select b.iteam_id as item, b.vtipe as vtipe from plc2.plc2_upb_team_item as a
			join plc2.plc2_upb_team as b on b.iteam_id=a.iteam_id
			where a.vnip='".$log."' or b.vnip='".$log."' group by a.iteam_id";
		$rupd = $this->db_plc0->query($que)->row_array();
		$id_team=$rupd['item'];
		if ($id_team==74){
			$grid->setQuery('iTeam_andev',74);
		}
		else if ($id_team==75){
			$grid->setQuery('iTeam_andev',75);
		}
		else{
			$grid->setQuery('iTeam_andev',0);
		}
		*/
		//$grid->setQuery('iTeam_andev IN ('.$this->auth->my_teams().')', null);
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = dossier_upd.iupb_id', 'inner');
		$grid->setJoinTable('hrd.mnf_sediaan', 'mnf_sediaan.isediaan_id = plc2.plc2_upb.isediaan_id', 'inner');
		$grid->setJoinTable('dossier.dossier_review', 'dossier_review.idossier_upd_id = dossier_upd.idossier_upd_id', 'inner');
		//$grid->setQuery('iDok_sas',1);
		//$grid->setQuery('dossier.dossier_komparator.lDeleted',0);
		//$grid->setQuery('dossier.dossier_komparator.iDok_Submit_Beli',1);
		//$grid->setQuery('dossier.dossier_komparator.iApprove_plan',1); //Approval pembelian komparator
		//$grid->setQuery('dossier_komparator.idossier_komparator_id not in (select dok.idossier_komparator_id from dossier.dossier_dok_sas dok)',NULL);
		$grid->setQuery('dossier_review.iKelengkapan_data3 = 2 ', null);
		$grid->setQuery('dossier_review.irelease_imm', 1);
		//$grid->setQuery('dossier_upd.vNo_nie is null or dossier_upd.vNo_nie =""', null);
		$grid->setQuery('dossier_upd.vNo_nie =""', null);
		//$grid->setQuery('dossier_upd.vNo_nie is null', null);
		$grid->setQuery('dossier_upd.iperlutd', 1);

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
	
function listBox_browse_dok_td_pilih($value, $pk, $name, $rowData) {
		$url_rincian = base_url()."processor/plc/partial/view/export?action=gethistorytd"; 
		$url_dokumen = base_url()."processor/plc/partial/view/export?action=getuploadfile_dokumentd";
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->vUpd_no.'\',\''.$rowData->vNama_usulan.'\',\''.$rowData->iTeam_andev.'\',\''.$rowData->iSediaan.'\',\''.$rowData->plc2_upb__vupb_nama.'\',\''.$rowData->dossier_review__idossier_review_id.'\') ;" />
<script type="text/javascript">
		function pilih_upb_detail (id, vUpd_no, vNama_usulan,iTeam_andev,iSediaan,nama_exist,idossier_review_id){					
			custom_confirm("Yakin ?", function(){
				$("#dossier_dokumen_td_idossier_review_id").val(idossier_review_id);
				$("#dossier_dokumen_td_idossier_review_id_dis").val(vUpd_no+" - "+vNama_usulan);
				
				$("#dossier_dokumen_td_nama_produk").val(vNama_usulan);
				$("#dossier_dokumen_td_nama_exist").val(nama_exist);

				if (iSediaan == 1) {
					iSediaan = "Solid";
				}else{
					iSediaan = "Non Solid";
				}

				if (iTeam_andev == 74) {
					iTeam_andev = "Andev 1";
				}else{
					iTeam_andev = "Andev 2";
				}
				
				$("#dossier_dokumen_td_sediaan").val(iSediaan);
				$("#dossier_dokumen_td_team_andev").val(iTeam_andev);

				$.ajax({
						     url: "'.$url_rincian.'", 
						     type: "POST", 
						     data: {idossier_review_id: idossier_review_id,idossier_upd_id: id}, 
						     success: function(response){
						         $("#hist_dok_td_view").html(response);
						     }

						});
				$.ajax({
				    url: "'.$url_dokumen.'", 
				    type: "POST", 
				    data: {idossier_review_id: idossier_review_id,idossier_upd_id: id}, 
				    success: function(response){
				        $("#dok_file_dis").html(response);
				    }

				});


				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}
}
