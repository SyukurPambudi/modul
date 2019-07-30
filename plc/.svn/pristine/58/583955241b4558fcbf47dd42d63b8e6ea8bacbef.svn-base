<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_trial_approval_hpp extends MX_Controller {
	function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->user = $this->auth->user();
		$this->load->library('biz_process');
		$this->load->helper('tanggal');
		$this->load->model('user_model');
		$this->load->library('lib_utilitas'); 
	}
    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle('Approval HPP');		
		$grid->setTable('plc2.plc2_upb_formula');		
		$grid->setUrl('product_trial_approval_hpp');
		//$grid->addList('vkode_surat','vupb_nomor','vupb_nama','vgenerik','iteampd_id','plc2_upb_stabilita.inumber','isucced','tdate');
		//$grid->addList('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','plc2_hpp.vnip_apppd','plc2_hpp.vnip_appfa','plc2_hpp.vnip_appbd','plc2_hpp.vnip_appdir');
		$grid->addList('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','plc2_hpp.vnip_apppd','plc2_hpp.vnip_appbd');
		$grid->setSortBy('plc2_upb.vupb_nomor');
		$grid->setSortOrder('DESC');
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setAlign('vrevisi', 'center');
		$grid->setWidth('vkode_surat', '150');
		$grid->setWidth('plc2_upb.vupb_nomor', '100');
		$grid->setWidth('vrevisi', '75');
		$grid->setWidth('plc2_upb.vupb_nama', '250');
		$grid->setWidth('plc2_upb.vgenerik', '250');
		//$grid->addFields('vkode_surat','tberlaku','filename','vfile_lab','vrevisi','vhpp','vnip_formulator','vnip_apppd','vnip_appfa','vnip_appbd','vnip_appdir');				
		$grid->addFields('vkode_surat','tberlaku','filename','vfile_lab','vrevisi','vhpp','vnip_formulator','vnip_apppd','vnip_appbd');				
		
		$grid->setLabel('vkode_surat', 'No. Formula Trial');
		$grid->setLabel('tberlaku', 'Tanggal berlaku');
		$grid->setLabel('filename', 'File Formula Skala Trial');
		$grid->setLabel('vfile_lab', 'File Formula Skala Lab');
		$grid->setLabel('vhpp', 'HPP');
		$grid->setLabel('vnip_formulator', 'Formulator');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setLabel('plc2_upb.iteampd_id', 'Team PD');
		$grid->setLabel('vrevisi', 'Revisi');
		//$grid->setLabel('plc2_hpp.vrevisi', 'Revisi');
		$grid->setLabel('plc2_hpp.vnip_apppd', 'Approval PD');				
		$grid->setLabel('plc2_hpp.vnip_appfa', 'Approval FA');				
		$grid->setLabel('plc2_hpp.vnip_appbd', 'Approval Busdev');				
		$grid->setLabel('plc2_hpp.vnip_appdir', 'Approval Direksi');
		$grid->setLabel('vnip_apppd', 'Approval PD');				
		$grid->setLabel('vnip_appfa', 'Approval FA');				
		$grid->setLabel('vnip_appbd', 'Approval Busdev');				
		$grid->setLabel('vnip_appdir', 'Approval Direksi');	
		
		$grid->setJoinTable('plc2.plc2_upb','plc2_upb_formula.iupb_id = plc2_upb.iupb_id','inner');
		$grid->setJoinTable('plc2.plc2_hpp', 'plc2_upb_formula.ifor_id = plc2.plc2_hpp.ifor_id', 'LEFT');
		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik');
		
		$grid->setQuery('plc2_upb_formula.ibest', 2);
		$grid->setQuery('plc2_upb_formula.vbest_nip_apppd != ""', null);
		
		$grid->setQuery('plc2_upb_formula.ldeleted', 0);
		
		//formula dari upb yg sudah app soi mikro jika iujimikro=2, jika iujimikro=1 maka app soi fg
		$grid->setQuery('((plc2_upb_formula.iupb_id in 
				(select soi.iupb_id from plc2.plc2_upb_soi_fg soi 
					inner join plc2.plc2_upb u on u.iupb_id=soi.iupb_id
					where soi.iappqa=2 and soi.itype=1 and u.iuji_mikro=1))
		or
		(plc2_upb_formula.iupb_id in 
				(select soi.iupb_id from plc2.plc2_upb_mikro_fg soi 
					inner join plc2.plc2_upb u on u.iupb_id=soi.iupb_id
					where soi.iappqa=2 and soi.itype=1 and u.iuji_mikro=2)))',null);
		//$grid->setQuery('plc2_upb_formula.iupb_id in (select soi.iupb_id from plc2.plc2_upb_mikro_fg soi where soi.iappqa_f=2 and soi.itype=1)',null);
		//$grid->setQuery('plc2_upb_formula.isucced', 2);
		
		$grid->setQuery('plc2_upb.ihold', 0);
		
		// if($this->auth->is_manager()){
    		// $xa=$this->auth->dept();
    		// $managera=$xa['manager'];
			// if(in_array('BD', $managera)){$typea='BD';}
    		// else{$typea='';}
			
    	// }
		//$grid->setQuery('plc2_upb.iteambusdev_id IN (66)', null); // hanya busdev 3 saja yg harus
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('iteampd_id IN ('.$this->auth->my_teams().')', null);
			}
			elseif(in_array('BD', $manager)){
				$type='BD';
				$grid->setQuery('iteambusdev_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('iteampd_id IN ('.$this->auth->my_teams().')', null);
			}elseif(in_array('BD', $team)){
				$type='BD';
				$grid->setQuery('iteambusdev_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		//if($typea=='BD'){$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth->my_teams().')', null);}
		
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
			default:
				$grid->render_grid();
				break;
		}
    }
	
    function manipulate_update_button($buttons, $rowData) {
    	//echo "<pre>";print_r($rowData);echo "</pre>"; exit();
		if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			unset($buttons['update_back']);
			unset($buttons['update']);
			
			//echo $rowData['vnip_formulator']."<br>".$this->user->gNIP;
			$user = $this->auth->user();
   //print_r ($rowData);
			if($this->auth->is_manager()){
				$x=$this->auth->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){$type='PD';}
				elseif(in_array('FA', $manager)){$type='FA';}
				elseif(in_array('BD', $manager)){$type='BD';}
				elseif(in_array('DR', $manager)){$type='DR';}
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
			
				// echo $this->auth->my_teams();
				
				$upb_id=$rowData['iupb_id'];
				$ifor_id=$rowData['ifor_id'];
                $vhpp = $this->input->get('vhpp');
				$qcek="select h.vnip_apppd, h.vnip_appfa, h.vnip_appbd, h.vnip_appdir from plc2.plc2_hpp h where h.ifor_id=$ifor_id";
				$rcount = $this->db_plc0->query($qcek)->num_rows();
				$rcek = $this->db_plc0->query($qcek)->row_array();
			
				if($rcount > 0){
				$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
				if(empty($getbp)){}
					else{
						//jika manager PD
						if($this->auth->is_manager()){
							if(($type=='PD')&&($rcek['vnip_apppd']== null)){
								$update = '<button onclick="javascript:update_btn_upload(\'product_trial_approval_hpp\', \''.base_url().'processor/plc/product/trial/approval/hpp?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/approval/hpp?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_hpp">Approve</button>';
									
								$buttons['update'] = $update.$approve;
							}

							// approval sudah tidak perlu berurutan
							//if(($type=='FA')&&($rcek['vnip_apppd']!=null)&&($rcek['vnip_appfa']==null)){
							if(($type=='FA')&&($rcek['vnip_apppd']!=null)&&($rcek['vnip_appfa']==null)){
								$update = '<button onclick="javascript:update_btn_upload(\'product_trial_approval_hpp\', \''.base_url().'processor/plc/product/trial/approval/hpp?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/approval/hpp?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_hpp">Approve</button>';
									
								$buttons['update'] = $update.$approve;
							}
							//if(($type=='BD')&&($rcek['vnip_appfa']!=null)&&($rcek['vnip_appbd']==null)){
							if(($type=='BD')&&($rcek['vnip_apppd']!=null)&&($rcek['vnip_appbd']==null)){
								$update = '<button onclick="javascript:update_btn_upload(\'product_trial_approval_hpp\', \''.base_url().'processor/plc/product/trial/approval/hpp?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/approval/hpp?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_hpp">Approve</button>';
									
								$buttons['update'] = $update.$approve;
							}
							//if(($type=='DR')&&(($rcek['vnip_appbd']=='-')||($rcek['vnip_appbd']!=null))&&($rcek['vnip_appdir']==null)){
							if(($type=='DR')&&($rcek['vnip_apppd']!=null)&&($rcek['vnip_appdir']==null)){
								$update = '<button onclick="javascript:update_btn_upload(\'product_trial_approval_hpp\', \''.base_url().'processor/plc/product/trial/approval/hpp?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/approval/hpp?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_hpp">Approve</button>';
									
								$buttons['update'] = $update.$approve;
							}
							else{}
						}
						//jika bukan manager PD, tapi staff PD, QA, QC atau formulator
						else{
							if(($rowData['vnip_formulator']==$this->user->gNIP)&&($rcek['vnip_apppd']==null)){
								$update = '<button onclick="javascript:update_btn_upload(\'product_trial_approval_hpp\', \''.base_url().'processor/plc/product/trial/approval/hpp?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
									
								$buttons['update'] = $update;
							}
						}
					}
				}else{
					if($this->auth->is_manager()){
						if(($type=='PD')){
							$update = '<button onclick="javascript:update_btn_upload(\'product_trial_approval_hpp\', \''.base_url().'processor/plc/product/trial/approval/hpp?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/approval/hpp?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'&vhpp='.$this->input->get('vhpp').'\')" class="ui-button-text icon-save" id="button_approve_hpp">Approve</button>';
								
							$buttons['update'] = $update.$approve;
						}
						
						else{}
						//array_unshift($buttons, $reject, $approve, $revise);
					}
					else{
						if(($rowData['vnip_formulator']==$this->user->gNIP)&&($rcek['vnip_apppd']==null)){
								$update = '<button onclick="javascript:update_btn_upload(\'product_trial_approval_hpp\', \''.base_url().'processor/plc/product/trial/approval/hpp?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
									
								$buttons['update'] = $update;
							}
						else{}
					}
				}
	   
		}
    	return $buttons;
    }
    /*
    public function listBox_Action($row, $actions) {
    	//cek apakah ada soi mikro upb itu yg statusnya sudah Final, 
		//print_r($row); exit;
		$iupbid=$row->iupb_id;
    	//formulator
		if($row->vnip_formulator==$this->user->gNIP){
			unset($actions['delete']);
		}
		elseif($this->auth->is_manager()){
			$teams = $this->auth->tipe();
			$man=$teams['manager'];
			print_r($man);
			if(in_array('BD',$man) && ($row->plc2_hpp__vnip_appbd)==''){}
			elseif(in_array('FA',$man) && ($row->plc2_hpp__vnip_appfa)==''){}
			elseif(in_array('PD',$man) && ($row->plc2_hpp__vnip_apppd)==''){}
			elseif(in_array('DR',$man) && ($row->plc2_hpp__vnip_appdir)==''){}
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
    */
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
								var url = "'.base_url().'processor/plc/product/trial/approval/hpp";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_product_trial_approval_hpp").html(data);
									});
					
								}
									reload_grid("grid_product_trial_approval_hpp");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_product_trial_approval_hpp_approve" action="'.base_url().'processor/plc/product/trial/approval/hpp?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : <input type="hidden" name="ifor_id" value="'.$this->input->get('ifor_id').'" />
    			<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
    			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                <input type="hidden" name="vhpp" value="'.$this->input->get('vhpp').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_product_trial_approval_hpp_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
		//print_r($post);

    	$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$upbid=$post['iupb_id'];
		$this->db_plc0->where('iupb_id', $post['iupb_id']);
		$this->db_plc0->update('plc2.plc2_upb', array('ihpp'=>2));
    
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
		
		//perubahan approval HPP hanya busdev 3 saja yg memerlukan//
			$qbusdev="select u.* from plc2.plc2_upb u where u.iupb_id='".$post['iupb_id']."'";
			$rbusdev = $this->db_plc0->query($qbusdev)->row_array();
		//end//
		
		//update vhpp aja
		if($post['type']=='PD'){
			$vnip='vnip_apppd';$tapp='tapppd';

		}
		elseif($post['type']=='FA'){
			if($rbusdev['iteambusdev_id']!='66'){
				$this->db_plc0->where('ifor_id', $post['ifor_id']);	
				$this->db_plc0->update('plc2.plc2_hpp', array('vnip_appbd'=>'-','tUpdate'=>$skg,'tappbd'=>'0000-00-00 00:00:00'));
				$vnip='vnip_appfa';$tapp='tappfa';
			}
			else{
				$vnip='vnip_appfa';$tapp='tappfa';
			}
		}
		elseif($post['type']=='BD'){$vnip='vnip_appbd';$tapp='tappbd';}
		elseif($post['type']=='DR'){$vnip='vnip_appdir';$tapp='tappdir';}

		/*
		//cek ditable HPP sudah ada insert belum 
		$cek_hpp="select * from plc2_hpp a where a.ifor_id = '".$post['iupb_id']."'";
        $data_hpp = $this->db_plc0->query($cek_hpp)->row_array();

        if (empty($data_hpp)) {
        	// jika belum ada data approval HPP , maka insert 
			//$ins['iCreate'] = $this->user->gNIP;
			$ins['treason'] = $post['remark'];
			$ins['tCreate'] = date('Y-m-d H:i:s');
	       	$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
        }else{
        	//jika sudah ada di approval HPP maka update saja

        	$this->db_plc0->where('ifor_id', $post['ifor_id']);	
			$this->db_plc0->update('plc2.plc2_hpp', array($vnip=>$nip,'tUpdate'=>$skg,$tapp=>$skg));

        }
		*/

        $this->db_plc0->where('ifor_id', $post['ifor_id']);	
		$this->db_plc0->update('plc2.plc2_hpp', array($vnip=>$nip,'tUpdate'=>$skg,$tapp=>$skg));
		
		
		// $sqlh = "Update plc2.plc2_hpp set vhpp = '".$vhpp_target."' ,tUpdate='".$skg."'  where id_plc2_hpp='".$updateId."'";	
		// $this->db_plc0->query($sqlh);		
		
		//jika PD approve, maka kirim email ke FA, Busdev dan Direksi
        
        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id,
                (select te.iteam_id from plc2.plc2_upb_team te where te.cDeptId='PR') as iteampr_id,
                (select te.iteam_id from plc2.plc2_upb_team te where te.cDeptId='FA') as iteamfa_id  
                from plc2.plc2_upb u 
                where u.iupb_id='".$post['iupb_id']."'";
        $rsql = $this->db_plc0->query($qsql)->row_array();

        $pd = $rsql['iteampd_id'];
        $bd = $rsql['iteambusdev_id'];
        $qa = $rsql['iteamqa_id'];
        $qc = $rsql['iteamqc_id'];
        $pr = $rsql['iteampr_id'];
        $fa = $rsql['iteamfa_id'];
        
        $team = $pd.','.$bd.','.$fa ;        

		$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
				(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
				(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
				(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
				(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
				from plc2.plc2_upb u where u.iupb_id='".$post['iupb_id']."'";
		$rupb = $this->db_plc0->query($qupb)->row_array();
        
        
        
		if($post['type']=='PD'){
            $toEmail = $this->lib_utilitas->get_email_team( $fa );
            $head = "Diberitahukan bahwa telah ada approval oleh PD pada proses Approval HPP(aplikasi PLC) dengan rincian sebagai berikut :<br><br>";
            $desc = "<td><b>Proses Selanjutnya</b></td><td> : </td><td>Approval HPP - Approval oleh FA</td>";
        }elseif($post['type']=='FA'){
            $toEmail = $this->lib_utilitas->get_email_team( $bd );
            $head = "Diberitahukan bahwa telah ada approval oleh FA pada proses Approval HPP(aplikasi PLC) dengan rincian sebagai berikut :<br><br>";
            $desc = "<td><b>Proses Selanjutnya</b></td><td> : </td><td>Approval HPP - Approval oleh Busdev</td>";
        }elseif($post['type']=='BD'){
            $head = "Diberitahukan bahwa telah ada approval oleh Busdev pada proses Approval HPP(aplikasi PLC) dengan rincian sebagai berikut :<br><br>";
            $desc = "<td><b>Proses Selanjutnya</b></td><td> : </td><td>Approval HPP - Approval oleh Direksi</td>";
            $toEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );
        }elseif($post['type']=='DR'){
            $toEmail = $this->lib_utilitas->get_email_team($pd);
            $head = "Diberitahukan bahwa telah ada approval oleh Direksi pada proses Approval HPP(aplikasi PLC) dengan rincian sebagai berikut :<br><br>";
            $desc = "<td><b>Proses Selanjutnya</b></td><td> : </td><td>Basic Formula - Input data oleh PD</td>";
        }

        $toEmail2 = $this->lib_utilitas->get_email_team( $team );
        $to = $toEmail;
        $cc = $toEmail2;
        
        $subject="Proses Approval HPP: UPB ".$rupb['vupb_nomor'];
        $content= $head."                
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
                                        ".$desc."
                                </tr>
                        </table>
                </div>
                <br/> 
                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
                Post Master";
        /*echo  $to;
        echo '</br>cc:' .$cc;      
        echo  $content ;    
        exit;*/
        $this->lib_utilitas->send_email($to, $cc, $subject, $content);
        
		$data['status']  = true;
    	$data['last_id'] = $ifor_id;
    	return json_encode($data);
    }
    function listBox_product_trial_approval_hpp_plc2_hpp_vnip_apppd($value) {
    	if($value==null){$vstatus='Waiting for approval';}
    	else{$vstatus='Approved';}
    	return $vstatus;
    }
	 function listBox_product_trial_approval_hpp_plc2_hpp_vnip_appfa($value) {
    	if($value==null){$vstatus='Waiting for approval';}
    	else{$vstatus='Approved';}
    	return $vstatus;
    }
	 function listBox_product_trial_approval_hpp_plc2_hpp_vnip_appbd($value) {
    	if($value==null){$vstatus='Waiting for approval';}
    	else{$vstatus='Approved';}
    	return $vstatus;
    }
	 function listBox_product_trial_approval_hpp_plc2_hpp_vnip_appdir($value) {
    	if($value==null){$vstatus='Waiting for approval';}
    	else{$vstatus='Approved';}
    	return $vstatus;
    }
	//Keterangan approval 
	
	function updateBox_product_trial_approval_hpp_vnip_apppd($field, $id, $value, $rowData) {
		$ifor_id=$rowData['ifor_id'];
		$qcek="select h.vnip_apppd, h.tapppd from plc2.plc2_hpp h where h.ifor_id=$ifor_id";
		$rcek = $this->db_plc0->query($qcek)->row_array();
		$rcount = $this->db_plc0->query($qcek)->num_rows();
		
		if($rcount > 0){
			if($rcek['vnip_apppd'] != null){
				$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rcek['vnip_apppd']))->row_array();
				$ret= 'Approved oleh '.$row['vName'].' ( '.$rcek['vnip_apppd'].' )'.' pada '.$rcek['tapppd'];
				// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
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
	function updateBox_product_trial_approval_hpp_vnip_appfa($field, $id, $value, $rowData) {
		$ifor_id=$rowData['ifor_id'];
		$qcek="select h.vnip_appfa, h.tappfa from plc2.plc2_hpp h where h.ifor_id=$ifor_id";
		$rcek = $this->db_plc0->query($qcek)->row_array();
		$rcount = $this->db_plc0->query($qcek)->num_rows();
		
		if($rcount > 0){
			if($rcek['vnip_appfa'] != null){
				$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rcek['vnip_appfa']))->row_array();
				$ret= 'Approved oleh '.$row['vName'].' ( '.$rcek['vnip_appfa'].' )'.' pada '.$rcek['tappfa'];
				// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
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
	function updateBox_product_trial_approval_hpp_vnip_appbd($field, $id, $value, $rowData) {
		//print_r($rowData);
		$ifor_id=$rowData['ifor_id'];
		$qcek="select h.vnip_appbd, h.tappbd from plc2.plc2_hpp h where h.ifor_id=$ifor_id";
		$rcek = $this->db_plc0->query($qcek)->row_array();
		$rcount = $this->db_plc0->query($qcek)->num_rows();
		if($rcount > 0){
			if($rcek['vnip_appbd']=='-'){
				$ret='Tidak Memerlukan Approval';
			}
			elseif($rcek['vnip_appbd'] != null){
				$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rcek['vnip_appbd']))->row_array();
				$ret= 'Approved oleh '.$row['vName'].' ( '.$rcek['vnip_appbd'].' )'.' pada '.$rcek['tappbd'];
				// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
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
	function updateBox_product_trial_approval_hpp_vnip_appdir($field, $id, $value, $rowData) {
		$ifor_id=$rowData['ifor_id'];
		$qcek="select h.vnip_appdir, h.tappdir from plc2.plc2_hpp h where h.ifor_id=$ifor_id";
		$rcek = $this->db_plc0->query($qcek)->row_array();
		$rcount = $this->db_plc0->query($qcek)->num_rows();
		if($rcount > 0){
			if($rcek['vnip_appdir'] != null){
				$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rcek['vnip_appdir']))->row_array();
				$ret= 'Approved oleh '.$row['vName'].' ( '.$rcek['vnip_appdir'].' )'.' pada '.$rcek['tappdir'];
				// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
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
	//
    function updateBox_product_trial_approval_hpp_vkode_surat($name, $id, $value) {
		if($value==''){$value='-';}
		return $value;
	}
	
	function updateBox_product_trial_approval_hpp_tberlaku($name, $id, $value) {
		if($value==''){$value='-';}
		return tanggal($value,'l, F jS, Y');
	}
	
	function updateBox_product_trial_approval_hpp_filename($name, $id, $value) {
		if($value != '') {
			if (file_exists('./files/plc/product_trial/formula_trial/'.$value)) {
				$link = base_url().'processor/plc/product/trial/formula/skala/trial?action=download&file='.$value;
				$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			}
			else {
				$linknya = 'File sudah tidak ada!';
			}
			return 'File name : '.$value.' ['.$linknya.']';
		}
		else {
			return 'No File<br />';
		}		
	}
	
	function updateBox_product_trial_approval_hpp_vfile_lab($name, $id, $value) {
		if($value != '') {
			if (file_exists('./files/plc/product_trial/formula_trial/'.$value)) {
				$link = base_url().'processor/plc/product/trial/formula/skala/trial?action=download&file='.$value;
				$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			}
			else {
				$linknya = 'File sudah tidak ada!';
			}
			return 'File name : '.$value.' ['.$linknya.']';
		}
		else {
			return 'No File<br />';
		}
	}	
	
	function updateBox_product_trial_approval_hpp_vrevisi($name, $id, $value) {
		if($value==''){$value='-';}
		return $value;
	}
	
	function updateBox_product_trial_approval_hpp_vhpp($name, $id, $value) {
		return '<input type="text" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1" size="15" onkeypress="return isFloatKey(event)"/>';
	}
	
	function updateBox_product_trial_approval_hpp_vnip_formulator($name, $id, $value) {
		$row = $this->user_model->get_user_info($value);
		if(sizeOf($row)>0){
			return $row['cNip'].' | '.$row['vName'].' | '.$row['divisi'];
		}else{
			return ' | | ';
		}
		
	}
	function before_update_processor($row, $postData) {
		unset($postData['vkode_surat']);
		unset($postData['tberlaku']);
		unset($postData['filename']);
		unset($postData['vfile_lab']);
		unset($postData['vrevisi']);
		unset($postData['vhpp']);
		unset($postData['vnip_formulator']);
		
		//unset($postData['tdate']);
	
		return $postData;
	}
	function after_update_processor($row, $updateId, $postData) {
		
		//print_r($postData);
		$getbp=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // activity 3 input data
		$bizsup=$getbp['idplc2_biz_process_sub'];
		
		//getiupb_id
		$ifor_id=$postData['ifor_id'];
		//get upb_id
			$qupb="select f.iupb_id from plc2.plc2_upb_formula f where f.ifor_id=$ifor_id";
			$rupb = $this->db_plc0->query($qupb)->row_array();
			
			$iupb_id=$rupb['iupb_id'];
			
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
		
		$vhpp_target=$postData['vhpp'];
		$skg=date('Y-m-d H:i:s');
		
		//cek jika sudah ada data di plc2_hpp
		$qcek="select * from plc2.plc2_hpp h where h.ifor_id=$ifor_id";
		$rcount = $this->db_plc0->query($qcek)->num_rows();
		
		
		if($rcount==0){
			
			//insert tabel plc2_hpp
			$ins['vhpp'] = $postData['vhpp'];
			$ins['ifor_id'] = $postData['ifor_id'];
			$ins['iCreate'] = $this->user->gNIP;
			$ins['tCreate'] = $skg;
			$this->db_plc0->insert('plc2.plc2_hpp', $ins);
		}
		else{
			$getid=$this->db_plc0->query($qcek)->row_array();
			$id_hpp=$getid['id_plc2_hpp'];
			//update vhpp aja
			$sqlh = "Update plc2.plc2_hpp set vhpp = '".$vhpp_target."' ,tUpdate='".$skg."'  where id_plc2_hpp='".$id_hpp."'";	
			$this->db_plc0->query($sqlh);
		}
		//update tabel upb
		$sqlu = "Update plc2.plc2_upb set vhpp_target = '".$vhpp_target."' where iupb_id='".$iupb_id."'";	
		$this->db_plc0->query($sqlu);
		
		//update tabel formula
		$sqlf = "Update plc2.plc2_upb_formula set vhpp = '".$vhpp_target."' where ifor_id='".$ifor_id."'";	
		$this->db_plc0->query($sqlf);
		
		
	}

	function output(){
    	$this->index($this->input->get('action'));
    }
}
