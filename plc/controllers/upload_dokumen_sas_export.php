<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upload_dokumen_sas_export extends MX_Controller {
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
		$grid->setTitle('Upload Dokumen SAS');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_dok_sas');		
		$grid->setUrl('upload_dokumen_sas_export');
		$grid->addList('vNo_req_sas','dossier_komparator.vNo_req_komparator','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','iFileupload_submit','employee.vName','dApproval_sas','dossier_upd.iTeam_andev');
		$grid->setSortBy('vNo_req_sas');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vNo_req_sas','idossier_komparator_id','vUpd_no','vNama_Bahan','dosis','vSediaan','vUpb_Ref','vEksisting','team_andev','vProduk_komparator','harga','Tgl_Expired','jml_sample_tersedia','no_batch_id','dApproval_sas','cApproval_sas','vFileSas');

		//setting widht grid
		$grid->setWidth('vSupplierName', '200'); 
		$grid->setWidth('vTags', '230'); 
		$grid->setWidth('dCreated', '100'); 
		$grid->setWidth('vNote', '220'); 
		$grid->setWidth('cCreatedBy', '220'); 
		$grid->setWidth('iStatus', '100');
		$grid->setWidth('dossier_upd.iTeam_andev','-5'); 

		
	//setting widht grid
		$grid->setWidth('vNo_req_sas', '80'); 
		$grid->setWidth('idossier_komparator_id', '80'); 
		$grid->setWidth('employee.vName', '100'); 
		$grid->setWidth('dossier_upd.vUpd_no', '100'); 
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
		$grid->setWidth('iFileupload_submit', '200'); 
		$grid->setWidth('employee.vName', '150'); 
		$grid->setWidth('jml_sample_tersedia', '100'); 
		$grid->setWidth('dossier_komparator.vNo_req_komparator', '60'); 
		$grid->setWidth('dApproval_sas', '120'); 
		
		
		//modif label
		$grid->setLabel('vNo_req_sas','No Req SAS'); 
		$grid->setLabel('dossier_komparator.vNo_req_komparator','No Req Komparator'); 
		$grid->setLabel('idossier_komparator_id','No Req Komparator'); 
		$grid->setLabel('employee.vName','Approve SAS'); 
		$grid->setLabel('dossier_upd.vUpd_no','No Dossier'); 
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
		$grid->setLabel('iFileupload_submit', 'Status '); 
		$grid->setLabel('jml_sample_tersedia', 'Jml Sample Tersedia'); 
		$grid->setLabel('cApproval_sas', 'Approve By'); 
		$grid->setLabel('vFileSas','File Dokumen SAS');
		
		$grid->setFormUpload(TRUE);

		$grid->setSearch('vNo_req_sas','dossier_komparator.vNo_req_komparator','dossier_upd.vUpd_no','iFileupload_submit');
		
		
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iFileupload_submit','combobox','',array(''=>'Pilih Semua',0=>'Draft - Need to be Publish',1=>'Submited'));
	
		//view sesuai dengan team andev nya
		//$grid->setQuery('dossier_upd.iTeam_andev IN ('.$this->auth->my_teams().')', null);

		//Approve Dokumen SAS
		$grid->setQuery('iApprove_sas',2);
		
	//Join Table
		$grid->setJoinTable('dossier.dossier_komparator', 'dossier_komparator.idossier_komparator_id = dossier_dok_sas.idossier_komparator_id', 'inner');
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_komparator.idossier_upd_id', 'inner');
		$grid->setJoinTable('hrd.employee', 'employee.cNip = dossier_dok_sas.cApproval_sas', 'inner');
		
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_upd.lDeleted', 0);
		
		//Set View Gridnya (Default = grid)
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
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
				$isUpload = $this->input->get('isUpload');
				$post=$this->input->post();
				
				$iupload=$post['upload_dokumen_sas_export_idossier_dok_sas_id'];
				$path = realpath("files/plc/dok_sas/");
				if(!file_exists($path."/".$iupload)){
					if (!mkdir($path."/".$iupload, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
				$cpic_updoksas = array();	
				$fileid='';
				foreach($_POST as $key=>$value) {
										
					if ($key == 'cpic_updoksas') {
						foreach($value as $y=>$u) {
							$cpic_updoksas[$y] = $u;
						}
					}
					if ($key == 'namafile_updoksas') {
						foreach($value as $k=>$v) {
							$file_name[$k] = $v;
						}
					}
					if ($key == 'fileid_updoksas') {
						$i=0;
						foreach($value as $k=>$v) {
							if($i==0){
								$fileid .= "'".$v."'";
							}else{
								$fileid .= ",'".$v."'";
							}
							$i++;
						}
					}
				}
				
   				if($isUpload) {	
					if (isset($_FILES['fileupload_updoksas']))  {

						$i=0;
						foreach ($_FILES['fileupload_updoksas']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_updoksas']["tmp_name"][$key];
								$name =$_FILES['fileupload_updoksas']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$iupload."/".$name)) {
									$sql[] = "INSERT INTO dossier.dossier_file_dok_sas (idossier_dok_sas_id, vDok_sas_name, dDate_sas_dok, cPic_sas, cCreated,dCreate) 
										VALUES ('".$iupload."', '".$data['filename']."','".$data['dInsertDate']."','".$cpic_updoksas[$i]."','".$this->user->gNIP."','".$data['dInsertDate']."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sql as $q) {
							try {
								$this->dbset->query($q);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}

					$r['message']='Data Berhasil di Simpan';
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');				
					echo json_encode($r);
					exit();
				}  else {
					$fileid='';
					foreach($_POST as $key=>$value) {
						if ($key == 'fileid_updoksas') {
							$i=0;
							foreach($value as $k=>$v) {
								if($v!=''){
									if($i==0){
										$fileid .= "'".$v."'";
									}else{
										$fileid .= ",'".$v."'";
									}
								}
								$i++;
							}
						}
					}

					$tgl= date('Y-m-d H:i:s');
					$sql1="update dossier.dossier_file_dok_sas set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where idossier_dok_sas_id='".$iupload."'";
					if($fileid!=''){
						$sql1.=" and idossier_file_dok_sas_id not in (".$fileid.")";
					}
					//echo $sql1;exit();
					$this->dbset->query($sql1);
					echo $grid->updated_form();
				}
				break;
			case 'employee_list':
				$this->employee_list();
			case 'download':
				$this->download($this->input->get('file'));
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

    /*Maniupulasi Gird Start*/

    function listBox_Action($row, $actions) {
	    if($row->iFileupload_submit<>0){
	    	unset($actions['edit']);
	    }
    return $actions; 

	}

 /*function listBox_Action($row, $actions) {
 	$manager=0;
	$team=0;
	$manager1=0;
	$iteamman1=NULL;
	$iteam1=NULL;
	$team1=0;
	$sqman="select count(b.iteam_id) as jmlman from plc2.plc2_upb_team as b
		where b.vtipe='TD' and b.vnip='".$this->user->gNIP."'
		group by b.iteam_id";
	$datman=$this->dbset->query($sqman)->row_array();
	if(isset($datman['jmlman'])){
 		$manager=$datman['jmlman'];
 	}
 	$sqteam="select count(b.iteam_id) as jmlman from plc2.plc2_upb_team_item as b
		join plc2.plc2_upb_team as a on a.iteam_id=b.iteam_id
		where a.vtipe='TD' and b.vnip='".$this->user->gNIP."'
		group by b.iteam_id";
	$datteam=$this->dbset->query($sqteam)->row_array();
	if(isset($datteam['jmlman'])){
 		$team=$datteam['jmlman'];
 	}
 	$sqman1="select count(b.iteam_id) as jmlman, b.iteam_id as iteamman1 from plc2.plc2_upb_team as b
		where b.vtipe='AD' and b.vnip='".$this->user->gNIP."'
		group by b.iteam_id";
	$datman1=$this->dbset->query($sqman1)->row_array();
	if(isset($datman1['jmlman'])){
 		$manager1=$datman1['jmlman'];
 		$iteamman1=$datman1['iteamman1'];
 	}
 	$sqteam1="select count(b.iteam_id) as jmlman, b.iteam_id as iteam1 from plc2.plc2_upb_team_item as b
		join plc2.plc2_upb_team as a on a.iteam_id=b.iteam_id
		where a.vtipe='AD' and b.vnip='".$this->user->gNIP."'
		group by b.iteam_id";
	$datteam1=$this->dbset->query($sqteam1)->row_array();
	if(isset($datteam1['jmlman'])){
 		$team1=$datteam1['jmlman'];
 		$iteam1=$datteam1['iteam1'];
 	}

 	if (($manager<>0) or ($team<>0)){
 		if ($row->iFileupload_submit<>0){
 			 unset($actions['edit']);
 		}
 	}
 	else if (($manager1<>0) or ($team1<>0)) {
 		if($row->iFileupload_submit==0){
 			if($row->dossier_upd__iTeam_andev==$iteamman1){
 				$actions['edit'];
 			}
 			else if($row->dossier_upd__iTeam_andev==$iteam1){
 				$actions['edit'];
 			}
 			else{
		 		unset($actions['edit']);
		 		//$actions['edit'];
		 	}
 		}
 		else{
 			unset($actions['edit']);
 		}
 		//$actions['edit'];
 	}
 	else{
 		unset($actions['edit']);
 		//$actions['edit'];
 	}
	return $actions;
} 
   */
/*Maniupulasi Gird end*/

/*manipulasi view object form start*/
 	
/*manipulasi view object form end*/

/*manipulasi proses object form start*/

   
/*manipulasi proses object form end*/    
function updateBox_upload_dokumen_sas_export_vNo_req_sas($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return= $value;
		$return .= '<input type="hidden" name="'.$id.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />
		<input type="hidden" name="isdraft" id="isdraft">';

		
	}
	
	return $return;
}	

function updateBox_upload_dokumen_sas_export_idossier_komparator_id($field, $id, $value, $rowData) {
$sql = 'select vNo_req_komparator as a from dossier_komparator where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" ';
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

		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="25" value="'.$data_kom['a'].'"/>';
		//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/komparator/export?field=dokumen_sas\',\'List Komparator\')" type="button">&nbsp;</button>';                
		            
	}
	return $return; 
	
}	

function updateBox_upload_dokumen_sas_export_vUpd_no($field, $id, $value, $rowData) {
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

function updateBox_upload_dokumen_sas_export_vNama_Bahan($field, $id, $value, $rowData) {
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

function updateBox_upload_dokumen_sas_export_dosis($field, $id, $value, $rowData) {
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

function updateBox_upload_dokumen_sas_export_vSediaan($field, $id, $value, $rowData) {
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

function updateBox_upload_dokumen_sas_export_vUpb_Ref($field, $id, $value, $rowData) {
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


function updateBox_upload_dokumen_sas_export_vEksisting($field, $id, $value, $rowData) {
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

function updateBox_upload_dokumen_sas_export_team_andev($field, $id, $value, $rowData) {
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

function updateBox_upload_dokumen_sas_export_vProduk_komparator($field, $id, $value, $rowData) {
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

function updateBox_upload_dokumen_sas_export_Tgl_Expired($field, $id, $value, $rowData) {
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

function updateBox_upload_dokumen_sas_export_harga($field, $id, $value, $rowData) {
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

function updateBox_upload_dokumen_sas_export_no_batch_id($field, $id, $value, $rowData) {
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

function updateBox_upload_dokumen_sas_export_jml_sample_tersedia($field, $id, $value, $rowData) {
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

function updateBox_upload_dokumen_sas_export_dApproval_sas($field, $id, $value, $rowData) {
	$return= $rowData['dApproval_sas'];
	$return .='<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" />';
	return $return;
}

function updateBox_upload_dokumen_sas_export_cApproval_sas($field, $id, $value, $rowData) {
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
		$palue .= '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" />';
		$return= $palue;
	}
	
	return $return;
}


function updateBox_upload_dokumen_sas_export_vFileSas($field, $id, $value, $rowData) {
	//return print_r($rowData);
 	$idossier_dok_sas_id=$rowData['idossier_dok_sas_id'];
	$data['rows'] = $this->db_plc0->get_where('dossier.dossier_file_dok_sas', array('idossier_dok_sas_id'=>$idossier_dok_sas_id,'lDeleted'=>0))->result_array();
	$sql="select * from hrd.employee em 
			inner join plc2.plc2_upb_team_item it on it.vnip=em.cNip
			where it.iteam_id in (".$this->auth->my_teams().")";
	$data['cpic']=$this->dbset2->query($sql)->result_array();
	return $this->load->view('upload_dokumen_sas_export_file',$data,TRUE);
}




/*function pendukung start*/    
function before_update_processor($row, $postData) {
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	//return $postData;
	// ubah status submit
	if($postData['isdraft']==true){
		$postData['iFileupload_submit']=0;
	} 
	else{$postData['iFileupload_submit']=1;} 

	return $postData;

}

function manipulate_update_button($buttons, $rowData) {
	$cNip= $this->user->gNIP;

	$js = $this->load->view('upload_dokumen_sas_export_js');
	$js .= $js .= $this->load->view('uploadjs');

	$update = '<button onclick="javascript:update_btn_back(\'upload_dokumen_sas_export\', \''.base_url().'processor/plc/upload/dokumen/sas/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_upload_dokumen_sas_export">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'upload_dokumen_sas_export\', \''.base_url().'processor/plc/upload/dokumen/sas/export?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_upload_dokumen_sas_export">Update as Draft</button>';



	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('TD', $manager)){
				$type='TD';
				if ($rowData['iFileupload_submit']<> 0) {
				}else{
					$buttons['update'] = $update.$updatedraft.$js;
				}
			}else{
				$type='';
			}
		}else{

			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('TD', $team)){
				$type='TD';
				if ($rowData['iFileupload_submit']<> 0) {
				}else{
					$buttons['update'] = $update.$updatedraft.$js;
				}
			}else{
				$type='';
			}
		}
	}
	return $buttons;
}


	function readDirektory($path, $empty="") {
		$filename = array();
				
		if (empty($empty)) {
			if ($handle = opendir($path)) {		
				while (false !== ($entry = readdir($handle))) {
				   if ($entry != '.' && $entry != '..' && $entry != '.svn') {			   		
						$filename[] = $entry;
					}
				}		
				closedir($handle);
			}
				
			$x =  $filename;
		} else {
			if ($handle = opendir($path)) {		
				while (false !== ($entry = readdir($handle))) {
				   if ($entry != '.' && $entry != '..' && $entry != '.svn') {			   		
						unlink($path."/".$entry);					
					}
				}		
				closedir($handle);
			}
			
			$x = "";
		}
		
		return $x;
	}

function hapusfile($path, $file_name, $table, $lastId){
		$path = $path."/".$lastId;
		//$path = $path."/".$lastId;
		$path = str_replace("\\", "/", $path);
		
		if (is_array($file_name)) {			
			$list_dir  = $this->readDirektory($path);
			$list_sql  = $this->readSQL($table, $lastId);
			asort($file_name);		
			asort($list_dir);		
			asort($list_sql);
			
			foreach($list_dir as $v) {				
				if (!in_array($v, $file_name)) {				
					unlink($path.'/'.$v);	
				}			
			}
			foreach($list_sql as $v) {
				if (!in_array($v, $file_name)) {
					$del = "delete from dossier.".$table." where idossier_dok_sas_id = {$lastId} and vDok_sas_name= '{$v}'";
					mysql_query($del);	
				}
				
			}
		} else {
			$this->readDirektory($path, 1);
			$this->readSQL($table, $lastId, 1);
		}
	} 

	function readSQL($table, $lastId, $empty="") {
		$list_file = array();
		if (empty($empty)) {
			$sql = "SELECT vDok_sas_name from dossier.".$table." where idossier_dok_sas_id=".$lastId;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['vDok_sas_name'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT vDok_sas_name from dossier.".$table." where idossier_dok_sas_id=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM dossier.".$table." where idossier_dok_sas_id=".$lastId." and vDok_sas_name='".$row['vDok_sas_name']."'";			
			}
			
			foreach($sql2 as $q) {
				try {
					mysql_query($q);
				}catch(Exception $e) {
					die($e);
				}
			}
			
		  $x = "";
		}
		
		return $x;
	}

	function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/dok_sas/'.$id.'/'.$name);	
		force_download($name, $path);
	}
/*function pendukung end*/    	

	
		public function output(){
		$this->index($this->input->get('action'));
	}

}
