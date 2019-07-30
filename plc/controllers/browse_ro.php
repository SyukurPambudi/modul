<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Browse_ro extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Bahan Baku');		
		$grid->setTable('plc2.plc2_upb_request_sample_detail');		
		$grid->setUrl('browse_ro');
		$grid->addList('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb_request_sample.vreq_nomor','plc2_raw_material.vnama','ijumlah','vsatuan','plc2_upb_request_sample.trequest','pilih');
		$grid->setSortBy('vnama');
		$grid->setSortOrder('asc');

		$grid->setJoinTable('plc2.plc2_upb_request_sample','plc2_upb_request_sample.ireq_id = plc2_upb_request_sample_detail.ireq_id','inner');
		$grid->setJoinTable('plc2.plc2_raw_material','plc2_raw_material.raw_id = plc2_upb_request_sample_detail.raw_id','inner');
		$grid->setJoinTable('plc2.plc2_upb','plc2_upb_request_sample.iupb_id = plc2_upb.iupb_id','inner');

		$grid->setWidth('ifrekuensi', '40');
		$grid->setWidth('plc2_upb_request_sample.vreq_nomor', '120');
		$grid->setWidth('ijumlah', '100');
		$grid->setWidth('vsatuan', '100');
		$grid->setWidth('plc2_raw_material.vnama', '330');
		$grid->setWidth('plc2_upb_request_sample.trequest', '100');
		$grid->setWidth('plc2_upb.vupb_nomor', '100');
		$grid->setWidth('plc2_upb.vupb_nama', '300');
		$grid->setWidth('pilih', '25');

		$grid->setLabel('ifrekuensi', 'Frek');
		$grid->setLabel('plc2_upb_request_sample.vreq_nomor', 'No. Permintaan');
		$grid->setLabel('plc2_raw_material.vnama', 'Raw Material');
		$grid->setLabel('ijumlah', 'Jumlah');
		$grid->setLabel('vsatuan', 'Satuan');
		$grid->setLabel('plc2_upb_request_sample.trequest', 'Tanggal Request');
		$grid->setLabel('plc2_upb.vupb_nomor', 'Nomor UPB');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama UPB');

		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb_request_sample.vreq_nomor','plc2_raw_material.vnama','ijumlah','vsatuan','plc2_upb_request_sample.trequest');

		$grid->setAlign('ijumlah', 'right');
		$grid->setAlign('ifrekuensi', 'center');
		$grid->setAlign('plc2_upb_request_sample.vreq_nomor', 'center');
		$grid->setAlign('plc2_upb_request_sample.trequest', 'center');
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setAlign('pilih', 'center');

		$grid->setInputGet('field', $this->input->get('field'));
		$grid->setInputGet('col', $this->input->get('col'));

		$grid->setQuery('plc2_upb_request_sample_detail.ldeleted', 0);		
		//$grid->setQuery('plc2_upb_request_sample_detail.iclose', 0);
		$grid->setQuery('plc2_upb_request_sample.iapppd', 2);
		$grid->setQuery('plc2_upb_request_sample.ijenis_sample', 1);
		
		//po yg sudah ada...
		$grid->setInputGet('_ireqdet_id', $this->input->get('ireqdet_id'));
		if($this->input->get('_ireqdet_id')==""){
			
		}
		else{
			$grid->setQuery('plc2.plc2_upb_request_sample_detail.ireqdet_id not in ('.str_replace("_", ",", $this->input->get('_ireqdet_id')).')', null);
		}
		
		// $grid->setQuery('plc2.plc2_upb_request_sample_detail.ireqdet_id IN (
		// 				    SELECT aa.ireqdet_id FROM plc2.plc2_upb_request_sample_detail aa WHERE aa.ldeleted=0 
		// 					AND ( 
		// 						(SELECT IF(SUM(a.ijumlah) IS NULL , 0 , SUM(a.ijumlah)) AS sumjum FROM plc2.plc2_upb_po_detail a WHERE a.raw_id=aa.raw_id AND a.ireq_id=aa.ireq_id) 
		// 						<= aa.ijumlah) 
		// 				  )', null);

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

	function listBox_browse_ro_plc2_upb_request_sample_trequest($value) {
		return date('d M Y', strtotime($value));
	}

	function listBox_browse_ro_pilih($value, $pk, $name, $rowData) {
	$url_header = base_url()."processor/plc/sample/po/sample/?action=getMax"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_bb('.$pk.',\''.$rowData->ireq_id.'\',\''.$rowData->plc2_upb_request_sample__vreq_nomor.'\',\''.$rowData->raw_id.'\',\''.$rowData->plc2_raw_material__vnama.'\',\''.$rowData->ireqdet_id.'\',\''.$rowData->vsatuan.'\') ;" />
<script type="text/javascript">
	var ix = "'.$this->input->get('index').'";
	function pilih_bb (id, ireq_id, vreq_no, raw_id, raw_name, reqdet_id,vsatuan) {					
		custom_confirm("Yakin", function() {
			$(".'.$this->input->get('col').'").eq(ix).val(ireq_id);
			$(".'.$this->input->get('col').'_dis").eq(ix).val(vreq_no);
			$(".detraw_id").eq(ix).val(raw_id);
			$(".detraw_id_dis").eq(ix).val(raw_name);
			$(".detsatuan").eq(ix).val(vsatuan);
			$(".ireqdet_id").eq(ix).val(reqdet_id);
			

			$.ajax({
				url: "'.$url_header.'",
				type: "post",
				data: {
					ireqdet_id: id,
					},
				dataType: "json",
		        success: function( data ) {
		        
		            $.each(data, function(index, element) {
		        
		            	$(".detmaxjumlah").eq(ix).val(element.iMax);

           			})
				}
			})
				                    
			$("#alert_dialog_form").dialog("close");
		});
	}
</script>';
		//'.$pk.','.$rowData->cNamaSup.'
		return $o;
	}

		

}
