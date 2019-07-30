<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_trial_best_formula extends MX_Controller {
	function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->load->library('biz_process');
        $this->load->library('lib_utilitas');
        $this->load->library('lib_flow');
		$this->user = $this->auth_localnon->user(); 
		$this->url = 'product_trial_best_formula';
		$this->load->helper(array('tanggal','to_mysql'));
		$this->load->model('user_model');
    }
    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle('Best Formula');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('product_trial_best_formula');
		//$grid->addList('vkode_surat','vupb_nomor','vupb_nama','vgenerik','iteampd_id','plc2_upb_stabilita.inumber','isucced','tdate');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik','iteampd_id','ttanggal','approval');
		$grid->setSortBy('vupb_nomor');
		$grid->setSortOrder('ASC');
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setAlign('ttanggal', 'center');
		$grid->setWidth('vupb_nomor', '100');
		$grid->setWidth('ttanggal', '140');
		$grid->setWidth('iteampd_id', '150');
		$grid->setWidth('vupb_nama', '250');
		$grid->setWidth('vgenerik', '250');
		$grid->addFields('vupb_nomor','ttanggal','cnip','vupb_nama','vgenerik','voriginator','tindikasi');
		$grid->addFields('ikategori_id','isediaan_id','itipe_id','vhpp_target','tunique','tpacking','iteambusdev_id');
		$grid->addFields('iteampd_id','iteamqa_id','iteamqc_id','iteammarketing_id','ipublish','approval');//'formula','approval');
		//$grid->setRequired();
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('cnip', 'Pengusul');
		$grid->setLabel('voriginator', 'Originator');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('iteampd_id', 'Team PD');
		$grid->setLabel('ttanggal', 'Tanggal UPB');				
		$grid->setLabel('tindikasi', 'Indikasi');
		$grid->setLabel('ikategori_id', 'Kategori Product');
		$grid->setLabel('isediaan_id', 'Sediaan');
		$grid->setLabel('itipe_id', 'Tipe Product');
		$grid->setLabel('vhpp_target', 'Target HPP');
		$grid->setLabel('tunique', 'Keunggulan Product');
		$grid->setLabel('tpacking', 'Formula Kemasan');
		$grid->setLabel('iteambusdev_id', 'Team Busdev');
		$grid->setLabel('iteamqa_id', 'Team QA');
		$grid->setLabel('iteamqc_id', 'Team QC');
		$grid->setLabel('iteammarketing_id', 'Team Marketing');
		$grid->setLabel('ipublish', 'Publish');
		$grid->setLabel('approval', 'Approval PD');
		
		$grid->setRelation('iteampd_id','plc2.plc2_upb_team','iteam_id','vteam', 'team_pd','inner',array('ldeleted'=>0,'vtipe'=>'PD'));
		$grid->setSearch('vupb_nomor','vgenerik','vupb_nama','iteampd_id','ttanggal');
		
		$grid->changeFieldType('ipublish', 'combobox','' , array(0=>'Tidak', 1=>'Ya'));
		
		$grid->setQuery('plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2_upb.iappdireksi', 2);
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		
		// $grid->setQuery('plc2_upb.iupb_id in (select f.iupb_id from plc2.plc2_upb_formula f)',null);
		
		//tampilkan upb yg pny formula yg stabilita ke-6 memenuhi syarat dan sudah approve
		/*
		$grid->setQuery('iupb_id in (select f.iupb_id from plc2.plc2_upb_formula f 
									where 
									f.ifor_id in (select st.ifor_id from plc2.plc2_upb_stabilita st where st.inumber=6 and st.isucced=2 and st.iapppd=2)
									)',null);
		*/

		// jika iwithstabilita = 1 maka lewat stabilita , kalau 0 langsung best formula
		/*$grid->setQuery('iupb_id in (select f.iupb_id from plc2.plc2_upb_formula f 
									where f.ifor_id in (select st.ifor_id from plc2.plc2_upb_stabilita st where st.inumber=1 and st.iapppd=2))',null);*/
		
		/*integrasi PD detail , status sudah stabilita lab ambil dari pd detail 20170510 by mansur*/
				$grid->setQuery('plc2_upb.iupb_id in(
											select fp.iupb_id 
											from pddetail.formula_stabilita f 
											join pddetail.formula_process fp on fp.iFormula_process=f.iFormula_process
											where f.lDeleted=0
											and fp.lDeleted=0
											and f.iKesimpulanStabilita=1
											and f.iApp_formula=2
											and fp.iFormula_process in (select a.iFormula_process 
																				from pddetail.formula_process a where a.lDeleted=0
																				and a.iMaster_flow in (6,7,8))
											)
				',null);

		// CEK di soi fg, vamoa dan soi mikro fg
		$grid->setQuery('plc2_upb.iupb_id in (select up.iupb_id from plc2.plc2_upb up
						inner join plc2.study_literatur_pd st on up.iupb_id=st.iupb_id
						where 
						(CASE WHEN st.iuji_mikro=1 THEN 
							(case when st.ijenis_sediaan=1
							then up.iupb_id in (select mo.iupb_id from plc2.plc2_vamoa mo where mo.lDeleted=0 and mo.iapppd=2)
							else
								up.iupb_id in (select sp.iupb_id from plc2.plc2_upb_soi_fg sp where sp.ldeleted=0 and sp.iapppd=2 and sp.iappqa=2) AND up.iupb_id in (select mo.iupb_id from plc2.plc2_vamoa mo where mo.lDeleted=0 and mo.iapppd=2)
							 END)
						ELSE st.ldeleted=0 
  						END)
						)',null);
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
				$grid->render_form($this->input->get('id'), TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'detail':
				$this->detail();
				break;
			case 'pilihformula':
				$this->formula_pilih($this->input->get('ifor_id'));
				break;
			case 'approve':
				echo $this->approve_view();
				break;
			case 'approve_process':
				echo $this->approve_process();
				break;
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();

				$this->db_plc0->where('ifor_id', $get['ifor_id']);
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$this->db_plc0->update('plc2.plc2_upb_formula', array('ibest'=>2,'vbest_nip_apppd'=>$nip,'tbest_apppd'=>$skg,'isubmit_best'=>1));
		    
		    	$upbid = $post['iupb_id'];
				
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
		        
		        $team = $pd. ','.$qa ;
		        
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
		        $subject="Proses Best Formula Selesai: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada approval oleh pada proses Best Formula(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
		                                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>Spek. SOI FG Final- Input data oleh PD dilanjutkan Approval oleh QA</td>
		                                </tr>
		                        </table>
		                </div>
		                <br/> 
		                Demikian, mohon segera follow up  pada aplikasi ERP Product  Life Cycle. Terimakasih.<br><br><br>
		                Post Master";
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
	public function listBox_Action($row, $actions) {
    	$iupb_id=$row->iupb_id;
		$sql="select *
					from plc2.plc2_upb_formula f 
					where f.iupb_id=$iupb_id	
					#and f.iFormula_process is not null
					order by f.ifor_id DESC limit 1	";
		$res=$this->db_plc0->query($sql)->row_array();
		$ifor_id=$res['ifor_id'];
		$apppd=$res['vbest_nip_apppd'];
    	
		$x=$this->auth_localnon->dept();
    	if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		if(in_array('PD', $manager)){$type='PD';}
    		else{$type='';}
    	}
		else{$type='';}
		
		// jika formula skala trial sudah di app tidak bisa di edit
		if(($apppd!=null)||($type!='PD')){
				unset($actions['edit']);
				unset($actions['delete']);
		}
		return $actions;
    }
	function manipulate_update_button($buttons, $rowData) {
		$update = '<button onclick="javascript:update_btn_back(\'product_trial_best_formula\', \''.base_url().'processor/plc/product/trial/best/formula?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_product_trial_best_formula">Update</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'product_trial_best_formula\', \''.base_url().'processor/plc/product/trial/best/formula?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_product_trial_best_formula">Update as Draft</button>';
		$js=$this->load->view('product_trial_best_formula_js');
		//get ifor_id
		if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			$iupb_id=$rowData['iupb_id'];
			$sql="select *
					from plc2.plc2_upb_formula f 
					where f.iupb_id=$iupb_id	
					#and f.iFormula_process is not null
					order by f.ifor_id DESC limit 1	";
			/*echo $sql;*/

			$res=$this->db_plc0->query($sql)->row_array();
			/*print_r($res);
			exit;*/
			$ifor_id=$res['ifor_id'];

			$apppd=$res['vbest_nip_apppd'];
			$isubmit=$res['isubmit_best'];
			unset($buttons['update_back']);
			unset($buttons['update']);
			
			$sql= "select * from plc2.plc2_upb_formula fo
				inner join plc2.plc2_upb up on fo.iupb_id=up.iupb_id
				where fo.ifor_id=".$ifor_id;
			$dt=$this->db_plc0->query($sql)->row_array();
			$setuju = '<button onclick="javascript:setuju(\'product_trial_best_formula\', \''.base_url().'processor/plc/product/trial/best/formula?action=confirm&last_id='.$this->input->get('id').'&ifor_id='.$ifor_id.'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Confirm</button>';
						
			$user = $this->auth_localnon->user();
		
			$x=$this->auth_localnon->dept();
			if($this->auth_localnon->is_manager()){
				$x=$this->auth_localnon->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){$type='PD';}
				else{$type='';}
			}
			$x=$this->auth_localnon->my_teams();
			if($this->auth_localnon->is_manager()){
				if(($type=='PD') && ($apppd == null)){
						$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/best/formula?action=approve&ifor_id='.$ifor_id.'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_best">Approve</button>';
						$buttons['update'] = $setuju.$js;
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
								var url = "'.base_url().'processor/plc/product/trial/best/formula";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_product_trial_best_formula").html(data);
									});
					
								}
									reload_grid("grid_product_trial_best_formula");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_product_trial_best_formula_approve" action="'.base_url().'processor/plc/product/trial/best/formula?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="ifor_id" value="'.$this->input->get('ifor_id').'" />
    			<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_product_trial_best_formula_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
	 	$this->db_plc0->where('ifor_id', $post['ifor_id']);
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$this->db_plc0->update('plc2.plc2_upb_formula', array('ibest'=>2,'vbest_nip_apppd'=>$nip,'tbest_apppd'=>$skg));
    
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

		//$this->lib_flow->insert_logs($post['modul_id'],$upbid,9,2);
    	
    	$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
   		/*
		$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // 1 approval
		$bizsup=$getbp['idplc2_biz_process_sub'];
		
		$ifor_id=$this->input->post('ifor_id');
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
        
        $team = $pd. ','.$qa ;
        
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
        $subject="Proses Best Formula Selesai: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval oleh pada proses Best Formula(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
                                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>Spek. SOI FG Final- Input data oleh PD dilanjutkan Approval oleh QA</td>
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
    	$data['last_id'] = $post['iupb_id'];
    	return json_encode($data);
    }
	function listBox_product_trial_best_formula_ttanggal($value) {
		return to_mysql($value, TRUE);
	}
	 function listBox_product_trial_best_formula_approval($value,$id) {
	 	//baliksini
	 	$sql="select *
					from plc2.plc2_upb_formula f 
					where f.iupb_id=$id	
					#and f.iFormula_process is not null
					#and f.ibest=0	
					LIMIT 1";

	 	/*$sql="select *
					from plc2.plc2_upb_formula f 
					where f.ifor_id in (select st.ifor_id from plc2.plc2_upb_stabilita st where st.inumber=1 and st.iapppd=2)
				 	and f.iupb_id=$id";*/
		/* 	
    	$sql="select f.ifor_id, f.vkode_surat,f.vbest_nip_apppd,f.tbest_apppd 
    				from plc2.plc2_upb_formula f where f.ifor_id in 
					(select st.ifor_id from plc2.plc2_upb_stabilita st 
						where st.inumber=6 and st.isucced=2 and st.iapppd=2) and f.iupb_id=$id";
		*/
		$res=$this->db_plc0->query($sql)->row_array();
		if (!empty($res)) {
			if($res['vbest_nip_apppd'] != null){
				$ret='Approved';
			}
			else{
				$ret='Waiting for Approval';
			}
		}else{
				//$ret='Bypass Stabilita Lab';
				$ret='';
		}

		return $ret;
    }

	function updateBox_product_trial_best_formula_vupb_nomor($name, $id, $value) {
		if(empty($value)){ return '-';} 
		else{
			$return = '<input type="hidden" name="isdraft" id="isdraft">';
			return $return.$value;
		}
	}
	function updateBox_product_trial_best_formula_ttanggal($name, $id, $value) {
		if(empty($value)){ return '-';} else{return tanggal($value,'l, F jS, Y');}
	}
	function updateBox_product_trial_best_formula_cnip($name, $id, $value) {
		$row = $this->user_model->get_user_info($value);
		if(empty($value)){ return '-';} else{return $value.' | '.$row['vName'].' | '.$row['divisi'];}
	}
	function updateBox_product_trial_best_formula_vupb_nama($name, $id, $value) {
		if(empty($value)){ return '-';} else{return $value;}
	}
	function updateBox_product_trial_best_formula_vgenerik($name, $id, $value) {
		if(empty($value)){ return '-';} else{return $value;}
	}
	function updateBox_product_trial_best_formula_voriginator($name, $id, $value) {
		if(empty($value)){ return '-';} else{return $value;}
	}
	function updateBox_product_trial_best_formula_tindikasi($name, $id, $value) {
		if(empty($value)){ return '-';} else{return $value;}
	}
	function updateBox_product_trial_best_formula_ikategori_id($name, $id, $value) {
		$row = $this->db_plc0->get_where('hrd.mnf_kategori', array('ikategori_id'=>$value))->row_array();
		if(empty($row)){ return '-';} else{return $row['vkategori'];}
	}
	function updateBox_product_trial_best_formula_isediaan_id($name, $id, $value) {
		$row = $this->db_plc0->get_where('hrd.mnf_sediaan', array('isediaan_id'=>$value))->row_array();
		//print_r($row);
		if(empty($row)){ return '-';} else{return $row['vsediaan'];}
	}
	function updateBox_product_trial_best_formula_itipe_id($name, $id, $value) {
		$row = $this->db_plc0->get_where('plc2.plc2_biz_process_type', array('idplc2_biz_process_type'=>$value))->row_array();
		if(empty($row)){ return '-';} else{return $row['vName'];}
	}
	function updateBox_product_trial_best_formula_vhpp_target($name, $id, $value) {
		if(empty($value)){ return '-';} else{return $value;}
	}
	function updateBox_product_trial_best_formula_tunique($name, $id, $value) {
		if(empty($value)){ return '-';} else{return $value;}
	}
	function updateBox_product_trial_best_formula_tpacking($name, $id, $value) {
		if(empty($value)){ return '-';} else{return $value;}
	}
	function updateBox_product_trial_best_formula_iteambusdev_id($name, $id, $value) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$value))->row_array();
		if(empty($row)){ return '-';} else{return $row['vteam'];}
	}
	function updateBox_product_trial_best_formula_iteampd_id($name, $id, $value) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$value))->row_array();
		if(empty($row)){ return '-';} else{return $row['vteam'];}
	}
	function updateBox_product_trial_best_formula_iteamqa_id($name, $id, $value) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$value))->row_array();
		return $row['vteam'];
	}
	function updateBox_product_trial_best_formula_iteamqc_id($name, $id, $value) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$value))->row_array();
		if(empty($row)){ return '-';} else{return $row['vteam'];}
	}
	function updateBox_product_trial_best_formula_iteammarketing_id($name, $id, $value) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$value))->row_array();
		if(empty($row)){ return '-';} else{return $row['vteam'];}
	}
	function updateBox_product_trial_best_formula_ipublish($name, $id, $value) {
		return $value == 1 ? 'Ya' : 'Tidak';
	}
	function updateBox_product_trial_best_formula_formula($name, $id, $value, $rowData) {
		//print_r($rowData); exit();
		// $sql="select * from plc2_upb_formula f where f.ifor_id in 
				// (select st.ifor_id from plc2_upb_stabilita st 
					// where st.inumber=6 and st.isucced=2 and st.iapppd=2) and f.iupb_id=$iupb_id";
		// $data['']
		 // $data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_formula', array('iupb_id'=>$rowData['iupb_id']))->result_array();
		 // $data['rowss'] = $this->db_plc0->get_where('plc2.plc2_upb_formula', array('iupb_id'=>$rowData['iupb_id'],'ibest'=>'2'))->result_array();
		$iupb_id=$rowData['iupb_id'];
		$sql="select *
					from plc2.plc2_upb_formula f 
					where f.iupb_id=$iupb_id	
					#and f.iFormula_process is not null
					order by f.ifor_id DESC limit 1	";
		$res=$this->db_plc0->query($sql)->row_array();
		$data['ifor_id']=$res['ifor_id'];
		$data['vkode_surat']=$res['vkode_surat'];
		//echo $data['ifor_id'];
		return $this->load->view('product_trial_best_formula_formula',$data,TRUE);
	}
	function updateBox_product_trial_best_formula_approval($field, $id, $value, $rowData) {
		//print_r($rowData);
		$iupb_id=$rowData['iupb_id'];
		$sql="select *
					from plc2.plc2_upb_formula f 
					where f.iupb_id=$iupb_id	
					#and f.iFormula_process is not null
					order by f.ifor_id DESC limit 1	";
		$res=$this->db_plc0->query($sql)->row_array();
		if($res['vbest_nip_apppd'] != null){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$res['vbest_nip_apppd']))->row_array();
			
			$ret= $row['vName'].' ( '.$res['vbest_nip_apppd'].' )'.' pada '.$res['tbest_apppd'];
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	
	// function formula_pilih($id){
		// $sql = "Update plc2.plc2_upb_formula set ibest = '2' where ifor_id='".$id."'";
		// //echo $sql;
		// $this->db_plc0->query($sql);
		// //$grid->render_form($this->input->get('id'));
	// }

	//Manipulate post
	function before_update_processor($row, $postData) {
		//$postData['dupdate'] = date('Y-m-d H:i:s');
		//$postData['cUpdate'] =$this->user->gNIP;
		$iupb_id=$postData['iupb_id'];
		$isdraft=$postData['isdraft'];
		unset($postData);
		if($isdraft==true){
			$postData['isubmit_best']=0;
		} 
		else{$postData['isubmit_best']=1;} 
		$postData['iupb_id']=$iupb_id;
		//print_r($postData);exit();
		return $postData;

	}

	function after_update_processor($row, $insertId, $postData){
		$iupb_id=$postData['iupb_id'];
		$sql="select *
					from plc2.plc2_upb_formula f 
					where f.iupb_id=$iupb_id	
					#and f.iFormula_process is not null
					order by f.ifor_id DESC limit 1	";

		$res=$this->db_plc0->query($sql)->row_array();
		$this->db_plc0->where('ifor_id', $res['ifor_id']);
		$this->db_plc0->update('plc2.plc2_upb_formula', array('isubmit_best'=>$postData['isubmit_best']));
		if($postData['isdraft']!=true){
			$this->lib_flow->insert_logs($this->input->get('modul_id'),$iupb_id,6);
		}
		
	}

	function output(){
    	$this->index($this->input->get('action'));
    }
}
