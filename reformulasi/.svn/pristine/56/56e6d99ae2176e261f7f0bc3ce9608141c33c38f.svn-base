<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_export_stabilita_pilot extends MX_Controller {
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
        $grid->setUrl('browse_export_stabilita_pilot');
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

        /*Filter untuk MBR*/
        $grid->setQuery('export_refor_formula.iexport_refor_formula in (select iexport_refor_formula from reformulasi.export_produksi_pilot where ldeleted=0 and iapprove_pd=2)',NULL);
        $grid->setQuery('export_refor_formula.iexport_refor_formula not in (select iexport_refor_formula from reformulasi.export_stabilita_pilot where ldeleted=0)',NULL);

        /*Filter PD Terkait*/
        if($this->auth_export->is_manager()){
            $x=$this->auth_export->dept();
            $manager=$x['manager'];
            if(in_array('PD', $manager)){
                $type='PD';
                $grid->setQuery('export_req_refor.iTeamPD IN ('.$this->auth_export->my_teams().')', null); 
            }
            else{$type='';}
        }
        else{
            $x=$this->auth_export->dept();
            $team=$x['team'];
            if(in_array('PD', $team)){
                $type='PD';
                $grid->setQuery('export_req_refor.iTeamPD IN ('.$this->auth_export->my_teams().')', null);
            }
            else{$type='';}
        }

        $grid->setQuery('dossier_upd.ldeleted',0);
        $grid->setQuery('export_refor_formula.ldeleted',0);
        $grid->setQuery('export_req_refor.ldeleted',0);


 
        $grid->setSortOrder('DESC');  

        switch ($action) {
            case 'json':
                $grid->getJsonData();
                break;
            case 'getdetails':
                $data=$this->getdetails();
                echo $data;
                break;
            case 'get_data_prev':
                echo $this->getdetailsprev();
                break;
            default:
                $grid->render_grid();
                $url=base_url()."processor/reformulasi/browse/export/stabilita/pilot?action=getdetails";
                $o='<script type="text/javascript">
                function pilih_request_stabilita_pilot(id){    
                    custom_confirm("Yakin ?", function(){
                        $.ajax({
                            url: "'.$url.'",
                            type: "post",
                            data: {
                                id:id
                            },
                            success: function( data ) {
                                var o = $.parseJSON(data);
                                $("#'.$this->input->get('field').'_iexport_refor_formula").val(id);
                                $("#'.$this->input->get('field').'_iexport_refor_formula_dis").val(o.vno_export_req_refor);
                                $("#'.$this->input->get('field').'_vUpd_no").val(o.vUpd_no);
                                $("#'.$this->input->get('field').'_vNama_usulan").val(o.vNama_usulan);
                                $("#'.$this->input->get('field').'_cInisiator_export").val(o.cInisiator_export);
                                $("#'.$this->input->get('field').'_iDapartemen_export").val(o.iDapartemen_export);
                                $("#'.$this->input->get('field').'_tAlasan_export").val(o.tAlasan_export);
                                $("#'.$this->input->get('field').'_iTeamPD").val(o.iTeamPD);
                                $("#'.$this->input->get('field').'_dPermintaan_req_export").val(o.dPermintaan_req_export);
                                $("#'.$this->input->get('field').'_cApproval_ats_inisiator").val(o.cApproval_ats_inisiator);
                                $("#'.$this->input->get('field').'_cPicFormulator").val(o.cPicFormulator);
                                $("#tb_details_export_stabilita_pilot_id").val(o.iexport_req_refor);
                                reload_grid_tb_details_export_stabilita_pilot();
                            }
                        });
                        $("#alert_dialog_form").dialog("destroy");
                    });
                }</script>';
                echo $o;
                break;
        }
    }
      
    function output(){
        $this->index($this->input->get('action'));//test komen
    }

    function listBox_browse_export_stabilita_pilot_pilih($value, $pk, $name, $rowData) {
        $o = '<input type="radio" name="pilih" onClick="javascript:pilih_request_stabilita_pilot('.$pk.') ;" />';
        
        return $o;
    }


    /*Optional Func*/
    function getdetails(){
        $post=$this->input->post();
        $sql="select r.vno_export_req_refor,u.vUpd_no,u.vNama_usulan,r.cInisiator_export,r.iDapartemen_export,r.tAlasan_export,r.iTeamPD,r.dPermintaan_req_export,r.cApproval_ats_inisiator,r.cPicFormulator,r.iexport_req_refor 
            from reformulasi.export_refor_formula f
            join reformulasi.export_req_refor r on r.iexport_req_refor=f.iexport_req_refor
            join dossier.dossier_upd u on r.idossier_upd_id=u.idossier_upd_id
            where f.lDeleted=0 and r.lDeleted=0 and u.lDeleted=0 and f.iexport_refor_formula=".$post['id'];
        $row=$this->db->query($sql)->row_array();
        $cInisiator_export=$this->getDetailsEmploye($row['cInisiator_export']);
        $row['cInisiator_export']="[".$row['cInisiator_export']."] ".$cInisiator_export['vName'];
        $depart=$this->getDetailsDepart($row['iDapartemen_export']);
        $row['iDapartemen_export']=$depart['vDescription'];
        $cApproval_ats_inisiator=$this->getDetailsEmploye($row['cApproval_ats_inisiator']);
        $row['cApproval_ats_inisiator']="[".$row['cApproval_ats_inisiator']."] ".$cApproval_ats_inisiator['vName'];
        $cPicFormulator=$this->getDetailsEmploye($row['cPicFormulator']);
        $row['cPicFormulator']="[".$row['cPicFormulator']."] ".$cPicFormulator['vName'];
        $row['iTeamPD']=$this->getTeamByID($row['iTeamPD']);
        return json_encode($row);
    }

    function getDetailsEmploye($nip=0){
        $sql="select * from hrd.employee em where em.cNip='".$nip."'";
        $qsql=$this->db->query($sql);
        $ret=array();
        if($qsql->num_rows()>=1){
            $ret=$qsql->row_array();
        }
        return $ret;
    }
    function getDetailsDepart($id=0){
        $sql="select * from hrd.msdepartement em where em.iDeptID='".$id."'";
        $qsql=$this->db->query($sql);
        $ret=array();
        if($qsql->num_rows()>=1){
            $ret=$qsql->row_array();
        }
        return $ret;
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
