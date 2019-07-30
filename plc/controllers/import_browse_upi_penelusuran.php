<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class import_browse_upi_penelusuran extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->_field = $this->input->get('field');
		$this->dbset = $this->load->database('plc', true);
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPI');		
		$grid->setTable('plc2.daftar_upi');		
		$grid->setUrl('import_browse_upi_penelusuran');
		$grid->addList('vNo_upi','dTgl_upi','vNama_usulan','pilih');
		$grid->setSortBy('vNo_upi');
		$grid->setSortOrder('DESC');
		$grid->setWidth('vNo_upi', '55');
		$grid->setWidth('dTgl_upi', '190');
		$grid->setWidth('vNama_usulan', '300');
		$grid->setWidth('pilih', '25');

		$grid->setLabel('vNo_upi', 'No. UPD');
		$grid->setLabel('dTgl_upi', 'Tanggal UPD');				
		$grid->setLabel('vNama_usulan', 'Nama Usulan');
		
		$grid->setSearch('vNo_upi','vNama_usulan');
		
		$grid->setAlign('vNo_upi', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setJoinTable('plc2.setting_prioritas_upi_detail', 'setting_prioritas_upi_detail.iupi_id = daftar_upi.iupi_id', 'inner');
		$grid->setJoinTable('plc2.setting_prioritas_upi', 'setting_prioritas_upi.isetting_prioritas_upi_id = setting_prioritas_upi_detail.isetting_prioritas_upi_id', 'inner');

		$grid->setQuery('daftar_upi.lDeleted = "0" ', null);	
		//upi sudah approve
		$grid->setQuery('daftar_upi.iApprove_dir = "2" ', null);
		$grid->setQuery('daftar_upi.iStatusKill = "0" ', null);		
		//setting prioritas sudah apprve
		$grid->setQuery('setting_prioritas_upi.iApprove_dir = "2" ', null);	

		//upi tidak sedang penelusuran paten yang masih aktif
		$grid->setQuery('daftar_upi.iupi_id not in (select a.iupi_id from plc2.telusur_paten a where a.iApprove_dir in(2,0)) ', null);

		// join table
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

	function listBox_import_browse_upi_penelusuran_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upi_penelusuran('.$pk.',\''.$rowData->vNo_upi.'\',\''.$rowData->dTgl_upi.'\',\''.$rowData->vNama_usulan.'\') ;" />';
		$o .= '<script type="text/javascript">
					var ix = "'.$this->input->get('index').'";
					function pilih_upi_penelusuran (id, vNo_upi, dTgl_upi,vNama_usulan) {					
						custom_confirm("Yakin", function() {
							$("#'.$this->input->get('field').'_'.'iupi_id_dis").val(vNo_upi);
							$("#'.$this->input->get('field').'_'.'iupi_id").val(id);
							$("#'.$this->input->get('field').'_'.'vNama_usulan").val(vNama_usulan);
							$("#alert_dialog_form").dialog("close");
						});
					}
				</script>';

		return $o;
	}
}
