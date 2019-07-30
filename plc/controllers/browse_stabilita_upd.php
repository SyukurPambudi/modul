<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Browse_stabilita_upd extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->_field = $this->input->get('field');
		$this->_iBatch_no = $this->input->get("iBatch_no");
		$this->_iBulanke = $this->input->get("iBulanke");
		$this->dbset = $this->load->database('plc', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPD');		
		$grid->setTable('dossier.dossier_review');		
		$grid->setUrl('browse_stabilita_upd');
		$grid->addList('idossier_review_id','dossier_upd.vUpd_no','dossier_upd.idossier_upd_id','dossier_upd.vNama_usulan','plc2_upb.dosis','plc2_upb.vupb_nomor','plc2_upb_team.vteam','mnf_sediaan.vSediaan','pilih');
		$grid->setSortBy('vUpd_no');
		$grid->setSortOrder('DESC');
		$grid->setWidth('idossier_review_id', '-5');
		$grid->setWidth('dossier_upd.idossier_upd_id', '-5');
		$grid->setWidth('dossier_upd.vUpd_no', '50');
		$grid->setWidth('dossier_upd.vNama_usulan', '140');
		$grid->setWidth('plc2_upb.dosis', '100');
		$grid->setWidth('plc2_upb.vupb_nomor', '100');
		$grid->setWidth('mnf_sediaan.vSediaan', '100');
		$grid->setWidth('plc2_upb_team.vteam','-5');
		$grid->setWidth('pilih', '50');

		$grid->setLabel('dossier_upd.vUpd_no', 'No Dossier');
		$grid->setLabel('vNama_usulan', 'Nama Produk');				
		$grid->setLabel('plc2_upb.dosis', 'Kekuatan');
		$grid->setLabel('plc2_upb.vupb_nomor', 'Upb Ref');
		$grid->setLabel('mnf_sediaan.vSediaan', 'Sediaan');
		$grid->setLabel('dossier_upd.vNama_usulan', 'Nama Usulan');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->setInputGet('iBulanke',$this->_iBulanke);
		$grid->setInputGet('iBatch_no',$this->_iBatch_no);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setSearch('dossier_upd.vUpd_no','dossier_upd.vNama_usulan','plc2_upb.dosis');
		
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id=dossier_review.idossier_upd_id','inner');
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = dossier.dossier_upd.iupb_id', 'inner');
		$grid->setJoinTable('hrd.mnf_sediaan', 'mnf_sediaan.isediaan_id = plc2.plc2_upb.isediaan_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_formula', 'plc2_upb_formula.iupb_id=plc2.plc2_upb.iupb_id','left');
		$grid->setJoinTable('dossier.dossier_dok_list', 'dossier_dok_list.idossier_review_id=dossier.dossier_review.idossier_review_id','inner');
		$grid->setJoinTable('dossier.dossier_dokumen', 'dossier_dokumen.idossier_dokumen_id=dossier.dossier_dok_list.idossier_dokumen_id','inner');
		$grid->setJoinTable('dossier.dossier_kat_dok','dossier_kat_dok.idossier_kat_dok_id=dossier.dossier_dokumen.idossier_kat_dok_id','inner');
		$grid->setJoinTable('plc2.plc2_upb_team','plc2_upb_team.iteam_id=dossier.dossier_upd.iTeam_andev');
		//$grid->setJoinTable('dossier.dossier_review','dossier_review.idossier_upd_id=dossier.dossier_upd.idossier_upd_id','inner');
		//$grid->setJoinTable('dossier.dossier_dok_list','dossier_dok_list.idossier_review_id=dossier.dossier_review.idossier_review_id','inner');
		//$grid->setJoinTable('dossier.dossier_dokumen','dossier_dokumen.idossier_dokumen_id=dossier.dossier_dok_list.idossier_dokumen_id','inner');

		$grid->setQuery("dossier_dok_list.idossier_review_id in (select distinct(lis.idossier_review_id) from dossier.dossier_dok_list lis
			inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=lis.idossier_dokumen_id
			inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=dok.idossier_kat_dok_id
			inner join dossier.dossier_review rev on rev.idossier_review_id=lis.idossier_review_id
			where lis.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0
			and ( dok.vNama_Dokumen='ACC ".$this->input->get("iBulanke")." (Batch ".$this->input->get("iBatch_no").")' OR dok.vNama_Dokumen='RT ".$this->input->get("iBulanke")." (Batch ".$this->input->get("iBatch_no").")') )",NULL);
		
		$grid->setGroupBy('idossier_upd_id');
		//$grid->setQuery('plc2.plc2_upb.istatus_launching', 2);
		$mydept=$this->auth->tipe();
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('AD', $manager)){
				$grid->setQuery('iTeam_andev IN ('.$this->auth->my_teams().')', null);
			}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('AD', $team)){
				$type='AD';
				$grid->setQuery('iTeam_andev IN ('.$this->auth->my_teams().')', null);
			}
		}

		$grid->setQuery('iKelengkapan_data', 0);
		$grid->setQuery('dossier.dossier_kat_dok.idossier_kat_dok_id', 4);
		$grid->setQuery('dossier_review.iApprove_review', 2);

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
	
function listBox_browse_stabilita_upd_pilih($value, $pk, $name, $rowData) {
		$url_rincian=base_url()."processor/plc/stabilita/terbalik/cek?action=view";
		$url_header = base_url()."processor/plc/stabilita/terbalik?action=getdetil"; 
		$url_realtime=base_url()."processor/plc/stabilita/terbalik?action=refresh_file_realtime";
		$url_accelerate=base_url()."processor/plc/stabilita/terbalik?action=refresh_file_accelerate";
			$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upd('.$pk.',\''.$rowData->dossier_upd__idossier_upd_id.'\',\''.$rowData->dossier_upd__vUpd_no.'\',\''.$rowData->dossier_upd__vNama_usulan.'\',\''.$rowData->plc2_upb__dosis.'\',\''.$rowData->mnf_sediaan__vSediaan.'\',\''.$rowData->plc2_upb__vupb_nomor.'\') ;" />
<script type="text/javascript">
		function pilih_upd (id, idupd ,vUpdNo, vNamaUsulan, dosis, vSediaan, vUpbNo){				
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'idossier_review_id").val(id);
				$("#'.$this->input->get('field').'_idossier_upd_id_dis").val(vUpdNo);
				var iBatch_no = '.$this->input->get("iBatch_no").';
				var iBulanke = '.$this->input->get("iBulanke").';
				datareal= "";
				dataacc="";
				//cek Dokumen Realtime;
				$.ajax({
					url:"'.$url_realtime.'",
					type:"post",
					data:"idreview="+id+"&iBatch_no="+iBatch_no+"&iBulanke="+iBulanke,
					success: function(data) {
						$("#file_realtime").html(data);
					
					}
				})

				//Cek Dokumen
				$.ajax({
					url:"'.$url_accelerate.'",
					type:"post",
					data:"idreview="+id+"&iBatch_no="+iBatch_no+"&iBulanke="+iBulanke,
					success: function(data) {
						$("#file_accelerate").html(data);
					}
				})

				return $.ajax({
				url: "'.$url_header.'",
				type: "post",
				data: {
						stabilita_terbalik_idossier_review_id: id,
						},
				beforeSend: function(){
	
				},

				success: function(data){
					
					$("#stabilita_terbalik_idossier_review_id").val(id);
					$("#stabilita_terbalik_idossier_upd_id").val(idupd);
					$("#stabilita_terbalik_vUpd_no").val(vUpdNo);
					$("#stabilita_terbalik_vNama_usulan").val(vNamaUsulan);
					$("#stabilita_terbalik_dosis").val(dosis);
					$("#stabilita_terbalik_vupb_ref").val(vUpbNo);
					$("#stabilita_terbalik_vSediaan").val("sediaan");
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
