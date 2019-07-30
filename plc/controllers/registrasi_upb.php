<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Registrasi_upb extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->load->helper('to_mysql');
		$this->user = $this->auth_localnon->user();
		$this->load->library('lib_utilitas');
		$this->dbset = $this->load->database('plc', true); 
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('Registrasi UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('registrasi_upb');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik','ttarget_hpr','tspb','iappbusdev_registrasi');
		$grid->setSortBy('vupb_nomor');
		$grid->setSortOrder('desc');
		$grid->addFields('vupb_nomor','vupb_nama','vgenerik','iteambusdev_id','tsubmit_prareg');
		$grid->addFields('ttarget_hpr','tspb','tregistrasi','tbayar_reg','vnie','ttarget_noreg','vfileregistrasi','vnip_appbusdev_registrasi');
		//$grid->addFields('vupb_nomor','vupb_nama','vgenerik','iteambusdev_id','ttarget_hpr','tterima_hpr','tspb');
		//$grid->addFields('tbayar_reg','dmulai_reg','tterima_noreg','tTd_applet','tsubmit_dokapplet','tsubmit_tdApplet','ttarget_noreg','vnoreg','vfileregistrasi','dokumen','history_td','tambahan_data','vnip_appbusdev_registrasi');
		//$grid->addFields('vupb_nomor','vupb_nama','vgenerik','iteambusdev_id','ttarget_hpr','tterima_hpr','icap_lengkap','dcap_lengkap','tspb');
		//$grid->addFields('tbayar_reg','dmulai_reg','ttarget_noreg','tterima_noreg','vnoreg','vfileregistrasi','dokumen','vnip_appbusdev_registrasi');
		
		$grid->setFormUpload(TRUE);
		// $grid->changeFieldType('vfileregistrasi','upload');
		// $grid->setUploadPath('vfileregistrasi', './files/plc/registrasi_doc/');
		// $grid->setAllowedTypes('vfileregistrasi', 'gif|jpg|png|jpeg|pdf');
		// $grid->setMaxSize('vfileregistrasi', '1000');	
		
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('cnip','NIP');
		$grid->setLabel('employee.vName','Nama');
		$grid->setLabel('vnoreg','No. Registrasi');
		$grid->setLabel('ttanggal','Tanggal UPB');
		$grid->setLabel('tindikasi','Indikasi');
		$grid->setLabel('ikategori_id','Kategori Produk');
		$grid->setLabel('isediaan_id','Sediaan Produk');
		$grid->setLabel('itipe_id','Tipe Produk');
		$grid->setLabel('ipatent','Tipe hak paten');
		$grid->setLabel('ibe','Tipe BE');
		$grid->setLabel('vhpp_target','Target HPP');
		$grid->setLabel('tunique','Keunggulan Produk');
		$grid->setLabel('tpacking','Spesifikasi Kemasan');
		$grid->setLabel('iteambusdev_id','Team Busdev');
		$grid->setLabel('iteampd_id','PD');
		$grid->setLabel('iteamqa_id','QA');
		$grid->setLabel('iteamqc_id','QC');
		$grid->setLabel('iteammarketing_id','Marketing');
		$grid->setLabel('iregister','Registrasi untuk');
		$grid->setLabel('idevelop','Produksi oleh');
		$grid->setLabel('tmemo_date','Tanggal Launching');
		$grid->setLabel('tterimabb_date','Perkiraan Terima Bahan Baku');
		$grid->setLabel('tterimabk_date','Perkiraan Terima Bahan Kemas');
		$grid->setLabel('tmemo','Memo launching');
		$grid->setLabel('fmemolaunchingfile','Memo launching File');
		$grid->setLabel('cnip','NIP');
		$grid->setLabel('tsubmit_prareg','Tanggal Prareg');
		$grid->setLabel('ttarget_noreg','Target Terima No. Registrasi');
		$grid->setLabel('tterima_noreg','Terima No. Registrasi');
		$grid->setLabel('tterima_hpr','Tanggal HPR II');
		$grid->setLabel('ttarget_hpr','Tanggal HPR');
		$grid->setLabel('vnie','NIE');
		// $grid->setLabel('icap_lengkap','Cap Lengkap');
		// $grid->setLabel('dcap_lengkap','Tanggal Cap Lengkap');
		$grid->setLabel('tspb','Tanggal SPB');
		$grid->setLabel('tbayar_reg','Tanggal Pembayaran oleh FA');
		$grid->setLabel('dmulai_reg','Tanggal Submit Dokumen');
		$grid->setLabel('tregistrasi','Tanggal Registrasi');
		//$grid->setLabel('ttarget_noreg','Tanggal No Reg I (BPOM)');
		$grid->setLabel('ttarget_noreg','Tanggal NIE');
		//$grid->setLabel('tterima_noreg','Tanggal No Registrasi/NIE');
		$grid->setLabel('tterima_noreg','Tanggal Approvable Letter');
		$grid->setLabel('tsubmit_dokapplet','Tanggal Submit Dok AppLet');
		$grid->setLabel('tsubmit_tdApplet','Tanggal Submit Tambahan Data AppLet');
		$grid->setLabel('tTd_applet','Tanggal Tambahan Data Dok AppLet');
		$grid->setLabel('vnoreg','No Izin Edar(No. Registrasi)');
		$grid->setLabel('vfileregistrasi','File Registrasi');
		$grid->setLabel('history_td','History Tambahan Data');
		$grid->setLabel('tambahan_data','Tambahan Data');
		$grid->setLabel('iappbusdev_registrasi','Approval Busdev');
		$grid->setLabel('vnip_appbusdev_registrasi','Approval Busdev');
		$grid->setSearch('vupb_nomor','vupb_nama','vgenerik');
		$grid->setRequired('vnegara','vnmnegara','vkode','ldeleted','vnie');
		
		
		//$grid->setQuery('plc2_upb.ispekpd', 2);
        $grid->setQuery('plc2_upb.iappdireksi', 2);
        //$grid->setQuery('plc2_upb.iappbusdev_prareg', 2); sudah approve prareg diganti sudah approve setting prioritas reg
		/*$grid->setQuery('iupb_id in (select pd.iupb_id from plc2.plc2_upb_prioritas_reg_detail pd 
												inner join plc2.plc2_upb_prioritas_reg pr on pr.iprioritas_id=pd.iprioritas_id
										where pd.ldeleted=0 and pr.iappbusdev=2 )',null); //sdh app setting prioritas reg
		*/
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

        $grid->setQuery('plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2_upb.ihold', 0);

		//New Parameter For PLC Non OTC
		$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2.plc2_upb.iKill', 0);
		$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
		$grid->setQuery('plc2_upb.ihold', 0);

		//prareg utk team nya sendiri
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
		$grid->setQuery('iupb_id in (select f.iupb_id from plc2.plc2_upb_formula f where f.iapppd_basic=2 and f.ldeleted=0)',null); 
		// upb yg bisa dipilih hanya upb yg pny bahan kemas yg di approve
		$grid->setQuery('iupb_id in (select f.iupb_id from plc2.plc2_upb_bahan_kemas f where f.iappbd=2 and f.ldeleted=0)',null); 
		
        		
		$grid->changeFieldType('icap_lengkap','combobox','',array(0=>'Tidak Lengkap', 2=>'Lengkap'));
		
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
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				// echo $_POST['tTD_AppLet_td'];
					//print_r($_POST);
				//echo $this->input->get('lastId');
				$isUpload = $this->input->get('isUpload');
				$sql = array();
   				$file_name= "";
				$fileId = array();
				$sqltd = array();
   				$file_nametd= "";
				$fileIdtd = array();
				
				$path = realpath("files/plc/registrasi_doc");
				$pathtd = realpath("files/plc/dok_td");
				
				if (!file_exists( $path."/".$this->input->post('registrasi_upb_iupb_id'))) {
					mkdir($path."/".$this->input->post('registrasi_upb_iupb_id'), 0777, true);						 
				}
												
				$file_keterangan = array();
				$file_keterangantd = array();
				
				foreach($_POST as $key=>$value) {
											
					if ($key == 'fileketerangan') {
						foreach($value as $y=>$u) {
							$file_keterangan[$y] = $u;
						}
					}
					if ($key == 'namafile') {
						foreach($value as $k=>$v) {
							$file_name[$k] = $v;
						}
					}
					if ($key == 'fileid') {
						foreach($value as $k=>$v) {
							$fileId[$k] = $v;
						}
					}
					//tambahan data
					if ($key == 'fileketerangantd') {
						foreach($value as $y=>$u) {
							$file_keterangantd[$y] = $u;
						}
					}
					if ($key == 'namafiletd') {
						foreach($value as $k=>$v) {
							$file_nametd[$k] = $v;
						}
					}
					if ($key == 'fileidtd') {
						foreach($value as $k=>$v) {
							$fileIdtd[$k] = $v;
						}
					}
				}
				
				$last_index = 0;
				$last_indextd = 0;
				
				if($isUpload) {
					$j = $last_index;						
					if (isset($_FILES['fileupload'])) {
						//echo "aa";
						//exit;
						$this->hapusfile($path, $file_name, 'plc2_upb_file_registrasi', $this->input->post('registrasi_upb_iupb_id'),'iupb_id');
						foreach ($_FILES['fileupload']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
								$name = $_FILES['fileupload']["name"][$key];
								$data['filename'] = $name;
								$data['id']=$this->input->post('registrasi_upb_iupb_id');
								$data['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name, $path."/".$this->input->post('registrasi_upb_iupb_id')."/".$name)) 
				 				{
									$sql[] = "INSERT INTO plc2_upb_file_registrasi (iupb_id, filename, dInsertDate, vKeterangan, cInsert) 
										VALUES ('".$data['id']."', '".$data['filename']."','".$data['dInsertDate']."','".$file_keterangan[$j]."','".$data['nip']."')";
								//print_r($sql);
								$j++;																			
								}
								else{
								echo "Upload ke folder gagal";	
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
					
					//tambahan data
					$k = $last_indextd;						
					if (isset($_FILES['fileuploadtd'])) {
						//send email
							$iupb_id=$this->input->post('registrasi_upb_iupb_id');
							$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
									u.iteambusdev_id as bd,
									u.iteampd_id as pd,
									u.iteamqa_id as qa,
									u.iteamqc_id as qc
									from plc2.plc2_upb u where u.iupb_id='$iupb_id'";
							$rupb = $this->db_plc0->query($qupb)->row_array();
							//echo $qupb;
							$pdteam=$rupb['pd'];
							$qateam=$rupb['qa'];
							$qcteam=$rupb['qc'];
						//insert tambahan table tambahan data
							$nip = $this->user->gNIP;
							$skg=date('Y-m-d H:i:s');
							$smd['iupb_id'] = $this->input->post('registrasi_upb_iupb_id');
							$smd['tTamb_Data_td'] = to_mysql($_POST['tTamb_Data_td']);
							$smd['tSub_TD_td'] = to_mysql($_POST['tSub_TD_td']);
							$smd['tSub_Dok_AppLet_td'] = to_mysql($_POST['tSub_Dok_AppLet_td']);
							$smd['tTD_AppLet_td'] = to_mysql($_POST['tTD_AppLet_td']);
							$smd['dUpdateDate'] = $skg;
							$smd['cUpdated'] = $nip;
							$this->db_plc0->insert('plc2.plc2_upb_reg_td', $smd);
							$id_td=$this->db_plc0->insert_id();
							//echo ' id table td= '.$this->db_plc0->insert_id();
							//exit();
						//end insert table tambahan data
						
						//insert detail tambahan data (divisinya)
							if(isset($_POST['divPR'])){
								$pr['id_td'] = $id_td;
								$pr['vDivisi_tujuan'] = $_POST['divPR'];
								$pr['vCatatan'] = $_POST['notePR'];
								$pr['dUpdateDate'] = $skg;
								$pr['cUpdated'] = $nip;
								$this->db_plc0->insert('plc2.plc2_upb_reg_td_detail', $pr);
							}
							if(isset($_POST['divAD'])){
								$ad['id_td'] = $id_td;
								$ad['vDivisi_tujuan'] = $_POST['divAD'];
								$ad['vCatatan'] = $_POST['noteAD'];
								$ad['dUpdateDate'] = $skg;
								$ad['cUpdated'] = $nip;
								$this->db_plc0->insert('plc2.plc2_upb_reg_td_detail', $ad);
							}
							if(isset($_POST['divPD'])){
								$pd['id_td'] = $id_td;
								$pd['vDivisi_tujuan'] = $_POST['divPD'];
								$pd['vCatatan'] = $_POST['notePD'];
								$pd['dUpdateDate'] = $skg;
								$pd['cUpdated'] = $nip;
								$this->db_plc0->insert('plc2.plc2_upb_reg_td_detail', $pd);
							}
							if(isset($_POST['divQA'])){
								$qa['id_td'] = $id_td;
								$qa['vDivisi_tujuan'] = $_POST['divQA'];
								$qa['vCatatan'] = $_POST['noteQA'];
								$qa['dUpdateDate'] = $skg;
								$qa['cUpdated'] = $nip;
								$this->db_plc0->insert('plc2.plc2_upb_reg_td_detail', $qa);
							}
							if(isset($_POST['divQC'])){
								$qc['id_td'] = $id_td;
								$qc['vDivisi_tujuan'] = $_POST['divQC'];
								$qc['vCatatan'] = $_POST['noteQC'];
								$qc['dUpdateDate'] = $skg;
								$qc['cUpdated'] = $nip;
								$this->db_plc0->insert('plc2.plc2_upb_reg_td_detail', $qc);
							}
							if(isset($_POST['divQAM'])){
								$qam['id_td'] = $id_td;
								$qam['vDivisi_tujuan'] = $_POST['divQAM'];
								$qam['vCatatan'] = $_POST['noteQAM'];
								$qam['dUpdateDate'] = $skg;
								$qam['cUpdated'] = $nip;
								$this->db_plc0->insert('plc2.plc2_upb_reg_td_detail', $qam);
							}
							if(isset($_POST['divPDV'])){
								$pdv['id_td'] = $id_td;
								$pdv['vDivisi_tujuan'] = $_POST['divPDV'];
								$pdv['vCatatan'] = $_POST['notePDV'];
								$pdv['dUpdateDate'] = $skg;
								$pdv['cUpdated'] = $nip;
								$this->db_plc0->insert('plc2.plc2_upb_reg_td_detail', $pdv);
							}
						
						//send email notifikasi
						
						//$to = "";
						$toPD="";
						$toQA="";
						$toQC="";
						$cc = "";
						
						if((isset($_POST['divAD'])) ||(isset($_POST['divPD'])) ||(isset($_POST['divPDV'])) ||(isset($_POST['divQAM']))){
							$qemailPD="select e.vEmail from hrd.employee e 
										where e.cNip in (select te.vnip from plc2.plc2_upb_team te where te.iteam_id=$pdteam) 
										or e.cNip in (select ti.vnip from plc2.plc2_upb_team_item ti where ti.iteam_id=$pdteam and ti.ldeleted=0)";
							$remailPD = $this->db_plc0->query($qemailPD)->result_array();
							foreach($remailPD as $toemailPD){
								$toPD.=$toemailPD['vEmail'].', ';
							}
							//send email PD
							$subjectPD="Tambahan Data UPB ".$rupb['vupb_nomor']." ( ".$rupb['vupb_nama']." )";
							$contentPD="
								Diberitahukan kepada Departemen PD bahwa ada tambahan dokumen untuk Registrasi UPB, pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
										<tr><td></td><td></td></tr><tr><td></td><td></td></tr><tr><td></td><td></td></tr>
										<tr><td colspan='3'>Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
								Post Master</td></tr>
								</table>
								</div>
								<br/>";
							$this->lib_utilitas->send_email($toPD, $cc, $subjectPD, $contentPD);
						}
						elseif(isset($_POST['divPR'])){
							//$to.="Rugun.Clara-gp@novellpharm.com; tika@novellpharm.com"; //PR
							$toPR = "dinny.rachma@novellpharm.com";
							//send email PR
							$subjectPR="Tambahan Data UPB ".$rupb['vupb_nomor']." ( ".$rupb['vupb_nama']." )";
							$contentPR="
								Diberitahukan kepada Departemen PR bahwa ada tambahan dokumen untuk Registrasi UPB, pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
										<tr><td></td><td></td></tr><tr><td></td><td></td></tr><tr><td></td><td></td></tr>
										<tr><td colspan='3'>Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
								Post Master</td></tr>
								</table>
								</div>
								<br/>";
							$this->lib_utilitas->send_email($toPR, $cc, $subjectPR, $contentPR);
						}
						elseif(isset($_POST['divQC'])){
							$qemailQC="select e.vEmail from hrd.employee e 
										where e.cNip in (select te.vnip from plc2.plc2_upb_team te where te.iteam_id=$qcteam) 
										or e.cNip in (select ti.vnip from plc2.plc2_upb_team_item ti where ti.iteam_id=$qcteam and ti.ldeleted=0)";
							$remailQC = $this->db_plc0->query($qemailQC)->result_array();
							foreach($remailQC as $toemailQC){
								$toQC.=$toemailQC['vEmail'].', ';
							}
							//send email QC
							$subjectQC="Tambahan Data UPB ".$rupb['vupb_nomor']." ( ".$rupb['vupb_nama']." )";
							$contentQC="
								Diberitahukan kepada Departemen QC bahwa ada tambahan dokumen untuk Registrasi UPB, pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
										<tr><td></td><td></td></tr><tr><td></td><td></td></tr><tr><td></td><td></td></tr>
										<tr><td colspan='3'>Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
								Post Master</td></tr>
								</table>
								</div>
								<br/>";
							$this->lib_utilitas->send_email($toQC, $cc, $subjectQC, $contentQC);
						}
						elseif(isset($_POST['divQA'])){
							$qemailQA="select e.vEmail from hrd.employee e 
										where e.cNip in (select te.vnip from plc2.plc2_upb_team te where te.iteam_id=$qateam) 
										or e.cNip in (select ti.vnip from plc2.plc2_upb_team_item ti where ti.iteam_id=$qateam and ti.ldeleted=0)";
							$remailQA = $this->db_plc0->query($qemailQA)->result_array();
							foreach($remailQA as $toemailQA){
								$toQA.=$toemailQA['vEmail'].', ';
							}
							//send email QA
							$subjectQA="Tambahan Data UPB ".$rupb['vupb_nomor']." ( ".$rupb['vupb_nama']." )";
							$contentQA="
								Diberitahukan kepada Departemen QA bahwa ada tambahan dokumen untuk Registrasi UPB, pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
										<tr><td></td><td></td></tr><tr><td></td><td></td></tr><tr><td></td><td></td></tr>
										<tr><td colspan='3'>Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
								Post Master</td></tr>
								</table>
								</div>
								<br/>";
							$this->lib_utilitas->send_email($toQA, $cc, $subjectQA, $contentQA);
						}
						
						
						//end send email notifikasi
						//end insert detail tambahan data
						if (!file_exists( $pathtd."/".$id_td)) {
							mkdir($pathtd."/".$id_td, 0777, true);						 
						}
						$this->hapusfile($pathtd, $file_nametd, 'plc2_upb_file_reg_td', $id_td,'id_td');
						foreach ($_FILES['fileuploadtd']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_nametd = $_FILES['fileuploadtd']["tmp_name"][$key];
								$nametd = $_FILES['fileuploadtd']["name"][$key];
								$datatd['filename'] = $nametd;
								$datatd['id']=$id_td;
								$datatd['nip']=$this->user->gNIP;
								$datatd['dInsertDate'] = date('Y-m-d H:i:s');
				 				if(move_uploaded_file($tmp_nametd, $pathtd."/".$id_td."/".$nametd)) 
				 				{
									$sqltd[] = "INSERT INTO plc2_upb_file_reg_td (id_td, filename, dInsertDate, cInsert) 
										VALUES ('".$datatd['id']."', '".$datatd['filename']."','".$datatd['dInsertDate']."','".$datatd['nip']."')";
									$k++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
							
						}
					//print_r($sqltd);
						foreach($sqltd as $qtd) {
							try {
								$this->dbset->query($qtd);
							}catch(Exception $e) {
								die($e);
							}
						}
					}	
					$r['message']="Data Berhasil Disimpan!";	
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->post('registrasi_upb_iupb_id');					
					echo json_encode($r);
					exit();
				}  else {
						
					// if (is_array($file_name)) {									
						// $this->hapusfile($path, $file_name, 'plc2_upb_file_registrasi', $this->input->post('registrasi_upb_iupb_id'),'iupb_id');
					// }
					// if (is_array($file_nametd)) {									
						// $this->hapusfile($pathtd, $file_nametd, 'plc2_upb_file_reg_td', $id_td,'id_td');
					// }
													
					echo $grid->updated_form();
				}
				break;
			case 'delete':
				echo $grid->delete_row();
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
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();

				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$this->db_plc0->where('iupb_id', $post['iupb_id']);
				$this->db_plc0->update('plc2.plc2_upb', array('iappbusdev_registrasi'=>2,'vnip_appbusdev_registrasi'=>$nip,'tappbusdev_registrasi'=>$skg));
		    
				$upb_id=$post['iupb_id'];
				
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

		        $team = $pd. ','.$bd ;
		        
		        $toEmail2='';
		        $toEmail = $this->lib_utilitas->get_email_team( $bd );
		        $toEmail2 = $this->lib_utilitas->get_email_leader( $bd );                        

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
		        
				$subject="Proses Registrasi Selesai : UPB ".$rupb['vupb_nomor']." ( ".$rupb['vupb_nama']." )";
				$content="
					Diberitahukan bahwa telah ada approval Registrasi UPB oleh Busdev Manager pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
		                         <td><b>Proses Selanjutnya</b></td><td> : </td><td>Launching Product - Input data oleh Busdev</td>
		                    </tr>                    
						</table>
					</div>
					<br/> 
					Demikian. Terimakasih.<br><br><br>
					Post Master";
		            
		        /*echo  $to;
		        echo '</br>cc:' .$cc;      
		        echo  $content ;    
		        exit ;   */
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

	function listBox_Action($row, $actions) {
		//print_r($row);
	    if($row->iappbusdev_registrasi<>0){
	    	unset($actions['delete']);
	    	unset($actions['edit']);
	    }
	    return $actions; 
	}
	function manipulate_update_button($buttons, $rowData) {
    	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			unset($buttons['update_back']);
			unset($buttons['update']);
		//print_r($rowData);
		//echo $rowData['vnip_formulator']."<br>".$this->user->gNIP;
    	$user = $this->auth_localnon->user();
		$js = $this->load->view('registrasi_upb_js');
		$js .= $this->load->view('uploadjs');
    	$x=$this->auth_localnon->dept();
    	if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		if(in_array('BD', $manager)){$type='BD';}
    		else{$type='';}
    	}
		else{
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('BD', $team)){$type='BD';}
			else{$type='';}
		}
		
		//echo $type;
		// cek status upb, klao upb 
			unset($buttons['update_back']);
    		unset($buttons['update']);
			
			//echo $this->auth_localnon->my_teams();
			$upb_id=$rowData['iupb_id'];
			
			// print_r($rowData);exit();
    		
			$x=$this->auth_localnon->my_teams();
			if($this->auth_localnon->is_manager()){ //jika manager PR
				if(($type=='BD')&&($rowData['iappbusdev_registrasi']==0)){
					$update = '<button onclick="javascript:update_btn_back(\'registrasi_upb\', \''.base_url().'processor/plc/registrasi/upb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_reg_upb">Update</button>';
					$cNip=$this->user->gNIP;
					$sql= "select * from plc2.plc2_upb up where up.iupb_id=".$rowData['iupb_id'];
					$dt=$this->dbset->query($sql)->row_array();
					$setuju = '<button onclick="javascript:setuju(\'registrasi_upb\', \''.base_url().'processor/plc/registrasi/upb?action=confirm&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Confirm</button>';
					//$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/registrasi/upb?action=approve&upb_id='.$upb_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_reg_upb">Approve</button>';
					//$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/registrasi/upb?action=reject&upb_id='.$upb_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_reg_upb">Reject</button>';
						
					$buttons['update'] = $update.$setuju.$js;
				}
				else{}
			}
			else{
				if(($type=='BD')&&($rowData['iappbusdev_registrasi']==0)){
					$update = '<button onclick="javascript:update_btn_back(\'registrasi_upb\', \''.base_url().'processor/plc/registrasi/upb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_reg_upb">Update</button>';
						
					$buttons['update'] = $update.$js;
				}
				else{}
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
								var url = "'.base_url().'processor/plc/registrasi/upb";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_registrasi_upb").html(data);
									});
					
								}
									reload_grid("grid_registrasi_upb");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_registrasi_upb_approve" action="'.base_url().'processor/plc/registrasi/upb?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="upb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_registrasi_upb_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$this->db_plc0->where('iupb_id', $post['upb_id']);
		$this->db_plc0->update('plc2.plc2_upb', array('iappbusdev_registrasi'=>2,'vnip_appbusdev_registrasi'=>$nip,'tappbusdev_registrasi'=>$skg));
    
		$upb_id=$post['upb_id'];
		
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
		}*/
		//}
    	$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
                            (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
                            from plc2.plc2_upb u where u.iupb_id='".$post['upb_id']."'";
        $rupb = $this->db_plc0->query($qupb)->row_array();

        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id 
                from plc2.plc2_upb u where u.iupb_id='".$post['upb_id']."'";
        $rsql = $this->db_plc0->query($qsql)->row_array();

        //$query = $this->dbset->query($rsql);

        $pd = $rsql['iteampd_id'];
        $bd = $rsql['iteambusdev_id'];
        $qa = $rsql['iteamqa_id'];
        $qc = $rsql['iteamqc_id'];

        $team = $pd. ','.$bd ;
        
        $toEmail2='';
        $toEmail = $this->lib_utilitas->get_email_team( $bd );
        $toEmail2 = $this->lib_utilitas->get_email_leader( $bd );                        

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
        
		$subject="Proses Registrasi Selesai : UPB ".$rupb['vupb_nomor']." ( ".$rupb['vupb_nama']." )";
		$content="
			Diberitahukan bahwa telah ada approval Registrasi UPB oleh Busdev Manager pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
                         <td><b>Proses Selanjutnya</b></td><td> : </td><td>Launching Product - Input data oleh Busdev</td>
                    </tr>                    
				</table>
			</div>
			<br/> 
			Demikian. Terimakasih.<br><br><br>
			Post Master";
            
        /*echo  $to;
        echo '</br>cc:' .$cc;      
        echo  $content ;    
        exit ;   */
		$this->lib_utilitas->send_email($to, $cc, $subject, $content);
        
		$data['status']  = true;
    	$data['last_id'] = $upb_id;
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
								var url = "'.base_url().'processor/plc/registrasi/upb";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_registrasi_upb").html(data);
									});
					
								}
									reload_grid("grid_registrasi_upb");
							}
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_registrasi_upb_reject" action="'.base_url().'processor/plc/registrasi/upb?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="upb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea><button type="button" onclick="submit_ajax(\'form_regitrasi_upb_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process () {
    	$post = $this->input->post();
    	$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
	 	$this->db_plc0->where('iupb_id', $post['upb_id']);
		$this->db_plc0->update('plc2.plc2_upb', array('iappbusdev_registrasi'=>1,'vnip_appbusdev_registrasi'=>$nip,'tappbusdev_registrasi'=>$skg));
    
		$upb_id = $post['upb_id'];
		
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
    	$data['last_id'] = $upb_id;
    	return json_encode($data);
    }
	// public function listBox_Action($row, $actions) {
		// //print_r($row);
		// if($this->auth_localnon->is_manager()){
			// $teams = $this->auth_localnon->tipe();
			// $man=$teams['manager'];
			// if(in_array('BD',$man) && ($row->iappbusdev_registrasi)==0){}
			// else{
				// unset($actions['edit']);
				// unset($actions['delete']);
			// }
		// }
		// else{
				// unset($actions['edit']);
				// unset($actions['delete']);
			// }
		// return $actions;
	// }
	function listBox_registrasi_upb_iappbusdev_registrasi($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	//Keterangan approval 
	function insertBox_registrasi_upb_vnip_appbusdev_registrasi($field, $id) {
		return '-';
	}
	function updateBox_registrasi_upb_vnip_appbusdev_registrasi($field, $id, $value, $rowData) {
		//print_r($rowData);
		//echo $rowData['vnip_appbusdev_registrasi'];
		if(($rowData['iappbusdev_registrasi'] <>0)){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_appbusdev_registrasi']))->row_array();
			if($rowData['iappbusdev_registrasi']==2){$st="Approved";}elseif($rowData['iappbusdev_registrasi']==1){$st="Rejected";
				// $rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// if(isset($rowa)){$reason=$rowa['treason'];}
				
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_appbusdev_registrasi'].' )'.' pada '.$rowData['tappbusdev_registrasi'];
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	//
	function updateBox_registrasi_upb_dokumen($field, $id, $value, $rowData) {
		$this->load->helper('search_array');
		$data['iupb_id'] = $rowData['iupb_id'];
		$data['bb'] = $rowData['txtDocBB'];
		$data['sm'] = $rowData['txtDocSM'];
		return $this->load->view('registrasi_upb_dokumen', $data, TRUE);
		
	}
	function updateBox_registrasi_upb_tambahan_data($field, $id, $value, $rowData) {
		$this->load->helper('search_array');
		$data['iupb_id'] = $rowData['iupb_id'];
		return $this->load->view('registrasi_upb_tambahanData', $data, TRUE);
	}
	function updateBox_registrasi_upb_history_td($field, $id, $value, $rowData) {
		 $this->load->helper('search_array');
		 $data['iupb_id'] = $rowData['iupb_id'];
		 return $this->load->view('registrasi_upb_histTD', $data, TRUE);
	}
	function updateBox_registrasi_upb_vfileregistrasi($field, $id, $value, $rowData) {
		$idspek = $rowData['iupb_id'];	
		//$this->db_plc0->where('ispekfg_id',$rowData['ispekfg_id']);
		//$this->db_plc0->where('ldeleted', 0);
		//$data['rows'] = $this->db_plc0->get('plc2.plc2_upb_file_spesifikasi_fg')->result_array();	
		//print_r($data);
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_registrasi', array('iupb_id'=>$idspek))->result_array();
		return $this->load->view('registrasi_upb_file',$data,TRUE);
	}
	// function updateBox_registrasi_upb_vfileregistrasi($field, $id, $value, $rowData) {
		// $input = '<input type="file" name="'.$id.'" id="'.$id.'" class="" size="50" />';
		// if($value != '') {
			// if (file_exists('./files/plc/registrasi_doc/'.$value)) {
				// $link = base_url().'processor/plc/registrasi/upb?action=download&file='.$value;
				// $linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			// }
			// else {
				// $linknya = 'File sudah tidak ada!';
			// }
			// return 'File name : '.$value.' ['.$linknya.']<br />'.$input;
		// }
		// else {
			// return 'No File<br />'.$input;
		// }		
	// }

	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$dok = $_GET['dok'];
		$path = file_get_contents('./files/plc/'.$dok.'/'.$id.'/'.$name);
		force_download($name, $path);
	}
	function updateBox_registrasi_upb_vupb_nomor($name, $id, $value) {
		return $value;
	}
	function updateBox_registrasi_upb_vupb_nama($name, $id, $value) {
		return $value;
	}
	function updateBox_registrasi_upb_vgenerik($name, $id, $value) {
		return $value;
	}
	function updateBox_registrasi_upb_tsubmit_prareg($name, $id, $value) {
		return $value;
	}
	function updateBox_registrasi_upb_iteambusdev_id($name, $id, $value) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$value))->row_array();
		return $row['vteam'];
	}

	// function updateBox_registrasi_upb_dcap_lengkap($name, $id, $value) {
		// $this->load->helper('to_mysql');
		// $val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		// return '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
	// }
	function updateBox_registrasi_upb_ttarget_hpr($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		return $val;
	}
	function updateBox_registrasi_upb_tregistrasi($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		if($this->input->get('action')=='view'){
				$return	=$val;
		}else{
		$return= '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
		}
		return $return;
	}
	function updateBox_registrasi_upb_tterima_hpr($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		if($this->input->get('action')=='view'){
				$return	=$val;
		}else{
		$return= '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
		}
		return $return;
	}
	
	function updateBox_registrasi_upb_tspb($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		if($this->input->get('action')=='view'){
				$return	=$val;
		}else{
		$return= '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
		}
		return $return;
	}
	
	function updateBox_registrasi_upb_tbayar_reg($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		if($this->input->get('action')=='view'){
				$return	=$val;
		}else{
		$return= '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
		}
		return $return;
	}

	function updateBox_registrasi_upb_dmulai_reg($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		if($this->input->get('action')=='view'){
				$return	=$val;
		}else{
		$return= '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
		}
		return $return;
	}
	
	function updateBox_registrasi_upb_ttarget_noreg($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		if($this->input->get('action')=='view'){
				$return	=$val;
		}else{
		$return= '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
		}
		return $return;
	}
	
	function updateBox_registrasi_upb_tterima_noreg($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		if($this->input->get('action')=='view'){
				$return	=$val;
		}else{
		$return= '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
		}
		return $return;
	}
	function updateBox_registrasi_upb_tTd_applet($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		if($this->input->get('action')=='view'){
				$return	=$val;
		}else{
		$return= '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
		}
		return $return;
	}
	function updateBox_registrasi_upb_tsubmit_dokapplet($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		if($this->input->get('action')=='view'){
				$return	=$val;
		}else{
		$return= '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
		}
		return $return;
	}
	function updateBox_registrasi_upb_tsubmit_tdApplet($name, $id, $value) {
		$this->load->helper('to_mysql');
		$val = $value == '0000-00-00' || $value == '' ? '' : to_mysql($value, TRUE);
		if($this->input->get('action')=='view'){
				$return	=$val;
		}else{
		$return= '<input type="text" class="input_tgl datepicker input_rows1" name="'.$name.'" value="'.$val.'" id="'.$id.'">';
		}
		return $return;
	}
	function before_update_processor($row, $post, $postData) {
		//print_r($postData);exit();
		// $divisi
		// if(isset($postData['divQA'])){echo "aa";} else{echo "bb";}
		
		$user = $this->auth_localnon->user();
		$this->load->helper('to_mysql');
		unset($postData['bbid']);
		unset($postData['smid']);
		unset($postData['okbb']);
		unset($postData['notebb']);
		unset($postData['oksm']);
		unset($postData['notesm']);
		// $postData['dcap_lengkap'] = to_mysql($postData['dcap_lengkap']);
		//$postData['ttarget_hpr'] = to_mysql($postData['ttarget_hpr']);
		$postData['tregistrasi'] = to_mysql($postData['tregistrasi']);
		//$postData['tterima_hpr'] = to_mysql($postData['tterima_hpr']);
		$postData['tspb'] = to_mysql($postData['tspb']);
		$postData['tbayar_reg'] = to_mysql($postData['tbayar_reg']);
		//$postData['dmulai_reg'] = to_mysql($postData['dmulai_reg']);
		//$postData['ttarget_noreg'] = to_mysql($postData['ttarget_noreg']);
		//$postData['tterima_noreg'] = to_mysql($postData['tterima_noreg']);
		//$postData['tsubmit_tdApplet'] = to_mysql($postData['tsubmit_tdApplet']);
		//$postData['tsubmit_dokapplet'] = to_mysql($postData['tsubmit_dokapplet']);
		//$postData['tTd_applet'] = to_mysql($postData['tTd_applet']);
		
		//$postData['vnoreg'] =$postData['registrasi_upb_vnoreg'];
		unset($postData['registrasi_upb_vnoreg']);
		$postData['iupb_id'] =$postData['registrasi_upb_iupb_id'];
		$postData['vnie'] =$postData['registrasi_upb_vnie'];
		unset($postData['registrasi_upb_iupb_id']);
		//unset($postData['registrasi_upb_icap_lengkap']);
		
		//print_r($postData);exit;
		return $postData;
	}
	
	/*function after_update_processor($row, $updateId, $postData) {
		//$bb = $postData['bbid'];
		//$sm = $postData['smid'];
		//$okbb = $postData['okbb'];
		$notebb = $postData['notebb'];
		$oksm = $postData['oksm'];
		$notesm = $postData['notesm'];
		$this->db_plc0->where('iupb_id', $updateId);
		$this->db_plc0->delete('plc2.plc2_upb_registrasi_dokumen_bb_detail');
		$this->db_plc0->where('iupb_id', $updateId);
		$this->db_plc0->delete('plc2.plc2_upb_registrasi_dokumen_sm_detail');
		
		foreach($bb as $r) {
			if(array_key_exists($r, $okbb)) {
				$bbd['iupb_id'] = $updateId;
				$bbd['idoc_id'] = $r;
				$bbd['tnote'] = $notebb[$r];
				$this->db_plc0->insert('plc2.plc2_upb_registrasi_dokumen_bb_detail', $bbd);
			}
		}
		foreach($sm as $r) {
			if(array_key_exists($r, $oksm)) {
				$smd['iupb_id'] = $updateId;
				$smd['idoc_id'] = $r;
				$smd['tnote'] = $notesm[$r];
				$this->db_plc0->insert('plc2.plc2_upb_registrasi_dokumen_sm_detail', $smd);
			}
		}
			
			$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
			$hacek=$this->biz_process->cek_last_status($updateId,$bizsup,7); // status 7 => submit
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($updateId, $bizsup, 7); // status 7 => submit
				//update last log
					$this->biz_process->update_last_log($updateId, $bizsup, 7);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($updateId, $bizsup, 7); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($updateId, $bizsup, 7);
			}
	}*/

	function output(){		
    	$this->index($this->input->get('action'));
    }
	function readDirektory($path, $empty="") {
		
		$filename = array();
		
		/*if (!file_exists( $path )) {
			mkdir( $path, 0777, true);						 
		}*/
				
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
	
	
	function hapusfile($path, $file_name, $table, $lastId, $field){
		$path = $path."/".$lastId;
		$path = str_replace("\\", "/", $path);
		
		if (is_array($file_name)) {			
			$list_dir  = $this->readDirektory($path);
			$list_sql  = $this->readSQL($table, $lastId,'',$field);
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
					$del = "delete from plc2.".$table." where ".$field." = {$lastId} and filename= '{$v}'";
					mysql_query($del);	
				}
				
			}
		} else {
			$this->readDirektory($path, 1);
			$this->readSQL($table, $lastId, 1,$field);
		}
	} 
	
	function readSQL($table, $lastId, $empty="",$field) {
		$list_file = array();
		if (empty($empty)) {
			$sql = "SELECT filename from plc2.".$table." where ".$field."=".$lastId;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['filename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT filename from plc2.".$table." where ".$field."=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM plc2.".$table." where ".$field."=".$lastId." and filename='".$row['filename']."'";			
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