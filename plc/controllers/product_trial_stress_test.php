<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_trial_stress_test extends MX_Controller {
		var $_url;
		var $dbset; 
	function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->load->library('biz_process');
        $this->load->library('lib_utilitas');
		$this->user = $this->auth->user(); 
		$this->dbset = $this->load->database('plc', true);
		$this->url = 'product_trial_stress_test';
    }
    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle('Stress Test');		
		$grid->setTable('plc2.plc2_upb_formula');		
		$grid->setUrl('product_trial_stress_test');
		//$grid->addList('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','iskimiawi','isdisolusi','ismikro','plc2_upb.iteampd_id','istress_apppd');
		$grid->addList('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','ilab','istress_apppd');
		$grid->setSortBy('ifor_id');
		$grid->setSortOrder('DESC');
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '100');
		$grid->setWidth('vkode_surat', '150');
		$grid->setWidth('plc2_upb.vupb_nama', '250');
		$grid->setWidth('plc2_upb.vgenerik', '250');
		// $grid->setWidth('idisolusi', '75');
		// $grid->setWidth('ikimiawi', '75');
		// $grid->setWidth('imikro', '75');
		// $grid->setWidth('ilab', '150');
		$grid->addFields('vkode_surat','iupb_id','vupb_nama','vgenerik','iteampd_id','tberlaku','filename','vrevisi','vnip_formulator');
		$grid->addFields('tstart_stress','tend_stress','tupload_stress','tstart_skimiawi','tend_skimiawi','vnip_pic_skimiawi','vhasil_skimiawi','iskimiawi','thasil_skimiawi','tkimias_note');
		$grid->addFields('tstart_sdisolusi','tend_sdisolusi','vnip_pic_sdisolusi','vhasil_sdisolusi','isdisolusi','thasil_sdisolusi');
		$grid->addFields('tstart_smikro','tend_smikro','vnip_pic_smikro','vhasil_smikro','ismikro','thasil_smikro','tmikros_note');
		$grid->addFields('ilab','thasil_ilab','tnote','tstress_note','vstress_nip_apppd','iKeSkala_lab');
		$grid->setRequired('ilab');
		$grid->setLabel('vkode_surat', 'No. Formulasi');
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('plc2_upb.iupb_id', 'No. UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setLabel('iteampd_id', 'Team PD');		
		$grid->setLabel('plc2_upb.iteampd_id', 'Team PD');
		$grid->setLabel('tberlaku', 'Tanggal berlaku');
		$grid->setLabel('filename', 'Nama File');
		$grid->setLabel('vrevisi', 'Revisi');
		$grid->setLabel('vnip_formulator', 'Formulator');
		$grid->setLabel('tstart_stress', 'Tgl. Mulai Stress Test');
		$grid->setLabel('tend_stress', 'Tgl. Selesai Stress Test');
		$grid->setLabel('tupload_stress', 'Tgl. Update Stress Test');
		$grid->setLabel('tstart_skimiawi', 'Tgl. Mulai Analisa Kimiawi');
		$grid->setLabel('tend_skimiawi', 'Tgl. Selesai Analisa Kimiawi');
		$grid->setLabel('vnip_pic_skimiawi', 'PIC Analisa Kimiawi');
		$grid->setLabel('vhasil_skimiawi', 'Hasil Analisa Kimiawi');
		$grid->setLabel('thasil_skimiawi', 'Tgl. Kesimpulan Analisa Kimiawi');
		$grid->setLabel('iskimiawi', 'Analisa Kimiawi');
		
		$grid->setLabel('isdisolusi', 'Uji UDT');
		$grid->setLabel('tstart_sdisolusi', 'Tgl. Mulai Uji Disolusi');
		$grid->setLabel('tend_sdisolusi', 'Tgl. Selesai Uji Disolusi');
		$grid->setLabel('vnip_pic_sdisolusi', 'PIC Uji Disolusi');
		$grid->setLabel('vhasil_sdisolusi', 'Hasil Uji Disolusi');
		$grid->setLabel('thasil_sdisolusi', 'Tgl. Kesimpulan Uji Disolusi');
		
		$grid->setLabel('ismikro', 'Uji Mikrobiologi');
		$grid->setLabel('tstart_smikro', 'Tgl. Mulai Uji Mikrobiologi');
		$grid->setLabel('tend_smikro', 'Tgl. Selesai Uji Mikrobiologi');
		$grid->setLabel('vnip_pic_smikro', 'PIC Uji Mikrobiologi');
		$grid->setLabel('vhasil_smikro', 'Hasil Uji Mikrobiologi');
		$grid->setLabel('thasil_smikro', 'Tgl. Kesimpulan Uji Mikrobiologi');
		
		$grid->setLabel('ilab', 'Hasil Stress Test');
		$grid->setLabel('thasil_ilab', 'Tgl. Hasil Stress Test');
		$grid->setLabel('tnote', 'Catatan Formula');
		$grid->setLabel('tstress_note', 'Catatan Stress Test');
		$grid->setLabel('tmikros_note', 'Catatan Mikrobiologi');
		$grid->setLabel('tkimias_note', 'Catatan Uji Kimkiawi');
		$grid->setLabel('vstress_nip_apppd', 'PD Approval');
		$grid->setLabel('istress_apppd', 'PD Approval');

		$grid->setLabel('iKeSkala_lab', 'Ke Skala Lab');
		
		
		$grid->setFormWidth('vrevisi',5);
		$grid->setFormWidth('vkode_surat',20);
		$grid->setFormWidth('ismikro',25);
		
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('QC', $manager)){
				$type='QC';
				$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth->my_teams().')', null);
			}
			elseif(in_array('QA', $manager)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth->my_teams().')', null);
			}
			elseif(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('QC', $team)){
				$type='QC';
				$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth->my_teams().')', null);
			}
			elseif(in_array('QA', $team)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth->my_teams().')', null);
			}
			elseif(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		$grid->setQuery('plc2_upb_formula.ldeleted', 0);
		$grid->setQuery('plc2_upb_formula.iwithstress', 1); // cari yg melalui stress test
		$grid->setQuery('plc2_upb_formula.istress', 2); // cari yg hasil skala trial nya tdk Gagal
		$grid->setQuery('plc2_upb_formula.iformula_apppd', 2); //sudah approve formula skala trial oleh PD
		$grid->setQuery('plc2_upb.ihold', 0);
		/*Start Buat Upload*/
		
		//Set Form Supaya ectype=multipart dan jadi iframe post
		$grid->setFormUpload(TRUE);
	
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id', 'inner');
		//$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id', 'inner');
		$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));
		//$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner');
		
		$grid->changeFieldType('iskimiawi','combobox','',array(0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		//$grid->changeFieldType('ikimiawi','combobox','',array(0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		//$grid->changeFieldType('idisolusi','combobox','',array(0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('isdisolusi','combobox','',array(0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		//$grid->changeFieldType('imikro','combobox','',array(0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('ilab','combobox','',array(0=>'-', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('ismikro','combobox','',array(0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		//$grid->changeFieldType('istress_apppd','combobox','',array(''=>'-',0=>'Waiting For Approval',1=>'Reject', 2=>'Approved'));
		
		//$grid->changeFieldType('istress','combobox','',array(0=>'-',4=>'Diskontinu',3=>'Kontinu', 2=>'Berhasil', 1=>'Gagal'));
		
		$grid->setSearch('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama');
		//$grid->setSearch('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','ilab');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
					$isUpload = $this->input->get('isUpload');
				$sql = array();
				$sql1 = array();
				$sql2 = array();
				$sql3 = array();
   				if($isUpload) {
					$path = realpath("files/plc/product_trial/skala_trial/filename");
					$path2 = realpath("files/plc/product_trial/stress_test/disolusi");
					$path1 = realpath("files/plc/product_trial/stress_test/kimiawi");
					$path3 = realpath("files/plc/product_trial/stress_test/mikrobiologi");
					
					if (!mkdir($path."/".$this->input->get('lastId'), 0777, true)) {
					    die('Failed upload, try again!');
					}
					if (!mkdir($path1."/".$this->input->get('lastId'), 0777, true)) {
					    die('Failed upload, try again!');
					}
					if (!mkdir($path2."/".$this->input->get('lastId'), 0777, true)) {
					    die('Failed upload, try again!');
					}
					if (!mkdir($path3."/".$this->input->get('lastId'), 0777, true)) {
					    die('Failed upload, try again!');
					}
					
					$file_keterangan = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'fileketerangan') {
							foreach($value as $k=>$v) {
								$file_keterangan[$k] = $v;
							}
						}
						if ($key == 'fileketerangan1') {
							foreach($value as $k=>$v) {
								$file_keterangan1[$k] = $v;
							}
						}
						if ($key == 'fileketerangan2') {
							foreach($value as $k=>$v) {
								$file_keterangan2[$k] = $v;
							}
						}
						if ($key == 'fileketerangan3') {
							foreach($value as $k=>$v) {
								$file_keterangan3[$k] = $v;
							}
						}
					}
				
					$i = 0;
					//upload form 1
					foreach ($_FILES['fileupload']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {				
							$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
							$name = $_FILES['fileupload']["name"][$key];
							$data['filename'] = $name;
							$data['id']=$this->input->get('lastId');
							$data['nip']=$this->user->gNIP;
							//$data['iupb_id'] = $insertId;
							//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							$data['dInsertDate'] = date('Y-m-d H:i:s');
							if(move_uploaded_file($tmp_name, $path."/".$this->input->get('lastId')."/".$name)) {	
								$sql[] = "INSERT INTO plc2_upb_file_skala_trial_filename(ifor_id, filename, dInsertDate, keterangan,cInsert) 
										VALUES ('".$data['id']."', '".$data['filename']."','".$data['dInsertDate']."','".$file_keterangan[$i]."','".$data['nip']."')";
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
					
					//upload form 2
					$i = 0;
					foreach ($_FILES['fileupload1']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {				
							$tmp_name1 = $_FILES['fileupload1']["tmp_name"][$key];
							$name1 = $_FILES['fileupload1']["name"][$key];
							$data1['filename'] = $name1;
							$data1['id']=$this->input->get('lastId');
							$data1['nip']=$this->user->gNIP;
							//$data['iupb_id'] = $insertId;
							//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							$data1['dInsertDate'] = date('Y-m-d H:i:s');
							if(move_uploaded_file($tmp_name1, $path1."/".$this->input->get('lastId')."/".$name1)) {	
								$sql1[] = "INSERT INTO plc2_upb_file_stress_test_kimiawi(ifor_id, filename, dInsertDate, keterangan,cInsert) 
										VALUES ('".$data1['id']."', '".$data1['filename']."','".$data1['dInsertDate']."','".$file_keterangan1[$i]."','".$data1['nip']."')";
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
						}catch(Exception $e) {
							die($e);
						}
					}
					
					//upload form 3
					$i = 0;
					foreach ($_FILES['fileupload2']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {				
							$tmp_name2 = $_FILES['fileupload2']["tmp_name"][$key];
							$name2 = $_FILES['fileupload2']["name"][$key];
							$data2['filename'] = $name2;
							$data2['id']=$this->input->get('lastId');
							$data2['nip']=$this->user->gNIP;
							//$data['iupb_id'] = $insertId;
							//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							$data2['dInsertDate'] = date('Y-m-d H:i:s');
							if(move_uploaded_file($tmp_name2, $path2."/".$this->input->get('lastId')."/".$name2)) {	
								$sql2[] = "INSERT INTO plc2_upb_file_stress_test_disolusi(ifor_id, filename, dInsertDate, keterangan,cInsert) 
										VALUES ('".$data2['id']."', '".$data2['filename']."','".$data2['dInsertDate']."','".$file_keterangan2[$i]."','".$data2['nip']."')";
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
						}catch(Exception $e) {
							die($e);
						}
					}
					
					//upload form 4
					$i = 0;
					foreach ($_FILES['fileupload3']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {				
							$tmp_name3 = $_FILES['fileupload3']["tmp_name"][$key];
							$name3 = $_FILES['fileupload3']["name"][$key];
							$data3['filename'] = $name3;
							$data3['id']=$this->input->get('lastId');
							$data3['nip']=$this->user->gNIP;
							//$data['iupb_id'] = $insertId;
							//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							$data3['dInsertDate'] = date('Y-m-d H:i:s');
							if(move_uploaded_file($tmp_name3, $path3."/".$this->input->get('lastId')."/".$name3)) {	
								$sql3[] = "INSERT INTO plc2_upb_file_stress_test_mikrobiologi(ifor_id, filename, dInsertDate, keterangan,cInsert) 
										VALUES ('".$data3['id']."', '".$data3['filename']."','".$data3['dInsertDate']."','".$file_keterangan3[$i]."','".$data3['nip']."')";
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
						}catch(Exception $e) {
							die($e);
						}
					}
					
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');					
					echo json_encode($r);
					exit();
				}  else {
					echo $grid->saved_form();
				}
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'), TRUE);
				break;
			case 'updateproses':
				$isUpload = $this->input->get('isUpload');
				$sql = array();
   				$sql1 = array();
				$sql2 = array();
				$sql3 = array();
				$file_name= "";
				$file_name1= "";
				$file_name2= "";
				$file_name3= "";
				
				$fileId = array();
				
				$path = realpath("files/plc/product_trial/skala_trial/filename");
				$path2 = realpath("files/plc/product_trial/stress_test/disolusi");
				$path1 = realpath("files/plc/product_trial/stress_test/kimiawi");
				$path3 = realpath("files/plc/product_trial/stress_test/mikrobiologi");
				
				if (!file_exists( $path."/".$this->input->post('product_trial_stress_test_ifor_id') )) {
					mkdir($path."/".$this->input->post('product_trial_stress_test_ifor_id'), 0777, true);						 
				}
			
				if (!file_exists( $path1."/".$this->input->post('product_trial_stress_test_ifor_id') )) { 
					mkdir($path1."/".$this->input->post('product_trial_stress_test_ifor_id'), 0777, true);					    
				}
				
				if (!file_exists( $path2."/".$this->input->post('product_trial_stress_test_ifor_id') )) {	
					mkdir($path2."/".$this->input->post('product_trial_stress_test_ifor_id'), 0777, true);					    
				}
					
				if (!file_exists( $path3."/".$this->input->post('product_trial_stress_test_ifor_id') )) {
					mkdir($path3."/".$this->input->post('product_trial_stress_test_ifor_id'), 0777, true);					    
				}
									
				$file_keterangan = array();
				$file_keterangan1 = array();
				$file_keterangan2 = array();
				$file_keterangan3 = array();
				
				foreach($_POST as $key=>$value) {
											
					if ($key == 'fileketerangan') {
						foreach($value as $y=>$u) {
							$file_keterangan[$y] = $u;
						}
					}
					if ($key == 'fileketerangan1') {
						foreach($value as $y=>$u) {
							$file_keterangan1[$y] = $u;
						}
					}
					if ($key == 'fileketerangan2') {
						foreach($value as $y=>$u) {
							$file_keterangan2[$y] = $u;
						}
					}
					if ($key == 'fileketerangan3') {
						foreach($value as $y=>$u) {
							$file_keterangan3[$y] = $u;
						}
					}
					
					//
					if ($key == 'namafile') {
						foreach($value as $k=>$v) {
							$file_name[$k] = $v;
						}
					}
					if ($key == 'namafile1') {
						foreach($value as $k=>$v) {
							$file_name1[$k] = $v;
						}
					}
					if ($key == 'namafile2') {
						foreach($value as $k=>$v) {
							$file_name2[$k] = $v;
						}
					}
					if ($key == 'namafile3') {
						foreach($value as $k=>$v) {
							$file_name3[$k] = $v;
						}
					}
					
					//
					if ($key == 'fileid') {
						foreach($value as $k=>$v) {
							$fileId[$k] = $v;
						}
					}
					if ($key == 'fileid1') {
						foreach($value as $k=>$v) {
							$fileId1[$k] = $v;
						}
					}
					if ($key == 'fileid2') {
						foreach($value as $k=>$v) {
							$fileId2[$k] = $v;
						}
					}
					if ($key == 'fileid3') {
						foreach($value as $k=>$v) {
							$fileId3[$k] = $v;
						}
					}
				}

				/*$last_index = 0;				
				if (sizeof($fileId) > 0){
					$x=0;				
					foreach($fileId as $k=>$v) {
						$SQL = "UPDATE plc2_upb_file_skala_trial_filename SET keterangan = '".$file_keterangan[$k]."' where id = '".$v."'"; 
						$this->dbset->query($SQL);
						$x=$k;
					}
					$last_index = $x+1;
				}
					
				$last_index1 = 0;
				if (sizeof($fileId1) > 0){
					$xx=0;				
					foreach($fileId1 as $k=>$v) {
						$SQL1 = "UPDATE plc2_upb_file_stress_test_kimiawi SET keterangan = '".$file_keterangan1[$k]."' where id = '".$v."'"; 
						$this->dbset->query($SQL1);
						$xx=$k;
					}
					$last_index1 = $xx+1;
				}
				
				$last_index2 = 0;
				if (sizeof($fileId2) > 0){
					$xxx=0;				
					foreach($fileId2 as $k=>$v) {
						$SQL2 = "UPDATE plc2_upb_file_stress_test_disolusi SET keterangan = '".$file_keterangan2[$k]."' where id = '".$v."'"; 
						$this->dbset->query($SQL2);
						$xxx=$k;
					}
					$last_index2 = $xxx+1;
				}
				
				$last_index3 = 0;
				if (sizeof($fileId3)){
					$xxxx=0;				
					foreach($fileId3 as $k=>$v) {
						$SQL3 = "UPDATE plc2_upb_file_stress_test_mikrobiologi SET keterangan = '".$file_keterangan3[$k]."' where id = '".$v."'"; 
						$this->dbset->query($SQL3);
						$xxxx=$k;
					}
					$last_index3 = $xxxx+1;
				}
				 */
				$last_index = 0;
				$last_index1 = 0;
				$last_index2 = 0;
				$last_index3 = 0;
				
   				if($isUpload) {
					$j = $last_index;						
								
					if (isset($_FILES['fileupload'])) {
						$this->hapusfile($path, $file_name, 'plc2_upb_file_skala_trial_filename', $this->input->post('product_trial_stress_test_ifor_id'));
						foreach ($_FILES['fileupload']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
								$name = $_FILES['fileupload']["name"][$key];
								$data['filename'] = $name;
								$data['id']=$this->input->post('product_trial_stress_test_ifor_id');
								$data['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name, $path."/".$this->input->post('product_trial_stress_test_ifor_id')."/".$name)) 
				 				{
									$sql[] = "INSERT INTO plc2_upb_file_skala_trial_filename(ifor_id, filename, dInsertDate, keterangan,cInsert) 
										VALUES ('".$data['id']."', '".$data['filename']."','".$data['dInsertDate']."','".$file_keterangan[$j]."','".$data['nip']."')";
									$j++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
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
									
					$a = $last_index1;	
					//upload form 2
					if (isset($_FILES['fileupload1'])) {
						
						$this->hapusfile($path1, $file_name1, 'plc2_upb_file_stress_test_kimiawi', $this->input->post('product_trial_stress_test_ifor_id'));
						foreach ($_FILES['fileupload1']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name1 = $_FILES['fileupload1']["tmp_name"][$key];
								$name1 = $_FILES['fileupload1']["name"][$key];
								$data1['filename'] = $name1;
								$data1['id']=$this->input->get('lastId');
								$data1['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data1['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name1, $path1."/".$this->input->post('product_trial_stress_test_ifor_id')."/".$name1)) 
				 				{
									$sql1[] = "INSERT INTO plc2_upb_file_stress_test_kimiawi(ifor_id, filename, dInsertDate, keterangan,cInsert) 
										VALUES ('".$data1['id']."', '".$data1['filename']."','".$data1['dInsertDate']."','".$file_keterangan1[$a]."','".$data1['nip']."')";
									$a++;																			
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
					
					$b = $last_index2;	
					//upload form 3
					if (isset($_FILES['fileupload2'])) {
						$this->hapusfile($path2, $file_name2, 'plc2_upb_file_stress_test_disolusi', $this->input->post('product_trial_stress_test_ifor_id'));
						foreach ($_FILES['fileupload2']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name2 = $_FILES['fileupload2']["tmp_name"][$key];
								$name2 = $_FILES['fileupload2']["name"][$key];
								$data2['filename'] = $name2;
								$data2['id']=$this->input->get('lastId');
								$data2['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data2['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name2, $path2."/".$this->input->post('product_trial_stress_test_ifor_id')."/".$name2)) 
				 				{
									$sql2[] = "INSERT INTO plc2_upb_file_stress_test_disolusi(ifor_id, filename, dInsertDate, keterangan,cInsert) 
										VALUES ('".$data2['id']."', '".$data2['filename']."','".$data2['dInsertDate']."','".$file_keterangan2[$b]."','".$data2['nip']."')";
									$b++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}										
					foreach($sql2 as $q2) {
						try {
							$this->dbset->query($q2);
						}catch(Exception $e) {
							die($e);
						}
					}
					
					//upload form 4
					$c = $last_index3;	
					
					if (isset($_FILES['fileupload3'])) {
						$this->hapusfile($path3, $file_name3, 'plc2_upb_file_stress_test_mikrobiologi', $this->input->post('product_trial_stress_test_ifor_id'));
						foreach ($_FILES['fileupload3']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name3 = $_FILES['fileupload3']["tmp_name"][$key];
								$name3 = $_FILES['fileupload3']["name"][$key];
								$data3['filename'] = $name3;
								$data3['id']=$this->input->get('lastId');
								$data3['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data3['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name3, $path3."/".$this->input->post('product_trial_stress_test_ifor_id')."/".$name3)) 
				 				{
										
									$sql3[] = "INSERT INTO plc2_upb_file_stress_test_mikrobiologi(ifor_id, filename, dInsertDate, keterangan,cInsert) 
										VALUES ('".$data3['id']."', '".$data3['filename']."','".$data3['dInsertDate']."','".$file_keterangan3[$c]."','".$data3['nip']."')";
									$c++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sql3 as $q3) {
						try {
							$this->dbset->query($q3);
						}catch(Exception $e) {
							die($e);
						}
					}
					
				
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');					
					echo json_encode($r);
					exit();
				}  else {
					if (is_array($file_name)) {									
						$this->hapusfile($path, $file_name, 'plc2_upb_file_skala_trial_filename', $this->input->post('product_trial_stress_test_ifor_id'));
					}
					if (is_array($file_name1)) {									
						$this->hapusfile($path1, $file_name1, 'plc2_upb_file_stress_test_kimiawi', $this->input->post('product_trial_stress_test_ifor_id'));
					}
					if (is_array($file_name2)) {									
						$this->hapusfile($path2, $file_name2, 'plc2_upb_file_stress_test_disolusi', $this->input->post('product_trial_stress_test_ifor_id'));
					}
					if (is_array($file_name3)) {									
						$this->hapusfile($path3, $file_name3, 'plc2_upb_file_stress_test_mikrobiologi', $this->input->post('product_trial_stress_test_ifor_id'));
					}								
					echo $grid->updated_form();
				}
				break;
			case 'detail':
				$this->detail();
			break;
			case 'download':
				$this->download($this->input->get('file'));
			break;
			case 'download1':
				$this->download1($this->input->get('file'));
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
			default:
				$grid->render_grid();
				break;
		}
    }
	function manipulate_update_button($buttons, $rowData) {
    	//echo "<pre>";print_r($rowData);echo "</pre>"; exit();
		if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			unset($buttons['update_back']);
    	unset($buttons['update']);
		
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
			if(in_array('QA', $team)){$type='QA';}
    		else if(in_array('QC', $team)){$type='QC';}
			else if(in_array('PD', $team)){$type='PD';}
			else{$type='';}
		}
		// cek status upb, kalo upb 
			unset($buttons['update_back']);
    		unset($buttons['update']);
			
			//echo $this->auth->my_teams();
			
    		$upb_id=$rowData['iupb_id'];
			$imikro_id=$rowData['ifor_id'];
			$qcek="select f.istress_apppd, f.ilab from plc2.plc2_upb_formula f where f.ifor_id=$imikro_id";
			$rcek = $this->db_plc0->query($qcek)->row_array();
			$js = $this->load->view('product_trial_formula_stress_test_js.php');
			
			$x=$this->auth->my_teams();
			//print_r($x);
			$arrhak=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
		//print_r($arrhak);
			if(empty($arrhak)){
				$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
				if(empty($getbp)){}
				else{
					//jika manager PD
					if($this->auth->is_manager()){
						if(($type=='PD')&&($rcek['istress_apppd']==0) &&($rcek['ilab']==0)){ //jika blm app & hasil stress test blm disimpulkan
							$update = '<button onclick="javascript:update_btn_back(\'product_trial_stress_test\', \''.base_url().'processor/plc/product/trial/stress/test?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							// $approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stress/test?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ispekfg_id='.$rowData['ispekfg_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_trial">Approve</button>';
							// $reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stress/test?action=reject&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ispekfg_id='.$rowData['ispekfg_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_trial">Reject</button>';
								
							$buttons['update'] = $update.$js;//.$approve.$reject;
						}
						if(($type=='PD')&&($rcek['istress_apppd']==0) &&($rcek['ilab']==1)){ //jika blm app & hasil stress test gagal
							$update = '<button onclick="javascript:update_btn_back(\'product_trial_stress_test\', \''.base_url().'processor/plc/product/trial/stress/test?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							// $approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stress/test?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ispekfg_id='.$rowData['ispekfg_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_trial">Approve</button>';
							//$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stress/test?action=reject&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ispekfg_id='.$rowData['ispekfg_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_trial">Reject</button>';
								
							$buttons['update'] = $update.$js;//$reject.$approve;
						}
						if(($type=='PD')&&($rcek['istress_apppd']==0)&&($rcek['ilab']==2)){ //jika blm app & hasil stress test berhasil
							$update = '<button onclick="javascript:update_btn_back(\'product_trial_stress_test\', \''.base_url().'processor/plc/product/trial/stress/test?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stress/test?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_trial">Approve</button>';
							// $reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stress/test?action=reject&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ispekfg_id='.$rowData['ispekfg_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_trial">Reject</button>';
								
							$buttons['update'] = $update.$approve.$js; //.$reject;
						}
						else{}
					}
					//jika bukan manager PD, tapi staff PD, QA, QC atau formulator
					else{
						if((($type=='QA')&&($rcek['istress_apppd']==0))||(($type=='QC')&&($rcek['istress_apppd']==0)) || (($type=='PD')&&($rcek['istress_apppd']==0)) || ($rowData['vnip_formulator']==$this->user->gNIP)&&($rcek['istress_apppd']==0)){
							$update = '<button onclick="javascript:update_btn_back(\'product_trial_stress_test\', \''.base_url().'processor/plc/product/trial/stress/test?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$buttons['update'] = $update.$js;
						}
					}
				}
			}else{
				if($this->auth->is_manager()){
						if(($type=='PD')&&($rcek['istress_apppd']==0) &&($rcek['ilab']==0)){ //jika blm app & hasil stress test blm disimpulkan
							$update = '<button onclick="javascript:update_btn_back(\'product_trial_stress_test\', \''.base_url().'processor/plc/product/trial/stress/test?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							// $approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stress/test?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ispekfg_id='.$rowData['ispekfg_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_trial">Approve</button>';
							// $reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stress/test?action=reject&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ispekfg_id='.$rowData['ispekfg_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_trial">Reject</button>';
								
							$buttons['update'] = $update.$js;//.$approve.$reject;
						}
						if(($type=='PD')&&($rcek['istress_apppd']==0) &&($rcek['ilab']==1)){ //jika blm app & hasil stress test gagal
							$update = '<button onclick="javascript:update_btn_back(\'product_trial_stress_test\', \''.base_url().'processor/plc/product/trial/stress/test?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							// $approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stress/test?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ispekfg_id='.$rowData['ispekfg_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_trial">Approve</button>';
							//$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stress/test?action=reject&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ispekfg_id='.$rowData['ispekfg_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_trial">Reject</button>';
								
							$buttons['update'] = $update.$js;//$approve.$reject;
						}
						if(($type=='PD')&&($rcek['istress_apppd']==0)&&($rcek['ilab']==2)){ //jika blm app & hasil stress test berhasil
							$update = '<button onclick="javascript:update_btn_back(\'product_trial_stress_test\', \''.base_url().'processor/plc/product/trial/stress/test?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stress/test?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_trial">Approve</button>';
							// $reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/stress/test?action=reject&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&ispekfg_id='.$rowData['ispekfg_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_trial">Reject</button>';
								
							$buttons['update'] = $update.$approve.$js; //.$reject;
						}
					else{}
					//array_unshift($buttons, $reject, $approve, $revise);
				}
				else{
					if((($type=='QA')&&($rcek['istress_apppd']==0))||(($type=='QC')&&($rcek['istress_apppd']==0)) || (($type=='PD')&&($rcek['istress_apppd']==0)) || ($rowData['vnip_formulator']==$this->user->gNIP)&&($rcek['istress_apppd']==0)){
							$update = '<button onclick="javascript:update_btn_back(\'product_trial_stress_test\', \''.base_url().'processor/plc/product/trial/stress/test?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							$buttons['update'] = $update.$js;
					}
					else{}
				}
			}
		}
       	return $buttons;
    }
    public function listBox_Action($row, $actions) {
    	//cek apakah ada soi mikro upb itu yg statusnya sudah Final, 
		//print_r($row); exit;
		$iupbid=$row->iupb_id;
    	//formulator
		if($row->vnip_formulator==$this->user->gNIP){
			unset($actions['delete']);
		}
		// jika formula skala trial sudah di app tidak bisa di edit
		if($row->istress_apppd<>0){
				unset($actions['edit']);
				unset($actions['delete']);
		}
		return $actions;
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
								var url = "'.base_url().'processor/plc/product/trial/stress/test";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_product_trial_stress_test").html(data);
									});
					
								}
									reload_grid("grid_product_trial_stress_test");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_product_trial_stress_test_approve" action="'.base_url().'processor/plc/product/trial/stress/test?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : <input type="hidden" name="ifor_id" value="'.$this->input->get('ifor_id').'" />
    			<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
    			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_product_trial_stress_test_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
		//print_r($post);

    	
    	$this->db_plc0->where('ifor_id', $post['ifor_id']);
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$iapprove = $post['type'] == 'PD' ? 'istress_apppd' : '';
		$this->db_plc0->update('plc2.plc2_upb_formula', array($iapprove=>2,'vstress_nip_apppd'=>$nip,'tstress_apppd'=>$skg));
    
    	//jika ada satu saja spek fg dari upb tsb blm di app/ reject maka isoiqc / ispekqa = 1
    	$upbid=$post['iupb_id'];
    	
		$ins['iupb_id'] = $post['iupb_id'];
		$ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
		$ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
		$ins['idiv_id'] = '';
		$ins['vtipe'] = $post['type'];
		$ins['iapprove'] = '2';
		$ins['cnip'] = $this->user->gNIP;
		$ins['treason'] = $post['remark'];
		$ins['tupdate'] = date('Y-m-d H:i:s');
    
    	$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
   	
		$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$post['modul_id']); // 1 approval
		$bizsup=$getbp['idplc2_biz_process_sub'];
		
		$ifor_id=$this->input->post('ifor_id');
		//$ispekfg_id=$this->input->post('ispekfg_id');
		
		$hacek=$this->biz_process->cek_last_status($post['iupb_id'],$bizsup,1); // status 1 => app
		if($hacek==1){ // jika sudah pernah ada data maka update saja
			//insert log
				$this->biz_process->insert_log($post['iupb_id'], $bizsup, 1); // status 1 => app
			//update last log
				$this->biz_process->update_last_log($post['iupb_id'], $bizsup, 1);
		}
		elseif($hacek==0){
			//insert log
				$this->biz_process->insert_log($post['iupb_id'], $bizsup, 1); // status 1 => app
			//insert last log
				$this->biz_process->insert_last_log($post['iupb_id'], $bizsup, 1);
		}	
			
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
        $subject="Proses Stress Test Selesai: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval UPB oleh PD Manager pada proses Stress Test(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
                                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>Formula Skala Lab - Input data oleh PD&AD</td>
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
    	$data['status']  = true;
    	$data['last_id'] = $ifor_id;
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
								var url = "'.base_url().'processor/plc/product/trial/stress/test";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_product_trial_stress_test").html(data);
									});
					
								}
									reload_grid("grid_product_trial_stress_test");
							}
					 	 })
						 }
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_product_trial_stress_test_reject" action="'.base_url().'processor/plc/product/trial/stress/test?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
    			<input type="hidden" name="ifor_id" value="'.$this->input->get('ifor_id').'" />
    			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
    			<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark" id="remark" required></textarea><button type="button" onclick="submit_ajax(\'form_product_trial_stress_test_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process() {
    	$post = $this->input->post();
    	
    	$this->db_plc0->where('ifor_id', $post['ifor_id']);
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
	 	$iapprove = $post['type'] == 'PD' ? 'istress_apppd' : '';
    	$this->db_plc0->update('plc2.plc2_upb_formula', array($iapprove=>1,'vstress_nip_apppd'=>$nip,'tstress_apppd'=>$skg));
    
    	$ins['iupb_id'] = $post['iupb_id'];
		$ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
		$ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
		$ins['idiv_id'] = '';
		$ins['vtipe'] = $post['type'];
		$ins['iapprove'] = '2';
		$ins['cnip'] = $this->user->gNIP;
		$ins['treason'] = $post['remark'];
		$ins['tupdate'] = date('Y-m-d H:i:s');
    
    	$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
    
		$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$post['modul_id']); // 1 approval
		$bizsup=$getbp['idplc2_biz_process_sub'];
		
		$ifor_id=$this->input->post('ifor_id');
		//$ispekfg_id=$this->input->post('ispekfg_id');
	
		$hacek=$this->biz_process->cek_last_status($post['iupb_id'],$bizsup,2); // status 2 => reject
		if($hacek==1){ // jika sudah pernah ada data maka update saja
			//insert log
				$this->biz_process->insert_log($post['iupb_id'], $bizsup, 2); // status 2 => reject
			//update last log
				$this->biz_process->update_last_log($post['iupb_id'], $bizsup, 2);
		}
		elseif($hacek==0){
			//insert log
				$this->biz_process->insert_log($post['iupb_id'], $bizsup, 2); // status 2 => reject
			//insert last log
				$this->biz_process->insert_last_log($post['iupb_id'], $bizsup, 2);
		}	
		
    	$data['status']  = true;
    	$data['last_id'] = $ifor_id;
    	return json_encode($data);
    }
	function listBox_product_trial_stress_test_istress_apppd($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }

	function updateBox_product_trial_stress_test_iKeSkala_lab($field, $id, $value ,$rowData) {
		$kat = array(""=>'--Select--', 1=>'Ya', 0=>'Tidak');
		if ($this->input->get('action') == 'view') {
            $o = $kat[$value];

            $o  .= "<select id='iKeSkala_lab'  style='display:none;' class=' required combobox' name='iKeSkala_lab'>";            
            foreach($kat as $k=>$v) {
                if ($k == $value) $selected = " selected";
                else $selected = "";
                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
            }            
            $o .= "</select>";



            if ($rowData["iwithori"]==1) {
        		$checked1="checked"	;
        	}else{
        		$checked1=""	;
        	}

        	if ($rowData["iwithbb"]==1) {
        		$checked2="checked"	;
        	}else{
        		$checked2=""	;
        	}        	
        	
        	$supb="select * from plc2.plc2_upb u where u.iupb_id='".$rowData['iupb_id']."' ";
			$dupb = $this->db_plc0->query($qcek)->row_array();

	        $o .='<div id="cekbok2">';
	        	if ($dupb['vkat_originator']==3) {
	        		$o .='<input type="checkbox" value="1" '.$checked1.' id="iwithori2" name="iwithori"> Sample Originator';
	        	}
			$o .=		'<input type="checkbox" value="1" '.$checked2.'  id="iwithbb2" name="iwithbb"> Sample BB

				</div>';

        	$o .= '<script type="text/javascript">
				
					if ($("#iKeSkala_lab").val()=="0" ) {
						$("#cekbok2").show();	
					}else{
						$("#cekbok2").hide();
					}
					


				$("#iKeSkala_lab").die();
				$("#iKeSkala_lab").live("change",function(){

					if ($(this).val()=="" ) {
						$("#cekbok2").hide();
						
					}else{
						if ($(this).val()=="0" ) {
							$("#cekbok2").show();	
						}else{
							$("#iwithori2").attr("checked", false);
							$("#iwithbb2").attr("checked", false);
						
						}
						
					}
				});
				</script>';

        } else {
            $o  = "<select id='iKeSkala_lab' class=' required combobox' name='iKeSkala_lab'>";            
            foreach($kat as $k=>$v) {
                if ($k == $value) $selected = " selected";
                else $selected = "";
                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
            }            
            $o .= "</select>";


            if ($rowData["iwithori"]==1) {
        		$checked1="checked"	;
        	}else{
        		$checked1=""	;
        	}

        	if ($rowData["iwithbb"]==1) {
        		$checked2="checked"	;
        	}else{
        		$checked2=""	;
        	}        	
        	
	        $o .='<div id="cekbok2">
					<input type="checkbox" value="1" '.$checked1.' id="iwithori2" name="iwithori"> Sample Originator
					<input type="checkbox" value="1" '.$checked2.'  id="iwithbb2" name="iwithbb"> Sample BB

				</div>';

        	$o .= '<script type="text/javascript">
				
					if ($("#iKeSkala_lab").val()=="0" ) {
						$("#cekbok2").show();	
					}else{
						$("#cekbok2").hide();
					}
					


				$("#iKeSkala_lab").die();
				$("#iKeSkala_lab").live("change",function(){
					if ($(this).val()=="" ) {
						$("#cekbok2").hide();

					}else{
						if ($(this).val()=="0" ) {
							$("#cekbok2").show();	
						}else{
							$("#iwithori2").attr("checked", false);
							$("#iwithbb2").attr("checked", false);
							$("#cekbok2").hide();
						}
						
					}
				});
				</script>';


        }

        	
        return $o;
        
	}

	//Keterangan approval 
	function insertBox_product_trial_stress_test_vstress_nip_apppd($field, $id) {
		return '';
	}
	function updateBox_product_trial_stress_test_vstress_nip_apppd($field, $id, $value, $rowData) {
		//print_r($rowData);
		if($rowData['vstress_nip_apppd'] != null){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vstress_nip_apppd']))->row_array();
			if($rowData['istress_apppd']==2){$st="Approved";}elseif($rowData['istress_apppd']==1){$st="Rejected";
				// $rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// if(isset($rowa)){$reason=$rowa['treason'];}
				
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vstress_nip_apppd'].' )'.' pada '.$rowData['tstress_apppd'];
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	//
	function searchPost_product_trial_stress_test_ikimiawi($value, $name) {
		return $value == 0 ? '' : $value;
	}
	function searchPost_product_trial_stress_test_idisolusi($value, $name) {
		return $value == 0 ? '' : $value;
	}
	function searchPost_product_trial_stress_test_imikro($value, $name) {
		return $value == 0 ? '' : $value;
	}
	function searchPost_product_trial_stress_test_istress($value, $name) {
		return $value == 0 ? '' : $value;
	}
	
	function updateBox_product_trial_stress_test_vkode_surat($field, $id, $value) {
		$return= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'" value="'.$value.'" class="input_rows1" />';
		$return.='<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1" />';
		return $return;
		// return '<input type="text" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1" />';
	}

	// function insertBox_product_trial_stress_test_iskimiawi($field, $id) {
		// $return = '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		// $return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="7" />';
		// return $return;
	// }
	
	// function updateBox_product_trial_stress_test_iskimiawi($field, $id, $value, $rowData) {
		// //$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		// if($value=='0' || $value==''){$isi="-";$value='0';}elseif($value=='3'){$isi="Tidak Diuji";}elseif($value=='2'){$isi="Berhasil";}elseif($value=='1'){$isi="Gagal";}
		// $return = '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		// $return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" value="'.$isi.'" class="input_rows1" size="7" />';
		// //echo $isi; exit;
		// return $return;
	// }
	// function insertBox_product_trial_stress_test_isdisolusi($field, $id) {
		// $return = '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		// $return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="7" />';
		// return $return;
	// }
	// function updateBox_product_trial_stress_test_isdisolusi($field, $id, $value, $rowData) {
		// //$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		// if($value=='0' || $value==''){$isi="-";$value='0';}elseif($value=='3'){$isi="Tidak Diuji";}elseif($value=='2'){$isi="Berhasil";}elseif($value=='1'){$isi="Gagal";}
		// $return = '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		// $return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" value="'.$isi.'" class="input_rows1" size="7" />';
		// return $return;
	// }
	
	// function updateBox_product_trial_stress_test_ismikro($field, $id, $value, $rowData) {
		// //$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		// if($value=='0'|| $value==''){$isi="-";$value='0';}elseif($value=='3'){$isi="Tidak Diuji";}elseif($value=='2'){$isi="Berhasil";}elseif($value=='1'){$isi="Gagal";}
		// $return = '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		// $return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" value="'.$isi.'" class="input_rows1" size="12" />';
		// return $return;
	// }
	// function insertBox_product_trial_stress_test_ismikro($field, $id) {
		// $return = '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		// $return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="12" />';
		// return $return;
	// }

	function insertBox_product_trial_stress_test_iupb_id($field, $id) {
		$return = '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="7" />';
		return $return;
	}
	
	function updateBox_product_trial_stress_test_iupb_id($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
	
		$return = '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" value="'.$row['vupb_nomor'].'" class="input_rows1" size="7" />';
		return $return;
	}
	
	
	// function insertBox_product_trial_stress_test_ispekfg_id($field, $id) {
		// $return = '<script>
						// $( "button.icon_pop" ).button({
							// icons: {
								// primary: "ui-icon-newwin"
							// },
							// text: false
						// })
					// </script>';
		// $return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		// $return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" />';
		// $return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/spek/fg/list/trial/popup?field=product_trial_stress_test\',\'List Spesifikasi FG\')" type="button">&nbsp;</button>';
		
		// return $return;
	// }

	// function updateBox_product_trial_stress_test_ispekfg_id($field, $id, $value, $rowData) {
		// $row = $this->db_plc0->get_where('plc2.plc2_upb_spesifikasi_fg', array('ispekfg_id'=>$rowData['ispekfg_id']))->row_array();
		// /*$return = '<script>
						// $( "button.icon_pop" ).button({
							// icons: {
								// primary: "ui-icon-newwin"
							// },
							// text: false
						// })
					// </script>';*/
		// $return = '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		// $return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$row['vkode_surat'].'" />';
		// //$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/spek/fg/list/trial/popup?field=product_trial_stress_test\',\'List Spesifikasi FG\')" type="button">&nbsp;</button>';
		
		// return $return;
	// }
	
	function insertBox_product_trial_stress_test_vupb_nama($field, $id) {
		//$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1" size="50" />';
		return $return;
		//return '<input type="text" readonly name="'.$field.'" id="'.$id.'" class="input_rows1 required" size="50" />';
	}
	
	function updateBox_product_trial_stress_test_vupb_nama($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" value="'.$row['vupb_nama'].'" class="input_rows1" size="50" />';
		return $return;
	}
	
	function insertBox_product_trial_stress_test_vgenerik($field, $id) {
		return '<textarea disabled="TRUE" name="'.$id.'" id="'.$id.'"></textarea>';		
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="50" />';
	}

	function updateBox_product_trial_stress_test_vgenerik($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return '<textarea cols="50" disabled="TRUE" name="'.$id.'" id="'.$id.'">'.$row['vgenerik'].'</textarea>';
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" value="'.$row['vgenerik'].'" class="input_rows1" size="50" />';
		return $return;
	}
	
	function insertBox_product_trial_stress_test_iteampd_id($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="40" />';
	}
	
	function updateBox_product_trial_stress_test_iteampd_id($field, $id, $value, $rowData) {
		$sql = "SELECT t.vteam FROM plc2.plc2_upb u INNER JOIN plc2.plc2_upb_team t ON u.iteampd_id=t.iteam_id WHERE u.iupb_id='".$rowData['iupb_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		//$return = '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'"/>';
		$return= '<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" value="'.$row['vteam'].'" class="input_rows1 required" size="40" />';
		
		return $return;
	}
	
	function updateBox_product_trial_stress_test_vrevisi($field, $id, $value) {
		if($value=='')$value=0;
		//echo $value; exit;
		return '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" value="'.$value.'" class="input_rows1" />';
	}
	
	function insertBox_product_trial_stress_test_vnip_formulator($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	function updateBox_product_trial_stress_test_vnip_formulator($field, $id, $value, $rowData) {		 
		$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		$v = count($row) > 0 ? $row['cNip'].' - '.$row['vName'] : '' ;
		/*$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';*/
		//$return .= '<input type="hidden" value="'.$value.'" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />';
		$return = '<input type="text" value="'.$v.'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" size="40" class="" />';
		//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function insertBox_product_trial_stress_test_vnip_pic_skimiawi($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test&col='.$field.'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	function updateBox_product_trial_stress_test_vnip_pic_skimiawi($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		$v = count($row) > 0 ? $row['cNip'].' - '.$row['vName'] : '' ;
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="input_rows1" />';
		$return .= '<input type="text" value="'.$v.'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test&col='.$field.'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function insertBox_product_trial_stress_test_vnip_pic_sdisolusi($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test&col='.$field.'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	function updateBox_product_trial_stress_test_vnip_pic_sdisolusi($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		$v = count($row) > 0 ? $row['cNip'].' - '.$row['vName'] : '' ;
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="input_rows1" />';
		$return .= '<input type="text" value="'.$v.'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test&col='.$field.'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function insertBox_product_trial_stress_test_vnip_pic_smikro($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test&col='.$field.'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	function updateBox_product_trial_stress_test_vnip_pic_smikro($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		$v = count($row) > 0 ? $row['cNip'].' - '.$row['vName'] : '' ;
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="input_rows1" />';
		$return .= '<input type="text" value="'.$v.'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test&col='.$field.'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	// function insertPost_product_trial_stress_test_filename($value, $name, $post) {
		// $new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		// return $new_name;
	// }	
	// function updatePost_product_trial_stress_test_filename($value, $name, $post) {
		// $new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		// return $new_name;
	// }

	// function insertPost_product_trial_stress_test_vhasil_kimiawi($value, $name, $post) {
		// $new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		// return $new_name;
	// }	
	// function updatePost_product_trial_stress_test_vhasil_kimiawi($value, $name, $post) {
		// $new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		// return $new_name;
	// }
	
	// function insertPost_product_trial_stress_test_vhasil_disolusi($value, $name, $post) {
		// $new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		// return $new_name;
	// }	
	// function updatePost_product_trial_stress_test_vhasil_disolusi($value, $name, $post) {
		// $new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		// return $new_name;
	// }
	
	// function insertPost_product_trial_stress_test_vhasil_mikro($value, $name, $post) {
		// $new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		// return $new_name;
	// }	
	// function updatePost_product_trial_stress_test_vhasil_mikro($value, $name, $post) {
		// $new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		// return $new_name;
	// }

	function updateBox_product_trial_stress_test_tstart_stress($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl input_rows1 datepicker" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}

	function updateBox_product_trial_stress_test_tend_stress($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl input_rows1 datepicker" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}

	function updateBox_product_trial_stress_test_tupload_stress($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl input_rows1 datepicker" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	
	function updateBox_product_trial_stress_test_tberlaku($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="hidden" class="input_tgl input_rows1 required" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		$return .= '<input type="text" disabled="TRUE" class="input_tgl input_rows1 required" name="'.$field.'_dis" value="'.$val.'" id="'.$id.'_dis">';
		return $return;
	}	
	function updateBox_product_trial_stress_test_tstart_skimiawi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_tend_skimiawi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_thasil_skimiawi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_tstart_sdisolusi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_tend_sdisolusi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_thasil_sdisolusi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_tstart_smikro($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_tend_smikro($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_thasil_smikro($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_thasil_ilab($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_tnote($field, $id, $value) {
		$return='<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'">';
		$return.='<textarea name="'.$id.'" id="'.$id.'" disabled="TRUE">'.$value.'</textarea>';
		return $return;
	}
	function updateBox_product_trial_stress_test_tstress_note($field, $id, $value) {
		$return='<textarea name="'.$id.'" id="'.$id.'" >'.$value.'</textarea>';
		return $return;
	}
	function updateBox_product_trial_stress_test_tmikros_note($field, $id, $value) {
		$return='<textarea name="'.$id.'" id="'.$id.'" >'.$value.'</textarea>';
		return $return;
	}function updateBox_product_trial_stress_test_tkimias_note($field, $id, $value) {
		$return='<textarea name="'.$id.'" id="'.$id.'">'.$value.'</textarea>';
		return $return;
	}
	function insertBox_product_trial_stress_test_filename($field, $id) {
		$data['mydept'] = $this->auth->my_depts(TRUE);				
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('product_trial_formula_stress_test_file',$data,TRUE);
	}
	function updateBox_product_trial_stress_test_filename($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE);				
		$idfor = $rowData['ifor_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_skala_trial_filename', array('ifor_id'=>$idfor))->result_array();
		//$sql = "select * from plc2.plc2_upb_file_skala_trial_filename where ifor_id = '".$idfor."'";
		//$a = $this->db_plc0->query($sql)->result_array();
		//echo $sql;
		//print_r($a);
		//echo $rowData['ifor_id'];
		//echo $sql;
		//exit;
		return $this->load->view('product_trial_formula_stress_test_file',$data,TRUE);
	}
	
	/*function updateBox_product_trial_stress_test_filename($field, $id, $value, $rowData) {
		//$input = '<input type="file" name="'.$field.'" id="'.$id.'" class="" size="50" />';
		$input = '';
		if($value != '') {
			if (file_exists('./files/plc/product_trial/formula_trial/'.$value)) {
				$link = base_url().'processor/plc/product/trial/formula/skala/trial?action=download&file='.$value;
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
	
	//fungsi download untuk semua
	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/product_trial/stress_test/'.$tempat.'/'.$id.'/'.$name);	
		force_download($name, $path);
	}
	
	function download1($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/product_trial/skala_trial/'.$tempat.'/'.$id.'/'.$name);	
		force_download($name, $path);
	}
	//sampai sini fungsi donloadnya
	
	function insertBox_product_trial_stress_test_vhasil_skimiawi($field, $id) {
		$data['mydept'] = $this->auth->my_depts(TRUE);		
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('product_trial_formula_stress_test_file1',$data,TRUE);
	}
	
	function updateBox_product_trial_stress_test_vhasil_skimiawi($field, $id, $value, $rowData) {
		/*$input = '<input type="file" name="'.$id.'" id="'.$id.'" class="" size="50" />';
		if($value != '') {
			if (file_exists('./files/plc/product_trial/formula_trial/'.$value)) {
				$link = base_url().'processor/plc/product/trial/formula/skala/trial?action=download&file='.$value;
				$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			}
			else {
				$linknya = 'File sudah tidak ada!';
			}
			return 'File name : '.$value.' ['.$linknya.']<br />'.$input;
		}
		else {
			return 'No File<br />'.$input;
		}*/
		$data['mydept'] = $this->auth->my_depts(TRUE);
		$idfor = $rowData['ifor_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_stress_test_kimiawi', array('ifor_id'=>$idfor))->result_array();
		return $this->load->view('product_trial_formula_stress_test_file1',$data,TRUE);		
	}
	
	function insertBox_product_trial_stress_test_vhasil_sdisolusi($field, $id) {
		$data['mydept'] = $this->auth->my_depts(TRUE);	
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('product_trial_formula_stress_test_file2',$data,TRUE);
	}
	
	function updateBox_product_trial_stress_test_vhasil_sdisolusi($field, $id, $value, $rowData) {
		/*$input = '<input type="file" name="'.$id.'" id="'.$id.'" class="" size="50" />';
		if($value != '') {
			if (file_exists('./files/plc/product_trial/formula_trial/'.$value)) {
				$link = base_url().'processor/plc/product/trial/formula/skala/trial?action=download&file='.$value;
				$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			}
			else {
				$linknya = 'File sudah tidak ada!';
			}
			return 'File name : '.$value.' ['.$linknya.']<br />'.$input;
		}
		else {
			return 'No File<br />'.$input;
		}*/
		$data['mydept'] = $this->auth->my_depts(TRUE);
		$idfor = $rowData['ifor_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_stress_test_disolusi', array('ifor_id'=>$idfor))->result_array();
		return $this->load->view('product_trial_formula_stress_test_file2',$data,TRUE);			
	}
	
	function insertBox_product_trial_stress_test_vhasil_smikro($field, $id) {
		$data['mydept'] = $this->auth->my_depts(TRUE);	
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('product_trial_formula_stress_test_file3',$data,TRUE);
	}
	
	function updateBox_product_trial_stress_test_vhasil_smikro($field, $id, $value, $rowData) {
		/*$input = '<input type="file" name="'.$id.'" id="'.$id.'" class="" size="50" />';
		if($value != '') {
			if (file_exists('./files/plc/product_trial/formula_trial/'.$value)) {
				$link = base_url().'processor/plc/product/trial/formula/skala/trial?action=download&file='.$value;
				$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			}
			else {
				$linknya = 'File sudah tidak ada!';
			}
			return 'File name : '.$value.' ['.$linknya.']<br />'.$input;
		}
		else {
			return 'No File<br />'.$input;
		}*/
		$data['mydept'] = $this->auth->my_depts(TRUE);
		$idfor = $rowData['ifor_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_stress_test_mikrobiologi', array('ifor_id'=>$idfor))->result_array();
		return $this->load->view('product_trial_formula_stress_test_file3',$data,TRUE);		
	}
	
	function before_update_processor($row, $postData) {
		$this->load->helper('to_mysql');
		
		$skrg = date('Y-m-d H:i:s');
		unset($postData['vupb_nama']);
		unset($postData['vgenerik']);
		unset($postData['iteampd_id']);
		unset($postData['vrevisi']);
		unset($postData['filename']);
	
		//$postData['tupdate'] = $skrg;
		$postData['tberlaku'] = to_mysql($postData['tberlaku']);
		$postData['tstart_skimiawi'] = to_mysql($postData['tstart_skimiawi']);
		$postData['tend_skimiawi'] = to_mysql($postData['tend_skimiawi']);
		$postData['thasil_skimiawi'] = to_mysql($postData['thasil_skimiawi']);
		$postData['tstart_sdisolusi'] = to_mysql($postData['tstart_sdisolusi']);
		$postData['tend_sdisolusi'] = to_mysql($postData['tend_sdisolusi']);
		$postData['thasil_sdisolusi'] = to_mysql($postData['thasil_sdisolusi']);
		$postData['tstart_smikro'] = to_mysql($postData['tstart_smikro']);
		$postData['tend_smikro'] = to_mysql($postData['tend_smikro']);
		$postData['thasil_smikro'] = to_mysql($postData['thasil_smikro']);
		//$postData['thasil_istress'] = to_mysql($postData['thasil_istress']);
		$postData['tstart_stress'] = to_mysql($postData['tstart_stress']);
		$postData['tend_stress'] = to_mysql($postData['tend_stress']);
		$postData['tupload_stress'] = to_mysql($postData['tupload_stress']);
		$postData['thasil_ilab'] = to_mysql($postData['thasil_ilab']);
		 // print_r($postData);
		 // exit();
		 
		return $postData;
	}
	
	function after_update_processor($row, $updateId, $postData) {
		$getbp=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
		$bizsup=$getbp['idplc2_biz_process_sub'];
		$hacek=$this->biz_process->cek_last_status($postData['iupb_id'],$bizsup,7);
		if($hacek==1){ // jika sudah pernah ada data maka update saja
			//insert log
				$this->biz_process->insert_log($postData['iupb_id'], $bizsup, 7); // status 7 => submit
			//update last log
				$this->biz_process->update_last_log($postData['iupb_id'], $bizsup, 7);
		}
		elseif($hacek==0){
			//insert log
				$this->biz_process->insert_log($postData['iupb_id'], $bizsup, 7); // status 7 => submit
			//insert last log
				$this->biz_process->insert_last_log($postData['iupb_id'], $bizsup, 7);
		}
		$skrg = date('Y-m-d H:i:s');
		$sql = "Update plc2.plc2_upb_formula set tUpdate = '".$skrg."' where ifor_id='".$updateId."'";	
	//echo $sql;	
		$this->db_plc0->query($sql);
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
			
			foreach($list_dir as $v) {				
				if (!in_array($v, $file_name)) {				
					unlink($path.'/'.$v);	
				}			
			}
			foreach($list_sql as $v) {
				if (!in_array($v, $file_name)) {				
					$del = "delete from plc2.".$table." where ifor_id = {$lastId} and filename= '{$v}'";
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
			$sql = "SELECT filename from plc2.".$table." where ifor_id=".$lastId;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['filename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT filename from plc2.".$table." where ifor_id=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM plc2.".$table." where ifor_id=".$lastId." and filename='".$row['filename']."'";			
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
