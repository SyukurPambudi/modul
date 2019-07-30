<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_export_uji_mikro_fg extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
        $this->load->library('auth_export');
        $this->user = $this->auth_export->user();
        $this->arrEmployee = array(); 
        $this->arrEmployeeUpper = array();

		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Formula');
        $grid->setTable('reformulasi.export_refor_formula');   	
		$grid->setUrl('browse_export_uji_mikro_fg');
		$grid->addList('pilih','vnoFormulasi','export_req_refor.vno_export_req_refor','dossier_upd.vNama_usulan'); 
        $grid->setSortBy('vnoFormulasi');
        $grid->setSortOrder('asc');  

		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setWidth('pilih', '50');
		$grid->setAlign('pilih', 'center');
		$grid->setSearch('vnoFormulasi');

		$grid->setWidth('vnoFormulasi', '250');
        $grid->setAlign('vnoFormulasi', 'left');
        $grid->setLabel('vnoFormulasi','No Formulasi');

        $grid->setWidth('export_req_refor.vno_export_req_refor', '100');
        $grid->setAlign('export_req_refor.vno_export_req_refor', 'left');
        $grid->setLabel('export_req_refor.vno_export_req_refor','No Request');


        $grid->setWidth('dossier_upd.vNama_usulan', '250');
        $grid->setAlign('dossier_upd.vNama_usulan', 'left');
        $grid->setLabel('dossier_upd.vNama_usulan','Nama Usulan');

        $grid->setJoinTable('reformulasi.export_req_refor', 'export_req_refor.iexport_req_refor=reformulasi.export_refor_formula.iexport_req_refor', 'inner');
        $grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id=reformulasi.export_req_refor.idossier_upd_id', 'inner');


        //Validasi
        $grid->setQuery('dossier_upd.lDeleted', 0);
        $grid->setQuery('export_req_refor.lDeleted', 0);
        $grid->setQuery('export_refor_formula.lDeleted', 0);
        $grid->setQuery('export_refor_formula.iksm_skala_trial', 1); //MS

        /*$grid->setQuery('(case when export_refor_formula.isStressTest=0 and export_refor_formula.isScaleUp=0 then
								export_refor_formula.iappd_trial = 2
							else
								export_refor_formula.iappd_up =  2
						end)', NULL); //Untuk Formula Skala Trial dan Formula Skala Lab*/
        
        $grid->setQuery('export_refor_formula.iexport_refor_formula not in (select iexport_refor_formula from reformulasi.export_uji_mikro_fg where ldeleted=0)', NULL);

        /*Uji Mikro Pada Stury Literatur*/
        $grid->setQuery('export_refor_formula.iexport_req_refor in (select iexport_req_refor from reformulasi.export_refor_studi_literatur_ad where lDeleted=0 and isubmitAd=1 and iUjiMikrofg=1)', NULL);
 
        $grid->setSortOrder('DESC');  

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

	function listBox_browse_export_uji_mikro_fg_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_request('.$pk.',\''.$rowData->vnoFormulasi.'\',\''.$rowData->export_req_refor__vno_export_req_refor.'\',\''.$rowData->dossier_upd__vNama_usulan.'\') ;" />';
		$o.='<script type="text/javascript">
                function pilih_request (id, vnoformulasi, vno_export_req_refor, vNama_usulan){	
					custom_confirm("Yakin ?", function(){
						$("#'.$this->input->get('field').'_iexport_refor_formula_dis").val(vnoformulasi); 
                        $("#'.$this->input->get('field').'_iexport_refor_formula").val(id); 
                        $("#'.$this->input->get('field').'_vNo_req_refor").val(vno_export_req_refor); 
                        $("#'.$this->input->get('field').'_vNama_usulan").val(vNama_usulan); 
						$("#alert_dialog_form").dialog("destroy");
					});
				}</script>';
		return $o;
	}
}
