<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_stress_test extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('auth_local');
        $this->user = $this->auth_local->user();
        $this->arrEmployee = array(); 
        $this->arrEmployeeUpper = array();
        $this->_field = $this->input->get('field');
    }
    function index($action = '') {
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;       
        $grid->setTitle('Request Reformulasi Local');
        $grid->setTable('reformulasi.local_req_refor');     
        $grid->setUrl('browse_stress_test');
        $grid->addList('pilih','vNo_req_refor','itemas.c_itnam','vBatch_no','dRequest'); 
        $grid->setSortBy('iLocal_req_refor');
        $grid->setSortOrder('asc');  

        $grid->setAlign('pilih', 'center');
        $grid->setInputGet('field',$this->_field);
        $grid->hideTitleCol('pilih');
        $grid->notSortCol('pilih');
        $grid->setWidth('pilih', '55');
        $grid->setAlign('pilih', 'center');
        $grid->setSearch('vBatch_no','itemas.c_itnam','vNo_req_refor');

        $grid->setWidth('vNo_req_refor', '150');
        $grid->setAlign('vNo_req_refor', 'center');
        $grid->setLabel('vNo_req_refor','No Request');
    
        $grid->setWidth('vNo_deviasi', '100');
        $grid->setAlign('vNo_deviasi', 'left');
        $grid->setLabel('vNo_deviasi','No Deviasi');
    
        $grid->setWidth('iNo_usulan', '100');
        $grid->setAlign('iNo_usulan', 'left');
        $grid->setLabel('iNo_usulan','No Usulan Produk');
    
        $grid->setWidth('iKey', '100');
        $grid->setAlign('iKey', 'center');
        $grid->setLabel('iKey','Jenis Refor');
    
        $grid->setWidth('vBatch_no', '100');
        $grid->setAlign('vBatch_no', 'center');
        $grid->setLabel('vBatch_no','No Batch');

        $grid->setWidth('cIteno', '300');
        $grid->setAlign('cIteno', 'center');
        $grid->setLabel('cIteno','Nama Produk');
    
        $grid->setWidth('cInisiator', '200');
        $grid->setAlign('cInisiator', 'left');
        $grid->setLabel('cInisiator','Nama Inisiator');
    
        $grid->setWidth('idept_id', '100');
        $grid->setAlign('idept_id', 'left');
        $grid->setLabel('idept_id','Departement');
    
        $grid->setWidth('dRequest', '100');
        $grid->setAlign('dRequest', 'left');
        $grid->setLabel('dRequest','Tgl Request');
    
        $grid->setWidth('vAlasan_refor', '200');
        $grid->setAlign('vAlasan_refor', 'left');
        $grid->setLabel('vAlasan_refor','Alasan Refor');
    
        $grid->setWidth('iteam_pd', '100');
        $grid->setAlign('iteam_pd', 'left');
        $grid->setLabel('iteam_pd','Team PD');
    
        $grid->setWidth('iStatus', '100');
        $grid->setAlign('iStatus', 'center');
        $grid->setLabel('iStatus','Status Approval');
    
        $grid->setWidth('iSubmit', '100');
        $grid->setAlign('iSubmit', 'center');
        $grid->setLabel('iSubmit','Status Submit');

        $grid->setWidth('iStatus_proses', '200');
        $grid->setAlign('iStatus_proses', 'center');
        $grid->setLabel('iStatus_proses','Current Proses'); 
    
        $grid->setWidth('cApproved', '100');
        $grid->setAlign('cApproved', 'left');
        $grid->setLabel('cApproved','CAPPROVED');
    
        $grid->setWidth('vreason_approved', '100');
        $grid->setAlign('vreason_approved', 'left');
        $grid->setLabel('vreason_approved','VREASON_APPROVED');
    
        $grid->setWidth('cformulator', '100');
        $grid->setAlign('cformulator', 'left');
        $grid->setLabel('cformulator','CFORMULATOR');
    
        $grid->setWidth('istatus_terima_req', '100');
        $grid->setAlign('istatus_terima_req', 'left');
        $grid->setLabel('istatus_terima_req','ISTATUS_TERIMA_REQ');
    
        $grid->setWidth('cApproved_terima', '100');
        $grid->setAlign('cApproved_terima', 'left');
        $grid->setLabel('cApproved_terima','CAPPROVED_TERIMA');
    
        $grid->setWidth('dApproved_terima', '100');
        $grid->setAlign('dApproved_terima', 'left');
        $grid->setLabel('dApproved_terima','DAPPROVED_TERIMA');
    
        $grid->setWidth('vreason_terima', '100');
        $grid->setAlign('vreason_terima', 'left');
        $grid->setLabel('vreason_terima','Keterangan');
    
        $grid->setWidth('dTgl_rev_mbr', '100');
        $grid->setAlign('dTgl_rev_mbr', 'left');
        $grid->setLabel('dTgl_rev_mbr','DTGL_REV_MBR');
    
        $grid->setWidth('vNo_cc', '100');
        $grid->setAlign('vNo_cc', 'left');
        $grid->setLabel('vNo_cc','VNO_CC');
    
        $grid->setWidth('dPengajuan_cc', '100');
        $grid->setAlign('dPengajuan_cc', 'left');
        $grid->setLabel('dPengajuan_cc','DPENGAJUAN_CC');
    
        $grid->setWidth('iStatus_cc', '100');
        $grid->setAlign('iStatus_cc', 'left');
        $grid->setLabel('iStatus_cc','ISTATUS_CC');
    
        $grid->setWidth('dApproved_cc', '100');
        $grid->setAlign('dApproved_cc', 'left');
        $grid->setLabel('dApproved_cc','DAPPROVED_CC');
    
        $grid->setWidth('cApproved_cc', '100');
        $grid->setAlign('cApproved_cc', 'left');
        $grid->setLabel('cApproved_cc','CAPPROVED_CC');
    
        $grid->setWidth('dUji_BE', '100');
        $grid->setAlign('dUji_BE', 'left');
        $grid->setLabel('dUji_BE','DUJI_BE');
    
        $grid->setWidth('dSelesai_uji_BE', '100');
        $grid->setAlign('dSelesai_uji_BE', 'left');
        $grid->setLabel('dSelesai_uji_BE','DSELESAI_UJI_BE');
    
        $grid->setWidth('vNo_hasil_uji_BE', '100');
        $grid->setAlign('vNo_hasil_uji_BE', 'left');
        $grid->setLabel('vNo_hasil_uji_BE','VNO_HASIL_UJI_BE');
    
        $grid->setWidth('vHasil_uji_BE', '100');
        $grid->setAlign('vHasil_uji_BE', 'left');
        $grid->setLabel('vHasil_uji_BE','VHASIL_UJI_BE');
    
        $grid->setWidth('iStatus_uji_BE', '100');
        $grid->setAlign('iStatus_uji_BE', 'left');
        $grid->setLabel('iStatus_uji_BE','ISTATUS_UJI_BE');
    
        $grid->setWidth('dApproved_uji_BE', '100');
        $grid->setAlign('dApproved_uji_BE', 'left');
        $grid->setLabel('dApproved_uji_BE','DAPPROVED_UJI_BE');
    
        $grid->setWidth('cApproved_uji_BE', '100');
        $grid->setAlign('cApproved_uji_BE', 'left');
        $grid->setLabel('cApproved_uji_BE','CAPPROVED_UJI_BE');
    
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

        $grid->setWidth('itemas.c_itnam', '150');
        $grid->setAlign('itemas.c_itnam', 'left');
        $grid->setLabel('itemas.c_itnam','Nama Product');
    
        $grid->setJoinTable('sales.itemas', 'itemas.c_iteno = local_req_refor.cIteno', 'inner');

        //Cek Maping Stress Test
        $grid->setJoinTable('reformulasi.lokal_mapping_refor', 'lokal_mapping_refor.iLocal_req_refor = local_req_refor.iLocal_req_refor', 'inner');
       
        #Cek Maping
        $grid->setQuery('IF(`lokal_mapping_refor`.`imaster_proses_refor`=3,
             #Cek Melewati Skala Trial
             IF((SELECT COUNT(lm.`ilokal_mapping_refor`) AS ck_skl_trial FROM reformulasi.`lokal_mapping_refor` lm WHERE lm.`lDeleted` = 0 
             AND lm.`imaster_proses_refor` = 4 AND lm.`iLocal_req_refor` = `local_req_refor`.`iLocal_req_refor`)>0,
                 
                 #Kalo iya Harus Approve dan MS
                 (SELECT COUNT(ls.iLocal_req_refor) FROM reformulasi.`lokal_refor_skala_trial` ls WHERE ls.`lDeleted` = 0 AND 
                    ls.iksm_skala_trial = 1 AND ls.iflag_open=0 AND ls.`iappd` = 2 AND ls.`iLocal_req_refor` = `local_req_refor`.`iLocal_req_refor`)>0,

                 #Kalo Tidak Cek Melewati literatur
                 IF((SELECT COUNT(lm.`ilokal_mapping_refor`) AS ck_skl_trial FROM reformulasi.`lokal_mapping_refor` lm WHERE lm.`lDeleted` = 0 
                 AND lm.`imaster_proses_refor` = 1 AND lm.`iLocal_req_refor` = `local_req_refor`.`iLocal_req_refor`)>0,

                    #Kalo Iya Literatur Harus Approve
                    (SELECT COUNT(p.`iLocal_req_refor`) AS stdliteratur FROM `reformulasi`.`lokal_refor_study_literatur_pd` p WHERE 
                    p.`ldeleted` = 0 AND p.`iapppd` = 2 AND p.`iLocal_req_refor` =`local_req_refor`.`iLocal_req_refor`)>0,
                    
                    #Kalo Tidak Kembali ke Kondisi Awal Tanpa Pengecakan
                     `lokal_mapping_refor`.`imaster_proses_refor`=3)),
              
              #Kalo Tidak Kembali ke Kondisi Awal Tanpa Pengecakan
             `lokal_mapping_refor`.`imaster_proses_refor`=3)  ', null); 
        
        #cek Ketersediaan Data
        $grid->setQuery('local_req_refor.iLocal_req_refor NOT IN(
            SELECT rl.`iLocal_req_refor` FROM reformulasi.`lokal_refor_stress_test` rl WHERE 
            rl.`iLocal_req_refor` = local_req_refor.iLocal_req_refor
            AND IF(rl.`iappd`=2,IF(rl.`iksm_stress_test`=0,rl.`iksm_stress_test`=1,rl.`lDeleted`=0),rl.`lDeleted`=0) 
            AND rl.`lDeleted` = 0 AND rl.`iflag_open` = 0)',null);

        #Only Formulator
       if($this->auth_local->is_manager()){
            $x=$this->auth_local->dept();
            $manager=$x['manager'];
            if(in_array('PD', $manager)){
                $type='PD';
                $grid->setQuery('local_req_refor.iteam_pd IN ('.$this->auth_local->my_teams().')', null); 
            }
            else{$type='';}
        }
        else{
            $x=$this->auth_local->dept();
            $team=$x['team'];
            if(in_array('PD', $team)){
                $type='PD';
                $grid->setQuery('local_req_refor.iteam_pd IN ('.$this->auth_local->my_teams().')', null);  
                $grid->setQuery('(local_req_refor.cFormulator = "'.$this->user->gNIP.'") ', null); 

            }
            else{$type='';}
        }
        #Status Delet dan Submit
        $grid->setQuery('isubmit_maping',1);
        $grid->setQuery('local_req_refor.lDeleted',0);
        
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

    function _child ($nip){ 
        $sql = "SELECT cNip, vName 
                    FROM hrd.employee 
                    WHERE cUpper = '$nip' 
                    AND dresign = '0000-00-00'
                    ORDER BY vName ASC";
        $dt_cek = $this->db->query($sql)->result_array();     
        if(!empty($dt_cek)){ 
            foreach($dt_cek as $x){
                $isi['nip'] = $x['cNip'];
                $isi['name'] = $x['vName'];
                array_push($this->arrEmployee, $isi);
                $this->_child($x['cNip']);
            } 
        } 
    }

    function _upper ($nip){ 
        $sql = "SELECT cUpper, vName 
                    FROM hrd.employee a
                    join hrd.position b on b.iPostID=a.iPostID
                    WHERE a.cNip = '$nip' 
                    AND a.dresign = '0000-00-00'
                    and b.iLvlemp <= 6
                    ORDER BY vName ASC";
        $dt_cek = $this->db->query($sql)->result_array();     
        if(!empty($dt_cek)){ 
            foreach($dt_cek as $x){
                $isi['nip'] = $x['cUpper'];
                array_push($this->arrEmployeeUpper, $isi);
                $this->_upper($x['cUpper']);
            } 
        } 
    }

    function output(){
        $this->index($this->input->get('action'));//test komen
    }

    function dt_upload(){
        $iLocal_req_refor = $this->input->post('iLocal_req_refor');
        $sq_all='SELECT * FROM reformulasi.`local_req_refor_file` lf WHERE lf.lDeleted = 0 AND 
                lf.iLocal_req_refor = "'.$iLocal_req_refor.'"'; 
        $data['sq_all'] = $this->db->query($sq_all)->result_array();  
        echo $this->load->view('local/lokal_skala_trial_ref_file',$data,TRUE);
    }

    

    function listBox_browse_stress_test_pilih($value, $pk, $name, $rowData) {
        $url_ = base_url().'processor/reformulasi/browse/skala/trial?action=dt_upload';

        $itname = "SELECT i.`c_itnam` FROM sales.`itemas` i WHERE i.`lDeleted` = 0 AND i.`c_iteno` = '".$rowData->cIteno."'";
        $c_itnam = $this->db->Query($itname)->row_array();
        if(empty($c_itnam['c_itnam'])){
            $c_itnam['c_itnam'] = '-';
        }

        $vn = "SELECT e.`vName` FROM hrd.`employee` e WHERE e.`cNip` = '".$rowData->cInisiator."'";
                $vName = $this->db->query($vn)->row_array();
        if(empty($vName['vName'])){
            $vName['vName'] = '-';
        }

        $dp = "SELECT e.`vName`, m.`vDescription` FROM hrd.`employee` e 
                        JOIN hrd.`msdepartement` m ON m.`iDeptID` = e.`iDepartementID` 
                        WHERE e.`cNip` = '".$rowData->cInisiator."'";
        $cdapart = $this->db->query($dp)->row_array();
        if(empty($cdapart['vDescription'])){
            $cdapart['vDescription'] = '-';
        }

        $pd = "SELECT r.vteam FROM reformulasi.`reformulasi_team` r WHERE r.ldeleted=0 AND r.ireformulasi_team= '".$rowData->iteam_pd."'";
        $c_pd = $this->db->Query($pd)->row_array();
        if(empty($c_pd['vteam'])){
            $c_pd['vteam'] = '-';
        }

        $ap = "SELECT e.`vName` FROM hrd.`employee` e WHERE e.`cNip` = '".$rowData->cApproval."'";
        $app = $this->db->query($ap)->row_array();
        if($rowData->iStatus==2){
            if(empty($app['vName'])){
                $app['vName'] = 'Approved'.' Tgl '.$rowData->dApproval;
            }else{ 
                $app['vName'] = 'Approved by '.$app['vName'].' Tgl '.$rowData->dApproval;
            }
        }else if($rowData->iStatus==1){
            if(empty($app['vName'])){
                $app['vName'] = 'Rejected'.' Tgl '.$rowData->dApproval;
            }else{ 
                $app['vName'] = 'Rejected by '.$app['vName'].' Tgl '.$rowData->dApproval;
            }
        }else{
            $app['vName'] = 'Waiting Approval';
        }

        $for = "SELECT e.`vName` FROM hrd.`employee` e WHERE e.`cNip` = '".$rowData->cFormulator."'";
        $formu = $this->db->query($for)->row_array();
        if(empty($formu['vName'])){
            $formu['vName'] = '-';
        }

        $nofu = "SELECT ls.`vnoFormulasi` FROM reformulasi.`lokal_refor_skala_trial` ls WHERE ls.`lDeleted` = 0 
            AND ls.`iappd` = 2 AND ls.`iksm_skala_trial` = 1 AND ls.`iLocal_req_refor` =  '".$pk."' AND ls.iflag_open = 0 
            ORDER BY ls.`ilokal_refor_skala_trial` DESC";
        $nofur = $this->db->query($nofu)->row_array();
        if(empty($nofur['vnoFormulasi'])){
            $nofur['vnoFormulasi'] = '-';
        }


        $o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->cIteno.'\',
                \''.$rowData->vNo_req_refor.'\',\''.$rowData->vBatch_no.'\',
                \''.str_replace("'", "",str_replace('"', '', $rowData->vAlasan_refor)).'\',
                \''.$rowData->dRequest.'\',\''.$c_itnam['c_itnam'].'\',\''.$vName['vName'].'\',
                \''.$cdapart['vDescription'].'\',\''.$c_pd['vteam'].'\', \''.$app['vName'].'\', \''.$formu['vName'].'\',
                \''.$nofur['vnoFormulasi'].'\' , \''.$rowData->cFormulator.'\'
                ) ;" />
              <script type="text/javascript">
                function pilih_upb_detail (id, cIteno, vNo_req_refor, vBatch_no, vAlasan_refor, 
                    dRequest, _cIteno, _cInisiator, _cdapart, _iteam_pd, _iStatus, _cFormulator, vnoFormulasi, cFormulator){                   
                    custom_confirm("Yakin ?", function(){
                        $(".'.$this->input->get('field').'_vNo_req_refor").val(vNo_req_refor); 
                        $(".'.$this->input->get('field').'_iLocal_req_refor").val(id); 
                        $(".'.$this->input->get('field').'_vBatch_no").text(vBatch_no);  
                        $(".'.$this->input->get('field').'_vAlasan_refor").text(vAlasan_refor);   
                        $(".'.$this->input->get('field').'_dRequest").text(dRequest);   
                        $(".'.$this->input->get('field').'_cIteno").text(_cIteno);   
                        $(".'.$this->input->get('field').'_cInisiator").text(_cInisiator);   
                        $(".'.$this->input->get('field').'_cdapart").text(_cdapart);  
                        $(".'.$this->input->get('field').'_iteam_pd").text(_iteam_pd);   
                        $(".'.$this->input->get('field').'_iStatus").text(_iStatus);   
                        $(".'.$this->input->get('field').'_cFormulator").text(_cFormulator);    
                        $(".'.$this->input->get('field').'_vnoFormulasi").val(vnoFormulasi);   
                        $(".'.$this->input->get('field').'_cpic_stress_test_").val(_cFormulator);  
                        $(".'.$this->input->get('field').'_cpic_stress_test").val(cFormulator); 
                        

                        $.ajax({
                            url: "'.$url_.'",
                            type: "post",
                            data: {
                                    iLocal_req_refor: id,
                                    field: "'.$this->input->get('field').'", 
                                },
                            success: function(data){
                                $(".'.$this->input->get('field').'_iupload_f").html(data);  
                            }
                        })
                        $("#alert_dialog_form").dialog("destroy");
                    });
                }
              </script>';
        return $o;
    }
}
