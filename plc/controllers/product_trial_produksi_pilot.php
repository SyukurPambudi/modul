<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_trial_produksi_pilot extends MX_Controller {
	var $_url;
	var $dbset;
	function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->user = $this->auth_localnon->user();
		$this->load->library('biz_process');
                $this->load->library('lib_utilitas');
		$this->load->helper(array('tanggal','to_mysql','mydb'));
		$this->load->model('user_model');
		$this->dbset = $this->load->database('plc0',false, true);
		$this->url = 'product_trial_produksi_pilot';
		$this->pathcoax = "files/plc/coaex";
		$this->pathlsaex = "files/plc/lsaex";
		$this->pathsoiex = "files/plc/soiex";
		$this->pathlapprot_udt = "files/plc/udt";
		$this->pathprot_udt = "files/plc/prot_udt";
		$this->pathcoars = "files/plc/pilot/coars";
		$this->pathcoaws = "files/plc/pilot/coaws";
		$this->pathcoabb_lsa = "files/plc/pilot/coabb_lsa";
		$this->pathprot_stab = "files/plc/pilot/prot_stab";
		$this->pathdraft_coafg = "files/plc/pilot/draft_coafg";
    }
    function index($action = '') {
    	$grid = new Grid;	
		$grid->setFormUpload(TRUE);	
		$grid->setTitle('Produksi Pilot');
		$grid->setUrl('product_trial_produksi_pilot');
		$grid->setTable('plc2.plc2_upb_formula');
		$grid->setJoinTable('plc2.plc2_upb','plc2_upb_formula.iupb_id = plc2_upb.iupb_id','inner');
		$grid->setJoinTable('plc2.plc2_upb_prodpilot','plc2_upb_prodpilot.ifor_id = plc2_upb_formula.ifor_id','left');
		$grid->setJoinTable('pddetail.formula_process','formula_process.iupb_id=plc2_upb_formula.iupb_id','inner');
		$grid->setJoinTable('pddetail.formula','formula.iFormula_process=formula_process.iFormula_process','inner');

		$grid->setSortOrder('DESC');
		$grid->setSortBy('iprodpilot_id');
		$grid->setSearch('formula.vNo_formula','plc2_upb.vupb_nomor','plc2_upb.vupb_nama');

		$grid->addList('formula.vNo_formula','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb_prodpilot.dtglmulai_prod','plc2_upb_prodpilot.dtglselesai_prod','plc2_upb_prodpilot.iapppd_pp');
		$grid->addFields('vkode_surat','vupb_nomor','vupb_nama','dtglmulai_prod','dtglselesai_prod');
		//$grid->addFields('coaex','lsaex','soiex','lapprot_udt','prot_udt');
		$grid->addFields('soiex','lapprot_udt','prot_udt');
		//$grid->addFields('coars','coaws','coabb_lsa','prot_stab','draft_coafg');
		$grid->addFields('coars','coaws','prot_stab','draft_coafg');
		$grid->addFields('vnip_apppd_pp');
		
		//$grid->setRequired('dtglmulai_prod','dtglselesai_prod','coaex','lsaex','soiex','lapprot_udt','prot_udt');
		$grid->setRequired('dtglmulai_prod','dtglselesai_prod','soiex','lapprot_udt','prot_udt');
		//$grid->setRequired('coars','coaws','coabb_lsa','prot_stab','draft_coafg');
		$grid->setRequired('coars','coaws','prot_stab','draft_coafg');
		
		$grid->setLabel('plc2_upb_formula.vkode_surat', 'No. Formulasi');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');		
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('vkode_surat', 'No. Formulasi');
		$grid->setLabel('formula.vNo_formula', 'No. Formulasi');
		
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('dtglmulai_prod', 'Tanggal Mulai Produksi');
		$grid->setLabel('plc2_upb_prodpilot.dtglmulai_prod', 'Tanggal Mulai Produksi');
		$grid->setLabel('dtglselesai_prod', 'Tanggal Selesai Produksi');
		$grid->setLabel('plc2_upb_prodpilot.dtglselesai_prod', 'Tanggal Selesai Produksi');
		$grid->setLabel('lapori','Laporan Originator');
		$grid->setLabel('prot_udt','Protokol UDT');
		$grid->setLabel('coaex','CoA Excipients');
		$grid->setLabel('lsaex','LSA Excipients');
		$grid->setLabel('soiex','SOI Excipients');
		$grid->setLabel('lapprot_udt','Laporan UDT');
		$grid->setLabel('vnip_apppd_pp', 'PD Approval');
		$grid->setLabel('plc2_upb_prodpilot.iapppd_pp', 'PD Approval');

		$grid->setLabel('coars', 'File CoA RS');
		$grid->setLabel('coaws', 'File CoA WS');
		$grid->setLabel('coabb_lsa', 'File CoA & LSA Zat Aktif');
		$grid->setLabel('prot_stab', 'Protokol Stabilita');
		$grid->setLabel('draft_coafg', 'Draft CoA FG');
		
		$grid->setQuery('plc2_upb_formula.ldeleted', 0);	
		$grid->setQuery('(if(plc2_upb_prodpilot.iprodpilot_id is not null , plc2_upb_prodpilot.ldeleted =  0 ,plc2_upb_formula.ldeleted =  0   )   )', NULL);	
		$grid->setQuery('plc2.plc2_upb_formula.ibest', 2); //yg best formula
		$grid->setQuery('plc2_upb_formula.ifor_id in (select mb.ifor_id from plc2.plc2_upb_buat_mbr mb where mb.iapppd_bm=2)', null); //yg sudah approve bahan kemas
		
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/

		// sudah protokol valpro
		$grid->setQuery('plc2_upb.iupb_id in (
						select a.iupb_id from plc2.protokol_valpro a 
						where a.iappqa =2 
						and a.lDeleted=0
			)', null);

		// sudah terima BB untuk Pilot II
		$grid->setQuery('if(plc2.plc2_upb_formula.iwithbasic=1,
					 (plc2.plc2_upb.iupb_id in (
					 select d.iupb_id
					 from plc2.plc2_upb_ro_detail a 
					 join plc2.plc2_upb_request_sample b on b.ireq_id=a.ireq_id
					 join plc2.plc2_upb_ro c on c.iro_id=a.iro_id
					 join plc2.plc2_upb d on d.iupb_id=b.iupb_id
					 join plc2.plc2_raw_material e on e.raw_id=a.raw_id
					 where 
					 a.vrec_nip_qc is not null
					 and a.trec_date_qc is not null
					 and a.ldeleted=0
					 and b.ldeleted=0
					 and c.ldeleted=0
					 and d.ldeleted=0
					 and e.ldeleted=0
					 and b.iTujuan_req=3
					 )
					 )
				 
				 ,plc2.plc2_upb_formula.ldeleted=0
				 )',null);

		
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			
		}
		
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
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'), TRUE);
				break;
			case 'updateproses':
				$isUpload = $this->input->get('isUpload');
				$post=$this->input->post();
				$lastId=$post['product_trial_produksi_pilot_ifor_id'];

                if($isUpload) {
                	/*COAex*/
                	$filejenis='coaex';
					$pathcoax = realpath($this->pathcoax);
					if(!file_exists($pathcoax."/".$lastId)){
						if (!mkdir($pathcoax."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again - '.$filejenis.'!');
						}
					}
					$fKeterangan = array(); 
	                $fileid='';
	                foreach($_POST as $key=>$value) {     
	                    if ($key == 'product_trial_produksi_pilot_'.$filejenis.'_fileketerangan') {
	                        foreach($value as $y=>$u) {
	                            $fKeterangan[$y] = $u;
	                        }
	                    }
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_file_coa_ex set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_file_coa_ex set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }
                    $i=0;
                    $sql=array();
                    if (isset($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']))  {
                        foreach ($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["tmp_name"][$key];
                                $name =$_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $pathcoax."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.plc2_upb_file_coa_ex (ifor_id, filename, keterangan, dInsertDate, cInsert) 
											VALUES (".$lastId.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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
                    }

                    /*LSAex*/
                	$filejenis='lsaex';
					$pathlsaex = realpath($this->pathlsaex);
					if(!file_exists($pathlsaex."/".$lastId)){
						if (!mkdir($pathlsaex."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again - '.$filejenis.'!');
						}
					}
					$fKeterangan = array(); 
	                $fileid='';
	                foreach($_POST as $key=>$value) {     
	                    if ($key == 'product_trial_produksi_pilot_'.$filejenis.'_fileketerangan') {
	                        foreach($value as $y=>$u) {
	                            $fKeterangan[$y] = $u;
	                        }
	                    }
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_file_lsa_ex set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_file_lsa_ex set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }
                    $i=0;
                    $sql=array();
                    if (isset($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']))  {
                        foreach ($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["tmp_name"][$key];
                                $name =$_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $pathlsaex."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.plc2_upb_file_lsa_ex (ifor_id, filename, keterangan, dInsertDate, cInsert) 
											VALUES (".$lastId.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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
                    }

                    /*SOIex*/
                	$filejenis='soiex';
					$pathsoiex = realpath($this->pathsoiex);
					if(!file_exists($pathsoiex."/".$lastId)){
						if (!mkdir($pathsoiex."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again - '.$filejenis.'!');
						}
					}
					$fKeterangan = array(); 
	                $fileid='';
	                foreach($_POST as $key=>$value) {     
	                    if ($key == 'product_trial_produksi_pilot_'.$filejenis.'_fileketerangan') {
	                        foreach($value as $y=>$u) {
	                            $fKeterangan[$y] = $u;
	                        }
	                    }
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_file_soi_ex set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_file_soi_ex set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }
                    $i=0;
                    $sql=array();
                    if (isset($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']))  {
                        foreach ($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["tmp_name"][$key];
                                $name =$_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $pathsoiex."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.plc2_upb_file_soi_ex (ifor_id, filename, keterangan, dInsertDate, cInsert) 
											VALUES (".$lastId.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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
                    }

                   
                    /*lapprot_udt*/
                	$filejenis='lapprot_udt';
					$pathlapprot_udt = realpath($this->pathlapprot_udt);
					if(!file_exists($pathlapprot_udt."/".$lastId)){
						if (!mkdir($pathlapprot_udt."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again - '.$filejenis.'!');
						}
					}
					$fKeterangan = array(); 
	                $fileid='';
	                foreach($_POST as $key=>$value) {     
	                    if ($key == 'product_trial_produksi_pilot_'.$filejenis.'_fileketerangan') {
	                        foreach($value as $y=>$u) {
	                            $fKeterangan[$y] = $u;
	                        }
	                    }
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_file_lapprot_udt set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_file_lapprot_udt set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }
                    $i=0;
                    $sql=array();
                    if (isset($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']))  {
                        foreach ($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["tmp_name"][$key];
                                $name =$_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $pathlapprot_udt."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.plc2_upb_file_lapprot_udt (ifor_id, filename, keterangan, dInsertDate, cInsert) 
											VALUES (".$lastId.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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
                    }

                    /*prot_udt*/
                	$filejenis='prot_udt';
					$pathprot_udt = realpath($this->pathprot_udt);
					if(!file_exists($pathprot_udt."/".$lastId)){
						if (!mkdir($pathprot_udt."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again - '.$filejenis.'!');
						}
					}
					$fKeterangan = array(); 
	                $fileid='';
	                foreach($_POST as $key=>$value) {     
	                    if ($key == 'product_trial_produksi_pilot_'.$filejenis.'_fileketerangan') {
	                        foreach($value as $y=>$u) {
	                            $fKeterangan[$y] = $u;
	                        }
	                    }
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_pilot_file_prot_udt set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_pilot_file_prot_udt set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }
                    $i=0;
                    $sql=array();
                    if (isset($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']))  {
                        foreach ($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["tmp_name"][$key];
                                $name =$_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $pathprot_udt."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.plc2_upb_pilot_file_prot_udt (ifor_id, filename, keterangan, dInsertDate, cInsert) 
											VALUES (".$lastId.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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
                    }

                    /*coars*/
                	$filejenis='coars';
					$pathcoars = realpath($this->pathcoars);
					if(!file_exists($pathcoars."/".$lastId)){
						if (!mkdir($pathcoars."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again - '.$filejenis.'!');
						}
					}
					$fKeterangan = array(); 
	                $fileid='';
	                foreach($_POST as $key=>$value) {     
	                    if ($key == 'product_trial_produksi_pilot_'.$filejenis.'_fileketerangan') {
	                        foreach($value as $y=>$u) {
	                            $fKeterangan[$y] = $u;
	                        }
	                    }
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_pilot_file_coars set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_pilot_file_coars set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }
                    $i=0;
                    $sql=array();
                    if (isset($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']))  {
                        foreach ($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["tmp_name"][$key];
                                $name =$_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $pathcoars."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.plc2_upb_pilot_file_coars (ifor_id, filename, keterangan, dInsertDate, cInsert) 
											VALUES (".$lastId.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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
                    }

                    /*coaws*/
                	$filejenis='coaws';
					$pathcoaws = realpath($this->pathcoaws);
					if(!file_exists($pathcoaws."/".$lastId)){
						if (!mkdir($pathcoaws."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again - '.$filejenis.'!');
						}
					}
					$fKeterangan = array(); 
	                $fileid='';
	                foreach($_POST as $key=>$value) {     
	                    if ($key == 'product_trial_produksi_pilot_'.$filejenis.'_fileketerangan') {
	                        foreach($value as $y=>$u) {
	                            $fKeterangan[$y] = $u;
	                        }
	                    }
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_pilot_file_coaws set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_pilot_file_coaws set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }
                    $i=0;
                    $sql=array();
                    if (isset($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']))  {
                        foreach ($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["tmp_name"][$key];
                                $name =$_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $pathcoaws."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.plc2_upb_pilot_file_coaws (ifor_id, filename, keterangan, dInsertDate, cInsert) 
											VALUES (".$lastId.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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
                    }

                    /*coabb_lsa*/
                	$filejenis='coabb_lsa';
					$pathcoabb_lsa = realpath($this->pathcoabb_lsa);
					if(!file_exists($pathcoabb_lsa."/".$lastId)){
						if (!mkdir($pathcoabb_lsa."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again - '.$filejenis.'!');
						}
					}
					$fKeterangan = array(); 
	                $fileid='';
	                foreach($_POST as $key=>$value) {     
	                    if ($key == 'product_trial_produksi_pilot_'.$filejenis.'_fileketerangan') {
	                        foreach($value as $y=>$u) {
	                            $fKeterangan[$y] = $u;
	                        }
	                    }
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_pilot_file_coabb_lsa set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_pilot_file_coabb_lsa set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }
                    $i=0;
                    $sql=array();
                    if (isset($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']))  {
                        foreach ($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["tmp_name"][$key];
                                $name =$_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $pathcoabb_lsa."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.plc2_upb_pilot_file_coabb_lsa (ifor_id, filename, keterangan, dInsertDate, cInsert) 
											VALUES (".$lastId.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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
                    }

                    /*prot_stab*/
                	$filejenis='prot_stab';
					$pathprot_stab = realpath($this->pathprot_stab);
					if(!file_exists($pathprot_stab."/".$lastId)){
						if (!mkdir($pathprot_stab."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again - '.$filejenis.'!');
						}
					}
					$fKeterangan = array(); 
	                $fileid='';
	                foreach($_POST as $key=>$value) {     
	                    if ($key == 'product_trial_produksi_pilot_'.$filejenis.'_fileketerangan') {
	                        foreach($value as $y=>$u) {
	                            $fKeterangan[$y] = $u;
	                        }
	                    }
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_pilot_file_prot_stab set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_pilot_file_prot_stab set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }
                    $i=0;
                    $sql=array();
                    if (isset($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']))  {
                        foreach ($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["tmp_name"][$key];
                                $name =$_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $pathprot_stab."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.plc2_upb_pilot_file_prot_stab (ifor_id, filename, keterangan, dInsertDate, cInsert) 
											VALUES (".$lastId.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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
                    }

                    /*draft_coafg*/
                	$filejenis='draft_coafg';
					$pathdraft_coafg = realpath($this->pathdraft_coafg);
					if(!file_exists($pathdraft_coafg."/".$lastId)){
						if (!mkdir($pathdraft_coafg."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again - '.$filejenis.'!');
						}
					}
					$fKeterangan = array(); 
	                $fileid='';
	                foreach($_POST as $key=>$value) {     
	                    if ($key == 'product_trial_produksi_pilot_'.$filejenis.'_fileketerangan') {
	                        foreach($value as $y=>$u) {
	                            $fKeterangan[$y] = $u;
	                        }
	                    }
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_pilot_file_draft_coafg set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_pilot_file_draft_coafg set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }
                    $i=0;
                    $sql=array();
                    if (isset($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']))  {
                        foreach ($_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["tmp_name"][$key];
                                $name =$_FILES['product_trial_produksi_pilot_'.$filejenis.'_upload_file']["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $pathdraft_coafg."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.plc2_upb_pilot_file_draft_coafg (ifor_id, filename, keterangan, dInsertDate, cInsert) 
											VALUES (".$lastId.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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
                    }

                    $r['message']='Data Berhasil di Simpan';
                    $r['status'] = TRUE;
                    $r['last_id'] = $this->input->get('lastId');                
                    echo json_encode($r);
                    exit();
                }else{
                	/*COAex*/
                	$filejenis='coaex';
                    $fileid='';
                    foreach($_POST as $key=>$value) {
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_file_coa_ex set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_file_coa_ex set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }

                    /*LSAEx*/
                	$filejenis='lsaex';
                    $fileid='';
                    foreach($_POST as $key=>$value) {
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_file_lsa_ex set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_file_lsa_ex set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }

                    /*soiex*/
                	$filejenis='soiex';
                    $fileid='';
                    foreach($_POST as $key=>$value) {
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_file_soi_ex set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_file_soi_ex set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }

                   /*lapprot_udt*/
                    $filejenis='lapprot_udt';
                    $fileid='';
                    foreach($_POST as $key=>$value) {
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_file_lapprot_udt set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_file_lapprot_udt set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }

                    /*prot_udt*/
                    $filejenis='prot_udt';
                    $fileid='';
                    foreach($_POST as $key=>$value) {
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_pilot_file_prot_udt set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_pilot_file_prot_udt set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }

                    /*coars*/
                    $filejenis='coars';
                    $fileid='';
                    foreach($_POST as $key=>$value) {
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_pilot_file_coars set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_pilot_file_coars set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }

                    /*coaws*/
                    $filejenis='coaws';
                    $fileid='';
                    foreach($_POST as $key=>$value) {
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_pilot_file_coaws set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_pilot_file_coars set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }

                    /*coabb_lsa*/
                    $filejenis='coabb_lsa';
                    $fileid='';
                    foreach($_POST as $key=>$value) {
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_pilot_file_coabb_lsa set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_pilot_file_coabb_lsa set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }

                    /*prot_stab*/
                    $filejenis='prot_stab';
                    $fileid='';
                    foreach($_POST as $key=>$value) {
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_pilot_file_prot_stab set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_pilot_file_prot_stab set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    } 

                    /*draft_coafg*/
                    $filejenis='draft_coafg';
                    $fileid='';
                    foreach($_POST as $key=>$value) {
	                    if ($key == 'product_trial_produksi_pilot_id_pk_'.$filejenis) {
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
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update plc2.plc2_upb_pilot_file_draft_coafg set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."' and id not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_upb_pilot_file_draft_coafg set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$lastId."'";
                        $this->dbset->query($sql1);
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
			case 'getDataFileUpload':
				echo $this->getDataFileUpload();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }
	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		switch ($_GET['filejenis']) {
			case 'coaex':
				$tempat=$this->pathcoax;
				break;
			case 'lsaex':
				$tempat=$this->pathlsaex;
				break;
			case 'soiex':
				$tempat=$this->pathsoiex;
				break;
			case 'lapprot_udt':
				$tempat=$this->pathlapprot_udt;
				break;
			case 'prot_udt':
				$tempat=$this->pathprot_udt;
				break;
			case 'coars':
				$tempat=$this->pathcoars;
				break;
			case 'coaws':
				$tempat=$this->pathcoaws;
				break;
			case 'coabb_lsa':
				$tempat=$this->pathcoabb_lsa;
				break;
			case 'prot_stab':
				$tempat=$this->pathprot_stab;
				break;
			case 'draft_coafg':
				$tempat=$this->pathdraft_coafg;
				break;
			
			default:
				$tempat="NULL";
				break;
		}
		$path = file_get_contents('./'.$tempat.'/'.$id.'/'.$name);	
		force_download($name, $path);
	}
	function manipulate_insert_button($button){
		$url=$this->url;
		unset($button['save']);
		$btnSave='<button onclick="javascript:save_btn_multiupload(\'product_trial_produksi_pilot\', \''.base_url().'processor/plc/product/trial/produksi/pilot?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_'.$url.'">Save</button>';
		$js = $this->load->view('produksi_pilot_js');
		$button['save'] = $btnSave.$js;
		return $button;
	}
	function manipulate_update_button($buttons, $rowData) {
    	
		if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			//print_r($rowData);
			unset($buttons['update_back']);
			unset($buttons['update']);
			$grid='product_trial_produksi_pilot';
			$datajs['grid']=$grid;
			$js = $this->load->view('produksi_pilot_js',$datajs);
			
			$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
			$this->db_plc0->where('ldeleted', '0'); //tambahin ldeleted=0
			$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_prodpilot');
			$user = $this->auth_localnon->user();
		
			$x=$this->auth_localnon->dept();
			if($this->auth_localnon->is_manager()){
				$x=$this->auth_localnon->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){$type='PD';}
				elseif(in_array('QA', $manager)){$type='QA';}
				else{$type='';}
			}
			else{
				$x=$this->auth_localnon->dept();
				$team=$x['team'];
				if(in_array('PD', $team)){$type='PD';}
				elseif(in_array('QA', $manager)){$type='QA';}
				else{$type='';}
			}
			// cek status upb, klao upb 
			unset($buttons['update_back']);
			unset($buttons['update']);
			
			//echo $type;
			//echo $this->auth_localnon->my_teams();
			
			$ifor_id=$rowData['ifor_id'];
			
			//get upb_id
			$ifor_id=$rowData['ifor_id'];
		
			$this->db_plc0->where('ifor_id', $ifor_id);		
			$this->db_plc0->where('ldeleted', '0'); //tambahin ldeleted=0			
			$j = $this->db_plc0->count_all_results('plc2.plc2_upb_prodpilot');
		
			if ($j > 0){
				$qcek="select * from plc2.plc2_upb_prodpilot f where f.ifor_id=$ifor_id";
				$rcek = $this->db_plc0->query($qcek)->row_array();
				
			}
			else {				
				$rcek['iapppd_pp'] = 0;
				$j=0;
				
			}
			if($this->auth_localnon->is_manager()){ //jika manager PD
				if(($type=='PD')&&($rcek['iapppd_pp']==0)){
						$update = '<button onclick="javascript:update_submit_'.$grid.'(\'product_trial_produksi_pilot\', \''.base_url().'processor/plc/product/trial/produksi/pilot?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
						$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/produksi/pilot?action=approve&iupb_id='.$rowData['iupb_id'].'&ifor_id='.$rowData['ifor_id'].'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_formula_lab">Approve</button>';
							
						$buttons['update'] = $update.$approve.$js;
				}
				elseif(($type=='QA')&&($rcek['iapppd_pp']==0)){
						$update = '<button onclick="javascript:update_submit_'.$grid.'(\'product_trial_produksi_pilot\', \''.base_url().'processor/plc/product/trial/produksi/pilot?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							
						$buttons['update'] = $update.$js;
				}
				else{}
				}
			else{
				if(($type=='PD')&&($rcek['iapppd_pp']==0)){
					$update = '<button onclick="javascript:update_submit_'.$grid.'(\'product_trial_produksi_pilot\', \''.base_url().'processor/plc/product/trial/produksi/pilot?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
					$buttons['update'] = $update.$js;
				}
				elseif(($type=='QA')&&($rcek['iapppd_pp']==0)){
					$update = '<button onclick="javascript:update_submit_'.$grid.'(\'product_trial_produksi_pilot\', \''.base_url().'processor/plc/product/trial/produksi/pilot?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Update</button>';
							
					$buttons['update'] = $update.$js;
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
								var url = "'.base_url().'processor/plc/product/trial/produksi/pilot";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_product_trial_produksi_pilot").html(data);
									});
					
								}
									reload_grid("grid_product_trial_produksi_pilot");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_product_trial_produksi_pilot_approve" action="'.base_url().'processor/plc/product/trial/produksi/pilot?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
				<input type="hidden" name="ifor_id" value="'.$this->input->get('ifor_id').'" />
    			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_product_trial_produksi_pilot_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
	 	$ifor_id=$post['ifor_id'];
		$this->db_plc0->where('ifor_id', $post['ifor_id']);
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$iapprove = $post['type'] == 'PD' ? 'iapppd_pp' : '';
		$this->db_plc0->update('plc2.plc2_upb_prodpilot', array($iapprove=>2,'vnip_apppd_pp'=>$nip,'tapppd_pp'=>$skg));
    
    	$upbid = $post['iupb_id'];
		
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
		
		$ifor_id=$this->input->post('ifor_id');

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

        $team = $pd. ','.$qa ;
        
        $toEmail2='';
        $toEmail = $this->lib_utilitas->get_email_team( $team );
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
        $subject="Proses Produksi Pilot Selesai: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval UPB oleh PD Manager pada proses Produksi Pilot(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
                                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>Stabilita Pilot - Input data oleh PD</td>
                                </tr>
                        </table>
                </div>
                <br/> 
                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
                Post Master";
            $this->lib_utilitas->send_email($to, $cc, $subject, $content);	
        

        	//Next To stabilita Pilot Detail

            $cek_form = "SELECT * FROM pddetail.`formula_process` fp WHERE fp.`lDeleted` = 0 AND fp.`iMaster_flow` IN (9,10,11) AND fp.`iupb_id` IN (".$upbid.")";
			$dcek = $this->db_plc0->query($cek_form)->result_array();

			//Jika Kosong

			//Ampil Nomor Formula
			$sql_get_no = "SELECT puf.`vkode_surat`,puf.vversi FROM plc2.`plc2_upb_formula` puf WHERE puf.`ldeleted` = 0 AND puf.`ifor_id` = '".$ifor_id."'";

			$sql_get_no = "select * 
							from plc2.plc2_upb_formula a 
							join pddetail.formula_process b on b.iFormula_process=a.iFormula_process
							join pddetail.formula c on c.iFormula_process=b.iFormula_process
							where a.ldeleted=0
							and b.lDeleted=0
							and c.lDeleted=0
							and a.ifor_id= '".$ifor_id."' ";

			$no_for = $this->db_plc0->query($sql_get_no)->row_array();

			if(empty($dcek)){
				for($i=9;$i<12;$i++){
					$cNip = $this->user->gNIP;
					$dUpdate_time = date("Y-m-d H:i:s");
					$noFormula = $no_for['vNo_formula'];
					$versi = $no_for['iVersi'];
					//Insert Formula Proses
					$sqlto_Back = "INSERT pddetail.`formula_process` (`iupb_id`,`iMaster_flow`,`cCreated`,dCreate) VALUES
						('".$post['iupb_id']."','".$i."','".$cNip."',SYSDATE())";
					$this->db_plc0->query($sqlto_Back);
					$iFormula_process = $this->db_plc0->insert_id();

					//Insert Formula Proses Detail
					$pn = "INSERT INTO pddetail.`formula_process_detail`(iFormula_process, cPic, iProses_id, is_proses, dStart_time, cCreated, dCreate) VALUES ('".$iFormula_process."','".$cNip."','1','1','".$dUpdate_time."','".$cNip."','".$dUpdate_time."')";
					$this->db_plc0->query($pn);

					//Insert Formula Awal
					$iFd ='INSERT INTO pddetail.`formula_stabilita` (iFormula_process,dCreate,cCreated,vNo_formula,iVersi)
						VALUES("'.$iFormula_process.'","'.$dUpdate_time.'","'.$cNip.'","'.$noFormula.'","'.$versi.'")';
					$this->db_plc0->query($iFd);
				}
					
			}

		$data['status']  = true;
    	$data['last_id'] = $ifor_id;
    	return json_encode($data);
    }
  
	function listBox_product_trial_produksi_pilot_plc2_upb_prodpilot_iapppd_pp($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	//Keterangan approval 
	function updateBox_product_trial_produksi_pilot_vnip_apppd_pp($field, $id, $value, $rowData) {
		//print_r($rowData);
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_prodpilot');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_prodpilot m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			if(($row['iapppd_pp'] > 0)){
				$roww = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$row['vnip_apppd_pp']))->row_array();
				if($row['iapppd_pp']==2){$st="Approved";}
				elseif($row['iapppd_pp']==1){$st="Rejected";} 
				$ret= $st.' oleh '.$roww['vName'].' ( '.$row['vnip_apppd_pp'].' )'.' pada '.$row['tapppd_pp'];
			}
			else{
				$ret='Waiting for Approval';
			}	
		}
		else{
			$ret='Waiting for Approval';
		}
		return $ret;
	}
	public function listBox_Action($row, $actions) {
    	// jika proses produksi sudah di app tidak bisa di edit
		$ifor_id=$row->ifor_id;
		$this->db_plc0->where('ifor_id',$ifor_id);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sel="select * from plc2.plc2_upb_prodpilot where ifor_id=$ifor_id";
			$roww = $this->db_plc0->query($sel)->row_array();
			$iapppd_pp=isset($roww['iapppd_pp'])?$roww['iapppd_pp']:0;
			if($iapppd_pp > 0){
				unset($actions['edit']);
				unset($actions['delete']);
			}
		}
		return $actions;
    }
	function updateBox_product_trial_produksi_pilot_vkode_surat($name, $id, $value) {
		return $value;
	}
	function updateBox_product_trial_produksi_pilot_vupb_nomor($field, $id, $value, $rowData) {
		$sql = "SELECT vupb_nomor FROM plc2.plc2_upb_formula f, plc2.plc2_upb u
				WHERE f.iupb_id=u.iupb_id AND f.ifor_id='".$rowData['ifor_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		return $row['vupb_nomor'];
	}
	function updateBox_product_trial_produksi_pilot_vupb_nama($field, $id, $value, $rowData) {
		$sql = "SELECT vupb_nama FROM plc2.plc2_upb_formula f, plc2.plc2_upb u
				WHERE f.iupb_id=u.iupb_id AND f.ifor_id='".$rowData['ifor_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		return $row['vupb_nama'];
	}
	
	function updateBox_product_trial_produksi_pilot_dtglmulai_prod($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_prodpilot');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_prodpilot m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$this->load->helper('to_mysql');
			$value=$row['dtglmulai_prod'];
			$val = $value;
			$dis="";
			if($this->input->get('action')=='view'){
				$dis='disabled="TRUE"';
			}
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="15" class="input_tgl datepicker required" style="width:90px" '.$dis.' value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd",changeMonth: true,changeYear: true});
						</script>';
			return $return;
		}
		else{
			return '<input type="text" name="'.$id.'" id="'.$id.'" class="input_tgl datepicker input_rows1 required" size="10"/>';
		}
	}
	function updateBox_product_trial_produksi_pilot_dtglselesai_prod($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_prodpilot');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_prodpilot m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$this->load->helper('to_mysql');
			$value=$row['dtglselesai_prod'];
			$val = $value;
			$dis="";
			if($this->input->get('action')=='view'){
				$dis='disabled="TRUE"';
			}
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="15" class="input_tgl datepicker required" style="width:90px" '.$dis.' value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd",changeMonth: true,changeYear: true});
						</script>';
			return $return;
		}
		else{
			return '<input type="text" name="'.$id.'" id="'.$id.'" class="input_tgl datepicker input_rows1 required" size="10"/>';
		}
	}

	/*File Upload Stabilita Pilot*/
	function updateBox_product_trial_produksi_pilot_coaex($f, $i, $v, $row) {
		$data['grid_detail']=$f;
		$data['caption']="File Upload CoA Excipients";
		$data['id']=$row['ifor_id'];
		$data['get']=$this->input->get();
		return $this->load->view('lokal/pilot/datagrid_produksi_pilot_file',$data,TRUE);
	}

	function updateBox_product_trial_produksi_pilot_lsaex($f, $i, $v, $row) {
		$data['grid_detail']=$f;
		$data['caption']="File Upload LSA Excipients";
		$data['id']=$row['ifor_id'];
		$data['get']=$this->input->get();
		return $this->load->view('lokal/pilot/datagrid_produksi_pilot_file',$data,TRUE);
	}

	function updateBox_product_trial_produksi_pilot_soiex($f, $i, $v, $row) {
		$data['grid_detail']=$f;
		$data['caption']="File Upload SOI Excipients";
		$data['id']=$row['ifor_id'];
		$data['get']=$this->input->get();
		return $this->load->view('lokal/pilot/datagrid_produksi_pilot_file',$data,TRUE);
	}

	function updateBox_product_trial_produksi_pilot_lapprot_udt($f, $i, $v, $row) {
		$data['grid_detail']=$f;
		$data['caption']="File Laporan & Protokol UDT";
		$data['id']=$row['ifor_id'];
		$data['get']=$this->input->get();
		return $this->load->view('lokal/pilot/datagrid_produksi_pilot_file',$data,TRUE);
	}

	function updateBox_product_trial_produksi_pilot_prot_udt($f, $i, $v, $row) {
		$data['grid_detail']=$f;
		$data['caption']="File Protokol UDT";
		$data['id']=$row['ifor_id'];
		$data['get']=$this->input->get();
		return $this->load->view('lokal/pilot/datagrid_produksi_pilot_file',$data,TRUE);
	}

	function updateBox_product_trial_produksi_pilot_coars($f, $i, $v, $row) {
		$data['grid_detail']=$f;
		$data['caption']="File CoA RS ";
		$data['id']=$row['ifor_id'];
		$data['get']=$this->input->get();
		return $this->load->view('lokal/pilot/datagrid_produksi_pilot_file',$data,TRUE);
	}

	function updateBox_product_trial_produksi_pilot_coaws($f, $i, $v, $row) {
		$data['grid_detail']=$f;
		$data['caption']="File CoA WS";
		$data['id']=$row['ifor_id'];
		$data['get']=$this->input->get();
		return $this->load->view('lokal/pilot/datagrid_produksi_pilot_file',$data,TRUE);
	}

	function updateBox_product_trial_produksi_pilot_coabb_lsa($f, $i, $v, $row) {
		$data['grid_detail']=$f;
		$data['caption']="File CoA & LSA Zat Aktif";
		$data['id']=$row['ifor_id'];
		$data['get']=$this->input->get();
		return $this->load->view('lokal/pilot/datagrid_produksi_pilot_file',$data,TRUE);
	}

	function updateBox_product_trial_produksi_pilot_prot_stab($f, $i, $v, $row) {
		$data['grid_detail']=$f;
		$data['caption']="File Protokol Stabilita";
		$data['id']=$row['ifor_id'];
		$data['get']=$this->input->get();
		return $this->load->view('lokal/pilot/datagrid_produksi_pilot_file',$data,TRUE);
	}

	function updateBox_product_trial_produksi_pilot_draft_coafg($f, $i, $v, $row) {
		$data['grid_detail']=$f;
		$data['caption']="File Draft CoA FG";
		$data['id']=$row['ifor_id'];
		$data['get']=$this->input->get();
		return $this->load->view('lokal/pilot/datagrid_produksi_pilot_file',$data,TRUE);
	}
	
	function output(){
    	$this->index($this->input->get('action'));
    }
    
    function before_update_processor($row, $postData) {
		unset($postData['vkode_surat']);
		unset($postData['vupb_nomor']);
		unset($postData['vupb_nama']);
		return $postData;
    }
	function after_update_processor($row, $updateId, $postData) {
		$this->load->helper('to_mysql');
		$skrg = date('Y-m-d H:i:s');
		
		$ifor_id=$postData['ifor_id'];
		$this->dbset->where('ifor_id',$ifor_id);		
		$j2 = $this->dbset->count_all_results('plc2.plc2_upb_prodpilot');
		//data
		$data['ifor_id'] = $postData['ifor_id'];
		$data['dtglmulai_prod'] = $postData['dtglmulai_prod'];
		$data['dtglselesai_prod'] = $postData['dtglselesai_prod'];
		
		if($j2 > 0){
			//update data
			$this->dbset->where('ifor_id',$data['ifor_id']);
			$this->dbset->update('plc2.plc2_upb_prodpilot', array('dtglmulai_prod'=>$data['dtglmulai_prod'],'dtglselesai_prod'=>$data['dtglselesai_prod']));
		}
		else{
			//insert data
			$this->dbset->insert('plc2.plc2_upb_prodpilot',$data);
		}
		
		$sel="select * from plc2.plc2_upb_formula f where f.ifor_id=$ifor_id";
		$rowb = $this->db_plc0->query($sel)->row_array();
	}


	/*Optioanal Function*/
	function getDataFileUpload(){
		$post=$this->input->post();
    	$get=$this->input->get();

		switch ($get['filejenis']) {
			case 'coaex':
				$sql_data="select * from plc2.plc2_upb_file_coa_ex p where p.ldeleted=0 and p.ifor_id=".$post['id'];
				$rsel=array('filename','keterangan','update');
				$idpk='id';
				$vfilename='filename';
				$idpkheader='ifor_id';
				$thisfilepath=$this->pathcoax;
				break;

			case 'lsaex':
				$sql_data="select * from plc2.plc2_upb_file_lsa_ex p where p.ldeleted=0 and p.ifor_id=".$post['id'];
				$rsel=array('filename','keterangan','update');
				$idpk='id';
				$vfilename='filename';
				$idpkheader='ifor_id';
				$thisfilepath=$this->pathlsaex;
				break;

			case 'soiex':
				$sql_data="select * from plc2.plc2_upb_file_soi_ex p where p.ldeleted=0 and p.ifor_id=".$post['id'];
				$rsel=array('filename','keterangan','update');
				$idpk='id';
				$vfilename='filename';
				$idpkheader='ifor_id';
				$thisfilepath=$this->pathsoiex;
				break;

			case 'lapprot_udt':
				$sql_data="select * from plc2.plc2_upb_file_lapprot_udt p where p.ldeleted=0 and p.ifor_id=".$post['id'];
				$rsel=array('filename','keterangan','update');
				$idpk='id';
				$vfilename='filename';
				$idpkheader='ifor_id';
				$thisfilepath=$this->pathlapprot_udt;
				break;

			case 'prot_udt':
				$sql_data="select * from plc2.plc2_upb_pilot_file_prot_udt p where p.ldeleted=0 and p.ifor_id=".$post['id'];
				$rsel=array('filename','keterangan','update');
				$idpk='id';
				$vfilename='filename';
				$idpkheader='ifor_id';
				$thisfilepath=$this->pathprot_udt;
				break;

			case 'coars':
				$sql_data="select * from plc2.plc2_upb_pilot_file_coars p where p.ldeleted=0 and p.ifor_id=".$post['id'];
				$rsel=array('filename','keterangan','update');
				$idpk='id';
				$vfilename='filename';
				$idpkheader='ifor_id';
				$thisfilepath=$this->pathcoars;
				break;

			case 'coaws':
				$sql_data="select * from plc2.plc2_upb_pilot_file_coaws p where p.ldeleted=0 and p.ifor_id=".$post['id'];
				$rsel=array('filename','keterangan','update');
				$idpk='id';
				$vfilename='filename';
				$idpkheader='ifor_id';
				$thisfilepath=$this->pathcoaws;
				break;

			case 'coabb_lsa':
				$sql_data="select * from plc2.plc2_upb_pilot_file_coabb_lsa p where p.ldeleted=0 and p.ifor_id=".$post['id'];
				$rsel=array('filename','keterangan','update');
				$idpk='id';
				$vfilename='filename';
				$idpkheader='ifor_id';
				$thisfilepath=$this->pathcoabb_lsa;
				break;

			case 'prot_stab':
				$sql_data="select * from plc2.plc2_upb_pilot_file_prot_stab p where p.ldeleted=0 and p.ifor_id=".$post['id'];
				$rsel=array('filename','keterangan','update');
				$idpk='id';
				$vfilename='filename';
				$idpkheader='ifor_id';
				$thisfilepath=$this->pathprot_stab;
				break;

			case 'draft_coafg':
				$sql_data="select * from plc2.plc2_upb_pilot_file_draft_coafg p where p.ldeleted=0 and p.ifor_id=".$post['id'];
				$rsel=array('filename','keterangan','update');
				$idpk='id';
				$vfilename='filename';
				$idpkheader='ifor_id';
				$thisfilepath=$this->pathdraft_coafg;
				break;
			
			default:
				$sql_data="error_file";
				break;
		}
		$q=$this->dbset->query($sql_data);
		$data = new StdClass;
		$data->records=$q->num_rows();
		$i=0;
		foreach ($q->result() as $k) {
			$data->rows[$i]['id']=$i+1;
			$z=0;
			foreach ($rsel as $dsel => $vsel) {
				if($vsel=="update"){
					$ini=$i+1;
					$btn1="<input type='hidden' class='num_rows_tb_details_product_trial_produksi_pilot_".$get['filejenis']."' value='".$ini."' />";
					if($get['isubmit']==0){
					$btn1=$btn1."<button id='ihapus_tb_produksi_pilot_file_".$get['filejenis']."' class='ui-button-text icon_hapus' style='font-size: .8em !important;' onclick='javascript:hapus_row_tb_details_product_trial_produksi_pilot_".$get['filejenis']."(".$ini.")' type='button'>Hapus</button><input type='hidden' name='product_trial_produksi_pilot_id_pk_".$get['filejenis']."[]' value='".$k->{$idpk}."' />";
					}
					$value=$k->{$vfilename};
					$id=$k->{$idpkheader};
					$caption='No File';
					$btn2="";
					if($value != '') {
						if (file_exists('./'.$thisfilepath.'/'.$id.'/'.$value)) {
							$caption='Download';
							$link = base_url().'processor/plc/product/trial/produksi/pilot?action=download&filejenis='.$get['filejenis'].'&id='.$id.'&file='.$value;
							/*$btn2='<button id="download_product_trial_produksi_pilot_'.$get['filejenis'].'" class="ui-button-text icon-extlink" style="font-size: .8em !important;" onclick="alert(\'dsadsa\')">Download</button>';*/
							$btn2='<a style="font-size: .8em !important;" class="ui-button-text icon-extlink" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
						}
						else {
							$btn2 = ' [No File!]';
						}
					}
					else {
						$btn2 = ' [No File!]';
					}
					if($get['act']=='update'){
						$dataar[$dsel]=$btn1.$btn2;
					}else{
						$dataar[$dsel]=$btn2;
					}
				}else{
					$dataar[$dsel]=$k->{$vsel};
				}
				$z++;
			}
			$data->rows[$i]['cell']=$dataar;
			$i++;
		}
		return json_encode($data);
	}
}
