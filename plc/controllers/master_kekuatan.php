 <?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class master_kekuatan extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->db = $this->load->database('hrd',false, true);
        $this->user = $this->auth->user();
    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle('MASTER KEKUATAN');
        $grid->setTable('plc2.master_kekuatan');      
        $grid->setUrl('master_kekuatan');

        //List Table
        $grid->addList('vKekuatan'); 
        $grid->setSortBy('ims_kekuatan');
        $grid->setSortOrder('DESC');  

        //List field
        $grid->addFields('vKekuatan'); 

        //Setting Grid Width Name 
        /*
        Kamu bisa merubah nama label dari sini, Contoh :
        $grid->setLabel('nama field','nama field yang akan diubah');

        */

        $grid->setWidth('vKekuatan', '100');
        $grid->setAlign('vKekuatan', 'left');
        $grid->setLabel('vKekuatan','Kekuatan');
    
//Example modifikasi GRID ERP
    //- Set Query
            $grid->setQuery('lDeleted = 0 ', null); 

        

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
        $grid->setSearch('vKekuatan');
        
    //set required
        $grid->setRequired('vKekuatan'); 
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

                        function insertBox_master_kekuatan_vKekuatan($field, $id) {
                            $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
                            return $return;
                        }
                        
                        function updateBox_master_kekuatan_vKekuatan($field, $id, $value, $rowData) {
                                if ($this->input->get('action') == 'view') {
                                     $return= $value; 
                                }else{ 
                                    $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

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
                                    var url = "'.base_url().'processor/plc/master_kekuatan";                             
                                    if(o.status == true) { 
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id, function(data) {
                                             $("div#form_master_kekuatan").html(data);
                                             
                                        });
                                        
                                    }
                                        reload_grid("grid_master_kekuatan");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Approve</h1><br />';
            $echo .= '<form id="form_master_kekuatan_approve" action="'.base_url().'processor/plc/master_kekuatan?action=approve_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= 'Remark : 
                    <input type="hidden" name="ims_kekuatan" value="'.$this->input->get('ims_kekuatan').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    
                    <textarea name="vRemark"></textarea>
            <button type="button" onclick="submit_ajax(\'form_master_kekuatan_approve\')">Approve</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        } 

        function approve_process() {
            $post = $this->input->post();
            $cNip= $this->user->gNIP;
            $vName= $this->user->gName;
            $ims_kekuatan = $post['ims_kekuatan'];
            $vRemark = $post['vRemark'];
            $lvl = $post['lvl'];

            //Letakan Query Update approve disini

            $data['status']  = true;
            $data['last_id'] = $post['ims_kekuatan'];
            return json_encode($data);
        }
    */


    /*
        //Ini Merupakan Standart Reject yang digunakan di erp
        function reject_view() {
            $echo = '<script type="text/javascript">
                         function submit_ajax(form_id) {
                            var remark = $("#master_kekuatan_remark").val();
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
                                    var url = "'.base_url().'processor/plc/master_kekuatan";                             
                                    if(o.status == true) { 
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id, function(data) {
                                             $("div#form_master_kekuatan").html(data);
                                             
                                        });
                                        
                                    }
                                        reload_grid("grid_master_kekuatan");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Reject</h1><br />';
            $echo .= '<form id="form_master_kekuatan_reject" action="'.base_url().'processor/plc/master_kekuatan?action=reject_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= 'Remark : 
                    <input type="hidden" name="ims_kekuatan" value="'.$this->input->get('ims_kekuatan').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    
                    <textarea name="vRemark" id="reject_master_kekuatan_remark"></textarea>
            <button type="button" onclick="submit_ajax(\'form_master_kekuatan_reject\')">Reject</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }


        
        function reject_process() {
            $post = $this->input->post();
            $cNip= $this->user->gNIP;
            $vName= $this->user->gName;
            $ims_kekuatan = $post['ims_kekuatan'];
            $vRemark = $post['vRemark'];
            $lvl = $post['lvl'];

            //Letakan Query Update approve disini

            $data['status']  = true;
            $data['last_id'] = $post['ims_kekuatan'];
            return json_encode($data);
        }
    */


    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreate']=$this->user->gNIP;
        return $postData;

    }
    function before_update_processor($row, $postData) {
        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;
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

    //     $iframe = '<iframe name="master_kekuatan_frame" id="master_kekuatan_frame" height="0" width="0"></iframe>';
        
    //     $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'master_kekuatan\', \' '.base_url().'processor/folder_app/master_kekuatan?draft=true \',this,true )"  id="button_save_draft_master_kekuatan"  class="ui-button-text icon-save" >Save as Draft</button>';
    //     $save = '<button onclick="javascript:save_btn_multiupload(\'master_kekuatan\', \' '.base_url().'processor/folder_app/master_kekuatan?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_save_submit_master_kekuatan"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

        

    //     $buttons['save'] = $iframe.$save_draft.$save.$js;
        
    //     return $buttons;
    // }

    // function manipulate_update_button($buttons, $rowData) { 
    //     $peka=$rowData['ims_kekuatan'];


    //     //Load Javascript In Here 
    //     $cNip= $this->user->gNIP;
    //     $js = $this->load->view('js/standard_js');
    //     $js .= $this->load->view('js/upload_js');

    //     $iframe = '<iframe name="master_kekuatan_frame" id="master_kekuatan_frame" height="0" width="0"></iframe>';
        
    //     $update_draft = '<button onclick="javascript:update_draft_btn(\'master_kekuatan\', \' '.base_url().'processor/folder_app/master_kekuatan?draft=true \',this,true )"  id="button_update_draft_master_kekuatan"  class="ui-button-text icon-save" >Update as Draft</button>';
    //     $update = '<button onclick="javascript:update_btn_back(\'master_kekuatan\', \' '.base_url().'processor/folder_app/master_kekuatan?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_master_kekuatan"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

    //     $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/folder_app/master_kekuatan?action=approve&ims_kekuatan='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_master_kekuatan"  class="ui-button-text icon-save" >Approve</button>';
    //     $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/folder_app/master_kekuatan?action=reject&ims_kekuatan='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_master_kekuatan"  class="ui-button-text icon-save" >Reject</button>';
        



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
