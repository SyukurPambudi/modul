<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class pembuatan_dossier_export extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->load->library('lib_utilitas');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Pembuatan Dossier');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_review');		
		$grid->setUrl('pembuatan_dossier_export');
		$grid->addList('dossier_upd.vUpd_no','dossier_upd.vNama_usulan','dossier_upd.iTeam_andev','dossier_upd.iSediaan','dossier_prioritas.iSemester','dossier_prioritas.iTahun','iapp_ir_buatdossier','iapp_bdi_buatdossier');
		$grid->setSortBy('dossier_upd.vUpd_no');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('vUpd_no','vNama_usulan','iTeam_andev','rincian_dok','dPembuatan_dossier','dPeriksa_ir','dPeriksa_bdirm','iapp_ir_buatdossier','iapp_bdi_buatdossier');

		//setting widht grid
		$grid ->setWidth('dossier_upd.vUpd_no', '100'); 
		$grid->setWidth('dossier_upd.iTeam_andev', '100'); 
		$grid->setWidth('dossier_upd.iSediaan', '100'); 
		$grid->setWidth('dossier_prioritas.iSemester', '150'); 
		$grid->setWidth('dossier_prioritas.iTahun', '100'); 
		$grid->setWidth('iapp_ir_buatdossier', '100'); 
		$grid->setWidth('iapp_bdi_buatdossier', '100'); 
		$grid->setWidth('dossier_upd.vNama_usulan', '250'); 
		$grid->setWidth('lDeleted', '100'); 
		
		
		//modif label
		$grid->setLabel('vUpd_no','No UPD'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 

		$grid->setLabel('dossier_upd.vUpd_no','No UPD'); 
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Usulan'); 
		$grid->setLabel('dossier_upd.iTeam_andev','Team Andev'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 


		$grid->setLabel('iSubmit_kelengkapan1','Status Submit'); 
		$grid->setLabel('iapp_ir_buatdossier','Approval IR'); 
		$grid->setLabel('iapp_bdi_buatdossier','Approval BDIR'); 
		$grid->setLabel('iTeam_andev','Team Andev'); 
		$grid->setLabel('iNegara','Negara'); 
		$grid->setLabel('cCek_kelengkapan2','Approval SPV'); 
		$grid->setLabel('cCek_kelengkapan3','Approval BDIRM'); 
		$grid->setLabel('dossier_upd.iSediaan','Sediaan'); 
		$grid->setLabel('dossier_prioritas.iSemester','Semester Prioritas'); 
		$grid->setLabel('dossier_prioritas.iTahun','Tahun Prioritas');

		$grid->setLabel('dPembuatan_dossier','Tgl Pembuatan Dossier'); 
		$grid->setLabel('dPeriksa_ir','Tgl Periksa IR SPV'); 
		$grid->setLabel('dPeriksa_bdirm','Tgl Periksa BDIRM'); 

		$grid->setFormUpload(TRUE);

		$grid->setSearch('dossier_upd.vUpd_no');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('dossier_upd.iSediaan','combobox','',array(''=>'Pilih','1'=>'Solid','2'=>'Non Solid'));
		$grid->changeFieldType('iapp_ir_buatdossier','combobox','',array('0'=>'Waiting Approval','1'=>'Rejected','2'=>'Approved'));
		$grid->changeFieldType('iapp_bdi_buatdossier','combobox','',array('0'=>'Waiting Approval','1'=>'Rejected','2'=>'Approved'));
		$grid->changeFieldType('iSubmit_kelengkapan1','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submited'));
		
		

	//Field mandatori
		$grid->setRequired('iSediaan');	
		$grid->setRequired('iTeam_andev');	
		$grid->setRequired('lDeleted');	

		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_review.idossier_upd_id', 'inner');		
		$grid->setJoinTable('dossier.dossier_prioritas_detail', 'dossier_prioritas_detail.idossier_upd_id = dossier_upd.idossier_upd_id', 'inner');
		$grid->setJoinTable('dossier.dossier_prioritas', 'dossier_prioritas.idossier_prioritas_id = dossier_prioritas_detail.idossier_prioritas_id', 'inner');

		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_review.irelease_imm',1);
		//$grid->setQuery('dossier_review.iKelengkapan_data3', 2);

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
			  	//			$r['status'] = FALSE;
                 //           $r['message'] = "Nama Negara Sudah ada";
                 //           echo json_encode($r);
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
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();
				$type='';
				if($this->auth->is_manager()){
					$x=$this->auth->dept();
					$manager=$x['manager'];
					if(in_array('IR', $manager)){
						$type='IR';
						
					}
					elseif(in_array('BDI', $manager)){
						$type='BDI';
					}
				}
				$iapp=$type=='IR'?'iapp_ir_buatdossier':'iapp_bdi_buatdossier';
				$dapp=$type=='IR'?'dapp_ir_buatdossier':'dapp_bdi_buatdossier';
				$capp=$type=='IR'?'capp_ir_buatdossier':'capp_bdi_buatdossier';
				$skg=date('Y-m-d H:i:s');
				$this->dbset->where('idossier_review_id', $get['idossier_review_id']);
				$data[$iapp]=2;
				$data[$dapp]=$skg;
				$data[$capp]=$this->user->gNIP;
				$this->dbset->update('dossier.dossier_review', $data);
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
 	$mydept = $this->auth->my_depts(TRUE);
 	$type='';
 	if (isset($mydept)) {
		if((in_array('BDI', $mydept))) {
			$type='BDI';
		}elseif((in_array('IR', $mydept))) {
			$type='IR';
		}
	}else{
 		 unset($actions['edit']);
 		 unset($actions['delete']);
 	}
 	if($type=='BDI'){
 		if($row->iapp_ir_buatdossier==0 or $row->iapp_bdi_buatdossier!=0){
 			unset($actions['edit']);
 		 	unset($actions['delete']);
 		}
 	}
 	elseif($type=='IR'){
 		if($row->iapp_ir_buatdossier!=0){
 			unset($actions['edit']);
 		 	unset($actions['delete']);
 		}
 	}else{
 		unset($actions['edit']);
 		 	unset($actions['delete']);
 	}

	 return $actions;

 } 




function listBox_pembuatan_dossier_export_dossier_prioritas_iSemester ($value) {
	return 'Semester '.$value;
}

function listBox_pembuatan_dossier_export_dossier_upd_iTeam_andev ($value) {
	if ($value == 74) {
		$andev = 'Andev 1';
	}else{
		$andev = 'Andev 2';
	}

	return $andev;
}

function listBox_pembuatan_dossier_export_dossier_upd_iSediaan ($value) {
	if ($value == 1) {
		$sediaan = 'Solid';
	}else{
		$sediaan = 'Injection';
	}

	return $sediaan;
}


/*manipulasi view object form start*/


function updateBox_pembuatan_dossier_export_vUpd_no($field, $id, $value, $rowData) {
	$sql = 'select * from dossier.dossier_upd a where a.idossier_upd_id="'.$rowData['idossier_upd_id'].'" ';
	$data_upd = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];

	}else{

		$return= $data_upd['vUpd_no'].' - '.$data_upd['vNama_usulan'];
	}
	
	return $return;
}

function updateBox_pembuatan_dossier_export_vNama_usulan($field, $id, $value, $rowData) {
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

function updateBox_pembuatan_dossier_export_iTeam_andev($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$rowData['idossier_upd_id']))->row_array();
		if ($rows['iTeam_andev']==74) {
			$tim = 'Andev 1';	
		}else{
			$tim = 'Andev 2';	
		}
		

		if ($this->input->get('action') == 'view') {
			$return= $tim;

		}
		else{
			$return= $tim;
		}
		
		return $return;
}

function updateBox_pembuatan_dossier_export_cCek_kelengkapan3($field, $id, $value, $rowData) {
	
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

function updateBox_pembuatan_dossier_export_cCek_kelengkapan2($field, $id, $value, $rowData) {
		if ($rowData['iKelengkapan_data2'] <> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cCek_kelengkapan2']))->row_array();

			if ($rowData['iKelengkapan_data2'] == 2) {
				$palue='Approved by '.$rows['vName'].' pada '.$rowData['dCek_kelengkapan2'].', Remark :'.$rowData['vRemark_kelengkapan2'] ;	
			}else{
				$palue='Rejected by '.$rows['vName'].' pada '.$rowData['dCek_kelengkapan2'].', Remark :'.$rowData['vRemark_kelengkapan2'];	
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



function updateBox_pembuatan_dossier_export_rincian_dok($field, $id, $value, $rowData) {
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
		//$return= $this->load->view('pembuatan_dossier_export',$data,TRUE);

		$sql_negara="select * from dossier.dossier_upd_negara ne 
		inner join dossier.dossier_negara neg on neg.idossier_negara_id = ne.idossier_negara_id
		where ne.lDeleted=0 and ne.idossier_upd_id=".$rowData['idossier_upd_id'];
		$data['mnnegara'] = $this->dbset->query($sql_negara)->result_array();
		
		$return = '
				<script type="text/javascript">
					$("label[for=\''.$id.'\']").hide();
					$("label[for=\''.$id.'\']").next().css("margin-left",0);
				</script>
			';

		//data row table dokumen
		$sql_data="select doklist.*,kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen,dok.ijml_dok,dok.ibobot,
					divi.vDescription,doklist.istatus_keberadaan,em.vName
					from dossier.dossier_dok_list doklist
					inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=doklist.idossier_dokumen_id
					inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=dok.idossier_kat_dok_id
					inner join dossier.dossier_review rev on doklist.idossier_review_id=rev.idossier_review_id
					inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
					left join hrd.employee em on em.cNip=up.vpic
					left join hrd.msdivision divi on divi.iDivID=dok.idivisionId
					where doklist.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0 and up.lDeleted=0 and (divi.lDeleted=0 or divi.lDeleted is null)
					and doklist.idossier_review_id=".$rowData['idossier_review_id']."
					order by kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen ASC";
		$data['dokumen']=$this->dbset->query($sql_data)->result_array();

		$return.=$this->load->view('file_pembuatan_dossier',$data,TRUE);		
		return $return;
		
}

function updateBox_pembuatan_dossier_export_dPembuatan_dossier($field, $id, $value, $rowData) {
		//$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cCek_kelengkapan2']))->row_array();
		if($value=="0000-00-00"){
			$value="";
		}
		$mydept = $this->auth->my_depts(TRUE);
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return ="";
			if (isset($mydept)) {
				if((in_array('IR', $mydept))) {
					$return .= '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" />';
					$return .='<script>
						 $("#'.$id.'").datepicker({	changeMonth:true,
													changeYear:true,
													dateFormat:"yy-mm-dd" });
					</script>';
				}else{
					$return .= $value;

				}
			}
		
		}

		
		
		return $return;
}

function updateBox_pembuatan_dossier_export_dPeriksa_ir($field, $id, $value, $rowData) {
		//$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cCek_kelengkapan2']))->row_array();
	if($value=="0000-00-00"){
			$value="";
		}
		$type='';
		$mydept = $this->auth->my_depts(TRUE);
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
					/*
					if($this->auth->is_manager()){
						$x=$this->auth->dept();
						$manager=$x['manager'];
						if(in_array('BDI', $manager))
							{$type='BDI';}
						elseif(in_array('AD', $manager))
							{$type='AD';}
						else{$type='xx';}
						//echo $type;
					}
					*/

			$return =$type;
			if (isset($mydept)) {
				if((in_array('IR', $mydept))) {
					if($this->auth->is_managerdept('IR')){ 
						//jika manager maka tampil
						$return .= '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" />';

						$return .='<script>
						 			$("#'.$id.'").datepicker({	changeMonth:true,
													changeYear:true,
													dateFormat:"yy-mm-dd" });
									</script>';
					}
					
				}else{
					$return .= $value;
				}
			}
		
		}

		
		return $return;
}

function updateBox_pembuatan_dossier_export_dPeriksa_bdirm($field, $id, $value, $rowData) {
		if($value=="0000-00-00"){
			$value="";
		}
		$mydept = $this->auth->my_depts(TRUE);
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return ="";
			if (isset($mydept)) {
				if((in_array('BDI', $mydept))) {
					$return .= '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" />';
					$return .='<script>
							 $("#'.$id.'").datepicker({	changeMonth:true,
														changeYear:true,
														dateFormat:"yy-mm-dd" });
						</script>';
				}else{
					$return .= $value;
				}
			}
		
		}
		return $return;
}

function updateBox_pembuatan_dossier_export_iapp_ir_buatdossier($field, $id, $value, $rowData) {
	if($rowData['iapp_ir_buatdossier'] != 0){
		$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['capp_ir_buatdossier']))->row_array();
		if($rowData['iapp_ir_buatdossier']==2){$st="Approved";}elseif($rowData['iapp_ir_buatdossier']==1){$st="Rejected";} 
		$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['capp_ir_buatdossier'].' )'.' pada '.$rowData['dapp_ir_buatdossier'];
	}
	else{
		$ret='Waiting for Approval';
	}
	
	return $ret;
}

function updateBox_pembuatan_dossier_export_iapp_bdi_buatdossier($field, $id, $value, $rowData) {
	if($rowData['iapp_bdi_buatdossier'] != 0){
		$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['capp_bdi_buatdossier']))->row_array();
		if($rowData['iapp_bdi_buatdossier']==2){$st="Approved";}elseif($rowData['iapp_bdi_buatdossier']==1){$st="Rejected";} 
		$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['capp_bdi_buatdossier'].' )'.' pada '.$rowData['dapp_bdi_buatdossier'];
	}
	else{
		$ret='Waiting for Approval';
	}
	
	return $ret;
}

/*function pendukung start*/  

function before_update_processor($row, $postData) {
	$mydept = $this->auth->my_depts(TRUE);
 	$type='';
 	if (isset($mydept)) {
		if((in_array('BDI', $mydept))) {
			$type='BDI';
			unset($postData['dPembuatan_dossier']);
			unset($postData['dPeriksa_ir']);
		}elseif((in_array('IR', $mydept))) {
			$type='IR';
			unset($postData['dPeriksa_bdirm']);
		}
	}else{
 		 unset($actions['edit']);
 		 unset($actions['delete']);
 	}
	unset($postData['iapp_bdi_buatdossier']);
	unset($postData['iapp_ir_buatdossier']);
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	return $postData;

}

function after_update_processor($row, $insertId, $postData, $old_data) {
		/*$logged_nip =$this->user->gNIP;
		$qupd="select b.vUpd_no,b.vNama_usulan,b.cNip_pengusul,c.vupb_nomor,c.vupb_nama,d.vName,b.dTanggal_upd,a.iSubmit_kelengkapan1
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id=b.iTeam_andev) as ad
				from dossier.dossier_review a 
				join dossier.dossier_upd b on b.idossier_upd_id=a.idossier_upd_id
				join plc2.plc2_upb c on c.iupb_id = b.idossier_upd_id
				join hrd.employee d on d.cNip=b.cNip_pengusul
				where a.idossier_review_id = '".$insertId."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_kelengkapan1'] ;
		if ($rupd['ad'] == 74) {
			$iTeamandev = 'Andev 1';
		}else{
			$iTeamandev = 'Andev 2';
		}


		if (!empty($postData['dPeriksa_bdirm'])) {
			
			if ($postData['dPeriksa_bdirm'] != '0000-00-00') {
					//notif ke BDIRM

			
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

					$subject="Pemeriksaaan Dossier : UPD ".$rupd['vUpd_no'];
					$content="Diberitahukan bahwa telah ada inputan Pemeriksaan Dossier oleh BDIRM  pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
									<td><b>UPB</b></td><td> : </td><td>".$rupd['vupb_nomor'].' - '.$rupd['vupb_nama']."</td>
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
			
		}else{

			if ($postData['dPeriksa_ir'] != '0000-00-00') {
				// notif ke BDIRM

					//notif ke BDIRM
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

						$subject="Pembuatan Dossier : UPD ".$rupd['vUpd_no'];
						$content="Diberitahukan bahwa telah ada inputan Pembuatan Dossier  pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
										<td><b>UPB</b></td><td> : </td><td>".$rupd['vupb_nomor'].' - '.$rupd['vupb_nama']."</td>
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
		}*/

		
}


function manipulate_update_button($buttons, $rowData) {
	//Data UPD
	$js=$this->load->view("pembuatan_dossier_export_js");
	$sql="select * from dossier.dossier_review rev
		inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
		where rev.lDeleted=0 and up.lDeleted=0 and rev.idossier_review_id=".$rowData['idossier_review_id'];
	$dt=$this->dbset->query($sql)->row_array();
	$setuju = '<button onclick="javascript:setuju(\'pembuatan_dossier_export\', \''.base_url().'processor/plc/pembuatan/dossier/export?action=confirm&last_id='.$this->input->get('id').'&idossier_review_id='.$rowData['idossier_review_id'].'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this,'.$rowData['idossier_review_id'].', \''.$dt['vUpd_no'].'\')" class="ui-button-text icon-save" id="button_save_product_trial_basic_formula">Approve</button>';
	$update=$buttons['update'];
	unset($buttons['update']);
	$type="";
	if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('IR', $manager)){
				$type="IR";
				if($rowData['iapp_ir_buatdossier']==0){
					if ( $rowData['dPembuatan_dossier'] == "0000-00-00" or $rowData['dPeriksa_bdirm'] == "" or $rowData['dPeriksa_ir']=="0000-00-00" or $rowData['dPeriksa_ir']=="" ) {
						$buttons["update"]=$update;
					}else{
						$buttons['update']=$update.$setuju;		
					}
				}
			}
			elseif(in_array('BDI', $manager)){
				$type="BDI";
				if($rowData['iapp_bdi_buatdossier']==0 && $rowData['iapp_ir_buatdossier']==2){
					if ( $rowData['dPeriksa_bdirm'] == "0000-00-00" or $rowData['dPeriksa_bdirm'] == "") {
						$buttons["update"]=$update;
					}else{
						$buttons['update']=$update.$setuju.$js;		
					}
				}
			}
			else{$type='';}
	}
	else{
		$x=$this->auth->dept();
		$team=$x['team'];
		if(in_array('IR', $team)){
			$type="IR";
			if($rowData['iapp_ir_buatdossier']==0){
					if ( $rowData['dPembuatan_dossier'] == "0000-00-00" or $rowData['dPeriksa_bdirm'] == "" or $rowData['dPeriksa_ir']=="0000-00-00" or $rowData['dPeriksa_ir']=="" ) {
						$buttons["update"]=$update;
					}else{
						
					}
				}
		}
		else{$type='';}
	}
	return $buttons;
}

	public function output(){
		$this->index($this->input->get('action'));
	}

}

