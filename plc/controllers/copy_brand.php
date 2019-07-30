<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class copy_brand extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('lib_plc');
        $this->modul_id = $this->input->get('modul_id');
        $this->iModul_id = $this->lib_plc->getIModulID($this->input->get('modul_id'));
        $this->db = $this->load->database('hrd',false, true);
        $this->load->library('auth');
        $this->user = $this->auth->user();
        $this->team = $this->lib_plc->hasTeam($this->user->gNIP);
        $this->teamID = $this->lib_plc->hasTeamID($this->user->gNIP);
        $isAdmin=$this->lib_plc->isAdmin($this->user->gNIP);
        $this->isAdmin = $isAdmin;
        $this->main_table='plc2_upb';
        $this->main_table_pk='iupb_id';

        $this->load->library('auth_localnon');


        $this->title = 'Copy Brand';
        $this->url = 'copy_brand';
        $this->urlpath = 'plc/'.str_replace("_","/", $this->url);

        $this->maintable = 'plc2.plc2_upb';  
        $datagrid['islist'] = array(
                                        'vupb_nomor' => array('label'=>'No UPB','width'=>75,'align'=>'center','search'=>true)
                                        ,'vupb_nama' => array('label'=>'Nama UPB','width'=>300,'align'=>'left','search'=>true)
                                        ,'iupb_id_ref' => array('label'=>'Referensi UPB','width'=>100,'align'=>'center','search'=>true)
                                        ,'ttanggal' => array('label'=>'Tanggal UPB','width'=>100,'align'=>'center','search'=>false)
                                        ,'vgenerik' => array('label'=>'Nama Generik','width'=>300,'align'=>'left','search'=>true)
                                        ,'ikategori_id' => array('label'=>'Kategori Produk','width'=>100,'align'=>'center','search'=>true)
                                        ,'ikategoriupb_id' => array('label'=>'Kategori UPB','width'=>100,'align'=>'center','search'=>true)
                                        ,'isediaan_id' => array('label'=>'Sediaan Produk','width'=>150,'align'=>'center','search'=>true)
                                    );
        $datagrid['shortBy']=array('iupb_id'=>'Desc');

        

        $datagrid['setQuery']=array(
                                0=>array('vall'=>'plc2_upb.ldeleted','nilai'=>0),
                                1=>array('vall'=>'plc2_upb.iupb_id_ref != 0','nilai'=> NULL),
                                2=>array('vall'=>'plc2_upb.iCopy_brand','nilai'=>1)
                                
                                );

        $datagrid['jointableinner']=array(
                                    #0=>array('plc2.plc2_upb_formula'=>'plc2_upb_formula.ifor_id=mikro_fg.ifor_id')
                                    #0=>array('plc2.plc2_upb'=>'plc2.plc2_upb.iupb_id = plc2.plc2_upb.iupb_id')
                                );
        


        $this->datagrid=$datagrid;
    }

    function index($action = '') {
        $grid = new Grid;       
        $grid->setTitle($this->title);      
        $grid->setTable($this->maintable );
        $grid->setUrl($this->url);
        $grid->setGroupBy($this->setGroupBy);
        /*Untuk Field*/
        $grid->addFields('form_detail');
        foreach ($this->datagrid as $kv => $vv) {
            /*Untuk List*/
            if($kv=='islist'){
                foreach ($vv as $list => $vlist) {
                    $grid->addList($list);
                    foreach ($vlist as $kdis => $vdis) {
                        if($kdis=='label'){
                            $grid->setLabel($list, $vdis);
                        }
                        if($kdis=='width'){
                            $grid->setWidth($list, $vdis);
                        }
                        if($kdis=='align'){
                            $grid->setAlign($list, $vdis);
                        }
                        if($kdis=='search' && $vdis==true){
                            $grid->setSearch($list);
                        }
                    }
                }
            }

            /*Untuk Short List*/
            if($kv=='shortBy'){
                foreach ($vv as $list => $vlist) {
                    $grid->setSortBy($list);
                    $grid->setSortOrder($vlist);
                }
            }

            if($kv=='inputGet'){
                foreach ($vv as $list => $vlist) {
                    $grid->setInputGet($list,$vlist);
                }
            }

            if($kv=='jointableinner'){
                foreach ($vv as $list => $vlist) {
                    foreach ($vlist as $tbjoin => $onjoin) {
                        $grid->setJoinTable($tbjoin, $onjoin, 'inner');
                    }
                }
            }
            if($kv=='setQuery'){
                foreach ($vv as $kv => $vlist) {
                    $grid->setQuery($vlist['vall'], $vlist['nilai']);


                    
                }

                if($this->isAdmin){

                }else{
                   $grid->setQuery('plc2_upb.iteambusdev_id in ('.$this->teamID.')', NULL);                        
                }
            }

        }

        $grid->setRelation('ikategoriupb_id','plc2.plc2_upb_master_kategori_upb','ikategori_id','vkategori','upb_kat','inner',array('ldeleted'=>0),array('upb_kat'=>'asc'));
        $grid->setRelation('ikategori_id','hrd.mnf_kategori','ikategori_id','vkategori','mnf_kat','inner',array('ldeleted'=>0),array('mnf_kat'=>'asc'));
        $grid->setRelation('isediaan_id','hrd.mnf_sediaan','isediaan_id','vsediaan','','inner',array('ldeleted'=>0),array('vsediaan'=>'asc'));

        $grid->changeFieldType('iapppd','combobox','',array(0=>'Waiting Approval', 1=>'Rejected', 2=>'Approved'));
        $grid->changeFieldType('iSubmit','combobox','',array(0=>'Draft - Need to be Submitted', 1=>'Submitted'));
        $grid->changeFieldType('iTujuan_req','combobox','',array(1=>'Untuk Sample', 2=>'Untuk Pilot'));

        
        $grid->setGridView('grid');

        switch ($action) {
            case 'json':
                $grid->getJsonData();
                break;  
            case 'create':
                $grid->render_form();
                break;
            case 'createprosesz':
                echo $this->prosesKopi();
                break;
            case 'getRefreshDoc':
                $this->refreshDoc(1);
                break;
            case 'getRefreshDoc2':
                $this->refreshDoc(2);
                break;
            case 'getProsesKopixx':
                 $sql ='
                    select * 
                    from plc2.sys_masterdok a
                    join plc2.sys_detaildok b on b.idmasterdok=a.idmasterdok
                    join plc3.m_modul_fileds c on c.iM_modul_fileds=a.iM_modul_fileds
                    join plc3.m_modul d on d.iM_modul = c.iM_modul
                    join plc3.m_flow_proses e on e.iM_modul=d.iM_modul and e.iM_flow=d.iM_flow
                    where a.ldeleted=0
                    and b.ldeleted=0
                    and d.lDeleted=0
                    and e.lDeleted=0
                    and b.ijenisdok=1
                    and b.jenisplc=1
                    and d.iM_modul= 3
                    order by e.iUrut ASC 
                    limit 1
            ';
            
                $clone = $this->db->query($sql)->row_array();
                $idHeader_new = 367;
                $idHeader_ref = 352;
                echo $this->kopiFile($clone,$idHeader_ref,$idHeader_new);
                break;
            case 'getProsesKopi':
                echo $this->getProsesKopi();
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

            case 'getrekKe':
                echo $this->getrekKe();
                break;
            case 'getDetail':
                echo $this->getDetail();
                break;

            case 'cekCurrentPost':
                echo $this->cekCurrentPost();
                break;
            /*Option Case*/
            case 'getFormDetail':
                echo $this->getFormDetail();
                break;

            default:
                $grid->render_grid();
                break;
        }
    }

    function refreshDocBack($regorprareg){

        $sqlGetUPBMother = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$_POST['iupb_id'].'" ';
        $dUpebeh = $this->db_plc0->query($sqlGetUPBMother)->row_array();
        

        /* v3_cek_dokumen_prareg_iupb_id	[…]
            0	3242
            1	3242
            isdraft	[…]
            0	
            1	
            ifile_fileCoaRS[]	753
            ifile_fileCoaWS[]	754
            ifile_fileProtUDT[]	755
            ifile_fileProtStabilita[]	756
            ifile_fileuploadspek[]	750
            ifile_fileDraftCoafg[]	757
            v3_cek_dokumen_prareg_fileBahanKemasPrimer_ijenis_bk_id[748][]	1
            ifile_fileBahanKemasPrimer[]	748
            ifile_fileSOIBahanBaku[]	749
            ifile_filesoifg[]	751
            ifile_fileprotokolValpro[]	752
            iupb_id	3242 
        */

        


        $sql ='
            select * 
            from plc2.sys_masterdok a
            join plc2.sys_detaildok b on b.idmasterdok=a.idmasterdok
            join plc3.m_modul_fileds c on c.iM_modul_fileds=a.iM_modul_fileds
            join plc3.m_modul d on d.iM_modul = c.iM_modul
            join plc3.m_flow_proses e on e.iM_modul=d.iM_modul and e.iM_flow=d.iM_flow
            where a.ldeleted=0
            and b.ldeleted=0
            and d.lDeleted=0
            and e.lDeleted=0
            and d.iM_modul = 48
            
            ';
            if($regorprareg == 2){
                $sql .='and b.ijenisdok in(2)';
            }else{
                $sql .='and b.ijenisdok in(1)';
            }
        
        
        $sql .=' and b.jenisplc=1
            order by e.iUrut ASC 
        ';
        $clones = $this->db->query($sql)->result_array();
        

        foreach ($clones as $clone) {
            //echo $iModul_id;
            
            $nmarr = 'ifile_'.$clone['filename'];
            //if(isset($nmarr,$_POST['ifile_'.$clone['filename']])){
                //echo $iModul_id.' => Ada '.$clone['filename'].' <br>';
                
                /* dapatkan id yang sudah exist */
                $idIn = "'0'";
                foreach ($_POST['ifile_'.$clone['filename']] as $key => $value) {
                    $sqFiles = 'select * 
                                    from plc2.group_file_upload a 
                                    where a.iFile="'.$value.'"  
                                    ';
                    $dFilesnya = $this->db_plc0->query($sqFiles)->row_array();


                    $idIn .= ',"'.$dFilesnya['vFilename_generate'].'"';
                }


                //foreach ($cloneModuls as $clone) {
                    $target_file_table = $clone['filetable'];
                    $target_file_tableID = $clone['fielddetail'];
                    $target_filepath = $clone['filepath'];
                    $iM_modul_fileds = $clone['iM_modul_fileds'];
                    $target_header_table = $clone['vTable_name'];
                    $pk_Target_header_table = $clone['vFieldPK'];
                    $dbase = explode('.',$target_header_table);
                    $iM_modul = $clone['iM_modul'];

                    $vFieldPK = trim($clone['vFieldPK']);
                    if($iM_modul== 54){
                        /* jika kemas sekunder */
                        $pekanya_mother = $this->getAnotherUPB($vFieldPK,$dUpebeh['iupb_id_ref'],0,2);
                        $pekanya_child = $this->getAnotherUPB($vFieldPK,$dUpebeh['iupb_id'],0,2);
                    }else{
                        $pekanya_mother = $this->getAnotherUPB($vFieldPK,$dUpebeh['iupb_id_ref'],0,1);
                        $pekanya_child = $this->getAnotherUPB($vFieldPK,$dUpebeh['iupb_id'],0,1);

                    }
                


                 
                    /* yang dicopy file adalah UPB yang filenya sudah masuk tabel group file*/
                    $sqlgrpFiles = 'select * 
                                    from plc2.group_file_upload a 
                                    where a.iM_modul_fileds="'.$iM_modul_fileds.'"  
                                    and a.idHeader_File = "'.$pekanya_mother.'"
                                    and a.vFilename_generate not in ( '.$idIn.' )
                                    ';

                    /* if($iM_modul == 48){
                        echo '<pre>'.$sqlgrpFiles;
                        exit;

                    } */


                    
                        
                        
                    
                    
                    $dFilesGrp = $this->db->query($sqlgrpFiles)->result_array();

                    if(!empty($dFilesGrp)){
                        $dbase = explode('.',$target_header_table);
                        $query ="SELECT c.`COLUMN_NAME`,c.`COLUMN_KEY` , c.`COLUMN_TYPE`, c.`DATA_TYPE`, c.`CHARACTER_MAXIMUM_LENGTH` FROM `information_schema`.`COLUMNS` c WHERE c.`TABLE_SCHEMA` = '".$dbase[0]."' AND c.`TABLE_NAME`='".$dbase[1]."'"; 
                        $field = $this->db->query($query)->result_array();
                        
                        $field_tb = array();
                        $i =0;

                        foreach ($field as $f) {   
                                array_push($field_tb,$f['COLUMN_NAME']);
                        }

                        
                        /* cek header tabel pk child */

                        $sqlCekPKfield = 'select * from '.$target_header_table.' a where a.'.$vFieldPK.'= "'.$pekanya_child.'"  limit 1 ';
                        $dcekfield = $this->db_plc0->query($sqlCekPKfield)->result_array();
                        if(empty($dcekfield)){
                            /*  jika data tabel header dari upb original ada, maka clonre recordnya */

                            $selPK = "SHOW KEYS FROM ".$target_header_table." WHERE Key_name = 'PRIMARY' ";
                            $dPeka = $this->db->query($selPK)->row_array();
                            
                            $inst =  $this->DuplicateMySQLRecord($target_header_table,$vFieldPK,$pekanya_mother);
                            $iKey_new = $this->db->insert_id();
                            
                                
                                $vCode_key = $dPeka['Column_name'];
                        
                                /* if($vCode_key == 'iprodpilot_id'){
                                    $sqlCekPKfield = 'select * from plc3.t_copy_brand_temp a where a.vToken= "'.$vToken.'" and a.vCode_key = "ifor_id" order by a.id DESC limit 1 ';
                                    $dcekfield = $this->db_plc0->query($sqlCekPKfield)->row_array();
                        
                                    $sqlu = "UPDATE ".$target_header_table." set ifor_id = ".$dcekfield['iKey_new']."  where ".$pk_Target_header_table." = ".$iKey_new."  ";
                                    $this->db_plc0->query($sqlu);
                                    
                        
                                }else{ */
                        
                                    if( in_array('iupb_id',$field_tb) ){
                                        $sqlu = "UPDATE ".$target_header_table." set iupb_id = ".$dUpebeh['iupb_id']."  where ".$pk_Target_header_table." = ".$iKey_new." xx";
                                        $this->db_plc0->query($sqlu);
                        
                                    }else{
                        
                                        /* if( in_array('ifor_id',$field_tb) ){
                                            
                                            $sqlu = "UPDATE ".$target_header_table." set ifor_id = ".$pekanya_child."  where ".$pk_Target_header_table." = ".$iKey_new." cx ";
                                            $this->db_plc0->query($sqlu);
                        
                                        } */
                                        echo'okeh';
                                    }
                        
                                //}
                             
                                /* setelah berhasil copy data . kemudian kopy folder */
                                /* $this->kopiFile($clone,$iKey_ref,$iKey_new);
                                $this->insertLogtemp($vToken,$iM_modul,$iKey_ref,$iKey_new,$iupb_id,$vCode_key); */
                        
                        
                        


                            
                            
                            $sqlu = "UPDATE ".$target_file_table." set ".$vFieldPK." = ".$pekanya_child." where ".$pk_Target_header_table." = ".$iKey_new."  cx";
                            $this->db_plc0->query($sqlu);


                            $pekanya_child = $iKey_new;
                        }else{
                            $pekanya_child = $pekanya_child;
                        }

                        
                
                        

                        foreach ($dFilesGrp as $dFile) {
                            $target_file_tableID = 'iFile' ;
                            $pekaval = $dFile['iFile'];
                            $target_file_table = 'plc2.group_file_upload' ;
                            

                            $inst =  $this->DuplicateMySQLRecord($target_file_table,$target_file_tableID,$pekaval);
                            $insID = $this->db->insert_id();

                            $sqlu = "UPDATE ".$target_file_table." set idHeader_File = ".$pekanya_child.", iM_modul_fileds=".$iM_modul_fileds."  where iFile = ".$insID."  ";
                            $this->db_plc0->query($sqlu);

                            /* setelah berhasil copy data . kemudian kopy folder */
                            $this->kopiFile($clone,$pekanya_mother,$pekanya_child);
                            
                            /* if($iM_modul == 12){
                                echo '<pre>'.$sqlu;
                                exit;

                            } */

                            
                        }

                    }
                //}



            //}
        
        }

        $data['status'] = true;
        $data['last_id'] = $_POST['iupb_id'];   
        $data['message'] = 'Document Updated!';
        echo json_encode($data);


    }

    function refreshDoc($regorprareg){

        $sqlGetUPBMother = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$_POST['iupb_id'].'" ';
        $dUpebeh = $this->db_plc0->query($sqlGetUPBMother)->row_array();
        

        /* v3_cek_dokumen_prareg_iupb_id	[…]
            0	3242
            1	3242
            isdraft	[…]
            0	
            1	
            ifile_fileCoaRS[]	753
            ifile_fileCoaWS[]	754
            ifile_fileProtUDT[]	755
            ifile_fileProtStabilita[]	756
            ifile_fileuploadspek[]	750
            ifile_fileDraftCoafg[]	757
            v3_cek_dokumen_prareg_fileBahanKemasPrimer_ijenis_bk_id[748][]	1
            ifile_fileBahanKemasPrimer[]	748
            ifile_fileSOIBahanBaku[]	749
            ifile_filesoifg[]	751
            ifile_fileprotokolValpro[]	752
            iupb_id	3242 
        */

        


        $sql ='
            select * 
            from plc2.sys_masterdok a
            join plc2.sys_detaildok b on b.idmasterdok=a.idmasterdok
            join plc3.m_modul_fileds c on c.iM_modul_fileds=a.iM_modul_fileds
            join plc3.m_modul d on d.iM_modul = c.iM_modul
            join plc3.m_flow_proses e on e.iM_modul=d.iM_modul and e.iM_flow=d.iM_flow
            where a.ldeleted=0
            and b.ldeleted=0
            and d.lDeleted=0
            and e.lDeleted=0
            #and d.iM_modul = 45
            
            ';
            if($regorprareg == 2){
                $sql .='and b.ijenisdok in(2)';
            }else{
                $sql .='and b.ijenisdok in(1)';
            }
        
        
        $sql .=' and b.jenisplc=1
            order by e.iUrut ASC 
        ';
        //echo '<pre>'.$sql;
        $clones = $this->db->query($sql)->result_array();
        

        foreach ($clones as $clone) {
            //echo $iModul_id;
            
            $nmarr = 'ifile_'.$clone['filename'];
            //if(isset($nmarr,$_POST['ifile_'.$clone['filename']])){
                //echo $iModul_id.' => Ada '.$clone['filename'].' <br>';
                
                /* dapatkan id yang sudah exist */
                $idIn = "'0'";
                foreach ($_POST['ifile_'.$clone['filename']] as $key => $value) {
                    $sqFiles = 'select * 
                                    from plc2.group_file_upload a 
                                    where a.iFile="'.$value.'"  
                                    ';
                    $dFilesnya = $this->db_plc0->query($sqFiles)->row_array();


                    $idIn .= ',"'.$dFilesnya['vFilename_generate'].'"';
                }


                //foreach ($cloneModuls as $clone) {
                    $target_file_table = $clone['filetable'];
                    $target_file_tableID = $clone['fielddetail'];
                    $target_filepath = $clone['filepath'];
                    $iM_modul_fileds = $clone['iM_modul_fileds'];
                    $target_header_table = $clone['vTable_name'];
                    $pk_Target_header_table = $clone['vFieldPK'];
                    $dbase = explode('.',$target_header_table);
                    $iM_modul = $clone['iM_modul'];

                    $vFieldPK = trim($clone['vFieldPK']);
                    #echo $vFieldPK;
                    if($iM_modul== 54){
                        /* jika kemas sekunder */
                        $pekanya_mother = $this->getAnotherUPB($vFieldPK,$dUpebeh['iupb_id_ref'],0,2);
                        $pekanya_child = $this->getAnotherUPB($vFieldPK,$dUpebeh['iupb_id'],0,2);
                    }else{
                        
                        $pekanya_mother = $this->getAnotherUPB($vFieldPK,$dUpebeh['iupb_id_ref'],0,1);
                        
                        $pekanya_child = $this->getAnotherUPB($vFieldPK,$dUpebeh['iupb_id'],0,1);
                    }
                
                    /* echo $pekanya_child;
                    echo $pekanya_mother; */
                    

                 
                    /* yang dicopy file adalah UPB yang filenya sudah masuk tabel group file*/
                    $sqlgrpFiles = 'select * 
                                    from plc2.group_file_upload a 
                                    where a.iM_modul_fileds="'.$iM_modul_fileds.'"  
                                    and a.idHeader_File = "'.$pekanya_mother.'"
                                    and a.vFilename_generate not in ( '.$idIn.' )
                                    ';

                    /* if($iM_modul == 45){
                        echo '<pre>'.$sqlgrpFiles;
                        exit;

                    } */


                    
                        
                        
                    
                    
                    $dFilesGrp = $this->db->query($sqlgrpFiles)->result_array();

                    if(!empty($dFilesGrp)){
                        
                        $dbase = explode('.',$target_header_table);
                        $query ="SELECT c.`COLUMN_NAME`,c.`COLUMN_KEY` , c.`COLUMN_TYPE`, c.`DATA_TYPE`, c.`CHARACTER_MAXIMUM_LENGTH` FROM `information_schema`.`COLUMNS` c WHERE c.`TABLE_SCHEMA` = '".$dbase[0]."' AND c.`TABLE_NAME`='".$dbase[1]."'"; 
                        $field = $this->db->query($query)->result_array();
                        
                        $field_tb = array();
                        $i =0;

                        foreach ($field as $f) {   
                                array_push($field_tb,$f['COLUMN_NAME']);
                        }

                        
                        /* cek header tabel pk child */

                        $sqlCekPKfield = 'select * from '.$target_header_table.' a where a.'.$vFieldPK.'= "'.$pekanya_child.'"  limit 1 ';
                        #echo 'satu'.$sqlCekPKfield;
                        
                        $dcekfield = $this->db_plc0->query($sqlCekPKfield)->result_array();
                        if(empty($dcekfield)){
                            #echo 'masuk sini pak ekoo';
                            //exit;
                            /*  jika data tabel header dari upb original ada, maka clonre recordnya */
                            //echo'sini 3';
                            
                            $selPK = "SHOW KEYS FROM ".$target_header_table." WHERE Key_name = 'PRIMARY' ";
                            $dPeka = $this->db->query($selPK)->row_array();
                            
                            
                            
                               
                                $vCode_key = $dPeka['Column_name'];
                                #echo $vCode_key;
                                
                                if($vCode_key == 'iprodpilot_id'){
                                    
                                    $formulaget ='
                                                    SELECT a.ifor_id
                                                    FROM plc2.plc2_upb_formula a 
                                                    WHERE a.iupb_id= "'.$dUpebeh['iupb_id_ref'].'" 
                                                    ORDER BY a.iFormula_process DESC
                                                    LIMIT 1
                                    ';
                                    $dform = $this->db->query($formulaget)->row_array();

                                    
                                    

                                    $inst =  $this->DuplicateMySQLRecord('plc2.plc2_upb_formula','ifor_id',$dform['ifor_id']);
                                    $iNew_for = $this->db->insert_id();
                                    
                                    /* echo 'prodprod';
                                    exit; */

                                    $sqlu = "UPDATE plc2_upb_formula set iupb_id = ".$dUpebeh['iupb_id']."  where ifor_id = ".$iNew_for."  ";
                                    $this->db_plc0->query($sqlu);
                                    

                                    $getHeader_prod = 'SELECT * FROM plc2.plc2_upb_prodpilot a  WHERE a.ifor_id="'.$dform['ifor_id'].'" ';
                                    
                                    $dprod = $this->db->query($getHeader_prod)->row_array();

                                    $inst =  $this->DuplicateMySQLRecord('plc2.plc2_upb_prodpilot','iprodpilot_id',$dprod['iprodpilot_id']);
                                    $iNew_prod = $this->db->insert_id();

                                    $sqlu = "UPDATE plc2_upb_prodpilot set ifor_id = ".$iNew_for."  where iprodpilot_id = ".$iNew_prod."  ";
                                    $this->db_plc0->query($sqlu);




                                    /* $sqlCekPKfield = 'select * from plc3.t_copy_brand_temp a where a.vToken= "'.$vToken.'" and a.vCode_key = "ifor_id" order by a.id DESC limit 1 ';
                                    $dcekfield = $this->db_plc0->query($sqlCekPKfield)->row_array();
                        
                                    $sqlu = "UPDATE ".$target_header_table." set ifor_id = ".$dcekfield['iKey_new']."  where ".$pk_Target_header_table." = ".$iKey_new."  ";
                                    $this->db_plc0->query($sqlu); */
                                    
                        
                                }else{

                                    $inst =  $this->DuplicateMySQLRecord($target_header_table,$vFieldPK,$pekanya_mother);
                                    $iKey_new = $this->db->insert_id();

                        
                                    if( in_array('iupb_id',$field_tb) ){
                                        $sqlu = "UPDATE ".$target_header_table." set iupb_id = ".$dUpebeh['iupb_id']."  where ".$pk_Target_header_table." = ".$iKey_new." ";
                                        $this->db_plc0->query($sqlu);
                                        /* echo 'masuk sini' ;
                                        echo $sqlu ; */
                                        
                                    }else{
                        
                                        /* if( in_array('ifor_id',$field_tb) ){
                                            
                                            $sqlu = "UPDATE ".$target_header_table." set ifor_id = ".$pekanya_child."  where ".$pk_Target_header_table." = ".$iKey_new." cx ";
                                            $this->db_plc0->query($sqlu);
                        
                                        } */
                                        //echo'okeh';
                                    }

                                    
                        
                                }
                             
                                /* setelah berhasil copy data . kemudian kopy folder */
                                /* $this->kopiFile($clone,$iKey_ref,$iKey_new);
                                $this->insertLogtemp($vToken,$iM_modul,$iKey_ref,$iKey_new,$iupb_id,$vCode_key); */
                        
                        
                        


                            
                            
                            /* $sqlu = "UPDATE ".$target_file_table." set ".$vFieldPK." = ".$pekanya_child." where ".$pk_Target_header_table." = ".$iKey_new."  cx";
                            $this->db_plc0->query($sqlu); */


                            $pekanya_child = $iKey_new;
                        }else{
                            //echo'sini 2';
                            
                            $pekanya_child = $pekanya_child;
                        }

                        
                
                        

                        foreach ($dFilesGrp as $dFile) {
                            $target_file_tableID = 'iFile' ;
                            $pekaval = $dFile['iFile'];
                            $target_file_table = 'plc2.group_file_upload' ;
                            

                            $inst =  $this->DuplicateMySQLRecord($target_file_table,$target_file_tableID,$pekaval);
                            $insID = $this->db->insert_id();

                            $sqlu = "UPDATE ".$target_file_table." set idHeader_File = ".$pekanya_child.", iM_modul_fileds=".$iM_modul_fileds."  where iFile = ".$insID."  ";
                            $this->db_plc0->query($sqlu);

                            /* setelah berhasil copy data . kemudian kopy folder */
                            $this->kopiFile($clone,$pekanya_mother,$pekanya_child);
                            
                            /* if($iM_modul == 12){
                                echo '<pre>'.$sqlu;
                                exit;

                            } */

                            
                        }

                    }else{
                        #echo 'empty file';
                        #exit;
                    }
                //}



            //}
        
        }

        $data['status'] = true;
        $data['last_id'] = $_POST['iupb_id'];   
        $data['message'] = 'Document Updated!';
        echo json_encode($data);

    }

    
    function listBox_copy_brand_iupb_id_ref($value, $pk, $name, $rowData) {
        $sql = "SELECT a.vupb_nomor from plc2.plc2_upb a where a.iupb_id = '{$value}'";
        $query = $this->db_plc0->query($sql);
        $nama_group = '-';
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $nama_group = $row->vupb_nomor;
        }
        
        return $nama_group;
    }
    
    function getNamaTeamUPB($iupb_id){
      $sql = 'select 
            *
            ,ifnull(b.vteam,"-") as nmPD
            ,ifnull(c.vteam,"-") as nmBD
            ,ifnull(d.vteam,"-") as nmMKT
            ,ifnull(e.vteam,"-") as nmQA
            ,ifnull(f.vteam,"-") as nmAD

            ,ifnull(a.iteam_id,"-") as itimBD



            
            from plc2.plc2_upb a 
            left join plc2.plc2_upb_team b on b.iteam_id=a.iteampd_id
            left join plc2.plc2_upb_team c on c.iteam_id=a.iteambusdev_id
            left join plc2.plc2_upb_team d on d.iteam_id=a.iteammarketing_id
            left join plc2.plc2_upb_team e on e.iteam_id=a.iteamqa_id 
            left join plc2.plc2_upb_team f on f.iteam_id=a.iteamad_id
            where a.ldeleted=0 
            and a.iupb_id="'.$iupb_id.'"';
      $query = $this->_ci->db->query($sql);
      $jmlRow = $query->num_rows();
      if ($jmlRow > 0) {
         $rows = $query->row_array();
      }

      return $rows;

   }

   function myTimBede($nip){
      $sql = ' select b.iteam_id 
               from hrd.employee a
               join plc2.plc2_upb_team_item b on b.vnip=a.cNip 
               where b.ldeleted = 0
               and a.cNip = "'.$nip.'"

               union 

               select b.iteam_id 
               from hrd.employee a
               join plc2.plc2_upb_team b on b.vnip=a.cNip 
               where b.ldeleted = 0
               and a.cNip = "'.$nip.'"


               limit 1

               ';
      $dSql = $this->db->query($sql)->row_array();

      return $dSql['iteam_id'];
   }

    function copyUPB_process($postData,$iM_modul) {
        
        $vToken     = $postData['vToken'];
        $iupb_id    = $postData['iupb_id'];

        $team=  $this->auth_localnon->my_teams(TRUE);
        
        $timBd = $this->myTimBede($this->user->gNIP);

        $post = $this->input->post();
        $user = $this->auth_localnon->user();
        
        $qupb="select * from plc2.plc2_upb u where u.iupb_id=$iupb_id";
        $rupb = $this->db_plc0->query($qupb)->row_array();
        
        $query = "SELECT MAX(iupb_id) std FROM plc2.plc2_upb";
        $rs = $this->db_plc0->query($query)->row_array();
        $nomor = intval($rs['std']) + 1;
        $nomor = "U".str_pad($nomor, 5, "0", STR_PAD_LEFT);
        
        //insert table upb
        $ins['vkat_originator_new'] = $rupb['vkat_originator_new']; 
        $ins['ipatent_new'] = $rupb['ipatent_new']; 
        $ins['iPatent_ind'] = $rupb['iPatent_ind']; 
        $ins['iPatent_ind_exp'] = $rupb['iPatent_ind_exp']; 
        $ins['iPatent_ind_info'] = $rupb['iPatent_ind_info']; 

        $ins['iPatent_int'] = $rupb['iPatent_int']; 
        $ins['iPatent_int_exp'] = $rupb['iPatent_int_exp']; 
        $ins['iPatent_int_info'] = $rupb['iPatent_int_info']; 



        $ins['vupb_nomor'] = $nomor;
        $ins['vupb_nama'] = $rupb['vupb_nama']; 
        $ins['cnip'] = $this->user->gNIP;
        $ins['ttanggal'] = date('Y-m-d');
        $ins['iupb_id_ref'] = $iupb_id;
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
        $ins['iteambusdev_id'] = $timBd; 
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
        $ins['iCopy_brand'] = 1; 


        $insUPB = $this->db_plc0->insert('plc2.plc2_upb', $ins);

        if($insUPB){
            //after insert select maxid utk masukan status
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
           // echo $query_ku;         
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
            $ret['status'] = true;
            $ret['proses_ke'] = 1;

            $ret['iupb_id_new'] = $insertId;
            
            
            
            
            $iKey_ref   = $iupb_id;
            $iKey_new   = $insertId;
            $vCode_key  = 'iupb_id';
            $this->insertLogtemp($vToken,$iM_modul,$iKey_ref,$iKey_new,$iupb_id,$vCode_key);

            
                    

        }else{

            $ret['status'] = false;
            $ret['proses_ke'] =0;
            $ret['iupb_id_new'] = 0;
        }
        
        return $ret;
        

        
        
    }

    function insertLogtemp($vToken,$iM_modul,$iKey_ref,$iKey_new,$iupb_id,$vCode_key){
        $dataalert=array();
        $dataalert['dCreate'] = date('Y-m-d H:i:s');
        $dataalert['cCreated']=$this->user->gNIP;
        
        
        $dataalert['vToken']        = $vToken;
        $dataalert['iM_modul']      = $iM_modul;
        $dataalert['iKey_ref']      = $iKey_ref;
        $dataalert['iKey_new']      = $iKey_new;
        $dataalert['iupb_id_ref']   = $iupb_id;
        $dataalert['vCode_key']     = $vCode_key;
        
        $dataalert['dCreate'] = date('Y-m-d H:i:s');
        $ins = $this -> db -> insert('plc3.t_copy_brand_temp', $dataalert);

    }


    function getProsesKopi(){

        /* clear tabel temp */
            $SQL = "TRUNCATE plc3.`t_copy_brand_temp`";
            $this->db_plc0->query($SQL);
        
        /* clear tabel temp */

        $iupb_id_ref = $_POST['iupb_id'];
        $vToken = $_POST['vToken'];
        
        

        $sqlWhereisUPB = '  select d.iM_flow_proses,e.vNama_modul,c.iM_flow,a.iupb_id,d.iUrut
                            from plc3.m_modul_log_upb a
                            join plc3.m_modul_log_activity a1 on a1.iM_modul_log_activity=a.iM_modul_log_activity
                            join plc2.plc2_upb b on b.iupb_id=a.iupb_id
                            join plc3.m_modul e on e.idprivi_modules=a1.idprivi_modules
                            join plc3.m_flow c on c.iM_flow=b.iM_flow
                            join plc3.m_flow_proses d on d.iM_flow=c.iM_flow
                            where a.lDeleted=0
                            and a1.lDeleted=0
                            and b.ldeleted=0
                            and e.lDeleted=0
                            and c.lDeleted=0
                            and d.lDeleted=0
                            and b.iupb_id="'.$iupb_id_ref.'"
                            order by d.iUrut DESC limit 1
                            ';
        $dUpbLocation = $this->db->query($sqlWhereisUPB)->row_array();
        if(!empty($dUpbLocation)){
            $endProsesCp = $dUpbLocation['iUrut'];
        }else{
            $endProsesCp = 10;
        }

        $endProsesCp = 250;
        //$endProsesCp = 110;

        $sqlGetProsesFlow = '
             select c.iM_flow_proses,c.iM_flow,c.iM_modul,c.iUrut,d.*
            from plc3.m_flow b 
            join plc3.m_flow_proses c on c.iM_flow=b.iM_flow
            join plc3.m_modul d on d.iM_modul=c.iM_modul
            where b.lDeleted=0
            and c.lDeleted=0
            and b.iM_flow= "1" #flow Non OTC
            #and c.iUrut <= "'.$endProsesCp.'"
            order by c.iUrut

        ';

        /* echo '<pre>'.$sqlGetProsesFlow;
        exit; */
        $dproseses = $this->db->query($sqlGetProsesFlow);
        $totalproses = $dproseses->num_rows();
        $proseses = $dproseses->result_array();

        $ke = 0;
        foreach ($proseses as $proses) {
            $doModul= 'doModul'.$proses['iM_modul'];
            $iM_modul = $proses['iM_modul'];
            if($proses['iM_modul'] == 1){
                $return = $this->copyUPB_process($_POST,$iM_modul);   
                //$return = $this->doModul1($_POST);

            }else{
                $sqlGetlasToken = 'select a.*, 
                                    a.iKey_new 
                                    from plc3.t_copy_brand_temp a 
                                    where a.vToken="'.$vToken.'" 
                                    order by a.id DESC limit 1
                                    #and a.iM_modul="'.$iM_modul.'"
                                    ';
                $dNewUpb        = $this->db->query($sqlGetlasToken)->row_array();
                $return = $this->doModulGlobal($_POST,$dNewUpb['iKey_new'],$iM_modul,$ke);
            }

            $ke ++;
        }
         

        //if(!empty($proseses)){
        if($ke >= $totalproses){
            $data['status']  = true;
            $data['proseses'] = $proseses;
            $data['iupb_id_ref'] = $iupb_id_ref;
            $data['totalproses'] = $totalproses;
            $data['lastprosesKe'] = $ke;
            $data['message'] = 'Copy Brand Complete';
            return json_encode($data);
            
        }else{
            $data['status']  = false;
            $data['totalproses'] = $totalproses;
            $data['lastprosesKe'] = $ke;
            $data['message'] = 'Copy Brand Failed';
            return json_encode($data);
        }
        

    }


    function getAnotherUPB($field='iupb_id',$iupb_id,$n=0,$iJenis_bk=1){

		$ret=0;
		switch ($field) {

             case 'iprodpilot_id':
                $sq_getfor="select plc2_upb_formula.ifor_id 
                            from plc2.plc2_upb_formula
                            join plc2.plc2_upb on plc2_upb.iupb_id=plc2_upb_formula.iupb_id
                            #join plc2.plc2_upb_buat_mbr on plc2_upb_buat_mbr.ifor_id=plc2_upb_formula.ifor_id
                            where plc2_upb.ldeleted=0
                            #and plc2_upb_buat_mbr.iapppd_bm=2
                            and plc2_upb.iupb_id=".$iupb_id."
                            order by  plc2_upb_formula.ifor_id DESC limit 1
                            ";
                            //echo '<pre>'.$sq_getfor;

                $forfor=$this->db->query($sq_getfor)->row_array();

                if(!empty($forfor)){
                    $ifor_id = $forfor['ifor_id'];
                    $sql_lapori="select * from plc2.plc2_upb_prodpilot where ifor_id=".$ifor_id." and ldeleted=0 order by iprodpilot_id DESC Limit 1";
                    

                    $q_lapori=$this->db->query($sql_lapori)->row_array();
                    $ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
                

                }else{
                    $ret = 0;
                }
                
                break;
                


			case 'ifor_id':
				$sql_lapori="select * from plc2.plc2_upb_formula where iupb_id=".$iupb_id." #and iFormula_process is not null 
				and ldeleted=0 order by ifor_id DESC limit 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
				break;
			case 'iprotokol_id':
				$sql_lapori="select * from plc2.protokol_valpro where iupb_id=".$iupb_id." and lDeleted=0 order by iprotokol_id DESC limit 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
				break;
			case 'isoi_id':
				$sql_lapori="select * from plc2.plc2_upb_soi_fg fg where fg.iupb_id=".$iupb_id." and fg.ldeleted=0 order by fg.isoi_id DESC Limit 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
				break;

         case 'isoifg_id':
            $sql_lapori="select * from plc2.soi_fg fg where fg.iupb_id=".$iupb_id." and fg.ldeleted=0 order by fg.isoifg_id DESC Limit 1";
            $q_lapori=$this->db->query($sql_lapori)->row_array();
            $ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
            break;
            
			case 'ivalmoa_id':
				$sql_lapori="select * from plc2.plc2_vamoa fg where fg.iupb_id=".$iupb_id." and fg.lDeleted=0 order by fg.ivalmoa_id DESC Limit 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
				break;
			case 'ibk_id':
				$sql_lapori="select * 
                        from plc2.plc2_upb_bahan_kemas bk 
                        where bk.iupb_id='".$iupb_id."'
				           and bk.ldeleted=0 and bk.iJenis_bk='".$iJenis_bk."'  
                       order by bk.ibk_id DESC Limit 1";
                       //echo '<pre>'.$sql_lapori;

				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
				break;
			case 'isoibb_id':
				$sql_lapori="select * from plc2.plc2_upb_soi_bahanbaku where iupb_id=".$iupb_id." and ldeleted=0 order by isoibb_id DESC Limit 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
				break;
			case 'ilpo_id':
				$sql_lapori="select * from plc2.lpo where iupb_id=".$iupb_id." and ldeleted=0 order by ilpo_id DESC Limit 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
                break;
                
                case 'ivalidasi_id':
				$sql_lapori="select * from plc2.validasi_proses where iupb_id=".$iupb_id." and lDeleted=0 order by ivalidasi_id DESC Limit 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
				break;
                
			default:
				$ret=$iupb_id;
				break;
		}
		return $ret;
    }
    

    function doModulGlobal($postData,$iKey_new,$iM_modul,$proses_ke){
        /* print_r($postData);
        echo 'new'.$iupb_id_new;
        echo '| mod'.$iModul_id;
        echo '| pros'.$proses_ke;
        echo '<br>'; */
        $vToken = $postData['vToken'];
        $iupb_id = $postData['iupb_id'];

        $stat = true;
            // get modul apa saja yang akan di clone datanya
            $sql ='
                    select * 
                    from plc2.sys_masterdok a
                    join plc2.sys_detaildok b on b.idmasterdok=a.idmasterdok
                    join plc3.m_modul_fileds c on c.iM_modul_fileds=a.iM_modul_fileds
                    join plc3.m_modul d on d.iM_modul = c.iM_modul
                    join plc3.m_flow_proses e on e.iM_modul=d.iM_modul and e.iM_flow=d.iM_flow
                    where a.ldeleted=0
                    and b.ldeleted=0
                    and d.lDeleted=0
                    and e.lDeleted=0
                    #and b.ikategori_id in(3)
                    and b.ijenisdok in(1,99,2)
                    and b.jenisplc=1
                    and d.iM_modul= "'.$iM_modul.'"
                    order by e.iUrut ASC 
            ';
            
        $cloneModuls = $this->db->query($sql)->result_array();

        if (!empty($cloneModuls)) {
             /*if($iM_modul==50){
                echo '<pre>'.$sql;
                echo '<br>';
                exit;
            } */
            
            foreach ($cloneModuls as $clone) {
                $target_file_table = $clone['filetable'];
                $target_file_tableID = $clone['fielddetail'];
                $target_filepath = $clone['filepath'];
                $iM_modul_fileds = $clone['iM_modul_fileds'];
                $target_header_table = $clone['vTable_name'];
                $pk_Target_header_table = $clone['fieldheader'];
                $dbase = explode('.',$target_header_table);
                

                $vFieldPK = trim($clone['vFieldPK']);
                if($iM_modul== 54){
                    /* jika kemas sekunder */
                    $pekanya = $this->getAnotherUPB($vFieldPK,$postData['iupb_id'],0,2);
                }else{
                    $pekanya = $this->getAnotherUPB($vFieldPK,$postData['iupb_id'],0,1);

                     /*if($iM_modul==50){
                        echo '<pre>'.$vFieldPK.' '.$postData['iupb_id'];
                        echo '<br>';
                        echo $pekanya;
                        exit;
                    
                    } */


                }
                



                $query ="SELECT c.`COLUMN_NAME`,c.`COLUMN_KEY` , c.`COLUMN_TYPE`, c.`DATA_TYPE`, c.`CHARACTER_MAXIMUM_LENGTH` FROM `information_schema`.`COLUMNS` c WHERE c.`TABLE_SCHEMA` = '".$dbase[0]."' AND c.`TABLE_NAME`='".$dbase[1]."'"; 
                $field = $this->db->query($query)->result_array();
                
                //echo $query;

                $field_tb = array();
                $i =0;

                foreach ($field as $f) {   
                        array_push($field_tb,$f['COLUMN_NAME']);
                        // sampai sini
                        
                }

                //if( in_array('iupb_id',$field_tb) ){
                    /* echo 'kesini om <br>';
                    exit; */ 

                    /* jika di tablenya ada unsur field upnb_id maka jalankan script ini */
                    
                    /* cek udah di proses belum header table modul */
                    $sqUdah = 'select * from plc3.t_copy_brand_temp a where a.vToken= "'.$vToken.'" and a.iM_modul = "'.$iM_modul.'"  ';
                    $dUdah = $this->db->query($sqUdah)->row_array();
                    
                    $selPK = "SHOW KEYS FROM ".$target_header_table." WHERE Key_name = 'PRIMARY' ";
                    $dPeka = $this->db->query($selPK)->row_array();


                    /* select data header table file dari referensi PK */
                    //$selheaderbyUPB = 'select * from '.$target_header_table.' a where a.'.$vFieldPK.'="'.$pekanya.'"  order by '.$pk_Target_header_table.' DESC LIMIT 1 ';
                    $selheaderbyUPB = 'select * from '.$target_header_table.' a where a.'.$vFieldPK.'="'.$pekanya.'"  order by '.$vFieldPK.' DESC LIMIT 1 ';
                    
                    /* if($iM_modul==45){
                            echo '<pre>'.$selheaderbyUPB;
                            exit;
                        } */
                    $dHeaderbyUPB = $this->db->query($selheaderbyUPB)->row_array();

                    $sqUpbNew = 'select * from plc3.t_copy_brand_temp a where a.vToken= "'.$vToken.'" and a.iM_modul = "1" order by a.id DESC limit 1 ';
                    $dUpbNew = $this->db->query($sqUpbNew)->row_array();

                    if(empty($dUdah)){
                        /* jika belum , maka jalankan script ini untuk insert header table file */
                        


                        if(!empty($dHeaderbyUPB)){
                            $iKey_ref = $dHeaderbyUPB[$pk_Target_header_table];
                            //$iKey_ref = 20;
                            
                            $vCode_key = $dPeka['Column_name'];

                            /*  jika data tabel header dari upb ada, maka clonre recordnya */

                            $sqlCekPKfield = 'select * from plc3.t_copy_brand_temp a where a.vToken= "'.$vToken.'" and a.vCode_key = "'.$vCode_key.'" order by a.id DESC limit 1 ';
                            $dcekfield = $this->db_plc0->query($sqlCekPKfield)->result_array();
                            if(empty($dcekfield)){
                                $inst =  $this->DuplicateMySQLRecord($target_header_table,$pk_Target_header_table,$dHeaderbyUPB[$pk_Target_header_table]);
                                $iKey_new = $this->db->insert_id();

                            }else{
                                $sqlCekPKfield = 'select * from plc3.t_copy_brand_temp a where a.vToken= "'.$vToken.'" and a.vCode_key = "'.$vCode_key.'" order by a.id DESC limit 1 ';
                                $dcekfield = $this->db_plc0->query($sqlCekPKfield)->row_array();
                                $iKey_new = $dcekfield['iKey_new'];
                            }
                            
                            
                            if($vCode_key == 'iprodpilot_id'){
                                $sqlCekPKfield = 'select * from plc3.t_copy_brand_temp a where a.vToken= "'.$vToken.'" and a.vCode_key = "ifor_id" order by a.id DESC limit 1 ';
                                $dcekfield = $this->db_plc0->query($sqlCekPKfield)->row_array();

                                $sqlu = "UPDATE ".$target_header_table." set ifor_id = ".$dcekfield['iKey_new']."  where ".$pk_Target_header_table." = ".$iKey_new."  ";
                                $this->db_plc0->query($sqlu);
                                

                            }else{

                                if( in_array('iupb_id',$field_tb) ){
                                    $sqlu = "UPDATE ".$target_header_table." set iupb_id = ".$dUpbNew['iKey_new']."  where ".$pk_Target_header_table." = ".$iKey_new."  ";
                                    $this->db_plc0->query($sqlu);

                                }else{

                                    if( in_array('ifor_id',$field_tb) ){
                                        
                                        $sqlu = "UPDATE ".$target_header_table." set ifor_id = ".$dUpbNew['iKey_new']."  where ".$pk_Target_header_table." = ".$iKey_new."  ";
                                        $this->db_plc0->query($sqlu);

                                    }

                                }


                                /* if($vCode_key == 'ifor_id'){

                                    

                                }else{
                                    $sqlu = "UPDATE ".$target_header_table." set ".$vCode_key."= ".$dUpbNew['iKey_new']."  where ".$pk_Target_header_table." = ".$iKey_new."  ";
                                    $this->db_plc0->query($sqlu);
                                } */


                            }
                         
                            /* setelah berhasil copy data . kemudian kopy folder */
                            $this->kopiFile($clone,$iKey_ref,$iKey_new);
                            

                            
                            $this->insertLogtemp($vToken,$iM_modul,$iKey_ref,$iKey_new,$iupb_id,$vCode_key);


                        }else{
                           // $iKey_ref = 31;
                        }

                    }else{
                        if(!empty($dHeaderbyUPB)){

                            if($vFieldPK == 'iupb_id'){
                                $iKey_ref = $dHeaderbyUPB[$pk_Target_header_table];
                            }else{
                                $iKey_ref = $dUdah['iKey_ref'];
                                
                            }
                            
                            //$iKey_ref =10;

                            $vToken = $postData['vToken'];
                            $iupb_id = $postData['iupb_id'];
                            $vCode_key = $dPeka['Column_name'];
                            $iKey_new = $dUdah['iKey_new'];
                            
                            

                        }else{
                            //$iKey_ref = 30;
                        }


                    }

                        /* yang dicopy file adalah UPB yang filenya sudah masuk tabel group file*/
                        $sqlgrpFiles = 'select * from plc2.group_file_upload a where a.iM_modul_fileds="'.$iM_modul_fileds.'"  and a.idHeader_File = "'.$iKey_ref.'"';
                        /* if($iM_modul==45){
                            echo '<pre>'.$sqlgrpFiles;
                            echo '<br>';
                        //    exit;
                        } */
                        
                        $dFilesGrp = $this->db->query($sqlgrpFiles)->result_array();

                        if(!empty($dFilesGrp)){
                            foreach ($dFilesGrp as $dFile) {
                                $target_file_tableID = 'iFile' ;
                                $pekaval = $dFile['iFile'];
                                $target_file_table = 'plc2.group_file_upload' ;
                                

                                $inst =  $this->DuplicateMySQLRecord($target_file_table,$target_file_tableID,$pekaval);
                                $insID = $this->db->insert_id();

                                $sqlu = "UPDATE ".$target_file_table." set idHeader_File = ".$iKey_new.", iM_modul_fileds=".$iM_modul_fileds."  where iFile = ".$insID."  ";
                                $this->db_plc0->query($sqlu);
                                
                            }

                        }/* else{
                            $selFiles = 'select * from '.$target_file_table.' a where a.'.$dPeka['Column_name'].'="'.$iKey_ref.'"  order by '.$dPeka['Column_name'].'  ';
                            $dFiles = $this->db->query($selFiles)->result_array();

                            foreach ($dFiles as $dFile) {
                                $pekaval = $dFile[$target_file_tableID];

                                $inst =  $this->DuplicateMySQLRecord($target_file_table,$target_file_tableID,$pekaval);
                                $insID = $this->db->insert_id();

                                $sqlu = "UPDATE ".$target_file_table." set ".$dPeka['Column_name']."= ".$iKey_new."  where ".$target_file_tableID." = ".$insID."  ";
                                $this->db_plc0->query($sqlu);
                                
                            } 

                            foreach ($dFiles as $dFile) {
                                $target_file_tableID = 'iFile' ;
                                $pekaval = $dFile['iFile'];
                                $target_file_table = 'plc2.group_file_upload' ;
                                

                                $inst =  $this->DuplicateMySQLRecord($target_file_table,$target_file_tableID,$pekaval);
                                $insID = $this->db->insert_id();

                                $sqlu = "UPDATE ".$target_file_table." set idHeader_File = ".$iKey_new.", iM_modul_fileds=".$iM_modul_fileds."  where iFile = ".$insID."  ";
                                $this->db_plc0->query($sqlu);

                            
                            }
                            


                        } */




                        
                    

                    
                //}
                
            }
            

        }


        
        $ret['status'] = $stat;
        $ret['proses_ke'] = $proses_ke ;
        $ret['iupb_id_new'] = $iupb_id_new;
        

        

        return $ret;
    }
    
    function rcopy($src, $dest){
        
        // If source is not a directory stop processing
        if(!is_dir($src)) return false;

        // If the destination directory does not exist create it
        if(!is_dir($dest)) { 
            if(!mkdir($dest, 0777, true)) {
                // If the destination directory could not be created stop processing
                return false;
            }    
        }

        // Open the source directory to read in files
        $i = new DirectoryIterator($src);
        foreach($i as $f) {
            if($f->isFile()) {
                copy($f->getRealPath(), "$dest/" . $f->getFilename());
            } else if(!$f->isDot() && $f->isDir()) {
                rcopy($f->getRealPath(), "$dest/$f");
            }
        }

        return true;
        
    }

    function kopiFile($clone,$idHeader_ref,$idHeader_new){
        
        $path = realpath($clone['filepath']);
        $source = $path.'/'.$idHeader_ref ;
        $destiny = $path.'/'.$idHeader_new;
        /* if($idHeader_ref==155){
                //print_r($clone);
                echo '<br>';
                echo $path;
                echo '<br>';
                echo $source;
                echo '<br>';
                echo $destiny;
                echo '<br>';
                
        } */
        
        if(!file_exists($path.'/'.$idHeader_new)){
            if (!mkdir($path.'/'.$idHeader_new, 0777, true)) { 
                $data['status']  = false;
                $data['message'] = 'Copy Brand Failed '.$idHeader_new.'-'.$idHeader_ref.' => '.$clone['filepath'];
                //return json_encode($data);

                die('Failed upload, try again!');
            }else{
                
                if($this->rcopy($source,$destiny)){
                    $data['status']  = true;
                    $data['message'] = 'Copy Brand Successfully '.$idHeader_new.'-'.$idHeader_ref.' => '.$clone['filepath'];
                }else{
                    $data['status']  = false;
                    $data['message'] = 'Failed Copy Files';   
                }

                
            }
        }else{
            if($this->rcopy($source,$destiny)){
                $data['status']  = true;
                $data['message'] = 'Copy Brand Successfully';   
            }else{
                $data['status']  = false;
                $data['message'] = 'Failed Copy Files';   
            }

        }
            /*print_r($data);
            exit; */
            $data['status']  = true;
            
            return json_encode($data);
        
        

    }
    function DuplicateMySQLRecord ($table, $primary_key_field, $primary_key_val){
        /* generate the select query */
        $this->db->where($primary_key_field, $primary_key_val); 
        $query = $this->db->get($table);
    
        foreach ($query->result() as $row){   
        foreach($row as $key=>$val){        
            if($key != $primary_key_field){ 
            /* $this->db->set can be used instead of passing a data array directly to the insert or update functions */
            $this->db->set($key, $val);               
            }//endif              
        }//endforeach
        }//endforeach

        /* insert the new record into table*/
        return $this->db->insert($table); 
    }


    function doModul1($postData){
        /*daftar UPB*/
        $insertId = $postData['iupb_id_new'];
        $ret['status'] = true;
        $ret['iupb_id_new'] = $insertId+1;
        
        return $ret;

    }

    



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
                                        var url = "'.base_url().'processor/plc/copy_brand";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_copy_brand").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_copy_brand");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_copy_brand_approve" action="'.base_url().'processor/plc/copy_brand?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_copy_brand_approve\')">Approve</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function approve_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $iupb_id = $post['iupb_id'];
                $iupb_id = $post['iupb_id'];
                
                $vRemark = $post['vRemark'];
                $modul_id = $post['modul_id'];


                //Letakan Query Update approve disini
                $data=array('iapppd'=>'2');
                $this -> db -> where('iupb_id', $iupb_id);
                $updet = $this -> db -> update('plc2.plc2_upb', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_activity = $isAndSort['iM_activity'];
                $iSort = $isAndSort['iSort'];

                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iupb_id,$iM_activity,$iSort,$vRemark,2);
    
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
                                        var url = "'.base_url().'processor/plc/copy_brand";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_copy_brand").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_copy_brand");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_copy_brand_confirm" action="'.base_url().'processor/plc/copy_brand?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_copy_brand_confirm\')">Confirm</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function confirm_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $iupb_id = $post['iupb_id'];
                $iupb_id = $post['iupb_id'];
                $vRemark = $post['vRemark'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $modul_id = $post['modul_id'];

                //Letakan Query Update approve disini
                $data=array('iapppd'=>'2');
                $this -> db -> where('iupb_id', $iupb_id);
                $updet = $this -> db -> update('plc2.plc2_upb', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_activity = $isAndSort['iM_activity'];
                $iSort = $isAndSort['iSort'];
                
                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iupb_id,$iM_activity,$iSort,$vRemark,2);

                
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
                                var remark = $("#copy_brand_remark").val();
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
                                        var url = "'.base_url().'processor/plc/copy_brand";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_copy_brand").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_copy_brand");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_copy_brand_reject" action="'.base_url().'processor/plc/copy_brand?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark" id="reject_copy_brand_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_copy_brand_reject\')">Reject</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            }
    
    
            
            function reject_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $iupb_id = $post['iupb_id'];
                $iupb_id = $post['iupb_id'];
                $vRemark = $post['vRemark'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $modul_id = $post['modul_id'];
    
                //Letakan Query Update reject disini
                $data=array('iapppd'=>'1');
                $this -> db -> where('iupb_id', $iupb_id);
                $updet = $this -> db -> update('plc2.plc2_upb', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_activity = $isAndSort['iM_activity'];
                $iSort = $isAndSort['iSort'];
                
                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iupb_id,$iM_activity,$iSort,$vRemark,1);
    
                $data['status']  = true;
                $data['last_id'] = $post['iupb_id'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }


    function getHistory($iupb_id,$iTujuan_req){

        $sql = 'select a.vreq_ori_no , date(a.tcreate) as tcreate , a.tapppd as tapppd,a.vnip_apppd  
                from plc2.plc2_upb a 
                where 
                a.ldeleted=0
                and a.iupb_id= "'.$iupb_id.'"  
                and a.iTujuan_req= "'.$iTujuan_req.'"  
                order by iupb_id
        ';
        
        return $sql;
    }
    function getDetail(){
        $sqlHistory = $this->getHistory($_POST['iupb_id'],$_POST['iTujuan_req']);
        $data['datanya'] = $this->db->query($sqlHistory)->result_array();
        return $this->load->view('request_originator_history_show',$data,TRUE);   

    }
    function getrekKe(){

        $data = array();

        $sqlHistory = $this->getHistory($_POST['iupb_id'],$_POST['iTujuan_req']);
        $count = $this->db->query($sqlHistory)->num_rows();;

        $row_array['jumlah'] = trim($count)+1;
        $row_array['jumlah_before'] = trim($count);
        array_push($data, $row_array);
        echo json_encode($data);
        exit;

    }

    function cekCurrentPost(){

        $data = array();
        $sqCekTrial = 'select c.vCodeModule 
                        from plc3.m_modul_log_upb a 
                        join plc3.m_modul_log_activity b on b.iM_modul_log_activity=a.iM_modul_log_activity
                        join plc3.m_modul c on c.idprivi_modules=b.idprivi_modules
                        where a.iupb_id=2922
                        and b.lDeleted=0
                        and c.lDeleted=0
                        and c.vCodeModule = "1.skala_trial"
                        limit 1 ';
        $dTrial = $this->db->query($sqCekTrial)->row_array();

        if( empty($dTrial)){
            $sample=1;
            /*masih untuk sample*/
        }else{
            $sample=0;
            /*untuk pilot*/
        }
        

        $row_array['sample'] = $sample;
        array_push($data, $row_array);
        echo json_encode($data);
        exit;

    }

    
    function output(){
        $this->index($this->input->get('action'));
    }

    function before_insert_processor($row, $postData) {
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated']=$this->user->gNIP;



        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } else{
            $postData['iSubmit']=1;
            
        } 
        

        return $postData;

    }

    function after_insert_processor($fields, $id, $postData) {
        
        /* $nomor = "R".str_pad($id, 7, "0", STR_PAD_LEFT);
        $sql = "UPDATE plc2.plc2_upb SET vreq_ori_no = '".$nomor."' WHERE iupb_id=$id LIMIT 1";
        $query = $this->db_plc0->query( $sql ); 
        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } else{
            $postData['iSubmit']=1;
            $arrUPB['iupb_id'] = $postData['iupb_id'];
            $this->lib_plc->InsertActivityModule($arrUPB,$this->modul_id,$id,1,1);
        }

        $iupb_id=$id; */
    }


    public function after_update_processor($fields, $id, $post) {
       /*  $nomor = "R".str_pad($id, 7, "0", STR_PAD_LEFT);
        $sql = "UPDATE plc2.plc2_upb SET vreq_ori_no = '".$nomor."' WHERE iupb_id=$id LIMIT 1";
        $query = $this->db_plc0->query( $sql ); */


    }


    function before_update_processor($row, $postData) {
        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;

        $controller_name ='copy_brand';
        $pk_field = 'iupb_id';
        $gabung = $controller_name."_".$pk_field;
        $peka=$postData[$gabung];

        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } else{
            $postData['iSubmit']=1;
            $arrUPB['iupb_id'] = $postData['iupb_id'];
            $this->lib_plc->InsertActivityModule($arrUPB,$this->modul_id,$peka,1,1);
        } 


        return $postData; 
    }




    function manipulate_update_button($buttons, $rowData) { 
        $peka=$rowData['iupb_id'];
        $iupb_id=$rowData['iupb_id'];


        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $js = $this->load->view('js/standard_js');
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="copy_brand_frame" id="copy_brand_frame" height="0" width="0"></iframe>';
        

        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        }
        else{ 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\'copy_brand\', \' '.base_url().'processor/plc/copy_brand?draft=true \',this,true )"  id="button_update_draft_copy_brand"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$peka);
                    $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,$peka);

                    foreach ($activities as $act) {
                        $update_draft = '<button onclick="javascript:update_draft_btn(\'copy_brand\', \' '.base_url().'processor/plc/copy_brand?draft=true \',this,true )"  id="button_update_draft_copy_brand"  class="ui-button-text icon-save" >Update as Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\'copy_brand\', \' '.base_url().'processor/plc/copy_brand?company_id='.$this->input->get('company_id').'&iM_modul_activity='.$act['iM_modul_activity'].'group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_copy_brand"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/copy_brand?action=approve&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&iupb_id='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_copy_brand"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/copy_brand?action=reject&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&iupb_id='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_copy_brand"  class="ui-button-text icon-save" >Reject</button>';

                        $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/copy_brand?action=confirm&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&iupb_id='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_copy_brand"  class="ui-button-text icon-save" >Confirm</button>';

                        

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
                        
                        $arrDept = explode(',',$act['vDept_assigned'] );

                        $arrTeam = explode(',',$this->team);

                        $arrTeamID = explode(',',$this->teamID);
                        $upbTeamID = $this->lib_plc->upbTeam($iupb_id);

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


                $buttons['update'] = $sButton;        
                
            

            
        }
        
        return $buttons;
    }

    function manipulate_insert_button($buttons, $rowData) { 
        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $js = $this->load->view('js/copy_brand_js');

        $iframe = '<iframe name="copy_brand_frame" id="copy_brand_frame" height="0" width="0"></iframe>';
        
        $save_draft = '<button onclick="javascript:copy_brand_btn_multiupload(\'copy_brand\', \' '.base_url().'processor/plc/copy_brand?draft=true \',this,true )"  id="button_save_draft_copy_brand"  class="ui-button-text icon-save" >Copy Brand</button>';

        $AuthModul = $this->lib_plc->getAuthorModul($this->modul_id);
        $arrTeam = explode(',',$this->team);
        $nipAuthor = explode(',', $AuthModul['vNip_author']);

        if( in_array($AuthModul['vDept_author'],$arrTeam )  || in_array($this->user->gNIP, $nipAuthor)  ){

            $buttons['save'] = $iframe.$save_draft.$js;
        }else{
            unset($buttons['save']);
            $buttons['save'] = '<span style="color:red;" title="'.$AuthModul['vDept_author'].'">You\'re Dept not Authorized</span>';
        }
        
        
        return $buttons;
    }

    /*Manipulate Insert/Update Form*/
    function insertBox_copy_brand_form_detail($field,$id){
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
                var sebelum = $("label[for=\''.$this->url.'_form_detail\']").parent();
                $("label[for=\''.$this->url.'_form_detail\']").remove();
                sebelum.attr("id","'.$id.'");
                sebelum.html("");
                sebelum.removeAttr("class");
                sebelum.removeAttr("style");
                $.ajax({
                    url: base_url+"processor/'.$this->urlpath.'?action=getFormDetail&formaction=addnew&'.$g.'",
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

    function updateBox_copy_brand_form_detail($field,$id,$value,$rowData){
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
            var sebelum = $("label[for=\''.$this->url.'_form_detail\']").parent();
            $("label[for=\''.$this->url.'_form_detail\']").remove();
            sebelum.attr("id","'.$id.'");
            sebelum.html("");
            sebelum.removeAttr("class");
            sebelum.removeAttr("style");
            $.ajax({
                url: base_url+"processor/'.$this->urlpath.'?action=getFormDetail&formaction=update&'.$g.'",
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
    /*Function Tambahan*/
    function getFormDetail(){
        $post=$this->input->post();
        $get=$this->input->get();
        $logged_nip = $this->user->gNIP;
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
                    $data_field['tabel_file']= $form_field['vTabel_file'] ;
                    $data_field['tabel_file_pk']= $this->main_table_pk;
                    $data_field['tabel_file_pk_id']= $form_field['vTabel_file_pk_id'] ;

                    $path = 'files/plc/dok_tambah';
                    $createname_space =$this->url;
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

                if ($form_field['iRequired']==1) {
                    $data_field['field_required']= 'required';
                }else{
                    $data_field['field_required']= '';
                }


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

                $hate_emel .=' <input type="hidden" id="nip_login" name="logged_nip" value="'.$logged_nip.'">';
            }

        }else{
            $hate_emel .='Field belum disetting';
        }

        $hate_emel .= '<input type="hidden" name="isdraft" id="isdraft">';
        
        $data["html"] .= $hate_emel;
        return json_encode($data);
    }


}
