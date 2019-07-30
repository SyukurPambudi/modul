<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Browse_ro extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Bahan Baku');		
		$grid->setTable('reformulasi.export_request_sample_detail');		
		$grid->setUrl('browse_ro');
		$grid->addList('pilih','ifrekuensi','export_request_sample.vRequest_no','plc2_raw_material.vnama','iJumlah','vSatuan','export_request_sample.dTgl_request');
		$grid->setSortBy('iexport_request_sample_detail');
		$grid->setSortOrder('DESC');
		$grid->setJoinTable('reformulasi.export_request_sample','export_request_sample.iexport_request_sample=export_request_sample_detail.iexport_request_sample','inner');
		$grid->setJoinTable('plc2.plc2_raw_material','plc2_raw_material.raw_id=export_request_sample_detail.raw_id','inner');
		$grid->setWidth('ifrekuensi', '40');
		$grid->setWidth('export_request_sample.vRequest_no', '120');
		$grid->setWidth('iJumlah', '100');
		$grid->setWidth('vSatuan', '100');
		$grid->setWidth('plc2_raw_material.vnama', '330');
		$grid->setWidth('export_request_sample.dTgl_request', '100');
		$grid->setWidth('pilih', '25');
		$grid->setLabel('ifrekuensi', 'Frek');
		$grid->setLabel('export_request_sample.vRequest_no', 'No. Permintaan');
		$grid->setLabel('plc2_raw_material.vnama', 'Raw Material');
		$grid->setLabel('iJumlah', 'Jumlah');
		$grid->setLabel('vSatuan', 'Satuan');
		$grid->setLabel('export_request_sample.dTgl_request', 'Tanggal Request');
		$grid->setSearch('ifrekuensi','export_request_sample.vRequest_no','plc2_raw_material.vnama','iJumlah','vSatuan','export_request_sample.dTgl_request');
		$grid->setAlign('iJumlah', 'right');
		$grid->setAlign('ifrekuensi', 'center');
		$grid->setAlign('export_request_sample.vRequest_no', 'center');
		$grid->setAlign('export_request_sample.dTgl_request', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field', $this->input->get('field'));
		$grid->setInputGet('col', $this->input->get('col'));
		
		$grid->setQuery('export_request_sample_detail.ldeleted', 0);	 
		$grid->setQuery('export_request_sample.iApprove_pd', 2);
		
		//po yg sudah ada...
		$grid->setInputGet('_iexport_request_sample_detail', $this->input->get('iexport_request_sample_detail'));
		if($this->input->get('_iexport_request_sample_detail')==""){
			
		}
		else{
			$grid->setQuery('reformulasi.export_request_sample_detail.iexport_request_sample_detail not in ('.str_replace("_", ",", $this->input->get('_iexport_request_sample_detail')).')', null);
		}

		/*BB yang sudah diterima oleh PD/AD sebaiknya tidak muncul lagi di pilihan modul PO Sample. bu devina UAT refor export ver 1 rev0205 source email */


		
		$grid->setQuery('reformulasi.export_request_sample_detail.iexport_request_sample_detail not  in (
						    select a.iexport_request_sample_detail 
							from reformulasi.export_ro_detail a 
							where 
							a.lDeleted=0
							and a.iJumlah_batch is not null
						  )', null);

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

	function listBox_browse_ro_export_request_sample_trequest($value) {
		return date('d M Y', strtotime($value));
	}

	function listBox_browse_ro_pilih($value, $pk, $name, $rowData) {
	$url_header = base_url()."processor/reformulasi/v3/export/request/refor/?action=getMax"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_bb('.$pk.',\''.$rowData->iexport_request_sample.'\',\''.$rowData->export_request_sample__vRequest_no.'\',\''.$rowData->raw_id.'\',\''.$rowData->plc2_raw_material__vnama.'\',\''.$rowData->iexport_request_sample_detail.'\',\''.$rowData->vSatuan.'\') ;" />
<script type="text/javascript">
	var ix = "'.$this->input->get('index').'";
	function pilih_bb (id, iexport_request_sample, vreq_no, raw_id, raw_name, reqdet_id,vSatuan) {					
		custom_confirm("Yakin", function() {
			$(".'.$this->input->get('col').'").eq(ix).val(iexport_request_sample);
			$(".'.$this->input->get('col').'_dis").eq(ix).val(vreq_no);
			$(".detraw_id").eq(ix).val(raw_id);
			$(".detraw_id_dis").eq(ix).val(raw_name);
			$(".detsatuan").eq(ix).val(vSatuan);
			$(".iexport_request_sample_detail").eq(ix).val(reqdet_id);
			

			
				                    
			$("#alert_dialog_form").dialog("close");
		});
	}
</script>';
		//'.$pk.','.$rowData->cNamaSup.'
		return $o;
	}




}

