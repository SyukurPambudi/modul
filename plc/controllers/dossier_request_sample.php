<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dossier_request_sample extends MX_Controller {
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
		$grid->setTitle('Request Sample');
		//dc.m_vendor  database.tabel
		$grid->setTable('plc2.mr01');		
		$grid->setUrl('dossier_request_sample');
		$grid->addList('C_MRNO','itemas.C_ITNAM','D_MRDATE','C_REMARK','C_STATUS','C_CONFIRM');
		$grid->setSortBy('mr01.C_MRNO');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('C_MRNO','item_name','D_MRDATE','C_REMARK','C_STATUS','C_CONFIRM','detail_mr');

		//setting widht grid
		
		$grid->setWidth('C_MRNO','100'); 
		$grid->setWidth('itemas.C_ITNAM','250'); 
		$grid->setWidth('C_STATUS','100'); 
		$grid->setWidth('D_MRDATE','100'); 
		$grid->setWidth('C_REMARK','300'); 
		$grid->setWidth('C_CONFIRM','100'); 
	
		//modif label
		$grid->setLabel('C_MRNO','No MR'); 
		$grid->setLabel('itemas.C_ITNAM','Nama Produk'); 
		$grid->setLabel('C_STATUS','Status'); 
		$grid->setLabel('D_MRDATE','Tgl Request'); 
		$grid->setLabel('C_REMARK','Remark'); 
		$grid->setLabel('C_CONFIRM','Confirm by'); 
		

	
		$grid->setFormUpload(TRUE);
		$grid->setSearch('C_MRNO','itemas.C_ITNAM','C_STATUS');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('C_STATUS','combobox','',array(''=>'Pilih','B'=>'Need Confirm','C'=>'Confirmed'));
	
		$grid->setJoinTable('plc2.itemas', 'itemas.C_ITENO = mr01.C_ITENO', 'left');		
		$grid->setQuery('mr01.C_STATUS != "D"', NULL);
		

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

 
   


/*manipulasi view object form start*/

function updateBox_dossier_request_sample_item_name($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.itemas', array('C_ITENO'=>$rowData['C_ITENO']))->row_array();
			if (empty($rows)) {
				$itemname='-';
			}else{
				$itemname = $rows['C_ITNAM'];
			}

		$return= $itemname;

		
		return $return;
}

function updateBox_dossier_request_sample_detail_mr($field, $id, $value, $rowData) {
	//$return1 = print_r($rowData);

		//$rows = $this->db_plc0->get_where('plc2.mr02', array('c_mrno'=>$rowData['C_MRNO']))->result_array();
		$sql_doc='	select b.c_itemnumb,c.c_itemname,b.c_batchno,b.n_qty
					from plc2.mr02 b 
					join plc2.imsh c on c.c_itemnumb= b.c_itemnumb
					where b.c_mrno="'.$rowData['C_MRNO'].'"
					';
		
		$data['rows'] = $this->db_plc0->query($sql_doc)->result_array();
		$return=  $this->load->view('dossier_request_sample_detail_mr',$data,TRUE);
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

