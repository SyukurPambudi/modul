<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pembagian_produk_staff_export extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_plcexport');
		$this->load->library('lib_utilitas');
		$this->load->library('dossier_log');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->dbset3 = $this->load->database('plc', true);
		$this->user = $this->auth_plcexport->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Pembagian Produk');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_upd');		
		$grid->setUrl('pembagian_produk_staff_export');
		$grid->addList('vUpd_no','vNama_usulan','iSemester','iTahun','iTeam_andev','iappad_produk_staff');
		$grid->setSortBy('vUpd_no');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('det_upd','iappad_produk_staff');

		//setting widht grid
		$grid->setWidth('vUpd_no', '80'); 
		$grid->setWidth('vNama_usulan', '350'); 
		$grid->setWidth('iSemester', '70'); 
		$grid->setWidth('iTahun', '70'); 
		$grid->setWidth('iTeam_andev', '100'); 
		$grid->setWidth('lDeleted', '100'); 
		
		//setting align
		$grid->setAlign('iSemester','center');
		$grid->setAlign('iTahun','center');
		//modif label
		$grid->setLabel('det_upd','');
		$grid->setLabel('vUpd_no','No UPD');
		$grid->setLabel('iappad_produk_staff','Approval AD Manager');
		$grid->setLabel('iapptd_produk_staff','Approval TD Manager');
		$grid->setLabel('iTeam_andev','Team Andev');
		$grid->setLabel('vNama_usulan','Nama Usulan');
		$grid->setLabel('iSemester','Semester');
		$grid->setLabel('iTahun','Tahun');

		$grid->setFormUpload(TRUE);

		$grid->setSearch('vUpd_no');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iappad_produk_staff','combobox','',array(0=>'Need Approval',1=>'Rejected',2=>'Approved'));
		$grid->changeFieldType('iapptd_produk_staff','combobox','',array(0=>'Need Approval',1=>'Rejected',2=>'Approved'));
		$grid->changeFieldType('iTeam_andev','combobox','',array(''=>'Pilih','17'=>'Andev Export 1','40'=>'Andev Export 2'));
		
		

	//Field mandatori
		$grid->setRequired('iSediaan');	
		$grid->setRequired('iTeam_andev');	
		$grid->setRequired('lDeleted');	

		
		#$grid->setJoinTable('dossier.dossier_prioritas_detail', 'dossier_prioritas_detail.idossier_upd_id = dossier_upd.idossier_upd_id', 'inner');
		#$grid->setJoinTable('dossier.dossier_prioritas', 'dossier_prioritas.idossier_prioritas_id = dossier_prioritas_detail.idossier_prioritas_id', 'inner');
		$grid->setJoinTable('dossier.dossier_jenis_dok','dossier_jenis_dok.ijenis_dok_id=dossier_upd.iSediaan','left');
		$grid->setQuery('dossier_upd.idossier_upd_id in (
						select a.idossier_upd_id 
						from dossier.dossier_upd a 
						join dossier.dossier_prioritas_detail b on b.idossier_upd_id = a.idossier_upd_id
						join dossier.dossier_prioritas c on c.idossier_prioritas_id=b.idossier_prioritas_id 
						where c.iApprove_prio= 2
						and a.lDeleted = 0
						and b.lDeleted = 0
						and c.lDeleted = 0
						#and a.iSubmit_bagi_upd=1
						and a.vpic is not null
						and b.lDeleted=0
						group by a.idossier_upd_id)', NULL);
		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setQuery('dossier_upd.ihold', 0);
		//$grid->setQuery('dossier_upd.iappad_pembagian', 2);
		

		$mydept=$this->auth_plcexport->tipe();
		if($this->auth_plcexport->is_manager()){
			$x=$this->auth_plcexport->dept();
			$manager=$x['manager'];
			$q="select te.iteam_id from plc2.plc2_upb_team te where te.vnip in ('".$this->user->gNIP."') and te.iTipe=2";
			if(in_array('BDI', $manager)){
				$type='BDI';
				$q.=" and vtipe='".$type."'";
				$d=$this->dbset->query($q)->row_array();
				if($d['iteam_id']==91){//BDIRM 1
					$sq='dossier_upd.iTeam_andev in (17)';
					$grid->setQuery($sq, null);
				}elseif ($d['iteam_id']==78) {
					$sq='dossier_upd.iTeam_andev in (40)';
					$grid->setQuery('('.$sq.' or is_old=1)', null);
				}
			}elseif(in_array('AD', $manager)){
				$type='AD';
				$q.=" and vtipe='".$type."'";
				$d=$this->dbset->query($q)->row_array();
				if($d['iteam_id']==17){//BDIRM 1
					$sq='dossier_upd.iTeam_andev in (17)';
					$grid->setQuery($sq, null);
				}elseif ($d['iteam_id']==40) {
					$sq='dossier_upd.iTeam_andev in (40)';
					$grid->setQuery('('.$sq.' or is_old=1)', null);
				}
			}else{$type='';}
		}else{
			$x=$this->auth_plcexport->dept();
			$q="select * from plc2.plc2_upb_team_item te 
				inner join plc2.plc2_upb_team it on it.iteam_id
				where te.vnip in ('".$this->user->gNIP."') and te.ldeleted=0 and it.ldeleted=0";
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('AD', $team)){
					$type='AD';
					$q.=" and vtipe='".$type."'";
					$d=$this->dbset->query($q)->row_array();
					if($d['iteam_id']==17){//BDIRM 1
						$sq='dossier_upd.iTeam_andev in (17)';
						$grid->setQuery($sq, null);
					}elseif ($d['iteam_id']==40) {
						$sq='dossier_upd.iTeam_andev in (40)';
						$grid->setQuery('('.$sq.' or is_old=1)', null);
					}
				}elseif(in_array('BDI', $team)){
					$type='BDI';
					$q.=" and vtipe='".$type."'";
					$d=$this->dbset->query($q)->row_array();
					if($d['iteam_id']==91){//BDIRM 1
						$sq='dossier_upd.iTeam_andev in (17)';
						$grid->setQuery($sq, null);
					}elseif ($d['iteam_id']==78) {
						$sq='dossier_upd.iTeam_andev in (40)';
						$grid->setQuery('('.$sq.' or is_old=1)', null);
					}
				}
			}
		}
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				$post=$this->input->post();
				$idupd=array();
				$vpic=array();
				$vpic_andev=array();
				foreach ($post as $kpost => $vpost) {
					if($kpost=='idossier_upd_id'){
						foreach ($vpost as $k => $v) {
							$idupd[$k]=$v;
						}
					}
					if($kpost=='pic_pembagian_produk'){
						foreach ($vpost as $k => $v) {
							$vpic[$k]=$v;
						}
					}
					if($kpost=='pic_pembagian_produk_andev'){
						foreach ($vpost as $k => $v) {
							$vpic_andev[$k]=$v;
						}
					}
				}
				$isubmit=0;
				$iproses=2;//insert submit
				if($post['isdraft']==true){
					$isubmit=0;
					$iproses=1;//insert draft
				} 
				else{$isubmit=1;} 
				$sql=array();
				foreach ($idupd as $upk => $vkp) {
					$sql[]='UPDATE dossier.dossier_upd up SET up.vpic="'.$vpic[$upk].'", up.vpic_andev="'.$vpic_andev[$upk].'", up.iSubmit_bagi_staff='.$isubmit.' WHERE up.idossier_upd_id='.$vkp;
					$user=$this->user->gNIP;
					$date=date('Y-m-d H:m:s');
					$sql[]='INSERT INTO dossier.dossier_history_pic_andev (idossier_upd_id, cpic_andev, dmulai, dCreate, cCreated) VALUES ('.$vkp.', "'.$vpic_andev[$upk].'", "'.$date.'", "'.$date.'", "'.$user.'")';
					$sql[]='INSERT INTO dossier.dossier_history_pic_dossier (idossier_upd_id, cpic_dossier, dmulai, dCreate, cCreated) VALUES ('.$vkp.', "'.$vpic[$upk].'", "'.$date.'", "'.$date.'", "'.$user.'")';
					$this->dossier_log->insertlog($vkp,$this->input->get('modul_id'),$iproses);
				}
				if(isset($sql)){
					foreach ($sql as $ks => $vs) {
						try {
						$this->dbset->query($vs);
						}catch(Exception $e) {
						die($e);
						}
					}
				}

				$r['status'] = TRUE;
				$r['message'] = "Data Berhasil di Update";
				echo json_encode($r);
				break;
			case 'download':
				$this->download($this->input->get('file'));
				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'carinegara':
				$this->carinegara();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				$post=$this->input->post();
				$iproses=4; //update submit
				if($post['isdraft']==true){
					$isubmit=0;
					$iproses=3;//update draft;
				} 
				else{$isubmit=1;} 
				$id=$post['idossier_upd_id'];
				$pic=$post['pic_pembagian_produk'];
				$pic_andev=$post['pic_pembagian_andev_produk'];
				$sql='UPDATE dossier.dossier_upd up SET up.vpic="'.$pic.'",up.vpic_andev="'.$pic_andev.'", up.iSubmit_bagi_staff='.$isubmit.' WHERE up.idossier_upd_id='.$id;
				try {
					$this->dbset->query($sql);
				}catch(Exception $e) {
					die($e);
				}
				$sql2="UPDATE dossier.dossier_history_pic_andev his SET his.cpic_andev='".$pic_andev."', his.dmulai='".date('Y-m-d H:m:s')."', his.dupdate='".date('Y-m-d H:m:s')."', his.cUpdate='".$this->user->gNIP."' where his.idossier_upd_id=".$id;
				try {
					$this->dbset->query($sql2);
				}catch(Exception $e) {
					die($e);
				}
				$sql3="UPDATE dossier.dossier_history_pic_dossier his SET his.cpic_dossier='".$pic."', his.dmulai='".date('Y-m-d H:m:s')."', his.dupdate='".date('Y-m-d H:m:s')."', his.cUpdate='".$this->user->gNIP."' where his.idossier_upd_id=".$id;
				try {
					$this->dbset->query($sql3);
				}catch(Exception $e) {
					die($e);
				}
				$this->dossier_log->insertlog($id,$this->input->get('modul_id'),$iproses);
				$r['last_id'] = $id;
				$r['status'] = TRUE;
				$r['message'] = "Data Berhasil di Update";
				echo json_encode($r);
				//echo $grid->updated_form();
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
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }
function listBox_Action($row, $actions) {
	if($this->auth_plcexport->is_manager()){
		$x=$this->auth_plcexport->dept();
		$manager=$x['manager'];
		if(in_array('AD', $manager)){
			$type='AD';
			if($row->iSubmit_bagi_staff!=0){
				unset($actions['delete']);
				if($row->iappad_produk_staff!=0){
					unset($actions['edit']);
				}
			}
		}
		else{$type='';}
	}
	else{
		$x=$this->auth_plcexport->dept();
		$team=$x['team'];
		if(in_array('AD', $team)){$type='AD';
			if($row->iSubmit_bagi_staff!=0){
				unset($actions['delete']);
				unset($actions['edit']);
			}
		}
		else{$type='';}
	}
	return $actions;
}


function listBox_pembagian_produk_staff_export_iTahun($v,$p,$d,$r) {
	$sql="select c.*
						from dossier.dossier_upd a 
						join dossier.dossier_prioritas_detail b on b.idossier_upd_id = a.idossier_upd_id
						join dossier.dossier_prioritas c on c.idossier_prioritas_id=b.idossier_prioritas_id 
						where c.iApprove_prio= 2
						and a.lDeleted = 0
						and b.lDeleted = 0
						and c.lDeleted = 0
						#and a.iSubmit_bagi_upd=1
						and a.vpic is not null
						and b.lDeleted=0
						and a.idossier_upd_id=".$r->idossier_upd_id;
	$q=$this->dbset->query($sql);
	$ret="-";
	if($q->num_rows()>=1){
		$dat=$q->row_array();
		$ret=$dat['iTahun'];
	}
	return $ret;
}
function listBox_pembagian_produk_staff_export_iSemester($v,$p,$d,$r) {
		$sql="select c.*
						from dossier.dossier_upd a 
						join dossier.dossier_prioritas_detail b on b.idossier_upd_id = a.idossier_upd_id
						join dossier.dossier_prioritas c on c.idossier_prioritas_id=b.idossier_prioritas_id 
						where c.iApprove_prio= 2
						and a.lDeleted = 0
						and b.lDeleted = 0
						and c.lDeleted = 0
						#and a.iSubmit_bagi_upd=1
						and a.vpic is not null
						and b.lDeleted=0
						and a.idossier_upd_id=".$r->idossier_upd_id;
	$q=$this->dbset->query($sql);
	$ret="-";
	if($q->num_rows()>=1){
		$dat=$q->row_array();
		$ret=$dat['iSemester'];
	}
	return $ret;
}

function insertBox_pembagian_produk_staff_export_det_upd($field, $id) {
 		$return = '<script>
			$("label[for=\''.$id.'\']").remove();
		</script>';
		$data=array();
		$return .='<input type="hidden" name="isdraft" id="isdraft">';
		$return .= $this->load->view('det_upd_pembagian_produk_staff_export',$data,TRUE);
		return $return;
}
function updateBox_pembagian_produk_staff_export_det_upd($field, $id, $value, $rowData) {
 		$return = '<script>
			$("label[for=\''.$id.'\']").remove();
		</script>';
		$data=array();
		$sql="select *, (select vName from hrd.employee em where em.cNip=upd.vpic) as namedossier,
				(select vName from hrd.employee em where em.cNip=upd.vpic_andev) as nameandev 
				from dossier.dossier_upd upd
				inner join plc2.itemas upb on upd.iupb_id=upb.C_ITENO
				where upd.lDeleted=0
				and upd.idossier_upd_id=".$rowData['idossier_upd_id'];
		$data['rows']=$this->dbset->query($sql)->result_array();
		$return .='<input type="hidden" name="isdraft" id="isdraft">';
		$return .= $this->load->view('det_upd_pembagian_produk_staff_export',$data,TRUE);
		return $return;
}
function insertBox_pembagian_produk_staff_export_iappad_produk_staff($field, $id) {
	return "-";
}
function updateBox_pembagian_produk_staff_export_iappad_produk_staff($field, $id, $value, $rowData) {
	if($rowData['cappad_produk_staff'] != null && $rowData['iappad_produk_staff']!=0){
		$row = $this->dbset2->get_where('hrd.employee', array('cNip'=>$rowData['cappad_produk_staff']))->row_array();
		if($rowData['iappad_produk_staff']==2){$st="Approved";}elseif($rowData['iappad_produk_staff']==1){$st="Rejected";} 
		$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['cappad_produk_staff'].' )'.' pada '.$rowData['dappad_produk_staff'];
	}
	else{
		$ret='Waiting for Approval';
	}
	
	return $ret;
}
function insertBox_pembagian_produk_staff_export_iapptd_produk_staff($field, $id) {
	return "-";
}
function updateBox_pembagian_produk_staff_export_iapptd_produk_staff($field, $id, $value, $rowData) {
	if($rowData['capptd_produk_staff'] != null && $rowData['iapptd_produk_staff']!=0){
		$row = $this->dbset2->get_where('hrd.employee', array('cNip'=>$rowData['capptd_produk_staff']))->row_array();
		if($rowData['iapptd_produk_staff']==2){$st="Approved";}elseif($rowData['iapptd_produk_staff']==1){$st="Rejected";} 
		$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['capptd_produk_staff'].' )'.' pada '.$rowData['dapptd_produk_staff'];
	}
	else{
		$ret='Waiting for Approval';
	}
	
	return $ret;
}
function manipulate_insert_button($buttons) {
	unset($buttons['save']);
	//$js=$this->load->view('misc_util',array('className'=> 'study_literatur_pd'), true);
	$js = $this->load->view('pembagian_produk_staff_export_js');
	//$js .= $this->load->view('uploadjs');
	if($this->auth_plcexport->is_manager()){
		$x=$this->auth_plcexport->dept();
		$manager=$x['manager'];
		if(in_array('AD', $manager)){$type='AD';
			$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'pembagian_produk_staff_export\', \''.base_url().'processor/plc/pembagian/produk/staff/export?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_pembagian_produk_staff_export">Save as Draft</button>';
			$save = '<button onclick="javascript:save_btn_multiupload(\'pembagian_produk_staff_export\', \''.base_url().'processor/plc/pembagian/produk/staff/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_pembagian_produk_staff_export">Save &amp; Submit</button>';
			
			$buttons['save'] = $save_draft.$save.$js;
		}
		elseif(in_array('TD', $manager)){$type='TD';
			$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'pembagian_produk_staff_export\', \''.base_url().'processor/plc/pembagian/produk/staff/export?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_pembagian_produk_staff_export">Save as Draft</button>';
			$save = '<button onclick="javascript:save_btn_multiupload(\'pembagian_produk_staff_export\', \''.base_url().'processor/plc/pembagian/produk/staff/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_pembagian_produk_staff_export">Save &amp; Submit</button>';
			
			$buttons['save'] = $save_draft.$save.$js;
		}
		else{$type='';}
	}
	else{
		$x=$this->auth_plcexport->dept();
		$team=$x['team'];
		if(in_array('AD', $team)){$type='AD';
			$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'pembagian_produk_staff_export\', \''.base_url().'processor/plc/pembagian/produk/staff/export?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_pembagian_produk_staff_export">Save as Draft</button>';
			$save = '<button onclick="javascript:save_btn_multiupload(\'pembagian_produk_staff_export\', \''.base_url().'processor/plc/pembagian/produk/staff/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_pembagian_produk_staff_export">Save &amp; Submit</button>';
			$buttons['save'] = $save_draft.$save.$js;
		}elseif(in_array('TD', $team)){$type='TD';
			$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'pembagian_produk_staff_export\', \''.base_url().'processor/plc/pembagian/produk/staff/export?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_pembagian_produk_staff_export">Save as Draft</button>';
			$save = '<button onclick="javascript:save_btn_multiupload(\'pembagian_produk_staff_export\', \''.base_url().'processor/plc/pembagian/produk/staff/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_pembagian_produk_staff_export">Save &amp; Submit</button>';
			$buttons['save'] = $save_draft.$save.$js;
		}
		else{$type='';}
	}
	return $buttons;
}

function approve_view() {
	$echo = '<script type="text/javascript">
				 function submit_ajax(form_id) {
				 	$(document.body).append(\'<div id="loading_approve_process">Loading For Prepare Your Document</div>\');
				 	$("#loading_approve_process").fadeIn(800);
					return $.ajax({
				 	 	url: $("#"+form_id).attr("action"),
				 	 	type: $("#"+form_id).attr("method"),
				 	 	data: $("#"+form_id).serialize(),
				 	 	success: function(data) {
				 	 		var o = $.parseJSON(data);
							var last_id = o.last_id;							
							if(o.status == true) {
								$("#alert_dialog_form").dialog("close");
									$.get(base_url+"processor/plc/pembagian/produk/staff/export?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
                            			 $("div#form_pembagian_produk_staff_export").html(data);
                    				});
								
							}
								reload_grid("grid_pembagian_produk_staff_export");
								$("#loading_approve_process").fadeOut(600);

								_custom_alert("Approval Berhasil!","info","info", "pembagian_produk_staff_export", 1, 20000);
						}
				 	 	
				 	 })
				 }
			 </script>';
	$echo .= '<h1>Approval</h1><br />';
	$echo .= '<form id="form_pembagian_produk_staff_export_approve" action="'.base_url().'processor/plc/pembagian/produk/staff/export?action=approve_process" method="post">';
	$echo .= '<div style="vertical-align: top;">';
	$echo .= 'Remark : 
			<input type="hidden" name="idossier_upd_id" value="'.$this->input->get('idossier_upd_id').'" />
			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
			<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
			<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
			<textarea name="vRemark"></textarea>
	<button type="button" onclick="submit_ajax(\'form_pembagian_produk_staff_export_approve\')">Approve</button>';
		
	$echo .= '</div>';
	$echo .= '</form>';
	$echo .='<style>
			#loading_approve_process{
				position: fixed;
			    top: 0;
			    left: 0;
			    background-color: #1e5f8f;
			    opacity: 0.9;
			    z-index: 9999;
			    text-align: center;
			    width: 100%;
			    height: 100%;
			    padding-top: 200px;
			    font-size: 25px;
			    color: #fff;
			    display: none;
			}
			</style>
			';
	return $echo;
}

function approve_process(){
	$post = $this->input->post();
	$cNip= $this->user->gNIP;
	$vRemark = $post['vRemark'];
	$tApprove=date('Y-m-d H:i:s');
	$type=$post['type'];
	$capp=$type=='AD'?'cappad_produk_staff':'capptd_produk_staff';
	$dapp=$type=='AD'?'dappad_produk_staff':'dapptd_produk_staff';
	$iapp=$type=='AD'?'iappad_produk_staff':'iapptd_produk_staff';
	$remark=$type=='AD'?'tremarktd_produk_staff':'tremarkad_produk_staff';
	$sql="update dossier.dossier_upd set ".$remark."='".$vRemark."',".$capp."='".$cNip."', ".$dapp."='".$tApprove."', ".$iapp."=2 where idossier_upd_id='".$post['idossier_upd_id']."'";
	$this->dbset->query($sql);

	$sql="select * from dossier.dossier_upd up where up.lDeleted=0 and up.idossier_upd_id=".$post['idossier_upd_id'];
	$dt=$this->dbset->query($sql)->row_array();
	if($type=='AD'){
		$kom['idossier_upd_id']=$post['idossier_upd_id'];
		$kom['iApprove_keb']=2;
		$kom['dCreate']=date('Y-m-d H:i:s');
		$kom['cCreated']=$this->user->gNIP;
		$this->dbset->insert('dossier.dossier_review', $kom);

		$where = array('idossier_upd_id' => $post['idossier_upd_id'], 'lDeleted'=> 0);
		$this->dbset->where($where);
		$dt2=$this->dbset->get('dossier.dossier_review')->row_array();

		$sqlrev="select * from dossier.dossier_review rev
				inner join dossier.dossier_upd upd on rev.idossier_upd_id=upd.idossier_upd_id
				inner join dossier.dossier_standar_dok st on st.istandar_dok_id=upd.istandar_dok_id
				inner join dossier.dossier_standar_dok_detail stdet on stdet.istandar_dok_id=st.istandar_dok_id
				where rev.lDeleted=0 and upd.lDeleted=0 and st.lDeleted=0 and stdet.lDeleted=0 and rev.idossier_review_id=".$dt2['idossier_review_id'];
		$dtrev=$this->dbset->query($sqlrev)->result_array();
		
		$sqldok="select * from dossier.dossier_dokumen dok 
				where dok.lDeleted=0";
		$dtdok=$this->dbset->query($sqldok)->result_array();

		$dtinsert=array();
		foreach ($dtrev as $krev => $vrev) {
			$dtinsert['idossier_review_id']=$vrev['idossier_review_id'];
			$dtinsert['idossier_dokumen_id']=$vrev['idossier_dokumen_id'];
			$this->dbset->insert('dossier.dossier_dok_list',$dtinsert);
		}
	}
	$iproses=6;
	$this->dossier_log->insertlog($post['idossier_upd_id'],$post['modul_id'],$iproses);
    $team='"AD","TD"';
    //nip team
    $sql='select * from plc2.plc2_upb_team_item ite
			inner join plc2.plc2_upb_team te on ite.iteam_id=te.iteam_id
			where te.ldeleted=0 and te.ldeleted=0 and te.vtipe in ('.$team.')';	
	$dteam=$this->dbset3->query($sql)->result_array();
	$dto='';
	$i=0;
	foreach ($dteam as $ktean => $vteam) {
		if($i==0){
			$dto.="'".$vteam['iteam_id']."'";
		}else{
			$dto.=",'".$vteam['iteam_id']."'";
		}
		$i++;
	}
	$teamad='';
	$sq="select * from plc2.plc2_upb_team te where te.iteam_id=".$dt['iTeam_andev'];
	$q=$this->dbset->query($sq);
	if($q->num_rows()!=0){
		$d=$q->row_array();
		$teamad=$d['vteam'];
	}
	$sqlpic="select * from hrd.employee em where em.cNip='".$dt['vpic']."' and em.lDeleted=0";
	$dpic=$this->dbset2->query($sqlpic)->row_array();
	$sqlpic2="select * from hrd.employee em where em.cNip='".$dt['vpic_andev']."' and em.lDeleted=0";
	$dpic_andev=$this->dbset2->query($sqlpic2)->row_array();
	$toEmail = $this->lib_utilitas->get_email_team($dto);
	$toEmail2 = $this->lib_utilitas->get_email_leader( $dto );

	$idandev=$this->auth_plcexport->search_teamandev($post['idossier_upd_id']);
	if ($idandev == 17) {
		$iTeamandev = 'Andev Export 1';
		$vkode="PEMBAGIAN_APP_AD1";
	}else{
		$iTeamandev = 'Andev Export 2';
		$vkode="PEMBAGIAN_APP_AD2";
	}

	$dd=$this->auth_plcexport->prepare_mail($vkode);
	$to = $dd['tto'];
	$cc = $dd['tcc'];

    $subject="Proses Pembagian Produk Staff: UPD ".$dt['vUpd_no'];
    $content="
            Diberitahukan bahwa telah ada approval oleh ".$type." Manager pada proses Pembagian Produk Staff(aplikasi PLC-Export) dengan rincian sebagai berikut :<br><br>
            <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
                    <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
                            <tr>
                                    <td style='width: 110px;'><b>No UPD</b></td><td style='width: 20px;'> : </td><td>".$dt['vUpd_no']."</td>
                            </tr>
                            <tr>
                                    <td><b>Nama Usulan</b></td><td> : </td><td>".$dt['vNama_usulan']."</td>
                            </tr>
                            <tr>
                                    <td><b>Team Andev</b></td><td> : </td><td>".$teamad."</td>
                            </tr>
                            <tr>
                                    <td><b>PIC Team Dossier</b></td><td> : </td><td>".$dpic['cNip']."-".$dpic['vName']."</td>
                            </tr>
                            <tr>
                                    <td><b>PIC Team Andev</b></td><td> : </td><td>".$dpic_andev['cNip']."-".$dpic_andev['vName']."</td>
                            </tr>

                    </table>
            </div>
            <br/> 
            Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
            Post Master";
    $this->lib_utilitas->send_email($to, $cc, $subject, $content);
    
	$data['group_id']=$post['group_id'];
	$data['modul_id']=$post['modul_id'];
	$data['status']  = true;
	$data['last_id'] = $post['idossier_upd_id'];
	
	return json_encode($data);
}

function reject_view() {
	$echo = '<script type="text/javascript">
				 function submit_ajax(form_id) {
				 	var remark = $("#reject_study_literatur_pd_vRemark").val();
				 	if (remark=="") {
				 		alert("Remark tidak boleh kosong ");
				 		return
				 	}
				 	return $.ajax({
				 		url: $("#"+form_id).attr("action"),
				 	 	type: $("#"+form_id).attr("method"),
				 	 	data: $("#"+form_id).serialize(),
				 	 	success: function(data) {
				 	 		var o = $.parseJSON(data);
							var last_id = o.last_id;							
							if(o.status == true) {
								$("#alert_dialog_form").dialog("close");
									$.get(base_url+"processor/plc/pembagian/produk/staff/export?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
                            			 $("div#form_pembagian_produk_staff_export").html(data);
                    				});
								
							}
								reload_grid("grid_pembagian_produk_staff_export");
						}
				 	 	
				 	 })
				
				 }
			 </script>';
	$echo .= '<h1>Reject</h1><br />';
	$echo .= '<form id="form_pembagian_produk_staff_export_approve" action="'.base_url().'processor/plc/pembagian/produk/staff/export?action=reject_process" method="post">';
	$echo .= '<div style="vertical-align: top;">';
	$echo .= 'Remark : 
			<input type="hidden" name="idossier_upd_id" value="'.$this->input->get('idossier_upd_id').'" />
			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
			<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
			<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
			<textarea name="vRemark"></textarea>
	<button type="button" onclick="submit_ajax(\'form_pembagian_produk_staff_export_approve\')">Reject</button>';
		
	$echo .= '</div>';
	$echo .= '</form>';
	return $echo;
}

function reject_process () {
	$post = $this->input->post();
	$cNip= $this->user->gNIP;
	$vRemark = $post['vRemark'];
	$tApprove=date('Y-m-d H:i:s');
	$type=$post['type'];
	$capp=$type=='TD'?'capptd_produk_staff':'cappad_produk_staff';
	$dapp=$type=='TD'?'dapptd_produk_staff':'dappad_produk_staff';
	$iapp=$type=='TD'?'iapptd_produk_staff':'iappad_produk_staff';
	$remark=$type=='TD'?'tremarkad_produk_staff':'tremarktd_produk_staff';
	$sql="update dossier.dossier_upd set ".$remark."='".$vRemark."',".$capp."='".$cNip."', ".$dapp."='".$tApprove."', ".$iapp."=1 where idossier_upd_id='".$post['idossier_upd_id']."'";
	$this->dbset->query($sql);
	$iproses=5;
	$this->dossier_log->insertlog($id,$post['modul_id'],$iproses);
	$data['group_id']=$post['group_id'];
	$data['modul_id']=$post['modul_id'];
	$data['status']  = true;
	$data['last_id'] = $post['idossier_upd_id'];
	return json_encode($data);
}

function manipulate_update_button($buttons, $rowData){
	//print_r($rowData);exit();
	unset($buttons['update']);
	//$js=$this->load->view('misc_util',array('className'=> 'study_literatur_pd'), true);
	
	$js = $this->load->view('pembagian_produk_staff_export_js');
	//$js .= $this->load->view('uploadjs');
	$cNip=$this->user->gNIP;

	if($this->input->get('action')=='view'){

	}else{
		if($this->auth_plcexport->is_manager()){
			$x=$this->auth_plcexport->dept();
			$manager=$x['manager'];
			/*if(in_array('TD', $manager)){
				$type='TD';
				$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/pembagian/produk/staff/export?action=approve&idossier_upd_id='.$rowData['idossier_upd_id'].'&type='.$type.'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_pembagian_produk_staff_export">Approve</button>';
				$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/pembagian/produk/staff/export?action=reject&idossier_upd_id='.$rowData['idossier_upd_id'].'&type='.$type.'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_pembagian_produk_staff_export">Reject</button>';

				$update = '<button onclick="javascript:update_btn_back(\'pembagian_produk_staff_export\', \''.base_url().'processor/plc/pembagian/produk/staff/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_pembagian_produk_staff_export">Update & Submit</button>';
				$updatedraft = '<button onclick="javascript:update_draft_btn(\'pembagian_produk_staff_export\', \''.base_url().'processor/plc/pembagian/produk/staff/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_pembagian_produk_staff_export">Update as Draft</button>';
				if($rowData['iSubmit_bagi_staff']==0){
					$buttons['update']=$updatedraft.$update.$js;
				}
				elseif(($rowData['iSubmit_bagi_staff']<>0)&&($rowData['iappad_produk_staff']==2)&&($rowData['iapptd_produk_staff']==0)){
					$buttons['update']=$approve.$reject.$js;
				}else{}
			}else{

				$type='';
			}*/
			if(in_array('AD', $manager)){
				$type='AD';
				$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/pembagian/produk/staff/export?action=approve&idossier_upd_id='.$rowData['idossier_upd_id'].'&type='.$type.'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_pembagian_produk_staff_export">Approve</button>';
				$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/pembagian/produk/staff/export?action=reject&idossier_upd_id='.$rowData['idossier_upd_id'].'&type='.$type.'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_pembagian_produk_staff_export">Reject</button>';
				$update = '<button onclick="javascript:update_btn_back(\'pembagian_produk_staff_export\', \''.base_url().'processor/plc/pembagian/produk/staff/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_pembagian_produk_staff_export">Update & Submit</button>';
				$updatedraft = '<button onclick="javascript:update_draft_btn(\'pembagian_produk_staff_export\', \''.base_url().'processor/plc/pembagian/produk/staff/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_pembagian_produk_staff_export">Update as Draft</button>';
				if($rowData['iSubmit_bagi_staff']==0){
					$buttons['update']=$updatedraft.$update.$js;
				}
				elseif(($rowData['iSubmit_bagi_staff']<>0)&&($rowData['iappad_produk_staff']==0)){
					$buttons['update']=$approve.$reject.$js;
				}else{}
			}
			
			else{

				$type='';
			}
		}
		else{
			$x=$this->auth_plcexport->dept();
			$team=$x['team'];
			if(in_array('AD', $team)){
				$type='AD';
				if($rowData['iSubmit_bagi_staff']==0){
					$buttons['update']=$updatedraft.$update.$js;
				}else{}
			}
			else{
				$type='';
			}
		}
	}
	return $buttons;
}
public function output(){
	$this->index($this->input->get('action'));
}

}

