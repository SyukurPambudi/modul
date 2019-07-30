<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dossier_upload_dokumen extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_plcexport');
		$this->load->library('lib_utilitas');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth_plcexport->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Upload Dokumen');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_review');		
		$grid->setUrl('dossier_upload_dokumen');
		$grid->addList('dossier_upd.vUpd_no','dossier_upd.vNama_usulan','dossier_upd.iTeam_andev','iSemester','iTahun');
		$grid->setSortBy('dossier_upd.vUpd_no');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('vUpd_no','vNama_usulan','iTeam_andev','iKat_dok','rincian_dok');

		//setting widht grid
		$grid ->setWidth('dossier_upd.vUpd_no', '100'); 
		$grid->setWidth('dossier_upd.iTeam_andev', '100'); 
		$grid->setWidth('dossier_upd.iSediaan', '100'); 
		$grid->setWidth('iSemester', '100'); 
		$grid->setWidth('iTahun', '100'); 
		$grid->setWidth('iApprove_upload', '100'); 
		$grid->setWidth('dossier_upd.vNama_usulan', '250'); 
		$grid->setWidth('lDeleted', '100'); 
		
		
		//modif label
		$grid->setLabel('vUpd_no','No UPD'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 

		$grid->setLabel('dossier_upd.vUpd_no','No UPD'); 
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Usulan'); 
		$grid->setLabel('dossier_upd.iTeam_andev','Team Andev'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 

		$grid->setAlign('iSemester','center');
		$grid->setAlign('iTahun','center');

		$grid->setLabel('iSubmit_upload','Status Submit'); 
		$grid->setLabel('iApprove_upload','Status '); 
		$grid->setLabel('iTeam_andev','Team Andev'); 
		$grid->setLabel('iNegara','Negara'); 
		//$grid->setLabel('iApprove_upload','Approve at'); 
		$grid->setLabel('cApprove_upload','Approve by'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 
		$grid->setLabel('iSemester','Semester Prioritas'); 
		$grid->setLabel('iTahun','Tahun Prioritas');
		
		$grid->setLabel('iKat_dok','Kategori Dokumen'); 

		$grid->setFormUpload(TRUE);

		$grid->setSearch('dossier_upd.vUpd_no');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('dossier_upd.iSediaan','combobox','',array(''=>'Pilih','1'=>'Solid','2'=>'Non Solid'));
		$grid->changeFieldType('iApprove_upload','combobox','',array('0'=>'Waiting Approval','1'=>'Rejected','2'=>'Approved'));
		$grid->changeFieldType('iSubmit_upload','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submitted'));
		
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
			}elseif(in_array('TD', $manager)){$type='TD';
				$grid->setQuery('dossier_upd.vpic IN (select vnip from plc2.plc2_upb_team_item where iteam_id in ('.$this->auth_plcexport->my_teams().'))', null);
			}elseif(in_array('AD', $manager)){$type='AD';
				$grid->setQuery('dossier_upd.vpic_andev IN (select vnip from plc2.plc2_upb_team_item where iteam_id in ('.$this->auth_plcexport->my_teams().'))', null);
			}else{}
		}else{
			$x=$this->auth_plcexport->dept();
			$team=$x['team'];
			if(in_array('TD', $team)){
				$type='TD';
				$q="select * from plc2.plc2_upb_team_item it where it.lDeleted=0 and it.vnip='".$this->user->gNIP."'";
				$dt=$this->dbset->query($q);
				if($dt->num_rows()!=0){
					$d=$dt->row_array();
					if($d['iapprove']==1){
						$grid->setQuery('dossier_upd.vpic IN (select vnip from plc2.plc2_upb_team_item where iteam_id in ('.$this->auth_plcexport->my_teams().'))', null);
					}else{
						$grid->setQuery('dossier_upd.vpic IN ("'.$this->user->gNIP.'")', null);
					}
				}else{
					$grid->setQuery('dossier_upd.vpic IN ("'.$this->user->gNIP.'")', null);
				}
			}elseif(in_array('AD', $team)){$type='AD';
				$q="select * from plc2.plc2_upb_team_item it where it.lDeleted=0 and it.vnip='".$this->user->gNIP."'";
				$dt=$this->dbset->query($q);
				if($dt->num_rows()!=0){
					$d=$dt->row_array();
					if($d['iapprove']==1){
						$grid->setQuery('dossier_upd.vpic_andev IN (select vnip from plc2.plc2_upb_team_item where iteam_id in ('.$this->auth_plcexport->my_teams().'))', null);
					}else{
						$grid->setQuery('dossier_upd.vpic_andev IN ("'.$this->user->gNIP.'")', null);
					}
				}else{
					$grid->setQuery('dossier_upd.vpic_andev IN ("'.$this->user->gNIP.'")', null);
				}
			}else{}
		}
		

	//Field mandatori
		$grid->setRequired('iSediaan');	
		$grid->setRequired('iTeam_andev');	
		$grid->setRequired('lDeleted');	

		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id', 'inner');		
		//$grid->setJoinTable('dossier.dossier_prioritas_detail', 'dossier_prioritas_detail.idossier_upd_id = dossier_upd.idossier_upd_id', 'inner');
		//$grid->setJoinTable('dossier.dossier_prioritas', 'dossier_prioritas.idossier_prioritas_id = dossier_prioritas_detail.idossier_prioritas_id', 'inner');
		//$grid->setJoinTable('dossier.dossier_dok_list', 'dossier_dok_list.idossier_review_id = dossier_review.idossier_review_id', 'inner');
		//$grid->setJoinTable('dossier.dossier_dokumen', 'dossier_dokumen.idossier_dokumen_id = dossier_dok_list.idossier_dokumen_id', 'inner');
		//$grid->setJoinTable('dossier.dossier_kat_dok_details', 'dossier_kat_dok_details.idossier_kat_dok_details_id = dossier_dokumen.idossier_kat_dok_details_id', 'inner');
		//$grid->setJoinTable('dossier.dossier_kat_dok', 'dossier_kat_dok.idossier_kat_dok_id = dossier_kat_dok_details.idossier_kat_dok_id', 'inner');

		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_review.lDeleted', 0);
		$grid->setQuery('dossier_review.iApprove_review', 2);
		$grid->setQuery('dossier_review.iApprove_keb != 1',NULL);
		$grid->setQuery('dossier_review.iApprove_review != 1',NULL);
		$grid->setQuery('dossier_review.iApprove_verify != 1',NULL);
		$grid->setQuery('dossier_review.iApprove_confirm != 1',NULL);
		//$grid->setQuery('dossier_review.iApprove_confirm', 0);

		// group by reference hanya 1 field 
		//$grid->setGroupBy('dossier_kat_dok.vNama_Kategori','idossier_review_id');
		

		//$grid->setMultiSelect(true);
		
		//Set View Gridnya (Default = grid)
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
			case 'carinegara':
				$this->carinegara();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				//print_r($this->input->post());exit();
				//echo $grid->updated_form();
				$isUpload = $this->input->get('isUpload');
				$cNip = $this->user->gNIP;
				$tUpdated = date('Y-m-d H:i:s', mktime());		

				$sql = array();
				$sqlce=array();
   				$file_name= "";
				$fileId = array();
				//$path = realpath("files/plc/dossier_dok");
				$path = realpath("files/plc/dossier_dok");
				
				if (!file_exists( $path."/".$this->input->post('idossier_review_id') )) {
					mkdir($path."/".$this->input->post('idossier_review_id'), 0777, true);						 
				}
									
				$file_keterangan = array();
				$namafile = array();
				$cPic = array();
				
				$idossier_dok_list_id = array();
				$idossier_dok_list_file_id = array();
				$idfile=array();
				$sudah=array();
				$doklis_id=array();
				$istatus_keberadaan_update=array();
				foreach($_POST as $key=>$value) {
					if ($key == 'doklis_id') {
						foreach($value as $y=>$u) {
							$doklis_id[] = $y;
						}
					}
					if($key=='fileketerangan'){
						foreach ($value as $kf => $vf) {
							$file_keterangan[$kf]=$vf[0];
							
						}
					}
					if($key=='idossier_dok_list_file_id'){
						foreach ($value as $kf => $vf) {
							$idossier_dok_list_file_id[$kf]=$vf;
						}
					}
					if($key=='sudah'){
						foreach ($value as $kf => $vf) {
							$sudah[$kf]=$vf;
						}
					}
					if($key=='istatus_keberadaan_update'){
						foreach ($value as $kf => $vf) {
							$istatus_keberadaan_update[$kf]=$vf;
						}
					}
				}
				$sq="select * from dossier.dossier_dok_list li where li.lDeleted=0 and li.idossier_review_id=".$this->input->post('idossier_review_id');
				$dtu=$this->dbset->query($sq)->result_array();
				foreach ($dtu as $kdt => $vdt) {
					$dataup['istatus_keberadaan_update']=$vdt['istatus_keberadaan'];
					$this->dbset->where('idossier_dok_list_id',$vdt['idossier_dok_list_id']);
					$this->dbset->update('dossier_dok_list',$dataup);
				}
				$sqlup=array();
				$sqlc=array();
				$sqlupket=array();
				$sqlcek='';
				$ikeb=array();
				//print_r($idossier_dok_list_file_id);exit();
				//print_r($file_keterangan);exit();
				if ($idossier_dok_list_file_id) {
					foreach ($doklis_id as $kdok => $vdok) {
						if(isset($idossier_dok_list_file_id[$vdok])){
							$idfile=implode(',', array_filter($idossier_dok_list_file_id[$vdok]));
							if($idfile!=''){
								$sqlup[]="update dossier.dossier_dok_list_file li set li.lDeleted=1, li.dUpdate='".$tUpdated."', li.cUpdate='".$cNip."' where li.idossier_dok_list_id=".$vdok." and li.idossier_dok_list_file_id not in (".$idfile.")";
							}else{
								$sqlup[]="update dossier.dossier_dok_list_file li set li.lDeleted=1, li.dUpdate='".$tUpdated."', li.cUpdate='".$cNip."' where li.idossier_dok_list_id=".$vdok;
							}
							if(isset($file_keterangan[$vdok])){
								$sqlupket[]="update dossier.dossier_dok_list_file li set li.vKeterangan='".$file_keterangan[$vdok]."' where li.idossier_dok_list_id=".$vdok;
							}
						}else{
							$sqlup[]="update dossier.dossier_dok_list_file li set li.lDeleted=1, li.dUpdate='".$tUpdated."', li.cUpdate='".$cNip."' where li.idossier_dok_list_id=".$vdok;
						}
						$sqlcek="select * from dossier.dossier_dok_list li
							inner join dossier.dossier_dokumen dok on li.idossier_dokumen_id=dok.idossier_dokumen_id
							where li.lDeleted=0 and dok.lDeleted=0 and li.idossier_dok_list_id=".$vdok;
						$dt=$this->dbset->query($sqlcek)->row_array();
						if($dt['iPerlu']==0){
							$sqlc[]="UPDATE dossier.dossier_dok_list SET istatus_keberadaan_update=1 WHERE idossier_dok_list_id=".$vdok;
						}else{
							$cekfile="select * from dossier.dossier_dok_list_file li where li.idossier_dok_list_id=".$vdok." and lDeleted=0";
							$qu=$this->dbset->query($cekfile);
							if($qu->num_rows()>=1){
								$sqlc[]="UPDATE dossier.dossier_dok_list SET istatus_keberadaan_update=1 WHERE  idossier_dok_list_id=".$vdok;
							}else{
								$sqlc[]="UPDATE dossier.dossier_dok_list SET istatus_keberadaan_update=0 WHERE  idossier_dok_list_id=".$vdok;
							}
						}
					}
				}
				//print_r($sqlup);exit();
				foreach($sqlup as $qup) {
					try {
						$this->dbset->query($qup);
					}catch(Exception $e) {
						die($e);
					}
				}

				foreach ($sqlupket as $kupd) {
					try {
						$this->dbset->query($kupd);
					}catch(Exception $e) {
						die($e);
					}
				}
				/*
				foreach ($sqlc as $quc) {
					try {
						$this->dbset->query($quc);
					} catch (Exception $e) {
						die($e);
					}
				}*/
				if(count($istatus_keberadaan_update)>=1){
					foreach ($istatus_keberadaan_update as $kistatus => $vstatus) {
						$datastatus['istatus_keberadaan_update']=1;
						$this->dbset->where('idossier_dok_list_id',$kistatus);
						$this->dbset->update('dossier_dok_list',$datastatus);
					}
				}
				if(count($sudah)>=1){
					foreach ($sudah as $ksudah => $vsudah) {
						$data['istatus_verifikasi']=1;
						$data['iStatus_confirm']=1;
						$data['istatus_keberadaan_update']=1;
						$this->dbset->where('idossier_dok_list_id',$ksudah);
						$this->dbset->update('dossier_dok_list',$data);
					}
				}
				//print_r($sqlc);exit();
				
				$last_index = 0;	
				$jj = $last_index;	
				/*foreach($_POST['iHapus'] as $k=>$v) {
					if ( !empty($iHapus[$jj])) {
						$SQL2 = "UPDATE dossier.dossier_dok_list_file set cUpdate='{$cNip}', dupdate='{$tUpdated}' ,lDeleted='1',cPic=NULL,vFilename=NULL,vKeterangan=NULL where idossier_dok_list_file_id = '{$doklis_file_id[$jj]}'";
						$this->dbset->query($SQL2);

						// update keberadaaan setelah approve 
						//$SQL3 = "UPDATE dossier.dossier_dok_list set cUpdate='{$cNip}', dupdate='{$tUpdated}' ,istatus_keberadaan='0' where idossier_dok_list_id = '{$doklis_id[$jj]}'";
						//$this->dbset->query($SQL3);

					}
					$jj++;	
				}*/


				$j = $last_index;
   				if($isUpload) {

   					foreach ($doklis_id as $kdok => $vdok) {

   						$i=0;
   						if (isset($_FILES['fileupload_'.$vdok])) {

							foreach ($_FILES['fileupload_'.$vdok]["error"] as $key => $error) {	
								if ($error == UPLOAD_ERR_OK) {
									$tmp_name = $_FILES['fileupload_'.$vdok]["tmp_name"][$key];
									$name = $_FILES['fileupload_'.$vdok]["name"][$key];
									$data['filename'] = $name;
									$data['id']=$this->input->post('idossier_review_id');
									$data['nip']=$this->user->gNIP;
									$data['dInsertDate'] = date('Y-m-d H:i:s');
					 				if(move_uploaded_file($tmp_name, $path."/".$this->input->post('idossier_review_id')."/".$name)) 
					 				{
					 					/*

					 					if ( $idossier_dok_list_file_id[$j] != '') {
					 						//update
					 						$sql[] = "UPDATE dossier.dossier_dok_list_file set cUpdate='{$cNip}', dupdate='{$tUpdated}' ,lDeleted='0' , cPic='{$cPic[$j]}', vFilename='{$data['filename']}', vKeterangan='{$file_keterangan[$j]}'  where idossier_dok_list_file_id = '{$idossier_dok_list_file_id[$j]}'	";
					 					
					 						$sql22='select * from dossier.dossier_dok_list_file a where a.idossier_dok_list_file_id ="'.$idossier_dok_list_file_id[$j].'"';
											$data_dok = $this->db_plc0->query($sql22)->row_array();
					 						
					 						$sql_up= "UPDATE dossier.dossier_dok_list set cUpdate='{$cNip}', dupdate='{$tUpdated}' ,istatus_keberadaan='1' where idossier_dok_list_id = '".$data_dok['idossier_dok_list_id']."' ";
											$this->dbset->query($sql_up);

					 					}else{
					 						// insert*/
					 					
										$sql[] = "INSERT INTO dossier_dok_list_file (idossier_dok_list_id, vFilename, vKeterangan,cCreated, dCreate) 
											VALUES ('".$vdok."','".$data['filename']."','".$file_keterangan[$vdok]."','".$data['nip']."','".$data['dInsertDate']."')";
										$i++;	
										/*	$sql_up= "UPDATE dossier.dossier_dok_list set cUpdate='{$cNip}', dupdate='{$tUpdated}' ,istatus_keberadaan='1' where idossier_dok_list_id = '".$idossier_dok_list_id[$j]."' ";
											$this->dbset->query($sql_up);
										}

										
										$j++;*/	

									}
									else{
									echo "Upload ke folder gagal";	
									}
								}
								
							}						
						}
					}	
					//print_r($sql);exit();					
					foreach($sql as $q) {
						try {
							$this->dbset->query($q);
						}catch(Exception $e) {
							die($e);
						}
					}

					/*foreach ($doklis_id as $kdok => $vdok) {
						$sqlcek="select * from dossier.dossier_dok_list li
							inner join dossier.dossier_dokumen dok on li.idossier_dokumen_id=dok.idossier_dokumen_id
							where li.lDeleted=0 and dok.lDeleted=0 and li.idossier_dok_list_id=".$vdok;
						$dt=$this->dbset->query($sqlcek)->row_array();
						if($dt['iPerlu']==0){
							$sqlce[]="UPDATE dossier.dossier_dok_list SET istatus_keberadaan_update=1 WHERE  idossier_dok_list_id=".$vdok;
						}else{
							$cekfile="select * from dossier.dossier_dok_list_file li where li.idossier_dok_list_id=".$vdok." and lDeleted=0";
							$qu=$this->dbset->query($cekfile);
							if($qu->num_rows()>=1){
								$sqlce[]="UPDATE dossier.dossier_dok_list SET istatus_keberadaan_update=1 WHERE  idossier_dok_list_id=".$vdok;
							}else{
								$sqlce[]="UPDATE dossier.dossier_dok_list SET istatus_keberadaan_update=0 WHERE  idossier_dok_list_id=".$vdok;
							}
						}
					}

					foreach ($sqlce as $quce) {
						try {
							$this->dbset->query($quce);
						} catch (Exception $e) {
							die($e);
						}
					}*/
					if(count($istatus_keberadaan_update)>=1){
						foreach ($istatus_keberadaan_update as $kistatus => $vstatus) {
							$datastatus['istatus_keberadaan_update']=1;
							$this->dbset->where('idossier_dok_list_id',$kistatus);
							$this->dbset->update('dossier_dok_list',$datastatus);
						}
					}
					if(count($sudah)>=1){
					foreach ($sudah as $ksudah => $vsudah) {
						$data122['istatus_verifikasi']=1;
						$data122['iStatus_confirm']=1;
						$data122['istatus_keberadaan_update']=1;
						$this->dbset->where('idossier_dok_list_id',$ksudah);
						$this->dbset->update('dossier_dok_list',$data122);
						}
					}
				
					$r['status'] = TRUE;
					$r['message'] = 'Data Berhasil di Update';
					$r['last_id'] = $this->input->post('idossier_review_id');					
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
			case 'verkon':
				$data['istatus_verifikasi']=1;
				$data['iStatus_confirm']=1;
				$this->dbset->where('idossier_dok_list_id',$this->input->post('id'));
				$this->dbset->update('dossier_dok_list',$data);
				$r['status'] = TRUE;
				$r['message'] = 'Data Berhasil di Update';
				$r['last_id'] = $this->input->post('id');					
				echo json_encode($r);
				exit();
				break;
			case 'cekstatusup':
				$post=$this->input->post();
				echo $this->cekstatusup($post);
				exit();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

 
   
 function listBox_Action($row, $actions) {

 	if ($row->iApprove_upload<>0) {
 		// status sudah diapprove or reject , button edit hide 
 		 unset($actions['edit']);
 		 unset($actions['delete']);
 	}
	 return $actions;

 } 


function listBox_dossier_upload_dokumen_iTahun($v,$p,$d,$r) {
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
function listBox_dossier_upload_dokumen_iSemester($v,$p,$d,$r) {
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

function listBox_dossier_upload_dokumen_dossier_upd_iTeam_andev ($value) {
	$q="select * from plc2.plc2_upb_team te where te.iteam_id=".$value;
	$d=$this->dbset->query($q)->row_array();
	return $d['vteam'];
}

function listBox_dossier_upload_dokumen_dossier_upd_iSediaan ($value) {
	if ($value == 1) {
		$sediaan = 'Solid';
	}else{
		$sediaan = 'Injection';
	}

	return $sediaan;
}

/*manipulasi view object form start*/


function updateBox_dossier_upload_dokumen_vUpd_no($field, $id, $value, $rowData) {
	$sql = 'select * from dossier.dossier_upd a where a.idossier_upd_id="'.$rowData['idossier_upd_id'].'" ';
	$data_upd = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];

	}else{

		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];
	}
	
	return $return;
}

function updateBox_dossier_upload_dokumen_vNama_usulan($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vNama_usulan'];

		}
		else{
			$return= $rows['vNama_usulan'];
			$return .= '
			<input type="hidden" name="isdraft" id="isdraft">
			';
		}
		
		return $return;
}

function updateBox_dossier_upload_dokumen_iTeam_andev($field, $id, $value, $rowData) {
	$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
	$q="select * from plc2.plc2_upb_team te where te.iteam_id=".$rows['iTeam_andev'];
	$d=$this->dbset->query($q)->row_array();
	return $d['vteam'];
}

function updateBox_dossier_upload_dokumen_iKat_dok($field, $id, $value, $rowData) {
	$url_rincian = base_url()."processor/plc/partial/view/export?action=getdokwithkat"; 
		if ($this->input->get('action') == 'view') {
			$return= "All";

		}
		else{
			    	$sql = "select * 
							from dossier.dossier_kat_dok a 
							where a.lDeleted=0";
			    	$kats = $this->db_plc0->query($sql)->result_array();
			    	$return = '<select name="'.$id.'" id="'.$id.'">';
			    	$return .= '<option value="">Select One</option>';
			    	foreach($kats as $t) {
			    		$return .= '<option value="'.$t['idossier_kat_dok_id'].'">'.$t['vNama_Kategori'].'</option>';
			    	}
			    	$return .= '</select>';
			    	

			    	$return .= '<input type="hidden" class="required" name="idossier_upd_id" value="'.$rowData['idossier_upd_id'].'"  readonly="readonly" id="idossier_upd_id" />';
			    	$return .= '<input type="hidden" class="required" name="idossier_review_id" value="'.$rowData['idossier_review_id'].'"  readonly="readonly" id="idossier_review_id" />';


			    	$return .='<script>
							 	$("#'.$id.'").change(function()
							 	{


							 		$.ajax({
									     url: "'.$url_rincian.'", 
									     type: "POST", 
									     data: {iKat_dok:$(this).val() ,idossier_review_id:$("#idossier_review_id").val() ,idossier_upd_id:$("#idossier_upd_id").val()}, 
									     success: function(response){
									         $("#rincian_upload_dok_export").html(response);
									     }

									});

							 	});
								</script>';	



		}
		
		return $return;
}



function updateBox_dossier_upload_dokumen_cApprove_upload($field, $id, $value, $rowData) {
	
	

		if ($rowData['iApprove_upload'] <> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cApprove_upload']))->row_array();

			if ($rowData['iApprove_upload'] == 2) {
				$palue='Approved by '.$rows['vName'].', Remark :'.$rowData['vRemark_upload'] ;	
			}else{
				$palue='Rejected by '.$rows['vName'].', Remark :'.$rowData['vRemark_upload'];	
			}
			
		}else{
			$palue='Waiting Approval';
		}

		if ($this->input->get('action') == 'view') {
			$return= $palue;

		}
		else{
			$return= $palue;
		}
		
		return $return;
}

function updateBox_dossier_upload_dokumen_iApprove_upload($field, $id, $value, $rowData) {
		if ($rowData['iApprove_upload'] <> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cApprove_upload']))->row_array();

			if ($rowData['iApprove_upload'] == 2) {
				$palue='Approved by '.$rows['vName'].' pada '.$rowData['dApprove_upload'].', Remark :'.$rowData['vRemark_upload'] ;	
				//$palue='Approved by '.$rows['vName'].', Remark :'.$rowData['vRemark_upload'] ;	
			}else{
				//$palue='Rejected by '.$rows['vName'].', Remark :'.$rowData['vRemark_upload'];	
				$palue='Rejected by '.$rows['vName'].' pada '.$rowData['dApprove_upload'].', Remark :'.$rowData['vRemark_upload'];	
			}
			
		}else{
			$palue='Waiting Approval';
		}

		if ($this->input->get('action') == 'view') {
			$return= $palue;

		}
		else{
			$return= $palue;
		}
		
		return $return;
}

function updateBox_dossier_upload_dokumen_rincian_dok($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
		//$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>'13'))->row_array();
		//$return1= print_r($rows);
		$data['iTeam_andev']=$rows['iTeam_andev'];
		$data['rows'] = $rows;
		$data['iSediaan'] = $rows['iSediaan'];
		$data['idossier_upd_id'] =  $rows['idossier_upd_id'];

		$sql_negara="select * from dossier.dossier_upd_negara ne 
		inner join dossier.dossier_negara neg on neg.idossier_negara_id = ne.idossier_negara_id
		where ne.lDeleted=0 and ne.idossier_upd_id=".$rowData['idossier_upd_id'];
		$data['mnnegara'] = $this->db_plc0->query($sql_negara)->result_array();

		$sql_doc='select * ,b.idossier_dok_list_id as id_doklis,d.iSubmit_upload,b.vKeterangan_review
					from dossier.dossier_dokumen a 
					left join dossier.dossier_dok_list b on b.idossier_dokumen_id=a.idossier_dokumen_id 
					join dossier.dossier_review d on d.idossier_review_id=b.idossier_review_id
					left join dossier.dossier_dok_list_file c on c.idossier_dok_list_id =b.idossier_dok_list_id
					join dossier.dossier_kat_dok_details det on det.idossier_kat_dok_details_id=a.idossier_kat_dok_details_id
					join dossier.dossier_kat_dok e on e.idossier_kat_dok_id = det.idossier_kat_dok_id
					join dossier.dossier_upd u on d.idossier_upd_id=u.idossier_upd_id
					where a.lDeleted=0
					and b.lDeleted=0
					and e.lDeleted=0
					and u.lDeleted=0
					#and if(c.idossier_dok_list_file_id is not null,c.lDeleted = 0,b.lDeleted=0)
					and b.idossier_review_id="'.$rowData['idossier_review_id'].'"
					group by b.idossier_dok_list_id
					order by det.vsubmodul_kategori, a.iurut_dokumen ASC
					';
		$dt = $this->db_plc0->query($sql_doc)->result_array();
		$dat=array();
		foreach ($dt as $kdt => $vdt) {
			$dat[$kdt][$vdt['idossier_negara_id']]=$vdt;
		}
		$data['datadok']=$dat;
		//$data['row']=$this->db_plc0->query($sql_doc)->result_array();
		$return = '<div id="rincian_upload_dok_export">';
			$return.=  $this->load->view('dossier_upload_dokumen',$data,TRUE);
		$return.= '</div>';
		return $return;
		
}


function after_update_processor($row, $insertId, $postData, $old_data) {
		$logged_nip =$this->user->gNIP;
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.C_ITENO,c.C_ITNAM,d.vName,b.dTanggal_upd,a.iSubmit_upload
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.itemas c on c.C_ITENO=b.iupb_id 
				join hrd.employee d on d.cNip=b.cNip_pengusul
				where a.idossier_review_id = '".$insertId."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();
		$submit = $rupd['iSubmit_upload'] ;

		$q="select * from plc2.plc2_upb_team te where te.iteam_id in (".$rupd['ad'].")";
		$d=$this->dbset->query($q)->row_array();
		$iTeam_andev=$d['vteam'];
		$sudah=array();
		foreach($postData as $key=>$value) {

			if($key=='sudah'){
				foreach ($value as $kf => $vf) {
					$sudah[$kf]=$vf;
				}
			}
		}
		if(count($sudah)>=1){
			foreach ($sudah as $ksudah => $vsudah) {
				$isudah[]=$ksudah;
			}
			$is=implode(',',$isudah);
			$sql_dok="select * from dossier.dossier_dok_list li 
				inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=li.idossier_dokumen_id
				where li.lDeleted=0 and dok.lDeleted=0 and li.idossier_dok_list_id in (".$is.")";
			$data_dok=$this->dbset->query($sql_dok)->result_array();
			$ad = $rupd['ad'];
			$team = $ad;
			//$team = '81' ;
			/*
	        $toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_team( $team );
	        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
	        //$arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
	        $arrEmail = $this->lib_utilitas->get_email_by_nip( $logged_nip );                    
	                    
			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($toEmail);
				$to = $toEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
				}
			}	

			//$to = $toEmail2.';'.$toEmail;
			//$cc = $arrEmail;                        
			*/
			$vkode="";
			if ($rupd['ad'] == 17) {
				$iTeamandev = 'Andev Export 1';
				$vkode="UPLOAD_UPD_TD1";
			}else{
				$iTeamandev = 'Andev Export 2';
				$vkode="UPLOAD_UPD_TD2";
			}
			$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
			$dt=$this->dbset->query($sql)->row_array();
			$to = $dt['tto'];
			$cc = $dt['tcc'];                         

				$subject="Upload Dokumen: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada inputan Upload Dokumen UPD  pada aplikasi PLC - Export dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>No UPD</b></td><td style='width: 20px;'> : </td><td>".$rupd['vUpd_no']."</td>
							</tr>
							<tr>
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Tanggal UPD</b></td><td> : </td><td>".$rupd['dTanggal_upd']."</td>
							</tr>
							<tr>
								<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['cNip_pengusul'].' - '.$rupd['vName']."</td>
							</tr>
							<tr>
								<td><b>Produk</b></td><td> : </td><td>".$rupd['C_ITENO'].' - '.$rupd['C_ITNAM']."</td>
							</tr>
							<tr>
								<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
							</tr>
							<tr>
								<td><b>Dokumen Yang Sudah di Submit</b></td><td> : </td><td></td>
							</tr>
							<tr>
								<td colspan=3>
								<table border='1px' style='border-collapse:collapse;width:100%;border:1px;'>
									<tr>
									 		<th>No</th>
									 		<th>Nama Dokumen</th>
									 	</tr>";
					$no=1;
					foreach ($data_dok as $kdok => $vdokumen) {
						$content.= "<tr><td>".$no."</td><td>".$vdokumen['vNama_Dokumen']."</td></tr>";
						$no++;
					}


					$content.="</table>
								</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}

		
}

function cekstatusup($post){
	$data['status']=FALSE;
	$sqlcek="select * from dossier.dossier_dok_list li
				inner join dossier.dossier_dokumen dok on li.idossier_dokumen_id=dok.idossier_dokumen_id
				where li.lDeleted=0 and dok.lDeleted=0 and li.idossier_dok_list_id=".$post['id_doklis'];
	$dt=$this->dbset->query($sqlcek)->row_array();
	if($dt['istatus_keberadaan_update']==0){	
		if($dt['iPerlu']==0){ //JIka perlu dokumen maka status upload tidak tampil
			$data['status']=TRUE;
			$data['message']='File Tersedia';
		}else{
			$data['status']=FALSE;
		}
	}else{
		$data['message']='File Tersedia';
		$data['status']=TRUE;

	}
	$return=json_encode($data);
	return $return;
}

/*function pendukung start*/  
function before_update_processor($row, $postData) {

	// ubah status submit
		if($postData['isdraft']==true){
			$postData['iSubmit_upload']=0;
		} 
		else{$postData['iSubmit_upload']=1;} 
	
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	

	return $postData;

}

function manipulate_update_button($buttons, $rowData) {
	$cNip= $this->user->gNIP;
	$field='dossier_upload_dokumen';
	$data['field']=$field;
	$js = $this->load->view('dossier_upload_dokumen_js',$data,TRUE);
	$js .= $this->load->view('uploadjs');

	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/dossier/upload/dokumen?action=approve&idossier_review_id='.$rowData['idossier_review_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_dossier_upload_dokumen">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/dossier/upload/dokumen?action=reject&idossier_review_id='.$rowData['idossier_review_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_dossier_upload_dokumen">Reject</button>';

	$update = '<button onclick="javascript:update_btn_back(\'dossier_upload_dokumen\', \''.base_url().'processor/plc/dossier/upload/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_dossier_upload_dokumen">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'dossier_upload_dokumen\', \''.base_url().'processor/plc/dossier/upload/dokumen?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_draft_dossier_upload_dokumen">Update as Draft</button>';
	$browse = '<button class="ui-button-text icon_pop" onclick="javascript:load_browse_dossier_upload_'.$field.'(\''.base_url().'processor/plc/dossier/upload/list/folder?field=distribusi_request\',\'Folder LIST\',\'SAVE\',\'button_pilih_'.$field.'\')" type="button">Browse</button>';


	$sql_cek_verify='select * 
					from dossier.dossier_review a
					join dossier.dossier_dok_list b on b.idossier_review_id=a.idossier_review_id
					where a.idossier_review_id="'.$rowData['idossier_review_id'].'" 
					and (b.istatus_keberadaan_update = 0 or b.iStatus_kelengkapan4!=2)';
	$data_verify = $this->dbset->query($sql_cek_verify)->result_array();					


	if ($this->input->get('action') == 'view') {unset($buttons['update']);}

	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if ($rowData['iSubmit_upload']== 0) {
			// jika masih draft , show button update draft & update submit 
				// cek sudah verifikasi semua belum , kalau belum ceklis maka tombol draft saja 
				if (empty($data_verify)) {
					// sudah ceklist verify semua
					$buttons['update'] = $update.$updatedraft.$js;		
				}else{
					$buttons['update'] = $updatedraft.$js;		
					
				}
			
		}else{
			// sudah disubmit , show button approval 
			//$buttons['update'] = $approve.$reject.$js;
		}


		//$buttons['update'] = $update.$updatedraft.$approve.$reject.$js;
	}
	if($this->user->gNIP=='N15748'){
		$buttons['update']=$buttons['update'].$browse;
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
								var url = "'.base_url().'processor/plc/dossier/upload/dokumen";								
								if(o.status == true) {
									
									
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_dossier_upload_dokumen").html(data);
										$("#button_approve_dossier_upload_dokumen").hide();
										$("#button_reject_dossier_upload_dokumen").hide();
									});
									
								}
									reload_grid("grid_dossier_upload_dokumen");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_dossier_upload_dokumen_approve" action="'.base_url().'processor/plc/dossier/upload/dokumen?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_review_id" value="'.$this->input->get('idossier_review_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark_upload"></textarea>
		<button type="button" onclick="submit_ajax(\'form_dossier_upload_dokumen_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_review_id = $post['idossier_review_id'];
		$vRemark_upload = $post['vRemark_upload'];

		$data=array('iApprove_upload'=>'2','cApprove_upload'=>$cNip , 'iApprove_upload'=>date('Y-m-d H:i:s'), 'vRemark_upload'=>$vRemark_upload);
		$this -> db -> where('idossier_review_id', $idossier_review_id);
		$updet = $this -> db -> update('dossier.dossier_review', $data);



		$logged_nip =$this->user->gNIP;
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.C_ITENO,c.C_ITNAM,d.vName,b.dTanggal_upd,a.iSubmit_confirm
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.itemas c on c.C_ITENO=b.iupb_id 
				join hrd.employee d on d.cNip=b.cNip_pengusul
				where a.idossier_review_id = '".$idossier_review_id."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

	
		$submit = $rupd['iSubmit_confirm'] ;
		$q="select * from plc2.plc2_upb_team te where te.iteam_id in (".$rupd['ad'].")";
		$d=$this->dbset->query($q)->row_array();
		return $d['vteam'];

		if ($updet == 1) {
			
			//jika approve , update status keberadaan dokumen jadi 1
			$SQL3 = "UPDATE dossier.dossier_dok_list set cUpdate='{$cNip}', dupdate='{$tUpdated}' ,istatus_keberadaan_update='1' where idossier_review_id = '{$idossier_review_id}'";
			$this->dbset->query($SQL3);					

			$ad = $rupd['ad'];

			//$team = $dr ;
			$team = $ad;
			//$team = '81' ;

	        $toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_team( $team );
	        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
	        //$arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
	        $arrEmail = $this->lib_utilitas->get_email_by_nip( $logged_nip );                    
	                    
			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($toEmail);
				$to = $toEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
				}
			}	

			//$to = $toEmail2.';'.$toEmail;
			//$cc = $arrEmail;                        

			$to = $arrEmail;
			$cc = $toEmail2.';'.$toEmail;                        

				$subject="Approval Upload Dokumen: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada approval Upload Dokumen UPD  pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>No UPD</b></td><td style='width: 20px;'> : </td><td>".$rupd['vUpd_no']."</td>
							</tr>
							<tr>
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Tanggal UPD</b></td><td> : </td><td>".$rupd['dTanggal_upd']."</td>
							</tr>
							<tr>
								<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['cNip_pengusul'].' - '.$rupd['vName']."</td>
							</tr>
							<tr>
								<td><b>Produk</b></td><td> : </td><td>".$rupd['C_ITENO'].' - '.$rupd['C_ITNAM']."</td>
							</tr>
							<tr>
								<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}

		$data['status']  = true;
		$data['last_id'] = $post['idossier_review_id'];
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_dossier_upload_dokumen_vRemark_upload").val();
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
								var url = "'.base_url().'processor/plc/dossier/upload/dokumen";															
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_dossier_upload_dokumen").html(data);
										 $("#button_approve_dossier_upload_dokumen").hide();
										$("#button_reject_dossier_upload_dokumen").hide();
									});
									
								}
									reload_grid("grid_dossier_upload_dokumen");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_dossier_upload_dokumen_reject" action="'.base_url().'processor/plc/dossier/upload/dokumen?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_review_id" value="'.$this->input->get('idossier_review_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark_upload" id="reject_dossier_upload_dokumen_vRemark_upload"class="required" required="required"></textarea>
		<button type="button" onclick="submit_ajax(\'form_dossier_upload_dokumen_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	
	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_review_id = $post['idossier_review_id'];
		$vRemark_upload = $post['vRemark_upload'];

		$data=array('iApprove_upload'=>'1','cApprove_upload'=>$cNip , 'iApprove_upload'=>date('Y-m-d H:i:s'), 'vRemark_upload'=>$vRemark_upload);
		$this -> db -> where('idossier_review_id', $idossier_review_id);
		$updet = $this -> db -> update('dossier.dossier_review', $data);


		$data['status']  = true;
		$data['last_id'] = $post['idossier_review_id'];
		return json_encode($data);
	}

	function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/dossier_dok/'.$id.'/'.$name);	
		force_download($name, $path);
	}

/*function pendukung end*/    	

	

	public function output(){
		$this->index($this->input->get('action'));
	}

}

