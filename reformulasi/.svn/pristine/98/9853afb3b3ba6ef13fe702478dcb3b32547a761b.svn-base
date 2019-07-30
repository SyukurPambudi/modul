 
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_export_kesimpulan_skala_lab extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->db = $this->load->database('hrd',false, true);
        $this->user = $this->auth->user();

        $this->load->library('lib_refor');
        $this->modul_id = $this->input->get('modul_id');
        $this->iModul_id = $this->lib_refor->getIModulID($this->input->get('modul_id'));

        $this->title = 'Kesimpulan Trial';
        $this->url = 'v3_export_kesimpulan_skala_lab';
        $this->urlpath = 'reformulasi/'.str_replace("_","/", $this->url);

        $this->maintable = 'reformulasi.export_skala_lab_formula';    
        $this->main_table = $this->maintable;   
        $this->main_table_pk = 'iexport_skala_lab_formula';
        $this->arrKesimpulan = array(0 => 'TMS', 1 => 'MS');
        $this->arrValue = array(0 => 'No', 1 => 'Yes');

    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle($this->title);
        $grid->setTable($this->maintable);      
        $grid->setUrl($this->url);

        $grid->addList('vno_formula','ikesimpulan_trial','itrial_ulang','ineed_sample','isubmit_kesimpulan','dsubmit_kesimpulan'); 
        $grid->setSortBy('iexport_skala_lab_formula');
        $grid->setSortOrder('DESC');  

        $grid->addFields('vno_formula','ikesimpulan_trial','itrial_ulang','ineed_sample'); 

        $grid->setWidth('vno_formula', '100');
        $grid->setAlign('vno_formula', 'left');
        $grid->setLabel('vno_formula','No. Formulasi');
    
        $grid->setWidth('ikesimpulan_trial', '100');
        $grid->setAlign('ikesimpulan_trial', 'left');
        $grid->setLabel('ikesimpulan_trial','Kesimpulan Skala Lab');

        $grid->setWidth('itrial_ulang', '100');
        $grid->setAlign('itrial_ulang', 'left');
        $grid->setLabel('itrial_ulang','Trial Ulang');

        $grid->setWidth('ineed_sample', '100');
        $grid->setAlign('ineed_sample', 'left');
        $grid->setLabel('ineed_sample','Perlu Minta Sample');

        $grid->setWidth('isubmit_kesimpulan', '100');
        $grid->setAlign('isubmit_kesimpulan', 'left');
        $grid->setLabel('isubmit_kesimpulan','Status');

        $grid->setWidth('dsubmit_kesimpulan', '100');
        $grid->setAlign('dsubmit_kesimpulan', 'left');
        $grid->setLabel('dsubmit_kesimpulan','Tgl Submit');
    
        $grid->setQuery('lDeleted = 0 ', null); 
        $grid->setQuery('isubmit_fisik = 1 ', null); 
        $grid->setQuery('isubmit_kimiawi = 1 ', null); 

        $this->iexport_skala_lab = $this->input->get('iexport_skala_lab');            
        $grid->setInputGet('_iexport_skala_lab', $this->iexport_skala_lab);            
        $grid->setQuery('export_skala_lab_formula.iexport_skala_lab', intval($this->input->get('_iexport_skala_lab')));
        $grid->setForeignKey($this->input->get('iexport_skala_lab'));

        $grid->changeFieldType('isubmit_kesimpulan','combobox','',array('' => '--Pilih--', 0 => 'Need To Be Submit', 1 => 'Submitted'));
        $grid->changeFieldType('ikesimpulan_trial','combobox','',array('' => '--Pilih--', 0 => 'TMS', 1 => 'MS'));
        $grid->changeFieldType('itrial_ulang','combobox','',array('' => '--Pilih--', 0 => 'No', 1 => 'Yes'));
        $grid->changeFieldType('ineed_sample','combobox','',array('' => '--Pilih--', 0 => 'No', 1 => 'Yes'));

        $grid->setSearch('vno_formula','isubmit_kesimpulan');
        
        $grid->setRequired('vno_formula','ikesimpulan_trial','itrial_ulang','ineed_sample'); 
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
                case 'loadPengujian':
                    $this->loadPengujian();
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

    function loadPengujian(){
        $post   = $this->input->post();
        $value  = $post['value'];
        $bentuk = $post['bentuk'];
        $fid    = $post['idclass'];
        $name   = $post['name'];

        $pengujian = $this->db->get_where('reformulasi.master_pengujian_refor', array('id_bentuk_sediaan' => $bentuk, 'lDeleted' => 0, 'iStatus' => 0))->result_array(); 

        $return  = '<select name="'.$name.'" id="'.$fid.'">';
        $return .= '    <option value="">--Pilih Parameter Pengujian--</option>';
        foreach ($pengujian as $p) {
            $selected = ($p['id_pengujian']==$value)?'selected':'';
            $return .= '<option '.$selected.' value="'.$p['id_pengujian'].'">'.$p['vNama_pengujian'].'</option>';
        }
        $return .= '</select>';
        echo $return;exit();
    }

    //Jika Ingin Menambahkan Seting grid seperti button edit enable dalam kondisi tertentu
    public function manipulate_grid_button($button) {  
        unset($button['create']);
        $url        = base_url()."processor/reformulasi/v3/export/uji/fisik?action=create&foreign_key=".$this->input->get('iexport_skala_lab')."&iexport_skala_lab=".$this->input->get('iexport_skala_lab')."     &company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id');
        $btn_baru   = "<script type='text/javascript'>
                            function add_btn_".$this->url."(url, title) {
                                browse_with_no_close(url, title);
                            }        
                        </script>";

        $btn_baru   = '<span class="icon-add ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" onclick="add_btn_'.$this->url.'(\''.$url.'\', \'UJI FISIK\')">Tambah Foemulasi</span>';
        
        $cekSubmit  = $this->db->get_where('reformulasi.export_skala_lab', array('iexport_skala_lab' => $this->input->get('iexport_skala_lab')))->row_array();
        $submit     = (!empty($cekSubmit))?$cekSubmit['isubmit_kimiawi']:0;

        return $button;
        
    }

    function listBox_Action($row, $actions) { 
        unset($actions['edit']);
        $row        = get_object_vars($row);

        $sqlCek     = 'SELECT t.isubmit_kesimpulan FROM reformulasi.export_skala_lab_formula f
                        JOIN reformulasi.export_skala_lab t ON f.iexport_skala_lab = t.iexport_skala_lab
                        WHERE f.iexport_skala_lab_formula = '.$row[$this->main_table_pk];
        $cekSubmit  = $this->db->query($sqlCek)->row_array();
        $submit     = (!empty($cekSubmit))?$cekSubmit['isubmit_kesimpulan']:0;
            
        $url        = base_url()."processor/reformulasi/".str_replace('_', '/', $this->url)."?action=update&iexport_skala_lab=".$row['iexport_skala_lab']."&foreign_key=".$row['iexport_skala_lab']."&id=".$row[$this             ->main_table_pk]."&modul_id=".$this->input->get('modul_id');
        $edit       = "<script type'text/javascript'>
                            function edit_btn_".$this->url."(url, title) {
                                browse_with_no_close(url, title);
                            }
                        </script>";
        $edit       .= "<a href='#' onclick='javascript:edit_btn_".$this->url."(\"".$url."\", \"SETUP GROUPS\");'><center><span class='ui-icon ui-icon-pencil'></span></center></a>";

        $view       = "<script type'text/javascript'>
                            function view_btn_".$this->url."(url, title) {
                                browse_with_no_close(url, title);
                            }
                        </script>";
        $view       .= "<a href='#' onclick='javascript:view_btn_".$this->url."(\"".$url."\", \"SETUP GROUPS\");'><center><span class='ui-icon ui-icon-lightbulb'></span></center></a>";

        if ($submit == 1){
            unset($actions['delete']);
            unset($actions['edit']);
        } else {
            if ($row['isubmit_kesimpulan'] == 0){
                $actions['edit'] = $edit;
            }
        }

        $actions['view'] = $view;
         
        return $actions;
    } 
    
    function updateBox_v3_export_kesimpulan_skala_lab_vno_formula($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
             $return= $value; 
        }else{ 
            $return = '<input type="text" readonly name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';
            $return .= '<input type="hidden" name="isdraft" id="isdraft">';
            $return .= '<input type="hidden" value="'.$this->input->get('foreign_key').'" id="'.$this->url.'_iexport_skala_lab" name="iexport_skala_lab">';

        }
            
        return $return;
    }
    
    function updateBox_v3_export_kesimpulan_skala_lab_ikesimpulan_trial($field, $id, $value, $rowData) {
        $idtrial = $this->url.'_itrial_ulang';
        $idsample = $this->url.'_ineed_sample';

        $return  = '<select name="'.$field.'" id="'.$id.'">';
        foreach ($this->arrKesimpulan as $k => $v) {
            $selected = ($k==$value)?'selected':'';
            $return .= '<option value="'.$k.'">'.$v.'</option>';
        }
        $return .= '</select>';
        $return .= '<script>
                        var value = $("#'.$id.'").val();
                        show_hide_trial(value);

                        $("#'.$id.'").live("change",function(){
                            $("#'.$idtrial.'").val("0");
                            $("#'.$idsample.'").val("0");
                            var idval = $(this).val();
                            show_hide_trial(idval);
                        });

                        function show_hide_trial(value){
                            if (value == 1){
                                $("label[for=\''.$idtrial.'\']").parent().hide();
                                $("label[for=\''.$idsample.'\']").parent().hide();
                            } else {
                                $("label[for=\''.$idtrial.'\']").parent().show();
                            }
                        }
                    </script>';

        return $return;
    }

    function updateBox_v3_export_kesimpulan_skala_lab_itrial_ulang($field, $id, $value, $rowData) {
        $idsample = $this->url.'_ineed_sample';

        $return  = '<select name="'.$field.'" id="'.$id.'">';
        foreach ($this->arrValue as $k => $v) {
            $selected = ($k==$value)?'selected':'';
            $return .= '<option value="'.$k.'">'.$v.'</option>';
        }
        $return .= '</select>';
        $return .= '<script>
                        var value = $("#'.$id.'").val();
                        show_hide_sample(value);

                        $("#'.$id.'").live("change",function(){
                            $("#'.$idsample.'").val("0");
                            var idval = $(this).val();
                            show_hide_sample(idval);
                        });

                        function show_hide_sample(value){
                            if (value == 1){
                                $("label[for=\''.$idsample.'\']").parent().show();
                            } else {
                                $("label[for=\''.$idsample.'\']").parent().hide();
                            }
                        }
                    </script>';

        return $return;
    }
                        


    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated']=$this->user->gNIP;


        if($postData['isdraft']==true){
            $postData['isubmit_kimiawi'] = 0;
        } else{
            $postData['isubmit_kimiawi'] = 1;
            $postData['dsubmit_kimiawi'] = date('Y-m-d H:i:s');
            $postData['csubmit_kimiawi'] = $this->user->gNIP;
        } 
        return $postData;

    }
    function before_update_processor($row, $postData) {
        unset($postData['iexport_skala_lab']);
        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;

        if($postData['isdraft']==true){
            $postData['isubmit_kesimpulan'] = 0;
        } else{
            $postData['isubmit_kesimpulan'] = 1;
            $postData['dsubmit_kesimpulan'] = date('Y-m-d H:i:s');
            $postData['csubmit_kesimpulan'] = $this->user->gNIP;
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
                        onclick="javascript:save_btn_'.$this->url.'(\''.$this->url.'\', \' '.base_url().'processor/reformulasi/'.str_replace('_', '/', $this->url).'?draft=true&iexport_skala_lab='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true )">Save as Draft</button>';

        $save = '<button type="button"
                        name="button_create_'.$this->url.'"
                        id="button_create_'.$this->url.'"
                        class="icon-save ui-button" 
                        onclick="javascript:save_btn_'.$this->url.'(\''.$this->url.'\', \' '.base_url().'processor/reformulasi/'.str_replace('_', '/', $this->url).'?draft=false&iexport_skala_lab='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, false )">Save & Send</button>';

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
                                onclick='javascript:cancel_btn_".$this->url."(\"".$this->url."\", \"".base_url()."processor/reformulasi/".str_replace('_', '/', $this->url)."?iexport_skala_lab=".$this->input->get('foreign_key')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>
                                Close 
                            </button>";
        
        return $buttons;
    }

    function manipulate_update_button($buttons, $rowData) { 
        unset($buttons['update']);
        unset($buttons['update_back']);
        unset($buttons['cancel']);

        $sqlCek     = 'SELECT t.isubmit_kesimpulan FROM reformulasi.export_skala_lab_formula f
                        JOIN reformulasi.export_skala_lab t ON f.iexport_skala_lab = t.iexport_skala_lab
                        WHERE f.iexport_skala_lab_formula = '.$rowData[$this->main_table_pk];
        $cekSubmit  = $this->db->query($sqlCek)->row_array();
        $submit     = (!empty($cekSubmit))?$cekSubmit['isubmit_kesimpulan']:0;

        $data['url'] = $this->url;
        $js = $this->load->view('js/custom_js', $data, TRUE);

        $update_draft = '<button type="button"
                                name="button_update_draft_'.$this->url.'"
                                id="button_update_draft_'.$this->url.'"
                                class="ui-button-text icon-save"
                                onclick="javascript:update_btn_'.$this->url.'(\''.$this->url.'\', \' '.base_url().'processor/reformulasi/'.str_replace('_', '/', $this->url).'?draft=true&iexport_skala_lab='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)">Update As Draft</button>';

        $update = '<button type="button"
                        name="button_update_draft_'.$this->url.'"
                        id="button_update_draft_'.$this->url.'"
                        class="ui-button-text icon-save"
                        onclick="javascript:update_btn_'.$this->url.'(\''.$this->url.'\', \' '.base_url().'processor/reformulasi/'.str_replace('_', '/', $this->url).'?draft=false&iexport_skala_lab='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, false)">Update & Send</button>';

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
                                    onclick='javascript:cancel_btn_".$this->url."(\"".$this->url."\", \"".base_url()."processor/reformulasi/".str_replace('_', '/', $this->url)."?iexport_skala_lab=".$this->input->get('foreign_key')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>
                                    Close 
                                </button>";

            
        if ($this->input->get('action') == 'view' || $rowData['isubmit_kesimpulan'] == 1 || $submit == 1){
            unset($buttons['update_back']);
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
