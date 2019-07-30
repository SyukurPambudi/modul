<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class serah_terima_export extends MX_Controller {
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
		$grid->setTitle('Serah Terima Export');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_review');		
		$grid->setUrl('serah_terima_export');
		$grid->addList('dossier_upd.vUpd_no','dossier_upd.vNama_usulan','dossier_upd.iTeam_andev','dossier_upd.iSediaan','dossier_prioritas.iSemester','dossier_prioritas.iTahun');
		$grid->setSortBy('dossier_upd.vUpd_no');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('vUpd_no','vNama_usulan','iTeam_andev','iupb_id','dosis','nama_generik','sediaan_produk','dSerah_dossier','vRemark_ir','dTerima_dossier','vRemark_im','dTerima_dossier2','dDossier_selesai_periksa','cNip_periksa','iDossier_lengkap');

		//setting widht grid
		$grid ->setWidth('dossier_upd.vUpd_no', '100'); 
		$grid->setWidth('dossier_upd.iTeam_andev', '100'); 
		$grid->setWidth('dossier_upd.iSediaan', '100'); 
		$grid->setWidth('dossier_prioritas.iSemester', '150'); 
		$grid->setWidth('dossier_prioritas.iTahun', '100'); 
		$grid->setWidth('iKelengkapan_data', '100'); 
		$grid->setWidth('dossier_upd.vNama_usulan', '250'); 
		$grid->setWidth('lDeleted', '100'); 
		
		
		//modif label
		$grid->setLabel('vUpd_no','No UPD'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 

		$grid->setLabel('dossier_upd.vUpd_no','No UPD'); 
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Usulan'); 
		$grid->setLabel('dossier_upd.iTeam_andev','Team Andev'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 


		$grid->setLabel('iSubmit_kelengkapan1','Status Submit'); 
		$grid->setLabel('iKelengkapan_data','Status Confirm'); 
		$grid->setLabel('iTeam_andev','Team Andev'); 
		$grid->setLabel('iNegara','Negara'); 
		$grid->setLabel('cCek_kelengkapan2','Approval SPV'); 
		$grid->setLabel('cCek_kelengkapan3','Approval BDIRM'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 
		$grid->setLabel('dossier_prioritas.iSemester','Semester Prioritas'); 
		$grid->setLabel('dossier_prioritas.iTahun','Tahun Prioritas');
		$grid->setLabel('iupb_id','No UPB'); 

		$grid->setLabel('dPembuatan_dossier','Tgl Pembuatan Dossier'); 
		$grid->setLabel('dPeriksa_ir','Tgl Periksa IR SPV'); 
		$grid->setLabel('dPeriksa_bdirm','Tgl Periksa BDIRM'); 

		$grid->setLabel('dSerah_dossier','Tgl Penyerahan Dossier oleh IR'); 
		$grid->setLabel('dTerima_dossier','Tgl Penerimaan Dossier Oleh IM'); 
		$grid->setLabel('vRemark_im','Keterangan IM '); 
		$grid->setLabel('vRemark_ir','Keterangan IR Staff '); 
		$grid->setLabel('dTerima_dossier2','Input Tanggal Penerimaan 2 '); 
		$grid->setLabel('dDossier_selesai_periksa','Tgl Dossier Selesai diperiksa IM'); 
		$grid->setLabel('cNip_periksa','Pemeriksaan Dossier'); 
		$grid->setLabel('iDossier_lengkap','Dossier Lengkap'); 

		$grid->setFormUpload(TRUE);

		$grid->setSearch('dossier_upd.vUpd_no');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('dossier_upd.iSediaan','combobox','',array(''=>'Pilih','1'=>'Solid','2'=>'Non Solid'));
		$grid->changeFieldType('iKelengkapan_data','combobox','',array('0'=>'Waiting Approval','1'=>'Rejected','2'=>'Approved'));
		$grid->changeFieldType('iSubmit_kelengkapan1','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submited'));

	//Field mandatori
		$grid->setRequired('iSediaan');	
		$grid->setRequired('iTeam_andev');	
		$grid->setRequired('lDeleted');	
		$grid->setRequired('dSerah_dossier','vRemark_ir','dTerima_dossier','vRemark_im','dTerima_dossier2','dDossier_selesai_periksa','cNip_periksa','iDossier_lengkap');	

		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id', 'inner');		
		$grid->setJoinTable('dossier.dossier_prioritas_detail', 'dossier_prioritas_detail.idossier_upd_id = dossier_upd.idossier_upd_id', 'inner');
		$grid->setJoinTable('dossier.dossier_prioritas', 'dossier_prioritas.idossier_prioritas_id = dossier_prioritas_detail.idossier_prioritas_id', 'inner');

		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setQuery('dossier_upd.ihold', 0);

		$grid->setQuery('dossier_review.iapp_ir_buatdossier', 2);
		$grid->setQuery('dossier_review.iapp_bdi_buatdossier', 2);
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
				echo $grid->updated_form();
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
 	$mydept = $this->auth->my_depts(TRUE);
	$edit=$actions['edit'];
	unset($actions['edit']);
	unset($actions['delete']);
	if (isset($mydept)) {
		if((in_array('IR', $mydept))) {
			if($row->dSerah_dossier=='0000-00-00' && $row->iDossier_lengkap!=2){
				$actions['edit']=$edit;
			}
		}
		elseif ((in_array('IM', $mydept))) {
			if($row->dSerah_dossier!='0000-00-00' && $row->iDossier_lengkap!=2){
				$actions['edit']=$edit;
			}
		}
	}
	 return $actions;

 } 




function listBox_serah_terima_export_dossier_prioritas_iSemester ($value) {
	return 'Semester '.$value;
}

function listBox_serah_terima_export_dossier_upd_iTeam_andev ($value) {
	if ($value == 74) {
		$andev = 'Andev 1';
	}else{
		$andev = 'Andev 2';
	}

	return $andev;
}

function listBox_serah_terima_export_dossier_upd_iSediaan ($value) {
	if ($value == 1) {
		$sediaan = 'Solid';
	}else{
		$sediaan = 'Injection';
	}

	return $sediaan;
}

/*manipulasi view object form start*/


function updateBox_serah_terima_export_vUpd_no($field, $id, $value, $rowData) {
	$sql = 'select * from dossier.dossier_upd a where a.idossier_upd_id="'.$rowData['idossier_upd_id'].'" ';
	$data_upd = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];

	}else{

		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];
	}
	
	return $return;
}

function updateBox_serah_terima_export_vNama_usulan($field, $id, $value, $rowData) {
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

function updateBox_serah_terima_export_iTeam_andev($field, $id, $value, $rowData) {
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

function updateBox_serah_terima_export_iupb_id($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
		$sql = 'select pu.iupb_id , pu.vupb_nomor, pu.vupb_nama,pu.dosis,pu.isediaan_id,pu.vgenerik ,ms.vsediaan
				from plc2.plc2_upb pu 
				join hrd.mnf_sediaan ms on ms.isediaan_id=pu.isediaan_id where pu.iupb_id ="'.$rows['iupb_id'].'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vupb_nomor'].' - '.$data_upb['vupb_nama'];

		}
		else{
			$return= $data_upb['vupb_nomor'].' - '.$data_upb['vupb_nama'];
		}
		
		return $return;
}


function updateBox_serah_terima_export_dosis($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
		$sql = 'select pu.iupb_id , pu.vupb_nomor, pu.vupb_nama,pu.dosis,pu.isediaan_id,pu.vgenerik ,ms.vsediaan
				from plc2.plc2_upb pu 
				join hrd.mnf_sediaan ms on ms.isediaan_id=pu.isediaan_id where pu.iupb_id ="'.$rows['iupb_id'].'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['dosis'];

		}
		else{
			$return= $data_upb['dosis'];
		}
		
		return $return;
}

function updateBox_serah_terima_export_nama_generik($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
		$sql = 'select pu.iupb_id , pu.vupb_nomor, pu.vupb_nama,pu.dosis,pu.isediaan_id,pu.vgenerik ,ms.vsediaan
				from plc2.plc2_upb pu 
				join hrd.mnf_sediaan ms on ms.isediaan_id=pu.isediaan_id where pu.iupb_id ="'.$rows['iupb_id'].'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vgenerik'];

		}
		else{
			$return= $data_upb['vgenerik'];
		}
		
		return $return;
}

function updateBox_serah_terima_export_sediaan_produk($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
		$sql = 'select pu.iupb_id , pu.vupb_nomor, pu.vupb_nama,pu.dosis,pu.isediaan_id,pu.vgenerik ,ms.vsediaan
				from plc2.plc2_upb pu 
				join hrd.mnf_sediaan ms on ms.isediaan_id=pu.isediaan_id where pu.iupb_id ="'.$rows['iupb_id'].'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vsediaan'];

		}
		else{
			$return= $data_upb['vsediaan'];
		}
		
		return $return;
}

function updateBox_serah_terima_export_dSerah_dossier($field, $id, $value, $rowData) {
		//$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cCek_kelengkapan2']))->row_array();
		$mydept = $this->auth->my_depts(TRUE);
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return ="";
			if (isset($mydept)) {
				if((in_array('IR', $mydept))) {
					if ($value != '0000-00-00') {
						$return .= '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';						
						
					}else{
						if($value=='0000-00-00'){
							$value="";
						}
						// jika belum diisi tanggal penyerahan
						$return .= '<input type="text" class="required" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="" class="input_rows1 required" size="15" />';
						$return .='<script>
							 $("#'.$id.'").datepicker({	changeMonth:true,
														changeYear:true,
														dateFormat:"yy-mm-dd" });
						</script>';	
						
					}

					
				}else{
					$return .= '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';

				}
			}
		
		}
		
		return $return;
}

function updateBox_serah_terima_export_dDossier_selesai_periksa($field, $id, $value, $rowData) {
		$mydept = $this->auth->my_depts(TRUE);
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return ="";
			if (isset($mydept)) {
				if((in_array('IM', $mydept))) {
					if ($value != '0000-00-00') {
						$return .= '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';						
						
					}else{
						if($value=='0000-00-00'){
							$value="";
						}
						// jika belum diisi tanggal penyerahan
						$return .= '<input type="text" class="required" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="" class="input_rows1 required" size="15" />';
						$return .='<script>
							 $("#'.$id.'").datepicker({	changeMonth:true,
														changeYear:true,
														dateFormat:"yy-mm-dd" });
						</script>';	
						
					}

					
				}else{
					if($rowData['dSerah_dossier']=='0000-00-00' or $rowData['dSerah_dossier']=='' or $rowData['iDossier_lengkap']==''){
						$return .= '
							<script type="text/javascript">
								$("label[for=\''.$id.'\']").hide();
								$("label[for=\''.$id.'\']").next().css("margin-left",0);
							</script>
						';		
					}else{
						$return .= '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
					}
				}
			}
		
		}
		
		return $return;
}

function updateBox_serah_terima_export_dTerima_dossier($field, $id, $value, $rowData) {
		$mydept = $this->auth->my_depts(TRUE);
		if ($this->input->get('action') == 'view') {
			$return= $value;
		}
		else{
			$return ="";
			if (isset($mydept)) {
				if((in_array('IM', $mydept))) {
					if ($rowData['dSerah_dossier'] !="0000-00-00") {
						// jika tanggal serah sudah diisi 
						if ($value != '0000-00-00') {
							$return .= '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
						}else{
							if($value=='0000-00-00'){
								$value="";
							}
							$return .= '<input type="text"  name="'.$field.'" readonly="readonly" id="'.$id.'" value="" class="input_rows1 required" size="15" />';
							$return .='<script>
								 $("#'.$id.'").datepicker({	changeMonth:true,
															changeYear:true,
															dateFormat:"yy-mm-dd" });
							</script>';	
						}
					}else{
						$return .= '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
					}

					
				}else{
					if($rowData['dSerah_dossier']=='0000-00-00' or $rowData['dSerah_dossier']=='' or $rowData['iDossier_lengkap']==''){
						$return .= '
							<script type="text/javascript">
								$("label[for=\''.$id.'\']").hide();
								$("label[for=\''.$id.'\']").next().css("margin-left",0);
							</script>
						';		
					}else{
						$return .= '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
					}
				}
			}
		
		}
		
		return $return;
}

function updateBox_serah_terima_export_vRemark_im($field, $id, $value, $rowData) {
		$mydept = $this->auth->my_depts(TRUE);
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return ="";
			if (isset($mydept)) {
				if((in_array('IM', $mydept))) {
					if ($rowData['dSerah_dossier'] !="0000-00-00") {
						//jika tanggal serah sudah diisi
						if ($value != '') {
							$return .='<textarea name="'.$field.'" readonly="readonly">'.nl2br($value).'</textarea>';
						}else{
							$return .='<textarea name="'.$field.'" class="required">'.nl2br($value).'</textarea>';	
						}
						
					}else{
						$return .='<textarea name="'.$field.'" readonly="readonly">'.nl2br($value).'</textarea>';
					}
					
					
				}else{
					if($rowData['dSerah_dossier']=='0000-00-00' or $rowData['dSerah_dossier']=='' or $rowData['iDossier_lengkap']==''){
						$return .= '
							<script type="text/javascript">
								$("label[for=\''.$id.'\']").hide();
								$("label[for=\''.$id.'\']").next().css("margin-left",0);
							</script>
						';		
					}else{
						$return .='<textarea name="'.$field.'" readonly="readonly">'.nl2br($value).'</textarea>';
					}

				}
			}
		
		}
		
		return $return;
}

function updateBox_serah_terima_export_vRemark_ir($field, $id, $value, $rowData) {
		//$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cCek_kelengkapan2']))->row_array();
		$mydept = $this->auth->my_depts(TRUE);
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return ="";
			if (isset($mydept)) {
				if((in_array('IR', $mydept))) {
						if($rowData['dSerah_dossier']=='0000-00-00' or $rowData['dSerah_dossier']=='' or $rowData['iDossier_lengkap']==''){
							$return .='<textarea name="'.$field.'" class="required">'.nl2br($value).'</textarea>';
						}else{
							$return .='<textarea name="'.$field.'" readonly="readonly">'.nl2br($value).'</textarea>';
						}
				}else{
					// disini
					$return .='<textarea name="'.$field.'" readonly="readonly">'.nl2br($value).'</textarea>';
				}
			}
		
		}

		
		return $return;
}


function updateBox_serah_terima_export_dTerima_dossier2($field, $id, $value, $rowData) {
		//$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cCek_kelengkapan2']))->row_array();
		$mydept = $this->auth->my_depts(TRUE);
		$tUpdate = date('Y-m-d H:i:s');
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return ="";
			if (isset($mydept)) {
				if((in_array('IM', $mydept))) {
					if ($rowData['vRemark_ir'] !="") {
						if ($value != '0000-00-00') {
							$return .= '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
						}else{
							$return .= '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'"  class="input_rows1 required" size="15" />';
							$return .= '<input type="hidden" name="dAccept_im"  readonly="readonly" id="dAccept_im" value="'.$tUpdate.'"  class="input_rows1 required" size="15" />';
							$return .='<script>
								 $("#'.$id.'").datepicker({	changeMonth:true,
															changeYear:true,
															dateFormat:"yy-mm-dd" });
							</script>';
						}
						
					}else{
						$return .= '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
					}
					
				}else{
					if($rowData['dSerah_dossier']=='0000-00-00' or $rowData['dSerah_dossier']=='' or $rowData['iDossier_lengkap']==''){
						$return .= '
							<script type="text/javascript">
								$("label[for=\''.$id.'\']").hide();
								$("label[for=\''.$id.'\']").next().css("margin-left",0);
							</script>
						';		
					}else{
						$return .= '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
					}
				}
			}
		
		}
		
		return $return;
}

function updateBox_serah_terima_export_cNip_periksa($field, $id, $value, $rowData) {

		$mydept = $this->auth->my_depts(TRUE);

		$value=$value==""?$this->user->gNIP:$value;
		$sq="select * from hrd.employee em where em.cNip='".$value."'";
		$dt=$this->dbset->query($sq)->row_array();

		if ($this->input->get('action') == 'view') {
			$return= $dt['cNip']."-".$dt['vName'];

		}else{
			$return ="";
			if (isset($mydept)) {
				if((in_array('IM', $mydept))) {
						// jika belum diisi tanggal penyerahan
					$return .= $dt['cNip']."-".$dt['vName'];
					$return .= '<input type="hidden" class="required" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" />';						
					
				}else{
					if($rowData['dSerah_dossier']=='0000-00-00' or $rowData['dSerah_dossier']=='' or $rowData['iDossier_lengkap']==''){
						$return .= '
							<script type="text/javascript">
								$("label[for=\''.$id.'\']").hide();
								$("label[for=\''.$id.'\']").next().css("margin-left",0);
							</script>
						';		
					}else{
						$return .= $dt['cNip']."-".$dt['vName'];
						$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" />';
					}
				}
			}
		
		}
		
		return $return;
}

function updateBox_serah_terima_export_iDossier_lengkap($field, $id, $value, $rowData) {
		$dat=array(1=>'No',2=>'Yes');
		$ret="<select id='".$id."' name='".$field."' class='required'>";
		$ret.='<option value="">Pilih Kelengkapan</option>';
		foreach ($dat as $kdat => $vdat) {
			$sel=$kdat==$value?"selected":"";
			$ret.="<option value=".$kdat." ".$sel.">".$vdat."</option>";
		}
		$ret.="</select>";
		$mydept = $this->auth->my_depts(TRUE);
		if ($this->input->get('action') == 'view') {
			$return= $dat[$value];

		}
		else{
			$return ="";
			if (isset($mydept)) {
				if((in_array('IM', $mydept))) {
					$return=$ret;						
					
				}else{
					if($rowData['dSerah_dossier']=='0000-00-00' or $rowData['dSerah_dossier']=='' or $rowData['iDossier_lengkap']==''){
						$return .= '
							<script type="text/javascript">
								$("label[for=\''.$id.'\']").hide();
								$("label[for=\''.$id.'\']").next().css("margin-left",0);
							</script>
						';		
					}else{
						$return=$ret;
					}
				}
			}
		
		}
		
		return $return;
}

function after_update_processor($row, $insertId, $postData, $old_data) {
			$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.vupb_nomor,c.vupb_nama,d.vName,b.dTanggal_upd,a.iSubmit_kelengkapan1
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.plc2_upb c on c.iupb_id = b.idossier_upd_id
				join hrd.employee d on d.cNip=b.cNip_pengusul
				where a.idossier_review_id = '".$postData['idossier_review_id']."'";
			$rupd = $this->db_plc0->query($qupd)->row_array();
			$iTeamandev="";
			if ($rupd['ad'] == 74) {
			$iTeamandev = 'Andev 1';
			}else{
				$iTeamandev = 'Andev 2';
			}
		if($postData['iDossier_lengkap']==1){ //Reject dari IM
			$sql="select * from plc2.plc2_upb_team te where te.vtipe='IR' and te.ldeleted=0";
			$dt=$this->dbset->query($sql)->result_array();
			$dtteam=array();
			foreach ($dt as $kt => $vt) {
				$dtteam[]=$vt['iteam_id'];
			}
			$team=implode(',', $dtteam);

			$toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_leader( $team );
            $toEmail2 = $this->lib_utilitas->get_email_leader( $team );                        

			$arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );

			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($arrEmail);
				$to = $arrEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
				}
			}			
			
			$to = $toEmail;
			$cc = $arrEmail.';'.$toEmail2;
			$subject="Serah Terima Dossier : UPD ".$rupd['vUpd_no'];
			$content="Diberitahukan bahwa telah ada revisi kelengkapan data dossier pada inputan Pemeriksaan Dossier oleh BDIRM  pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
				<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
					<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
						<tr>
							<td style='width: 110px;'><b>No UPD</b></td><td style='width: 20px;'> : </td><td>".$rupd['vUpd_no']."</td>
						</tr>
						<tr>
							<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
						</tr>
						<tr>
							<td><b>Tanggal UPD</b></td><td> : </td><td>".$rupd['dTanggal_upd']."</td>
						</tr>
						<tr>
							<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['cNip_pengusul'].' - '.$rupd['vName']."</td>
						</tr>
						<tr>
							<td><b>UPB</b></td><td> : </td><td>".$rupd['vupb_nomor'].' - '.$rupd['vupb_nama']."</td>
						</tr>
						<tr>
							<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
						</tr>
					</table>
				</div>";
			$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		}elseif($postData['iDossier_lengkap']==2){
			$sql="select * from plc2.plc2_upb_team te where te.vtipe='IM' and te.ldeleted=0";
			$dt=$this->dbset->query($sql)->result_array();
			$dtteam=array();
			foreach ($dt as $kt => $vt) {
				$dtteam[]=$vt['iteam_id'];
			}
			$team=implode(',', $dtteam);

			$toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_leader( $team );
            $toEmail2 = $this->lib_utilitas->get_email_leader( $team );                        

			$arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );

			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($arrEmail);
				$to = $arrEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
				}
			}			
			
			$to = $toEmail;
			$cc = $arrEmail.';'.$toEmail2;
			$subject="Serah Terima Dossier : UPD ".$rupd['vUpd_no'];
			$content="Diberitahukan bahwa telah ada inputan Pemeriksaan Dossier oleh BDIRM  pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
				<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
					<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
						<tr>
							<td style='width: 110px;'><b>No UPD</b></td><td style='width: 20px;'> : </td><td>".$rupd['vUpd_no']."</td>
						</tr>
						<tr>
							<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
						</tr>
						<tr>
							<td><b>Tanggal UPD</b></td><td> : </td><td>".$rupd['dTanggal_upd']."</td>
						</tr>
						<tr>
							<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['cNip_pengusul'].' - '.$rupd['vName']."</td>
						</tr>
						<tr>
							<td><b>UPB</b></td><td> : </td><td>".$rupd['vupb_nomor'].' - '.$rupd['vupb_nama']."</td>
						</tr>
						<tr>
							<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
						</tr>
					</table>
				</div>";
			$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		}
		
}




/*function pendukung start*/  

function before_update_processor($row, $postData) {
	$iddo=$postData['iDossier_lengkap'];
	$mydept = $this->auth->my_depts(TRUE);
	if (isset($mydept)) {
		if((in_array('IR', $mydept))) {
			unset($postData['dTerima_dossier']);
			unset($postData['vRemark_im']);
			unset($postData['dTerima_dossier2']);
			unset($postData['dDossier_selesai_periksa']);
			unset($postData['cNip_periksa']);
			unset($postData['iDossier_lengkap']);
		}else{
			if($iddo==1){
				$postData['dSerah_dossier']='0000-00-00';
			}
		}
	}
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	return $postData;

}

function manipulate_update_button($buttons, $rowData) {
	$mydept = $this->auth->my_depts(TRUE);
	$update=$buttons['update'];
	unset($buttons['update']);
	if (isset($mydept)) {
		if((in_array('IR', $mydept))) {
			if($rowData['dSerah_dossier']=='0000-00-00' && $rowData['iDossier_lengkap']!=2){
				$buttons['update']=$update;
			}
		}
		elseif ((in_array('IM', $mydept))) {
			if($rowData['dSerah_dossier']!='0000-00-00' && $rowData['iDossier_lengkap']!=2){
				$buttons['update']=$update;
			}
		}
	}
	return $buttons;
	

}

public function output(){
		$this->index($this->input->get('action'));
	}

}

