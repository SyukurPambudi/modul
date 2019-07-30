<?php
    //echo $_SERVER['PATH_INFO']." : OLA Signore"; exit();
    $thisHost = gethostname();
    if($thisHost == 'WEBDEV.NOVELLPHARM.NPL'){
        $thisIP = "10.1.49.8";
    }else if($thisHost == "WEBAPP.NOVELLPHARM.NPL"){
        $thisIP = "10.1.49.6";
    }else{
        $thisIP = "localhost";
    }

    $thisIP = "10.1.49.6";
    
    //error_reporting(E_ALL);
    //ini_set("display_errors", 1);
    
    $appList = array(
        'default'   =>array('erp_core','Erp_core01','erp_privi'),
        'artwork'   =>array('erp_artwork','WC]?kj4Z2RGe[mfY','purchasing'),
        'brosur'    =>array('erp_brosur','Erp_brosur01','brosur'),
        'cost'      =>array('erp_cost','Erp_cost01','purchasing'),
        //'formulasi' =>array('erp_formulasi','Erp_formulasi01','reformulasi'),
        'core'        => array('erp_core','Erp_core01','gps_msg'),
        'complain'    => array('erp_complain','Erp_complain01','complain'),
        'custcare'    => array('erp_custcare','u[BPA=<P}6sV}K\6','smsc'),
        'etcsvc'      => array('erp_etcsvc','Erp_etcsvc01','asset'),
        'fixed_asset' => array('erp_asset','JA9>e9rt=cwy','fixed_asset'),
        
        /*baru*/
        'svc0'=> array('erp_svc0',"q,65y?@_!z#<P(qe",'asset'),
        // 'brosur0'=> array('erp_brosur0',"&+sK{3%@(9'.)-wZ",'brosur'),
        'brosur0'=> array('erp_brosur0',";Q/q~@x=Ou6s@+rC",'brosur'),
        'koperasi'=> array('erp_koperasi',"@|Sj2MI;Xpw<`?6o",'koperasi'),
        'warehouse'=> array('erp_warehouse',"T}],9_yAvshe_U*@",'plc2'),
        'hpp'=> array('erp_hpp',"jS+*2phW$/'`CWyU",'hpp'),
        'pk'=> array('erp_pk',";%.ghb-$^]'VBM2J",'hrd'),
        'gantt'=> array('erp_gantt',"Qf8ga}>0[dlF8<=m",'ganttcart'),
        'plc0'=> array('erp_plc0',"x[RGyD(VV]C++5?q",'plc2'),
        'plcotc'=> array('erp_plc0',"x[RGyD(VV]C++5?q",'plc2'),
        'schedulercheck'=> array('erp_scheduler',"H?zdwDb[kU1z%}@)",'hrd'),
        'inventory'=> array('erp_inventory',"wybhjBlV3>u%%OX`",'inventory'),
        'pddetail'=> array('erp_pddetail',"e{+~pPs{v6pc7U.l",'pddetail'),
        'rework'=> array('erp_rework',"pD>V2>{!V4v!(Rp'",'kanban'),
        'kartucall'=> array('erp_kartucall',"27N16BwcBa0%J6UP",'kartu_call'),
        'formulasi'=> array('erp_reformulasi',"7|I,//1mAJ@M^.`e",'reformulasi'),
        'complaint'=> array('erp_complaint',"6eLKh!9#'IJdNyI^",'complain'),
        'gpsm'=> array('mob_gpsm',"a[oU>l6~;9&n~^?>",'gps_msg'), 
        'plcexport'=> array('erp_plcexport',"bMUH{^`_JxE|*n5*",'dossier'),
        'core'=> array('mob_gpsm',"a[oU>l6~;9&n~^?>",'gps_msg'), 
        'kalibrasi'=> array('erp_kalibrasi',";=C'9S4A5O~M;2mP",'kalibrasi'),
        'deviasi'=> array('erp_deviasi',",^ru.Vi00+i)mz^2",'deviasi'),
        'prdtrial'=> array('erp_prdtrial',"Ru7knourg",'prdtrial'),
        'preventive'=> array('erp_preventive',"PbgWSaaCD3Ijhm!z",'asset'),
        
        /*baru*/

        'kknote'        =>array('erp_kknote','ge[6CSz+yB&fV@bU','hrd'),
        'erp_vs'        =>array('erp_vitalsign','h3UY8_#`ZTM6','general'),
        'erp_merk'      =>array('erp_merk','C&D<xAB)6kX}-','merek'),
        'erp_misell'    =>array('erp_misell','7:STyCEa+_3(*','general'),
        'erp_mst'       =>array('erp_mst','7.F7;[T?/Eye{','smsc'),
        'erp_hd'        =>array('erp_hd','R~VHc95q<H~=;','hrd'),
        'erp_rs'        =>array('erp_rs','z%gGnC)EW94[','hrd'),
        'erp_pm'        =>array('erp_pm','LDYz$c:G4+sW!E}t','pm'),
        'erp_ma'        =>array('erp_ma','+u9hnd3]@ReAXtbc','ma'),
        'erp_ga'        =>array('erp_ga','6Mgc(n!7RDJf}','ga'),
        'hrd'           =>array('erp_hrd','\eEB<Cm:]Twem<56','hrd'),
        'erp_pd_source' =>array('erp_pd_source','Q4#v/NzKxRR&rp.x','pd_source'),
        'erp_training'  =>array('erp_training','P#HTERh&Yj4g','general')
    );
    
    foreach($appList as $k => $v){ 
        $db[$k]['hostname'] = $thisIP; 
        $db[$k]['dbdriver'] = 'mysql';
        $db[$k]['username'] = $v[0];
        $db[$k]['password'] = $v[1]; 
        $db[$k]['database'] = $v[2];
        $db[$k]['db_debug'] = FALSE;
        
    }
    
    $db['dbplc']['username'] = 'erp_brosur';
    $db['dbplc']['password'] = 'Erp_brosur01';
    $db['dbplc']['database'] = 'plc2';   
     
    /*$db['artwork']['username'] = 'erp_artwork';
    $db['artwork']['password'] = 'Erp_artwork01';
    $db['artwork']['database'] = 'purchasing';
    
    $db['brosur']['username'] = 'erp_brosur';
    $db['brosur']['password'] = 'Erp_brosur01';
    $db['brosur']['database'] = 'brosur'; 
    
    $db['cost']['username'] = 'erp_cost';
    $db['cost']['password'] = 'Erp_cost01';
    $db['cost']['database'] = 'purchasing';
    
    $db['formulasi']['username'] = 'erp_formulasi';
    $db['formulasi']['password'] = 'Erp_formulasi01';
    $db['formulasi']['database'] = 'reformulasi';
    
    $db['core']['username'] = 'erp_core';
    $db['core']['password'] = 'Erp_core01'; 
    $db['core']['database'] = 'gpsmsg';
    
    $db['etcsvc']['username'] = 'erp_etcsvc';
    $db['etcsvc']['password'] = 'Erp_etcsvc01'; 
    $db['etcsvc']['database'] = 'asset';
    
    $db['complain']['username'] = 'erp_complain';
    $db['complain']['password'] = 'Erp_complain01';  
    $db['complain']['database'] = 'complain';
    
    $db['custcare']['username'] = 'erp_custcare';
    $db['custcare']['password'] = 'Erp_custcare01';
    $db['custcare']['database'] = 'smsc';  */      