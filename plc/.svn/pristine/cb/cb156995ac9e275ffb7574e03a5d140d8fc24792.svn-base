<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class study_literatur_ad extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->dbset = $this->load->database('plc', true);
		 $this->load->library('lib_flow');
		 $this->load->library('lib_utilitas');
		$this->user = $this->auth_localnon->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Study Literatur AD Formulator');		
		$grid->setTable('plc2.study_literatur_ad');		
		$grid->setUrl('study_literatur_ad');
		$grid->addList('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','plc2_upb.iteampd_id','cPIC','iStatus','iappad');
		$grid->setSortBy('dupdate');
		$grid->setSortOrder('DESC');
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '120');
		$grid->setAlign('plc2_upb.vupb_nama', 'Left');
		$grid->setWidth('plc2_upb.vupb_nama', '200');
		$grid->setAlign('plc2_upb.vgenerik', 'Left');
		$grid->setWidth('plc2_upb.vgenerik', '200');
		$grid->setAlign('plc2_upb.iteampd_id', 'Left');
		$grid->setWidth('plc2_upb.iteampd_id', '100');
		$grid->addFields('iupb_id','vupb_nama','vgenerik','iteampd_id','dmulai_study','dselesai_study','cPIC','vkompedial','vfile','iappad');
		$grid->setLabel('plc2_upb.vupb_nomor', 'UPB Nomor');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setLabel('plc2_upb.iteampd_id', 'Team PD');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('iappad','Approval AD');
		$grid->setLabel('iStatus','Status');
		$grid->setWidth('iStatus', '80');
		$grid->setWidth('iappad', '120');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('iteampd_id', 'Team PD');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('cPIC', 'PIC Study Literatur');
		$grid->setLabel('dmulai_study', 'Tgl Mulai Study Literatur');
		$grid->setLabel('dselesai_study', 'Tgl Selesai Study Literatur');
		$grid->setLabel('vkompedial', 'Kompedial yang digunakan');
		$grid->setLabel('vfile', 'File Study Literatur');//Field yg mandatori
		$grid->setFormUpload(TRUE);
		$grid->setRequired('iupb_id','dmulai_study','dselesai_study','cPIC','vfile');
		
		$grid->setJoinTable('plc2.plc2_upb', 'study_literatur_ad.iupb_id = plc2.plc2_upb.iupb_id', 'inner');
		$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));
		$grid->changeFieldType('iStatus','combobox','',array(0=>'Need to Submit',1=>'Submited'));
		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','cPIC');
		$grid->setQuery('study_literatur_ad.lDeleted',0);
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

		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				$isUpload = $this->input->get('isUpload');
   				if($isUpload) {
   					$lastId=$this->input->get('lastId');
					$path = realpath("files/plc/study_literatur_ad");
					if(!file_exists($path."/".$lastId)){
						if (!mkdir($path."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
					}
					$fKeterangan = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'fileketerangan_studyad') {
							foreach($value as $k=>$v) {
								$fKeterangan[$k] = $v;
							}
						}
					}
					$i=0;
					foreach ($_FILES['fileupload_studyad']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {
							$tmp_name = $_FILES['fileupload_studyad']["tmp_name"][$key];
							$name =$_FILES['fileupload_studyad']["name"][$key];
							$data['filename'] = $name;
							//$data['id']=$idossier_dok_list_id;
							$data['dInsertDate'] = date('Y-m-d H:i:s');

								if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.study_literatur_ad_file (istudy_ad_id, vFilename, vKeterangan, dCreate, cCreate) 
											VALUES (".$lastId.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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
					$r['message']="Data Berhasil Disimpan";
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');					
					echo json_encode($r);
   				}else{
   					echo $grid->saved_form();
				}
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
				$istudyad= $post['study_literatur_ad_istudy_ad_id'];
					$path = realpath("files/plc/study_literatur_ad/");
					if(!file_exists($path."/".$istudyad)){
						if (!mkdir($path."/".$istudyad, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
					}
					$fileid='';
					foreach($_POST as $key=>$value) {

						if ($key == 'fileketerangan_studyad') {
							foreach($value as $y=>$u) {
								$fKeterangan[$y] = $u;
							}
						}
						if ($key == 'namafile_studyad') {
							foreach($value as $k=>$v) {
								$file_name[$k] = $v;
							}
						}

						if ($key == 'fileid_studyad') {
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
				//print_r($post);
				if($isUpload) {
					
					if (isset($_FILES['fileupload_studyad']))  {
						$i=0;
						foreach ($_FILES['fileupload_studyad']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_studyad']["tmp_name"][$key];
								$name =$_FILES['fileupload_studyad']["name"][$key];
								$data['filename_studyad'] = $name;
								$data['dInsertDate_studyad'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$istudyad."/".$name)) {
									$sql[]="INSERT INTO plc2.study_literatur_ad_file (istudy_ad_id, vFilename, vKeterangan, dCreate, cCreate) 
											VALUES (".$istudyad.",'".$data['filename_studyad']."','".$fKeterangan[$i]."','".$data['dInsertDate_studyad']."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sql as $sq) {
							try {
								$this->dbset->query($sq);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}

					$r['status'] = TRUE;
					$r['last_id'] = $istudyad;	
					$r['message'] = 'Data Berhasil Disimpan';			
					echo json_encode($r);
					exit();
				}else{
					$istudyad= $post['study_literatur_ad_istudy_ad_id'];
					$fileid='';
					foreach($_POST as $key=>$value) {
						if ($key == 'fileid_studyad') {
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
					$sql1="update plc2.study_literatur_ad_file set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where istudy_ad_id='".$istudyad."' and istudy_ad_file_id not in (".$fileid.")";
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
				where em.vName like "%'.$term.'%" and te.vtipe in ("AD","PD") AND it.ldeleted=0 order by em.vname ASC';
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
function listBox_study_literatur_ad_iappad($value) {
	if($value==0){$vstatus='Waiting for approval';}
	elseif($value==1){$vstatus='Rejected';}
	elseif($value==2){$vstatus='Approved';}
	return $vstatus;
}
function listBox_study_literatur_ad_cPIC($value) {
	$data='-';
	$sql='select em.cNip as cNip, em.vName as vName from hrd.employee em where em.cNip="'.$value.'" LIMIT 1';
	$dt=$this->db_plc0->query($sql)->row_array();
	if($dt){
		$data=$dt['cNip'].' - '.$dt['vName'];
	}
	return $data;
}
function listBox_Action($row, $actions) {
    if($row->iStatus<>0){
    	unset($actions['delete']);
    }
    if($row->iappad<>0){
    	unset($actions['edit']);
    }
    return $actions; 

	}
/*manipulasi view object form start*/
 	

	function insertBox_study_literatur_ad_iupb_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/study/literatur/ad/popup?field=study_literatur_ad&modul_id='.$this->input->get('modul_id').'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	function insertBox_study_literatur_ad_vupb_nama($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" />';
	}
	function insertBox_study_literatur_ad_vgenerik($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" />';
	}
	function insertBox_study_literatur_ad_iteampd_id($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" />';
		/*$my_teams=$this->auth_localnon->my_teams();
		$sql="select * from plc2.plc2_upb_team te where te.ldeleted=0 and te.vtipe='AD' and te.iteam_id in(".$my_teams.")";
		$teams = $this->db_plc0->query($sql)->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;*/
	}
	function insertBox_study_literatur_ad_dmulai_study($field, $id){
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px"/>';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
					</script>';
		return $return;
	}
	function insertBox_study_literatur_ad_dselesai_study($field, $id){
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px"/>';
		$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
						
					</script>';
		return $return;
	}
	function insertBox_study_literatur_ad_cPIC($field,$id){
		$url = base_url().'processor/plc/study/literatur/ad?action=getemployee';
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
		      </script>
		<input name="'.$id.'" id="'.$id.'" type="hidden" class="required"/>
		<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20"/>';
		return $return;
	}

	function insertBox_study_literatur_ad_vkompedial($field, $id){
		return '<textarea id='.$id.' name='.$id.' colspan="2"></textarea>';
	}

    function insertBox_study_literatur_ad_vfile($field, $id) {
    	$data['date'] = date('Y-m-d H:i:s');
		$return = $this->load->view('study_literatur_ad_file',$data,TRUE);
		return $return;
	}
	function insertBox_study_literatur_ad_iappad($field, $id) {
    	return '-';
	}

	function updateBox_study_literatur_ad_iupb_id($field, $id, $value, $rowData){
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
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value='.$value.' />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" value="'.$dt['vupb_nomor'].'" size="20" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/study/literatur/ad/popup?field=study_literatur_ad&modul_id='.$this->input->get('modul_id').'\',\'List UPB\')" type="button">&nbsp;</button>';
		}
		return $return;
	}

	function updateBox_study_literatur_ad_vupb_nama($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nama'];
		}else{
			$return='<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="20" value="'.$dt['vupb_nama'].'" />';
		}
		return $return;
	}
	function updateBox_study_literatur_ad_vgenerik($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vgenerik'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="20" value="'.$dt['vgenerik'].'" />';
		}
		return $return;
	}

	function updateBox_study_literatur_ad_iteampd_id($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb up 
		inner join plc2.plc2_upb_team te on up.iteampd_id=te.iteam_id
		where up.iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vteam'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="20" value="'.$dt['vteam'].'" />';
		}
		return $return;
		/*$sql="select * from plc2.plc2_upb_team te where te.ldeleted=0 and te.vtipe='AD' and te.iteam_id=".$value."";
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$o=$dt['vteam'];
		}else{
		$my_teams=$this->auth_localnon->my_teams();
		$sql="select * from plc2.plc2_upb_team te where te.ldeleted=0 and te.vtipe='AD' and te.iteam_id in(".$my_teams.")";
		$teams = $this->db_plc0->query($sql)->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$select=$t['iteam_id']==$value ? 'selected' : '';
    		$o .= '<option value="'.$t['iteam_id'].'" '.$select.'>'.$t['vteam'].'</option>';
    	}
    	$o .= '</select>';
    	}
    	return $o;*/
	}
	function updateBox_study_literatur_ad_dmulai_study($field, $id, $value, $rowData) {
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker" style="width:130px" value='.$value.' />';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
					</script>';
		}
		return $return;
	}
	function updateBox_study_literatur_ad_dselesai_study($field, $id, $value, $rowData) {
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker" style="width:130px" value='.$value.' />';
		$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
						
					</script>';
		}
		return $return;
	}
	function updateBox_study_literatur_ad_cPIC($field, $id, $value, $rowData) {
		$sql="select * from hrd.employee em where em.cNip='".$value."'";
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return	=$dt['vName'];
		}else{
		$url = base_url().'processor/plc/study/literatur/ad?action=getemployee';
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
		      </script>
		<input name="'.$id.'" id="'.$id.'" type="hidden" value="'.$value.'" class="required"/>
		<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20" value="'.$dt['vName'].'"/>';
		}
		return $return;
	}

	function updateBox_study_literatur_ad_vkompedial($field, $id, $value, $rowData) {
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
			$return ='<textarea id='.$id.' name='.$id.' colspan="2">'.$value.'</textarea>';
		}
		return $return;
	}

    function updateBox_study_literatur_ad_vfile($field, $id, $value, $rowData) {
    	 	
		$qr="select * from plc2.study_literatur_ad_file where istudy_ad_id='".$rowData['istudy_ad_id']."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');
		$row=$this->db_plc0->query($qr)->num_rows();		
		$return = $this->load->view('study_literatur_ad_file',$data,TRUE);
		$return .= '<script>
		$(".fileupload").change(function () {
        var fileExtension = ["jpeg", "jpg", "png", "gif", "bmp"];
        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
            alert("Only formats are allowed : "+fileExtension.join(", "));
        }
    	});
		</script>';
		return $return;
	}
	function updateBox_study_literatur_ad_iappad($field, $id, $value, $rowData) {
    	if($rowData['cappad'] != null){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cappad']))->row_array();
			if($rowData['iappad']==2){$st="Approved";}elseif($rowData['iappad']==1){$st="Rejected";} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['cappad'].' )'.' pada '.$rowData['dappad'];
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
/*manipulasi view object form end*/

/*manipulasi proses object form start*/
    function manipulate_insert_button($buttons) {
		unset($buttons['save']);
		//$js=$this->load->view('misc_util',array('className'=> 'study_literatur_ad'), true);
		$js = $this->load->view('study_literatur_ad_js');
		$js .= $this->load->view('uploadjs');
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('AD', $manager)){$type='AD';
				$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'study_literatur_ad\', \''.base_url().'processor/plc/study/literatur/ad?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_study_literatur_ad">Save as Draft</button>';
				$save = '<button onclick="javascript:save_btn_multiupload(\'study_literatur_ad\', \''.base_url().'processor/plc/study/literatur/ad?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_study_literatur_ad">Save &amp; Submit</button>';
				$buttons['save'] = $save_draft.$save.$js;
			}elseif(in_array('PD', $manager)){$type='PD';
				$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'study_literatur_ad\', \''.base_url().'processor/plc/study/literatur/ad?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_study_literatur_ad">Save as Draft</button>';
				$save = '<button onclick="javascript:save_btn_multiupload(\'study_literatur_ad\', \''.base_url().'processor/plc/study/literatur/ad?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_study_literatur_ad">Save &amp; Submit</button>';
				
				$buttons['save'] = $save_draft.$save.$js;
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('AD', $team)){$type='AD';
				$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'study_literatur_ad\', \''.base_url().'processor/plc/study/literatur/ad?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_study_literatur_ad">Save as Draft</button>';
				$save = '<button onclick="javascript:save_btn_multiupload(\'study_literatur_ad\', \''.base_url().'processor/plc/study/literatur/ad?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_study_literatur_ad">Save &amp; Submit</button>';
				$buttons['save'] = $save_draft.$save.$js;
			}elseif(in_array('PD', $team)){$type='PD';
				$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'study_literatur_ad\', \''.base_url().'processor/plc/study/literatur/ad?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_study_literatur_ad">Save as Draft</button>';
				$save = '<button onclick="javascript:save_btn_multiupload(\'study_literatur_ad\', \''.base_url().'processor/plc/study/literatur/ad?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_study_literatur_ad">Save &amp; Submit</button>';
				$buttons['save'] = $save_draft.$save.$js;
			}
			else{$type='';}
		}
		return $buttons;
	}
	function manipulate_update_button($buttons, $rowData){
		//print_r($rowData);exit();
		unset($buttons['update']);
		//$js=$this->load->view('misc_util',array('className'=> 'study_literatur_ad'), true);
		$js = $this->load->view('study_literatur_ad_js');
		$js .= $this->load->view('uploadjs');
		$cNip=$this->user->gNIP;

		$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/study/literatur/ad?action=approve&istudy_ad_id='.$rowData['istudy_ad_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_study_literatur_ad">Approve</button>';
		$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/study/literatur/ad?action=reject&istudy_ad_id='.$rowData['istudy_ad_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_study_literatur_ad">Reject</button>';

		$update = '<button onclick="javascript:update_btn_back(\'study_literatur_ad\', \''.base_url().'processor/plc/study/literatur/ad?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_study_literatur_ad">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'study_literatur_ad\', \''.base_url().'processor/plc/study/literatur/ad?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_study_literatur_ad">Update as Draft</button>';
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('AD', $manager)){
				$type='AD';
				if($rowData['iStatus']==0){
					$buttons['update']=$updatedraft.$update.$js;
				}
				elseif(($rowData['iStatus']<>0)&&($rowData['iappad']==0)){
					$buttons['update']=$update.$approve.$reject.$js;
				}else{}
			}elseif(in_array('PD', $manager)){
				$type='PD';
				if($rowData['iStatus']==0){
					$buttons['update']=$updatedraft.$update.$js;
				}
				elseif(($rowData['iStatus']<>0)&&($rowData['iappad']==0)){
					$buttons['update']=$update.$approve.$reject.$js;
				}else{}
			}else{

				$type='';
			}
		}else{

			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('AD', $team)){
				$type='AD';
				if($rowData['iStatus']==0){
					$buttons['update']=$updatedraft.$update.$js;
				}else{}
			}elseif(in_array('PD', $team)){
				$type='PD';
				if($rowData['iStatus']==0){
					$buttons['update']=$updatedraft.$update.$js;
				}else{}
			}else{
				$type='';
			}
		}
		return $buttons;
	}
   
/*manipulasi proses object form end*/    
function before_insert_processor($row, $postData) {
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreate'] =$this->user->gNIP;
		if($postData['isdraft']==true){
			$postData['iStatus']=0;
		} 
		else{$postData['iStatus']=1;} 
	//print_r($postData);exit();
	return $postData;

}
function before_update_processor($row, $postData) {
	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;
		if($postData['isdraft']==true){
			$postData['iStatus']=0;
		} 
		else{$postData['iStatus']=1;} 
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
										$.get(base_url+"processor/plc/study/literatur/ad?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
	                            			 $("div#form_study_literatur_ad").html(data);
	                    				});
									
								}
									reload_grid("grid_study_literatur_ad");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_study_literatur_ad_approve" action="'.base_url().'processor/plc/study/literatur/ad?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="istudy_ad_id" value="'.$this->input->get('istudy_ad_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_study_literatur_ad_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function approve_process(){
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.study_literatur_ad set vRemark='".$vRemark."',cappad='".$cNip."', dappad='".$tApprove."', iappad=2 where istudy_ad_id='".$post['istudy_ad_id']."'";
		$this->dbset->query($sql);

		$sql="select iupb_id from plc2.study_literatur_ad where istudy_ad_id='".$post['istudy_ad_id']."' and lDeleted=0 LIMIT 1";
		$dt=$this->dbset->query($sql)->row_array();
		$iupb_id=$dt['iupb_id'];
		//$this->lib_flow->insert_logs($post['modul_id'],$iupb_id,15,2);

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
        $subject="Proses Study Literatur AD: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval oleh AD Manager pada proses Study Literatur AD(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
		$data['last_id'] = $post['istudy_ad_id'];
		return json_encode($data);
	}

function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_study_literatur_ad_vRemark").val();
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
								var url = "'.base_url().'processor/plc/study/literatur/ad";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
										 $("div#form_study_literatur_ad").html(data);
									});
									
								}
									reload_grid("grid_study_literatur_ad");
							}
					 	 	
					 	 })
					
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_study_literatur_ad_reject" action="'.base_url().'processor/plc/study/literatur/ad?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="istudy_ad_id" value="'.$this->input->get('istudy_ad_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_study_literatur_ad_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.study_literatur_ad set vRemark='".$vRemark."',cappad='".$cNip."', dappad='".$tApprove."', iappad=1 where istudy_ad_id='".$post['istudy_ad_id']."'";
		$this->dbset->query($sql);
		$data['group_id']=$post['group_id'];
		$data['modul_id']=$post['modul_id'];
		$data['status']  = true;
		$data['last_id'] = $post['istudy_ad_id'];
		return json_encode($data);
	}

	function after_insert_processor($row, $insertId, $postData){
		$iupb_id=$postData['iupb_id'];
		//$this->lib_flow->insert_logs($this->input->get('modul_id'),$iupb_id,1);
	}

/*function pendukung end*/    	
function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/study_literatur_ad/'.$id.'/'.$name);	
		force_download($name, $path);
	}

	public function output(){
		$this->index($this->input->get('action'));
	}

}
