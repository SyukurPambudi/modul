<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_draft_soi_bb extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('auth');
        $this->load->library('lib_plc');
        $this->db = $this->load->database('hrd',false, true);
        $this->user = $this->auth->user();
        $this->modul_id = $this->input->get('modul_id');

        $this->iModul_id = $this->lib_plc->getIModulID($this->input->get('modul_id'));

        $this->main_table='draft_soi_bb';
        $this->main_table_pk='idraft_soi_bb';

        $this->team = $this->lib_plc->hasTeam($this->user->gNIP);
        $this->teamID = $this->lib_plc->hasTeamID($this->user->gNIP);

        $isAdmin=$this->lib_plc->isAdmin($this->user->gNIP);
        $this->isAdmin = $isAdmin;

        $this->load->library('auth_localnon');
        $this->_table = 'plc2.draft_soi_bb';

        $this->path = 'files/plc/local/draft_soi_bb/rpt_draft_soi_bb';
        $this->tempat = 'local/draft_soi_bb/rpt_draft_soi_bb';
        $this->folderApp = 'plc';

        $this->url = 'v3_draft_soi_bb';
        $this->urlpath = 'plc/'.str_replace("_","/", $this->url);
    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle('Draft SOI Bahan Baku');       
        $grid->setTable($this->_table);     
        $grid->setUrl($this->url);
        $grid->addList('vNoDraft','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','irevisi','iSubmit','iApprove');
        $grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = draft_soi_bb.iupb_id', 'inner');
        $grid->setSortBy('idraft_soi_bb');
        $grid->setSortOrder('DESC');
        $grid->setSearch('plc2_upb.vupb_nomor', 'plc2_upb.vupb_nama','vNoDraft');

        $grid->setFormWidth('vpo_nomor', 50);
        $grid->setFormWidth('vro_nomor', 50);
        $grid->setFormWidth('trequest', 50);
        $grid->setFormWidth('cnip', 20);
        $grid->setFormWidth('employee.vName', 120);
        
        $grid->setLabel('iApprove', 'Status Approval'); //Ganti Label
        $grid->setAlign('iApprove', 'Center'); //Align nya
        $grid->setWidth('iApprove', '50'); // width nya
        
        $grid->setLabel('vupb_nama', 'Nama UPB'); //Ganti Label
        $grid->setLabel('vgenerik', 'Nama Generik'); //Ganti Label
        $grid->setLabel('team_pd', 'Team PD'); //Ganti Label
        $grid->setLabel('file_filename', 'Upload Laporan '); //Ganti Label
        $grid->setLabel('file_literatur', 'Upload Laporan Study Literatur'); //Ganti Label
        
        $grid->setLabel('vNoDraft', 'No Draft'); //Ganti Label
        $grid->setAlign('vNoDraft', 'Center'); //Align nya
        $grid->setWidth('vNoDraft', '100'); // width nya
    
        $grid->setLabel('ireqdet_id', 'Bahan Baku'); //Ganti Label
        $grid->setLabel('iupb_id', 'No UPB'); //Ganti Label
        $grid->setLabel('plc2_upb.vupb_nomor', 'No UPB'); //Ganti Label
        $grid->setAlign('plc2_upb.vupb_nomor', 'center'); //Align nya
        $grid->setWidth('plc2_upb.vupb_nomor', '80'); // width nya

        $grid->setLabel('plc2_upb.vupb_nama', 'Nama UPB'); //Ganti Label
        $grid->setAlign('plc2_upb.vupb_nama', 'center'); //Align nya
        $grid->setWidth('plc2_upb.vupb_nama', '200'); // width nya
        
        $grid->setLabel('vNoDraft', 'No Draft'); //Ganti Label
        $grid->setAlign('vNoDraft', 'center'); //Align nya
        $grid->setWidth('vNoDraft', '100'); // width nya

        $grid->setLabel('iSubmit', 'Status Submit'); //Ganti Label
        $grid->setAlign('iSubmit', 'center'); //Align nya
        $grid->setWidth('iSubmit', '100'); // width nya

        $grid->setLabel('iApprove', 'Status Approval'); //Ganti Label
        $grid->setAlign('iApprove', 'center'); //Align nya
        $grid->setWidth('iApprove', '150'); // width nya

        $grid->setLabel('dMulai_literatur', 'Tanggal Mulai Study Literatur '); //Ganti Label
        $grid->setAlign('dMulai_literatur', 'left'); //Align nya
        $grid->setWidth('dMulai_literatur', '50'); // width nya

        $grid->setLabel('dSelesai_literatur', 'Tanggal Selesai Study Literatur '); //Ganti Label
        $grid->setAlign('dSelesai_literatur', 'left'); //Align nya
        $grid->setWidth('dSelesai_literatur', '50'); // width nya

        $grid->setLabel('dMulai_draft', 'Mulai Pembuatan Draft'); //Ganti Label
        $grid->setAlign('dMulai_draft', 'left'); //Align nya
        $grid->setWidth('dMulai_draft', '50'); // width nya

        $grid->setLabel('dSelesai_draft', 'Selesai Pembuatan Draft'); //Ganti Label
        $grid->setAlign('dSelesai_draft', 'left'); //Align nya
        $grid->setWidth('dSelesai_draft', '50'); // width nya
        
        $grid->setLabel('cPenyusun', 'Penyusun'); //Ganti Label
        $grid->setAlign('cPenyusun', 'left'); //Align nya
        $grid->setWidth('cPenyusun', '50'); // width nya        
        
        $grid->setLabel('iHasil_uji', 'Hasil Pengujian Mikro BB'); //Ganti Label
        $grid->setAlign('iHasil_uji', 'left'); //Align nya
        $grid->setWidth('iHasil_uji', '50'); // width nya
        
        $grid->setLabel('irevisi', 'Revisi'); //Ganti Label
        $grid->setAlign('irevisi', 'center'); //Align nya
        $grid->setWidth('irevisi', '50'); // width nya

        $grid->setLabel('iUji_spesifik', 'Perlu Uji Spesifik'); //Ganti Label

        $grid->setQuery('draft_soi_bb.lDeleted', 0);   
        $grid->setQuery('plc2_upb.itipe_id <> 6',null); 

        $this->lib_plc->gridFilterUPBbyTeam($grid, $this->modul_id);
        
        $grid->changeFieldType('iApprove','combobox','',array(''=>'--Select--',0=>'Waiting Approval',1=>'Rejected', 2=>'Approved'));
        $grid->changeFieldType('iSubmit','combobox','',array('0'=>'Draft','1'=>'Submitted'));
        $grid->changeFieldType('iHasil_uji','combobox','',array(''=>'Select One','1'=>'Gagal','2'=>'Berhasil'));
        $grid->changeFieldType('iUji_spesifik','combobox','',array(''=>'Select One','1'=>'Ya','0'=>'Tidak'));

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
                    $iTujuan_req = 0;

                    $hate_emel = "";

                    if($get['formaction']=='update'){
                            $aidi = $get['id'];
                    }else{
                            $aidi = 0;
                    }

                    $hate_emel .= '
                        <table class="hover_table" style="width:99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
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

                            $hate_emel .= $this->lib_plc->getHistoryActivity($this->modul_id,$aidi);

                    $hate_emel .='
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <hr>
                    ';


                    if(!empty($dFields)){

                        foreach ($dFields as $form_field) {
                            $controller                     = $this->url;
                            
                            $data_field['iM_jenis_field']   = $form_field['iM_jenis_field'] ;
                            $data_field['form_field']       = $form_field;
                            $data_field['get']              = $get;
                            $data_field['id']               = $controller.'_'.$form_field['vNama_field'];
                            $data_field['field']            = $form_field['vNama_field'] ;
                            $data_field['act']              = $get['act'] ;
                            $data_field['hasTeam']          = $this->team ;
                            $data_field['hasTeamID']        = $this->teamID ;
                            $data_field['isAdmin']          = $this->isAdmin ;

                            /*untuk keperluad file upload*/
                            if($form_field['iM_jenis_field'] == 7){
                                $data_field['tabel_file']       = $form_field['vTabel_file'] ;
                                $data_field['tabel_file_pk']    = $this->main_table_pk;
                                $data_field['tabel_file_pk_id'] = $form_field['vTabel_file_pk_id'] ;

                                $createname_space               = $this->url;

                                $data_field['path']             = $this->path;
                                $data_field['FOLDER_APP']       = $this->folderApp;
                                $data_field['createname_space'] = $createname_space;
                                $data_field['tempat']           = $this->tempat;
                            }
                            /*untuk keperluad file upload*/

                            if($get['formaction'] == 'update'){
                                $id = $get['id'];

                                $sqlGetMainvalue    = 'SELECT * FROM plc2.'.$this->main_table.' WHERE ldeleted = 0 AND '.$this->main_table_pk.' = '.$id.'   '; 
                                $dataHead           = $this->db->query($sqlGetMainvalue)->row_array();
                                $iTujuan_req        = $dataHead['iTujuan_req']; 

                                $data_field['dataHead']         = $dataHead;
                                $data_field['main_table_pk']    = $this->main_table_pk;
                                $data_field['pk_id']            = $get['id'];
                                
                                if($form_field['iM_jenis_field'] == 6){
                                    $sqlEdit = $form_field['vSource_input_edit'];

                                    if($this->auth_localnon->is_manager()){
                                        $x          = $this->auth_localnon->dept();
                                        $manager    = $x['manager'];

                                        if(in_array('PD', $manager)){
                                            $sqlEdit .= ' AND ( e.cNip IN ( SELECT a.cNip FROM hrd.employee a 
                                                            JOIN plc2.plc2_upb_team_item b ON b.vnip = a.cNip
                                                            JOIN plc2.plc2_upb_team c ON c.iteam_id=b.iteam_id
                                                            WHERE b.ldeleted=0
                                                            AND c.ldeleted=0
                                                            AND a.dresign="0000-00-00"
                                                            AND c.iteam_id IN( '.$this->auth_localnon->my_teams().') ) 
                                                            OR e.cNip = "'.$dataHead['cPenyusun'].'" )';
                                        }
                                    } else {
                                        $x=$this->auth_localnon->dept();
                                        $team=$x['team'];
                                        if(in_array('PD', $team)){
                                            $sqlEdit .= ' AND ( e.cNip IN ( SELECT a.cNip FROM hrd.employee a 
                                                            JOIN plc2.plc2_upb_team_item b ON b.vnip = a.cNip
                                                            JOIN plc2.plc2_upb_team c ON c.iteam_id=b.iteam_id
                                                            WHERE b.ldeleted=0
                                                            AND c.ldeleted=0
                                                            AND a.dresign="0000-00-00"
                                                            AND c.iteam_id IN( '.$this->auth_localnon->my_teams().') ) 
                                                            OR e.cNip = "'.$dataHead['cPenyusun'].'" )';
                                        }
                                    }
                                    $data_field['vSource_input'] = $sqlEdit; 
                                }else if ($form_field['iM_jenis_field'] == 7){
                                    $data_field['qrFiles'] = 'SELECT id, idraft_soi_bb, filename AS vFilename, keterangan AS vKeterangan, IF (vFilename_generate IS NOT NULL, vFilename_generate, filename) AS vFilename_generate FROM plc2.draft_soi_bb_file WHERE '.$this->main_table_pk.' = '.$dataHead[$this->main_table_pk].' AND ( ldeleted = 0 OR ldeleted IS NULL)';
                                } else if ($form_field['iM_jenis_field'] == 13){
                                    $sqlEdit = $form_field['vSource_input_edit'];
                                    $sqlEdit .= $this->lib_plc->queryFilterUPBbyTeam($this->modul_id,'u');
                                    $sqlEdit .= ' UNION SELECT iupb_id AS valval, CONCAT (vupb_nomor, " | ",vupb_nama) AS showshow, '.$dataHead['iTujuan_req'].' AS iTujuan_req FROM plc2.plc2_upb WHERE iupb_id = '.$dataHead['iupb_id'];
                                    $data_field['vSource_input'] =  $sqlEdit;
                                    $data_field['form_field']['iRead_only_form'] = 1;
                                } else if ($form_field['iM_jenis_field'] == 19){
                                    $data_field['label'] = $dataHead['irevisi'];
                                    $data_field['default'] = $dataHead['irevisi'];
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
                                } 

                                $sqlQuery = $form_field['vSource_input'];

                                if ($form_field['iM_jenis_field'] == 13){
                                    $sqlQuery .= $this->lib_plc->queryFilterUPBbyTeam($this->modul_id,'u');
                                } else if ($form_field['iM_jenis_field'] == 19){
                                    $data_field['label'] = 0;
                                    $data_field['default'] = 0;
                                }else{
                                    $data_field['field_required']= '';
                                }


                                if ($form_field['iM_jenis_field'] == 6){
                                    if($this->auth_localnon->is_manager()){
                                        $x=$this->auth_localnon->dept();
                                        $manager=$x['manager'];
                                        if(in_array('PD', $manager)){
                                            $sqlQuery .= ' AND e.cNip IN ( SELECT a.cNip FROM hrd.employee a 
                                                            JOIN plc2.plc2_upb_team_item b ON b.vnip = a.cNip
                                                            JOIN plc2.plc2_upb_team c ON c.iteam_id=b.iteam_id
                                                            WHERE b.ldeleted=0
                                                            AND c.ldeleted=0
                                                            AND a.dresign="0000-00-00"
                                                            AND c.iteam_id IN( '.$this->auth_localnon->my_teams().') ) ';
                                        }
                                    } else {
                                        $x=$this->auth_localnon->dept();
                                        $team=$x['team'];
                                        if(in_array('PD', $team)){
                                            $sqlQuery .= ' AND e.cNip IN ( SELECT a.cNip FROM hrd.employee a 
                                                            JOIN plc2.plc2_upb_team_item b ON b.vnip = a.cNip
                                                            JOIN plc2.plc2_upb_team c ON c.iteam_id=b.iteam_id
                                                            WHERE b.ldeleted=0
                                                            AND c.ldeleted=0
                                                            AND a.dresign="0000-00-00"
                                                            AND c.iteam_id IN( '.$this->auth_localnon->my_teams().') ) ';
                                        }
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
                    $hate_emel .= '<input type="hidden" name="iTujuan_req" id="'.$this->url.'_iTujuan_req" value="'.$iTujuan_req.'" />';

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
            case 'getTujuanReq':
                echo $this->getTujuanReq();
                break;

            default:
                $grid->render_grid();
                break;
        }
    }

        function getTujuanReq(){
            $post           = $this->input->post();
            $upb            = $post['upb'];
            $field          = $post['field'];

            $detailField    = $this->db->get_where('plc3.m_modul_fileds', array('iM_modul_fileds' => $field))->row_array();
            $sqlQuery       = (!empty($detailField))?$detailField['vSource_input']:'';
            $tujuan         = 0;

            if (strlen($sqlQuery) > 0){
                $sqlQuery   .= $this->lib_plc->queryFilterUPBbyTeam($this->modul_id,'u');
                $sqlQuery   .= ' AND u.iupb_id = '.$upb;
                $dataTujuan  = $this->db->query($sqlQuery)->row_array();
                if (!empty($dataTujuan)){
                    $tujuan  = $dataTujuan['iTujuan_req'];
                }
            }

            return $tujuan; 
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

        function listBox_v3_draft_soi_bb_iapppr($value) {
            if ($value == 0){
                $vstatus    = 'Waiting for approval';
            } else if ($value == 1){
                $vstatus    = 'Rejected';
            } else if ($value == 2){
                $vstatus    = 'Approved';
            } else {
                $vstatus    = '';
            }
            return $vstatus;
        }

        function listBox_Action($row, $actions) {
            $peka               = $row->idraft_soi_bb;
            $getLastactivity    = $this->lib_plc->getLastactivity($this->modul_id,$peka);
            $isOpenEditing      = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

            if ( $getLastactivity == 0 ) { 
                    
            }else{
                if ($isOpenEditing){

                } else {
                    unset($actions['edit']);    
                }
                
            }

            return $actions;
        }


        function insertBox_v3_draft_soi_bb_form_detail($field,$id){
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
                var sebelum = $("label[for=\'v3_draft_soi_bb_form_detail\']").parent();
                $("label[for=\'v3_draft_soi_bb_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/plc/v3/draft/soi/bb?action=getFormDetail&formaction=addnew&'.$g.'",
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

        function updateBox_v3_draft_soi_bb_form_detail($field,$id,$value,$rowData){
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
                var sebelum = $("label[for=\'v3_draft_soi_bb_form_detail\']").parent();
                $("label[for=\'v3_draft_soi_bb_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/plc/v3/draft/soi/bb?action=getFormDetail&formaction=update&'.$g.'",
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
                                        var url = "'.base_url().'processor/plc/v3_draft_soi_bb";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_draft_soi_bb").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_draft_soi_bb");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_v3_draft_soi_bb_approve" action="'.base_url().'processor/plc/v3_draft_soi_bb?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_draft_soi_bb_approve\')">Approve</button>';
                    
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
                $this->db->update($this->_table, $update);

                $this->lib_plc->InsertActivityModule($this->ViewUPB($pk),$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);

                $getLastactivity = $this->lib_plc->getLastactivity($modul_id,$pk);
                if ($getLastactivity != 0){
                    $data = $this->db->get_where($this->_table, array($this->main_table_pk => $pk, 'lDeleted' => 0))->row_array();
                    $revisi = (count($data) > 0)?intval($data['irevisi']):0;
                    if ($revisi > 0){
                        $soi['iupb_id'] = $data['iupb_id'];
                        $soi['vrevisi'] = $revisi;
                        $soi['irevisi'] = $revisi;
                        $soi['ineed_revisi'] = 0;
                        $soi['itype'] = 1;
                        $soi['vkode_surat'] = $data['vNoDraft'].' -- After Revisi Draft';
                        $this->db->insert('plc2.plc2_upb_soi_bahanbaku', $soi);
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
                                        var url = "'.base_url().'processor/plc/v3_draft_soi_bb";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_draft_soi_bb").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_draft_soi_bb");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_v3_draft_soi_bb_confirm" action="'.base_url().'processor/plc/v3_draft_soi_bb?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_draft_soi_bb_confirm\')">Confirm</button>';
                    
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
                                var remark = $("#v3_draft_soi_bb_remark").val();
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
                                        var url = "'.base_url().'processor/plc/v3_draft_soi_bb";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_draft_soi_bb").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_draft_soi_bb");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_v3_draft_soi_bb_reject" action="'.base_url().'processor/plc/v3_draft_soi_bb?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark" id="reject_v3_draft_soi_bb_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_draft_soi_bb_reject\')">Reject</button>';
                    
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
    
                $data['status']  = true;
                $data['last_id'] = $post[$this->main_table_pk];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }



    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        // $sql = 'SELECT rs.iupb_id FROM plc2.plc2_upb_request_sample_detail rd JOIN plc2.plc2_upb_request_sample rs ON rd.ireq_id = rs.ireq_id WHERE rd.ireqdet_id = ? ';
        // $upb = $this->db->query($sql, array($postData['ireqdet_id']))->row_array();
        // $postData['iupb_id'] = $upb['iupb_id'];

        $sqlCekRevisi = 'SELECT d.irevisi FROM plc2.draft_soi_bb d WHERE d.iupb_id = ? AND d.lDeleted = 0 ORDER BY d.idraft_soi_bb DESC ';
        $cekRevisi = $this->db->query($sqlCekRevisi, array($postData['iupb_id']))->row_array();
        $revisi = (!empty($cekRevisi))?$cekRevisi['irevisi']:0;

        $postData['irevisi'] = $revisi;
        $postData['ireqdet_id'] = 0;
        $postData['ianalisa_bb'] = 0;
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated'] = $this->user->gNIP;
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

        // $sql = 'SELECT rs.iupb_id FROM plc2.plc2_upb_request_sample_detail rd JOIN plc2.plc2_upb_request_sample rs ON rd.ireq_id = rs.ireq_id WHERE rd.ireqdet_id = ? ';
        // $upb = $this->db->query($sql, array($postData['ireqdet_id']))->row_array();
        // $postData['iupb_id'] = $upb['iupb_id'];
        
        $postData['ireqdet_id'] = 0;
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
        }
    }

    function after_update_processor($fields, $id, $postData) {
        $post = $this->input->post();

        if ($postData['iSubmit'] == 1){
            $modul_id = $this->modul_id; 
            $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$post['iM_modul_activity'], 'lDeleted'=>0))->row_array();
            $this->lib_plc->InsertActivityModule($this->ViewUPB($id),$modul_id,$id,$activity['iM_activity'],$activity['iSort']);
        }

    }

    function manipulate_insert_button($buttons) { 
        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $data['upload']='upload_custom_grid';
        $js = $this->load->view('js/standard_js',$data,TRUE);

        $iframe = '<iframe name="v3_draft_soi_bb_frame" id="v3_draft_soi_bb_frame" height="0" width="0"></iframe>';

        $sql = "SELECT a.* FROM plc3.m_modul m JOIN plc3.m_modul_activity a ON m.iM_modul = a.iM_modul WHERE idprivi_modules = ? AND m.lDeleted = 0 AND a.lDeleted = 0 ORDER BY a.iSort ASC LIMIT 1";
        $act = $this->db->query($sql, array($this->modul_id))->row_array();

        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'v3_draft_soi_bb\', \' '.base_url().'processor/plc/v3_draft_soi_bb?draft=true&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].' \',this,true )"  id="button_save_draft_v3_draft_soi_bb"  class="ui-button-text icon-save" >Save as Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\'v3_draft_soi_bb\', \' '.base_url().'processor/plc/v3_draft_soi_bb?company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,false )"  id="button_save_submit_v3_draft_soi_bb"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

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

        $iframe = '<iframe name="v3_draft_soi_bb_frame" id="v3_draft_soi_bb_frame" height="0" width="0"></iframe>';
        
        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        }
        else{ 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_draft_soi_bb\', \' '.base_url().'processor/plc/v3_draft_soi_bb?draft=true \',this,true )"  id="button_update_draft_v3_draft_soi_bb"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$peka);
                    $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,$peka); 

                    foreach ($activities as $act) {
                        $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_draft_soi_bb\', \' '.base_url().'processor/plc/v3_draft_soi_bb?draft=true&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].' \',this,true )"  id="button_update_draft_v3_draft_soi_bb"  class="ui-button-text icon-save" >Update as Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\'v3_draft_soi_bb\', \' '.base_url().'processor/plc/v3_draft_soi_bb?company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,false )"  id="button_update_submit_v3_draft_soi_bb"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_draft_soi_bb?action=approve&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_draft_soi_bb"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_draft_soi_bb?action=reject&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_v3_draft_soi_bb"  class="ui-button-text icon-save" >Reject</button>';

                        $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_draft_soi_bb?action=confirm&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_draft_soi_bb"  class="ui-button-text icon-save" >Confirm</button>';

                        

                        switch ($act['iType']) {
                            case '1':
                                # Update
                                $sButton .= $update_draft.$update;
                                break;
                            case '2':
                                # Approval
                                if($getLastStatusApprove){
                                    $sButton .= $approve.$reject;
                                }else{
                                    $sButton .= 'Last Activity Reject';
                                }
                                
                                break;
                            case '3':
                                # Confirmation
                                if($getLastStatusApprove){
                                    $sButton .= $confirm;
                                }else{
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
                                        $sButton = '<span style="color:red;">You\'re not Authorized to Approve</span>';
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
