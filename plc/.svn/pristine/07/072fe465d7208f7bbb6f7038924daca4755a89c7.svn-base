<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sample_po_sample extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->user = $this->auth->user();
		$this->load->library('biz_process');
        $this->load->library('lib_utilitas');
        $this->load->library('lib_flow');
		$this->_table = 'plc2.plc2_upb_po';
		$this->_table_supplier = 'hrd.mnf_supplier';
		$this->_table_employee = 'hrd.employee';
		$this->_table_detail = 'plc2.plc2_upb_po_detail';
		$this->load->helper('to_mysql');
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('PO Sample');		
		$grid->setTable($this->_table);		
		$grid->setUrl('sample_po_sample');
		$grid->addList('vpo_nomor','trequest','itype','mnf_supplier.vnmsupp','cnip','employee.vName','iapppr');
		$grid->setJoinTable($this->_table_supplier, $this->_table_supplier.'.isupplier_id = '.$this->_table.'.isupplier_id', 'left');
		$grid->setJoinTable($this->_table_employee, $this->_table_employee.'.cNip = '.$this->_table.'.cnip', 'left');
		$grid->setSortBy('vpo_nomor');
		$grid->setSortOrder('desc');
		$grid->setSearch('vpo_nomor','trequest','itype','mnf_supplier.vnmsupp','cnip','employee.vName');
		$grid->setWidth('vpo_nomor', 90);
		$grid->setWidth('trequest', 90);
		$grid->setWidth('itype', 70);
		$grid->setWidth('cnip', 50);
		
		$grid->setLabel('vpo_nomor', 'No. PO');
		$grid->setLabel('trequest', 'Tanggal PO Request');
		$grid->setLabel('itype', 'Jenis');
		$grid->setLabel('mnf_supplier.vnmsupp','Supplier');
		$grid->setLabel('isupplier_id','Supplier');
		$grid->setLabel('tdeadline','Tanggal ETA');
		$grid->setLabel('vor_nomor','No. OR');
		$grid->setLabel('ttransfer','Tanggal Transfer FA');
		$grid->setLabel('cnip','NIP');
		$grid->setLabel('vreq_nomor','No. Permintaan');
		$grid->setLabel('employee.vName','Nama');
		$grid->setLabel('vnip_pur','Approval Purchasing');		
		$grid->setLabel('iapppr','Approval Purchasing');		
		$grid->setQuery('plc2_upb_po.ldeleted', 0);
		
		$grid->addFields('itype','vpo_nomor','isupplier_id','trequest','tdeadline','vor_nomor','ttransfer','detail_bahan_baku','vnip_pur');		
		$grid->setRequired('itype','iupb_id','trequest');
		
		$grid->changeFieldType('itype', 'combobox', '', array(''=>'--select--', 1=>'Free', 2=>'Not Free'));
		
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
				echo $grid->updated_form();
				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'download':
				$this->download($this->input->get('file'));
				break;
			case 'getMax':
				$this->getMax();
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
    
    function manipulate_insert_button($buttons) {
		unset($buttons['save']);

		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'sample_po_sample\', \''.base_url().'processor/plc/sample/po/sample?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_sample_po_sample">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'sample_po_sample\', \''.base_url().'processor/plc/sample/po/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_sample_po_sample">Save &amp; Submit</button>';
		$js = $this->load->view('lokal/sample_po_sample_js');
		$buttons['save'] = $save_draft.$save.$js;

		return $buttons;
	}

	function manipulate_update_button($buttons, $rowData) {
    	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			$js = $this->load->view('lokal/sample_po_sample_js');
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
			//echo $this->auth->my_teams();
			
    		$ipo_id=$rowData['ipo_id'];
    		
			//get upb_id
			$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
						select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
			$riu = $this->db_plc0->query($qiupb)->result_array();
			//print_r($riu);

			$qcek="select * from plc2.plc2_upb_po f where f.ipo_id=$ipo_id";
			$rcek = $this->db_plc0->query($qcek)->row_array();
			// echo $type.' : '.$rcek['iapppr']; 
			$x=$this->auth->my_teams();
			//print_r($x);
			$arrhak=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
		//print_r($arrhak);
			//if(empty($arrhak)){
				$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
			//	if(empty($getbp)){}
			//	else{
					if($this->auth->is_manager()){ //jika manager PR
						if(($type=='PR')&&($rcek['iapppr']==0)){
//							$update = '<button onclick="javascript:update_btn_upload(\'sample_po_sample\', \''.base_url().'processor/plc/sample/po/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$update = '<button onclick="javascript:update_btn_back(\'sample_po_sample\', \''.base_url().'processor/plc/sample/po/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save bt_permintaan_sample" id="button_update_permintaan_sample">Update & Submit</button>';
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/sample/po/sample?action=approve&ipo_id='.$ipo_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Confirm</button>';
							$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/sample/po/sample?action=reject&ipo_id='.$ipo_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Reject</button>';
								
							$buttons['update'] = $approve.$js;
						}
						else{}
					}
					else{
							if(($type=='PR')&&($rcek['iapppr']==0)){
								if ($rcek['iSubmit']==0) {
									$update = '<button onclick="javascript:update_btn_back(\'sample_po_sample\', \''.base_url().'processor/plc/sample/po/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save bt_permintaan_sample" id="button_update_permintaan_sample">Update & Submit</button>';
									$updatedraft = '<button onclick="javascript:update_draft_btn(\'sample_po_sample\', \''.base_url().'processor/plc/sample/po/sample?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_draft_sample_po_sample">Update as Draft</button>';
									//$update = '<button onclick="javascript:update_btn_upload(\'sample_po_sample\', \''.base_url().'processor/plc/sample/po/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
									$buttons['update'] = $update;
								}
								
							}
						}
			//	}
		/*		
			}else{
				if($this->auth->is_manager()){ //jika manager PR
					if(($type=='PR')&&($rcek['iapppr']==0)){
							$update = '<button onclick="javascript:update_btn_upload(\'sample_po_sample\', \''.base_url().'processor/plc/sample/po/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/sample/po/sample?action=approve&ipo_id='.$ipo_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Approve</button>';
							$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/sample/po/sample?action=reject&ipo_id='.$ipo_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Reject</button>';
								
							$buttons['update'] = $update.$approve.$reject;
						}
					else{}
					//array_unshift($buttons, $reject, $approve, $revise);
				}
				else{
					if(($type=='PR')&&($rcek['iapppr']==0)){
						$update = '<button onclick="javascript:update_btn_upload(\'sample_po_sample\', \''.base_url().'processor/plc/sample/po/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
						$buttons['update'] = $update;
					}
					else{}
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
								var url = "'.base_url().'processor/plc/sample/po/sample";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_sample_po_sample").html(data);
									});
					
								}
									reload_grid("grid_sample_po_sample");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_sample_po_sample_approve" action="'.base_url().'processor/plc/sample/po/sample?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="ipo_id" value="'.$this->input->get('ipo_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_sample_po_sample_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$iapprove = $post['type'] == 'PR' ? 'iapppr' : '';
		$this->db_plc0->where('ipo_id', $post['ipo_id']);
		$this->db_plc0->update('plc2.plc2_upb_po', array($iapprove=>2,'vnip_pur'=>$nip,'tapp_pur'=>$skg));
    
    	$ipo_id = $post['ipo_id'];
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
			
			$hacek=$this->biz_process->cek_last_status($xx['iupb_id'],$bizsup,1); // status 1 => app

			// lib_flow start
		//	$this->lib_flow->insert_logs($post['modul_id'],$xx['iupb_id'],14,2);
		/*
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($xx['iupb_id'], $bizsup, 1); // status 1 => app
				//update last log
					$this->biz_process->update_last_log($xx['iupb_id'], $bizsup, 1);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($xx['iupb_id'], $bizsup, 1); // status 1 => app
				//insert last log
					$this->biz_process->insert_last_log($xx['iupb_id'], $bizsup, 1);
			}
		*/
		}
    	
        $hsql= "select a.vpo_nomor,c.vnmsupp,a.trequest,a.tdeadline,a.vor_nomor,a.ttransfer,
                a.tapp_pur,a.vnip_pur
                	from plc2.plc2_upb_po a
                left outer join hrd.mnf_supplier c on c.isupplier_id = a.isupplier_id
                where a.ipo_id = ".$ipo_id;

        
        $rupb = $this->db_plc0->query($hsql)->row_array();
        
        $vpo_nomor= $rupb['vpo_nomor'];
        $vnmsupp = $rupb['vnmsupp'];
        $vtdeadline= $rupb['tdeadline'];
        $vor_nomor= $rupb['vor_nomor'];
        $trequest= $rupb['trequest'];
        $ttransfer = $rupb['ttransfer'];
        $tapp_pur= $rupb['tapp_pur'];
        $vnip_pur = $rupb['vnip_pur'];                        
        
        $qsql="select te.iteam_id as iteampr_id  from plc2.plc2_upb_team te where te.cDeptId='PR'";
        $rsql = $this->db_plc0->query($qsql)->row_array();

        $pr = $rsql['iteampr_id'];
        
        $team = $pr;
        
        $toEmail2='';
        $toEmail = $this->lib_utilitas->get_email_team( $pr );
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

        $to = $toEmail;
        $cc = $toEmail2;
        $subject="Proses Pembuatan PO Sample ".$vpo_nomor." Selesai";
        $content="
                Diberitahukan bahwa telah ada approval oleh Purchashing pada proses PO Sample(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
                <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
                        <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
                                <tr>
                                        <td style='width: 110px;'><b>No PO</b></td><td style='width: 20px;'> : </td><td>".$vpo_nomor."</td>
                                </tr>
                                <tr>
                                        <td><b>Supplier</b></td><td> : </td><td>".$vnmsupp."</td>
                                </tr>
                                <tr>
                                        <td><b>Nomor OR</b></td><td> : </td><td>".$vor_nomor."</td>
                                </tr>
                                <tr>
                                        <td><b>Tgl PO Req.</b></td><td> : </td><td>".$trequest."</td>
                                </tr>
                                <tr>
                                        <td><b>Tgl Transfer FA</b></td><td> : </td><td>".$ttransfer."</td>
                                </tr>
                                <tr>
                                        <td><b>Tgl Aprrove PO</b></td><td> : </td><td>".$tapp_pur."</td>
                                </tr>
                                <tr>
                                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>Penerimaan Sample - Input oleh Purchasing</td>
                                </tr>
                        </table>
                </div>
                <br/> 
                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
                Post Master";
        /*echo  $to;
        echo '</br>cc:' .$cc;      
        echo  $content ;    
        exit     ;*/
        $this->lib_utilitas->send_email($to, $cc, $subject, $content);
        
        
		$data['status']  = true;
    	$data['last_id'] = $ipo_id;
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
								var url = "'.base_url().'processor/plc/sample/po/sample";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_sample_po_sample").html(data);
									});
					
								}
									reload_grid("grid_sample_po_sample");
							}
					 	 })
						 }
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_sample_po_sample_reject" action="'.base_url().'processor/plc/sample/po/sample?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="ipo_id" value="'.$this->input->get('ipo_id').'" />
    			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark" id="remark" required></textarea><button type="button" onclick="submit_ajax(\'form_sample_po_sample_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process () {
    	$post = $this->input->post();
    	$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
	 	$iapprove = $post['type'] == 'PR' ? 'iapppr' : '';
    	$this->db_plc0->where('ipo_id', $post['ipo_id']);
		$this->db_plc0->update('plc2.plc2_upb_po', array($iapprove=>1,'vnip_pur'=>$nip,'tapp_pur'=>$skg));
    
		$ipo_id = $post['ipo_id'];
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
    	$data['last_id'] = $ipo_id;
    	return json_encode($data);
    }
	function listBox_sample_po_sample_iapppr($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	//Keterangan approval 
	function insertBox_sample_po_sample_vnip_pur($field, $id) {
		return '-';
	}
	function updateBox_sample_po_sample_vnip_pur($field, $id, $value, $rowData) {
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
	public function listBox_Action($row, $actions) {
	 	//print_r($row);
		if($row->iapppr != 0){
	 		 unset($actions['edit']);
	 		 unset($actions['delete']);
	 	}
		else{}
	 return $actions;
	}
	
	function listBox_sample_po_sample_trequest($value) {
		return date('d M Y', strtotime($value));
	}
	function listBox_sample_po_sample_cnip($value) {
		return strtoupper($value);
	}
	
	function updateBox_sample_po_sample_detail_bahan_baku($name, $id, $value, $rowData) {
		$this->load->helper('search_array');
		$this->db_plc0->where('ipo_id', $rowData['ipo_id']);
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('ipo_id', 'asc');
		$data['rows'] = $this->db_plc0->get('plc2.plc2_upb_po_detail')->result_array();
		$data['browse_url'] = base_url().'processor/plc/';
		return $this->load->view('sample_po_sample_detail', $data, TRUE);
	}

	function insertBox_sample_po_sample_detail_bahan_baku($name, $id) {
		$this->load->helper('search_array');
		$data['rows'] = array();
		$data['browse_url'] = base_url().'processor/plc/';
		return $this->load->view('sample_po_sample_detail', $data, TRUE);
	}
	
	function insertBox_sample_po_sample_vpo_nomor($name, $id) {
		//return 'this number would be generate automatically';
		return '<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" />';
	}
	function updateBox_sample_po_sample_vpo_nomor($name, $id, $value,$row) {
		//return $value;
		//print_r($row);
		if($row['itype']==2){
			return '<input type="hidden" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$value.'"/>
			<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" value="'.$value.'"/>';
		}
		else{
			return '<input type="hidden" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$value.'"/>
			<input type="text" name="'.$id.'" id="'.$id.'" disabled="true" class="input_rows1" size="20" value="'.$value.'"/>';
		}
		
	}	
	/*
	function insertBox_sample_po_sample_trequest($name, $id) {
		return '<input type="hidden" value="'.date('Y-m-d').'" name="'.$name.'" id="'.$id.'" />'.date('l, d F Y');
	}
	function updateBox_sample_po_sample_trequest($name, $id, $value) {
		return '<input type="hidden" value="'.date('Y-m-d', strtotime($value)).'" name="'.$name.'" id="'.$id.'" />'.date('l, d F Y', strtotime($value));
	}
	*/

	function insertBox_sample_po_sample_trequest($name, $id) {
		$return = '<input type="text" name="'.$name.'"  readonly="readonly" id="'.$id.'"  class="input_rows1 required" size="10" />';
		$return .='<script>
				 $("#'.$id.'").datepicker({	changeMonth:true,
											changeYear:true,
											dateFormat:"yy-mm-dd" });
			</script>';
	return $return;
	}

	function updateBox_sample_po_sample_trequest($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value ;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
			$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		}
		return $return;
	}


	function updateBox_sample_po_sample_vor_nomor($name, $id, $value) {
		return '<input type="text" class="input_rows1" name="'.$name.'" value="'.$value.'" id="'.$id.'">';
	}
	function updateBox_sample_po_sample_tdeadline($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		return '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">
		<input type="hidden" name="isdraft" id="isdraft">';
	}
	
	function updateBox_sample_po_sample_ttransfer($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		return '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">
		<input type="hidden" name="isdraft" id="isdraft">';
	}

	function insertBox_sample_po_sample_isupplier_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="50" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/supplier/list/popup?field=sample_po_sample&col=isupplier_id\',\'List Supplier\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function updateBox_sample_po_sample_isupplier_id($field, $id, $value) {
		$row = $this->db_plc0->get_where('hrd.mnf_supplier', array('isupplier_id'=>$value))->row_array();
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" value="'.$value.'" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" value="'.$row['vnmsupp'].'" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="50" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/supplier/list/popup?field=sample_po_sample&col=isupplier_id\',\'List Supplier\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	function before_insert_processor($row, $post, $postData) {
		$user = $this->auth->user();
		if($postData['sample_po_sample_itype']==1){
			$query = "select max(poi.ipo_id) as std from plc2.plc2_upb_po poi where poi.itype='1'";
			$rs = $this->db_plc0->query($query)->row_array();
			$nomor = intval($rs['std']) + 1;
			$nomor = "PO".str_pad($nomor, 7, "0", STR_PAD_LEFT);
			$postData['vpo_nomor'] = $nomor;			
		}
		else{
			$postData['vpo_nomor'] = $postData['sample_po_sample_vpo_nomor'];
			unset($postData['sample_po_sample_vpo_nomor']);
		}


		$skrg = date('Y-m-d H:i:s');
		unset($postData['ipodet_id']);
		unset($postData['ireq_id']);
		unset($postData['detrawid']);
		//unset($postData['detnamaproduk']);
		unset($postData['detjumlah']);
		unset($postData['detsatuan']);
		unset($postData['detmanufacture_id']);
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = $skrg;
		//$postData['vpo_nomor'] = $postData['sample_po_sample_vpo_nomor'];
		//$postData['vpo_nomor'] = $nomor;
		$postData['tdeadline'] = to_mysql($postData['sample_po_sample_tdeadline']);
		$postData['ttransfer'] = to_mysql($postData['sample_po_sample_ttransfer']);
		unset($postData['sample_po_sample_tdeadline']);
		unset($postData['sample_po_sample_ttransfer']);
		$postData['vor_nomor'] =$postData['sample_po_sample_vor_nomor'];
		unset($postData['sample_po_sample_vor_nomor']);
		$postData['itype'] = $postData['sample_po_sample_itype'];
		unset($postData['sample_po_sample_itype']);
		//print_r($postData);exit;
		return $postData;
	}

	function after_insert_processor($row, $insertId, $postData) {
		$this->load->helper(array('search_array','mydb'));
		$this->plcdb = mydb('plc');
		$post = $this->input->post();
		
		$ipodet_id = $post['ipodet_id'];
		$ireq_id = $post['ireq_id'];
		$detrawid = $post['detrawid'];
		//$detnamaproduk = $post['detnamaproduk'];
		$detjumlah = $post['detjumlah'];
		$detsatuan = $post['detsatuan'];
		$detmanufacture_id = $post['detmanufacture_id'];

		


		
		foreach($ipodet_id as $k => $v) {
			if(empty($v)) {
				if(!empty($ireq_id[$k])) {
					$idet['ipo_id'] = $insertId;
					$idet['ireq_id'] = $ireq_id[$k];
					$idet['raw_id'] = $detrawid[$k];
				//	$idet['vnama_produk'] = $detnamaproduk[$k];
					$idet['ijumlah'] = $detjumlah[$k];
					$idet['vsatuan'] = $detsatuan[$k];
					$idet['imanufacture_id'] = $detmanufacture_id[$k];
					$this->plcdb->insert('plc2_upb_po_detail', $idet);
				}						
			}
		}
		$ipo_id = $insertId;
		//get upb_id
		$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
					select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		
		$sql2="select * from plc2.plc2_upb_po a where a.ipo_id=$insertId";
		$list_po=$this->db_plc0->query($sql2)->row_array();

		
		// masukkan ke logs upb proses , action input 
		if ($list_po['iSubmit']==1) {
			foreach($riu as $xx){
				$iupb_id=$xx['iupb_id'];
				$getbp=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // activity 3 input data
				$bizsup=$getbp['idplc2_biz_process_sub'];

		//		$this->lib_flow->insert_logs($this->input->get('modul_id'),$iupb_id,1,0);
				/*
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
				*/
			}
		}


	}
	function before_update_processor($row, $post, $postData) {
		$user = $this->auth->user();
		$skrg = date('Y-m-d H:i:s');
		unset($postData['ipodet_id']);
		unset($postData['ireq_id']);
		unset($postData['detrawid']);
		//unset($postData['detnamaproduk']);
		unset($postData['detjumlah']);
		unset($postData['detsatuan']);
		unset($postData['detmanufacture_id']);
		$postData['tdeadline'] = to_mysql($postData['tdeadline']);
		$postData['ttransfer'] = to_mysql($postData['ttransfer']);		
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = $skrg;
		$postData['itype'] = $postData['sample_po_sample_itype'];
		if($postData['sample_po_sample_itype']==1){
			$query = "select max(poi.ipo_id) as std from plc2.plc2_upb_po poi where poi.itype='1'";
			$rs = $this->db_plc0->query($query)->row_array();
			$nomor = intval($rs['std']) + 1;
			$nomor = "PO".str_pad($nomor, 7, "0", STR_PAD_LEFT);
			$postData['vpo_nomor'] = $nomor;
			unset($postData['sample_po_sample_vpo_nomor']);
			unset($postData['sample_po_sample_vpo_nomor_dis']);
		}
		else{
			$postData['vpo_nomor'] = $postData['sample_po_sample_vpo_nomor'];
			unset($postData['sample_po_sample_vpo_nomor']);
			unset($postData['sample_po_sample_vpo_nomor_dis']);
		}
		// if($postData['itype']==1){
			// $postData['vpo_nomor'] = $postData['sample_po_sample_vpo_nomor_dis'];
			// unset($postData['sample_po_sample_vpo_nomor_dis']);
			// unset($postData['sample_po_sample_vpo_nomor']);
		// }
		// else{
			// $postData['vpo_nomor'] = $postData['sample_po_sample_vpo_nomor'];
			// unset($postData['sample_po_sample_vpo_nomor']);
			// unset($postData['sample_po_sample_vpo_nomor_dis']);
		// }
		//$postData['vpo_nomor'] = $postData['sample_po_sample_vpo_nomor'];
		unset($postData['sample_po_sample_itype']);
		$postData['ipo_id'] = $postData['sample_po_sample_ipo_id'];
		unset($postData['sample_po_sample_ipo_id']);
		//print_r($postData);exit;
		return $postData;
	}
	function after_update_processor($row, $insertId, $postData, $old_data) {
		$this->load->helper(array('search_array','mydb'));
		$this->plcdb = mydb('plc');
		$post = $this->input->post();
		
		$ipodet_id = $post['ipodet_id'];
		$ireq_id = $post['ireq_id'];
		$detrawid = $post['detrawid'];
		//$detnamaproduk = $post['detnamaproduk'];
		$detjumlah = $post['detjumlah'];
		$detsatuan = $post['detsatuan'];
		$detmanufacture_id = $post['detmanufacture_id'];
		
		$eRows = $this->db_plc0->get_where('plc2.plc2_upb_po_detail', array('ipo_id'=>$insertId, 'ldeleted'=>0))->result_array();
		foreach($eRows as $k => $v) {
			if(in_array($v['ipodet_id'], $ipodet_id)) {
				$this->plcdb->where('ipodet_id', $v['ipodet_id']);
				$key = array_search($v['ipodet_id'], $ipodet_id);
				$this->plcdb->update('plc2_upb_po_detail', array('ireq_id'=>$ireq_id[$key],'raw_id'=>$detrawid[$key],'ijumlah'=>$detjumlah[$key],'vsatuan'=>$detsatuan[$key],'imanufacture_id'=>$detmanufacture_id[$key]));
				//$this->plcdb->update('plc2_upb_po_detail', array('ireq_id'=>$ireq_id[$key],'raw_id'=>$detrawid[$key],'vnama_produk'=>$detnamaproduk[$key],'ijumlah'=>$detjumlah[$key],'vsatuan'=>$detsatuan[$key],'imanufacture_id'=>$detmanufacture_id[$key]));
			}
			else {
				$this->plcdb->where('ipodet_id', $v['ipodet_id']);
				$this->plcdb->update('plc2_upb_po_detail', array('ldeleted'=>1));
			}
		}


		foreach($ipodet_id as $k => $v) {
			if(empty($v)) {
				if(!empty($ireq_id[$k])) {
					$idet['ipo_id'] = $insertId;
					$idet['ireq_id'] = $ireq_id[$k];
					$idet['raw_id'] = $detrawid[$k];
					//$idet['vnama_produk'] = $detnamaproduk[$k];
					$idet['ijumlah'] = $detjumlah[$k];
					$idet['vsatuan'] = $detsatuan[$k];
					$idet['imanufacture_id'] = $detmanufacture_id[$k];
					$this->plcdb->insert('plc2_upb_po_detail', $idet);
				}						
			}
		}
		$ipo_id = $insertId;
		//get upb_id
		$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
					select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		

		$sql2="select * from plc2.plc2_upb_po a where a.ipo_id=$insertId";
		$list_po=$this->db_plc0->query($sql2)->row_array();
		if ($list_po['iSubmit']==1) {	
			foreach($riu as $xx){
				$iupb_id=$xx['iupb_id'];
				$getbp=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // activity 3 input data
				$bizsup=$getbp['idplc2_biz_process_sub'];
		//		$this->lib_flow->insert_logs($this->input->get('modul_id'),$iupb_id,1,0);
			/*	
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
			*/
			}
		}
	}

function getMax(){
	$ireqdet_id=$_POST['ireqdet_id'];
	$data = array();

	$sql2 = "SELECT * FROM plc2.plc2_upb_request_sample_detail c  where c.ireqdet_id='".$ireqdet_id."'";
	$data2 = $this->db_plc0->query($sql2)->row_array();

	$sql22 = "select sum(a.ijumlah) as sumjumlah from plc2.plc2_upb_po_detail a where a.raw_id='".$data2['raw_id']."' and a.ireq_id='".$data2['ireq_id']."'";
	$data22 = $this->db_plc0->query($sql22)->row_array();
 	
	$iMaxc = $data2['ijumlah']-$data22['sumjumlah'];
	if ($data22['sumjumlah'] =="") {
		$iMax=$data2['ijumlah'];
	}else{
		if ($iMaxc > 0) {
			$iMax=$iMaxc;
		}else{
			$iMax=0;
		}	
	}

	
 	$row_array['iMax'] = trim($iMax);
	
 	array_push($data, $row_array);
 	echo json_encode($data);
    exit;
}


	function output(){		
    	$this->index($this->input->get('action'));
    }
}