<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plc_upb_ref_popup extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPB');		
		$grid->setTable('plc2.plc2_upb_request_sample');		
		$grid->setUrl('plc_upb_ref_popup');
		$grid->addList('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','pilih');
		$grid->setSortBy('plc2_upb.vupb_nama');
		$grid->setSortOrder('ASC');
		$grid->setWidth('plc2_upb.vupb_nomor', '55');
		$grid->setWidth('plc2_upb.vupb_nama', '190');
		$grid->setWidth('plc2_upb.vgenerik', '210');
		$grid->setWidth('pilih', '25');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');				
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik');
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->setInputGet('iModul_id', $this->input->get('iModul_id'));
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setQuery('plc2_upb_request_sample.ldeleted',0);
		$grid->setQuery('plc2_upb_request_sample.iapppd',2);
		$grid->setGroupBy('plc2_upb_request_sample.iupb_id');

		$grid->setJoinTable('plc2.plc2_upb','plc2_upb_request_sample.iupb_id = plc2_upb.iupb_id','inner');
		
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
    	$this->index($this->input->get('action'));
    }

	function listBox_plc_upb_ref_popup_pilih($value, $pk, $name, $rowData) {
		 $modulID = $this->input->get('iModul_id');
		$url = base_url().'processor/plc/v3_permintaan_sample?action=load_detail';
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_spek_fg('.$pk.',\''.$rowData->plc2_upb__vupb_nomor.'\',\''.$rowData->plc2_upb__vupb_nama.'\',\''.$rowData->iupb_id.'\',\''.$modulID.'\') ;" />
				<script type="text/javascript">
					function pilih_upb_spek_fg (id, vupb_nomor, vupb_nama, iupb_id, modulID){					
						custom_confirm("Yakin ?", function(){ 
							$("#'.$this->input->get('field').'_iRefUpb_id").val(iupb_id);
							$("#'.$this->input->get('field').'_iRefUpb_id_dis").val(vupb_nomor+" - "+vupb_nama);

							$.ajax({
					            url: "'.$url.'",
					            type: "POST",
					            async: false,
					            data: {
					                    iupb_id: iupb_id,  
					                    iModul_id: modulID
					                }, 
					            success: function(data){
					                $(".v3_table_permintaan_sample_detail").html(data);  
        							$(".permintaan_sample_edit").hide();
					            }
					         });

							$("#alert_dialog_form").dialog("close");
						});
					}
				</script>';
		return $o;
	}
}
