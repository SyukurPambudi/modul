<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class download_dokumen_sas_export extends MX_Controller {
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
		$grid->setTitle('Download Dokumen SAS');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_dok_sas');		
		$grid->setUrl('download_dokumen_sas_export');
		$grid->addList('vNo_req_sas','dossier_komparator.vNo_req_komparator','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','iFiledownload_submit','employee.vName','dApproval_sas');
		$grid->setSortBy('vNo_req_sas');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vNo_req_sas','idossier_komparator_id','vUpd_no','vNama_Bahan','dosis','vSediaan','vUpb_Ref','vEksisting','team_andev','vProduk_komparator','harga','Tgl_Expired','jml_sample_tersedia','no_batch_id','dApproval_sas','cApproval_sas','vFileSas','dKirim_ke_bde');

		//setting widht grid
		$grid->setWidth('vSupplierName', '200'); 
		$grid->setWidth('vTags', '230'); 
		$grid->setWidth('dCreated', '100'); 
		$grid->setWidth('vNote', '220'); 
		$grid->setWidth('cCreatedBy', '220'); 
		$grid->setWidth('iStatus', '100'); 

		
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
		$grid->setWidth('iFiledownload_submit', '200'); 
		$grid->setWidth('employee.vName', '150'); 
		$grid->setWidth('jml_sample_tersedia', '100'); 
		$grid->setWidth('dossier_komparator.vNo_req_komparator', '60'); 
		$grid->setWidth('dApproval_sas', '120'); 
		
		
		//modif label
		$grid->setLabel('vNo_req_sas','No Req SAS'); 
		$grid->setLabel('dossier_komparator.vNo_req_komparator','No Req Komparator'); 
		$grid->setLabel('idossier_komparator_id','No Req Komparator'); 
		$grid->setLabel('employee.vName','Approve SAS'); 
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
		$grid->setLabel('iFiledownload_submit', 'Status '); 
		$grid->setLabel('jml_sample_tersedia', 'Jml Sample Tersedia'); 
		$grid->setLabel('cApproval_sas', 'Approve By'); 
		$grid->setLabel('vFileSas','File Dokumen SAS');
		$grid->setLabel('dKirim_ke_bde','Tanggal Kirim Ke BDE Import');
		
		$grid->setFormUpload(TRUE);

		$grid->setSearch('vNo_req_sas','dossier_komparator.vNo_req_komparator','dossier_upd.vUpd_no','iFiledownload_submit');
		
		$grid->setRequired('dKirim_ke_bde');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		//$grid->changeFieldType('iApprove_sas','combobox','',array(''=> 'Pilih',0=>'Waiting Approval',1=>'Reject',2=>'Approve'));
		$grid->changeFieldType('iFiledownload_submit','combobox','',array(''=>'Pilih Semua',0=>'Draft - Need to be Publish',1=>'Submited'));
	
		$grid->setQuery('iApprove_sas',2);
		$grid->setQuery('iFileupload_submit',1);

	//Join Table
		$grid->setJoinTable('dossier.dossier_komparator', 'dossier_komparator.idossier_komparator_id = dossier_dok_sas.idossier_komparator_id', 'inner');
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_komparator.idossier_upd_id', 'inner');
		$grid->setJoinTable('hrd.employee', 'employee.cNip = dossier_dok_sas.cApproval_sas', 'inner');
		
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_upd.lDeleted', 0);

		//Set View Gridnya (Default = grid)
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;
			case 'download':
				$i=$this->input->get('ipk');
				$data['ddown_sas_dok']=date('Y-m-d H:i:s');
				$this->dbset->where('idossier_file_dok_sas_id',$i);
				$this->dbset->update('dossier.dossier_file_dok_sas',$data);
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
			case 'employee_list':
				$this->employee_list();
				break;
			case 'cekdatedownload':
				$post=$this->input->post();
				$id=$post['download_dokumen_sas_export_idossier_dok_sas_id'];
				$sql='select * from dossier.dossier_file_dok_sas dok where dok.lDeleted=0 and dok.ddown_sas_dok is null and dok.idossier_dok_sas_id='.$id;
				$row=$this->dbset->query($sql)->num_rows();
				if($row>=1){
					$r['status'] = FALSE;
                    $r['message'] = "Ada File yang belum di download";
                    echo json_encode($r);
                    break;
				}else{
					$r['status'] = TRUE;
                    $r['message'] = "Success";
                    echo json_encode($r);
                    break;
				}
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

    /*Maniupulasi Gird Start*/

function listBox_Action($row, $actions){
	/*if($this->auth->is_manager()){
		$x=$this->auth->dept();
		$manager=$x['manager'];
		if(in_array('IR', $manager)){
			if($row->iFiledownload_submit<>0){
				unset($actions['edit']);
				unset($actions['delete']);
			}
		}
		else{
			unset($actions['edit']);
			unset($actions['delete']);
		}
	}else{
		$x=$this->auth->dept();
		$team=$x['team'];
		if(in_array('IR', $team)){
			if($row->iFiledownload_submit<>0){
				unset($actions['edit']);
				unset($actions['delete']);
			}
		}
		else{
			unset($actions['edit']);
			unset($actions['delete']);
		}
	}*/
	 if($row->iFiledownload_submit<>0){
	    	unset($actions['edit']);
	    	unset($actions['delete']);
	    }
	return $actions;
}

/*function listBox_Action($row, $actions) {
	$q=mysql_query("select count(b.iteam_id) as jml from plc2.plc2_upb_team_item as a
		join plc2.plc2_upb_team as b on a.iteam_id=b.iteam_id
		where a.vnip='".$this->user->gNIP."' and b.vtipe='IR'");	
		$team=mysql_fetch_array($q);
	$q1=mysql_query("select count(a.iteam_id) as jml1 from plc2.plc2_upb_team as a
		where a.vnip='".$this->user->gNIP."' and a.vtipe='IR'");	
		$manager=mysql_fetch_array($q1);
		if($team['jml']==1){
			if ($row->iFiledownload_submit<>0) {
	 		 unset($actions['edit']);
	 		}
		}
		else if ($manager['jml1']==1){
			if ($row->iFiledownload_submit<>0) {
	 		 unset($actions['edit']);
	 		}
		}
		else{
			unset($actions['edit']);
		}
		return $actions;
} 
   
/*Maniupulasi Gird end*/

/*manipulasi view object form start*/
 	
/*manipulasi view object form end*/

/*manipulasi proses object form start*/

   
/*manipulasi proses object form end*/    
function updateBox_download_dokumen_sas_export_vNo_req_sas($field, $id, $value, $rowData) {
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

function updateBox_download_dokumen_sas_export_idossier_komparator_id($field, $id, $value, $rowData) {
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
		//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/komparator/export?field=dokumen_sas\',\'List Komparator\')" type="button">&nbsp;</button>';                
		            
	}
	return $return; 
	
}	

function updateBox_download_dokumen_sas_export_vUpd_no($field, $id, $value, $rowData) {
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

function updateBox_download_dokumen_sas_export_vNama_Bahan($field, $id, $value, $rowData) {
$sql = 'select b.vNama_usulan as a from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}	

function updateBox_download_dokumen_sas_export_dosis($field, $id, $value, $rowData) {
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

function updateBox_download_dokumen_sas_export_vSediaan($field, $id, $value, $rowData) {
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

function updateBox_download_dokumen_sas_export_vUpb_Ref($field, $id, $value, $rowData) {
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


function updateBox_download_dokumen_sas_export_vEksisting($field, $id, $value, $rowData) {
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

function updateBox_download_dokumen_sas_export_team_andev($field, $id, $value, $rowData) {
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

function updateBox_download_dokumen_sas_export_vProduk_komparator($field, $id, $value, $rowData) {
$sql = 'select b.cNip_pengusul as a, b.vNama_usulan as b from dossier.dossier_komparator as a, dossier.dossier_upd as b, plc2.plc2_upb as c, hrd.mnf_sediaan as d, plc2.plc2_upb_team as e  where idossier_komparator_id="'.$rowData["idossier_komparator_id"].'" and b.idossier_upd_id = a.idossier_upd_id and c.iupb_id = b.iupb_id and d.isediaan_id=c.isediaan_id and e.iteam_id = b.iTeam_andev';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a'];
	}
	else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_kom['a'].' - '.$data_kom['b'].'" class="input_rows1" size="25" />';
	}
	return $return;
	
}

function updateBox_download_dokumen_sas_export_Tgl_Expired($field, $id, $value, $rowData) {
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

function updateBox_download_dokumen_sas_export_harga($field, $id, $value, $rowData) {
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

function updateBox_download_dokumen_sas_export_no_batch_id($field, $id, $value, $rowData) {
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

function updateBox_download_dokumen_sas_export_jml_sample_tersedia($field, $id, $value, $rowData) {
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

function updateBox_download_dokumen_sas_export_dApproval_sas($field, $id, $value, $rowData) {
		$return= $rowData['dApproval_sas'];
		$return .='<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" />';
		return $return;
}

function updateBox_download_dokumen_sas_export_cApproval_sas($field, $id, $value, $rowData) {
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


function updateBox_download_dokumen_sas_export_vFileSas($field, $id, $value, $rowData) {

		//return print_r($rowData);
	 	$idossier_dok_sas_id=$rowData['idossier_dok_sas_id'];
		$data['rows'] = $this->db_plc0->get_where('dossier.dossier_file_dok_sas', array('idossier_dok_sas_id'=>$idossier_dok_sas_id,'lDeleted'=>0))->result_array();
		return $this->load->view('download_dokumen_sas_export_file',$data,TRUE);
	}
function updateBox_download_dokumen_sas_export_dKirim_ke_bde($field, $id, $value, $rowData) {
		$dt=strtotime($rowData['dKirim_ke_bde']);
		$palue=date('d-m-Y',$dt);
		if ($this->input->get('action') == 'view') {
			$return= $palue;
		}
		else{
			if ($rowData['dKirim_ke_bde']==""){
				$palue="";
			}
			$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$palue.'" class="input_rows1 datepicker required" size="25" />';
			$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
					</script>';
		}
		return $return;
}




/*function pendukung start*/    
function before_update_processor($row, $postData) {
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	$dt=strtotime($postData['dKirim_ke_bde']);
	$postData['dKirim_ke_bde']=date('Y-m-d',$dt);
	//return $postData;
	// ubah status submit
	if($postData['isdraft']==true){
		$postData['iFiledownload_submit']=0;
	} 
	else{$postData['iFiledownload_submit']=1;} 

	return $postData;

}

function manipulate_update_button($buttons, $rowData) {
	$cNip= $this->user->gNIP;

	$js = $this->load->view('download_dokumen_sas_export_js');

	$update = '<button onclick="javascript:update_btn_back(\'download_dokumen_sas_export\', \''.base_url().'processor/plc/download/dokumen/sas/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_download_dokumen_sas_export">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'download_dokumen_sas_export\', \''.base_url().'processor/plc/download/dokumen/sas/export?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_download_dokumen_sas_export">Update as Draft</button>';

	
	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
	else{
		unset($buttons['update_back']);
		unset($buttons['update']);
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('IR', $manager)){
				$type='IR';
				if ($rowData['iFiledownload_submit']== 0) {
					$buttons['update'] = $update.$updatedraft.$js;
				}else{}
			}else{
				$type='';
			}
		}else{

			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('IR', $team)){
				$type='IR';
				if ($rowData['iFiledownload_submit']== 0) {
					$buttons['update'] = $update.$updatedraft.$js;
				}else{}
			}else{
				$type='';
			}
		}
	}
	return $buttons;
}




	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		//print_r($_GET);
		//exit;
		//$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/dok_sas/'.$id.'/'.$name);	
		force_download($name, $path);
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
