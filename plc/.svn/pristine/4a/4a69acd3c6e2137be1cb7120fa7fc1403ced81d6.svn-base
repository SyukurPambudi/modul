<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plc_spek_fg_employee_popup extends MX_Controller {
	private $sess_auth;
	private $dbset;
	private $_id = 0;
	private $_iDeptId = 0;
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
        $this->sess_auth = new Zend_Session_Namespace('auth');
        $this->dbset = $this->load->database('hrd', true);
		$this->_field = $this->input->get('field');
		$this->_col = $this->input->get('col');
    }
    function index($action = '') {
    	$action = $this->input->get('action');
		
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('Employee');		
		$grid->setTable('hrd.employee');		
		$grid->setUrl('plc_spek_fg_employee_popup');
		$grid->addList('cNip', 'vName', 'pilih');
		$grid->setSortBy('cNip');
		$grid->setSortOrder('ASC'); //sort ordernya
		$grid->setAlign('cNip', 'left'); //Align nya
		$grid->setWidth('cNip', '100'); 
		$grid->setAlign('vName', 'left'); //Align nya
		$grid->setWidth('vName', '705'); 
		$grid->setWidth('pilih', '30'); // width nya
		$grid->setAlign('pilih', 'center'); // align nya
		
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		
		$grid->setInputGet('field',$this->_field);
		$grid->setInputGet('col',$this->_col);
		
		//$grid->addFields('id', 'idga_mstype', 'idga_msservis','iBufferStock', 'iMaxStock');
		$grid->addFields('cNip', 'vName', 'pilih');
		$grid->setLabel('cNip', 'NIP'); //Ganti Label
		$grid->setLabel('vName', 'Nama Employee'); //Ganti Label
		$grid->setSearch('cNip','vName');
		
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
	
	function listBox_plc_spek_fg_employee_popup_pilih($value, $pk, $name, $rowData) {
		$f = $this->input->get('col') ? $this->input->get('field').'_'.$this->input->get('col') : $this->input->get('field').'_vnip_formulator';
		$fd = $this->input->get('col') ? $this->input->get('field').'_'.$this->input->get('col').'_dis' : $this->input->get('field').'_vnip_formulator_dis';
		$o  = '<input type="radio" name="pilih" onClick="javascript:pilih_employee_spek_fg(\''.$rowData->cNip.'\',\''.$rowData->vName.'\') ;" />';
		$o .= '<script type="text/javascript">
				var tipe = "'.$this->input->get('_tipe').'";
				var ix = "'.$this->input->get('_ix').'";
				function pilih_employee_spek_fg (id, nama) {
					custom_confirm("Yakin?", function(){												
						$("#'.$f.'").val(id);
						$("#'.$fd.'").val(id+" - "+nama);
						$("#alert_dialog_form").dialog("close");
					});
				}
			</script>';
		
		return $o;
	}
}