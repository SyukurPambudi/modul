<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verifikasi_dokumen extends MX_Controller {
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
		$grid->setTitle('Verifikasi Dokumen');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_review');		
		$grid->setUrl('verifikasi_dokumen');
		$grid->addList('dossier_upd.vUpd_no','dossier_upd.vNama_usulan','dossier_upd.iTeam_andev','dossier_upd.iSediaan','dossier_prioritas.iSemester','dossier_prioritas.iTahun','iSubmit_verify','iApprove_verify');
		$grid->setSortBy('dossier_upd.vUpd_no');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('vUpd_no','vNama_usulan','iTeam_andev','rincian_dok','iApprove_verify');

		//setting widht grid
		$grid ->setWidth('dossier_upd.vUpd_no', '100'); 
		$grid->setWidth('dossier_upd.iTeam_andev', '100'); 
		$grid->setWidth('dossier_upd.iSediaan', '100'); 
		$grid->setWidth('dossier_prioritas.iSemester', '150'); 
		$grid->setWidth('dossier_prioritas.iTahun', '100'); 
		$grid->setWidth('iApprove_verify', '100'); 
		$grid->setWidth('dossier_upd.vNama_usulan', '250'); 
		$grid->setWidth('lDeleted', '100'); 
		
		
		//modif label
		$grid->setLabel('vUpd_no','No UPD'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 

		$grid->setLabel('dossier_upd.vUpd_no','No UPD'); 
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Usulan'); 
		$grid->setLabel('dossier_upd.iTeam_andev','Team Andev'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 


		$grid->setLabel('iSubmit_verify','Status Submit'); 
		$grid->setLabel('iApprove_verify','Status Verifikasi'); 
		$grid->setLabel('iTeam_andev','Team Andev'); 
		$grid->setLabel('iNegara','Negara'); 
		//$grid->setLabel('iApprove_verify','Approve at'); 
		$grid->setLabel('cApprove_verify','Approve by'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 
		$grid->setLabel('dossier_prioritas.iSemester','Semester Prioritas'); 
		$grid->setLabel('dossier_prioritas.iTahun','Tahun Prioritas');

		$grid->setFormUpload(TRUE);

		$grid->setSearch('dossier_upd.vUpd_no');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('dossier_upd.iSediaan','combobox','',array(''=>'Pilih','1'=>'Solid','2'=>'Non Solid'));
		$grid->changeFieldType('iApprove_verify','combobox','',array('0'=>'Waiting Approval','1'=>'Rejected','2'=>'Approved'));
		$grid->changeFieldType('iSubmit_verify','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submitted '));
		
		

	//Field mandatori
		$grid->setRequired('iSediaan');	
		$grid->setRequired('iTeam_andev');	
		$grid->setRequired('lDeleted');	

		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id', 'inner');		
		$grid->setJoinTable('dossier.dossier_prioritas_detail', 'dossier_prioritas_detail.idossier_upd_id = dossier_upd.idossier_upd_id', 'inner');
		$grid->setJoinTable('dossier.dossier_prioritas', 'dossier_prioritas.idossier_prioritas_id = dossier_prioritas_detail.idossier_prioritas_id', 'inner');

		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setQuery('dossier_review.iApprove_review', 2);
		$x=$this->auth->dept();
		$team=$x['team'];
		if(in_array('AD', $team)){
			$type='AD';
			$grid->setQuery('dossier_upd.iTeam_andev IN ('.$this->auth->my_teams().')', null);
		}
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
			  	//			$r['status'] = FALSE;
                 //           $r['message'] = "Nama Negara Sudah ada";
                 //           echo json_encode($r);
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

 	if ($row->iApprove_verify<>0) {
 		// status sudah diapprove or reject , button edit hide 
 		 unset($actions['edit']);
 		 unset($actions['delete']);
 	}
	 return $actions;

 } 


function listBox_verifikasi_dokumen_dossier_prioritas_iSemester ($value) {
	return 'Semester '.$value;
}

function listBox_verifikasi_dokumen_dossier_upd_iTeam_andev ($value) {
	if ($value == 74) {
		$andev = 'Andev 1';
	}else{
		$andev = 'Andev 2';
	}

	return $andev;
}

function listBox_verifikasi_dokumen_dossier_upd_iSediaan ($value) {
	if ($value == 1) {
		$sediaan = 'Solid';
	}else{
		$sediaan = 'Injection';
	}

	return $sediaan;
}

/*manipulasi view object form start*/


function updateBox_verifikasi_dokumen_vUpd_no($field, $id, $value, $rowData) {
	$sql = 'select * from dossier.dossier_upd a where a.idossier_upd_id="'.$rowData['idossier_upd_id'].'" ';
	$data_upd = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];

	}else{

		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];
	}
	
	return $return;
}

function updateBox_verifikasi_dokumen_vNama_usulan($field, $id, $value, $rowData) {
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

function updateBox_verifikasi_dokumen_iTeam_andev($field, $id, $value, $rowData) {
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

function updateBox_verifikasi_dokumen_cApprove_verify($field, $id, $value, $rowData) {
	
	

		if ($rowData['iApprove_verify'] <> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cApprove_verify']))->row_array();

			if ($rowData['iApprove_verify'] == 2) {
				$palue='Approved by '.$rows['vName'].' pada '.$rowData['dApprove_verify'].', Remark :'.$rowData['vRemark_verify'] ;	
			}else{
				$palue='Rejected by '.$rows['vName'].' pada '.$rowData['dApprove_verify'].', Remark :'.$rowData['vRemark_verify'];	
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

function updateBox_verifikasi_dokumen_iApprove_verify($field, $id, $value, $rowData) {
		if ($rowData['iApprove_verify'] <> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cApprove_verify']))->row_array();

			if ($rowData['iApprove_verify'] == 2) {
				$palue='Approved by '.$rows['vName'].' pada '.$rowData['dApprove_verify'].', Remark :'.$rowData['vRemark_verify'] ;	
			}else{
				$palue='Rejected by '.$rows['vName'].' pada '.$rowData['dApprove_verify'].', Remark :'.$rowData['vRemark_verify'];	
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

function updateBox_verifikasi_dokumen_rincian_dok($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
		
		//$return1= print_r($rows);

		$data['rows'] = $rows;
		$data['iSediaan'] = $rows['iSediaan'];
		$data['idossier_upd_id'] =  $rows['idossier_upd_id'];



		$sql_doc='	select * 
					from dossier.dossier_dokumen a 
					join dossier.dossier_dok_list b on b.idossier_dokumen_id=a.idossier_dokumen_id 
					join dossier.dossier_kat_dok c on c.idossier_kat_dok_id=a.idossier_kat_dok_id 
					where a.lDeleted=0
					and b.lDeleted=0
					and b.idossier_review_id="'.$rowData['idossier_review_id'].'"';
		$data['docs'] = $this->db_plc0->query($sql_doc)->result_array();
		//$return= print_r($rows);
		

		if ($rows['iSediaan'] == 1  ) {
			//solid
			$return=  $this->load->view('verifikasi_dokumen_solid',$data,TRUE);
		}else{
			// non solid
			$return= $this->load->view('verifikasi_dokumen_nonsolid',$data,TRUE);
		}
		
		return $return;
		
}


function after_update_processor($row, $insertId, $postData, $old_data) {
		
		$urutan = 1;
			foreach($postData['idossier_dok_list_id'] as $k=>$v) {
				
					if($v != '') {

						if (empty($postData['istatus_verifikasi_'.$v])) {
								$istatus = 0;
						}else{
							foreach($postData['istatus_verifikasi_'.$v] as $k1=>$v1) {
								$istatus = $v1;
							}		
						}
						

						$data=array('istatus_verifikasi'=>$istatus);
						$this -> db -> where('idossier_dok_list_id',$v);
						$updet = $this -> db -> update('dossier.dossier_dok_list', $data);

					}
			}
		
		$logged_nip =$this->user->gNIP;
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.vupb_nomor,c.vupb_nama,d.vName,b.dTanggal_upd,a.iSubmit_verify
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.plc2_upb c on c.iupb_id = b.idossier_upd_id
				join hrd.employee d on d.cNip=b.cNip_pengusul
				where a.idossier_review_id = '".$insertId."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_verify'] ;
		if ($rupd['ad'] == 74) {
			$iTeamandev = 'Andev 1';
		}else{
			$iTeamandev = 'Andev 2';
		}

		if ($submit == 1) {
			$ad = $rupd['ad'];
			$team = $ad;
			//$team = '81' ;

	        $toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_team( $team );
	        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
	        //$arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
	        $arrEmail = $this->lib_utilitas->get_email_by_nip( $logged_nip );                    
	                    
			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($toEmail);
				$to = $toEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
				}
			}	

			//$to = $toEmail2.';'.$toEmail;
			//$cc = $arrEmail;                        

			$to = $arrEmail;
			$cc = $toEmail2.';'.$toEmail;                        

				$subject="Verifikasi Dokumen: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada inputan Verifikasi Dokumen UPD  pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}

}



/*function pendukung start*/  
function before_update_processor($row, $postData) {

	// ubah status submit
		if($postData['isdraft']==true){
			$postData['iSubmit_verify']=0;
		} 
		else{$postData['iSubmit_verify']=1;} 
	
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	

	return $postData;

}

function manipulate_update_button($buttons, $rowData) {
	$cNip= $this->user->gNIP;
	$mydept = $this->auth->my_depts(TRUE);
	$js = $this->load->view('verifikasi_dokumen_js');

	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/verifikasi/dokumen?action=approve&idossier_review_id='.$rowData['idossier_review_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_verifikasi_dokumen">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/verifikasi/dokumen?action=reject&idossier_review_id='.$rowData['idossier_review_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_verifikasi_dokumen">Reject</button>';

	$update = '<button onclick="javascript:update_btn_back(\'verifikasi_dokumen\', \''.base_url().'processor/plc/verifikasi/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_verifikasi_dokumen">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'verifikasi_dokumen\', \''.base_url().'processor/plc/verifikasi/dokumen?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_draft_verifikasi_dokumen">Update as Draft</button>';


	$sql_cek_verify='select * 
					from dossier.dossier_review a
					join dossier.dossier_dok_list b on b.idossier_review_id=a.idossier_review_id
					where a.idossier_review_id="'.$rowData['idossier_review_id'].'" 
					and b.istatus_verifikasi = 0';
	$data_verify = $this->dbset->query($sql_cek_verify)->result_array();					


	if ($this->input->get('action') == 'view') {unset($buttons['update']);}

	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if ($rowData['iSubmit_verify']== 0) {
			// jika masih draft , show button update draft & update submit 
				// cek sudah verifikasi semua belum , kalau belum ceklis maka tombol draft saja 
				if (empty($data_verify)) {
					// sudah ceklist verify semua
					$buttons['update'] = $update.$updatedraft.$js;		
				}else{
					$buttons['update'] = $updatedraft.$js;		
					
				}
			
		}else{
			// sudah disubmit , show button approval 
			// jika manager team andev  
			if (isset($mydept)) {
				if((in_array('AD', $mydept))) {
					if($this->auth->is_managerdept('AD')){ 
						$buttons['update'] = $approve.$reject.$js;
					}
				}
			}
		}


		//$buttons['update'] = $update.$updatedraft.$approve.$reject.$js;
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
								var url = "'.base_url().'processor/plc/verifikasi/dokumen";								
								if(o.status == true) {
									
									
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_verifikasi_dokumen").html(data);
										$("#button_approve_verifikasi_dokumen").hide();
										$("#button_reject_verifikasi_dokumen").hide();
									});
									
								}
									reload_grid("grid_verifikasi_dokumen");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_verifikasi_dokumen_approve" action="'.base_url().'processor/plc/verifikasi/dokumen?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_review_id" value="'.$this->input->get('idossier_review_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark_verify"></textarea>
		<button type="button" onclick="submit_ajax(\'form_verifikasi_dokumen_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_review_id = $post['idossier_review_id'];
		$vRemark_verify = $post['vRemark_verify'];

		$data=array('iApprove_verify'=>'2','cApprove_verify'=>$cNip , 'dApprove_verify'=>date('Y-m-d H:i:s'), 'vRemark_verify'=>$vRemark_verify);
		$this -> db -> where('idossier_review_id', $idossier_review_id);
		$updet = $this -> db -> update('dossier.dossier_review', $data);

		$logged_nip =$this->user->gNIP;
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.vupb_nomor,c.vupb_nama,d.vName,b.dTanggal_upd,a.iSubmit_verify
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.plc2_upb c on c.iupb_id = b.idossier_upd_id
				join hrd.employee d on d.cNip=b.cNip_pengusul
				where a.idossier_review_id = '".$idossier_review_id."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

	
		$submit = $rupd['iSubmit_verify'] ;
		if ($rupd['ad'] == 74) {
			$iTeamandev = 'Andev 1';
		}else{
			$iTeamandev = 'Andev 2';
		}

		if ($updet == 1) {
				

			$ad = $rupd['ad'];

			//$team = $dr ;
			$team = $ad;
			//$team = '81' ;

	        $toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_team( $team );
	        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
	        //$arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
	        $arrEmail = $this->lib_utilitas->get_email_by_nip( $logged_nip );                    
	                    
			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($toEmail);
				$to = $toEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
				}
			}	

			//$to = $toEmail2.';'.$toEmail;
			//$cc = $arrEmail;                        

			$to = $arrEmail;
			$cc = $toEmail2.';'.$toEmail;                        

				$subject="Approval Verifikasi Dokumen: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada approval Verifikasi Dokumen UPD  pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}

		$data['status']  = true;
		$data['last_id'] = $post['idossier_review_id'];
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_verifikasi_dokumen_vRemark_verify").val();
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
								var url = "'.base_url().'processor/plc/verifikasi/dokumen";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_verifikasi_dokumen").html(data);
										 $("#button_approve_verifikasi_dokumen").hide();
										$("#button_reject_verifikasi_dokumen").hide();
									});
									
								}
									reload_grid("grid_verifikasi_dokumen");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_verifikasi_dokumen_reject" action="'.base_url().'processor/plc/verifikasi/dokumen?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_review_id" value="'.$this->input->get('idossier_review_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark_verify" id="reject_verifikasi_dokumen_vRemark_verify"class="required" required="required"></textarea>
		<button type="button" onclick="submit_ajax(\'form_verifikasi_dokumen_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	
	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_review_id = $post['idossier_review_id'];
		$vRemark_verify = $post['vRemark_verify'];

		$data=array('iApprove_verify'=>'1','cApprove_verify'=>$cNip , 'dApprove_verify'=>date('Y-m-d H:i:s'), 'vRemark_verify'=>$vRemark_verify);
		$this -> db -> where('idossier_review_id', $idossier_review_id);
		$updet = $this -> db -> update('dossier.dossier_review', $data);

		$logged_nip =$this->user->gNIP;
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.vupb_nomor,c.vupb_nama,d.vName,b.dTanggal_upd,a.iSubmit_verify
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.plc2_upb c on c.iupb_id = b.idossier_upd_id
				join hrd.employee d on d.cNip=b.cNip_pengusul
				where a.idossier_review_id = '".$idossier_review_id."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

	
		$submit = $rupd['iSubmit_verify'] ;
		if ($rupd['ad'] == 74) {
			$iTeamandev = 'Andev 1';
		}else{
			$iTeamandev = 'Andev 2';
		}

		if ($updet == 1) {
				

			$ad = $rupd['ad'];

			//$team = $dr ;
			$team = $ad;
			//$team = '81' ;

	        $toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_team( $team );
	        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
	        //$arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
	        $arrEmail = $this->lib_utilitas->get_email_by_nip( $logged_nip );                    
	                    
			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($toEmail);
				$to = $toEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
				}
			}	

			//$to = $toEmail2.';'.$toEmail;
			//$cc = $arrEmail;                        

			$to = $arrEmail;
			$cc = $toEmail2.';'.$toEmail;                        

				$subject="Approval Verifikasi Dokumen: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada approval Verifikasi Dokumen UPD  pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}

		$data['status']  = true;
		$data['last_id'] = $post['idossier_review_id'];
		return json_encode($data);
	}



/*function pendukung end*/    	

	

	public function output(){
		$this->index($this->input->get('action'));
	}

}

