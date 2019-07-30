<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class master_departement extends MX_Controller {
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
        $this->main_table='erp_privi.m_dept';
        $this->main_table_pk='iM_dept';


        $this->title = 'Departement';
        $this->url = 'master_departement';
        $this->urlpath = 'plc/'.str_replace("_","/", $this->url);

        $this->maintable = 'erp_privi.m_dept';  
        $datagrid['islist'] = array(
                                        'vKode_dept' => array('label'=>'Kode Departement','width'=>100,'align'=>'center','search'=>false)
                                        ,'vNama_dept' => array('label'=>'Nama Departement','width'=>250,'align'=>'left','search'=>false)
                                        ,'vDesciption' => array('label'=>'Description','width'=>300,'align'=>'left','search'=>false)
                                    );
        $datagrid['shortBy']=array('iM_dept'=>'Desc');

        

        $datagrid['setQuery']=array(
                                    1=>array('vall'=>'lDeleted','nilai'=>0)
                                
                                );
        
        
        $datagrid['isField'] = array(
			'vKode_dept' => array('label'=>'Code','require'=>true)
            ,'vNama_dept' => array('label'=>'Name','require'=>true)
            ,'vDesciption' => array('label'=>'Description','require'=>true)
        );
        

      /*   $datagrid['jointableinner']=array(
                                    #0=>array('plc2.plc2_upb_formula'=>'plc2_upb_formula.ifor_id=mikro_fg.ifor_id')
                                    0=>array('plc2.plc2_upb_request_sample_detail'=>'plc2.plc2_upb_request_sample_detail.ireqdet_id = erp_privi.m_dept.ireqdet_id'),
                                    1=>array('plc2.plc2_upb_request_sample'=>'plc2.plc2_upb_request_sample.ireq_id = plc2.plc2_upb_request_sample_detail.ireq_id'),
                                    2=>array('plc2.plc2_raw_material'=>'plc2.plc2_raw_material.raw_id = plc2.plc2_upb_request_sample_detail.raw_id'),
                                    3=>array('plc2.plc2_upb'=>'plc2.plc2_upb_request_sample.iupb_id = plc2.plc2_upb.iupb_id')
                                ); */
        


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
            if($kv=='setQuery'){
                foreach ($vv as $kv => $vlist) {
                    $grid->setQuery($vlist['vall'], $vlist['nilai']);


                    
                }
            }

        }


        $grid->changeFieldType('iApprove_uji','combobox','',array(0=>'Waiting Approval', 1=>'Rejected', 2=>'Approved'));
        $grid->changeFieldType('iSubmit','combobox','',array(0=>'Draft - Need to be Submitted', 1=>'Submitted'));
        $grid->changeFieldType('iTujuan_req','combobox','',array(1=>'Untuk Sample', 2=>'Untuk Pilot'));

        
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

            case 'download':
                $this->load->helper('download');        
                $name = $_GET['file'];
                $id = $_GET['id'];
                $path = $_GET['path'];

                $this->db_plc0->select("*")
                    ->from("plc2.sys_masterdok")
                    ->where("filename",$path);
                $row=$this->db_plc0->get()->row_array();

                if(count($row)>0 && isset($row["filepath"])){
                    $path = file_get_contents('./'.$row['filepath'].'/'.$id.'/'.$name); 
                    force_download($name, $path);
                }else{
                    echo "File Not Found - 0x01";
                }

                
                break;

            case 'uploadFile':
                $lastId=$this->input->get('lastId');
                $dataFieldUpload=$this->lib_plc->getUploadFileFromField($this->input->get('modul_id'));
                if(count($dataFieldUpload)>0){
                    foreach ($dataFieldUpload as $kf => $vUpload) {
                        $pathf=$vUpload['filepath'];
                        $path = realpath($pathf);
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
                                $tmp_name = $_FILES['plc2_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file']["tmp_name"][$key];
                                $name =$_FILES['plc2_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file']["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');
                                $filenameori=$name;
                                $now_u = date('Y_m_d__H_i_s');

                                /*Cek Schema*/
                                $datatb=explode(".", $vUpload['filetable']);
                                $sql = "SELECT c.`COLUMN_NAME`,c.`COLUMN_KEY` , c.`COLUMN_TYPE`, c.`DATA_TYPE`, c.`CHARACTER_MAXIMUM_LENGTH` 
                                        FROM `information_schema`.`COLUMNS` c
                                        WHERE c.`TABLE_SCHEMA` = '".$datatb[0]."' AND c.`TABLE_NAME`='".$datatb[1]."'";

                                $qq=$this->db_plc0->query($sql);

                                if($qq->num_rows()>0){
                                    $namafield=array();
                                    foreach ( $qq->result_array() as $kky => $vvy) {
                                        $namafield[$vvy['COLUMN_NAME']]=1;
                                    }

                                    if(isset($namafield['vFilename_generate'])){

                                    }else{
                                        $sqlinsert="ALTER TABLE `".$datatb[1]."`
                                            ADD COLUMN `vFilename_generate` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Nama Generate Upload File' AFTER ".$vUpload['ffilename'];
                                        $this->db_plc0->query($sqlinsert);
                                    }


                                }else{
                                    echo "Table File Not Found";
                                    exit();
                                }

                                $name_generate = $i.'__'.$now_u.'__'.$name;
                                    if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name_generate)) {
                                        $datainsert=array();
                                        $datainsert[$vUpload['fieldheader']]=$lastId;
                                        $datainsert[$vUpload['fdcreate']]= date('Y-m-d H:i:s');
                                        $datainsert[$vUpload['fccreate']]= $this->user->gNIP;
                                        $datainsert[$vUpload['ffilename']]= $name;
                                        $datainsert['vFilename_generate']= $name_generate;
                                        $datainsert[$vUpload['fvketerangan']]= $fKeterangan[$i];
                                        $this->db_plc0->insert($vUpload['filetable'],$datainsert);
                                        $i++;   
                                    }
                                    else{
                                        echo "Upload ke folder gagal";  
                                    }
                            }
                        }
                    }
                    $r['message']="Data Berhasil Disimpan";
                    $r['status'] = TRUE;
                    $r['last_id'] = $this->input->get('lastId');                    
                    echo json_encode($r);

                }else{
                    $r['message']="Data Upload Not Found";
                    $r['status'] = TRUE;
                    $r['last_id'] = $this->input->get('lastId');                    
                    echo json_encode($r);
                }
                break;

            default:
                $grid->render_grid();
                break;
        }
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
                                var url = "'.base_url().'processor/plc/master_departement";                             
                                if(o.status == true) { 
                                    $("#alert_dialog_form").dialog("close");
                                         $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                         $("div#form_master_departement").html(data);
                                         
                                    });
                                    
                                }
                                    reload_grid("grid_master_departement");
                            }
                            
                         })
                     }
                 </script>';
        $echo .= '<h1>Approve</h1><br />';
        $echo .= '<form id="form_master_departement_approve" action="'.base_url().'processor/plc/master_departement?action=approve_process" method="post">';
        $echo .= '<div style="vertical-align: top;">';
        $echo .= 'Remark : 
                <input type="hidden" name="iM_dept" value="'.$this->input->get('iM_dept').'" />
                <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                
                <textarea name="vRemark"></textarea>
        <button type="button" onclick="submit_ajax(\'form_master_departement_approve\')">Approve</button>';
            
        $echo .= '</div>';
        $echo .= '</form>';
        return $echo;
    } 

    function approve_process() {
        $post = $this->input->post();
        $cNip= $this->user->gNIP;
        $vName= $this->user->gName;
        $iM_dept = $post['iM_dept'];
        $iupb_id = $post['iupb_id'];
        
        $vRemark = $post['vRemark'];
        $modul_id = $post['modul_id'];


        //Letakan Query Update approve disini
        $data=array('iapprove'=>'2');
        $this -> db -> where('iM_dept', $iM_dept);
        $updet = $this -> db -> update('erp_privi.m_dept', $data);

        $iM_modul_activity = $post['iM_modul_activity'];
        $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
        $iM_activity = $isAndSort['iM_activity'];
        $iSort = $isAndSort['iSort'];

        $arrUPB['iupb_id'] = $iupb_id;
        $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iM_dept,$iM_activity,$iSort,$vRemark,2);

        $data['status']  = true;
        $data['last_id'] = $post['iM_dept'];
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
                                var url = "'.base_url().'processor/plc/master_departement";                             
                                if(o.status == true) { 
                                    $("#alert_dialog_form").dialog("close");
                                         $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                         $("div#form_master_departement").html(data);
                                         
                                    });
                                    
                                }
                                    reload_grid("grid_master_departement");
                            }
                            
                         })
                     }
                 </script>';
        $echo .= '<h1>Confirm</h1><br />';
        $echo .= '<form id="form_master_departement_confirm" action="'.base_url().'processor/plc/master_departement?action=confirm_process" method="post">';
        $echo .= '<div style="vertical-align: top;">';
        $echo .= 'Remark : 
                <input type="hidden" name="iM_dept" value="'.$this->input->get('iM_dept').'" />
                <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                
                <textarea name="vRemark"></textarea>
        <button type="button" onclick="submit_ajax(\'form_master_departement_confirm\')">Confirm</button>';
            
        $echo .= '</div>';
        $echo .= '</form>';
        return $echo;
    } 

    function confirm_process() {
        $post = $this->input->post();
        $cNip= $this->user->gNIP;
        $vName= $this->user->gName;
        $iM_dept = $post['iM_dept'];
        $iupb_id = $post['iupb_id'];
        $vRemark = $post['vRemark'];
        $iM_modul_activity = $post['iM_modul_activity'];
        $modul_id = $post['modul_id'];

        //Letakan Query Update approve disini
        $data=array('iApprove_uji'=>'2');
        $this -> db -> where('iM_dept', $iM_dept);
        $updet = $this -> db -> update('erp_privi.m_dept', $data);

        $iM_modul_activity = $post['iM_modul_activity'];
        $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
        $iM_activity = $isAndSort['iM_activity'];
        $iSort = $isAndSort['iSort'];
        
        $arrUPB['iupb_id'] = $iupb_id;
        $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iM_dept,$iM_activity,$iSort,$vRemark,2);

        
        $data['status']  = true;
        $data['last_id'] = $post['iM_dept'];
        $data['group_id'] = $post['group_id'];
        $data['modul_id'] = $post['modul_id'];
        return json_encode($data);
    }


    //Ini Merupakan Standart Reject yang digunakan di erp
    function reject_view() {
        $echo = '<script type="text/javascript">
                     function submit_ajax(form_id) {
                        var remark = $("#master_departement_remark").val();
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
                                var url = "'.base_url().'processor/plc/master_departement";                             
                                if(o.status == true) { 
                                    $("#alert_dialog_form").dialog("close");
                                         $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                         $("div#form_master_departement").html(data);
                                         
                                    });
                                    
                                }
                                    reload_grid("grid_master_departement");
                            }
                            
                         })
                     }
                 </script>';
        $echo .= '<h1>Reject</h1><br />';
        $echo .= '<form id="form_master_departement_reject" action="'.base_url().'processor/plc/master_departement?action=reject_process" method="post">';
        $echo .= '<div style="vertical-align: top;">';
        $echo .= 'Remark : 
                <input type="hidden" name="iM_dept" value="'.$this->input->get('iM_dept').'" />
                <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                
                <textarea name="vRemark" id="reject_master_departement_remark"></textarea>
        <button type="button" onclick="submit_ajax(\'form_master_departement_reject\')">Reject</button>';
            
        $echo .= '</div>';
        $echo .= '</form>';
        return $echo;
    }


    
    function reject_process() {
        $post = $this->input->post();
        $cNip= $this->user->gNIP;
        $vName= $this->user->gName;
        $iM_dept = $post['iM_dept'];
        $iupb_id = $post['iupb_id'];
        $vRemark = $post['vRemark'];
        $iM_modul_activity = $post['iM_modul_activity'];
        $modul_id = $post['modul_id'];

        //Letakan Query Update reject disini
        $data=array('iapprove'=>'1');
        $this -> db -> where('iM_dept', $iM_dept);
        $updet = $this -> db -> update('erp_privi.m_dept', $data);

        $iM_modul_activity = $post['iM_modul_activity'];
        $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
        $iM_activity = $isAndSort['iM_activity'];
        $iSort = $isAndSort['iSort'];
        
        $arrUPB['iupb_id'] = $iupb_id;
        $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$iM_dept,$iM_activity,$iSort,$vRemark,1);

        $data['status']  = true;
        $data['last_id'] = $post['iM_dept'];
        $data['group_id'] = $post['group_id'];
        $data['modul_id'] = $post['modul_id'];
        return json_encode($data);
    }


    function getHistory($iupb_id,$iTujuan_req){

        $sql = 'select a.vreq_ori_no , date(a.tcreate) as tcreate , a.tapppd as tapppd,a.vnip_apppd  
                from erp_privi.m_dept a 
                where 
                a.ldeleted=0
                and a.iupb_id= "'.$iupb_id.'"  
                and a.iTujuan_req= "'.$iTujuan_req.'"  
                order by iM_dept
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

        function insertBox_master_departement_vKode_dept($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="4"  />';
        return $return;
    }
    
    function updateBox_master_departement_vKode_dept($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                    $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="4" value="'.$value.'"/>';

            }
            
        return $return;
    }
    
    function insertBox_master_departement_vNama_dept($field, $id) {
        $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30"  />';
        return $return;
    }
    
    function updateBox_master_departement_vNama_dept($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                    $return= $value; 
            }else{ 
                $return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1  required" size="30" value="'.$value.'"/>';

            }
            
        return $return;
    }
    
    function insertBox_master_departement_vDesciption($field, $id) {
        $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250"></textarea>';
        return $return;
    }
    
    function updateBox_master_departement_vDesciption($field, $id, $value, $rowData) {
            if ($this->input->get('action') == 'view') {
                    $return= '<label title="Note">'.nl2br($value).'</label>'; 
            }else{ 
                $return = '<textarea name="'.$field.'" id="'.$id.'" class="required" style="width: 240px; height: 75px;" size="250" maxlength ="250">'.nl2br($value).'</textarea>';

            }
            
        return $return;
    }
    

    function before_insert_processor($row, $postData) {
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated']=$this->user->gNIP;      
        return $postData;

    }



    function before_update_processor($row, $postData) {

        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;

        $controller_name ='master_departement';
        $pk_field = 'iM_dept';
        $gabung = $controller_name."_".$pk_field;
        $peka=$postData[$gabung];
        
        return $postData; 
    }





    /*Manipulate Insert/Update Form*/
    function insertBox_master_departement_form_detail($field,$id){
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

    function updateBox_master_departement_form_detail($field,$id,$value,$rowData){
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

        $sqlFields = 'select * from plc3.m_modul_fields a where a.lDeleted=0 and  a.iM_modul='.$this->iModul_id.' order by a.iSort ASC';
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
