<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upb_daftar extends MX_Controller {
	var $url;
	var $dbset;
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('auth_localnon');
        $this->load->library('lib_flow');
        $this->load->library('biz_process');
        $this->load->library('lib_utilitas');
		$this->user = $this->auth_localnon->user(); 
		$this->dbset = $this->load->database('plc0',false, true);
		$this->url = 'upb_daftar';
		#$this->auth_localnon
    }
    function index($action = '') {
    	$grid = new Grid;		
		//$grid->searchOperand('vupb_nomor','gteq');
		$grid->setFormUpload(TRUE);
		$grid->setTitle('Daftar UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('upb_daftar');
		//$grid->addList('vupb_nomor','vupb_nama','vgenerik','ikategori_id','ikategoriupb_id','ibe','iteampd_id','iappbusdev' ,'iappdireksi', 'istatus');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik','iteambusdev_id','ihold','ikategori_id','ikategoriupb_id','isediaan_id','iteampd_id','ibe','iappbusdev' ,'iappdireksi', 'istatus','istatus_launching');//,'imaster_delivery'
		$grid->setSortBy('vupb_nomor');
		$grid->setSortOrder('DESC');
		//jika manajer
		$mydept=$this->auth_localnon->tipe();
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			 elseif(in_array('BD', $manager)){
				 $type='BD';
				// $grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth_localnon->my_teams().')', null);
			 }
			elseif(in_array('QA', $manager)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			elseif(in_array('QC', $manager)){
				$type='QC';
				$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			elseif(in_array('DR',$manager)){
				$type='BD';
				$grid->setQuery('plc2.plc2_upb.istatus <> 0', null); // hanya tampil yg sudah di submit
			}
			elseif(in_array('PR',$manager)){
				$type='PR';
				$grid->setQuery('plc2.plc2_upb.istatus <> 0', null); // hanya tampil yg sudah di submit
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
			 elseif(in_array('BD', $team)){
				 $type='BD';
				 //$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth_localnon->my_teams().')', null);
			 }
			elseif(in_array('DR',$team)){
				$type='DR';
				$grid->setQuery('plc2.plc2_upb.istatus <> 0', null); // hanya tampil yg sudah di submit
			}
			elseif(in_array('PR',$team)){
				$type='PR';
				$grid->setQuery('plc2.plc2_upb.istatus <> 0', null); // hanya tampil yg sudah di submit
			}
			elseif(in_array('QA', $team)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			elseif(in_array('QC', $team)){
				$type='QC';
				$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
		/*basic required finish*/

		$grid->setAlign('vupb_nomor', 'center');
		$grid->setWidth('vupb_nomor', '100');
		$grid->setWidth('ikategoriupb_id', '120');
		$grid->setWidth('ibe', '100');
		$grid->setWidth('iteampd_id', '150');
		$grid->setWidth('vupb_nama', '250');
		$grid->setWidth('vgenerik', '250');
		$grid->addFields('iappbusdev','iappdireksi','vupb_nomor','ttanggal','nip_pengusul','vupb_nama','dosis','vgenerik','vkat_originator','voriginator','voriginator_price','voriginator_kemas','tindikasi');
		$grid->addFields('ikategori_id','ikategoriupb_id','iGroup_produk','isediaan_id','itipe_id');
		$grid->addFields('ibe','vhpp_target','tunique','tpacking','ttarget_prareg');
		$grid->addFields('ipatent','tinfo_paten','patent_year','vCopy_Product','iteambusdev_id','iteampd_id','iteamqa_id','iteamqc_id','iteamad_id','iteammarketing_id');//, 'imaster_delivery'
		//$grid->addFields('iregister','idevelop','tmemo_busdev','ihold','dokumen_tambahan');
		$grid->addFields('iregister','idevelop','tmemo_busdev','ihold','dokumen_tambahan');
		$grid->addFields('dokumen_bahan_baku','dokumen_standar_mutu','komposisi_originator','komposisi_upb','marketing_forecast');
		$grid->setRequired('dosis','ipatent','tinfo_paten','patent_year','vCopy_Product','komposisi_upb','idevelop','iregister','vupb_nama','vgenerik','vkat_originator','iteambusdev_id','iteampd_id','iteamqa_id','iteamqc_id','iteamad_id','ikategori_id','ikategoriupb_id','isediaan_id','ibe','itipe_id');
		$grid->setLabel('iappbusdev' ,'App Busdev');
		$grid->setLabel('iappdireksi' ,'App Direksi');
		$grid->setLabel('istatus' ,'Status');
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('tUpbCreatedAt', 'Tanggal UPB');
		$grid->setLabel('ttanggal', 'Tanggal UPB');
		$grid->setLabel('vUpbName', 'Nama Usulan');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		//$grid->setLabel('vGenerik', 'Nama Generik');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('txtIndication', 'Indikasi');
		$grid->setLabel('tindikasi', 'Indikasi');
		$grid->setLabel('idplc2_m_mnf_category', 'Kategori Produk');		
		$grid->setLabel('ikategori_id', 'Kategori Produk');
		$grid->setLabel('idplc2_m_upb_category', 'Kategori UPB');
		$grid->setLabel('ikategoriupb_id', 'Kategori UPB');
		$grid->setLabel('iGroup_produk', 'Group Produk');
		
		$grid->setLabel('idplc2_m_mnf_sediaan', 'Sediaan Produk');
		$grid->setLabel('isediaan_id', 'Sediaan Produk');
		$grid->setLabel('iJenis_sediaan', 'Jenis Sediaan');
		$grid->setLabel('idplc2_biz_process_type', 'Type Produk');
		$grid->setLabel('itipe_id', 'Type Produk');
		$grid->setLabel('iBeType', 'Tipe BE');
		$grid->setLabel('ibe', 'Tipe BE');
		$grid->setLabel('fHppTarget', 'Target HPP');
		$grid->setLabel('vhpp_target', 'Target HPP');
		$grid->setLabel('txtUniquenessOf', 'Keunggulan Produk');
		$grid->setLabel('tunique', 'Keunggulan Produk');
		$grid->setLabel('txtPackingSpec', 'Spesifikasi Kemasan');
		$grid->setLabel('tpacking', 'Spesifikasi Kemasan');
		$grid->setLabel('tPraRegister', 'Estimasi Praregistrasi');
		$grid->setLabel('ttarget_prareg', 'Estimasi Praregistrasi');
		$grid->setLabel('iPatent', 'Tipe Hak Patent');
		$grid->setLabel('ipatent', 'Tipe Hak Patent');
		$grid->setLabel('tInfoPatent', 'Informasi Hak Patent');
		$grid->setLabel('tinfo_paten', 'Informasi Hak Patent');
		$grid->setLabel('vPatentYear', 'Patent Exp.');
		$grid->setLabel('patent_year', 'Patent Exp.');
		$grid->setLabel('imaster_delivery','Master Delivery');
		
		$grid->setLabel('iteambusdev_id', 'Team Busdev');
		$grid->setLabel('iteampd_id', 'Team PD');
		$grid->setLabel('iteamqa_id', 'Team QA');
		$grid->setLabel('iteamqc_id', 'Team QC');
		$grid->setLabel('iteamad_id', 'Team AD');
		
		$grid->setLabel('iteammarketing_id', 'Team Marketing');
		
		$grid->setLabel('iRegisterFor', 'Registrasi Untuk');
		$grid->setLabel('iregister', 'Registrasi Untuk');
		$grid->setLabel('iDevelopBy', 'Produksi oleh');
		$grid->setLabel('idevelop', 'Produksi oleh');
		$grid->setLabel('tmemo_busdev', 'Catatan Busdev');
		$grid->setLabel('tmemo', 'Catatan Busdev');
		$grid->setLabel('isCancel', 'Cancel UPB');
		$grid->setLabel('ihold', 'Cancel UPB');
		$grid->setLabel('dokumen_hold', 'Dokumen cancel UPB');
		$grid->setLabel('vOriginator', 'Originator');
		$grid->setLabel('voriginator', 'Originator');
		$grid->setLabel('vkat_originator', 'Kategori Originator');
		$grid->setLabel('vOriginatorPrice', 'Harga Originator');
		$grid->setLabel('voriginator_price', 'Harga Originator');
		$grid->setLabel('vOriginatorKemas', 'Kemasan Originator');
		$grid->setLabel('voriginator_kemas', 'Kemasan Originator');
		$grid->setLabel('isRawCompleted', 'Kelengkapan Sample Raw Material');
		$grid->setLabel('iPatent', 'Tipe Hak Patent');
		$grid->setLabel('ipatent', 'Tipe Hak Patent');
		$grid->setLabel('tInfoPatent', 'Informasi Hak Patent');
		$grid->setLabel('tinfo_paten', 'Informasi Hak Patent');
		$grid->setLabel('vPatentYear', 'Patent Exp.');
		$grid->setLabel('patent_year', 'Patent Exp.');
		$grid->setLabel('dosis', 'Kekuatan / Dosis UPB');
		$grid->setLabel('iappbusdev', 'Approval Busdev');
		$grid->setLabel('iappdireksi', 'Approval Direksi');
		$grid->setLabel('istatus_launching', 'Status Launching');
		
		//tambahan copy resep
		$grid->setLabel('vCopyProduct', 'Copy Product ke-');
		$grid->setLabel('vCopy_Product', 'Copy Product ke-');

		$grid->setLabel('vsediaan', 'Sediaan');
		
		//end		
		
		$grid->setRelation('ikategoriupb_id','plc2.plc2_upb_master_kategori_upb','ikategori_id','vkategori','upb_kat','inner',array('ldeleted'=>0),array('upb_kat'=>'asc'));
		$grid->setRelation('ikategori_id','hrd.mnf_kategori','ikategori_id','vkategori','mnf_kat','inner',array('ldeleted'=>0),array('mnf_kat'=>'asc'));
		$grid->setRelation('isediaan_id','hrd.mnf_sediaan','isediaan_id','vsediaan','','inner',array('ldeleted'=>0),array('vsediaan'=>'asc'));
		$grid->setRelation('itipe_id','plc2.plc2_biz_process_type','idplc2_biz_process_type','vName','nama_type','inner',array('isDeleted'=>'0'),array('idplc2_biz_process_type'=>'asc'));
		//$grid->setSearch('vupb_nomor','vupb_nama','vgenerik','istatus','ikategori_id','ikategoriupb_id','ibe','iteampd_id');
		$grid->setSearch('vupb_nomor','iteambusdev_id','vupb_nama','vgenerik','iteampd_id','istatus','ikategori_id','ikategoriupb_id','isediaan_id','ibe','istatus_launching');//,'imaster_delivery');
		
		$grid->changeFieldType('iJenis_sediaan','combobox','',array(''=>'--Select--',1=>'Steril', 2=>'Non Setil'));
		$grid->changeFieldType('istatus_launching','combobox','',array(''=>'--Select--',0=>'On Progress', 1=>'Batal',2=>'Launching'));
		//$grid->changeFieldType('iteampd_id','combobox','',array(''=>'--Select--',1=>'Gunung Putri', 2=>'Ulujami PD', 3=>'Etercon'));
		$grid->changeFieldType('isCancel','combobox','',array(0=>'Tidak', 1=>'Iya'));
		$grid->changeFieldType('istatus','combobox','',array(''=>'--Select--',0=>'Draft - Need to be published by Busdev', 1=>'Need to be approved by BDM', 3=>'Need to be approved by Direksi', 7=>'Has been Approved (final)', 6=>'Rejected'));
		$grid->changeFieldType('ihold','combobox','',array(0=>'Tidak', 1=>'Iya'));
		$grid->changeFieldType('ibe','combobox','',array(''=>'--Select--',1=>'BE', 2=>'Non BE'));
		$grid->changeFieldType('ipatent','combobox','',array(''=>'--Select--',1=>'Indonesia', 2=>'International', 3=>'Off Patent'));
		$grid->changeFieldType('iregister','combobox','',array(''=>'--Select--',3=>'PT. Novell Pharm', 5=>'PT. Etercon Pharm'));
		$grid->changeFieldType('iDevelopBy','combobox','',array(''=>'--Select--',3=>'PT. Novell Pharm', 5=>'PT. Etercon Pharm', 100=>'Toll'));
		$grid->changeFieldType('idevelop','combobox','',array(''=>'--Select--',3=>'PT. Novell Pharm', 5=>'PT. Etercon Pharm', 100=>'Toll'));
		$grid->changeFieldType('isRawCompleted','combobox','',array(''=>'--Select--',1=>'Tidak Lengkap', 2=>'Lengkap'));

		
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
				$sql = array();
   				if($isUpload) {
					$path = realpath("files/plc/dok_tambah/");
					if (!mkdir($path."/".$this->input->get('lastId'), 0777, true)) {
					    die('Failed upload, try again!');
					}
					$file_keterangan = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'fileketerangan') {
							foreach($value as $k=>$v) {
								$file_keterangan[$k] = $v;
							}
						}
					}
					$i = 0;
					
					foreach ($_FILES['fileupload']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {				
							$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
							$name = $_FILES['fileupload']["name"][$key];
							$data['filename'] = $name;
							$data['id']=$this->input->get('lastId');
							//$data['iupb_id'] = $insertId;
							//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							$data['dInsertDate'] = date('Y-m-d');
							if(move_uploaded_file($tmp_name, $path."/".$this->input->get('lastId')."/".$name)) {	
								$sql[] = "INSERT INTO plc2_upb_file_dokumen_tambah (iupb_id, filename, dInsertDate, vKeterangan, cInsert) 
										VALUES ('".$data['id']."', '".$data['filename']."','".$data['dInsertDate']."','".$file_keterangan[$i]."','".$this->user->gNIP."')";
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
			case 'updateproses':
				//start cek cancel upb//
				//print_r($this->input->post());
				$cancel_btn = $this->input->get('cancel');
				$isUpload = $this->input->get('isUpload');
				//echo $isUpload.' ss '.$cancel_btn.' sss'.$this->input->post('upb_daftar_iupb_id');
				$sql=array();
				if($cancel_btn==2){
					//echo "ada";
					$fileId1 = array();
				
					$path1 = realpath("files/plc/dok_hold_upb");
					if (!file_exists( $path1."/".$this->input->post('upb_daftar_iupb_id') )) {
						mkdir($path1."/".$this->input->post('upb_daftar_iupb_id'), 0777, true);						 
					}
										
					
					foreach($_POST as $key1=>$value1) {
						if ($key1 == 'namafilex') {
							foreach($value1 as $k=>$v) {
								$file_name1[$k] = $v;
							}
						}
						if ($key1 == 'fileidx') {
							foreach($value1 as $k=>$v) {
								$fileId1[$k] = $v;
							}
						}
					}
					
					$last_index = 0;
				
					if($isUpload) {
						$j = $last_index;														
						if (isset($_FILES['fileuploadx'])) {
							$this->hapusfile($path1, $file_name1, 'plc2_upb_dokumen_hold', $this->input->post('upb_daftar_iupb_id'));
							foreach ($_FILES['fileuploadx']["error"] as $key => $error) {	
								if ($error == UPLOAD_ERR_OK) {
									$tmp_name = $_FILES['fileuploadx']["tmp_name"][$key];
									$name = $_FILES['fileuploadx']["name"][$key];
									$data['filename'] = $name;
									$data['nip']=$this->user->gNIP;
									$data['iupb_id']=$this->input->post('upb_daftar_iupb_id');
									$data['dInsertDate'] = date('Y-m-d H:i:s');
									if(move_uploaded_file($tmp_name, $path1."/".$this->input->post('upb_daftar_iupb_id')."/".$name)) 
									{
										$sql[] = "INSERT INTO plc2_upb_dokumen_hold (iupb_id, filename, dInsertDate, ldeleted) 
											VALUES ('".$data['iupb_id']."', '".$data['filename']."','".$data['dInsertDate']."','0')";
										//print_r($sql);
									//$j++;																			
									}
									 else{
									 echo "Upload ke folder gagal";
									 exit;
									 }
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
						$dateT = date('Y-m-d H:i:s');
						$sqlh = "update plc2.plc2_upb set ihold = 1, iholddate = '".$dateT."' where iupb_id = '".$data['iupb_id']."'";
						$this->db_plc0->query($sqlh);
						
						
						$r['status'] = TRUE;
						$r['last_id'] = $this->input->post('upb_daftar_iupb_id');					
						echo json_encode($r);
						exit();
					// }  else {
							
						// if (is_array($file_name1)) {									
							// $this->hapusfile($path1, $file_name1, 'plc2_upb_dokumen_hold', $this->input->post('upb_daftar_iupb_id'));
						// }
														
						// echo $grid->updated_form();
					// }
				}
				//end //
				else{
					$isUpload = $this->input->get('isUpload');
					$sql = array();
					$file_name= "";
					
					$fileId = array();
					
					$path = realpath("files/plc/dok_tambah/");
					if (!file_exists( $path."/".$this->input->post('upb_daftar_iupb_id') )) {
						mkdir($path."/".$this->input->post('upb_daftar_iupb_id'), 0777, true);						 
					}
										
					$file_keterangan = array();
					//print_r($_POST);exit;
					//[upb_daftar_ihold] => 0
					foreach($_POST as $key=>$value) {
												
						if ($key == 'fileketerangan') {
							foreach($value as $y=>$u) {
								$file_keterangan[$y] = $u;
							}
						}
						
						//
						if ($key == 'namafile') {
							foreach($value as $k=>$v) {
								$file_name[$k] = $v;
							}
						}
			
						//
						if ($key == 'fileid') {
							foreach($value as $k=>$v) {
								$fileId[$k] = $v;
							}
						}
					}
					
					$last_index = 0;
					
					// if (sizeof($fileId) > 0){
					// $x=0;				
						// foreach($fileId as $k=>$v) {
							// $SQL = "UPDATE plc2_upb_file_dokumen_tambah SET vketerangan = '".$file_keterangan[$k]."' where id = '".$v."'"; 
							// $this->dbset->query($SQL);
							// $x=$k;
						// }
						// $last_index = $x+1;
					// }
							
					if($isUpload) {
						$j = $last_index;														
						if (isset($_FILES['fileupload'])) {
							$this->hapusfile($path, $file_name, 'plc2_upb_file_dokumen_tambah', $this->input->post('upb_daftar_iupb_id'));
							foreach ($_FILES['fileupload']["error"] as $key => $error) {	
								if ($error == UPLOAD_ERR_OK) {
									$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
									$name = $_FILES['fileupload']["name"][$key];
									$data['filename'] = $name;
									$data['id']=$this->input->post('upb_daftar_iupb_id');
									$data['nip']=$this->user->gNIP;
									//$data['iupb_id'] = $insertId;
									$data['dInsertDate'] = date('Y-m-d H:i:s');
									//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
									if(move_uploaded_file($tmp_name, $path."/".$this->input->post('upb_daftar_iupb_id')."/".$name)) 
									{
										$sql[] = "INSERT INTO plc2_upb_file_dokumen_tambah (iupb_id, filename, dInsertDate, vketerangan, cInsert) 
											VALUES ('".$data['id']."', '".$data['filename']."','".$data['dInsertDate']."','".$file_keterangan[$j]."','".$data['nip']."')";
								
									$j++;																			
									}
									else{
									echo "Upload ke folder gagal";	
									}
								}
								
							}						
						}
						else{
						$this->hapusfile($path, $file_name, 'plc2_upb_file_dokumen_tambah', $this->input->post('upb_daftar_iupb_id'));
						}
													
						foreach($sql as $q) {
							try {
								$this->dbset->query($q);
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
							$this->hapusfile($path, $file_name, 'plc2_upb_file_dokumen_tambah', $this->input->post('upb_daftar_iupb_id'));
						}
														
						echo $grid->updated_form();
					}
				}
				break;
			case 'rawmat_list':
				$this->rawmat_list();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'), true);
				break;
			case 'copyUPB':
				echo $this->copyUPB_view();
				break;
			case 'copyUPB_process':
				echo $this->copyUPB_process();
				break;
			case 'copyOri':
				echo $this->copyOri_view();
				break;
			case 'copyOri_process':
				echo $this->copyOri_process();
				break;
			case 'copyKomp':
				echo $this->copyKomp_view();
				break;
			case 'copyKomp_process':
				echo $this->copyKomp_process();
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
			case 'revice':
				echo $this->revice_view();
				break;
			case 'revice_process':
				echo $this->revice_process();
				break;
			case 'download':
				$this->download($this->input->get('file'));
				break;	
			case 'download1':
				$this->download1($this->input->get('file'));
				break;	
			case 'gethistkomposisi':
				echo $this->gethistkomposisi();
				break;
			default:
				$grid->render_grid();
				break;
		}
		
    }
    function gethistkomposisi(){
	    $raw_id=$_POST['raw_id'];
		$data = array();
		$row_array = '';
		$sql2 = "select b.vupb_nomor 
				from plc2.plc2_upb_komposisi a 
				join plc2.plc2_upb b on b.iupb_id=a.iupb_id
				where  a.ldeleted=0 and b.ldeleted=0 and a.raw_id='".$raw_id."'";
		$results = $this->dbset->query($sql2)->result_array();

		$i=1;
		foreach ($results as $item ) {
			if ($i==1) {
				$row_array .= trim($item['vupb_nomor']);	
			}else{
				$row_array .= ','.trim($item['vupb_nomor']);		
			}
			

			$i++;
		}
	 	
	 	
	 	
	 	array_push($data, $row_array);
	 	echo json_encode($data);
	    exit;

    }

    function rawmat_list() {
    	$term = $this->input->get('term');
    	$return_arr = array();
    	$this->db_plc0->like('vraw',$term);
    	$this->db_plc0->or_like('vnama',$term);
    	$this->db_plc0->limit(50);
    	$lines = $this->db_plc0->get('plc2.plc2_raw_material')->result_array();
    	$i=0;
    	foreach($lines as $line) {
    		$row_array["sat"] = trim($line["vsatuan"]);
    		$row_array["value"] = trim($line["vnama"]).' - '.trim($line["vraw"]);
    		$row_array["id"] = trim($line["raw_id"]);
    		array_push($return_arr, $row_array);
    	}
    	echo json_encode($return_arr);exit();
		
    }
    
	// copy UPB
	function copyUPB_view() {
		$iupb_id=$this->input->get('upb_id');
		$qupb="select u.vupb_nomor, u.vupb_nama, u.cnip
					from plc2.plc2_upb u where u.iupb_id=$iupb_id";
		$rupb = $this->db_plc0->query($qupb)->row_array();
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
						return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var header = "Info";
								var info = "Info";
								var url = "'.base_url().'processor/plc/upb/daftar";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_upb_daftar").html(data);
									});
									
								}
									_custom_alert(o.message,header,info, "grid_upb_daftar", 1, 20000);
									reload_grid("grid_upb_daftar");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Copy UPB</h1><br />';
		$echo .= '<form id="form_daftar_upb_copyUPB" action="'.base_url().'processor/plc/upb/daftar?action=copyUPB_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= '<input type="hidden" name="iupb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<table class="hover_table" cellspacing="0" cellpadding="1" style="width: 45%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
					<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>Nomor UPB</b></td>
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nomor'].'</td>
					</tr>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7;"><b>Nama Usulan</b></td>
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nama'].'</td>
					</tr><tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>NIP Pengusul</b></td>
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['cnip'].'</td>
					</tr>
				</table>
				</br>
		<button type="button" onclick="submit_ajax(\'form_daftar_upb_copyUPB\')">Simpan</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function copyUPB_process() {
		$team=$this->auth_localnon->my_teams(TRUE);
		$post = $this->input->post();
		$iupb_id =$post['iupb_id'];
		$user = $this->auth_localnon->user();
		
		$qupb="select *	from plc2.plc2_upb u where u.iupb_id=$iupb_id";
		$rupb = $this->db_plc0->query($qupb)->row_array();
		
		$query = "SELECT MAX(iupb_id) std FROM plc2.plc2_upb";
		$rs = $this->db_plc0->query($query)->row_array();
		$nomor = intval($rs['std']) + 1;
		$nomor = "U".str_pad($nomor, 5, "0", STR_PAD_LEFT);
		
		//insert table upb
		$ins['vupb_nomor'] = $nomor;
		$ins['vupb_nama'] = $rupb['vupb_nama']; 
		$ins['cnip'] = $this->user->gNIP;
		$ins['ttanggal'] = date('Y-m-d');
		$ins['tunique'] = $rupb['tunique']; 
		$ins['tpacking'] = $rupb['tpacking']; 
		$ins['ikategori_id'] = $rupb['ikategori_id']; 
		$ins['ikategoriupb_id'] = $rupb['ikategoriupb_id']; 
		$ins['isediaan_id'] = $rupb['isediaan_id']; 
		$ins['ipatent'] = $rupb['ipatent']; 
		$ins['tinfo_paten'] = $rupb['tinfo_paten']; 
		$ins['patent_year'] = $rupb['patent_year']; 
		$ins['ibe'] = $rupb['ibe']; 
		$ins['iuji_mikro'] = $rupb['iuji_mikro']; 
		$ins['itipe_id'] = $rupb['itipe_id']; 
		$ins['voriginator'] = $rupb['voriginator']; 
		$ins['voriginator_price'] = $rupb['voriginator_price']; 
		$ins['voriginator_kemas'] = $rupb['voriginator_kemas']; 
		$ins['vgenerik'] = $rupb['vgenerik']; 
		$ins['tindikasi'] = $rupb['tindikasi']; 
		$ins['vhpp_target'] = $rupb['vhpp_target']; 
		$ins['idevelop'] = $rupb['idevelop']; 
		$ins['iregister'] = $rupb['iregister']; 
		$ins['iteambusdev_id'] = $team[0]; 
		$ins['iteampd_id'] = $rupb['iteampd_id']; 
		$ins['iteamqa_id'] = $rupb['iteamqa_id']; 
		$ins['iteamqc_id'] = $rupb['iteamqc_id']; 
		$ins['iteammarketing_id'] = $rupb['iteammarketing_id']; 
		$ins['txtDocBB'] = $rupb['txtDocBB']; 
		$ins['txtDocSM'] = $rupb['txtDocSM']; 
		$ins['iCompanyId'] = $rupb['iCompanyId']; 
		$ins['vCopy_Product'] = $rupb['vCopy_Product']; 	
		$ins['dosis'] = $rupb['dosis']; 
		$ins['ttarget_prareg'] = $rupb['ttarget_prareg']; 
		$ins['tmemo_busdev'] = $rupb['tmemo_busdev']; 
		$ins['istatus'] =0; //draft need to be published 
		$ins['ihold'] = 0; 
		$this->db_plc0->insert('plc2.plc2_upb', $ins);
		
		//after insert select maxid utk masukan status
		$insertId=$this->db_plc0->insert_id();
		
		/*  insert  dokumen bb  */
		if(isset($rupb['txtDocBB'])){
			// if(($postData['kom_bahan_id'][0])!=""){
				$valtemp = explode(',', $rupb['txtDocBB']);
				foreach($valtemp as $k=>$v){
					$indokbb['iupb_id']=$insertId;
					$indokbb['idoc_id']=$v;
					$indokbb['ldeleted']=0;
					$this->db_plc0->insert('plc2.plc2_upb_detail_dokumen_bb', $indokbb);
				}
				//exit;
			// }
		}

		/* end of insert*/
		/*  insert  dokumen sm  */
		if(isset($rupb['txtDocSM'])){
			// if(($postData['kom_bahan_id'][0])!=""){
				$valtemp = explode(',', $rupb['txtDocSM']);
				foreach($valtemp as $k=>$v){
					$indoksm['iupb_id']=$insertId;
					$indoksm['idoc_id']=$v;
					$indoksm['ldeleted']=0;
					$this->db_plc0->insert('plc2.plc2_upb_detail_dokumen_sm', $indoksm);
				}
				//exit;
			// }
		}
		/* end of insert*/
		
		
		/*  insert  komposisi upb */
		$query_ku = "select * from plc2.plc2_upb_komposisi where ldeleted=0 and iupb_id ='".$post['iupb_id']."' order by ikomposisi_id";
        $rows_ku = $this->db_plc0->query($query_ku)->result_array();
       // echo $query_ku;         
		if($this->db_plc0->query($query_ku)->num_rows() > 0){
			foreach($rows_ku as $k=>$v){
				$kom['iupb_id']=$insertId;
				$kom['raw_id'] = $v['raw_id'];
                $kom['ijumlah'] = $v['ijumlah'];
                $kom['vsatuan'] = $v['vsatuan'];
                $kom['ibobot'] = $v['ibobot'];
                $kom['vketerangan'] = $v['vketerangan'];
				$this->db_plc0->insert('plc2.plc2_upb_komposisi', $kom);
			}
			//exit;
		}
		
		/*  insert  komposisi originator */
		$query_ko = "select * from plc2.plc2_upb_komposisi_ori where ldeleted=0 and iupb_id ='".$post['iupb_id']."' order by ikomposisi_id";
        $rows_ko = $this->db_plc0->query($query_ko)->result_array();
        
		if($this->db_plc0->query($query_ko)->num_rows() > 0){
			foreach($rows_ko as $k=>$v){
				$kor['iupb_id']=$insertId;
				$kor['raw_id'] = $v['raw_id'];
                $kor['ijumlah'] = $v['ijumlah'];
                $kor['vsatuan'] = $v['vsatuan'];
                $kor['ibobot'] = $v['ibobot'];
                $kor['vfungsi'] = $v['vfungsi'];
				$this->db_plc0->insert('plc2.plc2_upb_komposisi_ori', $kor);
			}
			//exit;
		}
		/*
		$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // 1 approval
		$bizsup=$getbp['idplc2_biz_process_sub'];
			
		$hacek=$this->biz_process->cek_last_status($insertId,$bizsup,1); // status 1 => app
		if($hacek==1){ // jika sudah pernah ada data maka update saja
			//insert log
			$this->biz_process->insert_log($insertId, $bizsup, 1); // status 1 => app
			//update last log
			$this->biz_process->update_last_log($insertId, $bizsup, 1);
		}
		elseif($hacek==0){
			//insert log
			$this->biz_process->insert_log($insertId, $bizsup, 1); // status 1 => app
			//insert last log
			$this->biz_process->insert_last_log($insertId, $bizsup, 1);
		}*/
		
		$data['status']  = true;
		$data['last_id'] = $post['iupb_id'];
		$data['message'] = 'Copy UPB Berhasil !';
		return json_encode($data);
	}
	//
	
	// copy Komposisi Originator ke Komposisi UPB
	function copyOri_view() {
		$iupb_id=$this->input->get('upb_id');
		$qupb="select u.vupb_nomor, u.vupb_nama, u.cnip
					from plc2.plc2_upb u where u.iupb_id=$iupb_id";
		$qupa="SELECT  * FROM plc2.plc2_upb_komposisi_ori a 
				  INNER JOIN plc2.plc2_raw_material b 
				  ON b.raw_id = a.raw_id where
				  a.iupb_id=$iupb_id and a.ldeleted ='0' ";			
	
		$rupa = $this->db_plc0->query($qupa);
		$rupb = $this->db_plc0->query($qupb)->row_array();
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
						return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var company_id = 3;
								var group_id = o.group_id;
								var modul_id = o.modul_id;
								var foreign_id = "";
								var header = "Info";
								var info = "Info";
								var url = "'.base_url().'processor/plc/upb/daftar";								
								if(o.status == true) {
									//alert($iupb_id);
									$("#alert_dialog_form").dialog("close");
									$.get(url+"?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
										 $("div#form_upb_daftar").html(data);
									});
									// $.get(url+"processor/plc/upb/daftar?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
										// $("div#form_upb_daftar").html(data);
										// $("html, body").animate({scrollTop:$("#"+grid).offset().top - 20}, "slow");
									// });
									
								}
									_custom_alert("Copy data berhasil",header,info,"grid_upb_daftar", 1, 20000);
									reload_grid("grid_upb_daftar");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Copy Komposisi Originator ke Komposisi UPB</h1><br />';
		$echo .= '<form id="form_daftar_upb_copyOri" action="'.base_url().'processor/plc/upb/daftar?action=copyOri_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= '<input type="hidden" name="iupb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<table class="hover_table" cellspacing="0" cellpadding="1" style="width: 80%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
					<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>Nomor UPB</b></td>
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nomor'].'</td>
					</tr>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7;"><b>Nama Usulan</b></td>
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nama'].'</td>
					</tr><tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>NIP Pengusul</b></td>
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['cnip'].'</td>
					
					</tr><tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>Bahan yang akan di copy</b></td>
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">
						';	
					 if ($rupa->num_rows() > 0) {
						$result = $rupa->result_array();
						$i=1;
						foreach($result as $row) {
								$echo .='<input type="checkbox" name="ikomp_ori[]" value="'.$row['ikomposisi_id'] .'">
								<label for="">'.$row['vnama'].'</label><br>
								';
							$i++;
						}
					}	
		
			$echo .='</td></tr>
				</table>
				</br>
		<button type="button" onclick="submit_ajax(\'form_daftar_upb_copyOri\')">Simpan</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function copyOri_process() {
	//print_r($_POST);
	//exit;
		$team=$this->auth_localnon->my_teams(TRUE);
		$post = $this->input->post();
		$iupb_id =$post['iupb_id'];
		$modul_id =$post['modul_id'];
		$group_id =$post['group_id'];
		$user = $this->auth_localnon->user();
		
		
		$ikomp_ori = array();
		foreach($_POST as $k=>$v) {
			if ($k == 'ikomp_ori') {
				$ikomp_ori[] = $v; 
			}
		}
		$tes='';
		foreach($ikomp_ori as $value) {
			foreach($value as $k=>$v) {
				$sql ="select raw_id, ijumlah, vsatuan, ibobot, vfungsi from plc2.plc2_upb_komposisi_ori where ikomposisi_id ={$v}";
				$query = $this->db_plc0->query($sql);
				$raw_id ='';
				$ijumlah='';
				$vsatuan='';
				$ibobot='';
				$vketerangan='';
				if ($query->num_rows() > 0) {
						$result = $query->result_array();
						foreach($result as $row) {
							$raw_id = $row['raw_id'];
							$ijumlah=$row['ijumlah'];
							$vsatuan=$row['vsatuan'];
							$ibobot=$row['ibobot'];
							$vketerangan=$row['vfungsi'];									
						}
				}
				$kor['iupb_id']=$iupb_id;
				$kor['raw_id'] = $raw_id;
                $kor['ijumlah'] = $ijumlah;
                $kor['vsatuan'] = $vsatuan;
                $kor['ibobot'] = $ibobot;
                $kor['vketerangan'] = $vketerangan;
				$this->db_plc0->insert('plc2.plc2_upb_komposisi', $kor);
			}	
		}
		
		
		/*$qupb="select *	from plc2.plc2_upb u where u.iupb_id=$iupb_id";
		$rupb = $this->db_plc0->query($qupb)->row_array();
		
		        
		$query = "select raw_id, ijumlah, vsatuan, ibobot, vfungsi from plc2.plc2_upb_komposisi_ori where ldeleted=0 and iupb_id=$iupb_id order by ikomposisi_id";
        $rows = $this->db_plc0->query($query)->result_array();
        
		if($this->db_plc0->query($query)->num_rows() > 0){
			foreach($rows as $k=>$v){
				$kom['iupb_id']=$iupb_id;
				$kom['raw_id'] = $v['raw_id'];
                $kom['ijumlah'] = $v['ijumlah'];
                $kom['vsatuan'] = $v['vsatuan'];
                $kom['ibobot'] = $v['ibobot'];
                $kom['vketerangan'] = $v['vfungsi'];
				$this->db_plc0->insert('plc2.plc2_upb_komposisi', $kom);
			}
			//exit;
		}
		*/
		$data['status']  = true;
		$data['last_id'] = $post['iupb_id'];
		$data['modul_id'] = $modul_id;
		$data['group_id'] = $group_id;
		return json_encode($data);
	}
	//
	
	// copy Komposisi UPB ke Komposisi Originator
	function copyKomp_view() {
		$iupb_id=$this->input->get('upb_id');
		$qupb="select u.vupb_nomor, u.vupb_nama, u.cnip
					from plc2.plc2_upb u where u.iupb_id=$iupb_id";
		$qupa="SELECT  * FROM plc2.plc2_upb_komposisi a 
				  INNER JOIN plc2.plc2_raw_material b 
				  ON b.raw_id = a.raw_id where
				  a.iupb_id=$iupb_id and a.ldeleted ='0' ";			
	
		$rupa = $this->db_plc0->query($qupa);
		$rupb = $this->db_plc0->query($qupb)->row_array();
		
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
						return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var company_id = 3;
								var group_id = o.group_id;
								var modul_id = o.modul_id;
								var foreign_id = "";
								var header = "Info";
								var info = "Info";
								var url = "'.base_url().'processor/plc/upb/daftar";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
											$("div#form_upb_daftar").html(data);
										});
										 
									
								}
									_custom_alert("Copy data berhasil ! ",header,info,"grid_upb_daftar", 1, 20000);
									reload_grid("grid_upb_daftar");
							}
					 	 	
					 	 })
					 }
				 </script>';
		
		
		$echo .= '<h1>Copy Komposisi UPB ke Komposisi Originator</h1><br />';
		$echo .= '<form id="form_daftar_upb_copyKomp" action="'.base_url().'processor/plc/upb/daftar?action=copyKomp_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= '<input type="hidden" name="iupb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<table class="hover_table" cellspacing="0" cellpadding="1" style="width: 80%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
					<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>Nomor UPB</b></td>
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nomor'].'</td>
					</tr>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7;"><b>Nama Usulan</b></td>
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nama'].'</td>
					</tr>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>NIP Pengusul</b></td>
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['cnip'].'</td>
					</tr><tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>Bahan yang akan di copy</b></td>
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">
						';	
					 if ($rupa->num_rows() > 0) {
						$result = $rupa->result_array();
						$i=1;
						foreach($result as $row) {
								$echo .='<input type="checkbox" name="ikomp[]" value="'.$row['ikomposisi_id'] .'">
								<label for="">'.$row['vnama'].'</label><br>
								';
							$i++;
						}
					}	
		
			$echo .='</td></tr></table>
				</br>
		<button type="button" onclick="submit_ajax(\'form_daftar_upb_copyKomp\')">Simpan</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function copyKomp_process() {
		$team=$this->auth_localnon->my_teams(TRUE);
		$post = $this->input->post();
		$iupb_id =$post['iupb_id'];
		$modul_id =$post['modul_id'];
		$group_id =$post['group_id'];
		$user = $this->auth_localnon->user();
		$ikomp = array();
		foreach($_POST as $k=>$v) {
			if ($k == 'ikomp') {
				$ikomp[] = $v; 
			}
		}
		$tes='';
		foreach($ikomp as $value) {
			foreach($value as $k=>$v) {
				$sql ="select raw_id, ijumlah, vsatuan, ibobot, vketerangan from plc2.plc2_upb_komposisi where ikomposisi_id ={$v}";
				$query = $this->db_plc0->query($sql);
				$raw_id ='';
				$ijumlah='';
				$vsatuan='';
				$ibobot='';
				$vketerangan='';
				if ($query->num_rows() > 0) {
						$result = $query->result_array();
						foreach($result as $row) {
							$raw_id = $row['raw_id'];
							$ijumlah=$row['ijumlah'];
							$vsatuan=$row['vsatuan'];
							$ibobot=$row['ibobot'];
							$vketerangan=$row['vketerangan'];									
						}
				}
				$kor['iupb_id']=$iupb_id;
				$kor['raw_id'] = $raw_id;
                $kor['ijumlah'] = $ijumlah;
                $kor['vsatuan'] = $vsatuan;
                $kor['ibobot'] = $ibobot;
                $kor['vfungsi'] = $vketerangan;
				$this->db_plc0->insert('plc2.plc2_upb_komposisi_ori', $kor);
			}	
		}
		
		//$qupb="select *	from plc2.plc2_upb u where u.iupb_id=$iupb_id";
		//$rupb = $this->db_plc0->query($qupb)->row_array();
		
		        
		/*$query = "select raw_id, ijumlah, vsatuan, ibobot, vketerangan from plc2.plc2_upb_komposisi where ldeleted=0 and iupb_id=$iupb_id order by ikomposisi_id";
        $rows = $this->db_plc0->query($query)->result_array();
        
		
		if($this->db_plc0->query($query)->num_rows() > 0){
			foreach($rows as $k=>$v){
				$kor['iupb_id']=$iupb_id;
				$kor['raw_id'] = $v['raw_id'];
                $kor['ijumlah'] = $v['ijumlah'];
                $kor['vsatuan'] = $v['vsatuan'];
                $kor['ibobot'] = $v['ibobot'];
                $kor['vfungsi'] = $v['vketerangan'];
				$this->db_plc0->insert('plc2.plc2_upb_komposisi_ori', $kor);
			}
			//exit;
		}
	*/	
		$data['status']  = true;
		$data['last_id'] = $post['iupb_id'];
		$data['modul_id'] = $modul_id;
		$data['group_id'] = $group_id;
		return json_encode($data);
	}
	//
		
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
								var url = "'.base_url().'processor/plc/upb/daftar";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_upb_daftar").html(data);
									});
									
								}
									reload_grid("grid_upb_daftar");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_daftar_upb_approve" action="'.base_url().'processor/plc/upb/daftar?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : <input type="hidden" name="iupb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_daftar_upb_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function approve_process() {
		$post = $this->input->post();
		$this->db_plc0->where('iupb_id', $post['iupb_id']);
		$iapprove = $post['type'] == 'BD' ? 'iappbusdev' : 'iappdireksi';
		$istatus = $post['type'] == 'BD' ? '3' : '7'; // kalo yg app BD istatus=3(need app by BDM), jika DR istatus=7 (final)
		$isapprove = $this->db_plc0->update('plc2.plc2_upb', array($iapprove=>2,'istatus'=>$istatus));

		if ($isapprove) {
			// insert upb_proses_logs
			$action_id = $post['type'] == 'BD' ? '3' : '4'; // kalo yg app BD action_id=3(app by BDM), jika DR action_id=4 (final)
//			$this->lib_flow->insert_logs($post['modul_id'],$post['iupb_id'],$action_id,2);
		}
		
		


		
		$ins['iupb_id'] = $post['iupb_id'];
		$ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
		$ins['vmodule'] = $post['type'] == 'BD' ? 'AppUPB-BD' : 'AppUPB-DR';//$ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
		$ins['idiv_id'] = '';
		$ins['vtipe'] = $post['type'];
		$ins['iapprove'] = '2';
		$ins['cnip'] = $this->user->gNIP;
		$ins['treason'] = $post['remark'];
		$ins['tupdate'] = date('Y-m-d H:i:s');
		
		//yang ini disable sementara
		$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
		
		// if($post['type'] == 'BD') {
			// $bizsup = 2;
		// }
		// elseif($post['type'] == 'DR') {
			// $bizsup = 3;
		// }
		// else {
			// $bizsup = '';
		// }
		// $this->biz_process->insert_log($post['iupb_id'], $bizsup, 1);
		// $this->biz_process->insert_last_log($post['iupb_id'], $bizsup, 1);

/*
remark 20160603	
		$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // 1 approval
		$bizsup=$getbp['idplc2_biz_process_sub'];
			
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
*/		
		//jika BDM approve, maka kirim email ke Direksi
		if($post['type']=='BD'){
			$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
					from plc2.plc2_upb u where u.iappbusdev=2 and u.iappdireksi=0";
			$rupb = $this->db_plc0->query($qupb)->result_array();
			//$to = "";

			$arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
                        $DrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );
			//print_r($arrNip); exit;
			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($arrEmail);
				$to = $arrEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
				}
			}			
			
			$to = $DrEmail;
			$cc = $arrEmail;
			$subject="Need Approval Direksi";
			$a="
				<html>
				<head>
				<style type='text/css'>
				  body, table, tr, th, td, select, a {font-size: 9pt;font-family:tahoma;}
				  table.tbl3 {border-collapse: collapse; border: 1px solid black; font-size: 10px;}
				  tr.tr3, td.td3 {border: 1px solid black; background: #FFFFFF;}
				  tr.tr4, th.th3 {border: 1px solid black; background: #AAAAAA; color: #000000}
				</style>
				</head>
				<body>
				<div><h3>Alert Notification UPB yang Belum Diapprove</h3></div>
				<div><h5>Diberitahukan bahwa telah ada approval UPB oleh Busdev Manager pada aplikasi PLC dengan rincian sebagai berikut :<br><br></h5></div>
				<table class='tbl3' style='width: 100%' width='100%' border='0' cellspacing='0' cellpadding='2'>
				<thead>
					<tr class='tr4'>				
						<th class='th3' style='text-align: center; vertical-align: middle;'>No UPB</th>
						<th class='th3' style='text-align: center; vertical-align: middle;'>Nama Usulan</th>
						<th class='th3' style='text-align: center; vertical-align: middle;'>Nama Generik</th>																
						<th class='th3' style='text-align: center; vertical-align: middle;'>Team Busdev</th>
						<th class='th3' style='text-align: center; vertical-align: middle;'>Team PD</th>
						<th class='th3' style='text-align: center; vertical-align: middle;'>Team QA</th>
						<th class='th3' style='text-align: center; vertical-align: middle;'>Team QC</th>
					</tr>
				</thead>";
						foreach($rupb as $list){
						$a.='
							<tr class="tr3">
								<td class="td3">'.$list['vupb_nomor'].'</td>
								<td class="td3">'.$list['vupb_nama'].'</td>
								<td class="td3">'.$list['vgenerik'].'</td>
								<td class="td3">'.$list['bd'].'</td>
								<td class="td3">'.$list['pd'].'</td>
								<td class="td3">'.$list['qa'].'</td>
								<td class="td3">'.$list['qc'].'</td>
							</tr>
						';
						}
						
					$a.="	
					</table>
				<br/> 
				Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
				Post Master
				</body>
			</html>";
				$content=$a;
			$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		}
		//jika Direksi approve, maka kirim email ke QA, PD dan QC
		elseif($post['type']=='DR'){
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
						$toEmail = $this->lib_utilitas->get_email_team( $team );
                        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
                        $arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
                        
			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($toEmail);
				$to = $toEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
				}
			}	

			$sqlPAC = "select te.iteam_id from plc2.plc2_upb_team te 
				where te.vtipe='PAC' and te.ldeleted = 0";
			$team_pac = $this->db_plc0->query($sqlPAC)->row_array();
			$toEmail3 = $this->lib_utilitas->get_email_team( $team_pac['iteam_id'] );
            $toEmail4 = $this->lib_utilitas->get_email_leader( $team_pac['iteam_id'] );

			$to = $toEmail2.';'.$toEmail.';'.$toEmail3.';'.$toEmail4;
			$cc = $arrEmail;      

  			



			$subject="Has Been Approved : UPB ".$rupb['vupb_nomor'];
			$content="Diberitahukan bahwa telah ada approval UPB oleh Direksi pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
			$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		}
		$data['status']  = true;
		$data['last_id'] = $post['iupb_id'];
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
								var url = "'.base_url().'processor/plc/upb/daftar";								
								if(o.status == true) {
									//alert("a"+$("#remark").val());
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_upb_daftar").html(data);
									});
									
									}
								
									reload_grid("grid_upb_daftar");
							}
					 	 })
						}
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_daftar_upb_reject" action="'.base_url().'processor/plc/upb/daftar?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : <input type="hidden" name="iupb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark" id="remark" required></textarea><button type="button" onclick="submit_ajax(\'form_daftar_upb_reject\')">Reject</button>';
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function reject_process () {
		$post = $this->input->post();
		$this->db_plc0->where('iupb_id', $post['iupb_id']);
		$this->db_plc0->where('iupb_id', $post['iupb_id']);
		$iapprove = $post['type'] == 'BD' ? 'iappbusdev' : 'iappdireksi';
		
		$isreject = $this->db_plc0->update('plc2.plc2_upb', array($iapprove=>1,'istatus'=>6)); //statusnya jadi rejected
		

		// insert upb_proses_logs
		if ($isreject) {
			// insert upb_proses_logs
			$action_id = $post['type'] == 'BD' ? '3' : '4'; // kalo yg app BD action_id=3(app by BDM), jika DR action_id=4 (final)
			//$this->lib_flow->insert_logs($post['modul_id'],$post['iupb_id'],$action_id,1);
		}
		

		$ins['iupb_id'] = $post['iupb_id'];
		//$ins['iapp_id'] = $post['iupb_id']; masa iaap id diisi id upb?
		//$ins['vmodule'] = 'AppUPB-'.$post['type']; nanti gak nyambung kemana2 nya
		$ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
		$ins['vmodule'] = $post['type'] == 'BD' ? 'AppUPB-BD' : 'AppUPB-DR';
		//$ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
		$ins['idiv_id'] = '';
		$ins['vtipe'] = $post['type'];
		$ins['iapprove'] = '2';
		$ins['cnip'] = $this->user->gNIP;
		$ins['treason'] = $post['remark'];
		$ins['tupdate'] = date('Y-m-d H:i:s');
		
		$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
		
		// if($post['type'] == 'BD') {
			// $bizsup = 2;
		// }
		// elseif($post['type'] == 'DR') {
			// $bizsup = 3;
		// }
		// else {
			// $bizsup = '';
		// }
		// $this->biz_process->insert_log($post['iupb_id'], $bizsup, 2);
		// $this->biz_process->insert_last_log($post['iupb_id'], $bizsup, 2);
		
		/*$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // 1 approval
		$bizsup=$getbp['idplc2_biz_process_sub'];
			
		
				
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
			}*/
			
		$data['status']  = true;
		$data['last_id'] = $post['iupb_id'];
		return json_encode($data);
	}
	
	function revice_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	 return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/upb/daftar";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_upb_daftar").html(data);
									});
									
								}
									//reload_grid("grid_upb_daftar");
							}
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Revice</h1><br />';
		$echo .= '<form id="form_daftar_upb_revice" action="'.base_url().'processor/plc/upb/daftar?action=revice_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : <input type="hidden" name="iupb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea><button type="button" onclick="submit_ajax(\'form_daftar_upb_revice\')">Revice</button>';
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function revice_process() {
		$post = $this->input->post();
		$this->db_plc0->where('iupb_id', $post['iupb_id']);
		$this->db_plc0->where('iupb_id', $post['iupb_id']);
		$iapprove = $post['type'] == 'BD' ? 'iappbusdev' : 'iappdireksi';
		//$istatus = $post['type'] == 'BD' ? '2' : '7'; // kalo yg app BD istatus=3(need app by BDM), jika DR istatus=7 (final)
		$this->db_plc0->update('plc2.plc2_upb', array($iapprove=>0,'istatus'=>2)); // revice cm bisa dilakukan oleh BDM dgn istatus 2
		//$this->db_plc0->update('plc2.plc2_upb', array($iapprove=>0));
		
		$ins['iupb_id'] = $post['iupb_id'];
		//$ins['iapp_id'] = $post['iupb_id']; masa iaap id diisi id upb?
		//$ins['vmodule'] = 'AppUPB-'.$post['type']; nanti gak nyambung kemana2 nya
		$ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
		$ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
		$ins['idiv_id'] = '';
		$ins['vtipe'] = $post['type'];
		$ins['iapprove'] = '2';
		$ins['cnip'] = $this->user->gNIP;
		$ins['treason'] = $post['remark'];
		$ins['tupdate'] = date('Y-m-d H:i:s');
		
		$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
		
		if($post['type'] == 'BD') {
			$bizsup = 2;
		}
		elseif($post['type'] == 'DR') {
			$bizsup = 3;
		}
		else {
			$bizsup = '';
		}
		/*$this->biz_process->insert_log($post['iupb_id'], $bizsup, 3);
		$this->biz_process->insert_last_log($post['iupb_id'], $bizsup, 3);*/
		
		$data['status']  = true;
		$data['last_id'] = $post['iupb_id'];
		return json_encode($data);
	}
	
    function listBox_upb_daftar_iteambusdev_id($value) {
    	$team = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id' => $value))->row_array();
    	if(isset($team['vteam'])){
			return $team['vteam'];
		}
		else{
			return $value;
		}
		
    } 

    function listBox_upb_daftar_imaster_delivery($value){
    	if ($value == '0'){
    		return "Not Selected";
    	}else{
    		$sql = "SELECT vKey, vDeskripsi FROM plc2.master_delivery_system WHERE imaster_delivery_system = '".$value."' AND lDeleted = '0' LIMIT 1";
    		$data = $this->db_plc0->query($sql)->row_array();
    		return $data['vKey']." - ".$data['vDeskripsi'];
    	}
    }

    function listBox_upb_daftar_iteampd_id($value) {
    	$team = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id' => $value))->row_array();
    	if(isset($team['vteam'])){
			return $team['vteam'];
		}
		else{
			return $value;
		}
		
    } 

    function listBox_upb_daftar_iappdireksi($value) {
    	/* $appd = $this->db_plc0->get_where('plc2.plc2_status', array('idplc2_status' => $value))->row_array();
    	if($value==0){$appd['vCaption']="Waiting For Approval";} */
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	 function listBox_upb_daftar_iappbusdev($value) {
    	/* $team = $this->db_plc0->get_where('plc2.plc2_status', array('idplc2_status' => $value))->row_array();
    	if($value==0){$team['vCaption']="Waiting For Approval";} */
	 	if($value==0){$vstatus='Waiting for approval';}
	 	elseif($value==1){$vstatus='Rejected';}
	 	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    } 
 
     // function listBox_upb_daftar_istatus($value) {
    	 // if($value==0){$vstatus='Draft - Need to be published by Busdev';}
    	 // elseif($value==1){$vstatus='Need to be approved by BDM';}
    	 // elseif($value==3){$vstatus='Need to be approved by Direksi';}
    	 // elseif($value==7){$vstatus='Has been Approved (final)';}
    	 // elseif($value==6){$vstatus='Rejected';}
    	 // return $vstatus;
     // } 

	 //keterangan approval//
	function insertBox_upb_daftar_iappbusdev($field, $id) {
		return '-';
	}

	function searchBox_upb_daftar_iteampd_id($rowData, $id) {
		$teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('ldeleted' => 0,'vtipe' => 'PD'))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }  

    function searchBox_upb_daftar_imaster_delivery($rowData, $id){
    	$teams = $this->db_plc0->get_where('plc2.master_delivery_system', array('lDeleted' => 0))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['imaster_delivery_system'].'">'.$t['vKey']." - ".$t['vDeskripsi'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }
	/*
	function insertBox_upb_daftar_voriginator($field, $id) {
		$return ="<script>
			$('.test').tooltip();
		</script>";
		$return .='<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1 test" title="Jika N/A untuk Melanjutkan ke Permintaan Sample Originator" size="30" placeholder="N/A";/>';
    	 // onkeypress="return isFloatKey(event)"
    	return $return;
	}
	*/
	function updateBox_upb_daftar_iappbusdev($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($value <> 0) || (!empty($value))){
			$iupb_id=$rowData['iupb_id'];
			$ssql="select e.vName, uap.tupdate, (ifnull(uap.treason,'-')) as reason
					 from plc2.plc2_upb_approve uap 
						inner join hrd.employee e on e.cNip=uap.cnip
					where uap.iupb_id=$iupb_id and uap.vmodule in ('AppUPB-BD','2471') and uap.vtipe='BD' limit 1";
			$row = $this->db_plc0->query($ssql)->row_array();
			$jumrow = $this->db_plc0->query($ssql)->num_rows();
			if($jumrow>0){
				if($value==2){$st='<p style="color:green;font-size:120%;">Approved';}
				elseif($value==1){$st='<p style="color:red;font-size:120%;">Rejected';} 
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['tupdate'].'</br> Alasan: '.$row['reason'].'</p>';
			}
			else{
			if($value==2){$st='<p style="color:red;font-size:120%;">Approved';}
			elseif($value==1){$st='<p style="color:red;font-size:120%;">Rejected';} 
			$ret=$st.'&nbsp; (Detail Approval Belum Tersimpan!) </p>';}
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	function insertBox_upb_daftar_iappdireksi($field, $id) {
		return '-';
	}
	function updateBox_upb_daftar_iappdireksi($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($value <> 0) || (!empty($value))){
			$iupb_id=$rowData['iupb_id'];
			$ssql="select e.vName, uap.tupdate, (ifnull(uap.treason,'-')) as reason
					 from plc2.plc2_upb_approve uap 
						inner join hrd.employee e on e.cNip=uap.cnip
						where uap.iupb_id=$iupb_id and uap.vmodule in ('AppUPB-DR','2471') and uap.vtipe='DR' ORDER BY uap.iapprove_id DESC limit 1";
			$row = $this->db_plc0->query($ssql)->row_array();
			$jumrow = $this->db_plc0->query($ssql)->num_rows();
			if($jumrow>0){
				if($value==2){$st='<p style="color:green;font-size:120%;">Approved'; 
					$ret= $st.' oleh '.$row['vName'].' pada '.$row['tupdate'].'</p>';
				}
				elseif($value==1){$st='<p style="color:red;font-size:120%;">Rejected'; $ret= $st.' oleh '.$row['vName'].' pada '.$row['tupdate'].'</br> Alasan: '.$row['reason'].'</p>';} 
			}
			else{
				if($value==2){$st='<p style="color:red;font-size:120%;">Approved';}
				elseif($value==1){$st='<p style="color:red;font-size:120%;">Rejected';} 
					$ret=$st.'&nbsp; (Detail Approval Belum Tersimpan!) </p>';
				}
		}
		else{
			$ret='Waiting for Approval';
		}
		return $ret;
	}

	function insertBox_upb_daftar_vkat_originator($field, $id) {
		$o='<select id="upb_daftar_vkat_originator" class=" combobox" name="upb_daftar_vkat_originator">
				<option value="">--Select--</option>
				<option value="1">NA</option>
				<option value="2">Novell</option>
				<option value="3">Non-Novell</option>
			</select>';
		$o .= '<script type="text/javascript">
				$("#upb_daftar_vkat_originator").change(function(){
					if ($(this).val()==1 || $(this).val()==2 ) {
						$(this).parent().parent().next().hide();
						
					}else{
						$(this).parent().parent().next().show();
						
					}
				});
				</script>';
		return $o;
		
	}

	 
	public function updatebox_master_phonebk_lDeleted($field, $id, $value) {
        $lmarketing = array(0=>'Active', 1=>'Deleted');
        if ($this->input->get('action') == 'view') {
            $o = $lmarketing[$value];
        } else {
            $o  = "<select name='".$field."' id='".$id."'>";            
            foreach($lmarketing as $k=>$v) {
                if ($k == $value) $selected = " selected";
                else $selected = "";
                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
            }            
            $o .= "</select>";
        }
        return $o;
    }


	function updateBox_upb_daftar_vkat_originator($field, $id, $value ,$rowData) {
		 $kat = array(""=>'--Select--', 1=>'NA', 2=>'Novell', 3=>'Non-Novell');
		 if ($this->input->get('action') == 'view') {
            $o = $kat[$value];
        } else {
            $o  = "<select id='upb_daftar_vkat_originator' class='combobox' name='upb_daftar_vkat_originator'>";            
            foreach($kat as $k=>$v) {
                if ($k == $value) $selected = " selected";
                else $selected = "";
                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
            }            
            $o .= "</select>";
        }
        $o .= '<script type="text/javascript">
				$("#upb_daftar_vkat_originator").change(function(){
					if ($(this).val()==1 || $(this).val()==2) {
						$(this).parent().parent().next().hide();
						
					}else{
						$(this).parent().parent().next().show();
						
					}
				});
				</script>';
        return $o;
        /*

		$o='<select id="upb_daftar_voriginator" class=" combobox" name="upb_daftar_voriginator">
				<option value=""  >--Select--</option>
				<option value=1 <?php ($value===1)?selected=selected:'' ?>>NA</option>
				<option value=2  >Novell</option>
				<option value=3 >Non-Novell</option>
			</select>';
		$o .= '<script type="text/javascript">
				$("#upb_daftar_voriginator").change(function(){
					if ($(this).val()==1 ) {
						$(this).parent().parent().next().hide();
						
					}else{
						$(this).parent().parent().next().show();
						
					}
				});
				</script>';
		return $o;
		*/
	}



	function insertBox_upb_daftar_voriginator($field, $id) {
    	$return = '<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1" size="50"/>';
    	return $return;
    }

   function updateBox_upb_daftar_voriginator($field, $id, $value) {
		$return = '<input type="text" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1" size="50" />';
    	 
    	return $return;
    }

	//
	function insertBox_upb_daftar_voriginator_price($field, $id) {
    	$return = '<input type="hidden" name="isdraft" id="isdraft">
		<input type="text" name="'.$id.'" id="'.$id.'" class=" currency input_rows1" size="7"/> Rp';
    	 // onkeypress="return isFloatKey(event)"

		$return.='
		<script type="text/javascript">
			// datepicker
			 $(".tanggal").datepicker({changeMonth:true,
										changeYear:true,
										dateFormat:"yy-mm-dd" });

			// input number
			   $(".angka").numeric({ decimal : ".",  negative : false, scale: 2 });
			   $(".currency").numeric({ decimal : ".",  negative : false, scale: 2 });

				

			   var format = function(num){
				    var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
				    if(str.indexOf(".") > 0) {
				        parts = str.split(".");
				        str = parts[0];
				    }
				    str = str.split("").reverse();
				    for(var j = 0, len = str.length; j < len; j++) {
				        if(str[j] != ",") {
				            output.push(str[j]);
				            if(i%3 == 0 && j < (len - 1)) {
				                output.push(",");
				            }
				            i++;
				        }
				    }
				    formatted = output.reverse().join("");
				    return("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
				};

				$(function(){
				    $(".currency").keyup(function(e){
				        $(this).val(format($(this).val()));
				    });
				});

		</script>
		';

    	return $return;
    }
    
    function updateBox_upb_daftar_voriginator_price($field, $id, $value) {
    	//onkeypress="return isFloatKey(event)"
		$return = '<input type="hidden" name="isdraft" id="isdraft">
		<input type="text" name="'.$id.'" id="'.$id.'" value="'.$value.'" class=" currency input_rows1" size="7" /> Rp';
		$return.='
		<script type="text/javascript">
			// datepicker
			 $(".tanggal").datepicker({changeMonth:true,
										changeYear:true,
										dateFormat:"yy-mm-dd" });

			// input number
			  $(".angka").numeric({ decimal : ".",  negative : false, scale: 2 });
			   $(".currency").numeric({ decimal : ".",  negative : false, scale: 2 });

				

			   var format = function(num){
				    var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
				    if(str.indexOf(".") > 0) {
				        parts = str.split(".");
				        str = parts[0];
				    }
				    str = str.split("").reverse();
				    for(var j = 0, len = str.length; j < len; j++) {
				        if(str[j] != ",") {
				            output.push(str[j]);
				            if(i%3 == 0 && j < (len - 1)) {
				                output.push(",");
				            }
				            i++;
				        }
				    }
				    formatted = output.reverse().join("");
				    return("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
				};

				$(function(){
				    $(".currency").keyup(function(e){
				        $(this).val(format($(this).val()));
				    });
				}); 
		</script>
		';
    	 
    	return $return;
    }

    function insertBox_upb_daftar_vhpp_target($field, $id) {
    	//$return = '<input type="number" step="0.01" name="'.$id.'" id="'.$id.'" class="input_rows1" size="7" onkeypress="return isFloatKey(event)"/>';
    	$return = '<input type="text" name="'.$id.'" id="'.$id.'" class=" currency input_rows1" size="7" min="0"  /> Rp';
    
    	return $return;
    }
    
    function updateBox_upb_daftar_vhpp_target($field, $id, $value) {
    	$return = '<input type="text"  name="'.$id.'" value="'.$value.'" id="'.$id.'" class="currency input_rows1" size="7" min="0"  />';
    	//$return = '<input type="text" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1" size="7" onkeypress="return isFloatKey(event)"/>';
    	
    	return $return;
    }
	function insertBox_upb_daftar_vCopy_Product($field, $id) {
    	$return = '<input type="text" required=required name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="7" onkeypress="return isFloatKey(event)"/>';
    
    	return $return;
    }
    
    function updateBox_upb_daftar_vCopy_Product($field, $id, $value) {
    	$return = '<input type="text" required=required name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="7" onkeypress="return isFloatKey(event)"/>';
    
    	return $return;
    }
	
	function searchBox_upb_daftar_iteambusdev_id($rowData, $id) {
    	$teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('ldeleted' => 0,'vtipe' => 'BD'))->result_array();
    	$o = '<select id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }    
    public function updateBox_upb_daftar_ttarget_prareg($field, $id, $value) {
      	$o = '<input name="'.$id.'" id="'.$id.'" type="text" value="'.date('d-m-Y', strtotime($value)).'" size="15" class="input_tgl datepicker"/>';
    	return $o;
    }
   function insertBox_upb_daftar_ihold($field, $id) {
    	return 'Save record First !';
    }
	function updateBox_upb_daftar_ihold($field, $id, $value, $rowData) {
    	$team=$this->auth_localnon->my_teams(TRUE);
		$data['teamnya']=$team[0];
		$data['teamupb']=$rowData['iteambusdev_id'];
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		$idupb=$rowData['iupb_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_dokumen_hold', array('iupb_id'=>$idupb))->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('holdupb_detail',$data,TRUE);
    }
	// function insertBox_upb_daftar_dokumen_hold($field, $id) {
    	// return 'Save record First !';
    // }
	// function updateBox_upb_daftar_dokumen_hold($field, $id) {
    	// $data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		// $data['date'] = date('Y-m-d H:i:s');	
		// return $this->load->view('holdupb_detail',$data,TRUE);
    // }
    function insertBox_upb_daftar_iGroup_produk($field, $id) {
    	$teams = $this->db_plc0->get_where('plc2.master_group_produk', array('lDeleted' => 0))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['imaster_group_produk'].'">'.$t['vNama_Group'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }
    function updateBox_upb_daftar_iGroup_produk($field, $id, $value, $rowData) {
    	$sql = "select * from plc2.master_group_produk a where a.lDeleted=0 ";
    	$teams = $this->db_plc0->query($sql)->result_array();
    	$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($teams as $t) {
    		$selected = $rowData['iGroup_produk'] == $t['imaster_group_produk'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$t['imaster_group_produk'].'">'.$t['vNama_Group'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }

    function insertBox_upb_daftar_imaster_delivery($field, $id) {
    	$teams = $this->db_plc0->get_where('plc2.master_delivery_system', array('lDeleted' => 0))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['imaster_delivery_system'].'">'.$t['vKey']." - ".$t['vDeskripsi'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }


    function updateBox_upb_daftar_imaster_delivery($field, $id, $value, $rowData) {
    	$teams = $this->db_plc0->get_where('plc2.master_delivery_system', array('lDeleted' => 0))->result_array();
    	$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($teams as $t) {
    		$selected = $rowData['imaster_delivery'] == $t['imaster_delivery_system'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$t['imaster_delivery_system'].'">'.$t['vKey']." - ".$t['vDeskripsi'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }

	function insertBox_upb_daftar_iteampd_id($field, $id) {
    	$teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('ldeleted' => 0,'vtipe' => 'PD'))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }
    function updateBox_upb_daftar_iteampd_id($field, $id, $value, $rowData) {
    	$sql = "SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = 'PD' AND t.ldeleted = '0'";
    	$teams = $this->db_plc0->query($sql)->result_array();
    	$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($teams as $t) {
    		$selected = $rowData['iteampd_id'] == $t['iteam_id'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }
    
	function insertBox_upb_daftar_dokumen_tambahan($field, $id) {
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('upb_daftar_upb_file',$data,TRUE);
	}
	function updateBox_upb_daftar_dokumen_tambahan($field, $id, $value, $rowData) {
		$idupb = $rowData['iupb_id'];	
		//$a = $_GET['id'];	
		//$this->db_plc0->where('iupb_id',$a);
		//$this->db_plc0->where('ldeleted', 0);
		//$data['rows'] = $this->db_plc0->get('plc2.plc2_upb_dokumen')->result_array();	
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_dokumen_tambah', array('iupb_id'=>$idupb))->result_array();
		return $this->load->view('upb_daftar_upb_file',$data,TRUE);
	}
	
	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/dok_tambah/'.$id.'/'.$name);		
		force_download($name, $path);
	}
	function download1($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/dok_hold_upb/'.$id.'/'.$name);		
		force_download($name, $path);
	}
	
    function insertBox_upb_daftar_iteambusdev_id($field, $id) {
    	$sql = "SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = 'BD' AND t.ldeleted = '0' AND t.iteam_id IN (".$this->auth_localnon->my_teams().")";
    	$teams = $this->db_plc0->query($sql)->result_array();
    	$echo = '<select name="'.$id.'" id="'.$id.'">';
    	foreach($teams as $t) {
    		$echo .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }
    function updateBox_upb_daftar_iteambusdev_id($field, $id, $value, $rowData) {
    	/*$sql = "SELECT t.* FROM plc2.plc2_upb_team t
				INNER JOIN plc2.plc2_div d ON t.idplc2_div = d.idplc2_div
				WHERE d.vCode = 'BD' AND t.ldeleted = '0' AND t.iteam_id IN (".$this->auth_localnon->my_teams().")";*/
		$sql = "SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = 'BD' AND t.ldeleted = '0' AND t.iteam_id IN (".$value.")";
    	$teams = $this->db_plc0->query($sql)->result_array();
    	$echo = '<select name="'.$id.'" id="'.$id.'">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($teams as $t) {
    		$selected = $rowData['iteambusdev_id'] == $t['iteam_id'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }
    
    function insertBox_upb_daftar_iteamqa_id($field, $id) {
    	$teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('ldeleted' => 0,'vtipe' => 'QA'))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }
    function updateBox_upb_daftar_iteamqa_id($field, $id, $value, $rowData) {
    	$sql = "SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = 'QA' AND t.ldeleted = '0'";
    	$teams = $this->db_plc0->query($sql)->result_array();
    	$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($teams as $t) {
    		$selected = $rowData['iteamqa_id'] == $t['iteam_id'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }
    
    function insertBox_upb_daftar_iteamqc_id($field, $id) {
    	$teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('ldeleted' => 0,'vtipe' => 'QC'))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }
    function updateBox_upb_daftar_iteamqc_id($field, $id, $value, $rowData) {
    	$sql = "SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = 'QC' AND t.ldeleted = '0'";
    	$teams = $this->db_plc0->query($sql)->result_array();
    	$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($teams as $t) {
    		$selected = $rowData['iteamqc_id'] == $t['iteam_id'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }

    function insertBox_upb_daftar_iteamad_id($field, $id) {
    	$teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('ldeleted' => 0,'vtipe' => 'AD'))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }
    function updateBox_upb_daftar_iteamad_id($field, $id, $value, $rowData) {
    	$sql = "SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = 'AD' AND t.ldeleted = '0'";
    	$teams = $this->db_plc0->query($sql)->result_array();
    	$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($teams as $t) {
    		$selected = $rowData['iteamad_id'] == $t['iteam_id'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }
    
    function insertBox_upb_daftar_iteammarketing_id($field, $id) {
    	$teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('ldeleted' => 0,'vtipe' => 'MR'))->result_array();
    	$o = '<select  name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }
    
    function updateBox_upb_daftar_iteammarketing_id($field, $id, $value, $rowData) {
    	$sql = "SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = 'MR' AND t.ldeleted = '0'";
    	$teams = $this->db_plc0->query($sql)->result_array();
    	$echo = '<select  name="'.$id.'" id="'.$id.'">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($teams as $t) {
    		$selected = $rowData['iteammarketing_id'] == $t['iteam_id'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }

	function insertBox_upb_daftar_vupb_nomor($field, $id) {
		$echo = '<input type="hidden" name="'.$id.'" id="'.$id.'" />Automatic Generated';
		return $echo;
	}
	
	function updateBox_upb_daftar_vupb_nomor($field, $id, $value,$rowData) {
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('BD', $manager)){$type='BD';}
			elseif(in_array('DR', $manager)){$type='DR';}
			else{$type='';}
			//echo $type;
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('BD', $team)){$type='BD';}
			elseif(in_array('DR', $team)){$type='DR';}
			else{$type='';}
		}
		//echo 'tes: '.$type;
		$user = $this->auth_localnon->user();
		$return='<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" >';
		$return .=$value;
		if(($type=='BD')||($type=='DR')){
			$return .='&nbsp;&nbsp;&nbsp; <span onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/daftar?action=copyUPB&upb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" id="button_copyUPB">Copy UPB</span>';
		}
		return $return;
	}
	
	function insertBox_daftar_upb_tUpbCreatedAt($field, $id) {
		$user = $this->auth_localnon->user();
		return '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.date('Y-m-d').'" >'.date('l, F jS, Y');
	}
	function insertBox_upb_daftar_ttanggal($field, $id) {
		return '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.date('Y-m-d').'" >'.date('l, F jS, Y');
	}
	
	function updateBox_daftar_upb_tUpbCreatedAt($field, $id, $value) {
		return date('l, F jS, Y', strtotime($value));
	}
	function updateBox_upb_daftar_ttanggal($field, $id, $value) {
		return date('l, F jS, Y', strtotime($value));
	}

	function insertBox_daftar_upb_nip_pengusul($field, $id) {
		$user = $this->auth_localnon->user();
		return '<input type="hidden" name="cnip" value="'.$user['vNip'].'" >'.$user['vNip'].' | '.$user['vName'];
	}
	function insertBox_upb_daftar_nip_pengusul($field, $id) {
		$user = $this->auth_localnon->user();
		return '<input type="hidden" name="cnip" value="'.$user->gNIP.'" >'.$user->gNIP.' | '.$user->gName;
	}
	
	function updateBox_daftar_upb_nip_pengusul($field, $id, $value, $rowData) {
		$upb_id = $rowData['idplc_master_upb'];		
		$this->db_plc0->join('user_data','upb_status_last.cNip = user_data.vNip', 'inner');
		$row = $this->db_plc0->get_where('upb_status_last', array('idplc_master_upb'=> $upb_id))->row_array();
		if(count($row > 0)) {
			return $row['cNip'].' | '.$row['vName'];
		}
		else {
			return '';
		}		
	}
	
	function updateBox_upb_daftar_nip_pengusul($field, $id, $value, $rowData) {
		$upb_id = $rowData['iupb_id'];
		$this->db_plc0->join('hrd.employee','plc2.plc2_upb.cnip = hrd.employee.cNip', 'inner');
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=> $upb_id))->row_array();
		if(count($row > 0)) {
			return $row['cNip'].' | '.$row['vName'];
		}
		else {
			return '';
		}
	}

	function insertBox_daftar_upb_team_busdev($field, $id) {
		$sql = "SELECT t.* FROM ".$this->db_plc0->dbprefix('div_team')." t 
				INNER JOIN ".$this->db_plc0->dbprefix('div')." d ON t.idplc_div = d.idplc_div
				WHERE d.vCode = 'BD' AND t.isDeleted = '0' AND t.idplc_div_team = '".$this->auth_localnon->team()."'";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		foreach($teams as $t) {
			$echo .= '<option value="'.$t['idplc_div_team'].'">'.$t['vName'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	function updateBox_daftar_upb_team_busdev($field, $id, $value, $rowData) {		
		$sql = "SELECT t.* FROM ".$this->db_plc0->dbprefix('div_team')." t 
				INNER JOIN ".$this->db_plc0->dbprefix('div')." d ON t.idplc_div = d.idplc_div
				WHERE d.vCode = 'BD' AND t.isDeleted = '0' AND t.idplc_div_team = '".$this->auth_localnon->team()."'";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		foreach($teams as $t) {
			$selected = $rowData['idTeamBD'] == $t['idplc_div_team'] ? 'selected' : '';
			$echo .= '<option '.$selected.' value="'.$t['idplc_div_team'].'">'.$t['vName'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}

	function insertBox_daftar_upb_team_pd($field, $id) {
		$sql = "SELECT t.* FROM ".$this->db_plc0->dbprefix('div_team')." t 
				INNER JOIN ".$this->db_plc0->dbprefix('div')." d ON t.idplc_div = d.idplc_div
				WHERE d.vCode = 'PD' AND t.isDeleted = '0'";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		foreach($teams as $t) {
			$echo .= '<option value="'.$t['idplc_div_team'].'">'.$t['vName'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	function updateBox_daftar_upb_team_pd($field, $id, $value, $rowData) {		
		$sql = "SELECT t.* FROM ".$this->db_plc0->dbprefix('div_team')." t 
				INNER JOIN ".$this->db_plc0->dbprefix('div')." d ON t.idplc_div = d.idplc_div
				WHERE d.vCode = 'PD' AND t.isDeleted = '0'";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		foreach($teams as $t) {
			$selected = $rowData['idTeamPD'] == $t['idplc_div_team'] ? 'selected' : '';
			$echo .= '<option '.$selected.' value="'.$t['idplc_div_team'].'">'.$t['vName'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	function insertBox_daftar_upb_team_qa($field, $id) {
		$sql = "SELECT t.* FROM ".$this->db_plc0->dbprefix('div_team')." t 
				INNER JOIN ".$this->db_plc0->dbprefix('div')." d ON t.idplc_div = d.idplc_div
				WHERE d.vCode = 'QA' AND t.isDeleted = '0'";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		foreach($teams as $t) {
			$echo .= '<option value="'.$t['idplc_div_team'].'">'.$t['vName'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	function updateBox_daftar_upb_team_qa($field, $id, $value, $rowData) {		
		$sql = "SELECT t.* FROM ".$this->db_plc0->dbprefix('div_team')." t 
				INNER JOIN ".$this->db_plc0->dbprefix('div')." d ON t.idplc_div = d.idplc_div
				WHERE d.vCode = 'QA' AND t.isDeleted = '0'";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		foreach($teams as $t) {
			$selected = $rowData['idTeamQA'] == $t['idplc_div_team'] ? 'selected' : '';
			$echo .= '<option '.$selected.' value="'.$t['idplc_div_team'].'">'.$t['vName'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	function insertBox_daftar_upb_team_qc($field, $id) {
		$sql = "SELECT t.* FROM ".$this->db_plc0->dbprefix('div_team')." t 
				INNER JOIN ".$this->db_plc0->dbprefix('div')." d ON t.idplc_div = d.idplc_div
				WHERE d.vCode = 'QC' AND t.isDeleted = '0'";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		foreach($teams as $t) {
			$echo .= '<option value="'.$t['idplc_div_team'].'">'.$t['vName'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	function updateBox_daftar_upb_team_qc($field, $id, $value, $rowData) {		
		$sql = "SELECT t.* FROM ".$this->db_plc0->dbprefix('div_team')." t 
				INNER JOIN ".$this->db_plc0->dbprefix('div')." d ON t.idplc_div = d.idplc_div
				WHERE d.vCode = 'QC' AND t.isDeleted = '0'";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		foreach($teams as $t) {
			$selected = $rowData['idTeamQC'] == $t['idplc_div_team'] ? 'selected' : '';
			$echo .= '<option '.$selected.' value="'.$t['idplc_div_team'].'">'.$t['vName'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	function insertBox_daftar_upb_team_marketing($field, $id) {
		$sql = "SELECT t.* FROM ".$this->db_plc0->dbprefix('div_team')." t 
				INNER JOIN ".$this->db_plc0->dbprefix('div')." d ON t.idplc_div = d.idplc_div
				WHERE d.vCode = 'MKT' AND t.isDeleted = '0'";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		foreach($teams as $t) {
			$echo .= '<option value="'.$t['idplc_div_team'].'">'.$t['vName'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	function updateBox_daftar_upb_team_marketing($field, $id, $value, $rowData) {		
		$sql = "SELECT t.* FROM ".$this->db_plc0->dbprefix('div_team')." t 
				INNER JOIN ".$this->db_plc0->dbprefix('div')." d ON t.idplc_div = d.idplc_div
				WHERE d.vCode = 'MKT' AND t.isDeleted = '0'";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		foreach($teams as $t) {
			$selected = $rowData['idTeamMKT'] == $t['idplc_div_team'] ? 'selected' : '';
			$echo .= '<option '.$selected.' value="'.$t['idplc_div_team'].'">'.$t['vName'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}

	// function insertBox_daftar_upb_dokumen_bahan_baku($field, $id) {
		// $this->db_plc0->where('isDeleted', 0);
		// $this->db_plc0->order_by('vDocument', 'ASC');
		// $data['docs'] = $this->db_plc0->get('m_doc_bb')->result_array();
		// return $this->load->view('dokumen_bb',$data,TRUE);
	// }
	function insertBox_upb_daftar_dokumen_bahan_baku($field, $id) {
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('vdokumen', 'ASC');
		$data['docs'] = $this->db_plc0->get('plc2.plc2_upb_master_dokumen_bb')->result_array();
		return $this->load->view('upb_daftar_dokumen_bb',$data,TRUE);
	}
	
	function updateBox_upb_daftar_dokumen_bahan_baku($field, $id, $value, $rowData) {
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('vdokumen', 'ASC');
		$data['docs'] = $this->db_plc0->get('plc2.plc2_upb_master_dokumen_bb')->result_array();
		$data['isi'] = $rowData['txtDocBB'];
		return $this->load->view('upb_daftar_dokumen_bb_edit',$data,TRUE);
	}
	
	// function insertBox_daftar_upb_dokumen_standar_mutu($field, $id) {
		// $this->db_plc0->where('isDeleted', 0);
		// $this->db_plc0->order_by('vDocument', 'ASC');
		// $data['docs'] = $this->db_plc0->get('m_doc_sm')->result_array();
		// return $this->load->view('dokumen_sm',$data,TRUE);
	// }
	function insertBox_upb_daftar_dokumen_standar_mutu($field, $id) {
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('vdokumen', 'ASC');
		$data['docs'] = $this->db_plc0->get('plc2.plc2_upb_master_dokumen_sm')->result_array();
		return $this->load->view('upb_daftar_dokumen_sm',$data,TRUE);
	}
	
	function updateBox_upb_daftar_dokumen_standar_mutu($field, $id, $value, $rowData) {
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('vdokumen', 'ASC');
		$data['isi'] = $rowData['txtDocSM'];
		$data['docs'] = $this->db_plc0->get('plc2.plc2_upb_master_dokumen_sm')->result_array();
		return $this->load->view('upb_daftar_dokumen_sm_edit',$data,TRUE);
	}
	
	/* kayaknya sih gak kepake
	 * function insertBox_daftar_upb_komposisi_upb() {
		return $this->load->view('komposisi_upb','',TRUE);
	} */
	function insertBox_upb_daftar_komposisi_upb() {
		return $this->load->view('upb_daftar_komposisi_upb','',TRUE);
	}
	
/* kayaknya sih gak kepake	
 * function updateBox_daftar_upb_komposisi_upb() {
		return $this->load->view('komposisi_upb','',TRUE);
	}
	 */
	function updateBox_upb_daftar_komposisi_upb($field, $id, $value, $rowData) {
		$team=$this->auth_localnon->my_teams(TRUE);
		$data['teamnya']=$team[0];
		$data['teamupb']=$rowData['iteambusdev_id'];
		$data['iapp']=$rowData['iappbusdev'];
		$iupb_id=$rowData['iupb_id'];
		$sql="select k.ikomposisi_id, k.ijumlah, k.vsatuan, k.vketerangan, r.raw_id, r.vraw, r.vnama 
				from plc2.plc2_upb_komposisi k 
					inner join plc2.plc2_raw_material r on r.raw_id=k.raw_id
				where k.iupb_id=$iupb_id and k.ldeleted=0";
		$data['kompos'] =$this->db_plc0->query($sql)->result_array();
		$data['iupb_id']=$iupb_id;
		return $this->load->view('upb_daftar_komposisi_upb',$data,TRUE);
	}

	function insertBox_upb_daftar_komposisi_originator() {
		return $this->load->view('upb_daftar_komposisi_originator','',TRUE);
	}
	function updateBox_upb_daftar_komposisi_originator($field, $id, $value, $rowData) {
		//echo $id;
		$data['iapp']=$rowData['iappbusdev'];
		$team=$this->auth_localnon->my_teams(TRUE);
		$data['teamnya']=$team[0];
		$data['teamupb']=$rowData['iteambusdev_id'];
		$iupb_id=$rowData['iupb_id'];
		$sql="select ko.ikomposisi_id, ko.ijumlah, ko.vsatuan, ko.vfungsi, r.raw_id, r.vraw, r.vnama
				from plc2.plc2_upb_komposisi_ori ko 
					inner join plc2.plc2_raw_material r on r.raw_id=ko.raw_id
				where ko.iupb_id=$iupb_id and ko.ldeleted=0";
		$data['iupb_id']=$iupb_id;
		$data['kompor']=$this->db_plc0->query($sql)->result_array();
		
		return $this->load->view('upb_daftar_komposisi_originator',$data,TRUE);
	}
	
	function insertBox_daftar_upb_marketing_forecast() {
		return $this->load->view('marketing_forecast','',TRUE);
	}
	function insertBox_upb_daftar_marketing_forecast() {
		return $this->load->view('upb_daftar_marketing_forecast','',TRUE);
	}

	function updateBox_daftar_upb_marketing_forecast($field, $id, $value, $rowData) {
		$data['row1'] = $this->db_plc0->get_where('upb_forecast', array('idplc_master_upb' => $rowData['idplc_master_upb'], 'ino'=>1, 'ldeleted'=>0))->row_array();
		$data['row2'] = $this->db_plc0->get_where('upb_forecast', array('idplc_master_upb' => $rowData['idplc_master_upb'], 'ino'=>2, 'ldeleted'=>0))->row_array();
		$data['row3'] = $this->db_plc0->get_where('upb_forecast', array('idplc_master_upb' => $rowData['idplc_master_upb'], 'ino'=>3, 'ldeleted'=>0))->row_array();
		return $this->load->view('marketing_forecast_edit',$data,TRUE);
	}
	
	function updateBox_upb_daftar_marketing_forecast($field, $id, $value, $rowData) {
		$data['row1'] = $this->db_plc0->get_where('plc2.plc2_upb_forecast', array('iupb_id' => $rowData['iupb_id'], 'ino'=>1, 'ldeleted'=>0))->row_array();
		$data['row2'] = $this->db_plc0->get_where('plc2.plc2_upb_forecast', array('iupb_id' => $rowData['iupb_id'], 'ino'=>2, 'ldeleted'=>0))->row_array();
		$data['row3'] = $this->db_plc0->get_where('plc2.plc2_upb_forecast', array('iupb_id' => $rowData['iupb_id'], 'ino'=>3, 'ldeleted'=>0))->row_array();
		return $this->load->view('upb_daftar_marketing_forecast_edit',$data,TRUE);
	}
	/* public function manipulate_grid_button($button) {
		 	
		//unset($button['create']);
		
		$mydept=$this->auth_localnon->my_tipes();
		$artipe = explode(",",$mydept);
		if(in_array('BD',$artipe)){}else{unset($button['create']);}
		return $button;
		 
	} */
	 // public function listBox_Action($row, $actions) {
	 	// //jika BDM blm approve, upb rejected-> Dir gk bisa edit
	 	// if(($this->auth_localnon->is_dir()) && ($row->iappbusdev != 2) || ($row->istatus == 6)){
	 		// unset($actions['edit']);
	 		// unset($actions['delete']);
	 	// }
	 	// elseif($row->istatus == 7){ // kalo sudah finish (istatus==7) gak bisa di edit
	 		// unset($actions['edit']);
	 		// unset($actions['delete']);
	 	// }
	 	// else{}
	 	// return $actions;
	// } 

	 public function listBox_Action($row, $actions) {
	 	// //jika BDM blm approve, upb rejected-> Dir gk bisa edit
	 	// if(($this->auth_localnon->is_dir()) && ($row->iappbusdev != 2) || ($row->istatus == 6)){
	 		// unset($actions['edit']);
	 		// unset($actions['delete']);
	 	// }

	 	/*$mydept=$this->auth_localnon->tipe();
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			
			if(!in_array('BD', $manager)){
				 $type='BD';
				
				

				unset($actions['edit']);
			 	unset($actions['delete']);
		

			 }
			
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(!in_array('BD', $team)){
				$type='BD';
				unset($actions['edit']);
			 	unset($actions['delete']); 
			 }
			
		}*/

	 	if($row->istatus == 7){ // kalo sudah finish (istatus==7) gak bisa di edit
	 		 unset($actions['edit']);
	 		 unset($actions['delete']);
	 	} 
	 	
	 	// else{}
	 	 return $actions;
	 } 

	function manipulate_insert_button($buttons) {
		unset($buttons['save']);
		
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('BD', $manager)){$type='BD';
				$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'upb_daftar\', \''.base_url().'processor/plc/upb_daftar?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_daftar_upb">Save as Draft</button>';
				$save = '<button onclick="javascript:save_btn_multiupload(\'upb_daftar\', \''.base_url().'processor/plc/upb_daftar?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Save &amp; Submit</button>';
				$js = $this->load->view('upb_daftar_js');
				$buttons['save'] = $save_draft.$save.$js;
			/*
				$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'upb_daftar\', \''.base_url().'processor/plc/upb_daftar?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_daftar_upb">Save as Draft</button>';
				$save = '<button onclick="javascript:save_btn_multiupload(\'upb_daftar\', \''.base_url().'processor/plc/upb_daftar?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Save &amp; Submit</button>';
				$js = $this->load->view('upb_daftar_js');
				$buttons['save'] = $save_draft.$save.$js;
			*/
			}
			elseif(in_array('DR', $manager)){$type='DR';}
			else{$type='';}
			//echo $type;
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('BD', $team)){$type='BD';
				$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'upb_daftar\', \''.base_url().'processor/plc/upb_daftar?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_daftar_upb">Save as Draft</button>';
				$save = '<button onclick="javascript:save_btn_multiupload(\'upb_daftar\', \''.base_url().'processor/plc/upb_daftar?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Save &amp; Submit</button>';
				$js = $this->load->view('upb_daftar_js');
				$buttons['save'] = $save_draft.$save.$js;
			}
			elseif(in_array('DR', $team)){$type='DR';}
			else{$type='';}
		}
		return $buttons;
	}
	// function manipulate_update_button($buttons, $rowData) {
		// unset($buttons['update_back']);
		// unset($buttons['update']);
		// $js = $this->load->view('upb_daftar_js');
		// $user = $this->auth_localnon->user();
		
		// $laststat = $this->biz_process->get_last_status($rowData['iupb_id']);
		// //ubah di sini nya
		// $laststat2=$laststat['idplc2_status'];		
		
		// $lstat = $laststat2 == 3 ? $laststat2 : 1;
		
		// $bp = $this->biz_process->get($lstat, $this->auth_localnon->my_teams(),$this->input->get('modul_id'));
		// $n = $this->biz_process->get_next_process($rowData['iupb_id']);
		// $stat = $this->biz_process->get_last_status($rowData['iupb_id']);
		
		// if(empty($bp['idplc2_biz_process_sub'])) {
			// $struktur = '';
		// }	
		// else {
			// $struktur = $bp['idplc2_biz_process_sub'];
		// }
		// echo 'str='.$struktur.' n='.$n;
		// if($struktur == $n) {
			// unset($buttons['update_back']);
			// unset($buttons['update']);
			
			// /*  if($bp['vModuleOld'] == 'AppUPB-BD') {
				// $type = 'BD';
			// }
			// elseif($bp['vModuleOld'] == 'AppUPB-DR') {
				// $type = 'DR';
			// }
			// else {
				// $type = '';
			// } */ 
			// $x=$this->auth_localnon->dept();
			// if($this->auth_localnon->is_manager()){
	    		// $x=$this->auth_localnon->dept();
	    		// $manager=$x['manager'];
	    		// if(in_array('BD', $manager)){$type='BD';}
	    		// elseif(in_array('DR', $manager)){$type='DR';}
	    		// else{$type='';}
	    		
	    	// }
			// else{$type='';}
			
			// if($this->auth_localnon->is_manager()){
				// $update = '<button onclick="javascript:update_btn(\'upb_daftar\', \''.base_url().'processor/plc/upb/daftar?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
				// $approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/daftar?action=approve&upb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&sub_proses='.$struktur.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_daftar_upb">Approve</button>';
				// $reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/daftar?action=reject&upb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&sub_proses='.$struktur.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_daftar_upb">Reject</button>';
				
				
				// if($this->auth_localnon->is_dir()){
					// $buttons['update'] = $approve.$reject.$js;
				// }
				// else{
					// $revise = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/daftar?action=revice&upb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&sub_proses='.$struktur.'&status=2&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_daftar_upb">Revise</button>';
					// $buttons['update'] = $update.$approve.$reject.$revise.$js;
				// }
				// //array_unshift($buttons, $reject, $approve, $revise);
			// }
			// else{
			// }

			
		// }
		// else {
		
			// if($stat['idplc2_status'] == 7) {
			 	// unset($buttons['update_back']);
				// unset($buttons['update']);
			// }
			// elseif($stat['idplc2_status'] == 8) {
				// unset($buttons['update_back']);
				// unset($buttons['update']);
				// $save_draft = '<button onclick="javascript:update_draft_btn(\'upb_daftar\', \''.base_url().'upb_daftar\', this)" class="ui-button-text icon-save" id="button_save_draft_daftar_upb">Update as Draft</button>';
				// $update = '<button onclick="javascript:update_btn(\'upb_daftar\', \''.base_url().'processor/plc/upb/daftar?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update &amp; Submit</button>';
				
				// //array_unshift($buttons, $save_draft, $update);
				// $buttons['update'] =  $save_draft.$update.$js;
			// }
			// elseif($stat['idplc2_status'] == 3) {
				// unset($buttons['update_back']);
				// unset($buttons['update']);}
			// else {
				// unset($buttons['update_back']);
				// unset($buttons['update']);
			// }
		// }
		// return $buttons;
	// }
	
	 function manipulate_update_button($buttons, $rowData) {
		if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
		//echo $rowData['istatus'];
		//print_r($rowData);
		$user = $this->auth_localnon->user();
		$js = $this->load->view('upb_daftar_js');
		$upb_id=$rowData['iupb_id'];
		//$stat = $this->biz_process->get_last_status($rowData['iupb_id']);
		//print_r($stat);
		//if(isset($stat['idplc2_status'])){$laststatus=$stat['idplc2_status'];}
		unset($buttons['update_back']);
		unset($buttons['update']);
		
		if($this->auth_localnon->is_manager()){
			/*
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('BD', $manager)){$type='BD';}
			elseif(in_array('DR', $manager)){$type='DR';}
			else{$type='';}
			//echo $type;
			*/
			$x=$this->auth_localnon->dept();
			$mydept = $this->auth_localnon->my_depts(TRUE);
			//$team=$x['team'];
			if(in_array('BD', $mydept)){
				$type='BD';
				//echo $laststatus ;
				//echo "<br> appbusdev";
				//echo $rowData['iappbusdev'] ;
				//echo "<br> appdir";
				//echo $rowData['iappdireksi'];
				//echo "<br>";
				if(($rowData['istatus']==3)&&($rowData['iappbusdev']==2)&&($rowData['iappdireksi']==0)){
					if(in_array('DR', $mydept)){
						$type='DR';		
					}
				}
				
			}
			elseif(in_array('DR', $mydept)){$type='DR';}
			else{$type='';}

		}
		else{
			$x=$this->auth_localnon->dept();
			$mydept = $this->auth_localnon->my_depts(TRUE);

			//$team=$x['team'];
			if(in_array('BD', $mydept)){
				$type='BD';
				//echo $laststatus ;
				//echo "<br> appbusdev";
				//echo $rowData['iappbusdev'] ;
				//echo "<br> appdir";
				//echo $rowData['iappdireksi'];
				//echo "<br>";
				if(($rowData['istatus']==3)&&($rowData['iappbusdev']==2)&&($rowData['iappdireksi']==0)){
					if(in_array('DR', $mydept)){
						$type='DR';		
					}
				}
				
			}
			elseif(in_array('DR', $mydept)){$type='DR';}
			else{$type='';}
		}
			//tambahan cek tim upb sama apa nggak
			$teama=$this->auth_localnon->my_teams(TRUE);
			$teamnya=$teama[0];
			$teamupb=$rowData['iteambusdev_id'];
			//end tambahan cek tim upb sama apa nggak
			
			//echo $type; echo $teamupb; echo ' '.$teamnya.' '.$rowData['istatus'];
			//$arrhak=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
			//print_r($arrhak);
				
					if($rowData['ihold']==1){}
					elseif($this->auth_localnon->is_manager()){ //jika manager PR
						//jika manager BD atau DR
							//if(($laststatus==7)&&($type=='BD')&&($rowData['iappbusdev']==0)){ // status udah submit baru bisa approve dkk
							if(($rowData['istatus']==1)&&($type=='BD')&&($rowData['iappbusdev']==0)&&($teamupb==$teamnya)){ // status udah submit baru bisa approve dkk
								$update = '<button onclick="javascript:update_btn_back(\'upb_daftar\', \''.base_url().'processor/plc/upb/daftar?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/daftar?action=approve&upb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_daftar_upb">Approve</button>';
								$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/daftar?action=reject&upb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_daftar_upb">Reject</button>';
								//$cancelupb = '<button onclick="javascript:btn_cancel_upb(\'upb_daftar\', \''.base_url().'processor/plc/upb/daftar?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save">Cancel UPB</button>';
								$buttons['update'] = $update.$approve.$reject.$js;
							}
							//elseif(($laststatus==8)&&($type=='BD')&&($rowData['iappbusdev']==0)){ // status udah submit baru bisa approve dkk
							elseif(($rowData['istatus']==0)&&($type=='BD')&&($rowData['iappbusdev']==0)&&($teamupb==$teamnya)){ // status udah submit baru bisa approve dkk
								$updatedraft = '<button onclick="javascript:update_draft_btn(\'upb_daftar\', \''.base_url().'processor/plc/upb/daftar?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update as Draft</button>';
								$update = '<button onclick="javascript:update_btn_back(\'upb_daftar\', \''.base_url().'processor/plc/upb/daftar?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
								//$cancelupb = '<button onclick="javascript:btn_cancel_upb(\'upb_daftar\', \''.base_url().'processor/plc/upb/daftar?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save">Cancel UPB</button>';
								$buttons['update'] = $updatedraft.$update.$js;
							}
							//elseif(($laststatus==1)&&($type=='DR')&&($rowData['iappbusdev']==2)&&($rowData['iappdireksi']==0)){ // status busdev sudah app baru direksi bisa app/revise
							elseif(($rowData['istatus']==3)&&($type=='DR')&&($rowData['iappbusdev']==2)&&($rowData['iappdireksi']==0)){ // status busdev sudah app baru direksi bisa app/revise
								$update = '<button onclick="javascript:update_btn_back(\'upb_daftar\', \''.base_url().'processor/plc/upb/daftar?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
								
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/daftar?action=approve&upb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_daftar_upb">Approve</button>';
								$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/daftar?action=reject&upb_id='.$rowData['iupb_id'].'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_daftar_upb">Reject</button>';
								$buttons['update'] = $update.$approve.$reject.$js;
							}
							elseif(($rowData['ihold']==0)&&($type=='BD')&&($rowData['iappbusdev']==2)&&($teamupb==$teamnya)){ // status busdev sudah approve baru muncul cancel
								$cancelupb = '<button onclick="javascript:btn_cancel_upb(\'upb_daftar\', \''.base_url().'processor/plc/upb/daftar?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save">Cancel UPB</button>';
								$buttons['update'] = $cancelupb.$js;
							}
							else{}
						}
						else{
							//if(($laststatus==8)&&($type=='BD')&&($rowData['iappbusdev']==0)){ //staff busdev, bisa edit
							if(($rowData['istatus']==0)&&($type=='BD')&&($rowData['iappbusdev']==0)&&($teamupb==$teamnya)){ //staff busdev, bisa edit
								$update = '<button onclick="javascript:update_btn_back(\'upb_daftar\', \''.base_url().'processor/plc/upb/daftar?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update & Submit</button>';
								$updatedraft = '<button onclick="javascript:update_draft_btn(\'upb_daftar\', \''.base_url().'processor/plc/upb/daftar?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update as Draft</button>';
								$buttons['update'] = $update.$updatedraft.$js;
							}
							/*elseif(($laststatus==7)&&($type=='BD')&&($rowData['iappbusdev']==0)){ //staff busdev, bisa edit
							 elseif(($rowData['istatus']==0)&&($laststatus==7)&&($type=='BD')&&($rowData['iappbusdev']==0)){ //staff busdev, bisa edit
								 $update = '<button onclick="javascript:update_btn_back(\'upb_daftar\', \''.base_url().'processor/plc/upb/daftar?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
								 $buttons['update'] = $update.$js;
							 }*/
							else{}// jika staff busdev & sudah di supmit, tidak bisa edit
						}
				
				
		}
    	return $buttons;
	}
	
	function before_insert_processor($row, $postData) {
	
		if($postData['voriginator']==''){
			$postData['voriginator']='';
		}
		
		if(($postData['kom_bahan_id'][0])==""){
			//$o= "<script>alert('Change');</script> ";
			
			exit;
		}
		if(isset($postData['bb'])) {
			$bb = $postData['bb'];
			$new_bb = '';
			$i=1;
			foreach($bb as $k => $d) {
				if($i == count($bb)) {
					$new_bb .=$d;
				}
				else {
					$new_bb .=$d.',';
				}
				$i++;
			}
			$postData['txtDocBB'] = $new_bb;
		}
	
		if(isset($postData['sm'])) {
			$sm = $postData['sm'];
			$new_sm = '';
			$i=1;
			foreach($sm as $k => $d) {
				if($i == count($sm)) {
					$new_sm .=$d;
				}
				else {
					$new_sm .=$d.',';
				}
				$i++;
			}
			$postData['txtDocSM'] = $new_sm;
		}	
		
		$postData['ttarget_prareg'] = date('Y-m-d', strtotime($postData['upb_daftar_ttarget_prareg']));		
		
		$query = "SELECT MAX(iupb_id) std FROM plc2.plc2_upb";
		$rs = $this->db_plc0->query($query)->row_array();
		$nomor = intval($rs['std']) + 1;
		$nomor = "U".str_pad($nomor, 5, "0", STR_PAD_LEFT);
		$postData['vupb_nomor'] = $nomor;		
		
		// ubah status plc2_upb
		if($postData['isdraft']==true){
			$postData['istatus']=0;
		} 
		else{$postData['istatus']=1;
		//	$this->lib_flow->insert_logs($post['modul_id'],$nomor,1,0);
		} 
		
		//default ihold saat insert
		$postData['ihold']=0;

		if($postData['voriginator_price']<>""){
			$postData['voriginator_price']= str_replace(',', '', $postData['voriginator_price']);
		} 

		if($postData['vhpp_target']<>""){
			$postData['vhpp_target']= str_replace(',', '', $postData['upb_daftar_vhpp_target']);
		} 
		
		
		//print_r($postData);exit();
		return $postData;
	}

	function after_insert_processor ($row, $insertId, $postData) {
		
		//print_r($postData);
		//update tabel upb manual krn berhubungan dgn tipe data di grid
		$vhpp_target=$postData['vhpp_target'];
		$voriginator_price=$postData['voriginator_price'];
		$sqlu = "Update plc2.plc2_upb set vhpp_target = '".$vhpp_target."', voriginator_price='".$voriginator_price."' where iupb_id='".$insertId."'";	
		$this->db_plc0->query($sqlu);
		
		$user = $this->auth_localnon->user();
		
		for($i=1; $i<=3; $i++) {
			$m['iupb_id'] = $insertId;
			$m['ino'] = $i;
			$m['vyear'] = $postData['thn'.$i];
			$m['vunit'] = $postData['jum'.$i];
			$m['vforecast'] = $postData['for'.$i];
			$m['vincrement'] = $postData['inc'.$i];
			$this->db_plc0->insert('plc2.plc2_upb_forecast', $m);
		}
		
		// $status = empty($postData['isdraft']) ? 7 : 8;
		$status = empty($postData['isdraft']) ? 7 : 8;
		
		/*  insert  dokumen bb  */
		if(isset($postData['txtDocBB'])){
			// if(($postData['kom_bahan_id'][0])!=""){
				$valtemp = explode(',', $postData['txtDocBB']);
				foreach($valtemp as $k=>$v){
					$indokbb['iupb_id']=$insertId;
					$indokbb['idoc_id']=$v;
					$indokbb['ldeleted']=0;
					$this->db_plc0->insert('plc2.plc2_upb_detail_dokumen_bb', $indokbb);
				}
				//exit;
			// }
		}
		/* end of insert*/
		/*  insert  dokumen sm  */
		if(isset($postData['txtDocSM'])){
			// if(($postData['kom_bahan_id'][0])!=""){
				$valtemp = explode(',', $postData['txtDocSM']);
				foreach($valtemp as $k=>$v){
					$indoksm['iupb_id']=$insertId;
					$indoksm['idoc_id']=$v;
					$indoksm['ldeleted']=0;
					$this->db_plc0->insert('plc2.plc2_upb_detail_dokumen_sm', $indoksm);
				}
				//exit;
			// }
		}
		/* end of insert*/
		
		if(($postData['kom_bahan_id'][0])!=""){
			foreach($postData['kom_bahan_id'] as $k=>$v){
				$kom['iupb_id']=$insertId;
				$kom['raw_id']=$v;
				$kom['ijumlah']=$postData['kom_kekuatan'][$k];
				$kom['vsatuan']=$postData['kom_satuan'][$k];
				$kom['ibobot']=$k+1;
				$kom['vketerangan']=$postData['kom_fungsi'][$k];
				$this->db_plc0->insert('plc2.plc2_upb_komposisi', $kom);
			}
			//exit;
		}	
		/*  insert  komposisi originator */
		if(($postData['kor_bahan_id'][0])!=""){
			foreach($postData['kor_bahan_id'] as $k=>$v){
				$kor['iupb_id']=$insertId;
				$kor['raw_id']=$v;
				$kor['ijumlah']=$postData['kor_kekuatan'][$k];
				$kor['vsatuan']=$postData['kor_satuan'][$k];
				$kor['ibobot']=$k+1;
				$kor['vfungsi']=$postData['kor_fungsi'][$k];
				$this->db_plc0->insert('plc2.plc2_upb_komposisi_ori', $kor);
			}
			//exit;
		}

			$iupb_id=$insertId;
			
/*
remark 20160603 tidak pakai bizhub lagi 
			$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
			$hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,$status); // status 7 => submit
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, $status); // status 7 => submit
				//update last log
					$this->biz_process->update_last_log($iupb_id, $bizsup, $status);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, $status); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($iupb_id, $bizsup, $status);
			}
*/			
		// $this->biz_process->insert_log($insertId, 1, $status);
		// $this->biz_process->insert_last_log($insertId, 1, $status);	
		//return $o;
	}
	function before_update_processor($row, $postData, $newUpdateData) {
		//print_r($postData);
		if(isset($postData['bb'])) {
			$bb = $postData['bb'];
			$new_bb = '';
			$i=1;
			foreach($bb as $k => $d) {
				if($i == count($bb)) {
					$new_bb .=$d;
				}
				else {
					$new_bb .=$d.',';
				}			
				$i++;
			}
			$postData['txtDocBB'] = $new_bb;
		}
		// else{
			// $data['status']  = false;
			// $data['message'] = 'Isi dok BB';
			// return json_encode($data);
		// }
		//else{echo "<script>alert('harus isi dokumen bb');</script>";}
		
		if(isset($postData['sm'])) {
			$sm = $postData['sm'];
			$new_sm = '';
			$i=1;
			foreach($sm as $k => $d) {
				if($i == count($sm)) {
					$new_sm .=$d;
				}
				else {
					$new_sm .=$d.',';
				}			
				$i++;
			}
			$postData['txtDocSM'] = $new_sm;
		}
		
		unset($postData['cNip']);
		//unset($postData['ihold']);
		unset($postData['ttanggal']);

		unset($postData['dokumen_tambahan']);
		
		unset($postData['bb']);
		unset($postData['sm']);
		
		unset($postData['kom_bahan']);
		unset($postData['kom_kekuatan']);
		unset($postData['kom_satuan']);
		unset($postData['kom_fungsi']);
		
		unset($postData['kor_bahan']);
		unset($postData['kor_kekuatan']);
		unset($postData['kor_satuan']);
		unset($postData['kor_fungsi']);
		
		unset($postData['idfor1']);
		unset($postData['thn1']);
		unset($postData['jum1']);
		unset($postData['for1']);
		unset($postData['inc1']);
		unset($postData['idfor2']);
		unset($postData['thn2']);
		unset($postData['jum2']);
		unset($postData['for2']);
		unset($postData['inc2']);
		unset($postData['idfor3']);
		unset($postData['thn3']);
		unset($postData['jum3']);
		unset($postData['for3']);
		unset($postData['inc3']);
		
		unset($postData['fileketerangan']);
		unset($postData['filetanggal']);
		
		unset($postData['marketing_forecast']);
		
		$cek_upb= 'select * from plc2.plc2_upb a where a.iupb_id="'.$_POST['upb_daftar_iupb_id'].'"';
		$dcek_upb = $this->db_plc0->query($cek_upb)->row_array();
		
		$mydept=$this->auth_localnon->tipe();
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('DR',$manager)){}
			else{
				// ubah status plc2_upb
				if($postData['isdraft']==true){
					$postData['istatus']=0;
				} 
				else{$postData['istatus']=1;
					if ($dcek_upb['istatus']!=1) {
				//		$this->lib_flow->insert_logs($_GET['modul_id'],$_POST['upb_daftar_iupb_id'],1,0);
					}
					
				} 
			}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('DR',$team)){}
			else{
				// ubah status plc2_upb
				if($postData['isdraft']==true){
					$postData['istatus']=0;
				} 
				else{$postData['istatus']=1;
					if ($dcek_upb['istatus']!=1) {
					//	$this->lib_flow->insert_logs($_GET['modul_id'],$_POST['upb_daftar_iupb_id'],1,0);
					}
				} 
			
			}
			
		}
		
		
		$postData['ihold']=0;
		//print_r($postData); exit;
		
		unset($postData['draft']);
		
		$postData['ttarget_prareg'] = date('Y-m-d', strtotime($postData['ttarget_prareg']));

		if($postData['voriginator_price']<>""){
			$postData['voriginator_price']= str_replace(',', '', $postData['voriginator_price']);
		} 

		if($postData['vhpp_target']<>""){
			$postData['vhpp_target']= str_replace(',', '', $postData['upb_daftar_vhpp_target']);
		} 

		
		return $postData;
	}

	function after_update_processor ($row, $insertId, $postData, $old_data) {
		//echo $this->input->get('cancel');
		//print_r($postData);
		//$sqlc="select * from plc2.plc2_upb_dokumen_hold f where f.iupb_id=$insertId";
		//$cekfc=$this->db_plc0->query($sqlc)->num_rows();
		
		//echo 'ssss'.$cekfc;
		$mydept=$this->auth_localnon->tipe();
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('DR',$manager)){
				$type='BD';
				$sql_update = "update plc2.plc2_upb set iappbusdev ='2' where iupb_id ='".$insertId."'";
				$this->dbset->query($sql_update);
			}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('DR', $team)){
				$type='BD';
				$sql_update = "update plc2.plc2_upb set iappbusdev ='2' where iupb_id ='".$insertId."'";
				$this->dbset->query($sql_update);
			}
			
		}
			
		//if($postData['cancel_btn']==0){
			$user = $this->auth_localnon->user();
		
			//update tabel upb manual krn berhubungan dgn tipe data di grid
			$vhpp_target=$postData['vhpp_target'];
			$voriginator_price=$postData['voriginator_price'];
			$sqlu = "Update plc2.plc2_upb set vhpp_target = '".$vhpp_target."', voriginator_price='".$voriginator_price."' where iupb_id='".$insertId."'";	
			$this->db_plc0->query($sqlu);
			
			/* insert forecast	*/		
			$sql="select count(*) from plc2.plc2_upb_forecast f where f.iupb_id=$insertId";
			$cekf=$this->db_plc0->query($sql)->result_array();
			if($cekf > 0 ){
				$this->db_plc0->where('iupb_id', $insertId);
				$this->db_plc0->update('plc2.plc2_upb_forecast',array('ldeleted'=>1));
					
			}
			for($i=1; $i<=3; $i++) {
				//$m['idplc_master_upb'] = $insertId;
				$m['iupb_id'] = $insertId;
				$m['vyear'] = $postData['thn'.$i];
				$m['vunit'] = $postData['jum'.$i];
				$m['vforecast'] = $postData['for'.$i];
				$m['vincrement'] = $postData['inc'.$i];
				$m['ino'] = $i;
				$this->db_plc0->insert('plc2.plc2_upb_forecast', $m);
				
				//cek ada forecast atau tidak
				
				/* if(!empty($postData['idfor'.$i])) {
					$this->db_plc0->where('iforecast_id', $postData['idfor'.$i]);
					//$this->db_plc0->where('idplc_upb_forecast', $postData['idfor'.$i]);
					$this->db_plc0->update('plc2.plc2_upb_forecast', $m);
				} */
				
			}
			
			/*  insert  dokumen bb  */
			//cek isi awal
			$sql="select txtDocBB from plc2.plc2_upb k
			where k.iupb_id=$insertId and k.ldeleted=0";
			$dokbb =$this->db_plc0->query($sql)->row_array();
			//print_r($dokbb);
			$val = explode(',', $dokbb['txtDocBB']);
			
			
			if(isset($postData['txtDocBB'])){
				// if(($postData['kom_bahan_id'][0])!=""){
					foreach($val as $k=>$v){
						$this->db_plc0->where('iupb_id', $insertId);
						$this->db_plc0->update('plc2.plc2_upb_detail_dokumen_bb',array('ldeleted'=>1));
					}
					$valtemp = explode(',', $postData['txtDocBB']);
					foreach($valtemp as $k=>$v){
						$indokbb['iupb_id']=$insertId;
						$indokbb['idoc_id']=$v;
						$indokbb['ldeleted']=0;
						$this->db_plc0->insert('plc2.plc2_upb_detail_dokumen_bb', $indokbb);
					}
					//exit;
				// }
			}
			
			/*  insert  dokumen sm  */
			//cek isi awal
			$sql="select txtDocSM from plc2.plc2_upb k
			where k.iupb_id=$insertId and k.ldeleted=0";
			$dokbb =$this->db_plc0->query($sql)->row_array();
			//print_r($dokbb);
			$val = explode(',', $dokbb['txtDocSM']);
			
			
			if(isset($postData['txtDocSM'])){
				// if(($postData['kom_bahan_id'][0])!=""){
					foreach($val as $k=>$v){
						$this->db_plc0->where('iupb_id', $insertId);
						$this->db_plc0->update('plc2.plc2_upb_detail_dokumen_sm',array('ldeleted'=>1));
					}
					$valtemp = explode(',', $postData['txtDocSM']);
					foreach($valtemp as $k=>$v){
						$indoksm['iupb_id']=$insertId;
						$indoksm['idoc_id']=$v;
						$indoksm['ldeleted']=0;
						$this->db_plc0->insert('plc2.plc2_upb_detail_dokumen_sm', $indoksm);
					}
					//exit;
				// }
			}
			/*  insert  komposisi  */
			//cek isi awal
			$sql="select k.ikomposisi_id, r.raw_id
			from plc2.plc2_upb_komposisi k
			inner join plc2.plc2_raw_material r on r.raw_id=k.raw_id
			where k.iupb_id=$insertId and k.ldeleted=0";
			$kompos =$this->db_plc0->query($sql)->result_array();
			
			
			if(isset($postData['kom_bahan_id'])){
				if(($postData['kom_bahan_id'][0])!=""){
					foreach($kompos as $k=>$v){
						$this->db_plc0->where('ikomposisi_id', $v['ikomposisi_id']);
						$this->db_plc0->update('plc2.plc2_upb_komposisi',array('ldeleted'=>1));
					}
					foreach($postData['kom_bahan_id'] as $k=>$v){
						$kom['iupb_id']=$insertId;
						$kom['raw_id']=$v;
						$kom['ijumlah']=$postData['kom_kekuatan'][$k];
						$kom['vsatuan']=$postData['kom_satuan'][$k];
						$kom['ibobot']=$k+1;
						$kom['vketerangan']=$postData['kom_fungsi'][$k];
						$this->db_plc0->insert('plc2.plc2_upb_komposisi', $kom);
					}
					//exit;
				}
			}
			
			/*  insert  komposisi originator */
			
			//cek isi awal
			$sql="select k.ikomposisi_id, r.raw_id
			from plc2.plc2_upb_komposisi_ori k
			inner join plc2.plc2_raw_material r on r.raw_id=k.raw_id
			where k.iupb_id=$insertId and k.ldeleted=0";
			$kompor =$this->db_plc0->query($sql)->result_array();
			
			if(isset($postData['kor_bahan_id'])){
				if(($postData['kor_bahan_id'][0])!=""){
					foreach($kompor as $k=>$v){
						$this->db_plc0->where('ikomposisi_id', $v['ikomposisi_id']);
						$this->db_plc0->update('plc2.plc2_upb_komposisi_ori',array('ldeleted'=>1));
					}
					foreach($postData['kor_bahan_id'] as $k=>$v){
						$kor['iupb_id']=$insertId;
						$kor['raw_id']=$v;
						$kor['ijumlah']=$postData['kor_kekuatan'][$k];
						$kor['vsatuan']=$postData['kor_satuan'][$k];
						$kor['ibobot']=$k+1;
						$kor['vfungsi']=$postData['kor_fungsi'][$k];
						$this->db_plc0->insert('plc2.plc2_upb_komposisi_ori', $kor);
					}
					//exit;
				}
			}
			$d['idplc_master_upb'] = $insertId;
			$d['idplc_biz_process_sub'] = 1;

			// $status = empty($postData['isdraft']) ? 7 : 8;
			//tambahan ihold upb cancel
		// }
		// else
		// {
					// //$this->db_plc0->where('iupb_id', $insertId);
					// //$this->db_plc0->update('plc2.plc2_upb',array('ihold'=>1));
					// $dateT = date('Y-m-d H:i:s');
					// $sqlh = "update plc2.plc2_upb set ihold = 1, iholddate = '".$dateT."' where iupb_id = '".$insertId."'";
					// $this->db_plc0->query($sqlh);
					
		// }
		
		$mydept=$this->auth_localnon->tipe();
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('DR',$manager)){}
			else{
				
				$status = empty($postData['isdraft']) ? 7 : 8;
				$iupb_id=$insertId;
				/*$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
				$bizsup=$getbp['idplc2_biz_process_sub'];
			
				$hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,$status); // status 7 => submit
				if($hacek==1){ // jika sudah pernah ada data maka update saja
					//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, $status); // status 7 => submit
					//update last log
					$this->biz_process->update_last_log($iupb_id, $bizsup, $status);
				}
				elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, $status); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($iupb_id, $bizsup, $status);
				}*/
			
			
			}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('DR', $team)){}
			else{
				$status = empty($postData['isdraft']) ? 7 : 8;
				$iupb_id=$insertId;
				/*$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
				$bizsup=$getbp['idplc2_biz_process_sub'];
			
				$hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,$status); // status 7 => submit
				if($hacek==1){ // jika sudah pernah ada data maka update saja
					//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, $status); // status 7 => submit
					//update last log
					$this->biz_process->update_last_log($iupb_id, $bizsup, $status);
				}
				elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, $status); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($iupb_id, $bizsup, $status);
				}*/
			
			
			}
				/*
				$status = empty($postData['isdraft']) ? 7 : 8;
				$iupb_id=$insertId;
				$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
				$bizsup=$getbp['idplc2_biz_process_sub'];
			
				$hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,$status); // status 7 => submit
				if($hacek==1){ // jika sudah pernah ada data maka update saja
					//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, $status); // status 7 => submit
					//update last log
					$this->biz_process->update_last_log($iupb_id, $bizsup, $status);
				}
				elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, $status); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($iupb_id, $bizsup, $status);
				}
				*/
			
		}
		
			
	
	// //!!!!!!!!!!!!!!!!!!!!!!!!!!!!! insert status log !!!!!!!!!!!!!!!!!!!!!!!!!!//
	// //public function insert_log($upbid, $biz_sub, $status, $note = '', $approve = 0) {
		// $this->biz_process->insert_log($insertId, 1, $status);
	
	// //!!!!!!!!!!!!!!!!!!!!!!!!!!!!! insert status last !!!!!!!!!!!!!!!!!!!!!!!!!!//
	// //function insert_last_log($upbid, $biz_sub, $status, $note = '', $approve = 0)
		// $this->biz_process->insert_last_log($insertId, 1, $status);
	
	}

	function output(){
    	$this->index($this->input->get('action'));
    }
	
	function readDirektory($path, $empty="") {
		$filename = array();
		
		// if (!file_exists( $path )) {
			// mkdir( $path, 0777, true);						 
		// }
				
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
					$del = "delete from plc2.".$table." where iupb_id = {$lastId} and filename= '{$v}'";
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
			$sql = "SELECT filename from plc2.".$table." where iupb_id=".$lastId;
			//echo $sql;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['filename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT filename from plc2.".$table." where iupb_id=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM plc2.".$table." where iupb_id=".$lastId." and filename='".$row['filename']."'";			
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
