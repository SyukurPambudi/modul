 
<?php
/* Generated by Softdev 2 ERP Module Generator 2019-01-07 08:22:11 */
/* Location: ./modules/plc/controllers/plc3_master_activity.php */
/* Please DO NOT modify this information : */ 


/*
    Preparation 
    1. untuk load view halaman upload , file berada pada folder partial;
    2. lib auth untuk fungsi check modul



    Parameter need to be change after generate 
    1. FOLDER_APP => change to folder name where this controllers should be there
    2. Static Dropdown => change value for option
    3. Dynamic Dropdown => Change query for option




*/
 


 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class plc3_master_activity extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->db = $this->load->database('hrd',false, true);
        $this->user = $this->auth->user();

        // $checkMod = $this->auth->modul_set($this->input->get('modul_id'));
        // $this->validation =$checkMod['iValidation'];

    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle('Master Activity');
        $grid->setTable('plc3.m_activity');      
        $grid->setUrl('plc3_master_activity');

        //List Table
        $grid->addList('vKode_activity','vNama_activity','vDesciption'); 
        $grid->setSortBy('iM_activity');
        $grid->setSortOrder('DESC');  

        //List field
        $grid->addFields('vKode_activity','vNama_activity','vDesciption'); 

        //Setting Grid Width Name 
        /*
        Kamu bisa merubah nama label dari sini, Contoh :
        $grid->setLabel('nama field','nama field yang akan diubah');

        */

        $grid->setWidth('vKode_activity', '100');
        $grid->setAlign('vKode_activity', 'left');
        $grid->setLabel('vKode_activity','Kode Activity ');
    
        $grid->setWidth('vNama_activity', '100');
        $grid->setAlign('vNama_activity', 'left');
        $grid->setLabel('vNama_activity','Nama Activity ');
    
        $grid->setWidth('vDesciption', '100');
        $grid->setAlign('vDesciption', 'left');
        $grid->setLabel('vDesciption','Desckripsi ');
    
//Example modifikasi GRID ERP
    //- Set Query
        // if ($this->validation) {
            $grid->setQuery('lDeleted = 0 ', null); 
        // }

        

/*
    - Set Query
        $grid->setQuery('lDeleted = 0 ', null); 
        $grid->setQuery('plc2_upb.iupb_id IN (select distinct(bk.iupb_id) from plc2.plc2_upb_spesifikasi_fg bk where bk.iappqa=2 and bk.ldeleted=0)', null);  

    - Join Table
        $grid->setJoinTable('hrd.employee', 'employee.cNip = pk_master.vnip', 'inner');

    - Change Field Name
        $grid->changeFieldType('ideleted','combobox','',array(''=>'Pilih',0=>'Aktif',1=>'Tidak aktif'));
*/

    //set search
        $grid->setSearch('vKode_activity','vNama_activity');
        
    //set required
        $grid->setRequired('vKode_activity','vNama_activity','vDesciption'); 
        $grid->setGridView('grid');


        switch ($action) {
            case 'json':
                    $grid->getJsonData();
                    break;
            case 'view':
                    $grid->render_form($this->input->get('id'), true);
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

        
            case 'updateproses':
                    echo $grid->updated_form();
                    break;
        
        
            case 'delete':
                    echo $grid->delete_row();
                    break; 
            /*
                //Ini Merupakan Standart Case Untuk Approve

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

                
            */ 
                case 'download':
                    $this->download($this->input->get('file'));
                    break;
            default:
                    $grid->render_grid();
                    break;
        }
    }



    //Jika Ingin Menambahkan Seting grid seperti button edit enable dalam kondisi tertentu
    /* 
    function listBox_Action($row, $actions) {
        if ($row->vNo_Or<>'' || $row->vNo_Or<>NULL) { 
                unset($actions['edit']);
        }
        return $actions;
    } 
    */

                        function insertBox_plc3_master_activity_vKode_activity($field, $id) {
                            $return = 'Auto Generated...!!!';
                            return $return;
                        }
                        
                        function updateBox_plc3_master_activity_vKode_activity($field, $id, $value, $rowData) {
                                if ($this->input->get('action') == 'view') {
                                     $return= $value; 
                                }else{ 
                                    $return = '<input readonly type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

                                }
                                
                            return $return;
                        }
                        
                        function insertBox_plc3_master_activity_vNama_activity($field, $id) {
                            $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
                            return $return;
                        }
                        
                        function updateBox_plc3_master_activity_vNama_activity($field, $id, $value, $rowData) {
                                if ($this->input->get('action') == 'view') {
                                     $return= $value; 
                                }else{ 
                                    $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

                                }
                                
                            return $return;
                        }
                        
                        function insertBox_plc3_master_activity_vDesciption($field, $id) {
                            $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250"></textarea>';
                            return $return;
                        }
                        
                        function updateBox_plc3_master_activity_vDesciption($field, $id, $value, $rowData) {
                                if ($this->input->get('action') == 'view') {
                                     $return= '<label title="Note">'.nl2br($value).'</label>'; 
                                }else{ 
                                    $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250">'.nl2br($value).'</textarea>';

                                }
                                
                            return $return;
                        }
                        
    /*
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
                                    var url = "'.base_url().'processor/plc/plc3_master_activity";                             
                                    if(o.status == true) { 
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id, function(data) {
                                             $("div#form_plc3_master_activity").html(data);
                                             
                                        });
                                        
                                    }
                                        reload_grid("grid_plc3_master_activity");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Approve</h1><br />';
            $echo .= '<form id="form_plc3_master_activity_approve" action="'.base_url().'processor/plc/plc3_master_activity?action=approve_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= 'Remark : 
                    <input type="hidden" name="iM_activity" value="'.$this->input->get('iM_activity').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    
                    <textarea name="vRemark"></textarea>
            <button type="button" onclick="submit_ajax(\'form_plc3_master_activity_approve\')">Approve</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        } 

        function approve_process() {
            $post = $this->input->post();
            $cNip= $this->user->gNIP;
            $vName= $this->user->gName;
            $iM_activity = $post['iM_activity'];
            $vRemark = $post['vRemark'];
            $lvl = $post['lvl'];

            //Letakan Query Update approve disini

            $data['status']  = true;
            $data['last_id'] = $post['iM_activity'];
            return json_encode($data);
        }
    */


    /*
        //Ini Merupakan Standart Reject yang digunakan di erp
        function reject_view() {
            $echo = '<script type="text/javascript">
                         function submit_ajax(form_id) {
                            var remark = $("#plc3_master_activity_remark").val();
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
                                    var url = "'.base_url().'processor/plc/plc3_master_activity";                             
                                    if(o.status == true) { 
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id, function(data) {
                                             $("div#form_plc3_master_activity").html(data);
                                             
                                        });
                                        
                                    }
                                        reload_grid("grid_plc3_master_activity");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Reject</h1><br />';
            $echo .= '<form id="form_plc3_master_activity_reject" action="'.base_url().'processor/plc/plc3_master_activity?action=reject_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= 'Remark : 
                    <input type="hidden" name="iM_activity" value="'.$this->input->get('iM_activity').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    
                    <textarea name="vRemark" id="reject_plc3_master_activity_remark"></textarea>
            <button type="button" onclick="submit_ajax(\'form_plc3_master_activity_reject\')">Reject</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }


        
        function reject_process() {
            $post = $this->input->post();
            $cNip= $this->user->gNIP;
            $vName= $this->user->gName;
            $iM_activity = $post['iM_activity'];
            $vRemark = $post['vRemark'];
            $lvl = $post['lvl'];

            //Letakan Query Update approve disini

            $data['status']  = true;
            $data['last_id'] = $post['iM_activity'];
            return json_encode($data);
        }
    */


    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        $query = "SELECT MAX(iM_activity) as std from plc3.m_activity";
        $rs = $this->db->query($query)->row_array();
        $nomor = intval($rs['std']) + 1;
        $nomor = "AC".str_pad($nomor, 4, "0", STR_PAD_LEFT);

        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated']=$this->user->gNIP;
        $postData['vKode_activity'] = $nomor;


        // if($postData['isdraft']==true){
        //     $postData['iSubmit']=0;
        // } else{
        //     $postData['iSubmit']=1;
        // } 


        return $postData;

    }
    function before_update_processor($row, $postData) {
        $postData['dupdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;

        // if($postData['isdraft']==true){
        //     $postData['iSubmit']=0;
        // } else{
        //     $postData['iSubmit']=1;
        // } 


        return $postData; 
    }    

    function after_insert_processor($fields, $id, $postData) {
        //Example After Insert
        /*
        $cNip = $this->sess_auth->gNIP; 
        $sql = 'Place Query In Here';
        $this->dbset->query($sql);
        */
    }

    function after_update_processor($fields, $id, $postData) {
        //Example After Update
        /*
        $cNip = $this->sess_auth->gNIP; 
        $sql = 'Place Query In Here';
        $this->dbset->query($sql);
        */
    }

    // function manipulate_insert_button($buttons, $rowData) { 
    //     //Load Javascript In Here 
    //     $cNip= $this->user->gNIP;
    //     $js = $this->load->view('js/standard_js');
    //     $js .= $this->load->view('js/upload_js');

    //     $iframe = '<iframe name="plc3_master_activity_frame" id="plc3_master_activity_frame" height="0" width="0"></iframe>';
        
    //     $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'plc3_master_activity\', \' '.base_url().'processor/folder_app/plc3_master_activity?draft=true \',this,true )"  id="button_save_draft_plc3_master_activity"  class="ui-button-text icon-save" >Save as Draft</button>';
    //     $save = '<button onclick="javascript:save_btn_multiupload(\'plc3_master_activity\', \' '.base_url().'processor/folder_app/plc3_master_activity?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_save_submit_plc3_master_activity"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

        

    //     $buttons['save'] = $iframe.$save_draft.$save.$js;
        
    //     return $buttons;
    // }

    // function manipulate_update_button($buttons, $rowData) { 
    //     $peka=$rowData['iM_activity'];


    //     //Load Javascript In Here 
    //     $cNip= $this->user->gNIP;
    //     $js = $this->load->view('js/standard_js');
    //     $js .= $this->load->view('js/upload_js');

    //     $iframe = '<iframe name="plc3_master_activity_frame" id="plc3_master_activity_frame" height="0" width="0"></iframe>';
        
    //     $update_draft = '<button onclick="javascript:update_draft_btn(\'plc3_master_activity\', \' '.base_url().'processor/folder_app/plc3_master_activity?draft=true \',this,true )"  id="button_update_draft_plc3_master_activity"  class="ui-button-text icon-save" >Update as Draft</button>';
    //     $update = '<button onclick="javascript:update_btn_back(\'plc3_master_activity\', \' '.base_url().'processor/folder_app/plc3_master_activity?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_plc3_master_activity"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

    //     $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/folder_app/plc3_master_activity?action=approve&iM_activity='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_plc3_master_activity"  class="ui-button-text icon-save" >Approve</button>';
    //     $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/folder_app/plc3_master_activity?action=reject&iM_activity='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_plc3_master_activity"  class="ui-button-text icon-save" >Reject</button>';
        



    //     if ($this->input->get('action') == 'view') {
    //         unset($buttons['update']);
    //     }
    //     else{ 
    //         $buttons['update'] = $iframe.$update_draft.$update.$js;    
    //     }
        
    //     return $buttons;
    // }

    function whoAmI($nip) { 
        $sql = 'select b.vDescription as vdepartemen,a.*,b.*,c.iLvlemp 
                        from hrd.employee a 
                        join hrd.msdepartement b on b.iDeptID=a.iDepartementID
                        join hrd.position c on c.iPostId=a.iPostID
                        where a.cNip ="'.$nip.'"
                        ';
        
        $data = $this->db->query($sql)->row_array();
        return $data;
    }

    function download($vFilename) { 
        $this->load->helper('download');        
        $name = $vFilename;
        $id = $_GET['id'];
        $tempat = $_GET['path'];    
        $path = file_get_contents('./files/folder_app/'.$tempat.'/'.$id.'/'.$name);    
        force_download($name, $path);


    }

    //Output
    public function output(){
        $this->index($this->input->get('action'));
    }

}
