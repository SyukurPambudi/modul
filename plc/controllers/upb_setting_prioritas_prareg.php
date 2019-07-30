<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upb_setting_prioritas_prareg extends MX_Controller {
	function __construct() {
        parent::__construct();
		$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->load->library('biz_process');
		$this->load->library('lib_flow');
		$this->load->library('lib_utilitas');
		$this->user = $this->auth_localnon->user();
    }
    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle('Setting Prioritas Prareg');		
		$grid->setTable('plc2.plc2_upb_prioritas');		
		$grid->setUrl('upb_setting_prioritas_prareg');
		$grid->addList('iyear','imonth','iteambusdev_id','iappbusdev','iappdir');
		$grid->setSortBy('iyear');
		$grid->setSortOrder('DESC');
		$grid->setQuery('plc2.plc2_upb_prioritas.ldeleted', 0);
		$grid->addFields('iyear','imonth','iteambusdev_id','rincian_upb','cappbusdev','iappdir','tupdate');
		$grid->setRequired('iyear','imonth','iteambusdev_id');
		$grid->setSearch('iyear','imonth','iteambusdev_id');
		$grid->setLabel('iyear', 'Tahun');
		$grid->setAlign('iyear', 'center');
		$grid->setAlign('imonth', 'center');
		$grid->setAlign('iteambusdev_id', 'center');
		$grid->setLabel('rincian_upb', 'Rincian UPB');
		$grid->setLabel('imonth', 'Semester');
		$grid->setLabel('iteambusdev_id', 'Team Busdev');
		$grid->setLabel('iappbusdev', 'Approval Busdev');
		$grid->setLabel('iappdir', 'Approval Direksi');
		$grid->setLabel('cnip', 'Approval Busdev');
		$grid->changeFieldType('cnip','hidden');
		$grid->changeFieldType('tupdate','hidden');
		//prareg utk team nya sendiri
		/*
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('BD', $manager)){
				$grid->setQuery('iteambusdev_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
		
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('BD', $team)){
				$grid->setQuery('iteambusdev_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
		}
		*/
		//$grid->setQuery('iteambusdev_id IN ('.$this->auth_localnon->my_teams().')', NULL);
		
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
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			//tambah delete
			case 'delete':
				echo $grid->delete_row();
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
	function manipulate_update_button($buttons, $rowData) {
    	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			unset($buttons['update_back']);
			unset($buttons['update']);
			
			//print_r($rowData);
			//echo $rowData['vnip_formulator']."<br>".$this->user->gNIP;
			$user = $this->auth_localnon->user();
		
			$x=$this->auth_localnon->dept();
			if($this->auth_localnon->is_manager()){
				$x=$this->auth_localnon->dept();
				$manager=$x['manager'];
				if(in_array('BD', $manager))
				{
					$type='BD';
				}elseif(in_array('DR', $manager)){
					$type='DR';
				}else{
					$type='';
				}
			}
			else{
				$x=$this->auth_localnon->dept();
				$team=$x['team'];
				if(in_array('BD', $team))
				{
					$type='BD';
				}elseif(in_array('DR', $team)){
					$type='DR';
				}else{
					$type='';
				}
			}
			
			//echo $type;
			// cek status upb, klao upb 
				unset($buttons['update_back']);
				unset($buttons['update']);
				
				//echo $this->auth_localnon->my_teams();
				$iprio_id=$rowData['iprioritas_id'];
				//$ifor_id=$rowData['ifor_id'];
				
				// print_r($rowData);exit();
				$js = $this->load->view('import/setting_prioritas_upi_js');
				$x=$this->auth_localnon->my_teams();
				if($this->auth_localnon->is_manager()){ //jika manager BD
					if(($type=='BD')&&($rowData['iappbusdev']==0)){
						if ($rowData['iSubmit']==0) {
							$updatedraft = '<button onclick="javascript:update_draft_btn(\'upb_setting_prioritas_prareg\', \''.base_url().'processor/plc/upb/setting/prioritas/prareg?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_draft_setprio_prareg">Update as Draft</button>';
							$update = '<button onclick="javascript:update_btn_upload(\'upb_setting_prioritas_prareg\', \''.base_url().'processor/plc/upb/setting/prioritas/prareg?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_setprio_prareg">Update & Submit</button>';	
							$buttons['update'] = $updatedraft.$update.$js;
						}else{
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/setting/prioritas/prareg?action=approve&iprio_id='.$iprio_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_setprio_prareg">Approve</button>';
							$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/setting/prioritas/prareg?action=reject&iprio_id='.$iprio_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_setprio_prareg">Reject</button>';
							$buttons['update'] = $approve.$reject.$js;
						}
					}

					if(($type=='DR')&&($rowData['iappbusdev']==2)&&($rowData['iappdir']==0) ){
							$update = '<button onclick="javascript:update_btn_upload(\'upb_setting_prioritas_prareg\', \''.base_url().'processor/plc/upb/setting/prioritas/prareg?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_setprio_prareg">Update & Submit</button>';	

							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/setting/prioritas/prareg?action=approve&iprio_id='.$iprio_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_setprio_prareg">Confirm</button>';
							$buttons['update'] = $update.$approve.$js;
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
								var url = "'.base_url().'processor/plc/upb/setting/prioritas/prareg";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_upb_setting_prioritas_prareg").html(data);
									});
					
								}
									reload_grid("grid_upb_setting_prioritas_prareg");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_upb_setting_prioritas_prareg_approve" action="'.base_url().'processor/plc/upb/setting/prioritas/prareg?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="iprio_id" value="'.$this->input->get('iprio_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_upb_setting_prioritas_prareg_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$remark = $post['remark'];
		$type = $post['type'];
		$this->db_plc0->where('iprioritas_id', $post['iprio_id']);
		
		$iprio_id=$post['iprio_id'];

		if($type =='BD'){
			$updet = $this->db_plc0->update('plc2.plc2_upb_prioritas', array('iappbusdev'=>2,'tappbusdev'=>$skg,'cappbusdev'=>$nip,'remarkbusdev'=>$remark));

			//get upb_id
			$qiupb="select distinct(pd.iupb_id) from plc2.plc2_upb_prioritas_detail pd
						inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id
					where pd.iprioritas_id=$iprio_id";
			$riu = $this->db_plc0->query($qiupb)->result_array();
			
			

            if ($updet) {
                
                    

                   	$sql = "select distinct(pd.iteampd_id) from plc2.plc2_upb_prioritas_detail pd where pd.iprioritas_id=$iprio_id and pd.ldeleted=0
							order by pd.ibobot asc";
					$team_pd= $this->db_plc0->query($sql)->result_array();

					foreach($team_pd as $tpd){
						$pdteam=$tpd['iteampd_id'];
						$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
								(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
								(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
								(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
								(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
							 from plc2.plc2_upb u 
							 where u.iupb_id in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd where pd.iprioritas_id=$iprio_id 
								and pd.ldeleted=0 and pd.iteampd_id=$pdteam order by pd.ibobot asc)";
						$rupb = $this->db_plc0->query($qupb)->result_array();
						
						//echo $pdteam;exit;
						$qemail="select e.vEmail from hrd.employee e 
									where e.cNip in (select te.vnip from plc2.plc2_upb_team te where te.iteam_id=$pdteam) 
									or e.cNip in (select ti.vnip from plc2.plc2_upb_team_item ti where ti.iteam_id=$pdteam and ti.ldeleted=0)";
						$remail = $this->db_plc0->query($qemail)->result_array();
						$to="";
						foreach($remail as $toemail){
							$to.=$toemail['vEmail'].', ';
						}

						$qemail="select e.vEmail from hrd.employee e 
									where 
									e.vEmail <>'' and
									e.cNip in (select te.vnip from plc2.plc2_upb_team te 
										 where te.vtipe='PAC') 
									or e.cNip in (select ti.vnip from plc2.plc2_upb_team_item ti 
										JOIN plc2.plc2_upb_team p ON p.iteam_id = ti.iteam_id
										where p.vtipe='PAC' and ti.ldeleted=0)  ";
						$remail = $this->db_plc0->query($qemail)->result_array();

						$cc="";
						foreach($remail as $toemail){
							$cc.=$toemail['vEmail'].',';
						}
	 
						$subject="Setting Prioritas Prareg UPB";

						$a="
							<html>
							<head>
							<style type='text/css'>
							  table.tbl3 {border-collapse: collapse; border: 1px solid black; font-size: 10px;}
							  tr.tr3, tr.thHdr3, td.td3 {border: 1px solid black; background: #FFFFFF;}
							  tr.tr4, th.th3 {border: 1px solid black; background: #AAAAAA; color: #000000}
							</style>
							</head>
							<body>
							<div><h3>Alert Notification UPB yang sudah Disetting Prioritas Praregistrasi</h3></div>
							<div><h5>Diberitahukan bahwa telah ada Setting Prioritas Praregistrasi oleh Busdev Manager pada aplikasi PLC dengan rincian sebagai berikut :<br><br></h5></div>
							<table class='tbl3' style='width: 100%' width='100%' border='0' cellspacing='0' cellpadding='2'>
							<thead>
								<tr class='tr4'>				
									<th class='th3' style='text-align: center; vertical-align: middle;'>No UPB</th>
									<th class='th3' style='text-align: center; vertical-align: middle;'>Nama Usulan</th>
									<th class='th3' style='text-align: center; vertical-align: middle;'>Nama Generik</th>																
									<th class='th3' style='text-align: center; vertical-align: middle;'>Team Busdev</th>
									<th class='th3' style='text-align: center; vertical-align: middle;'>Team PD</th>
									<th class='th3' style='text-align: center; vertical-align: middle;'>Team QA</th>
									<th class='th3' style='text-align: center; vertical-align: middle;'>Team QC</th>
								</tr>
							</thead>";
									foreach($rupb as $list){
									$a.='
										<tr class="tr3">
											<td class="td3">'.$list['vupb_nomor'].'</td>
											<td class="td3">'.$list['vupb_nama'].'</td>
											<td class="td3">'.$list['vgenerik'].'</td>
											<td class="td3">'.$list['bd'].'</td>
											<td class="td3">'.$list['pd'].'</td>
											<td class="td3">'.$list['qa'].'</td>
											<td class="td3">'.$list['qc'].'</td>
										</tr>
									';
									}
									
								$a.="	
								</table>
							<br/> 
							Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
							Post Master
							</body>
						</html>";
						$content=$a;


                    }

                    $this->sess_auth->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
                    /*echo "sampai sini ";
						exit;*/
            }


			
		}else{

			$this->db_plc0->update('plc2.plc2_upb_prioritas', array('iappdir'=>1,'tappdir'=>$skg,'cappdir'=>$nip,'remarkdir'=>$remark));
		}
		$data['status']  = true;
    	$data['last_id'] = $iprio_id;
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
								var url = "'.base_url().'processor/plc/upb/setting/prioritas/prareg";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_upb_setting_prioritas_prareg").html(data);
									});
					
								}
									reload_grid("grid_upb_setting_prioritas_prareg");
							}
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_upb_setting_prioritas_prareg_reject" action="'.base_url().'processor/plc/upb/setting/prioritas/prareg?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="iprio_id" value="'.$this->input->get('iprio_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea><button type="button" onclick="submit_ajax(\'form_upb_setting_prioritas_prareg_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process () {
    	$post = $this->input->post();
    	$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
	 	$this->db_plc0->where('iprioritas_id', $post['iprio_id']);
		$this->db_plc0->update('plc2.plc2_upb_prioritas', array('iappbusdev'=>1,'tappbusdev'=>$skg));
    
		$iprio_id=$post['iprio_id'];
		
		//get upb_id
		$qiupb="select distinct(pd.iupb_id) from plc2.plc2_upb_prioritas_detail pd
					inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id
				where pd.iprioritas_id=$iprio_id";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		
		
		foreach($riu as $xx){
			/*$iupb_id=$xx['iupb_id'];
			$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // activity 3 input data
			$bizsup=$getbp['idplc2_biz_process_sub'];*/

			// lib_flow start
	//		$this->lib_flow->insert_logs($post['modul_id'],$iupb_id,3,1);

			
/*			
			$hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,2); // status 7 => submit
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 2); // status 7 => submit
				//update last log
					$this->biz_process->update_last_log($iupb_id, $bizsup, 2);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 2); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($iupb_id, $bizsup, 2);
			}
*/			
		}
		
		$data['status']  = true;
    	$data['last_id'] = $iprio_id;
    	return json_encode($data);
    }
	
	function listBox_upb_setting_prioritas_prareg_iappbusdev($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }

    function listBox_upb_setting_prioritas_prareg_iappdir($value) {
    	if($value==0){$vstatus='Waiting for Confirmation';}
    	elseif($value==1){$vstatus='Confirmed';}
    	return $vstatus;
    }

	//Keterangan approval 
	function insertBox_upb_setting_prioritas_prareg_cappbusdev($field, $id) {
		return '-';
	}
	function updateBox_upb_setting_prioritas_prareg_cappbusdev($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($rowData['iappbusdev'] <>0)){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
			if($rowData['iappbusdev']==2){$st="Approved";}elseif($rowData['iappbusdev']==1){$st="Rejected";
				// $rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// if(isset($rowa)){$reason=$rowa['treason'];}
				
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$value.' )'.' pada '.$rowData['tappbusdev'];
			$ret .= '<input type="hidden" id="'.$id.'" name="'.$id.'" value="'.$value.'">';
			$ret.='<br><p>'.$rowData['remarkbusdev'].'</p>';
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}

	function insertBox_upb_setting_prioritas_prareg_iappdir($field, $id) {
		return '-';
	}
	function updateBox_upb_setting_prioritas_prareg_iappdir($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($rowData['iappdir'] <>0)){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cappdir']))->row_array();
			if($rowData['iappdir']==1){$st="Confirmed";

			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['cappdir'].' )'.' pada '.$rowData['tappdir'];
			$ret.='<br><p>'.$rowData['remarkdir'].'</p>';
		}
		else{
			$ret='Waiting for Confirmation';
		}
		
		return $ret;
	}


	//
	function output(){
    	$this->index($this->input->get('action'));
    }
	function listBox_upb_setting_prioritas_prareg_iteambusdev_id ($value) {
		$teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$value))->row_array();
		
		$ret =$teams['vteam'];
		return $ret;
	}
	function listBox_upb_setting_prioritas_prareg_imonth ($value) {
		return 'Semester '.$value;
	}
	function searchBox_upb_setting_prioritas_prareg_imonth ($field, $id) {
		$this->load->config('plc_config');
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=1; $i<=2; $i++) {
			$echo .= '<option value="'.$i.'">Semester '.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	function searchBox_upb_setting_prioritas_prareg_iteambusdev_id ($field, $id) {
		$sql = "SELECT * FROM ".$this->db_plc0->dbprefix('plc2.plc2_upb_team')." d WHERE d.vtipe = 'BD' AND d.ldeleted = 0 ORDER BY d.vteam ASC ";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select id="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		foreach($teams as $t) {
			$echo .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	function searchBox_upb_setting_prioritas_prareg_iyear ($field, $id) {
		$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-3; // dari -2 diganti -3
		$sampai = $thn_sekarang+7;
		$echo = '<select id="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=$mulai; $i<=$sampai; $i++) {
			$echo .= '<option value="'.$i.'">'.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	function insertBox_upb_setting_prioritas_prareg_iyear ($field, $id) {
		$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-3; //dari -2 diganti -3
		$sampai = $thn_sekarang+7;
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=$mulai; $i<=$sampai; $i++) {
			$echo .= '<option value="'.$i.'">'.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}

	function updateBox_upb_setting_prioritas_prareg_iyear ($field, $id, $value, $rowData) {
		$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-3; //dari -2 diganti -3
		$sampai = $thn_sekarang+7;
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=$mulai; $i<=$sampai; $i++) {
			$selected = $value == $i ? 'selected' : '';
			$echo .= '<option '.$selected.' value="'.$i.'">'.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}

	function insertBox_upb_setting_prioritas_prareg_iteambusdev_id ($field, $id) {
		$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'BD' AND d.iteam_id IN (".$this->auth_localnon->my_teams().") AND d.ldeleted = 0 ORDER BY d.vteam ASC ";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		foreach($teams as $t) {
			$echo .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	function updateBox_upb_setting_prioritas_prareg_iteambusdev_id ($field, $id, $value, $rowData) {
		if($this->auth_localnon->is_manager()){
				$x=$this->auth_localnon->dept();
				$manager=$x['manager'];
				if(in_array('BD', $manager)){$type='BD';}
				else{$type='';}
			}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('BD', $team)){$type='BD';}
			else{$type='';}
		}
		if($type=='BD'){
			$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'BD' AND d.iteam_id IN (".$this->auth_localnon->my_teams().") AND d.ldeleted = 0 ORDER BY d.vteam ASC ";
			$teams = $this->db_plc0->query($sql)->result_array();
			$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
			foreach($teams as $t) {
				$selected = $value == $t['iteam_id'] ? 'selected' : '';
				$echo .= '<option '.$selected.' value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
			}
			$echo .= '</select>';
			return $echo;
		}
		else{
			$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'BD' AND d.iteam_id='$value' AND d.ldeleted = 0 ORDER BY d.vteam ASC ";
			$teams = $this->db_plc0->query($sql)->row_array();

			$ret = '<input type="hidden" id="'.$id.'" name="'.$id.'" value="'.$value.'">';
			$ret .= $teams['vteam'];
			return $ret;
		}
		
	}
	
	function insertBox_upb_setting_prioritas_prareg_imonth ($field, $id) {
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
	
	function updateBox_upb_setting_prioritas_prareg_imonth ($field, $id, $value, $rowData) {
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
	
	function insertBox_upb_setting_prioritas_prareg_rincian_upb ($field, $id) {
		$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'PD' AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
		$data['team_pd'] = $this->db_plc0->query($sql)->result_array();
		$data['browse_url'] = base_url().'processor/plc/browse/upb/setprareg?action=index';
		return $this->load->view('upb_setting_prioritas_prareg_rincian_upb',$data,TRUE);
	}
	
	function updateBox_upb_setting_prioritas_prareg_rincian_upb ($field, $id, $value, $rowData) {
		$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'PD' AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
		$data['team_pd'] = $this->db_plc0->query($sql)->result_array();
		$data['browse_url'] = base_url().'processor/plc/browse/upb/setprareg?action=index';
		$data['iprioritas_id'] = $rowData['iprioritas_id'];
		return $this->load->view('upb_setting_prioritas_prareg_rincian_upb_edit',$data,TRUE);
	}


	function manipulate_insert_button($buttons) {
		unset($buttons['save']);

		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'upb_setting_prioritas_prareg\', \''.base_url().'processor/plc/upb/setting/prioritas/prareg?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_upb_setting_prioritas_prareg">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'upb_setting_prioritas_prareg\', \''.base_url().'processor/plc/upb/setting/prioritas/prareg?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_upb_setting_prioritas_prareg">Save &amp; Submit</button>';
		$js = $this->load->view('lokal/setting_prioritas_prareg_js');
		$buttons['save'] = $save_draft.$save.$js;

		return $buttons;
	}

	function before_insert_processor($row, $postData) {
		$user = $this->auth_localnon->user();
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = date('Y-m-d H:i:s', mktime());
		unset($postData['iupb_id']);
		unset($postData['iupb_nomor']);
		unset($postData['rincian_upb']);

		if($postData['isdraft']==true){
			$postData['iSubmit']=0;
		} 
		else{$postData['iSubmit']=1;} 

		return $postData;
	}

	function after_insert_processor($row, $insertId, $postData) {
		$sql2="select * from plc2.plc2_upb_prioritas u where u.iprioritas_id=$insertId";
						$list_prio=$this->db_plc0->query($sql2)->row_array();

		$det = array();
		// masukkan ke logs upb proses , action input 
		if ($list_prio['iSubmit']==1) {
			foreach($postData['iupb_id'] as $k=>$v) {
				foreach($v as $uk => $uv) {
					if($uv != '') {
				//		$this->lib_flow->insert_logs($this->input->get('modul_id'),$uv,1,0);
					}
				}
			}
		}
		
		/*
		foreach($postData['iupb_id'] as $k=>$v) {
			$this->lib_flow->insert_logs($this->input->get('modul_id'),$post['iupb_id'],$action_id,2);
		}
		*/


		$bobot = 1;
		foreach($postData['iupb_id'] as $k=>$v) {
			foreach($v as $uk => $uv) {
				if($uv != '') {
					$det['iprioritas_id'] = $insertId;
					$det['iupb_id'] = $uv;
					$det['ibobot'] = $bobot;
					$det['iteampd_id'] =$k ; 
					$bobot++;
					/*$this->biz_process->insert_log($uv, 4, 7); // biz sub nya setting prioritas, statusnya input
					$this->biz_process->insert_last_log($uv, 4, 7); // biz sub nya setting prioritas, statusnya input*/
					//ubah status iprioritas di tabel upb
						//jika upb kategori 4 5 6 7 8
						$sql="select * from plc2.plc2_upb u where u.iupb_id=$uv";
						$list_upb=$this->db_plc0->query($sql)->row_array();
						if(($list_upb['ikategoriupb_id'] >= 4)&&($list_upb['ikategoriupb_id'] <= 8))
						{
							//ubah status prareg nya jadi gak butuh
							$this->db_plc0->where('iupb_id', $uv);
							$this->db_plc0->update('plc2.plc2_upb', array('iprioritas'=>1,'iappbusdev_prareg'=>3,'vnip_appbusdev_prareg'=>'-','tappbusdev_prareg'=>'0000-00-00 00:00:00')); 
						}
						else{
							$this->db_plc0->where('iupb_id', $uv);
							$this->db_plc0->update('plc2.plc2_upb', array('iprioritas'=>1)); // 1 sudah masuk prioritas, 0 belum
						}
					
					try {
						$this->db_plc0->insert('plc2.plc2_upb_prioritas_detail', $det);
					}catch(Exception $e) {
						die('salah!');
					}
				}
			}					
		}
		
		
		//get upb_id
		$qiupb="select distinct(pd.iupb_id) from plc2.plc2_upb_prioritas_detail pd
					inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id
				where pd.iprioritas_id=$insertId";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		
		foreach($riu as $xx){
			$iupb_id=$xx['iupb_id'];
			/*$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
			$bizsup=$getbp['idplc2_biz_process_sub'];*/
			
			/*$hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,7); // status 7 => submit
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//update last log
					$this->biz_process->update_last_log($iupb_id, $bizsup, 7);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($iupb_id, $bizsup, 7);
			}*/
		}
	}
	public function manipulate_grid_button($button) {
	
		//unset($button['create']);
		if($this->auth_localnon->is_manager()){
			$teams = $this->auth_localnon->tipe();
			$man=$teams['manager'];
			if(in_array('BD',$man)){}
			else{unset($button['create']);}
		}
		else{unset($button['create']);}
		return $button;
			
	}
	public function listBox_Action($row, $actions) {
		
		if($this->auth_localnon->is_manager()){
			$teams = $this->auth_localnon->tipe();
			$man=$teams['manager'];
			if(in_array('BD',$man)  ){
				if ($this->auth_localnon->myteam_id()==$row->iteambusdev_id ) {
					//print_r($row); 
					if ($row->iappbusdev<>0) {
						unset($actions['edit']);
						unset($actions['delete']);	
					}else{
						
					}
				}else{
					unset($actions['edit']);
					unset($actions['delete']);
					//echo $this->auth_localnon->my_teams()
				}

			}else if(in_array('DR',$man)  ){
				if ($row->iappbusdev == 2 and  $row->iappdir == 0 ) {

				}else{
					unset($actions['edit']);
					unset($actions['delete']);	
				}
			}

			
		}
		else{
				unset($actions['edit']);
				unset($actions['delete']);
			}
		return $actions;
	}
	function before_update_processor($row, $postData, $newUpdateData) {
		if($postData['isdraft']==true){
			$postData['iSubmit']=0;
		} 
		else{$postData['iSubmit']=1;} 

		

		$user = $this->auth_localnon->user();
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = date('Y-m-d H:i:s', mktime());
		unset($postData['iupb_id']);
		unset($postData['iupb_nomor']);
		unset($postData['rincian_upb']);
		return $postData;
	}
	function after_update_processor($row, $insertId, $postData, $old_data) {
		//print_r($postData); exit;
		
	$det = array();		
		$bobot = 1;
		$sql="select * from plc2.plc2_upb_prioritas_detail upd where upd.iprioritas_id=$insertId";
		$list_upb=$this->db_plc0->query($sql)->result_array();


		//ubah plc2_upb.iprioritas=0 utk semua upb dgn iprioritas tsb
		foreach($list_upb as $x=>$v){
			$this->db_plc0->where('iupb_id', $v['iupb_id']);
			$this->db_plc0->update('plc2.plc2_upb', array('iprioritas'=>0));
		}
		$this->db_plc0->where('iprioritas_id', $insertId);
		if($this->db_plc0->update('plc2.plc2_upb_prioritas_detail', array('ldeleted'=>1))) {
			foreach($postData['iupb_id'] as $k=>$v) {
				foreach($v as $uk => $uv) {
					if($uv != '') {
						$det['iprioritas_id'] = $insertId;
						$det['iupb_id'] = $uv;
						$det['ibobot'] = $bobot;
						$det['iteampd_id'] =$k ; 
						$bobot++;
						$this->db_plc0->where('iupb_id', $uv);
						$this->db_plc0->update('plc2.plc2_upb', array('iprioritas'=>1));
						try {
							$this->db_plc0->insert('plc2.plc2_upb_prioritas_detail', $det);
						}catch(Exception $e) {
							die('salah!');
						} 
					}
				}					
			}//exit;
		}
		
		$sql3="select * from plc2.plc2_upb_prioritas_detail upd where upd.iprioritas_id=$insertId and upd.ldeleted=0 ";
		$list_upb2=$this->db_plc0->query($sql3)->result_array();

		$sql2="select * from plc2.plc2_upb_prioritas u where u.iprioritas_id=$insertId";
						$list_prio=$this->db_plc0->query($sql2)->row_array();
						
		if ($list_prio['iSubmit']==1) {
			foreach($list_upb2 as $dupb) {
					if($dupb['iupb_id'] != '') {
				//		$this->lib_flow->insert_logs($this->input->get('modul_id'),$dupb['iupb_id'],1,0);
					}
			}
		}

/*			
		//get upb_id
		$qiupb="select distinct(pd.iupb_id) from plc2.plc2_upb_prioritas_detail pd
					inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id
				where pd.iprioritas_id=$insertId";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		
		foreach($riu as $xx){
			$iupb_id=$xx['iupb_id'];
			$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
			$hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,7); // status 7 => submit
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//update last log
					$this->biz_process->update_last_log($iupb_id, $bizsup, 7);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($iupb_id, $bizsup, 7);
			}
		}
*/		
	}
	function insertCheck_upb_setting_prioritas_prareg_iyear($value, $field, $rows) {
		$year = $value;
		$month = $rows['imonth'];
		$teambd = $rows['iteambusdev_id'];
// 		echo 'year'.$value;
// 		print_r($rows);exit;
		
		$this->db_plc0->where('iteambusdev_id', $teambd);		
		$this->db_plc0->where('iyear', $year);
		$this->db_plc0->where('imonth', $month);
		$this->db_plc0->where('ldeleted', '0'); //tambahin ldeleted=0
		$j = $this->db_plc0->count_all_results('plc2.plc2_upb_prioritas');
		if($j > 0) {
			return 'Insert Prioritas pada periode '.$year.' Semester '.$month.' sudah pernah di input, harap pilih periode lain';
		} 
		else {
			return TRUE;
		}
	}
	function updateCheck_upb_setting_prioritas_prareg_iyear($value, $field, $rows) {
		$year = $value;
		$month = $rows['imonth'];
		$teambd = $rows['iteambusdev_id'];
// 		echo 'year'.$value;
		//print_r($rows);exit;
		$idprioritas=$rows['iprioritas_id'];
		$this->db_plc0->where('iprioritas_id not in ('.$idprioritas.')', null);		
		$this->db_plc0->where('iteambusdev_id', $teambd);		
		$this->db_plc0->where('iyear', $year);
		$this->db_plc0->where('imonth', $month);
		$this->db_plc0->where('ldeleted', '0'); //tambahin ldeleted=0
		$j = $this->db_plc0->count_all_results('plc2.plc2_upb_prioritas');
		if($j > 0) {
			return 'Insert Prioritas pada periode '.$year.' Semester '.$month.' sudah pernah di input, harap pilih periode lain';
		} 
		else {
			return TRUE;
		}
	}
	
	/*public function listBox_action($row, $action) {
		if($row->iyear == '2012') {
			$action['edit'] = 'NO Edit';
		}
		return $action;
	}*/
}
