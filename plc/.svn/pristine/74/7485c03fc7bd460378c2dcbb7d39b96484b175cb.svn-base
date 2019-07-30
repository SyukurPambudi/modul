 <?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class plc3_master_dokumen extends MX_Controller {
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
        $grid->setTitle('Master Dokumen'    );
        $grid->setTable('plc2.sys_masterdok');      
        $grid->setUrl('plc3_master_dokumen');

        //List Table
        $grid->addList('filename','m_modul_fileds.vNama_field','modulename','labelform'); 
        $grid->setSortBy('idmasterdok');
        $grid->setSortOrder('DESC');  

        //List field
        $grid->addFields('filename','iM_modul_fileds','modulename','labelform','captiondone','filepath','fieldgrid','fieldinsert','filetable','fieldheader','fielddetail','fdupdate','fcupdate','ffilename','fvketerangan','fdcreate','fccreate','fldeleted','note'); 

        $grid->setJoinTable('plc3.m_modul_fileds', 'sys_masterdok.iM_modul_fileds = m_modul_fileds.iM_modul_fileds', 'inner');

        $grid->setWidth('filename', '100');
        $grid->setAlign('filename', 'left');
        $grid->setLabel('filename','Label file ');
    
        $grid->setWidth('iM_modul_fileds', '100');
        $grid->setAlign('iM_modul_fileds', 'left');
        $grid->setLabel('iM_modul_fileds','Nama Field Modul');

        $grid->setLabel('m_modul_fileds.vNama_field', 'Nama Field Modul');
    
        $grid->setWidth('modulename', '100');
        $grid->setAlign('modulename', 'left');
        $grid->setLabel('modulename','Nama Modul ');
    
        $grid->setWidth('labelform', '100');
        $grid->setAlign('labelform', 'left');
        $grid->setLabel('labelform','Form label ');
    
        $grid->setWidth('captiondone', '100');
        $grid->setAlign('captiondone', 'left');
        $grid->setLabel('captiondone','Caption Done ');
    
        $grid->setWidth('filetable', '100');
        $grid->setAlign('filetable', 'left');
        $grid->setLabel('filetable','Nama Table ');
    
        $grid->setWidth('fieldheader', '100');
        $grid->setAlign('fieldheader', 'left');
        $grid->setLabel('fieldheader','ID Field header ');
    
        $grid->setWidth('fielddetail', '100');
        $grid->setAlign('fielddetail', 'left');
        $grid->setLabel('fielddetail','ID Field Detail ');
    
        $grid->setWidth('filepath', '100');
        $grid->setAlign('filepath', 'left');
        $grid->setLabel('filepath','File Path ');
    
        $grid->setWidth('fieldgrid', '100');
        $grid->setAlign('fieldgrid', 'left');
        $grid->setLabel('fieldgrid','Field Grid ');
    
        $grid->setWidth('fieldinsert', '100');
        $grid->setAlign('fieldinsert', 'left');
        $grid->setLabel('fieldinsert','Field Insert ');
    
        $grid->setWidth('fdupdate', '100');
        $grid->setAlign('fdupdate', 'left');
        $grid->setLabel('fdupdate','Field Update Date');
    
        $grid->setWidth('fcupdate', '100');
        $grid->setAlign('fcupdate', 'left');
        $grid->setLabel('fcupdate','Field Update User ');
    
        $grid->setWidth('ffilename', '100');
        $grid->setAlign('ffilename', 'left');
        $grid->setLabel('ffilename','Field File Name ');
    
        $grid->setWidth('fvketerangan', '100');
        $grid->setAlign('fvketerangan', 'left');
        $grid->setLabel('fvketerangan','Field Keterangan ');
    
        $grid->setWidth('fdcreate', '100');
        $grid->setAlign('fdcreate', 'left');
        $grid->setLabel('fdcreate','Field Create Date ');
    
        $grid->setWidth('fccreate', '100');
        $grid->setAlign('fccreate', 'left');
        $grid->setLabel('fccreate','Field Create User ');
    
        $grid->setWidth('fldeleted', '100');
        $grid->setAlign('fldeleted', 'left');
        $grid->setLabel('fldeleted','Field Deleted ');
    
        $grid->setWidth('note', '100');
        $grid->setAlign('note', 'left');
        $grid->setLabel('note','Note ');
    
//Example modifikasi GRID ERP
    //- Set Query
        
        $grid->setQuery('sys_masterdok.ldeleted = 0 ', null); 
        $grid->setQuery('m_modul_fileds.lDeleted = 0 ', null); 

        

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
        $grid->setSearch('filename','modulename','labelform','m_modul_fileds.vNama_field');
        
    //set required
        $grid->setRequired('filename','iM_modul_fileds','modulename','labelform','captiondone'); 
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
                $post = $this->input->post();
                $label = $post['filename'];
                $sql = 'SELECT idmasterdok FROM plc2.sys_masterdok WHERE filename = ? ';
                $cek = $this->db->query($sql, array($label))->num_rows();
                if ($cek > 0){
                    $r['message']='Label File Telah Digunakan Di Modul Lain';
                    $r['status'] = false;                 
                    echo json_encode($r);
                }else{
                    echo $grid->saved_form();
                }
                break;
                  
           
            
            case 'update':
                    $grid->render_form($this->input->get('id'));
                    break;

        
            case 'updateproses':
                $post = $this->input->post();
                $label = $post['filename'];
                $id = $post['plc3_master_dokumen_idmasterdok'];
                $sql = 'SELECT idmasterdok FROM plc2.sys_masterdok WHERE filename = ? AND idmasterdok <> ? ';
                $cek = $this->db->query($sql, array($label,$id))->num_rows();
                if ($cek > 0){
                    $r['message']='Label File Telah Digunakan Di Modul Lain';
                    $r['status'] = false;                 
                    echo json_encode($r);
                }else{
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
                case 'load_field':
                    $this->load_field();
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

    function load_field(){
        $post = $this->input->post();
        $table = $post['table'];
        $grid = 'plc3_master_dokumen_';
        $splitted = explode('.', $table);
        $action = $post['action'];
        $rowData = $post['row']; 

        $field = array('fieldheader','fielddetail','fdupdate','fcupdate','ffilename','fvketerangan','fdcreate','fccreate','fldeleted');
        $arrSelect = array();
        $sql = 'SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = ? AND TABLE_SCHEMA = ?';
        $arrField = $this->db->query($sql, array($splitted[1], $splitted[0]))->result_array();

        foreach ($field as $v) {
            $disabled = ($action == 'view')?'disabled':'';
            $value = (isset($rowData[$v]))?$rowData[$v]:''; 
            $select = '<select '.$disabled.' class="input_rows1 choose field_'.$v.'" name="'.$v.'"  id="'.$grid.$v.'">';  
            $select .= '<option value=""> -- Pilih -- </option>';
            foreach ($arrField as $f) {
                $selected = ($value == $f['COLUMN_NAME'])?'selected':'';
                $select .= '<option '.$selected.' value="'.$f['COLUMN_NAME'].'">'.$f['COLUMN_NAME'].'</option>';
            }
            $select .= '</select>';

            $item['class'] = '.field_'.$v;
            $item['option'] = $select;
            array_push($arrSelect, $item);
        }
        echo json_encode($arrSelect);exit();
    }

                        function insertBox_plc3_master_dokumen_filename($field, $id) {
                            $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_filename($field, $id, $value, $rowData) {
                                if ($this->input->get('action') == 'view') {
                                     $return= $value; 
                                }else{ 
                                    $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

                                }
                                
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_iM_modul_fileds($field, $id) {
                            
                            $sql = 'SELECT f.iM_modul_fileds, CONCAT(m.vNama_modul," - ",f.vNama_field) AS vNama_field, m.vNama_modul
                                        FROM plc3.m_modul_fileds f JOIN plc3.m_modul m ON f.iM_modul = m.iM_modul 
                                        WHERE f.lDeleted = 0 AND m.lDeleted = 0 AND f.iM_jenis_field IN (7,16,8)
                                            AND f.iM_jenis_field NOT IN (SELECT iM_modul_fileds FROM plc2.sys_masterdok WHERE lDeleted = 0 AND iM_modul_fileds <> 0)
                                        ORDER BY m.vNama_modul ASC';
                            $pilihan = $this->db->query($sql)->result_array();

                            $return = '<select class="input_rows1 required choose" name="'.$field.'"  id="'.$id.'">';            
                            foreach($pilihan as $me) {
                                $return .= '<option value='.$me['iM_modul_fileds'].'>'.$me['vNama_field'].'</option>';
                            }            
                            $return .= '</select>';
                            $return .= '<script>
                                            var value = $("#plc3_master_dokumen_iM_modul_fileds option:selected").text();
                                            var modul = value.substr(0, value.indexOf(" - "));
                                            $("#plc3_master_dokumen_modulename").val(modul);
                                            $("#plc3_master_dokumen_iM_modul_fileds").change(function(){
                                                var value = $("#plc3_master_dokumen_iM_modul_fileds option:selected").text();
                                                var modul = value.substr(0, value.indexOf(" - "));
                                                $("#plc3_master_dokumen_modulename").val(modul);
                                            })
                                        </script>';

                        
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_iM_modul_fileds($field, $id, $value, $rowData) {
                            $sql = 'SELECT f.iM_modul_fileds, CONCAT(m.vNama_modul," - ",f.vNama_field) AS vNama_field, m.vNama_modul
                                        FROM plc3.m_modul_fileds f JOIN plc3.m_modul m ON f.iM_modul = m.iM_modul 
                                        WHERE f.lDeleted = 0 AND m.lDeleted = 0 AND f.iM_jenis_field IN (7,16,8)
                                            AND f.iM_jenis_field NOT IN (SELECT iM_modul_fileds FROM plc2.sys_masterdok WHERE lDeleted = 0 AND iM_jenis_field <> ? AND iM_modul_fileds <> 0)  
                                        ORDER BY m.vNama_modul ASC';
                            $pilihan = $this->db->query($sql, array($value))->result_array();

                            $disabled = ($this->input->get('action') == 'view')?'disabled':'';
                            $return = '<select '.$disabled.' class="input_rows1 required" name="'.$field.'"  id="'.$id.'">';            
                            foreach($pilihan as $me) {
                                $selected = ($me['iM_modul_fileds'] == $value)?'selected':'';
                                $return .= '<option '.$selected.' value='.$me['iM_modul_fileds'].'>'.$me['vNama_field'].'</option>';
                            }            
                            $return .= '</select>';
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_modulename($field, $id) {
                            $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_modulename($field, $id, $value, $rowData) {
                                if ($this->input->get('action') == 'view') {
                                     $return= $value; 
                                }else{ 
                                    $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

                                }
                                
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_labelform($field, $id) {
                            $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_labelform($field, $id, $value, $rowData) {
                                if ($this->input->get('action') == 'view') {
                                     $return= $value; 
                                }else{ 
                                    $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

                                }
                                
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_captiondone($field, $id) {
                            $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_captiondone($field, $id, $value, $rowData) {
                                if ($this->input->get('action') == 'view') {
                                     $return= $value; 
                                }else{ 
                                    $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

                                }
                                
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_filetable($field, $id) {    

                            $sql = 'SELECT CONCAT(TABLE_SCHEMA,".",TABLE_NAME) AS TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA LIKE "%plc%" ORDER BY TABLE_NAME ASC';
                            $pilihan = $this->db->query($sql)->result_array();

                            $return = '<select class="input_rows1 required" name="'.$field.'"  id="'.$id.'">';            
                            foreach($pilihan as $me) {
                                $return .= '<option value='.$me['TABLE_NAME'].'>'.$me['TABLE_NAME'].'</option>';
                            }            
                            $return .= '</select>';
                            $return .= '<script>
                                            $.ajax({
                                                url: base_url+"processor/plc/plc3/master/dokumen?action=load_field",
                                                type: "post",
                                                data : {
                                                    table: "'.$pilihan[0]['TABLE_NAME'].'",
                                                    row: "",
                                                    action: "'.$this->input->get('action').'"
                                                },
                                                success: function(data) {
                                                    var dt = $.parseJSON(data);
                                                    for (var i = 0; i < dt.length; i++){
                                                        var f = dt[i];
                                                        $(f.class).html(f.option);
                                                    }
                                                }
                                            });

                                            $("#plc3_master_dokumen_filetable").change(function(){
                                                $.ajax({
                                                    url: base_url+"processor/plc/plc3/master/dokumen?action=load_field",
                                                    type: "post",
                                                    data : {
                                                        table: $(this).val(),
                                                        row: "",
                                                        action: "'.$this->input->get('action').'"
                                                    },
                                                    success: function(data) {
                                                        var dt = $.parseJSON(data);
                                                        for (var i = 0; i < dt.length; i++){
                                                            var f = dt[i];
                                                            $(f.class).html(f.option);
                                                        }
                                                    }
                                                });
                                            })
                                        </script>';
                        
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_filetable($field, $id, $value, $rowData) {    

                            $sql = 'SELECT CONCAT(TABLE_SCHEMA,".",TABLE_NAME) AS TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA LIKE "%plc%" ORDER BY TABLE_NAME ASC';
                            $pilihan = $this->db->query($sql)->result_array();

                            $return = '<select class="input_rows1 required" name="'.$field.'"  id="'.$id.'">';            
                            foreach($pilihan as $me) {
                                $selected = ($value == $me['TABLE_NAME'])?'selected':'';
                                $return .= '<option '.$selected.' value='.$me['TABLE_NAME'].'>'.$me['TABLE_NAME'].'</option>';
                            }            
                            $return .= '</select>';
                            $return .= '<script>
                                            $.ajax({
                                                url: base_url+"processor/plc/plc3/master/dokumen?action=load_field",
                                                type: "post",
                                                data : {
                                                    table: $("#plc3_master_dokumen_filetable").val(),
                                                    row: '.json_encode($rowData).',
                                                    action: "'.$this->input->get('action').'"
                                                },
                                                success: function(data) {
                                                    var dt = $.parseJSON(data);
                                                    for (var i = 0; i < dt.length; i++){
                                                        var f = dt[i];
                                                        $(f.class).html(f.option);
                                                    }
                                                }
                                            });

                                            $("#plc3_master_dokumen_filetable").change(function(){
                                                $.ajax({
                                                    url: base_url+"processor/plc/plc3/master/dokumen?action=load_field",
                                                    type: "post",
                                                    data : {
                                                        table: $(this).val(),
                                                        row: '.json_encode($rowData).',
                                                        action: "'.$this->input->get('action').'"
                                                    },
                                                    success: function(data) {
                                                        var dt = $.parseJSON(data);
                                                        for (var i = 0; i < dt.length; i++){
                                                            var f = dt[i];
                                                            $(f.class).html(f.option);
                                                        }
                                                    }
                                                });
                                            })
                                        </script>';
                        
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_fieldheader($field, $id) {          
                            $return = '<div class="field_'.$field.'"></div>';                        
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_fieldheader($field, $id, $value, $rowData) {        
                            $return = '<div class="field_'.$field.'"></div>';                        
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_fielddetail($field, $id) {
                            $return = '<div class="field_'.$field.'"></div>';  
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_fielddetail($field, $id, $value, $rowData) {        
                            $return = '<div class="field_'.$field.'"></div>';                        
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_filepath($field, $id) {
                            $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_filepath($field, $id, $value, $rowData) {
                                if ($this->input->get('action') == 'view') {
                                     $return= $value; 
                                }else{ 
                                    $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

                                }
                                
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_fieldgrid($field, $id) {
                            $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="100"  />';
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_fieldgrid($field, $id, $value, $rowData) {
                                if ($this->input->get('action') == 'view') {
                                     $return= $value; 
                                }else{ 
                                    $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="100" value="'.$value.'"/>';

                                }
                                
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_fieldinsert($field, $id) {
                            $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="100"  />';
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_fieldinsert($field, $id, $value, $rowData) { 
                                if ($this->input->get('action') == 'view') {
                                     $return= $value; 
                                }else{ 
                                    $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="100" value="'.$value.'"/>';

                                }
                                
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_fdupdate($field, $id) {
                            $return = '<div class="field_'.$field.'"></div>';  
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_fdupdate($field, $id, $value, $rowData) {        
                            $return = '<div class="field_'.$field.'"></div>';                        
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_fcupdate($field, $id) {
                            $return = '<div class="field_'.$field.'"></div>';  
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_fcupdate($field, $id, $value, $rowData) {        
                            $return = '<div class="field_'.$field.'"></div>';                        
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_ffilename($field, $id) {
                            $return = '<div class="field_'.$field.'"></div>';  
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_ffilename($field, $id, $value, $rowData) {        
                            $return = '<div class="field_'.$field.'"></div>';                        
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_fvketerangan($field, $id) {
                            $return = '<div class="field_'.$field.'"></div>';  
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_fvketerangan($field, $id, $value, $rowData) {        
                            $return = '<div class="field_'.$field.'"></div>';                        
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_fdcreate($field, $id) {
                            $return = '<div class="field_'.$field.'"></div>';  
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_fdcreate($field, $id, $value, $rowData) {        
                            $return = '<div class="field_'.$field.'"></div>';                        
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_fccreate($field, $id) {
                            $return = '<div class="field_'.$field.'"></div>';  
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_fccreate($field, $id, $value, $rowData) {        
                            $return = '<div class="field_'.$field.'"></div>';                        
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_fldeleted($field, $id) {
                            $return = '<div class="field_'.$field.'"></div>';  
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_fldeleted($field, $id, $value, $rowData) {        
                            $return = '<div class="field_'.$field.'"></div>';                        
                            return $return;
                        }
                        
                        function insertBox_plc3_master_dokumen_note($field, $id) {
                            $return = '<textarea name="'.$field.'" id="'.$id.'" class="" style="width: 240px; height: 75px;" size="250" maxlength ="250"></textarea>';
                            return $return;
                        }
                        
                        function updateBox_plc3_master_dokumen_note($field, $id, $value, $rowData) {
                                if ($this->input->get('action') == 'view') {
                                     $return= '<label title="Note">'.nl2br($value).'</label>'; 
                                }else{ 
                                    $return = '<textarea name="'.$field.'" id="'.$id.'" class="" style="width: 240px; height: 75px;" size="250" maxlength ="250">'.nl2br($value).'</textarea>';

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
                                    var url = "'.base_url().'processor/plc/plc3_master_dokumen";                             
                                    if(o.status == true) { 
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id, function(data) {
                                             $("div#form_plc3_master_dokumen").html(data);
                                             
                                        });
                                        
                                    }
                                        reload_grid("grid_plc3_master_dokumen");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Approve</h1><br />';
            $echo .= '<form id="form_plc3_master_dokumen_approve" action="'.base_url().'processor/plc/plc3_master_dokumen?action=approve_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= 'Remark : 
                    <input type="hidden" name="idmasterdok" value="'.$this->input->get('idmasterdok').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    
                    <textarea name="vRemark"></textarea>
            <button type="button" onclick="submit_ajax(\'form_plc3_master_dokumen_approve\')">Approve</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        } 

        function approve_process() {
            $post = $this->input->post();
            $cNip= $this->user->gNIP;
            $vName= $this->user->gName;
            $idmasterdok = $post['idmasterdok'];
            $vRemark = $post['vRemark'];
            $lvl = $post['lvl'];

            //Letakan Query Update approve disini

            $data['status']  = true;
            $data['last_id'] = $post['idmasterdok'];
            return json_encode($data);
        }
    */


    /*
        //Ini Merupakan Standart Reject yang digunakan di erp
        function reject_view() {
            $echo = '<script type="text/javascript">
                         function submit_ajax(form_id) {
                            var remark = $("#plc3_master_dokumen_remark").val();
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
                                    var url = "'.base_url().'processor/plc/plc3_master_dokumen";                             
                                    if(o.status == true) { 
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id, function(data) {
                                             $("div#form_plc3_master_dokumen").html(data);
                                             
                                        });
                                        
                                    }
                                        reload_grid("grid_plc3_master_dokumen");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Reject</h1><br />';
            $echo .= '<form id="form_plc3_master_dokumen_reject" action="'.base_url().'processor/plc/plc3_master_dokumen?action=reject_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= 'Remark : 
                    <input type="hidden" name="idmasterdok" value="'.$this->input->get('idmasterdok').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    
                    <textarea name="vRemark" id="reject_plc3_master_dokumen_remark"></textarea>
            <button type="button" onclick="submit_ajax(\'form_plc3_master_dokumen_reject\')">Reject</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }


        
        function reject_process() {
            $post = $this->input->post();
            $cNip= $this->user->gNIP;
            $vName= $this->user->gName;
            $idmasterdok = $post['idmasterdok'];
            $vRemark = $post['vRemark'];
            $lvl = $post['lvl'];

            //Letakan Query Update approve disini

            $data['status']  = true;
            $data['last_id'] = $post['idmasterdok'];
            return json_encode($data);
        }
    */


    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated']=$this->user->gNIP;
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

    //     $iframe = '<iframe name="plc3_master_dokumen_frame" id="plc3_master_dokumen_frame" height="0" width="0"></iframe>';
        
    //     $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'plc3_master_dokumen\', \' '.base_url().'processor/folder_app/plc3_master_dokumen?draft=true \',this,true )"  id="button_save_draft_plc3_master_dokumen"  class="ui-button-text icon-save" >Save as Draft</button>';
    //     $save = '<button onclick="javascript:save_btn_multiupload(\'plc3_master_dokumen\', \' '.base_url().'processor/folder_app/plc3_master_dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_save_submit_plc3_master_dokumen"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

        

    //     $buttons['save'] = $iframe.$save_draft.$save.$js;
        
    //     return $buttons;
    // }

    // function manipulate_update_button($buttons, $rowData) { 
    //     $peka=$rowData['idmasterdok'];


    //     //Load Javascript In Here 
    //     $cNip= $this->user->gNIP;
    //     $js = $this->load->view('js/standard_js');
    //     $js .= $this->load->view('js/upload_js');

    //     $iframe = '<iframe name="plc3_master_dokumen_frame" id="plc3_master_dokumen_frame" height="0" width="0"></iframe>';
        
    //     $update_draft = '<button onclick="javascript:update_draft_btn(\'plc3_master_dokumen\', \' '.base_url().'processor/folder_app/plc3_master_dokumen?draft=true \',this,true )"  id="button_update_draft_plc3_master_dokumen"  class="ui-button-text icon-save" >Update as Draft</button>';
    //     $update = '<button onclick="javascript:update_btn_back(\'plc3_master_dokumen\', \' '.base_url().'processor/folder_app/plc3_master_dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_plc3_master_dokumen"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

    //     $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/folder_app/plc3_master_dokumen?action=approve&idmasterdok='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_plc3_master_dokumen"  class="ui-button-text icon-save" >Approve</button>';
    //     $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/folder_app/plc3_master_dokumen?action=reject&idmasterdok='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_plc3_master_dokumen"  class="ui-button-text icon-save" >Reject</button>';
        



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
