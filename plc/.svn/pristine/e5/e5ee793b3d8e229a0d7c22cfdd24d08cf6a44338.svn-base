<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class import_browse_upi_launching extends MX_Controller {
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
		$grid->setUrl('import_browse_upi_launching');
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
		$grid->setQuery('daftar_upi.iStatusKill = "0" ', null);
		$grid->setQuery('iSubmit_upi_detail = "1" ', null);
		//upi sudah approve prinsipal
		$grid->setQuery('daftar_upi.iupi_id in (select a.iupi_id from plc2.registrasi_upi a where a.iApprove_bdirm in(2)) ', null);
		//upi tidak sedang aktif di prareg atau sudah approve
		$grid->setQuery('daftar_upi.iupi_id not in (SELECT a.iupi_id FROM plc2.data_launching a WHERE a.iApprove_bdirm in(2,0)) ', null);

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

	function listBox_import_browse_upi_launching_pilih($value, $pk, $name, $rowData) {
		$url_header = base_url()."processor/plc/import/data/lounching/?action=getdetil"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upi_prio('.$pk.',\''.$rowData->vNo_upi.'\',\''.$rowData->dTgl_upi.'\',\''.$rowData->vNama_usulan.'\') ;" />';
		$o .= '<script type="text/javascript">
					function pilih_upi_prio (id, vNo_upi, dTgl_upi,vNama_usulan ) {					
						custom_confirm("Yakin", function() {
								$("#'.$this->input->get('field').'_'.'iupi_id ").val(id);
								$.ajax({
									url: "'.$url_header.'",
									type: "post",
									data: {
										iupi_id: id,
										},
									dataType: "json",
				                    success: function( data ) {
				                        
				                        $.each(data, function(index, element) {
				                        	$("#'.$this->input->get('field').'_'.'iupi_id_dis").val(element.vNo_upi);
				                        	$("#'.$this->input->get('field').'_'.'dTgl_upi").val(element.dTgl_upi);
				                        	$("#'.$this->input->get('field').'_'.'cPengusul_upi").val(element.cPengusul_upi);
											$("#'.$this->input->get('field').'_'.'vNama_usulan").val(element.vNama_usulan);

											$("#'.$this->input->get('field').'_'.'vKekuatan").val(element.vKekuatan);
											$("#'.$this->input->get('field').'_'.'vDosis").val(element.vDosis);
											$("#'.$this->input->get('field').'_'.'vNama_generik").val(element.vNama_generik);
											$("#'.$this->input->get('field').'_'.'vIndikasi").val(element.vIndikasi);
											$("#'.$this->input->get('field').'_'.'ikategori_id").val(element.ikategori_id);
											$("#'.$this->input->get('field').'_'.'ikategoriupi_id").val(element.ikategoriupi_id);
											
											
				                        })
				                    }

								})

							$("#alert_dialog_form").dialog("close");
						});
					}
				</script>';

		return $o;
	}
}
