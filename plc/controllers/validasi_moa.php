<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class validasi_moa extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		//$this->db_plc0 = $this->load->database('plc', true);
		 $this->load->library('lib_flow');
		 $this->load->library('lib_utilitas');
		$this->user = $this->auth_localnon->user();
		$this->pathvfile="files/plc/validasi_moa";
		$this->pathlapvalmoa="files/plc/lap_valmoa";
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Validasi MOA');
		//dc.m_vendor  database.tabel

		$grid->setTitle('Validasi MOA');		
		$grid->setTable('plc2.plc2_vamoa');		
		$grid->setUrl('validasi_moa');
		$grid->addList('vnomor_moa','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','plc2_upb.iteampd_id','cPIC_AD','isubmit','iapppd');
		$grid->setSortBy('ivalmoa_id');
		$grid->setSortOrder('DESC');

		$grid->setAlign('vnomor_moa', 'Left');
		$grid->setWidth('vnomor_moa', '80');
		$grid->setLabel('vnomor_moa', 'Validasi MOA Nomor');

		$grid->setAlign('plc2_upb.vupb_nomor', 'Left');
		$grid->setWidth('plc2_upb.vupb_nomor', '80');
		$grid->setLabel('plc2_upb.vupb_nomor', 'UPB Nomor');

		$grid->setAlign('plc2_upb.vupb_nama', 'Left');
		$grid->setWidth('plc2_upb.vupb_nama', '200');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usuluan');

		$grid->setAlign('plc2_upb.vgenerik', 'Left');
		$grid->setWidth('plc2_upb.vgenerik', '200');
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');

		$grid->setAlign('plc2_upb.iteampd_id', 'Left');
		$grid->setWidth('plc2_upb.iteampd_id', '120');
		$grid->setLabel('plc2_upb.iteampd_id', 'Team PD');

		$grid->setAlign('cPIC_AD', 'Left');
		$grid->setWidth('cPIC_AD', '120');
		$grid->setLabel('cPIC_AD', 'PIC PD-AD');

		$grid->setAlign('isubmit', 'Left');
		$grid->setWidth('isubmit', '100');
		$grid->setLabel('isubmit', 'Status Submit');

		$grid->setAlign('iapppd', 'Left');
		$grid->setWidth('iapppd', '100');
		$grid->setLabel('iapppd', 'Approval PD');
				
		$grid->addFields('vnomor_moa','iupb_id','vupb_nama','vgenerik','cPIC_AD','dmulai_vamoa','dselesai_vamoa','vfile','lapvalmoa','iapppd');
		
		$grid->setLabel('iupb_id', 'Nomor UPB');
		$grid->setLabel('vupb_nama', 'Nama Usuluan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('dmulai_vamoa', 'Tgl Mulai Validasi MOA');
		$grid->setLabel('dselesai_vamoa', 'Tgl Selesai Validasi MOA');
		$grid->setLabel('vfile', 'Upload File Validated SOI FG');
		$grid->setLabel('lapvalmoa', 'Laporan Validasi MoA');

		$grid->setRequired('vnomor_moa','iupb_id','dmulai_vamoa','dselesai_vamoa','cPIC_AD','vfile','lapvalmoa');

		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('PD', $team)){
					$type='PD';
					$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
				}
				else{$type='';}
			}
		}
		$grid->setQuery('plc2_vamoa.lDeleted',0);
		//New Parameter For PLC Non OTC
		$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2.plc2_upb.iKill', 0);
		$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
		$grid->setQuery('plc2_upb.ihold', 0);

		$grid->setFormUpload(TRUE);
		
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_vamoa.iupb_id = plc2.plc2_upb.iupb_id', 'inner');
		$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));
		$grid->changeFieldType('iuji_mikro','combobox','',array(''=>'-- Pilih --',0=>'No',1=>'Yes'));
		$grid->changeFieldType('isubmit','combobox','',array(0=>'Need to Submit',1=>'Submited'));
		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','cPIC_AD');
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
   				if($isUpload) {
   					$lastId=$this->input->get('lastId');
					$path = realpath($this->pathvfile);
					if(!file_exists($path."/".$lastId)){
						if (!mkdir($path."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again! - '.$this->pathvfile);
						}
					}
					$fKeterangan = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'validasi_moa_vfile_fileketerangan') {
							foreach($value as $k=>$v) {
								$fKeterangan[$k] = $v;
							}
						}
					}
					$i=0;
					$sql=array();
					foreach ($_FILES['validasi_moa_vfile_upload_file']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {
							$tmp_name = $_FILES['validasi_moa_vfile_upload_file']["tmp_name"][$key];
							$name =$_FILES['validasi_moa_vfile_upload_file']["name"][$key];
							$data['filename'] = $name;
							//$data['id']=$idossier_dok_list_id;
							$data['dInsertDate'] = date('Y-m-d H:i:s');

								if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.plc2_vamoa_file (ivalmoa_id, vFilename, vKeterangan, dCreate, cCreate) 
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
						$this->db_plc0->query($q);
						}catch(Exception $e) {
						die($e);
						}
					}

					$path = realpath($this->pathlapvalmoa);
					if(!file_exists($path."/".$lastId)){
						if (!mkdir($path."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again! - '.$this->pathlapvalmoa);
						}
					}
					$fKeterangan = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'validasi_moa_lapvalmoa_fileketerangan') {
							foreach($value as $k=>$v) {
								$fKeterangan[$k] = $v;
							}
						}
					}
					$i=0;
					$sql=array();
					foreach ($_FILES['validasi_moa_lapvalmoa_upload_file']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {
							$tmp_name = $_FILES['validasi_moa_lapvalmoa_upload_file']["tmp_name"][$key];
							$name =$_FILES['validasi_moa_lapvalmoa_upload_file']["name"][$key];
							$data['filename'] = $name;
							//$data['id']=$idossier_dok_list_id;
							$data['dInsertDate'] = date('Y-m-d H:i:s');

								if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.plc2_vamoa_laporan_file (ivalmoa_id, vFilename, vKeterangan, dCreate, cCreate) 
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
						$this->db_plc0->query($q);
						}catch(Exception $e) {
						die($e);
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
				$lastId=$post['validasi_moa_ivalmoa_id'];

                if($isUpload) {
                	/*vfile*/
                	$filejenis='vfile';
					$pathvfile = realpath($this->pathvfile);
					if(!file_exists($pathvfile."/".$lastId)){
						if (!mkdir($pathvfile."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again - '.$filejenis.'!');
						}
					}
					$fKeterangan = array(); 
	                $fileid='';
	                foreach($_POST as $key=>$value) {     
	                    if ($key == 'validasi_moa_'.$filejenis.'_fileketerangan') {
	                        foreach($value as $y=>$u) {
	                            $fKeterangan[$y] = $u;
	                        }
	                    }
	                    if ($key == 'validasi_moa_id_pk_'.$filejenis) {
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
                        $sql1="update plc2.plc2_vamoa_file set ldeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where ivalmoa_id='".$lastId."' and ivamoa_file_id not in (".$fileid.")";
                        $this->db_plc0->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_vamoa_file set ldeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where ivalmoa_id='".$lastId."'";
                        $this->db_plc0->query($sql1);
                    }
                    $i=0;
                    $sql=array();
                    if (isset($_FILES['validasi_moa_'.$filejenis.'_upload_file']))  {
                        foreach ($_FILES['validasi_moa_'.$filejenis.'_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['validasi_moa_'.$filejenis.'_upload_file']["tmp_name"][$key];
                                $name =$_FILES['validasi_moa_'.$filejenis.'_upload_file']["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $pathvfile."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.plc2_vamoa_file (ivalmoa_id, vFilename, vKeterangan, dCreate, cCreate) 
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
                            $this->db_plc0->query($q);
                            }catch(Exception $e) {
                            die($e);
                            }
                        }
                    }

                    /*lapvalmoa*/
                	$filejenis='lapvalmoa';
					$pathlapvalmoa = realpath($this->pathlapvalmoa);
					if(!file_exists($pathlapvalmoa."/".$lastId)){
						if (!mkdir($pathlapvalmoa."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again - '.$filejenis.'!');
						}
					}
					$fKeterangan = array(); 
	                $fileid='';
	                foreach($_POST as $key=>$value) {     
	                    if ($key == 'validasi_moa_'.$filejenis.'_fileketerangan') {
	                        foreach($value as $y=>$u) {
	                            $fKeterangan[$y] = $u;
	                        }
	                    }
	                    if ($key == 'validasi_moa_id_pk_'.$filejenis) {
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
                        $sql1="update plc2.plc2_vamoa_laporan_file set ldeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where ivalmoa_id='".$lastId."' and ivamoa_lapfile_id not in (".$fileid.")";
                        $this->db_plc0->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_vamoa_laporan_file set ldeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where ivalmoa_id='".$lastId."'";
                        $this->db_plc0->query($sql1);
                    }
                    $i=0;
                    $sql=array();
                    if (isset($_FILES['validasi_moa_'.$filejenis.'_upload_file']))  {
                        foreach ($_FILES['validasi_moa_'.$filejenis.'_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['validasi_moa_'.$filejenis.'_upload_file']["tmp_name"][$key];
                                $name =$_FILES['validasi_moa_'.$filejenis.'_upload_file']["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $pathlapvalmoa."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.plc2_vamoa_laporan_file (ivalmoa_id, vFilename, vKeterangan, dCreate, cCreate) 
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
                            $this->db_plc0->query($q);
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
                	/*vfile*/
                    $filejenis='vfile';
                    $fileid='';
                    foreach($_POST as $key=>$value) {
	                    if ($key == 'validasi_moa_id_pk_'.$filejenis) {
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
                        $sql1="update plc2.plc2_vamoa_file set ldeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where ivalmoa_id='".$lastId."' and ivamoa_file_id not in (".$fileid.")";
                        $this->db_plc0->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_vamoa_file set ldeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where ivalmoa_id='".$lastId."'";
                        $this->db_plc0->query($sql1);
                    }
                    /*lapvalmoa*/
                    $filejenis='lapvalmoa';
                    $fileid='';
                    foreach($_POST as $key=>$value) {
	                    if ($key == 'validasi_moa_id_pk_'.$filejenis) {
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
                        $sql1="update plc2.plc2_vamoa_laporan_file set ldeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where ivalmoa_id='".$lastId."' and ivamoa_lapfile_id not in (".$fileid.")";
                        $this->db_plc0->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                       $sql1="update plc2.plc2_vamoa_laporan_file set ldeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where ivalmoa_id='".$lastId."'";
                        $this->db_plc0->query($sql1);
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
			case 'getemployee':
				echo $this->getEmployee();
				break;
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();
		    	
		    	$cNip= $this->user->gNIP;
				$tApprove=date('Y-m-d H:i:s');
				$sql="update plc2.plc2_vamoa set capppd='".$cNip."', dapppd='".$tApprove."', iapppd=2 where ivalmoa_id='".$get['last_id']."'";
				$this->db_plc0->query($sql);

				$sql="select iupb_id from plc2.plc2_vamoa where ivalmoa_id='".$get['last_id']."' and lDeleted=0 LIMIT 1";
				$dt=$this->db_plc0->query($sql)->row_array();
				$iupb_id=$dt['iupb_id'];

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

		        //$query = $this->db_plc0->query($rsql);

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
		        $subject="Proses : Validasi MOA - UPB :".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada approval oleh PD Manager pada proses Validasi MOA(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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

				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Confirm Success!';
				echo json_encode($r);
				exit();
				break;
			case 'getDataFileUpload':
				echo $this->getDataFileUpload();
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
				where em.vName like "%'.$term.'%" and (te.vtipe="PD" OR te.vtipe="AD") AND it.ldeleted=0 order by em.vname ASC';
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
function listBox_validasi_moa_iapppd($value) {
	if($value==0){$vstatus='Waiting for approval';}
	elseif($value==1){$vstatus='Rejected';}
	elseif($value==2){$vstatus='Approved';}
	return $vstatus;
}
function listBox_validasi_moa_cPIC_AD($value) {
	$data='-';
	$sql='select em.cNip as cNip, em.vName as vName from hrd.employee em where em.cNip="'.$value.'" LIMIT 1';
	$dt=$this->db_plc0->query($sql)->row_array();
	if($dt){
		$data=$dt['cNip'].' - '.$dt['vName'];
	}
	return $data;
}
function listBox_Action($row, $actions) {
    if($row->isubmit<>0){
    	unset($actions['delete']);
    }
    if($row->iapppd<>0){
    	unset($actions['edit']);
    }
    if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('PD', $team)){
					$type='PD';
					if($row->isubmit<>0){
				    	unset($actions['edit']);
				    }
				}
				else{$type='';}
			}
		}
    return $actions; 

	}
/*manipulasi view object form start*/
 	function insertBox_validasi_moa_vnomor_moa($field,$id){
 		return 'Auto Generate';
 	}

	function insertBox_validasi_moa_iupb_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/validasi/moa/popup?field=validasi_moa&modul_id='.$this->input->get('modul_id').'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	function insertBox_validasi_moa_vupb_nama($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="20" />';
	}
	function insertBox_validasi_moa_vgenerik($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="20" />';
	}
	function insertBox_validasi_moa_dmulai_vamoa($field, $id){
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker" style="width:130px"/>';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
					</script>';
		return $return;
	}
	function insertBox_validasi_moa_dselesai_vamoa($field, $id){
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker" style="width:130px"/>';
		$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
						
					</script>';
		return $return;
	}
	function insertBox_validasi_moa_cPIC_AD($field,$id){
		$url = base_url().'processor/plc/validasi/moa?action=getemployee';
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
		      </script>
		<input name="'.$id.'" id="'.$id.'" type="hidden"/>
		<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20"/>';
		return $return;
	}

    function insertBox_validasi_moa_vfile($field, $id) {
    	$data['grid_detail']=$field;
		$data['caption']="File Validated SOI FG";
		$data['id']=0;
		$data['get']=$this->input->get();	
		return $this->load->view('validasi_moa_file',$data,TRUE);
	}

    function insertBox_validasi_moa_lapvalmoa($field, $id) {
    	$data['grid_detail']=$field;
		$data['caption']="File Laporan Validasi MoA";
		$data['id']=0;
		$data['get']=$this->input->get();	
		return $this->load->view('validasi_moa_file',$data,TRUE);
	}

	function insertBox_validasi_moa_iapppd($field, $id) {
    	return '-';
	}

	function updateBox_validasi_moa_iupb_id($field, $id, $value, $rowData){
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
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value='.$value.' />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" value="'.$dt['vupb_nomor'].'" size="20" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/validasi/moa/popup?field=validasi_moa&modul_id='.$this->input->get('modul_id').'\',\'List UPB\')" type="button">&nbsp;</button>';
		}
		return $return;
	}

	function updateBox_validasi_moa_vupb_nama($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nama'];
		}else{
			$return='<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="20" value="'.$dt['vupb_nama'].'" />';
		}
		return $return;
	}
	function updateBox_validasi_moa_vgenerik($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vgenerik'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="20" value="'.$dt['vgenerik'].'" />';
		}
		return $return;
	}

	function updateBox_validasi_moa_dmulai_vamoa($field, $id, $value, $rowData) {
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker" style="width:130px" value='.$value.' />';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
					</script>';
		}
		return $return;
	}
	function updateBox_validasi_moa_dselesai_vamoa($field, $id, $value, $rowData) {
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker" style="width:130px" value='.$value.' />';
		$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
						
					</script>';
		}
		return $return;
	}
	function updateBox_validasi_moa_cPIC_AD($field, $id, $value, $rowData) {
		$sql="select * from hrd.employee em where em.cNip='".$value."'";
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return	=$dt['vName'];
		}else{
		$url = base_url().'processor/plc/validasi/moa?action=getemployee';
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
		      </script>
		<input name="'.$id.'" id="'.$id.'" type="hidden" value="'.$value.'"/>
		<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20" value="'.$dt['vName'].'"/>';
		}
		return $return;
	}

    function updateBox_validasi_moa_vfile($field, $id, $value, $rowData) {
		$data['grid_detail']=$field;
		$data['caption']="File Laporan & Protokol UDT";
		$data['id']=$rowData['ivalmoa_id'];
		$data['isubmit']=$rowData['iapppd'];
		$data['get']=$this->input->get();
		return $this->load->view('validasi_moa_file',$data,TRUE);
	}

	function updateBox_validasi_moa_lapvalmoa($field, $id, $value, $rowData) {
		$data['grid_detail']=$field;
		$data['caption']="File Laporan & Protokol UDT";
		$data['id']=$rowData['ivalmoa_id'];
		$data['isubmit']=$rowData['iapppd'];
		$data['get']=$this->input->get();
		return $this->load->view('validasi_moa_file',$data,TRUE);
	}

	function updateBox_validasi_moa_iapppd($field, $id, $value, $rowData) {
    	if($rowData['capppd'] != null){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['capppd']))->row_array();
			if($rowData['iapppd']==2){$st="Approved";}elseif($rowData['iapppd']==1){$st="Rejected";} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['capppd'].' )'.' pada '.$rowData['dapppd'];
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
/*manipulasi view object form end*/

/*manipulasi proses object form start*/
    function manipulate_insert_button($buttons) {
		unset($buttons['save']);
		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'validasi_moa\', \''.base_url().'processor/plc/validasi/moa?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_validasi_moa">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'validasi_moa\', \''.base_url().'processor/plc/validasi/moa?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_validasi_moa">Save &amp; Submit</button>';
		$js = $this->load->view('validasi_moa_js');
		$js .= $this->load->view('uploadjs');
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){$type='PD';
				$buttons['save'] = $save_draft.$save.$js;
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';
				$buttons['save'] = $save_draft.$save.$js;
			}
			else{$type='';}
		}
		return $buttons;
	}
	function manipulate_update_button($buttons, $rowData){
		//print_r($rowData);exit();
		unset($buttons['update']);
		$js=$this->load->view('validasi_moa_js');
		$js .= $this->load->view('uploadjs');
		$cNip=$this->user->gNIP;
		$sql= "select * from plc2.plc2_upb up 
			where up.iupb_id=".$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		$setuju = '<button onclick="javascript:setuju(\'validasi_moa\', \''.base_url().'processor/plc/validasi/moa?action=confirm&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Confirm</button>';
		$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/validasi/moa?action=approve&ivalmoa_id='.$rowData['ivalmoa_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_validasi_moa">Approve</button>';
		$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/validasi/moa?action=reject&ivalmoa_id='.$rowData['ivalmoa_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_validasi_moa">Reject</button>';

		$updates = '<button onclick="javascript:update_btn(\'validasi_moa\', \''.base_url().'processor/plc/validasi/moa?company_id='.$this->input->get('company_id').'&draft=nol&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_validasi_moa">Update</button>';
		$update = '<button onclick="javascript:update_btn_back(\'validasi_moa\', \''.base_url().'processor/plc/validasi/moa?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_validasi_moa">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'validasi_moa\', \''.base_url().'processor/plc/validasi/moa?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_validasi_moa">Update as Draft</button>';
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){

				$type='PD';
				if($rowData['isubmit']==0){
					$buttons['update']=$updatedraft.$update.$js;
				}
				elseif(($rowData['isubmit']<>0)&&($rowData['iapppd']==0)){
					$buttons['update']=$updates.$setuju.$js;
				}else{}
			}else{

				$type='';
			}
		}else{

			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				if($rowData['isubmit']==0){
					$buttons['update']=$updatedraft.$update.$js;
				}else{}
			}else{
				$type='';
			}
		}
		return $buttons;
	}
   
/*manipulasi proses object form end*/    
function before_insert_processor($row, $postData) {
	unset($postData['iapppd']);
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreate'] =$this->user->gNIP;
		if($postData['isdraft']==true){
			$postData['isubmit']=0;
		} 
		else{$postData['isubmit']=1;} 
	//print_r($postData);exit();
	return $postData;

}
function before_update_processor($row, $postData) {
	unset($postData['iapppd']);
	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;
		if($postData['isdraft']==true){
			if($postData['isdraft']=='nol'){
				$postData['isubmit']=1;
			}else{
				$postData['isubmit']=0;
			}
			
		} 
		else{$postData['isubmit']=1;} 
	//print_r($postData);exit();
	return $postData;

}
function after_insert_processor($row, $insertId, $postData){
	$iupb_id=$postData['iupb_id'];

	$nomor = "V".str_pad($insertId, 5, "0", STR_PAD_LEFT);
	$sql = "UPDATE plc2.plc2_vamoa SET vnomor_moa = '".$nomor."' WHERE ivalmoa_id=$insertId LIMIT 1";
	//print_r($postData);
	$query = $this->db_plc0->query( $sql );
	//if($postData['isubmit']==1){
	//	$this->lib_flow->insert_logs($this->input->get('modul_id'),$iupb_id,1);
	//}
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
										$.get(base_url+"processor/plc/validasi/moa?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
	                            			 $("div#form_validasi_moa").html(data);
	                    				});
									
								}
									reload_grid("grid_validasi_moa");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_validasi_moa_approve" action="'.base_url().'processor/plc/validasi/moa?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="ivalmoa_id" value="'.$this->input->get('ivalmoa_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_validasi_moa_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function approve_process(){
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.plc2_vamoa set vRemark='".$vRemark."',capppd='".$cNip."', dapppd='".$tApprove."', iapppd=2 where ivalmoa_id='".$post['ivalmoa_id']."'";
		$this->db_plc0->query($sql);

		$sql="select iupb_id from plc2.plc2_vamoa where ivalmoa_id='".$post['ivalmoa_id']."' and lDeleted=0 LIMIT 1";
		$dt=$this->db_plc0->query($sql)->row_array();
		$iupb_id=$dt['iupb_id'];
		//$this->lib_flow->insert_logs($post['modul_id'],$iupb_id,9,2);

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

        //$query = $this->db_plc0->query($rsql);

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
        $subject="Proses : Validasi MOA".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval oleh PD Manager pada proses Validasi MOA(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
        
		$data['group_id']=$post['group_id'];
		$data['modul_id']=$post['modul_id'];
		$data['status']  = true;
		$data['last_id'] = $post['ivalmoa_id'];
		
		return json_encode($data);
	}

function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_validasi_moa_vRemark").val();
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
								var url = "'.base_url().'processor/plc/validasi/moa";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
										 $("div#form_validasi_moa").html(data);
									});
									
								}
									reload_grid("grid_validasi_moa");
							}
					 	 	
					 	 })
					
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_validasi_moa_reject" action="'.base_url().'processor/plc/validasi/moa?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="ivalmoa_id" value="'.$this->input->get('ivalmoa_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_validasi_moa_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.plc2_vamoa set vRemark='".$vRemark."',capppd='".$cNip."', dapppd='".$tApprove."', iapppd=1 where ivalmoa_id='".$post['ivalmoa_id']."'";
		$this->db_plc0->query($sql);
		$data['group_id']=$post['group_id'];
		$data['modul_id']=$post['modul_id'];
		$data['status']  = true;
		$data['last_id'] = $post['ivalmoa_id'];
		return json_encode($data);
	}

	/*function pendukung end*/    	
	
	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		switch ($_GET['filejenis']) {
			case 'vfile':
				$tempat=$this->pathvfile;
				break;
			case 'lapvalmoa':
				$tempat=$this->pathlapvalmoa;
				break;
			
			default:
				$tempat="NULL";
				break;
		}
		$path = file_get_contents('./'.$tempat.'/'.$id.'/'.$name);	
		force_download($name, $path);
	}

	public function output(){
		$this->index($this->input->get('action'));
	}

	function getDataFileUpload(){
		$post=$this->input->post();
    	$get=$this->input->get();

		switch ($get['filejenis']) {
			case 'vfile':
				$sql_data="select * from plc2.plc2_vamoa_file p where p.ldeleted=0 and p.ivalmoa_id=".$post['id'];
				$rsel=array('vFilename','vKeterangan','update');
				$idpk='ivamoa_file_id';
				$vfilename='vFilename';
				$idpkheader='ivalmoa_id';
				$thisfilepath=$this->pathvfile;
				break;
			case 'lapvalmoa':
				$sql_data="select * from plc2.plc2_vamoa_laporan_file p where p.ldeleted=0 and p.ivalmoa_id=".$post['id'];
				$rsel=array('vFilename','vKeterangan','update');
				$idpk='ivamoa_lapfile_id';
				$vfilename='vFilename';
				$idpkheader='ivalmoa_id';
				$thisfilepath=$this->pathlapvalmoa;
				break;
			
			default:
				$sql_data="error_file";
				break;
		}
		$q=$this->db_plc0->query($sql_data);
		$data = new StdClass;
		$data->records=$q->num_rows();
		$i=0;
		foreach ($q->result() as $k) {
			$data->rows[$i]['id']=$i+1;
			$z=0;
			foreach ($rsel as $dsel => $vsel) {
				if($vsel=="update"){
					$ini=$i+1;
					$btn1="<input type='hidden' class='num_rows_tb_details_validasi_moa_".$get['filejenis']."' value='".$ini."' />";
					if($get['isubmit']==0){
					$btn1=$btn1."<button id='ihapus_tb_validasi_moa_file_".$get['filejenis']."' class='ui-button-text icon_hapus' style='font-size: .8em !important;' onclick='javascript:hapus_row_tb_details_validasi_moa_".$get['filejenis']."(".$ini.")' type='button'>Hapus</button><input type='hidden' name='validasi_moa_id_pk_".$get['filejenis']."[]' value='".$k->{$idpk}."' />";
					}
					$value=$k->{$vfilename};
					$id=$k->{$idpkheader};
					$caption='No File';
					$btn2="";
					if($value != '') {
						if (file_exists('./'.$thisfilepath.'/'.$id.'/'.$value)) {
							$caption='Download';
							$link = base_url().'processor/plc/validasi/moa?action=download&filejenis='.$get['filejenis'].'&id='.$id.'&file='.$value;
							/*$btn2='<button id="download_validasi_moa_'.$get['filejenis'].'" class="ui-button-text icon-extlink" style="font-size: .8em !important;" onclick="alert(\'dsadsa\')">Download</button>';*/
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
