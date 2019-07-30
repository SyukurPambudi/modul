<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Registrasi_prareg_upb extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->user = $this->auth->user();
		$this->load->library('biz_process');
		$this->load->library('lib_utilitas');
		$this->dbset = $this->load->database('plc', true);
	}
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('Pra Registrasi UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('registrasi_prareg_upb');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik','tsubmit_prareg','iappbusdev_prareg');
		//$grid->addList('vupb_nomor','vupb_nama','vgenerik','ttarget_prareg','tsubmit_prareg','iappbusdev_prareg');
		$grid->setSortBy('vupb_nomor');
		$grid->setSortOrder('desc');
		$grid->addFields('vupb_nomor','vupb_nama','vgenerik','iteambusdev_id','icap_lengkap_prareg','dcap_lengkap_prareg');
		//$grid->addFields('ttarget_prareg','tsubmit_prareg','tTglTD_prareg','tTgl_SubDokTD_prareg','dokumen','vnip_appbusdev_prareg');
		$grid->addFields('tsubmit_prareg','dokumen','vnip_appbusdev_prareg');
		
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('iteambusdev_id','Team Busdev');
		$grid->setLabel('icap_lengkap_prareg','Cap Lengkap');
		$grid->setLabel('dcap_lengkap_prareg','Tanggal Cap Lengkap');
		$grid->setLabel('tspb','Tanggal SPB');
		//$grid->setLabel('ttarget_prareg','Tanggal Target Prareg');
		$grid->setLabel('tsubmit_prareg','Tanggal Prareg');
		$grid->setLabel('tTglTD_prareg','Tanggal Tambahan Data');
		$grid->setLabel('tTgl_SubDokTD_prareg','Tanggal Submit Dok. TD');
		//$grid->setSearch('vupb_nomor','vupb_nama','vgenerik','ttarget_prareg','tsubmit_prareg');
		$grid->setSearch('vupb_nomor','vupb_nama','vgenerik','tsubmit_prareg');
		$grid->setLabel('iappbusdev_prareg','Approval Busdev');
		$grid->setLabel('vnip_appbusdev_prareg','Approval Busdev');
		
        $grid->setQuery('plc2_upb.iappdireksi', 2);
        $grid->setQuery('plc2_upb.iconfirm_dok', 1); //confirm cek dokumen prareg

        //New Parameter For PLC Non OTC
		$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2.plc2_upb.iKill', 0);
		$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
		$grid->setQuery('plc2_upb.ihold', 0);


		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('BD', $manager)){
				$type='BD';
				$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('BD', $team)){
				$type='BD';
				$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}

		$grid->setQuery('plc2_upb.ihold', 0);
		$grid->changeFieldType('icap_lengkap_prareg','combobox','',array(0=>'Tidak Lengkap', 2=>'Lengkap', 3=>'N/A'));
		$grid->setFormUpload(TRUE);
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
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				$isUpload = $this->input->get('isUpload');
				$post=$this->input->post();
				//print_r($post);exit();
				$iupb_id=$post['registrasi_prareg_upb_iupb_id'];
				$path = realpath("files/plc/prareg/");
				if(!file_exists($path."/".$iupb_id)){
					if (!mkdir($path."/".$iupb_id, 0777, true)) { //id review
						die('Failed upload, try again!'.$path);
					}
				}
									
				$fKeterangan = array();	
   				if($isUpload) {	
   					$fileid='';
   					foreach($_POST as $key=>$value) {
											
						if ($key == 'fileketerangan') {
							foreach($value as $y=>$u) {
								$fKeterangan[$y] = $u;
							}
						}
						if ($key == 'namafile') {
							foreach($value as $k=>$v) {
								$file_name[$k] = $v;
							}
						}
						if ($key == 'fileid') {
							$i=0;
							foreach($value as $k=>$v) {
								if($i==0){
									$fileid .= "'".$v."'";
								}else{
									$fileid .= ",'".$v."'";
								}
								$i++;
							}
						}
					}
					
					if (isset($_FILES['fileupload_prareg']))  {
						$i=0;
						foreach ($_FILES['fileupload_prareg']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_prareg']["tmp_name"][$key];
								$name =$_FILES['fileupload_prareg']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$iupb_id."/".$name)) {
									$sql[]="INSERT INTO plc2.prareg_file (iupb_id, vFilename, vKeterangan, dCreate, cCreate) 
											VALUES (".$iupb_id.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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

					}
					
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');				
					echo json_encode($r);
					exit();
				}  else {
					$fileid='';
					foreach($_POST as $key=>$value) {
											
						if ($key == 'fileketerangan') {
							foreach($value as $y=>$u) {
								$fKeterangan[$y] = $u;
							}
						}
						if ($key == 'namafile') {
							foreach($value as $k=>$v) {
								$file_name[$k] = $v;
							}
						}
						if ($key == 'fileid') {
							$i=0;
							foreach($value as $k=>$v) {
								if($i==0){
									$fileid .= "'".$v."'";
								}else{
									$fileid .= ",'".$v."'";
								}
								$i++;
							}
						}
					}
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.prareg_file set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where iupb_id='".$iupb_id."' and iprareg_file_id not in (".$fileid.")";
					$this->dbset->query($sql1);
					echo $grid->updated_form();
				}
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
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();

				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$this->db_plc0->where('iupb_id', $post['iupb_id']);
				$this->db_plc0->update('plc2.plc2_upb', array('iappbusdev_prareg'=>2,'vnip_appbusdev_prareg'=>$nip,'tappbusdev_prareg'=>$skg));
		    
				$upb_id=$post['iupb_id'];
				/*
				$ins['iupb_id'] = $post['upb_id'];
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
					
				$hacek=$this->biz_process->cek_last_status($post['upb_id'],$bizsup,1); // status 1 => app
				if($hacek==1){ // jika sudah pernah ada data maka update saja
					//insert log
					$this->biz_process->insert_log($post['upb_id'], $bizsup, 1); // status 1 => app
					//update last log
					$this->biz_process->update_last_log($post['upb_id'], $bizsup, 1);
				}
				elseif($hacek==0){
					//insert log
					$this->biz_process->insert_log($post['upb_id'], $bizsup, 1); // status 1 => app
					//insert last log
					$this->biz_process->insert_last_log($post['upb_id'], $bizsup, 1);
				}*/
				//}
		    	//send email notifikasi to PD
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

		        //$query = $this->dbset->query($rsql);

		        $pd = $rsql['iteampd_id'];
		        $bd = $rsql['iteambusdev_id'];
		        $qa = $rsql['iteamqa_id'];
		        $qc = $rsql['iteamqc_id'];

		        $team = $pd. ','.$bd ;
		        
		        $toEmail2='';
		        $toEmail = $this->lib_utilitas->get_email_team( $bd );
		        $toEmail2 = $this->lib_utilitas->get_email_leader( $bd );                        

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
		        $cc = $toEmail2;
		        
				$subject="Proses Praregistrasi Selesai : UPB ".$rupb['vupb_nomor']." ( ".$rupb['vupb_nama']." )";
				$content="
					Diberitahukan bahwa telah ada approval Praregistrasi UPB oleh Busdev Manager pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
		                            <td><b>Proses Selanjutnya</b></td><td> : </td><td>Setting Prioritas Registrasi - Input data oleh Busdev</td>
		                    </tr>                    
						</table>
					</div>
					<br/> 
					Demikian. Terimakasih.<br><br><br>
					Post Master";
		        /*    
		        echo  $to;
		        echo '</br>cc:' .$cc;      
		        echo  $content ;    
		        exit ;      */ 
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
    function listBox_Action($row, $actions) {
		//print_r($row);
	    if($row->iappbusdev_prareg<>0){
	    	unset($actions['edit']);
	    	unset($actions['delete']);
	    }
	    return $actions; 

	}

	function manipulate_update_button($buttons, $rowData) {
    	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			unset($buttons['update_back']);
			unset($buttons['update']);
			//print_r($rowData);
			//echo $rowData['vnip_formulator']."<br>".$this->user->gNIP;
			$user = $this->auth->user();
		
			$x=$this->auth->dept();
			if($this->auth->is_manager()){
				$x=$this->auth->dept();
				$manager=$x['manager'];
				if(in_array('BD', $manager)){$type='BD';}
				else{$type='';}
			}
			else{
				$x=$this->auth->dept();
				$team=$x['team'];
				if(in_array('BD', $team)){$type='BD';}
				else{$type='';}
			}
			
			//echo $type;
			// cek status upb, klao upb 
				unset($buttons['update_back']);
				unset($buttons['update']);
				
				//echo $this->auth->my_teams();
				$js=$this->load->view('registrasi_prareg_upb_js');
				$upb_id=$rowData['iupb_id'];
				$update = '<button onclick="javascript:update_btn_back(\'registrasi_prareg_upb\', \''.base_url().'processor/plc/registrasi/prareg/upb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_prareg">Update</button>';
				// print_r($rowData);exit();

				$sql= "select * from plc2.plc2_upb up where up.iupb_id=".$rowData['iupb_id'];
				$dt=$this->dbset->query($sql)->row_array();
				$setuju = '<button onclick="javascript:setuju(\'registrasi_prareg_upb\', \''.base_url().'processor/plc/registrasi/prareg/upb?action=confirm&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Confirm</button>';

				if($this->auth->is_manager()){ //jika manager PR
					if(($type=='BD')&&($rowData['iappbusdev_prareg']==0)){
						//$update = '<button onclick="javascript:update_btn_upload(\'registrasi_prareg_upb\', \''.base_url().'processor/plc/registrasi/prareg/upb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_prareg_upb">Update</button>';
						//$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/registrasi/prareg/upb?action=approve&upb_id='.$upb_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_prareg_upb">Approve</button>';
						//$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/registrasi/prareg/upb?action=reject&upb_id='.$upb_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_prareg_upb">Reject</button>';
							
						$buttons['update'] = $update.$setuju.$js;
					}
					else{}
				}
				else{
					if(($type=='BD')&&($rowData['iappbusdev_prareg']==0)){
						//$update = '<button onclick="javascript:update_btn_upload(\'registrasi_prareg_upb\', \''.base_url().'processor/plc/registrasi/prareg/upb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_prareg_upb">Update</button>';
							
						$buttons['update'] = $update;
					}
					else{}
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
								var url = "'.base_url().'processor/plc/registrasi/prareg/upb";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_registrasi_prareg_upb").html(data);
									});
					
								}
									reload_grid("grid_registrasi_prareg_upb");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_registrasi_prareg_upb_approve" action="'.base_url().'processor/plc/registrasi/prareg/upb?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="upb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_registrasi_prareg_upb_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$this->db_plc0->where('iupb_id', $post['upb_id']);
		$this->db_plc0->update('plc2.plc2_upb', array('iappbusdev_prareg'=>2,'vnip_appbusdev_prareg'=>$nip,'tappbusdev_prareg'=>$skg));
    
		$upb_id=$post['upb_id'];
		
		$ins['iupb_id'] = $post['upb_id'];
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
			
		$hacek=$this->biz_process->cek_last_status($post['upb_id'],$bizsup,1); // status 1 => app
		if($hacek==1){ // jika sudah pernah ada data maka update saja
			//insert log
			$this->biz_process->insert_log($post['upb_id'], $bizsup, 1); // status 1 => app
			//update last log
			$this->biz_process->update_last_log($post['upb_id'], $bizsup, 1);
		}
		elseif($hacek==0){
			//insert log
			$this->biz_process->insert_log($post['upb_id'], $bizsup, 1); // status 1 => app
			//insert last log
			$this->biz_process->insert_last_log($post['upb_id'], $bizsup, 1);
		}
		//}
    	//send email notifikasi to PD
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

        $team = $pd. ','.$bd ;
        
        $toEmail2='';
        $toEmail = $this->lib_utilitas->get_email_team( $bd );
        $toEmail2 = $this->lib_utilitas->get_email_leader( $bd );                        

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
        $cc = $toEmail2;
        
		$subject="Proses Praregistrasi Selesai : UPB ".$rupb['vupb_nomor']." ( ".$rupb['vupb_nama']." )";
		$content="
			Diberitahukan bahwa telah ada approval Praregistrasi UPB oleh Busdev Manager pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
                            <td><b>Proses Selanjutnya</b></td><td> : </td><td>Setting Prioritas Registrasi - Input data oleh Busdev</td>
                    </tr>                    
				</table>
			</div>
			<br/> 
			Demikian. Terimakasih.<br><br><br>
			Post Master";
        /*    
        echo  $to;
        echo '</br>cc:' .$cc;      
        echo  $content ;    
        exit ;      */ 
		$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		$data['status']  = true;
    	$data['last_id'] = $upb_id;
    	return json_encode($data);
    }
    
    function reject_view() {
    	$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	 return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/registrasi/prareg/upb";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_registrasi_prareg_upb").html(data);
									});
					
								}
									reload_grid("grid_registrasi_prareg_upb");
							}
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_registrasi_prareg_upb_reject" action="'.base_url().'processor/plc/registrasi/prareg/upb?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="upb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
				<button type="button" onclick="submit_ajax(\'form_registrasi_prareg_upb_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process () {
    	$post = $this->input->post();
    	$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
	 	$this->db_plc0->where('iupb_id', $post['upb_id']);
		$this->db_plc0->update('plc2.plc2_upb', array('iappbusdev_prareg'=>1,'vnip_appbusdev_prareg'=>$nip,'tappbusdev_prareg'=>$skg));
    
		$upb_id = $post['upb_id'];
		
			$ins['iupb_id'] = $post['upb_id'];
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
			
				
			$hacek=$this->biz_process->cek_last_status($post['upb_id'],$bizsup,2); // status 2 => reject
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($post['upb_id'], $bizsup, 2); // status 2 => reject
				//update last log
					$this->biz_process->update_last_log($post['upb_id'], $bizsup, 2);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($post['upb_id'], $bizsup, 2); // status 2 => reject
				//insert last log
					$this->biz_process->insert_last_log($post['upb_id'], $bizsup, 2);
			}
		//}
		
    	$data['status']  = true;
    	$data['last_id'] = $upb_id;
    	return json_encode($data);
    }
	// public function listBox_Action($row, $actions) {
		// if($this->auth->is_manager()){
			// $teams = $this->auth->tipe();
			// $man=$teams['manager'];
			// if(in_array('BD',$man) && ($row->iappbusdev_prareg)==0){}
			// else{
				// unset($actions['edit']);
				// unset($actions['delete']);
			// }
		// }
		// else{
				// unset($actions['edit']);
				// unset($actions['delete']);
			// }
		// return $actions;
	// }
	function listBox_registrasi_prareg_upb_iappbusdev_prareg($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	elseif($value==3){$vstatus='Tidak Memerlukan';}
    	return $vstatus;
    }
	//Keterangan approval 
	
	function updateBox_registrasi_prareg_upb_vnip_appbusdev_prareg($field, $id, $value, $rowData) {
		//print_r($rowData);
		if($rowData['iappbusdev_prareg']==3){
			$ret="Tidak Memerlukan Prareg";
		}
		elseif(($rowData['vnip_appbusdev_prareg'] != null)){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_appbusdev_prareg']))->row_array();
			if($rowData['iappbusdev_prareg']==2){
				$st="Approved";
				$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_appbusdev_prareg'].' )'.' pada '.$rowData['tappbusdev_prareg'];
			}
			elseif($rowData['iappbusdev_prareg']==1){
				$st="Rejected";
				$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_appbusdev_prareg'].' )'.' pada '.$rowData['tappbusdev_prareg'];
			}
			else{
				$ret='Waiting for Approval';
			}	
			
				// $rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// if(isset($rowa)){$reason=$rowa['treason'];}
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	//
	function updateBox_registrasi_prareg_upb_dokumen($field, $id, $value, $rowData) {
		/*$this->load->helper('search_array');
		$data['iupb_id'] = $rowData['iupb_id'];
		$data['bb'] = $rowData['txtDocBB'];
		$data['sm'] = $rowData['txtDocSM'];
		return $this->load->view('registrasi_prareg_upb_dokumen', $data, TRUE);*/
		$qr="select * from plc2.prareg_file pra where pra.lDeleted=0 and pra.iupb_id=".$rowData['iupb_id'];
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');
		$row=$this->db_plc0->query($qr)->num_rows();		
		$return = $this->load->view('registrasi_prareg_upb_file',$data,TRUE);
		return $return;
		
	}
	
	// function updateBox_registrasi_prareg_upb_vfileregistrasi($field, $id, $value, $rowData) {
		// $input = '<input type="file" name="'.$id.'" id="'.$id.'" class="" size="50" />';
		// if($value != '') {
			// if (file_exists('./files/plc/registrasi_doc/'.$value)) {
				// $link = base_url().'processor/plc/registrasi/upb?action=download&file='.$value;
				// $linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			// }
			// else {
				// $linknya = 'File sudah tidak ada!';
			// }
			// return 'File name : '.$value.' ['.$linknya.']<br />'.$input;
		// }
		// else {
			// return 'No File<br />'.$input;
		// }		
	// }

	// function download($filename) {
		// $this->load->helper('download');		
		// $name = $filename;
		// $path = file_get_contents('./files/plc/registrasi_doc/'.$name);		
		// force_download($name, $path);
	// }

	function updateBox_registrasi_prareg_upb_vupb_nomor($name, $id, $value) {
		return $value;
	}
	function updateBox_registrasi_prareg_upb_vupb_nama($name, $id, $value) {
		return $value;
	}
	function updateBox_registrasi_prareg_upb_vgenerik($name, $id, $value) {
		return $value;
	}
	function updateBox_registrasi_prareg_upb_iteambusdev_id($name, $id, $value) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$value))->row_array();
		return $row['vteam'];
	}

	function updateBox_registrasi_prareg_upb_dcap_lengkap_prareg($name, $id, $value) {
		//$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : $value;
		if($this->input->get('action')=='view'){
			$return = $val;
		}else{
			$return= '<input type="text" class="input_tgl tanggal input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
		}
		$return.='
		<script type="text/javascript">
			// datepicker
			 $(".tanggal").datepicker({changeMonth:true,
										changeYear:true,
										dateFormat:"yy-mm-dd" });

			
		</script>
		';
		return $return;
	}
	function updateBox_registrasi_prareg_upb_tTglTD_prareg($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		if($this->input->get('action')=='view'){
			$return = $val;
		}else{
			$return= '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
		}
		return $return;
	}
	function updateBox_registrasi_prareg_upb_tTgl_SubDokTD_prareg($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		if($this->input->get('action')=='view'){
			$return = $val;
		}else{
			$return= '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
		}
		return $return;
	}
	
	function updateBox_registrasi_prareg_upb_tspb($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		if($this->input->get('action')=='view'){
			$return = $val;
		}else{
			$return= '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
		}
		return $return;
	}
	
/* 	function updateBox_registrasi_prareg_upb_ttarget_prareg($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		return '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
	} */
	
	function updateBox_registrasi_prareg_upb_tsubmit_prareg($name, $id, $value,$r) {
		//$this->load->helper('to_mysql');
		$val = $r['tsubmit_prareg'] == '0000-00-00' || $r['tsubmit_prareg'] == '' ? '' : $r['tsubmit_prareg'];
		if($this->input->get('action')=='view'){
			$return = $val;
		}else{
			$return= '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
		}
		$return.='
		<script type="text/javascript">
			// datepicker
			 $("#'.$id.'").datepicker({changeMonth:true,
										changeYear:true,
										dateFormat:"yy-mm-dd" });

			
		</script>
		';
		return $return;
	}

	function before_update_processor($row, $post, $postData) {
		//print_r($postData);exit;
		$user = $this->auth->user();
		$this->load->helper('to_mysql');
		//$postData['dcap_lengkap_prareg'] = to_mysql($postData['dcap_lengkap_prareg']);
		//$postData['tspb'] = to_mysql($postData['tspb']);
		//$postData['ttarget_prareg'] = to_mysql($postData['ttarget_prareg']);
		//$postData['tsubmit_prareg'] = to_mysql($postData['tsubmit_prareg']);
		//$postData['tTglTD_prareg'] = to_mysql($postData['tTglTD_prareg']);
		//$postData['tTgl_SubDokTD_prareg'] = to_mysql($postData['tTgl_SubDokTD_prareg']);
		
		$postData['iupb_id'] =$postData['registrasi_prareg_upb_iupb_id'];
		unset($postData['registrasi_upb_iupb_id']);
		$postData['icap_lengkap_prareg'] =$postData['registrasi_prareg_upb_icap_lengkap_prareg'];
		unset($postData['registrasi_prareg_upb_icap_lengkap_prareg']);
		
		//print_r($postData);exit;
		return $postData;
	}
	
	function after_update_processor($row, $updateId, $postData) {
		/*$bb = $postData['bbid'];
		$sm = $postData['smid'];
		$okbb = $postData['okbb'];
		$notebb = $postData['notebb'];
		$oksm = $postData['oksm'];
		$notesm = $postData['notesm'];
		$this->db_plc0->where('iupb_id', $updateId);
		$this->db_plc0->delete('plc2.plc2_upb_prareg_dokumen_bb_detail');
		$this->db_plc0->where('iupb_id', $updateId);
		$this->db_plc0->delete('plc2.plc2_upb_prareg_dokumen_sm_detail');
		
		foreach($bb as $r) {
			if(array_key_exists($r, $okbb)) {
				$bbd['iupb_id'] = $updateId;
				$bbd['idoc_id'] = $r;
				$bbd['tnote'] = $notebb[$r];
				$this->db_plc0->insert('plc2.plc2_upb_prareg_dokumen_bb_detail', $bbd);
			}
		}
		foreach($sm as $r) {
			if(array_key_exists($r, $oksm)) {
				$smd['iupb_id'] = $updateId;
				$smd['idoc_id'] = $r;
				$smd['tnote'] = $notesm[$r];
				$this->db_plc0->insert('plc2.plc2_upb_prareg_dokumen_sm_detail', $smd);
			}
		}
			$getbp=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // activity 3 input data
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
			$hacek=$this->biz_process->cek_last_status($updateId,$bizsup,7); // status 7 => submit
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($updateId, $bizsup, 7); // status 7 => submit
				//update last log
					$this->biz_process->update_last_log($updateId, $bizsup, 7);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($updateId, $bizsup, 7); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($updateId, $bizsup, 7);
			}*/
	}

	function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/prareg/'.$id.'/'.$name);	
		force_download($name, $path);
	}


	function output(){		
    	$this->index($this->input->get('action'));
    }
}