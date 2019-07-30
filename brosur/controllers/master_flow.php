<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class master_flow extends MX_Controller {
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
        $this->main_table='erp_privi.m_flow';
        $this->main_table_pk='iM_flow';


        $this->title = 'Flow';
        $this->url = 'master_flow';
        $this->urlpath = 'plc/'.str_replace("_","/", $this->url);

        $this->maintable = 'erp_privi.m_flow';
        $datagrid['islist'] = array(    
            'privi_apps.vAppName'   => array('label' => 'Application',    'width' => 100, 'align' => 'center',    'search' => false),
            'vKode_flow'            => array('label' => 'Code',           'width' => 100, 'align' => 'center',    'search' => false),
            'vNama_flow'            => array('label' => 'Name',           'width' => 250, 'align' => 'left',      'search' => false),
            'vDesciption'           => array('label' => 'Description',    'width' => 400, 'align' => 'left',      'search' => false),
        );

        $datagrid['shortBy']=array('iM_flow'=>'Desc');

        

        $datagrid['setQuery']=array(
            1=>array('vall'=>'m_flow.lDeleted','nilai'=>0)
        );
        
        
        $datagrid['isField'] = array(
			'vKode_flow'    => array('label' =>' Code',          'require' => true),
            'iM_application'=> array('label' => 'Aplikasi',      'require' => true),
            'vNama_flow'    => array('label' => 'Nama Flow',     'require' => true),
            'vDesciption'   => array('label' =>' Description',   'require' => true),
            'detail_flow'   => array('label' =>' Detail Flow',   'require' => true),
        );
        
        $datagrid['jointableinner']=array(
            0 => array('erp_privi.m_application'    => 'erp_privi.m_application.iM_application  = erp_privi.m_flow.iM_application'),
            1 => array('erp_privi.privi_apps'       => 'erp_privi.privi_apps.idprivi_apps       = erp_privi.m_application.idprivi_apps'),
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
            if($kv=='setQuery'){
                foreach ($vv as $kv => $vlist) {
                    $grid->setQuery($vlist['vall'], $vlist['nilai']);


                    
                }
            }

        }


        $grid->changeFieldType('iApprove_uji','combobox','',array(0=>'Waiting Approval', 1=>'Rejected', 2=>'Approved'));
        $grid->changeFieldType('iSubmit','combobox','',array(0=>'Draft - Need to be Submitted', 1=>'Submitted'));
        $grid->changeFieldType('iTujuan_req','combobox','',array(1=>'Untuk Sample', 2=>'Untuk Pilot'));

        
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
            case 'getApplication':
                echo $this->getApplication();
                break;
            case 'dataDetailsFlow':
                echo $this->dataDetailsFlow();
                break;
            default:
                $grid->render_grid();
                break;
        }
    }

    function getApplication (){
        $term = $this->input->get('term');
        $sql = 'SELECT a.iM_application, a.vDesciption, a.vAplication_code FROM erp_privi.m_application a WHERE ( a.vDesciption LIKE ? OR a.vAplication_code LIKE ? ) AND lDeleted = 0 AND a.iM_application NOT IN (SELECT iM_application FROM erp_privi.m_flow WHERE lDeleted = 0)';
        $dt = $this->db->query($sql, array('%'.$term.'%','%'.$term.'%'));

        $data = array();
        if($dt->num_rows>0){
            foreach($dt->result_array() as $line) {
    
                $row_array['value'] = $line['vAplication_code'].' - '.trim($line['vDesciption']);
                $row_array['id']    = $line['iM_application'];
    
                array_push($data, $row_array);
            }
        }
        return json_encode($data);
        exit;
    }

    function dataDetailsFlow (){
        $post=$this->input->post();
        $get=$this->input->get();
        $nmTable=isset($get['nmTable'])?$get['nmTable']:$this->url;
        $grid=isset($get['grid'])?$get['grid']:$this->url;
        $id=isset($get['id'])?$get['id']:0;
        $sql_data = 'SELECT p.iM_flow_proses, p.iM_flow, p.iM_modul, p.iUrut, f.iM_application, f.vKode_flow, f.vNama_flow, a.idprivi_apps, a.vAplication_code, a.vDesciption, m.vKode_modul, 
                        m.vDesciption AS vNamaModul, v.vNameModule
                    FROM erp_privi.m_flow_proses p
                    JOIN erp_privi.m_flow f ON p.iM_flow = f.iM_flow
                    JOIN erp_privi.m_application a ON f.iM_application = a.iM_application
                    JOIN erp_privi.m_modul m ON p.iM_modul = m.iM_modul
                    JOIN erp_privi.privi_modules v ON m.idprivi_modules = v.idprivi_modules
                    WHERE p.lDeleted = 0 AND f.lDeleted = 0 AND a.lDeleted = 0 AND m.lDeleted = 0 AND p.iM_flow = ?
                    ORDER BY p.iUrut asc';
        $q=$this->db->query($sql_data, array($id));
        $rsel=array('hapus','vKode_modul',"iUrut");
        $data = new StdClass;
        $data->records=$q->num_rows();
        $i=0;
        foreach ($q->result() as $k) {
            $data->rows[$i]['id']=$i;
            $z=0;
            foreach ($rsel as $dsel => $vsel) {
                if($vsel=="hapus"){
                    $dataar[$dsel]="<input type='hidden' class='num_rows_".$nmTable."' value='".$i."' /><a href='javascript:;' onclick='javascript:hapus_row_".$nmTable."(".$i.")'><center><span class='ui-icon ui-icon-close'></span></center></a>";
                }elseif($vsel=="vKode_modul"){
                    $dataar[$dsel]="<input type='text' size='35' id='".$grid."_vkode_text_".$i."' value='".$k->vKode_modul." - ".$k->vNameModule."' class='autocomplate_flow_process required' name='".$grid."_vkode_text[".$k->iM_flow_proses."][]'><input type='hidden' size='10' class='required classiMmodul' value='".$k->iM_modul."' id='".$grid."_vkode_".$i."' name='".$grid."_vkode[".$k->iM_flow_proses."][]'>";
                }elseif($vsel=="iUrut"){
                    $dataar[$dsel]="<input type='text' size='5' id='".$grid."_iUrut_".$i."' value='".$k->iUrut."' class='numbersOnly required' name='".$grid."_iUrut[".$k->iM_flow_proses."][]'>";
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
                                        var url = "'.base_url().'processor/plc/master_flow";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_master_flow").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_master_flow");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_master_flow_approve" action="'.base_url().'processor/plc/master_flow?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iM_flow" value="'.$this->input->get('iM_flow').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_master_flow_approve\')">Approve</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function approve_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $iM_flow = $post['iM_flow'];
                $iupb_id = $post['iupb_id'];
                
                $vRemark = $post['vRemark'];
                $modul_id = $post['modul_id'];


                //Letakan Query Update approve disini
                $data=array('iapprove'=>'2');
                $this -> db -> where('iM_flow', $iM_flow);
                $updet = $this -> db -> update('erp_privi.m_flow', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_flow = $isAndSort['iM_flow'];
                $iSort = $isAndSort['iSort'];

                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iM_flow,$iM_flow,$iSort,$vRemark,2);
    
                $data['status']  = true;
                $data['last_id'] = $post['iM_flow'];
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
                                        var url = "'.base_url().'processor/plc/master_flow";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_master_flow").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_master_flow");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_master_flow_confirm" action="'.base_url().'processor/plc/master_flow?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iM_flow" value="'.$this->input->get('iM_flow').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_master_flow_confirm\')">Confirm</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function confirm_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $iM_flow = $post['iM_flow'];
                $iupb_id = $post['iupb_id'];
                $vRemark = $post['vRemark'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $modul_id = $post['modul_id'];

                //Letakan Query Update approve disini
                $data=array('iApprove_uji'=>'2');
                $this -> db -> where('iM_flow', $iM_flow);
                $updet = $this -> db -> update('erp_privi.m_flow', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_flow = $isAndSort['iM_flow'];
                $iSort = $isAndSort['iSort'];
                
                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iM_flow,$iM_flow,$iSort,$vRemark,2);

                
                $data['status']  = true;
                $data['last_id'] = $post['iM_flow'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }
    
        
            //Ini Merupakan Standart Reject yang digunakan di erp
            function reject_view() {
                $echo = '<script type="text/javascript">
                             function submit_ajax(form_id) {
                                var remark = $("#master_flow_remark").val();
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
                                        var url = "'.base_url().'processor/plc/master_flow";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_master_flow").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_master_flow");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_master_flow_reject" action="'.base_url().'processor/plc/master_flow?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iM_flow" value="'.$this->input->get('iM_flow').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark" id="reject_master_flow_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_master_flow_reject\')">Reject</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            }
    
    
            
            function reject_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $iM_flow = $post['iM_flow'];
                $iupb_id = $post['iupb_id'];
                $vRemark = $post['vRemark'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $modul_id = $post['modul_id'];
    
                //Letakan Query Update reject disini
                $data=array('iapprove'=>'1');
                $this -> db -> where('iM_flow', $iM_flow);
                $updet = $this -> db -> update('erp_privi.m_flow', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_flow = $isAndSort['iM_flow'];
                $iSort = $isAndSort['iSort'];
                
                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iM_flow,$iM_flow,$iSort,$vRemark,1);
    
                $data['status']  = true;
                $data['last_id'] = $post['iM_flow'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }    

    
    function output(){
        $this->index($this->input->get('action'));
    }

        function insertBox_master_flow_vKode_flow($field, $id) {
        return 'Auto Generated';
    }
    
    function updateBox_master_flow_vKode_flow($field, $id, $value, $rowData) {
        $return = '<input type="hidden" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="4" value="'.$value.'"/>';
        $return .= $value;
        return $return;
    }
    
    function insertBox_master_flow_vNama_flow($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
        return $return;
    }
    
    function updateBox_master_flow_vNama_flow($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                    $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }

    function insertBox_master_flow_iM_application($field, $id) {
        $return = '<input type="hidden" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
        $return .= '<input type="text" id="'.$id.'_dis"  class="input_rows1 required '.$id.'" size="30"  />';
        $return .= '<script>
                     $(".'.$id.'" ).livequery(function() {
                        $( this ).autocomplete({
                            source: function( request, response) {
                                $.ajax({
                                    url: base_url+"processor/brosur/master/flow?action=getApplication",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                    },
                                    success: function( data ) {
                                        response( data );
                                    }
                                });
                            },
                            select: function(event, ui){
                                $( "#'.$id.'" ).val(ui.item.id);
                                $( "#'.$id.'_dis" ).val(ui.item.value);
                                return false;
                            },
                            minLength: 3,
                            autoFocus: true,
                        });

                        $(this).blur(function(){
                            if($( "#'.$id.'" ).val() == "") {
                                $( "#'.$id.'" ).val("");
                                $( "#'.$id.'_dis" ).val("");
                            }           
                        })

                    });
                   </script>';
        return $return;
    }
    
    function updateBox_master_flow_iM_application($field, $id, $value, $rowData) {
        $sql = 'SELECT * FROM erp_privi.m_application WHERE iM_application = ? AND lDeleted = 0';
        $apps = $this->db->query($sql, array($value))->row_array();
        
        $return = '<input type="hidden" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';
        $return .= (!empty($apps)) ? $apps['vAplication_code'].' - '.$apps['vDesciption']:'-';
            
        return $return;
    }
    
    function insertBox_master_flow_vDesciption($field, $id) {
        $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250"></textarea>';
        return $return;
    }
    
    function updateBox_master_flow_vDesciption($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                    $return= '<label title="Note">'.nl2br($value).'</label>'; 
            }else{ 
                $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250">'.nl2br($value).'</textarea>';

            }
            
        return $return;
    }

    function insertBox_master_flow_detail_flow($field, $id) {
        $return = '<script>
                    $("label[for=\''.$id.'\']").parent().hide();
                </script>';
        return $return;
    }

    function updateBox_master_flow_detail_flow($field, $id, $value, $rowData) {
        $sqlHaveFlow = 'SELECT iHave_flow FROM erp_privi.m_application WHERE iM_application = ? AND lDeleted = 0';
        $dtHaveFlow = $this->db->query($sqlHaveFlow, array($rowData['iM_application']))->row_array();
        $isHaveFlow = (!empty($dtHaveFlow)) ? $dtHaveFlow['iHave_flow']:0;
        if (intval($isHaveFlow) == 1){
            $data['get']=$this->input->get();
            $data['id']=$this->input->get('id');
            $return = $this->load->view('master_flow_details',$data,TRUE);
        }else{
            $return = '<script>
                            $("label[for=\''.$id.'\']").parent().hide();
                        </script>';
        }
        return $return;
    }
    

    function before_insert_processor($row, $postData) {
        $query = "SELECT MAX(iM_flow) as std from erp_privi.m_flow";
        $rs = $this->db->query($query)->row_array();
        $nomor = intval($rs['std']) + 1;
        $nomor = "FL".str_pad($nomor, 3, "0", STR_PAD_LEFT);

        $postData['vKode_flow'] = $nomor;
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated']=$this->user->gNIP;  
        return $postData;
    }



    function before_update_processor($row, $postData) {

        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;
        unset($postData['vKode_flow']);
        unset($postData['iM_application']);
        return $postData; 
    }

    function after_update_processor($fields, $id, $postData) { 
        $vkodeInsert=array();
        $vkodeUpdate=array();
        $iUrutInsert=array();
        $iUrutUpdate=array();
        $idupdate=array();

        $iM_flow=$postData['master_flow_iM_flow'];

        foreach ($postData as $kpost => $vpost) {
            if($kpost=="master_flow_vkode"){
                foreach ($vpost as $key => $vbel) {
                    if($key==0){
                        foreach ($vbel as $kbel => $vlast) {
                            $vkodeInsert[$kbel]=$vlast;
                        }
                    }else{
                        foreach ($vbel as $kbel => $vlast) {
                            $vkodeUpdate[$key]=$vlast;
                        }
                        $idupdate[]=$key;
                    }
                }
            }

            if($kpost=="master_flow_iUrut"){
                foreach ($vpost as $key => $vbel) {
                    if($key==0){
                        foreach ($vbel as $kbel => $vlast) {
                            $iUrutInsert[$kbel]=$vlast;
                        }
                    }else{
                        foreach ($vbel as $kbel => $vlast) {
                            $iUrutUpdate[$key]=$vlast;
                        }
                    }
                }
            }
        }
        $date=date("Y-m-d H:i:s");
        if(count($idupdate)==0){
            $datadel=array();
            $datadel['lDeleted']=1;
            $datadel['dupdate']=$date;
            $datadel['cUpdate']=$this->user->gNIP;
            $this->db->where('iM_flow',$iM_flow);
            if($this->db->update("erp_privi.m_flow_proses",$datadel)){

            }else{
                echo "Deleted Failed";
            }
        }else{
            $datadel=array();
            $datadel['lDeleted']=1;
            $datadel['dupdate']=$date;
            $datadel['cUpdate']=$this->user->gNIP;
            $this->db->where('iM_flow',$iM_flow);
            $this->db->where_not_in('iM_flow_proses',$idupdate);
            if($this->db->update("erp_privi.m_flow_proses",$datadel)){

            }else{
                echo "Deleted Failed";
            }
        }

        
        if(count($vkodeInsert)>0){
            foreach ($vkodeInsert as $ki => $vi) {
                $dataInsert=array();
                $iUrut=isset($iUrutInsert[$ki])?$iUrutInsert[$ki]:'0';
                $dataInsert['iM_modul']=$vi;
                $dataInsert['iM_flow']=$iM_flow;
                $dataInsert['iUrut']=$iUrut;
                $dataInsert['dCreate']=$date;
                $dataInsert['cCreated']=$this->user->gNIP;
                if($this->db->insert('erp_privi.m_flow_proses',$dataInsert)){

                }else{
                    echo "Failed Insert";
                }
            }
        }

        if(count($vkodeUpdate)){
            foreach ($vkodeUpdate as $ku => $vu) {
                $this->db->where('iM_flow_proses',$ku);
                $dataupdate=array();
                $dataupdate['iM_modul']=$vu;
                $iUrut=isset($iUrutUpdate[$ku])?$iUrutUpdate[$ku]:'0';
                $dataupdate['iUrut']=$iUrut;
                $dataupdate['dupdate']=$date;
                $dataupdate['cUpdate']=$this->user->gNIP;
                if($this->db->update('erp_privi.m_flow_proses',$dataupdate)){

                }else{
                    echo "Failed Insert";
                }
            }
        }

    }


}
