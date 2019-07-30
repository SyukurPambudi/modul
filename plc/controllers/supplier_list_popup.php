<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Supplier_list_popup extends MX_Controller {
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
		
    	$grid = new Grid;		
		$grid->setTitle('Supplier');		
		$grid->setTable('hrd.mnf_supplier');		
		$grid->setUrl('supplier_list_popup');
		$grid->addList('vnmsupp', 'vkota', 'vcontact', 'pilih');
		$grid->setSortBy('cNip');
		$grid->setSortOrder('ASC');
		$grid->setWidth('vnmsupp', '355'); 
		$grid->setWidth('vkota', '195'); 
		$grid->setWidth('vcontact', '250');
		$grid->setWidth('pilih', '30');
		$grid->setAlign('pilih', 'center');
		
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		
		$grid->setInputGet('field',$this->_field);
		$grid->setInputGet('col',$this->_col);
		
		$grid->setLabel('vnmsupp', 'Nama Supplier');
		$grid->setLabel('vkota', 'Kota');
		$grid->setLabel('vcontact', 'Contact Person');
		$grid->setSearch('vnmsupp', 'vkota', 'vcontact');
		
		$grid->setQuery('hrd.mnf_supplier.ldeleted', 0);
		
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
	
	function listBox_supplier_list_popup_pilih($value, $pk, $name, $rowData) {
		$f = $this->input->get('col') ? $this->input->get('field').'_'.$this->input->get('col') : $this->input->get('field').'_isupplier_id';
		$fd = $this->input->get('col') ? $this->input->get('field').'_'.$this->input->get('col').'_dis' : $this->input->get('field').'_isupplier_id_dis';
		$o  = '<input type="radio" name="pilih" onClick="javascript:pilih_supplier_popup(\''.$pk.'\',\''.$rowData->vnmsupp.'\') ;" />';
		$o .= '<script type="text/javascript">
				function pilih_supplier_popup (id, nama) {
					custom_confirm("Yakin?", function(){												
						$("#'.$f.'").val(id);
						$("#'.$fd.'").val(nama);
						$("#alert_dialog_form").dialog("close");
					});
				}
			</script>';
		
		return $o;
	}
}