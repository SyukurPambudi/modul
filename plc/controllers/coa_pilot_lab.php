<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class coa_pilot_lab extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->dbset = $this->load->database('plc', true);
		 $this->load->library('lib_utilitas');
		$this->user = $this->auth_localnon->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;

		$grid->setTitle('Validasi Proses');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('coa_pilot_lab');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik','coa_pilot_lab.iappqa');
		$grid->setSortBy('iupb_id');
		$grid->setSortOrder('DESC');
		$grid->setLabel('vupb_nomor', 'UPB Nomor');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setWidth('vupb_nomor', '120');
		$grid->setAlign('vupb_nama', 'Left');
		$grid->setWidth('vupb_nama', '200');
		$grid->setAlign('coa_pilot_lab.iappqa', 'Left');
		$grid->setWidth('coa_pilot_lab.iappqa', '150');
		$grid->addFields('iupb_id','vupb_nama','vgenerik','lblcoapilot1','dmulai_coa_pilot1','dselesai_coa_pilot1','vPIC_coa_pilot1','vno_batch_coa_pilot1','vfile_coa_pilot1',
			'lblcoapilot2','dmulai_coa_pilot2','dselesai_coa_pilot2','vPIC_coa_pilot2','vno_batch_coa_pilot2','vfile_coa_pilot2',
			'lbllsa1','dmulai_lsa1','dselesai_lsa1','vPIC_lsa1','vno_batch_lsa1','vfile_lsa1',
			'lbllsa2','dmulai_lsa2','dselesai_lsa2','vPIC_lsa2','vno_batch_lsa2','vfile_lsa2','lblapp','iappqa');
		$grid->setLabel('vbatch', 'No Batch');
		$grid->setLabel('lblcoapilot1', 'COA Pilot (Batch 1)');
		$grid->setLabel('dmulai_coa_pilot1', 'Tgl Mulai');
		$grid->setLabel('dselesai_coa_pilot1', 'Tgl Selesai');
		$grid->setLabel('vPIC_coa_pilot1', 'PIC');
		$grid->setLabel('vno_batch_coa_pilot1', 'No Batch');
		$grid->setLabel('vfile_coa_pilot1', 'Histori Stabilita');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('iappqa', 'Approval QA');
		$grid->setLabel('lblapp', '');
		$grid->setLabel('coa_pilot_lab.iappqa', 'Approval QA');;

		$grid->setLabel('lblcoapilot2', 'COA Pilot (Batch II)');
		$grid->setLabel('dmulai_coa_pilot2', 'Tgl Mulai');
		$grid->setLabel('dselesai_coa_pilot2', 'Tgl Selesai');
		$grid->setLabel('vPIC_coa_pilot2', 'PIC');
		$grid->setLabel('vno_batch_coa_pilot2', 'No Batch');
		$grid->setLabel('vfile_coa_pilot2', 'Histori Stabilita');

		$grid->setLabel('lbllsa1', 'LSA Bahan Aktif LSA Excipient MBR (Batch I)');
		$grid->setLabel('dmulai_lsa1', 'Tgl Mulai');
		$grid->setLabel('dselesai_lsa1', 'Tgl Selesai');
		$grid->setLabel('vPIC_lsa1', 'PIC');
		$grid->setLabel('vno_batch_lsa1', 'No Batch');
		$grid->setLabel('vfile_lsa1', 'Histori Stabilita');

		$grid->setLabel('lbllsa2', 'LSA Bahan Aktif LSA Excipient MBR (Batch II)');
		$grid->setLabel('dmulai_lsa2', 'Tgl Mulai');
		$grid->setLabel('dselesai_lsa2', 'Tgl Selesai');
		$grid->setLabel('vPIC_lsa2', 'PIC');
		$grid->setLabel('vno_batch_lsa2', 'No Batch');
		$grid->setLabel('vfile_lsa2', 'Histori Stabilita');

		$grid->setFormUpload(TRUE);
		$grid->setRequired('iupb_id','dmulai_coa_pilot1','dselesai_coa_pilot1','vPIC_coa_pilot1','vno_batch_coa_pilot1','vfile_coa_pilot1',
			'dmulai_coa_pilot2','dselesai_coa_pilot2','vPIC_coa_pilot2','vno_batch_coa_pilot2','vfile_coa_pilot2',
			'dmulai_lsa1','dselesai_lsa1','vPIC_lsa1','vno_batch_lsa1','vfile_lsa1',
			'dmulai_lsa2','dselesai_lsa2','vPIC_lsa2','vno_batch_lsa2','vfile_lsa2');
		
		$grid->setJoinTable('plc2.coa_pilot_lab', 'coa_pilot_lab.iupb_id = plc2_upb.iupb_id', 'left');
		$grid->setJoinTable('plc2.validasi_proses','validasi_proses.iupb_id = plc2_upb.iupb_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_formula', 'plc2_upb_formula.iupb_id=plc2.plc2_upb.iupb_id','inner');
		$grid->setJoinTable('pddetail.formula_process','formula_process.iFormula_process=plc2_upb_formula.iFormula_process','inner');
		$grid->setJoinTable('pddetail.formula','formula.iFormula_process=formula_process.iFormula_process','inner');
		$grid->setJoinTable('plc2.plc2_upb_buat_mbr', 'plc2_upb_buat_mbr.ifor_id=plc2_upb_formula.ifor_id','inner');
		$grid->setRelation('plc2.plc2_upb.iteamqa_id','plc2.plc2_upb_team','iteam_id','vteam','team_qa','inner',array('vtipe'=>'QA', 'ldeleted'=>0),array('vteam'=>'asc'));

		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('QA', $team)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		$grid->setSearch('vupb_nomor','vupb_nama');
		$grid->setQuery('plc2_upb.ldeleted',0);
		$grid->setQuery('plc2_upb_buat_mbr.iapppd_bm',2); //approval pembuatan mbr
		$grid->setQuery('plc2_upb_buat_mbr.ldeleted',0); 
		$grid->setQuery('plc2_upb.ihold',0); //status hold upb
		$grid->setQuery('validasi_proses.iappqa',2); //approval validasi proses
		$grid->setQuery('plc2_upb.iupb_id in (select bk.iupb_id from plc2.plc2_upb_bahan_kemas bk where bk.iapppc=2 and bk.iapppd=2 and bk.iappqa=2 and bk.iappbd=2 and bk.ldeleted=0 group by bk.iupb_id)', null); //tambah approval bahan_kemas
		$grid->setQuery('plc2_upb.iupb_id in (select distinct(fo.iupb_id) from plc2.plc2_upb_formula fo
						inner join plc2.plc2_upb_prodpilot pr on pr.ifor_id=fo.ifor_id
						where fo.ldeleted=0 and pr.ldeleted=0 and pr.iapppd_pp=2)',NULL); //produksi pilot

		//New Parameter For PLC Non OTC
		$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2.plc2_upb.iKill', 0);
		$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
		$grid->setQuery('plc2_upb.ihold', 0);
		
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
			case 'download_pilot1':
				$this->download_pilot1($this->input->get('file'));
				break;
			case 'download_pilot2':
				$this->download_pilot2($this->input->get('file'));
				break;
			case 'download_lsa1':
				$this->download_lsa1($this->input->get('file'));
				break;
			case 'download_lsa2':
				$this->download_lsa2($this->input->get('file'));
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
				//print_r($post);exit();

				$this->db_plc0->where('iupb_id', $post['coa_pilot_lab_iupb_id']);		
				$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');

				$data['dUpdate'] = date('Y-m-d H:i:s');
				$data['cUpdate'] = $this->user->gNIP;
				$data['cCreate'] = $this->user->gNIP;
				$data['dCreate'] = date('Y-m-d H:i:s');

				if($post['isdraft']==true){
					$data['isubmit']=0;
				} 
				else{$data['isubmit']=1;} 

				$data['iupb_id']=$post['coa_pilot_lab_iupb_id'];

				$data['dmulai_coa_pilot1'] = date("Y-m-d", strtotime($post['coa_pilot_lab_dmulai_coa_pilot1']));
				$data['dselesai_coa_pilot1'] = date("Y-m-d", strtotime($post['coa_pilot_lab_dselesai_coa_pilot1']));
				$data['vPIC_coa_pilot1'] = $post['coa_pilot_lab_vPIC_coa_pilot1'];
				$data['vno_batch_coa_pilot1'] = $post['coa_pilot_lab_vno_batch_coa_pilot1'];

				$data['dmulai_coa_pilot2'] = date("Y-m-d", strtotime($post['coa_pilot_lab_dmulai_coa_pilot2']));
				$data['dselesai_coa_pilot2'] = date("Y-m-d", strtotime($post['coa_pilot_lab_dselesai_coa_pilot2']));
				$data['vPIC_coa_pilot2'] = $post['coa_pilot_lab_vPIC_coa_pilot2'];
				$data['vno_batch_coa_pilot2'] = $post['coa_pilot_lab_vno_batch_coa_pilot2'];

				$data['dmulai_lsa1'] = date("Y-m-d", strtotime($post['coa_pilot_lab_dmulai_lsa1']));
				$data['dselesai_lsa1'] = date("Y-m-d", strtotime($post['coa_pilot_lab_dselesai_lsa1']));
				$data['vPIC_lsa1'] = $post['coa_pilot_lab_vPIC_lsa1'];
				$data['vno_batch_lsa1'] = $post['coa_pilot_lab_vno_batch_lsa1'];

				$data['dmulai_lsa2'] = date("Y-m-d", strtotime($post['coa_pilot_lab_dmulai_lsa2']));
				$data['dselesai_lsa2'] = date("Y-m-d", strtotime($post['coa_pilot_lab_dselesai_lsa2']));
				$data['vPIC_lsa2'] = $post['coa_pilot_lab_vPIC_lsa2'];
				$data['vno_batch_lsa2'] = $post['coa_pilot_lab_vno_batch_lsa2'];

				if($j2==0){
					$this->dbset->insert('plc2.coa_pilot_lab',$data);
					$sql="select * from plc2.coa_pilot_lab where iupb_id=".$post['coa_pilot_lab_iupb_id']." LIMIT 1";
					$dt=$this->db_plc0->query($sql)->row_array();
					$icoa_id=$dt['icoa_id'];
				}else{
					$sql="select * from plc2.coa_pilot_lab where iupb_id=".$post['coa_pilot_lab_iupb_id']." LIMIT 1";
					$dt=$this->db_plc0->query($sql)->row_array();
					$icoa_id=$dt['icoa_id'];
					$this->dbset->where('icoa_id',$icoa_id);
					$this->dbset->update('plc2.coa_pilot_lab',$data);
				}
				$path = realpath("files/plc/coa_pilot_lab/");
				if(!file_exists($path."/".$icoa_id."/coa_pilot1")){
					if (!mkdir($path."/".$icoa_id."/coa_pilot1", 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}	
				if(!file_exists($path."/".$icoa_id."/coa_pilot2")){
					if (!mkdir($path."/".$icoa_id."/coa_pilot2", 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
				if(!file_exists($path."/".$icoa_id."/lsa1")){
					if (!mkdir($path."/".$icoa_id."/lsa1", 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
				if(!file_exists($path."/".$icoa_id."/lsa2")){
					if (!mkdir($path."/".$icoa_id."/lsa2", 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}

				$fileid_pilotI='';
					foreach($_POST as $key=>$value) {
										
					if ($key == 'fileketerangan_pilotI') {
						foreach($value as $y=>$u) {
							$fKeterangan_pilotI[$y] = $u;
						}
					}
					if ($key == 'namafile_pilotI') {
						foreach($value as $k=>$v) {
							$file_name_pilotI[$k] = $v;
						}
					}
					if ($key == 'fileid_pilotI') {
						$i=0;
						foreach($value as $k=>$v) {
							if($i==0){
								$fileid_pilotI .= "'".$v."'";
							}else{
								$fileid_pilotI .= ",'".$v."'";
							}
							$i++;
						}
					}
				}
				if($fileid_pilotI!=''){
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.coa_pilot_batch1 set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where icoa_id='".$icoa_id."' and icoa_pilot_batch1_id not in (".$fileid_pilotI.")";
					$this->dbset->query($sql1);
				}else{
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.coa_pilot_batch1 set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where icoa_id='".$icoa_id."'";
					$this->dbset->query($sql1);
				}

				$fileid_pilotII='';
					foreach($_POST as $key=>$value) {
										
					if ($key == 'fileketerangan_pilotII') {
						foreach($value as $y=>$u) {
							$fKeterangan_pilotII[$y] = $u;
						}
					}
					if ($key == 'namafile_pilotII') {
						foreach($value as $k=>$v) {
							$file_name_pilotII[$k] = $v;
						}
					}
					if ($key == 'fileid_pilotII') {
						$i=0;
						foreach($value as $k=>$v) {
							if($i==0){
								$fileid_pilotII .= "'".$v."'";
							}else{
								$fileid_pilotII .= ",'".$v."'";
							}
							$i++;
						}
					}
				}
				if($fileid_pilotII!=''){
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.coa_pilot_batch2 set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where icoa_id='".$icoa_id."' and icoa_pilot_batch2_id not in (".$fileid_pilotII.")";
					$this->dbset->query($sql1);
				}else{
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.coa_pilot_batch2 set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where icoa_id='".$icoa_id."'";
					$this->dbset->query($sql1);
				}

				$fileid_lsaI='';
					foreach($_POST as $key=>$value) {
										
					if ($key == 'fileketerangan_lsaI') {
						foreach($value as $y=>$u) {
							$fKeterangan_lsaI[$y] = $u;
						}
					}
					if ($key == 'namafile_lsaI') {
						foreach($value as $k=>$v) {
							$file_name_lsaI[$k] = $v;
						}
					}
					if ($key == 'fileid_lsaI') {
						$i=0;
						foreach($value as $k=>$v) {
							if($i==0){
								$fileid_lsaI .= "'".$v."'";
							}else{
								$fileid_lsaI .= ",'".$v."'";
							}
							$i++;
						}
					}
				}

				if($fileid_lsaI!=''){
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.coa_lsa1 set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where icoa_id='".$icoa_id."' and icoa_lsa1_id not in (".$fileid_lsaI.")";
					$this->dbset->query($sql1);
				}else{
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.coa_lsa1 set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where icoa_id='".$icoa_id."'";
					$this->dbset->query($sql1);
				}

				$fileid_lsaII='';
				foreach($_POST as $key=>$value) {
										
					if ($key == 'fileketerangan_lsaII') {
						foreach($value as $y=>$u) {
							$fKeterangan_lsaII[$y] = $u;
						}
					}
					if ($key == 'namafile_lsaII') {
						foreach($value as $k=>$v) {
							$file_name_lsaII[$k] = $v;
						}
					}
					if ($key == 'fileid_lsaII') {
						$i=0;
						foreach($value as $k=>$v) {
							if($i==0){
								$fileid_lsaII .= "'".$v."'";
							}else{
								$fileid_lsaII .= ",'".$v."'";
							}
							$i++;
						}
					}
				}

				if($fileid_lsaII!=''){
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.coa_lsa2 set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where icoa_id='".$icoa_id."' and icoa_lsa2_id not in (".$fileid_lsaII.")";
					$this->dbset->query($sql1);
				}else{
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.coa_lsa2 set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where icoa_id='".$icoa_id."'";
					$this->dbset->query($sql1);
				}

   				if($isUpload) {

	   				
					if (isset($_FILES['fileupload_pilotI']))  {
						$i=0;
						foreach ($_FILES['fileupload_pilotI']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_pilotI']["tmp_name"][$key];
								$name =$_FILES['fileupload_pilotI']["name"][$key];
								$data['filename_pilotI'] = $name;
								$data['dInsertDate_pilotI'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$icoa_id."/coa_pilot1/".$name)) {
									$sqli_pilotI[]="INSERT INTO plc2.coa_pilot_batch1 (icoa_id, vFilename, vKeterangan, dCreate, cCreate) 
											VALUES (".$icoa_id.",'".$data['filename_pilotI']."','".$fKeterangan_pilotI[$i]."','".$data['dInsertDate_pilotI']."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sqli_pilotI as $ql_pilotI) {
							try {
								$this->dbset->query($ql_pilotI);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}
					
					
					if (isset($_FILES['fileupload_pilotII']))  {
						$i=0;
						foreach ($_FILES['fileupload_pilotII']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_pilotII']["tmp_name"][$key];
								$name =$_FILES['fileupload_pilotII']["name"][$key];
								$data['filename_pilotII'] = $name;
								$data['dInsertDate_pilotII'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$icoa_id."/coa_pilot2/".$name)) {
									$sqli_pilotII[]="INSERT INTO plc2.coa_pilot_batch2 (icoa_id, vFilename, vKeterangan, dCreate, cCreate) 
											VALUES (".$icoa_id.",'".$data['filename_pilotII']."','".$fKeterangan_pilotII[$i]."','".$data['dInsertDate_pilotII']."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sqli_pilotII as $ql_pilotII) {
							try {
								$this->dbset->query($ql_pilotII);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}

					if (isset($_FILES['fileupload_lsaI']))  {
						$i=0;
						foreach ($_FILES['fileupload_lsaI']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_lsaI']["tmp_name"][$key];
								$name =$_FILES['fileupload_lsaI']["name"][$key];
								$data['filename_lsaI'] = $name;
								$data['dInsertDate_lsaI'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$icoa_id."/lsa1/".$name)) {
									$sqli_lsaI[]="INSERT INTO plc2.coa_lsa1 (icoa_id, vFilename, vKeterangan, dCreate, cCreate) 
											VALUES (".$icoa_id.",'".$data['filename_lsaI']."','".$fKeterangan_lsaI[$i]."','".$data['dInsertDate_lsaI']."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sqli_lsaI as $ql_lsaI) {
							try {
								$this->dbset->query($ql_lsaI);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}

					if (isset($_FILES['fileupload_lsaII']))  {
						$i=0;
						foreach ($_FILES['fileupload_lsaII']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_lsaII']["tmp_name"][$key];
								$name =$_FILES['fileupload_lsaII']["name"][$key];
								$data['filename_lsaII'] = $name;
								$data['dInsertDate_lsaII'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$icoa_id."/lsa2/".$name)) {
									$sqli_lsaII[]="INSERT INTO plc2.coa_lsa2 (icoa_id, vFilename, vKeterangan, dCreate, cCreate) 
											VALUES (".$icoa_id.",'".$data['filename_lsaII']."','".$fKeterangan_lsaII[$i]."','".$data['dInsertDate_lsaII']."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sqli_lsaII as $ql_lsaII) {
							try {
								$this->dbset->query($ql_lsaII);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}

					$r['status'] = TRUE;
					$r['last_id'] = $post['coa_pilot_lab_iupb_id'];	
					$r['message'] = 'Data Berhasil Disimpan';			
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
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();

				$cNip= $this->user->gNIP;
				$iupb_id = $post['iupb_id'];
				$tApprove=date('Y-m-d H:i:s');
				$sql="update plc2.coa_pilot_lab set vappqa='".$cNip."', dappqa='".$tApprove."', iappqa=2 where icoa_id='".$get['icoa_id']."'";
				$this->dbset->query($sql);

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

		        $pd = $rsql['iteampd_id'];
		        $bd = $rsql['iteambusdev_id'];
		        $qa = $rsql['iteamqa_id'];
		        $qc = $rsql['iteamqc_id'];
		        $pr = $rsql['iteampr_id'];
		        
		        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
		        
		        $toEmail2='';
		        $toEmail = $this->lib_utilitas->get_email_team( $qa );
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
		        $subject="Laporan COA Pilot dan LAB: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada approval oleh QA Manager pada proses Laporan COA Pilot dan LAB(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
				where em.vName like "%'.$term.'%" and te.vtipe="QA" AND it.ldeleted=0 order by em.vname ASC';
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
function listBox_coa_pilot_lab_coa_pilot_lab_iappqa($value) {
	if($value==0){$vstatus='Waiting for approval';}
	elseif($value==1){$vstatus='Rejected';}
	elseif($value==2){$vstatus='Approved';}
	return $vstatus;
}
function listBox_Action($row, $actions) {
    if($row->coa_pilot_lab__iappqa<>0){
    	unset($actions['edit']);
    }
    return $actions; 

	}
/*manipulasi view object form start*/
 	function updateBox_coa_pilot_lab_iupb_id($field, $id, $value, $rowData){
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
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1" value='.$value.' />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" value="'.$dt['vupb_nomor'].'" size="20" />';
		}
		return $return;
	}

	function updateBox_coa_pilot_lab_vupb_nama($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nama'];
		}else{
			$return='<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vupb_nama'].'" />';
		}
		return $return;
	}
	function updateBox_coa_pilot_lab_vgenerik($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vgenerik'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vgenerik'].'" />';
		}
		return $return;
	}
	//input label coa pilot 1
	function updateBox_coa_pilot_lab_lblcoapilot1($field, $id, $value, $rowData){
		$return = '<script>
			$("label[for=\'coa_pilot_lab_lblcoapilot1\']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"99%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase"});
		</script>';
		return $return;
	}
	function updateBox_coa_pilot_lab_dmulai_coa_pilot1($field, $id, $value, $rowData){
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=date('d-m-Y',strtotime($dt['dmulai_coa_pilot1']));
			if(($value==NULL)||($value=='')||($value=='0000-00-00')){
				$val='';
			}else{
				$val=date('d-m-Y',strtotime($value));
			}
			if($this->input->get('action')=='view'){
			$return	=$val;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" />';
				$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}
		return $return;
	}
	function updateBox_coa_pilot_lab_dselesai_coa_pilot1($field, $id, $value, $rowData){
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=date('d-m-Y',strtotime($dt['dselesai_coa_pilot1']));
			if(($value==NULL)||($value=='')||($value=='0000-00-00')){
				$val='';
			}else{
				$val=date('d-m-Y',strtotime($value));
			}
			if($this->input->get('action')=='view'){
			$return	=$val;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" />';
				$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}
		return $return;
	}
	function updateBox_coa_pilot_lab_vPIC_coa_pilot1($field, $id, $value, $rowData) {
		$url = base_url().'processor/plc/coa/pilot/lab?action=getemployee';
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
		      </script>';
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['vPIC_coa_pilot1'];
			if(($value!=NULL)||($value!='')){
				$sql="select * from plc2.coa_pilot_lab where icoa_id=".$dt['icoa_id']." LIMIT 1";
				$dt=$this->db_plc0->query($sql)->row_array();
				$value=$dt['vPIC_coa_pilot1'];
				$sql="select * from hrd.employee em where em.cNip='".$value."'";
				$dt=$this->db_plc0->query($sql)->row_array();
				if($this->input->get('action')=='view'){
					$return	=$dt['vName'];
				}else{
					$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" value="'.$value.'" class="required" />
					<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20" value="'.$dt['vName'].'"/>';
				}
			}else{
				if($this->input->get('action')=='view'){
					$return	='-';
				}else{
					$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" class="required" />
					<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20"/>';
				}
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" class="required" />
				<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20"/>';
			}
		}
		
		return $return;
	}
	function updateBox_coa_pilot_lab_vno_batch_coa_pilot1($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['vno_batch_coa_pilot1'];
			if($this->input->get('action')=='view'){
				$return	=$value;
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="required" style="width:130px" value="'.$value.'" />';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="required" style="width:130px" />';
			}
		}
		return $return;
	}
    function updateBox_coa_pilot_lab_vfile_coa_pilot1($field, $id, $value, $rowData) {
    	$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['icoa_id'];
		}else{$value='0';} 	
		$qr="select * from plc2.coa_pilot_batch1 where icoa_id='".$value."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('coa_pilot_batch1',$data,TRUE);
	}
	//input label coa pilot 2
	function updateBox_coa_pilot_lab_lblcoapilot2($field, $id, $value, $rowData){
		$return = '<script>
			$("label[for=\'coa_pilot_lab_lblcoapilot2\']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"99%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase"});
		</script>';
		return $return;
	}
	function updateBox_coa_pilot_lab_dmulai_coa_pilot2($field, $id, $value, $rowData){
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=date('d-m-Y',strtotime($dt['dmulai_coa_pilot2']));
			if(($value==NULL)||($value=='')||($value=='0000-00-00')){
				$val='';
			}else{
				$val=date('d-m-Y',strtotime($value));
			}
			if($this->input->get('action')=='view'){
			$return	=$val;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" />';
				$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}
		return $return;
	}
	function updateBox_coa_pilot_lab_dselesai_coa_pilot2($field, $id, $value, $rowData){
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=date('d-m-Y',strtotime($dt['dselesai_coa_pilot2']));
			if(($value==NULL)||($value=='')||($value=='0000-00-00')){
				$val='';
			}else{
				$val=date('d-m-Y',strtotime($value));
			}
			if($this->input->get('action')=='view'){
			$return	=$val;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" />';
				$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}
		return $return;
	}
	function updateBox_coa_pilot_lab_vPIC_coa_pilot2($field, $id, $value, $rowData) {
		$url = base_url().'processor/plc/coa/pilot/lab?action=getemployee';
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
		      </script>';
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['vPIC_coa_pilot2'];
			if(($value!=NULL)||($value!='')){
				$sql="select * from plc2.coa_pilot_lab where icoa_id=".$dt['icoa_id']." LIMIT 1";
				$dt=$this->db_plc0->query($sql)->row_array();
				$value=$dt['vPIC_coa_pilot2'];
				$sql="select * from hrd.employee em where em.cNip='".$value."'";
				$dt=$this->db_plc0->query($sql)->row_array();
				if($this->input->get('action')=='view'){
					$return	=$dt['vName'];
				}else{
					$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" value="'.$value.'" class="required" />
					<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20" value="'.$dt['vName'].'"/>';
				}
			}else{
				if($this->input->get('action')=='view'){
					$return	='-';
				}else{
					$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" class="required" />
					<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20"/>';
				}
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" class="required" />
				<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20"/>';
			}
		}
		
		return $return;
	}
	function updateBox_coa_pilot_lab_vno_batch_coa_pilot2($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['vno_batch_coa_pilot2'];
			if($this->input->get('action')=='view'){
				$return	=$value;
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="required" style="width:130px" value="'.$value.'" />';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="required" style="width:130px" />';
			}
		}
		return $return;
	}
	function updateBox_coa_pilot_lab_vfile_coa_pilot2($field, $id, $value, $rowData) {
    	$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['icoa_id'];
		}else{$value='0';} 	
		$qr="select * from plc2.coa_pilot_batch2 where icoa_id='".$value."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('coa_pilot_batch2',$data,TRUE);
	}
	//input label LSA 1
	function updateBox_coa_pilot_lab_lbllsa1($field, $id, $value, $rowData){
		$return = '<script>
			$("label[for=\'coa_pilot_lab_lbllsa1\']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"99%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase"});
		</script>';
		return $return;
	}
	function updateBox_coa_pilot_lab_dmulai_lsa1($field, $id, $value, $rowData){
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=date('d-m-Y',strtotime($dt['dmulai_lsa1']));
			if(($value==NULL)||($value=='')||($value=='0000-00-00')){
				$val='';
			}else{
				$val=date('d-m-Y',strtotime($value));
			}
			if($this->input->get('action')=='view'){
			$return	=$val;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" />';
				$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}
		return $return;
	}
	function updateBox_coa_pilot_lab_dselesai_lsa1($field, $id, $value, $rowData){
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=date('d-m-Y',strtotime($dt['dselesai_lsa1']));
			if(($value==NULL)||($value=='')||($value=='0000-00-00')){
				$val='';
			}else{
				$val=date('d-m-Y',strtotime($value));
			}
			if($this->input->get('action')=='view'){
			$return	=$val;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" />';
				$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}
		return $return;
	}
	function updateBox_coa_pilot_lab_vPIC_lsa1($field, $id, $value, $rowData) {
		$url = base_url().'processor/plc/coa/pilot/lab?action=getemployee';
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
		      </script>';
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['vPIC_lsa1'];
			if(($value!=NULL)||($value!='')){
				$sql="select * from plc2.coa_pilot_lab where icoa_id=".$dt['icoa_id']." LIMIT 1";
				$dt=$this->db_plc0->query($sql)->row_array();
				$value=$dt['vPIC_lsa1'];
				$sql="select * from hrd.employee em where em.cNip='".$value."'";
				$dt=$this->db_plc0->query($sql)->row_array();
				if($this->input->get('action')=='view'){
					$return	=$dt['vName'];
				}else{
					$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" value="'.$value.'" class="required" />
					<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20" value="'.$dt['vName'].'"/>';
				}
			}else{
				if($this->input->get('action')=='view'){
					$return	='-';
				}else{
					$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" class="required" />
					<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20"/>';
				}
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" class="required" />
				<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20"/>';
			}
		}
		
		return $return;
	}
	function updateBox_coa_pilot_lab_vno_batch_lsa1($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['vno_batch_lsa1'];
			if($this->input->get('action')=='view'){
				$return	=$value;
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="required" style="width:130px" value="'.$value.'" />';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="required" style="width:130px" />';
			}
		}
		return $return;
	}
	function updateBox_coa_pilot_lab_vfile_lsa1($field, $id, $value, $rowData) {
    	$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['icoa_id'];
		}else{$value='0';} 	
		$qr="select * from plc2.coa_lsa1 where icoa_id='".$value."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('coa_lsa1',$data,TRUE);
	}
	//input label LSA 2
	function updateBox_coa_pilot_lab_lbllsa2($field, $id, $value, $rowData){
		$return = '<script>
			$("label[for=\'coa_pilot_lab_lbllsa2\']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"99%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase"});
		</script>';
		return $return;
	}
	function updateBox_coa_pilot_lab_dmulai_lsa2($field, $id, $value, $rowData){
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=date('d-m-Y',strtotime($dt['dmulai_lsa2']));
			if(($value==NULL)||($value=='')||($value=='0000-00-00')){
				$val='';
			}else{
				$val=date('d-m-Y',strtotime($value));
			}
			if($this->input->get('action')=='view'){
			$return	=$val;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" />';
				$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}
		return $return;
	}
	function updateBox_coa_pilot_lab_dselesai_lsa2($field, $id, $value, $rowData){
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=date('d-m-Y',strtotime($dt['dselesai_lsa2']));
			if(($value==NULL)||($value=='')||($value=='0000-00-00')){
				$val='';
			}else{
				$val=date('d-m-Y',strtotime($value));
			}
			if($this->input->get('action')=='view'){
			$return	=$val;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" />';
				$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}
		return $return;
	}
	function updateBox_coa_pilot_lab_vPIC_lsa2($field, $id, $value, $rowData) {
		$url = base_url().'processor/plc/coa/pilot/lab?action=getemployee';
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
		      </script>';
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['vPIC_lsa2'];
			if(($value!=NULL)||($value!='')){
				$sql="select * from plc2.coa_pilot_lab where icoa_id=".$dt['icoa_id']." LIMIT 1";
				$dt=$this->db_plc0->query($sql)->row_array();
				$value=$dt['vPIC_lsa2'];
				$sql="select * from hrd.employee em where em.cNip='".$value."'";
				$dt=$this->db_plc0->query($sql)->row_array();
				if($this->input->get('action')=='view'){
					$return	=$dt['vName'];
				}else{
					$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" value="'.$value.'" class="required" />
					<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20" value="'.$dt['vName'].'"/>';
				}
			}else{
				if($this->input->get('action')=='view'){
					$return	='-';
				}else{
					$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" class="required" />
					<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20"/>';
				}
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" class="required" />
				<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20"/>';
			}
		}
		
		return $return;
	}
	function updateBox_coa_pilot_lab_vno_batch_lsa2($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['vno_batch_lsa2'];
			if($this->input->get('action')=='view'){
				$return	=$value;
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="required" style="width:130px" value="'.$value.'" />';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="required" style="width:130px" />';
			}
		}
		return $return;
	}
	function updateBox_coa_pilot_lab_vfile_lsa2($field, $id, $value, $rowData) {
    	$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['icoa_id'];
		}else{$value='0';} 	
		$qr="select * from plc2.coa_lsa2 where icoa_id='".$value."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('coa_lsa2',$data,TRUE);
	}
	function updateBox_coa_pilot_lab_lblapp($field, $id, $value, $rowData){
		$return = '<script>
			$("label[for=\'coa_pilot_lab_lblapp\']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"99%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase"});
		</script>';
		return $return;
	}
	function updateBox_coa_pilot_lab_iappqa($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			if($dt['iappqa'] != 0){
				$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$dt['vappqa']))->row_array();
				if($dt['iappqa']==2){$st="Approved";}elseif($dt['iappqa']==1){$st="Rejected";} 
				$ret= $st.' oleh '.$row['vName'].' ( '.$dt['vappqa'].' )'.' pada '.$dt['dappqa'];
			}
			else{
				$ret='Waiting for Approval';
			}
		}else{
			$ret='Waiting for Approval';
		}
		return $ret;
	}
/*manipulasi view object form end*/

/*manipulasi proses object form start*/
	function manipulate_update_button($buttons, $rowData){
		//print_r($rowData);exit();
		if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		{
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.coa_pilot_lab');
		$icoa_id=0;
		if($j2> 0){
			$sql="select * from plc2.coa_pilot_lab where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$icoa_id=$dt['icoa_id'];
		}

		unset($buttons['update']);
		//$js=$this->load->view('misc_util',array('className'=> 'coa_pilot_lab'), true);
		$js =$this->load->view('coa_pilot_lab_js');
		$js .= $this->load->view('uploadjs');

		$cNip=$this->user->gNIP;
		$sql= "select * from plc2.plc2_upb up where up.iupb_id=".$rowData['iupb_id'];
		$dt=$this->dbset->query($sql)->row_array();
		$setuju = '<button onclick="javascript:setuju(\'coa_pilot_lab\', \''.base_url().'processor/plc/coa/pilot/lab?action=confirm&last_id='.$this->input->get('id').'&icoa_id='.$icoa_id.'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Confirm</button>';
		
		$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/coa/pilot/lab?action=approve&iupb_id='.$rowData['iupb_id'].'&icoa_id='.$icoa_id.'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_coa_pilot_lab">Approve</button>';
		$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/coa/pilot/lab?action=reject&iupb_id='.$rowData['iupb_id'].'&icoa_id='.$icoa_id.'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_coa_pilot_lab">Reject</button>';

		$update = '<button onclick="javascript:update_btn_back(\'coa_pilot_lab\', \''.base_url().'processor/plc/coa/pilot/lab?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_coa_pilot_lab">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'coa_pilot_lab\', \''.base_url().'processor/plc/coa/pilot/lab?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_coa_pilot_lab">Update as Draft</button>';
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){
				if($j2> 0){
					$sql="select * from plc2.coa_pilot_lab where icoa_id=".$icoa_id." LIMIT 1";
					$dt=$this->db_plc0->query($sql)->row_array();
					if($dt['isubmit']==0){
						$buttons['update']=$updatedraft.$update.$js;
					}
					elseif(($dt['isubmit']<>0)&&($dt['iappqa']==0)){
						$buttons['update']=$setuju.$js;
					}else{}
				}else{
					$buttons['update']=$updatedraft.$update.$js;
				}
				$type='QA';
			}else{

				$type='';
			}
		}else{

			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('QA', $team)){
				$type='QA';
				if($j2> 0){
					$sql="select * from plc2.coa_pilot_lab where icoa_id=".$icoa_id." LIMIT 1";
					$dt=$this->db_plc0->query($sql)->row_array();
					if($dt['isubmit']==0){
						$buttons['update']=$updatedraft.$update.$js;
					}else{}
				}else{
					$buttons['update']=$updatedraft.$update.$js;
				}
			}else{
				$type='';
			}
		}
	}
		return $buttons;
	}
   
/*manipulasi proses object form end*/    
function before_update_processor($row, $postData) {
	unset($postData['vupb_nama']);
	unset($postData['vgenerik']);
	
	//print_r($postData);exit();
	return $postData;

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
										$.get(base_url+"processor/plc/coa/pilot/lab?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
	                            			 $("div#form_coa_pilot_lab").html(data);
	                    				});
									
								}
									reload_grid("grid_coa_pilot_lab");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_coa_pilot_lab_approve" action="'.base_url().'processor/plc/coa/pilot/lab?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="icoa_id" value="'.$this->input->get('icoa_id').'" />
				<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_coa_pilot_lab_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function approve_process(){
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$iupb_id = $post['iupb_id'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.coa_pilot_lab set vRemark='".$vRemark."',vappqa='".$cNip."', dappqa='".$tApprove."', iappqa=2 where icoa_id='".$post['icoa_id']."'";
		$this->dbset->query($sql);

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

        $pd = $rsql['iteampd_id'];
        $bd = $rsql['iteambusdev_id'];
        $qa = $rsql['iteamqa_id'];
        $qc = $rsql['iteamqc_id'];
        $pr = $rsql['iteampr_id'];
        
        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
        
        $toEmail2='';
        $toEmail = $this->lib_utilitas->get_email_team( $pr );
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
        $subject="Laporan COA Pilot dan LAB: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval oleh QA Manager pada proses Laporan COA Pilot dan LAB(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
		$data['last_id'] = $post['iupb_id'];
		return json_encode($data);
	}

function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#vRemark").val();
					 	if (remark=="") {
					 		info = "Info";
							header = "Info";
							grid="coa_pilot_lab";
					 		_custom_alert("Remark Tidak Boleh Kosong!",header,info, grid, 1, 20000);
					 		return
					 	}
					 	return $.ajax({
					 		url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/coa/pilot/lab";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
										 $("div#form_coa_pilot_lab").html(data);
									});
									
								}
									reload_grid("grid_coa_pilot_lab");
							}
					 	 	
					 	 })
					
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_coa_pilot_lab_reject" action="'.base_url().'processor/plc/coa/pilot/lab?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="icoa_id" value="'.$this->input->get('icoa_id').'" />
				<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_coa_pilot_lab_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.coa_pilot_lab set vRemark='".$vRemark."',vappqa='".$cNip."', dappqa='".$tApprove."', iappqa=1 where icoa_id='".$post['icoa_id']."'";
		$this->dbset->query($sql);

		$data['group_id']=$post['group_id'];
		$data['modul_id']=$post['modul_id'];
		$data['status']  = true;
		$data['last_id'] = $post['iupb_id'];
		return json_encode($data);
	}
	function after_update_processor($row, $insertId, $postData){
	}

/*function pendukung end*/    	
	function download_pilot1($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/coa_pilot_lab/'.$id.'/coa_pilot1/'.$name);	
		force_download($name, $path);
	}

	function download_pilot2($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/coa_pilot_lab/'.$id.'/coa_pilot2/'.$name);	
		force_download($name, $path);
	}

	function download_lsa1($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/coa_pilot_lab/'.$id.'/lsa1/'.$name);	
		force_download($name, $path);
	}

	function download_lsa2($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/coa_pilot_lab/'.$id.'/lsa2/'.$name);	
		force_download($name, $path);
	}

	public function output(){
		$this->index($this->input->get('action'));
	}

}
