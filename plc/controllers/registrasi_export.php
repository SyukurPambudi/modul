<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class registrasi_export extends MX_Controller {
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
		$grid->setTitle('Registrasi UPD');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_upd');		
		$grid->setUrl('registrasi_export');
		$grid->addList('vUpd_no','vNama_usulan','vNo_nie','dExpdate','iRegistrasi');
		$grid->setSortBy('vUpd_no');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('vUpd_no','vNama_usulan','iTeam_andev','cNip_pengusul','dSubmit_dossier_registrasi','iperlutd','vNo_nie','dExpdate');

		//setting widht grid
		$grid ->setWidth('vUpd_no', '100'); 
		$grid->setWidth('lDeleted', '100'); 
		
		
		//modif label
		
		$grid->setLabel('iTeam_andev','Team Andev'); 
		$grid->setLabel('vUpd_no','No UPD'); 
		
		$grid->setLabel('iperlutd','Tambahan Data'); 
		$grid->setLabel('doktd','Dokumen Tambahan Data'); 
		$grid->setLabel('vNama_usulan','Nama Produk'); 
		$grid->setLabel('vNo_nie','Nomor NIE'); 
		$grid->setLabel('dExpdate','Berlaku s/d'); 
		$grid->setLabel('iRegistrasi','Status Registrasi'); 
		$grid->setLabel('iSubmit_registrasi','Status Submit '); 
		$grid->setLabel('dTanggal_upd','Tanggal UPD'); 
		$grid->setLabel('dApproval_upd','Tanggal Approve'); 
		$grid->setLabel('cApproval_direksi','Approve by'); 
		$grid->setLabel('dRegistrasi','Tgl Approval Registrasi di Negara Buyer');
		$grid->setLabel('cNip_pengusul','Requestor');
		$grid->setLabel('plc2_upb.vupb_nomor','No UPB'); 
		$grid->setLabel('iupb_id','No UPB');
		$grid->setLabel('dSubmit_dossier_registrasi','Tanggal Submit Dossier ke Buyer');
		$grid->setLabel('dApproval_registrasi','Tanggal Approval Registrasi ke Negara Buyer');
		$grid->setLabel('dPEB','Tanggal PEB');

		$grid->setFormUpload(TRUE);

		$grid->setSearch('vUpd_no','vNama_usulan','iRegistrasi');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		//$grid->changeFieldType('istatus','combobox','',array(''=>'Pilih','C'=>'Kontrak','A'=>'Tetap'));
		$grid->changeFieldType('lDeleted','combobox','',array(''=>'Pilih',0=>'Aktif',1=>'Tidak aktif'));
		$grid->changeFieldType('iSubmit_registrasi','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submited - Waiting Approval'));
		$grid->changeFieldType('iRegistrasi','combobox','',array(''=> 'Pilih',0=>'Belum Registrasi',1=>'Sudah Registrasi'));
		

	//Field mandatori
		$grid->setRequired('vUpd_no');	
		$grid->setRequired('vNama_usulan');	
		$grid->setRequired('lDeleted','iperlutd');	

		$grid->setRequired('dSubmit_dossier_registrasi','dApproval_registrasi','dRegistrasi','dExpdate','dPEB');	

		
		$grid->setJoinTable('hrd.employee', 'employee.cNip = dossier_upd.cNip_pengusul', 'inner');
		$grid->setJoinTable('dossier.dossier_review', 'dossier_review.idossier_upd_id = dossier_upd.idossier_upd_id', 'inner');
		//$grid->setQuery('dossier_upd.lDeleted', 0);
		//$grid->setQuery('dossier_upd.idossier_upd_id in (
		//												select a.idossier_upd_id
		//												from dossier.dossier_upd a
		//												join dossier.dossier_review b on b.idossier_upd_id=a.idossier_upd_id
		//												where a.lDeleted=0 and b.lDeleted=0
		//												#and b.dSerah_dossier != "0000-00-00"
		//												group by a.idossier_upd_id
		//
		//	)',NULL );

		//$grid->setQuery('dossier_review.dSerah_dossier != "0000-00-00" ',NULL);
		//$grid->setQuery('dossier_review.iDossier_lengkap',2);
		//$grid->setQuery('dossier_review.iapp_ir_buatdossier', 2);
		$grid->setQuery('dossier_review.irelease_imm', 1);
		//$grid->setQuery('dossier_review.iKelengkapan_data4', 2);


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
			case 'getspname':
				echo $this->getSpname();
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
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }

   
	 function listBox_Action($row, $actions) {

	 	if ($row->iRegistrasi<>0 && $row->vNo_nie<>'') {
	 		// status sudah diapprove or reject , button edit hide 
	 		 unset($actions['edit']);
	 		 unset($actions['delete']);
	 	}
		 return $actions;

	 } 

/*manipulasi view object form start*/

function updateBox_registrasi_export_vUpd_no($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
		}
		
		return $return;
}

function updateBox_registrasi_export_iperlutd($field, $id, $value, $rowData) {
		$kat = array(""=>'--Select--', 1=>'YES', 2=>'NO');
		 if ($this->input->get('action') == 'view') {
		 	if($value<>''){
		 		$o = $kat[$value];
		 	}else{
		 		$o = "-";
		 	}
            
        } else {
            $o  = "<select id='registrasi_export_iperlutd' class='combobox required' name='registrasi_export_iperlutd'>";            
            foreach($kat as $k=>$v) {
                if ($k == $value) $selected = " selected";
                else $selected = "";
                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
            }            
            $o .= "</select>";
        }
        return $o;
		
	}

	/*function updateBox_registrasi_export_doktd($field, $id, $value, $rowData) {
		$qr="select * from dossier.dosier_dok_reg_td where idossier_upd_id='".$rowData['idossier_upd_id']."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('export/view_td_registrasi',$data,TRUE);
	}*/



function updateBox_registrasi_export_dTanggal_upd($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
		}
		
		return $return;
}



function updateBox_registrasi_export_vNama_usulan($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
			
		}
		
		return $return;
}



function updateBox_registrasi_export_cNip_pengusul($field, $id, $value, $rowData) {
	$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $value.' - '.$rows['vName'];

		}
		else{
			$return= $value.' - '.$rows['vName'];
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
		}
		
		return $return;
}




function updateBox_registrasi_export_iupb_id($field, $id, $value, $rowData) {
	$sql = 'select pu.iupb_id , pu.vupb_nomor, pu.vupb_nama from plc2.plc2_upb pu where pu.iupb_id ="'.$value.'" ';
	$data_upb = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_upb['vupb_nomor'].' - '.$data_upb['vupb_nama'];

	}else{

		$return= $data_upb['vupb_nomor'].' - '.$data_upb['vupb_nama'];
		$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
	}
	
	return $return;
}

function updateBox_registrasi_export_iTeam_andev($field, $id, $value, $rowData) {
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



function updateBox_registrasi_export_kekuatan($field, $id, $value, $rowData) {
		$sql = 'select pu.iupb_id , pu.vupb_nomor, pu.vupb_nama,pu.dosis,pu.isediaan_id,pu.vgenerik ,ms.vsediaan
				from plc2.plc2_upb pu 
				join hrd.mnf_sediaan ms on ms.isediaan_id=pu.isediaan_id where pu.iupb_id ="'.$rowData['iupb_id'].'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['dosis'];

		}
		else{
			$return= $data_upb['dosis'];
		}
		
		return $return;
}


function updateBox_registrasi_export_vNo_nie($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return=  $value;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1" size="20" />';
			$return .= '<input type="hidden" name="iRegistrasi"  id="iRegistrasi" value="1" class="input_rows1 " size="3" />';
		}
		
		
		return $return;
}

function updateBox_registrasi_export_dRegistrasi($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return=  $value;

		}
		else{
			$return = '<input type="text" class="required" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
						$return .='<script>
							 $("#'.$id.'").datepicker({	changeMonth:true,
														changeYear:true,
														dateFormat:"yy-mm-dd" });
						</script>';	
		}
		
		return $return;
}
function updateBox_registrasi_export_dSubmit_dossier_registrasi($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return=  $value;

		}
		else{
			$return = '<input type="text" class="required" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
						$return .='<script>
							 $("#'.$id.'").datepicker({	changeMonth:true,
														changeYear:true,
														dateFormat:"yy-mm-dd" });
						</script>';	
		}
		
		return $return;
}

function updateBox_registrasi_export_dPEB($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return=  $value;

		}
		else{
			$return = '<input type="text" class="required" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
						$return .='<script>
							 $("#'.$id.'").datepicker({	changeMonth:true,
														changeYear:true,
														dateFormat:"yy-mm-dd" });
						</script>';	
		}
		
		return $return;
}
function updateBox_registrasi_export_dApproval_registrasi($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return=  $value;

		}
		else{
			$return = '<input type="text" class="required" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
						$return .='<script>
							 $("#'.$id.'").datepicker({	changeMonth:true,
														changeYear:true,
														dateFormat:"yy-mm-dd" });
						</script>';	
		}
		
		return $return;
}

function updateBox_registrasi_export_dExpdate($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return=  $value;

		}
		else{
			$return = '<input type="text" class="required" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
						$return .='<script>
							 $("#'.$id.'").datepicker({	changeMonth:true,
														changeYear:true,
														dateFormat:"yy-mm-dd" });
						</script>';	
		}
		
		return $return;
}




function updateBox_registrasi_export_sediaan_produk($field, $id, $value, $rowData) {
		$sql = 'select pu.iupb_id , pu.vupb_nomor, pu.vupb_nama,pu.dosis,pu.isediaan_id,pu.vgenerik ,ms.vsediaan
				from plc2.plc2_upb pu 
				join hrd.mnf_sediaan ms on ms.isediaan_id=pu.isediaan_id where pu.iupb_id ="'.$rowData['iupb_id'].'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vsediaan'];

		}
		else{
			$return= $data_upb['vsediaan'];
		}
		
		return $return;
}



function after_update_processor($row, $insertId, $postData, $old_data) {
		$logged_nip =$this->user->gNIP;
		/*$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.vupb_nomor,c.vupb_nama,d.vName,b.dTanggal_upd,a.iSubmit_kelengkapan1
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.plc2_upb c on c.iupb_id = b.idossier_upd_id
				join hrd.employee d on d.cNip=b.cNip_pengusul
				where b.idossier_upd_id = '".$insertId."'
				and a.dAccept_im is not null
				and a.lDeleted = 0";*/
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.C_ITENO,c.C_ITNAM,d.vName,b.dTanggal_upd
							,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
							from dossier.dossier_review a 
							join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
							join plc2.itemas c on c.C_ITENO=b.iupb_id
							join hrd.employee d on d.cNip=b.cNip_pengusul
							where b.idossier_upd_id = ".$insertId;
		$rupd = $this->db_plc0->query($qupd)->row_array();

		//$submit = $rupd['iSubmit_kelengkapan1'] ;
					$vkode="";
					if ($rupd['ad'] == 17) {
						$iTeamandev = 'Andev Export 1';
						$vkode="CK4_REV_TD1";
					}else{
						$iTeamandev = 'Andev Export 2';
						$vkode="CK4_REV_TD2";
					}
					$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
					$dt=$this->dbset->query($sql)->row_array();
					$to = $dt['tto'];
					$cc = $dt['tcc'];                        

					$subject="Registrasi Dossier : UPD ".$rupd['vUpd_no'];
					$content="Diberitahukan bahwa telah ada inputan Registrasi Dossier oleh IM  pada aplikasi PLC-Export dengan rincian sebagai berikut :<br><br>
						<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
							<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
								<tr>
									<td style='width: 110px;'><b>No UPD</b></td><td style='width: 5px;'> : </td><td>".$rupd['vUpd_no']."</td>
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
									<td><b>Produk</b></td><td> : </td><td>".$rupd['C_ITENO'].' - '.$rupd['C_ITNAM']."</td>
								</tr>
								<tr>
									<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
								</tr>
							</table>
						</div>
						<br/> 
						Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
						Post Master";
					$this->lib_utilitas->send_email($to, $cc, $subject, $content);
}



function manipulate_update_button($buttons, $rowData) {
	if ($this->input->get('action') == 'view') {
		unset($buttons['update_back']);
		unset($buttons['update']);	
	}else{
		if ( $rowData['iRegistrasi'] <> 0  && $rowData['vNo_nie'] <>'') {
				unset($buttons['update_back']);
				unset($buttons['update']);	
		}else{
			$js = $this->load->view('export/registrasi_export_js');
			$update = '<button onclick="javascript:update_btn_back(\'registrasi_export\', \''.base_url().'processor/plc/registrasi/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_update_registrasi_export">Update</button>';
			$buttons['update'] = $update.$js;
		}
	}

	return $buttons;
	
}
	

	function before_update_processor($row, $postData) {
	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;
	unset($postData['iTeam_andev']);
	//print_r($postData);exit();
	return $postData;

}
	

	public function output(){
		$this->index($this->input->get('action'));
	}

}

