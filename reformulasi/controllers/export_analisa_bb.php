<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class export_analisa_bb extends MX_Controller {
	private $sess_auth_export;
	private $dbset;
    function __construct() {
        parent::__construct();
		$this->load->library('auth_export');
        $this->load->library('lib_utilitas');
        $this->user = $this->auth_export->user(); 
        $this->dbset = $this->load->database('formulasi', false, true);
    }
    function index($action = '') {
    	$action = $this->input->get('action');
		
    	//Bikin Object Baru Nama nya $grid		
        $grid = new Grid;		
        $grid->setTitle('Analisa & Release BB');		
        $grid->setTable('reformulasi.export_ro_detail_batch');		
        $grid->setUrl('export_analisa_bb');
        $grid->addList('vNo_batch','dTgl_expired', 'iHasil_analisa_bb','cPic_analisa_bb','dMulai_analisa_bb','dSelesai_analisa_bb','iSubmit_analisa_bb','iApprove_analisa_bb');//'lPersen', 'yPersen', 
        $grid->setSortBy('iexport_ro_detail_batch');
        $grid->setSortOrder('DESC'); //sort ordernya
		
		//align & width
		$grid->setLabel('iexport_ro_detail_batch', 'No Batch'); 
        $grid->setAlign('iexport_ro_detail_batch', 'center'); 
        $grid->setWidth('iexport_ro_detail_batch', '80'); 

        $grid->setLabel('vNo_batch', 'No Batch'); 
        $grid->setAlign('vNo_batch', 'center'); 
        $grid->setWidth('vNo_batch', '80'); 

        $grid->setLabel('dTgl_expired', 'Tgl Expired'); 
        $grid->setAlign('dTgl_expired', 'center'); 
        $grid->setWidth('dTgl_expired', '80'); 

        $grid->setLabel('cPic_analisa_bb', 'PIC Analisa'); 
        $grid->setAlign('cPic_analisa_bb', 'left'); 
        $grid->setWidth('cPic_analisa_bb', '200'); 

        $grid->setLabel('dMulai_analisa_bb', 'Mulai Analisa'); 
        $grid->setAlign('dMulai_analisa_bb', 'center'); 
        $grid->setWidth('dMulai_analisa_bb', '90'); 

        $grid->setLabel('dSelesai_analisa_bb', 'Selesai Analisa'); 
        $grid->setAlign('dSelesai_analisa_bb', 'center'); 
        $grid->setWidth('dSelesai_analisa_bb', '90'); 

        $grid->setLabel('iApprove_analisa_bb', 'Status Approval'); 
        $grid->setAlign('iApprove_analisa_bb', 'center'); 
        $grid->setWidth('iApprove_analisa_bb', '150'); 

        $grid->setLabel('iSubmit_analisa_bb', 'Status Submit'); 
        $grid->setAlign('iSubmit_analisa_bb', 'center'); 
        $grid->setWidth('iSubmit_analisa_bb', '100'); 

        
        $grid->setWidth('vUploadfile', '100');
        $grid->setAlign('vUploadfile', 'left');
        $grid->setLabel('vUploadfile','Upload File');

        

        

        
		
		$grid->setLabel('iHasil_analisa_bb', 'Hasil Analisa & Release'); //Ganti Label
        $grid->setAlign('iHasil_analisa_bb', 'center'); //Align nya
        $grid->setWidth('iHasil_analisa_bb', '150'); // width nya
		
        $grid->addFields('iexport_ro_detail_batch','dTgl_expired','iHasil_analisa_bb','cPic_analisa_bb','dMulai_analisa_bb','dSelesai_analisa_bb','vUploadfile','iApprove_analisa_bb');
		
        $grid->changeFieldType('iSubmit_analisa_bb','combobox','',array('0'=>'Draft','1'=>'Submitted'));
        $grid->changeFieldType('iHasil_analisa_bb','combobox','',array(''=>'-','1'=>'Gagal','2'=>'Berhasil'));
        $grid->changeFieldType('iApprove_analisa_bb','combobox','',array('0'=>'Waiting Approval','1'=>'Rejected','2'=>'Approved'));

        //setQuery 
        $grid->setQuery('iTerimaPd = 1', null); 
		

        //set relation and join 
        //$grid->setRelation('cPic_analisa_bb','hrd.employee','cNip','vName','vName','left',array('lDeleted'=>0),array('vName'=>'asc'));

		//set search
        $grid->setSearch('vNo_batch', 'iHasil_analisa_bb');
		
		//set required
        $grid->setRequired('iexport_ro_detail_batch', 'iHasil_analisa_bb','dTgl_expired','cPic_analisa_bb','dMulai_analisa_bb','dSelesai_analisa_bb');	//Field yg mandatori

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
                            $isUpload = $this->input->get('isUpload');
                            $lastId=$_POST['export_analisa_bb_iexport_ro_detail_batch'];
                            $sql = array();
                            $sql1 = array();
                            $file_name= "";
                            $file_name1= "";
                            
                            $fileId = array();
                            $path = realpath("files/reformulasi/export/export_analisa_bb");
                    
                            if (!file_exists( $path."/".$this->input->post('export_analisa_bb_iexport_ro_detail_batch') )) {
                                mkdir($path."/".$this->input->post('export_analisa_bb_iexport_ro_detail_batch'), 0777, true);                      
                            }

                    
                            $file_vKeterangan = array();
                    
                            foreach($_POST as $key=>$value) {
                                                        
                                if ($key == 'file_vKeterangan') {
                                    foreach($value as $y=>$u) {
                                        $file_vKeterangan[$y] = $u;
                                    }
                                }
                                
                                
                                
                                //
                                if ($key == 'namafile') {
                                    foreach($value as $k=>$v) {
                                        $file_name[$k] = $v;
                                    }
                                }
                                
                                
                                
                                //
                                if ($key == 'fileid') {
                                    foreach($value as $k=>$v) {
                                        $fileId[$k] = $v;
                                    }
                                }
                                
                                
                            }
                    
                    
                            $last_index = 0;
                            
                    
                            if($isUpload) {
                                $j = $last_index;               
                                                            
                                if (isset($_FILES['fileupload'])) {
                                    $this->hapusfile($path, $file_name, 'export_analisa_bb_file', $lastId);
                                    foreach ($_FILES['fileupload']["error"] as $key => $error) {    
                                        if ($error == UPLOAD_ERR_OK) {
                                            $tmp_name = $_FILES['fileupload']["tmp_name"][$key];
                                            $name = $_FILES['fileupload']["name"][$key];
                                            $data['vFilename'] = $name;
                                            $data['id']=$this->input->post('export_analisa_bb_iexport_ro_detail_batch');
                                            $data['nip']=$this->user->gNIP;
                                            $data['dCreate'] = date('Y-m-d H:i:s');
                                            //$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));     
                                            if(move_uploaded_file($tmp_name, $path."/".$this->input->post('export_analisa_bb_iexport_ro_detail_batch')."/".$name)) 
                                            {                                   
                                                $sql[] = "INSERT INTO reformulasi.export_analisa_bb_file(iexport_ro_detail_batch, vFilename, dCreate, vKeterangan,cCreate) 
                                                    VALUES ('".$data['id']."', '".$data['vFilename']."','".$data['dCreate']."','".$file_vKeterangan[$j]."','".$data['nip']."')";                                                                      
                                                $j++;                                                                           
                                            }
                                            else{
                                            echo "Upload ke folder gagal";  
                                            }
                                        }
                                        
                                    }                       
                                        
                                    //print_r($sql);
                                    foreach($sql as $q) {
                                            try {
                                                    $this->db->query($q);
                                            }catch(Exception $e) {
                                                    die($e);
                                            }
                                    }
                                }   
                                
                                
                                $r['status'] = TRUE;
                                $r['last_id'] = $lastId;                    
                                echo json_encode($r);
                                exit();
                            }  else {
                                if (is_array($file_name)) {                                 
                                    //echo "adaaaaaaaaaaaaaaaaaaa";
                                    $this->hapusfile($path, $file_name, 'export_analisa_bb_file', $lastId);
                                }
                                                    
                                echo $grid->updated_form();
                            }
                            break;
                case 'delete':
                        echo $grid->delete_row();
                        break;
                case 'getPicAnalisa':
                        echo $this->getPicAnalisa();
                        break;
                case 'approve':
                        echo $this->approve_view();
                break;
                case 'approve_process':
                        echo $this->approve_process();
                break; 
                case 'download':
                        $this->download($this->input->get('file'));
                break;

                default:
                        $grid->render_grid();
                        break;
        }
    }

    function getPicAnalisa() {
            $teamAD = '5'; // 4 untuk departement ad

            $term = trim($this->input->get('term'));      
            $data = array();
            $sql = "select * 
                    from hrd.employee a
                    join hrd.company b on a.iCompanyID=b.iCompanyId
                    where 
                    a.lDeleted=0 
                    and  ( a.vName like '%".$term."%'  or  a.cNip like '%".$term."%' )
                    #hanya nip yang terdaftar pada team
                    and a.cNip in (select b.vnip 
                                       from reformulasi.reformulasi_team a 
                                       join reformulasi.reformulasi_team_item b on b.ireformulasi_team=a.ireformulasi_team
                                       where a.ldeleted=0
                                       and b.ldeleted=0
                                       and a.cDeptId= '".$teamAD."'
                                       and a.iTipe=2
                                       
                                       union 
                                       
                                        select a.vnip 
                                       from reformulasi.reformulasi_team a 
                                       where a.ldeleted=0
                                       and a.cDeptId= '".$teamAD."'
                                       and a.iTipe=2   
                                    )
                    ";
            //echo '<pre>'.$sql;
            $query = $this->db->query($sql);
            if ($query->num_rows > 0) {
                foreach($query->result_array() as $line) {
                    $row_array['value'] = trim($line['cNip']).' - '.trim($line['vName']);
                    $row_array['id']    = $line['cNip'];
                    $row_array['nama']    = trim($line['vName']);
                    array_push($data, $row_array);
                }
            }
            echo json_encode($data);
            exit;
    }

    function download($vFilename) {
        $this->load->helper('download');        
        $name = $vFilename;
        $id = $_GET['id']; 
        $path = file_get_contents('./files/reformulasi/export/export_analisa_bb/'.$id.'/'.$name);    
        force_download($name, $path);
    }

            function readDirektory($path, $empty="") {
                $vFilename = array();
                        
                if (empty($empty)) {
                    if ($handle = opendir($path)) {     
                        while (false !== ($entry = readdir($handle))) {
                           if ($entry != '.' && $entry != '..' && $entry != '.svn') {                   
                                //unlink($path."/".$entry);
                                $vFilename[] = $entry;
                            }
                        }       
                        closedir($handle);
                    }
                        
                    $x =  $vFilename;
                } else {
                    if ($handle = opendir($path)) {     
                        while (false !== ($entry = readdir($handle))) {
                           if ($entry != '.' && $entry != '..' && $entry != '.svn') {                   
                                //echo $path."/".$entry;
                                unlink($path."/".$entry);                   
                            }
                        }       
                        closedir($handle);
                    }
                    
                    $x = "";
                }
                
                return $x;
            }

            function hapusfile($path, $file_name, $table, $lastId){
                $path = $path."/".$lastId;
                $path = str_replace("\\", "/", $path);
                //echo 'cc : '.$file_name;
                //
                if (is_array($file_name)) {
                                
                    $list_dir  = $this->readDirektory($path);
                    $list_sql  = $this->readSQL($table, $lastId);
                    asort($file_name);      
                    asort($list_dir);       
                    asort($list_sql);
                    
                    //print_r($list_dir);
                    //print_r($list_sql);
                    //print_r($file_name);
                    //$del = array();
                    foreach($list_dir as $v) {              
                        if (!in_array($v, $file_name)) {                
                            unlink($path.'/'.$v);   
                        }           
                    }
                    foreach($list_sql as $v) {
                        if (!in_array($v, $file_name)) {                
                            $del = "delete from reformulasi.".$table." where iexport_ro_detail_batch = {$lastId} and vFilename= '{$v}'";
                            //echo $del;
                            mysql_query($del);  
                        }
                        
                    }
                    
                    //print_r($del);
                    //exit;
                } else {
                    $this->readDirektory($path, 1);
                    $this->readSQL($table, $lastId, 1);
                }
            } 

            function readSQL($table, $lastId, $empty="") {
                $list_file = array();
                if (empty($empty)) {
                    $sql = "SELECT vFilename from reformulasi.".$table." where iexport_ro_detail_batch=".$lastId;
                    $query = mysql_query($sql);
                    while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {  
                        $list_file[] = $row['vFilename'];
                    }
                    
                    $x = $list_file;
                } else {            
                    $sql = "SELECT vFilename from reformulasi.".$table." where iexport_ro_detail_batch=".$lastId;
                    $query = mysql_query($sql);
                    $sql2 = array();
                    while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
                        $sql2[] = "DELETE FROM reformulasi.".$table." where iexport_ro_detail_batch=".$lastId." and vFilename='".$row['vFilename']."'";         
                    }
                    
                    foreach($sql2 as $q) {
                        try {
                            mysql_query($q);
                        }catch(Exception $e) {
                            die($e);
                        }
                    }
                    
                  $x = "";
                }
                
                return $x;
            }



    
    /*manipulate object */
    
    function listBox_Action($row, $actions) {
        if ($row->iApprove_analisa_bb <> 0) {
            unset($actions['edit']);
            unset($actions['delete']);  
        }

        return $actions;
    }

    function listBox_export_analisa_bb_cPic_analisa_bb($value, $pk, $name, $rowData) {
        $sql = "SELECT a.vName from hrd.employee a where a.cNip = '{$value}'";
        $query = $this->db->query($sql);
        $nama_group = '-';
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $nama_group = $row->vName;
        }
        
        return $nama_group;
    }

    function updateBox_export_analisa_bb_vUploadfile($field, $id, $value, $rowData) {
        $sq = "SELECT * FROM reformulasi.`export_analisa_bb_file` lr WHERE lr.`lDeleted` = 0 AND  
        lr.`iexport_ro_detail_batch` ='".$rowData['iexport_ro_detail_batch']."'";
        $data['rows']=$this->db->query($sq)->result_array();
        $return = $this->load->view('export/sample/export_analisa_bb_file',$data,TRUE);
        return $return;
    }



    function updateBox_export_analisa_bb_iexport_ro_detail_batch($field, $id, $value, $rowData) {
        /*$sql = "SELECT * 
                FROM reformulasi.`export_req_refor` lr 
                join dossier.dossier_upd b on b.idossier_upd_id=lr.idossier_upd_id
                WHERE lr.`lDeleted` = 0 AND lr.`iexport_ro_detail_batch` = '".$value."'";*/
        $sql = "
                SELECT 
                a.vNo_batch,a.vNo_KSK
                ,c.vRo_no
                ,d.vnmsupp
                ,e.vpo_nomor
                ,f.raw_id
                ,g.vnama
                ,h.vRequest_no
                ,i.vno_export_req_refor
                ,j.vUpd_no,j.vNama_usulan
                ,a.* ,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*
                from reformulasi.export_ro_detail_batch a 
                join reformulasi.export_ro_detail b on b.iexport_ro_detail=a.iexport_ro_detail
                join reformulasi.export_ro c on c.iexport_ro=b.iexport_ro
                join hrd.mnf_supplier d on d.isupplier_id=c.isupplier_id
                join reformulasi.export_po e on e.ipo_id=c.ipo_id
                join reformulasi.export_request_sample_detail f on f.iexport_request_sample_detail=b.iexport_request_sample_detail
                join plc2.plc2_raw_material g on g.raw_id=f.raw_id
                join reformulasi.export_request_sample h on h.iexport_request_sample=f.iexport_request_sample
                join reformulasi.export_req_refor i on i.iexport_req_refor=h.iexport_req_refor
                join dossier.dossier_upd j on j.idossier_upd_id=i.idossier_upd_id
                where a.lDeleted=0
                and b.lDeleted=0
                and a.iexport_ro_detail_batch='".$value."';

        ";        
        $dt = $this->db->query($sql)->row_array();

        
        if(!empty($dt['iexport_ro_detail_batch'])){

                
        }

        $uri = 'export_analisa_bb';
        $o = "";  
        $o   .= "<div style='
                        padding: 3px;
                        width: 700px;
                        border: 1px solid rgba(51, 23, 93, 0.2);
                        background-color: #FFF;'>";
        
        
        $o   .= "<table border='0' style='width: 100%;'>
                    <tbody>";  
        
        $o  .="         
                        <tr>
                            <td width='20%'>No Batch</td>
                            <td>:</td>
                            <td width='75%'> 
                                <span class='".$uri."_vNo_batch' id='".$uri."_vNo_batch'>".$dt['vNo_batch']."</span>
                            </td>
                        </tr>

                        <tr>
                            <td width='20%'>Batch Ke- </td>
                            <td>:</td>
                            <td width='75%'> 
                                <span class='".$uri."_iBatch_ke' id='".$uri."_iBatch_ke'>".$dt['iBatch_ke']."</span>
                            </td>
                        </tr>

                        <tr>
                            <td width='20%'>No KSK</td>
                            <td>:</td>
                            <td width='75%'> 
                                <span class='".$uri."_vNo_KSK' id='".$uri."_vNo_KSK'>".$dt['vNo_KSK']."</span>
                            </td>
                        </tr>



                        <tr>
                            <td width='20%'>No PO</td>
                            <td>:</td>
                            <td width='75%'> 
                                <span class='".$uri."_vpo_nomor' id='".$uri."_vpo_nomor'>".$dt['vpo_nomor']."</span>
                            </td>
                        </tr>

                        <tr>
                            <td width='20%'>No Penerimaan</td>
                            <td>:</td>
                            <td width='75%'> 
                                <span class='".$uri."_vRo_no' id='".$uri."_vRo_no'>".$dt['vRo_no']."</span>
                            </td>
                        </tr>

                        <tr>
                            <td width='20%'>Supplier</td>
                            <td>:</td>
                            <td width='75%'> 
                                <span class='".$uri."_vnmsupp' id='".$uri."_vnmsupp'>".$dt['vnmsupp']."</span>
                            </td>
                        </tr>

                        <tr>
                            <td width='20%'>Bahan Baku</td>
                            <td>:</td>
                            <td width='75%'> 
                                <span class='".$uri."_vnama' id='".$uri."_vnama'>".$dt['vnama']."</span>
                            </td>
                        </tr>

                        <tr>
                            <td width='20%'>No Permintaan Sample</td>
                            <td>:</td>
                            <td width='75%'> 
                                <span class='".$uri."_vRequest_no' id='".$uri."_vRequest_no'>".$dt['vRequest_no']."</span>
                            </td>
                        </tr>

                        <tr>
                            <td width='20%'>No Request Reformulasi</td>
                            <td>:</td>
                            <td width='75%'> 
                                <span class='".$uri."_vno_export_req_refor' id='".$uri."_vno_export_req_refor'>".$dt['vno_export_req_refor']."</span>
                            </td>
                        </tr>

                        <tr>
                            <td width='20%'>No UPD</td>
                            <td>:</td>
                            <td width='75%'> 
                                <span class='".$uri."_vUpd_no' id='".$uri."_vUpd_no'>".$dt['vUpd_no']."</span>
                            </td>
                        </tr>

                        <tr>
                            <td width='20%'>Nama Produk </td>
                            <td>:</td>
                            <td width='75%'> 
                                <span class='".$uri."_vNama_usulan' id='".$uri."_vNama_usulan'>".$dt['vNama_usulan']."</span>
                            </td>
                        </tr>

                        
                    </tbody>    
                </table>"; 
        $o .= "    </div>";  

        $o .= '<script>
                $( "button.icon_pop" ).button({
                    icons: {
                        primary: "ui-icon-newwin"
                    }, 
                })
            </script>';

             
        return $o;
    }


    function updateBox_export_analisa_bb_iApprove_analisa_bb($field, $id, $value, $rowData) {
        //print_r($rowData);
        if(($value <> 0) || (!empty($value))){
            $sql_dtapp = 'select * 
                        from reformulasi.export_ro_detail_batch a 
                        join hrd.employee b on b.cNip=a.cApprove_analisa_bb
                        where
                        a.lDeleted = 0
                        and  a.iexport_ro_detail_batch = "'.$rowData['iexport_ro_detail_batch'].'"';
            $row = $this->db->query($sql_dtapp)->row_array();
            if($value==2){
                $st='<p style="color:green;font-size:120%;">Approved';
                $ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_analisa_bb'].'</br> Alasan: '.$row['vRemark_analisa_bb'].'</p>';
            }
            elseif($value==1){
                $st='<p style="color:red;font-size:120%;">Rejected';
                $ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_analisa_bb'].'</br> Alasan: '.$row['vRemark_analisa_bb'].'</p>';
            } 

            
            
            
        }
        else{
            $ret='Waiting for Approval';
        }
        
        return $ret;
    }

    

    function updateBox_export_analisa_bb_dTgl_expired($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
             $return= $value; 
        }else{
        $return = '
                    <input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required tanggal" size="8" value="'.$value.'"/>
                    <input type="hidden" name="isdraft" id="isdraft">
                    ';
        $return .= '<script>
                        $("#'.$id.'").keyup(function() {
                             this.value = this.value.replace(/[^0-9\.]/g,"");
                        });

                         // datepicker
                         $(".tanggal").datepicker({changeMonth:true,
                                                    changeYear:true,
                                                    dateFormat:"yy-mm-dd" });

                        // input number
                           $(".angka").numeric();

                     </script>';
        } 
        return $return;
    }

    function updateBox_export_analisa_bb_dMulai_analisa_bb($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
             $return= $value; 
        }else{
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required tanggal" size="8" value="'.$value.'"/>';
        $return .= '<script>
                        $("#'.$id.'").keyup(function() {
                             this.value = this.value.replace(/[^0-9\.]/g,"");
                        });

                         // datepicker
                         $(".tanggal").datepicker({changeMonth:true,
                                                    changeYear:true,
                                                    dateFormat:"yy-mm-dd" });

                        // input number
                           $(".angka").numeric();

                     </script>';
        } 
        return $return;
    }

    function updateBox_export_analisa_bb_dSelesai_analisa_bb($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
             $return= $value; 
        }else{
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required tanggal" size="8" value="'.$value.'"/>';
        $return .= '<script>
                        $("#'.$id.'").keyup(function() {
                             this.value = this.value.replace(/[^0-9\.]/g,"");
                        });

                         // datepicker
                         $(".tanggal").datepicker({changeMonth:true,
                                                    changeYear:true,
                                                    dateFormat:"yy-mm-dd" });

                        // input number
                           $(".angka").numeric();
                       
                     </script>';
        } 
        return $return;
    }

    function updateBox_export_analisa_bb_cPic_analisa_bb($field, $id, $value, $rowData) {
                $url=base_url().'processor/reformulasi/export/analisa/bb?action=getPicAnalisa';

                $sql="select * from hrd.employee em where em.cNip='".$rowData['cPic_analisa_bb']."'";
                $dt=$this->db->query($sql)->row_array();

                if (empty($dt)) {
                    $cPic_analisa_bb='';
                    $namepic='';
                }else{
                    $cPic_analisa_bb=$dt['cNip'];
                    $namepic=$dt['cNip']." - ".$dt['vName'];    
                }
                

                if ($this->input->get('action') == 'view') {
                    $re = $namepic;
                }else{
                     $re="
                    <input name='".$field."'  id='".$id."' type='hidden' value='".$cPic_analisa_bb."' class='required' />
                    <input name='".$field."_dis'  id='".$id."_dis' type='text' size='40' value='".$namepic."' class='required' />";     
                }


               
                $re.='<script>
                    var config3 = {
                        source: function( request, response) {
                            $.ajax({
                                url: "'.$url.'",
                                beforeSend: function(){
                                    $( "#'.$id.'" ).val("");
                                },
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    teamAD:  $( "#export_analisa_bb_iteam_pd" ).val(),

                                },
                                success: function( data ) {
                                    response( data );
                                }
                            });
                        },
                        select: function(event, ui){
                            $( "#'.$id.'" ).val(ui.item.id);
                            $( "#'.$id.'_dis" ).val(ui.item.value);
                            return false;
                        },
                        minLength: 2,
                        autoFocus: true,
                    };

                    $( "#'.$id.'_dis" ).livequery(function() {
                        $( this ).autocomplete(config3);
                    });
                </script>';
                return $re;
            }




    function before_update_processor($row, $postData) {
    
        // ubah status submit
        if($postData['isdraft']==true){
            $postData['iSubmit_analisa_bb']=0;
        } 
        else{$postData['iSubmit_analisa_bb']=1;} 
        $postData['dupdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] =$this->user->gNIP;
        
        return $postData;

    }

    function after_update_processor($fields, $id, $postData) {
        $post = $this->input->post();

        $qsql = "
                SELECT 
                a.vNo_batch,a.vNo_KSK
                ,c.vRo_no
                ,d.vnmsupp
                ,e.vpo_nomor
                ,f.raw_id
                ,g.vnama
                ,h.vRequest_no
                ,i.vno_export_req_refor
                ,j.vUpd_no,j.vNama_usulan
                ,a.* 
                ,i.*
                ,g.*
                ,k.*
                #,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*
                from reformulasi.export_ro_detail_batch a 
                join reformulasi.export_ro_detail b on b.iexport_ro_detail=a.iexport_ro_detail
                join reformulasi.export_ro c on c.iexport_ro=b.iexport_ro
                join hrd.mnf_supplier d on d.isupplier_id=c.isupplier_id
                join reformulasi.export_po e on e.ipo_id=c.ipo_id
                join reformulasi.export_request_sample_detail f on f.iexport_request_sample_detail=b.iexport_request_sample_detail
                join plc2.plc2_raw_material g on g.raw_id=f.raw_id
                join reformulasi.export_request_sample h on h.iexport_request_sample=f.iexport_request_sample
                join reformulasi.export_req_refor i on i.iexport_req_refor=h.iexport_req_refor
                join dossier.dossier_upd j on j.idossier_upd_id=i.idossier_upd_id
                join hrd.employee k on k.cNip=a.cPic_analisa_bb
                where a.lDeleted=0
                and b.lDeleted=0
                and a.iexport_ro_detail_batch='".$id."';

        ";        

        $rsql = $this->db->query($qsql)->row_array();
        //echo $qsql;
        if ($rsql['iSubmit_analisa_bb']==1) {
            // kirim notifikasi message ERp
            $sqlEmpAr = 'select * from reformulasi.mailsparam a where a.cVariable="export_analisa_bb_submit "';
            $dEmpAr =  $this->db->query($sqlEmpAr)->row_array();

               

            $to = $dEmpAr['vTo'];
            $cc = $dEmpAr['vCc'];

            

            $pd = $rsql['iTeamPD'];
            $andev = $rsql['iTeamAndev'];
            $qa = '10';


            $jointeam = $pd.','.$andev.','.$qa;
            $toEmail = $this->lib_utilitas->get_nip_team( $jointeam );
            $to = $to.','.$toEmail;
            $cc = $cc.','.$this->user->gNIP;                        

            $subject = 'Reformulasi - New Analisa & Release BB '.$rsql['vnama'];
            $content="
                Diberitahukan bahwa telah ada Submitted Analisa & Release BB dengan rincian sebagai berikut :<br><br>  
                    <table border='0' style='width: 600px;'>
                        <tr>
                                <td style='width: 110px;'><b>Penguji</b></td><td style='width: 20px;'> : </td>
                                <td>".$rsql['cNip'].' || '.$rsql['vName']."</td>
                        </tr>
                        <tr>
                                <td><b>No Request Sample  </b></td><td> : </td>
                                <td>".$rsql['vRequest_no']."</td>
                        </tr> 
                        <tr>
                                <td><b>Nama Bahan baku  </b></td><td> : </td>
                                <td>".$rsql['vnama']."</td>
                        </tr> 
                        <tr>
                                <td><b>Tanggal Pengujian  </b></td><td> : </td>
                                <td>".$rsql['dMulai_analisa_bb']." s/d".$rsql['dSelesai_analisa_bb']."</td>
                        </tr> 
                    </table> 

                <br/> <br/>
                Demikian, mohon segera follow up  pada aplikasi ERP Reformulasi. Terimakasih.<br><br><br>
                Post Master"; 
            
            $this->sess_auth->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
        }



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
                                var url = "'.base_url().'processor/reformulasi/export/analisa/bb";                                
                                if(o.status == true) {
                                    
                                    $("#alert_dialog_form").dialog("close");
                                         $.get(url+"?action=update&id="+last_id, function(data) {
                                         $("div#form_export_analisa_bb").html(data);
                                         $("#button_approve_export_analisa_bb").hide();
                                         $("#button_reject_export_analisa_bb").hide();
                                    });
                                    
                                }
                                    reload_grid("grid_export_analisa_bb");
                            }
                            
                         })
                     }
                 </script>';
        $echo .= '<h1>Confirm</h1><br />';
        $echo .= '<form id="form_export_analisa_bb_approve" action="'.base_url().'processor/reformulasi/export/analisa/bb?action=approve_process" method="post">';
        $echo .= '<div style="vertical-align: top;">';
        $echo .= 'Remark : 
                <input type="hidden" name="iexport_ro_detail_batch" value="'.$this->input->get('iexport_ro_detail_batch').'" />
                <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                <textarea name="vRemark_analisa_bb"></textarea>
        <button type="button" onclick="submit_ajax(\'form_export_analisa_bb_approve\')">Confirm</button>';
            
        $echo .= '</div>';
        $echo .= '</form>';
        return $echo;
    }

    
    function approve_process() {
        $post = $this->input->post();
        $cNip= $this->user->gNIP;
        $vName= $this->user->gName;
        $iexport_ro_detail_batch = $post['iexport_ro_detail_batch'];
        $lvl = $post['lvl'];
        $vRemark_analisa_bb = $post['vRemark_analisa_bb'];

        
        $data=array('iApprove_analisa_bb'=>'2','cApprove_analisa_bb'=>$cNip , 'dApprove_analisa_bb'=>date('Y-m-d H:i:s'), 'vRemark_analisa_bb'=>$vRemark_analisa_bb);
        $this -> db -> where('iexport_ro_detail_batch', $iexport_ro_detail_batch);
        $updet = $this -> db -> update('reformulasi.export_ro_detail_batch', $data);


        $qsql = "
                SELECT 
                a.vNo_batch,a.vNo_KSK
                ,c.vRo_no
                ,d.vnmsupp
                ,e.vpo_nomor
                ,f.raw_id
                ,g.vnama
                ,h.vRequest_no
                ,h.iTujuan_request
                ,i.`iTeamAndev`
                ,i.`iTeamPD`
                ,i.vno_export_req_refor
                ,j.vUpd_no,j.vNama_usulan
                ,a.* 
                ,i.*
                ,g.*
                ,k.*
                ,i.cPicFormulator as requestor_sample
                #,b.*,c.*,d.*,e.*,f.*,g.*,h.*,i.*,j.*
                from reformulasi.export_ro_detail_batch a 
                join reformulasi.export_ro_detail b on b.iexport_ro_detail=a.iexport_ro_detail
                join reformulasi.export_ro c on c.iexport_ro=b.iexport_ro
                join hrd.mnf_supplier d on d.isupplier_id=c.isupplier_id
                join reformulasi.export_po e on e.ipo_id=c.ipo_id
                join reformulasi.export_request_sample_detail f on f.iexport_request_sample_detail=b.iexport_request_sample_detail
                join plc2.plc2_raw_material g on g.raw_id=f.raw_id
                join reformulasi.export_request_sample h on h.iexport_request_sample=f.iexport_request_sample
                join reformulasi.export_req_refor i on i.iexport_req_refor=h.iexport_req_refor
                join dossier.dossier_upd j on j.idossier_upd_id=i.idossier_upd_id
                join hrd.employee k on k.cNip=a.cPic_analisa_bb
                where a.lDeleted=0
                and b.lDeleted=0
                and a.iexport_ro_detail_batch='".$iexport_ro_detail_batch."';

        ";        

        $rsql = $this->db->query($qsql)->row_array();
        //echo $qsql;
        if ($updet) {
            // kirim notifikasi message ERp
            $sqlEmpAr = 'select * from reformulasi.mailsparam a where a.cVariable="export_analisa_bb_submit "';
            $dEmpAr =  $this->db->query($sqlEmpAr)->row_array();

               

            $to = $dEmpAr['vTo'];
            $cc = $dEmpAr['vCc'];

            

            if(empty($rsql['iTeamPD'])){
                $rsql['iTeamPD'] = 10;
            }

            if(empty($rsql['iTeamAndev'])){
                $rsql['iTeamAndev'] = 10;
            }
            
            $pd = $rsql['iTeamPD'];
            $andev = $rsql['iTeamAndev'];


            $qa = '10';


            $jointeam = $pd.','.$andev.','.$qa;
            $toEmail = $this->lib_utilitas->get_nip_team( $jointeam );
            $to = $to.','.$toEmail;
            $cc = $cc.','.$this->user->gNIP;                        

            $subject = 'Reformulasi - Approval Analisa & Release BB '.$rsql['vnama'];
            $content="
                Diberitahukan bahwa telah ada Approval Analisa & Release BB dengan rincian sebagai berikut :<br><br>  
                    <table border='0' style='width: 600px;'>
                        <tr>
                                <td style='width: 110px;'><b>Penguji</b></td><td style='width: 20px;'> : </td>
                                <td>".$rsql['cNip'].' || '.$rsql['vName']."</td>
                        </tr>
                        <tr>
                                <td><b>No Request Sample  </b></td><td> : </td>
                                <td>".$rsql['vRequest_no']."</td>
                        </tr> 
                        <tr>
                                <td><b>Nama Bahan baku  </b></td><td> : </td>
                                <td>".$rsql['vnama']."</td>
                        </tr> 
                        <tr>
                                <td><b>Tanggal Pengujian  </b></td><td> : </td>
                                <td>".$rsql['dMulai_analisa_bb']." s/d".$rsql['dSelesai_analisa_bb']."</td>
                        </tr> 
                    </table> 

                <br/> <br/>
                Demikian, mohon segera follow up  pada aplikasi ERP Reformulasi. Terimakasih.<br><br><br>
                Post Master"; 
            
            $this->sess_auth->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);


            /*jika hasil analisa TMS maka langsung generate header permintaan sample*/
            if ($rsql['iHasil_analisa_bb']==1) { 
                // Tambahain Validasi Lagi

                // $sqlGetRo = "SELECT er.`iexport_ro_detail` FROM reformulasi.`export_ro_detail_batch` er WHERE er.`lDeleted` = 0 
                //     AND er.`iexport_ro_detail_batch` = '".$iexport_ro_detail_batch."' LIMIT 1";
                // $dRode = $this->db->query($sqlGetRo)->row_array();

                // $sqlCoun = "SELECT er.`iexport_ro_detail` FROM reformulasi.`export_ro_detail_batch` er 
                //     WHERE er.`lDeleted` = 0 AND er.`iexport_ro_detail` = '".$dRode['iexport_ro_detail']."'";
                // $numTotMin = $this->db->query($sqlCoun)->num_rows()-1;

                // $sqlCountNow  ="SELECT er.`iexport_ro_detail` FROM reformulasi.`export_ro_detail_batch` er WHERE er.`lDeleted` = 0 
                //     AND er.`iHasil_analisa_bb` = 1 AND er.`iApprove_analisa_bb` = 2  
                //     AND er.`iexport_ro_detail` = '".$dRode['iexport_ro_detail']."'";
                // $numTotCur = $this->db->query($sqlCountNow)->num_rows();

               // if($numTotMin==$numTotCur){
                    $datasample=array();
                    $datasample['iTujuan_request'] =$rsql['iTujuan_request'];
                    $datasample['iexport_req_refor'] = $rsql['iexport_req_refor'];
                    $datasample['cRequestor'] = $rsql['requestor_sample'];
                    $datasample['dTgl_request'] = date('Y-m-d H:i:s');
                    $datasample['cCreated']=$this->user->gNIP;
                    $datasample['dCreate'] = date('Y-m-d H:i:s');

                    $ins = $this -> db -> insert('reformulasi.export_request_sample', $datasample);
                    $idnew=$this->db->insert_id();

                    if ($ins) {
                        $nomor = "RS".str_pad($idnew, 8, "0", STR_PAD_LEFT);
                        $sql = "UPDATE reformulasi.export_request_sample SET vRequest_no = '".$nomor."' WHERE iexport_request_sample=$idnew LIMIT 1";
                        $query = $this->db->query( $sql );
                    }
                //} 
            }


            




        }



        $data['status']  = true;
        $data['last_id'] = $post['iexport_ro_detail_batch'];
        return json_encode($data);
    }


	
    function manipulate_update_button($buttons, $rowData) {
        //$rows = $this->db->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id'],'ldeleted'=>0))->row_array();
        //$idtim_bd =$rows['iteambusdev_id'];
        $mydept = $this->auth_export->my_depts(TRUE);
        $cNip= $this->user->gNIP;
        $js = $this->load->view('export/sample/js/export_analisa_bb_js');
        $js .= $this->load->view('export/sample/js/upload_js');
        
        $approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/reformulasi/export/analisa/bb?action=approve&iexport_ro_detail_batch='.$rowData['iexport_ro_detail_batch'].'&cNip='.$cNip.'&lvl=2&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_export_analisa_bb">Confirm</button>';
        $update = '<button onclick="javascript:update_btn_back(\'export_analisa_bb\', \''.base_url().'processor/reformulasi/export/analisa/bb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_export_analisa_bb">Update & Submit</button>';
        $updatedraft = '<button onclick="javascript:update_draft_btn(\'export_analisa_bb\', \''.base_url().'processor/reformulasi/export/analisa/bb?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_export_analisa_bb">Update as Draft</button>';



        if ($this->input->get('action') == 'view') {unset($buttons['update']);}

        else{
            
            unset($buttons['update_back']);
            unset($buttons['update']);
            
            if ($rowData['iSubmit_analisa_bb']== 0) {
                // jika masih draft , show button update draft & update submit 
                if (isset($mydept)) {
                    // cek punya dep
                    if((in_array('AD', $mydept))) {
                        $buttons['update'] = $update.$updatedraft.$js;
                    }
                }

            }else{
                // sudah disubmit , show button approval 
                if ($rowData['iApprove_analisa_bb'] == 0) {
                     // jika approval bdirm 0 
                    if (isset($mydept)) {
                        if((in_array('AD', $mydept))) {
                            if($this->auth_export->is_manager()){
                                $buttons['update'] = $approve.$js;  
                            }else{
                                $sqlcekapp='select * 
                                            from reformulasi.reformulasi_team_item i 
                                            join reformulasi.reformulasi_team t on t.ireformulasi_team=i.ireformulasi_team
                                            where i.vnip="'.$cNip.'" 
                                            and i.ldeleted=0 
                                            and cDeptId=5
                                            and iapprove=1';
                                //echo '<pre>'.$sqlcekapp;
                                $qce=$this->dbset->query($sqlcekapp);
                                if($qce->num_rows()>=1){
                                    $dce=$qce->row_array();
                                    if($dce['iapprove']==1){
                                        $buttons['update'] = $approve.$js;
                                    }
                                }
                            }
                        }
                    }


                }   
                
            }
        }

        return $buttons;

    }
    

    public function output(){
            $this->index($this->input->get('action'));
    }
}
