<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class cek_dokumen_registrasi extends MX_Controller {
    function __construct() {
        parent::__construct();
		//$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->dbset =  $this->load->database('plc0',false, true);
		$this->load->library('lib_utilitas');
		$this->user = $this->auth_localnon->user();
		$this->load->model('m_registrasi');
		$this->isPD = array('fileprot','filestp');
		$this->uploadfilename=array('lapprot_udt','stabilita_pilot','validasi_proses','lapvalmoa');
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Cek Dokumen Registrasi');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('cek_dokumen_registrasi');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik','iconfirm_registrasi');
		$grid->setSortBy('vupb_nomor');
		$grid->setSortOrder('ASC');

		$grid->setLabel('vupb_nomor', 'UPB Nomor');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('iconfirm_registrasi', 'Approval Busdev Manager');
		$grid->setLabel('form_iconfirm_registrasi', 'Approval Busdev Manager');
		$grid->setLabel('form_iconfirm_registrasi_qa', 'Approval QA Manager');
		$grid->setLabel('form_iconfirm_registrasi_pd', 'Approval PD Manager');
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setWidth('vupb_nomor', '120');
		$grid->setAlign('vupb_nama', 'Left');
		$grid->setWidth('vupb_nama', '200');
		$grid->setAlign('iconfirm_registrasi', 'Left');
		$grid->setWidth('iconfirm_registrasi', '150');
		$grid->addFields('iupb_id','vupb_nama','vgenerik');
		$grid->addFields('lapprot_udt','stabilita_pilot','validasi_proses','lapvalmoa');
		//$grid->addFields('filelsa','filelsb');
		$grid->addFields('form_iconfirm_registrasi_pd');
		$grid->addFields('form_iconfirm_registrasi_qa');
		$grid->addFields('form_iconfirm_registrasi');

		$grid->setLabel('lapprot_udt','File Laporan UDT (PD)');
		$grid->setLabel('stabilita_pilot','Stabilita Pilot Detail (PD)');
		$grid->setLabel('validasi_proses','Laporan Validasi Proses (QA)');
		$grid->setLabel('lapvalmoa','Laporan Validasi MoA (PD)');
		
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
			if(in_array('PD', $manager)){
				$type='PD';
				//$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
				$grid->setQuery('plc2_upb.iconfirm_dok_pd IN (1)', null);
			}
			if(in_array('QA', $manager)){
				$type='QA';
				//$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
				$grid->setQuery('plc2_upb.iupb_id in (select la.iupb_id from plc2.coa_pilot_lab la
						where la.lDeleted=0 and la.iappqa=2)',NULL); //Sudah Melewati COA Pilot dan Lab
				$grid->setQuery('plc2_upb.iupb_id in (select up.iupb_id from plc2.plc2_upb up
						inner join plc2.study_literatur_pd st on up.iupb_id=st.iupb_id
						where (case when st.ijenis_sediaan=0 && st.iuji_mikro=1
							then up.iupb_id in (select fo.iupb_id from plc2.plc2_upb_formula fo 
							inner join plc2.mikro_fg mi on mi.ifor_id=fo.ifor_id 
							where mi.iappqa_soi=2 and mi.lDeleted=0 and fo.ldeleted=0
							and fo.iFormula_process is not null
							)
							else
								up.iupb_id in (select la.iupb_id from plc2.coa_pilot_lab la where la.lDeleted=0 and la.iappqa=2)
							end))',NULL);
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

			if(in_array('PD', $team)){
				$type='PD';
				//$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
				$grid->setQuery('plc2_upb.iconfirm_dok_pd IN (1)', null);
			}
			if(in_array('QA', $team)){
				$type='QA';
				//$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
				$grid->setQuery('plc2_upb.iupb_id in (select la.iupb_id from plc2.coa_pilot_lab la
						where la.lDeleted=0 and la.iappqa=2)',NULL); //Sudah Melewati COA Pilot dan Lab
				$grid->setQuery('plc2_upb.iupb_id in (select up.iupb_id from plc2.plc2_upb up
						inner join plc2.study_literatur_pd st on up.iupb_id=st.iupb_id
						where (case when st.ijenis_sediaan=0 && st.iuji_mikro=1
							then up.iupb_id in (select fo.iupb_id from plc2.plc2_upb_formula fo 
							inner join plc2.mikro_fg mi on mi.ifor_id=fo.ifor_id 
							where mi.iappqa_soi=2 and mi.lDeleted=0 and fo.ldeleted=0
							and fo.iFormula_process is not null
							)
							else
								up.iupb_id in (select la.iupb_id from plc2.coa_pilot_lab la where la.lDeleted=0 and la.iappqa=2)
							end))',NULL);
			}
			else{$type='';}
		}
		$grid->setQuery('plc2_upb.iappdireksi', 2); //Aproval Direksi
		/*$grid->setQuery('plc2_upb.iappbd_hpr',2); //Sudah Melewati HPR
				$grid->setQuery('plc2_upb.iupb_id in(
											select fp.iupb_id 
											from pddetail.formula_stabilita f 
											join pddetail.formula_process fp on fp.iFormula_process=f.iFormula_process
											where f.lDeleted=0
											and fp.lDeleted=0
											and f.iKesimpulanStabilita=1
											and f.iApp_formula=2
											and fp.iFormula_process in (select a.iFormula_process 
																				from pddetail.formula_process a where a.lDeleted=0
																				and a.iMaster_flow in (9,10,11))
											)
				',null);
*/
		/*$grid->setQuery('plc2_upb.iupb_id in (select la.iupb_id from plc2.coa_pilot_lab la
						where la.lDeleted=0 and la.iappqa=2)',NULL); //Sudah Melewati COA Pilot dan Lab
		$grid->setQuery('plc2_upb.iupb_id in (select up.iupb_id from plc2.plc2_upb up
						inner join plc2.study_literatur_pd st on up.iupb_id=st.iupb_id
						where (case when st.ijenis_sediaan=0
							then up.iupb_id in (select fo.iupb_id from plc2.plc2_upb_formula fo 
							inner join plc2.mikro_fg mi on mi.ifor_id=fo.ifor_id 
							where mi.iappqa_soi=2 and mi.lDeleted=0 and fo.ldeleted=0
							and fo.iFormula_process is not null
							)
							else
								up.iupb_id in (select la.iupb_id from plc2.coa_pilot_lab la where la.lDeleted=0 and la.iappqa=2)
							end))',NULL);*/ //Optional SOI Mikro
		$grid->setSearch('vupb_nomor','vupb_nama');
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/

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
				$this->m_registrasi->download($this->input->get('file'));
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
						echo $this->m_registrasi->get_cek_dokumen_registrasi_filemain();
						break;
				}
				break;
			case 'doneprocess':
				echo $this->m_registrasi->doneprocess();
				break;
			case 'updateproses':
				$post=$this->input->post();
				$get=$this->input->get();
				$isUpload = $this->input->get('isUpload');
				$lastId=$this->input->get('lastId');
				$iupb_id=$post['cek_dokumen_registrasi_iupb_id'];
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

				/*Upload File Untuk Dokumen prg*/

				$returndarta=array();
				foreach ($this->uploadfilename as $kfileup => $fieldfileup) {
					$returndarta[$fieldfileup]=$this->m_registrasi->updateBeforeUpload($fieldfileup,$type);
				}
				/*End Update Details File lsb*/

				if($isUpload) {

					foreach ($this->uploadfilename as $kfileup => $fieldfileup) {
						$this->m_registrasi->updateUploadFile($fieldfileup,$type,$returndarta,$iupb_id);
					}

					if($type=='BD'){
						if($postData['isubmitbusdev']==1){
							$cek=$this->m_registrasi->cek_dokumen_confirm($postData);
							$get=$this->input->get();
							$nip = $this->user->gNIP;
							$skg=date('Y-m-d H:i:s');
							$iapprove ='iconfirm_registrasi_qa';$vapprove ='cnip_confirm_registrasi_qa';$tapprove ='tconfirm_registrasi_qa';$isubmit_registrasi_bd='isubmit_registrasi_bd';
							$this->dbset->where('iupb_id', $postData['iupb_id']);
							if($cek!=0){
								$this->dbset->update('plc2.plc2_upb', array($iapprove=>0,$vapprove=>'',$tapprove=>'',$isubmit_registrasi_bd=>1));

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
						        $subject="Cek Dokumen Registrasi: UPB ".$rupb['vupb_nomor'];
						        $content="
						                Diberitahukan bahwa telah ada update proses oleh team BD pada Cek Dokumen Registrasi(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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

															/*PK per table*/
															$iupb_id=$postData['iupb_id'];
															$datanotconfirm=$this->m_registrasi->getDetailtableUse($postData);

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
						                Demikian, mohon segera follow up pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
						                Post Master";
						        $this->lib_utilitas->send_email($to, $cc, $subject, $content);								

							}else{
								$this->dbset->update('plc2.plc2_upb', array($isubmit_registrasi_bd=>2));
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
							$cek=$this->m_registrasi->cek_dokumen_confirm($postData);
							$get=$this->input->get();
							$nip = $this->user->gNIP;
							$skg=date('Y-m-d H:i:s');
							$iapprove ='iconfirm_registrasi_qa';$vapprove ='cnip_confirm_registrasi_qa';$tapprove ='tconfirm_registrasi_qa';$isubmit_registrasi_bd='isubmit_registrasi_bd';
							$this->dbset->where('iupb_id', $postData['iupb_id']);
							if($cek!=0){
								$this->dbset->update('plc2.plc2_upb', array($iapprove=>0,$vapprove=>'',$tapprove=>'',$isubmit_registrasi_bd=>1));

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
						        $subject="Cek Dokumen Registrasi: UPB ".$rupb['vupb_nomor'];
						        $content="
						                Diberitahukan bahwa telah ada update proses oleh team BD pada Cek Dokumen Registrasi(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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

															/*PK per table*/
															$iupb_id=$postData['iupb_id'];
															$datanotconfirm=$this->m_registrasi->getDetailtableUse($postData);

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
						                Demikian, mohon segera follow up pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
						                Post Master";
						        $this->lib_utilitas->send_email($to, $cc, $subject, $content);

							}else{
								$this->dbset->update('plc2.plc2_upb', array($isubmit_registrasi_bd=>2));
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
			case 'dokDone':
				echo $this->dokDone_view();
			break;
			case 'dokDone_process':
				echo $this->dokDone_process();
			break;
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove ='iconfirm_registrasi';$vapprove ='cconfirm_registrasi';$tapprove ='dconfirm_registrasi';
				$this->dbset->where('iupb_id', $post['iupb_id']);
				$this->dbset->update('plc2.plc2_upb', array($iapprove=>2,$vapprove=>$nip,$tapprove=>$skg));
				$iupb_id=$post['iupb_id'];
				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Confirm Success!';
				echo json_encode($r);
				exit();
			break;
			case 'confirmqa':
				$post=$this->input->post();
				$get=$this->input->get();
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove ='iconfirm_registrasi_qa';$vapprove ='cnip_confirm_registrasi_qa';$tapprove ='tconfirm_registrasi_qa';
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
		        $subject="Cek Dokumen Registrasi: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada Approval oleh QA Manager pada Cek Dokumen Registrasi(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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

				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Approved Success!';
				echo json_encode($r);
				exit();
				break;
			case 'confirmpd':
				$post=$this->input->post();
				$get=$this->input->get();
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove ='iconfirm_registrasi_pd';$vapprove ='cconfirm_registrasi_pd';$tapprove ='dconfirm_registrasi_pd';
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
		        $subject="Cek Dokumen Registrasi: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada Approval oleh PD Manager pada Cek Dokumen Registrasi(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
			default:
				$grid->render_grid();
				//echo $this->load->view('count');
				break;
		}
    }

/*Maniupulasi Gird end*/
	function listBox_cek_dokumen_registrasi_iconfirm_registrasi($value) {
		if($value==0){$vstatus='Waiting for approval';}
		elseif($value==1){$vstatus='Rejected';}
		elseif($value==2){$vstatus='Approved';}
		return $vstatus;
	}
	function listBox_Action($row, $actions) {
		$rowprivi=$this->m_registrasi->getERPPrivi($this->input->get('modul_id'));
		$iValidation=$rowprivi['iValidation'];
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
			if($row->iconfirm_registrasi_pd!=0&&$iValidation==1){
				unset($actions['edit']);
			}
		}
		if($type=="QA"){
			if(($row->iconfirm_registrasi_qa!=0||$row->iconfirm_registrasi_pd==0)&&$iValidation==1){
				unset($actions['edit']);
			}
		}
		if($type=="BD"){
			if(($row->iconfirm_registrasi_qa==0||$row->iconfirm_registrasi!=0)&&$iValidation==1){
				unset($actions['edit']);
			}
		}
	    if($row->iconfirm_registrasi<>0){
	    	unset($actions['edit']);
	    }
	    return $actions; 

	}
/*manipulasi view object form start*/
 	function updateBox_cek_dokumen_registrasi_iupb_id($field, $id, $value, $rowData){
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->dbset->query($sql)->row_array();
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

	function updateBox_cek_dokumen_registrasi_vupb_nama($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->dbset->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nama'];
		}else{
			$return='<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="50" value="'.$dt['vupb_nama'].'" />';
		}
		return $return;
	}
	function updateBox_cek_dokumen_registrasi_vgenerik($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->dbset->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vgenerik'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="50" value="'.$dt['vgenerik'].'" />';
		}
		return $return;
	}

	function updateBox_cek_dokumen_registrasi_lapprot_udt($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_registrasi->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_registrasi_file',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_registrasi_stabilita_pilot($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_registrasi->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_registrasi_file',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_registrasi_validasi_proses($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_registrasi->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_registrasi_file',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_registrasi_lapvalmoa($field, $id, $value, $rowData){
		/*Get ID Header*/
		$dgrid=$this->m_registrasi->getDoneOnUpdateBox($field,$rowData);
		if($dgrid['nilaiid']>=1){
			$ret=$this->load->view('lokal/cek_dokumen_prareg/grid_registrasi_file',$dgrid,TRUE);
		}else{
			$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
		}
		return $ret;
	}

	function updateBox_cek_dokumen_registrasi_form_iconfirm_registrasi_pd($field, $id, $value, $rowData) {
		if($rowData['iconfirm_registrasi_pd'] != 0){
			$row = $this->dbset->get_where('hrd.employee', array('cNip'=>$rowData['cconfirm_registrasi_pd']))->row_array();
			if($rowData['iconfirm_registrasi_pd']==1){$st="Approved";}
			$ret= $st.' By '.$row['vName'].' ( '.$rowData['cconfirm_registrasi_pd'].' )'.' At '.$rowData['dconfirm_registrasi_pd'];
		}
		else{
			$ret='Waiting for Approval';
		}
		$ret.='<input type="hidden" name="'.$id.'" value="'.$rowData['iconfirm_registrasi_pd'].'" />';
		return $ret;
	}
	
	function updateBox_cek_dokumen_registrasi_form_iconfirm_registrasi_qa($field, $id, $value, $rowData) {
		if($rowData['iconfirm_registrasi_qa'] != 0){
			$row = $this->dbset->get_where('hrd.employee', array('cNip'=>$rowData['cnip_confirm_registrasi_qa']))->row_array();
			if($rowData['iconfirm_registrasi_qa']==1){$st="Submited";} 
			$name=isset($row['vName'])?$row['vName']:"";
			$ret= $st.' oleh '.$name.' ( '.$rowData['cnip_confirm_registrasi_qa'].' )'.' pada '.$rowData['tconfirm_registrasi_qa'];
		}
		else{
			$ret='Waiting for Submited';
		}
		$ret.='<input type="hidden" name="'.$id.'" value="'.$rowData['iconfirm_registrasi_qa'].'" />';
		return $ret;
	}
	
	function updateBox_cek_dokumen_registrasi_form_iconfirm_registrasi($field, $id, $value, $rowData) {
		if($rowData['iconfirm_registrasi'] != 0){
			$row = $this->dbset->get_where('hrd.employee', array('cNip'=>$rowData['cconfirm_registrasi']))->row_array();
			if($rowData['iconfirm_registrasi']==2){$st="Approved";}elseif($rowData['iconfirm_registrasi']==1){$st="Rejected";} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['cconfirm_registrasi'].' )'.' pada '.$rowData['dconfirm_registrasi'];
		}
		else{
			$ret='Waiting for Approval';
		}
		$ret.='<input type="hidden" name="'.$id.'" value="'.$rowData['iconfirm_registrasi'].'" />';
		return $ret;
	}

	/*manipulasi view object form end*/

	/*manipulasi proses object form start*/
	function manipulate_update_button($buttons, $rowData){
		$isman=false;
		$js = $this->load->view('cek_dokumen_registrasi_js');
		$js .= $this->load->view('uploadjs');
		$cNip=$this->user->gNIP;
		$rowprivi=$this->m_registrasi->getERPPrivi($this->input->get('modul_id'));
		$iValidation=$rowprivi['iValidation'];
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
					elseif(in_array('PR', $team)){$type='PR';}
					elseif(in_array('PD', $team)){$type='PD';}
					elseif(in_array('QA', $team)){$type='QA';}
					elseif(in_array('QC', $team)){$type='QC';}
					else{$type='';}
				}
			}

			$iupb_id=$rowData['iupb_id'];

			/*---------------------Cek Untuk PD----------------------------------*/
			/*List Tabel*/
			$pddetailtable=$this->m_registrasi->getDetailtable("PD",$iupb_id);
			$table=$pddetailtable['table'];
			$pktable=$pddetailtable['pktable'];/*PK per table*/
			$nitable=$pddetailtable['nitable'];
			/*End Table PD*/
			/*---------------------Cek Untuk QA----------------------------------*/
			/*List Tabel*/
			$pddetailtableqa=$this->m_registrasi->getDetailtable("QA",$iupb_id);
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
			if($type=='PD'&&$rowData['iconfirm_registrasi_pd']==0){
				$approve = '<button onclick="javascript:setuju(\'cek_dokumen_registrasi\', \''.base_url().'processor/plc/cek/dokumen/registrasi?action=confirmpd&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Approve</button>';
				$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen_registrasi\', \''.base_url().'processor/plc/cek/dokumen/registrasi?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
				if($ii==0){
					$buttons['update']=$update.$approve.$js;
				}else{
					$buttons['update']=$update.$js;
				}
				if($iValidation==0){
					$buttons['update']=$approve.$js;
				}
			}

			/*---------------------Cek Untuk QA----------------------------------*/
			if($type=='QA'&&$rowData['iconfirm_registrasi_pd']==1&&$rowData['iconfirm_registrasi_qa']==0){
				$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen_registrasi\', \''.base_url().'processor/plc/cek/dokumen/registrasi?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
				$approve = '<button onclick="javascript:setuju(\'cek_dokumen_registrasi\', \''.base_url().'processor/plc/cek/dokumen/registrasi?action=confirmqa&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Submit</button>';
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
				if($iValidation==0){
					$buttons['update']=$approve.$js;
				}
				
			}

			/*---------------------Cek Untuk BD----------------------------------*/
			if($type=='BD'&&$rowData['iconfirm_registrasi_pd']==1&&$rowData['iconfirm_registrasi_qa']==1&&$rowData['iconfirm_registrasi']==0){
				$update = '<button onclick="javascript:update_draft_btn(\'cek_dokumen_registrasi\', \''.base_url().'processor/plc/cek/dokumen/registrasi?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update as Draft</button>';
				$submit = '<button onclick="javascript:update_btn_back(\'cek_dokumen_registrasi\', \''.base_url().'processor/plc/cek/dokumen/registrasi?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update as Submit</button>';
				$approve = '<button onclick="javascript:setuju(\'cek_dokumen_registrasi\', \''.base_url().'processor/plc/cek/dokumen/registrasi?action=confirm&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Confirm</button>';
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
					if($isman==true&&$rowData['isubmit_registrasi_bd']==2){
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
				}elseif($rowData['isubmit_registrasi_bd']!=2){
					$buttons['update']=$submit.$update.$js;
				}
				if($iValidation==0){
					$buttons['update']=$approve.$js;
				}
			}
		}
		return $buttons;
	}


	function getAnotherUPB($field='iupb_id',$iupb_id){
		$ret=0;
		switch ($field) {
			case 'ifor_id':
				$sql_lapori="select * from plc2.plc2_upb_formula where iupb_id=".$iupb_id." and iFormula_process is not null and iapp_basic=2 and iapppd_basic=2 and ldeleted=0 order by ifor_id DESC limit 1";
				$q_lapori=$this->dbset->query($sql_lapori)->row_array();
				$ret=$q_lapori['ifor_id'];
				break;
			case 'iFormula_process':
				$sql_lapori="SELECT * FROM pddetail.formula_process
					INNER JOIN pddetail.formula_process_detail ON formula_process_detail.iFormula_process = formula_process.iFormula_process
					INNER JOIN pddetail.formula_stabilita ON formula_stabilita.iFormula_process = formula_process.iFormula_process
					INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = formula_process.iupb_id
					WHERE formula_process_detail.lDeleted = 0 
					AND formula_stabilita.lDeleted = 0 
					AND formula_process.lDeleted = 0 
					AND formula_process.iMaster_flow IN (9,10,11) 
					AND formula_process.iupb_id=".$iupb_id."
					GROUP BY formula_process.iupb_id, formula_stabilita.iVersi
					ORDER BY formula_process.iFormula_process desc limit 1";
				$q_lapori=$this->dbset->query($sql_lapori)->row_array();
				$ret=$q_lapori['iFormula_process'];
				break;
			case 'ivalidasi_id':
				$sql_lapori="select * from plc2.validasi_proses va
				where va.iappqa=2 and va.iupb_id=".$iupb_id;
				$q_lapori=$this->dbset->query($sql_lapori)->row_array();
				$ret=$q_lapori['ivalidasi_id'];
				break;
			case 'icoa_id':
				$sql_lapori="select * from plc2.coa_pilot_lab cp where cp.iappqa=2 and cp.lDeleted=0 and cp.iupb_id=".$iupb_id;
				$q_lapori=$this->dbset->query($sql_lapori)->row_array();
				$ret=$q_lapori['icoa_id'];
				break;
			case 'ivalmoa_id':
				$sql_lapori="select * from plc2.plc2_vamoa cp where cp.iapppd=2 and cp.lDeleted=0 and cp.iupb_id=".$iupb_id;
				$q_lapori=$this->dbset->query($sql_lapori)->row_array();
				$ret=$q_lapori['ivalmoa_id'];
				break;
			default:
				$ret=$this->input->get('id');
				break;
		}
		return $ret;
	}
	   
	/*manipulasi proses object form end*/    
	function before_update_processor($row, $postData) {
		unset($postData['vupb_nama']);
		unset($postData['vgenerik']);
		return $postData;

	}

	function after_update_processor($row, $post, $postData) {
		
	}

	function cek_dokumen_confirm($post){
		/*List Tabel*/
		$table=array('plc2.prareg_file','pddetail.file_stabilita_pilot','plc2.validasi_proses_file','plc2.coa_pilot_batch1','plc2.plc2_upb_file_lapprot_udt','plc2.coa_pilot_batch2','plc2.coa_lsa1','plc2.coa_lsa2');
		/*PK per table*/
		$iupb_id=$post['iupb_id'];
		$ifor_id=$this->getAnotherUPB('ifor_id',$iupb_id);
		$iFormula=$this->getAnotherUPB('iFormula_process',$iupb_id);
		$ivalidasi_id=$this->getAnotherUPB('ivalidasi_id',$iupb_id);
		$icoa_id=$this->getAnotherUPB('icoa_id',$iupb_id);
		/*Array id dan PK*/
		$pktable=array($iupb_id,$iFormula,$ivalidasi_id,$icoa_id,$ifor_id,$icoa_id,$icoa_id,$icoa_id);
		$idtable=array('iupb_id','iFormula','ivalidasi_id','icoa_id','ifor_id','icoa_id','icoa_id','icoa_id');
		$ii=0;//nilai apakah sudah ada belum
		foreach ($table as $ktb => $vtb) {
			/*Kagem ngecek upload file sing dipun confirm / not use*/
			$sqlc="select * from ".$vtb." where (ldeleted is null or ldeleted=0) and iconfirm_busdev in (0,3) and ".$idtable[$ktb]."=".$pktable[$ktb];
			if($this->dbset->query($sqlc)->num_rows()>=1){
				$ii++;
			}
		}
		return $ii;
	}

	function download($filename) {
	}

	/*function pendukung end*/    	
	public function output(){
		$this->index($this->input->get('action'));
	}

	}
