<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_trial_basic_formula extends MX_Controller {
		var $url;
		var $dbset;
	function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->user = $this->auth_localnon->user();
        $this->load->library('lib_utilitas');
        $this->load->library('lib_flow');
		$this->url = 'product_trial_basic_formula';
		$this->dbset = $this->load->database('plc0',false, true);
		$this->load->helper(array('tanggal','to_mysql'));
		$this->load->model('user_model');
    }
    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle('Basic Formula');
		$grid->setUrl('product_trial_basic_formula');
		$grid->setTable('plc2.plc2_upb_formula');
		$grid->setJoinTable('plc2.plc2_upb','plc2_upb_formula.iupb_id = plc2_upb.iupb_id','INNER');			
		$grid->setJoinTable('pddetail.formula_process','formula_process.iFormula_process=plc2_upb_formula.iFormula_process','inner');
		$grid->setJoinTable('pddetail.formula','formula.iFormula_process=formula_process.iFormula_process','inner');

		$grid->addList('formula.vNo_formula','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','iapppd_basic');		
		$grid->setSortBy('ifor_id');
		$grid->setSortOrder('DESC');
		$grid->setSearch('formula.vNo_formula','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik');
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '100');
		$grid->setWidth('plc2_upb.vupb_nama', '250');
		$grid->setWidth('plc2_upb.vgenerik', '250');
		$grid->addFields('vkode_surat','iupb_id','vupb_nama','vgenerik');
		/*$grid->addFields('lblbasic','dmulai_basic','dselesai_basic','cPIC_bacic','tberlaku','dupload_basic','vfile_basic');*/
		$grid->addFields('lblbasic','cPIC_bacic','tberlaku','vfile_basic');
		/*$grid->addFields('lblspesifikasi','dmulai_spesifikasi','dselesai_spesifikasi','dupload_spesifikasi','cPIC_spesifikasi','file_spek');*/
		$grid->addFields('lblspesifikasi','cPIC_spesifikasi','file_spek');
		//$grid->addFields('filename','vfile_lab');
		//$grid->addFields('vhpp','vnip_formulator','vbatchpilot1','vbatchpilot2','vbatchpabrik','pkomp','vrevisi');
		$grid->addFields('iwithbasic');
		$grid->addFields('vnip_formulator','vbasic_nip_apppd');
		//$grid->addFields('vhpp','vnip_formulator','istabilita1','istabilita2','istabilita3','vbasic_nip_apppd');
		$grid->setRequired('vkode_surat');
		//$grid->setRequired('vkode_surat', 'istabilita1', 'istabilita2', 'istabilita3');
		$grid->setLabel('vkode_surat', 'No. Formulasi');
		$grid->setLabel('formula.vNo_formula', 'No. Formulasi');
		
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');		
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('lblbasic', 'Pembuatan Basic Formula');
		$grid->setLabel('dmulai_basic', 'Tanggal Mulai');
		$grid->setLabel('dselesai_basic', 'Tanggal Selesai');
		$grid->setLabel('cPIC_bacic', 'PIC');
		$grid->setLabel('lblspesifikasi', 'Pembuatan Spesifikasi FG');
		$grid->setLabel('dmulai_spesifikasi','Tanggal Mulai');
		$grid->setLabel('dselesai_spesifikasi','Tanggal Selesai');
		$grid->setLabel('dupload_spesifikasi','Tanggal Upload');
		$grid->setLabel('tberlaku', 'Tanggal Berlaku / Terbit');
		$grid->setLabel('dupload_basic','Tanggal Upload');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');		
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('filename', 'File Formula Trial');
		$grid->setLabel('vfile_lab', 'File Formula Skala Lab');
		$grid->setLabel('vfile_basic', 'File Basic Formula');
		$grid->setLabel('file_formula', 'File Formula');
		$grid->setLabel('file_spek', 'File Spesifikasi');
		$grid->setLabel('proses_produksi', 'Proses Produksi');
		$grid->setLabel('lpp', 'Laporan Pengembangan Produk');
		$grid->setLabel('valpro', 'Form Valpro/IPC');
		$grid->setLabel('coafg', 'COAFG');
		$grid->setLabel('soifg', 'SOIFG');
		$grid->setLabel('pvm', 'Protokol Validasi MOA');
		$grid->setLabel('pkomp', 'Perubahan Komposisi');
		$grid->setLabel('vrevisi', 'Revisi');
		$grid->setLabel('iwithbasic','Proses Selanjutnya');
		$grid->setLabel('vhpp', 'HPP');
		$grid->setLabel('vnip_formulator', 'Formulator');
		$grid->setLabel('cPIC_spesifikasi', 'PIC Spesifikasi');
		// $grid->setLabel('vbatchpilot1', 'No. Batch Pilot I');
		// $grid->setLabel('istabilita1', 'Stabilita Pilot I');
		// $grid->setLabel('vbatchpilot2', 'No. Batch Pilot II');
		// $grid->setLabel('istabilita2', 'Stabilita Pilot II');
		// $grid->setLabel('vbatchpabrik', 'No. Batch Manufacturer');
		// $grid->setLabel('istabilita3', 'Stabilita Manufacturer');
		$grid->setLabel('iapppd_basic','Approval PD Manager');
		$grid->setLabel('vbasic_nip_apppd','Approval PD Manager');
		
		$grid->setQuery('plc2_upb_formula.ibest', 2);//Approval best formula
		$grid->setQuery('plc2_upb_formula.vbest_nip_apppd is not null', null);//Approval best formula
		$grid->setQuery('plc2_upb.ihold', 0);
		//$grid->setQuery('plc2_upb.ihpp', 2);
		$grid->setQuery('plc2_upb_formula.ldeleted', 0);
		
		$grid->setQuery('plc2_upb.iupb_id in (SELECT plc2_upb.iupb_id
									 FROM (plc2.plc2_upb_ro_detail)
									 INNER JOIN plc2.plc2_upb_ro ON plc2.plc2_upb_ro.iro_id = plc2.plc2_upb_ro_detail.iro_id
									 INNER JOIN plc2.plc2_upb_po ON plc2.plc2_upb_po.ipo_id = plc2.plc2_upb_ro_detail.ipo_id
									 INNER JOIN plc2.plc2_upb_request_sample ON plc2.plc2_upb_request_sample.ireq_id = plc2.plc2_upb_ro_detail.ireq_id
									 INNER JOIN plc2.plc2_upb ON plc2.plc2_upb.iupb_id = plc2.plc2_upb_request_sample.iupb_id
									 WHERE plc2.plc2_upb.iupb_id in (
									 select fp.iupb_id 
									 from pddetail.formula_stabilita f 
									 join pddetail.formula_process fp on fp.iFormula_process=f.iFormula_process
									 where f.lDeleted=0
									 and fp.lDeleted=0
									 and f.iKesimpulanStabilita=1
									 and f.iApp_formula=2
									 and fp.iFormula_process in (select a.iFormula_process 
									 from pddetail.formula_process a where a.lDeleted=0
									 and a.iMaster_flow in (6,7,8))
									 )
 
									 AND plc2_upb_ro_detail.ldeleted = 0
									 AND plc2_upb_ro.iclose_po = 1
									 AND plc2_upb.ihold = 0
									 AND plc2_upb_ro_detail.iappqa_ksk=2
									 GROUP BY plc2_upb.iupb_id)', NULL);//Mandatori Approval KSK
		//$grid->setQuery('plc2_upb_formula.ifor_id in (select hp.ifor_id from plc2.plc2_hpp hp where hp.vnip_appdir is not null)',null);

		// modified 20151116 minimal approval PD manager 
		//$grid->setQuery('plc2_upb_formula.ifor_id in (select hp.ifor_id from plc2.plc2_hpp hp where hp.vnip_apppd is not null)',null);
		//
		//New Parameter For PLC Non OTC
		$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2.plc2_upb.iKill', 0);
		$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
		$grid->setQuery('plc2_upb.ihold', 0);
		
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
		$grid->changeFieldType('vrevisi','label');
		$grid->changeFieldType('vhpp','label');
		
		$grid->setFormUpload(TRUE);
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				$grid->saved_form();
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
				$post['dupdate'] = date('Y-m-d H:i:s');
				$post['cUpdate'] =$this->user->gNIP;
				$ifor_id=$post['product_trial_basic_formula_ifor_id'];
				$path = realpath("files/plc/product_trial/basic_formula/filename");
				if(!file_exists($path."/".$ifor_id)){
					if (!mkdir($path."/".$ifor_id, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}			
				$fKeterangan = array();	

				//spesifikasi
				$pathspek = realpath("files/plc/product_trial/basic_formula/");
				if(!file_exists($pathspek."/spesifikasi_fg/".$ifor_id)){
					if (!mkdir($pathspek."/spesifikasi_fg/".$ifor_id, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}			
				$fileketeranganspek = array();

   				if($isUpload) {	
	   				$fileid='';
   					foreach($_POST as $key=>$value) {
											
						if ($key == 'fileketeranganfbasic') {
							foreach($value as $y=>$u) {
								$fKeterangan[$y] = $u;
							}
						}
						if ($key == 'namafilefbasic') {
							foreach($value as $k=>$v) {
								$file_name[$k] = $v;
							}
						}
						if ($key == 'fileidfbasic') {
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
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.plc2_upb_file_basic_formula set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$ifor_id."' and id not in (".$fileid.")";
					$this->dbset->query($sql1);
					if (isset($_FILES['fileuploadfbasic']))  {
						$i=0;
						foreach ($_FILES['fileuploadfbasic']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileuploadfbasic']["tmp_name"][$key];
								$name =$_FILES['fileuploadfbasic']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$ifor_id."/".$name)) {
									$sqli[]="INSERT INTO plc2.plc2_upb_file_basic_formula (ifor_id, filename, keterangan, dInsertDate, cInsert) 
											VALUES (".$ifor_id.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sqli as $ql) {
							try {
								$this->dbset->query($ql);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}

					//spesifikasi
					$fileidspek='';
   					foreach($_POST as $key=>$value) {
											
						if ($key == 'fileketeranganspek') {
							foreach($value as $y=>$u) {
								$fileketeranganspek[$y] = $u;
							}
						}
						if ($key == 'namafilespek') {
							foreach($value as $k=>$v) {
								$namafilespek[$k] = $v;
							}
						}
						if ($key == 'fileidspek') {
							$i=0;
							foreach($value as $k=>$v) {
								if($i==0){
									$fileidspek .= "'".$v."'";
								}else{
									$fileidspek .= ",'".$v."'";
								}
								$i++;
							}
						}
					}
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.plc2_file_spesifikasi set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ifor_id='".$ifor_id."' and id not in (".$fileidspek.")";
					$this->dbset->query($sql1);
					if (isset($_FILES['fileuploadspek']))  {
						$i=0;
						foreach ($_FILES['fileuploadspek']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileuploadspek']["tmp_name"][$key];
								$name =$_FILES['fileuploadspek']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $pathspek."/spesifikasi_fg/".$ifor_id."/".$name)) {
									$sqlspek[]="INSERT INTO plc2.plc2_file_spesifikasi (ifor_id, filename, keterangan, dInsertDate, cInsert) 
											VALUES (".$ifor_id.",'".$data['filename']."','".$fileketeranganspek[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sqlspek as $qlspek) {
							try {
								$this->dbset->query($qlspek);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}
					$r['message'] = "Data Berhasil di Simpan!";
					$r['status'] = TRUE;
					$r['last_id'] =$this->input->get('last_id');			
					echo json_encode($r);
					exit();
				}  else {
					echo $grid->updated_form();
				}
				break;
			case 'detail':
				$this->detail();
			break;
			case 'approve':
				echo $this->approve_view();
				break;
			case 'download':
				$this->download($this->input->get('file'));
				break;	
			case 'downloadn':
				$this->downloadn($this->input->get('file'));
				break;
			case 'download1':
				$this->download1($this->input->get('file'));
				break;
			case 'download2':
				$this->download2($this->input->get('file'));
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

				$skg=date('Y-m-d H:i:s');
				$this->db_plc0->where('ifor_id', $get['ifor_id']);
				$this->db_plc0->update('plc2.plc2_upb_formula', array('iapp_basic'=>2,'iapppd_basic'=>2,'vbasic_nip_apppd'=>$this->user->gNIP,'tbasic_apppd'=>$skg));
		    	
				$iupb_id=$post['iupb_id'];
				$ifor_id=$get['ifor_id'];
				
		    	$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
		                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
		                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
		                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
		                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
		                        from plc2.plc2_upb u where u.iupb_id='".$post['iupb_id']."'";
		        $rupb = $this->db_plc0->query($qupb)->row_array();

		        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id,
		                (select te.iteam_id from plc2.plc2_upb_team te where te.cDeptId='PR') as iteampr_id 
		                from plc2.plc2_upb u 
		                where u.iupb_id='".$post['iupb_id']."'";
		        $rsql = $this->db_plc0->query($qsql)->row_array();

		        //$query = $this->dbset->query($rsql);

		        $pd = $rsql['iteampd_id'];
		        $bd = $rsql['iteambusdev_id'];
		        $qa = $rsql['iteamqa_id'];
		        $qc = $rsql['iteamqc_id'];
		        $pr = $rsql['iteampr_id'];
		        
		        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
		        
		        $toEmail2='';
		        $toEmail = $this->lib_utilitas->get_email_team( $pd );
		        $toEmail2 = $this->lib_utilitas->get_email_leader( $pd );                        

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
		        $subject="Proses Basic Formula Selesai: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada approval oleh PD Manager pada proses Basic Formula(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
    function getEmployee() {
    	$term = $this->input->get('term');
    	$sql='select de.vDescription,em.cNip as cNIP, em.vName as vName from plc2.plc2_upb_team_item it
				inner join plc2.plc2_upb_team te on it.iteam_id= te.iteam_id
				inner join hrd.employee em on em.cNip=it.vnip
				inner join hrd.msdepartement de on de.iDeptID=em.iDepartementID 
				where em.vName like "%'.$term.'%" and te.vtipe="PD" AND it.ldeleted=0 order by em.vname ASC';
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
	function manipulate_update_button($buttons, $rowData) {
		if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			unset($buttons['update_back']);
			unset($buttons['update']);
			
			//print_r($rowData);
			//echo $rowData['vnip_formulator']."<br>".$this->user->gNIP;
			$user = $this->auth_localnon->user();
			//
			//tambah validasi approve, kalo dia blm lengkap stabilita pilotnya (pilot 1, pilot2, pabrik)
			$inumber_pilot1 = $rowData['inumber_pilot1'];
			$vbatchpilot1 = $rowData['vbatchpilot1'];
			$inumber_pilot2 = $rowData['inumber_pilot2'];
			$vbatchpilot2 = $rowData['vbatchpilot2'];
			$inumber_pabrik = $rowData['inumber_pabrik'];
			$vbatchpabrik = $rowData['vbatchpabrik'];
			
			//if(($rowData['inumber_pilot1']==null)||($rowData['vbatchpilot1']==null)||($rowData['inumber_pilot2']==null)||($rowData['vbatchpilot2']==null)||($rowData['inumber_pabrik']==null)||($rowData['vbatchpabrik']==null)){
			/*if(($rowData['inumber_pilot1']==null)||($rowData['inumber_pilot2']==null)||($rowData['inumber_pabrik']==null)){
				$pilot='invalid';
			}else{
				$pilot='valid';
			}*/
			//echo $pilot;
			//
			$x=$this->auth_localnon->dept();
			if($this->auth_localnon->is_manager()){
				$x=$this->auth_localnon->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){$type='PD';}
				else{$type='';}
			}
			else{
				$x=$this->auth_localnon->dept();
				if(isset($x['team'])){
					$team=$x['team'];
					if(in_array('PD', $team)){$type='PD';}
					else{$type='';}
				}
			}
			
			//echo $type;
			// cek status upb, klao upb 
				unset($buttons['update_back']);
				unset($buttons['update']);
				$js = $this->load->view('product_trial_basic_formula_js');
				$js .= $this->load->view('uploadjs');
				//echo $this->auth_localnon->my_teams();
				$upb_id=$rowData['iupb_id'];
				$ifor_id=$rowData['ifor_id'];

				$sql= "select * from plc2.plc2_upb up where up.iupb_id=".$rowData['iupb_id'];
				$dt=$this->dbset->query($sql)->row_array();
				$setuju = '<button onclick="javascript:setuju(\'product_trial_basic_formula\', \''.base_url().'processor/plc/product/trial/basic/formula?action=confirm&last_id='.$this->input->get('id').'&ifor_id='.$ifor_id.'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_product_trial_basic_formula">Confirm</button>';

				$update = '<button onclick="javascript:update_btn_back(\'product_trial_basic_formula\', \''.base_url().'processor/plc/product/trial/basic/formula?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_product_trial_basic_formula">Update & Submit</button>';
				$updatedraft = '<button onclick="javascript:update_draft_btn(\'product_trial_basic_formula\', \''.base_url().'processor/plc/product/trial/basic/formula?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_product_trial_basic_formula">Update as Draft</button>';

				if($this->auth_localnon->is_manager()){ //jika manager PR
					if(($type=='PD')&&($rowData['iapppd_basic']==0)){
						//$update = '<button onclick="javascript:update_btn_back(\'product_trial_basic_formula\', \''.base_url().'processor/plc/product/trial/basic/formula?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_basic_formula">Update</button>';
						$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/basic/formula?action=approve&upb_id='.$upb_id.'&ifor_id='.$ifor_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_basic_formula">Approve</button>';
						//$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/basic/formula?action=reject&upb_id='.$upb_id.'&ifor_id='.$ifor_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_basic_formula">Reject</button>';
						if ($rowData['isubmit_basic']==0){
							$buttons['update']=$updatedraft.$update.$js;
						}else{	
							$buttons['update'] = $setuju.$js;
						}
					}
					else{
						$buttons['update'] = '';
					}
				}
				else{
					if(($type=='PD')&&($rowData['iapppd_basic']==0)){
						//$update = '<button onclick="javascript:update_btn_back(\'product_trial_basic_formula\', \''.base_url().'processor/plc/product/trial/basic/formula?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_basic_formula">Update</button>';
							
						if ($rowData['isubmit_basic']==0){
							$buttons['update']=$updatedraft.$update.$js;
						}else{}
					}
					else{
						$buttons['update'] = '';
					}
				}
				
				 //print_r($rowData);
				 //exit();
				/*
				$x=$this->auth_localnon->my_teams();
				//print_r($x);
				$arrhak=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
			//print_r($arrhak);
				if(empty($arrhak)){
					$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
					if(empty($getbp)){}
					else{
						if($this->auth_localnon->is_manager()){ //jika manager PR
							/*if($pilot=='invalid'){
								$update = '<button onclick="javascript:update_btn_back(\'product_trial_basic_formula\', \''.base_url().'processor/plc/product/trial/basic/formula?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_basic_formula">Update</button>';
								// $approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/basic/formula?action=approve&upb_id='.$upb_id.'&ifor_id='.$ifor_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_basic_formula">Approve</button>';
								// $reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/basic/formula?action=reject&upb_id='.$upb_id.'&ifor_id='.$ifor_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_basic_formula">Reject</button>';
									
								$buttons['update'] = $update.$js;
							}else*/
							/*if(($type=='PD')&&($rowData['iapppd_basic']==0)){
								$update = '<button onclick="javascript:update_btn_back(\'product_trial_basic_formula\', \''.base_url().'processor/plc/product/trial/basic/formula?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_basic_formula">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/basic/formula?action=approve&upb_id='.$upb_id.'&ifor_id='.$ifor_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_basic_formula">Approve</button>';
								//$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/basic/formula?action=reject&upb_id='.$upb_id.'&ifor_id='.$ifor_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_basic_formula">Reject</button>';
									
								$buttons['update'] = $update.$approve.$js;
							}
							else{
								$buttons['update'] = '';
							}
						}
						else{
							if(($type=='PD')&&($rowData['iapppd_basic']==0)){
								$update = '<button onclick="javascript:update_btn_back(\'product_trial_basic_formula\', \''.base_url().'processor/plc/product/trial/basic/formula?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_basic_formula">Update</button>';
									
								$buttons['update'] = $update.$js;
							}
							else{
								$buttons['update'] = '';
							}
						}
					}
				}else{
					if($this->auth_localnon->is_manager()){ //jika manager PR
						if($this->auth_localnon->is_manager()){ //jika manager PR
							/*if($pilot=='invalid'){
								$update = '<button onclick="javascript:update_btn_back(\'product_trial_basic_formula\', \''.base_url().'processor/plc/product/trial/basic/formula?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_basic_formula">Update</button>';
								// $approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/basic/formula?action=approve&upb_id='.$upb_id.'&ifor_id='.$ifor_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_basic_formula">Approve</button>';
								// $reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/basic/formula?action=reject&upb_id='.$upb_id.'&ifor_id='.$ifor_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_basic_formula">Reject</button>';
									
								$buttons['update'] = $update.$js;
							}
							elseif(($type=='PD')&&($rowData['iapppd_basic']==0)){
								$update = '<button onclick="javascript:update_btn_back(\'product_trial_basic_formula\', \''.base_url().'processor/plc/product/trial/basic/formula?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_basic_formula">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/basic/formula?action=approve&upb_id='.$upb_id.'&ifor_id='.$ifor_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_basic_formula">Approve</button>';
								//$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/basic/formula?action=reject&upb_id='.$upb_id.'&ifor_id='.$ifor_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_basic_formula">Reject</button>';
									
								$buttons['update'] = $update.$approve.$js;
							}
							else{
								$buttons['update'] = $rowData['iapppd_basic'];
							}
						}
						else{
							if(($type=='PD')&&($rowData['iapppd_basic']==0)){
								$update = '<button onclick="javascript:update_btn_back(\'product_trial_basic_formula\', \''.base_url().'processor/plc/product/trial/basic/formula?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_basic_formula">Update</button>';
									
								$buttons['update'] = $update.$js;
							}
							else{
								$buttons['update'] = '';
							}
						}
					}
				}*/
		}
		//$buttons['update']=$type.$rowData['iapppd_basic'];
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
								var url = "'.base_url().'processor/plc/product/trial/basic/formula";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_product_trial_basic_formula").html(data);
									});
					
								}
									reload_grid("grid_product_trial_basic_formula");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_product_trial_basic_formula_approve" action="'.base_url().'processor/plc/product/trial/basic/formula?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="upb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="ifor_id" value="'.$this->input->get('ifor_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_product_trial_basic_formula_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$this->db_plc0->where('ifor_id', $post['ifor_id']);
		$this->db_plc0->update('plc2.plc2_upb_formula', array('iapp_basic'=>2,'iapppd_basic'=>2,'vbasic_nip_apppd'=>$nip,'tbasic_apppd'=>$skg));
    	
		$upb_id=$post['upb_id'];
		$ifor_id=$post['ifor_id'];
		//$this->lib_flow->insert_logs($post['modul_id'],$upb_id,9,2);
		/*
		$ins['iupb_id'] = $post['upb_id'];
		$ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
		$ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
		$ins['idiv_id'] = '';
		$ins['vtipe'] = $post['type'];
		$ins['iapprove'] = '2';
		$ins['cnip'] = $this->user->gNIP;
		$ins['treason'] = $post['remark'];
		$ins['tupdate'] = date('Y-m-d H:i:s');
		
		$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
		
		$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // 1 approval
		$bizsup=$getbp['idplc2_biz_process_sub'];
			
		$hacek=$this->biz_process->cek_last_status($post['upb_id'],$bizsup,1); // status 1 => app
		if($hacek==1){ // jika sudah pernah ada data maka update saja
			//insert log
			$this->biz_process->insert_log($post['upb_id'], $bizsup, 1); // status 1 => app
			//update last log
			$this->biz_process->update_last_log($post['upb_id'], $bizsup, 1);
		}
		elseif($hacek==0){
			//insert log
			$this->biz_process->insert_log($post['upb_id'], $bizsup, 1); // status 1 => app
			//insert last log
			$this->biz_process->insert_last_log($post['upb_id'], $bizsup, 1);
		}
		//}*/
    	$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
                        from plc2.plc2_upb u where u.iupb_id='".$post['upb_id']."'";
        $rupb = $this->db_plc0->query($qupb)->row_array();

        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id,
                (select te.iteam_id from plc2.plc2_upb_team te where te.cDeptId='PR') as iteampr_id 
                from plc2.plc2_upb u 
                where u.iupb_id='".$post['upb_id']."'";
        $rsql = $this->db_plc0->query($qsql)->row_array();

        //$query = $this->dbset->query($rsql);

        $pd = $rsql['iteampd_id'];
        $bd = $rsql['iteambusdev_id'];
        $qa = $rsql['iteamqa_id'];
        $qc = $rsql['iteamqc_id'];
        $pr = $rsql['iteampr_id'];
        
        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
        
        $toEmail2='';
        $toEmail = $this->lib_utilitas->get_email_team( $pd );
        $toEmail2 = $this->lib_utilitas->get_email_leader( $pd );                        

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
        $subject="Proses Basic Formula Selesai: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval oleh PD Manager pada proses Basic Formula(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
		$data['status']  = true;
    	$data['last_id'] = $ifor_id;
    	return json_encode($data);
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
								var url = "'.base_url().'processor/plc/product/trial/basic/formula";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_product_trial_basic_formula").html(data);
									});
					
								}
									reload_grid("grid_product_trial_basic_formula");
							}
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_product_trial_basic_formula_reject" action="'.base_url().'processor/plc/product/trial/basic/formula?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="upb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="ifor_id" value="'.$this->input->get('ifor_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea><button type="button" onclick="submit_ajax(\'form_product_trial_basic_formula_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process () {
    	$post = $this->input->post();
    	$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
	 	$this->db_plc0->where('ifor_id', $post['ifor_id']);
		$this->db_plc0->update('plc2.plc2_upb_formula', array('iapp_basic'=>1,'iapppd_basic'=>1,'vbasic_nip_apppd'=>$nip,'tbasic_apppd'=>$skg));
    
		$upb_id=$post['upb_id'];
		$ifor_id=$post['ifor_id'];
		
			$ins['iupb_id'] = $post['upb_id'];
			$ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
			$ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
			$ins['idiv_id'] = '';
			$ins['vtipe'] = $post['type'];
			$ins['iapprove'] = '2';
			$ins['cnip'] = $this->user->gNIP;
			$ins['treason'] = $post['remark'];
			$ins['tupdate'] = date('Y-m-d H:i:s');
		
			$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
			/*
			$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // 1 approval
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
				
			$hacek=$this->biz_process->cek_last_status($post['upb_id'],$bizsup,2); // status 2 => reject
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($post['upb_id'], $bizsup, 2); // status 2 => reject
				//update last log
					$this->biz_process->update_last_log($post['upb_id'], $bizsup, 2);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($post['upb_id'], $bizsup, 2); // status 2 => reject
				//insert last log
					$this->biz_process->insert_last_log($post['upb_id'], $bizsup, 2);
			}*/
		//}
		
    	$data['status']  = true;
    	$data['last_id'] = $ifor_id;
    	return json_encode($data);
    }
    
	public function listBox_Action($row, $actions) {
    	//print_r($row);
		if($this->auth_localnon->is_manager()){
			$teams = $this->auth_localnon->tipe();
			$man=$teams['manager'];
			if(in_array('PD',$man) && ($row->iapppd_basic)==0){}
			else{
				unset($actions['edit']);
				unset($actions['delete']);
			}
		}
		else{
				$x=$this->auth_localnon->dept();
				if(isset($x['team'])){
					$team=$x['team'];
					if(in_array('PD', $team)&& ($row->iapppd_basic)==0 && ($row->isubmit_basic)==0){}
					else{
						$type='';
						unset($actions['edit']);
						unset($actions['delete']);
					}
				}else{
					unset($actions['edit']);
					unset($actions['delete']);
				}
			}
		return $actions;
    }
	function listBox_product_trial_basic_formula_iapppd_basic($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	//Keterangan approval 
	function insertBox_product_trial_basic_formula_vbasic_nip_apppd($field, $id) {
		return '-';
	}
	function updateBox_product_trial_basic_formula_vbasic_nip_apppd($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($rowData['vbasic_nip_apppd'] != null)){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vbasic_nip_apppd']))->row_array();
			if($rowData['iapppd_basic']==2){$st="Approved";}elseif($rowData['iapppd_basic']==1){$st="Rejected";
				// $rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// if(isset($rowa)){$reason=$rowa['treason'];}
				
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vbasic_nip_apppd'].' )'.' pada '.$rowData['tbasic_apppd'];
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	//
	function updateBox_product_trial_basic_formula_vkode_surat($name, $id, $value,$rowData) {
		$sql='select fo.ifor_id,f.vNo_formula as vkode_surat, up.vupb_nomor, up.vupb_nama, up.vgenerik 
				from plc2.plc2_upb_formula fo
				inner join plc2.plc2_upb up on up.iupb_id=fo.iupb_id
				join pddetail.formula_process fp on fp.iFormula_process=fo.iFormula_process
				join pddetail.formula f on f.iFormula_process=fp.iFormula_process
				where fo.ifor_id='.$rowData['ifor_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		return $dt['vkode_surat'];
	}
	function updateBox_product_trial_basic_formula_iupb_id($name, $id, $value) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$value))->row_array();
		$return ='<input type="hidden" size="50" value="'.$value.'" name="'.$id.'" id="'.$id.'" />'.$row['vupb_nomor'];
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		return $return;
	}
	function updateBox_product_trial_basic_formula_vupb_nama($name, $id, $value,$rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$return = $row['vupb_nama'];
		return $return;
	}
	function updateBox_product_trial_basic_formula_vgenerik($name, $id, $value,$rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$return = $row['vgenerik'];
		return $return;
	}
	function updateBox_product_trial_basic_formula_lblbasic($field, $id, $value, $rowData){
		$return = '<script>
			$("label[for=\'product_trial_basic_formula_lblbasic\']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"99%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase"});
		</script>';
		return $return;
	}
	function updateBox_product_trial_basic_formula_dmulai_basic($field, $id, $value, $rowData){
		//print_r($rowData);
		$value=date('d-m-Y',strtotime($rowData['dmulai_basic']));
		if(($value==NULL)||($value=='')||($value=='0000-00-00') || ($value =='01-01-1970')){
			$val='';
		}else{
			$val=$value;
		}
		if($this->input->get('action')=='view'){
			$return	=$val;
		}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
		}
		return $return;
	}
	function updateBox_product_trial_basic_formula_dselesai_basic($field, $id, $value, $rowData){
		//print_r($rowData);
		$value=date('d-m-Y',strtotime($rowData['dselesai_basic']));
		if(($value==NULL)||($value=='')||($value=='0000-00-00') || ($value =='01-01-1970')){
			$val='';
		}else{
			$val=$value;
		}
		if($this->input->get('action')=='view'){
			$return	=$val;
		}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
		}
		return $return;
	}
	function updateBox_product_trial_basic_formula_cPIC_bacic($field, $id, $value, $rowData) {
		$url = base_url().'processor/plc/product/trial/basic/formula?action=getemployee';
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
			if(($value!=NULL)||($value!='')){
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
		
		return $return;
	}
	function updateBox_product_trial_basic_formula_dupload_basic($field, $id, $value, $rowData){
		//print_r($rowData);
		$value=date('d-m-Y',strtotime($rowData['dupload_basic']));
		if(($value==NULL)||($value=='')||($value=='0000-00-00') || ($value =='01-01-1970')){
			$val='';
		}else{
			$val=$value;
		}
		if($this->input->get('action')=='view'){
			$return	=$val;
		}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
		}
		return $return;
	}
	function updateBox_product_trial_basic_formula_tberlaku($name, $id, $value) {
		return tanggal($value,'l, F jS, Y');
	}
	function updateBox_product_trial_basic_formula_filename($field, $id, $value, $rowData) {
		/*if($value != '') {
			if (file_exists('./files/plc/product_trial/formula_trial/'.$value)) {
				$link = base_url().'processor/plc/product/trial/formula/skala/trial?action=download&file='.$value;
				$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			}
			else {
				$linknya = 'File sudah tidak ada!';
			}
			return 'File name : '.$value.' ['.$linknya.']';
		}
		else {
			return 'No File<br />';
		}*/
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		$idfor = $rowData['ifor_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_skala_trial_filename', array('ifor_id'=>$idfor))->result_array();
		return $this->load->view('product_trial_basic_formula_file1',$data,TRUE);		
	}
	
	function updateBox_product_trial_basic_formula_vfile_lab($field, $id, $value, $rowData) {
		/*if($value != '') {
			if (file_exists('./files/plc/product_trial/formula_trial/'.$value)) {
				$link = base_url().'processor/plc/product/trial/formula/skala/trial?action=download&file='.$value;
				$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			}
			else {
				$linknya = 'File sudah tidak ada!';
			}
			return 'File name : '.$value.' ['.$linknya.']';
		}
		else {
			return 'No File<br />';
		}*/
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		$idfor = $rowData['ifor_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_skala_lab_filename', array('ifor_id'=>$idfor))->result_array();
		return $this->load->view('product_trial_basic_formula_file2',$data,TRUE);
	}	
	function updateBox_product_trial_basic_formula_vfile_basic($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		$idfor = $rowData['ifor_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_basic_formula', array('ifor_id'=>$idfor,'ldeleted'=>'0'))->result_array();
		return $this->load->view('product_trial_basic_formula_file',$data,TRUE);
	}
	
	function updateBox_product_trial_basic_formula_proses_produksi($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		$idfor = $rowData['ifor_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_proses_produksi', array('ifor_id'=>$idfor))->result_array();
		return $this->load->view('product_trial_basic_formula_file3',$data,TRUE);
	}
	
	function updateBox_product_trial_basic_formula_lpp($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		$idfor = $rowData['ifor_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_lpp', array('ifor_id'=>$idfor))->result_array();
		return $this->load->view('product_trial_basic_formula_file4',$data,TRUE);
	}
	
	function updateBox_product_trial_basic_formula_valpro($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		$idfor = $rowData['ifor_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_form_valpro', array('ifor_id'=>$idfor))->result_array();
		return $this->load->view('product_trial_basic_formula_file5',$data,TRUE);
	}
	
	function updateBox_product_trial_basic_formula_coafg($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		$idfor = $rowData['ifor_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_coa_fg', array('ifor_id'=>$idfor))->result_array();
		return $this->load->view('product_trial_basic_formula_file6',$data,TRUE);
	}
	
	function updateBox_product_trial_basic_formula_pvm($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		$idfor = $rowData['ifor_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_valmoa', array('ifor_id'=>$idfor))->result_array();
		return $this->load->view('product_trial_basic_formula_file7',$data,TRUE);
	}
	function updateBox_product_trial_basic_formula_pkomp($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		$idfor = $rowData['ifor_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_ubah_komposisi', array('ifor_id'=>$idfor))->result_array();
		return $this->load->view('product_trial_basic_formula_file8',$data,TRUE);
	}
	//FUNGSI DOWNLOAD UNTUK basic_formula
	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/product_trial/'.$tempat.'/filename/'.$id.'/'.$name);	
		force_download($name, $path);
	}
	function download1($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/product_trial/basic_formula/pros_prod/'.$id.'/'.$name);	
		force_download($name, $path);
	}
	function download2($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$tempat = './files/plc/product_trial/basic_formula/spesifikasi_fg';
		$path = file_get_contents($tempat.'/'.$id.'/'.$name);	
		force_download($name, $path);
	}
	//
	//FUNGSI DOWNLOAD UNTUK dokumen baru (lpp)
	function downloadn($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/'.$tempat.'/'.$id.'/'.$name);	
		force_download($name, $path);
	}
	//
	function updateBox_product_trial_basic_formula_vnip_formulator($name, $id, $value) {
		$row = $this->user_model->get_user_info($value);
		if(sizeOf($row)>0){
			return $row['cNip'].' | '.$row['vName'].' | '.$row['divisi'];
		}else{
			return ' | | ';
		}
	}
	function updateBox_product_trial_basic_formula_istabilita1($name, $id, $value, $rowData) {
		$query = "select inumber_pilot1 from plc2.plc2_upb_formula where ifor_id = '".$rowData['ifor_id']."'";
		$row = $this->db_plc0->query($query)->row_array();
		$queryp = "select * from plc2.plc2_upb_stabilita_pilot sp where sp.ipilot=1 and sp.iapppd=2 and sp.ifor_id='".$rowData['ifor_id']."'";
		$rowp = $this->db_plc0->query($queryp)->result_array();
		//print_r($rowp);
		// $return='<select name="inumber_pilot1" id="inumber_pilot1">';
		// foreach($rowp as $stabp){
			// if(is_null($row['inumber_pilot1'])){
				// $return.='<option value="'.$stabp['inumber'].'">'.$stabp['inumber'].'</option>';
			// }
			// else{
				// if($stabp['inumber']==$row['inumber_pilot1']){
					// $return.='<option value="'.$stabp['inumber'].'" selected>'.$stabp['inumber'].'</option>';
				// }
				// else{
					// $return.='<option value="'.$stabp['inumber'].'">'.$stabp['inumber'].'</option>';
				// }
			// }
			
		// }
		// $return.='</select>';
		if(is_null($row['inumber_pilot1'])){
			$return='<input type="text" class="required dua" name="inumber_pilot1" id="inumber_pilot1" size="2" style="text-align: right;" onkeypress="return isNumberKey(event)" /> ';
		}
		else{
			$return='<input type="text" class="required dua" name="inumber_pilot1" id="inumber_pilot1" size="2" value="'.$row['inumber_pilot1'].'" style="text-align: right;" onkeypress="return isNumberKey(event)" /> ';
		}
		return $return;
		
	}
 	
	function updateBox_product_trial_basic_formula_istabilita2($name, $id, $value, $rowData) {
		$query = "select inumber_pilot2 from plc2.plc2_upb_formula where ifor_id = '".$rowData['ifor_id']."'";
		$row = $this->db_plc0->query($query)->row_array();
		$queryp = "select * from plc2.plc2_upb_stabilita_pilot sp where sp.ipilot=2 and sp.iapppd=2 and sp.ifor_id='".$rowData['ifor_id']."'";
		$rowp = $this->db_plc0->query($queryp)->result_array();
		//print_r($rowp);
		
		// $return='<select name="inumber_pilot2" id="inumber_pilot2">';
		// foreach($rowp as $stabp){
			// if(is_null($row['inumber_pilot2'])){
				// $return.='<option value="'.$stabp['inumber'].'">'.$stabp['inumber'].'</option>';
			// }
			// else{
				// if($stabp['inumber']==$row['inumber_pilot2']){
					// $return.='<option value="'.$stabp['inumber'].'" selected>'.$stabp['inumber'].'</option>';
				// }
				// else{
					// $return.='<option value="'.$stabp['inumber'].'">'.$stabp['inumber'].'</option>';
				// }
			// }
			
		// }
		// $return.='</select>';
		if(is_null($row['inumber_pilot2'])){
			$return='<input type="text" class="required dua" name="inumber_pilot2" id="inumber_pilot2" size="2" style="text-align: right;" onkeypress="return isNumberKey(event)" /> ';
		}
		else{
			$return='<input type="text" class="required dua" name="inumber_pilot2" id="inumber_pilot2" size="2" value="'.$row['inumber_pilot2'].'" style="text-align: right;" onkeypress="return isNumberKey(event)" /> ';
		}
		return $return;
			
	}
	function updateBox_product_trial_basic_formula_istabilita3($name, $id, $value, $rowData) {
		$query = "select inumber_pabrik from plc2.plc2_upb_formula where ifor_id = '".$rowData['ifor_id']."'";
		$row = $this->db_plc0->query($query)->row_array();
		$queryp = "select * from plc2.plc2_upb_stabilita_pilot sp where sp.ipilot=3 and sp.iapppd=2 and sp.ifor_id='".$rowData['ifor_id']."'";
		$rowp = $this->db_plc0->query($queryp)->result_array();
		//print_r($rowp);
		//sementara tidak pake select tapi pake input text dulu
		// $return='<select name="inumber_pabrik" id="inumber_pabrik">';
		// foreach($rowp as $stabp){
			// if(is_null($row['inumber_pabrik'])){
				// $return.='<option value="'.$stabp['inumber'].'">'.$stabp['inumber'].'</option>';
			// }
			// else{
				// if($stabp['inumber']==$row['inumber_pabrik']){
					// $return.='<option value="'.$stabp['inumber'].'" selected>'.$stabp['inumber'].'</option>';
				// }
				// else{
					// $return.='<option value="'.$stabp['inumber'].'">'.$stabp['inumber'].'</option>';
				// }
			// }
			
		// }
		// $return.='</select>';
		if(is_null($row['inumber_pabrik'])){
			$return='<input type="text" class="required dua" name="inumber_pabrik" id="inumber_pabrik" size="2" style="text-align: right;" onkeypress="return isNumberKey(event)" /> ';
		}
		else{
			$return='<input type="text" class="required dua" name="inumber_pabrik" id="inumber_pabrik" size="2" value="'.$row['inumber_pabrik'].'" style="text-align: right;" onkeypress="return isNumberKey(event)" /> ';
		}
		return $return;
	}
	
	function updateBox_product_trial_basic_formula_vrevisi($name, $id, $value) {
		if($value==''){$value='-';}
		return $value;
	}
	function updateBox_product_trial_basic_formula_iwithbasic($field, $id, $value, $rowData){
		$check=$value==1 ? 'checked' : '' ;
		$return='<input type="checkbox" id="'.$id.'_pilot" name="'.$id.'_pilot" value="1" class="checkbox" '.$check.'>Request BB untuk Pilot<br>
				<input type="checkbox" id="'.$id.'_MBR" name="'.$id.'_MBR" value="0" class="checkbox" checked onclick="return false;">Pembuatan Master Formula dan MBR';
		return $return;

	}
	function updateBox_product_trial_basic_formula_vhpp($name, $id, $value) {
		if($value==''){$value='-';}
		return $value;
	}

	function updateBox_product_trial_basic_formula_lblspesifikasi($field, $id, $value, $rowData){
		$return = '<script>
			$("label[for=\'product_trial_basic_formula_lblspesifikasi\']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"99%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase"});
		</script>';
		return $return;
	}
	function updateBox_product_trial_basic_formula_dmulai_spesifikasi($field, $id, $value, $rowData){
		//print_r($rowData);
		$value=date('d-m-Y',strtotime($rowData['dmulai_spesifikasi']));
		if(($value==NULL)||($value=='')||($value=='0000-00-00') || ($value =='01-01-1970')){
			$val='';
		}else{
			$val=$value;
		}
		if($this->input->get('action')=='view'){
			$return	=$val;
		}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
		}
		return $return;
	}
	function updateBox_product_trial_basic_formula_dselesai_spesifikasi($field, $id, $value, $rowData){
		//print_r($rowData);
		$value=date('d-m-Y',strtotime($rowData['dselesai_spesifikasi']));
		if(($value==NULL)||($value=='')||($value=='0000-00-00') || ($value =='01-01-1970')){
			$val='';
		}else{
			$val=$value;
		}
		if($this->input->get('action')=='view'){
			$return	=$val;
		}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
		}
		return $return;
	}
	
	function updateBox_product_trial_basic_formula_dupload_spesifikasi($field, $id, $value, $rowData){
		//print_r($rowData);
		$value=date('d-m-Y',strtotime($rowData['dupload_spesifikasi']));
		if(($value==NULL)||($value=='')||($value=='0000-00-00') || ($value =='01-01-1970')){
			$val='';
		}else{
			$val=$value;
		}
		if($this->input->get('action')=='view'){
			$return	=$val;
		}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
		}
		return $return;
	}

	function updateBox_product_trial_basic_formula_cPIC_spesifikasi($field, $id, $value, $rowData) {
		$url = base_url().'processor/plc/product/trial/basic/formula?action=getemployee';
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
			if(($value!=NULL)||($value!='')){
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
		
		return $return;
	}

	function updateBox_product_trial_basic_formula_file_spek($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		$idfor = $rowData['ifor_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_file_spesifikasi', array('ifor_id'=>$idfor,'ldeleted'=>'0'))->result_array();
		return $this->load->view('product_trial_basic_formula_file_spek',$data,TRUE);
	}
	

	function before_update_processor($row, $postData) {
	
		if($postData['isdraft']==true){
			$postData['isubmit_basic']=0;
		} 
		else{$postData['isubmit_basic']=1;} 
		$j=0;
		if(isset($postData['iwithbasic_pilot'])){
			$j=$postData['iwithbasic_pilot'];
		}
		$postData['iwithbasic']=$j;

		$postData['dmulai_basic']=date("Y-m-d", strtotime($postData['dmulai_basic']));
		$postData['dselesai_basic']=date("Y-m-d", strtotime($postData['dselesai_basic']));
		$postData['dupload_basic']=date("Y-m-d", strtotime($postData['dupload_basic']));
		$postData['dmulai_spesifikasi']=date("Y-m-d", strtotime($postData['dmulai_spesifikasi']));
		$postData['dselesai_spesifikasi']=date("Y-m-d", strtotime($postData['dselesai_spesifikasi']));
		$postData['dupload_spesifikasi']=date("Y-m-d", strtotime($postData['dupload_spesifikasi']));
		$postData['tberlaku']=date('Y-m-d H:i:s');

		unset($postData['vkode_surat']);
		unset($postData['vfile_basic']);
		unset($postData['vnip_formulator']);
		unset($postData['vbasic_nip_apppd']);
		unset($postData['product_trial_basic_formula_dmulai_basic']);
		unset($postData['product_trial_basic_formula_dselesai_basic']);
		unset($postData['product_trial_basic_formula_cPIC_basic_text']);
		unset($postData['product_trial_basic_formula_dupload_basic']);
		unset($postData['product_trial_basic_formula_dmulai_basic']);
		unset($postData['product_trial_basic_formula_dmulai_spesifikasi']);
		unset($postData['product_trial_basic_formula_dselesai_spesifikasi']);
		unset($postData['product_trial_basic_formula_dupload_spesifikasi']);
		unset($postData['product_trial_basic_formula_cPIC_spesifikasi_text']);
		
		return $postData;
	}
	
	function after_update_processor($r, $updateId, $postData) {
		//print_r($postData);exit();
		//$iupb_id=$postData['iupb_id'];
		//if($postData['isubmit_basic']==1){
		//	$this->lib_flow->insert_logs($this->input->get('modul_id'),$iupb_id,6);
		//}
		//print_r($postData);
		// if(isset($postData['stabilita1']) && $postData['stabilita1'] != '') {
			// //print_r($postData); exit();
			// $sta['ifor_id'] = $updateId;
			// $sta['inumber'] = 0;
			// $sta['ipilot'] = 1;
			// $sta['vbatch'] = $postData['vbatchpilot1'];
			// $sta['tdate'] = to_mysql($postData['stabilita1']);
			// if($this->db_plc0->insert('plc2.plc2_upb_stabilita_pilot', $sta)) {
				// $id = $this->db_plc0->insert_id();
				// $sql = "UPDATE plc2.plc2_upb_formula SET inumber_pilot1 = '0' WHERE ifor_id='".$updateId."'";
				// if($this->db_plc0->query($sql)) {
					// $query = "select ispekfg_id from plc2.plc2_upb_formula where ifor_id='".$updateId."'";
			        // $row = $this->db_plc0->query($query)->row_array();
					// $spekfgId = $row['ispekfg_id'];					
					// $query = "select vspesifikasi, vvalue from plc2.plc2_upb_spesifikasi_fg_sediaan where ldeleted=0 and istabilita = 2 and ispekfg_id='".$spekfgId."' order by iurut";
			        // $rows = $this->db_plc0->query($query)->result_array();
					// foreach($rows as $row){
			            // $spesifikasi = $row['vspesifikasi'];
			            // $value = $row['vvalue'];
			            
			            // $query = "insert into plc2.plc2_upb_stabilita_pilot_item (istai_id, ista_id, vparam, vsyarat) values (default, $id, '{$spesifikasi}', '{$value}')";
						// $this->db_plc0->query($query);
			        // }
				// }
			// }
		// }
		// if(isset($postData['stabilita2']) && $postData['stabilita2'] != '') {
			// //print_r($postData); exit();
			// $sta['ifor_id'] = $updateId;
			// $sta['inumber'] = 0;
			// $sta['ipilot'] = 2;
			// $sta['vbatch'] = $postData['vbatchpilot2'];
			// $sta['tdate'] = to_mysql($postData['stabilita2']);
			// if($this->db_plc0->insert('plc2.plc2_upb_stabilita_pilot', $sta)) {
				// $id = $this->db_plc0->insert_id();
				// $sql = "UPDATE plc2.plc2_upb_formula SET inumber_pilot2 = '0' WHERE ifor_id='".$updateId."'";
				// if($this->db_plc0->query($sql)) {
					// $query = "select ispekfg_id from plc2.plc2_upb_formula where ifor_id='".$updateId."'";
			        // $row = $this->db_plc0->query($query)->row_array();
					// $spekfgId = $row['ispekfg_id'];					
					// $query = "select vspesifikasi, vvalue from plc2.plc2_upb_spesifikasi_fg_sediaan where ldeleted=0 and istabilita = 2 and ispekfg_id='".$spekfgId."' order by iurut";
			        // $rows = $this->db_plc0->query($query)->result_array();
					// foreach($rows as $row){
			            // $spesifikasi = $row['vspesifikasi'];
			            // $value = $row['vvalue'];
			            
			            // $query = "insert into plc2.plc2_upb_stabilita_pilot_item (istai_id, ista_id, vparam, vsyarat) values (default, $id, '{$spesifikasi}', '{$value}')";
						// $this->db_plc0->query($query);
			        // }
				// }
			// }
		// }
		// if(isset($postData['stabilita3']) && $postData['stabilita3'] != '') {
			// //print_r($postData); exit();
			// $sta['ifor_id'] = $updateId;
			// $sta['inumber'] = 0;
			// $sta['ipilot'] = 3;
			// $sta['vbatch'] = $postData['vbatchpabrik'];
			// $sta['tdate'] = to_mysql($postData['stabilita3']);
			// if($this->db_plc0->insert('plc2.plc2_upb_stabilita_pilot', $sta)) {
				// $id = $this->db_plc0->insert_id();
				// $sql = "UPDATE plc2.plc2_upb_formula SET inumber_pabrik = '0' WHERE ifor_id='".$updateId."'";
				// if($this->db_plc0->query($sql)) {
					// $query = "select ispekfg_id from plc2.plc2_upb_formula where ifor_id='".$updateId."'";
			        // $row = $this->db_plc0->query($query)->row_array();
					// $spekfgId = $row['ispekfg_id'];					
					// $query = "select vspesifikasi, vvalue from plc2.plc2_upb_spesifikasi_fg_sediaan where ldeleted=0 and istabilita = 2 and ispekfg_id='".$spekfgId."' order by iurut";
			        // $rows = $this->db_plc0->query($query)->result_array();
					// foreach($rows as $row){
			            // $spesifikasi = $row['vspesifikasi'];
			            // $value = $row['vvalue'];
			            
			            // $query = "insert into plc2.plc2_upb_stabilita_pilot_item (istai_id, ista_id, vparam, vsyarat) values (default, $id, '{$spesifikasi}', '{$value}')";
						// $this->db_plc0->query($query);
			        // }
				// }
			// }
		// }
			// $inumber_pilot1=$postData['inumber_pilot1'];
			// $inumber_pilot2=$postData['inumber_pilot2'];
			// $inumber_pabrik=$postData['inumber_pabrik'];
			
			// $q1="select * from plc2.plc2_upb_stabilita_pilot p where p.ipilot=1 and p.ifor_id='".$updateId."' and p.inumber='".$inumber_pilot1."'";
			// $row1 = $this->db_plc0->query($q1)->row_array();
			// $vbatch1=$row1['vbatch'];
				
			// $q2="select * from plc2.plc2_upb_stabilita_pilot p where p.ipilot=2 and p.ifor_id='".$updateId."' and p.inumber='".$inumber_pilot2."'";
			// $row2 = $this->db_plc0->query($q2)->row_array();
			// $vbatch2=$row2['vbatch'];
			
			// $q3="select * from plc2.plc2_upb_stabilita_pilot p where p.ipilot=3 and p.ifor_id='".$updateId."' and p.inumber='".$inumber_pabrik."'";
			// $row3 = $this->db_plc0->query($q3)->row_array();
			// $vbatch3=$row3['vbatch'];
			
			// $sql1 = "UPDATE plc2.plc2_upb_formula SET inumber_pilot1 = '".$inumber_pilot1."', vbatchpilot1='".$vbatch1."', inumber_pilot2 = '".$inumber_pilot2."', vbatchpilot2='".$vbatch2."', inumber_pabrik = '".$inumber_pabrik."', vbatchpabrik='".$vbatch3."' WHERE ifor_id='".$updateId."'";
			// $this->db_plc0->query($sql1);
			/*
			$iupb_id=$postData['iupb_id'];
			$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
			$hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,7); // status 7 => submit
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//update last log
					$this->biz_process->update_last_log($iupb_id, $bizsup, 7);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($iupb_id, $bizsup, 7);
			}*/	
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
