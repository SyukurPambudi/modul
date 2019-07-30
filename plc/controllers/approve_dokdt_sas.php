<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class approve_dokdt_sas extends MX_Controller {
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
		$grid->setTitle('Dokumen Tambahan SAS');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_dok_td_sas');		
		$grid->setUrl('approve_dokdt_sas');
		$grid->addList('vNo_req_dok_td_sas','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','iApprove','dApprove');
		$grid->setSortBy('vNo_req_dok_td_sas');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vNo_req_dok_td_sas','idossier_dok_sas_id','vNama_bahan','dosis','vSediaan','vUpb_Ref','vEksisting','team_andev','vProduk_komparator','vUpd_no','vNo_req_komparator','dok_td');

		//setting widht grid
		$grid->setWidth('vNo_req_dok_td_sas', '100');
		$grid->setWidth('idossier_dok_sas_id', '150'); 
		$grid->setWidth('iApprove', '150');
		$grid->setWidth('dok_td', '100');
		$grid->setWidth('dApprove', '150');
		$grid->setWidth('vUpd_no', '150');
		$grid->setWidth('dossier_upd.vUpd_no', '150');
		$grid->setWidth('vNama_bahan', '200');
		$grid->setWidth('dossier_upd.vNama_usulan', '200');
		$grid->setWidth('dosis', '100'); 
		$grid->setWidth('vSediaan', '100'); 
		$grid->setWidth('vUpb_Ref', '100'); 
		$grid->setWidth('vEksisting', '100'); 
		$grid->setWidth('team_andev', '100'); 
		$grid->setWidth('vProduk_komparator', '100'); 
		$grid->setWidth('vNo_req_komparator', '60'); 
		
		
		//modif label
		$grid->setLabel('vNo_req_dok_td_sas','Nomor Permintaan TD');
		$grid->setLabel('idossier_dok_sas_id','No Req SAS');
		$grid->setLabel('iApprove','Status');
		$grid->setLabel('dok_td','Dokumen TD');
		$grid->setLabel('dApprove','Tanggal Approve');
		$grid->setLabel('vUpd_no','No Dossier');
		$grid->setLabel('dossier_upd.vUpd_no','No Dossier');
		$grid->setLabel('vNama_bahan','Nama Produk');
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Produk');
		$grid->setLabel('dosis','Kekuatan'); 
		$grid->setLabel('vSediaan', 'Sediaan'); 
		$grid->setLabel('vUpb_Ref', 'UPB Referensi'); 
		$grid->setLabel('vEksisting', 'Nama Eksisting'); 
		$grid->setLabel('team_andev', 'Team Andev'); 
		$grid->setLabel('vNo_req_komparator','No Req Komparator'); 
		$grid->setLabel('vProduk_komparator', 'Nama Produk Koparator'); 

		$grid->setFormUpload(TRUE);

		$grid->setSearch('vNo_req_dok_td_sas','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','iApprove');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		//$grid->changeFieldType('istatus','combobox','',array(''=>'Pilih','C'=>'Kontrak','A'=>'Tetap'));
		//$grid->changeFieldType('iApprove','combobox','',array(0=>'Waiting Approval',1=>'Approved'));
		$grid->changeFieldType('iApprove','combobox','',array(''=>'-Pilih Semua-',0=>'Waiting Approval',1=>'Approved'));
		//$grid->changeFieldType('iDok_sas','combobox','',array(''=>'Pilih',0=>'Tidak',1=>'Ya'));
		

	//Field mandatori
		$grid->setRequired('vNo_req_dok_td_sas');	
		$grid->setRequired('idossier_dok_sas_id');
		$grid->setRequired('dok_td');

		$grid->setQuery('dossier.dossier_dok_td_sas.iDok_Submit',1);
		//$grid->setQuery('asset.asset_sparepart.ldeleted', 0);
		//$grid->setQuery('lDeleted',0);
		//$grid->setMultiSelect(true);
		
		//join table
		$grid->setJoinTable('dossier.dossier_dok_sas', 'dossier_dok_sas.idossier_dok_sas_id = dossier_dok_td_sas.idossier_dok_sas_id', 'inner');
		$grid->setJoinTable('dossier.dossier_komparator', 'dossier_komparator.idossier_komparator_id = dossier_dok_sas.idossier_komparator_id', 'inner');
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_komparator.idossier_upd_id', 'inner');
		//$grid->setJoinTable('dossier.dossier_bahan_komparator', 'dossier_bahan_komparator.idossier_bahan_komparator_id = dossier_komparator.idossier_bahan_komparator_id', 'inner');
		//$grid->setJoinTable('hrd.employee', 'employee.cNip = dossier_dok_td_sas.cApproval', 'inner');

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

	$q1=mysql_query("select count(a.iteam_id) as jml1 from plc2.plc2_upb_team as a
		where a.vnip='".$this->user->gNIP."' and a.vtipe='IR'");	
		$manager=mysql_fetch_array($q1);
		if ($manager['jml1']==1){
			if ($row->iApprove<>0) {
		 		// status sudah diapprove or reject , button edit hide 
		 		 unset($actions['edit']);
		 	}
		}
		else{
			unset($actions['edit']);
		}

		 return $actions;

	 }   

function updateBox_approve_dokdt_sas_vNo_req_dok_td_sas($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return= $value;
		$return .= '<input type="hidden" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';

		
	}
	
	return $return;
}	

function updateBox_approve_dokdt_sas_idossier_dok_sas_id($field, $id, $value, $rowData) {
	$sql = 'select b.vNo_req_sas as a1, a.idossier_dok_sas_id as b1 from dossier_dok_td_sas as a, dossier_dok_sas as b where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'"';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{

		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';

		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$dtkm['b1'].'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" class="" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="25" value="'.$dtkm['a1'].'"/>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc_export/browse/doksas?field=approve_dokdt_sas\',\'List Komparator\')" type="button">&nbsp;</button>';                
		            
	}
	return $return; 
	
}


function updateBox_approve_dokdt_sas_dosis($field, $id, $value, $rowData) {
	$sql = 'select c.dosis as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}

function updateBox_approve_dokdt_sas_vSediaan($field, $id, $value, $rowData) {
	$sql = 'select f.vSediaan as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}


function updateBox_approve_dokdt_sas_vUpb_Ref($field, $id, $value, $rowData) {
	$sql = 'select c.vupb_nomor as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}


function updateBox_approve_dokdt_sas_vEksisting($field, $id, $value, $rowData) {
	$sql = 'select c.vupb_nama as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}


function updateBox_approve_dokdt_sas_team_andev($field, $id, $value, $rowData) {
	$sql = 'select g.vteam as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f, plc2.plc2_upb_team as g where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id and e.iTeam_andev=g.iteam_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}


function updateBox_approve_dokdt_sas_vProduk_komparator($field, $id, $value, $rowData) {
	$sql = 'select e.cNip_pengusul as a1, e.vNama_usulan as b1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f, plc2.plc2_upb_team as g where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id and e.iTeam_andev=g.iteam_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1']." - ".$dtkm['b1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].' - '.$dtkm['b1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}


function updateBox_approve_dokdt_sas_vNama_bahan($field, $id, $value, $rowData) {
	$sql = 'select e.vNama_usulan as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f, plc2.plc2_upb_team as g, dossier.dossier_bahan_komparator as h where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id and e.iTeam_andev=g.iteam_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}


function updateBox_approve_dokdt_sas_vUpd_no($field, $id, $value, $rowData) {
	$sql = 'select e.vUpd_no as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f, plc2.plc2_upb_team as g, dossier.dossier_bahan_komparator as h where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id and e.iTeam_andev=g.iteam_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}


function updateBox_approve_dokdt_sas_vNo_req_komparator($field, $id, $value, $rowData) {
	$sql = 'select d.vNo_req_komparator as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f, plc2.plc2_upb_team as g, dossier.dossier_bahan_komparator as h where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id and e.iTeam_andev=g.iteam_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}

function updateBox_approve_dokdt_sas_dok_td($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;
	}
	else{
		$return = '<textarea name="'.$field.'"  id="'.$id.'" class="input_rows1" readonly="readonly" size="25" row="2">'.$value.'</textarea>';
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
	$postData['dApprove'] = date('Y-m-d H:i:s');
	$postData['cApprove'] =$this->user->gNIP;
	//return $postData;
	// ubah status submit
	//if($postData['isdraft']==true){
		$postData['iApprove']=1;
	//} 
	//else{$postData['iApprove']=1;} 
	return $postData; 

}

function manipulate_update_button($buttons, $rowData) {
	$cNip= $this->user->gNIP;

	$js = $this->load->view('approve_dokdt_sas_js');

/*
	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc_export/dokumen/dt/sas?action=approve&idossier_dok_sas_id='.$rowData['idossier_dok_sas_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_approve_dokdt_sas">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc_export/dokumen/dt/sas?action=reject&idossier_dok_sas_id='.$rowData['idossier_dok_sas_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_approve_dokdt_sas">Reject</button>';
*/
	$update = '<button onclick="javascript:update_btn_back(\'approve_dokdt_sas\', \''.base_url().'processor/plc_export/approve/dokdt/sas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_approve_dokdt_sas">Approve</button>';
	//$updatedraft = '<button onclick="javascript:update_draft_btn(\'approve_dokdt_sas\', \''.base_url().'processor/plc_export/approve/dokdt/sas?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_approve_dokdt_sas">Update as Draft</button>';



	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if ($rowData['iApprove']== 0) {
			// jika masih draft , show button update draft & update submit 
			$buttons['update'] = $update.$js;
		}else{
			// sudah disubmit , show button approval 
			
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
								var url = "'.base_url().'processor/plc_export/dokumen/sas";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_approve_dokdt_sas").html(data);
									});
									
								}
									reload_grid("grid_approve_dokdt_sas");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_approve_dokdt_sas_approve" action="'.base_url().'processor/plc_export/dokumen/sas?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_dok_sas_id" value="'.$this->input->get('idossier_dok_sas_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_approve_dokdt_sas_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_dok_sas_id = $post['idossier_dok_sas_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove_sas'=>'2','cApproval_sas'=>$cNip , 'dApproval_sas'=>date('Y-m-d H:i:s'), 'vRemark'=>$vRemark);
		$this -> db -> where('idossier_dok_sas_id', $idossier_dok_sas_id);
		$updet = $this -> db -> update('dossier.dossier_dok_sas', $data);


		$data['status']  = true;
		$data['last_id'] = $post['idossier_dok_sas_id'];
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_approve_dokdt_sas_vRemark").val();
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
								var url = "'.base_url().'processor/plc_export/dokumen/sas";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_approve_dokdt_sas").html(data);
									});
									
								}
									reload_grid("grid_approve_dokdt_sas");
							}
					 	 	
					 	 })
					
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_dokumen_sas_reject" action="'.base_url().'processor/plc_export/dokumen/sas?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_dok_sas_id" value="'.$this->input->get('idossier_dok_sas_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="reject_dokumen_sas_vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_dokumen_sas_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	
	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_dok_sas_id = $post['idossier_dok_sas_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove_sas'=>'1','cApproval_sas'=>$cNip , 'dApproval_sas'=>date('Y-m-d H:i:s'), 'vRemark'=>$vRemark);
		$this -> db -> where('idossier_dok_sas_id', $idossier_dok_sas_id);
		$updet = $this -> db -> update('dossier.dossier_dok_sas', $data);


		$data['status']  = true;
		$data['last_id'] = $post['idossier_dok_sas_id'];
		return json_encode($data);
	}

*/
	
/*function pendukung end*/    	


	public function output(){
		$this->index($this->input->get('action'));
	}

}
