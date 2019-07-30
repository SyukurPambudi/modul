<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_spesifikasi_soi_bb extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('auth');
        $this->load->library('lib_plc');
        $this->db = $this->load->database('hrd',false, true);
        $this->user = $this->auth->user();
        $this->modul_id = $this->input->get('modul_id');

        $this->iModul_id = $this->lib_plc->getIModulID($this->input->get('modul_id'));

        $this->main_table='plc2_upb_soi_bahanbaku';
        $this->main_table_pk='isoibb_id';

        $this->team = $this->lib_plc->hasTeam($this->user->gNIP);
        $this->teamID = $this->lib_plc->hasTeamID($this->user->gNIP);

        $isAdmin=$this->lib_plc->isAdmin($this->user->gNIP);
        $this->isAdmin = $isAdmin;

        $this->load->library('auth_localnon');
        $this->_table = 'plc2.plc2_upb_soi_bahanbaku';

        $this->path = 'files/plc/soi_bahanbaku';
        $this->tempat = 'soi_bahanbaku';
        $this->folderApp = 'plc';

        $this->url = 'v3_spesifikasi_soi_bb';
        $this->urlpath = 'plc/'.str_replace("_","/", $this->url);

    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle('Spesifikasi SOI Bahan Baku');       
        $grid->setTable($this->_table);     
        $grid->setUrl($this->url);
        $grid->addList('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','vkode_surat','ineed_revisi','irevisi', 'iappqc', 'iappqa');
        $grid->setSortBy('isoibb_id');
        $grid->setSortOrder('DESC');
        $grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','vkode_surat','irevisi','iappqc','iappqa');


        $grid->setQuery('plc2.plc2_upb_soi_bahanbaku.ldeleted', 0);
        $grid->setAlign('plc2_upb.vupb_nomor', 'center');
        $grid->setAlign('irevisi', 'center');
        $grid->setAlign('itype', 'center');
        $grid->setAlign('ineed_revisi', 'center');
        $grid->setWidth('plc2_upb.vupb_nomor', '100');
        $grid->setWidth('plc2_upb.iteampd_id', '150');
        $grid->setWidth('plc2_upb.vupb_nama', '250');
        $grid->setWidth('plc2_upb.vgenerik', '250');
        $grid->setWidth('irevisi', '75');
        $grid->setWidth('itype', '75');
        $grid->setWidth('ineed_revisi', '75');
        $grid->setFormWidth('irevisi',5);
        $grid->setFormWidth('vupb_nama',40);
        $grid->setFormWidth('vgenerik',40);
        $grid->setFormWidth('iteampd_id',25);
        $grid->setFormWidth('vkode_surat',20);

        $grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
        $grid->setLabel('vupb_nomor', 'No. UPB');
        $grid->setLabel('iupb_id', 'No. UPB');
        $grid->setLabel('plc2_upb.iupb_id', 'No. UPB');
        $grid->setLabel('vupb_nama', 'Nama Usulan');
        $grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
        $grid->setLabel('vgenerik', 'Nama Generik');
        $grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
        $grid->setLabel('iteampd_id', 'Team PD');
        $grid->setLabel('plc2_upb.iteampd_id', 'Team PD');
        $grid->setLabel('vkode_surat', 'No. SOI');
        $grid->setLabel('tberlaku', 'Tanggal Berlaku');
        $grid->setLabel('filename', 'Nama File');       
        $grid->setLabel('irevisi', 'Revisi');
        $grid->setLabel('itype', 'Status');
        $grid->setLabel('vnip_formulator', 'Penyusun');
        $grid->setLabel('iappqc', 'QC Approval');
        $grid->setLabel('iappqa', 'QA Approval');
        $grid->setLabel('vnip_qc', 'PD Approval');
        $grid->setLabel('vnip_qa', 'QA Approval');
        $grid->setLabel('ineed_revisi', 'Butuh Revisi');

        $grid->setJoinTable('plc2.plc2_upb', 'plc2_upb_soi_bahanbaku.iupb_id = plc2.plc2_upb.iupb_id', 'INNER');
        $grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));

        $this->lib_plc->gridFilterUPBbyTeam($grid, $this->modul_id);

        $grid->changeFieldType('ineed_revisi','combobox','',array('0'=>'Tidak','1'=>'Ya'));

        $grid->setQuery('plc2_upb.ihold', 0);
        $grid->setQuery('plc2_upb.itipe_id <> 6',null); 

        $grid->setGridView('grid');
        $grid->addFields('form_detail'); 


        switch ($action) {
            case 'json':
                    $grid->getJsonData();
                    break;
            case 'getFormDetail':
                    $post=$this->input->post();
                    $get=$this->input->get();
                    $data['html']="";

                    $sqlFields = 'SELECT * FROM plc3.m_modul_fileds a WHERE a.lDeleted = 0 AND  a.iM_modul= ? ORDER BY a.iSort ASC';
                    $dFields = $this->db->query($sqlFields, array($this->iModul_id))->result_array(); 

                    $hate_emel = "";

                    if($get['formaction']=='update'){
                            $aidi = $get['id'];
                    }else{
                            $aidi = 0;
                    }

                    $hate_emel .= '
                        <table class="hover_table" style="width: 99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
                            <thead>
                                <tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
                                    <th style="border: 1px solid #dddddd; width: 10%;">Activity Name</th>
                                    <th style="border: 1px solid #dddddd;">Status</th>
                                    <th style="border: 1px solid #dddddd;">at</th>      
                                    <th style="border: 1px solid #dddddd; width: 30%;">By</th>      
                                    <th style="border: 1px solid #dddddd; width: 40%;">Remark</th>      
                                </tr>
                            </thead>
                            <tbody>';

                            $sqlLog = 'SELECT b.vNama_activity, a.dCreate, c.vName, a.vRemark, IF(a.iApprove=2,"Approve",if(a.iApprove=1,"Reject","-")) AS setatus
                                        FROM plc3.m_modul_log_activity a 
                                        JOIN plc3.m_activity b ON b.iM_activity = a.iM_activity
                                        JOIN hrd.employee c ON c.cNip = a.cCreated
                                        WHERE a.idprivi_modules = ?
                                            and a.iKey_id = ? ';
                            $dataLog = $this->db->query($sqlLog, array($this->modul_id, $aidi))->result_array();
                            if (count($dataLog) > 0) {
                                $i=0;
                                foreach ($dataLog as $dtl ) {
                                    $hate_emel .='
                                        <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
                                            <td style="border: 1px solid #dddddd; text-align: center;">
                                                <span class="">'.$dtl['vNama_activity'].'</span>
                                            </td>
                                            <td style="border: 1px solid #dddddd; text-align: center;">
                                                <span class="">'.$dtl['setatus'].'</span>
                                            </td>
                                            <td style="border: 1px solid #dddddd; text-align: center;">
                                                <span class="">'.$dtl['dCreate'].'</span>
                                            </td>
                                            <td style="border: 1px solid #dddddd; text-align: center;">
                                                <span class="">'.$dtl['vName'].'</span>
                                            </td>
                                            <td style="border: 1px solid #dddddd; text-align: center;">
                                                <span class="">'.$dtl['vRemark'].'</span>
                                            </td>
                                        </tr>';
                                    $i++;
                                }
                            }else{
                                $hate_emel .='
                                        <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
                                            <td colspan="5" style="border: 1px solid #dddddd; text-align: center;">
                                                <span class="">Tidak Ada Data</span>
                                            </td>
                                        </tr>';


                            }

                    $hate_emel .='
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <hr>
                    '; 


                    if(!empty($dFields)){

                        foreach ($dFields as $form_field) {
                            
                            $data_field['iM_jenis_field']= $form_field['iM_jenis_field'] ;
                            $data_field['form_field']= $form_field;
                            $data_field['get']= $get;

                            $controller = $this->url;
                            $data_field['id']= $controller.'_'.$form_field['vNama_field'];
                            //$data_field['field']= $controller.'_'.$form_field['vNama_field'] ;
                            $data_field['field']= $form_field['vNama_field'] ;

                            $data_field['act']= $get['act'] ;
                            $data_field['hasTeam']= $this->team ;
                            $data_field['hasTeamID']= $this->teamID ;
                            $data_field['isAdmin']= $this->isAdmin ;

                            /*untuk keperluad file upload*/
                            if($form_field['iM_jenis_field'] == 7){
                                $data_field['tabel_file'] = $form_field['vTabel_file'] ;
                                $data_field['tabel_file_pk']= $this->main_table_pk;
                                $data_field['tabel_file_pk_id']= $form_field['vTabel_file_pk_id'] ;

                                $createname_space = $this->url;

                                $data_field['path'] = $this->path;
                                $data_field['FOLDER_APP'] = $this->folderApp;
                                $data_field['createname_space'] = $createname_space;
                                $data_field['tempat'] = $this->tempat;
                            }
                            /*untuk keperluad file upload*/
                            if($get['formaction']=='update'){
                                $id = $get['id'];

                                $sqlGetMainvalue= 'SELECT * FROM plc2.'.$this->main_table.' WHERE ldeleted = 0 AND '.$this->main_table_pk.' = '.$id.'   '; 
                                $dataHead = $this->db->query($sqlGetMainvalue)->row_array(); 

                                $data_field['dataHead']= $dataHead;
                                $data_field['main_table_pk']= $this->main_table_pk;
                                $data_field['pk_id'] = $get['id'];
                                
                                if($form_field['iM_jenis_field'] == 13){
                                    $sqlEdit = $form_field['vSource_input_edit'];
                                    $sqlEdit = str_replace('$filter$', $this->lib_plc->queryFilterUPBbyTeam($this->modul_id,'u'), $sqlEdit);
                                    $union = ' UNION SELECT u.iupb_id AS valval, CONCAT(u.vupb_nomor," | ",u.vupb_nama) AS showshow, '.$dataHead['iexisting'].' AS iexisting FROM plc2.plc2_upb u WHERE u.iupb_id = '.$dataHead['iupb_id'];
                                    $sqlEdit .= $union;
                                    $data_field['vSource_input'] = $sqlEdit;
                                }else if ($form_field['iM_jenis_field'] == 7){
                                    $data_field['qrFiles'] = 'SELECT id, isoibb_id, filename AS vFilename, vKeterangan AS vKeterangan, vFilename_generate AS vFilename_generate FROM plc2.plc2_upb_file_soi_bahanbaku WHERE '.$this->main_table_pk.' = '.$dataHead[$this->main_table_pk].' AND ( ldeleted = 0 OR ldeleted IS NULL)';
                                } else if ($form_field['iM_jenis_field'] == 19){
                                    if ($form_field['vNama_field'] == 'itype'){
                                        $data_field['label'] = 'Final';
                                        $data_field['default'] = 1;
                                    }else if ($form_field['vNama_field'] == 'irevisi'){
                                        $data_field['label'] = $dataHead['irevisi'];
                                        $data_field['default'] = $dataHead['irevisi'];
                                    }
                                }else{
                                    $data_field['vSource_input']= $form_field['vSource_input'] ;
                                }

                                if ($form_field['iRequired']==1) { 
                                    $data_field['field_required']= 'required';
                                }else{
                                    $data_field['field_required']= '';
                                }
                                $data_field['iModul_id'] = $this->iModul_id;
                                $data_field['modul_id'] = $this->modul_id;
                                

                                $return_field = $this->load->view('partial/v3_form_detail_update',$data_field,true);    
                            }else{
                                if ($form_field['iRequired']==1) { 
                                    $data_field['field_required']= 'required';
                                }else{
                                    $data_field['field_required']= '';
                                }

                                $sqlQuery = $form_field['vSource_input'];

                                if ($form_field['iM_jenis_field'] == 13){
                                    $sqlQuery = str_replace('$filter$', $this->lib_plc->queryFilterUPBbyTeam($this->modul_id,'u'), $sqlQuery);
                                }else if ($form_field['iM_jenis_field'] == 19){
                                    if ($form_field['vNama_field'] == 'itype'){
                                        $data_field['label'] = 'Final';
                                        $data_field['default'] = 1;
                                    }else if ($form_field['vNama_field'] == 'irevisi'){
                                        $data_field['label'] = 0;
                                        $data_field['default'] = 0;
                                    }
                                }

                                $data_field['vSource_input']= $sqlQuery; 
                                $data_field['iModul_id'] = $this->iModul_id;
                                $data_field['modul_id'] = $this->modul_id;

                                $return_field = $this->load->view('partial/v3_form_detail',$data_field,true);    
                            }
                            

                            $hate_emel .='  <div class="rows_group" style="overflow:fixed;">
                                                <label for="'.$controller.'_form_detail_'.$form_field['vNama_field'].'" class="rows_label">'.$form_field['vDesciption'].'
                                                ';
                            if ($form_field['iRequired']==1) {
                                $hate_emel .='<span class="required_bintang">*</span>';    
                                $data_field['field_required']= 'required';
                            }else{
                                $data_field['field_required']= '';
                            }

                            if ($form_field['vRequirement_field']<> "") {
                                $hate_emel .='<span style="float:right;" title="'.$form_field['vRequirement_field'].'" class="ui-icon ui-icon-info"></span>';    
                            }else{
                                $hate_emel .='';    
                            }

                            $hate_emel .='      </label>
                                                <div class="rows_input">'.$return_field.'</div>
                                            </div>';
                        }

                    }else{
                        $hate_emel .='Field belum disetting';
                    }

                    $hate_emel .= '<input type="hidden" name="isdraft" id="isdraft" />';
                    $hate_emel .= '<script>
                                        var idexist = "#v3_spesifikasi_soi_bb_iexisting";
                                        $(idexist).parent().parent().hide();

                                        var iexisting = $(idexist).val();
                                        var idfield = "#v3_spesifikasi_soi_bb_ineed_revisi";
                                        if (iexisting == 1){
                                            $(idfield).removeAttr("value");
                                            $(idfield).parent().parent().hide();
                                            $(idfield).removeClass("required error_text");
                                        }else{
                                            $(idfield).parent().parent().show();
                                            $(idfield).addClass("required");
                                        }
                                    </script>';

                    $data["html"] .= $hate_emel;
                    echo json_encode($data);
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
                $post           = $this->input->post();
                $get            = $this->input->get();
                $lastId         = isset($post[$this->url."_".$this->main_table_pk])?$post[$this->url."_".$this->main_table_pk]:"0";
                $dataFieldUpload=$this->lib_plc->getUploadFileFromField($this->input->get('modul_id'));

                if(count($dataFieldUpload) > 0 && $lastId != "0" && $lastId != ""){
                    foreach ($dataFieldUpload as $kf => $vUpload) {
                        $pathf      = $vUpload['filepath'];
                        $iddetails  = $vUpload['filename'].'_iFile';

                        $validdetails = array();

                        foreach ($post as $kk => $vv) {
                            if($kk==$iddetails){
                                foreach ($vv as $kv2 => $vv2) {
                                    $validdetails[]=$vv2;
                                }
                                
                            }
                        }
                        $dataupdate['iDeleted']     = 1;
                        $dataupdate['dUpdate']      = date("Y-m-d H:i:s");
                        $dataupdate['cUpdate']      = $this->user->gNIP;
                        if(count($validdetails) > 0){
                            $this->db_plc0->where('idHeader_File',$lastId)
                                            ->where_not_in('iFile',$validdetails)
                                            ->where('iM_modul_fileds',$vUpload['iM_modul_fileds'])
                                            ->update('plc2.group_file_upload',$dataupdate);
                        }else{
                            $this->db_plc0->where('idHeader_File',$lastId)
                                            ->where('iM_modul_fileds',$vUpload['iM_modul_fileds'])
                                            ->update('plc2.group_file_upload',$dataupdate);
                        }

                        // Delete File
                        $where  = array('iDeleted'=>1,'idHeader_File'=>$lastId,'iM_modul_fileds'=>$vUpload['iM_modul_fileds']);
                        $this->db_plc0->where($where);
                        $qq     = $this->db_plc0->get('plc2.group_file_upload');

                        if($qq->num_rows() > 0){
                            $result = $qq->result_array();
                            foreach ($result as $kr => $vr) {
                                if(isset($vr["vFilename_generate"])){
                                    $pathf  = $vUpload['filepath'];
                                    $path   = realpath($pathf);
                                    if(file_exists($path."/".$lastId."/".$vr["vFilename_generate"])){
                                        unlink($path."/".$lastId."/".$vr["vFilename_generate"]);
                                    }
                                }
                            }

                        }
                    }
                }

                echo $grid->updated_form();
                break;
                                   
            case 'delete':
                echo $grid->delete_row();
                break;
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
                $this->load->helper('download');        
                $name   = $_GET['file'];
                $id     = $_GET['id'];
                $path   = $_GET['path'];

                $row    = $this->db_plc0->get_where('plc2.sys_masterdok', array('filename' => $path))->row_array();

                if(count($row) > 0 && isset($row["filepath"])){
                    $path = file_get_contents('./'.$row['filepath'].'/'.$id.'/'.$name); 
                    force_download($name, $path);
                }else{
                    echo "File Not Found - 0x01";
                }
                break;

            case 'download_draft':
                $this->load->helper('download');  
                $filename   = $_GET['file'];
                $filepath   = str_replace('\\/', '/', $_GET['path']);
                $id         = $_GET['id'];

                if (file_exists('./'.$filepath.'/'.$id.'/'.$filename)){
                    $file = file_get_contents('./'.$filepath.'/'.$id.'/'.$filename);
                    force_download($filename, $file);
                } else {
                    echo "File Not Found";
                }
                break;

            case 'uploadFile':
                $lastId             = $this->input->get('lastId');
                $dataFieldUpload    = $this->lib_plc->getUploadFileFromField($this->input->get('modul_id'));

                if(count($dataFieldUpload) > 0){
                    foreach ($dataFieldUpload as $kf => $vUpload) {
                        $pathf  = $vUpload['filepath'];
                        $path   = realpath($pathf);

                        if(!file_exists($path."/".$lastId)){
                            if (!mkdir($path."/".$lastId, 0777, true)) { //id review
                                die('Failed upload, try again!');
                            }
                        }

                        $fKeterangan = array();
                        foreach($_POST as $key=>$value) {                       
                            if ($key == 'plc2_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_fileketerangan') {
                                foreach($value as $k=>$v) {
                                    $fKeterangan[$k] = $v;
                                }
                            }
                        }

                        $i=0;
                        foreach ($_FILES['plc2_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name           = $_FILES['plc2_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file']["tmp_name"][$key];
                                $name               = $_FILES['plc2_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file']["name"][$key];
                                $data['filename']   = $name;
                                $data['dInsertDate']= date('Y-m-d H:i:s');
                                $filenameori        = $name;
                                $now_u              = date('Y_m_d__H_i_s');
                                $name_generate      = $this->lib_plc->generateFilename($name, $i);

                                if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name_generate)) {
                                    $datainsert                         = array();
                                    $datainsert['idHeader_File']        = $lastId;
                                    $datainsert['iM_modul_fileds']      = $vUpload['iM_modul_fileds'];
                                    $datainsert['dCreate']              = date('Y-m-d H:i:s');
                                    $datainsert['cCreate']              = $this->user->gNIP;
                                    $datainsert['vFilename']            = $name;
                                    $datainsert['vFilename_generate']   = $name_generate;
                                    $datainsert['tKeterangan']          = $fKeterangan[$i];
                                    $this->db_plc0->insert('plc2.group_file_upload',$datainsert);
                                    $i++;   

                                } else {
                                    echo "Upload ke folder gagal";
                                }
                            }
                        }
                    }

                    $r['message']   = "Data Berhasil Disimpan";
                    $r['status']    = TRUE;
                    $r['last_id']   = $this->input->get('lastId');                  
                    echo json_encode($r);

                }else{
                    $r['message']   = "Data Upload Not Found";
                    $r['status']    = TRUE;
                    $r['last_id']   = $this->input->get('lastId');                  
                    echo json_encode($r);
                }
                break;

            case 'get_data_prev':
                echo $this->get_data_prev();
                break;
            case 'getUPBfrom':
                $this->getUPBfrom();
                break;

            case 'getUploadedFileDraft':
                $this->getUploadedFileDraft();
                break;

            default:
                    $grid->render_grid();
                    break;
        }
    }

        function getUploadedFileDraft(){
            $post       = $this->input->post();
            $upb        = $post['upb'];
            $revisi     = $post['revisi'];
            $modul      = $post['modul'];

            //mendapatkan id draft soi bb
            $sqlLast    = 'SELECT d.idraft_soi_bb FROM plc2.draft_soi_bb d WHERE d.iupb_id = ? AND d.irevisi = ? AND d.iSubmit = 1 AND d.iApprove = 2 AND d.lDeleted = 0 ORDER BY d.idraft_soi_bb DESC LIMIT 1';
            $lastDraft  = $this->db->query($sqlLast, array($upb, $revisi))->row_array();
            $idDraft    = (!empty($lastDraft))?$lastDraft['idraft_soi_bb']:0;

            //mendapatkan file draft soi bb
            $sqlFile    = 'SELECT f.filepath, f.filename, g.* FROM plc2.sys_masterdok f 
                            JOIN plc2.group_file_upload g ON f.iM_modul_fileds = g.iM_modul_fileds
                            WHERE f.idmasterdok = 32 AND g.iDeleted = 0 
                                AND g.idHeader_File = ?';
            $fileDraft  = $this->db->query($sqlFile, array($idDraft))->result_array();

            $fileCust   = $this->db->get_where('plc3.m_modul_fileds', array('vNama_field'=>'file_draft', 'lDeleted' => 0, 'iM_modul' => $modul))->row_array();
            $fileLoad   = $fileCust['vFile_detail'];

            $data['rows'] = $fileDraft;
            $value      = $this->load->view('partial/modul/'.$fileLoad, $data,true);
            echo $value;exit();
        }

        function getUPBfrom(){
            $post = $this->input->post();
            $upb = (!empty($post['upb']))?$post['upb']:0;
            $pk = $post['id'];
            $fieldID = $post['field'];
            $text = $post['text'];
            
            $field = $this->db->get_where('plc3.m_modul_fileds', array('iM_modul_fileds'=>$fieldID))->row_array();
            $soi = $this->db->get_where($this->_table, array( $this->main_table_pk => $pk, 'ldeleted' => 0 ))->row_array();

            $query = $field['vSource_input'];
            if (count($soi) > 0){
                $query = $field['vSource_input_edit'];
                $query .= ' UNION SELECT u.iupb_id AS valval, CONCAT(u.vupb_nomor," | ",u.vupb_nama) AS showshow, '.$soi['iexisting'].' AS iexisting FROM plc2.plc2_upb u WHERE u.iupb_id = '.$soi['iupb_id'];
            }

            $query = str_replace('$filter$', $this->lib_plc->queryFilterUPBbyTeam($this->modul_id,'u'), $query);
            $query = 'SELECT q.iexisting FROM ( '.$query.' ) AS q WHERE q.valval = '.$upb.' AND q.showshow LIKE "%'.$text.'%" '; 
            $selected = $this->db->query($query)->row_array();
            echo (!empty($selected)?$selected['iexisting']:0); exit();
        }

        function get_data_prev(){
            $post       = $this->input->post();
            $get        = $this->input->get();
            $nmTable    = isset($post["nmTable"])?$post["nmTable"]:"0";
            $grid       = isset($post["grid"])?$post["grid"]:"0";
            $grid       = isset($post["grid"])?$post["grid"]:"0";
            $namefield  = isset($post["namefield"])?$post["namefield"]:"0";

            $this->db_plc0->select("*") ->from("plc2.sys_masterdok")->where("filename",$namefield);
            $row        = $this->db_plc0->get()->row_array();
            
            $where      = array('iDeleted'=>0,'idHeader_File'=>$post["id"],'iM_modul_fileds'=>$row['iM_modul_fileds']);
            $this->db_plc0->where($where);

            $q          = $this->db_plc0->get('plc2.group_file_upload');
            $rsel       = array('vFilename','tKeterangan','iact');
            $data       = new StdClass;
            $data->records = $q->num_rows();
            $i          = 0;

            foreach ($q->result() as $k) {
                $data->rows[$i]['id']   = $i;
                $z                      = 0;
                $value                  = $k->vFilename_generate;
                $id                     = $k->idHeader_File;
                $linknya                = 'No File';

                if($value != '') {
                    if (file_exists('./'.$row["filepath"].'/'.$id.'/'.$value)) {
                        $link       = base_url().'processor/'.$this->urlpath.'?action=download&id='.$id.'&file='.$value.'&path='.$row['filename'];
                        $linknya    = '<a class="ui-button-text" href="javascript:;" onclick="window.location=\''.$link.'\'">[Download]</a>&nbsp;&nbsp;&nbsp;';
                    }
                }

                $linknya = $linknya.'<a class="ui-button-text" href="javascript:;" onclick="javascript:hapus_row_'.$nmTable.'('.$i.')">[Hapus]</a><input type="hidden" class="num_rows_'.$nmTable.'" value="'.$i.'" /><input type="hidden" name="'.$post["namefield"].'_iFile[]" value="'.$k->iFile.'" />';

                foreach ($rsel as $dsel => $vsel) {
                    if($vsel == "iact"){
                        $dataar[$dsel]  = $linknya;
                    }else{
                        $dataar[$dsel]  = $k->{$vsel};
                    }
                    $z++;
                }

                $data->rows[$i]['cell']     = $dataar;
                $i++;

            }

            return json_encode($data);
        }

        function searchBox_v3_spesifikasi_soi_bb_iappqc($fields, $id) {
            $arrStat    = array(0 => 'Waiting For Approval', 1 => 'Rejected', 2 => 'Approved');
            $echo       = '<select class="combobox" id="'.$id.'">';
            $echo      .= '<option value="">-- All Status --</option>';

            foreach($arrStat as $s => $i) {
                $echo .= '<option value="'.$s.'">'.$i.'</option>';
            }
            $echo .= '</select>';
            //return $this->db_plc0->last_query();
            return $echo;
        }

        function searchBox_v3_spesifikasi_soi_bb_iappqa($fields, $id) {
            $arrStat    = array(0 => 'Waiting For Approval', 1 => 'Rejected', 2 => 'Approved');
            $echo       = '<select class="combobox" id="'.$id.'">';
            $echo      .= '<option value="">-- All Status --</option>';

            foreach($arrStat as $s => $i) {
                $echo .= '<option value="'.$s.'">'.$i.'</option>';
            }
            $echo .= '</select>';
            //return $this->db_plc0->last_query();
            return $echo;
        }

        function listBox_v3_spesifikasi_soi_bb_iappqc($value, $pk, $name, $rowData) {
            if ($value == 0){
                $vstatus = (intval($rowData->ineed_revisi) == 1)?'-':'Waiting For Approval';
            } else if($value == 1){
                $vstatus = 'Rejected';
            } else if($value == 2){
                $vstatus = 'Approved';
            } else {
                $vstatus = '';
            }
            return $vstatus;
        }

        function listBox_v3_spesifikasi_soi_bb_iappqa($value, $pk, $name, $rowData) {
            if ($value == 0){
                $vstatus = (intval($rowData->ineed_revisi) == 1)?'-':'Waiting For Approval';
            } else if($value == 1){
                $vstatus = 'Rejected';
            } else if($value == 2){
                $vstatus = 'Approved';
            } else {
                $vstatus = '';
            }
            return $vstatus;
        }

        function listBox_v3_spesifikasi_soi_bb_itype($value, $pk, $name, $rowData) {
            if($value==0){$vstatus='Tentative';}
            elseif($value==1){$vstatus='Final';}
            return $vstatus;
        }

        function listBox_Action($row, $actions) {
            $peka = $row->isoibb_id;
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


        function insertBox_v3_spesifikasi_soi_bb_form_detail($field,$id){
            $get=$this->input->get();
            $post=$this->input->post();
            foreach ($get as $kget => $vget) {
                if($kget!="action"){
                    $in[]=$kget."=".$vget;
                }
                if($kget=="action"){
                    $in[]="act=".$vget;
                }
            }
            $g=implode("&", $in);
            $return = '<script>
                var sebelum = $("label[for=\'v3_spesifikasi_soi_bb_form_detail\']").parent();
                $("label[for=\'v3_spesifikasi_soi_bb_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/plc/v3/spesifikasi/soi/bb?action=getFormDetail&formaction=addnew&'.$g.'",
                    type: "post",
                    data: iro_id=0,
                    success: function(data) {
                        var o = $.parseJSON(data);
                        sebelum.html(o.html);
                    }       
                });
            </script>';
            return $return;
        }

        function updateBox_v3_spesifikasi_soi_bb_form_detail($field,$id,$value,$rowData){
            $get=$this->input->get();
            $post=$this->input->post();
            foreach ($get as $kget => $vget) {
                if($kget!="action"){
                    $in[]=$kget."=".$vget;
                }
                if($kget=="action"){
                    $in[]="act=".$vget;
                }
            }
            $g=implode("&", $in);
            $return = '<script>
                var sebelum = $("label[for=\'v3_spesifikasi_soi_bb_form_detail\']").parent();
                $("label[for=\'v3_spesifikasi_soi_bb_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/plc/v3/spesifikasi/soi/bb?action=getFormDetail&formaction=update&'.$g.'",
                    type: "post",
                    data: iro_id=0,
                    success: function(data) {
                        var o = $.parseJSON(data);
                        sebelum.html(o.html);
                    }       
                });
            </script>';
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
                                        var url = "'.base_url().'processor/plc/v3_spesifikasi_soi_bb";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_spesifikasi_soi_bb").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_spesifikasi_soi_bb");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_v3_spesifikasi_soi_bb_approve" action="'.base_url().'processor/plc/v3_spesifikasi_soi_bb?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_spesifikasi_soi_bb_approve\')">Approve</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function approve_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName; 
                $pk = $post[$this->main_table_pk];
                $vRemark = $post['vRemark'];
                $modul_id = $post['modul_id'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $lvl = $post['lvl'];

                $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

                $field = $activity['vFieldName'];
                $update = array($field => 2);
                $this->db->where($this->main_table_pk, $pk);
                $this->db->update('plc2.'.$this->main_table, $update);

                $this->lib_plc->InsertActivityModule($this->ViewUPB($pk),$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);

                $getLastactivity = $this->lib_plc->getLastactivity($modul_id,$pk);
                if ($getLastactivity != 0){
                    $data = $this->db->get_where($this->_table, array($this->main_table_pk => $pk, 'ldeleted' => 0))->row_array();
                    $ineed_revisi = (count($data) > 0)?intval($data['ineed_revisi']):0;
                    if ($ineed_revisi > 0){
                        $draft['iupb_id'] = $data['iupb_id'];
                        $draft['irevisi'] = intval($data['irevisi']) + 1;
                        $draft['vNoDraft'] = $data['vkode_surat'];
                        $draft['iSubmit'] = 0;
                        $draft['dCreate'] = date('Y-m-d H:i:s');
                        $draft['cCreated'] = $this->user->gNIP;
                        $draft['lDeleted'] = 0;
                        $draft['iApprove'] = 0;
                        $this->db->insert('plc2.draft_soi_bb', $draft);
                    }
                }
    
                $data['status']  = true;
                $data['last_id'] = $post[$this->main_table_pk];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }
    
            //Ini Merupakan Standart Confirm yang digunakan di erp
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
                                        var url = "'.base_url().'processor/plc/v3_spesifikasi_soi_bb";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_spesifikasi_soi_bb").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_spesifikasi_soi_bb");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_v3_spesifikasi_soi_bb_confirm" action="'.base_url().'processor/plc/v3_spesifikasi_soi_bb?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_spesifikasi_soi_bb_confirm\')">Confirm</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function confirm_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $pk = $post[$this->main_table_pk];
                $vRemark = $post['vRemark'];
                $lvl = $post['lvl'];
                $modul_id = $post['modul_id'];
                $iM_modul_activity = $post['iM_modul_activity'];

                $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

                $field = $activity['vFieldName'];
                $update = array($field => 2);
                $this->db->where($this->main_table_pk, $pk);
                $this->db->update('plc2.'.$this->main_table, $update);

                $this->lib_plc->InsertActivityModule($this->ViewUPB($pk),$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);
                
                $data['status']  = true;
                $data['last_id'] = $post[$this->main_table_pk];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }
        
            //Ini Merupakan Standart Reject yang digunakan di erp
            function reject_view() {
                $echo = '<script type="text/javascript">
                             function submit_ajax(form_id) {
                                var remark = $("#v3_spesifikasi_soi_bb_remark").val();
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
                                        var url = "'.base_url().'processor/plc/v3_spesifikasi_soi_bb";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_spesifikasi_soi_bb").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_spesifikasi_soi_bb");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_v3_spesifikasi_soi_bb_reject" action="'.base_url().'processor/plc/v3_spesifikasi_soi_bb?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark" id="reject_v3_spesifikasi_soi_bb_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_spesifikasi_soi_bb_reject\')">Reject</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            }
            
            function reject_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $pk = $post[$this->main_table_pk];
                $vRemark = $post['vRemark'];
                $lvl = $post['lvl'];
                $modul_id = $post['modul_id'];
                $iM_modul_activity = $post['iM_modul_activity'];

                $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

                $field = $activity['vFieldName'];
                $update = array($field => 1);
                $this->db->where($this->main_table_pk, $pk);
                $this->db->update('plc2.'.$this->main_table, $update);

                $this->lib_plc->InsertActivityModule($this->ViewUPB($pk),$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,1);

                //status submit, appr & confirmation di ubah emnjadi 0
                $sqlAct     = $this->db->get_where('plc3.m_modul_activity', array('lDeleted' => 0, 'iM_modul' => $activity['iM_modul']))->result_array();
                foreach ($sqlAct as $act) {
                    $vFieldName = $act['vFieldName'];
                    if (strlen($vFieldName) > 0){
                        $this->db->where($this->main_table_pk, $pk);
                        $this->db->update($this->_table, array($vFieldName => 0));
                    } else {
                        $this->db->where($this->main_table_pk, $pk);
                        $this->db->update($this->_table, array('iSubmit' => 0));
                    }
                }

                //log yang sudah ada diubah status nya menjadi delete
                $this->db->where('idprivi_modules', $modul_id);
                $this->db->where('iKey_id', $pk);
                $this->db->update('plc3.m_modul_log_activity', array('lDeleted' => 1));
    
                $data['status']  = true;
                $data['last_id'] = $post[$this->main_table_pk];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }



    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreate'] = $this->user->gNIP;
        $postData['lDeleted'] = 0;
        if($postData['isdraft'] == true){
            $postData['iSubmit'] = 0;
        } else {
            $postData['iSubmit'] = 1;
        } 

        return $postData;
    }

    function before_update_processor($row, $postData) {
        $postData['dupdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;

        if($postData['isdraft'] == true){
            $postData['iSubmit'] = 0;
        } else {
            $postData['iSubmit'] = 1;
        }
        return $postData;
    }    

    function after_insert_processor($fields, $id, $postData) { 
        $post = $this->input->post();

        if ($postData['iSubmit'] == 1){
            $modul_id = $this->modul_id; 
            $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$post['iM_modul_activity'], 'lDeleted'=>0))->row_array();
            $this->lib_plc->InsertActivityModule($this->ViewUPB($id),$modul_id,$id,$activity['iM_activity'],$activity['iSort']);

            if ($postData['ineed_revisi'] > 0){
                $draft['iupb_id'] = $postData['iupb_id'];
                $draft['irevisi'] = intval($postData['irevisi']) + 1;
                $draft['vNoDraft'] = $postData['vkode_surat'];
                $draft['iSubmit'] = 0;
                $draft['dCreate'] = date('Y-m-d H:i:s');
                $draft['cCreated'] = $this->user->gNIP;
                $draft['lDeleted'] = 0;
                $draft['iApprove'] = 0;
                $draft['iTujuan_req'] = 1;
                $draft['ireqdet_id'] = 0;
                $draft['ianalisa_bb'] = 0;
                $this->db->insert('plc2.draft_soi_bb', $draft);
            }
        }
    }

    function after_update_processor($fields, $id, $postData) {
        $post = $this->input->post();

        if ($postData['iSubmit'] == 1){
            $modul_id = $this->modul_id; 
            $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$post['iM_modul_activity'], 'lDeleted'=>0))->row_array();
            $this->lib_plc->InsertActivityModule($this->ViewUPB($id),$modul_id,$id,$activity['iM_activity'],$activity['iSort']);

            if ($postData['ineed_revisi'] > 0){
                $draft['iupb_id'] = $postData['iupb_id'];
                $draft['irevisi'] = intval($postData['irevisi']) + 1;
                $draft['vNoDraft'] = $postData['vkode_surat'];
                $draft['iSubmit'] = 0;
                $draft['dCreate'] = date('Y-m-d H:i:s');
                $draft['cCreated'] = $this->user->gNIP;
                $draft['lDeleted'] = 0;
                $draft['iApprove'] = 0;
                $draft['iTujuan_req'] = 1;
                $draft['ireqdet_id'] = 0;
                $draft['ianalisa_bb'] = 0;
                $this->db->insert('plc2.draft_soi_bb', $draft);
            }
        }

    }

    function manipulate_insert_button($buttons) { 
        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $data['upload']='upload_custom_grid';
        $js = $this->load->view('js/standard_js',$data,TRUE);

        $iframe = '<iframe name="v3_spesifikasi_soi_bb_frame" id="v3_spesifikasi_soi_bb_frame" height="0" width="0"></iframe>';

        $sql = "SELECT a.* FROM plc3.m_modul m JOIN plc3.m_modul_activity a ON m.iM_modul = a.iM_modul WHERE idprivi_modules = ? AND m.lDeleted = 0 AND a.lDeleted = 0 ORDER BY a.iSort ASC LIMIT 1";
        $act = $this->db->query($sql, array($this->modul_id))->row_array();

        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'v3_spesifikasi_soi_bb\', \' '.base_url().'processor/plc/v3_spesifikasi_soi_bb?draft=true&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].' \',this,true )"  id="button_save_draft_v3_spesifikasi_soi_bb"  class="ui-button-text icon-save" >Save as Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\'v3_spesifikasi_soi_bb\', \' '.base_url().'processor/plc/v3_spesifikasi_soi_bb?company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,false )"  id="button_save_submit_v3_spesifikasi_soi_bb"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

        $AuthModul = $this->lib_plc->getAuthorModul($this->modul_id);
        $arrTeam = explode(',',$this->team);
        $nipAuthor = explode(',', $AuthModul['vNip_author']);

        if( in_array($AuthModul['vDept_author'],$arrTeam )  || in_array($this->user->gNIP, $nipAuthor)  ){

            $buttons['save'] = $iframe.$save_draft.$save.$js;
        }else{
            unset($buttons['save']);
            $buttons['save'] = '<span style="color:red;" title="'.$AuthModul['vDept_author'].'">You\'re Dept not Authorized</span>';
        }
        
        
        return $buttons;
    }

    function manipulate_update_button($buttons, $rowData) { 
        $peka=$rowData[$this->main_table_pk];
        $iupb_id = 0;

        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $data['upload']='upload_custom_grid';
        $js = $this->load->view('js/standard_js',$data,TRUE);

        $iframe = '<iframe name="v3_spesifikasi_soi_bb_frame" id="v3_spesifikasi_soi_bb_frame" height="0" width="0"></iframe>';
        
        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        } else { 
            $sButton = $iframe.$js;

            $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

            if($isOpenEditing){
                $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_spesifikasi_soi_bb\', \' '.base_url().'processor/plc/v3_spesifikasi_soi_bb?draft=true \',this,true )"  id="button_update_draft_v3_spesifikasi_soi_bb"  class="ui-button-text icon-save" >Update open Editing</button>';
                $sButton .= $update_draft;

            } else {

                $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$peka);
                $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,$peka); 

                foreach ($activities as $act) {
                    $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_spesifikasi_soi_bb\', \' '.base_url().'processor/plc/v3_spesifikasi_soi_bb?draft=true&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].' \',this,true )"  id="button_update_draft_v3_spesifikasi_soi_bb"  class="ui-button-text icon-save" >Update as Draft</button>';
                    $update = '<button onclick="javascript:update_btn_back(\'v3_spesifikasi_soi_bb\', \' '.base_url().'processor/plc/v3_spesifikasi_soi_bb?company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,false )"  id="button_update_submit_v3_spesifikasi_soi_bb"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

                    $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_spesifikasi_soi_bb?action=approve&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_spesifikasi_soi_bb"  class="ui-button-text icon-save" >Approve</button>';
                    $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_spesifikasi_soi_bb?action=reject&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_v3_spesifikasi_soi_bb"  class="ui-button-text icon-save" >Reject</button>';

                    $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_spesifikasi_soi_bb?action=confirm&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_spesifikasi_soi_bb"  class="ui-button-text icon-save" >Confirm</button>';

                    

                    switch ($act['iType']) {
                        case '1':
                            # Update
                            $sButton .= $update_draft.$update;
                            break;
                        case '2':
                            # Approval
                            if ($getLastStatusApprove){
                                if ($rowData['ineed_revisi'] == 0 ){
                                    $sButton .= $approve.$reject;
                                }else{
                                    $sButton = '';
                                }
                            } else {
                                $sButton .= 'Last Activity Reject';
                            }
                            
                            break;
                        case '3':
                            # Confirmation
                            if ($getLastStatusApprove){
                                if ($rowData['ineed_revisi'] == 0){
                                    $sButton .= $confirm;
                                }else{
                                    $sButton = '';
                                }
                            } else {
                                $sButton .= 'Last Activity Reject';
                            }
                            
                            break;
                        default:
                            # Update
                            $sButton .= $update_draft.$update;
                            break;
                    }
                    $arrNipAssign = explode(',',$act['vNip_assigned'] );
                    $arrTeam = explode(',',$this->team);

                    $arrTeamID = explode(',',$this->teamID);
                    $upbTeamID = $this->lib_plc->upbTeam($peka);

                    if(in_array($act['vDept_assigned'], $arrTeam ) || in_array($this->user->gNIP, $arrNipAssign)  ){
                        
                        /*// jika Dept id yang ditunjuk ada pada team id yang dimiliki
                        if(in_array($upbTeamID[$act['vDept_assigned']], $arrTeamID) || in_array($this->user->gNIP, $arrNipAssign) ){*/
                            //get manager from Team ID
                            $magrAndCief = $this->lib_plc->managerAndChief(20);

                            // jika activitynya approval keatas
                            if($act['iType'] > 1){
                                // nip harus ada pada nip manager atau chief dari Dept, atau nip yang ditunjuk di table modul activity
                                $arrmgrAndCief = explode(',', $magrAndCief);
                                if(in_array($this->user->gNIP, $arrmgrAndCief) ||in_array($this->user->gNIP, $arrNipAssign)){
                                    
                                }else{
                                    $sButton = '<span style="color:red;" <th style="border: 1px solid #dddddd; width: 30%;">By</th>>You\'re not Authorized to Approve</span>';
                                }
                            }

/*                            }else{
                            $sButton = '<span style="color:red;" arrTeamID="'.$this->teamID.'" title="'.$upbTeamID[$act['vDept_assigned']].'" >You\'re Team not Authorized </span>';
                        }*/


                        

                    }else{
                        $sButton = '<span style="color:red;" title="'.$act['vDept_assigned'].'">You\'re Dept not Authorized</span>';
                        
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

    private function ViewUPB ($id=0){
        $upb = $this->db->get_where('plc2.'.$this->main_table, array($this->main_table_pk=>$id, 'lDeleted'=>0))->result_array();
        $arrUPB = array();
        foreach ($upb as $u) {
            if (isset($u['iupb_id'])){
                array_push($arrUPB, $u['iupb_id']);
            }
        }
        return $arrUPB;
    }

}
