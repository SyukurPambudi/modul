<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_validasi_moa_export extends MX_Controller {
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
		$grid->setTitle('Request Reformulasi Export');
        $grid->setTable('reformulasi.export_req_refor');   

		$grid->setUrl('browse_validasi_moa_export');
        $grid->addList('pilih','vno_export_req_refor','dossier_upd.vUpd_no','itemas.c_iteno','dossier_upd.vNama_usulan','employee.vName'); 
        $grid->setSortBy('iexport_req_refor'); 
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

                $grid->setWidth('vno_export_req_refor', '100');
                $grid->setAlign('vno_export_req_refor', 'left');
                $grid->setLabel('vno_export_req_refor','No Request');
            
                $grid->setWidth('idossier_upd_id', '100');
                $grid->setAlign('idossier_upd_id', 'left');
                $grid->setLabel('idossier_upd_id','Nomor UPD');

                $grid->setWidth('dossier_upd.vUpd_no', '80');
                $grid->setAlign('dossier_upd.vUpd_no', 'left');
                $grid->setLabel('dossier_upd.vUpd_no','Nomor UPD');
 
                $grid->setWidth('cInisiator_export', '100');
                $grid->setAlign('cInisiator_export', 'left');
                $grid->setLabel('cInisiator_export','Nama Inisiator');

                $grid->setWidth('employee.vName', '250');
                $grid->setAlign('employee.vName', 'left');
                $grid->setLabel('employee.vName','Nama Inisiator');

                
            
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
    
        $grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = export_req_refor.idossier_upd_id', 'inner');
        $grid->setJoinTable('sales.itemas', 'itemas.c_iteno = dossier_upd.iupb_id', 'inner');
        $grid->setJoinTable('hrd.employee', 'employee.cNip = export_req_refor.cInisiator_export', 'inner'); 

        $grid->setSearch('vno_export_req_refor','dossier_upd.vUpd_no','employee.vName'); 
        $grid->setQuery('iSubmitPD',1);
        $grid->setQuery('export_req_refor.lDeleted',0);
        $grid->setQuery('`export_req_refor`.`iexport_req_refor` IN( 
                SELECT ef.`iexport_req_refor` FROM reformulasi.`export_refor_best_formula` e 
            JOIN reformulasi.`export_refor_formula` ef ON ef.`iexport_refor_formula` = e.`iexport_refor_formula`
            WHERE e.`iapproveBest` = 2 AND e.`lDeleted` = 0 
                )',null);
        $grid->setQuery('export_req_refor.iexport_req_refor NOT IN(SELECT em.`iexport_req_refor` FROM reformulasi.`export_refor_validasi_moa` em WHERE em.`isubmit` = 0)',null);
 
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
 

	function listBox_browse_validasi_moa_export_pilih($value, $pk, $name, $rowData) {   
        $url_ = base_url().'processor/reformulasi/browse/skala/trial/export?action=dt_upload';

        $itname = "SELECT i.`c_itnam`, d.vUpd_no, d.vNama_usulan FROM sales.`itemas` i JOIN `dossier`.`dossier_upd` d ON d.`iupb_id` = i.`c_iteno`
            WHERE d.`idossier_upd_id` =  '".$rowData->idossier_upd_id."'";
        $c_itnam = $this->db->Query($itname)->row_array();
        if(empty($c_itnam['c_itnam'])){
            $c_itnam['c_itnam'] = '-';
        } 
        if(empty($c_itnam['vUpd_no'])){
            $c_itnam['vUpd_no'] = '-';
        } 
        if(empty($c_itnam['vNama_usulan'])){
            $c_itnam['vNama_usulan'] = '-';
        } 

		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.', \''.$rowData->vno_export_req_refor.'\',\''.$c_itnam['vNama_usulan'].'\',\''.$c_itnam['vUpd_no'].'\',\''.$c_itnam['c_itnam'].'\') ;" />
			  <script type="text/javascript">
				function pilih_upb_detail (id, vno_export_req_refor,_vNama_usulan,_vUpd_no,_cIteno){					
					custom_confirm("Yakin ?", function(){
    					$(".'.$this->input->get('field').'_vno_export_req_refor").val(vno_export_req_refor); 
                        $(".'.$this->input->get('field').'_iexport_req_refor").val(id);    
                        $(".'.$this->input->get('field').'_vUpd_no").text(_vUpd_no);  
                        $(".'.$this->input->get('field').'_vNama_usulan").text(_vNama_usulan);    
                        $(".'.$this->input->get('field').'_cIteno").text(_cIteno);    
						$("#alert_dialog_form").dialog("destroy");
					});
				}
			  </script>';
		return $o;
	}
}
