<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sample_permintaan_sample extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
			$this->load->library('auth_localnon');
		$this->user = $this->auth_localnon->user();
		$this->load->library('biz_process');
        $this->load->library('lib_utilitas');
		$this->_table = 'plc2.plc2_upb_request_sample';
		$this->_table_plc_upb = 'plc2.plc2_upb';
		$this->_table_plc_team = 'plc2.plc2_upb_team';
		$this->_table_employee = 'hrd.employee';
		$this->load->helper('to_mysql');
		$this->load->library('lib_flow');
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('Permintaan Sample');		
		$grid->setTable($this->_table);		
		$grid->setUrl('sample_permintaan_sample');
		$grid->addList('vreq_nomor','trequest','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.iteampd_id','iapppd');
		$grid->setJoinTable($this->_table_plc_upb, $this->_table_plc_upb.'.iupb_id = '.$this->_table.'.iupb_id', 'inner');
		$grid->setSortBy('vreq_nomor');
		$grid->setSortOrder('desc');
		$grid->setRelation($this->_table_plc_upb.'.iteampd_id', $this->_table_plc_team, 'iteam_id', 'vteam', 'bdteam','inner', array('vtipe'=>'PD','ldeleted'=>0), array('vteam'=>'asc'));		
		$grid->setSearch('vreq_nomor','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.iteampd_id'); //,'trequest'
		$grid->addFields('vreq_nomor','cRequestor','iTujuan_req','iupb_id','vupb_nama','iteampd_id','trequest','detail','vnip_apppd');
		$grid->setRequired('iupb_id','trequest');
		$grid->setWidth('vreq_nomor', 90);
		$grid->setWidth('trequest', 90);
		$grid->setWidth('plc2_upb.vupb_nomor', 70);
		$grid->setWidth('plc2_upb.iteampd_id', 120);
		
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.iteampd_id','Team PD');
		$grid->setLabel('iteampd_id','Team PD');
		$grid->setLabel('vreq_nomor','No. Permintaan');
		$grid->setLabel('itipe','Kemasan');
		$grid->setLabel('trequest','Tanggal permintaan');
		$grid->setLabel('detail','Detail Bahan Baku');
		$grid->setLabel('iapppd','Approval PD');
		$grid->setLabel('vnip_apppd','Approval PD');
		$grid->setLabel('iTujuan_req','Tujuan Request');
		$grid->setLabel('cRequestor','Requestor');
		
		$grid->setQuery('plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2_upb_request_sample.ldeleted', 0);
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/
		
		//Query PD
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		//$grid->setGridView('grid');
		
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

    function listBox_Action($row, $actions) {
    	//cek apakah ada soi mikro upb itu yg statusnya sudah Final, 
		//print_r($row); exit;
		$approval=$row->iapppd;
    	//formulator
		if($approval!=0){
			unset($actions['edit']);
			unset($actions['delete']);
		}

		return $actions;
    }

    function manipulate_insert_button($buttons) {
		unset($buttons['save']);

		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'sample_permintaan_sample\', \''.base_url().'processor/plc/sample/permintaan/sample?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_sample_permintaan_sample">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'sample_permintaan_sample\', \''.base_url().'processor/plc/sample/permintaan/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_sample_permintaan_sample">Save &amp; Submit</button>';
		$js = $this->load->view('lokal/permintaan_sample_bb_js');
		$buttons['save'] = $save_draft.$save.$js;

		return $buttons;
	}

	function manipulate_update_button($buttons, $rowData) {
    	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			unset($buttons['update_back']);
			unset($buttons['update']);
			$js = $this->load->view('lokal/permintaan_sample_bb_js');
			//print_r($rowData);
			//echo $rowData['vnip_formulator']."<br>".$this->user->gNIP;
			$user = $this->auth_localnon->user();
		
			$x=$this->auth_localnon->dept();
			if($this->auth_localnon->is_manager()){
				$x=$this->auth_localnon->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){$type='PD';}
				else{$type='';}
			}
			else{
				$x=$this->auth_localnon->dept();
				$team=$x['team'];
				if(in_array('PD', $team)){$type='PD';}
				else{$type='';}
			}
			// cek status upb, klao upb 
				unset($buttons['update_back']);
				unset($buttons['update']);
				
				//echo $this->auth_localnon->my_teams();
				
				$iupb_id=$rowData['iupb_id'];
				$ireq_id=$rowData['ireq_id'];

				$qcek="select * from plc2.plc2_upb_request_sample f where f.ireq_id=$ireq_id";
				$rcek = $this->db_plc0->query($qcek)->row_array();
				
				$x=$this->auth_localnon->my_teams();
				//print_r($x);
				//$arrhak=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
			//print_r($arrhak);
				$update = '<button onclick="javascript:update_btn_back(\'sample_permintaan_sample\', \''.base_url().'processor/plc/sample/permintaan/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save bt_permintaan_sample" id="button_update_permintaan_sample">Update & Submit</button>';
				$updatedraft = '<button onclick="javascript:update_draft_btn(\'sample_permintaan_sample\', \''.base_url().'processor/plc/sample/permintaan/sample?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_draft_sample_permintaan_sample">Update as Draft</button>';

//				if(empty($arrhak)){
//					$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
//					if(empty($getbp)){}
//					else{
						if($this->auth_localnon->is_manager()){ //jika manager PD
							if(($type=='PD')&&($rcek['iapppd']==0)){
							//	$update = '<button onclick="javascript:update_btn_upload(\'sample_permintaan_sample\', \''.base_url().'processor/plc/sample/permintaan/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/sample/permintaan/sample?action=approve&iupb_id='.$rowData['iupb_id'].'&ireq_id='.$ireq_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Approve</button>';
								$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/sample/permintaan/sample?action=reject&iupb_id='.$rowData['iupb_id'].'&ireq_id='.$ireq_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Reject</button>';
									
								//$buttons['update'] = $update.$approve.$reject;
								if ($rowData['iSubmit']==1) {
									$buttons['update'] = $update.$approve.$reject.$js;
								}else{
									$buttons['update'] = $updatedraft.$update.$js;
								}
								
							}
							else{}
						}
						else{
							if(($type=='PD')&&($rcek['iapppd']==0)){
							//	$update = '<button onclick="javascript:update_btn_upload(\'sample_permintaan_sample\', \''.base_url().'processor/plc/sample/permintaan/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
								if ($rowData['iSubmit']!=1) {
									$buttons['update'] = $updatedraft.$update.$js;
								}
								
							}
						}
					//}
//				}else{
/*					
					if($this->auth_localnon->is_manager()){ //jika manager PD
						if(($type=='PD')&&($rcek['iapppd']==0)){
								$update = '<button onclick="javascript:update_btn_upload(\'sample_permintaan_sample\', \''.base_url().'processor/plc/sample/permintaan/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/sample/permintaan/sample?action=approve&iupb_id='.$rowData['iupb_id'].'&ireq_id='.$ireq_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Approve</button>';
								$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/sample/permintaan/sample?action=reject&iupb_id='.$rowData['iupb_id'].'&ireq_id='.$ireq_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Reject</button>';
									
								$buttons['update'] = $update.$approve.$reject;
							}
						else{}
						//array_unshift($buttons, $reject, $approve, $revise);
					}
					else{
						if(($type=='PD')&&($rcek['iapppd']==0)){
								$update = '<button onclick="javascript:update_btn_upload(\'sample_permintaan_sample\', \''.base_url().'processor/plc/sample/permintaan/sample?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
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
								var url = "'.base_url().'processor/plc/sample/permintaan/sample";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_sample_permintaan_sample").html(data);
									});
					
								}
									reload_grid("grid_sample_permintaan_sample");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_sample_permintaan_sample_approve" action="'.base_url().'processor/plc/sample/permintaan/sample?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
				<input type="hidden" name="ireq_id" value="'.$this->input->get('ireq_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_sample_permintaan_sample_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$iapprove = $post['type'] == 'PD' ? 'iapppd' : '';
		$this->db_plc0->where('ireq_id', $post['ireq_id']);
		$updete=$this->db_plc0->update('plc2.plc2_upb_request_sample', array($iapprove=>2,'vnip_apppd'=>$nip,'tapppd'=>$skg));

		$cek_upb= 'select * from plc2.plc2_upb_request_sample a where a.ireq_id="'.$post['ireq_id'].'"';
		$dcek_upb = $this->db_plc0->query($cek_upb)->row_array();


		if ($updete) {
			if ($dcek_upb['iTujuan_req']==1) {
				$tipe=1;
			}else if( $dcek_upb['iTujuan_req']==2 ){
				$tipe=2;
				/*integrasi dengan aplikasi PD detail 20170510 by mansur*/
				/*update flag finish pada db pD Detail*/
				$id_Upb=$dcek_upb['iupb_id'];
				$cek_fromPD='
							select fp.iupb_id,f.iFormula 
											from pddetail.formula f 
											join pddetail.formula_process fp on fp.iFormula_process=f.iFormula_process
											where f.lDeleted=0
											and fp.lDeleted=0
											and f.iNextReqSample=1
											and f.iFinishRegSample=0
											and fp.iupb_id="'.$id_Upb.'"
											order by f.iFormula DESC limit 1';
				$dFormula = $this->db_plc0->query($cek_fromPD)->row_array();	

				if (!empty($dFormula)) {
					$this->db_plc0->where('iFormula', $dFormula['iFormula']);
					$this->db_plc0->update('pddetail.formula', array('iFinishRegSample'=>1));											
				}										

				

			}else if( $dcek_upb['iTujuan_req']==3 ){


			}else{
				// tujuan 4 , reSample
				$id_Upb=$dcek_upb['iupb_id'];
				// cek 
				/*if($dcek_upb['iTujuan_req']==4){
					$sql='
						update pddetail.formula f set f.iBackSample=0 where f.iFormula_process in (
							select f.iFormula 
							from pddetail.formula_process fp 
							join pddetail.formula f on f.iFormula_process=fp.iFormula_process
							where fp.lDeleted=0
							and f.lDeleted=0
							and f.iBackSample=1
							and fp.iupb_id="'.$id_Upb.'"
						)

					';
					$query = $this->db_plc0->query($sql);
				}*/
				if($dcek_upb['iTujuan_req']==4){
					/*tujuan re-sample*/
					$cek_fromPD='select f.iFormula 
								from pddetail.formula_process fp 
								join pddetail.formula f on f.iFormula_process=fp.iFormula_process
								where fp.lDeleted=0
								and f.lDeleted=0
								#and f.iBackSample=1
								and fp.iupb_id="'.$id_Upb.'" ';
					$dFormula = $this->db_plc0->query($cek_fromPD)->result_array();	

					if (!empty($dFormula)) {
						foreach ($dFormula as $forfor) {
							
							$this->db_plc0->where('iFormula', $forfor['iFormula']);
							$this->db_plc0->update('pddetail.formula', array('iBackSample'=>0));											
						}
							
					}
				}


				/*$cek_fromPD='
							select fp.iupb_id,f.iFormula 
											from pddetail.formula f 
											join pddetail.formula_process fp on fp.iFormula_process=f.iFormula_process
											where f.lDeleted=0
											and fp.lDeleted=0
											and f.iBackSample=0
											and fp.iupb_id="'.$id_Upb.'"
											order by f.iFormula DESC limit 1';


				$dFormula = $this->db_plc0->query($cek_fromPD)->row_array();	

				if (!empty($dFormula)) {
					$this->db_plc0->where('iFormula', $dFormula['iFormula']);
					$this->db_plc0->update('pddetail.formula', array('iBackSample'=>0));											
				}*/				

			}

			//cek next_proses
		//	$this->lib_flow->insert_logs($_POST['modul_id'],$dcek_upb['iupb_id'],9,2,$tipe);
		}


		/*if ($updete) {
			if ($dcek_upb['iTujuan_req']==1) {
				$tipe=1;
			}else if ($dcek_upb['iTujuan_req']==2){
				$tipe=2;
			}else{
				$tipe=3;
			}

			//cek next_proses
		//	$this->lib_flow->insert_logs($_POST['modul_id'],$dcek_upb['iupb_id'],9,2,$tipe);
		}*/

    
    	$upbid = $post['iupb_id'];
    	$ireq_id = $post['ireq_id'];
		
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
   	
		/*$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // 1 approval
		$bizsup=$getbp['idplc2_biz_process_sub'];*/
	
	/*	
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
        
        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
        
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
        $subject="Proses Permintaan Sample Selesai: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval oleh PD Manager pada proses Permintaan Sample(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
                                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>PO Sample- Input data Purchasing</td>
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
    	$data['last_id'] = $ireq_id;
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
								var url = "'.base_url().'processor/plc/sample/permintaan/sample";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_sample_permintaan_sample").html(data);
									});
					
								}
									reload_grid("grid_sample_permintaan_sample");
							}
							})
						 }
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_sample_permintaan_sample_reject" action="'.base_url().'processor/plc/sample/permintaan/sample?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="ireq_id" value="'.$this->input->get('ireq_id').'" />
    			<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark" id="remark" required></textarea><button type="button" onclick="submit_ajax(\'form_sample_permintaan_sample_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process () {
    	$post = $this->input->post();
    	$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
	 	$iapprove = $post['type'] == 'PD' ? 'iapppd' : '';
    	$this->db_plc0->where('ireq_id', $post['ireq_id']);
		$updete= $this->db_plc0->update('plc2.plc2_upb_request_sample', array($iapprove=>1,'vnip_apppd'=>$nip,'tapppd'=>$skg));

		$cek_upb= 'select * from plc2.plc2_upb_request_sample a where a.ireq_id="'.$post['ireq_id'].'"';
		$dcek_upb = $this->db_plc0->query($cek_upb)->row_array();
		if ($updete) {
			if ($dcek_upb['iTujuan_req']==1) {
				$tipe=1;
			}else if ($dcek_upb['iTujuan_req']==2){
				$tipe=2;
			}else{
				$tipe=3;
			}

			//cek next_proses
		//	$this->lib_flow->insert_logs($_POST['modul_id'],$dcek_upb['iupb_id'],9,2,$tipe);
		}

    
		$req_id=$post['ireq_id'];
		
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
    
		/*$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // 1 approval
		$bizsup=$getbp['idplc2_biz_process_sub'];*/
		
/*
		$hacek=$this->biz_process->cek_last_status($post['iupb_id'],$bizsup,2); // status 2 => reject
		if($hacek==1){ // jika sudah pernah ada data maka update saja
			//insert log
				$this->biz_process->insert_log($post['iupb_id'], $bizsup, 2); // status 2 => reject
			//update last log
				$this->biz_process->update_last_log($post['iupb_id'], $bizsup, 2);
		}
		elseif($hacek==0){
			//insert log
				$this->biz_process->insert_log($post['iupb_id'], $bizsup, 2); // status 2 => reject
			//insert last log
				$this->biz_process->insert_last_log($post['iupb_id'], $bizsup, 2);
		}	
*/				
		
    	$data['status']  = true;
    	$data['last_id'] = $req_id;
    	return json_encode($data);
    }
	function listBox_sample_permintaan_sample_iapppd($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	//Keterangan approval 
	function insertBox_sample_permintaan_sample_vnip_apppd($field, $id) {
		return '-';
	}
	function updateBox_sample_permintaan_sample_vnip_apppd($field, $id, $value, $rowData) {
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
	function listBox_sample_permintaan_sample_trequest($value) {
		return date('d M Y', strtotime($value));
	}

	function insertBox_sample_permintaan_sample_vreq_nomor($name, $id) {
		return 'this number would be generate automatically';
	}

	function updateBox_sample_permintaan_sample_vreq_nomor($name, $id, $value) {
		return $value;
	}
	
	function updateBox_sample_permintaan_sample_detail($name, $id, $value, $rowData) {
		$this->load->helper('search_array');
		$this->db_plc0->where('ireq_id', $rowData['ireq_id']);
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('ireq_id', 'asc');
		$data['rows'] = $this->db_plc0->get('plc2.plc2_upb_request_sample_detail')->result_array();
		$data['browse_url'] = base_url().'processor/plc/browse/bb';
		return $this->load->view('sample_permintaan_sample_detail', $data, TRUE);
	}
	function insertBox_sample_permintaan_sample_detail($name, $id) {
		$this->load->helper('search_array');
		$data['rows'] = array();
		$data['browse_url'] = base_url().'processor/plc/browse/bb';
		return $this->load->view('sample_permintaan_sample_detail', $data, TRUE);
	}

	function insertBox_sample_permintaan_sample_iTujuan_req($field, $id) {
		$o='<select id="iTujuan_req" class="required combobox" name="iTujuan_req">
				<option value="">--Select--</option>
				<option value="1">Untuk Sample</option>
				<option value="2">Untuk Skala Lab</option>
				<option value="3">Untuk Pilot</option>
				<option value="4">Untuk Re-Sample</option>
			</select>';

		$o .='
				<script type="text/javascript">
					$("#bt_req_bb_1").hide();
					$("#bt_req_bb_2").hide();
					$("#bt_req_bb_3").hide();
					$("#bt_req_bb_4").hide();
					$("#iTujuan_req").die();
					$("#iTujuan_req").live("change",function(){
						if ($( this ).val()=="") {
							alert("Tujuan harus diisi");
							$("#bt_req_bb_1").hide();
							$("#bt_req_bb_2").hide();
							$("#bt_req_bb_3").hide();
							$("#bt_req_bb_4").hide();
						}else{
							if ($( this ).val()==1) {
								$("#bt_req_bb_1").show();	
								$("#bt_req_bb_2").hide();
								$("#bt_req_bb_3").hide();
								$("#bt_req_bb_4").hide();
							}else if($( this ).val()==2){
								$("#bt_req_bb_2").show();	
								$("#bt_req_bb_1").hide();
								$("#bt_req_bb_3").hide();
								$("#bt_req_bb_4").hide();
							}else if($( this ).val()==3){
								$("#bt_req_bb_3").show();	
								$("#bt_req_bb_1").hide();
								$("#bt_req_bb_2").hide();
								$("#bt_req_bb_4").hide();
							}else{
								$("#bt_req_bb_1").hide();	
								$("#bt_req_bb_2").hide();
								$("#bt_req_bb_3").hide();
								$("#bt_req_bb_4").show();
							}
							
						}

					})
				</script>
		';	
		return $o;
		
	}
	function updateBox_sample_permintaan_sample_iTujuan_req($field, $id, $value,$rowData) {
        
        if ($this->input->get('action') == 'view') {
        	$lchoose = array(0=>'Select -One', 1=>'Untuk Sample', 2=>'Untuk Skala Lab', 3=>'Untuk Pilot', 4=>'Untuk Re-Sample');
            $o = $lchoose[$value];
        } else {
        	$o='';
        	if ($rowData['iSubmit']<>0) {
        		$disabled='disabled=disabled';
        		$o .= '<input type="hidden" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" />';
        	}else{
        		$disabled='';
        	}

        	$lchoose = array(""=>'Select One', 1=>'Untuk Sample', 2=>'Untuk Skala Lab', 3=>'Untuk Pilot', 4=>'Untuk Re-Sample');
            $o  .= "<select  name='".$field."' ".$disabled." id='".$id."' class='required combobox'>";            
            foreach($lchoose as $k=>$v) {
                if ($k == $value) $selected = " selected";
                else $selected = "";
                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
            }            
            $o .= "</select>";
        }

        $o .='
				<script type="text/javascript">
					
					
					if ( $("#sample_permintaan_sample_iTujuan_req").val()==1 ) {
						$("#bt_req_bb_2").hide();
						$("#bt_req_bb_3").hide();	
						$("#bt_req_bb_4").hide();
					}else if( $("#sample_permintaan_sample_iTujuan_req").val()==2 ){
						$("#bt_req_bb_1").hide();
						$("#bt_req_bb_3").hide();
						$("#bt_req_bb_4").hide();
					}else if( $("#sample_permintaan_sample_iTujuan_req").val()==3 ){
						$("#bt_req_bb_1").hide();
						$("#bt_req_bb_2").hide();
						$("#bt_req_bb_4").hide();
					}else if( $("#sample_permintaan_sample_iTujuan_req").val()==4 ){
						$("#bt_req_bb_1").hide();
						$("#bt_req_bb_2").hide();
						$("#bt_req_bb_3").hide();
					}else{
						$("#bt_req_bb_1").hide();
						$("#bt_req_bb_2").hide();
						$("#bt_req_bb_3").hide();	
						$("#bt_req_bb_4").hide();	
					}
					$("#sample_permintaan_sample_iTujuan_req").die();
					$("#sample_permintaan_sample_iTujuan_req").live("change",function(){
						if ($( this ).val()=="") {
							alert("Tujuan harus diisi");
							$("#bt_req_bb_1").hide();
							$("#bt_req_bb_2").hide();
							$("#bt_req_bb_3").hide();
							$("#bt_req_bb_4").hide();
						}else{
							if ($( this ).val()==1) {
								$("#bt_req_bb_1").show();	
								$("#bt_req_bb_2").hide();
								$("#bt_req_bb_3").hide();
								$("#bt_req_bb_4").hide();
							}else if($( this ).val()==2){
								$("#bt_req_bb_2").show();	
								$("#bt_req_bb_1").hide();
								$("#bt_req_bb_3").hide();
								$("#bt_req_bb_4").hide();
							}else if($( this ).val()==3){
								$("#bt_req_bb_3").show();	
								$("#bt_req_bb_1").hide();
								$("#bt_req_bb_2").hide();
								$("#bt_req_bb_4").hide();
							}else{
								$("#bt_req_bb_1").hide();	
								$("#bt_req_bb_2").hide();
								$("#bt_req_bb_3").hide();
								$("#bt_req_bb_4").show();
							}
							
						}

					})
				</script>
		';	

        return $o;
    }	

	function insertBox_sample_permintaan_sample_iupb_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="7" />';
		
		$return .= '&nbsp;<button id="bt_req_bb_1" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/popup?field=sample_permintaan_sample&iTujuan_req=1\',\'List UPB\')" type="button">&nbsp;</button>';
		$return .= '&nbsp;<button id="bt_req_bb_2" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/popup?field=sample_permintaan_sample&iTujuan_req=2\',\'List UPB\')" type="button">&nbsp;</button>';
		$return .= '&nbsp;<button id="bt_req_bb_3" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/popup?field=sample_permintaan_sample&iTujuan_req=3\',\'List UPB\')" type="button">&nbsp;</button>';
		$return .= '&nbsp;<button id="bt_req_bb_4" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/popup?field=sample_permintaan_sample&iTujuan_req=4\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function updateBox_sample_permintaan_sample_iupb_id($field, $id, $value) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$value))->row_array();
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" value="'.$value.'" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" value="'.$row['vupb_nomor'].'" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="7" />';
		
		$return .= '&nbsp;<button id="bt_req_bb_1" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/popup?field=sample_permintaan_sample&iTujuan_req=1\',\'List UPB\')" type="button">&nbsp;</button>';
		$return .= '&nbsp;<button id="bt_req_bb_2" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/popup?field=sample_permintaan_sample&iTujuan_req=2\',\'List UPB\')" type="button">&nbsp;</button>';
		$return .= '&nbsp;<button id="bt_req_bb_3" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/popup?field=sample_permintaan_sample&iTujuan_req=3\',\'List UPB\')" type="button">&nbsp;</button>';
		$return .= '&nbsp;<button id="bt_req_bb_4" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/popup?field=sample_permintaan_sample&iTujuan_req=4\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function insertBox_sample_permintaan_sample_vupb_nama($name, $id) {
		return '<span id="'.$id.'"></span>
		<input type="hidden" name="isdraft" id="isdraft">';
	}
	
	function updateBox_sample_permintaan_sample_vupb_nama($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return '<span id="'.$id.'">'.$row['vupb_nama'].'</span>
		<input type="hidden" name="isdraft" id="isdraft">';
	}
	
	function insertBox_sample_permintaan_sample_iteampd_id($name, $id) {
		return '<span id="'.$id.'"></span>';
	}

	function updateBox_sample_permintaan_sample_iteampd_id($name, $id, $value, $rowData) {
		$sql = "SELECT t.vteam FROM plc2.plc2_upb u INNER JOIN plc2.plc2_upb_team t ON u.iteampd_id=t.iteam_id WHERE u.iupb_id='".$rowData['iupb_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		return '<span id="'.$id.'">'.$row['vteam'].'</span>';
	}
	
	function updateBox_sample_permintaan_sample_trequest($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		return '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
	}
	function insertbox_sample_permintaan_sample_trequest($field, $id) {
		//input_tgl datepicker input_rows1 required hasDatepicker
		$today = date('d-m-Y', mktime());
		$o = "<input type='text' name='".$id."' id='".$id."' class='input_tgl datepicker' value='".$today."'/>";
		return $o;
	}

	function insertbox_sample_permintaan_sample_cRequestor($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="" />
					';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="30" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/pic/req/sample/?id='.$id.'\',\'List PIC\')" type="button">&nbsp;</button>';                
		
		return $return;
	}

	function updateBox_sample_permintaan_sample_cRequestor($field, $id, $value, $rowData) {
		$emp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cRequestor']))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $emp['cNip'].' - '.$emp['vName'];

		}else{
			
			if ($rowData['iSubmit'] == 0) {
				$return = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />
						';
			$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="30" value="'.$emp['cNip'].' - '.$emp['vName'].'"/>';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/pic/req/sample/?id='.$id.'\',\'List PIC\')" type="button">&nbsp;</button>';                
			

			
			}else{
				$return= $emp['cNip'].' - '.$emp['vName'];
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			}
			
		}
		
		return $return;
	}	
	
	function before_insert_processor($row, $post, $postData) {
		$user = $this->auth_localnon->user();
		$query = "select max(ireq_id) as std from plc2.plc2_upb_request_sample";
        $rs = $this->db_plc0->query($query)->row_array();
        $nomor = intval($rs['std']) + 1;
        $nomor = "L".str_pad($nomor, 7, "0", STR_PAD_LEFT);
		
		$skrg = date('Y-m-d H:i:s');
		unset($postData['ireqdet_id']);
		unset($postData['detrawid']);
		unset($postData['detjumlah']);
		unset($postData['detsatuan']);
		unset($postData['detspesifikasi']);
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = $skrg;
		$postData['vreq_nomor'] = $nomor;
		//$postData['trequest'] = to_mysql($postData['trequest']);
		$postData['trequest'] = to_mysql($post['trequest']);

		if ($postData['iTujuan_req']==1) {
			$tipe=1;
		}else if($postData['iTujuan_req']==2){
			$tipe=2;
		}else{
			$tipe=3;
		}

		if($postData['isdraft']==true){
			$postData['iSubmit']=0;
		} 
		else{
			$postData['iSubmit']=1;
		//	$this->lib_flow->insert_logs($_GET['modul_id'],$postData['iupb_id'],1,0,$tipe);
		} 


		return $postData;
	}
	function after_insert_processor($row, $insertId, $postData) {
		//print_r($postData);
		$this->load->helper(array('search_array','mydb'));
		$this->plcdb = mydb('plc');
		$post = $this->input->post();
		$ireqdet_id = $post['ireqdet_id'];
		$detrawid = $post['detrawid'];
		$detsatuan = $post['detsatuan'];
		$detspesifikasi = $post['detspesifikasi'];
		$detjumlah = $post['detjumlah'];
		foreach($ireqdet_id as $k => $v) {
			if(empty($v)) {
				if(!empty($detrawid[$k])) {
					$idet['ireq_id'] = $insertId;
					$idet['raw_id'] = $detrawid[$k];
					$idet['ijumlah'] = $detjumlah[$k];
					$idet['vsatuan'] = $detsatuan[$k];
					$idet['tspecification'] = $detspesifikasi[$k];
					$this->plcdb->insert('plc2_upb_request_sample_detail', $idet);
				}						
			}
		}
		/*$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
		$bizsup=$getbp['idplc2_biz_process_sub'];*/
		/*
		$hacek=$this->biz_process->cek_last_status($postData['iupb_id'],$bizsup,7); // status 7 => submit
		if($hacek==1){ // jika sudah pernah ada data maka update saja
			//insert log
				$this->biz_process->insert_log($postData['iupb_id'], $bizsup, 7); // status 7 => submit
			//update last log
				$this->biz_process->update_last_log($postData['iupb_id'], $bizsup, 7);
		}
		elseif($hacek==0){
			//insert log
				$this->biz_process->insert_log($postData['iupb_id'], $bizsup, 7); // status 7 => submit
			//insert last log
				$this->biz_process->insert_last_log($postData['iupb_id'], $bizsup, 7);
		}
		*/
	}
	function before_update_processor($row, $post, $postData) {
		$user = $this->auth_localnon->user();
		$skrg = date('Y-m-d H:i:s');
		unset($postData['ireqdet_id']);
		unset($postData['detrawid']);
		unset($postData['detjumlah']);
		unset($postData['detsatuan']);
		unset($postData['detspesifikasi']);
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = $skrg;
		$postData['trequest'] = to_mysql($postData['trequest']);

		$req_id=$postData['sample_permintaan_sample_ireq_id'] ;
		if ($postData['iTujuan_req']==1) {
			$tipe=1;
		}else if($postData['iTujuan_req']==2){
			$tipe=2;
		}else{
			$tipe=3;
		}

		if($postData['isdraft']==true){
			$postData['iSubmit']=0;
		} 
		else{
			$cek_upb= 'select * from plc2.plc2_upb_request_sample a where a.ireq_id="'.$req_id.'"';
			$dcek_upb = $this->db_plc0->query($cek_upb)->row_array();

			if ($dcek_upb['iSubmit']!=1) {
		//		$this->lib_flow->insert_logs($_GET['modul_id'],$postData['sample_permintaan_sample_iupb_id'],1,0,$tipe);
			}
			$postData['iSubmit']=1;
			
		} 


		return $postData;
	}
	function after_update_processor($row, $insertId, $postData, $old_data) {
		$this->load->helper(array('search_array','mydb'));
		$this->plcdb = mydb('plc');
		$post = $this->input->post();
		$ireqdet_id = $post['ireqdet_id'];
		$detrawid = $post['detrawid'];
		$detsatuan = $post['detsatuan'];
		$detspesifikasi = $post['detspesifikasi'];
		$detjumlah = $post['detjumlah'];
		$eRows = $this->db_plc0->get_where('plc2.plc2_upb_request_sample_detail', array('ireq_id'=>$insertId, 'ldeleted'=>0))->result_array();
		foreach($eRows as $k => $v) {
			if(in_array($v['ireqdet_id'], $ireqdet_id)) {
				$this->plcdb->where('ireqdet_id', $v['ireqdet_id']);
				$key = array_search($v['ireqdet_id'], $ireqdet_id);
				$this->plcdb->update('plc2_upb_request_sample_detail', array('raw_id'=>$detrawid[$key],'ijumlah'=>$detjumlah[$key],'vsatuan'=>$detsatuan[$key],'tspecification'=>$detspesifikasi[$key]));
			}
			else {
				$this->plcdb->where('ireqdet_id', $v['ireqdet_id']);
				$this->plcdb->update('plc2_upb_request_sample_detail', array('ldeleted'=>1));
			}
		}
		foreach($ireqdet_id as $k => $v) {
			if(empty($v)) {
				if(!empty($detrawid[$k])) {
					$idet['ireq_id'] = $insertId;
					$idet['raw_id'] = $detrawid[$k];
					$idet['ijumlah'] = $detjumlah[$k];
					$idet['vsatuan'] = $detsatuan[$k];
					$idet['tspecification'] = $detspesifikasi[$k];
					$this->plcdb->insert('plc2_upb_request_sample_detail', $idet);
				}						
			}
		}
		/*$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
		$bizsup=$getbp['idplc2_biz_process_sub'];*/
		
		/*$hacek=$this->biz_process->cek_last_status($postData['iupb_id'],$bizsup,7); // status 7 => submit
		if($hacek==1){ // jika sudah pernah ada data maka update saja
			//insert log
				$this->biz_process->insert_log($postData['iupb_id'], $bizsup, 7); // status 7 => submit
			//update last log
				$this->biz_process->update_last_log($postData['iupb_id'], $bizsup, 7);
		}
		elseif($hacek==0){
			//insert log
				$this->biz_process->insert_log($postData['iupb_id'], $bizsup, 7); // status 7 => submit
			//insert last log
				$this->biz_process->insert_last_log($postData['iupb_id'], $bizsup, 7);
		}*/
	}

	function output(){		
    	$this->index($this->input->get('action'));
    }
}