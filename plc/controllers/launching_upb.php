<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Launching_upb extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->load->library('biz_process');
        $this->load->library('lib_utilitas');
		$this->user = $this->auth->user();
		$this->dbset = $this->load->database('plc', true); 
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('Launching Produk');		
		$grid->setTable('plc2.plc2_upb_bahan_kemas');		
		// $grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('launching_upb');
		$grid->setJoinTable('plc2.plc2_upb','plc2_upb_bahan_kemas.iupb_id = plc2_upb.iupb_id','inner');
		$grid->setJoinTable('hrd.employee','plc2_upb.cnip = employee.cNip','left');
		$grid->addList('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','plc2_upb.cnip','employee.vName','plc2_upb.vnoreg','istatus_launching');
		$grid->setSortBy('vupb_nomor');
		$grid->setSortOrder('desc');
		$grid->addFields('vupb_nomor','ttanggal','cnip','vupb_nama','vgenerik','voriginator','tindikasi');
		$grid->addFields('ikategori_id','isediaan_id','itipe_id','ipatent','ibe','tunique');
		$grid->addFields('tpacking','iteambusdev_id','iteampd_id','iteamqa_id','iteamqc_id','iteammarketing_id','iregister');
		$grid->addFields('idevelop','vnoreg','tmeeting_date','tmemo','tapp_memo','tmemo_date','tterimabk_date','tterimabb_date','istatus_launching','vmemo_launching','fmemolaunchingfile');
		$grid->setLabel('voriginator', 'Originator');
		$grid->setLabel('indikasi', 'Indikasi');
		//$grid->setLabel('vKode_obat', 'Kode Obat');
		$grid->setLabel('plc2_upb.vKode_obat', 'Kode Obat');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setLabel('cnip','NIP');
		$grid->setLabel('plc2_upb.cnip','NIP');
		$grid->setLabel('employee.vName','Nama');
		$grid->setLabel('vnoreg','No. Registrasi');
		$grid->setLabel('plc2_upb.vnoreg','No. Registrasi');
		$grid->setLabel('ttanggal','Tanggal UPB');
		$grid->setLabel('tindikasi','Indikasi');
		$grid->setLabel('ikategori_id','Kategori Produk');
		$grid->setLabel('isediaan_id','Sediaan Produk');
		$grid->setLabel('itipe_id','Tipe Produk');
		$grid->setLabel('ipatent','Tipe hak paten');
		$grid->setLabel('ibe','Tipe BE');
		$grid->setLabel('tunique','Keunggulan Produk');
		$grid->setLabel('tpacking','Spesifikasi Kemasan');
		$grid->setLabel('iteambusdev_id','Team Busdev');
		$grid->setLabel('iteampd_id','PD');
		$grid->setLabel('iteamqa_id','QA');
		$grid->setLabel('iteamqc_id','QC');
		$grid->setLabel('iteammarketing_id','Marketing');
		$grid->setLabel('iregister','Registrasi untuk');
		$grid->setLabel('idevelop','Produksi oleh');
		$grid->setLabel('tmemo_date','Estimasi Tanggal Launching');
		//$grid->setLabel('filename','File Bahan Kemas');
		$grid->setLabel('tterimabb_date','Perkiraan Terima Bahan Baku');
		$grid->setLabel('tterimabk_date','Perkiraan Terima Bahan Kemas');
		$grid->setLabel('tmemo','No. Memo Launching');
		$grid->setLabel('tapp_memo','Tanggal Memo Direksi');
		$grid->setLabel('istatus_launching','Status Launching');
		$grid->setLabel('vmemo_launching','Reason of Cancel');
		$grid->setLabel('tmeeting_date',' Tanggal Meeting Launching');
		$grid->setLabel('fmemolaunchingfile','Memo Launching File');
		$grid->setLabel('cnip','NIP');
		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','plc2_upb.cnip','employee.vName','plc2_upb.vnoreg','istatus_launching');
		$grid->setRequired('tmeeting_date','tmemo_date','tterimabk_date','tterimabb_date','tmemo','fmemolaunchingfile');
		//join ke table bahan kemas
		
		$grid->setFormUpload(TRUE);
		/*$grid->changeFieldType('fmemolaunchingfile','upload');
		$grid->setUploadPath('fmemolaunchingfile', './files/plc/memo_launching/');
		$grid->setAllowedTypes('fmemolaunchingfile', 'gif|jpg|png|jpeg|pdf');
		$grid->setMaxSize('fmemolaunchingfile', '1000');		
		*/
		
		$grid->setQuery('plc2_upb.iappdireksi', 2);
		$grid->setQuery('plc2_upb.iappbusdev_registrasi', 2);
		$grid->setQuery('plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2_upb.ihold', 0);
		$grid->setQuery('plc2_upb.vnoreg != ""', NULL);
		//$grid->setQuery('iappbd', 2);
		
		if($this->auth->is_manager()){
    		$x=$this->auth->dept();
    		$manager=$x['manager'];
    		if(in_array('BD', $manager)){
				$teams = $this->auth->team();
				$mteams = '';
				$tteams = '';
				$i = 1;
				if(!empty($teams['manager'])) {
					$i = 1;
					foreach($teams['manager'] as $k => $m) {
						if($i==1) {
							$mteams .= $m;
						}
						else {
							$mteams .= ','.$m;
						}
						$i++;		
					}
				}
				if(!empty($teams['team'])) {
					$i = 1;
					foreach($teams['team'] as $k => $m) {
						if($i==1) {
							$tteams .= $m;
						}
						else {
							$tteams .= ','.$m;
						}
						$i++;			
					}
				}
				$tteams = $tteams == '' ? 0 : $tteams;
				$mteams = $mteams == '' ? 0 : $mteams;
				$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$tteams.','.$mteams.')', NULL);
			}
    		else{}
    	}
		
		$grid->changeFieldType('ibe','combobox','',array(''=>'--Select--',1=>'BE', 2=>'Non BE'));
		$grid->changeFieldType('ipatent','combobox','',array(''=>'--Select--',1=>'Indonesia', 2=>'International'));
		$grid->changeFieldType('iregister','combobox','',array(''=>'--Select--',3=>'PT. Novell Pharma', 5=>'PT. Etercorn Pharm'));
		$grid->changeFieldType('iDevelopBy','combobox','',array(''=>'--Select--',3=>'PT. Novell Pharma', 5=>'PT. Etercorn Pharm', 100=>'Toll'));
		$grid->changeFieldType('idevelop','combobox','',array(''=>'--Select--',3=>'PT. Novell Pharma', 5=>'PT. Etercorn Pharm', 100=>'Toll'));
		$grid->changeFieldType('istatus_launching','combobox','',array('0'=>'On Progress', 1=>'Batal', 2=>'Launching'));
		
		//$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
				$isUpload = $this->input->get('isUpload');
				$sql1 = array();
				
				if($isUpload) {
					$path1 = realpath("files/plc/memo_launching");
					
					if (!mkdir($path1."/".$this->input->get('lastId'), 0777, true)) {
					    die('Failed upload, try again!');
					}
					
					$file_keterangan = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'fileketerangan1') {
							foreach($value as $k=>$v) {
								$file_keterangan1[$k] = $v;
							}
						}
					}
				
					//upload form 2
					$i = 0;
					foreach ($_FILES['fileupload1']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {				
							$tmp_name1 = $_FILES['fileupload1']["tmp_name"][$key];
							$name1 = $_FILES['fileupload1']["name"][$key];
							$data1['filename'] = $name1;
							$data1['id']=$this->input->get('lastId');
							$data1['nip']=$this->user->gNIP;
							//$data['iupb_id'] = $insertId;
							//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							$data1['dInsertDate'] = date('Y-m-d H:i:s');
							if(move_uploaded_file($tmp_name1, $path1."/".$this->input->get('lastId')."/".$name1)) {	
								$sql1[] = "INSERT INTO plc2_upb_file_memo_launching(iupb_id, filename, dInsertDate, vketerangan,cInsert) 
										VALUES ('".$data1['id']."', '".$data1['filename']."','".$data1['dInsertDate']."','".$file_keterangan1[$i]."','".$data1['nip']."')";
								$i++;
							
							}
							else{
							echo "Upload ke folder gagal";	
							}
						}
					}			
					foreach($sql1 as $q1) {
						try {
							$this->dbset->query($q1);
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
				//print_r($this->input->post());
				$isUpload = $this->input->get('isUpload');
				$sql1 = array();
				$file_name1= "";
				
				$fileId = array();
				
				$path1 = realpath("files/plc/memo_launching");
				
				if (!file_exists( $path1."/".$this->input->post('launching_upb_ibk_id') )) { 
					mkdir($path1."/".$this->input->post('launching_upb_ibk_id'), 0777, true);					    
				}
									
				$file_keterangan1 = array();
				//print_r($_POST);
				foreach($_POST as $key=>$value) {
					if ($key == 'fileketerangan1') {
						foreach($value as $y=>$u) {
							$file_keterangan1[$y] = $u;
						}
					}
					if ($key == 'namafile1') {
						foreach($value as $k=>$v) {
							$file_name1[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid1') {
						foreach($value as $k=>$v) {
							$fileId1[$k] = $v;
						}
					}
				}

				$last_index1 = 0;
				if($isUpload) {			
					$a = $last_index1;	
					//upload form 2
					if (isset($_FILES['fileupload1'])) {
						
						$this->hapusfile($path1, $file_name1, 'plc2_upb_file_memo_launching',$this->input->post('launching_upb_ibk_id'), 'iupb_id');
						foreach ($_FILES['fileupload1']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name1 = $_FILES['fileupload1']["tmp_name"][$key];
								$name1 = $_FILES['fileupload1']["name"][$key];
								$data1['filename'] = $name1;
								$data1['id']=$this->input->post('launching_upb_ibk_id');
								$data1['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data1['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name1, $path1."/".$this->input->post('launching_upb_ibk_id')."/".$name1)) 
				 				{
									$sql1[] = "INSERT INTO plc2_upb_file_memo_launching(iupb_id, filename, dInsertDate, vketerangan,cInsert) 
										VALUES ('".$data1['id']."', '".$data1['filename']."','".$data1['dInsertDate']."','".$file_keterangan1[$a]."','".$data1['nip']."')";
									$a++;																			
								//print_r($sql1);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sql1 as $q1) {
						try {
							$this->dbset->query($q1);
						}catch(Exception $e) {
							die($e);
						}
					}
					
					
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->post('launching_upb_ibk_id');					
					echo json_encode($r);
					exit();
				}  else {
					if (is_array($file_name1)) {									
						$this->hapusfile($path1, $file_name1, 'plc2_upb_file_memo_launching',$this->input->post('launching_upb_ibk_id'),'iupb_id');
					}
					echo $grid->updated_form();
				}
				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'download':
				$this->download($this->input->get('file'));
			break;
			case 'download1':
				$this->download1($this->input->get('file'));
			break;
			case 'approve':
				echo $this->approve_view();
				break;
			case 'approve_process':
				echo $this->approve_process();
				break;
			
			default:
				$grid->render_grid();
				break;
		}
    }

	function manipulate_update_button($buttons, $rowData) {
    if ($this->input->get('action') == 'view') {unset($buttons['update']);}
	else{
		unset($buttons['update_back']);
    	unset($buttons['update']);
		
    	$user = $this->auth->user();
    
    	if($this->auth->is_manager()){
    		$x=$this->auth->dept();
    		$manager=$x['manager'];
    		if(in_array('BD', $manager)){$type='BD';}
    		elseif(in_array('DR', $manager)){$type='DR';}
    		else{$type='';}
			
    	}
		
		else{
			$x=$this->auth->dept();
    		$team=$x['team'];
			if(in_array('BD', $team)){$type='BD';}
			elseif(in_array('DR', $team)){$type='DR';}
			else{$type='';}
		}
		//echo $type;
		// cek status upb, klao upb 
			$ibk_id=$rowData['ibk_id'];
			//get upb_id
			$qupb="select * from plc2.plc2_upb_bahan_kemas bk where bk.ibk_id=$ibk_id";
			$rupb = $this->db_plc0->query($qupb)->row_array();
			//print_r($rupb);
			
			$iupb_id=$rupb['iupb_id'];
			//echo "<pre>";print_r($rowData);echo "</pre>"; exit();
			$js = $this->load->view('launching_upb_js');
			$x=$this->auth->my_teams();
			//print_r($x);
			$arrhak=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
		//print_r($arrhak);
			if(empty($arrhak)){
				$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
				if(empty($getbp)){}
				else{
					if($this->auth->is_manager()){ //jika manager PD
						if(($type=='BD')){
							$update = '<button onclick="javascript:update_btn_back(\'launching_upb\', \''.base_url().'processor/plc/launching/upb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							//$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/launching/upb?action=approve&iupb_id='.$iupb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Approve</button>';
							//$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stabilita/pilot?action=reject&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ista_id='.$rowData['ista_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Reject</button>';
								
							$buttons['update'] = $update.$js;
						}
						// if(($type=='DR')&&($rupb['iappbd_launch']==2)){
							// $approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/launching/upb?action=approve&iupb_id='.$iupb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Approve</button>';
							// //$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stabilita/pilot?action=reject&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ista_id='.$rowData['ista_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Reject</button>';
								
							// $buttons['update'] = $approve;
						// }
						else{}
					}
					else{
						if(($type=='BD')){
							$update = '<button onclick="javascript:update_btn_back(\'launching_upb\', \''.base_url().'processor/plc/launching/upb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$buttons['update'] = $update.$js;
						}
					}
				}
			}else{
				if($this->auth->is_manager()){ //jika manager PD
						if(($type=='BD')){
							$update = '<button onclick="javascript:update_btn_back(\'launching_upb\', \''.base_url().'processor/plc/launching/upb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							//$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/launching/upb?action=approve&iupb_id='.$iupb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Approve</button>';
							//$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stabilita/pilot?action=reject&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ista_id='.$rowData['ista_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Reject</button>';
								
							$buttons['update'] = $update.$js;
						}
						// if(($type=='DR')&&($rupb['iappbd_launch']==2)){
							// $approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/launching/upb?action=approve&iupb_id='.$iupb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Approve</button>';
							// //$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stabilita/pilot?action=reject&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ista_id='.$rowData['ista_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Reject</button>';
								
							// $buttons['update'] = $approve;
						// }
						else{}
					}
					else{
						if(($type=='BD')){
							$update = '<button onclick="javascript:update_btn_back(\'launching_upb\', \''.base_url().'processor/plc/launching/upb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$buttons['update'] = $update.$js;
						}
					}
			}
   
    	return $buttons;
    }
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
								var url = "'.base_url().'processor/plc/launching/upb";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_launching_upb").html(data);
									});
					
								}
									reload_grid("grid_launching_upb");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_launching_upb_approve" action="'.base_url().'processor/plc/launching/upb?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="ibk_id" value="'.$this->input->get('ibk_id').'" />
    			<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_launching_upb_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
	 	$ibk_id=$post['ibk_id'];
		$this->db_plc0->where('ibk_id', $post['ibk_id']);
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$iapprove = $post['type'] == 'BD' ? 'iappbd_launch' : 'iappdr_launch';
		$vapprove = $post['type'] == 'BD' ? 'vnip_appbd_launch' : 'vnip_appdr_launch';
		$tapprove = $post['type'] == 'BD' ? 'tappbd_launch' : 'tappdr_launch';
		$this->db_plc0->update('plc2.plc2_upb_bahan_kemas', array($iapprove=>2,$vapprove=>$nip,$tapprove=>$skg));
    
    	
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
   	
		$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$post['modul_id']); // 1 approval
		$bizsup=$getbp['idplc2_biz_process_sub'];
		
		$ifor_id=$this->input->post('ifor_id');
		$ista_id=$this->input->post('ista_id');
		// $qcek="select count(f.ifor_id) as jum from plc2.plc2_upb_stabilita f where f.ifor_id=$ifor_id";
		// $rcek = $this->db_plc0->query($qcek)->row_array();
		// //jika sudah pernah ada stress test utk ups & spek_fg tsb maka
		
		$hacek=$this->biz_process->cek_last_status($post['iupb_id'],$bizsup,1); // status 1 => app
		if($hacek==1){ // jika sudah pernah ada data maka update saja
			//insert log
				$this->biz_process->insert_log($post['iupb_id'], $bizsup, 1); // status 1 => app
			//update last log
				$this->biz_process->update_last_log($post['iupb_id'], $bizsup, 1);
		}
		elseif($hacek==0){
			//insert log
				$this->biz_process->insert_log($post['iupb_id'], $bizsup, 1); // status 1 => app
			//insert last log
				$this->biz_process->insert_last_log($post['iupb_id'], $bizsup, 1);
		}
		$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
                            from plc2.plc2_upb u where u.iupb_id='".$post['upb_id']."'";
        $rupb = $this->db_plc0->query($qupb)->row_array();

        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id 
                from plc2.plc2_upb u where u.iupb_id='".$post['upb_id']."'";
        $rsql = $this->db_plc0->query($qsql)->row_array();

        //$query = $this->dbset->query($rsql);

        $pd = $rsql['iteampd_id'];
        $bd = $rsql['iteambusdev_id'];
        $qa = $rsql['iteamqa_id'];
        $qc = $rsql['iteamqc_id'];

        $team = $pd. ','.$bd. ','.$qa. ','.$qc ;
        
        $toEmail2='';
        
        If($post['type']=='BD'){
            $head = "Diberitahukan bahwa telah ada approval oleh Busdev pada proses Launching Product(aplikasi PLC) dengan rincian sebagai berikut :<br><br>";
            $desc = "<td><b>Proses Selanjutnya</b></td><td> : </td><td>Launching Product - Approval oleh Direksi</td>";
            $toEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );
            $toEmail2 = $this->lib_utilitas->get_email_leader( $bd ); 
        }elseif($post['type']=='DR'){
            $toEmail = $this->lib_utilitas->get_email_leader($team);
            $toEmail2 = $this->lib_utilitas->get_email_by_nip( "N00923" );
            $head = "Diberitahukan bahwa telah ada approval oleh Direksi pada proses Launching Product(aplikasi PLC) dengan rincian sebagai berikut :<br><br>";
            $desc = "";
        }        
        
        $to = $cc = '';
        if(is_array($arrEmail)) {
                $count = count($arrEmail);
                $to = $arrEmail[0];
                for($i=1;$i<$count;$i++) {
                        $cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
                }
        }			

        $to = $toEmail;
        $cc = $toEmail2;
        
		$subject="Proses Launching Selesai : UPB ".$rupb['vupb_nomor']." ( ".$rupb['vupb_nama']." )";
		$content=$head."<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
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
                          ".$desc."
                    </tr>                  
				</table>
			</div>
			<br/> 
			Demikian. Terimakasih.<br><br><br>
			Post Master";
            
        echo  $to;
        echo '</br>cc:' .$cc; 
        echo '</br>'.$subject ;     
        echo '</br>'.$content ;    
        exit ; 
		//$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		$data['status']  = true;
    	$data['last_id'] = $ibk_id;
    	return json_encode($data);
    }
  
	// function listBox_launching_upb_iappbd_launch($value) {
    	// if($value==0){$vstatus='Waiting for approval';}
    	// elseif($value==1){$vstatus='Rejected';}
    	// elseif($value==2){$vstatus='Approved';}
    	// return $vstatus;
    // }
	// function listBox_launching_upb_iappdr_launch($value) {
    	// if($value==0){$vstatus='Waiting for approval';}
    	// elseif($value==1){$vstatus='Rejected';}
    	// elseif($value==2){$vstatus='Approved';}
    	// return $vstatus;
    // }
	// function updateBox_launching_upb_vKode_obat($name, $id, $value, $rowData) {
		// $row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		// $val=$row['vKode_obat'];
		// return '<input type="text" class="input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'" size="7" onkeypress="return isNumberKey(event)">';
	// }
	//Keterangan approval 
	// function insertBox_launching_upb_vnip_appbd_launch($field, $id) {
		// return '-';
	// }
	// function updateBox_launching_upb_vnip_appbd_launch($field, $id, $value, $rowData) {
		// //print_r($rowData);
		// if(($rowData['iappbd_launch'] <>0)){
			// $row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_appbd_launch']))->row_array();
			// if($rowData['iappbd_launch']==2){$st="Approved";}elseif($rowData['iappbd_launch']==1){$st="Rejected";
			// } 
			// $ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_appbd_launch'].' )'.' pada '.$rowData['tappbd_launch'];
			// // if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		// }
		// else{
			// $ret='Waiting for Approval';
		// }
		
		// return $ret;
	// }
	// function insertBox_launching_upb_vnip_appdr_launch($field, $id) {
		// return '-';
	// }
	// function updateBox_launching_upb_vnip_appdr_launch($field, $id, $value, $rowData) {
		// //print_r($rowData);
		// if(($rowData['iappdr_launch'] <>0)){
			// $row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_appdr_launch']))->row_array();
			// if($rowData['iappdr_launch']==2){$st="Approved";}elseif($rowData['iappdr_launch']==1){$st="Rejected";
			// } 
			// $ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_appdr_launch'].' )'.' pada '.$rowData['tappdr_launch'];
			// // if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		// }
		// else{
			// $ret='Waiting for Approval';
		// }
		
		// return $ret;
	// }
	// public function listBox_Action($row, $actions) {
    	// // jika formula sudah di app tidak bisa di edit
		// if($row->iappdr_launch<>0){
				// unset($actions['edit']);
				// unset($actions['delete']);
		// }
		// return $actions;
    // }
	// function updateBox_launching_upb_filename($field, $id, $value, $rowData) {
		// //$input = '<input type="file" name="'.$id.'" id="'.$id.'" class="" size="50" />';
		// /*if($value != '') {
			// if (file_exists('./files/plc/bahan_kemas/'.$value)) {
				// $link = base_url().'processor/plc/launching/upb?action=download&file='.$value;
				// $linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			// }
			// else {
				// $linknya = 'File sudah tidak ada!';
			// }
			// return 'File name : '.$value.' ['.$linknya.']<br />';
		// }
		// else {
			// return 'No File<br />';
		// }*/
		// $data['mydept'] = $this->auth->my_depts(TRUE);
		// $idfor = $rowData['ibk_id'];
		// $data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_bahan_kemas', array('ibk_id'=>$idfor))->result_array();
		// return $this->load->view('launching_upb_file',$data,TRUE);		
	// }

	
	function updateBox_launching_upb_istatus_launching($field, $id, $value, $rowData) {
		$o='<select id="launching_upb_istatus_launching" class="combobox" name="launching_upb_istatus_launching">
				<option value="">--Select--</option>
				<option value="1">Batal</option>
				<option value="2">Launching</option>
			</select>';
		$o .= '<script type="text/javascript">
				$("#launching_upb_istatus_launching").change(function(){
					if ($(this).val()==2 ) {
						$("#launching_upb_vmemo_launching").removeClass("required");
						
					}else{
						$("#launching_upb_vmemo_launching").addClass("required");
						
					}
				});

	
				</script>';
		return $o;
		
	}
	function updateBox_launching_upb_fmemolaunchingfile($field, $id, $value, $rowData) {
		/*$input = '<input type="file" name="'.$id.'" id="'.$id.'" class="" size="50" />';
		if($value != '') {
			if (file_exists('./files/plc/memo_launching/'.$value)) {
				$link = base_url().'processor/plc/launching/upb?action=download&file='.$value;
				$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			}
			else {
				$linknya = 'File sudah tidak ada!';
			}
			return 'File name : '.$value.' ['.$linknya.']<br />'.$input;
		}
		else {
			return 'No File<br />'.$input;
		}*/
		$data['mydept'] = $this->auth->my_depts(TRUE);
		$idfor = $rowData['ibk_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_memo_launching', array('iupb_id'=>$idfor))->result_array();
		return $this->load->view('launching_upb_file1',$data,TRUE);		
	}

	function updateBox_launching_upb_tmemo($name, $id, $value,$rowData) {
		return '<input type class="input_rows1 required" name="'.$name.'" id="'.$id.'" value="'.$value.'">';
	}
	function updateBox_launching_upb_tmemo_date($name, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		return '<input type="text" class="input_tgl datepicker input_rows1 required" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
	}
	function updateBox_launching_upb_tmeeting_date($name, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		return '<input type="text" class="input_tgl datepicker input_rows1 required" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
	}
	 function updateBox_launching_upb_tterimabb_date($name, $id, $value) {
		 // $this->load->helper('to_mysql');
		 // $val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		 return '<input type="text" class="input_rows1 required" name="'.$name.'" value="'.$value.'" id="'.$id.'">';
	}
	function updateBox_launching_upb_tterimabk_date($name, $id, $value, $rowData) {
		// $this->load->helper('to_mysql');
		// $val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		return '<input type="text" class="input_rows1 required" name="'.$name.'" value="'.$value.'" id="'.$id.'">';
	}
	
	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/bahan_kemas/'.$id.'/'.$name);		
		force_download($name, $path);
	}

	function download1($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/memo_launching/'.$id.'/'.$name);		
		force_download($name, $path);
	}


	function updateBox_launching_upb_vupb_nomor($name, $id, $value, $rowData) {
		//print_r($rowData);
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return $row['vupb_nomor'];
	}
	function updateBox_launching_upb_ttanggal($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$this->load->helper('to_mysql');
		return to_mysql($row['ttanggal'], TRUE);
	}
	function updateBox_launching_upb_cnip($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$this->load->model('user_model');
		$u = $this->user_model->get_user_info($row['cnip']);
		return $row['cnip'].' | '.$u['vName']. ' | '.$u['divisi'];
	}
	function updateBox_launching_upb_vupb_nama($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return $row['vupb_nama'];
	}
	function updateBox_launching_upb_vgenerik($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return $row['vgenerik'];
	}
	function updateBox_launching_upb_voriginator($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return $row['voriginator'];
	}
	function updateBox_launching_upb_tindikasi($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return $row['tindikasi'];
	}
	function updateBox_launching_upb_ikategori_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$mydept=$this->auth->tipe();
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('DR',$manager)){
				$type='BD';
				if($row['ikategori_id']== 0){
				
					return "-";
				}else{
					
					$rowk = $this->db_plc0->get_where('hrd.mnf_kategori', array('ikategori_id'=>$row['ikategori_id']))->row_array();
					return $rowk['vkategori'];
				}
			}
			else{$type='';
				
				$rowk = $this->db_plc0->get_where('hrd.mnf_kategori', array('ikategori_id'=>$row['ikategori_id']))->row_array();
				return $rowk['vkategori'];
			}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('DR',$team)){
				$type='DR';
				if($row['ikategori_id']== 0){
				
					return "-";
				}else{
					
					$rowk = $this->db_plc0->get_where('hrd.mnf_kategori', array('ikategori_id'=>$row['ikategori_id']))->row_array();
					return $rowk['vkategori'];
				}
			}
			else{$type='';
				
				$rowk = $this->db_plc0->get_where('hrd.mnf_kategori', array('ikategori_id'=>$row['ikategori_id']))->row_array();
				return $rowk['vkategori'];
			}
		}
		
	}
	function updateBox_launching_upb_isediaan_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$rowk = $this->db_plc0->get_where('hrd.mnf_sediaan', array('isediaan_id'=>$row['isediaan_id']))->row_array();
		if(sizeOf($rowk) > 0) {		
			return $rowk['vsediaan'];
		} else { return '';}
	}
	function updateBox_launching_upb_itipe_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$mydept=$this->auth->tipe();
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('DR',$manager)){
				$type='BD';
				if($row['itipe_id']== 0){
				
					return "-";
				}else{
					$rowk = $this->db_plc0->get_where('plc2.plc2_biz_process_type', array('idplc2_biz_process_type'=>$row['itipe_id']))->row_array();
					return $rowk['vName'];
				}
			}
			else{$type='';
				$rowk = $this->db_plc0->get_where('plc2.plc2_biz_process_type', array('idplc2_biz_process_type'=>$row['itipe_id']))->row_array();
				return $rowk['vName'];
			}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('DR',$team)){
				$type='DR';
				if($row['itipe_id']== 0){
				
					return "-";
				}else{
					$rowk = $this->db_plc0->get_where('plc2.plc2_biz_process_type', array('idplc2_biz_process_type'=>$row['itipe_id']))->row_array();
					return $rowk['vName'];
				}
			}
			else{$type='';
				$rowk = $this->db_plc0->get_where('plc2.plc2_biz_process_type', array('idplc2_biz_process_type'=>$row['itipe_id']))->row_array();
				return $rowk['vName'];
			}
		}
		
	}
	function updateBox_launching_upb_ipatent($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$mydept=$this->auth->tipe();
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('DR',$manager)){
				$type='BD';
				if($row['ipatent']== 0){
				
					return "-";
				}else{
					$ipatent=$row['ipatent'];
					$array = array(1=>'Indonesia', 2=>'International');
					return $array[$ipatent];
				}
			}
			else{$type='';
				$ipatent=$row['ipatent'];
				$array = array(1=>'Indonesia', 2=>'International');
				return $array[$ipatent];
			}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('DR',$team)){
				$type='DR';
				if($row['ipatent']== 0){
				
					return "-";
				}else{
					$ipatent=$row['ipatent'];
					$array = array(1=>'Indonesia', 2=>'International');
					return $array[$ipatent];
				}
			}
			else{$type='';
				$ipatent=$row['ipatent'];
				$array = array(1=>'Indonesia', 2=>'International');
				return $array[$ipatent];
			}
		}
		
		
	}
	function updateBox_launching_upb_ibe($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$mydept=$this->auth->tipe();
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('DR',$manager)){
				$type='BD';
				if($row['ibe']== 0){
				
					return "-";
				}else{
					$ibe=$row['ibe'];
					$array = array(1=>'BE', 2=>'Non BE');
					return $array[$ibe];
				}
			}
			else{$type='';
				$ibe=$row['ibe'];
				$array = array(1=>'BE', 2=>'Non BE');
				return $array[$ibe];
			}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('DR',$team)){
				$type='DR';
				if($row['ibe']== 0){
				
					return "-";
				}else{
					$ibe=$row['ibe'];
					$array = array(1=>'BE', 2=>'Non BE');
					return $array[$ibe];
				}
			}
			else{$type='';
				$ibe=$row['ibe'];
				$array = array(1=>'BE', 2=>'Non BE');
				return $array[$ibe];
			}
		}
		
		
	}
	function updateBox_launching_upb_vhpp_target($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return $row['vhpp_target'];
	}
	function updateBox_launching_upb_tunique($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return $row['tunique'];
	}
	function updateBox_launching_upb_tpacking($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return $row['tpacking'];
	}
	function updateBox_launching_upb_iteambusdev_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$rowk = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$row['iteambusdev_id']))->row_array();
		return $rowk['vteam'];
	}
	function updateBox_launching_upb_iteampd_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$rowk = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$row['iteampd_id']))->row_array();
		return $rowk['vteam'];
	}
	function updateBox_launching_upb_iteamqa_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$rowk = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$row['iteamqa_id']))->row_array();
		return $rowk['vteam'];
	}
	function updateBox_launching_upb_iteamqc_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$rowk = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$row['iteamqc_id']))->row_array();
		return $rowk['vteam'];
	}
	function updateBox_launching_upb_iteammarketing_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$mydept=$this->auth->tipe();
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('DR',$manager)){
				$type='BD';
				if($row['iteammarketing_id']== 0){
				
					return "-";
				}else{
					$rowk = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$row['iteammarketing_id']))->row_array();
					return $rowk['vteam'];
				}
			}
			else{$type='';
				$rowk = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$row['iteammarketing_id']))->row_array();
				return $rowk['vteam'];
			}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('DR',$team)){
				$type='DR';
				if($row['iteammarketing_id']== 0){
				
					return "-";
				}else{
					$rowk = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$row['iteammarketing_id']))->row_array();
					return $rowk['vteam'];
				}
			}
			else{$type='';
				$rowk = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$row['iteammarketing_id']))->row_array();
				return $rowk['vteam'];
			}
		}
		
		
	}
	function updateBox_launching_upb_iregister($name, $id, $value, $rowData) {
		$rowk = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$ireg=$rowk['iregister'];
		$array = array(3=>'PT. Novell Pharma', 5=>'PT. Etercorn Pharm');
		return $array[$ireg];
	}
	function updateBox_launching_upb_idevelop($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$mydept=$this->auth->tipe();
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('DR',$manager)){
				$type='BD';
				if($row['idevelop']== 0){
				
					return "-";
				}else{
					$array = array(3=>'PT. Novell Pharma', 5=>'PT. Etercorn Pharm', 100=>'Toll');
					$idev=$row['idevelop'];
					return $array[$idev];
				}
			}
			else{$type='';
				$array = array(3=>'PT. Novell Pharma', 5=>'PT. Etercorn Pharm', 100=>'Toll');
				$idev=$row['idevelop'];
				return $array[$idev];
			}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('DR',$team)){
				$type='DR';
				if($row['idevelop']== 0){
				
					return "-";
				}else{
					$array = array(3=>'PT. Novell Pharma', 5=>'PT. Etercorn Pharm', 100=>'Toll');
					$idev=$row['idevelop'];
					return $array[$idev];
				}
			}
			else{$type='';
				$array = array(3=>'PT. Novell Pharma', 5=>'PT. Etercorn Pharm', 100=>'Toll');
				$idev=$row['idevelop'];
				return $array[$idev];
			}
		}
		
	}
	function updateBox_launching_upb_vnoreg($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return $row['vnoreg'];
	}	

	function before_update_processor($row, $postData) {
		$user = $this->auth->user();
		$this->load->helper('to_mysql');
		$postData['tmemo_date'] = to_mysql($postData['tmemo_date']);
		$postData['tmeeting_date'] = to_mysql($postData['tmeeting_date']);
		// $postData['tterimabb_date'] = to_mysql($postData['tterimabb_date']);
		// $postData['tterimabk_date'] = to_mysql($postData['tterimabk_date']);
		return $postData;
	}
	function after_update_processor($row, $updateId, $postData) {
		
		$getbp=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // activity 3 input data
		$bizsup=$getbp['idplc2_biz_process_sub'];
				
		//echo  $this->auth->my_teams();
		//getiupb_id
		$sel="select * from plc2.plc2_upb_bahan_kemas f where f.ibk_id=$updateId";
		$rowb = $this->db_plc0->query($sel)->row_array();
		
		$hacek=$this->biz_process->cek_last_status($rowb['iupb_id'],$bizsup,7); // status 7 => submit
		if($hacek==1){ // jika sudah pernah ada data maka update saja
			//insert log
				$this->biz_process->insert_log($rowb['iupb_id'], $bizsup, 7); // status 7 => submit
			//update last log
				$this->biz_process->update_last_log($rowb['iupb_id'], $bizsup, 7);
		}
		elseif($hacek==0){
			//insert log
				$this->biz_process->insert_log($rowb['iupb_id'], $bizsup, 7); // status 7 => submit
			//insert last log
				$this->biz_process->insert_last_log($rowb['iupb_id'], $bizsup, 7);
		}
		// $kodeobat=$postData['vKode_obat'];
		// $iupb=$rowb['iupb_id'];
		// $SQL = "UPDATE plc2.plc2_upb SET vKode_obat = '".$kodeobat."' where iupb_id = '".$iupb."'"; 
		// $this->dbset->query($SQL);

		 $istatus_launching=$postData['istatus_launching'];
		 $vmemo_launching=$postData['vmemo_launching'];
		 $iupb=$rowb['iupb_id'];
		 //$SQL = "UPDATE plc2.plc2_upb SET istatus_launching = '".$istatus_launching."' where iupb_id = '".$iupb."'"; 
		 $SQL =	'update plc2.plc2_upb  set istatus_launching="'.$istatus_launching.'", vmemo_launching="'.$vmemo_launching.'" where iupb_id="'.$iupb.'"';
	 	 $this->dbset->query($SQL);
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
	
	function hapusfile($path, $file_name, $table, $lastId, $keyId){
		//echo 'aa '.$lastId;
		$path = $path."/".$lastId;
		$path = str_replace("\\", "/", $path);
		
		if (is_array($file_name)) {
						
			$list_dir  = $this->readDirektory($path);
			$list_sql  = $this->readSQL($table, $lastId,'',$keyId);
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
					$del = "delete from plc2.".$table." where  ".$keyId." = {$lastId} and filename= '{$v}'";
					mysql_query($del);	
				}
				
			}
			
		} else {
			$this->readDirektory($path, 1);
			$this->readSQL($table, $lastId, 1, $keyId);
		}
	} 
	
	function readSQL($table, $lastId, $empty="", $keyId) {
		$list_file = array();
		if (empty($empty)) {
			$sql = "SELECT filename from plc2.".$table." where ".$keyId."=".$lastId;
			//echo $sql;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['filename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT filename from plc2.".$table." where ".$keyId."=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM plc2.".$table." where ".$keyId."=".$lastId." and filename='".$row['filename']."'";			
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