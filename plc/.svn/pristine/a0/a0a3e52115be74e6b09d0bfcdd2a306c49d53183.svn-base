<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class kelengkapan_dokumen3_export extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_plcexport');
		$this->load->library('lib_utilitas');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth_plcexport->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Cek Kelengkapan Dokumen III');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_review');		
		$grid->setUrl('kelengkapan_dokumen3_export');
		$grid->addList('dossier_upd.vUpd_no','dossier_upd.vNama_usulan','dossier_upd.iTeam_andev','dossier_prioritas.iSemester','dossier_prioritas.iTahun');
		$grid->setSortBy('dossier_upd.vUpd_no');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('vUpd_no','vNama_usulan','iTeam_andev','rincian_dok','dPembuatan_dossier','dPeriksa_ir','dPeriksa_bdirm');

		//setting widht grid
		$grid ->setWidth('dossier_upd.vUpd_no', '100'); 
		$grid->setWidth('dossier_upd.iTeam_andev', '100'); 
		$grid->setWidth('dossier_upd.iSediaan', '100'); 
		$grid->setWidth('dossier_prioritas.iSemester', '150'); 
		$grid->setWidth('dossier_prioritas.iTahun', '100'); 
		$grid->setWidth('iKelengkapan_data3', '100'); 
		$grid->setWidth('dossier_upd.vNama_usulan', '250'); 
		$grid->setWidth('lDeleted', '100'); 
		
		
		//modif label
		$grid->setLabel('vUpd_no','No UPD'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 

		$grid->setLabel('dossier_upd.vUpd_no','No UPD'); 
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Usulan'); 
		$grid->setLabel('dossier_upd.iTeam_andev','Team Andev'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 


		$grid->setLabel('iSubmit_kelengkapan3','Status Submit'); 
		$grid->setLabel('iKelengkapan_data3','Status Kelengkapan III'); 
		$grid->setLabel('iTeam_andev','Team Andev'); 
		$grid->setLabel('iNegara','Negara'); 
		//$grid->setLabe6l('iKelengkapan_data3','Approved at'); 
		//$grid->setLabel('cCek_kelengkapan3','Approved by'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 
		$grid->setLabel('dossier_prioritas.iSemester','Semester Prioritas'); 
		$grid->setLabel('dossier_prioritas.iTahun','Tahun Prioritas');
		
		$grid->setLabel('dPembuatan_dossier','Tanggal Pembuatan Dosier');
		$grid->setLabel('dPeriksa_ir','Tanggal Periksa IR SPV');
		$grid->setLabel('dPeriksa_bdirm','Tanggal Periksa BDIRM');
		

		$grid->setFormUpload(TRUE);

		$grid->setSearch('dossier_upd.vUpd_no');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('dossier_upd.iSediaan','combobox','',array(''=>'Pilih','1'=>'Solid','2'=>'Non Solid'));
		$grid->changeFieldType('iKelengkapan_data3','combobox','',array('0'=>'Waiting Approval','1'=>'Rejected','2'=>'Approved'));
		$grid->changeFieldType('iSubmit_kelengkapan3','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submitted'));
		
		

	//Field mandatori
		$grid->setRequired('iSediaan');	
		$grid->setRequired('iTeam_andev');	
		$grid->setRequired('lDeleted');	

		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id', 'inner');		
		$grid->setJoinTable('dossier.dossier_prioritas_detail', 'dossier_prioritas_detail.idossier_upd_id = dossier_upd.idossier_upd_id', 'inner');
		$grid->setJoinTable('dossier.dossier_prioritas', 'dossier_prioritas.idossier_prioritas_id = dossier_prioritas_detail.idossier_prioritas_id', 'inner');

		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_review.iKelengkapan_data2', 2);

		if($this->auth_plcexport->is_manager()){
			$x=$this->auth_plcexport->dept();
			$manager=$x['manager'];
			$q="select te.iteam_id from plc2.plc2_upb_team te where te.vnip in ('".$this->user->gNIP."') and te.iTipe=2";
			if(in_array('BDI', $manager)){
				$type='BDI';
				$q.=" and vtipe='".$type."'";
				$d=$this->dbset->query($q)->row_array();
				if($d['iteam_id']==90){//BDIRM 1
					$sq='dossier_upd.iTeam_andev in (17)';
					$grid->setQuery($sq, null);
				}elseif ($d['iteam_id']==78) {
					$sq='dossier_upd.iTeam_andev in (40)';
					$grid->setQuery('('.$sq.' or is_old=1)', null);
				}
			}
		}else{
			$x=$this->auth_plcexport->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('BDI', $team)){
					$type='BDI';
					$q="select * from plc2.plc2_upb_team_item it where it.lDeleted=0 and it.vnip='".$this->user->gNIP."'";
					$dt=$this->dbset->query($q);
					if($dt->num_rows()!=0){
						$d=$dt->row_array();
						$q="select te.iteam_id from plc2.plc2_upb_team te where te.iteam_id=".$d['iteam_id']." and te.iTipe=2";
						if($d['iteam_id']==90){//BDIRM 1
							$sq='dossier_upd.iTeam_andev in (17)';
							$grid->setQuery($sq, null);
						}elseif ($d['iteam_id']==78) {
							$sq='dossier_upd.iTeam_andev in (40)';
							$grid->setQuery('('.$sq.' or is_old=1)', null);
						}
					}
				}
			}
		}

		//$grid->setMultiSelect(true);
		
		//Set View Gridnya (Default = grid)
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
				$this->download($this->input->get('file'));
				break;

			case 'delete':
				echo $grid->delete_row();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'carinegara':
				$this->carinegara();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				$post=$this->input->post();
				$idossier_dok_list_id=array();
				$keterangan=array();
				foreach ($post as $kpost=> $vpost) {
					if($kpost=='cek_3_'){
						$idossier_dok_list_id=$vpost;
					}
					if($kpost=='cek_3_keterangan'){
						foreach ($vpost as $kp => $vp) {
							$keterangan[$kp]=$vp;
						}
					}
				}
				$status=0;
				if(count($idossier_dok_list_id)>=1){
					foreach ($idossier_dok_list_id as $kidos =>$valdos ) {
						if($valdos==2){
							$appro[$kidos]=$valdos;
						}elseif($valdos==1){
							$revi[$kidos]=$valdos;
						}
					}
				}
				if(isset($revi)){
					if(isset($appro)){
						foreach ($appro as $kapp => $vapp) {
							$data['iStatus_kelengkapan3']=0;
							$data['vKeterangan_kelengkapan3']=$keterangan[$kapp];
							$sqlup[]="UPDATE dossier.dossier_dok_list SET iStatus_kelengkapan3=0, vKeterangan_kelengkapan3='".$keterangan[$kapp]."' WHERE idossier_dok_list_id=".$vapp;
						}
						
					}
					if(isset($revi)){
						foreach ($revi as $krev => $vrev) {
							$data1['iStatus_kelengkapan3']=0;
							$data1['iStatus_confirm']=0;
							$data1['istatus_verifikasi']=0;
							$data1['iStatus_kelengkapan1']=1;
							$data1['iStatus_kelengkapan2']=1;
							$data1['iStatus_kelengkapan3']=0;
							$data1['vKeterangan_kelengkapan3']=$keterangan[$krev];
							$sqlup[]="UPDATE dossier.dossier_dok_list SET iStatus_kelengkapan3=0, 
							vKeterangan_kelengkapan3='".$keterangan[$krev]."',
							iStatus_confirm=0, istatus_verifikasi=0, iStatus_kelengkapan1=1,iStatus_kelengkapan2=1
							WHERE idossier_dok_list_id=".$krev;
							$iddok2[]=$krev;
							$status++;
						}
					}
					$data2['iSubmit_kelengkapan2']=0;
					$data2['iKelengkapan_data2']=0;
					$sqlup[]="UPDATE dossier.dossier_review SET iSubmit_kelengkapan2=0, iKelengkapan_data2=0 WHERE idossier_review_id=".$post['kelengkapan_dokumen3_export_idossier_review_id'];
				}elseif(isset($appro)){
					foreach ($appro as $kapp1 => $vapp1) {
						$data4['iStatus_kelengkapan3']=0;
						$data4['vKeterangan_kelengkapan3']=$keterangan[$kapp1];
						$sqlup[]="UPDATE dossier.dossier_dok_list SET iStatus_kelengkapan3=2, vKeterangan_kelengkapan3='".$keterangan[$kapp1]."' WHERE idossier_dok_list_id=".$kapp1;
					}
				}
				if(isset($sqlup)){
					foreach($sqlup as $q) {
						try {
							$this->dbset->query($q);
						}catch(Exception $e) {
							die($e);
						}
					}	
				}
				/*if(count($idossier_dok_list_id)>=1){
					foreach ($idossier_dok_list_id as $kidos =>$valdos ) {
						$data=array();
						if($valdos==2){
							$data['iStatus_kelengkapan3']=2;
							$data['vKeterangan_kelengkapan3']=$keterangan[$kidos];
							$this->dbset->where('idossier_dok_list_id',$kidos);
							$this->dbset->update('dossier.dossier_dok_list',$data);
						}else{
							$data['iStatus_confirm']=0;
							$data['istatus_verifikasi']=0;
							$data['iStatus_kelengkapan1']=$valdos;
							$data['iStatus_kelengkapan2']=$valdos;
							$data['iStatus_kelengkapan3']=$valdos;
							$data['vKeterangan_kelengkapan3']=$keterangan[$kidos];
							$this->dbset->where('idossier_dok_list_id',$kidos);
							$this->dbset->update('dossier.dossier_dok_list',$data);
							$data2['iSubmit_kelengkapan2']=0;
							$data2['iKelengkapan_data2']=0;
							$this->dbset->where('idossier_review_id',$post['kelengkapan_dokumen3_export_idossier_review_id']);
							$this->dbset->update('dossier.dossier_review',$data2);
							$iddok2[]=$kidos;
							$status=1;
						}
					}
				}*/

				if(isset($iddok2)){
					//Kirim Email Ke
					$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.C_ITENO,c.C_ITNAM,d.vName,b.dTanggal_upd
							,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad, b.is_old
							from dossier.dossier_review a 
							join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
							join plc2.itemas c on c.C_ITENO=b.iupb_id 
							join hrd.employee d on d.cNip=b.cNip_pengusul
							where a.idossier_review_id = '".$post['kelengkapan_dokumen3_export_idossier_review_id']."'";
					if($this->db_plc0->query($qupd)->num_rows()>0){
						$rupd = $this->db_plc0->query($qupd)->row_array();
					$q="select * from plc2.plc2_upb_team te where te.iteam_id in (".$rupd['ad'].")";
					$d=$this->dbset->query($q)->row_array();
					$iTeamandev=$d['vteam'];
					//team
					$t='IR';
					$sql="select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='".$t."' and te.ldeleted=0";
					$rteam=$this->db_plc0->query($sql)->row_array();
					$team = $rteam['iteam_id'].','.$rupd['ad'];
					$logged_nip =$this->user->gNIP;
					$vkode="";
					if ($rupd['ad'] == 17 && $rupd['is_old']==0) {
						$iTeamandev = 'Andev Export 1';
						$vkode="CK3_REV_TD1";
					}else{
						$iTeamandev = 'Andev Export 2';
						$vkode="CK3_REV_TD2";
					}
					$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
					$dt=$this->dbset->query($sql)->row_array();
					$to = $dt['tto'];
					$cc = $dt['tcc'];

					$idossier_dok_list_id=implode(",",$iddok2);
					$qseldok="select * from dossier.dossier_dok_list li
						inner join dossier.dossier_dokumen do on do.idossier_dokumen_id=li.idossier_dokumen_id
						where li.lDeleted=0 and do.lDeleted=0 and li.idossier_dok_list_id in (".$idossier_dok_list_id.")";
					$qseldok=$this->dbset->query($qseldok);

					$subject="Kelengkapan Dokumen III: UPD ".$rupd['vUpd_no'];
					$content="Diberitahukan bahwa telah ada revised dokumen Kelengkapan Dokumen III UPD pada aplikasi PLC - Export dengan rincian sebagai berikut :<br><br>
						<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
							<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
								<tr>
									<td style='width: 110px;'><b>No UPD</b></td><td style='width: 20px;'> : </td><td>".$rupd['vUpd_no']."</td>
								</tr>
								<tr>
									<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
								</tr>
								<tr>
									<td><b>Tanggal UPD</b></td><td> : </td><td>".$rupd['dTanggal_upd']."</td>
								</tr>
								<tr>
									<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['cNip_pengusul'].' - '.$rupd['vName']."</td>
								</tr>
								<tr>
									<td><b>Produk</b></td><td> : </td><td>".$rupd['C_ITENO'].' - '.$rupd['C_ITNAM']."</td>
								</tr>
								<tr>
									<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
								</tr>
								<tr>
									<td colspan=3>
									<table border='1px' style='border-collapse:collapse;width:100%;border:1px;'>
									 	<tr>
									 		<th>No</th>
									 		<th align='left'>Nama Dokumen</th>
									 		<th align='left'>Keterangan Revised</th>
									 	</tr>";
								if($qseldok->num_rows>=1){
									$no = 1;
									foreach ($qseldok->result_array() as $rsel => $valdok ) {
									$content .=	"<tr>
										 		<td>".$no."</td>
										 		<td>".$valdok['vNama_Dokumen']."</td>
										 		<td>".$valdok['vKeterangan_kelengkapan3']."</td>
										 	</tr>";
									$no++;
									}
								}	 	
					$content .=
									"</table>
									</td>
								</tr>
							</table>
						</div>
						<br/> 
						Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
						Post Master";
					$this->lib_utilitas->send_email($to, $cc, $subject, $content);
					}
					
				}
				//$grid->updated_form();
				$r['revised']=$status;
				$r['status'] = TRUE;
				$r['last_id'] = $post['kelengkapan_dokumen3_export_idossier_review_id'];
				$r['foreign_id'] = $this->input->get('foreign_key');
				$r['company_id'] = $this->input->get('company_id');
				$r['group_id'] = $this->input->get('group_id');
				$r['modul_id'] = $this->input->get('modul_id');
				$r['message'] = "Data Updated Successfuly";
				echo json_encode($r);
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
				$skg=date('Y-m-d H:i:s');
				$this->dbset->where('idossier_review_id', $get['idossier_review_id']);

				$this->dbset->update('dossier.dossier_review', array('iKelengkapan_data3'=>2,'iSubmit_kelengkapan3'=>1,'cCek_kelengkapan3'=>$this->user->gNIP,'dCek_kelengkapan3'=>$skg));
		    	
				//Kirim Email Ke
				$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.C_ITENO,c.C_ITNAM,d.vName,b.dTanggal_upd
						,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
						from dossier.dossier_review a 
						join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
						join plc2.itemas c on c.C_ITENO=b.iupb_id 
						join hrd.employee d on d.cNip=b.cNip_pengusul
						where a.idossier_review_id = '".$get['idossier_review_id']."'";
				$rupd = $this->db_plc0->query($qupd)->row_array();
				$q="select * from plc2.plc2_upb_team te where te.iteam_id in (".$rupd['ad'].")";
				$d=$this->dbset->query($q)->row_array();
				$iTeamandev=$d['vteam'];
				//team
				/*
				$t='IM';
				$sql="select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='".$t."' and te.ldeleted=0";
				$rteam=$this->db_plc0->query($sql)->row_array();
				$team = $rteam['iteam_id'];
				$logged_nip =$this->user->gNIP;

		        $toEmail2='';
				$toEmail = $this->lib_utilitas->get_email_team( $team );
		        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
		        //$arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
		        $arrEmail = $this->lib_utilitas->get_email_by_nip( $logged_nip );                    
		                    
				$to = $cc = '';
				if(is_array($arrEmail)) {
					$count = count($toEmail);
					$to = $toEmail[0];
					for($i=1;$i<$count;$i++) {
						$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
					}
				}	

				//$to = $toEmail2.';'.$toEmail;
				//$cc = $arrEmail;                        

				$to = $arrEmail;
				$cc = $toEmail2.';'.$toEmail;                        
				*/
				$vkode='CK3_APP';
				$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
				$dt=$this->dbset->query($sql)->row_array();
				$to = $dt['tto'];
				$cc = $dt['tcc'];
				$subject="Kelengkapan Dokumen III: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada Approval Kelengkapan Dokumen III pada aplikasi PLC - Export dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>No UPD</b></td><td style='width: 20px;'> : </td><td>".$rupd['vUpd_no']."</td>
							</tr>
							<tr>
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Tanggal UPD</b></td><td> : </td><td>".$rupd['dTanggal_upd']."</td>
							</tr>
							<tr>
								<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['cNip_pengusul'].' - '.$rupd['vName']."</td>
							</tr>
							<tr>
								<td><b>Produk</b></td><td> : </td><td>".$rupd['C_ITENO'].' - '.$rupd['C_ITNAM']."</td>
							</tr>
							<tr>
								<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
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
			case 'getdetailsdok':
				echo $this->getdetailsdok();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

 function getdetailsdok(){
	$sql_data="select doklist.*,kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen,dok.ijml_dok,dok.ibobot,
					divi.vDescription,doklist.istatus_keberadaan,em.vName,rev.*,det.vsubmodul_kategori
					from dossier.dossier_dok_list doklist
					inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=doklist.idossier_dokumen_id
					inner join dossier.dossier_kat_dok_details det on dok.idossier_kat_dok_details_id=det.idossier_kat_dok_details_id
					inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=det.idossier_kat_dok_id
					inner join dossier.dossier_review rev on doklist.idossier_review_id=rev.idossier_review_id
					inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
					left join hrd.employee em on em.cNip=up.vpic
					left join hrd.msdivision divi on divi.iDivID=dok.idivisionId
					where doklist.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0 and up.lDeleted=0 and (divi.lDeleted=0 or divi.lDeleted is null)
					and doklist.idossier_review_id=".$this->input->get('id')."
					order by det.vsubmodul_kategori,dok.iurut_dokumen ASC";
		$q=$this->dbset->query($sql_data);
		$rsel=array('vmodul_kategori','vsubmodul_kategori','vNama_Dokumen','ibobot','vDescription','istatus_keberadaan','istatus_keberadaan','vKeterangan_review','istatus_keberadaan_update','istatus_upload','download','rev1','app1','ket1','ihasil_dossier','rev2','app2','ket2','ihasil_ir','rev3','app3','ket3','ihasil_bdirm','rev4','app4','ket4');
		$data = new StdClass;
		$data->records=$q->num_rows();
		$i=0;
		foreach ($q->result() as $k) {
			$data->rows[$i]['id']=$k->idossier_dok_list_id;
			$z=0;
			foreach ($rsel as $dsel => $vsel) {
				if($vsel=="download"){
					$dataar[$dsel]=$this->downloadlist($k->idossier_dok_list_id,$k->idossier_review_id);
				}elseif($vsel=="istatus_upload"){
					$dataar[$z]=$this->details_status_upload($k->istatus_verifikasi,$k->iStatus_confirm);
				}elseif($vsel=="rev1"){
					$dataar[$z]=$this->details_rev1($k);
				}elseif($vsel=="app1"){
					$dataar[$z]=$this->details_app1($k);
				}elseif($vsel=="ket1"){
					$dataar[$z]=$this->details_ket1($k);
				}elseif($vsel=="rev2"){
					$dataar[$z]=$this->details_rev2($k);
				}elseif($vsel=="app2"){
					$dataar[$z]=$this->details_app2($k);
				}elseif($vsel=="ket2"){
					$dataar[$z]=$this->details_ket2($k);
				}elseif($vsel=="ihasil_dossier"){
					$dataar[$z]=$this->ihasil_dossier($k);
				}elseif($vsel=="rev3"){
					$dataar[$z]=$this->details_rev3($k);
				}elseif($vsel=="app3"){
					$dataar[$z]=$this->details_app3($k);
				}elseif($vsel=="ket3"){
					$dataar[$z]=$this->details_ket3($k);
				}elseif($vsel=="ihasil_ir"){
					$dataar[$z]=$this->ihasil_ir($k);
				}elseif($vsel=="ihasil_bdirm"){
					$dataar[$z]=$this->ihasil_bdirm($k);
				}elseif($vsel=="rev4"){
					$dataar[$z]=$this->details_rev4($k);
				}elseif($vsel=="app4"){
					$dataar[$z]=$this->details_app4($k);
				}elseif($vsel=="ket4"){
					$dataar[$z]=$this->details_ket4($k);
				}else{
					$dataar[$z]=$k->{$vsel};
				}
				$z++;
			}
			$data->rows[$i]['cell']=$dataar;
			$i++;
		}
		return json_encode($data);
 }

 function details_ket4($k){
	$ista3='';
	$status3=0;
	if($k->iStatus_kelengkapan3==2){
		$status3=2;
		$ista3='Approved';
	}elseif($k->iStatus_kelengkapan3==1){
		$status3=1;
		$ista3='Revised';
	}
	$disabled='disabled';
	$revrchek=$k->iStatus_kelengkapan4==1?'checked':'';
	$apprchek=$k->iStatus_kelengkapan4==2?'checked':'';
    $o='';
	if($status3==2){ 
		if ($k->iStatus_kelengkapan4==0){
			$o.='<textarea name="cek_4_keterangan['.$k->idossier_dok_list_id.']" id="cek_4_keterangan_'.$k->idossier_dok_list_id.$disabled.'">'.$k->vKeterangan_kelengkapan4.'</textarea>';
		}else{
			$o.=$k->vKeterangan_kelengkapan4;
		}
	}
	return $o;
}

function details_rev4($k){
	$ista3='';
	$status3=0;
	if($k->iStatus_kelengkapan3==2){
		$status3=2;
		$ista3='Approved';
	}elseif($k->iStatus_kelengkapan3==1){
		$status3=1;
		$ista3='Revised';
	}
			
	$disabled='disabled';
	$revrchek=$k->iStatus_kelengkapan4==1?'checked':'';
	$apprchek=$k->iStatus_kelengkapan4==2?'checked':'';
    $o='';
	if($status3==2){ 
		$o='<input type="checkbox" name="cek_4_'.$disabled.'['.$k->idossier_dok_list_id.']" id="cek_4_'.$disabled.$k->idossier_dok_list_id.'" value="1" class="rev'.$disabled.'" '.$disabled.' '.$revrchek.' />';
	}
	return $o;
}
function details_app4($k){
	$ista3='';
	$status3=0;
	if($k->iStatus_kelengkapan3==2){
		$status3=2;
		$ista3='Approved';
	}elseif($k->iStatus_kelengkapan3==1){
		$status3=1;
		$ista3='Revised';
	}
			
	$disabled='disabled';
	$revrchek=$k->iStatus_kelengkapan4==1?'checked':'';
	$apprchek=$k->iStatus_kelengkapan4==2?'checked':'';
    $o='';
	if($status3==2){ 
		$o='<input type="checkbox" name="cek_4_'.$disabled.'['.$k->idossier_dok_list_id.']" id="cek_4_'.$disabled.$k->idossier_dok_list_id.'" value="2" class="appr_disabled" '.$disabled.' '.$apprchek.' />';
	}
	return $o;
}

function ihasil_bdirm($k){
	$status2=0;
	$ista2='';
	if($k->iStatus_kelengkapan3==2){
		$status2=2;
		$ista2='Approved';
	}elseif($k->iStatus_kelengkapan3==1){
		$status2=1;
		$ista2='Revised';
	}
    return $ista2;
}

function ihasil_ir($k){
	$status2=0;
	$ista2='';
	if($k->iStatus_kelengkapan2==2){
		$status2=2;
		$ista2='Approved';
	}elseif($k->iStatus_kelengkapan2==1){
		$status2=1;
		$ista2='Revised';
	}
    return $ista2;
}

function details_ket3($k){
	$status2=0;
	$ista2='';
	if($k->iStatus_kelengkapan2==2){
		$status2=2;
		$ista2='Approved';
	}elseif($k->iStatus_kelengkapan2==1){
		$status2=1;
		$ista2='Revised';
	}
	$disabled=$k->iKelengkapan_data3==2?'disabled':'';
	$o='';
	if($status2==2){ 
		if ($k->iKelengkapan_data3==0){
			$o.='<textarea name="cek_3_keterangan['.$k->idossier_dok_list_id.']" id="cek_3_keterangan_'.$k->idossier_dok_list_id.$disabled.'">'.$k->vKeterangan_kelengkapan3.'</textarea>';
		}else{
			$o.=$k->vKeterangan_kelengkapan3;
		}
	}
	return $o;
}

function details_rev3($k){
	$status2=0;
	$ista2='';
	if($k->iStatus_kelengkapan2==2){
		$status2=2;
		$ista2='Approved';
	}elseif($k->iStatus_kelengkapan2==1){
		$status2=1;
		$ista2='Revised';
	}
	$disabled=$k->iKelengkapan_data3==2?'disabled':'';
   	$revrchek=$k->iStatus_kelengkapan3==1?'checked':'';
	$appcehek=$k->iStatus_kelengkapan3==2?'checked':'';
    $o='';
	if($status2==2){ 
		$o='<input type="checkbox" name="cek_3_'.$disabled.'['.$k->idossier_dok_list_id.']" id="cek_3_'.$disabled.$k->idossier_dok_list_id.'" value="1" class="rev'.$disabled.'" '.$disabled.' '.$revrchek.' />';
	}
	return $o;
}
function details_app3($k){
	$status2=0;
	$ista2='';
	if($k->iStatus_kelengkapan2==2){
		$status2=2;
		$ista2='Approved';
	}elseif($k->iStatus_kelengkapan2==1){
		$status2=1;
		$ista2='Revised';
	}
	$disabled=$k->iKelengkapan_data3==2?'disabled':'';
   	$revrchek=$k->iStatus_kelengkapan3==1?'checked':'';
	$appcehek=$k->iStatus_kelengkapan3==2?'checked':'';
    $o='';
	if($status2==2){ 
		$o='<input type="checkbox" name="cek_3_'.$disabled.'['.$k->idossier_dok_list_id.']" id="cek_3_'.$disabled.$k->idossier_dok_list_id.'" value="2" class="appr'.$disabled.'" '.$disabled.' '.$appcehek.' />';
	}
	return $o;
}
function ihasil_dossier($k){
	$ista='';
	if($k->iStatus_kelengkapan1==2){
        $status=2;
        $ista='Approved';
    }elseif($k->iStatus_kelengkapan1==1){
        $status=1;
        $ista='Revised';
    }
    return $ista;
}

function details_ket2($k){
	$o=$k->vKeterangan_kelengkapan2;
	return $o;
}

function details_rev2($k){
	$mydept = $this->auth_plcexport->my_depts(TRUE);
	$type='';
	if (isset($mydept)) {
		if((in_array('IR', $mydept))) {
			$type='IR';
		}
	}
	$ty='disabled';
	if($type=='IR'){
	    $ty='';
	}
	$status=0;
    $ista='';
    if($k->iStatus_kelengkapan1==2){
        $status=2;
        $ista='Approved';
    }elseif($k->iStatus_kelengkapan1==1){
        $status=1;
        $ista='Revised';
    }
    $disabled=$k->iKelengkapan_data2!=0?'disabled':'';
    $checked=$k->iStatus_kelengkapan2==2?'checked':'';
    $o='';
	if($status==2){ 
		$o='<input type="checkbox" name="cek_2_'.$disabled.'['.$k->idossier_dok_list_id.']" id="cek_2_'.$disabled.$k->idossier_dok_list_id.'" value="1" class="rev_cek_2'.$disabled.'" '.$disabled.' '.$ty.' disabled="disabled" />';
	}
	return $o;
}
function details_app2($k){
	$mydept = $this->auth_plcexport->my_depts(TRUE);
	$type='';
	if (isset($mydept)) {
		if((in_array('IR', $mydept))) {
			$type='IR';
		}
	}
	$ty='disabled';
	if($type=='IR'){
	    $ty='';
	}
	$status=0;
    $ista='';
    if($k->iStatus_kelengkapan1==2){
        $status=2;
        $ista='Approved';
    }elseif($k->iStatus_kelengkapan1==1){
        $status=1;
        $ista='Revised';
    }
    $disabled=$k->iKelengkapan_data2!=0?'disabled':'';
    $checked=$k->iStatus_kelengkapan2==2?'checked':'';
    $o='';
	if($status==2){ 
		$o='<input type="checkbox" name="cek_2_'.$disabled.'['.$k->idossier_dok_list_id.']" id="cek_2_'.$disabled.$k->idossier_dok_list_id.'" value="2" class="appr_cek_2'.$disabled.'" '.$disabled.' '.$ty.' '.$checked.' disabled="disabled" />';
	}
	return $o;
}

function details_ket1($k){
	$o=$k->vKeterangan_kelengkapan1;
	return $o;
}

function details_rev1($k){
	$status=0;
	$revcheck=$k->iStatus_kelengkapan1==1?'checked':'';
	if(($k->iStatus_confirm==1)&&($k->istatus_verifikasi==1)){
        $status=1;
         $disabled=$k->iStatus_kelengkapan1==2?'disabled':'';
    }
    $o='';
	if($status==1){ 
		$o='<input type="checkbox" name="cek_1_'.$disabled.'['.$k->idossier_dok_list_id.']" id="cek_1_'.$disabled.$k->idossier_dok_list_id.'" value="1" class="rev_cek_1" '.$disabled.' '.$revcheck.' disabled="disabled" />';
	}
	return $o;
}
function details_app1($k){
	$status=0;
	$appchek=$k->iStatus_kelengkapan1==2?'checked':'';
	if(($k->iStatus_confirm==1)&&($k->istatus_verifikasi==1)){
        $status=1;
         $disabled=$k->iStatus_kelengkapan1==2?'disabled':'';
    }
    $o='';
	if($status==1){ 
		$o='<input type="checkbox" name="cek_1_'.$disabled.'['.$k->idossier_dok_list_id.']" id="cek_1_'.$disabled.$k->idossier_dok_list_id.'" value="2" class="appr_cek_1" '.$disabled.' '.$appchek.' disabled="disabled" />';
	}
	return $o;
}
function details_status_upload($a,$b){
	$s=($a==1)&&($b==1)?'Uploaded':'Need Upload';
	return $s;
}

 function downloadlist($idossier_dok_list_id,$idossier_review_id){
 	$sql = 'select * from dossier.dossier_dok_list_file a where a.idossier_dok_list_id = "'.$idossier_dok_list_id.'" and a.lDeleted=0';
    $rows = $this->db_plc0->query($sql);
    $o='';
        if($rows->num_rows()>=1){
            foreach ($rows->result_array() as $kr => $vr) {
                    $file='';
                    if ($vr['vFilename'] != "") {
                        $id  = $idossier_review_id;
                        $value = $vr['vFilename'];  
                        if (file_exists('./files/plc/dossier_dok/'.$id.'/'.$value)) {
                            $link = base_url().'processor/plc/dossier/upload/dokumen?action=download&id='.$id.'&file='.$value;
                            $file = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">'.$vr['vFilename'].'</a><br />';
                        }else{
                            $file=$vr['vFilename'];
                        }
                    }else{
                        $file="File Tersedia";
                    }
   				$o.=$file;
                }
            }else{
            }
    return $o;
 } 
   
function listBox_Action($row, $actions) {
 	$sql_cek_lengkap1='select * 
		from dossier.dossier_review a
		join dossier.dossier_dok_list b on b.idossier_review_id=a.idossier_review_id
		where a.idossier_review_id="'.$row->idossier_review_id.'" 
		and b.iStatus_kelengkapan3 = 0';
	$data_lengkap1 = $this->dbset->query($sql_cek_lengkap1)->result_array();
 	if (empty($data_lengkap1)) {
 		// status sudah diapprove or reject , button edit hide 
 		if($row->iKelengkapan_data3!=0){
	 		unset($actions['edit']);
	 		unset($actions['delete']);
 		}
 	}
	 return $actions;

 }  


function listBox_kelengkapan_dokumen3_export_dossier_prioritas_iSemester ($value) {
	return 'Semester '.$value;
}

function listBox_kelengkapan_dokumen3_export_dossier_upd_iTeam_andev ($value) {
	$q="select * from plc2.plc2_upb_team te where te.iteam_id=".$value;
	$d=$this->dbset->query($q)->row_array();
	return $d['vteam'];
}

function listBox_kelengkapan_dokumen3_export_dossier_upd_iSediaan ($value) {
	if ($value == 1) {
		$sediaan = 'Solid';
	}else{
		$sediaan = 'Injection';
	}

	return $sediaan;
}

/*manipulasi view object form start*/

//Revisi

function updateBox_kelengkapan_dokumen3_export_dPembuatan_dossier($field, $id, $value, $rowData) {
	return $value;
}
function updateBox_kelengkapan_dokumen3_export_dPeriksa_bdirm($field, $id, $value, $rowData) {
	return $value;
}
function updateBox_kelengkapan_dokumen3_export_dPeriksa_ir($field, $id, $value, $rowData) {
	return $value;
}
function updateBox_kelengkapan_dokumen3_export_vUpd_no($field, $id, $value, $rowData) {
	$sql = 'select * from dossier.dossier_upd a where a.idossier_upd_id="'.$rowData['idossier_upd_id'].'" ';
	$data_upd = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];

	}else{

		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];
	}
	
	return $return;
}

function updateBox_kelengkapan_dokumen3_export_vNama_usulan($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vNama_usulan'];

		}
		else{
			$return= $rows['vNama_usulan'];
			$return .= '
			<input type="hidden" name="isdraft" id="isdraft">
			';
		}
		
		return $return;
}

function updateBox_kelengkapan_dokumen3_export_iTeam_andev($field, $id, $value, $rowData) {
	$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
	$q="select * from plc2.plc2_upb_team te where te.iteam_id=".$rows['iTeam_andev'];
	$d=$this->dbset->query($q)->row_array();
	return $d['vteam'];
}

function updateBox_kelengkapan_dokumen3_export_cCek_kelengkapan3($field, $id, $value, $rowData) {

		if ($rowData['iKelengkapan_data3'] <> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cCek_kelengkapan3']))->row_array();

			if ($rowData['iKelengkapan_data3'] == 2) {
				$palue='Approved by '.$rows['vName'].', Remark :'.$rowData['vRemark_kelengkapan3'] ;	
			}else{
				$palue='Rejected by '.$rows['vName'].', Remark :'.$rowData['vRemark_kelengkapan3'];	
			}
			
		}else{
			$palue='Waiting Approval';
		}

		if ($this->input->get('action') == 'view') {
			$return= $palue;

		}
		else{
			$return= $palue;
		}
		
		return $return;
}

function updateBox_kelengkapan_dokumen3_export_iKelengkapan_data3($field, $id, $value, $rowData) {
		if ($rowData['iKelengkapan_data3'] <> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cCek_kelengkapan3']))->row_array();

			if ($rowData['iKelengkapan_data3'] == 2) {
				$palue='Approved by '.$rows['vName'].' pada '.$rowData['dCek_kelengkapan3'].', Remark :'.$rowData['vRemark_kelengkapan3'] ;	
			}else{
				$palue='Rejected by '.$rows['vName'].' pada '.$rowData['dCek_kelengkapan3'].', Remark :'.$rowData['vRemark_kelengkapan3'];	
			}
			
		}else{
			$palue='Waiting Approval';
		}

		if ($this->input->get('action') == 'view') {
			$return= $palue;

		}
		else{
			$return= $palue;
		}
		
		return $return;
}

function updateBox_kelengkapan_dokumen3_export_rincian_dok($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
		
		//$return1= print_r($rows);

		$data['rows'] = $rows;
		$data['iSediaan'] = $rows['iSediaan'];
		$data['idossier_upd_id'] =  $rows['idossier_upd_id'];



		$sql_doc='	select * 
					from dossier.dossier_dokumen a 
					join dossier.dossier_dok_list b on b.idossier_dokumen_id=a.idossier_dokumen_id 
					join dossier.dossier_kat_dok c on c.idossier_kat_dok_id=a.idossier_kat_dok_id
					where a.lDeleted=0
					and b.lDeleted=0
					and b.idossier_review_id="'.$rowData['idossier_review_id'].'"';
		$data['docs'] = $this->db_plc0->query($sql_doc)->result_array();
		//$return= print_r($rows);
		
/*

		if ($rows['iSediaan'] == 1  ) {
			//solid
			$return=  $this->load->view('kelengkapan_dokumen3_export_solid',$data,TRUE);
		}else{
			// non solid
			$return= $this->load->view('kelengkapan_dokumen3_export_nonsolid',$data,TRUE);
		}
*/		
		//$return= $this->load->view('kelengkapan_dokumen3_export',$data,TRUE);	

		/*$sql_negara="select * from dossier.dossier_upd_negara ne 
		inner join dossier.dossier_negara neg on neg.idossier_negara_id = ne.idossier_negara_id
		where ne.lDeleted=0 and ne.idossier_upd_id=".$rowData['idossier_upd_id'];
		$data['mnnegara'] = $this->dbset->query($sql_negara)->result_array();*/

		//data row table dokumen
		$sql_data="select doklist.*,kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen,dok.ijml_dok,dok.ibobot,
					divi.vDescription,doklist.istatus_keberadaan,em.vName,rev.*,det.vsubmodul_kategori
					from dossier.dossier_dok_list doklist
					inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=doklist.idossier_dokumen_id
					inner join dossier.dossier_kat_dok_details det on dok.idossier_kat_dok_details_id=det.idossier_kat_dok_details_id
					inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=det.idossier_kat_dok_id
					inner join dossier.dossier_review rev on doklist.idossier_review_id=rev.idossier_review_id
					inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
					left join hrd.employee em on em.cNip=up.vpic
					left join hrd.msdivision divi on divi.iDivID=dok.idivisionId
					where doklist.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0 and up.lDeleted=0 and (divi.lDeleted=0 or divi.lDeleted is null)
					and doklist.idossier_review_id=".$rowData['idossier_review_id']."
					order by kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen ASC";
		$data['dokumen']=$this->dbset->query($sql_data)->result_array();
		$return = '
			<script type="text/javascript">
				$("label[for=\''.$id.'\']").hide();
				$("label[for=\''.$id.'\']").next().css("margin-left",10);
				$("label[for=\''.$id.'\']").parent().css("overflow","");
			</script>
		';
		$data['id']=$id;
		$data['idossier_review_id']=$rowData['idossier_review_id'];
		$return.=$this->load->view('file_cek_kelengkapan_3',$data,TRUE);	
		return $return;
		
}


function after_update_processor($row, $insertId, $postData, $old_data) {
		/*
		$urutan = 1;
			foreach($postData['idossier_dok_list_id'] as $k=>$v) {
				
					if($v != '') {

						if (empty($postData['iStatus_kelengkapan3_'.$v])) {
								$istatus = 0;
						}else{
							foreach($postData['iStatus_kelengkapan3_'.$v] as $k1=>$v1) {
								$istatus = $v1;
							}		
						}
						

						$data=array('iStatus_kelengkapan3'=>$istatus);
						$this -> db -> where('idossier_dok_list_id',$v);
						$updet = $this -> db -> update('dossier.dossier_dok_list', $data);

					}
			}*/
		$logged_nip =$this->user->gNIP;
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.C_ITENO,c.C_ITNAM,d.vName,b.dTanggal_upd,a.iSubmit_kelengkapan3
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.itemas c on c.C_ITENO=b.iupb_id 
				join hrd.employee d on d.cNip=b.cNip_pengusul
				where a.idossier_review_id = '".$insertId."'";

		$rupd = $this->db_plc0->query($qupd);
		if($rupd->num_rows()>0){
			$rupd = $this->db_plc0->query($qupd)->row_array();

			$submit = $rupd['iSubmit_kelengkapan3'] ;
			
			$q="select * from plc2.plc2_upb_team te where te.iteam_id in (".$rupd['ad'].")";
			$d=$this->dbset->query($q)->row_array();
			$iTeamandev=$d['vteam'];

			if ($submit == 1) {
				$ad = $rupd['ad'];
				$team = $ad;
				//$team = '81' ;

		        $toEmail2='';
				$toEmail = $this->lib_utilitas->get_email_team( $team );
		        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
		        //$arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
		        $arrEmail = $this->lib_utilitas->get_email_by_nip( $logged_nip );                    
		                    
				$to = $cc = '';
				if(is_array($arrEmail)) {
					$count = count($toEmail);
					$to = $toEmail[0];
					for($i=1;$i<$count;$i++) {
						$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
					}
				}	

				//$to = $toEmail2.';'.$toEmail;
				//$cc = $arrEmail;                        

				$to = $arrEmail;
				$cc = $toEmail2.';'.$toEmail;                        

					$subject="Kelengkapan Dokumen III: UPD ".$rupd['vUpd_no'];
					$content="Diberitahukan bahwa telah ada inputan Kelengkapan Dokumen III UPD  pada aplikasi PLC - Export dengan rincian sebagai berikut :<br><br>
						<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
							<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
								<tr>
									<td style='width: 110px;'><b>No UPD</b></td><td style='width: 20px;'> : </td><td>".$rupd['vUpd_no']."</td>
								</tr>
								<tr>
									<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
								</tr>
								<tr>
									<td><b>Tanggal UPD</b></td><td> : </td><td>".$rupd['dTanggal_upd']."</td>
								</tr>
								<tr>
									<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['cNip_pengusul'].' - '.$rupd['vName']."</td>
								</tr>
								<tr>
									<td><b>Produk</b></td><td> : </td><td>".$rupd['C_ITENO'].' - '.$rupd['C_ITNAM']."</td>
								</tr>
								<tr>
									<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
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



/*function pendukung start*/  

function before_update_processor($row, $postData) {

	// ubah status submit
		if($postData['isdraft']==true){
			$postData['iSubmit_kelengkapan3']=0;
		} 
		else{
			$postData['iSubmit_kelengkapan3']=1;
			//$postData['cCek_kelengkapan3']=$this->user->gNIP;
			//$postData['iKelengkapan_data3']= date('Y-m-d H:i:s');

		} 
	
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	unset($postData['dPembuatan_dossier']);
	unset($postData['dPeriksa_ir']);
	unset($postData['dPeriksa_bdirm']);
	return $postData;

}


function manipulate_update_button($buttons, $rowData) {
	$cNip= $this->user->gNIP;

	$js = $this->load->view('kelengkapan_dokumen3_export_js');

	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/kelengkapan/dokumen3/export?action=approve&idossier_review_id='.$rowData['idossier_review_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_kelengkapan_dokumen3_export">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/kelengkapan/dokumen3/export?action=reject&idossier_review_id='.$rowData['idossier_review_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_kelengkapan_dokumen3_export">Reject</button>';

	$update = '<button onclick="javascript:update_btn_back(\'kelengkapan_dokumen3_export\', \''.base_url().'processor/plc/kelengkapan/dokumen3/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_kelengkapan_dokumen3_export">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'kelengkapan_dokumen3_export\', \''.base_url().'processor/plc/kelengkapan/dokumen3/export?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_draft_kelengkapan_dokumen3_export">Update</button>';


	$sql_cek_lengkap3='select * 
					from dossier.dossier_review a
					join dossier.dossier_dok_list b on b.idossier_review_id=a.idossier_review_id
					join dossier.dossier_dokumen c on c.idossier_dokumen_id=b.idossier_dokumen_id
					where a.idossier_review_id="'.$rowData['idossier_review_id'].'" 
					and b.iStatus_kelengkapan3 != 2 
					and b.lDeleted=0
					and a.lDeleted=0
					and c.lDeleted=0';
	$data_lengkap3 = $this->dbset->query($sql_cek_lengkap3)->result_array();

	$sql="select * from dossier.dossier_review rev
		inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
		where rev.lDeleted=0 and up.lDeleted=0 and rev.idossier_review_id=".$rowData['idossier_review_id'];
	$dt=$this->dbset->query($sql)->row_array();
	$submit = '<button onclick="javascript:setuju(\'kelengkapan_dokumen3_export\', \''.base_url().'processor/plc/kelengkapan/dokumen3/export?action=confirm&last_id='.$this->input->get('id').'&idossier_review_id='.$rowData['idossier_review_id'].'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this,'.$rowData['idossier_review_id'].', \''.$dt['vUpd_no'].'\')" class="ui-button-text icon-save" id="button_save_kelengkapan_dokumen3_export">Submit</button>';

	if ($this->input->get('action') == 'view') {unset($buttons['update']);}

	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		
		if ($rowData['iSubmit_kelengkapan3']== 0) {
			// jika masih draft , show button update draft & update submit 

			//Revisi ------- Button update draft ubah ke save as draft, dan submit
				// cek sudah verifikasi semua belum , kalau belum ceklis maka tombol draft saja 
				if (empty($data_lengkap3)) {
					// sudah ceklist verify semua
					$buttons['update'] = $updatedraft.$submit.$js;		
				}else{
					$buttons['update'] = $updatedraft.$js;		
					
				}
			
		}else{
			// sudah disubmit , show button approval 
			if ($rowData['iKelengkapan_data3']== 0) {
				$buttons['update'] = $submit.$js;
			}
		}

		/*if($rowData['iKelengkapan_data2']<>2){
			unset($buttons['update_back']);
			unset($buttons['update']);
		}
		*/

		//$buttons['update'] = $update.$updatedraft.$approve.$reject.$js;
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
								var url = "'.base_url().'processor/plc/kelengkapan/dokumen3/export";								
								if(o.status == true) {
									
									
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_kelengkapan_dokumen3_export").html(data);
										$("#button_approve_kelengkapan_dokumen3_export").hide();
										$("#button_reject_kelengkapan_dokumen3_export").hide();
									});
									
								}
									reload_grid("grid_kelengkapan_dokumen3_export");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_kelengkapan_dokumen3_export_approve" action="'.base_url().'processor/plc/kelengkapan/dokumen3/export?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_review_id" value="'.$this->input->get('idossier_review_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark_kelengkapan3"></textarea>
		<button type="button" onclick="submit_ajax(\'form_kelengkapan_dokumen3_export_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_review_id = $post['idossier_review_id'];
		$vRemark_kelengkapan3 = $post['vRemark_kelengkapan3'];

		$data=array('iKelengkapan_data3'=>'2','cCek_kelengkapan3'=>$cNip , 'dCek_kelengkapan3'=>date('Y-m-d H:i:s'), 'vRemark_kelengkapan3'=>$vRemark_kelengkapan3);
		$this -> db -> where('idossier_review_id', $idossier_review_id);
		$updet = $this -> db -> update('dossier.dossier_review', $data);

		$logged_nip =$this->user->gNIP;
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.C_ITENO,c.C_ITNAM,d.vName,b.dTanggal_upd,a.iSubmit_kelengkapan3
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.itemas c on c.C_ITENO=b.iupb_id 
				join hrd.employee d on d.cNip=b.cNip_pengusul
				where a.idossier_review_id = '".$idossier_review_id."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();
		$submit = $rupd['iSubmit_kelengkapan3'] ;
		$q="select * from plc2.plc2_upb_team te where te.iteam_id in (".$rupd['ad'].")";
		$d=$this->dbset->query($q)->row_array();
		$iTeamandev=$d['vteam'];
		if ($updet == 1) {
				

			$ad = $rupd['ad'];

			//$team = $dr ;
			$team = $ad;
			//$team = '81' ;

	        $toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_team( $team );
	        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
	        //$arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
	        $arrEmail = $this->lib_utilitas->get_email_by_nip( $logged_nip );                    
	                    
			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($toEmail);
				$to = $toEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
				}
			}	

			//$to = $toEmail2.';'.$toEmail;
			//$cc = $arrEmail;                        

			$to = $arrEmail;
			$cc = $toEmail2.';'.$toEmail;                        

				$subject="Approval Kelengkapan Dokumen III: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada approval Kelengkapan Dokumen III UPD  pada aplikasi PLC - Export dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>No UPD</b></td><td style='width: 20px;'> : </td><td>".$rupd['vUpd_no']."</td>
							</tr>
							<tr>
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Tanggal UPD</b></td><td> : </td><td>".$rupd['dTanggal_upd']."</td>
							</tr>
							<tr>
								<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['cNip_pengusul'].' - '.$rupd['vName']."</td>
							</tr>
							<tr>
								<td><b>Produk</b></td><td> : </td><td>".$rupd['C_ITENO'].' - '.$rupd['C_ITNAM']."</td>
							</tr>
							<tr>
								<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}

		$data['status']  = true;
		$data['last_id'] = $post['idossier_review_id'];
		return json_encode($data);
	}


	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_kelengkapan_dokumen3_export_vRemark_kelengkapan3").val();
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
								var url = "'.base_url().'processor/plc/kelengkapan/dokumen3/export";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_kelengkapan_dokumen3_export").html(data);
										 $("#button_approve_kelengkapan_dokumen3_export").hide();
										$("#button_reject_kelengkapan_dokumen3_export").hide();
									});
									
								}
									reload_grid("grid_kelengkapan_dokumen3_export");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_kelengkapan_dokumen3_export_reject" action="'.base_url().'processor/plc/kelengkapan/dokumen3/export?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_review_id" value="'.$this->input->get('idossier_review_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark_kelengkapan3" id="reject_kelengkapan_dokumen3_export_vRemark_kelengkapan3" class="required" required="required"></textarea>
		<button type="button" onclick="submit_ajax(\'form_kelengkapan_dokumen3_export_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	
	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_review_id = $post['idossier_review_id'];
		$vRemark_kelengkapan3 = $post['vRemark_kelengkapan3'];

		$data=array('iKelengkapan_data3'=>'1','cCek_kelengkapan3'=>$cNip , 'dCek_kelengkapan3'=>date('Y-m-d H:i:s'), 'vRemark_kelengkapan3'=>$vRemark_kelengkapan3);
		$this -> db -> where('idossier_review_id', $idossier_review_id);
		$updet = $this -> db -> update('dossier.dossier_review', $data);

		$logged_nip =$this->user->gNIP;
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.C_ITENO,c.C_ITNAM,d.vName,b.dTanggal_upd,a.iSubmit_kelengkapan3
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.itemas c on c.C_ITENO=b.iupb_id 
				join hrd.employee d on d.cNip=b.cNip_pengusul
				where a.idossier_review_id = '".$idossier_review_id."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();
		$submit = $rupd['iSubmit_kelengkapan3'] ;
		$q="select * from plc2.plc2_upb_team te where te.iteam_id in (".$rupd['ad'].")";
		$d=$this->dbset->query($q)->row_array();
		$iTeamandev=$d['vteam'];

		if ($updet == 1) {
				

			$ad = $rupd['ad'];

			//$team = $dr ;
			$team = $ad;
			//$team = '81' ;

	        $toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_team( $team );
	        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
	        //$arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
	        $arrEmail = $this->lib_utilitas->get_email_by_nip( $logged_nip );                    
	                    
			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($toEmail);
				$to = $toEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
				}
			}	

			//$to = $toEmail2.';'.$toEmail;
			//$cc = $arrEmail;                        

			$to = $arrEmail;
			$cc = $toEmail2.';'.$toEmail;                        

				$subject="Approval Kelengkapan Dokumen III: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada approval Kelengkapan Dokumen III UPD  pada aplikasi PLC - Export dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>No UPD</b></td><td style='width: 20px;'> : </td><td>".$rupd['vUpd_no']."</td>
							</tr>
							<tr>
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Tanggal UPD</b></td><td> : </td><td>".$rupd['dTanggal_upd']."</td>
							</tr>
							<tr>
								<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['cNip_pengusul'].' - '.$rupd['vName']."</td>
							</tr>
							<tr>
								<td><b>Produk</b></td><td> : </td><td>".$rupd['C_ITENO'].' - '.$rupd['C_ITNAM']."</td>
							</tr>
							<tr>
								<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}


		$data['status']  = true;
		$data['last_id'] = $post['idossier_review_id'];
		return json_encode($data);
	}



/*function pendukung end*/    	

	

	public function output(){
		$this->index($this->input->get('action'));
	}

}

