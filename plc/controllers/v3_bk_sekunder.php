 <?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_bk_sekunder extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('auth');
        $this->load->library('lib_plc');
        $this->db = $this->load->database('hrd',false, true);
        $this->user = $this->auth->user();
        $this->modul_id = $this->input->get('modul_id');

        $this->iModul_id = $this->lib_plc->getIModulID($this->input->get('modul_id'));

        $this->main_table='plc2_upb_bahan_kemas';
        $this->main_table_pk='ibk_id';

        $this->team = $this->lib_plc->hasTeam($this->user->gNIP);
        $this->teamID = $this->lib_plc->hasTeamID($this->user->gNIP);

        $isAdmin=$this->lib_plc->isAdmin($this->user->gNIP);
        $this->isAdmin = $isAdmin;

        $this->load->library('auth_localnon');
        $this->_table = 'plc2.plc2_upb_bahan_kemas';
        $this->_table_plc_upb = 'plc2.plc2_upb';
        $this->_table_plc_team = 'plc2.plc2_upb_team';
        $this->_table_employee = 'hrd.employee';  

        $this->path = 'files/plc/bahan_kemas/bahan_kemas_sekunder';
        $this->tempat = 'bahan_kemas/bahan_kemas_sekunder';
        $this->folderApp = 'plc';

    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle('Bahan Kemas Sekunder');       
        $grid->setTable($this->_table);     
        $grid->setUrl('v3_bk_sekunder');
        $grid->addList('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','vtitle','iSubmit','iapppc','iapppd','iappbd','iappqa');
        $grid->setJoinTable($this->_table_plc_upb, $this->_table_plc_upb.'.iupb_id = '.$this->_table.'.iupb_id', 'inner');
        $grid->setRelation('plc2_upb.iteambusdev_id', $this->_table_plc_team, 'iteam_id', 'vteam', 'bdteam','inner', array('vtipe'=>'BD','ldeleted'=>0), array('vteam'=>'asc'));
        $grid->setSortBy('plc2_upb_bahan_kemas.ibk_id');
        $grid->setSortOrder('desc');
        $grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','vtitle');

        $grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
        $grid->setWidth('plc2_upb.vupb_nomor', '73');
        $grid->setLabel('iupb_id', 'UPB');
        $grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
        $grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
        $grid->setLabel('plc2_upb.iteambusdev_id','Team Busdev');
        $grid->setLabel('vtitle','Title');
        $grid->setLabel('iSubmit','Status');
        $grid->setWidth('plc2_upb.vupb_nama','200');
        $grid->setWidth('vtitle','200');
        $grid->setWidth('iSubmit','120');
        $grid->setWidth('iapppc','120');
        $grid->setWidth('iapppd','120');
        $grid->setWidth('iappbd','120');
        $grid->setWidth('iappqa','120');

        $grid->setLabel('ijenis_bk_id','Kemasan Sekunder');
        $grid->setLabel('ijenis_bk_id_sk','Kemasan Sekunder');
        $grid->setLabel('ijenis_bk_id_tr','Kemasan Tersier');
        $grid->setLabel('filename','File');
        $grid->setLabel('vversi','Kode Kemas');
        $grid->setLabel('vrevisi','Revisi');

        $grid->setLabel('vnip_apppd','Approval PD');
        $grid->setLabel('vnip_appqa','Approval QA');
        $grid->setLabel('vnip_appbd','Approval Busdev');
        $grid->setLabel('vnip_apppc', 'Approval Packdev');
        $grid->setLabel('iapppd','Approval PD');
        $grid->setLabel('iappqa','Approval QA');
        $grid->setLabel('iappbd','Approval Busdev');
        $grid->setLabel('iapppc','Approval Packdev');

        $grid->setFormWidth('vrevisi',3);
        $grid->setFormWidth('vversi',3);
        
        $grid->setQuery('plc2_upb_bahan_kemas.ldeleted', 0);
        /*basic required start*/
            $grid->setQuery('plc2.plc2_upb.ldeleted', 0);
            $grid->setQuery('plc2.plc2_upb.iKill', 0);
            $grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
            $grid->setQuery('plc2_upb.ihold', 0);
            $grid->setQuery('plc2_upb_bahan_kemas.iJenis_bk', 2);
        /*basic required finish*/
        
        $this->lib_plc->gridFilterUPBbyTeam($grid, $this->modul_id);

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

                    $sqlFields = 'select * from plc3.m_modul_fileds a where a.lDeleted=0 and  a.iM_modul='.$this->iModul_id.' order by a.iSort ASC';
                    /*echo $sqlFields;
                    exit;*/
                    $dFields = $this->db->query($sqlFields)->result_array(); 

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
                            
                            $data_field['iM_jenis_field']= $form_field['iM_jenis_field'] ;
                            
                            $data_field['form_field']= $form_field;

                            $controller = 'v3_bk_sekunder';
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
                                $createname_space = 'v3_bk_sekunder';

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
                                
                                if($form_field['iM_jenis_field'] == 6){
                                    $data_field['vSource_input']= $form_field['vSource_input_edit'] ;
                                } else if ($form_field['iM_jenis_field'] == 13){
                                    $sqlQuery = $form_field['vSource_input_edit'] ;
                                    $sqlQuery .= $this->lib_plc->queryFilterUPBbyTeam($this->modul_id,'u');
                                    $sqlQuery .= ' UNION SELECT iupb_id AS valval, CONCAT (vupb_nomor, " | ",vupb_nama) AS showshow FROM plc2.plc2_upb WHERE iupb_id = '.$dataHead['iupb_id'];
                                    $data_field['vSource_input']= $sqlQuery;
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

                                $sqlQuery = $form_field['vSource_input'] ;
                                if ($form_field['iM_jenis_field'] == 13){
                                    $sqlQuery .= $this->lib_plc->queryFilterUPBbyTeam($this->modul_id,'u');
                                    $data_field['vSource_input']= $sqlQuery;
                                }

                                $data_field['vSource_input']= $sqlQuery ;
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


                            if ($form_field['iM_jenis_field'] == 8){
                                $hate_emel .='</label>
                                                <div class="">'.$return_field.'</div>
                                            </div>';
                            } else {
                                $hate_emel .='</label>
                                                <div class="rows_input">'.$return_field.'</div>
                                            </div>';
                            }
                        }

                    }else{
                        $hate_emel .='Field belum disetting';
                    }

                    $hate_emel .= '<input type="hidden" name="isdraft" id="isdraft" />';
                    
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
                $post       = $this->input->post();
                $isUpload   = $this->input->get('isUpload');
                $modul_field= $post['modul_fields'];
                $masterDok  = $this->db->get_where('plc2.sys_masterdok', array('ldeleted' => 0, 'iM_modul_fileds' => $modul_field))->row_array(); 
                $path       = ( !empty($masterDok) ) ? $masterDok['filepath'] : $this->path;
                $path       = realpath($path);

                if($isUpload) {
                    $lastId=$this->input->get('lastId');
                    $path = realpath($this->path);
                    if(!file_exists($path."/".$lastId)){
                        if (!mkdir($path."/".$lastId, 0777, true)) { //id review
                            $r['message'] = 'Failed Upload , Failed create Folder!';
                            $r['status'] = FALSE;
                            $r['last_id'] = $lastId;
                            echo json_encode($r);
                            die('Failed upload, try again!');
                        }
                    }
                    $ijenis_bk_id=array();
                    $fileketerangan = array();
                    foreach($_POST as $key=>$value) {
                        if ($key == 'fileketerangan') {
                            foreach($value as $k=>$v) {
                                $fileketerangan[$k] = $v;
                            }
                        }
                        if ($key == 'ijenis_bk_id') {
                            foreach($value as $k=>$v) {
                                $ijenis_bk_id[$k] = $v;
                            }
                        }
                    }
                    $i=0;
                    foreach ($_FILES['fileupload']["error"] as $key => $error) {
                        if ($error == UPLOAD_ERR_OK) {
                            $tmp_name = $_FILES['fileupload']["tmp_name"][$key];
                            $name =$_FILES['fileupload']["name"][$key];
                            $data['filename'] = $name;
                            $name_generate = $this->lib_plc->generateFilename($name);
                            $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name_generate)) {
                                    // $sql[] = "INSERT INTO plc2.plc2_upb_file_bahan_kemas(ibk_id, ijenis_bk_id ,filename, vFilename_generate, dInsertDate, vketerangan,cInsert)
                                    //         VALUES (".$lastId.",'".$ijenis_bk_id[$i]."','".$data['filename']."','".$name_generate."','".$data['dInsertDate']."','".$fileketerangan[$i]."','".$this->user->gNIP."')";

                                    $insert['iM_modul_fileds']  = $modul_field;
                                    $insert['idHeader_File']    = $lastId;
                                    $insert['ijenis_bk_id']     = $ijenis_bk_id[$i];
                                    $insert['vFilename']        = $data['filename'];
                                    $insert['vFilename_generate']= $name_generate;
                                    $insert['tKeterangan']      = $fileketerangan[$i];
                                    $insert['dCreate']          = $data['dInsertDate'];
                                    $insert['cCreate']          = $this->user->gNIP;    
                                    $insert['iDeleted']         = 0;
                                    $this->db->insert('plc2.group_file_upload', $insert);

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
                $lastId     = $post['v3_bk_sekunder_ibk_id'];
                $iupb_id    = $post['iupb_id'];
                // $path       = realpath("files/plc/bahan_kemas/bahan_kemas_primer/");
                $modul_field= $post['modul_fields'];
                $masterDok  = $this->db->get_where('plc2.sys_masterdok', array('ldeleted' => 0, 'iM_modul_fileds' => $modul_field))->row_array(); 
                $path       = ( !empty($masterDok) ) ? $masterDok['filepath'] : 'files/plc/bahan_kemas/bahan_kemas_primer';
                $path       = realpath($path.'/');
                $filesUpload= $this->db->get_where('plc2.group_file_upload', array('iDeleted' => 0, 'iM_modul_fileds' => $modul_field, 'idHeader_File' => $lastId))->result_array();

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
                            $ifileid[$k]=$v;
                            if($i==0){
                                $fileid .= "'".$v."'";
                            }else{
                                $fileid .= ",'".$v."'";
                            }
                            if($v!=''){
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
                        foreach($value as $k=>$v) {
                            $namafile[$k] = $v;
                        }
                    }
                    if ($key == 'ijenis_bk_id') {

                        foreach($value as $k=>$v) {
                            $ijenis_bk_id[$k] = $v;
                        }
                    }
                }

                $tgl= date('Y-m-d H:i:s');

                if($fileid!=''){
                    // $sql1="UPDATE plc2.plc2_upb_file_bahan_kemas SET ldeleted = 1, dUpdateDate = ?, cUpdated = ? WHERE ibk_id = ? AND id not IN (".$fileid.")";
                    $sql1 = "UPDATE plc2.group_file_upload SET iDeleted = 1, dUpdate = ?, cUpdate = ? WHERE idHeader_File = ? AND iM_modul_fileds = ? AND iFile NOT IN (".$fileid.")";
                    $this->db->query($sql1, array($tgl, $this->user->gNIP, $lastId, $modul_field));
                }
                $s=array();

                foreach ($ifileid as $if => $va) {
                    if($va!=''){
                        try {
                            $sql2 = "UPDATE plc2.group_file_upload SET ijenis_bk_id = ?, dUpdate = ?, cUpdate = ? WHERE iFile = ? AND iM_modul_fileds = ? ";
                            $this->db->query($sql2, array($ijenis_bk_id[$if], $tgl, $this->user->gNIP, $va, $modul_field));
                        }catch(Exception $e) {
                            die($e);
                        }
                        // $s[]="UPDATE plc2.plc2_upb_file_bahan_kemas SET ijenis_bk_id=".$ijenis_bk_id[$if].", dUpdateDate='".$tgl."', cUpdated='".$this->user->gNIP."' where id =".$va;
                    }
                }

                //update upload dmf

                $fileiddmf='';
                $jmlfile=0;
                foreach($_POST as $key=>$value) {

                    if ($key == 'fileketerangandmf') {
                        foreach($value as $y=>$u) {
                            $fileketerangandmf[$y] = $u;
                        }
                    }
                    if ($key == 'namafileddmf') {
                        foreach($value as $k=>$v) {
                            $namafileddmf[$k] = $v;
                        }
                    }
                    if ($key == 'fileiddmf') {
                        foreach($value as $k=>$v) {
                            if($jmlfile==0){
                                $fileiddmf .= "'".$v."'";
                            }else{
                                $fileiddmf .= ",'".$v."'";
                            }
                            $jmlfile++;
                        }
                    }
                }

                //delete proses

                if($isUpload) {

                    if (isset($_FILES['fileupload']))  {

                        $i=0;
                        foreach ($_FILES['fileupload']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['fileupload']["tmp_name"][$key];
                                $name =$_FILES['fileupload']["name"][$key];
                                $data['filename'] = $name;
                                $name_generate = $this->lib_plc->generateFilename($name);
                                $data['dInsertDate'] = date('Y-m-d H:i:s');
                                if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name_generate)) {
                                    // $sql[] = "INSERT INTO plc2.plc2_upb_file_bahan_kemas(ibk_id, ijenis_bk_id ,filename, vFilename_generate, dInsertDate, vketerangan,cInsert)
                                    //         VALUES (".$lastId.",'".$ijenis_bk_id[$j]."','".$data['filename']."','".$name_generate."','".$data['dInsertDate']."','".$fileketerangan[$i]."','".$this->user->gNIP."')";

                                    $insert['iM_modul_fileds']  = $modul_field;
                                    $insert['idHeader_File']    = $lastId;
                                    $insert['ijenis_bk_id']     = $ijenis_bk_id[$i];
                                    $insert['vFilename']        = $data['filename'];
                                    $insert['vFilename_generate']= $name_generate;
                                    $insert['tKeterangan']      = $fileketerangan[$i];
                                    $insert['dCreate']          = $data['dInsertDate'];
                                    $insert['cCreate']          = $this->user->gNIP;    
                                    $insert['iDeleted']         = 0;
                                    $this->db->insert('plc2.group_file_upload', $insert);

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
                                   
            case 'delete':
                    echo $grid->delete_row();
                    break;

            case 'gethistkomposisi':
                echo $this->gethistkomposisi();
                break;

            case 'rawmat_list':
                $this->rawmat_list();
                break;
            case 'copyOri':
                echo $this->copyOri_view();
                break;
            case 'copyOri_process':
                echo $this->copyOri_process();
                break;
            case 'copyKomp':
                echo $this->copyKomp_view();
                break;
            case 'copyKomp_process':
                echo $this->copyKomp_process();
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
                $this->download($this->input->get('file'));
                break;
            case 'cekjnsbk':
                $id=$this->input->post('id');
                $sql='SELECT mbk.itipe_bk AS idtipe_bk FROM plc2.plc2_master_jenis_bk mbk WHERE mbk.ldeleted=0 AND mbk.ijenis_bk_id = ?';
                $dt=$this->db->query($sql, array($id))->row_array();
                $data['id']=$dt['idtipe_bk'];
                $data['value']=$id;
                echo json_encode($data);
                break;

            default:
                    $grid->render_grid();
                    break;
        }
    }

        function gethistkomposisi(){
            $raw_id=$_POST['raw_id'];
            $data = array();
            $row_array = '';
            $sql2 = "select b.vupb_nomor 
                    from plc2.plc2_upb_prioritas_komposisi a 
                    join plc2.plc2_upb_prioritas b on b.ibk_id=a.ibk_id
                    where  a.ldeleted=0 and b.ldeleted=0 and a.raw_id='".$raw_id."'";
            $results = $this->db_plc0->query($sql2)->result_array();

            $i=1;
            foreach ($results as $item ) {
                if ($i==1) {
                    $row_array .= trim($item['vupb_nomor']);    
                }else{
                    $row_array .= ','.trim($item['vupb_nomor']);        
                }
                

                $i++;
            }
            
            
            
            array_push($data, $row_array);
            echo json_encode($data);
            exit;

        }

        function rawmat_list() {
            $term = $this->input->get('term');
            $return_arr = array();
            $this->db_plc0->like('vraw',$term);
            $this->db_plc0->or_like('vnama',$term);
            $this->db_plc0->limit(50);
            $lines = $this->db_plc0->get('plc2.plc2_raw_material')->result_array();
            $i=0;
            foreach($lines as $line) {
                $row_array["sat"] = trim($line["vsatuan"]);
                $row_array["value"] = trim($line["vnama"]).' - '.trim($line["vraw"]);
                $row_array["id"] = trim($line["raw_id"]);
                array_push($return_arr, $row_array);
            }
            echo json_encode($return_arr);exit();
            
        }

        // copy Komposisi Originator ke Komposisi UPB
        function copyOri_view() {
            $ibk_id=$this->input->get('upb_id');
            $qupb="select u.vupb_nomor, u.vupb_nama, u.cnip
                        from plc2.plc2_upb_prioritas u where u.ibk_id=$ibk_id";
            $qupa="SELECT  * FROM plc2.plc2_upb_prioritas_komposisi_ori a 
                      INNER JOIN plc2.plc2_raw_material b 
                      ON b.raw_id = a.raw_id where
                      a.ibk_id=$ibk_id and a.ldeleted ='0' ";         
        
            $rupa = $this->db_plc0->query($qupa);
            $rupb = $this->db_plc0->query($qupb)->row_array();
            $echo = '<script type="text/javascript">
                         function submit_ajax(form_id) {
                            return $.ajax({
                                url: $("#"+form_id).attr("action"),
                                type: $("#"+form_id).attr("method"),
                                data: $("#"+form_id).serialize(),
                                success: function(data) {
                                    var o = $.parseJSON(data);
                                    var last_id = o.last_id;
                                    var company_id = 3;
                                    var group_id = o.group_id;
                                    var modul_id = o.modul_id;
                                    var foreign_id = "";
                                    var header = "Info";
                                    var info = "Info";
                                    var url = "'.base_url().'processor/plc/v3/bk/sekunder";                             
                                    if(o.status == true) {
                                        //alert($ibk_id);
                                        $("#alert_dialog_form").dialog("close");
                                        $.get(url+"?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                             $("div#form_upb_daftar").html(data);
                                        });
                                        // $.get(url+"processor/plc/v3/bk/sekunder?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                            // $("div#form_upb_daftar").html(data);
                                            // $("html, body").animate({scrollTop:$("#"+grid).offset().top - 20}, "slow");
                                        // });
                                        
                                    }
                                        _custom_alert("Copy data berhasil",header,info,"grid_upb_daftar", 1, 20000);
                                        reload_grid("grid_upb_daftar");
                                }
                                
                             })
                         }
                     </script>';
            $echo .= '<h1>Copy Komposisi Originator ke Komposisi UPB</h1><br />';
            $echo .= '<form id="form_v3_bk_sekunder_copyOri" action="'.base_url().'processor/plc/v3/bk/sekunder?action=copyOri_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= '<input type="hidden" name="ibk_id" value="'.$this->input->get('upb_id').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <table class="hover_table" cellspacing="0" cellpadding="1" style="width: 80%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
                        <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>Nomor UPB</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nomor'].'</td>
                        </tr>
                        <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7;"><b>Nama Usulan</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nama'].'</td>
                        </tr><tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>NIP Pengusul</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['cnip'].'</td>
                        
                        </tr><tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>Bahan yang akan di copy</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">
                            ';  
                         if ($rupa->num_rows() > 0) {
                            $result = $rupa->result_array();
                            $i=1;
                            foreach($result as $row) {
                                    $echo .='<input type="checkbox" name="ikomp_ori[]" value="'.$row['ikomposisi_id'] .'">
                                    <label for="">'.$row['vnama'].'</label><br>
                                    ';
                                $i++;
                            }
                        }   
            
                $echo .='</td></tr>
                    </table>
                    </br>
            <button type="button" onclick="submit_ajax(\'form_v3_bk_sekunder_copyOri\')">Simpan</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }
        
        function copyOri_process() {
            $team=$this->auth_localnon->my_teams(TRUE);
            $post = $this->input->post();
            $ibk_id =$post['ibk_id'];
            $modul_id =$post['modul_id'];
            $group_id =$post['group_id'];
            $user = $this->auth_localnon->user();
            
            
            $ikomp_ori = array();
            foreach($_POST as $k=>$v) {
                if ($k == 'ikomp_ori') {
                    $ikomp_ori[] = $v; 
                }
            }
            $tes='';
            foreach($ikomp_ori as $value) {
                foreach($value as $k=>$v) {
                    $sql ="select raw_id, ijumlah, vsatuan, ibobot, vfungsi from plc2.plc2_upb_prioritas_komposisi_ori where ikomposisi_id ={$v}";
                    $query = $this->db_plc0->query($sql);
                    $raw_id ='';
                    $ijumlah='';
                    $vsatuan='';
                    $ibobot='';
                    $vketerangan='';
                    if ($query->num_rows() > 0) {
                            $result = $query->result_array();
                            foreach($result as $row) {
                                $raw_id = $row['raw_id'];
                                $ijumlah=$row['ijumlah'];
                                $vsatuan=$row['vsatuan'];
                                $ibobot=$row['ibobot'];
                                $vketerangan=$row['vfungsi'];                                   
                            }
                    }
                    $kor['ibk_id']=$ibk_id;
                    $kor['raw_id'] = $raw_id;
                    $kor['ijumlah'] = $ijumlah;
                    $kor['vsatuan'] = $vsatuan;
                    $kor['ibobot'] = $ibobot;
                    $kor['vketerangan'] = $vketerangan;
                    $this->db_plc0->insert('plc2.plc2_upb_prioritas_komposisi', $kor);
                }   
            }
            
            $data['status']  = true;
            $data['last_id'] = $post['ibk_id'];
            $data['modul_id'] = $modul_id;
            $data['group_id'] = $group_id;
            return json_encode($data);
        }
        
        // copy Komposisi UPB ke Komposisi Originator
        function copyKomp_view() {
            $ibk_id=$this->input->get('upb_id');
            $qupb="select u.vupb_nomor, u.vupb_nama, u.cnip
                        from plc2.plc2_upb_prioritas u where u.ibk_id=$ibk_id";
            $qupa="SELECT  * FROM plc2.plc2_upb_prioritas_komposisi a 
                      INNER JOIN plc2.plc2_raw_material b 
                      ON b.raw_id = a.raw_id where
                      a.ibk_id=$ibk_id and a.ldeleted ='0' ";         
        
            $rupa = $this->db_plc0->query($qupa);
            $rupb = $this->db_plc0->query($qupb)->row_array();
            
            $echo = '<script type="text/javascript">
                         function submit_ajax(form_id) {
                            return $.ajax({
                                url: $("#"+form_id).attr("action"),
                                type: $("#"+form_id).attr("method"),
                                data: $("#"+form_id).serialize(),
                                success: function(data) {
                                    var o = $.parseJSON(data);
                                    var last_id = o.last_id;
                                    var company_id = 3;
                                    var group_id = o.group_id;
                                    var modul_id = o.modul_id;
                                    var foreign_id = "";
                                    var header = "Info";
                                    var info = "Info";
                                    var url = "'.base_url().'processor/plc/v3/bk/sekunder";                             
                                    if(o.status == true) {
                                        
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                $("div#form_upb_daftar").html(data);
                                            });
                                             
                                        
                                    }
                                        _custom_alert("Copy data berhasil ! ",header,info,"grid_upb_daftar", 1, 20000);
                                        reload_grid("grid_upb_daftar");
                                }
                                
                             })
                         }
                     </script>';
            
            
            $echo .= '<h1>Copy Komposisi UPB ke Komposisi Originator</h1><br />';
            $echo .= '<form id="form_v3_bk_sekunder_copyKomp" action="'.base_url().'processor/plc/v3/bk/sekunder?action=copyKomp_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= '<input type="hidden" name="ibk_id" value="'.$this->input->get('upb_id').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <table class="hover_table" cellspacing="0" cellpadding="1" style="width: 80%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
                        <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>Nomor UPB</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nomor'].'</td>
                        </tr>
                        <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7;"><b>Nama Usulan</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nama'].'</td>
                        </tr>
                        <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>NIP Pengusul</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['cnip'].'</td>
                        </tr><tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>Bahan yang akan di copy</b></td>
                            <td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">
                            ';  
                         if ($rupa->num_rows() > 0) {
                            $result = $rupa->result_array();
                            $i=1;
                            foreach($result as $row) {
                                    $echo .='<input type="checkbox" name="ikomp[]" value="'.$row['ikomposisi_id'] .'">
                                    <label for="">'.$row['vnama'].'</label><br>
                                    ';
                                $i++;
                            }
                        }   
            
                $echo .='</td></tr></table>
                    </br>
            <button type="button" onclick="submit_ajax(\'form_v3_bk_sekunder_copyKomp\')">Simpan</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }
        
        function copyKomp_process() {
            $post = $this->input->post();
            $ibk_id =$post['ibk_id'];
            $modul_id =$post['modul_id'];
            $group_id =$post['group_id'];
            $ikomp = array();
            foreach($_POST as $k=>$v) {
                if ($k == 'ikomp') {
                    $ikomp[] = $v; 
                }
            }
            $tes='';
            foreach($ikomp as $value) {
                foreach($value as $k=>$v) {
                    $sql ="select raw_id, ijumlah, vsatuan, ibobot, vketerangan from plc2.plc2_upb_prioritas_komposisi where ikomposisi_id ={$v}";
                    $query = $this->db_plc0->query($sql);
                    $raw_id ='';
                    $ijumlah='';
                    $vsatuan='';
                    $ibobot='';
                    $vketerangan='';
                    if ($query->num_rows() > 0) {
                            $result = $query->result_array();
                            foreach($result as $row) {
                                $raw_id = $row['raw_id'];
                                $ijumlah=$row['ijumlah'];
                                $vsatuan=$row['vsatuan'];
                                $ibobot=$row['ibobot'];
                                $vketerangan=$row['vketerangan'];                                   
                            }
                    }
                    $kor['ibk_id']=$ibk_id;
                    $kor['raw_id'] = $raw_id;
                    $kor['ijumlah'] = $ijumlah;
                    $kor['vsatuan'] = $vsatuan;
                    $kor['ibobot'] = $ibobot;
                    $kor['vfungsi'] = $vketerangan;
                    $this->db_plc0->insert('plc2.plc2_upb_prioritas_komposisi_ori', $kor);
                }   
            }
            
            $data['status']  = true;
            $data['last_id'] = $post['ibk_id'];
            $data['modul_id'] = $modul_id;
            $data['group_id'] = $group_id;
            return json_encode($data);
        }

        function listBox_v3_bk_sekunder_iSubmit($value) {
            if($value==0){$vstatus='Need To Submit';}
            elseif($value==1){$vstatus='Submited';}
            return $vstatus;
        }
        function listBox_v3_bk_sekunder_iapppc($value) {
            if($value==0){$vstatus='Waiting for approval';}
            elseif($value==1){$vstatus='Rejected';}
            elseif($value==2){$vstatus='Approved';}
            return $vstatus;
        }
        function listBox_v3_bk_sekunder_iapppd($value) {
            if($value==0){$vstatus='Waiting for approval';}
            elseif($value==1){$vstatus='Rejected';}
            elseif($value==2){$vstatus='Approved';}
            return $vstatus;
        }
        function listBox_v3_bk_sekunder_iappqa($value) {
            if($value==0){$vstatus='Waiting for approval';}
            elseif($value==1){$vstatus='Rejected';}
            elseif($value==2){$vstatus='Approved';}
            return $vstatus;
        }
        function listBox_v3_bk_sekunder_iappbd($value) {
            if($value==0){$vstatus='Waiting for approval';}
            elseif($value==1){$vstatus='Rejected';}
            elseif($value==2){$vstatus='Approved';}
            return $vstatus;
        }

        function listBox_Action($row, $actions) {
            $peka = $row->ibk_id;
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


        function insertBox_v3_bk_sekunder_form_detail($field,$id){
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
                var sebelum = $("label[for=\'v3_bk_sekunder_form_detail\']").parent();
                $("label[for=\'v3_bk_sekunder_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/plc/v3/bk/sekunder?action=getFormDetail&formaction=addnew&'.$g.'",
                    type: "post",
                    data: ibk_id=0,
                    success: function(data) {
                        var o = $.parseJSON(data);
                        sebelum.html(o.html);
                    }       
                });
            </script>';
            return $return;
        }

        function updateBox_v3_bk_sekunder_form_detail($field,$id,$value,$rowData){
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
                var sebelum = $("label[for=\'v3_bk_sekunder_form_detail\']").parent();
                $("label[for=\'v3_bk_sekunder_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/plc/v3/bk/sekunder?action=getFormDetail&formaction=update&'.$g.'",
                    type: "post",
                    data: ibk_id=0,
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
                                        var url = "'.base_url().'processor/plc/v3_bk_sekunder";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_bk_sekunder").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_bk_sekunder");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_v3_bk_sekunder_approve" action="'.base_url().'processor/plc/v3_bk_sekunder?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_bk_sekunder_approve\')">Approve</button>';
                    
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
                                        var url = "'.base_url().'processor/plc/v3_bk_sekunder";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_bk_sekunder").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_bk_sekunder");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_v3_bk_sekunder_confirm" action="'.base_url().'processor/plc/v3_bk_sekunder?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_bk_sekunder_confirm\')">Confirm</button>';
                    
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
                                var remark = $("#v3_bk_sekunder_remark").val();
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
                                        var url = "'.base_url().'processor/plc/v3_bk_sekunder";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_bk_sekunder").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_bk_sekunder");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_v3_bk_sekunder_reject" action="'.base_url().'processor/plc/v3_bk_sekunder?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark" id="reject_v3_bk_sekunder_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_bk_sekunder_reject\')">Reject</button>';
                    
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
                $data['last_id'] = $post['ibk_id'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }



    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        if($postData['isdraft'] == true){
            $postData['iSubmit'] = 0;
        } else {
            $postData['iSubmit'] = 1;
        } 
        $postData['iJenis_bk'] = 2;
        return $postData;

    }
    function before_update_processor($row, $postData) { 
        if($postData['isdraft'] == true){
            $postData['iSubmit'] = 0;
        } else {
            $postData['iSubmit'] = 1;
        } 
        $postData['iJenis_bk'] = 2;
        return $postData;
    }    

    function after_insert_processor($fields, $id, $postData) { 
        $post = $this->input->post();
        $modul_id = $this->modul_id;

        //save kemasan sekunder
        $jenisbk_sekunder = $post['jenisbk_sekunder']; 
        foreach($jenisbk_sekunder as $k => $v) {
            if(!empty($v)) {
                $idet['ibk_id'] = $id;
                $idet['ijenis_bk_id'] = $jenisbk_sekunder[$k];
                $this->db->insert('plc2.plc2_upb_bk_sekunder_detail', $idet);
            }
        }  

        //save kemasan tersier
        $jenisbk_sekunder = $post['jenisbk_tersier']; 
        foreach($jenisbk_sekunder as $k => $v) {
            if(!empty($v)) {
                $idet['ibk_id'] = $id;
                $idet['ijenis_bk_id'] = $jenisbk_sekunder[$k];
                $this->db->insert('plc2.plc2_upb_bk_tersier_detail', $idet);
            }
        } 

        if ($postData['iSubmit'] == 1){
            $this->lib_plc->InsertActivityModule($this->ViewUPB($id),$modul_id,$id,1,1);
        } 
    }

    function after_update_processor($fields, $id, $postData) { 
        //Example After Update
        $modul_id = $this->modul_id;
        $post = $this->input->post(); 

        //update kemasan sekunder
        $jenisbk_sekunder = $post['jenisbk_sekunder']; 
        $sekunderRows = $this->db->get_where('plc2.plc2_upb_bk_sekunder_detail', array('ibk_id'=>$id, 'ldeleted'=>0))->result_array(); 
        foreach($sekunderRows as $k => $v) {
            if(in_array($v['ibk_sekunder_id'], $jenisbk_sekunder)) {
                $this->db->where('ibk_sekunder_id', $v['ibk_sekunder_id']);
                $key = array_search($v['ibk_sekunder_id'], $jenisbk_sekunder);
                $this->db->update('plc2.plc2_upb_bk_sekunder_detail', array('iJenis_bk'=>$jenisbk_sekunder[$key]));
            } else {
                $this->db->where('ibk_sekunder_id', $v['ibk_sekunder_id']);
                $this->db->update('plc2.plc2_upb_bk_sekunder_detail', array('ldeleted'=>1));
            }
        }

        foreach($jenisbk_sekunder as $k => $v) {
            if(!empty($v)) {
                $idet['ibk_id'] = $id;
                $idet['ijenis_bk_id'] = $jenisbk_sekunder[$k];
                $this->db->insert('plc2.plc2_upb_bk_sekunder_detail', $idet);
            }
        } 

        //update kemasan tersier
        $jenisbk_tersier = $post['jenisbk_tersier']; 
        $sekunderRows = $this->db->get_where('plc2.plc2_upb_bk_tersier_detail', array('ibk_id'=>$id, 'ldeleted'=>0))->result_array(); 
        foreach($sekunderRows as $k => $v) {
            if(in_array($v['ibk_tersier_id'], $jenisbk_tersier)) {
                $this->db->where('ibk_tersier_id', $v['ibk_tersier_id']);
                $key = array_search($v['ibk_tersier_id'], $jenisbk_tersier);
                $this->db->update('plc2.plc2_upb_bk_tersier_detail', array('iJenis_bk'=>$jenisbk_tersier[$key]));
            } else {
                $this->db->where('ibk_tersier_id', $v['ibk_tersier_id']);
                $this->db->update('plc2.plc2_upb_bk_tersier_detail', array('ldeleted'=>1));
            }
        }

        foreach($jenisbk_tersier as $k => $v) {
            if(!empty($v)) {
                $idet['ibk_id'] = $id;
                $idet['ijenis_bk_id'] = $jenisbk_tersier[$k];
                $this->db->insert('plc2.plc2_upb_bk_tersier_detail', $idet);
            }
        }  

        if ($postData['iSubmit'] == 1){
            $this->lib_plc->InsertActivityModule($this->ViewUPB($id),$modul_id,$id,1,1);
        }

    }

    function manipulate_insert_button($buttons) { 
        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $data['upload'] = 'uploadCustomGrid';
        $js = $this->load->view('js/standard_js', $data, TRUE);
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="v3_bk_sekunder_frame" id="v3_bk_sekunder_frame" height="0" width="0"></iframe>';
        
        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'v3_bk_sekunder\', \' '.base_url().'processor/plc/v3_bk_sekunder?draft=true \',this,true )"  id="button_save_draft_v3_bk_sekunder"  class="ui-button-text icon-save" >Save As Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\'v3_bk_sekunder\', \' '.base_url().'processor/plc/v3_bk_sekunder?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_save_submit_v3_bk_sekunder"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

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
        $peka=$rowData['ibk_id'];


        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $data['upload'] = 'uploadCustomGrid';
        $js = $this->load->view('js/standard_js', $data, TRUE);
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="v3_bk_sekunder_frame" id="v3_bk_sekunder_frame" height="0" width="0"></iframe>';
        
        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        }
        else{ 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_bk_sekunder\', \' '.base_url().'processor/plc/v3_bk_sekunder?draft=true \',this,true )"  id="button_update_draft_v3_bk_sekunder"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$peka);
                    $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,$peka); 

                    foreach ($activities as $act) {
                        $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_bk_sekunder\', \' '.base_url().'processor/plc/v3_bk_sekunder?draft=true \',this,true )"  id="button_update_draft_v3_bk_sekunder"  class="ui-button-text icon-save" >Update as Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\'v3_bk_sekunder\', \' '.base_url().'processor/plc/v3_bk_sekunder?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_v3_bk_sekunder"  class="ui-button-text icon-save" >Update &amp; Submit</button>';



                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_bk_sekunder?action=approve&iM_modul_activity='.$act['iM_modul_activity'].'&'.$this->main_table_pk.'='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_bk_sekunder"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_bk_sekunder?action=reject&iM_modul_activity='.$act['iM_modul_activity'].'&'.$this->main_table_pk.'='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_v3_bk_sekunder"  class="ui-button-text icon-save" >Reject</button>';

                        $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_bk_sekunder?action=confirm&iM_modul_activity='.$act['iM_modul_activity'].'&'.$this->main_table_pk.'='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_bk_sekunder"  class="ui-button-text icon-save" >Confirm</button>';

                        

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
                                $magrAndCief = $this->lib_plc->managerAndChiefIn($this->teamID);

                                // jika activitynya approval keatas
                                if($act['iType'] > 1){
                                    // nip harus ada pada nip manager atau chief dari Dept, atau nip yang ditunjuk di table modul activity
                                    $arrmgrAndCief = explode(',', $magrAndCief);
                                    if(in_array($this->user->gNIP, $arrmgrAndCief) ||in_array($this->user->gNIP, $arrNipAssign)){
                                        
                                    }else{
                                        $sButton = '<span style="color:red;" title="">You\'re not Authorized to Approve</span>';
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
        $upb = $this->db->get_where('plc2.'.$this->main_table, array($this->main_table_pk=>$id, 'ldeleted'=>0))->result_array();
        $arrUPB = array();
        foreach ($upb as $u) {
            array_push($arrUPB, $u['iupb_id']);
        }
        return $arrUPB;
    }

}
