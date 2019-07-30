<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class import_uji_labs extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
        $this->load->library('biz_process');
        $this->load->library('lib_utilitas');
		$this->user = $this->auth->user(); 
		$this->dbset = $this->load->database('plc', true);
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Uji Lab');
		//dc.m_vendor  database.tabel
		$grid->setTable('plc2.uji_lab_upi');		
		$grid->setUrl('import_uji_labs');
		$grid->addList('daftar_upi.vNo_upi','daftar_upi.vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori','iSubmit_ujiLabs','iApprove_bdirm');
		$grid->setSortBy('iujilab_id');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('iApprove_bdirm','iupi_id','vNama_usulan','cPengusul_upi','vKekuatan','vDosis','vNama_generik','vIndikasi','ikategori_id');
		$grid->addFields('histori');
		$grid->addFields('ilab_penguji_id','vAlamat','vTelp','vContact_Person');
		$grid->addFields('vFilesuratpenawaran','vFileparameterperiksa','vFilefilebuktibayar');
		$grid->addFields('dTanggal_kirim_sample','dTanggal_permohonan_pemeriksaaan','dTanggal_hasil_pemeriksaan');
		$grid->addFields('vFilehasilperiksa');

		//setting widht grid

		$grid->setLabel('vFilesuratpenawaran','Surat Penawaran Lab'); 
		$grid ->setWidth('vFilesuratpenawaran', '100'); 
		$grid->setAlign('vFilesuratpenawaran', 'center'); 
		
		$grid->setLabel('vFileparameterperiksa','Parameter Pemeriksaan'); 
		$grid ->setWidth('vFileparameterperiksa', '100'); 
		$grid->setAlign('vFileparameterperiksa', 'center'); 
		
		$grid->setLabel('vFilefilebuktibayar','Bukti Pembayaran Lab'); 
		$grid ->setWidth('vFilefilebuktibayar', '100'); 
		$grid->setAlign('vFilefilebuktibayar', 'center'); 

		$grid->setLabel('vFilehasilperiksa','Hasil Pemeriksaan'); 
		$grid ->setWidth('vFilehasilperiksa', '100'); 
		$grid->setAlign('vFilehasilperiksa', 'center'); 

		$grid->setLabel('histori','History Uji Lab'); 
		$grid ->setWidth('histori', '100'); 
		$grid->setAlign('histori', 'center'); 

		$grid->setLabel('dTanggal_kirim_sample','Tanggal Kirim Sample'); 
		$grid ->setWidth('dTanggal_kirim_sample', '100'); 
		$grid->setAlign('dTanggal_kirim_sample', 'center');

		$grid->setLabel('dTanggal_permohonan_pemeriksaaan','Tgl Permohonan Pemeriksaaan'); 
		$grid ->setWidth('dTanggal_permohonan_pemeriksaaan', '100'); 
		$grid->setAlign('dTanggal_permohonan_pemeriksaaan', 'center');

		$grid->setLabel('dTanggal_hasil_pemeriksaan','Tgl Hasil Pemeriksaan'); 
		$grid ->setWidth('dTanggal_hasil_pemeriksaan', '100'); 
		$grid->setAlign('dTanggal_hasil_pemeriksaan', 'center');

		$grid->setLabel('iSubmit_ujiLabs','Status'); 
		$grid ->setWidth('iSubmit_ujiLabs', '100'); 
		$grid->setAlign('iSubmit_ujiLabs', 'center'); 

		$grid->setLabel('iApprove_bdirm','Approval BDIRM'); 
		$grid ->setWidth('iApprove_bdirm', '100'); 
		$grid->setAlign('iApprove_bdirm', 'center'); 

		$grid->setLabel('daftar_upi.vNo_upi','No UPI'); 
		$grid->setWidth('daftar_upi.vNo_upi','80'); 
		$grid->setAlign('daftar_upi.vNo_upi','center'); 
 
		$grid->setLabel('iupi_id','No UPI'); 
		$grid ->setWidth('iupi_id', '100'); 
		$grid->setAlign('iupi_id', 'center'); 

		$grid->setLabel('dTgl_upi','Tanggal UPI'); 
		$grid ->setWidth('dTgl_upi', '100'); 
		$grid->setAlign('dTgl_upi', 'center'); 
 
		$grid->setLabel('daftar_upi.vNama_usulan','Nama Usulan'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 
		$grid ->setWidth('vNama_usulan', '250'); 
		$grid->setAlign('vNama_usulan', 'left');

		$grid->setLabel('cPengusul_upi','Nama Pengusul'); 
		$grid ->setWidth('cPengusul_upi', '250'); 
		$grid->setAlign('cPengusul_upi', 'center');

		$grid->setLabel('daftar_upi.vKekuatan','Kekuatan'); 
		$grid->setLabel('vNama_usulan','Kekuaatan'); 
		$grid ->setWidth('vNama_usulan', '250'); 
		$grid->setAlign('vNama_usulan', 'left');

		$grid->setLabel('daftar_upi.vDosis','Dosis'); 
		$grid->setLabel('vNama_usulan','Dosis'); 
		$grid ->setWidth('vNama_usulan', '250'); 
		$grid->setAlign('vNama_usulan', 'left');

		$grid->setLabel('daftar_upi.vNama_usulan','Nama Usulan'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 
		$grid ->setWidth('vNama_usulan', '250'); 
		$grid->setAlign('vNama_usulan', 'left');

		$grid->setLabel('vKekuatan','Kekuatan'); 
		$grid ->setWidth('vKekuatan', '10'); 
		$grid->setAlign('vKekuatan', 'center');

		$grid->setLabel('vDosis','Dosis'); 
		$grid ->setWidth('vDosis', '10'); 
		$grid->setAlign('vDosis', 'center');

		$grid->setLabel('vNama_generik','Nama Generik'); 
		$grid ->setWidth('vNama_generik', '10'); 
		$grid->setAlign('vNama_generik', 'center');

		$grid->setLabel('vIndikasi','Indikasi'); 
		$grid ->setWidth('vIndikasi', '10'); 
		$grid->setAlign('vIndikasi', 'center');
		
		$grid->setLabel('mnf_kategori.vkategori','Kategori Produk'); 
		$grid->setLabel('ikategori_id','Kategori Produk'); 
		$grid ->setWidth('ikategori_id', '150'); 
		$grid->setAlign('ikategori_id', 'center');

		$grid->setLabel('plc2_upb_master_kategori_upb.vkategori','Kategori UPI'); 
		$grid->setWidth('plc2_upb_master_kategori_upb.vkategori','50'); 
		$grid->setAlign('plc2_upb_master_kategori_upb.vkategori','center'); 
 
		$grid->setLabel('ikategoriupi_id','Kategori UPI'); 
		$grid ->setWidth('ikategoriupi_id', '150'); 
		$grid->setAlign('ikategoriupi_id', 'center');

		$grid->setLabel('iSubmit_ujiLabs','Status Submit'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 
		$grid ->setWidth('vNama_usulan', '300'); 

		$grid->setLabel('lab_penguji.vNama_lab_penguji','Nama Lab Penguji'); 
		$grid->setWidth('lab_penguji.vNama_lab_penguji','80'); 
		$grid->setAlign('lab_penguji.vNama_lab_penguji','center'); 
 
		$grid->setLabel('ilab_penguji_id','Nama Lab Penguji'); 
		$grid ->setWidth('ilab_penguji_id', '100'); 
		$grid->setAlign('ilab_penguji_id', 'center'); 

		$grid->setLabel('lab_penguji.vAlamat','Alamat Lab'); 
		$grid->setLabel('vAlamat','Alamat Lab'); 
		$grid->setWidth('vAlamat','80'); 
		$grid->setAlign('vAlamat','center'); 

		$grid->setLabel('lab_penguji.vTelp','Telepon'); 
		$grid->setLabel('vTelp','Telepon'); 
		$grid->setWidth('vTelp','80'); 
		$grid->setAlign('vTelp','center'); 

		$grid->setLabel('lab_penguji.vContact_Person','Contact Name'); 
		$grid->setLabel('vContact_Person','Contact Name'); 
		$grid->setWidth('vContact_Person','80'); 
		$grid->setAlign('vContact_Person','center'); 

		$grid->setSearch('daftar_upi.vNo_upi','daftar_upi.vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori');
		
		
		$grid->setLabel('dupdate','Tgl Update'); 
		$grid->setLabel('cUpdate','Update By'); 
		
		$grid->setFormUpload(TRUE);
		
		// Mandatory
		$grid->setRequired('iupi_id');	
		
		$grid->setRequired('ilab_penguji_id');
		//$grid->setGroupBy('iupi_id');

		$grid->setRequired('vFilesuratpenawaran');	
		$grid->setRequired('fileparameterperiksa');	
		$grid->setRequired('filebuktibayar');
		$grid->setRequired('dTanggal_kirim_sample');	
		$grid->setRequired('dTanggal_permohonan_pemeriksaaan');
		$grid->setRequired('dTanggal_hasil_pemeriksaan');	
		$grid->setRequired('vFilehasilperiksa');


		$grid->setQuery('daftar_upi.iStatusKill = "0" ', null);

		//$grid->setJoinTable('plc2.analisa_prinsipal', 'analisa_prinsipal.ianalisa_prinsipal_id = uji_lab_upi.ianalisa_prinsipal_id', 'inner');
		//$grid->setJoinTable('(SELECT `iupi_id`,MAX(`dCreate`) AS a FROM plc2.`uji_lab_upi` GROUP BY `iupi_id`) b', 'a.`iupi_id` = b.`iupi_id` AND a.`dCreate` = b.a', 'inner');
		$grid->setJoinTable('plc2.daftar_upi', 'daftar_upi.iupi_id = uji_lab_upi.iupi_id', 'inner');
		$grid->setJoinTable('plc2.lab_penguji', 'lab_penguji.ilab_penguji_id = uji_lab_upi.ilab_penguji_id', 'inner');
		$grid->setJoinTable('hrd.mnf_kategori', 'mnf_kategori.ikategori_id = daftar_upi.ikategori_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_master_kategori_upb', 'plc2_upb_master_kategori_upb.ikategori_id = daftar_upi.ikategoriupi_id', 'inner');

		$grid->setJoinTable('(SELECT `iupi_id`,MAX(`dCreate`) AS a FROM plc2.uji_lab_upi  GROUP BY `iupi_id`) b', 'b.iupi_id = daftar_upi.iupi_id AND uji_lab_upi.`dCreate` = b.a', 'inner');
			
		$grid->changeFieldType('iSubmit_ujiLabs','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submitted'));
		//$grid->changeFieldType('iBentuk_td','combobox','',array(''=>'Select One',1=>'Ya', 0=>'Tidak'));
		
		//Set View Gridnya (Default = grid)
		$grid->setGridView('grid');
		switch ($action) {
                case 'json':
                        $grid->getJsonData();
                        break;
                case 'view':
                        $grid->render_form($this->input->get('id'), true);
                        break;
                case 'create':
                        $grid->render_form();
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
                case 'createproses':
                		//print_r($_POST);
                       	$isUpload = $this->input->get('isUpload');
                       	
   						if($isUpload) {

		   					$lastId=$this->input->get('lastId');
							
							$path = realpath("files/plc/hasil_uji_labs");
							if(!file_exists($path."/".$lastId)){
								if (!mkdir($path."/".$lastId, 0777, true)) { 
									die('Failed upload, try again!');
								}
							}

							$file_keterangan4 = array();
							foreach($_POST as $key=>$value) {						
								if ($key == 'fileketerangan4') {
									foreach($value as $k=>$v) {
										$file_keterangan4[$k] = $v;
									}
								}
							}

						
							$i=0;
							foreach ($_FILES['fileupload4_studypd4']["error"] as $key => $error) {
								if ($error == UPLOAD_ERR_OK) {
									$tmp_name = $_FILES['fileupload4_studypd4']["tmp_name"][$key];
									$name =$_FILES['fileupload4_studypd4']["name"][$key];
									$data['filename'] = $name;
									$data['dInsertDate'] = date('Y-m-d H:i:s');

										if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
											$sql[]="INSERT INTO plc2.file_hasil_periksa (iujilab_id, vFilehasilperiksa, dCreate, cCreated, vKeterangan) 
													VALUES (".$lastId.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."','".$file_keterangan4[$i]."')";
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
									echo "TestingSimpan";
								}catch(Exception $e) {
								die($e);
								}
							}

							$path1 = realpath("files/plc/surat_penawaran");
							if(!file_exists($path1."/".$lastId)){
								if (!mkdir($path1."/".$lastId, 0777, true)) { //id review
									die('Failed upload, try again!');
								}
							}

							$file_keterangan1 = array();
							foreach($_POST as $key=>$value) {						
								if ($key == 'fileketerangan1') {
									foreach($value as $k=>$v) {
										$file_keterangan1[$k] = $v;
									}
								}
							}
						
							$i=0;
							foreach ($_FILES['fileupload1_studypd1']["error"] as $key => $error) {
								if ($error == UPLOAD_ERR_OK) {
									$tmp_name1 = $_FILES['fileupload1_studypd1']["tmp_name"][$key];
									$name1 =$_FILES['fileupload1_studypd1']["name"][$key];
									$data['filename'] = $name1;
									$data['dInsertDate'] = date('Y-m-d H:i:s');

										if(move_uploaded_file($tmp_name1, $path1."/".$lastId."/".$name1)) {
											$sql1[]="INSERT INTO plc2.file_surat_penawaran (iujilab_id, vFilesuratpenawaran, dCreate, cCreated, vKeterangan) 
													VALUES (".$lastId.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."','".$file_keterangan1[$i]."')";
											$i++;	
										}
										else{
											echo "Upload ke folder gagal";	
										}
								}
							}
							foreach($sql1 as $q1) {
								try {
									$this->dbset->query($q1);
									echo "TestingSimpan";
								}catch(Exception $e) {
								die($e);
								}
							}

							$path2 = realpath("files/plc/parameter_pemeriksaan");
							if(!file_exists($path2."/".$lastId)){
								if (!mkdir($path2."/".$lastId, 0777, true)) { //id review
									die('Failed upload, try again!');
								}
							}
							
							$file_keterangan2 = array();
							foreach($_POST as $key=>$value) {						
								if ($key == 'fileketerangan2') {
									foreach($value as $k=>$v) {
										$file_keterangan2[$k] = $v;
									}
								}
							}

							$i=0;
							foreach ($_FILES['fileupload2_studypd2']["error"] as $key => $error) {
								if ($error == UPLOAD_ERR_OK) {
									$tmp_name2 = $_FILES['fileupload2_studypd2']["tmp_name"][$key];
									$name2 =$_FILES['fileupload2_studypd2']["name"][$key];
									$data['filename'] = $name2;
									$data['dInsertDate'] = date('Y-m-d H:i:s');

										if(move_uploaded_file($tmp_name2, $path2."/".$lastId."/".$name2)) {
											$sql2[]="INSERT INTO plc2.file_parameter_periksa (iujilab_id, vFileparameterperiksa, dCreate, cCreated, vKeterangan) 
													VALUES (".$lastId.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."','".$file_keterangan2[$i]."')";
											$i++;	
										}
										else{
											echo "Upload ke folder gagal";	
										}
								}
							}
							foreach($sql2 as $q2) {
								try {
									$this->dbset->query($q2);
									echo "TestingSimpan";
								}catch(Exception $e) {
								die($e);
								}
							}

							$path3 = realpath("files/plc/bukti_pembayaran");
							if(!file_exists($path3."/".$lastId)){
								if (!mkdir($path3."/".$lastId, 0777, true)) { //id review
									die('Failed upload, try again!');
								}
							}
							
							$file_keterangan3 = array();
							foreach($_POST as $key=>$value) {						
								if ($key == 'fileketerangan3') {
									foreach($value as $k=>$v) {
										$file_keterangan3[$k] = $v;
									}
								}
							}

							$i=0;
							foreach ($_FILES['fileupload3_studypd3']["error"] as $key => $error) {
								if ($error == UPLOAD_ERR_OK) {
									$tmp_name3 = $_FILES['fileupload3_studypd3']["tmp_name"][$key];
									$name3 =$_FILES['fileupload3_studypd3']["name"][$key];
									$data['filename'] = $name3;
									$data['dInsertDate'] = date('Y-m-d H:i:s');

										if(move_uploaded_file($tmp_name3, $path3."/".$lastId."/".$name3)) {
											$sql3[]="INSERT INTO plc2.file_bukti_bayar (iujilab_id, vFilefilebuktibayar, dCreate, cCreated, vKeterangan) 
													VALUES (".$lastId.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."','".$file_keterangan3[$i]."')";
											$i++;	
										}
										else{
											echo "Upload ke folder gagal";	
										}
								}
							}
							foreach($sql3 as $q3) {
								try {
									$this->dbset->query($q3);
									echo "TestingSimpan";
								}catch(Exception $e) {
								die($e);
								}
							}

						$r['message']="Data Berhasil Disimpan";
						$r['status'] = TRUE;
						$r['last_id'] = $this->input->get('lastId');					
						echo json_encode($r);
	   				}

	   				else{
	   					echo $grid->saved_form();
					}
					break;
                case 'update':
                        $grid->render_form($this->input->get('id'));
                        break;
                case 'updateproses':
					$isUpload = $this->input->get('isUpload');
					$post=$this->input->post();
					
					$iujiLabs=$post['import_uji_labs_iujilab_id'];

	   				if($isUpload) {	
	   					$path = realpath("files/plc/hasil_uji_labs");
						if(!file_exists($path."/".$iujiLabs)){
							if (!mkdir($path."/".$iujiLabs, 0777, true)) { //id review
								die('Failed upload, try again!');
							}
						}

						$file_keterangan4 = array();
						foreach($_POST as $key=>$value) {						
							if ($key == 'fileketerangan4') {
								foreach($value as $k=>$v) {
									$file_keterangan4[$k] = $v;
								}
							}
						}

						if (isset($_FILES['fileupload4_studypd4']))  {
							$i=0;
							foreach ($_FILES['fileupload4_studypd4']["error"] as $key => $error) {	
								if ($error == UPLOAD_ERR_OK) {
									$tmp_name = $_FILES['fileupload4_studypd4']["tmp_name"][$key];
									$name =$_FILES['fileupload4_studypd4']["name"][$key];
									$data['filename'] = $name;
									$data['dInsertDate'] = date('Y-m-d H:i:s');
									if(move_uploaded_file($tmp_name, $path."/".$iujiLabs."/".$name)) {
										$sql[]="INSERT INTO plc2.file_hasil_periksa (iujilab_id, vFilehasilperiksa, dCreate, cCreated,vKeterangan) 
												VALUES (".$iujiLabs.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."','".$file_keterangan4[$i]."')";
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
									echo "TestingSimpan";
								}catch(Exception $e) {
								die($e);
								}
							}

						}

						$path1 = realpath("files/plc/surat_penawaran");
							if(!file_exists($path1."/".$iujiLabs)){
								if (!mkdir($path1."/".$iujiLabs, 0777, true)) { //id review
									die('Failed upload, try again!');
								}
							}

						$file_keterangan1 = array();
							foreach($_POST as $key=>$value) {						
								if ($key == 'fileketerangan1') {
									foreach($value as $k=>$v) {
										$file_keterangan1[$k] = $v;
									}
								}
							}

						if (isset($_FILES['fileupload1_studypd1']))  {
							$i=0;
							foreach ($_FILES['fileupload1_studypd1']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
									$tmp_name1 = $_FILES['fileupload1_studypd1']["tmp_name"][$key];
									$name1 =$_FILES['fileupload1_studypd1']["name"][$key];
									$data['filename'] = $name1;
									$data['dInsertDate'] = date('Y-m-d H:i:s');

										if(move_uploaded_file($tmp_name1, $path1."/".$iujiLabs."/".$name1)) {
											$sql1[]="INSERT INTO plc2.file_surat_penawaran (iujilab_id, vFilesuratpenawaran, dCreate, cCreated, vKeterangan) 
													VALUES (".$iujiLabs.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."','".$file_keterangan1[$i]."')";
											$i++;	
										}
										else{
											echo "Upload ke folder gagal";	
										}
								}
							}
							foreach($sql1 as $q1) {
								try {
									$this->dbset->query($q1);
									echo "TestingSimpan";
								}catch(Exception $e) {
								die($e);
								}
							}

						}

						$path2 = realpath("files/plc/parameter_pemeriksaan");
							if(!file_exists($path2."/".$iujiLabs)){
								if (!mkdir($path2."/".$iujiLabs, 0777, true)) { //id review
									die('Failed upload, try again!');
								}
							}

						$file_keterangan2 = array();
							foreach($_POST as $key=>$value) {						
								if ($key == 'fileketerangan2') {
									foreach($value as $k=>$v) {
										$file_keterangan2[$k] = $v;
									}
								}
							}

						if (isset($_FILES['fileupload2_studypd2']))  {
							$i=0;
							foreach ($_FILES['fileupload2_studypd2']["error"] as $key => $error) {
							if ($error == UPLOAD_ERR_OK) {
									$tmp_name2 = $_FILES['fileupload2_studypd2']["tmp_name"][$key];
									$name2 =$_FILES['fileupload2_studypd2']["name"][$key];
									$data['filename'] = $name2;
									$data['dInsertDate'] = date('Y-m-d H:i:s');

										if(move_uploaded_file($tmp_name2, $path2."/".$iujiLabs."/".$name2)) {
											$sql2[]="INSERT INTO plc2.file_parameter_periksa (iujilab_id, vFileparameterperiksa, dCreate, cCreated, vKeterangan) 
													VALUES (".$iujiLabs.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."','".$file_keterangan2[$i]."')";
											$i++;	
										}
										else{
											echo "Upload ke folder gagal";	
										}
								}
							}
							foreach($sql2 as $q2) {
								try {
									$this->dbset->query($q2);
									echo "TestingSimpan";
								}catch(Exception $e) {
								die($e);
								}
							}

						}

						$path3 = realpath("files/plc/bukti_pembayaran");
							if(!file_exists($path3."/".$iujiLabs)){
								if (!mkdir($path3."/".$iujiLabs, 0777, true)) { //id review
									die('Failed upload, try again!');
								}
							}

						$file_keterangan3 = array();
							foreach($_POST as $key=>$value) {						
								if ($key == 'fileketerangan3') {
									foreach($value as $k=>$v) {
										$file_keterangan3[$k] = $v;
									}
								}
							}

						if (isset($_FILES['fileupload3_studypd3']))  {
							$i=0;
							foreach ($_FILES['fileupload3_studypd3']["error"] as $key => $error) {
							if ($error == UPLOAD_ERR_OK) {
									$tmp_name3 = $_FILES['fileupload3_studypd3']["tmp_name"][$key];
									$name3 =$_FILES['fileupload3_studypd3']["name"][$key];
									$data['filename'] = $name3;
									$data['dInsertDate'] = date('Y-m-d H:i:s');

										if(move_uploaded_file($tmp_name3, $path3."/".$iujiLabs."/".$name3)) {
											$sql3[]="INSERT INTO plc2.file_bukti_bayar (iujilab_id, vFilefilebuktibayar, dCreate, cCreated, vKeterangan) 
													VALUES (".$iujiLabs.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."','".$file_keterangan3[$i]."')";
											$i++;	
										}
										else{
											echo "Upload ke folder gagal";	
										}
								}
							}
							foreach($sql3 as $q3) {
								try {
									$this->dbset->query($q3);
									echo "TestingSimpan";
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
					}  

					else {
						$fileid1='';
						foreach($_POST as $key=>$value) {
							if ($key == 'fileid1_studypd1') {
								$i=0;
								foreach($value as $k=>$v) {
									if($i==0){
										$fileid1 .= "'".$v."'";
									}else{
										$fileid1 .= ",'".$v."'";
									}
									$i++;
								}
							}
						}
						$tgl= date('Y-m-d H:i:s');
						$sql1="update plc2.file_surat_penawaran set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where iujilab_id='".$iujiLabs."' and ifilesuratpenawaran_id not in (".$fileid1.")";
						$this->dbset->query($sql1);

						$fileid2='';
						foreach($_POST as $key=>$value) {
							if ($key == 'fileid2_studypd2') {
								$i=0;
								foreach($value as $k=>$v) {
									if($i==0){
										$fileid2 .= "'".$v."'";
									}else{
										$fileid2 .= ",'".$v."'";
									}
									$i++;
								}
							}
						}
						$tgl= date('Y-m-d H:i:s');
						$sql2="update plc2.file_parameter_periksa set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where iujilab_id='".$iujiLabs."' and ifileparameterperiksa_id not in (".$fileid2.")";
						$this->dbset->query($sql2);

						$fileid3='';
						foreach($_POST as $key=>$value) {
							if ($key == 'fileid3_studypd3') {
								$i=0;
								foreach($value as $k=>$v) {
									if($i==0){
										$fileid3 .= "'".$v."'";
									}else{
										$fileid3 .= ",'".$v."'";
									}
									$i++;
								}
							}
						}
						$tgl= date('Y-m-d H:i:s');
						$sql3="update plc2.file_bukti_bayar set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where iujilab_id='".$iujiLabs."' and ifilebuktibayar_id not in (".$fileid3.")";
						$this->dbset->query($sql3);

						$fileid4='';
						foreach($_POST as $key=>$value) {
							if ($key == 'fileid4_studypd4') {
								$i=0;
								foreach($value as $k=>$v) {
									if($i==0){
										$fileid4 .= "'".$v."'";
									}else{
										$fileid4 .= ",'".$v."'";
									}
									$i++;
								}
							}
						}
						$tgl= date('Y-m-d H:i:s');
						$sql3="update plc2.file_hasil_periksa set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where iujilab_id='".$iujiLabs."' and ifilehasilperiksa_id not in (".$fileid4.")";
						$this->dbset->query($sql3);


						echo $grid->updated_form();
					}
					break;
                /*case 'updateproses':
                	$post=$this->input->post();
                	$isUpload = $this->input->get('isUpload');
                	$isUpload = $this->input->get('isUpload');
                   	$isUpload1 = $this->input->get('isUpload1');
                   	$isUpload2 = $this->input->get('isUpload2');
                   	$isUpload3 = $this->input->get('isUpload3');

					$istudy=$post['iujilab_id'];


					if($isUpload || $isUpload1 || $isUpload2 || $isUpload3) {
		   					
		   					$lastId=$this->input->get('lastId');
							
							$path = realpath("files/plc/hasil_uji_labs");
							if(!file_exists($path."/".$lastId)){
								if (!mkdir($path."/".$lastId, 0777, true)) { //id review
									die('Failed upload, try again!');
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
											$sql[]="INSERT INTO plc2.file_hasil_periksa (iujilab_id, vFilehasilperiksa, dCreate, cCreated) 
													VALUES (".$lastId.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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
									echo "TestingSimpan";
								}catch(Exception $e) {
								die($e);
								}
							}

							$path1 = realpath("files/plc/surat_penawaran");
							if(!file_exists($path1."/".$lastId)){
								if (!mkdir($path1."/".$lastId, 0777, true)) { //id review
									die('Failed upload, try again!');
								}
							}
						
							$i=0;
							foreach ($_FILES['fileupload_studypd1']["error"] as $key => $error) {
								if ($error == UPLOAD_ERR_OK) {
									$tmp_name1 = $_FILES['fileupload_studypd1']["tmp_name"][$key];
									$name1 =$_FILES['fileupload_studypd1']["name"][$key];
									$data['filename'] = $name1;
									$data['dInsertDate'] = date('Y-m-d H:i:s');

										if(move_uploaded_file($tmp_name1, $path1."/".$lastId."/".$name1)) {
											$sql1[]="INSERT INTO plc2.file_surat_penawaran (iujilab_id, vFilesuratpenawaran, dCreate, cCreated) 
													VALUES (".$lastId.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."')";
											$i++;	
										}
										else{
											echo "Upload ke folder gagal";	
										}
								}
							}
							foreach($sql1 as $q1) {
								try {
									$this->dbset->query($q1);
									echo "TestingSimpan";
								}catch(Exception $e) {
								die($e);
								}
							}

							$path2 = realpath("files/plc/parameter_pemeriksaan");
							if(!file_exists($path2."/".$lastId)){
								if (!mkdir($path2."/".$lastId, 0777, true)) { //id review
									die('Failed upload, try again!');
								}
							}
						
							$i=0;
							foreach ($_FILES['fileupload_studypd2']["error"] as $key => $error) {
								if ($error == UPLOAD_ERR_OK) {
									$tmp_name2 = $_FILES['fileupload_studypd2']["tmp_name"][$key];
									$name2 =$_FILES['fileupload_studypd2']["name"][$key];
									$data['filename'] = $name2;
									$data['dInsertDate'] = date('Y-m-d H:i:s');

										if(move_uploaded_file($tmp_name2, $path2."/".$lastId."/".$name2)) {
											$sql2[]="INSERT INTO plc2.file_parameter_periksa (iujilab_id, vFileparameterperiksa, dCreate, cCreated) 
													VALUES (".$lastId.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."')";
											$i++;	
										}
										else{
											echo "Upload ke folder gagal";	
										}
								}
							}
							foreach($sql2 as $q2) {
								try {
									$this->dbset->query($q2);
									echo "TestingSimpan";
								}catch(Exception $e) {
								die($e);
								}
							}

							$path3 = realpath("files/plc/bukti_pembayaran");
							if(!file_exists($path3."/".$lastId)){
								if (!mkdir($path3."/".$lastId, 0777, true)) { //id review
									die('Failed upload, try again!');
								}
							}
						
							$i=0;
							foreach ($_FILES['fileupload_studypd3']["error"] as $key => $error) {
								if ($error == UPLOAD_ERR_OK) {
									$tmp_name3 = $_FILES['fileupload_studypd3']["tmp_name"][$key];
									$name3 =$_FILES['fileupload_studypd3']["name"][$key];
									$data['filename'] = $name3;
									$data['dInsertDate'] = date('Y-m-d H:i:s');

										if(move_uploaded_file($tmp_name3, $path3."/".$lastId."/".$name3)) {
											$sql3[]="INSERT INTO plc2.file_bukti_bayar (iujilab_id, vFilefilebuktibayar, dCreate, cCreated) 
													VALUES (".$lastId.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."')";
											$i++;	
										}
										else{
											echo "Upload ke folder gagal";	
										}
								}
							}
							foreach($sql3 as $q3) {
								try {
									$this->dbset->query($q3);
									echo "TestingSimpan";
								}catch(Exception $e) {
								die($e);
								}
							}

						$r['message']="Data Berhasil Disimpan";
						$r['status'] = TRUE;
						$r['last_id'] = $this->input->get('lastId');					
						echo json_encode($r);

	   				} else {



						$fileid1='';
						foreach($_POST as $key=>$value) {
							if ($key == 'ifilehasilperiksa_id') {
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
						$sql1="update plc2.file_hasil_periksa set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where iujilab_id='".$istudy."' and ifilehasilperiksa_id not in (".$fileid.")";
						$this->dbset->query($sql1);



						$fileid='';
						foreach($_POST as $key=>$value) {
							if ($key == 'ifilesuratpenawaran_id') {
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
						$sql1="update plc2.file_surat_penawaran set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where iujilab_id='".$istudy."' and ifilesuratpenawaran_id not in (".$fileid.")";
						$this->dbset->query($sql1);

						$fileid='';
						foreach($_POST as $key=>$value) {
							if ($key == 'ifileparameterperiksa_id') {
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
						$sql1="update plc2.file_parameter_periksa set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where iujilab_id='".$istudy."' and ifileparameterperiksa_id not in (".$fileid.")";
						$this->dbset->query($sql1);

						$fileid='';
						foreach($_POST as $key=>$value) {
							if ($key == 'ifilebuktibayar_id') {
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
						$sql1="update plc2.file_bukti_bayar set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where iujilab_id='".$istudy."' and ifilebuktibayar_id not in (".$fileid.")";
						$this->dbset->query($sql1);


						echo $grid->updated_form();
					}
                       
                        break;*/
                case 'getdetil':
					$this->getdetil();
					break;	

				case 'getdetillab':
					//print_r(getdetillab());
					$this->getdetillab();
					break;
				case 'downloadbkt':
					$this->downloadbkt($this->input->get('filebkt'));
					break;
				case 'downloadhsl':
					$this->downloadhsl($this->input->get('filehsl'));
					break;
				case 'downloadprm':
					$this->downloadprm($this->input->get('fileprm'));
					break;
				case 'downloadad':
					$this->downloadad($this->input->get('filead'));
					break;

                case 'delete':
                        echo $grid->delete_row();
                        break;
                case 'employee_list':
						$this->employee_list();
                default:
                        $grid->render_grid();
                        break;
        }
    }   

    /*function listBox_Action($row, $actions) {

	 	$mydept = $this->auth->my_depts(TRUE);
	 	$x = $this->auth->my_teams();
		$array = explode(',', $x);
		// cek user bagian dari tim bd terkait
		

	 	if ($row->iSubmit_prinsipal<>0) {
	 		// status sudah diapprove or reject , button edit hide 
	 		 	if ($row->iApprove_bdirm<>0) {
	 		 		unset($actions['edit']);
		 		 	unset($actions['delete']);
	 		 	}else{

		 		 	if((in_array('BDI', $mydept))) {
						if($this->auth->is_manager()){
							//$buttons['update'] = $approve_bdirm.$reject_bdirm.$js;	
						}else{
							unset($actions['edit']);
		 		 			unset($actions['delete']);
						}
					}
	 		 	}


	 	}else{
	 		
	 	}
	 	
		 return $actions;
	}*/
    
    /*public function after_insert_processor($fields, $id, $post) {
        $cNip = $this->sess_auth->gNIP;
        
        $sql = "Update _dbname_._tblname_ set tCreated = CURRENT_TIMESTAMP, cCreatedBy='".$cNip."', 
                dUpdated = CURRENT_TIMESTAMP, cUpdatedBy='".$cNip."' where id='".$id."'";
        $this->dbset->query($sql);
    }
    
    public function after_update_processor($fields, $id, $post) {
        $cNip = $this->sess_auth->gNIP;
        
        $sql = "Update _dbname_._tblname_ set tUpdated = CURRENT_TIMESTAMP, cUpdatedBy='".$cNip."' 
            where id='".$id."'";
        $this->dbset->query($sql);
    }*/
    function listBox_Action($row, $actions) {

	 	$mydept = $this->auth->my_depts(TRUE);
	 	$x = $this->auth->my_teams();
		$array = explode(',', $x);
		// cek user bagian dari tim bd terkait
		

	 	if ($row->iSubmit_ujiLabs<>0) {
	 		// status sudah diapprove or reject , button edit hide 
	 		 	if ($row->iApprove_bdirm<>0) {
	 		 		unset($actions['edit']);
		 		 	unset($actions['delete']);
	 		 	}else{

		 		 	if((in_array('BDI', $mydept))) {
						if($this->auth->is_manager()){
							//$buttons['update'] = $approve_bdirm.$reject_bdirm.$js;	
						}else{
							unset($actions['edit']);
		 		 			unset($actions['delete']);
						}
					}
	 		 	}
	 	}
	 	
		 return $actions;
	}


    function getdetil(){
	
		$iupi_id=$_POST['iupi_id'];

		$data = array();
		
		$sql2 = "select *
			from plc2.daftar_upi a 
			join hrd.employee b on b.cNip=a.cPengusul_upi
			where a.ldeleted = 0 and a.iupi_id='".$iupi_id."'";
		$data2 = $this->dbset->query($sql2)->row_array();
	 	
	 	$row_array['vNo_upi'] = trim($data2['vNo_upi']);
		$row_array['dTgl_upi'] = trim($data2['dTgl_upi']);


		$row_array['cPengusul_upi'] = trim($data2['vName']);
		$row_array['vNama_usulan'] = trim($data2['vNama_usulan']);
		$row_array['vKekuatan'] = trim($data2['vKekuatan']);

		$row_array['vDosis'] = trim($data2['vDosis']);
		$row_array['vNama_generik'] = trim($data2['vNama_generik']);
		$row_array['vIndikasi'] = trim($data2['vIndikasi']);

		$row_array['ikategori_id'] = trim($data2['ikategori_id']);
		$row_array['ikategoriupi_id'] = trim($data2['ikategoriupi_id']);
		
	 	array_push($data, $row_array);
	 	echo json_encode($data);
	    exit;
	}
	function getdetillab(){

		$ilab_penguji_id=$_POST['ilab_penguji_id'];

		$data = array();

		$sql3 = "SELECT * FROM plc2.`lab_penguji` a WHERE a.`lDeleted` = 0 AND a.`ilab_penguji_id` ='".$ilab_penguji_id."'";
			
			$data3 = $this->dbset->query($sql3)->row_array();
			$row_array['ilab_penguji_id'] = trim($data3['ilab_penguji_id']);
			$row_array['vNama_lab_penguji'] = trim($data3['vNama_lab_penguji']);
			$row_array['vAlamat'] = trim($data3['vAlamat']);
			$row_array['vTelp'] = trim($data3['vTelp']);
			$row_array['vContact_Person'] = trim($data3['vContact_Person']);

		array_push($data, $row_array);
	 	echo json_encode($data);
	    exit;
	}


	function searchBox_import_uji_labs_mnf_kategori_vkategori($rowData, $id) {
		$teams = $this->db_plc0->get_where('hrd.mnf_kategori', array('ldeleted' => 0))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		if($t['ikategori_id'] == '1' || $t['ikategori_id'] =='3' || $t['ikategori_id'] =='5'){

    		}else{
    			$o .= '<option value="'.$t['vkategori'].'">'.$t['vkategori'].'</option>';
    		}
    	}
    	$o .= '</select>';
    	return $o;
    } 

    function searchBox_import_uji_labs_plc2_upb_master_kategori_upb_vkategori($rowData, $id) {
		$teams = $this->db_plc0->get_where('plc2.plc2_upb_master_kategori_upb', array('ldeleted' => 0))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['vkategori'].'">'.$t['vkategori'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }   

	function listBox_import_uji_labs_iApprove_bdirm($value) {
		if($value==0){$vstatus='Waiting for approval';}
		elseif($value==1){$vstatus='Rejected';}
		elseif($value==2){$vstatus='Approved';}
		return $vstatus;
	}
	
	function insertBox_import_uji_labs_iApprove_bdirm($field, $id) {
		return '-';
	}
	function updateBox_import_uji_labs_iApprove_bdirm($field, $id, $value, $rowData) {
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = "SELECT * FROM plc2.uji_lab_upi a JOIN hrd.employee b ON b.cNip=a.cApprove_bdirm WHERE a.lDeleted = 0 AND a.`iujilab_id` = '".$rowData['iujilab_id']."'";
			$row = $this->db_plc0->query($sql_dtapp)->row_array();
			
			if($value==2){
				$st='<p style="color:green;font-size:120%;">Approved';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_bdirm'].'</br> Alasan: '.$row['vRemark_bdirm'].'</p>';
			}
			elseif($value==1){
				$st='<p style="color:red;font-size:120%;">Rejected';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_bdirm'].'</br> Alasan: '.$row['vRemark_bdirm'].'</p>';
			} 
		}
		else{
			$ret='Waiting for Approval';
		}
		$ret .= "<input type='hidden' name='".$field."' id='".$id."'  value='".$value."'/>";
		return $ret;
	}
	function insertBox_import_uji_labs_cPengusul_upi($field, $id) {
		$return = '<input disabled="true" type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="35" />';
		return $return;
	}
	function insertBox_import_uji_labs_iupi_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />
					';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="10" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/import/browse/upi/ujilab/?field=import_uji_labs\',\'List UPI\')" type="button">&nbsp;</button>';                
		
		return $return;
	}

	function updateBox_import_uji_labs_iupi_id($field, $id, $value, $rowData) {
		$sql = 'select a.iupi_id,a.vNo_upi,a.vNama_usulan from plc2.daftar_upi a where a.iupi_id ="'.$value.'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vNo_upi'];

		}else{
			
			if ($rowData['iSubmit_ujiLabs'] == 0) {
				$return = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />
						';
			$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="10" value="'.$data_upb['vNo_upi'].'"/>';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/import/browse/upi/ujilab/?field=import_uji_labs\',\'List UPI\')" type="button">&nbsp;</button>';                
			
			
			}else{
				$return= $data_upb['vNo_upi'];
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			}
			
			//$return= $data_upb['vNo_upi'];
		}
		
		return $return;
	}

	function updateBox_import_uji_labs_cPengusul_upi($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
    	$rowss = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rows['cPengusul_upi']))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rowss['vName'];

		}
		else{
				$return = '<input disabled="true" type="text" name="'.$field.'" size="35" readonly="readonly" id="'.$id.'" value="'.$rowss['vName'].'" class="input_rows1 required" size="10" />';

		}
		
		return $return;
	}
	function insertBox_import_uji_labs_vNama_usulan($field, $id) {
		$return = '<input type="text" name="'.$field.'"  disabled="true" id="'.$id.'" class="input_rows1 required" size="35" />
					<input type="hidden" name="isdraft" id="isdraft">';
		return $return;
	}

	function updateBox_import_uji_labs_vNama_usulan($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vNama_usulan'];

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="35" disabled="true" id="'.$id.'" value="'.$rows['vNama_usulan'].'" class="input_rows1 required" size="10" />
				<input type="hidden" name="isdraft" id="isdraft">';

		}
		
		return $return;
	}

	function insertBox_import_uji_labs_vKekuatan($field, $id) {
		$return = '<input type="text" name="'.$field.'" style="text-align:right;" disabled="true" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_uji_labs_vKekuatan($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vKekuatan'];

		}
		else{
				$return = '<input type="text" style="text-align:right;" name="'.$field.'" size="8" disabled="true" id="'.$id.'" value="'.$rows['vKekuatan'].'" class="input_rows1 required"/>';

		}
		
		return $return;
	}

	function insertBox_import_uji_labs_vDosis($field, $id) {
		$return = '<input type="text" style="text-align:right;" name="'.$field.'"  disabled="true" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_uji_labs_vDosis($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vDosis'];

		}
		else{
				$return = '<input style="text-align:right;" type="text" name="'.$field.'" size="8" disabled="true" id="'.$id.'" value="'.$rows['vDosis'].'" class="input_rows1 required"  />';

		}
		
		return $return;
	}
	function insertBox_import_uji_labs_vNama_generik($field, $id) {
		$return = '<input type="text" name="'.$field.'"  disabled="true" id="'.$id.'" class="input_rows1 required" size="35" />';
		return $return;
	}

	function updateBox_import_uji_labs_vNama_generik($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vNama_generik'];

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="35" disabled="true" id="'.$id.'" value="'.$rows['vNama_generik'].'" class="input_rows1 required" size="10" />';

		}
		
		return $return;
	}

	function insertBox_import_uji_labs_vIndikasi($field, $id) {
		$o 	= "<textarea name='".$id."' id='".$id."' class='required' disabled style='width: 260px; height: 50px;'size='250'></textarea>";		
		$o .= "	<script>
				$('#".$id."').keyup(function() {
				var len = this.value.length;
				if (len >= 250) {
				this.value = this.value.substring(0, 250);
				}
				$('#maxlengthnote').text(250 - len);
				});
			</script>";
	    $o .= '<br/>tersisa <span id="maxlengthnote">250</span> karakter<br/>';
    
                                            
		return $o;
	}

	function updateBox_import_uji_labs_vIndikasi($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Note'>".nl2br($rows['vIndikasi'])."</label>";
		
		}else{
			$o 	= "<textarea name='".$id."' id='".$id."' class='required' disabled   style='width: 240px; height: 50px;'size='250'>".nl2br($rows['vIndikasi'])."</textarea>";		
			$o .= "	<script>
				$('#".$id."').keyup(function() {
				var len = this.value.length;
				if (len >= 250) {
				this.value = this.value.substring(0, 250);
				}
				$('#maxlengthnote').text(250 - len);
				});
			</script>";
	    	$o .= '<br/>tersisa <span id="maxlengthnote">250</span> karakter<br/>';
	    
		}

		return $o;
	}

	function insertBox_import_uji_labs_ikategori_id($field, $id) {
        
            $o  = "<select name='".$field."' id='".$id."' class='required' disabled='true'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.ikategori_id,a.vkategori from hrd.mnf_kategori a where a.ldeleted=0";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($id == $row['ikategori_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected}  value='".$row['ikategori_id']."'>".$row['vkategori']."</option>";
                }
            }
            $o .= "</select>";
            
            return $o;
    } 

    function updateBox_import_uji_labs_ikategori_id($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
        if ($this->input->get('action') == 'view') {
            $sql = 'select a.ikategori_id,a.vkategori from hrd.mnf_kategori a where a.ikategori_id= "'.$rows['ikategori_id'].'"';
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $o = $row->vkategori;
            }
        } else {

            $o  = "<select name='".$field."' id='".$id."' class='required' disabled='true'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.ikategori_id,a.vkategori from hrd.mnf_kategori a where a.ldeleted=0";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($rows['ikategori_id'] == $row['ikategori_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected} value='".$row['ikategori_id']."'>".$row['vkategori']."</option>";
                }
            }
        }   

            $o .= "</select>";
            
            return $o;
    } 

    function insertBox_import_uji_labs_ilab_penguji_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />
					';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/import/browse/ujilab/?field=import_uji_labs\',\'List Lab Penguji\')" type="button">&nbsp;</button>';                
		
		return $return;
	}

	function updateBox_import_uji_labs_ilab_penguji_id($field, $id, $value, $rowData) {
		$sql = 'SELECT a.ilab_penguji_id,a.vNama_lab_penguji,a.vAlamat,a.vTelp, a.vContact_Person FROM plc2.`lab_penguji` a WHERE a.ilab_penguji_id ="'.$value.'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vNama_lab_penguji'];

		}else{
			
			if ($rowData['iSubmit_ujiLabs'] == 0) {
				$return = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />
						';
			$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="10" value="'.$data_upb['vNama_lab_penguji'].'"/>';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/import/browse/ujilab/?field=import_uji_labs\',\'List Lab Penguji\')" type="button">&nbsp;</button>';                
			
			
			}else{
				$return= $data_upb['vNama_lab_penguji'];
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			}
			
			//$return= $data_upb['vNo_upi'];
		}
		
		return $return;
	}

	function insertBox_import_uji_labs_vAlamat($field, $id) {
		$o 	= "<textarea name='".$id."' id='".$id."' class='required' disabled style='width: 260px; height: 50px;'size='250'></textarea>";		
		$o .= "	<script>
				$('#".$id."').keyup(function() {
				var len = this.value.length;
				if (len >= 250) {
				this.value = this.value.substring(0, 250);
				}
				$('#maxlengthnote').text(250 - len);
				});
			</script>";
	    $o .= '<br/>tersisa <span id="maxlengthnote">250</span> karakter<br/>';
    
                                            
		return $o;
	}

	function updateBox_import_uji_labs_vAlamat($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.lab_penguji', array('ilab_penguji_id'=>$rowData['ilab_penguji_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Note'>".nl2br($rows['vAlamat'])."</label>";
		
		}else{
			$o 	= "<textarea name='".$id."' id='".$id."' class='required' disabled   style='width: 240px; height: 50px;'size='250'>".nl2br($rows['vAlamat'])."</textarea>";		
			$o .= "	<script>
				$('#".$id."').keyup(function() {
				var len = this.value.length;
				if (len >= 250) {
				this.value = this.value.substring(0, 250);
				}
				$('#maxlengthnote').text(250 - len);
				});
			</script>";
	    	$o .= '<br/>tersisa <span id="maxlengthnote">250</span> karakter<br/>';
	    
		}

		return $o;
	}

	function insertBox_import_uji_labs_vTelp($field, $id) {
		$return = '<input type="text" name="'.$field.'"  disabled="true" id="'.$id.'" class="input_rows1 required" size="35" />';
		return $return;
	}

	function updateBox_import_uji_labs_vTelp($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.lab_penguji', array('ilab_penguji_id'=>$rowData['ilab_penguji_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vTelp'];

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="35" disabled="true" id="'.$id.'" value="'.$rows['vTelp'].'" class="input_rows1 required" size="10" />';

		}
		
		return $return;
	}

	function insertBox_import_uji_labs_vContact_Person($field, $id) {
		$return = '<input type="text" name="'.$field.'"  disabled="true" id="'.$id.'" class="input_rows1 required" size="35" />';
		return $return;
	}

	function updateBox_import_uji_labs_vContact_Person($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.lab_penguji', array('ilab_penguji_id'=>$rowData['ilab_penguji_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vContact_Person'];

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="35" disabled="true" id="'.$id.'" value="'.$rows['vContact_Person'].'" class="input_rows1 required" size="10" />';

		}
		
		return $return;
	}

	function insertBox_import_uji_labs_dTanggal_kirim_sample($field, $id){
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly" class="input_rows1 required" size="8" />';
		$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		return $return;
	}
	function updateBox_import_uji_labs_dTanggal_kirim_sample($field, $id, $value, $rowData) {
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" readonly="readonly" class="input_rows1 required" size="8" value='.$value.' />';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
					</script>';
		}
		return $return;
	}

	function insertBox_import_uji_labs_dTanggal_permohonan_pemeriksaaan($field, $id){
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly" class="input_rows1 required" size="8" />';
		$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		return $return;
	}
	function updateBox_import_uji_labs_dTanggal_permohonan_pemeriksaaan($field, $id, $value, $rowData) {
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" readonly="readonly" class="input_rows1 required" size="8" value='.$value.' />';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
					</script>';
		}
		return $return;
	}
	
	function insertBox_import_uji_labs_dTanggal_hasil_pemeriksaan($field, $id){
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly" class="input_rows1 required" size="8" />';
		$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		return $return;
	}
	function updateBox_import_uji_labs_dTanggal_hasil_pemeriksaan($field, $id, $value, $rowData) {
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" readonly="readonly" class="input_rows1 required" size="8" value='.$value.' />';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
					</script>';
		}
		return $return;
	}


	//Upload File

	function insertBox_import_uji_labs_vFilesuratpenawaran($field, $id) {
    	$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('import_uji_labs_file1',$data,TRUE);
	}
	function updateBox_import_uji_labs_vFilesuratpenawaran($field, $id, $value, $rowData) {
		$qr="select * from plc2.file_surat_penawaran where iujilab_id='".$rowData['iujilab_id']."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('import_uji_labs_file1',$data,TRUE);
	}
	
	function insertBox_import_uji_labs_vFileparameterperiksa($field, $id) {
    	$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('import_uji_labs_file2',$data,TRUE);
	}
	function updateBox_import_uji_labs_vFileparameterperiksa($field, $id, $value, $rowData) {
		$qr="select * from plc2.file_parameter_periksa where iujilab_id='".$rowData['iujilab_id']."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('import_uji_labs_file2',$data,TRUE);
	}
	
	function insertBox_import_uji_labs_vFilefilebuktibayar($field, $id) {
    	$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('import_uji_labs_file3',$data,TRUE);
	}
	function updateBox_import_uji_labs_vFilefilebuktibayar($field, $id, $value, $rowData) {
		$qr="select * from plc2.file_bukti_bayar where iujilab_id='".$rowData['iujilab_id']."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('import_uji_labs_file3',$data,TRUE);
	}

	function insertBox_import_uji_labs_vFilehasilperiksa($field, $id) {
    	$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('import_uji_labs_file',$data,TRUE);
	}
	function updateBox_import_uji_labs_vFilehasilperiksa($field, $id, $value, $rowData) {
		$qr="select * from plc2.file_hasil_periksa where iujilab_id='".$rowData['iujilab_id']."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('import_uji_labs_file',$data,TRUE);
	}

	function insertBox_import_uji_labs_histori($field, $id) {
		$return ='';
		$return .= '
					<script type="text/javascript">
						$("label[for=\''.$id.'\']").hide();
						$("label[for=\''.$id.'\']").next().css("margin-left",0);
					</script>
				';
		$return .= '<div id="hist_dok_td_view"></div>';
		return $return;
	}

	function updateBox_import_uji_labs_histori($field, $id, $value, $rowData) {
		//$sql_doc='	select * from dossier.dossier_dok_td a where a.lDeleted = 0 and a.idossier_review_id = "'.$rowData['idossier_review_id'].'" and a.iapp_dok_td_cek4=2';
		$sql_doc="SELECT a.`iujilab_id`, a.`iupi_id`, DATE_FORMAT(a.`dTanggal_hasil_pemeriksaan`,'%m-%d-%Y') AS a, 
				DATE_FORMAT(a.`dTanggal_kirim_sample`,'%m-%d-%Y') AS b, DATE_FORMAT(a.`dTanggal_permohonan_pemeriksaaan`,'%m-%d-%Y') AS c,
				b.*,c.* FROM plc2.`uji_lab_upi` a 
				JOIN plc2.`lab_penguji` b ON a.`ilab_penguji_id` = b.`ilab_penguji_id`
				JOIN plc2.`daftar_upi` c ON a.`iupi_id` = c.`iupi_id`
				WHERE a.`lDeleted`=0 AND c.iStatusKill=0 AND a.`iupi_id`=".$rowData['iupi_id'];
		$data['rows'] = $this->db_plc0->query($sql_doc)->result_array();
		$return ='';
		$return .= '
					<script type="text/javascript">
						$("label[for=\''.$id.'\']").hide();
						$("label[for=\''.$id.'\']").next().css("margin-left",0);
					</script>
				';
		$return .= '<div id="hist_dok_td_view"> ';
		$return .= $this->load->view('uji_lab_histori',$data,TRUE);
		$return .='</div>';
		return $return;
	}

	/*function manipulate_insert_button($buttons) {
		unset($buttons['save']);

		$js = $this->load->view('import/import_uji_labs_js');
		$js .= $this->load->view('uploadjs');

		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'import_uji_labs\', \''.base_url().'processor/plc/import/uji/labs?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_import_uji_labs">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'import_uji_labs\', \''.base_url().'processor/plc/import/uji/labs?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_import_uji_labs">
				Save &amp; Submit</button>';
		
		$buttons['save'] = $save_draft.$save.$js;


		return $buttons;
	}*/
	function before_insert_processor($row, $postData) {

	// ubah status submit
		if($postData['isdraft']==true){
			$postData['iSubmit_ujiLabs']=0;
		} 
		else{
			$postData['iSubmit_ujiLabs']=1;
		} 
			$postData['dCreate'] = date('Y-m-d H:i:s');
			$postData['cCreated'] =$this->user->gNIP;
		
		return $postData;
	}
	function before_update_processor($row, $postData) {
	
	if($postData['isdraft']==true){
		$postData['iSubmit_ujiLabs']=0;
	} else{
		$postData['iSubmit_ujiLabs']=1;} 


	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;

	return $postData;

}

	function manipulate_insert_button($buttons) {
		unset($buttons['save']);

		$js = $this->load->view('import/import_uji_labs_js');
		
		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'import_uji_labs\', \''.base_url().'processor/plc/import/uji/labs?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_import_uji_labs_js">Save as Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\'import_uji_labs\', \''.base_url().'processor/plc/import/uji/labs?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_import_uji_labs">Save &amp; Submit</button>';
        
		
		$buttons['save'] = $save_draft.$save.$js;

		return $buttons;
	}


	function manipulate_update_button($buttons, $rowData) {
			$mydept = $this->auth->my_depts(TRUE);
			$cNip= $this->user->gNIP;

			
			//$js = $this->load->view('import_uji_labs_js');
			$js = $this->load->view('import/import_uji_labs_js');
			$update = '<button onclick="javascript:update_btn_back(\'import_uji_labs\', \''.base_url().'processor/plc/import/uji/labs?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_update_import_uji_labs">Update & Submit</button>';
			$updatedraft = '<button onclick="javascript:update_draft_btn(\'import_uji_labs\', \''.base_url().'processor/plc/import/uji/labs?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_import_uji_labs">Update as Draft</button>';

			$approve_bdirm = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/uji/labs?action=approve&iujilab_id='.$rowData['iujilab_id'].'&iupi_id='.$rowData['iupi_id'].'&cNip='.$cNip.'&lvl=1&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_import_uji_labs">Approve</button>';
			$reject_bdirm = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/uji/labs?action=reject&iujilab_id='.$rowData['iujilab_id'].'&cNip='.$cNip.'&lvl=1&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_import_uji_labs">Reject</button>';

			

			if ($this->input->get('action') == 'view') {unset($buttons['update']);}

			else{
				
				unset($buttons['update_back']);
				unset($buttons['update']);
				
				if ($rowData['iSubmit_ujiLabs']== 0) {
					// jika masih draft , show button update draft & update submit 
					if (isset($mydept)) {
						// cek punya dep
						if((in_array('BDI', $mydept)) || (in_array('BDE', $mydept)) ) {

									$buttons['update'] = $update.$updatedraft.$js;
						}
					}

				}else{
						if (isset($mydept)) {
							if((in_array('BDI', $mydept))) {
								if($this->auth->is_manager()){
									$buttons['update'] = $approve_bdirm.$reject_bdirm.$js;	
								}
							}
						}	
					
				}
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
								var url = "'.base_url().'processor/plc/import/uji/labs";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_import_uji_labs").html(data);
										 $("#button_approve_import_uji_labs").hide();
										 $("#button_reject_import_uji_labs").hide();
									});
									
								}
									reload_grid("grid_import_uji_labs");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_import_uji_labs_approve" action="'.base_url().'processor/plc/import/uji/labs?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="iupi_id" value="'.$this->input->get('iupi_id').'" />
				<input type="hidden" name="iujilab_id" value="'.$this->input->get('iujilab_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_import_uji_labs_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$ianalisa_prinsipal_id = $post['iujilab_id'];
		$vRemark = $post['vRemark'];
		//$ikategori_id = $post['ikategori_id'];
		$iupi_id = $post['iupi_id'];


		$data =array();
		$data=array('iApprove_bdirm'=>'2','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>date('Y-m-d H:i:s'), 'vRemark_bdirm'=>$vRemark);
		$this -> db -> where('iujilab_id', $ianalisa_prinsipal_id);
		//Uprofe
		$updet = $this -> db -> update('plc2.uji_lab_upi', $data);


		//Mengubah Status Uji ke Prareg
		$data1 =array();
		$data1 =array('iStatusUji'=>'0');
		$this -> db -> where('iupi_id', $iupi_id);
		$updet1 = $this -> db -> update('plc2.daftar_upi', $data1);

		$data['status']  = true;
		$data['last_id'] = $post['iujilab_id'];
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_import_uji_labs_remark").val();
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
								var url = "'.base_url().'processor/plc/import/uji/labs";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_import_uji_labs").html(data);
										 $("#button_approve_import_uji_labs").hide();
										 $("#button_reject_import_uji_labs").hide();
									});
									
								}
									reload_grid("grid_import_uji_labs");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_import_uji_labs_reject" action="'.base_url().'processor/plc/import/uji/labs?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="iujilab_id" value="'.$this->input->get('iujilab_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="reject_import_uji_labs_remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_import_uji_labs_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function reject_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$iujilab_id = $post['iujilab_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove_bdirm'=>'1','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>date('Y-m-d H:i:s'), 'vRemark_bdirm'=>$vRemark);
		$this -> db -> where('iujilab_id', $iujilab_id);
		$updet = $this -> db -> update('plc2.uji_lab_upi', $data);

		$data['status']  = true;
		$data['last_id'] = $post['iujilab_id'];
		return json_encode($data);
	}


	/*function after_insert_processor($row, $insertId, $postData){
		
	}
*/
    /*function manipulate_update_button($button) {
		if ($this->input->get('action') == 'view') {
			unset($button['update']);
		}
		return $button;
    }*/

    function after_insert_processor($fields, $id, $postData) {
	$logged_nip =$this->user->gNIP;
	$qupi="select c.iSubmit_ujiLabs,a.iupi_id,a.vNo_upi,a.dTgl_upi,a.cPengusul_upi,a.vNama_usulan,a.vKekuatan,a.vDosis,a.vNama_generik,a.vIndikasi 
			,a.iSubmit_upi,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdirm,
			b.cNip,b.vName,c.iujilab_id
			from plc2.daftar_upi a 
			join plc2.uji_lab_upi c on c.iupi_id=a.iupi_id
			join hrd.employee b on b.cNip=a.cPengusul_upi
			where a.lDeleted=0
			and c.iujilab_id = '".$id."'";
	$rupd = $this->db_plc0->query($qupi)->row_array();

	$submit = $rupd['iSubmit_ujiLabs'] ;

	if ($submit == 1) {
		$bdirm = $rupd['bdirm'];

		$team = $bdirm;
		//$team = '81' ;

        $toEmail2='';
		$toEmail = $this->lib_utilitas->get_email_team( $team );
        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
        $arrEmail = $this->lib_utilitas->get_email_by_nip( $logged_nip );                    
                    
		$to = $cc = '';
		if(is_array($arrEmail)) {
			$count = count($toEmail);
			$to = $toEmail[0];
			for($i=1;$i<$count;$i++) {
				$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
			}
		}	

		$to = $toEmail2.';'.$toEmail;
		$cc = $arrEmail;                        

		//$to = $arrEmail;
		//$cc = $toEmail2.';'.$toEmail;                        

			$subject="New : Uji Lab ".$rupd['vNo_upi'];
			$content="Diberitahukan bahwa telah ada Input Uji Lab pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
				<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
					<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
						<tr>
							<td style='width: 110px;'><b>No UPI</b></td><td style='width: 20px;'> : </td><td>".$rupd['vNo_upi']."</td>
						</tr>
						<tr>
							<td><b>Tanggal UPI</b></td><td> : </td><td>".$rupd['dTgl_upi']."</td>
						</tr>
						<tr>
							<td><b>Diinput oleh</b></td><td> : </td><td>".$rupd['cNip'].' - '.$rupd['vName']."</td>
						</tr>
						<tr>
							<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
						</tr>
						<tr>
							<td><b>Kekuatan</b></td><td> : </td><td>".$rupd['vKekuatan']."</td>
						</tr>
						<tr>
							<td><b>Dosis</b></td><td> : </td><td> ".$rupd['vDosis']."</td>
						</tr>
						<tr>
							<td><b>Nama Generik</b></td><td> : </td><td>".$rupd['vNama_generik']."</td>
						</tr>
						<tr>
							<td><b>Indikasi</b></td><td> : </td><td><p> ".$rupd['vIndikasi']."</p></td>
						</tr>
					</table>
				</div>
				<br/> 
				Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
				Post Master";
			$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		
	}




}

function after_update_processor($fields, $id, $postData) {
	$logged_nip =$this->user->gNIP;
	$qupi="select c.iSubmit_ujiLabs,a.iupi_id,a.vNo_upi,a.dTgl_upi,a.cPengusul_upi,a.vNama_usulan,a.vKekuatan,a.vDosis,a.vNama_generik,a.vIndikasi 
			,a.iSubmit_upi,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdirm,
			b.cNip,b.vName,c.iujilab_id
			from plc2.daftar_upi a 
			join plc2.uji_lab_upi c on c.iupi_id=a.iupi_id
			join hrd.employee b on b.cNip=a.cPengusul_upi
			where a.lDeleted=0
			and c.iujilab_id = '".$id."'";
	$rupd = $this->db_plc0->query($qupi)->row_array();

	$submit = $rupd['iSubmit_ujiLabs'] ;

	if ($submit == 1) {
		$bdirm = $rupd['bdirm'];

		$team = $bdirm;
		//$team = '81' ;

        $toEmail2='';
		$toEmail = $this->lib_utilitas->get_email_team( $team );
        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
        $arrEmail = $this->lib_utilitas->get_email_by_nip( $logged_nip );                    
                    
		$to = $cc = '';
		if(is_array($arrEmail)) {
			$count = count($toEmail);
			$to = $toEmail[0];
			for($i=1;$i<$count;$i++) {
				$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
			}
		}	

		$to = $toEmail2.';'.$toEmail;
		$cc = $arrEmail;                        

		//$to = $arrEmail;
		//$cc = $toEmail2.';'.$toEmail;                        

			$subject="New : Uji Lab ".$rupd['vNo_upi'];
			$content="Diberitahukan bahwa telah ada Input Uji Lab pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
				<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
					<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
						<tr>
							<td style='width: 110px;'><b>No UPI</b></td><td style='width: 20px;'> : </td><td>".$rupd['vNo_upi']."</td>
						</tr>
						<tr>
							<td><b>Tanggal UPI</b></td><td> : </td><td>".$rupd['dTgl_upi']."</td>
						</tr>
						<tr>
							<td><b>Diinput oleh</b></td><td> : </td><td>".$rupd['cNip'].' - '.$rupd['vName']."</td>
						</tr>
						<tr>
							<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
						</tr>
						<tr>
							<td><b>Kekuatan</b></td><td> : </td><td>".$rupd['vKekuatan']."</td>
						</tr>
						<tr>
							<td><b>Dosis</b></td><td> : </td><td> ".$rupd['vDosis']."</td>
						</tr>
						<tr>
							<td><b>Nama Generik</b></td><td> : </td><td>".$rupd['vNama_generik']."</td>
						</tr>
						<tr>
							<td><b>Indikasi</b></td><td> : </td><td><p> ".$rupd['vIndikasi']."</p></td>
						</tr>
					</table>
				</div>
				<br/> 
				Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
				Post Master";
			$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		
	}
}


    //Tambahan

    function downloadbkt($filename) {
		$this->load->helper('download');		
		$name = $_GET['filebkt'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/bukti_pembayaran/'.$id.'/'.$name);	
		force_download($name, $path);
	}
	function downloadhsl($filename) {
		$this->load->helper('download');		
		$name = $_GET['filehsl'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/hasil_uji_labs/'.$id.'/'.$name);	
		force_download($name, $path);
	}
	function downloadprm($filename) {
		$this->load->helper('download');		
		$name = $_GET['fileprm'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/parameter_pemeriksaan/'.$id.'/'.$name);	
		force_download($name, $path);
	}
	function downloadad($filename) {
		$this->load->helper('download');		
		$name = $_GET['filead'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/surat_penawaran/'.$id.'/'.$name);	
		force_download($name, $path);
	}

    function output(){
		$this->index($this->input->get('action'));
	}
}