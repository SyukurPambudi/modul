<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class study_literatur_mikro extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('plc', true);
		 $this->load->library('lib_flow');
		 $this->load->library('lib_utilitas');
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;

		$grid->setTitle('Study Literatur Mikro BB & FG');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('study_literatur_mikro');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik','study_literatur_mikro.vnama_literatur','study_literatur_mikro.isubmit','study_literatur_mikro.iappqa');
		$grid->setSortBy('dupdate');
		$grid->setSortOrder('DESC');
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setWidth('vupb_nomor', '120');
		$grid->setAlign('vupb_nama', 'Left');
		$grid->setWidth('vupb_nama', '200');
		$grid->setAlign('study_literatur_mikro.vnama_literatur', 'Left');
		$grid->setWidth('study_literatur_mikro.vnama_literatur', '200');
		$grid->setAlign('study_literatur_mikro.isubmit', 'Left');
		$grid->setWidth('study_literatur_mikro.isubmit', '150');
		$grid->setAlign('study_literatur_mikro.iappqa', 'Left');
		$grid->setWidth('study_literatur_mikro.iappqa', '150');
		$grid->addFields('iupb_id','vupb_nama','vgenerik','vnama_literatur','dmulai_study','dselesai_study','vPICqa','vfile','iappqa');
		$grid->setLabel('vupb_nomor', 'UPB Nomor');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('dmulai_study', 'Tgl Mulai Pembuatan');
		$grid->setLabel('dselesai_study', 'Tgl Selesai Pembuatan');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('vnama_literatur', 'Nama Literatur');
		$grid->setLabel('vPICqa', 'PIC QA');
		$grid->setLabel('vfile', 'File Name Upload');
		$grid->setLabel('iappqa', 'Approval QA');
		$grid->setLabel('study_literatur_mikro.isubmit', 'Status Submit');
		$grid->setLabel('study_literatur_mikro.iappqa', 'Approval QA');
		$grid->setLabel('study_literatur_mikro.vnama_literatur', 'Nama Literatur');
		$grid->setRequired('iupb_id','vnama_literatur','dmulai_study','dselesai_study','vPICqa','vfile');	

		$grid->setJoinTable('plc2.study_literatur_mikro', 'study_literatur_mikro.iupb_id = plc2.plc2_upb.iupb_id', 'left');
		$grid->setRelation('plc2.plc2_upb.iteamqa_id','plc2.plc2_upb_team','iteam_id','vteam','team_qa','inner',array('vtipe'=>'QA', 'ldeleted'=>0),array('vteam'=>'asc'));

		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('QA', $team)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}

		$grid->setQuery('plc2_upb.iupb_id in (select ad.iupb_id from plc2.study_literatur_ad ad where ad.lDeleted=0 and ad.iappad=2 and ad.iStatus=1)',Null);
		$grid->setQuery('plc2_upb.iupb_id in (select pd.iupb_id from plc2.study_literatur_pd pd where pd.lDeleted=0 and pd.iapppd=2 and pd.iStatus=1)',Null);
		$grid->setQuery('plc2_upb.ihold',0);

		$grid->setFormUpload(TRUE);
		
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
				$this->db_plc0->where('iupb_id', $post['study_literatur_mikro_iupb_id']);		
				$j2 = $this->db_plc0->count_all_results('plc2.study_literatur_mikro');
				if($j2>0){
					$sql="select * from plc2.study_literatur_mikro where iupb_id=".$post['study_literatur_mikro_iupb_id']." order by istudy_mikro_id DESC limit 1";
					$dt=$this->dbset->query($sql)->row_array();
					$istudy_mikro_id=$dt['istudy_mikro_id'];
					$path = realpath("files/plc/study_literatur_mikro/");
					if(!file_exists($path."/".$istudy_mikro_id)){
						if (!mkdir($path."/".$istudy_mikro_id, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
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

					$j2 = $this->db_plc0->count_all_results('plc2.study_literatur_mikro');
					if($j2>0){
						$sql="select * from plc2.study_literatur_mikro where iupb_id=".$this->input->get('lastId')." order by istudy_mikro_id DESC limit 1";
						$dt=$this->dbset->query($sql)->row_array();
						$istudy_mikro_id=$dt['istudy_mikro_id'];
					}else{
						$istudy_mikro_id=0;
					}
					$sql=array();
					$i=0;

					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.study_literatur_mikro_file set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where istudy_mikro_id='".$istudy_mikro_id."' and istudy_mikro_file_id not in (".$fileid.")";
					$this->dbset->query($sql1);

					if (isset($_FILES['fileupload']))  {
						foreach ($_FILES['fileupload']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
								$name =$_FILES['fileupload']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$istudy_mikro_id."/".$name)) {
									$sql[]="INSERT INTO plc2.study_literatur_mikro_file (istudy_mikro_id, vFilename, vKeterangan, dCreate, cCreate) 
											VALUES ('".$istudy_mikro_id."','".$name."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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
					
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');				
					echo json_encode($r);
					exit();
				}  else {
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
				where em.vName like "%'.$term.'%" and te.vtipe="QA" AND it.ldeleted=0 order by em.vname ASC';
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
function listBox_study_literatur_mikro_study_literatur_mikro_iappqa($value) {
	if($value==0){$vstatus='Waiting for approval';}
	elseif($value==1){$vstatus='Rejected';}
	elseif($value==2){$vstatus='Approved';}
	return $vstatus;
}
function listBox_study_literatur_mikro_study_literatur_mikro_isubmit($value){
	if($value==0){$vstatus='Draft - Need to Submit';}
	elseif($value==1){$vstatus='Submited';}
	else{$vstatus='Draft - Need to Submit';}
	return $vstatus;
}
function listBox_study_literatur_mikro_study_literatur_mikro_vPICqa($value) {
	$data='-';
	$sql='select em.cNip as cNip, em.vName as vName from hrd.employee em where em.cNip="'.$value.'" LIMIT 1';
	$dt=$this->db_plc0->query($sql)->row_array();
	if($dt){
		$data=$dt['cNip'].' - '.$dt['vName'];
	}
	return $data;
}
function listBox_Action($row, $actions) {
    if($row->study_literatur_mikro__isubmit<>0){
    	unset($actions['delete']);
    }
    if($row->study_literatur_mikro__iappqa<>0){
    	unset($actions['edit']);
    }
    return $actions; 

	}
/*manipulasi view object form start*/
 	function updateBox_study_literatur_mikro_iupb_id($field, $id, $value, $rowData){
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

	function updateBox_study_literatur_mikro_vupb_nama($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nama'];
		}else{
			$return='<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vupb_nama'].'" />';
		}
		return $return;
	}
	function updateBox_study_literatur_mikro_vgenerik($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vgenerik'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vgenerik'].'" />';
		}
		return $return;
	}
	function updateBox_study_literatur_mikro_vnama_literatur($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.study_literatur_mikro');
		if($j2> 0){
			$sql="select * from plc2.study_literatur_mikro where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['vnama_literatur'];
			if($this->input->get('action')=='view'){
			$return	=$value;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="required" style="width:130px" value="'.$value.'" />';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="required" style="width:130px" />';
			}
		}

		return $return;
	}
	function updateBox_study_literatur_mikro_dmulai_study($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.study_literatur_mikro');
		if($j2> 0){
			$sql="select * from plc2.study_literatur_mikro where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=date('d-m-Y',strtotime($dt['dmulai_study']));
			if($this->input->get('action')=='view'){
			$return	=$value;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker" style="width:130px" value="'.$value.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker" style="width:130px" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}

		return $return;
	}
	function updateBox_study_literatur_mikro_dselesai_study($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.study_literatur_mikro');
		if($j2> 0){
			$sql="select * from plc2.study_literatur_mikro where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=date('d-m-Y',strtotime($dt['dselesai_study']));
			if($this->input->get('action')=='view'){
				$return	=$value;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker" style="width:130px" value='.$value.' />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker" style="width:130px" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}
		return $return;
	}
	function updateBox_study_literatur_mikro_vPICqa($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.study_literatur_mikro');
		$url = base_url().'processor/plc/study/literatur/mikro?action=getemployee';
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

		if($j2> 0){
			$sql="select * from plc2.study_literatur_mikro where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['vPICqa'];
			$sql="select * from hrd.employee em where em.cNip='".$value."'";
			$dt=$this->db_plc0->query($sql)->row_array();
			if($this->input->get('action')=='view'){
				$return	=$dt['vName'];
			}else{
				$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" value="'.$value.'"/>
				<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20" value="'.$dt['vName'].'"/>';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" />
				<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20"/>';
			}
		}
		
		return $return;
	}

    function updateBox_study_literatur_mikro_vfile($field, $id, $value, $rowData) {
    	$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.study_literatur_mikro');
		if($j2> 0){
			$sql="select * from plc2.study_literatur_mikro where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['istudy_mikro_id'];
		}else{$value='0';} 	
		$qr="select * from plc2.study_literatur_mikro_file where istudy_mikro_id='".$value."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('study_literatur_mikro_file',$data,TRUE);
	}
	function updateBox_study_literatur_mikro_iappqa($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.study_literatur_mikro');
		if($j2> 0){
			$sql="select * from plc2.study_literatur_mikro where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			if($dt['iappqa'] != 0){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$dt['cappqa']))->row_array();
			if($dt['iappqa']==2){$st="Approved";}elseif($dt['iappqa']==1){$st="Rejected";} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$dt['cappqa'].' )'.' pada '.$dt['dappqa'];
		}
		else{
			$ret='Waiting for Approval';
		}
		}else{$ret='';}
		return $ret;
	}
/*manipulasi view object form end*/

/*manipulasi proses object form start*/
	function manipulate_update_button($buttons, $rowData){
		//print_r($rowData);exit();

		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.study_literatur_mikro');
		$istudy_mikro_id=0;
		if($j2> 0){
			$sql="select * from plc2.study_literatur_mikro where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$istudy_mikro_id=$dt['istudy_mikro_id'];
		}

		unset($buttons['update']);
		$js=$this->load->view('study_literatur_mikro_js');
		$cNip=$this->user->gNIP;

		$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/study/literatur/mikro?action=approve&iupb_id='.$rowData['iupb_id'].'&istudy_mikro_id='.$istudy_mikro_id.'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_study_literatur_mikro">Approve</button>';
		$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/study/literatur/mikro?action=reject&iupb_id='.$rowData['iupb_id'].'&istudy_mikro_id='.$istudy_mikro_id.'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_study_literatur_mikro">Reject</button>';

		$update = '<button onclick="javascript:update_btn_back(\'study_literatur_mikro\', \''.base_url().'processor/plc/study/literatur/mikro?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_study_literatur_mikro">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'study_literatur_mikro\', \''.base_url().'processor/plc/study/literatur/mikro?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_study_literatur_mikro">Update as Draft</button>';
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){
				if($j2> 0){
					$sql="select * from plc2.study_literatur_mikro where iupb_id=".$rowData['iupb_id']." LIMIT 1";
					$dt=$this->db_plc0->query($sql)->row_array();
					if($dt['isubmit']==0){
						$buttons['update']=$updatedraft.$update.$js;
					}
					elseif(($dt['isubmit']<>0)&&($dt['iappqa']==0)){
						$buttons['update']=$approve.$reject.$js;
					}else{}
				}else{
					$buttons['update']=$updatedraft.$update.$js;
				}
				$type='QA';
			}else{

				$type='';
			}
		}else{

			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('QA', $team)){
				$type='QA';
				if($j2> 0){
					$sql="select * from plc2.study_literatur_mikro where iupb_id=".$rowData['iupb_id']." LIMIT 1";
					$dt=$this->db_plc0->query($sql)->row_array();
					if($dt['isubmit']==0){
						$buttons['update']=$updatedraft.$update.$js;
					}else{}
				}else{
					$buttons['update']=$updatedraft.$update.$js;
				}
			}else{
				$type='';
			}
		}
		return $buttons;
	}
   
/*manipulasi proses object form end*/    
function before_update_processor($row, $postData) {
	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;
		if($postData['isdraft']==true){
			$postData['isubmit_txt']=0;$isubmit=0;
		} 
		else{$postData['isubmit_txt']=1;$isubmit=1;} 
	$postData['dmulai_study']=date("Y-m-d", strtotime($postData['dmulai_study']));
	$postData['dselesai_study']=date("Y-m-d", strtotime($postData['dselesai_study']));
	unset($postData['vupb_nama']);
	unset($postData['vgenerik']);
	unset($postData['study_literatur_mikro_dmulai_study']);
	unset($postData['study_literatur_mikro_dselesai_study']);
	$this->db_plc0->where('iupb_id', $postData['iupb_id']);		
	$j2 = $this->db_plc0->count_all_results('plc2.study_literatur_mikro');
		$data['iupb_id']=$postData['iupb_id'];
		$data['vnama_literatur']=$postData['vnama_literatur'];
		$data['dmulai_study']=$postData['dmulai_study'];
		$data['dselesai_study']=$postData['dselesai_study'];
		$data['vPICqa']=$postData['vPICqa'];
		$data['isubmit']=$postData['isubmit_txt'];
		$data['dupdate']=$postData['dupdate'];
		$data['cUpdate']=$postData['cUpdate'];
		$data['dCreate']=$postData['dupdate'];
		$data['cCreate']=$postData['cUpdate'];
	if($j2==0){
		$this->db_plc0->insert('plc2.study_literatur_mikro', $data);
		$sql="select * from plc2.study_literatur_mikro where iupb_id=".$data['iupb_id']." order by istudy_mikro_id DESC limit 1";
		$dt=$this->dbset->query($sql)->row_array();
		$postData['istudy_mikro_id']=$dt['istudy_mikro_id'];
	}else{
		$sql="select * from plc2.study_literatur_mikro where iupb_id=".$postData['iupb_id']." order by istudy_mikro_id DESC limit 1";
		$dt=$this->dbset->query($sql)->row_array();
		$postData['istudy_mikro_id']=$dt['istudy_mikro_id'];

		$sql="UPDATE plc2.study_literatur_mikro SET iupb_id=".$data['iupb_id'].", vnama_literatur='".$data['vnama_literatur']."', dmulai_study='".$data['dmulai_study']."', 
			dselesai_study='".$data['dselesai_study']."', vPICqa='".$data['vPICqa']."', isubmit=".$data['isubmit'].", 
			dupdate='".$data['dupdate']."', cUpdate='".$data['cUpdate']."' WHERE istudy_mikro_id=".$postData['istudy_mikro_id'];
		$this->db_plc0->query($sql);
	}
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
										$.get(base_url+"processor/plc/study/literatur/mikro?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
	                            			 $("div#form_study_literatur_mikro").html(data);
	                    				});
									
								}
									reload_grid("grid_study_literatur_mikro");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_study_literatur_mikro_approve" action="'.base_url().'processor/plc/study/literatur/mikro?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="istudy_mikro_id" value="'.$this->input->get('istudy_mikro_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_study_literatur_mikro_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function approve_process(){
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.study_literatur_mikro set vRemark='".$vRemark."',cappqa='".$cNip."', dappqa='".$tApprove."', iappqa=2 where istudy_mikro_id='".$post['istudy_mikro_id']."'";
		$this->dbset->query($sql);

		$sql="select iupb_id from plc2.study_literatur_mikro where istudy_mikro_id='".$post['istudy_mikro_id']."' and lDeleted=0 LIMIT 1";
		$dt=$this->dbset->query($sql)->row_array();
		$iupb_id=$dt['iupb_id'];
		$this->lib_flow->insert_logs($post['modul_id'],$iupb_id,11,2);

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
        $subject="Proses Study Literatur Mikro: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval oleh QA Manager pada proses Study Literatur Mikro(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
		$data['last_id'] = $iupb_id;
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
								var url = "'.base_url().'processor/plc/study/literatur/mikro";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
										 $("div#form_study_literatur_mikro").html(data);
									});
									
								}
									reload_grid("grid_study_literatur_mikro");
							}
					 	 	
					 	 })
					
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_study_literatur_mikro_reject" action="'.base_url().'processor/plc/study/literatur/mikro?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="istudy_mikro_id" value="'.$this->input->get('istudy_mikro_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_study_literatur_mikro_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.study_literatur_mikro set vRemark='".$vRemark."',cappqa='".$cNip."', dappqa='".$tApprove."', iappqa=1 where istudy_mikro_id='".$post['istudy_mikro_id']."'";
		$this->dbset->query($sql);

		$sql="select iupb_id from plc2.study_literatur_mikro where istudy_mikro_id='".$post['istudy_mikro_id']."' and lDeleted=0 LIMIT 1";
		$dt=$this->dbset->query($sql)->row_array();
		$iupb_id=$dt['iupb_id'];

		$data['group_id']=$post['group_id'];
		$data['modul_id']=$post['modul_id'];
		$data['status']  = true;
		$data['last_id'] = $iupb_id;
		return json_encode($data);
	}
	function after_update_processor($row, $insertId, $postData){
		//cek log
		$iupb_id=$postData['iupb_id'];
		/*$sql="select up.* from plc2.upb_proses_logs up 
			inner join plc2.master_proses_action ac on ac.master_proses_action_id=up.master_proses_action_id
			inner join plc2.master_proses ma on ac.master_proses_id=ma.master_proses_id
			where ma.idprivi_modules='".$this->input->get('modul_id')."' and ac.master_action_id=1 and up.iupb_id='".$iupb_id."'";
		$jrow=$this->dbset->query($sql)->num_rows();
		if($jrow==0){*/
			if($postData['isubmit_txt']==1){
				$this->lib_flow->insert_logs($this->input->get('modul_id'),$iupb_id,8);
			}
		//}
	}

/*function pendukung end*/    	
function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/study_literatur_mikro/'.$id.'/'.$name);	
		force_download($name, $path);
	}

	public function output(){
		$this->index($this->input->get('action'));
	}

}
