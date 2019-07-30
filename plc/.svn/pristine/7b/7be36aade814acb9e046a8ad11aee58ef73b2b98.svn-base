<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class import_data_lounching extends MX_Controller {
    function __construct() {
       parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('auth');
        $this->load->library('biz_process');
        $this->load->library('lib_utilitas');
        $this->user = $this->auth->user(); 
        $this->dbset = $this->load->database('plc', true);
    }
    function index($action = '') {
    	$action = $this->input->get('action');
		
    	//Bikin Object Baru Nama nya $grid		
        $grid = new Grid;		
        $grid->setTitle('Persiapan Launching');		
        $grid->setTable('plc2.data_launching');		
        $grid->setUrl('import_data_lounching');
        $grid->addList('daftar_upi.vNo_upi','daftar_upi.vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori','iSubmit_launching','iApprove_bdirm','daftar_upi.iStatus_launching');

        $grid->setSortBy('iLaunching_id');
        $grid->setSortOrder('DESC'); 

        $grid->addFields('iApprove_bdirm','iupi_id','vNama_usulan','cPengusul_upi','vKekuatan','vDosis',
            'vNama_generik','vIndikasi','ikategori_id');
        $grid->addFields('fHarga','vMOQ','vSatuan','vKonvert_satuan','fFo_unit','fFo_value',
            'vFileLaunching','dLeadtime_principla','dTanggalPO');

        
        //sort ordernya
		
		//align & width
        $grid->setLabel('daftar_upi.iStatus_launching','Status Launching'); 
        $grid ->setWidth('daftar_upi.iStatus_launching', '100'); 
        $grid->setAlign('daftar_upi.iStatus_launching', 'center'); 

        $grid->setLabel('iSubmit_launching','Status'); 
        $grid ->setWidth('iSubmit_launching', '100'); 
        $grid->setAlign('iSubmit_launching', 'center'); 

        $grid->setLabel('iApprove_bdirm','Approval BDIRM'); 
        $grid ->setWidth('iApprove_bdirm', '100'); 
        $grid->setAlign('iApprove_bdirm', 'center');

        $grid->setLabel('daftar_upi.vNo_upi','No UPI'); 
        $grid->setWidth('daftar_upi.vNo_upi','80'); 
        $grid->setAlign('daftar_upi.vNo_upi','center'); 
 
        $grid->setLabel('iupi_id','No UPI'); 
        $grid ->setWidth('iupi_id', '100'); 
        $grid->setAlign('iupi_id', 'center'); 

        $grid->setLabel('plc2_upb_master_kategori_upb.vkategori','Kategori UPI'); 
        $grid->setWidth('plc2_upb_master_kategori_upb.vkategori','50'); 
        $grid->setAlign('plc2_upb_master_kategori_upb.vkategori','center'); 
 
        $grid->setLabel('ikategoriupi_id','Kategori UPI'); 
        $grid ->setWidth('ikategoriupi_id', '150'); 
        $grid->setAlign('ikategoriupi_id', 'center');

        $grid->setLabel('mnf_kategori.vkategori','Kategori Produk'); 
        $grid->setLabel('ikategori_id','Kategori Produk'); 
        $grid ->setWidth('ikategori_id', '150'); 
        $grid->setAlign('ikategori_id', 'center');
       
        $grid->setLabel('daftar_upi.vNama_usulan','Nama Usulan'); 
        $grid->setLabel('vNama_usulan','Nama Usulan'); 
        $grid ->setWidth('vNama_usulan', '250'); 
        $grid->setAlign('vNama_usulan', 'left');

        $grid->setLabel('cPengusul_upi','Nama Pengusul'); 
        $grid ->setWidth('cPengusul_upi', '250'); 
        $grid->setAlign('cPengusul_upi', 'center');

        $grid->setLabel('daftar_upi.vKekuatan','Kekuatan'); 
        $grid->setLabel('vKekuatan','Kekuatan'); 
        $grid ->setWidth('vKekuatan', '250'); 
        $grid->setAlign('vKekuatan', 'left');

        $grid->setLabel('daftar_upi.vDosis','Dosis'); 
        $grid->setLabel('vDosis','Dosis'); 
        $grid ->setWidth('vDosis', '250'); 
        $grid->setAlign('vDosis', 'left');

        $grid->setLabel('vNama_generik','Nama Generik'); 
        $grid ->setWidth('vNama_generik', '10'); 
        $grid->setAlign('vNama_generik', 'center');

        $grid->setLabel('vIndikasi','Indikasi'); 
        $grid ->setWidth('vIndikasi', '10'); 
        $grid->setAlign('vIndikasi', 'center');


		$grid->setLabel('fHarga', 'Harga'); //Ganti Label
        $grid->setAlign('fHarga', 'left'); //Align nya
        $grid->setWidth('fHarga', '50'); // width nya
		
		$grid->setLabel('vMOQ', 'MOQ'); //Ganti Label
        $grid->setAlign('vMOQ', 'left'); //Align nya
        $grid->setWidth('vMOQ', '50'); // width nya

        $grid->setLabel('vSatuan', 'Satuan'); //Ganti Label
        $grid->setAlign('vSatuan', 'left'); //Align nya
        $grid->setWidth('vSatuan', '50'); // width nya
        
        $grid->setLabel('vKonvert_satuan', 'Konversi Satuan'); //Ganti Label
        $grid->setAlign('vKonvert_satuan', 'left'); //Align nya
        $grid->setWidth('vKonvert_satuan', '50'); // width nya

        $grid->setLabel('fFo_unit', 'Forecast Order (Unit)'); //Ganti Label
        $grid->setAlign('fFo_unit', 'left'); //Align nya
        $grid->setWidth('fFo_unit', '50'); // width nya
        
        $grid->setLabel('fFo_value', 'Forecast Order (Value)'); //Ganti Label
        $grid->setAlign('fFo_value', 'left'); //Align nya
        $grid->setWidth('fFo_value', '50'); // width nya

        $grid->setLabel('vFileLaunching', 'Memo Launching'); //Ganti Label
        $grid->setAlign('vFileLaunching', 'left'); //Align nya
        $grid->setWidth('vFileLaunching', '50'); // width nya
        
        $grid->setLabel('dLeadtime_principla', 'Leadtime Principal'); //Ganti Label
        $grid->setAlign('dLeadtime_principla', 'left'); //Align nya
        $grid->setWidth('dLeadtime_principla', '50'); // width nya

        $grid->setLabel('dTanggalPO', 'Tanggal PO'); //Ganti Label
        $grid->setAlign('dTanggalPO', 'left'); //Align nya
        $grid->setWidth('dTanggalPO', '50'); // width nya
		
       
		$grid->setSearch('daftar_upi.vNo_upi','daftar_upi.vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori');
       

        $grid->changeFieldType('iSubmit_launching','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submitted'));

        //$grid->changeFieldType('iStatus_launching','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submitted'));
        
        $grid->setLabel('dupdate','Tgl Update'); 
        $grid->setLabel('cUpdate','Update By'); 
		
		//set required

        $grid->setQuery('daftar_upi.iStatusKill = "0" ', null);

        $grid->setRequired('iupi_id', 'fHarga', 'vMOQ', 'vSatuan', 'vKonvert_satuan', 'fFo_unit', 'fFo_value', 'Memo', 'dLeadtime_principla','dTanggalPO');	//Field yg mandatori

        $grid->setJoinTable('plc2.daftar_upi', 'data_launching.iupi_id = daftar_upi.iupi_id', 'inner');
        $grid->setJoinTable('hrd.mnf_kategori', 'mnf_kategori.ikategori_id = daftar_upi.ikategori_id', 'inner');
        $grid->setJoinTable('plc2.plc2_upb_master_kategori_upb', 'plc2_upb_master_kategori_upb.ikategori_id = daftar_upi.ikategoriupi_id', 'inner');

        //$grid->changeFieldType('iSubmit_ujiLabs','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submitted'));
        //$grid->changeFieldType('daftar_upi.iStatus_launching','combobox','',array(0=>'Need to be Launching',1=>'Not Launching',2=>'Launching'));
        

        $grid->setGridView('grid');

        switch ($action) {
                case 'json':
                        $grid->getJsonData();
                        break;
                case 'getdetil':
                        $this->getdetil();
                        break;  
                case 'view':
                        $grid->render_form($this->input->get('id'), true);
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
                case 'create':
                        $grid->render_form();
                        break;
                case 'createproses':
                       $isUpload = $this->input->get('isUpload');
                if($isUpload) {
                    $lastId=$this->input->get('lastId');
                    $path = realpath("files/plc/memo_launching");
                    if(!file_exists($path."/".$lastId)){
                        if (!mkdir($path."/".$lastId, 0777, true)) { //id review
                            die('Failed upload, try again!');
                        }
                    }

                    $file_keterangan = array();
                    foreach($_POST as $key=>$value) {                       
                        if ($key == 'fileketerangan') {
                            foreach($value as $k=>$v) {
                                $file_keterangan[$k] = $v;
                            }
                        }
                    }

                    $i=0;
                    foreach ($_FILES['fileupload_studyad']["error"] as $key => $error) {
                        if ($error == UPLOAD_ERR_OK) {
                            $tmp_name = $_FILES['fileupload_studyad']["tmp_name"][$key];
                            $name =$_FILES['fileupload_studyad']["name"][$key];
                            $data['filename'] = $name;
                            $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
                                    $sql[]="INSERT INTO plc2.launching_file_upi (iLaunching_id, vFileLaunching, dCreate, cCreated, vKeterangan) 
                                            VALUES (".$lastId.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."','".$file_keterangan[$i]."')";
                                    $i++;   
                                }
                                else{
                                    echo "Upload ke folder gagal";  
                                }
                        }
                    }
                    foreach($sql as $q) {
                        try {
                        $this->dbset->query($q);
                        }catch(Exception $e) {
                        die($e);
                        }
                    }
                    $r['message']="Data Berhasil Disimpan";
                    $r['status'] = TRUE;
                    $r['last_id'] = $this->input->get('lastId');                    
                    echo json_encode($r);
                }else{
                    echo $grid->saved_form();
                }
                break;
                case 'update':
                        $grid->render_form($this->input->get('id'));
                        break;
                case 'updateproses':
                    $isUpload = $this->input->get('isUpload');
                    $post=$this->input->post();
                    
                    $iujiLabs=$post['import_data_lounching_iLaunching_id'];

                    if($isUpload) { 
                         $path = realpath("files/plc/memo_launching");
                        if(!file_exists($path."/".$iujiLabs)){
                            if (!mkdir($path."/".$iujiLabs, 0777, true)) { //id review
                                die('Failed upload, try again!');
                            }
                        }

                         $file_keterangan = array();
                            foreach($_POST as $key=>$value) {                       
                                if ($key == 'fileketerangan') {
                                    foreach($value as $k=>$v) {
                                        $file_keterangan[$k] = $v;
                                    }
                                }
                            }

                        if (isset($_FILES['fileupload_studyad']))  {
                            $i=0;
                             foreach ($_FILES['fileupload_studyad']["error"] as $key => $error) {
                                    if ($error == UPLOAD_ERR_OK) {
                                        $tmp_name = $_FILES['fileupload_studyad']["tmp_name"][$key];
                                        $name =$_FILES['fileupload_studyad']["name"][$key];
                                        $data['filename'] = $name;
                                        $data['dInsertDate'] = date('Y-m-d H:i:s');

                                            if(move_uploaded_file($tmp_name, $path."/".$iujiLabs."/".$name)) {
                                                $sql[]="INSERT INTO plc2.launching_file_upi (iLaunching_id, vFileLaunching, dCreate, cCreated, vKeterangan) 
                                                        VALUES (".$iujiLabs.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."','".$file_keterangan[$i]."')";
                                                $i++;   
                                            }
                                            else{
                                                echo "Upload ke folder gagal";  
                                            }
                                    }
                                }
                                
                            }
                            foreach($sql as $q) {
                                try {
                                    $this->dbset->query($q);
                                    }catch(Exception $e) {
                                    die($e);
                                }
                            }
                            $r['message']="Data Berhasil Disimpan";
                            $r['status'] = TRUE;
                            $r['last_id'] = $this->input->get('lastId');                    
                            echo json_encode($r);

                        }else{
                            $fileid1='';
                            foreach($_POST as $key=>$value) {
                                if ($key == 'fileid_studyad') {
                                    $i=0;
                                    foreach($value as $k=>$v) {
                                        if($i==0){
                                            $fileid1 .= "'".$v."'";
                                        }else{
                                            $fileid1 .= ",'".$v."'";
                                        }
                                        $i++;
                                    }
                                }
                            }
                            $tgl= date('Y-m-d H:i:s');
                            $sql1="update plc2.launching_file_upi set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where iLaunching_id='".$iujiLabs."' and iLaunchingfile_id not in (".$fileid1.")";
                            $this->dbset->query($sql1);

                            echo $grid->updated_form();
                        }
                        
                        break;
                case 'delete':
                        echo $grid->delete_row();
                        break;
                case 'downloadad':
                    $this->downloadad($this->input->get('filead'));
                    break;
               
                default:
                        $grid->render_grid();
                        break;
        }
    }   

    function listBox_Action($row, $actions) {

        $mydept = $this->auth->my_depts(TRUE);
        $x = $this->auth->my_teams();
        $array = explode(',', $x);
        // cek user bagian dari tim bd terkait
        

        if ($row->iSubmit_launching<>0) {
            // status sudah diapprove or reject , button edit hide 
                if ($row->iApprove_bdirm<>0) {
                    unset($actions['edit']);
                    unset($actions['delete']);
                }else{

                    if((in_array('BDI', $mydept))) {
                        if($this->auth->is_manager()){
                            //$buttons['update'] = $approve_bdirm.$reject_bdirm.$js;    
                        }else{
                            unset($actions['edit']);
                            unset($actions['delete']);
                        }
                    }
                }
        }
        
         return $actions;
    }

    function getdetil(){
    
        $iupi_id=$_POST['iupi_id'];
        //$ianalisa_prinsipal_id=$_POST['ianalisa_prinsipal_id'];
        $data = array();
        //$iupi_id=$_POST['iupi_id'];
        $sql2 = "select *
            from plc2.daftar_upi a 
            join hrd.employee b on b.cNip=a.cPengusul_upi
            where a.ldeleted = 0 and a.iupi_id='".$iupi_id."'";
        $data2 = $this->dbset->query($sql2)->row_array();
        
        $row_array['vNo_upi'] = trim($data2['vNo_upi']);
        $row_array['dTgl_upi'] = trim($data2['dTgl_upi']);
        $row_array['cPengusul_upi'] = trim($data2['vName']);
        $row_array['vNama_usulan'] = trim($data2['vNama_usulan']);
        $row_array['vKekuatan'] = trim($data2['vKekuatan']);

        $row_array['vDosis'] = trim($data2['vDosis']);
        $row_array['vNama_generik'] = trim($data2['vNama_generik']);
        $row_array['vIndikasi'] = trim($data2['vIndikasi']);
        //$row_array['vIndikasi'] = trim($data2['vIndikasi']);



        $row_array['ikategori_id'] = trim($data2['ikategori_id']);
        $row_array['ikategoriupi_id'] = trim($data2['ikategoriupi_id']);
        
        array_push($data, $row_array);
        echo json_encode($data);
        exit;
    }

    /*Field*/
    function searchBox_import_data_lounching_mnf_kategori_vkategori($rowData, $id) {
        $teams = $this->db_plc0->get_where('hrd.mnf_kategori', array('ldeleted' => 0))->result_array();
        $o = '<select class="required" name="'.$id.'" id="'.$id.'">';
        $o .= '<option value="">--Select--</option>';
        foreach ($teams as $t) {
            if($t['ikategori_id'] == '1' || $t['ikategori_id'] =='3' || $t['ikategori_id'] =='5'){

            }else{
                $o .= '<option value="'.$t['vkategori'].'">'.$t['vkategori'].'</option>';
            }
        }
        $o .= '</select>';
        return $o;
    } 

    function searchBox_import_data_lounching_plc2_upb_master_kategori_upb_vkategori($rowData, $id) {
        $teams = $this->db_plc0->get_where('plc2.plc2_upb_master_kategori_upb', array('ldeleted' => 0))->result_array();
        $o = '<select class="required" name="'.$id.'" id="'.$id.'">';
        $o .= '<option value="">--Select--</option>';
        foreach ($teams as $t) {
            $o .= '<option value="'.$t['vkategori'].'">'.$t['vkategori'].'</option>';
        }
        $o .= '</select>';
        return $o;
    }   

    function listBox_import_data_lounching_iApprove_bdirm($value) {
        if($value==0){$vstatus='Waiting for approval';}
        elseif($value==1){$vstatus='Rejected';}
        elseif($value==2){$vstatus='Approved';}
        return $vstatus;
    }
    function listBox_import_data_lounching_daftar_upi_iStatus_launching($value) {
        if($value==0){$vstatus='Need to be Launching';}
        elseif($value==1){$vstatus='Not Launching';}
        elseif($value==2){$vstatus='Launching';}
        return $vstatus;
    }
    //$grid->changeFieldType('daftar_upi.iStatus_launching','combobox','',array(0=>'Need to be Launching',1=>'Not Launching',2=>'Launching'));

    function insertBox_import_data_lounching_iApprove_bdirm($field, $id) {
        return '-';
    }
    function updateBox_import_data_lounching_iApprove_bdirm($field, $id, $value, $rowData) {
        if(($value <> 0) || (!empty($value))){
            $sql_dtapp = "SELECT * FROM plc2.data_launching a JOIN hrd.employee b ON b.cNip=a.cApprove_bdirm WHERE a.lDeleted = 0 AND a.`iLaunching_id` = '".$rowData['iLaunching_id']."'";
            $row = $this->db_plc0->query($sql_dtapp)->row_array();
            
            if($value==2){
                $st='<p style="color:green;font-size:120%;">Approved';
                $ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_bdirm'].'</br> Alasan: '.$row['vRemark_bdirm'].'</p>';
            }
            elseif($value==1){
                $st='<p style="color:red;font-size:120%;">Rejected';
                $ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_bdirm'].'</br> Alasan: '.$row['vRemark_bdirm'].'</p>';
            } 
        }
        else{
            $ret='Waiting for Approval';
        }
        $ret .= "<input type='hidden' name='".$field."' id='".$id."'  value='".$value."'/>";
        return $ret;
    }

    function insertBox_import_data_lounching_iupi_id($field, $id) {
        $return = '<script>
                        $( "button.icon_pop" ).button({
                            icons: {
                                primary: "ui-icon-newwin"
                            },
                            text: false
                        })
                    </script>';
        $return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />
                    ';

                    //Controlller Belum Dibuat
        $return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="10" />';
        $return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/import/browse/upi/launching/?field=import_data_lounching\',\'List UPI\')" type="button">&nbsp;</button>';


        return $return;
    }

    function updateBox_import_data_lounching_iupi_id($field, $id, $value, $rowData) {
        $sql = 'select a.iupi_id,a.vNo_upi,a.vNama_usulan from plc2.daftar_upi a where a.iupi_id ="'.$value.'" ';
        $data_upb = $this->dbset->query($sql)->row_array();
        if ($this->input->get('action') == 'view') {
            $return= $data_upb['vNo_upi'];

        }else{
            
            if ($rowData['iSubmit_launching'] == 0) {
                $return = '<script>
                            $( "button.icon_pop" ).button({
                                icons: {
                                    primary: "ui-icon-newwin"
                                },
                                text: false
                            })
                        </script>';
            $return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />
                        ';
            $return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="10" value="'.$data_upb['vNo_upi'].'"/>';

            //Controlller Belum Dibuat
            $return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/import/browse/upi/launching/?field=import_data_lounching\',\'List UPI\')" type="button">&nbsp;</button>';                
            
            
            }else{
                $return= $data_upb['vNo_upi'];
                $return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
            }
        }
        
        return $return;
    }

    function insertBox_import_data_lounching_cPengusul_upi($field, $id) {
        $return = '<input disabled="true" type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="35" />';
        return $return;
    }

    function updateBox_import_data_lounching_cPengusul_upi($field, $id, $value, $rowData) {
        $rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
        $rowss = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rows['cPengusul_upi']))->row_array();
        if ($this->input->get('action') == 'view') {
            $return= $rowss['vName'];

        }
        else{
                $return = '<input disabled="true" type="text" name="'.$field.'" size="35" readonly="readonly" id="'.$id.'" value="'.$rowss['vName'].'" class="input_rows1 required" size="10" />';

        }
        
        return $return;
    }

    function insertBox_import_data_lounching_vNama_usulan($field, $id) {
        $return = '<input type="text" name="'.$field.'"  disabled="true" id="'.$id.'" class="input_rows1 required" size="35" />
                    <input type="hidden" name="isdraft" id="isdraft">';
        return $return;
    }

    function updateBox_import_data_lounching_vNama_usulan($field, $id, $value, $rowData) {
        $rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
        if ($this->input->get('action') == 'view') {
            $return= $rows['vNama_usulan'];

        }
        else{
                $return = '<input type="text" name="'.$field.'" size="35" disabled="true" id="'.$id.'" value="'.$rows['vNama_usulan'].'" class="input_rows1 required" size="10" />
                <input type="hidden" name="isdraft" id="isdraft">';

        }
        
        return $return;
    }

    function insertBox_import_data_lounching_vKekuatan($field, $id) {
        $return = '<input type="text" name="'.$field.'" style="text-align:right;" disabled="true" id="'.$id.'" class="input_rows1 required" size="8" />';
        return $return;
    }

    function updateBox_import_data_lounching_vKekuatan($field, $id, $value, $rowData) {
        $rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
        if ($this->input->get('action') == 'view') {
            $return= $rows['vKekuatan'];

        }
        else{
                $return = '<input type="text" style="text-align:right;" name="'.$field.'" size="8" disabled="true" id="'.$id.'" value="'.$rows['vKekuatan'].'" class="input_rows1 required"/>';

        }
        
        return $return;
    }
    function insertBox_import_data_lounching_vDosis($field, $id) {
        $return = '<input type="text" style="text-align:right;" name="'.$field.'"  disabled="true" id="'.$id.'" class="input_rows1 required" size="8" />';
        return $return;
    }

    function updateBox_import_data_lounching_vDosis($field, $id, $value, $rowData) {
        $rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
        if ($this->input->get('action') == 'view') {
            $return= $rows['vDosis'];

        }
        else{
                $return = '<input style="text-align:right;" type="text" name="'.$field.'" size="8" disabled="true" id="'.$id.'" value="'.$rows['vDosis'].'" class="input_rows1 required"  />';

        }
        
        return $return;
    }
    function insertBox_import_data_lounching_vNama_generik($field, $id) {
        $return = '<input type="text" name="'.$field.'"  disabled="true" id="'.$id.'" class="input_rows1 required" size="35" />';
        return $return;
    }

    function updateBox_import_data_lounching_vNama_generik($field, $id, $value, $rowData) {
        $rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
        if ($this->input->get('action') == 'view') {
            $return= $rows['vNama_generik'];

        }
        else{
                $return = '<input type="text" name="'.$field.'" size="35" disabled="true" id="'.$id.'" value="'.$rows['vNama_generik'].'" class="input_rows1 required" size="10" />';

        }
        
        return $return;
    }

    function insertBox_import_data_lounching_vIndikasi($field, $id) {
        $o  = "<textarea name='".$id."' id='".$id."' class='required' disabled style='width: 260px; height: 50px;'size='250'></textarea>";      
        $o .= " <script>
                $('#".$id."').keyup(function() {
                var len = this.value.length;
                if (len >= 250) {
                this.value = this.value.substring(0, 250);
                }
                $('#maxlengthnote').text(250 - len);
                });
            </script>";
        $o .= '<br/>tersisa <span id="maxlengthnote">250</span> karakter<br/>';
    
                                            
        return $o;
    }

    function updateBox_import_data_lounching_vIndikasi($field, $id, $value, $rowData) {
        $rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
        if ($this->input->get('action') == 'view') { 
            $o = "<label title='Note'>".nl2br($rows['vIndikasi'])."</label>";
        
        }else{
            $o  = "<textarea name='".$id."' id='".$id."' class='required' disabled   style='width: 240px; height: 50px;'size='250'>".nl2br($rows['vIndikasi'])."</textarea>";       
            $o .= " <script>
                $('#".$id."').keyup(function() {
                var len = this.value.length;
                if (len >= 250) {
                this.value = this.value.substring(0, 250);
                }
                $('#maxlengthnote').text(250 - len);
                });
            </script>";
            $o .= '<br/>tersisa <span id="maxlengthnote">250</span> karakter<br/>';
        
        }

        return $o;
    }

    function insertBox_import_data_lounching_ikategori_id($field, $id) {
        
            $o  = "<select name='".$field."' id='".$id."' class='required' disabled='true'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.ikategori_id,a.vkategori from hrd.mnf_kategori a where a.ldeleted=0";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($id == $row['ikategori_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected}  value='".$row['ikategori_id']."'>".$row['vkategori']."</option>";
                }
            }
            $o .= "</select>";
            
            return $o;
    } 

    function updateBox_import_data_lounching_ikategori_id($field, $id, $value, $rowData) {
        $rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
        if ($this->input->get('action') == 'view') {
            $sql = 'select a.ikategori_id,a.vkategori from hrd.mnf_kategori a where a.ikategori_id= "'.$rows['ikategori_id'].'"';
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $o = $row->vkategori;
            }
        } else {

            $o  = "<select name='".$field."' id='".$id."' class='required' disabled='true'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.ikategori_id,a.vkategori from hrd.mnf_kategori a where a.ldeleted=0";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($rows['ikategori_id'] == $row['ikategori_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected} value='".$row['ikategori_id']."'>".$row['vkategori']."</option>";
                }
            }
        }   

            $o .= "</select>";
            
            return $o;
    } 

    function insertBox_import_data_lounching_fHarga($field, $id) {
        $return = '<input type="text" name="'.$field.'" style="text-align:right;"  id="'.$id.'" class="input_rows1 required angka2" size="8" />';
        $return .= '<script type="text/javascript">
                        $(".angka2").keyup(function(){
                            this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
                    </script>';
        return $return;
    }

    function insertBox_import_data_lounching_vMOQ($field, $id) {
        $return = '<input type="text" name="'.$field.'" style="text-align:left;" id="'.$id.'" class="input_rows1 required " size="8" />';
       
        return $return;
    }
    function insertBox_import_data_lounching_fFo_unit($field, $id) {
        $return = '<input type="text" name="'.$field.'" style="text-align:right;" id="'.$id.'" class="input_rows1 required angka2" size="8" />';
        $return .= '<script type="text/javascript">
                        $(".angka2").keyup(function(){
                            this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
                    </script>';
        return $return;
    }
    function insertBox_import_data_lounching_vSatuan($field, $id) {
        $return = '<input type="text" name="'.$field.'" style="text-align:left;"  id="'.$id.'" class="input_rows1 required" size="8" />';
        
        return $return;
    }
    function insertBox_import_data_lounching_vKonvert_satuan($field, $id) {
        $return = '<input type="text" name="'.$field.'" style="text-align:left;"  id="'.$id.'" class="input_rows1 required" size="8" />';
        return $return;
    }
    function insertBox_import_data_lounching_fFo_value($field, $id) {
        $return = '<input type="text" name="'.$field.'" style="text-align:right;" id="'.$id.'" class="input_rows1 required angka2" size="8" />';
        $return .= '<script type="text/javascript">
                        $(".angka2").keyup(function(){
                            this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
                    </script>';
        return $return;
    }


    function updateBox_import_data_lounching_fHarga($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
            $return= $value;

        }
        else{

            $return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required angka2" size="8" />';
            $return .= '<script type="text/javascript">
                        $(".angka2").keyup(function(){
                            this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
                    </script>';
        }
        return $return;
    }
     function updateBox_import_data_lounching_vMOQ($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
            $return= $value;

        }
        else{

            $return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required  size="8" />';
          
        }
        return $return;
    }
     function updateBox_import_data_lounching_vSatuan($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
            $return= $value;

        }
        else{

            $return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required " size="8" />';
           
        }
        return $return;
    }
     function updateBox_import_data_lounching_vKonvert_satuan($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
            $return= $value;

        }
        else{

            $return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="8" />';
        }
        return $return;
    }


     function updateBox_import_data_lounching_fFo_unit($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
            $return= $value;

        }
        else{

            $return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required angka2" size="8" />';
            $return .= '<script type="text/javascript">
                        $(".angka2").keyup(function(){
                            this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
                    </script>';
        }
        return $return;
    }
     function updateBox_import_data_lounching_fFo_value($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
            $return= $value;

        }
        else{

            $return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required angka2" size="8" />';
            $return .= '<script type="text/javascript">
                        $(".angka2").keyup(function(){
                            this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
                    </script>';
        }
        return $return;
    }
    function insertBox_import_data_lounching_dLeadtime_principla($field, $id){
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly" class="input_rows1 required angka2" size="8" />';
        $return .='<script>
                     $("#'.$id.'").datepicker({ changeMonth:true,
                                                changeYear:true,
                                                dateFormat:"yy-mm-dd" });
                </script>';
        return $return;
    }
    function updateBox_import_data_lounching_dLeadtime_principla($field, $id, $value, $rowData) {
        if($this->input->get('action')=='view'){
            $return =$value;
        }else{
        $return = '<input name="'.$id.'" id="'.$id.'" type="text" readonly="readonly" class="input_rows1 required angka2" size="8" value='.$value.' />';
        $return .=  '<script>
                        $("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
                    </script>';
        }
        return $return;
    }

    function insertBox_import_data_lounching_dTanggalPO($field, $id){
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly" class="input_rows1 required" size="8" />';
        $return .='<script>
                     $("#'.$id.'").datepicker({ changeMonth:true,
                                                changeYear:true,
                                                dateFormat:"yy-mm-dd" });
                </script>';
        return $return;
    }
    function updateBox_import_data_lounching_dTanggalPO($field, $id, $value, $rowData) {
        if($this->input->get('action')=='view'){
            $return =$value;
        }else{
        $return = '<input name="'.$id.'" id="'.$id.'" type="text" readonly="readonly" class="input_rows1 required" size="8" value='.$value.' />';
        $return .=  '<script>
                        $("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
                    </script>';
        }
        return $return;
    }

    function insertBox_import_data_lounching_vFileLaunching($field, $id) {
        $data['date'] = date('Y-m-d H:i:s');    
        return $this->load->view('import_launching_file',$data,TRUE);
    }
    function updateBox_import_data_lounching_vFileLaunching($field, $id, $value, $rowData) {
        
        $qr="select * from plc2.launching_file_upi where iLaunching_id='".$rowData['iLaunching_id']."' and lDeleted=0";
        $data['rows'] = $this->db_plc0->query($qr)->result_array();
        $data['date'] = date('Y-m-d H:i:s');    
        return $this->load->view('import_launching_file',$data,TRUE);
    }

    /* Manipulate Insert Button*/

    function manipulate_insert_button($buttons) {
        unset($buttons['save']);
        
        $js = $this->load->view('import_data_lounching_js');
        //$js .= $this->load->view('uploadjs');
        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'import_data_lounching\', \''.base_url().'processor/plc/import/data/lounching?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_import_data_lounching_js">Save as Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\'import_data_lounching\', \''.base_url().'processor/plc/import/data/lounching?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_import_data_lounching">Save &amp; Submit</button>';
        
        $buttons['save'] = $save_draft.$save.$js;

        return $buttons;
    }

    function manipulate_update_button($buttons, $rowData) {
            $mydept = $this->auth->my_depts(TRUE);
            $cNip= $this->user->gNIP;

            

            $update = '<button onclick="javascript:update_btn_back(\'import_data_lounching\', \''.base_url().'processor/plc/import/data/lounching?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_update_import_data_lounching">Update & Submit</button>';
            $updatedraft = '<button onclick="javascript:update_draft_btn(\'import_data_lounching\', \''.base_url().'processor/plc/import/data/lounching?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_import_data_lounching">Update as Draft</button>';

            $approve_bdirm = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/data/lounching?action=approve&iLaunching_id='.$rowData['iLaunching_id'].'&iupi_id='.$rowData['iupi_id'].'&cNip='.$cNip.'&lvl=1&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_import_data_lounching">Approve</button>';
            $reject_bdirm = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/data/lounching?action=reject&iLaunching_id='.$rowData['iLaunching_id'].'&iupi_id='.$rowData['iupi_id'].'&cNip='.$cNip.'&lvl=1&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_import_data_lounching">Reject</button>';

            $js = $this->load->view('import_data_lounching_js');

            if ($this->input->get('action') == 'view') {unset($buttons['update']);}

            else{
                
                unset($buttons['update_back']);
                unset($buttons['update']);
                
                if ($rowData['iSubmit_launching']== 0) {
                    // jika masih draft , show button update draft & update submit 
                    if (isset($mydept)) {
                        // cek punya dep
                        if((in_array('BDI', $mydept)) || (in_array('BDE', $mydept))) {
                                    $buttons['update'] = $update.$updatedraft.$js;
                        }
                    }

                }else{
                        if (isset($mydept)) {
                            if((in_array('BDI', $mydept))) {
                                if($this->auth->is_manager()){
                                    $buttons['update'] = $approve_bdirm.$reject_bdirm.$js;  
                                }
                            }
                        }   
                    
                }
            }

            return $buttons;

    }

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
                                var url = "'.base_url().'processor/plc/import/data/lounching";                                
                                if(o.status == true) {
                                    
                                    $("#alert_dialog_form").dialog("close");
                                         $.get(url+"?action=update&id="+last_id, function(data) {
                                         $("div#form_import_data_lounching").html(data);
                                         $("#button_approve_import_data_lounching").hide();
                                         $("#button_reject_import_data_lounching").hide();
                                    });
                                    
                                }
                                    reload_grid("grid_import_data_lounching");
                            }
                            
                         })
                     }
                 </script>';
        $echo .= '<h1>Approval</h1><br />';
        $echo .= '<form id="form_import_data_lounching_approve" action="'.base_url().'processor/plc/import/data/lounching?action=approve_process" method="post">';
        $echo .= '<div style="vertical-align: top;">';
        $echo .= 'Remark : 
                <input type="hidden" name="iLaunching_id" value="'.$this->input->get('iLaunching_id').'" />
                <input type="hidden" name="iupi_id" value="'.$this->input->get('iupi_id').'" />
                <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                <textarea name="vRemark"></textarea>
        <button type="button" onclick="submit_ajax(\'form_import_data_lounching_approve\')">Approve</button>';
            
        $echo .= '</div>';
        $echo .= '</form>';
        return $echo;
    }
    function approve_process() {
        $post = $this->input->post();
        $cNip= $this->user->gNIP;
        $vName= $this->user->gName;
        $ianalisa_prinsipal_id = $post['iLaunching_id'];
        $vRemark = $post['vRemark'];
        $iupi_id = $post['iupi_id'];
        //$ikategori_id = $post['ikategori_id'];
        $data =array();
        $data=array('iApprove_bdirm'=>'2','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>date('Y-m-d H:i:s'), 'vRemark_bdirm'=>$vRemark);
        $this -> db -> where('iLaunching_id', $ianalisa_prinsipal_id);
        //Uprofe
        $updet = $this -> db -> update('plc2.data_launching', $data);

        $data1 =array();
        $data1 = array('iApprove_launching'=>'2','cApprove_launching'=>$cNip , 'dApprove_launching'=>date('Y-m-d H:i:s'), 'vRemark_launching'=>$vRemark,'iStatus_launching'=>'2');
        $this -> db -> where('iupi_id', $iupi_id);
        //Uprofe
        $updet1 = $this -> db -> update('plc2.daftar_upi', $data1);

        $data['status']  = true;
        $data['last_id'] = $post['iLaunching_id'];
        return json_encode($data);
    }

    function reject_view() {
        $echo = '<script type="text/javascript">
                     function submit_ajax(form_id) {
                        var remark = $("#reject_import_uji_labs_remark").val();
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
                                var url = "'.base_url().'processor/plc/import/data/lounching";                                
                                if(o.status == true) {
                                    
                                    $("#alert_dialog_form").dialog("close");
                                         $.get(url+"?action=update&id="+last_id, function(data) {
                                         $("div#form_import_data_lounching").html(data);
                                         $("#button_approve_import_data_lounching").hide();
                                         $("#button_reject_import_data_lounching").hide();
                                    });
                                    
                                }
                                    reload_grid("grid_import_data_lounching");
                            }
                            
                         })
                     }
                 </script>';
        $echo .= '<h1>Reject</h1><br />';
        $echo .= '<form id="form_import_data_lounching_reject" action="'.base_url().'processor/plc/import/data/lounching?action=reject_process" method="post">';
        $echo .= '<div style="vertical-align: top;">';
        $echo .= 'Remark : 
                 <input type="hidden" name="iLaunching_id" value="'.$this->input->get('iLaunching_id').'" />
                <input type="hidden" name="iupi_id" value="'.$this->input->get('iupi_id').'" />
                <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                <textarea name="vRemark" id="reject_import_data_lounching_remark"></textarea>
        <button type="button" onclick="submit_ajax(\'form_import_data_lounching_reject\')">Reject</button>';
            
        $echo .= '</div>';
        $echo .= '</form>';
        return $echo;
    }
    
    function reject_process() {
        $post = $this->input->post();
        $cNip= $this->user->gNIP;
        $vName= $this->user->gName;
        $iujilab_id = $post['iLaunching_id'];
        $vRemark = $post['vRemark'];
        $iupi_id = $post['iupi_id'];

        $data=array('iApprove_bdirm'=>'1','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>date('Y-m-d H:i:s'), 'vRemark_bdirm'=>$vRemark);
        $this -> db -> where('iLaunching_id', $iujilab_id);
        $updet = $this -> db -> update('plc2.data_launching', $data);

        $data1 =array();
        $data1 = array('iApprove_launching'=>'1','cApprove_launching'=>$cNip , 'dApprove_launching'=>date('Y-m-d H:i:s'), 'vRemark_launching'=>$vRemark,'iStatus_launching'=>'1');
        $this -> db -> where('iupi_id', $iupi_id);
        //Uprofe
        $updet1 = $this -> db -> update('plc2.daftar_upi', $data1);

        $data['status']  = true;
        $data['last_id'] = $post['iLaunching_id'];
        return json_encode($data);
    }

    function downloadad($filename) {
        $this->load->helper('download');        
        $name = $_GET['filead'];
        $id = $_GET['id'];
        $path = file_get_contents('./files/plc/memo_launching/'.$id.'/'.$name);    
        force_download($name, $path);
    }




    function before_insert_processor($row, $postData) {

    // ubah status submit
        if($postData['isdraft']==true){
            $postData['iSubmit_launching']=0;
        } 
        else{
            $postData['iSubmit_launching']=1;
        } 
            $postData['dCreate'] = date('Y-m-d H:i:s');
            $postData['cCreated'] =$this->user->gNIP;
        
        return $postData;
    }
    function before_update_processor($row, $postData) {
    
        if($postData['isdraft']==true){
            $postData['iSubmit_launching']=0;
        } else{
            $postData['iSubmit_launching']=1;} 


        $postData['dupdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] =$this->user->gNIP;

        return $postData;

        }

   
    public function output(){
            $this->index($this->input->get('action'));
    }
}







