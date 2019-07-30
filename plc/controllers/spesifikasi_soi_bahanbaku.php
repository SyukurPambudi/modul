<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Spesifikasi_soi_bahanbaku extends MX_Controller {
		var $url;
		var $db_plc0;
	function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		
		$this->load->library('auth_localnon');
		$this->user = $this->auth_localnon->user();

		$this->load->library('biz_process');
        $this->load->library('lib_utilitas');
		//$this->db_plc0 = $this->load->database('plc', true); 
		$this->url = 'spesifikasi_soi_bahanbaku';
    }
    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle('SOI Bahan Baku');		
		$grid->setTable('plc2.plc2_upb_soi_bahanbaku');		
		$grid->setUrl('spesifikasi_soi_bahanbaku');
		$grid->addList('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','vkode_surat','itype','vrevisi', 'iappqc', 'iappqa');
		$grid->setSortBy('isoibb_id');
		$grid->setSortOrder('DESC');
		$grid->setQuery('plc2.plc2_upb_soi_bahanbaku.ldeleted', 0);
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setAlign('vrevisi', 'center');
		$grid->setAlign('itype', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '100');
		$grid->setWidth('plc2_upb.iteampd_id', '150');
		$grid->setWidth('plc2_upb.vupb_nama', '250');
		$grid->setWidth('plc2_upb.vgenerik', '250');
		$grid->setWidth('vrevisi', '75');
		$grid->setWidth('itype', '75');
		$grid->setFormWidth('vrevisi',5);
		$grid->setFormWidth('vupb_nama',40);
		$grid->setFormWidth('vgenerik',40);
		$grid->setFormWidth('iteampd_id',25);
		$grid->setFormWidth('vkode_surat',20);
		$grid->addFields('iupb_id','vupb_nama','vgenerik','iteampd_id','vkode_surat','tberlaku','filename','vrevisi','itype','vnip_formulator','vnip_qc','vnip_qa');
		$grid->setRequired('iupb_id','vkode_surat','filename','tberlaku','itype','fmikro');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('plc2_upb.iupb_id', 'No. UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setLabel('iteampd_id', 'Team PD');
		$grid->setLabel('plc2_upb.iteampd_id', 'Team PD');
		$grid->setLabel('vkode_surat', 'No. SOI');
		$grid->setLabel('tberlaku', 'Tanggal Berlaku');
		$grid->setLabel('filename', 'Nama File');		
		$grid->setLabel('vrevisi', 'Revisi');
		$grid->setLabel('itype', 'Status');
		$grid->setLabel('vnip_formulator', 'Penyusun');
		// $grid->setLabel('iappqc', 'QC Approval');
		// $grid->setLabel('iappqa', 'QA Approval');
		$grid->setLabel('iappqc', 'PD Approval');
		$grid->setLabel('iappqa', 'QA Approval');
		$grid->setLabel('vnip_qc', 'PD Approval');
		$grid->setLabel('vnip_qa', 'QA Approval');
		
		$grid->setFormUpload(TRUE);

		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb_soi_bahanbaku.iupb_id = plc2.plc2_upb.iupb_id', 'INNER');
		$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			// if(in_array('QC', $manager)){
			// 	$type='QC';
			// 	$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth_localnon->my_teams().')', null);
			// }
			// else
			if(in_array('QA', $manager)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			elseif(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			// if(in_array('QC', $team)){
			// 	$type='QC';
			// 	$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth_localnon->my_teams().')', null);
			// }
			//else
			if(in_array('QA', $team)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			elseif(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','vkode_surat','itype','vrevisi');
		$grid->setQuery('plc2_upb.ihold', 0);
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				$isUpload = $this->input->get('isUpload');
				$sql = array();
   				if($isUpload) {
					$path = realpath("files/plc/soi_bahanbaku/");
					if (!mkdir($path."/".$this->input->get('lastId'), 0777, true)) {
					    die('Failed upload, try again!');
					}
					$file_keterangan = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'fileketerangan') {
							foreach($value as $k=>$v) {
								$file_keterangan[$k] = $v;
							}
						}
					}
					
					$i = 0;
					foreach ($_FILES['fileupload']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {				
							$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
							$name = $_FILES['fileupload']["name"][$key];
							$data['filename'] = $name;
							$data['id']=$this->input->get('lastId');
							//$data['iupb_id'] = $insertId;
							//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							$data['dInsertDate'] = date('Y-m-d H:i:s');
							if(move_uploaded_file($tmp_name, $path."/".$this->input->get('lastId')."/".$name)) {	
								$sql[] = "INSERT INTO plc2_upb_file_soi_bahanbaku (isoibb_id, filename, dInsertDate, vKeterangan, cInsert) 
										VALUES ('".$data['id']."', '".$data['filename']."','".$data['dInsertDate']."','".$file_keterangan[$i]."','".$this->user->gNIP."')";
							
								$i++;																			
							}
							else{
							echo "Upload ke folder gagal";	
							}
						}
						
					}
					
					foreach($sql as $q) {
						try {
							$this->db_plc0->query($q);
						}catch(Exception $e) {
							die($e);
						}
					}
					
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');					
					echo json_encode($r);
					exit();
				}  else {
					echo $grid->saved_form();
				}	
				break;		
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'), TRUE);
				break;
			case 'updateproses':
				$isUpload = $this->input->get('isUpload');
				$sql = array();
   				$file_name= "";
				
				$fileId = array();
				
				$path = realpath("files/plc/soi_bahanbaku/");
				
				if (!file_exists( $path."/".$this->input->post('spesifikasi_soi_bahanbaku_isoibb_id') )) {
					mkdir($path."/".$this->input->post('spesifikasi_soi_bahanbaku_isoibb_id'), 0777, true);						 
				}				
				$file_keterangan = array();
				
				foreach($_POST as $key=>$value) {
											
					if ($key == 'fileketerangan') {
						foreach($value as $y=>$u) {
							$file_keterangan[$y] = $u;
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

				//$x=0;				
				/*foreach($fileId as $k=>$v) {
					$SQL = "UPDATE plc2_upb_file_soi_fg SET vKeterangan = '".$file_keterangan[$k]."' where id = '".$v."'"; 
					$this->db_plc0->query($SQL);
					$x=$k;
				}*/
				//$last_index = $x+1;
				$last_index = 0;	
						
   				if($isUpload) {
					$j = $last_index;			
					if (isset($_FILES['fileupload'])) {
						//$this->hapusfile($path, $file_name, 'plc2.plc2_upb_file_soi_bahanbaku', $this->input->post('spesifikasi_soi_bahanbaku_isoibb_id'));
						foreach ($_FILES['fileupload']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
								$name = $_FILES['fileupload']["name"][$key];
								$data['filename'] = $name;
								$data['id']=$this->input->post('spesifikasi_soi_bahanbaku_isoibb_id');
								$data['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name, $path."/".$this->input->post('spesifikasi_soi_bahanbaku_isoibb_id')."/".$name)) 
				 				{
									$sql[] = "INSERT INTO plc2.plc2_upb_file_soi_bahanbaku (isoibb_id, filename, dInsertDate, vKeterangan, cInsert) 
										VALUES ('".$data['id']."', '".$data['filename']."','".$data['dInsertDate']."','".$file_keterangan[$j]."','".$data['nip']."')";
							
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
							$this->db_plc0->query($q);
						}catch(Exception $e) {
							die($e);
						}
					}
					
				
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->post('spesifikasi_soi_bahanbaku_isoibb_id');					
					echo json_encode($r);
					exit();
				}  else {
						
					if (is_array($file_name)) {									
						//$this->hapusfile($path, $file_name, 'plc2.plc2_upb_file_soi_bahanbaku', $this->input->post('spesifikasi_soi_bahanbaku_isoibb_id'));
					}
													
					echo $grid->updated_form();
				}
				break;
			case 'detail':
				$this->detail();
				break;
			case 'download':
				$this->download($this->input->get('file'));
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
			 //tambah delete
			case 'delete':
				echo $grid->delete_row();
			break; 
			default:
				$grid->render_grid();
				break;
		}
    }
	
	function manipulate_insert_button($buttons){
		$url=$this->url;
		unset($buttons['save']);
		//echo $this->auth_localnon->my_teams();
		/*$arrhak=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
		//print_r($arrhak);
		//exit;
		if(empty($arrhak)){
			
		}else{*/
			$btnSave='<button onclick="javascript:save_btn_multiupload(\'spesifikasi_soi_bahanbaku\', \''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_'.$url.'">Save</button>';
			$js = $this->load->view('spesifikasi_soi_bahanbaku_js');
			$buttons['save'] = $btnSave.$js;
		//}		
		return $buttons;
	}
	function manipulate_update_button($buttons, $rowData) {
    	//print_r($rowData);
		if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			unset($buttons['update_back']);
			unset($buttons['update']);
    
    	$user = $this->auth_localnon->user();
    
    	$x=$this->auth_localnon->dept();
    	if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		// if(in_array('QC', $manager)){$type='QC';}
    		// else
    		if(in_array('QA', $manager)){$type='QA';}
			elseif(in_array('PD', $manager)){$type='PD';} //AD yg ada didlm tim PD bisa input dan update
    		else{$type='';}
    	}
		else{
		//yg bisa add team PD
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';}
			elseif(in_array('QA', $team)){$type='QA';} //AD yg ada didlm tim PD bisa input dan update
    		else{$type='';}
		}
		// cek status upb, klao upb 
			unset($buttons['update_back']);
    		unset($buttons['update']);
			
			$js = $this->load->view('spesifikasi_soi_bahanbaku_js');
			// echo $this->auth_localnon->my_teams();
			// echo $type;
			
    		$upb_id=$rowData['iupb_id'];
			$isoibb_id=$rowData['isoibb_id'];
			$qcek="select f.itype, f.iappqc,f.tberlaku, f.iappqa from plc2.plc2_upb_soi_bahanbaku f where f.isoibb_id=$isoibb_id and f.ldeleted=0";
			$rcek = $this->db_plc0->query($qcek)->row_array();
			
			// //cek upb sudah pny best formula dan sudah pny spek fg final
			// $qfcek="select * from plc2.plc2_upb_formula fm 
					// inner join plc2.plc2_upb_spesifikasi_fg fg on fg.iupb_id=$upb_id and fg.itype=1 
					// where fm.iupb_id=$upb_id and fm.ibest=2";
			// $fcek = $this->db_plc0->query($qfcek)->num_rows();
			
			$x=$this->auth_localnon->dept();
			//print_r($x);
			//$arrhak=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
		//print_r($arrhak);
		//echo $type;
			/*if(empty($arrhak)){
				$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
				if(empty($getbp)){}
				else{
					if($this->auth_localnon->is_manager()){
						if(($type=='PD')&&($rcek['tberlaku']=="")){ // PD bisa update selama QC blm app
							$update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_bahanbaku\', \''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$buttons['update'] = $update.$js;//.$approve.$reject;
						}
						elseif(($type=='PD')&&($rcek['tberlaku']!="")){
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?action=approve&isoibb_id='.$rowData['isoibb_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Approve</button>';
							$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?action=reject&isoibb_id='.$rowData['isoibb_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Reject</button>';
								
							$buttons['update'] = $approve.$reject;
						}
						elseif(($type=='QA')&&($rcek['iappqa']==0) && ($rcek['iappqc']<>0)){
							$update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_bahanbaku\', \''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?action=approve&isoibb_id='.$rowData['isoibb_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Approve</button>';
							$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?action=reject&isoibb_id='.$rowData['isoibb_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Reject</button>';
			
							$buttons['update'] = $update.$approve.$reject.$js;
						}
						elseif(($type=='QA')&&($rcek['iappqa']==0)){
							$update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_bahanbaku\', \''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$buttons['update'] = $update.$js;
						}
						else{}
					//array_unshift($buttons, $reject, $approve, $revise);
					}
					else{
					//echo "test";
						if(($type=='PD')&&($rcek['iappqc']==0) &&($rcek['iappqa']==0)){
							$update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_bahanbaku\', \''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$buttons['update'] = $update.$js;
						}
					}
				}
			}else{*/
				if($this->auth_localnon->is_manager()){
					if(($type=='PD')&&($rcek['tberlaku']=="")){ // PD bisa update selama QC blm app
						$update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_bahanbaku\', \''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
						$buttons['update'] = $update.$js;//.$approve.$reject;
					}
					elseif(($type=='PD')&&($rcek['tberlaku']!="")&& ($rcek['iappqa']==0)){
					//elseif(($type=='PD')&&($rcek['tberlaku']!="")&& ($rcek['iappqc']==0)){ 
						$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?action=approve&isoibb_id='.$rowData['isoibb_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_bb">Approve</button>';
						$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?action=reject&isoibb_id='.$rowData['isoibb_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_bb">Reject</button>';
							
						$buttons['update'] = $approve.$reject;
					//echo "<br> aaaaaaaaa--------";
					}
					elseif(($type=='QA')&&($rcek['iappqa']==0)){
					//elseif(($type=='QA')&&($rcek['iappqa']==0) && ($rcek['iappqc']<>0)){
							$update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_bahanbaku\', \''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?action=approve&isoibb_id='.$rowData['isoibb_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Approve</button>';
							$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?action=reject&isoibb_id='.$rowData['isoibb_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Reject</button>';
			
							$buttons['update'] = $update.$approve.$reject.$js;
					}
					elseif(($type=='QA')&&($rcek['iappqa']==0)){
							$update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_bahanbaku\', \''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$buttons['update'] = $update.$js;
					}
					else{}
					//array_unshift($buttons, $reject, $approve, $revise);
				}
				else{
					if(($type=='PD')&&($rcek['iappqa']==0)){
							$update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_bahanbaku\', \''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$buttons['update'] = $update.$js;
					}else if(($type=='QA')&&($rcek['iappqa']==0)){
						$update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_bahanbaku\', \''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?action=approve&isoibb_id='.$rowData['isoibb_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Approve</button>';
							$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/bahanbaku?action=reject&isoibb_id='.$rowData['isoibb_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Reject</button>';
			
							$buttons['update'] = $update.$approve.$reject.$js;
					}
				}
			/*}*/
   
		}
    	return $buttons;
    }
    public function listBox_Action($row, $actions) {
    	//cek apakah ada spek soi FG upb itu yg statusnya sudah Final, 
		//print_r($row);
		$iupbid=$row->iupb_id;
    	// $sqle="select count(*) as jum from plc2.plc2_upb_soi_fg f where f.iupb_id=$iupbid and f.itype=1 and f.iappqa_f<>0";
		// $jum=$this->db_plc0->query($sqle)->row_array();
		// //kalo iya unset edit dan delete nya
		// if($jum['jum']>0){
			// // if($row->itype==0){
				// unset($actions['edit']);
				// unset($actions['delete']);
			// // }
			
		// }
		//jika manager
    	if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
			//print_r($manager);
    		// Jika QCM sudah app, QCM tidak bisa edit
    		// if(in_array('QC', $manager)){
    			// if(($row->iappqc<>0)){
    				// unset($actions['edit']);
    				// unset($actions['delete']);
    			// }
    		// }
    		// jika QAM blm app QA tidak edit
    		if(in_array('QA', $manager)){
    			if($row->iappqa<>0){
    			//if(($row->iappqc<>2) && ($row->iappqa<>0)){
				//echo "sss";
    				unset($actions['edit']);
    				unset($actions['delete']);
    			}
    		}

    		if(in_array('PD', $manager)){
    			if(($row->iappqa<>0)){
    			//if(($row->iappqc<>0)){
				//echo "sss";
    				unset($actions['edit']);
    				unset($actions['delete']);
    			}
    		}
    		
    	}
		//jika bukan manager
    	else{

    		$x=$this->auth_localnon->dept();
    		$team=$x['team'];




    		if(in_array('QA', $team)){
				$type='QA';
				if($row->iappqa<>0){
					unset($actions['edit']);
				}
			}else{
				    		// jika QCM sudah approve/ reject, staff tidak bisa edit
				if($row->iappqc<>0){
	    			unset($actions['edit']);
	    			unset($actions['delete']);
	    		}
			}



    	}
    	return $actions;
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
								var url = "'.base_url().'processor/plc/spesifikasi/soi/bahanbaku";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_spesifikasi_soi_bahanbaku").html(data);
									});
					
								}
									reload_grid("grid_spesifikasi_soi_bahanbaku");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_spesifikasi_soi_bahanbaku_approve" action="'.base_url().'processor/plc/spesifikasi/soi/bahanbaku?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : <input type="hidden" name="isoibb_id" value="'.$this->input->get('isoibb_id').'" />
    			<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_spesifikasi_soi_bahanbaku_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
		//print_r($post);
    	$this->db_plc0->where('iupb_id', $post['iupb_id']);
    	$iapprove = $post['type'] == 'PD' ? 'isoibbqc' : 'isoibbqa';
    	$this->db_plc0->update('plc2.plc2_upb', array($iapprove=>2));
    	
    	$this->db_plc0->where('isoibb_id', $post['isoibb_id']);
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$iappnip = $post['type'] == 'PD' ? 'vnip_qc' : 'vnip_qa';
		$iappdate = $post['type'] == 'PD' ? 'tapp_qc' : 'tapp_qa';
    	$iapprove = $post['type'] == 'PD' ? 'iappqc' : 'iappqa';
		$istatus=$post['type'] == 'PD' ? '2' : '3';
    	$this->db_plc0->update('plc2.plc2_upb_soi_bahanbaku', array($iapprove=>2, 'istatus'=>$istatus, $iappnip=>$nip, $iappdate=>$skg));
    
    	//jika ada satu saja spek fg dari upb tsb blm di app/ reject maka isoiqc / ispekqa = 1
    	$upbid=$post['iupb_id'];
    	$query = "select count(isoibb_id) as c from plc2.plc2_upb_soi_bahanbaku where iupb_id = $upbid and $iapprove = 0";
    	//echo $query;
    	$rows = $this->db_plc0->query($query)->row_array();
    	//echo $rows;
    	$total = $rows['c'];
    	 
    	
    	$ins['iupb_id'] = $post['iupb_id'];
		$ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
		$ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
		$ins['idiv_id'] = '';
		$ins['vtipe'] = $post['type'];
		$ins['iapprove'] = '2';
		$ins['cnip'] = $this->user->gNIP;
		$ins['treason'] = 'Tentative '.$post['remark'];
		$ins['tupdate'] = date('Y-m-d H:i:s');
    
    	$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
    	
//		$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // 1 approval
//		$bizsup=$getbp['idplc2_biz_process_sub'];
		
		$isoibb_id=$this->input->post('isoibb_id');
		$qcek="select f.isoibb_id, f.itype, f.iappqc, f.iappqa from plc2.plc2_upb_soi_bahanbaku f where f.isoibb_id=$isoibb_id";
		$rcek = $this->db_plc0->query($qcek)->row_array();

            
            $qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
                            from plc2.plc2_upb u where u.iupb_id='".$post['iupb_id']."'";
            $rupb = $this->db_plc0->query($qupb)->row_array();

            $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id 
                    from plc2.plc2_upb u where u.iupb_id='".$post['iupb_id']."'";
            $rsql = $this->db_plc0->query($qsql)->row_array();

            //$query = $this->db_plc0->query($rsql);

            $pd = $rsql['iteampd_id'];
            $qc = $rsql['iteamqc_id'];
            $qa = $rsql['iteamqa_id'];

            $team = '' ;
            $toEmail2='';
            $toEmail='';

            if($post['type']=='QC'){
                $subject="Approved by QC - SOI Bahan Baku (UPB ".$rupb['vupb_nomor'].")";
                $a = "Diberitahukan bahwa telah ada approval UPB oleh QC Manager pada proses SOI Bahan Baku(aplikasi PLC) dengan rincian sebagai berikut :<br><br>";
                $b = "<td><b>Proses Selanjutnya</b></td><td> : </td><td>Approval oleh QA</td>";
                //$team = $pd. ','.$qa. ','.$qc ;
                $team = $qa;
                $team_cc = $pd.','.$qc ;
            } elseif($post['type']=='QA'){
                $subject="Approved by QA - SOI Bahan Baku (UPB ".$rupb['vupb_nomor'].")";
                $a = "Diberitahukan bahwa telah ada approval UPB oleh QA Manager pada proses SOI Bahan Baku(aplikasi PLC) dengan rincian sebagai berikut :<br><br>";
                $b = "<td><b>Proses Selanjutnya</b></td><td> : </td><td>Formula Skala Trial - Input data oleh PD</td>";
                $team = $pd ;
                $team_cc = $qa.','.$qc ;                
            }

            $toEmail = $this->lib_utilitas->get_email_team( $team );
            $ccEmail = $this->lib_utilitas->get_email_team( $team_cc );
            $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
            $ccEmail2 = $this->lib_utilitas->get_email_leader( $team_cc );
            $arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );

            $to = $cc = '';
            if(is_array($arrEmail)) {
                    $count = count($arrEmail);
                    $to = $arrEmail[0];
                    for($i=1;$i<$count;$i++) {
                            $cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
                    }
            }			

            $to = $toEmail2.";".$toEmail;
            $cc = $arrEmail.";".$ccEmail.";".$ccEmail2;

            $content=$a."
                    <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
                            <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
                                    <tr>
                                            <td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
                                    </tr>
                                    <tr>
                                            <td><b>Nama Usulan</b></td><td> : </td><td>".$rupb['vupb_nama']."</td>
                                    </tr>
                                    <tr>
                                            <td><b>Nama Generik</b></td><td> : </td><td>".$rupb['vgenerik']."</td>
                                    </tr>
                                    <tr>
                                            <td><b>Team Busdev</b></td><td> : </td><td>".$rupb['bd']."</td>
                                    </tr>
                                    <tr>
                                            <td><b>Team PD</b></td><td> : </td><td>".$rupb['pd']."</td>
                                    </tr>
                                    <tr>
                                            <td><b>Team QA</b></td><td> : </td><td>".$rupb['qa']."</td>
                                    </tr>
                                    <tr>
                                            <td><b>Team QC</b></td><td> : </td><td>".$rupb['qc']."</td>
                                    </tr>
                                    <tr>
                                            ".$b."
                                    </tr>
                            </table>
                    </div>
                    <br/> 
                    Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
                    Post Master";
                 //   echo $to;
                  //  echo "</br></br></br>CC";
                  //  echo $cc;
                  //  echo $content;
                  //  echo exit;
            $this->lib_utilitas->send_email($to, $cc, $subject, $content);
                            
		$data['status']  = true;
    	$data['last_id'] = $isoibb_id;
    	return json_encode($data);
    }
    
    function reject_view() {
    	$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	if($("#remark").val()==""){
							alert("Isi alasan! ");
							return false;
						}
						 else{
							return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/spesifikasi/soi/bahanbaku";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_spesifikasi_soi_bahanbaku").html(data);
									});
					
								}
									reload_grid("grid_spesifikasi_soi_bahanbaku");
							}
							})
						 }
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_spesifikasi_soi_bahanbaku_reject" action="'.base_url().'processor/plc/spesifikasi/soi/bahanbaku?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
    			<input type="hidden" name="isoibb_id" value="'.$this->input->get('isoibb_id').'" />
    			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
    			<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark" id="remark" required></textarea><button type="button" onclick="submit_ajax(\'form_spesifikasi_soi_bahanbaku_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process () {
    	$post = $this->input->post();
    	$this->db_plc0->where('iupb_id', $post['iupb_id']);
    	$iapprove = $post['type'] == 'QC' ? 'isoibbqc' : 'isoibbqa';
    	$this->db_plc0->update('plc2.plc2_upb', array($iapprove=>1));
    	
    	$this->db_plc0->where('isoibb_id', $post['isoibb_id']);
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$iappnip = $post['type'] == 'QC' ? 'vnip_qc' : 'vnip_qa';
		$iappdate = $post['type'] == 'QC' ? 'tapp_qc' : 'tapp_qa';
    	$iapprove = $post['type'] == 'QC' ? 'iappqc' : 'iappqa';
    	$this->db_plc0->update('plc2.plc2_upb_soi_bahanbaku', array($iapprove=>1, 'istatus'=>0, $iappnip=>$nip, $iappdate=>$skg));
    
    	//jika ada satu saja spek fg dari upb tsb blm di app/ reject maka ispekpd / ispekqa = 1
    	$upbid=$post['iupb_id'];
    	$query = "select count(isoibb_id) as c from plc2.plc2_upb_soi_bahanbaku where iupb_id = $upbid and $iapprove = 0";
    	//echo $query;
    	$rows = $this->db_plc0->query($query)->row_array();
    	//echo $rows;
    	$total = $rows['c'];
    	
    	$ins['iupb_id'] = $post['iupb_id'];
		$ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
		$ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
		$ins['idiv_id'] = '';
		$ins['vtipe'] = $post['type'];
		$ins['iapprove'] = '2';
		$ins['cnip'] = $this->user->gNIP;
		$ins['treason'] = $post['remark'];
		$ins['tupdate'] = date('Y-m-d H:i:s');
    
    	$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
    
		/*$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // 1 approval
		$bizsup=$getbp['idplc2_biz_process_sub'];
		
		$isoibb_id=$this->input->post('isoibb_id');
		$qcek="select f.isoibb_id, f.itype, f.iappqc, f.iappqa from plc2.plc2_upb_soi_bahanbaku f where f.isoibb_id=$isoibb_id";
		$rcek = $this->db_plc0->query($qcek)->row_array();
		// if($rcek['itype']==1){
			// //insert log
				// $this->biz_process->insert_log($upbid, $bizsup, 2); // status 1 => approve
			// //update last log
				// $this->biz_process->update_last_log($post['iupb_id'], $bizsup, 2);
		// }
		// elseif($rcek['itype']==0){
			//insert log
				$this->biz_process->insert_log($upbid, $bizsup, 2); // status 1 => submit
			//insert last log
				$this->biz_process->insert_last_log($upbid, $bizsup, 2);
		// }*/
		
    	$data['status']  = true;
    	$data['last_id'] = $isoibb_id;
    	return json_encode($data);
    }
	
	function before_insert_processor($row, $postData) {
		$this->load->helper('to_mysql');
		// unset($postData['fmikro']);
		// unset($postData['vupb_nama']);unset($postData['vgenerik']);unset($postData['iteampd_id']);
		$postData['tberlaku'] = to_mysql($postData['tberlaku']);
		return $postData;
	}
	function after_insert_processor($row, $insertId, $postData) {
		//print_r($postData); exit();
	/*	$upbId = $postData['iupb_id'];
		$i=1;
		$skrg = date('Y-m-d H:i:s');
		$user = $this->auth_localnon->user();
		
		$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
		$bizsup=$getbp['idplc2_biz_process_sub'];
		$qcek="select f.isoibb_id, f.itype, f.iappqc, f.iappqa from plc2.plc2_upb_soi_bahanbaku f where f.isoibb_id=$insertId";
		$rcek = $this->db_plc0->query($qcek)->row_array();
			//insert log
				$this->biz_process->insert_log($postData['iupb_id'], $bizsup, 7); // status 7=> submit
			//update last log
				$this->biz_process->insert_last_log($postData['iupb_id'], $bizsup, 7);*/
		
	}
	function before_update_processor($row, $postData) {
		
		$this->load->helper('to_mysql');
		// unset($postData['fmikro']);
		// unset($postData['vupb_nama']);unset($postData['vgenerik']);unset($postData['iteampd_id']);
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){
				$type='QA';
			}
			else{$type='';}
			
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('QA', $team)){
				$type='QA';
			}else{$type='';}
		}
		if($type=='QA'){unset($postData['vnip_qc']);}
		$postData['tberlaku'] = to_mysql($postData['tberlaku']);
		//print_r($postData);
		return $postData;
	}
	function after_update_processor($row, $updateId, $postData) {
		/*$this->load->helper('search_array');
		$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
		$bizsup=$getbp['idplc2_biz_process_sub'];
		//echo $bizsup; 
		$qcek="select f.isoibb_id, f.itype, f.iappqc, f.iappqa from plc2.plc2_upb_soi_bahanbaku f where f.isoibb_id=$updateId";
		$rcek = $this->db_plc0->query($qcek)->row_array();
			//insert log
				$this->biz_process->insert_log($postData['iupb_id'], $bizsup, 7); // status 7 => submit
			//update last log
				$this->biz_process->update_last_log($postData['iupb_id'], $bizsup, 7);*/
	}
	function listBox_spesifikasi_soi_bahanbaku_itype($value) {
    	if($value==0){$vstatus='Tentative';}
    	elseif($value==1){$vstatus='Final';}
    	return $vstatus;
    }
	function listBox_spesifikasi_soi_bahanbaku_iappqc($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
    function listBox_spesifikasi_soi_bahanbaku_iappqa($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }

	//status (itype)
	function insertBox_spesifikasi_soi_bahanbaku_itype($field, $id) {		
		return 'Final &nbsp;<input type="hidden" value="1" name="'.$id.'" id="'.$id.'" class="input_rows1" size="25" />';
	}
	function updateBox_spesifikasi_soi_bahanbaku_itype($field, $id, $value, $rowData) {
		 //print_r($rowData);
		return 'Final &nbsp;<input type="hidden" value="1" name="'.$id.'" id="'.$id.'" class="input_rows1" size="25" />';
	}
	//
	
	//Keterangan approval 
	function insertBox_spesifikasi_soi_bahanbaku_vnip_qc($field, $id) {
		return ' ';
	}
	function updateBox_spesifikasi_soi_bahanbaku_vnip_qc($field, $id, $value, $rowData) {
		if($rowData['vnip_qc'] != null){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_qc']))->row_array();
			if($rowData['iappqc']==2){$st="Approved";}elseif($rowData['iappqc']==1){$st="Rejected";
				$rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// $reason=$rowa['treason'];
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_qc'].' )'.' pada '.$rowData['tapp_qc'];
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	function insertBox_spesifikasi_soi_bahanbaku_vnip_qa($field, $id) {
		return ' ';
	}
	function updateBox_spesifikasi_soi_bahanbaku_vnip_qa($field, $id, $value, $rowData) {
		if($rowData['vnip_qa'] != null){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_qa']))->row_array();
			if($rowData['iappqa']==2){$st="Approved";}elseif($rowData['iappqa']==1){$st="Rejected";
				$rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// $reason=$rowa['treason'];
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_qa'].' )'.' pada '.$rowData['tapp_qa'];
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	
	function updateBox_spesifikasi_soi_bahanbaku_tberlaku($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1 required" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	
	function insertBox_spesifikasi_soi_bahanbaku_iupb_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="7" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/soibb/popup?field=spesifikasi_soi_bahanbaku\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function updateBox_spesifikasi_soi_bahanbaku_iupb_id($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$value))->row_array();
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" value="'.$value.'" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" value="'.$row['vupb_nomor'].'" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="7" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/soibb/popup?field=spesifikasi_soi_bahanbaku\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function insertBox_spesifikasi_soi_bahanbaku_filename($field, $id) {
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('spesifikasi_soi_bahanbaku_file',$data,TRUE);
	}
	function updateBox_spesifikasi_soi_bahanbaku_filename($field, $id, $value, $rowData) {
		$idsoi = $rowData['isoibb_id'];	
		//$this->db_plc0->where('ispekfg_id',$rowData['ispekfg_id']);
		//$this->db_plc0->where('ldeleted', 0);
		//$data['rows'] = $this->db_plc0->get('plc2.plc2_upb_file_spesifikasi_fg')->result_array();	
		//print_r($data);
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_soi_bahanbaku', array('isoibb_id'=>$idsoi))->result_array();
		return $this->load->view('spesifikasi_soi_bahanbaku_file',$data,TRUE);
	}

	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/soi_bahanbaku/'.$id.'/'.$name);		
		force_download($name, $path);
	}
	 
	function insertBox_spesifikasi_soi_bahanbaku_vupb_nama($field, $id) {
		return '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="40" />';
	}
	function updateBox_spesifikasi_soi_bahanbaku_vupb_nama($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" value="'.$row['vupb_nama'].'" class="input_rows1" size="40" />';
	}
	function insertBox_spesifikasi_soi_bahanbaku_vgenerik($field, $id) {
		return '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="40" />';
	}
	function updateBox_spesifikasi_soi_bahanbaku_vgenerik($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" value="'.$row['vgenerik'].'" class="input_rows1" size="40" />';
	}
	function insertBox_spesifikasi_soi_bahanbaku_iteampd_id($field, $id) {		
		return '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="25" />';
	}
	function updateBox_spesifikasi_soi_bahanbaku_iteampd_id($field, $id, $value, $rowData) {
		$sql = "SELECT t.vteam FROM plc2.plc2_upb u INNER JOIN plc2.plc2_upb_team t ON u.iteampd_id=t.iteam_id WHERE u.iupb_id='".$rowData['iupb_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		return '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" value="'.$row['vteam'].'" class="input_rows1" size="25" />';
	}
	
	function insertBox_spesifikasi_soi_bahanbaku_vnip_formulator($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=spesifikasi_soi_bahanbaku\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function updateBox_spesifikasi_soi_bahanbaku_vnip_formulator($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" value="'.$value.'" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" value="'.$row['cNip'].' - '.$row['vName'].'" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=spesifikasi_soi_bahanbaku\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}	
	
	function output(){
    	$this->index($this->input->get('action'));
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
					$del = "delete from plc2.".$table." where isoibb_id = {$lastId} and filename= '{$v}'";
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
			$sql = "SELECT filename from plc2.".$table." where isoibb_id=".$lastId;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['filename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT filename from plc2.".$table." where isoibb_id=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM plc2.".$table." where isoibb_id=".$lastId." and filename='".$row['filename']."'";			
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
}
