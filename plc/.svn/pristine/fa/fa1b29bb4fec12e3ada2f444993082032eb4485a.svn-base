<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class import_browse_upi_prio extends MX_Controller {
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
		$grid->setUrl('import_browse_upi_prio');
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
		
		$grid->setSearch('vNo_upi','dTgl_upi');
		
		$grid->setAlign('vNo_upi', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');

		$grid->setInputGet('_iupi_id', $this->input->get('iupi_id'));
		//echo "test : ".$this->input->get('_iupb_id');
		//$grid->setJoinTable('plc2.telusur_paten', 'telusur_paten.iupi_id = daftar_upi.iupi_id', 'inner');

		// join table

		$grid->setQuery('daftar_upi.iupi_id not in ('.str_replace("_", ",", $this->input->get('_iupi_id')).')', null);
		//$grid->setQuery('telusur_paten.iRekomendasi_produk = "2" ', null);
		//$grid->setQuery('telusur_paten.iApprove_dir = "2" ', null);
		$grid->setQuery('daftar_upi.iApprove_dir = "2" ', null);
		$grid->setQuery('iStatusKill = "0" ', null);	
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

	function listBox_import_browse_upi_prio_pilih($value, $pk, $name, $rowData) {
		$url_header = base_url()."processor/plc/daftar/upd/export/?action=getdetil"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upi_prio('.$pk.',\''.$rowData->vNo_upi.'\',\''.$rowData->dTgl_upi.'\',\''.$rowData->vNama_usulan.'\') ;" />';
		$o .= '<script type="text/javascript">
					var ix = "'.$this->input->get('index').'";
					function pilih_upi_prio (id, vNo_upi, dTgl_upi,vNama_usulan) {					
						custom_confirm("Yakin", function() {
							$(".upi_prio_upi_id").eq(ix).val(id);
							$(".upi_prio_upi_no").eq(ix).val(vNo_upi);
							$(".upi_prio_nama_usulan").eq(ix).text(vNama_usulan);
							$(".upi_prio_tgl").eq(ix).text(dTgl_upi);

							$("#alert_dialog_form").dialog("close");
						});
					}
				</script>';

		return $o;
	}
}
