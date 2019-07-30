<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class soi_mikro_fg extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->dbset = $this->load->database('plc0',false, true);
		$this->load->library('lib_flow');
		$this->load->library('lib_utilitas');
		$this->user = $this->auth_localnon->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;

		$grid->setTitle('SOI Mikro FG');		
		$grid->setTable('plc2.mikro_fg');		
		$grid->setUrl('soi_mikro_fg');
		$grid->addList('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','istatus','study_literatur_pd.ijenis_sediaan','iappqa_soi');
		$grid->setSortBy('plc2_upb_formula.vkode_surat');
		$grid->setSortOrder('ASC');

		$grid->setAlign('plc2_upb.vupb_nomor', 'Left');
		$grid->setWidth('plc2_upb.vupb_nomor', '80');
		$grid->setLabel('plc2_upb.vupb_nomor', 'UPB Nomor');

		$grid->setAlign('plc2_upb.vupb_nama', 'Left');
		$grid->setWidth('plc2_upb.vupb_nama', '300');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');

		$grid->setAlign('plc2_upb.vgenerik', 'Left');
		$grid->setWidth('plc2_upb.vgenerik', '300');
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');

		$grid->setAlign('istatus', 'Left');
		$grid->setWidth('istatus', '150');
		$grid->setLabel('istatus','Status Standarisasi');

		$grid->setAlign('study_literatur_pd.ijenis_sediaan', 'Left');
		$grid->setWidth('study_literatur_pd.ijenis_sediaan', '80');
		$grid->setLabel('study_literatur_pd.ijenis_sediaan', 'Jenis');

		$grid->setAlign('iappqa_soi', 'Left');
		$grid->setWidth('iappqa_soi', '150');
		$grid->setLabel('iappqa_soi','Approval QA');

		$grid->addFields('ifor_id','iupb_id','vupb_nama','vgenerik','dmulai_uji','dselesai_uji','istatus','itrial_uji','dmulai_draft','dselesai_draft','vPIC_draft','vfile_lempeng','vfile_endotoksin','vPIC_soi','iappqa_soi');
		
		$grid->setLabel('itujuan_req','Tujuan Produk');
		$grid->setLabel('ifor_id','Nomor Formulasi');
		$grid->setLabel('iupb_id','Nomor UPB');
		$grid->setLabel('vupb_nama','Nama Usulan');
		$grid->setLabel('vgenerik','Nama Generik');
		$grid->setLabel('dmulai_uji','Tgl Mulai Pengujian Mikro FG');
		$grid->setLabel('dselesai_uji','Tgl Selesai Pengujian Mikro FG');
		$grid->setLabel('itrial_uji','Trial ke-');
		$grid->setLabel('istatus','Satatus Standarisasi');
		$grid->setLabel('dmulai_draft','Tgl Mulai Pembuatan Draft SOI Mikro FG');
		$grid->setLabel('dselesai_draft','Tgl Selesai Pembuatan Draft SOI Mikro FG');
		$grid->setLabel('vfile_lempeng','Upload Laporan Draft SOI FG Umum - Lempeng');
		$grid->setLabel('vfile_endotoksin','Upload Laporan Draft SOI FG Spesifik - Endotoksin');
		$grid->setLabel('vPIC_draft','PIC Pembuatan Draft SOI Mikro FG');
		$grid->setLabel('vPIC_soi','PIC Upload SOI Final');
		$grid->setQuery('mikro_fg.lDeleted','0');

		$grid->setRequired('ifor_id','vfile_lempeng','vPIC_soi','vfile_endotoksin');
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
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('QA', $team)){
					$type='QA';
					$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
				}
				else{$type='';}
			}
		}
		$grid->setFormUpload(TRUE);
		$grid->setJoinTable('plc2.plc2_upb_formula', 'plc2_upb_formula.ifor_id = mikro_fg.ifor_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb', 'plc2.plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id', 'inner');
		$grid->setJoinTable('plc2.study_literatur_pd', 'plc2.plc2_upb_formula.iupb_id = plc2.study_literatur_pd.iupb_id', 'inner');
		
		$grid->setRelation('plc2.plc2_upb.iteamqa_id','plc2.plc2_upb_team','iteam_id','vteam','team_qa','inner',array('vtipe'=>'QA', 'ldeleted'=>0),array('vteam'=>'asc'));
		
		//$grid->changeFieldType('istatus','combobox','',array(''=>'--------- Pilih ---------','0'=>'Masuk Standart (MS)', '1'=>'Tidak Masuk Standart (TMS)'));
		//$grid->changeFieldType('study_literatur_pd.ijenis_sediaan','combobox','',array(0=>'Steril',1=>'Non Steril'));

		$grid->setQuery('mikro_fg.lDeleted',0);
		$grid->setQuery('mikro_fg.iappqa_uji',2);
		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama');

		//New Parameter For PLC Non OTC
		$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2.plc2_upb.iKill', 0);
		$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
		$grid->setQuery('plc2_upb.ihold', 0);
		
		//Mandatori untuk steril yang melalui draft
		//$grid->setQuery('(CASE WHEN plc2.study_literatur_pd.ijenis_sediaan=0 then
		//	 	plc2_upb_formula.ifor_id in (select mi.ifor_id from plc2.mikro_fg mi where mi.iappqa_draft=2 and mi.lDeleted=0)
		//	 else
	//		 	plc2_upb_formula.ifor_id in (select mi.ifor_id from plc2.mikro_fg mi where mi.lDeleted=0)
	//		 end)',NULL);

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
				echo $grid->saved_form();
				break;
			case 'download1':
				$this->download1($this->input->get('file'));
				break;
			case 'download2':
				$this->download2($this->input->get('file'));
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
				$imikro_fg_id=$post['soi_mikro_fg_imikro_fg_id'];
				$path1 = realpath("files/plc/soi_mikro_fg/lempeng");
				$path2 = realpath("files/plc/soi_mikro_fg/endotoksin");
				if(!file_exists($path1."/".$imikro_fg_id)){
					if (!mkdir($path1."/".$imikro_fg_id, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
				if(!file_exists($path2."/".$imikro_fg_id)){
					if (!mkdir($path2."/".$imikro_fg_id, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
									
				$fKeterangan = array();	
   				if($isUpload) {	
   					$fileid_lempeng='';
   					foreach($_POST as $key=>$value) {
											
						if ($key == 'fileketerangan_lempeng') {
							foreach($value as $y=>$u) {
								$fKeterangan_lempeng[$y] = $u;
							}
						}
						if ($key == 'namafile_lempeng') {
							foreach($value as $k=>$v) {
								$file_name_lempeng[$k] = $v;
							}
						}
						if ($key == 'fileid_lempeng') {
							$i=0;
							foreach($value as $k=>$v) {
								if($i==0){
									$fileid_lempeng .= "'".$v."'";
								}else{
									$fileid_lempeng .= ",'".$v."'";
								}
								$i++;
							}
						}
					}

					$fileid_endotoksin='';
   					foreach($_POST as $key=>$value) {
											
						if ($key == 'fileketerangan_endotoksin') {
							foreach($value as $y=>$u) {
								$fKeterangan_endotoksin[$y] = $u;
							}
						}
						if ($key == 'namafile_endotoksin') {
							foreach($value as $k=>$v) {
								$file_name_endotoksin[$k] = $v;
							}
						}
						if ($key == 'fileid_endotoksin') {
							$i=0;
							foreach($value as $k=>$v) {
								if($i==0){
									$fileid_endotoksin .= "'".$v."'";
								}else{
									$fileid_endotoksin .= ",'".$v."'";
								}
								$i++;
							}
						}
					}
					
					if (isset($_FILES['fileupload_lempeng']))  {

						$i=0;
						foreach ($_FILES['fileupload_lempeng']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_lempeng']["tmp_name"][$key];
								$name =$_FILES['fileupload_lempeng']["name"][$key];
								$data['filename_lempeng'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path1."/".$imikro_fg_id."/".$name)) {
									$sql[]="INSERT INTO plc2.soi_mikro_fg_file_lempeng (imikro_fg_id, vFilename, vKeterangan, dCreate, cCreate) 
											VALUES (".$imikro_fg_id.",'".$data['filename_lempeng']."','".$fKeterangan_lempeng[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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

					if (isset($_FILES['fileupload_endotoksin']))  {

						$i=0;
						foreach ($_FILES['fileupload_endotoksin']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_endotoksin']["tmp_name"][$key];
								$name =$_FILES['fileupload_endotoksin']["name"][$key];
								$data['filename_endotoksin'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path2."/".$imikro_fg_id."/".$name)) {
									$sql2[]="INSERT INTO plc2.soi_mikro_fg_file_endotoksin (imikro_fg_id, vFilename, vKeterangan, dCreate, cCreate) 
											VALUES (".$imikro_fg_id.",'".$data['filename_endotoksin']."','".$fKeterangan_endotoksin[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
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

					}
					
					$r['message']='Data Berhasil Di Simpan';
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');				
					echo json_encode($r);
					exit();
				}  else {
					$fileid_endotoksin='';
					foreach($_POST as $key=>$value) {
						if ($key == 'fileid_endotoksin') {
							$i=0;
							foreach($value as $k=>$v) {
								if($i==0){
									$fileid_endotoksin .= "'".$v."'";
								}else{
									$fileid_endotoksin .= ",'".$v."'";
								}
								$i++;
							}
						}
					}
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.soi_mikro_fg_file_endotoksin set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where imikro_fg_id='".$imikro_fg_id."' and isoi_mikro_fg_file_endotoksin_id not in (".$fileid_endotoksin.")";
					//echo $sql1;exit();
					$this->dbset->query($sql1);
					$fileid_lempeng='';
					foreach($_POST as $key=>$value) {
						if ($key == 'fileid_lempeng') {
							$i=0;
							foreach($value as $k=>$v) {
								if($i==0){
									$fileid_lempeng .= "'".$v."'";
								}else{
									$fileid_lempeng .= ",'".$v."'";
								}
								$i++;
							}
						}
					}
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.soi_mikro_fg_file_lempeng set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where imikro_fg_id='".$imikro_fg_id."' and isoi_mikro_fg_file_lempeng_id not in (".$fileid_lempeng.")";
					//echo $sql1;exit();
					$this->dbset->query($sql1);
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
				$sql="update plc2.mikro_fg set cappqa_soi='".$cNip."', dappqa_soi='".$tApprove."', iappqa_soi=2 where imikro_fg_id='".$get['last_id']."'";
				$this->dbset->query($sql);

				$sql="select fo.iupb_id, st.ijenis_sediaan from plc2.mikro_fg fg
					inner join plc2.plc2_upb_formula fo on fg.ifor_id=fo.ifor_id
					inner join plc2.study_literatur_pd st on st.iupb_id=fo.iupb_id
					where fg.imikro_fg_id=".$get['last_id'];
				$dt=$this->dbset->query($sql)->row_array();
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

		        //$query = $this->dbset->query($rsql);

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
		        $subject="SOI Mikro FG : UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada approval oleh QA Manager pada SOI Mikro FG(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
	function listBox_soi_mikro_fg_iappqa_soi($value) {
		if($value==0){$vstatus='Waiting for approval';}
		elseif($value==1){$vstatus='Rejected';}
		elseif($value==2){$vstatus='Approved';}
		return $vstatus;
	}

	function listBox_soi_mikro_fg_study_literatur_pd_ijenis_sediaan($value){
		if($value==0){$vstatus='Steril';}
		elseif($value==1){$vstatus='Non Steril';}
		return $vstatus;
	}

	function listBox_Action($row, $actions) {
	    if($row->iappqa_soi<>0){
	    	unset($actions['edit']);
	    }
	    if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){
				$type='QA';
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('QA', $team)){
					$type='QA';
					if($row->iappqa_soi<>0){
						unset($actions['edit']);
					}
				}
				else{$type='';}
			}
		}
	    return $actions; 

	}
/*manipulasi view object form start*/
	function updateBox_soi_mikro_fg_ifor_id($field, $id, $value, $rowData){
		$sql='select fo.ifor_id,f.vNo_formula as vkode_surat, up.vupb_nomor, up.vupb_nama, up.vgenerik 
				from plc2.plc2_upb_formula fo
				inner join plc2.plc2_upb up on up.iupb_id=fo.iupb_id
				join pddetail.formula_process fp on fp.iFormula_process=fo.iFormula_process
				join pddetail.formula f on f.iFormula_process=fp.iFormula_process
				where fo.ifor_id='.$rowData['ifor_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vkode_surat'];
		}else{
			$return = '<input type="hidden" name="isdraft" id="isdraft">';
			$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vkode_surat'].'" />&nbsp;';
		}
		return $return;
	}

	function updateBox_soi_mikro_fg_iupb_id($field, $id, $value, $rowData){
		$sql='select fo.ifor_id, fo.vkode_surat, up.vupb_nomor, up.vupb_nama, up.vgenerik from plc2.plc2_upb_formula fo
				inner join plc2.plc2_upb up on up.iupb_id=fo.iupb_id
				where fo.ifor_id='.$rowData['ifor_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nomor'];
		}else{
			$return = '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" value="'.$dt['vupb_nomor'].'" size="20" />&nbsp;';
		}
		return $return;
	}

	function updateBox_soi_mikro_fg_vupb_nama($field, $id, $value, $rowData) {
		$sql='select fo.ifor_id, fo.vkode_surat, up.vupb_nomor, up.vupb_nama, up.vgenerik from plc2.plc2_upb_formula fo
				inner join plc2.plc2_upb up on up.iupb_id=fo.iupb_id
				where fo.ifor_id='.$rowData['ifor_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nama'];
		}else{
			$return='<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" value="'.$dt['vupb_nama'].'" />';
		}
		return $return;
	}
	function updateBox_soi_mikro_fg_vgenerik($field, $id, $value, $rowData) {
		$sql='select fo.ifor_id, fo.vkode_surat, up.vupb_nomor, up.vupb_nama, up.vgenerik from plc2.plc2_upb_formula fo
				inner join plc2.plc2_upb up on up.iupb_id=fo.iupb_id
				where fo.ifor_id='.$rowData['ifor_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vgenerik'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" value="'.$dt['vgenerik'].'" />';
		}
		return $return;
	}
	function updateBox_soi_mikro_fg_dmulai_uji($field,$id,$value,$rowData){
		if(($value==NULl) || ($value=='')){
			$value='';
		}else{
			$value=date('d-m-Y',strtotime($value));
		}
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
			$return = '<input name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" type="text" size="20" class="" style="width:130px" value="'.$value.'" />';
		}

		return $return;
	}
	function updateBox_soi_mikro_fg_dselesai_uji($field,$id,$value,$rowData){
		if(($value==NULl) || ($value=='')){
			$value='';
		}else{
			$value=date('d-m-Y',strtotime($value));
		}
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
			$return = '<input name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" type="text" size="20" class="" style="width:130px" value="'.$value.'" />';
		}

		return $return;
	}
	function updateBox_soi_mikro_fg_istatus($field, $id, $value, $rowData) {
		
		if($this->input->get('action')=='view'){
			$return=$value;
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'" class="input_rows1" size="20" value="'.$value.'" />';
		}
		return $return;
	}
	function updateBox_soi_mikro_fg_itrial_uji($field, $id, $value, $rowData) {
		
		if($this->input->get('action')=='view'){
			$return=$value;
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'" class="input_rows1" size="20" value="'.$value.'" />';
		}
		return $return;
	}
	function updateBox_soi_mikro_fg_dmulai_draft($field,$id,$value,$rowData){
		if(($value==NULl) || ($value=='')){
			$value='';
		}else{
			$value=date('d-m-Y',strtotime($value));
		}
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
			$return = '<input name="'.$id.'" id="'.$id.'" disabled="TRUE" type="text" size="20" class="input_tgl" style="width:130px" value="'.$value.'" />';
		}

		$sql="select st.ijenis_sediaan as ijenis from plc2.mikro_fg mi
				inner join plc2.plc2_upb_formula fo on mi.ifor_id=fo.ifor_id
				inner join plc2.study_literatur_pd st on st.iupb_id=fo.iupb_id
				where mi.lDeleted=0 and fo.ldeleted=0 and st.lDeleted=0 and mi.imikro_fg_id=".$rowData['imikro_fg_id'];
		$r=$this->dbset->query($sql)->row_array();
		if($r['ijenis']==1){
			$return.='<script>
				$("#'.$id.'").parent().parent().hide();
			</script>';
		}

		return $return;
	}
	function updateBox_soi_mikro_fg_dselesai_draft($field,$id,$value,$rowData){
		if(($value==NULl) || ($value=='')){
			$value='';
		}else{
			$value=date('d-m-Y',strtotime($value));
		}
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
			$return = '<input name="'.$id.'" disabled="TRUE" id="'.$id.'" type="text" size="20" class="input_tgl" style="width:130px" value="'.$value.'" />';
		}
		$sql="select st.ijenis_sediaan as ijenis from plc2.mikro_fg mi
				inner join plc2.plc2_upb_formula fo on mi.ifor_id=fo.ifor_id
				inner join plc2.study_literatur_pd st on st.iupb_id=fo.iupb_id
				where mi.lDeleted=0 and fo.ldeleted=0 and st.lDeleted=0 and mi.imikro_fg_id=".$rowData['imikro_fg_id'];
		$r=$this->dbset->query($sql)->row_array();
		if($r['ijenis']==1){
			$return.='<script>
				$("#'.$id.'").parent().parent().hide();
			</script>';
		}
		return $return;
	}
	function updateBox_soi_mikro_fg_vPIC_draft($field, $id, $value, $rowData) {
		$sql="select * from hrd.employee em where em.cNip='".$value."'";
		$dt=$this->db_plc0->query($sql)->row_array();
		if($dt){
			$vName=$dt['vName'];
			$value=$value;
		}else{
			$vName='';
			$value='';
		}
		if($this->input->get('action')=='view'){
			$return	=$vName;
		}else{
			$return	= '<input name="'.$id.'" disabled="TRUE" id="'.$id.'" type="text" size="20" value="'.$vName.'"/>';
		}
		$sql="select st.ijenis_sediaan as ijenis from plc2.mikro_fg mi
			inner join plc2.plc2_upb_formula fo on mi.ifor_id=fo.ifor_id
			inner join plc2.study_literatur_pd st on st.iupb_id=fo.iupb_id
			where mi.lDeleted=0 and fo.ldeleted=0 and st.lDeleted=0 and mi.imikro_fg_id=".$rowData['imikro_fg_id'];
		$r=$this->dbset->query($sql)->row_array();
		if($r['ijenis']==1){
			$return.='<script>
				$("#'.$id.'").parent().parent().hide();
			</script>';
		}
		return $return;
	}

	function updateBox_soi_mikro_fg_vrevisi($field, $id, $value, $rowData) {
		if($this->input->get('action')=='view'){
			$return=$value;
		}else{
			$return	= '<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="20" value="'.$value.'" />';
		}
		return $return;
	}

    function updateBox_soi_mikro_fg_vfile_lempeng($field, $id, $value, $rowData) {
    	 	
		$qr="select * from plc2.soi_mikro_fg_file_lempeng where imikro_fg_id='".$rowData['imikro_fg_id']."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('soi_mikro_fg_file_lempeng',$data,TRUE);
	}
	function updateBox_soi_mikro_fg_vfile_endotoksin($field, $id, $value, $rowData) {  	 	
		$qr="select * from plc2.soi_mikro_fg_file_endotoksin where imikro_fg_id='".$rowData['imikro_fg_id']."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		$rs="select pd.* from plc2.plc2_upb_formula fo
			inner join plc2.study_literatur_pd pd on pd.iupb_id=fo.iupb_id
			where fo.ifor_id=".$rowData['ifor_id']." and pd.lDeleted=0 and fo.ldeleted=0
			group by pd.iupb_id";
		$drs=$this->db_plc0->query($rs)->row_array();
		$data['ijenis']=$drs['ijenis_sediaan'];
		return $this->load->view('soi_mikro_fg_file_endotoksin',$data,TRUE);
	}

	function  updateBox_soi_mikro_fg_vPIC_soi($field, $id, $value, $rowData) {
		$sql="select * from hrd.employee em where em.cNip='".$value."'";
		$dt=$this->db_plc0->query($sql)->row_array();
		if($dt){
			$vName=$dt['vName'];
			$value=$value;
		}else{
			$vName='';
			$value='';
		}
		if($this->input->get('action')=='view'){
			$return	=$vName;
		}else{
		$url = base_url().'processor/plc/soi/mikro/fg?action=getemployee';
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
		<input name="'.$id.'" id="'.$id.'" type="hidden" value="'.$value.'" class="required" />
		<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20" value="'.$vName.'"/>';
		}
		return $return;
	}

	function updateBox_soi_mikro_fg_iappqa_soi($field, $id, $value, $rowData) {
    	if($rowData['iappqa_soi'] != 0){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cappqa_soi']))->row_array();
			if($rowData['iappqa_soi']==2){$st="Approved";}elseif($rowData['iappqa_soi']==1){$st="Rejected";} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['cappqa_soi'].' )'.' pada '.$rowData['dappqa_soi'];
		}else{
			$ret='Waiting Approval';
		}
		return $ret;
	}
/*manipulasi view object form end*/

/*manipulasi proses object form start*/
  
	function manipulate_update_button($buttons, $rowData){
		//print_r($rowData);exit();
		unset($buttons['update']);
		$js=$this->load->view('soi_mikro_fg_js');
		$js .= $this->load->view('uploadjs');
		$cNip=$this->user->gNIP;

		$sql= "select * from plc2.plc2_upb_formula fo
			inner join plc2.plc2_upb up on fo.iupb_id=up.iupb_id
			where fo.ifor_id=".$rowData['ifor_id'];
		$dt=$this->dbset->query($sql)->row_array();
		$setuju = '<button onclick="javascript:setuju(\'soi_mikro_fg\', \''.base_url().'processor/plc/soi/mikro/fg?action=confirm&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Confirm</button>';

		$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/soi/mikro/fg?action=approve&imikro_fg_id='.$rowData['imikro_fg_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_mikro_fg">Approve</button>';
		$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/soi/mikro/fg?action=reject&imikro_fg_id='.$rowData['imikro_fg_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_soi_mikro_fg">Reject</button>';

		$update = '<button onclick="javascript:update_btn_back(\'soi_mikro_fg\', \''.base_url().'processor/plc/soi/mikro/fg?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_soi_mikro_fg">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'soi_mikro_fg\', \''.base_url().'processor/plc/soi/mikro/fg?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_soi_mikro_fg">Update as Draft</button>';
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){
				$type='QA';
				if (($rowData['iappqa_soi']==0)&&($rowData['isubmit_soi'])==0){
					$buttons['update']=$updatedraft.$update.$js;
				}else{
					if($rowData['iappqa_soi']==0){
						$buttons['update']=$setuju.$js;
					}else{}
				}
			}else{
				$type='';
			}
		}else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('QA', $team)){
				$type='QA';
				$q="select a.* from plc2.plc2_upb_team_item a
					join plc2.plc2_upb_team b on b.iteam_id=a.iteam_id
					where a.ldeleted=0 and b.vtipe='QA' and a.vnip='".$this->user->gNIP."'";
				$qr=$this->dbset->query($q)->row_array();
				if (($rowData['iappqa_soi']==0)&&($rowData['isubmit_soi'])==0){
					if($qr['iapprove']=='1'){
						$buttons['update']=$setuju.$js;
					}else{
						$buttons['update']=$updatedraft.$update.$js;
					}
				}else{
					if($qr['iapprove']=='1'){
						$buttons['update']=$setuju.$js;
					}
				}
			}else{
				$type='';
			}
		}
		return $buttons;
	}
   
/*manipulasi proses object form end*/    
function before_update_processor($row, $postData) {
	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;
	unset($postData['vPIC_text']);
	unset($postData['ifor_id']);
	unset($postData['dmulai_uji']);
	unset($postData['dselesai_uji']);
	unset($postData['dmulai_draft']);
	unset($postData['dselesai_draft']);
	unset($postData['vPIC_draft']);
	unset($postData['istatus']);
	unset($postData['itrial_uji']);
	unset($postData['soi_mikro_fg_vPIC_soi']);
	unset($postData['soi_mikro_fg_vPIC_text']);
	unset($postData['iappqa_soi']);
	if($postData['isdraft']==true){
		$postData['isubmit_soi']=0;
	} 
	else{$postData['isubmit_soi']=1;} 
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
										$.get(base_url+"processor/plc/soi/mikro/fg?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
	                            			 $("div#form_soi_mikro_fg").html(data);
	                    				});
									
								}
									reload_grid("grid_soi_mikro_fg");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_soi_mikro_fg_approve" action="'.base_url().'processor/plc/soi/mikro/fg?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="imikro_fg_id" value="'.$this->input->get('imikro_fg_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_soi_mikro_fg_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function approve_process(){
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.mikro_fg set vremark_soi='".$vRemark."',cappqa_soi='".$cNip."', dappqa_soi='".$tApprove."', iappqa_soi=2 where imikro_fg_id='".$post['imikro_fg_id']."'";
		$this->dbset->query($sql);

		$sql="select fo.iupb_id, st.ijenis_sediaan from plc2.mikro_fg fg
			inner join plc2.plc2_upb_formula fo on fg.ifor_id=fo.ifor_id
			inner join plc2.study_literatur_pd st on st.iupb_id=fo.iupb_id
			where fg.imikro_fg_id=".$post['imikro_fg_id'];
		$dt=$this->dbset->query($sql)->row_array();
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

        //$query = $this->dbset->query($rsql);

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
        $subject="SOI Mikro FG : UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval oleh QA Manager pada SOI Mikro FG(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
		$data['last_id'] = $post['imikro_fg_id'];
		
		return json_encode($data);
	}

function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#vRemark").val();
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
								if(o.status == true) {
									$("#alert_dialog_form").dialog("close");
										$.get(base_url+"processor/plc/soi/mikro/fg?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
	                            			 $("div#form_soi_mikro_fg").html(data);
	                    				});
									
								}
									reload_grid("grid_soi_mikro_fg");
							}
					 	 	
					 	 })
					
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_soi_mikro_fg_reject" action="'.base_url().'processor/plc/soi/mikro/fg?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="imikro_fg_id" value="'.$this->input->get('imikro_fg_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_soi_mikro_fg_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.mikro_fg set vremark_soi='".$vRemark."',cappqa_soi='".$cNip."', dappqa_soi='".$tApprove."', iappqa_soi=1 where imikro_fg_id='".$post['imikro_fg_id']."'";
		$this->dbset->query($sql);
		$data['group_id']=$post['group_id'];
		$data['modul_id']=$post['modul_id'];
		$data['status']  = true;
		$data['last_id'] = $post['imikro_fg_id'];
		return json_encode($data);
	}

/*function pendukung end*/    	
	function download1($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/soi_mikro_fg/lempeng/'.$id.'/'.$name);	
		force_download($name, $path);
	}
	function download2($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/soi_mikro_fg/endotoksin/'.$id.'/'.$name);	
		force_download($name, $path);
	}


	public function output(){
		$this->index($this->input->get('action'));
	}

}
