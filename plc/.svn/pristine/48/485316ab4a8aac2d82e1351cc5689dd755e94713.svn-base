<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class cek_review_dokumen_export extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_plcexport');
		$this->load->library('lib_utilitas');
		$this->load->library('dossier_log');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth_plcexport->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Review Dokumen');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_review');		
		$grid->setUrl('cek_review_dokumen_export');
		$grid->addList('dossier_upd.vUpd_no','dossier_upd.vNama_usulan','dossier_upd.iTeam_andev','dossier_upd.vpic','iSemester','iTahun','iApprove_review');
		$grid->setSortBy('dossier_upd.vUpd_no');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('vUpd_no','vNama_usulan','iTeam_andev','rincian_dok','iApprove_review');

		//setting widht grid
		$grid ->setWidth('dossier_upd.vUpd_no', '100'); 
		$grid->setWidth('dossier_upd.iTeam_andev', '100'); 
		$grid->setWidth('dossier_upd.iSediaan', '100'); 
		$grid->setWidth('iSemester', '120'); 
		$grid->setWidth('iTahun', '80'); 
		$grid->setWidth('iApprove_review', '100'); 
		$grid->setWidth('dossier_upd.vNama_usulan', '250'); 
		$grid->setWidth('lDeleted', '100'); 
		
		
		//modif label
		$grid->setLabel('vUpd_no','No UPD'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 

		$grid->setLabel('dossier_upd.vUpd_no','No UPD'); 
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Usulan'); 
		$grid->setLabel('dossier_upd.iTeam_andev','Team Andev'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 


		$grid->setLabel('iApprove_review','Status Review'); 
		$grid->setLabel('iTeam_andev','Team Andev'); 
		$grid->setLabel('dossier_upd.vpic','PIC Team Dossier'); 
		$grid->setLabel('iNegara','Negara'); 
		//$grid->setLabel('iApprove_review','Approve at'); 
		$grid->setLabel('cApprove_review','Approve by'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 
		$grid->setLabel('iSemester','Semester Prioritas'); 
		$grid->setLabel('iTahun','Tahun Prioritas');

		$grid->setAlign('iSemester','center');
		$grid->setAlign('iTahun','center');

		$grid->setFormUpload(TRUE);

		$grid->setSearch('dossier_upd.vUpd_no','dossier_upd.vNama_usulan');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('dossier_upd.iSediaan','combobox','',array(''=>'Pilih','1'=>'Solid','2'=>'Non Solid'));
		$grid->changeFieldType('iApprove_review','combobox','',array('0'=>'Waiting Approval','1'=>'Rejected','2'=>'Approved'));
		
		

	//Field mandatori
		$grid->setRequired('iSediaan');	
		$grid->setRequired('iTeam_andev');	
		$grid->setRequired('lDeleted');	

		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id', 'inner');		
		#$grid->setJoinTable('dossier.dossier_prioritas_detail', 'dossier_prioritas_detail.idossier_upd_id = dossier_upd.idossier_upd_id', 'inner');
		#$grid->setJoinTable('dossier.dossier_prioritas', 'dossier_prioritas.idossier_prioritas_id = dossier_prioritas_detail.idossier_prioritas_id', 'inner');

		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_review.lDeleted', 0);
		$grid->setQuery('dossier_review.iApprove_keb', 2);
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
			}elseif(in_array('AD', $manager)){
				$type='AD';
				$q.=" and vtipe='".$type."'";
				$d=$this->dbset->query($q)->row_array();
				if($d['iteam_id']==17){//BDIRM 1
					$grid->setQuery('dossier_upd.vpic_andev IN (select vnip from plc2.plc2_upb_team_item where iteam_id in ('.$this->auth_plcexport->my_teams().'))', null);
				}elseif ($d['iteam_id']==40) {
					$grid->setQuery('(dossier_upd.vpic_andev IN (select vnip from plc2.plc2_upb_team_item where iteam_id in ('.$this->auth_plcexport->my_teams().')) or dossier_upd.is_old=1', null);
				}
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
				echo $grid->updated_form();
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
			default:
				$grid->render_grid();
				break;
		}
    }

 
   
 function listBox_Action($row, $actions) {
 	if ($row->iApprove_review==2) {
 		 unset($actions['edit']);
 		 unset($actions['delete']);
 	}
	 return $actions;
 } 


/*function listBox_cek_review_dokumen_export_dossier_prioritas_iSemester ($value) {
	return 'Semester '.$value;
}
*/

function listBox_cek_review_dokumen_export_iTahun($v,$p,$d,$r) {
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
function listBox_cek_review_dokumen_export_iSemester($v,$p,$d,$r) {
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


function listBox_cek_review_dokumen_export_dossier_upd_iTeam_andev ($value) {
	if ($value == 17) {
		$andev = 'Andev Export 1';
	}else{
		$andev = 'Andev Export 2';
	}

	return $andev;
}

function listBox_cek_review_dokumen_export_dossier_upd_iSediaan ($value) {
	if ($value == 1) {
		$sediaan = 'Solid';
	}else{
		$sediaan = 'Injection';
	}

	return $sediaan;
}


function listBox_cek_review_dokumen_export_dossier_upd_vpic($value){
	$sql="select * from hrd.employee em where em.cNip='".$value."'";
	$dt=$this->dbset->query($sql)->row_array();
	return $value."-".$dt['vName'];
}
/*manipulasi view object form start*/


function updateBox_cek_review_dokumen_export_vUpd_no($field, $id, $value, $rowData) {
	$sql = 'select * from dossier.dossier_upd a where a.idossier_upd_id="'.$rowData['idossier_upd_id'].'" ';
	$data_upd = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];

	}else{

		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];
	}
	
	return $return;
}

function updateBox_cek_review_dokumen_export_vNama_usulan($field, $id, $value, $rowData) {
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

function updateBox_cek_review_dokumen_export_iTeam_andev($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
		if ($rows['iTeam_andev']==17) {
			$andev = 'Andev Export 1';
		}else{
			$andev = 'Andev Export 2';
		}

		if ($this->input->get('action') == 'view') {
			$return= $andev;

		}
		else{
			$return= $andev;
		}
		
		return $return;
}

function updateBox_cek_review_dokumen_export_cApprove_review($field, $id, $value, $rowData) {
	
	

		if ($rowData['iApprove_review'] <> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cApprove_review']))->row_array();

			if ($rowData['iApprove_review'] == 2) {
				$palue='Approved by '.$rows['vName'].', Remark :'.$rowData['vRemark_review'] ;	
			}else{
				$palue='Rejected by '.$rows['vName'].', Remark :'.$rowData['vRemark_review'];	
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

function updateBox_cek_review_dokumen_export_iApprove_review($field, $id, $value, $rowData) {
		if ($rowData['iApprove_review'] <> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cApprove_review']))->row_array();

			if ($rowData['iApprove_review'] == 2) {
				$palue='Approved by '.$rows['vName'].' pada '.$rowData['dApprove_review'].', Remark :'.$rowData['vRemark_review'] ;	
			}else{
				$palue='Rejected by '.$rows['vName'].' pada '.$rowData['dApprove_review'].', Remark :'.$rowData['vRemark_review'];	
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

function updateBox_cek_review_dokumen_export_rincian_dok($field, $id, $value, $rowData) {
		$mydept = $this->auth_plcexport->my_depts(TRUE);
		$timnya = $this->auth_plcexport->my_teams();
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
		
		//$return1= print_r($rows);

		$data['rows'] = $rows;
		$data['iSediaan'] = $rows['iSediaan'];
		$data['idossier_upd_id'] =  $rows['idossier_upd_id'];
		$data['idossier_review_id'] =  $rowData['idossier_review_id'];


		$sql_data="select doklist.*,det.vsubmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen,dok.ijml_dok,dok.ibobot,doklist.istatus_keberadaan
					from dossier.dossier_dok_list doklist
					inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=doklist.idossier_dokumen_id
					inner join dossier.dossier_kat_dok_details det on det.idossier_kat_dok_details_id=dok.idossier_kat_dok_details_id 
					inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=det.idossier_kat_dok_id
					inner join dossier.dossier_review rev on doklist.idossier_review_id=rev.idossier_review_id
					inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
					where doklist.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0 and up.lDeleted=0 and det.lDeleted=0
					and doklist.idossier_review_id=".$rowData['idossier_review_id']."
					order by det.vsubmodul_kategori, dok.iurut_dokumen ASC";
		$data['dokumen']=$this->dbset->query($sql_data)->result_array();
		$data['sql']=$sql_data;
		$return=$this->load->view('cek_review_dokumen',$data,TRUE);
		
		return $return;
		
}


function after_update_processor($row, $insertId, $postData, $old_data) {
		$idossier_dok_list_id=array();
		$vKeterangan=array();
		foreach ($postData as $kp => $vp) {
			if($kp=='review_dokumen'){
				$idossier_dok_list_id=$vp;
			}
			if($kp=='review_keterangan'){
				$vKeterangan=$vp;
			}
		}
		foreach ($idossier_dok_list_id as $kid => $vid) {
			$data['istatus_keberadaan']=$vid;
			$data['istatus_keberadaan_update']=$vid;
			$data['vKeterangan_review']=$vKeterangan[$kid];
			$this->dbset->where('idossier_dok_list_id',$kid);
			$this->dbset->update('dossier.dossier_dok_list',$data);
		}
		$logged_nip =$this->user->gNIP;
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,itemas.C_ITENO,itemas.C_ITNAM,d.vName,b.dTanggal_upd,a.iSubmit_review
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.itemas on itemas.C_ITENO=b.iupb_id 
				join hrd.employee d on d.cNip=b.cNip_pengusul
				where a.idossier_review_id = '".$insertId."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();


		$sql_cek_lengkap ='select a.vNama_Dokumen
					from dossier.dossier_dokumen a 
					join dossier.dossier_dok_list b on b.idossier_dokumen_id=a.idossier_dokumen_id
					join dossier.dossier_kat_dok_details d on d.idossier_kat_dok_details_id=a.idossier_kat_dok_details_id
					join dossier.dossier_kat_dok c on c.idossier_kat_dok_id=d.idossier_kat_dok_id
					where a.lDeleted=0
					and b.lDeleted=0
					and b.idossier_review_id="'.$insertId.'"
					and a.iPerlu=1
					and d.lDeleted=0
					and c.lDeleted=0
					and (b.istatus_keberadaan=0 or b.istatus_keberadaan=3)';
		$dcek = $this->db_plc0->query($sql_cek_lengkap)->result_array();


		$submit = $rupd['iSubmit_review'] ;
		if ($rupd['ad'] == 17) {
			$iTeamandev = 'Andev Export 1';
			$vkode="REVIEW_UPD_TD1";
		}else{
			$iTeamandev = 'Andev Export 2';
			$vkode="REVIEW_UPD_TD2";
		}
		$iproses=3;
		if ($submit == 1) {
			$iproses=4;
			$team = $rupd['ad'];
			$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
			$dt=$this->dbset->query($sql)->row_array();
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
 			*/
			$to = $dt['tto'];
			$cc = $dt['tcc'];                       
			
				$subject="Review Dokumen: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada inputan Review Dokumen UPD  pada aplikasi PLC-Export dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 200;'><b>No UPD</b></td><td style='width: 5px;'> : </td><td>".$rupd['vUpd_no']."</td>
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
								<td><b>No Produk</b></td><td> : </td><td>".$rupd['C_ITENO'].' - '.$rupd['C_ITNAM']."</td>
							</tr>
							<tr>
								<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
							</tr>
							<tr>
								<td><b>Dokumen yang belum tersedia</b></td><td colspan=2> : </td>
							</tr>
							<tr>
								<td colspan=3><table border='1px' style='border-collapse:collapse;width:100%;border:1px;'>
									 	<tr>
									 		<th>No</th>
									 		<th>Nama Dokumen</th>
									 	</tr>";
						
								$no = 1;
								foreach ($dcek as $datadok ) {
								$content .=	"<tr>
									 		<td>".$no."</td>
									 		<td>".$datadok['vNama_Dokumen']."</td>
									 	</tr>";
								$no++;
								}	 	
					$content .=
									"</table></td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}
		$this->dossier_log->insertlog($insertId,$this->input->get('modul_id'),$iproses);
		
}



/*function pendukung start*/  
function before_update_processor($row, $postData) {

	// ubah status submit
		if($postData['isdraft']==true){
			$postData['iSubmit_review']=0;
		} 
		else{$postData['iSubmit_review']=1;} 
	
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;

	return $postData;

}

function manipulate_update_button($buttons, $rowData) {

	$mydept = $this->auth_plcexport->my_depts(TRUE);

	$cNip= $this->user->gNIP;

	$js = $this->load->view('cek_review_dokumen_export_js');

	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/cek/review/dokumen/export?action=approve&idossier_review_id='.$rowData['idossier_review_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_cek_review_dokumen_export">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/cek/review/dokumen/export?action=reject&idossier_review_id='.$rowData['idossier_review_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_cek_review_dokumen_export">Reject</button>';

	$update = '<button onclick="javascript:update_btn_back(\'cek_review_dokumen_export\', \''.base_url().'processor/plc/cek/review/dokumen/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_review_dokumen_export">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'cek_review_dokumen_export\', \''.base_url().'processor/plc/cek/review/dokumen/export?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_cek_review_dokumen_export">Update as Draft</button>';



	if ($this->input->get('action') == 'view') {unset($buttons['update']);}

	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if ($rowData['iSubmit_review']== 0) {
			// jika masih draft , show button update draft & update submit 
			$buttons['update'] = $update.$updatedraft.$js;
		}else{
			// sudah disubmit , show button approval 
			// jika manager team andev  
			if (isset($mydept)) {
				if((in_array('TD', $mydept))) {
					if($this->auth_plcexport->is_managerdept('TD')){ 
						$buttons['update'] = $approve.$reject.$js;
					}
				}
				if((in_array('AD', $mydept))) {
					if($this->auth_plcexport->is_managerdept('AD')){ 
						$buttons['update'] = $approve.$reject.$js;
					}else{
						$q="select * from plc2.plc2_upb_team_item it where it.lDeleted=0 and it.vnip='".$this->user->gNIP."'";
						$dt=$this->dbset->query($q);
						if($dt->num_rows()!=0){
							$d=$dt->row_array();
							if($d['iapprove']==1){
								$buttons['update'] = $approve.$reject.$js;
							}
						}else{}
					}
				}
				if((in_array('BDI', $mydept))) {
					if($this->auth_plcexport->is_managerdept('BDI')){ 
						$buttons['update'] = $approve.$reject.$js;
					}
				}
			}
			
		}


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
								var url = "'.base_url().'processor/plc/cek/review/dokumen/export";								
								if(o.status == true) {
									
									
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_cek_review_dokumen_export").html(data);
										$("#button_approve_cek_review_dokumen_export").hide();
										$("#button_reject_cek_review_dokumen_export").hide();
									});
									
								}
									reload_grid("grid_cek_review_dokumen_export");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_cek_review_dokumen_export_approve" action="'.base_url().'processor/plc/cek/review/dokumen/export?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_review_id" value="'.$this->input->get('idossier_review_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark_review"></textarea>
		<button type="button" onclick="submit_ajax(\'form_cek_review_dokumen_export_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_review_id = $post['idossier_review_id'];
		$vRemark_review = $post['vRemark_review'];

		$data=array('iApprove_review'=>'2','cApprove_review'=>$cNip , 'dApprove_review'=>date('Y-m-d H:i:s'), 'vRemark_review'=>$vRemark_review);
		$this -> db -> where('idossier_review_id', $idossier_review_id);
		$updet = $this -> db -> update('dossier.dossier_review', $data);
		$sql="select * from dossier.dossier_review rev where rev.idossier_review_id=".$idossier_review_id;
		$dt=$this->dbset->query($sql)->row_array();
		$iproses=6;
		$this->dossier_log->insertlog($dt['idossier_upd_id'],$this->input->get('modul_id'),$iproses);

		$logged_nip =$this->user->gNIP;
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,itemas.C_ITENO,itemas.C_ITNAM,d.vName,b.dTanggal_upd,a.iSubmit_review
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.itemas on itemas.C_ITENO=b.iupb_id 
				join hrd.employee d on d.cNip=b.cNip_pengusul
				where a.idossier_review_id = '".$idossier_review_id."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_review'] ;
		if ($rupd['ad'] == 17) {
			$iTeamandev = 'Andev Export 1';
			$vkode="REVIEW_APP_TD1";
		}else{
			$iTeamandev = 'Andev Export 2';
			$vkode="REVIEW_APP_TD2";
		}

		if ($updet == 1) {
			$ad = $rupd['ad'];

			//$team = $dr ;
			$team = $ad;
			//$team = '81' ;
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
			*/
			$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
			$dt=$this->dbset->query($sql)->row_array();
			$to = $dt['tto'];
			$cc = $dt['tcc']; 
				$subject="Approval Review Dokumen: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada approval Review Dokumen UPD  pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
								<td><b>No Produk</b></td><td> : </td><td>".$rupd['C_ITENO'].' - '.$rupd['C_ITNAM']."</td>
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
					 	var remark = $("#reject_cek_review_dokumen_export_vRemark_review").val();
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
								var url = "'.base_url().'processor/plc/cek/review/dokumen/export";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_cek_review_dokumen_export").html(data);
										 $("#button_approve_cek_review_dokumen_export").hide();
										$("#button_reject_cek_review_dokumen_export").hide();
									});
									
								}
									reload_grid("grid_cek_review_dokumen_export");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_cek_review_dokumen_export_reject" action="'.base_url().'processor/plc/cek/review/dokumen/export?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_review_id" value="'.$this->input->get('idossier_review_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark_review" id="reject_cek_review_dokumen_export_vRemark_keb"class="required" required="required"></textarea>
		<button type="button" onclick="submit_ajax(\'form_cek_review_dokumen_export_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	
	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_review_id = $post['idossier_review_id'];
		$vRemark_review = $post['vRemark_review'];

		$data=array('iSubmit_review'=>0,'iApprove_review'=>'1','cApprove_review'=>$cNip , 'dApprove_review'=>date('Y-m-d H:i:s'), 'vRemark_review'=>$vRemark_review);
		$this -> db -> where('idossier_review_id', $idossier_review_id);
		$updet = $this -> db -> update('dossier.dossier_review', $data);

		$sql="select * from dossier.dossier_review rev where rev.idossier_review_id=".$idossier_review_id;
		$dt=$this->dbset->query($sql)->row_array();
		$iproses=5;
		$this->dossier_log->insertlog($dt['idossier_upd_id'],$this->input->get('modul_id'),$iproses);

		$logged_nip =$this->user->gNIP;
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,itemas.C_ITENO,itemas.C_ITNAM,d.vName,b.dTanggal_upd,a.iSubmit_review
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.itemas on itemas.C_ITENO=b.iupb_id 
				join hrd.employee d on d.cNip=b.cNip_pengusul
				where a.idossier_review_id = '".$idossier_review_id."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_review'] ;
		if ($rupd['ad'] == 17) {
			$iTeamandev = 'Andev 1';
		}else{
			$iTeamandev = 'Andev 2';
		}

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

				$subject="Approval Review Dokumen: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada approval Review Dokumen UPD  pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
								<td><b>No Produk</b></td><td> : </td><td>".$rupd['C_ITENO'].' - '.$rupd['C_ITNAM']."</td>
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

