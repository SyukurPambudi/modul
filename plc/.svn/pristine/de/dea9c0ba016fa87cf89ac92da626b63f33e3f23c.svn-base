<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dossier_dokumen_td extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->load->library('lib_utilitas');
		$this->dbset = $this->load->database('plc', true);
		$this->dbset1 = $this->load->database('dosier', true);		
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Dokumen Tambahan');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_dok_td');		
		$grid->setUrl('dossier_dokumen_td');
		$grid->addList('vNo_req_td','dossier_upd.vUpd_no','dossier_upd.vNama_usulan');

		$grid->setSortBy('dossier_dok_td.idossier_dok_td_id');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('vNo_req_td','idossier_review_id','sediaan','nama_exist','team_andev','iTeam_sre',
			'memo_file','dtgldeadline','dok_file','history_td');

		//setting widht grid
		
		$grid->setWidth('vNo_req_td','100'); 
		
		
		$grid->setWidth('dossier_upd.C_CUNAM','300'); 
		$grid->setWidth('C_STATUS','100'); 
		$grid->setWidth('D_DATENT','100'); 
		$grid->setWidth('C_USERID','150'); 
		$grid->setWidth('C_CONFIRM','100'); 
		
		//modif label
		$grid->setLabel('vNo_req_td','No Request'); 
		
		$grid->setLabel('memo_file','File Memo TD Buyer/MOH'); 
		$grid->setLabel('dtgldeadline','Tanggal Deadline'); 
		$grid->setLabel('idossier_review_id','Kode Dossier'); 
		$grid->setLabel('dossier_upd.vUpd_no','Kode Dossier'); 
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Produk'); 
		$grid->setLabel('iTeam_sre','Team SRE'); 
		$grid->setLabel('iApprove','Status');
		$grid->setLabel('dAccepted_dok_td','Tgl Terima Dokumen'); 
		$grid->setLabel('cApprove','Approved by'); 
		
		$grid->setFormUpload(TRUE);
		$grid->setSearch('vNo_req_td','dossier_upd.vUpd_no','dossier_upd.vNama_usulan');
		
		// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iApprove','combobox','',array(''=>'Select one','0'=>'Waiting Approval','1'=>'Reject','2'=>'Approved'));
		$grid->setJoinTable('dossier.dossier_review', 'dossier_review.idossier_review_id = dossier_dok_td.idossier_review_id', 'inner');		
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id', 'inner');
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
				$post=$this->input->post();
				$isUpload = $this->input->get('isUpload');
   				if($isUpload) {
   					$lastId=$this->input->get('lastId');
   					$sql="select * from dossier.dossier_review rev
						inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
						#inner join dossier.dossier_upd_negara ne on ne.idossier_upd_id=up.idossier_upd_id
						inner join dossier.dossier_dok_td td on td.idossier_review_id=rev.idossier_review_id
						where rev.lDeleted=0 and up.lDeleted=0 
						#and ne.lDeleted=0
						and td.idossier_dok_td_id=".$lastId;
					//print_r($sql);
					$dn=$this->dbset1->query($sql);
					$vdok=array();
					$cpic=array();
					$dreq=array();
					$jmlrow=$dn->num_rows();
					if($jmlrow>=1){
						foreach ($dn->result_array() as $keyneg) {
							$vneg['idossier_negara_id'] = 0;
							$idneg=$vneg['idossier_negara_id'];
							foreach ($post as $kp => $vp) {
								if($kp=='cpic_dossier_dok_td'){
									foreach ($vp as $kn => $vn) {
										if($kn==$vneg['idossier_negara_id']){
											$cpic[$kn]=$vn;
										}
									}
								}
								if($kp=='dreq_dossier_dok_td'){
									foreach ($vp as $kn => $vn) {
										if($kn==$vneg['idossier_negara_id']){
											$dreq[$kn]=$vn;
										}
									}
								}	
							}
						}
						foreach ($dn->result_array() as $keyneg) {
							$vneg['idossier_negara_id']=0;
							$idneg=$vneg['idossier_negara_id'];
							$id=$lastId;
							$data['idossier_dok_td_id']=$lastId;
							$data['idossier_negara_id']=$idneg;
							foreach ($cpic as $kdok => $vdok) {
								if($kdok==$idneg){
									foreach ($vdok as $kdet => $vdet) {
										//$insertdoktd[]="INSERT INTO dossier.dossier_dok_td_detail (idossier_dok_td_id,idossier_negara_id,cpic,drequest,cCreated) VALUES (".$id.",".$idneg.",'".$vdet."','".date("Y-m-d")."','".$this->user->gNIP."')";
										//$data['cpic']=isset($cpic[$idneg][$kdet])?$cpic[$idneg][$kdet]:'';
										$data['cpic']=$vdet;
										$data['drequest']=date("Y-m-d");
										$data['dCreate']=date("Y-m-d");
										$data['cCreated']=$this->user->gNIP;
										$this->dbset1->insert('dossier_dok_td_detail',$data);
										$sql="select * from dossier.dossier_dok_td_detail det where det.idossier_dok_td_id=".$id." and det.idossier_negara_id=".$idneg." order by det.idossier_dok_td_detail_id DESC LIMIT 1 ";
										$dtlast=$this->dbset1->query($sql)->row_array();
										$path = realpath("files/plc/dossier_dok");
										if(!file_exists($path."/dossier_dok_memo/".$id."/".$dtlast['idossier_dok_td_detail_id'])){
											if (!mkdir($path."/dossier_dok_memo/".$id."/".$dtlast['idossier_dok_td_detail_id'], 0777, true)) { //id review
												die('Failed upload, try again!');
											}
										}
										$k=$kdet+1;

										$nmfile='fileupload_memo_dossier_dok_td'.$idneg.'_'.$k;
										if(isset($_FILES[$nmfile])){
											$namefile[$dtlast['idossier_dok_td_detail_id']]=$nmfile;
										}
										$vmemo='vdokumen_memo_dossier_dok_td'.$idneg.'_'.$k;
										if(isset($post[$vmemo])){
											$namememo[$dtlast['idossier_dok_td_detail_id']]=$vmemo;
										}
										$asal='vasal_memo_dossier_dok_td'.$idneg.'_'.$k;
										if(isset($post[$asal])){
											$nameasal[$dtlast['idossier_dok_td_detail_id']]=$asal;
										}
									}
								}
							}
						}
						if (isset($namefile))  {
							foreach ($namefile as $idossier_dok_td_detail_id => $vfile) {
								$i=0;
								foreach ($_FILES[$vfile]["error"] as $key => $error) {	
									if ($error == UPLOAD_ERR_OK) {
										$tmp_name = $_FILES[$vfile]["tmp_name"][$key];
										$name =$_FILES[$vfile]["name"][$key];
										$date = date('Y-m-d H:i:s');
										if(move_uploaded_file($tmp_name, $path."/dossier_dok_memo/".$lastId."/".$idossier_dok_td_detail_id."/".$name)) {
											$sqlinsert[]="INSERT INTO dossier.dossier_dok_td_memo_file (idossier_dok_td_detail_id, vFilename, dCreate, cCreated) 
													VALUES (".$idossier_dok_td_detail_id.",'".$name."','".$date."','".$this->user->gNIP."')";
											$i++;	
										}
										else{
											echo "Upload ke folder gagal";	
										}
									}
									
								}
							}
							foreach($sqlinsert as $sq) {
								try {
									$this->dbset->query($sq);
								}catch(Exception $e) {
									die($e);
								}
							}	

						}
						
						$path1 = realpath("files/plc/");
						if(!file_exists($path1."/export/memo_td_buyer_moh/".$lastId)){
							if (!mkdir($path1."/export/memo_td_buyer_moh/".$lastId, 0777, true)) { //id review
								die('Eror 2');
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

									if(move_uploaded_file($tmp_name1, $path1."/export/memo_td_buyer_moh/".$lastId."/".$name1)) {
										$sql1[]="INSERT INTO dossier.dossier_dok_td_memo_buyer (idossier_dok_td_id, vFilename, dCreate, cCreated, vKeterangan) 
												VALUES (".$lastId.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."','".$file_keterangan1[$i]."')";
										$i++;	
									}
									else{
										echo "Upload ke folder gagal";	
									}
							}
						}
						foreach($sql1 as $q11) {
							try {
								$this->dbset->query($q11);
								//echo "TestingSimpan";
							}catch(Exception $e) {
							die('Eror 1');
							}
						}


						$sql=array();
						if(isset($namememo)){
							foreach ($namememo as $idossier_dok_td_detail_id => $vmemo) {
								$sql[]=$vmemo;
								if(isset($post[$vmemo])){
									foreach ($post[$vmemo] as $kmemo => $vmemodet) {
										$sqlmemo[]="INSERT INTO dossier.dossier_dok_td_memo (idossier_dok_td_detail_id, vdok_td_memo, dCreate, cCreated)
												VALUES (".$idossier_dok_td_detail_id.",'".$vmemodet."','".$date."','".$this->user->gNIP."')";
									}
								}
							}
							foreach ($sqlmemo as $kmem) {
								try {
									$this->dbset->query($kmem);
								}catch(Exception $e) {
									die($e);
								}
							}
						}

						$sql=array();
						if(isset($nameasal)){
							foreach ($nameasal as $idossier_dok_td_detail_id => $asal) {
								$sql[]=$asal;
								if(isset($post[$asal])){
									foreach ($post[$asal] as $kasal => $vasalet) {
										//dossier_asal_dokumen
										$sqlasal[]="INSERT INTO dossier.dossier_asal_dokumen (idossier_dok_td_detail_id, vAsaldokumen, dCreate, cCreated)
												VALUES (".$idossier_dok_td_detail_id.",'".$vasalet."','".$date."','".$this->user->gNIP."')";
									}
								}
							}
							foreach ($sqlasal as $kmem) {
								try {
									$this->dbset->query($kmem);
								}catch(Exception $e) {
									die($e);
								}
							}
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

			case 'updatememo':
				$post=$this->input->post();
				$get=$this->input->get();
				$isUpload = $this->input->get('isUpload');
				$date = date('Y-m-d H:i:s');
				$nip=$this->user->gNIP;
				$idossier_dok_td_id=$post['dossier_dokumen_td_idossier_dok_td_id'];
				foreach ($post as $kpost => $vpost) {
					if($kpost=='idossier_dok_td_memo_id'){
						foreach ($vpost as $kdetpost => $vpostdet) {
							$idossier_dok_td_memo_id[$kdetpost]=$vpostdet;
						}
					}
					if($kpost=='vdokumen_memo_dossier_dok_td'){
						foreach ($vpost as $kdetpost => $vpostdet) {
							$vdokumen_memo_dossier_dok_td[$kdetpost]=$vpostdet;
						}
					}
					if($kpost=='vdokumen_memo_dossier_dok_td'){
						foreach ($vpost as $kdetpost => $vpostdet) {
							$vdokumen_memo_dossier_dok_td[$kdetpost]=$vpostdet;
						}
					}
					if($kpost=='cpic_dossier_dok_td'){
						foreach ($vpost as $kdetpost => $vpostdet) {
							$cpic_dossier_dok_td[$kdetpost]=$vpostdet;
						}
					}
					if($kpost=='iddet_dossier_dok_td'){
						foreach ($vpost as $kdetpost => $vpostdet) {
							$iddet_dossier_dok_td[$kdetpost]=$vpostdet;
						}
					}
					if($kpost=='idossier_dok_td_memo_file_id'){
						foreach ($vpost as $kdetpost => $vpostdet) {
							$idossier_dok_td_memo_file_id[$kdetpost]=$vpostdet;
						}
					}
					if($kpost=='ins_new_row_dossier_dok_td'){
						foreach ($vpost as $kdetpost => $vpostdet) {
							$ins_new_row_dossier_dok_td[$kdetpost]=$vpostdet;
						}
					}
				}

				if(isset($idossier_dok_td_memo_file_id)){
					foreach ($idossier_dok_td_memo_file_id as $kmemofile => $vmemofile) {
						$upfile="";
						$idossier_dok_td_detail_id=$kmemofile;
						$i=0;
						foreach ($vmemofile as $kmefile => $vmefile) {
							if($i==0){
								$upfile.=$vmefile;
							}else{
								$upfile.=",".$vmefile;
							}
							$i++;
						}
						if($upfile==""){
							$sqlup[]="UPDATE dossier.dossier_dok_td_memo_file fil SET fil.lDeleted=1, fil.dupdate='".$date."', fil.cUpdate='".$nip."' WHERE fil.idossier_dok_td_detail_id=".$idossier_dok_td_detail_id;
						}else{
							$sqlup[]="UPDATE dossier.dossier_dok_td_memo_file fil SET fil.lDeleted=1, fil.dupdate='".$date."', fil.cUpdate='".$nip."' WHERE fil.idossier_dok_td_detail_id=".$idossier_dok_td_detail_id." AND fil.idossier_dok_td_memo_file_id not in (".$upfile.")";
						}
					}
				}

				if(isset($idossier_dok_td_memo_id)){
					foreach ($idossier_dok_td_memo_id as $kmemo => $vmemo) {
						$upsql="";
						$idossier_dok_td_detail_id=$kmemo;
						$i=0;
						foreach ($vmemo as $kk => $vv) {
							if($i==0){
								$upsql.=$kk;
							}else{
								$upsql.=",".$kk;
							}
							$i++;
						}
						if($upsql==""){
							$sqlup[]="UPDATE dossier.dossier_dok_td_memo mem SET mem.lDeleted=1, mem.dupdate='".$date."', mem.cUpdate='".$nip."' WHERE mem.idossier_dok_td_detail_id=".$idossier_dok_td_detail_id;
						}else{
							$sqlup[]="UPDATE dossier.dossier_dok_td_memo mem SET mem.lDeleted=1, mem.dupdate='".$date."', mem.cUpdate='".$nip."' WHERE mem.idossier_dok_td_detail_id=".$idossier_dok_td_detail_id." AND mem.idossier_dok_td_memo_id not in (".$upsql.")";
						}
					}
					foreach ($post as $kpo => $vpo) {
						foreach ($idossier_dok_td_memo_id as $kidok => $vid) {
							
							if($kpo=='vdokumen_memo_dossier_dok_td_'.$kidok){
								foreach ($vpo as $kdetpost => $vpostdet) {
									$idinsertmemo[$kidok][]=$vpostdet;
								}
							}
						}
					}
				}

				if(isset($idinsertmemo)){
					foreach ($idinsertmemo as $kins => $vins) {
						foreach ($vins as $kvins => $vvins) {
							$sqlup[]="INSERT INTO dossier.dossier_dok_td_memo (idossier_dok_td_detail_id, vdok_td_memo, dCreate, cCreated) VALUES (".$kins.",'".$vvins."','".$date."','".$nip."')";
						}
					}
				}
				
				if(isset($vdokumen_memo_dossier_dok_td)){
					foreach ($vdokumen_memo_dossier_dok_td as $kvdok => $vvdok) {
						$sqlup[]="UPDATE dossier.dossier_dok_td_memo mem SET mem.vdok_td_memo='".$vvdok."', mem.dupdate='".$date."', mem.cUpdate='".$nip."' WHERE mem.idossier_dok_td_memo_id=".$kvdok;
					}
				}
				if(isset($iddet_dossier_dok_td)){
					
					foreach ($iddet_dossier_dok_td as $kiddet => $viddet) {
						$ups="";
						$idneg=$kiddet;
						$i=0;
						foreach ($viddet as $kvi => $vvi) {
							if($i==0){
								$ups.=$vvi;
							}else{
								$ups.=",".$vvi;
							}
							$i++;
						}
						if($ups==""){
							$sqlup[]="UPDATE dossier.dossier_dok_td_detail det SET det.lDeleted=1, det.cUpdate='".$nip."', det.dupdate='".$date."' WHERE det.idossier_negara_id=".$idneg;
						}else{
							$sqlup[]="UPDATE dossier.dossier_dok_td_detail det SET det.lDeleted=1, det.cUpdate='".$nip."', det.dupdate='".$date."' WHERE det.idossier_negara_id=".$idneg." AND det.idossier_dok_td_detail_id not in (".$ups.")";
						}
					}
				}
				if(isset($cpic_dossier_dok_td)){
					foreach ($cpic_dossier_dok_td as $kpic => $vpic) {
						$sqlup[]="UPDATE dossier.dossier_dok_td_detail det SET det.cpic='".$vpic."', det.dupdate='".$date."', det.cUpdate='".$nip."' WHERE det.idossier_dok_td_detail_id=".$kpic;
					}
				}
				if(isset($idossier_dok_td_memo_file_id)){
					foreach ($idossier_dok_td_memo_file_id as $ktdfile => $vtdfile) {
						$ups2="";
						$idossier_dok_td_detail_id=$ktdfile;
						$i=0;
						foreach ($vtdfile as $ktd => $vtd) {
							if($i==0){
								$ups2.=$vtd;
							}else{
								$ups2.=",".$vtd;
							}
							$i++;
						}
						if($ups2==""){
							$sqlup[]="UPDATE dossier.dossier_dok_td_memo_file det SET det.lDeleted=1, det.cUpdate='".$nip."', det.dupdate='".$date."' WHERE det.idossier_dok_td_detail_id=".$idossier_dok_td_detail_id;
						}else{
							$sqlup[]="UPDATE dossier.dossier_dok_td_memo_file det SET det.lDeleted=1, det.cUpdate='".$nip."', det.dupdate='".$date."' WHERE det.idossier_dok_td_detail_id=".$idossier_dok_td_detail_id." AND det.idossier_dok_td_memo_file_id not in (".$ups2.")";
						}
					}
				}
				foreach ($sqlup as $sqli ) {
					try {
						$this->dbset1->query($sqli);
					}catch(Exception $e) {
						die($e);
					}
				}
				if($isUpload){
					if(isset($iddet_dossier_dok_td)){
						foreach ($iddet_dossier_dok_td as $kiddet => $vidd) {
							foreach ($vidd as $ktd => $vtd) {
								$mninup="fileupload_memo_".$vtd;
								$path = realpath("files/plc/dossier_dok");
								if(!file_exists($path."/dossier_dok_memo/".$idossier_dok_td_id."/".$vtd)){
									if (!mkdir($path."/dossier_dok_memo/".$idossier_dok_td_id."/".$vtd, 0777, true)) { //id review
										die('Failed upload, try again!');
									}
								}

								if(isset($_FILES[$mninup])){
									$nmfiledok[$vtd]=$mninup;
								}


							}
						}
					}
					if(isset($nmfiledok)){
						foreach ($nmfiledok as $knm => $vnm) {
							$i=0;
							foreach ($_FILES[$vnm]["error"] as $key => $error) {	
								if ($error == UPLOAD_ERR_OK) {
									$tmp_name = $_FILES[$vnm]["tmp_name"][$key];
									$name =$_FILES[$vnm]["name"][$key];
									$date = date('Y-m-d H:i:s');
									if(move_uploaded_file($tmp_name, $path."/dossier_dok_memo/".$idossier_dok_td_id."/".$knm."/".$name)) {
										$sqlinsertq[]="INSERT INTO dossier.dossier_dok_td_memo_file (idossier_dok_td_detail_id, vFilename, dCreate, cCreated) 
												VALUES (".$knm.",'".$name."','".$date."','".$this->user->gNIP."')";
										$i++;	
									}
									else{
										echo "Upload ke folder gagal";	
									}
								}
								
							}

						}
						foreach ($sqlinsertq as $ksql) {
							try {
								$this->dbset1->query($ksql);
							}catch(Exception $e) {
								die($e);
							}
						}
					}
					if(isset($ins_new_row_dossier_dok_td)){
						foreach ($ins_new_row_dossier_dok_td as $idnegara => $viddet) {
							foreach ($viddet as $kurut => $vurut) {
								$cpic=$post['cpic_insert_dossier_dok_td'][$idnegara][$kurut];
								$datinsert['idossier_dok_td_id']=$idossier_dok_td_id;
								$datinsert['idossier_negara_id']=$idnegara;
								$datinsert['cpic']=$cpic;
								$datinsert['drequest']=$date;
								$datinsert['dCreate']=$date;
								$datinsert['cCreated']=$nip;
								$this->dbset1->insert('dossier.dossier_dok_td_detail', $datinsert);
								$qin="Select * from dossier.dossier_dok_td_detail det where det.idossier_dok_td_id=".$idossier_dok_td_id." and det.idossier_negara_id=".$idnegara." and det.lDeleted=0 ORDER BY det.idossier_dok_td_detail_id DESC LIMIT 1";
								$dt=$this->dbset1->query($qin)->row_array();
								foreach ($post as $kpo => $vpo) {
									if($kpo=='vdokumen_memo_dossier_dok_td'.$idnegara.'_'.$kurut){
										foreach ($vpo as $kdetpost => $vpostdet) {
											$vdokumen[$dt['idossier_dok_td_detail_id']][]=$vpostdet;
										}
									}
								}

								$path2 = realpath("files/plc/dossier_dok");
								if(!file_exists($path2."/dossier_dok_memo/".$idossier_dok_td_id."/".$dt['idossier_dok_td_detail_id'])){
									if (!mkdir($path2."/dossier_dok_memo/".$idossier_dok_td_id."/".$dt['idossier_dok_td_detail_id'], 0777, true)) { //id review
										die('Failed upload, try again!');
									}
								}
								$nmfile="fileupload_memo_dossier_dok_td".$idnegara."_".$kurut;
								if(isset($_FILES[$nmfile])){
									$filenewrowin[$dt['idossier_dok_td_detail_id']]=$nmfile;
								}
							}
						}
						foreach ($vdokumen as $id => $vdok) {
							foreach ($vdok as $kem => $vdok_mem) {

								$datinsertmem['idossier_dok_td_detail_id']=$id;
								$datinsertmem['vdok_td_memo']=$vdok_mem;
								$datinsertmem['dCreate']=$date;
								$datinsertmem['cCreated']=$nip;
								$insertmem[]="INSERT INTO dossier.dossier_dok_td_memo (idossier_dok_td_detail_id,vdok_td_memo,dCreate,cCreated) VALUES (".$id.",'".$vdok_mem."','".$date."','".$nip."')";
								//$this->dbset1->insert('dossier.dossier_dok_td_memo', $datinsertmem);
							}
						}
						foreach ($insertmem as $kmemos) {
							try {
								$this->dbset1->query($kmemos);
							}catch(Exception $e) {
								die($e);
							}
						}
						if(isset($filenewrowin)){
							foreach ($filenewrowin as $kfn => $vfn) {
								$i=0;
								foreach ($_FILES[$vfn]["error"] as $key => $error) {	
									if ($error == UPLOAD_ERR_OK) {
										$tmp_name = $_FILES[$vfn]["tmp_name"][$key];
										$name =$_FILES[$vfn]["name"][$key];
										$date = date('Y-m-d H:i:s');
										if(move_uploaded_file($tmp_name, $path."/dossier_dok_memo/".$idossier_dok_td_id."/".$kfn."/".$name)) {
											$sqlinsertr[]="INSERT INTO dossier.dossier_dok_td_memo_file (idossier_dok_td_detail_id, vFilename, dCreate, cCreated) 
													VALUES (".$kfn.",'".$name."','".$date."','".$this->user->gNIP."')";
											$i++;	
										}
										else{
											echo "Upload ke folder gagal";	
										}
									}
									
								}

							}
							foreach ($sqlinsertr as $ksqlr) {
								try {
									$this->dbset1->query($ksqlr);
								}catch(Exception $e) {
									die($e);
								}
							}
						}
					}
					
					$r['message']="Data Berhasil Disimpan";
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');					
					echo json_encode($r);
				}else{
					if(isset($post['isdraft'])){
						if($post['isdraft']==true){
							$dataupmain['iSubmit']=0;
						}else{
							$dataupmain['iSubmit']=1;
						}
					}else{
						$dataupmain['iSubmit']=1;
					}
					$dataupmain['dupdate']=$date;
					$dataupmain['cUpdate']=$nip;
					$this->dbset1->where('idossier_dok_td_id',$post['dossier_dokumen_td_idossier_dok_td_id']);
					$this->dbset1->update('dossier.dossier_dok_td',$dataupmain);
					$r['status'] = TRUE;
					$r['last_id'] = $post['dossier_dokumen_td_idossier_dok_td_id'];
					$r['foreign_id'] = '';
					$r['company_id'] = $get['company_id'];
					$r['group_id'] = $get['group_id'];
					$r['modul_id'] = $get['modul_id'];
					$r['message'] = "Data Updated Successfuly";		
					echo json_encode($r);	
				}
				break;
			case 'downloadmemo':
				$this->downloadmemo($this->input->get('file'));
				break;
			case 'downloaddok':
				$this->downloaddok($this->input->get('file'));
				break;
			case 'downloadmemotdbuyer':
				$this->downloadmemotdbuyer($this->input->get('file'));
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
				$post=$this->input->post();
				$idossier_dok_td_id=$post['dossier_dokumen_td_idossier_dok_td_id'];
				$iddet=array();
				$vdok=array();
				$cpic=array();

				$dataup['dupdate'] = date('Y-m-d H:i:s');
				$dataup['cUpdate'] =$this->user->gNIP;
				// ubah status submit
				if($post['isdraft']==true){
					$dataup['iSubmit']=0;
				} 
				else{$dataup['iSubmit']=1;}

				if(isset($post['dossier_dokumen_td_iTeam_sre'])){
					$dataup['iTeam_sre']=$post['dossier_dokumen_td_iTeam_sre'];
				}

				$this->dbset->where('idossier_dok_td_id',$idossier_dok_td_id);
				$this->dbset->update('dossier.dossier_dok_td',$dataup);

				foreach ($post as $kpost => $vpost) {
					if($kpost=="iddet_dossier_dok_td"){
						foreach ($vpost as $kp => $vp) {
							$iddet[$kp]=$vp;
						}
					}
					if($kpost=="vdok_dossier_dok_td"){
						foreach ($vpost as $kp => $vp) {
							$vdok[$kp]=$vp;
						}
					}
					if($kpost=="vketerangan_dossier_dok_td"){
						foreach ($vpost as $kp => $vp) {
							$vketerangan[$kp]=$vp;
						}
					}
					if($kpost=="cpic_dossier_dok_td"){
						foreach ($vpost as $kp => $vp) {
							$cpic[$kp]=$vp;
						}
					}
					
				}
				$sqlupdel=array();
				foreach ($iddet as $idnegara => $vdok1) {
					$iddet_im=implode(',', array_filter($vdok1));
					$sqlupdel[]="UPDATE dossier.dossier_dok_td_detail SET lDeleted=1 where idossier_negara_id=".$idnegara." and idossier_dok_td_id=".$idossier_dok_td_id." and idossier_dok_td_detail_id not in (".$iddet_im.")";
				}
				foreach($sqlupdel as $squpdel) {
					try {
						$this->dbset1->query($squpdel);
					}catch(Exception $e) {
						die($e);
					}
				}
				$sql=array();
				$date=date('Y-m-d H:i:s');
				$dreq=date('Y-m-d');
				$gnip=$this->user->gNIP;
				foreach ($vdok as $kdok => $valvdok) {
					$idnegara=$kdok;
					foreach ($valvdok as $kval => $vvd) {
						if(isset($iddet[$idnegara][$kval])){
							$sql[]="UPDATE dossier.dossier_dok_td_detail SET cNama_dokumen='".$vvd."', vketerangan='".$vketerangan[$idnegara][$kval]."', 
							cpic='".$cpic[$idnegara][$kval]."', drequest='".$dreq."', dupdate='".$date."', cUpdate='".$gnip."' where 
							idossier_dok_td_detail_id=".$iddet[$idnegara][$kval];
						}else{
							$sql[]="INSERT INTO dossier.dossier_dok_td_detail (idossier_dok_td_id, idossier_negara_id, cNama_dokumen, vketerangan, cpic, drequest, dCreate, cCreated) 
							VALUES ('".$idossier_dok_td_id."','".$idnegara."','".$vvd."','".$vketerangan[$idnegara][$kval]."','".$cpic[$idnegara][$kval]."','".$dreq."','".$date."','".$gnip."')";
						}
					}
				}
				
				foreach($sql as $sq) {
					try {
						$this->dbset1->query($sq);
					}catch(Exception $e) {
						die($e);
					}
				}

				


				$get=$this->input->get();
				$r['status'] = TRUE;
				$r['last_id'] = $idossier_dok_td_id;
				$r['foreign_id'] = '';
				$r['company_id'] = $get['company_id'];
				$r['group_id'] = $get['group_id'];
				$r['modul_id'] = $get['modul_id'];
				$r['message'] = "Data Updated Successfuly";		
				echo json_encode($r); exit();	
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
			case 'accept_dt':
				$post=$this->input->post();
				$get=$this->input->get();

				$skg=date('Y-m-d H:i:s');
				$this->db_plc0->where('idossier_dok_td_id', $post['dossier_dokumen_td_idossier_dok_td_id']);
				$this->db_plc0->update('dossier.dossier_dok_td', array('iApprove'=>2,'cApprove'=>$this->user->gNIP,'dApprove'=>$skg,'iTeam_sre'=>$post['dossier_dokumen_td_iTeam_sre']));

				
		    	$logged_nip =$this->user->gNIP;
				$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.vupb_nomor,c.vupb_nama,d.vName,b.dTanggal_upd,a.iSubmit_verify
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='SR' and te.ldeleted=0 and te.iteam_id=e.iTeam_sre) as sre
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='IM' and te.ldeleted=0) as im
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdi
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='IR' and te.ldeleted=0) as ir
						,e.dAccepted_dok_td,e.iSubmit_upload,e.dAccepted_req_td,e.iSubmit
						from dossier.dossier_review a 
						join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
						join plc2.plc2_upb c on c.iupb_id = b.idossier_upd_id
						join hrd.employee d on d.cNip=b.cNip_pengusul
						join dossier.dossier_dok_td e on e.idossier_review_id = a.idossier_review_id
						where e.idossier_dok_td_id = '".$post['dossier_dokumen_td_idossier_dok_td_id']."'";
				if($this->db_plc0->query($qupd)->num_rows()>0){
					$rupd = $this->db_plc0->query($qupd)->row_array();

				$submit = $rupd['iSubmit'] ;
				if ($rupd['ad'] == 74) {
					$iTeamandev = 'Andev 1';
				}else{
					$iTeamandev = 'Andev 2';
				}

				$ad = $rupd['ad'];
				$sre = $rupd['sre'];
				$im = $rupd['im'];
				$bdi = $rupd['bdi'];
				$ir = $rupd['ir'];
				//$team = $ad;

				$team=$ad;
				
				$logged_nip=$this->user->gNIP;
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
				$to = $arrEmail;
				$cc = $toEmail2.';'.$toEmail;   


				$subject="Dokumen Tambahan: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada inputan Dokumen Tambahan UPD  pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
								<td><b>UPB</b></td><td> : </td><td>".$rupd['vupb_nomor'].' - '.$rupd['vupb_nama']."</td>
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
				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Confirm Success!';
				echo json_encode($r);
				exit();
				break;
			case 'updateupload':
				$post=$this->input->post();
				$get=$this->input->get();
				$isUpload = $this->input->get('isUpload');
				$date = date('Y-m-d H:i:s');
				$nip=$this->user->gNIP;
				$idossier_dok_td_id=$post['dossier_dokumen_td_idossier_dok_td_id'];

				foreach ($post as $kpost => $vpost) {
					if($kpost=="dossier_dok_td_fileketerangan"){
						foreach ($vpost as $kdep => $vdep) {
							$vketerangan_upload[$kdep]=$vdep;
						}
					}
					if($kpost=="dossier_dok_td_sudah"){
						foreach ($vpost as $kdep => $vdep) {
							$dossier_dok_td_sudah[$kdep]=$vdep;
						}
					}
					if($kpost=="cek_1_keterangan"){
						foreach ($vpost as $kdep => $vdep) {
							$cek_1_keterangan[$kdep]=$vdep;
						}
					}
					if($kpost=="cek_1"){
						foreach ($vpost as $kdep => $vdep) {
							$cek_1[$kdep]=$vdep;
						}
					}
				}

				if($isUpload){
					foreach ($vketerangan_upload as $kvket => $vvket) {
						if(isset($_FILES['fileupload_dossier_dok_td'.$kvket])){
							$path = realpath("files/plc/dossier_dok");
							if (!file_exists( $path."/dossier_dok_td/".$kvket )) {
								mkdir($path."/dossier_dok_td/".$kvket, 0777, true);						 
							}
							foreach ($_FILES['fileupload_dossier_dok_td'.$kvket]["error"] as $key => $error) {
								if ($error == UPLOAD_ERR_OK) {
									$tmp_name = $_FILES['fileupload_dossier_dok_td'.$kvket]["tmp_name"][$key];
									$name = $_FILES['fileupload_dossier_dok_td'.$kvket]["name"][$key];
									$data['filename'] = $name;
					 				if(move_uploaded_file($tmp_name, $path."/dossier_dok_td/".$kvket."/".$name)) 
					 				{
										$sqlins[] = "INSERT INTO dossier.dossier_dok_td_file (idossier_dok_td_memo_id, vFilename, cCreated, dCreate) 
											VALUES ('".$kvket."','".$data['filename']."','".$nip."','".$nip."')";
									}
									else{
										echo "Upload ke folder gagal";	
									}
								}
							}
							if($sqlins){
								foreach($sqlins as $q) {
									try {
										$this->dbset->query($q);
									}catch(Exception $e) {
										die($e);
									}
								}
							}
							
						}
					}
					
					$r['status'] = TRUE;
					$r['message'] = 'Data Berhasil di Update';
					$r['last_id'] = $idossier_dok_td_id;					
					echo json_encode($r);
					exit();
				}else{
					if(isset($vketerangan_upload)){
						foreach ($vketerangan_upload as $kvket => $vvket) {
							if(isset($dossier_dok_td_sudah)){
								foreach ($dossier_dok_td_sudah as $ksudah => $vsudah) {
									if($kvket==$ksudah){
										$dt[$ksudah]=1;
									}
								}
							}
							
							$dtupdate['vketerangan']=$vvket;
							$dtupdate['dupdate']=$date;
							$dtupdate['cUpdate']=$nip;
							$this->dbset1->where('idossier_dok_td_memo_id',$kvket);
							$this->dbset1->update('dossier.dossier_dok_td_memo',$dtupdate);
						}
					}
					if(isset($cek_1_keterangan)){//Update Keterangan Cek Kelengkapan 1
						foreach ($cek_1_keterangan as $kcek1 => $vcek1) {
							$dtket['vKeterangan_td_kelengkapan1']=$vcek1;
							if(isset($cek_1)){//Approve or revise cek kelengkapan 1
								foreach ($cek_1 as $kccek1 => $vccek1) {
									if($kcek1==$kccek1){
										if($vccek1==1){
											$updaterevice[$kccek1]=1;
										}
										$dtket['istatus_td_kelengkapan1']=$vccek1;
									}
								}
							}
							$this->dbset1->where('idossier_dok_td_memo_id',$kcek1);
							$this->dbset1->update('dossier.dossier_dok_td_memo',$dtket);
						}
					}
					
					if(isset($updaterevice)){ //Update revice dari cek kelengkapan 1
						foreach ($updaterevice as $kuprev => $vuprev) {
							$dtserv['istatus_upload']=0;
							$dtserv['dupdate']=$date;
							$dtserv['cUpdate']=$nip;
							$this->dbset1->where('idossier_dok_td_memo_id',$kuprev);
							$this->dbset1->update('dossier.dossier_dok_td_memo',$dtserv);
						}
					}
					
					if(isset($dt)){
						foreach ($dt as $kt => $vt) {
							$this->dbset1->where('idossier_dok_td_memo_id',$kt);
							$this->dbset1->update('dossier.dossier_dok_td_memo',array('istatus_upload'=>1));
						}
					}
					$r['status'] = TRUE;
					$r['last_id'] = $get['id'];
					$r['foreign_id'] = 0;
					$r['company_id'] =$get['company_id'];
					$r['group_id'] = $get['group_id'];
					$r['modul_id'] = $get['modul_id'];
					$r['message'] = "Data Updated Successfuly";
					echo json_encode($r);
				}
				break;
			case 'updatecek2':
				$post=$this->input->post();
				$get=$this->input->get();
				$vketerangan=array();
				$istatus=array();
				foreach ($post as $kp => $vp) {
					if($kp=='cek_2_keterangan'){
						foreach ($vp as $kde => $vde) {
							$vketerangan[$kde]=$vde;
						}
					}
					if($kp=='cek_2'){
						foreach ($vp as $kde => $vde) {
							$istatus[$kde]=$vde;
						}
					}
				}
				if(count($vketerangan)>=1){
					foreach ($vketerangan as $kket => $vket) {
						if(isset($istatus[$kket])){
							if($istatus[$kket]==1){
								$delbeck[]="UPDATE dossier.dossier_dok_td_memo SET istatus_upload=0, istatus_td_kelengkapan1=0, iStatus_td_kelengkapan2=0, vKeterangan_td_kelengkapan2='".$vket."',
								dupdate='".date('Y-m-d H:i:s')."', cUpdate='".$this->user->gNIP."' WHERE idossier_dok_td_memo_id=".$kket;
							}else{
								$delbeck[]="UPDATE dossier.dossier_dok_td_memo SET iStatus_td_kelengkapan2=".$istatus[$kket].", vKeterangan_td_kelengkapan2='".$vket."',
								dupdate='".date('Y-m-d H:i:s')."', cUpdate='".$this->user->gNIP."' WHERE idossier_dok_td_memo_id=".$kket;
							}
						}else{
							$delbeck[]="UPDATE dossier.dossier_dok_td_memo SET iStatus_td_kelengkapan2=1, vKeterangan_td_kelengkapan2='".$vket."',
								dupdate='".date('Y-m-d H:i:s')."', cUpdate='".$this->user->gNIP."' WHERE idossier_dok_td_memo_id=".$kket;
						}
					}
					if(isset($delbeck)){
						foreach($delbeck as $qdel) {
							try {
								$this->dbset->query($qdel);
							}catch(Exception $e) {
								die($e);
							}
						}
					}
				}

				$r['status'] = TRUE;
				$r['last_id'] = $get['id'];
				$r['foreign_id'] = 0;
				$r['company_id'] =$get['company_id'];
				$r['group_id'] = $get['group_id'];
				$r['modul_id'] = $get['modul_id'];
				$r['message'] = "Data Updated Successfuly";
				echo json_encode($r);
				exit();
				break;
			case 'accept_dt_cek2':
				$post=$this->input->post();
				$get=$this->input->get();

				$skg=date('Y-m-d H:i:s');
				$this->db_plc0->where('idossier_dok_td_id', $post['dossier_dokumen_td_idossier_dok_td_id']);
				$this->db_plc0->update('dossier.dossier_dok_td', array('iapp_dok_td_cek2'=>2,'capp_dok_td_cek2'=>$this->user->gNIP,'dapp_dok_td_cek2'=>$skg));
				
				
		    	$logged_nip =$this->user->gNIP;
				$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.vupb_nomor,c.vupb_nama,d.vName,b.dTanggal_upd,a.iSubmit_verify
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='SR' and te.ldeleted=0 and te.iteam_id=e.iTeam_sre) as sre
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='IM' and te.ldeleted=0) as im
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdi
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='IR' and te.ldeleted=0) as ir
						,e.dAccepted_dok_td,e.iSubmit_upload,e.dAccepted_req_td,e.iSubmit
						from dossier.dossier_review a 
						join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
						join plc2.plc2_upb c on c.iupb_id = b.idossier_upd_id
						join hrd.employee d on d.cNip=b.cNip_pengusul
						join dossier.dossier_dok_td e on e.idossier_review_id = a.idossier_review_id
						where e.idossier_dok_td_id = '".$post['dossier_dokumen_td_idossier_dok_td_id']."'";
				$rupd = $this->db_plc0->query($qupd)->row_array();

				$submit = $rupd['iSubmit'] ;
				if ($rupd['ad'] == 74) {
					$iTeamandev = 'Andev 1';
				}else{
					$iTeamandev = 'Andev 2';
				}

				$ad = $rupd['ad'];
				$sre = $rupd['sre'];
				$im = $rupd['im'];
				$bdi = $rupd['bdi'];
				$ir = $rupd['ir'];
				//$team = $ad;

				$team=$bdi;
				
				$logged_nip=$this->user->gNIP;
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
				$to = $arrEmail;
				$cc = $toEmail2.';'.$toEmail;   


				$subject="Dokumen Tambahan-Cek Kelengkapan II: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada inputan Dokumen Tambahan UPD Cek Kelengkapan II pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
								<td><b>UPB</b></td><td> : </td><td>".$rupd['vupb_nomor'].' - '.$rupd['vupb_nama']."</td>
							</tr>
							<tr>
								<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
			    //$this->lib_utilitas->send_email($to, $cc, $subject, $content);

				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Confirm Success!';
				echo json_encode($r);
				exit();
				break;
			case 'updatecek3':
				$post=$this->input->post();
				$get=$this->input->get();
				$vketerangan=array();
				$istatus=array();
				$skg=date('Y-m-d H:i:s');
				foreach ($post as $kp => $vp) {
					if($kp=='cek_3_keterangan'){
						foreach ($vp as $kde => $vde) {
							$vketerangan[$kde]=$vde;
						}
					}
					if($kp=='cek_3'){
						foreach ($vp as $kde => $vde) {
							$istatus[$kde]=$vde;
						}
					}
				}
				if(count($vketerangan)>=1){
					$rev=0;
					foreach ($vketerangan as $kket => $vket) {
						if(isset($istatus[$kket])){
							if($istatus[$kket]==2){
								$updaterow[]="UPDATE dossier.dossier_dok_td_memo SET iStatus_td_kelengkapan3=".$istatus[$kket].", vKeterangan_td_kelengkapan3='".$vket."',
								dupdate='".date('Y-m-d H:i:s')."', cUpdate='".$this->user->gNIP."' WHERE idossier_dok_td_memo_id=".$kket; //update jika revice
								$updatebeck[]="UPDATE dossier.dossier_dok_td_memo SET iStatus_td_kelengkapan2=1, iStatus_td_kelengkapan3=1, vKeterangan_td_kelengkapan3='".$vket."',
								dupdate='".date('Y-m-d H:i:s')."', cUpdate='".$this->user->gNIP."' WHERE idossier_dok_td_memo_id=".$kket; //update jika revice
							}else{
								$rev++;
								$updatebeck[]="UPDATE dossier.dossier_dok_td_memo SET istatus_upload=0, istatus_td_kelengkapan1=0, iStatus_td_kelengkapan2=0, iStatus_td_kelengkapan3=".$istatus[$kket].", vKeterangan_td_kelengkapan3='".$vket."',
								dupdate='".date('Y-m-d H:i:s')."', cUpdate='".$this->user->gNIP."' WHERE idossier_dok_td_memo_id=".$kket; //update jika revice
							}
						}else{
							$rev++;
							$updatebeck[]="UPDATE dossier.dossier_dok_td_memo SET iStatus_td_kelengkapan3=1, vKeterangan_td_kelengkapan3='".$vket."',
							dupdate='".date('Y-m-d H:i:s')."', cUpdate='".$this->user->gNIP."' WHERE idossier_dok_td_memo_id=".$kket; //update jika revice
						}
					}
				
					if($rev!=0){
						if(isset($updatebeck)){
							foreach($updatebeck as $qdel) {
								try {
									$this->dbset->query($qdel);
								}catch(Exception $e) {
									die($e);
								}
							}
						}
						$this->db_plc0->where('idossier_dok_td_id', $get['id']);
						$this->db_plc0->update('dossier.dossier_dok_td', array('iapp_dok_td_cek2'=>0,'iapp_dok_td_cek3'=>0,'capp_dok_td_cek3'=>$this->user->gNIP,'dapp_dok_td_cek3'=>$skg));
					}elseif ($rev==0) {
							if(isset($updaterow)){
								foreach($updaterow as $qup) {
									try {
										$this->dbset->query($qup);
									}catch(Exception $e) {
										die($e);
									}
								}
							}
					}
				}

				$r['status'] = TRUE;
				$r['last_id'] = $get['id'];
				$r['foreign_id'] = 0;
				$r['company_id'] =$get['company_id'];
				$r['group_id'] = $get['group_id'];
				$r['modul_id'] = $get['modul_id'];
				$r['message'] = "Data Updated Successfuly";
				echo json_encode($r);
				exit();
				break;
			case 'accept_dt_cek3':
				$post=$this->input->post();
				$get=$this->input->get();

				$skg=date('Y-m-d H:i:s');
				$this->db_plc0->where('idossier_dok_td_id', $post['dossier_dokumen_td_idossier_dok_td_id']);
				$this->db_plc0->update('dossier.dossier_dok_td', array('iapp_dok_td_cek3'=>2,'capp_dok_td_cek3'=>$this->user->gNIP,'dapp_dok_td_cek3'=>$skg));
				
		    	$logged_nip =$this->user->gNIP;
				$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.vupb_nomor,c.vupb_nama,d.vName,b.dTanggal_upd,a.iSubmit_verify
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='SR' and te.ldeleted=0 and te.iteam_id=e.iTeam_sre) as sre
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='IM' and te.ldeleted=0) as im
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdi
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='IR' and te.ldeleted=0) as ir
						,e.dAccepted_dok_td,e.iSubmit_upload,e.dAccepted_req_td,e.iSubmit
						from dossier.dossier_review a 
						join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
						join plc2.plc2_upb c on c.iupb_id = b.idossier_upd_id
						join hrd.employee d on d.cNip=b.cNip_pengusul
						join dossier.dossier_dok_td e on e.idossier_review_id = a.idossier_review_id
						where e.idossier_dok_td_id = '".$post['dossier_dokumen_td_idossier_dok_td_id']."'";
				$rupd = $this->db_plc0->query($qupd)->row_array();

				$submit = $rupd['iSubmit'] ;
				if ($rupd['ad'] == 74) {
					$iTeamandev = 'Andev 1';
				}else{
					$iTeamandev = 'Andev 2';
				}

				$ad = $rupd['ad'];
				$sre = $rupd['sre'];
				$im = $rupd['im'];
				$bdi = $rupd['bdi'];
				$ir = $rupd['ir'];
				//$team = $ad;

				$team=$im;
				
				$logged_nip=$this->user->gNIP;
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
				$to = $arrEmail;
				$cc = $toEmail2.';'.$toEmail;   


				$subject="Dokumen Tambahan-Cek Kelengkapan III: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada inputan Dokumen Tambahan UPD Cek Kelengkapan III pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
								<td><b>UPB</b></td><td> : </td><td>".$rupd['vupb_nomor'].' - '.$rupd['vupb_nama']."</td>
							</tr>
							<tr>
								<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
			    //$this->lib_utilitas->send_email($to, $cc, $subject, $content);

				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Confirm Success!';
				echo json_encode($r);
				exit();
				break;
			case 'updatecek4':
				$post=$this->input->post();
				$get=$this->input->get();
				$vketerangan=array();
				$istatus=array();
				$skg=date('Y-m-d H:i:s');
				foreach ($post as $kp => $vp) {
					if($kp=='cek_4_keterangan'){
						foreach ($vp as $kde => $vde) {
							$vketerangan[$kde]=$vde;
						}
					}
					if($kp=='cek_4'){
						foreach ($vp as $kde => $vde) {
							$istatus[$kde]=$vde;
						}
					}
				}
				if(count($vketerangan)>=1){
					$rev=0;
					foreach ($vketerangan as $kket => $vket) {
						if(isset($istatus[$kket])){
							if($istatus[$kket]==2){
								$updaterow[]="UPDATE dossier.dossier_dok_td_memo SET iStatus_td_kelengkapan4=".$istatus[$kket].", vKeterangan_td_kelengkapan4='".$vket."',
								dupdate='".date('Y-m-d H:i:s')."', cUpdate='".$this->user->gNIP."' WHERE idossier_dok_td_memo_id=".$kket; //update jika revice
								$updatebeck[]="UPDATE dossier.dossier_dok_td_memo SET iStatus_td_kelengkapan2=1, iStatus_td_kelengkapan3=1, iStatus_td_kelengkapan4=1, vKeterangan_td_kelengkapan4='".$vket."',
								dupdate='".date('Y-m-d H:i:s')."', cUpdate='".$this->user->gNIP."' WHERE idossier_dok_td_memo_id=".$kket; //update jika revice
							}else{
								$rev++;
								$updatebeck[]="UPDATE dossier.dossier_dok_td_memo SET istatus_upload=0, istatus_td_kelengkapan1=0, iStatus_td_kelengkapan2=1, iStatus_td_kelengkapan3=1, iStatus_td_kelengkapan4=".$istatus[$kket].", vKeterangan_td_kelengkapan4='".$vket."',
								dupdate='".date('Y-m-d H:i:s')."', cUpdate='".$this->user->gNIP."' WHERE idossier_dok_td_memo_id=".$kket; //update jika revice
							}
						}else{
							$rev++;
							$updatebeck[]="UPDATE dossier.dossier_dok_td_memo SET iStatus_td_kelengkapan3=1,iStatus_td_kelengkapan4=1, vKeterangan_td_kelengkapan4='".$vket."',
							dupdate='".date('Y-m-d H:i:s')."', cUpdate='".$this->user->gNIP."' WHERE idossier_dok_td_memo_id=".$kket; //update jika revice
						}
					}
				
					if($rev!=0){
						if(isset($updatebeck)){
							foreach($updatebeck as $qdel) {
								try {
									$this->dbset->query($qdel);
								}catch(Exception $e) {
									die($e);
								}
							}
						}
						$this->db_plc0->where('idossier_dok_td_id', $get['id']);
						$this->db_plc0->update('dossier.dossier_dok_td', array('iapp_dok_td_cek2'=>0,'iapp_dok_td_cek3'=>0,'iapp_dok_td_cek4'=>0,'capp_dok_td_cek4'=>$this->user->gNIP,'dapp_dok_td_cek4'=>$skg));
					}elseif ($rev==0) {
							if(isset($updaterow)){
								foreach($updaterow as $qup) {
									try {
										$this->dbset->query($qup);
									}catch(Exception $e) {
										die($e);
									}
								}
							}
					}
				}

				$r['status'] = TRUE;
				$r['last_id'] = $get['id'];
				$r['foreign_id'] = 0;
				$r['company_id'] =$get['company_id'];
				$r['group_id'] = $get['group_id'];
				$r['modul_id'] = $get['modul_id'];
				$r['message'] = "Data Updated Successfuly";
				echo json_encode($r);
				exit();
				break;
			case 'accept_dt_cek4':
				$post=$this->input->post();
				$get=$this->input->get();

				$skg=date('Y-m-d H:i:s');
				$this->db_plc0->where('idossier_dok_td_id', $post['dossier_dokumen_td_idossier_dok_td_id']);
				$this->db_plc0->update('dossier.dossier_dok_td', array('iapp_dok_td_cek4'=>2,'capp_dok_td_cek4'=>$this->user->gNIP,'dapp_dok_td_cek4'=>$skg));
				
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

function listBox_Action($row, $actions) {
	/*
 	if ( ($row->dAccepted_dok_td!="") && ($row->dAccepted_dok_td != "0000-00-00" )) {
 		// status dokumen sudah diterima
 		 unset($actions['edit']);
 		 unset($actions['delete']);
 	}*/
 		if($row->iSubmit!=0){
 			unset($actions['delete']);
 		}
 		if($row->iapp_dok_td_cek4==2){
 			unset($actions['edit']);
 		}
	 return $actions;

} 

function searchBox_dossier_dokumen_td_C_STATUS($rowData, $id) {
		$o='<select id="upb_daftar_vkat_originator" class=" combobox" name="upb_daftar_vkat_originator">
				<option value="">--Select--</option>
				<option value="Confirmed">Confirmed</option>
				<option value="Need Confirmation">Need Confirmation</option>
			</select>';
		return $o;
}  


function listBox_dossier_dokumen_td_C_STATUS($value, $pk, $name, $rowData) {
	$rows = $this->db_plc0->get_where('dossier.dossier_dok_td', array('vNo_req_td'=>$pk))->row_array();
	$prod = $rows['D_DCONFPRD'];
	$ppic = $rows['D_DCONPPIC'];



	if ( ($value == "C")  or ( $prod<>"") or ($ppic<>"") ) {
		$setatus = 'Confirmed';
	}else{
		$setatus = 'Need Confirmation';
	}
	
	return $setatus;
	
}


/*manipulasi view object form start*/

function insertBox_dossier_dokumen_td_vNo_req_td($field, $id) {
	$return = 'Auto generate
				<input type="hidden" name="isdraft" id="isdraft">';

	return $return;
}
function insertBox_dossier_dokumen_td_dtgldeadline($field, $id){
	$mydept = $this->auth->my_depts(TRUE);
	$cNip= $this->user->gNIP;
	if($this->auth->is_manager()){
		$x=$this->auth->dept();
		$manager=$x['manager'];
		if(in_array('IR', $manager) || in_array('BDI', $manager) ){
			$req= "required";
			$typ = "";
		}
		else{
			$req= "";
			$typ = "disabled";
		}
	}

	$return = '<input '.$typ.' type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly" class="input_rows1 '.$req.'" size="8" />';
	$return .='<script>
				 $("#'.$id.'").datepicker({	changeMonth:true,
											changeYear:true,
											dateFormat:"yy-mm-dd" });
			</script>';
	return $return;
}
function updateBox_dossier_dokumen_td_dtgldeadline($field, $id, $value, $rowData) {
	if($this->input->get('action')=='view'){
		if($value<>'' || $value!="0000-00-00"){
			$dt = $value;
		}else{
			$dt = '';
		}

		$return	=$dt;

	}else{
		if($value<>'' || $value!="0000-00-00"){
			$dt = $value;
		}else{
			$dt = '';
		}

	$mydept = $this->auth->my_depts(TRUE);
	$cNip= $this->user->gNIP;
	if($this->auth->is_manager()){
		$x=$this->auth->dept();
		$manager=$x['manager'];
		if(in_array('IR', $manager) || in_array('BDI', $manager) ){
			$req= "required";
			$typ = "";
		}
		else{
			$req= "";
			$typ = "disabled";
		}
	}

	$return = '<input '.$typ.' name="'.$id.'" id="'.$id.'" type="text" readonly="readonly" class="input_rows1 '.$req.'" size="8" value='.$dt.' >';
	$return .=	'<script>
					$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
				</script>';
	}
	return $return;
}

function insertBox_dossier_dokumen_td_memo_file($field, $id){
	$data['date'] = date('Y-m-d H:i:s');	
	return $this->load->view('export/memo_td_file',$data,TRUE);
}
function updateBox_dossier_dokumen_td_memo_file($field, $id, $value, $rowData){
	$qr="select * from dossier.dossier_dok_td_memo_buyer where idossier_dok_td_id='".$rowData['idossier_dok_td_id']."' and lDeleted=0";
	$data['rows'] = $this->db_plc0->query($qr)->result_array();
	$data['date'] = date('Y-m-d H:i:s');	
	return $this->load->view('export/memo_td_file',$data,TRUE);
	//return $qr;
}

function updateBox_dossier_dokumen_td_vNo_req_td($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view' or $rowData['iApprove']==2) {
			$return= $value;
			$return.='<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';

		}
		else{
			$return= $value;
			$return .= '
			<input type="hidden" name="isdraft" id="isdraft">
			<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
		}
		
		return $return;
}

function insertBox_dossier_dokumen_td_idossier_review_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/dok/td?field=dossier_dokumen_td\',\'List UPD\')" type="button">&nbsp;</button>';                
		
		return $return;
}

function updateBox_dossier_dokumen_td_idossier_review_id($field, $id, $value, $rowData) {
	$sql = 'select * 
			from dossier.dossier_dok_td a 
			join dossier.dossier_review b on b.idossier_review_id = a.idossier_review_id
			join dossier.dossier_upd c on c.idossier_upd_id = b.idossier_upd_id
			where a.idossier_review_id="'.$rowData['idossier_review_id'].'" ';
	$data_upd = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view' or $rowData['iApprove']==2) {
		$return= $data_upd['vUpd_no'];
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		}else{

		if ($rowData['iSubmit'] == 0 ) {
			$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
			$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'].'"/>';
			//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/dok/td?field=dossier_dokumen_td\',\'List UPD\')" type="button">&nbsp;</button>';                
			
		}else{
			$return = '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			$return .= $data_upd['vUpd_no'];

		}
		
	}
	
	return $return;
}

function insertBox_dossier_dokumen_td_nama_produk($field, $id) {
	$return = '<input type="text" name="'.$id.'" class="required" readonly="TRUE" id="'.$id.'" class="input_rows1" size="20" />';
	return $return;
}

function updateBox_dossier_dokumen_td_nama_produk($field, $id, $value, $rowData) {
	$sql = 'select * 
			from dossier.dossier_dok_td a 
			join dossier.dossier_review b on b.idossier_review_id = a.idossier_review_id
			join dossier.dossier_upd c on c.idossier_upd_id = b.idossier_upd_id
			join plc2.plc2_upb d on d.iupb_id = c.iupb_id
			where a.idossier_review_id="'.$rowData['idossier_review_id'].'" ';
	$data_upd = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view' or $rowData['iApprove']==2) {
		$return= $data_upd['vNama_usulan'];

	}else{
		$return = '<input type="text" name="'.$id.'" class="required" readonly="TRUE" id="'.$id.'"  value="'.$data_upd['vNama_usulan'].'"  class="input_rows1" size="20" />';
	}
	
	return $return;
}

function insertBox_dossier_dokumen_td_dosis($field, $id) {
	$return = '<input type="text" name="'.$id.'" class="required" readonly="TRUE" id="'.$id.'" class="input_rows1" size="20" />';
	return $return;
}

function updateBox_dossier_dokumen_td_dosis($field, $id, $value, $rowData) {
	$sql = 'select * 
			from dossier.dossier_dok_td a 
			join dossier.dossier_review b on b.idossier_review_id = a.idossier_review_id
			join dossier.dossier_upd c on c.idossier_upd_id = b.idossier_upd_id
			join plc2.plc2_upb d on d.iupb_id = c.iupb_id
			where a.idossier_review_id="'.$rowData['idossier_review_id'].'" ';
	$data_upd = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view' or $rowData['iApprove']==2) {
		$return= $data_upd['dosis'];

	}else{
		$return = '<input type="text" name="'.$id.'" class="required" readonly="TRUE" id="'.$id.'"  value="'.$data_upd['dosis'].'"  class="input_rows1" size="20" />';
	}
	
	return $return;
}

function insertBox_dossier_dokumen_td_sediaan($field, $id) {
	$return = '<input type="text" name="'.$id.'" class="required" readonly="TRUE" id="'.$id.'" class="input_rows1" size="20" />';
	return $return;
}

function updateBox_dossier_dokumen_td_sediaan($field, $id, $value, $rowData) {
	$sql = 'select * 
			from dossier.dossier_dok_td a 
			join dossier.dossier_review b on b.idossier_review_id = a.idossier_review_id
			join dossier.dossier_upd c on c.idossier_upd_id = b.idossier_upd_id
			join plc2.plc2_upb d on d.iupb_id = c.iupb_id
			where a.idossier_review_id="'.$rowData['idossier_review_id'].'" ';
	$data_upd = $this->dbset->query($sql)->row_array();

	if ($data_upd['iSediaan'] == 1) {
			$iSediaan = "Solid";
		}else{
			$iSediaan = "Non Solid";
		}


	if ($this->input->get('action') == 'view' or $rowData['iApprove']==2) {
		$return= $iSediaan;

	}else{
		$return = '<input type="text" name="'.$id.'" class="required" readonly="TRUE" id="'.$id.'"  value="'.$iSediaan.'"  class="input_rows1" size="20" />';
	}
	
	return $return;
}


function insertBox_dossier_dokumen_td_no_upb($field, $id) {
	$return = '<input type="text" name="'.$id.'" class="required" readonly="TRUE" id="'.$id.'" class="input_rows1" size="20" />';
	return $return;
}

function updateBox_dossier_dokumen_td_no_upb($field, $id, $value, $rowData) {
	$sql = 'select * 
			from dossier.dossier_dok_td a 
			join dossier.dossier_review b on b.idossier_review_id = a.idossier_review_id
			join dossier.dossier_upd c on c.idossier_upd_id = b.idossier_upd_id
			join plc2.plc2_upb d on d.iupb_id = c.iupb_id
			where a.idossier_review_id="'.$rowData['idossier_review_id'].'" ';
	$data_upd = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view' or $rowData['iApprove']==2) {
		$return= $data_upd['vupb_nomor'];

	}else{
		$return = '<input type="text" name="'.$id.'" class="required" readonly="TRUE" id="'.$id.'"  value="'.$data_upd['vupb_nomor'].'"  class="input_rows1" size="20" />';
	}
	
	return $return;
}


function insertBox_dossier_dokumen_td_nama_exist($field, $id) {
	$return = '<input type="text" name="'.$id.'" class="required" readonly="TRUE" id="'.$id.'" class="input_rows1" size="20" />';
	return $return;
}

function updateBox_dossier_dokumen_td_nama_exist($field, $id, $value, $rowData) {
	$sql = 'select * 
			from dossier.dossier_dok_td a 
			join dossier.dossier_review b on b.idossier_review_id = a.idossier_review_id
			join dossier.dossier_upd c on c.idossier_upd_id = b.idossier_upd_id
			join plc2.plc2_upb d on d.iupb_id = c.iupb_id
			where a.idossier_review_id="'.$rowData['idossier_review_id'].'" ';
	$data_upd = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view' or $rowData['iApprove']==2) {
		$return= $data_upd['vupb_nama'];

	}else{
		$return = '<input type="text" name="'.$id.'" class="required" readonly="TRUE" id="'.$id.'"  value="'.$data_upd['vupb_nama'].'"  class="input_rows1" size="20" />';
	}
	
	return $return;
}



function insertBox_dossier_dokumen_td_team_andev($field, $id) {
	$return = '<input type="text" name="'.$id.'" class="required" readonly="TRUE" id="'.$id.'" class="input_rows1" size="20" />';
	return $return;
}

function updateBox_dossier_dokumen_td_team_andev($field, $id, $value, $rowData) {
	$sql = 'select * 
			from dossier.dossier_dok_td a 
			join dossier.dossier_review b on b.idossier_review_id = a.idossier_review_id
			join dossier.dossier_upd c on c.idossier_upd_id = b.idossier_upd_id
			join plc2.plc2_upb d on d.iupb_id = c.iupb_id
			where a.idossier_review_id="'.$rowData['idossier_review_id'].'" ';
	$data_upd = $this->dbset->query($sql)->row_array();

	if ($data_upd['iTeam_andev'] == 1) {
			$iTeam_andev = "Andev 1";
		}else{
			$iTeam_andev = "Andev 2";
		}


	if ($this->input->get('action') == 'view' or $rowData['iApprove']==2) {
		$return= $iTeam_andev;
		$return .='<input type="hidden" name="'.$id.'" class="required" readonly="TRUE" id="'.$id.'"  value="'.$iTeam_andev.'"  class="input_rows1" size="20" />';

	}else{
		$return = '<input type="text" name="'.$id.'" class="required" readonly="TRUE" id="'.$id.'"  value="'.$iTeam_andev.'"  class="input_rows1" size="20" />';
	}
	
	return $return;
}

function insertBox_dossier_dokumen_td_history_td($field, $id) {
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

function updateBox_dossier_dokumen_td_history_td($field, $id, $value, $rowData) {
	//$sql_doc='	select * from dossier.dossier_dok_td a where a.lDeleted = 0 and a.idossier_review_id = "'.$rowData['idossier_review_id'].'" and a.iapp_dok_td_cek4=2';
	$sql_doc='select td.*,up.*,td.cCreated as pengusul from dossier.dossier_dok_td td 
			inner join dossier.dossier_review rev on rev.idossier_review_id=td.idossier_review_id
			inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
			where td.lDeleted=0 and rev.lDeleted=0 and up.lDeleted=0 and td.iapp_dok_td_cek4=2
			and td.idossier_review_id='.$rowData['idossier_review_id'];
	$data['rows'] = $this->db_plc0->query($sql_doc)->result_array();
	$return ='';
	$return .= '
				<script type="text/javascript">
					$("label[for=\''.$id.'\']").hide();
					$("label[for=\''.$id.'\']").next().css("margin-left",0);
				</script>
			';
	$return .= '<div id="hist_dok_td_view"> ';
	$return .= $this->load->view('dossier_history_dok_td',$data,TRUE);
	$return .='</div>';
	return $return;
}



function insertBox_dossier_dokumen_td_dok_file($field, $id) {
		/*$data['mydept'] = $this->auth->my_depts(TRUE);
		$data['rows'] = "";
		$return=  $this->load->view('dossier_dokumen_td_file_create',$data,TRUE);	
		*/
		$return = "<div id='".$field."_dis'>Pilih UPD</div>";
		return $return;
}

function updateBox_dossier_dokumen_td_dok_file($field, $id, $value, $rowData) {
	    /*if ($rowData['dAccepted_req_td']=="") {
			
			$data['mydept'] = $this->auth->my_depts(TRUE);
			$sql_doc='	select * from dossier.dossier_dok_td_detail a where a.lDeleted = 0 and a.idossier_dok_td_id = "'.$rowData['idossier_dok_td_id'].'"	';
			$data['rows'] = $this->db_plc0->query($sql_doc)->result_array();
			$return=  $this->load->view('dossier_dokumen_td_file_create',$data,TRUE);	
		}else{

			$data['mydept'] = $this->auth->my_depts(TRUE);
			$sql_doc='	select * from dossier.dossier_dok_td_detail a where a.lDeleted = 0 and a.idossier_dok_td_id = "'.$rowData['idossier_dok_td_id'].'"	';
			$data['rows'] = $this->db_plc0->query($sql_doc)->result_array();
			$return=  $this->load->view('dossier_dokumen_td_file',$data,TRUE);	
		}*/
		$post=$this->input->post();
		$sql_negara="select * from dossier.dossier_upd_negara ne 
		inner join dossier.dossier_negara neg on neg.idossier_negara_id = ne.idossier_negara_id
		inner join dossier.dossier_review rev on rev.idossier_upd_id=ne.idossier_upd_id
		inner join dossier.dossier_dok_td doktd on doktd.idossier_review_id=rev.idossier_review_id
		where ne.lDeleted=0 and doktd.idossier_dok_td_id=".$rowData['idossier_dok_td_id'];
		$data['mnnegara'] = $this->dbset->query($sql_negara)->result_array();

		$sqlteam="select em.* from plc2.plc2_upb_team_item ite
			inner join plc2.plc2_upb_team te on ite.iteam_id=te.iteam_id
			inner join hrd.employee em on em.cNip=ite.vnip
			where ite.ldeleted=0 and te.ldeleted=0 and (te.vtipe='AD' OR te.vtipe='TD')";
		$data['pic']=$this->dbset2->query($sqlteam)->result_array();

		$sql_docs="select mem.*,det.idossier_negara_id,det.cpic,det.drequest from dossier.dossier_dok_td_memo mem
				inner join dossier.dossier_dok_td_detail det on det.idossier_dok_td_detail_id=mem.idossier_dok_td_detail_id
				inner join dossier.dossier_dok_td dok on dok.idossier_dok_td_id=det.idossier_dok_td_id
				where det.lDeleted=0 and mem.lDeleted=0 and dok.lDeleted=0 and dok.idossier_dok_td_id=".$rowData['idossier_dok_td_id'];
		//print_r($sql_docs);
		$data['docs']=$this->dbset1->query($sql_docs);
		
		$sql_ir_update="select * from dossier.dossier_dok_td_detail det where det.lDeleted=0 and det.idossier_dok_td_id=".$rowData['idossier_dok_td_id'];
		//print_r($sql_docs);

		
		$data_ir_update=$this->dbset1->query($sql_ir_update);
		$mydept = $this->auth->my_depts(TRUE);
	 	$type='';
	 	$return='';
	 	/*if (isset($mydept)) {
			if((in_array('BDI', $mydept))) {
				$type='BDI';
			}elseif((in_array('IR', $mydept))) {
				$type='IR';
			}elseif((in_array('AD', $mydept))){
				$type='AD';
			}elseif((in_array('IM', $mydept))){
				$type='IM';
			}
		}
		if($rowData['iApprove']==0 and $type=='IR'){
			$return .= $this->load->view('dossier_dokumen_td_update',$data,TRUE);
		}elseif($rowData['iApprove']==2 and $type=='AD'){
			$return .= $this->load->view('dossier_dokumen_td_upload',$data,TRUE);
		}elseif($rowData['iApprove']==2 and $type=='IR'){
			//$return .= $this->load->view('dossier_dokumen_td_cek2',$data,TRUE);
			$return	.='test';
		}elseif ($type=='BDI' && $rowData['iApprove']==2) {
			$return .= $this->load->view('dossier_dokumen_td_cek3',$data,TRUE);
		}elseif ($type=='IM' && $rowData['iApprove']==2) {
			$return .= $this->load->view('dossier_dokumen_td_cek4',$data,TRUE);
		}*/
		if($this->auth->is_manager()){
			$jabatan='2';
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('IR', $manager)){
				$type='IR';
			}elseif(in_array('AD', $manager)){
				$type='AD';
			}elseif(in_array('BDI', $manager)){
				$type='BDI';
			}elseif(in_array('IM', $manager)){
				$type='IM';
			}
			else{$type='';}
		}
		else{
			$jabatan='0';
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('IR', $team)){
				$type='IR';
			}elseif(in_array('AD', $team)){
				$type='AD';
			}elseif(in_array('BDI', $team)){
				$type='BDI';
			}elseif(in_array('IM', $team)){
				$type='IM';
			}
			else{$type='';}
		}
		if($jabatan=='2'){
			$data['jabatan']=2;
			if ($type=='IR') {
				if ($rowData['iApprove']==0) {
					$data['docs']=$data_ir_update;
					$return .= $this->load->view('dossier_dokumen_td_update',$data,TRUE);
				}elseif($rowData['iApprove']==2){
					$return .= $this->load->view('dossier_dokumen_td_cek2',$data,TRUE);
				}
			}
			elseif($type=='AD'){
				if($rowData['iApprove']==2){
					$return .= $this->load->view('dossier_dokumen_td_upload',$data,TRUE);
				}
			}
			elseif ($type=='BDI') {
				if($rowData['iApprove']==2){
					$return .= $this->load->view('dossier_dokumen_td_cek3',$data,TRUE);
				}
			}elseif($type=='IM'){
				if($rowData['iApprove']==2){
					$return .= $this->load->view('dossier_dokumen_td_cek4',$data,TRUE);
				}
			}

		}else{
			$data['jabatan']=1;
			if ($type=='IR') {
				if ($rowData['iApprove']==0) {
					$return .= $this->load->view('dossier_dokumen_td_update',$data,TRUE);
				}elseif($rowData['iApprove']==2){
					$return .= $this->load->view('dossier_dokumen_td_cek2',$data,TRUE);
				}
			}
			elseif($type=='AD'){
				if($rowData['iApprove']==2){
					$return .= $this->load->view('dossier_dokumen_td_upload',$data,TRUE);
				}
			}
			elseif ($type=='BDI') {
				if($rowData['iApprove']==2){
					$return .= $this->load->view('dossier_dokumen_td_cek3',$data,TRUE);
				}
			}elseif($type=='IM'){
				if($rowData['iApprove']==2){
					$return .= $this->load->view('dossier_dokumen_td_cek4',$data,TRUE);
				}
			}
		}
		return $return;
}

function insertBox_dossier_dokumen_td_iTeam_sre($field, $id) {
		$return = 'Save Record First !!!';
		return $return;
}

function updateBox_dossier_dokumen_td_iTeam_sre($field, $id, $value, $rowData) {
	$tim = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$value))->row_array();

	if ($this->input->get('action') == 'view' or $rowData['iApprove']==2) 
	{
			if (!empty($tim)) {
				$return= $tim['vteam'];	
			}else{
				$return= "-";
			}
			
	}else{
		if ($rowData['iSubmit']==0) {
			$return = 'Submit Request First !!!';	
		}else{
			// sudah di submit , pilih team SRE & update tanggal accept
			if ($rowData['dAccepted_req_td'] =="") {
					if ($value == "" or $value == "0" ) {
						$sql = "SELECT t.* FROM plc2.plc2_upb_team t
								WHERE t.vtipe = 'SR' AND t.ldeleted = '0' ";
				    	$teams = $this->db_plc0->query($sql)->result_array();
				    	$echo = '<select name="'.$id.'" id="'.$id.'" class="required">';
				    	$echo .= '<option value="">Select One</option>';
				    	foreach($teams as $t) {
				    		$echo .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
				    	}
				    	$echo .= '</select>';
						
					}else{
						
						$sql = "SELECT t.* FROM plc2.plc2_upb_team t
								WHERE t.vtipe = 'SR' AND t.ldeleted = '0' AND t.iteam_id IN (".$value.")";
				    	$teams = $this->db_plc0->query($sql)->result_array();
				    	$echo = '<select name="'.$id.'" id="'.$id.'" class="required">';
				    	$echo .= '<option value="">Select One</option>';
				    	foreach($teams as $t) {
				    		$selected = $rowData['iTeam_sre'] == $t['iteam_id'] ? 'selected' : '';
				    		$echo .= '<option '.$selected.' value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
				    	}
				    	$echo .= '</select>';
					}
						
    	

				$return = $echo;
				$return .= '<input type="hidden" name="dossier_dokumen_td_dAccepted_req_td" class="required" readonly="TRUE" id="dossier_dokumen_td_dAccepted_req_td"  value="'.date('Y-m-d').'"  class="input_rows1" size="10" />';				
			}else{
				$return = $tim['vteam'];
				$return .= '<input type="hidden" name="'.$id.'" class="required" readonly="TRUE" id="'.$id.'"  value="'.$value.'"  class="input_rows1" size="10" />';
				$return .= '<input type="hidden" name="dossier_dokumen_td_dAccepted_req_td" class="required" readonly="TRUE" id="dossier_dokumen_td_dAccepted_req_td"  value="'.date('Y-m-d').'"  class="input_rows1" size="10" />';				
			}
			
		}

	}
		
		return $return;
}

function insertBox_dossier_dokumen_td_dAccepted_dok_td($field, $id) {
		$return = 'Save Record First !!!';
		return $return;
}

function updateBox_dossier_dokumen_td_dAccepted_dok_td($field, $id, $value, $rowData) {

		if ($rowData['iSubmit_upload']==0) {
			$return = 'Upload Dokumen First !!!';	
		}else{
			// sudah di submit , pilih team SRE & update tanggal accept
			if ($rowData['dAccepted_dok_td'] =="") {
				$return='<input type="text" class="datepicker2" name="'.$id.'" id="'.$id.'" value="'.$value.'" size="8" maxlength="12" />';
				$return.='<script type="text/javascript">';
				$return.="$('.datepicker2').datepicker({
						changeMonth:true,
						changeYear:true,
						showButtonPanel:true,
						dateFormat:'yy-mm-dd',
						
					 });
					
					";
				$return.='</script>';

			}else{
				$return='<input type="text" class="datepicker2" name="'.$id.'" id="'.$id.'" value="'.$value.'" size="8" maxlength="12" />';
				$return.='<script type="text/javascript">';
				$return.="$('.datepicker2').datepicker({
						changeMonth:true,
						changeYear:true,
						showButtonPanel:true,
						dateFormat:'yy-mm-dd',
						
					 });
					
					";
				$return.='</script>';
	

			}
			
		}
		
		return $return;
}

function before_insert_processor($row, $postData) {
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreated'] =$this->user->gNIP;

	// ubah status submit
		if($postData['isdraft']==true){
			$postData['iSubmit']=0;
		} 
		else{$postData['iSubmit']=1;} 

	return $postData;

}

function before_update_processor($row, $postData) {
	//print_r($postData);
	//exit();
	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;
	// ubah status submit
	if(isset($postData['isdraft'])){
		if($postData['isdraft']==true){
			$postData['iSubmit']=0;
		} 
		else{$postData['iSubmit']=1;} 
	}

	return $postData;

}



function after_insert_processor($fields, $id, $post) {
		//update service_request autonumber No Brosur
		$nomor = "T".str_pad($id, 5, "0", STR_PAD_LEFT);
		$sql = "UPDATE dossier.dossier_dok_td SET vNo_req_td = '".$nomor."' WHERE idossier_dok_td_id=$id LIMIT 1";
		$query = $this->db_plc0->query( $sql );
		/*
		$det = array();		
		$this->db_plc0->where('idossier_dok_td_id', $id);
		if($this->db_plc0->update('dossier.dossier_dok_td_detail', array('lDeleted'=>1))) {
			foreach($post['namadokumen'] as $k=>$v) {
				
					if($v != '') {
						$det['idossier_dok_td_id'] = $id;
						$det['cNama_dokumen'] = $v;

						try {
							$this->db_plc0->insert('dossier.dossier_dok_td_detail', $det);
						}catch(Exception $e) {
							die('salah!');
						} 
					}
			}//exit;
		}*/

		//sampai disini
		$logged_nip =$this->user->gNIP;
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.vupb_nomor,c.vupb_nama,d.vName,b.dTanggal_upd,a.iSubmit_verify
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='SR' and te.ldeleted=0 and te.iteam_id=e.iTeam_sre) as sre
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='IM' and te.ldeleted=0) as im
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdi
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='IR' and te.ldeleted=0) as ir
				,e.dAccepted_dok_td,e.iSubmit_upload,e.dAccepted_req_td,e.iSubmit
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.plc2_upb c on c.iupb_id = b.idossier_upd_id
				join hrd.employee d on d.cNip=b.cNip_pengusul
				join dossier.dossier_dok_td e on e.idossier_review_id = a.idossier_review_id
				where e.idossier_dok_td_id = '".$id."'";
		if($this->db_plc0->query($qupd)->num_rows()>0){
			$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit'] ;
		if ($rupd['ad'] == 74) {
			$iTeamandev = 'Andev 1';
		}else{
			$iTeamandev = 'Andev 2';
		}

		$ad = $rupd['ad'];
		$sre = $rupd['sre'];
		$im = $rupd['im'];
		$bdi = $rupd['bdi'];
		$ir = $rupd['ir'];
		//$team = $ad;

		if ($rupd['dAccepted_dok_td'] != '') {
		//	$team = $ir. ','.$bdi. ','.$sre ;
				$team = $im ;
		}else if($rupd['iSubmit_upload'] == 1){
			$team = $im ;

		}else if($rupd['dAccepted_req_td'] !=""){
		//	$team = $ir. ','.$sre ;
				$team = $im ;
		}else if($rupd['iSubmit'] ==1){
		//	$team = $ir. ','.$bdi ;
				$team = $im ;
		}else{
			$team ='';
		}
		
		if ($submit == 1) {

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
			$to = $arrEmail;
			$cc = $toEmail2.';'.$toEmail;   
				$subject="Dokumen Tambahan: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada inputan Dokumen Tambahan UPD  pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
								<td><b>UPB</b></td><td> : </td><td>".$rupd['vupb_nomor'].' - '.$rupd['vupb_nama']."</td>
							</tr>
							<tr>
								<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
					//$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			}
		}
		

		


		

			
		

		
} 

function after_update_processor($row, $insertId, $post, $old_data) {
	//print_r($old_data);
	//exit();
	//dAccepted_dok_td
	/*if($old_data['dAccepted_req_td']==""){
		$det = array();		
		$this->db_plc0->where('idossier_dok_td_id', $insertId);
		if($this->db_plc0->update('dossier.dossier_dok_td_detail', array('lDeleted'=>1))) {
			foreach($post['namadokumen'] as $k=>$v) {
				
					if($v != '') {
						$det['idossier_dok_td_id'] = $insertId;
						$det['cNama_dokumen'] = $v;

						try {
							$this->db_plc0->insert('dossier.dossier_dok_td_detail', $det);
						}catch(Exception $e) {
							die('salah!');
						} 
					}
			}//exit;
		}
		
	} 

		//sampai disini
		$logged_nip =$this->user->gNIP;
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.vupb_nomor,c.vupb_nama,d.vName,b.dTanggal_upd,a.iSubmit_verify
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='SR' and te.ldeleted=0 and te.iteam_id=e.iTeam_sre) as sre
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='IM' and te.ldeleted=0) as im
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdi
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='IR' and te.ldeleted=0) as ir
				,e.dAccepted_dok_td,e.iSubmit_upload,e.dAccepted_req_td,e.iSubmit
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.plc2_upb c on c.iupb_id = b.idossier_upd_id
				join hrd.employee d on d.cNip=b.cNip_pengusul
				join dossier.dossier_dok_td e on e.idossier_review_id = a.idossier_review_id
				where e.idossier_dok_td_id = '".$insertId."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit'] ;
		if ($rupd['ad'] == 74) {
			$iTeamandev = 'Andev 1';
		}else{
			$iTeamandev = 'Andev 2';
		}

		$ad = $rupd['ad'];
		$sre = $rupd['sre'];
		$im = $rupd['im'];
		$bdi = $rupd['bdi'];
		$ir = $rupd['ir'];
		//$team = $ad;
		
		if($rupd['iSubmit'] ==1){
			$team = $ir. ','.$bdi ;
			//echo "4";
			//	$team = $im ;
		}else{
			$team ='';
		}
		

		

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
		//$to = $arrEmail;
		//$cc = $toEmail2.';'.$toEmail;   
		
		$cc = $arrEmail;
		$to = $toEmail2.';'.$toEmail;   


				$subject="Dokumen Tambahan: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada inputan Dokumen Tambahan UPD  pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
								<td><b>UPB</b></td><td> : </td><td>".$rupd['vupb_nomor'].' - '.$rupd['vupb_nama']."</td>
							</tr>
							<tr>
								<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				//$this->lib_utilitas->send_email($to, $cc, $subject, $content);
	*/

}



function manipulate_insert_button($buttons) {
	unset($buttons['save']);
	$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'dossier_dokumen_td\', \''.base_url().'processor/plc/dossier/dokumen/td?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_dossier_dokumen_td">Save as Draft</button>';
	$save = '<button onclick="javascript:save_btn_multiupload(\'dossier_dokumen_td\', \''.base_url().'processor/plc/dossier/dokumen/td?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Save &amp; Submit</button>';
	$js = $this->load->view('dossier_dokumen_td_file_js');
	$js .= $this->load->view('uploadjs');
	$buttons['save'] = $save_draft.$save.$js;

	return $buttons;
}



function manipulate_update_button($buttons, $rowData) {
	$mydept = $this->auth->my_depts(TRUE);
	$cNip= $this->user->gNIP;
	$js = $this->load->view('dossier_dokumen_td_file_js');
	$js .= $this->load->view('uploadjs');

	$type='';
	$jabatan='';
	if($this->auth->is_manager()){
		$jabatan='2';
		$x=$this->auth->dept();
		$manager=$x['manager'];
		if(in_array('IR', $manager)){
			$type='IR';
		}elseif(in_array('AD', $manager)){
			$type='AD';
		}elseif(in_array('BDI', $manager)){
			$type='BDI';
		}elseif(in_array('IM', $manager)){
			$type='IM';
		}
		else{$type='';}
	}
	else{
		$jabatan='0';
		$x=$this->auth->dept();
		$team=$x['team'];
		if(in_array('IR', $team)){
			$type='IR';
		}elseif(in_array('AD', $team)){
			$type='AD';
		}elseif(in_array('BDI', $team)){
			$type='BDI';
		}elseif(in_array('IM', $team)){
			$type='IM';
		}
		else{$type='';}
	}

	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/dossier/dokumen/td?action=approve&idossier_dok_td_id='.$rowData['idossier_dok_td_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_dossier_dokumen_td">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/dossier/dokumen/td?action=reject&idossier_dok_td_id='.$rowData['idossier_dok_td_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_dossier_dokumen_td">Reject</button>';

	$updatedraft = '<button onclick="javascript:update_draft_memo(\'dossier_dokumen_td\', \''.base_url().'processor/plc/dossier/dokumen/td?company_id='.$this->input->get('company_id').'&isdraft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true, \''.base_url().'processor/plc/dossier/dokumen/td?action=updatememo&id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'&lastId='.$this->input->get('id').'\')" class="ui-button-text icon-save" id="button_save_dossier_dokumen_td">Update as Draft</button>';
	$update = '<button onclick="javascript:update_memo(\'dossier_dokumen_td\', \''.base_url().'processor/plc/dossier/dokumen/td?company_id='.$this->input->get('company_id').'&isdraft=false&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true, \''.base_url().'processor/plc/dossier/dokumen/td?action=updatememo&id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'&lastId='.$this->input->get('id').'\')" class="ui-button-text icon-save" id="button_save_dossier_dokumen_td">Update & Submit</button>';
	
	$updateupload = '<button onclick="javascript:updateupload(\'dossier_dokumen_td\', \''.base_url().'processor/plc/dossier/dokumen/td?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, \''.base_url().'processor/plc/dossier/dokumen/td?action=updateupload&id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'&lastId='.$this->input->get('id').'\')" class="ui-button-text icon-save" id="button_save_dossier_dokumen_td">Update</button>';
	
	$updatecek2 = '<button onclick="javascript:updatecek2(\'dossier_dokumen_td\', \''.base_url().'processor/plc/dossier/dokumen/td?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, \''.base_url().'processor/plc/dossier/dokumen/td?action=updatecek2&id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'&lastId='.$this->input->get('id').'\')" class="ui-button-text icon-save" id="button_save_dossier_dokumen_td">Update</button>';

	$accept = '<button onclick="javascript:accept(\'dossier_dokumen_td\', \''.base_url().'processor/plc/dossier/dokumen/td?action=accept_dt&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$this->input->get('id').')" class="ui-button-text icon-save" id="button_save_dossier_dokumen_td">Confirm</button>';

	$accept2 = '<button onclick="javascript:accept_cek2(\'dossier_dokumen_td\', \''.base_url().'processor/plc/dossier/dokumen/td?action=accept_dt_cek2&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$this->input->get('id').')" class="ui-button-text icon-save" id="button_save_dossier_dokumen_td">Confirm</button>';

	$updatecek3 = '<button onclick="javascript:updatecek3(\'dossier_dokumen_td\', \''.base_url().'processor/plc/dossier/dokumen/td?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, \''.base_url().'processor/plc/dossier/dokumen/td?action=updatecek3&id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'&lastId='.$this->input->get('id').'\')" class="ui-button-text icon-save" id="button_save_dossier_dokumen_td">Update</button>';
	
	$accept3 = '<button onclick="javascript:accept_cek3(\'dossier_dokumen_td\', \''.base_url().'processor/plc/dossier/dokumen/td?action=accept_dt_cek3&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$this->input->get('id').')" class="ui-button-text icon-save" id="button_save_dossier_dokumen_td">Confirm</button>';

	$updatecek4 = '<button onclick="javascript:updatecek4(\'dossier_dokumen_td\', \''.base_url().'processor/plc/dossier/dokumen/td?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, \''.base_url().'processor/plc/dossier/dokumen/td?action=updatecek4&id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'&lastId='.$this->input->get('id').'\')" class="ui-button-text icon-save" id="button_save_dossier_dokumen_td">Update</button>';
	
	$accept4 = '<button onclick="javascript:accept_cek4(\'dossier_dokumen_td\', \''.base_url().'processor/plc/dossier/dokumen/td?action=accept_dt_cek4&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$this->input->get('id').')" class="ui-button-text icon-save" id="button_save_dossier_dokumen_td">Confirm</button>';


	if ($this->input->get('action') == 'view') {unset($buttons['update']);}

	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if($jabatan=='2'){
			if ($type=='IR') {
				if ($rowData['iSubmit']== 0) {
					$buttons['update'] = $update.$updatedraft.$js;
				}else{
					if($rowData['iApprove']!=2){
						$buttons['update'] = $accept.$js;
					}elseif($rowData['iApprove']==2 && $rowData['iapp_dok_td_cek2']==0){
						$sql="select * from dossier.dossier_dok_td_memo mem 
							inner join dossier.dossier_dok_td_detail dosi on dosi.idossier_dok_td_detail_id=mem.idossier_dok_td_detail_id 
							where dosi.lDeleted=0 and mem.lDeleted=0 and mem.iStatus_td_kelengkapan2!=2 and dosi.idossier_dok_td_id=".$rowData['idossier_dok_td_id'];
						if($this->dbset1->query($sql)->num_rows()>=1){
							$buttons['update'] = $updatecek2.$js;
						}elseif($this->dbset1->query($sql)->num_rows()==0){
							$buttons['update'] = $updatecek2.$accept2.$js;
						}

					}
				}
			}
			elseif($type=='AD'){
				if($rowData['iApprove']==2){
					$buttons['update']=$updateupload.$js;
				}
			}
			elseif ($type=='BDI') {
				if($rowData['iapp_dok_td_cek2']==2 && $rowData['iapp_dok_td_cek3']==0){
					$sql="select * from dossier.dossier_dok_td_memo mem 
							inner join dossier.dossier_dok_td_detail dosi on dosi.idossier_dok_td_detail_id=mem.idossier_dok_td_detail_id 
							where dosi.lDeleted=0 and mem.lDeleted=0 and mem.iStatus_td_kelengkapan3!=2 and dosi.idossier_dok_td_id=".$rowData['idossier_dok_td_id'];
					if($this->dbset1->query($sql)->num_rows()>=1){
						$buttons['update']=$updatecek3.$js;
					}elseif($this->dbset1->query($sql)->num_rows()==0){
						$buttons['update']=$updatecek3.$accept3.$js;
					}
				}
			}elseif($type=='IM'){
				if($rowData['iapp_dok_td_cek3']==2 && $rowData['iapp_dok_td_cek4']==0){
					$sql="select * from dossier.dossier_dok_td_memo mem 
							inner join dossier.dossier_dok_td_detail dosi on dosi.idossier_dok_td_detail_id=mem.idossier_dok_td_detail_id 
							where dosi.lDeleted=0 and mem.lDeleted=0 and mem.iStatus_td_kelengkapan4!=2 and dosi.idossier_dok_td_id=".$rowData['idossier_dok_td_id'];
					if($this->dbset1->query($sql)->num_rows()>=1){
						$buttons['update'] = $updatecek4.$js;
					}elseif($this->dbset1->query($sql)->num_rows()==0){
						$buttons['update'] = $updatecek4.$accept4.$js;
					}
				}

			}

		}else{
			if ($type=='IR') {
				if ($rowData['iSubmit']== 0) {
					$buttons['update'] = $update.$updatedraft.$js;
				}else{
					$sql="select * from dossier.dossier_dok_td_memo mem 
							inner join dossier.dossier_dok_td_detail dosi on dosi.idossier_dok_td_detail_id=mem.idossier_dok_td_detail_id 
							where dosi.lDeleted=0 and mem.lDeleted=0 and mem.iStatus_td_kelengkapan2!=2 and dosi.idossier_dok_td_id=".$rowData['idossier_dok_td_id'];
					if($this->dbset1->query($sql)->num_rows()>=1){
						$buttons['update'] = $updatecek2.$js;
					}
				}
			}
			elseif($type=='AD'){
				if($rowData['iApprove']==2){
					$buttons['update']=$updateupload.$js;
				}
			}
			elseif ($type=='BDI') {
				if($rowData['iapp_dok_td_cek2']==2 && $rowData['iapp_dok_td_cek3']==0){
					$sql="select * from dossier.dossier_dok_td_memo mem 
							inner join dossier.dossier_dok_td_detail dosi on dosi.idossier_dok_td_detail_id=mem.idossier_dok_td_detail_id 
							where dosi.lDeleted=0 and mem.lDeleted=0 and mem.iStatus_td_kelengkapan3!=2 and dosi.idossier_dok_td_id=".$rowData['idossier_dok_td_id'];
					if($this->dbset1->query($sql)->num_rows()>=1){
						$buttons['update']=$updatecek3.$js;
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
								var url = "'.base_url().'processor/plc/dossier/dokumen/td";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_dossier_dokumen_tambahan").html(data);
										 $("#button_approve_dossier_dokumen_td").hide();
										 $("#button_reject_dossier_dokumen_td").hide();
									});
									
								}
									reload_grid("grid_dossier_dokumen_td");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_dossier_dokumen_td_approve" action="'.base_url().'processor/plc/dossier/dokumen/td?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_dok_td_id" value="'.$this->input->get('idossier_dok_td_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_dossier_dokumen_td_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_dok_td_id = $post['idossier_dok_td_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove'=>'2','cApprove'=>$cNip , 'dApprove'=>date('Y-m-d H:i:s'), 'vRemark'=>$vRemark);
		$this -> db -> where('idossier_dok_td_id', $idossier_dok_td_id);
		$updet = $this -> db -> update('dossier.dossier_dok_td', $data);


		$data['status']  = true;
		$data['last_id'] = $post['idossier_dok_td_id'];
		return json_encode($data);
	}

		function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_dossier_dokumen_td_remark").val();
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
								var url = "'.base_url().'processor/plc/dossier/dokumen/td";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										  $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_dossier_dokumen_tambahan").html(data);
										 $("#button_approve_dossier_dokumen_td").hide();
										 $("#button_reject_dossier_dokumen_td").hide();
									});
									
								}
									reload_grid("grid_dossier_dokumen_td");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_dossier_dokumen_td_reject" action="'.base_url().'processor/plc/dossier/dokumen/td?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_dok_td_id" value="'.$this->input->get('idossier_dok_td_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="reject_dossier_dokumen_td_remark"class="required" required="required"></textarea>
		<button type="button" onclick="submit_ajax(\'form_dossier_dokumen_td_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	
	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_dok_td_id = $post['idossier_dok_td_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove'=>'1','cApprove'=>$cNip , 'dApprove'=>date('Y-m-d H:i:s'), 'vRemark'=>$vRemark);
		$this -> db -> where('idossier_dok_td_id', $idossier_dok_td_id);
		$updet = $this -> db -> update('dossier.dossier_dok_td', $data);


		$data['status']  = true;
		$data['last_id'] = $post['idossier_dok_td_id'];
		return json_encode($data);
	}



/*function pendukung start*/  

function downloadmemo($filename) {
	$this->load->helper('download');		
	$name = $filename;
	$id = $_GET['id'];
	$last=$_GET['last'];
	$path = file_get_contents('./files/plc/dossier_dok/dossier_dok_memo/'.$last.'/'.$id.'/'.$name);	
	force_download($name, $path);
}
function downloaddok($filename) {
	$this->load->helper('download');		
	$name = $filename;
	$id = $_GET['id'];
	$path = file_get_contents('./files/plc/dossier_dok/dossier_dok_td/'.$id.'/'.$name);	
	force_download($name, $path);
}
function downloadmemotdbuyer($filename) {
	$this->load->helper('download');		
	$name = $filename;
	$id = $_GET['id'];
	$path = file_get_contents('./files/plc/export/memo_td_buyer_moh/'.$id.'/'.$name);	
	force_download($name, $path);
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
		//$path = $path."/".$lastId;
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
					$del = "delete from dossier.".$table." where idossier_dok_td_id = {$lastId} and vFilename= '{$v}'";
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
			$sql = "SELECT vFilename from dossier.".$table." where idossier_dok_td_id=".$lastId;
			//echo $sql;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['vFilename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT vFilename from dossier.".$table." where idossier_dok_td_id=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM dossier.".$table." where idossier_dok_td_id=".$lastId." and vFilename='".$row['vFilename']."'";			
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


/*function pendukung end*/    	

	

	public function output(){
		$this->index($this->input->get('action'));
	}

}
