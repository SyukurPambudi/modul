<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Browse_bb extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Bahan Baku');		
		$grid->setTable('plc2.plc2_raw_material');		
		$grid->setUrl('browse_bb');
		$grid->addList('pilih','vnama','vsatuan');
		$grid->setSortBy('vnama');
		$grid->setSortOrder('asc');
		$grid->setWidth('vnama', '480');
		$grid->setWidth('vsatuan', '330');
		//$grid->setWidth('iteampd_id', '115');
		//$grid->setWidth('ikategoriupb_id', '120');
		//$grid->setWidth('ttanggal', '100');
		$grid->setWidth('pilih', '25');
		$grid->setLabel('vnama', 'Nama Bahan Baku');
		$grid->setLabel('vsatuan', 'Satuan');
		$grid->setSearch('vnama','vsatuan');
		$grid->setAlign('vsatuan', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field', $this->input->get('field'));
		$grid->setInputGet('col', $this->input->get('col'));
		
		$grid->setQuery('vnama IS NOT NULL', null);	
		$grid->setQuery('vnama <>"" ', null);		
		$grid->setQuery('vsatuan IS NOT NULL', null);	
		$grid->setQuery('vsatuan <> ""', null);		
		
		$idupb =0;
		//rawmate yg sudah ada...
		$grid->setInputGet('_irawmat_id', $this->input->get('irawmat_id'));
		$grid->setInputGet('_upb_id', $this->input->get('upbid'));

		$idupb = $this->input->get('_upb_id') ;
		if($this->input->get('_irawmat_id')==""){
				
		}
		else{
			$grid->setQuery('plc2.plc2_raw_material.raw_id not in ('.str_replace("_", ",", $this->input->get('_irawmat_id')).')', null);
		}
  
		// raw material tidak boleh yang sudah ada di request sebelumnya dengan UPB yang sama 
		
		/*$grid->setQuery('plc2.plc2_raw_material.raw_id not in (
						select a.raw_id
						from plc2.plc2_upb_request_sample_detail a 
						join plc2.plc2_upb_request_sample b on b.ireq_id=a.ireq_id
						where a.ldeleted=0
						and b.ldeleted=0
						and b.iupb_id="'.$idupb.'" )

			', null);*/

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

	function listBox_browse_bb_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_bb('.$pk.',\''.$rowData->raw_id.'\',\''.$rowData->vnama.'\',\''.$rowData->vsatuan.'\') ;" />
				<script type="text/javascript">
					var ix = "'.$this->input->get('index').'";
					function pilih_bb (id, raw_id, vnama, vsatuan) {					
						custom_confirm("Yakin", function() {
							$(".'.$this->input->get('col').'").eq(ix).val(id);
							$(".'.$this->input->get('col').'_dis").eq(ix).val(vnama);
							$(".detsatuan").eq(ix).val(vsatuan);
							$("#alert_dialog_form").dialog("close");
						});
					}
				</script>';
		//'.$pk.','.$rowData->cNamaSup.'
		return $o;
	}
}
