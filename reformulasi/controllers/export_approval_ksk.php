<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class export_approval_ksk extends MX_Controller {
	private $sess_auth;
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
        $grid->setTitle('Approval KSK');
        $grid->setTable('reformulasi.export_ro_detail_batch');
        $grid->setUrl('export_approval_ksk');
        $grid->addList('vNo_KSK','vNo_batch','export_ro.vRo_no','export_po.vpo_nomor','vSatuan_batch','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','isubmitKSK','iapprovekskQA');//'lPersen', 'yPersen',
        $grid->setSortBy('iexport_ro_detail_batch');
        $grid->setSortOrder('DESC'); //sort ordernya

		//align & width
		$grid->setLabel('iexport_ro_detail_batch', 'No Batch');
        $grid->setAlign('iexport_ro_detail_batch', 'center');
        $grid->setWidth('iexport_ro_detail_batch', '80');

        $grid->setLabel('dossier_upd.vUpd_no', 'No UPD');
        $grid->setAlign('dossier_upd.vUpd_no', 'center');
        $grid->setWidth('dossier_upd.vUpd_no', '80');

        $grid->setLabel('dossier_upd.vNama_usulan', 'Nama Usulan');
        $grid->setAlign('dossier_upd.vNama_usulan', 'center');
        $grid->setWidth('dossier_upd.vNama_usulan', '180');

        $grid->setLabel('export_request_sample.vRequest_no', 'No Request');
        $grid->setAlign('export_request_sample.vRequest_no', 'center');
        $grid->setWidth('export_request_sample.vRequest_no', '80');

        $grid->setLabel('export_ro.vRo_no', 'No RO');
        $grid->setAlign('export_ro.vRo_no', 'center');
        $grid->setWidth('export_ro.vRo_no', '80');

        $grid->setLabel('vNo_batch', 'No Batch');
        $grid->setAlign('vNo_batch', 'center');
        $grid->setWidth('vNo_batch', '80');

        $grid->setLabel('vNo_KSK', 'No KSK');
        $grid->setAlign('vNo_KSK', 'center');
        $grid->setWidth('vNo_KSK', '80');

        $grid->setLabel('vSatuan_batch', 'Satuan');
        $grid->setAlign('vSatuan_batch', 'center');
        $grid->setWidth('vSatuan_batch', '80');


        $grid->setLabel('export_po.vpo_nomor', 'No PO');
        $grid->setAlign('export_po.vpo_nomor', 'center');
        $grid->setWidth('export_po.vpo_nomor', '80');

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

        $grid->setLabel('iapprovekskQC', 'Approval QC');
        $grid->setAlign('iapprovekskQC', 'center');
        $grid->setWidth('iapprovekskQC', '150');

        $grid->setLabel('iapprovekskQA', 'Approval QA');
        $grid->setAlign('iapprovekskQA', 'center');
        $grid->setWidth('iapprovekskQA', '150');

        $grid->setLabel('isubmitKSK', 'Status Submit');
        $grid->setAlign('isubmitKSK', 'center');
        $grid->setWidth('isubmitKSK', '100');


        $grid->setWidth('vUploadfile', '100');
        $grid->setAlign('vUploadfile', 'left');
        $grid->setLabel('vUploadfile','Upload File');


		$grid->setLabel('iHasil_analisa_bb', 'Hasil Analisa & Release'); //Ganti Label
        $grid->setAlign('iHasil_analisa_bb', 'center'); //Align nya
        $grid->setWidth('iHasil_analisa_bb', '150'); // width nya

        $grid->addFields('iexport_ro_detail_batch','vUploadfile','iapprovekskQA');

        $grid->changeFieldType('isubmitKSK','combobox','',array('0'=>'Draft','1'=>'Submitted'));




        $grid->setRequired('vNo_req_refor','dstabilita','ireal','iaccelerated','ihasil','dhasil_stabilita');

        $grid->setJoinTable('reformulasi.export_ro_detail', 'export_ro_detail.iexport_ro_detail = export_ro_detail_batch.iexport_ro_detail', 'inner');

        $grid->setJoinTable('reformulasi.export_ro', 'export_ro.iexport_ro = export_ro_detail.iexport_ro', 'inner');

        $grid->setJoinTable('reformulasi.export_po', 'export_po.ipo_id = export_ro.ipo_id', 'inner');

        $grid->setJoinTable('reformulasi.export_request_sample_detail', 'export_request_sample_detail.iexport_request_sample_detail = export_ro_detail.iexport_request_sample_detail', 'inner');

        $grid->setJoinTable('reformulasi.export_request_sample', 'export_request_sample_detail.iexport_request_sample = export_request_sample.iexport_request_sample', 'inner');

        $grid->setJoinTable('reformulasi.export_req_refor', 'export_req_refor.iexport_req_refor = export_request_sample.iexport_req_refor', 'inner');

        $grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = export_req_refor.idossier_upd_id', 'inner');

        //Ikut Flow Harus Lab Kelar Dulu
        $grid->setQuery('export_req_refor.iexport_req_refor IN (SELECT DISTINCT(r.`iexport_req_refor`) AS iexport_req_refor FROM reformulasi.`export_refor_formula` r WHERE r.`ihslStabilita_lab` = 1 AND r.`iappd_StabilitaLab`=2)',null);

        $grid->setQuery('iTerimaPd = 1', null);

		$grid->setSearch('vNo_KSK','vNo_batch','export_ro.vRo_no','export_po.vpo_nomor','vSatuan_batch','dossier_upd.vUpd_no','dossier_upd.vNama_usulan');
        $grid->setFormUpload(TRUE);
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
                            $lastId=$_POST['export_approval_ksk_iexport_ro_detail_batch'];
                            $sql = array();
                            $sql1 = array();
                            $file_name= "";
                            $file_name1= "";

                            $fileId = array();
                            $path = realpath("files/reformulasi/export/export_approval_ksk");

                            if (!file_exists( $path."/".$this->input->post('export_approval_ksk_iexport_ro_detail_batch') )) {
                                mkdir($path."/".$this->input->post('export_approval_ksk_iexport_ro_detail_batch'), 0777, true);
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
                                    $this->hapusfile($path, $file_name, 'export_approval_ksk_file', $lastId);
                                    foreach ($_FILES['fileupload']["error"] as $key => $error) {
                                        if ($error == UPLOAD_ERR_OK) {
                                            $tmp_name = $_FILES['fileupload']["tmp_name"][$key];
                                            $name = $_FILES['fileupload']["name"][$key];
                                            $data['vFilename'] = $name;
                                            $data['id']=$this->input->post('export_approval_ksk_iexport_ro_detail_batch');
                                            $data['nip']=$this->user->gNIP;
                                            $data['dCreate'] = date('Y-m-d H:i:s');
                                            //$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));
                                            if(move_uploaded_file($tmp_name, $path."/".$this->input->post('export_approval_ksk_iexport_ro_detail_batch')."/".$name))
                                            {
                                                $sql[] = "INSERT INTO reformulasi.export_approval_ksk_file(iexport_ro_detail_batch, vFilename, dCreate, vKeterangan,cCreate)
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
                                    $this->hapusfile($path, $file_name, 'export_approval_ksk_file', $lastId);
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
        $path = file_get_contents('./files/reformulasi/export/export_approval_ksk/'.$id.'/'.$name);
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
        if ($row->isubmitKSK ==1) {
            if($this->auth_export->is_manager()){
                $x=$this->auth_export->tipe();
                $manager=$x['manager'];
                 if($row->iapprovekskQA==0){
                    if(in_array('QA', $manager)){
                        if($row->iapprovekskQA<>0){
                           unset($actions['edit']);
                           unset($actions['delete']);
                        }
                    } else{
                        unset($actions['edit']);
                           unset($actions['delete']);
                    }
                }else{
                     unset($actions['edit']);
                     unset($actions['delete']);
                }
            }else{
                unset($actions['edit']);
                unset($actions['delete']);
            }
        }

        return $actions;
    }

    function listBox_export_approval_ksk_cPic_analisa_bb($value, $pk, $name, $rowData) {
        $sql = "SELECT a.vName from hrd.employee a where a.cNip = '{$value}'";
        $query = $this->db->query($sql);
        $nama_group = '-';
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $nama_group = $row->vName;
        }

        return $nama_group;
    }

    function listBox_export_approval_ksk_iapprovekskQA($value) {
        if($value==0){$vstatus='Waiting for approval';}
        elseif($value==1){$vstatus='Rejected';}
        elseif($value==2){$vstatus='Approved';}
        return $vstatus;
    }


    function insertBox_export_approval_ksk_iapprovekskQA($field, $id) {
                $return ='';
                $return .= '
                            <script type="text/javascript">
                                $("label[for=\''.$id.'\']").hide();
                                $("label[for=\''.$id.'\']").next().css("margin-left",0);
                            </script>
                        ';
                $return .= '<div></div>';
                return $return;
            }
    function updateBox_export_approval_ksk_iapprovekskQA($field, $id, $value, $rowData) {
       if(($value <> 0) || (!empty($value))){
            $sql_dtapp = "SELECT * FROM reformulasi.`export_ro_detail_batch` a JOIN hrd.employee b on b.cNip=a.capprovekskQA
            WHERE a.`lDeleted` = 0 AND a.iexport_ro_detail_batch = '".$rowData['iexport_ro_detail_batch']."'";
            $row = $this->db->query($sql_dtapp)->row_array();

            if($value==2){
                $st='<i><p style="">Approved';
                $ret= $st.' oleh '.$row['vName'].' pada '.$row['dapprovekskQA'].'</br> Alasan: '.$row['tapprovekskQA'].'</p>';
            }
            elseif($value==1){
                $st='<i><p style="color:red;">Rejected';
                $ret= $st.' oleh '.$row['vName'].' pada '.$row['dapprovekskQA'].'</br> Alasan: '.$row['tapprovekskQA'].'</p>';
            }
        }
        else{
            $ret='Waiting for Approval';
        }
        $ret .= "</i><input type='hidden' name='".$field."' id='".$id."'  value='".$value."'/>";
        return $ret;
    }

    function insertBox_export_approval_ksk_iapprovekskQC($field, $id) {
                $return ='';
                $return .= '
                            <script type="text/javascript">
                                $("label[for=\''.$id.'\']").hide();
                                $("label[for=\''.$id.'\']").next().css("margin-left",0);
                            </script>
                        ';
                $return .= '<div></div>';
                return $return;
            }
    function updateBox_export_approval_ksk_iapprovekskQC($field, $id, $value, $rowData) {
       if(($value <> 0) || (!empty($value))){
            $sql_dtapp = "SELECT * FROM reformulasi.`export_ro_detail_batch` a JOIN hrd.employee b on b.cNip=a.capprovekskQC
            WHERE a.`lDeleted` = 0 AND a.iexport_ro_detail_batch = '".$rowData['iexport_ro_detail_batch']."'";
            $row = $this->db->query($sql_dtapp)->row_array();

            if($value==2){
                $st='<i><p style="">Approved';
                $ret= $st.' oleh '.$row['vName'].' pada '.$row['dapprovekskQC'].'</br> Alasan: '.$row['tapprovekskQC'].'</p>';
            }
            elseif($value==1){
                $st='<i><p style="color:red;">Rejected';
                $ret= $st.' oleh '.$row['vName'].' pada '.$row['dapprovekskQC'].'</br> Alasan: '.$row['tapprovekskQC'].'</p>';
            }
        }
        else{
            $ret='Waiting for Approval';
        }
        $ret .= "</i><input type='hidden' name='".$field."' id='".$id."'  value='".$value."'/>";
        return $ret;
    }


    function updateBox_export_approval_ksk_vUploadfile($field, $id, $value, $rowData) {
        $sq = "SELECT * FROM reformulasi.`export_approval_ksk_file` lr WHERE lr.`lDeleted` = 0 AND
        lr.`iexport_ro_detail_batch` ='".$rowData['iexport_ro_detail_batch']."'";
        $data['rows']=$this->db->query($sq)->result_array();
        $return = $this->load->view('export/sample/export_approval_ksk_file',$data,TRUE);
        $return .= '<input type="hidden" name="isdraft" id="isdraft" class="isdraft">';
        return $return;
    }



    function updateBox_export_approval_ksk_iexport_ro_detail_batch($field, $id, $value, $rowData) {
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

        $uri = 'export_approval_ksk';
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


    function updateBox_export_approval_ksk_iApprove_analisa_bb($field, $id, $value, $rowData) {
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



    function updateBox_export_approval_ksk_dTgl_expired($field, $id, $value, $rowData) {
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

    function updateBox_export_approval_ksk_dMulai_analisa_bb($field, $id, $value, $rowData) {
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

    function updateBox_export_approval_ksk_dSelesai_analisa_bb($field, $id, $value, $rowData) {
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

    function updateBox_export_approval_ksk_cPic_analisa_bb($field, $id, $value, $rowData) {
                $url=base_url().'processor/reformulasi/export/approval/ksk?action=getPicAnalisa';

                $sql="select * from hrd.employee em where em.cNip='".$rowData['cPic_analisa_bb']."'";
                $dt=$this->db->query($sql)->row_array();

                $cPic_analisa_bb=$dt['cNip'];
                $namepic=$dt['cNip']." - ".$dt['vName'];

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
                                    teamAD:  $( "#export_approval_ksk_iteam_pd" ).val(),

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
            $postData['isubmitKSK']=0;
        }
        else{
            $postData['isubmitKSK']=1;
        }
        $postData['dupdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] =$this->user->gNIP;

        return $postData;

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
                                var url = "'.base_url().'processor/reformulasi/export/approval/ksk";
                                if(o.status == true) {

                                    $("#alert_dialog_form").dialog("close");
                                         $.get(url+"?action=update&id="+last_id, function(data) {
                                         $("div#form_export_approval_ksk").html(data);
                                         $("#button_approve_export_approval_ksk").hide();
                                         $("#button_reject_export_approval_ksk").hide();
                                    });

                                }
                                    reload_grid("grid_export_approval_ksk");
                            }

                         })
                     }
                 </script>';
        $echo .= '<h1>Confirm</h1><br />';
        $echo .= '<form id="form_export_approval_ksk_approve" action="'.base_url().'processor/reformulasi/export/approval/ksk?action=approve_process" method="post">';
        $echo .= '<div style="vertical-align: top;">';
        $echo .= 'Remark :
                <input type="hidden" name="iexport_ro_detail_batch" value="'.$this->input->get('iexport_ro_detail_batch').'" />
                <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                <input type="hidden" name="statusgp" value="'.$this->input->get('statusgp').'" />
                <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                <textarea name="vRemark_analisa_bb"></textarea>
        <button type="button" onclick="submit_ajax(\'form_export_approval_ksk_approve\')">Confirm</button>';

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

        if($post['statusgp']==2){
            $data=array('iapprovekskQC'=>'2','capprovekskQC'=>$cNip , 'dapprovekskQC'=>date('Y-m-d H:i:s'), 'tapprovekskQC'=>$vRemark_analisa_bb);
            $this -> db -> where('iexport_ro_detail_batch', $iexport_ro_detail_batch);
            $updet = $this -> db -> update('reformulasi.export_ro_detail_batch', $data);
        }elseif ($post['statusgp']==1) {
            $data=array('iapprovekskQA'=>'2','capprovekskQA'=>$cNip , 'dapprovekskQA'=>date('Y-m-d H:i:s'), 'tapprovekskQA'=>$vRemark_analisa_bb);
            $this -> db -> where('iexport_ro_detail_batch', $iexport_ro_detail_batch);
            $updet = $this -> db -> update('reformulasi.export_ro_detail_batch', $data);
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
        $js = $this->load->view('export/sample/js/export_approval_ksk_js');
        $js .= $this->load->view('export/sample/js/upload_js');

        $approveQA = '<button onclick="javascript:load_popup(\''.base_url().'processor/reformulasi/export/approval/ksk?action=approve&iexport_ro_detail_batch='.$rowData['iexport_ro_detail_batch'].'&cNip='.$cNip.'&lvl=2&status=1&statusgp=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_export_approval_ksk">Approve by QA</button>';
        $approveQC = '<button onclick="javascript:load_popup(\''.base_url().'processor/reformulasi/export/approval/ksk?action=approve&iexport_ro_detail_batch='.$rowData['iexport_ro_detail_batch'].'&cNip='.$cNip.'&lvl=2&status=1&statusgp=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_export_approval_ksk">Approve by QC</button>';

        $rejectQA = '<button onclick="javascript:load_popup(\''.base_url().'processor/reformulasi/export/approval/ksk?action=reject&iexport_ro_detail_batch='.$rowData['iexport_ro_detail_batch'].'&cNip='.$cNip.'&lvl=1&status=2&statusgp=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_export_approval_ksk">Reject</button>';
        $rejectQC = '<button onclick="javascript:load_popup(\''.base_url().'processor/reformulasi/export/approval/ksk?action=reject&iexport_ro_detail_batch='.$rowData['iexport_ro_detail_batch'].'&cNip='.$cNip.'&lvl=1&status=2&statusgp=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_export_approval_ksk">Reject</button>';


        $update = '<button onclick="javascript:update_btn_back(\'export_approval_ksk\', \''.base_url().'processor/reformulasi/export/approval/ksk?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_export_approval_ksk">Update & Submit</button>';
        $updatedraft = '<button onclick="javascript:update_draft_btn(\'export_approval_ksk\', \''.base_url().'processor/reformulasi/export/approval/ksk?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_export_approval_ksk">Update as Draft</button>';



        if ($this->input->get('action') == 'view') {unset($buttons['update']);}

        else{

            unset($buttons['update_back']);
            unset($buttons['update']);

            if ($rowData['isubmitKSK'] == 0 or empty($rowData['isubmitKSK'])) {
                // jika masih draft , show button update draft & update submit
                //if (isset($mydept)) {
                    // cek punya dep
                    //if((in_array('AD', $mydept))) {
                        $buttons['update'] = $updatedraft.$update.$js;
                    //}
                //}

            }else{
                // sudah disubmit , show button approval
                if ($rowData['iapprovekskQA'] == 0) {
                   if($this->auth_export->is_manager()){
                        $x=$this->auth_export->tipe();
                        $manager=$x['manager'];
                        if(in_array('QA', $manager)){
                            $buttons['update'] = $approveQA.$js;
                        } else{ }
                        //echo 'dancuk';
                    }
                }else{}

            }
        }

        return $buttons;

    }


    public function output(){
            $this->index($this->input->get('action'));
    }
}
