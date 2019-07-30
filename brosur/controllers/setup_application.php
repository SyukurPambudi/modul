<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class setup_application extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->db_plc0 = $this->load->database('brosur0',false, true);
        $this->load->library('lib_plc');
        $this->modul_id = $this->input->get('modul_id');
        $this->iModul_id = $this->lib_plc->getIModulID($this->input->get('modul_id'));
        $this->db = $this->load->database('brosur0',false, true);
        $this->load->library('auth');
        $this->user = $this->auth->user();
        $this->team = $this->lib_plc->hasTeam($this->user->gNIP);
        $this->teamID = $this->lib_plc->hasTeamID($this->user->gNIP);
        $isAdmin=$this->lib_plc->isAdmin($this->user->gNIP);
        $this->isAdmin = $isAdmin;
        $this->main_table='erp_privi.m_application';
        $this->main_table_pk='iM_application';
        $this->haveFlow = array(0 => 'No', 1 => 'Yes');

        $this->title = 'Application';
        $this->url = 'setup_application';
        $this->urlpath = 'plc/'.str_replace("_","/", $this->url);

        $this->maintable = 'erp_privi.m_application';  
        $datagrid['islist'] = array(
            'vAplication_code'      => array('label' => 'Application Code', 'width' => 100, 'align' => 'center',    'search' => false)
            ,'privi_apps.vAppName'  => array('label' => 'Application Name', 'width' => 250, 'align' => 'left',      'search' => true)
            ,'vDesciption'          => array('label' => 'Description',      'width' => 400, 'align' => 'left',      'search' => false)
            ,'iHave_flow'           => array('label' => 'Have Flow',        'width' => 100, 'align' => 'center',    'search' => false)
            ,'m_flow.vNama_flow'    => array('label' => 'Flow Name',        'width' => 100, 'align' => 'left',      'search' => false)
            
        );
        $datagrid['shortBy']=array('iM_application'=>'Desc');

        

        $datagrid['setQuery']=array(
            1 => array('vall' => 'm_application.lDeleted', 'nilai' => 0)        
        );
        
        
        $datagrid['isField'] = array(
			'vAplication_code'  => array('label' => 'Code',              'require' => true)
            ,'idprivi_apps'     => array('label' => 'Application Name',  'require' => true)
            ,'vDesciption'      => array('label' => 'Description',       'require' => true)
            ,'iHave_flow'       => array('label' => 'Have Flow',         'require' => true)
            ,'iM_flow'          => array('label' => 'Active Flow',       'require' => false)
            ,'detail_modul'     => array('label' => 'Application Moduls','require' => false)
            ,'vTable_file'      => array('label' => 'Table File Upload','require' => true) 
            ,'vParent_path_file'     => array('label' => 'Parent SVN Aplication','require' => true)             
        );
        

        $datagrid['jointableleft']=array(
            0 => array('erp_privi.m_flow' => 'erp_privi.m_flow.iM_flow = erp_privi.m_application.iM_flow'),
        );
        

        $datagrid['jointableinner']=array(
            0 => array('erp_privi.privi_apps' => 'erp_privi.privi_apps.idprivi_apps = erp_privi.m_application.idprivi_apps'),
        );
        


        $this->datagrid=$datagrid;
    }

    function index($action = '') {
        $grid = new Grid;       
        $grid->setTitle($this->title);      
        $grid->setTable($this->maintable );
        $grid->setUrl($this->url);
       /* $grid->setGroupBy($this->setGroupBy);*/
        /*Untuk Field*/
        //$grid->addFields('form_detail');
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

            /*Untuk Field*/
			if($kv=='isField'){
                foreach ($vv as $list => $vlist) {
                    $grid->addFields($list);
                    foreach ($vlist as $kdis => $vdis) {
                        if($kdis=='label'){
                            $grid->setLabel($list, $vdis);
                        }
                            if($kdis=='require' && $vdis==true){
                            $grid->setRequired($list);
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

            if($kv=='jointableleft'){
                foreach ($vv as $list => $vlist) {
                    foreach ($vlist as $tbjoin => $onjoin) {
                        $grid->setJoinTable($tbjoin, $onjoin, 'left');
                    }
                }
            }


            if($kv=='setQuery'){
                foreach ($vv as $kv => $vlist) {
                    $grid->setQuery($vlist['vall'], $vlist['nilai']);                    
                }
            }

        }


        $grid->changeFieldType('iApprove_uji','combobox','',array(0=>'Waiting Approval', 1=>'Rejected', 2=>'Approved'));
        $grid->changeFieldType('iSubmit','combobox','',array(0=>'Draft - Need to be Submitted', 1=>'Submitted'));
        // $grid->changeFieldType('iHave_flow','combobox','',array(''=>'Select One',0=>'No', 1=>'Yes'));

        
        $grid->setGridView('grid');

        switch ($action) {
            case 'json':
                $grid->getJsonData();
                break;
            case 'download':
                $this->download($this->input->get('file'));
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

            case 'get_data_prev':
                echo $this->get_data_prev();
                break;

            case 'dataDetailsFlow':
                echo $this->dataDetailsFlow();
                break;

            case 'getProcess':
                echo $this->getProcess();
                break;

            default:
                $grid->render_grid();
                break;
        }
    }

    function listBox_setup_application_iHave_flow($value) {
        return $this->haveFlow[$value];
    }

    function dataDetailsFlow (){
        $post=$this->input->post();
        $get=$this->input->get();
        $nmTable=isset($get['nmTable'])?$get['nmTable']:$this->url;
        $grid=isset($get['grid'])?$get['grid']:$this->url;
        $id=isset($get['id'])?$get['id']:0;
        $sql_data = 'SELECT m.iM_modul, m.vKode_modul, p.vNameModule, p.idprivi_modules FROM erp_privi.m_modul m
                        JOIN erp_privi.privi_modules p ON m.idprivi_modules = p.idprivi_modules
                        WHERE m.lDeleted = 0 AND p.isDeleted = 0 AND m.iM_application = ? 
                        ORDER BY m.vKode_modul ASC ';
        $q=$this->db->query($sql_data, array($id)); 
        $rsel=array('hapus','vKode_modul');
        $data = new StdClass;
        $data->records=$q->num_rows();
        $i=0;
        foreach ($q->result() as $k) {
            $data->rows[$i]['id']=$i;
            $z=0;
            foreach ($rsel as $dsel => $vsel) {
                if ($vsel=="hapus") {
                    $dt =   "<input type='hidden' class='num_rows_".$nmTable."' value='".$i."' />";
                    $dt .=  "<a href='javascript:;' onclick='javascript:hapus_row_".$nmTable."(".$i.")'>";
                    $dt .=      "<center>";
                    $dt .=          "<span class='ui-icon ui-icon-close'></span>";
                    $dt .=      "</center>";
                    $dt .=  "</a>";
                    $dataar[$dsel] = $dt;
                } else if ($vsel=="vKode_modul") {
                    $dt = "<input type='text' size='90' id='".$grid."_vkode_text_".$i."' value='".$k->vKode_modul." - ".$k->vNameModule."' class='autocomplate_flow_process required' name='".$grid."_vkode_text[".$k->iM_modul."][]'>";
                    $dt .= "<input type='hidden' size='10' class='required classiMmodul' value='".$k->idprivi_modules."' id='".$grid."_vkode_".$i."' name='".$grid."_vkode[".$k->iM_modul."][]'>";
                    $dt .= "<input type='hidden' size='10' class='required classiMmodul' value='".$k->iM_modul."' id='".$grid."_im_modul_".$i."' name='".$grid."_imodul[".$k->iM_modul."][]'>";
                    $dataar[$dsel] = $dt;
                } else {
                    $dataar[$dsel]=$k->{$vsel};
                }
                $z++;
            }
            $data->rows[$i]['cell']=$dataar;
            $i++;
        }
        return json_encode($data);
    }

    function getProcess(){
        $term = $this->input->get('term');
        $id = $this->input->get('id'); 
        $sql = 'SELECT m.idprivi_modules, m.vNameModule FROM erp_privi.privi_modules m
                    WHERE m.isDeleted = 0 AND m.idprivi_apps = ?
                    AND m.idprivi_modules NOT IN ( SELECT d.idprivi_modules FROM erp_privi.m_modul d WHERE d.lDeleted = 0 )
                    AND m.vNameModule LIKE ? ';
        $dt=$this->db->query($sql, array($id, '%'.$term.'%')); //print_r($sql.' - '.$id.' - '.$term);exit();
        $data = array();
        if($dt->num_rows > 0){
            foreach($dt->result_array() as $line) {
                $row_array['value'] = 'NEW - '.trim($line['vNameModule']);
                $row_array['id']    = $line['idprivi_modules'];
                array_push($data, $row_array);
            }
        }
        return json_encode($data);
        exit;
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
                                        var url = "'.base_url().'processor/plc/setup_application";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_setup_application").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_setup_application");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_setup_application_approve" action="'.base_url().'processor/plc/setup_application?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iM_application" value="'.$this->input->get('iM_application').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_setup_application_approve\')">Approve</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function approve_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $iM_application = $post['iM_application'];
                $iupb_id = $post['iupb_id'];
                
                $vRemark = $post['vRemark'];
                $modul_id = $post['modul_id'];


                //Letakan Query Update approve disini
                $data=array('iapprove'=>'2');
                $this -> db -> where('iM_application', $iM_application);
                $updet = $this -> db -> update('erp_privi.m_application', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_application = $isAndSort['iM_application'];
                $iSort = $isAndSort['iSort'];

                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iM_application,$iM_application,$iSort,$vRemark,2);
    
                $data['status']  = true;
                $data['last_id'] = $post['iM_application'];
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
                                        var url = "'.base_url().'processor/plc/setup_application";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_setup_application").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_setup_application");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_setup_application_confirm" action="'.base_url().'processor/plc/setup_application?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iM_application" value="'.$this->input->get('iM_application').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_setup_application_confirm\')">Confirm</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function confirm_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $iM_application = $post['iM_application'];
                $iupb_id = $post['iupb_id'];
                $vRemark = $post['vRemark'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $modul_id = $post['modul_id'];

                //Letakan Query Update approve disini
                $data=array('iApprove_uji'=>'2');
                $this -> db -> where('iM_application', $iM_application);
                $updet = $this -> db -> update('erp_privi.m_application', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_application = $isAndSort['iM_application'];
                $iSort = $isAndSort['iSort'];
                
                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iM_application,$iM_application,$iSort,$vRemark,2);

                
                $data['status']  = true;
                $data['last_id'] = $post['iM_application'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }
    
        
            //Ini Merupakan Standart Reject yang digunakan di erp
            function reject_view() {
                $echo = '<script type="text/javascript">
                             function submit_ajax(form_id) {
                                var remark = $("#setup_application_remark").val();
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
                                        var url = "'.base_url().'processor/plc/setup_application";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_setup_application").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_setup_application");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_setup_application_reject" action="'.base_url().'processor/plc/setup_application?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iM_application" value="'.$this->input->get('iM_application').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark" id="reject_setup_application_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_setup_application_reject\')">Reject</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            }
    
    
            
            function reject_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $iM_application = $post['iM_application'];
                $iupb_id = $post['iupb_id'];
                $vRemark = $post['vRemark'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $modul_id = $post['modul_id'];
    
                //Letakan Query Update reject disini
                $data=array('iapprove'=>'1');
                $this -> db -> where('iM_application', $iM_application);
                $updet = $this -> db -> update('erp_privi.m_application', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_application = $isAndSort['iM_application'];
                $iSort = $isAndSort['iSort'];
                
                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iM_application,$iM_application,$iSort,$vRemark,1);
    
                $data['status']  = true;
                $data['last_id'] = $post['iM_application'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }

    
    function output(){
        $this->index($this->input->get('action'));
    }

    function insertBox_setup_application_vAplication_code($field, $id) {
        return 'Auto Generate';
    }
    
    function updateBox_setup_application_vAplication_code($field, $id, $value, $rowData) {
        $return = $value; 
        $return .= '<input type="hidden" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="4" value="'.$value.'"/>';  
        return $return;
    }
    
    function insertBox_setup_application_vNama_activity($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
        return $return;
    }
    
    function updateBox_setup_application_vNama_activity($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                    $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }
    
    function insertBox_setup_application_vDesciption($field, $id) {
        $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250"></textarea>';
        return $return;
    }
    
    function updateBox_setup_application_vDesciption($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                    $return= '<label title="Note">'.nl2br($value).'</label>'; 
            }else{ 
                $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250">'.nl2br($value).'</textarea>';

            }
            
        return $return;
    }

    function insertBox_setup_application_iHave_flow($field, $id) {
        $return = '<script>
                        $("label[for=\'setup_application_iHave_flow\']").parent().hide();
                    </script>';
        return $return;
    }


    function updateBox_setup_application_iHave_flow($field, $id, $value, $rowData) {
        $o = '<select class="" name="'.$field.'" id="'.$id.'">';
        foreach ($this->haveFlow as $k => $v) {
            $selected = ( $value == $k ) ? 'selected' : '';
            $o .= '<option '.$selected.' value="'.$k.'">'.$v.'</option>';
        }
        $o .= '</select>';
        $o .= '<script>
                var haveFlow = $("#'.$id.'").val();
                if (haveFlow == 0){
                    $("label[for=\'setup_application_iM_flow\']").parent().hide();
                }else{
                    $("label[for=\'setup_application_iM_flow\']").parent().show();
                }
                
                $("#'.$id.'").change(function(){
                    var value = $( this ).val();
                    if (value == 0){
                        $("label[for=\'setup_application_iM_flow\']").parent().hide();
                    }else{
                        $("label[for=\'setup_application_iM_flow\']").parent().show();
                    }
                })
            </script>';
        return $o;
    }

    function insertBox_setup_application_iM_flow($field, $id) {
    	$return = '<script>
                        $("label[for=\'setup_application_iM_flow\']").parent().hide();
                    </script>';
        return $return;
    }


    function updateBox_setup_application_iM_flow($field, $id, $value, $rowData) {
    	$flow = $this->db->get_where('erp_privi.m_flow', array( 'lDeleted' => 0, 'iM_application' => $rowData['iM_application'] ))->result_array();
    	$apps = $this->db->get_where('erp_privi.m_application',array('iM_application' => $rowData['iM_application']))->row_array();

    	$echo = '<select class="" name="'.$id.'" id="'.$id.'">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($flow as $f) {
    		$selected = $apps['iM_flow'] == $f['iM_flow'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$f['iM_flow'].'">'.$f['vKode_flow']." - ".$f['vNama_flow'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }

    function insertBox_setup_application_idprivi_apps($field, $id) {
        $sql = 'SELECT a.idprivi_apps, a.vAppName FROM erp_privi.privi_apps a 
                    WHERE a.idprivi_apps NOT IN ( SELECT p.idprivi_apps FROM erp_privi.m_application p WHERE p.lDeleted = 0 ) 
                        AND a.isDeleted = 0 ORDER BY a.vAppName ASC';
        $apps = $this->db->query($sql)->result_array();

    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($apps as $t) {
    		$o .= '<option value="'.$t['idprivi_apps'].'">'.$t['vAppName'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }


    function updateBox_setup_application_idprivi_apps($field, $id, $value, $rowData) {
        $sql = 'SELECT a.idprivi_apps, a.vAppName FROM erp_privi.privi_apps a 
                    WHERE a.idprivi_apps NOT IN ( SELECT p.idprivi_apps FROM erp_privi.m_application p WHERE p.lDeleted = 0 AND p.idprivi_apps <> ? ) 
                        AND a.isDeleted = 0 ORDER BY a.vAppName ASC';
        $apps = $this->db->query($sql, array($value))->result_array();

    	$echo = '<select disabled class="required" name="'.$id.'" id="'.$id.'">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($apps as $t) {
    		$selected = $value == $t['idprivi_apps'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$t['idprivi_apps'].'">'.$t['vAppName'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }
    
    function insertBox_setup_application_detail_modul($field, $id) {
    	$return = '<script>
                        $("label[for=\'setup_application_detail_modul\']").parent().hide();
                    </script>';
    	return $return;
    }


    function updateBox_setup_application_detail_modul($field, $id, $value, $rowData) {
        $data['get']=$this->input->get();
        $data['id']=$this->input->get('id');
        $return = $this->load->view('master_application_detail',$data,TRUE);
        return $return;
    }



    

    function before_insert_processor($row, $postData) {
        $query = "SELECT MAX(iM_application) AS std FROM erp_privi.m_application";
        $rs = $this->db_plc0->query($query)->row_array();
        $nomor = intval($rs['std']) + 1;
        $nomor = "APP".str_pad($nomor, 5, "0", STR_PAD_LEFT);

        $postData['vAplication_code'] = $nomor;
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated'] = $this->user->gNIP;
        $postData['iHave_flow'] = 0; /* print_r($postData);exit(); */
        return $postData;

    }



    function before_update_processor($row, $postData) {
        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;
        unset($postData['idprivi_apps']);
        unset($postData['vAplication_code']);
        return $postData; 
    }

    function after_update_processor($fields, $id, $postData) {
        $idModulOld     = array();
        $idPriviOld     = array();
        $idPriviNew     = array();
        $date           = date("Y-m-d H:i:s");
        $iM_application = $postData['iM_application']; 

        foreach ($postData['vkode'] as $key => $value) {
            if ( $key == 0 ){
                foreach ($value as $v) {
                    array_push($idPriviNew, $v);
                }
            } else {
                array_push($idModulOld, $key);
                array_push($idPriviOld, $value[0]);
            }
        }
        
        $modulExist = $this->db->get_where('erp_privi.m_modul', array( 'iM_application' => $iM_application, 'lDeleted' => 0 ))->result_array();

        foreach ($modulExist as $mod) {
            $id = $mod['iM_modul'];
            if (in_array($id, $idModulOld)) {
                $key = array_search($id, $idModulOld);
                $priviModul = $this->db->get_where('erp_privi.privi_modules', array( 'idprivi_modules' => $idPriviOld[$key], 'isDeleted' => 0 ))->row_array();
                $upd['idprivi_modules']     = $idPriviOld[$key];
                $upd['vCodeModule']         = ( !empty($priviModul) ) ? $priviModul['vCodeModule'] : '-';
                $upd['dupdate']             = $date;
                $upd['cUpdate']             = $this->user->gNIP;
                $this->db->where('iM_modul', $id);
                $this->db->update('erp_privi.m_modul', $upd);
            } else {
                $del['lDeleted']    = 1;
                $del['dupdate']     = $date;
                $del['cUpdate']     = $this->user->gNIP;
                $this->db->where('iM_modul', $id); 
                $this->db->update('erp_privi.m_modul', $del);
            }
        }

        foreach ($idPriviNew as $new) {
            $query = "SELECT MAX(iM_modul) as std from erp_privi.m_modul";
            $rs = $this->db->query($query)->row_array();
            $nomor = intval($rs['std']) + 1;
            $nomor = "MD".str_pad($nomor, 5, "0", STR_PAD_LEFT);

            $priviModul = $this->db->get_where('erp_privi.privi_modules', array( 'idprivi_modules' => $new, 'isDeleted' => 0 ))->row_array();

            if (!empty($new)){
                $ins['vKode_modul']     = $nomor;
                $ins['iM_application']  = $iM_application;
                $ins['idprivi_modules'] = $new;
                $ins['vCodeModule']     = ( !empty($priviModul) ) ? $priviModul['vCodeModule'] : '-';
                $ins['iType_modul']     = 1;
                $ins['dCreate']         = $date;
                $ins['cCreated']        = $this->user->gNIP;
                $upd['lDeleted']        = 0;
                $this->db->insert('erp_privi.m_modul', $ins);
            }
        }

    }





    /*Manipulate Insert/Update Form*/
    function insertBox_setup_application_form_detail($field,$id){
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

    function updateBox_setup_application_form_detail($field,$id,$value,$rowData){
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

    function download($vFilename) { 
        $this->load->helper('download');        
        $name = $vFilename;
        $id = $_GET['id'];
        $tempat = $_GET['path'];    
        $path = file_get_contents('./files/plc/local/uji_mikro_bb/'.$tempat.'/'.$id.'/'.$name);    
        force_download($name, $path);


    }


    function getFormDetail(){
        $post=$this->input->post();
        $get=$this->input->get();
        $data['html']="";

        $sqlFields = 'select * from plc3.m_modul_fields a where a.lDeleted=0 and  a.iM_modul='.$this->iModul_id.' order by a.iSort ASC';
        $dFields = $this->db->query($sqlFields)->result_array();

        $hate_emel = "";

        if($get['formaction']=='update'){
                $aidi = $get['id'];
        }else{
                $aidi = 0;
        }

        $hate_emel .= '
            <table class="hover_table" style="width:60%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
                <thead>
                    <tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
                        <th style="border: 1px solid #dddddd;">Activity Name</th>
                        <th style="border: 1px solid #dddddd;">Status</th>
                        <th style="border: 1px solid #dddddd;">at</th>      
                        <th style="border: 1px solid #dddddd;">by</th>      
                        <th style="border: 1px solid #dddddd;">Remark</th>      
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
                $data_field['get']= $get;
                $data_field['post']= $post;

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

                $return_field="";
                if($get['formaction']=='update'){
                    $id = $get['id'];

                    $sqlGetMainvalue= 'select * from '.$this->main_table.' where lDeleted=0 and '.$this->main_table_pk.'= '.$id.'   ';
                    $dataHead = $this->db->query($sqlGetMainvalue)->row_array();

                    $data_field['dataHead']= $dataHead;
                    $data_field['main_table_pk']= $this->main_table_pk;
                    
                    if($form_field['iM_jenis_field'] == 6){
                        $data_field['vSource_input']= $form_field['vSource_input_edit'] ;
                    }else{
                        $data_field['vSource_input']= $form_field['vSource_input_edit'] ;
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

    function get_data_prev(){
        $post=$this->input->post();
        $get=$this->input->get();
        $nmTable=isset($post["nmTable"])?$post["nmTable"]:"0";
        $grid=isset($post["grid"])?$post["grid"]:"0";
        $grid=isset($post["grid"])?$post["grid"]:"0";
        $namefield=isset($post["namefield"])?$post["namefield"]:"0";

        $this->db_plc0->select("*")
                    ->from("plc2.sys_masterdok")
                    ->where("filename",$namefield);
        $row=$this->db_plc0->get()->row_array();
        
        $where=array('lDeleted'=>0,$row["fieldheader"]=>$post["id"]);
        $this->db_plc0->where($where);
        $q=$this->db_plc0->get($row["filetable"]);
        $rsel=array($row["ffilename"],$row["fvketerangan"],'iact');
        $data = new StdClass;
        $data->records=$q->num_rows();
        $i=0;
        foreach ($q->result() as $k) {
            $data->rows[$i]['id']=$i;
            $z=0;

            $value=$k->vFilename_generate;
            $id=$k->{$row["fieldheader"]};
            $linknya = 'No File';
            if($value != '') {
                if (file_exists('./'.$row["filepath"].'/'.$id.'/'.$value)) {
                    $link = base_url().'processor/'.$this->urlpath.'?action=download&id='.$id.'&file='.$value.'&path='.$row['filename'];
                    $linknya = '<a class="ui-button-text" href="javascript:;" onclick="window.location=\''.$link.'\'">[Download]</a>&nbsp;&nbsp;&nbsp;';
                }
            }
            $linknya=$linknya.'<a class="ui-button-text" href="javascript:;" onclick="javascript:hapus_row_'.$nmTable.'('.$i.')">[Hapus]</a><input type="hidden" class="num_rows_'.$nmTable.'" value="'.$i.'" /><input type="hidden" name="'.$row["fielddetail"].'[]" value="'.$k->{$row["fielddetail"]}.'" />';


            foreach ($rsel as $dsel => $vsel) {
                if($vsel=="iact"){
                    $dataar[$dsel]=$linknya;
                }else{
                    $dataar[$dsel]=$k->{$vsel};
                }
                $z++;
            }
            $data->rows[$i]['cell']=$dataar;
            $i++;
        }
        return json_encode($data);
    }


}
