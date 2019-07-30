<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class perencanaan_komparator extends MX_Controller {
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
		$grid->setTitle('Perencanaan Komparator');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_komparator');		
		$grid->setUrl('perencanaan_komparator');
		$grid->addList('vNo_req_komparator','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','plc2_upb_team.vteam','iDok_Submit_Beli','iApprove_bdirm','iApprove_direksi');
		$grid->setSortBy('vNo_req_komparator');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vNo_req_komparator','idossier_upd_id','vNama_bahan','dosis','vSediaan','vUpb_Ref','vEksisting','vteam','vProduk_komparator','dreq_komparator','vFileKom','iHarga','dTgl_expired','iJumlah_sample','vNo_Batch','iApprove_bdirm','iApprove_direksi');

		//setting widht grid
		$grid->setWidth('vNo_req_komparator', '80'); 
		$grid->setWidth('dossier_upd.vUpd_no','100');
		$grid->setWidth('dossier_upd.vNama_usulan','300');
		$grid->setWidth('dosis','100');
		$grid->setWidth('vSediaan','100');
		$grid->setWidth('vUpb_Ref','100');
		$grid->setWidth('vEksisting','100');
		$grid->setWidth('plc2_upb_team.vteam','100');
		$grid->setWidth('vProduk_komparator','100');
		$grid->setWidth('vFileKom','100');
		$grid->setWidth('iDok_Submit_Beli','150');
		$grid->setWidth('AppByDirm', '200'); 
		$grid->setWidth('iHarga', '200'); 
		$grid->setWidth('dTgl_expired', '200'); 
		$grid->setWidth('iJumlah_sample', '200');
		$grid->setWidth('vNo_Batch', '200');
		$grid->setWidth('iApprove_bdirm', '100');
		$grid->setWidth('iApprove_direksi', '120');
		
		//modif label
		$grid->setLabel('vNo_req_komparator','No Req Komparator');
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
		$grid->setLabel('iDok_Submit_Beli','Status');
		$grid->setLabel('dosis','Kekuatan / Dossier');
		$grid->setLabel('iHarga','Harga');
		$grid->setLabel('dTgl_expired','Tgl Expired');
		$grid->setLabel('iJumlah_sample','Jml Sample Tersedia');
		$grid->setLabel('vNo_Batch','No Batch');
		$grid->setLabel('iApprove_bdirm','Approve By BDIRM');
		$grid->setLabel('iApprove_direksi','Approve By Direksi');
		$grid->setLabel('dreq_komparator','Tanggal Permintaan Komprator');


		$grid->setFormUpload(TRUE);

		$grid->setSearch('vNo_req_komparator','dossier_upd.vUpd_no','plc2_upb_team.vteam','iApprove_bdirm','iApprove_direksi');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iApprove_direksi','combobox','',array(''=> 'Pilih',0=>'Waiting Approval',1=>'Reject',2=>'Approved'));
		$grid->changeFieldType('iApprove_bdirm','combobox','',array(''=> 'Pilih',0=>'Waiting Approval',1=>'Reject',2=>'Approved'));
		$grid->changeFieldType('iDok_Submit_Beli','combobox','',array(''=> 'Pilih',0=>'Draft - Need to be Publish',1=>'Submited'));
		

	//Field mandatori
		$grid->setRequired('vNo_req_komparator');	
		$grid->setRequired('iHarga');
		$grid->setRequired('dTgl_expired');
		$grid->setRequired('iJumlah_sample');
		$grid->setRequired('vNo_Batch');

		//Approve permintaan komparator
		$grid->setQuery('iApprove',2);

		/*if($this->auth->is_dir()){
			$grid->setQuery('iDok_Submit_Beli', 1);
		}
		elseif($this->auth->is_bdirm()){
			$grid->setQuery('iDok_Submit_Beli', 1);
		}
		*/
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
/*
   function listBox_perencanaan_komparator_cApprove_bdirm($value, $pk, $name, $rowData) {
    	$sql = "SELECT a.vName from hrd.employee a where a.cNip = '{$value}'";
		$query = $this->dbset->query($sql);
		$jmlrow=mysql_num_rows(mysql_query($sql));
		$nama_group="-";
		if($jmlrow==0){
			$nama_group = 'Waiting Approval';
		}
		else{
			if ($query->num_rows() > 0) {
				$row = $query->row();
				$nama_group = $row->vName;
			}
		}
		
		return $nama_group;
	}

   function listBox_perencanaan_komparator_cApprove_direksi($value, $pk, $name, $rowData) {
    	$sql = "SELECT a.vName from hrd.employee a where a.cNip = '{$value}'";
		$query = $this->dbset->query($sql);
		$jmlrow=mysql_num_rows(mysql_query($sql));
		$nama_group="-";
		if($jmlrow==0){
			$nama_group = 'Waiting Approval';
		}
		else{
			if ($query->num_rows() > 0) {
				$row = $query->row();
				$nama_group = $row->vName;
			}
		}
		
		return $nama_group;
	}*/
//Manipulate button
 function listBox_Action($row, $actions) {
 	if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('IR', $manager)){
				$type='IR';
			}
			elseif(in_array('BDI', $manager)){
				$type='BDI';
			}
			elseif(in_array('DR', $manager)){
				$type='DR';
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('IR', $team)){
				$type='IR';
			}
		else{$type='';}
	}

	if($type=='IR'){
		if($row->iDok_Submit_Beli!=0){
			unset($actions['edit']);
		}
	}elseif($type=='BDI'){
		if($row->iDok_Submit_Beli!=0){
			if ($row->iApprove_bdirm!=0) {
	 		 unset($actions['edit']);
	 		}
	 		else{
	 			$actions['edit'];
	 		}
		}else{
			unset($actions['edit']);
		}
	}elseif($type=='DR'){
		if ($row->iApprove_bdirm<=1){
				unset($actions['edit']);
		}else{
			if ($row->iApprove_direksi!=0) {
	 		 	unset($actions['edit']);
	 		} 
 			unset($actions['delete']);
 		}
	}else{
		unset($actions['edit']);
	}
 	/*
 	$q=mysql_query("select count(b.iteam_id) as jml from plc2.plc2_upb_team_item as a
			join plc2.plc2_upb_team as b on a.iteam_id=b.iteam_id
			where a.vnip='".$this->user->gNIP."' and b.vtipe='IR'");	
			$team=mysql_fetch_array($q);
	$q3=mysql_query("select count(a.iteam_id) as jml1 from plc2.plc2_upb_team as a
			where a.vnip='".$this->user->gNIP."' and a.vtipe='IR'");	
			$manager=mysql_fetch_array($q3);

	if($this->auth->is_dir()){
 			if (($row->iApprove_bdirm<=1)){
 				unset($actions['edit']);
 			}
 			else{
				if ($row->iApprove_direksi<>0) {
		 		 	unset($actions['edit']);
		 		} 
	 			unset($actions['delete']);
	 		}
	}
	elseif($this->auth->is_bdirm()){
			if ($row->iApprove_bdirm<>0) {
	 		 unset($actions['edit']);
	 		}
	 		else{
	 			$actions['edit'];
	 		}
	 		 unset($actions['delete']);
	}

	else if($team['jml']==1){
		if ($row->iDok_Submit_Beli<>0) {
		 		unset($actions['edit']);
			}
	}
	
	else if ($manager['jml1']==1){
		if ($row->iDok_Submit_Beli<>0) {
		 		unset($actions['edit']);
			}
	}
	
	else{
		unset($actions['edit']);
	}
	*/
	return $actions;
}

/*manipulasi view object form start*/

function updateBox_perencanaan_komparator_vNo_req_komparator($field, $id, $value, $rowData) {
	//print_r($rowData);
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return= $value;
		$return .= '<input type="hidden" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';

		
	}
	
	return $return;
}	


function updateBox_perencanaan_komparator_idossier_upd_id($field, $id, $value, $rowData) {
$sql = 'select b.vUpd_no as a1 from dossier_komparator as a, dossier_upd as b where a.idossier_upd_id=b.idossier_upd_id and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];

	}else{

		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';

		$return .= '<input type="hidden" name="isdraft" id="isdraft"><input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="25" value="'.$data_kom['a1'].'"/>';
		//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upd/komparator?field=perencanaan_komparator\',\'List Komparator\')" type="button">&nbsp;</button>';                
		            
	}
	return $return; 
	
}	


function updateBox_perencanaan_komparator_vNama_bahan($field, $id, $value, $rowData) {
$sql = 'select b.vNama_usulan as a1 from dossier_komparator as a, dossier_upd as b where a.idossier_upd_id=b.idossier_upd_id and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return = '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}	


function updateBox_perencanaan_komparator_dosis($field, $id, $value, $rowData) {
$sql = 'select c.dosis as a1 from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c where a.idossier_upd_id=b.idossier_upd_id and c.iupb_id = b.iupb_id and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  disabled="TRUE" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}


function updateBox_perencanaan_komparator_vSediaan($field, $id, $value, $rowData) {
$sql = 'select d.vSediaan as a1 from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d where a.idossier_upd_id=b.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id = c.isediaan_id and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  disabled="TRUE" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}


function updateBox_perencanaan_komparator_vUpb_Ref($field, $id, $value, $rowData) {
$sql = 'select c.vupb_nomor as a1 from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d where a.idossier_upd_id=b.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id = c.isediaan_id and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  disabled="TRUE" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}

function updateBox_perencanaan_komparator_vEksisting($field, $id, $value, $rowData) {
$sql = 'select c.vupb_nama as a1 from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d where a.idossier_upd_id=b.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id = c.isediaan_id and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  disabled="TRUE" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}

function updateBox_perencanaan_komparator_vteam($field, $id, $value, $rowData) {
$sql = 'select e.vteam as a1 from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e where a.idossier_upd_id=b.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id = c.isediaan_id and e.iteam_id = b.iTeam_andev and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  disabled="TRUE" id="'.$id.'" value="'.$data_kom['a1'].'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}

function updateBox_perencanaan_komparator_vProduk_komparator($field, $id, $value, $rowData) {
$sql = 'select f.vName as a1, b.cNip_pengusul as b1 from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e, hrd.employee as f where a.idossier_upd_id=b.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id = c.isediaan_id and e.iteam_id = b.iTeam_andev and f.cNip = b.cNip_pengusul and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['b1'].' - '.$data_kom['a1'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  disabled="TRUE" id="'.$id.'" value="'.$data_kom['b1'].' - '.$data_kom['a1'].'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}

function updateBox_perencanaan_komparator_dupdate($field, $id, $value, $rowData) {
		$skg=date('Y-m-d');
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = $value;
			$return .= '<input type="hidden" name="'.$field.'"  disabled="TRUE" id="'.$id.'" value="'.$skg.'" class="input_rows1 required" size="8" />';
		}
		
		return $return;
}

function updateBox_perencanaan_komparator_cUpdate($field, $id, $value, $rowData) {
		$skg=date('Y-m-d');
		$cNip = $this->user->gNIP;
		$emp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$cNip))->row_array();
		$vName = $this->user->gName;
		if ($this->input->get('action') == 'view') {
			$return= $emp['vName'];

		}
		else{
			$return = $emp['vName'];
			$return .= '<input type="hidden" name="'.$field.'"  disabled="TRUE" id="'.$id.'" value="'.$cNip.'" class="input_rows1 required" size="8" />';
		}
		
		return $return;
}

function updateBox_perencanaan_komparator_iApprove_bdirm($field, $id, $value, $rowData) {

		if ($rowData['iApprove_bdirm']<> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cApprove_bdirm']))->row_array();

			if ($rowData['iApprove_bdirm'] == 2) {
				$palue='Approved by '.$rows['vName'].', Remark :'.$rowData['vRemark_bdirm'] ;	
			}else{
				$palue='Rejected by '.$rows['vName'].', Remark :'.$rowData['vRemark_bdirm'];	
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

function updateBox_perencanaan_komparator_iApprove_direksi($field, $id, $value, $rowData) {
		if ($rowData['iApprove_direksi']<> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cApprove_direksi']))->row_array();

			if ($rowData['iApprove_direksi'] == 2) {
				$palue='Approved by '.$rows['vName'].', Remark :'.$rowData['vRemark_direksi'] ;	
			}else{
				$palue='Rejected by '.$rows['vName'].', Remark :'.$rowData['vRemark_direksi'];	
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

function updateBox_perencanaan_komparator_vFileKom($field, $id, $value, $rowData) {

		//return print_r($rowData);
	 	$idossier_komparator_id=$rowData['idossier_komparator_id'];
		$data['rows'] = $this->db_plc0->get_where('dossier.dossier_komparator_detail', array('idossier_komparator_id'=>$idossier_komparator_id, 'iDelete'=>0))->result_array();
		return $this->load->view('perencanaan_komparator_file',$data,TRUE);
	}

function updateBox_perencanaan_komparator_iHarga($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;
	}
	else{
		$return = '<input type="number" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}
function updateBox_perencanaan_komparator_dTgl_expired($field, $id, $value, $rowData) {
	$dt=strtotime($value);
	$palue=date('d-m-Y',$dt);
	if ($this->input->get('action') == 'view') {
		$return= $palue;
	}
	else{
		if ($value==""){
			$palue="";
		}
		$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$palue.'" class="input_rows1 datepicker required" size="25" />';
		$return .=	'<script>
					$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
				</script>';
	}
	return $return;
	
}

function updateBox_perencanaan_komparator_iJumlah_sample($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;
	}
	else{
		$return = '<input type="number" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" />';
		$return .='<script>
				function forceNumeric(){
				    var $input = $(this);
				    $input.val($input.val().replace(/[^\d]+/g,""));
				}
				$("body").on("propertychange input", "input[type=\'number\']", forceNumeric);
				</script>';
	}
	return $return;
	
}
function updateBox_perencanaan_komparator_vNo_Batch($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;
	}
	else{
		$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" />';
	}
	return $return;
	
}

function updateBox_perencanaan_komparator_dApprove_bdirm($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		if ($value==''){
			$return="Waiting Approval";
		}
		else{
			$return = $value;
		}
	}
	else{
		if ($value==''){
			$return="Waiting Approval";
		}
		else{
			$return = $value;
		}
	}
	return $return;
	
}

function updateBox_perencanaan_komparator_dApprove_direksi($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		if ($value==''){
			$return="Waiting Approval";
		}
		else{
			$return = $value;
		}
	}
	else{
		if ($value==''){
			$return="Waiting Approval";
		}
		else{
			$return = $value;
		}	
	}
	return $return;
	
}

function updateBox_perencanaan_komparator_dreq_komparator($field, $id, $value, $rowData) {
	if($this->input->get('action')=='view'){
		$return	=date('d-m-Y',strtotime($value));
	}else{
	$return = '<input name="'.$id.'" id="'.$id.'" type="text" class="input_tgl datepicker required" style="width:158px" disabled="TRUE" value='.date('d-m-Y',strtotime($value)).' />';
	$return .=	'<script>
					$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
				</script>';
	}
	return $return;
}
/*manipulasi view object form end*/

/*manipulasi proses object form start*/

    
   
/*manipulasi proses object form end*/    

/*function pendukung start*/  
function before_update_processor($row, $postData) {
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	$postData['dApprove_bdirm']=NULL;
	$postData['dApprove_direksi']=NULL;
	//return $postData;

	// ubah status submit
	
	if($postData['isdraft']==true){
		$postData['iDok_Submit_Beli']=0;
	} 
	else{$postData['iDok_Submit_Beli']=1;} 

	$dt=strtotime($postData['dTgl_expired']);
	$postData['dTgl_expired']=date('Y-m-d',$dt);
	unset ($postData['idossier_upd_id']);
	unset ($postData['dreq_komparator']);
	unset ($postData['iApprove_bdirm']);
	unset ($postData['iApprove_direksi']);
	unset ($postData['updateBox_perencanaan_komparator_idossier_upd_id']);
	unset ($postData['dApprove_direksi']);
	unset ($postData['dApprove_bdirm']);
	//print_r($postData);exit();
	return $postData;

}

function after_update_processor($row, $insertId, $postData){
		$submit=$postData['iDok_Submit_Beli'];
		if ($submit == 1) {
			$qupd="select a.iHarga as harga, a.dTgl_expired as tglExpired, a.iJumlah_sample as sample, a.vNo_Batch as batch, d.iteam_id as item,a.iDok_Submit as submit, a.vNo_req_komparator as no_komparator, b.vUpd_no as no_upd, b.vNama_usulan as nama_usulan, b.cNip_pengusul as nip, c.vName as name from dossier.dossier_komparator as a
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
			
			$toEmail="supri@novellpharm.com";
			//$toEmail2="mansur@novellpharm.com";
			//$toEmail3="farhah.syafina@novellpharm.com";
			//$to = $toEmail2.';'.$toEmail;
			//$cc = $arrEmail;                        

				$to = $arrEmail;
				$cc = $toEmail21;                       

				$subject="Perencanaan Pembelian Komparator: <".$rupd['no_komparator'].">";
				$content="Diberitahukan bahwa telah ada Perencanaan Pembelian Komparator yang dialokasikan pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
								<td><b>Harga</b></td><td> : </td><td>".$rupd['harga']."</td>
							</tr>
							<tr>
								<td><b>Tanggal Expired</b></td><td> : </td><td>".$rupd['tglExpired']."</td>
							</tr>
							<tr>
								<td><b>Jumlah Sample</b></td><td> : </td><td>".$rupd['sample']."</td>
							</tr>
							<tr>
								<td><b>No Batch</b></td><td> : </td><td>".$rupd['batch']."</td>
							</tr>
						</table><br />
					</div><br/>
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}
}


function manipulate_update_button($buttons, $rowData) {
	$cNip= $this->user->gNIP;

	$js = $this->load->view('perencanaan_komparator_js');

	$update = '<button onclick="javascript:update_btn_back(\'perencanaan_komparator\', \''.base_url().'processor/plc/perencanaan/komparator?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_perencanaan_komparator">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'perencanaan_komparator\', \''.base_url().'processor/plc/perencanaan/komparator?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_perencanaan_komparator">Update as Draft</button>';

	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/perencanaan/komparator?action=approve&idossier_komparator_id='.$rowData['idossier_komparator_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_perencanaan_komparator">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/perencanaan/komparator?action=reject&idossier_komparator_id='.$rowData['idossier_komparator_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_perencanaan_komparator">Reject</button>';


	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if ($rowData['iDok_Submit_Beli']== 0) {
			// jika masih draft , show button update draft & update submit 
			$buttons['update'] = $update.$updatedraft.$js;
		}else{
			if($this->auth->is_bdirm()){
					$buttons['update'] = $approve.$reject.$js;
				}
			else if($this->auth->is_dir()){
				if($rowData['iApprove_bdirm']<>0){
					$buttons['update'] = $approve.$reject.$js;
				}
				else{
					unset($buttons['update_btn_back']);
					unset($buttons['update_draft_btn']);
					unset($buttons['update']);					
				}
			}
			else{
					unset($buttons['update_btn_back']);
					unset($buttons['update_draft_btn']);
					unset($buttons['update']);
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
								var url = "'.base_url().'processor/plc/perencanaan/komparator";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id, function(data) {
										 $("div#form_perencanaan_komparator").html(data);
									});
									
								}
									reload_grid("grid_perencanaan_komparator");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_perencanaan_komparator_approve" action="'.base_url().'processor/plc/perencanaan/komparator?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_komparator_id" value="'.$this->input->get('idossier_komparator_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_perencanaan_komparator_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_komparator_id = $post['idossier_komparator_id'];
		$vRemark = $post['vRemark'];
		if($this->auth->is_bdirm()){
			$dApprove_bdirm=date('Y-m-d H:i:s');
			$data=array('iApprove_bdirm'=>'2','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>$dApprove_bdirm, 'vRemark_bdirm'=>$vRemark);
			$this -> db -> where('idossier_komparator_id', $idossier_komparator_id);
			$updet = $this -> db -> update('dossier.dossier_komparator', $data);
		}
		elseif($this->auth->is_dir()){
			$q="select * from dossier.dossier_komparator where idossier_komparator_id='".$idossier_komparator_id."'";
			$dat=$this->db_plc0->query($q)->row_array();
			if($dat['iApprove_bdirm']==2){
				$dApprove_direksi=date('Y-m-d H:i:s');
				$data=array('iApprove_direksi'=>'2','cApprove_direksi'=>$cNip , 'dApprove_direksi'=>$dApprove_direksi, 'vRemark_direksi'=>$vRemark);
				$this -> db -> where('idossier_komparator_id', $idossier_komparator_id);
				$updet = $this -> db -> update('dossier.dossier_komparator', $data);
			}
		}

		//Kirim Email
			$qupd="select d.iteam_id as item,a.iDok_Submit as submit,a.vNo_req_komparator as no_komparator, b.vUpd_no as no_upd, b.vNama_usulan as nama_usulan, b.cNip_pengusul as nip, c.vName as name from dossier.dossier_komparator as a
			join dossier.dossier_upd as b on a.idossier_upd_id=b.idossier_upd_id
			join hrd.employee as c on b.cNip_pengusul=c.cNip
			join plc2.plc2_upb_team as d on b.iTeam_andev=d.iteam_id
			where a.idossier_komparator_id='".$idossier_komparator_id."'";
			$rupd = $this->db_plc0->query($qupd)->row_array();

			$query1=mysql_query("select d.iteam_id as item_id, d.vnip as nip, b.iDok_Submit as submit, b.vNo_req_komparator as no_komparator, c.vUpd_no as no_upd, c.vNama_usulan as nama_usulan, c.cNip_pengusul as nip, e.vName as name from dossier.dossier_komparator as b 
								join dossier.dossier_upd as c on b.idossier_upd_id=c.idossier_upd_id 
								join plc2.plc2_upb_team as d on c.iTeam_andev = d.iteam_id 
								join plc2.plc2_upb_team_item as a on a.iteam_id=d.iteam_id
								join hrd.employee as e on c.cNip_pengusul=e.cNip 
								where b.idossier_komparator_id='".$idossier_komparator_id."' and d.ldeleted=0 and d.vtipe = 'AD' 
								group by d.vnip
								order by d.vnip ASC
								");
			$datbd=array();
			$i=0;
			while($datbdi=mysql_fetch_array($query1)){
				$datbd[$i] = $datbdi['item_id'];
				$i++;
			}
			$andev=implode(',',$datbd);

			$query2=mysql_query("select a.iteam_id as iteam_id  from plc2.plc2_upb_team as a
					where a.ldeleted=0 and a.vtipe in ('BDIRM','DR')");
			$datdir=array();
			$i=0;
			while($datdi=mysql_fetch_array($query2)){
				$datdir[$i] = $datdi['iteam_id'];
				$i++;
			}
			$datdireksi=implode(',',$datdir);

			if ($andev == 74) {
				$iTeamandev = 'Andev 1';
			}else{
				$iTeamandev = 'Andev 2';
			}
			$team=$andev.','.$datdireksi;
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
			
			//$toEmail="Supri@novellpharm.com";
			//$toEmail2="mansur@novellpharm.com";
			//$toEmail3="farhah.syafina@novellpharm.com";
			//$to = $toEmail2.';'.$toEmail;
			//$cc = $arrEmail;                        

				$to = $arrEmail;
				$cc = $toEmail20.";".$toEmail21;                       

				$subject="Perencanaan Komparator: <".$rupd['no_komparator'].">";
				$content="Diberitahukan bahwa telah ada Perencanaan komparator yang dialokasikan pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
						</table><br />
					</div><br/>
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);


		$data['status']  = true;
		$data['last_id'] = $post['idossier_komparator_id'];
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_perencanaan_komparator_vRemark").val();
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
								var url = "'.base_url().'processor/plc/perencanaan/komparator";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id, function(data) {
										 $("div#form_perencanaan_komparator").html(data);
									});
									
								}
									reload_grid("grid_perencanaan_komparator");
							}
					 	 	
					 	 })
					
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_perencanaan_komparator_reject" action="'.base_url().'processor/plc/perencanaan/komparator?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_komparator_id" value="'.$this->input->get('idossier_komparator_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="reject_perencanaan_komparator_vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_perencanaan_komparator_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	
	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_komparator_id = $post['idossier_komparator_id'];
		$vRemark = $post['vRemark'];
		
		if($this->auth->is_dir()){
			$dApprove_direksi=date('Y-m-d H:i:s');
			$data=array('iApprove_direksi'=>'1','cApprove_direksi'=>$cNip , 'dApprove_direksi'=>$dApprove_direksi, 'vRemark_direksi'=>$vRemark);
			$this -> db -> where('idossier_komparator_id', $idossier_komparator_id);
			$updet = $this -> db -> update('dossier.dossier_komparator', $data);

		}
		elseif($this->auth->is_bdirm()){
			$dApprove_bdirm=date('Y-m-d H:i:s');
			$data=array('iApprove_bdirm'=>'1','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>$dApprove_bdirm, 'vRemark_bdirm'=>$vRemark);
			$this -> db -> where('idossier_komparator_id', $idossier_komparator_id);
			$updet = $this -> db -> update('dossier.dossier_komparator', $data);
		}

		$data['status']  = true;
		$data['last_id'] = $post['idossier_komparator_id'];
		return json_encode($data);
	}



	
/*function pendukung end*/    	


	public function output(){
		$this->index($this->input->get('action'));
	}

}
