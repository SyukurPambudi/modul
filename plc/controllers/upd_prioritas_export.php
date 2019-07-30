<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upd_prioritas_export extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_plcexport');
		$this->load->library('lib_utilitas');
		$this->load->library('dossier_log');
		$this->dbset = $this->load->database('plc0',false, true);
		$this->dbset2 = $this->load->database('plc0',false, true);
		$this->user = $this->auth_plcexport->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('UPD Prioritas');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_prioritas');		
		$grid->setUrl('upd_prioritas_export');
		$grid->addList('iSemester','iTahun','iTeam_andev','iSubmit_prio','iApprove_prio');
		$grid->setSortBy('iSemester');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('iSemester','iTahun','iTeam_andev','rincian_upd','iApprove_prio');

		//setting widht grid
		$grid ->setWidth('iSemester', '100'); 
		$grid->setWidth('iTahun', '100'); 
		
		
		//modif label
		$grid->setLabel('iSemester','Semester'); 
		$grid->setLabel('iTeam_andev','Team Andev'); 
		$grid->setLabel('iTahun','Tahun'); 
		$grid->setLabel('iApprove_prio','Status Approval'); 
		$grid->setLabel('iSubmit_prio','Status UPD Prioritas'); 
		//$grid->setLabel('iApprove_prio','Tgl Approval');
		$grid->setLabel('cApprove','Approve by');
		$grid->setLabel('rincian_upd','Rincian UPD');
		

		$grid->setFormUpload(TRUE);

		$grid->setSearch('iSemester','iTeam_andev');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		//$grid->changeFieldType('istatus','combobox','',array(''=>'Pilih','C'=>'Kontrak','A'=>'Tetap'));
		$grid->changeFieldType('iSubmit_prio','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submitted'));
		$grid->changeFieldType('iApprove_prio','combobox','',array(0=>'Waiting Approval',1=>'Rejected' , 2=>'Approved'));
		$grid->changeFieldType('iTeam_andev','combobox','',array(''=>'Pilih', 17=>'Andev Export 1', 40=>'Andev Export 2'));
	//Field mandatori
		$grid->setRequired('iSemester');	
		$grid->setRequired('iTahun');	
		$grid->setRequired('iTeam_andev');	



		
		$grid->setQuery('lDeleted', 0);
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
				$semester = $_POST['upd_prioritas_export_iSemester'];
				$tahun = $_POST['upd_prioritas_export_iTahun'];
				$post=$this->input->post();

                $cek_data = 'select * from dossier_prioritas a where a.iSemester="'.$semester.'" and a.iTahun="'.$tahun.'" and a.iTeam_andev="'.$post['upd_prioritas_export_iTeam_andev'].'"  and  a.iApprove_prio in (0,2) and  a.lDeleted=0 ';
                $data_cek = $this->dbset->query($cek_data)->row_array();
                if (empty($data_cek) ) {
                     echo $grid->saved_form();
                }else{
                    $r['status'] = FALSE;
                    $r['message'] = "Prioritas Untuk Tahun, Team Andev & Semester Sudah ada";
                    echo json_encode($r);
                }

				//echo $grid->saved_form();
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
				$semester = $_POST['upd_prioritas_export_iSemester'];
				$tahun = $_POST['upd_prioritas_export_iTahun'];
				$id=$_POST['upd_prioritas_export_idossier_prioritas_id'];
				$post=$this->input->post();
                $cek_data = 'select * from dossier_prioritas a where a.iSemester="'.$semester.'" and a.iTahun="'.$tahun.'" and a.iTeam_andev="'.$post['upd_prioritas_export_iTeam_andev'].'" and a.iApprove_prio in (0,2) and a.lDeleted=0 ';
                $data_cek = $this->dbset->query($cek_data)->row_array();

                $sql2 = 'select * from dossier_prioritas a where a.idossier_prioritas_id = "'.$id.'"';
				$old = $this->dbset->query($sql2)->row_array();

				
				if (empty($data_cek) or ( $old['iTahun'] == $tahun and  $old['iSemester'] == $semester and  $old['iTeam_andev']==$post['upd_prioritas_export_iTeam_andev'] ) ) {
                     echo $grid->updated_form();
                }else{
                    $r['status'] = FALSE;
                    $r['message'] = "Prioritas Untuk Tahun, Team Andev & Semester Sudah ada";
                    echo json_encode($r);
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

 
	function listBox_upd_prioritas_export_iSemester ($value) {
		return 'Semester '.$value;
	}

function listBox_Action($row, $actions) {

 	if ($row->iApprove_prio<>0) {
 		// status sudah diapprove or reject , button edit hide 
 		 unset($actions['edit']);
 		 unset($actions['delete']);
 	}
 	if($row->iSubmit_prio!=0){
 		 unset($actions['delete']);
 	}
 	$iTeam_andev=$row->iTeam_andev;
 	if($this->auth_plcexport->is_manager()){
		$x=$this->auth_plcexport->dept();
		$manager=$x['manager'];
		$q="select * from plc2.plc2_upb_team te where te.vnip in ('".$this->user->gNIP."')";
		
		if(in_array('BDI', $manager)){
			$type='BDI';
			$q.=" and vtipe='".$type."'";
			$d=$this->dbset->query($q)->row_array();
			if($d['iteam_id']==91){//BDIRM 1
				if($iTeam_andev!=17){
					unset($actions['edit']);
 		 			unset($actions['delete']);
				}
			}elseif ($d['iteam_id']==78) {
				if($iTeam_andev!=40){
					unset($actions['edit']);
 		 			unset($actions['delete']);
				}
			}
		}
	}else{
		$x=$this->auth_plcexport->dept();
		if(isset($x['team'])){
			$team=$x['team'];
			$q="select * from plc2.plc2_upb_team_item te 
			inner join plc2.plc2_upb_team it on it.iteam_id
			where te.vnip in ('".$this->user->gNIP."') and te.ldeleted=0 and it.ldeleted=0";
			if(in_array('BDI', $team)){
				$type='BDI';
				$q.=" and vtipe='".$type."'";
				$d=$this->dbset->query($q)->row_array();
				if($d['iteam_id']==91){//BDIRM 1
					if($iTeam_andev!=17){
						unset($actions['edit']);
	 		 			unset($actions['delete']);
					}
				}elseif ($d['iteam_id']==78) {
					if($iTeam_andev!=40){
						unset($actions['edit']);
	 		 			unset($actions['delete']);
					}
				}
			}
		}
	}
	return $actions;

} 


/*manipulasi view object form start*/
	function insertBox_upd_prioritas_export_iTahun ($field, $id) {
		$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-3;
		$sampai = $thn_sekarang+6;
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=$mulai; $i<=$sampai; $i++) {
			$echo .= '<option value="'.$i.'">'.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}

	function updateBox_upd_prioritas_export_iTahun ($field, $id, $value, $rowData) {
		$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-3;
		$sampai = $thn_sekarang+6;
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=$mulai; $i<=$sampai; $i++) {
			$selected = $value == $i ? 'selected' : '';
			$echo .= '<option '.$selected.' value="'.$i.'">'.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}

	function insertBox_upd_prioritas_export_iSemester ($field, $id) {
		$echo = '
		<input type="hidden" name="isdraft" id="isdraft">
		<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=1; $i<=2; $i++) {
			$echo .= '<option value="'.$i.'">Semester '.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	function updateBox_upd_prioritas_export_iSemester ($field, $id, $value, $rowData) {
		$echo = '
		<input type="hidden" name="isdraft" id="isdraft">
		<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=1; $i<=2; $i++) {
			$selected = $value == $i ? 'selected' : '';
			$echo .= '<option '.$selected.' value="'.$i.'">Semester '.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}


	function insertBox_upd_prioritas_export_rincian_upd ($field, $id) {
		$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'PD' AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
		$data['team_pd'] = $this->db_plc0->query($sql)->result_array();
		$data['browse_url'] = base_url().'processor/plc/browse/upd/prio/export?action=index';
		return $this->load->view('upd_prioritas_export_rincian',$data,TRUE);
	}

	function updateBox_upd_prioritas_export_rincian_upd ($field, $id, $value, $rowData) {
		$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'PD' AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
		$data['team_pd'] = $this->db_plc0->query($sql)->result_array();
		$data['idossier_prioritas_id'] = $rowData['idossier_prioritas_id'];
		$data['browse_url'] = base_url().'processor/plc/browse/upd/prio/export?action=index';
		return $this->load->view('upd_prioritas_export_rincian_edit',$data,TRUE);
	}


function insertBox_upd_prioritas_export_iApprove_prio($field, $id) {
	$return = '-';
	return $return;
}

function updateBox_upd_prioritas_export_iApprove_prio($field, $id, $value, $rowData) {
		if ($rowData['iApprove_prio']<> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cApprove']))->row_array();

			if ($rowData['iApprove_prio'] == 2) {
				$palue='Approved by '.$rows['vName'].' pada '.$rowData['dApprove'].', Remark :'.$rowData['vRemark'] ;	
			}else{
				$palue='Rejected by '.$rows['vName'].' pada '.$rowData['dApprove'].', Remark :'.$rowData['vRemark'];	
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






/*function pendukung start*/  
function before_update_processor($row, $postData) {
	
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	
	// ubah status submit
	
	if($postData['isdraft']==true){
		$postData['iSubmit_prio']=0;
	} 
	else{$postData['iSubmit_prio']=1;} 
	
	return $postData;

}
function before_insert_processor($row, $postData) {

	//end 
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreated'] =$this->user->gNIP;

	// ubah status submit
	
		if($postData['isdraft']==true){
			$postData['iSubmit_prio']=0;
		} 
		else{$postData['iSubmit_prio']=1;} 
	
	return $postData;

}


		
function after_insert_processor($row, $insertId, $postData) {
		
		//print_r($_POST);
		//exit;
		$det = array();
		$logged_nip =$this->user->gNIP;
		$qupd="select a.iSemester,a.iTahun,a.iSubmit_prio,b.cNip,b.vName,a.cCreated,a.iTeam_andev							
				from dossier.dossier_prioritas a 
				join hrd.employee b on b.cNip = a.cCreated
				where a.lDeleted = 0
				and a.idossier_prioritas_id = '".$insertId."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_prio'] ;
		$urutan = 1;
		foreach($postData['idossier_upd_id'] as $k=>$v) {
				if($v != '') {
					$det['idossier_prioritas_id'] = $insertId;
					$det['idossier_upd_id'] = $v;
					$det['iUrutan'] = $urutan;
					
					$urutan++;
					try {
						$this->db_plc0->insert('dossier.dossier_prioritas_detail', $det);
					}catch(Exception $e) {
						die('salah!');
					}
					$iproses=1;
					if ($submit == 1) {
						$iproses=2;
					}
					$this->dossier_log->insertlog($det['idossier_upd_id'],$this->input->get('modul_id'),$iproses);
				}			
		}


				// kirim email notifikasi ke Direksi 
		
		if ($submit == 1) {
				
				if ($rupd['ad'] == 17) {
					$iTeamandev = 'Andev Export 1';
					$vkode="PRIO_SUBMIT_AD1";
				}else{
					$iTeamandev = 'Andev Export 2';
					$vkode="PRIO_SUBMIT_AD1";
				}

				$dt=$this->auth_plcexport->prepare_mail($vkode);
				$to = $dt['tto'];
				$cc = $dt['tcc'];                      

				$subject="Waiting Approval : Setting Prioritas ".$rupd['iTahun']." - Semester ".$rupd['iSemester'];
				$content="Diberitahukan bahwa telah ada input Prioritas UPD yang membutuhkan approval dari Direksi pada aplikasi PLC-Export dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>Tahun</b></td><td style='width: 20px;'> : </td><td>".$rupd['iTahun']."</td>
							</tr>
							<tr>
								<td><b>Semester</b></td><td> : </td><td>Semester ".$rupd['iSemester']."</td>
							</tr>
							<tr>
								<td><b>Diinput oleh</b></td><td> : </td><td>".$rupd['cNip'].' - '.$rupd['vName']."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}
		

}							


function after_update_processor($row, $insertId, $postData, $old_data) {
	$det = array();		
		$urutan = 1;
/*
		$sql="select * from dossier.dossier_prioritas_detail a where a.idossier_prioritas_id=$insertId";
		$list_upb=$this->db_plc0->query($sql)->result_array();
		//ubah plc2_upb.iprioritas=0 utk semua upb dgn iprioritas tsb
		foreach($list_upb as $x=>$v){
			$this->db_plc0->where('idossier_prioritas_detail_id', $v['idossier_prioritas_detail_id']);
			$this->db_plc0->update('dossier.dossier_prioritas_detail', array('iprioritas'=>0));
		}
*/
		$logged_nip =$this->user->gNIP;
		$qupd="select a.iSemester,a.iTahun,a.iSubmit_prio,b.cNip,b.vName,a.cCreated,a.iTeam_andev as ad
				from dossier.dossier_prioritas a 
				join hrd.employee b on b.cNip = a.cCreated
				where a.lDeleted = 0
				and a.idossier_prioritas_id = '".$insertId."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_prio'] ;

		$this->db_plc0->where('idossier_prioritas_id', $insertId);
		if($this->db_plc0->update('dossier.dossier_prioritas_detail', array('lDeleted'=>1))) {
			foreach($postData['idossier_upd_id'] as $k=>$v) {
				
					if($v != '') {
						$det['idossier_prioritas_id'] = $insertId;
						$det['idossier_upd_id'] = $v;
						$det['iUrutan'] = $urutan;
						$urutan++;
						
						try {
							$this->db_plc0->insert('dossier.dossier_prioritas_detail', $det);
						}catch(Exception $e) {
							die('salah!');
						} 
						$iproses=3;
						if ($submit == 1) {
							$iproses=4;
						}
						$this->dossier_log->insertlog($det['idossier_upd_id'],$this->input->get('modul_id'),$iproses);
					}
			}//exit;
		}

						// kirim email notifikasi ke Direksi 
		

		if ($submit == 1) {
			if ($rupd['ad'] == 17) {
					$iTeamandev = 'Andev Export 1';
					$vkode="PRIO_SUBMIT_AD1";
				}else{
					$iTeamandev = 'Andev Export 2';
					$vkode="PRIO_SUBMIT_AD1";
				}

				$dt=$this->auth_plcexport->prepare_mail($vkode);
				$to = $dt['tto'];
				$cc = $dt['tcc'];                        

				$subject="Waiting Approval : Setting Prioritas ".$rupd['iTahun']." - Semester ".$rupd['iSemester'];
				$content="Diberitahukan bahwa telah ada input Prioritas UPD yang membutuhkan approval dari Direksi pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>Tahun</b></td><td style='width: 20px;'> : </td><td>".$rupd['iTahun']."</td>
							</tr>
							<tr>
								<td><b>Semester</b></td><td> : </td><td>Semester ".$rupd['iSemester']."</td>
							</tr>
							<tr>
								<td><b>Diinput oleh</b></td><td> : </td><td>".$rupd['cNip'].' - '.$rupd['vName']."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}

}


	
/*function pendukung end*/    	

	
	
function manipulate_insert_button($buttons) {
	unset($buttons['save']);

	$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'upd_prioritas_export\', \''.base_url().'processor/plc/upd/prioritas/export?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_upd_prioritas_export">Save as Draft</button>';
	$save = '<button onclick="javascript:save_btn_multiupload(\'upd_prioritas_export\', \''.base_url().'processor/plc/upd/prioritas/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_upd_prioritas_export">Save &amp; Submit</button>';
	$js = $this->load->view('upd_prioritas_export_js');
	$buttons['save'] = $save.$save_draft.$js;

	return $buttons;
}

function manipulate_update_button($buttons, $rowData) {
	$mydept = $this->auth_plcexport->my_depts(TRUE);
	$cNip= $this->user->gNIP;
	$js = $this->load->view('upd_prioritas_export_js');
	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upd/prioritas/export?action=approve&idossier_prioritas_id='.$rowData['idossier_prioritas_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_upd_prioritas_export">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upd/prioritas/export?action=reject&idossier_prioritas_id='.$rowData['idossier_prioritas_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_upd_prioritas_export">Reject</button>';

	$update = '<button onclick="javascript:update_btn_back(\'upd_prioritas_export\', \''.base_url().'processor/plc/plc/upd/prioritas/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upd">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'upd_prioritas_export\', \''.base_url().'processor/plc/upd/prioritas/export?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_daftar_upd">Update as Draft</button>';



	if ($this->input->get('action') == 'view') {unset($buttons['update']);}

	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if ($rowData['iSubmit_prio']== 0) {
			// jika masih draft , show button update draft & update submit 
			$buttons['update'] = $update.$updatedraft.$js;
		}else{
			// sudah disubmit , show button approval 
			if (isset($mydept)) {
				// jika punya team di plc2_upb_team
				if((in_array('DR', $mydept))){
					// sudah disubmit , show button approval 
					$buttons['update'] = $approve.$reject.$js;

				}
			}

		}
	}

	return $buttons;

}

	function approve_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
						return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/upd/prioritas/export";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_upd_prioritas_export").html(data);
										 $("#button_approve_upd_prioritas_export").hide();
										 $("#button_reject_upd_prioritas_export").hide();
									});
									
								}
									reload_grid("grid_upd_prioritas_export");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_upd_prioritas_export_approve" action="'.base_url().'processor/plc/upd/prioritas/export?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_prioritas_id" value="'.$this->input->get('idossier_prioritas_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_upd_prioritas_export_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_prioritas_id = $post['idossier_prioritas_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove_prio'=>'2','cApprove'=>$cNip , 'dApprove'=>date('Y-m-d H:i:s'), 'vRemark'=>$vRemark);
		$this -> db -> where('idossier_prioritas_id', $idossier_prioritas_id);
		$updet = $this -> db -> update('dossier.dossier_prioritas', $data);

		$logged_nip =$this->user->gNIP;
		$qupd="select a.iSemester,a.iTahun,a.iSubmit_prio,b.cNip,b.vName,a.cCreated,a.iTeam_andev as ad
				from dossier.dossier_prioritas a 
				join hrd.employee b on b.cNip = a.cCreated
				where a.lDeleted = 0
				and a.idossier_prioritas_id = '".$idossier_prioritas_id."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_prio'] ;

		if ($updet) {
			if ($rupd['ad'] == 17) {
				$iTeamandev = 'Andev Export 1';
				$vkode="PRIO_APP_AD1";
			}else{
				$iTeamandev = 'Andev Export 2';
				$vkode="PRIO_APP_AD2";
			}

			$dt=$this->auth_plcexport->prepare_mail($vkode);
			$to = $dt['tto'];
			$cc = $dt['tcc'];                          

			$subject="Approval : Setting Prioritas ".$rupd['iTahun']." - Semester ".$rupd['iSemester'];
			$content="Diberitahukan bahwa telah ada approval Prioritas UPD dari Direksi pada aplikasi PLC-Export dengan rincian sebagai berikut :<br><br>
				<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
					<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
						<tr>
							<td style='width: 110px;'><b>Tahun</b></td><td style='width: 20px;'> : </td><td>".$rupd['iTahun']."</td>
						</tr>
						<tr>
							<td><b>Semester</b></td><td> : </td><td>Semester ".$rupd['iSemester']."</td>
						</tr>
						<tr>
							<td><b>Diinput oleh</b></td><td> : </td><td>".$rupd['cNip'].' - '.$rupd['vName']."</td>
						</tr>
					</table>
				</div>
				<br/> 
				Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
				Post Master";
			$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}

		$sq="select * from dossier.dossier_prioritas_detail det where det.idossier_prioritas_id=".$post['idossier_prioritas_id'];
		$dr=$this->dbset->query($sq)->result_array();
		foreach ($dr as $kr => $vr) {
			$this->dossier_log->insertlog($vr['idossier_upd_id'],$this->input->post('modul_id'),6);
		}
		

		$data['status']  = true;
		$data['last_id'] = $post['idossier_prioritas_id'];
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_upd_prioritas_export_remark").val();
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
								var url = "'.base_url().'processor/plc/upd/prioritas/export";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_upd_prioritas_export").html(data);
										 $("#button_approve_upd_prioritas_export").hide();
										 $("#button_reject_upd_prioritas_export").hide();

									});
									
								}
									reload_grid("grid_upd_prioritas_export");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_upd_prioritas_export_reject" action="'.base_url().'processor/plc/upd/prioritas/export?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_prioritas_id" value="'.$this->input->get('idossier_prioritas_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="reject_upd_prioritas_export_remark"class="required" required="required"></textarea>
		<button type="button" onclick="submit_ajax(\'form_upd_prioritas_export_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	
	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_prioritas_id = $post['idossier_prioritas_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove_prio'=>'1','cApprove'=>$cNip , 'dApprove'=>date('Y-m-d H:i:s'), 'vRemark'=>$vRemark);
		$this -> db -> where('idossier_prioritas_id', $idossier_prioritas_id);
		$updet = $this -> db -> update('dossier.dossier_prioritas', $data);

				$logged_nip =$this->user->gNIP;
		$qupd="select a.iSemester,a.iTahun,a.iSubmit_prio,b.cNip,b.vName,a.cCreated,a.iTeam_andev as ad
				from dossier.dossier_prioritas a 
				join hrd.employee b on b.cNip = a.cCreated
				where a.lDeleted = 0
				and a.idossier_prioritas_id = '".$idossier_prioritas_id."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_prio'] ;

		if ($updet) {
			if ($rupd['ad'] == 17) {
				$iTeamandev = 'Andev Export 1';
				$vkode="PRIO_APP_AD1";
			}else{
				$iTeamandev = 'Andev Export 2';
				$vkode="PRIO_APP_AD2";
			}

			$dt=$this->auth_plcexport->prepare_mail($vkode);
			$to = $dt['tto'];
			$cc = $dt['tcc'];                       

				$subject="Approval : Setting Prioritas ".$rupd['iTahun']." - Semester ".$rupd['iSemester'];
				$content="Diberitahukan bahwa telah ada Reject Prioritas UPD dari Direksi pada aplikasi PLC-Export dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>Tahun</b></td><td style='width: 20px;'> : </td><td>".$rupd['iTahun']."</td>
							</tr>
							<tr>
								<td><b>Semester</b></td><td> : </td><td>Semester ".$rupd['iSemester']."</td>
							</tr>
							<tr>
								<td><b>Diinput oleh</b></td><td> : </td><td>".$rupd['cNip'].' - '.$rupd['vName']."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}

		$sq="select * from dossier.dossier_prioritas_detail det where det.idossier_prioritas_id=".$post['idossier_prioritas_id'];
		$dr=$this->dbset->query($sq)->result_array();
		foreach ($dr as $kr => $vr) {
			$this->dossier_log->insertlog($vr['idossier_upd_id'],$this->input->post('modul_id'),5);
		}

		$data['status']  = true;
		$data['last_id'] = $post['idossier_prioritas_id'];
		return json_encode($data);
	}


	

	
	

	public function output(){
		$this->index($this->input->get('action'));
	}

}

