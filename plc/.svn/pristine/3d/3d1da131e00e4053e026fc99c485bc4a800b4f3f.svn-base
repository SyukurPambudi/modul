<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_review_dok_export extends MX_Controller {
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
		$grid->setUrl('browse_review_dok_export');
		$grid->addList('vUpd_no','vNama_usulan','iTeam_andev','iSediaan','pilih');
		$grid->setSortBy('vUpd_no');
		$grid->setSortOrder('DESC');
		$grid->setWidth('vUpd_no', '55');
		$grid->setWidth('dTanggal_upd', '190');
		$grid->setWidth('plc2.vupb_nomor', '210');
		$grid->setWidth('vNama_usulan', '300');
		$grid->setWidth('pilih', '25');

		$grid->setLabel('vUpd_no', 'No. UPD');
		$grid->setLabel('dTanggal_upd', 'Tanggal UPD');				
		$grid->setLabel('plc2.vupb_nomor', 'No. UPB');
		$grid->setLabel('vNama_usulan', 'Nama Usulan');
		$grid->setLabel('iTeam_andev','Team Andev'); 
		$grid->setLabel('iSediaan','Sediaan'); 
		
		$grid->setSearch('vUpd_no');
		
		$grid->setAlign('vUpd_no', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');

		$grid->changeFieldType('iSediaan','combobox','',array(''=>'Pilih','1'=>'Solid','2'=>'Non Solid'));
		$grid->changeFieldType('iTeam_andev','combobox','',array(''=>'Pilih','74'=>'Andev 1','75'=>'Andev 2'));
		// join table
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = dossier_upd.iupb_id', 'inner');
		$grid->setQuery('iSubmit_bagi_upd = 1 ', null);
		$grid->setQuery('idossier_upd_id not in(
							select c.idossier_upd_id
							from dossier.dossier_review a 
							join dossier.dossier_dok_list b on b.idossier_review_id=a.idossier_review_id
							join dossier.dossier_upd c on c.idossier_upd_id=a.idossier_upd_id
							where a.lDeleted=0
							and b.lDeleted=0
							#status ceklis not in 0,2
							and 
							(a.iApprove_keb in (0,2)
							#status review not in 0,2
							or a.iApprove_review in (0,2)
							#status verifikasi not in 0,2
							or a.iApprove_verify in (0,2)
							#status confirm not in 0,2
							or a.iApprove_confirm in (0,2)
							#status kelengkapan 1 not in 0,2
							or a.iSubmit_kelengkapan1 in (0)
							#status kelengkapan 2 not in 0,2
							or a.iKelengkapan_data2 in (0,2)
							#status kelengkapan 3 not in 0,2
							or a.iKelengkapan_data3 in (0,2)
							)


			) ', null);


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

	function listBox_browse_review_dok_export_pilih($value, $pk, $name, $rowData) {
		$url_rincian = base_url()."processor/plc/partial/view/export?getreviewdokumen"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upd_prio('.$pk.',\''.$rowData->vUpd_no.'\',\''.$rowData->vNama_usulan.'\',\''.$rowData->iTeam_andev.'\',\''.$rowData->iSediaan.'\') ;" />';
		$o .= '<script type="text/javascript">
					function pilih_upd_prio (id, vUpd_no,vNama_usulan,iTeam_andev,iSediaan) {					
						custom_confirm("Yakin", function() {

						$("#review_dokumen_export_idossier_upd_id").val(id);
						$("#review_dokumen_export_vUpd_no").val(vUpd_no);
						$("#review_dokumen_export_vNama_usulan").val(vNama_usulan);


						$.ajax({
						     url: "'.$url_rincian.'", 
						     type: "POST", 
						     data: {iSediaan: iSediaan,idossier_upd_id: id}, 
						     success: function(response){
						         $("#review_dokumen_rincian").html(response);
						     }

						});


						if (iTeam_andev==74) {
							var tim = "Andev 1";
							
						}else{
							var tim = "Andev 2";
							
						}
						$("#review_dokumen_export_iTeam_andev").val(tim);

						


						$("#alert_dialog_form").dialog("close");


						});
					}
				</script>';

		return $o;
	}
}
