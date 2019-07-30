<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class migrasi_data extends MX_Controller {
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


        $this->title = 'Migrasi Data';
        $this->url = 'migrasi_data';
        $this->urlpath = 'plc/'.str_replace("_","/", $this->url);

        $this->maintable = 'plc2.plc2_upb';  
        $datagrid['islist'] = array(
                                        'vupb_nomor' => array('label'=>'No UPB','width'=>75,'align'=>'center','search'=>true)
                                        ,'vupb_nama' => array('label'=>'Nama UPB','width'=>300,'align'=>'left','search'=>true)
                                        ,'ttanggal' => array('label'=>'Tanggal UPB','width'=>100,'align'=>'center','search'=>false)
                                        ,'vgenerik' => array('label'=>'Nama Generik','width'=>300,'align'=>'left','search'=>true)
                                        ,'ikategori_id' => array('label'=>'Kategori Produk','width'=>100,'align'=>'center','search'=>true)
                                        ,'ikategoriupb_id' => array('label'=>'Kategori UPB','width'=>100,'align'=>'center','search'=>true)
                                        ,'isediaan_id' => array('label'=>'Sediaan Produk','width'=>150,'align'=>'center','search'=>true)
                                    );
        $datagrid['shortBy']=array('iupb_id'=>'Desc');

        

        $datagrid['setQuery']=array(
                                0=>array('vall'=>'plc2_upb.ldeleted','nilai'=>0)
                              #  1=>array('vall'=>'plc2_upb.iupb_id_ref != 0','nilai'=> NULL)
                                
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
        // $grid->setGroupBy($this->setGroupBy);
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
            case 'getProsesKopiModul':
                print_r($_GET);
                //Array ( [action] => getProsesKopiModul [modul] => 1 ) 
                echo $this->migrasiModul($_GET['modul']);
                break;
            case 'getProsesKopi':
                //echo $this->getProsesMigrasi();
                echo $this->loopAjah();
                
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

    function getModulActivities($modul_id){
        $sql_get_flow_modul_activity = '
        select *
        from plc3.m_modul a
                JOIN plc3.m_modul_activity b ON b.iM_modul=a.iM_modul
                JOIN plc3.m_activity c ON c.iM_activity=b.iM_activity
                where a.lDeleted=0
                and b.lDeleted=0
                and a.iM_modul = "'.$modul_id.'"
                
                '; 
                
        $dAlurs = $this->db->query($sql_get_flow_modul_activity)->result_array();
        return $dAlurs;

    }
    function migrasiModul($modul_id){ 
        /* getactivities */
        $activities = $this->getModulActivities($modul_id); 
        
        switch ($modul_id){
            case '26':
            echo 'Skala Trial';
            
                /* dapatkan semua data */
                $sql ='SELECT a.iformula_apppd,a.tformula_apppd,a.vformula_nip_apppd,a.iSubmit,a.* 
                        FROM plc2.plc2_upb_formula a 
                        WHERE a.ldeleted=0
                        AND a.iformula_apppd <> 0
                    ';
                    echo '<pre>'.$sql;
                    print_r($activities);
                    //exit;
                $datas = $this->db->query($sql)->result_array();
                //print_r($datas);
                /* looping agar semua header approval dimasukkan ke Log*/
                foreach ($datas as $data){
                    /* $what = $data['iappbusdev'];
                    $when = $data['tappbusdev'];
                    $who  = $data['cappbusdev'];
                    $why  = $data['remarkbusdev']; */
                    $iKey  = $data['ifor_id'];
                    
                    
                    /* get upb on detail setting prioritas */
                    
                        $arrUPB[] = $data['iupb_id'] ;
                        
                    


                    foreach ($activities as $activity){
                        $iM_activity = $activity['iM_activity'];
                        $iSort       = $activity['iSort'];
                        $idprivi_modules = $activity['idprivi_modules'];
                        

                        /* $what = $data[$activity['vFieldName']];
                        $when = $data[$activity['dFieldName']];
                        $who  = $data[$activity['cFieldName']];
                        $why  = $data[$activity['tFieldName']]; */

                        
                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) > 0 ){
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> Bawah ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }


                    }

                    $arrUPB= array();

                    
                    
                }


            break;
            case '36':
            echo 'Stress Test';
            
                /* dapatkan semua data */
                $sql ='SELECT a.iformula_apppd,a.tformula_apppd,a.vformula_nip_apppd,a.iSubmit,a.* 
                        FROM plc2.plc2_upb_formula a 
                        WHERE a.ldeleted=0
                        AND a.iformula_apppd <> 0
                    ';
                    echo '<pre>'.$sql;
                    print_r($activities);
                    //exit;
                $datas = $this->db->query($sql)->result_array();
                //print_r($datas);
                /* looping agar semua header approval dimasukkan ke Log*/
                foreach ($datas as $data){
                    /* $what = $data['iappbusdev'];
                    $when = $data['tappbusdev'];
                    $who  = $data['cappbusdev'];
                    $why  = $data['remarkbusdev']; */
                    $iKey  = $data['ifor_id'];
                    
                    
                    /* get upb on detail setting prioritas */
                    
                        $arrUPB[] = $data['iupb_id'] ;
                        
                    


                    foreach ($activities as $activity){
                        $iM_activity = $activity['iM_activity'];
                        $iSort       = $activity['iSort'];
                        $idprivi_modules = $activity['idprivi_modules'];
                        

                        /* $what = $data[$activity['vFieldName']];
                        $when = $data[$activity['dFieldName']];
                        $who  = $data[$activity['cFieldName']];
                        $why  = $data[$activity['tFieldName']]; */

                        
                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) > 0 ){
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> Bawah ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }


                    }

                    $arrUPB= array();

                    
                    
                }


            break;
            case '37':
            echo 'Skala Lab';
            
                /* dapatkan semua data */
                $sql ='SELECT a.iformula_apppd,a.tformula_apppd,a.vformula_nip_apppd,a.iSubmit,a.* 
                        FROM plc2.plc2_upb_formula a 
                        WHERE a.ldeleted=0
                        #AND a.iformula_apppd <> 0
                    ';
                    echo '<pre>'.$sql;
                    print_r($activities);
                    //exit;
                $datas = $this->db->query($sql)->result_array();
                //print_r($datas);
                /* looping agar semua header approval dimasukkan ke Log*/
                foreach ($datas as $data){
                    /* $what = $data['iappbusdev'];
                    $when = $data['tappbusdev'];
                    $who  = $data['cappbusdev'];
                    $why  = $data['remarkbusdev']; */
                    $iKey  = $data['ifor_id'];
                    
                    
                    /* get upb on detail setting prioritas */
                    
                        $arrUPB[] = $data['iupb_id'] ;
                        
                    


                    foreach ($activities as $activity){
                        $iM_activity = $activity['iM_activity'];
                        $iSort       = $activity['iSort'];
                        $idprivi_modules = $activity['idprivi_modules'];
                        

                        /* $what = $data[$activity['vFieldName']];
                        $when = $data[$activity['dFieldName']];
                        $who  = $data[$activity['cFieldName']];
                        $why  = $data[$activity['tFieldName']]; */

                        
                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) > 0 ){
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> Bawah ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }


                    }

                    $arrUPB= array();

                    
                    
                }


            break;
            case '38':
            echo 'Stabilita Lab';
            
                /* dapatkan semua data */
                $sql ='SELECT formula_stabilita.vNo_formula AS formula_stabilita__vNo_formula, formula_stabilita.iKesimpulanStabilita 
                        , formula_stabilita.iFormula 
                        , formula_stabilita.iApp_formula , 
                        formula_stabilita.cApp_formula , 
                        formula_stabilita.dApp_formula , 
                        formula_stabilita.vApp_formula , 
                        `formula_process`.`iupb_id`, plc2_upb.vupb_nomor AS plc2_upb__vupb_nomor, plc2_upb.vupb_nama AS plc2_upb__vupb_nama, /*kesimpulan_stabilita/kesimpulan_stabilita.php/output*/pddetail.formula_process.*
                        FROM (`pddetail`.`formula_process`)
                        INNER JOIN `pddetail`.`formula_process_detail` ON `formula_process_detail`.`iFormula_process` = `formula_process`.`iFormula_process`
                        INNER JOIN `pddetail`.`formula_stabilita` ON `formula_stabilita`.`iFormula_process` = `formula_process`.`iFormula_process`
                        INNER JOIN `plc2`.`plc2_upb` ON `plc2_upb`.`iupb_id` = `formula_process`.`iupb_id`
                        WHERE `formula_process_detail`.`lDeleted` = "0" 
                        AND `formula_stabilita`.`lDeleted` = "0" 
                        AND `formula_process`.`lDeleted` = "0" 
                        AND `formula_process`.`iMaster_flow` IN (6,7,8) 
                        GROUP BY iupb_id, formula_stabilita.iVersi
                        ORDER BY `iFormula_process` desc
                        #AND a.iformula_apppd <> 0
                    ';
                    echo '<pre>'.$sql;
                    print_r($activities);
                    //exit;
                $datas = $this->db->query($sql)->result_array();
                //print_r($datas);
                /* looping agar semua header approval dimasukkan ke Log*/
                foreach ($datas as $data){
                    /* $what = $data['iappbusdev'];
                    $when = $data['tappbusdev'];
                    $who  = $data['cappbusdev'];
                    $why  = $data['remarkbusdev']; */
                    $iKey  = $data['iFormula'];
                    
                    
                    /* get upb on detail setting prioritas */
                    
                        $arrUPB[] = $data['iupb_id'] ;
                        
                    


                    foreach ($activities as $activity){
                        $iM_activity = $activity['iM_activity'];
                        $iSort       = $activity['iSort'];
                        $idprivi_modules = $activity['idprivi_modules'];
                        

                        /* $what = $data[$activity['vFieldName']];
                        $when = $data[$activity['dFieldName']];
                        $who  = $data[$activity['cFieldName']];
                        $why  = $data[$activity['tFieldName']]; */

                        
                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) > 0 ){
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> Bawah ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }


                    }

                    $arrUPB= array();

                    
                    
                }


            break;
            case '34':
            echo 'Approval KSK';
            
                /* dapatkan semua data */
                    $sql ='SELECT 
                    plc2_upb.iupb_id as upebeh,
                    plc2_upb_ro_detail.irodet_id,
                    plc2_upb_ro_detail.iappqa_ksk,
                    plc2_upb_ro_detail.*
                    FROM (`plc2`.`plc2_upb_ro_detail`)
                    LEFT JOIN `plc2`.`plc2_upb_po` ON `plc2`.`plc2_upb_po`.`ipo_id` = `plc2`.`plc2_upb_ro_detail`.`ipo_id`
                    INNER JOIN `plc2`.`plc2_raw_material` ON `plc2_raw_material`.`raw_id`=`plc2_upb_ro_detail`.`raw_id`
                    INNER JOIN `plc2`.`plc2_upb_ro` ON `plc2`.`plc2_upb_ro`.`iro_id` = `plc2`.`plc2_upb_ro_detail`.`iro_id`
                    INNER JOIN `plc2`.`plc2_upb_request_sample` ON `plc2`.`plc2_upb_request_sample`.`ireq_id` = `plc2`.`plc2_upb_ro_detail`.`ireq_id`
                    INNER JOIN `plc2`.`plc2_upb` ON `plc2`.`plc2_upb`.`iupb_id` = `plc2`.`plc2_upb_request_sample`.`iupb_id`
                    WHERE `plc2_upb_ro_detail`.`ldeleted` =  0
                    AND `plc2_upb`.`iupb_id` IN 
                    (select m_modul_log_upb.iupb_id 
                    from plc3.m_modul_log_upb
                    JOIN plc3.m_modul_log_activity on m_modul_log_activity.iM_modul_log_activity=m_modul_log_upb.iM_modul_log_activity
                    where m_modul_log_upb.lDeleted=0 
                    AND m_modul_log_activity.idprivi_modules IN (3591,3339))
                    GROUP BY irodet_id
                    ORDER BY `plc2_upb_ro_detail`.`irodet_id` desc
                
                    ';
                    echo '<pre>'.$sql;
                    //print_r($activities);
                    //exit;
                $datas = $this->db->query($sql)->result_array();
                //print_r($datas);
                /* looping agar semua header approval dimasukkan ke Log*/
                foreach ($datas as $data){
                    /* $what = $data['iappbusdev'];
                    $when = $data['tappbusdev'];
                    $who  = $data['cappbusdev'];
                    $why  = $data['remarkbusdev']; */
                    $iKey  = $data['irodet_id'];
                    
                    
                    /* get upb on detail setting prioritas */
                    
                        $arrUPB[] = $data['upebeh'] ;
                        
                    


                    foreach ($activities as $activity){
                        $iM_activity = $activity['iM_activity'];
                        $iSort       = $activity['iSort'];
                        $idprivi_modules = $activity['idprivi_modules'];
                        

                        /* $what = $data[$activity['vFieldName']];
                        $when = $data[$activity['dFieldName']];
                        $who  = $data[$activity['cFieldName']];
                        $why  = $data[$activity['tFieldName']]; */

                        
                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) > 0 ){
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> Bawah ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }


                    }

                    $arrUPB= array();

                    
                    
                }


            break;
            case '19':
            echo 'Basic Formula';
            
                /* dapatkan semua data */
                    $sql ='SELECT plc2_upb_formula.*,plc2_upb.iupb_id as upebeh
                    FROM (`plc2`.`plc2_upb_formula`)
                    INNER JOIN `plc2`.`plc2_upb` ON `plc2_upb`.`iupb_id`=`plc2_upb_formula`.`iupb_id`
                    INNER JOIN `pddetail`.`formula_process` ON `formula_process`.`iFormula_process`=`plc2_upb_formula`.`iFormula_process`
                    INNER JOIN (SELECT a.*
                     FROM pddetail.formula a
                     join pddetail.formula_process b on b.iFormula_process=a.iFormula_process
                     WHERE a.iFormula IN (
                     SELECT MAx(b1.iFormula)
                     FROM pddetail.formula b1
                     join pddetail.formula_process c1 on c1.iFormula_process=b1.iFormula_process
                     where c1.iMaster_flow=1
                     GROUP BY c1.iupb_id
                     )) as formula  ON `formula`.`iFormula_process`=`formula_process`.`iFormula_process`
                    WHERE `plc2_upb_formula`.`ldeleted` =  0
                    AND (
                     if(
                     plc2.plc2_upb.iCopy_brand = 0
                     ,
                     plc2_upb.iupb_id in (
                     select b.iupb_id 
                     from pddetail.formula_stabilita a 
                     join pddetail.formula_process b on a.iFormula_process=b.iFormula_process
                     where a.lDeleted=0
                     and b.lDeleted=0
                     and a.iKesimpulanStabilita=1
                     )
                     ,`plc2_upb_formula`.`ldeleted` = 0
                     
                     )
                    
                     )
                     
                    GROUP BY ifor_id
                    ORDER BY `plc2_upb`.`vupb_nomor` desc
                    
                
                    ';
                    echo '<pre>'.$sql;
                    //print_r($activities);
                    //exit;
                $datas = $this->db->query($sql)->result_array();
                //print_r($datas);
                /* looping agar semua header approval dimasukkan ke Log*/
                foreach ($datas as $data){
                    /* $what = $data['iappbusdev'];
                    $when = $data['tappbusdev'];
                    $who  = $data['cappbusdev'];
                    $why  = $data['remarkbusdev']; */
                    $iKey  = $data['ifor_id'];
                    
                    
                    /* get upb on detail setting prioritas */
                    
                        $arrUPB[] = $data['upebeh'] ;
                        
                    


                    foreach ($activities as $activity){
                        $iM_activity = $activity['iM_activity'];
                        $iSort       = $activity['iSort'];
                        $idprivi_modules = $activity['idprivi_modules'];
                        

                        /* $what = $data[$activity['vFieldName']];
                        $when = $data[$activity['dFieldName']];
                        $who  = $data[$activity['cFieldName']];
                        $why  = $data[$activity['tFieldName']]; */

                        
                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) > 0 ){
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> Bawah ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }


                    }

                    $arrUPB= array();

                    
                    
                }


            break;
            case '13':
            echo 'Pembuatan MBR';
            
                /* dapatkan semua data */
                    $sql ='SELECT plc2_upb_buat_mbr.*,plc2_upb.iupb_id AS upebeh
                    FROM (`plc2`.`plc2_upb_buat_mbr`)
                    INNER JOIN `plc2`.`plc2_upb_formula` ON `plc2_upb_formula`.`ifor_id`=`plc2_upb_buat_mbr`.`ifor_id`
                    INNER JOIN `plc2`.`plc2_upb` ON `plc2_upb`.`iupb_id`=`plc2_upb_formula`.`iupb_id`
                    INNER JOIN `pddetail`.`formula_process` ON `formula_process`.`iupb_id`=`plc2_upb_formula`.`iupb_id`
                    INNER JOIN `pddetail`.`formula` ON `formula`.`iFormula_process`=`formula_process`.`iFormula_process`
                    WHERE `plc2_upb_formula`.`ldeleted` =  0
                    GROUP BY ibuatmbr_id
                    ORDER BY `plc2_upb`.`vupb_nomor` desc
                    
                
                    ';
                    echo '<pre>'.$sql;
                    //print_r($activities);
                    //exit;
                $datas = $this->db->query($sql)->result_array();
                //print_r($datas);
                /* looping agar semua header approval dimasukkan ke Log*/
                foreach ($datas as $data){
                    /* $what = $data['iappbusdev'];
                    $when = $data['tappbusdev'];
                    $who  = $data['cappbusdev'];
                    $why  = $data['remarkbusdev']; */
                    $iKey  = $data['ibuatmbr_id'];
                    
                    
                    /* get upb on detail setting prioritas */
                    
                        $arrUPB[] = $data['upebeh'] ;
                        
                    


                    foreach ($activities as $activity){
                        $iM_activity = $activity['iM_activity'];
                        $iSort       = $activity['iSort'];
                        $idprivi_modules = $activity['idprivi_modules'];
                        

                        /* $what = $data[$activity['vFieldName']];
                        $when = $data[$activity['dFieldName']];
                        $who  = $data[$activity['cFieldName']];
                        $why  = $data[$activity['tFieldName']]; */

                        
                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) > 0 ){
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> Bawah ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }


                    }

                    $arrUPB= array();

                    
                    
                }


            break;
            
            case '45':
            echo 'Produksi Pilot';
            
                /* dapatkan semua data */
                    $sql ='SELECT plc2_upb_prodpilot.*,plc2_upb.iupb_id AS upebeh
                    FROM (`plc2`.`plc2_upb_prodpilot`)
                    INNER JOIN `plc2`.`plc2_upb_formula` ON `plc2_upb_formula`.`ifor_id`=`plc2_upb_prodpilot`.`ifor_id`
                    INNER JOIN `plc2`.`plc2_upb` ON `plc2_upb`.`iupb_id`=`plc2_upb_formula`.`iupb_id`
                    INNER JOIN `pddetail`.`formula_process` ON `formula_process`.`iFormula_process`=`plc2_upb_formula`.`iFormula_process`
                    INNER JOIN `pddetail`.`formula` ON `formula`.`iFormula_process`=`formula_process`.`iFormula_process`
                    WHERE `plc2_upb_prodpilot`.`ldeleted` =  0
                    GROUP BY iprodpilot_id
                    ORDER BY `plc2_upb`.`vupb_nomor` desc
                    
                
                    ';
                    echo '<pre>'.$sql;
                    //print_r($activities);
                    //exit;
                $datas = $this->db->query($sql)->result_array();
                //print_r($datas);
                /* looping agar semua header approval dimasukkan ke Log*/
                foreach ($datas as $data){
                    /* $what = $data['iappbusdev'];
                    $when = $data['tappbusdev'];
                    $who  = $data['cappbusdev'];
                    $why  = $data['remarkbusdev']; */
                    $iKey  = $data['iprodpilot_id'];
                    
                    
                    /* get upb on detail setting prioritas */
                    
                        $arrUPB[] = $data['upebeh'] ;
                        
                    


                    foreach ($activities as $activity){
                        $iM_activity = $activity['iM_activity'];
                        $iSort       = $activity['iSort'];
                        $idprivi_modules = $activity['idprivi_modules'];
                        

                        /* $what = $data[$activity['vFieldName']];
                        $when = $data[$activity['dFieldName']];
                        $who  = $data[$activity['cFieldName']];
                        $why  = $data[$activity['tFieldName']]; */

                        
                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) > 0 ){
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> Bawah ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }


                    }

                    $arrUPB= array();

                    
                    
                }


            break;

            case '43':
            echo 'Stabilita Pilot';
            
                /* dapatkan semua data */
                    $sql ='SELECT formula_process.*
                    ,pddetail.formula_stabilita.iApp_formula
                    ,pddetail.formula_stabilita.cApp_formula
                    ,pddetail.formula_stabilita.dApp_formula
                    ,pddetail.formula_stabilita.vApp_formula
                    FROM (`pddetail`.`formula_process`)
                    INNER JOIN `pddetail`.`formula_process_detail` ON `formula_process_detail`.`iFormula_process` = `formula_process`.`iFormula_process`
                    INNER JOIN `pddetail`.`formula_stabilita` ON `formula_stabilita`.`iFormula_process` = `formula_process`.`iFormula_process`
                    INNER JOIN `plc2`.`plc2_upb` ON `plc2_upb`.`iupb_id` = `formula_process`.`iupb_id`
                    WHERE `formula_process_detail`.`lDeleted` = "0" 
                    AND `formula_stabilita`.`lDeleted` = "0" 
                    AND `formula_process`.`lDeleted` = "0" 
                    AND `formula_process`.`iMaster_flow` IN (9,10,11) 
                    AND `plc2_upb`.`iteampd_id` IN(5,2,69,2,94) 
                    GROUP BY iupb_id, formula_stabilita.iVersi
                    ORDER BY `iFormula_process` desc
                    
                
                    ';
                    echo '<pre>'.$sql;
                    //print_r($activities);
                    //exit;
                $datas = $this->db->query($sql)->result_array();
                //print_r($datas);
                /* looping agar semua header approval dimasukkan ke Log*/
                foreach ($datas as $data){
                    /* $what = $data['iappbusdev'];
                    $when = $data['tappbusdev'];
                    $who  = $data['cappbusdev'];
                    $why  = $data['remarkbusdev']; */
                    $iKey  = $data['iFormula_process'];
                    
                    
                    /* get upb on detail setting prioritas */
                    
                        $arrUPB[] = $data['iupb_id'] ;
                        
                    


                    foreach ($activities as $activity){
                        $iM_activity = $activity['iM_activity'];
                        $iSort       = $activity['iSort'];
                        $idprivi_modules = $activity['idprivi_modules'];
                        

                        /* $what = $data[$activity['vFieldName']];
                        $when = $data[$activity['dFieldName']];
                        $who  = $data[$activity['cFieldName']];
                        $why  = $data[$activity['tFieldName']]; */

                        
                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) > 0 ){
                           $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> Bawah ID Formula Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }


                    }

                    $arrUPB= array();

                    
                    
                }


            break;

            case '2':
                /* setting prioritas */
                
            
                /* dapatkan semua header setting prioritas */
                $sql ='SELECT * 
                    FROM plc2.plc2_upb_prioritas a 
                    WHERE a.ldeleted=0 
                    AND a.iappbusdev in(2,0)
                    AND a.iyear <> 0
                    AND a.iteambusdev_id <> 5
                    and a.iprioritas_id <> 5
                    ORDER BY a.iyear
                    ';
                $datas = $this->db->query($sql)->result_array();
                //print_r($datas);
                /* looping agar semua header approval dimasukkan ke Log*/
                foreach ($datas as $data){
                    /* $what = $data['iappbusdev'];
                    $when = $data['tappbusdev'];
                    $who  = $data['cappbusdev'];
                    $why  = $data['remarkbusdev']; */
                    $iKey  = $data['iprioritas_id'];
                    
                    

                    foreach ($activities as $activity){
                        $iM_activity = $activity['iM_activity'];
                        $iSort       = $activity['iSort'];
                        $idprivi_modules = $activity['idprivi_modules'];
                        if($iSort == 1){
                            /* submit setting prioritas */
                            $what = $data['iSubmit'];
                            $when = $data['tupdate'];
                            $who  = $data['cnip'];
                            $why  = '-';
                        
                        }else{
                            /* approval */
                            $what = $data['iappbusdev'];
                            $when = $data['tappbusdev'];
                            $who  = $data['cappbusdev'];
                            $why  = $data['remarkbusdev'];

                        }


                        /* get upb on detail setting prioritas */
                        $sqlUpbs = '
                                    SELECT * 
                                    FROM plc2.plc2_upb_prioritas a 
                                    JOIN plc2.plc2_upb_prioritas_detail b ON b.iprioritas_id=a.iprioritas_id
                                    WHERE a.ldeleted=0 
                                    AND a.iprioritas_id= "'.$iKey.'"
                                    AND b.ldeleted=0
                                    group by b.iupb_id
                        ';
                        //echo $sqlUpbs;
                        $upbs = $this->db->query($sqlUpbs)->result_array();
                        //print_r($upbs);
                        $i=1;
                        foreach ($upbs as $upb){
                            
                            $arrUPB[] = $upb['iupb_id'] ;
                            $i++;
                        }

                        
                        $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                        //print_r($arrUPB);
                        //exit;
                    }

                    
                    
                }


            break;

            case '11':
            echo 'oke';
            
                /* Input Sample Originator */
                
            
                /* dapatkan semua data */
                $sql ='SELECT * 
                    , IF(a.dTanggalKirimBD IS NULL,2,NULL)  AS iBD
                    , IF(a.dTanggalTerimaPD IS NULL,2,NULL)  AS iPD
                    , IF(a.dTanggalTerimaAD IS NULL,2,NULL)  AS iAD
                    , IF(a.dTanggalTerimaQA IS NULL,2,NULL)  AS iQA
                        FROM plc2.plc2_upb_date_sample a 
                        JOIN plc2.plc2_upb_request_originator b ON b.ireq_ori_id=a.iReq_ori_id
                        WHERE b.ldeleted=0
                        and b.iupb_id not in (2140)
                    ';
                    /* echo '<pre>'.$sql;
                    print_r($activities);
                    exit; */
                $datas = $this->db->query($sql)->result_array();
                //print_r($datas);
                /* looping agar semua header approval dimasukkan ke Log*/
                foreach ($datas as $data){
                    /* $what = $data['iappbusdev'];
                    $when = $data['tappbusdev'];
                    $who  = $data['cappbusdev'];
                    $why  = $data['remarkbusdev']; */
                    $iKey  = $data['ireq_ori_id'];
                    
                    
                    /* get upb on detail setting prioritas */
                    
                        $arrUPB[] = $data['iupb_id'] ;
                        
                    


                    foreach ($activities as $activity){
                        $iM_activity = $activity['iM_activity'];
                        $iSort       = $activity['iSort'];
                        $idprivi_modules = $activity['idprivi_modules'];
                        

                        $what = $data[$activity['vFieldName']];
                        $when = $data[$activity['dFieldName']];
                        $who  = $data[$activity['cFieldName']];
                        $why  = $data[$activity['tFieldName']];

                        
                        //print_r($arrUPB);
                        
                        $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                        print_r($arrUPB);
                        //exit;
                    }

                    $arrUPB= array();

                    
                    
                }


            break;

            case 51:
                //modul pembuatan po sample

                //mendapatkan data header
                $datas = $this->db->get_where('plc2.plc2_upb_po', array('ldeleted' => 0))->result_array();
                foreach ($datas as $data) {
                    $iKey       = $data['ipo_id'];

                    //mendapatkan upb yang ada di detail
                    $sqlDet     = 'SELECT re.iupb_id FROM plc2.plc2_upb_po_detail po 
                                    JOIN plc2.plc2_upb_request_sample re ON po.ireq_id = re.ireq_id
                                    JOIN plc2.plc2_upb u ON re.iupb_id = u.iupb_id
                                    WHERE po.ldeleted = 0 AND po.ipo_id = ? AND u.itipe_id <> 6
                                    GROUP BY re.iupb_id';
                    $details    = $this->db->query($sqlDet, array($iKey))->result_array();
                    $arrUPB     = array();
                    foreach ($details as $detail) {
                        $upb    = $detail['iupb_id'];
                        if (!in_array($upb, $arrUPB)){
                            array_push($arrUPB, $upb);
                        }
                    }

                    foreach ($activities as $activity){
                        $iM_activity        = $activity['iM_activity'];
                        $iSort              = $activity['iSort'];
                        $idprivi_modules    = $activity['idprivi_modules'];
                        

                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) >= 1 ){
                            $what   = ( $iM_activity == 1 ) ? 0 : $what;
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> ID No Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }

                        //exit;
                    }
                }

                break;

            case 23:
                //modul penerimaan sample dari supplier

                //mendapatkan data header
                $datas = $this->db->get_where('plc2.plc2_upb_ro', array('ldeleted' => 0))->result_array();
                foreach ($datas as $data) {
                    $iKey       = $data['iro_id'];

                    //mendapatkan upb yang ada di detail
                    $sqlDet     = 'SELECT re.iupb_id FROM plc2.plc2_upb_ro_detail ro 
                                    JOIN plc2.plc2_upb_request_sample re ON ro.ireq_id = re.ireq_id
                                    JOIN plc2.plc2_upb u ON re.iupb_id = u.iupb_id
                                    WHERE ro.ldeleted = 0 AND ro.iro_id = ? AND u.itipe_id <> 6
                                    GROUP BY re.iupb_id';
                    $details    = $this->db->query($sqlDet, array($iKey))->result_array();
                    $arrUPB     = array();
                    foreach ($details as $detail) {
                        $upb    = $detail['iupb_id'];
                        if (!in_array($upb, $arrUPB)){
                            array_push($arrUPB, $upb);
                        }
                    }

                    foreach ($activities as $activity){
                        $iM_activity        = $activity['iM_activity'];
                        $iSort              = $activity['iSort'];
                        $idprivi_modules    = $activity['idprivi_modules'];
                        

                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) >= 1 ){
                            $what   = ( $iM_activity == 1 ) ? 0 : $what;
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> ID No Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }

                        //exit;
                    }
                }
                break;

            case 27:
                //modul analisa & release bb

                //mendapatkan data header
                $sql    = 'SELECT re.iupb_id, ro.* FROM plc2.plc2_upb_ro_detail ro 
                            JOIN plc2.plc2_upb_request_sample re ON ro.ireq_id = re.ireq_id
                            JOIN plc2.plc2_upb u ON re.iupb_id = u.iupb_id
                            WHERE ro.ldeleted = 0 AND u.itipe_id <> 6';
                $datas  = $this->db->query($sql)->result_array();
                foreach ($datas as $data) {
                    $iKey       = $data['irodet_id'];
                    $arrUPB     = array();
                    array_push($arrUPB, $data['iupb_id']);

                    foreach ($activities as $activity){
                        $iM_activity        = $activity['iM_activity'];
                        $iSort              = $activity['iSort'];
                        $idprivi_modules    = $activity['idprivi_modules'];
                        

                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) >= 1 ){
                            $what   = ( $iM_activity == 1 ) ? 0 : $what;
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> ID No Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }

                        //exit;
                    }
                }
                break;

            case 25:
                //modul terima sample bahan baku

                //mendapatkan data header
                $arrKeyStat     = array(1 => 'isubmit_pd', 2 => 'isubmit_qc', 3 => 'isubmit_qa');
                $arrKeyDate     = array(1 => 'trec_date_pd', 2 => 'trec_date_qc', 3 => 'trec_date_qa');
                $arrKeyNip      = array(1 => 'vrec_nip_pd', 2 => 'vrec_nip_qc', 3 => 'vrec_nip_qa');
                $sql            = 'SELECT ro.irodet_id, re.iupb_id, 
                                        ro.trec_date_pd, ro.trec_date_qc, ro.trec_date_qa, 
                                        ro.vrec_nip_pd, ro.vrec_nip_qc, ro.vrec_nip_qa,
                                        IF(ro.trec_date_pd IS NOT NULL, 1, 0) AS isubmit_pd,
                                        IF(ro.trec_date_qc IS NOT NULL, 1, 0) AS isubmit_qc,
                                        IF(ro.trec_date_qa IS NOT NULL, 1, 0) AS isubmit_qa 
                                    FROM plc2.plc2_upb_ro_detail ro 
                                    JOIN plc2.plc2_upb_request_sample re ON ro.ireq_id = re.ireq_id
                                    JOIN plc2.plc2_upb u ON re.iupb_id = u.iupb_id
                                    WHERE ro.ldeleted = 0 AND u.itipe_id <> 6';
                $datas          = $this->db->query($sql)->result_array();
                foreach ($datas as $data) {
                    $iKey       = $data['irodet_id'];
                    $arrUPB     = array();
                    array_push($arrUPB, $data['iupb_id']);

                    foreach ($activities as $activity){
                        $iM_activity        = $activity['iM_activity'];
                        $iSort              = $activity['iSort'];
                        $idprivi_modules    = $activity['idprivi_modules'];
                        

                        $what   = $data[$arrKeyStat[$iSort]];
                        $when   = $data[$arrKeyDate[$iSort]];
                        $who    = $data[$arrKeyNip[$iSort]];
                        $why    = '-';
                        
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) >= 1 ){
                            $what   = ( $iM_activity == 1 ) ? 0 : $what;
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> ID No Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }

                        //exit;
                    }
                }
                break;

            case 33:
                //modul uji mikro bahan baku

                //mendapatkan data header
                $sql    = 'SELECT u.iupb_id, bb.* FROM plc2.uji_mikro_bb bb 
                            JOIN plc2.plc2_upb_request_sample_detail rd ON bb.ireqdet_id = rd.ireqdet_id
                            JOIN plc2.plc2_upb_request_sample rs ON rd.ireq_id = rs.ireq_id
                            JOIN plc2.plc2_upb u ON rs.iupb_id = u.iupb_id
                            WHERE bb.lDeleted = 0 AND u.itipe_id <> 6';
                $datas  = $this->db->query($sql)->result_array();
                foreach ($datas as $data) {
                    $iKey       = $data['iuji_mikro_bb'];
                    $arrUPB     = array();
                    array_push($arrUPB, $data['iupb_id']);

                    foreach ($activities as $activity){
                        $iM_activity        = $activity['iM_activity'];
                        $iSort              = $activity['iSort'];
                        $idprivi_modules    = $activity['idprivi_modules'];
                        
                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) >= 1 ){
                            $what   = ( $iM_activity == 1 ) ? 0 : $what;
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> ID No Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }

                        //exit;
                    }
                }
                break;

            case 35:
                //modul soi mikro bb final

                //mendapatkan data header
                $sql    = 'SELECT u.iupb_id, bb.* FROM plc2.uji_mikro_bb bb 
                            JOIN plc2.plc2_upb_request_sample_detail rd ON bb.ireqdet_id = rd.ireqdet_id
                            JOIN plc2.plc2_upb_request_sample rs ON rd.ireq_id = rs.ireq_id
                            JOIN plc2.plc2_upb u ON rs.iupb_id = u.iupb_id
                            WHERE bb.lDeleted = 0 AND u.itipe_id <> 6';
                $datas  = $this->db->query($sql)->result_array();
                foreach ($datas as $data) {
                    $iKey       = $data['iuji_mikro_bb'];
                    $arrUPB     = array();
                    array_push($arrUPB, $data['iupb_id']);

                    foreach ($activities as $activity){
                        $iM_activity        = $activity['iM_activity'];
                        $iSort              = $activity['iSort'];
                        $idprivi_modules    = $activity['idprivi_modules'];
                        
                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) >= 1 ){
                            $what   = ( $iM_activity == 1 ) ? 0 : $what;
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> ID No Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }

                        //exit;
                    }
                }
                break;

            case 39:
                //modul uji mikro fg non steril

                //mendapatkan data header
                $sql    = 'SELECT u.iupb_id, m.* FROM plc2.mikro_fg m 
                            JOIN plc2.plc2_upb_formula f ON m.ifor_id = f.ifor_id
                            JOIN plc2.plc2_upb u ON f.iupb_id = u.iupb_id
                            WHERE m.lDeleted = 0 AND u.itipe_id <> 6';
                $datas  = $this->db->query($sql)->result_array();
                foreach ($datas as $data) {
                    $iKey       = $data['imikro_fg_id'];
                    $arrUPB     = array();
                    array_push($arrUPB, $data['iupb_id']);

                    foreach ($activities as $activity){ print
                        $iM_activity        = $activity['iM_activity'];
                        $iSort              = $activity['iSort'];
                        $idprivi_modules    = $activity['idprivi_modules'];
                        
                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // echo "<br>";
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) >= 1 ){
                            $what   = ( $iM_activity == 1 ) ? 0 : $what;
                            $who    = ( empty($who) ) ? 'N17770' : $who;
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> ID No Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }

                        //exit;
                    }
                }
                break;

            case 52:
                //modul uji mikro fg steril
            
                //mendapatkan data header
                $sql    = 'SELECT u.iupb_id, m.* FROM plc2.mikro_fg m 
                            JOIN plc2.plc2_upb_formula f ON m.ifor_id = f.ifor_id
                            JOIN plc2.plc2_upb u ON f.iupb_id = u.iupb_id
                            WHERE m.lDeleted = 0 AND u.itipe_id <> 6';
                $datas  = $this->db->query($sql)->result_array();
                foreach ($datas as $data) {
                    $iKey       = $data['imikro_fg_id'];
                    $arrUPB     = array();
                    array_push($arrUPB, $data['iupb_id']);

                    foreach ($activities as $activity){ print
                        $iM_activity        = $activity['iM_activity'];
                        $iSort              = $activity['iSort'];
                        $idprivi_modules    = $activity['idprivi_modules'];
                        
                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // echo "<br>";
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) >= 1 ){
                            $what   = ( $iM_activity == 1 ) ? 0 : $what;
                            $who    = ( empty($who) ) ? 'N17770' : $who;
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> ID No Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }

                        //exit;
                    }
                }
                break;

            case 42:
                //modul soi mikro fg
            
                //mendapatkan data header
                $sql    = 'SELECT u.iupb_id, m.* FROM plc2.mikro_fg m 
                            JOIN plc2.plc2_upb_formula f ON m.ifor_id = f.ifor_id
                            JOIN plc2.plc2_upb u ON f.iupb_id = u.iupb_id
                            WHERE m.lDeleted = 0 AND u.itipe_id <> 6';
                $datas  = $this->db->query($sql)->result_array();
                foreach ($datas as $data) {
                    $iKey       = $data['imikro_fg_id'];
                    $arrUPB     = array();
                    array_push($arrUPB, $data['iupb_id']);

                    foreach ($activities as $activity){ print
                        $iM_activity        = $activity['iM_activity'];
                        $iSort              = $activity['iSort'];
                        $idprivi_modules    = $activity['idprivi_modules'];
                        
                        $what   = ( array_key_exists($activity['vFieldName'], $data) ) ? $data[$activity['vFieldName']] : 0;
                        $when   = ( array_key_exists($activity['dFieldName'], $data) ) ? $data[$activity['dFieldName']] : null;
                        $who    = ( array_key_exists($activity['cFieldName'], $data) ) ? $data[$activity['cFieldName']] : null;
                        $why    = ( array_key_exists($activity['tFieldName'], $data) ) ? $data[$activity['tFieldName']] : '-';
                        
                        // echo "<br>";
                        // print_r(array($what, $when, $who, $why));
                        
                        if ( !empty($what) && intval($what) >= 1 ){
                            $what   = ( $iM_activity == 1 ) ? 0 : $what;
                            $who    = ( empty($who) ) ? 'N17770' : $who;
                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$idprivi_modules,$iKey,$iM_activity,$iSort,$why,$what,$when,$who);
                            echo "<br> ID Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        } else {
                            echo "<br> ID No Log => ".$iKey.' || Status = '.$what.' ==> '.json_encode($arrUPB); 
                        }

                        //exit;
                    }
                }
                break;
            


            default:
            echo 'tidak ada modul';
            break;

        }
    }

    function loopAjah(){

        $sql = '
                    SELECT plc2.plc2_upb_master_kategori_upb.vkategori AS upb_kat, hrd.mnf_kategori.vkategori AS mnf_kat, `hrd`.`mnf_sediaan`.`vsediaan`, plc2.plc2_biz_process_type.vName AS nama_type, /*upb_daftar/upb_daftar.php/output*/plc2.plc2_upb.*
                    FROM (`plc2`.`plc2_upb`)
                    INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
                    INNER JOIN `hrd`.`mnf_kategori` ON `plc2`.`plc2_upb`.`ikategori_id`=`hrd`.`mnf_kategori`.`ikategori_id`
                    INNER JOIN `hrd`.`mnf_sediaan` ON `plc2`.`plc2_upb`.`isediaan_id`=`hrd`.`mnf_sediaan`.`isediaan_id`
                    INNER JOIN `plc2`.`plc2_biz_process_type` ON `plc2`.`plc2_upb`.`itipe_id`=`plc2`.`plc2_biz_process_type`.`idplc2_biz_process_type`
                    WHERE `plc2`.`plc2_upb`.`ldeleted` =  0
                    AND `plc2`.`plc2_upb`.`iKill` =  0
                    AND `plc2`.`plc2_upb`.`itipe_id` not in (6)
                    #and `plc2`.`plc2_upb`.`iupb_id`= 2565
                    GROUP BY iupb_id
                    ORDER BY `vupb_nomor` desc
                    #LIMIT 1700,100
        ';
        /* echo '<pre>'.$sql;
        exit; */
        $datas = $this->db->query($sql)->result_array();
        $i=1;
        foreach($datas as $datax){
            echo '<br>';
            echo 'ke - '.$i.' UPB '.$datax['iupb_id'];
            
            $this->getProsesMigrasi2($datax['iupb_id']);
            $i++;
        }

        echo 'Done';

        /* $data['status']  = true;
        $data['last_id'] = $_POST['iupb_id'];
        $data['message'] = 'Migrasi data Selesai';
        return json_encode($data); */

    }
    function getProsesMigrasi2($iupb_id){

        $iupb_id = $iupb_id;
        $vToken = $_POST['vToken'];

        $sql_get_flow_modul_activity = '
                select *
                from plc3.m_modul a
                join plc3.m_flow_proses b on b.iM_modul=a.iM_modul
                join plc3.m_flow c on c.iM_flow=b.iM_flow
                where a.lDeleted=0
                and b.lDeleted=0
                and c.lDeleted=0
                and a.iUsed_main_table = 1
                and a.iM_modul in( 49,24)
                order by b.iUrut
                #limit 1
        ';
        
        $dAlurs = $this->db->query($sql_get_flow_modul_activity)->result_array();
        //echo '<pre>'.$sql_get_flow_modul_activity;
        echo '<pre>';

        /* print_r($dAlurs); */
        

        foreach ($dAlurs as $alur) {
            $sql_get_activity   = 'select * from plc3.m_modul_activity a where a.lDeleted=0 and  a.iM_modul= "'.$alur['iM_modul'].'" ';
            /* echo $sql_get_activity;
            echo '<br>'; */
            
            $dActivity_modul    = $this->db->query($sql_get_activity)->result_array();
            $iUsed_main_table   = $alur['iUsed_main_table'];
            $vTable_name        = $alur['vTable_name'];
            $iM_modul           = $alur['iM_modul'];
            $modul_id           = $alur['idprivi_modules'];
            
            
                
                foreach ($dActivity_modul as $dAct) {
                    
                   $flagApp     = $dAct['vFieldName'];
                   $iM_activity = $dAct['iM_activity'];
                   $iSort       = $dAct['iSort'];
                    if ($vTable_name <> '' and $flagApp <> '') {
                        
                        if($iUsed_main_table == 1){
                            /* jika upb digunakan di main table */
                            $selPK = "SHOW KEYS FROM ".$vTable_name." WHERE Key_name = 'PRIMARY' ";
                            $dPeka = $this->db->query($selPK)->row_array();
                            $vCode_key = $dPeka['Column_name'];

                            $sqGetudah = 'select * from '.$vTable_name.' where ('.$flagApp.' != 0 and '.$flagApp.' is not null) and iupb_id = "'.$iupb_id.'" ' ;
                            echo ''.$sqGetudah;
                            echo '<br>';
                        }else if($iUsed_main_table == 2){
                            

                            $sqGetudah = $dAct['vSql_get_passed'];
                        }else{
                            $sqGetudah = $dAct['vSql_get_passed'];
                        }
                        //echo 'oke <br>';
                                /* $cekLog = 'SELECT * 
                                            FROM plc3.m_modul_log_activity a 
                                            WHERE a.iKey_id= "'.$iKey.'" 
                                            and a.idprivi_modules= "'.$modul_id.'" 
                                            and a.iM_activity= "'.$iM_activity.'" 
                                            and a.iSort= "'.$iSort.'" 
                                            ';
                                            //echo '<pre>'.$cekLog;            
                                $dCekLog = $this->db->query($cekLog)->result_array();
                                $arrUPB['iupb_id'] = $iupb_id;
                                if(!empty($dCekLog)){ */
                                    //echo 'masuk sini';
                                    /* jika sudah pernah masuk log, maka jangan dimasukkan lagi */
                                /* }else{ */

                                    /* jika activity sudah dilewati  */
                                    $datas = $this->db->query($sqGetudah)->result_array();
                                    if(empty($datas)){
                                        echo 'masuk atas  ';
                                        echo '<br>';
                                    }else{

                                        foreach ($datas as $datanya) {
                                            $iKey     = $datanya[$vCode_key];
                                            $iapp     = $datanya[$dAct['vFieldName']];
                                            
                                                if($modul_id== 4320){
                                                    if($iM_activity == 4){
                                                        $selApp = 'SELECT * FROM plc2.plc2_upb_approve a WHERE a.iupb_id= "'.$iupb_id.'" and a.vtipe= "DR" ';
                                                        $datanya = $this->db->query($selApp)->row_array();

                                                        $dapp     = $datanya['tupdate'];
                                                        $capp     = $datanya['cnip'];
                                                        $vRemark  = $datanya['treason'];
                                                    }else{
                                                        $selApp = 'SELECT * FROM plc2.plc2_upb_approve a WHERE a.iupb_id= "'.$iupb_id.'" and a.vtipe= "BD" ';
                                                        $datanya = $this->db->query($selApp)->row_array();

                                                        $dapp     = $datanya['tupdate'];
                                                        $capp     = $datanya['cnip'];
                                                        $vRemark  = $datanya['treason'];
                                                    }
                                                    

                                                }else{
                                                    $dapp     = $datanya[$dAct['dFieldName']];
                                                    $capp     = $datanya[$dAct['cFieldName']];
                                                    $vRemark  = $datanya[$dAct['tFieldName']];
                                                }

                                        

                                            echo 'masuk bawah  '.$iapp.' ';
                                            echo '<br>';
                                            $arrUPB['iupb_id'] = $iupb_id;
                                            $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$modul_id,$iKey,$iM_activity,$iSort,$vRemark,$iapp,$dapp,$capp);

                                        }
                                    }
                                    
                                    /* echo 'kesini';
                                    echo '<br>'; */
                                /* } */

                            

                        
                    }
                        
                    
                }


        }

        
        /* echo 'kesini'; */
        $datax['iupb_id'] = $iupb_id;
        $datax['dCreate'] = date('Y-m-d H:i:s');
        $datax['cCreated'] = 'N14615';
        $this->db-> insert('plc3.t_migrasi_data', $datax);	

    }

    function getProsesMigrasi(){

        $iupb_id = $_POST['iupb_id'];
        $vToken = $_POST['vToken'];

        $sql_get_flow_modul_activity = '
                select *
                from plc3.m_modul a
                join plc3.m_flow_proses b on b.iM_modul=a.iM_modul
                join plc3.m_flow c on c.iM_flow=b.iM_flow
                where a.lDeleted=0
                and b.lDeleted=0
                and c.lDeleted=0
                and a.iUsed_main_table = 1
                order by b.iUrut
                limit 1
        ';
        
        $dAlurs = $this->db->query($sql_get_flow_modul_activity)->result_array();

        foreach ($dAlurs as $alur) {
            $sql_get_activity   = 'select * from plc3.m_modul_activity a where a.lDeleted=0 and  a.iM_modul= "'.$alur['iM_modul'].'" ';
            /* echo $sql_get_activity;
            echo '<br>'; */
            $dActivity_modul    = $this->db->query($sql_get_activity)->result_array();
            $iUsed_main_table   = $alur['iUsed_main_table'];
            $vTable_name        = $alur['vTable_name'];
            $iM_modul           = $alur['iM_modul'];
            $modul_id           = $alur['idprivi_modules'];

            
                
                foreach ($dActivity_modul as $dAct) {
                   $flagApp     = $dAct['vFieldName'];
                   $iM_activity = $dAct['iM_activity'];
                   $iSort       = $dAct['iSort'];
                    if ($vTable_name <> '' and $flagApp <> '') {
                    
                        if($iUsed_main_table == 1){
                            /* jika upb digunakan di main table */
                            $selPK = "SHOW KEYS FROM ".$vTable_name." WHERE Key_name = 'PRIMARY' ";
                            $dPeka = $this->db->query($selPK)->row_array();
                            $vCode_key = $dPeka['Column_name'];

                            $sqGetudah = 'select * from '.$vTable_name.' where ('.$flagApp.' != 0 and '.$flagApp.' is not null) and iupb_id = "'.$iupb_id.'" ' ;
                            /* echo 'atas 1'.$sqGetudah;
                            echo '<br>'; */
                        }else{
                            $sqGetudah = $dAct['vSql_get_passed'];
                        }
                        
                        $query = $this->db->query($sqGetudah);
                        if ($query->num_rows() > 0) {
                            /* jika activity sudah dilewati  */
                            /* echo 'atas';
                            echo '<br>'; */

                            $datas = $this->db->query($sqGetudah)->result_array();
                            foreach ($datas as $datanya) {
                                $iKey     = $datanya[$vCode_key];
                                $iapp     = $datanya[$dAct['vFieldName']];

                                    if($modul_id== 4320 || 4213){
                                        if($iM_activity == 4){
                                            $selApp = 'SELECT * FROM plc2.plc2_upb_approve a WHERE a.iupb_id= "'.$iupb_id.'" and a.vtipe= "DR" ';
                                            $datanya = $this->db->query($selApp)->row_array();

                                            $dapp     = $datanya['tupdate'];
                                            $capp     = $datanya['cnip'];
                                            $vRemark  = $datanya['treason'];
                                        }else{
                                            $selApp = 'SELECT * FROM plc2.plc2_upb_approve a WHERE a.iupb_id= "'.$iupb_id.'" and a.vtipe= "BD" ';
                                            $datanya = $this->db->query($selApp)->row_array();

                                            $dapp     = $datanya['tupdate'];
                                            $capp     = $datanya['cnip'];
                                            $vRemark  = $datanya['treason'];
                                        }
                                        

                                    }else{
                                        $dapp     = $datanya[$dAct['dFieldName']];
                                        $capp     = $datanya[$dAct['cFieldName']];
                                        $vRemark     = $datanya[$dAct['tFieldName']];
                                    }

                               

                                /* echo $iapp;
                                echo '<br>'; */
                                $arrUPB['iupb_id'] = $iupb_id;
                                $this->lib_plc->MigrasiInsertActivityModule($arrUPB,$modul_id,$iKey,$iM_activity,$iSort,$vRemark,$iapp,$dapp,$capp);

                            }

                            

                        }else{
                            /* echo 'bawah';
                            echo '<br>'; */
                            /* jika activity belum dilewati  */
                        }
                    }
                        
                    
                }


        }

        $datax['iupb_id'] = $iupb_id;
        $datax['dCreate'] = date('Y-m-d H:i:s');
        $datax['cCreated'] =$this->user->gNIP;
        $this->db-> insert('plc3.t_migrasi_data', $datax);	

        $data['status']  = true;
        $data['last_id'] = $_POST['iupb_id'];
        $data['message'] = 'Migrasi data Selesai';
        return json_encode($data);


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
                                        var url = "'.base_url().'processor/plc/migrasi_data";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_migrasi_data").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_migrasi_data");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_migrasi_data_approve" action="'.base_url().'processor/plc/migrasi_data?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_migrasi_data_approve\')">Approve</button>';
                    
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
                                        var url = "'.base_url().'processor/plc/migrasi_data";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_migrasi_data").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_migrasi_data");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_migrasi_data_confirm" action="'.base_url().'processor/plc/migrasi_data?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_migrasi_data_confirm\')">Confirm</button>';
                    
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
                                var remark = $("#migrasi_data_remark").val();
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
                                        var url = "'.base_url().'processor/plc/migrasi_data";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_migrasi_data").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_migrasi_data");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_migrasi_data_reject" action="'.base_url().'processor/plc/migrasi_data?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark" id="reject_migrasi_data_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_migrasi_data_reject\')">Reject</button>';
                    
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
        
        $nomor = "R".str_pad($id, 7, "0", STR_PAD_LEFT);
        $sql = "UPDATE plc2.plc2_upb SET vreq_ori_no = '".$nomor."' WHERE iupb_id=$id LIMIT 1";
        $query = $this->db_plc0->query( $sql );

        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } else{
            $postData['iSubmit']=1;
            $arrUPB['iupb_id'] = $postData['iupb_id'];
            $this->lib_plc->InsertActivityModule($arrUPB,$this->modul_id,$id,1,1);
        }

        $iupb_id=$id;
    }


    public function after_update_processor($fields, $id, $post) {
        $nomor = "R".str_pad($id, 7, "0", STR_PAD_LEFT);
        $sql = "UPDATE plc2.plc2_upb SET vreq_ori_no = '".$nomor."' WHERE iupb_id=$id LIMIT 1";
        $query = $this->db_plc0->query( $sql );


    }


    function before_update_processor($row, $postData) {
        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;

        $controller_name ='migrasi_data';
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

        $iframe = '<iframe name="migrasi_data_frame" id="migrasi_data_frame" height="0" width="0"></iframe>';
        

        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        }
        else{ 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\'migrasi_data\', \' '.base_url().'processor/plc/migrasi_data?draft=true \',this,true )"  id="button_update_draft_migrasi_data"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$peka);
                    $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,$peka);

                    foreach ($activities as $act) {
                        $update_draft = '<button onclick="javascript:update_draft_btn(\'migrasi_data\', \' '.base_url().'processor/plc/migrasi_data?draft=true \',this,true )"  id="button_update_draft_migrasi_data"  class="ui-button-text icon-save" >Update as Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\'migrasi_data\', \' '.base_url().'processor/plc/migrasi_data?company_id='.$this->input->get('company_id').'&iM_modul_activity='.$act['iM_modul_activity'].'group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_migrasi_data"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/migrasi_data?action=approve&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&iupb_id='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_migrasi_data"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/migrasi_data?action=reject&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&iupb_id='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_migrasi_data"  class="ui-button-text icon-save" >Reject</button>';

                        $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/migrasi_data?action=confirm&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&iupb_id='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_migrasi_data"  class="ui-button-text icon-save" >Confirm</button>';

                        

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

    function manipulate_insert_button($buttons) { 
        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $js = $this->load->view('js/migrasi_data_js');

        $iframe = '<iframe name="migrasi_data_frame" id="migrasi_data_frame" height="0" width="0"></iframe>';
        
        $save_draft = '<button onclick="javascript:migrasi_data_btn_multiupload(\'migrasi_data\', \' '.base_url().'processor/plc/migrasi_data?draft=true \',this,true )"  id="button_save_draft_migrasi_data"  class="ui-button-text icon-save" >Migrasi Data</button>';

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
    function insertBox_migrasi_data_form_detail($field,$id){
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

    function updateBox_migrasi_data_form_detail($field,$id,$value,$rowData){
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
