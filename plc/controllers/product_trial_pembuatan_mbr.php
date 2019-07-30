<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_trial_pembuatan_mbr extends MX_Controller {
	var $_url;
	var $dbset;
	function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->user = $this->auth->user();
        $this->load->library('lib_utilitas');
		$this->load->library('biz_process');
		$this->load->library('lib_flow');
		$this->load->helper(array('tanggal','to_mysql','mydb'));
		$this->load->model('user_model');
		$this->dbset = $this->load->database('plc', true);
		$this->url = 'product_trial_pembuatan_mbr';
    }
    function index($action = '') {
    	$grid = new Grid;	
		$grid->setFormUpload(TRUE);	
		$grid->setTitle('Pembuatan MBR');
		$grid->setUrl('product_trial_pembuatan_mbr');
		$grid->setTable('plc2.plc2_upb_formula');
		$grid->setJoinTable('plc2.plc2_upb','plc2_upb_formula.iupb_id = plc2_upb.iupb_id','inner');
		$grid->setJoinTable('plc2.plc2_upb_buat_mbr','plc2_upb_buat_mbr.ifor_id = plc2_upb_formula.ifor_id','left');
		$grid->addList('vkode_surat','plc2_upb.vupb_nomor','plc2_upb_buat_mbr.no_mbr','plc2_upb_buat_mbr.dbuat_mbr','plc2_upb_buat_mbr.isubmit','plc2_upb_buat_mbr.iapppd_bm');		
		$grid->setSortBy('vkode_surat');
		$grid->setSortOrder('DESC');
		$grid->setSearch('vkode_surat','plc2_upb.vupb_nomor');
		
		//$grid->changeFieldType('plc2_upb_buat_mbr.iapppd_bm','combobox','',array(''=>'-', 0=>'Waiting For Approval', 2=>'Approved', 1=>'Reject'));
		
		// $grid->setAlign('plc2_upb.vupb_nomor', 'center');
		// $grid->setWidth('plc2_upb.vupb_nomor', '100');
		// $grid->setWidth('plc2_upb.vupb_nama', '250');
		// $grid->setWidth('plc2_upb.vgenerik', '250');
		//$grid->addFields('vkode_surat','no_mbr','dbuat_mbr','dtgl_appr_1','dtgl_appr_2','dtgl_release','dtgl_buat_draft','dtgl_periksa_draft');
		//$grid->addFields('dtgl_mulai_edar','dtgl_kembali_draft','vnip_apppd_bm');
		
		$grid->addFields('vkode_surat','no_mbr','dbuat_mbr','dtgl_appr_1','dtgl_appr_2','dtgl_appr_3','dtgl_appr_4','vnip_apppd_bm');	

		$grid->setRequired('no_mbr','dbuat_mbr','dtgl_appr_1','dtgl_appr_2','dtgl_appr_3','dtgl_appr_4');
		$grid->setLabel('plc2_upb_buat_mbr.dbuat_mbr','Tgl Buat MBR');
		$grid->setLabel('plc2_upb_buat_mbr.isubmit','Status Submit');
		$grid->setWidth('plc2_upb.vupb_nomor','100');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('plc2_upb_buat_mbr.no_mbr', 'No. MBR');
		$grid->setLabel('plc2_upb_buat_mbr.dtgl_release', 'Tanggal Release');
		$grid->setLabel('plc2_upb_buat_mbr.dtgl_mulai_edar', 'Tanggal Mulai Edar');
		$grid->setLabel('plc2_upb_buat_mbr.iapppd_bm','Approval PD');
		$grid->setLabel('vkode_surat','No Formula');
		$grid->setLabel('no_mbr', 'No. MBR');
		$grid->setLabel('dbuat_mbr', 'Tanggal Pembuatan MBR');
		$grid->setLabel('dtgl_appr_1', 'Tanggal Approve I');
		$grid->setLabel('dtgl_appr_2', 'Tanggal Approve II');
		$grid->setLabel('dtgl_appr_3', 'Tanggal Approve III');
		$grid->setLabel('dtgl_appr_4', 'Tanggal Approve IV');

		$grid->setLabel('dtgl_release', 'Tanggal Release');
		$grid->setLabel('dtgl_buat_draft', 'Tanggal Pembuatan Draft MBR');
		$grid->setLabel('dtgl_periksa_draft', 'Tanggal Periksa Draft MBR');
		$grid->setLabel('dtgl_mulai_edar', 'Tanggal Edar Draft MBR');
		$grid->setLabel('dtgl_kembali_draft', 'Tanggal Kembali Draft MBR');		
		$grid->setLabel('vnip_apppd_bm', 'PD Approval');
		$grid->setLabel('iapppd_bm', 'PD Approval');


		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
			}elseif(in_array('QC', $manager)){
				$type='QC';
				$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth->my_teams().')',null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
			}elseif(in_array('QC', $manager)){
				$type='QC';
				$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth->my_teams().')',null);
			}
			else{$type='';}
		}
		
		$grid->setQuery('plc2_upb_formula.ldeleted', 0);	
		//$grid->setQuery('plc2.plc2_upb_formula.ibest', 2); //yg best formula
		//$grid->setQuery('plc2_upb_formula.iupb_id in ()', null); //yg sudah approve bahan kemas
		$grid->setQuery('plc2_upb_formula.iapp_basic',2);
		$grid->setQuery('plc2_upb_formula.iapppd_basic',2);
		$grid->setQuery('plc2_upb.ihold', 0);
		
		//echo $this->db_plc0->last_query();
		
		
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
				$grid->render_form($this->input->get('id'), TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'detail':
				$this->detail();
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
				//echo $this->db_plc0->last_query();
				$grid->render_grid();
				break;
		}
    }

	function manipulate_update_button($buttons, $rowData) {
		unset($buttons['update_back']);
    	unset($buttons['update']);
		
		$user = $this->auth->user();
		//print_r($rowData);
    	$x=$this->auth->dept();
    	if($this->auth->is_manager()){
    		$x=$this->auth->dept();
    		$manager=$x['manager'];
    		if(in_array('PD', $manager)){$type='PD';}
			elseif(in_array('QC', $manager)){$type='QC';}
    		else{$type='';}
    	}
		else{
			$x=$this->auth->dept();
    		$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';}
			elseif(in_array('QC', $team)){$type='QC';}
			else{$type='';}
		}
		// cek status upb, klao upb 
			unset($buttons['update_back']);
    		unset($buttons['update']);
			
			//echo $this->auth->my_teams();
			
    		$ifor_id=$rowData['ifor_id'];
			
			$this->db_plc0->where('ifor_id', $ifor_id);		
			$this->db_plc0->where('ldeleted', '0'); //tambahin ldeleted=0			
			$j = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
			//echo $j;exit();
		
			if ($j > 0){
				$qcek="select * from plc2.plc2_upb_buat_mbr f where f.ifor_id=$ifor_id";
				$rcek = $this->db_plc0->query($qcek)->row_array();
				$rowData['ibuatmbr_id']=$rcek['ibuatmbr_id'];
			}
			else {				
				$rcek['iapppd_bm'] = 0;
				$j=0;
				$rowData['ibuatmbr_id']=0;
			}
			$update = '<button onclick="javascript:update_btn_back(\'product_trial_pembuatan_mbr\', \''.base_url().'processor/plc/product/trial/pembuatan/mbr?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_product_trial_pembuatan_mbr">Update & Submit</button>';
			$updatedraft = '<button onclick="javascript:update_draft_btn(\'product_trial_pembuatan_mbr\', \''.base_url().'processor/plc/product/trial/pembuatan/mbr?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_product_trial_pembuatan_mbr">Update as Draft</button>';
			$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/pembuatan/mbr?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&imbr_id='.$rowData['ibuatmbr_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_buat_mbr">Approve</button>';
			$js=$this->load->view('product_trial_pembuatan_mbr_js');
			if($this->auth->is_manager()){ //jika manager PD
				if($type=='PD'){
					if($rcek['iapppd_bm']==0){
						$buttons['update'] = $approve;
					}else{}
				}
				elseif($type=='QC'){
					if($j!=0){
						if($rcek['isubmit']==0){
							$buttons['update'] = $updatedraft.$update.$js;
						}else{}
					}else{
						$buttons['update'] = $updatedraft.$update.$js;
					}
				}
				else{}
			}
			else{
				if($type=='PD'){
					if($rcek['iapppd_bm']==0){
						$buttons['update'] = $approve;
					}else{}
				}
				elseif($type=='QC'){
					if($j!=0){
						if($rcek['isubmit']==0){
							$buttons['update'] = $updatedraft.$update.$js;
						}else{}
					}else{
						$buttons['update'] = $updatedraft.$update.$js;
					}
				}
				else{}
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
								var url = "'.base_url().'processor/plc/product/trial/pembuatan/mbr";
								if(o.status == true) {
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_product_trial_pembuatan_mbr").html(data);
									});
					
								}
									reload_grid("grid_product_trial_pembuatan_mbr");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_product_trial_pembuatan_mbr_approve" action="'.base_url().'processor/plc/product/trial/pembuatan/mbr?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
    			<input type="hidden" name="ifor_id" value="'.$this->input->get('ifor_id').'" />
    			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_product_trial_pembuatan_mbr_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
	 	$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$iapprove = $post['type'] == 'PD' ? 'iapppd_bm' : '';
		$this->db_plc0->update('plc2.plc2_upb_buat_mbr', array($iapprove=>2,'vnip_apppd_bm'=>$nip,'tapppd_bm'=>$skg));
    
    	$upbid = $post['iupb_id'];
	
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
   	
		$ifor_id=$this->input->post('ifor_id');
		//$mbr_id=$this->input->post('ibuatmbr_id');
        $ins2['ifor_id']=$ifor_id;
		$this->db_plc0->insert('plc2.plc2_upb_prodpilot', $ins2);
		$this->lib_flow->insert_logs($post['modul_id'],$upbid,9,2);
        /*        
		$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$post['modul_id']); // 1 approval
		$bizsup=$getbp['idplc2_biz_process_sub'];
		
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
		}*/
	
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
        //$bd = $rsql['iteambusdev_id'];
        //$qa = $rsql['iteamqa_id'];

        $team = $pd ;

        $toEmail2='';
        $toEmail = $this->lib_utilitas->get_email_team( $team );
        //$toEmail2 = $this->lib_utilitas->get_email_leader( $team );                        

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
        $subject="Proses Pembuatan MBR Selesai: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval UPB oleh PD Manager pada proses Pembuatan MBR(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
                                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>Produksi Pilot - Input data oleh PD</td>
                                </tr>
                        </table>
                </div>
                <br/> 
                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
                Post Master";
        $this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		$data['status']  = true;
    	$data['last_id'] = $ifor_id;
    	return json_encode($data);
    }
  
	function listBox_product_trial_pembuatan_mbr_plc2_upb_buat_mbr_iapppd_bm($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	//Keterangan approval 
	function updateBox_product_trial_pembuatan_mbr_vnip_apppd_bm($field, $id, $value, $rowData) {
		//print_r($rowData);
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			if(($row['iapppd_bm'] > 0)){
				$roww = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$row['vnip_apppd_bm']))->row_array();
				if($row['iapppd_bm']==2){$st="Approved";}
				elseif($row['iapppd_bm']==1){$st="Rejected";} 
				$ret= $st.' oleh '.$roww['vName'].' ( '.$row['vnip_apppd_bm'].' )'.' pada '.$row['tapppd_bm'];
			}
			else{
				$ret='Waiting for Approval';
			}	
		}
		else{
			$ret='Waiting for Approval';
		}
		return $ret;
	}
	
	function updateBox_product_trial_pembuatan_mbr_vkode_surat($name, $id, $value) {
		return $value;
	}
	
	function updateBox_product_trial_pembuatan_mbr_no_mbr($field, $id, $value, $rowData) {
	//print_r($rowData);
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			if($this->input->get('action')=='view'){
				return $row['no_mbr'];
			}else{
				return '<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="15" value="'.$row['no_mbr'].'"/>';
			}
		}
		else{
			if($this->input->get('action')=='view'){
				return '-';
			}else{
				return '<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="15"/>';
			}
		}
		
	}
	function updateBox_product_trial_pembuatan_mbr_dbuat_mbr($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$value=$row['dbuat_mbr'];
			$value=date("d-m-Y", strtotime($value));
			if($this->input->get('action')=='view'){
				$return	=date("d-m-Y", strtotime($value));
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" value='.$value.' />';
				$return .= '<input type="hidden" name="isdraft" id="isdraft">';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
		else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" />';
				$return .= '<input type="hidden" name="isdraft" id="isdraft">';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
		
	}
	function updateBox_product_trial_pembuatan_mbr_dtgl_appr_1($field, $id, $value, $rowData) {

		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$value=$row['dtgl_appr_1'];
			$value=date("d-m-Y", strtotime($value));
			if($this->input->get('action')=='view'){
				$return	=date("d-m-Y", strtotime($value));
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" value='.$value.' />';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
		else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" />';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
	}
	function updateBox_product_trial_pembuatan_mbr_dtgl_appr_2($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$value=$row['dtgl_appr_2'];
			$value=date("d-m-Y", strtotime($value));
			if($this->input->get('action')=='view'){
				$return	=date("d-m-Y", strtotime($value));
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" value='.$value.' />';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
		else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" />';
				$return .=	'<script>
								$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
	}
	function updateBox_product_trial_pembuatan_mbr_dtgl_appr_3($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$value=$row['dtgl_appr_2'];
			$value=date("d-m-Y", strtotime($value));
			if($this->input->get('action')=='view'){
				$return	=date("d-m-Y", strtotime($value));
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" value='.$value.' />';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
		else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" />';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
	}
	function updateBox_product_trial_pembuatan_mbr_dtgl_appr_4($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$value=$row['dtgl_appr_2'];
			$value=date("d-m-Y", strtotime($value));
			if($this->input->get('action')=='view'){
				$return	=date("d-m-Y", strtotime($value));
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" value='.$value.' />';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
		else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" />';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
	}/*
	function updateBox_product_trial_pembuatan_mbr_dtgl_release($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$this->load->helper('to_mysql');
			$value=$row['dtgl_release'];
			$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
			$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
			return $return;
		}
		else{
			return '<input type="text" name="'.$id.'" id="'.$id.'" class="input_tgl datepicker input_rows1 required" size="10"/>';
		}
	}
	function updateBox_product_trial_pembuatan_mbr_dtgl_periksa_draft($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$this->load->helper('to_mysql');
			$value=$row['dtgl_periksa_draft'];
			$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
			$return = '<input type="text" class="input_tgl datepicker input_rows1 required" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
			return $return;
		}
		else{
			return '<input type="text" name="'.$id.'" id="'.$id.'" class="input_tgl datepicker input_rows1 required" size="10"/>';
		}
	}
	function updateBox_product_trial_pembuatan_mbr_dtgl_mulai_edar($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$this->load->helper('to_mysql');
			$value=$row['dtgl_mulai_edar'];
			$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
			$return = '<input type="text" class="input_tgl datepicker input_rows1 required" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
			return $return;
		}
		else{
			return '<input type="text" name="'.$id.'" id="'.$id.'" class="input_tgl datepicker input_rows1 required" size="10"/>';
		}
	}
	function updateBox_product_trial_pembuatan_mbr_dtgl_kembali_draft($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$this->load->helper('to_mysql');
			$value=$row['dtgl_kembali_draft'];
			$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
			$return = '<input type="text" class="input_tgl datepicker input_rows1 required" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
			return $return;
		}
		else{
			return '<input type="text" name="'.$id.'" id="'.$id.'" class="input_tgl datepicker input_rows1 required" size="10"/>';
		}
	}
	function updateBox_product_trial_pembuatan_mbr_dtgl_buat_draft($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$this->load->helper('to_mysql');
			$value=$row['dtgl_buat_draft'];
			$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
			$return = '<input type="text" class="input_tgl datepicker input_rows1 required" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
			return $return;
		}
		else{
			return '<input type="text" name="'.$id.'" id="'.$id.'" class="input_tgl datepicker input_rows1 required" size="10"/>';
		}
	}*/
	 function listBox_Action($row, $actions) {
    	 // // jika formula sudah di app tidak bisa di edit
	 	//print_r($row);exit();
		$ifor_id=$row->ifor_id;
		$this->db_plc0->where('ifor_id',$ifor_id);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sel="select * from plc2.plc2_upb_buat_mbr where ifor_id=$ifor_id";
			$roww = $this->db_plc0->query($sel)->row_array();
			if($roww['iapppd_bm'] > 0){
				unset($actions['edit']);
				unset($actions['delete']);
			}
		}
		return $actions;
     }

	function listBox_product_trial_pembuatan_mbr_plc2_upb_buat_mbr_isubmit($value){
		if($value==0){$vstatus='Draft - Need To Submit';}
		elseif($value==1){$vstatus='Submited';}
		return $vstatus;
	}

	function output(){
    	$this->index($this->input->get('action'));
    }
    
    function before_update_processor($row, $postData) {
    	unset($postData['vkode_surat']);
    	unset($postData['product_trial_pembuatan_mbr_ifor_id']);
    	unset($postData['product_trial_pembuatan_mbr_no_mbr']);
    	unset($postData['product_trial_pembuatan_mbr_dbuat_mbr']);
    	unset($postData['product_trial_pembuatan_mbr_dtgl_appr_1']);
    	unset($postData['product_trial_pembuatan_mbr_dtgl_appr_2']);
    	unset($postData['product_trial_pembuatan_mbr_dtgl_appr_3']);
    	unset($postData['product_trial_pembuatan_mbr_dtgl_appr_4']);
    	$postData['dbuat_mbr']=date("Y-m-d", strtotime($postData['dbuat_mbr']));
    	$postData['dtgl_appr_1']=date("Y-m-d", strtotime($postData['dtgl_appr_1']));
    	$postData['dtgl_appr_2']=date("Y-m-d", strtotime($postData['dtgl_appr_2']));
    	$postData['dtgl_appr_3']=date("Y-m-d", strtotime($postData['dtgl_appr_3']));
    	$postData['dtgl_appr_4']=date("Y-m-d", strtotime($postData['dtgl_appr_4']));
    	if($postData['isdraft']==true){
			$postData['isubmit']=0;
		}else{$postData['isubmit']=1;}
		return $postData;
    }
	function after_update_processor($row, $updateId, $postData) {			
		//print_r($postData);exit();
		$this->load->helper('search_array');
		$post = $this->input->post();
		
		//$this->load->helper('to_mysql');
		$skrg = date('Y-m-d H:i:s');
		
		$ifor_id=$postData['ifor_id'];
		$this->dbset->where('ifor_id',$ifor_id);		
		$j2 = $this->dbset->count_all_results('plc2.plc2_upb_buat_mbr');
			//data
			$data['ifor_id'] = $postData['ifor_id'];
			$data['no_mbr'] = $postData['no_mbr'];
			$data['dbuat_mbr'] =$postData['dbuat_mbr'];
			$data['dtgl_appr_1'] =$postData['dtgl_appr_1'];
			$data['dtgl_appr_2'] = $postData['dtgl_appr_2'];
			$data['dtgl_appr_3'] = $postData['dtgl_appr_3'];
			$data['dtgl_appr_4'] = $postData['dtgl_appr_4'];
			$data['isubmit'] = $postData['isubmit'];
		if($j2 > 0){
			//update data
			$this->dbset->where('ifor_id',$data['ifor_id']);
			$this->dbset->update('plc2.plc2_upb_buat_mbr', array('no_mbr'=>$data['no_mbr'],'dbuat_mbr'=>$data['dbuat_mbr'],'dtgl_appr_1'=>$data['dtgl_appr_1'],
																'dtgl_appr_2'=>$data['dtgl_appr_2'],'dtgl_appr_3'=>$data['dtgl_appr_3'],'dtgl_appr_4'=>$data['dtgl_appr_4'],'isubmit'=>$data['isubmit']));
		}
		else{
			//insert data
			$this->dbset->insert('plc2_upb_buat_mbr',$data);
		}
		$sel="select * from plc2.plc2_upb_formula f where f.ifor_id=$ifor_id";
		$rowb = $this->db_plc0->query($sel)->row_array();
		$iupb_id=$rowb['iupb_id'];
		if($postData['isubmit']==1){
			$this->lib_flow->insert_logs($this->input->get('modul_id'),$iupb_id,7);
		}
	}
}
