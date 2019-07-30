<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kelengkapan_dokumen_export extends MX_Controller {
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
		$grid->setTitle('Cek Kelengkapan Dokumen');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_review');		
		$grid->setUrl('kelengkapan_dokumen_export');
		$grid->addList('dossier_upd.vUpd_no','dossier_upd.vNama_usulan','dossier_upd.iTeam_andev','dossier_upd.iSediaan','iSemester','iTahun');
		$grid->setSortBy('dossier_upd.vUpd_no');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('vUpd_no','vNama_usulan','iTeam_andev','rincian_dok');

		//setting widht grid
		$grid ->setWidth('dossier_upd.vUpd_no', '100'); 
		$grid->setWidth('dossier_upd.iTeam_andev', '100'); 
		$grid->setWidth('dossier_upd.iSediaan', '100'); 
		$grid->setWidth('iSemester', '100'); 
		$grid->setWidth('iTahun', '100'); 
		$grid->setWidth('iKelengkapan_data', '100'); 
		$grid->setWidth('dossier_upd.vNama_usulan', '250'); 
		$grid->setWidth('lDeleted', '100'); 
		
		$grid->setAlign('iSemester','center');
		$grid->setAlign('iTahun','center');
		
		//modif label
		$grid->setLabel('vUpd_no','No UPD'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 

		$grid->setLabel('dossier_upd.vUpd_no','No UPD'); 
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Usulan'); 
		$grid->setLabel('dossier_upd.iTeam_andev','Team Andev'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 


		$grid->setLabel('iSubmit_kelengkapan1','Status Submit'); 
		$grid->setLabel('iKelengkapan_data','Status Confirm'); 
		$grid->setLabel('iTeam_andev','Team Andev'); 
		$grid->setLabel('iNegara','Negara'); 
		$grid->setLabel('dCek_kelengkapan1','Submitted at'); 
		$grid->setLabel('cCek_kelengkapan1','Status Submit'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 
		$grid->setLabel('iSemester','Semester Prioritas'); 
		$grid->setLabel('iTahun','Tahun Prioritas');

		$grid->setFormUpload(TRUE);

		$grid->setSearch('dossier_upd.vUpd_no');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('dossier_upd.iSediaan','combobox','',array(''=>'Pilih','1'=>'Solid','2'=>'Non Solid'));
		$grid->changeFieldType('iKelengkapan_data','combobox','',array('0'=>'Waiting Approval','1'=>'Rejected','2'=>'Approved'));
		$grid->changeFieldType('iSubmit_kelengkapan1','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submitted'));
		
		//Flag untuk UPD sesuai dengan PIC Andev masing2
		$mydept = $this->auth_plcexport->my_depts(TRUE);
		if($this->auth_plcexport->is_manager()){
			$x=$this->auth_plcexport->dept();
			$manager=$x['manager'];
			$q="select te.iteam_id from plc2.plc2_upb_team te where te.vnip in ('".$this->user->gNIP."') and te.iTipe=2";
			if(in_array('BDI', $manager)){
				$type='BDI';
				$q.=" and vtipe='".$type."'";
				$d=$this->dbset->query($q)->row_array();
				if($d['iteam_id']==91){//BDIRM 1
					$sq='dossier_upd.iTeam_andev in (17)';
					$grid->setQuery($sq, null);
				}elseif ($d['iteam_id']==78) {
					$sq='dossier_upd.iTeam_andev in (40)';
					$grid->setQuery('('.$sq.' or is_old=1)', null);
				}
			}elseif(in_array('TD', $manager)){$type='TD';
				$grid->setQuery('dossier_upd.vpic IN (select vnip from plc2.plc2_upb_team_item where iteam_id in ('.$this->auth_plcexport->my_teams().'))', null);
			}elseif(in_array('AD', $manager)){$type='AD';
				$grid->setQuery('dossier_upd.vpic_andev IN (select vnip from plc2.plc2_upb_team_item where iteam_id in ('.$this->auth_plcexport->my_teams().'))', null);
			}else{}
		}else{
			$x=$this->auth_plcexport->dept();
			$team=$x['team'];
			if(in_array('TD', $team)){
				$type='TD';
				$q="select * from plc2.plc2_upb_team_item it where it.lDeleted=0 and it.vnip='".$this->user->gNIP."'";
				$dt=$this->dbset->query($q);
				if($dt->num_rows()!=0){
					$d=$dt->row_array();
					if($d['iapprove']==1){
						$grid->setQuery('dossier_upd.vpic IN (select vnip from plc2.plc2_upb_team_item where iteam_id in ('.$this->auth_plcexport->my_teams().'))', null);
					}else{
						$grid->setQuery('dossier_upd.vpic IN ("'.$this->user->gNIP.'")', null);
					}
				}else{
					$grid->setQuery('dossier_upd.vpic IN ("'.$this->user->gNIP.'")', null);
				}
			}elseif(in_array('AD', $team)){$type='AD';
				//cek karyawan tapi memiliki access approval
				$q="select * from plc2.plc2_upb_team_item it where it.lDeleted=0 and it.vnip='".$this->user->gNIP."'";
				$dt=$this->dbset->query($q);
				if($dt->num_rows()!=0){
					$d=$dt->row_array();
					if($d['iapprove']==1){
						$grid->setQuery('dossier_upd.vpic_andev IN (select vnip from plc2.plc2_upb_team_item where iteam_id in ('.$this->auth_plcexport->my_teams().'))', null);
					}else{
						$grid->setQuery('dossier_upd.vpic_andev IN ("'.$this->user->gNIP.'")', null);
					}
				}else{
					$grid->setQuery('dossier_upd.vpic_andev IN ("'.$this->user->gNIP.'")', null);
				}
				
			}else{}
		}

	//Field mandatori
		$grid->setRequired('iSediaan');	
		$grid->setRequired('iTeam_andev');	
		$grid->setRequired('lDeleted');	

		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id', 'inner');		
		//$grid->setJoinTable('dossier.dossier_prioritas_detail', 'dossier_prioritas_detail.idossier_upd_id = dossier_upd.idossier_upd_id', 'inner');
		//$grid->setJoinTable('dossier.dossier_prioritas', 'dossier_prioritas.idossier_prioritas_id = dossier_prioritas_detail.idossier_prioritas_id', 'inner');

		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setQuery('dossier_review.lDeleted', 0);
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_review.iApprove_review', 2);
		$grid->setQuery('dossier_review.iApprove_keb != 1',NULL);
		$grid->setQuery('dossier_review.iApprove_review != 1',NULL);
		$grid->setQuery('dossier_review.iApprove_verify != 1',NULL);
		$grid->setQuery('dossier_review.iApprove_confirm != 1',NULL);

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
					if($kpost=='cek_1_'){
						$idossier_dok_list_id=$vpost;
					}
					if($kpost=='cek_1_keterangan'){
						foreach ($vpost as $kp => $vp) {
							$keterangan[$kp]=$vp;
						}
					}
				}
				if(count($idossier_dok_list_id)>=1){
					foreach ($idossier_dok_list_id as $kidos =>$valdos ) {
						$data=array();
						if($valdos==2){
							$data['iStatus_kelengkapan1']=2;
							$data['vKeterangan_kelengkapan1']=$keterangan[$kidos];
							$this->dbset->where('idossier_dok_list_id',$kidos);
							$this->dbset->update('dossier.dossier_dok_list',$data);
							$iddok[]=$kidos;
						}else{
							$data['iStatus_confirm']=0;
							$data['istatus_verifikasi']=0;
							$data['iStatus_kelengkapan1']=$valdos;
							$data['vKeterangan_kelengkapan1']=$keterangan[$kidos];
							$this->dbset->where('idossier_dok_list_id',$kidos);
							$this->dbset->update('dossier.dossier_dok_list',$data);
							$irevdok[]=$kidos;
						}
					}
				}

				if(isset($iddok)){
					/*$id=implode(",", $iddok);
					$sqli="select dok.* from dossier.dossier_dok_list li
						inner join dossier.dossier_dokumen dok on li.idossier_dokumen_id=dok.idossier_dokumen_id
						where li.lDeleted=0 and dok.lDeleted=0 and li.idossier_dok_list_id in (".$id.")
						group by dok.idossier_dokumen_id";
					$rsqli=$this->dbset->query($sqli)->result_array();
					$vdok=array();
					foreach ($rsqli as $kval => $vval) {
						$vdok[]=$vval['vNama_Dokumen'];
					}*/
					//Kirim Email Ke
					$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.C_ITENO,c.C_ITNAM,d.vName,b.dTanggal_upd
							,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
							from dossier.dossier_review a 
							join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
							join plc2.itemas c on c.C_ITENO=b.iupb_id 
							join hrd.employee d on d.cNip=b.cNip_pengusul
							where a.idossier_review_id = '".$post['kelengkapan_dokumen_export_idossier_review_id']."'";
					$rupd = $this->db_plc0->query($qupd)->row_array();
					$q="select * from plc2.plc2_upb_team te where te.iteam_id in (".$rupd['ad'].")";
					$d=$this->dbset->query($q)->row_array();
					$iTeamandev=$d['vteam'];
					//team
					$t='IR';
					$sql="select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='".$t."' and te.ldeleted=0";
					$rteam=$this->db_plc0->query($sql)->row_array();
					$team = $rteam['iteam_id'];
					$logged_nip =$this->user->gNIP;
					/*
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
					$cc = $toEmail2.';'.$toEmail;  */
					$vkode="";
					if ($rupd['ad'] == 17) {
						$iTeamandev = 'Andev Export 1';
						$vkode="CK1_APP_AD1";
					}else{
						$iTeamandev = 'Andev Export 2';
						$vkode="CK1_APP_AD2";
					}
					$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
					$dt=$this->dbset->query($sql)->row_array();
					$to = $dt['tto'];
					$cc = $dt['tcc'];      

					//Details Dokumen
					$idossier_dok_list_id=implode(",",$iddok);
					$qseldok="select * from dossier.dossier_dok_list li
						inner join dossier.dossier_dokumen do on do.idossier_dokumen_id=li.idossier_dokumen_id
						where li.lDeleted=0 and do.lDeleted=0 and li.idossier_dok_list_id in (".$idossier_dok_list_id.")";
					$qseldok=$this->dbset->query($qseldok);                

					$subject="Kelengkapan Dokumen I: UPD ".$rupd['vUpd_no'];
					$content="Diberitahukan bahwa telah ada Approval Kelengkapan Dokumen I UPD  pada aplikasi PLC - Export dengan rincian sebagai berikut :<br><br>
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
									 		<th>Nama Dokumen</th>
									 	</tr>";
								if($qseldok->num_rows>=1){
									$no = 1;
									foreach ($qseldok->result_array() as $rsel => $valdok ) {
									$content .=	"<tr>
										 		<td>".$no."</td>
										 		<td>".$valdok['vNama_Dokumen']."</td>
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
				if(isset($irevdok)){
					/*$id=implode(",", $iddok);
					$sqli="select dok.* from dossier.dossier_dok_list li
						inner join dossier.dossier_dokumen dok on li.idossier_dokumen_id=dok.idossier_dokumen_id
						where li.lDeleted=0 and dok.lDeleted=0 and li.idossier_dok_list_id in (".$id.")
						group by dok.idossier_dokumen_id";
					$rsqli=$this->dbset->query($sqli)->result_array();
					$vdok=array();
					foreach ($rsqli as $kval => $vval) {
						$vdok[]=$vval['vNama_Dokumen'];
					}*/
					//Kirim Email Ke
					$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.C_ITENO,c.C_ITNAM,d.vName,b.dTanggal_upd
							,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad, b.is_old
							from dossier.dossier_review a 
							join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
							join plc2.itemas c on c.C_ITENO=b.iupb_id 
							join hrd.employee d on d.cNip=b.cNip_pengusul
							where a.idossier_review_id = '".$post['kelengkapan_dokumen_export_idossier_review_id']."'";
					$rupd = $this->db_plc0->query($qupd)->row_array();
					$q="select * from plc2.plc2_upb_team te where te.iteam_id in (".$rupd['ad'].")";
					$d=$this->dbset->query($q)->row_array();
					$iTeamandev=$d['vteam'];
					//team
					$t='IR';
					$sql="select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='".$t."' and te.ldeleted=0";
					$rteam=$this->db_plc0->query($sql)->row_array();
					$team = $rteam['iteam_id'];
					$logged_nip =$this->user->gNIP;
					/*
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
					$cc = $toEmail2.';'.$toEmail;  */
					$vkode="";
					if ($rupd['ad'] == 17 && $rupd['ad']==0) {
						$iTeamandev = 'Andev Export 1';
						$vkode="CK1_REV_TD1";
					}else{
						$iTeamandev = 'Andev Export 2';
						$vkode="CK1_REV_TD2";
					}
					$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
					$dt=$this->dbset->query($sql)->row_array();
					$to = $dt['tto'];
					$cc = $dt['tcc'];      

					//Details Dokumen
					$idossier_dok_list_id=implode(",",$irevdok);
					$qseldok="select * from dossier.dossier_dok_list li
						inner join dossier.dossier_dokumen do on do.idossier_dokumen_id=li.idossier_dokumen_id
						where li.lDeleted=0 and do.lDeleted=0 and li.idossier_dok_list_id in (".$idossier_dok_list_id.")";
					$qseldok=$this->dbset->query($qseldok);                

					$subject="Kelengkapan Dokumen I: UPD ".$rupd['vUpd_no'];
					$content="Diberitahukan bahwa telah ada Reviced Kelengkapan Dokumen I UPD  pada aplikasi PLC - Export dengan rincian sebagai berikut :<br><br>
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
									 		<th>Nama Dokumen</th>
									 		<th>Keterangan Reviced</th>
									 	</tr>";
								if($qseldok->num_rows>=1){
									$no = 1;
									foreach ($qseldok->result_array() as $rsel => $valdok ) {
									$content .=	"<tr>
										 		<td>".$no."</td>
										 		<td>".$valdok['vNama_Dokumen']."</td>
										 		<td>".$valdok['vKeterangan_kelengkapan1']."</td>
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
				echo $grid->updated_form();
				exit();
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
			case 'getdetailsdok':
				echo $this->getdetailsdok();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

function listBox_kelengkapan_dokumen_export_iTahun($v,$p,$d,$r) {
	$sql="select c.*
						from dossier.dossier_upd a 
						join dossier.dossier_prioritas_detail b on b.idossier_upd_id = a.idossier_upd_id
						join dossier.dossier_prioritas c on c.idossier_prioritas_id=b.idossier_prioritas_id 
						where c.iApprove_prio= 2
						and a.lDeleted = 0
						and b.lDeleted = 0
						and c.lDeleted = 0
						#and a.iSubmit_bagi_upd=1
						and a.vpic is not null
						and b.lDeleted=0
						and a.idossier_upd_id=".$r->idossier_upd_id;
	$q=$this->dbset->query($sql);
	$ret="-";
	if($q->num_rows()>=1){
		$dat=$q->row_array();
		$ret=$dat['iTahun'];
	}
	return $ret;
}
function listBox_kelengkapan_dokumen_export_iSemester($v,$p,$d,$r) {
		$sql="select c.*
						from dossier.dossier_upd a 
						join dossier.dossier_prioritas_detail b on b.idossier_upd_id = a.idossier_upd_id
						join dossier.dossier_prioritas c on c.idossier_prioritas_id=b.idossier_prioritas_id 
						where c.iApprove_prio= 2
						and a.lDeleted = 0
						and b.lDeleted = 0
						and c.lDeleted = 0
						#and a.iSubmit_bagi_upd=1
						and a.vpic is not null
						and b.lDeleted=0
						and a.idossier_upd_id=".$r->idossier_upd_id;
	$q=$this->dbset->query($sql);
	$ret="-";
	if($q->num_rows()>=1){
		$dat=$q->row_array();
		$ret=$dat['iSemester'];
	}
	return $ret;
}

 function getdetailsdok(){
	$sql_data="select doklist.*,kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen,dok.ijml_dok,dok.ibobot,
					divi.vDescription,doklist.istatus_keberadaan,em.vName,det.vsubmodul_kategori
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
		$o='<input type="checkbox" name="cek_4_'.$disabled.'['.$k->idossier_dok_list_id.']" id="cek_4_'.$disabled.$k->idossier_dok_list_id.'" value="1" class="rev'.$disabled.'" '.$revrchek.' '.$disabled.' />';
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
	$o=$k->vKeterangan_kelengkapan3;
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
   	$revrchek=$k->iStatus_kelengkapan3==1?'checked':'';
	$appcehek=$k->iStatus_kelengkapan3==2?'checked':'';
    $o='';
	if($status2==2){ 
		$o='<input type="checkbox" name="cek_3_disabled['.$k->idossier_dok_list_id.']" id="cek_3_disabled'.$k->idossier_dok_list_id.'" value="1" class="rev_disabled" '.$revrchek.' disabled="disabled" />';
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
   	$revrchek=$k->iStatus_kelengkapan3==1?'checked':'';
	$appcehek=$k->iStatus_kelengkapan3==2?'checked':'';
    $o='';
	if($status2==2){ 
		$o='<input type="checkbox" name="cek_3_disabled['.$k->idossier_dok_list_id.']" id="cek_3_disabled'.$k->idossier_dok_list_id.'" value="2" class="appr_disabled" '.$appcehek.'  disabled="disabled" />';
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
    $checked=$k->iStatus_kelengkapan2==2?'checked':'';
    $o='';
	if($status==2){ 
		$o='<input type="checkbox" name="cek_2_disabled['.$k->idossier_dok_list_id.']" id="cek_2_disabled'.$k->idossier_dok_list_id.'" value="1" class="rev_cek_2_disabled" '.$ty.' disabled="disabled" />';
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
    $checked=$k->iStatus_kelengkapan2==2?'checked':'';
    $o='';
	if($status==2){ 
		$o='<input type="checkbox" name="cek_2_disabled['.$k->idossier_dok_list_id.']" id="cek_2_disabled'.$k->idossier_dok_list_id.'" value="2" class="appr_cek_2_disabled" '.$ty.' '.$checked.' disabled="disabled" />';
	}
	return $o;
}


function details_ket1($k){
	$status=0;
	$disabled="disabled";
	if(($k->iStatus_confirm==1)&&($k->istatus_verifikasi==1)){
        $status=1;
        $disabled=$k->iStatus_kelengkapan1==2?'disabled':'';
    }
    $o='';
	if($status==1){ 
	    if ($k->iStatus_kelengkapan1!=2){
	    	$o.='<textarea name="cek_1_keterangan['.$k->idossier_dok_list_id.']" id="cek_1_keterangan_'.$k->idossier_dok_list_id.$disabled.'">'.$k->vKeterangan_kelengkapan1.'</textarea>';
	    }else{
	        $o.=$k->vKeterangan_kelengkapan1;
	    }
	}
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
		$o='<input type="checkbox" name="cek_1_'.$disabled.'['.$k->idossier_dok_list_id.']" id="cek_1_'.$disabled.$k->idossier_dok_list_id.'" value="1" class="rev_cek_1" '.$disabled.' '.$revcheck.' />';
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
		$o='<input type="checkbox" name="cek_1_'.$disabled.'['.$k->idossier_dok_list_id.']" id="cek_1_'.$disabled.$k->idossier_dok_list_id.'" value="2" class="appr_cek_1" '.$disabled.' '.$appchek.' />';
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
					and b.iStatus_kelengkapan1 != 2';
	$data_lengkap1 = $this->dbset->query($sql_cek_lengkap1)->result_array();

 	if (empty($data_lengkap1)) {
 		// status sudah diapprove or reject , button edit hide 
 		 unset($actions['edit']);
 		 unset($actions['delete']);
 	}else{
 		$mydept = $this->auth_plcexport->my_depts(TRUE);
 		if (isset($mydept)) {
			if((in_array('TD', $mydept))) {
				if($this->auth_plcexport->is_managerdept('TD')){ 
				}else{
					$q="select * from plc2.plc2_upb_team_item it where it.lDeleted=0 and it.vnip='".$this->user->gNIP."'";
					$dt=$this->dbset->query($q);
					if($dt->num_rows()!=0){
						$d=$dt->row_array();
						if($d['iapprove']==1){
							
						}else{
							unset($actions['edit']);
 							unset($actions['delete']);
						}
					}else{
						unset($actions['edit']);
 						unset($actions['delete']);
					}
				}
			}
		}else{
			unset($actions['edit']);
 			unset($actions['delete']);
		}
 		
 	}
	 return $actions;
 } 


function listBox_kelengkapan_dokumen_export_dossier_prioritas_iSemester ($value) {
	return 'Semester '.$value;
}

function listBox_kelengkapan_dokumen_export_dossier_upd_iTeam_andev ($value) {
	$q="select * from plc2.plc2_upb_team te where te.iteam_id=".$value;
	$d=$this->dbset->query($q)->row_array();
	return $d['vteam'];
}

function listBox_kelengkapan_dokumen_export_dossier_upd_iSediaan ($value) {
	if ($value == 1) {
		$sediaan = 'Solid';
	}else{
		$sediaan = 'Injection';
	}

	return $sediaan;
}

/*manipulasi view object form start*/


function updateBox_kelengkapan_dokumen_export_vUpd_no($field, $id, $value, $rowData) {
	$sql = 'select * from dossier.dossier_upd a where a.idossier_upd_id="'.$rowData['idossier_upd_id'].'" ';
	$data_upd = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];

	}else{

		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];
	}
	
	return $return;
}

function updateBox_kelengkapan_dokumen_export_vNama_usulan($field, $id, $value, $rowData) {
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

function updateBox_kelengkapan_dokumen_export_iTeam_andev($field, $id, $value, $rowData) {
	$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
	$q="select * from plc2.plc2_upb_team te where te.iteam_id=".$rows['iTeam_andev'];
	$d=$this->dbset->query($q)->row_array();
	return $d['vteam'];
}

function updateBox_kelengkapan_dokumen_export_cCek_kelengkapan1($field, $id, $value, $rowData) {
		if ($rowData['iSubmit_kelengkapan1'] <> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cCek_kelengkapan1']))->row_array();

			if ($rowData['iKelengkapan_data'] == 2) {
				$palue='Submitted by '.$rows['vName'].' pada '.$rowData['dCek_kelengkapan1'] ;	
			}else{
				$palue='Submitted by '.$rows['vName'].' pada '.$rowData['dCek_kelengkapan1']  ;	
			}
			
		}else{
			$palue='Waiting Submit';
		}

		if ($this->input->get('action') == 'view') {
			$return= $palue;

		}
		else{
			$return= $palue;
		}
		
		return $return;
}

function updateBox_kelengkapan_dokumen_export_dCek_kelengkapan1($field, $id, $value, $rowData) {
		if ($rowData['iSubmit_kelengkapan1'] <> 0 ) {
			$palue= $rowData['dCek_kelengkapan1'];
			
		}else{
			$palue='Waiting Submit';
		}


		if ($this->input->get('action') == 'view') {
			$return= $palue;

		}
		else{
			$return= $palue;
		}
		
		return $return;
}

function updateBox_kelengkapan_dokumen_export_rincian_dok($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
		//$return1= print_r($rows);

		$data['rows'] = $rows;
		$data['iSediaan'] = $rows['iSediaan'];
		$data['idossier_upd_id'] =  $rows['idossier_upd_id'];

		$sql_negara="select * from dossier.dossier_upd_negara ne 
		inner join dossier.dossier_negara neg on neg.idossier_negara_id = ne.idossier_negara_id
		where ne.lDeleted=0 and ne.idossier_upd_id=".$rowData['idossier_upd_id'];
		$data['mnnegara'] = $this->dbset->query($sql_negara)->result_array();


		//data row table dokumen
		$sql_data="select doklist.*,kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen,dok.ijml_dok,dok.ibobot,
					divi.vDescription,doklist.istatus_keberadaan,em.vName,det.vsubmodul_kategori
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
					order by det.vsubmodul_kategori,dok.iurut_dokumen ASC";
		$data['dokumen']=$this->dbset->query($sql_data)->result_array();

		$sql_doc='	select * 
					from dossier.dossier_dokumen a 
					join dossier.dossier_dok_list b on b.idossier_dokumen_id=a.idossier_dokumen_id 
					inner join dossier.dossier_kat_dok_details det on a.idossier_kat_dok_details_id=det.idossier_kat_dok_details_id
					inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=det.idossier_kat_dok_id
					where a.lDeleted=0
					and b.lDeleted=0
					and det.lDeleted=0 and kat.lDeleted=0
					and b.idossier_review_id="'.$rowData['idossier_review_id'].'"';
		$data['docs'] = $this->db_plc0->query($sql_doc)->result_array();
		//$return= print_r($rows);
		
/*

		if ($rows['iSediaan'] == 1  ) {
			//solid
			$return=  $this->load->view('kelengkapan_dokumen_export_solid',$data,TRUE);
		}else{
			// non solid
			$return= $this->load->view('kelengkapan_dokumen_export_nonsolid',$data,TRUE);
		}
*/		
		//$return= $this->load->view('kelengkapan_dokumen1_export',$data,TRUE);		
		//$return=$this->load->view('export/table-scroll_min_js');
		$return = '
			<script type="text/javascript">
				$("label[for=\''.$id.'\']").hide();
				$("label[for=\''.$id.'\']").next().css("margin-left",10);
				$("label[for=\''.$id.'\']").parent().css("overflow","");
			</script>
		';
		$data['id']=$id;
		$data['idossier_review_id']=$rowData['idossier_review_id'];
		$return.=$this->load->view('file_cek_kelengkapan_1',$data,TRUE);
		return $return;
		
}


function after_update_processor($row, $insertId, $postData, $old_data) {
		/*
		$urutan = 1;
			foreach($postData['idossier_dok_list_id'] as $k=>$v) {
				
					if($v != '') {

						if (empty($postData['iStatus_kelengkapan1_'.$v])) {
								$istatus = 0;
						}else{
							foreach($postData['iStatus_kelengkapan1_'.$v] as $k1=>$v1) {
								$istatus = $v1;
							}		
						}
						

						$data=array('iStatus_kelengkapan1'=>$istatus);
						$this -> db -> where('idossier_dok_list_id',$v);
						$updet = $this -> db -> update('dossier.dossier_dok_list', $data);

					}
			}
	*/
		$logged_nip =$this->user->gNIP;
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.C_ITENO,c.C_ITNAM,d.vName,b.dTanggal_upd,a.iSubmit_kelengkapan1
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.itemas c on c.C_ITENO=b.iupb_id 
				join hrd.employee d on d.cNip=b.cNip_pengusul
				where a.idossier_review_id = '".$insertId."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_kelengkapan1'] ;
		$q="select * from plc2.plc2_upb_team te where te.iteam_id in (".$rupd['ad'].")";
		$d=$this->dbset->query($q)->row_array();
		$iTeam_andev=$d['vteam'];
		/*
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

				$subject="Kelengkapan Dokumen I: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada inputan Kelengkapan Dokumen I UPD  pada aplikasi PLC - Export dengan rincian sebagai berikut :<br><br>
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
			
		}*/

		
}



/*function pendukung start*/  

function before_update_processor($row, $postData) {

	// ubah status submit
		if($postData['isdraft']==true){
			$postData['iSubmit_kelengkapan1']=0;
		} 
		else{
			$postData['iSubmit_kelengkapan1']=1;
			$postData['cCek_kelengkapan1']=$this->user->gNIP;
			$postData['dCek_kelengkapan1']= date('Y-m-d H:i:s');

		} 
	
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	

	return $postData;

}


function manipulate_update_button($buttons, $rowData) {
	$cNip= $this->user->gNIP;

	$js = $this->load->view('kelengkapan_dokumen_export_js');

	$update = '<button onclick="javascript:update_btn_back(\'kelengkapan_dokumen_export\', \''.base_url().'processor/plc/kelengkapan/dokumen/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_kelengkapan_dokumen_export">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'kelengkapan_dokumen_export\', \''.base_url().'processor/plc/kelengkapan/dokumen/export?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_draft_kelengkapan_dokumen_export">Update</button>';


	$sql_cek_lengkap1='select * 
					from dossier.dossier_review a
					join dossier.dossier_dok_list b on b.idossier_review_id=a.idossier_review_id
					where a.idossier_review_id="'.$rowData['idossier_review_id'].'" 
					and b.iStatus_kelengkapan1 != 2';
	$data_lengkap1 = $this->dbset->query($sql_cek_lengkap1)->result_array();					
	//print_r($data_lengkap1);

	if ($this->input->get('action') == 'view') {unset($buttons['update']);}

	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if ($rowData['iSubmit_kelengkapan1']!=2) {
			// jika masih draft , show button update draft & update submit 
				// cek sudah verifikasi semua belum , kalau belum ceklis maka tombol draft saja 
				if (empty($data_lengkap1)) {
					// sudah ceklist verify semua
					//$buttons['update'] = $update.$updatedraft.$js;		
				}else{
					$buttons['update'] = $updatedraft.$js;		
					
				}
			
		}else{
			// sudah disubmit , show button approval 
			//$buttons['update'] = $approve.$reject.$js;
		}


		//$buttons['update'] = $update.$updatedraft.$approve.$reject.$js;
	}
	

	return $buttons;


}	

/*
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
								var url = "'.base_url().'processor/plc_export/confirm/dokumen";								
								if(o.status == true) {
									
									
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_kelengkapan_dokumen_export").html(data);
										$("#button_approve_kelengkapan_dokumen_export").hide();
										$("#button_reject_kelengkapan_dokumen_export").hide();
									});
									
								}
									reload_grid("grid_kelengkapan_dokumen_export");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_kelengkapan_dokumen_export_approve" action="'.base_url().'processor/plc_export/confirm/dokumen?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_review_id" value="'.$this->input->get('idossier_review_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark_confirm"></textarea>
		<button type="button" onclick="submit_ajax(\'form_kelengkapan_dokumen_export_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_review_id = $post['idossier_review_id'];
		$vRemark_confirm = $post['vRemark_confirm'];

		$data=array('iKelengkapan_data'=>'2','cCek_kelengkapan1'=>$cNip , 'dCek_kelengkapan1'=>date('Y-m-d H:i:s'), 'vRemark_confirm'=>$vRemark_confirm);
		$this -> db -> where('idossier_review_id', $idossier_review_id);
		$updet = $this -> db -> update('dossier.dossier_review', $data);


		$data['status']  = true;
		$data['last_id'] = $post['idossier_review_id'];
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_kelengkapan_dokumen_export_vRemark_confirm").val();
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
								var url = "'.base_url().'processor/plc_export/confirm/dokumen";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_kelengkapan_dokumen_export").html(data);
										 $("#button_approve_kelengkapan_dokumen_export").hide();
										$("#button_reject_kelengkapan_dokumen_export").hide();
									});
									
								}
									reload_grid("grid_kelengkapan_dokumen_export");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_kelengkapan_dokumen_export_reject" action="'.base_url().'processor/plc_export/confirm/dokumen?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_review_id" value="'.$this->input->get('idossier_review_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark_confirm" id="reject_kelengkapan_dokumen_export_vRemark_confirm"class="required" required="required"></textarea>
		<button type="button" onclick="submit_ajax(\'form_kelengkapan_dokumen_export_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	
	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_review_id = $post['idossier_review_id'];
		$vRemark_confirm = $post['vRemark_confirm'];

		$data=array('iKelengkapan_data'=>'1','cCek_kelengkapan1'=>$cNip , 'dCek_kelengkapan1'=>date('Y-m-d H:i:s'), 'vRemark_confirm'=>$vRemark_confirm);
		$this -> db -> where('idossier_review_id', $idossier_review_id);
		$updet = $this -> db -> update('dossier.dossier_review', $data);


		$data['status']  = true;
		$data['last_id'] = $post['idossier_review_id'];
		return json_encode($data);
	}
*/


/*function pendukung end*/    	

	

	public function output(){
		$this->index($this->input->get('action'));
	}

}

