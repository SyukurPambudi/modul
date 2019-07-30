<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class import_browse_ujilab extends MX_Controller {
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
		$grid->setTitle('List Lab Penguji');		
		$grid->setTable('plc2.lab_penguji');		
		$grid->setUrl('import_browse_ujilab');
		$grid->addList('vNama_lab_penguji','vAlamat','vTelp','vContact_Person','pilih');
		$grid->setSortBy('vNama_lab_penguji');
		$grid->setSortOrder('DESC');

		$grid ->setWidth('vNama_lab_penguji', '150'); 
		$grid ->setWidth('vAlamat', '250'); 
		$grid ->setWidth('vTelp', '100'); 
		$grid ->setWidth('vContact_Person', '150'); 

		//$grid->setWidth('vNo_upi', '55');
		//$grid->setWidth('dTgl_upi', '190');
		//$grid->setWidth('vNama_usulan', '300');
		$grid->setWidth('pilih', '35');

		$grid->setLabel('vNama_lab_penguji','Nama Lab Penguji'); //Ganti Label
		$grid->setLabel('vAlamat','Alamat'); 
		$grid->setLabel('vTelp','Telp.'); //Ganti Label
		$grid->setLabel('vContact_Person','Contact Person'); 

		//$grid->setLabel('vNo_upi', 'No. UPD');
		//$grid->setLabel('dTgl_upi', 'Tanggal UPD');				
		//$grid->setLabel('vNama_usulan', 'Nama Usulan');
		
		//$grid->setSearch('vNo_upi','dTgl_upi');
		$grid->setSearch('vNama_lab_penguji');
		
		//$grid->setAlign('vNo_upi', 'center');
		$grid->setAlign('pilih', 'center');

		$grid->setInputGet('field',$this->_field);

		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');

		$grid->setInputGet('iupi_id', $this->input->get('iupi_id'));

		$grid->setQuery('lDeleted  = "0" ', null);
		//upi sudah approve prinsipal
		//$grid->setQuery('daftar_upi.iupi_id in (select a.iupi_id from plc2.analisa_prinsipal a where a.iApprove_bdirm in(2) AND a.iStatus = 0) ', null);
		//upi tidak sedang aktif di prareg atau sudah approve
		//$grid->setQuery('daftar_upi.iupi_id not in (select a.iupi_id from plc2.uji_lab_upi a where a.iApprove_bdirm in(2,0)) ', null);

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

	function listBox_import_browse_ujilab_pilih($value, $pk, $name, $rowData) {
		$url_header = base_url()."processor/plc/import/uji/labs/?action=getdetillab"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upi_prio('.$pk.',\''.$rowData->vNama_lab_penguji.'\',\''.$rowData->vAlamat.'\',\''.$rowData->vTelp.'\',\''.$rowData->vContact_Person.'\') ;" />';
		$o .= '<script type="text/javascript">
					function pilih_upi_prio (id, vNama_lab_penguji, vAlamat, vTelp, vContact_Person) {					
						custom_confirm("Yakin", function() {
							$("#'.$this->input->get('field').'_'.'ilab_penguji_id ").val(id);
							$.ajax({
								url: "'.$url_header.'",
								type: "post",
								data: {
									ilab_penguji_id: id,
									},
								dataType: "json",
			                    success: function( data ) {
			                        
			                        $.each(data, function(index, element) {
			                        	$("#'.$this->input->get('field').'_'.'ilab_penguji_id_dis").val(element.vNama_lab_penguji);
			                        	$("#'.$this->input->get('field').'_'.'vAlamat").val(element.vAlamat);
										$("#'.$this->input->get('field').'_'.'vTelp").val(element.vTelp);
										$("#'.$this->input->get('field').'_'.'vContact_Person").val(element.vContact_Person);
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
