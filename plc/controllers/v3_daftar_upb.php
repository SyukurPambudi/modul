 
<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_daftar_upb extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('auth');
        $this->load->library('auth_localnon');
        $this->load->library('lib_plc');
        $this->db = $this->load->database('hrd',false, true);
        $this->user = $this->auth->user();
        $this->modul_id = $this->input->get('modul_id');

        $this->iModul_id = $this->lib_plc->getIModulID($this->input->get('modul_id'));

        $this->main_table='plc2_upb';
        $this->main_table_pk='iupb_id';

        $this->team = $this->lib_plc->hasTeam($this->user->gNIP);
        $this->teamID = $this->lib_plc->hasTeamID($this->user->gNIP);

        $isAdmin = $this->lib_plc->isAdmin($this->user->gNIP);
        $this->isAdmin = $isAdmin;
        $this->url = 'v3_daftar_upb';
        $this->urlpath = 'plc/'.str_replace("_","/", $this->url);
        //$skemaPK = $this->lib_utilitas->getSkemaPK($this->sess_auth->gNIP);


    }

    function index($action = '') {
        $action = $this->input->get('action');
        //Bikin Object Baru Nama nya $grid      
        $grid = new Grid;
        $grid->setTitle('Daftar UPB');
        $grid->setTable('plc2.plc2_upb');      
        $grid->setUrl('v3_daftar_upb');

        //List Table
        $grid->addList('vupb_nomor','vupb_nama','vgenerik','iteambusdev_id','ihold','ikategori_id','ikategoriupb_id','isediaan_id','iteampd_id','ibe','iappbusdev' ,'iappdireksi', 'iSubmit','istatus_launching','iCopy_brand','ineed_prareg');
        $grid->setSortBy('iupb_id');
        $grid->setSortOrder('DESC');  

        //List field
        $grid->addFields('form_detail'); 

        //Setting Grid Width Name 
        /*
        Kamu bisa merubah nama label dari sini, Contoh :
        $grid->setLabel('nama field','nama field yang akan diubah');

        */

        $grid->setWidth('iCopy_brand', '100');
        $grid->setAlign('iCopy_brand', 'center');
        $grid->setLabel('iCopy_brand','UPB Copy Brand');

        $grid->setWidth('iupb_id', '100');
        $grid->setAlign('iupb_id', 'left');
        $grid->setLabel('iupb_id','No UPB');
    
        $grid->setWidth('cPIC', '100');
        $grid->setAlign('cPIC', 'left');
        $grid->setLabel('cPIC','PIC Study Literatur');
    
        $grid->setWidth('dmulai_study', '100');
        $grid->setAlign('dmulai_study', 'left');
        $grid->setLabel('dmulai_study','Tgl Mulai Study Literatur');
    
        $grid->setWidth('dselesai_study', '100');
        $grid->setAlign('dselesai_study', 'left');
        $grid->setLabel('dselesai_study','Tgl Selesai Study Literatur ');
    
        $grid->setWidth('iuji_mikro', '100');
        $grid->setAlign('iuji_mikro', 'left');
        $grid->setLabel('iuji_mikro','Uji Mikro FG');
    
        $grid->setWidth('ijenis_sediaan', '100');
        $grid->setAlign('ijenis_sediaan', 'left');
        $grid->setLabel('ijenis_sediaan','Jenis Sediaan');
    
        $grid->setWidth('vkompedial', '100');
        $grid->setAlign('vkompedial', 'left');
        $grid->setLabel('vkompedial','Kompedial yang digunakan');
    
        $grid->setWidth('iapppd', '100');
        $grid->setAlign('iapppd', 'left');
        $grid->setLabel('iapppd','iapppd ');
    
        $grid->setWidth('file', '100');
        $grid->setAlign('file', 'left');
        $grid->setLabel('file','File Study Literatur');

        $grid->setWidth('plc2_upb.vupb_nomor', '100');
        $grid->setAlign('plc2_upb.vupb_nomor', 'left');
        $grid->setLabel('plc2_upb.vupb_nomor','No UPB');

        
        /*basic required start*/
            $grid->setQuery('plc2.plc2_upb.ldeleted', 0);
            $grid->setQuery('plc2.plc2_upb.iKill', 0);
            $grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
        /*basic required finish*/

        
    
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
        $grid->setAlign('vupb_nomor', 'center');
        $grid->setWidth('vupb_nomor', '100');
        $grid->setWidth('ikategoriupb_id', '120');
        $grid->setWidth('ibe', '100');
        $grid->setWidth('iteampd_id', '150');
        $grid->setWidth('vupb_nama', '250');
        $grid->setWidth('vgenerik', '250');
        $grid->setWidth('ineed_prareg', '-250');
        $grid->setRequired('dosis','ipatent','tinfo_paten','patent_year','vCopy_Product','komposisi_upb','idevelop','iregister','vupb_nama','vgenerik','vkat_originator','iteambusdev_id','iteampd_id','iteamqa_id','iteamqc_id','iteamad_id','ikategori_id','ikategoriupb_id','isediaan_id','ibe','itipe_id');
        $grid->setLabel('iappbusdev' ,'App Busdev');
        $grid->setLabel('iappdireksi' ,'App Direksi');
        $grid->setLabel('iSubmit' ,'Status Submit');
        $grid->setLabel('vupb_nomor', 'No. UPB');
        $grid->setLabel('tUpbCreatedAt', 'Tanggal UPB');
        $grid->setLabel('ttanggal', 'Tanggal UPB');
        $grid->setLabel('vUpbName', 'Nama Usulan');
        $grid->setLabel('vupb_nama', 'Nama Usulan');
        //$grid->setLabel('vGenerik', 'Nama Generik');
        $grid->setLabel('vgenerik', 'Nama Generik');
        $grid->setLabel('txtIndication', 'Indikasi');
        $grid->setLabel('tindikasi', 'Indikasi');
        $grid->setLabel('idplc2_m_mnf_category', 'Kategori Produk');        
        $grid->setLabel('ikategori_id', 'Kategori Produk');
        $grid->setLabel('idplc2_m_upb_category', 'Kategori UPB');
        $grid->setLabel('ikategoriupb_id', 'Kategori UPB');
        $grid->setLabel('iGroup_produk', 'Group Produk');
        
        $grid->setLabel('idplc2_m_mnf_sediaan', 'Sediaan Produk');
        $grid->setLabel('isediaan_id', 'Sediaan Produk');
        $grid->setLabel('iJenis_sediaan', 'Jenis Sediaan');
        $grid->setLabel('idplc2_biz_process_type', 'Type Produk');
        $grid->setLabel('itipe_id', 'Type Produk');
        $grid->setLabel('iBeType', 'Tipe BE');
        $grid->setLabel('ibe', 'Tipe BE');
        $grid->setLabel('fHppTarget', 'Target HPP');
        $grid->setLabel('vhpp_target', 'Target HPP');
        $grid->setLabel('txtUniquenessOf', 'Keunggulan Produk');
        $grid->setLabel('tunique', 'Keunggulan Produk');
        $grid->setLabel('txtPackingSpec', 'Spesifikasi Kemasan');
        $grid->setLabel('tpacking', 'Spesifikasi Kemasan');
        $grid->setLabel('tPraRegister', 'Estimasi Praregistrasi');
        $grid->setLabel('ttarget_prareg', 'Estimasi Praregistrasi');
        $grid->setLabel('iPatent', 'Tipe Hak Patent');
        $grid->setLabel('ipatent', 'Tipe Hak Patent');
        $grid->setLabel('tInfoPatent', 'Informasi Hak Patent');
        $grid->setLabel('tinfo_paten', 'Informasi Hak Patent');
        $grid->setLabel('vPatentYear', 'Patent Exp.');
        $grid->setLabel('patent_year', 'Patent Exp.');
        $grid->setLabel('imaster_delivery','Master Delivery');
        
        $grid->setLabel('iteambusdev_id', 'Team Busdev');
        $grid->setLabel('iteampd_id', 'Team PD');
        $grid->setLabel('iteamqa_id', 'Team QA');
        $grid->setLabel('iteamqc_id', 'Team QC');
        $grid->setLabel('iteamad_id', 'Team AD');
        
        $grid->setLabel('iteammarketing_id', 'Team Marketing');
        
        $grid->setLabel('iRegisterFor', 'Registrasi Untuk');
        $grid->setLabel('iregister', 'Registrasi Untuk');
        $grid->setLabel('iDevelopBy', 'Produksi oleh');
        $grid->setLabel('idevelop', 'Produksi oleh');
        $grid->setLabel('tmemo_busdev', 'Catatan Busdev');
        $grid->setLabel('tmemo', 'Catatan Busdev');
        $grid->setLabel('isCancel', 'Cancel UPB');
        $grid->setLabel('ihold', 'Cancel UPB');
        $grid->setLabel('dokumen_hold', 'Dokumen cancel UPB');
        $grid->setLabel('vOriginator', 'Originator');
        $grid->setLabel('voriginator', 'Originator');
        $grid->setLabel('vkat_originator', 'Kategori Originator');
        $grid->setLabel('vOriginatorPrice', 'Harga Originator');
        $grid->setLabel('voriginator_price', 'Harga Originator');
        $grid->setLabel('vOriginatorKemas', 'Kemasan Originator');
        $grid->setLabel('voriginator_kemas', 'Kemasan Originator');
        $grid->setLabel('isRawCompleted', 'Kelengkapan Sample Raw Material');
        $grid->setLabel('iPatent', 'Tipe Hak Patent');
        $grid->setLabel('ipatent', 'Tipe Hak Patent');
        $grid->setLabel('tInfoPatent', 'Informasi Hak Patent');
        $grid->setLabel('tinfo_paten', 'Informasi Hak Patent');
        $grid->setLabel('vPatentYear', 'Patent Exp.');
        $grid->setLabel('patent_year', 'Patent Exp.');
        $grid->setLabel('dosis', 'Kekuatan / Dosis UPB');
        $grid->setLabel('iappbusdev', 'Approval Busdev');
        $grid->setLabel('iappdireksi', 'Approval Direksi');
        $grid->setLabel('istatus_launching', 'Status Launching');
        $grid->setLabel('ineed_prareg', 'Butuh Prareg');
        
        //tambahan copy resep
        $grid->setLabel('vCopyProduct', 'Copy Product ke-');
        $grid->setLabel('vCopy_Product', 'Copy Product ke-');

        $grid->setLabel('vsediaan', 'Sediaan');
        
        //end       
        
        $grid->setRelation('ikategoriupb_id','plc2.plc2_upb_master_kategori_upb','ikategori_id','vkategori','upb_kat','inner',array('ldeleted'=>0),array('upb_kat'=>'asc'));
        $grid->setRelation('ikategori_id','hrd.mnf_kategori','ikategori_id','vkategori','mnf_kat','inner',array('ldeleted'=>0),array('mnf_kat'=>'asc'));
        $grid->setRelation('isediaan_id','hrd.mnf_sediaan','isediaan_id','vsediaan','','inner',array('ldeleted'=>0),array('vsediaan'=>'asc'));
        $grid->setRelation('itipe_id','plc2.plc2_biz_process_type','idplc2_biz_process_type','vName','nama_type','inner',array('isDeleted'=>'0'),array('idplc2_biz_process_type'=>'asc'));
        
        $grid->setSearch('vupb_nomor','iteambusdev_id','vupb_nama','vgenerik','iteampd_id','ikategori_id','ikategoriupb_id','isediaan_id','ibe','ineed_prareg');//,'imaster_delivery');
        
        $grid->changeFieldType('iSubmit','combobox','',array('0'=>'Draft',1=>'Submitted'));
        $grid->changeFieldType('iJenis_sediaan','combobox','',array(''=>'--Select--',1=>'Steril', 2=>'Non Setil'));
        $grid->changeFieldType('istatus_launching','combobox','',array(''=>'--Select--',0=>'On Progress', 1=>'Batal',2=>'Launching'));
        //$grid->changeFieldType('iteampd_id','combobox','',array(''=>'--Select--',1=>'Gunung Putri', 2=>'Ulujami PD', 3=>'Etercon'));
        $grid->changeFieldType('isCancel','combobox','',array(0=>'Tidak', 1=>'Iya'));
        $grid->changeFieldType('istatus','combobox','',array(''=>'--Select--',0=>'Draft - Need to be published by Busdev', 1=>'Need to be approved by BDM', 3=>'Need to be approved by Direksi', 7=>'Has been Approved (final)', 6=>'Rejected'));
        $grid->changeFieldType('ihold','combobox','',array(0=>'Tidak', 1=>'Iya'));
        $grid->changeFieldType('ineed_prareg','combobox','',array(''=>'--Select--',0=>'Tidak', 1=>'Ya'));
        $grid->changeFieldType('ibe','combobox','',array(''=>'--Select--',1=>'BE', 2=>'Non BE'));
        $grid->changeFieldType('ipatent','combobox','',array(''=>'--Select--',1=>'Indonesia', 2=>'International', 3=>'Off Patent'));
        $grid->changeFieldType('iregister','combobox','',array(''=>'--Select--',3=>'PT. Novell Pharm', 5=>'PT. Etercon Pharm'));
        $grid->changeFieldType('iDevelopBy','combobox','',array(''=>'--Select--',3=>'PT. Novell Pharm', 5=>'PT. Etercon Pharm', 100=>'Toll'));
        $grid->changeFieldType('idevelop','combobox','',array(''=>'--Select--',3=>'PT. Novell Pharm', 5=>'PT. Etercon Pharm', 100=>'Toll'));
        $grid->changeFieldType('isRawCompleted','combobox','',array(''=>'--Select--',1=>'Tidak Lengkap', 2=>'Lengkap'));

    
        $grid->setGridView('grid');


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
                            
                            $data_field['logged_nip']= $this->user->gNIP; 

                            $data_field['iM_jenis_field']= $form_field['iM_jenis_field'] ;
                            $data_field['get']= $get;
                            $data_field['form_field']= $form_field;

                            $controller = 'v3_daftar_upb';
                            $data_field['id']= $controller.'_'.$form_field['vNama_field'];
                            //$data_field['field']= $controller.'_'.$form_field['vNama_field'] ;
                            $data_field['field']= $form_field['vNama_field'] ;

                            $data_field['act']= $get['act'] ;
                            $data_field['hasTeam']= $this->team ;
                            $data_field['hasTeamID']= $this->teamID ;
                            $data_field['isAdmin']= $this->isAdmin ;


                            /*untuk keperluad file upload*/
                            if($form_field['iM_jenis_field'] == 7){
                                $data_field['tabel_file']= $form_field['vTabel_file'] ;
                                $data_field['tabel_file_pk']= $this->main_table_pk;
                                $data_field['tabel_file_pk_id']= $form_field['vTabel_file_pk_id'] ;

                                $path = 'files/plc/dok_tambah';
                                $createname_space = 'v3_daftar_upb';
                                $tempat = 'dok_tambah';
                                $FOLDER_APP = 'plc';

                                $data_field['path'] = $path;
                                $data_field['FOLDER_APP'] = $FOLDER_APP;
                                $data_field['createname_space'] = $createname_space;
                                $data_field['tempat'] = $tempat;

                                if ($form_field['iRequired']==1) {
                                    $data_field['field_required']= 'required';
                                }else{
                                    $data_field['field_required']= '';
                                }


                            }
                            /*untuk keperluad file upload*/

                            $data_field['iM_modul_fileds'] = $form_field['iM_modul_fileds'] ;

                            if($get['formaction']=='update'){
                                $id = $get['id']; 

                                $sqlGetMainvalue= 'select * from plc2.'.$this->main_table.' where lDeleted=0 and '.$this->main_table_pk.'= '.$id.'   ';
                                $dataHead = $this->db->query($sqlGetMainvalue)->row_array();

                                $data_field['dataHead']= $dataHead;
                                $data_field['main_table_pk']= $this->main_table_pk;
                                
                                if($form_field['iM_jenis_field'] == 6){
                                    $data_field['vSource_input']= $form_field['vSource_input_edit'] ;
                                }else{
                                    $data_field['vSource_input']= $form_field['vSource_input'] ;
                                }
                                
                                
                                
                                $return_field = $this->load->view('partial/v3_form_detail_update',$data_field,true);    
                            }else{
                                $data_field['vSource_input']= $form_field['vSource_input'] ;

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

                    $hate_emel .= '<input type="hidden" name="isdraft" id="isdraft">';
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

            case 'copyUPB':
				echo $this->copyUPB_view();
                break;
            case 'copyUPB_process':
				echo $this->copyUPB_process();
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
            case 'cancel':
                    echo $this->cancel_view();
                    break;
            case 'cancel_process':
                    echo $this->cancel_process();
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
            default:
                    $grid->render_grid();
                    break;
        }
    }

    	// copy UPB
        function copyUPB_view() {
            $iupb_id=$this->input->get('upb_id');
            $qupb="select u.vupb_nomor, u.vupb_nama, u.cnip
                        from plc2.plc2_upb u where u.iupb_id=$iupb_id";
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
                                    var group_id = o.group_id;
                                    var modul_id = o.modul_id;
                                    var company_id = o.company_id;
                                    var header = "Info";
                                    var info = "Info";
                                    var url = "'.base_url().'processor/plc/v3/daftar/upb";								
                                    if(o.status == true) {
                                        $.get(url+"?action=update&foreign_key=0&company_id="+company_id+"&id="+last_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                $("div#form_v3_daftar_upb").html(data);
                                        });
                                    }
                                        _custom_alert(o.message,header,info, "v3_daftar_upb", 1, 20000);
                                        $("#grid_v3_daftar_upb").trigger("reloadGrid");
                                        $("#alert_dialog_form").dialog("close");
                                }
                                
                            })
                        }
                    </script>';
            $echo .= '<h1>Copy UPB</h1><br />';
            $echo .= '<form id="form_daftar_upb_copyUPB" action="'.base_url().'processor/plc/v3/daftar/upb?action=copyUPB_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= '<input type="hidden" name="iupb_id" value="'.$this->input->get('upb_id').'" />
                    <input type="hidden" name="type" value="'.$this->input->get('type').'" />
                    <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                    <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                    <input type="hidden" name="company_id" value="'.$this->input->get('company_id').'" />
                    <table class="hover_table" cellspacing="0" cellpadding="1" style="width: 45%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
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
                        </tr>
                    </table>
                    </br>
            <button type="button" onclick="submit_ajax(\'form_daftar_upb_copyUPB\')">Simpan</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }
        
        function copyUPB_process() {
            $team=$this->auth_localnon->my_teams(TRUE);
            $post = $this->input->post();
            $iupb_id =$post['iupb_id'];
            $user = $this->auth_localnon->user();
            
            $qupb="select *	from plc2.plc2_upb u where u.iupb_id=$iupb_id";
            $rupb = $this->db_plc0->query($qupb)->row_array();
            
            $query = "SELECT MAX(iupb_id) std FROM plc2.plc2_upb";
            $rs = $this->db_plc0->query($query)->row_array();
            $nomor = intval($rs['std']) + 1;
            $nomor = "U".str_pad($nomor, 5, "0", STR_PAD_LEFT);
            
            //insert table upb
            $ins['vupb_nomor'] = $nomor;
            $ins['vupb_nama'] = $rupb['vupb_nama']; 
            $ins['cnip'] = $this->user->gNIP;
            $ins['ttanggal'] = date('Y-m-d');
            $ins['tunique'] = $rupb['tunique']; 
            $ins['tpacking'] = $rupb['tpacking']; 
            $ins['ikategori_id'] = $rupb['ikategori_id']; 
            $ins['ikategoriupb_id'] = $rupb['ikategoriupb_id']; 
            $ins['isediaan_id'] = $rupb['isediaan_id']; 
            $ins['ipatent'] = $rupb['ipatent']; 
            $ins['tinfo_paten'] = $rupb['tinfo_paten']; 
            $ins['patent_year'] = $rupb['patent_year']; 
            $ins['ibe'] = $rupb['ibe']; 
            $ins['iuji_mikro'] = $rupb['iuji_mikro']; 
            $ins['itipe_id'] = $rupb['itipe_id']; 
            $ins['voriginator'] = $rupb['voriginator']; 
            $ins['voriginator_price'] = $rupb['voriginator_price']; 
            $ins['voriginator_kemas'] = $rupb['voriginator_kemas']; 
            $ins['vgenerik'] = $rupb['vgenerik']; 
            $ins['tindikasi'] = $rupb['tindikasi']; 
            $ins['vhpp_target'] = $rupb['vhpp_target']; 
            $ins['idevelop'] = $rupb['idevelop']; 
            $ins['iregister'] = $rupb['iregister']; 
            $ins['iteambusdev_id'] = $team[0]; 
            $ins['iteampd_id'] = $rupb['iteampd_id']; 
            $ins['iteamqa_id'] = $rupb['iteamqa_id']; 
            $ins['iteamqc_id'] = $rupb['iteamqc_id']; 
            $ins['iteammarketing_id'] = $rupb['iteammarketing_id']; 
            $ins['txtDocBB'] = $rupb['txtDocBB']; 
            $ins['txtDocSM'] = $rupb['txtDocSM']; 
            $ins['iCompanyId'] = $rupb['iCompanyId']; 
            $ins['vCopy_Product'] = $rupb['vCopy_Product']; 	
            $ins['dosis'] = $rupb['dosis']; 
            $ins['ttarget_prareg'] = $rupb['ttarget_prareg']; 
            $ins['tmemo_busdev'] = $rupb['tmemo_busdev']; 
            $ins['istatus'] =0; //draft need to be published 
            $ins['ihold'] = 0; 
            $this->db_plc0->insert('plc2.plc2_upb', $ins);
            
            $insertId=$this->db_plc0->insert_id();
            
            /*  insert  dokumen bb  */
            if(isset($rupb['txtDocBB'])){
                // if(($postData['kom_bahan_id'][0])!=""){
                    $valtemp = explode(',', $rupb['txtDocBB']);
                    foreach($valtemp as $k=>$v){
                        $indokbb['iupb_id']=$insertId;
                        $indokbb['idoc_id']=$v;
                        $indokbb['ldeleted']=0;
                        $this->db_plc0->insert('plc2.plc2_upb_detail_dokumen_bb', $indokbb);
                    }
                    //exit;
                // }
            }

            /* end of insert*/
            /*  insert  dokumen sm  */
            if(isset($rupb['txtDocSM'])){
                // if(($postData['kom_bahan_id'][0])!=""){
                    $valtemp = explode(',', $rupb['txtDocSM']);
                    foreach($valtemp as $k=>$v){
                        $indoksm['iupb_id']=$insertId;
                        $indoksm['idoc_id']=$v;
                        $indoksm['ldeleted']=0;
                        $this->db_plc0->insert('plc2.plc2_upb_detail_dokumen_sm', $indoksm);
                    }
                    //exit;
                // }
            }
            /* end of insert*/
            
            /*  insert  komposisi upb */
            $query_ku = "select * from plc2.plc2_upb_komposisi where ldeleted=0 and iupb_id ='".$post['iupb_id']."' order by ikomposisi_id";
            $rows_ku = $this->db_plc0->query($query_ku)->result_array();
        
            if($this->db_plc0->query($query_ku)->num_rows() > 0){
                foreach($rows_ku as $k=>$v){
                    $kom['iupb_id']=$insertId;
                    $kom['raw_id'] = $v['raw_id'];
                    $kom['ijumlah'] = $v['ijumlah'];
                    $kom['vsatuan'] = $v['vsatuan'];
                    $kom['ibobot'] = $v['ibobot'];
                    $kom['vketerangan'] = $v['vketerangan'];
                    $this->db_plc0->insert('plc2.plc2_upb_komposisi', $kom);
                }
                //exit;
            }
            
            /*  insert  komposisi originator */
            $query_ko = "select * from plc2.plc2_upb_komposisi_ori where ldeleted=0 and iupb_id ='".$post['iupb_id']."' order by ikomposisi_id";
            $rows_ko = $this->db_plc0->query($query_ko)->result_array();
            
            if($this->db_plc0->query($query_ko)->num_rows() > 0){
                foreach($rows_ko as $k=>$v){
                    $kor['iupb_id']=$insertId;
                    $kor['raw_id'] = $v['raw_id'];
                    $kor['ijumlah'] = $v['ijumlah'];
                    $kor['vsatuan'] = $v['vsatuan'];
                    $kor['ibobot'] = $v['ibobot'];
                    $kor['vfungsi'] = $v['vfungsi'];
                    $this->db_plc0->insert('plc2.plc2_upb_komposisi_ori', $kor);
                }
                //exit;
            }
            
            $data['status']  = true;
            $data['last_id'] = $insertId;
            $data['group_id'] = $post['group_id'];
            $data['modul_id'] = $post['modul_id'];
            $data['company_id'] = $post['company_id'];
            $data['message'] = 'Copy UPB Berhasil !';
            return json_encode($data);
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


        function gethistkomposisi(){
            $raw_id=$_POST['raw_id'];
            $data = array();
            $row_array = '';
            $sql2 = "select b.vupb_nomor 
                    from plc2.plc2_upb_komposisi a 
                    join plc2.plc2_upb b on b.iupb_id=a.iupb_id
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
            $iupb_id=$this->input->get('upb_id');
            $qupb="select u.vupb_nomor, u.vupb_nama, u.cnip
                        from plc2.plc2_upb u where u.iupb_id=$iupb_id";
            $qupa="SELECT  * FROM plc2.plc2_upb_komposisi_ori a 
                      INNER JOIN plc2.plc2_raw_material b 
                      ON b.raw_id = a.raw_id where
                      a.iupb_id=$iupb_id and a.ldeleted ='0' ";         
        
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
                                    var url = "'.base_url().'processor/plc/v3/daftar/upb";                             
                                    if(o.status == true) {
                                        //alert($iupb_id);
                                        $("#alert_dialog_form").dialog("close");
                                        $.get(url+"?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                             $("div#form_v3_daftar_upb").html(data);
                                        });
                                        // $.get(url+"processor/plc/v3/daftar/upb?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                            // $("div#form_v3_daftar_upb").html(data);
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
            $echo .= '<form id="form_v3_daftar_upb_copyOri" action="'.base_url().'processor/plc/v3/daftar/upb?action=copyOri_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= '<input type="hidden" name="iupb_id" value="'.$this->input->get('upb_id').'" />
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
            <button type="button" onclick="submit_ajax(\'form_v3_daftar_upb_copyOri\')">Simpan</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }
        
        function copyOri_process() {
            $team=$this->auth_localnon->my_teams(TRUE);
            $post = $this->input->post();
            $iupb_id =$post['iupb_id'];
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
                    $sql ="select raw_id, ijumlah, vsatuan, ibobot, vfungsi from plc2.plc2_upb_komposisi_ori where ikomposisi_id ={$v}";
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
                    $kor['iupb_id']=$iupb_id;
                    $kor['raw_id'] = $raw_id;
                    $kor['ijumlah'] = $ijumlah;
                    $kor['vsatuan'] = $vsatuan;
                    $kor['ibobot'] = $ibobot;
                    $kor['vketerangan'] = $vketerangan;
                    $this->db_plc0->insert('plc2.plc2_upb_komposisi', $kor);
                }   
            }
            
            $data['status']  = true;
            $data['last_id'] = $post['iupb_id'];
            $data['modul_id'] = $modul_id;
            $data['group_id'] = $group_id;
            return json_encode($data);
        }
        
        // copy Komposisi UPB ke Komposisi Originator
        function copyKomp_view() {
            $iupb_id=$this->input->get('upb_id');
            $qupb="select u.vupb_nomor, u.vupb_nama, u.cnip
                        from plc2.plc2_upb u where u.iupb_id=$iupb_id";
            $qupa="SELECT  * FROM plc2.plc2_upb_komposisi a 
                      INNER JOIN plc2.plc2_raw_material b 
                      ON b.raw_id = a.raw_id where
                      a.iupb_id=$iupb_id and a.ldeleted ='0' ";         
        
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
                                    var url = "'.base_url().'processor/plc/v3/daftar/upb";                             
                                    if(o.status == true) {
                                        
                                        $("#alert_dialog_form").dialog("close");
                                             $.get(url+"?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                $("div#form_v3_daftar_upb").html(data);
                                            });
                                             
                                        
                                    }
                                        _custom_alert("Copy data berhasil ! ",header,info,"grid_upb_daftar", 1, 20000);
                                        reload_grid("grid_upb_daftar");
                                }
                                
                             })
                         }
                     </script>';
            
            
            $echo .= '<h1>Copy Komposisi UPB ke Komposisi Originator</h1><br />';
            $echo .= '<form id="form_v3_daftar_upb_copyKomp" action="'.base_url().'processor/plc/v3/daftar/upb?action=copyKomp_process" method="post">';
            $echo .= '<div style="vertical-align: top;">';
            $echo .= '<input type="hidden" name="iupb_id" value="'.$this->input->get('upb_id').'" />
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
            <button type="button" onclick="submit_ajax(\'form_v3_daftar_upb_copyKomp\')">Simpan</button>';
                
            $echo .= '</div>';
            $echo .= '</form>';
            return $echo;
        }
        
        function copyKomp_process() {
            $post = $this->input->post();
            $iupb_id =$post['iupb_id'];
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
                    $sql ="select raw_id, ijumlah, vsatuan, ibobot, vketerangan from plc2.plc2_upb_komposisi where ikomposisi_id ={$v}";
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
                    $kor['iupb_id']=$iupb_id;
                    $kor['raw_id'] = $raw_id;
                    $kor['ijumlah'] = $ijumlah;
                    $kor['vsatuan'] = $vsatuan;
                    $kor['ibobot'] = $ibobot;
                    $kor['vfungsi'] = $vketerangan;
                    $this->db_plc0->insert('plc2.plc2_upb_komposisi_ori', $kor);
                }   
            }
            
            $data['status']  = true;
            $data['last_id'] = $post['iupb_id'];
            $data['modul_id'] = $modul_id;
            $data['group_id'] = $group_id;
            return json_encode($data);
        }




        
        function searchBox_v3_daftar_upb_iteambusdev_id($rowData, $id) {
            $teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('ldeleted' => 0,'vtipe' => 'BD'))->result_array();
            $o = '<select id="'.$id.'">';
            $o .= '<option value="">--Select--</option>';
            foreach ($teams as $t) {
                $o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
            }
            $o .= '</select>';
            return $o;
        }

        function searchBox_v3_daftar_upb_iteampd_id($rowData, $id) {
            $teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('ldeleted' => 0,'vtipe' => 'PD'))->result_array();
            $o = '<select class="required" name="'.$id.'" id="'.$id.'">';
            $o .= '<option value="">--Select--</option>';
            foreach ($teams as $t) {
                $o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
            }
            $o .= '</select>';
            return $o;
        }  

        function searchBox_v3_daftar_upb_imaster_delivery($rowData, $id){
            $teams = $this->db_plc0->get_where('plc2.master_delivery_system', array('lDeleted' => 0))->result_array();
            $o = '<select class="required" name="'.$id.'" id="'.$id.'">';
            $o .= '<option value="">--Select--</option>';
            foreach ($teams as $t) {
                $o .= '<option value="'.$t['imaster_delivery_system'].'">'.$t['vKey']." - ".$t['vDeskripsi'].'</option>';
            }
            $o .= '</select>';
            return $o;
        }

        
        function listBox_v3_daftar_upb_iCopy_brand($value) {
            
            if($value==1){
                return 'Ya';
            }
            else{
                return 'Tidak';
            }
            
        } 

        function listBox_v3_daftar_upb_iteambusdev_id($value) {
            $team = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id' => $value))->row_array();
            if(isset($team['vteam'])){
                return $team['vteam'];
            }
            else{
                return $value;
            }
            
        } 

        function listBox_v3_daftar_upb_imaster_delivery($value){
            if ($value == '0'){
                return "Not Selected";
            }else{
                $sql = "SELECT vKey, vDeskripsi FROM plc2.master_delivery_system WHERE imaster_delivery_system = '".$value."' AND lDeleted = '0' LIMIT 1";
                $data = $this->db_plc0->query($sql)->row_array();
                return $data['vKey']." - ".$data['vDeskripsi'];
            }
        }

        function listBox_v3_daftar_upb_iteampd_id($value) {
            $team = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id' => $value))->row_array();
            if(isset($team['vteam'])){
                return $team['vteam'];
            }
            else{
                return $value;
            }
        } 

        function listBox_v3_daftar_upb_iappdireksi($value) {
            /* $appd = $this->db_plc0->get_where('plc2.plc2_status', array('idplc2_status' => $value))->row_array();
            if($value==0){$appd['vCaption']="Waiting For Approval";} */
            if($value==0){$vstatus='Waiting for approval';}
            elseif($value==1){$vstatus='Rejected';}
            elseif($value==2){$vstatus='Approved';}
            return $vstatus;
        }
        function listBox_v3_daftar_upb_iappbusdev($value) {
            if($value==0){$vstatus='Waiting for approval';}
            elseif($value==1){$vstatus='Rejected';}
            elseif($value==2){$vstatus='Approved';}
            return $vstatus;
        }

        //Jika Ingin Menambahkan Seting grid seperti button edit enable dalam kondisi tertentu

        function listBox_Action($row, $actions) {
            $peka=$row->iupb_id;
            $getLastactivity = $this->lib_plc->getLastactivity($this->modul_id,$peka);
            $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

            if ( $getLastactivity == 0 ) { 
                   if($row->iappbusdev <> 0){
                        /*approval DR lewat setting prioritas*/
                        unset($actions['edit']);    

                   } 
            }else{
                if($isOpenEditing){

                }else{
                    unset($actions['edit']);    
                }
                
            }


            return $actions;
        }


        function insertBox_v3_daftar_upb_form_detail($field,$id){
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
                var sebelum = $("label[for=\'v3_daftar_upb_form_detail\']").parent();
                $("label[for=\'v3_daftar_upb_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/plc/v3/daftar/upb?action=getFormDetail&formaction=addnew&'.$g.'",
                    type: "post",
                    data: iupb_id=0,
                    success: function(data) {
                        var o = $.parseJSON(data);
                        sebelum.html(o.html);
                    }       
                });
            </script>';
            return $return;
        }

        function updateBox_v3_daftar_upb_form_detail($field,$id,$value,$rowData){
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
                var sebelum = $("label[for=\'v3_daftar_upb_form_detail\']").parent();
                $("label[for=\'v3_daftar_upb_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/plc/v3/daftar/upb?action=getFormDetail&formaction=update&'.$g.'",
                    type: "post",
                    data: iupb_id=0,
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
                                        var url = "'.base_url().'processor/plc/v3_daftar_upb";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_daftar_upb").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_daftar_upb");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_v3_daftar_upb_approve" action="'.base_url().'processor/plc/v3_daftar_upb?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_daftar_upb_approve\')">Approve</button>';
                    
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
                $data=array('iappbusdev'=>'2');
                $this -> db -> where('iupb_id', $iupb_id);
                $updet = $this -> db -> update('plc2.plc2_upb', $data);

                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iupb_id,3,2,$vRemark,2);
    
                $data['status']  = true;
                $data['last_id'] = $post['iupb_id'];
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
                                        var url = "'.base_url().'processor/plc/v3_daftar_upb";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_daftar_upb").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_daftar_upb");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_v3_daftar_upb_confirm" action="'.base_url().'processor/plc/v3_daftar_upb?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_daftar_upb_confirm\')">Confirm</button>';
                    
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
                $data=array('iappdireksi'=>'2');
                $this -> db -> where('iupb_id', $iupb_id);
                $updet = $this -> db -> update('plc2.plc2_upb', $data);

                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iupb_id,4,3,$vRemark,2);

                
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
                                var remark = $("#v3_daftar_upb_remark").val();
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
                                        var url = "'.base_url().'processor/plc/v3_daftar_upb";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_daftar_upb").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_daftar_upb");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_v3_daftar_upb_reject" action="'.base_url().'processor/plc/v3_daftar_upb?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        
                        <textarea name="vRemark" id="reject_v3_daftar_upb_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_daftar_upb_reject\')">Reject</button>';
                    
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
                $data=array('iappbusdev'=>'1');
                $this -> db -> where('iupb_id', $iupb_id);
                $updet = $this -> db -> update('plc2.plc2_upb', $data);

    
                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iupb_id,3,2,$vRemark,1);
    
                $data['status']  = true;
                $data['last_id'] = $post['iupb_id'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }



    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated']=$this->user->gNIP;


        if(isset($postData['bb'])) {
            $bb = $postData['bb'];
            $new_bb = '';
            $i=1;
            foreach($bb as $k => $d) {
                if($i == count($bb)) {
                    $new_bb .=$d;
                }
                else {
                    $new_bb .=$d.',';
                }
                $i++;
            }
            $postData['txtDocBB'] = $new_bb;
        }
    
        if(isset($postData['sm'])) {
            $sm = $postData['sm'];
            $new_sm = '';
            $i=1;
            foreach($sm as $k => $d) {
                if($i == count($sm)) {
                    $new_sm .=$d;
                }
                else {
                    $new_sm .=$d.',';
                }
                $i++;
            }
            $postData['txtDocSM'] = $new_sm;
        }


        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } else{
            $postData['iSubmit']=1;
            
        } 
        

        return $postData;

    }
    function before_update_processor($row, $postData) {
        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;

        $controller_name ='v3_daftar_upb';
        $pk_field = 'iupb_id';
        $gabung = $controller_name."_".$pk_field;
        $peka=$postData[$gabung];

        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } else{
            $postData['iSubmit']=1;
            $arrUPB['iupb_id'] = $peka;
            $this->lib_plc->InsertActivityModule($arrUPB,$this->modul_id,$peka,1,1);
        } 


        return $postData; 
    }    

    function after_insert_processor($fields, $id, $postData) {
        $nomor = "U".str_pad($id, 5, "0", STR_PAD_LEFT);
        $sql = "UPDATE plc2.plc2_upb SET vupb_nomor = '".$nomor."' WHERE iupb_id=$id LIMIT 1";
        $query = $this->db_plc0->query( $sql );

        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } else{
            $postData['iSubmit']=1;
            $arrUPB['iupb_id'] = $id;
            $this->lib_plc->InsertActivityModule($arrUPB,$this->modul_id,$id,1,1);
        }

        /*  insert  dokumen bb  */
        if(isset($postData['txtDocBB'])){
            // if(($postData['kom_bahan_id'][0])!=""){
                $valtemp = explode(',', $postData['txtDocBB']);
                foreach($valtemp as $k=>$v){
                    $indokbb['iupb_id']=$id;
                    $indokbb['idoc_id']=$v;
                    $indokbb['ldeleted']=0;
                    $this->db_plc0->insert('plc2.plc2_upb_detail_dokumen_bb', $indokbb);
                }
                //exit;
            // }
        }
        /* end of insert*/

        /*  insert  dokumen sm  */
        if(isset($postData['txtDocSM'])){
            // if(($postData['kom_bahan_id'][0])!=""){
                $valtemp = explode(',', $postData['txtDocSM']);
                foreach($valtemp as $k=>$v){
                    $indoksm['iupb_id']=$id;
                    $indoksm['idoc_id']=$v;
                    $indoksm['ldeleted']=0;
                    $this->db_plc0->insert('plc2.plc2_upb_detail_dokumen_sm', $indoksm);
                }
                //exit;
            // }
        }
        /* end of insert*/


        if(($postData['kom_bahan_id'][0])!=""){
            foreach($postData['kom_bahan_id'] as $k=>$v){
                $kom['iupb_id']=$id;
                $kom['raw_id']=$v;
                $kom['ijumlah']=$postData['kom_kekuatan'][$k];
                $kom['vsatuan']=$postData['kom_satuan'][$k];
                $kom['ibobot']=$k+1;
                $kom['vketerangan']=$postData['kom_fungsi'][$k];
                $this->db_plc0->insert('plc2.plc2_upb_komposisi', $kom);
            }
            //exit;
        }   
        /*  insert  komposisi originator */
        if(($postData['kor_bahan_id'][0])!=""){
            foreach($postData['kor_bahan_id'] as $k=>$v){
                $kor['iupb_id']=$id;
                $kor['raw_id']=$v;
                $kor['ijumlah']=$postData['kor_kekuatan'][$k];
                $kor['vsatuan']=$postData['kor_satuan'][$k];
                $kor['ibobot']=$k+1;
                $kor['vfungsi']=$postData['kor_fungsi'][$k];
                $this->db_plc0->insert('plc2.plc2_upb_komposisi_ori', $kor);
            }
            //exit;
        }

        for($i=1; $i<=3; $i++) {
            $m['iupb_id'] = $id;
            $m['ino'] = $i;
            $m['vyear'] = $postData['thn'.$i];
            $m['vunit'] = $postData['jum'.$i];
            $m['vforecast'] = $postData['for'.$i];
            $m['vincrement'] = $postData['inc'.$i];
            $this->db_plc0->insert('plc2.plc2_upb_forecast', $m);
        }


            $iupb_id=$id;
    }

    function after_update_processor($fields, $id, $postData) {
        //Example After Update

        /* insert forecast  */      
            $sql="select count(*) from plc2.plc2_upb_forecast f where f.iupb_id=$id";
            $cekf=$this->db_plc0->query($sql)->result_array();
            if($cekf > 0 ){
                $this->db_plc0->where('iupb_id', $id);
                $this->db_plc0->update('plc2.plc2_upb_forecast',array('ldeleted'=>1));
                    
            }
            for($i=1; $i<=3; $i++) {
                $m['iupb_id'] = $id;
                $m['vyear'] = $postData['thn'.$i];
                $m['vunit'] = $postData['jum'.$i];
                $m['vforecast'] = $postData['for'.$i];
                $m['vincrement'] = $postData['inc'.$i];
                $m['ino'] = $i;
                $this->db_plc0->insert('plc2.plc2_upb_forecast', $m);
                
            }

            /*  insert  dokumen bb  */
            //cek isi awal
            $sql="select txtDocBB from plc2.plc2_upb k
            where k.iupb_id=$id and k.ldeleted=0";
            $dokbb =$this->db_plc0->query($sql)->row_array();
            $val = explode(',', $dokbb['txtDocBB']);
            
            
            if(isset($postData['txtDocBB'])){
                    foreach($val as $k=>$v){
                        $this->db_plc0->where('iupb_id', $id);
                        $this->db_plc0->update('plc2.plc2_upb_detail_dokumen_bb',array('ldeleted'=>1));
                    }
                    $valtemp = explode(',', $postData['txtDocBB']);
                    foreach($valtemp as $k=>$v){
                        $indokbb['iupb_id']=$id;
                        $indokbb['idoc_id']=$v;
                        $indokbb['ldeleted']=0;
                        $this->db_plc0->insert('plc2.plc2_upb_detail_dokumen_bb', $indokbb);
                    }
                
            }

            /*  insert  dokumen sm  */
            //cek isi awal
            $sql="select txtDocSM from plc2.plc2_upb k
            where k.iupb_id=$id and k.ldeleted=0";
            $dokbb =$this->db_plc0->query($sql)->row_array();
            $val = explode(',', $dokbb['txtDocSM']);
            
            
            if(isset($postData['txtDocSM'])){
                    foreach($val as $k=>$v){
                        $this->db_plc0->where('iupb_id', $id);
                        $this->db_plc0->update('plc2.plc2_upb_detail_dokumen_sm',array('ldeleted'=>1));
                    }
                    $valtemp = explode(',', $postData['txtDocSM']);
                    foreach($valtemp as $k=>$v){
                        $indoksm['iupb_id']=$id;
                        $indoksm['idoc_id']=$v;
                        $indoksm['ldeleted']=0;
                        $this->db_plc0->insert('plc2.plc2_upb_detail_dokumen_sm', $indoksm);
                    }
            }

            /*  insert  komposisi  */
            //cek isi awal
            $sql="select k.ikomposisi_id, r.raw_id
            from plc2.plc2_upb_komposisi k
            inner join plc2.plc2_raw_material r on r.raw_id=k.raw_id
            where k.iupb_id=$id and k.ldeleted=0";
            $kompos =$this->db_plc0->query($sql)->result_array();
            
            
            if(isset($postData['kom_bahan_id'])){
                if(($postData['kom_bahan_id'][0])!=""){
                    foreach($kompos as $k=>$v){
                        $this->db_plc0->where('ikomposisi_id', $v['ikomposisi_id']);
                        $this->db_plc0->update('plc2.plc2_upb_komposisi',array('ldeleted'=>1));
                    }
                    foreach($postData['kom_bahan_id'] as $k=>$v){
                        $kom['iupb_id']=$id;
                        $kom['raw_id']=$v;
                        $kom['ijumlah']=$postData['kom_kekuatan'][$k];
                        $kom['vsatuan']=$postData['kom_satuan'][$k];
                        $kom['ibobot']=$k+1;
                        $kom['vketerangan']=$postData['kom_fungsi'][$k];
                        $this->db_plc0->insert('plc2.plc2_upb_komposisi', $kom);
                    }
                }
            }
            
            /*  insert  komposisi originator */
            
            //cek isi awal
            $sql="select k.ikomposisi_id, r.raw_id
            from plc2.plc2_upb_komposisi_ori k
            inner join plc2.plc2_raw_material r on r.raw_id=k.raw_id
            where k.iupb_id=$id and k.ldeleted=0";
            $kompor =$this->db_plc0->query($sql)->result_array();
            
            if(isset($postData['kor_bahan_id'])){
                if(($postData['kor_bahan_id'][0])!=""){
                    foreach($kompor as $k=>$v){
                        $this->db_plc0->where('ikomposisi_id', $v['ikomposisi_id']);
                        $this->db_plc0->update('plc2.plc2_upb_komposisi_ori',array('ldeleted'=>1));
                    }
                    foreach($postData['kor_bahan_id'] as $k=>$v){
                        $kor['iupb_id']=$id;
                        $kor['raw_id']=$v;
                        $kor['ijumlah']=$postData['kor_kekuatan'][$k];
                        $kor['vsatuan']=$postData['kor_satuan'][$k];
                        $kor['ibobot']=$k+1;
                        $kor['vfungsi']=$postData['kor_fungsi'][$k];
                        $this->db_plc0->insert('plc2.plc2_upb_komposisi_ori', $kor);
                    }
                    //exit;
                }
            }



    }

    function cancel_view() {
        $echo = '<script type="text/javascript">
                     function submit_ajax(form_id) {
                        return $.ajax({
                            url: $("#"+form_id).attr("action"),
                            type: $("#"+form_id).attr("method"),
                            data: $("#"+form_id).serialize(),
                            success: function(data) {
                                var o = $.parseJSON(data);
                                var last_id = o.last_id;
                                var url = "'.base_url().'processor/plc/v3/daftar/upb";                             
                                if(o.status == true) {
                                    
                                    $("#alert_dialog_form").dialog("close");
                                         $.get(url+"?action=update&id="+last_id, function(data) {
                                         $("div#form_v3_daftar_upb").html(data);
                                    });
                                    
                                }
                                    reload_grid("grid_v3_daftar_upb");
                            }
                            
                         })
                     }
                 </script>';
        $echo .= '<h1>Cancel</h1><br />';
        $echo .= '<form id="form_daftar_upb_cancel" action="'.base_url().'processor/plc/v3/daftar/upb?action=cancel_process" method="post">';
        $echo .= '<div style="vertical-align: top;">';
        $echo .= 'Remark : <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                <input type="hidden" name="type" value="'.$this->input->get('type').'" />
                <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                <textarea name="remark"></textarea>
        <button type="button" onclick="submit_ajax(\'form_daftar_upb_cancel\')">Cancel</button>';
            
        $echo .= '</div>';
        $echo .= '</form>';
        return $echo;
    }
    
    function cancel_process() {
        $post = $this->input->post();
        $cNip= $this->user->gNIP;
        $vName= $this->user->gName;
        $iupb_id = $post['iupb_id'];
        
        $vRemark = $post['remark'];
        $modul_id = $post['modul_id'];


        //Letakan Query Update approve disini
        $data=array('ihold'=>'1','iholddate'=>date('Y-m-d H:i:s'),'cHold_by'=>$cNip,'cHold_remark'=>$vRemark);
        $this -> db -> where('iupb_id', $iupb_id);
        $updet = $this -> db -> update('plc2.plc2_upb', $data);


        $data['status']  = true;
        $data['last_id'] = $post['modul_id'];
        $data['group_id'] = $post['group_id'];
        $data['modul_id'] = $post['modul_id'];
        return json_encode($data);


    }
    function manipulate_insert_button($buttons) { 
        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $data['upload']='upload_custom_grid';
        $js = $this->load->view('js/standard_js',$data,TRUE);

        $iframe = '<iframe name="v3_daftar_upb_frame" id="v3_daftar_upb_frame" height="0" width="0"></iframe>';
        
        // $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'v3_daftar_upb\', \' '.base_url().'processor/plc/v3_daftar_upb?draft=true \',this,true )"  id="button_save_draft_v3_daftar_upb"  class="ui-button-text icon-save" >Save as Draft</button>';
        // $save = '<button onclick="javascript:save_btn_multiupload(\'v3_daftar_upb\', \' '.base_url().'processor/plc/v3_daftar_upb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_save_submit_v3_daftar_upb"  class="ui-button-text icon-save" >Save &amp; Submit</button>';\

        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'v3_daftar_upb\', \' '.base_url().'processor/plc/v3_daftar_upb?draft=true&modul_id='.$this->input->get('modul_id').'&iM_modul_activity=1 \',this,true )"  id="button_save_draft_v3_daftar_upb"  class="ui-button-text icon-save" >Save as Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\'v3_daftar_upb\', \' '.base_url().'processor/plc/v3_daftar_upb?company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&iM_modul_activity=1&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,false )"  id="button_save_submit_v3_daftar_upb"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

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
        $peka=$rowData['iupb_id'];


        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $data['upload']='upload_custom_grid';
        $js = $this->load->view('js/standard_js',$data,TRUE);

        $iframe = '<iframe name="v3_daftar_upb_frame" id="v3_daftar_upb_frame" height="0" width="0"></iframe>';        

        $cancelupbx = '<button onclick="javascript:btn_cancel_upb(\'upb_daftar\', \''.base_url().'processor/plc/v3/daftar/upb?company_id='.$this->input->get('company_id').'&iupb_id='.$peka.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save">Cancel UPB</button>';

        $cancelupb = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_daftar_upb?action=cancel&iupb_id='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_cancel_v3_daftar_upb"  class="ui-button-text icon-save" >Cancel</button>';
                                

        if ($this->input->get('action') == 'view') {
            
            if($rowData['iappbusdev'] == 2 and  $rowData['ihold'] == 1){
                $buttons['update'] = $cancelupb;        
            }else{
                unset($buttons['update']);
            }
        }
        else{ 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_daftar_upb\', \' '.base_url().'processor/plc/v3_daftar_upb?draft=true \',this,true )"  id="button_update_draft_v3_daftar_upb"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$peka);
                    $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,$peka);

                    foreach ($activities as $act) {
                        // $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_daftar_upb\', \' '.base_url().'processor/plc/v3_daftar_upb?draft=true \',this,true )"  id="button_update_draft_v3_daftar_upb"  class="ui-button-text icon-save" >Update as Draft</button>';
                        // $update = '<button onclick="javascript:update_btn_back(\'v3_daftar_upb\', \' '.base_url().'processor/plc/v3_daftar_upb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_v3_daftar_upb"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

                        $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_daftar_upb\', \' '.base_url().'processor/plc/v3_daftar_upb?draft=true&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].' \',this,true )"  id="button_update_draft_v3_daftar_upb"  class="ui-button-text icon-save" >Update as Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\'v3_daftar_upb\', \' '.base_url().'processor/plc/v3_daftar_upb?company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,false )"  id="button_update_submit_v3_daftar_upb"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_daftar_upb?action=approve&iM_activity='.$act['iM_activity'].'&iupb_id='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_daftar_upb"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_daftar_upb?action=reject&iM_activity='.$act['iM_activity'].'&iupb_id='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_v3_daftar_upb"  class="ui-button-text icon-save" >Reject</button>';

                        $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_daftar_upb?action=confirm&iM_activity='.$act['iM_activity'].'&iupb_id='.$peka.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_daftar_upb"  class="ui-button-text icon-save" >Confirm</button>';

                        

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
                                    //$sButton .= $confirm;
                                    /*confirm UPB lewat setting prioritas*/
                                    $sButton .= '';
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
                        
                        $arrDept = explode(',',$act['vDept_assigned'] );

                        $arrTeam = explode(',',$this->team);

                        $arrTeamID = explode(',',$this->teamID);
                        $upbTeamID = $this->lib_plc->upbTeam($peka);

                        $cekDept = array_intersect($arrTeam, $arrDept);

                        //if(in_array($act['vDept_assigned'], $arrTeam ) || in_array($this->user->gNIP, $arrNipAssign)  ){
                        if( !empty($cekDept) || in_array($this->user->gNIP, $arrNipAssign)  ){
                            
                            // jika Dept id yang ditunjuk ada pada team id yang dimiliki
                            if(in_array($upbTeamID[$act['vDept_assigned']], $arrTeamID) || in_array($this->user->gNIP, $arrNipAssign) ){
                                //get manager from Team ID
                                $magrAndCief = $this->lib_plc->managerAndChief($upbTeamID[$act['vDept_assigned']]);

                                // jika activitynya approval keatas
                                if($act['iType'] > 1){
                                    // nip harus ada pada nip manager atau chief dari Dept, atau nip yang ditunjuk di table modul activity
                                    $arrmgrAndCief = explode(',', $magrAndCief);
                                    if(in_array($this->user->gNIP, $arrmgrAndCief) ||in_array($this->user->gNIP, $arrNipAssign)){
                                        
                                    }else{
                                        $sButton = '<span style="color:red;">You\'re not Authorized to Approve</span>';
                                    }
                                }

                            }else{
                                $sButton = '<span style="color:red;" arrTeamID="'.$this->teamID.'" title="'.$upbTeamID[$act['vDept_assigned']].'" >You\'re Team not Authorized </span>';
                            }


                            

                        }else{
                            $sButton = '<span style="color:red;" title="'.$act['vDept_assigned'].'">You\'re Dept not Authorized</span>';
                            
                        }
                    }
                }


                if($rowData['iappbusdev'] == 2 and  $rowData['ihold'] == 1){
                    $sButton .= $cancelupb;
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
