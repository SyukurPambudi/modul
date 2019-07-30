 
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_export_stress_kimiawi extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->db = $this->load->database('hrd',false, true);
        $this->user = $this->auth->user();

        $this->load->library('lib_refor');
        $this->modul_id = $this->input->get('modul_id');
        $this->iModul_id = $this->lib_refor->getIModulID($this->input->get('modul_id'));

        $this->title = 'Uji kimiawi';
        $this->url = 'v3_export_stress_kimiawi';
        $this->urlpath = 'reformulasi/'.str_replace("_","/", $this->url);

        $this->maintable = 'reformulasi.export_refor_formulasi_detail';    
        $this->main_table = $this->maintable;   
        $this->main_table_pk = 'iexport_formulasi_detail';

    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle($this->title);
        $grid->setTable($this->maintable);      
        $grid->setUrl($this->url);

        $grid->setJoinTable('reformulasi.master_bentuk_sediaan_refor', 'export_refor_formulasi_detail.id_bentuk_sediaan_stress = master_bentuk_sediaan_refor.id_bentuk_sediaan', 'left');
        $grid->setJoinTable('reformulasi.master_pengujian_refor', 'export_refor_formulasi_detail.id_pengujian_stress = master_pengujian_refor.id_pengujian', 'left');

        $grid->addList('vno_formula','id_bentuk_sediaan_stress','id_pengujian_stress','dmulai_analisa_stress','dmulai_analisa_stress','dselesai_analisa_stress','cpic_analisa_stress','ikesimpulan_analisa_stress','isubmit_kimiawi_stress','dsubmit_kimiawi_stress'); 
        $grid->setSortBy('iexport_formulasi_detail');
        $grid->setSortOrder('DESC');  

        $grid->addFields('vno_formula','id_bentuk_sediaan_stress','id_pengujian_stress','dmulai_analisa_stress','dselesai_analisa_stress','cpic_analisa_stress','formulasi_uji_kimiawi','ikesimpulan_analisa_stress','dkesimpulan_analisa_stress'); 

        $grid->setWidth('vno_formula', '100');
        $grid->setAlign('vno_formula', 'left');
        $grid->setLabel('vno_formula','No. Formulasi');
    
        $grid->setWidth('dmulai_analisa_stress', '100');
        $grid->setAlign('dmulai_analisa_stress', 'left');
        $grid->setLabel('dmulai_analisa_stress','Tgl Mulai Analisa ');

        $grid->setWidth('dselesai_analisa_stress', '100');
        $grid->setAlign('dselesai_analisa_stress', 'left');
        $grid->setLabel('dselesai_analisa_stress','Tgl Selesai Analisa ');

        $grid->setWidth('cpic_analisa_stress', '100');
        $grid->setAlign('cpic_analisa_stress', 'left');
        $grid->setLabel('cpic_analisa_stress','PIC Analisa ');

        $grid->setWidth('formulasi_uji_fisik', '100');
        $grid->setAlign('formulasi_uji_fisik', 'left');
        $grid->setLabel('formulasi_uji_fisik','File Uji Fisik');

        $grid->setWidth('isubmit_kimiawi_stress', '100');
        $grid->setAlign('isubmit_kimiawi_stress', 'left');
        $grid->setLabel('isubmit_kimiawi_stress','Status');

        $grid->setWidth('dsubmit_kimiawi_stress', '100');
        $grid->setAlign('dsubmit_kimiawi_stress', 'left');
        $grid->setLabel('dsubmit_kimiawi_stress','Tgl Submit');

        $grid->setWidth('master_bentuk_sediaan_refor.vBentuk_sediaan', '100');
        $grid->setAlign('master_bentuk_sediaan_refor.vBentuk_sediaan', 'left');
        $grid->setLabel('master_bentuk_sediaan_refor.vBentuk_sediaan', 'Bentuk Sediaan');
        $grid->setLabel('id_bentuk_sediaan_stress', 'Bentuk Sediaan');

        $grid->setWidth('master_pengujian_refor.vNama_pengujian', '100');
        $grid->setAlign('master_pengujian_refor.vNama_pengujian', 'left');
        $grid->setLabel('master_pengujian_refor.vNama_pengujian', 'Parameter Pengujian');
        $grid->setLabel('id_pengujian_stress', 'Parameter Pengujian');

        $grid->setWidth('ikesimpulan_analisa_stress', '100');
        $grid->setAlign('ikesimpulan_analisa_stress', 'left');
        $grid->setLabel('ikesimpulan_analisa_stress', 'Kesimpulan Analisa');

        $grid->setWidth('dkesimpulan_analisa_stress', '100');
        $grid->setAlign('dkesimpulan_analisa_stress', 'left');
        $grid->setLabel('dkesimpulan_analisa_stress', 'Tanggal Kesimpulan Analisa');
    
        $grid->setQuery('export_refor_formulasi_detail.lDeleted = 0 ', null); 
        $grid->setQuery('export_refor_formulasi_detail.isubmit_fisik_stress = 1 ', null); 

        $this->iexport_formulasi = $this->input->get('iexport_formulasi');            
        $grid->setInputGet('_iexport_formulasi', $this->iexport_formulasi);            
        $grid->setQuery('export_refor_formulasi_detail.iexport_formulasi', intval($this->input->get('_iexport_formulasi')));
        $grid->setForeignKey($this->input->get('iexport_formulasi'));

        $grid->changeFieldType('isubmit_kimiawi_stress','combobox','',array('' => '--Pilih--', 0 => 'Need To Be Submit', 1 => 'Submitted'));
        $grid->changeFieldType('ikesimpulan_analisa_stress','combobox','',array('' => '--Pilih--', 0 => 'TMS', 1 => 'MS'));

        $grid->setSearch('vno_formula','isubmit_kimiawi_stress','ikesimpulan_analisa_stress');
        
        $grid->setRequired('vno_formula','id_bentuk_sediaan_stress','id_pengujian_stress','dmulai_analisa_stress','dselesai_analisa_stress','cpic_analisa_stress','ikesimpulan_analisa_stress','dkesimpulan_analisa_stress'); 
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
                $path       = ( !empty($masterDok) ) ? $masterDok['vPath_upload'] : 'files/reformulasi/export/stress_test/uji_fisik';
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
                $idForm     = $post['id_form_upload'];
                $id_field   = $post['iM_modul_fields'];
                $data_dok   = $this->db->get_where('erp_privi.sys_masterdok', array('iM_modul_fields' => $id_field, 'ldeleted' => 0))->row_array();
                $lastId     = $post[$this->url.'_'.$this->main_table_pk];
                $path       = realpath($data_dok['filepath'].'/');

                $filesUpload= $this->db->get_where('reformulasi.group_file_upload_export', array('iM_modul_fields' => $id_field, 'idHeader_File' => $lastId, 'iDeleted' => 0))->result_array();

                if(!file_exists($path."/".$lastId)){
                    if (!mkdir($path."/".$lastId, 0777, true)) { //id review
                        die('Failed upload, try again!');
                    }
                }

                $fileid             = null;
                $tgl                = date('Y-m-d H:i:s');
                $j                  = 0;

                $arrFileID          = $_POST[$idForm.'_id'];
                $arrFileKet         = $_POST[$idForm.'_keterangan'];

                foreach ($arrFileID as $val_id) {
                    $fileid = ( strlen($fileid) > 0 ) ? $fileid.',"'.$val_id.'"' : '"'.$val_id.'"';
                }

                if($fileid!=''){
                    $sql1 = "UPDATE reformulasi.group_file_upload_export SET iDeleted = 1, dUpdate = ?, cUpdate = ? WHERE iM_modul_fields = ? AND idHeader_File = ? AND iFile NOT IN (".$fileid.") ";
                    $this->db->query($sql1, array($tgl, $this->user->gNIP, $id_field, $lastId));
                }

                foreach ($arrFileID as $val_id) {
                    if ( $val_id != "" ){
                        try{
                            $updateFile['dUpdate']  = $tgl;
                            $updateFile['cUpdate']  = $this->user->gNIP;
                            $this->db->where('iM_modul_fields', $id_field);
                            $this->db->where('idHeader_File', $lastId);
                            $this->db->update('reformulasi.group_file_upload_export', $updateFile);
                        } catch (Exception $ex){
                            die($ex);
                        }
                    }
                }


                if($isUpload) {
                    $filesKey = $idForm.'_file';
                    if (isset($_FILES[$filesKey]))  {
                        $i=0;
                        foreach ($_FILES[$filesKey]["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name       = $_FILES[$filesKey]["tmp_name"][$key];
                                $name           = $_FILES[$filesKey]["name"][$key];
                                $name_generate  = $this->lib_refor->generateFilename($name);

                                if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name_generate)) {
                                    $insert['iM_modul_fields']      = $id_field;
                                    $insert['idHeader_File']        = $lastId;
                                    $insert['vFilename']            = $name;
                                    $insert['vFilename_generate']   = $name_generate;
                                    $insert['tKeterangan']          = $arrFileKet[$i];
                                    $insert['dCreate']              = $tgl;
                                    $insert['cCreate']              = $this->user->gNIP;    
                                    $insert['iDeleted']             = 0;
                                    $this->db->insert('reformulasi.group_file_upload_export', $insert);

                                    $i++;
                                    $j++;

                                } else {
                                    echo "Upload ke folder gagal";
                                }
                            }

                        }

                    }

                    $r['message']   = 'Data Berhasil di Simpan!';
                    $r['status']    = TRUE;
                    $r['last_id']   = $this->input->get('lastId');
                    echo json_encode($r);exit();
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
        $url        = base_url()."processor/reformulasi/v3/export/uji/fisik?action=create&foreign_key=".$this->input->get('iexport_formulasi')."&iexport_formulasi=".$this->input->get('iexport_formulasi')."     &company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id');
        $btn_baru   = "<script type='text/javascript'>
                            function add_btn_".$this->url."(url, title) {
                                browse_with_no_close(url, title);
                            }        
                        </script>";

        $btn_baru   = '<span class="icon-add ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" onclick="add_btn_'.$this->url.'(\''.$url.'\', \'UJI FISIK\')">Tambah Foemulasi</span>';
        
        $cekSubmit  = $this->db->get_where('reformulasi.export_refor_formulasi', array('iexport_formulasi' => $this->input->get('iexport_formulasi')))->row_array();
        $submit     = (!empty($cekSubmit))?$cekSubmit['isubmit_kimiawi_stress']:0;

        // if ( $submit == 1 ){
        //     unset($button['create']);
        // } else {
        //     array_unshift($button, $btn_baru);
        // }

        return $button;
        
    }

    function listBox_v3_export_stress_kimiawi_id_bentuk_sediaan_stress($value, $pk, $name, $rowData) {
        $bentuk = $this->db->get_where('reformulasi.master_bentuk_sediaan_refor', array('id_bentuk_sediaan' => intval($value)))->row_array();
        $return = (!empty($bentuk))?$bentuk['vBentuk_sediaan']:'-';
        return $return;
    }

    function listBox_v3_export_stress_kimiawi_id_pengujian_stress($value, $pk, $name, $rowData) {
        $bentuk = $this->db->get_where('reformulasi.master_pengujian_refor', array('id_pengujian' => intval($value)))->row_array();
        $return = (!empty($bentuk))?$bentuk['vNama_pengujian']:'-';
        return $return;
    }

    function listBox_Action($row, $actions) { 
        unset($actions['edit']);
        $row        = get_object_vars($row);

        $sqlCek     = 'SELECT t.isubmit_kimiawi_stress FROM reformulasi.export_refor_formulasi_detail f
                        JOIN reformulasi.export_refor_formulasi t ON f.iexport_formulasi = t.iexport_formulasi
                        WHERE f.iexport_formulasi_detail = '.$row[$this->main_table_pk];
        $cekSubmit  = $this->db->query($sqlCek)->row_array();
        $submit     = (!empty($cekSubmit))?$cekSubmit['isubmit_kimiawi_stress']:0;
            
        $url        = base_url()."processor/reformulasi/".str_replace('_', '/', $this->url)."?action=update&iexport_formulasi=".$row['iexport_formulasi']."&foreign_key=".$row['iexport_formulasi']."&id=".$row[$this             ->main_table_pk]."&modul_id=".$this->input->get('modul_id');
        $edit       = "<script type'text/javascript'>
                            function edit_btn_".$this->url."(url, title) {
                                browse_with_no_close(url, title);
                            }
                        </script>";
        $edit       .= "<a href='#' onclick='javascript:edit_btn_".$this->url."(\"".$url."\", \"UJI KIMIAWI\");'><center><span class='ui-icon ui-icon-pencil'></span></center></a>";

        $view       = "<script type'text/javascript'>
                            function view_btn_".$this->url."(url, title) {
                                browse_with_no_close(url, title);
                            }
                        </script>";
        $view       .= "<a href='#' onclick='javascript:view_btn_".$this->url."(\"".$url."\", \"UJI KIMIAWI\");'><center><span class='ui-icon ui-icon-lightbulb'></span></center></a>";

        if ($submit == 1){
            unset($actions['delete']);
            unset($actions['edit']);
        } else {
            if ($row['isubmit_kimiawi_stress'] == 0){
                $actions['edit'] = $edit;
            }
        }

        $actions['view'] = $view;
         
        return $actions;
    } 
    
    function updateBox_v3_export_stress_kimiawi_vno_formula($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
             $return= $value; 
        }else{ 
            $return = '<input type="text" readonly name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';
            $return .= '<input type="hidden" name="isdraft" id="isdraft">';
            $return .= '<input type="hidden" value="'.$this->input->get('foreign_key').'" id="'.$this->url.'_iexport_formulasi" name="iexport_formulasi">';

        }
            
        return $return;
    }
    
    function updateBox_v3_export_stress_kimiawi_id_bentuk_sediaan_stress($field, $id, $value, $rowData) {
        $url     = base_url().'processor/reformulasi/'.str_replace('_', '/', $this->url).'?action=loadPengujian';
        $value   = intval($value);
        $sql     = 'SELECT b.id_bentuk_sediaan, b.vBentuk_sediaan, j.jenis_sediaan FROM reformulasi.master_bentuk_sediaan_refor b 
                    JOIN reformulasi.master_jenis_sediaan_refor j ON b.id_sediaan = j.id_sediaan
                    WHERE b.lDeleted = 0 AND b.iStatus = 0 AND j.lDeleted = 0 AND j.`status` = 0 
                    ORDER BY b.vBentuk_sediaan ASC ';
        $bentuk  = $this->db->query($sql)->result_array();

        $disable = ($this->input->get('action') == 'view')?'disabled="true"':'';
        $return  = '<select '.$disable.' name="'.$field.'" id="'.$id.'">';
        $return .= '    <option value="">--Pilih--</option>';
        foreach ($bentuk as $b) {
            $selected= ($b['id_bentuk_sediaan'] == $value)?'selected':'';
            $return .= '<option '.$selected.' value="'.$b['id_bentuk_sediaan'].'">'.$b['vBentuk_sediaan'].' ( '.$b['jenis_sediaan'].' )'.'</option>';
        }
        $return .= '<select>';
        $return .= '<script>
                        var id_bentuk = '.$value.';
                        load_pengujian(id_bentuk);

                        $("#'.$id.'").live("change",function(){
                            var idval = $(this).val();
                            load_pengujian(idval);
                        });

                        function load_pengujian (id_bentuk) { 
                            $.ajax({
                                url: "'.$url.'",
                                type: "post",
                                data : {
                                    value   : '.$rowData['id_pengujian_stress'].',
                                    bentuk  : id_bentuk,
                                    idclass : "'.$this->url.'_id_pengujian_stress",
                                    name    : "id_pengujian_stress",
                                },
                                success: function(data) {
                                    $(".'.$this->url.'_id_pengujian_stress_form_class").html(data);
                                }
                            });
                        }
                    </script>';

        return $return;
    }

    function updateBox_v3_export_stress_kimiawi_id_pengujian_stress($field, $id, $value, $rowData) {
        $return = '<div class="'.$id.'_form_class">Pilih Bentuk Sediaan</div>';  
        return $return;
    }

    function updateBox_v3_export_stress_kimiawi_dmulai_analisa_stress($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
             $return= $value; 
        }else{ 
            $return = '<input type="date" name="'.$field.'"  id="'.$id.'"  class="input_rows1 tanggal  required" size="15" value="'.$value.'"/>';

        }  
        return $return;
    }
    
    function updateBox_v3_export_stress_kimiawi_dselesai_analisa_stress($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
             $return= $value; 
        }else{ 
            $return = '<input type="date" name="'.$field.'"  id="'.$id.'"  class="input_rows1 tanggal  required" size="15" value="'.$value.'"/>';

        }
        return $return;
    }
    
    function updateBox_v3_export_stress_kimiawi_formulasi_uji_kimiawi($field, $id, $value, $rowData) {
        $sql_dok    = "SELECT d.* FROM erp_privi.m_modul m 
                        JOIN erp_privi.m_modul_fields f ON m.iM_modul = f.iM_modul
                        JOIN erp_privi.sys_masterdok d ON f.iM_modul_fields = d.iM_modul_fields
                        WHERE m.lDeleted = 0 AND f.lDeleted = 0 AND d.ldeleted = 0
                            AND m.idprivi_modules = ? AND f.vNama_field = ? ";
        $data_dok   = $this->db->query($sql_dok, array($this->input->get('modul_id'), $field))->row_array();
        $rows       = $this->db->get_where('reformulasi.group_file_upload_export', array('iM_modul_fields' => $data_dok['iM_modul_fields'], 'iDeleted' => 0, 'idHeader_File' => $rowData[$this->main_table_pk]))->result_array();

        $data['controller'] = $this->url;
        $data['rows']       = $rows;
        $data['field']      = $field;
        $data['id']         = $id;
        $data['dokumen']    = $data_dok;
        $return  = $this->load->view('partial/modul/export_skala_trial_file', $data, true);
        $return .= '<script>
                        $("label[for=\''.$id.'\']").next().removeClass("rows_input");
                        $("label[for=\''.$id.'\']").remove();
                    </script>';
        return $return;
    }
    
    function updateBox_v3_export_stress_kimiawi_cpic_analisa_stress($field, $id, $value, $rowData) {
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

    function updateBox_v3_export_stress_kimiawi_dkesimpulan_analisa_stress($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
             $return= $value; 
        }else{ 
            $return = '<input type="date" name="'.$field.'"  id="'.$id.'"  class="input_rows1 tanggal required" size="15" value="'.$value.'"/>';

        }  
        return $return;
    }
                        


    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated']=$this->user->gNIP;


        if($postData['isdraft']==true){
            $postData['isubmit_kimiawi_stress'] = 0;
        } else{
            $postData['isubmit_kimiawi_stress'] = 1;
            $postData['dsubmit_kimiawi_stress'] = date('Y-m-d H:i:s');
            $postData['csubmit_kimiawi_stress'] = $this->user->gNIP;
        } 
        return $postData;

    }
    function before_update_processor($row, $postData) {
        unset($postData['iexport_formulasi']);
        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;

        if($postData['isdraft']==true){
            $postData['isubmit_kimiawi_stress'] = 0;
        } else{
            $postData['isubmit_kimiawi_stress'] = 1;
            $postData['dsubmit_kimiawi_stress'] = date('Y-m-d H:i:s');
            $postData['csubmit_kimiawi_stress'] = $this->user->gNIP;
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
                        onclick="javascript:save_btn_'.$this->url.'(\''.$this->url.'\', \' '.base_url().'processor/reformulasi/'.str_replace('_', '/', $this->url).'?draft=true&iexport_formulasi='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true )">Save as Draft</button>';

        $save = '<button type="button"
                        name="button_create_'.$this->url.'"
                        id="button_create_'.$this->url.'"
                        class="icon-save ui-button" 
                        onclick="javascript:save_btn_'.$this->url.'(\''.$this->url.'\', \' '.base_url().'processor/reformulasi/'.str_replace('_', '/', $this->url).'?draft=false&iexport_formulasi='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, false )">Save & Send</button>';

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
                                onclick='javascript:cancel_btn_".$this->url."(\"".$this->url."\", \"".base_url()."processor/reformulasi/".str_replace('_', '/', $this->url)."?iexport_formulasi=".$this->input->get('foreign_key')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>
                                Close 
                            </button>";
        
        return $buttons;
    }

    function manipulate_update_button($buttons, $rowData) { 
        unset($buttons['update']);
        unset($buttons['update_back']);
        unset($buttons['cancel']);

        $sqlCek     = 'SELECT t.isubmit_kimiawi_stress FROM reformulasi.export_refor_formulasi_detail f
                        JOIN reformulasi.export_refor_formulasi t ON f.iexport_formulasi = t.iexport_formulasi
                        WHERE f.iexport_formulasi_detail = '.$rowData[$this->main_table_pk];
        $cekSubmit  = $this->db->query($sqlCek)->row_array();
        $submit     = (!empty($cekSubmit))?$cekSubmit['isubmit_kimiawi_stress']:0;

        $data['url'] = $this->url;
        $js = $this->load->view('js/custom_js', $data, TRUE);

        $update_draft = '<button type="button"
                                name="button_update_draft_'.$this->url.'"
                                id="button_update_draft_'.$this->url.'"
                                class="ui-button-text icon-save"
                                onclick="javascript:update_btn_'.$this->url.'(\''.$this->url.'\', \' '.base_url().'processor/reformulasi/'.str_replace('_', '/', $this->url).'?draft=true&iexport_formulasi='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)">Update As Draft</button>';

        $update = '<button type="button"
                        name="button_update_draft_'.$this->url.'"
                        id="button_update_draft_'.$this->url.'"
                        class="ui-button-text icon-save"
                        onclick="javascript:update_btn_'.$this->url.'(\''.$this->url.'\', \' '.base_url().'processor/reformulasi/'.str_replace('_', '/', $this->url).'?draft=false&iexport_formulasi='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, false)">Update & Send</button>';

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
                                    onclick='javascript:cancel_btn_".$this->url."(\"".$this->url."\", \"".base_url()."processor/reformulasi/".str_replace('_', '/', $this->url)."?iexport_formulasi=".$this->input->get('foreign_key')."&company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>
                                    Close 
                                </button>";

            
        if ($this->input->get('action') == 'view' || $rowData['isubmit_kimiawi_stress'] == 1 || $submit == 1){
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
