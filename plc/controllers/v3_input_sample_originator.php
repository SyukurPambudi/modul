<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_input_sample_originator extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('lib_plc');
        $this->modul_id = $this->input->get('modul_id');
        $this->iModul_id = $this->lib_plc->getIModulID($this->input->get('modul_id'));
        $this->db = $this->load->database('hrd',false, true);
        $this->load->library('auth');
        $this->user = $this->auth->user();
        $this->team = $this->lib_plc->hasTeam($this->user->gNIP);
        $this->teamID = $this->lib_plc->hasTeamID($this->user->gNIP);
        $isAdmin=$this->lib_plc->isAdmin($this->user->gNIP);
        $this->isAdmin = $isAdmin;
        $this->main_table='plc2_upb_request_originator';
        $this->main_table_pk='ireq_ori_id';


        $this->title = 'Input Sample Originator';
        $this->url = 'v3_input_sample_originator';
        $this->urlpath = 'plc/'.str_replace("_","/", $this->url);

        $this->maintable = 'plc2.plc2_upb_request_originator';  
        $datagrid['islist'] = array(
                                        'vreq_ori_no' => array('label'=>'No Request','width'=>100,'align'=>'center','search'=>true)
                                        ,'plc2_upb.vupb_nomor' => array('label'=>'No UPB','width'=>75,'align'=>'center','search'=>true)
                                        ,'plc2_upb.vupb_nama' => array('label'=>'Nama Usulan','width'=>300,'align'=>'left','search'=>true)
                                        
                                        ,'iTujuan_req' => array('label'=>'Tujuan Request','width'=>100,'align'=>'center','search'=>true)
                                        ,'isent_status' => array('label'=>'Status Kirim','width'=>100,'align'=>'center','search'=>true)
                                    );
        $datagrid['shortBy']=array('ireq_ori_id'=>'Desc');

        

        $datagrid['setQuery']=array(
                                0=>array('vall'=>'plc2_upb.ldeleted','nilai'=>0)
                               , 1=>array('vall'=>'plc2_upb_request_originator.ldeleted','nilai'=>0)
                                
                                );

        $datagrid['jointableinner']=array(
                                    #0=>array('plc2.plc2_upb_formula'=>'plc2_upb_formula.ifor_id=mikro_fg.ifor_id')
                                    0=>array('plc2.plc2_upb'=>'plc2.plc2_upb_request_originator.iupb_id = plc2.plc2_upb.iupb_id')

                                );
        


        $this->datagrid=$datagrid;
    }

    function index($action = '') {
        $grid = new Grid;       
        $grid->setTitle($this->title);      
        $grid->setTable($this->maintable );
        $grid->setUrl($this->url);
        // $grid->setGroupBy($this->setGroupBy);
        /*Untuk Field*/
        $grid->addFields('form_detail');
        foreach ($this->datagrid as $kv => $vv) {
            /*Untuk List*/
            if($kv=='islist'){
                foreach ($vv as $list => $vlist) {
                    $grid->addList($list);
                    foreach ($vlist as $kdis => $vdis) {
                        if($kdis=='label'){
                            $grid->setLabel($list, $vdis);
                        }
                        if($kdis=='width'){
                            $grid->setWidth($list, $vdis);
                        }
                        if($kdis=='align'){
                            $grid->setAlign($list, $vdis);
                        }
                        if($kdis=='search' && $vdis==true){
                            $grid->setSearch($list);
                        }
                    }
                }
            }

            /*Untuk Short List*/
            if($kv=='shortBy'){
                foreach ($vv as $list => $vlist) {
                    $grid->setSortBy($list);
                    $grid->setSortOrder($vlist);
                }
            }

            if($kv=='inputGet'){
                foreach ($vv as $list => $vlist) {
                    $grid->setInputGet($list,$vlist);
                }
            }

            if($kv=='jointableinner'){
                foreach ($vv as $list => $vlist) {
                    foreach ($vlist as $tbjoin => $onjoin) {
                        $grid->setJoinTable($tbjoin, $onjoin, 'inner');
                    }
                }
            }
            if($kv=='setQuery'){
                foreach ($vv as $kv => $vlist) {
                    $grid->setQuery($vlist['vall'], $vlist['nilai']);


                    
                }

                if($this->isAdmin){

                }else{
                    $arrTeam = explode(',',$this->team);

                    $AuthModul = $this->lib_plc->getAuthorModul($this->modul_id);
                    $nipAuthor = explode(',', $AuthModul['vNip_author']);
                    $nipParticipant = explode(',', $AuthModul['vNip_author']);

                    if(in_array('PD', $arrTeam)){
                        $grid->setQuery('plc2_upb.iteampd_id in ('.$this->teamID.')', NULL);                        
                    }else if(in_array('AD', $arrTeam)){
                        $grid->setQuery('plc2_upb.iteamad_id in ('.$this->teamID.')', NULL);                        
                    }else if(in_array('QA', $arrTeam)){
                        $grid->setQuery('plc2_upb.iteamqa_id in ('.$this->teamID.')', NULL);                        
                    }else if(in_array('BD', $arrTeam)){
                        $grid->setQuery('plc2_upb.iteambusdev_id in ('.$this->teamID.')', NULL);                        
                    }else if( in_array($this->user->gNIP, $nipAuthor )|| in_array($this->user->gNIP, $nipParticipant)  ){


                    }

                    
                }


                $grid->setQuery('plc2_upb_request_originator.iapppd in (2)', NULL);                        

            }

        }


        $grid->changeFieldType('isent_status','combobox','',array(''=>'--Pilih--',0=>'Belum dikirim', 1=>'Terkirim'));
        $grid->changeFieldType('iSubmit','combobox','',array(0=>'Draft - Need to be Submitted', 1=>'Submitted'));
        $grid->changeFieldType('iTujuan_req','combobox','',array(''=>'--Pilih--',1=>'Untuk Sample', 2=>'Untuk Pilot'));

        
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
                $grid->render_form($this->input->get('id'),TRUE);
                break;
            case 'updateproses':
                echo $grid->updated_form();
                break;  
            case 'delete':
                echo $grid->delete_row();
                break;
            case 'approve':
                    echo $this->approve_view();
                    break;
            case 'approve_process':
                    echo $this->approve_process();
                    break;
            case 'reject':
                    echo $this->reject_view();
                    break;
            case 'reject_process':
                    echo $this->reject_process();
                    break;

            case 'confirm':
                echo $this->confirm_view();
                break;
            case 'confirm_process':
                echo $this->confirm_process();
                break;

            case 'getrekKe':
                echo $this->getrekKe();
                break;
            case 'getDetail':
                echo $this->getDetail();
                break;
            /*Option Case*/
            case 'getFormDetail':
                echo $this->getFormDetail();
                break;

            default:
                $grid->render_grid();
                break;
        }
    }

    function listBox_Action($row, $actions) {
        $peka=$row->ireq_ori_id;
        $getLastactivity = $this->lib_plc->getLastactivity($this->modul_id,$peka);
        $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

        if ( $getLastactivity == 0 ) { 
                
        }else{
            if($isOpenEditing){

            }else{
                unset($actions['edit']);    
            }
            
        }

        return $actions;
    }

            //Ini Merupakan Standart Approve yang digunakan di erp
            function approve_view() {
                $echo = '<script type="text/javascript">
                             function submit_ajax(form_id) {
                                return $.ajax({
                                    url: $("#"+form_id).attr("action"),
                                    type: $("#"+form_id).attr("method"),
                                    data: $("#"+form_id).serialize(),
                                    success: function(data) {
                                        var o = $.parseJSON(data);
                                        var last_id = o.last_id;
                                        var group_id = o.group_id;
                                        var modul_id = o.modul_id;
                                        var url = "'.base_url().'processor/plc/v3_input_sample_originator";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_input_sample_originator").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_input_sample_originator");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_v3_input_sample_originator_approve" action="'.base_url().'processor/plc/v3_input_sample_originator?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="ireq_ori_id" value="'.$this->input->get('ireq_ori_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_input_sample_originator_approve\')">Approve</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function approve_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $ireq_ori_id = $post['ireq_ori_id'];
                $iupb_id = $post['iupb_id'];
                
                $vRemark = $post['vRemark'];
                $modul_id = $post['modul_id'];


                //Letakan Query Update approve disini
                $data=array('iapprove'=>'2');
                $this -> db -> where('ireq_ori_id', $ireq_ori_id);
                $updet = $this -> db -> update('plc2.plc2_upb_request_originator', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_activity = $isAndSort['iM_activity'];
                $iSort = $isAndSort['iSort'];

                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$ireq_ori_id,$iM_activity,$iSort,$vRemark,2);
    
                $data['status']  = true;
                $data['last_id'] = $post['ireq_ori_id'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }
    
    
            //Ini Merupakan Standart Confirm yang digunakan di erp
            function confirm_view() {
                $echo = '<script type="text/javascript">
                             function submit_ajax(form_id) {
                                return $.ajax({
                                    url: $("#"+form_id).attr("action"),
                                    type: $("#"+form_id).attr("method"),
                                    data: $("#"+form_id).serialize(),
                                    success: function(data) {
                                        var o = $.parseJSON(data);
                                        var last_id = o.last_id;
                                        var group_id = o.group_id;
                                        var modul_id = o.modul_id;
                                        var url = "'.base_url().'processor/plc/v3_input_sample_originator";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_input_sample_originator").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_input_sample_originator");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_v3_input_sample_originator_confirm" action="'.base_url().'processor/plc/v3_input_sample_originator?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="ireq_ori_id" value="'.$this->input->get('ireq_ori_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_input_sample_originator_confirm\')">Confirm</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function confirm_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $ireq_ori_id = $post['ireq_ori_id'];
                $iupb_id = $post['iupb_id'];
                $vRemark = $post['vRemark'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $modul_id = $post['modul_id'];

                //Letakan Query Update approve disini
                $data=array('iapprove'=>'2');
                $this -> db -> where('ireq_ori_id', $ireq_ori_id);
                $updet = $this -> db -> update('plc2.plc2_upb_request_originator', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_activity = $isAndSort['iM_activity'];
                $iSort = $isAndSort['iSort'];
                
                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$ireq_ori_id,$iM_activity,$iSort,$vRemark,2);

                
                $data['status']  = true;
                $data['last_id'] = $post['ireq_ori_id'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }
    
        
            //Ini Merupakan Standart Reject yang digunakan di erp
            function reject_view() {
                $echo = '<script type="text/javascript">
                             function submit_ajax(form_id) {
                                var remark = $("#v3_input_sample_originator_remark").val();
                                if (remark=="") {
                                    alert("Remark tidak boleh kosong ");
                                    return
                                }
    
                                return $.ajax({
                                    url: $("#"+form_id).attr("action"),
                                    type: $("#"+form_id).attr("method"),
                                    data: $("#"+form_id).serialize(),
                                    success: function(data) {
                                        var o = $.parseJSON(data);
                                        var last_id = o.last_id;
                                        var group_id = o.group_id;
                                        var modul_id = o.modul_id;
                                        var url = "'.base_url().'processor/plc/v3_input_sample_originator";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_input_sample_originator").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_input_sample_originator");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_v3_input_sample_originator_reject" action="'.base_url().'processor/plc/v3_input_sample_originator?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="ireq_ori_id" value="'.$this->input->get('ireq_ori_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark" id="reject_v3_input_sample_originator_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_input_sample_originator_reject\')">Reject</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            }
    
    
            
            function reject_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $ireq_ori_id = $post['ireq_ori_id'];
                $iupb_id = $post['iupb_id'];
                $vRemark = $post['vRemark'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $modul_id = $post['modul_id'];
    
                //Letakan Query Update reject disini
                $data=array('iapprove'=>'1');
                $this -> db -> where('ireq_ori_id', $ireq_ori_id);
                $updet = $this -> db -> update('plc2.plc2_upb_request_originator', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_activity = $isAndSort['iM_activity'];
                $iSort = $isAndSort['iSort'];
                
                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$ireq_ori_id,$iM_activity,$iSort,$vRemark,1);
    
                $data['status']  = true;
                $data['last_id'] = $post['ireq_ori_id'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }


    function getHistory($iupb_id,$iTujuan_req){

        $sql = 'select a.vreq_ori_no , date(a.tcreate) as tcreate , a.tapppd as tapppd,a.vnip_apppd  
                from plc2.plc2_upb_request_originator a 
                where 
                a.ldeleted=0
                and a.iupb_id= "'.$iupb_id.'"  
                and a.iTujuan_req= "'.$iTujuan_req.'"  
                order by ireq_ori_id
        ';
        
        return $sql;
    }
    function getDetail(){
        $sqlHistory = $this->getHistory($_POST['iupb_id'],$_POST['iTujuan_req']);
        $data['datanya'] = $this->db->query($sqlHistory)->result_array();
        return $this->load->view('request_originator_history_show',$data,TRUE);   

    }
    function getrekKe(){

        $data = array();

        $sqlHistory = $this->getHistory($_POST['iupb_id'],$_POST['iTujuan_req']);
        $count = $this->db->query($sqlHistory)->num_rows();;

        $row_array['jumlah'] = trim($count)+1;
        $row_array['jumlah_before'] = trim($count);
        array_push($data, $row_array);
        echo json_encode($data);
        exit;

    }

    
    function output(){
        $this->index($this->input->get('action'));
    }

/*    function before_insert_processor($row, $postData) {
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated']=$this->user->gNIP;



        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } else{
            $postData['iSubmit']=1;
            
        } 
        

        return $postData;

    }

    function after_insert_processor($fields, $id, $postData) {
      

        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } else{
            $postData['iSubmit']=1;
            $arrUPB['iupb_id'] = $postData['iupb_id'];
            $this->lib_plc->InsertActivityModule($arrUPB,$this->modul_id,$id,1,1);
        }

        $iupb_id=$id;
    }*/


    function before_update_processor($row, $postData) {
        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;
        $cNip= $this->user->gNIP;
        $now            = date('Y-m-d H:i:s');
        $controller_name ='v3_input_sample_originator';
        $pk_field = 'ireq_ori_id';
        $gabung = $controller_name."_".$pk_field;
        $peka=$postData[$gabung];

        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
             $iupb_id = $postData['iupb_id'];


            $modul_id=$postData['modul_id'];
            $iM_modul_activity = $postData['iM_modul_activity'];
            $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
            $iM_activity = $isAndSort['iM_activity'];
            $iSort = $isAndSort['iSort'];
            $vRemark = '';
            
            $cekUdah = 'select * from plc2.plc2_upb_date_sample a where a.iReq_ori_id=?';
            $dUdah = $this->db->query($cekUdah,array($peka))->row_array();

            if (empty($dUdah)) {

                /*$datastatus=array();
                $datastatus['isent_status'] = 1;

                $this -> db -> where('ireq_ori_id', $peka);
                $updet = $this -> db -> update('plc2.plc2_upb_request_originator', $datastatus);*/



                /*insert by BD*/
                $dataalert=array();
                $dataalert['iReq_ori_id'] =$peka;
                $dataalert['iupb_id'] = $iupb_id;
                
                $dataalert['dTanggalKirimBD'] = $postData['dTanggalKirimBD'];
                $dataalert['cPengirimBD'] = $postData['cPengirimBD'];
                $dataalert['txtNoteBD'] = $postData['txtNoteBD'];
                
                $ins = $this -> db -> insert('plc2.plc2_upb_date_sample', $dataalert);    

            }else{
                /*update*/
                $dataalert=array();
                if (isset($postData['dTanggalKirimBD'])) {
                    $dataalert['dTanggalKirimBD'] = $postData['dTanggalKirimBD'];    
                    $dataalert['cPengirimBD'] = $postData['cPengirimBD'];
                    $dataalert['txtNoteBD'] = $postData['txtNoteBD'];
                }

                if (isset($postData['dTanggalTerimaPD'])) {
                    $dataalert['dTanggalTerimaPD'] = $postData['dTanggalTerimaPD'];
                    $dataalert['cPenerimaPD'] = $postData['cPenerimaPD'];
                    $dataalert['txtNotePD'] = $postData['txtNotePD'];
                }
                
                if (isset($postData['dTanggalTerimaAD'])) {
                    $dataalert['dTanggalTerimaAD'] = $postData['dTanggalTerimaAD'];
                    $dataalert['cPenerimaAD'] = $postData['cPenerimaAD'];
                    $dataalert['txtNoteAD'] = $postData['txtNoteAD'];
                }

                if (isset($postData['dTanggalTerimaQA'])) {
                    $dataalert['dTanggalTerimaQA'] = $postData['dTanggalTerimaQA'];
                    $dataalert['cPenerimaQA'] = $postData['cPenerimaQA'];
                    $dataalert['txtNoteQA'] = $postData['txtNoteQA'];

                }
                
                $this -> db -> where('iKirimID', $dUdah['iKirimID']);
                $updet = $this -> db -> update('plc2.plc2_upb_date_sample', $dataalert);

            }
            
        } else{
            $postData['iSubmit']=1;
            $iupb_id = $postData['iupb_id'];


            $modul_id=$postData['modul_id'];
            $iM_modul_activity = $postData['iM_modul_activity'];
            $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
            $iM_activity = $isAndSort['iM_activity'];
            $iSort = $isAndSort['iSort'];
            $vRemark = '';
            
            $cekUdah = 'select * from plc2.plc2_upb_date_sample a where a.iReq_ori_id=?';
            $dUdah = $this->db->query($cekUdah,array($peka))->row_array();

            if (empty($dUdah)) {

                $datastatus=array();
                $datastatus['isent_status'] = 1;

                $this -> db -> where('ireq_ori_id', $peka);
                $updet = $this -> db -> update('plc2.plc2_upb_request_originator', $datastatus);



                /*insert by BD*/
                $dataalert=array();
                $dataalert['iReq_ori_id'] =$peka;
                $dataalert['iupb_id'] = $iupb_id;
                
                $dataalert['dTanggalKirimBD'] = $postData['dTanggalKirimBD'];
                $dataalert['cPengirimBD'] = $postData['cPengirimBD'];
                $dataalert['txtNoteBD'] = $postData['txtNoteBD'];
                
                $ins = $this -> db -> insert('plc2.plc2_upb_date_sample', $dataalert);    

            }else{
                $datastatus=array();
                $datastatus['isent_status'] = 1;

                $this -> db -> where('ireq_ori_id', $peka);
                $updet = $this -> db -> update('plc2.plc2_upb_request_originator', $datastatus);
                
                /*update*/
                $dataalert=array();
                if (isset($postData['dTanggalKirimBD'])) {
                    $dataalert['dTanggalKirimBD'] = $postData['dTanggalKirimBD'];    
                    $dataalert['cPengirimBD'] = $postData['cPengirimBD'];
                    $dataalert['txtNoteBD'] = $postData['txtNoteBD'];
                }

                if (isset($postData['dTanggalTerimaPD'])) {
                    $dataalert['dTanggalTerimaPD'] = $postData['dTanggalTerimaPD'];
                    $dataalert['cPenerimaPD'] = $postData['cPenerimaPD'];
                    $dataalert['txtNotePD'] = $postData['txtNotePD'];
                }
                
                if (isset($postData['dTanggalTerimaAD'])) {
                    $dataalert['dTanggalTerimaAD'] = $postData['dTanggalTerimaAD'];
                    $dataalert['cPenerimaAD'] = $postData['cPenerimaAD'];
                    $dataalert['txtNoteAD'] = $postData['txtNoteAD'];
                }

                if (isset($postData['dTanggalTerimaQA'])) {
                    $dataalert['dTanggalTerimaQA'] = $postData['dTanggalTerimaQA'];
                    $dataalert['cPenerimaQA'] = $postData['cPenerimaQA'];
                    $dataalert['txtNoteQA'] = $postData['txtNoteQA'];

                }
                
                

                $this -> db -> where('iKirimID', $dUdah['iKirimID']);
                $updet = $this -> db -> update('plc2.plc2_upb_date_sample', $dataalert);
                

            }

            if( $iSort == 2 and ( $postData['dTanggalTerimaPD']<> "" and $postData['dTanggalTerimaAD'] <> ""  ) ){
                /*  jika terima pD dan diisi sekaligus terima AD. maka akan otomatis insert 2 activity */
                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$peka,$iM_activity,$iSort,$vRemark,0);
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$peka,$iM_activity,3,$vRemark,0);

            }else{
                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$peka,$iM_activity,$iSort,$vRemark,0);

            }


            if( $iSort == 4 and ( $postData['cPenerimaQA']<> "" and $postData['dTanggalTerimaQA'] <> ""  ) ){

                 /* syaratnya masuk skala trial terbaru
                        1. confirm study literatur PD
                        2. confirm study literatur AD
                        3. terima input sample originator oleh QA
                        4. terima bb oleh PD

                    */

                    $stPD = 'select *
                            from plc3.m_modul a 
                            join plc3.m_modul_log_activity b on b.idprivi_modules=a.idprivi_modules
                            join plc3.m_modul_log_upb c on c.iM_modul_log_activity=b.iM_modul_log_activity
                            where 
                            a.iM_modul in (3)
                            and b.iM_activity = 4
                            and c.iupb_id="'.$iupb_id.'" ';

                    $stAD = 'select *
                            from plc3.m_modul a 
                            join plc3.m_modul_log_activity b on b.idprivi_modules=a.idprivi_modules
                            join plc3.m_modul_log_upb c on c.iM_modul_log_activity=b.iM_modul_log_activity
                            where 
                            
                            a.iM_modul in (4)
                            and b.iM_activity = 4
                            and c.iupb_id="'.$iupb_id.'" ';

                    $inpQA = 'select *
                            from plc3.m_modul a 
                            join plc3.m_modul_log_activity b on b.idprivi_modules=a.idprivi_modules
                            join plc3.m_modul_log_upb c on c.iM_modul_log_activity=b.iM_modul_log_activity
                            where 
                            
                            a.iM_modul in (11)
                            and b.iSort = 4
                            and c.iupb_id="'.$iupb_id.'" ';

                    $terimaPD = 'select *
                            from plc3.m_modul a 
                            join plc3.m_modul_log_activity b on b.idprivi_modules=a.idprivi_modules
                            join plc3.m_modul_log_upb c on c.iM_modul_log_activity=b.iM_modul_log_activity
                            where 
                            a.iM_modul in (25)
                            and b.iSort = 2
                            and c.iupb_id="'.$iupb_id.'" ';

                    $cPD = $this->db->query($stPD)->num_rows();
                    $cAD = $this->db->query($stAD)->num_rows();
                    $cQA = $this->db->query($inpQA)->num_rows();
                    $cTPD = $this->db->query($terimaPD)->num_rows();

                    if( $cPD > 0 and $cAD > 0 and $cQA > 0 and $cTPD > 0){

                        $cek_form = "SELECT * FROM pddetail.formula_process fp WHERE fp.lDeleted = 0 AND fp.iMaster_flow = 1 AND fp.iupb_id IN (".$iupb_id.")";
                        $dcek = $this->db->query($cek_form)->result_array();

                        if (count($dcek) == 0){             
                            //Insert Formula Proses
                            $sqlto_Back     = "INSERT pddetail.formula_process (iupb_id,iMaster_flow,cCreated,dCreate) VALUES (?, ?, ?, ?)"; 
                            $this->db->query($sqlto_Back, array($iupb_id, '1', $cNip, $now));
                            $iFormula_process = $this->db->insert_id();

                            //Insert Formula Proses Detail
                            $pn = "INSERT INTO pddetail.formula_process_detail(iFormula_process, cPic, iProses_id, is_proses, dStart_time, cCreated, dCreate) VALUES (?,?,'1','1',?,?,?)";
                            $this->db->query($pn, array($iFormula_process, $cNip, $now, $cNip, $now));

                            //Insert Formula Awal
                            $ver = 0;
                            $iFd ='INSERT INTO pddetail.formula (iFormula_process,iVersi,dCreate,cCreated) VALUES(?,?,?,?)';
                            $this->db->query($iFd, array($iFormula_process, $ver, $now, $cNip));
                        }

                        $cek_fromPD = 'SELECT f.iFormula FROM pddetail.formula_process fp 
                                        JOIN pddetail.formula f ON f.iFormula_process = fp.iFormula_process
                                        WHERE fp.lDeleted = 0 AND f.lDeleted = 0
                                            AND fp.iupb_id = ? ';
                        $dFormula = $this->db_plc0->query($cek_fromPD, array($iupb_id))->result_array(); 

                        if (count($dFormula) > 0) {
                            foreach ($dFormula as $forfor) {
                                $this->db->where('iFormula', $forfor['iFormula']);
                                $this->db->update('pddetail.formula', array('iBackSample'=>0));                                            
                            }
                                
                        }
                    }


            }

           


            

            //$this->lib_plc->InsertActivityModule($arrUPB,$this->modul_id,$peka,1,1);
        } 


        return $postData; 
    }

    function after_update_processor($fields, $id, $postData) {



    }




    function manipulate_update_button($buttons, $rowData) { 
        $peka=$rowData['ireq_ori_id'];
        $iupb_id=$rowData['iupb_id'];


        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $js = $this->load->view('js/standard_js');
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="v3_input_sample_originator_frame" id="v3_input_sample_originator_frame" height="0" width="0"></iframe>';
        

        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        }
        else{ 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_input_sample_originator\', \' '.base_url().'processor/plc/v3_input_sample_originator?draft=true \',this,true )"  id="button_update_draft_v3_input_sample_originator"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$peka);
                    $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,$peka);

                    foreach ($activities as $act) {
                        $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_input_sample_originator\', \' '.base_url().'processor/plc/v3_input_sample_originator?draft=true&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].' \',this,true )"  id="button_update_draft_v3_input_sample_originator"  class="ui-button-text icon-save" >Update as Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\'v3_input_sample_originator\', \' '.base_url().'processor/plc/v3_input_sample_originator?company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,false )"  id="button_update_submit_v3_input_sample_originator"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_input_sample_originator?action=approve&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&ireq_ori_id='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_input_sample_originator"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_input_sample_originator?action=reject&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&ireq_ori_id='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_v3_input_sample_originator"  class="ui-button-text icon-save" >Reject</button>';

                        $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_input_sample_originator?action=confirm&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&ireq_ori_id='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_input_sample_originator"  class="ui-button-text icon-save" >Confirm</button>';

                        

                        switch ($act['iType']) {
                            case '1':
                                # Update
                                $sButton .= $update_draft.$update;
                                break;
                            case '2':
                                # Approval
                                if($getLastStatusApprove){
                                    $sButton .= $approve.$reject;
                                }else{
                                    $sButton .= 'Last Activity Reject';
                                }
                                
                                break;
                            case '3':
                                # Confirmation
                                if($getLastStatusApprove){
                                    $sButton .= $confirm;
                                }else{
                                    $sButton .= 'Last Activity Reject';
                                }
                                
                                break;
                            default:
                                # Update
                                $sButton .= $update_draft.$update;
                                break;
                        }
                        $arrNipAssign = explode(',',$act['vNip_assigned'] );
                        
                        $arrDept = explode(',',$act['vDept_assigned'] );

                        $arrTeam = explode(',',$this->team);

                        $arrTeamID = explode(',',$this->teamID);
                        $upbTeamID = $this->lib_plc->upbTeam($iupb_id);

                        $cekDept = array_intersect($arrTeam, $arrDept);

                        //if(in_array($act['vDept_assigned'], $arrTeam ) || in_array($this->user->gNIP, $arrNipAssign)  ){
                        if( !empty($cekDept) || in_array($this->user->gNIP, $arrNipAssign)  ){
                            
                            // jika Dept id yang ditunjuk ada pada team id yang dimiliki
                            if(in_array($upbTeamID[$act['vDept_assigned']], $arrTeamID) || in_array($this->user->gNIP, $arrNipAssign) ){
                                //get manager from Team ID
                                $magrAndCief = $this->lib_plc->managerAndChief($upbTeamID[$act['vDept_assigned']]);

                                // jika activitynya approval keatas
                                if($act['iType'] > 1){
                                    // nip harus ada pada nip manager atau chief dari Dept, atau nip yang ditunjuk di table modul activity
                                    $arrmgrAndCief = explode(',', $magrAndCief);
                                    if(in_array($this->user->gNIP, $arrmgrAndCief) ||in_array($this->user->gNIP, $arrNipAssign)){
                                        
                                    }else{
                                        $sButton = '<span style="color:red;">You\'re not Authorized to Approve</span>';
                                    }
                                }

                            }else{
                                $sButton = '<span style="color:red;" arrTeamID="'.$this->teamID.'" title="'.$upbTeamID[$act['vDept_assigned']].'" >You\'re Team not Authorized </span>';
                            }

                        }else{
                            $sButton = '<span style="color:red;" title="'.$act['vDept_assigned'].'">You\'re Dept not Authorized</span>';
                            
                        }
                    }
                }


                $buttons['update'] = $sButton;        
                
            

            
        }
        
        return $buttons;
    }

    function manipulate_insert_button($buttons, $rowData) { 
        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $js = $this->load->view('js/standard_js');
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="v3_input_sample_originator_frame" id="v3_input_sample_originator_frame" height="0" width="0"></iframe>';
        
        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'v3_input_sample_originator\', \' '.base_url().'processor/plc/v3_input_sample_originator?draft=true \',this,true )"  id="button_save_draft_v3_input_sample_originator"  class="ui-button-text icon-save" >Save as Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\'v3_input_sample_originator\', \' '.base_url().'processor/plc/v3_input_sample_originator?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_save_submit_v3_input_sample_originator"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

        $AuthModul = $this->lib_plc->getAuthorModul($this->modul_id);
        $arrTeam = explode(',',$this->team);
        $nipAuthor = explode(',', $AuthModul['vNip_author']);

        if( in_array($AuthModul['vDept_author'],$arrTeam )  || in_array($this->user->gNIP, $nipAuthor)  ){

            $buttons['save'] = $iframe.$save_draft.$save.$js;
        }else{
            unset($buttons['save']);
            $buttons['save'] = '<span style="color:red;" title="'.$AuthModul['vDept_author'].'">You\'re Dept not Authorized</span>';
        }
        
        
        return $buttons;
    }

    /*Manipulate Insert/Update Form*/
    function insertBox_v3_input_sample_originator_form_detail($field,$id){
            $get=$this->input->get();
            $post=$this->input->post();
            foreach ($get as $kget => $vget) {
                if($kget!="action"){
                    $in[]=$kget."=".$vget;
                }
                if($kget=="action"){
                    $in[]="act=".$vget;
                }
            }
            $g=implode("&", $in);
            $return = '<script>
                var sebelum = $("label[for=\''.$this->url.'_form_detail\']").parent();
                $("label[for=\''.$this->url.'_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/'.$this->urlpath.'?action=getFormDetail&formaction=addnew&'.$g.'",
                    type: "post",
                    data: iupb_id=0,
                    success: function(data) {
                        var o = $.parseJSON(data);
                        sebelum.html(o.html);
                    }       
                });
            </script>';
            return $return;
    }

    function updateBox_v3_input_sample_originator_form_detail($field,$id,$value,$rowData){
        $get=$this->input->get();
        $post=$this->input->post();
        foreach ($get as $kget => $vget) {
            if($kget!="action"){
                $in[]=$kget."=".$vget;
            }
            if($kget=="action"){
                $in[]="act=".$vget;
            }
        }
        $g=implode("&", $in);
        $return = '<script>
            var sebelum = $("label[for=\''.$this->url.'_form_detail\']").parent();
            $("label[for=\''.$this->url.'_form_detail\']").remove();
            sebelum.attr("id","'.$id.'");
            sebelum.html("");
            sebelum.removeAttr("class");
            sebelum.removeAttr("style");
            $.ajax({
                url: base_url+"processor/'.$this->urlpath.'?action=getFormDetail&formaction=update&'.$g.'",
                type: "post",
                data: iupb_id=0,
                success: function(data) {
                    var o = $.parseJSON(data);
                    sebelum.html(o.html);
                }       
            });
        </script>';
        return $return;
    }
    /*Function Tambahan*/
    function getFormDetail(){
        $post=$this->input->post();
        $get=$this->input->get();
        $data['html']="";

        $sqlFields = 'select * from plc3.m_modul_fileds a where a.lDeleted=0 and  a.iM_modul='.$this->iModul_id.' order by a.iSort ASC';
        /*echo $sqlFields;
        exit;*/
        $dFields = $this->db->query($sqlFields)->result_array();

        $hate_emel = "";

        if($get['formaction']=='update'){
                $aidi = $get['id'];
        }else{
                $aidi = 0;
        }

        $hate_emel .= '
            <table class="hover_table" style="width:99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
                <thead>
                    <tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
                        <th style="border: 1px solid #dddddd; width: 10%;">Activity Name</th>
                        <th style="border: 1px solid #dddddd;">Status</th>
                        <th style="border: 1px solid #dddddd;">at</th>      
                        <th style="border: 1px solid #dddddd; width: 30%;">By</th>      
                        <th style="border: 1px solid #dddddd; width: 40%;">Remark</th>      
                    </tr>
                </thead>
                <tbody>';

                $hate_emel .= $this->lib_plc->getHistoryActivity($this->modul_id,$aidi);

        $hate_emel .='
                </tbody>
            </table>
            <br>
            <br>
            <hr>
        ';


        if(!empty($dFields)){

            foreach ($dFields as $form_field) {
                
                $data_field['iM_jenis_field']= $form_field['iM_jenis_field'] ;
                
                $data_field['form_field']= $form_field;

                $controller = $this->url;
                $data_field['id']= $controller.'_'.$form_field['vNama_field'];
                //$data_field['field']= $controller.'_'.$form_field['vNama_field'] ;
                $data_field['field']= $form_field['vNama_field'] ;

                $data_field['act']= $get['act'] ;
                $data_field['hasTeam']= $this->team ;
                $data_field['hasTeamID']= $this->teamID ;
                $data_field['isAdmin']= $this->isAdmin ;


                /*untuk keperluad file upload*/
                if($form_field['iM_jenis_field'] == 7){
                    $data_field['tabel_file']= $form_field['vTabel_file'] ;
                    $data_field['tabel_file_pk']= $this->main_table_pk;
                    $data_field['tabel_file_pk_id']= $form_field['vTabel_file_pk_id'] ;

                    $path = 'files/plc/dok_tambah';
                    $createname_space =$this->url;
                    $tempat = 'dok_tambah';
                    $FOLDER_APP = 'plc';

                    $data_field['path'] = $path;
                    $data_field['FOLDER_APP'] = $FOLDER_APP;
                    $data_field['createname_space'] = $createname_space;
                    $data_field['tempat'] = $tempat;

                    if ($form_field['iRequired']==1) {
                        $data_field['field_required']= 'required';
                    }else{
                        $data_field['field_required']= '';
                    }


                }
                /*untuk keperluad file upload*/

                if ($form_field['iRequired']==1) {
                    $data_field['field_required']= 'required';
                }else{
                    $data_field['field_required']= '';
                }


                if($get['formaction']=='update'){
                    $id = $get['id'];

                    $sqlGetMainvalue= 'select * from plc2.'.$this->main_table.' where lDeleted=0 and '.$this->main_table_pk.'= '.$id.'   ';
                    $dataHead = $this->db->query($sqlGetMainvalue)->row_array();

                    $data_field['dataHead']= $dataHead;
                    $data_field['main_table_pk']= $this->main_table_pk;
                    
                    if($form_field['iM_jenis_field'] == 6){
                        $data_field['vSource_input']= $form_field['vSource_input_edit'] ;
                    }else{
                        $data_field['vSource_input']= $form_field['vSource_input'] ;
                    }
                    

                    $return_field = $this->load->view('partial/v3_form_detail_update',$data_field,true);    
                }else{
                    $data_field['vSource_input']= $form_field['vSource_input'] ;
                    $return_field = $this->load->view('partial/v3_form_detail',$data_field,true);    
                }
                

                $hate_emel .='  <div class="rows_group" style="overflow:fixed;">
                                    <label for="'.$controller.'_form_detail_'.$form_field['vNama_field'].'" class="rows_label">'.$form_field['vDesciption'].'
                                    ';
                if ($form_field['iRequired']==1) {
                    $hate_emel .='<span class="required_bintang">*</span>';    
                    $data_field['field_required']= 'required';
                }else{
                    $data_field['field_required']= '';
                }

                if ($form_field['vRequirement_field']<> "") {
                    $hate_emel .='<span style="float:right;" title="'.$form_field['vRequirement_field'].'" class="ui-icon ui-icon-info"></span>';    
                }else{
                    $hate_emel .='';    
                }


                

                $hate_emel .='      </label>
                                    <div class="rows_input">'.$return_field.'</div>
                                </div>';
            }

        }else{
            $hate_emel .='Field belum disetting';
        }

        $hate_emel .= '<input type="hidden" name="isdraft" id="isdraft">';
        
        $data["html"] .= $hate_emel;
        return json_encode($data);
    }


}
