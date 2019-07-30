<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class download_dokumen_export extends MX_Controller {
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
		$grid->setTitle('Download Dokumen');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_review');		
		$grid->setUrl('download_dokumen_export');
		$grid->addList('dossier_upd.vUpd_no','dossier_upd.vNama_usulan','dossier_upd.iTeam_andev','dossier_upd.iSediaan','dossier_prioritas.iSemester','dossier_prioritas.iTahun');
		$grid->setSortBy('dossier_upd.vUpd_no');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vUpd_no','vNama_usulan','iTeam_andev','rincian_dok');

		//setting widht grid
		$grid ->setWidth('dossier_upd.vUpd_no', '100'); 
		$grid->setWidth('dossier_upd.iTeam_andev', '100'); 
		$grid->setWidth('dossier_upd.iSediaan', '100'); 
		$grid->setWidth('dossier_prioritas.iSemester', '150'); 
		$grid->setWidth('dossier_prioritas.iTahun', '100'); 
		$grid->setWidth('iApprove_upload', '100'); 
		$grid->setWidth('dossier_upd.vNama_usulan', '250'); 
		$grid->setWidth('lDeleted', '100'); 
		
		
		//modif label
		$grid->setLabel('vUpd_no','No UPD'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 

		$grid->setLabel('dossier_upd.vUpd_no','No UPD'); 
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Usulan'); 
		$grid->setLabel('dossier_upd.iTeam_andev','Team Andev'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 


		$grid->setLabel('iSubmit_upload','Status Submit'); 
		$grid->setLabel('iApprove_upload','Status Confirm'); 
		$grid->setLabel('iTeam_andev','Team Andev'); 
		$grid->setLabel('iNegara','Negara'); 
		$grid->setLabel('dApprove_upload','Approve at'); 
		$grid->setLabel('cApprove_upload','Approve by'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 
		$grid->setLabel('dossier_prioritas.iSemester','Semester Prioritas'); 
		$grid->setLabel('dossier_prioritas.iTahun','Tahun Prioritas');
		$grid->setLabel('iKat_dok','Kategori Dokumen'); 

		$grid->setFormUpload(TRUE);

		$grid->setSearch('dossier_upd.vUpd_no');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('dossier_upd.iSediaan','combobox','',array(''=>'Pilih','1'=>'Solid','2'=>'Non Solid'));
		$grid->changeFieldType('iApprove_upload','combobox','',array('0'=>'Waiting Approval','1'=>'Rejected','2'=>'Approved'));
		$grid->changeFieldType('iSubmit_upload','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submited - Waiting Approval'));
		
		

	//Field mandatori
		$grid->setRequired('iSediaan');	
		$grid->setRequired('iTeam_andev');	
		$grid->setRequired('lDeleted');	

		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id', 'inner');		
		$grid->setJoinTable('dossier.dossier_prioritas_detail', 'dossier_prioritas_detail.idossier_upd_id = dossier_upd.idossier_upd_id', 'inner');
		$grid->setJoinTable('dossier.dossier_prioritas', 'dossier_prioritas.idossier_prioritas_id = dossier_prioritas_detail.idossier_prioritas_id', 'inner');
		$grid->setJoinTable('dossier.dossier_dok_list', 'dossier_dok_list.idossier_review_id = dossier_review.idossier_review_id', 'inner');
		$grid->setJoinTable('dossier.dossier_dokumen', 'dossier_dokumen.idossier_dokumen_id = dossier_dok_list.idossier_dokumen_id', 'inner');
		$grid->setJoinTable('dossier.dossier_kat_dok', 'dossier_kat_dok.idossier_kat_dok_id = dossier_dokumen.idossier_kat_dok_id', 'inner');

		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setQuery('dossier_review.lDeleted', 0);
		$grid->setQuery('dossier_review.iSubmit_kelengkapan1', 1);
		

		// group by reference hanya 1 field 
		//$grid->setGroupBy('dossier_kat_dok.vNama_Kategori','idossier_review_id');
		

		//$grid->setMultiSelect(true);
		
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
			case 'carinegara':
				$this->carinegara();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				//echo $grid->updated_form();
				$isUpload = $this->input->get('isUpload');
				$cNip = $this->user->gNIP;
				$tUpdated = date('Y-m-d H:i:s', mktime());		

				$sql = array();
   				$file_name= "";
				$fileId = array();
				$path = realpath("files/plc/dossier_dok/");
				
				if (!file_exists( $path."/".$this->input->post('idossier_review_id') )) {
					mkdir($path."/".$this->input->post('idossier_review_id'), 0777, true);						 
				}
									
				$file_keterangan = array();
				$namafile = array();
				$cPic = array();
				
				$idossier_dok_list_id = array();
				$idossier_dok_list_file_id = array();

				
				
				foreach($_POST as $key=>$value) {
											
					if ($key == 'fileketerangan') {
						foreach($value as $y=>$u) {
							$file_keterangan[$y] = $u;
						}
					}


					if ($key == 'cPic') {
						foreach($value as $y=>$u) {
							$cPic[$y] = $u;
						}
					}

					if ($key == 'namafile') {
						foreach($value as $y=>$u) {
							$namafile[$y] = $u;
						}
					}

					if ($key == 'idossier_dok_list_id') {
						foreach($value as $y=>$u) {
							$idossier_dok_list_id[$y] = $u;
						}
					}

					if ($key == 'idossier_dok_list_file_id') {
						foreach($value as $y=>$u) {
							$idossier_dok_list_file_id[$y] = $u;
						}
					}

					if ($key == 'doklis_file_id') {
						foreach($value as $y=>$u) {
							$doklis_file_id[$y] = $u;
						}
					}

					if ($key == 'doklis_id') {
						foreach($value as $y=>$u) {
							$doklis_id[$y] = $u;
						}
					}
					

					
					if ($key == 'iHapus') {
						foreach($value as $y=>$u) {
							$iHapus[$y] = $u;
						}
					}

					
					
					
				}
				
				$last_index = 0;	

				$jj = $last_index;	
				foreach($_POST['iHapus'] as $k=>$v) {
					if ( !empty($iHapus[$jj])) {
						$SQL2 = "UPDATE dossier.dossier_dok_list_file set cUpdate='{$cNip}', dupdate='{$tUpdated}' ,lDeleted='1',cPic=NULL,vFilename=NULL,vKeterangan=NULL where idossier_dok_list_file_id = '{$doklis_file_id[$jj]}'";
						$this->dbset->query($SQL2);

						$SQL3 = "UPDATE dossier.dossier_dok_list set cUpdate='{$cNip}', dupdate='{$tUpdated}' ,istatus_keberadaan='0' where idossier_dok_list_id = '{$doklis_id[$jj]}'";
						$this->dbset->query($SQL3);

					}
					$jj++;	
				}


				$j = $last_index;
   				if($isUpload) {
   					if (isset($_FILES['fileupload'])) {
						//$this->hapusfile($path, $file_name, 'brochure_file', $this->input->post('master_brosur_id'));
						foreach ($_FILES['fileupload']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
								$name = $_FILES['fileupload']["name"][$key];
								$data['filename'] = $name;
								$data['id']=$this->input->post('idossier_review_id');
								$data['nip']=$this->user->gNIP;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
				 				if(move_uploaded_file($tmp_name, $path."/".$this->input->post('idossier_review_id')."/".$name)) 
				 				{
				 					

				 					if ( $idossier_dok_list_file_id[$j] != '') {
				 						//update
				 						$sql[] = "UPDATE dossier.dossier_dok_list_file set cUpdate='{$cNip}', dupdate='{$tUpdated}' ,lDeleted='0' , cPic='{$cPic[$j]}', vFilename='{$data['filename']}', vKeterangan='{$file_keterangan[$j]}'  where idossier_dok_list_file_id = '{$idossier_dok_list_file_id[$j]}'	";
				 					
				 						$sql22='select * from dossier.dossier_dok_list_file a where a.idossier_dok_list_file_id ="'.$idossier_dok_list_file_id[$j].'"';
										$data_dok = $this->db_plc0->query($sql22)->row_array();
				 						
				 						$sql_up= "UPDATE dossier.dossier_dok_list set cUpdate='{$cNip}', dupdate='{$tUpdated}' ,istatus_keberadaan='1' where idossier_dok_list_id = '".$data_dok['idossier_dok_list_id']."' ";
										$this->dbset->query($sql_up);

				 					}else{
				 						// insert
				 					
									$sql[] = "INSERT INTO dossier_dok_list_file (idossier_dok_list_id, cPic, vFilename, vKeterangan,cCreated, dCreate) 
										VALUES ('".$idossier_dok_list_id[$j]."', '".$cPic[$j]."','".$data['filename']."','".$file_keterangan[$j]."','".$data['nip']."','".$data['dInsertDate']."')";
										$sql_up= "UPDATE dossier.dossier_dok_list set cUpdate='{$cNip}', dupdate='{$tUpdated}' ,istatus_keberadaan='1' where idossier_dok_list_id = '".$idossier_dok_list_id[$j]."' ";
										$this->dbset->query($sql_up);
									}

									
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
					
				
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->post('idossier_review_id');					
					echo json_encode($r);
					exit();

				}  else {
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
			default:
				$grid->render_grid();
				break;
		}
    }

 
   
 function listBox_Action($row, $actions) {

 	if ($row->iApprove_upload<>0) {
 		// status sudah diapprove or reject , button edit hide 
 		 unset($actions['edit']);
 		 unset($actions['delete']);
 	}
	 return $actions;

 } 


function listBox_download_dokumen_export_dossier_prioritas_iSemester ($value) {
	return 'Semester '.$value;
}

function listBox_download_dokumen_export_dossier_upd_iTeam_andev ($value) {
	if ($value == 74) {
		$andev = 'Andev 1';
	}else{
		$andev = 'Andev 2';
	}

	return $andev;
}

function listBox_download_dokumen_export_dossier_upd_iSediaan ($value) {
	if ($value == 1) {
		$sediaan = 'Solid';
	}else{
		$sediaan = 'Injection';
	}

	return $sediaan;
}

/*manipulasi view object form start*/


function updateBox_download_dokumen_export_vUpd_no($field, $id, $value, $rowData) {
	$sql = 'select * from dossier.dossier_upd a where a.idossier_upd_id="'.$rowData['idossier_upd_id'].'" ';
	$data_upd = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];

	}else{

		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];
	}
	
	return $return;
}

function updateBox_download_dokumen_export_vNama_usulan($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vNama_usulan'];

		}
		else{
			$return= $rows['vNama_usulan'];
			$return .= '
			<input type="hidden" name="isdraft" id="isdraft">
			';
		}
		
		return $return;
}

function updateBox_download_dokumen_export_iTeam_andev($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
		if ($rows['iTeam_andev']==74) {
			$tim = 'Andev 1';	
		}else{
			$tim = 'Andev 2';	
		}
		

		if ($this->input->get('action') == 'view') {
			$return= $tim;

		}
		else{
			$return= $tim;
		}
		
		return $return;
}


function updateBox_download_dokumen_export_cApprove_upload($field, $id, $value, $rowData) {
	
	

		if ($rowData['iApprove_upload'] <> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cApprove_upload']))->row_array();

			if ($rowData['iApprove_upload'] == 2) {
				$palue='Approved by '.$rows['vName'].', Remark :'.$rowData['vRemark_upload'] ;	
			}else{
				$palue='Rejected by '.$rows['vName'].', Remark :'.$rowData['vRemark_upload'];	
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

function updateBox_download_dokumen_export_dApprove_upload($field, $id, $value, $rowData) {
		if ($rowData['iApprove_upload'] <> 0 ) {
			$palue= $rowData['dApprove_upload'];
			
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

function updateBox_download_dokumen_export_rincian_dok($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();

		//$return1= print_r($rows);
		$data['iTeam_andev']	=$rows['iTeam_andev'];
		$data['rows'] = $rows;
		$data['iSediaan'] = $rows['iSediaan'];
		$data['idossier_upd_id'] =  $rows['idossier_upd_id'];
		$data['idossier_review_id'] =  $rowData['idossier_review_id'];

		$sql = "select * 
				from dossier.dossier_kat_dok a 
				where a.lDeleted=0";
    	$kats = $this->db_plc0->query($sql)->result_array();
    	$data['kats'] =  $kats;
		$return=  '<div style="margin-left:15px;">';
			$return.=  $this->load->view('download_dokumen_export',$data,TRUE);
		$return.=  '</div>';
		return $return;
		
}

/*function pendukung start*/  
	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		//print_r($_GET);
		//exit;
		//$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/dossier_dok/'.$id.'/'.$name);	
		force_download($name, $path);
	}

/*function pendukung end*/    	

	

	public function output(){
		$this->index($this->input->get('action'));
	}

}

