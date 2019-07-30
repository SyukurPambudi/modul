 
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class setup_modul_activity extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->db = $this->load->database('brosur0',false, true);
        $this->user = $this->auth->user();
        $this->url = 'setup_modul_activity';
        $this->arrTipe = array(1 => 'Insert / Update',2 => 'Approval', 3 => 'Confirmation');
    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle('Setup Modul Activity');
        $grid->setTable('erp_privi.m_modul_activity');      
        $grid->setUrl('setup_modul_activity');

        //List Table
        $grid->addList('iM_activity','iType','vDesciption','vFieldName','vDept_assigned','vNip_assigned','iSort','lDeleted'); 
        $grid->setSortBy('iSort');
        $grid->setSortOrder('ASC');  

        //List field
        $grid->addFields('iSort','iM_activity','iType','vDept_assigned','vSql_get_passed','vNip_assigned','vDesciption','vFieldName','dFieldName','cFieldName','tFieldName','lDeleted'); 

        //Setting Grid Width Name 
        /*
        Kamu bisa merubah nama label dari sini, Contoh :
        $grid->setLabel('nama field','nama field yang akan diubah');

        */

        $grid->setWidth('iM_activity', '150');
        $grid->setAlign('iM_activity', 'left');
        $grid->setLabel('iM_activity','Activity');
    
        $grid->setWidth('iSort', '50');
        $grid->setAlign('iSort', 'center');
        $grid->setLabel('iSort','No. Urut ');
    
        $grid->setWidth('iType', '100');
        $grid->setAlign('iType', 'left');
        $grid->setLabel('iType','Tipe ');
    
        $grid->setWidth('vDept_assigned', '100');
        $grid->setAlign('vDept_assigned', 'left');
        $grid->setLabel('vDept_assigned','Departement ');
    
        $grid->setWidth('vSql_get_passed', '100');
        $grid->setAlign('vSql_get_passed', 'left');
        $grid->setLabel('vSql_get_passed','Get Passed SQL');
    
        $grid->setWidth('vNip_assigned', '100');
        $grid->setAlign('vNip_assigned', 'left');
        $grid->setLabel('vNip_assigned','NIP Assigned ');
    
        $grid->setWidth('vDesciption', '200');
        $grid->setAlign('vDesciption', 'left');
        $grid->setLabel('vDesciption','Keterangan ');
    
        $grid->setWidth('vFieldName', '100');
        $grid->setAlign('vFieldName', 'left');
        $grid->setLabel('vFieldName','Nama Field ');
    
        $grid->setWidth('dFieldName', '100');
        $grid->setAlign('dFieldName', 'left');
        $grid->setLabel('dFieldName','Tanggal Field ');
    
        $grid->setWidth('cFieldName', '100');
        $grid->setAlign('cFieldName', 'left');
        $grid->setLabel('cFieldName','NIP Field ');
    
        $grid->setWidth('tFieldName', '100');
        $grid->setAlign('tFieldName', 'left');
        $grid->setLabel('tFieldName','Remark Field ');

        $grid->setWidth('lDeleted', '100');
        $grid->setAlign('lDeleted', 'center');
        $grid->setLabel('lDeleted','Status Activity');
    
        // $grid->setQuery('m_modul_activity.lDeleted = 0 ', null); 
        $grid->setQuery('m_activity.lDeleted = 0 ', null); 

        $this->iM_modul = $this->input->get('iM_modul');            
        $grid->setInputGet('_iM_modul', $this->iM_modul);            
        $grid->setQuery('m_modul_activity.iM_modul', intval($this->input->get('_iM_modul')));
        $grid->setForeignKey($this->input->get('iM_modul'));
        
        $grid->setJoinTable('erp_privi.m_activity', 'm_modul_activity.iM_activity = m_activity.iM_activity', 'inner');

        $grid->changeFieldType('iType','combobox', '' , array('' => '--Semua--',1 => 'Insert / Update',2 => 'Approval', 3 => 'Confirmation'));
        $grid->changeFieldType('lDeleted','combobox', '' , array('' => '--Semua--', 0 => 'Active', 1 => 'Deleted'));

        $grid->setSearch('iSort','iType','vDesciption','vFieldName','lDeleted');
        
        $grid->setRequired('iM_activity','iSort','iType','vDept_assigned','vSql_get_passed','vNip_assigned','vDesciption','vFieldName','dFieldName','cFieldName','tFieldName'); 
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

    public function manipulate_grid_button($button) {  
        unset($button['create']);
        $url = base_url()."processor/brosur/setup/modul/activity?action=create&foreign_key=".$this->input->get('iM_modul')."&iM_modul=".$this->input->get('iM_modul')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id');
        $btn_baru  = "<script type='text/javascript'>
                function add_btn_$this->url(url, title) {
                    browse_with_no_close(url, title);
                }        
            </script>
        ";

        $btn_baru .= '<span class="icon-add ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" onclick="add_btn_'.$this->url.'(\''.$url.'\', \'SETUP MODULES\')">Add New</span>';
        
        array_unshift($button, $btn_baru);
   
        return $button;
        
    }
    
    function listBox_Action($row, $actions) {
        // unset($actions['view']);
        unset($actions['edit']);
        unset($actions['delete']);
            
        $url = base_url()."processor/brosur/setup/modul/activity?action=update&iM_modul=".$row->iM_modul."&foreign_key=".$row->iM_modul."&id=".$row->iM_modul_activity;
        $edit  = "<script type'text/javascript'>
                                function edit_btn_".$this->url."(url, title) {
                                    browse_with_no_close(url, title);
                                }
                            </script>";
        $edit .= "<a href='#' onclick='javascript:edit_btn_".$this->url."(\"".$url."\", \"SETUP GROUPS\");'><center><span class='ui-icon ui-icon-pencil'></span></center></a>";

        $url2 = base_url()."processor/brosur/setup/modul/activity?action=view&iM_modul=".$row->iM_modul."&foreign_key=".$row->iM_modul."&id=".$row->iM_modul_activity;
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

    function listBox_setup_modul_activity_iM_activity($value){
        $activity = $this->db->get_where('erp_privi.m_activity', array('lDeleted' => 0, 'iM_activity' => $value))->row_array();
        $return = (!empty($activity))?$activity['vKode_activity'].' - '.$activity['vNama_activity']:$value;
        return $return;
    }
    

    function insertBox_setup_modul_activity_iM_activity($field, $id) {
        
        $activity = $this->db->get_where('erp_privi.m_activity', array('lDeleted' => 0))->result_array();
        $return = '<select class="input_rows1 required" name="'.$field.'"  id="'.$id.'">';            
        foreach($activity as $a) {
            $return .= '<option value='.$a['iM_activity'].'>'.$a['vKode_activity'].' - '.$a['vNama_activity'].'</option>';
        }            
        $return .= '</select>';
        $return .= '<input type="hidden" value="'.$this->input->get('foreign_key').'" id="setup_modul_activity_iM_modul" name="iM_modul">';
        return $return;
    }
                        
    function updateBox_setup_modul_activity_iM_activity($field, $id, $value, $rowData) {
        $activity = $this->db->get_where('erp_privi.m_activity', array('lDeleted' => 0))->result_array();
        $return = '<select class="input_rows1 required" name="'.$field.'"  id="'.$id.'">';            
        foreach($activity as $a) {
            $selected = ($a['iM_activity']==$value)?'selected':'';
            $return .= '<option '.$selected.' value='.$a['iM_activity'].'>'.$a['vKode_activity'].' - '.$a['vNama_activity'].'</option>';
        }            
        $return .= '</select>';
        return $return;
    }
                        
    function insertBox_setup_modul_activity_iSort($field, $id) {
        $return = '<input type="number" name="'.$field.'"  id="'.$id.'"  class="input_rows1 angka required" size="10" />';
        return $return;
    }
    
    function updateBox_setup_modul_activity_iSort($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input type="number" name="'.$field.'"  id="'.$id.'"  class="input_rows1 angka required" size="10" value="'.$value.'"/>';

            }
            
        return $return;
    }
                        
    function insertBox_setup_modul_activity_iType($field, $id) {
        $pilihan = $this->arrTipe;
        $return = '<select class="input_rows1 required" name="'.$field.'"  id="'.$id.'">';            
        foreach($pilihan as $k=>$v) {
            $return .= '<option value="'.$k.'">'.$v.'</option>';
        }            
        $return .= '</select>';
        return $return;
    }
    
    function updateBox_setup_modul_activity_iType($field, $id, $value, $rowData) {
        $pilihan = $this->arrTipe;
        if ($this->input->get('action') == 'view') {
            $return = $pilihan[$value];
        } else {
            $return = '<select class="input_rows1 required" name="'.$field.'"  id="'.$id.'">';            
            foreach($pilihan as $k=>$v) {
                if ($k == $value) $selected = ' selected';
                else $selected = '';
                $return .= '<option '.$selected.' value="'.$k.'">'.$v.'</option>';
            }            
            $return .= '</select>';
        }
        return $return;
    }
                        
    function insertBox_setup_modul_activity_vDept_assigned($field, $id) {
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
    
    function updateBox_setup_modul_activity_vDept_assigned($field, $id, $value, $rowData) {
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
                        
    function insertBox_setup_modul_activity_vSql_get_passed($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
        return $return;
    }
    
    function updateBox_setup_modul_activity_vSql_get_passed($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_activity_vNip_assigned($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value=""/>';
        return $return;
    }
    
    function updateBox_setup_modul_activity_vNip_assigned($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_activity_vDesciption($field, $id) {
        $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250"></textarea>';
        return $return;
    }
    
    function updateBox_setup_modul_activity_vDesciption($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= '<label title="Note">'.nl2br($value).'</label>'; 
            }else{ 
                $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250">'.nl2br($value).'</textarea>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_activity_vFieldName($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
        return $return;
    }
    
    function updateBox_setup_modul_activity_vFieldName($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_activity_dFieldName($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
        return $return;
    }
    
    function updateBox_setup_modul_activity_dFieldName($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_activity_cFieldName($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
        return $return;
    }
    
    function updateBox_setup_modul_activity_cFieldName($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }
    
    function insertBox_setup_modul_activity_tFieldName($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
        return $return;
    }
    
    function updateBox_setup_modul_activity_tFieldName($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                 $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }

    function insertBox_setup_modul_activity_lDeleted($field, $id) {
        $pilihan = array(0 => 'Active', 1 => 'Deleted');
        $return = '<select class="input_rows1 required" name="'.$field.'"  id="'.$id.'">';            
        foreach($pilihan as $k=>$v) {
            $return .= '<option value="'.$k.'">'.$v.'</option>';
        }            
        $return .= '</select>';
        return $return;
    }
    
    function updateBox_setup_modul_activity_lDeleted($field, $id, $value, $rowData) {
        $pilihan = array(0 => 'Active', 1 => 'Deleted');
        if ($this->input->get('action') == 'view') {
            $return = $pilihan[$value];
        } else {
            $return = '<select class="input_rows1 required" name="'.$field.'"  id="'.$id.'">';            
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
                                    var url = "'.base_url().'processor/plc/setup_modul_activity";                             
                                    if(o.status == true) { 
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id, function(data) {
                                             $("div#form_setup_modul_activity").html(data);
                                             
                                        });
                                        
                                    }
                                        reload_grid("grid_setup_modul_activity");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Approve</h1><br />';
            $echo .= '<form id="form_setup_modul_activity_approve" action="'.base_url().'processor/plc/setup_modul_activity?action=approve_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= 'Remark : 
                    <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    
                    <textarea name="vRemark"></textarea>
            <button type="button" onclick="submit_ajax(\'form_setup_modul_activity_approve\')">Approve</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        } 

        function approve_process() {
            $post = $this->input->post();
            $cNip= $this->user->gNIP;
            $vName= $this->user->gName;
            $iM_modul_activity = $post['iM_modul_activity'];
            $vRemark = $post['vRemark'];
            $lvl = $post['lvl'];

            //Letakan Query Update approve disini

            $data['status']  = true;
            $data['last_id'] = $post['iM_modul_activity'];
            return json_encode($data);
        }
    */


    /*
        //Ini Merupakan Standart Reject yang digunakan di erp
        function reject_view() {
            $echo = '<script type="text/javascript">
                         function submit_ajax(form_id) {
                            var remark = $("#setup_modul_activity_remark").val();
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
                                    var url = "'.base_url().'processor/plc/setup_modul_activity";                             
                                    if(o.status == true) { 
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id, function(data) {
                                             $("div#form_setup_modul_activity").html(data);
                                             
                                        });
                                        
                                    }
                                        reload_grid("grid_setup_modul_activity");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Reject</h1><br />';
            $echo .= '<form id="form_setup_modul_activity_reject" action="'.base_url().'processor/plc/setup_modul_activity?action=reject_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= 'Remark : 
                    <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    
                    <textarea name="vRemark" id="reject_setup_modul_activity_remark"></textarea>
            <button type="button" onclick="submit_ajax(\'form_setup_modul_activity_reject\')">Reject</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }


        
        function reject_process() {
            $post = $this->input->post();
            $cNip= $this->user->gNIP;
            $vName= $this->user->gName;
            $iM_modul_activity = $post['iM_modul_activity'];
            $vRemark = $post['vRemark'];
            $lvl = $post['lvl'];

            //Letakan Query Update approve disini

            $data['status']  = true;
            $data['last_id'] = $post['iM_modul_activity'];
            return json_encode($data);
        }
    */


    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated']=$this->user->gNIP;
        $departement = $postData['departement'];
        $vDept_assigned = '';
        foreach ($departement as $d) {
            $vDept_assigned = (strlen($vDept_assigned) > 0)?$vDept_assigned.','.$d:$d;
        }
        $postData['vDept_assigned'] = $vDept_assigned;

        return $postData;

    }
    function before_update_processor($row, $postData) {
        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;
        $departement = $postData['departement'];
        $vDept_assigned = '';
        foreach ($departement as $d) {
            $vDept_assigned = (strlen($vDept_assigned) > 0)?$vDept_assigned.','.$d:$d;
        }
        $postData['vDept_assigned'] = $vDept_assigned;
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
                                    onclick='javascript:create_btn_back_".$this->url."(\"".$this->url."\", \"".base_url()."processor/brosur/setup/modul/activity?iM_modul=".$this->input->get('foreign_key')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>
                                    Save Activity
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
                                onclick='javascript:cancel_btn_".$this->url."(\"".$this->url."\", \"".base_url()."processor/brosur/setup/modul/activity?iM_modul=".$this->input->get('foreign_key')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>
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
                                        onclick='javascript:update_btn_back_".$this->url."(\"".$this->url."\", \"".base_url()."processor/brosur/setup/modul/activity?iM_modul=".$this->input->get('foreign_key')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>
                                        Update Activity
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
                                    onclick='javascript:cancel_btn_".$this->url."(\"".$this->url."\", \"".base_url()."processor/brosur/setup/modul/activity?iM_modul=".$this->input->get('foreign_key')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>
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
