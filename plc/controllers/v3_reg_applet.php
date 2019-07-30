<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_reg_applet extends MX_Controller {
	private $_ci;
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
		$this->load->model('v3_m_reg');

        $this->team = $this->lib_plc->hasTeam($this->user->gNIP);
        $this->teamID = $this->lib_plc->hasTeamID($this->user->gNIP);
        $this->isAdmin=$this->lib_plc->isAdmin($this->user->gNIP);

		$this->title = 'Registrasi (TD & Applet)';
		$this->url = 'v3_reg_applet';
		$this->urlpath = 'plc/'.str_replace("_","/", $this->url);

		$this->maintable = 'plc2.plc2_upb';	
		$this->main_table = $this->maintable;	
		$this->main_table_pk = 'iupb_id';	
		$datagrid['islist'] = array(
			'vupb_nomor' => array('label'=>'No UPB','width'=>75,'align'=>'center','search'=>true)
			,'vupb_nama' => array('label'=>'Nama Usulan','width'=>250,'align'=>'left','search'=>true)
			,'vgenerik' => array('label'=>'Nama Generik','width'=>250,'align'=>'left','search'=>false)
			,'iappbd_applet' => array('label'=>'Approval Busdev','width'=>250,'align'=>'left','search'=>true)
		);		

		$datagrid['setQuery']=array(
								0=>array('vall'=>'plc2_upb.lDeleted','nilai'=>0)
								,2=>array('vall'=>'plc2_upb.iconfirm_registrasi','nilai'=>2)
								,3=>array('vall'=>'plc2_upb.tregistrasi is not null','nilai'=>NULL)
								,4=>array('vall'=>'plc2_upb.tregistrasi <> 0000-00-00','nilai'=>NULL)
								);
		/* $datagrid['jointableinner']=array(
								0=>array('plc2.plc2_upb'=>'plc2_upb.iupb_id=validasi_proses.iupb_id')
								); */
		$datagrid['shortBy']=array("plc2_upb.vupb_nomor"=>"DESC");
		
		$this->datagrid=$datagrid;
		$this->_ci=& get_instance();
    }

    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle($this->title);		
		$grid->setTable($this->maintable );
		$grid->setUrl($this->url);

		/*$grid->setGroupBy($this->setGroupBy);*/
        /*Untuk Field*/
		// $grid->addFields('test');        
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
		$grid->changeFieldType('iappbd_applet', 'combobox','',array(''=>'--select--',0=>'Waiting for approval',1=>'Rejected', 2=>'Approved'));

		$grid->setGridView('grid');

		switch ($action) {
			case 'json':
				$grid->getJsonData();
                break;	
            case 'hilangap1':
				$this->hilangap1();
				break;	
			case 'donefileap';
				$this->donefileap();
				break;	
			case 'donefileapall';
				$this->donefileapall();
				break;
            case 'hilang1':
				$this->hilang1();
				break;	
			case 'donefile';
				$this->donefile();
				break;	
			case 'hapustable';
                $this->hapustable();
                break;
			case 'donefileall';
				$this->donefileall();
				break;	
			case 'donefilerevisi';
				$this->donefilerevisi();
                break;
            case 'donefileaprevisi';
				$this->donefileaprevisi();
				break;
            case 'getTglApplet';
                $post=$this->input->post();
                $sql='SELECT itemreg.*,plc2_upb_formula.iupb_id FROM plc2.plc2_upb_buat_mbr
                JOIN plc2.plc2_upb_formula on plc2_upb_formula.ifor_id=plc2_upb_buat_mbr.ifor_id
                JOIN sales.itemreg on itemreg.c_iteno=plc2_upb_buat_mbr.c_iteno
                WHERE plc2_upb_buat_mbr.ldeleted=0 and  plc2_upb_formula.ldeleted=0  and plc2_upb_formula.iupb_id='.$post['iupb'].' order by itemreg.id ASC LIMIT 1';
                $row=$this->db->query($sql)->row_array();
                $result=array();
                if(count($row)>0){
                    $result['c_row']=count($row);
                    $result['d_row']=$row;
                }else{
                    $result['c_row']=0;
                    $result['d_row']=array();
                }
                echo json_encode($result);
				break;
            case 'cekDoneProses':

                $post=$this->input->post();
                $sql = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
                WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0 
                AND h3.`irevisi` = 2 AND h3.`iDone` = 1 AND h2.`iDoneAll` =  1 AND  h.`iupb_id` = '".$post['iupb_id']."'";
                $c1 = $this->db->query($sql)->num_rows();
                $sql2 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                    JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                    JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
                    WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0  
                    AND h.`iupb_id` = '".$post['iupb_id']."'";
                $c2 = $this->db->query($sql2)->num_rows();


                $sql3 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                    JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
                    WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0  AND (h2.dcAndev<>'0000-00-00' AND h2.dcAndev IS NOT NULL)
                    AND h2.vTeamPD='AD' AND h2.`iDoneAll` =  1 AND  h.`iupb_id` = '".$post['iupb_id']."'";
                $c11 = $this->db->query($sql3)->num_rows();
                $sql4 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                    JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
                    WHERE h.idoneAdd=1 AND h2.vTeamPD='AD' AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h.`iupb_id` = '".$post['iupb_id']."'";
                $c22 = $this->db->query($sql4)->num_rows();


                $sqL5 = "SELECT  h.`iappletfile1` FROM plc2.`appletfile1` h   
                    WHERE h.idoneAdd=1 AND h.`ldelete` = 0 AND  h.`iupb_id` = '".$post['iupb_id']."'";
                $c111 = $this->db->query($sqL5)->num_rows();
                $sqL6 = "SELECT  h.`iappletfile1` FROM plc2.`appletfile1` h   
                    WHERE h.`ldelete` = 0 AND  h.`iupb_id` = '".$post['iupb_id']."'";
                $c222 = $this->db->query($sqL6)->num_rows();
                
                $sqL3 = "SELECT  h2.`iappletfile2` FROM plc2.`appletfile2` h2 
                JOIN  plc2.`appletfile1` h on h2.iappletfile1=h.iappletfile1
                WHERE h.`ldelete` = 0 AND h2.ldelete=0 AND h.`iupb_id` = '".$post['iupb_id']."'";
                $c3 = $this->db->query($sqL3)->num_rows();

                $sql4="SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                    JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                    JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
                    WHERE h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0  
                    AND h.`iupb_id` = '".$post['iupb_id']."'";
                $c4 = $this->db->query($sql4)->num_rows();

                /* Cek Grouping Semua Done */

                $sqlD="SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                    JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                    WHERE h2.`ldelete`=0 AND h.`ldelete` = 0 and h2.iDoneAll=0
                    AND h.`iupb_id` = '".$post['iupb_id']."'";
                $cD = $this->db->query($sqlD)->num_rows();

                $sqljj="select h1.iappletfile1 from plc2.appletfile1 h1 where  h1.ldelete = 0 AND h1.iupb_id = '".$post['iupb_id']."'";
                $sqljd="select h1.iappletfile1 from  plc2.appletfile2 h1 
                    join plc2.appletfile1 h2 on h2.iappletfile1=h1.iappletfile1 
                    join  plc2.appletfile3 h3 on h1.iappletfile2=h3.iappletfile2 
                    where  h2.ldelete = 0 AND h1.ldelete = 0 AND h2.iupb_id = '".$post['iupb_id']."' and h3.ldelete = 0
                    group by h1.iappletfile1";
                
                    $row111=$this->db->query($sqljj)->num_rows();
                    $row222=$this->db->query($sqljd)->num_rows();

                //Cek Don File untuk Manager Khusus Dia
                $sqlmm="select h1.iappletfile2 from  plc2.appletfile2 h1 
                    join plc2.appletfile1 h2 on h2.iappletfile1=h1.iappletfile1 
                    where  h2.ldelete = 0 AND h1.ldelete = 0 AND h2.iupb_id = '".$post['iupb_id']."'
                    group by h1.iappletfile2";
                $sqlnn="select h1.iappletfile2 from  plc2.appletfile2 h1 
                        join plc2.appletfile1 h2 on h2.iappletfile1=h1.iappletfile1 
                        join  plc2.appletfile3 h3 on h1.iappletfile2=h3.iappletfile2 
                        where  h2.ldelete = 0 AND h1.ldelete = 0 AND h2.iupb_id = '".$post['iupb_id']."' and h3.ldelete = 0
                        group by h1.iappletfile2";
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
                $dataupdate['tregistrasi']=$post['tregistrasi'];
                $dataupdate['tspb']=$post['tspb'];
                $dataupdate['itambahan_applet']=$post['itambahan_applet'];
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
				$lastId         = isset($post[$this->url."_".$this->main_table_pk])?$post[$this->url."_".$this->main_table_pk]:"0";
                $dataFieldUpload=$this->lib_plc->getUploadFileFromField($this->input->get('modul_id'));

                if(count($dataFieldUpload) > 0 && $lastId != "0" && $lastId != ""){
                    foreach ($dataFieldUpload as $kf => $vUpload) {
                        $pathf      = $vUpload['filepath'];
                        $iddetails  = $vUpload['filename'].'_iFile';

                        $validdetails = array();

                        foreach ($post as $kk => $vv) {
                            if($kk==$iddetails){
                                foreach ($vv as $kv2 => $vv2) {
                                    $validdetails[]=$vv2;
                                }
                                
                            }
                        }
                        $dataupdate['iDeleted']     = 1;
                        $dataupdate['dUpdate']      = date("Y-m-d H:i:s");
                        $dataupdate['cUpdate']      = $this->user->gNIP;
                        if(count($validdetails) > 0){
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
                        $where  = array('iDeleted'=>1,'idHeader_File'=>$lastId,'iM_modul_fileds'=>$vUpload['iM_modul_fileds']);
                        $this->db_plc0->where($where);
                        $qq     = $this->db_plc0->get('plc2.group_file_upload');

                        if($qq->num_rows() > 0){
                            $result = $qq->result_array();
                            foreach ($result as $kr => $vr) {
                                if(isset($vr["vFilename_generate"])){
                                    $pathf  = $vUpload['filepath'];
                                    $path   = realpath($pathf);
                                    if(file_exists($path."/".$lastId."/".$vr["vFilename_generate"])){
                                        unlink($path."/".$lastId."/".$vr["vFilename_generate"]);
                                    }
                                }
                            }

                        }
                    }
                }
				$sqlIn = "SELECT h.`iappletfile1`, h.idoneAdd FROM plc2.`appletfile1` h WHERE h.`ldelete` = 0 AND h.`iupb_id` = '".$lastId."'";
                $rowIn = $this->db->query($sqlIn)->result_array();  
                $i=0;
                    
                foreach ($rowIn as $r) {
                    if($r['idoneAdd']==0){
                        if($i==0){
                            $sqlCk = "SELECT * FROM plc2.`appletfile2` h WHERE h.`ldelete` = 0 AND h.`iappletfile1` =".$r['iappletfile1'];
                            $cekNum = $this->db->query($sqlCk)->num_rows();
                            if($cekNum>0){
                                //Delete yang Lama
                                $sqlDl = "UPDATE plc2.`appletfile2` h SET h.`ldelete` = 1 AND h.`iappletfile1` = ".$r['iappletfile1'];
                                $this->db->query($sqlDl); 
                            }
                            $i++;
                        }

                        $Deadline = array();
                        $vpic_td_dis = array();
                        $namaDokumen = array();

                        $ij = 0;
                        foreach($_POST as $key=>$value) {  
                            if ($key == 'Deadline_'.$r['iappletfile1']) {
                                foreach($value as $y=>$u) {
                                    $Deadline[$y] = $u;
                                }
                            }
                            if ($key == 'vpic_td_dis_'.$r['iappletfile1']) {
                                foreach($value as $y=>$u) {
                                    $vpic_td_dis[$y] = $u;
                                }
                            }
                            if ($key == 'namaDokumen_'.$r['iappletfile1']) {
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
                                    $sql="INSERT INTO plc2.appletfile2 (iappletfile1, vnamaDokumen, dDeadline, vTeamPD, dcreate, ccreate) 
                                                    VALUES (".$r['iappletfile1'].",'".$n."','".$Deadline[$ii]."','".$vpic_td_dis[$ii]."','".date('Y-m-d h:i:s')."','".$this->user->gNIP."')";
                                    $this->db->query($sql); 
                                }
                                $ii++;
                            } 
                        } 


                    }else{
                        $sqHP1 = "SELECT h.`iappletfile2` FROM plc2.`appletfile2` h WHERE h.`ldelete` = 0 AND h.`iappletfile1` =".$r['iappletfile1'];
                        $quHP1 = $this->db->query($sqHP1)->result_array();
                        foreach ($quHP1 as $r2) {
                            foreach($_POST as $key=>$value) {  
                                if ($key == 'DeadlineAD_'.$r2['iappletfile2']) {
                                    foreach($value as $y=>$u) {
                                        $sqlDl = "UPDATE plc2.`appletfile2` h SET h.`dcAndev` = '".$u."' WHERE h.`iappletfile2` = ".$r2['iappletfile2'];
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
                $iupbid=$lastId;
                $path = realpath("files/plc/appletnew/");
                if(!file_exists($path."/".$iupbid)){
                    if (!mkdir($path."/".$iupbid, 0777, true)) { //id review
                        die('Failed upload, try again!');
                    }
                } 
                $i=0;
                if (isset($_FILES['fileupload']))  {
                    foreach ($_FILES['fileupload']["error"] as $key => $error) {
                        if ($error == UPLOAD_ERR_OK) {
                            $tmp_name = $_FILES['fileupload']["tmp_name"][$key];
                            $name =$_FILES['fileupload']["name"][$key];
                            $data['filename'] = $name;
                            $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $path."/".$iupbid."/".$name)) {
                                    $sql="INSERT INTO plc2.appletfile1 (iupb_id, vfilename,  dcreate, ccreate) 
                                            VALUES (".$iupbid.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."')";
                                    $this->db->query($sql); 
                                    $i++;   
                                }
                                else{
                                    echo "Upload ke folder gagal";  
                                }
                        }
                    } 
                }  

                //Insert In Here Buat Nambah Tambahin Tipe Nya
                $sqlIn2 = "SELECT h2.`iappletfile2`, h.idoneAdd FROM plc2.`appletfile1` h JOIN
                plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h.`iupb_id` =  '".$iupbid."'";
                $rowIn2 = $this->db->query($sqlIn2)->result_array();  
                foreach ($rowIn2 as $r) { 
                    if(!file_exists($path."/".$iupbid."/"."detail/".$r['iappletfile2'])){
                        if (!mkdir($path."/".$iupbid."/"."detail/".$r['iappletfile2'], 0777, true)) { //id review
                            die('Failed upload, try again!');
                        }
                    } 
                    if (isset($_FILES['fileupload3_'.$r['iappletfile2']]))  {
                        foreach ($_FILES['fileupload3_'.$r['iappletfile2']]["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['fileupload3_'.$r['iappletfile2']]["tmp_name"][$key];
                                $name =$_FILES['fileupload3_'.$r['iappletfile2']]["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                    if(move_uploaded_file($tmp_name, $path."/".$iupbid."/detail/".$r['iappletfile2'].'/'.$name)) {
                                        $sql="INSERT INTO plc2.appletfile3 (irevisi , iappletfile2, vfilename,  dupload, cupload, dcreate, ccreate) 
                                                VALUES (0, ".$r['iappletfile2'].",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."', 
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
                $sqlIn2 = "SELECT h2.`iappletfile2`, h3.`iappletfile3` FROM plc2.`appletfile1` h 
                JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
                WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0 
                AND h3.`irevisi` = 1 
                AND h.`iupb_id` =   '".$iupbid."'";
                $rowIn2 = $this->db->query($sqlIn2)->result_array();  
                foreach ($rowIn2 as $r) { 
                    if (isset($_FILES['fileupload3_'.$r['iappletfile2'].'_'.$r['iappletfile3']]))  {
                        if(!file_exists($path."/".$iupbid."/"."detail/".$r['iappletfile2'])){
                            if (!mkdir($path."/".$iupbid."/"."detail/".$r['iappletfile2'], 0777, true)) { //id review
                                die('Failed upload, try again!');
                            }
                        } 

                        foreach ($_FILES['fileupload3_'.$r['iappletfile2'].'_'.$r['iappletfile3']]["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['fileupload3_'.$r['iappletfile2'].'_'.$r['iappletfile3']]["tmp_name"][$key];
                                $name =$_FILES['fileupload3_'.$r['iappletfile2'].'_'.$r['iappletfile3']]["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                    if(move_uploaded_file($tmp_name, $path."/".$iupbid."/detail/".$r['iappletfile2'].'/'.$name)) {

                                        $sql = "UPDATE plc2.`appletfile3` h SET h.irevisi = 0, h.iappletfile2 = '".$r['iappletfile2']."' ,
                                            h.vfilename = '".$data['filename']."', h.dupload = '".$data['dInsertDate']."', 
                                            h.cupload = '".$this->user->gNIP."', h.dupdate = '".$data['dInsertDate']."',
                                            h.cupdate = '".$this->user->gNIP."'
                                        WHERE h.`iappletfile3` = ".$r['iappletfile3']; 

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
       	$js .= $this->load->view('js/registrasi_applet_custome_js',$data,TRUE);
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

                        $setuju = '<button onclick="javascript:confirm_registrasi_applet(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?company_id='.$this->input->get('company_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_'.$this->url.'"  class="ui-button-text icon-save" >Confirm</button>';

                        if($this->auth->is_manager()){ 

                            $x=$this->auth->dept();
                            $manager=$x['manager'];
                            if(in_array('BD', $manager)){ 
                                $type='BD';
                                if($rowData['iappbusdev_registrasi']==0){
                                    //Cek Done File untul BD
                                    $sql = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                    JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                                    JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
                                    WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0 
                                    AND h3.`irevisi` = 2 AND h3.`iDone` = 1 AND h2.`iDoneAll` =  1 AND  h.`iupb_id` = '".$rowData['iupb_id']."'";
                                    $c1 = $this->db->query($sql)->num_rows();
                                    $sql2 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                        JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                                        JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
                                        WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0  
                                        AND h.`iupb_id` = '".$rowData['iupb_id']."'";
                                    $c2 = $this->db->query($sql2)->num_rows();


                                    $sql3 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                        JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
                                        WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0  AND (h2.dcAndev<>'0000-00-00' AND h2.dcAndev IS NOT NULL)
                                        AND h2.`iDoneAll` =  1 
                                        AND h2.vTeamPD='AD' AND  h.`iupb_id` = '".$rowData['iupb_id']."'";
                                    $c11 = $this->db->query($sql3)->num_rows();
                                    $sql4 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                        JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
                                        WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 
                                        AND h2.vTeamPD='AD' AND h.`iupb_id` = '".$rowData['iupb_id']."'";
                                    $c22 = $this->db->query($sql4)->num_rows();


                                    $sqL5 = "SELECT  h.`iappletfile1` FROM plc2.`appletfile1` h   
                                        WHERE h.idoneAdd=1 AND h.`ldelete` = 0 AND  h.`iupb_id` = '".$rowData['iupb_id']."'";
                                    $c111 = $this->db->query($sqL5)->num_rows();
                                    $sqL6 = "SELECT  h.`iappletfile1` FROM plc2.`appletfile1` h   
                                        WHERE h.`ldelete` = 0 AND  h.`iupb_id` = '".$rowData['iupb_id']."'";
                                    $c222 = $this->db->query($sqL6)->num_rows();
                
                                    $sqL3 = "SELECT  h2.`iappletfile2` FROM plc2.`appletfile2` h2 
                                    JOIN  plc2.`appletfile1` h on h2.iappletfile1=h.iappletfile1
                                    WHERE h.`ldelete` = 0 AND h2.ldelete=0 AND h.`iupb_id` = '".$rowData['iupb_id']."'";
                                    $c3 = $this->db->query($sqL3)->num_rows();

                                    $sql4="SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                        JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                                        JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
                                        WHERE h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0  
                                        AND h.`iupb_id` = '".$rowData['iupb_id']."'";
                                    $c4 = $this->db->query($sql4)->num_rows();

                                    $sqlD="SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                        JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                                        WHERE h2.`ldelete`=0 AND h.`ldelete` = 0 and h2.iDoneAll=0
                                        AND h.`iupb_id` = '".$rowData['iupb_id']."'";
                                    $cD = $this->db->query($sqlD)->num_rows();

                                     /* Cek Data Di Dokumen Sebelum di Isi */
                                     $sqljj="select h1.iappletfile1 from plc2.appletfile1 h1 where  h1.ldelete = 0 AND h1.iupb_id = '".$rowData['iupb_id']."'";
                                     $sqljd="select h1.iappletfile1 from  plc2.appletfile2 h1 
                                             join plc2.appletfile1 h2 on h2.iappletfile1=h1.iappletfile1 
                                             join  plc2.appletfile3 h3 on h1.iappletfile2=h3.iappletfile2 
                                             where  h2.ldelete = 0 AND h1.ldelete = 0 AND h2.iupb_id = '".$rowData['iupb_id']."' and h3.ldelete = 0
                                             group by h1.iappletfile1";
                                         $row111=$this->db->query($sqljj)->num_rows();
                                         $row222=$this->db->query($sqljd)->num_rows();
                                     //Cek Don File untuk Manager Khusus Dia
                                     $sqlmm="select h1.iappletfile2 from  plc2.appletfile2 h1 
                                             join plc2.appletfile1 h2 on h2.iappletfile1=h1.iappletfile1 
                                             where  h2.ldelete = 0 AND h1.ldelete = 0 AND h2.iupb_id = '".$rowData['iupb_id']."'
                                             group by h1.iappletfile2";
                                     $sqlnn="select h1.iappletfile2 from  plc2.appletfile2 h1 
                                             join plc2.appletfile1 h2 on h2.iappletfile1=h1.iappletfile1 
                                             join  plc2.appletfile3 h3 on h1.iappletfile2=h3.iappletfile2 
                                             where  h2.ldelete = 0 AND h1.ldelete = 0 AND h2.iupb_id = '".$rowData['iupb_id']."' and h3.ldelete = 0
                                             group by h1.iappletfile2";
                                     $rowmm=$this->db->query($sqlmm)->num_rows();
                                     $rownn=$this->db->query($sqlnn)->num_rows();
                                     /* Cek Untuk TD Yang Belum Upload Sama Sekali */
 
                
                                    //Cek Don File untuk Manager Khusus Dia
                                    if($rowData['itambahan_applet']==1){
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
                                }elseif($rowData['iappbusdev_registrasi']==2&&$rowData['iappbd_applet']==0){
                                    $sButton.=$update_draft.$setuju;
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
                
                                $sql = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                    JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                                    JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
                                    WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0 
                                    AND h3.`irevisi` = 2 AND h3.`iDone` = 1 AND h2.`iDoneAll` =  1 AND 
                                    h2.`vTeamPD` in(".$dtO.") AND h.`iupb_id` = '".$rowData['iupb_id']."'";
                                $c1 = $this->db->query($sql)->num_rows();
                                $sql2 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                    JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                                    JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
                                    WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0  
                                    AND h2.`vTeamPD` in(".$dtO.") AND h.`iupb_id` = '".$rowData['iupb_id']."'";
                                $c2 = $this->db->query($sql2)->num_rows();
                
                
                                $sql = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                    JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
                                    WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h2.`iDoneAll` =  1 AND 
                                    h2.`vTeamPD`in(".$dtO.") AND h.`iupb_id` = '".$rowData['iupb_id']."'";
                                $c11 = $this->db->query($sql)->num_rows();
                                $sql2 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                    JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
                                    WHERE h2.`ldelete`=0 AND h.`ldelete` = 0 
                                    AND h2.`vTeamPD` in(".$dtO.") AND h.`iupb_id` = '".$rowData['iupb_id']."'";
                                $c22 = $this->db->query($sql2)->num_rows(); 
                                //Cek Don File untuk Manager Khusus Dia
                                if($c1==$c2 && $c11==$c22){  
                                    if(in_array('AD', $manager)){
                                        $sql3 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                            JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
                                            WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0  AND (h2.dcAndev<>'0000-00-00' AND h2.dcAndev IS NOT NULL)
                                            AND h2.`iDoneAll` =  1 AND  h.`iupb_id` = '".$rowData['iupb_id']."'";
                                            
                                        $c11 = $this->db->query($sql3)->num_rows();
                                        $sql4 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                            JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
                                            WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h.`iupb_id` = '".$rowData['iupb_id']."'";
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
                                    if($rowData['iappbd_applet']==0){
                                        $sql = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                            JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                                            JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
                                            WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0 
                                            AND h3.`irevisi` = 2 AND h3.`iDone` = 1 AND h2.`iDoneAll` =  1 AND h.`iupb_id` = '".$rowData['iupb_id']."'";
                                        $c1 = $this->db->query($sql)->num_rows();
                                        $sql2 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                            JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                                            JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
                                            WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0  
                                            AND  h.`iupb_id` = '".$rowData['iupb_id']."'";
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
                                    $sql = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                        JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                                        JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
                                        WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0 
                                        AND h3.`irevisi` = 2 AND h3.`iDone` = 1 AND h2.`iDoneAll` =  1 AND h2.`vTeamPD`in(".$dtO.") AND h.`iupb_id` = '".$rowData['iupb_id']."'";
                                    $c1 = $this->db->query($sql)->num_rows();
                                    $sql2 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                        JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
                                        JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
                                        WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0  
                                        AND h2.`vTeamPD` in(".$dtO.") AND h.`iupb_id` = '".$rowData['iupb_id']."'";
                                    $c2 = $this->db->query($sql2)->num_rows();
                                     //Cek Don File untuk Manager Khusus Dia
                
                                    $sql = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                        JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
                                        WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h2.`iDoneAll` =  1 AND h2.`vTeamPD` in(".$dtO.") AND h.`iupb_id` = '".$rowData['iupb_id']."'";
                                    $c11 = $this->db->query($sql)->num_rows();
                                    $sql2 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                        JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
                                        WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 
                                        AND h2.`vTeamPD`in(".$dtO.") AND h.`iupb_id` = '".$rowData['iupb_id']."'";
                                    $c22 = $this->db->query($sql2)->num_rows(); 
                                    //Cek Don File untuk Manager Khusus Dia
                                    if($c1==$c2 && $c11==$c22){ 
                                        if($dtO=="AD"){
                                            $sql3 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                                JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
                                                WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0  AND 
                                                (h2.dcAndev<>'0000-00-00' or h2.dcAndev IS NOT NULL)
                                                AND h2.vTeamPD='AD' AND h2.`iDoneAll` =  1 AND  h.`iupb_id` = '".$rowData['iupb_id']."'";
                                            $c11 = $this->db->query($sql3)->num_rows();
                                            $sql4 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
                                                JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
                                                WHERE h.idoneAdd=1 AND h2.vTeamPD='AD' AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h.`iupb_id` = '".$rowData['iupb_id']."'";
                                            $c22 = $this->db->query($sql4)->num_rows();
                                            if($c11!=$c22){
                                                $sButton.=$update_draft;
                                            }
                                        }
                                    }else{
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
        $js .= $this->load->view('js/js_registrasi_applet_upload_js');

        $iframe = '<iframe name="'.$this->url.'_frame" id="'.$this->url.'_frame" height="0" width="0"></iframe>';
        
        $save = '<button onclick="javascript:registrasi_applet_custome_save(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?draft=true&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',this,true )"  id="button_save_draft_'.$this->url.'"  class="ui-button-text icon-save" >Save</button>';
        //$save = '<button onclick="javascript:registrasi_applet_custome_save(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_save_submit_'.$this->url.'"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

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
        return $buttons;
	}

	/*List Box*/
	/*function listBox_v3_reg_applet_cPIC_AD($value, $pk, $name, $rowData) {
		$sql="select em.cNip, em.vName from hrd.employee em where em.cNip='".$value."'";
		$qq=$this->db_plc0->query($sql);
		$return = "-";
		if($qq->num_rows()>0){
			$row=$qq->row_array();
			$return=$row["cNip"]." - ".$row["vName"];
		}
		return $return;
	}
	function listBox_v3_reg_applet_plc2_upb_iteampd_id($value, $pk, $name, $rowData) {
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
	function insertBox_v3_reg_applet_form_detail($field,$id){
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
        function updateBox_v3_reg_applet_test($field,$id,$value,$rowData){
            $iupb_id=$rowData['iupb_id'];
            $this->db->where("vNama","APPLET_CONFIRM");
            $this->db->where("lDeleted","0");
            $hnotif=$this->db->get("plc2.notifikasi_h")->row_array();
            $html=$hnotif["vTemplate"];
            $whereJamak='AND plc2_upb.iupb_id ="'.$iupb_id.'"';
            $this->db->where('iHeader_id',$hnotif['id']);
            $dquery=$this->db->get('plc2.notifikasi_query')->result_array();
            foreach ($dquery as $kv => $vv) {
                $row=$this->db->query($vv['tQuery'].' '.$whereJamak)->row_array();
                $field=array_keys($row);
                if($vv["tCustom"]=="{##default##}"){
                    $html=str_replace("{##".$vv["vKode"]."##}",$row[$field[0]],$html);
                }else{
                    $str_det=$vv["tCustom"];
                    foreach ($field as $fieldkey => $vfield) {
                        $value=isset($row[$vfield])?$row[$vfield]:"ORA ONO";
                        $str_det=str_replace("{##".$vfield."##}",$value,$str_det);
                    }
                    $html=str_replace("{##".$vv["vKode"]."##}",$str_det,$html);
                }
            }
            $this->db->where("cNip",$this->user->gNIP);
            $row=$this->db->get("hrd.employee")->row_array();
            $html=str_replace("{##GLOBAL_NAMA_LOGIN##}",$row["vName"],$html);
            $parsed = $this->getInbetweenStrings('{##', '##}', $html);
            foreach ($parsed as $kp1 => $vp1) {
                $html=str_replace("{##".$vp1."##}","-",$html);
            }

            //Get To CC Data;
            $this->db->where("iHeader_id",$hnotif['id']);
            $this->db->where("lDeleted",0);
            $result=$this->db->get("plc2.notifikasi_d")->result_array();
            $toarrayNIP=array();
            $ccarrayNIP=array(); 
            $toarrayEmail=array();
            $ccarrayEmail=array();
            $bccarrayNIP=explode(",",$hnotif["vBCC"]);
            $bccarrayEmail=array();
            foreach ($result as $kr => $vvr) {
                $this->db->where('cNip',$vvr["vNip"]);
                $rowEmployee=$this->db->get("hrd.employee")->row_array();
               if($vvr['iTipe']==1){
                $toarrayNIP[]=$vvr["vNip"];
                $toarrayEmail[]=$rowEmployee["vEmail"];
               }else{
                $ccarrayNIP[]=$vvr["vNip"];
                $ccarrayEmail[]=$rowEmployee["vEmail"];
               }
            }
            
            // Email
            /*Send Mail*/

            $this->_ci->load->helper('email');
            $this->_ci->load->library('email');

            /*Kebutuhan Email*/
            
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = '10.1.48.4';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['wordwrap'] = FALSE;
            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';
            $config['crlf'] = "\r\n";
            $config['newline'] = "\r\n";
            
            $from = "postmaster@novellpharm.com";
            // $to='supri@novellpharm.com';
            // $cc = "mansur@novellpharm.com";
            // $bcc = "eka.yuni@novellpharm.com"; //$cc;

            $toemail=implode(";",$toarrayEmail);
            $ccemail=implode(";",$ccarrayEmail);

            foreach ($bccarrayEmail as $kbcc => $vbcc) {
                $this->db->where('cNip',$vbcc);
                $bccarrayEmail=$this->db->get("hrd.employee")->row_array();
            }

            $bccemail=implode(";",$bccarrayEmail);

            $content = $html;
            
            
            $this->_ci->email->initialize($config);
            $this->_ci->email->from($from, $hnotif["vCaptionMail"]);
            $this->_ci->email->to($toemail);
            $this->_ci->email->cc($ccemail);
            $this->_ci->email->bcc($bccemail);
            $this->_ci->email->subject($hnotif["vSubject"]);
            $this->_ci->email->message($content);

            /*Attch File*/
            $sql="SELECT gr.*,ma.filepath from plc2.group_file_upload gr
            join plc2.sys_masterdok ma on ma.iM_modul_fileds=gr.iM_modul_fileds
            where ma.ldeleted=0 and gr.iDeleted=0 and ma.filename='vfileregistrasiApplet'
            and gr.idHeader_File=".$iupb_id;
            $que=$this->db->query($sql);
            if($que->num_rows()>0){
                $html.="<br /><br /><p>Attch:</p>";
                $i=1;
                foreach ($que->result_array() as $kf => $vfile) {
                    $path=$vfile["filepath"];
                    if($path != '') {
                        if (file_exists('./'.$path.'/'.$iupb_id.'/'.$vfile["vFilename_generate"])) {
                            
                            $this->_ci->email->attach('./'.$path.'/'.$iupb_id.'/'.$vfile["vFilename_generate"]); 
                            
                            $link = base_url().'processor/'.$this->urlpath.'?action=download&id='.$iupb_id.'&file='.$vfile["vFilename_generate"].'&path=vfileregistrasiApplet';
                            $html .= '<p>'.$i.'. <a class="ui-button-text" href="javascript:;" onclick="window.location=\''.$link.'\'">'.$vfile["vFilename"].'</a></p>';
                            $i++;
                        }
                    }
                }
            }
            
            $this->_ci->email->send();

            $tonip=implode(";",$toarrayNIP);
            $ccnip=implode(";",$ccarrayNIP);
            $subject=$hnotif["vSubject"];
            $content=$html;
            $this->sess_message->send_message_erp($this->uri->segment_array(),$tonip, $ccnip, $subject, $content);

            return $html;
        }
        function getInbetweenStrings($start, $end, $str){
            $matches = array();
            $regex = "/$start([a-zA-Z0-9_]*)$end/";
            preg_match_all($regex, $str, $matches);
            return $matches[1];
        }
        

        function updateBox_v3_reg_applet_form_detail($field,$id,$value,$rowData){
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
        /* Cek Apakah dia sudah approve reg belum */
        $this->db->where('iupb_id',$postData['iupb_id']);
        $row=$this->db->get('plc2.plc2_upb')->row_array();
        $iappbusdev_registrasi=$row['iappbusdev_registrasi'];
        if($iappbusdev_registrasi==0){
            $postData["iprareg_ulang_reg"]=NULL;
            $postData["ireg_ulang"]=NULL;
            $postData["iHasil_registrasi"]=NULL;
            $postData["vnie"]=NULL;
            $postData["imutu_prareg"]=NULL;
            $postData["ibutuh_dok_prareg"]=NULL;
            $postData["imutu_reg"]=NULL;
            $postData["ibutuh_dok_reg"]=NULL;
            $postData["iPic_Registrasi_req_doc"]=NULL;
        }
        if($postData['isdraft']==true){
            $postData['isubmit']=0;
        } 
        else{
            $postData['isubmit']=1;
            $postData['iappbusdev_registrasi']=2;
            $postData['tappbusdev_registrasi']=date("Y-m-d H:i:s");
            $postData['vnip_appbusdev_registrasi']=$this->user->gNIP;
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

        $iprareg_ulang_reg=$post['iprareg_ulang_reg'];
        $ireg_ulang=$post['ireg_ulang'];
        $imutu_reg=$post['imutu_reg'];
        $ibutuh_dok_reg=$post['ibutuh_dok_reg'];
        $imutu_prareg=$post['imutu_prareg'];
        $ibutuh_dok_prareg=$post['ibutuh_dok_prareg'];
        $iHasil_registrasi=$post['iHasil_registrasi'];

        $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

        $ireq=isset($post['iPic_Registrasi_req_doc'])?$post['iPic_Registrasi_req_doc']:'0';


        /* Jika Butuh Tambahan Dokumen Registrasi Tidak */
        if($iprareg_ulang_reg==0 && $ireg_ulang==1 && $imutu_reg==0 && $ibutuh_dok_reg==0){
            $vRemark="Confirm : Butuh Dokumen Registrasi - Tidak";
            $field = $activity['vFieldName'];
            $update = array('iappbusdev_registrasi'=>0,'iprareg_ulang_reg'=>NULL,'ireg_ulang'=>NULL,'imutu_reg'=>NULL,'ibutuh_dok_reg'=>NULL,'imutu_prareg'=>NULL,'ibutuh_dok_prareg'=>NULL);
            $this->db->where("iupb_id", $pk);
            $this->db->update("plc2.plc2_upb", $update);
            $iupb_id[]=$pk;
            $this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);
            
            /* Delete Semua Log */
            $this->db->where('iKey_id',$pk);
            $this->db->where('idprivi_modules',$modul_id);
            $this->db->update('plc3.m_modul_log_activity',array('lDeleted'=>1));
        
        }


        /* Jika Butuh Tambahan Dokumen Registrasi Ya */

        if($iprareg_ulang_reg==0 && $ireg_ulang==1 && $imutu_reg==0 && $ibutuh_dok_reg==1){

            /*Clear Di Registrasi  */
            $vRemark="Confirm : Butuh Dokumen Registrasi - Ya";
            $field = $activity['vFieldName'];
            $update = array('iappbusdev_registrasi'=>0,'iprareg_ulang_reg'=>NULL,'ireg_ulang'=>NULL,'imutu_reg'=>NULL,'ibutuh_dok_reg'=>NULL,'imutu_prareg'=>NULL,'ibutuh_dok_prareg'=>NULL);
            $this->db->where("iupb_id", $pk);
            $this->db->update("plc2.plc2_upb", $update);
            $iupb_id[]=$pk;
            $this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);
            $ireq=isset($post['iPic_Registrasi_req_doc'])?$post['iPic_Registrasi_req_doc']:'0';
            /* Delete Semua Log */
            $this->db->where('iKey_id',$pk);
            $this->db->where('idprivi_modules',$modul_id);
            if($ireq==1){
                $this->db->where('vRemark =!',"Approval PD");
            }
            $this->db->update('plc3.m_modul_log_activity',array('lDeleted'=>1));

            /* Clear Di Cek Dok Registrasi */
            $update = array('iappbusdev_registrasi'=>0
                            ,'iprareg_ulang_reg'=>NULL
                            ,'ireg_ulang'=>NULL
                            ,'imutu_reg'=>NULL
                            ,'ibutuh_dok_reg'=>NULL
                            ,'imutu_prareg'=>NULL
                            ,'ibutuh_dok_prareg'=>NULL
                            ,'iconfirm_registrasi_qa'=>0
                            ,'iconfirm_registrasi'=>0
                            ,'tRegistrasi_req_doc'=>$post["tRegistrasi_req_doc"]
                            ,'iPic_Registrasi_req_doc'=>$post["iPic_Registrasi_req_doc"]
                        );
          
                    if($ireq==0){
                        $update['iconfirm_registrasi_pd']=0;
                    }

            $this->db->where("iupb_id", $pk);
            $this->db->update("plc2.plc2_upb", $update);
            
            /* Open All Done File di Registrasi */
            $CODE='PL00029';
            $sql='select * from plc3.m_modul where lDeleted=0 AND vKode_modul="'.$CODE.'"';
            $getprivi=$this->db->query($sql)->row_array();
            $idprivi=isset($getprivi['idprivi_modules'])?$getprivi['idprivi_modules']:0;

            $filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
            $rowtb=$this->v3_m_reg->getDetailFiles($filter)->result_array();
            foreach ($rowtb as $krow => $vrow) {
                $ipk=$this->v3_m_reg->getAnotherUPB($vrow['fieldheader'],$pk);
                $iM_modul_fileds=$vrow['iM_modul_fileds'];
                $this->db->where("iM_modul_fileds",$iM_modul_fileds)
                        ->where('idHeader_File',$ipk)
                        ->where('iDeleted',0);
                $this->db->update('plc2.group_file_upload',array('iDone'=>0));
            }

            /* Hapus Activity Cek Dokumen Registrasi */
            $this->db->where('iKey_id',$pk)
                        ->where('idprivi_modules',$idprivi);
            $this->db->update('plc3.m_modul_log_activity',array('lDeleted'=>1));

            /* Send Email */
            $cData['module']="Cek Dokumen Registrasi";
            $this->db->where('iupb_id',$pk);
            $rowUPB=$this->db->get('plc2.plc2_upb')->row_array();

            $iteampd_id=$rowUPB['iteampd_id']>0?$rowUPB['iteampd_id']:"0";
            $iteamqa_id=$rowUPB['iteamqa_id']>0?$rowUPB['iteamqa_id']:"0";
            $iteambusdev_id=$rowUPB['iteambusdev_id']>0?$rowUPB['iteambusdev_id']:"0";
            /* Get CC */
            $sql="select * from plc2.plc2_upb_team where iteam_id IN (".$iteampd_id.",".$iteamqa_id.",".$iteamqa_id.",".$iteambusdev_id.") AND ldeleted=0";
            if($ireq==1){
                $sql="select * from plc2.plc2_upb_team where iteam_id IN (".$iteamqa_id.",".$iteamqa_id.",".$iteambusdev_id.") AND ldeleted=0";
            }
            $qqqq=$this->db->query($sql)->result_array();
            $teamM=array();
            foreach ($qqqq as $kq => $vq) {
                $teamM[]=$vq["vnip"];
            }
            $cc=implode(";",$teamM);
            
            $sql2="select * from plc2.plc2_upb_team_item where iteam_id IN (".$iteampd_id.",".$iteamqa_id.",".$iteamqa_id.",".$iteambusdev_id.") AND ldeleted=0";
            if($ireq==1){
                $sql2="select * from plc2.plc2_upb_team_item where iteam_id IN (".$iteamqa_id.",".$iteamqa_id.",".$iteambusdev_id.") AND ldeleted=0";
            }
            $qqqq2=$this->db->query($sql2)->result_array();
            $teamT=array();
            foreach ($qqqq2 as $kq => $vq) {
                $teamT[]=$vq["vnip"];
            }

            $to=implode(";",$teamT);

            $cData['rowUPB']=$rowUPB;
            $cData['headerCaption']="Mohon untuk melakukan update Cek Dokumen Registrasi aplikasi PLC dengan rincian:";
            $content = $this->load->view('partial/mail_themplate',$cData,TRUE);
            $path = '';
            $subject = "Registrasi - Butuh Dokumen [".$rowUPB['vupb_nomor']."']";
            $this->sess_message->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
        }

        if($iprareg_ulang_reg==0 && $ireg_ulang==1 && $imutu_reg==1){
            /*Clear Di Registrasi  */
            $vRemark="Confirm : Butuh Dokumen Registrasi - Ya";
            $field = $activity['vFieldName'];
            $update = array('iappbusdev_registrasi'=>0,'iprareg_ulang_reg'=>NULL,'ireg_ulang'=>NULL,'imutu_reg'=>NULL,'ibutuh_dok_reg'=>NULL,'imutu_prareg'=>NULL,'ibutuh_dok_prareg'=>NULL);
            $this->db->where("iupb_id", $pk);
            $this->db->update("plc2.plc2_upb", $update);

            /* balikin status jika punya child */
                $sqlUPBref = 'select * from plc2.plc2_upb a where a.iupb_id_ref= "'.$pk.'"';
                $dUpebehref = $this->db->query($sqlUPBref)->row_array();

                $update = array('iappbusdev_registrasi'=>0,'iprareg_ulang_reg'=>NULL,'ireg_ulang'=>NULL,'imutu_reg'=>NULL,'ibutuh_dok_reg'=>NULL,'imutu_prareg'=>NULL,'ibutuh_dok_prareg'=>NULL);
                $this->db->where("iupb_id", $dUpebehref['iupb_id']);
                $this->db->update("plc2.plc2_upb", $update);
            /* balikin status jika punya child */

            /* balikin status jika punya child  ke cek dok prareg*/
                $update = array($field => 0,'tsubmit_prareg'=>NULL, 'iappbusdev_prareg'=>0,'iconfirm_dok'=>0,'iconfirm_dok_pd'=>0,'iconfirm_dok_qa'=>0);
                $this->db->where("iupb_id", $dUpebehref['iupb_id']);
                $this->db->update("plc2.plc2_upb", $update);
            /* balikin status jika punya child  ke cek dok prareg*/
            
            


            $iupb_id[]=$pk;
            $this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);
            
            /* Delete Semua Log */
            $this->db->where('iKey_id',$pk);
            $this->db->where('idprivi_modules',$modul_id);
            $this->db->update('plc3.m_modul_log_activity',array('lDeleted'=>1));

            /* Clear Di Cek Dok Registrasi */
            $update = array('iappbusdev_registrasi'=>0
                            ,'iprareg_ulang_reg'=>NULL
                            ,'ireg_ulang'=>NULL
                            ,'imutu_reg'=>NULL
                            ,'ibutuh_dok_reg'=>NULL
                            ,'imutu_prareg'=>NULL
                            ,'ibutuh_dok_prareg'=>NULL
                            ,'iconfirm_registrasi'=>0
                            ,'iconfirm_registrasi_qa'=>0
                            ,'iconfirm_registrasi_pd'=>0
                        );
            $this->db->where("iupb_id", $pk);
            $this->db->update("plc2.plc2_upb", $update);


            /* Clear Di Cek Dok Registrasi (untuk Child)*/
            $update = array('iappbusdev_registrasi'=>0
                            ,'iprareg_ulang_reg'=>NULL
                            ,'ireg_ulang'=>NULL
                            ,'imutu_reg'=>NULL
                            ,'ibutuh_dok_reg'=>NULL
                            ,'imutu_prareg'=>NULL
                            ,'ibutuh_dok_prareg'=>NULL
                            ,'iconfirm_registrasi'=>0
                            ,'iconfirm_registrasi_qa'=>0
                            ,'iconfirm_registrasi_pd'=>0
                        );
            $this->db->where("iupb_id", $dUpebehref['iupb_id']);
            $this->db->update("plc2.plc2_upb", $update);
            
            /* Open All Done File di Registrasi */
            $CODE='PL00029';
            $sql='select * from plc3.m_modul where lDeleted=0 AND vKode_modul="'.$CODE.'"';
            $getprivi=$this->db->query($sql)->row_array();
            $idprivi=isset($getprivi['idprivi_modules'])?$getprivi['idprivi_modules']:0;

            $filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
            $rowtb=$this->v3_m_reg->getDetailFiles($filter)->result_array();
            foreach ($rowtb as $krow => $vrow) {
                $ipk=$this->v3_m_reg->getAnotherUPB($vrow['fieldheader'],$pk);
                $iM_modul_fileds=$vrow['iM_modul_fileds'];
                $this->db->where("iM_modul_fileds",$iM_modul_fileds)
                        ->where('idHeader_File',$ipk)
                        ->where('iDeleted',0);
                $this->db->update('plc2.group_file_upload',array('iDone'=>0));
            }

            /* Hapus Activity Cek Dokumen Registrasi */
            $this->db->where('iKey_id',$pk)
                        ->where('idprivi_modules',$idprivi);
            $this->db->update('plc3.m_modul_log_activity',array('lDeleted'=>1));

            /* Get Module yang Uji Mutu */
            $wherearr=array('iMutu'=>1,'lDeleted'=>0);
            $this->db->where($wherearr);
            $result=$this->db->get('plc3.m_modul')->result_array();
            foreach($result as $kr => $vkar){
                $datainsert['idprivi_modules']=$vkar['idprivi_modules'];
                $datainsert['iupb_id']=$pk;
                $this->db->insert('plc2.log_mutu',$datainsert);
            }

        }

        if($iprareg_ulang_reg==1 && $imutu_prareg==1){

            /* Hapus Cek Dok Reg */

            $this->removeCekDokPrareg();
            $this->removeCekDokRegistrasi();
            

            $vRemark="Confirm - Karena Mutu - Prareg : Ya";
            $field = $activity['vFieldName'];
            $update = array($field => 0,'tsubmit_prareg'=>NULL, 'iappbusdev_prareg'=>0,'iprareg_ulang_prareg'=>0,'imutu_prareg'=>0,'ibutuh_dok_prareg'=>0);
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
        
        /* Imutu Karena Registrasi */
        if($iprareg_ulang_reg==0 && $ireg_ulang==1 && $imutu_reg==1){

            $this->removeCekDokPrareg();
            $this->removeCekDokRegistrasi();

            $vRemark="Confirm - Karena Mutu - Reg : Ya";
            $field = $activity['vFieldName'];
            $update = array($field => 0,'tsubmit_prareg'=>NULL, 'iappbusdev_prareg'=>0,'iprareg_ulang_prareg'=>0,'imutu_prareg'=>0,'ibutuh_dok_prareg'=>0);
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

        if($iprareg_ulang_reg==1 && $imutu_prareg==0 && $ibutuh_dok_prareg==1){
            $this->removeCekDokPrareg();
            $this->removeCekDokRegistrasi();
            $update = array('iappbusdev_registrasi'=>0
                ,'iprareg_ulang_reg'=>NULL
                ,'ireg_ulang'=>NULL
                ,'imutu_reg'=>NULL
                ,'ibutuh_dok_reg'=>NULL
                ,'imutu_prareg'=>NULL
                ,'ibutuh_dok_prareg'=>NULL
                ,'iconfirm_registrasi_qa'=>0
                ,'iconfirm_registrasi'=>0
                ,'tPrareg_req_doc'=>$post["tPrareg_req_doc"]
                ,'iPic_Prareg_req_doc'=>$post["iPic_Prareg_req_doc"]
            );
            $update['iconfirm_registrasi_pd']=0;
            $update['iconfirm_dok_qa']=0;
            $update['iconfirm_dok']=0;
            $update['iappbusdev_registrasi']=0;
            $update['iappbd_applet']=0;
            $update['iappbusdev_prareg']=0;
            $update['iappbd_applet']=0;

            if($ireq==0){
                $update['iconfirm_dok_pd']=0;
            }

        $this->db->where("iupb_id", $pk);
        $this->db->update("plc2.plc2_upb", $update);

            $filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
            $rowtb=$this->v3_m_reg->getDetailFiles($filter)->result_array();
            foreach ($rowtb as $krow => $vrow) {
                $ipk=$this->v3_m_reg->getAnotherUPB($vrow['fieldheader'],$pk);
                $iM_modul_fileds=$vrow['iM_modul_fileds'];
                $this->db->where("iM_modul_fileds",$iM_modul_fileds)
                        ->where('idHeader_File',$ipk)
                        ->where('iDeleted',0);
                $this->db->update('plc2.group_file_upload',array('iDone'=>0));
            }

            /* Send Email */
            $cData['module']="Cek Dokumen Registrasi";
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
            $subject = "Registrasi - Butuh Dokumen [".$rowUPB['vupb_nomor']."']";
            $this->sess_message->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);

            /* Cek */
            /* Remove All log di Prareg*/
            $CODE='PL00049';
            $sql='select * from plc3.m_modul where lDeleted=0 AND vKode_modul="'.$CODE.'"';
            $getprivi=$this->db->query($sql)->row_array();
            $idprivi=isset($getprivi['idprivi_modules'])?$getprivi['idprivi_modules']:0;

            $this->db->where('iKey_id',$pk)
                        ->where('idprivi_modules',$idprivi);
            $this->db->update('plc3.m_modul_log_activity',array('lDeleted'=>1));


        }
        if($iprareg_ulang_reg==0 && $ireg_ulang==0){
            $iupb_id[]=$pk;
            $update['iappbd_applet']=2;
            $this->db->where("iupb_id", $pk);
            $this->db->update("plc2.plc2_upb", $update);
            $vRemark="Confirm BD";
            $this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);

            // Notif Email Dengan Attch
            if($iHasil_registrasi==1){
                $iupb_id=$pk;
                $this->db->where("vNama","APPLET_CONFIRM");
                $this->db->where("lDeleted","0");
                $hnotif=$this->db->get("plc2.notifikasi_h")->row_array();
                $html=$hnotif["vTemplate"];
                $whereJamak='AND plc2_upb.iupb_id ="'.$iupb_id.'"';
                $this->db->where('iHeader_id',$hnotif['id']);
                $dquery=$this->db->get('plc2.notifikasi_query')->result_array();
                foreach ($dquery as $kv => $vv) {
                    $row=$this->db->query($vv['tQuery'].' '.$whereJamak)->row_array();
                    $field=array_keys($row);
                    if($vv["tCustom"]=="{##default##}"){
                        $html=str_replace("{##".$vv["vKode"]."##}",$row[$field[0]],$html);
                    }else{
                        $str_det=$vv["tCustom"];
                        foreach ($field as $fieldkey => $vfield) {
                            $value=isset($row[$vfield])?$row[$vfield]:"ORA ONO";
                            $str_det=str_replace("{##".$vfield."##}",$value,$str_det);
                        }
                        $html=str_replace("{##".$vv["vKode"]."##}",$str_det,$html);
                    }
                }
                $this->db->where("cNip",$this->user->gNIP);
                $row=$this->db->get("hrd.employee")->row_array();
                $html=str_replace("{##GLOBAL_NAMA_LOGIN##}",$row["vName"],$html);
                $parsed = $this->getInbetweenStrings('{##', '##}', $html);
                foreach ($parsed as $kp1 => $vp1) {
                    $html=str_replace("{##".$vp1."##}","-",$html);
                }

                //Get To CC Data;
                $this->db->where("iHeader_id",$hnotif['id']);
                $this->db->where("lDeleted",0);
                $result=$this->db->get("plc2.notifikasi_d")->result_array();
                $toarrayNIP=array();
                $ccarrayNIP=array(); 
                $toarrayEmail=array();
                $ccarrayEmail=array();
                $bccarrayNIP=explode(",",$hnotif["vBCC"]);
                $bccarrayEmail=array();
                foreach ($result as $kr => $vvr) {
                    $this->db->where('cNip',$vvr["vNip"]);
                    $rowEmployee=$this->db->get("hrd.employee")->row_array();
                if($vvr['iTipe']==1){
                    $toarrayNIP[]=$vvr["vNip"];
                    $toarrayEmail[]=$rowEmployee["vEmail"];
                }else{
                    $ccarrayNIP[]=$vvr["vNip"];
                    $ccarrayEmail[]=$rowEmployee["vEmail"];
                }
                }
                
                // Email
                /*Send Mail*/

                $this->_ci->load->helper('email');
                $this->_ci->load->library('email');

                /*Kebutuhan Email*/
                
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = '10.1.48.4';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['wordwrap'] = FALSE;
                $config['mailtype'] = 'html';
                $config['charset'] = 'utf-8';
                $config['crlf'] = "\r\n";
                $config['newline'] = "\r\n";
                
                $from = "postmaster@novellpharm.com";
                // $to='supri@novellpharm.com';
                // $cc = "mansur@novellpharm.com";
                // $bcc = "eka.yuni@novellpharm.com"; //$cc;

                $toemail=implode(";",$toarrayEmail);
                $ccemail=implode(";",$ccarrayEmail);

                foreach ($bccarrayEmail as $kbcc => $vbcc) {
                    $this->db->where('cNip',$vbcc);
                    $bccarrayEmail=$this->db->get("hrd.employee")->row_array();
                }

                $bccemail=implode(";",$bccarrayEmail);

                $content = $html;
                
                
                $this->_ci->email->initialize($config);
                $this->_ci->email->from($from, $hnotif["vCaptionMail"]);
                $this->_ci->email->to($toemail);
                $this->_ci->email->cc($ccemail);
                $this->_ci->email->bcc($bccemail);
                $this->_ci->email->subject($hnotif["vSubject"]);
                $this->_ci->email->message($content);

                /*Attch File*/
                $sql="SELECT gr.*,ma.filepath from plc2.group_file_upload gr
                join plc2.sys_masterdok ma on ma.iM_modul_fileds=gr.iM_modul_fileds
                where ma.ldeleted=0 and gr.iDeleted=0 and ma.filename='vfileregistrasiApplet'
                and gr.idHeader_File=".$iupb_id;
                $que=$this->db->query($sql);
                if($que->num_rows()>0){
                    $html.="<br /><br /><p>Attch:</p>";
                    $i=1;
                    foreach ($que->result_array() as $kf => $vfile) {
                        $path=$vfile["filepath"];
                        if($path != '') {
                            if (file_exists('./'.$path.'/'.$iupb_id.'/'.$vfile["vFilename_generate"])) {
                                
                                $this->_ci->email->attach('./'.$path.'/'.$iupb_id.'/'.$vfile["vFilename_generate"]); 
                                
                                $link = base_url().'processor/'.$this->urlpath.'?action=download&id='.$iupb_id.'&file='.$vfile["vFilename_generate"].'&path=vfileregistrasiApplet';
                                $html .= '<p>'.$i.'. <a class="ui-button-text" href="javascript:;" onclick="window.location=\''.$link.'\'">'.$vfile["vFilename"].'</a></p>';
                                $i++;
                            }
                        }
                    }
                }
                
                $this->_ci->email->send();

                $tonip=implode(";",$toarrayNIP);
                $ccnip=implode(";",$ccarrayNIP);
                $subject=$hnotif["vSubject"];
                $content=$html;
                $this->sess_message->send_message_erp($this->uri->segment_array(),$tonip, $ccnip, $subject, $content);
            }

        }

        $data=array();
        foreach ($get as $kget => $vget) {
            if($kget!="action"){
                $data[$kget]=$vget;
            }
        }
        /* Insert Log Approve */
        $tanggal=date('Y-m-d H:i:s');
        $dinsert=array();
        $dinsert['ijenis']=2;
        $dinsert['iupb_id']=$pk;
        $dinsert['dtanggal']=$tanggal;
        $dinsert['cInsert']=$cNip;
        $dinsert['dInsert']=$tanggal;
        $this->db->insert('plc2.tanggal_history_prareg_reg',$dinsert);
        

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
    
    function hilangap1(){
    	$id = $this->input->post('id_file'); 
    	$iupb_id = $this->input->post('iupb_id'); 
    	$sqlUp = "UPDATE plc2.`appletfile1` h SET h.`idoneAdd` = 1 WHERE h.`iappletfile1` =".$id; 
    	$this->db->query($sqlUp);  

    	//Sent Mail

    	$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik, u.isentmail_applet,
		                u.iteambusdev_id AS bd,u.iteampd_id AS pd,u.iteamqa_id AS qa,u.iteamqc_id AS qc, u.`iteamad_id` as ad
		                from plc2.plc2_upb u where u.iupb_id='".$iupb_id."'";
    	$rupb = $this->db_plc0->query($qupb)->row_array();  
    	$subject = 'APPLET ('.$rupb['vupb_nomor'].' -  '.$rupb['vupb_nama'].')';
		$sqlEm = "SELECT DISTINCT(h.`vTeamPD`) as vTeam FROM plc2.`appletfile2` h JOIN 
					plc2.`appletfile1` h1 ON h.`iappletfile1` = h1.`iappletfile1`
					WHERE h.`ldelete` = 0 AND h1.`ldelete` = 0 AND h1.iMail=0 AND h1.`idoneAdd` = 1 AND h1.`iappletfile1` = ".$id; 
		$dta = $this->db->query($sqlEm)->result_array();
		$sqUp = "UPDATE plc2.`appletfile1` p SET p.`iMail` = 1 WHERE 
			p.`iMail`=0 AND  p.`idoneAdd` = 1  AND p.`iappletfile1` = ".$id; 
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
				$sql = "SELECT p.`vnip` FROM plc2.`plc2_upb_team` p WHERE p.`ldeleted` = 0 AND p.`iStatus` = 1 
					AND p.`vtipe` ='".$v['vTeam']."'";
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
                Diberitahukan kepada ".$v['vTeam']." Manager untuk melakukan Upload file pada proses APPLET ( Aplikasi PLC) <br><br>
                Link Aplikasi: http://www.npl-net.com/erp/<br><br>
                Terimakasih.<br><br>
                ";
            //$this->lib_utilitas->send_email($to, $cc, $subject, $content);

             /* Send Email */
             $this->db->where('iupb_id',$iupb_id);
             $rowUPB=$this->db->get('plc2.plc2_upb')->row_array();

             $iteampd_id=$rowUPB['iteampd_id']>0?$rowUPB['iteampd_id']:"0";
             $iteamqa_id=$rowUPB['iteamqa_id']>0?$rowUPB['iteamqa_id']:"0";
             $iteambusdev_id=$rowUPB['iteambusdev_id']>0?$rowUPB['iteambusdev_id']:"0";
             /* Get CC */
            $team="BYTEAM";
			if($v['vTeam']=="BD"){
				$team=$iteambusdev_id;
			}
			elseif($v['vTeam']=="PD"){
				$team=$iteampd_id;
			}
			elseif($v['vTeam']=="QA"){
				$team=$iteampd_id;
            }
            
            $teamM=array();
            if($team!="BYTEAM"){
                $sql="select * from plc2.plc2_upb_team where iteam_id IN (".$team.") AND ldeleted=0";
                $qqqq=$this->db->query($sql)->result_array();
                if($this->db->query($sql)->num_rows()>0){
                    foreach ($qqqq as $kq => $vq) {
                        $teamM[]=$vq["vnip"];
                    }
                }else{
                    $sql2="select * from plc2.plc2_upb_team_item where iteam_id IN (".$team.") AND ldeleted=0";
                    $qqqq2=$this->db->query($sql2)->result_array();
                    $teamT=array();
                    foreach ($qqqq2 as $kq => $vq) {
                        $teamM[]=$vq["vnip"];
                    }
                }
            }else{
                $sql="select * from plc2.plc2_upb_team where vtipe IN ('".$v['vTeam']."') AND ldeleted=0";
                $qqqq=$this->db->query($sql)->result_array();
                if($this->db->query($sql)->num_rows()>0){
                    foreach ($qqqq as $kq => $vq) {
                        $teamM[]=$vq["vnip"];
                    }
                }else{
                    $sql2="select * from plc2.plc2_upb_team_item 
                        join plc2.plc2_upb_team on plc2_upb_team.iteam_id=plc2_upb_team_item.iteam_id  
                        where plc2_upb_team.vtipe IN ('".$v['vTeam']."') AND plc2_upb_team.ldeleted=0 and plc2_upb_team.ldeleted=0";
                    $qqqq2=$this->db->query($sql2)->result_array();
                    $teamT=array();
                    foreach ($qqqq2 as $kq => $vq) {
                        $teamM[]=$vq["vnip"];
                    }
                }
            }
            $to=implode(";",$teamM);
            $cc=$this->user->gNIP;

            $cData['file']=array();
             $cData['rowUPB']=$rowUPB;
             $cData['module']="Registrasi (TD & APPLET)";
             $cData['headerCaption']=" Diberitahukan kepada ".$v['vTeam']." Manager untuk melakukan Upload file pada proses ".$cData['module']." ( Aplikasi PLC) dengan rincian:";
             $content = $this->load->view('partial/mail_details_upb_prareg_reg',$cData,TRUE);
             $path = '';
             $subject = "Registasi - Tambahan Data[".$rowUPB['vupb_nomor']."]";
             $this->sess_message->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
		}


    	/* $qr="select * from plc2.applet_dokumen where iupb_id='".$iupb_id."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');
		$data['iupb_id'] = $iupb_id;
		$qp="select distinct(vtipe) from plc2.plc2_upb_team where ldeleted=0 and vtipe!=''";
		$data['rpic'] = $this->db_plc0->query($qp)->result_array(); 
		$qp="SELECT * FROM plc2.`appletfile1` h WHERE h.`ldelete` = 0 AND h.`iupb_id` = '".$iupb_id."' "; 
		$data['applet1'] = $this->db_plc0->query($qp)->result_array();
		echo $this->load->view('applet_file',$data,TRUE);  */
    }

    function donefileap(){
    	$id = $this->input->post('id_file'); 
    	$id2 = $this->input->post('id_file2'); 
    	$sqlUp = "UPDATE plc2.`appletfile3` h SET h.`iDone` = 1 WHERE h.`iappletfile3` = ".$id;
    	$this->db->query($sqlUp); 

    	$sql = "SELECT * FROM plc2.`appletfile3` h WHERE h.`ldelete` = 0 AND h.`iDone` = 0 AND h.`iappletfile2` = '".$id2."'";
		$ck = $this->db->query($sql)->num_rows();
		if($ck>0){}else{
			$sqlUp = "UPDATE plc2.`appletfile2` h SET h.`iDoneAll` = 1 WHERE h.`iappletfile2` = ".$id2; 
    		$this->db->query($sqlUp); 
		}

		$qupb="SELECT h.`vfilename`, h2.`iupb_id`, p.`vupb_nomor`, p.`vupb_nama`, p.`iteambusdev_id`, h1.`vTeamPD` FROM plc2.`appletfile3` h 
			JOIN plc2.`appletfile2` h1 ON h.`iappletfile2` = h1.`iappletfile2`
			JOIN plc2.`appletfile1` h2 ON h1.`iappletfile1` = h2.`iappletfile1`
			JOIN plc2.`plc2_upb` p ON p.`iupb_id` = h2.`iupb_id`
			WHERE h.`ldelete` = 0 AND h1.`ldelete`=0 AND h2.`ldelete`=0
			AND h.`iappletfile3` = '".$id."' AND h1.`iappletfile2` = '".$id2."' LIMIT 1"; 
		$mdt = $this->db_plc0->query($qupb)->row_array(); 
		if(!empty($mdt['vupb_nomor'])){
			$subject ="APPLET Cek File (".$mdt['vupb_nomor']." - ".$mdt['vupb_nama'].")";
			$to = $this->lib_utilitas->get_email_leader( $mdt['iteambusdev_id'] ); 
			if($to==""){
				$to = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
			}
			$cc = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
			$content="
				Dengan Hormat,<br>
	            Diberitahukan kepada Busdev Manager untuk melakukan Pengecekan file dari ".$mdt['vTeamPD']." Manager pada proses APPLET ( Aplikasi PLC) <br>
	            File : ".$mdt['vfilename']."<br><br>
	            Link Aplikasi: http://www.npl-net.com/erp/<br><br>
	            Terimakasih.<br><br>
	            ";
            //$this->lib_utilitas->send_email($to, $cc, $subject, $content);
            $file=array();
            $this->SendEmailERP($mdt['iupb_id']," Diberitahukan kepada Busdev Manager untuk melakukan Pengecekan file dari ".$mdt['vTeamPD']." Manager pada proses ( Aplikasi PLC) dengan rincian",$file,"BD");
            
	    }
		

    	echo 'Success';
    }
    function donefileapall(){
    	$id = $this->input->post('id_file'); 

    	$qupb="SELECT h.`vfilename`, h2.`iupb_id`, p.`vupb_nomor`, p.`vupb_nama`, p.`iteambusdev_id`, h1.`vTeamPD` FROM plc2.`appletfile3` h 
			JOIN plc2.`appletfile2` h1 ON h.`iappletfile2` = h1.`iappletfile2`
			JOIN plc2.`appletfile1` h2 ON h1.`iappletfile1` = h2.`iappletfile1`
			JOIN plc2.`plc2_upb` p ON p.`iupb_id` = h2.`iupb_id`
			WHERE h.`ldelete` = 0 AND h1.`ldelete`=0 AND h2.`ldelete`=0 AND h.iDone=0
			AND h1.`iappletfile2` = '".$id."'"; 
		$mdt = $this->db_plc0->query($qupb.' LIMIT 1')->row_array(); 
		if(!empty($mdt['vupb_nomor'])){
			$subject ="APPLET Cek File (".$mdt['vupb_nomor']." - ".$mdt['vupb_nama'].")";
			$to = $this->lib_utilitas->get_email_leader( $mdt['iteambusdev_id'] ); 
			if($to==""){
				$to = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
			}
			$cc = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );
			$content="
				Dengan Hormat,<br>
	            Diberitahukan kepada Busdev Manager untuk melakukan Pengecekan file dari ".$mdt['vTeamPD']." Manager pada proses APPLET ( Aplikasi PLC) <br><br>";
	        $mdt2 = $this->db_plc0->query($qupb)->result_array(); 
	        $i=1;
	        foreach ($mdt2 as $v) {
	        	 $content.="<i>".$i.",  ".$v['vfilename']."</i><br>";
	        	 $i++;
	        }
	        $content.="<br>Link Aplikasi: http://www.npl-net.com/erp/<br><br>
	            Terimakasih.<br><br>
	            ";
            //$this->lib_utilitas->send_email($to, $cc, $subject, $content);
            $file=array();
            $this->SendEmailERP($mdt['iupb_id']," Diberitahukan kepada Busdev Manager untuk melakukan pengecekan file dari ".$mdt['vTeamPD']." Manager pada proses Registrasi ( Aplikasi PLC) dengan rincian",$file,"BD");
            
	    }


    	$sqlUp = "UPDATE plc2.`appletfile3` h SET h.`iDone` = 1 WHERE h.`iappletfile2` = ".$id;
    	$this->db->query($sqlUp); 
    	$sqlUp = "UPDATE plc2.`appletfile2` h SET h.`iDoneAll` = 1 WHERE h.`iappletfile2` = ".$id; 
    	$this->db->query($sqlUp);  
    	echo 'Success';
    }
    
    function donefileaprevisi(){
    	$id = $this->input->post('id_file');
    	$irevisi = $this->input->post('revisi'); 
    	$to='';
    	if($irevisi==1){
    		$sqlUp = "UPDATE plc2.`appletfile3` h SET h.`iDone` = 0 , h.`irevisi` = '".$irevisi."' WHERE h.`iappletfile3` = ".$id;

    		$qupb="SELECT h.`vfilename`, h2.`iupb_id`, p.`vupb_nomor`, p.`vupb_nama`, p.`iteambusdev_id`,p.`iteamad_id` as ad,
    			p.iteambusdev_id AS bd,p.iteampd_id AS pd,p.iteamqa_id AS qa,p.iteamqc_id AS qc, 
    			h1.`vTeamPD` AS vTeam FROM plc2.`appletfile3` h 
				JOIN plc2.`appletfile2` h1 ON h.`iappletfile2` = h1.`iappletfile2`
				JOIN plc2.`appletfile1` h2 ON h1.`iappletfile1` = h2.`iappletfile1`
				JOIN plc2.`plc2_upb` p ON p.`iupb_id` = h2.`iupb_id`
				WHERE h.`ldelete` = 0 AND h1.`ldelete`=0 AND h2.`ldelete`=0
				AND h.`iappletfile3` = '".$id."' LIMIT 1"; 
			$mdt = $this->db_plc0->query($qupb)->row_array();  
			if(!empty($mdt['vupb_nomor'])){
				$subject ="APPLET Revisi File (".$mdt['vupb_nomor']." - ".$mdt['vupb_nama'].")"; 
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
					$sql = "SELECT p.`vnip` FROM plc2.`plc2_upb_team` p WHERE p.`ldeleted` = 0 AND p.`iStatus` = 1 
						AND p.`vtipe` ='".$mdt['vTeam']."'";
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
		            Diberitahukan kepada ".$mdt['vTeam']." Manager untuk melakukan Revisi file <b><i> ".$mdt['vfilename']."</i></b>   pada proses APPLET ( Aplikasi PLC) <br> <br>
		            Link Aplikasi: http://www.npl-net.com/erp/<br><br>
		            Terimakasih.<br><br>
		            ";
                //$this->lib_utilitas->send_email($to, $cc, $subject, $content);
                $file=array();
                $this->SendEmailERP($mdt['iupb_id'],"Diberitahukan kepada ".$mdt['vTeam']." Manager untuk melakukan Revisi file <b><i> ".$mdt['vfilename']." pada proses Registrasi ( Aplikasi PLC) dengan rincian",$file,"BD");
                
			}
			

    	}else{
    		$sqlUp = "UPDATE plc2.`appletfile3` h SET h.`irevisi` = '".$irevisi."' WHERE h.`iappletfile3` = ".$id;
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


    function removeCekDokRegistrasi(){
        $post = $this->input->post();
        $get = $this->input->get();
        $cNip= $this->user->gNIP;
        $vName= $this->user->gName;
        $pk = $post["iupb_id"];
        $vRemark="";
        $modul_id = $post['modul_id'];
        $iM_modul_activity = $post['iM_modul_activity'];

        $iprareg_ulang_reg=$post['iprareg_ulang_reg'];
        $ireg_ulang=$post['ireg_ulang'];
        $imutu_reg=$post['imutu_reg'];
        $ibutuh_dok_reg=$post['ibutuh_dok_reg'];
        $imutu_prareg=$post['imutu_prareg'];
        $ibutuh_dok_prareg=$post['ibutuh_dok_prareg'];

        $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();
        /* Delete Semua Log */
        $this->db->where('iKey_id',$pk);
        $this->db->where('idprivi_modules',$modul_id);
        $ireq=isset($post['iPic_Registrasi_req_doc'])?$post['iPic_Registrasi_req_doc']:'0';
        $this->db->update('plc3.m_modul_log_activity',array('lDeleted'=>1));

        /* Clear Di Cek Dok Registrasi */
        $update = array('iappbusdev_registrasi'=>0
                        ,'iprareg_ulang_reg'=>NULL
                        ,'ireg_ulang'=>NULL
                        ,'imutu_reg'=>NULL
                        ,'ibutuh_dok_reg'=>NULL
                        ,'imutu_prareg'=>NULL
                        ,'ibutuh_dok_prareg'=>NULL
                        ,'iconfirm_registrasi_qa'=>0
                        ,'iconfirm_registrasi'=>0
                        ,'tRegistrasi_req_doc'=>$post["tRegistrasi_req_doc"]
                        ,'iPic_Registrasi_req_doc'=>$post["iPic_Registrasi_req_doc"]
                    );
      
                if($ireq==0){
                    $update['iconfirm_registrasi_pd']=0;
                }

            $this->db->where("iupb_id", $pk);
            $this->db->update("plc2.plc2_upb", $update);
            
            /* Open All Done File di Registrasi */
            $CODE='PL00029';
            $sql='select * from plc3.m_modul where lDeleted=0 AND vKode_modul="'.$CODE.'"';
            $getprivi=$this->db->query($sql)->row_array();
            $idprivi=isset($getprivi['idprivi_modules'])?$getprivi['idprivi_modules']:0;

            $filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
            $rowtb=$this->v3_m_reg->getDetailFiles($filter)->result_array();
            foreach ($rowtb as $krow => $vrow) {
                $ipk=$this->v3_m_reg->getAnotherUPB($vrow['fieldheader'],$pk);
                $iM_modul_fileds=$vrow['iM_modul_fileds'];
                $this->db->where("iM_modul_fileds",$iM_modul_fileds)
                        ->where('idHeader_File',$ipk)
                        ->where('iDeleted',0);
                $this->db->update('plc2.group_file_upload',array('iDone'=>0));
            }

            /* Hapus Activity Cek Dokumen Registrasi */
            $this->db->where('iKey_id',$pk)
                        ->where('idprivi_modules',$idprivi);
            if($ireq==1){
                $this->db->where('vRemark =!',"Approval PD");
            }
            $this->db->update('plc3.m_modul_log_activity',array('lDeleted'=>1));
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

        $iprareg_ulang_reg=$post['iprareg_ulang_reg'];
        $ireg_ulang=$post['ireg_ulang'];
        $imutu_reg=$post['imutu_reg'];
        $ibutuh_dok_reg=$post['ibutuh_dok_reg'];
        $imutu_prareg=$post['imutu_prareg'];
        $ibutuh_dok_prareg=$post['ibutuh_dok_prareg'];

        $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();
        /* Delete Semua Log */
        $ireq=isset($post['iPic_Registrasi_req_doc'])?$post['iPic_Registrasi_req_doc']:'0';

        /* Clear Di Cek Dok Registrasi */
        $update = array('iappbusdev_registrasi'=>0
                        ,'iprareg_ulang_reg'=>NULL
                        ,'ireg_ulang'=>NULL
                        ,'imutu_reg'=>NULL
                        ,'ibutuh_dok_reg'=>NULL
                        ,'imutu_prareg'=>NULL
                        ,'ibutuh_dok_prareg'=>NULL
                        ,'iconfirm_registrasi_qa'=>0
                        ,'iconfirm_registrasi'=>0
                        ,'tRegistrasi_req_doc'=>$post["tRegistrasi_req_doc"]
                        ,'iPic_Registrasi_req_doc'=>$post["iPic_Registrasi_req_doc"]
                    );
      
                if($ireq==0){
                    $update['iconfirm_registrasi_pd']=0;
                }

            $this->db->where("iupb_id", $pk);
            $this->db->update("plc2.plc2_upb", $update);
            
            /* Open All Done File di Registrasi */
            $CODE='PL00047';
            $sql='select * from plc3.m_modul where lDeleted=0 AND vKode_modul="'.$CODE.'"';
            $getprivi=$this->db->query($sql)->row_array();
            $idprivi=isset($getprivi['idprivi_modules'])?$getprivi['idprivi_modules']:0;

            $filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
            $rowtb=$this->v3_m_reg->getDetailFiles($filter)->result_array();
            foreach ($rowtb as $krow => $vrow) {
                $ipk=$this->v3_m_reg->getAnotherUPB($vrow['fieldheader'],$pk);
                $iM_modul_fileds=$vrow['iM_modul_fileds'];
                $this->db->where("iM_modul_fileds",$iM_modul_fileds)
                        ->where('idHeader_File',$ipk)
                        ->where('iDeleted',0);
                $this->db->update('plc2.group_file_upload',array('iDone'=>0));
            }
            

            /* Hapus Activity Cek Dokumen Registrasi */
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
        $cData['module']="Registrasi - TD [".$rowUPB['vupb_nomor']."]";

        $cData['rowUPB']=$rowUPB;
        $cData['headerCaption']=$caption;
        $cData['file']=$file;
        $content = $this->load->view('partial/mail_details_upb_prareg_reg',$cData,TRUE);
        $path = '';
        $subject = "Registrasi - Butuh Dokumen [".$rowUPB['vupb_nomor']."]";
        $this->sess_message->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
    }

}