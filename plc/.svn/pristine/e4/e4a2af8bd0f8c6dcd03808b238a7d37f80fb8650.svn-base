<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class pengerjaan_dokumen_sas extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Dokumen SAS oleh Admin');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_dok_sas');		
		$grid->setUrl('pengerjaan_dokumen_sas');
		$grid->addList('vNo_req_sas','dossier_komparator.vNo_req_komparator','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','iApprove_bpom','employee.vName','dApproval_sas');
		$grid->setSortBy('vNo_req_sas');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vNo_req_sas','idossier_komparator_id','vUpd_no','vNama_Bahan','dosis','vSediaan','vUpb_Ref','vEksisting','team_andev','vProduk_komparator','harga','Tgl_Expired','jml_sample_tersedia','no_batch_id','dApproval_sas','cApproval_sas','vFileSas','dKirim_ke_bde','dTerima_dari_ir','iDok_td','dSubmit_bpom','vnomor_setuju_bpom');

		//setting widht grid
		$grid->setWidth('vSupplierName', '200'); 
		$grid->setWidth('vTags', '230'); 
		$grid->setWidth('dCreated', '100'); 
		$grid->setWidth('vNote', '220'); 
		$grid->setWidth('cCreatedBy', '220'); 
		$grid->setWidth('iStatus', '100');
		$grid->setWidth('dKirim_ke_bde', '100'); 
		$grid->setWidth('dTerima_dari_ir', '100'); 
		
	//setting widht grid
		$grid->setWidth('vNo_req_sas', '80'); 
		$grid->setWidth('idossier_komparator_id', '80'); 
		$grid->setWidth('employee.vName', '100'); 
		$grid->setWidth('dossier_upd.vUpd_no', '100'); 
		$grid->setWidth('vUpd_no', '100'); 
		$grid->setWidth('vNama_Bahan', '80'); 
		$grid->setWidth('dosis', '100'); 
		$grid->setWidth('vSediaan', '100'); 
		$grid->setWidth('vUpb_Ref', '100'); 
		$grid->setWidth('vEksisting', '100'); 
		$grid->setWidth('team_andev', '100'); 
		$grid->setWidth('vProduk_komparator', '100'); 
		$grid->setWidth('Tgl_Expired', '100'); 
		$grid->setWidth('harga', '100'); 
		$grid->setWidth('no_batch_id', '100'); 
		$grid->setWidth('iDok_sas', '100'); 
		$grid->setWidth('iApprove_bpom', '200'); 
		$grid->setWidth('employee.vName', '150'); 
		$grid->setWidth('jml_sample_tersedia', '100'); 
		$grid->setWidth('dossier_komparator.vNo_req_komparator', '60'); 
		$grid->setWidth('dApproval_sas', '120');
		$grid->setWidth('iDok_td', '120');
		$grid->setWidth('cApprove_bpom', '120');
		$grid->setWidth('dSubmit_bpom', '120');
		
		
		
		//modif label
		$grid->setLabel('vNo_req_sas','No Req SAS'); 
		$grid->setLabel('dossier_komparator.vNo_req_komparator','No Req Komparator'); 
		$grid->setLabel('employee.vName','Approve SAS'); 
		$grid->setLabel('dKirim_ke_bde','Tgl Penyerahan Ke BDE Import'); 
		$grid->setLabel('dTerima_dari_ir','Tgl Terima Dari IR Spv'); 

		$grid->setLabel('dossier_upd.vUpd_no','No Dossier'); 
		$grid->setLabel('vUpd_no','No Dossier'); 
		$grid->setLabel('vNama_Bahan','Nama Produk'); 
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Produk'); 
		$grid->setLabel('iDeleted','Hapus'); 
		$grid->setLabel('dupdate','Tgl Update'); 
		$grid->setLabel('cUpdate','Update By'); 
		$grid->setLabel('dosis','Kekuatan'); 
		$grid->setLabel('vSediaan', 'Sediaan'); 
		$grid->setLabel('vUpb_Ref', 'UPB Referensi'); 
		$grid->setLabel('vEksisting', 'Nama UPB Referensi'); 
		$grid->setLabel('team_andev', 'Team Andev'); 
		$grid->setLabel('vProduk_komparator', 'Nama Produk Komparator'); 
		$grid->setLabel('Tgl_Expired', 'Tgl Expired'); 
		$grid->setLabel('harga', 'Harga'); 
		$grid->setLabel('dApproval_sas', 'Tanggal Approve'); 
		$grid->setLabel('no_batch_id', 'No Batch'); 
		$grid->setLabel('iDok_sas', 'Dok SAS'); 
		$grid->setLabel('iApprove_bpom', 'Status '); 
		$grid->setLabel('jml_sample_tersedia', 'Jml Sample Tersedia'); 
		$grid->setLabel('cApproval_sas', 'Approve By'); 
		$grid->setLabel('vFileSas','File Dokumen SAS');
		$grid->setLabel('iDok_td','Dokumen TD');
		$grid->setLabel('vnomor_setuju_bpom','Nomor Dokumen SAS yang disetujui BPOM');
		$grid->setLabel('dSubmit_bpom','Tgl Submit Dok ke BPOM');
		
		$grid->setFormUpload(TRUE);

		$grid->setSearch('vNo_req_sas','dossier_komparator.vNo_req_komparator','dossier_upd.vUpd_no','iApprove_bpom');
		
		
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iApprove_bpom','combobox','',array(''=>'Pilih Semua',0=>'Draft - Need to be Approval',2=>'Approved'));
		$grid->setQuery('iApprove_sas',2);
		$grid->setQuery('iFileupload_submit',1);
		$grid->setQuery('iFiledownload_submit',1);
		$grid->setQuery('iApprove_bde',1);
		$grid->setQuery('iDok_td',0);
		
		$grid->setRequired('vnomor_setuju_bpom');
		$grid->setRequired('dSubmit_bpom');
	//	$grid->setQuery('asset.asset_sparepart.ldeleted', 0);
		//$grid->setMultiSelect(true);
		
	//Join Table
		$grid->setJoinTable('dossier.dossier_komparator', 'dossier_komparator.idossier_komparator_id = dossier_dok_sas.idossier_komparator_id', 'inner');
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_komparator.idossier_upd_id', 'inner');
		//$grid->setJoinTable('dossier.dossier_bahan_komparator', 'dossier_bahan_komparator.idossier_bahan_komparator_id = dossier_komparator.idossier_bahan_komparator_id', 'inner');
		$grid->setJoinTable('hrd.employee', 'employee.cNip = dossier_dok_sas.cApproval_sas', 'inner');
		
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_upd.lDeleted', 0);
		
		//Set View Gridnya (Default = grid)
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
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
					echo $grid->updated_form();
				break;
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();
				$skg=date('Y-m-d H:i:s');
				$this->dbset->where('idossier_dok_sas_id', $post['pengerjaan_dokumen_sas_idossier_dok_sas_id']);
				$this->dbset->update('dossier.dossier_dok_sas', array('dSubmit_bpom'=>$post['dSubmit_bpom'],'vnomor_setuju_bpom'=>$post['vnomor_setuju_bpom'],'iApprove_bpom'=>2,'dApprove_bpom'=>$skg,'cApprove_bpom'=>$this->user->gNIP));
				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Accept Success!';
				echo json_encode($r);
				exit();
				break;
			case 'employee_list':
				$this->employee_list();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

    /*Maniupulasi Gird Start*/

function listBox_Action($row, $actions){
	if ($row->iApprove_bpom<>0) { 
	 unset($actions['edit']);
	}
	return $actions;
}
 /*function listBox_Action($row, $actions) {
 	$q=mysql_query("select count(b.iteam_id) as jml from plc2.plc2_upb_team_item as a
		join plc2.plc2_upb_team as b on a.iteam_id=b.iteam_id
		where a.vnip='".$this->user->gNIP."' and b.vtipe='ADM'");	
		$team=mysql_fetch_array($q);
	$q1=mysql_query("select count(a.iteam_id) as jml1 from plc2.plc2_upb_team as a
		where a.vnip='".$this->user->gNIP."' and a.vtipe='ADM'");	
		$manager=mysql_fetch_array($q1);
		if($team['jml']==1){
			if ($row->iApprove_bpom<>0) { 
	 		 unset($actions['edit']);
	 		}
		}
		else if ($manager['jml1']==1){
			if ($row->iApprove_bpom<>0) { 
	 		 unset($actions['edit']);
	 		}
		}
		else{
			unset($actions['edit']);
			unset($actions['delete']);
		}
 	
	return $actions;
} 
   
/*Maniupulasi Gird end*/

/*manipulasi view object form start*/
 	
/*manipulasi view object form end*/

/*manipulasi proses object form start*/

   
/*manipulasi proses object form end*/    
function updateBox_pengerjaan_dokumen_sas_vNo_req_sas($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return= $value;
		$return .= '<input type="hidden" name="'.$id.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />
		<input type="hidden" name="isdraft" id="isdraft">';

		
	}
	
	return $return;
}	

function updateBox_pengerjaan_dokumen_sas_idossier_komparator_id($field, $id, $value, $rowData) {
$sql = 'select vNo_req_komparator as a from dossier_komparator where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" ';
	$data_kom = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];

	}else{

		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';

		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="25" value="'.$data_kom['a'].'"/>';
		//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc_export/browse/komparator?field=dokumen_sas\',\'List Komparator\')" type="button">&nbsp;</button>';                
		            
	}
	return $return; 
	
}	

function updateBox_pengerjaan_dokumen_sas_vUpd_no($field, $id, $value, $rowData) {
$sql = 'select b.vUpd_no as a from dossier_komparator as a, dossier_upd as b where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and a.idossier_upd_id=b.idossier_upd_id';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />
		<input type="hidden" name="isdraft" id="isdraft">';
	}
	return $return;
	
}	

function updateBox_pengerjaan_dokumen_sas_dKirim_ke_bde($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return = '<input type="text" name="'.$field.'" readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
		
	}
	
	return $return;
}	

function updateBox_pengerjaan_dokumen_sas_dTerima_dari_ir($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return = '<input type="text" name="'.$field.'" readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
		
	}
	
	return $return;
}

function updateBox_pengerjaan_dokumen_sas_iDok_td($field, $id, $value, $rowData) {
	if($rowData['iDok_td']==0){
		$palue="Tidak";
	}
	else{
		$palue="Ya";
	}
	if ($this->input->get('action') == 'view') {
		$return= $palue;

	}
	else{
		$return = '<input type="hidden" name="'.$field.'" readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
		$return .= '<input type="text" name="'.$field.'_dis" readonly="readonly" id="'.$id.'" value="'.$palue.'" class="input_rows1 required" size="15" />';
		
	}
	
	return $return;
}

function updateBox_pengerjaan_dokumen_sas_dSubmit_bpom($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$palue=date('d-m-Y',strtotime($value));
		$return= $palue;

	}
	else{
		$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1 datepicker required" size="15" />';
		$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
						
					</script>';
		
	}
	
	return $return;
}

function updateBox_pengerjaan_dokumen_sas_vnomor_setuju_bpom($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;
	}
	else{
		$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
		
	}
	
	return $return;
}	


function updateBox_pengerjaan_dokumen_sas_vNama_Bahan($field, $id, $value, $rowData) {
$sql = 'select b.vNama_usulan as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'" readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}	

function updateBox_pengerjaan_dokumen_sas_dosis($field, $id, $value, $rowData) {
$sql = 'select c.dosis as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function updateBox_pengerjaan_dokumen_sas_vSediaan($field, $id, $value, $rowData) {
$sql = 'select d.vSediaan as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function updateBox_pengerjaan_dokumen_sas_vUpb_Ref($field, $id, $value, $rowData) {
$sql = 'select c.vupb_nomor as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}


function updateBox_pengerjaan_dokumen_sas_vEksisting($field, $id, $value, $rowData) {
$sql = 'select c.vupb_nama as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function updateBox_pengerjaan_dokumen_sas_team_andev($field, $id, $value, $rowData) {
$sql = 'select e.vteam as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function updateBox_pengerjaan_dokumen_sas_vProduk_komparator($field, $id, $value, $rowData) {
$sql = 'select b.cNip_pengusul as a, b.vNama_usulan as b from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'].' - '.$data_kom['b'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].' - '.$data_kom['b'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function updateBox_pengerjaan_dokumen_sas_Tgl_Expired($field, $id, $value, $rowData) {
$sql = 'select a.dTgl_expired as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function updateBox_pengerjaan_dokumen_sas_harga($field, $id, $value, $rowData) {
$sql = 'select a.iHarga as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function updateBox_pengerjaan_dokumen_sas_no_batch_id($field, $id, $value, $rowData) {
$sql = 'select a.vNo_Batch as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function updateBox_pengerjaan_dokumen_sas_jml_sample_tersedia($field, $id, $value, $rowData) {
$sql = 'select a.iJumlah_sample as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function updateBox_pengerjaan_dokumen_sas_dApproval_sas($field, $id, $value, $rowData) {
		$return= $rowData['dApproval_sas'];
		$return .='<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" />';
		return $return;
}

function updateBox_pengerjaan_dokumen_sas_cApproval_sas($field, $id, $value, $rowData) {
	
	

		if ($rowData['iApprove_sas']<> 0 ) {

			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cApproval_sas']))->row_array();

			if ($rowData['iApprove_sas'] == 2) {
				$palue='Approved by '.$rows['vName'].', Remark :'.$rowData['vRemark'] ;
			}else{
				$palue='Rejected by '.$rows['vName'].', Remark :'.$rowData['vRemark'];	
			}
			
		}else{
			$palue='Waiting Approval';
		}

		if ($this->input->get('action') == 'view') {
			$return= $palue;

		}
		else{
			$palue .= '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" />';
			$return= $palue;
		}
		
		return $return;
}


function updateBox_pengerjaan_dokumen_sas_vFileSas($field, $id, $value, $rowData) {

		//return print_r($rowData);
	 	$idossier_dok_sas_id=$rowData['idossier_dok_sas_id'];
		$data['rows'] = $this->db_plc0->get_where('dossier.dossier_file_dok_sas', array('idossier_dok_sas_id'=>$idossier_dok_sas_id))->result_array();
		return $this->load->view('pengerjaan_dokumen_sas_file',$data,TRUE);
	}

function manipulate_update_button($buttons, $rowData) {
	$cNip= $this->user->gNIP;

	$js = $this->load->view('pengerjaan_dokumen_sas_js');

	$update = '<button onclick="javascript:update_btn_back(\'pengerjaan_dokumen_sas\', \''.base_url().'processor/plc/pengerjaan/dokumen/sas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_pengerjaan_dokumen_sas">Accept</button>';
	$Accept = '<button onclick="javascript:setuju(\'pengerjaan_dokumen_sas\', \''.base_url().'processor/plc/pengerjaan/dokumen/sas?action=confirm&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$this->input->get('id').', \''.$rowData['vNo_req_sas'].'\')" class="ui-button-text icon-save" id="button_pengerjaan_dokumen_sas">Accept</button>';

	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if ($rowData['iApprove_bpom']== 0) {
			$buttons['update'] = $Accept.$js;
		}else{
		}
	}
	return $buttons;
}



/*function pendukung start*/    
function before_update_processor($row, $postData) {
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	$postData['iApprove_bpom']=1;
	$dt=strtotime($postData['dSubmit_bpom']);
	$postData['dSubmit_bpom']=date('Y-m-d',$dt);
	//return $postData;
	// ubah status submit
	//if($postData['isdraft']==true){
	
	//} 
	//else{$postData['iApprove_bpom']=1;} 

	return $postData;

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
		//$path = $path."/".$lastId;
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
					$del = "delete from dossier.".$table." where idossier_dok_sas_id = {$lastId} and vDok_sas_name= '{$v}'";
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
			$sql = "SELECT vDok_sas_name from dossier.".$table." where idossier_dok_sas_id=".$lastId;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['vDok_sas_name'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT vDok_sas_name from dossier.".$table." where idossier_dok_sas_id=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM dossier.".$table." where idossier_dok_sas_id=".$lastId." and vDok_sas_name='".$row['vDok_sas_name']."'";			
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
/*function pendukung end*/    	

	
		public function output(){
		$this->index($this->input->get('action'));
	}

}
