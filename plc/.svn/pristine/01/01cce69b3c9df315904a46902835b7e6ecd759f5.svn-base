<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class lpp extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->dbset = $this->load->database('plc', true);
		//$this->load->library('lib_flow');
		$this->load->library('lib_utilitas');
		$this->user = $this->auth_localnon->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;

		$grid->setTitle('Laporan Pengembangan Produk');		
		$grid->setTable('plc2.plc2_upb_formula');		
		$grid->setUrl('lpp');
		$grid->addList('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','dmulai_lpp','dselesai_lpp','isubmit_lpp','iapppd_lpp');
		$grid->setSortBy('plc2_upb.vupb_nomor');
		$grid->setSortOrder('DESC');

		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '80');
		$grid->setLabel('plc2_upb.vupb_nomor','Nomor UPB');

		$grid->setAlign('plc2_upb.vupb_nama', 'left');
		$grid->setWidth('plc2_upb.vupb_nama', '240');
		$grid->setLabel('plc2_upb.vupb_nama','Nama Usulan');

		$grid->setAlign('plc2_upb.vgenerik', 'left');
		$grid->setWidth('plc2_upb.vgenerik', '240');
		$grid->setLabel('plc2_upb.vgenerik','Nama Generik');

		$grid->setAlign('dmulai_lpp', 'center');
		$grid->setWidth('dmulai_lpp', '150');
		$grid->setLabel('dmulai_lpp','Tgl Mulai Pembuatan');

		$grid->setAlign('dselesai_lpp', 'center');
		$grid->setWidth('dselesai_lpp', '150');
		$grid->setLabel('dselesai_lpp','Tgl Selesai Pembuatan');

		$grid->setAlign('iapppd_lpp', 'center');
		$grid->setWidth('iapppd_lpp', '120');
		$grid->setLabel('iapppd_lpp','Approval PD');

		$grid->setAlign('isubmit_lpp', 'center');
		$grid->setWidth('isubmit_lpp', '120');
		$grid->setLabel('isubmit_lpp','Status Submit');

		$grid->addFields('iupb_id','vupb_nama','vgenerik','dmulai_lpp','dselesai_lpp','cPIC_PD_lpp','vfile','iapppd_lpp');

		$grid->setRequired('iupb_id','dmulai_lpp','dselesai_lpp','cPIC_PD_lpp','vfile');

		$grid->setLabel('iupb_id','Nomor UPB');
		$grid->setLabel('vupb_nama','Nama Usulan');
		$grid->setLabel('vgenerik','Nama Generik');
		$grid->setLabel('cPIC_PD_lpp','PIC PD');
		$grid->setLabel('vfile','Nama File');
		
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id', 'inner');
		$grid->setJoinTable('pddetail.formula_process','formula_process.iFormula_process=plc2_upb_formula.iFormula_process','inner');
		//$grid->setJoinTable('pddetail.formula','formula.iFormula_process=formula_process.iFormula_process','inner');
		$grid->setJoinTable('pddetail.formula_process','formula_process.iupb_id=plc2_upb_formula.iupb_id','inner');
		$grid->setJoinTable('plc2.plc2_upb_prodpilot','plc2_upb_prodpilot.ifor_id=plc2_upb_formula.ifor_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_buat_mbr', 'plc2_upb_buat_mbr.ifor_id=plc2_upb_formula.ifor_id','inner');
		$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));

		//$grid->setSearch('vupb_nomor','vupb_nama');
		$grid->setQuery('plc2_upb.ldeleted',0);
		$grid->setQuery('plc2_upb_buat_mbr.iapppd_bm',2);
		$grid->setQuery('plc2_upb_buat_mbr.ldeleted',0);
		$grid->setQuery('plc2_upb.ihold',0);
		$grid->setQuery('plc2_upb.iupb_id in (select bk.iupb_id from plc2.plc2_upb_bahan_kemas bk where bk.iapppc=2 and bk.iapppd=2 and bk.iappqa=2 and bk.iappbd=2 and bk.ldeleted=0 group by bk.iupb_id)', null); //tambah approval bahan_kemas
		$grid->setQuery('plc2_upb.iupb_id in (select distinct(fo.iupb_id) from plc2.plc2_upb_formula fo
						inner join plc2.plc2_upb_prodpilot pr on pr.ifor_id=fo.ifor_id
						where fo.ldeleted=0 and pr.ldeleted=0 and pr.iapppd_pp=2)',NULL);

		//New Parameter For PLC Non OTC
		$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2.plc2_upb.iKill', 0);
		$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
		$grid->setQuery('plc2_upb.ihold', 0);

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
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('PD', $team)){
					$type='PD';
					$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
				}
				else{$type='';}
			}
		}
		$grid->setFormUpload(TRUE);

		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama');

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
			case 'download':
				$this->download($this->input->get('file'));
				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'getspname':
				echo $this->getSpname();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				$isUpload = $this->input->get('isUpload');
				$post=$this->input->post();
				$ifor_id=$post['lpp_ifor_id'];
				$path = realpath("files/plc/lpp/");
				if(!file_exists($path."/".$ifor_id)){
					if (!mkdir($path."/".$ifor_id, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
									
				$fKeterangan = array();	
   				if($isUpload) {	
   					$fileid='';
   					foreach($_POST as $key=>$value) {
											
						if ($key == 'fileketerangan') {
							foreach($value as $y=>$u) {
								$fKeterangan[$y] = $u;
							}
						}
						if ($key == 'namafile') {
							foreach($value as $k=>$v) {
								$file_name[$k] = $v;
							}
						}
						if ($key == 'fileid') {
							$i=0;
							foreach($value as $k=>$v) {
								if($i==0){
									$fileid .= "'".$v."'";
								}else{
									$fileid .= ",'".$v."'";
								}
								$i++;
							}
						}
					}
					
					if (isset($_FILES['fileupload']))  {

						$i=0;
						foreach ($_FILES['fileupload']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
								$name =$_FILES['fileupload']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$ifor_id."/".$name)) {
									$sql[]="INSERT INTO plc2.lpp_file (ifor_id, vFilename, vKeterangan, dCreate, cCreate) 
											VALUES (".$ifor_id.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sql as $q) {
							try {
								$this->dbset->query($q);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}
					$r['message']='Data Berhasil Di Simpan!';
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');				
					echo json_encode($r);
					exit();
				}  else {
					$fileid='';
					foreach($_POST as $key=>$value) {
											
						if ($key == 'fileketerangan') {
							foreach($value as $y=>$u) {
								$fKeterangan[$y] = $u;
							}
						}
						if ($key == 'namafile') {
							foreach($value as $k=>$v) {
								$file_name[$k] = $v;
							}
						}
						if ($key == 'fileid') {
							$i=0;
							foreach($value as $k=>$v) {
								if($i==0){
									$fileid .= "'".$v."'";
								}else{
									$fileid .= ",'".$v."'";
								}
								$i++;
							}
						}
					}
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.lpp_file set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where ifor_id='".$ifor_id."' and ilpp_file_id not in (".$fileid.")";
					$this->dbset->query($sql1);
					echo $grid->updated_form();
				}
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
			case 'getemployee':
				echo $this->getEmployee();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

    /*Maniupulasi Gird Start*/
 function getEmployee() {
    	$term = $this->input->get('term');
    	$sql='select de.vDescription,em.cNip as cNIP, em.vName as vName from plc2.plc2_upb_team_item it
				inner join plc2.plc2_upb_team te on it.iteam_id= te.iteam_id
				inner join hrd.employee em on em.cNip=it.vnip
				inner join hrd.msdepartement de on de.iDeptID=em.iDepartementID 
				where em.vName like "%'.$term.'%" and te.vtipe="PD" AND it.ldeleted=0 order by em.vname ASC';
    	$dt=$this->db_plc0->query($sql);
    	$data = array();
    	if($dt->num_rows>0){
    		foreach($dt->result_array() as $line) {
	
				$row_array['value'] = trim($line['vName']);
				$row_array['id']    = $line['cNIP'];
	
				array_push($data, $row_array);
			}
    	}
    	echo json_encode($data);
		exit;
    }


/*Maniupulasi Gird end*/
function listBox_lpp_iapppd_lpp($value) {
	if($value==0){$vstatus='Waiting for approval';}
	elseif($value==1){$vstatus='Rejected';}
	elseif($value==2){$vstatus='Approved';}
	return $vstatus;
}

function listBox_lpp_isubmit_lpp($value) {
	if($value==0){$vstatus='Waiting for Submit';}
	elseif($value==1){$vstatus='Submited';}
	return $vstatus;
}

function listBox_Action($row, $actions) {
   	if($row->iapppd_lpp<>0){
    	unset($actions['edit']);
    }
    return $actions; 
	}
/*manipulasi view object form start*/
 	function updateBox_lpp_iupb_id($field, $id, $value, $rowData){
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nomor'];
		}else{
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1" value='.$value.' />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" value="'.$dt['vupb_nomor'].'" size="20" />';
		}
		return $return;
	}

	function updateBox_lpp_vupb_nama($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nama'];
		}else{
			$return='<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vupb_nama'].'" />';
		}
		return $return;
	}
	function updateBox_lpp_vgenerik($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vgenerik'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vgenerik'].'" />';
		}
		return $return;
	}
	function updateBox_lpp_dmulai_lpp($field, $id, $value, $rowData) {
		if(($rowData['dmulai_lpp']==NULl) || ($rowData['dmulai_lpp']=='')){
			$value='';
		}else{
			$value=date('d-m-Y',strtotime($rowData['dmulai_lpp']));
		}
		if($this->input->get('action')=='view'){
		$return	=$value;
		}else{
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$value.'" />';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
					</script>';
		}

		return $return;
	}
	function updateBox_lpp_dselesai_lpp($field, $id, $value, $rowData) {
		if(($rowData['dselesai_lpp']==NULl) || ($rowData['dselesai_lpp']=='')){
			$value='';
		}else{
			$value=date('d-m-Y',strtotime($rowData['dselesai_lpp']));
		}
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$value.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
		}

		return $return;
	}
	function updateBox_lpp_cPIC_PD_lpp($field, $id, $value, $rowData) {
		$url = base_url().'processor/plc/lpp?action=getemployee';
		$return	= '<script language="text/javascript">
					$(document).ready(function() {
						var config = {
							source: function( request, response) {
								$.ajax({
									url: "'.$url.'",
									dataType: "json",
									data: {
										term: request.term,
									},
									success: function( data ) {
										response( data );
									}
								});
							},
							select: function(event, ui){
								$( "#'.$id.'" ).val(ui.item.id);
								$( "#'.$id.'_text" ).val(ui.item.value);
								return false;
							},
							minLength: 2,
							autoFocus: true,
						};
	
						$( "#'.$id.'_text" ).livequery(function() {
						 	$( this ).autocomplete(config);
						});
	
					});
		      </script>';

			$sql="select * from hrd.employee em where em.cNip='".$value."'";
			$dt=$this->db_plc0->query($sql)->row_array();
			if($dt){
				$vName=$dt['vName'];
				$value=$value;
			}else{
				$vName='';
				$value='';
			}
			if($this->input->get('action')=='view'){
				$return	=$vName;
			}else{
				$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" value="'.$value.'" class="required" />
				<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20" value="'.$vName.'" />';
			}
		
		return $return;
	}

    function updateBox_lpp_vfile($field, $id, $value, $rowData) {
		$qr="select * from plc2.lpp_file where ifor_id='".$rowData['ifor_id']."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('lpp_file',$data,TRUE);
	}
	function updateBox_lpp_iapppd_lpp($field, $id, $value, $rowData) {
		if($rowData['iapppd_lpp'] != 0){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['capppd_lpp']))->row_array();
			if($rowData['iapppd_lpp']==2){$st="Approved";}elseif($rowData['iapppd_lpp']==1){$st="Rejected";} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['capppd_lpp'].' )'.' pada '.$rowData['dapppd_lpp'];
		}else{
			$ret='Waiting Approval';
		}
		return $ret;
	}
/*manipulasi view object form end*/

/*manipulasi proses object form start*/
	function manipulate_update_button($buttons, $rowData){
		unset($buttons['update']);
		$js=$this->load->view('lpp_js');
		$js .= $this->load->view('uploadjs');
		$cNip=$this->user->gNIP;

		$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/lpp?action=approve&ifor_id='.$rowData['ifor_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_lpp">Approve</button>';
		$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/lpp?action=reject&ifor_id='.$rowData['ifor_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_lpp">Reject</button>';

		$update = '<button onclick="javascript:update_btn_back(\'lpp\', \''.base_url().'processor/plc/lpp?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_lpp">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'lpp\', \''.base_url().'processor/plc/lpp?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_lpp">Update as Draft</button>';
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){

				$type='PD';
				if($rowData['isubmit_lpp']==0){
					$buttons['update']=$updatedraft.$update.$js;
				}
				elseif(($rowData['isubmit_lpp']<>0)&&($rowData['iapppd_lpp']==0)){
					$buttons['update']=$approve.$reject;
				}else{}
			}else{

				$type='';
			}
		}else{

			$x=$this->auth_localnon->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('PD', $team)){
					$type='PD';
					if($rowData['isubmit_lpp']==0){
						$buttons['update']=$updatedraft.$update.$js;
					}else{}
				}else{
					$type='';
				}
			}
		}
		return $buttons;
	}
   
/*manipulasi proses object form end*/    
function before_update_processor($row, $postData) {
	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;
		if($postData['isdraft']==true){
			$postData['isubmit_lpp']=0;
		} 
		else{$postData['isubmit_lpp']=1;} 
	$postData['dmulai_lpp']=date("Y-m-d", strtotime($postData['dmulai_lpp']));
	$postData['dselesai_lpp']=date("Y-m-d", strtotime($postData['dselesai_lpp']));
	unset($postData['vupb_nama']);
	unset($postData['vgenerik']);
	unset($postData['lpp_dmulai_lpp']);
	unset($postData['lpp_dselesai_lpp']);
	//print_r($postData);exit();
	return $postData;

}

/*Approval & Reject Proses */

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
								if(o.status == true) {
									$("#alert_dialog_form").dialog("close");
										$.get(base_url+"processor/plc/lpp?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
	                            			 $("div#form_lpp").html(data);
	                    				});
									
								}
									reload_grid("grid_lpp");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_lpp_approve" action="'.base_url().'processor/plc/lpp?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="ifor_id" value="'.$this->input->get('ifor_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_lpp_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function approve_process(){
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.plc2_upb_formula set vRemark_lpp='".$vRemark."',capppd_lpp='".$cNip."', dapppd_lpp='".$tApprove."', iapppd_lpp=2 where ifor_id='".$post['ifor_id']."'";
		$this->dbset->query($sql);

		$sql="select * from plc2.plc2_upb_formula where ifor_id=".$post['ifor_id'];
		$data=$this->dbset->query($sql)->row_array();
		$iupb_id=$data['iupb_id'];

		$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
                (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
                (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
                (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
                (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
                from plc2.plc2_upb u where u.iupb_id='".$iupb_id."'";
        $rupb = $this->db_plc0->query($qupb)->row_array();

		$qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id,
                (select te.iteam_id from plc2.plc2_upb_team te where te.cDeptId='PR') as iteampr_id 
                from plc2.plc2_upb u 
                where u.iupb_id='".$iupb_id."'";
        $rsql = $this->db_plc0->query($qsql)->row_array();

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
        $subject="Proses Laporan Pengembangan Produk: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval oleh PD Manager pada proses Laporan Pengembangan Produk(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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

		$data['group_id']=$post['group_id'];
		$data['modul_id']=$post['modul_id'];
		$data['status']  = true;
		$data['last_id'] = $post['ifor_id'];
		return json_encode($data);
	}

function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#vRemark").val();
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
								var url = "'.base_url().'processor/plc/lpp";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
										 $("div#form_lpp").html(data);
									});
									
								}
									reload_grid("grid_lpp");
							}
					 	 	
					 	 })
					
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_lpp_reject" action="'.base_url().'processor/plc/lpp?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="ifor_id" value="'.$this->input->get('ifor_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_lpp_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.plc2_upb_formula set vRemark_lpp='".$vRemark."',capppd_lpp='".$cNip."', dapppd_lpp='".$tApprove."', iapppd_lpp=1 where ifor_id='".$post['ifor_id']."'";
		$this->dbset->query($sql);

		$data['group_id']=$post['group_id'];
		$data['modul_id']=$post['modul_id'];
		$data['status']  = true;
		$data['last_id'] = $post['ifor_id'];
		return json_encode($data);
	}

/*function pendukung end*/    	
function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/lpp/'.$id.'/'.$name);	
		force_download($name, $path);
	}

	public function output(){
		$this->index($this->input->get('action'));
	}

}
