<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_soi_bb extends MX_Controller {
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
		$grid->setTitle('Browse SOI BB');
        $grid->setTable('reformulasi.export_req_refor');   

		$grid->setUrl('browse_soi_bb');
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

                // sudah ada BB yang draft soi
                 $grid->setQuery('export_req_refor`.`iexport_req_refor` in (
                                    SELECT export_req_refor.iexport_req_refor
                                     FROM `reformulasi`.`export_request_sample_detail`
                                     INNER JOIN `reformulasi`.`export_request_sample` ON `export_request_sample`.`iexport_request_sample` = `export_request_sample_detail`.`iexport_request_sample`
                                     INNER JOIN `reformulasi`.`export_ro_detail` ON `export_ro_detail`.`iexport_request_sample_detail` = `export_request_sample_detail`.`iexport_request_sample_detail`
                                     INNER JOIN `reformulasi`.`export_ro` ON `export_ro`.`iexport_ro` = `export_ro_detail`.`iexport_ro`
                                     INNER JOIN `plc2`.`plc2_raw_material` ON `plc2_raw_material`.`raw_id` = `export_request_sample_detail`.`raw_id`
                                     INNER JOIN `reformulasi`.`export_req_refor` ON `export_req_refor`.`iexport_req_refor` = `export_request_sample`.`iexport_req_refor`
                                     INNER JOIN `dossier`.`dossier_upd` ON `dossier_upd`.`idossier_upd_id` = `export_req_refor`.`idossier_upd_id`
                                     join reformulasi.export_draft_soi_bb a on a.iexport_ro_detail=export_ro_detail.iexport_ro_detail
                                     join hrd.employee b on b.cNip=a.cPic_penyusun
                                     WHERE 
                                     a.lDeleted=0
                                     and a.iApprove = 2
                        ) ', null); 

               

                // belum pernah ada pada soi BB
                $grid->setQuery('export_req_refor.iexport_req_refor not in (
                                    select a.iexport_req_refor 
                                    from reformulasi.export_soi_bb a
                                    where a.lDeleted=0

                                ) ', null);


        //Grid Harus Mengulang Trial
        /*$grid->setQuery('export_req_refor.iexport_req_refor NOT IN (SELECT e.`iexport_req_refor` FROM reformulasi.`export_refor_formula` 
            e WHERE e.iflag_open = 1 AND e.iflag_open_app = 1 AND e.`lDeleted` = 0 )', null);*/ 
         
        
       

        $grid->setQuery('iSubmitPD',1);
        $grid->setQuery('export_req_refor.lDeleted',0);
 
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

    function dt_upload(){
        $iexport_req_refor = $this->input->post('iexport_req_refor');
        $sq_all='SELECT * FROM reformulasi.`export_req_refor_file` lf WHERE lf.lDeleted = 0 AND 
                lf.iexport_req_refor = "'.$iexport_req_refor.'"'; 
        $data['sq_all'] = $this->db->query($sq_all)->result_array();  
        echo $this->load->view('export/export_refor_skala_trial_ref_file',$data,TRUE);
    }

    

	function listBox_browse_soi_bb_pilih($value, $pk, $name, $rowData) {   
        $url_ = base_url().'processor/reformulasi/browse/skala/trial/export?action=dt_upload';

        $itname = "SELECT i.`c_itnam` , d.vUpd_no FROM sales.`itemas` i JOIN `dossier`.`dossier_upd` d ON d.`iupb_id` = i.`c_iteno`
            WHERE d.`idossier_upd_id` =  '".$rowData->idossier_upd_id."'";
        $c_itnam = $this->db->Query($itname)->row_array();
        if(empty($c_itnam['c_itnam'])){
            $c_itnam['c_itnam'] = '-';
        }

        $vn = "SELECT e.`vName` FROM hrd.`employee` e WHERE e.`cNip` = '".$rowData->cInisiator_export."'";
                $_cInisiator = $this->db->query($vn)->row_array();
        if(empty($_cInisiator['vName'])){
            $_cInisiator['vName'] = '-';
        }

        $dp = "SELECT m.`vDescription` FROM  hrd.`msdepartement` m  
                WHERE m.`iDeptID` = '".$rowData->iDapartemen_export."'";
        $_cdapart = $this->db->query($dp)->row_array();
        if(empty($_cdapart['vDescription'])){
            $_cdapart['vDescription'] = '-';
        }

        $ap = "SELECT e.`vName` FROM hrd.`employee` e WHERE e.`cNip` = '".$rowData->cApproval_ats_inisiator."'";
        $app = $this->db->query($ap)->row_array();
        if($rowData->iApproval_ats_inisiator==2){
            if(empty($app['vName'])){
                $app['vName'] = 'Approved'.' Tgl '.$rowData->dApproval_ats_inisiator;
            }else{ 
                $app['vName'] = 'Approved by '.$app['vName'].' Tgl '.$rowData->dApproval_ats_inisiator;
            }
        }else if($rowData->iApproval_ats_inisiator==1){
            if(empty($app['vName'])){
                $app['vName'] = 'Rejected'.' Tgl '.$rowData->dApproval_ats_inisiator;
            }else{ 
                $app['vName'] = 'Rejected by '.$app['vName'].' Tgl '.$rowData->dApproval_ats_inisiator;
            }
        }else{
            $app['vName'] = 'Waiting Approval';
        }

        $for = "SELECT e.`vName` FROM hrd.`employee` e WHERE e.`cNip` = '".$rowData->cPicFormulator."'";
        $formu = $this->db->query($for)->row_array();
        if(empty($formu['vName'])){
            $formu['vName'] = '-';
        }

        $pd = "SELECT r.vteam FROM reformulasi.`reformulasi_team` r WHERE r.ldeleted=0 AND r.ireformulasi_team= '".$rowData->iTeamPD."'";
        $c_pd = $this->db->Query($pd)->row_array();
        if(empty($c_pd['vteam'])){
            $c_pd['vteam'] = '-';
        }

        
        $noandname = $c_itnam['vUpd_no'].' - '.$c_itnam['c_itnam'];
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.', \''.$rowData->vno_export_req_refor.'\' ,
            \''.$_cInisiator['vName'].'\',\''.$_cdapart['vDescription'].'\',\''.str_replace("'", "",str_replace('"', '', $rowData->tAlasan_export)).'\',
            \''.$rowData->dPermintaan_req_export.'\',\''.$app['vName'].'\',\''.$rowData->cPicFormulator.'\',\''.$formu['vName'].'\',\''.$c_pd['vteam'].'\',\''.$noandname.'\') ;" />
			  <script type="text/javascript">
				function pilih_upb_detail (id, vno_export_req_refor,_cInisiator,_cdapart,vAlasan_refor,dPermintaan_req_export,_iStatus,cPicFormulator,_cFormulator,_iteam_pd,_cIteno){					
					custom_confirm("Yakin ?", function(){
    					$(".'.$this->input->get('field').'_vno_export_req_refor").val(vno_export_req_refor); 
                        $(".'.$this->input->get('field').'_iexport_req_refor").val(id);    
                        $(".'.$this->input->get('field').'_cInisiator").text(_cInisiator);   
                        $(".'.$this->input->get('field').'_cdapart").text(_cdapart);  
                        $(".'.$this->input->get('field').'_vAlasan_refor").text(vAlasan_refor); 
                        $(".'.$this->input->get('field').'_iStatus").text(_iStatus);    
                        $(".'.$this->input->get('field').'_dRequest").text(dPermintaan_req_export);
                        $(".'.$this->input->get('field').'_cFormulator").text(_cFormulator);  
                        $(".'.$this->input->get('field').'_iTeamPD").text(_iteam_pd); 
                        $(".'.$this->input->get('field').'_cIteno").text(_cIteno);  

                        $(".'.$this->input->get('field').'_cpic_skala_trial").val(cPicFormulator);  
                        $(".'.$this->input->get('field').'_cpic_skala_trial_").val(_cFormulator);  

                        

                        
						$("#alert_dialog_form").dialog("destroy");
					});
				}
			  </script>';
		return $o;
	}
}
