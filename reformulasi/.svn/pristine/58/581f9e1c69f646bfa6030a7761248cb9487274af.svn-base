<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class lokal_browse_refor_ujibe extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
		$this->_field = $this->input->get('field');
		/*yang ini udah ada settingan belum di config ?*/
		$this->dbset = $this->load->database('reformulasi', true);
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Permintaan Uji BE');		
		$grid->setTable('reformulasi.local_req_refor');		
		$grid->setUrl('lokal_browse_refor_ujibe');

		


		$grid->addList('vNo_req_refor','cIteno','plc2.C_ITNAM','pilih');
		$grid->setSortBy('vNo_req_refor');
		$grid->setSortOrder('DESC');

 // $grid->setJoinTable('umum.glccmas', 'glccmas.c_cccode= order01.c_reqby', 'inner');
              /*  $grid->setQuery('glccmas.c_tahun ', date('Y')); 
                $grid->setQuery('order01.lDeleted = 0 ', null); 
                $grid->setQuery('order01.iCompanyID = \''.$this->input->get('company_id').'\'',null);*/


		$grid->setWidth('vNo_req_refor', '100');
		$grid->setWidth('cIteno', '50');
		$grid->setWidth('plc2.C_ITNAM', '190');
		$grid->setWidth('pilih', '50');

		$grid->setLabel('vNo_req_refor', 'No. Formula');
		$grid->setLabel('cIteno', 'Kode Finish Good');	
		$grid->setLabel('plc2.C_ITNAM', 'Nama Finish Good');	
		
		

		$grid->setSearch('vNo_req_refor','plc2.C_ITNAM');
		
		$grid->setAlign('vNo_req_refor', 'center');
		$grid->setAlign('plc2.C_ITNAM', 'left');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');

		//$grid->setJoinTable('plc2.analisa_prinsipal', 'daftar_upi.iupi_id = analisa_prinsipal.iupi_id', 'inner');
		//$grid->setJoinTable('plc2.lab_penguji', 'lab_penguji.ilab_penguji_id = uji_lab_upi.ilab_penguji_id', 'inner');

		$grid->setJoinTable('plc2.itemas', 'itemas.C_ITENO= local_req_refor.cIteno', 'inner');
		$grid->setQuery('local_req_refor.iUji_be = "1" ', null);
		$grid->setQuery('local_req_refor.lDeleted = 0 ', null);

		//upi sudah approve prinsipal
		// $grid->setQuery('daftar_upi.iupi_id in (select a.iupi_id from plc2.analisa_prinsipal a where a.iApprove_bdirm in(2)) ', null);
		//upi tidak sedang aktif di prareg atau sudah approve
		//$grid->setQuery('daftar_upi.iupi_id in (SELECT a.iupi_id FROM plc2.analisa_prinsipal a WHERE a.iApprove_bdirm IN(2) OR iSubmit_prinsipal = 0) ', null);
		// $grid->setQuery('daftar_upi.iupi_id not in (SELECT a.iupi_id FROM plc2.uji_lab_upi a WHERE a.iApprove_bdirm = 2 or a.iSubmit_ujiLabs=0) ', null);

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



	function listBox_lokal_browse_refor_ujibe_pilih($value, $pk, $name, $rowData) {
		$url_header = base_url()."processor/reformulasi/lokal/req/ujibe/?action=getdetil"; 
			$url_rincian = base_url()."processor/reformulasi/partial/view/ujibe?action=gethistorytd"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_refor_prio('.$pk.',\''.$rowData->vNo_req_refor.'\',\''.$rowData->cIteno.'\') ;" />';
		$o .= '<script type="text/javascript">
					function pilih_refor_prio (id, vNo_req_refor, cIteno) {					
						custom_confirm("Yakin", function() {
							$("#'.$this->input->get('field').'_'.'refor_id").val(id);
								$.ajax({
							     url: "'.$url_rincian.'", 
							     type: "POST", 
							     data: {refor_id: id}, 
							     success: function(response){
							         $("#hist_dok_td_view").html(response);
							     }

							});
								$.ajax({
									url: "'.$url_header.'",
									type: "post",
									data: {
										refor_id: id,
										},
									dataType: "json",
				                    success: function( data ) {
				                        
				                        $.each(data, function(index, element) {
				                        	$("#'.$this->input->get('field').'_'.'refor_id_dis").val(element.vNo_req_refor);
				                        	$("#'.$this->input->get('field').'_'.'cIteno").val(element.cIteno);
				                        										
											
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
