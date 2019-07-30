<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class pk_pd3_asc extends MX_Controller {
  private $sess_auth;
  private $db_erp_pk;
    function __construct() {
        parent::__construct();
        $this->sess_auth = new Zend_Session_Namespace('auth'); 
        $this->db_erp_pk = $this->load->database('pk', false,true);
        $this->url = 'pk_pd3_asc'; 
        //$this->load->helper('encrypt');
        $this->load->library('lib_utilitas');
        $this->load->library('lib_pk_pd3_asc');
        
        $this->report = $this->load->library('report');
        //$this->config->load('config_hd');
    }
    function index($action = '') {
      $action = $this->input->get('action');
      //Bikin Object Baru Nama nya $grid    
      $grid = new Grid;
      $grid->setTitle('PK Product Development');    
      $grid->setTable('hrd.pk_trans');    
      $grid->setUrl('pk_pd3_asc');
      $grid->addList('cNip','employee.vName','iPostId','dPk','cTahun','iSemester','iStatus');
      $grid->addFields('cNip','iPostId','dPk','iProbation','cTahun','iSemester','cPeriode','iSkemaId','detail','lampiran');

      $grid->setSortBy('id');
      $grid->setSortOrder('desc'); //sort ordernya

      $grid->setWidth('iPostId', '200'); // width nya
      $grid->setLabel('iPostId','Jabatan'); //Ganti Label
      $grid->setAlign('iPostId', 'left'); //Align nya

      $grid->setWidth('cNip', '50'); // width nya
      $grid->setLabel('cNip','NIP'); //Ganti Label
      $grid->setAlign('cNip', 'left'); //Align nya

      $grid->setWidth('employee.vName', '200'); // width nya
      $grid->setLabel('employee.vName','Employee'); //Ganti Label
      $grid->setAlign('employee.vName', 'left'); //Align nya

      $grid->setLabel('dPk', 'Tgl Penilaian'); //Ganti Label
      $grid->setWidth('dPk', '100'); // width nya
      $grid->setAlign('dPk', 'center'); //Align nya

      $grid->setLabel('iSemester', 'Semester'); //Ganti Label
      $grid->setWidth('iSemester', '100'); // width nya
      $grid->setAlign('iSemester', 'center'); //Align nya

      $grid->setLabel('iStatus', 'Status'); //Ganti Label
      $grid->setWidth('iStatus', '200'); // width nya
      $grid->setAlign('iStatus', 'left'); //Align nya

      $grid->setLabel('cTahun', 'Tahun'); //Ganti Label
      $grid->setWidth('cTahun', '100'); // width nya
      $grid->setAlign('cTahun', 'center'); //Align nya

      $grid->setLabel('cPeriode', 'Periode Penilaian'); //Ganti Label
      $grid->setWidth('cPeriode', '100'); // width nya
      $grid->setAlign('cPeriode', 'center'); //Align nya

      $grid->setLabel('msdivision.vDescription', 'Divisi'); //Ganti Label
      $grid->setAlign('msdivision.vDescription', 'left'); //Align nya
      $grid->setWidth('msdivision.vDescription', '300'); // width nya
    
      $grid->setLabel('msdepartement.vDescription', 'Department'); //Ganti Label
      $grid->setAlign('msdepartement.vDescription', 'left'); //Align nya
      $grid->setWidth('msdepartement.vDescription', '200'); // width nya

      $grid->setLabel('iProbation', 'PK Probation'); //Ganti Label
      $grid->setLabel('iSkemaId', 'Skema PK'); //Ganti Label
      $grid->setLabel('grpaspek', 'Group Aspek'); //Ganti Label


      

      $grid->setRequired('dPk','iSemester','cTahun'); //Field yg mandatori

      $grid->setJoinTable('hrd.employee', 'hrd.pk_trans.cNip = hrd.employee.cNip', 'LEFT');
      
      $grid->setJoinTable('hrd.msdepartement', 'hrd.msdepartement.iDeptID = hrd.employee.iDepartementId', 'LEFT');
        $grid->setJoinTable('hrd.msdivision', 'hrd.msdivision.iDivID = hrd.employee.iDivisionID', 'LEFT');
      $grid->setQuery('pk_trans.lDeleted',0);
     // $grid->setQuery('pk_trans.iStatus > 0',null);

    
    $grid->changeFieldType('iStatus','combobox','',array(''=>'Pilih',0=>'Need Submited',1=>'Need Confirm By Aybs',3=>'Agreement',4=>'Final'));

    $grid->changeFieldType('iSemester','combobox','',array(''=>'Pilih',1=>'1',2=>'2'));

    /*$skemaPK = $this->lib_utilitas->getSysParam('SKEMA_PK_PD3_ASC_CLINISINDO');

    $DIV_PK_PD3_ASC_CLINISINDO = $this->lib_utilitas->getSysParam('DIV_PK_PD3_ASC_CLINISINDO');
    $grid->setQuery('hrd.employee.iDivisionID in ('.$DIV_PK_PD3_ASC_CLINISINDO.')',null);
    $grid->setQuery('hrd.pk_trans.iSkemaId in ('.$skemaPK.')',null);*/

    $DIV_PK = $this->lib_utilitas->getDivId($this->sess_auth->gNIP);
    $grid->setQuery('hrd.employee.iDivisionID in ('.$DIV_PK.')',null);
    

    $manager = explode(",",$this->lib_utilitas->getSysParam('SU_PK'));

    if (!in_array($this->sess_auth->gNIP,$manager)){
      $nipUnder   = $this->lib_utilitas->getNipSubOrdinat($this->sess_auth->gNIP,$tmpNip); 
      $grid->setQuery('(hrd.pk_trans.cNip '.$nipUnder.' or hrd.pk_trans.cNip="'.$this->sess_auth->gNIP.'")',null);
      $grid->setQuery('IF(hrd.`employee`.`cUpper` = "'.$this->sess_auth->gNIP.'",hrd.`pk_trans`.`iStatus` > 0 , hrd.`pk_trans`.`iStatus` IS NOT NULL)',null);
      //$grid->setQuery('(hrd.pk_trans.cNip '.$nipUnder.' or hrd.pk_trans.cNip="'.$this->sess_auth->gNIP.'")',null);
    }


    $manager = explode(",",$this->lib_utilitas->getSysParam('SU_PK'));

    if (!in_array($this->sess_auth->gNIP,$manager)){
      $nipUnder   = $this->lib_utilitas->getNipSubOrdinat($this->sess_auth->gNIP,$tmpNip);
      
      $grid->setQuery('(hrd.pk_trans.cNip '.$nipUnder.' or hrd.pk_trans.cNip="'.$this->sess_auth->gNIP.'")',null);
      $grid->setQuery('IF(hrd.`employee`.`cUpper` = "'.$this->sess_auth->gNIP.'",hrd.`pk_trans`.`iStatus` > 0 , hrd.`pk_trans`.`iStatus` IS NOT NULL)',null);
    }


      

      $grid->setSearch('cNip','employee.vName','iSemester','cTahun','iStatus');

    $grid->setGridView('grid');
    
    switch ($action) {
      case 'json':
        $grid->getJsonData();
        break;      
      case 'create':
        $grid->render_form();
        break;
      case 'createproses':
        echo $grid->saved_form();
        break;
      case 'delete':
        echo $grid->delete_row();
        $this->deleteDetail($_GET['id']);
        break;
      case 'update':
        $grid->render_form($this->input->get('id'));
        break;
      case 'view':
        $grid->render_form($this->input->get('id'),TRUE);
        break;
      case 'updateproses':
        echo $grid->updated_form();
        break;
      case 'add_group':
        echo $this->add_group();
        break;
      case 'delGroup':
        echo $this->delGroup();
        break; 
      case 'CopyGroup':
        echo $this->CopyGroup();
        break;
      case 'get_preview_report':
        echo $this->preview_report();
        break;
       case 'searchEmployee':
          echo $this->searchEmployee();
          break;
        case 'searchSkema':
          echo $this->searchSkema();
          break;
      case 'searchcNip':
        echo $this->searchcNip();
        break;
      case 'getDetail':
        echo $this->getDetail();
        break;
      case 'cekDataPk':
        echo $this->cekDataPk();
        break;
      case 'uploadproses';
        echo $this->uploadproses();
        break;
      case 'hapus';
          $this->hapus();
          break;
       case 'getLampiran';
          $this->getListLampiran2();
          break;
      case 'SaveNilai';
        $this->SaveNilai();
        break;
      case 'SaveHasil';
        $this->SaveHasil();
        break;
      case 'getValuePk';
        $this->getValuePk();
        break;
      case 'proses_approve';
        $this->proses_approve();
        break;
       case 'showDetail';
        $this->showDetail();
        break;
      case 'supportData';
        $this->supportData();
        break;
    case 'cekJabatan';
        $this->cekJabatan();
        break;
      case 'saveSupportData';
        $this->saveSupportData();
        break;
      case 'cekSupport':
        $this->cekSupport();
        break;
      default:
        $grid->render_grid();
        break;
      }
    }

    function saveSupportData(){
      //print_r($_POST);
      $parameter   = $_POST['_parameter'];
      switch ($parameter) {
        case 'PD3_ASC_getParameter7':
          $this->savePD3_ASC_getParameter7($_POST);
          break;

        case 'PD3_ASC_getParameter8':
          $this->savePD3_ASC_getParameter8($_POST);
          break;
        
        default:
          echo 'ulala';
          break;
      }

      exit();
   
    }


    function savePD3_ASC_getParameter7($post){
      $iPkTransId = $post['_iPkTransId'];
      $iAspekId   = $post['_iAspekId'];
      $suport_data = $post['klaim_bulan'];

      $sql = "DELETE FROM  hrd.pk_trans_support_data where iPkTransId='".$iPkTransId."' AND iAspekId='".$iAspekId."'";
      $this->db_erp_pk->query($sql);

      $querydtl = "INSERT INTO hrd.pk_trans_support_data (iPkTransId,iAspekId,vValue,tCreated,cCreatedBy) VALUES 
            ('".$iPkTransId."','".$iAspekId."','".$suport_data."',CURRENT_TIMESTAMP,'".$this->sess_auth->gNIP."') ";

      $this->db_erp_pk->query($querydtl);
     
    }

    function savePD3_ASC_getParameter8($post){
      $iPkTransId = $post['_iPkTransId'];
      $iAspekId   = $post['_iAspekId'];
      $suport_data = $post['klaim_bulan'];

      $sql = "DELETE FROM  hrd.pk_trans_support_data where iPkTransId='".$iPkTransId."' AND iAspekId='".$iAspekId."'";
      $this->db_erp_pk->query($sql);

      $querydtl = "INSERT INTO hrd.pk_trans_support_data (iPkTransId,iAspekId,vValue,tCreated,cCreatedBy) VALUES 
            ('".$iPkTransId."','".$iAspekId."','".$suport_data."',CURRENT_TIMESTAMP,'".$this->sess_auth->gNIP."') ";

      $this->db_erp_pk->query($querydtl);
     
    }

    function cekSupport(){
        $iAspekId   = $_POST['iAspekId'];
        $iPkTransId = $_POST['iPkTransId'];

        $sql = 'select * from hrd.pk_trans_support_data a where a.iAspekId ="'.$iAspekId.'" and a.iPkTransId ="'.$iPkTransId.'"  ';
        //echo $sql;
        $ddata = $this->db->query($sql)->row_array();
        if (empty($ddata)) {
          $out =0;
        }else{
          /*sudah dibuat support data*/
          $out=1;
        }
        echo $out;
    }
    function supportData(){
      $iAspekId   = $_GET['iAspekId'];
      $iPkTransId = $_GET['iPkTransId'];
      $action     = $_GET['getaction'];

      $sql = "SELECT vAspekName,vFunctionLink FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
      $query = $this->db_erp_pk->query($sql);
      if ($query->num_rows() > 0) {
        $row = $query->row();
          $vAspekName = $row->vAspekName;
          $vFunctionLink = $row->vFunctionLink;
      }

      $data['iAspekId']   = $iAspekId;
      $data['iPkTransId'] = $iPkTransId;
      $data['action']     = $action;

      $html = "<b>Data Pendukung Untuk Aspek :</b> <i>".$vAspekName."</i>";

      switch ($vFunctionLink) {
        case 'PD3_ASC_getParameter7':
            $html .= $this->load->view('pd/support_data/PD3_ASC_getParameter7',$data, TRUE);
          break;
        case 'PD3_ASC_getParameter8':
            $html .= $this->load->view('pd/support_data/PD3_ASC_getParameter8',$data, TRUE);
          break;
        
        default:
          $html .= $this->load->view('pd/support_data/default',$data, TRUE);
          break;
      }
      /*if ($iAspekId=='118'){
          $html .= $this->load->view('support_data/parameter1',$data, TRUE);
      }else if ($iAspekId=='119'){
        $html .= $this->load->view('support_data/parameter2',$data, TRUE);
      }else if ($iAspekId=='120'){
        $html .= $this->load->view('support_data/parameter3',$data, TRUE);
      }else if ($iAspekId=='121'){
        $html .= $this->load->view('support_data/parameter4',$data, TRUE);
      }*/
      

      
      echo $html;

    }



    function showDetail(){
      $html = $_GET['html'];
      echo "<div id='detailPointPk'>".$html."</div>";
    }
    function preview_report(){
      $this->load->helper('download');
      $id     = $_GET['id'];
      $vName  = ucwords(strtolower($_GET['vName']));
      $path = $this->config->item('report_path');
      $path .= 'hdsystem/laporan/'; 

      

      $params = new Java("java.util.HashMap");
      $params->put('id', (int)$id);
      $params->put('SUBREPORT_DIR', $path);

      $reportAsal   = "pk_trans.jrxml";
      $reportTujuan = "PK ".$vName.".pdf";

      $nama_file = explode('.', $reportAsal);   
      $this->report->showReport($path, $reportAsal, $reportTujuan, $params,1);  
      $open_file = file_get_contents($path.$reportTujuan);
    
      force_download($nama_file[0], $open_file);
      exit();
     
     }

    function proses_approve(){
      $id       = $_POST['_id'];
      $jenis    = $_POST['_jenis'];
      $cNip     =  $this->sess_auth->gNIP;
      $cNipNya  =  $_POST['_cNipNya'];


      $return = '';
      if ($jenis==0){ //Cek Before Sumbit
        $sql = "SELECT a.iMsGroupAspekId,
        (SELECT vDescription FROM hrd.pk_msgroup_aspek WHERE id=a.iMsGroupAspekId ) AS  vDescription ,
        (SELECT COUNT(id) FROM  hrd.pk_nilai WHERE iPkTransId='".$id."' AND iMsGroupAspekId=a.iMsGroupAspekId) AS count_nilai 
        FROM hrd.pk_group_aspek AS a
        WHERE a.iSkemaId=(SELECT iSkemaId FROM hrd.pk_trans WHERE id='".$id."')";
        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows > 0) {
          foreach($query->result_array() as $row) {
            $iMsGroupAspekId  = $row['iMsGroupAspekId'];
            $vDescription     = $row['vDescription'];
            $count_nilai      = $row['count_nilai'];


            if ($count_nilai==0){
              $return = "Aspek ".ucfirst(strtolower($vDescription))." Belum Disimpan";
              echo $return;
              exit();
            }

            //cek pointnya udah ada apa belum
            //if ($cNip==$cNipNya){
              $sqla = "SELECT a.iAspekId,
              (SELECT vAspekName FROM hrd.pk_aspek WHERE id=a.iAspekId) AS vAspekName 
              FROM hrd.pk_nilai AS a WHERE a.iPkTransId='".$id."' 
              AND imsGroupAspekId='".$iMsGroupAspekId."' AND nPointKry = 0";
            /*}else{
              $sqla = "SELECT a.iAspekId,
              (SELECT vAspekName FROM hrd.pk_aspek WHERE id=a.iAspekId) AS vAspekName 
              FROM hrd.pk_nilai AS a WHERE a.iPkTransId='".$id."' 
              AND imsGroupAspekId='".$iMsGroupAspekId."' AND nPointAybs = 0";
            }*/
            

            $query = $this->db_erp_pk->query($sqla);
            if ( $query->num_rows() > 0 ) {
                $rl = $query->row();
                $vAspekName = ucfirst(strtolower($rl->vAspekName));
                $return = "Point <b style='color:red;' >".$vAspekName."</b> Pada Aspek <b style='color:blue;'>".ucfirst(strtolower($vDescription))."</b> Belum Dipilih";
                echo $return;
                exit();

            }

            
          }
        }
       
      }else if ($jenis==1){ //Submit
        if ($cNip==$cNipNya){
          $sql = "UPDATE hrd.pk_trans SET iStatus=1,dSubmit=CURRENT_TIMESTAMP,tUpdated=CURRENT_TIMESTAMP,cUpdatedBy='".$cNip."' WHERE id='".$id."' ";
          $this->db_erp_pk->query($sql);
        }else{
          $sql = "UPDATE hrd.pk_trans SET iStatus=3,dApproveAybs=CURRENT_TIMESTAMP,
          cApproveAybs='".$cNip."',
          tUpdated=CURRENT_TIMESTAMP,cUpdatedBy='".$cNip."' WHERE id='".$id."' ";
          $this->db_erp_pk->query($sql);
        }
        
      }else if ($jenis==2){ //Aggrement
        $password = $_POST['_password'];

        //cek Password bener apa tidak
        $sql = "SELECT cNip FROM hrd.employee WHERE cNip='".$cNipNya."' and 
              vPassword=MD5('".$password."')";
        $query = $this->db_erp_pk->query($sql);
        if ( $query->num_rows() > 0 ) {
           $sql = "UPDATE hrd.pk_trans SET iStatus=4,dAgrement=CURRENT_TIMESTAMP,
          tUpdated=CURRENT_TIMESTAMP,cUpdatedBy='".$cNip."' WHERE id='".$id."' ";
          $this->db_erp_pk->query($sql);
        }else{
          $return = "<b style='color:red' >Wrong Password</b>";
          echo $return;
          exit();
        }


      }
      



      echo $return;
      exit();
    }
    function SaveHasil(){
      $cNip         =  $this->sess_auth->gNIP;
      
      $iPkTransId   = $_POST['_iPkTransId'];
      $vEvaKry      = $_POST['pk_pd3_asc_vEvaKry'];
      $vRencana     = $_POST['pk_pd3_asc_vRencana'];
      $vEvaAtasan   = $_POST['pk_pd3_asc_vEvaAtasan'];
      $vSaranAtasan = $_POST['pk_pd3_asc_vSaranAtasan'];
      $vPelatihan   = $_POST['pk_pd3_asc_vPelatihan'];
      

      if (isset($_POST['pk_create_mekanik_engine_iRencana'])){
          $iRencana     = $_POST['pk_pd3_asc_iRencana'];
      }else{
          $iRencana = '';
      }

      $iDivIdTo     = $_POST['pk_pd3_asc_iDivIdTo'];
      $iPostIdTo     = $_POST['pk_pd3_asc_iPostIdTo'];
      $vPertimbangan = $_POST['pk_pd3_asc_vPertimbangan'];
      $nFinal        = $_POST['pk_pd3_asc_nFinal'];

      $sql = "UPDATE hrd.pk_trans SET nFinal='".$nFinal."',vEvaKry='".$vEvaKry."',
              vRencana='".$vRencana."',vEvaAtasan='".$vEvaAtasan."',
              vSaranAtasan='".$vSaranAtasan."',vPelatihan='".$vPelatihan."',
              iRencana='".$iRencana."',iPostIdTo='".$iPostIdTo."',
              iDivIdTo='".$iDivIdTo."',vPertimbangan='".$vPertimbangan."',
              tUpdated=CURRENT_TIMESTAMP,cUpdatedBy='".$cNip."' WHERE id='".$iPkTransId."'";

      $this->db_erp_pk->query($sql);

      Echo "Saved";
      exit();

    }

    function SaveNilai(){
      //print_r($_POST);
      //exit();
      $iPkTransId         = $_POST['pk_pd3_asc_id'];
      $iMsGroupAspekId    = $_POST['_iMsGroupAspekId'];
      $cNip               =  $this->sess_auth->gNIP;

      $iAspekId     = array();
      $ySource    = array();
      $nPointKry    = array();
      $nPointAybs   = array();
      $nBobot       = array();
      $nNilai       = array();
      $GroupAspekId = array();
      $nPointSepakat = array();
      $querydtl     = array();

      $post = $_POST;
      foreach($post as $k=>$v) {
        if (preg_match('/^'.$this->url.'_iMsGroupAspekIdNya(.*)$/', $k, $match)) {
          $GroupAspekId[] = $v;
        }

        if (preg_match('/^'.$this->url.'_nNilai(.*)$/', $k, $match)) {
          $nNilai[] = $v;
        }

        if (preg_match('/^'.$this->url.'_ySource(.*)$/', $k, $match)) {
          $ySource[] = str_replace(",", "", $v);
        }

        if (preg_match('/^'.$this->url.'_tmpPilih(.*)$/', $k, $match)) {
          $nPointKry[] = $v;
        }


        if (preg_match('/^'.$this->url.'_tmpAybs(.*)$/', $k, $match)) {
          $nPointAybs[] = $v;
        }

        if (preg_match('/^'.$this->url.'_nBobotnya(.*)$/', $k, $match)) {
          $nBobot[] = $v;
        }

        if (preg_match('/^'.$this->url.'_iAspekIdnya(.*)$/', $k, $match)) {
          $iAspekId[] = $v;
        }

        if (preg_match('/^'.$this->url.'_nPointSepakat(.*)$/', $k, $match)) {
          $nPointSepakat[] = $v;
        }


      }


      foreach($iAspekId as $key=>$value) {
        foreach($value as $k=>$v) {
          if ($GroupAspekId[0][$k]==$iMsGroupAspekId){

            $querydtl[] = "INSERT INTO hrd.pk_nilai 
            (iPkTransId,iAspekId,ySource,nPointKry,nPointAybs,
            nPointSepakat,nBobot,nNilai,cCreatedBy,tCreated,iMsGroupAspekId) VALUES 
            ('".$iPkTransId."','".$v."','".$ySource[0][$k]."','".$nPointKry[0][$k]."',
            '".$nPointAybs[0][$k]."','".$nPointSepakat[0][$k]."','".$nBobot[0][$k]."',
            '".$nNilai[0][$k]."','".$cNip."',CURRENT_TIMESTAMP,'".$iMsGroupAspekId."') ";
          }
        }
      }


      //hapus dulu yg lama biar gampang
      $sql = "DELETE FROM hrd.pk_nilai WHERE  iMsGroupAspekId='".$iMsGroupAspekId."' and iPkTransId='".$iPkTransId."'";
      $this->db_erp_pk->query($sql);

      foreach ($querydtl as $q) {
        try {
          $this->db_erp_pk->query($q);
        } catch (Exception $e) {
          die('Have Some Error');
        }
      }

      //save ke PK_Result;
      $sql = "SELECT a.iMsGroupAspekId,b.cNip,b.cTahun,b.iSemester,b.iPostId,b.iSkemaId,
            SUM(a.nNilai) AS nResult,c.nBobot,(SUM(a.nNilai) * c.nBobot)/100 AS nNilai 
            FROM hrd.pk_nilai AS a
            INNER JOIN hrd.pk_trans AS b ON b.id=a.iPkTransId
            INNER JOIN hrd.pk_group_aspek AS c ON c.iSkemaId=b.iSkemaId AND c.iMsGroupAspekId=a.iMsGroupAspekId 
            WHERE a.iPkTransId='".$iPkTransId."' 
            AND a.iMsGroupAspekId='".$iMsGroupAspekId."' AND a.lDeleted=0 AND c.lDeleted=0";
      $query = $this->db_erp_pk->query($sql);
      if ( $query->num_rows() > 0 ) {
          $row = $query->row();
          $cNipNya = $row->cNip;
          $cTahun = $row->cTahun;
          $iSemester = $row->iSemester;
          $iPostId = $row->iPostId;
          $iSkemaId = $row->iSkemaId;
          $nResult = $row->nResult;
          $nBobot = $row->nBobot;
          $nNilai = $row->nNilai;
      }



      //cek dulu udah ada apa belum
      $sql = "SELECT id FROM hrd.pk_pkresult WHERE iPkTransId='".$iPkTransId."' AND iMsGroupAspek='".$iMsGroupAspekId."'";
      $query = $this->db_erp_pk->query($sql);
      if ( $query->num_rows() > 0 ) {
          $sqlresult = "UPDATE hrd.pk_pkresult SET cNip='".$cNipNya."',cTahun='".$cTahun."',
                      nSemester='".$iSemester."',iPostId='".$iPostId."',
                      iSkemaId='".$iSkemaId."',
                      nResult='".$nResult."',nBobot='".$nBobot."',nNilai='".$nNilai."',
                      tUpdated=CURRENT_TIMESTAMP,cUpdatedBy='".$cNip."'
                      WHERE  iPkTransId='".$iPkTransId."' AND iMsGroupAspek='".$iMsGroupAspekId."'"; 
      }else{
        $sqlresult = "INSERT INTO hrd.pk_pkresult (iPkTransId,cNip,cTahun,nSemester,iPostId,iSkemaId,iMsGroupAspek,nResult,nBobot,nNilai,tCreated,cCreatedBy) VALUES 
        ('".$iPkTransId."','".$cNipNya."','".$cTahun."','".$iSemester."', '".$iPostId."',
         '".$iSkemaId."', '".$iMsGroupAspekId."', '".$nResult."', '".$nBobot."',
          '".$nNilai."', CURRENT_TIMESTAMP,'".$cNip."') ";
      }

      $this->db_erp_pk->query($sqlresult);

      //Update nFinal Di pk_trans
      $sql = "UPDATE hrd.pk_trans SET nFinal=(SELECT SUM(nNilai) FROM hrd.pk_pkresult WHERE iPkTransId='".$iPkTransId."') WHERE id='".$iPkTransId."'";
      $this->db_erp_pk->query($sql);

      Echo "Saved";
      exit();
    }
    function uploadproses(){
      $id = $this->input->get('id');
      $cNip = $this->sess_auth->gNIP;

      $files = $_FILES;
      $realname = $files["pk_pd3_asc_lampiran"]["name"];
      $newName= "PK_".$id."_".$realname;
      $newName =  str_replace("/", "_", $newName);
      $upload_dir = "files/hdsystem/".$newName;

      move_uploaded_file($files["pk_pd3_asc_lampiran"]["tmp_name"], $upload_dir);
      
      
      //update ke employee
      $sql = "INSERT INTO hrd.pk_trans_attch (iPkTransId,vPath,vName,tCreated,cCreatedBy) VALUES
          ('".$id."','".$newName."','".$realname."',CURRENT_TIMESTAMP,'".$cNip."')";
      $this->db_erp_pk->query($sql);
      
      exit();
    }


    function hapus(){
      $id = $_POST['_id'];
      

      $sql = "SELECT vPath
            FROM hrd.pk_trans_attch 
            WHERE  id='".$id."'";

      $query = $this->db_erp_pk->query($sql);
      if ( $query->num_rows() > 0 ) {
          $row = $query->row();
          $vPath = $row->vPath;
          
          
      }

      $file = "files/hdsystem/".$vPath;

      unlink($file);
      $sql = "DELETE FROM hrd.pk_trans_attch WHERE id='".$id."'";
      $this->db_erp_pk->query($sql);
      echo "-";
    }

    function deleteDetail($id){
      $sql = "DELETE FROM hrd.pk_pkresult WHERE iPkTransId='".$id."'";
      $this->db_erp_pk->query($sql);
    }

    function cekDataPk(){
      $cNip = $_POST['cNip'];
      $iSemester = $_POST['iSemester'];
      $cTahun = $_POST['cTahun'];

      $sql = "SELECT id FROM hrd.pk_trans WHERE 
            cNip='".$cNip."' AND iSemester='".$iSemester."' 
            AND cTahun='".$cTahun."' AND lDeleted=0";

      $query = $this->db_erp_pk->query($sql);
      if ($query->num_rows > 0) {
        $row = $query->row();
        $id = $row->id;
        $x = "ADA|".$id;
      }else{
        $x = "TIDAK|";
      }
      echo $x;
    }

    function cekJabatan(){
        $iPostId = $_POST['_iPostId'];
        $x_jabpk = explode(",", $this->lib_utilitas->getSysParam('JABATAN_PK_PD3_ASC_CLINISINDO'));

        if(in_array($iPostId, $x_jabpk)){
            $return = "ADA";
        }else{
            $return = "TIDAK";
        }

        echo $return;
    }


    function searchSkema() {
      $skemaPK = $this->lib_utilitas->getSkemaPK($this->sess_auth->gNIP);
      $data = array();
      $sql = "SELECT id,vName 
      FROM hrd.pk_skema WHERE id in (".$skemaPK.")  AND lDeleted=0 and iActive=1 ";
                  
      /*echo '<pre> hilih'.$sql;
      exit;*/
      $query = $this->db_erp_pk->query($sql);
      if ($query->num_rows > 0) {
        foreach($query->result_array() as $line) {
    
          $row_array['value'] = trim($line['vName']);
          $row_array['id']    = $line['id'];
    
          array_push($data, $row_array);
        }
      }
    
      echo json_encode($data);
      exit;
    }

    function searchSkemax() {
      $skemaPK = $this->lib_utilitas->getSysParam('SKEMA_PK_PD3_ASC_CLINISINDO');

      $data = array();
      $sql = "SELECT id,vName 
      FROM hrd.pk_skema WHERE id in (".$skemaPK.")  AND lDeleted=0 and iActive=1 ";
                  
      //echo $sql;
      $query = $this->db_erp_pk->query($sql);
      if ($query->num_rows > 0) {
        foreach($query->result_array() as $line) {
    
          $row_array['value'] = trim($line['vName']);
          $row_array['id']    = $line['id'];
    
          array_push($data, $row_array);
        }
      }
    
      echo json_encode($data);
      exit;
    }


    function proses_reject(){
      
      $cNip   = $this->sess_auth->gNIP;
      $id     = $_POST['_id'];
      $alasan = $_POST['_alasan'];


      $sql    = "SELECT cNip FROM hrd.pk_pd3_asc 
      WHERE iSkemaId='".$id."' and cNip='".$cNip."' and iUlang=0";
      $query = $this->db_erp_pk->query($sql);
      if ($query->num_rows > 0) {
        echo "2";
        exit();

      }

      $sql = "INSERT INTO hrd.pk_pd3_asc (iSkemaId,cNip,iStatus,vReason,dDate,iUlang,lDeleted,tCreated,cCreatedBy) VALUES
        ('".$id."','".$cNip."',2,'".$alasan."',CURRENT_TIMESTAMP,0,0,CURRENT_TIMESTAMP,'".$cNip."') ";
      $this->db_erp_pk->query($sql);

      $sql = "UPDATE hrd.pk_skema SET  iStatus='6' WHERE id='".$id."' ";
      $this->db_erp_pk->query($sql);

      $this->sendEmailReject($id,$alasan);
      echo "1";
      exit();

    }
    



    function listBox_ACTION($rows, $actions) {
        $cNip   = $this->sess_auth->gNIP;
        $cNipNya = $rows->cNip;
        
        $nipLogin = $this->sess_auth->gNIP;

        if ( $rows->iStatus>3){
          unset($actions['delete']);
          unset($actions['edit']);
        }else if ($rows->iStatus> 0){
          unset($actions['delete']);
            if ($nipLogin != $cNipNya){
                $listaybs =  $this->lib_utilitas->getAybs($cNipNya,$tmpNip=array());
                if(!in_array($nipLogin,$listaybs)){
                    unset($actions['edit']);
                }

            }
        }else{
            if ($nipLogin != $cNipNya){
                unset($actions['delete']);
                $listaybs =  $this->lib_utilitas->getAybs($cNipNya,$tmpNip=array());
                if(!in_array($nipLogin,$listaybs)){
                    unset($actions['edit']);
                }

            }
        }


        //unset($actions['delete']);
        //unset($actions['edit']);
       
        return $actions;
    }

    
    public function listbox_pk_pd3_asc_dPk($value, $id,$field,$rowData) {
      
      return date('d-m-Y',strtotime($value));

    }

  
    public function listbox_pk_pd3_asc_iPostId($value, $id,$field,$rowData) {
      $vDescription = $value;
      $sql = "SELECT vDescription FROM hrd.position WHERE iPostId='".$value."'";
      $query = $this->db_erp_pk->query($sql);
      if ($query->num_rows() > 0) {
          $row = $query->row();
          $vDescription = $row->vDescription;
      }
      return $vDescription;

    }



    public function insertbox_pk_pd3_asc_iPostId($field, $id) {

      $cNip   =  $this->sess_auth->gNIP;
      $sql    = "SELECT  a.iPostId,(SELECT vDescription  
                from hrd.position where iPostId=a.iPostId) as vDescription 
                FROM hrd.employee as a WHERE a.cNip='".$cNip."' ";
      $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $iPostId = $row->iPostId;
            $vDescription = $row->vDescription;
        } else {
            $vDescription = ' - ';
            $iPostId = '';
        }


      $o = '<input name="'.$id.'" id="'.$id.'" type="hidden" class="required" readonly size="10" value="'.$iPostId.'" />
          <b><span name="nama_'.$id.'" id="nama_'.$id.'">'.$vDescription.'</span></b>
        ';


        return $o;
    }


    public function updatebox_pk_pd3_asc_iPostId($field, $id,$value,$data) {
        $url2 = base_url().'processor/hdsystem/master/jabatan/popup/';
        $sql = "SELECT vDescription as vDescription 
                from hrd.position where ldeleted = 0 and iPostId = '{$value}'";
        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $vDescription = $row->vDescription;
        } else {
            $vDescription = ' - ';
        }

       
        $o = '<input name="'.$id.'" id="'.$id.'" type="hidden" 
              class="required" readonly size="10" value="'.$value.'" />
            </b>'.$vDescription.'</b>';
       
        return $o;
    }

    

    

    public function insertbox_pk_pd3_asc_cNip($field, $id) {
      $cNip        =  $this->sess_auth->gNIP;
      $vDescription = $cNip." - ".$this->lib_utilitas->getvName($cNip);

      $url = $this->url;
      $url6 = base_url().'processor/pk/pk/pd3/asc?action=searchcNip';
      $url2 = base_url().'processor/pk/pk/pd3/asc?action=searchSkema';
      $url3 = base_url().'processor/pk/pk/pd3/asc?action=cekJabatan';

      $sql = "SELECT a.cNip,a.vName,a.dRealIn,a.iPostId,
        (SELECT vDescription FROM hrd.msdivision WHERE iDivID=a.iDivisionID) AS divisi,
        (SELECT vDescription FROM hrd.msdepartement WHERE iDeptID=a.iDepartementId) AS departement,
        (SELECT vDescription FROM hrd.bagian WHERE ibagid=a.ibagid) AS bagian,
        (SELECT vAreaname FROM hrd.area WHERE iAreaID=a.iArea) AS vAreaname,
        (SELECT vDescription FROM hrd.position WHERE iPostId=a.iPostId) AS jabatan
        FROM hrd.employee AS a WHERE a.cNip='".$cNip."'";

        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $iPostId = $row->iPostId;
            $jabatan = $row->jabatan;
            $now = date('Y-m-d');
            $d1 = new DateTime($row->dRealIn);
            $d2 = new DateTime($now);
            $interval = $d2->diff($d1);
            $masakerja = $interval->format('%y Tahun, %m Bulan');
        }


      $o = "<script type='text/javascript'>
              $(document).ready(function() {

                var akses = cekJabatan('pk_pd3_asc_iSkemaId', '".$iPostId."');
                if (akses=='TIDAK'){
                    custom_alert('Jabatan anda tidak terdaftar untuk input Penilaian Kinerja pada module ini');
                    //$('#form_pk_pd3_asc').hide();
                    return false;
                }


                loadSkema('pk_pd3_asc_iSkemaId', '".$iPostId."');

                $('#".$url."_vName').live('keyup', function() {
                var config = {
                  source: '".$url6."',          
                  select: function(event, ui){
                    $('#".$url."_cNip').val(ui.item.id);
                    $('#".$url."_vName').val(ui.item.value);

                    $('#".$url."_nmiDivID').html(ui.item.divisi);
                    $('#".$url."_nmiDeptID').html(ui.item.departement);
                    $('#".$url."_nmibagid').html(ui.item.bagian);
                    $('#".$url."_nmArea').html(ui.item.vAreaname);
                    $('#".$url."_nmJabatan').html(ui.item.jabatan);
                    $('#".$url."_dRealIn').html(ui.item.dRealIn);
                    $('#".$url."_masaKerja').html(ui.item.masakerja);

                    $('#".$url."_iPostId').val(ui.item.iPostId);
                    $('#nama_".$url."_iPostId').html(ui.item.jabatan);
                    

                    loadSkema('pk_pd3_asc_iSkemaId', ui.item.iPostId);

                    return false;             
                  },
                  minLength: 2,
                  autoFocus: true,
                  };

                  $('#".$url."_vName').autocomplete(config);      
                

                });
                  
              });

           function loadSkema(control, iPostId) {
                  $.get('".$url2."', 
                  {_control:control, _iPostId:iPostId},  function(data) {
                          if (data.error == undefined) {
                                  $('#'+control).empty();
                                  $('#'+control).append('<option value=\'0\'>[Pilih]</option>');
                                  for (var x=0;x<data.length;x++) {           
                                          $('#'+control).append($('<option></option>').val(data[x].id).text(data[x].value));  
                                  }
                          } else {
                                  //alert('Data Error');
                                  return false;
                          }

                  },'json');
          } 

            function cekJabatan(control, iPostId){
                return $.ajax({
                    type: 'POST', 
                    url: '".$url3."',
                    data: '_control='+control+'&_iPostId='+iPostId,
                    async:false
                }).responseText
            }                
        </script>";
            
      $o   .= "<div style='
              padding: 3px;
              width: 500px;
              border: 1px solid rgba(51, 23, 93, 0.2);
              background-color: #FFF;'>
              
          <table border='0' style='width: 100%;'>
            <tbody>";
              
      $o  .='<tr>
                <td width="20%"">Employee Name</td>
                <td>:</td>
                <td width="80%"">';

                if ($this->input->get('action')=='view'){
                  $o .= $vDescription;
                }else{
                  $o .= '<input  name="'.$url.'_cNip" id="'.$url.'_cNip" type="hidden" class="required" readonly size="7" value="'.$cNip.'"/>

                <input readonly  name="'.$url.'_vName" id="'.$url.'_vName" type="hidden" class="required"  size="30" value="'.$vDescription.'" />
                '.$vDescription;


                }

                

                

                
                
                $o .= '<span name="'.$url.'_vName" id="'.$url.'_vName"></span>
                </td>
              </tr>';
      $o  .=" 
              <tr>
                <td width='20%'>Tanggal Masuk</td>
                <td>:</td>
                <td width='75%'>
                  
                  
                  <span id='".$url."_dRealIn' name='".$url."_dRealIn'>".date('d-m-Y',strtotime($row->dRealIn))."</span>
                  
                </td>
              </tr>

              <tr>
                <td width='20%'>Masa Kerja</td>
                <td>:</td>
                <td width='75%'>
                  
                  
                  <span id='".$url."_masaKerja' name='".$url."_masaKerja'>".$masakerja."</span>
                  
                </td>
              </tr>

              <tr>
                <td width='20%'>Division</td>
                <td>:</td>
                <td width='75%'>
                  
                  
                  <span id='".$url."_nmiDivID' name='".$url."_nmiDivID'>".$row->divisi."</span>
                  
                </td>
              </tr>
              
              <tr>
                <td width='20%'>Department</td>
                <td>:</td>
                <td width='75%'>
                  
                  
                  <span id='".$url."_nmiDeptID' name='".$url."_nmiDeptID'>".$row->departement."</span>
                </td>
              </tr>
              
              <tr>
                <td width='20%'>Part</td>
                <td>:</td>
                <td width='75%'>
                  
                  
                  <span id='".$url."_nmibagid' name='".$url."_nmibagid'>".$row->bagian."</span>
                </td>
              </tr>

              <tr>
                <td width='20%'>Area</td>
                <td>:</td>
                <td width='75%'>
                  
                  
                  <span id='".$url."_nmArea' name='".$url."_nmArea'>".$row->vAreaname."</span>
                </td>
              </tr>

              

              
              
            </tbody>  
          </table>
          
          
        </div>"; 
    return $o;
    }

    public function updatebox_pk_pd3_asc_cNip($field, $id,$value,$data) {
      $cNip         =  $value;
      $vDescription = $cNip." - ".$this->lib_utilitas->getvName($cNip);
      $url = $this->url;
      $url6 = base_url().'processor/pk/pk/pd3/asc?action=searchcNip';
      $url2 = base_url().'processor/pk/pk/pd3/asc?action=searchSkema';

      $sql = "SELECT a.cNip,a.vName,a.dRealIn,a.iPostId,
        (SELECT vDescription FROM hrd.msdivision WHERE iDivID=a.iDivisionID) AS divisi,
        (SELECT vDescription FROM hrd.msdepartement WHERE iDeptID=a.iDepartementId) AS departement,
        (SELECT vDescription FROM hrd.bagian WHERE ibagid=a.ibagid) AS bagian,
        (SELECT vAreaname FROM hrd.area WHERE iAreaID=a.iArea) AS vAreaname,
        (SELECT vDescription FROM hrd.position WHERE iPostId=a.iPostId) AS jabatan
        FROM hrd.employee AS a WHERE a.cNip='".$cNip."'";

        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();

            $now = date('Y-m-d');
            $d1 = new DateTime($row->dRealIn);
            $d2 = new DateTime($now);
            $interval = $d2->diff($d1);
            $masakerja = $interval->format('%y Tahun, %m Bulan');
        }


      $o = "<script type='text/javascript'>
              $(document).ready(function() {

                $('#".$url."_vName').live('keyup', function() {
                var config = {
                  source: '".$url6."',          
                  select: function(event, ui){
                    $('#".$url."_cNip').val(ui.item.id);
                    $('#".$url."_vName').val(ui.item.value);

                    $('#".$url."_nmiDivID').html(ui.item.divisi);
                    $('#".$url."_nmiDeptID').html(ui.item.departement);
                    $('#".$url."_nmibagid').html(ui.item.bagian);
                    $('#".$url."_nmArea').html(ui.item.vAreaname);
                    //$('#".$url."_jabatan').html(ui.item.jabatan);
                    $('#".$url."_dRealIn').html(ui.item.dRealIn);
                    $('#".$url."_masaKerja').html(ui.item.masakerja);

                    $('#".$url."_iPostId').val(ui.item.iPostId);
                    $('#nama_".$url."_iPostId').html(ui.item.jabatan);
                    

                    loadSkema('pk_pd3_asc_iSkemaId', ui.item.iPostId);

                    return false;             
                  },
                  minLength: 2,
                  autoFocus: true,
                  };

                  $('#".$url."_vName').autocomplete(config);      
                

                });
                  
              });

           function loadSkema(control, iPostId) {
                  $.get('".$url2."', 
                  {_control:control, _iPostId:iPostId},  function(data) {
                          if (data.error == undefined) {
                                  $('#'+control).empty();
                                  $('#'+control).append('<option value=\'0\'>[Pilih]</option>');
                                  for (var x=0;x<data.length;x++) {           
                                          $('#'+control).append($('<option></option>').val(data[x].id).text(data[x].value));  
                                  }
                          } else {
                                  //alert('Data Error');
                                  return false;
                          }

                  },'json');
          }                 
        </script>";
            
      $o   .= "<div style='
              padding: 3px;
              width: 500px;
              border: 1px solid rgba(51, 23, 93, 0.2);
              background-color: #FFF;'>
              
          <table border='0' style='width: 100%;'>
            <tbody>";
              
      $o  .='<tr>
                <td width="20%"">Employee Name</td>
                <td>:</td>
                <td width="80%"">';

                $o .= '<input name="'.$url.'_cNip" id="'.$url.'_cNip" type="hidden" class="required" readonly size="7" value="'.$cNip.'"/>';

                if ($this->input->get('action')=='view'){
                  $o .= $vDescription;
                }else{
                  $o .= '
                <input name="'.$url.'_vName" id="'.$url.'_vName" type="hidden" class="required"  size="30" value="'.$vDescription.'" /><b>'.$vDescription.'</b>';
                }

                
                $o .= '<span name="'.$url.'_vName" id="'.$url.'_vName"></span>
                </td>
              </tr>';
      $o  .=" 
              <tr>
                <td width='20%'>Tanggal Masuk</td>
                <td>:</td>
                <td width='75%'>
                  
                  
                  <span id='".$url."_dRealIn' name='".$url."_dRealIn'>".date('d-m-Y',strtotime($row->dRealIn))."</span>
                  
                </td>
              </tr>

              <tr>
                <td width='20%'>Masa Kerja</td>
                <td>:</td>
                <td width='75%'>
                  
                  
                  <span id='".$url."_masaKerja' name='".$url."_masaKerja'>".$masakerja."</span>
                  
                </td>
              </tr>

              <tr>
                <td width='20%'>Division</td>
                <td>:</td>
                <td width='75%'>
                  
                  
                  <span id='".$url."_nmiDivID' name='".$url."_nmiDivID'>".$row->divisi."</span>
                  
                </td>
              </tr>
              
              <tr>
                <td width='20%'>Department</td>
                <td>:</td>
                <td width='75%'>
                  
                  
                  <span id='".$url."_nmiDeptID' name='".$url."_nmiDeptID'>".$row->departement."</span>
                </td>
              </tr>
              
              <tr>
                <td width='20%'>Part</td>
                <td>:</td>
                <td width='75%'>
                  
                  
                  <span id='".$url."_nmibagid' name='".$url."_nmibagid'>".$row->bagian."</span>
                </td>
              </tr>

              <tr>
                <td width='20%'>Area</td>
                <td>:</td>
                <td width='75%'>
                  
                  
                  <span id='".$url."_nmArea' name='".$url."_nmArea'>".$row->vAreaname."</span>
                </td>
              </tr>

              

              
              
            </tbody>  
          </table>
          
          
        </div>"; 
    return $o;

    }

    public function insertbox_pk_pd3_asc_cTahun($field, $id) {
      $year = date('Y');
      $y1 = $year - 5;
      $y2 = $year + 5;

      $o = "<select onchange='cekDataPk()' name='".$field."' id='".$id."'>";
      for ($i=$y1; $i < $y2; $i++) {
        if ($year==$i){
          $sel = 'selected';
        }else{
          $sel = '';
        } 
        $o .= "<option {$sel} value='".$i."' >".$i."</option>";
      }
      
      $o .= "</select>";
      return $o;
    }

    public function updatebox_pk_pd3_asc_cTahun($field, $id,$value,$data) {
      $year = $value;
     
      $o = "<input type='hidden' name='".$field."' id='".$id."' value='".$value."' />";
      $o .= $year;
      
      
    return $o;

    }

    public function insertbox_pk_pd3_asc_cPeriode($field, $id) {
       $o = '<input type="text" readonly size="8" id="'.$this->url.'_dPeriode1"
        name="'.$this->url.'_dPeriode1" value="" /> s/d ';
      $o .= '<input type="text" readonly size="8" id="'.$this->url.'_dPeriode2" 
      name="'.$this->url.'_dPeriode2" value="" />';
     
      return $o;
    }

    public function updatebox_pk_pd3_asc_cPeriode($field, $id,$value,$data) {
      $dPeriode1 = $data['dPeriode1'];
      $dPeriode2 = $data['dPeriode2'];

      if ($dPeriode1=='' || $dPeriode1=='0000-00-00'){
        $dPeriode1 = '';
      }else{
        $dPeriode1 = date('d-m-Y',strtotime($dPeriode1));
      }

      if ($dPeriode2=='' || $dPeriode2=='0000-00-00'){
        $dPeriode2 = '';
      }else{
        $dPeriode2 = date('d-m-Y',strtotime($dPeriode2));
      }

      if ($this->input->get('action')!='view'){
        $o = '<input  type="text" size="8" id="'.$this->url.'_dPeriode1" value="'.$dPeriode1.'" name="'.$this->url.'_dPeriode1" /> s/d ';
        $o .= '<input type="text"  size="8" id="'.$this->url.'_dPeriode2" value="'.$dPeriode2.'" name="'.$this->url.'_dPeriode2" />';


        $o .= "<script>

              $(document).ready(function(){
                cekDataPk();
              });

              function cekDataPk(){
                var iSemester = $('#".$this->url."_iSemester').val();
                var cTahun    = $('#".$this->url."_cTahun').val();
                var cNip    = $('#".$this->url."_cNip').val();

                if (iSemester==1){
                  minimal = new Date(cTahun+'-01-01');
                  maximal = new Date(cTahun+'-06-30');
                }else if (iSemester==2){
                  minimal = new Date(cTahun+'-07-01');
                  maximal = new Date(cTahun+'-12-31');
                }else{
                  minimal = new Date();
                  maximal = new Date();
                }


                $('#".$this->url."_dPeriode1').datepicker({
                    showOn: 'button',
                    buttonImage: 'http://10.1.49.8/erp/assets/images/calendar.gif',
                    buttonImageOnly: true,
                    dateFormat: 'dd-mm-yy',
                    changeMonth: true,
                    changeYear: true,
                    minDate: minimal,
                    maxDate: maximal
                });

                $('#".$this->url."_dPeriode2').datepicker({
                    showOn: 'button',
                    buttonImage: 'http://10.1.49.8/erp/assets/images/calendar.gif',
                    buttonImageOnly: true,
                    dateFormat: 'dd-mm-yy',
                    changeMonth: true,
                    changeYear: true,
                    minDate: minimal,
                    maxDate: maximal
                });

              }

             
            </script>";

      }else{
        $o = $dPeriode1." s/d ".$dPeriode2;

        $o .= '<input type="hidden"  size="8" id="'.$this->url.'_dPeriode1" value="'.$dPeriode1.'" name="'.$this->url.'_dPeriode1" />';
        $o .= '<input type="hidden"  size="8" id="'.$this->url.'_dPeriode2" value="'.$dPeriode2.'" name="'.$this->url.'_dPeriode2" />';
      }
     
      
    return $o;

    }




    public function insertbox_pk_pd3_asc_iSemester($field, $id) {
      
      $url2 = base_url().'processor/pk/pk/pd3/asc?action=cekDataPk';
      $url  = base_url()."processor/pk/pk/pd3/asc?company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id');

      $o = "<select onchange='cekDataPk()' name='".$field."' id='".$id."'>";
      $o .= "<option value='' ></option>";
      $o .= "<option value='1' >1</option>";
      $o .= "<option value='2' >2</option>";
     
      $o .= "</select>";

      $o .= "<script>
              function cekDataPk(){
                var iSemester = $('#".$id."').val();
                var cTahun    = $('#".$this->url."_cTahun').val();
                var cNip    = $('#".$this->url."_cNip').val();

                var x = cekAdaDataPk(iSemester,cTahun,cNip);
                var x_split = x.split('|');

                if (x_split['0']=='ADA'){
                  custom_alert('Data PK Untuk Semester '+iSemester+' Tahun '+cTahun+' Sudah ada');

                  $.get('".$url."&action=view&id='+x_split['1'], function(data) {
                     $('div#form_".$this->url."').html(data);
                                                         
                  });
                }

                if (iSemester==1){
                  $('#".$this->url."_dPeriode1').val('01-01-'+cTahun);
                  $('#".$this->url."_dPeriode2').val('30-06-'+cTahun);
                  minimal = new Date(cTahun+'-01-01');
                  maximal = new Date(cTahun+'-06-30');
                }else if (iSemester==2){
                  $('#".$this->url."_dPeriode1').val('01-07-'+cTahun);
                  $('#".$this->url."_dPeriode2').val('31-12-'+cTahun);
                  minimal = new Date(cTahun+'-07-01');
                  maximal = new Date(cTahun+'-12-31');
                }else{
                  $('#".$this->url."_dPeriode1').val('');
                  $('#".$this->url."_dPeriode2').val('');
                  minimal = new Date();
                  maximal = new Date();
                }


                $('#".$this->url."_dPeriode1').datepicker({
                    showOn: 'button',
                    buttonImage: 'http://10.1.49.8/erp/assets/images/calendar.gif',
                    buttonImageOnly: true,
                    dateFormat: 'dd-mm-yy',
                    changeMonth: true,
                    changeYear: true,
                    minDate: minimal,
                    maxDate: maximal
                });

                $('#".$this->url."_dPeriode2').datepicker({
                    showOn: 'button',
                    buttonImage: 'http://10.1.49.8/erp/assets/images/calendar.gif',
                    buttonImageOnly: true,
                    dateFormat: 'dd-mm-yy',
                    changeMonth: true,
                    changeYear: true,
                    minDate: minimal,
                    maxDate: maximal
                });

              }

              function cekAdaDataPk(iSemester,cTahun,cNip){
                return $.ajax({
                    type: 'POST', 
                    url: '".$url2."',
                    data: 'iSemester='+iSemester+'&cTahun='+cTahun+'&cNip='+cNip,
                    async:false
                }).responseText
              }
            </script>";
      return $o;
    }

    public function updatebox_pk_pd3_asc_iSemester($field, $id,$value,$data) {
      $sms = array(''=>'',1=>1,2=>2);

      $o = "<input type='hidden' name='".$field."' id='".$id."' value='".$value."' />";
      $o .= $value;
     
      
      return $o;

    }


    public function insertbox_pk_pd3_asc_dPk($field, $id) {
      $now = date('d-m-Y');

      $o = "<input type='hidden' readonly value='".$now."' id='".$id."'
           name='".$id."' size='8' />";

      $o .= $now;
      return $o;
    }

    public function updatebox_pk_pd3_asc_dPk($field, $id,$value,$data) {
      $now = date('d-m-Y',strtotime($value));
      
        $o = "<input type='hidden' readonly value='".$now."' id='".$id."' 
            name='".$id."' size='8' />";
    
        $o .= $now;
      
      return $o;

    }


    public function insertbox_pk_pd3_asc_iProbation($field, $id) {
      //1=PK Probation, tahun dan semester bisa dikosongkan.

      $iProbation = array(0=>'No',1=>'Yes');
      $o = "<select onchange='".$this->url."_changeProbation()' id='".$id."' name='".$id."' >";
      foreach ($iProbation as $key => $val) {
        $o .= "<option value='".$key."' >".$val."</option>";
      }
      $o .= "</select>";

      $o .= "<script>
            function ".$this->url."_changeProbation(){
              var iProbation = $('#".$id."').val();
              var cTahun    = $('#".$this->url."_cTahun').val();

              if (iProbation==0){
                $('#".$this->url."_iSemester').empty();

                 $('#".$this->url."_iSemester').append('<option value=\'\'></option>');
                 $('#".$this->url."_iSemester').append('<option value=\'1\'>1</option>');
                 $('#".$this->url."_iSemester').append('<option value=\'2\'>2</option>');
              }else{
                  $('#".$this->url."_iSemester').empty();
                 $('#".$this->url."_dPeriode1').datepicker({
                      showOn: 'button',
                      buttonImage: 'http://10.1.49.8/erp/assets/images/calendar.gif',
                      buttonImageOnly: true,
                      dateFormat: 'dd-mm-yy',
                      changeMonth: true,
                      changeYear: true
                     
                  });

                  $('#".$this->url."_dPeriode2').datepicker({
                      showOn: 'button',
                      buttonImage: 'http://10.1.49.8/erp/assets/images/calendar.gif',
                      buttonImageOnly: true,
                      dateFormat: 'dd-mm-yy',
                      changeMonth: true,
                      changeYear: true,
                  });
              }


              
              


            }

      </script>";

      return $o;
    }

    public function updatebox_pk_pd3_asc_iProbation($field, $id,$value,$data) {
      //1=PK Probation, tahun dan semester bisa dikosongkan.

      $iProbation = array(0=>'No',1=>'Yes');
      $o = "<input type='hidden' name='".$field."' id='".$id."' value='".$value."' />";
      $o .= $iProbation[$value];

      return $o;
      

    }


    public function insertbox_pk_pd3_asc_lampiran($field, $id) {
      
      $o = "<b>--please save record first--</b>";

      return $o;
    }

    public function updatebox_pk_pd3_asc_lampiran($field, $id,$value,$data) {
      $action = $this->input->get('action');
      $idnya = $data['id'];
      $url = base_url().'processor/pk/pk/pd3/asc?action=uploadproses&id='.$idnya;
      $urlhapus = base_url().'processor/pk/pk/pd3/asc?action=hapus';
      $urlgetLampiran = base_url().'processor/pk/pk/pd3/asc?action=getLampiran';
      $o = '';  
      $o .= '<style>
            #'.$this->url.'_progressBar {
          background-color: #3E6FAD;
          width: 0px;
          height: 30px;
          margin-top: 10px;
          margin-bottom: 10px;
          -moz-border-radius: 5px;
          -webkit-border-radius: 5px;
          -o-border-radius: 5px;
          border-radius: 5px;
          -moz-transition: .25s ease-out;
          -webkit-transition: .25s ease-out;
          -o-transition: .25s ease-out;
          transition: .25s ease-out;
          color: red;
        }
            </style>';

        if ($this->input->get('action')!='view'){
          $o .= " <input type='file' class='multifile' id='".$id."' name='".$id."' /> <br />";
        }
       

        $o .= '<div style="padding-left: 15px;" id="'.$this->url.'_listLampiran" >
            '.$this->getListLampiran($idnya).'
          </div>';

        if ($this->input->get('action')!='view'){
          $o .='<div id="'.$this->url.'_filename"></div>
      <div id="'.$this->url.'_progress"></div>
      <div id="'.$this->url.'_progressBar"></div>';
        }
       
       
       

        
       
       $o .= "<script>
          $(document).ready(function() {
            
            $('input[type=file]').change(function(){
              
              var url ='".$url."';
              $(this).simpleUpload(url, {
                //allowedExts: ['jpg', 'jpeg', 'jpe', 'jif', 'jfif', 'jfi', 'png', 'gif'],
                //allowedTypes: ['image/pjpeg', 'image/jpeg', 'image/png', 'image/x-png', 'image/gif', 'image/x-gif'],
                
                maxFileSize: 150000000, //150MB in bytes
                
   
                start: function(file){
                  //upload started
                  $('#".$this->url."_filename').html(file.name);
                  $('#".$this->url."_progress').html('');
                  $('#".$this->url."_progressBar').width(0);
                },

                progress: function(progress){
                  //received progress
                  $('#".$this->url."_progress').html('Progress: ' + Math.round(progress) + '%');
                  $('#".$this->url."_progressBar').width(progress + '%');
                },

                success: function(data){
                  //upload successful
                  //$('#".$this->url."_progress').html('Success!<br>Data: ' + JSON.stringify(data));
                  var id ='".$idnya."';
                  
                  $('#".$this->url."_progress').html('Success!');
                  $('#".$this->url."_progress').html('Success!');
                  $('#".$this->url."_filename').html('');
                  $('#".$this->url."_progressBar').width(0);

                  custom_alert('Upload Success');

                  x = getListLampiran(id);
                  $('#".$this->url."_listLampiran').html(x);
                },

                error: function(error){
                  //upload failed
                  $('#".$this->url."_progress').html('Failure!<br>' + error.name + ': ' + error.message);
                }

              });

            });

          });
          
          
          
          function hapus(id){
            var action = '".$action."';
            if (action=='view'){
              return false;
            }
            var idNya = '".$idnya."';
            jwb = confirm('Hapus Lampiran ini ?');
            if (jwb==1){
              prosesHapus(id);
              custom_alert('File Deleted');
              x = getListLampiran(idNya);
              $('#".$this->url."_listLampiran').html(x);
            }
          }

          function prosesHapus(id){
            return $.ajax({
              type: 'POST', 
              url: '".$urlhapus."',
              data: '_id='+id,
              async:false
            }).responseText
          }

          function getListLampiran(id){
            return $.ajax({
              type: 'POST', 
              url: '".$urlgetLampiran."',
              data: 'id='+id,
              async:false
            }).responseText
          }
        </script>";
        return $o;
    

    }


    function getListLampiran($id){
    $o = "";
    $sql = "SELECT id,vName,vPath FROM hrd.pk_trans_attch WHERE iPkTransId='".$id."'";
         $query = $this->db_erp_pk->query($sql);
      if ($query->num_rows() > 0) {
        $o = "<ol>";
        foreach($query->result() as $row) {
          $idLamp = $row->id;
          $o .= "<li><a target='_blank' href='".base_url()."files/hdsystem/".$row->vPath."' >".$row->vName."</a> <a href='javascript:void(0);' style='color: red;' onClick='hapus(".$idLamp.")'  >[x]</a></li>";
        }
        $o .= "</ol>";
      }


    return $o;
  }


  function getListLampiran2(){
    $o = "-";
    $id = $_POST['id'];
    $sql = "SELECT id,vName,vPath FROM hrd.pk_trans_attch WHERE iPkTransId='".$id."'";
         $query = $this->db_erp_pk->query($sql);
      if ($query->num_rows() > 0) {
        $o = "<ol>";
        foreach($query->result() as $row) {
          $idLamp = $row->id;
          $o .= "<li><a target='_blank' href='".base_url()."files/hdsystem/".$row->vPath."' >".$row->vName."</a> <a href='javascript:void(0);' style='color: red;' onClick='hapus(".$idLamp.")'  >[x]</a></li>";
        }
        $o .= "</ol>";
      }

    
    echo $o;
  }

  public function insertbox_pk_pd3_asc_iSkemaId($field, $id) {
      

      $o = "<select name='".$field."' id='".$id."'>";
      $o .= "</select>";

      return $o;
    }

    public function updatebox_pk_pd3_asc_iSkemaId($field, $id,$value,$data) {
      $iPostId = $data['iPostId'];
      $url = base_url().'processor/pk/pk/pd3/asc?action=getDetail';
      $sql = "SELECT id,vName FROM hrd.pk_skema WHERE id ='".$value."' ";
      $query = $this->db_erp_pk->query($sql);
      if ($query->num_rows > 0) {
        $row = $query->row();
        $vName = $row->vName;
      } 

      $o = "<input type='hidden' id='".$id."' name='".$id."' value='".$value."'  /> <b>".$vName."</b>";
      
    return $o;

    }

  public function insertbox_pk_pd3_asc_detail($field, $id) {
    
    $o = "<div id='".$this->url."_detail' style='background-color: white;
padding: 5px;
border: 1px solid aquamarine;' >
      <h3>Petunjuk pelaksanaan</h3>
      <ol style='padding-left: 40px;'>
        <li>Baca dan pahami setiap aspek penilaian yang ada</li>
        <li>Berikan penilaian sesuai dengan hasil dan sikap kerja yang ditunjukkan sepanjang periode penilaian, dengan cara memilih pada point yang sesuai.</li>
        <li>Penilaian masing-masing dilakukan oleh karyawan yang bersangkutan dan oleh Atasan.</li>
        <li>Selanjutnya proses penilaian harus dilakukan dengan melakukan diskusi antara Karyawan dengan Atasan, untuk memberikan evaluasi dan feed back.</li>
        <li>Setelah proses selesai dilakukan, lengkapi dengan catatan dan approval Karyawan dan Atasan, lalu cetak dan kirimkan hasil penilaian tersebut ke HRD yang selanjutnya akan memasukkan hasil penilaian tersebut dalam file karyawan. </li>
      </ol>

      <br />

      <h3>Petunjuk pengisian</h3>
      <ol style='padding-left: 40px;'>
        <li>Berikanlah angka pada kolom yang tersedia sesuai dengan hasil penilaian yang dilakukan.</li>
        <li>Dalam proses diskusi, point penilaian dibicarakan sehingga dapat diperoleh point yang disepakati antara Karyawan dan Atasan. Namun apabila tidak terjadi kesepakatan, maka masing-masing tetap pada point penilaian yang sudah diberikan dan ditentukan nilai rata-rata dari point penilaian Karyawan dan dari point penilaian Atasan.</li>
        <li>Nilai yang disepakati atau nilai rata-rata tersebut, oleh system akan dikalikan dengan bobot dari tiap item penilaian tersebut.</li>
        <li>Sistem akan menjumlahkan point seluruh item dari masing-masing aspek, kemudian mengalikannya dengan bobot dari aspek tersebut.</li>
        <li>Hasil akhir dari setiap aspek akan dijumlahkan dan dikonversikan nilai tersebut ke kategori penilaian yang ada.</li>
      </ol>
  
    </div>";

    return $o;
  }

  public function updatebox_pk_pd3_asc_detail($field, $id,$value,$data) {
    $idnya      = $data['iSkemaId'];
    $iPkTransId = $data['id'];
    $cNip       = $data['cNip'];
    
    $adagrpid = 0;
    $sqlgrp = "SELECT a.iSkemaId,a.iMsGroupAspekId,a.nBobot,
    (SELECT vDescription FROM hrd.pk_msgroup_aspek WHERE id=a.iMsGroupAspekId) AS group_aspek
    FROM hrd.pk_group_aspek AS a WHERE a.lDeleted=0 and a.iSkemaId='".$idnya."'";

    $o = "<div id='detailPointPk'></div>";

    $o .= '<div style="margin: 30px 5px 10px -185px; display: block;background-color: antiquewhite;" id="'.$this->url.'_list_detail">';
     $o .= ' <ul>';
    $query = $this->db_erp_pk->query($sqlgrp);
    if ($query->num_rows > 0) {
      foreach($query->result_array() as $line) {
        $adagrpid .= ",".$line['iMsGroupAspekId'];
        $group_aspek      = $line['group_aspek'];
        $iMsGroupAspekId  = $line['iMsGroupAspekId'];

        $o .= ' <li><a href="#'.$this->url.'_'.$iMsGroupAspekId.'">'.$group_aspek.'</a></li>';

        

        $o .= "<script>
                  $(document).ready(function() {
                                
                   
                    
                  });

              </script>";
      }

      $o .= ' <li><a href="#'.$this->url.'_hasil_akhir">HASIL AKHIR</a></li>';

    }
    $o .= '   </ul>';

     $query = $this->db_erp_pk->query($sqlgrp);
    if ($query->num_rows > 0) {
      foreach($query->result_array() as $line) {
        $group_aspek      = $line['group_aspek'];
        $iMsGroupAspekId  = $line['iMsGroupAspekId'];

        $o .= '<div id="'.$this->url.'_'.$iMsGroupAspekId.'">
                  <div style="background-color: white;
                      border: solid 1px aquamarine;
                      padding: 5px;">
                   '.$this->generateAspekDivisi($idnya,$iMsGroupAspekId,$iPkTransId,$cNip,$data).'
                   </div>
              </div>';
      }
    }

    $o .= '<div id="'.$this->url.'_hasil_akhir">
                  <div style="background-color: white;
                      border: solid 1px aquamarine;
                      padding: 5px;">
                   '.$this->generateHasilAkhir($iPkTransId,$cNip,$data).'
                   </div>
              </div>';


    $o .= '   </div>';


    /*$o .= "<div id='divPop_".$this->url."' style='display:none;'>
        <div>
          <table>
            <tbody>
             

              <tr>
                <td>Grup Aspek</td>
                <td>:</td>
                <td>";
                  $o  .= "<select name='".$this->url."_iMsGroupAspekId' id='".$this->url."_iMsGroupAspekId'>";
                      $o  .= "<option value=''>Pilih</option>";
                      $sql = "SELECT id, vDescription from hrd.pk_msgroup_aspek where ldeleted = 0 and id not in (".$adagrpid.") ";
                      $query = $this->db_erp_pk->query($sql);
                if ($query->num_rows() > 0) {
                          $result = $query->result_array();
                          foreach($result as $row) {

                                 $o .= "<option value='".$row['id']."'>".$row['vDescription']."</option>";
                          }
                      } 
                  
                      $o .= "</select>";


                $o .= "</td>
              </tr>

              <tr>
                <td>Bobot</td>
                <td>:</td>
                <td><input type='text' size='5' name='".$this->url."_nBobot' id='".$this->url."_nBobot' /></td>
              </tr>
            </tbody>
          </table>
          
        </div>";*/




    $o .=  "<script type='text/javascript'>
            $(document).ready(function() {
                $('#".$this->url."_list_detail').tabs(); 

               
            });

      </script>";


    return $o;
  }
    


  public function updatebox_pk_pd3_asc_Approval($field, $id,$value,$data) {
    $id = $data['id'];
   $o = '<div class="box_cbox">
                    <table id="table_approval_<?=$this->url?>" cellspacing="0" cellpadding="3" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
                    <thead>
                    <!-- <tr style="width: 98%; border: 1px solid #dddddd; background: #aaaaaa; border-collapse: collapse">      -->
                            <tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
                            
                            <th style="border: 1px solid #dddddd;">Name</th>
                            <th style="border: 1px solid #dddddd;">Status</th>
                            <th style="border: 1px solid #dddddd;">Reason</th>
                            <th style="border: 1px solid #dddddd;">Date </th>   
                    </tr>
                    </thead>
                    <tbody>';
    $sql = "SELECT cNip,iStatus,vReason,dDate 
          FROM hrd.pk_pd3_asc WHERE iSkemaId='".$id."' ORDER BY id ASC";
    $query=$this->db->query($sql);
    if($query->num_rows() > 0 ){
      foreach($query->result() as $row) {
        if ($row->iStatus==0){
            $status = '<strong>Need Approval</strong>';
            $color = ' ';
        }else if ($row->iStatus==1){
            $status = '<strong>(✔) Approved </strong>';
            $color = 'color="#1f8b4c"';
        }else if ($row->iStatus==2){
            $status = '<strong>(&#10008) Rejected </strong>';
            $color = 'color="red"';
        }

        $tApprv = date('d-m-Y h:i:s',strtotime($row->dDate));
        $o .= '<tr style="width: 100%; border: 1px solid #dddddd;  border-collapse: collapse" >
                  <td style="border: 1px solid #dddddd;">'.$row->cNip.' - '.$this->lib_utilitas->getvName($row->cNip).'</td>
                  <td style="border: 1px solid #dddddd;">
                      <font  size="1" '.$color.' >'.$status.'</font></td>
                  <td style="border: 1px solid #dddddd;">'.$row->vReason.'</td>
                  <td style="border: 1px solid #dddddd;">'.$tApprv.'</td>
              </tr>';
      }
    }


    $o .= " 
              </tbody></table>
            </div>";

    return $o;

  }


  public function manipulate_update_button($button,$rowData) {  
    unset($button['update']);
    $idnya = $rowData['id'];
    $cNipNya = $rowData['cNip'];

       $btnSave  =  "<script type='text/javascript'>                      
                
                function update_btn_back_".$this->url."(grid, url, dis) {
                  var req = $('#form_update_'+grid+' input.required, #form_update_'+grid+' select.required, #form_update_'+grid+' textarea.required');
                  var conf=0;
                  var alert_message = '';
                  var tot_err = 0;

                  if ($('#".$this->url."_cNip').val() == '') {
                                    custom_alert('Lengkapi karyawan');
                                    return false;
                                }

                                if ($('#".$this->url."_dPk').val() == '') {
                                    custom_alert('Lengkapi Tanggal Penilaian');
                                    return false;
                                }

                                if ($('#".$this->url."_iSemester').val() == '') {
                                    custom_alert('Pilih Semester');
                                    return false;
                                }

                                if ($('#".$this->url."_cTahun').val() == '') {
                                    custom_alert('Pilih Tahun');
                                    return false;
                                }

                                if ($('#".$this->url."_dPeriode1').val() == '') {
                                    custom_alert('Pilih Periode Penilaian');
                                    return false;
                                }

                                if ($('#".$this->url."_dPeriode2').val() == '') {
                                    custom_alert('Pilih Periode Penilaian');
                                    return false;
                                }

                                if ($('#".$this->url."_iSkemaId').val() == '' || $('#".$this->url."_iSkemaId').val()==0) {
                                    custom_alert('Pilih Skema PK');
                                    return false;
                                }
                  
                  
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

                        if(o.status == true) {                         
                           $.get(url+'&action=update&id='+last_id, function(data) {
                             $('div#form_'+grid).html(data);
                                               
                          });
                    
                          reload_grid('grid_'+grid);
                          info = 'info';
                          header = 'Info';
                        }
                        _custom_alert(o.message,header,info,grid, 1, 20000);
                      }
                    })
                  })
                }
                
                </script>";
      $btnSave .= "<button type='button'
                name='button_update_".$this->url."'
                id='button_update_".$this->url."'
                class='icon-save ui-button'
                onclick='javascript:update_btn_back_".$this->url."(\"".$this->url."\", \"".base_url()."processor/pk/pk/pd3/asc?company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>Update 
                </button>";


      $urlsumbit  = base_url().'processor/pk/pk/pd3/asc?action=proses_approve';
      $btnSubmit  =  "<script type='text/javascript'>                      
                
                function proses_approve(id,jenis){
                    var cNipNya = '".$cNipNya."';
                    return $.ajax({
                        type: 'POST', 
                        url: '".$urlsumbit."',
                        data: '_id='+id+'&_jenis='+jenis+'&_cNipNya='+cNipNya,
                        async:false
                    }).responseText
                }

                



                function btn_submit_".$this->url."(grid, url, dis) {
                  var id = '".$idnya."';
                  x = proses_approve(id,0);

                  if (x!=''){
                    custom_alert(x);
                    return false;
                  }

                  
                  custom_confirm(comfirm_message,function(){
                        
                          x = proses_approve(id,1);

                          custom_alert('Confirmasi berhasil');
                           $.get(url+'&action=view&id='+id, function(data) {
                               $('div#form_'+grid).html(data);
                                                                   
                            });

                          reload_grid('grid_'+grid);

                          
                      })
                }
                
                </script>";
      $btnSubmit .= "<button type='button'
                name='button_update_".$this->url."'
                id='button_update_".$this->url."'
                class='icon-save ui-button'
                onclick='javascript:btn_submit_".$this->url."(\"".$this->url."\", \"".base_url()."processor/pk/pk/pd3/asc?company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>Sumbit 
                </button>";

      $btnApprove  =  "<script type='text/javascript'>                      
                
                function proses_approve(id,jenis){
                    var cNipNya = '".$cNipNya."';
                    return $.ajax({
                        type: 'POST', 
                        url: '".$urlsumbit."',
                        data: '_id='+id+'&_jenis='+jenis+'&_cNipNya='+cNipNya,
                        async:false
                    }).responseText
                }

                



                function btn_submit_".$this->url."(grid, url, dis) {
                  var id = '".$idnya."';
                  x = proses_approve(id,0);

                  if (x!=''){
                    custom_alert(x);
                    return false;
                  }

                  
                  custom_confirm(comfirm_message,function(){
                        
                          x = proses_approve(id,1);

                          custom_alert('Confirmasi berhasil');
                           $.get(url+'&action=view&id='+id, function(data) {
                               $('div#form_'+grid).html(data);
                                                                   
                            });

                          reload_grid('grid_'+grid);

                          
                      })
                }
                
                </script>";
      $btnApprove .= "<button type='button'
                name='button_update_".$this->url."'
                id='button_update_".$this->url."'
                class='icon-save ui-button'
                onclick='javascript:btn_submit_".$this->url."(\"".$this->url."\", \"".base_url()."processor/pk/pk/pd3/asc?company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>Approve 
                </button>";

      $btnAggrement =  "<script type='text/javascript'>                      
                
                function proses_agree(id,jenis,password,cNip){
                    var cNipNya = '".$cNipNya."';
                    return $.ajax({
                        type: 'POST', 
                        url: '".$urlsumbit."',
                        data: '_id='+id+'&_jenis='+jenis+'&_cNipNya='+cNipNya+'&_password='+password,
                        async:false
                    }).responseText
                }

                function showPop_".$this->url."(grid, url, dis,tgl) {
                  var ok = 0;
                  
                  $('#divPop_".$this->url."').dialog({
                    title : 'Prosess Aggrement',
                    modal : true,
                    show: 'slide',
                    hide: 'slide',
                    closeOnEscape: false,
                    beforeClose: function(event, ui) { 
                      
                      if ( ok == 0 ) {
                        
                        
                      }
                    },
                    buttons: {
                      'OK': function () {
                         var password = $('#".$this->url."_password').val();
                         var id   = '".$idnya."';
                         var cNip   = '".$cNipNya."';
                         
                         var x = proses_agree(id,2,password,cNip);

                         if (x!=''){
                            custom_alert(x);
                            $('#divPop_".$this->url."').dialog('close');
                            return false;
                         }

                         $('#divPop_".$this->url."').dialog('close');

                          $.get(url+'&action=view&id='+id, function(data) {
                               $('div#form_'+grid).html(data);
                                                                   
                            });

                          reload_grid('grid_'+grid);

                      },
                      'Cancel': function () {
                        //alert('cancel');
                        $('#divPop_".$this->url."').dialog('close');
                      }
                    }
                  });
                }



                function btn_agree_".$this->url."(grid, url, dis) {
                  var id = '".$idnya."';

                  showPop_".$this->url."(grid, url, dis,'".$idnya."');

                 

                  

                }
                
                </script>";
      $btnAggrement .= "<button type='button'
                name='button_update_".$this->url."'
                id='button_update_".$this->url."'
                class='icon-save ui-button'
                onclick='javascript:btn_agree_".$this->url."(\"".$this->url."\", \"".base_url()."processor/hdsystem/pk/transaksi/divisi?company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>Aggrement 
                </button>";

      $btnAggrement .= "
        <div id='divPop_".$this->url."' style='display:none;'>
        <div>
          <table>
            <tbody>
              <tr>
                <td>Employee</td>
                <td>:</td>
                <td>
                  <b>".$cNipNya." - ".$this->lib_utilitas->getvName($cNipNya)."</b>
                </td>
              </tr>
              <tr>
                <td>Password</td>
                <td>:</td>
                <td>
                  <input  type='password' name='".$this->url."_password' id='".$this->url."_password' value = ''/>
                </td>
              </tr>

              


            </tbody>
          </table>
          
        </div>
        <div style='margin-top:2px;'>
        <input type='hidden' size='30' name='tempTgl' id='tempTgl' class='tempTgl'/>
        </div>
        </div>";


      $vName = str_replace(" ", "_", $this->lib_utilitas->getvName($rowData['cNip']));

      $btn_preview  = '
                      <script type="text/javascript">
                         
                        
                        function print_'.$this->url.'() {
                          var id    = "'.$idnya.'";
                          var vName = "'.$vName.'";
                          
                          document.getElementById("iframe_preview_ga_'.$this->url.'").src = "'.base_url().'processor/pk/pk/pd3/asc?action=get_preview_report&id="+id+"&vName="+vName;
                          
                        }   
                      </script>
                    ';
     
    $btn_preview .= '<iframe height="0" width="0" id="iframe_preview_ga_'.$this->url.'"></iframe>';
    $btn_preview .= '<button onclick="javascript:print_'.$this->url.'();" class="ui-button-text icon-print" id="button_preview_ga_'.$this->url.'">Print</button>';                  


      $cNipNya = $rowData['cNip'];
      $listaybs =  $this->lib_utilitas->getAybs($cNipNya,$tmpNip=array());
      $nipLogin = $this->sess_auth->gNIP;
      //$manager = $listaybs;
      
      if ($this->input->get('action') != 'view') {
        if ($rowData['nFinal'] > 0 && $rowData['iStatus']==0){
          $button['update'] = $btnSave.$btnSubmit;

        }else if ($rowData['iStatus']==1 && in_array($nipLogin,$listaybs)){
          $button['update'] = $btnApprove;
        }else if ($rowData['iStatus']==3 && in_array($nipLogin,$listaybs)) {
          $button['update'] = $btnAggrement;
        }else{
          $button['update'] = '';
        }
        
      }else{
        if ($rowData['iStatus']==3 && in_array($nipLogin,$listaybs)){
          $button['update'] = $btnAggrement;
        }else if ($rowData['iStatus']==4){
          $button['update'] = $btn_preview;
        }else {
          $button['update'] = '';
        }
      } 
      return $button;
  }



  public function manipulate_insert_button($button) {
    unset($button['save']);


    $btnSave  =  "<script type='text/javascript'>               
                            
                           
                            function save_btn_back_".$this->url."(grid, url, dis) {
                                var req = $('#form_create_'+grid+' input.required, #form_create_'+grid+' select.required, #form_create_'+grid+' textarea.required');
                                var conf=0;
                                var alert_message = '';                             
                                var tot_err = 0;

                                
                                if ($('#".$this->url."_cNip').val() == '') {
                                    custom_alert('Lengkapi karyawan');
                                    return false;
                                }

                                if ($('#".$this->url."_dPk').val() == '') {
                                    custom_alert('Lengkapi Tanggal Penilaian');
                                    return false;
                                }

                                if ($('#".$this->url."_iSemester').val() == '') {
                                    custom_alert('Pilih Semester');
                                    return false;
                                }

                                if ($('#".$this->url."_cTahun').val() == '') {
                                    custom_alert('Pilih Tahun');
                                    return false;
                                }

                                if ($('#".$this->url."_dPeriode1').val() == '') {
                                    custom_alert('Pilih Periode Penilaian');
                                    return false;
                                }

                                if ($('#".$this->url."_dPeriode2').val() == '') {
                                    custom_alert('Pilih Periode Penilaian');
                                    return false;
                                }

                                if ($('#".$this->url."_iSkemaId').val() == '' || $('#".$this->url."_iSkemaId').val()==0 || $('#".$this->url."_iSkemaId').val()==null) {
                                    custom_alert('Pilih Skema PK');
                                    return false;
                                }

                                

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

                                            if(o.status == true) {                                             
                                               $.get(url+'&action=update&id='+last_id, function(data) {
                                                   $('div#form_'+grid).html(data);
                                                                                       
                                                });
                                    
                                                reload_grid('grid_'+grid);
                                                info = 'info';
                                                header = 'Info';
                                            }
                                            _custom_alert(o.message,header,info,grid, 1, 20000);
                                        }
                                    })
                                })
                            }
                          </script>";
        $btnSave .= "<button type='button'
                            name='button_add_".$this->url."'
                            id='button_add_".$this->url."'
                            class='icon-save ui-button'
                            onclick='javascript:save_btn_back_".$this->url."(\"".$this->url."\", \"".base_url()."processor/pk/pk/pd3/asc?company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>Save
                            </button>";
    $button['save'] = $btnSave;
    
    return $button;
  }



 
  public function before_update_processor($fields, $post) {
      $post['dPk']    = date('Y-m-d', strtotime($post['dPk']));
      $post['dPeriode1']    = date('Y-m-d', strtotime($post['dPeriode1']));
      $post['dPeriode2']    = date('Y-m-d', strtotime($post['dPeriode2']));
      return $post;
    }
 
  public function before_insert_processor($fields, $post) {
      
      $post['dPk']    = date('Y-m-d', strtotime($post['dPk']));
      $post['dPeriode1']    = date('Y-m-d', strtotime($post['dPeriode1']));
      $post['dPeriode2']    = date('Y-m-d', strtotime($post['dPeriode2']));
      return $post;
    }


  public function after_insert_processor($fields, $id, $post) {
    $cNip        =  $this->sess_auth->gNIP;
    $cNipNya     = $post['cNip'];
    $cTahun      = $post['cTahun'];
    $nSemester   = $post['iSemester'];
    $iPostId     = $post['iPostId'];
    $iSkemaId    = $post['iSkemaId'];


    $sql = "UPDATE hrd.pk_trans set lDeleted=0,iStatus=0,tCreated = CURRENT_TIMESTAMP, cCreatedBy='{$cNip}' where id = '{$id}'";
    $this->db_erp_pk->query($sql);

  }
  
  public function after_update_processor($fields, $id, $post, $old_data) {
    $cNip        =  $this->sess_auth->gNIP;
    $cNipNya     = $post['cNip'];
    $cTahun      = $post['cTahun'];
    $nSemester   = $post['iSemester'];
    $iPostId     = $post['iPostId'];
    $iSkemaId    = $post['iSkemaId'];


    $sql = "UPDATE hrd.pk_trans set lDeleted=0,tUpdated = CURRENT_TIMESTAMP, cUpdatedBy='{$cNip}' where id = '{$id}'";
    $this->db_erp_pk->query($sql);

  }
  
  

  function generateAspekDivisi($iSkemaId,$iMsGroupAspekId,$iPkTransId,$cNip,$rowData){
    $action      = $this->input->get('action');
    $nipLogin    =  $this->sess_auth->gNIP;
    $aybs        = $this->lib_utilitas->getSingleAybs($cNip);
    
    $cNipNya = $rowData['cNip'];
    $listaybs =  $this->lib_utilitas->getAybs($cNipNya,$tmpNip=array());
    $manager = $listaybs;
    $iStatus     = $rowData['iStatus'];

    $tmpNip = array();
    $arAybs = $this->lib_utilitas->getAybs($cNip,$tmpNip);
    //print_r($arAybs);

    

    

    $group_aspek = '';
    $sum_bobot   = '';
    $nBobot      = '';
    $id          = '';

    $sql = "SELECT a.id,a.iSkemaId,a.iMsGroupAspekId,a.nBobot,
          (SELECT vDescription FROM hrd.pk_msgroup_aspek WHERE id=a.iMsGroupAspekId) AS group_aspek,
          (SELECT COALESCE(SUM(nBobot),0) FROM hrd.pk_aspek WHERE iSkemaId=a.iSkemaId AND iMsGroupAspekId=a.iMsGroupAspekId) AS sum_bobot
          FROM hrd.pk_group_aspek AS a WHERE a.lDeleted=0 and a.iSkemaId='".$iSkemaId."' AND iMsGroupAspekId='".$iMsGroupAspekId."'";

    $query = $this->db_erp_pk->query($sql);
    if ($query->num_rows() > 0) {
        $row = $query->row();
        $nBobot = $row->nBobot;
        $group_aspek = $row->group_aspek;
        $sum_bobot   = $row->sum_bobot;
        $id          = $row->id;
    }

   

    $html = '<table cellspacing="0" cellpadding="3" style="width: 100%;">
              <thead>
                <tr style="width: 60%; border: 1px solid #f86609; background: #5c9ccc; border-collapse: collapse">
                  <th rowspan="2" style="border: 1px solid #dddddd;">No Urut</th>
                  <th rowspan="2" style="border: 1px solid #dddddd;width: 85%;">Aspek</th>
                  <th colspan="3" style="border: 1px solid #dddddd;">Point Penilaian Oleh</th>
                  <th rowspan="2" style="border: 1px solid #dddddd;">Point Sepakat atau Point rata-rata (a+b)/2</th>
                  <th rowspan="2" style="border: 1px solid #dddddd;">Bobot (%)</th>
                  <th rowspan="2" style="border: 1px solid #dddddd;">Nilai (Point x Bobot)</th>
                </tr>

                <tr style="width: 60%; border: 1px solid #f86609; background: #5c9ccc; border-collapse: collapse">
                   <th style="border: 1px solid #dddddd;">Karyawan (a)</th>
                   <th style="border: 1px solid #dddddd;">Point</th>
                   <th style="border: 1px solid #dddddd;">Atasan (b)</th>

                </tr>



                </thead>

                <tbody>';

    /*$sql = "SELECT id,iSkemaId,iMsGroupAspekId,iUrut,vAspekName,nBobot 
            FROM hrd.pk_aspek WHERE iSkemaId='".$iSkemaId."' 
            AND iMsGroupAspekId='".$iMsGroupAspekId."' AND lDeleted=0 order by iUrut ASC";*/


    $sql = "SELECT a.id,a.iSkemaId,a.iMsGroupAspekId,a.iUrut,a.vAspekName,a.nBobot,b.nBobot as bobot_saved,b.nPointKry,b.nPointAybs,b.ySource,
b.nPointSepakat,b.nNilai,a.lAutoCalculation,a.vFunctionLink,a.iSupportData 
            FROM hrd.pk_aspek as a
            left join hrd.pk_nilai as b on b.iAspekId=a.id and b.iPkTransId='".$iPkTransId."'
            WHERE a.iSkemaId='".$iSkemaId."'
            AND a.iMsGroupAspekId='".$iMsGroupAspekId."' 
            AND a.lDeleted=0 order by iUrut ASC";

    $nTotalNilai = 0;
    $query = $this->db_erp_pk->query($sql);
      if ($query->num_rows() > 0) {
        $result = $query->result_array();
        foreach($result as $row) {
          $iAspekId       = $row['id'];
          $nPointKry      = $row['nPointKry'];
          $nPointAybs     = $row['nPointAybs'];
          $bobot_saved    = $row['bobot_saved'];
          $nPointSepakat  = $row['nPointSepakat'];
          $nNilai         = $row['nNilai'];
          $nTotalNilai    = $row['nNilai'] + $nTotalNilai;
          $lAutoCalculation     = $row['lAutoCalculation'];
          $vFunctionLink        = $row['vFunctionLink'];
          $ySource              = $row['ySource'];
          $iSupportData         = $row['iSupportData'];

          
          if (($iStatus==1 || $iStatus==3 ) && in_array($nipLogin, $manager)){
            $disaybs = "";
          }else{
            $disaybs = "disabled";
          }

          if ($lAutoCalculation==1){
              $disaybs = "disabled";
          }
                   

      $html .= ' 
            <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                 <td rowspan="6"  style="border: 1px solid #dddddd; width: 7%;text-align: center">
                      '.$row['iUrut'].'
                 </td>
                 <td  style="border: 1px solid #dddddd; width: 90%;text-align: left">
                      <u><b>'.$row['vAspekName'].'</b></u>
                 </td>';
      if ($iSupportData==1){
        $html .= '<td colspan="3"  style="border: 1px solid #dddddd; width: 90%;text-align: center">
                      <span onClick="'.$this->url.'_input_supoortData('.$iAspekId.','.$iPkTransId.')" class="icon-add ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">Support Data</span>
                 </td>';
      }else{
        $html .= '<td colspan="3"  style="border: 1px solid #dddddd; width: 90%;text-align: left">
                      
                 </td>';
      }     
      

/*
        if ($lAutoCalculation==1){
          $html .= ' <td rowspan="6" style="border: 1px solid #dddddd; width: 90%;text-align: left">
                      <u><b>Hitung</b></u>
                 </td>';
        }*/
       

         $html .= '<td rowspan="6" style="border: 1px solid #dddddd; width: 5%;text-align: center">';

                    if ($iStatus==3 && in_array($nipLogin, $manager)){
                        $html .= '<input type="text" name="'.$this->url.'_nPointSepakat[]"  id="'.$this->url.'_nPointSepakat_'.$iAspekId.'" class="'.$this->url.'_nPointSepakat auto" size="3" value="'.$nPointSepakat.'" />

                     <span style="display:none" name="lable_'.$this->url.'_nPointSepakat[]"  id="lable_'.$this->url.'_nPointSepakat_'.$iAspekId.'">'.$nPointSepakat.'</span>';
                    }else{
                      $html .= '<input type="hidden" name="'.$this->url.'_nPointSepakat[]"  id="'.$this->url.'_nPointSepakat_'.$iAspekId.'" class="'.$this->url.'_nPointSepakat auto" size="3" value="'.$nPointSepakat.'" />

                     <span name="lable_'.$this->url.'_nPointSepakat[]"  id="lable_'.$this->url.'_nPointSepakat_'.$iAspekId.'">'.$nPointSepakat.'</span>';
                    }

                   
                     

                $html .= ' </td>

                 <td rowspan="6" style="border: 1px solid #dddddd; width: 5%;text-align: center">
                      '.$row['nBobot'].'%
                 </td>

                 <td rowspan="6" style="border: 1px solid #dddddd; width: 5%;text-align: center">

                       <input type="hidden" name="'.$this->url.'_iAspekIdnya[]" value="'.$iAspekId.'" class="'.$this->url.'_iAspekIdnya" id="'.$this->url.'_iAspekIdnya" />

                      
                      <input type="hidden" name="'.$this->url.'_nBobotnya[]" id="'.$this->url.'_nBobotnya" value="'.$row['nBobot'].'" class="'.$this->url.'_nBobotnya" />

                      <input type="hidden" name="'.$this->url.'_iMsGroupAspekIdNya[]" value="'.$iMsGroupAspekId.'" class="'.$this->url.'_iMsGroupAspekIdNya_'.$iAspekId.'" id="'.$this->url.'_iMsGroupAspekIdNya" />

                      <input type="hidden" name="'.$this->url.'_nNilai[]"  id="'.$this->url.'_nNilai_'.$iAspekId.'" value="'.$nNilai.'" class="'.$this->url.'_nNilai"/>


                       <input type="hidden" name="'.$this->url.'_groupnilai_'.$iMsGroupAspekId.'[]"  id="'.$this->url.'_groupnilai_'.$iAspekId.'" value="'.$nNilai.'" class="'.$this->url.'_groupnilai_'.$iMsGroupAspekId.'"/>

                      

                      <input type="hidden" name="'.$this->url.'_ySource[]"  id="'.$this->url.'_ySource_'.$iAspekId.'" class="'.$this->url.'_ySource" size="2" value="'.$ySource.'" />

                      <input type="hidden" name="'.$this->url.'_tmpPilih[]"  id="'.$this->url.'_tmpPilih_'.$iAspekId.'" class="'.$this->url.'_tmpPilih" size="2" value="'.$nPointKry.'" />

                      <input type="hidden" name="'.$this->url.'_tmpAybs[]"  id="'.$this->url.'_tmpAybs_'.$iAspekId.'" class="'.$this->url.'_tmpAybs" size="2" 
                      value="'.$nPointAybs.'"/>

                      <b><span id="lable_'.$this->url.'_nNilai_'.$iAspekId.'" >'.$nNilai.'</span></b>
                   </td>
              </tr>';

      //====================Isi Detailnya dimulai Dari Sini yooo======================

      $sqld = "SELECT iAspekId,vDescription,nPoint,
              (SELECT a.cWarna FROM hrd.pk_warna AS a WHERE a.iPoint=hrd.pk_aspek_detail.nPoint ) AS cWarna
      FROM hrd.pk_aspek_detail WHERE iAspekId='".$iAspekId."' AND ldeleted=0 ORDER BY nPoint DESC";
     $query = $this->db_erp_pk->query($sqld);
      if ($query->num_rows() > 0) {
        $result = $query->result_array();
        foreach($result as $line) {
          $cWarna   = $line['cWarna'];
          $iAspekId = $line['iAspekId'];
          $nPoint   = $line['nPoint'];
          $nBobot   = $row['nBobot'];
          

          if ($nPointKry==$line['nPoint']){
            $selKry = 'checked="checked"';
            $colorPk  = $this->lib_utilitas->getColorPK($line['nPoint']); 
          }else{
            $selKry = '';
            $colorPk = '#ffffff';
          }


          if ($nPointAybs==$line['nPoint']){
            $selAybs = 'checked="checked"';
          }else{
            $selAybs = '';
          }

          if ($iStatus>=1 || $action=='view'){
            $diskry = "disabled";
          }else{
            $diskry = "";
          }

          
          if ($line['nPoint']==100){
            $rowspan = 'rowspan="5"';
          }else{
            $rowspan = '';
          }

          if ($nPointKry != '0'){
            $displayDetail = 'style="display:block"';
          }else{
            $displayDetail = 'style="display:none"';
          }


          $html .= ' <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td id="vDescription_'.$this->url.'_'.$iAspekId.'_'.$nPoint.'" style="width:90%;border: 1px solid #dddddd;background-color:'.$colorPk.' "  > 
                           '.$line['vDescription'].'
                        </td>';

           //Hitung disini      
          if ($lAutoCalculation==1 && $line['nPoint']==100){

            if ($nPointKry != '0'){
              $kataAnto = number_format($ySource,2);
            }else{
              $kataAnto = 'Hitung';
            }

             /*<a href="javascript:void(0);" id="link_'.$this->url.'_hitung_'.$iAspekId.'"
                          onClick="'.$this->url.'_hitungPk(\''.$vFunctionLink.'\','.$iAspekId.',1,'.$nBobot.')" >
                          <b><span id="lable_'.$this->url.'_nNilai_'.$iAspekId.'" ><i>'.$kataAnto.'</i></span></b></a>*/
            
                switch ($vFunctionLink) {
                  case 'PD3_ASC_getParameter7':
                      $html .= '<td '.$rowspan.' style="width:10%;text-align: center;border: 1px solid #dddddd;">';
                      $html .= '
                              <input type="hidden" name="'.$this->url.'_iAspekId[]" value="'.$iAspekId.'" class="'.$this->url.'_iAspekId" id="'.$this->url.'_iAspekId" />
                              <input  type="hidden" name="'.$this->url.'_nBobot[]" id="'.$this->url.'_nBobot" value="'.$row['nBobot'].'" class="'.$this->url.'_nBobot" />
                              <img style="display:none;" id="img_'.$this->url.'_nNilai_'.$iAspekId.'" src="../assets/images/e-load.gif" width="50px" height="50px" >
                                 
                                  <br />
                                  <br />
                                  
                                  ';
                      $datax['displayDetail']=$displayDetail;
                      $datax['uerel']=$this->url;
                      $datax['iAspekId']=$iAspekId;
                      $datax['vFunctionLink']=$vFunctionLink;
                      $datax['nBobot']=$nBobot;
                      $datax['kataAnto']=$kataAnto;
                      $datax['iPkTransId']=$iPkTransId;
                      


                      $html .=  $this->load->view('pd/'.$vFunctionLink,$datax,true);
                      $html .=  '
                                <br />
                                  <br />
                                  <a '.$displayDetail.' href="javascript:void(0);" id="detail_'.$this->url.'_hitung_'.$iAspekId.'"
                                  onClick="'.$this->url.'_hitungPk_'.$vFunctionLink.'(\''.$vFunctionLink.'\','.$iAspekId.',2,'.$nBobot.')" >
                                  <b><span id="lable_'.$this->url.'_nNilai_'.$iAspekId.'" >Detail</span></b></a>


                              </td>';


                    break;

                  case 'PD3_ASC_getParameter8':
                      $html .= '<td '.$rowspan.' style="width:10%;text-align: center;border: 1px solid #dddddd;">';
                      $html .= '
                              <input type="hidden" name="'.$this->url.'_iAspekId[]" value="'.$iAspekId.'" class="'.$this->url.'_iAspekId" id="'.$this->url.'_iAspekId" />
                              <input  type="hidden" name="'.$this->url.'_nBobot[]" id="'.$this->url.'_nBobot" value="'.$row['nBobot'].'" class="'.$this->url.'_nBobot" />
                              <img style="display:none;" id="img_'.$this->url.'_nNilai_'.$iAspekId.'" src="../assets/images/e-load.gif" width="50px" height="50px" >
                                 
                                  <br />
                                  <br />
                                  
                                  ';
                      $datax['displayDetail']=$displayDetail;
                      $datax['uerel']=$this->url;
                      $datax['iAspekId']=$iAspekId;
                      $datax['vFunctionLink']=$vFunctionLink;
                      $datax['nBobot']=$nBobot;
                      $datax['kataAnto']=$kataAnto;
                      $datax['iPkTransId']=$iPkTransId;
                      


                      $html .=  $this->load->view('pd/'.$vFunctionLink,$datax,true);
                      $html .=  '
                                <br />
                                  <br />
                                  <a '.$displayDetail.' href="javascript:void(0);" id="detail_'.$this->url.'_hitung_'.$iAspekId.'"
                                  onClick="'.$this->url.'_hitungPk_'.$vFunctionLink.'(\''.$vFunctionLink.'\','.$iAspekId.',2,'.$nBobot.')" >
                                  <b><span id="lable_'.$this->url.'_nNilai_'.$iAspekId.'" >Detail</span></b></a>


                              </td>';


                    break;
                  
                  default:
                        $html .='<td '.$rowspan.' style="width:10%;text-align: center;border: 1px solid #dddddd;">

                              <input type="hidden" name="'.$this->url.'_iAspekId[]" value="'.$iAspekId.'" class="'.$this->url.'_iAspekId" id="'.$this->url.'_iAspekId" />

                              <input  type="hidden" name="'.$this->url.'_nBobot[]" id="'.$this->url.'_nBobot" value="'.$row['nBobot'].'" class="'.$this->url.'_nBobot" />

                              <img style="display:none;" id="img_'.$this->url.'_nNilai_'.$iAspekId.'" src="../assets/images/e-load.gif" width="50px" height="50px" >
                              
                              <a href="javascript:void(0);" id="link_'.$this->url.'_hitung_'.$iAspekId.'"
                              onClick="'.$this->url.'_hitungPk(\''.$vFunctionLink.'\','.$iAspekId.',1,'.$nBobot.')" >
                              <b><span id="lable_'.$this->url.'_nNilai_'.$iAspekId.'" ><i>'.$kataAnto.'</i></span></b></a>
                              <br />
                              <br />
                              <a '.$displayDetail.' href="javascript:void(0);" id="detail_'.$this->url.'_hitung_'.$iAspekId.'"
                              onClick="'.$this->url.'_hitungPk(\''.$vFunctionLink.'\','.$iAspekId.',2,'.$nBobot.')" >
                              <b><span id="lable_'.$this->url.'_nNilai_'.$iAspekId.'" >Detail</span></b></a>

                        </td>';

                    break;
                }
            
            
            }else if ($lAutoCalculation==0){
                 $html .= '<td  style="width:10%;text-align: center;border: 1px solid #dddddd;">

                          <input type="hidden" name="'.$this->url.'_iAspekId[]" value="'.$iAspekId.'" class="'.$this->url.'_iAspekId" id="'.$this->url.'_iAspekId" />

                          <input  type="hidden" name="'.$this->url.'_nBobot[]" id="'.$this->url.'_nBobot" value="'.$row['nBobot'].'" class="'.$this->url.'_nBobot" />


                          <input '.$diskry.' type="radio" name="'.$this->url.'_nPointKry_'.$iAspekId.'[]" id="'.$this->url.'_nPointKry_'.$iAspekId.'" value="'.$line['nPoint'].'" class="'.$this->url.'_nPointKry" '.$selKry.' onClick="'.$this->url.'_pilihRadio('.$iAspekId.','.$nBobot.','.$nPoint.')"  />
                        </td>';

            }
         
             $html .= '

                        <td style="width:10%;text-align: center;border: 1px solid #dddddd;background-color:'.$cWarna.';">
                          '.$line['nPoint'].'
                        </td>

                        <td style="width:10%;text-align: center;border: 1px solid #dddddd;">
                         
                          <input '.$disaybs.' type="radio" name="'.$this->url.'_nPointAybs_'.$iAspekId.'" id="'.$this->url.'_nPointAybs_'.$iAspekId.'" class="'.$this->url.'_nPointAybs" value="'.$line['nPoint'].'" '.$selAybs.' 
                          onClick="'.$this->url.'_pilihRadioAybs('.$iAspekId.','.$nBobot.','.$nPoint.')" />
                        </td>

                      </tr>';

        }
      }


      }
    }
    $html .= ' </tbody>
                <tfoot>
                    <tr>
                    <td style="border: 1px solid #dddddd; width: 15%;text-align: center" colspan="6"><b>TOTAL BOBOT '.$group_aspek.'</b></td>
                    <td style="border: 1px solid #dddddd; width: 15%;text-align: center" >
                        <b>'.$sum_bobot.'%</b>
                    </td>
                    <td style="border: 1px solid #dddddd; width: 15%;text-align: center" >
                        <input type="hidden" name="'.$this->url.'_nResult[]" id="'.$this->url.'_nResult" value="'.number_format($nTotalNilai,2).'" size="3" class="'.$this->url.'_nResult_'.$iMsGroupAspekId.'" />
                        <b><span id="lable_'.$this->url.'_nResult_'.$iMsGroupAspekId.'">'.number_format($nTotalNilai,2).'</span></b>
                    </td>
                     </tr>

                     <tr>
                     <td style="border: 1px solid #dddddd; width: 15%;text-align: center" colspan="8">';

                    $tombol = '<a  href="javascript:void(0);" onclick="simpanPoint('.$iMsGroupAspekId.')" class="icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">Simpan '.ucwords(strtolower($group_aspek)).'</a>';

                    $tombolAggre = '<a  href="javascript:void(0);" onclick="simpanPoint('.$iMsGroupAspekId.')" class="icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">Simpan Point Sepakat '.ucwords(strtolower($group_aspek)).'</a>';
                    if ($action=='view'){
                        $tombol = '';
                    }

                    if ($iStatus==1 && in_array($nipLogin, $manager)){
                      $html .= $tombol;
                    }else if ($iStatus==0 /*&& $nipLogin==$cNip*/){
                      $html .= $tombol;
                    }else if ($iStatus==3 && in_array($nipLogin, $manager)){
                      $html .= $tombolAggre;
                    }

                     
                     $html .= '</td>
                     </tr>
                </tfoot>



          </table>';
     $urlSD = base_url().'processor/pk/pk/pd3/asc?action=supportData';
     $urlgetValuePk = base_url().'processor/pk/pk/pd3/asc?action=getValuePk';
     $urlDetail = base_url().'processor/pk/pk/pd3/asc?action=showDetail';
     $url = base_url().'processor/pk/pk/pd3/asc?action=SaveNilai';
     $rUrl = base_url()."processor/pk/pk/pd3/asc?company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id');

     $html .= "<script>

      $(document).ready(function() {
        $('.pk_pd3_asc_nPointSepakat').autoNumeric('init', {vMin:'0', vMax:'100'});
     
      });

      $('.pk_pd3_asc_nPointSepakat').live('keyup', function() {                
        var ix = $('.pk_pd3_asc_nPointSepakat').index($(this));

        var point  = $('.".$this->url."_nPointSepakat').eq(ix).val();
        if (point==''){
          point = 0;
        }
        var bobot  = $('.".$this->url."_nBobotnya').eq(ix).val();
        var iAspekId  = $('.".$this->url."_iAspekIdnya').eq(ix).val();
        var nilai  = (parseFloat(point) * parseFloat(bobot))/100;

        
        $('#".$this->url."_nNilai_'+iAspekId+'').val(nilai.toFixed(2));
        $('#".$this->url."_groupnilai_'+iAspekId+'').val(nilai.toFixed(2));
        //$('#".$this->url."_tmpPilih_'+iAspekId+'').val(point);
        $('#lable_".$this->url."_nNilai_'+iAspekId+'').html(nilai.toFixed(2));
        
        var iMsGroupAspekId = $('.".$this->url."_iMsGroupAspekIdNya_'+iAspekId+'').val();
        sum_".$this->url."(iMsGroupAspekId);

        //simpanPointDetail(iMsGroupAspekId);

      });


      $('.pk_pd3_asc_nPointSepakat').live('blur', function() {  
            var ix = $('.pk_pd3_asc_nPointSepakat').index($(this));

            var point  = $('.".$this->url."_nPointSepakat').eq(ix).val();
            if (point==''){
            point = 0;
            }
            var bobot  = $('.".$this->url."_nBobotnya').eq(ix).val();
            var iAspekId  = $('.".$this->url."_iAspekIdnya').eq(ix).val();
            var nilai  = (parseFloat(point) * parseFloat(bobot))/100;

              
            $('#".$this->url."_nNilai_'+iAspekId+'').val(nilai.toFixed(2));
            $('#".$this->url."_groupnilai_'+iAspekId+'').val(nilai.toFixed(2));
            //$('#".$this->url."_tmpPilih_'+iAspekId+'').val(point);
            $('#lable_".$this->url."_nNilai_'+iAspekId+'').html(nilai.toFixed(2));
              
            var iMsGroupAspekId = $('.".$this->url."_iMsGroupAspekIdNya_'+iAspekId+'').val();
            sum_".$this->url."(iMsGroupAspekId);
            simpanPointDetail(iMsGroupAspekId);
      });

     

      function ".$this->url."_pilihRadio(iAspekId,bobot,point){
        
          
          var nilai  = (parseFloat(point) * parseFloat(bobot))/100;
          $('#".$this->url."_nNilai_'+iAspekId+'').val(nilai.toFixed(2));
          $('#".$this->url."_groupnilai_'+iAspekId+'').val(nilai.toFixed(2));
          $('#".$this->url."_tmpPilih_'+iAspekId+'').val(point);
          $('#lable_".$this->url."_nNilai_'+iAspekId+'').html(nilai.toFixed(2));
          $('#".$this->url."_tmpAybs_'+iAspekId+'').val(point);

          $('#".$this->url."_nPointSepakat_'+iAspekId+'').val(point);
          $('#lable_".$this->url."_nPointSepakat_'+iAspekId+'').html(point);

          var iMsGroupAspekId = $('.".$this->url."_iMsGroupAspekIdNya_'+iAspekId+'').val();
          sum_".$this->url."(iMsGroupAspekId);

          simpanPointDetail(iMsGroupAspekId);

      }


      function ".$this->url."_pilihRadioAybs(iAspekId,bobot,point){
        var pointKry = $('#".$this->url."_tmpPilih_'+iAspekId+'').val();

        if (pointKry==0 || pointKry== ''){
          custom_alert('Point Karyawan Kosong');
          return false;
        }

        var sepakat = (parseFloat(pointKry) + parseFloat(point) )/2
        console.log(sepakat)
        
        var nilai  = (parseFloat(sepakat) * parseFloat(bobot))/100;

        $('#".$this->url."_nPointSepakat_'+iAspekId+'').val(sepakat.toFixed(2));
        $('#lable_".$this->url."_nPointSepakat_'+iAspekId+'').html(sepakat.toFixed(2));
        $('#".$this->url."_nNilai_'+iAspekId+'').val(nilai.toFixed(2));
        $('#".$this->url."_groupnilai_'+iAspekId+'').val(nilai.toFixed(2));
        $('#".$this->url."_tmpAybs_'+iAspekId+'').val(point);
        $('#lable_".$this->url."_nNilai_'+iAspekId+'').html(nilai.toFixed(2));
        
        var iMsGroupAspekId = $('.".$this->url."_iMsGroupAspekIdNya_'+iAspekId+'').val();
        sum_".$this->url."(iMsGroupAspekId);
        simpanPointDetail(iMsGroupAspekId);

      }


     


      function sum_".$this->url."(iMsGroupAspekId){
       
        var i     = 0;
        var total     = 0;

        $('.".$this->url."_groupnilai_'+iMsGroupAspekId).each(function() {
          if ($('.".$this->url."_groupnilai_'+iMsGroupAspekId).eq(i).val() != '') {        
            total += parseFloat($('.".$this->url."_groupnilai_'+iMsGroupAspekId).eq(i).val());
            
          }

          i++;
        });

       

        //alert(iMsGroupAspekId)
        $('.".$this->url."_nResult_'+iMsGroupAspekId).val(total.toFixed(2));
        $('#lable_".$this->url."_nResult_'+iMsGroupAspekId).html(total.toFixed(2));

      }

      function simpanPoint(iMsGroupAspekId){
        
        var iPkTransId = '".$iPkTransId."';
       
        $.ajax({
           type: 'POST',
           url: '".$url."',
           data: $('#form_update_".$this->url."').serialize()+'&_iMsGroupAspekId='+iMsGroupAspekId,
           success: function(data)
           {
                custom_alert(data);
                 $.get('".$rUrl."&action=update&id='+iPkTransId, function(data) {
                     $('div#form_".$this->url."').html(data);
                                       
                  });
           }
         });

      }


      function simpanPointDetail(iMsGroupAspekId){
        
        var iPkTransId = '".$iPkTransId."';
       
        $.ajax({
           type: 'POST',
           url: '".$url."',
           data: $('#form_update_".$this->url."').serialize()+'&_iMsGroupAspekId='+iMsGroupAspekId,
           success: function(data)
           {
                /*custom_alert(data);
                 $.get('".$rUrl."&action=update&id='+iPkTransId, function(data) {
                     $('div#form_".$this->url."').html(data);
                                       
                  });*/
           }
         });

      }


      function ".$this->url."_hitungPk(vFunctionLink,iAspekId,tampil,bobot){

            var action = '".$action."';
          $('#img_".$this->url."_nNilai_'+iAspekId).show();
          $('#link_".$this->url."_hitung_'+iAspekId).hide();

          var hasil = ".$this->url."_getValuePk(vFunctionLink,iAspekId)
          var x_hasil = hasil.split('~');
          value = x_hasil['0'];
          point = x_hasil['1'];
          color = x_hasil['2'];
          html  = x_hasil['3'];

          document.getElementById('vDescription_pk_pd3_asc_'+iAspekId+'_100').style.backgroundColor='#ffffff';
          document.getElementById('vDescription_pk_pd3_asc_'+iAspekId+'_80').style.backgroundColor='#ffffff';
          document.getElementById('vDescription_pk_pd3_asc_'+iAspekId+'_60').style.backgroundColor='#ffffff';
          document.getElementById('vDescription_pk_pd3_asc_'+iAspekId+'_40').style.backgroundColor='#ffffff';
          document.getElementById('vDescription_pk_pd3_asc_'+iAspekId+'_20').style.backgroundColor='#ffffff';

          document.getElementById('vDescription_pk_pd3_asc_'+iAspekId+'_'+point).style.backgroundColor = color;

          $('#img_".$this->url."_nNilai_'+iAspekId).hide();
          $('#detail_".$this->url."_hitung_'+iAspekId).hide();
          $('#link_".$this->url."_hitung_'+iAspekId).show();
          $('#link_".$this->url."_hitung_'+iAspekId).html(value);
          $('#detail_".$this->url."_hitung_'+iAspekId).show();
          

          //=====================================

          
          var nilai  = (parseFloat(point) * parseFloat(bobot))/100;

          $('#".$this->url."_nNilai_'+iAspekId+'').val(nilai.toFixed(2));
          $('#".$this->url."_groupnilai_'+iAspekId+'').val(nilai.toFixed(2));
          $('#".$this->url."_tmpPilih_'+iAspekId+'').val(point);
          $('#lable_".$this->url."_nNilai_'+iAspekId+'').html(nilai.toFixed(2));
          $('#".$this->url."_ySource_'+iAspekId+'').val(value);
          $('#".$this->url."_nPointSepakat_'+iAspekId+'').val(point);
          $('#lable_".$this->url."_nPointSepakat_'+iAspekId+'').html(point);
          $('#".$this->url."_tmpAybs_'+iAspekId+'').val(point);

          var iMsGroupAspekId = $('.".$this->url."_iMsGroupAspekIdNya_'+iAspekId+'').val();
          sum_".$this->url."(iMsGroupAspekId);

          if (action!='view'){
             simpanPointDetail(iMsGroupAspekId);
          }
         

          //=====================================

          if (tampil==2){
            //browse('".$urlDetail."&html='+html,'Detail Point')
            $('#detailPointPk').html(html);
            $('#detailPointPk').dialog({
              title : 'Detail Point',
              modal : true,
              show: 'slide',
              hide: 'slide',
              closeOnEscape: true,
              width: 'auto',
              minHeight: 0,
              create: function() {
                  $(this).css('maxHeight', 400);   
              },
              buttons: {
                'Close': function () {
                  $('#detailPointPk').dialog('close');
                }
              }
            });
          }

      }

      function ".$this->url."_getValuePk(vFunctionLink,iAspekId){

        var nip = $('#pk_pd3_asc_cNip').val();
        var dPeriode1 = $('#pk_pd3_asc_dPeriode1').val();
        var dPeriode2 = $('#pk_pd3_asc_dPeriode2').val();
        return $.ajax({
            type: 'POST', 
            url: '".$urlgetValuePk."',
            data: '_vFunctionLink='+vFunctionLink+'&_iAspekId='+iAspekId+'&_cNipNya='+nip+'&_dPeriode1='+dPeriode1+'&_dPeriode2='+dPeriode2,
            async:false
        }).responseText
      }


      function ".$this->url."_input_supoortData(iAspekId,iPkTransId){
     
        browse('".$urlSD."&iAspekId='+iAspekId+'&iPkTransId='+iPkTransId+'&getaction=".$this->input->get('action')."','Support Data');
      }

     </script>";    

      return $html;
  }

  function generateHasilAkhir($iPkTransId,$cNip,$rowData){
    $action = $this->input->get('action');
    $nipLogin    =  $this->sess_auth->gNIP;
    $aybs        = $this->lib_utilitas->getSingleAybs($cNip);
    $cNipNya = $rowData['cNip'];
    $listaybs =  $this->lib_utilitas->getAybs($cNipNya,$tmpNip=array());

    $manager = $listaybs;
    $iStatus     = $rowData['iStatus'];
    $html = '<table cellspacing="0" cellpadding="3">
              <thead>
                <tr style="width: 60%; border: 1px solid #f86609; background: #d79a20; border-collapse: collapse">
                  <th  style="border: 1px solid #dddddd;">ASPEK PENILAIAN</th>
                  <th  style="border: 1px solid #dddddd;">BOBOT</th>
                  <th  style="border: 1px solid #dddddd;">NILAI AKHIR TIAP ASPEK</th>
                  <th  style="border: 1px solid #dddddd;">NILAI X BOBOT</th>
                  
                </tr>

                

                </thead>

                <tbody>';
    $sql = "SELECT a.iMsGroupAspek,a.nResult,a.nBobot,a.nNilai,
            (SELECT vDescription FROM hrd.pk_msgroup_aspek WHERE id=a.iMsGroupAspek ) AS vDescription 
            FROM hrd.pk_pkresult AS a WHERE a.iPkTransId='".$iPkTransId."'
            ORDER BY a.iMsGroupAspek ASC";
    $query = $this->db_erp_pk->query($sql);
    $jumlah = 0;
      if ($query->num_rows() > 0) {
        $result = $query->result_array();
        foreach($result as $row) {
          $jumlah = $jumlah + $row['nNilai'];
          $html .= ' <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td style="width:50%;border: 1px solid #dddddd" > 
                           '.$row['vDescription'].'
                        </td>

                        <td  style="width:10%;border: 1px solid #dddddd;text-align:center;" > 
                           '.number_format($row['nBobot'],2).'%
                        </td>

                        <td style="width:20%;border: 1px solid #dddddd;text-align:center;" > 
                           '.number_format($row['nResult'],2).'
                        </td>

                        <td style="width:20%;border: 1px solid #dddddd;text-align:center;" > 
                           '.number_format($row['nNilai'],2).'
                        </td>
                      </tr>';

        }
      }

       $html .= ' <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td colspan="3" style="width:50%;border: 1px solid #dddddd;text-align:center;" > 
                            <b>JUMLAH</b>
                        </td>
                        <td style="width:20%;border: 1px solid #dddddd;text-align:center;" > 
                           <b>'.number_format($jumlah,2).'</b>
                           <input type="hidden" id="'.$this->url.'_nFinal" name="'.$this->url.'_nFinal" value="'.$jumlah.'" />
                        </td>
                      </tr>';

       $html .= ' <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td colspan="3" style="width:50%;border: 1px solid #dddddd;text-align:center;" > 
                            <b>KATEGORI PENILAIAN</b>
                        </td>
                        <td style="width:20%;border: 1px solid #dddddd;text-align:center;" > 
                           <b>'.$this->lib_utilitas->getKateGoriPk(number_format($jumlah,2)).'</b>
                        </td>
                      </tr>';
      $html .= "</body></table>";

     $html .= '<br /><table cellspacing="0" cellpadding="3">
              <thead>
                <tr style="border: 1px solid #f86609; background: #d79a20; border-collapse: collapse">
                  <th colspan="2" style="border: 1px solid #dddddd;">KATEGORI PENILAIAN</th>
                </tr>
                </thead>

                <tbody>';
      $sql = "SELECT * FROM hrd.pk_kategori";
      $query = $this->db_erp_pk->query($sql);
      if ($query->num_rows() > 0) {
        $result = $query->result_array();
        foreach($result as $row) {
          $html .= ' <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td style="border: 1px solid #dddddd" > 
                           '.$row['vKeterangan'].'
                        </td>

                        <td  style="border: 1px solid #dddddd;text-align:center;" > 
                           '.number_format($row['iNilai1']).' - '.number_format($row['iNilai2']).'
                        </td>

                       

                        
                      </tr>';
        }
      }
      $html .= "</tbody></table>";


      $sql = "SELECT * FROM hrd.pk_trans WHERE id='".$iPkTransId."'";
      $query = $this->db_erp_pk->query($sql);
      if ($query->num_rows() > 0) {
          $row = $query->row();
          
      }



      $ybs  = $cNip;
      $aybs = $this->lib_utilitas->getSingleAybs($cNip);


      if($nipLogin == $ybs){
        $readybs = '';
        $disybs = '';
      }else{
        $readybs = 'readonly="true"';
        $disybs = 'disabled="true"';
      }

      $html .= '<br /><table cellspacing="0" cellpadding="3" style="width:100%" >
              <thead>
                <tr style="border: 1px solid #f86609; background: #d79a20; border-collapse: collapse">
                  <th colspan="2" style="border: 1px solid #dddddd;">CATATAN UNTUK KARYAWAN</th>
                </tr>
                </thead>

                <tbody>
                <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td style="border: 1px solid #dddddd" > 
                          Komentar/evaluasi Umum
                          <br />
                          <textarea '.$readybs.' style="width:98%;" id="'.$this->url.'_vEvaKry" name="'.$this->url.'_vEvaKry" >'.$row->vEvaKry.'</textarea>

                         

                        </td>
                 </tr>

                 <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td style="border: 1px solid #dddddd" > 
                          Rencana untuk periode yang akan datang
                          <br />
                           <textarea '.$readybs.' style="width:98%;" id="'.$this->url.'_vRencana" name="'.$this->url.'_vRencana" >'.$row->vRencana.'</textarea>

                        </td>
                 </tr>

                </tbody>
                </table>';


      if($nipLogin == $aybs){
        $readatas = '';
        $disatas = '';
      }else{
        $readatas = 'readonly="true"';
        $disatas = 'disabled="true"';
      }


      $html .= '<br /><table cellspacing="0" cellpadding="3" style="width:100%" >
              <thead>
                <tr style="border: 1px solid #f86609; background: #d79a20; border-collapse: collapse">
                  <th colspan="2" style="border: 1px solid #dddddd;">CATATAN UNTUK ATASAN</th>
                </tr>
                </thead>

                <tbody>
                <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td style="border: 1px solid #dddddd" > 
                          Evaluasi Umum
                          <br />
                           <textarea '.$readatas.' style="width:98%;" id="'.$this->url.'_vEvaAtasan" name="'.$this->url.'_vEvaAtasan" >'.$row->vEvaAtasan.'</textarea>

                         

                        </td>
                 </tr>

                 <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td style="border: 1px solid #dddddd" > 
                          Saran/Perbaikan
                          <br />
                           <textarea '.$readatas.' style="width:98%;" id="'.$this->url.'_vSaranAtasan" name="'.$this->url.'_vSaranAtasan" >'.$row->vSaranAtasan.'</textarea>

                        </td>
                 </tr>

                 <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td style="border: 1px solid #dddddd" > 
                          Pelatihan yang diusulkan
                          <br />
                           <textarea '.$readatas.' style="width:98%;" id="'.$this->url.'_vPelatihan" name="'.$this->url.'_vPelatihan" >'.$row->vPelatihan.'</textarea>

                        </td>
                 </tr>

                </tbody>
                </table>';

             $html .= '<br /><table cellspacing="0" cellpadding="3" style="width:100%" >
              <thead>
                <tr style="border: 1px solid #f86609; background: #d79a20; border-collapse: collapse">
                  <th colspan="2" style="border: 1px solid #dddddd;"></th>
                </tr>
                </thead>

                <tbody>
                <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td width="25%" rowspan="2" style="border: 1px solid #dddddd" > 
                          Rencana Karir Yang Akan Datang </br>
                          ';
                          $arr_iRencana = array(1=>'Demosi',2=>'Rotasi',3=>'Mutasi',4=>'Promosi',5=>'Belum dapat ditentukan');
                          foreach ($arr_iRencana as $key => $value) {
                            if ($row->iRencana==$key){
                              $sel = 'checked="checked"';
                            }else{
                              $sel = '';
                            }
                            $html .=' <input '.$disatas.' '.$sel.' type="radio" id="'.$this->url.'_iRencana" name="'.$this->url.'_iRencana" value="'.$key.'" />'.$value.'<br />';
                          }
                           
                           
                       $html .=' </td>
                         <td style="border: 1px solid #dddddd" > 
                          Ke </br>
                          Divisi : ';


                          $sql = "Select iDivID, vDescription as vDescription from msdivision where ldeleted = 0 order by vDescription ASC";

                          $html  .= "<select ".$disatas." name='".$this->url."_iDivIdTo' id='".$this->url."_iDivIdTo'>";
                          $html  .= "<option value='0'>Pilih</option>";
                          $query = $this->db_erp_pk->query($sql);
                          if ($query->num_rows() > 0) {
                                    $result = $query->result_array();
                                    foreach($result as $r) {
                                        if ($r['iDivID']==$row->iDivIdTo){
                                          $sel = 'selected';
                                        }else{
                                          $sel = '';
                                        }
                                           $html .= "<option {$sel} value='".$r['iDivID']."'>".$r['vDescription']."</option>";
                                    }
                                } 
                            
                                $html .= "</select>";

                          $url2 = base_url().'processor/personalia/perso/master/employeet?action=searchJbt&company_id='.$this->input->get('company_id').'&modul_id=34&group_id=2368';


                          $html .='  </br></br>
                          Posisi : ';
                          $sql = "SELECT a.iPostId,a.vDescription,a.iGrpDivId 
                                  FROM hrd.position AS a
                                  WHERE a.iGrpDivId=(SELECT iGrpDivId FROM hrd.msdivision WHERE iDivId='".$row->iDivIdTo."') AND a.lDeleted=0
                                  ORDER BY a.vDescription ASC";

                          $html  .= "<select ".$disatas." name='".$this->url."_iPostIdTo' id='".$this->url."_iPostIdTo'>";
                          $html  .= "<option value='0'>Pilih</option>";
                           $query = $this->db_erp_pk->query($sql);
                          if ($query->num_rows() > 0) {
                              $result = $query->result_array();
                              foreach($result as $r) {
                                  if ($r['iPostId']==$row->iPostIdTo){
                                    $sel = 'selected';
                                  }else{
                                    $sel = '';
                                  }
                                     $html .= "<option {$sel} value='".$r['iPostId']."'>".$r['vDescription']."</option>";
                              }
                          } 

                          $html .= "</select>";

                        $html .='</td>


                 </tr>

                 <tr style="border: 1px solid #dddddd; border-collapse: collapse;">
                        <td style="border: 1px solid #dddddd" > 
                          Pertimbangan</br>
                           <textarea '.$disatas.' style="width:98%;" id="'.$this->url.'_vPertimbangan" name="'.$this->url.'_vPertimbangan" >'.$row->vPertimbangan.'</textarea>
                        </td>

                         
                 </tr>

                 

                </tbody>
                </table>

                </br >
                <center>';

                $tombol = '<a href="javascript:void(0);" onclick="simpanHasilAkhir('.$iPkTransId.')" class="icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" style="background: #eae978;">Simpan Hasil Akhir</a>';

                if ($action=='view'){
                    $tombol = '';
                }

                if (($iStatus==1 || $iStatus==2 || $iStatus==3 ) &&  in_array($nipLogin, $manager)){
                  $html .= $tombol;
                }else if ($iStatus==0 /*&& $nipLogin==$cNip*/){
                  $html .= $tombol;
                }

                $html .= '</center>

                ';

    $urlHasil = base_url().'processor/pk/pk/pd3/asc?action=SaveHasil';
    $rUrl = base_url()."processor/pk/pk/pd3/asc?company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id');

    $html .= "<script>
                function simpanHasilAkhir(iPkTransId){
                 
                  $.ajax({
                     type: 'POST',
                     url: '".$urlHasil."',
                     data: $('#form_update_".$this->url."').serialize()+'&_iPkTransId='+iPkTransId,
                     success: function(data)
                     {
                         custom_alert(data);
                         $.get('".$rUrl."&action=update&id='+iPkTransId, function(data) {
                             $('div#form_".$this->url."').html(data);
                                               
                          });
                     }
                   });
                }
                $(document).ready(function() {  
                  $('#pk_pd3_asc_iDivIdTo').change(function() {
                      groupdeptid = getGroupDeptId($(this).val());
                      loadDataJbt('pk_pd3_asc_iPostIdTo', groupdeptid, groupdeptid);

                  });
                });


                function getGroupDeptId(deptId) {
                    return $.ajax({
                            type: 'POST',
                            url: '".base_url()."processor/personalia/perso/master/employeet?action=getGroupDept',
                            data: '_param='+deptId, 
                            async: false                      
                    }).responseText
                }

                function loadDataJbt(control, param, tipe) {
                        $.get('".$url2."', 
                        {_control:control, _param:param, _tipe:tipe},  function(data) {
                                if (data.error == undefined) {
                                        $('#'+control).empty();
                                        $('#'+control).append('<option value=\'0\'>[Pilih]</option>');
                                        for (var x=0;x<data.length;x++) {           
                                                $('#'+control).append($('<option></option>').val(data[x].id).text(data[x].value));  
                                        }
                                } else {
                                        //alert('Data Error');
                                        return false;
                                }

                        },'json');
                }


              </script>";

    return $html;
    
  }

  public function output(){
    $this->index($this->input->get('action'));
  }


  function searchEmployee() {
    
    $term = $this->input->get('term');    
    $data = array();
    
    $sql = "SELECT a.cNip, a.vName as nama 
        FROM employee a
        WHERE a.cNip like '%".$term."%' or a.vName like '%".$term."%'";
    $query = $this->db_erp_pk->query($sql);
    if ($query->num_rows > 0) {     
      foreach($query->result_array() as $line) {
        
        $row_array['value'] = trim($line['cNip'])." - ".$line['nama'];
        $row_array['id'] = trim($line['cNip']);
        
        array_push($data, $row_array);
      }
    }
    
    echo json_encode($data);
    exit;
  }



  public function searchcNip() {
    $tgl    = date('Y-m-d');
    $term     = $this->input->get('term');
    $iCompanyId = $this->sess_auth->gComId;   
    $data = array();
    $divGa = $this->lib_utilitas->getSysParam('DIV_PK_PD3_ASC_CLINISINDO');
    $jabatan  =  $this->lib_utilitas->getSysParam("JABATAN_PK_PD3_ASC_CLINISINDO");

    //$sql = "select cNip, vName from hrd.employee where (cNip like '%{$term}%') limit 1 ";
    $sql = "SELECT a.cNip,a.vName,a.dRealIn,a.iPostId,
        (SELECT vDescription FROM hrd.msdivision WHERE iDivID=a.iDivisionID) AS divisi,
        (SELECT vDescription FROM hrd.msdepartement WHERE iDeptID=a.iDepartementId) AS departement,
        (SELECT vDescription FROM hrd.bagian WHERE ibagid=a.ibagid) AS bagian,
        (SELECT vAreaname FROM hrd.area WHERE iAreaID=a.iArea) AS vAreaname,
        (SELECT vDescription FROM hrd.position WHERE iPostId=a.iPostId) AS jabatan,
        (SELECT c.vDescription FROM hrd.position AS b LEFT JOIN hrd.lvlemp AS c ON c.iLvlEmp=b.iLvlID 
          WHERE b.iPostId=a.iPostID) AS lvlemply
        

        FROM hrd.employee AS a WHERE a.cEmpStat='T' AND a.dResign='0000-00-00'
        AND a.iCompanyId !=1 and a.iPostId in (".$jabatan.") AND  a.iDivisionID in (".$divGa.") and
        (a.cNip LIKE '%{$term}%' OR a.vName LIKE '%{$term}%') limit 50";
    //echo $sql;exit; 
  
    $query = $this->db_erp_pk->query($sql);
    if ($query->num_rows > 0) {     
      foreach($query->result_array() as $line) {

        $now = date('Y-m-d');

        $d1 = new DateTime($line['dRealIn']);
        $d2 = new DateTime($now);
        $interval = $d2->diff($d1);
        $masakerja = $interval->format('%y Tahun, %m Bulan');

        $row_array['id']          = trim($line['cNip']);
        $row_array['value']       = trim($line['cNip']).' - '.trim($line['vName']);
        $row_array['divisi']      = trim($line['divisi']);
        $row_array['vAreaname']   = trim($line['vAreaname']);
        $row_array['jabatan']     = trim($line['jabatan']);
        $row_array['departement'] = trim($line['departement']);
        $row_array['bagian']      = trim($line['bagian']);
        $row_array['lvlemply']    = trim($line['lvlemply']);
        $row_array['dRealIn']     = trim(date('d-m-Y',strtotime($line['dRealIn'])));
        $row_array['masakerja']     = trim($masakerja);
        $row_array['iPostId']     = trim($line['iPostId']);
        
        array_push($data, $row_array);
      }
    }
    
    echo json_encode($data);
    exit; 
  }


  function getDetail(){
      $iSkemaId = $_POST['_iSkemaId'];
      $sql = "SELECT a.iMsGroupAspekId,a.nBobot,
              (select vDescription FROM hrd.pk_msgroup_aspek WHERE id=a.iMsGroupAspekId) as vDescription
              FROM hrd.pk_group_aspek as a WHERE a.iSkemaId='".$iSkemaId."' and a.lDeleted=0";
      
      $html = '<table id="table_approval_<?=$this->url?>" cellspacing="0" cellpadding="3" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
                    <thead>
                      <tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
                      
                      <th style="border: 1px solid #dddddd;">ASPEK PENILAIAN</th>
                      <th style="border: 1px solid #dddddd;">BOBOT</th>
                      <th style="border: 1px solid #dddddd;">NILAI AKHIR TIAP ASPEK</th>
                      <th style="border: 1px solid #dddddd;">NILAI X BOBOT</th>   
                    </tr>
                    </thead>
                    <tbody>';

      $query = $this->db_erp_pk->query($sql);
      if ($query->num_rows > 0) {     
        foreach($query->result_array() as $line) {
           $html .= '<tr style="width: 100%; border: 1px solid #dddddd;  border-collapse: collapse" >
                  
                  <td style="border: 1px solid #dddddd;">'.$line['vDescription'].'</td>
                  <td style="border: 1px solid #dddddd;">'.$line['nBobot'].' %</td>
                  <td style="border: 1px solid #dddddd;">
                     <input type="hidden" id="'.$this->url.'_nBobot" name="'.$this->url.'_nBobot[]" class="'.$this->url.'_nBobot" value="'.$line['nBobot'].'" />

                     <input type="hidden" id="'.$this->url.'_iMsGroupAspek" name="'.$this->url.'_iMsGroupAspek[]" value="'.$line['iMsGroupAspekId'].'" />

                     <input type="text" id="'.$this->url.'_nResult" name="'.$this->url.'_nResult[]" class="'.$this->url.'_nResult auto" size="5" />
                  </td>
                  <td style="border: 1px solid #dddddd;">
                    <span id="nama_'.$this->url.'_nNilai" 
                      class="nama_'.$this->url.'_nNilai" 
                      name="nama_'.$this->url.'_nNilai[]"
                    >0.00</span>

                     <input type="hidden" id="'.$this->url.'_nNilai" name="'.$this->url.'_nNilai[]" size="5" class="'.$this->url.'_nNilai" />
                  </td>
                  
              </tr>';

        }
      }

       $html .= " 
              </tbody>
              <tfoot>
                  <tr style='width: 100%; border: 1px solid #dddddd;  border-collapse: collapse' >
                    <td colspan='4' style='border: 1px solid #dddddd;'>
                       
                    </td>
                    
                  </tr>

                  <tr style='width: 100%; border: 1px solid #dddddd;  border-collapse: collapse' >
                    <td colspan='3' style='border: 1px solid #dddddd;'><b>JUMLAH</b></td>
                    <td style='border: 1px solid #dddddd;'>
                      <b><span id='".$this->url."_jumlah' ></span></b>
                      <input type='hidden' id='".$this->url."_nFinal' name='".$this->url."_nFinal'  />
                    </td>
                  </tr>

                  <tr style='width: 100%; border: 1px solid #dddddd;  border-collapse: collapse' >
                    <td colspan='3' style='border: 1px solid #dddddd;'><b>KATEGORI PENILAIAN</b></td>
                    <td style='border: 1px solid #dddddd;'></td>
                  </tr>


              </tfoot>
              </table>
            </div>";

      $html .= "<script>
                  $(document).ready(function() {
                    
                    $('.pk_pd3_asc_nResult').autoNumeric('init', {vMin:'0', vMax:'100.00'});
                  });


                  $('.pk_pd3_asc_nResult').live('keyup', function() {            
                    var ix = $('.pk_pd3_asc_nResult').index($(this));
                    
                    var sisa_sblm   = 0;
                    var result  = $('.pk_pd3_asc_nResult').eq(ix).val();
                    var bobot   = $('.pk_pd3_asc_nBobot').eq(ix).val();
                    var nilai   = parseFloat((result * bobot) / 100);

                    $('.pk_pd3_asc_nNilai').eq(ix).val(nilai.toFixed(2));
                    $('.nama_pk_pd3_asc_nNilai').eq(ix).html(nilai.toFixed(2));
                    
                    sum_".$this->url."();
                  
                  });

                  function sum_".$this->url."(){
                    var i     = 0;
                    var total     = 0;

                    $('.pk_pd3_asc_nResult').each(function() {
                      if ($('.pk_pd3_asc_nResult').eq(i).val() != '') {        
                        total += parseFloat($('.pk_pd3_asc_nNilai').eq(i).val());
                        
                      }

                      i++;
                    });

                   

                    $('#pk_pd3_asc_jumlah').html(total.toFixed(2));
                    $('#pk_pd3_asc_nFinal').val(total.toFixed(2));

                  }  
              </script>";
                  
      echo $html;

    }


    function getDetailOnEdit($iPkTransId,$action){
      
      $sql = "SELECT a.iMsGroupAspek,
(SELECT vDescription FROM hrd.pk_msgroup_aspek WHERE id=a.iMsGroupAspek) AS vDescription,
a.nResult,a.nBobot,a.nNilai
FROM hrd.pk_pkresult AS a WHERE a.iPkTransId='".$iPkTransId."' ";
      
      $html = '<table id="table_approval_<?=$this->url?>" cellspacing="0" cellpadding="3" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
                    <thead>
                      <tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
                      
                      <th style="border: 1px solid #dddddd;">ASPEK PENILAIAN</th>
                      <th style="border: 1px solid #dddddd;">BOBOT</th>
                      <th style="border: 1px solid #dddddd;">NILAI AKHIR TIAP ASPEK</th>
                      <th style="border: 1px solid #dddddd;">NILAI X BOBOT</th>   
                    </tr>
                    </thead>
                    <tbody>';

      $nFinal = 0;
      $query = $this->db_erp_pk->query($sql);
      if ($query->num_rows > 0) {     
        foreach($query->result_array() as $line) {
          $nFinal = $nFinal + $line['nNilai'];
           $html .= '<tr style="width: 100%; border: 1px solid #dddddd;  border-collapse: collapse" >
                  
                  <td style="border: 1px solid #dddddd;">'.$line['vDescription'].'</td>
                  <td style="border: 1px solid #dddddd;">'.$line['nBobot'].' %</td>
                  <td style="border: 1px solid #dddddd;">
                     <input type="hidden" id="'.$this->url.'_nBobot" name="'.$this->url.'_nBobot[]" class="'.$this->url.'_nBobot" value="'.$line['nBobot'].'" />

                     <input type="hidden" id="'.$this->url.'_iMsGroupAspek" name="'.$this->url.'_iMsGroupAspek[]" value="'.$line['iMsGroupAspek'].'" />

                     ';

                     if ($action =='view'){
                       $html .= '<span>'.$line['nResult'].'</span>';
                     }else{
                       $html .= '<input type="text" id="'.$this->url.'_nResult" name="'.$this->url.'_nResult[]" class="'.$this->url.'_nResult auto" size="5" value="'.$line['nResult'].'" />';
                     }

                    
                     


                 $html .= '</td>
                  <td style="border: 1px solid #dddddd;">
                    <span id="nama_'.$this->url.'_nNilai" 
                      class="nama_'.$this->url.'_nNilai" 
                      name="nama_'.$this->url.'_nNilai[]"
                    >'.$line['nNilai'].'</span>


                     <input type="hidden" id="'.$this->url.'_nNilai" name="'.$this->url.'_nNilai[]" size="5" class="'.$this->url.'_nNilai" value="'.$line['nNilai'].'" />
                  </td>
                  
              </tr>';

        }
      }

        $sql = 'SELECT vKeterangan FROM hrd.rs_pk_kategori WHERE '.$nFinal.' 
              BETWEEN iNilai1 AND iNilai2';
        $kat = '-';
        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $kat = $row->vKeterangan;
            
        }      

       $html .= " 
              </tbody>
              <tfoot>
                  <tr style='width: 100%; border: 1px solid #dddddd;  border-collapse: collapse' >
                    <td colspan='4' style='border: 1px solid #dddddd;'>
                       
                    </td>
                    
                  </tr>

                  <tr style='width: 100%; border: 1px solid #dddddd;  border-collapse: collapse' >
                    <td colspan='3' style='border: 1px solid #dddddd;'><b>JUMLAH</b></td>
                    <td style='border: 1px solid #dddddd;'>
                      <b><span id='".$this->url."_jumlah' >".number_format($nFinal,2)."</span></b>
                      <input type='hidden' id='".$this->url."_nFinal' name='".$this->url."_nFinal' value='".number_format($nFinal,2)."'  />
                    </td>
                  </tr>

                  <tr style='width: 100%; border: 1px solid #dddddd;  border-collapse: collapse' >
                    <td colspan='3' style='border: 1px solid #dddddd;'><b>KATEGORI PENILAIAN</b></td>
                    <td style='border: 1px solid #dddddd;'><b>".$kat."</b></td>
                  </tr>


              </tfoot>
              </table>
            ";

      $html .= "<script>
                  $(document).ready(function() {
                    
                    $('.pk_pd3_asc_nResult').autoNumeric('init', {vMin:'0', vMax:'100.00'});
                  });


                  $('.pk_pd3_asc_nResult').live('keyup', function() {            
                    var ix = $('.pk_pd3_asc_nResult').index($(this));
                    
                    var sisa_sblm   = 0;
                    var result  = $('.pk_pd3_asc_nResult').eq(ix).val();
                    var bobot   = $('.pk_pd3_asc_nBobot').eq(ix).val();
                    var nilai   = parseFloat((result * bobot) / 100);

                    $('.pk_pd3_asc_nNilai').eq(ix).val(nilai.toFixed(2));
                    $('.nama_pk_pd3_asc_nNilai').eq(ix).html(nilai.toFixed(2));
                    
                    sum_".$this->url."();
                  
                  });

                  function sum_".$this->url."(){
                    var i     = 0;
                    var total     = 0;

                    $('.pk_pd3_asc_nResult').each(function() {
                      if ($('.pk_pd3_asc_nResult').eq(i).val() != '') {        
                        total += parseFloat($('.pk_pd3_asc_nNilai').eq(i).val());
                        
                      }

                      i++;
                    });

                   

                    $('#pk_pd3_asc_jumlah').html(total.toFixed(2));
                    $('#pk_pd3_asc_nFinal').val(total.toFixed(2));

                  }  
              </script>";
                  
      return $html;

    }

    function getValuePk(){
      $vFunctionLink = $_POST['_vFunctionLink'];
      $this->lib_pk_pd3_asc->$vFunctionLink($_POST);
    }

}
