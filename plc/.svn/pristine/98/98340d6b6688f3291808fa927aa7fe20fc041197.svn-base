<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class import_setting_prioritas extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->load->library('lib_utilitas');
		$this->dbset = $this->load->database('plc', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Setting Prioritas UPI');
		//dc.m_vendor  database.tabel
		$grid->setTable('plc2.setting_prioritas_upi');		
		$grid->setUrl('import_setting_prioritas');
		$grid->addList('iSemester','iTahun','iSubmit_prio','iApprove_bdirm','iApprove_dir');
		$grid->setSortBy('iSemester');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('iApprove_bdirm','iApprove_dir','iSemester','iTahun','rincian_upi');

		//setting widht grid
		$grid ->setWidth('iSemester', '100'); 
		$grid->setWidth('iTahun', '100'); 
		
		
		//modif label
		$grid->setLabel('iSemester','Semester'); 
		$grid->setLabel('iTahun','Tahun'); 
		$grid->setLabel('iSubmit_prio','Status UPD Prioritas'); 
		$grid->setLabel('cApprove','Approve by');
		$grid->setLabel('rincian_upi','Rincian UPI');

		$grid->setLabel('iSubmit_prio','Status'); 
		$grid ->setWidth('iSubmit_prio', '100'); 
		$grid->setAlign('iSubmit_prio', 'center'); 

		$grid->setLabel('iApprove_bdirm','Approval BDIRM'); 
		$grid ->setWidth('iApprove_bdirm', '100'); 
		$grid->setAlign('iApprove_bdirm', 'center'); 

		$grid->setLabel('iApprove_dir','Approval Direksi'); 
		$grid ->setWidth('iApprove_dir', '100'); 
		$grid->setAlign('iApprove_dir', 'center'); 

		

		$grid->setFormUpload(TRUE);

		$grid->setSearch('iTahun','iSemester');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		//$grid->changeFieldType('istatus','combobox','',array(''=>'Pilih','C'=>'Kontrak','A'=>'Tetap'));
		$grid->changeFieldType('iSubmit_prio','combobox','',array('0'=>'Draft','1'=>'Submitted'));
		

	//Field mandatori
		$grid->setRequired('iSemester');	
		$grid->setRequired('iTahun');	



		
		$grid->setQuery('lDeleted', 0);
		//$grid->setMultiSelect(true);
		$mydept = $this->auth->my_depts(TRUE);
		if (isset($mydept)) 
		{
			// cek punya dep
			if((in_array('DR', $mydept))) {
				$grid->setQuery('setting_prioritas_upi.iApprove_bdirm = "2" ', null);	
			}
		}
			
		
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
				$semester = $_POST['iSemester'];
				$tahun = $_POST['iTahun'];

                $cek_data = 'select * from setting_prioritas_upi a where a.iSemester="'.$semester.'" and a.iTahun="'.$tahun.'"  and  a.iApprove_dir in (0,2) and  a.lDeleted=0 ';
                $data_cek = $this->dbset->query($cek_data)->row_array();
                if (empty($data_cek) ) {
                     echo $grid->saved_form();
                }else{
                    $r['status'] = FALSE;
                    $r['message'] = "Prioritas Untuk Tahun & Semester Sudah ada";
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
				$semester = $_POST['iSemester'];
				$tahun = $_POST['iTahun'];
				$id=$_POST['import_setting_prioritas_isetting_prioritas_upi_id'];

                $cek_data = 'select * from setting_prioritas_upi a where a.iSemester="'.$semester.'" and a.iTahun="'.$tahun.'"  and  a.iApprove_dir in (0,2) and  a.lDeleted=0 ';
                $data_cek = $this->dbset->query($cek_data)->row_array();

                $sql2 = 'select * from setting_prioritas_upi a where a.isetting_prioritas_upi_id = "'.$id.'"';
				$old = $this->dbset->query($sql2)->row_array();

				
				if (empty($data_cek) or ( $old['iTahun'] == $tahun and  $old['iSemester'] == $semester ) ) {
                     echo $grid->updated_form();
                }else{
                    $r['status'] = FALSE;
                    $r['message'] = "Prioritas Untuk Tahun & Semester Sudah ada";
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

 
 	function listBox_import_setting_prioritas_iApprove_bdirm($value) {
		/* $appd = $this->db_plc0->get_where('plc2.plc2_status', array('idplc2_status' => $value))->row_array();
		if($value==0){$appd['vCaption']="Waiting For Approval";} */
		if($value==0){$vstatus='Waiting for approval';}
		elseif($value==1){$vstatus='Rejected';}
		elseif($value==2){$vstatus='Approved';}
		return $vstatus;
	}
	 function listBox_import_setting_prioritas_iApprove_dir($value) {
		/* $team = $this->db_plc0->get_where('plc2.plc2_status', array('idplc2_status' => $value))->row_array();
		if($value==0){$team['vCaption']="Waiting For Approval";} */
	 	if($value==0){$vstatus='Waiting for approval';}
	 	elseif($value==1){$vstatus='Rejected';}
	 	elseif($value==2){$vstatus='Approved';}
		return $vstatus;
	} 
	function searchBox_import_setting_prioritas_iSemester ($field, $id) {
		$this->load->config('plc_config');
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=1; $i<=2; $i++) {
			$echo .= '<option value="'.$i.'">Semester '.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}	

	function listBox_import_setting_prioritas_iSemester ($value) {
		return 'Semester '.$value;
	}

	function listBox_Action($row, $actions) {
	 	//$rows = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$row->iupb_id,'ldeleted'=>0))->row_array();
	 	//$idtim_bd =$rows['iteambusdev_id'];
	 	$mydept = $this->auth->my_depts(TRUE);
	 	$x = $this->auth->my_teams();
		$array = explode(',', $x);
		// cek user bagian dari tim bd terkait
		

	 	if ($row->iApprove_dir<>0) {
	 		// status sudah diapprove or reject , button edit hide 
	 		 unset($actions['edit']);
	 		 unset($actions['delete']);
	 	}else{
	 		$mydept = $this->auth->my_depts(TRUE);
	 		if (isset($mydept)) 
			{
				// cek punya dep
				if((in_array('DR', $mydept))  and $row->iApprove_bdirm <> 2 ) {
					unset($actions['edit']);
	 		 		unset($actions['delete']);
				}else if( (in_array('BDI', $mydept))  and $row->iApprove_bdirm ==1 ){
					unset($actions['edit']);
	 		 		unset($actions['delete']);
				}
			}

	 		/*
	 		if((in_array($idtim_bd, $array))) {
				$actions['delete'];
				$actions['edit'];
			}else{
				 unset($actions['edit']);
		 		 unset($actions['delete']);
			}
			*/

	 	}

	 	
		 return $actions;

	}  


/*manipulasi view object form start*/
	function insertBox_import_setting_prioritas_iTahun ($field, $id) {
		$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-3;
		$sampai = $thn_sekarang+6;
		$echo = '<select class="required" id="'.$id.'" name="'.$field.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=$mulai; $i<=$sampai; $i++) {
			$echo .= '<option value="'.$i.'">'.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}

	function updateBox_import_setting_prioritas_iTahun ($field, $id, $value, $rowData) {
		$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-3;
		$sampai = $thn_sekarang+6;
		$echo = '<select class="required" id="'.$id.'" name="'.$field.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=$mulai; $i<=$sampai; $i++) {
			$selected = $value == $i ? 'selected' : '';
			$echo .= '<option '.$selected.' value="'.$i.'">'.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}

	function insertBox_import_setting_prioritas_iSemester ($field, $id) {
		$echo = '
		<input type="hidden" name="isdraft" id="isdraft">
		<select class="required" id="'.$id.'" name="'.$field.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=1; $i<=2; $i++) {
			$echo .= '<option value="'.$i.'">Semester '.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	function updateBox_import_setting_prioritas_iSemester ($field, $id, $value, $rowData) {
		$echo = '
		<input type="hidden" name="isdraft" id="isdraft">
		<select class="required" id="'.$id.'" name="'.$field.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=1; $i<=2; $i++) {
			$selected = $value == $i ? 'selected' : '';
			$echo .= '<option '.$selected.' value="'.$i.'">Semester '.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}


	function insertBox_import_setting_prioritas_rincian_upi ($field, $id) {
		$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'PD' AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
		$data['team_pd'] = $this->db_plc0->query($sql)->result_array();
		$data['browse_url'] = base_url().'processor/plc/import/browse/upi/prio?action=index';
		return $this->load->view('import/setting_prioritas_rincian',$data,TRUE);
	}

	function updateBox_import_setting_prioritas_rincian_upi ($field, $id, $value, $rowData) {
		$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'PD' AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
		$data['team_pd'] = $this->db_plc0->query($sql)->result_array();
		$data['isetting_prioritas_upi_id'] = $rowData['isetting_prioritas_upi_id'];
		$data['browse_url'] = base_url().'processor/plc/import/browse/upi/prio?action=index';
		return $this->load->view('import/setting_prioritas_rincian_edit',$data,TRUE);
	}

	function insertBox_import_setting_prioritas_iApprove_bdirm($field, $id) {

		return '-';
	}

	function updateBox_import_setting_prioritas_iApprove_bdirm($field, $id, $value, $rowData) {
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = 'select * 
						from plc2.setting_prioritas_upi a
						join hrd.employee b on b.cNip=a.cApprove_bdirm
						where
						a.lDeleted = 0
						and  a.isetting_prioritas_upi_id = "'.$rowData['isetting_prioritas_upi_id'].'"';
			$row = $this->db_plc0->query($sql_dtapp)->row_array();
			if($value==2){
				$st='<p style="color:green;font-size:120%;">Approved';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_bdirm'].'</br> Alasan: '.$row['vRemark_bdirm'].'</p>';
			}
			elseif($value==1){
				$st='<p style="color:red;font-size:120%;">Rejected';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_bdirm'].'</br> Alasan: '.$row['vRemark_bdirm'].'</p>';
			} 

			
			
			
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}

	function insertBox_import_setting_prioritas_iApprove_dir($field, $id) {
		return '-';
	}

	function updateBox_import_setting_prioritas_iApprove_dir($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = 'select * 
						from plc2.setting_prioritas_upi a
						join hrd.employee b on b.cNip=a.cApprove_dir
						where
						a.lDeleted = 0
						and  a.isetting_prioritas_upi_id = "'.$rowData['isetting_prioritas_upi_id'].'"';
			$row = $this->db_plc0->query($sql_dtapp)->row_array();
			if($value==2){
				$st='<p style="color:green;font-size:120%;">Approved';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_dir'].'</br> Alasan: '.$row['vRemark_dir'].'</p>';
			}
			elseif($value==1){
				$st='<p style="color:red;font-size:120%;">Rejected';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_dir'].'</br> Alasan: '.$row['vRemark_dir'].'</p>';
			} 

			
			
			
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
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
		
		$urutan = 1;
		foreach($postData['iupi_id'] as $k=>$v) {
			//foreach($v as $uk => $uv) {
				if($v != '') {
					$det['isetting_prioritas_upi_id'] = $insertId;
					$det['iupi_id'] = $v;
					$det['iUrutan'] = $urutan;
					$det['dCreate'] = date('Y-m-d H:i:s');
					$det['cCreated'] = $this->user->gNIP;
					
					$urutan++;
					try {
						$this->db_plc0->insert('plc2.setting_prioritas_upi_detail', $det);
					}catch(Exception $e) {
						die('salah!');
					}
				}
			//}					
		}

		
		// kirim email notifikasi ke Direksi 
		$logged_nip =$this->user->gNIP;
		$qupd="select a.isetting_prioritas_upi_id,a.iSemester,a.iTahun,a.iSubmit_prio,b.cNip,b.vName,a.cCreated 
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='DR' and te.ldeleted=0) as dr
				from plc2.setting_prioritas_upi a
				join hrd.employee b on b.cNip = a.cCreated
				where a.lDeleted = 0
				and a.isetting_prioritas_upi_id = '".$insertId."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_prio'] ;

		if ($submit == 1) {
			$dr = $rupd['dr'];

			//$team = $dr ;
			$team = $dr;
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

				$subject="Waiting Approval : Setting Prioritas ".$rupd['iTahun']." - Semester ".$rupd['iSemester'];
				$content="Diberitahukan bahwa telah ada input Prioritas UPI yang membutuhkan approval dari Direksi pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
		$this->db_plc0->where('isetting_prioritas_upi_id', $insertId);
		if($this->db_plc0->update('plc2.setting_prioritas_upi_detail', array('lDeleted'=>1))) {
			foreach($postData['iupi_id'] as $k=>$v) {
				
					if($v != '') {
						$det['isetting_prioritas_upi_id'] = $insertId;
						$det['iupi_id'] = $v;
						$det['iUrutan'] = $urutan;
						$det['dupdate'] = date('Y-m-d H:i:s');
						$det['cUpdate'] = $this->user->gNIP;
						$urutan++;
						
						try {
							$this->db_plc0->insert('plc2.setting_prioritas_upi_detail', $det);
						}catch(Exception $e) {
							die('salah!');
						} 
					}
			}
		}

		$logged_nip =$this->user->gNIP;
		$qupd="select a.isetting_prioritas_upi_id,a.iSemester,a.iTahun,a.iSubmit_prio,b.cNip,b.vName,a.cCreated 
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='DR' and te.ldeleted=0) as dr
				from plc2.setting_prioritas_upi a
				join hrd.employee b on b.cNip = a.cCreated
				where a.lDeleted = 0
				and a.isetting_prioritas_upi_id = '".$insertId."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_prio'] ;

		if ($submit == 1) {
			$dr = $rupd['dr'];

			//$team = $dr ;
			$team = $dr;
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

				$subject="Waiting Approval : Setting Prioritas ".$rupd['iTahun']." - Semester ".$rupd['iSemester'];
				$content="Diberitahukan bahwa telah ada input Prioritas UPI yang membutuhkan approval dari Direksi pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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

function manipulate_insert_button($buttons) {
	unset($buttons['save']);

	$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'import_setting_prioritas\', \''.base_url().'processor/plc/import/setting/prioritas?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_import_setting_prioritas">Save as Draft</button>';
	$save = '<button onclick="javascript:save_btn_multiupload(\'import_setting_prioritas\', \''.base_url().'processor/plc/import/setting/prioritas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_import_setting_prioritas">Save &amp; Submit</button>';
	$js = $this->load->view('import/setting_prioritas_upi_js');
	$buttons['save'] = $save_draft.$save.$js;

	return $buttons;
}


function manipulate_update_button($buttons, $rowData) {
	$mydept = $this->auth->my_depts(TRUE);
	$cNip= $this->user->gNIP;
	$js = $this->load->view('import/setting_prioritas_upi_js');

	$approve_bdirm = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/setting/prioritas?action=approve&isetting_prioritas_upi_id='.$rowData['isetting_prioritas_upi_id'].'&cNip='.$cNip.'&lvl=1&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_import_setting_prioritas">Approve</button>';
	$reject_bdirm = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/setting/prioritas?action=reject&isetting_prioritas_upi_id='.$rowData['isetting_prioritas_upi_id'].'&cNip='.$cNip.'&lvl=1&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_import_setting_prioritas">Reject</button>';

	$approve_dir = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/setting/prioritas?action=approve&isetting_prioritas_upi_id='.$rowData['isetting_prioritas_upi_id'].'&cNip='.$cNip.'&lvl=2&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_import_setting_prioritas">Approve</button>';
	$reject_dir = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/setting/prioritas?action=reject&isetting_prioritas_upi_id='.$rowData['isetting_prioritas_upi_id'].'&cNip='.$cNip.'&lvl=2&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_import_setting_prioritas">Reject</button>';


	$update = '<button onclick="javascript:update_btn_back(\'import_setting_prioritas\', \''.base_url().'processor/plc/import/setting/prioritas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_import_setting_prioritas">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'import_setting_prioritas\', \''.base_url().'processor/plc/import/setting/prioritas?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_import_setting_prioritas">Update as Draft</button>';



	if ($this->input->get('action') == 'view') {unset($buttons['update']);}

	else{
		
		unset($buttons['update_back']);
		unset($buttons['update']);
		
		if ($rowData['iSubmit_prio']== 0) {
			// jika masih draft , show button update draft & update submit 
			if (isset($mydept)) {
				// cek punya dep
				if((in_array('BDI', $mydept))) {
					//cek dep ada bdirm
					//$x = $this->auth->my_teams();
					//$array = explode(',', $x);
						// cek user bagian dari tim bd terkait
					//	if((in_array($idtim_bd, $array))) {
							$buttons['update'] = $update.$updatedraft.$js;
					//	}
				}
			}

		}else{
			// sudah disubmit , show button approval 
			if ($rowData['iApprove_bdirm']==0) {
				// jika approval bdirm 0 
				if (isset($mydept)) {
					if((in_array('BDI', $mydept))) {
						if($this->auth->is_manager()){
							$buttons['update'] = $approve_bdirm.$reject_bdirm.$js;	
						}
					}
				}

				

			}else if($rowData['iApprove_dir']==0){
				if ($rowData['iApprove_bdirm']==2) {
					if (isset($mydept)) {
						if((in_array('DR', $mydept))) {
							if($this->auth->is_manager()){
								$buttons['update'] = $approve_dir.$reject_dir.$js;
							}
						}
					}
					
				}

				
			}


			

			
		}
		

		//$buttons['update'] = $update.$updatedraft.$approve.$reject.$js;
		//$buttons['update'] = $update.$updatedraft.$approve_dir.$reject_dir.$js;
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
								var url = "'.base_url().'processor/plc/import/setting/prioritas";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_import_setting_prioritas").html(data);
										 $("#button_approve_import_setting_prioritas").hide();
										 $("#button_reject_import_setting_prioritas").hide();
									});
									
								}
									reload_grid("grid_import_setting_prioritas");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_import_setting_prioritas_approve" action="'.base_url().'processor/plc/import/setting/prioritas?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="isetting_prioritas_upi_id" value="'.$this->input->get('isetting_prioritas_upi_id').'" />
				<input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_import_setting_prioritas_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$isetting_prioritas_upi_id = $post['isetting_prioritas_upi_id'];
		$lvl = $post['lvl'];
		$vRemark = $post['vRemark'];

		if ($lvl == 2) {
			//approval direksi 
			$data=array('iApprove_dir'=>'2','cApprove_dir'=>$cNip , 'dApprove_dir'=>date('Y-m-d H:i:s'), 'vRemark_dir'=>$vRemark);
		}else{
			//bdirm
			$data=array('iApprove_bdirm'=>'2','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>date('Y-m-d H:i:s'), 'vRemark_bdirm'=>$vRemark);
		}
		$this -> db -> where('isetting_prioritas_upi_id', $isetting_prioritas_upi_id);
		$updet = $this -> db -> update('plc2.setting_prioritas_upi', $data);
/*
		$logged_nip =$this->user->gNIP;
		$qupd="select a.iSemester,a.iTahun,a.iSubmit_prio,b.cNip,b.vName,a.cCreated 
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BI' and te.ldeleted=0) as bi
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 order by te.iteam_id DESC limit 1) as ad1
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 order by te.iteam_id ASC limit 1) as ad2
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='IM' and te.ldeleted=0) as im
				from dossier.dossier_prioritas a 
				join hrd.employee b on b.cNip = a.cCreated
				where a.lDeleted = 0
				and a.iupi_id = '".$iupi_id."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_prio'] ;

		if ($updet) {
			$bi = $rupd['bi'];
			$ad1 = $rupd['ad1'];
			$ad2 = $rupd['ad2'];
			$im = $rupd['im'];

			//$team = $dr ;
			$team = $bi. ','.$ad1. ','.$ad2. ','.$im;
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

			$to = $toEmail2.';'.$toEmail;
			$cc = $arrEmail;                        

			//$to = $arrEmail;
			//$cc = $toEmail2.';'.$toEmail;                        

				$subject="Approval : Setting Prioritas ".$rupd['iTahun']." - Semester ".$rupd['iSemester'];
				$content="Diberitahukan bahwa telah ada approval Prioritas UPD dari Direksi pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
*/


		$data['status']  = true;
		$data['last_id'] = $post['isetting_prioritas_upi_id'];
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_import_setting_prioritas_remark").val();
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
								var url = "'.base_url().'processor/plc/import/setting/prioritas";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_import_setting_prioritas").html(data);
										 $("#button_approve_import_setting_prioritas").hide();
										 $("#button_reject_import_setting_prioritas").hide();
									});
									
								}
									reload_grid("grid_import_setting_prioritas");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_import_setting_prioritas_reject" action="'.base_url().'processor/plc/import/setting/prioritas?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="isetting_prioritas_upi_id" value="'.$this->input->get('isetting_prioritas_upi_id').'" />
				<input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="reject_import_setting_prioritas_remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_import_setting_prioritas_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function reject_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$isetting_prioritas_upi_id = $post['isetting_prioritas_upi_id'];
		$lvl = $post['lvl'];
		$vRemark = $post['vRemark'];

		if ($lvl == 2) {
			//approval direksi 
			$data=array('iApprove_dir'=>'1','cApprove_dir'=>$cNip , 'dApprove_dir'=>date('Y-m-d H:i:s'), 'vRemark_dir'=>$vRemark);
		}else{
			//bdirm
			$data=array('iApprove_bdirm'=>'1','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>date('Y-m-d H:i:s'), 'vRemark_bdirm'=>$vRemark);
		}
		$this -> db -> where('isetting_prioritas_upi_id', $isetting_prioritas_upi_id);
		$updet = $this -> db -> update('plc2.setting_prioritas_upi', $data);

/*
		$logged_nip =$this->user->gNIP;
		$qupd="select a.iSemester,a.iTahun,a.iSubmit_prio,b.cNip,b.vName,a.cCreated 
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BI' and te.ldeleted=0) as bi
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 order by te.iteam_id DESC limit 1) as ad1
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 order by te.iteam_id ASC limit 1) as ad2
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='IM' and te.ldeleted=0) as im
				from dossier.dossier_prioritas a 
				join hrd.employee b on b.cNip = a.cCreated
				where a.lDeleted = 0
				and a.iupi_id = '".$iupi_id."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_prio'] ;

		if ($updet) {
			$bi = $rupd['bi'];
			$ad1 = $rupd['ad1'];
			$ad2 = $rupd['ad2'];
			$im = $rupd['im'];

			//$team = $dr ;
			$team = $bi. ','.$ad1. ','.$ad2. ','.$im;
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

			$to = $toEmail2.';'.$toEmail;
			$cc = $arrEmail;                        

			//$to = $arrEmail;
			//$cc = $toEmail2.';'.$toEmail;                        

				$subject="Approval : Setting Prioritas ".$rupd['iTahun']." - Semester ".$rupd['iSemester'];
				$content="Diberitahukan bahwa telah ada approval Prioritas UPD dari Direksi pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
*/


		$data['status']  = true;
		$data['last_id'] = $post['isetting_prioritas_upi_id'];
		return json_encode($data);
	}


	
/*function pendukung end*/    	

	public function output(){
		$this->index($this->input->get('action'));
	}

}

