<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
stabilita hanya bisa diisi dan approve oleh PD
*/
class Product_trial_stabilita_lab extends MX_Controller {
	function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->user = $this->auth->user();
		$this->load->library('biz_process');
        $this->load->library('lib_utilitas');
		$this->url = 'product_trial_stabilita_lab';
    }
    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle('Stabilita Lab');		
		$grid->setTable('plc2.plc2_upb_stabilita');		
		$grid->setUrl('product_trial_stabilita_lab');
		//$grid->addList('vkode_surat','vupb_nomor','vupb_nama','vgenerik','iteampd_id','plc2_upb_stabilita.inumber','isucced','tdate');
		$grid->addList('plc2_upb_formula.vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','inumber','isucced','tdate','iapppd');
		//$grid->addList('plc2_upb_formula.vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','plc2_upb.iteampd_id','inumber','isucced','tdate','iapppd');
		$grid->setSortBy('ista_id');
		$grid->setSortOrder('DESC');
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setAlign('inumber', 'center');
		$grid->setAlign('tdate', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '100');
		$grid->setWidth('inumber', '160');
		$grid->setFormWidth('inumber',10);
		$grid->setFormWidth('plc2_upb.vupb_nama',100);
		$grid->setWidth('tdate', '140');
		$grid->setWidth('iteampd_id', '150');
		$grid->setWidth('plc2_upb.vupb_nama', '250');
		$grid->setWidth('plc2_upb.vgenerik', '250');
		$grid->addFields('vkode_surat','vupb_nomor','vupb_nama','vgenerik','vrevisi','iteampd_id');
		$grid->addFields('inumber','tdate','vrealtime','vaccelerate','isucced','vnip_apppd','history_stabilita');
		
		//$grid->setRequired();
		$grid->setLabel('plc2_upb_formula.vkode_surat', 'No. Formulasi');
		$grid->setLabel('vkode_surat', 'No. Formulasi');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('vrealtime', 'Real Time Test');
		$grid->setLabel('vaccelerate', 'Accelerated Test');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('plc2_upb.iteampd_id', 'Team PD');
		$grid->setLabel('iteampd_id', 'Team PD');
		$grid->setLabel('inumber', 'Stabilita Bulan ke');
		$grid->setLabel('isucced', 'Status Stabilita');
		$grid->setLabel('tdate', 'Tanggal Stabilita');
		$grid->setLabel('vrevisi', 'Revisi');
		$grid->setLabel('vnip_apppd', 'PD Approval');
		$grid->setLabel('iapppd', 'PD Approval');
		$grid->setLabel('history_stabilita', 'History Stabilita');
	//	$grid->setLabel('ispekfg_id', 'No. Spek FG');
				
		$grid->setQuery('plc2_upb_stabilita.ldeleted', 0);	
		$grid->setQuery('plc2.plc2_upb_stabilita.inumber =(select max(st2.inumber) from plc2.plc2_upb_stabilita st2 where plc2_upb_stabilita.ifor_id=st2.ifor_id and st2.ldeleted=0)', null);

		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		
		$grid->setJoinTable('plc2.plc2_upb_formula', 'plc2_upb_stabilita.ifor_id = plc2.plc2_upb_formula.ifor_id', 'LEFT');
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id', 'LEFT');
		$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));
		//$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner');
		
		$grid->changeFieldType('isucced','combobox','',array(0=>'Belum Stabilita', 1=>'Tidak Memenuhi Syarat (TMS)', 2=>'Memenuhi Syarat (MS)', 3=>'Belum Analisa'));
		//$grid->changeFieldType('iapppd','combobox','',array(''=>'',0=>'Waiting For Approval', 1=>'Reject', 2=>'Approved'));
		$grid->changeFieldType('vrealtime','text');
		$grid->changeFieldType('vaccelerate','text');
		
		//$grid->setSearch('vkode_surat','vupb_nomor','vupb_nama','vgenerik','iteampd_id','inumber','isucced','tdate');
		$grid->setSearch('inumber','plc2_upb_formula.vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','tdate','iapppd');
		$grid->setQuery('plc2_upb.ihold', 0);
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
		    	
		    	$this->db_plc0->where('ista_id', $get['last_id']);
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove = $get['type'] == 'PD' ? 'iapppd' : '';
				$this->db_plc0->update('plc2.plc2_upb_stabilita', array($iapprove=>2,'vnip_apppd'=>$nip,'tapppd'=>$skg));
		    
		    	$upbid = $post['iupb_id'];
				$ifor_id=$this->input->get('ifor_id');
				$ista_id=$this->input->get('last_id');
		    	/*$ins['iupb_id'] = $get['iupb_id'];
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
		        */
		        $hsql= "select vkode_surat from plc2.plc2_upb_formula where ifor_id = ".$ifor_id;
		        $forName = $this->db_plc0->query($hsql)->row_array();
		        
		        //$forName= $rupb['vkode_surat'];
		                
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

		        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
		        
		        $toEmail2='';
		        $toEmail = $this->lib_utilitas->get_email_team( $pd );
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
		        $subject="Proses Stabilita Lab Selesai: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada approval pada proses Stabilita Lab(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
		                <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
		                        <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
		                                <tr>
		                                        <td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Nomor Formulasi</b></td><td> : </td><td>".$forName['vkode_surat']."</td>
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
		                                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>Best Formula - Approval oleh PD</td>
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

				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Confirm Success!';
				echo json_encode($r);
				exit();
			default:
				$grid->render_grid();
				break;
		}
    }
	
	function manipulate_update_button($buttons, $rowData) {
    	//print_r($rowData);
		if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			unset($buttons['update_back']);
			unset($buttons['update']);
			
			//echo $rowData['vnip_formulator']."<br>".$this->user->gNIP;
			$user = $this->auth->user();
		
			$x=$this->auth->dept();
			if($this->auth->is_manager()){
				$x=$this->auth->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){$type='PD';}
				else{$type='';}
			}
			else{
				$x=$this->auth->dept();
				$team=$x['team'];
				if(in_array('PD', $team)){$type='PD';}
				else{$type='';}
			}
			// cek status upb, klao upb 
				unset($buttons['update_back']);
				unset($buttons['update']);
				
				//echo $this->auth->my_teams();
				
				$ifor_id=$rowData['ifor_id'];
				$ista_id=$rowData['ista_id'];
				$qcek="select f.iapppd from plc2.plc2_upb_stabilita f where f.ista_id=$ista_id";
				$rcek = $this->db_plc0->query($qcek)->row_array();
				
				//get upb_id
				$qupb="select f.iupb_id from plc2.plc2_upb_formula f where f.ifor_id=$ifor_id";
				$rupb = $this->db_plc0->query($qupb)->row_array();
				
				$rowData['iupb_id']=$rupb['iupb_id'];
				//echo "<pre>";print_r($rowData);echo "</pre>"; exit();
				$sql= "select * from plc2.plc2_upb up 
					where up.iupb_id=".$rowData['iupb_id'];
				$dt=$this->db_plc0->query($sql)->row_array();
				$setuju = '<button onclick="javascript:setuju(\'product_trial_stabilita_lab\', \''.base_url().'processor/plc/product/trial/stabilita/lab?action=confirm&last_id='.$this->input->get('id').'&type='.$type.'&ifor_id='.$ifor_id.'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Confirm</button>';
				$js=$this->load->view('product_trial_stabilita_lab_js');
				$x=$this->auth->my_teams();
				//print_r($x);
				$arrhak=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
			//print_r($arrhak);
				if(empty($arrhak)){
					$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
					if(empty($getbp)){}
					else{
						if($this->auth->is_manager()){ //jika manager PD
							if(($type=='PD')&&($rowData['iapppd']==0)){
								$update = '<button onclick="javascript:update_btn_upload(\'product_trial_stabilita_lab\', \''.base_url().'processor/plc/product/trial/stabilita/lab?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stabilita/lab?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ista_id='.$rowData['ista_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Approve</button>';
								// $reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stabilita/lab?action=reject&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ista_id='.$rowData['ista_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Reject</button>';
									
								$buttons['update'] = $update.$setuju.$js;
							}
							else{}
						}
						else{
							//echo 'a'.$type;
							if(($type=='PD')&&($rowData['iapppd']==0)){
								$update = '<button onclick="javascript:update_btn_upload(\'product_trial_stabilita_lab\', \''.base_url().'processor/plc/product/trial/stabilita/lab?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
								$buttons['update'] = $update;
							}
						}
					}
				}else{
					if($this->auth->is_manager()){ //jika manager PD
						if(($type=='PD')&&($rowData['iapppd']==0)){
								$update = '<button onclick="javascript:update_btn_upload(\'product_trial_stabilita_lab\', \''.base_url().'processor/plc/product/trial/stabilita/lab?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stabilita/lab?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ista_id='.$rowData['ista_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Approve</button>';
								// $reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stabilita/lab?action=reject&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ista_id='.$rowData['ista_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Reject</button>';
									
								$buttons['update'] = $update.$setuju.$js;
							}
						else{}
						//array_unshift($buttons, $reject, $approve, $revise);
					}
					else{
						//echo 'a'.$type;
						if(($type=='PD')&&($rowData['iapppd']==0)){
								$update = '<button onclick="javascript:update_btn_upload(\'product_trial_stabilita_lab\', \''.base_url().'processor/plc/product/trial/stabilita/lab?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
								$buttons['update'] = $update;
						}
						else{}
					}
				}
		}
   
    	return $buttons;
    }
    public function listBox_Action($row, $actions) {
    	//cek apakah ada soi mikro upb itu yg statusnya sudah Final, 
		//print_r($row); exit;
		$forid=$row->ifor_id;
    	
		// jika stabilita lab sudah di app tidak bisa di edit
		if($row->iapppd<>0){
			unset($actions['edit']);
			unset($actions['delete']);
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
								var url = "'.base_url().'processor/plc/product/trial/stabilita/lab";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_product_trial_stabilita_lab").html(data);
									});
					
								}
									reload_grid("grid_product_trial_stabilita_lab");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_product_trial_stabilita_lab_approve" action="'.base_url().'processor/plc/product/trial/stabilita/lab?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="ista_id" value="'.$this->input->get('ista_id').'" />
    			<input type="hidden" name="ifor_id" value="'.$this->input->get('ifor_id').'" />
    			<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_product_trial_stabilita_lab_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
	 	$this->db_plc0->where('ista_id', $post['ista_id']);
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$iapprove = $post['type'] == 'PD' ? 'iapppd' : '';
		$this->db_plc0->update('plc2.plc2_upb_stabilita', array($iapprove=>2,'vnip_apppd'=>$nip,'tapppd'=>$skg));
    
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
        
        $hsql= "select vkode_surat from plc2.plc2_upb_formula where ifor_id = ".$ifor_id;
        $forName = $this->db_plc0->query($hsql)->row_array();
        
        //$forName= $rupb['vkode_surat'];
                
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

        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
        
        $toEmail2='';
        $toEmail = $this->lib_utilitas->get_email_team( $pd );
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
        $subject="Proses Stabilita Lab Selesai: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval pada proses Stabilita Lab(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
                <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
                        <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
                                <tr>
                                        <td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
                                </tr>
                                <tr>
                                        <td><b>Nomor Formulasi</b></td><td> : </td><td>".$forName['vkode_surat']."</td>
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
                                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>Best Formula - Approval oleh PD</td>
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
    	$data['last_id'] = $ista_id;
    	return json_encode($data);
    }
    
    // function reject_view() {
    	// $echo = '<script type="text/javascript">
					 // function submit_ajax(form_id) {
					 	 // return $.ajax({
					 	 	// url: $("#"+form_id).attr("action"),
					 	 	// type: $("#"+form_id).attr("method"),
					 	 	// data: $("#"+form_id).serialize(),
					 	 	// success: function(data) {
					 	 		// var o = $.parseJSON(data);
								// var last_id = o.last_id;
								// var url = "'.base_url().'processor/plc/product/trial/stabilita/lab";
								// if(o.status == true) {
									// //alert("aaaa");
									// $("#alert_dialog_form").dialog("close");
										 // $.get(url+"?action=update&id="+last_id, function(data) {
										 // $("div#form_product_trial_stabilita_lab").html(data);
									// });
					
								// }
									// reload_grid("grid_product_trial_stabilita_lab");
							// }
					 	 // })
					 // }
				 // </script>';
    	// $echo .= '<h1>Reject</h1><br />';
    	// $echo .= '<form id="form_product_trial_stabilita_lab_reject" action="'.base_url().'processor/plc/product/trial/stabilita/lab?action=reject_process" method="post">';
    	// $echo .= '<div style="vertical-align: top;">';
    	// $echo .= 'Remark : 
				// <input type="hidden" name="ista_id" value="'.$this->input->get('ista_id').'" />
    			// <input type="hidden" name="ifor_id" value="'.$this->input->get('ifor_id').'" />
    			// <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
				// <input type="hidden" name="type" value="'.$this->input->get('type').'" />
				// <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				// <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				// <textarea name="remark"></textarea><button type="button" onclick="submit_ajax(\'form_product_trial_stabilita_lab_reject\')">Reject</button>';
    	// $echo .= '</div>';
    	// $echo .= '</form>';
    	// return $echo;
    // }
    
    // function reject_process () {
    	// $post = $this->input->post();
    	
    	// $this->db_plc0->where('ifor_id', $post['ifor_id']);
		// $nip = $this->user->gNIP;
		// $skg=date('Y-m-d H:i:s');
	 	// $iapprove = $post['type'] == 'PD' ? 'iapppd' : '';
    	// $this->db_plc0->update('plc2.plc2_upb_stabilita', array($iapprove=>1,'vnip_apppd'=>$nip,'tapppd'=>$skg));
    
    	// $ins['iupb_id'] = $post['iupb_id'];
		// $ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
		// $ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
		// $ins['idiv_id'] = '';
		// $ins['vtipe'] = $post['type'];
		// $ins['iapprove'] = '2';
		// $ins['cnip'] = $this->user->gNIP;
		// $ins['treason'] = $post['remark'];
		// $ins['tupdate'] = date('Y-m-d H:i:s');
    
    	// $this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
    
		// $getbp=$this->biz_process->get(1, $this->auth->my_teams(),$post['modul_id']); // 1 approval
		// $bizsup=$getbp['idplc2_biz_process_sub'];
		
		// $ifor_id=$this->input->post('ifor_id');
		// $ista_id=$this->input->post('ista_id');
		// // $qcek="select count(f.ifor_id) as jum from plc2.plc2_upb_stabilita f where f.ifor_id=$ifor_id";
		// // $rcek = $this->db_plc0->query($qcek)->row_array();
		// // //jika sudah pernah ada stress test utk ups & spek_fg tsb maka
		
		// $hacek=$this->biz_process->cek_last_status($post['iupb_id'],$bizsup,2); // status 2 => reject
		// if($hacek==1){ // jika sudah pernah ada data maka update saja
			// //insert log
				// $this->biz_process->insert_log($post['iupb_id'], $bizsup, 2); // status 2 => reject
			// //update last log
				// $this->biz_process->update_last_log($post['iupb_id'], $bizsup, 2);
		// }
		// elseif($hacek==0){
			// //insert log
				// $this->biz_process->insert_log($post['iupb_id'], $bizsup, 2); // status 2 => reject
			// //insert last log
				// $this->biz_process->insert_last_log($post['iupb_id'], $bizsup, 2);
		// }			
		
    	// $data['status']  = true;
    	// $data['last_id'] = $ista_id;
    	// return json_encode($data);
    // }
	function insertBox_product_trial_stabilita_lab_history_stabilita($field, $id) {
		return '-';
	}
	function updateBox_product_trial_stabilita_lab_history_stabilita($name, $id, $value, $rowData) {
		//print_r($rowData);
		$ifor_id=$rowData['ifor_id'];
		//get upb_id
			$qupb="select f.iupb_id from plc2.plc2_upb_formula f where f.ifor_id=$ifor_id";
			$rupb = $this->db_plc0->query($qupb)->row_array();
			
			$iupb_id=$rupb['iupb_id'];
		
		 $sql="select f.vkode_surat from plc2.plc2_upb_formula f where f.ifor_id=$ifor_id";
		 $res=$this->db_plc0->query($sql)->row_array();
		 $data['vkode_surat']=$res['vkode_surat'];
		 $data['ifor_id']=$ifor_id;
		 $data['ista_id']=$rowData['ista_id'];
		return $this->load->view('product_trial_stabilita_lab_history',$data,TRUE);
	}
	function listBox_product_trial_stabilita_lab_iapppd($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	//Keterangan approval 
	function insertBox_product_trial_stabilita_lab_vnip_apppd($field, $id) {
		return '-';
	}
	function updateBox_product_trial_stabilita_lab_vnip_apppd($field, $id, $value, $rowData) {
		//print_r($rowData);
		if($rowData['vnip_apppd'] != null){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_apppd']))->row_array();
			if($rowData['iapppd']==2){$st="Approved";}elseif($rowData['iapppd']==1){$st="Rejected";
				// $rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// if(isset($rowa)){$reason=$rowa['treason'];}
				
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_apppd'].' )'.' pada '.$rowData['tapppd'];
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	//
	function insertBox_product_trial_stabilita_lab_inumber($field, $id) {
		// $return = '<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1" size="2" onkeypress="return isNumberKey(event)"/>';
		 
		return 'Automated Generate';
	}
	
	function updateBox_product_trial_stabilita_lab_inumber($field, $id, $value) {
		$return = $value.' <input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1" size="2"/>';
		return $return;
	}
	function insertBox_product_trial_stabilita_lab_vupb_nomor($field, $id) {
		$return = '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="40" />';
		return $return;
	}
	function insertBox_product_trial_stabilita_lab_vupb_nama($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="40" />';
	}
	function insertBox_product_trial_stabilita_lab_vgenerik($field, $id) {
		return '<textarea disabled="TRUE" name="'.$id.'" id="'.$id.'"></textarea>';
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="40" />';
	}
	function insertBox_product_trial_stabilita_lab_iteampd_id($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="40" />';
	}
	function insertBox_product_trial_stabilita_lab_vrevisi($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="40" />';
	}
	
	function insertBox_product_trial_stabilita_lab_vkode_surat($field, $id) {
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
		$return .= '&nbsp;<button class="icon_pop" onclick="browse(\''.base_url().'processor/plc/browse/formula/stablab?action=index&field=product_trial_stabilita_lab\',\'\',\'\',\'List Formula\')" type="button">&nbsp;</button>';
	
		return $return;
	}
	
	 function updateBox_product_trial_stabilita_lab_vkode_surat($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb_formula', array('ifor_id'=>$rowData['ifor_id']))->row_array();
		$return = '<script>
		 $( "button.icon_pop" ).button({
		 		icons: {
		 		primary: "ui-icon-newwin"
		 		},
		 		text: false
		 		})
		</script>';
		$return = '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$rowData['ifor_id'].'" />';
		$return .= '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$row['vkode_surat'].'" />';
		//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/spek/fg/list/trial/popup?field=product_trial_formula_skala_lab\',\'List Spesifikasi FG\')" type="button">&nbsp;</button>';
	
		return $return;
	} 
	function updateBox_product_trial_stabilita_lab_vrevisi($field, $id, $value, $rowData) {
		/*$sql = "SELECT vrevisi FROM plc2.plc2_upb_stabilita s, plc2.plc2_upb_formula f, plc2.plc_upb u
				WHERE s.ifor_id = f.ifor_id AND f.iupb_id=u.iupb_id";*/
		$row=$this->db_plc0->get_where('plc2.plc2_upb_formula', array('ifor_id'=> $rowData['ifor_id']))->row_array();
		return '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" value="'.$row['vrevisi'].'" class="input_rows1" />';
	}
	
	function updateBox_product_trial_stabilita_lab_vupb_nomor($field, $id, $value, $rowData) {
		$sql = "SELECT vupb_nomor FROM plc2.plc2_upb_stabilita s, plc2.plc2_upb_formula f, plc2.plc2_upb u
				WHERE s.ifor_id = f.ifor_id AND f.iupb_id=u.iupb_id AND s.ifor_id='".$rowData['ifor_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		//$row=$this->db_plc0->get_where('plc2.plc2_upb_formula', array('ifor_id'=> $rowData['ifor_id']))->row_array();
		return '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" value="'.$row['vupb_nomor'].'" class="input_rows1" />';
	}
	function updateBox_product_trial_stabilita_lab_vupb_nama($field, $id, $value, $rowData) {
		$sql = "SELECT u.vupb_nama as vupb_nama FROM plc2.plc2_upb_stabilita s, plc2.plc2_upb_formula f, plc2.plc2_upb u
				WHERE s.ifor_id = f.ifor_id AND f.iupb_id=u.iupb_id AND s.ifor_id='".$rowData['ifor_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		//$row=$this->db_plc0->get_where('plc2.plc2_upb_formula', array('ifor_id'=> $rowData['ifor_id']))->row_array();
		return '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" value="'.$row['vupb_nama'].'" size="20" class="input_rows1" />';
	}
	function updateBox_product_trial_stabilita_lab_vgenerik($field, $id, $value, $rowData) {
		$sql = "SELECT u.vgenerik as vgenerik FROM plc2.plc2_upb_stabilita s, plc2.plc2_upb_formula f, plc2.plc2_upb u
				WHERE s.ifor_id = f.ifor_id AND f.iupb_id=u.iupb_id AND s.ifor_id='".$rowData['ifor_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		//$row=$this->db_plc0->get_where('plc2.plc2_upb_formula', array('ifor_id'=> $rowData['ifor_id']))->row_array();
		return '<textarea disabled="TRUE" name="'.$id.'" id="'.$id.'" style="width:275px" >'.$row['vgenerik'].'</textarea>';
		//return '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'"  class="input_rows1" />';
	}
	function updateBox_product_trial_stabilita_lab_iteampd_id($field, $id, $value, $rowData) {
		$sql = "SELECT vteam FROM plc2.plc2_upb_stabilita s, plc2.plc2_upb_formula f, plc2.plc2_upb u, plc2.plc2_upb_team t
				WHERE s.ifor_id = f.ifor_id AND f.iupb_id=u.iupb_id AND u.iteampd_id = t.iteam_id AND s.ifor_id='".$rowData['ifor_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		//$row=$this->db_plc0->get_where('plc2.plc2_upb_formula', array('ifor_id'=> $rowData['ifor_id']))->row_array();
		return '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" value="'.$row['vteam'].'" class="input_rows1" />';
	}
	
	function updateBox_product_trial_stabilita_lab_tdate($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'" style="width:130px;" />';
		return $return;
	}

	function before_insert_processor($row, $postData) {
		
		$this->load->helper('to_mysql');
		$skrg = date('Y-m-d H:i:s');
		$postData['tdate'] = to_mysql($postData['tdate']);
		$postData['ifor_id'] =$postData['vkode_surat'];
		$ifor_id=$postData['vkode_surat'];
		
		$sel="select max(st.inumber) as inumber, st.ista_id,st.ifor_id,st.iapppd from plc2.plc2_upb_stabilita st 
				where st.ifor_id=$ifor_id and st.iapppd=2";
		$rowc = $this->db_plc0->query($sel)->row_array();
		
		if($rowc['inumber']==null){$postData['inumber']=0;}
		elseif($rowc['inumber']==0){$postData['inumber']=1;}
		elseif($rowc['inumber']==1){$postData['inumber']=3;}
		elseif($rowc['inumber']==3){$postData['inumber']=6;}
		
		unset($postData['vkode_surat']);
		unset($postData['vrevisi']);
		//unset($postData['vupb_nomor']);
		unset($postData['vupb_nama']);
		unset($postData['vgenerik']);
		unset($postData['iteampd_id']);
		//print_r($postData);
		return $postData;
	}
	function after_insert_processor($row, $insertId, $postData) {
		$getbp=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // activity 3 input data
		$bizsup=$getbp['idplc2_biz_process_sub'];
		
		//getiupb_id
		$ifor_id=$postData['vkode_surat'];
		$sel="select * from plc2.plc2_upb_formula f where f.ifor_id=$ifor_id";
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
	
		//update tabel formula
		$isucced=$postData['isucced'];
		if($postData['inumber']==6){
			$sqlu = "Update plc2.plc2_upb_formula set isucced = '".$isucced."', isucced6='".$isucced."' where ifor_id='".$ifor_id."'";	
			$this->db_plc0->query($sqlu);
		}
		else{
			$sqlu = "Update plc2.plc2_upb_formula set isucced = '".$isucced."' where ifor_id='".$ifor_id."'";	
			$this->db_plc0->query($sqlu);
		}
	}
	function before_update_processor($row, $postData) {
		$this->load->helper('to_mysql');
		$skrg = date('Y-m-d H:i:s');
		//print_r($postData); exit;
		$postData['tdate'] = to_mysql($postData['tdate']);
		unset($postData['vkode_surat']);
		unset($postData['vrevisi']);
		unset($postData['vupb_nomor']);
		unset($postData['vupb_nama']);
		unset($postData['vgenerik']);
		unset($postData['iteampd_id']);
		return $postData;
	}
	function after_update_processor($row, $updateId, $postData) {
		$getbp=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // activity 3 input data
		$bizsup=$getbp['idplc2_biz_process_sub'];
		
		//getiupb_id
		$ifor_id=$postData['vkode_surat'];
		$sel="select * from plc2.plc2_upb_formula f where f.ifor_id=$ifor_id";
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
		$skrg = date('Y-m-d H:i:s');
		$sql = "Update plc2.plc2_upb_stabilita set tUpdate = '".$skrg."' where ista_id='".$updateId."'";	
	//echo $sql;	
		$this->db_plc0->query($sql);
		
		//update tabel formula
		$isucced=$postData['isucced'];
		if($postData['inumber']==6){
			$sqlu = "Update plc2.plc2_upb_formula set isucced = '".$isucced."', isucced6='".$isucced."' where ifor_id='".$ifor_id."'";	
			$this->db_plc0->query($sqlu);
		}
		else{
			$sqlu = "Update plc2.plc2_upb_formula set isucced = '".$isucced."' where ifor_id='".$ifor_id."'";	
			$this->db_plc0->query($sqlu);
		}
		
	}
	function output(){
    	$this->index($this->input->get('action'));
    }
}
