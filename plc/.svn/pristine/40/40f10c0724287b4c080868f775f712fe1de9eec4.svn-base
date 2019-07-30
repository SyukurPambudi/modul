<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class study_literatur_pd extends MX_Controller {
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
		$grid->setTitle('Study Literatur PD Formulator');
		//dc.m_vendor  database.tabel

		$grid->setTitle('Study Literatur PD');		
		$grid->setTable('plc2.study_literatur_pd');		
		$grid->setUrl('study_literatur_pd');
		$grid->addList('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','plc2_upb.iteampd_id','cPIC','plc2_upb.imaster_delivery','iStatus','iapppd');
		$grid->setSortBy('istudy_pd_id');
		$grid->setSortOrder('DESC');
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '120');
		$grid->setAlign('plc2_upb.vupb_nama', 'Left');
		$grid->setWidth('plc2_upb.vupb_nama', '200');
		$grid->setAlign('plc2_upb.vgenerik', 'Left');
		$grid->setWidth('plc2_upb.vgenerik', '200');
		$grid->setAlign('plc2_upb.iteampd_id', 'Left');
		$grid->setWidth('plc2_upb.iteampd_id', '100');
		$grid->addFields('iupb_id','vupb_nama','vgenerik','iteampd_id','dmulai_study','dselesai_study','iuji_mikro','imaster_delivery','cPIC','ijenis_sediaan','vkompedial','vfile','iapppd');
		$grid->setLabel('plc2_upb.vupb_nomor', 'UPB Nomor');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setLabel('plc2_upb.iteampd_id', 'Team PD');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('iapppd','Approval PD');
		$grid->setLabel('iStatus','Status');
		$grid->setWidth('iStatus', '80');
		$grid->setWidth('iapppd', '120');
		$grid->setLabel('ijenis_sediaan','Jenis Sediaan');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('iteampd_id', 'Team PD');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('cPIC', 'PIC Study Literatur');
		$grid->setLabel('dmulai_study', 'Tgl Mulai Study Literatur');
		$grid->setLabel('dselesai_study', 'Tgl Selesai Study Literatur');
		$grid->setLabel('iuji_mikro', 'Uji Mikro FG');
		$grid->setLabel('vkompedial', 'Kompedial yang digunakan');
		$grid->setLabel('vfile', 'File Study Literatur');//Field yg mandatori
		$grid->setQuery('study_literatur_pd.lDeleted','0');
		$grid->setRequired('iupb_id','dmulai_study','dselesai_study','iuji_mikro','ijenis_sediaan','cPIC','vfile');
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
		$grid->setFormUpload(TRUE);
		
		$grid->setJoinTable('plc2.plc2_upb', 'study_literatur_pd.iupb_id = plc2.plc2_upb.iupb_id', 'inner');
		$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));
		
		$grid->setRelation('plc2.plc2_upb.imaster_delivery','plc2.master_delivery_system','imaster_delivery_system','vKey','vDeskripsi','left',array('lDeleted'=>0),array('vKey'=>'asc'));

		$grid->changeFieldType('iuji_mikro','combobox','',array(''=>'-- Pilih --',0=>'No',1=>'Yes'));
		$grid->changeFieldType('ijenis_sediaan','combobox','',array(''=>'-- Pilih --',0=>'Khusus Produk Steril',1=>'Khusus Produk Non Steril'));
		$grid->changeFieldType('iStatus','combobox','',array(0=>'Need to Submit',1=>'Submited'));
		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','cPIC','plc2_upb.imaster_delivery');
		$grid->setGridView('grid');
		
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/

		$grid->setLabel('imaster_delivery','Master Delivery');
		$grid->setLabel('plc2_upb.imaster_delivery','Master Delivery');
		$grid->setWidth('plc2_upb.imaster_delivery','100');

		
		
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
					$path = realpath("files/plc/study_literatur_pd");
					if(!file_exists($path."/".$lastId)){
						if (!mkdir($path."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
					}
					$fKeterangan = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'fileketerangan_studypd') {
							foreach($value as $k=>$v) {
								$fKeterangan[$k] = $v;
							}
						}
					}
					$i=0;
					foreach ($_FILES['fileupload_studypd']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {
							$tmp_name = $_FILES['fileupload_studypd']["tmp_name"][$key];
							$name =$_FILES['fileupload_studypd']["name"][$key];
							$data['filename'] = $name;
							$data['dInsertDate'] = date('Y-m-d H:i:s');

								if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.study_literatur_pd_file (istudy_pd_id, vFilename, vKeterangan, dCreate, cCreate) 
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
				
				$istudy=$post['study_literatur_pd_istudy_pd_id'];
				$path = realpath("files/plc/study_literatur_pd/");
				if(!file_exists($path."/".$istudy)){
					if (!mkdir($path."/".$istudy, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
				$fKeterangan = array();	
					$fileid='';
					foreach($_POST as $key=>$value) {
										
					if ($key == 'fileketerangan_studypd') {
						foreach($value as $y=>$u) {
							$fKeterangan[$y] = $u;
						}
					}
					if ($key == 'namafile_studypd') {
						foreach($value as $k=>$v) {
							$file_name[$k] = $v;
						}
					}
					if ($key == 'fileid_studypd') {
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
					if (isset($_FILES['fileupload_studypd']))  {

						$i=0;
						foreach ($_FILES['fileupload_studypd']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_studypd']["tmp_name"][$key];
								$name =$_FILES['fileupload_studypd']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$istudy."/".$name)) {
									$sql[]="INSERT INTO plc2.study_literatur_pd_file (istudy_pd_id, vFilename, vKeterangan, dCreate, cCreate) 
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
						if ($key == 'fileid_studypd') {
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
					$sql1="update plc2.study_literatur_pd_file set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where istudy_pd_id='".$istudy."' and istudy_pd_file_id not in (".$fileid.")";
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
	function searchBox_study_literatur_pd_plc2_upb_imaster_delivery($rowData, $id){
	    $teams = $this->db_plc0->get_where('plc2.master_delivery_system', array('lDeleted' => 0))->result_array();
	    $o = '<select class="required" name="'.$id.'" id="'.$id.'">';
	    $o .= '<option value="">--Select--</option>';
	    foreach ($teams as $t) {
	        $o .= '<option value="'.$t['imaster_delivery_system'].'">'.$t['vKey']." - ".$t['vDeskripsi'].'</option>';
	    }
	    $o .= '</select>';
	    return $o;
	}

	function listBox_study_literatur_pd_imaster_delivery($value,$id){
		$study = $this->db_plc0->get_where('plc2.study_literatur_pd',array('istudy_pd_id'=>$id))->row_array();
		$upb = $this->db_plc0->get_where('plc2.plc2_upb',array('iupb_id'=>$study['iupb_id']))->row_array();
	    if ($upb['imaster_delivery'] == '0'){
	        return "Not Selected";
	    }else{
	        $sql = "SELECT vKey, vDeskripsi FROM plc2.master_delivery_system WHERE imaster_delivery_system = '".$upb['imaster_delivery']."' AND lDeleted = '0' LIMIT 1";
	        $data = $this->db_plc0->query($sql)->row_array();
	        return $data['vKey']." - ".$data['vDeskripsi'];
	        //return $row;
	    }
	}

function listBox_study_literatur_pd_iapppd($value) {
	if($value==0){$vstatus='Waiting for approval';}
	elseif($value==1){$vstatus='Rejected';}
	elseif($value==2){$vstatus='Approved';}
	return $vstatus;
}
function listBox_study_literatur_pd_cPIC($value) {
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
    if($row->iapppd<>0){
    	unset($actions['edit']);
    }
    return $actions; 

	}
/*manipulasi view object form start*/
 	
 	function insertBox_study_literatur_pd_imaster_delivery($field, $id) {
    	$teams = $this->db_plc0->get_where('plc2.master_delivery_system', array('lDeleted' => 0))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['imaster_delivery_system'].'">'.$t['vKey']." - ".$t['vDeskripsi'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }


    function updateBox_study_literatur_pd_imaster_delivery($field, $id, $value, $rowData) {
    	$teams = $this->db_plc0->get_where('plc2.master_delivery_system', array('lDeleted' => 0))->result_array();
    	$upb = $this->db_plc0->get_where('plc2.plc2_upb',array('iupb_id'=>$rowData['iupb_id']))->row_array();

    	$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($teams as $t) {
    		$selected = $upb['imaster_delivery'] == $t['imaster_delivery_system'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$t['imaster_delivery_system'].'">'.$t['vKey']." - ".$t['vDeskripsi'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }


	function insertBox_study_literatur_pd_iupb_id($field, $id) {
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/study/literatur/pd/popup?field=study_literatur_pd&modul_id='.$this->input->get('modul_id').'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	function insertBox_study_literatur_pd_vupb_nama($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" />';
	}
	function insertBox_study_literatur_pd_vgenerik($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" />';
	}
	function insertBox_study_literatur_pd_iteampd_id($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" />';
		/*$my_teams=$this->auth_localnon->my_teams();
		$sql="select * from plc2.plc2_upb_team te where te.ldeleted=0 and te.vtipe='PD' and te.iteam_id in(".$my_teams.")";
		$teams = $this->db_plc0->query($sql)->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;*/
	}
	function insertBox_study_literatur_pd_dmulai_study($field, $id){
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px"/>';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
					</script>';
		return $return;
	}
	function insertBox_study_literatur_pd_dselesai_study($field, $id){
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px"/>';
		$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
						
					</script>';
		return $return;
	}
	function insertBox_study_literatur_pd_cPIC($field,$id){
		$url = base_url().'processor/plc/study/literatur/pd?action=getemployee';
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

	function insertBox_study_literatur_pd_vkompedial($field, $id){
		return '<textarea id='.$id.' name='.$id.' colspan="2"></textarea>';
	}

    function insertBox_study_literatur_pd_vfile($field, $id) {
    	$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('study_literatur_pd_file',$data,TRUE);
	}
	function insertBox_study_literatur_pd_iapppd($field, $id) {
    	return '-';
	}

	function updateBox_study_literatur_pd_iupb_id($field, $id, $value, $rowData){
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/study/literatur/pd/popup?field=study_literatur_pd&modul_id='.$this->input->get('modul_id').'\',\'List UPB\')" type="button">&nbsp;</button>';
		}
		return $return;
	}

	function updateBox_study_literatur_pd_vupb_nama($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nama'];
		}else{
			$return='<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" value="'.$dt['vupb_nama'].'" />';
		}
		return $return;
	}
	function updateBox_study_literatur_pd_vgenerik($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vgenerik'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" value="'.$dt['vgenerik'].'" />';
		}
		return $return;
	}

	function updateBox_study_literatur_pd_iteampd_id($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb up 
		inner join plc2.plc2_upb_team te on up.iteampd_id=te.iteam_id 
		 where up.iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vteam'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" value="'.$dt['vteam'].'" />';
		}
		return $return;
		/*$sql="select * from plc2.plc2_upb_team te where te.ldeleted=0 and te.vtipe='PD' and te.iteam_id=".$value."";
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$o=$dt['vteam'];
		}else{
		$my_teams=$this->auth_localnon->my_teams();
		$sql="select * from plc2.plc2_upb_team te where te.ldeleted=0 and te.vtipe='PD' and te.iteam_id in(".$my_teams.")";
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
	function updateBox_study_literatur_pd_dmulai_study($field, $id, $value, $rowData) {
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value='.$value.' />';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
					</script>';
		}
		return $return;
	}
	function updateBox_study_literatur_pd_dselesai_study($field, $id, $value, $rowData) {
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value='.$value.' />';
		$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
						
					</script>';
		}
		return $return;
	}
	function updateBox_study_literatur_pd_cPIC($field, $id, $value, $rowData) {
		$sql="select * from hrd.employee em where em.cNip='".$value."'";
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return	=$dt['vName'];
		}else{
		$url = base_url().'processor/plc/study/literatur/pd?action=getemployee';
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
		<input name="'.$id.'" id="'.$id.'" type="hidden" value="'.$value.'"/>
		<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20" value="'.$dt['vName'].'"/>';
		}
		return $return;
	}

	function updateBox_study_literatur_pd_vkompedial($field, $id, $value, $rowData) {
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
			$return ='<textarea id='.$id.' name='.$id.' colspan="2">'.$value.'</textarea>';
		}
		return $return;
	}

    function updateBox_study_literatur_pd_vfile($field, $id, $value, $rowData) {
    	 	
		$qr="select * from plc2.study_literatur_pd_file where istudy_pd_id='".$rowData['istudy_pd_id']."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('study_literatur_pd_file',$data,TRUE);
	}
	function updateBox_study_literatur_pd_iapppd($field, $id, $value, $rowData) {
    	if($rowData['capppd'] != null){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['capppd']))->row_array();
			if($rowData['iapppd']==2){$st="Approved";}elseif($rowData['iapppd']==1){$st="Rejected";} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['capppd'].' )'.' pada '.$rowData['dapppd'];
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
		//$js=$this->load->view('misc_util',array('className'=> 'study_literatur_pd'), true);
		$js = $this->load->view('study_literatur_pd_js');
		$js .= $this->load->view('uploadjs');
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){$type='PD';
				$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'study_literatur_pd\', \''.base_url().'processor/plc/study/literatur/pd?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_study_literatur_pd">Save as Draft</button>';
				$save = '<button onclick="javascript:save_btn_multiupload(\'study_literatur_pd\', \''.base_url().'processor/plc/study/literatur/pd?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_study_literatur_pd">Save &amp; Submit</button>';
				
				$buttons['save'] = $save_draft.$save.$js;
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';
				$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'study_literatur_pd\', \''.base_url().'processor/plc/study/literatur/pd?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_study_literatur_pd">Save as Draft</button>';
				$save = '<button onclick="javascript:save_btn_multiupload(\'study_literatur_pd\', \''.base_url().'processor/plc/study/literatur/pd?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_study_literatur_pd">Save &amp; Submit</button>';
				//$js = $this->load->view('study_literatur_pd_js');
				$buttons['save'] = $save_draft.$save.$js;
			}
			else{$type='';}
		}
		return $buttons;
	}
	function manipulate_update_button($buttons, $rowData){
		//print_r($rowData);exit();
		unset($buttons['update']);
		//$js=$this->load->view('misc_util',array('className'=> 'study_literatur_pd'), true);
		
		$js = $this->load->view('study_literatur_pd_js');
		$js .= $this->load->view('uploadjs');
		$cNip=$this->user->gNIP;

		$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/study/literatur/pd?action=approve&istudy_pd_id='.$rowData['istudy_pd_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_study_literatur_pd">Approve</button>';
		$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/study/literatur/pd?action=reject&istudy_pd_id='.$rowData['istudy_pd_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_study_literatur_pd">Reject</button>';

		$update = '<button onclick="javascript:update_btn_back(\'study_literatur_pd\', \''.base_url().'processor/plc/study/literatur/pd?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_study_literatur_pd">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'study_literatur_pd\', \''.base_url().'processor/plc/study/literatur/pd?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_study_literatur_pd">Update as Draft</button>';
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){

				$type='PD';
				if($rowData['iStatus']==0){
					$buttons['update']=$updatedraft.$update.$js;
				}
				elseif(($rowData['iStatus']<>0)&&($rowData['iapppd']==0)){
					$buttons['update']=$update.$approve.$reject.$js;
				}else{}
			}else{

				$type='';
			}
		}else{

			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
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
	return $postData;

}
function before_update_processor($row, $postData) {
	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;
		if($postData['isdraft']==true){
			$postData['iStatus']=0;
		} 
		else{$postData['iStatus']=1;} 
	return $postData;

}
function after_insert_processor($row, $insertId, $postData){
	$iupb_id=$postData['iupb_id'];
	$imaster_delivery= $postData['imaster_delivery'];

	/*update master delivery system*/
	$SQL = "UPDATE plc2.plc2_upb set imaster_delivery='{$imaster_delivery}' where iupb_id = '{$iupb_id}'";
	$this->db_plc0->query($SQL);
	
}


function after_update_processor($row, $insertId, $postData){
	$iupb_id=$postData['iupb_id'];
	$imaster_delivery= $postData['imaster_delivery'];

	/*update master delivery system*/
	$SQL = "UPDATE plc2.plc2_upb set imaster_delivery='{$imaster_delivery}' where iupb_id = '{$iupb_id}'";
	$this->db_plc0->query($SQL);
	
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
										$.get(base_url+"processor/plc/study/literatur/pd?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
	                            			 $("div#form_study_literatur_pd").html(data);
	                    				});
									
								}
									reload_grid("grid_study_literatur_pd");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_study_literatur_pd_approve" action="'.base_url().'processor/plc/study/literatur/pd?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="istudy_pd_id" value="'.$this->input->get('istudy_pd_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_study_literatur_pd_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function approve_process(){
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.study_literatur_pd set vRemark='".$vRemark."',capppd='".$cNip."', dapppd='".$tApprove."', iapppd=2 where istudy_pd_id='".$post['istudy_pd_id']."'";
		$this->dbset->query($sql);

		$sql="select iupb_id from plc2.study_literatur_pd where istudy_pd_id='".$post['istudy_pd_id']."' and lDeleted=0 LIMIT 1";
		$dt=$this->dbset->query($sql)->row_array();
		$iupb_id=$dt['iupb_id'];
		//$this->lib_flow->insert_logs($post['modul_id'],$iupb_id,9,2);

		//$sqli="update plc2.plc2_upb set istudypd=1 where iupb_id='".$iupb_id."'";
        //$this->dbset->query($sqli);

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
        $subject="Proses Study Literatur PD: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval oleh PD Manager pada proses Study Literatur PD(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
		$data['last_id'] = $post['istudy_pd_id'];
		
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
								var url = "'.base_url().'processor/plc/study/literatur/pd";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
										 $("div#form_study_literatur_pd").html(data);
									});
									
								}
									reload_grid("grid_study_literatur_pd");
							}
					 	 	
					 	 })
					
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_study_literatur_pd_reject" action="'.base_url().'processor/plc/study/literatur/pd?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="istudy_pd_id" value="'.$this->input->get('istudy_pd_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_study_literatur_pd_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.study_literatur_pd set vRemark='".$vRemark."',capppd='".$cNip."', dapppd='".$tApprove."', iapppd=1 where istudy_pd_id='".$post['istudy_pd_id']."'";
		$this->dbset->query($sql);
		$data['group_id']=$post['group_id'];
		$data['modul_id']=$post['modul_id'];
		$data['status']  = true;
		$data['last_id'] = $post['istudy_pd_id'];
		return json_encode($data);
	}

/*function pendukung end*/    	
function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/study_literatur_pd/'.$id.'/'.$name);	
		force_download($name, $path);
	}

	public function output(){
		$this->index($this->input->get('action'));
	}

}
