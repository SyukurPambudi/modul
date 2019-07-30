<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sample_penerimaan_sample extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->load->library('lib_flow');
		$this->user = $this->auth->user();
		$this->load->library('biz_process');
        $this->load->library('lib_utilitas');
		$this->_table = 'plc2.plc2_upb_ro';
		$this->_table_po = 'plc2.plc2_upb_po';
		$this->_table_supplier = 'hrd.mnf_supplier';
		$this->_table_employee = 'hrd.employee';
		$this->load->helper('to_mysql');
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('Penerimaan Sample');		
		$grid->setTable($this->_table);		
		$grid->setUrl('sample_penerimaan_sample');
		
		$grid->addFields('vro_nomor','vpo_nomor','iclose_po','trequest','isupplier_id','detail_batch','detail_terima_sample','vnip_pur');		
		$grid->setRequired('iclose_po','trequest','isupplier_id');

		$grid->addList('vro_nomor','plc2_upb_po.vpo_nomor','iclose_po','trequest','cnip','employee.vName','iapppr');
		
		$grid->setJoinTable($this->_table_po, $this->_table_po.'.ipo_id = '.$this->_table.'.ipo_id', 'inner');
		$grid->setJoinTable($this->_table_supplier, $this->_table_supplier.'.isupplier_id = '.$this->_table_po.'.isupplier_id', 'left');
		$grid->setJoinTable($this->_table_employee, $this->_table_employee.'.cNip = '.$this->_table.'.cnip', 'left');
		
		$grid->setSortBy('vro_nomor');
		$grid->setSortOrder('desc');
		$grid->setSearch('plc2_upb_po.vpo_nomor','trequest','cnip','employee.vName');
		$grid->setFormWidth('vpo_nomor', 50);
		$grid->setFormWidth('vro_nomor', 50);
		$grid->setFormWidth('trequest', 50);
		$grid->setFormWidth('cnip', 20);
		$grid->setFormWidth('employee.vName', 120);
		
		$grid->setLabel('cnip', 'NIP');
		$grid->setLabel('employee.vName', 'Nama');
		$grid->setLabel('vro_nomor', 'No. RO');
		$grid->setLabel('vpo_nomor', 'No. PO');
		$grid->setLabel('plc2_upb_po.vpo_nomor', 'No. PO');
		$grid->setLabel('iclose_po', 'Tutup PO');
		$grid->setLabel('trequest', 'Tanggal Terima');
		$grid->setLabel('isupplier_id','Supplier');
		$grid->setLabel('detail_batch','Detail Batch');		
		$grid->setLabel('detail_terima_sample','Detail Terima Sample');		
		$grid->setLabel('vnip_pur','Approval Purchasing');		
		$grid->setLabel('iapppr','Approval Purchasing');
	
		
		$grid->setQuery('plc2_upb_ro.ldeleted', 0);
		
		$grid->changeFieldType('iclose_po', 'combobox', '', array(''=>'--select--', 1=>'Ya', 0=>'Tidak'));
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				//$grid->saved_form();
				echo $grid->saved_form();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'delete':
				echo $grid->delete_row();
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
			default:
				$grid->render_grid();
				break;
		}
    }
	public function listBox_Action($row, $actions) {
    	unset($actions['delete']);
		//cek apakah sudah diapprove,
		if(($row->iapppr==2)||($row->iapppr==1)){
			unset($actions['edit']);
			unset($actions['delete']);
		}
		return $actions;
    }

/*
    function manipulate_insert_button($buttons) {
		unset($buttons['save']);
		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'sample_penerimaan_sample\', \''.base_url().'processor/plc/sample/penerimaan/sample?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_sample_penerimaan_sample">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'sample_penerimaan_sample\', \''.base_url().'processor/plc/sample/penerimaan/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_sample_penerimaan_sample">Save &amp; Submit</button>';
		$js = $this->load->view('lokal/sample_penerimaan_sample_js');
		$buttons['save'] = $save_draft.$save.$js;

		return $buttons;
	}
*/
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
				if(in_array('PR', $manager)){$type='PR';}
				else{$type='';}
			}
			else{
				$x=$this->auth->dept();
				$team=$x['team'];
				if(in_array('PR', $team)){$type='PR';}
				else{$type='';}
			}
			// cek status upb, klao upb 
				unset($buttons['update_back']);
				unset($buttons['update']);
				
				//echo $this->auth->my_teams();
				
				$ipo_id=$rowData['ipo_id'];
				$iro_id=$rowData['iro_id'];
				$iclose_po=$rowData['iclose_po'];
				
				//get upb_id
				$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
							select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
				$riu = $this->db_plc0->query($qiupb)->result_array();
				//print_r($riu);

				$qcek="select * from plc2.plc2_upb_ro f where f.iro_id=$iro_id";
				$rcek = $this->db_plc0->query($qcek)->row_array();
				//print_r($rcek);
				$x=$this->auth->my_teams();
				//print_r($x);
				$arrhak=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
				//print_r($arrhak);
				//if(empty($arrhak)){
					$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
					
			//		if(empty($getbp)){}
			//		else{
						if($this->auth->is_manager()){ //jika manager PR
							//jika blm approve dan sudah tutup PO
							if(($type=='PR')&&($iclose_po==1)&&($rcek['iapppr']==0)){
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/sample/penerimaan/sample?action=approve&ipo_id='.$ipo_id.'&iro_id='.$iro_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Approve</button>';
								//$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/sample/penerimaan/sample?action=reject&ipo_id='.$ipo_id.'&iro_id='.$iro_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Reject</button>';
									
								//$buttons['update'] = $approve.$reject;
								$buttons['update'] = $approve;
							}
							//jika blm approve dan blm tutup PO bisa update
							if(($type=='PR')&&($rcek['iapppr']==0)&&($iclose_po==0)){
								$update = '<button onclick="javascript:update_btn_upload(\'sample_penerimaan_sample\', \''.base_url().'processor/plc/sample/penerimaan/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_sample_penerimaan_sample">Update</button>';
								
								$buttons['update'] = $update;
							}
							//jika blm approve dan blm tutup PO bisa update
							if(($type=='PR')&&($rcek['iapppr']==1)){
								$buttons['update'] ='';
							}
							else{}
						}
						else{
							if(($type=='PR')&&($rcek['iapppr']==0)&&($iclose_po==0)){
								$update = '<button onclick="javascript:update_btn_upload(\'sample_penerimaan_sample\', \''.base_url().'processor/plc/sample/penerimaan/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_sample_penerimaan_sample">Update</button>';
								$buttons['update'] = $update;
							}
						}
			//		}
			/*
				}else{
					if($this->auth->is_manager()){ //jika manager PR
							//jika blm approve dan sudah tutup PO
							if(($type=='PR')&&($iclose_po==1)&&($rcek['iapppr']==0)){
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/sample/penerimaan/sample?action=approve&ipo_id='.$ipo_id.'&iro_id='.$iro_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Approve</button>';
								$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/sample/penerimaan/sample?action=reject&ipo_id='.$ipo_id.'&iro_id='.$iro_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Reject</button>';
									
								$buttons['update'] = $approve.$reject;
							}
							//jika blm approve dan blm tutup PO bisa update
							if(($type=='PR')&&($rcek['iapppr']==0)&&($iclose_po==0)){
								$update = '<button onclick="javascript:update_btn_upload(\'sample_penerimaan_sample\', \''.base_url().'processor/plc/sample/penerimaan/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_sample_penerimaan_sample">Update</button>';
								
								$buttons['update'] = $update;
							}
							//jika blm approve dan blm tutup PO bisa update
							if(($type=='PR')&&($rcek['iapppr']==1)){
								$buttons['update'] ='';
							}
							else{}
						}
					else{
						if(($type=='PR')&&($rcek['iapppr']==0)&&($iclose_po==0)){
							$update = '<button onclick="javascript:update_btn_upload(\'sample_penerimaan_sample\', \''.base_url().'processor/plc/sample/penerimaan/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_sample_penerimaan_sample">Update</button>';
							$buttons['update'] = $update;
						}
					}
				}
			*/				
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
								var url = "'.base_url().'processor/plc/sample/penerimaan/sample";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_sample_penerimaan_sample").html(data);
									});
					
								}
									reload_grid("grid_sample_penerimaan_sample");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_sample_penerimaan_sample_approve" action="'.base_url().'processor/plc/sample/penerimaan/sample?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="ipo_id" value="'.$this->input->get('ipo_id').'" />
				<input type="hidden" name="iro_id" value="'.$this->input->get('iro_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_sample_penerimaan_sample_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$iapprove = $post['type'] == 'PR' ? 'iapppr' : '';
		$this->db_plc0->where('iro_id', $post['iro_id']);
		$this->db_plc0->update('plc2.plc2_upb_ro', array($iapprove=>2,'vnip_pur'=>$nip,'tapp_pur'=>$skg));
    
    	$ipo_id = $post['ipo_id'];
    	$iro_id = $post['iro_id'];
        
        $po_row =  $this->db_plc0->get_where('plc2.plc2_upb_po', array('ipo_id'=>$post['ipo_id']))->row_array(); 
        $po_nomor = $po_row['vpo_nomor'];
        
		//get upb_id
        /*
		$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
					select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
                    */
         
        $row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$nip))->row_array(); 
        $vName =  $row['vName'];            
        $a="
			<html>
			<head>
			<style type='text/css'>
			  body, table, tr, th, td, select, a {font-size: 9pt;font-family:tahoma;}
			  table.tbl3 {border-collapse: collapse; border: 1px solid black; font-size: 10px;}
			  tr.tr3, td.td3 {border: 1px solid black; background: #FFFFFF;}
			  tr.tr4, th.th3 {border: 1px solid black; background: #AAAAAA; color: #000000}
			</style>
			</head>
			<body>
			<div><h5>Diberitahukan bahwa telah ada Approval penerimaan PO(" .$po_nomor.") oleh Purchasing (NIP:".$nip." - ".$vName." ) pada aplikasi PLC dengan rincian sebagai berikut :<br><br></h5></div>
			<table class='tbl3' style='width: 100%' width='100%' border='0' cellspacing='0' cellpadding='2'>
			<thead>
				<tr class='tr4'>				
					<th class='th3' style='text-align: center; vertical-align: middle;'>No Permintaan</th>
					<th class='th3' style='text-align: center; vertical-align: middle;'>Bahan Baku</th>
					<th class='th3' style='text-align: center; vertical-align: middle;'>Jumlah Permintaan</th>																
					<th class='th3' style='text-align: center; vertical-align: middle;'>Jumlah Terima</th>
				</tr>
			</thead>";                    
        
        $qiupb = "select distinct(rs.iupb_id), u.vupb_nomor, u.vupb_nama, u.vgenerik,
    				(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
    				(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
    				(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
    				(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
                    from plc2.plc2_upb_request_sample rs 
                    left outer join plc2.plc2_upb u on u.iupb_id = rs.iupb_id
                    where rs.ireq_id in (select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
		$riu = $this->db_plc0->query($qiupb)->result_array();
                
		$team = '';
        
		foreach($riu as $xx){
			$ins['iupb_id'] = $xx['iupb_id'];
			$ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
			$ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
			$ins['idiv_id'] = '';
			$ins['vtipe'] = $post['type'];
			$ins['iapprove'] = '2';
			$ins['cnip'] = $this->user->gNIP;
			$ins['treason'] = $post['remark'];
			$ins['tupdate'] = date('Y-m-d H:i:s');
            
            $ins2['vupb_nomor']= $xx['vupb_nomor'];
            $ins2['vupb_nama']= $xx['vupb_nama'];
            $ins2['vgenerik']= $xx['vgenerik'];
            $ins2['bd']= $xx['bd'];
            $ins2['pd']= $xx['pd'];
            $ins2['qa']= $xx['qa'];
            $ins2['qc']= $xx['qc'];                                  
		
			$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
		
			$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$post['modul_id']); // 1 approval
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
			$hacek=$this->biz_process->cek_last_status($xx['iupb_id'],$bizsup,1); // status 1 => app

			//$this->lib_flow->insert_logs($post['modul_id'],$xx['iupb_id'],14,2);
			
                       
		}
        
        $qiupb = "select distinct(rs.iupb_id), u.vupb_nomor, u.vupb_nama, u.vgenerik,
    		rs.vreq_nomor,rsd.raw_id,rm.vnama, u.iteampd_id,rod.ijumlah,rod.vrec_jum_pr
    		from plc2.plc2_upb_ro ro
    		left outer join plc2.plc2_upb_ro_detail rod on rod.iro_id = ro.iro_id and rod.ldeleted = 0
    		left outer join plc2.plc2_upb_po po on po.ipo_id = ro.ipo_id
    		left outer join plc2.plc2_upb_request_sample_detail rsd on rsd.ireq_id = rod.ireq_id 
    				and rsd.raw_id = rod.raw_id and  rsd.ldeleted = 0
    		left outer join plc2.plc2_raw_material rm on rm.raw_id=rsd.raw_id
    		left outer join plc2.plc2_upb_request_sample	rs on rs.ireq_id = 	rod.ireq_id 
    		left outer join plc2.plc2_upb u on u.iupb_id = rs.iupb_id
    		 where po.ipo_id=$ipo_id";
                        
                    
		$riu = $this->db_plc0->query($qiupb)->result_array();
        foreach($riu as $dtl){
            
			$a.='
				<tr class="tr3">
                    <td class="td3">'.$dtl['vreq_nomor'].'</td>
					<td class="td3">'.$dtl['vnama'].'</td>
					<td class="td3">'.$dtl['ijumlah'].'</td>
					<td class="td3">'.$dtl['vrec_jum_pr'].'</td>
				</tr>
			'; 
            $pd = $dtl['iteampd_id'];
            $toEmail = $this->lib_utilitas->get_email_team($pd);              
        }       
        
        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );  
		$arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );

		$to = $cc = '';
		if(is_array($toEmail2)) {
			$count = count($toEmail2);
			$to = $toEmail2[0];
			for($i=1;$i<$count;$i++) {
				$cc.=isset($toEmail2[$i]) ? $toEmail2[$i].';' : ';';
			}
		}			
		
		$to = $toEmail.";".$toEmail2;
		$cc = $arrEmail;
		$subject="Penerimaan PO:".$po_nomor. " Sudah Di Approved ";				
		$a.="	
				</table>
			<br/> 
			Demikian, mohon segera di follow up pada proses selanjutnya yaitu Penerimaan Sample Bahan Baku oleh masing-masing PD pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
			Post Master
			</body>
		</html>";
		$content=$a;
        
        /*echo  $to;
        echo '</br>cc:' .$cc;      
        echo  $content ;    
        exit ;*/        

		$this->lib_utilitas->send_email($to, $cc, $subject, $content);
        

        
		$data['status']  = true;
    	$data['last_id'] = $iro_id;
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
								var url = "'.base_url().'processor/plc/sample/penerimaan/sample";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_sample_penerimaan_sample").html(data);
									});
					
								}
									reload_grid("grid_sample_penerimaan_sample");
							}
					 	 })
						 }
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_sample_penerimaan_sample_reject" action="'.base_url().'processor/plc/sample/penerimaan/sample?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="ipo_id" value="'.$this->input->get('ipo_id').'" />
				<input type="hidden" name="iro_id" value="'.$this->input->get('iro_id').'" />
    			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark" id="remark" required></textarea><button type="button" onclick="submit_ajax(\'form_sample_penerimaan_sample_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process () {
    	$post = $this->input->post();
    	$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
	 	$iapprove = $post['type'] == 'PR' ? 'iapppr' : '';
    	$this->db_plc0->where('iro_id', $post['iro_id']);
		$this->db_plc0->update('plc2.plc2_upb_ro', array($iapprove=>1,'vnip_pur'=>$nip,'tapp_pur'=>$skg));
    
		$ipo_id = $post['ipo_id'];
		$iro_id = $post['iro_id'];
		//get upb_id
		$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
					select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		
		foreach($riu as $xx){
			$ins['iupb_id'] = $xx['iupb_id'];
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
			
				
			$hacek=$this->biz_process->cek_last_status($xx['iupb_id'],$bizsup,2); // status 2 => reject
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($xx['iupb_id'], $bizsup, 2); // status 2 => reject
				//update last log
					$this->biz_process->update_last_log($xx['iupb_id'], $bizsup, 2);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($xx['iupb_id'], $bizsup, 2); // status 2 => reject
				//insert last log
					$this->biz_process->insert_last_log($xx['iupb_id'], $bizsup, 2);
			}
		}
		
    	$data['status']  = true;
    	$data['last_id'] = $iro_id;
    	return json_encode($data);
    }
	function listBox_sample_penerimaan_sample_iapppr($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	function listBox_sample_penerimaan_sample_iclose_po($value) {
    	if($value==0){$vstatus='Tidak';}
    	elseif($value==1){$vstatus='Ya';}
    	return $vstatus;
    }
	//Keterangan approval 
	function insertBox_sample_penerimaan_sample_vnip_pur($field, $id) {
		return '-';
	}
	function updateBox_sample_penerimaan_sample_vnip_pur($field, $id, $value, $rowData) {
		//print_r($rowData);
		if($rowData['vnip_pur'] != null){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_pur']))->row_array();
			if($rowData['iapppr']==2){$st="Approved";}elseif($rowData['iapppr']==1){$st="Reject";
				// $rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// if(isset($rowa)){$reason=$rowa['treason'];}
				
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_pur'].' )'.' pada '.$rowData['tapp_pur'];
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	//
	function listBox_sample_penerimaan_sample_trequest($value) {
		return date('d M Y', strtotime($value));
	}
	function listBox_sample_penerimaan_sample_cnip($value) {
		return strtoupper($value);
	}
	function insertBox_sample_penerimaan_sample_detail_batch($name, $id) {
		$data['rows'] = array();
		return $this->load->view('sample_batch_sample_detail',$data,TRUE);
	}
	function updateBox_sample_penerimaan_sample_detail_batch($name, $id, $value, $rowData) {
		$this->db_plc0->where('iro_id', $rowData['iro_id']);
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('iro_id', 'asc');
		$data['rows'] = $this->db_plc0->get('plc2.plc2_upb_ro_batch')->result_array();
		return $this->load->view('sample_batch_sample_detail', $data, TRUE);
	}
	function updateBox_sample_penerimaan_sample_detail_terima_sample($name, $id, $value, $rowData) {
		$this->load->helper('search_array');
		$this->db_plc0->where('iro_id', $rowData['iro_id']);
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('iro_id', 'asc');
		$data['rows'] = $this->db_plc0->get('plc2.plc2_upb_ro_detail')->result_array();
		$data['browse_url'] = base_url().'processor/plc/';
		return $this->load->view('sample_penerimaan_sample_detail', $data, TRUE);
	}

	function insertBox_sample_penerimaan_sample_detail_terima_sample($name,$id) {
		//return 'Save Records first';
		/*$this->load->helper('search_array');
		$this->db_plc0->where('ipo_id', $rowData['ipo_id']);
		$this->db_plc0->where('ldeleted', 0);
	    $this->db_plc0->order_by('ipo_id', 'asc');
		$data['rowss'] = $this->db_plc0->get('plc2.plc2_upb_po_detail')->result_array();
		$data['browse_url'] = base_url().'processor/plc/';
		return $this->load->view('sample_penerimaan_sample_detail', $data, TRUE);*/
	}
	function insertBox_sample_penerimaan_sample_vro_nomor($name, $id) {
		return 'this number would be generate automatically
		<input type="hidden" name="isdraft" id="isdraft">';
		//return '<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" />';
	}
	function updateBox_sample_penerimaan_sample_vro_nomor($name, $id, $value) {
		$o = "<input type='hidden' name='".$name."' id='".$id."' readonly='readonly' value='".$value."'/>
		<input type='hidden' name='isdraft' id='isdraft'>";
		$o .= "<label title='Auto Number'>".$value."</label>";
		return $o;

		//return '<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" value="'.$value.'"/>';
		//return $value;
	}

	function insertBox_sample_penerimaan_sample_trequest($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" tanggal input_rows1 required" size="8" />';
		$return.='
		<script type="text/javascript">
			// datepicker
			 $(".tanggal").datepicker({changeMonth:true,
										changeYear:true,
										dateFormat:"yy-mm-dd" });

			// input number
			   $(".angka").numeric();
		</script>
		';
		return $return;
	}

	function updateBox_sample_penerimaan_sample_trequest($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="tanggal input_rows1 required" size="8" />';
			$return.='
				<script type="text/javascript">
					// datepicker
					 $(".tanggal").datepicker({changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });

					// input number
					   $(".angka").numeric();
				</script>
				';
		}
		return $return;
	}

	function insertBox_sample_penerimaan_sample_trequest1($name, $id) {
		return '<input type="hidden" value="'.date('Y-m-d').'" name="'.$name.'" id="'.$id.'" />'.date('l, d F Y');
	}
	function updateBox_sample_penerimaan_sample_trequest1($name, $id, $value) {
		return '<input type="hidden" value="'.date('Y-m-d', strtotime($value)).'" name="'.$name.'" id="'.$id.'" />'.date('l, d F Y', strtotime($value));
	}
	
	function insertBox_sample_penerimaan_sample_vpo_nomor($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" />';
		$return .= '&nbsp;<button class="icon_pop" onclick="browse(\''.base_url().'processor/plc/browse/po?action=index&field=sample_penerimaan_sample\',\'\',\'\',\'List PO Sample\')" type="button">&nbsp;</button>';
	
		return $return;
	}
	
	 function updateBox_sample_penerimaan_sample_vpo_nomor($field, $id, $value, $rowData) {
		
		$row = $this->db_plc0->get_where('plc2.plc2_upb_po', array('ipo_id'=>$rowData['ipo_id']))->row_array();
		$return = '<script>
		 $( "button.icon_pop" ).button({
		 		icons: {
		 		primary: "ui-icon-newwin"
		 		},
		 		text: false
		 		})
		</script>';
		$return = '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$rowData['ipo_id'].'" />';
		$return .= '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$row['vpo_nomor'].'" />';
		//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/spek/fg/list/trial/popup?field=product_trial_formula_skala_lab\',\'List Spesifikasi FG\')" type="button">&nbsp;</button>';
	
		return $return;
	} 
	function insertBox_sample_penerimaan_sample_isupplier_id($field, $id) {
		
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="50" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/supplier/list/popup?field=sample_penerimaan_sample&col=isupplier_id\',\'List Supplier\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function updateBox_sample_penerimaan_sample_isupplier_id($field, $id, $value, $rowData) {
		$ipo_id=$rowData['ipo_id'];
		$sel="select * from hrd.mnf_supplier f where f.isupplier_id=
			(select po.isupplier_id from plc2.plc2_upb_po po where po.ipo_id=$ipo_id)";
		$row = $this->db_plc0->query($sel)->row_array();
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" value="'.$row['isupplier_id'].'" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" value="'.$row['vnmsupp'].'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="50" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/supplier/list/popup?field=sample_penerimaan_sample&col=isupplier_id\',\'List Supplier\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	function before_insert_processor($row, $post, $postData) {
		//print_r($postData);
		$user = $this->auth->user();
		// $query = "select max(iro_id) as std from plc2.plc2_upb_ro";
        // $rs = $this->db_plc0->query($query)->row_array();
        // $nomor = intval($rs['std']) + 1;
        // $nomor = "RE".str_pad($nomor, 7, "0", STR_PAD_LEFT);		
		$skrg = date('Y-m-d H:i:s');
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = $skrg;
		//$postData['vro_nomor'] = $postData['sample_penerimaan_sample_vro_nomor'];
		$postData['ipo_id'] = $postData['sample_penerimaan_sample_vpo_nomor'];
		$postData['iclose_po'] = $postData['sample_penerimaan_sample_iclose_po'];


		//print_r($postData);exit;
		return $postData;
	}

	function after_insert_processor($row, $insertId, $postData) {

		//update service_request autonumber No RO
		$nomor = "RO".str_pad($insertId, 7, "0", STR_PAD_LEFT);
		$sql = "UPDATE plc2.plc2_upb_ro SET vro_nomor = '".$nomor."' WHERE iro_id=$insertId LIMIT 1";
		$query = $this->db_plc0->query( $sql );


		$this->load->helper(array('search_array','mydb'));
		$user = $this->auth->user();
		$skrg = date('Y-m-d H:i:s');
		$this->plcdb = mydb('plc');
		$post = $this->input->post();
		$ipo_id=$postData['vpo_nomor'];
		
		//update table PO utk isi isupplier_id
		$this->plcdb->where('ipo_id', $post['sample_penerimaan_sample_vpo_nomor']);
		$this->plcdb->update('plc2_upb_po', array('isupplier_id'=>$postData['isupplier_id']));
		
		$eRows = $this->db_plc0->get_where('plc2.plc2_upb_po_detail', array('ipo_id'=>$ipo_id, 'ldeleted'=>0))->result_array();
		foreach($eRows as $k => $v) {
			$det['iro_id']=$insertId;
			$det['ipo_id']=$ipo_id;
			$det['raw_id'] = $v['raw_id'];
			$det['ireq_id'] = $v['ireq_id'];
			$det['vnama_produk'] = $v['vnama_produk'];
			$det['ijumlah'] = $v['ijumlah'];
			$det['vjumlah_po'] = $v['ijumlah'];
			$det['vsatuan'] = $v['vsatuan'];
			$det['imanufacture_id'] = $v['imanufacture_id'];
			$this->plcdb->insert('plc2_upb_ro_detail', $det);
			
		}
		
		//insert detail batch
		$det_nobatch = $post['det_nobatch'];
		$detsatuan = $post['detsatuan'];
		$detjumlah = $post['detjumlah'];
		foreach($det_nobatch as $k => $v) {
			if(!empty($v)) {
				$idet['iro_id'] = $insertId;
				$idet['vbatch_nomor'] = $det_nobatch[$k];
				$idet['iJumlah'] = $detjumlah[$k];
				$idet['vSatuan'] = $detsatuan[$k];
				$idet['cnip_insert'] = $user->gNIP;
				$idet['tinsert'] = $skrg;
				$this->plcdb->insert('plc2_upb_ro_batch', $idet);
			}						
		}
		
		$ipo_id = $postData['vpo_nomor'];
		//get upb_id
		$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
					select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		

		if($postData['sample_penerimaan_sample_iclose_po']==1){
			foreach($riu as $xx){
				$iupb_id=$xx['iupb_id'];
			//	$getbp=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // activity 3 input data
			//	$bizsup=$getbp['idplc2_biz_process_sub'];
			//	$this->lib_flow->insert_logs($_GET['modul_id'],$iupb_id,1,0);
			}

			
		} 

		
	}
	function before_update_processor($row, $post, $postData) {
		//print_r($postData);
		$user = $this->auth->user();
		$skrg = date('Y-m-d H:i:s');
		$postData['iro_id']=$postData['sample_penerimaan_sample_iro_id'];
		$postData['iclose_po']=$postData['sample_penerimaan_sample_iclose_po'];
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = $skrg;
		$postData['ipo_id'] = $postData['vpo_nomor'];
		unset($postData['ipo_id']);
		unset($postData['irodet_id']);
		unset($postData['detjumlah']);
		unset($postData['raw_id']);
		unset($postData['detjum_pr']);
		unset($postData['detsatuan']);
		//print_r($postData);
		return $postData;
	}
	function after_update_processor($row, $insertId, $postData, $old_data) {
		$this->load->helper(array('search_array','mydb'));
		$this->plcdb = mydb('plc');
		$user = $this->auth->user();
		$skrg = date('Y-m-d H:i:s');
		$post = $this->input->post();
		
		$irodet_id = $post['irodet_id'];
		$ipo_id = $post['vpo_nomor'];
		$detjum_pr = $post['detjum_pr'];
		
		//update table PO utk isi isupplier_id
		$this->plcdb->where('ipo_id', $post['vpo_nomor']);
		$this->plcdb->update('plc2_upb_po', array('isupplier_id'=>$postData['isupplier_id']));
		
		$eRows = $this->db_plc0->get_where('plc2.plc2_upb_ro_detail', array('iro_id'=>$insertId, 'ldeleted'=>0))->result_array();
		foreach($eRows as $k => $v) {
			if(in_array($v['irodet_id'], $irodet_id)) {
				$this->plcdb->where('irodet_id', $v['irodet_id']);
				$key = array_search($v['irodet_id'], $irodet_id);
				$this->plcdb->update('plc2_upb_ro_detail', array('vrec_jum_pr'=>$detjum_pr[$k]));
			}
			else {
				$this->plcdb->where('irodet_id', $v['irodet_id']);
				$this->plcdb->update('plc2_upb_ro_detail', array('ldeleted'=>1));
			}
		}
		
	
		$iro_id = $insertId;
		$det_nobatch = $post['det_nobatch'];
		$detjumlah = $post['detjumlah'];
		$detsatuan = $post['detsatuan'];
		
		
		if(!empty($post['ibatch_id'])){
			$ibatch_id = $post['ibatch_id'];
			$baRows = $this->db_plc0->get_where('plc2.plc2_upb_ro_batch', array('iro_id'=>$insertId, 'ldeleted'=>0))->result_array();
			foreach($baRows as $k => $v) {
				if(in_array($v['ibatch_id'], $ibatch_id)) {
					$this->plcdb->where('ibatch_id', $v['ibatch_id']);
					$this->plcdb->update('plc2_upb_ro_batch', array('vbatch_nomor'=>$det_nobatch[$k],'iJumlah'=>$detjumlah[$k],'vSatuan'=>$detsatuan[$k],'cnip_update'=>$user->gNIP,'tupdate'=>$skrg));
				}
				else {
					$this->plcdb->where('ibatch_id', $v['ibatch_id']);
					$this->plcdb->update('plc2_upb_ro_batch', array('ldeleted'=>1));
				}
			}
			foreach($ibatch_id as $k => $v) {
				if(empty($v)) {
					if(!empty($det_nobatch[$k])) {
						$idet['iro_id'] = $insertId;
						$idet['vbatch_nomor'] = $det_nobatch[$k];
						$idet['iJumlah'] = $detjumlah[$k];
						$idet['vSatuan'] = $detsatuan[$k];
						$idet['cnip_insert'] = $user->gNIP;
						$idet['tinsert'] = $skrg;
						$this->plcdb->insert('plc2_upb_ro_batch', $idet);
					}						
				}
			}
		}
		else{
			foreach($det_nobatch as $k => $v) {
				$idet['iro_id'] = $insertId;
				$idet['vbatch_nomor'] = $det_nobatch[$k];
				$idet['iJumlah'] = $detjumlah[$k];
				$idet['vSatuan'] = $detsatuan[$k];
				$idet['cnip_insert'] = $user->gNIP;
				$idet['tinsert'] = $skrg;
				$this->plcdb->insert('plc2_upb_ro_batch', $idet);
			}
		}
		
			
		$ipo_id = $postData['vpo_nomor'];
		//get upb_id
		$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
					select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		

		if($postData['sample_penerimaan_sample_iclose_po']==1){
			foreach($riu as $xx){
				$iupb_id=$xx['iupb_id'];
			
			//	$this->lib_flow->insert_logs($_GET['modul_id'],$iupb_id,1,0);
			}

			
		} 

	}
	function output(){		
    	$this->index($this->input->get('action'));
    }

          
}