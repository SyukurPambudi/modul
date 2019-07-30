<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bahan_kemas extends MX_Controller {
	var $_url;
	var $dbset;
    function __construct() {
        parent::__construct();
		$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->load->library('biz_process');
        $this->load->library('lib_utilitas');
        $this->load->library('lib_flow');
		$this->user = $this->auth_localnon->user(); 
		$this->dbset = $this->load->database('plc', true);
		$this->_table = 'plc2.plc2_upb_bahan_kemas';
		$this->_table_plc_upb = 'plc2.plc2_upb';
		$this->_table_plc_team = 'plc2.plc2_upb_team';
		$this->_url = 'bahan_kemas';
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setFormUpload(TRUE);
		$grid->setTitle('Dokumentasi Spesifikasi Bahan kemas');		
		$grid->setTable($this->_table);		
		$grid->setUrl('bahan_kemas');
		//$grid->addList('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','vtitle','iSubmit','iapppc','iapppd','iappbd','iappqa');
		$grid->addList('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','vtitle','iSubmit','iapppd','iappbd','iappqa');
		//$grid->addList('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','vtitle','itipe','iapppd','iappbd','iappqa');
		$grid->setJoinTable($this->_table_plc_upb, $this->_table_plc_upb.'.iupb_id = '.$this->_table.'.iupb_id', 'inner');
		$grid->setRelation('plc2_upb.iteambusdev_id', $this->_table_plc_team, 'iteam_id', 'vteam', 'bdteam','inner', array('vtipe'=>'BD','ldeleted'=>0), array('vteam'=>'asc'));
		$grid->setSortBy('plc2_upb_bahan_kemas.ibk_id');
		$grid->setSortOrder('desc');
		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','vtitle');
		//$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','vtitle','itipe');
		//$grid->addFields('vtitle','iupb_id','itipe','filename','vversi','vrevisi','vnip_apppd','vnip_appbd','vnip_appqa');
		// $grid->addFields('vtitle','iupb_id','ijenis_bk_id','ijenis_bk_id_sk','ijenis_bk_id_tr','filename','dmf','vversi','vrevisi','vnip_apppc','vnip_apppd','vnip_appbd','vnip_appqa');
		$grid->addFields('vtitle','iupb_id','ijenis_bk_id','ijenis_bk_id_sk','ijenis_bk_id_tr','filename','dmf','vversi','vrevisi','vnip_apppd','vnip_appbd','vnip_appqa');
		//$grid->addFields('vtitle','iupb_id','ijenis_bk_id','ijenis_bk_id_sk','ijenis_bk_id_tr','filename','DMF','coars','ws','lsa','vversi','vrevisi','vnip_apppd','vnip_appbd','vnip_appqa');
		$grid->setRequired('vtitle','ijenis_bk_id','iupb_id');
		/*
		$grid->changeFieldType('filename','upload');
		$grid->setUploadPath('filename', './files/plc/bahan_kemas/');
		$grid->setAllowedTypes('filename', 'gif|jpg|png|jpeg|pdf'); // * For Semua
		$grid->setMaxSize('filename', '1000');
		*/
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setWidth('plc2_upb.vupb_nomor', '73');
		$grid->setLabel('iupb_id', 'UPB');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setLabel('plc2_upb.iteambusdev_id','Team Busdev');
		$grid->setLabel('vtitle','Title');
		$grid->setWidth('plc2_upb.vupb_nama','200');
		$grid->setWidth('vtitle','200');
		$grid->setWidth('iSubmit','120');
		$grid->setWidth('iapppc','120');
		$grid->setWidth('iapppd','120');
		$grid->setWidth('iappbd','120');
		$grid->setWidth('iappqa','120');
		//$grid->setLabel('itipe','Kemasan');
		$grid->setLabel('ijenis_bk_id','Kemasan Primer');
		$grid->setLabel('ijenis_bk_id_sk','Kemasan Sekunder');
		$grid->setLabel('ijenis_bk_id_tr','Kemasan Tersier');
		$grid->setLabel('filename','File');
		$grid->setLabel('vversi','Kode Kemas');
		$grid->setLabel('vrevisi','Revisi');
		//$grid->setLabel('vnip_apppd','Approval PD');
		//20160314 , ganti label by SSID 250821
		$grid->setLabel('vnip_apppd','Approval PD');
		$grid->setLabel('vnip_appqa','Approval QA');
		$grid->setLabel('vnip_appbd','Approval Busdev');
		$grid->setLabel('vnip_apppc', 'Approval Packdev');
		$grid->setLabel('iapppd','Approval PD');
		$grid->setLabel('iappqa','Approval QA');
		$grid->setLabel('iappbd','Approval Busdev');
		$grid->setLabel('iapppc','Approval Packdev');

		$grid->setLabel('iSubmit','Status');
		 $grid->setLabel('dmf','File DMF');
		// $grid->setLabel('coars','File COA RS');
		// $grid->setLabel('ws','File WS');
		// $grid->setLabel('lsa','File LSA');
		
		$grid->setFormWidth('vrevisi',3);
		$grid->setFormWidth('vversi',3);
		
		$grid->setQuery('plc2_upb_bahan_kemas.ldeleted', 0);
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
			elseif(in_array('QA', $manager)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			elseif(in_array('BD', $manager)){
				$type='BD';
				$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth_localnon->my_teams().')', null);
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
			elseif(in_array('QA', $team)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			elseif(in_array('BD', $team)){
				$type='BD';
				$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		
		//$grid->changeFieldType('itipe','combobox','',array('' => '-', 1=>'Primer', 2=>'Sekunder', 3=>'Leaflet'));		
		//$grid->changeFieldType('itipe','combobox','',array('' => '-',  1=>'Primer', 2=>'UB (Sekunder)',3=>'MB (Sekunder)', 4=>'Label (Sekunder)', 5=>'Leaflet (Sekunder)'));		
		
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				/*$isUpload = $this->input->get('isUpload');
				$sql = array();
   				if($isUpload) {
					$path = realpath("files/plc/bahan_kemas/");
					$pathd = realpath("files/plc/dmf/");
					// $pathc = realpath("files/plc/coars/");
					// $pathw = realpath("files/plc/ws/");
					// $pathl = realpath("files/plc/lsa/");
					$sql1= 'select * from plc2.plc2_upb_bahan_kemas bk where ibk_id='.$this->input->get('lastId');
					$dt=$this->dbset->query($sql1)->row_array();
					$iupb_id=$dt['iupb_id'];
					if (!mkdir($path."/".$this->input->get('lastId'), 0777, true)) {
					    die('Failed upload, try again!');
					}
					if (!mkdir($pathd."/".$iupb_id, 0777, true)) {
					    die('Failed upload, try again!');
					}
					// if (!mkdir($pathc."/".$this->input->get('lastId'), 0777, true)) {
					    // die('Failed upload, try again!');
					// }
					// if (!mkdir($pathw."/".$this->input->get('lastId'), 0777, true)) {
					    // die('Failed upload, try again!');
					// }
					// if (!mkdir($pathl."/".$this->input->get('lastId'), 0777, true)) {
					    // die('Failed upload, try again!');
					// }
					
					$file_keterangan = array();
					$ijenis_bk_id = array();
					$fileketerangandmf = array();
					// $file_keteranganc = array();
					// $file_keteranganw = array();
					// $file_keteranganl = array();
					
					foreach($_POST as $key=>$value) {						
						if ($key == 'fileketerangan') {
							foreach($value as $k=>$v) {
								$file_keterangan[$k] = $v;
							}
						}
						if ($key == 'ijenis_bk_id') {
							foreach($value as $k=>$v) {
								$ijenis_bk_id[$k] = $v;
							}
						}
						if ($key == 'fileketerangandmf') {
							foreach($value as $k=>$v) {
								$fileketerangandmf[$k] = $v;
							}
						}
						// if ($key == 'fileketeranganw') {
							// foreach($value as $k=>$v) {
								// $file_keteranganw[$k] = $v;
							// }
						// }
						// if ($key == 'fileketeranganl') {
							// foreach($value as $k=>$v) {
								// $file_keteranganl[$k] = $v;
							// }
						// }
					}
					$i = 0;

					foreach ($_FILES['fileupload']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {				
							$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
							$name = $_FILES['fileupload']["name"][$key];
							$data['filename'] = $name;
							$data['id']=$this->input->get('lastId');
							$data['nip']=$this->user->gNIP;
							$data['iupb_id'] = $insertId;
							//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							$data['dInsertDate'] = date('Y-m-d H:i:s');
							if(move_uploaded_file($tmp_name, $path."/".$this->input->get('lastId')."/".$name)) {	
								$sql[] = "INSERT INTO plc2_upb_file_bahan_kemas(iupb_id, ijenis_bk_id ,filename, dInsertDate, vketerangan,cInsert) 
										VALUES ('".$data['id']."', '".$ijenis_bk_id[$i]."', '".$data['filename']."','".$data['dInsertDate']."','".$file_keterangan[$i]."','".$data['nip']."')";
								$i++;																			
							}
							else{
							echo "Upload ke folder gagal";	
							}
						}
					}
						//upload 
						foreach($sql as $q) {
							try {
								$this->dbset->query($q);
							}catch(Exception $e) {
								die($e);
							}
						}
					
					// //upload dmf
					$i=0;

					foreach ($_FILES['fileuploaddmf']["error"] as $key => $error) {
						 if ($error == UPLOAD_ERR_OK) {				
							$tmp_named = $_FILES['fileuploaddmf']["tmp_name"][$key];
							$named = $_FILES['fileuploaddmf']["name"][$key];
							$datad['fileuploaddmf'] = $named;

							$datad['iddmf']=$this->input->get('lastId');
							$datad['nipdmf']=$this->user->gNIP;
							$data['iupb_id'] = $insertId;
							 //$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							$datad['dInsertDate'] = date('Y-m-d H:i:s');
							if(move_uploaded_file($tmp_named, $pathd."/2377/".$named)) {	
								$sqldmf[] = "INSERT INTO plc2.plc2_upb_file_bk_dmf(iupb_id, filename, dInsertDate, vketerangan,cInsert) 
									VALUES ('".$iupb_id."', '".$datad['fileuploaddmf']."','".$datad['dInsertDate']."','".$fileketerangandmf[$i]."','".$datad['nipdmf']."')";
								$i++;																			
							}
							else{
								echo "Upload ke folder gagal";	
							}
						}
						
					}
					// //upload 
					foreach($sqldmf as $qdmf) {
						try {
							$this->dbset->query($qdmf);
						}catch(Exception $e) {
							die($e);
						}
					}
					
					// //upload coa rs
					// foreach ($_FILES['fileuploadc']["error"] as $key => $error) {
						// if ($error == UPLOAD_ERR_OK) {				
							// $tmp_namec = $_FILES['fileuploadc']["tmp_name"][$key];
							// $namec = $_FILES['fileuploadc']["name"][$key];
							// $datac['filename'] = $namec;
							// $datac['id']=$this->input->get('lastId');
							// $datac['nip']=$this->user->gNIP;
							// //$data['iupb_id'] = $insertId;
							// //$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							// $datac['dInsertDate'] = date('Y-m-d H:i:s');
							// if(move_uploaded_file($tmp_namec, $pathc."/".$this->input->get('lastId')."/".$namec)) {	
								// $sqlc[] = "INSERT INTO plc2_upb_file_bk_coars(ibk_id, filename, dInsertDate, vketerangan,cInsert) 
										// VALUES ('".$datac['id']."', '".$datac['filename']."','".$datac['dInsertDate']."','".$file_keteranganc[$i]."','".$datac['nip']."')";
								// $i++;																			
							// }
							// else{
							// echo "Upload ke folder gagal";	
							// }
						// }
						
					// }
					// //upload 
					// foreach($sqlc as $qc) {
						// try {
							// $this->dbset->query($qc);
						// }catch(Exception $e) {
							// die($e);
						// }
					// }
					// //upload ls
					// foreach ($_FILES['fileuploadl']["error"] as $key => $error) {
						// if ($error == UPLOAD_ERR_OK) {				
							// $tmp_namel = $_FILES['fileuploadl']["tmp_name"][$key];
							// $namel = $_FILES['fileuploadl']["name"][$key];
							// $datal['filename'] = $namel;
							// $datal['id']=$this->input->get('lastId');
							// $datal['nip']=$this->user->gNIP;
							// //$data['iupb_id'] = $insertId;
							// //$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							// $datal['dInsertDate'] = date('Y-m-d H:i:s');
							// if(move_uploaded_file($tmp_namel, $pathl."/".$this->input->get('lastId')."/".$namel)) {	
								// $sqll[] = "INSERT INTO plc2_upb_file_bk_lsa(ibk_id, filename, dInsertDate, vketerangan,cInsert) 
										// VALUES ('".$datal['id']."', '".$datal['filename']."','".$datal['dInsertDate']."','".$file_keteranganl[$i]."','".$datal['nip']."')";
								// $i++;																			
							// }
							// else{
							// echo "Upload ke folder gagal";	
							// }
						// }
						
					// }
					// //upload 
					// foreach($sqll as $ql) {
						// try {
							// $this->dbset->query($ql);
						// }catch(Exception $e) {
							// die($e);
						// }
					// }
					
					// //upload ws
					// foreach ($_FILES['fileuploadw']["error"] as $key => $error) {
						// if ($error == UPLOAD_ERR_OK) {				
							// $tmp_namew = $_FILES['fileuploadw']["tmp_name"][$key];
							// $namew = $_FILES['fileuploadw']["name"][$key];
							// $dataw['filename'] = $namew;
							// $dataw['id']=$this->input->get('lastId');
							// $dataw['nip']=$this->user->gNIP;
							// //$data['iupb_id'] = $insertId;
							// //$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							// $dataw['dInsertDate'] = date('Y-m-d H:i:s');
							// if(move_uploaded_file($tmp_namew, $pathw."/".$this->input->get('lastId')."/".$namew)) {	
								// $sqlw[] = "INSERT INTO plc2_upb_file_bk_ws(ibk_id, filename, dInsertDate, vketerangan,cInsert) 
										// VALUES ('".$dataw['id']."', '".$dataw['filename']."','".$dataw['dInsertDate']."','".$file_keteranganw[$i]."','".$dataw['nip']."')";
								// $i++;																			
							// }
							// else{
							// echo "Upload ke folder gagal";	
							// }
						// }
						
					// }
					// //upload 
					// foreach($sqlw as $qw) {
						// try {
							// $this->dbset->query($qw);
						// }catch(Exception $e) {
							// die($e);
						// }
					// }
					
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');					
					echo json_encode($r);
					exit();
				}  else {
					echo $grid->saved_form();
				}
				*/

				$isUpload = $this->input->get('isUpload');
   				if($isUpload) {
   					$lastId=$this->input->get('lastId');
					$path = realpath("files/plc/bahan_kemas");
					if(!file_exists($path."/".$lastId)){
						if (!mkdir($path."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
					}
					$ijenis_bk_id=array();
					$fileketerangan = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'fileketerangan') {
							foreach($value as $k=>$v) {
								$fileketerangan[$k] = $v;
							}
						}
						if ($key == 'ijenis_bk_id') {
							foreach($value as $k=>$v) {
								$ijenis_bk_id[$k] = $v;
							}
						}
					}
					$i=0;
					foreach ($_FILES['fileupload']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {
							$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
							$name =$_FILES['fileupload']["name"][$key];
							$data['filename'] = $name;
							//$data['id']=$idossier_dok_list_id;
							$data['dInsertDate'] = date('Y-m-d H:i:s');

								if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
									$sql[] = "INSERT INTO plc2.plc2_upb_file_bahan_kemas(ibk_id, ijenis_bk_id ,filename, dInsertDate, vketerangan,cInsert) 
											VALUES (".$lastId.",'".$ijenis_bk_id[$i]."','".$data['filename']."','".$data['dInsertDate']."','".$fileketerangan[$i]."','".$this->user->gNIP."')";
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

					//upload dmf
					$fileketerangandmf = array();
					$iupb_id = $this->input->post('bahan_kemas_iupb_id');

					$pathdmf = realpath("files/plc/dmf");
					if(!file_exists($pathdmf."/".$iupb_id)){
						if (!mkdir($pathdmf."/".$iupb_id, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
					}
					
					foreach($_POST as $key=>$value) {						
						if ($key == 'fileketerangandmf') {
							foreach($value as $k=>$v) {
								$fileketerangandmf[$k] = $v;
							}
						}
					}

					$i=0;
					if(isset($_FILES['fileuploaddmf'])){
						foreach ($_FILES['fileuploaddmf']["error"] as $key => $error) {
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileuploaddmf']["tmp_name"][$key];
								$name =$_FILES['fileuploaddmf']["name"][$key];
								$data['filename'] = $name;
								//$data['id']=$idossier_dok_list_id;
								$data['dInsertDate'] = date('Y-m-d H:i:s');

									if(move_uploaded_file($tmp_name, $pathdmf."/".$iupb_id."/".$name)) {
										$sqldmf[] = "INSERT INTO plc2.plc2_upb_file_bk_dmf(iupb_id ,filename, dInsertDate, vketerangan,cInsert) 
												VALUES (".$iupb_id.",'".$data['filename']."','".$data['dInsertDate']."','".$fileketerangandmf[$i]."','".$this->user->gNIP."')";
										$i++;	
									}
									else{
										echo "Upload ke folder gagal";	
									}
							}
						}
						foreach($sqldmf as $qdmf) {
							try {
								$this->dbset->query($qdmf);
							}catch(Exception $e) {
								die($e);
							}
						}
					}
					$r['message'] = 'Data Berhasil di Simpan!';
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');					
					echo json_encode($r);
				}  else {
						echo $grid->saved_form();
				}
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				//print_r($this->input->post());
				/*$isUpload = $this->input->get('isUpload');
				
				$sql1 = array();
				$file_name1= "";
				$fileId1 = array();
				$sqldmf = array();
				// $file_named= "";
				// $fileIdd = array();
				// $sqlc = array();
				// $file_namec= "";
				// $fileIdc = array();
				// $sqll = array();
				// $file_namel= "";
				// $fileIdl = array();
				// $sqlw = array();
				// $file_namew= "";
				// $fileIdw = array();
				
				$path = realpath("files/plc/bahan_kemas");
				$pathd = realpath("files/plc/dmf");
				// $pathc= realpath("files/plc/coars");
				// $pathl = realpath("files/plc/lsa");
				// $pathw = realpath("files/plc/ws");
				
				if (!file_exists( $path."/".$this->input->post('bahan_kemas_ibk_id') )) { 
					mkdir($path."/".$this->input->post('bahan_kemas_ibk_id'), 0777, true);					    
				}
				if (!file_exists( $pathd."/".$this->input->post('bahan_kemas_ibk_id') )) { 
					mkdir($pathd."/".$this->input->post('bahan_kemas_ibk_id'), 0777, true);					    
				}
				// if (!file_exists( $pathc."/".$this->input->post('bahan_kemas_ibk_id') )) { 
					// mkdir($pathc."/".$this->input->post('bahan_kemas_ibk_id'), 0777, true);					    
				// }
				// if (!file_exists( $pathl."/".$this->input->post('bahan_kemas_ibk_id') )) { 
					// mkdir($pathl."/".$this->input->post('bahan_kemas_ibk_id'), 0777, true);					    
				// }
				// if (!file_exists( $pathw."/".$this->input->post('bahan_kemas_ibk_id') )) { 
					// mkdir($pathw."/".$this->input->post('bahan_kemas_ibk_id'), 0777, true);					    
				// }
									
				$file_keterangan = array();
				$ijenis_bk_id = array();
				$fileketerangandmf = array();
				// $file_keteranganc = array();
				// $file_keteranganl = array();
				// $file_keteranganw = array();
				//print_r($_POST);
				foreach($_POST as $key=>$value) {
					if ($key == 'fileketerangan') {
						foreach($value as $y=>$u) {
							$file_keterangan[$y] = $u;
						}
					}
					if ($key == 'namafile') {
						foreach($value as $k=>$v) {
							$file_name1[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid') {
						foreach($value as $k=>$v) {
							$fileId1[$k] = $v;
						}
					}
					if ($key == 'ijenis_bk_id') {
						foreach($value as $k=>$v) {
							$ijenis_bk_id[$k] = $v;
						}
					}
					$fileiddmf='';
   					foreach($_POST as $key=>$value) {
											
						if ($key == 'fileketerangandmf') {
							foreach($value as $y=>$u) {
								$fileketerangandmf[$y] = $u;
							}
						}
						if ($key == 'namafileddmf') {
							foreach($value as $k=>$v) {
								$namafileddmf[$k] = $v;
							}
						}
						if ($key == 'fileiddmf') {
							$i=0;
							foreach($value as $k=>$v) {
								if($i==0){
									$fileiddmf .= "'".$v."'";
								}else{
									$fileiddmf .= ",'".$v."'";
								}
								$i++;
							}
						}
					}
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.plc2_upb_file_bk_dmf set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ibk_id='".$this->input->post('bahan_kemas_ibk_id')."' and id not in (".$fileiddmf.")";
					$this->dbset->query($sql1);
					// if ($key == 'namafiled') {
						// foreach($value as $k=>$v) {
							// $file_named[$k] = $v;
						// }
					// }					
					// //
					// if ($key == 'fileid') {
						// foreach($value as $k=>$v) {
							// $fileIdd[$k] = $v;
						// }
					// }
					// if ($key == 'fileketeranganc') {
						// foreach($value as $y=>$u) {
							// $file_keteranganc[$y] = $u;
						// }
					// }
					// if ($key == 'namafilec') {
						// foreach($value as $k=>$v) {
							// $file_namec[$k] = $v;
						// }
					// }					
					// //
					// if ($key == 'fileidc') {
						// foreach($value as $k=>$v) {
							// $fileIdc[$k] = $v;
						// }
					// }
					// if ($key == 'fileketeranganl') {
						// foreach($value as $y=>$u) {
							// $file_keteranganl[$y] = $u;
						// }
					// }
					// if ($key == 'namafilel') {
						// foreach($value as $k=>$v) {
							// $file_namel[$k] = $v;
						// }
					// }					
					// //
					// if ($key == 'fileidl') {
						// foreach($value as $k=>$v) {
							// $fileIdl[$k] = $v;
						// }
					// }
					// if ($key == 'fileketeranganw') {
						// foreach($value as $y=>$u) {
							// $file_keteranganw[$y] = $u;
						// }
					// }
					// if ($key == 'namafilew') {
						// foreach($value as $k=>$v) {
							// $file_namew[$k] = $v;
						// }
					// }					
					// //
					// if ($key == 'fileidw') {
						// foreach($value as $k=>$v) {
							// $fileIdw[$k] = $v;
						// }
					// }
				}

				$last_index1 = 0;
				$last_indexd = 0;
				// $last_indexc = 0;
				// $last_indexl = 0;
				// $last_indexw = 0;
				
				if($isUpload) {			
					$a = $last_index1;	
					//upload form 2
					if (isset($_FILES['fileupload'])) {
						
						$this->hapusfile($path, $file_name1, 'plc2_upb_file_bahan_kemas',$this->input->post('bahan_kemas_ibk_id'), 'ibk_id');
						foreach ($_FILES['fileupload']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name1 = $_FILES['fileupload']["tmp_name"][$key];
								$name1 = $_FILES['fileupload']["name"][$key];
								$data1['filename'] = $name1;
								$data1['id']=$this->input->post('bahan_kemas_ibk_id');
								$data1['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data1['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name1, $path."/".$this->input->post('bahan_kemas_ibk_id')."/".$name1)) 
				 				{
									$sql1[] = "INSERT INTO plc2_upb_file_bahan_kemas(ibk_id, ijenis_bk_id, filename, dInsertDate, vketerangan,cInsert) 
										VALUES ('".$data1['id']."','".$ijenis_bk_id[$a]."', '".$data1['filename']."','".$data1['dInsertDate']."','".$file_keterangan[$a]."','".$data1['nip']."')";
									$a++;																			
								//print_r($sql1);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sql1 as $q1) {
						try {
							$this->dbset->query($q1);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($ijenis_bk_id as $xkey1=>$xx1){
						$idnya1=$fileId1[$xkey1];
						$sqlc13="update plc2_upb_file_bahan_kemas bk set bk.ijenis_bk_id='$xx1' where bk.id='$idnya1' ";
						$this->dbset->query($sqlc13);
					}
					
					// //upload dmf
					 $d = $last_indexd;	
					if (isset($_FILES['fileuploaddmf'])) {
						
						// $this->hapusfile($pathd, $file_named, 'plc2_upb_file_bk_dmf',$this->input->post('bahan_kemas_ibk_id'), 'ibk_id');
						foreach ($_FILES['fileuploaddmf']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_named = $_FILES['fileuploaddmf']["tmp_name"][$key];
								$named = $_FILES['fileuploaddmf']["name"][$key];
								$datad['filenamedmf'] = $named;
								$datad['iddmf']=$this->input->post('bahan_kemas_ibk_id');
								$datad['nipdmf']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$datad['dInsertDate'] = date('Y-m-d H:i:s');
				 				// //$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_named, $pathd."/".$this->input->post('bahan_kemas_ibk_id')."/".$named)) 
				 				{
									$sqldmf[] = "INSERT INTO plc2.plc2_upb_file_bk_dmf(ibk_id, filename, dInsertDate, vketerangan,cInsert) 
										 VALUES ('".$datad['iddmf']."', '".$datad['filenamedmf']."','".$datad['dInsertDate']."','".$fileketerangandmf[$d]."','".$datad['nipdmf']."')";
									$d++;																			
								// //print_r($sql1);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sqldmf as $qdmf) {
						 try {
							$this->dbset->query($qdmf);
						}catch(Exception $e) {
							die($e);
						}
					}
					
					// //upload coars
					// $c = $last_indexc;	
					// if (isset($_FILES['fileuploadc'])) {
						
						// $this->hapusfile($pathc, $file_namec, 'plc2_upb_file_bk_coars',$this->input->post('bahan_kemas_ibk_id'), 'ibk_id');
						// foreach ($_FILES['fileuploadc']["error"] as $key => $error) {	
							// if ($error == UPLOAD_ERR_OK) {
								// $tmp_namec = $_FILES['fileuploadc']["tmp_name"][$key];
								// $namec = $_FILES['fileuploadc']["name"][$key];
								// $datac['filename'] = $namec;
								// $datac['id']=$this->input->post('bahan_kemas_ibk_id');
								// $datac['nip']=$this->user->gNIP;
								// //$data['iupb_id'] = $insertId;
								// $datad['dInsertDate'] = date('Y-m-d H:i:s');
				 				// //$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				// if(move_uploaded_file($tmp_namec, $pathc."/".$this->input->post('bahan_kemas_ibk_id')."/".$namec)) 
				 				// {
									// $sqlc[] = "INSERT INTO plc2_upb_file_bk_coars(ibk_id, filename, dInsertDate, vketerangan,cInsert) 
										// VALUES ('".$datac['id']."', '".$datac['filename']."','".$datac['dInsertDate']."','".$file_keteranganc[$c]."','".$datac['nip']."')";
									// $c++;																			
								// //print_r($sql1);
								// }
								// else{
								// echo "Upload ke folder gagal";	
								// }
							// }
						// }
					// }
										
					// foreach($sqlc as $qc) {
						// try {
							// $this->dbset->query($qc);
						// }catch(Exception $e) {
							// die($e);
						// }
					// }
					
					// //upload ls
					// $l = $last_indexl;	
					// if (isset($_FILES['fileuploadl'])) {
						
						// $this->hapusfile($pathl, $file_namel, 'plc2_upb_file_bk_lsa',$this->input->post('bahan_kemas_ibk_id'), 'ibk_id');
						// foreach ($_FILES['fileuploadl']["error"] as $key => $error) {	
							// if ($error == UPLOAD_ERR_OK) {
								// $tmp_namel = $_FILES['fileuploadl']["tmp_name"][$key];
								// $namel = $_FILES['fileuploadl']["name"][$key];
								// $datal['filename'] = $namel;
								// $datal['id']=$this->input->post('bahan_kemas_ibk_id');
								// $datal['nip']=$this->user->gNIP;
								// //$data['iupb_id'] = $insertId;
								// $datal['dInsertDate'] = date('Y-m-d H:i:s');
				 				// //$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				// if(move_uploaded_file($tmp_namel, $pathl."/".$this->input->post('bahan_kemas_ibk_id')."/".$namel)) 
				 				// {
									// $sqll[] = "INSERT INTO plc2_upb_file_bk_lsa(ibk_id, filename, dInsertDate, vketerangan,cInsert) 
										// VALUES ('".$datal['id']."', '".$datal['filename']."','".$datal['dInsertDate']."','".$file_keteranganl[$c]."','".$datal['nip']."')";
									// $l++;																			
								// //print_r($sql1);
								// }
								// else{
								// echo "Upload ke folder gagal";	
								// }
							// }
						// }
					// }
										
					// foreach($sqll as $ql) {
						// try {
							// $this->dbset->query($ql);
						// }catch(Exception $e) {
							// die($e);
						// }
					// }
					// //upload ws
					// $w = $last_indexw;	
					// if (isset($_FILES['fileuploadw'])) {
						
						// $this->hapusfile($pathw, $file_namew, 'plc2_upb_file_bk_ws',$this->input->post('bahan_kemas_ibk_id'), 'ibk_id');
						// foreach ($_FILES['fileuploadw']["error"] as $key => $error) {	
							// if ($error == UPLOAD_ERR_OK) {
								// $tmp_namew = $_FILES['fileuploadw']["tmp_name"][$key];
								// $namew = $_FILES['fileuploadw']["name"][$key];
								// $dataw['filename'] = $namew;
								// $dataw['id']=$this->input->post('bahan_kemas_ibk_id');
								// $dataw['nip']=$this->user->gNIP;
								// //$data['iupb_id'] = $insertId;
								// $datal['dInsertDate'] = date('Y-m-d H:i:s');
				 				// //$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				// if(move_uploaded_file($tmp_namew, $pathw."/".$this->input->post('bahan_kemas_ibk_id')."/".$namew)) 
				 				// {
									// $sqlw[] = "INSERT INTO plc2_upb_file_bk_ws(ibk_id, filename, dInsertDate, vketerangan,cInsert) 
										// VALUES ('".$dataw['id']."', '".$dataw['filename']."','".$dataw['dInsertDate']."','".$file_keteranganw[$c]."','".$dataw['nip']."')";
									// $w++;																			
								// //print_r($sql1);
								// }
								// else{
								// echo "Upload ke folder gagal";	
								// }
							// }
						// }
					// }
										
					// foreach($sqlw as $qw) {
						// try {
							// $this->dbset->query($qw);
						// }catch(Exception $e) {
							// die($e);
						// }
					// }
					
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->post('bahan_kemas_ibk_id');					
					echo json_encode($r);
					exit();
				}  else {
					if (is_array($file_name1)) {									
						$this->hapusfile($path, $file_name1, 'plc2_upb_file_bahan_kemas',$this->input->post('bahan_kemas_ibk_id'),'ibk_id');
					}
					 foreach($ijenis_bk_id as $xkey1=>$xx1){
						 $idnya1=$fileId1[$xkey1];
						 $sqlc13="update plc2_upb_file_bahan_kemas bk set bk.ijenis_bk_id='$xx1' where bk.id='$idnya1' ";
						 $this->dbset->query($sqlc13);
					 }
					
					
					// if (is_array($file_named)) {									
						// $this->hapusfile($pathd, $file_named, 'plc2_upb_file_bk_dmf',$this->input->post('bahan_kemas_ibk_id'),'ibk_id');
					// }
					// if (is_array($file_namec)) {									
						// $this->hapusfile($pathc, $file_namec, 'plc2_upb_file_bk_coars',$this->input->post('bahan_kemas_ibk_id'),'ibk_id');
					// }
					// if (is_array($file_namel)) {									
						// $this->hapusfile($pathl, $file_namel, 'plc2_upb_file_bk_lsa',$this->input->post('bahan_kemas_ibk_id'),'ibk_id');
					// }
					// if (is_array($file_namew)) {									
						// $this->hapusfile($pathw, $file_namew, 'plc2_upb_file_bk_ws',$this->input->post('bahan_kemas_ibk_id'),'ibk_id');
					// }
					echo $grid->updated_form();
				}*/

				$isUpload = $this->input->get('isUpload');
				$post=$this->input->post();
				$lastId=$post['bahan_kemas_ibk_id'];
				$iupb_id=$post['bahan_kemas_iupb_id'];
				$path = realpath("files/plc/bahan_kemas/");
				if(!file_exists($path."/".$lastId)){
					if (!mkdir($path."/".$lastId, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}

				$pathdmf = realpath("files/plc/dmf/");
				if(!file_exists($pathdmf."/".$iupb_id)){
					if (!mkdir($pathdmf."/".$iupb_id, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
									
				$fileketerangan = array();	
				$ifileid = array();
				$ijenis_bk_id=array();
				$fileid='';
				$j=0;
				foreach($_POST as $key=>$value) {
					
					if ($key == 'fileid') {
						$i=0;
						foreach($value as $k=>$v) {
							$ifileid[$k]=$v;
							if($i==0){
								$fileid .= "'".$v."'";
							}else{
								$fileid .= ",'".$v."'";
							}
							if($v!=''){
								$j++;
							}
							$i++;
						}
					}				
					if ($key == 'fileketerangan') {
						foreach($value as $y=>$u) {
							$fileketerangan[$y] = $u;
						}
					}
					if ($key == 'namafile') {
						foreach($value as $k=>$v) {
							$namafile[$k] = $v;
						}
					}
					if ($key == 'ijenis_bk_id') {

						foreach($value as $k=>$v) {
							$ijenis_bk_id[$k] = $v;
						}
					}
				}

				$tgl= date('Y-m-d H:i:s');

				if($fileid!=''){
					$sql1="update plc2.plc2_upb_file_bahan_kemas set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ibk_id='".$lastId."' and id not in (".$fileid.")";
					$this->dbset->query($sql1);
				}
				$s=array();

				foreach ($ifileid as $if => $va) {
					if($va!=''){
						$s[]="update plc2.plc2_upb_file_bahan_kemas set ijenis_bk_id=".$ijenis_bk_id[$if].", dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where id =".$va;
					}
				}

				foreach($s as $ql) {
					try {
						$this->dbset->query($ql);
					}catch(Exception $e) {
						die($e);
					}
				}

				//update upload dmf

				$fileiddmf='';
				$jmlfile=0;
				foreach($_POST as $key=>$value) {
										
					if ($key == 'fileketerangandmf') {
						foreach($value as $y=>$u) {
							$fileketerangandmf[$y] = $u;
						}
					}
					if ($key == 'namafileddmf') {
						foreach($value as $k=>$v) {
							$namafileddmf[$k] = $v;
						}
					}
					if ($key == 'fileiddmf') {
						foreach($value as $k=>$v) {
							if($jmlfile==0){
								$fileiddmf .= "'".$v."'";
							}else{
								$fileiddmf .= ",'".$v."'";
							}
							$jmlfile++;
						}
					}
				}
				
				//delete proses

				$tgl= date('Y-m-d H:i:s');
				if($jmlfile==0){
					$sql1="update plc2.plc2_upb_file_bk_dmf set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where iupb_id='".$iupb_id."'";
					$this->dbset->query($sql1);
				}else{
					$sql1="update plc2.plc2_upb_file_bk_dmf set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where iupb_id='".$iupb_id."' and id not in (".$fileiddmf.")";
					$this->dbset->query($sql1);
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
								if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
									$sql[] = "INSERT INTO plc2.plc2_upb_file_bahan_kemas(ibk_id, ijenis_bk_id ,filename, dInsertDate, vketerangan,cInsert) 
											VALUES (".$lastId.",'".$ijenis_bk_id[$j]."','".$data['filename']."','".$data['dInsertDate']."','".$fileketerangan[$i]."','".$this->user->gNIP."')";
									$i++;
									$j++;	
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

										
					if (isset($_FILES['fileuploaddmf']))  {

						$i=0;
						foreach ($_FILES['fileuploaddmf']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileuploaddmf']["tmp_name"][$key];
								$name =$_FILES['fileuploaddmf']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $pathdmf."/".$iupb_id."/".$name)) {
									$sqldmf[] = "INSERT INTO plc2.plc2_upb_file_bk_dmf(iupb_id ,filename, dInsertDate, vketerangan,cInsert) 
											VALUES (".$iupb_id.",'".$data['filename']."','".$data['dInsertDate']."','".$fileketerangandmf[$i]."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sqldmf as $qdmf) {
							try {
								$this->dbset->query($qdmf);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}
					$r['message'] = 'Data Berhasil di Simpan!';
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');				
					echo json_encode($r);
					exit();
				}  else {
					echo $grid->updated_form();
				}

				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'download':
				$this->download($this->input->get('file'));
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
			case 'cekjnsbk':
				$id=$this->input->post('id');
				$sql='select mbk.itipe_bk as idtipe_bk from plc2.plc2_master_jenis_bk mbk where mbk.ldeleted=0 AND mbk.ijenis_bk_id='.$id;
				$dt=$this->dbset->query($sql)->row_array();
				$data['id']=$dt['idtipe_bk'];
				$data['value']=$id;
				echo json_encode($data);
				break;
			default:
				$grid->render_grid();
				break;
		}
    }
	function listBox_Action($row, $actions) {
		$type='';
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
			}
			elseif(in_array('QA', $manager)){
				$type='QA';
			}
			elseif(in_array('BD', $manager)){
				$type='BD';
			}elseif(in_array('PPC',$manager)){
				$type='PPC';
			}
			else{$type='';}
			$iSubmit=$row->iSubmit;
			$iapppc=$row->iapppc;
			$iapppd=$row->iapppd;
			$iappbd=$row->iappbd;
			$iappqa=$row->iappqa;
			if($type=='PD'){
				//echo "halllo";
				if(($iSubmit==1)&&($iapppd==0)&&($iappbd==0)&&($iappqa==0)){
					unset($actions['delete']);
					//unset($actions['edit']); 
				// }
				// elseif(($iSubmit==1)&&($iapppc==2)&&($iapppd==0)&&($iappbd==0)&&($iappqa==0)){
				// 	unset($actions['delete']);
				}else{
					unset($actions['delete']);
					unset($actions['edit']);
				}
			}elseif($type=='PPC'){
				if(($iSubmit==0)&&($iapppc==0)&&($iapppd==0)&&($iappbd==0)&&($iappqa==0)){
					$actions['edit'];
					$actions['delete'];
				}elseif(($iSubmit==1)&&($iapppc==0)&&($iapppd==0)&&($iappbd==0)&&($iappqa==0)){
					unset($actions['delete']);
				}else{
					unset($actions['delete']);
					unset($actions['edit']);
				}
			}elseif($type=='QA'){
				//if(($iSubmit==1)&&($iapppc==2)&&($iapppd==2)&&($iappbd==2)&&($iappqa==0)){
				if(($iSubmit==1)&&($iapppd==2)&&($iappbd==2)&&($iappqa==0)){
					unset($actions['delete']);
				}else{
					unset($actions['delete']);
					unset($actions['edit']);
				}
			}elseif($type=='BD'){
				//if(($iSubmit==1)&&($iapppc==2)&&($iapppd==2)&&($iappbd==0)&&($iappqa==0)){
				if(($iSubmit==1)&&($iapppd==2)&&($iappbd==0)&&($iappqa==0)){
					unset($actions['delete']);
				}else{
					unset($actions['delete']);
					unset($actions['edit']);
				}
			}else{
				unset($actions['edit']);
				unset($actions['delete']);
			}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
			}
			else{$type='';}
		}
    	return $actions;
    }
    function listBox_bahan_kemas_iSubmit($value) {
    	if($value==0){$vstatus='Need To Submit';}
    	elseif($value==1){$vstatus='Submited';}
    	return $vstatus;
    }
    function listBox_bahan_kemas_iapppc($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	function listBox_bahan_kemas_iapppd($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	function listBox_bahan_kemas_iappqa($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	function listBox_bahan_kemas_iappbd($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	//Keterangan approval 

    function insertBox_bahan_kemas_vnip_apppc($field, $id) {
		return '-';
	}
	function updateBox_bahan_kemas_vnip_apppc($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($rowData['iapppc'] <>0)){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_apppc']))->row_array();
			if($rowData['iapppc']==2){$st="Approve";}elseif($rowData['iapppc']==1){$st="Reject";
				// $rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// if(isset($rowa)){$reason=$rowa['treason'];}
				
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_apppc'].' )'.' pada '.$rowData['tapppc'];
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}

	function insertBox_bahan_kemas_vnip_apppd($field, $id) {
		return '-';
	}
	function updateBox_bahan_kemas_vnip_apppd($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($rowData['iapppd'] <>0)){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_apppd']))->row_array();
			if($rowData['iapppd']==2){$st="Approve";}elseif($rowData['iapppd']==1){$st="Reject";
				// $rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// if(isset($rowa)){$reason=$rowa['treason'];}
				
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_apppd'].' )'.' pada '.$rowData['tapppd'];
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	function insertBox_bahan_kemas_vnip_appqa($field, $id) {
		return '-';
	}
	function updateBox_bahan_kemas_vnip_appqa($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($rowData['iappqa'] <>0)){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_appqa']))->row_array();
			if($rowData['iappqa']==2){$st="Approve";}
			elseif($rowData['iappqa']==1){$st="Reject";} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_appqa'].' )'.' pada '.$rowData['tappqa'];
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	function insertBox_bahan_kemas_vnip_appbd($field, $id) {
		return '-';
	}
	function updateBox_bahan_kemas_vnip_appbd($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($rowData['iappbd'] <>0)){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_appbd']))->row_array();
			if($rowData['iappbd']==2){$st="Approve";}
			elseif($rowData['iappbd']==1){$st="Reject";} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_appbd'].' )'.' pada '.$rowData['tappbd'];
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	//
	function insertBox_bahan_kemas_iupb_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft"><input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1 required" size="7" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/bahan/kemas?field=bahan_kemas&modul_id='.$this->input->get('modul_id').'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	function updateBox_bahan_kemas_iupb_id($field, $id, $value) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$value))->row_array();
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft"><input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" value="'.$row['vupb_nomor'].'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1 required" size="7" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/bahan/kemas?field=bahan_kemas&modul_id='.$this->input->get('modul_id').'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function insertBox_bahan_kemas_filename($field, $id) {
		$data['date'] = date('Y-m-d H:i:s');	
		$sql = "select mbk.ijenis_bk_id,mbk.vjenis_bk,
				(case
					when mbk.itipe_bk=1 then 'Primer'
					when mbk.itipe_bk=2 then 'Sekunder'
					else 'Tersier'
				end) as itipe_bk, mbk.itipe_bk as idtipe_bk from plc2.plc2_master_jenis_bk mbk where mbk.ldeleted=0 
				";
		$data['jenis_bk'] = $this->db_plc0->query($sql)->result_array();
		return $this->load->view('bahan_kemas_file',$data,TRUE);
	}
	function updateBox_bahan_kemas_filename($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		$sql = "select mbk.ijenis_bk_id,mbk.vjenis_bk,
				(case
					when mbk.itipe_bk=1 then 'Primer'
					when mbk.itipe_bk=2 then 'Sekunder'
					else 'Tersier'
				end) as itipe_bk, mbk.itipe_bk as idtipe_bk from plc2.plc2_master_jenis_bk mbk where mbk.ldeleted=0 
				";
		$data['jenis_bk'] = $this->db_plc0->query($sql)->result_array();
		$bkid = $rowData['ibk_id'];
		$sql="select * from plc2.plc2_upb_file_bahan_kemas where ibk_id=".$bkid." and (ldeleted=0 or ldeleted is null)";
		$data['rows'] = $this->db_plc0->query($sql)->result_array();
		return $this->load->view('bahan_kemas_file',$data,TRUE);
	}
	
	/*function updateBox_bahan_kemas_filename($field, $id, $value, $rowData) {
		$input = '<input type="file" name="'.$id.'" id="'.$id.'" class="" size="50" />';
		if($value != '') {
			if (file_exists('./files/plc/bahan_kemas/'.$value)) {
				$link = base_url().'processor/plc/bahan/kemas?action=download&file='.$value;
				$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			}
			else {
				$linknya = 'File sudah tidak ada!';
			}
			return 'File name : '.$value.' ['.$linknya.']<br />'.$input;
		}
		else {
			return 'No File<br />'.$input;
		}		
	}
*/
	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/'.$tempat.'/'.$id.'/'.$name);	
		force_download($name, $path);
	}	
	function insertBox_bahan_kemas_dmf($field, $id) {
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);	
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('bahan_kemas_file_dmf.php',$data,TRUE); 
	}
	
	function updateBox_bahan_kemas_dmf($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE); 
		$idfor = $rowData['iupb_id'];
		$sql = "select * from plc2.plc2_upb_file_bk_dmf where iupb_id=".$idfor. " AND (ldeleted is null or ldeleted = 0)";
		$data['rows'] = $this->db_plc0->query($sql)->result_array();
		//return $sql;
		return $this->load->view('bahan_kemas_file_dmf',$data,TRUE);			
	}
	// function insertBox_bahan_kemas_coars($field, $id) {
		// $data['mydept'] = $this->auth_localnon->my_depts(TRUE);	
		// $data['date'] = date('Y-m-d H:i:s');	
		// return $this->load->view('bahan_kemas_file_coars.php',$data,TRUE); 
	// }
	
	// function updateBox_bahan_kemas_coars($field, $id, $value, $rowData) {
		// /*$input = '<input type="file" name="'.$id.'" id="'.$id.'" class="" size="50" />';
		// if($value != '') {
			// if (file_exists('./files/plc/product_trial/formula_trial/'.$value)) {
				// $link = base_url().'processor/plc/product/trial/formula/skala/trial?action=download&file='.$value;
				// $linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			// }
			// else {
				// $linknya = 'File sudah tidak ada!';
			// }
			// return 'File name : '.$value.' ['.$linknya.']<br />'.$input;
		// }
		// else {
			// return 'No File<br />'.$input;
		// }
		 // */ 
		// $data['mydept'] = $this->auth_localnon->my_depts(TRUE); 
		 // $idfor = $rowData['ibk_id'];
		// $data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_bk_coars', array('ibk_id'=>$idfor))->result_array();
		// return $this->load->view('bahan_kemas_file_coars',$data,TRUE);			
	// }
	// function insertBox_bahan_kemas_lsa($field, $id) {
		// $data['mydept'] = $this->auth_localnon->my_depts(TRUE);	
		// $data['date'] = date('Y-m-d H:i:s');	
		// return $this->load->view('bahan_kemas_file_ls.php',$data,TRUE); 
	// }
	
	// function updateBox_bahan_kemas_lsa($field, $id, $value, $rowData) {
		// /*$input = '<input type="file" name="'.$id.'" id="'.$id.'" class="" size="50" />';
		// if($value != '') {
			// if (file_exists('./files/plc/product_trial/formula_trial/'.$value)) {
				// $link = base_url().'processor/plc/product/trial/formula/skala/trial?action=download&file='.$value;
				// $linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			// }
			// else {
				// $linknya = 'File sudah tidak ada!';
			// }
			// return 'File name : '.$value.' ['.$linknya.']<br />'.$input;
		// }
		// else {
			// return 'No File<br />'.$input;
		// }
		 // */ 
		// $data['mydept'] = $this->auth_localnon->my_depts(TRUE); 
		 // $idfor = $rowData['ibk_id'];
		// $data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_bk_lsa', array('ibk_id'=>$idfor))->result_array();
		// return $this->load->view('bahan_kemas_file_ls',$data,TRUE);			
	// }
	// function insertBox_bahan_kemas_ws($field, $id) {
		// $data['mydept'] = $this->auth_localnon->my_depts(TRUE);	
		// $data['date'] = date('Y-m-d H:i:s');	
		// return $this->load->view('bahan_kemas_file_ws.php',$data,TRUE); 
	// }
	
	// function updateBox_bahan_kemas_ws($field, $id, $value, $rowData) {
		// /*$input = '<input type="file" name="'.$id.'" id="'.$id.'" class="" size="50" />';
		// if($value != '') {
			// if (file_exists('./files/plc/product_trial/formula_trial/'.$value)) {
				// $link = base_url().'processor/plc/product/trial/formula/skala/trial?action=download&file='.$value;
				// $linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			// }
			// else {
				// $linknya = 'File sudah tidak ada!';
			// }
			// return 'File name : '.$value.' ['.$linknya.']<br />'.$input;
		// }
		// else {
			// return 'No File<br />'.$input;
		// }
		 // */ 
		// $data['mydept'] = $this->auth_localnon->my_depts(TRUE); 
		 // $idfor = $rowData['ibk_id'];
		// $data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_bk_ws', array('ibk_id'=>$idfor))->result_array();
		// return $this->load->view('bahan_kemas_file_ws',$data,TRUE);			
	// }
		
	function manipulate_insert_button($buttons) {
		unset($buttons['save']);
		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'bahan_kemas\', \''.base_url().'bahan_kemas\', this, true)" class="ui-button-text icon-save" id="button_save_draft_soi_mikrobiologi">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'bahan_kemas\', \''.base_url().'processor/plc/bahan/kemas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_Bahan_kemas">Save & Submit</button>';
		$js = $this->load->view('bahan_kemas_js');
		$js .= $this->load->view('uploadjs');
		$buttons['save'] = $save_draft.$save.$js;
		//$buttons['save'] = $save_draft.$save.$js;
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
								var url = "'.base_url().'processor/plc/bahan/kemas";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_bahan_kemas").html(data);
									});
					
								}
									reload_grid("grid_bahan_kemas");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_bahan_kemas_approve" action="'.base_url().'processor/plc/bahan/kemas?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="upb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="ibk_id" value="'.$this->input->get('ibk_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_bahan_kemas_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
        $nip = $this->user->gNIP;
        $skg=date('Y-m-d H:i:s');

		if($post['type'] == 'PPC'){$iapprove ='iapppc';$vapprove ='vnip_apppc';$tapprove ='tapppc';$master_action_id=12;}
		if($post['type'] == 'PAC'){$iapprove ='iapppc';$vapprove ='vnip_apppc';$tapprove ='tapppc';$master_action_id=12;} 
        if($post['type'] == 'PD'){$iapprove ='iapppd';$vapprove ='vnip_apppd';$tapprove ='tapppd';$master_action_id=9;}
        if($post['type'] == 'QA'){$iapprove ='iappqa';$vapprove ='vnip_appqa';$tapprove ='tappqa';$master_action_id=11;}
        if($post['type'] == 'BD'){$iapprove ='iappbd';$vapprove ='vnip_appbd';$tapprove ='tappbd';$master_action_id=3;}

        //$this->lib_flow->insert_logs($post['modul_id'],$post['upb_id'],$master_action_id,2);

		//$this->lib_flow->next_proses($post['modul_id'],$post['upb_id'],$master_action_id,2);

        $this->db_plc0->where('ibk_id', $post['ibk_id']);
        $this->db_plc0->update('plc2.plc2_upb_bahan_kemas', array($iapprove=>2,$vapprove=>$nip,$tapprove=>$skg));

        $iupb_id=$post['upb_id'];
        $ibk_id=$post['ibk_id'];

        /*
        $getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // activity 3 input data
        $bizsup=$getbp['idplc2_biz_process_sub'];

        $hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,1); // status 7 => submit
        if($hacek==1){ // jika sudah pernah ada data maka update saja
                //insert log
                        $this->biz_process->insert_log($iupb_id, $bizsup, 1); // status 7 => submit
                //update last log
                        $this->biz_process->update_last_log($iupb_id, $bizsup, 1);
        }
        elseif($hacek==0){
                //insert log
                        $this->biz_process->insert_log($iupb_id, $bizsup, 1); // status 7 => submit
                //insert last log
                        $this->biz_process->insert_last_log($iupb_id, $bizsup, 1);
        }
		*/


        if($post['type']=='PPC' or $post['PAC']){
        	//echo "HREHREHR";exit;
			$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
					from plc2.plc2_upb u where u.iupb_id='".$post['upb_id']."'";
			$rupb = $this->db_plc0->query($qupb)->row_array();
                        
                        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id 
                                from plc2.plc2_upb u where u.iupb_id='".$post['upb_id']."'";
			$rsql = $this->db_plc0->query($qsql)->row_array();
                        
                        //$query = $this->dbset->query($rsql);
   						$sql="select * from plc2.plc2_upb_team te where te.vtipe in('PAC') and te.ldeleted=0";
   						$dpp=$this->dbset->query($sql)->result_array();
   						$sa=array();
   						foreach ($dpp as $kp => $vp) {
   							$sa[]=$vp['iteam_id'];
   						}
   						$ppicid=implode(",",$sa);
                        $pd = $rsql['iteampd_id'];
                        $bd = $rsql['iteambusdev_id'];
                        $qa = $rsql['iteamqa_id'];
                        $team = $pd. ','.$qa. ','.$bd.",".$ppicid;
                        $toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_leader( $pd );
			$toEmail2 = $this->lib_utilitas->get_email_leader( $ppicid );
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
			$cc = $this->lib_utilitas->get_email_by_nip("N16945").';'.$arrEmail.';'.$toEmail2;
			//echo $to.'<br>'.$cc;exit;
			$subject="Bahan Kemas - Need Approval PD Manager";
			$content="
				Diberitahukan bahwa telah ada approval UPB oleh Packdev Manager pada proses Dokumentasi Spesifikasi Bahan kemas(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
							<td><b>Proses Selanjutnya</b></td><td> : </td><td>Bahan Kemas - Approval QA Manager</td>
						</tr>
					</table>
				</div>
				<br/> 
				Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
				Post Master";
			$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		}
		if($post['type']=='BD'){
			$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
					from plc2.plc2_upb u where u.iupb_id='".$post['upb_id']."'";
			$rupb = $this->db_plc0->query($qupb)->row_array();
                        
                        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id 
                                from plc2.plc2_upb u where u.iupb_id='".$post['upb_id']."'";
			$rsql = $this->db_plc0->query($qsql)->row_array();
                        
                        //$query = $this->dbset->query($rsql);
   						$sql="select * from plc2.plc2_upb_team te where te.vtipe in('PAC') and te.ldeleted=0";
   						$dpp=$this->dbset->query($sql)->result_array();
   						$sa=array();
   						foreach ($dpp as $kp => $vp) {
   							$sa[]=$vp['iteam_id'];
   						}
   						$ppicid=implode(",",$sa);
                        $pd = $rsql['iteampd_id'];
                        $bd = $rsql['iteambusdev_id'];
                        $qa = $rsql['iteamqa_id'];
                        $team = $pd. ','.$qa. ','.$bd;
                        $toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_leader( $qa );
			$toEmail2 = $this->lib_utilitas->get_email_leader( $bd );
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
			$cc .= $arrEmail.';'.$toEmail2;
			$subject="Bahan Kemas - Need Approval QA Manager";
			$content="
				Diberitahukan bahwa telah ada approval UPB oleh Busdev Manager pada proses Dokumentasi Spesifikasi Bahan kemas(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
							<td><b>Proses Selanjutnya</b></td><td> : </td><td>Bahan Kemas - Approval QA Manager</td>
						</tr>
					</table>
				</div>
				<br/> 
				Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
				Post Master";
			$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		}
		//jika PD approve, maka kirim email ke QA, BD
		elseif($post['type']=='PD'){
			$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
					from plc2.plc2_upb u where u.iupb_id='".$post['upb_id']."'";
			$rupb = $this->db_plc0->query($qupb)->row_array();
                        
                        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id 
                                from plc2.plc2_upb u where u.iupb_id='".$post['upb_id']."'";
			$rsql = $this->db_plc0->query($qsql)->row_array();
                        
            $pd = $rsql['iteampd_id'];
            $bd = $rsql['iteambusdev_id'];
            $qa = $rsql['iteamqa_id'];
                                    
            $team = $qa ;
            
            $toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_leader( $bd );
            $toEmail2 = $this->lib_utilitas->get_email_leader( $pd );                        

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
			$cc = $arrEmail.';'.$toEmail2;
			$subject="Bahan Kemas - Need Approval Busdev Manager";
			$content="
				Diberitahukan bahwa telah ada approval UPB oleh PD Manager pada proses Dokumentasi Spesifikasi Bahan kemas(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
							<td><b>Proses Selanjutnya</b></td><td> : </td><td>Bahan Kemas - Approval Busdev Manager</td>
						</tr>
					</table>
				</div>
				<br/> 
				Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
				Post Master";
			$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		}
                //jika QA approve, maka kirim email ke QA, BD dan PD
		elseif($post['type']=='QA'){
			$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
					from plc2.plc2_upb u where u.iupb_id='".$post['upb_id']."'";
			$rupb = $this->db_plc0->query($qupb)->row_array();
                        
            $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id 
                   from plc2.plc2_upb u where u.iupb_id='".$post['upb_id']."'";
			$rsql = $this->db_plc0->query($qsql)->row_array();
            $sql="select * from plc2.plc2_upb_team te where te.vtipe in('PAC') and te.ldeleted=0";
   						$dpp=$this->dbset->query($sql)->result_array();
   						$sa=array();
   						foreach ($dpp as $kp => $vp) {
   							$sa[]=$vp['iteam_id'];
   						}
   						$ppicid=implode(",",$sa);            
                        $pd = $rsql['iteampd_id'];
                        $bd = $rsql['iteambusdev_id'];
                        $qa = $rsql['iteamqa_id'];
                        $qc = $rsql['iteamqc_id'];                        

                        $team = $pd. ','.$qa. ','.$bd.',' .$qc.','.$ppicid ;
                        
            $toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_leader( $pd );
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
			$cc = $arrEmail.';'.$toEmail2;
			$subject="Proses Bahan Kemas Selesai: UPB ".$rupb['vupb_nomor'];
			$content="
				Diberitahukan bahwa telah ada approval UPB oleh QA Manager pada proses Dokumentasi Spesifikasi Bahan kemas(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
							<td><b>Proses Selanjutnya</b></td><td> : </td><td>Pembuatan MBR - Input data oleh PD</td>
						</tr>
					</table>
				</div>
				<br/> 
				Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
				Post Master";
			$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		}
        $data['status']  = true;
        $data['last_id'] = $ibk_id;
        return json_encode($data);
    }
    
    function reject_view() {
    	$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	if($("#remark").val()==""){
							alert("Isi alasan! ");
							return false;
						}
						 else{
							return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/bahan/kemas";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_bahan_kemas").html(data);
									});
					
								}
									reload_grid("grid_bahan_kemas");
							}
					 	 })
						 }
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_bahan_kemas_reject" action="'.base_url().'processor/plc/bahan/kemas?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="upb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="ibk_id" value="'.$this->input->get('ibk_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark" id="remark" required></textarea><button type="button" onclick="submit_ajax(\'form_bahan_kemas_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process () {
    	$post = $this->input->post();
    	$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
	 	if($post['type'] == 'PD'){$iapprove ='iapppd';$vapprove ='vnip_apppd';$tapprove ='tapppd';}
		if($post['type'] == 'QA'){$iapprove ='iappqa';$vapprove ='vnip_appqa';$tapprove ='tappqa';}
		if($post['type'] == 'BD'){$iapprove ='iappbd';$vapprove ='vnip_appbd';$tapprove ='tappbd';}
		$this->db_plc0->where('ibk_id', $post['ibk_id']);
		$this->db_plc0->update('plc2.plc2_upb_bahan_kemas', array($iapprove=>1,$vapprove=>$nip,$tapprove=>$skg));
    
		$iupb_id=$post['upb_id'];
		$ibk_id=$post['ibk_id'];
		/*
			$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // activity 3 input data
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
			$hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,1); // status 7 => submit
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 1); // status 7 => submit
				//update last log
					$this->biz_process->update_last_log($iupb_id, $bizsup, 1);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 1); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($iupb_id, $bizsup, 1);
			}
		*/
		$data['status']  = true;
    	$data['last_id'] = $ibk_id;
    	return json_encode($data);
    }
	function manipulate_update_button($buttons, $rowData) {
		if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
				unset($buttons['update']);
			unset($buttons['update_back']);
			
			//print_r($rowData);
			//echo $rowData['vnip_formulator']."<br>".$this->user->gNIP;
			$user = $this->auth_localnon->user();
		
			$x=$this->auth_localnon->dept();
			if($this->auth_localnon->is_manager()){
				$x=$this->auth_localnon->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){$type='PD';}
				elseif(in_array('QA', $manager)){$type='QA';}
				elseif(in_array('BD', $manager)){$type='BD';}
				elseif(in_array('PPC', $manager)){$type='PPC';}
				elseif(in_array('PAC', $manager)){$type='PAC';}
				else{$type='';}
			}
			else{
				$x=$this->auth_localnon->dept();
				$team=$x['team'];
				if(in_array('PD', $team)){$type='PD';}
				elseif(in_array('PAC', $team)){$type='PAC';}
				elseif(in_array('PPC', $team)){$type='PPC';}
				elseif(in_array('QA', $team)){$type='QA';}
				else{$type='';}
			}
			
			 
			// cek status upb, klao upb 
				unset($buttons['update_back']);
				unset($buttons['update']);
				
				//echo $this->auth_localnon->my_teams();
				$upb_id=$rowData['iupb_id'];
				$ibk_id=$rowData['ibk_id'];
				
				//cek 3 jenis bahan kemas baru bisa approve
				$sqlcek = "select bk.ijenis_bk_id_tr from plc2.plc2_upb_bahan_kemas bk where bk.ldeleted=0 and bk.ibk_id='".$ibk_id."'";
				$rowcek = $this->db_plc0->query($sqlcek)->row_array();
				$tersier=$rowcek['ijenis_bk_id_tr'];
				//echo $tersier; 
				//
				
				// print_r($rowData);exit();
				$js = $this->load->view('bahan_kemas_js');
				$js .= $this->load->view('uploadjs');
				
				$x=$this->auth_localnon->my_teams();
				if($this->auth_localnon->is_manager()){ //jika manager BD
							// if((($type=='PPC')||($type=='PAC'))&&($rowData['iapppc']==0)&&($rowData['iSubmit']==0)){
							// 	$update_drf='<button onclick="javascript:update_drf(\'bahan_kemas\', \''.base_url().'processor/plc/bahan/kemas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_Bahan_kemas">Update to Draft</button>';
							// 	$update = '<button onclick="javascript:update_btn_back(\'bahan_kemas\', \''.base_url().'processor/plc/bahan/kemas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_Bahan_kemas">Update & Submit</button>';
							// 	$buttons['update']=$update_drf.$update.$js;
							// }elseif((($type=='PPC')||($type=='PAC'))&&($rowData['iapppc']==0)&&($rowData['iSubmit']==1)){
							// 	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/kemas?action=approve&upb_id='.$upb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bahan_kemas">Approve</button>';
							// 	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/kemas?action=reject&upb_id='.$upb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bahan_kemas">Reject</button>';
							// 	$buttons['update'] = $approve.$reject;
							// }

							if((($type=='PD')||($type=='PD'))&&($rowData['iapppc']==0)&&($rowData['iSubmit']==0)){
								$update_drf='<button onclick="javascript:update_drf(\'bahan_kemas\', \''.base_url().'processor/plc/bahan/kemas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_Bahan_kemas">Update to Draft</button>';
								$update = '<button onclick="javascript:update_btn_back(\'bahan_kemas\', \''.base_url().'processor/plc/bahan/kemas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_Bahan_kemas">Update & Submit</button>';
								$buttons['update']=$update_drf.$update.$js;
							//}elseif((($type=='PD')||($type=='PD'))&&($rowData['iapppc']==0)&&($rowData['iSubmit']==1)){
							}elseif((($type=='PD')||($type=='PD'))&&($rowData['iSubmit']==1)){
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/kemas?action=approve&upb_id='.$upb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bahan_kemas">Approve</button>';
								$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/kemas?action=reject&upb_id='.$upb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bahan_kemas">Reject</button>';
								$buttons['update'] = $approve.$reject;
							}

							elseif(($type=='PD')&&($rowData['iapppd']==0)&&($rowData['iapppc']<>0)){// &&($tersier<>0)){
								//$update = '<button onclick="javascript:update_btn_back(\'bahan_kemas\', \''.base_url().'processor/plc/bahan/kemas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_Bahan_kemas">Update</button>';
								
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/kemas?action=approve&upb_id='.$upb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bahan_kemas">Approve</button>';
								$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/kemas?action=reject&upb_id='.$upb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bahan_kemas">Reject</button>';
								$buttons['update'] = $approve.$reject.$js;
							}
							elseif(($type=='BD')&&($rowData['iappbd']==0)&&($rowData['iapppd']<>0)){
							//elseif(($type=='BD')&&($rowData['iappbd']==0)&&($rowData['iapppd']<>0)&&($rowData['iapppc']<>0)){//&&($tersier<>0)){
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/kemas?action=approve&upb_id='.$upb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bahan_kemas">Approve</button>';
								$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/kemas?action=reject&upb_id='.$upb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bahan_kemas">Reject</button>';
								$buttons['update'] = $approve.$reject;
							}
							elseif(($type=='QA')&&($rowData['iappqa']==0)&&($rowData['iappbd']<>0)){
							//elseif(($type=='QA')&&($rowData['iappqa']==0)&&($rowData['iappbd']<>0)&&($rowData['iapppc']<>0)){//&&($tersier<>0)){
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/kemas?action=approve&upb_id='.$upb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bahan_kemas">Approve</button>';
								$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/kemas?action=reject&upb_id='.$upb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bahan_kemas">Reject</button>';
								$buttons['update'] = $approve.$reject;
							}
							else{}
						}
						else{
							if((($type=='PPC')||($type=='PAC')||($type=='PD'))&&($rowData['iapppc']==0)&&($rowData['iSubmit']==0)){
								$update_drf='<button onclick="javascript:update_drf(\'bahan_kemas\', \''.base_url().'processor/plc/bahan/kemas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_Bahan_kemas">Update to Draft</button>';
								$update = '<button onclick="javascript:update_btn_back(\'bahan_kemas\', \''.base_url().'processor/plc/bahan/kemas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_Bahan_kemas">Update & Submit</button>';
								$buttons['update']=$update_drf.$update.$js;
							}else{
									if(($type=='QA')&&($rowData['iappqa']==0)&&($rowData['iappbd']<>0)){
									//elseif(($type=='QA')&&($rowData['iappqa']==0)&&($rowData['iappbd']<>0)&&($rowData['iapppc']<>0)){//&&($tersier<>0)){
										$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/kemas?action=approve&upb_id='.$upb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bahan_kemas">Approve</button>';
										$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/kemas?action=reject&upb_id='.$upb_id.'&ibk_id='.$ibk_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bahan_kemas">Reject</button>';
										$buttons['update'] = $approve.$reject;
									}
							}
						}
		}

    	return $buttons;
		
	}
	function before_insert_processor($row, $postData) {
		//print_r($postData);exit();
		if($postData['isdraft']==true){
			$postData['iSubmit']=0;
		}else{
			$postData['iSubmit']=1;
		}
		return $postData;
	}
	function after_insert_processor($row, $insertId, $postData){
		//print_r($postData);
			$iupb_id=$postData['iupb_id'];
			$post = $this->input->post();
			$ijbk_primer=$post['ijbk_pr'];
			$ijbk_sekund=$post['ijbk_sk'];
			$ijbk_tersi=$post['ijbk_tr'];
			//insert detail primer
			foreach($ijbk_primer as $k => $v) {
				$idet['ibk_id'] = $insertId;
				$idet['ijenis_bk_id'] = $v;
				$idet['ldeleted'] = 0;
				$this->db_plc0->insert('plc2.plc2_upb_bk_primer_detail', $idet);
			}
			
			//insert detail sekunder
			foreach($ijbk_sekund as $k2 => $v2) {
				$idet2['ibk_id'] = $insertId;
				$idet2['ijenis_bk_id'] = $v2;
				$idet2['ldeleted'] = 0;
				$this->db_plc0->insert('plc2.plc2_upb_bk_sekunder_detail', $idet2);
			}
			
			//insert detail tersier
			foreach($ijbk_tersi as $k3 => $v3) {
				$idet3['ibk_id'] = $insertId;
				$idet3['ijenis_bk_id'] = $v3;
				$idet3['ldeleted'] = 0;
				$this->db_plc0->insert('plc2.plc2_upb_bk_tersier_detail', $idet3);
			}/*
			$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
			$hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,7); // status 7 => submit
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//update last log
					$this->biz_process->update_last_log($iupb_id, $bizsup, 7);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($iupb_id, $bizsup, 7);
			}*/
			//insert upb_proses_logs
			//$this->lib_flow->insert_logs($this->input->get('modul_id'),$iupb_id,1);
			
			/*Send Email*/
		if($post['iSubmit']==1){
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

	        $qppc="select * from plc2.plc2_upb_team te where te.ldeleted=0 and te.vtipe in('PAC')";
	        $dppc=$this->db_plc0->query($qppc);
	        if($dppc->num_rows()>=1){

		        //$query = $this->dbset->query($rsql);
	        	foreach ($dppc as $kppc => $vppc) {
	        		$ppcteam[]=$vppc['iteam_id'];
	        	}

	        	$ppic=implode(",",$ppcteam);

		        $pd = $rsql['iteampd_id'];
		        $bd = $rsql['iteambusdev_id'];
		        $qa = $rsql['iteamqa_id'];
		        $qc = $rsql['iteamqc_id'];
		        $pr = $rsql['iteampr_id'];
		        
		        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
		        
		        $toEmail2='';
		        $toEmail2 = $this->lib_utilitas->get_email_team( $ppic );
		        $toEmail = $this->lib_utilitas->get_email_leader( $ppic );                        

		        $arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );

		        $to = $cc = '';
		        if(is_array($arrEmail)) {
		                $count = count($arrEmail);
		                $to = $arrEmail[0];
		                for($i=1;$i<$count;$i++) {
		                        $cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
		                }
		        }			

		        $to = $toEmail2;
		        $cc = $toEmail;
		        $subject="Proses Bahan Kemas: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada inputan oleh Packdev Team pada proses Bahan Kemas(aplikasi PLC Non OTC) dengan rincian sebagai berikut :<br><br>
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
	        }
	    }
	}
	//tambahan untuk field jenis kemasan
	function listBox_bahan_kemas_ijenis_bk_id($value, $id, $column, $row) {
		//return $value;
		$sql = "select mbk.ijenis_bk_id,mbk.vjenis_bk,
				'Primer' as itipe_bk from plc2.plc2_master_jenis_bk mbk where mbk.ldeleted=0 AND mbk.ijenis_bk_id = '".$value."'";
		$row = $this->db_plc0->query($sql)->row_array();
		//print_r($row); 
		return $row['itipe_bk'].' > '.$row['vjenis_bk'];
	}
	function searchBox_bahan_kemas_ijenis_bk_id($fields, $id) {
		$sql = "select mbk.ijenis_bk_id,mbk.vjenis_bk,
				'Primer' as itipe_bk from plc2.plc2_master_jenis_bk mbk where mbk.itipe_bk=1 and mbk.ldeleted=0
				";
		$rows = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="combobox" id="'.$id.'">';
		$echo .= '<option value="">-- None --</option>';
		foreach($rows as $r) {
			$echo .= '<option value="'.$r['ijenis_bk_id'].'">'.$r['itipe_bk'].' > '.$r['vjenis_bk'].'</option>';
		}
		$echo .= '</select>';
		//return $this->db_plc0->last_query();
		return $echo;
	}
	function insertBox_bahan_kemas_ijenis_bk_id($field, $id) {
		$sql = "select mbk.ijenis_bk_id,mbk.vjenis_bk,
				'Primer' as itipe_bk from plc2.plc2_master_jenis_bk mbk where mbk.itipe_bk=1 and mbk.ldeleted=0 
				";
		$data['jenis_bk'] = $this->db_plc0->query($sql)->result_array();
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		return $this->load->view('bahan_kemas_detail_primer',$data,TRUE);
	}
	function updateBox_bahan_kemas_ijenis_bk_id($field, $id, $value, $rowData) {
		//print_r($rowData);
		$sql = "select mbk.ijenis_bk_id,mbk.vjenis_bk,
				'Primer' as itipe_bk from plc2.plc2_master_jenis_bk mbk where mbk.itipe_bk=1 and mbk.ldeleted=0 
				";
		$data['jenis_bk'] = $this->db_plc0->query($sql)->result_array();
		$sql = "select * from plc2.plc2_upb_bk_primer_detail pr where pr.ibk_id='".$rowData['ibk_id']."' and pr.ldeleted=0";
		$data['rows'] = $this->db_plc0->query($sql)->result_array();
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		return $this->load->view('bahan_kemas_detail_primer',$data,TRUE);
	}
	//jenis kemasan sekunder
	function insertBox_bahan_kemas_ijenis_bk_id_sk($field, $id) {
		$sql = "select mbk.ijenis_bk_id,mbk.vjenis_bk,
				'Sekunder' as itipe_bk from plc2.plc2_master_jenis_bk mbk where mbk.itipe_bk=2 and mbk.ldeleted=0 
				";
		$data['jenis_bk'] = $this->db_plc0->query($sql)->result_array();
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		return $this->load->view('bahan_kemas_detail_sekunder',$data,TRUE);
	}
	function updateBox_bahan_kemas_ijenis_bk_id_sk($field, $id, $value, $rowData) {
		//print_r($rowData);
		$sql = "select mbk.ijenis_bk_id,mbk.vjenis_bk,
				'Sekunder' as itipe_bk from plc2.plc2_master_jenis_bk mbk where mbk.itipe_bk=2 and mbk.ldeleted=0 
				";
		$data['jenis_bk'] = $this->db_plc0->query($sql)->result_array();
		$sql = "select * from plc2.plc2_upb_bk_sekunder_detail pr where pr.ibk_id='".$rowData['ibk_id']."' and pr.ldeleted=0";
		$data['rows'] = $this->db_plc0->query($sql)->result_array();
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		return $this->load->view('bahan_kemas_detail_sekunder',$data,TRUE);
	}
	//
	
	//jenis kemasan tersier
	function insertBox_bahan_kemas_ijenis_bk_id_tr($field, $id) {
		$sql = "select mbk.ijenis_bk_id,mbk.vjenis_bk,
				'Tersier' as itipe_bk from plc2.plc2_master_jenis_bk mbk where mbk.itipe_bk=3 and mbk.ldeleted=0 
				";
		$data['jenis_bk'] = $this->db_plc0->query($sql)->result_array();
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		return $this->load->view('bahan_kemas_detail_tersier',$data,TRUE);
	}
	function updateBox_bahan_kemas_ijenis_bk_id_tr($field, $id, $value, $rowData) {
		//print_r($rowData);
		$sql = "select mbk.ijenis_bk_id,mbk.vjenis_bk,
				'Tersier' as itipe_bk from plc2.plc2_master_jenis_bk mbk where mbk.itipe_bk=3 and mbk.ldeleted=0 
				";
		$data['jenis_bk'] = $this->db_plc0->query($sql)->result_array();
		$sql = "select * from plc2.plc2_upb_bk_tersier_detail pr where pr.ibk_id='".$rowData['ibk_id']."' and pr.ldeleted=0";
		$data['rows'] = $this->db_plc0->query($sql)->result_array();
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		return $this->load->view('bahan_kemas_detail_tersier',$data,TRUE);
	}
	//
	function before_update_processor($row, $post, $postData) {
		unset($postData['ijbk_pr']);
		$postData['tupdate']=date('Y-m-d H:i:s');
		//unset($postData['ijenis_bk_id_sk']);
		//unset($postData['ijenis_bk_id_tr']);
		if($postData['isdraft']==true){
			$postData['iSubmit']=0;
		}else{
			$postData['iSubmit']=1;
		}
		$postData['vversi']=$postData['bahan_kemas_vversi'];
		$postData['vrevisi']=$postData['bahan_kemas_vrevisi'];
		//print_r($postData);exit();
		return $postData;
	}
	function after_update_processor($row, $post, $postData) {
			$iupb_id=$postData['iupb_id'];
			$post = $this->input->post();
			$ijbk_primer=$post['ijbk_pr'];
			$ijbk_sekund=$post['ijbk_sk'];
			$ijbk_tersi=$post['ijbk_tr'];
			//update detail primer
			$this->db_plc0->where('ibk_id', $postData['ibk_id']);
			$this->db_plc0->update('plc2.plc2_upb_bk_primer_detail', array('ldeleted'=>1));
			
			foreach($ijbk_primer as $k => $v) {
				$idet['ibk_id'] = $postData['ibk_id'];
				$idet['ijenis_bk_id'] = $v;
				$idet['ldeleted'] = 0;
				$this->db_plc0->insert('plc2.plc2_upb_bk_primer_detail', $idet);
			}
			
			//update detail sekunder
			$this->db_plc0->where('ibk_id', $postData['ibk_id']);
			$this->db_plc0->update('plc2.plc2_upb_bk_sekunder_detail', array('ldeleted'=>1));
			
			foreach($ijbk_sekund as $k2 => $v2) {
				$idet2['ibk_id'] = $postData['ibk_id'];
				$idet2['ijenis_bk_id'] = $v2;
				$idet2['ldeleted'] = 0;
				$this->db_plc0->insert('plc2.plc2_upb_bk_sekunder_detail', $idet2);
			}
			
			//update detail tersier
			$this->db_plc0->where('ibk_id', $postData['ibk_id']);
			$this->db_plc0->update('plc2.plc2_upb_bk_tersier_detail', array('ldeleted'=>1));
			
			foreach($ijbk_tersi as $k3 => $v3) {
				$idet3['ibk_id'] = $postData['ibk_id'];
				$idet3['ijenis_bk_id'] = $v3;
				$idet3['ldeleted'] = 0;
				$this->db_plc0->insert('plc2.plc2_upb_bk_tersier_detail', $idet3);
			}
			/*
			$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
			$hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,7); // status 7 => submit
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//update last log
					$this->biz_process->update_last_log($iupb_id, $bizsup, 7);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($iupb_id, $bizsup, 7);
			}*/

			/*Send Email*/
		if($post['iSubmit']==1){
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

	        $qppc="select * from plc2.plc2_upb_team te where te.ldeleted=0 and te.vtipe in('PAC')";
	        $dppc=$this->db_plc0->query($qppc);
	        if($dppc->num_rows()>=1){

		        //$query = $this->dbset->query($rsql);
	        	foreach ($dppc as $kppc => $vppc) {
	        		$ppcteam[]=$vppc['iteam_id'];
	        	}

	        	$ppic=implode(",",$ppcteam);

		        $pd = $rsql['iteampd_id'];
		        $bd = $rsql['iteambusdev_id'];
		        $qa = $rsql['iteamqa_id'];
		        $qc = $rsql['iteamqc_id'];
		        $pr = $rsql['iteampr_id'];
		        
		        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
		        
		        $toEmail2='';
		        $toEmail2 = $this->lib_utilitas->get_email_team( $ppic );
		        $toEmail = $this->lib_utilitas->get_email_leader( $ppic );                        

		        $arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );

		        $to = $cc = '';
		        if(is_array($arrEmail)) {
		                $count = count($arrEmail);
		                $to = $arrEmail[0];
		                for($i=1;$i<$count;$i++) {
		                        $cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
		                }
		        }			

		        $to = $toEmail2;
		        $cc = $toEmail;
		        $subject="Proses Bahan Kemas: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada inputan oleh Packdev Team pada proses Bahan Kemas(aplikasi PLC Non OTC) dengan rincian sebagai berikut :<br><br>
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
	        }
	    }

		return $postData;
 	}
	function output(){		
    	$this->index($this->input->get('action'));
    }
	
	function readDirektory($path, $empty="") {
		$filename = array();
				
		if (empty($empty)) {
			if ($handle = opendir($path)) {		
				while (false !== ($entry = readdir($handle))) {
				   if ($entry != '.' && $entry != '..' && $entry != '.svn') {			   		
						//unlink($path."/".$entry);
						$filename[] = $entry;
					}
				}		
				closedir($handle);
			}
				
			$x =  $filename;
		} else {
			if ($handle = opendir($path)) {		
				while (false !== ($entry = readdir($handle))) {
				   if ($entry != '.' && $entry != '..' && $entry != '.svn') {			   		
						//echo $path."/".$entry;
						unlink($path."/".$entry);					
					}
				}		
				closedir($handle);
			}
			
			$x = "";
		}
		
		return $x;
	}
	
	
	function hapusfile($path, $file_name, $table, $lastId){
		$path = $path."/".$lastId;
		$path = str_replace("\\", "/", $path);
		
		if (is_array($file_name)) {			
			$list_dir  = $this->readDirektory($path);
			$list_sql  = $this->readSQL($table, $lastId);
			asort($file_name);		
			asort($list_dir);		
			asort($list_sql);
			
			//$del = array();
			foreach($list_dir as $v) {				
				if (!in_array($v, $file_name)) {				
					unlink($path.'/'.$v);	
					//echo "a";
				}			
			}
			foreach($list_sql as $v) {
				if (!in_array($v, $file_name)) {				
					$del = "delete from plc2.".$table." where ibk_id = {$lastId} and filename= '{$v}'";
					mysql_query($del);	
				}
				
			}
		} else {
			$this->readDirektory($path, 1);
			$this->readSQL($table, $lastId, 1);
		}
	} 
	
	function readSQL($table, $lastId, $empty="") {
		$list_file = array();
		if (empty($empty)) {
			$sql = "SELECT filename from plc2.".$table." where ibk_id=".$lastId;
			$query = mysql_query($sql);
			//echo $sql;
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['filename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT filename from plc2.".$table." where ibk_id=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM plc2.".$table." where ibk_id=".$lastId." and filename='".$row['filename']."'";			
			}
			
			foreach($sql2 as $q) {
				try {
					mysql_query($q);
				}catch(Exception $e) {
					die($e);
				}
			}
			
		  $x = "";
		}
		
		return $x;
	} 
}