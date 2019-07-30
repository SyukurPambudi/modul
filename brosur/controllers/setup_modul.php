<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class setup_modul extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->db_plc0 = $this->load->database('brosur0',false, true);
        $this->load->library('lib_plc');
        $this->modul_id = $this->input->get('modul_id');
        $this->iModul_id = $this->lib_plc->getIModulID($this->input->get('modul_id'));
        $this->db = $this->load->database('brosur0',false, true);
        $this->load->library('auth');
        $this->user = $this->auth->user();
        $this->team = $this->lib_plc->hasTeam($this->user->gNIP);
        $this->teamID = $this->lib_plc->hasTeamID($this->user->gNIP);
        $isAdmin=$this->lib_plc->isAdmin($this->user->gNIP);
        $this->isAdmin = $isAdmin;
        $this->main_table='erp_privi.m_modul';
        $this->main_table_pk='iM_modul';
        $this->tipe_modul = array(1=>'Insert / Update',2=>'Update');

        $this->title = 'Modul';
        $this->url = 'setup_modul';
        $this->urlpath = 'brosur/'.str_replace("_","/", $this->url);

        $this->maintable = 'erp_privi.m_modul';  
        $datagrid['islist'] = array(
            'vKode_modul'                   => array('label' => 'Modul Code',       'width' => 100, 'align' => 'center',    'search'=>false),
            'privi_apps.vAppName'           => array('label' => 'Application Name', 'width' => 250, 'align' => 'left',      'search'=>true),
            'privi_modules.vNameModule'     => array('label' => 'Modul Name',       'width' => 250, 'align' => 'left',      'search'=>true),
            'm_application.vDesciption'                   => array('label' => 'Description',      'width' => 400, 'align' => 'left',      'search'=>true),
        );
        $datagrid['shortBy']=array('iM_modul'=>'Desc');

        

        $datagrid['setQuery']=array(
            1   => array('vall' => 'm_modul.lDeleted', 'nilai' => 0)
        );
        
        
        $datagrid['isField'] = array(
			'vKode_modul'           => array('label' => 'Code',                     'require' => true),
            'idprivi_modules'       => array('label' => 'Nama Modul',               'require' => true),
            'iM_application'        => array('label' => 'Aplikasi',                 'require' => true),
            'vDesciption'           => array('label' => 'Description',              'require' => true),
            'iType_modul'           => array('label' => 'Tipe Modul',               'require' => true),
            'vTable_name'           => array('label' => 'Main Table',               'require' => true),
            'vDept_author'          => array('label' => 'Departemen Author',        'require' => true),
            'vNip_author'           => array('label' => 'NIP Author',               'require' => true),
            'vDept_participant'     => array('label' => 'Departement Participant',  'require' => true),
            'vNip_participant'      => array('label' => 'NIP Participant',          'require' => true),
            // 'detail_activity'       => array('label' => 'Detail Activity',          'require' => true),
            // 'detail_field'          => array('label' => 'Detail Field',             'require' => true),
            'detail_setup'          => array('label' => 'Detail Setup',             'require' => true),
        );
        


        $datagrid['jointableinner']=array(
            0 => array('erp_privi.m_application'    => 'erp_privi.m_application.iM_application  = erp_privi.m_modul.iM_application'),
            1 => array('erp_privi.privi_apps'       => 'erp_privi.privi_apps.idprivi_apps       = erp_privi.m_application.idprivi_apps'),
            2 => array('erp_privi.privi_modules'    => 'erp_privi.privi_modules.idprivi_modules = erp_privi.m_modul.idprivi_modules'),
        );
        


        $this->datagrid=$datagrid;
    }

    function index($action = '') {
        $grid = new Grid;       
        $grid->setTitle($this->title);      
        $grid->setTable($this->maintable );
        $grid->setUrl($this->url);
       /* $grid->setGroupBy($this->setGroupBy);*/
        /*Untuk Field*/
        //$grid->addFields('form_detail');
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

            /*Untuk Field*/
			if($kv=='isField'){
                foreach ($vv as $list => $vlist) {
                    $grid->addFields($list);
                    foreach ($vlist as $kdis => $vdis) {
                        if($kdis=='label'){
                            $grid->setLabel($list, $vdis);
                        }
                            if($kdis=='require' && $vdis==true){
                            $grid->setRequired($list);
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

            if($kv=='jointableleft'){
                foreach ($vv as $list => $vlist) {
                    foreach ($vlist as $tbjoin => $onjoin) {
                        $grid->setJoinTable($tbjoin, $onjoin, 'left');
                    }
                }
            }


            if($kv=='setQuery'){
                foreach ($vv as $kv => $vlist) {
                    $grid->setQuery($vlist['vall'], $vlist['nilai']);


                    
                }
            }

        }


        $grid->changeFieldType('iApprove_uji','combobox','',array(0=>'Waiting Approval', 1=>'Rejected', 2=>'Approved'));
        $grid->changeFieldType('iSubmit','combobox','',array(0=>'Draft - Need to be Submitted', 1=>'Submitted'));
        $grid->changeFieldType('iHave_flow','combobox','',array(0=>'No', 1=>'Yes'));

        
        $grid->setGridView('grid');

        switch ($action) {
            case 'json':
                $grid->getJsonData();
                break;
            case 'download':
                $this->download($this->input->get('file'));
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
            case 'view':
                $grid->render_form($this->input->get('id'),TRUE);
                break;
            case 'updateproses':
                // $post=$this->input->post();
                // $id=$post["setup_modul_iM_modul"];
                // /*Details Activity*/
                // $Usetup_modul_iM_activity=array();
                // $Isetup_modul_iM_activity=array();

                // $Usetup_modul_iType=array();
                // $Isetup_modul_iType=array(); 

                // $UvDept_assigned=array();
                // $IvDept_assigned=array();

                // $UvNip_assigned=array();
                // $IvNip_assigned=array();

                // $UvDesciption=array();
                // $IvDesciption=array();

                // $UiSort=array();
                // $IiSort=array();

                // $iM_modul_activity=array();

                // foreach ($post as $kpost => $vpost) {
                //     if($kpost=="setup_modul_iM_activity"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_iM_activity[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                     $iM_modul_activity[]=$kplast;
                //                     $Usetup_modul_iM_activity[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_iType"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_iType[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Usetup_modul_iType[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_vDept_assigned"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $IvDept_assigned[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                    $UvDept_assigned[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_vNip_assigned"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $IvNip_assigned[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                    $UvNip_assigned[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_vDesciption"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $IvDesciption[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                    $UvDesciption[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_iSort"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $IiSort[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                    $UiSort[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                // }

                // /*Update lDeleted Activity*/
                // $query=array();
                // if(count($iM_modul_activity)>0){
                //     $this->db->where("iM_modul",$id);
                //     $this->db->where_not_in("iM_modul_activity",$iM_modul_activity);
                //     $dupdate=array();
                //     $dupdate['dupdate']=date("Y-m-d H:i:s");
                //     $dupdate['cUpdate']=$this->user->gNIP;
                //     $dupdate['lDeleted']=1;
                //     $this->db->update("erp_privi.m_modul_activity",$dupdate);
                //     $query[]=$this->db->last_query();
                // }else{
                //     $this->db->where("iM_modul",$id);
                //     $dupdate=array();
                //     $dupdate['dupdate']=date("Y-m-d H:i:s");
                //     $dupdate['cUpdate']=$this->user->gNIP;
                //     $dupdate['lDeleted']=1;
                //     $this->db->update("erp_privi.m_modul_activity",$dupdate);
                //     $query[]=$this->db->last_query();
                // }

                // /*Modif or Insert Activity*/
                // if(count($Usetup_modul_iM_activity)>0){
                //     foreach ($Usetup_modul_iM_activity as $iddetail => $valini) {
                //             $dupdated=array();
                //             $dupdated['iM_activity']=$valini;
                //             $dupdated['iType']=isset($Usetup_modul_iType[$iddetail])?$Usetup_modul_iType[$iddetail]:"";
                //             $dupdated['vDept_assigned']=isset($UvDept_assigned[$iddetail])?$UvDept_assigned[$iddetail]:"";
                //             $dupdated['vNip_assigned']=isset($UvNip_assigned[$iddetail])?$UvNip_assigned[$iddetail]:"";
                //             $dupdated['vDesciption']=isset($UvDesciption[$iddetail])?$UvDesciption[$iddetail]:"";
                //             $dupdated['iSort']=isset($UiSort[$iddetail])?$UiSort[$iddetail]:"";
                //             $dupdated['dupdate']=date("Y-m-d H:i:s");
                //             $dupdated['cUpdate']=$this->user->gNIP;
                //             $this->db->where('iM_modul_activity',$iddetail);
                //             $this->db->update('erp_privi.m_modul_activity',$dupdated);
                //     }
                // }

                // if(count($Isetup_modul_iM_activity)>0){
                //     foreach ($Isetup_modul_iM_activity as $iddinsert => $valinsert) {
                //             $dinsertd=array();
                //             $dinsertd['iM_modul']=$id;
                //             $dinsertd['iM_activity']=$valinsert;
                //             $dinsertd['iType']=isset($Isetup_modul_iType[$iddinsert])?$Isetup_modul_iType[$iddinsert]:"";
                //             $dinsertd['vDept_assigned']=isset($IvDept_assigned[$iddinsert])?$IvDept_assigned[$iddinsert]:"";
                //             $dinsertd['vNip_assigned']=isset($IvNip_assigned[$iddinsert])?$IvNip_assigned[$iddinsert]:"";
                //             $dinsertd['vDesciption']=isset($IvDesciption[$iddinsert])?$IvDesciption[$iddinsert]:"";
                //             $dinsertd['iSort']=isset($IiSort[$iddinsert])?$IiSort[$iddinsert]:"";
                //             $dinsertd['dCreate']=date("Y-m-d H:i:s");
                //             $dinsertd['cCreated']=$this->user->gNIP;
                //             $this->db->insert('erp_privi.m_modul_activity',$dinsertd);
                //     }
                // }

                // /*Details Fields*/
                // $Usetup_modul_iM_jenis_field=array();
                // $Isetup_modul_iM_jenis_field=array();
                
                // $Usetup_modul_vNama_field=array();
                // $Isetup_modul_vNama_field=array();
                
                // $Usetup_modul_vSource_input=array();
                // $Isetup_modul_vSource_input=array();
                
                // $Usetup_modul_vSource_input_edit=array();
                // $Isetup_modul_vSource_input_edit=array();
                
                // $Usetup_modul_vRequirement_field=array();
                // $Isetup_modul_vRequirement_field=array();
                
                // $Usetup_modul_iValidation=array();
                // $Isetup_modul_iValidation=array();
                
                // $Usetup_modul_iRequired=array();
                // $Isetup_modul_iRequired=array();
                
                // $Usetup_modul_vTabel_file=array();
                // $Isetup_modul_vTabel_file=array();

                // $Usetup_modul_vTabel_file_pk_id=array();
                // $Isetup_modul_vTabel_file_pk_id=array();

                // $Usetup_modul_vDept_author=array();
                // $Isetup_modul_vDept_author=array();

                // $Usetup_modul_vNip_author=array();
                // $Isetup_modul_vNip_author=array();

                // $Usetup_modul_vFile_detail=array();
                // $Isetup_modul_vFile_detail=array();

                // $Usetup_modul_iSort=array();
                // $Isetup_modul_iSort=array();

                // $iM_modul_fields=array();
                // foreach ($post as $kpost => $vpost) {
                //     if($kpost=="setup_modul_iM_jenis_field"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_iM_jenis_field[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                     $iM_modul_fields[]=$kplast;
                //                     $Usetup_modul_iM_jenis_field[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_vNama_field"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_vNama_field[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                     $Usetup_modul_vNama_field[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_vSource_input"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_vSource_input[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                     $Usetup_modul_vSource_input[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_vSource_input_edit"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_vSource_input_edit[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                     $Usetup_modul_vSource_input_edit[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_vRequirement_field"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_vRequirement_field[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                     $Usetup_modul_vRequirement_field[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_iValidation"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_iValidation[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                     $Usetup_modul_iValidation[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_iRequired"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_iRequired[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                     $Usetup_modul_iRequired[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_vDesciption"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_vDesciption[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                     $Usetup_modul_vDesciption[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_vTabel_file"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_vTabel_file[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                     $Usetup_modul_vTabel_file[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_vTabel_file_pk_id"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_vTabel_file_pk_id[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                     $Usetup_modul_vTabel_file_pk_id[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_vDept_author"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_vDept_author[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                     $Usetup_modul_vDept_author[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_vNip_author"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_vNip_author[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                     $Usetup_modul_vNip_author[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_vFile_detail"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_vFile_detail[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                     $Usetup_modul_vFile_detail[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                //     if($kpost=="setup_modul_iSort"){
                //         foreach ($vpost as $kplast => $vplast) {
                //             if($kplast==0){
                //                 foreach ($vplast as $kk => $vv) {
                //                    $Isetup_modul_iSort[$kk]=$vv;
                //                 }
                //             }else{
                //                 foreach ($vplast as $kk => $vv) {
                //                     $Usetup_modul_iSort[$kplast]=$vv;
                //                 }
                //             }
                //         }
                //     }
                // }

                // /*Update lDeleted Activity*/
                // if(count($iM_modul_fields)>0){
                //     $this->db->where("iM_modul",$id);
                //     $this->db->where_not_in("iM_modul_fields",$iM_modul_fields);
                //     $dupdate=array();
                //     $dupdate['dupdate']=date("Y-m-d H:i:s");
                //     $dupdate['cUpdate']=$this->user->gNIP;
                //     $dupdate['lDeleted']=1;
                //     $this->db->update("erp_privi.m_modul_fields",$dupdate);
                // }else{
                //     $this->db->where("iM_modul",$id);
                //     $dupdate=array();
                //     $dupdate['dupdate']=date("Y-m-d H:i:s");
                //     $dupdate['cUpdate']=$this->user->gNIP;
                //     $dupdate['lDeleted']=1;
                //     $this->db->update("erp_privi.m_modul_fields",$dupdate);
                // }

                //  /*Modif or Insert Field*/
                // if(count($Usetup_modul_iM_jenis_field)>0){
                //     foreach ($Usetup_modul_iM_jenis_field as $iddetail => $valini) {
                //         $dupdated=array();
                //         $dupdated['iM_jenis_field']=$valini;
                //         $dupdated['vNama_field']=isset($Usetup_modul_vNama_field[$iddetail])?$Usetup_modul_vNama_field[$iddetail]:"";
                //         $dupdated['vSource_input']=isset($Usetup_modul_vSource_input[$iddetail])?$Usetup_modul_vSource_input[$iddetail]:"";
                //         $dupdated['vSource_input_edit']=isset($Usetup_modul_vSource_input_edit[$iddetail])?$Usetup_modul_vSource_input_edit[$iddetail]:"";
                //         $dupdated['vRequirement_field']=isset($Usetup_modul_vRequirement_field[$iddetail])?$Usetup_modul_vRequirement_field[$iddetail]:"";
                //         $dupdated['iValidation']=isset($Usetup_modul_iValidation[$iddetail])?$Usetup_modul_iValidation[$iddetail]:"";
                //         $dupdated['iRequired']=isset($Usetup_modul_iRequired[$iddetail])?$Usetup_modul_iRequired[$iddetail]:"";
                //         $dupdated['vDesciption']=isset($Usetup_modul_vDesciption[$iddetail])?$Usetup_modul_vDesciption[$iddetail]:"";
                //         $dupdated['vTabel_file']=isset($Usetup_modul_vTabel_file[$iddetail])?$Usetup_modul_vTabel_file[$iddetail]:"";
                //         $dupdated['vTabel_file_pk_id']=isset($Usetup_modul_vTabel_file_pk_id[$iddetail])?$Usetup_modul_vTabel_file_pk_id[$iddetail]:"";
                //         $dupdated['vDept_author']=isset($Usetup_modul_vDept_author[$iddetail])?$Usetup_modul_vDept_author[$iddetail]:"";
                //         $dupdated['vNip_author']=isset($Usetup_modul_vNip_author[$iddetail])?$Usetup_modul_vNip_author[$iddetail]:"";
                //         $dupdated['vFile_detail']=isset($Usetup_modul_vFile_detail[$iddetail])?$Usetup_modul_vFile_detail[$iddetail]:"";
                //         $dupdated['iSort']=isset($Usetup_modul_iSort[$iddetail])?$Usetup_modul_iSort[$iddetail]:"";
                //         $dupdated['dupdate']=date("Y-m-d H:i:s");
                //         $dupdated['cUpdate']=$this->user->gNIP;
                //         $this->db->where('iM_modul_fields',$iddetail);
                //         $this->db->update('erp_privi.m_modul_fields',$dupdated);
                //     }
                // }

                //  if(count($Isetup_modul_iM_jenis_field)>0){
                //     foreach ($Isetup_modul_iM_jenis_field as $iddinsert => $valinsert) {
                //             $dinsertd=array();
                //             $dinsertd['iM_modul']=$id;
                //             $dinsertd['iM_jenis_field']=$valinsert;
                //             $dinsertd['vNama_field']=isset($Isetup_modul_vNama_field[$iddinsert])?$Isetup_modul_vNama_field[$iddinsert]:"";
                //             $dinsertd['vSource_input']=isset($Isetup_modul_vSource_input[$iddinsert])?$Isetup_modul_vSource_input[$iddinsert]:"";
                //             $dinsertd['vSource_input_edit']=isset($Isetup_modul_vSource_input_edit[$iddinsert])?$Isetup_modul_vSource_input_edit[$iddinsert]:"";
                //             $dinsertd['vRequirement_field']=isset($Isetup_modul_vRequirement_field[$iddinsert])?$Isetup_modul_vRequirement_field[$iddinsert]:"";
                //             $dinsertd['iValidation']=isset($Isetup_modul_iValidation[$iddinsert])?$Isetup_modul_iValidation[$iddinsert]:"";
                //             $dinsertd['iRequired']=isset($Isetup_modul_iRequired[$iddinsert])?$Isetup_modul_iRequired[$iddinsert]:"";
                //             $dinsertd['vDesciption']=isset($Isetup_modul_vDesciption[$iddinsert])?$Isetup_modul_vDesciption[$iddinsert]:"";
                //             $dinsertd['vTabel_file']=isset($Isetup_modul_vTabel_file[$iddinsert])?$Isetup_modul_vTabel_file[$iddinsert]:"";
                //             $dinsertd['vTabel_file_pk_id']=isset($Isetup_modul_vTabel_file_pk_id[$iddinsert])?$Isetup_modul_vTabel_file_pk_id[$iddinsert]:"";
                //             $dinsertd['vDept_author']=isset($Isetup_modul_vDept_author[$iddinsert])?$Isetup_modul_vDept_author[$iddinsert]:"";
                //             $dinsertd['vNip_author']=isset($Isetup_modul_vNip_author[$iddinsert])?$Isetup_modul_vNip_author[$iddinsert]:"";
                //             $dinsertd['vFile_detail']=isset($Isetup_modul_vFile_detail[$iddinsert])?$Isetup_modul_vFile_detail[$iddinsert]:"";
                //             $dinsertd['iSort']=isset($Isetup_modul_iSort[$iddinsert])?$Isetup_modul_iSort[$iddinsert]:"";
                //             $dinsertd['dCreate']=date("Y-m-d H:i:s");
                //             $dinsertd['cCreated']=$this->user->gNIP;
                //             $this->db->insert('erp_privi.m_modul_fields',$dinsertd);
                //     }
                // }

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
            /*Option Case*/
            case 'getFormDetail':
                echo $this->getFormDetail();
                break;

            case 'get_data_prev':
                echo $this->get_data_prev();
                break;
            case 'getProcess':
                echo $this->getProcess();
                break;
            case 'dataDetailsFields':
                echo $this->dataDetailsFields();
                break;
            case 'dataDetailsModul':
                echo $this->dataDetailsModul();
                break; 

            default:
                $grid->render_grid();
                break;
        }
    }


    function getProcess(){
        $term = $this->input->get('term');
        $id = $this->input->get('id'); 
        $sql = 'SELECT m.iM_modul, m.vKode_modul, p.vNameModule FROM erp_privi.m_modul m 
                JOIN erp_privi.privi_modules p ON m.idprivi_modules = p.idprivi_modules 
                WHERE ( m.vKode_modul LIKE ? OR p.vNameModule LIKE ? ) AND m.iM_application = ? AND m.lDeleted = 0
                ORDER BY p.vNameModule ASC';
        $dt=$this->db->query($sql, array('%'.$term.'%', '%'.$term.'%', $id));
        $data = array();
        if($dt->num_rows > 0){
            foreach($dt->result_array() as $line) {
                $row_array['value'] = $line['vKode_modul'].' - '.trim($line['vNameModule']);
                $row_array['id']    = $line['iM_modul'];
                array_push($data, $row_array);
            }
        }
        return json_encode($data);
        exit;
    }

    function dataDetailsModul(){
        $post=$this->input->post();
        $get=$this->input->get();
        $nmTable=isset($get['nmTable'])?$get['nmTable']:$this->url;
        $grid=isset($get['grid'])?$get['grid']:$this->url;
        $id=isset($get['id'])?$get['id']:0;
        /*DataActivity*/
        $this->db->where('lDeleted',0);
        $listActivity=$this->db->get('erp_privi.m_activity')->result_array();

        $sql_data="SELECT mo.*, ac.vKode_activity, ac.vNama_activity 
                    FROM erp_privi.m_modul_activity mo
                    JOIN erp_privi.m_activity ac ON ac.iM_activity = mo.iM_activity
                    WHERE mo.lDeleted = 0 AND ac.lDeleted = 0 AND mo.iM_modul = ? ";
        $q=$this->db->query($sql_data, array($id));
        $rsel=array('hapus','vKode_activity','iType','vDept_assigned','vNip_assigned','vDesciption','iSort');
        $data = new StdClass;
        $data->records=$q->num_rows();
        $i=0;
        foreach ($q->result() as $k) {
            $data->rows[$i]['id']=$i;
            $z=0;
            foreach ($rsel as $dsel => $vsel) {
                if($vsel=="hapus"){
                    $dataar[$dsel]="<input type='hidden' class='num_rows_".$nmTable."' value='".$i."' /><a href='javascript:;' onclick='javascript:hapus_row_".$nmTable."(".$i.")'><center><span class='ui-icon ui-icon-close'></span></center></a>";
                }elseif($vsel=="vKode_activity"){
                    $option="<option value=''>---Pilih---</option>";
                    foreach ($listActivity as $kv => $vv) {
                        $select=$k->iM_activity==$vv['iM_activity']?"selected='selected'":"";
                        $option.="<option value='".$vv['iM_activity']."' ".$select.">".$vv['vKode_activity']." - ".$vv['vNama_activity']."</option>";
                    }
                    $dataar[$dsel]="<select id='".$grid."_iM_activity_".$i."' name='".$grid."_iM_activity[".$k->iM_modul_activity."][]'>".$option."</select>";
                }elseif($vsel=="iType"){
                   $option2="<option value=''>---Pilih---</option>";
                    $listType=array(1=>"Insert/Update",2=>"Approval",3=>"Confirmation");
                    foreach ($listType as $kv => $vv) {
                        $select2=$k->iType==$kv?"selected='selected'":"";
                       $option2.="<option value='".$kv."' ".$select2.">".$vv."</option>";
                    }
                    $dataar[$dsel]="<select id='".$grid."_iType_".$i."' name='".$grid."_iType[".$k->iM_modul_activity."][]' ".$select2.">".$option2."</select>";
                }elseif($vsel=="iSort"){
                    $dataar[$dsel]="<input type='text' size='3' id='".$grid."_iSort_".$i."' value='".$k->iSort."' class='numbersOnly required' name='".$grid."_iSort[".$k->iM_modul_activity."][]'>";
                }elseif($vsel=="vDept_assigned"){
                    $dataar[$dsel]="<input type='text' size='10' id='".$grid."_vDept_assigned_".$i."' value='".$k->vDept_assigned."' class='required' name='".$grid."_vDept_assigned[".$k->iM_modul_activity."][]'>";
                }elseif($vsel=="vNip_assigned"){
                    $dataar[$dsel]="<input type='text' size='20' id='".$grid."_vNip_assigned_".$i."' value='".$k->vNip_assigned."' class='required' name='".$grid."_vNip_assigned[".$k->iM_modul_activity."][]'>";
                }elseif($vsel=="vDesciption"){
                    $dataar[$dsel]="<textarea id='".$grid."_vDesciption_".$i."' class='required' name='".$grid."_vDesciption[".$k->iM_modul_activity."][]' size='250'>".$k->{$vsel}."</textarea>";
                }else{
                    $dataar[$dsel]=$k->{$vsel};
                }
                $z++;
            }
            $data->rows[$i]['cell']=$dataar;
            $i++;
        }
        return json_encode($data);
    }

    function dataDetailsFields(){
        $post=$this->input->post();
        $get=$this->input->get();
        $nmTable=isset($get['nmTable'])?$get['nmTable']:$this->url;
        $grid=isset($get['grid'])?$get['grid']:$this->url;
        $id=isset($get['id'])?$get['id']:0;
        /*DataActivity*/
        $this->db->where('lDeleted',0);
        $listField=$this->db->get('erp_privi.m_jenis_field')->result_array();

        $this->db->where('lDeleted',0);
        $this->db->where('iM_modul',$id);
        $this->db->order_by("iSort", "ASC");
        $q=$this->db->get('erp_privi.m_modul_fields');
        $rsel=array('hapus','iM_jenis_field','vNama_field','vSource_input','vSource_input_edit','vRequirement_field','iValidation','iRequired','vDesciption','vTabel_file','vTabel_file_pk_id','vDept_author','vNip_author','vFile_detail','iSort');
        $data = new StdClass;
        $data->records=$q->num_rows();
        $i=0;
        
        $listTypeyesno=array(1=>"Iya",2=>"Tidak");
        
        foreach ($q->result() as $k) {
            $data->rows[$i]['id']=$i;
            $z=0;
            foreach ($rsel as $dsel => $vsel) {
                if($vsel=="hapus"){
                    $dataar[$dsel]="<input type='hidden' class='num_rows_".$nmTable."' value='".$i."' /><a href='javascript:;' onclick='javascript:hapus_row_".$nmTable."(".$i.")'><center><span class='ui-icon ui-icon-close'></span></center></a>";
                }elseif($vsel=="iM_jenis_field"){
                    $option="<option value=''>---Pilih---</option>";
                    foreach ($listField as $kv => $vv) {
                        $select=$k->iM_jenis_field==$vv['iM_jenis_field']?"selected='selected'":"";
                        $option.="<option value='".$vv['iM_jenis_field']."' ".$select.">".$vv['vKode_field']." - ".$vv['vNama_field']."</option>";
                    }
                    $dataar[$dsel]="<select id='".$grid."_iM_jenis_field_".$i."' name='".$grid."_iM_jenis_field[".$k->iM_modul_fields."][]'><?php echo $option ?></select>";
                }elseif($vsel=="vNama_field"){
                    $dataar[$dsel]="<input type='text' size='20' id='".$grid."_vNama_field_".$i."' value='".$k->vNama_field."' class='' name='".$grid."_vNama_field[".$k->iM_modul_fields."][]'>";
                }elseif($vsel=="vSource_input"){
                    $dataar[$dsel]="<textarea id='".$grid."_vSource_input_".$i."' class='' name='".$grid."_vSource_input[".$k->iM_modul_fields."][]' size='250'>".$k->{$vsel}."</textarea>";
                }elseif($vsel=="vSource_input_edit"){
                    $dataar[$dsel]="<textarea id='".$grid."_vSource_input_edit_".$i."' class='' name='".$grid."_vSource_input_edit[".$k->iM_modul_fields."][]' size='250'>".$k->{$vsel}."</textarea>";
                }elseif($vsel=="vRequirement_field"){
                    $dataar[$dsel]="<textarea id='".$grid."_vRequirement_field_".$i."' class='' name='".$grid."_vRequirement_field[".$k->iM_modul_fields."][]' size='250'>".$k->{$vsel}."</textarea>";
                }elseif($vsel=="iValidation"){
                    $option2yesno1="<option value=''>---Pilih---</option>";
                    foreach ($listTypeyesno as $kv => $vv) {
                        $select=$k->iValidation==$kv?"selected='selected'":"";
                        $option2yesno1.="<option value='".$kv."' ".$select.">".$vv."</option>";
                    }
                    $dataar[$dsel]="<select id='".$grid."_iValidation_".$i."' name='".$grid."_iValidation[".$k->iM_modul_fields."][]'><?php echo $option2yesno1 ?></select>";
                }elseif($vsel=="iRequired"){
                    $option2yesno1="<option value=''>---Pilih---</option>";
                    foreach ($listTypeyesno as $kv => $vv) {
                        $select=$k->iRequired==$kv?"selected='selected'":"";
                        $option2yesno1.="<option value='".$kv."' ".$select.">".$vv."</option>";
                    }
                    $dataar[$dsel]="<select id='".$grid."_iRequired_".$i."' name='".$grid."_iRequired[".$k->iM_modul_fields."][]'><?php echo $option2yesno1 ?></select>";
                }elseif($vsel=="vDesciption"){
                    $dataar[$dsel]="<textarea id='".$grid."_vDesciption_".$i."' class='' name='".$grid."_vDesciption[".$k->iM_modul_fields."][]' size='250'>".$k->{$vsel}."</textarea>";
                }elseif($vsel=="vTabel_file"){
                    $dataar[$dsel]="<input type='text' size='20' id='".$grid."_vTabel_file_".$i."' class='' name='".$grid."_vTabel_file[".$k->iM_modul_fields."][]' value='".$k->{$vsel}."' />";
                }elseif($vsel=="vTabel_file_pk_id"){
                    $dataar[$dsel]="<input type='text' size='20' id='".$grid."_vTabel_file_pk_id_".$i."' class='' name='".$grid."_vTabel_file_pk_id[".$k->iM_modul_fields."][]' value='".$k->{$vsel}."' />";
                }elseif($vsel=="vDept_author"){
                    $dataar[$dsel]="<input type='text' size='12' id='".$grid."_vDept_author_".$i."' class='' name='".$grid."_vDept_author[".$k->iM_modul_fields."][]' value='".$k->{$vsel}."' />";
                }elseif($vsel=="vNip_author"){
                    $dataar[$dsel]="<input type='text' size='12' id='".$grid."_vNip_author_".$i."' class='' name='".$grid."_vNip_author[".$k->iM_modul_fields."][]' value='".$k->{$vsel}."' />";
                }elseif($vsel=="vFile_detail"){
                    $dataar[$dsel]="<input type='text' size='18' id='".$grid."_vFile_detail_".$i."' class='' name='".$grid."_vFile_detail[".$k->iM_modul_fields."][]' value='".$k->{$vsel}."' />";
                }elseif($vsel=="iSort"){
                    $dataar[$dsel]="<input type='text' size='3' id='".$grid."_iSort_".$i."' class='' name='".$grid."_iSort[".$k->iM_modul_fields."][]' value='".$k->{$vsel}."' />";
                }else{
                    $dataar[$dsel]=$k->{$vsel};
                }
                $z++;
            }
            $data->rows[$i]['cell']=$dataar;
            $i++;
        }
        return json_encode($data);
    }

    function listBox_Action($row, $actions) {
        $peka=$row->iM_modul;
        $getLastactivity = $this->lib_plc->getLastactivity($this->modul_id,$peka);
        $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

        // if ( $getLastactivity == 0 ) { 
        //        if($row->iApprove_uji <> 0){
        //             /*approval DR lewat setting prioritas*/
        //             unset($actions['edit']);    

        //        } 
        // }else{
        //     if($isOpenEditing){

        //     }else{
        //         unset($actions['edit']);    
        //     }
            
        // }


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
                                        var url = "'.base_url().'processor/plc/setup_modul";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_setup_modul").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_setup_modul");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_setup_modul_approve" action="'.base_url().'processor/plc/setup_modul?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iM_modul" value="'.$this->input->get('iM_modul').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_setup_modul_approve\')">Approve</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function approve_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $iM_modul = $post['iM_modul'];
                $iupb_id = $post['iupb_id'];
                
                $vRemark = $post['vRemark'];
                $modul_id = $post['modul_id'];


                //Letakan Query Update approve disini
                $data=array('iapprove'=>'2');
                $this -> db -> where('iM_modul', $iM_modul);
                $updet = $this -> db -> update('erp_privi.m_modul', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_modul = $isAndSort['iM_modul'];
                $iSort = $isAndSort['iSort'];

                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iM_modul,$iM_modul,$iSort,$vRemark,2);
    
                $data['status']  = true;
                $data['last_id'] = $post['iM_modul'];
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
                                        var url = "'.base_url().'processor/plc/setup_modul";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_setup_modul").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_setup_modul");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_setup_modul_confirm" action="'.base_url().'processor/plc/setup_modul?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iM_modul" value="'.$this->input->get('iM_modul').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_setup_modul_confirm\')">Confirm</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function confirm_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $iM_modul = $post['iM_modul'];
                $iupb_id = $post['iupb_id'];
                $vRemark = $post['vRemark'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $modul_id = $post['modul_id'];

                //Letakan Query Update approve disini
                $data=array('iApprove_uji'=>'2');
                $this -> db -> where('iM_modul', $iM_modul);
                $updet = $this -> db -> update('erp_privi.m_modul', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_modul = $isAndSort['iM_modul'];
                $iSort = $isAndSort['iSort'];
                
                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iM_modul,$iM_modul,$iSort,$vRemark,2);

                
                $data['status']  = true;
                $data['last_id'] = $post['iM_modul'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }
    
        
            //Ini Merupakan Standart Reject yang digunakan di erp
            function reject_view() {
                $echo = '<script type="text/javascript">
                             function submit_ajax(form_id) {
                                var remark = $("#setup_modul_remark").val();
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
                                        var url = "'.base_url().'processor/plc/setup_modul";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_setup_modul").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_setup_modul");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_setup_modul_reject" action="'.base_url().'processor/plc/setup_modul?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="iM_modul" value="'.$this->input->get('iM_modul').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark" id="reject_setup_modul_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_setup_modul_reject\')">Reject</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            }
    
    
            
            function reject_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $iM_modul = $post['iM_modul'];
                $iupb_id = $post['iupb_id'];
                $vRemark = $post['vRemark'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $modul_id = $post['modul_id'];
    
                //Letakan Query Update reject disini
                $data=array('iapprove'=>'1');
                $this -> db -> where('iM_modul', $iM_modul);
                $updet = $this -> db -> update('erp_privi.m_modul', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_modul = $isAndSort['iM_modul'];
                $iSort = $isAndSort['iSort'];
                
                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iM_modul,$iM_modul,$iSort,$vRemark,1);
    
                $data['status']  = true;
                $data['last_id'] = $post['iM_modul'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }


    function getHistory($iupb_id,$iTujuan_req){

        $sql = 'select a.vreq_ori_no , date(a.tcreate) as tcreate , a.tapppd as tapppd,a.vnip_apppd  
                from erp_privi.m_modul a 
                where 
                a.ldeleted=0
                and a.iupb_id= "'.$iupb_id.'"  
                and a.iTujuan_req= "'.$iTujuan_req.'"  
                order by iM_modul
        ';
        
        return $sql;
    }
    function getDetail(){
        $ireqdet_id = $_POST['ireqdet_id'];
        $sql = 'select d3.vjenis_mikro
                from plc2.plc2_upb_request_sample_detail a 
                join plc2.plc2_upb_request_sample b on b.ireq_id=a.ireq_id
                join plc2.plc2_raw_material c on c.raw_id=a.raw_id
                join plc2.plc2_upb d on d.iupb_id=b.iupb_id
                join plc2.plc2_upb_ro_detail d1 on d1.ireq_id = a.ireq_id and d1.raw_id = a.raw_id
                join plc2.plc2_upb_po e on e.ipo_id = d1.ipo_id
                join plc2.plc2_upb_ro f on f.iro_id = d1.iro_id
                join plc2.plc2_upb_ro_detail_jenis d2 on d2.irodet_id=d1.irodet_id
                join plc2.plc2_master_jenis_uji_mikro d3 on d3.ijenis_mikro=d2.ijenis_mikro
                where a.ldeleted=0
                and b.ldeleted=0
                and c.ldeleted=0
                and d.ldeleted=0
                and d2.ldeleted=0
                and d.ihold = 0
                and d.iKill = 0
                and d.itipe_id <> 6
                and d1.ldeleted=0
                and e.ldeleted=0
                and f.ldeleted=0
                and d1.iUjiMikro_bb = 1
                and d1.trec_date_qa is not null
                and a.ireqdet_id in ("'.$ireqdet_id.'")
                #and a.ireqdet_id in ("1676")
                ';

        $data['datas'] = $this->db->query($sql)->result_array();
        return $this->load->view('partial/modul/uji_mikro_bb_jenis_detail',$data,TRUE);   

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


    

    
    function output(){
        $this->index($this->input->get('action'));
    }
    
    function updateBox_setup_modul_vKode_modul($field, $id, $value, $rowData) {
        return $value.' ( '.$rowData[$this->main_table_pk].' )';
    }
    
    function updateBox_setup_modul_vNama_activity($field, $id, $value, $rowData) {
        return $value;
    }

    function updateBox_setup_modul_idprivi_modules($field, $id, $value, $rowData) {
        $sql = 'SELECT m.vNameModule FROM erp_privi.privi_modules m WHERE m.idprivi_modules = ? AND m.isDeleted = 0 ';
        $apps = $this->db->query($sql, array($value))->row_array();
        $return = (!empty($apps))?$apps['vNameModule']:'-';
        return $return;
    }

    function updateBox_setup_modul_iM_application($field, $id, $value, $rowData) {
        $sql = 'SELECT a.vAplication_code, a.vDesciption FROM erp_privi.m_application a WHERE a.iM_application = ? AND a.lDeleted = 0';
        $apps = $this->db->query($sql, array($value))->row_array();
        $return = (!empty($apps))?$apps['vAplication_code'].' - '.$apps['vDesciption']:'-';
        return $return;
    } 

    function updateBox_setup_modul_iType_modul($field, $id, $value, $rowData) {
        $return = '<select name="'.$field.'"  id="'.$id.'">';
        foreach ($this->tipe_modul as $k => $v) {
            $selected = ( $value == $v ) ? 'selected' : '';
            $return .= '<option '.$selected.' value="'.$k.'">'.$v.'</option>';
        }
        $return .= '</select>';
        return $return;
    }
    
    function updateBox_setup_modul_vDesciption($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                    $return= '<label title="Note">'.nl2br($value).'</label>'; 
            }else{ 
                $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250">'.nl2br($value).'</textarea>';

            }
            
        return $return;
    }

    function updateBox_setup_modul_vTable_name($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                    $return= '<label title="Note">'.nl2br($value).'</label>'; 
            }else{ 
                $sql = 'SELECT CONCAT(TABLE_SCHEMA,".",TABLE_NAME) AS TABLE_NAME FROM information_schema.TABLES ORDER BY TABLE_NAME ASC';
                $tableList = $this->db->query($sql)->result_array();
                $return = '<select name="'.$field.'"  id="'.$id.'">';
                foreach ($tableList as $v) {
                    $selected = ( $value == $v['TABLE_NAME'] ) ? 'selected' : '';
                    $return .= '<option '.$selected.' value="'.$v['TABLE_NAME'].'">'.$v['TABLE_NAME'].'</option>';
                }
                $return .= '</select>';
                // $return = '<input name="'.$field.'" id="'.$id.'" value="'.$value.'" />';
            }
            
        return $return;
    }

    function updateBox_setup_modul_vDept_author($field, $id, $value, $rowData) {
            // if ($this->input->get('action') == 'view') {
            //         $return= '<label title="Note">'.nl2br($value).'</label>'; 
            // }else{ 
            //     $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250">'.nl2br($value).'</textarea>';

            // }

        $dept        = $this->db->get_where('erp_privi.m_dept', array('lDeleted' => 0))->result_array();
        $return      = '<select name="'.$field.'"  id="'.$id.'">';
        $return     .= '    <option value="">--Pilih--</option>';
        foreach ($dept as $d) {
            $selected = ($value == $d['vKode_dept'])?'selected':'';
            $return .= '    <option '.$selected.' value="'.$d['vKode_dept'].'">'.$d['vKode_dept'].' - '.$d['vNama_dept'].'</option>';
        }
        $return     .= '</select>';
        return $return;
    }

    function updateBox_setup_modul_vNip_author($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                    $return= '<label title="Note">'.nl2br($value).'</label>'; 
            }else{ 
                $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250">'.nl2br($value).'</textarea>';

            }
            
        return $return;
    }

    function updateBox_setup_modul_vDept_participant($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                    $return= '<label title="Note">'.nl2br($value).'</label>'; 
            }else{ 
                $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250">'.nl2br($value).'</textarea>';

            }
            
        return $return;
    }  

    function updateBox_setup_modul_vNip_participant($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                    $return= '<label title="Note">'.nl2br($value).'</label>'; 
            }else{ 
                $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250">'.nl2br($value).'</textarea>';

            }
            
        return $return;
    }  

    function updateBox_setup_modul_detail_activity($field, $id, $value, $rowData) {
        $sql = "SELECT * FROM erp_privi.m_activity a WHERE a.lDeleted = 0 ";
        $data['activities'] = $this->db->query($sql)->result_array();
        $sql = "SELECT * FROM erp_privi.m_modul_activity pr 
                JOIN erp_privi.m_modul b ON b.iM_modul = pr.iM_modul
                WHERE b.iM_modul = ? AND pr.lDeleted=0
                ORDER BY pr.iSort ASC ";
        $data['rows'] = $this->db->query($sql, array($rowData['iM_modul']))->result_array();
            
        /*DataActivity*/
        $this->db->where('lDeleted',0);
        $data['listActivity']=$this->db->get('erp_privi.m_activity')->result_array();

        // return $this->load->view('setup_modul_detail_activity',$data,TRUE);
        $data['get']=$this->input->get();
        $data['id']=$this->input->get('id');
        $return = $this->load->view('setup_modul_activity_detail',$data,TRUE);
        return $return;
    }  

    function updateBox_setup_modul_detail_field($field, $id, $value, $rowData) {
        $sql = "SELECT * FROM erp_privi.m_activity a WHERE a.lDeleted = 0 ";
        $data['activities'] = $this->db->query($sql)->result_array();
        $sql = "SELECT * FROM erp_privi.m_modul_activity pr 
                JOIN erp_privi.m_modul b ON b.iM_modul = pr.iM_modul
                WHERE b.iM_modul = ? AND pr.lDeleted=0
                ORDER BY pr.iSort ASC ";
        $data['rows'] = $this->db->query($sql, array($rowData['iM_modul']))->result_array();
            
        /*DataActivity*/
        $this->db->where('lDeleted',0);
        $data['listField']=$this->db->get('erp_privi.m_jenis_field')->result_array();

        // return $this->load->view('setup_modul_detail_activity',$data,TRUE);
        $data['get']=$this->input->get();
        $data['id']=$this->input->get('id');
        return $this->load->view('setup_modul_field_detail',$data,TRUE);
    }    

    function updateBox_setup_modul_detail_setup($field, $id, $value, $rowData) {
        $url    = base_url().'processor/brosur/setup/modul/activity/'; 
        $url2   = base_url().'processor/brosur/setup/modul/field/';

        $return      = '<table width="100%" style="margin-top:10px;margin-bottom:10px;">';
        $return     .= '<tr>';
        $return     .= '    <td>';
        $return     .= '        <script type="text/javascript">';
        $return     .= '            $(document).ready(function() {    
                                        $("#'.$this->url.'_setup_application").tabs();
                                        browse_tab(\''.$url.'?iM_modul='.$rowData['iM_modul'].'&company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&group_id='.$this->input->get('group_id').'\',\'USER GROUP\', \''.$this->url.'_module\');                        
                                        browse_tab(\''.$url2.'?iM_modul='.$rowData['iM_modul'].'&company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&group_id='.$this->input->get('group_id').'\',\'GROUP\', \''.$this->url.'_group\');  
                                    }); ';
        $return     .= '        </script>';
        $return     .= '        <div id="'.$this->url.'_setup_application" width="100%">';
        $return     .= '            <ul>                        
                                        <li><a href="#'.$this->url.'_module">Setup Activity</a></li>
                                        <li><a href="#'.$this->url.'_group">Setup Fields</a></li>
                                    </ul>                      
                                    <div id="'.$this->url.'_module"></div>
                                    <div id="'.$this->url.'_group"></div>
                                </div> ';
        $return     .= '    </td>';            
        $return     .= '<tr>';            
        $return     .= '</table>';
        $return     .= '<script>
                            var sa = $("label[for=\'setup_modul_detail_setup\']");
                            var input = sa.parent().find("div").css({"margin":"0px"});
                            sa.remove();
                        </script>';
        return $return;
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



    function before_update_processor($row, $postData) {
        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;
        unset($postData['vKode_modul']);
        unset($postData['idprivi_modules']);
        unset($postData['iM_application']);
        return $postData; 
    }


    function after_update_processor($fields, $id, $postData) { 
        $cNip = $this->user->gNIP; 
        $skg=date('Y-m-d H:i:s');

    }


    /*Manipulate Insert/Update Form*/
    function insertBox_setup_modul_form_detail($field,$id){
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

    function updateBox_setup_modul_form_detail($field,$id,$value,$rowData){
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

    function download($vFilename) { 
        $this->load->helper('download');        
        $name = $vFilename;
        $id = $_GET['id'];
        $tempat = $_GET['path'];    
        $path = file_get_contents('./files/plc/local/uji_mikro_bb/'.$tempat.'/'.$id.'/'.$name);    
        force_download($name, $path);


    }


    function getFormDetail(){
        $post=$this->input->post();
        $get=$this->input->get();
        $data['html']="";

        $sqlFields = 'select * from erp_privi.m_modul_fields a where a.lDeleted=0 and  a.iM_modul='.$this->iModul_id.' order by a.iSort ASC';
        $dFields = $this->db->query($sqlFields)->result_array();

        $hate_emel = "";

        if($get['formaction']=='update'){
                $aidi = $get['id'];
        }else{
                $aidi = 0;
        }

        $hate_emel .= '
            <table class="hover_table" style="width:60%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
                <thead>
                    <tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
                        <th style="border: 1px solid #dddddd;">Activity Name</th>
                        <th style="border: 1px solid #dddddd;">Status</th>
                        <th style="border: 1px solid #dddddd;">at</th>      
                        <th style="border: 1px solid #dddddd;">by</th>      
                        <th style="border: 1px solid #dddddd;">Remark</th>      
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
                $data_field['get']= $get;
                $data_field['post']= $post;

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

                $return_field="";
                if($get['formaction']=='update'){
                    $id = $get['id'];

                    $sqlGetMainvalue= 'select * from '.$this->main_table.' where lDeleted=0 and '.$this->main_table_pk.'= '.$id.'   ';
                    $dataHead = $this->db->query($sqlGetMainvalue)->row_array();

                    $data_field['dataHead']= $dataHead;
                    $data_field['main_table_pk']= $this->main_table_pk;
                    
                    if($form_field['iM_jenis_field'] == 6){
                        $data_field['vSource_input']= $form_field['vSource_input_edit'] ;
                    }else{
                        $data_field['vSource_input']= $form_field['vSource_input_edit'] ;
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
        return json_encode($data);
    }

    function get_data_prev(){
        $post=$this->input->post();
        $get=$this->input->get();
        $nmTable=isset($post["nmTable"])?$post["nmTable"]:"0";
        $grid=isset($post["grid"])?$post["grid"]:"0";
        $grid=isset($post["grid"])?$post["grid"]:"0";
        $namefield=isset($post["namefield"])?$post["namefield"]:"0";

        $this->db_plc0->select("*")
                    ->from("plc2.sys_masterdok")
                    ->where("filename",$namefield);
        $row=$this->db_plc0->get()->row_array();
        
        $where=array('lDeleted'=>0,$row["fieldheader"]=>$post["id"]);
        $this->db_plc0->where($where);
        $q=$this->db_plc0->get($row["filetable"]);
        $rsel=array($row["ffilename"],$row["fvketerangan"],'iact');
        $data = new StdClass;
        $data->records=$q->num_rows();
        $i=0;
        foreach ($q->result() as $k) {
            $data->rows[$i]['id']=$i;
            $z=0;

            $value=$k->vFilename_generate;
            $id=$k->{$row["fieldheader"]};
            $linknya = 'No File';
            if($value != '') {
                if (file_exists('./'.$row["filepath"].'/'.$id.'/'.$value)) {
                    $link = base_url().'processor/'.$this->urlpath.'?action=download&id='.$id.'&file='.$value.'&path='.$row['filename'];
                    $linknya = '<a class="ui-button-text" href="javascript:;" onclick="window.location=\''.$link.'\'">[Download]</a>&nbsp;&nbsp;&nbsp;';
                }
            }
            $linknya=$linknya.'<a class="ui-button-text" href="javascript:;" onclick="javascript:hapus_row_'.$nmTable.'('.$i.')">[Hapus]</a><input type="hidden" class="num_rows_'.$nmTable.'" value="'.$i.'" /><input type="hidden" name="'.$row["fielddetail"].'[]" value="'.$k->{$row["fielddetail"]}.'" />';


            foreach ($rsel as $dsel => $vsel) {
                if($vsel=="iact"){
                    $dataar[$dsel]=$linknya;
                }else{
                    $dataar[$dsel]=$k->{$vsel};
                }
                $z++;
            }
            $data->rows[$i]['cell']=$dataar;
            $i++;
        }
        return json_encode($data);
    }


}
