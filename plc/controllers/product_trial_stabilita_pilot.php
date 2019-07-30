<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_trial_stabilita_pilot extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('plc', true);
		$this->load->library('lib_utilitas');
		$this->user = $this->auth->user();
		$this->load->model('user_model');
    }
    function index($action = '') {
    	$action = $this->input->get('action');

		$grid = new Grid;

		$grid->setTitle('Stabilita Pilot');
		$grid->setUrl('product_trial_stabilita_pilot');
		$grid->setTable('plc2.plc2_upb_stabilita_pilot');
		$grid->addList('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb_formula.vkode_surat','vbatch','inumber','isucced','ipilot','iapppd');
		$grid->setSortBy('tdate');
		$grid->setSortOrder('DESC');

		$grid->setLabel('plc2_upb.vupb_nomor', 'UPB Nomor');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '120');
		$grid->setAlign('plc2_upb.vupb_nama', 'Left');
		$grid->setWidth('plc2_upb.vupb_nama', '200');
		$grid->setLabel('plc2_upb_formula.vkode_surat', 'No. Formulasi');
		$grid->setLabel('vbatch', 'No. Batch');
		$grid->setLabel('inumber', 'Stabilita bulan ke');
		$grid->setLabel('isucced', 'Status Stabilita');
		$grid->setLabel('ipilot', 'Jenis Stabilita');
		$grid->setLabel('iapppd', 'PD Approval');

		$grid->addFields('vkode_surat','vupb_nomor','vgenerik','vupb_nama','inumber','tdate','vrealtime','vaccelerate','isucced','ipilot','vbatch');
		$grid->addFields('protaccel','protreal','dok_stab','data_stabilita','history_stabilita','vnip_apppd');

		$grid->setLabel('tdate', 'Tanggal Stabilita');
		$grid->setLabel('vrealtime', 'Real Time Test');
		$grid->setLabel('vaccelerate', 'Accelerated Test');

		$grid->setLabel('vkode_surat', 'No. Formulasi');
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('vupb_nama', 'Nama Usulan Produk');
		$grid->setLabel('protaccel', 'File Protokol Accelerated');
		$grid->setLabel('protreal', 'File Protokol Real Time');
		$grid->setLabel('dok_stab', 'File Dokumen Stabilita (Tambahan)');
		$grid->setLabel('vnip_apppd', 'PD Approval');
		$grid->setRequired('inumber','tdate','vrealtime','vaccelerate','isucced','ipilot','vbatch','vkode_surat');
		
		$grid->setJoinTable('plc2.plc2_upb_formula','plc2_upb_formula.ifor_id = plc2_upb_stabilita_pilot.ifor_id','INNER');		
		$grid->setJoinTable('plc2.plc2_upb','plc2_upb_formula.iupb_id = plc2_upb.iupb_id','INNER');
		$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));

		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb_formula.vkode_surat','vbatch','inumber','isucced','iapppd');

		$grid->setQuery('plc2_upb_stabilita_pilot.ldeleted', 0);	
		$grid->setQuery('plc2.plc2_upb_stabilita_pilot.inumber =(select max(st2.inumber) from plc2.plc2_upb_stabilita_pilot st2 where plc2.plc2_upb_stabilita_pilot.ifor_id=st2.ifor_id and plc2.plc2_upb_stabilita_pilot.ipilot=st2.ipilot and st2.ldeleted=0)', null);	
		$grid->setQuery('plc2_upb.ihold', 0);

		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}

		$grid->changeFieldType('isucced','combobox','',array(''=>'-', 0=>'Belum Stabilita', 1=>'Tidak Memenuhi Syarat (TMS)', 2=>'Memenuhi Syarat (MS)'));
		$grid->changeFieldType('ipilot','combobox','',array(''=>'-', 1=>'Stabilita Pilot 1', 2=>'Stabilita Pilot 2', 3=>'Stabilita Manufacturer'));
		$grid->changeFieldType('iapppd','combobox','',array(''=>'-', 0=>'Waiting For Approval', 2=>'Approved', 1=>'Reject'));

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
				//print_r($this->input->post());exit();
				$isUpload = $this->input->get('isUpload');
				
				$sql = array();
				$sqlr = array();
				$sqld = array();
				
   				if($isUpload) {
					$patha = realpath("files/plc/prot_accel/");
					$pathr = realpath("files/plc/prot_real/");
					$pathd = realpath("files/plc/dokstab/");
					$lastId=$this->input->post('product_trial_stabilita_pilot_vkode_surat');
					
					if(!file_exists($patha."/".$lastId)){
						if (!mkdir($patha."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
					}
					if(!file_exists($pathr."/".$lastId)){
						if (!mkdir($pathr."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
					}
					if(!file_exists($pathd."/".$lastId)){
						if (!mkdir($pathd."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
					}
					
					$file_keterangana = array();
					$file_keteranganr = array();
					$file_keterangand = array();
					$detvparam=array();
					$detvsyarat=array();
					$detvrealtime=array();
					$detvaccelerate=array();
										
					foreach($_POST as $key=>$value) {						
						if ($key == 'fileketerangana') {
							foreach($value as $k=>$v) {
								$file_keterangana[$k] = $v;
							}
						}
						if ($key == 'fileketerangand') {
							foreach($value as $k=>$v) {
								$file_keterangand[$k] = $v;
							}
						}
						if ($key == 'fileketeranganr') {
							foreach($value as $k=>$v) {
								$file_keteranganr[$k] = $v;
							}
						}

					}
					$i = 0;
					foreach ($_FILES['fileuploada']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {				
							$tmp_namea = $_FILES['fileuploada']["tmp_name"][$key];
							$namea = $_FILES['fileuploada']["name"][$key];
							$dataa['filename'] = $namea;
							$dataa['id']=$this->input->post('product_trial_stabilita_pilot_vkode_surat');
							$dataa['nip']=$this->user->gNIP;
							//$data['iupb_id'] = $insertId;
							//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							$dataa['dInsertDate'] = date('Y-m-d H:i:s');
							if(move_uploaded_file($tmp_namea, $patha."/".$this->input->post('product_trial_stabilita_pilot_vkode_surat')."/".$namea)) {	
								$sqla[] = "INSERT INTO plc2_upb_file_protaccel(ifor_id, filename, dInsertDate, keterangan,cInsert) 
										VALUES ('".$dataa['id']."', '".$dataa['filename']."','".$dataa['dInsertDate']."','".$file_keterangana[$i]."','".$dataa['nip']."')";
								$i++;																			
							}
							else{
							echo "Upload ke folder gagal";	
							}
						}
						//upload 
						foreach($sqla as $qa) {
							try {
								$this->dbset->query($qa);
							}catch(Exception $e) {
								die($e);
							}
						}
					}
					$i = 0;
					//upload protokol real time
					foreach ($_FILES['fileuploadr']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {				
							$tmp_namer = $_FILES['fileuploadr']["tmp_name"][$key];
							$namer = $_FILES['fileuploadr']["name"][$key];
							$datar['filename'] = $namer;
							$datar['id']=$this->input->post('product_trial_stabilita_pilot_vkode_surat');
							$datar['nip']=$this->user->gNIP;
							//$data['iupb_id'] = $insertId;
							//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							$datar['dInsertDate'] = date('Y-m-d H:i:s');
							if(move_uploaded_file($tmp_namer, $pathr."/".$this->input->post('product_trial_stabilita_pilot_vkode_surat')."/".$namer)) {	
								$sqlr[] = "INSERT INTO plc2_upb_file_protreal(ifor_id, filename, dInsertDate, keterangan,cInsert) 
										VALUES ('".$datar['id']."', '".$datar['filename']."','".$datar['dInsertDate']."','".$file_keteranganr[$i]."','".$datar['nip']."')";
								$i++;																			
							//print_r($sqlr);
							}
							else{
							echo "Upload ke folder gagal";	
							}
						}
						
					}
					//upload 
					foreach($sqlr as $qr) {
						try {
							$this->dbset->query($qr);
						}catch(Exception $e) {
							die($e);
						}
					}
					$i = 0;
					//upload dokumen tambahan
					foreach ($_FILES['fileuploadd']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {				
							$tmp_named = $_FILES['fileuploadd']["tmp_name"][$key];
							$named = $_FILES['fileuploadd']["name"][$key];
							$datad['filename'] = $named;
							$datad['id']=$this->input->post('product_trial_stabilita_pilot_vkode_surat');
							$datad['nip']=$this->user->gNIP;
							//$data['iupb_id'] = $insertId;
							//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							$datad['dInsertDate'] = date('Y-m-d H:i:s');
							if(move_uploaded_file($tmp_named, $pathd."/".$this->input->post('product_trial_stabilita_pilot_vkode_surat')."/".$named)) {	
								$sqld[] = "INSERT INTO plc2_upb_file_stabpilot(ifor_id, filename, dInsertDate, keterangan,cInsert) 
										VALUES ('".$datad['id']."', '".$datad['filename']."','".$datad['dInsertDate']."','".$file_keterangand[$i]."','".$datad['nip']."')";
								$i++;																			
							}
							else{
							echo "Upload ke folder gagal";	
							}
						}
						
					}
					//upload 
					foreach($sqld as $qd) {
						try {
							$this->dbset->query($qd);
						}catch(Exception $e) {
							die($e);
						}
					}

					$r['message'] = "Data Berhasil Di Simpan!";
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');					
					echo json_encode($r);
					exit();
				}  else {
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
				//print_r($this->input->post());
				$sqla = array();
				$file_namea= "";
				$fileIda = array();
				$sqlr = array();
				$file_namer= "";
				$fileIdr = array();
				$sqld = array();
				$file_named= "";
				$fileIdd = array();
				
				
				$patha = realpath("files/plc/prot_accel");
				$pathr = realpath("files/plc/prot_real");
				$pathd= realpath("files/plc/dokstab");
				
				$lastId=$this->input->post('vkode_surat');
					
				if(!file_exists($patha."/".$lastId)){
					if (!mkdir($patha."/".$lastId, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
				if(!file_exists($pathr."/".$lastId)){
					if (!mkdir($pathr."/".$lastId, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
				if(!file_exists($pathd."/".$lastId)){
					if (!mkdir($pathd."/".$lastId, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
													
				$file_keterangana = array();
				$file_keterangand = array();
				$file_keteranganr = array();
				$fileidaa='';
				$fileidda='';
				$fileidra='';
				
				foreach($_POST as $key=>$value) {
					if ($key == 'fileketerangana') {
						foreach($value as $y=>$u) {
							$file_keterangana[$y] = $u;
						}
					}
					if ($key == 'namafilea') {
						foreach($value as $k=>$v) {
							$file_namea[$k] = $v;
						}
					}					
					//
					if ($key == 'fileida') {
						$i=0;
						foreach($value as $k=>$v) {
							$fileIda[$k] = $v;
							if($i==0){
								$fileidaa .= "'".$v."'";
							}else{
								$fileidaa .= ",'".$v."'";
							}
							$i++;
						}
					}
					if ($key == 'fileketerangand') {
						foreach($value as $y=>$u) {
							$file_keterangand[$y] = $u;
						}
					}
					if ($key == 'namafiled') {
						foreach($value as $k=>$v) {
							$file_named[$k] = $v;
						}
					}					
					//
					if ($key == 'fileidd') {
						$i=0;
						foreach($value as $k=>$v) {
							$fileIdd[$k] = $v;
							if($i==0){
								$fileidda .= "'".$v."'";
							}else{
								$fileidda .= ",'".$v."'";
							}
							$i++;
						}
					}
					if ($key == 'fileketeranganr') {
						foreach($value as $y=>$u) {
							$file_keteranganr[$y] = $u;
						}
					}
					if ($key == 'namafiler') {
						foreach($value as $k=>$v) {
							$file_namer[$k] = $v;
						}
					}					
					//
					if ($key == 'fileidr') {
						$i=0;
						foreach($value as $k=>$v) {

							$fileIdr[$k] = $v;
							if($i==0){
								$fileidra .= "'".$v."'";
							}else{
								$fileidra .= ",'".$v."'";
							}
							$i++;
						}
					}
				}

				//echo $fileidaa.'<br>'.$fileidra.'<br>'.$fileidda;exit();

				$tgl= date('Y-m-d H:i:s');
				$sql[]="update plc2.plc2_upb_file_protaccel set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileidaa.")";
				$sql[]="update plc2.plc2_upb_file_protreal set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileidra.")";
				$sql[]="update plc2.plc2_upb_file_stabpilot set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileidda.")";

				foreach ($sql as $k => $vsq) {
					try {
						$this->dbset->query($vsq);
					}catch(Exception $e) {
						die($e);
					}
				}
				//exit();

				$last_indexa = 0;
				$last_indexd = 0;
				$last_indexr = 0;
				
				if($isUpload) {			
					$a = $last_indexa;	
					//upload form 2
					if (isset($_FILES['fileuploada'])) {
						//$this->hapusfile($patha, $file_namea, 'plc2_upb_file_protaccel',$this->input->post('vkode_surat'));
						foreach ($_FILES['fileuploada']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_namea = $_FILES['fileuploada']["tmp_name"][$key];
								$namea = $_FILES['fileuploada']["name"][$key];
								$dataa['filename'] = $namea;
								$dataa['id']=$this->input->post('vkode_surat');
								$dataa['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$dataa['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_namea, $patha."/".$this->input->post('vkode_surat')."/".$namea)) 
				 				{
									$sqla[] = "INSERT INTO plc2_upb_file_protaccel(ifor_id, filename, dInsertDate, keterangan,cInsert) 
										VALUES ('".$dataa['id']."', '".$dataa['filename']."','".$dataa['dInsertDate']."','".$file_keterangana[$a]."','".$dataa['nip']."')";
									$a++;																			
								//print_r($sql1);
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sqla as $qa) {
						try {
							$this->dbset->query($qa);
						}catch(Exception $e) {
							die($e);
						}
					}
					
					//upload protokol realtime
					$rr = $last_indexr;	
					if (isset($_FILES['fileuploadr'])) {
						
						//$this->hapusfile($pathr, $file_namer, 'plc2_upb_file_protreal',$this->input->post('vkode_surat'));
						foreach ($_FILES['fileuploadr']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_namer = $_FILES['fileuploadr']["tmp_name"][$key];
								$namer = $_FILES['fileuploadr']["name"][$key];
								$datar['filename'] = $namer;
								$datar['id']=$this->input->post('vkode_surat');
								$datar['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$datar['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_namer, $pathr."/".$this->input->post('vkode_surat')."/".$namer)) 
				 				{
									$sqlr[] = "INSERT INTO plc2_upb_file_protreal(ifor_id, filename, dInsertDate, keterangan,cInsert) 
										VALUES ('".$datar['id']."', '".$datar['filename']."','".$datar['dInsertDate']."','".$file_keteranganr[$rr]."','".$datar['nip']."')";
									$rr++;		
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sqlr as $qr) {
						try {
							$this->dbset->query($qr);
						}catch(Exception $e) {
							die($e);
						}
					}
					
					//upload dokumen stabilita pilot
					$d = $last_indexd;	
					if (isset($_FILES['fileuploadd'])) {
						//$this->hapusfile($pathd, $file_named, 'plc2_upb_file_stabpilot',$this->input->post('vkode_surat'));
						foreach ($_FILES['fileuploadd']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_named = $_FILES['fileuploadd']["tmp_name"][$key];
								$named = $_FILES['fileuploadd']["name"][$key];
								$datad['filename'] = $named;
								$datad['id']=$this->input->post('vkode_surat');
								$datad['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$datad['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_named, $pathd."/".$this->input->post('vkode_surat')."/".$named)) 
				 				{
									$sqld[] = "INSERT INTO plc2_upb_file_stabpilot(ifor_id, filename, dInsertDate, keterangan,cInsert) 
										VALUES ('".$datad['id']."', '".$datad['filename']."','".$datad['dInsertDate']."','".$file_keterangand[$d]."','".$datad['nip']."')";
									$d++;																			
								//print_r($sqld);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sqld as $qd) {
						try {
							$this->dbset->query($qd);
						}catch(Exception $e) {
							die($e);
						}
					}
					$r['message'] = "Data Berhasil Di Simpan!";
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->post('product_trial_stabilita_pilot_ista_id');					
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
			case 'cekstabilita':
				echo  $this->cekstabilita();
				exit();
				break;
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();

				$this->db_plc0->where('ista_id', $get['last_id']);
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove = $get['type'] == 'PD' ? 'iapppd' : '';
				$this->db_plc0->update('plc2.plc2_upb_stabilita_pilot', array($iapprove=>2,'vnip_apppd'=>$nip,'tapppd'=>$skg));
		    
		    	$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
		                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
		                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
		                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
		                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
		                            from plc2.plc2_upb u where u.iupb_id='".$post['iupb_id']."'";
		        $rupb = $this->db_plc0->query($qupb)->row_array();

		        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id 
		                from plc2.plc2_upb u where u.iupb_id='".$post['iupb_id']."'";
		        $rsql = $this->db_plc0->query($qsql)->row_array();

		        //$query = $this->dbset->query($rsql);

		        $pd = $rsql['iteampd_id'];
		        $bd = $rsql['iteambusdev_id'];
		        $qa = $rsql['iteamqa_id'];
		        $qc = $rsql['iteamqc_id'];

		        $team = $pd. ','.$bd ;
		        
		        $toEmail2='';
		        $toEmail = $this->lib_utilitas->get_email_team( $bd );
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
		        $subject="Proses Stabilita Pilot Selesai: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada approval UPB oleh PD Manager pada proses Stabilita Pilot(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
		                                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>Praregistrasi - Input data oleh Busdev</td>
		                                </tr>
		                        </table>
		                </div>
		                <br/> 
		                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
		                Post Master";
		                        
		        $this->lib_utilitas->send_email($to, $cc, $subject, $content);

				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Confirm Success!';
				echo json_encode($r);
				exit();
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
function listBox_Action($row, $actions) {
	//print_r($row);
    if($row->iapppd<>0){
    	unset($actions['edit']);
    	unset($actions['delete']);
    }
    return $actions; 

	}
/*manipulasi view object form start*/

	/* Inser Button */
 	function insertBox_product_trial_stabilita_pilot_inumber($field, $id) {
		$return = 'Automated Generate';
		return $return;
	}

	function insertBox_product_trial_stabilita_pilot_vrealtime($field, $id) {
		$return = '<textarea name="'.$id.'" id="'.$id.'" class="required"></textarea>';
		return $return;
	}

	function insertBox_product_trial_stabilita_pilot_vaccelerate($field, $id) {
		$return = '<textarea name="'.$id.'" id="'.$id.'" class="required"></textarea>';
		return $return;
	}

	function insertBox_product_trial_stabilita_pilot_vbatch($field, $id) {
		$return = '<input type="text" name="'.$id.'" id="'.$id.'_dis" class="input_rows1 required" size="10" />';
		return $return;
	}

	function insertBox_product_trial_stabilita_pilot_vkode_surat($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1 required" size="20" />';
		$return .= '&nbsp;<button class="icon_pop" onclick="browse(\''.base_url().'processor/plc/browse/formula/stabpilot?action=index&field=product_trial_stabilita_pilot\',\'\',\'\',\'List Formula\')" type="button">&nbsp;</button>';
	
		return $return;
	}

	function insertBox_product_trial_stabilita_pilot_vupb_nomor($field, $id) {
		$return = '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="10" />';
		return $return;
	}

	function insertBox_product_trial_stabilita_pilot_vupb_nama($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="45" />';
	}

	function insertBox_product_trial_stabilita_pilot_vgenerik($field, $id) {
		return '<textarea disabled="TRUE" name="'.$id.'" id="'.$id.'"></textarea>';
	}

	function insertBox_product_trial_stabilita_pilot_protaccel($field, $id) {
		$data['mydept'] = $this->auth->my_depts(TRUE);	
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('stabilita_pilot_file_accel.php',$data,TRUE); 
	}

	function insertBox_product_trial_stabilita_pilot_protreal($field, $id) {
		$data['mydept'] = $this->auth->my_depts(TRUE);	
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('stabilita_pilot_file_real.php',$data,TRUE); 
	}

	function insertBox_product_trial_stabilita_pilot_dok_stab($field, $id) {
		$data['mydept'] = $this->auth->my_depts(TRUE);	
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('stabilita_pilot_file_dokstab.php',$data,TRUE); 
	}

	function insertBox_product_trial_stabilita_pilot_data_stabilita($field, $id) {
		return $this->load->view('product_trial_stabilita_pilot_data_stabilita','', TRUE);
	}

	function insertBox_product_trial_stabilita_pilot_history_stabilita($field, $id) {
		return '-';
	}
	function insertBox_product_trial_stabilita_pilot_vnip_apppd($field, $id) {
		return '-';
	}

	/* Update Box */

	function updateBox_product_trial_stabilita_pilot_inumber($field, $id, $value, $rowData) {
		$return = '<input type="text" name="'.$id.'" id="'.$id.'_dis" class="input_rows1 required" disabled="true" size="10" value="'.$value.'" onkeypress="return isFloatKey(event)"/>';
		return $return;
	}

	function updateBox_product_trial_stabilita_pilot_vrealtime($field, $id, $value, $rowData) {
		$return = '<textarea name="'.$id.'" id="'.$id.'" class="required">'.$value.'</textarea>';
		return $return;
	}

	function updateBox_product_trial_stabilita_pilot_vaccelerate($field, $id, $value, $rowData) {
		$return = '<textarea name="'.$id.'" id="'.$id.'" class="required">'.$value.'</textarea>';
		return $return;
	}

	function updateBox_product_trial_stabilita_pilot_vbatch($field, $id, $value, $rowData) {
		$return = '<input type="text" name="'.$id.'" id="'.$id.'_dis" class="input_rows1 required"  size="10" value="'.$value.'"/>';
		return $return;
	}

	function updateBox_product_trial_stabilita_pilot_vkode_surat($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb_formula', array('ifor_id'=>$rowData['ifor_id']))->row_array();
		$return = '<script>
		 $( "button.icon_pop" ).button({
		 		icons: {
		 		primary: "ui-icon-newwin"
		 		},
		 		text: false
		 		})
		</script>';
		$return = '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$rowData['ifor_id'].'" />';
		$return .= '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$row['vkode_surat'].'" disabled="true" />';
		return $return;
	}

	function updateBox_product_trial_stabilita_pilot_vupb_nomor($field, $id, $value, $rowData) {
		$sql = "SELECT vupb_nomor FROM plc2.plc2_upb_stabilita_pilot s, plc2.plc2_upb_formula f, plc2.plc2_upb u
				WHERE s.ifor_id = f.ifor_id AND f.iupb_id=u.iupb_id AND s.ifor_id='".$rowData['ifor_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		return '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" value="'.$row['vupb_nomor'].'" size="10" class="input_rows1" />';
	}

	function updateBox_product_trial_stabilita_pilot_vupb_nama($field, $id, $value, $rowData) {
		$sql = "SELECT vupb_nama FROM plc2.plc2_upb_stabilita_pilot s, plc2.plc2_upb_formula f, plc2.plc2_upb u
				WHERE s.ifor_id = f.ifor_id AND f.iupb_id=u.iupb_id AND s.ifor_id='".$rowData['ifor_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		return '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" value="'.$row['vupb_nama'].'" size="45" class="input_rows1" />';
	}

	function updateBox_product_trial_stabilita_pilot_vgenerik($field, $id, $value, $rowData) {
		$sql = "SELECT vgenerik FROM plc2.plc2_upb_stabilita_pilot s, plc2.plc2_upb_formula f, plc2.plc2_upb u
				WHERE s.ifor_id = f.ifor_id AND f.iupb_id=u.iupb_id AND s.ifor_id='".$rowData['ifor_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		$return = '<textarea name="'.$id.'" id="'.$id.'" class="required" disabled="true">'.$row['vgenerik'].'</textarea>';
		return $return;
	}

	function updateBox_product_trial_stabilita_pilot_tdate($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}

	function updateBox_product_trial_stabilita_pilot_protaccel($field, $id, $value, $rowData) {
		$ifor_id=$rowData['ifor_id'];
		$data['mydept'] = $this->auth->my_depts(TRUE);	
		$sql="select * from plc2.plc2_upb_file_protaccel where ifor_id=".$ifor_id." and ldeleted=0 order by id DESC limit 1";
		$data['rows'] = $this->db_plc0->query($sql)->result_array();
		return $this->load->view('stabilita_pilot_file_accel',$data,TRUE);
	}

	function updateBox_product_trial_stabilita_pilot_protreal($field, $id, $value, $rowData) {
		$ifor_id=$rowData['ifor_id'];
		$data['mydept'] = $this->auth->my_depts(TRUE);	
		$sql="select * from plc2.plc2_upb_file_protreal where ifor_id=".$ifor_id." and ldeleted=0 order by id DESC limit 1";
		$data['rows'] = $this->db_plc0->query($sql)->result_array();
		return $this->load->view('stabilita_pilot_file_real',$data,TRUE); 
	}
	function updateBox_product_trial_stabilita_pilot_ipilot($name, $id, $value) {
		$pilot = array(1=>'Stabilita pilot 1', 2=>'Stabilita pilot 2', 3=>'Stabilita Manufacturer');
		if($pilot[$value]=='' || $pilot[$value]=='0'){$pilot[$value]='-';}
		$return = '<input type="text" name="'.$id.'" id="'.$id.'_dis" class="input_rows1 required" disabled="true" size="45" value="'.$pilot[$value].'"/>';
		return $return;
	}

	function updateBox_product_trial_stabilita_pilot_dok_stab($field, $id, $value, $rowData) {
		$ifor_id=$rowData['ifor_id'];
		$data['mydept'] = $this->auth->my_depts(TRUE);	
		$sql="select * from plc2.plc2_upb_file_stabpilot where ifor_id=".$ifor_id." and ldeleted=0 order by id DESC limit 1";
		$data['rows'] = $this->db_plc0->query($sql)->result_array();
		return $this->load->view('stabilita_pilot_file_dokstab',$data,TRUE); 
	}

	function updateBox_product_trial_stabilita_pilot_data_stabilita($field, $id, $value, $rowData) {
		$this->db_plc0->where('ista_id', $rowData['ista_id']);
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('istai_id', 'asc');
		$data['rows'] = $this->db_plc0->get('plc2.plc2_upb_stabilita_pilot_item')->result_array();
		return $this->load->view('product_trial_stabilita_pilot_data_stabilita', $data, TRUE);
	}

	function updateBox_product_trial_stabilita_pilot_history_stabilita($name, $id, $value, $rowData) {
		//print_r($rowData);
		$ifor_id=$rowData['ifor_id'];
		
		
		 $sql="select f.vkode_surat from plc2.plc2_upb_formula f where f.ifor_id=$ifor_id";
		 $res=$this->db_plc0->query($sql)->row_array();
		 $data['vkode_surat']=$res['vkode_surat'];
		 $data['ifor_id']=$ifor_id;
		 $data['ista_id']=$rowData['ista_id'];
		 $data['ipilot']=$rowData['ipilot'];
		return $this->load->view('product_trial_stabilita_pilot_history',$data,TRUE);
	}
	function updateBox_product_trial_stabilita_pilot_vnip_apppd($field, $id, $value, $rowData) {
		return '-';
	}



/*manipulasi view object form end*/

/*manipulasi proses object form start*/
	function manipulate_insert_button($buttons){
		unset($buttons['save']);
		$js = $this->load->view('product_trial_stabilita_pilot_js');
		$js .= $this->load->view('uploadjs');
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){$type='PD';
				$save = '<button onclick="javascript:save_btn_multiupload(\'product_trial_stabilita_pilot\', \''.base_url().'processor/plc/product/trial/stabilita/pilot?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_product_trial_stabilita_pilot">Save</button>';
				
				$buttons['save'] = $save.$js;
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';
				$save = '<button onclick="javascript:save_btn_multiupload(\'product_trial_stabilita_pilot\', \''.base_url().'processor/plc/product/trial/stabilita/pilot?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_product_trial_stabilita_pilot">Save</button>';
				$buttons['save'] = $save.$js;
			}
			else{$type='';}
		}
		return $buttons;
	}
	function manipulate_update_button($buttons, $rowData){
		$cNip=$this->user->gNIP;
		
		if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			unset($buttons['update_back']);
			unset($buttons['update']);
			$js = $this->load->view('product_trial_stabilita_pilot_js');
			$js .= $this->load->view('uploadjs');
			$where2="inumber <".$rowData['inumber']; // cek kalo ada ipilot yg sama dan nomernya kurang dari itu
			$this->db_plc0->where($where2);
			$this->db_plc0->where('iapppd', 0);		
			$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
			$this->db_plc0->where('ipilot', $rowData['ipilot']);		
			$this->db_plc0->where('ldeleted', '0'); //tambahin ldeleted=0
			$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_stabilita_pilot');
			//echo $rowData['vnip_formulator']."<br>".$this->user->gNIP;
			$user = $this->auth->user();
		
			$x=$this->auth->dept();
			if($this->auth->is_manager()){
				$x=$this->auth->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){$type='PD';}
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
			
			//echo $this->auth->my_teams();
			
			$ifor_id=$rowData['ifor_id'];
			$ista_id=$rowData['ista_id'];
			$qcek="select f.iapppd from plc2.plc2_upb_stabilita_pilot f where f.ista_id=$ista_id";
			$rcek = $this->db_plc0->query($qcek)->row_array();
			
			//get upb_id
			$qupb="select f.iupb_id from plc2.plc2_upb_formula f where f.ifor_id=$ifor_id";
			$rupb = $this->db_plc0->query($qupb)->row_array();
			
			$rowData['iupb_id']=$rupb['iupb_id'];
			$sql= "SELECT * FROM plc2.plc2_upb_stabilita_pilot s, plc2.plc2_upb_formula f, plc2.plc2_upb u
				WHERE s.ifor_id = f.ifor_id AND f.iupb_id=u.iupb_id AND s.ifor_id='".$rowData['ifor_id']."'";
			$dt=$this->dbset->query($sql)->row_array();
			$setuju = '<button onclick="javascript:setuju(\'product_trial_stabilita_pilot\', \''.base_url().'processor/plc/product/trial/stabilita/pilot?action=confirm&last_id='.$this->input->get('id').'&type='.$type.'&ifor_id='.$rowData['ifor_id'].'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Confirm</button>';

			if($this->auth->is_manager()){ //jika manager PD
				if(($type=='PD')&&($rcek['iapppd']==0) &&($j2==0)){
					$update = '<button onclick="javascript:update_btn_back(\'product_trial_stabilita_pilot\', \''.base_url().'processor/plc/product/trial/stabilita/pilot?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
					$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stabilita/pilot?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ista_id='.$rowData['ista_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Approve</button>';
					$buttons['update'] = $update.$setuju.$js;
				}
				else{}
			}
			else{
				if(($type=='PD')&&($rcek['iapppd']==0)&&($j2==0)){
					$update = '<button onclick="javascript:update_btn_back(\'product_trial_stabilita_pilot\', \''.base_url().'processor/plc/product/trial/stabilita/pilot?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
					$buttons['update'] = $update.$js;
				}
			}
		}

    	return $buttons;

	}
   
/*manipulasi proses object form end*/  
function before_insert_processor($row, $postData){
	$this->load->helper('to_mysql');
	$skrg = date('Y-m-d H:i:s');
	$postData['tdate'] = to_mysql($postData['tdate']);
	$postData['product_trial_stabilita_pilot_tdate'] = to_mysql($postData['product_trial_stabilita_pilot_tdate']);
	unset($postData['detvrealtime']);
	unset($postData['detvaccelerate']);
	unset($postData['detistai_id']);
	$postData['ifor_id']=$postData['vkode_surat'];
	unset($postData['vkode_surat']);
	unset($postData['vupb_nomor']);
	unset($postData['vgenerik']);
	unset($postData['vupb_nama']);
	unset($postData['vnip_apppd']);
	$sql="select max(st.inumber) as number from plc2.plc2_upb_stabilita_pilot st where st.ifor_id=".$postData['ifor_id']." and st.ipilot=".$postData['product_trial_stabilita_pilot_ipilot']." and st.vbatch=".$postData['product_trial_stabilita_pilot_vbatch']." and st.ldeleted=0";
	$dt=$this->dbset->query($sql)->row_array();
	switch ($dt['number']) {
		case '0':
			$postData['inumber']=1;
			break;
		case '1':
			$postData['inumber']=3;
			break;
		case '3':
			$postData['inumber']=6;
			break;
		case '6':
			$postData['inumber']=9;
			break;
		case '9':
			$postData['inumber']=12;
			break;
		case '12':
			$postData['inumber']=24;
			break;
		default:
			$postData['inumber']=0;
			break;
	}
	//print_r($postData);exit();
	return $postData;
}  
function before_update_processor($row, $postData) {
    	$this->load->helper('to_mysql');
		$skrg = date('Y-m-d H:i:s');
		$postData['tdate'] = to_mysql($postData['tdate']);
		unset($postData['detvrealtime']);
		unset($postData['detvaccelerate']);
		unset($postData['detistai_id']);
		
		unset($postData['inumber']);
		unset($postData['ipilot']);
		unset($postData['vbatch']);
		unset($postData['data_stabilita']);
		unset($postData['vkode_surat']);
		// unset($postData['vrevisi']);
		unset($postData['vhpp']);
		unset($postData['vupb_nomor']);
		unset($postData['vgenerik']);
		unset($postData['vupb_nama']);
		
		return $postData;
    }

  function after_insert_processor($row, $updateId, $postData) {
		
		$this->load->helper('search_array');
		$post = $this->input->post();	

		//delete dulu, lalu insert detail
		$this->db_plc0->where('ista_id', $updateId);
		$this->db_plc0->update('plc2.plc2_upb_stabilita_pilot_item', array('ldeleted'=>1));
		
		$realtime = $post['detvrealtime'];
		$param = $post['detvparam'];
		$syarat = $post['detvsyarat'];
		$accel = $post['detvaccelerate'];
		
		foreach($realtime as $k => $v) {
			if(!empty($v)) {
				$idet['ista_id'] = $updateId;
				$idet['vparam'] = $param[$k];
				$idet['vsyarat'] = $syarat[$k];
				$idet['vaccelerate']=$accel[$k];
				$idet['vrealtime'] = $realtime[$k];
				$this->db_plc0->insert('plc2.plc2_upb_stabilita_pilot_item', $idet);
			}
		}
	}

/*function pendukung end*/  
function cekstabilita(){
	$post=$_POST;
	//$inumber = $post['product_trial_stabilita_pilot_inumber'];
	$ifor_id = $post['product_trial_stabilita_pilot_vkode_surat'];
	$ipilot = $post['product_trial_stabilita_pilot_ipilot'];
	$vbatch = $post['product_trial_stabilita_pilot_vbatch'];

	/*
	$where="inumber >=".$inumber;
	$this->db_plc0->where($where);		
	$this->db_plc0->where('ifor_id', $ifor_id);		
	$this->db_plc0->where('ipilot', $ipilot);
	$this->db_plc0->where('vbatch', $vbatch);		
	$this->db_plc0->where('ldeleted', '0'); //tambahin ldeleted=0
	$j = $this->db_plc0->count_all_results('plc2.plc2_upb_stabilita_pilot');
	
	$where2="inumber <=".$inumber;
	$this->db_plc0->where($where2);
	$this->db_plc0->where('iapppd', 0);		
	$this->db_plc0->where('ifor_id', $ifor_id);		
	$this->db_plc0->where('ipilot', $ipilot);
	$this->db_plc0->where('vbatch', $vbatch);		
	$this->db_plc0->where('ldeleted', '0'); //tambahin ldeleted=0
	$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_stabilita_pilot');
	*/
	if($ipilot==1){
	$jenis='Stabilita Pilot 1';
	}
	elseif($ipilot==2){
	$jenis='Stabilita Pilot 2';
	}
	elseif($ipilot==3){
	$jenis='Stabilita Manufacturer';
	}
	/*
	if($j > 0) {
		$data['status']=false;
		$data['message']='Stabilita Pilot jenis '.$jenis.' Bulan ke '.$inumber.' sudah pernah di input, harap masukan bulan selanjutnya';
	}elseif($j2 > 0) {
		$data['status']=false;
		$data['message']='Stabilita Pilot jenis '.$jenis.' Bulan sebelumnya belum di approve, harap approve dulu';
	}  
	else {
		$data['status']=true;
		$data['message']='success';
	}*/
	$sql="select max(st.inumber) as number from plc2.plc2_upb_stabilita_pilot st where st.ifor_id=".$ifor_id." and st.ipilot=".$ipilot." and st.vbatch=".$vbatch." and st.ldeleted=0";
	$dt=$this->dbset->query($sql)->row_array();
	if($dt['number']>=24){
		$data['status']=false;
		$data['message']='Stabilita Pilot jenis '.$jenis.' Batch ke '.$vbatch.' sudah mencapai batas maximun bulan ke 24!';
	}else {
		$data['status']=true;
		$data['message']='success';
	}
	echo json_encode($data);
	exit();
}

function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$pathu = $_GET['path'];
		$path = file_get_contents('./files/plc/'.$pathu.'/'.$id.'/'.$name);	
		force_download($name, $path);
	}

	public function output(){
		$this->index($this->input->get('action'));
	}

}
