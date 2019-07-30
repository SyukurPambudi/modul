<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_upi_detail extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPI');		
		$grid->setTable('plc2.daftar_upi');		
		$grid->setUrl('browse_upi_detail');
		$grid->addList('vNo_upi','vNama_usulan','pilih');

		$grid->setSortBy('iupi_id');
		$grid->setSortOrder('asc'); 

		$grid ->setWidth('vNo_upi', '150'); 
		$grid->setWidth('vNama_usulan', '500'); 
		$grid->setWidth('pilih', '25');

		$grid->setLabel('iupi_id','No UPI'); //Ganti Label
		$grid->setLabel('vNo_upi','No UPI'); //Ganti Label
		$grid->setLabel('vNama_usulan','Nama Usulan'); //Ganti Label

		$grid->setSearch('vNo_upi');
		$grid->setAlign('vNo_upi', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		//$grid->setRelation('iteambusdev_id', 'plc2.plc2_div_team', 'idplc2_div_team', 'vName','bdTeamName','inner');

		// join table
		$grid->setQuery('iStatusKill = "1" ', null);

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

	function listBox_browse_upi_detail_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->vNo_upi.'\',\''.$rowData->vNama_usulan.'\') ;" />
		<script type="text/javascript">
				function pilih_upb_detail (id, vNo_upi, vNama_usulan){					
					custom_confirm("Yakin ?", function(){
						$("#'.$this->input->get('field').'_iupi_id").val(id);
						$("#'.$this->input->get('field').'_iupi_id_dis").val(vNo_upi+" - "+vNama_usulan);
						$("#alert_dialog_form").dialog("close");
					});
				}
		</script>';
		return $o;
	}
}
