<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_produsen_komparator extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->load->library('lib_utilitas');
		$this->_field = $this->input->get('field');
		$this->dbset = $this->load->database('dosier', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Produsen Komparator');		
		$grid->setTable('dossier.dossier_produsen_komparator');		
		$grid->setUrl('browse_produsen_komparator');
		$grid->addList('pilih','vKode_produsen','vNama_produsen');
		$grid->setSortBy('vKode_produsen');
		$grid->setSortOrder('DESC');
		$grid->setWidth('pilih', '50');

	
		$grid->setLabel('vKode_produsen', 'Kode Produsen');
		$grid->setLabel('vNama_produsen', 'Nama Produsen');

		$grid->setAlign('pilih', 'center');

		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setWidth('vNama_produsen','500');
		$grid->setWidth('vKode_produsen','80');
		$grid->setSearch('vKode_produsen','vNama_produsen');
		$grid->setQuery('dossier_produsen_komparator.lDeleted', 0);

		$grid->setGridView('grid');

		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));//test komen
    }
	
    /*Modify main grid output */
    
	function listBox_browse_produsen_komparator_pilih($value, $pk, $name, $r) {
		$nr=strlen($r->vNama_produsen);
		if($nr>=50){
			$nama= substr($r->vNama_produsen, 0, 50);
		}else{
			$nama=$r->vNama_produsen;
		}
		$nama=$r->vKode_produsen.' - '.$nama;
			$o = '<input type="radio" name="pilih" onClick="javascript:pilih_komparator_detail('.$pk.',\''.$nama.'\') ;" />
		<script type="text/javascript">
			function pilih_komparator_detail (id, nama){				
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'").val(id);
				$("#'.$this->input->get('field').'_dis").val(nama);
				$("#alert_dialog_form").dialog("close");
			});
			}
		</script>';
		return $o;
	}
}
