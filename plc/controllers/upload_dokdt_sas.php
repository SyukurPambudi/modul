<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class upload_dokdt_sas extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Dokumen Tambahan SAS');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_dok_td_sas');		
		$grid->setUrl('upload_dokdt_sas');
		$grid->addList('vNo_req_dok_td_sas','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','iFileupload_submit','employee.vName','dApprove');
		$grid->setSortBy('vNo_req_dok_td_sas');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vNo_req_dok_td_sas','idossier_dok_sas_id','vNama_bahan','dosis','vSediaan','vUpb_Ref','vEksisting','team_andev','vProduk_komparator','vUpd_no','vNo_req_komparator','dok_td','vFileSas');

		//setting widht grid
		$grid->setWidth('vNo_req_dok_td_sas', '100');
		$grid->setWidth('idossier_dok_sas_id', '150'); 
		$grid->setWidth('iFileupload_submit', '150');
		$grid->setWidth('dok_td', '100');
		$grid->setWidth('dApprove', '150');
		$grid->setWidth('vUpd_no', '150');
		$grid->setWidth('dossier_upd.vUpd_no', '150');
		$grid->setWidth('vNama_bahan', '200');
		$grid->setWidth('dossier_upd.vNama_usulan', '200');
		$grid->setWidth('dosis', '100'); 
		$grid->setWidth('vSediaan', '100'); 
		$grid->setWidth('vUpb_Ref', '100'); 
		$grid->setWidth('vEksisting', '100'); 
		$grid->setWidth('team_andev', '100'); 
		$grid->setWidth('vProduk_komparator', '100'); 
		$grid->setWidth('vNo_req_komparator', '60'); 
		$grid->setWidth('employee.vName', '100'); 
		
		
		//modif label
		$grid->setLabel('vNo_req_dok_td_sas','Nomor Permintaan TD');
		$grid->setLabel('idossier_dok_sas_id','No Req SAS');
		$grid->setLabel('iFileupload_submit','Status');
		$grid->setLabel('dok_td','Dokumen TD');
		$grid->setLabel('dApprove','Tanggal Approve');
		$grid->setLabel('vUpd_no','No Dossier');
		$grid->setLabel('dossier_upd.vUpd_no','No Dossier');
		$grid->setLabel('vNama_bahan','Nama Produk');
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Produk');
		$grid->setLabel('dosis','Kekuatan'); 
		$grid->setLabel('vSediaan', 'Sediaan'); 
		$grid->setLabel('vUpb_Ref', 'UPB Referensi'); 
		$grid->setLabel('vEksisting', 'Nama Eksisting'); 
		$grid->setLabel('team_andev', 'Team Andev'); 
		$grid->setLabel('vNo_req_komparator','No Req Komparator'); 
		$grid->setLabel('vProduk_komparator', 'Nama Produk Koparator'); 
		$grid->setLabel('employee.vName', 'Approved By');
		$grid->setLabel('vFileSas','File Dokumen Tambahan SAS');

		$grid->setFormUpload(TRUE);

		$grid->setSearch('vNo_req_dok_td_sas','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','iFileupload_submit');
		
		
	
		$grid->changeFieldType('iFileupload_submit','combobox','',array(''=>'-Pilih Semua-',0=>'Draft - Need to be Publish',1=>'Submited'));
		//$grid->changeFieldType('iDok_sas','combobox','',array(''=>'Pilih',0=>'Tidak',1=>'Ya'));
		

	//Field mandatori
		$grid->setQuery('dossier.dossier_dok_td_sas.iApprove',1);
		$grid->setQuery('dossier.dossier_dok_td_sas.iDok_Submit',1);
		
		//join table
		$grid->setJoinTable('dossier.dossier_dok_sas', 'dossier_dok_sas.idossier_dok_sas_id = dossier_dok_td_sas.idossier_dok_sas_id', 'inner');
		$grid->setJoinTable('dossier.dossier_komparator', 'dossier_komparator.idossier_komparator_id = dossier_dok_sas.idossier_komparator_id', 'inner');
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_komparator.idossier_upd_id', 'inner');
		$grid->setJoinTable('hrd.employee', 'employee.cNip = dossier_dok_td_sas.cApprove', 'inner');

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
				echo $grid->saved_form();
				break;
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
				$isUpload = $this->input->get('isUpload');
				$sql = array();
   				$file_name= "";
				$fileId = array();
				
				$path = realpath("files/plc/dok_dt_sas/");
				if (!file_exists( $path."/".$this->input->post('upload_dokdt_sas_idossier_dok_td_sas_id') )) {
					mkdir($path."/".$this->input->post('upload_dokdt_sas_idossier_dok_td_sas_id'), 0777, true);						 
				}	
				
				$cPic_sas = array();
				
				foreach($_POST as $key=>$value) {
											
					if ($key == 'cPic_sas') {
						foreach($value as $y=>$u) {
							$cPic_sas[$y] = $u;
						}
					}
					
					//
					if ($key == 'namafile') {
						foreach($value as $k=>$v) {
							$file_name[$k] = $v;
						}
					}
		
					//
					if ($key == 'fileid') {
						foreach($value as $k=>$v) {
							$fileId[$k] = $v;
						}
					}
				}
				//print_r($cPic_sas);
				$last_index = 0;	
						
   				if($isUpload) {
					$j = $last_index;		
							
								
					if (isset($_FILES['fileupload'])) {
						$this->hapusfile($path, $file_name, 'dossier_file_dok_dt_sas', $this->input->post('upload_dokdt_sas_idossier_dok_td_sas_id'));
						foreach ($_FILES['fileupload']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
								$name = $_FILES['fileupload']["name"][$key];
								$data['filename'] = $name;
								$data['id']=$this->input->post('upload_dokdt_sas_idossier_dok_td_sas_id');
								$data['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name, $path."/".$this->input->post('upload_dokdt_sas_idossier_dok_td_sas_id')."/".$name)) 
				 				{
				 					
									$sql[] = "INSERT INTO dossier_file_dok_dt_sas (idossier_dok_td_sas_id, vDok_sas_name, dDate_sas_dok, cPic_sas, cCreated,dCreate) 
										VALUES ('".$data['id']."', '".$data['filename']."','".$data['dInsertDate']."','".$cPic_sas[$j]."','".$data['nip']."','".$data['dInsertDate']."')";
									
								$j++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
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
					
				
					$r['status'] = true;
					$r['last_id'] = $this->input->post('upload_dokdt_sas_idossier_dok_td_sas_id');					
					echo json_encode($r);
					exit();
				}  else {
					
					if (is_array($file_name)) {									
						$this->hapusfile($path, $file_name, 'dossier_file_dok_dt_sas', $this->input->post('upload_dokdt_sas_idossier_dok_td_sas_id'));
					}							
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
function listBox_Action($row, $actions) {

		$q=mysql_query("select count(b.iteam_id) as jml from plc2.plc2_upb_team_item as a
			join plc2.plc2_upb_team as b on a.iteam_id=b.iteam_id
			where a.vnip='".$this->user->gNIP."' and b.vtipe='IR'");	
			$team=mysql_fetch_array($q);
		$q1=mysql_query("select count(b.iteam_id) as jml from plc2.plc2_upb_team_item as a
			join plc2.plc2_upb_team as b on a.iteam_id=b.iteam_id
			where a.vnip='".$this->user->gNIP."' and b.vtipe='TD'");	
			$team2=mysql_fetch_array($q1);
		$q3=mysql_query("select count(a.iteam_id) as jml1 from plc2.plc2_upb_team as a
			where a.vnip='".$this->user->gNIP."' and a.vtipe='IR'");	
			$manager=mysql_fetch_array($q3);
		$q4=mysql_query("select count(a.iteam_id) as jml1 from plc2.plc2_upb_team as a
			where a.vnip='".$this->user->gNIP."' and a.vtipe='TD'");	
			$manager1=mysql_fetch_array($q4);
			if($team['jml']==1){
				if ($row->iFileupload_submit<>0) {
			 		// status sudah diapprove or reject , button edit hide 
			 		 unset($actions['edit']);
		 		}
			}
			else if ($team2['jml']==1){
				if ($row->iFileupload_submit<>0) {
			 		// status sudah diapprove or reject , button edit hide 
			 		 unset($actions['edit']);
		 		}
			}
			else if ($manager['jml1']==1){
				if ($row->iFileupload_submit<>0) {
			 		// status sudah diapprove or reject , button edit hide 
			 		 unset($actions['edit']);
		 		}
			}
			else if ($manager1['jml1']==1){
				if ($row->iFileupload_submit<>0) {
			 		// status sudah diapprove or reject , button edit hide 
			 		 unset($actions['edit']);
		 		}
			}
			else{
				unset($actions['edit']);
			}
			return $actions;



	 }   

function updateBox_upload_dokdt_sas_vNo_req_dok_td_sas($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return= $value;
		$return .= '<input type="hidden" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';

		
	}
	
	return $return;
}	

function updateBox_upload_dokdt_sas_idossier_dok_sas_id($field, $id, $value, $rowData) {
	$sql = 'select b.vNo_req_sas as a1, a.idossier_dok_sas_id as b1 from dossier_dok_td_sas as a, dossier_dok_sas as b where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'"';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{

		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';

		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$dtkm['b1'].'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" class="" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="25" value="'.$dtkm['a1'].'"/>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/doksas?field=approve_dokdt_sas\',\'List Komparator\')" type="button">&nbsp;</button>';                
		            
	}
	return $return; 
	
}


function updateBox_upload_dokdt_sas_dosis($field, $id, $value, $rowData) {
	$sql = 'select c.dosis as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}

function updateBox_upload_dokdt_sas_vSediaan($field, $id, $value, $rowData) {
	$sql = 'select f.vSediaan as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}


function updateBox_upload_dokdt_sas_vUpb_Ref($field, $id, $value, $rowData) {
	$sql = 'select c.vupb_nomor as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}


function updateBox_upload_dokdt_sas_vEksisting($field, $id, $value, $rowData) {
	$sql = 'select c.vupb_nama as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}


function updateBox_upload_dokdt_sas_team_andev($field, $id, $value, $rowData) {
	$sql = 'select g.vteam as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f, plc2.plc2_upb_team as g where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id and e.iTeam_andev=g.iteam_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}


function updateBox_upload_dokdt_sas_vProduk_komparator($field, $id, $value, $rowData) {
	$sql = 'select e.cNip_pengusul as a1, e.vNama_usulan as b1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f, plc2.plc2_upb_team as g where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id and e.iTeam_andev=g.iteam_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1']." - ".$dtkm['b1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].' - '.$dtkm['b1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}


function updateBox_upload_dokdt_sas_vNama_bahan($field, $id, $value, $rowData) {
	$sql = 'select e.vNama_usulan as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f, plc2.plc2_upb_team as g, dossier.dossier_bahan_komparator as h where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id and e.iTeam_andev=g.iteam_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}


function updateBox_upload_dokdt_sas_vUpd_no($field, $id, $value, $rowData) {
	$sql = 'select e.vUpd_no as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f, plc2.plc2_upb_team as g, dossier.dossier_bahan_komparator as h where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id and e.iTeam_andev=g.iteam_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}


function updateBox_upload_dokdt_sas_vNo_req_komparator($field, $id, $value, $rowData) {
	$sql = 'select d.vNo_req_komparator as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f, plc2.plc2_upb_team as g, dossier.dossier_bahan_komparator as h where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id and e.iTeam_andev=g.iteam_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}

function updateBox_upload_dokdt_sas_dok_td($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;
	}
	else{
		$return = '<textarea name="'.$field.'"  id="'.$id.'" class="input_rows1" readonly="readonly" size="25" row="2">'.$value.'</textarea>';
	}
	return $return;
	
}	

function updateBox_upload_dokdt_sas_vFileSas($field, $id, $value, $rowData) {

		//return print_r($rowData);
	 	$idossier_dok_td_sas_id=$rowData['idossier_dok_td_sas_id'];
		$data['rows'] = $this->db_plc0->get_where('dossier.dossier_file_dok_dt_sas', array('idossier_dok_td_sas_id'=>$idossier_dok_td_sas_id))->result_array();
		return $this->load->view('upload_doktd_sas_file',$data,TRUE);
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
		$postData['iFileupload_submit']=0;
	} 
	else{$postData['iFileupload_submit']=1;} 
	return $postData; 

}

function manipulate_update_button($buttons, $rowData) {
	$cNip= $this->user->gNIP;

	$js = $this->load->view('upload_dokdt_sas_js');

/*
	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/dokumen/dt/sas?action=approve&idossier_dok_sas_id='.$rowData['idossier_dok_sas_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_approve_dokdt_sas">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/dokumen/dt/sas?action=reject&idossier_dok_sas_id='.$rowData['idossier_dok_sas_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_approve_dokdt_sas">Reject</button>';
*/
	$update = '<button onclick="javascript:update_btn_back(\'upload_dokdt_sas\', \''.base_url().'processor/plc/upload/dokdt/sas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_upload_dokdt_sas">Update As Submited</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'upload_dokdt_sas\', \''.base_url().'processor/plc/upload/dokdt/sas?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_upload_dokdt_sas">Update as Draft</button>';



	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if ($rowData['iFileupload_submit']== 0) {
			// jika masih draft , show button update draft & update submit 
			$buttons['update'] = $update.$updatedraft.$js;
		}else{
			// sudah disubmit , show button approval 
			
		}

		//$buttons['update'] = $update.$updatedraft.$approve.$reject.$js;
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
					$del = "delete from dossier.".$table." where idossier_dok_td_sas_id = {$lastId} and vDok_sas_name= '{$v}'";
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
			$sql = "SELECT vDok_sas_name from dossier.".$table." where idossier_dok_td_sas_id=".$lastId;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['vDok_sas_name'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT vDok_sas_name from dossier.".$table." where idossier_dok_td_sas_id=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM dossier.".$table." where idossier_dok_td_sas_id=".$lastId." and vDok_sas_name='".$row['vDok_sas_name']."'";			
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
/*function pendukung end*/    	


	public function output(){
		$this->index($this->input->get('action'));
	}

}
