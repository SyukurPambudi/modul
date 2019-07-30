 
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_export_uji_fisik_kesimpulan extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->db = $this->load->database('hrd',false, true);
        $this->user = $this->auth->user();

        $this->load->library('lib_refor');
        $this->modul_id = $this->input->get('modul_id');
        $this->iModul_id = $this->lib_refor->getIModulID($this->input->get('modul_id'));

        $this->title = 'Uji Fisik';
        $this->url = 'v3_export_uji_fisik_kesimpulan';
        $this->urlpath = 'reformulasi/'.str_replace("_","/", $this->url);

        $this->maintable = 'reformulasi.export_skala_trial_formula';    
        $this->main_table = $this->maintable;   
        $this->main_table_pk = 'iexport_skala_trial_formula';

    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle($this->title);
        $grid->setTable($this->maintable);      
        $grid->setUrl($this->url);

        $grid->addList('vno_formula','dmulai_skala_trial','dselesai_skala_trial','cpic_skala_trial','isubmit_fisik','dsubmit_fisik'); 
        $grid->setSortBy('iexport_skala_trial_formula');
        $grid->setSortOrder('DESC');  

        $grid->addFields('vno_formula','dmulai_skala_trial','dselesai_skala_trial','cpic_skala_trial','formulasi_uji_fisik'); 

        $grid->setWidth('vno_formula', '100');
        $grid->setAlign('vno_formula', 'left');
        $grid->setLabel('vno_formula','No. Formulasi');
    
        $grid->setWidth('dmulai_skala_trial', '100');
        $grid->setAlign('dmulai_skala_trial', 'left');
        $grid->setLabel('dmulai_skala_trial','Tgl Mulai Orientasi Skala Trial ');

        $grid->setWidth('dselesai_skala_trial', '100');
        $grid->setAlign('dselesai_skala_trial', 'left');
        $grid->setLabel('dselesai_skala_trial','Tgl Selesai Orientasi Skala Trial ');

        $grid->setWidth('cpic_skala_trial', '100');
        $grid->setAlign('cpic_skala_trial', 'left');
        $grid->setLabel('cpic_skala_trial','PIC Skala Trial ');

        $grid->setWidth('formulasi_uji_fisik', '100');
        $grid->setAlign('formulasi_uji_fisik', 'left');
        $grid->setLabel('formulasi_uji_fisik','File Uji Fisik');

        $grid->setWidth('isubmit_fisik', '100');
        $grid->setAlign('isubmit_fisik', 'left');
        $grid->setLabel('isubmit_fisik','Status');

        $grid->setWidth('dsubmit_fisik', '100');
        $grid->setAlign('dsubmit_fisik', 'left');
        $grid->setLabel('dsubmit_fisik','Tgl Submit');
    
        $grid->setQuery('lDeleted = 0 ', null); 

        $this->iexport_skala_trial = $this->input->get('iexport_skala_trial');            
        $grid->setInputGet('_iexport_skala_trial', $this->iexport_skala_trial);            
        $grid->setQuery('export_skala_trial_formula.iexport_skala_trial', intval($this->input->get('_iexport_skala_trial')));
        $grid->setForeignKey($this->input->get('iexport_skala_trial'));

        $grid->changeFieldType('isubmit_fisik','combobox','',array('' => 'Pilih', 0 => 'Need To Be Submit', 1 => 'Submitted'));

        $grid->setSearch('vno_formula','isubmit_fisik');
        
        $grid->setRequired('vno_formula','dmulai_skala_trial','dselesai_skala_trial','cpic_skala_trial'); 
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
                $post       = $this->input->post();
                $isUpload   = $this->input->get('isUpload');
                $modul_field= $post['modul_fields'];
                $masterDok  = $this->db->get_where('erp_privi.m_modul_fields', array('lDeleted' => 0, 'iM_modul_fields' => $modul_field))->row_array();
                $path       = ( !empty($masterDok) ) ? $masterDok['vPath_upload'] : 'files/reformulasi/export/skala_trial/uji_fisik';
                $path       = realpath($path);

                if($isUpload) {
                    $lastId = $this->input->get('lastId');
                    if(!file_exists($path."/".$lastId)){
                        if (!mkdir($path."/".$lastId, 0777, true)) { //id review
                            $r['message'] = 'Failed Upload , Failed create Folder!';
                            $r['status'] = FALSE;
                            $r['last_id'] = $lastId;
                            echo json_encode($r);
                            die('Failed upload, try again!');
                        }
                    }

                    $fileketerangan = array();
                    foreach($_POST as $key=>$value) {
                        if ($key == 'fileketerangan') {
                            foreach($value as $k=>$v) {
                                $fileketerangan[$k] = $v;
                            }
                        }
                    }
                    $i=0;
                    foreach ($_FILES['fileupload']["error"] as $key => $error) {
                        if ($error == UPLOAD_ERR_OK) {
                            $tmp_name = $_FILES['fileupload']["tmp_name"][$key];
                            $name =$_FILES['fileupload']["name"][$key];
                            $data['filename'] = $name;
                            $name_generate = $this->lib_refor->generateFilename($name);
                            $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name_generate)) {

                                    $insert['iM_modul_fileds']  = $modul_field;
                                    $insert['idHeader_File']    = $lastId;
                                    $insert['vFilename']        = $data['filename'];
                                    $insert['vFilename_generate']= $name_generate;
                                    $insert['tKeterangan']      = $fileketerangan[$i];
                                    $insert['dCreate']          = $data['dInsertDate'];
                                    $insert['cCreate']          = $this->user->gNIP;    
                                    $insert['iDeleted']         = 0;
                                    $this->db->insert('reformulasi.group_file_upload', $insert);

                                    $i++;
                                }
                                else{
                                    echo "Upload ke folder gagal";
                                }
                        }
                    }

                    $r['message'] = 'Data Berhasil di Simpan!';
                    $r['status'] = TRUE;
                    $r['last_id'] = $this->input->get('lastId');
                    echo json_encode($r);
                }  else {
                    echo $grid->saved_form();
                }
                break;
            
            case 'update':
                    $grid->render_form($this->input->get('id'));
                    break;

        
            case 'updateproses':
                $isUpload   = $this->input->get('isUpload'); 
                $post       = $this->input->post();
                $lastId     = $post[$this->url.'_'.$this->main_table_pk];
                $modul_field= $post['modul_fields'];
                $masterDok  = $this->db->get_where('erp_privi.m_modul_fields', array('lDeleted' => 0, 'iM_modul_fields' => $modul_field))->row_array(); 
                $path       = ( !empty($masterDok) ) ? $masterDok['vPath_upload'] : 'files/reformulasi/export/skala_trial/uji_fisik';
                $path       = realpath($path.'/');
                $filesUpload= $this->db->get_where('reformulasi.group_file_upload', array('iDeleted' => 0, 'iM_modul_fileds' => $modul_field, 'idHeader_File' => $lastId))->result_array();

                if(!file_exists($path."/".$lastId)){
                    if (!mkdir($path."/".$lastId, 0777, true)) { //id review
                        die('Failed upload, try again!');
                    }
                }

                $fileketerangan     = array();
                $ifileid            = array();
                $ijenis_bk_id       = array();
                $fileid             = '';
                $j                  = 0;
                $tgl                = date('Y-m-d H:i:s');

                foreach($_POST as $key=>$value) {

                    if ($key == 'fileid') {
                        $i=0;
                        foreach($value as $k=>$v) {
                            $ifileid[$k] = $v;
                            if ($i == 0) {
                                $fileid .= "'".$v."'";
                            } else {
                                $fileid .= ",'".$v."'";
                            }

                            if($v != ''){
                                $j++;
                            }

                            $i++;
                        }
                    }
                    if ($key == 'fileketerangan') {
                        foreach($value as $y=>$u) {
                            $fileketerangan[$y] = $u;
                        }
                    }
                    if ($key == 'namafile') {
                        foreach($value as $k => $v) {
                            $namafile[$k] = $v;
                        }
                    }
                }

                if($fileid!=''){
                    $sql1 = "UPDATE reformulasi.group_file_upload SET iDeleted = 1, dUpdate = ?, cUpdate = ? WHERE idHeader_File = ? AND iM_modul_fileds = ? AND iFile NOT IN (".$fileid.")";
                    $this->db->query($sql1, array($tgl, $this->user->gNIP, $lastId, $modul_field));
                }

                foreach ($ifileid as $if => $va) {
                    if($va != ''){
                        try {
                            $sql2 = "UPDATE reformulasi.group_file_upload SET dUpdate = ?, cUpdate = ? WHERE iFile = ? AND iM_modul_fileds = ? ";
                            $this->db->query($sql2, array($tgl, $this->user->gNIP, $va, $modul_field));
                        }catch(Exception $e) {
                            die($e);
                        }
                    }
                }


                if($isUpload) {
                    if (isset($_FILES['fileupload']))  {
                        $i=0;
                        foreach ($_FILES['fileupload']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['fileupload']["tmp_name"][$key];
                                $name =$_FILES['fileupload']["name"][$key];
                                $data['filename'] = $name;
                                $name_generate = $this->lib_refor->generateFilename($name);
                                $data['dInsertDate'] = date('Y-m-d H:i:s');
                                if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name_generate)) {
                                    $insert['iM_modul_fileds']  = $modul_field;
                                    $insert['idHeader_File']    = $lastId;
                                    $insert['vFilename']        = $data['filename'];
                                    $insert['vFilename_generate']= $name_generate;
                                    $insert['tKeterangan']      = $fileketerangan[$i];
                                    $insert['dCreate']          = $data['dInsertDate'];
                                    $insert['cCreate']          = $this->user->gNIP;    
                                    $insert['iDeleted']         = 0;
                                    $this->db->insert('reformulasi.group_file_upload', $insert);

                                    $i++;
                                    $j++;
                                }
                                else{
                                    echo "Upload ke folder gagal";
                                }
                            }

                        }

                    }

                    $r['message'] = 'Data Berhasil di Simpan!';
                    $r['status'] = TRUE;
                    $r['last_id'] = $this->input->get('lastId');
                    echo json_encode($r);
                    exit();
                }  else {
                    echo $grid->updated_form();
                }

                break;      

            case 'download':
                $this->load->helper('download');        
                $name = $this->input->get('file');
                $id = $_GET['id'];
                $tempat = $_GET['path'];    
                $path = file_get_contents('./'.$tempat.'/'.$id.'/'.$name);    
                force_download($name, $path);
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
                case 'searchPIC':
                    $this->searchPIC();
                    break;
            default:
                    $grid->render_grid();
                    break;
        }
    }

    function searchPIC (){
        $term = $this->input->get('term'); 
        $data = array(); 

        $sql = "SELECT e.cNip, e.vName FROM hrd.employee e 
                WHERE e.lDeleted = 0 AND ( e.dresign = '0000-00-00' OR e.dresign > DATE(NOW()) ) 
                    AND ( e.cNip LIKE '%{$term}%' OR e.vName LIKE '%{$term}%' ) 
                ORDER BY e.vName ASC ";
    
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {         
            foreach($query->result_array() as $line) {
                $row_array['id']        = trim($line['cNip']);
                $row_array['value']     = trim($line['cNip']).' - '.trim($line['vName']); 
                array_push($data, $row_array);
            }
        }
        
        echo json_encode($data);
        exit;  
    }

    //Jika Ingin Menambahkan Seting grid seperti button edit enable dalam kondisi tertentu
    public function manipulate_grid_button($button) {  
        unset($button['create']);
        return $button;
        
    }

    function listBox_Action($row, $actions) { 
        unset($actions['edit']);
        $row        = get_object_vars($row);
            
        $url        = base_url()."processor/reformulasi/".str_replace('_', '/', $this->url)."?action=update&iexport_skala_trial=".$row['iexport_skala_trial']."&foreign_key=".$row['iexport_skala_trial']."&id=".$row[$this             ->main_table_pk]."&modul_id=".$this->input->get('modul_id');

        $view       = "<script type'text/javascript'>
                            function view_btn_".$this->url."(url, title) {
                                browse_with_no_close(url, title);
                            }
                        </script>";
        $view       .= "<a href='#' onclick='javascript:view_btn_".$this->url."(\"".$url."\", \"SETUP GROUPS\");'><center><span class='ui-icon ui-icon-lightbulb'></span></center></a>";

        unset($actions['delete']);
        unset($actions['edit']);
        $actions['view'] = $view;
         
        return $actions;
    } 
    
    function updateBox_v3_export_uji_fisik_kesimpulan_vno_formula($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
             $return= $value; 
        }else{ 
            $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';
            $return .= '<input type="hidden" name="isdraft" id="isdraft">';
            $return .= '<input type="hidden" value="'.$this->input->get('foreign_key').'" id="'.$this->url.'_iexport_skala_trial" name="iexport_skala_trial">';

        }
            
        return $return;
    }
    
    function updateBox_v3_export_uji_fisik_kesimpulan_dmulai_skala_trial($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
             $return= $value; 
        }else{ 
            $return = '<input type="date" name="'.$field.'"  id="'.$id.'"  class="input_rows1 tanggal  required" size="15" value="'.$value.'"/>';

        }  
        return $return;
    }
    
    function updateBox_v3_export_uji_fisik_kesimpulan_dselesai_skala_trial($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
             $return= $value; 
        }else{ 
            $return = '<input type="date" name="'.$field.'"  id="'.$id.'"  class="input_rows1 tanggal  required" size="15" value="'.$value.'"/>';

        }
        return $return;
    }
    
    function updateBox_v3_export_uji_fisik_kesimpulan_formulasi_uji_fisik($field, $id, $value, $rowData) {
        $form_field = $this->db->get_where('erp_privi.m_modul_fields', array( 'lDeleted' => 0, 'vNama_field' => $field ))->row_array();
        $rows       = $this->db->get_where('reformulasi.group_file_upload', array('iM_modul_fileds' => $form_field['iM_modul_fields'], 'iDeleted' => 0, 'idHeader_File' => $rowData[$this->main_table_pk]))->result_array();

        $data['rows'] = $rows;
        $data['form_field'] = $form_field;
        $return  = $this->load->view('partial/modul/export_skala_trial_fisik_file', $data, true);
        $return .= '<script>
                        $("label[for=\''.$id.'\']").next().removeClass("rows_input");
                        $("label[for=\''.$id.'\']").remove();
                    </script>';
        return $return;
    }
    
    function updateBox_v3_export_uji_fisik_kesimpulan_cpic_skala_trial($field, $id, $value, $rowData) {
        $emp = $this->db->get_where('hrd.employee', array('cNip' => $value))->row_array();
        $pic = (!empty($emp))?$emp['cNip'].' - '.$emp['vName']:$value;
        if ($this->input->get('action') == 'view') {
             $return= $pic; 
        }else{ 
            $url6 = base_url().'processor/reformulasi/'.str_replace('_', '/', $this->url).'?action=searchPIC'; 
            $return = "<script type='text/javascript'>
                            $(document).ready(function() { 
                                $('#".$id."_dis').live('keyup', function(e) {
                                    var config = {
                                        source: '".$url6."',                    
                                        select: function(event, ui){
                                            $('#".$id."').val(ui.item.id);
                                            $('#".$id."_dis').val(ui.item.value);  
                                            return false;                           
                                        },
                                        minLength: 2,
                                        autoFocus: true,
                                        }; 
                                    $('#".$id."_dis').autocomplete(config);  
                                    $(this).keypress(function(e){
                                        if(e.which != 13) {
                                            $('#".$id."').val('');
                                        }           
                                    });
                                    $(this).blur(function(){
                                        if($('#".$id."').val() == '') {
                                            $(this).val('');
                                        }           
                                    });

                                }); 
                                    
                            }); 
                      </script>";
            $return   .= '<input type="hidden" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30" maxlength = "50"  value="'.$value.'"/>';
            $return   .= '<input type="text" name="'.$field.'_dis"  id="'.$id.'_dis"  class="input_rows1 " size="50" maxlength = "50"  value="'.$pic.'"/>'; 

        }
        return $return;
    }
                        


    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated']=$this->user->gNIP;


        if($postData['isdraft']==true){
            $postData['isubmit_fisik'] = 0;
        } else{
            $postData['isubmit_fisik'] = 1;
            $postData['dsubmit_fisik'] = date('Y-m-d H:i:s');
            $postData['csubmit_fisik'] = $this->user->gNIP;
        } 
        
        return $postData;

    }
    function before_update_processor($row, $postData) {
        unset($postData['iexport_skala_trial']);
        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;

        if($postData['isdraft']==true){
            $postData['isubmit_fisik'] = 0;
        } else{
            $postData['isubmit_fisik'] = 1;
            $postData['dsubmit_fisik'] = date('Y-m-d H:i:s');
            $postData['csubmit_fisik'] = $this->user->gNIP;
        } 
        
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

    function manipulate_insert_button($buttons) { 
        unset($buttons['save']);
        unset($buttons['save_back']);
        unset($buttons['cancel']);

        $data['url'] = $this->url;
        $js = $this->load->view('js/custom_js', $data, TRUE);

        $save_draft = '<button type="button"
                        name="button_create_'.$this->url.'"
                        id="button_create_'.$this->url.'"
                        class="icon-save ui-button" 
                        onclick="javascript:save_btn_'.$this->url.'(\''.$this->url.'\', \' '.base_url().'processor/reformulasi/'.str_replace('_', '/', $this->url).'?draft=true&iexport_skala_trial='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true )">Save as Draft</button>';

        $save = '<button type="button"
                        name="button_create_'.$this->url.'"
                        id="button_create_'.$this->url.'"
                        class="icon-save ui-button" 
                        onclick="javascript:save_btn_'.$this->url.'(\''.$this->url.'\', \' '.base_url().'processor/reformulasi/'.str_replace('_', '/', $this->url).'?draft=false&iexport_skala_trial='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, false )">Save & Send</button>';

        $buttons['save_back'] = $save_draft.$save.$js;

         $buttons['cancel']  =  "<script type='text/javascript'>
                                    function cancel_btn_".$this->url."(grid, url, dis) {     
                                        $('#alert_dialog_form').dialog('close');
                                    }
                                </script>";

        $buttons['cancel'] .= "<button type='button'
                                name='button_cancel_".$this->url."'
                                id='button_cancel_".$this->url."'
                                class='icon-cancel ui-button'
                                onclick='javascript:cancel_btn_".$this->url."(\"".$this->url."\", \"".base_url()."processor/reformulasi/".str_replace('_', '/', $this->url)."?iexport_skala_trial=".$this->input->get('foreign_key')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>
                                Close 
                            </button>";
        
        return $buttons;
    }

    function manipulate_update_button($buttons, $rowData) { 
        unset($buttons['update']);
        unset($buttons['update_back']);
        unset($buttons['cancel']);

        $data['url'] = $this->url;
        $js = $this->load->view('js/custom_js', $data, TRUE);

        $update_draft = '<button type="button"
                                name="button_update_draft_'.$this->url.'"
                                id="button_update_draft_'.$this->url.'"
                                class="ui-button-text icon-save"
                                onclick="javascript:update_btn_'.$this->url.'(\''.$this->url.'\', \' '.base_url().'processor/reformulasi/'.str_replace('_', '/', $this->url).'?draft=true&iexport_skala_trial='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)">Update As Draft</button>';

        $update = '<button type="button"
                        name="button_update_draft_'.$this->url.'"
                        id="button_update_draft_'.$this->url.'"
                        class="ui-button-text icon-save"
                        onclick="javascript:update_btn_'.$this->url.'(\''.$this->url.'\', \' '.base_url().'processor/reformulasi/'.str_replace('_', '/', $this->url).'?draft=false&iexport_skala_trial='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, false)">Update & Send</button>';

        $buttons['update_back'] = $update_draft.$update.$js;
            
        $buttons['cancel']  =  "<script type='text/javascript'>
                                    function cancel_btn_".$this->url."(grid, url, dis) {      
                                        $('#alert_dialog_form').dialog('close');
                                    }
                                </script>";
        $buttons['cancel'] .= "<button type='button'
                                    name='button_cancel_".$this->url."'
                                    id='button_cancel_".$this->url."'
                                    class='icon-cancel ui-button'
                                    onclick='javascript:cancel_btn_".$this->url."(\"".$this->url."\", \"".base_url()."processor/reformulasi/".str_replace('_', '/', $this->url)."?iexport_skala_trial=".$this->input->get('foreign_key')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>
                                    Close 
                                </button>";

        unset($buttons['update_back']);
        
        return $buttons;
    }

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
