<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_prareg_hpr extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('lib_plc');
        $this->modul_id = $this->input->get('modul_id');
        $this->iModul_id = $this->lib_plc->getIModulID($this->input->get('modul_id'));
        $this->db = $this->load->database('plc0',false, true);
        $this->load->library('auth');
        $this->user = $this->auth->user();
        $this->load->library('lib_utilitas');

        $this->team = $this->lib_plc->hasTeam($this->user->gNIP);
        $this->teamID = $this->lib_plc->hasTeamID($this->user->gNIP);
        $this->isAdmin=$this->lib_plc->isAdmin($this->user->gNIP);

		$this->title = 'Praregistrasi (TD & HPR)';
		$this->url = 'v3_prareg_hpr';
		$this->urlpath = 'plc/'.str_replace("_","/", $this->url);
		$this->load->model('v3_m_reg');

		$this->maintable = 'plc2.plc2_upb';	
		$this->main_table = $this->maintable;	
		$this->main_table_pk = 'iupb_id';	
		$datagrid['islist'] = array(
			'vupb_nomor' => array('label'=>'No UPB','width'=>75,'align'=>'center','search'=>true)
			,'vupb_nama' => array('label'=>'Nama Usulan','width'=>250,'align'=>'left','search'=>true)
			,'vgenerik' => array('label'=>'Nama Generik','width'=>250,'align'=>'left','search'=>false)
			,'iappbd_hpr' => array('label'=>'Approval Busdev','width'=>250,'align'=>'left','search'=>true)
		);		

		$datagrid['setQuery']=array(
								0=>array('vall'=>'plc2_upb.lDeleted','nilai'=>0)
								,1=>array('vall'=>'plc2_upb.ineed_prareg','nilai'=>1)
								,2=>array('vall'=>'plc2_upb.iconfirm_dok','nilai'=>2)
								,3=>array('vall'=>'plc2_upb.tsubmit_prareg is not null','nilai'=>NULL)
								,4=>array('vall'=>'plc2_upb.tsubmit_prareg <> 0000-00-00','nilai'=>NULL)
								);
		/* $datagrid['jointableinner']=array(
								0=>array('plc2.plc2_upb'=>'plc2_upb.iupb_id=validasi_proses.iupb_id')
								); */
		$datagrid['shortBy']=array("plc2_upb.vupb_nomor"=>"DESC");
		
		$this->datagrid=$datagrid;
    }

    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle($this->title);		
		$grid->setTable($this->maintable );
		$grid->setUrl($this->url);

		/*$grid->setGroupBy($this->setGroupBy);*/
		/*Untuk Field*/
		$grid->addFields('form_detail');
		foreach ($this->datagrid as $kv => $vv) {
			/*Untuk List*/
			if($kv=='islist'){
				foreach ($vv as $list => $vlist) {
					$grid->addList($list);
					foreach ($vlist as $kdis => $vdis) {
						if($kdis=='label'){
							$grid->setLabel($list, $vdis);
						}
						if($kdis=='width'){
							$grid->setWidth($list, $vdis);
						}
						if($kdis=='align'){
							$grid->setAlign($list, $vdis);
						}
						if($kdis=='search' && $vdis==true){
							$grid->setSearch($list);
						}
					}
				}
			}

			/*Untuk Short List*/
			if($kv=='shortBy'){
				foreach ($vv as $list => $vlist) {
					$grid->setSortBy($list);
					$grid->setSortOrder($vlist);
				}
			}

			if($kv=='inputGet'){
				foreach ($vv as $list => $vlist) {
					$grid->setInputGet($list,$vlist);
				}
			}

			if($kv=='jointableinner'){
				foreach ($vv as $list => $vlist) {
					foreach ($vlist as $tbjoin => $onjoin) {
						$grid->setJoinTable($tbjoin, $onjoin, 'inner');
					}
				}
			}
			if($kv=='setQuery'){
				foreach ($vv as $list => $vlist) {
					$grid->setQuery($vlist['vall'], $vlist['nilai']);
				}
			}

		}

		$grid->changeFieldType('isubmit', 'combobox','',array(''=>'--select--',0=>'Draft - Need to be Submit', 1=>'Submited'));
		$grid->changeFieldType('iappbd_hpr', 'combobox','',array(''=>'--select--',0=>'Waiting for approval',1=>'Rejected', 2=>'Approved'));

		$grid->setGridView('grid');

		switch ($action) {
			case 'json':
				$grid->getJsonData();
                break;	

            case 'hilang1':
				$this->hilang1();
				break;	
			case 'donefile';
				$this->donefile();
				break;	
			case 'hapustable';
				$this->hapustable();
			case 'donefileall';
				$this->donefileall();
				break;	
			case 'donefilerevisi';
				$this->donefilerevisi();
                break;
            case 'cekDoneProses':

                $post=$this->input->post();
                $sql = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                JOIN plc2.hprfile3 h3 ON h3.ihprfile2 = h2.ihprfile2
                WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 AND h3.ldelete = 0 
                AND h3.irevisi = 2 AND h3.iDone = 1 AND h2.iDoneAll =  1 AND  h.iupb_id = '".$post['iupb_id']."'";
                $c1 = $this->db->query($sql)->num_rows();
                $sql2 = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                    JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                    JOIN plc2.hprfile3 h3 ON h3.ihprfile2 = h2.ihprfile2
                    WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 AND h3.ldelete = 0  
                    AND h.iupb_id = '".$post['iupb_id']."'";
                $c2 = $this->db->query($sql2)->num_rows();


                $sql3 = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                    JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1 
                    WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0  #AND (h2.dcAndev<>'0000-00-00' AND h2.dcAndev IS NOT NULL)
                    AND h2.vTeamPD='AD' AND h2.iDoneAll =  1 AND  h.iupb_id = '".$post['iupb_id']."'";
                $c11 = $this->db->query($sql3)->num_rows();
                $sql4 = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                    JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1 
                    WHERE h.idoneAdd=1 AND h2.vTeamPD='AD' AND h2.ldelete=0 AND h.ldelete = 0 AND h.iupb_id = '".$post['iupb_id']."'";
                $c22 = $this->db->query($sql4)->num_rows();


                $sqL5 = "SELECT  h.ihprfile1 FROM plc2.hprfile1 h   
                    WHERE h.idoneAdd=1 AND h.ldelete = 0 AND  h.iupb_id = '".$post['iupb_id']."'";
                $c111 = $this->db->query($sqL5)->num_rows();
                $sqL6 = "SELECT  h.ihprfile1 FROM plc2.hprfile1 h   
                    WHERE h.ldelete = 0 AND  h.iupb_id = '".$post['iupb_id']."'";
                $c222 = $this->db->query($sqL6)->num_rows();
                
                $sqL3 = "SELECT  h2.ihprfile2 FROM plc2.hprfile2 h2 
                JOIN  plc2.hprfile1 h on h2.ihprfile1=h.ihprfile1
                WHERE h.ldelete = 0 AND h2.ldelete=0 AND h.iupb_id = '".$post['iupb_id']."'";
                $c3 = $this->db->query($sqL3)->num_rows();

                $sql4="SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                    JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                    JOIN plc2.hprfile3 h3 ON h3.ihprfile2 = h2.ihprfile2
                    WHERE h2.ldelete=0 AND h.ldelete = 0 AND h3.ldelete = 0  
                    AND h.iupb_id = '".$post['iupb_id']."'";
                $c4 = $this->db->query($sql4)->num_rows();

                /* Cek Grouping Semua Done */

                $sqlD="SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                    JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                    WHERE h2.ldelete=0 AND h.ldelete = 0 and h2.iDoneAll=0
                    AND h.iupb_id = '".$post['iupb_id']."'";
                $cD = $this->db->query($sqlD)->num_rows();

                $sqljj="select h1.ihprfile1 from plc2.hprfile1 h1 where  h1.ldelete = 0 AND h1.iupb_id = '".$post['iupb_id']."'";
                $sqljd="select h1.ihprfile1 from  plc2.hprfile2 h1 
                    join plc2.hprfile1 h2 on h2.ihprfile1=h1.ihprfile1 
                    join  plc2.hprfile3 h3 on h1.ihprfile2=h3.ihprfile2 
                    where  h2.ldelete = 0 AND h1.ldelete = 0 AND h2.iupb_id = '".$post['iupb_id']."' and h3.ldelete = 0
                    group by h1.ihprfile1";
                
                    $row111=$this->db->query($sqljj)->num_rows();
                    $row222=$this->db->query($sqljd)->num_rows();

                //Cek Don File untuk Manager Khusus Dia
                $sqlmm="select h1.ihprfile2 from  plc2.hprfile2 h1 
                    join plc2.hprfile1 h2 on h2.ihprfile1=h1.ihprfile1 
                    where  h2.ldelete = 0 AND h1.ldelete = 0 AND h2.iupb_id = '".$post['iupb_id']."'
                    group by h1.ihprfile2";
                $sqlnn="select h1.ihprfile2 from  plc2.hprfile2 h1 
                        join plc2.hprfile1 h2 on h2.ihprfile1=h1.ihprfile1 
                        join  plc2.hprfile3 h3 on h1.ihprfile2=h3.ihprfile2 
                        where  h2.ldelete = 0 AND h1.ldelete = 0 AND h2.iupb_id = '".$post['iupb_id']."' and h3.ldelete = 0
                        group by h1.ihprfile2";
                $rowmm=$this->db->query($sqlmm)->num_rows();
                $rownn=$this->db->query($sqlnn)->num_rows();

                $return['status']=0;

                if($c1==$c2 && $c11==$c22 && $c111==$c222){  
                    if($c222>0&&$c3>0&&$c4>0&&$sqlD==0&&$row111==$row222&&$rowmm==$rownn){
                       $return['status']=1;  
                    }
                }
                echo json_encode($return);
                break;                        
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
   				echo $grid->saved_form();
				break;
            case 'updateinsert':
                $post=$this->input->post();
                $get=$this->input->get();
                $iupb_id=$post['iupb_id'];
                $dataupdate['tsubmit_prareg']=$post['tsubmit_prareg'];
                $dataupdate['ttarget_hpr']=$post['ttarget_hpr'];
                $dataupdate['itambahan_hpr']=$post['itambahan_hpr'];
                $this->db->where('iupb_id',$iupb_id);
                $this->db->update('plc2.plc2_upb',$dataupdate);
                $datafeed=array();
                foreach ($get as $kget => $vget) {
                    if($kget!="action"){
                        $datafeed[$kget]=$vget;
                    }
                }
                $datafeed['status']=TRUE;
                $datafeed['last_id']=$iupb_id;
                $datafeed['message']="Data Berhasil di Simpan";
                echo json_encode($datafeed);
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				$post=$this->input->post();
				$get=$this->input->get();
				$lastId=isset($post[$this->url."_".$this->main_table_pk])?$post[$this->url."_".$this->main_table_pk]:"0";
				$dataFieldUpload=$this->lib_plc->getUploadFileFromField($this->input->get('modul_id'));
				if(count($dataFieldUpload)>0 && $lastId!="0" && $lastId!=""){
					foreach ($dataFieldUpload as $kf => $vUpload) {
						$pathf=$vUpload['filepath'];
						$iddetails=$vUpload['fielddetail'];

						$validdetails=array();

						foreach ($post as $kk => $vv) {
							if($kk=='fileDokPrareg_iFile'){
								foreach ($vv as $kv2 => $vv2) {
									$validdetails[]=$vv2;
								}
								
							}
						}
						$dataupdate['iDeleted']=1;
						$dataupdate['dUpdate']=date("Y-m-d H:i:s");
						$dataupdate['cUpdate']=$this->user->gNIP;
						if(count($validdetails)>0){
							$this->db_plc0->where('idHeader_File',$lastId)
                                            ->where_not_in('iFile',$validdetails)
                                            ->where('iM_modul_fileds',$vUpload['iM_modul_fileds'])
											->update('plc2.group_file_upload',$dataupdate);
						}else{
                            $this->db_plc0->where('idHeader_File',$lastId)
                                            ->where('iM_modul_fileds',$vUpload['iM_modul_fileds'])
											->update('plc2.group_file_upload',$dataupdate);
						}

						// Delete File
						$where=array('iDeleted'=>1,'idHeader_File'=>$lastId,'iM_modul_fileds'=>$vUpload['iM_modul_fileds']);
						$this->db_plc0->where($where);
						$qq=$this->db_plc0->get('plc2.group_file_upload');
						if($qq->num_rows() > 0){
							$result=$qq->result_array();
							foreach ($result as $kr => $vr) {
								if(isset($vr["vFilename_generate"])){
									$pathf=$vUpload['filepath'];
									$path = realpath($pathf);
									if(file_exists($path."/".$lastId."/".$vr["vFilename_generate"])){
										unlink($path."/".$lastId."/".$vr["vFilename_generate"]);
									}
								}
							}

						}
					}
				}
				$sqlIn = "SELECT h.ihprfile1, h.idoneAdd FROM plc2.hprfile1 h WHERE h.ldelete = 0 AND h.iupb_id = '".$lastId."'";
                $rowIn = $this->db->query($sqlIn)->result_array();  
                $i=0;
                    
                foreach ($rowIn as $r) {
                    if($r['idoneAdd']==0){
                        if($i==0){
                            $sqlCk = "SELECT * FROM plc2.hprfile2 h WHERE h.ldelete = 0 AND h.ihprfile1 =".$r['ihprfile1'];
                            $cekNum = $this->db->query($sqlCk)->num_rows();
                            if($cekNum>0){
                                //Delete yang Lama
                                $sqlDl = "UPDATE plc2.hprfile2 h SET h.ldelete = 1 AND h.ihprfile1 = ".$r['ihprfile1'];
                                $this->db->query($sqlDl); 
                            }
                            $i++;
                        }

                        $Deadline = array();
                        $vpic_td_dis = array();
                        $namaDokumen = array();

                        $ij = 0;
                        foreach($_POST as $key=>$value) {  
                            if ($key == 'Deadline_'.$r['ihprfile1']) {
                                foreach($value as $y=>$u) {
                                    $Deadline[$y] = $u;
                                }
                            }
                            if ($key == 'vpic_td_dis_'.$r['ihprfile1']) {
                                foreach($value as $y=>$u) {
                                    $vpic_td_dis[$y] = $u;
                                }
                            }
                            if ($key == 'namaDokumen_'.$r['ihprfile1']) {
                                foreach($value as $y=>$u) {
                                    $namaDokumen[$y] = $u;
                                    $ij++;
                                }
                            }  
                        }

                        if($ij>0){
                            $ii = 0;
                            foreach ($namaDokumen as $n) {
                                if(!empty($n)){
                                    $sql="INSERT INTO plc2.hprfile2 (ihprfile1, vnamaDokumen, dDeadline, vTeamPD, dcreate, ccreate) 
                                                    VALUES (".$r['ihprfile1'].",'".$n."','".$Deadline[$ii]."','".$vpic_td_dis[$ii]."','".date('Y-m-d h:i:s')."','".$this->user->gNIP."')";
                                    $this->db->query($sql); 
                                }
                                $ii++;
                            } 
                        } 


                    }else{
                        $sqHP1 = "SELECT h.ihprfile2 FROM plc2.hprfile2 h WHERE h.ldelete = 0 AND h.ihprfile1 =".$r['ihprfile1'];
                        $quHP1 = $this->db->query($sqHP1)->result_array();
                        foreach ($quHP1 as $r2) {
                            foreach($_POST as $key=>$value) {  
                                if ($key == 'DeadlineAD_'.$r2['ihprfile2']) {
                                    foreach($value as $y=>$u) {
                                        $sqlDl = "UPDATE plc2.hprfile2 h SET h.dcAndev = '".$u."' WHERE h.ihprfile2 = ".$r2['ihprfile2'];
                                        $this->db->query($sqlDl);   
                                    }
                                } 
                            }
                        }
                            
                    }

                }

                if($post['isdraft']==true){
                } 
                else{
                    $iupb_id=$lastId;
                    $activities = $this->lib_plc->get_current_module_activities($this->modul_id,'iupb_id');
                    $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,'iupb_id');
                    $iM_modul_activity=0;
                    $iM_activity=0;
                    foreach ($activities as $act) {
                        $iM_modul_activity=$act['iM_modul_activity'];
                        $iM_activity=$act['iM_activity'];
                    }
                    $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();
                    $iupppp[]=$iupb_id;
                    $this->lib_plc->InsertActivityModule($iupppp,$this->modul_id,$iupb_id,$activity['iM_activity'],$activity['iSort'],'Submit Tambahan Data',2);



                }

                echo $grid->updated_form();
                break;	
            case 'getUPB':
                $id=$this->input->post('id');
                $this->db->where('iupb_id',$id);
                $row=$this->db->get('plc2.plc2_upb')->row_array();
                $ibe=isset($row['ibe'])?$row['ibe']:0;
                $ret['ibe']=$ibe;
                echo json_encode($ret);
                break;
			case 'delete':
				echo $grid->delete_row();
				break;

			/*Option Case*/
			case 'getFormDetail':
				echo $this->getFormDetail();
				break;
			case 'get_data_prev':
				echo $this->lib_plc->get_data_prev($this->urlpath);
                break;

			/*Confirm*/
			case 'confirm':
                echo $this->confirm_view();
                break;
            case 'confirmA':
                echo $this->confirm_process();
                break;

             /*Confirm*/
			case 'approve':
                echo $this->approve_view(2);
                break;
            case 'reject':
                echo $this->approve_view(1);
                break;
            case 'approve_process':
                echo $this->approve_process();
                break;

			case 'download':
				$this->load->helper('download');		
				$name = $_GET['file'];
				$id = $_GET['id'];
				$path = $_GET['path'];

				$this->db_plc0->select("*")
    				->from("plc2.sys_masterdok")
    				->where("filename",$path);
    			$row=$this->db_plc0->get()->row_array();

    			if(count($row)>0 && isset($row["filepath"])){
    				$path = file_get_contents('./'.$row['filepath'].'/'.$id.'/'.$name);	
					force_download($name, $path);
    			}else{
    				echo "File Not Found - 0x01";
    			}

				
				break;

			case 'uploadFile':
                $lastId=$this->input->get('lastId');
                $dataFieldUpload=$this->lib_plc->getUploadFileFromField($this->input->get('modul_id'));
                if(count($dataFieldUpload)>0){
                    foreach ($dataFieldUpload as $kf => $vUpload) {
                        $pathf=$vUpload['filepath'];
                        $path = realpath($pathf);
                        if(!file_exists($path."/".$lastId)){
                            if (!mkdir($path."/".$lastId, 0777, true)) { //id review
                                die('Failed upload, try again!'.$path."/".$lastId);
                            }
                        }

                        $fKeterangan = array();
                        foreach($_POST as $key=>$value) {						
                            if ($key == 'plc2_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_fileketerangan') {
                                foreach($value as $k=>$v) {
                                    $fKeterangan[$k] = $v;
                                }
                            }
                        }
                        $i=0;
                        if(isset($_FILES['plc2_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file'])){
                            foreach ($_FILES['plc2_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file']["error"] as $key => $error) {
                                if ($error == UPLOAD_ERR_OK) {
                                    $tmp_name = $_FILES['plc2_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file']["tmp_name"][$key];
                                    $name =$_FILES['plc2_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file']["name"][$key];
                                    $data['filename'] = $name;
                                    $data['dInsertDate'] = date('Y-m-d H:i:s');
                                    $filenameori=$name;
                                    $now_u = date('Y_m_d__H_i_s');
                                    $name_generate = $i.'__'.$now_u.'__'.$name;
                                        if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name_generate)) {
                                            $datainsert=array();
                                            $datainsert['idHeader_File']=$lastId;
                                            $datainsert['iM_modul_fileds']=$vUpload['iM_modul_fileds'];
                                            $datainsert['dCreate']= date('Y-m-d H:i:s');
                                            $datainsert['cCreate']= $this->user->gNIP;
                                            $datainsert['vFilename']= $name;
                                            $datainsert['vFilename_generate']= $name_generate;
                                            $datainsert['tKeterangan']= $fKeterangan[$i];
                                            $this->db_plc0->insert('plc2.group_file_upload',$datainsert);
                                            $i++;	
                                        }
                                        else{
                                            echo "Upload ke folder gagal";
                                        }
                                }
                            }
                        }
                    }
                }
                /* Upload Jika Dokumen Tambahan */
                if(isset($_FILES['fileupload_hpr'])){
                    $path = realpath("files/plc/hprnew/");
                    if(!file_exists($path."/".$lastId)){
                        if (!mkdir($path."/".$lastId, 0777, true)) { //id review
                            die('Failed upload, try again!');
                        }
                    } 
                    foreach ($_FILES['fileupload_hpr']["error"] as $key => $error) {
                        if ($error == UPLOAD_ERR_OK) {
                            $tmp_name = $_FILES['fileupload_hpr']["tmp_name"][$key];
                            $name =$_FILES['fileupload_hpr']["name"][$key];
                            $data['filename'] = $name;
                            $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
                                    $sql="INSERT INTO plc2.hprfile1 (iupb_id, vfilename,  dcreate, ccreate) 
                                            VALUES (".$lastId.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."')";
                                    $this->db->query($sql); 
                                    $i++;   
                                }
                                else{
                                    echo "Upload ke folder gagal";  
                                }
                        }
                    }
                }

                    $iupbid=$lastId;

                //Insert In Here Buat Nambah Tambahin Tipe Nya
                $sqlIn2 = "SELECT h2.ihprfile2, h.idoneAdd FROM plc2.hprfile1 h JOIN
                plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 AND h.iupb_id =  '".$iupbid."'";
                $rowIn2 = $this->db->query($sqlIn2)->result_array();  
                foreach ($rowIn2 as $r) { 
                    if(!file_exists($path."/".$iupbid."/"."detail/".$r['ihprfile2'])){
                        if (!mkdir($path."/".$iupbid."/"."detail/".$r['ihprfile2'], 0777, true)) { //id review
                            die('Failed upload, try again!');
                        }
                    } 
                    if (isset($_FILES['fileupload3_'.$r['ihprfile2']]))  {
                        foreach ($_FILES['fileupload3_'.$r['ihprfile2']]["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['fileupload3_'.$r['ihprfile2']]["tmp_name"][$key];
                                $name =$_FILES['fileupload3_'.$r['ihprfile2']]["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                    if(move_uploaded_file($tmp_name, $path."/".$iupbid."/detail/".$r['ihprfile2'].'/'.$name)) {
                                        $sql="INSERT INTO plc2.hprfile3 (irevisi , ihprfile2, vfilename,  dupload, cupload, dcreate, ccreate) 
                                                VALUES (0, ".$r['ihprfile2'].",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."', 
                                                    '".$data['dInsertDate']."','".$this->user->gNIP."')";
                                        $this->db->query($sql); 
                                        $i++;   
                                    }
                                    else{
                                        echo "Upload ke folder gagal";  
                                    }

                            }
                        } 
                    }   
                }

                //Update Jika Revisi
                $sqlIn2 = "SELECT h2.ihprfile2, h3.ihprfile3 FROM plc2.hprfile1 h 
                JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                JOIN plc2.hprfile3 h3 ON h3.ihprfile2 = h2.ihprfile2
                WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 AND h3.ldelete = 0 
                AND h3.irevisi = 1 
                AND h.iupb_id =   '".$iupbid."'";
                $rowIn2 = $this->db->query($sqlIn2)->result_array();  
                foreach ($rowIn2 as $r) { 
                    if (isset($_FILES['fileupload3_'.$r['ihprfile2'].'_'.$r['ihprfile3']]))  {
                        if(!file_exists($path."/".$iupbid."/"."detail/".$r['ihprfile2'])){
                            if (!mkdir($path."/".$iupbid."/"."detail/".$r['ihprfile2'], 0777, true)) { //id review
                                die('Failed upload, try again!');
                            }
                        } 

                        foreach ($_FILES['fileupload3_'.$r['ihprfile2'].'_'.$r['ihprfile3']]["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['fileupload3_'.$r['ihprfile2'].'_'.$r['ihprfile3']]["tmp_name"][$key];
                                $name =$_FILES['fileupload3_'.$r['ihprfile2'].'_'.$r['ihprfile3']]["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                    if(move_uploaded_file($tmp_name, $path."/".$iupbid."/detail/".$r['ihprfile2'].'/'.$name)) {

                                        $sql = "UPDATE plc2.hprfile3 h SET h.irevisi = 0, h.ihprfile2 = '".$r['ihprfile2']."' ,
                                            h.vfilename = '".$data['filename']."', h.dupload = '".$data['dInsertDate']."', 
                                            h.cupload = '".$this->user->gNIP."', h.dupdate = '".$data['dInsertDate']."',
                                            h.cupdate = '".$this->user->gNIP."'
                                        WHERE h.ihprfile3 = ".$r['ihprfile3']; 

                                        $this->db->query($sql); 
                                        $i++;   
                                    }
                                    else{
                                        echo "Upload ke folder gagal";  
                                    }

                            }
                        } 
                    }   
                }

                $r['message']="Data Berhasil Disimpan";
                $r['status'] = TRUE;
                $r['last_id'] = $this->input->get('lastId');					
                echo json_encode($r);

                break;
                case 'exportfile':
                    $sql = "select m_modul.vKode_modul,sys_masterdok.* from plc2.sys_masterdok
                    join plc3.m_modul_fileds on m_modul_fileds.iM_modul_fileds=sys_masterdok.iM_modul_fileds
                    join plc3.m_modul on m_modul.iM_modul=m_modul_fileds.iM_modul
                    WHERE m_modul.vKode_modul IN ('PL00018') 
                    and sys_masterdok.ldeleted=0 and m_modul_fileds.lDeleted=0";
                    $data=$this->db->query($sql)->result_array();
                    $count=array();
                    foreach ($data as $kd => $vd) {
                        /* Dapetin data */
                        $sqlg='select * from '.$vd['filetable'];
                        $dataget=$this->db->query($sqlg)->result_array();
                        foreach ($dataget as $kget => $vget) {
                            $datainsert=array();
                            $datainsert['iM_modul_fileds']=$vd['iM_modul_fileds'];
                            $datainsert['idHeader_File']=$vget[$vd['fieldheader']];
                            $count[]=$vget[$vd['fieldheader']];
                            if(isset($vget['ijenis_bk_id'])){
                                $datainsert['ijenis_bk_id']=$vget['ijenis_bk_id'];
                            }
                            $datainsert['vFilename']=$vget[$vd['ffilename']];
                            $datainsert['vFilename_generate']=isset($vget['vFilename_generate'])?$vget['vFilename_generate']:$vget[$vd['ffilename']];
                            $datainsert['tKeterangan']=$vget[$vd['fvketerangan']];
                            $datainsert['dCreate']=$vget[$vd['fdcreate']];
                            $datainsert['cCreate']=$vget[$vd['fccreate']];
                            $datainsert['dUpdate']=$vget[$vd['fdupdate']];
                            $datainsert['cUpdate']=$vget[$vd['fcupdate']];
                            $datainsert['iDeleted']=isset($vget[$vd['fldeleted']])?$vget[$vd['fldeleted']]:0;
                            $datainsert['iconfirm_busdev']=isset($vget['iconfirm_busdev'])?$vget['iconfirm_busdev']:0;
                            $datainsert['istatus']=isset($vget['istatus'])?$vget['istatus']:0;
                            $datainsert['iDone']=isset($vget['iDone'])?$vget['iDone']:0;
                            $datainsert['dDoneDate']=isset($vget['dDoneDate'])?$vget['dDoneDate']:NULL;
                            $datainsert['cDone']=isset($vget['cDone'])?$vget['cDone']:NULL;
                            if(!@$this->db->insert('plc2.group_file_upload',$datainsert)){
                                echo $this->db->last_query();
                                echo $this->db->error();
                                exit();
                            }
                        }
                    }
                    echo count($count);
                break;
                case 'migrasicustome':
                    $path = realpath("files/plc/");
                    // if(!file_exists($path."/files/plc/pilot/coars")){
                    //     if (!mkdir($path."/coalsaex_upb", 0777, true)) { //id review
                    //         die('Failed upload, try again!');
                    //     }
                    // }
                    $sql='select * from plc2.plc2_upb_pilot_file_draft_coafg';
                    $dataget=$this->db->query($sql)->result_array();
                    $move = array();
                    $insert=array();
                    foreach ($dataget as $kget => $vget) {
                        $datainsert=array();
                        $this->db->where('ifor_id',$vget['ifor_id']);
                        $row=$this->db->get('plc2.plc2_upb_prodpilot')->result_array();
                        foreach ($row as $kr => $vr) {
                            $datainsert['iM_modul_fileds']=376;
                            $datainsert['idHeader_File']=$vr['iprodpilot_id'];
                            $count[]=$vr['iprodpilot_id'];
                            if(isset($vget['ijenis_bk_id'])){
                                $datainsert['ijenis_bk_id']=$vget['ijenis_bk_id'];
                            }
                            $datainsert['vFilename']=$vget['filename'];
                            $datainsert['vFilename_generate']=isset($vget['vFilename_generate'])?$vget['vFilename_generate']:$vget['filename'];
                            $datainsert['tKeterangan']=$vget['keterangan'];
                            $datainsert['dCreate']=$vget['dInsertDate'];
                            $datainsert['cCreate']=$vget['cInsert'];
                            $datainsert['dUpdate']=$vget['dUpdateDate'];
                            $datainsert['cUpdate']=$vget['cUpdated'];
                            $datainsert['iDeleted']=isset($vget['ldeleted'])?$vget['ldeleted']:0;
                            $datainsert['iconfirm_busdev']=isset($vget['iconfirm_busdev'])?$vget['iconfirm_busdev']:0;
                            $datainsert['istatus']=isset($vget['istatus'])?$vget['istatus']:0;
                            $datainsert['iDone']=isset($vget['iDone'])?$vget['iDone']:0;
                            $datainsert['dDoneDate']=isset($vget['dDoneDate'])?$vget['dDoneDate']:NULL;
                            $datainsert['cDone']=isset($vget['cDone'])?$vget['cDone']:NULL;
                            if(!@$this->db->insert('plc2.group_file_upload',$datainsert)){
                                echo $this->db->last_query();
                                echo $this->db->error();
                                exit();
                            }
                            $insert[]=$vr['ifor_id'];
                        }
                        /* Insert Dan Copy file di folder lpp */
                        $source = 'files/plc/pilot/draft_coafg/'.$vr['ifor_id'];
                        $dest = 'files/plc/pilot/draft_coafg/'.$vr['iprodpilot_id'];
                        if(file_exists($source)){
                            $this->xcopy($source, $dest, 0777);
                            $move[]=$vr['iprodpilot_id'];
                        }
                    }
                    $ret['insert']=count($insert);
                    $ret['move']=count($move);
                    print_r($ret);
                break;
            case 'bahankemassek':
                $sql='SELECT bk.* FROM plc2.plc2_upb_bahan_kemas bk
                    join plc2.plc2_upb up on up.iupb_id=bk.iupb_id
                    where up.itipe_id not in (6)
                    group by bk.iupb_id,bk.itipe';
                $data=$this->db->query($sql)->result_array();
                foreach ($data as $kk => $vk) {
                    $datainsert=array();
                    foreach ($vk as $kr => $vr) {
                        if($kr!='ibk_id'){
                            $vr=$kr=='iJenis_bk'?2:$vr;
                            $datainsert[$kr]=$vr;
                        }
                    }
                    $this->db->insert('plc2.plc2_upb_bahan_kemas',$datainsert);
                }
                break;
            case 'injectsoi':
                $data=$this->db->get('plc2.plc2_upb_soi_fg')->result_array();
                $datain=array();
                foreach ($data as $kr => $vr) {
                    $fields = $this->db->list_fields('plc2.soi_fg');
                    $datainsert=array();
                    foreach ($fields as $field)
                    {
                        if($field != 'isoifg_id'){
                            $datainsert[$field]=isset($vr[$field])?$vr[$field]:'';
                        }
                    }
                    if(!@$this->db->insert('plc2.soi_fg',$datainsert)){
                        echo $this->db->last_query();
                        echo $this->db->error();
                        exit();
                    }
                    $datain[]=1;
                }
                print_r(count($datain));
                break;

            case 'updateProdPilot':
                $sql="select * from plc2.group_file_upload where iFile < 4000 and iM_modul_fileds = 373";
                $result=$this->db->query($sql)->result_array();
                break;
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));
    }

    function manipulate_update_button($buttons, $rowData) { 
        $fieldpeka=$this->main_table_pk;
        $peka=$rowData[$this->main_table_pk];
        $iupb_id=$this->lib_plc->getUpbId($fieldpeka,$rowData[$fieldpeka]);

        $cNip= $this->user->gNIP;
        $data['upload']='upload_custom_grid';
        $data['get']=$this->input->get();
       	$js = $this->load->view('js/standard_js',$data,TRUE);
       	$js .= $this->load->view('js/prareg_hpr_custome_js',$data,TRUE);
        //$js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="'.$this->url.'_frame" id="'.$this->url.'_frame" height="0" width="0"></iframe>';
        

        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        }
        else{ 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?draft=true&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',this,true )"  id="button_update_draft_'.$this->url.'"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$peka);
                    $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,$peka);
                    

                    foreach ($activities as $act) {
                        $update_draft = '<button onclick="javascript:update_draft_btn(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?draft=true&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',this,true )"  id="button_update_draft_'.$this->url.'"  class="ui-button-text icon-save" >Update As Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?company_id='.$this->input->get('company_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \',this )"  id="button_update_submit_'.$this->url.'"  class="ui-button-text icon-save" >Update & Submit</button>';

                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/'.$this->urlpath.'?action=approve&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$fieldpeka.'='.$rowData[$fieldpeka].'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_'.$this->url.'"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/'.$this->urlpath.'?action=reject&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_'.$this->url.'"  class="ui-button-text icon-save" >Reject</button>';

                        $setuju = '<button onclick="javascript:confirm_prareg_hpr(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?company_id='.$this->input->get('company_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_'.$this->url.'"  class="ui-button-text icon-save" >Confirm</button>';

                        if($this->auth->is_manager()){ 

                            $x=$this->auth->dept();
                            $manager=$x['manager'];
                            if(in_array('BD', $manager)){ 
                                $type='BD';
                                if($rowData['iappbusdev_prareg']==0){
                                    //Cek Done File untul BD
                                    $sql = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                    JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                                    JOIN plc2.hprfile3 h3 ON h3.ihprfile2 = h2.ihprfile2
                                    WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 AND h3.ldelete = 0 
                                    AND h3.irevisi = 2 AND h3.iDone = 1 AND h2.iDoneAll =  1 AND  h.iupb_id = '".$rowData['iupb_id']."'";
                                    $c1 = $this->db->query($sql)->num_rows();
                                    $sql2 = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                        JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                                        JOIN plc2.hprfile3 h3 ON h3.ihprfile2 = h2.ihprfile2
                                        WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 AND h3.ldelete = 0  
                                        AND h.iupb_id = '".$rowData['iupb_id']."'";
                                    $c2 = $this->db->query($sql2)->num_rows();
                
                
                                    $sql3 = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                        JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1 
                                        WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0  AND (h2.dcAndev<>'0000-00-00' AND h2.dcAndev IS NOT NULL)
                                        AND h2.vTeamPD='AD' AND h2.iDoneAll =  1 AND  h.iupb_id = '".$rowData['iupb_id']."'";
                                    $c11 = $this->db->query($sql3)->num_rows();
                                    $sql4 = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                        JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1 
                                        WHERE h.idoneAdd=1 AND h2.vTeamPD='AD' AND h2.ldelete=0 AND h.ldelete = 0 AND h.iupb_id = '".$rowData['iupb_id']."'";
                                    $c22 = $this->db->query($sql4)->num_rows();
                
                
                                    $sqL5 = "SELECT  h.ihprfile1 FROM plc2.hprfile1 h   
                                        WHERE h.idoneAdd=1 AND h.ldelete = 0 AND  h.iupb_id = '".$rowData['iupb_id']."'";
                                    $c111 = $this->db->query($sqL5)->num_rows();
                                    $sqL6 = "SELECT  h.ihprfile1 FROM plc2.hprfile1 h   
                                        WHERE h.ldelete = 0 AND  h.iupb_id = '".$rowData['iupb_id']."'";
                                    $c222 = $this->db->query($sqL6)->num_rows();
                
                                    $sqL3 = "SELECT  h2.ihprfile2 FROM plc2.hprfile2 h2 
                                    JOIN  plc2.hprfile1 h on h2.ihprfile1=h.ihprfile1
                                    WHERE h.ldelete = 0 AND h2.ldelete=0 AND h.iupb_id = '".$rowData['iupb_id']."'";
                                    $c3 = $this->db->query($sqL3)->num_rows();

                                    $sql4="SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                        JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                                        JOIN plc2.hprfile3 h3 ON h3.ihprfile2 = h2.ihprfile2
                                        WHERE h2.ldelete=0 AND h.ldelete = 0 AND h3.ldelete = 0  
                                        AND h.iupb_id = '".$rowData['iupb_id']."'";
                                    $c4 = $this->db->query($sql4)->num_rows();

                                    $sqlD="SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                        JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                                        WHERE h2.ldelete=0 AND h.ldelete = 0 and h2.iDoneAll=0
                                        AND h.iupb_id = '".$rowData['iupb_id']."'";
                                    $cD = $this->db->query($sqlD)->num_rows();

                                    /* Cek Data Di Dokumen Sebelum di Isi */
                                    $sqljj="select h1.ihprfile1 from plc2.hprfile1 h1 where  h1.ldelete = 0 AND h1.iupb_id = '".$rowData['iupb_id']."'";
                                    $sqljd="select h1.ihprfile1 from  plc2.hprfile2 h1 
                                            join plc2.hprfile1 h2 on h2.ihprfile1=h1.ihprfile1 
                                            join  plc2.hprfile3 h3 on h1.ihprfile2=h3.ihprfile2 
                                            where  h2.ldelete = 0 AND h1.ldelete = 0 AND h2.iupb_id = '".$rowData['iupb_id']."' and h3.ldelete = 0
                                            group by h1.ihprfile1";
                                        $row111=$this->db->query($sqljj)->num_rows();
                                        $row222=$this->db->query($sqljd)->num_rows();
                                    //Cek Don File untuk Manager Khusus Dia
                                    $sqlmm="select h1.ihprfile2 from  plc2.hprfile2 h1 
                                            join plc2.hprfile1 h2 on h2.ihprfile1=h1.ihprfile1 
                                            where  h2.ldelete = 0 AND h1.ldelete = 0 AND h2.iupb_id = '".$rowData['iupb_id']."'
                                            group by h1.ihprfile2";
                                    $sqlnn="select h1.ihprfile2 from  plc2.hprfile2 h1 
                                            join plc2.hprfile1 h2 on h2.ihprfile1=h1.ihprfile1 
                                            join  plc2.hprfile3 h3 on h1.ihprfile2=h3.ihprfile2 
                                            where  h2.ldelete = 0 AND h1.ldelete = 0 AND h2.iupb_id = '".$rowData['iupb_id']."' and h3.ldelete = 0
                                            group by h1.ihprfile2";
                                    $rowmm=$this->db->query($sqlmm)->num_rows();
                                    $rownn=$this->db->query($sqlnn)->num_rows();
                                    /* Cek Untuk TD Yang Belum Upload Sama Sekali */

                                    if($rowData['itambahan_hpr']==1){
                                        if($c1==$c2 && $c11==$c22 && $c111==$c222){  
                                            if($c222>0&&$c3>0&&$c4>0&&$sqlD==0&&$row111==$row222){
                                                if($rowmm==$rownn){
                                                    $sButton.=$update_draft.$update;
                                                }
                                            }else{
                                                $sButton.=$update_draft;
                                            }  
                                        }else{
                                            $sButton.=$update_draft;
                                        }  
                                    }else{
                                        $sButton.=$update_draft.$update;  
                                    }
                                }elseif($rowData['iappbusdev_prareg']==2&&$rowData['iappbd_hpr']==0){
                                    if($rowData['iCopy_brand'] == 1){
                                        $sqlMother = 'select * from plc2.plc2_upb a where a.iupb_id= "'.$rowData['iupb_id_ref'].'"';
                                        $dMother = $this->db->query($sqlMother)->row_array();

                                        if($dMother['iappbd_hpr'] == 2 ){
                                            $sButton.=$update_draft.$setuju;
                                        }else{
                                            $sButton.=$update_draft.'<br>'.'UPB Original belum melewati Approval BD';
                                        }

                                    }else{
                                        $sButton.=$update_draft.$setuju;
                                    }
                                    
                                }
                            }else{ 
                                $dtO = "";
                                $i2=0;
                                foreach ($manager as $k => $v) {
                                    if($i2==0){
                                        $dtO .= "'".$v."'"; 
                                    }else{
                                        $dtO .= ",'".$v."'"; 
                                    } 
                                    $i2++;
                                }
                
                                $sql = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                    JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                                    JOIN plc2.hprfile3 h3 ON h3.ihprfile2 = h2.ihprfile2
                                    WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 AND h3.ldelete = 0 
                                    AND h3.irevisi = 2 AND h3.iDone = 1 AND h2.iDoneAll =  1 AND 
                                    h2.vTeamPD in(".$dtO.") AND h.iupb_id = '".$rowData['iupb_id']."'";
                                $c1 = $this->db->query($sql)->num_rows();
                                $sql2 = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                    JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                                    JOIN plc2.hprfile3 h3 ON h3.ihprfile2 = h2.ihprfile2
                                    WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 AND h3.ldelete = 0  
                                    AND h2.vTeamPD in(".$dtO.") AND h.iupb_id = '".$rowData['iupb_id']."'";
                                $c2 = $this->db->query($sql2)->num_rows();
                
                
                                $sql = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                    JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1 
                                    WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 AND h2.iDoneAll =  1 AND 
                                    h2.vTeamPD in (".$dtO.") AND h.iupb_id = '".$rowData['iupb_id']."'";
                                $c11 = $this->db->query($sql)->num_rows();
                                $sql2 = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                    JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1 
                                    WHERE h2.ldelete=0 AND h.ldelete = 0 
                                    AND h2.vTeamPD in(".$dtO.") AND h.iupb_id = '".$rowData['iupb_id']."'";
                                $c22 = $this->db->query($sql2)->num_rows(); 
                                //Cek Don File untuk Manager Khusus Dia
                                if($c1==$c2 && $c11==$c22){  
                                    if(in_array('AD', $manager)){
                                        $sql3 = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                            JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1 
                                            WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0  AND (h2.dcAndev<>'0000-00-00' AND h2.dcAndev IS NOT NULL)
                                            AND h2.iDoneAll =  1 AND  h.iupb_id = '".$rowData['iupb_id']."'";
                                            
                                        $c11 = $this->db->query($sql3)->num_rows();
                                        $sql4 = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                            JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1 
                                            WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 AND h.iupb_id = '".$rowData['iupb_id']."'";
                                        $c22 = $this->db->query($sql4)->num_rows();
                                        if($c11!=$c22){
                                            $sButton.=$update_draft;
                                        }
                                    }
                                }else{ 
                                    $sButton.=$update_draft;
                                }
                                
                            }
                                 
                             
                        }else{
                             
                            $x=$this->auth->dept();
                            if(isset($x['team'])){
                                $team=$x['team'];
                                if(in_array('BD', $team)){
                                    $type='BD';
                                    if($rowData['iappbd_hpr']==0){
                                        $sql = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                            JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                                            JOIN plc2.hprfile3 h3 ON h3.ihprfile2 = h2.ihprfile2
                                            WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 AND h3.ldelete = 0 
                                            AND h3.irevisi = 2 AND h3.iDone = 1 AND h2.iDoneAll =  1 AND h.iupb_id = '".$rowData['iupb_id']."'";
                                        $c1 = $this->db->query($sql)->num_rows();
                                        $sql2 = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                            JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                                            JOIN plc2.hprfile3 h3 ON h3.ihprfile2 = h2.ihprfile2
                                            WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 AND h3.ldelete = 0  
                                            AND  h.iupb_id = '".$rowData['iupb_id']."'";
                                        $c2 = $this->db->query($sql2)->num_rows();
                                        //Cek Don File untuk Manager Khusus Dia
                                        if($c1!=$c2){ 
                                            $sButton.=$update_draft;
                                        }else{
                                            $sButton.=$update_draft;
                                        }
                                    }else{}
                                }else{
                                    $dtO = '';
                                    $i=0;
                                    foreach ($team as $k => $v) {
                                        if($i==0){
                                            $dtO .= "'".$v."'"; 
                                        }else{
                                            $dtO .= ",'".$v."'"; 
                                        }
                                        
                                        $i++;
                                    }
                                    $sql = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                        JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                                        JOIN plc2.hprfile3 h3 ON h3.ihprfile2 = h2.ihprfile2
                                        WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 AND h3.ldelete = 0 
                                        AND h3.irevisi = 2 AND h3.iDone = 1 AND h2.iDoneAll =  1 AND h2.vTeamPD in (".$dtO.") AND h.iupb_id = '".$rowData['iupb_id']."'";
                                    $c1 = $this->db->query($sql)->num_rows();
                                    $sql2 = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                        JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1
                                        JOIN plc2.hprfile3 h3 ON h3.ihprfile2 = h2.ihprfile2
                                        WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 AND h3.ldelete = 0  
                                        AND h2.vTeamPD in(".$dtO.") AND h.iupb_id = '".$rowData['iupb_id']."'";
                                    $c2 = $this->db->query($sql2)->num_rows();
                                     //Cek Don File untuk Manager Khusus Dia
                
                                    $sql = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                        JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1 
                                        WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 AND h2.iDoneAll =  1 AND h2.vTeamPD in(".$dtO.") AND h.iupb_id = '".$rowData['iupb_id']."'";
                                    $c11 = $this->db->query($sql)->num_rows();
                                    $sql2 = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                        JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1 
                                        WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0 
                                        AND h2.vTeamPD in (".$dtO.") AND h.iupb_id = '".$rowData['iupb_id']."'";
                                    $c22 = $this->db->query($sql2)->num_rows(); 
                                    //Cek Don File untuk Manager Khusus Dia
                                    if($c1==$c2 && $c11==$c22){ 
                                        if($dtO=="AD"){
                                            $sql3 = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                                JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1 
                                                WHERE h.idoneAdd=1 AND h2.ldelete=0 AND h.ldelete = 0  AND 
                                                (h2.dcAndev<>'0000-00-00' or h2.dcAndev IS NOT NULL)
                                                AND h2.vTeamPD='AD' AND h2.iDoneAll =  1 AND  h.iupb_id = '".$rowData['iupb_id']."'";
                                            $c11 = $this->db->query($sql3)->num_rows();
                                            $sql4 = "SELECT h2.ihprfile2 FROM plc2.hprfile1 h 
                                                JOIN plc2.hprfile2 h2 ON h.ihprfile1 = h2.ihprfile1 
                                                WHERE h.idoneAdd=1 AND h2.vTeamPD='AD' AND h2.ldelete=0 AND h.ldelete = 0 AND h.iupb_id = '".$rowData['iupb_id']."'";
                                            $c22 = $this->db->query($sql4)->num_rows();
                                            if($c11!=$c22 && $rowData["iappbd_hpr"]==0 && $rowData["iappbusdev_prareg"]==0){
                                                $sButton.=$update_draft;
                                            }
                                        }
                                    }elseif($rowData["iappbd_hpr"]==0 && $rowData["iappbusdev_prareg"]==0){
                                        $sButton.=$update_draft;
                                    }
                                } 
                            }
                
                        }
                    }
                }
                $buttons['update'] = $sButton; 
        }

        //Load Javascript In Here 
       
        // $buttons["update"]=$iupb_id;
        return $buttons;
    }

	function manipulate_insert_button($buttons){
		 $cNip= $this->user->gNIP;
		 $data['upload']='upload_custom_grid';
       $js = $this->load->view('js/standard_js',$data,TRUE);
        $js .= $this->load->view('js/js_prareg_hpr_upload_js');

        $iframe = '<iframe name="'.$this->url.'_frame" id="'.$this->url.'_frame" height="0" width="0"></iframe>';
        
        $save = '<button onclick="javascript:prareg_hpr_custome_save(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?draft=true&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',this,true )"  id="button_save_draft_'.$this->url.'"  class="ui-button-text icon-save" >Save</button>';
        $export = '<button onclick="javascript:export_data(\'exportfile\');"  id="button_save_submit_'.$this->url.'"  class="ui-button-text icon-save" >Export</button>';
        $export = '<button onclick="javascript:export_data(\'migrasicustome\');"  id="button_save_submit_'.$this->url.'"  class="ui-button-text icon-save" >Export</button>';
        //$export = '<button onclick="javascript:export_data(\'bahankemassek\');"  id="button_save_submit_'.$this->url.'"  class="ui-button-text icon-save" >Export</button>';
        //$export = '<button onclick="javascript:export_data(\'injectsoi\');"  id="button_save_submit_'.$this->url.'"  class="ui-button-text icon-save" >Export</button>';

        /* $AuthModul = $this->lib_plc->getAuthorModul($this->modul_id);
        $arrTeam = explode(',',$this->team);
        $nipAuthor = explode(',', $AuthModul['vNip_author']);
 */
       /*  if( in_array($AuthModul['vDept_author'],$arrTeam )  || in_array($this->user->gNIP, $nipAuthor) || $this->isAdmin==TRUE  ){

            $buttons['save'] = $iframe.$save_draft.$save.$js;
        }else{
            unset($buttons['save']);
            $buttons['save'] = '<span style="color:red;" title="'.$AuthModul['vDept_author'].'">You\'re Dept not Authorized</span>';
        } */
        $buttons['save']=$save.$js.$iframe;
        if($cNip=='N15748'){
            $sa='<script>
            function export_data(nilaiacc){
                $.ajax({
                    url: base_url+"processor/plc/v3/prareg/hpr?action="+nilaiacc,
                    type: "post",
                    success: function(data) {
                        alert("done")
                    }
                });
            }
                </script>';
            $buttons['save']=$export.$save.$js.$iframe.$sa;

        }
        return $buttons;
	}

	/*List Box*/
	/*function listBox_v3_prareg_hpr_cPIC_AD($value, $pk, $name, $rowData) {
		$sql="select em.cNip, em.vName from hrd.employee em where em.cNip='".$value."'";
		$qq=$this->db_plc0->query($sql);
		$return = "-";
		if($qq->num_rows()>0){
			$row=$qq->row_array();
			$return=$row["cNip"]." - ".$row["vName"];
		}
		return $return;
	}
	function listBox_v3_prareg_hpr_plc2_upb_iteampd_id($value, $pk, $name, $rowData) {
		$sql="select * from plc2.plc2_upb_team where iteam_id='".$value."'";
		$qq=$this->db_plc0->query($sql);
		$return = "-";
		if($qq->num_rows()>0){
			$row=$qq->row_array();
			$return=$row["vteam"];
		}
		return $return;
	}*/

	/*Manipulate Insert/Update Form*/
	function insertBox_v3_prareg_hpr_form_detail($field,$id){
            $get=$this->input->get();
            $post=$this->input->post();
            foreach ($get as $kget => $vget) {
                if($kget!="action"){
                    $in[]=$kget."=".$vget;
                }
                if($kget=="action"){
                    $in[]="act=".$vget;
                }
            }
            $g=implode("&", $in);
            $return = '<script>
                var sebelum = $("label[for=\''.$this->url.'_form_detail\']").parent();
                $("label[for=\''.$this->url.'_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/'.$this->urlpath.'?action=getFormDetail&formaction=addnew&'.$g.'",
                    type: "post",
                    data: iupb_id=0,
                    success: function(data) {
                        var o = $.parseJSON(data);
                        sebelum.html(o.html);
                    }       
                });
            </script>';
            return $return;
        }

        function updateBox_v3_prareg_hpr_form_detail($field,$id,$value,$rowData){
            $get=$this->input->get();
            $post=$this->input->post();
            foreach ($get as $kget => $vget) {
                if($kget!="action"){
                    $in[]=$kget."=".$vget;
                }
                if($kget=="action"){
                    $in[]="act=".$vget;
                }
            }
            $g=implode("&", $in);
            $return = '<script>
                var sebelum = $("label[for=\''.$this->url.'_form_detail\']").parent();
                $("label[for=\''.$this->url.'_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/'.$this->urlpath.'?action=getFormDetail&formaction=update&'.$g.'",
                    type: "post",
                    data: iupb_id=0,
                    success: function(data) {
                        var o = $.parseJSON(data);
                        sebelum.html(o.html);
                    }       
                });
            </script>';
            return $return;
        }
    /*Function Tambahan*/

    function before_insert_processor($row, $postData) {
        if($postData['isdraft']==true){
            $postData['isubmit']=0;
        } 
        else{
            $postData['isubmit']=1;
            
        } 
        $postData['itype']=1;
        return $postData;

    }
    function before_update_processor($row, $postData) {
        if($postData['isdraft']==true){
            $postData['isubmit']=0;
        } 
        else{
            $postData['isubmit']=1;
            $postData['iappbusdev_prareg']=2;
            $postData['tappbusdev_prareg']=date("Y-m-d H:i:s");
            $postData['vnip_appbusdev_prareg']=$this->user->gNIP;
        }
        $postData['itype']=1;
        return $postData;
    }

    /*After Insert*/
    function after_insert_processor($fields, $id, $postData) {

		/* $nomor = "V".str_pad($id, 5, "0", STR_PAD_LEFT);
		$sql = "UPDATE plc2.plc2_vamoa SET vnomor_moa = '".$nomor."' WHERE ivalmoa_id=".$id." LIMIT 1";
		$query = $this->db->query($sql);


    	$peka=$this->main_table_pk;
        $iupb_id[]=$this->lib_plc->getUpbId($peka,$id);
        $modul_id=$this->input->get("modul_id");
        $iKey_id=$id;
        $iM_activity=0;
        $iSort=1;
        $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$id);
        foreach ($activities as $kk => $vv) {
        	$iM_activity=isset($vv['iM_activity'])?$vv['iM_activity']:$iM_activity;
        }
        if($postData['isubmit']){
        	$this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$iKey_id,$iM_activity,$iSort);
        } */
    }

    /*After Update*/
    function after_update_processor($fields, $id, $postData) {
    	/* $peka=$this->main_table_pk;
        $iupb_id[]=$this->lib_plc->getUpbId($peka,$id);
        $modul_id=$this->input->get("modul_id");
        $iKey_id=$id;
        $iM_activity=0;
        $iSort=1;
        $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$id);
        foreach ($activities as $kk => $vv) {
        	$iM_activity=isset($vv['iM_activity'])?$vv['iM_activity']:$iM_activity;
        }
        if($postData['isubmit']){
        	$this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$iKey_id,$iM_activity,$iSort);
        } */
    }


    /*Confirm View*/

    function confirm_view() { 
                $echo = '<script type="text/javascript">
                             function submit_ajax(form_id) {
                                return $.ajax({
                                    url: $("#"+form_id).attr("action"),
                                    type: $("#"+form_id).attr("method"),
                                    data: $("#"+form_id).serialize(),
                                    success: function(data) {
                                        var o = $.parseJSON(data);
                                        var last_id = o.last_id;
                                        var group_id = o.group_id;
                                        var modul_id = o.modul_id;
                                        var url = "'.base_url().'processor/'.$this->urlpath.'";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_'.$this->url.'").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_'.$this->url.'");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_'.$this->url.'_confirm" action="'.base_url().'processor/'.$this->urlpath.'?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_'.$this->url.'_confirm\')">Confirm</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 

     function confirm_process() {
        $post = $this->input->post();
        $get = $this->input->get();
        $cNip= $this->user->gNIP;
        $vName= $this->user->gName;
        $pk = $post["iupb_id"];
        $vRemark="";
        $modul_id = $post['modul_id'];
        $iM_modul_activity = $post['iM_modul_activity'];
        $iprareg_ulang_prareg=$post['iprareg_ulang_prareg'];
        $imutu_prareg=$post['imutu_prareg'];
        $ibutuh_dok_prareg=$post['ibutuh_dok_prareg'];
        $tanggal=date('Y-m-d H:i:s');

        $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();


        /* Jika Tidak Memerlukan Prareg */
        if($iprareg_ulang_prareg==0){
            $vRemark="Confirm";
            $field = $activity['vFieldName'];
            $update = array($field => 2,'iprareg_ulang_prareg'=>$iprareg_ulang_prareg,'imutu_prareg'=>$imutu_prareg,'ibutuh_dok_prareg'=>$ibutuh_dok_prareg);
            $this->db->where("iupb_id", $pk);
            $this->db->update("plc2.plc2_upb", $update);
            $iupb_id[]=$pk;
            $this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);
        }

        /* Jika Karena Mutu Ya */
        if($iprareg_ulang_prareg==1&&$imutu_prareg==1){
            $vRemark="Confirm - Karena Mutu : Ya";
            $field = $activity['vFieldName'];
            $update = array($field => 0,'tsubmit_prareg'=>NULL, 'iappbusdev_prareg'=>0,'iprareg_ulang_prareg'=>$iprareg_ulang_prareg,'imutu_prareg'=>$imutu_prareg,'ibutuh_dok_prareg'=>$ibutuh_dok_prareg);
            $this->db->where("iupb_id", $pk);
            $this->db->update("plc2.plc2_upb", $update);
            $iupb_id[]=$pk;
            $this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);
            $dataupdate['lDeleted']=1;
            $where=array('iKey_id'=>$pk,'idprivi_modules'=>$modul_id);
            $this->db_plc0->where($where);
            $this->db_plc0->update("plc3.m_modul_log_activity",$dataupdate);

            /* Get Module yang Uji Mutu */
            $wherearr=array('iMutu'=>1,'lDeleted'=>0);
            $this->db->where($wherearr);
            $result=$this->db->get('plc3.m_modul')->result_array();
            foreach($result as $kr => $vkar){
                $datainsert['idprivi_modules']=$vkar['idprivi_modules'];
                $datainsert['iupb_id']=$pk;
                $this->db->insert('plc2.log_mutu',$datainsert);
            }

            /* balikin status jika punya child */
            $sqlUPBref = 'select * from plc2.plc2_upb a where a.iupb_id_ref= "'.$pk.'"';
            $dUpebehref = $this->db->query($sqlUPBref)->row_array();

            $update = array($field => 0,'tsubmit_prareg'=>NULL, 'iappbusdev_prareg'=>0,'iconfirm_dok'=>0,'iconfirm_dok_pd'=>0,'iconfirm_dok_qa'=>0);
            $this->db->where("iupb_id", $dUpebehref['iupb_id']);
            $this->db->update("plc2.plc2_upb", $update);


                        

        }
        
        /* Jika Karena Butuh Dokumen Tambahan */
        if($iprareg_ulang_prareg==1&&$imutu_prareg==0){

            /* Jika Butuh Dokumen  */

            if($ibutuh_dok_prareg==0){
                $vRemark="Confirm - Butuh Dokumen : Tidak";
                $field = $activity['vFieldName'];
                $update = array('iappbusdev_prareg'=>0
                        ,'iprareg_ulang_prareg'=>NULL
                        ,'imutu_prareg'=>NULL
                        ,'ibutuh_dok_prareg'=>NULL
                        ,'iprareg_ulang_reg'=>NULL
                        ,'ireg_ulang'=>NULL
                        ,'iHasil_registrasi'=>NULL
                        ,'imutu_reg'=>NULL
                        ,'ibutuh_dok_reg'=>NULL
                        ,'iPic_Registrasi_req_doc'=>NULL
                    );
                $this->db->set('iappbusdev_prareg',0)
                            ->set('iprareg_ulang_prareg',NULL)
                            ->set('imutu_prareg',NULL)
                            ->set('ibutuh_dok_prareg',NULL)
                            ->set('ireg_ulang',NULL)
                            ->set('iHasil_registrasi',NULL)
                            ->set('imutu_reg',NULL)
                            ->set('ibutuh_dok_reg',NULL)
                            ->set('iPic_Registrasi_req_doc',NULL);
                $this->db->where("iupb_id", $pk);
                $this->db->update("plc2.plc2_upb");
                $iupb_id[]=$pk;
                $this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);
                $dataupdate['lDeleted']=1;
                $where=array('iKey_id'=>$pk,'idprivi_modules'=>$modul_id);
                $this->db_plc0->where($where);
                $this->db_plc0->update("plc3.m_modul_log_activity",$dataupdate);
            }else{
                $this->removeCekDokPrareg();
                $vRemark="Confirm - Butuh Dokumen : Ya";
                $field = $activity['vFieldName'];
                $update = array('iappbusdev_prareg'=>0
                                ,'iprareg_ulang_prareg'=>NULL
                                ,'imutu_prareg'=>NULL
                                ,'ibutuh_dok_prareg'=>NULL
                                ,'iprareg_ulang_reg'=>NULL
                                ,'ireg_ulang'=>NULL
                                ,'iHasil_registrasi'=>NULL
                                ,'imutu_reg'=>NULL
                                ,'ibutuh_dok_reg'=>NULL
                                ,'iPic_Registrasi_req_doc'=>NULL
                            );
                $update["tsubmit_prareg"]=NULL;
                $update["iappbusdev_prareg"]=0;
                $update["iappbd_hpr"]=0;
                $this->db->where("iupb_id", $pk);
                $this->db->update("plc2.plc2_upb", $update);
                $iupb_id[]=$pk;
                $this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);
                $dataupdate['lDeleted']=1;
                $where=array('iKey_id'=>$pk,'idprivi_modules'=>$modul_id);
                $this->db_plc0->where($where);
                $this->db_plc0->update("plc3.m_modul_log_activity",$dataupdate);

                /* Send Email */
                $cData['module']="Cek Dokumen Praregistrasi";
                $this->db->where('iupb_id',$pk);
                $rowUPB=$this->db->get('plc2.plc2_upb')->row_array();

                $iteampd_id=$rowUPB['iteampd_id']>0?$rowUPB['iteampd_id']:"0";
                $iteamqa_id=$rowUPB['iteamqa_id']>0?$rowUPB['iteamqa_id']:"0";
                $iteambusdev_id=$rowUPB['iteambusdev_id']>0?$rowUPB['iteambusdev_id']:"0";
                /* Get CC */
                $sql="select * from plc2.plc2_upb_team where iteam_id IN (".$iteampd_id.",".$iteamqa_id.",".$iteamqa_id.",".$iteambusdev_id.") AND ldeleted=0";
                $qqqq=$this->db->query($sql)->result_array();
                $teamM=array();
                foreach ($qqqq as $kq => $vq) {
                    $teamM[]=$vq["vnip"];
                }
                $cc=implode(";",$teamM);
                
                $sql2="select * from plc2.plc2_upb_team_item where iteam_id IN (".$iteampd_id.",".$iteamqa_id.",".$iteamqa_id.",".$iteambusdev_id.") AND ldeleted=0";
                $qqqq2=$this->db->query($sql2)->result_array();
                $teamT=array();
                foreach ($qqqq2 as $kq => $vq) {
                    $teamT[]=$vq["vnip"];
                }

                $to=implode(";",$teamT);

                $cData['rowUPB']=$rowUPB;
                $cData['headerCaption']="Mohon untuk melakukan update Cek Dokumen Praregistrasi aplikasi PLC dengan rincian:";
                $content = $this->load->view('partial/mail_themplate',$cData,TRUE);
                $path = '';
                $subject = "Praregistrasi - Butuh Dokumen [".$rowUPB['vupb_nomor']."]";
                $this->sess_message->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);

            }
        }


        /* Insert Log Approve */
        $dinsert=array();
        $dinsert['ijenis']=1;
        $dinsert['iupb_id']=$pk;
        $dinsert['dtanggal']=$tanggal;
        $dinsert['cInsert']=$cNip;
        $dinsert['dInsert']=$tanggal;
        $this->db->insert('plc2.tanggal_history_prareg_reg',$dinsert);

        $data=array();
        foreach ($get as $kget => $vget) {
            if($kget!="action"){
                $data[$kget]=$vget;
            }
        }

        $data['status']  = true;
        $data['last_id'] = $post[$this->main_table_pk];
        return json_encode($data);
    }


    /*Confirm View*/

    function approve_view($id=0) { 
    	$lblbutton="-";
    	if($id==1){
    		$lblbutton="Reject";
    	}
    	if($id==2){
    		$lblbutton="Approve";
    	}
        $echo = '<script type="text/javascript">
                     function submit_ajax(form_id) {
                        return $.ajax({
                            url: $("#"+form_id).attr("action"),
                            type: $("#"+form_id).attr("method"),
                            data: $("#"+form_id).serialize(),
                            success: function(data) {
                                var o = $.parseJSON(data);
                                var last_id = o.last_id;
                                var group_id = o.group_id;
                                var modul_id = o.modul_id;
                                var url = "'.base_url().'processor/'.$this->urlpath.'";                             
                                if(o.status == true) { 
                                    $("#alert_dialog_form").dialog("close");
                                         $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                         $("div#form_'.$this->url.'").html(data);
                                         
                                    });
                                    
                                }
                                    reload_grid("grid_'.$this->url.'");
                            }
                            
                         })
                     }
                 </script>';
        $echo .= '<h1>'.$lblbutton.'</h1><br />';
        $echo .= '<form id="form_'.$this->url.'_approve" action="'.base_url().'processor/'.$this->urlpath.'?action=approve_process" method="post">';
        $echo .= '<div style="vertical-align: top;">';
        $echo .= 'Remark : 
                <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                <input type="hidden" name="iapprove" value="'.$id.'" />
                <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                
                <textarea name="vRemark"></textarea>
        <button type="button" onclick="submit_ajax(\'form_'.$this->url.'_approve\')">'.$lblbutton.'</button>';
            
        $echo .= '</div>';
        $echo .= '</form>';
        return $echo;
    } 

     function approve_process() {
        $post = $this->input->post();
        $cNip= $this->user->gNIP;
        $vName= $this->user->gName;
        $pk = $post[$this->main_table_pk];
        $vRemark = $post['vRemark'];
        $modul_id = $post['modul_id'];
        $iapprove = $post['iapprove'];
        $iM_modul_activity = $post['iM_modul_activity'];

        $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

        $field = $activity['vFieldName'];
        $update = array($field => $iapprove);
        $this->db->where($this->main_table_pk, $pk);
        $this->db->update($this->main_table, $update);

        $peka=$this->main_table_pk;
        $iupb_id[]=$this->lib_plc->getUpbId($peka,$pk);

        $this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,$iapprove);
        
        $data['status']  = true;
        $data['last_id'] = $post[$this->main_table_pk];
        $data['group_id'] = $post['group_id'];
        $data['modul_id'] = $post['modul_id'];
        return json_encode($data);
    }

    function getFormDetail(){
    	$post=$this->input->post();
        $get=$this->input->get();
        $data['html']="";

        $sqlFields = 'select * from plc3.m_modul_fileds a where a.lDeleted=0 and  a.iM_modul='.$this->iModul_id.' order by a.iSort ASC';
        $dFields = $this->db->query($sqlFields)->result_array();

        $hate_emel = "";

        if($get['formaction']=='update'){
                $aidi = $get['id'];
        }else{
                $aidi = 0;
        }

        $hate_emel .= '
            <table class="hover_table" style="width:99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
                <thead>
                    <tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
                        <th style="border: 1px solid #dddddd; width: 10%;">Activity Name</th>
                        <th style="border: 1px solid #dddddd;">Status</th>
                        <th style="border: 1px solid #dddddd;">at</th>      
                        <th style="border: 1px solid #dddddd; width: 30%;">By</th>      
                        <th style="border: 1px solid #dddddd; width: 40%;">Remark</th>      
                    </tr>
                </thead>
                <tbody>';

                $hate_emel .= $this->getHistoryActivity($this->modul_id,$aidi);

        $hate_emel .='
                </tbody>
            </table>
            <br>
            <br>
            <hr>
        ';


        if(!empty($dFields)){

            foreach ($dFields as $form_field) {
                
                $data_field['iM_jenis_field']= $form_field['iM_jenis_field'] ;
                
                $data_field['form_field']= $form_field;
                $data_field['get']= $get;
                $data_field['post']= $post;

                $controller = $this->url;
                $data_field['id']= $controller.'_'.$form_field['vNama_field'];
                //$data_field['field']= $controller.'_'.$form_field['vNama_field'] ;
                $data_field['field']= $form_field['vNama_field'] ;

                $data_field['act']= $get['act'] ;
                $data_field['hasTeam']= $this->team ;
                $data_field['hasTeamID']= $this->teamID ;
                $data_field['isAdmin']= $this->isAdmin ;

                /*untuk keperluad file upload*/
                if($form_field['iM_jenis_field'] == 7){
                    $data_field['tabel_file']= $form_field['vTabel_file'] ;
                    $data_field['tabel_file_pk']= $this->main_table_pk;
                    $data_field['tabel_file_pk_id']= $form_field['vTabel_file_pk_id'] ;

                    $path = 'files/plc/dok_tambah';
                    $createname_space =$this->url;
                    $tempat = 'dok_tambah';
                    $FOLDER_APP = 'plc';

                    $data_field['path'] = $path;
                    $data_field['FOLDER_APP'] = $FOLDER_APP;
                    $data_field['createname_space'] = $createname_space;
                    $data_field['tempat'] = $tempat;

                    if ($form_field['iRequired']==1) {
                        $data_field['field_required']= 'required';
                    }else{
                        $data_field['field_required']= '';
                    }


                }
                /*untuk keperluad file upload*/

                $return_field="";
                if($get['formaction']=='update'){
                    $id = $get['id'];

                    $sqlGetMainvalue= 'select * from '.$this->main_table.' where lDeleted=0 and '.$this->main_table_pk.'= '.$id.'   ';
                    $dataHead = $this->db->query($sqlGetMainvalue)->row_array();

                    $data_field['dataHead']= $dataHead;
                    $data_field['main_table_pk']= $this->main_table_pk;
                    
                    if($form_field['iM_jenis_field'] == 6){
                        $data_field['vSource_input']= $form_field['vSource_input_edit'] ;
                    }else if ($form_field['iM_jenis_field'] == 13){
                        $sqlQuery = $form_field['vSource_input_edit'] ;
                        $sqlQuery .= $this->lib_plc->queryFilterUPBbyTeam($this->modul_id);
                        $sqlQuery .= ' UNION SELECT iupb_id AS valval, CONCAT (vupb_nomor, " | ",vupb_nama) AS showshow FROM plc2.plc2_upb WHERE iupb_id = '.$dataHead['iupb_id'];
                        $data_field['vSource_input']= $sqlQuery;
                        $data_field['disabled'] = true;
                        $data_field['form_field']['iRead_only_form'] = 1;
                    }else{
                        $data_field['vSource_input']= $form_field['vSource_input_edit'] ;
                    }
                    $return_field = $this->load->view('partial/v3_form_detail_update',$data_field,true);   
                }else{
                    $data_field['vSource_input']= $form_field['vSource_input'] ;
                    $return_field = $this->load->view('partial/v3_form_detail',$data_field,true);    
                }
                

                $hate_emel .='  <div class="rows_group" style="overflow:fixed;">
                                    <label for="'.$controller.'_form_detail_'.$form_field['vNama_field'].'" class="rows_label">'.$form_field['vDesciption'].'
                                    ';
                if ($form_field['iRequired']==1) {
                    $hate_emel .='<span class="required_bintang">*</span>';    
                    $data_field['field_required']= 'required';
                }else{
                    $data_field['field_required']= '';
                }

                if ($form_field['vRequirement_field']<> "") {
                    $hate_emel .='<span style="float:right;" title="'.$form_field['vRequirement_field'].'" class="ui-icon ui-icon-info"></span>';    
                }else{
                    $hate_emel .='';    
                }
                $hate_emel .='      </label>
                                    <div class="rows_input">'.$return_field.'</div>
                                </div>';
            }

        }else{
            $hate_emel .='Field belum disetting';
        }

        $hate_emel .= '<input type="hidden" name="isdraft" id="isdraft">';
        
        $data["html"] .= $hate_emel;
        return json_encode($data);
    }

    function get_data_prev(){
    	$post=$this->input->post();
    	$get=$this->input->get();
    	$nmTable=isset($post["nmTable"])?$post["nmTable"]:"0";
    	$grid=isset($post["grid"])?$post["grid"]:"0";
    	$grid=isset($post["grid"])?$post["grid"]:"0";
    	$namefield=isset($post["namefield"])?$post["namefield"]:"0";

    	$this->db_plc0->select("*")
    				->from("plc2.sys_masterdok")
    				->where("filename",$namefield);
        $row=$this->db_plc0->get()->row_array();
		
		$where=array('iDeleted'=>0,'idHeader_File'=>$post["id"],'iM_modul_fileds'=>$row['iM_modul_fileds']);
		$this->db_plc0->where($where);
		$q=$this->db_plc0->get('plc2.group_file_upload');
		$rsel=array('vFilename','tKeterangan','iact');
		$data = new StdClass;
		$data->records=$q->num_rows();
		$i=0;
		foreach ($q->result() as $k) {
			$data->rows[$i]['id']=$i;
			$z=0;

			$value=$k->vFilename_generate;
			$id=$k->idHeader_File;
			$linknya = 'No File';
			if($value != '') {
				if (file_exists('./'.$row["filepath"].'/'.$id.'/'.$value)) {
					$link = base_url().'processor/'.$this->urlpath.'?action=download&id='.$id.'&file='.$value.'&path='.$row['filename'];
					$linknya = '<a class="ui-button-text" href="javascript:;" onclick="window.location=\''.$link.'\'">[Download]</a>&nbsp;&nbsp;&nbsp;';
				}
			}
			$linknya=$linknya.'<a class="ui-button-text" href="javascript:;" onclick="javascript:hapus_row_'.$nmTable.'('.$i.')">[Hapus]</a><input type="hidden" class="num_rows_'.$nmTable.'" value="'.$i.'" /><input type="hidden" name="'.$post["namefield"].'_iFile[]" value="'.$k->iFile.'" />';


			foreach ($rsel as $dsel => $vsel) {
				if($vsel=="iact"){
					$dataar[$dsel]=$linknya;
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


    function hilang1(){
    	$id = $this->input->post('id_file'); 
    	$iupb_id = $this->input->post('iupb_id'); 
    	$sqlUp = "UPDATE plc2.hprfile1 h SET h.idoneAdd = 1 WHERE h.ihprfile1 =".$id; 
    	$this->db->query($sqlUp);  

    	//Sent Mail

    	$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik, u.isentmail_hpr,
		                u.iteambusdev_id AS bd,u.iteampd_id AS pd,u.iteamqa_id AS qa,u.iteamqc_id AS qc, u.iteamad_id as ad
		                from plc2.plc2_upb u where u.iupb_id='".$iupb_id."'";
    	$rupb = $this->db_plc0->query($qupb)->row_array();  
    	$subject = 'HPR ('.$rupb['vupb_nomor'].' -  '.$rupb['vupb_nama'].')';
		$sqlEm = "SELECT DISTINCT(h.vTeamPD) as vTeam,h1.iupb_id FROM plc2.hprfile2 h JOIN 
					plc2.hprfile1 h1 ON h.ihprfile1 = h1.ihprfile1
					WHERE h.ldelete = 0 AND h1.ldelete = 0 AND h1.iMail=0 AND h1.idoneAdd = 1 AND h1.ihprfile1 = ".$id; 
		$dta = $this->db->query($sqlEm)->result_array();
		$sqUp = "UPDATE plc2.hprfile1 p SET p.iMail = 1 WHERE 
			p.iMail=0 AND  p.idoneAdd = 1  AND p.ihprfile1 = ".$id; 
		$this->db_plc0->query($sqUp);
		foreach ($dta as $v) {
			$to = '';
			if($v['vTeam']=="BD"){
				$to = $this->lib_utilitas->get_email_leader( $rupb['bd'] ); 
				if($to==""){
					$to = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
				}
			}
			elseif($v['vTeam']=="PD"){
				$to = $this->lib_utilitas->get_email_leader( $rupb['pd'] ); 
			}
			elseif($v['vTeam']=="AD"){
				$to = $this->lib_utilitas->get_email_leader( $rupb['ad'] ); 
			} 
			elseif($v['vTeam']=="QA"){
				$to = $this->lib_utilitas->get_email_leader( $rupb['qa'] ); 
			}
			elseif($v['vTeam']=="QC"){
				$to = $this->lib_utilitas->get_email_leader( $rupb['qc'] ); 
			}else{
				$sql = "SELECT p.vnip FROM plc2.plc2_upb_team p WHERE p.ldeleted = 0 AND p.iStatus = 1 
					AND p.vtipe ='".$v['vTeam']."'";
				$dtMail = $this->db->query($sql)->result_array();
				$i=0;
				foreach ($dtMail as $vm) {
					if($i==0){
						$to .= $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
					}else{
						$to .= ','.$this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
					}
					$i++;
				}
			} 
			$cc = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
			$content="
				Dengan Hormat,<br>
                Diberitahukan kepada ".$v['vTeam']." Manager untuk melakukan Upload file pada proses Praregistrasi ( Aplikasi PLC) <br><br>
                Link Aplikasi: http://www.npl-net.com/erp/<br><br>
                Terimakasih.<br><br>
                ";
            //$this->lib_utilitas->send_email($to, $cc, $subject, $content);
            $file=array();
            $this->SendEmailERP($iupb_id,"Diberitahukan kepada ".$v['vTeam']." Manager untuk melakun pengecekan pada proses Praregistrasi ( Aplikasi PLC) dengan rincian",$file,$to=$v['vTeam']);
	   
		}


    	
    }
    

    function donefile(){
    	$id = $this->input->post('id_file'); 
    	$id2 = $this->input->post('id_file2'); 
    	$sqlUp = "UPDATE plc2.hprfile3 h SET h.iDone = 1 WHERE h.ihprfile3 = ".$id;
    	$this->db->query($sqlUp); 

    	$sql = "SELECT * FROM plc2.hprfile3 h WHERE h.ldelete = 0 AND h.iDone = 0 AND h.ihprfile2 = '".$id2."'";
		$ck = $this->db->query($sql)->num_rows();
		if($ck>0){}else{
			$sqlUp = "UPDATE plc2.hprfile2 h SET h.iDoneAll = 1 WHERE h.ihprfile2 = ".$id2; 
    		$this->db->query($sqlUp); 
		}

		$qupb="SELECT h.vfilename, h2.iupb_id, p.vupb_nomor, p.vupb_nama, p.iteambusdev_id, h1.vTeamPD,p.iupb_id FROM plc2.hprfile3 h 
			JOIN plc2.hprfile2 h1 ON h.ihprfile2 = h1.ihprfile2
			JOIN plc2.hprfile1 h2 ON h1.ihprfile1 = h2.ihprfile1
			JOIN plc2.plc2_upb p ON p.iupb_id = h2.iupb_id
			WHERE h.ldelete = 0 AND h1.ldelete=0 AND h2.ldelete=0
			AND h.ihprfile3 = '".$id."' AND h1.ihprfile2 = '".$id2."' LIMIT 1"; 
		$mdt = $this->db_plc0->query($qupb)->row_array(); 
		if(!empty($mdt['vupb_nomor'])){
			/* $subject ="HPR Cek File (".$mdt['vupb_nomor']." - ".$mdt['vupb_nama'].")";
			$to = $this->lib_utilitas->get_email_leader( $mdt['iteambusdev_id'] ); 
			if($to==""){
				$to = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
			}
			$cc = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
			$content="
				Dengan Hormat,<br>
	            Diberitahukan kepada Busdev Manager untuk melakukan Pengecekan file dari ".$mdt['vTeamPD']." Manager pada proses HPR ( Aplikasi PLC) <br>
	            File : ".$mdt['vfilename']."<br><br>
	            Link Aplikasi: http://www.npl-net.com/erp/<br><br>
	            Terimakasih.<br><br>
	            ";
            $this->lib_utilitas->send_email($to, $cc, $subject, $content); */
            $file=array($mdt['vfilename']);
            $this->SendEmailERP($mdt['iupb_id'],"Diberitahukan kepada Busdev Manager untuk melakun pengecekan file dari ".$mdt['vTeamPD']." Manager pada proses Praregistrasi ( Aplikasi PLC) dengan rincian",$file,$to='BD');
	    }
    }

    function donefileall(){
    	$id = $this->input->post('id_file'); 

    	$qupb="SELECT h.vfilename, h2.iupb_id, p.vupb_nomor, p.vupb_nama, p.iteambusdev_id, h1.vTeamPD FROM plc2.hprfile3 h 
			JOIN plc2.hprfile2 h1 ON h.ihprfile2 = h1.ihprfile2
			JOIN plc2.hprfile1 h2 ON h1.ihprfile1 = h2.ihprfile1
			JOIN plc2.plc2_upb p ON p.iupb_id = h2.iupb_id
			WHERE h.ldelete = 0 AND h1.ldelete=0 AND h2.ldelete=0 AND h.iDone=0
			AND h1.ihprfile2 = '".$id."'"; 
		$mdt = $this->db_plc0->query($qupb.' LIMIT 1')->row_array(); 
		if(!empty($mdt['vupb_nomor'])){
			$subject ="HPR Cek File (".$mdt['vupb_nomor']." - ".$mdt['vupb_nama'].")";
			$to = $this->lib_utilitas->get_email_leader( $mdt['iteambusdev_id'] ); 
			if($to==""){
				$to = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
			}
			$cc = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
			$content="
				Dengan Hormat,<br>
	            Diberitahukan kepada Busdev Manager untuk melakukan Pengecekan file dari ".$mdt['vTeamPD']." Manager pada proses Praregistrasi ( Aplikasi PLC) <br><br>";
	        $mdt2 = $this->db_plc0->query($qupb)->result_array(); 
            $i=1;
            $file=array();
	        foreach ($mdt2 as $v) {
                 $content.="<i>".$i.",  ".$v['vfilename']."</i><br>";
                 $file[]=$v['vfilename'];
	        	 $i++;
	        }
	        $content.="<br>Link Aplikasi: http://www.npl-net.com/erp/<br><br>
	            Terimakasih.<br><br>
	            ";
            //$this->lib_utilitas->send_email($to, $cc, $subject, $content);
            $this->SendEmailERP($mdt['iupb_id'],"Diberitahukan kepada Busdev Manager untuk melakun pengecekan file dari ".$mdt['vTeamPD']." Manager pada proses Praregistarasi ( Aplikasi PLC) dengan rincian",$file,$to='BD');
	    }


    	$sqlUp = "UPDATE plc2.hprfile3 h SET h.iDone = 1 WHERE h.ihprfile2 = ".$id;
    	$this->db->query($sqlUp); 
    	$sqlUp = "UPDATE plc2.hprfile2 h SET h.iDoneAll = 1 WHERE h.ihprfile2 = ".$id; 
    	$this->db->query($sqlUp);  
    	echo 'Success';
    }
    
    function donefilerevisi(){
    	$id = $this->input->post('id_file');
    	$irevisi = $this->input->post('revisi'); 
    	$to='';
    	if($irevisi==1){
    		$sqlUp = "UPDATE plc2.hprfile3 h SET h.iDone = 0 , h.irevisi = '".$irevisi."' WHERE h.ihprfile3 = ".$id;

    		$qupb="SELECT h.vfilename, h2.iupb_id, p.vupb_nomor, p.vupb_nama, p.iteambusdev_id,p.iteamad_id as ad,
    			p.iteambusdev_id AS bd,p.iteampd_id AS pd,p.iteamqa_id AS qa,p.iteamqc_id AS qc, 
    			h1.vTeamPD AS vTeam FROM plc2.hprfile3 h 
				JOIN plc2.hprfile2 h1 ON h.ihprfile2 = h1.ihprfile2
				JOIN plc2.hprfile1 h2 ON h1.ihprfile1 = h2.ihprfile1
				JOIN plc2.plc2_upb p ON p.iupb_id = h2.iupb_id
				WHERE h.ldelete = 0 AND h1.ldelete=0 AND h2.ldelete=0
				AND h.ihprfile3 = '".$id."' LIMIT 1"; 
			$mdt = $this->db_plc0->query($qupb)->row_array();  
			if(!empty($mdt['vupb_nomor'])){
				$subject ="HPR Revisi File (".$mdt['vupb_nomor']." - ".$mdt['vupb_nama'].")"; 
				if($mdt['vTeam']=="BD"){
					$to = $this->lib_utilitas->get_email_leader( $mdt['bd'] ); 
					if($to==""){
						$to = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
					}
				}
				elseif($mdt['vTeam']=="PD"){
					$to = $this->lib_utilitas->get_email_leader( $mdt['pd'] ); 
				}
				elseif($mdt['vTeam']=="AD"){
					$to = $this->lib_utilitas->get_email_leader( $mdt['ad'] ); 
				}
				elseif($mdt['vTeam']=="QA"){
					$to = $this->lib_utilitas->get_email_leader( $mdt['qa'] ); 
				}
				elseif($mdt['vTeam']=="QC"){
					$to = $this->lib_utilitas->get_email_leader( $mdt['qc'] ); 
				}else{
					$sql = "SELECT p.vnip FROM plc2.plc2_upb_team p WHERE p.ldeleted = 0 AND p.iStatus = 1 
						AND p.vtipe ='".$mdt['vTeam']."'";
					$dtMail = $this->db->query($sql)->result_array();
					$i=0;
					foreach ($dtMail as $vm) {
						if($i==0){
							$to .= $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
						}else{
							$to .= ','.$this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
						}
						$i++;
					}
				} 
				$cc = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
				$content="
					Dengan Hormat,<br>
		            Diberitahukan kepada ".$mdt['vTeam']." Manager untuk melakukan Revisi file <b><i> ".$mdt['vfilename']."</i></b>   pada proses HPR ( Aplikasi PLC) <br> <br>
		            Link Aplikasi: http://www.npl-net.com/erp/<br><br>
		            Terimakasih.<br><br>
		            ";
		        //$this->sess_auth->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
                //$this->lib_utilitas->send_email($to, $cc, $subject, $content);
                $file=array($mdt['vfilename']);
                $this->SendEmailERP($mdt['iupb_id'],"Diberitahukan kepada Busdev Manager untuk melakukan pengecekan file dari ".$mdt['vTeam']." Manager pada proses HPR ( Aplikasi PLC)m dengan rincian",$file,$to=$mdt['vTeam']);
			}
			

    	}else{
    		$sqlUp = "UPDATE plc2.hprfile3 h SET h.irevisi = '".$irevisi."' WHERE h.ihprfile3 = ".$id;
    	} 
    	$this->db->query($sqlUp); 
    	echo 'Success';
    }


    function getHistoryActivity($modul_id,$iKey_id){
        $sql = '
                select b.vNama_activity,a.dCreate,c.vName,a.vRemark
                ,if(a.iApprove=2,"Approve",if(a.iApprove=1,"Reject","-")) as setatus
                from plc3.m_modul_log_activity a 
                join plc3.m_activity b on b.iM_activity=a.iM_activity
                join hrd.employee c on c.cNip=a.cCreated
                where 
                a.idprivi_modules ="'.$modul_id.'"
                and a.iKey_id ="'.$iKey_id.'"
                order by a.iM_modul_log_activity DESC
        ';
    
        $query = $this->db_plc0->query($sql);
        $jmlRow = $query->num_rows();
        
        $html = '';
    
        if ($jmlRow > 0) {
            $rows = $query->result_array();
            $i=0;
            foreach ($rows as $data ) {
                $html .='
                    <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['vNama_activity'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['setatus'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['dCreate'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['vName'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['vRemark'].'</span>
                        </td>
                    </tr>';
    
    
                $i++;
            }
        }else{
            $html .='
                    <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
                        <td colspan="5" style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">No Data</span>
                        </td>
                    </tr>';
    
    
        }
    
        return $html;
    
    }

    function removeCekDokPrareg(){
        $post = $this->input->post();
        $get = $this->input->get();
        $cNip= $this->user->gNIP;
        $vName= $this->user->gName;
        $pk = $post["iupb_id"];
        $vRemark="";
        $modul_id = $post['modul_id'];
        $iM_modul_activity = $post['iM_modul_activity'];


        $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();
        /* Delete Semua Log */
        $ireq=isset($post['iPic_Prareg_req_doc'])?$post['iPic_Prareg_req_doc']:'0';

        /* Clear Di Cek Dok Prareg */
        $update = array('iconfirm_dok'=>0
                        ,'iconfirm_dok_qa'=>0
                        ,'tRegistrasi_req_doc'=>$post["tPrareg_req_doc"]
                        ,'iPic_Registrasi_req_doc'=>$post["iPic_Prareg_req_doc"]
                    );
      
                if($ireq==0){
                    $update['iconfirm_dok_pd']=0;
                }

            $this->db->where("iupb_id", $pk);
            $this->db->update("plc2.plc2_upb", $update);
            
            /* Open All Done File di Prareg */
            $CODE='PL00047';
            $sql='select * from plc3.m_modul where lDeleted=0 AND vKode_modul="'.$CODE.'"';
            $getprivi=$this->db->query($sql)->row_array();
            $idprivi=isset($getprivi['idprivi_modules'])?$getprivi['idprivi_modules']:0;

            $filter=array('de.ikategori_id=3 and de.ijenisdok=1 and de.jenisplc=1');
            $rowtb=$this->v3_m_reg->getDetailFiles($filter)->result_array();
            foreach ($rowtb as $krow => $vrow) {
                $ipk=$this->v3_m_reg->getAnotherUPB($vrow['fieldheader'],$pk);
                $iM_modul_fileds=$vrow['iM_modul_fileds'];
                $this->db->where("iM_modul_fileds",$iM_modul_fileds)
                        ->where('idHeader_File',$ipk)
                        ->where('iDeleted',0);
                $this->db->update('plc2.group_file_upload',array('iDone'=>0));
                
            }


            /* Hapus Activity Cek Dokumen Prareg */
            $this->db->where('iKey_id',$pk)
                        ->where('idprivi_modules',$idprivi);
                        if($ireq==1){
                            $this->db->where('vRemark =!',"Approval PD");
                        }
            $this->db->update('plc3.m_modul_log_activity',array('lDeleted'=>1));
    }

    function SendEmailERP($pk,$caption="",$file=array(),$tto){
        /* Send Email */
        $this->db->where('iupb_id',$pk);
        $rowUPB=$this->db->get('plc2.plc2_upb')->row_array();

        $iteampd_id=$rowUPB['iteampd_id']>0?$rowUPB['iteampd_id']:"0";
        $iteamqa_id=$rowUPB['iteamqa_id']>0?$rowUPB['iteamqa_id']:"0";
        $iteambusdev_id=$rowUPB['iteambusdev_id']>0?$rowUPB['iteambusdev_id']:"0";
        /* Get CC */
        $sql="select * from plc2.plc2_upb_team where vtipe='".$tto."' AND iteam_id IN (".$iteampd_id.",".$iteamqa_id.",".$iteambusdev_id.") AND ldeleted=0";
        $qqqq=$this->db->query($sql)->result_array();
        $teamM=array();
        $ato=0;
        foreach ($qqqq as $kq => $vq) {
            $teamM[]=$vq["vnip"];
            $ato=$vq["iteam_id"];
        }
        $cc=implode(";",$teamM);
        
        $sql2="select * from plc2.plc2_upb_team_item where iteam_id IN (".$ato.") AND ldeleted=0";
        $qqqq2=$this->db->query($sql2)->result_array();
        $teamT=array();
        foreach ($qqqq2 as $kq => $vq) {
            $teamT[]=$vq["vnip"];
        }

        $to=implode(";",$teamT);
        $cData['module']="Praregistrasi - TD [".$rowUPB['vupb_nomor']."]";

        $cData['rowUPB']=$rowUPB;
        $cData['headerCaption']=$caption;
        $cData['file']=$file;
        $content = $this->load->view('partial/mail_details_upb_prareg_reg',$cData,TRUE);
        $path = '';
        $subject = "Praregistrasi - Butuh Dokumen [".$rowUPB['vupb_nomor']."]";
        $this->sess_message->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
    }


    function xcopy($source, $dest, $permissions = 0775)
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            if(!file_exists($dest)){
                if (!mkdir($dest, 0777, true)) { //id review
                    die('Failed upload, try again!'.$dest);
                }
            }
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            echo '-> '.$dest."/".$entry.'<br />';
            $this->xcopy("$source/$entry", "$dest/$entry", $permissions);
        }

        // Clean up
        $dir->close();
        return true;
    }

}