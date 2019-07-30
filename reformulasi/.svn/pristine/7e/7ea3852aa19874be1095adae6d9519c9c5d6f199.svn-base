<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class export_po_sample extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth_export');
		$this->user = $this->auth_export->user();
        $this->load->library('lib_utilitas');
        //$this->load->library('lib_flow');
		$this->_table = 'reformulasi.export_po';
		$this->_table_supplier = 'hrd.mnf_supplier';
		$this->_table_employee = 'hrd.employee';
		$this->_table_detail = 'reformulasi.export_po_detail';
		$this->load->helper('to_mysql');
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('PO Sample');		
		$grid->setTable($this->_table);		
		$grid->setUrl('export_po_sample');
		$grid->addList('vpo_nomor','trequest','itype','mnf_supplier.vnmsupp','cnip','employee.vName','iapppr');
		$grid->setJoinTable($this->_table_supplier, $this->_table_supplier.'.isupplier_id = '.$this->_table.'.isupplier_id', 'left');
		$grid->setJoinTable($this->_table_employee, $this->_table_employee.'.cNip = '.$this->_table.'.cnip', 'left');
		$grid->setSortBy('ipo_id');
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
		$grid->setQuery('export_po.ldeleted', 0);
		
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

		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'export_po_sample\', \''.base_url().'processor/reformulasi/export/po/sample?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_export_po_sample">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'export_po_sample\', \''.base_url().'processor/reformulasi/export/po/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_export_po_sample">Save &amp; Submit</button>';
		$js = $this->load->view('export/sample/js/export_po_sample_js');
		$buttons['save'] = $save_draft.$save.$js;

		return $buttons;
	}

	function manipulate_update_button($buttons, $rowData) {
    	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			$js = $this->load->view('export/sample/js/export_po_sample_js');
			unset($buttons['update_back']);
			unset($buttons['update']);
	    	
	    	$user = $this->auth_export->user();
	    	$x=$this->auth_export->dept();
	    	if($this->auth_export->is_manager()){
	    		$x=$this->auth_export->dept();
	    		$manager=$x['manager'];
	    		if(in_array('PR', $manager)){$type='PR';}
	    		else{$type='';}
	    	}
			else{
				$x=$this->auth_export->dept();
	    		$team=$x['team'];
				if(in_array('PR', $team)){$type='PR';}
				else{$type='';}
			}
			//echo $this->auth_export->my_teams();
			
    		$ipo_id=$rowData['ipo_id'];
    		
			$qcek="select * from reformulasi.export_po f where f.ipo_id=$ipo_id";
			$rcek = $this->db->query($qcek)->row_array();

			$x=$this->auth_export->my_teams();
			//print_r($x);
			
					if($this->auth_export->is_manager()){ //jika manager PR
						if(($type=='PR')&&($rcek['iSubmit']==0)){
								$update = '<button onclick="javascript:update_btn_back(\'export_po_sample\', \''.base_url().'processor/reformulasi/export/po/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save bt_permintaan_sample" id="button_update_permintaan_sample">Update & Submit</button>';
								$updatedraft = '<button onclick="javascript:update_draft_btn(\'export_po_sample\', \''.base_url().'processor/reformulasi/export/po/sample?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_draft_export_po_sample">Update as Draft</button>';
								
								$buttons['update'] = $updatedraft.$update.$js;
						
							
						}else{
							if(($type=='PR')&&($rcek['iapppr']==0)){
								$update = '<button onclick="javascript:update_btn_back(\'export_po_sample\', \''.base_url().'processor/reformulasi/export/po/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save bt_permintaan_sample" id="button_update_permintaan_sample">Update & Submit</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/reformulasi/export/po/sample?action=approve&ipo_id='.$ipo_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Confirm</button>';
								$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/reformulasi/export/po/sample?action=reject&ipo_id='.$ipo_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Reject</button>';
									
								$buttons['update'] = $approve.$js;
							}

						}

						
						
					}
					else{
							if(($type=='PR')&&($rcek['iapppr']==0)){
								if ($rcek['iSubmit']==0) {
									$update = '<button onclick="javascript:update_btn_back(\'export_po_sample\', \''.base_url().'processor/reformulasi/export/po/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save bt_permintaan_sample" id="button_update_permintaan_sample">Update & Submit</button>';
									$updatedraft = '<button onclick="javascript:update_draft_btn(\'export_po_sample\', \''.base_url().'processor/reformulasi/export/po/sample?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_draft_export_po_sample">Update as Draft</button>';
									
									$buttons['update'] = $updatedraft.$update.$js;
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
								var url = "'.base_url().'processor/reformulasi/export/po/sample";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_export_po_sample").html(data);
									});
					
								}
									reload_grid("grid_export_po_sample");
									var  full = $("#infomodule").text().split(":");
                                    var part1 = full[1].split("/");
                                    reload_grid_new(part1[1],grid);
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_export_po_sample_approve" action="'.base_url().'processor/reformulasi/export/po/sample?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="ipo_id" value="'.$this->input->get('ipo_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_export_po_sample_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$iapprove = $post['type'] == 'PR' ? 'iapppr' : '';
		$this->db->where('ipo_id', $post['ipo_id']);
		$this->db->update('reformulasi.export_po', array($iapprove=>2,'vnip_pur'=>$nip,'tapp_pur'=>$skg,'remark'=>$post['remark']));
    
    	$ipo_id = $post['ipo_id'];
		
		

   	/*bagian email notifikasi*/
        $hsql= "select a.vpo_nomor,c.vnmsupp,a.trequest,a.tdeadline,a.vor_nomor,a.ttransfer,
                a.tapp_pur,a.vnip_pur
                	from reformulasi.export_po a
                left outer join hrd.mnf_supplier c on c.isupplier_id = a.isupplier_id
                where a.ipo_id = ".$ipo_id;

        
        $rupb = $this->db->query($hsql)->row_array();
        
        $vpo_nomor= $rupb['vpo_nomor'];
        $vnmsupp = $rupb['vnmsupp'];
        $vtdeadline= $rupb['tdeadline'];
        $vor_nomor= $rupb['vor_nomor'];
        $trequest= $rupb['trequest'];
        $ttransfer = $rupb['ttransfer'];
        $tapp_pur= $rupb['tapp_pur'];
        $vnip_pur = $rupb['vnip_pur'];                        
        
        $qsql="select te.ireformulasi_team as iteampr_id  
				from reformulasi.reformulasi_team te
				join reformulasi.reformulasi_master_departement  rmd on rmd.ireformulasi_master_departement=te.cDeptId
				where rmd.vkode_departement='PR'";
				//echo $qsql;
        $rsql = $this->db->query($qsql)->row_array();

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
        $subject="Reformulasi - PO Sample ".$vpo_nomor." Selesai";
        $content="
                Diberitahukan bahwa telah ada approval oleh Purchashing pada proses PO Sample(aplikasi Reformulasi Export) dengan rincian sebagai berikut :<br><br>
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
                //echo $to;
        $this->sess_auth->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);

    /*bagian email notifikasi*/   
        
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
								var url = "'.base_url().'processor/reformulasi/export/po/sample";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_export_po_sample").html(data);
									});
					
								}
									reload_grid("grid_export_po_sample");
							}
					 	 })
						 }
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_export_po_sample_reject" action="'.base_url().'processor/reformulasi/export/po/sample?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="ipo_id" value="'.$this->input->get('ipo_id').'" />
    			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark" id="remark" required></textarea><button type="button" onclick="submit_ajax(\'form_export_po_sample_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process () {
    	$post = $this->input->post();
    	$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
	 	$iapprove = $post['type'] == 'PR' ? 'iapppr' : '';
    	$this->db->where('ipo_id', $post['ipo_id']);
		$this->db->update('reformulasi.export_po', array($iapprove=>1,'vnip_pur'=>$nip,'tapp_pur'=>$skg));
    
		$ipo_id = $post['ipo_id'];

		
    	$data['status']  = true;
    	$data['last_id'] = $ipo_id;
    	return json_encode($data);
    }
	function listBox_export_po_sample_iapppr($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	//Keterangan approval 
	function insertBox_export_po_sample_vnip_pur($field, $id) {
		return '-';
	}
	function updateBox_export_po_sample_vnip_pur($field, $id, $value, $rowData) {
		//print_r($rowData);
		if($rowData['vnip_pur'] != null){
			$row = $this->db->get_where('hrd.employee', array('cNip'=>$rowData['vnip_pur']))->row_array();
			if($rowData['iapppr']==2){$st="Approved";}elseif($rowData['iapppr']==1){$st="Reject";
				// $rowa = $this->db->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// if(isset($rowa)){$reason=$rowa['treason'];}
				
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_pur'].' )'.' pada '.$rowData['tapp_pur'].' <br> Remark : '.$rowData['remark'];
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

	


	
	function listBox_export_po_sample_trequest($value) {
		return date('d M Y', strtotime($value));
	}
	function listBox_export_po_sample_cnip($value) {
		return strtoupper($value);
	}
	

	function updateBox_export_po_sample_itype($field, $id, $value, $row) {
        // $lmarketing = array(1=>'Free', 2=>'Not Free');
        // $o = '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1" size="20" value="'.$value.'"/>' ;
        // if ($this->input->get('action') == 'view') {
        //     $o .= $lmarketing[$value];
        // } else {
        // 	$o .= $lmarketing[$value]; 
        // }
        // return $o;
        $o = '';
        $lmarketing = array(1=>'Free', 2=>'Not Free');
		if($row['iSubmit']==1){
			$o .= $lmarketing[$value];
		}else{

	        $o  .= "<select name='".$field."' id='".$id."' class='".$id."'>";            
	        foreach($lmarketing as $k=>$v) {
	        	if($k==$value){
	        		$selected = ' selected ';
	        	}else{
	        		$selected = '';
	        	}
	            $o .= "<option {$selected} value='".$k."'>".$v."</option>";
	        }            
	        $o .= "</select>";

	        $o .="<script>
	        		$('.".$id."').on('change', function() { 
					  if(this.value==2){
					  	$('.export_po_sample_vpo_nomor').attr('disabled', false);
					  	$('.export_po_sample_vpo_nomor').val('');
					  }else{
					  	$('.export_po_sample_vpo_nomor').attr('disabled', true);
					  	$('.export_po_sample_vpo_nomor').val('Auto Generated');
					  }
					}) 
	        	</script>";
		}
        
        return $o;
    }
    
    function insertBox_export_po_sample_itype($field, $id) {
    	$lmarketing = array(1=>'Free', 2=>'Not Free');
        $o  = "<select name='".$field."' id='".$id."' class='".$id."'>";            
        foreach($lmarketing as $k=>$v) {
            $o .= "<option value='".$k."'>".$v."</option>";
        }            
        $o .= "</select>";

        $o .="<script>
        		$('.".$id."').on('change', function() { 
				  if(this.value==2){
				  	$('.export_po_sample_vpo_nomor').attr('disabled', false);
				  	$('.export_po_sample_vpo_nomor').val('');
				  }else{
				  	$('.export_po_sample_vpo_nomor').attr('disabled', true);
				  	$('.export_po_sample_vpo_nomor').val('Auto Generated');
				  }
				}) 
        	</script>";
        return $o;
    }

    function insertBox_export_po_sample_vpo_nomor($name, $id) {
		//return 'this number would be generate automatically';
		return '<input type="text" name="'.$id.'" id="'.$id.'" disabled="true" class="input_rows1 '.$id.'" size="20"  value="Auto Generate"/>';
	}
	function updateBox_export_po_sample_vpo_nomor($name, $id, $value,$row) {
		//return $value;
		//print_r($row);
		$o = '';
		if($row['iSubmit']==1){
			$o .='<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 '.$id.'" size="20" value="'.$value.'"/>';
			$o .= $value;
		}else{
			$o .='<input type="true" name="'.$id.'" id="'.$id.'" class="input_rows1 '.$id.'" size="20" value="'.$value.'"/>';
		}
		return $o;
		// if($row['itype']==2){
		// 	return '<input type="hidden" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$value.'"/>
		// 	<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1 '.$id.'" size="20" value="'.$value.'"/>';
		// }
		// else{
		// 	return '<input type="hidden" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$value.'"/>
		// 	<input type="text" name="'.$id.'" id="'.$id.'" disabled="true" class="input_rows1" size="20" value="'.$value.'"/>';
		// }
		
	}	



	function updateBox_export_po_sample_detail_bahan_baku($name, $id, $value, $rowData) {
		$this->load->helper('search_array');
		$this->db->where('ipo_id', $rowData['ipo_id']);
		$this->db->where('ldeleted', 0);
		$this->db->order_by('ipo_id', 'asc');
		$data['rows'] = $this->db->get('reformulasi.export_po_detail')->result_array();
		$data['browse_url'] = base_url().'processor/reformulasi/';
		return $this->load->view('export/sample/export_po_sample_detail', $data, TRUE);
	}

	function insertBox_export_po_sample_detail_bahan_baku($name, $id) {
		$this->load->helper('search_array');
		$data['rows'] = array();
		$data['browse_url'] = base_url().'processor/reformulasi/';
		return $this->load->view('export/sample/export_po_sample_detail', $data, TRUE);
	}
	
	
	/*
	function insertBox_export_po_sample_trequest($name, $id) {
		return '<input type="hidden" value="'.date('Y-m-d').'" name="'.$name.'" id="'.$id.'" />'.date('l, d F Y');
	}
	function updateBox_export_po_sample_trequest($name, $id, $value) {
		return '<input type="hidden" value="'.date('Y-m-d', strtotime($value)).'" name="'.$name.'" id="'.$id.'" />'.date('l, d F Y', strtotime($value));
	}
	*/

	function insertBox_export_po_sample_trequest($name, $id) {
		$return = '<input type="text" name="'.$name.'"  readonly="readonly" id="'.$id.'"  class="input_rows1 required" size="10" />
					<input type="hidden" name="isdraft" id="isdraft">
		';
		$return .='<script>
				 $("#'.$id.'").datepicker({	changeMonth:true,
											changeYear:true,
											dateFormat:"yy-mm-dd" });
			</script>';
	return $return;
	}

	function updateBox_export_po_sample_trequest($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value ;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />
			<input type="hidden" name="isdraft" id="isdraft">';
			$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		}
		return $return;
	}

	function insertBox_export_po_sample_tdeadline($name, $id) {
		$return = '<input type="text" name="'.$name.'"  readonly="readonly" id="'.$id.'"  class="input_rows1 required" size="10" />
					<input type="hidden" name="isdraft" id="isdraft">
		';
		$return .='<script>
				 $("#'.$id.'").datepicker({	changeMonth:true,
											changeYear:true,
											dateFormat:"yy-mm-dd" });
			</script>';
	return $return;
	}

	function updateBox_export_po_sample_tdeadline($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value ;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />
				      ';
			$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		}
		return $return;
	}

	function insertBox_export_po_sample_vor_nomor($name, $id) {
		$return = '<input type="text" name="'.$name.'"    id="'.$id.'"  class="input_rows1 required" size="10" /> '; 
		return $return;
	}

	function updateBox_export_po_sample_vor_nomor($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value ; 
		}
		else{
			$return = '<input type="text" name="'.$field.'"   id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" /> '; 
		}
		return $return;
	}

	function insertBox_export_po_sample_ttransfer($name, $id) {
		$return = '<input type="text" name="'.$name.'"  readonly="readonly" id="'.$id.'"  class="input_rows1 required" size="10" />
					<input type="hidden" name="isdraft" id="isdraft">
		';
		$return .='<script>
				 $("#'.$id.'").datepicker({	changeMonth:true,
											changeYear:true,
											dateFormat:"yy-mm-dd" });
			</script>';
	return $return;
	}

	function updateBox_export_po_sample_ttransfer($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value ;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />
				      ';
			$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		}
		return $return;
	} 

	function insertBox_export_po_sample_isupplier_id($field, $id) {
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/reformulasi/supplier/list/popup?field=export_po_sample&col=isupplier_id\',\'List Supplier\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function updateBox_export_po_sample_isupplier_id($field, $id, $value) {
		$row = $this->db->get_where('hrd.mnf_supplier', array('isupplier_id'=>$value))->row_array();
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/reformulasi/supplier/list/popup?field=export_po_sample&col=isupplier_id\',\'List Supplier\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	function before_insert_processor($row, $post, $postData) {
		$user = $this->auth_export->user();
		if($postData['itype']==1){
			$query = "select max(poi.ipo_id) as std from reformulasi.export_po poi where poi.itype='1'";
			$rs = $this->db->query($query)->row_array();
			$nomor = intval($rs['std']) + 1;
			$nomor = "PO".str_pad($nomor, 7, "0", STR_PAD_LEFT);
			$postData['vpo_nomor'] = $nomor;			
		}
		else{
			$postData['vpo_nomor'] = $postData['export_po_sample_vpo_nomor'];
			unset($postData['export_po_sample_vpo_nomor']);
		}

		if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } 
        else{$postData['iSubmit']=1; 
    	} 
 
		$skrg = date('Y-m-d H:i:s');
		// unset($postData['ipodet_id']);
		// unset($postData['iexport_request_sample']);
		// unset($postData['detrawid']);
		// unset($postData['detjumlah']);
		// unset($postData['detsatuan']);
		// unset($postData['detmanufacture_id']);
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = $skrg;
		// $postData['tdeadline'] = to_mysql($postData['export_po_sample_tdeadline']);
		// $postData['ttransfer'] = to_mysql($postData['export_po_sample_ttransfer']);
		// unset($postData['export_po_sample_tdeadline']);
		// unset($postData['export_po_sample_ttransfer']);
		// $postData['vor_nomor'] =$postData['export_po_sample_vor_nomor'];
		// unset($postData['export_po_sample_vor_nomor']);
		// $postData['itype'] = $postData['export_po_sample_itype'];
		// unset($postData['export_po_sample_itype']);
		return $postData;
	}

	function before_update_processor($row, $post, $postData) {
		$user = $this->auth_export->user();
		if($postData['itype']==1){
			$query = "select max(poi.ipo_id) as std from reformulasi.export_po poi where poi.itype='1'";
			$rs = $this->db->query($query)->row_array();
			$nomor = intval($rs['std']) + 1;
			$nomor = "PO".str_pad($nomor, 7, "0", STR_PAD_LEFT);
			$postData['vpo_nomor'] = $nomor;			
		}
		else{
			$postData['vpo_nomor'] = $postData['export_po_sample_vpo_nomor'];
			unset($postData['export_po_sample_vpo_nomor']);
		}

		if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } 
        else{$postData['iSubmit']=1; 
    	} 
 
		$skrg = date('Y-m-d H:i:s');
		// unset($postData['ipodet_id']);
		// unset($postData['iexport_request_sample']);
		// unset($postData['detrawid']);
		// unset($postData['detjumlah']);
		// unset($postData['detsatuan']);
		// unset($postData['detmanufacture_id']);
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = $skrg;
		// $postData['tdeadline'] = to_mysql($postData['export_po_sample_tdeadline']);
		// $postData['ttransfer'] = to_mysql($postData['export_po_sample_ttransfer']);
		// unset($postData['export_po_sample_tdeadline']);
		// unset($postData['export_po_sample_ttransfer']);
		// $postData['vor_nomor'] =$postData['export_po_sample_vor_nomor'];
		// unset($postData['export_po_sample_vor_nomor']);
		// $postData['itype'] = $postData['export_po_sample_itype'];
		// unset($postData['export_po_sample_itype']);
		return $postData;
	}

	function after_insert_processor($row, $insertId, $postData) {
		$this->load->helper(array('search_array','mydb'));
		$post = $this->input->post();
		
		$ipodet_id = $post['ipodet_id'];
		$iexport_request_sample = $post['iexport_request_sample'];
		$detrawid = $post['detrawid'];
		$detjumlah = $post['detjumlah'];
		$detsatuan = $post['detsatuan'];
		$detmanufacture_id = $post['detmanufacture_id'];

		


		
		foreach($ipodet_id as $k => $v) {
			if(empty($v)) {
				if(!empty($iexport_request_sample[$k])) {
					$idet['ipo_id'] = $insertId;
					$idet['iexport_request_sample'] = $iexport_request_sample[$k];
					$idet['raw_id'] = $detrawid[$k];
					$idet['ijumlah'] = $detjumlah[$k];
					$idet['vsatuan'] = $detsatuan[$k];
					$idet['imanufacture_id'] = $detmanufacture_id[$k];
					$this->db->insert('reformulasi.export_po_detail', $idet);
				}						
			}
		}
		$ipo_id = $insertId;


			// ketika submit maka kirim message
        	$qsql="select * 
                from reformulasi.export_po a 
                join hrd.employee b on b.cNip=a.cnip
                where a.ldeleted=0
                and a.ipo_id='".$ipo_id."'";
            $rsql = $this->db->query($qsql)->row_array();

            if ($rsql['iSubmit']==1) {
            	
	            // kirim notifikasi message ERp
	            $sqlEmpAr = 'select * from reformulasi.mailsparam a where a.cVariable="export_po_new "';
	            $dEmpAr =  $this->db->query($sqlEmpAr)->row_array();

	            $to = $dEmpAr['vTo'];
	            $cc = $dEmpAr['vCc'];
	            
	            $subject = 'Reformulasi - Need Approval PO '.$rsql['vRequest_no'];
	            $content="
	                Diberitahukan bahwa telah ada Pembuatan PO dengan rincian sebagai berikut :<br><br>  
	                    <table border='0' style='width: 600px;'>
	                        <tr>
	                                <td style='width: 110px;'><b>Requestor </b></td><td style='width: 20px;'> : </td>
	                                <td>".$rsql['cNip'].' || '.$rsql['vName']."</td>
	                        </tr>
	                        <tr>
	                                <td><b>No PO  </b></td><td> : </td>
	                                <td>".$rsql['vpo_nomor']."</td>
	                        </tr> 
	                        <tr>
	                                <td><b>Tanggal PO  </b></td><td> : </td>
	                                <td>".$rsql['trequest']."</td>
	                        </tr> 
	                    </table> 

	                <br/> <br/>
	                Demikian, mohon segera follow up  pada aplikasi ERP Reformulasi. Terimakasih.<br><br><br>
	                Post Master"; 
	            $this->sess_auth->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
	        }

		
	}


	// function before_update_processor($row, $post, $postData) {
	// 	$user = $this->auth_export->user();
	// 	$skrg = date('Y-m-d H:i:s');
	// 	unset($postData['ipodet_id']);
	// 	unset($postData['iexport_request_sample']);
	// 	unset($postData['detrawid']);
	// 	//unset($postData['detnamaproduk']);
	// 	unset($postData['detjumlah']);
	// 	unset($postData['detsatuan']);
	// 	unset($postData['detmanufacture_id']);
	// 	$postData['tdeadline'] = to_mysql($postData['tdeadline']);
	// 	$postData['ttransfer'] = to_mysql($postData['ttransfer']);		
	// 	$postData['cnip'] = $user->gNIP;
	// 	$postData['tupdate'] = $skrg;
	// 	$postData['itype'] = $postData['export_po_sample_itype'];
	// 	if($postData['export_po_sample_itype']==1){
	// 		$query = "select max(poi.ipo_id) as std from reformulasi.export_po poi where poi.itype='1'";
	// 		$rs = $this->db->query($query)->row_array();
	// 		$nomor = intval($rs['std']) + 1;
	// 		$nomor = "PO".str_pad($nomor, 7, "0", STR_PAD_LEFT);
	// 		$postData['vpo_nomor'] = $nomor;
	// 		unset($postData['export_po_sample_vpo_nomor']);
	// 		unset($postData['export_po_sample_vpo_nomor_dis']);
	// 	}
	// 	else{
	// 		$postData['vpo_nomor'] = $postData['export_po_sample_vpo_nomor'];
	// 		unset($postData['export_po_sample_vpo_nomor']);
	// 		unset($postData['export_po_sample_vpo_nomor_dis']);
	// 	}

	// 	if($postData['isdraft']==true){
 //            $postData['iSubmit']=0;
 //        } 
 //        else{
 //        	$postData['iSubmit']=1;
        	

 //    	} 

		
	// 	unset($postData['export_po_sample_itype']);
	// 	$postData['ipo_id'] = $postData['export_po_sample_ipo_id'];
	// 	unset($postData['export_po_sample_ipo_id']);
	// 	//print_r($postData);exit;
	// 	return $postData;
	// }
	function after_update_processor($row, $insertId, $postData, $old_data) {
		$this->load->helper(array('search_array','mydb'));
		//$this->plcdb = mydb('reformulasi');
		$post = $this->input->post();
		
		$ipodet_id = $post['ipodet_id'];
		$iexport_request_sample = $post['iexport_request_sample'];
		$detrawid = $post['detrawid'];
		//$detnamaproduk = $post['detnamaproduk'];
		$detjumlah = $post['detjumlah'];
		$detsatuan = $post['detsatuan'];
		$detmanufacture_id = $post['detmanufacture_id'];
		
		$eRows = $this->db->get_where('reformulasi.export_po_detail', array('ipo_id'=>$insertId, 'ldeleted'=>0))->result_array();
		foreach($eRows as $k => $v) {
			if(in_array($v['ipodet_id'], $ipodet_id)) {
				$this->db->where('ipodet_id', $v['ipodet_id']);
				$key = array_search($v['ipodet_id'], $ipodet_id);
				$this->db->update('reformulasi.export_po_detail', array('iexport_request_sample'=>$iexport_request_sample[$key],'raw_id'=>$detrawid[$key],'ijumlah'=>$detjumlah[$key],'vsatuan'=>$detsatuan[$key],'imanufacture_id'=>$detmanufacture_id[$key]));
				//$this->plcdb->update('export_po_detail', array('iexport_request_sample'=>$iexport_request_sample[$key],'raw_id'=>$detrawid[$key],'vnama_produk'=>$detnamaproduk[$key],'ijumlah'=>$detjumlah[$key],'vsatuan'=>$detsatuan[$key],'imanufacture_id'=>$detmanufacture_id[$key]));
			}
			else {
				$this->db->where('ipodet_id', $v['ipodet_id']);
				$this->db->update('reformulasi.export_po_detail', array('ldeleted'=>1));
			}
		}


		foreach($ipodet_id as $k => $v) {
			if(empty($v)) {
				if(!empty($iexport_request_sample[$k])) {
					$idet['ipo_id'] = $insertId;
					$idet['iexport_request_sample'] = $iexport_request_sample[$k];
					$idet['raw_id'] = $detrawid[$k];
					//$idet['vnama_produk'] = $detnamaproduk[$k];
					$idet['ijumlah'] = $detjumlah[$k];
					$idet['vsatuan'] = $detsatuan[$k];
					$idet['imanufacture_id'] = $detmanufacture_id[$k];
					$this->db->insert('reformulasi.export_po_detail', $idet);
				}						
			}
		}
		$ipo_id = $insertId;



		$sql2="select * from reformulasi.export_po a where a.ipo_id=$insertId";
		$list_po=$this->db->query($sql2)->row_array();


		// ketika submit maka kirim message
    	$qsql="select * 
            from reformulasi.export_po a 
            join hrd.employee b on b.cNip=a.cnip
            where a.ldeleted=0
            and a.ipo_id='".$ipo_id."'";
        $rsql = $this->db->query($qsql)->row_array();

        if ($rsql['iSubmit']==1) {
        	
            // kirim notifikasi message ERp
            $sqlEmpAr = 'select * from reformulasi.mailsparam a where a.cVariable="export_po_new "';
            $dEmpAr =  $this->db->query($sqlEmpAr)->row_array();

            $to = $dEmpAr['vTo'];
            $cc = $dEmpAr['vCc'];
            
            $subject = 'Reformulasi - Need Approval PO '.$rsql['vRequest_no'];
            $content="
                Diberitahukan bahwa telah ada Pembuatan PO dengan rincian sebagai berikut :<br><br>  
                    <table border='0' style='width: 600px;'>
                        <tr>
                                <td style='width: 110px;'><b>Requestor </b></td><td style='width: 20px;'> : </td>
                                <td>".$rsql['cNip'].' || '.$rsql['vName']."</td>
                        </tr>
                        <tr>
                                <td><b>No PO  </b></td><td> : </td>
                                <td>".$rsql['vpo_nomor']."</td>
                        </tr> 
                        <tr>
                                <td><b>Tanggal PO  </b></td><td> : </td>
                                <td>".$rsql['trequest']."</td>
                        </tr> 
                    </table> 

                <br/> <br/>
                Demikian, mohon segera follow up  pada aplikasi ERP Reformulasi. Terimakasih.<br><br><br>
                Post Master"; 
            $this->sess_auth->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
        }


		
	}

function getMax(){
	$ireqdet_id=$_POST['ireqdet_id'];
	$data = array();

	$sql2 = "SELECT * FROM reformulasi.export_request_sample_detail c  where c.ireqdet_id='".$ireqdet_id."'";
	$data2 = $this->db->query($sql2)->row_array();

	$sql22 = "select sum(a.ijumlah) as sumjumlah from reformulasi.export_po_detail a where a.raw_id='".$data2['raw_id']."' and a.iexport_request_sample='".$data2['iexport_request_sample']."'";

	echo $sql22;
	exit;
	$data22 = $this->db->query($sql22)->row_array();
 	
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