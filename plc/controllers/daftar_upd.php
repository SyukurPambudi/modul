<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Daftar_upd extends MX_Controller {
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
		$grid->setTitle('Daftar UPD');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_upd');		
		$grid->setUrl('daftar_upd');
		$grid->addList('vUpd_no','vNama_usulan','employee.vName','plc2_upb.vupb_nomor','iSubmit_upd','iApprove_upd');
		$grid->setSortBy('vUpd_no');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vUpd_no','dTanggal_upd','vNama_usulan','cNip_pengusul','nama_pengusul','iupb_id'
							,'kekuatan','nama_generik','sediaan_produk','dApproval_upd','cApproval_direksi');

		//setting widht grid
		$grid ->setWidth('vUpd_no', '100'); 
		$grid->setWidth('lDeleted', '100'); 
		
		
		//modif label
		$grid->setLabel('vUpd_no','No UPD'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 
		$grid->setLabel('cNip_pengusul','NIP Pengusul'); 
		$grid->setLabel('iupb_id','No UPB'); 
		$grid->setLabel('iApprove_upd','Status Approval'); 
		$grid->setLabel('iSubmit_upd','Status UPD '); 
		$grid->setLabel('dTanggal_upd','Tanggal UPD'); 
		$grid->setLabel('dApproval_upd','Tanggal Approve'); 
		$grid->setLabel('cApproval_direksi','Approve by'); 
		$grid->setLabel('employee.vName','Nama Pengusul');
		$grid->setLabel('plc2_upb.vupb_nomor','No UPB'); 

		$grid->setFormUpload(TRUE);

		$grid->setSearch('vUpd_no','vNama_usulan','employee.vName','plc2_upb.vupb_nomor','iApprove_upd');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		//$grid->changeFieldType('istatus','combobox','',array(''=>'Pilih','C'=>'Kontrak','A'=>'Tetap'));
		$grid->changeFieldType('lDeleted','combobox','',array(''=>'Pilih',0=>'Aktif',1=>'Tidak aktif'));
		$grid->changeFieldType('iSubmit_upd','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submited - Waiting Approval'));
		$grid->changeFieldType('iApprove_upd','combobox','',array(''=> 'Pilih',0=>'Waiting Approval',1=>'Reject',2=>'Approve'));
		

	//Field mandatori
		$grid->setRequired('vUpd_no');	
		$grid->setRequired('vNama_usulan');	
		$grid->setRequired('lDeleted');	

		
		$grid->setJoinTable('hrd.employee', 'employee.cNip = dossier_upd.cNip_pengusul', 'inner');
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = dossier_upd.iupb_id', 'inner');
		$grid->setQuery('dossier_upd.lDeleted', 0);
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

	 	if ($row->iApprove_upd<>0) {
	 		// status sudah diapprove or reject , button edit hide 
	 		 unset($actions['edit']);
	 		 unset($actions['delete']);
	 	}
		 return $actions;

	 } 

/*manipulasi view object form start*/

function insertBox_daftar_upd_vUpd_no($field, $id) {
	$return = 'Auto generate';
	return $return;
}

function updateBox_daftar_upd_vUpd_no($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
		}
		
		return $return;
}





function insertBox_daftar_upd_dTanggal_upd($field, $id) {
	$skg=date('Y-m-d');
	$cNip = $this->user->gNIP;
	$vName = $this->user->gName;
	$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$skg.'" class="input_rows1" size="8" />';
	$return .= $skg;
	return $return;
}

function updateBox_daftar_upd_dTanggal_upd($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
		}
		
		return $return;
}



function insertBox_daftar_upd_vNama_usulan($field, $id) {
		$return = '
		<input type="hidden" name="isdraft" id="isdraft">
		<input type="text" name="'.$field.'"   id="'.$id.'" value="" class="required input_rows1" size="25" />';
		return $return;
}


function updateBox_daftar_upd_vNama_usulan($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '
			<input type="hidden" name="isdraft" id="isdraft">
			<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" />';
		}
		
		return $return;
}






function insertBox_daftar_upd_cNip_pengusul($field, $id) {
	$skg=date('Y-m-d');
	$cNip = $this->user->gNIP;
	$vName = $this->user->gName;
	$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$cNip.'" class="input_rows1" size="8" />';
	$return .= $cNip;
	return $return;
}

function updateBox_daftar_upd_cNip_pengusul($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
		}
		
		return $return;
}



function insertBox_daftar_upd_nama_pengusul($field, $id) {
	$skg=date('Y-m-d');
	$cNip = $this->user->gNIP;
	$vName = $this->user->gName;
	//$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$cNip.'" class="input_rows1" size="8" />';
	$return = $vName;
	return $return;
}

function updateBox_daftar_upd_nama_pengusul($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cNip_pengusul']))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vName'];

		}
		else{
			$return= $rows['vName'];
		}
		
		return $return;
}


function insertBox_daftar_upd_iupb_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="35" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc_export/browse/upb?field=daftar_upd\',\'List UPB\')" type="button">&nbsp;</button>';                
		
		return $return;
}

function updateBox_daftar_upd_iupb_id($field, $id, $value, $rowData) {
	$sql = 'select pu.iupb_id , pu.vupb_nomor, pu.vupb_nama from plc2.plc2_upb pu where pu.iupb_id ="'.$value.'" ';
	$data_upb = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_upb['vupb_nomor'].' - '.$data_upb['vupb_nama'];

	}else{

		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="35" value="'.$data_upb['vupb_nomor'].' - '.$data_upb['vupb_nama'].'"/>';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc_export/browse/upb?field=daftar_upd\',\'List UPB\')" type="button">&nbsp;</button>';                
	}
	
	return $return;
}


function insertBox_daftar_upd_kekuatan($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="25" />';
	return $return;
}

function updateBox_daftar_upd_kekuatan($field, $id, $value, $rowData) {
		$sql = 'select pu.iupb_id , pu.vupb_nomor, pu.vupb_nama,pu.dosis,pu.isediaan_id,pu.vgenerik ,ms.vsediaan
				from plc2.plc2_upb pu 
				join hrd.mnf_sediaan ms on ms.isediaan_id=pu.isediaan_id where pu.iupb_id ="'.$rowData['iupb_id'].'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['dosis'];

		}
		else{
			$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_upb['dosis'].'" class="input_rows1 required" size="25" />';
		}
		
		return $return;
}



function insertBox_daftar_upd_nama_generik($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="25" />';
	return $return;
}

function updateBox_daftar_upd_nama_generik($field, $id, $value, $rowData) {
		$sql = 'select pu.iupb_id , pu.vupb_nomor, pu.vupb_nama,pu.dosis,pu.isediaan_id,pu.vgenerik ,ms.vsediaan
				from plc2.plc2_upb pu 
				join hrd.mnf_sediaan ms on ms.isediaan_id=pu.isediaan_id where pu.iupb_id ="'.$rowData['iupb_id'].'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vgenerik'];

		}
		else{
			$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_upb['vgenerik'].'" class="input_rows1 required" size="25" />';
		}
		
		return $return;
}

function insertBox_daftar_upd_sediaan_produk($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="25" />';
	return $return;
}

function updateBox_daftar_upd_sediaan_produk($field, $id, $value, $rowData) {
		$sql = 'select pu.iupb_id , pu.vupb_nomor, pu.vupb_nama,pu.dosis,pu.isediaan_id,pu.vgenerik ,ms.vsediaan
				from plc2.plc2_upb pu 
				join hrd.mnf_sediaan ms on ms.isediaan_id=pu.isediaan_id where pu.iupb_id ="'.$rowData['iupb_id'].'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vsediaan'];

		}
		else{
			$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$data_upb['vsediaan'].'" class="input_rows1 required" size="25" />';
		}
		
		return $return;
}


function insertBox_daftar_upd_dApproval_upd($field, $id) {
	$return = '-';
	return $return;
}

function updateBox_daftar_upd_dApproval_upd($field, $id, $value, $rowData) {
		if ($rowData['iApprove_upd']<> 0 ) {
			$palue= $rowData['dApproval_upd'];
			
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



			

function insertBox_daftar_upd_cApproval_direksi($field, $id) {
	$return = '-';
	return $return;
}

function updateBox_daftar_upd_cApproval_direksi($field, $id, $value, $rowData) {
	
	

		if ($rowData['iApprove_upd']<> 0 ) {
			$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cApproval_direksi']))->row_array();

			if ($rowData['iApprove_upd'] == 2) {
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


/*function pendukung start*/  
function before_update_processor($row, $postData) {
	
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	$postData['cApproval_direksi'] = NULL;
	$postData['dApproval_upd'] = NULL;

	// ubah status submit
	if($postData['isdraft']==true){
		$postData['iSubmit_upd']=0;
	} 
	else{$postData['iSubmit_upd']=1;} 

	return $postData;

}
function before_insert_processor($row, $postData) {
	
	// insert iteam andev

	//end 
	$postData['cApproval_direksi'] = NULL;
	$postData['dApproval_upd'] = NULL;
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreated'] =$this->user->gNIP;

	// ubah status submit
		if($postData['isdraft']==true){
			$postData['iSubmit_upd']=0;
		} 
		else{$postData['iSubmit_upd']=1;} 

	return $postData;

}


function manipulate_update_button($buttons, $rowData) {
	$cNip= $this->user->gNIP;

	$js = $this->load->view('daftar_upd_js');

	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc_export/daftar/upd?action=approve&idossier_upd_id='.$rowData['idossier_upd_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_daftar_upd">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc_export/daftar/upd?action=reject&idossier_upd_id='.$rowData['idossier_upd_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_daftar_upd">Reject</button>';

	$update = '<button onclick="javascript:update_btn_back(\'daftar_upd\', \''.base_url().'processor/plc_export/daftar/upd?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upd">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'daftar_upd\', \''.base_url().'processor/plc_export/daftar/upd?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_daftar_upd">Update as Draft</button>';



	if ($this->input->get('action') == 'view') {unset($buttons['update']);}

	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if ($rowData['iSubmit_upd']== 0) {
			// jika masih draft , show button update draft & update submit 
			$buttons['update'] = $update.$updatedraft.$js;
		}else{
			// sudah disubmit , show button approval 
			$buttons['update'] = $approve.$reject.$js;
		}


		//$buttons['update'] = $update.$updatedraft.$approve.$reject.$js;
	}
	

	return $buttons;


}								
function manipulate_insert_button($buttons) {
	unset($buttons['save']);

	$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'daftar_upd\', \''.base_url().'processor/plc_export/daftar/upd?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_daftar_upd">Save as Draft</button>';
	$save = '<button onclick="javascript:save_btn_multiupload(\'daftar_upd\', \''.base_url().'processor/plc_export/daftar/upd?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Save &amp; Submit</button>';
	$js = $this->load->view('daftar_upd_js');
	$buttons['save'] = $save_draft.$save.$js;

	return $buttons;
}



function after_insert_processor($fields, $id, $post) {
		
		//update service_request autonumber No Brosur
		$nomor = "D".str_pad($id, 5, "0", STR_PAD_LEFT);
		$sql = "UPDATE dossier.dossier_upd SET vUpd_no = '".$nomor."' WHERE idossier_upd_id=$id LIMIT 1";
		$query = $this->db_plc0->query( $sql );
		
		
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
								var url = "'.base_url().'processor/plc_export/daftar/upd";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_daftar_upd").html(data);
										 $("#button_approve_daftar_upd").hide();
										 $("#button_reject_daftar_upd").hide();
									});
									
								}
									reload_grid("grid_daftar_upd");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_daftar_upd_approve" action="'.base_url().'processor/plc_export/daftar/upd?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_upd_id" value="'.$this->input->get('idossier_upd_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_daftar_upd_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_upd_id = $post['idossier_upd_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove_upd'=>'2','cApproval_direksi'=>$cNip , 'dApproval_upd'=>date('Y-m-d H:i:s'), 'vRemark'=>$vRemark);
		$this -> db -> where('idossier_upd_id', $idossier_upd_id);
		$updet = $this -> db -> update('dossier.dossier_upd', $data);


		$data['status']  = true;
		$data['last_id'] = $post['idossier_upd_id'];
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_daftar_upd_remark").val();
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
								var url = "'.base_url().'processor/plc_export/daftar/upd";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_daftar_upd").html(data);
										 $("#button_approve_daftar_upd").hide();
										 $("#button_reject_daftar_upd").hide();
									});
									
								}
									reload_grid("grid_daftar_upd");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_daftar_upd_reject" action="'.base_url().'processor/plc_export/daftar/upd?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_upd_id" value="'.$this->input->get('idossier_upd_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="reject_daftar_upd_remark"class="required" required="required"></textarea>
		<button type="button" onclick="submit_ajax(\'form_daftar_upd_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	
	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_upd_id = $post['idossier_upd_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove_upd'=>'1','cApproval_direksi'=>$cNip , 'dApproval_upd'=>date('Y-m-d H:i:s'), 'vRemark'=>$vRemark);
		$this -> db -> where('idossier_upd_id', $idossier_upd_id);
		$updet = $this -> db -> update('dossier.dossier_upd', $data);


		$data['status']  = true;
		$data['last_id'] = $post['idossier_upd_id'];
		return json_encode($data);
	}


	
/*function pendukung end*/    	

	
	




	

	
	

	public function output(){
		$this->index($this->input->get('action'));
	}

}

