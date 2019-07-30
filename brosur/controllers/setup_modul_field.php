 
<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class setup_modul_field extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->db = $this->load->database('brosur0',false, true);
        $this->user = $this->auth->user();
        $this->url = 'setup_modul_field';
        $this->arrVal = array(0 => 'Tidak', 1 => 'Ya');
        $this->arrStat = array(0 => 'Active', 1 => 'Deleted');
    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle('SETUP MODUL FIELD');
        $grid->setTable('erp_privi.m_modul_fields');      
        $grid->setUrl('setup_modul_field');

        //List Table
        $grid->addList('iM_jenis_field','vNama_field','iRequired','vDesciption','iSort','lDeleted'); 
        $grid->setSortBy('iSort');
        $grid->setSortOrder('ASC');  

        //List field
        $grid->addFields('iSort','iM_jenis_field','vNama_field','vDesciption','vRequirement_field','iFilter_log','iShow_SQL','iLoad','vLoad_path','iRead_only_form','vSource_input','vSource_input_edit','iValidation','validation_field','validation_after','iRead_flow','iRead_team','vRead_team','iRequired','vDept_author','vNip_author','vDept_participant','vNip_participant','vFile_detail','vPath_upload','lDeleted'); 

        //Setting Grid Width Name 
        /*
        Kamu bisa merubah nama label dari sini, Contoh :
        $grid->setLabel('nama field','nama field yang akan diubah');

        */

        $grid->setWidth('iSort', '50');
        $grid->setAlign('iSort', 'center');
        $grid->setLabel('iSort','No. Urut ');
    
        $grid->setWidth('iM_jenis_field', '250');
        $grid->setAlign('iM_jenis_field', 'left');
        $grid->setLabel('iM_jenis_field','Jenis Field ');
    
        $grid->setWidth('iFilter_log', '100');
        $grid->setAlign('iFilter_log', 'left');
        $grid->setLabel('iFilter_log','Filter Log ');
    
        $grid->setWidth('iShow_SQL', '100');
        $grid->setAlign('iShow_SQL', 'left');
        $grid->setLabel('iShow_SQL','Show SQL ');
    
        $grid->setWidth('iLoad', '100');
        $grid->setAlign('iLoad', 'left');
        $grid->setLabel('iLoad','Load File');
    
        $grid->setWidth('vLoad_path', '100');
        $grid->setAlign('vLoad_path', 'left');
        $grid->setLabel('vLoad_path','File To Load ');
    
        $grid->setWidth('iRead_only_form', '100');
        $grid->setAlign('iRead_only_form', 'left');
        $grid->setLabel('iRead_only_form','Read Only Form ');
    
        $grid->setWidth('vNama_field', '100');
        $grid->setAlign('vNama_field', 'left');
        $grid->setLabel('vNama_field','Nama Field ');
    
        $grid->setWidth('vSource_input', '100');
        $grid->setAlign('vSource_input', 'left');
        $grid->setLabel('vSource_input','Source Input ');
    
        $grid->setWidth('vSource_input_edit', '100');
        $grid->setAlign('vSource_input_edit', 'left');
        $grid->setLabel('vSource_input_edit','Source Input Edit ');
    
        $grid->setWidth('vRequirement_field', '100');
        $grid->setAlign('vRequirement_field', 'left');
        $grid->setLabel('vRequirement_field','Requirement Field ');
    
        $grid->setWidth('iValidation', '100');
        $grid->setAlign('iValidation', 'left');
        $grid->setLabel('iValidation','Validatioin ');
    
        $grid->setWidth('iRead_flow', '100');
        $grid->setAlign('iRead_flow', 'left');
        $grid->setLabel('iRead_flow','Read Flow ');
    
        $grid->setWidth('iRead_team', '100');
        $grid->setAlign('iRead_team', 'left');
        $grid->setLabel('iRead_team','Read Team');
    
        $grid->setWidth('vRead_team', '100');
        $grid->setAlign('vRead_team', 'left');
        $grid->setLabel('vRead_team','Text Read Team ');
    
        $grid->setWidth('iRequired', '100');
        $grid->setAlign('iRequired', 'left');
        $grid->setLabel('iRequired','Required ');
    
        $grid->setWidth('vDesciption', '200');
        $grid->setAlign('vDesciption', 'left');
        $grid->setLabel('vDesciption','Label');
    
        $grid->setWidth('vTabel_file', '100');
        $grid->setAlign('vTabel_file', 'left');
        $grid->setLabel('vTabel_file','Table File ');
    
        $grid->setWidth('vTabel_file_pk_id', '100');
        $grid->setAlign('vTabel_file_pk_id', 'left');
        $grid->setLabel('vTabel_file_pk_id','Table File Primary Key ');
    
        $grid->setWidth('vDept_author', '100');
        $grid->setAlign('vDept_author', 'left');
        $grid->setLabel('vDept_author','Departement Author ');
    
        $grid->setWidth('vNip_author', '100');
        $grid->setAlign('vNip_author', 'left');
        $grid->setLabel('vNip_author','NIP Author ');
    
        $grid->setWidth('vDept_participant', '100');
        $grid->setAlign('vDept_participant', 'left');
        $grid->setLabel('vDept_participant','Departement Participant ');
    
        $grid->setWidth('vNip_participant', '100');
        $grid->setAlign('vNip_participant', 'left');
        $grid->setLabel('vNip_participant','NIP Participant');
    
        $grid->setWidth('vFile_detail', '100');
        $grid->setAlign('vFile_detail', 'left');
        $grid->setLabel('vFile_detail','File Detail');

        $grid->setWidth('vPath_upload', '100');
        $grid->setAlign('vPath_upload', 'left');
        $grid->setLabel('vPath_upload','Path File Upload');

        $grid->setWidth('lDeleted', '100');
        $grid->setAlign('lDeleted', 'center');
        $grid->setLabel('lDeleted','Status Field');
    
        $this->iM_modul = $this->input->get('iM_modul');            
        $grid->setInputGet('_iM_modul', $this->iM_modul);            
        $grid->setQuery('m_modul_fields.iM_modul', intval($this->input->get('_iM_modul')));
        $grid->setForeignKey($this->input->get('iM_modul')); 

        $grid->setSearch('iM_jenis_field','vNama_field','iRequired','vDesciption','lDeleted');

        $grid->changeFieldType('iRequired','combobox', '' ,array('' => '--Semua--',0 => 'Tidak', 1 => 'Ya'));
        $grid->changeFieldType('lDeleted','combobox', '' , array('' => '--Semua--', 0 => 'Active', 1 => 'Deleted'));
        
        $grid->setRequired('iSort','iM_jenis_field','iFilter_log','iShow_SQL','iLoad','iRead_only_form','vNama_field','iValidation','iRead_flow','iRead_team','vRead_team','iRequired','vDesciption','vDept_author','vNip_author'); 
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
                case 'load_field':
                    $this->load_field();
                    break;
            default:
                    $grid->render_grid();
                    break;
        }
    }


    function load_field(){
        $post = $this->input->post();
        $table = $post['table'];
        $splitted = explode('.', $table);
        $rowData = $post['row']; 

        /* $sql = 'SELECT k.COLUMN_NAME FROM information_schema.TABLE_CONSTRAINTS t
                JOIN information_schema.KEY_COLUMN_USAGE k
                    USING (CONSTRAINT_NAME, TABLE_SCHEMA, TABLE_NAME)
                WHERE t.CONSTRAINT_TYPE = "PRIMARY KEY"
                    AND t.TABLE_SCHEMA = ?
                    AND t.TABLE_NAME = ? ';
        $arrField = $this->db->query($sql, array($splitted[0], $splitted[1]))->row_array();
        $pk = (!empty($arrField)) ? $arrField['COLUMN_NAME']:''; */
        $sql="SHOW KEYS FROM ".$table." WHERE Key_name = 'PRIMARY'";
        $data=$this->db->query($sql)->row_array();
        $pk=$data['Column_name'];
        echo $pk;exit();
    }

    public function manipulate_grid_button($button) {  
        unset($button['create']);
        $url = base_url()."processor/brosur/setup/modul/field?action=create&foreign_key=".$this->input->get('iM_modul')."&iM_modul=".$this->input->get('iM_modul')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id');
        $btn_baru  = "<script type='text/javascript'>
                        function add_btn_$this->url(url, title) {
                            browse_with_no_close(url, title);
                        }        
                    </script>";

        $btn_baru .= '<span class="icon-add ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" onclick="add_btn_'.$this->url.'(\''.$url.'\', \'SETUP MODULES\')">Add New</span>';
        
        array_unshift($button, $btn_baru);
   
        return $button;
        
    }

    function listBox_Action($row, $actions) {
        // unset($actions['view']);
        unset($actions['edit']);
        unset($actions['delete']);
            
        $url = base_url()."processor/brosur/setup/modul/field?action=update&iM_modul=".$row->iM_modul."&foreign_key=".$row->iM_modul."&id=".$row->iM_modul_fields;
        $edit  = "<script type'text/javascript'>
                                function edit_btn_".$this->url."(url, title) {
                                    browse_with_no_close(url, title);
                                }
                            </script>";
        $edit .= "<a href='#' onclick='javascript:edit_btn_".$this->url."(\"".$url."\", \"SETUP GROUPS\");'><center><span class='ui-icon ui-icon-pencil'></span></center></a>";

        $url2 = base_url()."processor/brosur/setup/modul/field?action=view&iM_modul=".$row->iM_modul."&foreign_key=".$row->iM_modul."&id=".$row->iM_modul_fields;
        $view  = "<script type'text/javascript'>
                                function view_btn_".$this->url."(url, title) {
                                    browse_with_no_close(url, title);
                                }
                            </script>";
        $view .= "<a href='#' onclick='javascript:view_btn_".$this->url."(\"".$url2."\", \"SETUP GROUPS\");'><center><span class='ui-icon ui-icon-lightbulb'></span></center></a>";

        $actions['edit'] = $edit;
        $actions['view'] = $view;
         
        return $actions;
    } 

    function listBox_setup_modul_field_iM_jenis_field($value){
        $activity = $this->db->get_where('erp_privi.m_jenis_field', array('lDeleted' => 0, 'iM_jenis_field' => $value))->row_array();
        $return = (!empty($activity))?$activity['vKode_field'].' - '.$activity['vNama_field']:$value;
        return $return;
    }

    function insertBox_setup_modul_field_iSort($field, $id) {
        $return = '<input type="number" name="'.$field.'"  id="'.$id.'"  class="input_rows1 angka" size="10" />';
        $return .= '<input type="hidden" name="iM_modul"  id="iM_modul" value ="'.$_GET['iM_modul'].'" class="input_rows1 angka" size="10" />';
        return $return;
    }
    
    function updateBox_setup_modul_field_iSort($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input type="number" name="'.$field.'"  id="'.$id.'"  class="input_rows1 angka" size="10" value="'.$value.'"/>';
                $return .= '<input type="hidden" name="iM_modul"  id="iM_modul" value ="'.$_GET['iM_modul'].'" class="input_rows1 angka" size="10" />';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_field_iM_jenis_field($field, $id) {
        $jenis = $this->db->get_where('erp_privi.m_jenis_field', array('lDeleted' => 0))->result_array();

        $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
        foreach($jenis as $f) {
            $return .= '<option value='.$f['iM_jenis_field'].'>'.$f['vKode_field'].' - '.$f['vNama_field'].'</option>';
        }            
        $return .= '</select>';
        $return .= '<input type="hidden" value="'.$this->input->get('foreign_key').'" id="setup_modul_field_iM_modul" name="iM_modul">';
        return $return;
    }
    
    function updateBox_setup_modul_field_iM_jenis_field($field, $id, $value, $rowData) {
        $jenis = $this->db->get_where('erp_privi.m_jenis_field', array('lDeleted' => 0))->result_array();

        $return = '<select  class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
        foreach($jenis as $f) {
            $selected = ($f['iM_jenis_field']==$value)?'selected':'';
            $return .= '<option '.$selected.' value='.$f['iM_jenis_field'].'>'.$f['vKode_field'].' - '.$f['vNama_field'].'</option>';
        }            
        $return .= '</select>';
                
        return $return;
    }
    
    function insertBox_setup_modul_field_iFilter_log($field, $id) {
        $pilihan = $this->arrVal;
        $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
        foreach($pilihan as $k=>$v) {
            $return .= '<option value="'.$k.'">'.$v.'</option>';
        }            
        $return .= '</select>';

    
        return $return;
    }
    
    function updateBox_setup_modul_field_iFilter_log($field, $id, $value, $rowData) {
        $pilihan = $this->arrVal;
        if ($this->input->get('action') == 'view') {
            $return = $pilihan[$value];
        } else {
            $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
            foreach($pilihan as $k=>$v) {
                if ($k == $value) $selected = ' selected';
                else $selected = '';
                $return .= '<option '.$selected.' value="'.$k.'">'.$v.'</option>';
            }            
            $return .= '</select>';
        }
            
            
        return $return;
    }
    
    function insertBox_setup_modul_field_iShow_SQL($field, $id) {
        $pilihan = $this->arrVal;
        $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
        foreach($pilihan as $k=>$v) {
            $return .= '<option value="'.$k.'">'.$v.'</option>';
        }            
        $return .= '</select>';

    
        return $return;
    }
    
    function updateBox_setup_modul_field_iShow_SQL($field, $id, $value, $rowData) {
        $pilihan = $this->arrVal;
        if ($this->input->get('action') == 'view') {
            $return = $pilihan[$value];
        } else {
            $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
            foreach($pilihan as $k=>$v) {
                if ($k == $value) $selected = ' selected';
                else $selected = '';
                $return .= '<option '.$selected.' value="'.$k.'">'.$v.'</option>';
            }            
            $return .= '</select>';
        }
            
            
        return $return;
    }
    
    function insertBox_setup_modul_field_iLoad($field, $id) {
        $pilihan = $this->arrVal;
        $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
        foreach($pilihan as $k=>$v) {
            $return .= '<option value="'.$k.'">'.$v.'</option>';
        }            
        $return .= '</select>';
        $return .= '<script>
                        $("label[for=\'setup_modul_field_vLoad_path\']").parent().hide();
                        $("#setup_modul_field_vLoad_path").removeClass("required error_text");

                        $("#'.$id.'").change(function(){
                            var load = $(this).val();
                            if (load == 1){
                                $("label[for=\'setup_modul_field_vLoad_path\']").parent().show();
                                $("#setup_modul_field_vLoad_path").addClass("required");
                            } else {
                                $("label[for=\'setup_modul_field_vLoad_path\']").parent().hide();
                                $("#setup_modul_field_vLoad_path").removeClass("required error_text");
                            }
                        })
                    </script>';
    
        return $return;
    }
    
    function updateBox_setup_modul_field_iLoad($field, $id, $value, $rowData) {
        $pilihan = $this->arrVal;
        $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
        foreach($pilihan as $k=>$v) {
            if ($k == $value) $selected = ' selected';
            else $selected = '';
            $return .= '<option '.$selected.' value="'.$k.'">'.$v.'</option>';
        }            
        $return .= '</select>';   
        $return .= '<script>
                        var iload = '.$value.';
                        if (iload == 1){
                            $("label[for=\'setup_modul_field_vLoad_path\']").parent().show();
                            $("#setup_modul_field_vLoad_path").addClass("required");
                        } else {
                            $("label[for=\'setup_modul_field_vLoad_path\']").parent().hide();
                            $("#setup_modul_field_vLoad_path").removeClass("required error_text");
                        }

                        $("#'.$id.'").change(function(){
                            var load = $(this).val();
                            if (load == 1){
                                $("label[for=\'setup_modul_field_vLoad_path\']").parent().show();
                                $("#setup_modul_field_vLoad_path").addClass("required");
                            } else {
                                $("label[for=\'setup_modul_field_vLoad_path\']").parent().hide();
                                $("#setup_modul_field_vLoad_path").removeClass("required error_text");
                            }
                        })
                    </script>';         
            
        return $return;
    }
    
    function insertBox_setup_modul_field_vLoad_path($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30"  />';
        return $return;
    }
    
    function updateBox_setup_modul_field_vLoad_path($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_field_iRead_only_form($field, $id) {
        $pilihan = $this->arrVal;
        $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
        foreach($pilihan as $k=>$v) {
            $return .= '<option value="'.$k.'">'.$v.'</option>';
        }            
        $return .= '</select>';

    
        return $return;
    }
    
    function updateBox_setup_modul_field_iRead_only_form($field, $id, $value, $rowData) {
        $pilihan = $this->arrVal;
        if ($this->input->get('action') == 'view') {
            $return = $pilihan[$value];
        } else {
            $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
            foreach($pilihan as $k=>$v) {
                if ($k == $value) $selected = ' selected';
                else $selected = '';
                $return .= '<option '.$selected.' value="'.$k.'">'.$v.'</option>';
            }            
            $return .= '</select>';
        }
            
            
        return $return;
    }
    
    function insertBox_setup_modul_field_vNama_field($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30"  />';
        return $return;
    }
    
    function updateBox_setup_modul_field_vNama_field($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 " size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_field_vSource_input($field, $id) {
        $return = '<textarea name="'.$field.'" id="'.$id.'" class="" style="width: 98%; height: 100px;" size="250"></textarea>';
        return $return;
    }
    
    function updateBox_setup_modul_field_vSource_input($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= '<label title="Note">'.nl2br($value).'</label>'; 
            }else{ 
                $return = '<textarea name="'.$field.'" id="'.$id.'" class="" style="width: 98%; height: 100px;" size="250">'.($value).'</textarea>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_field_vSource_input_edit($field, $id) {
        $return = '<textarea name="'.$field.'" id="'.$id.'" class="" style="width: 98%; height: 100px;" size="250"></textarea>';
        return $return;
    }
    
    function updateBox_setup_modul_field_vSource_input_edit($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= '<label title="Note">'.nl2br($value).'</label>'; 
            }else{ 
                $return = '<textarea name="'.$field.'" id="'.$id.'" class="" style="width: 98%; height: 100px;" size="250">'.($value).'</textarea>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_field_vRequirement_field($field, $id) {
        $return = '<textarea name="'.$field.'" id="'.$id.'" class="" style="width: 98%; height: 100px;" size="250" maxlength ="250"></textarea>';
        return $return;
    }
    
    function updateBox_setup_modul_field_vRequirement_field($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= '<label title="Note">'.nl2br($value).'</label>'; 
            }else{ 
                $return = '<textarea name="'.$field.'" id="'.$id.'" class="" style="width: 98%; height: 100px;" size="250" maxlength ="250">'.nl2br($value).'</textarea>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_field_iValidation($field, $id) {
        $pilihan = $this->arrVal;
        $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
        foreach($pilihan as $k=>$v) {
            $return .= '<option value="'.$k.'">'.$v.'</option>';
        }            
        $return .= '</select>';
        $return .= '<script>
                        $("label[for=\'setup_modul_field_validation_field\']").parent().hide();
                        $("label[for=\'setup_modul_field_validation_after\']").parent().hide();
                        $("#setup_modul_field_validation_field_input").removeClass("required error_text");
                        $("#setup_modul_field_validation_field_edit").removeClass("required error_text");
                        $("#setup_modul_field_validation_after_input").removeClass("required error_text");
                        $("#setup_modul_field_validation_after_edit").removeClass("required error_text");
                        $("#setup_modul_field_validation_after_sort").removeClass("required error_text");

                        $("#'.$id.'").change(function(){
                            var load = $(this).val();
                            if (load == 1){
                                $("label[for=\'setup_modul_field_validation_field\']").parent().show();
                                $("label[for=\'setup_modul_field_validation_after\']").parent().show();
                                $("#setup_modul_field_validation_field_input").addClass("required");
                                $("#setup_modul_field_validation_field_edit").addClass("required");
                                $("#setup_modul_field_validation_after_input").addClass("required");
                                $("#setup_modul_field_validation_after_edit").addClass("required");
                                $("#setup_modul_field_validation_after_sort").addClass("required");
                            } else {
                                $("label[for=\'setup_modul_field_validation_field\']").parent().hide();
                                $("label[for=\'setup_modul_field_validation_after\']").parent().hide();
                                $("#setup_modul_field_validation_field_input").removeClass("required error_text");
                                $("#setup_modul_field_validation_field_edit").removeClass("required error_text");
                                $("#setup_modul_field_validation_after_input").removeClass("required error_text");
                                $("#setup_modul_field_validation_after_edit").removeClass("required error_text");
                                $("#setup_modul_field_validation_after_sort").removeClass("required error_text");
                            }
                        })
                    </script>';  

    
        return $return;
    }
    
    function updateBox_setup_modul_field_iValidation($field, $id, $value, $rowData) {
        $pilihan = $this->arrVal;
        if ($this->input->get('action') == 'view') {
            $return = $pilihan[$value];
        } else {
            $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
            foreach($pilihan as $k=>$v) {
                $selected = ($k==$value)?'selected':'';
                $return .= '<option '.$selected.' value="'.$k.'">'.$v.'</option>';
            }            
            $return .= '</select>';
        }

        $return .= '<script>
                        var iload = '.$value.';
                        if (iload == 1){
                            $("label[for=\'setup_modul_field_validation_field\']").parent().show();
                            $("label[for=\'setup_modul_field_validation_after\']").parent().show();
                        } else {
                            $("label[for=\'setup_modul_field_validation_field\']").parent().hide();
                            $("label[for=\'setup_modul_field_validation_after\']").parent().hide();
                        }

                        $("#'.$id.'").change(function(){
                            var load = $(this).val();
                            if (load == 1){
                                $("label[for=\'setup_modul_field_validation_field\']").parent().show();
                                $("label[for=\'setup_modul_field_validation_after\']").parent().show();
                            } else {
                                $("label[for=\'setup_modul_field_validation_field\']").parent().hide();
                                $("label[for=\'setup_modul_field_validation_after\']").parent().hide();
                            }
                        })
                    </script>'; 
            
        return $return;
    }

    function insertBox_setup_modul_field_validation_field($field, $id) {
        $return  = '<table id="validation_field_table" cellspacing="0" cellpadding="1" style="width: 99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">';
        $return .= '    <thead>';
        $return .= '        <tr>';
        $return .= '            <th style="width:2%;">No.</th>';
        $return .= '            <th>Validation</th>';
        $return .= '            <th>Validation Edit</th>';
        $return .= '            <th style="width:8%;">Aktif</th>';
        $return .= '            <th style="width:8%;">Action</th>';
        $return .= '        </tr>';
        $return .= '    </thead>';
        $return .= '    <tbody>';
        $return .= '        <tr>';
        $return .= '            <td><span class="validation_field_table_num">1.</span></td>';
        $return .= '            <td><textarea id="'.$id.'_input" class="" style="width: 90%;" name="val_field_input[]"></textarea></td>';
        $return .= '            <td><textarea id="'.$id.'_edit" class="" style="width: 90%;" name="val_field_edit[]"></textarea></td>';
        $return .= '            <td>';
        $return .= '                <select name="val_field_val[]">';
        foreach ($this->arrVal as $k => $v) {
            $return .= '                <option value="'.$k.'">'.$v.'</option>';
        }
        $return .= '                </select>';
        $return .= '            </td>';
        $return .= '            <td>';
        $return .= '                <input type="hidden" name="val_field_id[]" value="" />';
        $return .= '                <span class="validation_field_table_delete_btn"><a href="javascript:;" class="validation_field_table_del" onclick="del_row(this, \'validation_field_table_del\')">[Delete]</a></span>';
        $return .= '            </td>';
        $return .= '        </tr>';
        $return .= '    </tbody>';
        $return .= '    <tfoot>';
        $return .= '        <td colspan="3"></td>';
        $return .= '        <td>';
        $return .= '            <td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row(\'validation_field_table\')">Tambah</a></td>';
        $return .= '        </td>';
        $return .= '    </tfoot>';
        $return .= '</table>';
        $return .= '<script>
                        var field = $("label[for=\'setup_modul_field_validation_field\']");
                        var input = field.parent().find("div").css({"margin":"0px"});
                        field.css({
                            "width" : "99%",
                            "background" : "#548cb6",
                            "text-align" : "center",
                            "color" : "#fff",
                            "text-transform" : "uppercase",
                            "font-weight" : "bold"
                        });
                    </script>';
        return $return;
    }
    
    function updateBox_setup_modul_field_validation_field($field, $id, $value, $rowData) { 
        $rows    = $this->db->get_where('erp_privi.m_modul_fields_validation', array('lDeleted' => 0, 'iM_modul_fields' => $rowData['iM_modul_fields']))->result_array();

        $return  = '<table id="validation_field_table" cellspacing="0" cellpadding="1" style="width: 99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">';
        $return .= '    <thead>';
        $return .= '        <tr>';
        $return .= '            <th style="width:2%;">No.</th>';
        $return .= '            <th>Validation</th>';
        $return .= '            <th>Validation Edit</th>';
        $return .= '            <th style="width:8%;">Aktif</th>';
        $return .= '            <th style="width:8%;">Action</th>';
        $return .= '        </tr>';
        $return .= '    </thead>';
        $return .= '    <tbody>';
        if (count($rows) > 0){
            foreach ($rows as $row) {
                $return .= '<tr>';
                $return .= '    <td><span class="validation_field_table_num">1.</span></td>';
                $return .= '    <td><textarea id="'.$id.'_input" class="" style="width: 90%;" name="val_field_input[]">'.$row['vSource_input_validtation'].'</textarea></td>';
                $return .= '    <td><textarea id="'.$id.'_edit" class="" style="width: 90%;" name="val_field_edit[]">'.$row['vSource_input_edit_validtation'].'</textarea></td>';
                $return .= '    <td>';
                $return .= '        <select name="val_field_val[]">';
                foreach ($this->arrVal as $k => $v) {
                    $selected = ($row['iValidation'] == $k)?'selected':'';
                    $return .= '        <option '.$selected.' value="'.$k.'">'.$v.'</option>';
                }
                $return .= '        </select>';
                $return .= '    </td>';
                $return .= '    <td>';
                $return .= '        <input type="hidden" name="val_field_id[]" value="'.$row['iM_modul_fields_validation'].'" />';
                $return .= '        <span class="validation_field_table_delete_btn"><a href="javascript:;" class="validation_field_table_del" onclick="del_row(this, \'validation_field_table_del\')">[Delete]</a></span>';
                $return .= '    </td>';
                $return .= '</tr>';
            }
        } else {
            $return .= '    <tr>';
            $return .= '        <td><span class="validation_field_table_num">1.</span></td>';
            $return .= '        <td><textarea id="'.$id.'_input" class="" style="width: 90%;" name="val_field_input[]"></textarea></td>';
            $return .= '        <td><textarea id="'.$id.'_edit" class="" style="width: 90%;" name="val_field_edit[]"></textarea></td>';
            $return .= '        <td>';
            $return .= '            <select name="val_field_val[]">';
            foreach ($this->arrVal as $k => $v) {
                $return .= '            <option value="'.$k.'">'.$v.'</option>';
            }
            $return .= '            </select>';
            $return .= '        </td>';
            $return .= '        <td>';
            $return .= '            <input type="hidden" name="val_field_id[]" value="" />';
            $return .= '            <span class="validation_field_table_delete_btn"><a href="javascript:;" class="validation_field_table_del" onclick="del_row(this, \'validation_field_table_del\')">[Delete]</a></span>';
            $return .= '        </td>';
            $return .= '    </tr>';
        }
        $return .= '    </tbody>';
        $return .= '    <tfoot>';
        $return .= '        <td colspan="3"></td>';
        $return .= '        <td>';
        $return .= '            <td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row(\'validation_field_table\')">Tambah</a></td>';
        $return .= '        </td>';
        $return .= '    </tfoot>';
        $return .= '</table>';
        $return .= '<script>
                        var field = $("label[for=\'setup_modul_field_validation_field\']");
                        var input = field.parent().find("div").css({"margin":"0px"});
                        field.css({
                            "width" : "99%",
                            "background" : "#548cb6",
                            "text-align" : "center",
                            "color" : "#fff",
                            "text-transform" : "uppercase",
                            "font-weight" : "bold"
                        });
                    </script>';
        return $return;
    }

    function insertBox_setup_modul_field_validation_after($field, $id) {
        $return  = '<table id="validation_after_table" cellspacing="0" cellpadding="1" style="width: 99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">';
        $return .= '    <thead>';
        $return .= '        <tr>';
        $return .= '            <th style="width:2%;">No.</th>';
        $return .= '            <th>Validation</th>';
        $return .= '            <th>Validation Edit</th>';
        $return .= '            <th style="width:8%;">No. Urut</th>';
        $return .= '            <th style="width:8%;">Action</th>';
        $return .= '        </tr>';
        $return .= '    </thead>';
        $return .= '    <tbody>';
        $return .= '        <tr>';
        $return .= '            <td><span class="validation_field_table_num">1.</span></td>';
        $return .= '            <td><textarea id="'.$id.'_input" class="" style="width: 90%;" name="val_after_input[]"></textarea></td>';
        $return .= '            <td><textarea id="'.$id.'_edit" class="" style="width: 90%;" name="val_after_edit[]"></textarea></td>';
        $return .= '            <td><input type="number" id="'.$id.'_sort" style="width: 90%;" name="val_after_sort[]" class="" /></td>';
        $return .= '            <td>';
        $return .= '                <input type="hidden" name="val_after_id[]" value="" />';
        $return .= '                <span class="validation_after_table_delete_btn"><a href="javascript:;" class="validation_after_table_del" onclick="del_row(this, \'validation_field_table_del\')">[Delete]</a></span>';
        $return .= '            </td>';
        $return .= '        </tr>';
        $return .= '    </tbody>';
        $return .= '    <tfoot>';
        $return .= '        <td colspan="3"></td>';
        $return .= '        <td>';
        $return .= '            <td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row(\'validation_after_table\')">Tambah</a></td>';
        $return .= '        </td>';
        $return .= '    </tfoot>';
        $return .= '</table>';
        $return .= '<script>
                        var field = $("label[for=\'setup_modul_field_validation_after\']");
                        var input = field.parent().find("div").css({"margin":"0px"});
                        field.css({
                            "width" : "99%",
                            "background" : "#548cb6",
                            "text-align" : "center",
                            "color" : "#fff",
                            "text-transform" : "uppercase",
                            "font-weight" : "bold"
                        });
                    </script>';
        return $return;
    }
    
    function updateBox_setup_modul_field_validation_after($field, $id, $value, $rowData) {
        $sql     = 'SELECT a.* FROM erp_privi.m_modul_fields_validation_after a WHERE a.lDeleted = 0 AND a.iM_modul_fields = ? ORDER BY a.iSort ASC ';
        $rows    = $this->db->query($sql, array($rowData['iM_modul_fields']))->result_array();

        $return  = '<table id="validation_after_table" cellspacing="0" cellpadding="1" style="width: 99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">';
        $return .= '    <thead>';
        $return .= '        <tr>';
        $return .= '            <th style="width:2%;">No.</th>';
        $return .= '            <th>Validation</th>';
        $return .= '            <th>Validation Edit</th>';
        $return .= '            <th style="width:8%;">No. Urut</th>';
        $return .= '            <th style="width:8%;">Action</th>';
        $return .= '        </tr>';
        $return .= '    </thead>';
        $return .= '    <tbody>';
        if (count($rows) > 0){
            foreach ($rows as $row) {
                $return .= '<tr>';
                $return .= '    <td><span class="validation_field_table_num">1.</span></td>';
                $return .= '    <td><textarea id="'.$id.'_input" class="" style="width: 90%;" name="val_after_input[]">'.$row['vSource_input_validtation_after'].'</textarea></td>';
                $return .= '    <td><textarea id="'.$id.'_edit" class="" style="width: 90%;" name="val_after_edit[]">'.$row['vSource_input_edit_validtation_after'].'</textarea></td>';
                $return .= '    <td><input type="number" id="'.$id.'_sort" style="width: 90%;" name="val_after_sort[]" class="" value="'.$row['iSort'].'" /></td>';
                $return .= '    <td>';
                $return .= '        <input type="hidden" name="val_after_id[]" value="'.$row['iM_modul_fields_validation_after'].'" />';
                $return .= '        <span class="validation_field_table_delete_btn"><a href="javascript:;" class="validation_after_table_del" onclick="del_row(this, \'validation_field_table_del\')">[Delete]</a></span>';
                $return .= '    </td>';
                $return .= '</tr>';
            }
        } else {
            $return .= '    <tr>';
            $return .= '        <td><span class="validation_field_table_num">1.</span></td>';
            $return .= '        <td><textarea id="'.$id.'_input" class="" style="width: 90%;" name="val_after_input[]"></textarea></td>';
            $return .= '        <td><textarea id="'.$id.'_edit" class="" style="width: 90%;" name="val_after_edit[]"></textarea></td>';
            $return .= '        <td><input type="number" id="'.$id.'_sort" style="width: 90%;" name="val_after_sort[]" class="" /></td>';
            $return .= '        <td>';
            $return .= '            <input type="hidden" name="val_after_id[]" value="" />';
            $return .= '            <span class="validation_field_table_delete_btn"><a href="javascript:;" class="validation_after_table_del" onclick="del_row(this, \'validation_field_table_del\')">[Delete]</a></span>';
            $return .= '        </td>';
            $return .= '    </tr>';
        }
        $return .= '    </tbody>';
        $return .= '    <tfoot>';
        $return .= '        <td colspan="3"></td>';
        $return .= '        <td>';
        $return .= '            <td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row(\'validation_after_table\')">Tambah</a></td>';
        $return .= '        </td>';
        $return .= '    </tfoot>';
        $return .= '</table>';
        $return .= '<script>
                        var field = $("label[for=\'setup_modul_field_validation_after\']");
                        var input = field.parent().find("div").css({"margin":"0px"});
                        field.css({
                            "width" : "99%",
                            "background" : "#548cb6",
                            "text-align" : "center",
                            "color" : "#fff",
                            "text-transform" : "uppercase",
                            "font-weight" : "bold"
                        });
                    </script>';
        return $return;
    }
    
    function insertBox_setup_modul_field_iRead_flow($field, $id) {
        $pilihan = $this->arrVal;
        $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
        foreach($pilihan as $k=>$v) {
            $return .= '<option value="'.$k.'">'.$v.'</option>';
        }            
        $return .= '</select>';

    
        return $return;
    }
    
    function updateBox_setup_modul_field_iRead_flow($field, $id, $value, $rowData) {
        $pilihan = $this->arrVal;
        if ($this->input->get('action') == 'view') {
            $return = $pilihan[$value];
        } else {
            $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
            foreach($pilihan as $k=>$v) {
                if ($k == $value) $selected = ' selected';
                else $selected = '';
                $return .= '<option '.$selected.' value="'.$k.'">'.$v.'</option>';
            }            
            $return .= '</select>';
        }
            
            
        return $return;
    }
    
    function insertBox_setup_modul_field_iRead_team($field, $id) {
        $pilihan = $this->arrVal;
        $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
        foreach($pilihan as $k=>$v) {
            $return .= '<option value="'.$k.'">'.$v.'</option>';
        }            
        $return .= '</select>';
        $return .= '<script>
                        $("label[for=\'setup_modul_field_vRead_team\']").parent().hide();
                        $("#setup_modul_field_vRead_team").removeClass("required error_text");
                        $("#'.$id.'").change(function(){
                            var read = $(this).val();
                            if (read == 1){
                                $("label[for=\'setup_modul_field_vRead_team\']").parent().show();
                                $("#setup_modul_field_vRead_team").addClass("required");
                            } else {
                                $("label[for=\'setup_modul_field_vRead_team\']").parent().hide();
                                $("#setup_modul_field_vRead_team").removeClass("required error_text");
                            }
                        });
                    </script>';

    
        return $return;
    }
    
    function updateBox_setup_modul_field_iRead_team($field, $id, $value, $rowData) {
        $pilihan = $this->arrVal;
        if ($this->input->get('action') == 'view') {
            $return = $pilihan[$value];
        } else {
            $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
            foreach($pilihan as $k=>$v) {
                if ($k == $value) $selected = ' selected';
                else $selected = '';
                $return .= '<option '.$selected.' value="'.$k.'">'.$v.'</option>';
            }            
            $return .= '</select>';
        }
        $return .= '<script>
                        var iread = $("#'.$id.'").val();
                        if (iread == 1){
                            $("label[for=\'setup_modul_field_vRead_team\']").parent().show();
                            $("#setup_modul_field_vRead_team").addClass("required");
                        } else {
                            $("label[for=\'setup_modul_field_vRead_team\']").parent().hide();
                            $("#setup_modul_field_vRead_team").removeClass("required error_text");
                        }

                        $("#'.$id.'").change(function(){
                            var read = $(this).val();
                            if (read == 1){
                                $("label[for=\'setup_modul_field_vRead_team\']").parent().show();
                                $("#setup_modul_field_vRead_team").addClass("required");
                            } else {
                                $("label[for=\'setup_modul_field_vRead_team\']").parent().hide();
                                $("#setup_modul_field_vRead_team").removeClass("required error_text");
                            }
                        });
                    </script>';
            
            
        return $return;
    }
    
    function insertBox_setup_modul_field_vRead_team($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30"  />';
        return $return;
    }
    
    function updateBox_setup_modul_field_vRead_team($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 " size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_field_iRequired($field, $id) {
        $pilihan = $this->arrVal;
        $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
        foreach($pilihan as $k=>$v) {
            $return .= '<option value="'.$k.'">'.$v.'</option>';
        }            
        $return .= '</select>';

    
        return $return;
    }
    
    function updateBox_setup_modul_field_iRequired($field, $id, $value, $rowData) {
        $pilihan = $this->arrVal;
        if ($this->input->get('action') == 'view') {
            $return = $pilihan[$value];
        } else {
            $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
            foreach($pilihan as $k=>$v) {
                if ($k == $value) $selected = ' selected';
                else $selected = '';
                $return .= '<option '.$selected.' value="'.$k.'">'.$v.'</option>';
            }            
            $return .= '</select>';
        }
            
            
        return $return;
    }

    function insertBox_setup_modul_field_vDesciption($field, $id) {
        $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 98%; height: 100px;" size="250" maxlength ="250"></textarea>';
        return $return;
    }
    
    function updateBox_setup_modul_field_vDesciption($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= '<label title="Note">'.nl2br($value).'</label>'; 
            }else{ 
                $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 98%; height: 100px;" size="250" maxlength ="250">'.nl2br($value).'</textarea>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_field_vTabel_file($field, $id) {
        $sql         = 'SELECT CONCAT(TABLE_SCHEMA,".",TABLE_NAME) AS TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA LIKE "%plc%" ORDER BY TABLE_NAME ASC';
        $pilihan     = $this->db->query($sql)->result_array();
        $action      = $this->input->get('action');
        $disabled    = ($action == 'view') ? 'disabled' : '';

        $return      = '<select '.$disabled.' class="input_rows1" name="'.$field.'"  id="'.$id.'">';
        $return     .='<option value="">---pilih---</option>';            
        foreach($pilihan as $me) {
            $return .= '<option value='.$me['TABLE_NAME'].'>'.$me['TABLE_NAME'].'</option>';
        }            
        $return .= '</select>';
        $return .= '<script>
                        // $("select#'.$id.'").chosen();
                        $("#'.$id.'").change(function(){
                            $.ajax({
                                url: base_url+"processor/plc/setup/modul/field?action=load_field",
                                type: "post",
                                data : {
                                    table: $(this).val(),
                                    row: "",
                                    action: "'.$this->input->get('action').'"
                                },
                                success: function(data) {
                                    $("#setup_modul_field_vTabel_file_pk_id").val(data);
                                }
                            });
                        })
                    </script>';
        return $return;
    }
    
    function updateBox_setup_modul_field_vTabel_file($field, $id, $value, $rowData) {
        $sql = 'SELECT CONCAT(TABLE_SCHEMA,".",TABLE_NAME) AS TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA LIKE "%plc%" ORDER BY TABLE_NAME ASC';
        $pilihan = $this->db->query($sql)->result_array();
        $action = $this->input->get('action');
        $disabled = ($action == 'view') ? 'disabled' : '';
        $return = '<select '.$disabled.' class="input_rows1" name="'.$field.'"  id="'.$id.'">';
        $return.='<option value="">---pilih---</option>';            
        foreach($pilihan as $me) {
            $selected = ($value == $me['TABLE_NAME']) ? 'selected' : '';
            $return .= '<option '.$selected.' value='.$me['TABLE_NAME'].'>'.$me['TABLE_NAME'].'</option>';
        }            
        $return .= '</select>';
        $return .= '<script>
                        // $("select#'.$id.'").chosen();
                        $("#'.$id.'").change(function(){
                            $.ajax({
                                url: base_url+"processor/plc/setup/modul/field?action=load_field",
                                type: "post",
                                data : {
                                    table: $(this).val(),
                                    row: "",
                                    action: "'.$this->input->get('action').'"
                                },
                                success: function(data) {
                                    $("#setup_modul_field_vTabel_file_pk_id").val(data);
                                }
                            });
                        })
                    </script>';   
        return $return;
    }
    
    function insertBox_setup_modul_field_vTabel_file_pk_id($field, $id) {
        $return = '<input readonly type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30"  />';
        return $return;
    }
    
    function updateBox_setup_modul_field_vTabel_file_pk_id($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input readonly type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_field_vDept_author($field, $id) {
        $dept = $this->db->get_where('erp_privi.m_dept', array('lDeleted' => 0))->result_array();

        $return = '<select  class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
        foreach($dept as $d) {
            $return .= '<option value='.$d['vKode_dept'].'>'.$d['vKode_dept'].' - '.$d['vNama_dept'].'</option>';
        }            
        $return .= '</select>';
                
        return $return;
    }
    
    function updateBox_setup_modul_field_vDept_author($field, $id, $value, $rowData) {
        $dept = $this->db->get_where('erp_privi.m_dept', array('lDeleted' => 0))->result_array();

        $return = '<select  class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
        foreach($dept as $d) {
            $selected = ($d['vKode_dept']==$value)?'selected':'';
            $return .= '<option '.$selected.' value='.$d['vKode_dept'].'>'.$d['vKode_dept'].' - '.$d['vNama_dept'].'</option>';
        }            
        $return .= '</select>';
        return $return;
    }
    
    function insertBox_setup_modul_field_vNip_author($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30"  />';
        return $return;
    }
    
    function updateBox_setup_modul_field_vNip_author($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 " size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_field_vDept_participant($field, $id) {
        $dept = $this->db->get_where('erp_privi.m_dept', array('lDeleted' => 0))->result_array();

        $return  = '<style>
                        #dept_assigned thead tr{
                            background : #5c9ccc;
                            color: #fff;
                            font-weight: bold;
                            text-transform: uppercase;
                            text-align: center;
                        }
                    </style>';
        $return .= '<table id="dept_assigned" cellspacing="0" cellpadding="1" style="width: 99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">';
        $return .= '    <thead>';
        $return .= '        <tr>';
        $return .= '            <th style="width:2%;">No.</th>';
        $return .= '            <th>Departement</th>';
        $return .= '            <th style="width:10%;">Action</th>';
        $return .= '        </tr>';
        $return .= '    </thead>';
        $return .= '    <tbody>';
        $return .= '        <tr>';
        $return .= '            <td><span class="validation_field_table_num">1</span></td>';
        $return .= '            <td>';
        $return .= '                <select style="width: 99%" name="departement[]">';
        foreach ($dept as $d) {
            $return .= '                <option value="'.$d['vKode_dept'].'">'.$d['vKode_dept'].' - '.$d['vNama_dept'].'</option>';
        }
        $return .= '               </select>';
        $return .= '            </td>';
        $return .= '            <td>';
        $return .= '                <span class="dept_assigned_delete_btn"><a href="javascript:;" class="dept_assigned_del" onclick="del_row(this, \'dept_assigned_del\')">[Delete]</a></span>';
        $return .= '            </td>';
        $return .= '        </tr>';
        $return .= '    </tbody>';
        $return .= '    <tfoot>';
        $return .= '        <td colspan="1"></td>';
        $return .= '        <td>';
        $return .= '            <td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row(\'dept_assigned\')">Tambah</a></td>';
        $return .= '        </td>';
        $return .= '    </tfoot>';
        $return .= '</table>';
        return $return;
    }
    
    function updateBox_setup_modul_field_vDept_participant($field, $id, $value, $rowData) {
        $dept = $this->db->get_where('erp_privi.m_dept', array('lDeleted' => 0))->result_array();
        $rows = explode(',', $value);

        $return  = '<style>
                        #dept_assigned thead tr{
                            background : #5c9ccc;
                            color: #fff;
                            font-weight: bold;
                            text-transform: uppercase;
                            text-align: center;
                        }
                    </style>';
        $return .= '<table id="dept_assigned" cellspacing="0" cellpadding="1" style="width: 99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">';
        $return .= '    <thead>';
        $return .= '        <tr>';
        $return .= '            <th style="width:2%;">No.</th>';
        $return .= '            <th>Departement</th>';
        $return .= '            <th style="width:10%;">Action</th>';
        $return .= '        </tr>';
        $return .= '    </thead>';
        $return .= '    <tbody>';
        if (count($rows) > 0){
            $index = 1;
            foreach ($rows as $row) {
                $return .= '<tr>';
                $return .= '    <td><span class="dept_assigned_num">'.$index.'</span></td>';
                $return .= '    <td>';
                $return .= '        <select style="width: 99%" name="departement[]">';
                foreach ($dept as $d) {
                    $selected = (strtoupper($row) == strtoupper($d['vKode_dept']))?'selected':'';
                    $return .= '        <option '.$selected.' value="'.$d['vKode_dept'].'">'.$d['vKode_dept'].' - '.$d['vNama_dept'].'</option>';
                }
                $return .= '        </select>';
                $return .= '    </td>';
                $return .= '    <td>';
                $return .= '        <span class="dept_assigned_delete_btn"><a href="javascript:;" class="dept_assigned_del" onclick="del_row(this, \'dept_assigned_del\')">[Delete]</a></span>';
                $return .= '    </td>';
                $return .= '</tr>';
                $index++;
            }
        } else {
            $return .= '    <tr>';
            $return .= '        <td><span class="validation_field_table_num">1</span></td>';
            $return .= '        <td>';
            $return .= '            <select style="width: 99%" name="departement[]">';
            foreach ($dept as $d) {
                $return .= '            <option value="'.$d['vKode_dept'].'">'.$d['vKode_dept'].' - '.$d['vNama_dept'].'</option>';
            }
            $return .= '            </select>';
            $return .= '        </td>';
            $return .= '        <td>';
            $return .= '            <span class="dept_assigned_delete_btn"><a href="javascript:;" class="dept_assigned_del" onclick="del_row(this, \'dept_assigned_del\')">[Delete]</a></span>';
            $return .= '        </td>';
            $return .= '    </tr>';
        }
        $return .= '    </tbody>';
        $return .= '    <tfoot>';
        $return .= '        <td colspan="1"></td>';
        $return .= '        <td>';
        $return .= '            <td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row(\'dept_assigned\')">Tambah</a></td>';
        $return .= '        </td>';
        $return .= '    </tfoot>';
        $return .= '</table>';
        return $return;
    }
    
    function insertBox_setup_modul_field_vNip_participant($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30"  />';
        return $return;
    }
    
    function updateBox_setup_modul_field_vNip_participant($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_field_vFile_detail($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30"  />';
        return $return;
    }
    
    function updateBox_setup_modul_field_vFile_detail($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }

    function insertBox_setup_modul_field_lDeleted($field, $id) {
        $pilihan = $this->arrStat;
        $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
        foreach($pilihan as $k=>$v) {
            $return .= '<option value="'.$k.'">'.$v.'</option>';
        }            
        $return .= '</select>';

    
        return $return;
    }
    
    function updateBox_setup_modul_field_lDeleted($field, $id, $value, $rowData) {
        $pilihan = $this->arrStat;
        if ($this->input->get('action') == 'view') {
            $return = $pilihan[$value];
        } else {
            $return = '<select class="input_rows1" name="'.$field.'"  id="'.$id.'">';            
            foreach($pilihan as $k=>$v) {
                if ($k == $value) $selected = ' selected';
                else $selected = '';
                $return .= '<option '.$selected.' value="'.$k.'">'.$v.'</option>';
            }            
            $return .= '</select>';
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
                                    var url = "'.base_url().'processor/plc/setup_modul_field";                             
                                    if(o.status == true) { 
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id, function(data) {
                                             $("div#form_setup_modul_field").html(data);
                                             
                                        });
                                        
                                    }
                                        reload_grid("grid_setup_modul_field");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Approve</h1><br />';
            $echo .= '<form id="form_setup_modul_field_approve" action="'.base_url().'processor/plc/setup_modul_field?action=approve_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= 'Remark : 
                    <input type="hidden" name="iM_modul_fields" value="'.$this->input->get('iM_modul_fields').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    
                    <textarea name="vRemark"></textarea>
            <button type="button" onclick="submit_ajax(\'form_setup_modul_field_approve\')">Approve</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        } 

        function approve_process() {
            $post = $this->input->post();
            $cNip= $this->user->gNIP;
            $vName= $this->user->gName;
            $iM_modul_fields = $post['iM_modul_fields'];
            $vRemark = $post['vRemark'];
            $lvl = $post['lvl'];

            //Letakan Query Update approve disini

            $data['status']  = true;
            $data['last_id'] = $post['iM_modul_fields'];
            return json_encode($data);
        }
    */


    /*
        //Ini Merupakan Standart Reject yang digunakan di erp
        function reject_view() {
            $echo = '<script type="text/javascript">
                         function submit_ajax(form_id) {
                            var remark = $("#setup_modul_field_remark").val();
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
                                    var url = "'.base_url().'processor/plc/setup_modul_field";                             
                                    if(o.status == true) { 
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id, function(data) {
                                             $("div#form_setup_modul_field").html(data);
                                             
                                        });
                                        
                                    }
                                        reload_grid("grid_setup_modul_field");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Reject</h1><br />';
            $echo .= '<form id="form_setup_modul_field_reject" action="'.base_url().'processor/plc/setup_modul_field?action=reject_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= 'Remark : 
                    <input type="hidden" name="iM_modul_fields" value="'.$this->input->get('iM_modul_fields').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    
                    <textarea name="vRemark" id="reject_setup_modul_field_remark"></textarea>
            <button type="button" onclick="submit_ajax(\'form_setup_modul_field_reject\')">Reject</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }


        
        function reject_process() {
            $post = $this->input->post();
            $cNip= $this->user->gNIP;
            $vName= $this->user->gName;
            $iM_modul_fields = $post['iM_modul_fields'];
            $vRemark = $post['vRemark'];
            $lvl = $post['lvl'];

            //Letakan Query Update approve disini

            $data['status']  = true;
            $data['last_id'] = $post['iM_modul_fields'];
            return json_encode($data);
        }
    */


    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated'] = $this->user->gNIP;
        $departement = $postData['departement'];
        $vDept_participant = '';
        foreach ($departement as $d) {
            $vDept_participant = (strlen($vDept_participant) > 0)?$vDept_participant.','.$d:$d;
        }
        $postData['vDept_participant'] = $vDept_participant;

        return $postData;

    }
    function before_update_processor($row, $postData) { 
        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;
        $departement = $postData['departement'];
        $vDept_participant = '';
        foreach ($departement as $d) {
            $vDept_participant = (strlen($vDept_participant) > 0)?$vDept_participant.','.$d:$d;
        }
        $postData['vDept_participant'] = $vDept_participant;

        return $postData; 
    }    

    function after_insert_processor($fields, $id, $postData) { 
        $iM_modul_fields    = $id;
        $nip                = $this->user->gNIP;
        $date               = date('Y-m-d H:i:s');

        if (intval($postData['iValidation']) == 1){
            $val_field_input    = $postData['val_field_input'];
            $val_field_edit     = $postData['val_field_edit'];
            $val_field_id       = $postData['val_field_id'];
            $val_field_val      = $postData['val_field_val'];

            foreach ($val_field_input as $key => $value) {
                if (!empty($value) && !empty($val_field_edit[$key])){
                    $field['iM_modul_fields']                  = $iM_modul_fields;
                    $field['vSource_input_validtation']        = $value;
                    $field['vSource_input_edit_validtation']   = $val_field_edit[$key];
                    $field['iValidation']                      = $val_field_val[$key];
                    $field['dCreate']                          = $date;
                    $field['cCreated']                         = $nip;
                    $field['lDeleted']                         = 0;
                    $this->db->insert('erp_privi.m_modul_fields_validation', $field);
                }
            }

            $val_after_input    = $postData['val_after_input'];
            $val_after_edit     = $postData['val_after_edit'];
            $val_after_id       = $postData['val_after_id'];
            $val_after_sort     = $postData['val_after_sort'];

            foreach ($val_after_input as $key => $value) {
                if (!empty($value) && !empty($val_after_edit[$key])){
                    $after['iM_modul_fields']                          = $iM_modul_fields;
                    $after['vSource_input_validtation_after']          = $value;
                    $after['vSource_input_edit_validtation_after']     = $val_after_edit[$key];
                    $after['iSort']                                    = $val_after_sort[$key];
                    $after['dCreate']                                  = $date;
                    $after['cCreated']                                 = $nip;
                    $after['lDeleted']                                 = 0;
                    $this->db->insert('erp_privi.m_modul_fields_validation_after', $after);
                }
            }
        }

    }

    function after_update_processor($fields, $id, $postData) {
        $iM_modul_fields    = $id;
        $nip                = $this->user->gNIP;
        $date               = date('Y-m-d H:i:s');

        if (intval($postData['iValidation']) == 1){
            $val_field_input    = $postData['val_field_input'];
            $val_field_edit     = $postData['val_field_edit'];
            $val_field_id       = $postData['val_field_id'];
            $val_field_val      = $postData['val_field_val'];
            $field_pk           = 'iM_modul_fields_validation';
            $field_existing     = $this->db->get_where('erp_privi.m_modul_fields_validation', array('lDeleted' => 0, 'iM_modul_fields' => $iM_modul_fields))->result_array(); 

            foreach ($field_existing as $value) {
                if (in_array($value[$field_pk], $val_field_id)){
                    $key    = array_search($value[$field_pk], $val_field_id);
                    $field['iM_modul_fields']                  = $iM_modul_fields;
                    $field['vSource_input_validtation']        = $val_field_input[$key];
                    $field['vSource_input_edit_validtation']   = $val_field_edit[$key];
                    $field['iValidation']                      = $val_field_val[$key];
                    $field['dupdate']                          = $date;
                    $field['cUpdate']                          = $nip;
                    $field['lDeleted']                         = 0;
                    $this->db->where($field_pk, $val_field_id[$key]);
                    $this->db->update('erp_privi.m_modul_fields_validation', $field);
                } else {
                    $f_del['iM_modul_fields']                  = $iM_modul_fields;
                    $f_del['dupdate']                          = $date;
                    $f_del['cUpdate']                          = $nip;
                    $f_del['lDeleted']                         = 1;
                    $this->db->where($field_pk, $value[$field_pk]);
                    $this->db->update('erp_privi.m_modul_fields_validation', $f_del);
                }
            }

            foreach ($val_field_id as $key => $value) {
                if (empty($value)){
                    $f_insert['iM_modul_fields']                  = $iM_modul_fields;
                    $f_insert['vSource_input_validtation']        = $val_field_input[$key];
                    $f_insert['vSource_input_edit_validtation']   = $val_field_edit[$key];
                    $f_insert['iValidation']                      = $val_field_val[$key];
                    $f_insert['dCreate']                          = $date;
                    $f_insert['cCreated']                         = $nip;
                    $f_insert['lDeleted']                         = 0;
                    $this->db->insert('erp_privi.m_modul_fields_validation', $f_insert);
                }
            }


            $val_after_input    = $postData['val_after_input'];
            $val_after_edit     = $postData['val_after_edit'];
            $val_after_id       = $postData['val_after_id'];
            $val_after_sort     = $postData['val_after_sort'];
            $after_pk           = 'iM_modul_fields_validation_after';
            $after_existing     = $this->db->get_where('erp_privi.m_modul_fields_validation_after', array('lDeleted' => 0, 'iM_modul_fields' => $iM_modul_fields))->result_array();

            foreach ($after_existing as $value) {
                if (in_array($value[$after_pk], $val_after_id)){
                    $key    = array_search($value[$after_pk], $val_after_id);
                    $after['iM_modul_fields']                          = $iM_modul_fields;
                    $after['vSource_input_validtation_after']          = $val_after_input[$key];
                    $after['vSource_input_edit_validtation_after']     = $val_after_edit[$key];
                    $after['iSort']                                    = $val_after_sort[$key];
                    $after['dupdate']                                  = $date;
                    $after['cUpdate']                                  = $nip;
                    $after['lDeleted']                                 = 0;
                    $this->db->where($after_pk, $val_after_id[$key]);
                    $this->db->update('erp_privi.m_modul_fields_validation_after', $after);
                } else {
                    $a_del['iM_modul_fields']                  = $iM_modul_fields;
                    $a_del['dupdate']                          = $date;
                    $a_del['cUpdate']                          = $nip;
                    $a_del['lDeleted']                         = 1;
                    $this->db->where($after_pk, $value[$after_pk]);
                    $this->db->update('erp_privi.m_modul_fields_validation_after', $a_del);
                }
            }

            foreach ($val_after_id as $key => $value) {
                if (empty($value)){
                    $a_insert['iM_modul_fields']                        = $iM_modul_fields;
                    $a_insert['vSource_input_validtation_after']        = $val_after_input[$key];
                    $a_insert['vSource_input_edit_validtation_after']   = $val_after_edit[$key];
                    $a_insert['iSort']                                  = $val_after_sort[$key];
                    $a_insert['dCreate']                                = $date;
                    $a_insert['cCreated']                               = $nip;
                    $a_insert['lDeleted']                               = 0;
                    $this->db->insert('erp_privi.m_modul_fields_validation_after', $a_insert);
                }
            }
        }
    }

    function manipulate_insert_button($buttons) { 
        unset($buttons['save']);
        unset($buttons['save_back']);
        unset($buttons['cancel']);
        
        $buttons['save_back']  =  "<script type='text/javascript'>
                                        function create_btn_back_".$this->url."(grid, url, dis) {    
                                            var req = $('#form_create_'+grid+' input.required, #form_create_'+grid+' select.required, #form_create_'+grid+' textarea.required');
                                            var conf=0;
                                            var alert_message = '';
                                            var tot_err = 0;
                                            var adaDiStockOpname = 0;
                                            var statusStockOpname = 0;
                                            $.each(req, function(i,v){
                                                $(this).removeClass('error_text');
                                                if($(this).val() == '') {
                                                    var id = $(this).attr('id');
                                                    var label = $(\"label[for=\''+id+\'']\").text();
                                                    label = label.replace('*','');
                                                    alert_message += '<br /><b>'+label+'</b> '+required_message;            
                                                    $(this).addClass('error_text');         
                                                    conf++;
                                                }       
                                            })
                                            if(conf > 0) {
                                                _custom_alert(alert_message,'Error!','info',grid, 1, 5000);
                                            }
                                            else {
                                            custom_confirm(comfirm_message,function(){
                                                    $.ajax({
                                                        url: $('#form_create_'+grid).attr('action'),
                                                        type: 'post',
                                                        data: $('#form_create_'+grid).serialize(),
                                                        success: function(data) {
                                                            var o = $.parseJSON(data);
                                                            var info = 'Error';
                                                            var header = 'Error';
                                                            var last_id = o.last_id;
                                                            var foreign_id = o.foreign_id;
                                                            
                                                            if(o.status == true) {
                                                                    $('#grid_'+grid).trigger('reloadGrid');
                                                                    $.get(url+'&action=update&id='+last_id+'&foreign_key='+foreign_id+'&iM_modul='+foreign_id, function(data) {
                                                                            $('#alert_dialog_form').html(data);
                                                                    });
                                                                    info = 'info';
                                                                    header = 'Info';
                                                            }
                                                            _custom_alert(o.message,header,info, grid, 1, 20000);
                                                        }
                                                    })
                                                });
                                            }
                                        }
                                  </script>";

        $buttons['save_back'] .= "<button type='button' 
                                    name='button_create_".$this->url."' 
                                    id='button_create_".$this->url."' 
                                    class='icon-save ui-button' 
                                    onclick='javascript:create_btn_back_".$this->url."(\"".$this->url."\", \"".base_url()."processor/brosur/setup/modul/field?iM_modul=".$this->input->get('foreign_key')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>
                                    Save Field
                                </button>";

         $buttons['cancel']  =  "<script type='text/javascript'>
                                    function cancel_btn_".$this->url."(grid, url, dis) {     
                                        $('#alert_dialog_form').dialog('close');
                                    }
                                </script>";

        $buttons['cancel'] .= "<button type='button'
                                name='button_cancel_".$this->url."'
                                id='button_cancel_".$this->url."'
                                class='icon-save ui-button'
                                onclick='javascript:cancel_btn_".$this->url."(\"".$this->url."\", \"".base_url()."processor/brosur/setup/modul/field?iM_modul=".$this->input->get('foreign_key')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>
                                Close 
                            </button>";
        
        return $buttons;
    }

    function manipulate_update_button($buttons, $rowData) { 
        unset($buttons['update']);
        unset($buttons['update_back']);
        unset($buttons['cancel']);
        
        $buttons['update_back']  =  "<script type='text/javascript'>
                                        function update_btn_back_".$this->url."(grid, url, dis) {  
                                            var req = $('#form_update_'+grid+' input.required, #form_update_'+grid+' select.required, #form_update_'+grid+' textarea.required');
                                            var conf=0;
                                            var alert_message = '';
                                            var tot_err = 0;
                                            var adaDiStockOpname = 0;
                                            var statusStockOpname = 0;
                                            $.each(req, function(i,v){
                                                $(this).removeClass('error_text');
                                                if($(this).val() == '') {
                                                    var id = $(this).attr('id');
                                                    var label = $(\"label[for=\''+id+\'']\").text();
                                                    label = label.replace('*','');
                                                    alert_message += '<br /><b>'+label+'</b> '+required_message;            
                                                    $(this).addClass('error_text');         
                                                    conf++;
                                                }       
                                            })
                                            if(conf > 0) {
                                                    _custom_alert(alert_message,'Error!','info',grid, 1, 5000);
                                            }
                                            else {
                                                custom_confirm(comfirm_message,function(){
                                                    $.ajax({
                                                        url: $('#form_update_'+grid).attr('action'),
                                                        type: 'post',
                                                        data: $('#form_update_'+grid).serialize(),
                                                        success: function(data) {
                                                            var o = $.parseJSON(data);
                                                            var info = 'Error';
                                                            var header = 'Error';
                                                            var last_id = o.last_id;
                                                            var foreign_id = o.foreign_id;
                                                            if(o.status == true) {
                                                                reload_grid('grid_'+grid);
                                                                info = 'info';
                                                                header = 'Info';
                                                            }
                                                            _custom_alert(o.message,header,info, grid, 1, 20000);
                                                        }
                                                    })
                                                });
                                            }
                                        }
                                  </script>";

        $buttons['update_back'] .= "<button type='button'
                                        name='button_update_".$this->url."'
                                        id='button_update_".$this->url."'
                                        class='icon-save ui-button'
                                        onclick='javascript:update_btn_back_".$this->url."(\"".$this->url."\", \"".base_url()."processor/brosur/setup/modul/field?iM_modul=".$this->input->get('foreign_key')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>
                                        Update Field
                                    </button>";
            
        $buttons['cancel']  =  "<script type='text/javascript'>
                                    function cancel_btn_".$this->url."(grid, url, dis) {      
                                        $('#alert_dialog_form').dialog('close');
                                    }
                                </script>";

        $buttons['cancel'] .= "<button type='button'
                                    name='button_cancel_".$this->url."'
                                    id='button_cancel_".$this->url."'
                                    class='icon-save ui-button'
                                    onclick='javascript:cancel_btn_".$this->url."(\"".$this->url."\", \"".base_url()."processor/brosur/setup/modul/field?iM_modul=".$this->input->get('foreign_key')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>
                                    Close 
                                </button>";
            
        if ($this->input->get('action') == 'view'){
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
