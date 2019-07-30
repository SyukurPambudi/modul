<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class cek_dokumen_prareg extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->dbset = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		//$this->dbset = $this->load->database('plc0',false, true);
		$this->load->library('lib_utilitas');
		$this->user = $this->auth_localnon->user();
		$this->load->model('m_prareg');
		$this->uploadfilename=array('filedmf','filecoars','filecoaws','filecoabb_lsa','filesoibb','filespekfg','filelpp','fileproval','filecoaex','filelsaex','filesoifg','filevamoa','filelpo','fileprot_stab','fileprot_udt','filesoiex');

    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;

		$grid->setTitle('Cek Dokumen Pra-Registrasi');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('cek_dokumen_prareg');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik','iconfirm_dok');
		$grid->setSortBy('vupb_nomor');
		$grid->setSortOrder('ASC');

		$grid->setLabel('vupb_nomor', 'UPB Nomor');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('form_iconfirm_dok_pd', 'Approval PD Manager');
		$grid->setLabel('form_iconfirm_dok_qa', 'Approval QA Manager');
		$grid->setLabel('form_iconfirm_dok', 'Approval Busdev Manager');
		$grid->setLabel('iconfirm_dok', 'Approval Busdev Manager');

		$grid->setAlign('vupb_nomor', 'center');
		$grid->setWidth('vupb_nomor', '120');
		$grid->setAlign('vupb_nama', 'Left');
		$grid->setWidth('vupb_nama', '200');
		$grid->setAlign('iconfirm_dok', 'Left');
		$grid->setWidth('iconfirm_dok', '150');

		$grid->addFields('iupb_id','vupb_nama','vgenerik');
		$grid->addFields('filedmf','filecoars','filecoaws','filecoabb_lsa','filesoibb','filespekfg','filelpp','fileproval');
		$grid->addFields('filecoaex','filelsaex','filesoifg','filevamoa','filelpo','fileprot_stab','fileprot_udt','filesoiex','filebk');

		$grid->addFields('form_iconfirm_dok_pd');
		$grid->addFields('form_iconfirm_dok_qa');
		$grid->addFields('form_iconfirm_dok');

		$grid->setLabel('filedmf','File DMF (QA)');
		$grid->setLabel('filecoars','File CoA RS (PD)');
		$grid->setLabel('filecoaws','File CoA WS (PD)');
		$grid->setLabel('filecoabb_lsa','File CoA & LSA Zat Aktif(QA)');
		$grid->setLabel('filesoibb','File SOI BB(QA)');
		$grid->setLabel('filespekfg','File Spesifikasi FG (PD)');
		$grid->setLabel('filelpp','Laporan Pengembangan Produk (PD)');
		$grid->setLabel('fileproval','File Protokol Valpro(QA)');
		$grid->setLabel('filecoaex','File CoA Excipient(QA)');
		$grid->setLabel('filelsaex','File LSA Excipient(QA)');
		$grid->setLabel('filesoifg','File SOI FG(QA)');
		$grid->setLabel('filevamoa','File protokol Validasi MoA(PD)');
		$grid->setLabel('filelpo','File Laporan Pemeriksaan Originator(PD)');
		$grid->setLabel('fileprot_stab','File Protokol Stabilita(PD)');
		$grid->setLabel('fileprot_udt','File Protokol UDT(PD)');
		$grid->setLabel('filesoiex','File SOI Excipients(QA)');
		$grid->setLabel('filebk','File Bahan Kemas (QA)');

		$grid->setLabel('iupb_id', 'No. UPB');

		$grid->setFormUpload(TRUE);
		$grid->setRequired('iupb_id');
		
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
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('BD', $team)){
					$type='BD';
					$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth_localnon->my_teams().')', null);
				}
				else{$type='';}
			}
		}

		//Query mandatori LPO
		//$grid->setQuery('iupb_id in (select po.iupb_id from plc2.lpo po where po.iapppd=2 and po.lDeleted=0)',NULL);

		//Query mandatori LPP
		//$grid->setQuery('iupb_id in (select fo.iupb_id from plc2.plc2_upb_formula fo where fo.iapppd_lpp=2 and fo.ldeleted=0)',NULL);

		//Query mandatori SOI BB
		//$grid->setQuery('iupb_id in (select bb.iupb_id from plc2.plc2_upb_soi_bahanbaku bb where bb.ldeleted=0 and  bb.iappqa=2)', NULL);

		//Query mandatori Uji Mikro
		/*$grid->setQuery('iupb_id in (select distinct(rs.iupb_id) from plc2.plc2_upb_ro ro
						left outer join plc2.plc2_upb_ro_detail rod on rod.iro_id = ro.iro_id and rod.ldeleted = 0
						left outer join plc2.plc2_upb_po po on po.ipo_id = ro.ipo_id
						left outer join plc2.plc2_upb_request_sample_detail rsd on rsd.ireq_id = rod.ireq_id and rsd.raw_id = rod.raw_id and  rsd.ldeleted = 0
						left outer join plc2.plc2_raw_material rm on rm.raw_id=rsd.raw_id
						left outer join plc2.plc2_upb_request_sample rs on rs.ireq_id = rod.ireq_id 
						left outer join plc2.plc2_upb u on u.iupb_id = rs.iupb_id
						where (
							case when rod.iUjiMikro_bb = 1 
							then rod.ireq_id in (select d.ireq_id from plc2.uji_mikro_bb u
									inner join plc2.plc2_upb_request_sample_detail d on u.ireqdet_id=d.ireqdet_id
									inner join plc2.plc2_upb_request_sample s on d.ireq_id=s.ireq_id
									inner join plc2.plc2_raw_material m on d.raw_id=m.raw_id
									where u.lDeleted=0 and u.iApprove_uji=2 and u.iApprove_mikro_final=2) 
							else
								rod.ireq_id in (select d.ireq_id
												from plc2.plc2_upb_request_sample_detail d 
												 inner join plc2.plc2_upb_request_sample s on d.ireq_id=s.ireq_id
												 inner join plc2.plc2_raw_material m on d.raw_id=m.raw_id
												 where d.ldeleted=0
												 and s.ldeleted=0
												 and m.ldeleted=0 
												 and s.iapppd=2 )
							end  
						))',NULL);*/


		//Mandatori Join Formula Process untuk PDDetail
		//$grid->setQuery('plc2_upb.iupb_id in (select iupb_id from plc2.plc2_upb_formula where ldeleted=0 and iFormula_process is not NULL)',NULL);

		//New Parameter For PLC Non OTC
		$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2.plc2_upb.iKill', 0);
		$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
		$grid->setQuery('plc2_upb.ihold', 0);

		$grid->setSearch('vupb_nomor','vupb_nama');
		$grid->setQuery('plc2_upb.ldeleted',0);
		$grid->setQuery('plc2_upb.ihold',0);
		$grid->setQuery('plc2_upb.iappdireksi',2);

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
			case 'download':
				$this->m_prareg->download($this->input->get('file'));
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
			case 'getuploadfile':
				$get=$this->input->get('field');
				switch ($get) {
					case 'null':
						echo "NOT FOUND";
						break;
					default:
						echo $this->m_prareg->get_cek_dokumen_prareg_filemain();
						break;
				}
				break;
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove ='iconfirm_dok';$vapprove ='vnip_confirm_dok';$tapprove ='tconfirm_dok';
				$this->dbset->where('iupb_id', $post['iupb_id']);
				$this->dbset->update('plc2.plc2_upb', array($iapprove=>1,$vapprove=>$nip,$tapprove=>$skg));
				$iupb_id=$post['iupb_id'];
				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Confirm Success!';
				echo json_encode($r);
				exit();
				break;
			case 'doneprocess':
				echo $this->m_prareg->doneprocess();
				break;
			case 'updateproses':
				$post=$this->input->post();
				$get=$this->input->get();
				$isUpload = $this->input->get('isUpload');
				$lastId=$this->input->get('lastId');
				$iupb_id=$post['cek_dokumen_prareg_iupb_id'];
				$postData=$this->input->post();
				$postData['iupb_id']=$iupb_id;
				if($postData['isdraft']==true){
					$postData['isubmitbusdev']=0;
				}else{$postData['isubmitbusdev']=1;}
				/*Cek Team*/
				$type='';
				if($this->auth_localnon->is_manager()){
					$x=$this->auth_localnon->dept();
					$manager=$x['manager'];
					if(in_array('BD', $manager)){
						$type='BD';
					}elseif(in_array('PD', $manager)){
						$type='PD';
					}elseif(in_array('QA', $manager)){
						$type='QA';
					}
					else{$type='';}
				}
				else{
					$x=$this->auth_localnon->dept();
					if(isset($x['team'])){
						$team=$x['team'];
						if(in_array('BD', $team)){
							$type='BD';
						}elseif(in_array('PD', $team)){
							$type='PD';
						}elseif(in_array('QA', $team)){
							$type='QA';
						}
						else{$type='';}
					}
				}

				$returndarta=array();
				foreach ($this->uploadfilename as $kfileup => $fieldfileup) {
					$returndarta[$fieldfileup]=$this->m_prareg->updateBeforeUpload($fieldfileup,$type);
				}

				/*Upload File Untuk Dokumen bk*/

				$ibk_id=$this->m_prareg->getAnotherUPB('ibk_id',$iupb_id);
				$pathbk = realpath("files/plc/bahan_kemas/bahan_kemas_primer");
				if(!file_exists($pathbk."/".$ibk_id)){
					if (!mkdir($pathbk."/".$ibk_id, 0777, true)) { //id review
						die('Failed upload, try again - bk!');
					}
				}
				$fileketeranganbk = array();
				$istatusbk = array();
				$iconfirmbk = array();
				$iconfirmbk_prareg_upload = array();
				$ijenisbk = array();
				$ijenisbk_upload = array();
				$istatusbk_upload = array();
				$fileidbk='';
				foreach($_POST as $key=>$value) {
					if($key == 'cek_dokumen_prareg_filebk_istatus'){
						foreach($value as $y=>$u) {
							if($y!=0){
								$istatusbk[$y]=$u[0];
							}else{
								$istatusbk_upload[]=$u;
							}
						}
					}
					if($key == 'cek_dokumen_prareg_filebk_iconfirm_prareg'){
						foreach($value as $y=>$u) {
							if($y!=0){
								$iconfirmbk[$y]=$u[0];
							}else{
								$iconfirmbk_prareg_upload[]=$u;
							}
						}
					}
					if($key == 'cek_dokumen_prareg_filebk_ijenis_bk_id'){
						foreach($value as $y=>$u) {
							if($y!=0){
								$ijenisbk[$y]=$u[0];
							}else{
								$ijenisbk_upload[]=$u;
							}
						}
					}
					if($key == 'file_keterangan_local_filebk'){
						foreach($value as $y=>$u) {
							$fileketeranganbk[] = $u;
						}
					}
					if ($key == 'ifile_filebk') {
						$i=0;
						foreach($value as $k=>$v) {
							$ifile_filebk[$k] = $v;
							if($i==0){
								$fileidbk .= "'".$v."'";
							}else{
								$fileidbk .= ",'".$v."'";
							}
							$i++;
						}
					}
				}

				/*Cek Confirm untuk upload*/
				if(count($fileketeranganbk)>=1){
					if(count($iconfirmbk_prareg_upload)>=1){
						$iconfirmbk_prareg_upload=$iconfirmbk_prareg_upload[0];
					}
					if(count($ijenisbk_upload)>=1){
						$ijenisbk_upload=$ijenisbk_upload[0];
					}
					if(count($istatusbk_upload)>=1){
						$istatusbk_upload=$istatusbk_upload[0];
					}
					foreach ($fileketeranganbk as $kketbk => $vketbk) {
						if(!isset($iconfirmbk_prareg_upload[$kketbk])){
							if($type!='BD'){
								$iconfirmbk_prareg_upload[$kketbk]=0;
							}
						}
						if(!isset($istatusbk_upload[$kketbk])){
							if($type=='BD'){
								$istatusbk_upload[$kketbk]=1;
							}
						}
					}
				}

				/*Update delete file*/
				if($fileidbk!=''){
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.plc2_upb_file_bahan_kemas set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ibk_id='".$ibk_id."' and id not in (".$fileidbk.")";
					$this->dbset->query($sql1);
				}elseif($fileidbk==""){
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.plc2_upb_file_bahan_kemas set ldeleted=1, dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where ibk_id='".$ibk_id."'";
					$this->dbset->query($sql1);
				}

				/*Update istatus oleh qa*/
				if(count($istatusbk)>=1){
					foreach ($istatusbk as $kbk => $vbk) {
						$sqlup="update plc2.plc2_upb_file_bahan_kemas set istatus=".$vbk." where ibk_id=".$ibk_id." and id=".$kbk;
						$this->dbset->query($sqlup);
					}
				}
				if(count($iconfirmbk)>=1){
					foreach ($iconfirmbk as $kbk => $vbk) {
						$sqlupp="update plc2.plc2_upb_file_bahan_kemas set iconfirm_busdev=".$vbk." where ibk_id=".$ibk_id." and id=".$kbk;
						$this->dbset->query($sqlupp);
					}
				}
				if(count($ijenisbk)>=1){
					foreach ($ijenisbk as $kbk => $vbk) {
						$sqlupp="update plc2.plc2_upb_file_bahan_kemas set ijenis_bk_id=".$vbk." where ibk_id=".$ibk_id." and id=".$kbk;
						$this->dbset->query($sqlupp);
					}
				}

				/*End Update Details File bk*/

				/*If Upload*/

				if($isUpload) {

					foreach ($this->uploadfilename as $kfileup => $fieldfileup) {
						$this->m_prareg->updateUploadFile($fieldfileup,$type,$returndarta,$iupb_id);
					}

					/*File Upload Untuk BK File*/
					$ibk_id=$this->m_prareg->getAnotherUPB('ibk_id',$iupb_id);
					if (isset($_FILES['fileupload_local_filebk'])){
						$i=0;
						foreach ($_FILES['fileupload_local_filebk']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_local_filebk']["tmp_name"][$key];
								$name =$_FILES['fileupload_local_filebk']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $pathbk."/".$ibk_id."/".$name)) {
									$sqlbk[] = "INSERT INTO plc2.plc2_upb_file_bahan_kemas(ibk_id , ijenis_bk_id,filename, dInsertDate, vketerangan, cInsert, istatus, iconfirm_busdev) 
											VALUES (".$ibk_id.",'".$ijenisbk_upload[$i]."','".$data['filename']."','".$data['dInsertDate']."','".$fileketeranganbk[$i]."','".$this->user->gNIP."','".$istatusbk_upload[$i]."','".$iconfirmbk_prareg_upload[$i]."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
						}
						foreach($sqlbk as $qbk) {
							try {
								$this->dbset->query($qbk);
							}catch(Exception $e) {
								die($e);
							}
						}	
					}


					/*End Uplad*/
					if($type=='BD'){
						if($postData['isubmitbusdev']==1){
							$cek=$this->m_prareg->cek_dokumen_confirm($postData);
							$get=$this->input->get();
							$nip = $this->user->gNIP;
							$skg=date('Y-m-d H:i:s');
							$iapprove ='iconfirm_dok_qa';$vapprove ='vnip_confirm_dok_qa';$tapprove ='tconfirm_dok_qa';$isubmit_bd='isubmit_bd';
							$this->dbset->where('iupb_id', $postData['iupb_id']);
							if($cek!=0){
								$this->dbset->update('plc2.plc2_upb', array($iapprove=>0,$vapprove=>'',$tapprove=>'',$isubmit_bd=>1));


								/*Send Email to QA*/
								$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
				                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
				                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
				                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
				                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
				                        from plc2.plc2_upb u where u.iupb_id='".$postData['iupb_id']."'";
						        $rupb = $this->dbset->query($qupb)->row_array();

						        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id,
						                (select te.iteam_id from plc2.plc2_upb_team te where te.cDeptId='PR') as iteampr_id 
						                from plc2.plc2_upb u 
						                where u.iupb_id='".$postData['iupb_id']."'";
						        $rsql = $this->dbset->query($qsql)->row_array();

						        $pd = $rsql['iteampd_id'];
						        $bd = $rsql['iteambusdev_id'];
						        $qa = $rsql['iteamqa_id'];
						        $qc = $rsql['iteamqc_id'];
						        $pr = $rsql['iteampr_id'];
						        
						        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
						        
						        $toEmail2='';
						        $toEmail = $this->lib_utilitas->get_email_team( $qa );
						        $toEmail2 = $this->lib_utilitas->get_email_leader( $qa );                        

						        $arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );

						        $to = $cc = '';
						        if(is_array($arrEmail)) {
						                $count = count($arrEmail);
						                $to = $arrEmail[0];
						                for($i=1;$i<$count;$i++) {
						                        $cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
						                }
						        }			

						        $to = $toEmail2;
						        $cc = $toEmail;
						        $subject="Cek Dokumen Praregistrasi: UPB ".$rupb['vupb_nomor'];
						        $content="
						                Diberitahukan bahwa telah ada update proses oleh team BD pada Cek Dokumen Praregistrasi(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
														<td colspan=3>
														<table style='border-collapse: collapse;' border='1' width='100%'>
														 	<tr>
														 		<th>No</th>
														 		<th>Nama Dokumen</th>
														 		<th>Jumlah Dokumen Reject</th>
														 	</tr>";
														 	/*Cek Details yang masih Unconfirm / Unused*/
															$datanotconfirm=$this->m_prareg->getDetailtableUse($postData);

														 	$table=$datanotconfirm['table'];
														 	$capt=$datanotconfirm['caption'];
														 	$idtable=$datanotconfirm['pktable'];
														 	$pktable=$datanotconfirm['nitable'];
															$no=1;//nilai apakah sudah ada belum
															foreach ($table as $ktb => $vtb) {
																/*Kagem ngecek upload file sing dipun confirm / not use*/
																$sqlc="select * from ".$vtb." where (ldeleted is null or ldeleted=0) and iconfirm_busdev in (0,3) and ".$idtable[$ktb]."=".$pktable[$ktb];
																if($this->dbset->query($sqlc)->num_rows()>=1){
																	$content .=	"<tr>
																 		<td>".$no."</td>
																 		<td>".$capt[$ktb]."</td>
																 		<td align='center'>".$this->dbset->query($sqlc)->num_rows()."</td>
																 	</tr>";
																	$no++;
																}
															}	 	
											$content .="</table>
													</td>
												</tr>
						                        </table>
						                </div>
						                <br/> 
						                Demikian, mohon segera follow up pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
						                Post Master";
						        $this->lib_utilitas->send_email($to, $cc, $subject, $content);

							}else{
								$this->dbset->update('plc2.plc2_upb', array($isubmit_bd=>2));
							}
						}
					}
					
					$r['message']="Data Berhasil Disimpan!";
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');				
					echo json_encode($r);
					exit();
				}else{
					if($type=='BD'){
						if($postData['isubmitbusdev']==1){
							$cek=$this->m_prareg->cek_dokumen_confirm($postData);
							$get=$this->input->get();
							$nip = $this->user->gNIP;
							$skg=date('Y-m-d H:i:s');
							$iapprove ='iconfirm_dok_qa';$vapprove ='vnip_confirm_dok_qa';$tapprove ='tconfirm_dok_qa';$isubmit_bd='isubmit_bd';
							$this->dbset->where('iupb_id', $postData['iupb_id']);
							if($cek!=0){
								$this->dbset->update('plc2.plc2_upb', array($iapprove=>0,$vapprove=>'',$tapprove=>'',$isubmit_bd=>1));

								/*Send Email to QA*/
								$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
				                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
				                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
				                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
				                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
				                        from plc2.plc2_upb u where u.iupb_id='".$postData['iupb_id']."'";
						        $rupb = $this->dbset->query($qupb)->row_array();

						        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id,
						                (select te.iteam_id from plc2.plc2_upb_team te where te.cDeptId='PR') as iteampr_id 
						                from plc2.plc2_upb u 
						                where u.iupb_id='".$postData['iupb_id']."'";
						        $rsql = $this->dbset->query($qsql)->row_array();

						        $pd = $rsql['iteampd_id'];
						        $bd = $rsql['iteambusdev_id'];
						        $qa = $rsql['iteamqa_id'];
						        $qc = $rsql['iteamqc_id'];
						        $pr = $rsql['iteampr_id'];
						        
						        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
						        
						        $toEmail2='';
						        $toEmail = $this->lib_utilitas->get_email_team( $qa );
						        $toEmail2 = $this->lib_utilitas->get_email_leader( $qa );                        

						        $arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );

						        $to = $cc = '';
						        if(is_array($arrEmail)) {
						                $count = count($arrEmail);
						                $to = $arrEmail[0];
						                for($i=1;$i<$count;$i++) {
						                        $cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
						                }
						        }			

						        $to = $toEmail2;
						        $cc = $toEmail;
						        $subject="Cek Dokumen Praregistrasi: UPB ".$rupb['vupb_nomor'];
						        $content="
						                Diberitahukan bahwa telah ada Approval oleh PD Manager pada Cek Dokumen Praregistrasi(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
														<td colspan=3>
														<table style='border-collapse: collapse;' border='1' width='100%'>
														 	<tr>
														 		<th>No</th>
														 		<th>Nama Dokumen</th>
														 		<th>Jumlah Dokumen Reject</th>
														 	</tr>";
														 	/*Cek Details yang masih Unconfirm / Unused*/
														 	$datanotconfirm=$this->m_prareg->getDetailtableUse($postData);

														 	$table=$datanotconfirm['table'];
														 	$capt=$datanotconfirm['caption'];
														 	$idtable=$datanotconfirm['pktable'];
														 	$pktable=$datanotconfirm['nitable'];

															$no=1;//nilai apakah sudah ada belum
															foreach ($table as $ktb => $vtb) {
																/*Kagem ngecek upload file sing dipun confirm / not use*/
																$sqlc="select * from ".$vtb." where (ldeleted is null or ldeleted=0) and iconfirm_busdev in (0,3) and ".$idtable[$ktb]."=".$pktable[$ktb];
																if($this->dbset->query($sqlc)->num_rows()>=1){
																	$content .=	"<tr>
																 		<td>".$no."</td>
																 		<td>".$capt[$ktb]."</td>
																 		<td>".$this->dbset->query($sqlc)->num_rows()."</td>
																 	</tr>";
																	$no++;
																}
															}	 	
											$content .="</table>
													</td>
												</tr>
						                        </table>
						                </div>
						                <br/> 
						                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
						                Post Master";
						        $this->lib_utilitas->send_email($to, $cc, $subject, $content);


							}else{
								$this->dbset->update('plc2.plc2_upb', array($isubmit_bd=>2));
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
			case 'confirmpd':
				$post=$this->input->post();
				$get=$this->input->get();
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove ='iconfirm_dok_pd';$vapprove ='vnip_confirm_dok_pd';$tapprove ='tconfirm_dok_pd';
				$this->dbset->where('iupb_id', $post['iupb_id']);
				$this->dbset->update('plc2.plc2_upb', array($iapprove=>1,$vapprove=>$nip,$tapprove=>$skg));

				/*Send Email to QA*/
				$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
                        from plc2.plc2_upb u where u.iupb_id='".$post['iupb_id']."'";
		        $rupb = $this->dbset->query($qupb)->row_array();

		        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id,
		                (select te.iteam_id from plc2.plc2_upb_team te where te.cDeptId='PR') as iteampr_id 
		                from plc2.plc2_upb u 
		                where u.iupb_id='".$post['iupb_id']."'";
		        $rsql = $this->dbset->query($qsql)->row_array();

		        $pd = $rsql['iteampd_id'];
		        $bd = $rsql['iteambusdev_id'];
		        $qa = $rsql['iteamqa_id'];
		        $qc = $rsql['iteamqc_id'];
		        $pr = $rsql['iteampr_id'];
		        
		        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
		        
		        $toEmail2='';
		        $toEmail = $this->lib_utilitas->get_email_team( $qa );
		        $toEmail2 = $this->lib_utilitas->get_email_leader( $qa );                        

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
		        $subject="Cek Dokumen Praregistrasi: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada Approval oleh PD Manager pada Cek Dokumen Praregistrasi(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
				$r['message'] = 'Approved Success!';
				echo json_encode($r);
				exit();
				break;
			case 'submitbd':
				$post=$this->input->post();
				$cek=$this->m_prareg->cek_dokumen_confirm($post);
				$get=$this->input->get();
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove ='iconfirm_dok_qa';$vapprove ='vnip_confirm_dok_qa';$tapprove ='tconfirm_dok_qa';$isubmit_bd='isubmit_bd';
				$this->dbset->where('iupb_id', $post['iupb_id']);
				if($cek!=0){
					$this->dbset->update('plc2.plc2_upb', array($iapprove=>0,$vapprove=>'',$tapprove=>'',$isubmit_bd=>1));
				}else{
					$this->dbset->update('plc2.plc2_upb', array($isubmit_bd=>2));
				}
				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Submited Success!';
				echo json_encode($r);
				exit();
				break;
			case 'confirmqa':
				$post=$this->input->post();
				$get=$this->input->get();
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove ='iconfirm_dok_qa';$vapprove ='vnip_confirm_dok_qa';$tapprove ='tconfirm_dok_qa';
				$this->dbset->where('iupb_id', $post['iupb_id']);
				$this->dbset->update('plc2.plc2_upb', array($iapprove=>1,$vapprove=>$nip,$tapprove=>$skg));
				/*Send Email to QA*/
				$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
                        from plc2.plc2_upb u where u.iupb_id='".$post['iupb_id']."'";
		        $rupb = $this->dbset->query($qupb)->row_array();

		        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id,
		                (select te.iteam_id from plc2.plc2_upb_team te where te.cDeptId='PR') as iteampr_id 
		                from plc2.plc2_upb u 
		                where u.iupb_id='".$post['iupb_id']."'";
		        $rsql = $this->dbset->query($qsql)->row_array();

		        $pd = $rsql['iteampd_id'];
		        $bd = $rsql['iteambusdev_id'];
		        $qa = $rsql['iteamqa_id'];
		        $qc = $rsql['iteamqc_id'];
		        $pr = $rsql['iteampr_id'];
		        
		        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
		        
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
		        $subject="Cek Dokumen Praregistrasi: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada Approval oleh QA Manager pada Cek Dokumen Praregistrasi(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
				$r['message'] = 'Approved Success!';
				echo json_encode($r);
				exit();
				break;

			case 'confirmbd':
				$post=$this->input->post();
				$get=$this->input->get();
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove ='iconfirm_dok';$vapprove ='vnip_confirm_dok';$tapprove ='tconfirm_dok';$isubmit_bd='isubmit_bd';
				$this->dbset->where('iupb_id', $post['iupb_id']);
				$this->dbset->update('plc2.plc2_upb', array($iapprove=>1,$vapprove=>$nip,$tapprove=>$skg,$isubmit_bd=>2));
				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Approved Success!';
				echo json_encode($r);
				exit();
				break;

			default:
				$grid->render_grid();
				break;
		}
    }
/*Maniupulasi Gird end*/
	function listBox_cek_dokumen_prareg_iconfirm_dok($value) {
		$vstatus=$value;
		if($value==0){$vstatus='Waiting for Approval';}
		elseif($value==1){$vstatus='Approved';}
		return $vstatus;
	}
	function listBox_Action($row, $actions) {
		//print_r($row);
		$user = $this->auth_localnon->user();
		$type='';
		$x=$this->auth_localnon->dept();
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){$type='PD';$isman=true;}
			elseif(in_array('BD', $manager)){$type='BD';$isman=true;}
			elseif(in_array('PR', $manager)){$type='PR';$isman=true;}
			elseif(in_array('QA', $manager)){$type='QA';$isman=true;}
			elseif(in_array('QC', $manager)){$type='QC';$isman=true;}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('BD', $team)){$type='BD';}
				elseif(in_array('PR', $team)){$type='PR';}
				elseif(in_array('QA', $team)){$type='QA';}
				elseif(in_array('QC', $team)){$type='QC';}
				else{$type='';}
			}
		}

		/*Access Untuk PD*/
		if($type=="PD"){
			if($row->iconfirm_dok_pd!=0){
				unset($actions['edit']);
			}
		}
		if($type=="QA"){
			if($row->iconfirm_dok_qa!=0||$row->iconfirm_dok_pd==0){
				unset($actions['edit']);
			}
		}
		if($type=="BD"){
			if($row->iconfirm_dok_qa==0||$row->iconfirm_dok!=0){
				unset($actions['edit']);
			}
		}
	    if($row->iconfirm_dok<>0){
	    	unset($actions['edit']);
	    }
	    return $actions; 

	}
/*manipulasi view object form start*/
 	function updateBox_cek_dokumen_prareg_iupb_id($field, $id, $value, $rowData){
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->dbset->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nomor'];
		}else{
		$return = '<input type="hidden" name="isdraft" id="isdraft">';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1" value='.$value.' />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" value="'.$dt['vupb_nomor'].'" size="20" />';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		}
		return $return;
	}

	function updateBox_cek_dokumen_prareg_vupb_nama($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->dbset->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nama'];
		}else{
			$return='<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vupb_nama'].'" />';
		}
		return $return;
	}
	function updateBox_cek_dokumen_prareg_vgenerik($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->dbset->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vgenerik'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vgenerik'].'" />';
		}
		return $return;
	}

	function updateBox_cek_dokumen_prareg_filedmf($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_filecoars($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_filecoaws($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_filecoabb_lsa($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_filesoibb($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_filespekfg($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_filelpp($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_fileproval($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_filecoaex($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_filelsaex($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_filesoifg($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_filevamoa($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_filelpo($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_fileprot_stab($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_fileprot_udt($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_filesoiex($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_prareg->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_dmf',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_filebk($field, $id, $value, $rowData){
		$dgrid['isPD']=(in_array($field, $this->m_prareg->isPD))?1:0;
		$dgrid['field']=$field;
		$dgrid['id']=$field;
		$dgrid['value']=$value;
		$dgrid['rowData']=$rowData;
		$dgrid['get']=$this->input->get();
		$dgrid['caption']='File Bahan Kemas';
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('BD', $manager)){
				$type='BD';
			}elseif(in_array('PD', $manager)){
				$type='PD';
			}elseif(in_array('QA', $manager)){
				$type='QA';
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('BD', $team)){
					$type='BD';
				}elseif(in_array('PD', $team)){
					$type='PD';
				}elseif(in_array('QA', $team)){
					$type='QA';
				}
				else{$type='';}
			}
		}
		/*Cek Untuk Done*/
		$idman=$this->m_prareg->getAnotherUPB('ibk_id',$rowData['iupb_id']);
		$dgrid['cekdone']=0;
		$sqlc="select * from plc2.plc2_upb_file_bahan_kemas where (ldeleted is null or ldeleted=0) and iconfirm_busdev in (0,3) and ibk_id=".$idman;
		$dgrid['cekdone']=$this->dbset->query($sqlc)->num_rows();
		$dgrid['ddd']=0;
		$sqlc2="select * from plc2.plc2_upb_file_bahan_kemas where (ldeleted is null or ldeleted=0) and iDone!=1 and ibk_id=".$idman;
		$dgrid['ddd']=$this->dbset->query($sqlc2)->num_rows();
		$dgrid['type']=$type;
		$vtb="plc2.plc2_upb_file_bahan_kemas";
		$sqlcc="select * from ".$vtb." where (ldeleted is null or ldeleted=0) and ibk_id=".$idman;
		$nn=$this->dbset->query($sqlcc);
		if($nn->num_rows()==0){
			//if($type!='QA'){
				$dgrid['ddd']=1;
			//}
		}
		$sql1 = "select mbk.ijenis_bk_id,mbk.vjenis_bk,
							(case
								when mbk.itipe_bk=1 then 'Primer'
								when mbk.itipe_bk=2 then 'Sekunder'
								else 'Tersier'
							end) as itipe_bk, mbk.itipe_bk as idtipe_bk from plc2.plc2_master_jenis_bk mbk where mbk.ldeleted=0 
							";
		$dgrid['arr3']=$this->dbset->query($sql1)->result_array();
		$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_prareg_file_bk',$dgrid,TRUE);
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_form_iconfirm_dok_pd($field, $id, $value, $rowData) {
		if($rowData['iconfirm_dok_pd'] != 0){
			$row = $this->dbset->get_where('hrd.employee', array('cNip'=>$rowData['vnip_confirm_dok_pd']))->row_array();
			if($rowData['iconfirm_dok_pd']==1){$st="Approved";}
			$name=isset($row['vName'])?$row['vName']:"";
			$ret= $st.' By '.$name.' ( '.$rowData['vnip_confirm_dok_pd'].' )'.' At '.$rowData['tconfirm_dok_pd'];
		}
		else{
			$ret='Waiting for Approval';
		}
		$ret.='<input type="hidden" name="'.$id.'" value="'.$rowData['iconfirm_dok_pd'].'" />';
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_form_iconfirm_dok_qa($field, $id, $value, $rowData) {
		if($rowData['iconfirm_dok_qa'] != 0){
			$row = $this->dbset->get_where('hrd.employee', array('cNip'=>$rowData['vnip_confirm_dok_qa']))->row_array();
			if($rowData['iconfirm_dok_qa']==1){$st="Submited";}
			$name=isset($row['vName'])?$row['vName']:"";
			$st=isset($st)?$st:"-";
			$ret= $st.' By '.$name.' ( '.$rowData['vnip_confirm_dok_qa'].' )'.' At '.$rowData['tconfirm_dok_qa'];
		}
		else{
			$ret='Waiting for Submited';
		}
		$ret.='<input type="hidden" name="'.$id.'" value="'.$rowData['iconfirm_dok_qa'].'" />';
		return $ret;
	}

	function updateBox_cek_dokumen_prareg_form_iconfirm_dok($field, $id, $value, $rowData) {
		if($rowData['iconfirm_dok'] != 0){
			$row = $this->dbset->get_where('hrd.employee', array('cNip'=>$rowData['vnip_confirm_dok']))->row_array();
			if($rowData['iconfirm_dok']==1){$st="Confirmed";}
			$ret= $st.' By '.$row['vName'].' ( '.$rowData['vnip_confirm_dok'].' )'.' At '.$rowData['tconfirm_dok'];
		}
		else{
			$ret='Waiting for Confirm';
		}
		$ret.='<input type="hidden" name="'.$id.'" value="'.$rowData['iconfirm_dok'].'" />';
		return $ret;
	}

	
/*manipulasi view object form end*/

/*manipulasi proses object form start*/
	function manipulate_update_button($buttons, $rowData){
		$isman=false;
		$js = $this->load->view('cek_dokumen_prareg_js');
		$js .= $this->load->view('uploadjs');
		$cNip=$this->user->gNIP;
		$sql= "select * from plc2.plc2_upb up where up.iupb_id=".$rowData['iupb_id'];
		$dt=$this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			unset($buttons['update']);
			unset($buttons['update_back']);
			$user = $this->auth_localnon->user();
		
			$x=$this->auth_localnon->dept();
			if($this->auth_localnon->is_manager()){
				$x=$this->auth_localnon->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){$type='PD';$isman=true;}
				elseif(in_array('BD', $manager)){$type='BD';$isman=true;}
				elseif(in_array('PR', $manager)){$type='PR';$isman=true;}
				elseif(in_array('QA', $manager)){$type='QA';$isman=true;}
				elseif(in_array('QC', $manager)){$type='QC';$isman=true;}
				else{$type='';}
			}
			else{
				$x=$this->auth_localnon->dept();
				if(isset($x['team'])){
					$team=$x['team'];
					if(in_array('BD', $team)){$type='BD';}
					elseif(in_array('PD', $team)){$type='PD';}
					elseif(in_array('PR', $team)){$type='PR';}
					elseif(in_array('QA', $team)){$type='QA';}
					elseif(in_array('QC', $team)){$type='QC';}
					else{$type='';}
				}
			}

			$iupb_id=$rowData['iupb_id'];
			$ifor_id=$this->m_prareg->getAnotherUPB('ifor_id',$iupb_id);
			$iprotokol_id=$this->m_prareg->getAnotherUPB('iprotokol_id',$iupb_id);
			$isoi_id=$this->m_prareg->getAnotherUPB('isoi_id',$iupb_id);
			$ivalmoa_id=$this->m_prareg->getAnotherUPB('ivalmoa_id',$iupb_id);
			$ibk_id=$this->m_prareg->getAnotherUPB('ibk_id',$iupb_id);

			/*---------------------Cek Untuk PD----------------------------------*/
			/*List Tabel*/
			$pddetailtable=$this->m_prareg->getDetailtable("PD",$iupb_id);
			$table=$pddetailtable['table'];
			$pktable=$pddetailtable['pktable'];/*PK per table*/
			$nitable=$pddetailtable['nitable'];
			/*End Table PD*/
			/*---------------------Cek Untuk QA----------------------------------*/
			/*List Tabel*/
			$pddetailtableqa=$this->m_prareg->getDetailtable("QA",$iupb_id);
			$tableqa=$pddetailtableqa['table'];
			$pktableqa=$pddetailtableqa['pktable'];/*PK per table*/
			$nitableqa=$pddetailtableqa['nitable'];
			/*End Table QA*/

			$ii=0;//nilai apakah sudah ada belum
			foreach ($table as $ktb => $vtb) {
				/*Cek Untuk dokumen PD minimal 1 File*/
				$sqlc="select * from ".$vtb." where (ldeleted is null or ldeleted=0) and ".$pktable[$ktb]."=".$nitable[$ktb];
				if($this->dbset->query($sqlc)->num_rows()==0){
					$ii++;
				}
			}
			if($type=='PD'&&$rowData['iconfirm_dok_pd']==0){
				$approve = '<button onclick="javascript:setuju(\'cek_dokumen_prareg\', \''.base_url().'processor/plc/cek/dokumen/prareg?action=confirmpd&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Approve</button>';
				$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen_prareg\', \''.base_url().'processor/plc/cek/dokumen/prareg?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
				if($ii==0){
					$buttons['update']=$update.$approve.$js;
				}else{
					$buttons['update']=$update.$js;
				}
			}


			/*---------------------Cek Untuk QA----------------------------------*/
			if($type=='QA'&&$rowData['iconfirm_dok_pd']==1&&$rowData['iconfirm_dok_qa']==0){
				$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen_prareg\', \''.base_url().'processor/plc/cek/dokumen/prareg?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
				$approve = '<button onclick="javascript:setuju(\'cek_dokumen_prareg\', \''.base_url().'processor/plc/cek/dokumen/prareg?action=confirmqa&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Submit</button>';
				/*Cek Button Approve*/
				/*Untuk list yang ada di array atas*/
				$iappqa=0;
				$iappqa=$ii+$iappqa;
				foreach ($tableqa as $ktb => $vtb) {
					/*Cek Untuk dokumen QA minimal 1 File*/
					$sqlc="select * from ".$vtb." where (ldeleted is null or ldeleted=0) and ".$pktableqa[$ktb]."=".$nitableqa[$ktb];
					if($this->dbset->query($sqlc)->num_rows()==0){
						$iappqa++;
					}
				}
				foreach ($table as $ktb => $vtb) {
					$sqlc="select * from ".$vtb." where (ldeleted is null or ldeleted=0) and istatus=0 and ".$pktable[$ktb]."=".$nitable[$ktb];
					if($this->dbset->query($sqlc)->num_rows()>=1){
						$iappqa++;
					}

				}
				foreach ($tableqa as $ktb => $vtb) {
					$sqlc="select * from ".$vtb." where (ldeleted is null or ldeleted=0) and istatus=0 and ".$pktableqa[$ktb]."=".$nitableqa[$ktb];
					if($this->dbset->query($sqlc)->num_rows()>=1){
						$iappqa++;
					}

				}
				if($iappqa==0){
					$buttons['update']=$approve.$update.$js;
				}else{
					$buttons['update']=$update.$js;
				}
				
			}

			/*---------------------Cek Untuk BD----------------------------------*/
			if($type=='BD'&&$rowData['iconfirm_dok_pd']==1&&$rowData['iconfirm_dok_qa']==1&&$rowData['iconfirm_dok']==0){
				$update = '<button onclick="javascript:update_draft_btn(\'cek_dokumen_prareg\', \''.base_url().'processor/plc/cek/dokumen/prareg?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update as Draft</button>';
				$submit = '<button onclick="javascript:update_btn_back(\'cek_dokumen_prareg\', \''.base_url().'processor/plc/cek/dokumen/prareg?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update as Submit</button>';
				$approve = '<button onclick="javascript:setuju(\'cek_dokumen_prareg\', \''.base_url().'processor/plc/cek/dokumen/prareg?action=confirm&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Confirm</button>';
				/*Cek Button Approve*/
				/*Untuk list yang ada di array atas*/
				$iappqa=0;
				$iappqa=$ii+$iappqa;
				foreach ($table as $ktb => $vtb) {
					$sqlc="select * from ".$vtb." where (ldeleted is null or ldeleted=0) and iconfirm_busdev in (0,3) and ".$pktable[$ktb]."=".$nitable[$ktb];
					if($this->dbset->query($sqlc)->num_rows()>=1){
						$iappqa++;
					}

				}
				foreach ($tableqa as $ktb => $vtb) {
					$sqlc="select * from ".$vtb." where (ldeleted is null or ldeleted=0) and istatus=0 and ".$pktableqa[$ktb]."=".$nitableqa[$ktb];
					if($this->dbset->query($sqlc)->num_rows()>=1){
						$iappqa++;
					}

				}
				if($iappqa==0){
					if($isman==true&&$rowData['isubmit_bd']==2){
						/*Cek All Done*/
						$nn=0;
						foreach ($table as $ktb => $vtb) {
							/*Cek Untuk dokumen PD minimal 1 File*/
							$sqlc="select * from ".$vtb." where (ldeleted is null or ldeleted=0) and iDone!=1 and ".$pktable[$ktb]."=".$nitable[$ktb];
							if($this->dbset->query($sqlc)->num_rows()>=1){
								$nn++;
							}
						}
						foreach ($tableqa as $ktb => $vtb) {
							/*Cek Untuk dokumen PD minimal 1 File*/
							$sqlc="select * from ".$vtb." where (ldeleted is null or ldeleted=0) and iDone!=1 and ".$pktableqa[$ktb]."=".$nitableqa[$ktb];
							if($this->dbset->query($sqlc)->num_rows()>=1){
								$nn++;
							}
						}
						if($nn==0){
							$buttons['update']=$approve.$js;
						}
					}else{
						$buttons['update']=$submit.$update.$js;
					}
				}elseif($rowData['isubmit_bd']!=2){
					$buttons['update']=$submit.$update.$js;
				}
			}
		}
		return $buttons;
	}
   
/*manipulasi proses object form end*/    
function before_update_processor($row, $postData) {
	unset($postData['vupb_nama']);
	unset($postData['vgenerik']);/*
	if($postData['isdraft']==true){
		$postData['isubmitbusdev']=0;
	} 
	else{$postData['isubmitbusdev']=1;} */
	return $postData;

}

function after_update_processor($row, $post, $postData) {
	
}


/*function pendukung end*/   

	public function output(){
		$this->index($this->input->get('action'));
	}

}