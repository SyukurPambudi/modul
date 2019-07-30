<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class stabilita_non_terbalik extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Stabilita');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_stabilita_non_terbalik');		
		$grid->setUrl('stabilita_non_terbalik');
		$grid->addList('dossier_upd.vUpd_no','dossier_upd.vNama_usulan','plc2_upb_formula.vkode_surat','iBatch_no','dossier_stabilita_non_terbalik_item.iNumber_ke','dossier_stabilita_non_terbalik_item.iSubmit','dossier_stabilita_non_terbalik_item.iApprove');
		$grid->setSortBy('dossier_stabilita_non_terbalik_item.iNumber_ke');
		$grid->setSortOrder('desc'); //sort ordernya
		$grid->setSearch('dossier_upd.vUpd_no','dossier_upd.vNama_usulan','iBatch_no','dossier_stabilita_non_terbalik_item.iNumber_ke');
		$grid->addFields('iNumber_ke','iBatch_no','idossier_upd_id','vNama_usulan','dosis','vSediaan','vupb_ref','vRealtime','vAccelerated','fRealtime','fAccelerate','histori','iSucced');

		//setting widht grid
		$grid->setWidth('dossier_stabilita_non_terbalik_item.iSubmit', '-5'); 
		$grid->setWidth('dossier_upd.vUpd_no', '80'); 
		$grid->setWidth('dossier_upd.vNama_usulan', '150'); 
		$grid->setWidth('iBatch_no', '80'); 
		$grid->setWidth('dossier_stabilita_non_terbalik_item.iNumber_ke', '120'); 
		$grid->setWidth('plc2_upb_formula.vkode_surat', '150'); 
		$grid->setWidth('iSucced','150');
		$grid->setWidth('dossier_stabilita_non_terbalik_item.iApprove','-5');
		
		//modif label
		$grid->setLabel('dossier_upd.vUpd_no','No Dossier'); 
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Produk'); 
		$grid->setLabel('iBatch_no','No Batch'); 
		$grid->setLabel('dossier_stabilita_non_terbalik_item.iNumber_ke','Stabilita Bulan Ke'); 
		$grid->setLabel('iNumber_ke','Stabilita Bulan Ke'); 
		$grid->setLabel('plc2_upb_formula.vkode_surat','No Formula'); 
		$grid->setLabel('idossier_upd_id','No Dossier');
		$grid->setLabel('vNama_usulan','Nama Produk');
		$grid->setLabel('dosis','Kekuatan');
		$grid->setLabel('vSediaan','Sediaan');
		$grid->setLabel('vupb_ref','UPB Referensi');
		$grid->setLabel('iBatch_no','Nomor Batch');
		$grid->setLabel('vRealtime','Realtime Test');
		$grid->setLabel('vAccelerated','Accelerated Test');
		$grid->setLabel('iSucced', 'Status Stabilita');
		$grid->setLabel('fRealtime', 'File Realtime');
		$grid->setLabel('fAccelerate','File Accelerated');
		$grid->setLabel('histori', 'Histori');
		$grid->setLabel('dossier_stabilita_non_terbalik_item.iApprove','Status Approval');

		$grid->setFormUpload(TRUE);

		//$grid->setSearch('vNo_req_komparator','dossier_upd.vUpd_no','plc2_upb_team.vteam','iDok_Submit');
		$grid->setRequired('iNumber_ke');
		$grid->setRequired('idossier_upd_id');
		$grid->setRequired('vRealtime');
		$grid->setRequired('vAccelerated');
		$grid->setRequired('iBatch_no');
		$grid->setRequired('iSucced');
		$grid->setRequired('fRealtime');
		$grid->setRequired('fAccelerate');
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		//$grid->changeFieldType('iDok_Submit','combobox','',array(''=> 'Pilih',0=>'Draft - Need to be Publish',1=>'Submited'));
		$grid->changeFieldType('iBatch_no','combobox','',array(''=> 'Pilih',1=>'Batch 1',2=>'Batch 2',3=>'Batch 3'));
		$grid->changeFieldType('iSucced','combobox','',array(''=> 'Pilih',0=>'Tidak Memenuhi',1=>'Memenuhi Syarat'));
		$grid->changeFieldType('dossier_stabilita_non_terbalik_item.iApprove','combobox','',array(''=>'Pilih',0=> 'Waiting Approval',1=>'Reject', 2=>'Approved'));

		//$grid->setGroupBy('idossier_upd_id');

	//Field mandatori
		//$grid->setRequired('vNo_req_komparator');
			$grid->setQuery('dossier_stabilita_non_terbalik_item.iApprove !=2', NULL);
			$grid->setQuery('dossier_stabilita_non_terbalik.lDeleted',0);
			//$grid->setGroupBy('idossier_review_id');
		
		//join table
		$grid->setJoinTable('dossier.dossier_stabilita_non_terbalik_item','dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id=dossier_stabilita_non_terbalik.idossier_stabilita_non_terbalik_id','inner');
		$grid->setJoinTable('dossier.dossier_review', 'dossier_review.idossier_review_id = dossier_stabilita_non_terbalik.idossier_review_id', 'inner');
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = dossier_upd.iupb_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_formula', 'plc2_upb_formula.iupb_id = plc2_upb.iupb_id', 'left');

		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_upd.lDeleted', 0);

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
				$post=$this->input->post();
				$id_review = $_POST['stabilita_non_terbalik_idossier_review_id'];
				$iNumber_ke=$_POST['iNumber_ke'];
				$iBatch_no=$_POST['stabilita_non_terbalik_iBatch_no'];
   				if($isUpload) {
   					$lastId=$this->input->get('lastId');
					$path = realpath("files/plc/dossier_dok");
					if(!file_exists($path."/".$id_review)){
						if (!mkdir($path."/".$id_review, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
					}

					//Upload untuk realtime	

					$fKeterangan_realtime = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'realtime_stabilita_non_terbalik_fileketerangan') {
							foreach($value as $k=>$v) {
								$fKeterangan_realtime[$k] = $v;
							}
						}
					}
					$sqli="select lis.* from dossier.dossier_dok_list lis
							inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=lis.idossier_dokumen_id
							inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=dok.idossier_kat_dok_id
							inner join dossier.dossier_review rev on rev.idossier_review_id=lis.idossier_review_id
							where lis.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0
							and dok.vNama_Dokumen='RT ".$iNumber_ke." (Batch ".$iBatch_no.") Non' and lis.istatus_verifikasi=0 and lis.iStatus_confirm=0";
					$q=$this->dbset->query($sqli);
					$sql=array();
					$updt=array();

					if($q->num_rows()>=1){
						
						foreach ($q->result_array() as $kq => $vq) {
							$r="realtime_stabilita_non_terbalik_".$vq['idossier_dok_list_id']."_fileupload";
							$updt[]="UPDATE dossier.dossier_dok_list SET istatus_keberadaan=1 WHERE idossier_dok_list_id=".$vq['idossier_dok_list_id'];
							if(isset($_FILES[$r])){
								$i=0;
								foreach ($_FILES[$r]["error"] as $key => $error) {
									if ($error == UPLOAD_ERR_OK) {
										$tmp_name = $_FILES[$r]["tmp_name"][$key];
										$name =$_FILES[$r]["name"][$key];
										$data['filename'] = $name;
										$data['dInsertDate'] = date('Y-m-d H:i:s');

											if(move_uploaded_file($tmp_name, $path."/".$id_review."/".$name)) {
												$sql[]="INSERT INTO dossier.dossier_dok_list_file (idossier_dok_list_id, vFilename, vKeterangan, dCreate, cCreated) 
														VALUES (".$vq['idossier_dok_list_id'].",'".$data['filename']."','".$fKeterangan_realtime[$vq['idossier_dok_list_id']][$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
												$i++;	
											}
											else{
												echo "Upload ke folder gagal";	
											}
									}
								}
							}
						}

						foreach ($updt as $kup) {
							try {
								$this->dbset->query($kup);
							} catch (Exception $e) {
								die($e);
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

					//Upload untuk Accelerate
					$fKeterangan_accelerate = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'accelerate_stabilita_non_terbalik_fileketerangan') {
							foreach($value as $k=>$v) {
								$fKeterangan_accelerate[$k] = $v;
							}
						}
					}
					
					$sqliac="select lis.* from dossier.dossier_dok_list lis
							inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=lis.idossier_dokumen_id
							inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=dok.idossier_kat_dok_id
							inner join dossier.dossier_review rev on rev.idossier_review_id=lis.idossier_review_id
							where lis.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0
							and dok.vNama_Dokumen='ACC ".$iNumber_ke." (Batch ".$iBatch_no.") Non' and lis.istatus_verifikasi=0 and lis.iStatus_confirm=0";
					$qac=$this->dbset->query($sqliac);
					$sqlac=array();
					$updtac=array();

					if($qac->num_rows()>=1){
						foreach ($qac->result_array() as $kqac => $vqac) {
							$rac="accelerate_stabilita_non_terbalik_".$vqac['idossier_dok_list_id']."_fileupload";
							$updtac[]="UPDATE dossier.dossier_dok_list SET istatus_keberadaan=1 WHERE idossier_dok_list_id=".$vqac['idossier_dok_list_id'];
							if(isset($_FILES[$rac])){
								$i=0;
								foreach ($_FILES[$rac]["error"] as $key => $error) {
									if ($error == UPLOAD_ERR_OK) {
										$tmp_nameac = $_FILES[$rac]["tmp_name"][$key];
										$nameac =$_FILES[$rac]["name"][$key];
										$data['filenameac'] = $nameac;
										$data['dInsertDate'] = date('Y-m-d H:i:s');

											if(move_uploaded_file($tmp_nameac, $path."/".$id_review."/".$nameac)) {
												$sqlac[]="INSERT INTO dossier.dossier_dok_list_file (idossier_dok_list_id, vFilename, vKeterangan, dCreate, cCreated) 
														VALUES (".$vqac['idossier_dok_list_id'].",'".$data['filenameac']."','".$fKeterangan_accelerate[$vqac['idossier_dok_list_id']][$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
												$i++;	
											}
											else{
												echo "Upload ke folder gagal";	
											}
									}
								}
							}
						}

						foreach ($updtac as $kupac) {
							try {
								$this->dbset->query($kupac);
							} catch (Exception $e) {
								die($e);
							}
						}
						
						foreach($sqlac as $qac) {
							try {
							$this->dbset->query($qac);
							}catch(Exception $e) {
							die($e);
							}
						}

					}

   					$rt['message']="Data Berhasil Disimpan";
					$rt['status'] = TRUE;
					$rt['last_id'] = $this->input->get('lastId');					
					echo json_encode($rt);
   				}else{

   					//Cek Id review dan Batch Telah ada pada stabilita
   					$sqlcek="select * from dossier.dossier_stabilita_non_terbalik sta
						where sta.idossier_review_id='".$id_review."' and sta.iBatch_no='".$iBatch_no."' and sta.lDeleted=0";
					$qcek=$this->dbset->query($sqlcek);
					if($qcek->num_rows()>=1){
						$r['status'] = FALSE;
						$r['message'] = "Data UPD dan Batch Sudah Terdaftar!";
						echo json_encode($r);exit();
					}else{

						//UPDATE Untuk Real time
	   					$sqli="select lis.* from dossier.dossier_dok_list lis
								inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=lis.idossier_dokumen_id
								inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=dok.idossier_kat_dok_id
								inner join dossier.dossier_review rev on rev.idossier_review_id=lis.idossier_review_id
								where lis.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0
								and dok.vNama_Dokumen='RT ".$iNumber_ke." (Batch ".$iBatch_no.") Non' and lis.istatus_verifikasi=0 and lis.iStatus_confirm=0";
						$q=$this->dbset->query($sqli);
						$sqlup=array();
						foreach($_POST as $key=>$value) {						
							if ($key == 'realtime_stabilita_non_terbalik_fileid') {
								foreach($value as $k=>$v) {
									$fileid[$k] = $v;
								}
							}
						}
						$sq=array();
						$sq1=array();
						if($q->num_rows()>=1){
							foreach ($q->result_array() as $kq => $vq) {
								foreach ($fileid as $kf => $vkf) {
									if($kf==$vq['idossier_dok_list_id']){
										$sq[$kf]=$vkf;
									}
								}
							}
							foreach ($sq as $kql => $vql) {
								$dt=array();
								foreach ($vql as $kkk => $vvv) {
									$dt[]=$vvv;
								}
								$dt=array_values(array_filter($dt));
								if(count($dt)!=0){
									$sq1[$kql]=implode(",", $dt);
								}
								
							}
							if(count($sq1)!=0){
								foreach ($sq1 as $ksq1 => $vql) {
									$id[]="UPDATE dossier.dossier_dok_list_file SET lDeleted=1 WHERE idossier_dok_list_id=".$ksq1." and idossier_dok_list_file_id not in (".$vql.")";
								}
								foreach($id as $qid) {
									try {
									$this->dbset->query($qid);
									}catch(Exception $e) {
									die($e);
									}
								}
							}
						}

						//UPDATE Untuk Accelerate
	   					$sqli="select lis.* from dossier.dossier_dok_list lis
								inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=lis.idossier_dokumen_id
								inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=dok.idossier_kat_dok_id
								inner join dossier.dossier_review rev on rev.idossier_review_id=lis.idossier_review_id
								where lis.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0
								and dok.vNama_Dokumen='ACC ".$iNumber_ke." (Batch ".$iBatch_no.") Non' and lis.istatus_verifikasi=0 and lis.iStatus_confirm=0";
						$q=$this->dbset->query($sqli);
						$sqlup=array();
						foreach($_POST as $key=>$value) {						
							if ($key == 'accelerate_stabilita_non_terbalik_fileid') {
								foreach($value as $k=>$v) {
									$fileid[$k] = $v;
								}
							}
						}
						$sq=array();
						$sq1=array();
						if($q->num_rows()>=1){
							foreach ($q->result_array() as $kq => $vq) {
								foreach ($fileid as $kf => $vkf) {
									if($kf==$vq['idossier_dok_list_id']){
										$sq[$kf]=$vkf;
									}
								}
							}
							foreach ($sq as $kql => $vql) {
								$dt=array();
								foreach ($vql as $kkk => $vvv) {
									$dt[]=$vvv;
								}
								$dt=array_values(array_filter($dt));
								if(count($dt)!=0){
									$sq1[$kql]=implode(",", $dt);
								}
								
							}
							if(count($sq1)!=0){
								foreach ($sq1 as $ksq1 => $vql) {
									$id[]="UPDATE dossier.dossier_dok_list_file SET lDeleted=1 WHERE idossier_dok_list_id=".$ksq1." and idossier_dok_list_file_id not in (".$vql.")";
								}
								foreach($id as $qid) {
									try {
									$this->dbset->query($qid);
									}catch(Exception $e) {
									die($e);
									}
								}
							}
						}
	   					echo $grid->saved_form();
	   				}
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
				$id_review = $_POST['stabilita_non_terbalik_idossier_review_id'];
				$iNumber_ke=$_POST['iNumber_ke'];
				$iBatch_no=$_POST['iBatch_no'];
				$path = realpath("files/plc/dossier_dok");
				if(!file_exists($path."/".$id_review)){
					if (!mkdir($path."/".$id_review, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
				$fKeterangan_realtime = array();
				$fileid=array();

				$fKeterangan_accelerate=array();
				$fileid_acc=array();

				foreach($_POST as $key=>$value) {						
					if ($key == 'realtime_stabilita_non_terbalik_fileketerangan') {
						foreach($value as $k=>$v) {
							$fKeterangan_realtime[$k] = $v;
						}
					}
					if ($key == 'realtime_stabilita_non_terbalik_fileid') {
						foreach($value as $k=>$v) {
							$fileid[$k] = $v;
						}
					}
					if ($key == 'accelerate_stabilita_non_terbalik_fileketerangan') {
						foreach($value as $k=>$v) {
							$fKeterangan_accelerate[$k] = $v;
						}
					}
					if ($key == 'accelerate_stabilita_non_terbalik_fileid') {
						foreach($value as $k=>$v) {
							$fileid_acc[$k] = $v;
						}
					}
				}
				if($isUpload) {

					//Update Realtime
					$sqli="select lis.* from dossier.dossier_dok_list lis
							inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=lis.idossier_dokumen_id
							inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=dok.idossier_kat_dok_id
							inner join dossier.dossier_review rev on rev.idossier_review_id=lis.idossier_review_id
							where lis.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0
							and dok.vNama_Dokumen='RT ".$iNumber_ke." (Batch ".$iBatch_no.") Non' and lis.istatus_verifikasi=0 and lis.iStatus_confirm=0";
					$q=$this->dbset->query($sqli);
					$sql=array();
					$updt=array();
					if($q->num_rows()>=1){
						foreach ($q->result_array() as $kq => $vq) {
							$r="realtime_stabilita_non_terbalik_".$vq['idossier_dok_list_id']."_fileupload";
							$updt[]="UPDATE dossier.dossier_dok_list SET istatus_keberadaan=1 WHERE idossier_dok_list_id=".$vq['idossier_dok_list_id'];
							if(isset($_FILES[$r])){
								$i=0;
								foreach ($_FILES[$r]["error"] as $key => $error) {
									if ($error == UPLOAD_ERR_OK) {
										$tmp_name = $_FILES[$r]["tmp_name"][$key];
										$name =$_FILES[$r]["name"][$key];
										$data['filename'] = $name;
										$data['dInsertDate'] = date('Y-m-d H:i:s');

											if(move_uploaded_file($tmp_name, $path."/".$id_review."/".$name)) {
												$sql[]="INSERT INTO dossier.dossier_dok_list_file (idossier_dok_list_id, vFilename, vKeterangan, dCreate, cCreated) 
														VALUES (".$vq['idossier_dok_list_id'].",'".$data['filename']."','".$fKeterangan_realtime[$vq['idossier_dok_list_id']][$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
												$i++;	
											}
											else{
												echo "Upload ke folder gagal";	
											}
									}
								}
							}
						}

						foreach ($updt as $kup) {
							try {
								$this->dbset->query($kup);
							} catch (Exception $e) {
								die($e);
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

					//update accelerate
					$sqliacc="select lis.* from dossier.dossier_dok_list lis
							inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=lis.idossier_dokumen_id
							inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=dok.idossier_kat_dok_id
							inner join dossier.dossier_review rev on rev.idossier_review_id=lis.idossier_review_id
							where lis.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0
							and dok.vNama_Dokumen='ACC ".$iNumber_ke." (Batch ".$iBatch_no.") Non' and lis.istatus_verifikasi=0 and lis.iStatus_confirm=0";
					$qacc=$this->dbset->query($sqliacc);
					$sqlacc=array();
					$updtacc=array();
					if($qacc->num_rows()>=1){
						foreach ($qacc->result_array() as $kqacc => $vqacc) {
							$racc="accelerate_stabilita_non_terbalik_".$vqacc['idossier_dok_list_id']."_fileupload";
							$updtacc[]="UPDATE dossier.dossier_dok_list SET istatus_keberadaan=1 WHERE idossier_dok_list_id=".$vqacc['idossier_dok_list_id'];
							if(isset($_FILES[$racc])){
								$i=0;
								foreach ($_FILES[$racc]["error"] as $key => $error) {
									if ($error == UPLOAD_ERR_OK) {
										$tmp_nameacc = $_FILES[$racc]["tmp_name"][$key];
										$nameacc =$_FILES[$racc]["name"][$key];
										$data['filenameacc'] = $nameacc;
										$data['dInsertDate'] = date('Y-m-d H:i:s');

											if(move_uploaded_file($tmp_nameacc, $path."/".$id_review."/".$nameacc)) {
												$sqlacc[]="INSERT INTO dossier.dossier_dok_list_file (idossier_dok_list_id, vFilename, vKeterangan, dCreate, cCreated) 
														VALUES (".$vqacc['idossier_dok_list_id'].",'".$data['filenameacc']."','".$fKeterangan_accelerate[$vqacc['idossier_dok_list_id']][$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
												$i++;	
											}
											else{
												echo "Upload ke folder gagal";	
											}
									}
								}
							}
						}

						foreach ($updtacc as $kupacc) {
							try {
								$this->dbset->query($kupacc);
							} catch (Exception $e) {
								die($e);
							}
						}
						
						foreach($sqlacc as $qacc) {
							try {
							$this->dbset->query($qacc);
							}catch(Exception $e) {
							die($e);
							}
						}
					}

					$rt['message']="Data Berhasil Disimpan";
					$rt['status'] = TRUE;
					$rt['last_id'] = $this->input->get('lastId');					
					echo json_encode($rt);exit();
				}else{

					//Update Realtime
					$sqli="select lis.* from dossier.dossier_dok_list lis
							inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=lis.idossier_dokumen_id
							inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=dok.idossier_kat_dok_id
							inner join dossier.dossier_review rev on rev.idossier_review_id=lis.idossier_review_id
							where lis.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0
							and dok.vNama_Dokumen='RT ".$iNumber_ke." (Batch ".$iBatch_no.") Non' and lis.istatus_verifikasi=0 and lis.iStatus_confirm=0";
					$q=$this->dbset->query($sqli);
					if($q->num_rows()>=1){
						foreach ($q->result_array() as $kq => $vq) {
							foreach ($fileid as $kf => $vkf) {
								if($kf==$vq['idossier_dok_list_id']){
									$sq[$kf]=$vkf;
								}
							}
						}
						foreach ($sq as $kql => $vql) {
							$dt=array();
							foreach ($vql as $kkk => $vvv) {
								$dt[]=$vvv;
							}
							$dt=array_values(array_filter($dt));
							if(count($dt)!=0){
								$sq1[$kql]=implode(",", $dt);
							}
							
						}
						if(count($sq1)!=0){
							foreach ($sq1 as $ksq1 => $vql) {
								$id[]="UPDATE dossier.dossier_dok_list_file SET lDeleted=1 WHERE idossier_dok_list_id=".$ksq1." and idossier_dok_list_file_id not in (".$vql.")";
							}
							foreach($id as $qid) {
								try {
								$this->dbset->query($qid);
								}catch(Exception $e) {
								die($e);
								}
							}
						}
					}


					//Update Accelerate
					$sqliacc="select lis.* from dossier.dossier_dok_list lis
							inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=lis.idossier_dokumen_id
							inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=dok.idossier_kat_dok_id
							inner join dossier.dossier_review rev on rev.idossier_review_id=lis.idossier_review_id
							where lis.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0
							and dok.vNama_Dokumen='ACC ".$iNumber_ke." (Batch ".$iBatch_no.") Non' and lis.istatus_verifikasi=0 and lis.iStatus_confirm=0";
					$qacc=$this->dbset->query($sqliacc);
					if($qacc->num_rows()>=1){

						foreach ($qacc->result_array() as $kqacc => $vqacc) {
							foreach ($fileid_acc as $kfacc => $vkfacc) {
								if($kfacc==$vqacc['idossier_dok_list_id']){
									$sqacc[$kfacc]=$vkfacc;
								}
							}
						}
						foreach ($sqacc as $kqlacc => $vqlacc) {
							$dtacc=array();
							foreach ($vqlacc as $kkkacc => $vvvacc) {
								$dtacc[]=$vvvacc;
							}
							$dtacc=array_values(array_filter($dtacc));
							if(count($dtacc)!=0){
								$sq1acc[$kqlacc]=implode(",", $dtacc);
							}
						}
						if(count($sq1acc)!=0){
							foreach ($sq1acc as $ksq1acc => $vqlacc) {
								$idacc[]="UPDATE dossier.dossier_dok_list_file SET lDeleted=1 WHERE idossier_dok_list_id=".$ksq1acc." and idossier_dok_list_file_id not in (".$vqlacc.")";
							}

							foreach($idacc as $qidacc) {
								try {
								$this->dbset->query($qidacc);
								}catch(Exception $e) {
								die($e);
								}
							}
						}
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
			case 'employee_list':
				$this->employee_list();
				break;
			case 'refresh_file_realtime':
				$post=$this->input->post();
				echo $this->refresh_file_realtime($post);
				break;
			case 'refresh_file_accelerate':
				$post=$this->input->post();
				echo $this->refresh_file_accelerate($post);
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

//Manipulate button
    function listBox_Action($row, $actions) {
    	/*$sql = "SELECT dossier.dossier_stabilita_non_terbalik_item.iNumber_ke as a1, dossier.dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_item_id as a2 FROM (dossier.dossier_stabilita_non_terbalik)
			INNER JOIN dossier.dossier_stabilita_non_terbalik_item ON dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id=dossier_stabilita_non_terbalik.idossier_stabilita_non_terbalik_id
			INNER JOIN dossier.dossier_review ON dossier_review.idossier_review_id = dossier_stabilita_non_terbalik.idossier_review_id
			INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id
			INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = dossier_upd.iupb_id
			Left JOIN plc2.plc2_upb_formula ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
			WHERE dossier_stabilita_non_terbalik_item.iApprove !=2 and dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id='".$row->pk."'
			GROUP BY iBatch_no
			ORDER BY dossier_stabilita_non_terbalik_item.iNumber_ke desc
			LIMIT 1";
			print_r($row);
		$data_kom = $this->dbset->query($sql)->row_array();*/
		if ($row->dossier_stabilita_non_terbalik_item__iNumber_ke<>0){
			 unset($actions['delete']);
		}
	 	if ($row->dossier_stabilita_non_terbalik_item__iSubmit<>0) {
	 		 unset($actions['delete']);
	 	}
	 	if ($row->dossier_stabilita_non_terbalik_item__iApprove<>0) {
	 		 unset($actions['edit']);
	 	}
		 return $actions; 

	}
/*manipulasi view object form start*/

function insertBox_stabilita_non_terbalik_iNumber_ke($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1 required" size="25" value="0" />';
	
	return $return;

}
function updateBox_stabilita_non_terbalik_iNumber_ke($field, $id, $value, $rowData) {
	$sql = "SELECT dossier.dossier_stabilita_non_terbalik_item.iNumber_ke as a1, dossier.dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_item_id as a2 FROM (dossier.dossier_stabilita_non_terbalik)
		INNER JOIN dossier.dossier_stabilita_non_terbalik_item ON dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id=dossier_stabilita_non_terbalik.idossier_stabilita_non_terbalik_id
		INNER JOIN dossier.dossier_review ON dossier_review.idossier_review_id = dossier_stabilita_non_terbalik.idossier_review_id
		INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id
		INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = dossier_upd.iupb_id
		Left JOIN plc2.plc2_upb_formula ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
		WHERE dossier_stabilita_non_terbalik_item.iApprove !=2 and dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id='".$rowData['idossier_stabilita_non_terbalik_id']."'
		GROUP BY iBatch_no
		ORDER BY dossier_stabilita_non_terbalik_item.iNumber_ke desc
		LIMIT 1";
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return = '<input type="hidden" name="idossier_stabilita_non_terbalik_item_id"  readonly="readonly" id="idossier_stabilita_non_terbalik_item_id" value="'.$data_kom['a2'].'" size="25" />';
		$return .= '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}	

function insertBox_stabilita_non_terbalik_idossier_upd_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
						function cekbatchnon(){
							$("#stabilita_non_terbalik_iBatch_no").removeClass("error_text");
							var iBatch_no=$("#stabilita_non_terbalik_iBatch_no").val();
							var iBulanke=$("#stabilita_non_terbalik_iNumber_ke").val();
							if(iBatch_no==""){
								_custom_alert("Pilih Nomor Batch Terlebih Dahulu!","Info","Info", "stabilita_non_terbalik", 1, 20000);
								$("#stabilita_non_terbalik_iBatch_no").addClass("error_text");
								return false;
							}else{
								browse("'.base_url().'processor/plc/browse/stabilita/non/upd?field=stabilita_non_terbalik&iBatch_no="+iBatch_no+"&iBulanke="+iBulanke,"List UPD");
							}
						}
					</script>';
		$return .= '<input type="hidden" name="stabilita_non_terbalik_idossier_review_id"  id="stabilita_non_terbalik_idossier_review_id" readonly="readonly" class="input_rows1 required" size="25"/>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft"><input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="25" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="return cekbatchnon()" type="button">&nbsp;</button>';                
		return $return;
}


function updateBox_stabilita_non_terbalik_idossier_upd_id($field, $id, $value, $rowData) {
	$sql = 'select b.idossier_upd_id as idUpd, b.vUpd_no as vUpd, a2.idossier_review_id as idossier_review_id from dossier.dossier_stabilita_non_terbalik as a, dossier.dossier_review as a2 ,dossier.dossier_upd as b where a.idossier_review_id=a2.idossier_review_id and a2.idossier_upd_id=b.idossier_upd_id and a.idossier_stabilita_non_terbalik_id="'.$rowData['idossier_stabilita_non_terbalik_id'].'"';
	$data_kom = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_kom['vUpd'];

	}else{

		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="stabilita_non_terbalik_idossier_review_id" id="stabilita_non_terbalik_idossier_review_id" readonly="readonly" class="input_rows1 idreview" size="25" value="'.$data_kom['idossier_review_id'].'"/>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft"><input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$data_kom['idUpd'].'" class="input_rows1 required" />';
		$return .= '<input type="hidden" name="idossier_review_id_lm" class="required" readonly="readonly" id="idossier_review_id_lm" class="input_rows1" size="25" value="'.$data_kom['idossier_review_id'].'"/>';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="25" value="'.$data_kom['vUpd'].'"/>';
		$sql = "SELECT dossier.dossier_stabilita_non_terbalik_item.iSubmit as a1, dossier.dossier_stabilita_non_terbalik_item.iNumber_ke as b1 FROM (dossier.dossier_stabilita_non_terbalik)
		INNER JOIN dossier.dossier_stabilita_non_terbalik_item ON dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id=dossier_stabilita_non_terbalik.idossier_stabilita_non_terbalik_id
		INNER JOIN dossier.dossier_review ON dossier_review.idossier_review_id = dossier_stabilita_non_terbalik.idossier_review_id
		INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id
		INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = dossier_upd.iupb_id
		Left JOIN plc2.plc2_upb_formula ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
		WHERE dossier_stabilita_non_terbalik_item.iApprove !=2 and dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id='".$rowData['idossier_stabilita_non_terbalik_id']."'
		GROUP BY iBatch_no
		ORDER BY dossier_stabilita_non_terbalik_item.iNumber_ke desc
		LIMIT 1";
		$data_kom = $this->dbset->query($sql)->row_array();
		if (($data_kom['a1']==0) and ($data_kom['b1']==0)){
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/stabilita/non/upd?field=stabilita_non_terbalik\',\'List Komparator\')" type="button">&nbsp;</button>';  
		}                      
	}
	return $return; 
	
}	


function insertBox_stabilita_non_terbalik_vNama_usulan($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" size="25" />';
	return $return;
}

function updateBox_stabilita_non_terbalik_vNama_usulan($field, $id, $value, $rowData) {
$sql = 'select b.vNama_usulan as a1 from dossier.dossier_stabilita_non_terbalik as a, dossier.dossier_review as a2 , dossier.dossier_upd as b where a.idossier_review_id=a2.idossier_review_id and a2.idossier_upd_id=b.idossier_upd_id and a.idossier_stabilita_non_terbalik_id="'.$rowData['idossier_stabilita_non_terbalik_id'].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}	

function insertBox_stabilita_non_terbalik_dosis($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1 required" size="25" />';
	return $return;
}

function updateBox_stabilita_non_terbalik_dosis($field, $id, $value, $rowData) {
$sql = 'select c.dosis as a1 from dossier.dossier_stabilita_non_terbalik as a, dossier.dossier_review as a2 ,dossier.dossier_upd as b, plc2.plc2_upb as c where a.idossier_review_id=a2.idossier_review_id and a2.idossier_upd_id=b.idossier_upd_id and b.iupb_id=c.iupb_id and a.idossier_stabilita_non_terbalik_id="'.$rowData['idossier_stabilita_non_terbalik_id'].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}

function insertBox_stabilita_non_terbalik_vSediaan($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1 required" size="25" />';
	return $return;
}

function updateBox_stabilita_non_terbalik_vSediaan($field, $id, $value, $rowData) {
$sql = 'select d.vSediaan as a1 from dossier.dossier_stabilita_non_terbalik as a, dossier.dossier_review as a2, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d where a.idossier_review_id=a2.idossier_review_id and a2.idossier_upd_id=b.idossier_upd_id and b.iupb_id=c.iupb_id and d.isediaan_id = c.isediaan_id and a.idossier_stabilita_non_terbalik_id="'.$rowData['idossier_stabilita_non_terbalik_id'].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}

function insertBox_stabilita_non_terbalik_vUpb_Ref($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1 required" size="25" />';
	return $return;
}


function updateBox_stabilita_non_terbalik_vUpb_Ref($field, $id, $value, $rowData) {
$sql = 'select c.vupb_nomor a1 from dossier.dossier_stabilita_non_terbalik as a, dossier.dossier_review as a2, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d where a.idossier_review_id=a2.idossier_review_id and a2.idossier_upd_id=b.idossier_upd_id and b.iupb_id=c.iupb_id and d.isediaan_id = c.isediaan_id and a.idossier_stabilita_non_terbalik_id="'.$rowData['idossier_stabilita_non_terbalik_id'].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}
function insertBox_stabilita_non_terbalik_vRealtime($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="25" />';
	return $return;
}

function updateBox_stabilita_non_terbalik_vRealtime($field, $id, $value, $rowData) {
	$sql = "SELECT dossier.dossier_stabilita_non_terbalik_item.vRealtime as a1, dossier.dossier_stabilita_non_terbalik_item.iSubmit as b1 FROM (dossier.dossier_stabilita_non_terbalik)
		INNER JOIN dossier.dossier_stabilita_non_terbalik_item ON dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id=dossier_stabilita_non_terbalik.idossier_stabilita_non_terbalik_id
		INNER JOIN dossier.dossier_review ON dossier_review.idossier_review_id = dossier_stabilita_non_terbalik.idossier_review_id
		INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id
		INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = dossier_upd.iupb_id
		Left JOIN plc2.plc2_upb_formula ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
		WHERE dossier_stabilita_non_terbalik_item.iApprove !=2 and dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id='".$rowData['idossier_stabilita_non_terbalik_id']."'
		GROUP BY iBatch_no
		ORDER BY dossier_stabilita_non_terbalik_item.iNumber_ke desc
		LIMIT 1";
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		if ($data_kom['b1']==0){
			$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1 required" size="25" />';
		}
		else{
			$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1 required" size="25" />';
		}
			
	}
	return $return;
	
}	


function insertBox_stabilita_non_terbalik_vAccelerated($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="25" />';
	return $return;
}

function updateBox_stabilita_non_terbalik_vAccelerated($field, $id, $value, $rowData) {
	$sql = "SELECT dossier.dossier_stabilita_non_terbalik_item.vAccelerated as a1, dossier.dossier_stabilita_non_terbalik_item.iSubmit as b1 FROM (dossier.dossier_stabilita_non_terbalik)
		INNER JOIN dossier.dossier_stabilita_non_terbalik_item ON dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id=dossier_stabilita_non_terbalik.idossier_stabilita_non_terbalik_id
		INNER JOIN dossier.dossier_review ON dossier_review.idossier_review_id = dossier_stabilita_non_terbalik.idossier_review_id
		INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id
		INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = dossier_upd.iupb_id
		Left JOIN plc2.plc2_upb_formula ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
		WHERE dossier_stabilita_non_terbalik_item.iApprove !=2 and dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id='".$rowData['idossier_stabilita_non_terbalik_id']."'
		GROUP BY iBatch_no
		ORDER BY dossier_stabilita_non_terbalik_item.iNumber_ke desc
		LIMIT 1";
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		if ($data_kom['b1']==0){
			$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1 required" size="25" />';
		}
		else{
			$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1 required" size="25" />';
		}
	}
	return $return;
	
}

function updateBox_stabilita_non_terbalik_iSucced($field, $id, $value, $rowData) {
	$sql = "SELECT dossier.dossier_stabilita_non_terbalik_item.iSucced as a1 FROM (dossier.dossier_stabilita_non_terbalik)
		INNER JOIN dossier.dossier_stabilita_non_terbalik_item ON dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id=dossier_stabilita_non_terbalik.idossier_stabilita_non_terbalik_id
		INNER JOIN dossier.dossier_review ON dossier_review.idossier_review_id = dossier_stabilita_non_terbalik.idossier_review_id
		INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id
		INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = dossier_upd.iupb_id
		Left JOIN plc2.plc2_upb_formula ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
		WHERE dossier_stabilita_non_terbalik_item.iApprove !=2 and dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id='".$rowData['idossier_stabilita_non_terbalik_id']."'
		GROUP BY iBatch_no
		ORDER BY dossier_stabilita_non_terbalik_item.iNumber_ke desc
		LIMIT 1";
	$data_kom = $this->dbset->query($sql)->row_array();
	$data=array(0=>'Tidak Memenuhi',1=>'Memenuhi Syarat');
	if ($this->input->get('action') == 'view') {
		$return= $data[$data_kom['a1']];
	}
	else{
		$sql1 = "SELECT dossier.dossier_stabilita_non_terbalik_item.iSubmit as a1, dossier.dossier_stabilita_non_terbalik_item.iSucced as b1 FROM (dossier.dossier_stabilita_non_terbalik)
		INNER JOIN dossier.dossier_stabilita_non_terbalik_item ON dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id=dossier_stabilita_non_terbalik.idossier_stabilita_non_terbalik_id
		INNER JOIN dossier.dossier_review ON dossier_review.idossier_review_id = dossier_stabilita_non_terbalik.idossier_review_id
		INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id
		INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = dossier_upd.iupb_id
		Left JOIN plc2.plc2_upb_formula ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
		WHERE dossier_stabilita_non_terbalik_item.iApprove !=2 and dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id='".$rowData['idossier_stabilita_non_terbalik_id']."'
		GROUP BY iBatch_no
		ORDER BY dossier_stabilita_non_terbalik_item.iNumber_ke desc
		LIMIT 1";
		$data_kom1 = $this->dbset->query($sql1)->row_array();
		if ($data_kom1['a1']==0){
			$return = '<select name ="'.$field.'" id="'.$id.'" class="required">';
			$return .= '<option value="'.$data_kom1['b1'].'">'.$data[$data_kom1['b1']].'</option>';
			if($data_kom1['b1']==1){
			$return .= '<option value="0">Tidak Memenuhi Syarat</option>';
			}
			else{
			$return .= '<option value="1">Memenuhi Syarat</option>';
			}
			$return .= '</select>';
		}
		else{
			$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data[$data_kom['a1']].'" class="input_rows1 required" size="25" />';
		}
	}
	return $return;
	
}

function updateBox_stabilita_non_terbalik_iBatch_no($field, $id, $value, $rowData) {
$dat = $rowData['iBatch_no'];
$data=array(1=>'Batch 1', 2=>'Batch 2', 3=>'Batch 3');
	if ($this->input->get('action') == 'view') {
		$return= $data[$dat];
	}
	else{
		$sql1 = "SELECT dossier.dossier_stabilita_non_terbalik_item.iSubmit as a1, dossier.dossier_stabilita_non_terbalik_item.iNumber_ke as b1 FROM (dossier.dossier_stabilita_non_terbalik)
		INNER JOIN dossier.dossier_stabilita_non_terbalik_item ON dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id=dossier_stabilita_non_terbalik.idossier_stabilita_non_terbalik_id
		INNER JOIN dossier.dossier_review ON dossier_review.idossier_review_id = dossier_stabilita_non_terbalik.idossier_review_id
		INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id
		INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = dossier_upd.iupb_id
		Left JOIN plc2.plc2_upb_formula ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
		WHERE dossier_stabilita_non_terbalik_item.iApprove !=2 and dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id='".$rowData['idossier_stabilita_non_terbalik_id']."'
		GROUP BY iBatch_no
		ORDER BY dossier_stabilita_non_terbalik_item.iNumber_ke desc
		LIMIT 1";
		$data_kom1 = $this->dbset->query($sql1)->row_array();
		if (($data_kom1['a1']==0) and ($data_kom1['b1']==0)){
			$return ='<input type="hidden" name="'.$field.'_lm"  readonly="readonly" id="'.$id.'_lm" value="'.$dat.'" class="input_rows1" size="25" />';
			$return .= '<select name ="'.$field.'" id="'.$id.'">';
			$return .= '<option value="'.$dat.'">'.$data[$dat].'</option>';
			$return .= '<option value="1">Batch 1</option>';
			$return .= '<option value="2">Batch 2</option>';
			$return .= '<option value="3">Batch 3</option>';
			$return .= '</select>';
		}
		else{
			$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dat.'" class="input_rows1" size="25" />';
			$return .= '<input type="text" name="'.$field.'_dis"  readonly="readonly" id="'.$id.'" value="'.$data[$dat].'" class="input_rows1" size="25" />';
		}
	}
	return $return;
	
}

 function insertBox_stabilita_non_terbalik_fRealtime($field, $id) {
		/*$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('stabilita_non_terbalik_Realtime_file',$data,TRUE);*/
		$return	= "<div id='file_non_realtime'><input type='hidden' class='required' value='' /> Select No Dossier</div>";
		return $return;
	}

	 function updateBox_stabilita_non_terbalik_fRealtime($field, $id, $value, $rowData) {
	 	$sql = "SELECT dossier.dossier_stabilita_non_terbalik_item.iNumber_ke as a1, dossier.dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_item_id as a2 FROM (dossier.dossier_stabilita_non_terbalik)
		INNER JOIN dossier.dossier_stabilita_non_terbalik_item ON dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id=dossier_stabilita_non_terbalik.idossier_stabilita_non_terbalik_id
		INNER JOIN dossier.dossier_review ON dossier_review.idossier_review_id = dossier_stabilita_non_terbalik.idossier_review_id
		INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id
		INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = dossier_upd.iupb_id
		Left JOIN plc2.plc2_upb_formula ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
		WHERE dossier_stabilita_non_terbalik_item.iApprove !=2 and dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id='".$rowData['idossier_stabilita_non_terbalik_id']."'
		GROUP BY iBatch_no
		ORDER BY dossier_stabilita_non_terbalik_item.iNumber_ke desc
		LIMIT 1";
		$data_kom = $this->dbset->query($sql)->row_array();

	 	$idossier_stabilita_non_terbalik_id=$rowData['idossier_stabilita_non_terbalik_id'];
	 	$iBatch_no=$rowData['iBatch_no'];
	 	$iNumber_ke=$data_kom['a1'];
	 	//$sqlc="select e.*, b.idossier_review_id as idossier_review_id from dossier.dossier_stabilita as a, dossier.dossier_review as b, dossier.dossier_dok_list as c, dossier.dossier_dok_list_file as e where a.idossier_review_id=b.idossier_review_id and b.idossier_review_id=c.idossier_review_id and c.idossier_dok_list_id=e.idossier_dok_list_id and e.vFilename LIKE 'REAL' and a.idossier_stabilita_id=".$rowData['idossier_stabilita_id']." and a.iBatch_no=".$rowData['iBatch_no']."";
		/*$querys1="select  a.idossier_review_id as idossier_review_id, e.idossier_dok_list_file_id as idossier_dok_list_file_id, e.vFilename as vFilename, e.vKeterangan as vKeterangan from dossier.dossier_stabilita_non_terbalik as s
							join dossier.dossier_review as a on a.idossier_review_id=s.idossier_review_id
							join dossier.dossier_dok_list as b on a.idossier_review_id=b.idossier_review_id
							join dossier.dossier_dokumen as c on b.idossier_dokumen_id=c.idossier_dokumen_id
							join dossier.dossier_kat_dok as d on c.idossier_kat_dok_id=c.idossier_kat_dok_id
							join dossier.dossier_dok_list_file as e on e.idossier_dok_list_id=b.idossier_dok_list_id
							where d.idossier_kat_dok_id=4 and c.vNama_Dokumen LIKE 'RT ".$iNumber_ke." (Batch ".$iBatch_no.") Non' and s.idossier_stabilita_non_terbalik_id=".$idossier_stabilita_non_terbalik_id." and e.lDeleted=0
							order by b.idossier_dok_list_id
							LIMIT 1";
		$data['rows'] = $this->db_plc0->query($querys1)->result_array();
		return $this->load->view('stabilita_non_terbalik_Realtime_file',$data,TRUE);*/

		$sql_negara="select * from dossier.dossier_upd_negara ne 
		inner join dossier.dossier_negara neg on neg.idossier_negara_id = ne.idossier_negara_id
		inner join dossier.dossier_review re on re.idossier_upd_id=ne.idossier_upd_id
		where ne.lDeleted=0 and re.idossier_review_id=".$rowData['idossier_review_id'];
		$data['mnnegara'] = $this->dbset->query($sql_negara)->result_array();


		//data row table dokumen
		$sql_data="select doklist.*,kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen,dok.ijml_dok,dok.ibobot,
					divi.vDescription,doklist.istatus_keberadaan,em.vName,rev.*,doklist.istatus_verifikasi as iveri, doklist.iStatus_confirm as iconfrm
					from dossier.dossier_dok_list doklist
					inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=doklist.idossier_dokumen_id
					inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=dok.idossier_kat_dok_id
					inner join dossier.dossier_review rev on doklist.idossier_review_id=rev.idossier_review_id
					inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
					left join hrd.employee em on em.cNip=up.vpic
					left join hrd.msdivision divi on divi.iDivID=dok.idivisionId
					where doklist.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0 and up.lDeleted=0 and (divi.lDeleted=0 or divi.lDeleted is null)
					and doklist.idossier_review_id=".$rowData['idossier_review_id']."
					and dok.vNama_Dokumen='RT ".$iNumber_ke." (Batch ".$iBatch_no.") Non' 
					order by kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen ASC";
		$data['dokumen']=$this->dbset->query($sql_data)->result_array();
		$return=$this->load->view('file_realtime_stabilita_non_terbalik',$data,TRUE);
		return $return;
	
	}	

function insertBox_stabilita_non_terbalik_fAccelerate($field, $id) {
		/*$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('stabilita_non_terbalik_Accelerate_file',$data,TRUE);
		*/
		$return	= "<div id='file_non_accelerate'><input type='hidden' class='required' value='' /> Select No Dossier</div>";
		return $return;
	}

	 function updateBox_stabilita_non_terbalik_fAccelerate($field, $id, $value, $rowData) {

	 $sql = "SELECT dossier.dossier_stabilita_non_terbalik_item.iNumber_ke as a1, dossier.dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_item_id as a2 FROM (dossier.dossier_stabilita_non_terbalik)
		INNER JOIN dossier.dossier_stabilita_non_terbalik_item ON dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id=dossier_stabilita_non_terbalik.idossier_stabilita_non_terbalik_id
		INNER JOIN dossier.dossier_review ON dossier_review.idossier_review_id = dossier_stabilita_non_terbalik.idossier_review_id
		INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id
		INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = dossier_upd.iupb_id
		Left JOIN plc2.plc2_upb_formula ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
		WHERE dossier_stabilita_non_terbalik_item.iApprove !=2 and dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id='".$rowData['idossier_stabilita_non_terbalik_id']."'
		GROUP BY iBatch_no
		ORDER BY dossier_stabilita_non_terbalik_item.iNumber_ke desc
		LIMIT 1";
		$data_kom = $this->dbset->query($sql)->row_array();

	 	$idossier_stabilita_non_terbalik_id=$rowData['idossier_stabilita_non_terbalik_id'];
	 	$iBatch_no=$rowData['iBatch_no'];
	 	$iNumber_ke=$data_kom['a1'];
	 	//$sqlc="select e.*, b.idossier_review_id as idossier_review_id from dossier.dossier_stabilita as a, dossier.dossier_review as b, dossier.dossier_dok_list as c, dossier.dossier_dok_list_file as e where a.idossier_review_id=b.idossier_review_id and b.idossier_review_id=c.idossier_review_id and c.idossier_dok_list_id=e.idossier_dok_list_id and e.vFilename LIKE 'REAL' and a.idossier_stabilita_id=".$rowData['idossier_stabilita_id']." and a.iBatch_no=".$rowData['iBatch_no']."";
		/*$querys1="select  a.idossier_review_id as idossier_review_id, e.idossier_dok_list_file_id as idossier_dok_list_file_id, e.vFilename as vFilename, e.vKeterangan as vKeterangan from dossier.dossier_stabilita_non_terbalik as s
							join dossier.dossier_review as a on a.idossier_review_id=s.idossier_review_id
							join dossier.dossier_dok_list as b on a.idossier_review_id=b.idossier_review_id
							join dossier.dossier_dokumen as c on b.idossier_dokumen_id=c.idossier_dokumen_id
							join dossier.dossier_kat_dok as d on c.idossier_kat_dok_id=c.idossier_kat_dok_id
							join dossier.dossier_dok_list_file as e on e.idossier_dok_list_id=b.idossier_dok_list_id
							where d.idossier_kat_dok_id=4 and c.vNama_Dokumen LIKE 'ACC ".$iNumber_ke." (Batch ".$iBatch_no.") Non' and s.idossier_stabilita_non_terbalik_id=".$idossier_stabilita_non_terbalik_id." and e.lDeleted=0
							order by b.idossier_dok_list_id
							LIMIT 1";
		$data['rows'] = $this->db_plc0->query($querys1)->result_array();
		return $this->load->view('stabilita_non_terbalik_Accelerate_file',$data,TRUE);*/
		$sql_negara="select * from dossier.dossier_upd_negara ne 
		inner join dossier.dossier_negara neg on neg.idossier_negara_id = ne.idossier_negara_id
		inner join dossier.dossier_review re on re.idossier_upd_id=ne.idossier_upd_id
		where ne.lDeleted=0 and re.idossier_review_id=".$rowData['idossier_review_id'];
		$data['mnnegara'] = $this->dbset->query($sql_negara)->result_array();
		$sql_data="select doklist.*,kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen,dok.ijml_dok,dok.ibobot,
					divi.vDescription,doklist.istatus_keberadaan,em.vName,rev.*,doklist.istatus_verifikasi as iveri, doklist.iStatus_confirm as iconfrm
					from dossier.dossier_dok_list doklist
					inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=doklist.idossier_dokumen_id
					inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=dok.idossier_kat_dok_id
					inner join dossier.dossier_review rev on doklist.idossier_review_id=rev.idossier_review_id
					inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
					left join hrd.employee em on em.cNip=up.vpic
					left join hrd.msdivision divi on divi.iDivID=dok.idivisionId
					where doklist.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0 and up.lDeleted=0 and (divi.lDeleted=0 or divi.lDeleted is null)
					and doklist.idossier_review_id=".$rowData['idossier_review_id']."
					and dok.vNama_Dokumen='ACC ".$iNumber_ke." (Batch ".$iBatch_no.") Non' 
					order by kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen ASC";
		$data['dokumen']=$this->dbset->query($sql_data)->result_array();
		$return=$this->load->view('file_accelerate_stabilita_non_terbalik',$data,TRUE);
		return $return;
	}
	 function updateBox_stabilita_non_terbalik_histori($field, $id, $value, $rowData) {

	 	$idossier_stabilita_non_terbalik_id=$rowData['idossier_stabilita_non_terbalik_id'];
	 	$iBatch_no=$rowData['iBatch_no'];
	 	//$sqlc="select e.*, b.idossier_review_id as idossier_review_id from dossier.dossier_stabilita as a, dossier.dossier_review as b, dossier.dossier_dok_list as c, dossier.dossier_dok_list_file as e where a.idossier_review_id=b.idossier_review_id and b.idossier_review_id=c.idossier_review_id and c.idossier_dok_list_id=e.idossier_dok_list_id and e.vFilename LIKE 'REAL' and a.idossier_stabilita_id=".$rowData['idossier_stabilita_id']." and a.iBatch_no=".$rowData['iBatch_no']."";
		$qr="select a.vNip_approve as nip, b.vName as vName, a.vRealtime as vRealtime, a.vAccelerated as vAccelerated, a.iStatus_stabilita as iStatus_stabilita, a.tApprove as tgl_Approve, a.vRemark as vRemark,a.iApprove as iApprove, a.iNumber_ke as iNumber_ke
					from dossier.dossier_stabilita_non_terbalik_item as a
					join hrd.employee as b on a.vNip_approve=b.cNip
					where a.idossier_stabilita_non_terbalik_id=".$rowData['idossier_stabilita_non_terbalik_id']." and a.iApprove !=0 
					order by a.iNumber_ke";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		return $this->load->view('stabilita_non_terbalik_histori',$data,TRUE);
	}	

function before_insert_processor($row, $postData) {
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreated'] =$this->user->gNIP;
	//return $postData;
	// ubah status submit
		if($postData['isdraft']==true){
			$postData['submit']=0;
		} 
		else{$postData['submit']=1;} 
	return $postData;

}

function before_update_processor($row, $postData) {
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreated'] =$this->user->gNIP;
	//return $postData;
	// ubah status submit
		if($postData['isdraft']==true){
			$postData['submit']=0;
		} 
		else{$postData['submit']=1;} 
	return $postData;

}

public function after_insert_processor($fields, $id, $post) {
		$cNip = $this->user->gNIP;
		$tgl = date('Y-m-d', mktime());
		$vRealtime= $_POST['vRealtime'];
		$vAccelerated=$_POST['vAccelerated'];
		$iSucced=$_POST['stabilita_non_terbalik_iSucced'];
		$submit=$post['submit'];
		$dat=array(0=>0,1=>1,2=>3,3=>6,4=>9,5=>12,6=>18,7=>24);
		$z=0;
		for($i=0;$i<=7;$i++){
			$iNumber_ke=$dat[$z];
			if ($z==0){
				$sql = "INSERT INTO dossier.dossier_stabilita_non_terbalik_item (idossier_stabilita_non_terbalik_id, vRealtime, vAccelerated, iNumber_ke, iSucced, dCreate, cCreated, iSubmit,tApprove, vNip_approve) VALUES ('".$id."','".$vRealtime."','".$vAccelerated."','".$iNumber_ke."','1','".$tgl."','".$cNip."','".$submit."', NULL, NULL)";
				$query = $this->db_plc0->query( $sql );
			}
			else{
				$sql = "INSERT INTO dossier.dossier_stabilita_non_terbalik_item (idossier_stabilita_non_terbalik_id,iNumber_ke, dCreate, cCreated, iSubmit, tApprove, vNip_approve) VALUES ('".$id."','".$iNumber_ke."','".$tgl."','".$cNip."','0', NULL, NULL)";
				$query = $this->db_plc0->query( $sql );
			}
			$z++;
		} //End For
	
}

public function after_update_processor($fields, $id, $post) {
		$cNip = $this->user->gNIP;
		$tgl = date('Y-m-d', mktime());
		$vRealtime= $_POST['vRealtime'];
		$vAccelerated=$_POST['vAccelerated'];
		$submit=$post['submit'];
		$iSucced=$_POST['iSucced'];
		$id_stabilita_item=$_POST['idossier_stabilita_non_terbalik_item_id'];
		$qstabilita_item="UPDATE dossier.dossier_stabilita_non_terbalik_item as a SET a.vAccelerated='".$vAccelerated."', a.vRealtime='".$vRealtime."', a.iSubmit='".$submit."',a.iSucced='".$iSucced."' WHERE a.idossier_stabilita_non_terbalik_item_id='".$id_stabilita_item."'";
		$this->dbset->query($qstabilita_item);		
}

function manipulate_update_button($buttons, $rowData) {
	$sql = "SELECT dossier.dossier_stabilita_non_terbalik_item.iSubmit as a1, dossier.dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_item_id as a2, dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id as a3,dossier_stabilita_non_terbalik_item.iApprove as a4 FROM (dossier.dossier_stabilita_non_terbalik)
		INNER JOIN dossier.dossier_stabilita_non_terbalik_item ON dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id=dossier_stabilita_non_terbalik.idossier_stabilita_non_terbalik_id
		INNER JOIN dossier.dossier_review ON dossier_review.idossier_review_id = dossier_stabilita_non_terbalik.idossier_review_id
		INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id
		INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = dossier_upd.iupb_id
		Left JOIN plc2.plc2_upb_formula ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
		WHERE dossier_stabilita_non_terbalik_item.iApprove !=2 and dossier_stabilita_non_terbalik_item.idossier_stabilita_non_terbalik_id='".$rowData['idossier_stabilita_non_terbalik_id']."'
		GROUP BY iBatch_no
		ORDER BY dossier_stabilita_non_terbalik_item.iNumber_ke desc
		LIMIT 1";
	$qb=mysql_query($sql);
	$dt=mysql_fetch_array($qb);
	$idossier_stabilita_non_terbalik_item_id=$dt['a2'];
	$idossier_stabilita_non_terbalik_id=$dt['a3'];
	$iApprove=$dt['a4'];

	$cNip= $this->user->gNIP;

	$js = $this->load->view('stabilita_non_terbalik_js');
	$js .= $this->load->view('uploadjs');

	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/stabilita/non/terbalik?action=approve&idossier_stabilita_non_terbalik_item_id='.$idossier_stabilita_non_terbalik_item_id.'&idossier_stabilita_non_terbalik_id='.$idossier_stabilita_non_terbalik_id.'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_stabilita_non_terbalik">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/stabilita/non/terbalik?action=reject&idossier_stabilita_non_terbalik_item_id='.$idossier_stabilita_non_terbalik_item_id.'&idossier_stabilita_non_terbalik_id='.$idossier_stabilita_non_terbalik_id.'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_stabilita_non_terbalik">Reject</button>';

	$update = '<button onclick="javascript:update_btn_back(\'stabilita_non_terbalik\', \''.base_url().'processor/plc/stabilita/non/terbalik?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_stabilita_non_terbalik">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'stabilita_non_terbalik\', \''.base_url().'processor/plc/stabilita/non/terbalik?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_stabilita_non_terbalik">Update as Draft</button>';



	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if ($dt['a1']== 0) {
			// jika masih draft , show button update draft & update submit 
			$buttons['update'] = $updatedraft.$update.$js;
		}else{
			if ($iApprove==0){
			$buttons['update'] = $approve.$reject.$js;	
			}
			else{
				unset($buttons['update_back']);
				unset($buttons['update']);
			}		
		}
	}

	return $buttons;
}

function manipulate_insert_button($buttons) {
	unset($buttons['save']);

	$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'stabilita_non_terbalik\', \''.base_url().'processor/plc/stabilita/non/terbalik?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_stabilita_non_terbalik">Save as Draft</button>';
	$save = '<button onclick="javascript:save_btn_multiupload(\'stabilita_non_terbalik\', \''.base_url().'processor/plc/stabilita/non/terbalik?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_stabilita_non_terbalik">Save &amp; Submit</button>';
	$js = $this->load->view('stabilita_non_terbalik_js');
	$js .= $this->load->view('uploadjs');
	$buttons['save'] = $save_draft.$save.$js;

	return $buttons;
}


/*

*/
//update row iDelete


function approve_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var iSta= $("#stabilita_non_terbalik_iNumber_ke").val();
					 	var iBatch_no= $("#stabilita_non_terbalik_iBatch_no").val();
						return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize() + "&iSta=" + iSta + "&iBatch_no=" + iBatch_no,
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;							
								if(o.status == true) {
									$("#alert_dialog_form").dialog("close");
										$.get(base_url+"processor/plc/stabilita/non/terbalik?action=update&id="+last_id, function(data) {
	                            			 $("div#form_stabilita_non_terbalik").html(data);
	                    				});
									
								}
									reload_grid("grid_stabilita_non_terbalik");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_stabilita_non_terbalik_approve" action="'.base_url().'processor/plc/stabilita/non/terbalik?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_stabilita_non_terbalik_item_id" value="'.$this->input->get('idossier_stabilita_non_terbalik_item_id').'" />
				<input type="hidden" name="idossier_stabilita_non_terbalik_id" value="'.$this->input->get('idossier_stabilita_non_terbalik_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_stabilita_non_terbalik_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function approve_process(){
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$idossier_stabilita_non_terbalik_item_id = $_POST['idossier_stabilita_non_terbalik_item_id'];
		$idossier_stabilita_non_terbalik_id = $_POST['idossier_stabilita_non_terbalik_id'];
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$data=array('vNip_approve'=>$cNip, 'tApprove'=>$tApprove,'vRemark'=>$vRemark, 'iApprove'=>2);
		$this->db_plc0-> where('idossier_stabilita_non_terbalik_item_id', $idossier_stabilita_non_terbalik_item_id);
		$updet = $this->db_plc0->update('dossier.dossier_stabilita_non_terbalik_item', $data);

		$iSta=$post['iSta'];
		$iBatch_no=$post['iBatch_no'];

		$querys="select a.idossier_review_id, b.idossier_dok_list_id as id_dok, c.vNama_Dokumen as Nama_Dok from dossier.dossier_review as a
				join dossier.dossier_dok_list as b on a.idossier_review_id=b.idossier_review_id
				join dossier.dossier_dokumen as c on b.idossier_dokumen_id=c.idossier_dokumen_id
				join dossier.dossier_kat_dok as d on c.idossier_kat_dok_id=c.idossier_kat_dok_id
				inner join dossier.dossier_stabilita_non_terbalik as e on a.idossier_review_id=e.idossier_review_id
				where d.idossier_kat_dok_id=4 and e.idossier_stabilita_non_terbalik_id='".$idossier_stabilita_non_terbalik_id."' and c.vNama_Dokumen in ('ACC ".$iSta." (Batch ".$iBatch_no.") Non','RT ".$iSta." (Batch ".$iBatch_no.") Non')
				order by b.idossier_dok_list_id";
		$seld=mysql_query($querys);
		while($dat=mysql_fetch_array($seld)){
			
			$sql_update[] = "update dossier.dossier_dok_list as a set a.istatus_keberadaan=1 where a.idossier_dok_list_id='".$dat['id_dok']."' LIMIT 1";
		}
		foreach($sql_update as $q_update) {
			try {
			$this->dbset->query($q_update);
			}catch(Exception $e) {
			die($e);
			}
		}


		$data['status']  = true;
		$data['last_id'] = $idossier_stabilita_non_terbalik_id;
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_stabilita_non_terbalik_vRemark").val();
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
								var url = "'.base_url().'processor/plc/stabilita/non/terbalik";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id, function(data) {
										 $("div#form_stabilita_non_terbalik").html(data);
									});
									
								}
									reload_grid("grid_stabilita_non_terbalik");
							}
					 	 	
					 	 })
					
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_stabilita_non_terbalik_reject" action="'.base_url().'processor/plc/stabilita/non/terbalik?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_stabilita_non_terbalik_item_id" value="'.$this->input->get('idossier_stabilita_non_terbalik_item_id').'" />
				<input type="hidden" name="idossier_stabilita_non_terbalik_id" value="'.$this->input->get('idossier_stabilita_non_terbalik_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="reject_stabilita_non_terbalik_vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_stabilita_non_terbalik_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	
	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$idossier_stabilita_non_terbalik_item_id = $_POST['idossier_stabilita_non_terbalik_item_id'];
		$idossier_stabilita_non_terbalik_id = $_POST['idossier_stabilita_non_terbalik_id'];
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$data=array('vNip_approve'=>$cNip, 'tApprove'=>$tApprove,'vRemark'=>$vRemark, 'iApprove'=>1);
		$this->db_plc0-> where('idossier_stabilita_non_terbalik_item_id', $idossier_stabilita_non_terbalik_item_id);
		$updet = $this->db_plc0->update('dossier.dossier_stabilita_non_terbalik_item', $data);
		
		$data['status']  = true;
		$data['last_id'] = $idossier_stabilita_non_terbalik_id;
		return json_encode($data);
	}

	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		//print_r($_GET);
		//exit;
		//$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/dossier_dok/'.$id.'/'.$name);	
		force_download($name, $path);
	}
/*function pendukung end*/    	

	function refresh_file_realtime($post){
		$sql_negara="select * from dossier.dossier_upd_negara ne 
		inner join dossier.dossier_negara neg on neg.idossier_negara_id = ne.idossier_negara_id
		inner join dossier.dossier_review re on re.idossier_upd_id=ne.idossier_upd_id
		where ne.lDeleted=0 and re.idossier_review_id=".$post['idreview'];
		$data['mnnegara'] = $this->dbset->query($sql_negara)->result_array();


		//data row table dokumen
		$sql_data="select doklist.*,kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen,dok.ijml_dok,dok.ibobot,
					divi.vDescription,doklist.istatus_keberadaan,em.vName,rev.*,doklist.istatus_verifikasi as iveri, doklist.iStatus_confirm as iconfrm
					from dossier.dossier_dok_list doklist
					inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=doklist.idossier_dokumen_id
					inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=dok.idossier_kat_dok_id
					inner join dossier.dossier_review rev on doklist.idossier_review_id=rev.idossier_review_id
					inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
					left join hrd.employee em on em.cNip=up.vpic
					left join hrd.msdivision divi on divi.iDivID=dok.idivisionId
					where doklist.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0 and up.lDeleted=0 and (divi.lDeleted=0 or divi.lDeleted is null)
					and doklist.idossier_review_id=".$post['idreview']."
					and dok.vNama_Dokumen='RT ".$post['iBulanke']." (Batch ".$post['iBatch_no'].") Non' 
					order by kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen ASC";
		$data['dokumen']=$this->dbset->query($sql_data)->result_array();
		$return=$this->load->view('file_realtime_stabilita_non_terbalik',$data,TRUE);
		return $return;
	}
	function refresh_file_accelerate($post){
		$sql_negara="select * from dossier.dossier_upd_negara ne 
		inner join dossier.dossier_negara neg on neg.idossier_negara_id = ne.idossier_negara_id
		inner join dossier.dossier_review re on re.idossier_upd_id=ne.idossier_upd_id
		where ne.lDeleted=0 and re.idossier_review_id=".$post['idreview'];
		$data['mnnegara'] = $this->dbset->query($sql_negara)->result_array();


		//data row table dokumen
		$sql_data="select doklist.*,kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen,dok.ijml_dok,dok.ibobot,
					divi.vDescription,doklist.istatus_keberadaan,em.vName,rev.*,doklist.istatus_verifikasi as iveri, doklist.iStatus_confirm as iconfrm
					from dossier.dossier_dok_list doklist
					inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=doklist.idossier_dokumen_id
					inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=dok.idossier_kat_dok_id
					inner join dossier.dossier_review rev on doklist.idossier_review_id=rev.idossier_review_id
					inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
					left join hrd.employee em on em.cNip=up.vpic
					left join hrd.msdivision divi on divi.iDivID=dok.idivisionId
					where doklist.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0 and up.lDeleted=0 and (divi.lDeleted=0 or divi.lDeleted is null)
					and doklist.idossier_review_id=".$post['idreview']."
					and dok.vNama_Dokumen='ACC ".$post['iBulanke']." (Batch ".$post['iBatch_no'].") Non' 
					order by kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen ASC";
		$data['dokumen']=$this->dbset->query($sql_data)->result_array();
		$return=$this->load->view('file_accelerate_stabilita_non_terbalik',$data,TRUE);
		return $return;
	}

	public function output(){
		$this->index($this->input->get('action'));
	}

}
