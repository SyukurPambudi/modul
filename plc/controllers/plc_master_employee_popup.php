<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class plc_master_employee_popup extends MX_Controller {
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
    }
    function index($action = '') {
    	$action = $this->input->get('action');
		
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('Employee');		
		$grid->setTable('hrd.employee');		
		$grid->setUrl('plc_master_employee_popup');
		$grid->addList('cNip', 'vName', 'pilih');
		$grid->setSortBy('cNip');
		$grid->setSortOrder('ASC'); //sort ordernya
		$grid->setAlign('cNip', 'left'); //Align nya
		$grid->setWidth('cNip', '100'); 
		$grid->setAlign('vName', 'left'); //Align nya
		$grid->setWidth('vName', '710'); 
		$grid->setWidth('pilih', '30'); // width nya
		$grid->setAlign('pilih', 'center'); // align nya
		//$grid->addFields('id', 'idga_mstype', 'idga_msservis','iBufferStock', 'iMaxStock');
		$grid->addFields('cNip', 'vName', 'pilih');
		$grid->setLabel('cNip', 'NIP'); //Ganti Label
		$grid->setLabel('vName', 'Nama Employee'); //Ganti Label
		$grid->setSearch('cNip','vName');
		
		$grid->setInputGet('_tipe', $this->_tipe);
		$grid->setInputGet('_ix', $this->_ix);
		//$grid->setQuery('hrd.employee.iDeptId', $this->input->get('_iDeptId'));
		$grid->setQuery('hrd.employee.dResign', '0000-00-00');
		$grid->setQuery('hrd.employee.iCompanyID in (2,3,4,5,7)', null);
		
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
	
	function listBox_plc_master_employee_popup_pilih($value, $pk, $name, $rowData) {
		$o  = '<input type="radio" name="pilih" onClick="javascript:pilih_employee(\''.$rowData->cNip.'\',\''.$rowData->vName.'\','.$rowData->iDeptID.') ;" />';
		$o .= '<script type="text/javascript">
				var tipe = "'.$this->input->get('_tipe').'";
				var ix = "'.$this->input->get('_ix').'";
				function pilih_employee (id, nama, dept) {
					//alert(tipe);
					custom_confirm("Yakin?", function(){
						if(tipe == "pd") {	
							$(".cPenerimaPD").val(id);
							$(".upb_input_sampel_nama_nip_pd").val(id+" - "+nama);
						}
						else if(tipe == "bd") {		
						//alert("BD")				
							$(".cTerimaBD").eq(ix).val(id);
							$(".upb_input_sampel_nama_nip_bd").eq(ix).val(id+" - "+nama);
							$(".cPengirimBD").eq(ix).val(id);
							
						}
						else if(tipe == "andev") {						
						//	alert("AD")				
							$(".cPenerimaAD").eq(ix).val(id);
							$(".upb_input_sampel_nama_nip_ad").eq(ix).val(id+" - "+nama);
						}
						$("#alert_dialog_form").dialog("close");
					});
				}
			</script>';
		
		return $o;
	}
}