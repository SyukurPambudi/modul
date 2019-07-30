<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upb_setting_prioritas_reg extends MX_Controller {
	function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->load->library('biz_process');
        $this->load->library('lib_utilitas');
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle('Setting Prioritas Registrasi');		
		$grid->setTable('plc2.plc2_upb_prioritas_reg');		
		$grid->setUrl('upb_setting_prioritas_reg');
		$grid->addList('iyear','imonth','iteambusdev_id','iappbusdev');
		$grid->setSortBy('iyear');
		$grid->setSortOrder('DESC');
		$grid->addFields('iyear','imonth','iteambusdev_id','rincian_upb','cnip','tupdate');
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
		$grid->setLabel('cnip', 'Approval Busdev');
		$grid->changeFieldType('cnip','hidden');
		$grid->changeFieldType('tupdate','hidden');
		//prareg utk team nya sendiri
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('BD', $manager)){
				$type='BD';
				$grid->setQuery('iteambusdev_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('BD', $team)){
				$type='BD';
				$grid->setQuery('iteambusdev_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		//$grid->setQuery('iteambusdev_id IN ('.$this->auth->my_teams().')', NULL);
		$grid->setQuery('ldeleted','0', NULL);
		
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
	function output(){
    	$this->index($this->input->get('action'));
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
				$iprio_id=$rowData['iprioritas_id'];
				//$ifor_id=$rowData['ifor_id'];
				
				// print_r($rowData);exit();
				
				$x=$this->auth->my_teams();
				//print_r($x);
				$arrhak=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
			//print_r($arrhak);
				if(empty($arrhak)){
					$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
					if(empty($getbp)){}
					else{
						if($this->auth->is_manager()){ //jika manager BD
							if(($type=='BD')&&($rowData['iappbusdev']==0)){
								$update = '<button onclick="javascript:update_btn_upload(\'upb_setting_prioritas_reg\', \''.base_url().'processor/plc/upb/setting/prioritas/reg?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_setprio_reg">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/setting/prioritas/reg?action=approve&iprio_id='.$iprio_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_setprio_reg">Approve</button>';
								//$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/setting/prioritas/reg?action=reject&iprio_id='.$iprio_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_setprio_reg">Reject</button>';
									
								$buttons['update'] = $update.$approve;
							}
							else{}
						}
						else{
							
						}
					}
				}else{
					if($this->auth->is_manager()){ //jika manager PR
						if($this->auth->is_manager()){ //jika manager PR
							if(($type=='BD')&&($rowData['iappbusdev']==0)){
								$update = '<button onclick="javascript:update_btn_upload(\'upb_setting_prioritas_reg\', \''.base_url().'processor/plc/upb/setting/prioritas/reg?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_setprio_reg">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/setting/prioritas/reg?action=approve&iprio_id='.$iprio_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_setprio_reg">Approve</button>';
								//$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/setting/prioritas/reg?action=reject&iprio_id='.$iprio_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_setprio_reg">Reject</button>';
									
								$buttons['update'] = $update.$approve;
							}
							else{}
						}
						else{
							
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
								var url = "'.base_url().'processor/plc/upb/setting/prioritas/reg";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_upb_setting_prioritas_reg").html(data);
									});
					
								}
									reload_grid("grid_upb_setting_prioritas_reg");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_upb_setting_prioritas_reg_approve" action="'.base_url().'processor/plc/upb/setting/prioritas/reg?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="iprio_id" value="'.$this->input->get('iprio_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_upb_setting_prioritas_reg_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$this->db_plc0->where('iprioritas_id', $post['iprio_id']);
		$this->db_plc0->update('plc2.plc2_upb_prioritas_reg', array('iappbusdev'=>2,'tappbusdev'=>$skg));
    
		$iprio_id=$post['iprio_id'];
		
		//get upb_id
		$qiupb="select distinct(pd.iupb_id) from plc2.plc2_upb_prioritas_reg_detail pd
					inner join plc2.plc2_upb_prioritas_reg pr on pr.iprioritas_id=pd.iprioritas_id
				where pd.iprioritas_id=$iprio_id";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		
		foreach($riu as $xx){
			$iupb_id=$xx['iupb_id'];
			$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$post['modul_id']); // activity 3 input data
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
			$hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,1); // status 7 => submit
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 1); // status 7 => submit
				//update last log
					$this->biz_process->update_last_log($iupb_id, $bizsup, 1);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 1); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($iupb_id, $bizsup, 1);
			}
		}
        
		$qry="select iyear,imonth,iteambusdev_id from plc2.plc2_upb_prioritas_reg pr 
				where pr.iprioritas_id=$iprio_id";
		$prio = $this->db_plc0->query($qry)->row_array();
             
        $bd = $prio['iteambusdev_id'];
             
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
        $cc = $arrEmail;
        
		$subject="Proses Setting Prioritas Registrasi Selesai";
		$content="
			Diberitahukan bahwa telah ada approval Setting Prioritas Registrasi UPB oleh Busdev Manager pada aplikasi PLC:<br><br>
			<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
				<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
					<tr>
						<td style='width: 110px;'><b>Tahun</b></td><td style='width: 20px;'> : 
                        </td><td>".$prio['iyear']."</td>
					</tr>
					<tr>
						<td><b>Semester</b></td><td> : </td><td>".$prio['imonth']."</td>
					</tr>
                    <tr>
                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>Registrasi - Input data oleh Busdev</td>
                    </tr>                    
				</table>
			</div>
			<br/> 
			Demikian. Terimakasih.<br><br><br>
			Post Master";
            
        /*echo  $to;
        echo '</br>cc:' .$cc;      
        echo  $content ;    
        exit ;*/
		$this->lib_utilitas->send_email($to, $cc, $subject, $content);
        
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
								var url = "'.base_url().'processor/plc/upb/setting/prioritas/reg";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_upb_setting_prioritas_reg").html(data);
									});
					
								}
									reload_grid("grid_upb_setting_prioritas_reg");
							}
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_upb_setting_prioritas_reg_reject" action="'.base_url().'processor/plc/upb/setting/prioritas/reg?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="iprio_id" value="'.$this->input->get('iprio_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea><button type="button" onclick="submit_ajax(\'form_upb_setting_prioritas_reg_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process () {
    	$post = $this->input->post();
    	$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
	 	$this->db_plc0->where('iprioritas_id', $post['iprio_id']);
		$this->db_plc0->update('plc2.plc2_upb_prioritas_reg', array('iappbusdev'=>1,'tappbusdev'=>$skg));
    
		$iprio_id=$post['iprio_id'];
		
		//get upb_id
		$qiupb="select distinct(pd.iupb_id) from plc2.plc2_upb_prioritas_reg_detail pd
					inner join plc2.plc2_upb_prioritas_reg pr on pr.iprioritas_id=pd.iprioritas_id
				where pd.iprioritas_id=$iprio_id";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		
		
		foreach($riu as $xx){
			$iupb_id=$xx['iupb_id'];
			$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$post['modul_id']); // activity 3 input data
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
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
		}
		
		$data['status']  = true;
    	$data['last_id'] = $iprio_id;
    	return json_encode($data);
    }
	
	function listBox_upb_setting_prioritas_reg_iappbusdev($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	//Keterangan approval 
	function insertBox_upb_setting_prioritas_reg_cnip($field, $id) {
		return '-';
	}
	function updateBox_upb_setting_prioritas_reg_cnip($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($rowData['iappbusdev'] <>0)){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cnip']))->row_array();
			if($rowData['iappbusdev']==2){$st="Approved";}elseif($rowData['iappbusdev']==1){$st="Rejected";
				// $rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// if(isset($rowa)){$reason=$rowa['treason'];}
				
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['cnip'].' )'.' pada '.$rowData['tappbusdev'];
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	//
	
    public function manipulate_grid_button($button) {
    	if($this->auth->is_manager()){}else{unset($button['create']);}
    	return $button;
    }
    public function listBox_Action($row, $actions) {
		
		if($this->auth->is_manager()){
			$teams = $this->auth->tipe();
			$man=$teams['manager'];
			if(in_array('BD',$man)){}
			else{
				unset($actions['edit']);
				unset($actions['delete']);
			}
		}
		else{
				unset($actions['edit']);
				unset($actions['delete']);
			}
		return $actions;
	}
	
	function listBox_upb_setting_prioritas_reg_iteambusdev_id ($value) {
		$teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$value))->row_array();
		return $teams['vteam'];
	}
	function listBox_upb_setting_prioritas_reg_imonth ($value) {
		return 'Semester '.$value;
	}
	function searchBox_upb_setting_prioritas_reg_imonth ($field, $id) {
		$this->load->config('plc_config');
		$echo = '<select class="required" id="'.$id.'" name="'.$field.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=1; $i<=2; $i++) {
			$echo .= '<option value="'.$i.'">Semester '.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	function searchBox_upb_setting_prioritas_reg_iteambusdev_id ($field, $id) {
		$sql = "SELECT * FROM ".$this->db_plc0->dbprefix('plc2.plc2_upb_team')." d WHERE d.vtipe = 'BD' AND d.iteam_id IN (".$this->auth->my_teams().") AND d.ldeleted = 0 ORDER BY d.vteam ASC ";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select id="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		foreach($teams as $t) {
			$echo .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	function searchBox_upb_setting_prioritas_reg_iyear ($field, $id) {
		$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-2;
		$sampai = $thn_sekarang+7;
		$echo = '<select id="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=$mulai; $i<=$sampai; $i++) {
			$echo .= '<option value="'.$i.'">'.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	function insertBox_upb_setting_prioritas_reg_iyear ($field, $id) {
		$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-2;
		$sampai = $thn_sekarang+7;
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=$mulai; $i<=$sampai; $i++) {
			$echo .= '<option value="'.$i.'">'.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}

	function updateBox_upb_setting_prioritas_reg_iyear ($field, $id, $value, $rowData) {
		$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-2;
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

	function insertBox_upb_setting_prioritas_reg_iteambusdev_id ($field, $id) {
		$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'BD' AND d.iteam_id IN (".$this->auth->my_teams().") AND d.ldeleted = 0 ORDER BY d.vteam ASC ";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		foreach($teams as $t) {
			$echo .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	function updateBox_upb_setting_prioritas_reg_iteambusdev_id ($field, $id, $value, $rowData) {
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
		if($type=='BD'){
			$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'BD' AND d.iteam_id IN (".$this->auth->my_teams().") AND d.ldeleted = 0 ORDER BY d.vteam ASC ";
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
			return $teams['vteam'];
		}
	}
	
	function insertBox_upb_setting_prioritas_reg_imonth ($field, $id) {
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=1; $i<=2; $i++) {
			$echo .= '<option value="'.$i.'">Semester '.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	function updateBox_upb_setting_prioritas_reg_imonth ($field, $id, $value, $rowData) {
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=1; $i<=2; $i++) {
			$selected = $value == $i ? 'selected' : '';
			$echo .= '<option '.$selected.' value="'.$i.'">Semester '.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	function insertBox_upb_setting_prioritas_reg_rincian_upb ($field, $id) {
		$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'PD' AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
		$data['team_pd'] = $this->db_plc0->query($sql)->result_array();
		$data['browse_url'] = base_url().'processor/plc/browse/upb/setreg?action=index';
		return $this->load->view('upb_setting_prioritas_reg_rincian_upb',$data,TRUE);
	}
	
	function updateBox_upb_setting_prioritas_reg_rincian_upb ($field, $id, $value, $rowData) {
		$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'PD' AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
		$data['team_pd'] = $this->db_plc0->query($sql)->result_array();
		$data['browse_url'] = base_url().'processor/plc/browse/upb/setreg?action=index';
		$data['iprioritas_id'] = $rowData['iprioritas_id'];
		return $this->load->view('upb_setting_prioritas_reg_rincian_upb_edit',$data,TRUE);
	}

	function before_insert_processor($row, $postData) {
		$user = $this->auth->user();
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = date('Y-m-d H:i:s', mktime());
		unset($postData['iupb_id']);
		unset($postData['iupb_nomor']);
		unset($postData['rincian_upb']);
		//print_r($postData); exit;
		return $postData;
	}

	function after_insert_processor($row, $insertId, $postData) {
		$det = array();
		
		$bobot = 1;
		foreach($postData['iupb_id'] as $k=>$v) {
			foreach($v as $uk => $uv) {
				if($uv != '') {
					$det['iprioritas_id'] = $insertId;
					$det['iupb_id'] = $uv;
					$det['ibobot'] = $bobot;
					$det['iteampd_id'] =$k ; 
					$bobot++;
					try {
						$this->db_plc0->insert('plc2.plc2_upb_prioritas_reg_detail', $det);
					}catch(Exception $e) {
						die('salah!');
					}
				}
			}					
		}
		//get upb_id
		$qiupb="select distinct(pd.iupb_id) from plc2.plc2_upb_prioritas_reg_detail pd
					inner join plc2.plc2_upb_prioritas_reg pr on pr.iprioritas_id=pd.iprioritas_id
				where pd.iprioritas_id=$insertId";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		
		foreach($riu as $xx){
			$iupb_id=$xx['iupb_id'];
			$getbp=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // activity 3 input data
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
	}
	
	function before_update_processor($row, $postData, $newUpdateData) {
		$user = $this->auth->user();
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = date('Y-m-d H:i:s', mktime());
		unset($postData['iupb_id']);
		unset($postData['iupb_nomor']);
		unset($postData['rincian_upb']);
		return $postData;
	}
	function after_update_processor($row, $insertId, $postData, $old_data) {
		$det = array();		
		$bobot = 1;
		//print_r($postData['iupb_id']);
		$this->db_plc0->where('iprioritas_id', $insertId);
		if($this->db_plc0->update('plc2.plc2_upb_prioritas_reg_detail', array('ldeleted'=>1))) {
			foreach($postData['iupb_id'] as $k=>$v) {
				foreach($v as $uk => $uv) {
					if($uv != '') {
						$det['iprioritas_id'] = $insertId;
						$det['iupb_id'] = $uv;
						$det['ibobot'] = $bobot;
						$det['iteampd_id'] =$k ; 
						$bobot++;
						try {
							$this->db_plc0->insert('plc2.plc2_upb_prioritas_reg_detail', $det);
						}catch(Exception $e) {
							die('salah!');
						}
					}
				}					
			}
		}
		//get upb_id
		$qiupb="select distinct(pd.iupb_id) from plc2.plc2_upb_prioritas_reg_detail pd
					inner join plc2.plc2_upb_prioritas_reg pr on pr.iprioritas_id=pd.iprioritas_id
				where pd.iprioritas_id=$insertId";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		
		foreach($riu as $xx){
			$iupb_id=$xx['iupb_id'];
			$getbp=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // activity 3 input data
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
	}
	function insertCheck_upb_setting_prioritas_reg_iyear($value, $field, $rows) {
		//print_r($value); exit;
		
		$year = $value;
		$month = $rows['imonth'];
		$teambd = $rows['iteambusdev_id'];
		
		$this->db_plc0->where('iteambusdev_id', $teambd);		
		$this->db_plc0->where('iyear', $year);
		$this->db_plc0->where('imonth', $month);
		$this->db_plc0->where('ldeleted',0);
		$j = $this->db_plc0->count_all_results('plc2.plc2_upb_prioritas_reg');
		if($j > 0) {
			return ' Insert Prioritas pada periode '.$year.' Semester '.$month.' sudah pernah di input, harap pilih periode lain';
		} 
		else {
			return TRUE;
		}
		
	}
	
	/*function updateCheck_upb_setting_prioritas_reg_iyear($value, $field, $rows) {
		//print_r($value); exit;
		
		/*$year = $value;
		$month = $rows['imonth'];
		$teambd = $rows['iteambusdev_id'];
		
		$this->db_plc0->where('iteambusdev_id', $teambd);		
		$this->db_plc0->where('iyear', $year);
		$this->db_plc0->where('imonth', $month);
		$this->db_plc0->where('ldeleted',0);
		$j = $this->db_plc0->count_all_results('plc2.plc2_upb_prioritas_reg');
		if($j > 0) {
			return ' Insert Prioritas pada periode '.$year.' Semester '.$month.' sudah pernah di input, harap pilih periode lain';
		} 
		else {
			return TRUE;
		}
		
	}
	*/
	/*public function listBox_action($row, $action) {
		if($row->iyear == '2012') {
			$action['edit'] = 'NO Edit';
		}
		return $action;
	}*/
}
