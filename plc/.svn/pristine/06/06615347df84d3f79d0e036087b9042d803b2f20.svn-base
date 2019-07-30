<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dokumen_sas_export extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->load->library('lib_utilitas');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Request Dokumen SAS');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_dok_sas');		
		$grid->setUrl('dokumen_sas_export');
		$grid->addList('vNo_req_sas','dossier_komparator.vNo_req_komparator','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','iDok_Submit','iApprove_sas','dApproval_sas','dossier_upd.iTeam_andev');
		$grid->setSortBy('vNo_req_sas');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vNo_req_sas','idossier_komparator_id','vUpd_no','vNama_Bahan','dosis','vSediaan','vUpb_Ref','vEksisting','team_andev','vProduk_komparator','harga','Tgl_Expired','jml_sample_tersedia','no_batch_id','iDok_sas','dApproval_sas','cApproval_sas');

		//setting widht grid
		$grid->setWidth('vNo_req_sas', '80'); 
		$grid->setWidth('idossier_komparator_id', '80'); 
		$grid->setWidth('iApprove_sas', '100'); 
		$grid->setWidth('dossier_upd.vUpd_no', '100'); 
		$grid->setWidth('dossier_upd.vNama_usulan', '100'); 
		$grid->setWidth('vUpd_no', '100'); 
		$grid->setWidth('vNama_Bahan', '80'); 
		$grid->setWidth('dosis', '100'); 
		$grid->setWidth('vSediaan', '100'); 
		$grid->setWidth('vUpb_Ref', '100'); 
		$grid->setWidth('vEksisting', '100'); 
		$grid->setWidth('team_andev', '100'); 
		$grid->setWidth('vProduk_komparator', '100'); 
		$grid->setWidth('Tgl_Expired', '100'); 
		$grid->setWidth('harga', '100'); 
		$grid->setWidth('no_batch_id', '100'); 
		$grid->setWidth('iDok_sas', '100'); 
		$grid->setWidth('iDok_Submit', '200'); 
		$grid->setWidth('iApprove_sas', '150'); 
		$grid->setWidth('jml_sample_tersedia', '100'); 
		$grid->setWidth('dossier_komparator.vNo_req_komparator', '60'); 
		$grid->setWidth('dApproval_sas', '120'); 
		$grid->setWidth('dossier_upd.iTeam_andev','-5');
		
		
		//modif label
		$grid->setLabel('vNo_req_sas','No Req SAS'); 
		$grid->setLabel('dossier_komparator.vNo_req_komparator','No Req Komparator'); 
		$grid->setLabel('iApprove_sas','Approve SAS'); 
		$grid->setLabel('dossier_upd.vUpd_no','No Dossier'); 
		$grid->setLabel('idossier_komparator_id', 'Kode Komparator');
		$grid->setLabel('vUpd_no','No Dossier'); 
		$grid->setLabel('vNama_Bahan','Nama Produk'); 
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Produk'); 
		$grid->setLabel('iDeleted','Hapus'); 
		$grid->setLabel('dupdate','Tgl Update'); 
		$grid->setLabel('cUpdate','Update By'); 
		$grid->setLabel('dosis','Kekuatan'); 
		$grid->setLabel('vSediaan', 'Sediaan'); 
		$grid->setLabel('vUpb_Ref', 'UPB Referensi'); 
		$grid->setLabel('vEksisting', 'Nama UPB Referensi'); 
		$grid->setLabel('team_andev', 'Team Andev'); 
		$grid->setLabel('vProduk_komparator', 'Nama Produk Komparator'); 
		$grid->setLabel('Tgl_Expired', 'Tgl Expired'); 
		$grid->setLabel('harga', 'Harga'); 
		$grid->setLabel('dApproval_sas', 'Tanggal Approve'); 
		$grid->setLabel('no_batch_id', 'No Batch'); 
		$grid->setLabel('iDok_sas', 'Dok SAS'); 
		$grid->setLabel('iDok_Submit', 'Status Dok SAS'); 
		$grid->setLabel('jml_sample_tersedia', 'Jml Sample Tersedia'); 
		$grid->setLabel('cApproval_sas', 'Approve By'); 
		
		$grid->setFormUpload(TRUE);

		$grid->setSearch('vNo_req_sas','dossier_komparator.vNo_req_komparator','dossier_upd.vUpd_no','iApprove_sas');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iApprove_sas','combobox','',array(''=> 'Pilih',0=>'Waiting Approval',1=>'Reject',2=>'Approve'));
		$grid->changeFieldType('iDok_Submit','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submited'));

		

	//Field mandatori
		$grid->setRequired('vNo_req_sas');	
		$grid->setRequired('idossier_komparator_id');

		//join table
		$grid->setJoinTable('dossier.dossier_komparator', 'dossier_komparator.idossier_komparator_id = dossier_dok_sas.idossier_komparator_id', 'inner');
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_komparator.idossier_upd_id', 'left');
		
		//$grid->setQuery('dossier_upd.iTeam_andev IN ('.$this->auth->my_teams().')', null);

		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_upd.lDeleted', 0);

		//Set View Gridnya (Default = grid)
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				$idossier_komparator_id=$_POST['dokumen_sas_export_idossier_komparator_id'];
				$sql="select a.* from dossier.dossier_dok_sas as a where idossier_komparator_id='".$idossier_komparator_id."'" ;
				$data_cek = $this->dbset->query($sql)->row_array();
                if ($data_cek) {
                	   	$r['status'] = FALSE;
                     	$r['message'] = "No Dossier Sudah Ada!";
                        echo json_encode($r);
                        break;
                }
                else{
                	echo $grid->saved_form();
                	break;
                }
				
			case 'download':
				$this->download($this->input->get('file'));
				break;

			case 'delete':
				echo $grid->delete_row();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'getspname':
				echo $this->getSpname();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
			
				$idossier_komparator_id_lm=$_POST['dokumen_sas_export_idossier_komparator_id_lm'];
				$idossier_komparator_id=$_POST['dokumen_sas_export_idossier_komparator_id'];
				if($idossier_komparator_id<>$idossier_komparator_id_lm){
					$sql="select a.* from dossier.dossier_dok_sas as a where a.idossier_komparator_id='".$idossier_komparator_id."' and a.idossier_komparator_id !='".$idossier_komparator_id_lm."'" ;
					$data_cek = $this->dbset->query($sql)->row_array();
	                if ($data_cek) {
	                	   	$r['status'] = FALSE;
	                     	$r['message'] = "No Dossier Sudah Ada!";
	                        echo json_encode($r);
	                        break;
	                }
	                else{
						echo $grid->updated_form();
					}
				}
				else{
					echo $grid->updated_form();
				}
				
				break;
			case 'approve':
				echo $this->approve_view();
				break;
			case 'approve_process':
				echo $this->approve_process();
				break;
			case 'reject':
				echo $this->reject_view();
				break;
			case 'reject_process':
				echo $this->reject_process();
				break;
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }

/*function manipulate_grid_button($buttons){
	$manager=0;
	$team=0;
	$sqman="select count(b.iteam_id) + 1 as jmlman from plc2.plc2_upb_team as b
		where b.vtipe='AD' and b.vnip='".$this->user->gNIP."'
		group by b.iteam_id";
	$datman=$this->dbset->query($sqman)->row_array();
	if(isset($datman['jmlman'])){
 		$manager=$datman['jmlman'];
 	}
 	$sqteam="select count(b.iteam_id) + 1 as jmlman from plc2.plc2_upb_team_item as b
		join plc2.plc2_upb_team as a on a.iteam_id=b.iteam_id
		where a.vtipe='AD' and b.vnip='".$this->user->gNIP."'
		group by b.iteam_id";
	$datteam=$this->dbset->query($sqteam)->row_array();
	if(isset($datteam['jmlman'])){
 		$team=$datteam['jmlman'];
 	}
	if($manager<>1 or $team<>1){
		//$buttons['create'];
	}
	else {
		unset($buttons['create']);
	}
	return $buttons;
}
*/
function listBox_Action($row, $actions){
	if($this->auth->is_manager()){
		$x=$this->auth->dept();
		$manager=$x['manager'];
		if(in_array('AD', $manager)){
			if($row->iApprove_sas<>0){
				unset($actions['edit']);
			}
		}
		else{
			unset($actions['edit']);
			unset($actions['delete']);
		}
	}else{
		$x=$this->auth->dept();
		$team=$x['team'];
		if(in_array('IR', $team)){
			if($row->iDok_Submit<>0){
				unset($actions['edit']);
				unset($actions['delete']);
			}
		}
		else{
			unset($actions['edit']);
			unset($actions['delete']);
		}
	}
	return $actions;
}
/*function listBox_Action($row, $actions) {
	$manager=0;
	$team=0;
	$manager1=0;
	$iteamman1=NULL;
	$iteam=NULL;
	/*$sqman="select count(b.iteam_id) as jmlman from plc2.plc2_upb_team as b
		where b.vtipe='AD' and b.vnip='".$this->user->gNIP."'
		group by b.iteam_id";
	$datman=$this->dbset->query($sqman)->row_array();
	if(isset($datman['jmlman'])){
 		$manager=$datman['jmlman'];
 	}
 	$sqteam="select count(b.iteam_id) as jmlman, b.iteam_id as iteam from plc2.plc2_upb_team_item as b
		join plc2.plc2_upb_team as a on a.iteam_id=b.iteam_id
		where a.vtipe='AD' and b.vnip='".$this->user->gNIP."'
		group by b.iteam_id";
	$datteam=$this->dbset->query($sqteam)->row_array();
	if(isset($datteam['jmlman'])){
 		$team=$datteam['jmlman'];
 		$iteam=$datteam['iteam'];
 	}
 	$sqman1="select count(b.iteam_id) as jmlman, b.iteam_id as iteamman1 from plc2.plc2_upb_team as b
		where b.vtipe='AD' and b.vnip='".$this->user->gNIP."'
		group by b.iteam_id";
	$datman1=$this->dbset->query($sqman1)->row_array();
	if(isset($datman1['jmlman'])){
 		$manager1=$datman1['jmlman'];
 		$iteamman1=$datman1['iteamman1'];
 	}
 	if(($manager1<>0) or ($team<>0)){
 		if($manager1<>0){
	 		if($row->iDok_Submit<>0){
	 			if ($row->iApprove_sas<>0){
			 		unset($actions['edit']);
				 	unset($actions['delete']);
		 		}
				else if($row->iDok_Submit<>0){
					if($row->dossier_upd__iTeam_andev==$iteamman1){
						$actions['edit'];
				 		unset($actions['delete']);
				 	}
				 	else{
				 		unset($actions['edit']);
			 			unset($actions['delete']);
				 	}
		 		}
		 		else{
		 			unset($actions['edit']);
			 		unset($actions['delete']);
		 		}
	 		}
	 		else{
	 			$actions['edit'];
			 	$actions['delete'];
	 		}
	 	}
	 	else if($team<>0){
	 		if($row->iDok_Submit==0){
	 			if($row->dossier_upd__iTeam_andev==$iteamman1){
					$actions['edit'];
					$actions['delete'];
				}
				else{
					unset($actions['edit']);
			 		unset($actions['delete']);
				}
	 		}
	 		else{
					unset($actions['edit']);
			 		unset($actions['delete']);	 			
	 		}
	 	}
	 	else{
	 		unset($actions['edit']);
			unset($actions['delete']);
	 	}
 	}
 	else{
 		unset($actions['edit']);
		unset($actions['delete']);
 	}			
	return $actions;

} */

/*manipulasi view object form start*/
function insertBox_dokumen_sas_export_vNo_req_sas($field, $id) {
	$return = 'Auto Number';
	return $return;
}
function updateBox_dokumen_sas_export_vNo_req_sas($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return= $value;
		$return .= '<input type="hidden" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';

		
	}
	
	return $return;
}	

function insertBox_dokumen_sas_export_idossier_komparator_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="25" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/komparator/export?field=dokumen_sas_export\',\'List Komparator\')" type="button">&nbsp;</button>';                
		return $return;
}

function updateBox_dokumen_sas_export_idossier_komparator_id($field, $id, $value, $rowData) {
$sql = 'select vNo_req_komparator as a from dossier_komparator where idossier_komparator_id="'.$value.'" ';
	$data_kom = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];

	}else{

		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'_lm" id="'.$id.'_lm" value="'.$value.'" class="input_rows1 required" />';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="25" value="'.$data_kom['a'].'"/>';
		if ($rowData['iDok_Submit']==0){
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/komparator/export?field=dokumen_sas_export\',\'List Komparator\')" type="button">&nbsp;</button>';
		}
		                
		            
	}
	return $return; 
	
}	

function insertBox_dokumen_sas_export_vUpd_no($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" size="25" />
	<input type="hidden" name="isdraft" id="isdraft">';
	return $return;
}

function updateBox_dokumen_sas_export_vUpd_no($field, $id, $value, $rowData) {
$sql = 'select b.vUpd_no as a from dossier_komparator as a, dossier_upd as b where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and a.idossier_upd_id=b.idossier_upd_id';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />
		<input type="hidden" name="isdraft" id="isdraft">';
	}
	return $return;
	
}	

function insertBox_dokumen_sas_export_vNama_Bahan($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" size="25" />';
	return $return;
}

function updateBox_dokumen_sas_export_vNama_Bahan($field, $id, $value, $rowData) {
$sql = 'select b.vNama_usulan as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}	

function insertBox_dokumen_sas_export_dosis($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" size="25" />';
	return $return;
}

function updateBox_dokumen_sas_export_dosis($field, $id, $value, $rowData) {
$sql = 'select c.dosis as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_sas_export_vSediaan($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" size="25" />';
	return $return;
}

function updateBox_dokumen_sas_export_vSediaan($field, $id, $value, $rowData) {
$sql = 'select d.vSediaan as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_sas_export_vUpb_Ref($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" size="25" />';
	return $return;
}


function updateBox_dokumen_sas_export_vUpb_Ref($field, $id, $value, $rowData) {
$sql = 'select c.vupb_nomor as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_sas_export_vEksisting($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" size="25" />';
	return $return;
}

function updateBox_dokumen_sas_export_vEksisting($field, $id, $value, $rowData) {
$sql = 'select c.vupb_nama as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_sas_export_team_andev($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" size="25" />';
	return $return;
}

function updateBox_dokumen_sas_export_team_andev($field, $id, $value, $rowData) {
$sql = 'select e.vteam as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_sas_export_vProduk_komparator($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" size="25" />';
	return $return;
}

function updateBox_dokumen_sas_export_vProduk_komparator($field, $id, $value, $rowData) {
$sql = 'select b.cNip_pengusul as a, b.vNama_usulan as b from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].' - '.$data_kom['b'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_sas_export_Tgl_Expired($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" size="25" />';
	return $return;
}

function updateBox_dokumen_sas_export_Tgl_Expired($field, $id, $value, $rowData) {
$sql = 'select a.dTgl_expired as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_sas_export_harga($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" size="25" />';
	return $return;
}

function updateBox_dokumen_sas_export_harga($field, $id, $value, $rowData) {
$sql = 'select a.iHarga as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_sas_export_no_batch_id($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" size="25" />';
	return $return;
}

function updateBox_dokumen_sas_export_no_batch_id($field, $id, $value, $rowData) {
$sql = 'select a.vNo_Batch as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_sas_export_jml_sample_tersedia($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" size="25" />';
	return $return;
}

function updateBox_dokumen_sas_export_jml_sample_tersedia($field, $id, $value, $rowData) {
$sql = 'select a.iJumlah_sample as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}


function insertBox_dokumen_sas_export_iDok_sas($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" size="25" />';
	return $return;
}

function updateBox_dokumen_sas_export_iDok_sas($field, $id, $value, $rowData) {
$sql = 'select a.iDok_sas as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($data_kom['a']==1){
		$dt="Ya";
	}
	elseif ($data_kom['a']==0) {
		$dt="Tidak";
	}
	if ($this->input->get('action') == 'view') {
		$return= $dt;
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dt.'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_sas_export_dupdate($field, $id) {
		$skg=date('Y-m-d');
		$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$skg.'" class="input_rows1" size="8" />';
		$return .= $skg;
		return $return;
}

function updateBox_dokumen_sas_export_dupdate($field, $id, $value, $rowData) {
		$skg=date('Y-m-d');
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = $value;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$skg.'" class="input_rows1" size="8" />';
		}
		
		return $return;
}

function insertBox_dokumen_sas_export_cUpdate($field, $id) {
		$skg=date('Y-m-d');
		$cNip = $this->user->gNIP;
		$vName = $this->user->gName;
		$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$cNip.'" class="input_rows1" size="8" />';
		$return .= $vName;
		return $return;
}

function updateBox_dokumen_sas_export_cUpdate($field, $id, $value, $rowData) {
		$skg=date('Y-m-d');
		$cNip = $this->user->gNIP;
		$emp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$cNip))->row_array();
		$vName = $this->user->gName;
		if ($this->input->get('action') == 'view') {
			$return= $emp['vName'];

		}
		else{
			$return = $emp['vName'];
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$cNip.'" class="input_rows1" size="8" />';
		}
		
		return $return;
}

function insertBox_dokumen_sas_export_dApproval_sas($field, $id) {
	$return = '-';
	return $return;
}

function updateBox_dokumen_sas_export_dApproval_sas($field, $id, $value, $rowData) {
		if ($rowData['iApprove_sas']<> 0 ) {
			$palue= $rowData['dApproval_sas'];
			
		}else{
			$palue='Waiting Approval';
		}


		if ($this->input->get('action') == 'view') {
			$return= $palue;

		}
		else{
			$return= $palue;
		}
		
		return $return;
}

function insertBox_dokumen_sas_export_cApproval_sas($field, $id) {
	$return = '-';
	return $return;
}

function updateBox_dokumen_sas_export_cApproval_sas($field, $id, $value, $rowData) {
	

		if ($rowData['iApprove_sas']<> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cApproval_sas']))->row_array();

			if ($rowData['iApprove_sas'] == 2) {
				$palue='Approved by '.$rows['vName'].', Remark :'.$rowData['vRemark'] ;	
			}else{
				$palue='Rejected by '.$rows['vName'].', Remark :'.$rowData['vRemark'];	
			}
			
		}else{
			$palue='Waiting Approval';
		}

		if ($this->input->get('action') == 'view') {
			$return= $palue;

		}
		else{
			$return= $palue;
		}
		
		return $return;
}

/*manipulasi view object form end*/

/*manipulasi proses object form start*/

    
   
/*manipulasi proses object form end*/    

/*function pendukung start*/  
function before_update_processor($row, $postData) {
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	//return $postData;
	// ubah status submit
	if($postData['isdraft']==true){
		$postData['iDok_Submit']=0;
	} 
	else{$postData['iDok_Submit']=1;} 
	return $postData;

}
function before_insert_processor($row, $postData) {
	$postData['cApproval_sas'] = NULL;
	$postData['dApproval_sas'] = NULL;
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreate'] =$this->user->gNIP;
	//return $postData;

	// ubah status submit
		if($postData['isdraft']==true){
			$postData['iDok_Submit']=0;
		} 
		else{$postData['iDok_Submit']=1;} 

	return $postData;

}


function manipulate_update_button($buttons, $rowData) {
	$cNip= $this->user->gNIP;

	$js = $this->load->view('dokumen_sas_export_js');

	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/dokumen/sas/export?action=approve&idossier_dok_sas_id='.$rowData['idossier_dok_sas_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_dokumen_sas_export">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/dokumen/sas/export?action=reject&idossier_dok_sas_id='.$rowData['idossier_dok_sas_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_dokumen_sas_export">Reject</button>';

	$update = '<button onclick="javascript:update_btn_back(\'dokumen_sas_export\', \''.base_url().'processor/plc/dokumen/sas/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_dokumen_sas_export">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'dokumen_sas_export\', \''.base_url().'processor/plc/dokumen/sas/export?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_dokumen_sas_export">Update as Draft</button>';

	

	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if ($rowData['iDok_Submit']== 0) {
			// jika masih draft , show button update draft & update submit 
			$buttons['update'] = $update.$updatedraft.$js;
		}else{
			if($this->auth->is_andev()){
				if ($rowData['iApprove_sas']==0){
					$buttons['update'] = $approve.$reject.$js;
				}
				else{}
			}
			else{}
		}

		//$buttons['update'] = $update.$updatedraft.$approve.$reject.$js;
	}
	

	return $buttons;


}								
function manipulate_insert_button($buttons) {
	unset($buttons['save']);

	$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'dokumen_sas_export\', \''.base_url().'processor/plc/dokumen/sas/export?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_dokumen_sas_export">Save as Draft</button>';
	$save = '<button onclick="javascript:save_btn_multiupload(\'dokumen_sas_export\', \''.base_url().'processor/plc/dokumen/sas/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_dokumen_sas_export">Save &amp; Submit</button>';
	$js = $this->load->view('dokumen_sas_export_js');
	$buttons['save'] = $save_draft.$save.$js;

	return $buttons;
}


public function after_insert_processor($fields, $id, $post) {

		$cNip = $this->user->gNIP;
		//$tgl = date('Y-m-d', mktime());
		//$tUpdated = date('Y-m-d H:i:s', mktime());
		//$SQL = "UPDATE dossier.dossier_bahan_komparator set cCreatedBy='{$cNip}', dCreated='{$tUpdated}' where id = '{$id}'";
		//$this->dbset->query($SQL);
		
		//update service_request autonumber No Brosur
		$nomor = "E".str_pad($id, 4, "0", STR_PAD_LEFT);
		$sql = "UPDATE dossier.dossier_dok_sas SET vNo_req_sas = '".$nomor."' WHERE idossier_dok_sas_id=$id LIMIT 1";
		$query = $this->db_plc0->query( $sql );

		$submit=$post['iDok_Submit'];
		if ($submit == 1) {
			$qupd="select d.iteam_id as item, a.vNo_req_sas as vNo_req_sas, a1.vNo_req_komparator as no_req_komparator, b.vNama_usulan as nama_usulan, f.vsediaan as sediaan, b.cNip_pengusul as nip_pengusul, c.vName as nama_pengusul, a1.iHarga as harga, a1.dTgl_expired as tglExpired, a1.iJumlah_sample as sample from dossier.dossier_dok_sas as a
					join dossier.dossier_komparator as a1 on a1.idossier_komparator_id=a.idossier_komparator_id
					join dossier.dossier_upd as b on a1.idossier_upd_id=b.idossier_upd_id
					join plc2.plc2_upb as e on e.iupb_id=b.iupb_id
					join hrd.mnf_sediaan as f on f.isediaan_id=e.isediaan_id
					join hrd.employee as c on b.cNip_pengusul=c.cNip
					join plc2.plc2_upb_team as d on b.iTeam_andev=d.iteam_id
					where a.idossier_dok_sas_id='".$id."'";
			$rupd = $this->db_plc0->query($qupd)->row_array();
			$andev=$rupd['item'];
			

			$query1=mysql_query("select a1.iteam_id as item_bdirm from plc2.plc2_upb_team as a1 where a1.vtipe='BDI'");
			$datbd=array();
			$i=0;
			while($datbdi=mysql_fetch_array($query1)){
				$datbd[$i] = $datbdi['item_bdirm'];
				$i++;
			}
			$databdirm=implode(',',$datbd);


			$query=mysql_query("select a1.iteam_id as item_bdirm from plc2.plc2_upb_team as a1 where a1.vtipe='DR'");
			$datdireksi=array();
			$i=0;
			while($datdir=mysql_fetch_array($query)){
				$datdireksi[$i] = $datdir['item_bdirm'];
				$i++;
			}
			$datadireksi=implode(',',$datdireksi);

			if ($andev == 74) {
				$iTeamandev = 'Andev 1';
			}else{
				$iTeamandev = 'Andev 2';
			}
			$team=$andev;
			//$logged_nip =$this->user->gNIP;
	        $toEmail2='';
			$toEmail20 = $this->lib_utilitas->get_email_team( $team );
	        $toEmail21 = $this->lib_utilitas->get_email_leader( $team );
	        //$arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
	        $arrEmail = $this->lib_utilitas->get_email_by_nip($this->user->gNIP);                    
	                    
			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($toEmail);
				$to = $toEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
				}
			}
			
			$toEmail="supri@novellpharm.com";
			//$toEmail2="mansur@novellpharm.com";
			//$toEmail3="farhah.syafina@novellpharm.com";
			//$to = $toEmail2.';'.$toEmail;
			//$cc = $arrEmail;                        
				//$doksas=array(0=>'Tidak',1=>'Iya');
				$to = $arrEmail;
				$cc = $toEmail21;                       

				$subject="Request Dokumen SAS: <".$rupd['vNo_req_sas'].">";
				$content="Diberitahukan bahwa telah ada Request Dokumen SAS yang dialokasikan pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #DCDCDC;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 150px;'><b>No Request SAS</b></td><td style='width: 20px;'> : </td><td>".$rupd['vNo_req_sas']."</td>
							</tr>
							<tr>
								<td><b>No Komparator</b></td><td> : </td><td>".$rupd['no_req_komparator']."</td>
							</tr>
							<tr>
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['nama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['nip_pengusul']."-".$rupd['nama_pengusul']."</td>
							</tr>
							<tr>
								<td><b>Sediaan</b></td><td> : </td><td>".$rupd['sediaan']."</td>
							</tr>
							<tr>
								<td><b>Harga</b></td><td> : </td><td>".$rupd['harga']."</td>
							</tr>
							<tr>
								<td><b>Jumlah Sample</b></td><td> : </td><td>".$rupd['sample']."</td>
							</tr>
							<tr>
								<td><b>Tgl Expired</b></td><td> : </td><td>".$rupd['tglExpired']."</td>
							</tr>
						</table><br />
					</div><br/>
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}
}  

public function after_update_processor($fields, $id, $post) {

		$submit=$post['iDok_Submit'];
		if ($submit == 1) {
			$qupd="select d.iteam_id as item, a.vNo_req_sas as vNo_req_sas, a1.vNo_req_komparator as no_req_komparator, b.vNama_usulan as nama_usulan, f.vsediaan as sediaan, b.cNip_pengusul as nip_pengusul, c.vName as nama_pengusul, a1.iHarga as harga, a1.dTgl_expired as tglExpired, a1.iJumlah_sample as sample from dossier.dossier_dok_sas as a
					join dossier.dossier_komparator as a1 on a1.idossier_komparator_id=a.idossier_komparator_id
					join dossier.dossier_upd as b on a1.idossier_upd_id=b.idossier_upd_id
					join plc2.plc2_upb as e on e.iupb_id=b.iupb_id
					join hrd.mnf_sediaan as f on f.isediaan_id=e.isediaan_id
					join hrd.employee as c on b.cNip_pengusul=c.cNip
					join plc2.plc2_upb_team as d on b.iTeam_andev=d.iteam_id
					where a.idossier_dok_sas_id='".$id."'";
			$rupd = $this->db_plc0->query($qupd)->row_array();
			$andev=$rupd['item'];
			

			$query1=mysql_query("select a1.iteam_id as item_bdirm from plc2.plc2_upb_team as a1 where a1.vtipe='BDI'");
			$datbd=array();
			$i=0;
			while($datbdi=mysql_fetch_array($query1)){
				$datbd[$i] = $datbdi['item_bdirm'];
				$i++;
			}
			$databdirm=implode(',',$datbd);


			$query=mysql_query("select a1.iteam_id as item_bdirm from plc2.plc2_upb_team as a1 where a1.vtipe='DR'");
			$datdireksi=array();
			$i=0;
			while($datdir=mysql_fetch_array($query)){
				$datdireksi[$i] = $datdir['item_bdirm'];
				$i++;
			}
			$datadireksi=implode(',',$datdireksi);

			if ($andev == 74) {
				$iTeamandev = 'Andev 1';
			}else{
				$iTeamandev = 'Andev 2';
			}
			$team=$andev;
			//$logged_nip =$this->user->gNIP;
	        $toEmail2='';
			$toEmail20 = $this->lib_utilitas->get_email_team( $team );
	        $toEmail21 = $this->lib_utilitas->get_email_leader( $team );
	        //$arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
	        $arrEmail = $this->lib_utilitas->get_email_by_nip($this->user->gNIP);                    
	                    
			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($toEmail);
				$to = $toEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
				}
			}
			
			$toEmail="supri@novellpharm.com";
			//$toEmail2="mansur@novellpharm.com";
			//$toEmail3="farhah.syafina@novellpharm.com";
			//$to = $toEmail2.';'.$toEmail;
			//$cc = $arrEmail;                        
				//$doksas=array(0=>'Tidak',1=>'Iya');
				$to = $arrEmail;
				$cc = $toEmail21;                       

				$subject="Request Dokumen SAS: <".$rupd['vNo_req_sas'].">";
				$content="Diberitahukan bahwa telah ada Request Dokumen SAS yang dialokasikan pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #DCDCDC;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 150px;'><b>No Request SAS</b></td><td style='width: 20px;'> : </td><td>".$rupd['vNo_req_sas']."</td>
							</tr>
							<tr>
								<td><b>No Komparator</b></td><td> : </td><td>".$rupd['no_req_komparator']."</td>
							</tr>
							<tr>
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['nama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['nip_pengusul']."-".$rupd['nama_pengusul']."</td>
							</tr>
							<tr>
								<td><b>Sediaan</b></td><td> : </td><td>".$rupd['sediaan']."</td>
							</tr>
							<tr>
								<td><b>Harga</b></td><td> : </td><td>".$rupd['harga']."</td>
							</tr>
							<tr>
								<td><b>Jumlah Sample</b></td><td> : </td><td>".$rupd['sample']."</td>
							</tr>
							<tr>
								<td><b>Tgl Expired</b></td><td> : </td><td>".$rupd['tglExpired']."</td>
							</tr>
						</table><br />
					</div><br/>
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}
}

function approve_view() {
		$echo = "<script type='text/javascript'>
					 function submit_ajax(form_id) {
						return $.ajax({
					 	 	url: $('#'+form_id).attr('action'),
					 	 	type: $('#'+form_id).attr('method'),
					 	 	data: $('#'+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = '".base_url()."processor/plc/dokumen/sas/export';								
								if(o.status == true) {
									
										$('#alert_dialog_form').dialog('close');
										var o = $.parseJSON(data);
										var last_id = o.last_id;
										var company_id = o.company_id;
										var group_id = o.group_id;
										var modul_id = o.modul_id;
										var foreign_id = o.foreign_id;
										
										$('#grid_dokumen_sas_export').trigger('reloadGrid');
											info = 'info';
											header = 'Info';
											
											$.get(base_url+'processor/plc/dokumen/sas/export?action=update&id='+last_id+'&foreign_key='+foreign_id+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
						                            $('div#form_dokumen_sas_export').html(data);
						                            $('html, body').animate({scrollTop:$('#dokumen_sas_export').offset().top - 20}, 'slow');
						                    });
									
								}
									reload_grid('grid_dokumen_sas_export');
							}
					 	 	
					 	 })
					 }
				 </script>";
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_dokumen_sas_export_approve" action="'.base_url().'processor/plc/dokumen/sas/export?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_dok_sas_id" value="'.$this->input->get('idossier_dok_sas_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_dokumen_sas_export_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_dok_sas_id = $post['idossier_dok_sas_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove_sas'=>'2','cApproval_sas'=>$cNip , 'dApproval_sas'=>date('Y-m-d H:i:s'), 'vRemark'=>$vRemark);
		$this -> db -> where('idossier_dok_sas_id', $idossier_dok_sas_id);
		$updet = $this -> db -> update('dossier.dossier_dok_sas', $data);


		$data['status']  = true;
		$data['last_id'] = $post['idossier_dok_sas_id'];
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_dokumen_sas_export_vRemark").val();
					 	if (remark=="") {
					 		alert("Remark tidak boleh kosong ");
					 		return
					 	}
					 	return $.ajax({
					 		url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/dokumen/sas/export";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_dokumen_sas_export").html(data);
									});
									
								}
									reload_grid("grid_dokumen_sas_export");
							}
					 	 	
					 	 })
					
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_dokumen_sas_export_reject" action="'.base_url().'processor/plc/dokumen/sas/export?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_dok_sas_id" value="'.$this->input->get('idossier_dok_sas_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="reject_dokumen_sas_export_vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_dokumen_sas_export_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	
	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_dok_sas_id = $post['idossier_dok_sas_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove_sas'=>'1','cApproval_sas'=>$cNip , 'dApproval_sas'=>date('Y-m-d H:i:s'), 'vRemark'=>$vRemark);
		$this -> db -> where('idossier_dok_sas_id', $idossier_dok_sas_id);
		$updet = $this -> db -> update('dossier.dossier_dok_sas', $data);


		$data['status']  = true;
		$data['last_id'] = $post['idossier_dok_sas_id'];
		return json_encode($data);
	}


	
/*function pendukung end*/    	


	public function output(){
		$this->index($this->input->get('action'));
	}

}
