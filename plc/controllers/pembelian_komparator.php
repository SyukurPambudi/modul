<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class pembelian_komparator extends MX_Controller {
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
		$grid->setTitle('Pembelian Komparator');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_komparator');		
		$grid->setUrl('pembelian_komparator');
		$grid->addList('vNo_req_komparator','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','plc2_upb_team.vteam','iApprove_plan','cApprove_bdirm','cApprove_direksi');
		$grid->setSortBy('vNo_req_komparator');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vNo_req_komparator','idossier_upd_id','vNama_bahan','dosis','vSediaan','vUpb_Ref','vEksisting','vteam','vProduk_komparator','dreq_komparator','vFileKom','iHarga','dTgl_expired','iJumlah_sample','vNo_Batch','iDok_sas','vOr_pajak','vOr_pembelian','vAsal_dok','dTerima','dKirim');

		//setting widht grid
		$grid->setWidth('vNo_req_komparator', '80'); 
		$grid->setWidth('dossier_upd.vUpd_no','100');
		$grid->setWidth('dossier_upd.vNama_usulan','100');
		$grid->setWidth('dosis','100');
		$grid->setWidth('vSediaan','100');
		$grid->setWidth('vUpb_Ref','100');
		$grid->setWidth('vEksisting','100');
		$grid->setWidth('plc2_upb_team.vteam','100');
		$grid->setWidth('vProduk_komparator','100');
		$grid->setWidth('vFileKom','100');
		$grid->setWidth('iApprove_plan','100');
		$grid->setWidth('AppByDirm', '200'); 
		$grid->setWidth('iHarga', '200'); 
		$grid->setWidth('dTgl_expired', '200'); 
		$grid->setWidth('iJumlah_sample', '200');
		$grid->setWidth('vNo_Batch', '200');
		$grid->setWidth('dApprove_bdirm', '200');
		$grid->setWidth('dApprove_direksi', '200');
		$grid->setWidth('iDok_sas', '200');
		$grid->setWidth('vOr_pajak', '200');
		$grid->setWidth('dTerima', '200');
		$grid->setWidth('dKirim', '200');

		
		//modif label
		$grid->setLabel('vNo_req_komparator','No Req Komparator');
		$grid->setLabel('vAsal_dok','Asal Dok SAS');
		$grid->setLabel('vOr_pembelian','No OR Pembelian');
		$grid->setLabel('dossier_upd.vUpd_no','No Dossier');
		$grid->setLabel('idossier_upd_id','No Dossier');
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Produk');
		$grid->setLabel('vNama_bahan','Nama Produk');
		$grid->setLabel('vSediaan','Sediaan');
		$grid->setLabel('vUpb_Ref','UPB Referensi');
		$grid->setLabel('vEksisting','Nama UPB Referensi');
		$grid->setLabel('plc2_upb_team.vteam','Team Andev');
		$grid->setLabel('vteam','Team Andev');
		$grid->setLabel('vProduk_komparator','Requestor');
		$grid->setLabel('vFileKom','Permintaan Komparator');
		$grid->setLabel('iApprove_plan','Status');
		$grid->setLabel('dosis','Kekuatan / Dossier');
		$grid->setLabel('iHarga','Harga');
		$grid->setLabel('dTgl_expired','Tgl Expired');
		$grid->setLabel('iJumlah_sample','Jml Sample Tersedia');
		$grid->setLabel('vNo_Batch','No Batch');
		$grid->setLabel('dApprove_bdirm','Approve By BDIRM');
		$grid->setLabel('dApprove_direksi','Approve By Direksi');
		$grid->setLabel('cApprove_bdirm','Approve By BDIRM');
		$grid->setLabel('cApprove_direksi','Approve By Direksi');
		$grid->setLabel('iDok_sas','Dok Sas');
		$grid->setLabel('vOr_pajak','OR Pajak SAS(jika ada)');
		$grid->setLabel('dTerima','Tgl Terima dr Supplier');
		$grid->setLabel('dKirim','Tgl Kirim ke Andev');
		$grid->setLabel('dreq_komparator','Tanggal Permintaan Komprator');


		$grid->setFormUpload(TRUE);

		$grid->setSearch('vNo_req_komparator','dossier_upd.vUpd_no','plc2_upb_team.vteam','iApprove_plan');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iApprove_plan','combobox','',array(''=> 'Pilih',0=>'Draft-Need Submit',1=>'Submited'));
		$grid->changeFieldType('iDok_sas','combobox','',array(''=> 'Pilih',0=>'Tidak',1=>'Ya'));
		

	//Field mandatori
		$grid->setRequired('vNo_req_komparator');
		$grid->setRequired('iDok_sas');
		$grid->setRequired('vOr_pajak');
		$grid->setRequired('dTerima');
		$grid->setRequired('dKirim');
	//	$grid->setQuery('asset.asset_sparepart.ldeleted', 0);
		$grid->setQuery('iApprove_bdirm',2);
		$grid->setQuery('iApprove_direksi',2);
		$grid->setQuery('iDok_Submit_Beli',1);
		//$grid->setMultiSelect(true);
		
		//join table
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_komparator.idossier_upd_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_team','plc2_upb_team.iteam_id=dossier.dossier_upd.iTeam_andev','inner');

		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_upd.lDeleted', 0);

		$grid->setGridView('grid');

		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
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
			case 'getspname':
				echo $this->getSpname();
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
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }

function listBox_Action($row, $actions) {
		/*
		//$q=mysql_query("select count(b.iteam_id) as jml from plc2.plc2_upb_team_item as a
		//join plc2.plc2_upb_team as b on a.iteam_id=b.iteam_id
		//where a.vnip='".$this->user->gNIP."' and b.vtipe='IR'");
		$q3=mysql_query("select count(a.iteam_id) as jml1 from plc2.plc2_upb_team as a
		where a.vnip='".$this->user->gNIP."' and a.vtipe='IR'");	
		$manager=mysql_fetch_array($q3);	
		//$team=mysql_fetch_array($q);
		//if($team['jml']==1){
		//	if ($row->iApprove_plan<>0) {
 		 //		unset($actions['edit']);
 			//}
		//}
		if ($manager['jml1']==1){
			if ($row->iApprove_plan<>0) {
 		 		unset($actions['edit']);
 			}
		}
		
		else{
			unset($actions['edit']);
		}*/
		$type='';
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('AD', $manager)){
				$type='AD';
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('AD', $team)){
				$type='AD';
			}else{$type='';}
		
		}
		if($type=='AD'){
			if ($row->iApprove_plan!=0){
 		 		unset($actions['edit']);
 			}
		}else{
			unset($actions['edit']);
		}
		return $actions;

 }

   function listBox_pembelian_komparator_cApprove_bdirm($value, $pk, $name, $rowData) {
    	$sql = "SELECT a.vName from hrd.employee a where a.cNip = '{$value}'";
		$query = $this->dbset->query($sql);
		$nama_group = '-';
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$nama_group = $row->vName;
		}
		
		return $nama_group;
	}

   function listBox_pembelian_komparator_cApprove_direksi($value, $pk, $name, $rowData) {
    	$sql = "SELECT a.vName from hrd.employee a where a.cNip = '{$value}'";
		$query = $this->dbset->query($sql);
		$nama_group = '-';
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$nama_group = $row->vName;
		}
		
		return $nama_group;
	}


/*manipulasi view object form start*/

function updateBox_pembelian_komparator_vNo_req_komparator($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return= $value;
		//$return .= '<input type="hidden" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';

		
	}
	
	return $return;
}	


function updateBox_pembelian_komparator_idossier_upd_id($field, $id, $value, $rowData) {
$sql = 'select b.vUpd_no as a1 from dossier_komparator as a, dossier_upd as b where a.idossier_upd_id=b.idossier_upd_id and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];

	}else{
		$return	= $data_kom['a1'];

		//$return = '<script>
		//				$( "button.icon_pop" ).button({
		//					icons: {
		//						primary: "ui-icon-newwin"
		//					},
		//					text: false
		//				})
		//			</script>';

		$return .= '<input type="hidden" name="isdraft" id="isdraft"><input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1" />';
		//$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="25" value="'.$data_kom['a1'].'"/>';
		//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upd/komparator?field=pembelian_komparator\',\'List Komparator\')" type="button">&nbsp;</button>';                
		            
	}
	return $return; 
	
}	


function updateBox_pembelian_komparator_vNama_bahan($field, $id, $value, $rowData) {
$sql = 'select b.vNama_usulan as a1 from dossier_komparator as a, dossier_upd as b where a.idossier_upd_id=b.idossier_upd_id and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return= $data_kom['a1'];
		//$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}	


function updateBox_pembelian_komparator_dosis($field, $id, $value, $rowData) {
$sql = 'select c.dosis as a1 from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c where a.idossier_upd_id=b.idossier_upd_id and c.iupb_id = b.iupb_id and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return= $data_kom['a1'];
		//$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}


function updateBox_pembelian_komparator_vSediaan($field, $id, $value, $rowData) {
$sql = 'select d.vSediaan as a1 from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d where a.idossier_upd_id=b.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id = c.isediaan_id and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return= $data_kom['a1'];
		//$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}


function updateBox_pembelian_komparator_vUpb_Ref($field, $id, $value, $rowData) {
$sql = 'select c.vupb_nomor as a1 from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d where a.idossier_upd_id=b.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id = c.isediaan_id and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return= $data_kom['a1'];
		//$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function updateBox_pembelian_komparator_vEksisting($field, $id, $value, $rowData) {
$sql = 'select c.vupb_nama as a1 from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d where a.idossier_upd_id=b.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id = c.isediaan_id and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return= $data_kom['a1'];
		//$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function updateBox_pembelian_komparator_vteam($field, $id, $value, $rowData) {
$sql = 'select e.vteam as a1 from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e where a.idossier_upd_id=b.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id = c.isediaan_id and e.iteam_id = b.iTeam_andev and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return= $data_kom['a1'];
		//$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function updateBox_pembelian_komparator_vProduk_komparator($field, $id, $value, $rowData) {
$sql = 'select f.vName as a1, b.cNip_pengusul as b1 from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e, hrd.employee as f where a.idossier_upd_id=b.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id = c.isediaan_id and e.iteam_id = b.iTeam_andev and f.cNip = b.cNip_pengusul and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['b1'].' - '.$data_kom['a1'];
	}
	else{
		$return= $data_kom['b1'].' - '.$data_kom['a1'];
		//$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['b1'].' - '.$data_kom['a1'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function updateBox_pembelian_komparator_dupdate($field, $id, $value, $rowData) {
		$skg=date('Y-m-d');
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = $value;
			//$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$skg.'" class="input_rows1" size="8" />';
		}
		
		return $return;
}

function updateBox_pembelian_komparator_cUpdate($field, $id, $value, $rowData) {
		$skg=date('Y-m-d');
		$cNip = $this->user->gNIP;
		$emp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$cNip))->row_array();
		$vName = $this->user->gName;
		if ($this->input->get('action') == 'view') {
			$return= $emp['vName'];

		}
		else{
			$return = $emp['vName'];
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$cNip.'" class="input_rows1" size="8" />';
		}
		
		return $return;
}

function updateBox_pembelian_komparator_dApprove($field, $id, $value, $rowData) {
		if ($rowData['iApprove_sas']<> 0 ) {
			$palue= $rowData['dApproval_sas'];
			
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
function updateBox_pembelian_komparator_cApprove($field, $id, $value, $rowData) {
	
	

		if ($rowData['iApprove']<> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cApprove']))->row_array();

			if ($rowData['iApprove'] == 2) {
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
			$return= $palue;
		}
		
		return $return;
}

function updateBox_pembelian_komparator_vFileKom($field, $id, $value, $rowData) {

		//return print_r($rowData);
	 	$idossier_komparator_id=$rowData['idossier_komparator_id'];
		$data['rows'] = $this->db_plc0->get_where('dossier.dossier_komparator_detail', array('idossier_komparator_id'=>$idossier_komparator_id, 'iDelete'=>0))->result_array();
		return $this->load->view('pembelian_komparator_file',$data,TRUE);
	}

function updateBox_pembelian_komparator_iHarga($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;
	}
	else{
		$return	= $value;
		//$return = '<input type="number" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1" readonly="readonly" size="25"/>';
	}
	return $return;
	
}
function updateBox_pembelian_komparator_dTgl_expired($field, $id, $value, $rowData) {
	$dt=strtotime($value);
	$palue=date('d-m-Y',$dt);
	if ($this->input->get('action') == 'view') {
		$return= $palue;
	}
	else{
		if ($value==""){
			$palue="";
		}
		$return=$palue;
		//$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$palue.'" class="input_rows1" readonly="readonly" size="25" />';
	}
	return $return;
	
}

function updateBox_pembelian_komparator_iJumlah_sample($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;
	}
	else{
		$return=$value;
		//$return = '<input type="number" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1" readonly="readonly" size="25" />';
	}
	return $return;
	
}
function updateBox_pembelian_komparator_vNo_Batch($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;
	}
	else{
		$return	= $value;
		//$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1" readonly="readonly" size="25" />';
	}
	return $return;
	
}

function updateBox_pembelian_komparator_vOr_pajak($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		if($value<>''){
			$return= $value;
		}else{
			$return= '-';
		}
		
	}
	else{
		$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}
function updateBox_pembelian_komparator_vOr_pembelian($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		if($value<>''){
			$return= $value;
		}else{
			$return= '-';
		}
		
	}
	else{
		$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}
function updateBox_pembelian_komparator_vAsal_dok($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		if($value<>''){
			$return= $value;
		}else{
			$return= '-';
		}
		
	}
	else{
		$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}

function updateBox_pembelian_komparator_dTerima($field, $id, $value, $rowData) {
	if($this->input->get('action')=='view'){
		$return	=date('d-m-Y',strtotime($value));
	}else{
		if($value==''){
			$value="";
		}else{
			$value=date('d-m-Y',strtotime($value));
		}
	$return = '<input name="'.$id.'" id="'.$id.'" type="text" class="input_tgl datepicker required" style="width:158px" value="'.$value.'" />';
	$return .=	'<script>
					$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
				</script>';
	}
	return $return;
}
function updateBox_pembelian_komparator_dKirim($field, $id, $value, $rowData) {
	if($this->input->get('action')=='view'){
		$return	=date('d-m-Y',strtotime($value));
	}else{
		if($value==""){
			$palue=NULL;
		}else{
			$palue=date('d-m-Y',strtotime($value));
		}
	$return = '<input name="'.$id.'" id="'.$id.'" type="text" class="input_tgl datepicker required" style="width:158px" value="'.$palue.'" />';
	$return .=	'<script>
					$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
				</script>';
	}
	return $return;
	
}
function updateBox_pembelian_komparator_dreq_komparator($field, $id, $value, $rowData) {
	if($this->input->get('action')=='view'){
		$return	=date('d-m-Y',strtotime($value));
	}else{
		$return	=date('d-m-Y',strtotime($value));
	/*$return = '<input name="'.$id.'" id="'.$id.'" type="text" class="input_tgl datepicker required" style="width:158px" disabled="TRUE" value='.date('d-m-Y',strtotime($value)).' />';
	$return .=	'<script>
					$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
				</script>';
	*/}
	return $return;
}
/*manipulasi view object form end*/

/*manipulasi proses object form start*/

    
   
/*manipulasi proses object form end*/    

/*function pendukung start*/  
function before_update_processor($row, $postData) {
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	//return $postData;
	// ubah status submit
	
	if($postData['isdraft']==true){
		$postData['iApprove_plan']=0;
	} 
	else{$postData['iApprove_plan']=1;} 

	$dt=strtotime($postData['dTgl_expired']);
	$postData['dTgl_expired']=date('Y-m-d',$dt);
	$dt=strtotime($postData['dKirim']);
	$postData['dKirim']=date('Y-m-d',$dt);
	$dt=strtotime($postData['dTerima']);
	$postData['dTerima']=date('Y-m-d',$dt);
	unset($postData['idossier_upd_id']);
	unset($postData['vNo_req_komparator']);
	unset($postData['dreq_komparator']);
	unset($postData['iHarga']);
	unset($postData['dTgl_expired']);
	unset($postData['iJumlah_sample']);
	unset($postData['vNo_Batch']);
	unset($postData['pembelian_komparator_idossier_upd_id']);
	return $postData;

}


function manipulate_update_button($buttons, $rowData) {
	$cNip= $this->user->gNIP;

	$js = $this->load->view('pembelian_komparator_js');

	$update = '<button onclick="javascript:update_btn_back(\'pembelian_komparator\', \''.base_url().'processor/plc/pembelian/komparator?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_pembelian_komparator">Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'pembelian_komparator\', \''.base_url().'processor/plc/pembelian/komparator?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_pembelian_komparator">Update as Draft</button>';



	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if ($rowData['iApprove_plan']== 0) {
			// jika masih draft , show button update draft & update submit 
			$buttons['update'] = $update.$js;
		}else{
			// sudah disubmit , show button approval 
			
		}

		//$buttons['update'] = $update.$updatedraft.$approve.$reject.$js;
	}
	

	return $buttons;


}	

function after_update_processor($row, $insertId, $postData){
		$submit=$postData['iApprove_plan'];
		if ($submit == 1) {
			$qupd="select a.iDok_sas as dok_sas, a.vOr_pajak as pajak, a.dTerima as terima, a.dKirim as kirim, d.iteam_id as item,a.iDok_Submit as submit, a.vNo_req_komparator as no_komparator, b.vUpd_no as no_upd, b.vNama_usulan as nama_usulan, b.cNip_pengusul as nip, c.vName as name from dossier.dossier_komparator as a
			join dossier.dossier_upd as b on a.idossier_upd_id=b.idossier_upd_id
			join hrd.employee as c on b.cNip_pengusul=c.cNip
			join plc2.plc2_upb_team as d on b.iTeam_andev=d.iteam_id
			where a.idossier_komparator_id='".$insertId."'";
			$rupd = $this->db_plc0->query($qupd)->row_array();
			$andev=$rupd['item'];
			

			$query1=mysql_query("select a1.iteam_id as item_bdirm from plc2.plc2_upb_team as a1 where a1.vtipe='BDI'");
			$datbd=array();
			$i=0;
			while($datbdi=mysql_fetch_array($query1)){
				$datbd[$i] = $datbdi['item_bdirm'];
				$i++;
			}
			$databdirm=implode(',',$datbd);


			$query=mysql_query("select a1.iteam_id as item_bdirm from plc2.plc2_upb_team as a1 where a1.vtipe='DR'");
			$datdireksi=array();
			$i=0;
			while($datdir=mysql_fetch_array($query)){
				$datdireksi[$i] = $datdir['item_bdirm'];
				$i++;
			}
			$datadireksi=implode(',',$datdireksi);

			if ($andev == 74) {
				$iTeamandev = 'Andev 1';
			}else{
				$iTeamandev = 'Andev 2';
			}
			$team=$andev.",".$databdirm.",".$datadireksi;
			//$logged_nip =$this->user->gNIP;
	        $toEmail2='';
			$toEmail20 = $this->lib_utilitas->get_email_team( $team );
	        $toEmail21 = $this->lib_utilitas->get_email_leader( $team );
	        //$arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
	        $arrEmail = $this->lib_utilitas->get_email_by_nip($this->user->gNIP);                    
	                    
			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($toEmail);
				$to = $toEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
				}
			}
			
			//$toEmail="supri@novellpharm.com";
			//$toEmail2="mansur@novellpharm.com";
			//$toEmail3="farhah.syafina@novellpharm.com";
			//$to = $toEmail2.';'.$toEmail;
			//$cc = $arrEmail;                        
				$doksas=array(0=>'Tidak',1=>'Iya');
				$to = $arrEmail;
				$cc = $toEmail21.','.$toEmail20;                       

				$subject="Pembelian Komparator: <".$rupd['no_komparator'].">";
				$content="Diberitahukan bahwa telah ada Pembelian Komparator yang dialokasikan pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #DCDCDC;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>No Komparator</b></td><td style='width: 20px;'> : </td><td>".$rupd['no_komparator']."</td>
							</tr>
							<tr>
								<td><b>No UPD</b></td><td> : </td><td>".$rupd['no_upd']."</td>
							</tr>
							<tr>
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['nama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['nip']."-".$rupd['name']."</td>
							</tr>
							<tr>
								<td><b>Dokumen Sas</b></td><td> : </td><td>".$doksas[$rupd['dok_sas']]."</td>
							</tr>
							<tr>
								<td><b>OR Pajak SAS</b></td><td> : </td><td>".$rupd['pajak']."</td>
							</tr>
							<tr>
								<td><b>Tgl Terima dr Supplier</b></td><td> : </td><td>".$rupd['terima']."</td>
							</tr>
							<tr>
								<td><b>Tgl Kirim ke Andev</b></td><td> : </td><td>".$rupd['kirim']."</td>
							</tr>
						</table><br />
					</div><br/>
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}
}
/*function pendukung end*/    	


	public function output(){
		$this->index($this->input->get('action'));
	}

}
