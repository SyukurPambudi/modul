<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class uji_mikro_bb_popup extends MX_Controller {
	private $sess_auth_localnon;
	private $dbset;
	private $_id = 0;
	private $_iDeptId = 0;
    function __construct() {
        parent::__construct();
        $this->sess_auth_localnon = new Zend_Session_Namespace('auth_localnon');
        $this->dbset = $this->load->database('formulasi', false, true);  
		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
    	$action = $this->input->get('action');
		
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('Bahan Baku');		
		$grid->setTable('reformulasi.export_request_sample_detail');		
		$grid->setUrl('uji_mikro_bb_popup');
		$grid->addList('pilih','export_request_sample.vRequest_no','export_ro.vRo_no','export_req_refor.vno_export_req_refor','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','plc2_raw_material.vnama','ijumlah');
		$grid->setSortBy('iexport_request_sample_detail');
		$grid->setSortOrder('ASC'); //sort ordernya
		

		$grid->setLabel('export_request_sample.vRequest_no', 'Nomor Request'); //Ganti Label
        $grid->setAlign('export_request_sample.vRequest_no', 'center'); //Align nya
        $grid->setWidth('export_request_sample.vRequest_no', '100'); // width nya      

        $grid->setLabel('export_po.vpo_nomor', 'No PO'); //Ganti Label
        $grid->setAlign('export_po.vpo_nomor', 'center'); //Align nya
        $grid->setWidth('export_po.vpo_nomor', '100'); // width nya  

        $grid->setLabel('export_ro.vRo_no', 'No Penerimaan'); //Ganti Label
        $grid->setAlign('export_ro.vRo_no', 'center'); //Align nya
        $grid->setWidth('export_ro.vRo_no', '100'); // width nya  


        $grid->setLabel('plc2_raw_material.vnama', 'Nama Bahan baku'); //Ganti Label
        $grid->setAlign('plc2_raw_material.vnama', 'left'); //Align nya
        $grid->setWidth('plc2_raw_material.vnama', '200'); // width nya  

        $grid->setLabel('export_req_refor.vno_export_req_refor', 'No Req Reformulasi'); //Ganti Label
        $grid->setAlign('export_req_refor.vno_export_req_refor', 'center'); //Align nya
        $grid->setWidth('export_req_refor.vno_export_req_refor', '120'); // width nya  

        $grid->setLabel('dossier_upd.vUpd_no', 'No UPD'); //Ganti Label
        $grid->setAlign('dossier_upd.vUpd_no', 'center'); //Align nya
        $grid->setWidth('dossier_upd.vUpd_no', '80'); // width nya  

        $grid->setLabel('dossier_upd.vNama_usulan', 'Nama UPD'); //Ganti Label
        $grid->setAlign('dossier_upd.vNama_usulan', 'left'); //Align nya
        $grid->setWidth('dossier_upd.vNama_usulan', '200'); // width nya  


        $grid->setLabel('ijumlah', 'Jumlah'); //Ganti Label
        $grid->setAlign('ijumlah', 'left'); //Align nya
        $grid->setWidth('ijumlah', '50'); // width nya  
       
       	$grid->setWidth('pilih', '25'); // width nya  
		$grid->setAlign('pilih', 'center'); //Align nya

		$grid->addFields('cNip', 'vName', 'pilih');
		$grid->setSearch('export_request_sample.vRequest_no','export_ro.vRo_no','export_req_refor.vno_export_req_refor','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','plc2_raw_material.vnama');
		
		$grid->setJoinTable('reformulasi.export_request_sample', 'export_request_sample.iexport_request_sample = export_request_sample_detail.iexport_request_sample', 'inner');
        
        $grid->setJoinTable('reformulasi.export_ro_detail', 'export_ro_detail.iexport_request_sample_detail = export_request_sample_detail.iexport_request_sample_detail' , 'inner');
        $grid->setJoinTable('reformulasi.export_ro_detail_batch', 'export_ro_detail_batch.iexport_ro_detail = export_ro_detail.iexport_ro_detail' , 'inner');
        
        
        $grid->setJoinTable('reformulasi.export_ro', 'export_ro.iexport_ro = export_ro_detail.iexport_ro', 'inner');
        $grid->setJoinTable('plc2.plc2_raw_material', 'plc2_raw_material.raw_id = export_request_sample_detail.raw_id', 'inner');
        $grid->setJoinTable('reformulasi.export_req_refor', 'export_req_refor.iexport_req_refor = export_request_sample.iexport_req_refor', 'inner');
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = export_req_refor.idossier_upd_id', 'inner');

		//membutuhkan uji mikro 
		$grid->setQuery('reformulasi.export_ro_detail.iUji_mikro', 2);
		
		// QA sudah terima bahan baku sample
		$grid->setQuery('reformulasi.export_ro_detail_batch.iTerimaQa = 1', null);

		// sudah di uji mikro , tidak bisa dipilih lagi.
		$grid->setQuery('reformulasi.export_ro_detail.iexport_request_sample_detail not in (
																				select a.iexport_request_sample_detail
																				from reformulasi.export_uji_mikro_bb a 
																				where a.lDeleted=0
						) ', null);
		
		

		$grid->setInputGet('field',$this->_field);
		
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				echo $grid->saved_form();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'), true);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'getlaststock':
				$this->getlaststok();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }
	public function output(){
		$this->index($this->input->get('action'));
	}	
	


	function listBox_uji_mikro_bb_popup_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->export_request_sample__vRequest_no.'\',\''.$rowData->export_ro__vRo_no.'\',\''.$rowData->plc2_raw_material__vnama.'\',\''.$rowData->dossier_upd__vUpd_no.'\',\''.$rowData->dossier_upd__vNama_usulan.'\') ;" />';
		$o .='<script type="text/javascript">
		function pilih_upb_detail (id,reqno,recno,nmmatr,noupb,nmupb){		
			custom_confirm("Yakin ?", function(){
				//alert(recno);
				$("#'.$this->input->get('field').'_iexport_request_sample_detail").val(id);
				$("#'.$this->input->get('field').'_iexport_request_sample_detail_dis").val(reqno+" - "+nmmatr);
				$("#'.$this->input->get('field').'_no_ro").val(recno);
				$("#'.$this->input->get('field').'_no_upb").val(noupb+" - "+nmupb);
				


				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}

}