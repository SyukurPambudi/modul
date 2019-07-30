<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class import_browse_upi_ujilab extends MX_Controller {
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
		$grid->setUrl('import_browse_upi_ujilab');
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

		//$grid->setJoinTable('plc2.analisa_prinsipal', 'daftar_upi.iupi_id = analisa_prinsipal.iupi_id', 'inner');
		//$grid->setJoinTable('plc2.lab_penguji', 'lab_penguji.ilab_penguji_id = uji_lab_upi.ilab_penguji_id', 'inner');

		$grid->setQuery('iSubmit_upi_detail = "1" ', null);
		$grid->setQuery('iStatusUji = "1" ', null);
		$grid->setQuery('daftar_upi.iStatusKill = "0" ', null);
		//upi sudah approve prinsipal
		$grid->setQuery('daftar_upi.iupi_id in (select a.iupi_id from plc2.analisa_prinsipal a where a.iApprove_bdirm in(2)) ', null);
		//upi tidak sedang aktif di prareg atau sudah approve
		//$grid->setQuery('daftar_upi.iupi_id in (SELECT a.iupi_id FROM plc2.analisa_prinsipal a WHERE a.iApprove_bdirm IN(2) OR iSubmit_prinsipal = 0) ', null);
		$grid->setQuery('daftar_upi.iupi_id not in (SELECT a.iupi_id FROM plc2.uji_lab_upi a WHERE a.iApprove_bdirm = 2 or a.iSubmit_ujiLabs=0) ', null);

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

	function listBox_import_browse_upi_ujilab_pilih($value, $pk, $name, $rowData) {
		$url_header = base_url()."processor/plc/import/uji/labs/?action=getdetil"; 
		$url_rincian = base_url()."processor/plc/partial/view/ujilab?action=gethistorytd"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upi_prio('.$pk.',\''.$rowData->vNo_upi.'\',\''.$rowData->dTgl_upi.'\',\''.$rowData->vNama_usulan.'\') ;" />';
		$o .= '<script type="text/javascript">
					function pilih_upi_prio (id, vNo_upi, dTgl_upi,vNama_usulan ) {					
						custom_confirm("Yakin", function() {
							$("#'.$this->input->get('field').'_'.'iupi_id").val(id);
								$.ajax({
							     url: "'.$url_rincian.'", 
							     type: "POST", 
							     data: {iupi_id: id}, 
							     success: function(response){
							         $("#hist_dok_td_view").html(response);
							     }

							});
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
