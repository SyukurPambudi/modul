<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class validasi_proses extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->dbset = $this->load->database('plc', true);
		 $this->load->library('lib_utilitas');
		$this->user = $this->auth_localnon->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;

		$grid->setTitle('Validasi Proses');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('validasi_proses');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik','validasi_proses.dmulai_validasi','validasi_proses.dselesai_validasi','validasi_proses.iappqa','validasi_proses.isubmit');
		$grid->setSortBy('iupb_id');
		$grid->setSortOrder('DESC');
		$grid->setLabel('vupb_nomor', 'UPB Nomor');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setWidth('vupb_nomor', '120');
		$grid->setAlign('vupb_nama', 'Left');
		$grid->setWidth('vupb_nama', '200');
		$grid->setAlign('validasi_proses.dmulai_validasi', 'Left');
		$grid->setWidth('validasi_proses.dmulai_validasi', '200');
		$grid->setAlign('validasi_proses.dselesai_validasi', 'Left');
		$grid->setWidth('validasi_proses.dselesai_validasi', '200');
		$grid->setAlign('validasi_proses.iappqa', 'Left');
		$grid->setWidth('validasi_proses.iappqa', '150');
		$grid->addFields('iupb_id','vupb_nama','vgenerik','vbatch','dmulai_validasi','dselesai_validasi','vPICqa','vfile','iappqa');
		$grid->setLabel('validasi_proses.dmulai_validasi', 'Tgl Mulai Pembuatan');

		$grid->setLabel('validasi_proses.dselesai_validasi', 'Tgl Selesai Pembuatan');
		$grid->setLabel('validasi_proses.isubmit', 'Status Submit');


		$grid->setLabel('vbatch', 'No Batch');
		$grid->setLabel('dmulai_validasi', 'Tgl Mulai Pembuatan');
		$grid->setLabel('dmulai_validasi', 'Tgl Mulai Pembuatan');
		$grid->setLabel('dselesai_validasi', 'Tgl Selesai Pembuatan');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('vPICqa', 'PIC QA');
		$grid->setLabel('vfile', 'File Laporan Valpro');
		$grid->setLabel('iappqa', 'Approval QA');
		$grid->setLabel('validasi_proses.iappqa', 'Approval QA');;
		$grid->setFormUpload(TRUE);
		$grid->setRequired('iupb_id','dmulai_validasi','dselesai_validasi','vPICqa','vfile');
		
		$grid->setJoinTable('plc2.validasi_proses', 'validasi_proses.iupb_id = plc2_upb.iupb_id', 'left');
		$grid->setJoinTable('plc2.plc2_upb_formula', 'plc2_upb_formula.iupb_id=plc2.plc2_upb.iupb_id','inner');
		$grid->setJoinTable('pddetail.formula_process','formula_process.iupb_id=plc2_upb_formula.iupb_id','inner');
		$grid->setJoinTable('pddetail.formula','formula.iFormula_process=formula_process.iFormula_process','inner');
		$grid->setJoinTable('plc2.plc2_upb_buat_mbr', 'plc2_upb_buat_mbr.ifor_id=plc2_upb_formula.ifor_id','inner');
		$grid->setRelation('plc2.plc2_upb.iteamqa_id','plc2.plc2_upb_team','iteam_id','vteam','team_qa','inner',array('vtipe'=>'QA', 'ldeleted'=>0),array('vteam'=>'asc'));

		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('QA', $team)){
					$type='QA';
					$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
				}
				else{$type='';}
			}
		}
		$grid->setSearch('vupb_nomor','vupb_nama');
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
				$post['dupdate'] = date('Y-m-d H:i:s');
				$post['cUpdate'] =$this->user->gNIP;
					if($post['isdraft']==true){
						$post['isubmit_validasi']=0;$isubmit=0;
					} 
					else{$post['isubmit_validasi']=1;$isubmit=1;} 
				$post['dmulai_validasi']=date("Y-m-d", strtotime($post['validasi_proses_dmulai_validasi']));
				$post['dselesai_validasi']=date("Y-m-d", strtotime($post['validasi_proses_dselesai_validasi']));
				//print_r($post);exit();
				//$ivalidasi_id=0;
				$this->db_plc0->where('iupb_id', $post['validasi_proses_iupb_id']);		
				$j2 = $this->db_plc0->count_all_results('plc2.validasi_proses');
					$data['iupb_id']=$post['validasi_proses_iupb_id'];
					$data['dmulai_validasi']=$post['dmulai_validasi'];
					$data['dselesai_validasi']=$post['dselesai_validasi'];
					$data['vPICqa']=$post['validasi_proses_vPICqa'];
					$data['vbatch']=$post['validasi_proses_vbatch'];
					$data['isubmit']=$post['isubmit_validasi'];
					$data['dupdate']=$post['dupdate'];
					$data['cUpdate']=$post['cUpdate'];
					$data['dCreate']=$post['dupdate'];
					$data['cCreate']=$post['cUpdate'];

				if($j2==0){
					$this->db_plc0->insert('plc2.validasi_proses', $data);
					$sql="select * from plc2.validasi_proses where iupb_id=".$data['iupb_id']." order by ivalidasi_id DESC limit 1";
					$dt=$this->dbset->query($sql)->row_array();
					$ivalidasi_id=$dt['ivalidasi_id'];
				}else{
					$sql="select * from plc2.validasi_proses where iupb_id=".$post['validasi_proses_iupb_id']." order by ivalidasi_id DESC limit 1";
					$dt=$this->dbset->query($sql)->row_array();
					$ivalidasi_id=$dt['ivalidasi_id'];
					$sql="UPDATE plc2.validasi_proses SET iupb_id=".$data['iupb_id'].", dmulai_validasi='".$data['dmulai_validasi']."', vbatch='".$data['vbatch']."',
						dselesai_validasi='".$data['dselesai_validasi']."', vPICqa='".$data['vPICqa']."', isubmit=".$data['isubmit'].", 
						dupdate='".$data['dupdate']."', cUpdate='".$data['cUpdate']."' WHERE ivalidasi_id=".$ivalidasi_id;
					$this->db_plc0->query($sql);
				}
				$path = realpath("files/plc/validasi_proses/");
				if(!file_exists($path."/".$ivalidasi_id)){
					if (!mkdir($path."/".$ivalidasi_id, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}			
				$fKeterangan = array();	
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
   				if($isUpload) {	
	   				
					if (isset($_FILES['fileupload']))  {
						$i=0;
						foreach ($_FILES['fileupload']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
								$name =$_FILES['fileupload']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$ivalidasi_id."/".$name)) {
									$sqli[]="INSERT INTO plc2.validasi_proses_file (ivalidasi_id, vFilename, vKeterangan, dCreate, cCreate) 
											VALUES (".$ivalidasi_id.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sqli as $ql) {
							try {
								$this->dbset->query($ql);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}
					$r['message']="Data Berhasil di Simpan!";
					$r['status'] = TRUE;
					$r['last_id'] = $post['validasi_proses_iupb_id'];				
					echo json_encode($r);
					exit();
				}  else {
					$fileid='';
   					foreach($_POST as $key=>$value) {
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
					$sql1="update plc2.validasi_proses_file set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where ivalidasi_id='".$ivalidasi_id."' and ivalidasi_proses_file_id not in (".$fileid.")";

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

    function listBox_validasi_proses_validasi_proses_isubmit($value, $pk, $name, $rowData) {
    	
		if ($value > 0) {
			$nama_group = 'Submitted';
		}else{
			$nama_group = 'Draft';
		}
		
		return $nama_group;
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
function listBox_validasi_proses_validasi_proses_iappqa($value) {
	if($value==0){$vstatus='Waiting for approval';}
	elseif($value==1){$vstatus='Rejected';}
	elseif($value==2){$vstatus='Approved';}
	return $vstatus;
}
function listBox_validasi_proses_validasi_proses_vPICqa($value) {
	$data='-';
	$sql='select em.cNip as cNip, em.vName as vName from hrd.employee em where em.cNip="'.$value.'" LIMIT 1';
	$dt=$this->db_plc0->query($sql)->row_array();
	if($dt){
		$data=$dt['cNip'].' - '.$dt['vName'];
	}
	return $data;
}
function listBox_Action($row, $actions) {
    if($row->validasi_proses__iappqa<>0){
    	unset($actions['edit']);
    }
    return $actions; 

	}
/*manipulasi view object form start*/
 	function updateBox_validasi_proses_iupb_id($field, $id, $value, $rowData){
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

	function updateBox_validasi_proses_vupb_nama($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nama'];
		}else{
			$return='<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vupb_nama'].'" />';
		}
		return $return;
	}
	function updateBox_validasi_proses_vgenerik($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vgenerik'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vgenerik'].'" />';
		}
		return $return;
	}
	function updateBox_validasi_proses_vbatch($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.validasi_proses');
		if($j2> 0){
			$sql="select * from plc2.validasi_proses where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['vbatch'];
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
	function updateBox_validasi_proses_dmulai_validasi($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.validasi_proses');
		if($j2> 0){
			$sql="select * from plc2.validasi_proses where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=date('d-m-Y',strtotime($dt['dmulai_validasi']));
			if(($value==NULL)||($value=='')||($value=='0000-00-00')){
				$val='';
			}else{
				$val=date('d-m-Y',strtotime($value));
			}
			if($this->input->get('action')=='view'){
			$return	=$val;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" />';
				$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}
		return $return;
	}
	function updateBox_validasi_proses_dselesai_validasi($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.validasi_proses');
		if($j2> 0){
			$sql="select * from plc2.validasi_proses where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=date('d-m-Y',strtotime($dt['dselesai_validasi']));
			if(($value==NULL)||($value=='')||($value=='0000-00-00')){
				$val='';
			}else{
				$val=date('d-m-Y',strtotime($value));
			}
			if($this->input->get('action')=='view'){
				$return	=$val;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}else{
			if($this->input->get('action')=='view'){
			$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" />';
				$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}
		return $return;
	}
	function updateBox_validasi_proses_vPICqa($field, $id, $value, $rowData) {
		$url = base_url().'processor/plc/validasi/proses?action=getemployee';
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
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.validasi_proses');
		if($j2> 0){
			$sql="select * from plc2.validasi_proses where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['vPICqa'];
			if(($value!=NULL)||($value!='')){
				$sql="select * from plc2.validasi_proses where ivalidasi_id=".$dt['ivalidasi_id']." LIMIT 1";
				$dt=$this->db_plc0->query($sql)->row_array();
				$value=$dt['vPICqa'];
				$sql="select * from hrd.employee em where em.cNip='".$value."'";
				$dt=$this->db_plc0->query($sql)->row_array();
				if($this->input->get('action')=='view'){
					$return	=$dt['vName'];
				}else{
					$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" value="'.$value.'" class="required" />
					<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20" value="'.$dt['vName'].'"/>';
				}
			}else{
				if($this->input->get('action')=='view'){
					$return	='-';
				}else{
					$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" class="required" />
					<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20"/>';
				}
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" class="required" />
				<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20"/>';
			}
		}
		
		return $return;
	}

    function updateBox_validasi_proses_vfile($field, $id, $value, $rowData) {
    	$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.validasi_proses');
		if($j2> 0){
			$sql="select * from plc2.validasi_proses where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['ivalidasi_id'];
		}else{$value='0';} 	
		$qr="select * from plc2.validasi_proses_file where ivalidasi_id='".$value."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('validasi_proses_file',$data,TRUE);
	}
	function updateBox_validasi_proses_iappqa($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.validasi_proses');
		if($j2> 0){
			$sql="select * from plc2.validasi_proses where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			if($dt['iappqa'] != 0){
				$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$dt['vappqa']))->row_array();
				if($dt['iappqa']==2){$st="Approved";}elseif($dt['iappqa']==1){$st="Rejected";} 
				$ret= $st.' oleh '.$row['vName'].' ( '.$dt['vappqa'].' )'.' pada '.$dt['dappqa'];
			}
			else{
				$ret='Waiting for Approval';
			}
		}else{
			$ret='Waiting for Approval';
		}
		return $ret;
	}
/*manipulasi view object form end*/

/*manipulasi proses object form start*/
	function manipulate_update_button($buttons, $rowData){
		//print_r($rowData);exit();

		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.validasi_proses');
		$ivalidasi_id=0;
		if($j2> 0){
			$sql="select * from plc2.validasi_proses where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$ivalidasi_id=$dt['ivalidasi_id'];
		}

		unset($buttons['update']);
		$js=$this->load->view('validasi_proses_js');
		$js .= $this->load->view('uploadjs');
		$cNip=$this->user->gNIP;

		$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/validasi/proses?action=approve&iupb_id='.$rowData['iupb_id'].'&ivalidasi_id='.$ivalidasi_id.'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_validasi_proses">Approve</button>';
		$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/validasi/proses?action=reject&iupb_id='.$rowData['iupb_id'].'&ivalidasi_id='.$ivalidasi_id.'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_validasi_proses">Reject</button>';

		$update = '<button onclick="javascript:update_btn_back(\'validasi_proses\', \''.base_url().'processor/plc/validasi/proses?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_validasi_proses">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'validasi_proses\', \''.base_url().'processor/plc/validasi/proses?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_validasi_proses">Update as Draft</button>';
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){
				if($j2> 0){
					$sql="select * from plc2.validasi_proses where ivalidasi_id=".$ivalidasi_id." LIMIT 1";
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

			$x=$this->auth_localnon->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('QA', $team)){
					$type='QA';
					if($j2> 0){
						$sql="select * from plc2.validasi_proses where ivalidasi_id=".$ivalidasi_id." LIMIT 1";
						$dt=$this->db_plc0->query($sql)->row_array();
						if($dt['isubmit']==0){
							$buttons['update']=$updatedraft.$update.$js;
						}elseif(($dt['isubmit']<>0)&&($dt['iappqa']==0)){
							$buttons['update']=$approve.$reject.$js;
						}else{}
					}else{
						$sql="select * from plc2.validasi_proses where ivalidasi_id=".$ivalidasi_id." LIMIT 1";
						$dt=$this->db_plc0->query($sql)->row_array();

						if($dt['isubmit']==0){
							$buttons['update']=$updatedraft.$update.$js;
						}elseif(($dt['isubmit']<>0)&&($dt['iappqa']==0)){
							$buttons['update']=$approve.$reject.$js;
						}else{}

						//$buttons['update']=$updatedraft.$update.$js;
					}
				}else{
					$type='';
				}
			}
		}
		return $buttons;
	}
   
/*manipulasi proses object form end*/    
function before_update_processor($row, $postData) {
	unset($postData['vupb_nama']);
	unset($postData['vgenerik']);
	unset($postData['validasi_proses_dmulai_validasi']);
	unset($postData['validasi_proses_dselesai_validasi']);
	
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
										$.get(base_url+"processor/plc/validasi/proses?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
	                            			 $("div#form_validasi_proses").html(data);
	                    				});
									
								}
									reload_grid("grid_validasi_proses");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_validasi_proses_approve" action="'.base_url().'processor/plc/validasi/proses?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="ivalidasi_id" value="'.$this->input->get('ivalidasi_id').'" />
				<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_validasi_proses_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function approve_process(){
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$iupb_id = $post['iupb_id'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.validasi_proses set vRemark='".$vRemark."',vappqa='".$cNip."', dappqa='".$tApprove."', iappqa=2 where ivalidasi_id='".$post['ivalidasi_id']."'";
		$this->dbset->query($sql);

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
        $subject="Laporan Validasi Proses: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval oleh QA Manager pada proses Laporan Validasi Proses(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
		$data['last_id'] = $post['iupb_id'];
		return json_encode($data);
	}

function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#vRemark").val();
					 	if (remark=="") {
					 		info = "Info";
							header = "Info";
							grid="validasi_proses";
					 		_custom_alert("Remark Tidak Boleh Kosong!",header,info, grid, 1, 20000);
					 		return
					 	}
					 	return $.ajax({
					 		url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/validasi/proses";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
										 $("div#form_validasi_proses").html(data);
									});
									
								}
									reload_grid("grid_validasi_proses");
							}
					 	 	
					 	 })
					
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_validasi_proses_reject" action="'.base_url().'processor/plc/validasi/proses?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="ivalidasi_id" value="'.$this->input->get('ivalidasi_id').'" />
				<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_validasi_proses_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.validasi_proses set vRemark='".$vRemark."',vappqa='".$cNip."', dappqa='".$tApprove."', iappqa=1 where ivalidasi_id='".$post['ivalidasi_id']."'";
		$this->dbset->query($sql);

		$data['group_id']=$post['group_id'];
		$data['modul_id']=$post['modul_id'];
		$data['status']  = true;
		$data['last_id'] = $post['iupb_id'];
		return json_encode($data);
	}
	function after_update_processor($row, $insertId, $postData){
	}

/*function pendukung end*/    	
function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/validasi_proses/'.$id.'/'.$name);	
		force_download($name, $path);
	}

	public function output(){
		$this->index($this->input->get('action'));
	}

}
