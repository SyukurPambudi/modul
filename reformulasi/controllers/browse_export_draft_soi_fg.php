<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_export_draft_soi_fg extends MX_Controller {
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
		$grid->setUrl('browse_export_draft_soi_fg');
		$grid->addList('pilih','vnoFormulasi','export_req_refor.vno_export_req_refor','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','export_req_refor.iTeamPD','export_req_refor.iTeamAndev'); 
        $grid->setSortBy('vnoFormulasi');
        $grid->setSortOrder('asc');  

		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setWidth('pilih', '50');
		$grid->setAlign('pilih', 'center');
		$grid->setSearch('vnoFormulasi');

		$grid->setWidth('vnoFormulasi', '100');
        $grid->setAlign('vnoFormulasi', 'left');
        $grid->setLabel('vnoFormulasi','No Formulasi');

        $grid->setWidth('export_req_refor.vno_export_req_refor', '100');
        $grid->setAlign('export_req_refor.vno_export_req_refor', 'left');
        $grid->setLabel('export_req_refor.vno_export_req_refor','No Request');

        $grid->setWidth('export_req_refor.iTeamPD', '100');
        $grid->setAlign('export_req_refor.iTeamPD', 'left');
        $grid->setLabel('export_req_refor.iTeamPD','Team PD'); 

        $grid->setWidth('export_req_refor.iTeamAndev', '100');
        $grid->setAlign('export_req_refor.iTeamAndev', 'left');
        $grid->setLabel('export_req_refor.iTeamAndev','Team Andev'); 


        $grid->setWidth('dossier_upd.vUpd_no', '100');
        $grid->setAlign('dossier_upd.vUpd_no', 'left');
        $grid->setLabel('dossier_upd.vUpd_no','Nomor UPD');


        $grid->setWidth('dossier_upd.vNama_usulan', '250');
        $grid->setAlign('dossier_upd.vNama_usulan', 'left');
        $grid->setLabel('dossier_upd.vNama_usulan','Nama Usulan');

        $grid->setJoinTable('reformulasi.export_req_refor', 'export_req_refor.iexport_req_refor=reformulasi.export_refor_formula.iexport_req_refor', 'inner');
        $grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id=reformulasi.export_req_refor.idossier_upd_id', 'inner');

        /*Validasi untuk module MOA*/
        $grid->setQuery('dossier_upd.ldeleted',0);
        $grid->setQuery('export_refor_formula.ldeleted',0);
        $grid->setQuery('export_req_refor.ldeleted',0);

        $grid->setQuery('export_req_refor.iexport_req_refor in (select iexport_req_refor from reformulasi.export_refor_validasi_moa where ldeleted=0 and iaprove=2)',NULL);
        $grid->setQuery('export_refor_formula.iexport_refor_formula not in (select iexport_refor_formula from reformulasi.export_draft_soi_fg where ldeleted=0)',NULL);

        /*Yang Sudah Best Formula*/
        $grid->setQuery('export_refor_formula.iexport_refor_formula in (select iexport_refor_formula from reformulasi.export_refor_best_formula where ldeleted=0 and iapproveBest=2)',NULL);

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

    function listBox_browse_export_draft_soi_fg_export_req_refor_iTeamPD($value, $pk, $name, $rowData) {
        return $this->getTeamByID($value);
    }
    function listBox_browse_export_draft_soi_fg_export_req_refor_iTeamAndev($value, $pk, $name, $rowData) {
        return $this->getTeamByID($value);
    }

	function listBox_browse_export_draft_soi_fg_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_request('.$pk.',\''.$rowData->vnoFormulasi.'\',\''.$rowData->export_req_refor__vno_export_req_refor.'\',\''.$rowData->dossier_upd__vNama_usulan.'\',\''.$this->getTeamByID($rowData->export_req_refor__iTeamPD).'\',\''.$rowData->dossier_upd__vUpd_no.'\',\''.$rowData->export_req_refor__iTeamAndev.'\') ;" />';
		$o.='<script type="text/javascript">
                function pilih_request (id, vnoformulasi, vno_export_req_refor, vNama_usulan,iTeamPD,vUpd_no,iTeamAndev){	
					custom_confirm("Yakin ?", function(){
						$("#'.$this->input->get('field').'_iexport_refor_formula_dis").val(vnoformulasi); 
                        $("#'.$this->input->get('field').'_iexport_refor_formula").val(id); 
                        $("#'.$this->input->get('field').'_vNama_usulan").val(vNama_usulan); 
                        $("#'.$this->input->get('field').'_vUpd_no").val(vUpd_no); 
                        $("#'.$this->input->get('field').'_vno_export_req_refor").val(vno_export_req_refor); 
                        $("#'.$this->input->get('field').'_iTeamPD").val(iTeamPD); 
                        $("#'.$this->input->get('field').'_iteamad").val(iTeamAndev); 
                        $("#export_draft_soi_fg_cpic_penyusun_text").removeAttr("disabled");
						$("#alert_dialog_form").dialog("destroy");
					});
				}</script>';
		return $o;
	}

    function getTeamByID($id=0){
        $sql='select * from reformulasi.reformulasi_team t where t.ldeleted=0 and t.ireformulasi_team='.$id;
        $qr=$this->db->query($sql);
        $ret="-";
        if($qr->num_rows()>=1){
            $row=$qr->row_array();
            $ret=isset($row['vteam'])?$row['vteam']:'-';
        }
        return $ret;
    }
}
