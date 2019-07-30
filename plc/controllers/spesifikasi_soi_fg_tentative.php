<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Spesifikasi_soi_fg_tentative extends MX_Controller {
		var $url;
		var $dbset;
	function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->user = $this->auth_localnon->user();
        $this->load->library('lib_utilitas');
		$this->load->library('biz_process');
		$this->load->library('lib_flow');
		$this->dbset =  $this->load->database('plc0',false, true);
		$this->url = 'spesifikasi_soi_fg_tentative';
    }
    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle('SOI Finish Good');		
		$grid->setTable('plc2.plc2_upb_soi_fg');		
		$grid->setUrl('spesifikasi_soi_fg_tentative');
		$grid->addList('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','vkode_surat','itype','isubmit','iapppd','iappqa');
		$grid->setSortBy('isoi_id');
		$grid->setSortOrder('DESC');
		$grid->setQuery('plc2.plc2_upb_soi_fg.ldeleted', 0);
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setAlign('vrevisi', 'center');
		$grid->setAlign('itype', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '100');
		$grid->setWidth('plc2_upb.iteampd_id', '150');
		$grid->setWidth('plc2_upb.vupb_nama', '250');
		$grid->setWidth('plc2_upb.vgenerik', '250');
		$grid->setWidth('itype', '75');
		$grid->setFormWidth('vrevisi',5);
		$grid->setFormWidth('vupb_nama',40);
		$grid->setFormWidth('vgenerik',40);
		$grid->setFormWidth('iteampd_id',25);
		$grid->setFormWidth('vkode_surat',20);
		/*$grid->addFields('iupb_id','vupb_nama','vgenerik','iteampd_id','vkode_surat','dmulai_draft','dselesai_draft','filename','vnip_formulator','vapppd','vnip_qc','vnip_qa');*/
		$grid->addFields('iupb_id','vupb_nama','vgenerik','iteampd_id','vkode_surat','dmulai_draft','dselesai_draft','filename','vnip_formulator','vapppd','vnip_qa');
		$grid->setRequired('iupb_id','vkode_surat','filename','dmulai_draft','dselesai_draft','fmikro','vnip_formulator');
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
		$grid->setLabel('vkode_surat', 'No. Draft');
		$grid->setLabel('dmulai_draft', 'Mulai Pembuatan Draft');
		$grid->setLabel('dselesai_draft', 'Selesai Pembuatan Draft');
		$grid->setLabel('filename', 'Nama File');
		$grid->setLabel('itype', 'Status');
		$grid->setLabel('isubmit', 'Status Submit');
		$grid->setLabel('vnip_formulator', 'Penyusun');
		// $grid->setLabel('iappqc', 'QC Approval');
		// $grid->setLabel('iappqa', 'QA Approval');
		$grid->setLabel('iappqc', 'QC Approval');
		$grid->setLabel('iappqa', 'QA Approval');
		$grid->setLabel('iapppd', 'PD Approval');
		// $grid->setLabel('iappqc_f', 'QC App Final');
		// $grid->setLabel('iappqa_f', 'QA App Final');
		$grid->setLabel('vnip_qc', 'QC Approval');
		$grid->setLabel('vnip_qa', 'QA Approval');
		$grid->setLabel('vapppd', 'PD Approval');
		// $grid->setLabel('vnip_qc_f', 'QC App Final');
		// $grid->setLabel('vnip_qa_f', 'QA App Final');
		
		/*Start Buat Upload
		//Set Form Supaya ectype=multipart
		*/
		$grid->setFormUpload(TRUE);
		/*
		//Pilih yg mau jadi file upload
		$grid->changeFieldType('filename','upload');
		//Tentuin Pathnya
		$grid->setUploadPath('filename', './files/plc/spek_soi_fg/');
		//Tentuin filetype nya
		$grid->setAllowedTypes('filename', 'gif|jpg|png|jpeg|pdf'); // * For Semua
		//Tentuin Max filesizenya
		$grid->setMaxSize('filename', '1000');
		/*End Buat Upload*/
		
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb_soi_fg.iupb_id = plc2.plc2_upb.iupb_id', 'INNER');
		$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));
		$grid->changeFieldType('isubmit','combobox','',array(0=>'Need to Submit',1=>'Submited'));
		//$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner');
		//$grid->changeFieldType('itype','combobox','',array(''=>'--Select--',0=>'Tentative', 1=>'Final'));
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('QC', $manager)){
				$type='QC';
				$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			elseif(in_array('QA', $manager)){
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
			if(in_array('QC', $team)){
				$type='QC';
				$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			elseif(in_array('QA', $team)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			elseif(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','vkode_surat','itype');
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/
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
					$path = realpath("files/plc/spek_soi_fg/");
					if (!mkdir($path."/".$this->input->get('lastId'), 0777, true)) {
					    die('Failed upload, try again!');
					}
					$file_keterangan = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'fileketerangan_soifg') {
							foreach($value as $k=>$v) {
								$file_keterangan[$k] = $v;
							}
						}
					}
					
					$i = 0;
					foreach ($_FILES['fileupload_soifg']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {				
							$tmp_name = $_FILES['fileupload_soifg']["tmp_name"][$key];
							$name = $_FILES['fileupload_soifg']["name"][$key];
							$data['filename'] = $name;
							$data['id']=$this->input->get('lastId');
							//$data['iupb_id'] = $insertId;
							//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							$data['dInsertDate'] = date('Y-m-d H:i:s');
							if(move_uploaded_file($tmp_name, $path."/".$this->input->get('lastId')."/".$name)) {	
								$sql[] = "INSERT INTO plc2_upb_file_soi_fg (isoi_id, filename, dInsertDate, vKeterangan, cInsert) 
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
							$this->dbset->query($q);
						}catch(Exception $e) {
							die($e);
						}
					}
					$r['message']="Data Berhasil Disimpan";
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
				
				$path = realpath("files/plc/spek_soi_fg/");
				
				if (!file_exists( $path."/".$this->input->post('spesifikasi_soi_fg_tentative_isoi_id') )) {
					mkdir($path."/".$this->input->post('spesifikasi_soi_fg_tentative_isoi_id'), 0777, true);						 
				}
									
				$file_keterangan = array();
				$idfile='';
				foreach($_POST as $key=>$value) {
											
					if ($key == 'fileketerangan_soifg') {
						foreach($value as $y=>$u) {
							$file_keterangan[$y] = $u;
						}
					}
					
					//
					if ($key == 'namafile_soifg') {
						foreach($value as $k=>$v) {
							$file_name[$k] = $v;
						}
					}
		
					//
					if ($key == 'fileid_soifg') {
						$i=0;
						foreach($value as $k=>$v) {
							$fileId[$k] = $v;
							if($i==0){
								$idfile .= "'".$v."'";
							}else{
								$idfile .= ",'".$v."'";
							}
							$i++;
						}
					}
				}

				$del = "delete from plc2.plc2_upb_file_soi_fg where id not in(".$idfile.") and isoi_id='".$this->input->post('spesifikasi_soi_fg_tentative_isoi_id')."'";
					//print_r($_POST);exit();
					//echo $del; exit();
					mysql_query($del);
										

				//$x=0;				
				/*foreach($fileId as $k=>$v) {
					$SQL = "UPDATE plc2_upb_file_soi_fg SET vKeterangan = '".$file_keterangan[$k]."' where id = '".$v."'"; 
					$this->dbset->query($SQL);
					$x=$k;
				}*/
				//$last_index = $x+1;
				$last_index = 0;	
						
   				if($isUpload) {
					$j = $last_index;						
								
					if (isset($_FILES['fileupload_soifg'])) {
						//$this->hapusfile($path, $file_name, 'plc2_upb_file_soi_fg', $this->input->post('spesifikasi_soi_fg_tentative_isoi_id'));
						foreach ($_FILES['fileupload_soifg']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_soifg']["tmp_name"][$key];
								$name = $_FILES['fileupload_soifg']["name"][$key];
								$data['filename'] = $name;
								$data['id']=$this->input->post('spesifikasi_soi_fg_tentative_isoi_id');
								$data['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name, $path."/".$this->input->post('spesifikasi_soi_fg_tentative_isoi_id')."/".$name)) 
				 				{
									$sql[] = "INSERT INTO plc2_upb_file_soi_fg (isoi_id, filename, dInsertDate, vKeterangan, cInsert) 
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
							$this->dbset->query($q);
						}catch(Exception $e) {
							die($e);
						}
					}
					
					$r['message']="Data Berhasil Disimpan";
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->post('spesifikasi_soi_fg_tentative_isoi_id');					
					echo json_encode($r);
					exit();
				}  else {	
					//if (is_array($file_name)) {									
						//$this->hapusfile($path, $file_name, 'plc2_upb_file_soi_fg', $this->input->post('spesifikasi_soi_fg_tentative_isoi_id'));
					//}
								
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
			case 'approve_final':
				echo $this->approve_view_final();
				break;
			case 'approve_process_final':
				echo $this->approve_process_final();
				break;
			 //tambah delete
			case 'delete':
				echo $grid->delete_row();
			break; 
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();
				$post = $this->input->post();
		    	$this->db_plc0->where('iupb_id', $post['iupb_id']);
		    	$iapprove = $get['type'] == 'QC' ? 'isoiqc' : 'isoiqa';
		    	$this->db_plc0->update('plc2.plc2_upb', array($iapprove=>2));
		    	
		    	$this->db_plc0->where('isoi_id', $get['last_id']);
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				if($get['type'] == 'PD'){
					$iappnip='vapppd';
					$iappdate='dapppd';
					$iapprove='iapppd';
				}elseif($get['type'] == 'QC'){
					$iappnip='vnip_qc';
					$iappdate='tapp_qc';
					$iapprove='iappqc';
				}elseif($get['type'] == 'QA'){
					$iappnip='vnip_qa';
					$iappdate='tapp_qa';
					$iapprove='iappqa';
				};
				$istatus=$get['type'] == 'QC' ? '2' : '3';
		    	$this->db_plc0->update('plc2.plc2_upb_soi_fg', array($iapprove=>2, 'istatus'=>$istatus, $iappnip=>$nip, $iappdate=>$skg));

		    	$iupb_id=$post['iupb_id'];
		    
		    	$upbid=$post['iupb_id'];
		    	$query = "select count(isoi_id) as c from plc2.plc2_upb_soi_fg where iupb_id = $upbid and $iapprove = 0";
		    	$rows = $this->db_plc0->query($query)->row_array();
		    	$total = $rows['c'];
				
				$isoi_id=$this->input->get('last_id');
		        
		        $qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
		                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
		                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
		                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
		                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
		                        from plc2.plc2_upb u where u.iupb_id='".$post['iupb_id']."'";
		        $rupb = $this->db_plc0->query($qupb)->row_array();

		        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id,
		                (select te.iteam_id from plc2.plc2_upb_team te where te.cDeptId='PR') as iteampr_id 
		                from plc2.plc2_upb u 
		                where u.iupb_id='".$post['iupb_id']."'";
		        $rsql = $this->db_plc0->query($qsql)->row_array();

		        //$query = $this->dbset->query($rsql);

		        $pd = $rsql['iteampd_id'];
		        $bd = $rsql['iteambusdev_id'];
		        $qa = $rsql['iteamqa_id'];
		        $qc = $rsql['iteamqc_id'];
		        $pr = $rsql['iteampr_id'];
		        
		        $team = $pd. ','.$qa. ',' .$qc ;
		        
		        $toEmail2='';
		        //$toEmail = $this->lib_utilitas->get_email_team( $pr );
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

		        if($get['type']=='QC'){
		            $toEmail = $this->lib_utilitas->get_email_team( $qc );
		            $desc = "<td><b>Proses Selanjutnya</b></td><td> : </td><td>SOI Finish Good - Approval oleh QA</td>";
		        }elseif($get['type']=='QA'){
		            $toEmail = $this->lib_utilitas->get_email_team( $qa );
		            $desc = "<td><b>Proses Selanjutnya</b></td><td> : </td><td>SOI Mikro - Input data oleh QA</td>";
		        }elseif($get['type']=='PD'){
		        	$toEmail = $this->lib_utilitas->get_email_team( $pd );
		            $desc = "<td><b>Proses Selanjutnya</b></td><td> : </td><td>SOI Finish Good - Approval oleh QC</td>";
		        }

		        $to = $toEmail;
		        $cc = $toEmail2;
		        $subject="Proses Approval SOI FG: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada approval pada proses SOI Finish Good(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
		                                        ".$desc."
		                                </tr>
		                        </table>
		                </div>
		                <br/> 
		                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
		                Post Master";
		        /*echo  $to;
		        echo '</br>cc:' .$cc;      
		        echo  $content ;    
		        exit;*/
		        $this->lib_utilitas->send_email($to, $cc, $subject, $content);
				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Confirm Success!';
				echo json_encode($r);
				exit();
			break;
			default:
				$grid->render_grid();
				break;
		}
    }
	
	function manipulate_insert_button($buttons){
		/*$url=$this->url;
		unset($buttons['save']);
		//echo $this->auth_localnon->my_teams();
		$arrhak=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
		//print_r($arrhak);
		//exit;
		if(empty($arrhak)){
			
		}else{
			$btnSave='<button onclick="javascript:save_btn_multiupload(\'spesifikasi_soi_fg_tentative\', \''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_'.$url.'">Save</button>';
			$js = $this->load->view('spesifikasi_soi_fg_tentative_js');
			$buttons['save'] = $btnSave.$js;
		}		
		return $buttons;*/
		unset($buttons['save']);
		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'spesifikasi_soi_fg_tentative\', \''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_spesifikasi_soi_fg_tentative">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'spesifikasi_soi_fg_tentative\', \''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_spesifikasi_soi_fg_tentative">Save &amp; Submit</button>';
		//$js = $this->load->view('misc_util',array('className'=> 'spesifikasi_soi_fg_tentative'), true);
		$js = $this->load->view('spesifikasi_soi_fg_tentative_js');
		$js .= $this->load->view('uploadjs');
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){$type='PD';
				$buttons['save'] = $save_draft.$save.$js;
			}
			elseif(in_array('AD', $manager)){$type='AD';
				$buttons['save'] = $save_draft.$save.$js;
			}
			else{$type='';}

		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';
				$buttons['save'] = $save_draft.$save.$js;
			}
			elseif(in_array('AD', $team)){$type='AD';
				$buttons['save'] = $save_draft.$save.$js;
			}
			else{$type='';}
		}
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
    		if(in_array('QC', $manager)){$type='QC';}
    		elseif(in_array('QA', $manager)){$type='QA';}
			elseif(in_array('PD', $manager)){$type='PD';} //AD yg ada didlm tim PD bisa input dan update
    		else{$type='';}
    	}
		else{
		//yg bisa add team PD
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';}
			elseif(in_array('QA', $team)){$type='QA';}
    		else{$type='';}
		}
		// cek status upb, klao upb 
			unset($buttons['update_back']);
    		unset($buttons['update']);
			
			//$js = $this->load->view('misc_util',array('className'=> 'spesifikasi_soi_fg_tentative'), true);
			$js = $this->load->view('spesifikasi_soi_fg_tentative_js');
			$js .= $this->load->view('uploadjs');
			// echo $this->auth_localnon->my_teams();
			// echo $type;
			
    		$upb_id=$rowData['iupb_id'];
			$isoi_id=$rowData['isoi_id'];
			$qcek="select f.iapppd,f.itype, f.iappqc, f.iappqa, f.iappqc_f, f.iappqa_f, f.isubmit from plc2.plc2_upb_soi_fg f where f.isoi_id=$isoi_id and f.ldeleted=0";
			$rcek = $this->db_plc0->query($qcek)->row_array();
			//print_r($rcek);
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
			//Cek Nomor UPB
			$sql= "Select * from plc2.plc2_upb where iupb_id=".$rowData['iupb_id'];
			$dt=$this->dbset->query($sql)->row_array();
			$updatedraft = '<button onclick="javascript:update_draft_btn(\'spesifikasi_soi_fg_tentative\', \''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_soi_fg">Update as Draft</button>';
			/*if(empty($arrhak)){
				$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
				if(empty($getbp)){}
				else{*/
					$setuju = '<button onclick="javascript:setuju(\'spesifikasi_soi_fg_tentative\', \''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=confirm&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'&type='.$type.'\', this, '.$rowData['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Confirm</button>';
					if($this->auth_localnon->is_manager()){
						if(($type=='PD')&&($rcek['iappqa']==0)){ // PD bisa update selama QC blm app
							$update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_fg_tentative\', \''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_soi_fg">Update & Submit</button>';
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=approve&isoi_id='.$rowData['isoi_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Approve</button>';
							$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=reject&isoi_id='.$rowData['isoi_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Reject</button>';
							if($rcek['iapppd']==0){
								if($rowData['isubmit']==0){
									$buttons['update'] = $updatedraft.$update.$js;
								}else{
									//$buttons['update'] = $update.$approve.$reject.$js;//.$approve.$reject;
									$buttons['update']=$update.$setuju.$js;
								}
							}else{
								//$buttons['update'] = $update.$js;
							}
						}/*
						elseif(($type=='QC')&&($rcek['iappqc']==0)&&($rcek['iapppd']<>0)){
							$update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_fg_tentative\', \''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update & Submit</button>';
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=approve&isoi_id='.$rowData['isoi_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Approve</button>';
							$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=reject&isoi_id='.$rowData['isoi_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Reject</button>';
							//$buttons['update'] = $update.$approve.$reject.$js;
							$buttons['update']=$setuju.$js;
						}*/
						elseif(($type=='QA')&&($rcek['iappqa']==0)){
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=approve&isoi_id='.$rowData['isoi_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Approve</button>';
							$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=reject&isoi_id='.$rowData['isoi_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Reject</button>';
							//$buttons['update'] = $approve.$reject;
							$buttons['update']=$setuju.$js;
						}
						else{}
					}else{
						if(($type=='PD') &&($rcek['iappqa']==0)&&($rowData['isubmit']==0)&&($rcek['iapppd']==0)){
							$update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_fg_tentative\', \''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update & Submit</button>';
							$buttons['update'] = $updatedraft.$update.$js;
						}elseif(($type=='QA')&&($rcek['iappqa']==0)){
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=approve&isoi_id='.$rowData['isoi_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Approve</button>';
							$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=reject&isoi_id='.$rowData['isoi_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Reject</button>';
							//$buttons['update'] = $approve.$reject;
							$buttons['update']=$setuju.$js;
						}else{}

						//$buttons['update']=$type.'-'.$rcek['iappqa'];
					}


				//}
			/*}else{
				if($this->auth_localnon->is_manager()){
					if(($type=='PD')&&($rcek['iappqc']==0)){ // PD bisa update selama QC blm app
						$update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_fg_tentative\', \''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_soi_fg">Update</button>';
							if($rowData['isubmit']==0){
								$buttons['update'] = $updatedraft.$update.$js;
							}else{
								$buttons['update'] = $update.$js;//.$approve.$reject;
							}
					}
					elseif(($type=='QC')&&($rcek['iappqc']==0)){
						$update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_fg_tentative\', \''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
						$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=approve&isoi_id='.$rowData['isoi_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Approve</button>';
						$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=reject&isoi_id='.$rowData['isoi_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Reject</button>';
							
						$buttons['update'] = $update.$approve.$reject.$js;
					//echo "<br> aaaaaaaaa--------";
					}
					elseif(($type=='QA')&&($rcek['iappqa']==0) && ($rcek['iappqc']<>0)){
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=approve&isoi_id='.$rowData['isoi_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Approve</button>';
							$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=reject&isoi_id='.$rowData['isoi_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Reject</button>';
			
							$buttons['update'] = $approve.$reject;
					}
					//approval utk status final
					// elseif(($type=='QC')&&($rcek['iappqa']>0)&&($rcek['iappqc_f']==0) && ($fcek > 0)){
						// $update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_fg_tentative\', \''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
						// $approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=approve_final&isoi_id='.$rowData['isoi_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Approve</button>';
						// // $reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/fg/tentative?action=reject_final&ispekfg_id='.$rowData['ispekfg_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_daftar_upb">Reject</button>';
								
						// $buttons['update'] = $update.$approve.$js;//.$reject;
					// }
					// elseif(($type=='QA')&&($rcek['iappqa_f']==0) && ($rcek['iappqc_f']<>0) && ($fcek>0)){
						// $approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=approve_final&isoi_id='.$rowData['isoi_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_fg">Approve</button>';
						// //$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/spesifikasi/fg/tentative?action=reject_final&ispekfg_id='.$rowData['ispekfg_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_daftar_upb">Reject</button>';
						// $buttons['update'] = $approve;//.$reject;
					// }
						//
					else{}
					//array_unshift($buttons, $reject, $approve, $revise);
				}
				else{
					if(($type=='PD')&&($rcek['iappqc']==0) &&($rcek['iappqa']==0)&&($rowData['isubmit']==0)){
						$update = '<button onclick="javascript:update_btn_back(\'spesifikasi_soi_fg_tentative\', \''.base_url().'processor/plc/spesifikasi/soi/fg/tentative?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
						$buttons['update'] = $updatedraft.$update.$js;
					}else{}
				}
			}*/
   
		}
    	return $buttons;
    }
    public function listBox_Action($row, $actions) {
    	//cek apakah ada spek soi FG upb itu yg statusnya sudah Final, 
		//print_r($row);
		$iupbid=$row->iupb_id;
		if($row->isubmit<>0){
    		unset($actions['delete']);
    	}
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
			/*if(in_array('QC', $manager)){
				$type='QC';
				if($row->iappqc<>0){
					unset($actions['edit']);
				}else{
					if($row->iapppd==0){
						unset($actions['edit']);
					}
				}
			}
			else*/
			if(in_array('QA', $manager)){
				$type='QA';
				if($row->iappqa<>0){
					unset($actions['edit']);
				}/*else{
					if($row->iappqc==0){
						unset($actions['edit']);
					}
				}*/
			}
			else if(in_array('PD', $manager)){
				$type='PD';
				if($row->iapppd<>0){
					unset($actions['edit']);
				}
			}
			else{
				$type='';
				unset($actions['edit']);
			}
		}
		else{
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];

			$type='';
			if($row->isubmit<>0){

				if(in_array('QA', $team)){
					$type='QA';
					if($row->iappqa<>0){
						unset($actions['edit']);
					}
				}else{
					unset($actions['edit']);	
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
								var url = "'.base_url().'processor/plc/spesifikasi/soi/fg/tentative";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_spesifikasi_soi_fg_tentative").html(data);
									});
					
								}
									reload_grid("grid_spesifikasi_soi_fg_tentative");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_spesifikasi_soi_fg_tentative_approve" action="'.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : <input type="hidden" name="isoi_id" value="'.$this->input->get('isoi_id').'" />
    			<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_spesifikasi_soi_fg_tentative_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
		//print_r($post);
    	$this->db_plc0->where('iupb_id', $post['iupb_id']);
    	$iapprove = $post['type'] == 'QC' ? 'isoiqc' : 'isoiqa';
    	$this->db_plc0->update('plc2.plc2_upb', array($iapprove=>2));
    	
    	$this->db_plc0->where('isoi_id', $post['isoi_id']);
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		if($post['type'] == 'PD'){
			$iappnip='vapppd';
			$iappdate='dapppd';
			$iapprove='iapppd';
			$imaster='9';
		}elseif($post['type'] == 'QC'){
			$iappnip='vnip_qc';
			$iappdate='tapp_qc';
			$iapprove='iappqc';
			$imaster='10';
		}elseif($post['type'] == 'QA'){
			$iappnip='vnip_qa';
			$iappdate='tapp_qa';
			$iapprove='iappqa';
			$imaster='11';
		};
		$istatus=$post['type'] == 'QC' ? '2' : '3';
    	$this->db_plc0->update('plc2.plc2_upb_soi_fg', array($iapprove=>2, 'istatus'=>$istatus, $iappnip=>$nip, $iappdate=>$skg));

    	$iupb_id=$post['iupb_id'];
		//$this->lib_flow->insert_logs($post['modul_id'],$iupb_id,$imaster,2);
    
    	//jika ada satu saja spek fg dari upb tsb blm di app/ reject maka isoiqc / ispekqa = 1
    	$upbid=$post['iupb_id'];
    	$query = "select count(isoi_id) as c from plc2.plc2_upb_soi_fg where iupb_id = $upbid and $iapprove = 0";
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
    	
		//$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // 1 approval
		//$bizsup=$getbp['idplc2_biz_process_sub'];
		
		$isoi_id=$this->input->post('isoi_id');
		//$qcek="select f.isoi_id, f.itype, f.iappqc, f.iappqa from plc2.plc2_upb_soi_fg f where f.isoi_id=$isoi_id";
		//$rcek = $this->db_plc0->query($qcek)->row_array();
		// if($rcek['itype']==1){
			// //insert log
				// $this->biz_process->insert_log($upbid, $bizsup, 1); // status 1 => approve
			// //update last log
				// $this->biz_process->update_last_log($post['iupb_id'], $bizsup, 1);
		// }
		// elseif($rcek['itype']==0){
			//insert log
				//$this->biz_process->insert_log($upbid, $bizsup, 1); // status 1 => submit
			//insert last log
				//$this->biz_process->insert_last_log($upbid, $bizsup, 1);
		// }	
			
		// //insert log
		// $this->biz_process->insert_log($post['iupb_id'], $bizsup, 1); // status 1 => approved
		// //update last log
		// $this->biz_process->update_last_log($post['iupb_id'], $bizsup, 1);
    	// //$this->biz_process->insert_last_log($post['iupb_id'], $bizsup, 1);
        
        
        $qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
                        from plc2.plc2_upb u where u.iupb_id='".$post['iupb_id']."'";
        $rupb = $this->db_plc0->query($qupb)->row_array();

        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id,
                (select te.iteam_id from plc2.plc2_upb_team te where te.cDeptId='PR') as iteampr_id 
                from plc2.plc2_upb u 
                where u.iupb_id='".$post['iupb_id']."'";
        $rsql = $this->db_plc0->query($qsql)->row_array();

        //$query = $this->dbset->query($rsql);

        $pd = $rsql['iteampd_id'];
        $bd = $rsql['iteambusdev_id'];
        $qa = $rsql['iteamqa_id'];
        $qc = $rsql['iteamqc_id'];
        $pr = $rsql['iteampr_id'];
        
        $team = $pd. ','.$qa. ',' .$qc ;
        
        $toEmail2='';
        //$toEmail = $this->lib_utilitas->get_email_team( $pr );
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

        if($post['type']=='QC'){
            $toEmail = $this->lib_utilitas->get_email_team( $qc );
            $desc = "<td><b>Proses Selanjutnya</b></td><td> : </td><td>SOI Finish Good - Approval oleh QA</td>";
        }elseif($post['type']=='QA'){
            $toEmail = $this->lib_utilitas->get_email_team( $qa );
            $desc = "<td><b>Proses Selanjutnya</b></td><td> : </td><td>SOI Mikro - Input data oleh QA</td>";
        }elseif($post['type']=='PD'){
        	$toEmail = $this->lib_utilitas->get_email_team( $pd );
            $desc = "<td><b>Proses Selanjutnya</b></td><td> : </td><td>SOI Finish Good - Approval oleh QC</td>";
        }

        $to = $toEmail;
        $cc = $toEmail2;
        $subject="Proses Approval SOI FG: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval pada proses SOI Finish Good(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
                                        ".$desc."
                                </tr>
                        </table>
                </div>
                <br/> 
                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
                Post Master";
        /*echo  $to;
        echo '</br>cc:' .$cc;      
        echo  $content ;    
        exit;*/
        $this->lib_utilitas->send_email($to, $cc, $subject, $content);
        
    	$data['status']  = true;
    	$data['last_id'] = $isoi_id;
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
								var url = "'.base_url().'processor/plc/spesifikasi/soi/fg/tentative";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_spesifikasi_soi_fg_tentative").html(data);
									});
					
								}
									reload_grid("grid_spesifikasi_soi_fg_tentative");
							}
							})
						 }
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_spesifikasi_soi_fg_tentative_reject" action="'.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
    			<input type="hidden" name="isoi_id" value="'.$this->input->get('isoi_id').'" />
    			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
    			<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark" id="remark" required></textarea><button type="button" onclick="submit_ajax(\'form_spesifikasi_soi_fg_tentative_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process () {
    	$post = $this->input->post();
    	$this->db_plc0->where('iupb_id', $post['iupb_id']);
    	$iapprove = $post['type'] == 'QC' ? 'isoiqc' : 'isoiqa';
    	$this->db_plc0->update('plc2.plc2_upb', array($iapprove=>1));
    	
    	$this->db_plc0->where('isoi_id', $post['isoi_id']);
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$iappnip = $post['type'] == 'QC' ? 'vnip_qc' : 'vnip_qa';
		$iappdate = $post['type'] == 'QC' ? 'tapp_qc' : 'tapp_qa';
    	$iapprove = $post['type'] == 'QC' ? 'iappqc' : 'iappqa';
    	$this->db_plc0->update('plc2.plc2_upb_soi_fg', array($iapprove=>1, 'istatus'=>0, $iappnip=>$nip, $iappdate=>$skg));
    
    	//jika ada satu saja spek fg dari upb tsb blm di app/ reject maka ispekpd / ispekqa = 1
    	$upbid=$post['iupb_id'];
    	$query = "select count(isoi_id) as c from plc2.plc2_upb_soi_fg where iupb_id = $upbid and $iapprove = 0";
    	//echo $query;
    	$rows = $this->db_plc0->query($query)->row_array();
    	//echo $rows;
    	$total = $rows['c'];
    	// if($total > 0){
    		// $queries = "update plc2.plc2_upb set isoiqc = 1 where iupb_id = $upbid";
    	// } else {
    		// $queries = "update plc2.plc2_upb set isoiqc = 2 where iupb_id = $upbid";
    	// }
    	// $this->db_plc0->query($queries);
    	
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
    
		//$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // 1 approval
		//$bizsup=$getbp['idplc2_biz_process_sub'];
		
		$isoi_id=$this->input->post('isoi_id');
		//$qcek="select f.isoi_id, f.itype, f.iappqc, f.iappqa from plc2.plc2_upb_soi_fg f where f.isoi_id=$isoi_id";
		//$rcek = $this->db_plc0->query($qcek)->row_array();
		// if($rcek['itype']==1){
			// //insert log
				// $this->biz_process->insert_log($upbid, $bizsup, 2); // status 1 => approve
			// //update last log
				// $this->biz_process->update_last_log($post['iupb_id'], $bizsup, 2);
		// }
		// elseif($rcek['itype']==0){
			//insert log
			//	$this->biz_process->insert_log($upbid, $bizsup, 2); // status 1 => submit
			//insert last log
			//	$this->biz_process->insert_last_log($upbid, $bizsup, 2);
		// }
		
    	$data['status']  = true;
    	$data['last_id'] = $isoi_id;
    	return json_encode($data);
    }
	
	// //----------------------approve final-------------------------------//
	// function approve_view_final() {
    	// $echo = '<script type="text/javascript">
					 // function submit_ajax(form_id) {
						// return $.ajax({
					 	 	// url: $("#"+form_id).attr("action"),
					 	 	// type: $("#"+form_id).attr("method"),
					 	 	// data: $("#"+form_id).serialize(),
					 	 	// success: function(data) {
					 	 		// var o = $.parseJSON(data);
								// var last_id = o.last_id;
								// var url = "'.base_url().'processor/plc/spesifikasi/soi/fg/tentative";
								// if(o.status == true) {
					
									// $("#alert_dialog_form").dialog("close");
										 // $.get(url+"?action=update&id="+last_id, function(data) {
										 // $("div#form_spesifikasi_soi_fg_tentative").html(data);
									// });
					
								// }
									// reload_grid("grid_spesifikasi_soi_fg_tentative");
							// }
					
					 	 // })
					 // }
				 // </script>';
    	// $echo .= '<h1>Approval</h1><br />';
    	// $echo .= '<form id="form_spesifikasi_soi_fg_tentative_approve" action="'.base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=approve_process_final" method="post">';
    	// $echo .= '<div style="vertical-align: top;">';
    	// $echo .= 'Remark : <input type="hidden" name="isoi_id" value="'.$this->input->get('isoi_id').'" />
    			// <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
				// <input type="hidden" name="type" value="'.$this->input->get('type').'" />
				// <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				// <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				// <textarea name="remark"></textarea>
		// <button type="button" onclick="submit_ajax(\'form_spesifikasi_soi_fg_tentative_approve\')">Approve</button>';
    		
    	// $echo .= '</div>';
    	// $echo .= '</form>';
    	// return $echo;
    // }
    
    // function approve_process_final() {
		
    	// $post = $this->input->post();
		// $upbid=$post['iupb_id'];
		// //print_r($post);
    	// $this->db_plc0->where('iupb_id', $post['iupb_id']);
    	// $iapprove = $post['type'] == 'QC' ? 'isoiqc' : 'isoiqa';
    	// $this->db_plc0->update('plc2.plc2_upb', array($iapprove=>2));
    	
    	// $this->db_plc0->where('isoi_id', $post['isoi_id']);
		// $nip = $this->user->gNIP;
		// $skg=date('Y-m-d H:i:s');
		// $iappnip = $post['type'] == 'QC' ? 'vnip_qc_f' : 'vnip_qa_f';
		// $iappdate = $post['type'] == 'QC' ? 'tapp_qc_f' : 'tapp_qa_f';
    	// $iapprove = $post['type'] == 'QC' ? 'iappqc_f' : 'iappqa_f';
		// $istatus=$post['type'] == 'QC' ? '2' : '3';
    	// $this->db_plc0->update('plc2.plc2_upb_soi_fg', array('itype'=>1,$iapprove=>2, 'istatus'=>$istatus, $iappnip=>$nip, $iappdate=>$skg));
        	
    	// $ins['iupb_id'] = $post['iupb_id'];
		// $ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
		// $ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
		// $ins['idiv_id'] = '';
		// $ins['vtipe'] = $post['type'];
		// $ins['iapprove'] = '2';
		// $ins['cnip'] = $this->user->gNIP;
		// $ins['treason'] = 'Final '.$post['remark'];
		// $ins['tupdate'] = date('Y-m-d H:i:s');
    
    	// $this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
    	
		// $getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // 1 approval
		// $bizsup=$getbp['idplc2_biz_process_sub'];
		
		// $isoi_id=$this->input->post('isoi_id');
		// $qcek="select f.isoi_id, f.itype, f.iappqc, f.iappqa from plc2.plc2_upb_soi_fg f where f.isoi_id=$isoi_id";
		// $rcek = $this->db_plc0->query($qcek)->row_array();
		// if($rcek['itype']==1){
			// //insert log
				// $this->biz_process->insert_log($upbid, $bizsup, 1); // status 1 => approve
			// //update last log
				// $this->biz_process->update_last_log($post['iupb_id'], $bizsup, 1);
		// }
		// elseif($rcek['itype']==0){
			// //insert log
				// $this->biz_process->insert_log($upbid, $bizsup, 1); // status 1 => submit
			// //insert last log
				// $this->biz_process->insert_last_log($upbid, $bizsup, 1);
		// }	
			
	   	// $data['status']  = true;
    	// $data['last_id'] = $isoi_id;
    	// return json_encode($data);
    // }
	
	// //------------------------------------------------------------------//
	
	
	function before_insert_processor($row, $postData) {
		$this->load->helper('to_mysql');
		if($postData['isdraft']==true){
			$postData['isubmit']=0;
		} 
		else{$postData['isubmit']=1;} 
		// unset($postData['fmikro']);
		// unset($postData['vupb_nama']);unset($postData['vgenerik']);unset($postData['iteampd_id']);
		//$postData['tberlaku'] = to_mysql($postData['tberlaku']);
		return $postData;
	}
	function after_insert_processor($row, $insertId, $postData) {
		//print_r($postData); exit();
		$upbId = $postData['iupb_id'];
		$i=1;
		$skrg = date('Y-m-d H:i:s');
		$user = $this->auth_localnon->user();
		
		//$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
		//$bizsup=$getbp['idplc2_biz_process_sub'];
		//$qcek="select f.isoi_id, f.itype, f.iapppd, f.iappqa from plc2.plc2_upb_soi_fg f where f.isoi_id=$insertId";
		//$rcek = $this->db_plc0->query($qcek)->row_array();
		$iupb_id=$postData['iupb_id'];
		//$this->lib_flow->insert_logs($this->input->get('modul_id'),$iupb_id,1);
			//insert log
				//$this->biz_process->insert_log($postData['iupb_id'], $bizsup, 7); // status 7=> submit
			//update last log
				//$this->biz_process->insert_last_log($postData['iupb_id'], $bizsup, 7);
		
	}
	function before_update_processor($row, $postData) {
		unset($postData['vapppd']);
		unset($postData['vnip_qc']);
		unset($postData['vnip_qa']);
		$this->load->helper('to_mysql');
		if($postData['isdraft']==true){
			$postData['isubmit']=0;
		} 
		else{$postData['isubmit']=1;} 
		$postData['tupdate']=date('Y-m-d H:i:s');
		// unset($postData['fmikro']);
		// unset($postData['vupb_nama']);unset($postData['vgenerik']);unset($postData['iteampd_id']);
		//$postData['tberlaku'] = to_mysql($postData['tberlaku']);
		//print_r($postData);
		return $postData;
	}
	function after_update_processor($row, $updateId, $postData) {
		//$this->load->helper('search_array');
		//$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
		//$bizsup=$getbp['idplc2_biz_process_sub'];
		//echo $bizsup; 
		//$qcek="select f.isoi_id, f.itype, f.iapppd, f.iappqa from plc2.plc2_upb_soi_fg f where f.isoi_id=$updateId";
		//$rcek = $this->db_plc0->query($qcek)->row_array();
			//insert log
				//$this->biz_process->insert_log($postData['iupb_id'], $bizsup, 7); // status 7 => submit
			//update last log
				//$this->biz_process->update_last_log($postData['iupb_id'], $bizsup, 7);
	}//
	function listBox_spesifikasi_soi_fg_tentative_iapppd($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	function listBox_spesifikasi_soi_fg_tentative_itype($value) {
    	if($value==0){$vstatus='Tentative';}
    	elseif($value==1){$vstatus='Final';}
    	return $vstatus;
    }
	function listBox_spesifikasi_soi_fg_tentative_iappqc($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
    function listBox_spesifikasi_soi_fg_tentative_iappqa($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }

    function insertBox_spesifikasi_soi_fg_tentative_dmulai_draft($field, $id){
    	$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px"/>';
		$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
						
					</script>';
		return $return;
    }
     function updateBox_spesifikasi_soi_fg_tentative_dmulai_draft($field, $id, $value, $rowData) {
    	$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" value="'.$value.'" style="width:80px"/>';
		$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
						
					</script>';
		return $return;
    }
    function insertBox_spesifikasi_soi_fg_tentative_dselesai_draft($field, $id){
    	$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px"/>';
		$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
						
					</script>';
		return $return;
    }
     function updateBox_spesifikasi_soi_fg_tentative_dselesai_draft($field, $id, $value, $rowData) {
    	$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" value="'.$value.'" style="width:80px"/>';
		$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
						
					</script>';
		return $return;
    }


	//status (itype)
	function insertBox_spesifikasi_soi_fg_tentative_itype($field, $id) {		
		return 'Final &nbsp;<input type="hidden" value="1" name="'.$id.'" id="'.$id.'" class="input_rows1" size="25" />';
	}
	function updateBox_spesifikasi_soi_fg_tentative_itype($field, $id, $value, $rowData) {
		 //print_r($rowData);
		return 'Final &nbsp;<input type="hidden" value="1" name="'.$id.'" id="'.$id.'" class="input_rows1" size="25" />';
	}
	//
	
	//Keterangan approval 
	function insertBox_spesifikasi_soi_fg_tentative_vapppd($field, $id) {
		return ' ';
	}
	function updateBox_spesifikasi_soi_fg_tentative_vapppd($field, $id, $value, $rowData) {
		if($rowData['vapppd'] != null){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vapppd']))->row_array();
			if($rowData['iapppd']==2){$st="Approved";}elseif($rowData['iapppd']==1){$st="Rejected";
				$rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// $reason=$rowa['treason'];
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vapppd'].' )'.' pada '.$rowData['dapppd'];
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	function insertBox_spesifikasi_soi_fg_tentative_vnip_qc($field, $id) {
		return ' ';
	}
	function updateBox_spesifikasi_soi_fg_tentative_vnip_qc($field, $id, $value, $rowData) {
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
	function insertBox_spesifikasi_soi_fg_tentative_vnip_qa($field, $id) {
		return ' ';
	}
	function updateBox_spesifikasi_soi_fg_tentative_vnip_qa($field, $id, $value, $rowData) {
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
	
/*	function updateBox_spesifikasi_soi_fg_tentative_tberlaku($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1 required" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	*/
	function insertBox_spesifikasi_soi_fg_tentative_iupb_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="7" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/soifg/popup?field=spesifikasi_soi_fg_tentative\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function updateBox_spesifikasi_soi_fg_tentative_iupb_id($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$value))->row_array();
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		$return .= '<input type="hidden" value="'.$value.'" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" value="'.$row['vupb_nomor'].'" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="7" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/soifg/popup?field=spesifikasi_soi_fg_tentative\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function insertBox_spesifikasi_soi_fg_tentative_filename($field, $id) {
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('spesifikasi_soi_fg_tentative_file',$data,TRUE);
	}
	function updateBox_spesifikasi_soi_fg_tentative_filename($field, $id, $value, $rowData) {
		$idsoi = $rowData['isoi_id'];	
		//$this->db_plc0->where('ispekfg_id',$rowData['ispekfg_id']);
		//$this->db_plc0->where('ldeleted', 0);
		//$data['rows'] = $this->db_plc0->get('plc2.plc2_upb_file_spesifikasi_fg')->result_array();	
		//print_r($data);
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_soi_fg', array('isoi_id'=>$idsoi))->result_array();
		return $this->load->view('spesifikasi_soi_fg_tentative_file',$data,TRUE);
	}

	/*function updateBox_spesifikasi_soi_fg_tentative_filename($field, $id, $value, $rowData) {
		$input = '<input type="file" name="'.$id.'" id="'.$id.'" class="" size="50" />';
		if($value != '') {
			if (file_exists('./files/plc/spek_soi_fg/'.$value)) {
				$link = base_url().'processor/plc/spesifikasi/soi/fg/tentative?action=download&file='.$value;
				$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			}
			else {
				$linknya = 'File sudah tidak ada!';
			}
			return 'File name : '.$value.' ['.$linknya.']<br />'.$input;
		}
		else {
			return 'No File<br />'.$input;
		}		
	}
	*/
	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/spek_soi_fg/'.$id.'/'.$name);		
		force_download($name, $path);
	}
	 
	function insertBox_spesifikasi_soi_fg_tentative_vupb_nama($field, $id) {
		return '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="40" /><input type="hidden" value="1" name="spesifikasi_soi_fg_tentative_itype" id="spesifikasi_soi_fg_tentative_vupb_itype" class="input_rows1" size="25" />';
	}
	function updateBox_spesifikasi_soi_fg_tentative_vupb_nama($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" value="'.$row['vupb_nama'].'" class="input_rows1" size="40" /><input type="hidden" value="1" name="spesifikasi_soi_fg_tentative_itype" id="spesifikasi_soi_fg_tentative_vupb_itype" class="input_rows1" size="25" />';
	}
	function insertBox_spesifikasi_soi_fg_tentative_vgenerik($field, $id) {
		return '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="40" />';
	}
	function updateBox_spesifikasi_soi_fg_tentative_vgenerik($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" value="'.$row['vgenerik'].'" class="input_rows1" size="40" />';
	}
	function insertBox_spesifikasi_soi_fg_tentative_iteampd_id($field, $id) {		
		return '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="40" />';
	}
	function insertBox_spesifikasi_soi_fg_tentative_vkode_surat($field, $id) {		
		return '<input type="text" name="'.$field.'" id="'.$id.'" class="input_rows1 required" size="40" />';
	}
	function updateBox_spesifikasi_soi_fg_tentative_vkode_surat($field, $id, $value, $rowData) {	
		return '<input type="text" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" size="40" />';
	}
	function updateBox_spesifikasi_soi_fg_tentative_iteampd_id($field, $id, $value, $rowData) {
		$sql = "SELECT t.vteam FROM plc2.plc2_upb u INNER JOIN plc2.plc2_upb_team t ON u.iteampd_id=t.iteam_id WHERE u.iupb_id='".$rowData['iupb_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		return '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" value="'.$row['vteam'].'" class="input_rows1" size="40" />';
	}
	
	/*function insertPost_spesifikasi_soi_fg_tentative_filename($value, $name, $post) {
		$new_name = 'Spek_soi_fg_'.$post['iupb_id'].'_'.date('Y-m-d_H_i_s');
		return $new_name;
	}
	
	function updatePost_spesifikasi_soi_fg_tentative_filename($value, $name, $post) {
		$new_name = 'Spek_soi_fg_'.$post['iupb_id'].'_'.date('Y-m-d_H_i_s');
		return $new_name;
	}
	*/
	
	function insertBox_spesifikasi_soi_fg_tentative_vnip_formulator($field, $id) {
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=spesifikasi_soi_fg_tentative\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function updateBox_spesifikasi_soi_fg_tentative_vnip_formulator($field, $id, $value, $rowData) {
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=spesifikasi_soi_fg_tentative\',\'List UPB\')" type="button">&nbsp;</button>';
		
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
					$del = "delete from plc2.".$table." where isoi_id = {$lastId} and filename= '{$v}'";
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
			$sql = "SELECT filename from plc2.".$table." where isoi_id=".$lastId;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['filename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT filename from plc2.".$table." where isoi_id=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM plc2.".$table." where isoi_id=".$lastId." and filename='".$row['filename']."'";			
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
