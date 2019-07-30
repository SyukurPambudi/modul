<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class uji_mikro_bb_popup extends MX_Controller {
	private $sess_auth_localnon;
	private $dbset;
	private $_id = 0;
	private $_iDeptId = 0;
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
        $this->sess_auth_localnon = new Zend_Session_Namespace('auth_localnon');
        $this->dbset = $this->load->database('plc', true);  
		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
    	$action = $this->input->get('action');
		
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('Bahan Baku');		
		$grid->setTable('plc2.plc2_upb_request_sample_detail');		
		$grid->setUrl('uji_mikro_bb_popup');
		$grid->addList('pilih','plc2_upb_request_sample.vreq_nomor','plc2_upb_po.vpo_nomor','plc2_upb_ro.vro_nomor','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_raw_material.vnama','ijumlah');
		$grid->setSortBy('ireqdet_id');
		$grid->setSortOrder('ASC'); //sort ordernya
		

		$grid->setLabel('plc2_upb_request_sample.vreq_nomor', 'Nomor Request'); //Ganti Label
        $grid->setAlign('plc2_upb_request_sample.vreq_nomor', 'center'); //Align nya
        $grid->setWidth('plc2_upb_request_sample.vreq_nomor', '80'); // width nya      

        $grid->setLabel('plc2_upb_po.vpo_nomor', 'No PO'); //Ganti Label
        $grid->setAlign('plc2_upb_po.vpo_nomor', 'center'); //Align nya
        $grid->setWidth('plc2_upb_po.vpo_nomor', '80'); // width nya  

        $grid->setLabel('plc2_upb_ro.vro_nomor', 'No Penerimaan'); //Ganti Label
        $grid->setAlign('plc2_upb_ro.vro_nomor', 'center'); //Align nya
        $grid->setWidth('plc2_upb_ro.vro_nomor', '80'); // width nya  


        $grid->setLabel('plc2_raw_material.vnama', 'Nama Bahan baku'); //Ganti Label
        $grid->setAlign('plc2_raw_material.vnama', 'left'); //Align nya
        $grid->setWidth('plc2_raw_material.vnama', '200'); // width nya  

        $grid->setLabel('plc2_upb.vupb_nomor', 'No UPB'); //Ganti Label
        $grid->setAlign('plc2_upb.vupb_nomor', 'center'); //Align nya
        $grid->setWidth('plc2_upb.vupb_nomor', '50'); // width nya  

        $grid->setLabel('plc2_upb.vupb_nama', 'Nama UPB'); //Ganti Label
        $grid->setAlign('plc2_upb.vupb_nama', 'left'); //Align nya
        $grid->setWidth('plc2_upb.vupb_nama', '200'); // width nya  


        $grid->setLabel('ijumlah', 'Jumlah'); //Ganti Label
        $grid->setAlign('ijumlah', 'left'); //Align nya
        $grid->setWidth('ijumlah', '50'); // width nya  
       
       	$grid->setWidth('pilih', '25'); // width nya  
		$grid->setAlign('pilih', 'center'); //Align nya

		$grid->addFields('cNip', 'vName', 'pilih');
		$grid->setSearch('plc2_upb_request_sample.vreq_nomor','plc2_upb_po.vpo_nomor','plc2_upb_ro.vro_nomor','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_raw_material.vnama');
		
		$grid->setJoinTable('plc2.plc2_upb_request_sample', 'plc2_upb_request_sample.ireq_id = plc2_upb_request_sample_detail.ireq_id', 'inner');
        $grid->setJoinTable('plc2.plc2_upb_ro_detail', 'plc2_upb_ro_detail.ireq_id = plc2_upb_request_sample_detail.ireq_id and plc2_upb_ro_detail.raw_id = plc2_upb_request_sample_detail.raw_id  ' , 'inner');
        $grid->setJoinTable('plc2.plc2_upb_po', 'plc2_upb_po.ipo_id = plc2_upb_ro_detail.ipo_id', 'inner');
        $grid->setJoinTable('plc2.plc2_upb_ro', 'plc2_upb_ro.iro_id = plc2_upb_ro_detail.iro_id', 'inner');
        $grid->setJoinTable('plc2.plc2_raw_material', 'plc2_raw_material.raw_id = plc2_upb_request_sample_detail.raw_id', 'inner');
        $grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = plc2_upb_request_sample.iupb_id', 'inner');

		//membutuhkan uji mikro 
		$grid->setQuery('plc2.plc2_upb_ro_detail.iUjiMikro_bb', 1);
		// QA sudah terima bahan baku sample
		$grid->setQuery('plc2.plc2_upb_ro_detail.trec_date_qa is not null', null);
		
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/
		

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
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->plc2_upb_request_sample__vreq_nomor.'\',\''.$rowData->plc2_upb_po__vpo_nomor.'\',\''.$rowData->plc2_upb_ro__vro_nomor.'\',\''.$rowData->plc2_raw_material__vnama.'\',\''.$rowData->plc2_upb__vupb_nomor.'\',\''.$rowData->plc2_upb__vupb_nama.'\') ;" />';
		$o .='<script type="text/javascript">
		function pilih_upb_detail (id, reqno,pono,recno,nmmatr,noupb,nmupb){		
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_ireqdet_id").val(id);
				$("#'.$this->input->get('field').'_ireqdet_id_dis").val(reqno+" - "+nmmatr);
				$("#'.$this->input->get('field').'_no_po").val(pono);
				$("#'.$this->input->get('field').'_no_upb").val(noupb+" - "+nmupb);
				


				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}

}