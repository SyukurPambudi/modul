 
<?php
/* Generated by Softdev 2 ERP Module Generator 2019-02-01 11:09:29 */
/* Location: ./modules/home/controllers/bayar_denda.php */
/* Please DO NOT modify this information : */ 
 

/*
    Preparation 
    1. untuk load view halaman upload , file berada pada folder partial;
    2. lib auth untuk fungsi check modul



    Parameter need to be change after generate 
    1. FOLDER_APP => change to folder name where this controllers should be there
    2. Static Dropdown => change value for option
    3. Dynamic Dropdown => Change query for option

    Table Sample 
    test.item && test.item_file_upload




*/
 


if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class master_bentuk_sediaan_refor extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->db_schedulercheck = $this->load->database('schedulercheck',false, true);
        $this->load->library('auth');
        $this->db = $this->load->database('hrd',false, true);
        $this->user = $this->auth->user();

        /*$checkMod = $this->auth->modul_set($this->input->get('modul_id'));
        $this->validation =$checkMod['iValidation'];*/

    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle('Master Bentuk Sediaan Reformulasi');
        $grid->setTable('reformulasi.master_bentuk_sediaan_refor');      
        $grid->setUrl('master_bentuk_sediaan_refor');


        //List Table
        $grid->addList('master_jenis_sediaan_refor.jenis_sediaan','vBentuk_sediaan','vKeterangan','iStatus'); 
        $grid->setSortBy('id_sediaan','vBentuk_sediaan');
        $grid->setSortOrder('DESC');  

        //List field
        $grid->addFields('id_sediaan','vBentuk_sediaan','vKeterangan','iStatus'); 

        //Setting Grid Width Name 
        /*
        Kamu bisa merubah nama label dari sini, Contoh :
        $grid->setLabel('nama field','nama field yang akan diubah');

        */
        $grid->setWidth('id_sediaan', '250');
        $grid->setAlign('id_sediaan', 'left');
        $grid->setLabel('id_sediaan','Jenis Sediaan Reformulasi');

        $grid->setWidth('master_jenis_sediaan_refor.id_sediaan', '250');
        $grid->setAlign('master_jenis_sediaan_refor.id_sediaan', 'left');
        $grid->setLabel('master_jenis_sediaan_refor.jenis_sediaan','Jenis Sediaan Reformulasi');

        $grid->setWidth('vBentuk_sediaan', '250');
        $grid->setAlign('vBentuk_sediaan', 'left');
        $grid->setLabel('vBentuk_sediaan','Nama Bentuk Sediaan');

        $grid->setWidth('vKeterangan', '250');
        $grid->setAlign('vKeterangan', 'left');
        $grid->setLabel('vKeterangan','Keterangan');

        $grid->setLabel('iStatus','Status');
        $grid->changeFieldType('iStatus','combobox', '', array(0=>'Active', 1=>'Deleted'));
    
//Example modifikasi GRID ERP
    //- Set Query
        $grid->setQuery('master_bentuk_sediaan_refor.lDeleted = 0 ', null); 
        /*if ($this->validation) {
            $grid->setQuery('lDeleted = 0 ', null); 
        }*/

            

/*
    - Set Query
        $grid->setQuery('lDeleted = 0 ', null); 
        $grid->setQuery('plc2_upb.iupb_id IN (select distinct(bk.iupb_id) from plc2.plc2_upb_spesifikasi_fg bk where bk.iappqa=2 and bk.ldeleted=0)', null);  

    - Join Table
        $grid->setJoinTable('hrd.employee', 'employee.cNip = pk_master.vnip', 'inner');

    - Change Field Name
        $grid->changeFieldType('ideleted','combobox','',array(''=>'Pilih',0=>'Aktif',1=>'Tidak aktif'));
*/
    //    $grid->setJoinTable('hrd.employee', 'employee.cNip = bayar_denda.cNip', 'inner');
        $grid->setJoinTable('reformulasi.master_jenis_sediaan_refor','master_jenis_sediaan_refor.id_sediaan = master_bentuk_sediaan_refor.id_sediaan', 'inner');
    //set search
        $grid->setSearch('vBentuk_sediaan','master_jenis_sediaan_refor.jenis_sediaan','iStatus');
        
    //set required
        $grid->setRequired('id_bentuk_sediaan','id_sediaan','vBentuk_sediaan','vketerangan','iStatus','dCreate','cCreated','dUpdate','cUpdate','lDeleted'); 
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
             
                case 'createproses':/*
                    $post=$this->input->post();print_r($post);exit();*/
                        $post = $this->input->post();
                      //  $nama_alasan = ['nama_alasan'];
                        $name = $post['master_bentuk_sediaan_refor_vBentuk_sediaan']; //print_r($_POST);exit();
                        $cek  = $this->db->get_where('reformulasi.master_bentuk_sediaan_refor', array('vBentuk_sediaan' => $name, 'lDeleted' => 0))->num_rows(); 
                        if ($cek > 0){
                            $data['status']  = false;
                            $data['message'] =' "'.$name.'" Sudah Ada';
                            echo json_encode($data);
                        } else {
                            echo $grid->saved_form();
                        }
                        
                    break;
                  
           
            
            case 'update':
                    $grid->render_form($this->input->get('id'));
                    break;

        
            case 'updateproses':
                    $post   = $this->input->post(); 
                        $id     = $post['master_bentuk_sediaan_refor_id_bentuk_sediaan']; 
                        $name   = $post['master_bentuk_sediaan_refor_vBentuk_sediaan']; 
                        $sql    = 'SELECT * FROM reformulasi.master_bentuk_sediaan_refor WHERE id_bentuk_sediaan <> '.$id.' AND vBentuk_sediaan = "'.$name.'" AND lDeleted = 0'; //echo $sql;exit();   
                        //echo ($sql);exit();
                        //$cek    = $this->db->query($sql)->num_rows();  
                        $cek    = $this->db->query($sql, array($id, $name))->num_rows(); 
                        if ($cek > 0){ 
                            $data['status']  = false;
                            $data['message'] = ' "'.$name.'" Sudah Ada';
                            echo json_encode($data);
                        } else {
                            echo $grid->updated_form();
                        }
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
                                    var url = "'.base_url().'processor/home/bayar_denda";                             
                                    if(o.status == true) { 
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id, function(data) {
                                             $("div#form_bayar_denda").html(data);
                                             
                                        });
                                        
                                    }
                                        reload_grid("grid_bayar_denda");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Approve</h1><br />';
            $echo .= '<form id="form_bayar_denda_approve" action="'.base_url().'processor/home/bayar_denda?action=approve_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= 'Remark : 
                    <input type="hidden" name="iBayar_denda" value="'.$this->input->get('iBayar_denda').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    
                    <textarea name="vRemark"></textarea>
            <button type="button" onclick="submit_ajax(\'form_bayar_denda_approve\')">Approve</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        } 

        function approve_process() {
            $post = $this->input->post();
            $cNip= $this->user->gNIP;
            $vName= $this->user->gName;
            $iBayar_denda = $post['iBayar_denda'];
            $vRemark = $post['vRemark'];
            $lvl = $post['lvl'];

            //Letakan Query Update approve disini

            $data['status']  = true;
            $data['last_id'] = $post['iBayar_denda'];
            return json_encode($data);
        }
    */


    /*
        //Ini Merupakan Standart Reject yang digunakan di erp
        function reject_view() {
            $echo = '<script type="text/javascript">
                         function submit_ajax(form_id) {
                            var remark = $("#bayar_denda_remark").val();
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
                                    var url = "'.base_url().'processor/home/bayar_denda";                             
                                    if(o.status == true) { 
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id, function(data) {
                                             $("div#form_bayar_denda").html(data);
                                             
                                        });
                                        
                                    }
                                        reload_grid("grid_bayar_denda");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Reject</h1><br />';
            $echo .= '<form id="form_bayar_denda_reject" action="'.base_url().'processor/home/bayar_denda?action=reject_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= 'Remark : 
                    <input type="hidden" name="iBayar_denda" value="'.$this->input->get('iBayar_denda').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    
                    <textarea name="vRemark" id="reject_bayar_denda_remark"></textarea>
            <button type="button" onclick="submit_ajax(\'form_bayar_denda_reject\')">Reject</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }


        
        function reject_process() {
            $post = $this->input->post();
            $cNip= $this->user->gNIP;
            $vName= $this->user->gName;
            $iBayar_denda = $post['iBayar_denda'];
            $vRemark = $post['vRemark'];
            $lvl = $post['lvl'];

            //Letakan Query Update approve disini

            $data['status']  = true;
            $data['last_id'] = $post['iBayar_denda'];
            return json_encode($data);
        }
    */


    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated']=$this->user->gNIP;


        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } else{
            $postData['iSubmit']=1;
        } 


        return $postData;

    }
    function before_update_processor($row, $postData) {
        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;

        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } else{
            $postData['iSubmit']=1;
        } 


        return $postData; 
    }    
    function insertBox_master_bentuk_sediaan_refor_id_sediaan($field, $id) {
        $teams = $this->db_schedulercheck->get_where('reformulasi.master_jenis_sediaan_refor', array('lDeleted' => 0))->result_array();
        $o = '<select class="required" name="'.$id.'" id="'.$id.'">';
        $o .= '<option value="">--Select--</option>';
        foreach ($teams as $t) {
            $o .= '<option value="'.$t['id_sediaan'].'">'.$t['jenis_sediaan'].'</option>';

        }
        $o .= '</select>';
        return $o;
    }
    function updateBox_master_bentuk_sediaan_refor_id_sediaanx($field, $id, $value, $rowData) {
        $sql = "select * from reformulasi.master_jenis_sediaan_refor a where a.lDeleted=0 ";
        $teams = $this->db_schedulercheck->query($sql)->result_array();
        $echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
        $echo .= '<option value="">--Pilih--</option>';
        foreach($teams as $t) {
            $selected = $rowData['id'] == $t['id'] ? 'selected' : '';
            $echo .= '<option '.$selected.' value="'.$t['id_sediaan'].'">'.$t['jenis_sediaan'].'</option>';
        }
        $echo .= '</select>';
        return $echo;
    }
    function updateBox_master_bentuk_sediaan_refor_id_sediaan($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') { 
            $sql='select * from reformulasi.master_jenis_sediaan_refor a where a.id_sediaan="'.$value.'" ';
            $data = $this->db->query($sql)->row_array();

            $echo .= $data['jenis_sediaan'];
        
        }else{
            
            $sql = "select * from reformulasi.master_jenis_sediaan_refor a where a.lDeleted=0 ";
            $teams = $this->db_schedulercheck->query($sql)->result_array();
            $echo = '<select class="required" name="'.$id.'" id="'.$id.'">';
            $echo .= '<option value="">--Pilih--</option>';
            foreach($teams as $t) {
            $selected = $rowData['id'] == $t['id'] ? 'selected' : '';
            $echo .= '<option '.$selected.' value="'.$t['id_sediaan'].'">'.$t['jenis_sediaan'].'</option>';
        }
        $echo .= '</select>';
        
        }

        return $echo;
    }

    
    function insertBox_master_bentuk_sediaan_refor_vKeterangan($field, $id) {
        $o  = "<textarea name='".$id."' id='".$id."' class='required' style='width: 240px; height: 50px;'size='250'></textarea>";        
        $o .= " <script>
        $('#".$id."').keyup(function() {
        var len = this.value.length;
        if (len >= 250) {
        this.value = this.value.substring(0, 250);
        }
        $('#maxlengthnote').text(250 - len);
        });
        </script>";
        $o .= '<br/>tersisa <span id="maxlengthnote">250</span> karakter<br/>';
    
                                            
        return $o;
       
    }
    function updateBox_master_bentuk_sediaan_refor_vKeterangan($field, $id, $value, $rowData) {
    if ($this->input->get('action') == 'view') { 
        $o = "<label title='Note'>".nl2br($value)."</label>";
    
    }else{
        $o  = "<textarea name='".$id."' id='".$id."' class='required' style='width: 240px; height: 50px;'size='250'>".nl2br($value)."</textarea>";     
        $o .= " <script>
            $('#".$id."').keyup(function() {
            var len = this.value.length;
            if (len >= 250) {
            this.value = this.value.substring(0, 250);
            }
            $('#maxlengthnote').text(250 - len);
            });
            </script>";
              $o .= '<br/>tersisa <span id="maxlengthnote">250</span> karakter<br/>';
    
            }

            return $o;
        }
     public function insertbox_master_bentuk_sediaan_refor_iStatus($field, $id) {
        $lmarketing = array(0=>'Active', 1=>'Deleted');
        $o  = "<select class='required' name='".$field."' id='".$id."'>";
        $o .= "<option value=''></option>";
        foreach($lmarketing as $k=>$v) {
            $o .= "<option value='".$k."'>".$v."</option>";
        }            
        $o .= "</select>";
        
        return $o;
    }
    

    function updateBox_master_jenis_sediaan_refor_iStatus($field, $id, $value, $rowData) {
          $lmarketing = array(0=>'Active', 1=>'Deleted');
        $o  = "<select name='".$field."' id='".$id."'>";
        $o .= "<option value=''></option>";
        foreach($lmarketing as $k=>$v) {
            $o .= "<option value='".$k."'>".$v."</option>";
        }            
        $o .= "</select>";
        
        return $o;
    }


    function after_insert_processor($fields, $id, $postData) {
        //Example After Insert
        /*
        $cNip = $this->sess_auth->gNIP; 
        $sql = 'Place Query In Here';
        $this->db_schedulercheck->query($sql);
        */
    }

    function after_update_processor($fields, $id, $postData) {
        //Example After Update
        /*
        $cNip = $this->sess_auth->gNIP; 
        $sql = 'Place Query In Here';
        $this->db_schedulercheck->query($sql);
        */
    }

    function manipulate_insert_button($buttons) { 
        //Load Javascript In Here 
       /* $cNip= $this->user->gNIP;
        $js = $this->load->view('js/standard_js');
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="bayar_denda_frame" id="bayar_denda_frame" height="0" width="0"></iframe>';
        
        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'bayar_denda\', \' '.base_url().'processor/brosur/bayar_denda?draft=true \',this,true )"  id="button_save_draft_bayar_denda"  class="ui-button-text icon-save" >Save as Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\'bayar_denda\', \' '.base_url().'processor/brosur/bayar_denda?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_save_submit_bayar_denda"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

        

        $buttons['save'] = $iframe.$save_draft.$save.$js;*/
        
        return $buttons;
    }
    function manipulate_update_button($buttons) {
        if ($this->input->get('action') == 'view') {unset($buttons['update']);}

        
       
        
        return $buttons;
    }
  

    function whoAmI($nip) { 
        $sql = 'select b.vDescription as vdepartemen,a.*,b.*,c.iLvlemp 
                        from hrd.employee a 
                        join hrd.msdepartement b on b.iDeptID=a.iDepartementID
                        join hrd.position c on c.iPostId=a.iPostID
                        where a.cNip ="'.$nip.'"
                        ';
        
        $data = $this->db_schedulercheck->query($sql)->row_array();
        return $data;
    }

    function download($vFilename) { 
        $this->load->helper('download');        
        $name = $vFilename;
        $id = $_GET['id'];
        $tempat = $_GET['path'];    
        $path = file_get_contents('./files/brosur/'.$tempat.'/'.$id.'/'.$name);    
        force_download($name, $path);


    }

    //Output
    public function output(){
        $this->index($this->input->get('action'));
    }

}
