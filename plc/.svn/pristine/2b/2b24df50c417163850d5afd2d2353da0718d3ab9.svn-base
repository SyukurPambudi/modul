<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class applet extends MX_Controller {
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

		$grid->setTitle('Applet');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('applet');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik','tappbusdev_registrasi','iappbd_applet');
		$grid->setSortBy('vupb_nomor');
		$grid->setSortOrder('DESC');
		$grid->setLabel('vupb_nomor', 'UPB Nomor');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('tappbusdev_registrasi', 'Tgl Registrasi');
		$grid->setLabel('iappbd_applet', 'App Busdev Manager');
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setWidth('vupb_nomor', '120');
		$grid->setAlign('vupb_nama', 'Left');
		$grid->setWidth('vupb_nama', '200');
		$grid->setAlign('tappbusdev_registrasi', 'Left');
		$grid->setWidth('tappbusdev_registrasi', '200');
		$grid->setAlign('iappbd_applet', 'Left');
		$grid->setWidth('iappbd_applet', '150');
		$grid->addFields('iupb_id','vupb_nama','vgenerik','tappbusdev_registrasi','ttarget_hpr','itambahan_applet','vfile','dinput_applet','no_fero_applet','iappbd_applet');
		$grid->setLabel('itambahan_applet', 'Tambahan Data');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('ttarget_hpr', 'Tgl Input HPR');
		$grid->setLabel('vfile', 'Tambahan Data');
		$grid->setLabel('dinput_applet','Tgl Input Applet');
		$grid->setLabel('no_fero_applet', 'No Fero');
		$grid->setFormUpload(TRUE);
		$grid->setRequired('iupb_id','itambahan_applet','dinput_applet');
		
		$grid->setJoinTable('plc2.plc2_upb_formula', 'plc2_upb_formula.iupb_id=plc2.plc2_upb.iupb_id','inner');
		$grid->setJoinTable('plc2.plc2_upb_buat_mbr', 'plc2_upb_buat_mbr.ifor_id=plc2_upb_formula.ifor_id','inner');
		$grid->setRelation('plc2.plc2_upb.iteambusdev_id','plc2.plc2_upb_team','iteam_id','vteam','team_bd','inner',array('vtipe'=>'BD', 'ldeleted'=>0),array('vteam'=>'asc'));

		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('BD', $manager)){
				$type='BD';
				$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('BD', $team)){
				$type='BD';
				$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		$grid->setSearch('vupb_nomor','vupb_nama');
		$grid->setQuery('plc2_upb.ldeleted',0);
		$grid->setQuery('plc2_upb.iappdireksi', 2);
		$grid->setQuery('plc2_upb.iappbusdev_registrasi',2);// Sudah Melewati Registrasi
		$grid->setQuery('plc2_upb.iconfirm_registrasi',2);//Sudah Melewati Cek Dokumen Registrasi
		$grid->setQuery('plc2_upb.iappbd_hpr',2); //Sudah Melewati HPR
		$grid->setQuery('plc2_upb.iupb_id in (select fo.iupb_id from plc2.plc2_upb_stabilita_pilot st
						inner join plc2.plc2_upb_formula fo on st.ifor_id=fo.ifor_id
						where st.iapppd=2 and fo.ldeleted=0 and st.ldeleted=0)',NULL); // Yang Sudah Stabilita PIlot
		$grid->setQuery('plc2_upb.iupb_id in (select la.iupb_id from plc2.coa_pilot_lab la
						where la.lDeleted=0 and la.iappqa=2)',NULL); //Sudah Melewati COA Pilot dan Lab
		$grid->setQuery('plc2_upb.iupb_id in (select up.iupb_id from plc2.plc2_upb up
						inner join plc2.study_literatur_pd st on up.iupb_id=st.iupb_id
						where (case when st.ijenis_sediaan=0
							then up.iupb_id in (select fo.iupb_id from plc2.plc2_upb_formula fo inner join plc2.mikro_fg mi on mi.ifor_id=fo.ifor_id where mi.iappqa_soi=2 and mi.lDeleted=0 and fo.ldeleted=0)
							else
								up.iupb_id in (select la.iupb_id from plc2.coa_pilot_lab la where la.lDeleted=0 and la.iappqa=2)
							end))',NULL);
		
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
			case 'hapustableap':
				$this->hapustableap();
				break;
			case 'createproses':
				echo $grid->saved_form();
				break;
			case 'download':
				$this->download($this->input->get('file'));
				break;
			case 'delete':
				echo $grid->delete_row();
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
			case 'donefileaprevisi';
				$this->donefileaprevisi();
				break;	
			case 'download2':
				$this->download2($this->input->get('file'));
				break;
			case 'download1':
				$this->download1($this->input->get('file'));
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
                $iupbid=$post['applet_iupb_id'];
                $path = realpath("files/plc/appletnew/");
                if(!file_exists($path."/".$iupbid)){
                    if (!mkdir($path."/".$iupbid, 0777, true)) { //id review
                        die('Failed upload, try again!');
                    }
                } 

                if($isUpload) {  
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
                                        $this->dbset->query($sql); 
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
					$rowIn2 = $this->dbset->query($sqlIn2)->result_array();  
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
	                                        $this->dbset->query($sql); 
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
					$rowIn2 = $this->dbset->query($sqlIn2)->result_array();  
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
	
	                                        $this->dbset->query($sql); 
	                                        $i++;   
	                                    }
	                                    else{
	                                        echo "Upload ke folder gagal";  
	                                    }

	                            }
	                        } 
	                    }   
					}
					//

                    $r['message']='Data Berhasil di Simpan';
                    $r['status'] = TRUE;
                    $r['last_id'] = $this->input->get('lastId');                
                    echo json_encode($r);
                    exit();
                }  else { 

                  
					$sqlIn = "SELECT h.`iappletfile1`, h.idoneAdd FROM plc2.`appletfile1` h WHERE h.`ldelete` = 0 AND h.`iupb_id` = '".$iupbid."'";
					$rowIn = $this->dbset->query($sqlIn)->result_array();  
					$i=0;
					 
					foreach ($rowIn as $r) {
						if($r['idoneAdd']==0){
							if($i==0){
								$sqlCk = "SELECT * FROM plc2.`appletfile2` h WHERE h.`ldelete` = 0 AND h.`iappletfile1` =".$r['iappletfile1'];
								$cekNum = $this->dbset->query($sqlCk)->num_rows();
								if($cekNum>0){
									//Delete yang Lama
									$sqlDl = "UPDATE plc2.`appletfile2` h SET h.`ldelete` = 1 AND h.`iappletfile1` = ".$r['iappletfile1'];
									$this->dbset->query($sqlDl); 
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
			                            $this->dbset->query($sql); 
			                        }
		                            $ii++;
								} 
							} 
 

						}else{
							$sqHP1 = "SELECT h.`iappletfile2` FROM plc2.`appletfile2` h WHERE h.`ldelete` = 0 AND h.`iappletfile1` =".$r['iappletfile1'];
							$quHP1 = $this->dbset->query($sqHP1)->result_array();
							foreach ($quHP1 as $r2) {
								foreach($_POST as $key=>$value) {  
									if ($key == 'DeadlineAD_'.$r2['iappletfile2']) {
										foreach($value as $y=>$u) {
											$sqlDl = "UPDATE plc2.`appletfile2` h SET h.`dcAndev` = '".$u."' WHERE h.`iappletfile2` = ".$r2['iappletfile2'];
											$this->dbset->query($sqlDl);   
										}
									} 
								}
							}
								
						}

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
				$iupb_id = $post['iupb_id'];
				$tApprove=date('Y-m-d H:i:s');
				$sql="update plc2.plc2_upb set cappbd_applet='".$cNip."', dappbd_applet='".$tApprove."', iappbd_applet=2 where iupb_id='".$post['iupb_id']."'";
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
		        $subject="PLC-Applet: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada approval oleh BD Manager pada proses Applet (aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
			default:
				$grid->render_grid();
				break;
		}
    }

    /*Maniupulasi Gird Start*/

	/*Maniupulasi Gird end*/
	 function hapustableap(){
		$tipe = $this->input->post('tipe'); 
		$id = $this->input->post('id_file');  
		$sql = '';
		if($tipe==1){
			//Hapus HPR FILE 1
			$sql = "UPDATE plc2.`appletfile1` h SET h.`ldelete` = 1 WHERE h.`iappletfile1` = '".$id."'";
		}else if($tipe==2){
			//Hapus HPR FilE 2
			$sql = "UPDATE plc2.`appletfile2` h SET h.`ldelete` = 1 WHERE h.`iappletfile2` = '".$id."'";
		}
		else{
			$sql = "UPDATE plc2.`appletfile3` h SET h.`ldelete` = 1 WHERE h.`iappletfile3` = '".$id."'";
			//Hapus HPR File 3
		}
		$this->dbset->query($sql);
		echo 'Success';
	}
	 function hilangap1(){
    	$id = $this->input->post('id_file'); 
    	$iupb_id = $this->input->post('iupb_id'); 
    	$sqlUp = "UPDATE plc2.`appletfile1` h SET h.`idoneAdd` = 1 WHERE h.`iappletfile1` =".$id; 
    	$this->dbset->query($sqlUp);  

    	//Sent Mail

    	$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik, u.isentmail_applet,
		                u.iteambusdev_id AS bd,u.iteampd_id AS pd,u.iteamqa_id AS qa,u.iteamqc_id AS qc, u.`iteamad_id` as ad
		                from plc2.plc2_upb u where u.iupb_id='".$iupb_id."'";
    	$rupb = $this->db_plc0->query($qupb)->row_array();  
    	$subject = 'APPLET ('.$rupb['vupb_nomor'].' -  '.$rupb['vupb_nama'].')';
		$sqlEm = "SELECT DISTINCT(h.`vTeamPD`) as vTeam FROM plc2.`appletfile2` h JOIN 
					plc2.`appletfile1` h1 ON h.`iappletfile1` = h1.`iappletfile1`
					WHERE h.`ldelete` = 0 AND h1.`ldelete` = 0 AND h1.iMail=0 AND h1.`idoneAdd` = 1 AND h1.`iappletfile1` = ".$id; 
		$dta = $this->dbset->query($sqlEm)->result_array();
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
				$dtMail = $this->dbset->query($sql)->result_array();
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
            $this->lib_utilitas->send_email($to, $cc, $subject, $content);
		}


    	$qr="select * from plc2.applet_dokumen where iupb_id='".$iupb_id."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');
		$data['iupb_id'] = $iupb_id;
		$qp="select distinct(vtipe) from plc2.plc2_upb_team where ldeleted=0 and vtipe!=''";
		$data['rpic'] = $this->db_plc0->query($qp)->result_array(); 
		$qp="SELECT * FROM plc2.`appletfile1` h WHERE h.`ldelete` = 0 AND h.`iupb_id` = '".$iupb_id."' "; 
		$data['applet1'] = $this->db_plc0->query($qp)->result_array();
		echo $this->load->view('applet_file',$data,TRUE); 
    }

    function donefileap(){
    	$id = $this->input->post('id_file'); 
    	$id2 = $this->input->post('id_file2'); 
    	$sqlUp = "UPDATE plc2.`appletfile3` h SET h.`iDone` = 1 WHERE h.`iappletfile3` = ".$id;
    	$this->dbset->query($sqlUp); 

    	$sql = "SELECT * FROM plc2.`appletfile3` h WHERE h.`ldelete` = 0 AND h.`iDone` = 0 AND h.`iappletfile2` = '".$id2."'";
		$ck = $this->dbset->query($sql)->num_rows();
		if($ck>0){}else{
			$sqlUp = "UPDATE plc2.`appletfile2` h SET h.`iDoneAll` = 1 WHERE h.`iappletfile2` = ".$id2; 
    		$this->dbset->query($sqlUp); 
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
	        $this->lib_utilitas->send_email($to, $cc, $subject, $content);
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
	        $this->lib_utilitas->send_email($to, $cc, $subject, $content);
	    }


    	$sqlUp = "UPDATE plc2.`appletfile3` h SET h.`iDone` = 1 WHERE h.`iappletfile2` = ".$id;
    	$this->dbset->query($sqlUp); 
    	$sqlUp = "UPDATE plc2.`appletfile2` h SET h.`iDoneAll` = 1 WHERE h.`iappletfile2` = ".$id; 
    	$this->dbset->query($sqlUp);  
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
					$dtMail = $this->dbset->query($sql)->result_array();
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
		        $this->lib_utilitas->send_email($to, $cc, $subject, $content);
			}
			

    	}else{
    		$sqlUp = "UPDATE plc2.`appletfile3` h SET h.`irevisi` = '".$irevisi."' WHERE h.`iappletfile3` = ".$id;
    	} 
    	$this->dbset->query($sqlUp); 
    	echo 'Success';
    }
	function listBox_applet_iappbd_applet($value) {
		if($value==0){$vstatus='Waiting for approval';}
		elseif($value==1){$vstatus='Rejected';}
		elseif($value==2){$vstatus='Approved';}
		return $vstatus;
	}

	function listBox_Action($row, $actions) {
		//print_r($row);
	    if($row->iappbd_applet<>0){
	    	unset($actions['edit']);
	    }
	    return $actions; 

		}
	/*manipulasi view object form start*/
 	function updateBox_applet_iupb_id($field, $id, $value, $rowData){
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

	function updateBox_applet_vupb_nama($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nama'];
		}else{
			$return='<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vupb_nama'].'" />';
		}
		return $return;
	}

	function updateBox_applet_vgenerik($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vgenerik'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vgenerik'].'" />';
		}
		return $return;
	}
	
	function updateBox_applet_tappbusdev_registrasi($field, $id, $value, $rowData) {
		if(($value==NULL)||($value=='')||($value=='0000-00-00') ){
			$val='';
		}else{
			$val=$value;
		}

		if($this->input->get('action')=='view'){
			$return	=$val;
		}else{
			$return = '<input name="'.$id.'" id="'.$id.'"   type="hidden" size="20" class="input_tgl " style="width:130px" value="'.$val.'" />';	
			$return = '<input name="'.$id.'_" id="'.$id.'_" disabled="TRUE" type="text" size="20" class="input_tgl " style="width:130px" value="'.$val.'" />';	
		}
		return $return;
	}
	function updateBox_applet_ttarget_hpr($field, $id, $value, $rowData) {
			if(($value==NULL)||($value=='')||($value=='0000-00-00') ){
				$val='';
			}else{
				$val=$value;
			}

			if($this->input->get('action')=='view'){
				$return	=$val;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'"   type="text" size="20" class="input_tgl datepicker" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		return $return;
	}
	function updateBox_applet_itambahan_applet($field, $id, $value, $rowData){
		/*$d=array(''=>'Pilih','0'=>'No','1'=>'Yes');
		if($this->input->get('action')=='view'){
			$return=$d[$value];
		}else{
			$return ='<select id='.$id.' name='.$id.' style="width:130px" class="combobox required">';
			foreach ($d as $k => $v) {
				$s=$value==$k ? 'selected':'';
				$return.='<option value='.$k.' '.$s.'>'.$v.'</option>';
			}
			$return .='</select>';
			$return .='<script>';
			$return	.='$("#'.$id.'").change(function(){
				var v = $(this).val();
				if(v=="1"){
					$("#applet_vfile").parent().parent().show();
				}else{
					$("#applet_vfile").parent().parent().hide();
				}
				});';
			$return .='</script>';
		}
		return $return;*/
		$d=array(''=>'Pilih','0'=>'No','1'=>'Yes');
		$r='';
		if($this->input->get('action')=='view'){
				$r	="disabled";
		}

		$sql = "SELECT * FROM plc2.`appletfile1` h WHERE h.`ldelete` = 0 AND h.`iupb_id` = ".$rowData['iupb_id'];
		$ck  = $this->dbset->query($sql)->num_rows();
		if($ck>0){
			$return ='<select id='.$id.' name='.$id.' style="width:130px" class="combobox required" disabled>';
			foreach ($d as $k => $v) {
				$s=$value==$k ? 'selected':'';
				$return.='<option value='.$k.' '.$s.'>'.$v.'</option>';
			}
			$return .='</select>';
			$return .='<script>';
			$return	.='$("#'.$id.'").change(function(){
				var v = $(this).val();
				if(v=="1"){
					$("#applet_vfile").parent().parent().show();
				}else{
					$("#applet_vfile").parent().parent().hide();
				}
				});';
			$return .='</script>';
			$return .= '<input name="'.$id.'" id="'.$id.'" type="hidden" size="20" class="d" style="width:130px" value="'.$value.'" />';
		} else{
			$return ='<select id='.$id.' name='.$id.' style="width:130px" class="combobox required" '.$r.'>';
			foreach ($d as $k => $v) {
				$s=$value==$k ? 'selected':'';
				$return.='<option value='.$k.' '.$s.'>'.$v.'</option>';
			}
			$return .='</select>';
			$return .='<script>';
			$return	.='$("#'.$id.'").change(function(){
				var v = $(this).val();
				if(v=="1"){
					$("#applet_vfile").parent().parent().show();
				}else{
					$("#applet_vfile").parent().parent().hide();
				}
				});';
			$return .='</script>';
		}
		
		return $return;
	}
	 function updateBox_applet_vfile($field, $id, $value, $rowData) {	
		$qr="select * from plc2.applet_dokumen where iupb_id='".$rowData['iupb_id']."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');
		$data['iupb_id'] = $rowData['iupb_id'];
		$data['iappbd_applet'] = $rowData['iappbd_applet'];
		$qp="select distinct(vtipe) from plc2.plc2_upb_team where ldeleted=0 and vtipe!=''";
		$data['rpic'] = $this->db_plc0->query($qp)->result_array();

		$qp="SELECT * FROM plc2.`appletfile1` h WHERE h.`ldelete` = 0 AND h.`iupb_id` = '".$rowData['iupb_id']."' ";
		$data['applet1'] = $this->db_plc0->query($qp)->result_array();

		$logged_nip =$this->user->gNIP;
        $iAm = $this->whoAmI($logged_nip);
        $data['iLvlemp'] = $iAm['iLvlemp'];

		$ret='<div id='.$id.'></div>';	
		$sa=$ret.$this->load->view('applet_file',$data,TRUE); 

		if($this->input->get('action')=='view'){
			$sa.="<script>";
			if($rowData['itambahan_applet']==1){
				$sa.='$("#applet_vfile").parent().parent().show();';
			}else{
				$sa.='$("#applet_vfile").parent().parent().hide();';
			}
			$sa.="</script>";
		}else{
			$sa.='<script>
				var c = $("#applet_itambahan_applet").val();
				if(c=="1"){
					$("#applet_vfile").parent().parent().show();
				}else{
					$("#applet_vfile").parent().parent().hide();
				}
				</script>';
		}
		return $sa;
	}
	function updateBox_applet_dinput_applet($field, $id, $value, $rowData) {
			$value=date('d-m-Y',strtotime($value));
			if(($value==NULL)||($value=='')||($value=='0000-00-00') || ($value=='01-01-1970')){
				$val='';
			}else{
				$val=date('d-m-Y',strtotime($value));
			}
			if($this->input->get('action')=='view'){
				$return	=$val;
			}else{
				if(($value==NULL)||($value=='')||($value=='0000-00-00') || ($value=='01-01-1970')){
					$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
					$return .=	'<script>
								$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
							</script>';
				}else{
					$val=date('d-m-Y',strtotime($value));
					$return = '<input name="'.$id.'" id="'.$id.'" type="hidden" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
					$return .=	'<input disabled name="'.$id.'_" id="'.$id.'_" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
				}
				/*$return = '<input name="'.$id.'" id="'.$id.'"type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
				$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';*/
			}
		return $return;
	}
	function updateBox_applet_iappbd_applet($field, $id, $value, $rowData) {
		//print_r($rowData);exit();
		if($rowData['iappbd_applet'] != 0){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cappbd_applet']))->row_array();
			if($rowData['iappbd_applet']==2){$st="Approved";}
			elseif($rowData['iappbd_applet']==1){$st="Rejected";} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['cappbd_applet'].' )'.' pada '.$rowData['dappbd_applet'];
		}
		else{
			$ret='Waiting for Approval';
		}
		return $ret;
	}
	function updateBox_applet_no_fero_applet($field, $id, $value, $rowData) {
		if($this->input->get('action')=='view'){
			$return=$rowData['no_fero_applet'];
		}else{
			$return='<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" value="'.$rowData['no_fero_applet'].'" />';
		}
		return $return;
	}
/*manipulasi view object form end*/

function after_update_processor($row, $post, $postData) {
	$iupb_id=$postData['iupb_id'];
    $sql="select * from plc2.applet_dokumen dok where dok.ldeleted=0 and icheck=0 and dok.iupb_id=".$iupb_id;
	$st=$this->dbset->query($sql);
	if($st->num_rows()>0){
		$dt=$st->result_array();
		$pic=array();
		$d=array();
		foreach ($dt as $k => $va) {
			$pic=explode(",", $va['vpic_td']);
			foreach ($pic as $key => $v) {
				$d=$this->cekteamPIC($v,$iupb_id);
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
		        $toEmail = $this->lib_utilitas->get_email_team( $d );
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
		        $subject="HPR-Tambahan Data: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada tambahan Data Dokumen pada Proses Applet  UPB ".$rupb['vupb_nomor']." :<br><br>
		                <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
		                        <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
		                                <tr>
		                                        <td><b>Tanggal Surat TD</b></td><td> : </td><td>".$va['dsrt_td']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Surat TD</b></td><td> : </td><td>".$va['vsrt_td']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Tgl Submit Dok</b></td><td> : </td><td>".$va['dsubmit_dok']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Info Pengiriman</b></td><td> : </td><td>".$va['vinfo']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Hasil TD</b></td><td> : </td><td>".$va['vhasil_td']."</td>
		                                </tr>
		                        </table>
		                </div>
		                <br/> 
		                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
		                Post Master";
		        $this->lib_utilitas->send_email($to, $cc, $subject, $content);
			}
		}
	}
	$s="update plc2.applet_dokumen set icheck=1 where iupb_id='".$iupb_id."'";
	$this->dbset->query($s);

}
public function cekteamPIC($type,$iupb_id){

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
	switch($type){
		case 'BD':
			return $bd;
			break;
		case 'PD':
			return $pd;
			break;
		case 'QA':
			return $qa;
			break;
		case 'QC':
			return $qc;
			break;
		case 'PR':
			return $pr;
			break;
		default:
			$dt='';
			$q="select * from plc2.plc2_upb_team te where vtipe='".$type."' and ldeleted=0";
			$nilai=$this->dbset->query($q)->result_array();
			foreach ($nilai as $n => $va) {
				$dt[]=$va['iteam_id'];
			}
			$dt=implode(",",$dt);
			return $dt;
			break;
	}
}

/*manipulasi proses object form start*/
	function manipulate_update_button($buttons, $rowData){
		unset($buttons['update']);
		$js=$this->load->view('applet_js');
		$cNip=$this->user->gNIP;
		$setuju = '<button onclick="javascript:setuju(\'applet\', \''.base_url().'processor/plc/applet?action=confirm&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$rowData['iupb_id'].', \''.$rowData['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_applet">Confirm</button>';
		$update = '<button onclick="javascript:update_btn_back(\'applet\', \''.base_url().'processor/plc/applet?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_applet">Update</button>';
		
				if($this->auth_localnon->is_manager()){ 

			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('BD', $manager)){ 
				$type='BD';
				if($rowData['iappbd_applet']==0){
					//Cek Done File untul BD
					$sql = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
					JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
					JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
					WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0 
					AND h3.`irevisi` = 2 AND h3.`iDone` = 1 AND h2.`iDoneAll` =  1 AND  h.`iupb_id` = '".$rowData['iupb_id']."'";
					$c1 = $this->dbset->query($sql)->num_rows();
					$sql2 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
						JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
						JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
						WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0  
						AND h.`iupb_id` = '".$rowData['iupb_id']."'";
					$c2 = $this->dbset->query($sql2)->num_rows();


					$sql3 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
						JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
						WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0  AND (h2.dcAndev<>'0000-00-00' AND h2.dcAndev IS NOT NULL)
						AND h2.`iDoneAll` =  1 
						AND h2.vTeamPD='AD' AND  h.`iupb_id` = '".$rowData['iupb_id']."'";
					$c11 = $this->dbset->query($sql3)->num_rows();
					$sql4 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
						JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
						WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 
						AND h2.vTeamPD='AD' AND h.`iupb_id` = '".$rowData['iupb_id']."'";
					$c22 = $this->dbset->query($sql4)->num_rows();


					$sqL5 = "SELECT  h.`iappletfile1` FROM plc2.`appletfile1` h   
						WHERE h.idoneAdd=1 AND h.`ldelete` = 0 AND  h.`iupb_id` = '".$rowData['iupb_id']."'";
					$c111 = $this->dbset->query($sqL5)->num_rows();
					$sqL6 = "SELECT  h.`iappletfile1` FROM plc2.`appletfile1` h   
						WHERE h.`ldelete` = 0 AND  h.`iupb_id` = '".$rowData['iupb_id']."'";
					$c222 = $this->dbset->query($sqL6)->num_rows();


					//Cek Don File untuk Manager Khusus Dia
					if($rowData['itambahan_applet']==1){
						if($c1==$c2 && $c11==$c22 && $c111==$c222){  
							if($c222>0){
								$buttons['update']=$update.$setuju.$js;  
							}else{
								$buttons['update']=$update.$js;
							}  
						}else{
							$buttons['update']=$update.$js;
						}  
					}else{
						$buttons['update']=$update.$setuju.$js;  
					}
				}else{}
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
				$c1 = $this->dbset->query($sql)->num_rows();
				$sql2 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
					JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
					JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
					WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0  
					AND h2.`vTeamPD` in(".$dtO.") AND h.`iupb_id` = '".$rowData['iupb_id']."'";
				$c2 = $this->dbset->query($sql2)->num_rows();


				$sql = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
					JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
					WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h2.`iDoneAll` =  1 AND 
					h2.`vTeamPD`in(".$dtO.") AND h.`iupb_id` = '".$rowData['iupb_id']."'";
				$c11 = $this->dbset->query($sql)->num_rows();
				$sql2 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
					JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
					WHERE h2.`ldelete`=0 AND h.`ldelete` = 0 
					AND h2.`vTeamPD` in(".$dtO.") AND h.`iupb_id` = '".$rowData['iupb_id']."'";
				$c22 = $this->dbset->query($sql2)->num_rows(); 
				//Cek Don File untuk Manager Khusus Dia
				if($c1==$c2 && $c11==$c22){  
					if(in_array('AD', $manager)){
						$sql3 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
							JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
							WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0  AND (h2.dcAndev<>'0000-00-00' AND h2.dcAndev IS NOT NULL)
							AND h2.vTeamPD='AD' AND h2.`iDoneAll` =  1 AND  h.`iupb_id` = '".$rowData['iupb_id']."'";
						$c11 = $this->dbset->query($sql3)->num_rows();
						$sql4 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
							JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
							WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h2.vTeamPD='AD' AND h.`ldelete` = 0 AND h.`iupb_id` = '".$rowData['iupb_id']."'";
						$c22 = $this->dbset->query($sql4)->num_rows();
						if($c11!=$c22){
							$buttons['update']=$update.$js;
						}
					}
				}else{ 
					$buttons['update']=$update.$js;
				}
				
			}
				 
			 
		}else{
			 
			$x=$this->auth_localnon->dept();
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
						$c1 = $this->dbset->query($sql)->num_rows();
						$sql2 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
							JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
							JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
							WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0  
							AND  h.`iupb_id` = '".$rowData['iupb_id']."'";
						$c2 = $this->dbset->query($sql2)->num_rows();
						//Cek Don File untuk Manager Khusus Dia
						if($c1!=$c2){ 
							$buttons['update']=$update.$js;
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
					$c1 = $this->dbset->query($sql)->num_rows();
					$sql2 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
						JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
						JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
						WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0  
						AND h2.`vTeamPD` in(".$dtO.") AND h.`iupb_id` = '".$rowData['iupb_id']."'";
					$c2 = $this->dbset->query($sql2)->num_rows();
					 //Cek Don File untuk Manager Khusus Dia

					$sql = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
						JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
						WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h2.`iDoneAll` =  1 AND h2.`vTeamPD` in(".$dtO.") AND h.`iupb_id` = '".$rowData['iupb_id']."'";
					$c11 = $this->dbset->query($sql)->num_rows();
					$sql2 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
						JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
						WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 
						AND h2.`vTeamPD` in(".$dtO.") AND h.`iupb_id` = '".$rowData['iupb_id']."'";
					$c22 = $this->dbset->query($sql2)->num_rows(); 
					//Cek Don File untuk Manager Khusus Dia
					if($c1==$c2 && $c11==$c22){ 
						if($dtO=="AD"){
							$sql3 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
								JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
								WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0  AND 
								(h2.dcAndev<>'0000-00-00' or h2.dcAndev IS NOT NULL)
								AND h2.vTeamPD='AD' AND h2.`iDoneAll` =  1 AND  h.`iupb_id` = '".$rowData['iupb_id']."'";
							$c11 = $this->dbset->query($sql3)->num_rows();
							$sql4 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
								JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
								WHERE h.idoneAdd=1 AND h2.vTeamPD='AD' AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h.`iupb_id` = '".$rowData['iupb_id']."'";
							$c22 = $this->dbset->query($sql4)->num_rows();
							if($c11!=$c22){
								$buttons['update']=$update.$js;
							}
						}
					}else{
						$buttons['update']=$update.$js;
					}
				} 
			}
			 

		}
		
		return $buttons;
	}
   
/*manipulasi proses object form end*/    
	function before_update_processor($row, $postData) {
		unset($postData['vupb_nama']);
		unset($postData['vgenerik']);
		unset($postData['iappbd_applet']);
		unset($postData['tsubmit_prareg']);
		unset($postData['ttarget_hpr']);
		unset($postData['iappbd_hpr']);
		unset($postData['tappbusdev_registrasi']);
		$postData['dinput_applet']=date("Y-m-d", strtotime($postData['dinput_applet']));
		$postData['applet_dinput_applet']=date("Y-m-d", strtotime($postData['applet_dinput_applet']));
		//print_r($postData);exit();
		return $postData;
	}
	function download1($filename) {
	    $this->load->helper('download');        
	    $name = $_GET['file'];
	    $id = $_GET['id'];
	    $path = file_get_contents('./files/plc/appletnew/'.$id.'/'.$name);  
	    force_download($name, $path);
	}
	function download2($filename) {
	    $this->load->helper('download');        
	    $name = $_GET['file'];
	    $id = $_GET['id'];
	    $id2 = $_GET['id2'];
	    $path = file_get_contents('./files/plc/appletnew/'.$id.'/detail/'.$id2.'/'.$name);  
	    force_download($name, $path);
	}
	function whoAmI($nip){
	    $sql = 'select b.vDescription as vdepartemen,a.*,b.*,c.iLvlemp 
	            from hrd.employee a 
	            join hrd.msdepartement b on b.iDeptID=a.iDepartementID
	            join hrd.position c on c.iPostId=a.iPostID
	            where a.cNip ="'.$nip.'"
	            ';
	    $data = $this->db_plc0->query($sql)->row_array();
	    return $data;
	}
/*function pendukung end*/    	
	public function output(){
		$this->index($this->input->get('action'));
	}

}
