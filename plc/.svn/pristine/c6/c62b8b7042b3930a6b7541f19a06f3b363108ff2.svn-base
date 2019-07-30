<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_upd_prio extends MX_Controller {
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
		$grid->setTitle('List UPD');		
		$grid->setTable('dossier.dossier_upd');		
		$grid->setUrl('browse_upd_prio');
		$grid->addList('vUpd_no','dTanggal_upd','plc2_upb.vupb_nomor','vNama_usulan','pilih');
		$grid->setSortBy('vUpd_no');
		$grid->setSortOrder('DESC');
		$grid->setWidth('vUpd_no', '55');
		$grid->setWidth('dTanggal_upd', '190');
		$grid->setWidth('plc2.vupb_nomor', '210');
		$grid->setWidth('vNama_usulan', '300');
		$grid->setWidth('pilih', '25');

		$grid->setLabel('vUpd_no', 'No. UPD');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('dTanggal_upd', 'Tanggal UPD');				
		$grid->setLabel('plc2.vupb_nomor', 'No. UPB');
		$grid->setLabel('vNama_usulan', 'Nama Usulan');
		
		$grid->setSearch('vUpd_no','dTanggal_upd');
		
		$grid->setAlign('vUpd_no', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');

		// join table
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = dossier_upd.iupb_id', 'inner');
		$grid->setQuery('iApprove_upd = "2" ', null);
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

	function listBox_browse_upd_prio_pilih($value, $pk, $name, $rowData) {
		$url_header = base_url()."processor/plc_export/daftar/upd/?action=getdetil"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upd_prio('.$pk.',\''.$rowData->vUpd_no.'\',\''.$rowData->dTanggal_upd.'\',\''.$rowData->plc2_upb__vupb_nomor.'\',\''.$rowData->vNama_usulan.'\') ;" />';
		$o .= '<script type="text/javascript">
					var ix = "'.$this->input->get('index').'";
					function pilih_upd_prio (id, vUpd_no, dTanggal_upd, iupb_id,vNama_usulan) {					
						custom_confirm("Yakin", function() {
							$(".upd_prio_upd_id").eq(ix).val(id);
							$(".upd_prio_upd_no").eq(ix).val(vUpd_no);
							$(".upd_prio_nama_usulan").eq(ix).text(vNama_usulan);
							$(".upd_prio_tgl").eq(ix).text(dTanggal_upd);
							$(".upd_prio_iupb_id").eq(ix).text(iupb_id);

							//$(".upd_prio_kategori_"+pdId).eq(ix).text(ikategoriupb_id);
							$("#alert_dialog_form").dialog("close");
						});
					}
				</script>';

		return $o;
	}
}
