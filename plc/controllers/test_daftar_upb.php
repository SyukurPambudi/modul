 
<?php
/* Generated by Softdev 2 ERP Module Generator 2018-12-11 15:52:23 */
/* Location: ./modules/menu/controllers/test_daftar_upb.php */
/* Please DO NOT modify this information : */ 


/*
    Preparation 
    1. untuk load view halaman upload , file berada pada folder partial;
    2. lib auth untuk fungsi check modul



    Parameter need to be change after generate 
    1. plc => change to folder name where this controllers should be there
    2. Static Dropdown => change value for option
    3. Dynamic Dropdown => Change query for option

    Table Sample 
    test.item && test.item_file_upload




*/
 


 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class test_daftar_upb extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('auth');
        $this->load->library('lib_plc');
        $this->db = $this->load->database('hrd',false, true);
        $this->user = $this->auth->user();
        $this->modul_id = $this->input->get('modul_id');
        /*$checkMod = $this->lib_plc->modul_set($this->input->get('modul_id'));
        $this->validation =$checkMod['iValidation'];*/

    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle('TEST_DAFTAR_UPB');
        $grid->setTable('plc2.plc2_upb');      
        $grid->setUrl('test_daftar_upb');

        //List Table
        $grid->addList('vupb_nomor','vupb_nama','vKode_obat'); 
        $grid->setSortBy('iupb_id');
        $grid->setSortOrder('DESC');  

        //List field
        $grid->addFields('vupb_nomor','vupb_nama','vKode_obat'); 

        //Setting Grid Width Name 
        /*
        Kamu bisa merubah nama label dari sini, Contoh :
        $grid->setLabel('nama field','nama field yang akan diubah');

        */

        $grid->setWidth('vupb_nomor', '100');
        $grid->setAlign('vupb_nomor', 'left');
        $grid->setLabel('vupb_nomor','No UPB');
    
        $grid->setWidth('vupb_nama', '100');
        $grid->setAlign('vupb_nama', 'left');
        $grid->setLabel('vupb_nama','Nama UPB');
    
        $grid->setWidth('vKode_obat', '100');
        $grid->setAlign('vKode_obat', 'left');
        $grid->setLabel('vKode_obat','Kode Obat');
    
//Example modifikasi GRID ERP
    //- Set Query
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

    //set search
        $grid->setSearch('vupb_nomor','vupb_nama','vKode_obat');
        
    //set required
        $grid->setRequired('vupb_nomor','vupb_nama','vKode_obat','iKill','vnipKill','dateKill','tKill','inonKill','vnipnonKill','datenonKill','tnonKill','cnip','ttanggal','tunique','tpacking','ikategori_id','ikategoriupb_id','isediaan_id','ipatent','tinfo_paten','patent_year','ibe','iuji_mikro','ipublish','iappdireksi','iappbusdev_prareg','tappbusdev_prareg','tappbusdev_registrasi','vnip_appbusdev_prareg','iappdireksi_prareg','tTglTD_prareg','tTgl_SubDokTD_prareg','iappbusdev_registrasi','tsubmit_tdApplet','tsubmit_dokapplet','tTd_applet','vnip_appbusdev_registrasi','iappdireksi_registrasi','vnip_kirim_sample','vnip_terima_sample','tkirim_sample','tterima_sample','tterima_sample_i','iavailability_raw','itipe_id','idivid','vkat_originator','voriginator','voriginator_price','voriginator_kemas','vgenerik','tindikasi','vhpp_target','iregister','idevelop','vdevelop','pic_produksi','iteambusdev_id','iteampd_id','iteamqa_id','iteamqc_id','iteamad_id','iteammarketing_id','iappmarketing','iappbusdev','tmemo_date','tmemo','fmemolaunchingfile','tmemo_busdev','iprioritas','irequest','isample','ipraregistrasi','icheck_praregistrasi','iregistrasi','icheck_registrasi','ikesesuaian','ttarget_prareg','tsubmit_prareg','ttarget_hpr','tterima_hpr','icap_lengkap','icap_lengkap_prareg','dcap_lengkap','dcap_lengkap_prareg','dmulai_reg','tspb','ttarget_reg','tsubmit_reg','ttarget_noreg','tterima_noreg','tbayar_reg','trealisasi_no','vnoreg','vfileregistrasi','tterimabb_date','tterimabk_date','ispekpd','ispekqc','ispekqa','isoipd','isoiqc','isoiqa','isoibbqc','isoibbqa','imoapd','imoaqc','imoaqa','imikpd','imikqc','imikqa','istatus','ihpp','isucced6','ilaunch','ilaunch_mr','ilaunch_dr','ihold','iholddate','ldeleted','FLAG','C_USERID','C_DIVISI','tlast_conversion','txtDocBB','txtDocSM','isOldVersion','iCompanyId','vCopy_Product','dosis','iconfirm_dok','iconfirm_dok_pd','iconfirm_dok_qa','isubmit_bd','isubmit_registrasi_bd','vnip_confirm_dok_pd','vnip_confirm_dok_qa','vnip_confirm_dok','tconfirm_dok','tconfirm_dok_pd','tconfirm_dok_qa','vcatatan_confirm_dok','istatus_launching','vmemo_launching','iApp_rev','iRevisi','iProsesKe','istudypd','istudyad','itambahan_hpr','dinput_hpr','iappbd_hpr','cappbd_hpr','dappbd_hpr','iconfirm_registrasi','iconfirm_registrasi_pd','dconfirm_registrasi','dconfirm_registrasi_pd','iconfirm_registrasi_qa','cnip_confirm_registrasi_qa','tconfirm_registrasi_qa','vnie','tregistrasi','cconfirm_registrasi','cconfirm_registrasi_pd','iconfirm_registrasi_pac','dconfirm_registrasi_pac','cconfirm_registrasi_pac','itambahan_applet','iappbd_applet','cappbd_applet','dappbd_applet','dinput_applet','no_fero_applet','iGroup_produk','tAturan','tKegunaan','vVarian','vHarga_jual','iRevOtc','iReview','cReview','dReview','iSubmit_review','vAlasan_review','iperlu_hpr','iLabext','irefor','vnama_produk','imaster_delivery','isentmail_pd_prareg','isentmail_hpr','isentmail_applet','remark_appbusdev_prareg'); 
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

                case 'confirm':
                    echo $this->confirm_view();
                    break;
                case 'confirm_process':
                    echo $this->confirm_process();
                    break;


                
             
                case 'download':
                    $this->download($this->input->get('file'));
                    break;
            default:
                    $grid->render_grid();
                    break;
        }
    }



    //Jika Ingin Menambahkan Seting grid seperti button edit enable dalam kondisi tertentu
    function listBox_Action($row, $actions) {
        $peka=$row->iupb_id;
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

                        function insertBox_test_daftar_upb_vupb_nomor($field, $id) {
                            $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
                            $return .='<input type="hidden" name="isdraft" id="isdraft">';
                            return $return;
                        }
                        
                        function updateBox_test_daftar_upb_vupb_nomor($field, $id, $value, $rowData) {
                                if ($this->input->get('action') == 'view') {
                                     $return= $value; 
                                }else{ 
                                    $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';
                                    $return .='<input type="hidden" name="isdraft" id="isdraft">';

                                }
                                
                            return $return;
                        }
                        
                        function insertBox_test_daftar_upb_vupb_nama($field, $id) {
                            $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
                            return $return;
                        }
                        
                        function updateBox_test_daftar_upb_vupb_nama($field, $id, $value, $rowData) {
                                if ($this->input->get('action') == 'view') {
                                     $return= $value; 
                                }else{ 
                                    $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

                                }
                                
                            return $return;
                        }
                        
                        function insertBox_test_daftar_upb_vKode_obat($field, $id) {
                            $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 angka required" size="10" />';
                            return $return;
                        }
                        
                        function updateBox_test_daftar_upb_vKode_obat($field, $id, $value, $rowData) {
                                if ($this->input->get('action') == 'view') {
                                     $return= $value; 
                                }else{ 
                                    $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 angka required" size="10" value="'.$value.'"/>';

                                }
                                
                            return $return;
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
                                    var url = "'.base_url().'processor/plc/test_daftar_upb";                             
                                    if(o.status == true) { 
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                             $("div#form_test_daftar_upb").html(data);
                                             
                                        });
                                        
                                    }
                                        reload_grid("grid_test_daftar_upb");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Approve</h1><br />';
            $echo .= '<form id="form_test_daftar_upb_approve" action="'.base_url().'processor/plc/test_daftar_upb?action=approve_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= 'Remark : 
                    <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    
                    <textarea name="vRemark"></textarea>
            <button type="button" onclick="submit_ajax(\'form_test_daftar_upb_approve\')">Approve</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        } 

        function approve_process() {
            $post = $this->input->post();
            $cNip= $this->user->gNIP;
            $vName= $this->user->gName;
            $iupb_id = $post['iupb_id'];
            $vRemark = $post['vRemark'];
            $modul_id = $post['modul_id'];
            $lvl = $post['lvl'];

            //Letakan Query Update approve disini

            $this->lib_plc->InsertActivityModule($modul_id,$iupb_id,3,2);

            $data['status']  = true;
            $data['last_id'] = $post['iupb_id'];
            $data['group_id'] = $post['group_id'];
            $data['modul_id'] = $post['modul_id'];
            return json_encode($data);
        }


        //Ini Merupakan Standart Approve yang digunakan di erp
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
                                    var url = "'.base_url().'processor/plc/test_daftar_upb";                             
                                    if(o.status == true) { 
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                             $("div#form_test_daftar_upb").html(data);
                                             
                                        });
                                        
                                    }
                                        reload_grid("grid_test_daftar_upb");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Confirm</h1><br />';
            $echo .= '<form id="form_test_daftar_upb_confirm" action="'.base_url().'processor/plc/test_daftar_upb?action=confirm_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= 'Remark : 
                    <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    
                    <textarea name="vRemark"></textarea>
            <button type="button" onclick="submit_ajax(\'form_test_daftar_upb_confirm\')">Confirm</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        } 

        function confirm_process() {
            $post = $this->input->post();
            $cNip= $this->user->gNIP;
            $vName= $this->user->gName;
            $iupb_id = $post['iupb_id'];
            $vRemark = $post['vRemark'];
            $lvl = $post['lvl'];
            $modul_id = $post['modul_id'];
            //Letakan Query Update approve disini
            $this->lib_plc->InsertActivityModule($modul_id,$iupb_id,3,3);

            $data['status']  = true;
            $data['last_id'] = $post['iupb_id'];
            $data['group_id'] = $post['group_id'];
            $data['modul_id'] = $post['modul_id'];
            return json_encode($data);
        }

    


    
        //Ini Merupakan Standart Reject yang digunakan di erp
        function reject_view() {
            $echo = '<script type="text/javascript">
                         function submit_ajax(form_id) {
                            var remark = $("#test_daftar_upb_remark").val();
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
                                    var url = "'.base_url().'processor/plc/test_daftar_upb";                             
                                    if(o.status == true) { 
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                             $("div#form_test_daftar_upb").html(data);
                                             
                                        });
                                        
                                    }
                                        reload_grid("grid_test_daftar_upb");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Reject</h1><br />';
            $echo .= '<form id="form_test_daftar_upb_reject" action="'.base_url().'processor/plc/test_daftar_upb?action=reject_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= 'Remark : 
                    <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    
                    <textarea name="vRemark" id="reject_test_daftar_upb_remark"></textarea>
            <button type="button" onclick="submit_ajax(\'form_test_daftar_upb_reject\')">Reject</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }


        
        function reject_process() {
            $post = $this->input->post();
            $cNip= $this->user->gNIP;
            $vName= $this->user->gName;
            $iupb_id = $post['iupb_id'];
            $vRemark = $post['vRemark'];
            $lvl = $post['lvl'];
            $modul_id = $post['modul_id'];

            //Letakan Query Update approve disini
            $this->lib_plc->InsertActivityModule($modul_id,$iupb_id,3,2);

            $data['status']  = true;
            $data['last_id'] = $post['iupb_id'];
            $data['group_id'] = $post['group_id'];
            $data['modul_id'] = $post['modul_id'];
            return json_encode($data);
        }
    


    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        $controller_name ='test_daftar_upb';
        $pk_field = 'iupb_id';
        $gabung = $controller_name."_".$pk_field;
        $peka=$postData[$gabung];

        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated']=$this->user->gNIP;


        if($postData['isdraft']==true){
            $postData['iSubmit']=0;

        } else{
            $postData['iSubmit']=1;
            $this->lib_plc->InsertActivityModule($this->modul_id,$peka,1,1);
        } 


        return $postData;

    }
    function before_update_processor($row, $postData) {
        $controller_name ='test_daftar_upb';
        $pk_field = 'iupb_id';
        $gabung = $controller_name."_".$pk_field;
        $peka=$postData[$gabung];


        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;

        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } else{
            $postData['iSubmit']=1;
            $this->lib_plc->InsertActivityModule($this->modul_id,$peka,1,1);
        } 


        return $postData; 
    }    

    function after_insert_processor($fields, $id, $postData) {
        //Example After Insert
        /*
        $cNip = $this->sess_auth->gNIP; 
        $sql = 'Place Query In Here';
        $this->db_plc0->query($sql);
        */
    }

    function after_update_processor($fields, $id, $postData) {
        //Example After Update
        /*
        $cNip = $this->sess_auth->gNIP; 
        $sql = 'Place Query In Here';
        $this->db_plc0->query($sql);
        */
    }

    function manipulate_insert_button($buttons, $rowData) { 
        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $js = $this->load->view('js/standard_js');
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="test_daftar_upb_frame" id="test_daftar_upb_frame" height="0" width="0"></iframe>';
        
        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'test_daftar_upb\', \' '.base_url().'processor/plc/test_daftar_upb?draft=true \',this,true )"  id="button_save_draft_test_daftar_upb"  class="ui-button-text icon-save" >Save as Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\'test_daftar_upb\', \' '.base_url().'processor/plc/test_daftar_upb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_save_submit_test_daftar_upb"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

        

        $buttons['save'] = $iframe.$save_draft.$save.$js;
        
        return $buttons;
    }

    function manipulate_update_button($buttons, $rowData) { 
        $peka=$rowData['iupb_id'];


        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $js = $this->load->view('js/standard_js');
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="test_daftar_upb_frame" id="test_daftar_upb_frame" height="0" width="0"></iframe>';
        
        
        



        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        }
        else{ 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\'test_daftar_upb\', \' '.base_url().'processor/plc/test_daftar_upb?draft=true \',this,true )"  id="button_update_draft_test_daftar_upb"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$peka);

                    foreach ($activities as $act) {
                        $update_draft = '<button onclick="javascript:update_draft_btn(\'test_daftar_upb\', \' '.base_url().'processor/plc/test_daftar_upb?draft=true \',this,true )"  id="button_update_draft_test_daftar_upb"  class="ui-button-text icon-save" >Update as Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\'test_daftar_upb\', \' '.base_url().'processor/plc/test_daftar_upb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_test_daftar_upb"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/test_daftar_upb?action=approve&iM_activity='.$act['iM_activity'].'&iupb_id='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_test_daftar_upb"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/test_daftar_upb?action=reject&iM_activity='.$act['iM_activity'].'&iupb_id='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_test_daftar_upb"  class="ui-button-text icon-save" >Reject</button>';

                        $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/test_daftar_upb?action=confirm&iM_activity='.$act['iM_activity'].'&iupb_id='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_test_daftar_upb"  class="ui-button-text icon-save" >Confirm</button>';

                        switch ($act['iType']) {
                            case '1':
                                # Update
                                $sButton .= $update_draft.$update;
                                break;
                            case '2':
                                # Approval
                                $sButton .= $approve.$reject;
                                break;
                            case '3':
                                # Confirmation
                                $sButton .= $confirm;
                                break;
                            default:
                                # Update
                                $sButton .= $update_draft.$update;
                                break;
                        }
                    }
                }

                $buttons['update'] = $sButton;        
                
            

            
        }
        
        return $buttons;
    }

    function whoAmI($nip) { 
        $sql = 'select b.vDescription as vdepartemen,a.*,b.*,c.iLvlemp 
                        from hrd.employee a 
                        join hrd.msdepartement b on b.iDeptID=a.iDepartementID
                        join hrd.position c on c.iPostId=a.iPostID
                        where a.cNip ="'.$nip.'"
                        ';
        
        $data = $this->db_plc0->query($sql)->row_array();
        return $data;
    }

    function download($vFilename) { 
        $this->load->helper('download');        
        $name = $vFilename;
        $id = $_GET['id'];
        $tempat = $_GET['path'];    
        $path = file_get_contents('./files/plc/'.$tempat.'/'.$id.'/'.$name);    
        force_download($name, $path);


    }

    //Output
    public function output(){
        $this->index($this->input->get('action'));
    }

}