<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class local_study_literatur_pd extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth_local');
		$this->dbset = $this->load->database('formulasi', false, true);
		 $this->load->library('lib_utilitas');
		$this->user = $this->auth_local->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Study Literatur PD Refor Lokal');		
		$grid->setTable('reformulasi.lokal_refor_study_literatur_pd');		
		$grid->setUrl('local_study_literatur_pd');
		//$grid->addList('itemas.c_itnam','local_req_refor.vBatch_no','local_req_refor.cInisiator','isubmit');
		$grid->addList('itemas.c_itnam','local_req_refor.cInisiator','isubmit');
		$grid->setSortBy('dupdate');
		$grid->setSortOrder('DESC');
		//$grid->addFields('vNo_req_refor','cIteno','vBatch_no','cInisiator','idept_id','vAlasan_refor','details','iteam_pd','dRequest','cApproval','cFormulator','lbl','dmulai','dselesai','vupload','iapppd');
		$grid->addFields('vNo_req_refor','cIteno','cInisiator','idept_id','vAlasan_refor','details','iteam_pd','dRequest','cApproval','cFormulator','lbl','dmulai','dselesai','vupload','iapppd');
		$grid->setLabel('itemas.c_itnam', 'Nama Usulan');
		$grid->setLabel('cIteno', 'Nama Usulan');
		$grid->setLabel('local_req_refor.vBatch_no', 'No Batch');
		$grid->setLabel('vBatch_no', 'No Batch');
		$grid->setLabel('isubmit', 'Status');
		$grid->setLabel('cInisiator', 'Inisiator');
		$grid->setLabel('idept_id', 'Departement');
		$grid->setLabel('vAlasan_refor', 'Alasan Refor');
		$grid->setLabel('details', 'Upload File');
		$grid->setLabel('iapppd', 'Approval PD');
		$grid->setLabel('dmulai', 'Tanggal Mulai Study Literatur');
		$grid->setLabel('dselesai', 'Tanggal Selesai Study Literatur');
		$grid->setLabel('lbl', '&nbsp&nbsp');
		$grid->setLabel('local_req_refor.cInisiator', 'Requetor');
		$grid->setLabel('vNo_req_refor', 'No Request');
		$grid->setLabel('iteam_pd', 'Team PD');
		$grid->setLabel('dRequest', 'Tgl Permintaan Refor Lokal');
		$grid->setLabel('cApproval', 'Approval Atasan Inisiator');
		$grid->setLabel('cFormulator', 'PIC Formulator Refor');
		$grid->setLabel('vupload', 'File Upload Study Literatur');
		$grid->setRequired('vNo_req_refor','dmulai','dselesai');
		$grid->setJoinTable('reformulasi.local_req_refor', 'local_req_refor.iLocal_req_refor = reformulasi.lokal_refor_study_literatur_pd.iLocal_req_refor', 'inner');
		$grid->setJoinTable('sales.itemas', 'itemas.c_iteno = reformulasi.local_req_refor.cIteno', 'inner');
		$grid->setFormUpload(TRUE);

		/*Set Query*/
		if($this->auth_local->is_manager()){
            $x=$this->auth_local->dept();
            $manager=$x['manager'];
            if(in_array('PD', $manager)){
                $type='PD';
                $grid->setQuery('local_req_refor.iteam_pd IN ('.$this->auth_local->my_teams().')', null); 
            }
            else{$type='';}
        }
        else{
            $x=$this->auth_local->dept();
            $team=$x['team'];
            if(in_array('PD', $team)){
                $type='PD';
                $grid->setQuery('local_req_refor.iteam_pd IN ('.$this->auth_local->my_teams().')', null); 
                $grid->setQuery('local_req_refor.cFormulator in ("'.$this->user->gNIP.'")',NULL);
            }
            else{$type='';}
        }
        $grid->setQuery('lokal_refor_study_literatur_pd.ldeleted',0);

		$grid->setSearch('itemas.c_itnam','local_req_refor.vBatch_no','local_req_refor.cInisiator');
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
					$path = realpath("files/reformulasi/local/local_study_literatur_pd");
					if(!file_exists($path."/".$lastId)){
						if (!mkdir($path."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
					}
					$fKeterangan = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'file_keterangan_local_study') {
							foreach($value as $k=>$v) {
								$fKeterangan[$k] = $v;
							}
						}
					}
					$i=0;
					if (isset($_FILES['fileupload_local_study_pd']))  {
						foreach ($_FILES['fileupload_local_study_pd']["error"] as $key => $error) {
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_local_study_pd']["tmp_name"][$key];
								$name =$_FILES['fileupload_local_study_pd']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');

									if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
										$sql[]="INSERT INTO reformulasi.file_lokal_refor_study_literatur_pd (istudy_id, vFilename, vKeterangan, dcreate, ccreate) 
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
				$istudy=$post['local_study_literatur_pd_istudy_id'];
				$path = realpath("files/reformulasi/local/local_study_literatur_pd");
				if(!file_exists($path."/".$istudy)){
					if (!mkdir($path."/".$istudy, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
				$fKeterangan = array();	
				$fileid='';
				foreach($_POST as $key=>$value) {
										
					if ($key == 'file_keterangan_local_study') {
						foreach($value as $y=>$u) {
							$fKeterangan[$y] = $u;
						}
					}
					if ($key == 'istudy_file_id') {
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
   				if($isUpload) {	
   					if($fileid!=''){
						$tgl= date('Y-m-d H:i:s');
						$sql1="update reformulasi.file_lokal_refor_study_literatur_pd set ldeleted=1, dupdate='".$tgl."', cupdate='".$this->user->gNIP."' where istudy_id='".$istudy."' and istudy_file_id not in (".$fileid.")";
						$this->dbset->query($sql1);
					}else{
						$tgl= date('Y-m-d H:i:s');
						$sql1="update reformulasi.file_lokal_refor_study_literatur_pd set ldeleted=1, dupdate='".$tgl."', cupdate='".$this->user->gNIP."' where istudy_id='".$istudy."'";
						$this->dbset->query($sql1);
					}
					$i=0;
					if (isset($_FILES['fileupload_local_study_pd']))  {
						foreach ($_FILES['fileupload_local_study_pd']["error"] as $key => $error) {
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_local_study_pd']["tmp_name"][$key];
								$name =$_FILES['fileupload_local_study_pd']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');

									if(move_uploaded_file($tmp_name, $path."/".$istudy."/".$name)) {
										$sql[]="INSERT INTO reformulasi.file_lokal_refor_study_literatur_pd (istudy_id, vFilename, vKeterangan, dcreate, ccreate) 
												VALUES (".$istudy.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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

					$r['message']='Data Berhasil di Simpan';
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');				
					echo json_encode($r);
					exit();
				}  else {
					$fileid='';
					foreach($_POST as $key=>$value) {
						if ($key == 'istudy_file_id') {
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
					if($fileid!=''){
						$tgl= date('Y-m-d H:i:s');
						$sql1="update reformulasi.file_lokal_refor_study_literatur_pd set ldeleted=1, dupdate='".$tgl."', cupdate='".$this->user->gNIP."' where istudy_id='".$istudy."' and istudy_file_id not in (".$fileid.")";
						$this->dbset->query($sql1);
					}else{
						$tgl= date('Y-m-d H:i:s');
						$sql1="update reformulasi.file_lokal_refor_study_literatur_pd set ldeleted=1, dupdate='".$tgl."', cupdate='".$this->user->gNIP."' where istudy_id='".$istudy."'";
						$this->dbset->query($sql1);
					}
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
			case 'getdetailsMR':
				echo $this->getdetailsMR();
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
    	$dt=$this->db->query($sql);
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
function listBox_Action($row, $actions) {
    if($row->isubmit<>0){
    	unset($actions['delete']);
    }
    if($row->iapppd<>0){
    	unset($actions['edit']);
    }
    return $actions; 

}

function listBox_local_study_literatur_pd_isubmit($value, $pk, $name, $rowData) {
	$ret="Draft-Need Submit";
	if($rowData->isubmit==1){
		if($rowData->iapppd==0){
			$ret="Submited-Waiting Approval";
		}elseif($rowData->iapppd==2){
			$ret="Approved";
		}else{
			$ret="NULL";
		}
	}
	return $ret;
}
/*manipulasi view object form start*/
 	

	function insertBox_local_study_literatur_pd_vNo_req_refor($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						});
						function browse_'.$id.'(){
							browse(\''.base_url().'processor/reformulasi/local/study/literatur/pd/popup?field=local_study_literatur_pd&modul_id='.$this->input->get('modul_id').'\',\'List Request Refor\');
						}
					</script>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		$return .= '<input type="hidden" name="local_study_literatur_pd_iLocal_req_refor" id="local_study_literatur_pd_iLocal_req_refor" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1 required" size="20" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse_'.$id.'()" type="button">&nbsp;</button>';
		
		return $return;
	}
	function insertBox_local_study_literatur_pd_cIteno($field, $id) {
		$return = '<textarea name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1"></textarea>';
		return $return;
	}
	function insertBox_local_study_literatur_pd_vBatch_no($field, $id) {
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="20" />';
		return $return;
	}
	function insertBox_local_study_literatur_pd_cInisiator($field, $id) {
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="20" />';
		return $return;
	}
	function insertBox_local_study_literatur_pd_idept_id($field, $id) {
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="20" />';
		return $return;
	}
	function insertBox_local_study_literatur_pd_vAlasan_refor($field, $id) {
		$return = '<textarea name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1"></textarea>';
		return $return;
	}
	function insertBox_local_study_literatur_pd_details($field, $id) {
		$return = '---Pilih No Refor Terlebih Dahulu---';
		return $return;
	}
	function insertBox_local_study_literatur_pd_iteam_pd($field, $id) {
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="20"  />';
		return $return;
	}
	function insertBox_local_study_literatur_pd_dRequest($field, $id) {
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="20"  />';
		return $return;
	}
	function insertBox_local_study_literatur_pd_cApproval($field, $id) {
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="20"  />';
		return $return;
	}
	function insertBox_local_study_literatur_pd_cFormulator($field, $id) {
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="20"  />';
		return $return;
	}
	function insertBox_local_study_literatur_pd_lbl($field, $id) {
		$return = '<script>
			$("label[for=\''.$id.'\']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"99%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase"});
		</script>';
		return $return;
	}
	function insertBox_local_study_literatur_pd_dmulai($field, $id){
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px"/>';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
					</script>';
		return $return;
	}
	function insertBox_local_study_literatur_pd_dselesai($field, $id){
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px"/>';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
					</script>';
		return $return;
	}
	function insertBox_local_study_literatur_pd_vupload($field, $id){
		$data['get']=$this->input->get();
		$ret=$this->load->view('local/jqgrid/details_file_study',$data,TRUE);
		return $ret;
	}
	function insertBox_local_study_literatur_pd_iapppd($field, $id){
		$return='-';
		return $return;
	}

	function updateBox_local_study_literatur_pd_vNo_req_refor($field, $id, $value, $rowData){
		$dt=$this->getrefordata($rowData['iLocal_req_refor']);
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						});
						function browse_'.$id.'(){
							browse(\''.base_url().'processor/reformulasi/local/study/literatur/pd/popup?field=local_study_literatur_pd&modul_id='.$this->input->get('modul_id').'\',\'List UPB\');
						}
					</script>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		$return .= '<input type="hidden" name="local_study_literatur_pd_iLocal_req_refor" id="local_study_literatur_pd_iLocal_req_refor" class="input_rows1 required" value="'.$rowData['iLocal_req_refor'].'" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1 required" size="20" value="'.$dt['vNo_req_refor'].'" />';
		if($rowData['iapppd']==0){
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse_'.$id.'()" type="button">&nbsp;</button>';
		}
		
		return $return;
	}

	function updateBox_local_study_literatur_pd_cIteno($field, $id, $value, $rowData){
		$dt=$this->getrefordata($rowData['iLocal_req_refor']);
		$return = '<textarea name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1">'.$dt['c_itnam'].'</textarea>';
		return $return;
	}
	function updateBox_local_study_literatur_pd_vBatch_no($field, $id, $value, $rowData){
		$dt=$this->getrefordata($rowData['iLocal_req_refor']);
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="20" value="'.$dt['vBatch_no'].'" />';
		return $return;
	}
	function updateBox_local_study_literatur_pd_cInisiator($field, $id, $value, $rowData){
		$dt=$this->getrefordata($rowData['iLocal_req_refor']);
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="20" value="'.$dt['cInisiator'].'" />';
		return $return;
	}
	function updateBox_local_study_literatur_pd_idept_id($field, $id, $value, $rowData){
		$dt=$this->getrefordata($rowData['iLocal_req_refor']);
		$iAm['vdepartemen']="-";
		if($dt['cInisiator']!=""){
			$iAm = $this->whoAmI($dt['cInisiator']);
		}
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="20" value="'.$iAm['vdepartemen'].'" />';
		return $return;
	}
	function updateBox_local_study_literatur_pd_vAlasan_refor($field, $id, $value, $rowData){
		$dt=$this->getrefordata($rowData['iLocal_req_refor']);
		$return = '<textarea name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1">'.$dt['vAlasan_refor'].'</textarea>';
		return $return;
	}
	function updateBox_local_study_literatur_pd_details($field, $id, $value, $rowData){
		$dt['id']=$rowData['iLocal_req_refor'];
		$d['post']=$dt;
		$d['nmTable']="tb_req_refor_study";
		$d['pager']="pager_tb_req_refor_study";
		$d['caption'] = "List File Request Refor";
		$return =$this->load->view('local/jqgrid/details_req_study',$d,true);;
		return $return;
	}
	function updateBox_local_study_literatur_pd_iteam_pd($field, $id, $value, $rowData){
		$iteam=array(0=>"NULL",1=>"Gunung Putri",2=>"Ulujami PD",3=>"Etercon");
		$dt=$this->getrefordata($rowData['iLocal_req_refor']);
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="20" value="'.$iteam[$dt['iteam_pd']].'" />';
		return $return;
	}
	function updateBox_local_study_literatur_pd_dRequest($field, $id, $value, $rowData){
		$dt=$this->getrefordata($rowData['iLocal_req_refor']);
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="20" value="'.$dt['dRequest'].'" />';
		return $return;
	}
	function updateBox_local_study_literatur_pd_cApproval($field, $id, $value, $rowData){
		$dt=$this->getrefordata($rowData['iLocal_req_refor']);
		$val='';
		if($dt['cApproval']!=''){
			$ss=$this->whoAmI($dt['cApproval']);
			$val=$ss['vName'];
		}
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="20" value="'.$val.'" />';
		return $return;
	}
	function updateBox_local_study_literatur_pd_cFormulator($field, $id, $value, $rowData){
		$dt=$this->getrefordata($rowData['iLocal_req_refor']);
		$val='';
		if($dt['cFormulator']!=''){
			$ss=$this->whoAmI($dt['cFormulator']);
			$val=$ss['vName'];
		}
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="20" value="'.$val.'" />';
		return $return;
	}

	function updateBox_local_study_literatur_pd_lbl($field, $id, $value, $rowData){
		$return = '<script>
			$("label[for=\''.$id.'\']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"99%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase"});
		</script>';
		return $return;
	}

	function updateBox_local_study_literatur_pd_dmulai($field, $id, $value, $rowData){
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl required" disabled="TRUE" value="'.$value.'" style="width:130px"/>';
		if($rowData['iapppd']==0){
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" value="'.$value.'" style="width:130px"/>';
			$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
					</script>';
		}
		return $return;
	}
	function updateBox_local_study_literatur_pd_dselesai($field, $id, $value, $rowData){
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl required" disabled="TRUE" value="'.$value.'" style="width:130px"/>';
		if($rowData['iapppd']==0){
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" value="'.$value.'" style="width:130px"/>';
			$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
					</script>';
		}
		return $return;
	}
	function updateBox_local_study_literatur_pd_vupload($field, $id, $value, $rowData){
		$data['get']=$this->input->get();
		$data['rowData']=$rowData;
		$ret=$this->load->view('local/jqgrid/details_file_study_edit',$data,TRUE);
		return $ret;
	}
	function updateBox_local_study_literatur_pd_iapppd($field, $id, $value, $rowData){
		$ret='Waiting for Approval';
		if($rowData['iapppd']!=0){
			if($rowData['capppd'] != null){
				$row = $this->db->get_where('hrd.employee', array('cNip'=>$rowData['capppd']))->row_array();
				if($rowData['iapppd']==2){$st="Approved";}elseif($rowData['iapppd']==1){$st="Rejected";} 
				$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['capppd'].' )'.' pada '.$rowData['dapppd'];
			}
			else{
				$ret='Waiting for Approval';
			}
		}
		return $ret;
	}

/*manipulasi view object form end*/

/*manipulasi proses object form start*/
    function manipulate_insert_button($buttons) {
		unset($buttons['save']);
		$js = $this->load->view('local/js/local_study_literatur_pd_js');
		$js .= $this->load->view('local/js/upload_js');
		if($this->auth_local->is_manager()){
			$x=$this->auth_local->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'local_study_literatur_pd\', \''.base_url().'processor/reformulasi/local/study/literatur/pd?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_local_study_literatur_pd">Save as Draft</button>';
				$save = '<button onclick="javascript:save_btn_multiupload(\'local_study_literatur_pd\', \''.base_url().'processor/reformulasi/local/study/literatur/pd?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_local_study_literatur_pd">Save &amp; Submit</button>';
				
				$buttons['save'] = $save_draft.$save.$js;
			}else{$type='qq';}
		}
		else{
			$x=$this->auth_local->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'local_study_literatur_pd\', \''.base_url().'processor/reformulasi/local/study/literatur/pd?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_local_study_literatur_pd">Save as Draft</button>';
				$save = '<button onclick="javascript:save_btn_multiupload(\'local_study_literatur_pd\', \''.base_url().'processor/reformulasi/local/study/literatur/pd?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_local_study_literatur_pd">Save &amp; Submit</button>';
				$buttons['save'] = $save_draft.$save.$js;
			}
			else{$type='sq';}
		}
		//$buttons['save']=$type;
		return $buttons;
	}
	function manipulate_update_button($buttons, $rowData){
		//print_r($rowData);exit();
		unset($buttons['update']);
		//$js=$this->load->view('misc_util',array('className'=> 'local_study_literatur_pd'), true);
		
		$js = $this->load->view('local/js/local_study_literatur_pd_js');
		$js .= $this->load->view('local/js/upload_js');
		$cNip=$this->user->gNIP;

		$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/reformulasi/local/study/literatur/pd?action=approve&istudy_id='.$rowData['istudy_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_local_study_literatur_pd">Approve</button>';
		$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/reformulasi/local/study/literatur/pd?action=reject&istudy_id='.$rowData['istudy_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_local_study_literatur_pd">Reject</button>';

		$update = '<button onclick="javascript:update_btn_back(\'local_study_literatur_pd\', \''.base_url().'processor/reformulasi/local/study/literatur/pd?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_local_study_literatur_pd">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'local_study_literatur_pd\', \''.base_url().'processor/reformulasi/local/study/literatur/pd?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_local_study_literatur_pd">Update as Draft</button>';
		if($this->input->get('action')!="view"){
			if($this->auth_local->is_manager()){
				$x=$this->auth_local->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){

					$type='PD';
					if($rowData['isubmit']==0){
						$buttons['update']=$updatedraft.$update.$js;
					}
					elseif(($rowData['isubmit']<>0)&&($rowData['iapppd']==0)){
						$buttons['update']=$approve.$js;
					}else{}
				}else{

					$type='';
				}
			}else{

				$x=$this->auth_local->dept();
				$team=$x['team'];
				if(in_array('PD', $team)){
					$type='PD';
					if($rowData['isubmit']==0){
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
function before_insert_processor($row, $postData) {
	$postData['dcreate'] = date('Y-m-d H:i:s');
	$postData['ccreate'] =$this->user->gNIP;
		if($postData['isdraft']==true){
			$postData['isubmit']=0;
		}else{$postData['isubmit']=1;} 
	return $postData;

}
function before_update_processor($row, $postData) {
	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cupdate'] =$this->user->gNIP;
		if($postData['isdraft']==true){
			$postData['isubmit']=0;
		} 
		else{$postData['isubmit']=1;} 
	return $postData;

}
function after_insert_processor($row, $insertId, $postData){
	if($postData['isubmit']){
		$dtrefor=$this->getrefordata($postData['local_study_literatur_pd_iLocal_req_refor']);
		$getemail=$this->getemail($dtrefor);
		$to =$getemail['to'];
        $cc =$getemail['cc'];
        $iteam=array(0=>"NULL",1=>"Gunung Putri",2=>"Ulujami PD",3=>"Etercon");
        $subject="Refor - Study Literatur PD: ".$dtrefor['vNo_req_refor'];
        $content="
                Diberitahukan bahwa telah ada inputan pada proses Study Literatur PD(aplikasi Reformulasi) dengan rincian sebagai berikut :<br><br>
                <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
                        <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
                                <tr>
                                        <td style='width: 110px;'><b>No Request</b></td><td style='width: 20px;'> : </td><td>".$dtrefor['vNo_req_refor']."</td>
                                </tr>
                                <tr>
                                        <td><b>Nama Usulan</b></td><td> : </td><td>".$dtrefor['c_itnam']."</td>
                                </tr>
                                <tr>
                                        <td><b>Team PD</b></td><td> : </td><td>".$iteam[$dtrefor['iteam_pd']]."</td>
                                </tr>
                        </table>
                </div>
                <br/> 
                Link Aplikasi : www.npl-net.com/erp <br>
                Menu : Reformulasi - Transaksi - Study Literatur PD
                <br/> <br/>
                Demikian, mohon segera follow up  pada aplikasi ERP Reformulasi. Terimakasih.<br><br><br>
                Post Master";
        $this->lib_utilitas->send_email($to, $cc, $subject, $content);
    }	
}

	function after_update_processor($row, $insertId, $postData, $old_data) {
	if($postData['isubmit']==1&&$old_data['isubmit']==0){
		$dtrefor=$this->getrefordata($postData['local_study_literatur_pd_iLocal_req_refor']);
		$getemail=$this->getemail($dtrefor);
		$to =$getemail['to'];
        $cc =$getemail['cc'];
        $iteam=array(0=>"NULL",1=>"Gunung Putri",2=>"Ulujami PD",3=>"Etercon");
        $subject="Refor - Study Literatur PD: ".$dtrefor['vNo_req_refor'];
        $content="
                Diberitahukan bahwa telah ada inputan pada proses Study Literatur PD(aplikasi Reformulasi) dengan rincian sebagai berikut :<br><br>
                <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
                        <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
                                <tr>
                                        <td style='width: 110px;'><b>No Request</b></td><td style='width: 20px;'> : </td><td>".$dtrefor['vNo_req_refor']."</td>
                                </tr>
                                <tr>
                                        <td><b>Nama Usulan</b></td><td> : </td><td>".$dtrefor['c_itnam']."</td>
                                </tr>
                                <tr>
                                        <td><b>Team PD</b></td><td> : </td><td>".$iteam[$dtrefor['iteam_pd']]."</td>
                                </tr>
                        </table>
                </div>
                <br/> 
                Link Aplikasi : www.npl-net.com/erp <br>
                Menu : Reformulasi - Transaksi - Study Literatur PD
                <br/> <br/>
                Demikian, mohon segera follow up  pada aplikasi ERP Reformulasi. Terimakasih.<br><br><br>
                Post Master";
       $this->lib_utilitas->send_email($to, $cc, $subject, $content);
    }	
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
										$.get(base_url+"processor/reformulasi/local/study/literatur/pd?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
	                            			 $("div#form_local_study_literatur_pd").html(data);
	                    				});
									
								}
									reload_grid("grid_local_study_literatur_pd");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_local_study_literatur_pd_approve" action="'.base_url().'processor/reformulasi/local/study/literatur/pd?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="istudy_id" value="'.$this->input->get('istudy_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_local_study_literatur_pd_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function approve_process(){
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update reformulasi.lokal_refor_study_literatur_pd set vremark_app='".$vRemark."',capppd='".$cNip."', dapppd='".$tApprove."', iapppd=2 where istudy_id='".$post['istudy_id']."'";
		$this->dbset->query($sql);
		$sql1 = "select * from reformulasi.lokal_refor_study_literatur_pd lab where lab.istudy_id='".$post['istudy_id']."'";
        $dtm = $this->db->query($sql1)->row_array();
        $sql2 = "UPDATE reformulasi.local_req_refor st SET st.iStatus_proses = 4 where
	                    st.iLocal_req_refor = '".$dtm['iLocal_req_refor']."'";
	    $this->db->query($sql2);
		$data['group_id']=$post['group_id'];
		$data['modul_id']=$post['modul_id'];
		$data['status']  = true;
		$data['last_id'] = $post['istudy_id'];
		
		return json_encode($data);
	}

function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_local_study_literatur_pd_vRemark").val();
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
								var url = "'.base_url().'processor/reformulasi/local/study/literatur/pd";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
										 $("div#form_local_study_literatur_pd").html(data);
									});
									
								}
									reload_grid("grid_local_study_literatur_pd");
							}
					 	 	
					 	 })
					
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_local_study_literatur_pd_reject" action="'.base_url().'processor/reformulasi/local/study/literatur/pd?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="istudy_id" value="'.$this->input->get('istudy_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_local_study_literatur_pd_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.local_study_literatur_pd set vRemark='".$vRemark."',capppd='".$cNip."', dapppd='".$tApprove."', iapppd=1 where istudy_id='".$post['istudy_id']."'";
		$this->dbset->query($sql);
		$data['group_id']=$post['group_id'];
		$data['modul_id']=$post['modul_id'];
		$data['status']  = true;
		$data['last_id'] = $post['istudy_id'];
		return json_encode($data);
	}

/*function pendukung end*/    	
	function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/reformulasi/local/local_study_literatur_pd/'.$id.'/'.$name);	
		force_download($name, $path);
	}

	/*Get Refor Data*/
	function getemail($dareq){
		$iteam_pd=$dareq['iteam_pd'];
		$return['to']='';
		$return['cc']='';

		/*Untuk Manager (To)*/
		$sqlman='select * from reformulasi.reformulasi_team t where t.ireformulasi_team='.$iteam_pd;
		$dman=$this->dbset->query($sqlman)->row_array();
		if(count($dman)>=1){
			$me=$this->whoAmI($dman['vnip']);
			$return['to']= $me['vEmail'];
		}

		/*Untuk Team (cc)*/
		$sqlteam='select * from reformulasi.reformulasi_team_item i where i.ireformulasi_team='.$iteam_pd;
		$dteam=$this->dbset->query($sqlteam);
		if($dteam->num_rows()>=1){
			$cc=array();
			foreach ($dteam->result_array() as $kteam => $vteam) {
				$me=$this->whoAmI($vteam['vnip']);
				$cc[]=$me['vEmail'];
			}
			$ccr=array_unique($cc);
			$return['cc']=implode(',',$ccr);
		}
		return $return;

	}

	function getrefordata($id=0){
		$sql="select * from reformulasi.local_req_refor r 
			join sales.itemas i on i.c_iteno = r.cIteno
			where r.iLocal_req_refor=".$id;
		$ret=$this->dbset->query($sql)->row_array();
		return $ret;
	}

	function whoAmI($nip){
        $sql = 'select b.vDescription as vdepartemen,a.vName,a.cNip,a.vEmail
                from hrd.employee a 
                join hrd.msdepartement b on b.iDeptID=a.iDepartementID
                where a.cNip ="'.$nip.'"
                ';
        $data = $this->db->query($sql);
       if($data->num_rows()>=1){
       	$dt=$data->row_array();
        return $dt;
       }else{
       	return "0";
       }
    }

    function getdetailsMR(){
    	$post=$this->input->get();
		$sql_data='select * from reformulasi.file_lokal_refor_study_literatur_pd f where f.ldeleted=0 and f.istudy_id='.$post['id'];
		$q=$this->db->query($sql_data);
		$rsel=array('vFilename','vKeterangan','iact');
		$data = new StdClass;
		$data->records=$q->num_rows();
		$i=0;
		foreach ($q->result() as $k) {
			$n=$i+1;
			$data->rows[$i]['id']=$n;
			$z=0;
			foreach ($rsel as $dsel => $vsel) {
				$value = $k->vFilename;	
				$linknya = 'No File';
				if($value != '') {
					if (file_exists('./files/reformulasi/local/local_study_literatur_pd/'.$k->istudy_id.'/'.$value)) {
						$link = base_url().'processor/reformulasi/local/study/literatur/pd?action=download&id='.$k->istudy_id.'&file='.$value;
						$linknya = '<a class="ui-button-text icon_cetak" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
					}
					else {
						$linknya = 'File Deleted';
					}
				}
				if($vsel=="iact"){
					if($post['acc']!="view"){
						$dataar[$dsel]='<input type="hidden" class="num_rows_details_file_study_edit" value="'.$n.'" /><button id="table_file_study_details_edit_hapus" class="ui-button-text icon_hapus" style="width:75px" onclick="javascript:hapus_row_details_file_study_edit('.$n.')" type="button">Hapus</button>'.$linknya.'<input type="hidden" name="istudy_file_id[]" value="'.$k->istudy_file_id.'"';
					}else{
						$dataar[$dsel]='<input type="hidden" class="num_rows_details_file_study_edit" value="'.$n.'" />'.$linknya.'<input type="hidden" name="istudy_file_id[]" value="'.$k->istudy_file_id.'"';
					}
				}else{
					$dataar[$z]=$k->{$vsel};
				}
				$z++;
			}
			$data->rows[$i]['cell']=$dataar;
			$i++;
		}
		return json_encode($data);
    }

	public function output(){
		$this->index($this->input->get('action'));
	}

}