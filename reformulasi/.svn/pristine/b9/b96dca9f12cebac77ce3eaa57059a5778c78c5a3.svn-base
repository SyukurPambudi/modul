<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_basic_noformula extends MX_Controller {
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
		$grid->setTitle('No Formulasi Export');
        $grid->setTable('reformulasi.export_refor_formula');   

		$grid->setUrl('browse_basic_noformula');
        $grid->addList('pilih','vnoFormulasi','export_req_refor.vno_export_req_refor','dossier_upd.vUpd_no','itemas.c_iteno','dossier_upd.vNama_usulan'); 
        $grid->setSortBy('iexport_refor_formula'); 
        $grid->setSortOrder('asc');  

		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setWidth('pilih', '55');
		$grid->setAlign('pilih', 'center'); 

		 
                $grid->setWidth('itemas.c_iteno', '80');
                $grid->setAlign('itemas.c_iteno', 'left');
                $grid->setLabel('itemas.c_iteno','Kode Product');

                $grid->setWidth('iUjibe', '80');
                $grid->setAlign('iUjibe', 'left');
                $grid->setLabel('iUjibe','Perlu Uji BE ?');

                $grid->setWidth('insBB', '80');
                $grid->setAlign('insBB', 'left');
                $grid->setLabel('insBB','Permintaan Bahan Baku'); 

                $grid->setWidth('dossier_upd.vNama_usulan', '250');
                $grid->setAlign('dossier_upd.vNama_usulan', 'left');
                $grid->setLabel('dossier_upd.vNama_usulan','Nama Usulan Product'); 

                $grid->setWidth('export_req_refor.vno_export_req_refor', '100');
                $grid->setAlign('export_req_refor.vno_export_req_refor', 'left');
                $grid->setLabel('export_req_refor.vno_export_req_refor','No Request');

                $grid->setWidth('vnoFormulasi', '100');
                $grid->setAlign('vnoFormulasi', 'left');
                $grid->setLabel('vnoFormulasi','No Formula');
            
                $grid->setWidth('idossier_upd_id', '100');
                $grid->setAlign('idossier_upd_id', 'left');
                $grid->setLabel('idossier_upd_id','Nomor UPD');

                $grid->setWidth('dossier_upd.vUpd_no', '80');
                $grid->setAlign('dossier_upd.vUpd_no', 'left');
                $grid->setLabel('dossier_upd.vUpd_no','Nomor UPD');
 
                $grid->setWidth('cInisiator_export', '100');
                $grid->setAlign('cInisiator_export', 'left');
                $grid->setLabel('cInisiator_export','Nama Inisiator');
 
                $grid->setWidth('iDapartemen_export', '100');
                $grid->setAlign('iDapartemen_export', 'left');
                $grid->setLabel('iDapartemen_export','Dapartemen');
            
                $grid->setWidth('tAlasan_export', '100');
                $grid->setAlign('tAlasan_export', 'left');
                $grid->setLabel('tAlasan_export','Alasan Reformulasi');
            
                $grid->setWidth('dPermintaan_req_export', '100');
                $grid->setAlign('dPermintaan_req_export', 'left');
                $grid->setLabel('dPermintaan_req_export','Tanggal Permintaan Req Reformulasi');
            
                $grid->setWidth('dPermintaan_bb_export', '100');
                $grid->setAlign('dPermintaan_bb_export', 'left');
                $grid->setLabel('dPermintaan_bb_export','Tanggal Permintaaan Bahan Baku');

                $grid->setWidth('vUploadfile', '100');
                $grid->setAlign('vUploadfile', 'left');
                $grid->setLabel('vUploadfile','Upload File');
                 
                $grid->setWidth('iTeamPD', '100');
                $grid->setAlign('iTeamPD', 'left');
                $grid->setLabel('iTeamPD','Team PD');
            
                $grid->setWidth('iTeamAndev', '100');
                $grid->setAlign('iTeamAndev', 'left');
                $grid->setLabel('iTeamAndev','Team Andev');
            
                $grid->setWidth('iSubmit', '100');
                $grid->setAlign('iSubmit', 'left');
                $grid->setLabel('iSubmit','Status Submit');
            
                $grid->setWidth('cApproval_ats_inisiator', '100');
                $grid->setAlign('cApproval_ats_inisiator', 'left');
                $grid->setLabel('cApproval_ats_inisiator','CAPPROVAL_ATS_INISIATOR');
            
                $grid->setWidth('vRemark_ats_inisiator', '100');
                $grid->setAlign('vRemark_ats_inisiator', 'left');
                $grid->setLabel('vRemark_ats_inisiator','VREMARK_ATS_INISIATOR');
            
                $grid->setWidth('dApproval_ats_inisiator', '100');
                $grid->setAlign('dApproval_ats_inisiator', 'left');
                $grid->setLabel('dApproval_ats_inisiator','DAPPROVAL_ATS_INISIATOR');
            
                $grid->setWidth('iApproval_ats_inisiator', '150');
                $grid->setAlign('iApproval_ats_inisiator', 'left');
                $grid->setLabel('iApproval_ats_inisiator','Approval Atasan Inisiator');
            
                $grid->setWidth('dCreate', '100');
                $grid->setAlign('dCreate', 'left');
                $grid->setLabel('dCreate','DCREATE');
            
                $grid->setWidth('cCreated', '100');
                $grid->setAlign('cCreated', 'left');
                $grid->setLabel('cCreated','CCREATED');
            
                $grid->setWidth('dupdate', '100');
                $grid->setAlign('dupdate', 'left');
                $grid->setLabel('dupdate','DUPDATE');
            
                $grid->setWidth('cUpdate', '100');
                $grid->setAlign('cUpdate', 'left');
                $grid->setLabel('cUpdate','CUPDATE');
            
                $grid->setWidth('lDeleted', '100');
                $grid->setAlign('lDeleted', 'left');
                $grid->setLabel('lDeleted','LDELETED');
    
        $grid->setJoinTable('reformulasi.export_req_refor', 'export_req_refor.iexport_req_refor = export_refor_formula.iexport_req_refor', 'inner');
        $grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = export_req_refor.idossier_upd_id', 'inner');
        $grid->setJoinTable('sales.itemas', 'itemas.c_iteno = dossier_upd.iupb_id', 'inner'); 
        $grid->setSearch('vnoFormulasi','export_req_refor.vno_export_req_refor','dossier_upd.vUpd_no');  
        $grid->setQuery('export_refor_formula.lDeleted',0);
        $grid->setQuery('export_refor_formula.iexport_refor_formula IN(
                SELECT e.`iexport_refor_formula` FROM reformulasi.`export_refor_best_formula` e 
                WHERE e.`iapproveBest` = 2 AND e.`lDeleted` = 0 
                )',null);
        $grid->setQuery('export_refor_formula.iexport_refor_formula NOT IN(
                SELECT eb.`iexport_refor_formula` FROM reformulasi.`export_refor_basic_formula` eb WHERE eb.`lDeleted` = 0
                )',null);

        
 
        $grid->setSortOrder('DESC');  



		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;
            case 'dt_upload':
                $this->dt_upload();
                break;			
			default:
				$grid->render_grid();
				break;
		}
    }
      
	function output(){
    	$this->index($this->input->get('action'));//test komen
    }

    function listBox_browse_basic_noformula_pilih($value, $pk, $name, $rowData) {   
        $sqlDat = "SELECT er.`vno_export_req_refor`, du.`vUpd_no`, it.`c_itnam` FROM reformulasi.`export_req_refor` er 
            JOIN dossier.`dossier_upd` du ON du.`idossier_upd_id`  = er.`idossier_upd_id`
            JOIN sales.`itemas` it ON it.`c_iteno` = du.`iupb_id`
            WHERE er.`lDeleted` = 0 
            AND du.`lDeleted` = 0 
            AND it.`lDeleted` = 0
            AND er.`iexport_req_refor` = '".$rowData->iexport_req_refor."'";
        $dtOut = $this->db->query($sqlDat)->row_array();
        if(empty($dtOut['vno_export_req_refor'])){
            $dtOut['vno_export_req_refor'] = '-';
        }
        if(empty($dtOut['vUpd_no'])){
            $dtOut['vUpd_no'] = '-';
        }
        if(empty($dtOut['c_itnam'])){
            $dtOut['c_itnam'] = '-';
        }

        $o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.', \''.$rowData->vnoFormulasi.'\', \''.$dtOut['vno_export_req_refor'].'\', \''.$dtOut['vUpd_no'].'\', \''.$dtOut['c_itnam'].'\' ) ;" />
              <script type="text/javascript">
                function pilih_upb_detail (id, _vnoFormulasi,_vno_export_req_refor,_vUpd_no,_c_itnam){                  
                    custom_confirm("Yakin ?", function(){
                        $(".'.$this->input->get('field').'_iexport_refor_formula").val(id);  
                        $(".'.$this->input->get('field').'_vnoFormulasi").val(_vnoFormulasi);  
                        $(".'.$this->input->get('field').'_vno_export_req_refor").text(_vno_export_req_refor);    
                        $(".'.$this->input->get('field').'_vUpd_no").text(_vUpd_no);   
                        $(".'.$this->input->get('field').'_cIteno").text(_c_itnam);    
                        $("#alert_dialog_form").dialog("destroy");
                    });
                }
              </script>';
        return $o;
    }
 
}
