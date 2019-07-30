<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_trial_formula_skala_lab extends MX_Controller {
		var $url;
		var $dbset;
	function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->load->library('biz_process');
        $this->load->library('lib_utilitas');
		$this->user = $this->auth->user(); 
		$this->url = 'product_trial_formula_skala_lab';
		$this->dbset = $this->load->database('plc', true);
		
    }
    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle('Formula Skala Lab');		
		$grid->setTable('plc2.plc2_upb_formula');		
		$grid->setUrl('product_trial_formula_skala_lab');
		//$grid->addList('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','ilabkimiawi','ilabdisolusi','ilabmikro','plc2_upb.iteampd_id','ilab_apppd');
		$grid->addList('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','istab','ilab_apppd');
		$grid->setSortBy('tupdate');
		$grid->setSortOrder('DESC');
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '100');
		$grid->setWidth('plc2_upb.iteampd_id', '150');
		$grid->setWidth('plc2_upb.vupb_nama', '250');
		$grid->setWidth('vgenerik', '250');
		$grid->setWidth('idisolusi', '75');
		$grid->setWidth('ikimiawi', '75');
		$grid->setWidth('imikro', '75');
		$grid->setWidth('istress', '75');
		$grid->addFields('vkode_surat','iupb_id','vupb_nama','vgenerik','iteampd_id','tberlaku','filename','vrevisi','vnip_formulator');
		$grid->addFields('tstart_labkimiawi','tend_labkimiawi','vnip_pic_labkimiawi','vhasil_labkimiawi','ilabkimiawi','thasil_labkimiawi');
		$grid->addFields('tstart_labdisolusi','tend_labdisolusi','vnip_pic_labdisolusi','vhasil_labdisolusi','ilabdisolusi','thasil_labdisolusi');
		$grid->addFields('tstart_labmikro','tend_labmikro','vnip_pic_labmikro','vhasil_labmikro','ilabmikro','thasil_labmikro');
		$grid->addFields('istab','thasil_istab','tnote','vlab_nip_apppd');
		$grid->setRequired('istab','iwithstabilita');
		
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('plc2_upb.iteampd_id', 'Team PD');
		$grid->setLabel('vkode_surat', 'No. Formulasi');
		//$grid->setLabel('ispekfg_id', 'No. Spek FG');
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('iteampd_id', 'Team PD');		
		$grid->setLabel('tberlaku', 'Tanggal berlaku');
		$grid->setLabel('filename', 'Nama File');
		$grid->setLabel('vrevisi', 'Revisi');
		$grid->setLabel('vnip_formulator', 'Formulator');
		$grid->setLabel('tstart_labkimiawi', 'Tgl. Mulai Analisa Kimiawi');
		$grid->setLabel('tend_labkimiawi', 'Tgl. Selesai Analisa Kimiawi');
		$grid->setLabel('vnip_pic_labkimiawi', 'PIC Analisa Kimiawi');
		$grid->setLabel('vhasil_labkimiawi', 'Hasil Analisa Kimiawi');
		$grid->setLabel('ikimiawi', 'Kesimpulan Analisa Kimiawi');
		$grid->setLabel('thasil_labkimiawi', 'Tgl. Kesimpulan Analisa Kimiawi');
		$grid->setLabel('tstart_labdisolusi', 'Tgl. Mulai Uji Disolusi');
		$grid->setLabel('tend_labdisolusi', 'Tgl. Selesai Uji Disolusi');
		$grid->setLabel('vnip_pic_labdisolusi', 'PIC Uji Disolusi');
		$grid->setLabel('vhasil_labdisolusi', 'Hasil Uji Disolusi');
		$grid->setLabel('idisolusi', 'Kesimpulan Uji Disolusi');
		$grid->setLabel('thasil_labdisolusi', 'Tgl. Kesimpulan Uji Disolusi');
		$grid->setLabel('tstart_labmikro', 'Tgl. Mulai Uji Mikrobiologi');
		$grid->setLabel('tend_labmikro', 'Tgl. Selesai Uji Mikrobiologi');
		$grid->setLabel('vnip_pic_labmikro', 'PIC Uji Mikrobiologi');
		$grid->setLabel('vhasil_labmikro', 'Hasil Uji Mikrobiologi');
		$grid->setLabel('imikro', 'Kesimpulan Uji Mikrobiologi');
		$grid->setLabel('thasil_labmikro', 'Tgl. Kesimpulan Uji Mikrobiologi');
		$grid->setLabel('istab', 'Hasil Skala Lab');
		$grid->setLabel('istress', 'Hasil Skala Lab');
		$grid->setLabel('thasil_istab', 'Tgl. Hasil Skala Lab');
		$grid->setLabel('iwithstabilita', 'Lanjut Ke');
		$grid->setLabel('tnote', 'Catatan');
		$grid->setLabel('vlab_nip_apppd', 'PD Approval');
		$grid->setLabel('ilab_apppd', 'PD Approval');
		
		$grid->setFormWidth('vrevisi',5);
		$grid->setFormWidth('vkode_surat',20);
		$grid->setFormWidth('ismikro',25);
		
		$grid->setLabel('ilabkimiawi', 'Analisa Kimiawi');
		$grid->setLabel('ilabdisolusi', 'Uji Disolusi');		
		$grid->setLabel('ilabmikro', 'Uji Mikrobiologi');
		$grid->setLabel('istress', 'Stress Test');
		//$grid->setQuery('ihold', 0);
		$grid->setQuery('plc2_upb_formula.ldeleted', 0);
		$grid->setQuery('plc2_upb.ihold', 0);
		$grid->setQuery('plc2_upb_formula.ilab <> 1', null); //yg hasil stress nya tidak gagal
		$grid->setQuery('plc2_upb_formula.iformula_apppd = 2', null); //yg formula skala trial approve PD
		$grid->setQuery('plc2_upb_formula.ifor_id in (select fo.ifor_id from plc2.plc2_upb_formula fo
				 where 
				 (case when fo.iwithstress=1 then #Cek Melewati StresTest
				 		(case when fo.iKeSkala_lab=1 then
					 	fo.istress_apppd=2
					 else
						 (case when fo.iwithbb=1 and fo.iwithori=1 then 
						 fo.iupb_id in (select req.iupb_id from plc2.plc2_upb_ro_detail rod
						 inner join plc2.plc2_upb_ro ro on rod.iro_id=ro.iro_id
						 inner join plc2.plc2_upb_request_sample req on req.ireq_id=rod.ireq_id
						 where rod.vwadah is not NULL and rod.vrec_jum_pd is not null)
						 AND fo.iupb_id in (select ori.iupb_id from plc2.plc2_upb_request_originator ori where ori.iapppd=2 and
						 ori.isent_status=1)
						 when fo.iwithbb=1 and fo.iwithori=0 then
						 fo.iupb_id in (select req.iupb_id from plc2.plc2_upb_ro_detail rod
						 inner join plc2.plc2_upb_ro ro on rod.iro_id=ro.iro_id
						 inner join plc2.plc2_upb_request_sample req on req.ireq_id=rod.ireq_id
						 where rod.vwadah is not NULL and rod.vrec_jum_pd is not null)
						 when fo.iwithbb=0 and fo.iwithori=1 then
						 fo.iupb_id in (select ori.iupb_id from plc2.plc2_upb_request_originator ori where ori.iapppd=2 and ori
						.isent_status=1)
						 end)
					 END)
				 	else
				 	fo.iformula_apppd=2
				 END))',NULL);
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

		
		$grid->setFormUpload(TRUE);
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id', 'LEFT');
		$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));
		//$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner');
		//$grid->changeFieldType('iwithstabilita','combobox','',array(0=>'Best Formula',1=>'Stabilita Lab'));
		$grid->changeFieldType('ilabkimiawi','combobox','',array(null=>'-',0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('ikimiawi','combobox','',array(null=>'-',0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('idisolusi','combobox','',array(null=>'-',0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('ilabdisolusi','combobox','',array(null=>'-',0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('imikro','combobox','',array(null=>'-',0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('ilabmikro','combobox','',array(null=>'-',0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('istress','combobox','',array(null=>'-',0=>'-',4=>'Diskontinu',3=>'Kontinu', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('istab','combobox','',array(0=>'-', 2=>'Berhasil', 1=>'Gagal'));
		//$grid->changeFieldType('ilab_apppd','combobox','',array(null=>'-',0=>'Waiting For Approval', 2=>'Approved', 1=>'Reject'));
		
		//$grid->setSearch('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','ikimiawi','idisolusi','imikro','istress','plc2_upb.iteampd_id');
		$grid->setSearch('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','ilab_apppd');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;	
			case 'upwith':
				$post=$this->input->post();
				$get=$this->input->get();
				$data['iwithstabilita']=$post['iwith'];
				$this->dbset->where('ifor_id',$post['ifor']);
				$this->dbset->update('plc2.plc2_upb_formula',$data);
				$r['company_id'] = $get['company_id'];
				$r['group_id'] = $get['group_id'];
				$r['modul_id'] = $get['modul_id'];
				$r['message'] = "Data Berhasil di Update";
				$r['last_id'] =$post['ifor'];
				echo json_encode($r);
				exit();
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
					$path = realpath("files/plc/product_trial/skala_lab/filename");
					$path2 = realpath("files/plc/product_trial/skala_lab/disolusi");
					$path1 = realpath("files/plc/product_trial/skala_lab/kimiawi");
					$path3 = realpath("files/plc/product_trial/skala_lab/mikrobiologi");
					
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
								$sql[] = "INSERT INTO plc2_upb_file_skala_lab_filename(ifor_id, filename, dInsertDate, keterangan,cInsert) 
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
								$sql1[] = "INSERT INTO plc2_upb_file_skala_lab_kimiawi(ifor_id, filename, dInsertDate, keterangan,cInsert) 
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
								$sql2[] = "INSERT INTO plc2_upb_file_skala_lab_disolusi(ifor_id, filename, dInsertDate, keterangan,cInsert) 
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
								$sql3[] = "INSERT INTO plc2_upb_file_skala_lab_mikrobiologi(ifor_id, filename, dInsertDate, keterangan,cInsert) 
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
				$post=$this->input->post();
				$ifor_id=$post['product_trial_formula_skala_lab_ifor_id'];
				$path = realpath("files/plc/product_trial/skala_lab/filename");
				if(!file_exists($path."/".$ifor_id)){
					if (!mkdir($path."/".$ifor_id, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
				$path_hak = realpath("files/plc/product_trial/skala_lab/kimiawi");
				if(!file_exists($path_hak."/".$ifor_id)){
					if (!mkdir($path_hak."/".$ifor_id, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
				$path_hud = realpath("files/plc/product_trial/skala_lab/disolusi");
				if(!file_exists($path_hud."/".$ifor_id)){
					if (!mkdir($path_hud."/".$ifor_id, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
				$path_hum = realpath("files/plc/product_trial/skala_lab/mikrobiologi");
				if(!file_exists($path_hum."/".$ifor_id)){
					if (!mkdir($path_hum."/".$ifor_id, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
									
				$fileketerangan_slff = array();	
				$fileketerangan_hak = array();	
				$fileketerangan_hud = array();	
				$fileketerangan_hum = array();	

   				if($isUpload) {	
   					$fileid_slff='';
   					foreach($_POST as $key=>$value) {
											
						if ($key == 'fileketerangan_slff') {
							foreach($value as $y=>$u) {
								$fileketerangan_slff[$y] = $u;
							}
						}
						if ($key == 'namafile_slff') {
							foreach($value as $k=>$v) {
								$namafile_slff[$k] = $v;
							}
						}
						if ($key == 'fileid_slff') {
							$i=0;
							foreach($value as $k=>$v) {
								if(($v<>'') or ($v<>NULL)){
									if($i==0){
										$fileid_slff .= "'".$v."'";
									}else{
										$fileid_slff .= ",'".$v."'";
									}
								}
								$i++;
							}
						}
					}
					
					if (isset($_FILES['fileupload_slff']))  {

						$i=0;
						foreach ($_FILES['fileupload_slff']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_slff']["tmp_name"][$key];
								$name =$_FILES['fileupload_slff']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$ifor_id."/".$name)) {
									$sql_slff[] = "INSERT INTO plc2_upb_file_skala_lab_filename(ifor_id, filename, dInsertDate, keterangan,cInsert) 
											VALUES (".$ifor_id.",'".$data['filename']."','".$data['dInsertDate']."','".$fileketerangan_slff[$i]."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sql_slff as $qf) {
							try {
								$this->dbset->query($qf);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}

					

					//Upload Hasil Analisa Kimiawi
					$fileid_hak='';
   					foreach($_POST as $key=>$value) {
											
						if ($key == 'fileketerangan_hak') {
							foreach($value as $y=>$u) {
								$fileketerangan_hak[$y] = $u;
							}
						}
						if ($key == 'namafile_hak') {
							foreach($value as $k=>$v) {
								$namafile_hak[$k] = $v;
							}
						}
						if ($key == 'fileid_hak') {
							$i=0;
							foreach($value as $k=>$v) {
								if(($v<>'') or ($v<>NULL)){
									if($i==0){
										$fileid_hak .= "'".$v."'";
									}else{
										$fileid_hak .= ",'".$v."'";
									}
								}
								$i++;
							}
						}
					}
					
					if (isset($_FILES['fileupload_hak']))  {

						$i=0;
						foreach ($_FILES['fileupload_hak']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_hak']["tmp_name"][$key];
								$name =$_FILES['fileupload_hak']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path_hak."/".$ifor_id."/".$name)) {
									$sql_hak[] = "INSERT INTO plc2_upb_file_skala_lab_kimiawi(ifor_id, filename, dInsertDate, keterangan,cInsert)
											VALUES (".$ifor_id.",'".$data['filename']."','".$data['dInsertDate']."','".$fileketerangan_hak[$i]."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sql_hak as $qh) {
							try {
								$this->dbset->query($qh);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}

					//
					$fileid_hud='';
   					foreach($_POST as $key=>$value) {
											
						if ($key == 'fileketerangan_hud') {
							foreach($value as $y=>$u) {
								$fileketerangan_hud[$y] = $u;
							}
						}
						if ($key == 'namafile_hud') {
							foreach($value as $k=>$v) {
								$namafile_hud[$k] = $v;
							}
						}
						if ($key == 'fileid_hud') {
							$i=0;
							foreach($value as $k=>$v) {
								if(($v<>'') or ($v<>NULL)){
									if($i==0){
										$fileid_hud .= "'".$v."'";
									}else{
										$fileid_hud .= ",'".$v."'";
									}
								}
								$i++;
							}
						}
					}
					
					if (isset($_FILES['fileupload_hud']))  {

						$i=0;
						foreach ($_FILES['fileupload_hud']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_hud']["tmp_name"][$key];
								$name =$_FILES['fileupload_hud']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path_hud."/".$ifor_id."/".$name)) {
									$sql_hud[] = "INSERT INTO plc2_upb_file_skala_lab_disolusi(ifor_id, filename, dInsertDate, keterangan,cInsert)
											VALUES (".$ifor_id.",'".$data['filename']."','".$data['dInsertDate']."','".$fileketerangan_hud[$i]."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sql_hud as $qhd) {
							try {
								$this->dbset->query($qhd);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}

					//
					$fileid_hum='';
   					foreach($_POST as $key=>$value) {
											
						if ($key == 'fileketerangan_hum') {
							foreach($value as $y=>$u) {
								$fileketerangan_hum[$y] = $u;
							}
						}
						if ($key == 'namafile_hum') {
							foreach($value as $k=>$v) {
								$namafile_hum[$k] = $v;
							}
						}
						if ($key == 'fileid_hum') {
							$i=0;
							foreach($value as $k=>$v) {
								if(($v<>'') or ($v<>NULL)){
									if($i==0){
										$fileid_hum .= "'".$v."'";
									}else{
										$fileid_hum .= ",'".$v."'";
									}
								}
								$i++;
							}
						}
					}
					
					if (isset($_FILES['fileupload_hum']))  {

						$i=0;
						foreach ($_FILES['fileupload_hum']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_hum']["tmp_name"][$key];
								$name =$_FILES['fileupload_hum']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path_hum."/".$ifor_id."/".$name)) {
									$sql_hum[] = "INSERT INTO plc2_upb_file_skala_lab_mikrobiologi(ifor_id, filename, dInsertDate, keterangan,cInsert)
											VALUES (".$ifor_id.",'".$data['filename']."','".$data['dInsertDate']."','".$fileketerangan_hum[$i]."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sql_hum as $qhd) {
							try {
								$this->dbset->query($qhd);
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
					$fileid_slff='';
					foreach($_POST as $key=>$value) {
						if ($key == 'fileid_slff') {
							$i=0;
							foreach($value as $k=>$v) {
								if(($v<>'') or ($v<>NULL)){
									if($i==0){
										$fileid_slff .= "'".$v."'";
									}else{
										$fileid_slff .= ",'".$v."'";
									}
									$i++;
								}
							}
						}
					}
					if($fileid_slff!=''){
						$tgl= date('Y-m-d H:i:s');
						$sql1="update plc2.plc2_upb_file_skala_lab_filename set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$ifor_id."' and id not in (".$fileid_slff.")";
						$this->dbset->query($sql1);
					}
					$fileid_hak='';
					foreach($_POST as $key=>$value) {
						if ($key == 'fileid_hak') {
							$i=0;
							foreach($value as $k=>$v) {
								if(($v<>'') or ($v<>NULL)){
									if($i==0){
										$fileid_hak .= "'".$v."'";
									}else{
										$fileid_hak .= ",'".$v."'";
									}
									$i++;
								}
							}
						}
					}
					if($fileid_hak!=''){
						$tgl= date('Y-m-d H:i:s');
						$sql2="update plc2.plc2_upb_file_skala_lab_kimiawi set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$ifor_id."' and id not in (".$fileid_hak.")";
						$this->dbset->query($sql2);
					}
					$fileid_hud='';
					foreach($_POST as $key=>$value) {
						if ($key == 'fileid_hud') {
							$i=0;
							foreach($value as $k=>$v) {
								if(($v<>'') or ($v<>NULL)){
									if($i==0){
										$fileid_hud .= "'".$v."'";
									}else{
										$fileid_hud .= ",'".$v."'";
									}
									$i++;
								}
							}
						}
					}
					if($fileid_hud!=''){
						$tgl= date('Y-m-d H:i:s');
						$sql3="update plc2.plc2_upb_file_skala_lab_disolusi set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$ifor_id."' and id not in (".$fileid_hud.")";
						$this->dbset->query($sql3);
					}
					$fileid_hum='';
					foreach($_POST as $key=>$value) {
						if ($key == 'fileid_hum') {
							$i=0;
							foreach($value as $k=>$v) {
								if(($v<>'') or ($v<>NULL)){
									if($i==0){
										$fileid_hum .= "'".$v."'";
									}else{
										$fileid_hum .= ",'".$v."'";
									}
									$i++;
								}
							}
						}
					}
					if($fileid_hum!=''){
						$tgl= date('Y-m-d H:i:s');
						$sql4="update plc2.plc2_upb_file_skala_lab_mikrobiologi set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$ifor_id."' and id not in (".$fileid_hum.")";
						$this->dbset->query($sql4);
					}
					
					echo $grid->updated_form();
				}
				break;
			case 'detail':
				$this->detail();
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
			case 'download':
				$this->download($this->input->get('file'));
			break;
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();
				
				if($this->auth->is_manager()){
					$x=$this->auth->dept();
					$manager=$x['manager'];
					if(in_array('QC', $manager)){
						$type='QC';
					}
					elseif(in_array('QA', $manager)){
						$type='QA';
					}
					elseif(in_array('PD', $manager)){
						$type='PD';
					}
					else{$type='';}
				}

				$this->db_plc0->where('ifor_id', $get['ifor_id']);
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove = $type == 'PD' ? 'ilab_apppd' : '';
				$this->db_plc0->update('plc2.plc2_upb_formula', array($iapprove=>2,'vlab_nip_apppd'=>$nip,'tlab_apppd'=>$skg));
		    
		    	//jika ada satu saja spek fg dari upb tsb blm di app/ reject maka isoiqc / ispekqa = 1
		    	$upbid=$post['iupb_id'];	
				
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
		        $subject="Proses Formula Skala Lab Selesai: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada approval oleh PD Manager pada proses Formula Skala Lab(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
		                                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>Approve KSK - Input data oleh PD/AD/Purchasing/QA</td>
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

	/*function listBox_spesifikasi_fg_tentative_vgenerik($value) {
		return '<ul><li><a href="http://google.com" target="_blank">test</a></li></ul>';
	}*/
	function manipulate_update_button($buttons, $rowData) {
    	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			//echo "<pre>";print_r($rowData);echo "</pre>"; exit();
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
		// cek status upb, klao upb 
			unset($buttons['update_back']);
    		unset($buttons['update']);
			
			//echo $this->auth->my_teams();
			
    		$upb_id=$rowData['iupb_id'];
			$imikro_id=$rowData['ifor_id'];
			$qcek="select f.ilab_apppd, f.istab, f.iwithstabilita from plc2.plc2_upb_formula f where f.ifor_id=$imikro_id";
			$rcek = $this->db_plc0->query($qcek)->row_array();
			$js=$this->load->view('misc_util',array('className'=> 'product_trial_formula_skala_lab'), true);
			$js .= $this->load->view('product_trial_formula_skala_lab_js');

			$cNip=$this->user->gNIP;
			$sql= "select * from plc2.plc2_upb up where up.iupb_id=".$rowData['iupb_id'];
			$dt=$this->dbset->query($sql)->row_array();
			$setuju = '<button onclick="javascript:setuju(\'product_trial_formula_skala_lab\', \''.base_url().'processor/plc/product/trial/formula/skala/lab?action=confirm&last_id='.$this->input->get('id').'&ifor_id='.$rowData['ifor_id'].'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Confirm</button>';
			

			$update = '<button onclick="javascript:update_btn_back(\'product_trial_formula_skala_lab\', \''.base_url().'processor/plc/product/trial/formula/skala/lab?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
			$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/formula/skala/lab?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Approve</button>';
			$x=$this->auth->my_teams();
			if($this->auth->is_manager()){
				if(($type=='PD')&&($rcek['ilab_apppd']==0)&&($rcek['istab']==0)){
					$buttons['update'] = $update.$js;
				}
				if(($type=='PD')&&($rcek['ilab_apppd']==0)&&($rcek['istab']==1)){
					$buttons['update'] = $update.$setuju.$js;
				}
				if(($type=='PD')&&($rcek['ilab_apppd']==0)&&($rcek['istab']==2)){
					$buttons['update'] = $update.$setuju.$js;
				}else{}
			}
			//jika bukan manager PD, tapi staff PD, QA, QC atau formulator
			else{
				if((($type=='QA')&&($rcek['ilab_apppd']==0)) || (($type=='QC')&&($rcek['ilab_apppd']==0)) || (($type=='PD')&&($rcek['ilab_apppd']==0)) || ($rowData['vnip_formulator']==$this->user->gNIP)){
					$buttons['update'] = $update.$js;
				}
			}
		}
   
    	return $buttons;
    }
    public function listBox_Action($row, $actions) {
    	//cek apakah ada soi mikro upb itu yg statusnya sudah Final, 
		//print_r($row); exit;
		$iupbid=$row->iupb_id;
    	/*Ketika iWithstress=1, maka istressapp=1 baru muncul edit di skala lab
			ketika iWithstress=0, maka iStressapp tak perlu di cek*/
		/*if(($row->iwithstress==1)&&(($row->istress_apppd<>2)||($row->istress_apppd==null))){
			unset($actions['edit']);
			unset($actions['delete']);
		}
		else*/if($row->ilab_apppd<>0){
				unset($actions['edit']);
				unset($actions['delete']);
		}
		//formulator
		// if($row->vnip_formulator==$this->user->gNIP){
			// unset($actions['delete']);
		// }
		// jika formula skala lab sudah di app tidak bisa di edit
		
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
								var url = "'.base_url().'processor/plc/product/trial/formula/skala/lab";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_product_trial_formula_skala_lab").html(data);
									});
					
								}
									reload_grid("grid_product_trial_formula_skala_lab");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_product_trial_formula_skala_lab_approve" action="'.base_url().'processor/plc/product/trial/formula/skala/lab?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : <input type="hidden" name="ifor_id" value="'.$this->input->get('ifor_id').'" />
    			<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
    			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_product_trial_formula_skala_lab_approve\')">Approve</button>';
    		
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
		$iapprove = $post['type'] == 'PD' ? 'ilab_apppd' : '';
		$this->db_plc0->update('plc2.plc2_upb_formula', array($iapprove=>2,'vlab_nip_apppd'=>$nip,'tlab_apppd'=>$skg));
    
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
        $subject="Proses Formula Skala Lab Selesai: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval oleh PD Manager pada proses Formula Skala Lab(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
                                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>Approve KSK - Input data oleh PD/AD/Purchasing/QA</td>
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
    
    function updateBox_product_trial_formula_skala_lab_iwithstabilita($field, $id, $value, $rowData){
		if($rowData['ilab_apppd']==0){
			$return ="<select id='".$id."' name='".$id."' class='combobox required'>";
			$return .="<option value=''>---Pilih---</option>";
			$return .="</select>";
			$return .='<script type="text/javascript">
					$("#product_trial_formula_skala_lab_iwithstabilita").parent().parent().hide();
					$("#product_trial_formula_skala_lab_iwithstabilita").removeClass("required");
				</script>';
		}else{
			$vi=array(1=>'Stabilita Lab', 0=>'Best Formula');
			$return ="<select id='".$id."' name='".$id."' class='combobox required'>";
			
			if($value!=''){
				$return .= "<option value='".$value."'>".$vi[$value]."</option>";
			}else{
				$return .="<option value=''>---Pilih---</option>";
			}
			for ($i=0; $i <=1 ; $i++) { 
				//if($i<>$value){
					$return .= "<option value='".$i."'>".$vi[$i]."</option>";
				//}
			}
			$return .="</select>"	;
		}
		return $return;
	}

    function reject_view() {
    	$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	 return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/product/trial/formula/skala/lab";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_product_trial_formula_skala_lab").html(data);
									});
					
								}
									reload_grid("grid_product_trial_formula_skala_lab");
							}
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_product_trial_formula_skala_lab_reject" action="'.base_url().'processor/plc/product/trial/formula/skala/lab?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
    			<input type="hidden" name="ifor_id" value="'.$this->input->get('ifor_id').'" />
    			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
    			<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea><button type="button" onclick="submit_ajax(\'form_product_trial_formula_skala_lab_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process () {
    	$post = $this->input->post();
    	
    	$this->db_plc0->where('ifor_id', $post['ifor_id']);
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
	 	$iapprove = $post['type'] == 'PD' ? 'ilab_apppd' : '';
    	$this->db_plc0->update('plc2.plc2_upb_formula', array($iapprove=>1,'vlab_nip_apppd'=>$nip,'tlab_apppd'=>$skg));
    
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
		// $qcek="select count(f.ifor_id) as jum from plc2.plc2_upb_formula f where f.ifor_id=$ifor_id and f.ispekfg_id=$ispekfg_id";
		// $rcek = $this->db_plc0->query($qcek)->row_array();
		// //jika sudah pernah ada stress test utk ups & spek_fg tsb maka
		
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
	function searchPost_product_trial_formula_skala_lab_ikimiawi($value, $name) {
		return $value == 0 ? '' : $value;
	}
	function searchPost_product_trial_formula_skala_lab_idisolusi($value, $name) {
		return $value == 0 ? '' : $value;
	}
	function searchPost_product_trial_formula_skala_lab_imikro($value, $name) {
		return $value == 0 ? '' : $value;
	}
	function searchPost_product_trial_formula_skala_lab_istress($value, $name) {
		return $value == 0 ? '' : $value;
	}
	function insertBox_product_trial_formula_skala_lab_iskimiawi($field, $id) {
		$return = '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="7" />';
		return $return;
	}
	function listBox_product_trial_formula_skala_lab_ilab_apppd($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	function updateBox_product_trial_formula_skala_lab_vkode_surat($field, $id, $value) {
		$return= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'" value="'.$value.'" class="input_rows1" />';
		$return.='<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1" />';
		return $return;
	}
	
	function updateBox_product_trial_formula_skala_lab_iupb_id($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$return = '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" value="'.$row['vupb_nomor'].'" class="input_rows1" size="7" />';
		return $return;
	}
	

	// function updateBox_product_trial_formula_skala_lab_ispekfg_id($field, $id, $value, $rowData) {
		// $row = $this->db_plc0->get_where('plc2.plc2_upb_spesifikasi_fg', array('ispekfg_id'=>$rowData['ispekfg_id']))->row_array();
		// /* print_r($rowData);
		// echo $rowData['ispekfg_id'];
		// print_r($row);exit; */ 
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
		// //$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/spek/fg/list/trial/popup?field=product_trial_formula_skala_lab\',\'List Spesifikasi FG\')" type="button">&nbsp;</button>';
		
		// return $return;
	// }
	
	function updateBox_product_trial_formula_skala_lab_vupb_nama($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" value="'.$row['vupb_nama'].'" class="input_rows1" size="50" />';
		return $return;
	}
	
	function updateBox_product_trial_formula_skala_lab_vgenerik($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return '<textarea cols="50" disabled="TRUE" name="'.$id.'" id="'.$id.'">'.$row['vgenerik'].'</textarea>';
		$return = '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" value="'.$row['vgenerik'].'" class="input_rows1" size="50" />';
		return $return;
	}
	
	function updateBox_product_trial_formula_skala_lab_iteampd_id($field, $id, $value, $rowData) {
		$sql = "SELECT t.vteam FROM plc2.plc2_upb u INNER JOIN plc2.plc2_upb_team t ON u.iteampd_id=t.iteam_id WHERE u.iupb_id='".$rowData['iupb_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" value="'.$row['vteam'].'" class="input_rows1 required" size="40" />';
	}
	
	function updateBox_product_trial_formula_skala_lab_vrevisi($field, $id, $value) {
		$return= '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1" />';
		$return.='<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" value="'.$value.'" class="input_rows1" />';
		return $return;
	}
	
	function updateBox_product_trial_formula_skala_lab_vnip_formulator($field, $id, $value, $rowData) {		 
		$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		$v = count($row) > 0 ? $row['cNip'].' - '.$row['vName'] : '0' ;
		/*$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';*/
		$value=='' ? $value='0' : $value=$value ;
		$return = '<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" value="'.$v.'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_formula_skala_lab\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function updateBox_product_trial_formula_skala_lab_vnip_pic_labkimiawi($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		$v = count($row) > 0 ? $row['cNip'].' - '.$row['vName'] : '0' ;
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_formula_skala_lab&col='.$field.'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	function updateBox_product_trial_formula_skala_lab_vnip_pic_labdisolusi($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		$v = count($row) > 0 ? $row['cNip'].' - '.$row['vName'] : '0' ;
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_formula_skala_lab&col='.$field.'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function updateBox_product_trial_formula_skala_lab_vnip_pic_labmikro($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		$v = count($row) > 0 ? $row['cNip'].' - '.$row['vName'] : '0' ;
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_formula_skala_lab&col='.$field.'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	// function updatePost_product_trial_formula_skala_lab_filename($value, $name, $post) {
		// $new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		// return $new_name;
	// }

	// function updatePost_product_trial_formula_skala_lab_vhasil_kimiawi($value, $name, $post) {
		// $new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		// return $new_name;
	// }
	
	// function updatePost_product_trial_formula_skala_lab_vhasil_disolusi($value, $name, $post) {
		// $new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		// return $new_name;
	// }
	
	// function updatePost_product_trial_formula_skala_lab_vhasil_mikro($value, $name, $post) {
		// $new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		// return $new_name;
	// }

	function updateBox_product_trial_formula_skala_lab_tstart_stress($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl input_rows1 datepicker" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}

	function updateBox_product_trial_formula_skala_lab_tend_stress($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl input_rows1 datepicker" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}

	function updateBox_product_trial_formula_skala_lab_tupload_stress($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl input_rows1 datepicker" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	
	function updateBox_product_trial_formula_skala_lab_tberlaku($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="hidden" class="input_tgl input_rows1 required" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		$return .= '<input type="text" disabled="TRUE" class="input_tgl input_rows1 required" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}	
	function updateBox_product_trial_formula_skala_lab_tstart_labkimiawi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_formula_skala_lab_tend_labkimiawi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_formula_skala_lab_thasil_labkimiawi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_formula_skala_lab_tstart_labdisolusi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_formula_skala_lab_tend_labdisolusi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_formula_skala_lab_thasil_labdisolusi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_formula_skala_lab_tstart_labmikro($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_formula_skala_lab_tend_labmikro($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_formula_skala_lab_thasil_labmikro($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_formula_skala_lab_thasil_istab($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$id.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	
	function updateBox_product_trial_formula_skala_lab_tnote($field, $id, $value) {
		$return = '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'">';
		$return.= '<textarea name="'.$id.'" id="'.$id.'" disabled="TRUE">'.$value.'</textarea>';
		return $return;
	}
	
	function updateBox_product_trial_formula_skala_lab_filename($field, $id, $value, $rowData) {
		//$input = '<input type="file" name="'.$field.'" id="'.$id.'" class="" size="50" />';
		/*$input = '';
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
		$data['rows'] = $this->db_plc0->query("select * from plc2.plc2_upb_file_skala_lab_filename where ifor_id='$idfor' and (ldeleted is null or ldeleted=0)")->result_array();
		//$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_skala_lab_filename', array('ifor_id'=>$idfor,'ldeleted'=>0))->result_array();
		//echo $idfor;
		return $this->load->view('product_trial_formula_skala_lab_file',$data,TRUE);		
	}
	
	//DOWNLOAD SKALA LAB
	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/product_trial/skala_lab/'.$tempat.'/'.$id.'/'.$name);	
		force_download($name, $path);
	}
	//
	
	function updateBox_product_trial_formula_skala_lab_vhasil_labkimiawi($field, $id, $value, $rowData) {
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
		$data['rows'] = $this->db_plc0->query("select * from plc2.plc2_upb_file_skala_lab_kimiawi where ifor_id='$idfor' and (ldeleted is null or ldeleted=0)")->result_array();
		//$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_skala_lab_kimiawi', array('ifor_id'=>$idfor,'ldeleted'=>0))->result_array();
		return $this->load->view('product_trial_formula_skala_lab_file1',$data,TRUE);			
	}
	
	function updateBox_product_trial_formula_skala_lab_vhasil_labdisolusi($field, $id, $value, $rowData) {
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
		$data['rows'] = $this->db_plc0->query("select * from plc2.plc2_upb_file_skala_lab_disolusi where ifor_id='$idfor' and (ldeleted is null or ldeleted=0)")->result_array();
		//$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_skala_lab_disolusi', array('ifor_id'=>$idfor,'ldeleted'=>0))->result_array();
		return $this->load->view('product_trial_formula_skala_lab_file2',$data,TRUE);	
	}
	
	function updateBox_product_trial_formula_skala_lab_vhasil_labmikro($field, $id, $value, $rowData) {
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
		$data['rows'] = $this->db_plc0->query("select * from plc2.plc2_upb_file_skala_lab_mikrobiologi where ifor_id='$idfor' and (ldeleted is null or ldeleted=0)")->result_array();
		//$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_skala_lab_mikrobiologi', array('ifor_id'=>$idfor,'ldeleted'=>0))->result_array();
		return $this->load->view('product_trial_formula_skala_lab_file3',$data,TRUE);		
	}
	
	//Keterangan approval 
	function insertBox_product_trial_formula_skala_lab_vlab_nip_apppd($field, $id) {
		return '';
	}
	function updateBox_product_trial_formula_skala_lab_vlab_nip_apppd($field, $id, $value, $rowData) {
		//print_r($rowData);
		if($rowData['vlab_nip_apppd'] != null){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vlab_nip_apppd']))->row_array();
			if($rowData['ilab_apppd']==2){$st="Approved";}elseif($rowData['ilab_apppd']==1){$st="Rejected";
				// $rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// if(isset($rowa)){$reason=$rowa['treason'];}
				
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vlab_nip_apppd'].' )'.' pada '.$rowData['tlab_apppd'];
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	//
	/*function updateBox_spesifikasi_fg_tentative_spesifikasi ($field, $id, $value, $rowData) {
		$this->db_plc0->where(array('ispekfg_id'=>$rowData['ispekfg_id'], 'ldeleted'=>0));
		$this->db_plc0->order_by('iurut','asc');
		$data['rows'] = $this->db_plc0->get('plc2.plc2_upb_spesifikasi_fg_sediaan')->result_array();
		return $this->load->view('spek_fg_spesifikasi', $data, TRUE);
	}*/
	
	function before_update_processor($row, $postData) {
		$this->load->helper('to_mysql');
		$skrg = date('Y-m-d H:i:s');
		
		$postData['tberlaku'] = to_mysql($postData['tberlaku']);
		unset($postData['vupb_nama']);
		unset($postData['vgenerik']);
		unset($postData['iteampd_id']);
		unset($postData['vrevisi']);
		unset($postData['filename']);
		unset($postData['iwithstabilita']);
		
		$postData['tstart_labkimiawi'] = to_mysql($postData['tstart_labkimiawi']);
		$postData['tend_labkimiawi'] = to_mysql($postData['tend_labkimiawi']);
		$postData['thasil_labkimiawi'] = to_mysql($postData['thasil_labkimiawi']);
		$postData['tstart_labdisolusi'] = to_mysql($postData['tstart_labdisolusi']);
		$postData['tend_labdisolusi'] = to_mysql($postData['tend_labdisolusi']);
		$postData['thasil_labdisolusi'] = to_mysql($postData['thasil_labdisolusi']);
		$postData['tstart_labmikro'] = to_mysql($postData['tstart_labmikro']);
		$postData['tend_labmikro'] = to_mysql($postData['tend_labmikro']);
		$postData['thasil_labmikro'] = to_mysql($postData['thasil_labmikro']);
		//$postData['thasil_istress'] = to_mysql($postData['thasil_istress']);
		$postData['thasil_istab'] = to_mysql($postData['thasil_istab']);
		$postData['iwithstabilita']=1;
		return $postData;
	}
	
	function after_update_processor($row, $updateId, $postData) {
		$getbp=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // activity 3 input data
		$bizsup=$getbp['idplc2_biz_process_sub'];
		$hacek=$this->biz_process->cek_last_status($postData['iupb_id'],$bizsup,7); // status 7 => submit
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
