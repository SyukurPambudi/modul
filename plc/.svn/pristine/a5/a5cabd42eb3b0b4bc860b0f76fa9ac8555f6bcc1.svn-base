<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dossier_request_sample_fg extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('plc', true);
		$this->dbset1 = $this->load->database('dosier', true);		
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Request Sample FG');
		//dc.m_vendor  database.tabel
		$grid->setTable('plc2.hstblfg');		
		$grid->setUrl('dossier_request_sample_fg');
		$grid->addList('C_NOMER','cusmas01.C_CUNAM','D_DATENT','C_USERID','C_STATUS');
		//,'cusmas01.C_CUNAM','D_DATENT','C_REMARK','C_STATUS','C_CONFIRM');
		
		$grid->setSortBy('hstblfg.C_NOMER');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('C_NOMER','C_CUNAM','D_DATENT','C_USERID','C_STATUS','detail_fg');

		//setting widht grid
		
		$grid->setWidth('C_NOMER','100'); 
		$grid->setWidth('cusmas01.C_CUNAM','300'); 
		$grid->setWidth('C_STATUS','100'); 
		$grid->setWidth('D_DATENT','100'); 
		$grid->setWidth('C_USERID','150'); 
		$grid->setWidth('C_CONFIRM','100'); 
	
		//modif label
		$grid->setLabel('C_NOMER','No Request'); 
		$grid->setLabel('cusmas01.C_CUNAM','Nama Customer'); 
		$grid->setLabel('C_STATUS','Status'); 
		$grid->setLabel('D_DATENT','Tgl Request'); 
		$grid->setLabel('C_USERID','Requestor'); 
		$grid->setLabel('C_CONFIRM','Confirm by'); 
		

	
		$grid->setFormUpload(TRUE);
		$grid->setSearch('C_NOMER','cusmas01.C_CUNAM');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		//$grid->changeFieldType('C_STATUS','combobox','',array(''=>'Need Confirm','C'=>'Confirmed'));
	
		$grid->setJoinTable('plc2.cusmas01', 'cusmas01.C_CUSNO = hstblfg.C_CUSNO', 'left');		
		$grid->setQuery('( C_STATUS is NULL or C_STATUS = "C") ', NULL);
		

		
		
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

 
function searchBox_dossier_request_sample_fg_C_STATUS($rowData, $id) {
		$o='<select id="upb_daftar_vkat_originator" class=" combobox" name="upb_daftar_vkat_originator">
				<option value="">--Select--</option>
				<option value="Confirmed">Confirmed</option>
				<option value="Need Confirmation">Need Confirmation</option>
			</select>';
		return $o;
}  


function listBox_dossier_request_sample_fg_C_STATUS($value, $pk, $name, $rowData) {
	$rows = $this->db_plc0->get_where('plc2.hstblfg', array('C_NOMER'=>$pk))->row_array();
	$prod = $rows['D_DCONFPRD'];
	$ppic = $rows['D_DCONPPIC'];



	if ( ($value == "C")  or ( $prod<>"") or ($ppic<>"") ) {
		$setatus = 'Confirmed';
	}else{
		$setatus = 'Need Confirmation';
	}
	
	return $setatus;
	
}


/*manipulasi view object form start*/

function updateBox_dossier_request_sample_fg_C_CUNAM($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.cusmas01', array('C_CUSNO'=>$rowData['C_CUSNO']))->row_array();
			if (empty($rows)) {
				$itemname='-';
			}else{
				$itemname = $rows['C_CUNAM'];
			}

		$return= $itemname;

		
		return $return;
}

function updateBox_dossier_request_sample_fg_C_STATUS($field, $id, $value, $rowData) {
	$prod = $rowData['D_DCONFPRD'];
	$ppic = $rowData['D_DCONPPIC'];



	if ( ($value == "C")  or ( $prod<>"") or ($ppic<>"") ) {
		$setatus = 'Confirmed';
	}else{
		$setatus = 'Need Confirmation';
	}
	
	return $setatus; 
	
}


function updateBox_dossier_request_sample_fg_detail_fg($field, $id, $value, $rowData) {
		$sql_doc='	select b.C_ITENO,b.C_NAMA,b.C_PANUMB,b.C_NOBATCH,b.C_LOT,b.N_QTYSMPL
					from plc2.hstblfg a
					join plc2.stabilfg b on b.C_NOMER=a.C_NOMER 
					where a.C_NOMER ="'.$rowData['C_NOMER'].'"
					';
		
		$data['rows'] = $this->db_plc0->query($sql_doc)->result_array();
		$return=  $this->load->view('dossier_request_sample_detail_fg',$data,TRUE);
		
		return $return;
		
}

function manipulate_update_button($buttons, $rowData) {
	if ($this->input->get('action') == 'view') {unset($buttons['update']);}

	else{
		unset($buttons['update_back']);
		unset($buttons['update']);
	}
	

	return $buttons;


}	



/*function pendukung start*/  

/*function pendukung end*/    	

	

	public function output(){
		$this->index($this->input->get('action'));
	}

}

