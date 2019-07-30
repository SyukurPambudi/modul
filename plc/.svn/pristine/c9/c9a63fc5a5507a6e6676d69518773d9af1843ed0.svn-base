<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_pic_req_sample extends MX_Controller {
	private $sess_auth;
	private $dbset;
	private $_id = 0;
	private $_iDeptId = 0;
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
        $this->sess_auth = new Zend_Session_Namespace('auth');
        $this->dbset = $this->load->database('hrd', true);  
		$this->_tipe = $this->input->get('type');      
		$this->_ix = $this->input->get('ix');
		$this->load->library('auth');
    }
    function index($action = '') {
    	$action = $this->input->get('action');
		
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('Employee');		
		$grid->setTable('hrd.employee');		
		$grid->setUrl('browse_pic_req_sample');
		$grid->addList('cNip', 'vName', 'pilih');
		$grid->setSortBy('cNip');
		$grid->setSortOrder('ASC'); //sort ordernya
		$grid->setAlign('cNip', 'left'); //Align nya
		$grid->setWidth('cNip', '100'); 
		$grid->setAlign('vName', 'left'); //Align nya
		$grid->setWidth('vName', '650'); 
		$grid->setWidth('pilih', '30'); // width nya
		$grid->setAlign('pilih', 'center'); // align nya
		//$grid->addFields('id', 'idga_mstype', 'idga_msservis','iBufferStock', 'iMaxStock');
		$grid->addFields('cNip', 'vName', 'pilih');
		$grid->setLabel('cNip', 'NIP'); //Ganti Label
		$grid->setLabel('vName', 'Nama Employee'); //Ganti Label
		$grid->setSearch('cNip','vName');
		
		//belum resign
		$grid->setQuery('hrd.employee.dResign', '0000-00-00');
		$grid->setQuery('hrd.employee.iCompanyID in (2,3,4,5,7)', null);

			//uji mikro BB , employee QA
		//$grid->setQuery('iDepartementID',5);
		//$grid->setQuery('iDivisionID',2);
		
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
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'), true);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'getlaststock':
				$this->getlaststok();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }
	public function output(){
		$this->index($this->input->get('action'));
	}	
	



	function listBox_browse_pic_req_sample_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->cNip.'\',\''.$rowData->vName.'\') ;" />';
		$o .='<script type="text/javascript">
		function pilih_upb_detail (id, nip, nama){		
			custom_confirm("Yakin ?", function(){
				$("#sample_permintaan_sample_cRequestor").val(nip);
				$("#sample_permintaan_sample_cRequestor_dis").val(nip+" - "+nama);

				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}


}