<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_export_draft_soi_bb extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('lib_refor');
        $this->modul_id = $this->input->get('modul_id');
        $this->iModul_id = $this->lib_refor->getIModulID($this->input->get('modul_id'));
        $this->db = $this->load->database('hrd',false, true);
        $this->load->library('auth');
        $this->user = $this->auth->user();

        $this->team = $this->lib_refor->hasTeam($this->user->gNIP);
        $this->teamID = $this->lib_refor->hasTeamID($this->user->gNIP);
        $this->isAdmin=$this->lib_refor->isAdmin($this->user->gNIP);

		$this->title = 'Draft SOI BB';
		$this->url = 'v3_export_draft_soi_bb';
		$this->urlpath = 'reformulasi/'.str_replace("_","/", $this->url);

		$this->maintable = 'reformulasi.export_export_draft_soi_bb';	
		$this->main_table = $this->maintable;	
		$this->main_table_pk = 'iexport_draft_soi_bb';	
		$datagrid['islist'] = array(
			'vtitle' 								=> array('label' => 'Tujuan Request', 			'width' => 150,	'align' => 'center',	'search'=>true),
			'export_req_refor.vno_export_req_refor' => array('label' => 'No request Refor',			'width' => 100,	'align' => 'center',	'search'=>true),
			'dossier_upd.vUpd_no' 					=> array('label' => 'No UPD',					'width' => 75,	'align' => 'center',	'search'=>true),
			'dossier_upd.vNama_usulan' 				=> array('label' => 'Nama Usulan',				'width' => 250,	'align' => 'left',		'search'=>true),
			'isubmit'	 							=> array('label' => 'Submit',					'width' => 100,	'align' => 'left',		'search'=>true),
			'iapppd'	 							=> array('label' => 'Approval PD',				'width' => 100,	'align' => 'left',		'search'=>true),
		);		

		$datagrid['setQuery'] = array(
			0 => array('vall' => 'export_req_refor.lDeleted', 		'nilai' => 0),
			1 => array('vall' => 'export_bahan_kemas.ldeleted', 	'nilai' => 0),
			2 => array('vall' => 'dossier_upd.lDeleted', 			'nilai' => 0),
			3 => array('vall' => 'export_bahan_kemas.ijenis_bk',	'nilai' => 1),
		);

		$datagrid['jointableinner'] = array(
			0 => array('reformulasi.export_req_refor' 	=> 'export_bahan_kemas.iexport_req_refor = export_req_refor.iexport_req_refor'),
			1 => array('dossier.dossier_upd' 			=> 'export_req_refor.idossier_upd_id = export_req_refor.idossier_upd_id'),
		);

		$datagrid['shortBy'] = array("export_bahan_kemas.iexport_bk_id" => "DESC");
		
		$this->datagrid = $datagrid;
    }

    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle($this->title);		
		$grid->setTable($this->maintable );
		$grid->setUrl($this->url);

		/*$grid->setGroupBy($this->setGroupBy);*/
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
				foreach ($vv as $list => $vlist) {
					$grid->setQuery($vlist['vall'], $vlist['nilai']);
				}
            }
            
            /* formula yang kesimpulan stabilita lolo */
           /*  $grid->setQuery('dossier_upd.iupb_id in (
                            select b.iupb_id 
                            from pddetail.formula_stabilita a 
                            join pddetail.formula_process b on a.iFormula_process=b.iFormula_process
                            where a.lDeleted=0
                            and b.lDeleted=0
                            and a.iKesimpulanStabilita=1
            ) ', NULL); */


		}

		$grid->changeFieldType('isubmit', 'combobox','',array('' => '--select--', 0 => 'Draft - Need to be Submit', 1 => 'Submited'));
		$grid->changeFieldType('iapppd', 'combobox','',array('' => '--select--', 0 => 'Waiting for approval', 1 => 'Rejected', 2 => 'Approved'));

		$grid->setGridView('grid');

		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;	
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
                $post       = $this->input->post();
                $isUpload   = $this->input->get('isUpload');
                $modul_field= $post['modul_fields'];
                $masterDok  = $this->db->get_where('erp_privi.m_modul_fields', array('lDeleted' => 0, 'iM_modul_fields' => $modul_field))->row_array();
                $path       = ( !empty($masterDok) ) ? $masterDok['vPath_upload'] : 'files/reformulasi/export/bahan_kemas_primer';
                $path       = realpath($path);

                if($isUpload) {
                    $lastId = $this->input->get('lastId');
                    if(!file_exists($path."/".$lastId)){
                        if (!mkdir($path."/".$lastId, 0777, true)) { //id review
                            $r['message'] = 'Failed Upload , Failed create Folder!';
                            $r['status'] = FALSE;
                            $r['last_id'] = $lastId;
                            echo json_encode($r);
                            die('Failed upload, try again!');
                        }
                    }
                    $ijenis_bk_id=array();
                    $fileketerangan = array();
                    foreach($_POST as $key=>$value) {
                        if ($key == 'fileketerangan') {
                            foreach($value as $k=>$v) {
                                $fileketerangan[$k] = $v;
                            }
                        }
                        if ($key == 'ijenis_bk_id') {
                            foreach($value as $k=>$v) {
                                $ijenis_bk_id[$k] = $v;
                            }
                        }
                    }
                    $i=0;
                    foreach ($_FILES['fileupload']["error"] as $key => $error) {
                        if ($error == UPLOAD_ERR_OK) {
                            $tmp_name = $_FILES['fileupload']["tmp_name"][$key];
                            $name =$_FILES['fileupload']["name"][$key];
                            $data['filename'] = $name;
                            $name_generate = $this->lib_refor->generateFilename($name);
                            $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name_generate)) {

                                    $insert['iM_modul_fileds']  = $modul_field;
                                    $insert['idHeader_File']    = $lastId;
                                    $insert['ijenis_bk_id']     = $ijenis_bk_id[$i];
                                    $insert['vFilename']        = $data['filename'];
                                    $insert['vFilename_generate']= $name_generate;
                                    $insert['tKeterangan']      = $fileketerangan[$i];
                                    $insert['dCreate']          = $data['dInsertDate'];
                                    $insert['cCreate']          = $this->user->gNIP;    
                                    $insert['iDeleted']         = 0;
                                    $this->db->insert('reformulasi.group_file_upload', $insert);

                                    $i++;
                                }
                                else{
                                    echo "Upload ke folder gagal";
                                }
                        }
                    }

                    $r['message'] = 'Data Berhasil di Simpan!';
                    $r['status'] = TRUE;
                    $r['last_id'] = $this->input->get('lastId');
                    echo json_encode($r);
                }  else {
                    echo $grid->saved_form();
                }
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
                $isUpload   = $this->input->get('isUpload'); 
                $post       = $this->input->post();
                $lastId     = $post[$this->url.'_'.$this->main_table_pk];
                $modul_field= $post['modul_fields'];
                $masterDok  = $this->db->get_where('erp_privi.m_modul_fields', array('lDeleted' => 0, 'iM_modul_fields' => $modul_field))->row_array(); 
                $path       = ( !empty($masterDok) ) ? $masterDok['vPath_upload'] : 'files/reformulasi/export/bahan_kemas_primer';
                $path       = realpath($path.'/');
                $filesUpload= $this->db->get_where('reformulasi.group_file_upload', array('iDeleted' => 0, 'iM_modul_fileds' => $modul_field, 'idHeader_File' => $lastId))->result_array();

                if(!file_exists($path."/".$lastId)){
                    if (!mkdir($path."/".$lastId, 0777, true)) { //id review
                        die('Failed upload, try again!');
                    }
                }

                $fileketerangan     = array();
                $ifileid            = array();
                $ijenis_bk_id       = array();
                $fileid             = '';
                $j                  = 0;
                $tgl                = date('Y-m-d H:i:s');

                foreach($_POST as $key=>$value) {

                    if ($key == 'fileid') {
                        $i=0;
                        foreach($value as $k=>$v) {
                            $ifileid[$k] = $v;
                            if ($i == 0) {
                                $fileid .= "'".$v."'";
                            } else {
                                $fileid .= ",'".$v."'";
                            }

                            if($v != ''){
                                $j++;
                            }

                            $i++;
                        }
                    }
                    if ($key == 'fileketerangan') {
                        foreach($value as $y=>$u) {
                            $fileketerangan[$y] = $u;
                        }
                    }
                    if ($key == 'namafile') {
                        foreach($value as $k => $v) {
                            $namafile[$k] = $v;
                        }
                    }
                    if ($key == 'ijenis_bk_id') {

                        foreach($value as $k=>$v) {
                            $ijenis_bk_id[$k] = $v;
                        }
                    }
                }

                if($fileid!=''){
                    // $sql1="UPDATE plc2.plc2_upb_file_bahan_kemas SET ldeleted = 1, dUpdateDate = ?, cUpdated = ? WHERE ibk_id = ? AND id NOT IN (".$fileid.")";
                    $sql1 = "UPDATE reformulasi.group_file_upload SET iDeleted = 1, dUpdate = ?, cUpdate = ? WHERE idHeader_File = ? AND iM_modul_fileds = ? AND iFile NOT IN (".$fileid.")";
                    $this->db->query($sql1, array($tgl, $this->user->gNIP, $lastId, $modul_field));
                }

                foreach ($ifileid as $if => $va) {
                    if($va != ''){
                        try {
                            $sql2 = "UPDATE reformulasi.group_file_upload SET ijenis_bk_id = ?, dUpdate = ?, cUpdate = ? WHERE iFile = ? AND iM_modul_fileds = ? ";
                            $this->db->query($sql2, array($ijenis_bk_id[$if], $tgl, $this->user->gNIP, $va, $modul_field));
                        }catch(Exception $e) {
                            die($e);
                        }
                        // $s[]="UPDATE plc2.plc2_upb_file_bahan_kemas SET ijenis_bk_id = ".$ijenis_bk_id[$if].", dUpdateDate = '".$tgl."', cUpdated = '".$this->user->gNIP."' WHERE id = ".$va;
                    }
                }


                if($isUpload) {
                    if (isset($_FILES['fileupload']))  {
                        $i=0;
                        foreach ($_FILES['fileupload']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['fileupload']["tmp_name"][$key];
                                $name =$_FILES['fileupload']["name"][$key];
                                $data['filename'] = $name;
                                $name_generate = $this->lib_refor->generateFilename($name);
                                $data['dInsertDate'] = date('Y-m-d H:i:s');
                                if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name_generate)) {
                                    $insert['iM_modul_fileds']  = $modul_field;
                                    $insert['idHeader_File']    = $lastId;
                                    $insert['ijenis_bk_id']     = $ijenis_bk_id[$i];
                                    $insert['vFilename']        = $data['filename'];
                                    $insert['vFilename_generate']= $name_generate;
                                    $insert['tKeterangan']      = $fileketerangan[$i];
                                    $insert['dCreate']          = $data['dInsertDate'];
                                    $insert['cCreate']          = $this->user->gNIP;    
                                    $insert['iDeleted']         = 0;
                                    $this->db->insert('reformulasi.group_file_upload', $insert);

                                    $i++;
                                    $j++;
                                }
                                else{
                                    echo "Upload ke folder gagal";
                                }
                            }

                        }

                    }

                    $r['message'] = 'Data Berhasil di Simpan!';
                    $r['status'] = TRUE;
                    $r['last_id'] = $this->input->get('lastId');
                    echo json_encode($r);
                    exit();
                }  else {
                    echo $grid->updated_form();
                }

                break;	
			case 'delete':
				echo $grid->delete_row();
				break;

			/*Option Case*/
			case 'getFormDetail':
				echo $this->getFormDetail();
				break;
			case 'get_data_prev':
				echo $this->get_data_prev();
				break;

			/*Confirm*/
			case 'confirm':
                echo $this->confirm_view();
                break;
            case 'confirm_process':
                echo $this->confirm_process();
                break;

             /*Confirm*/
			case 'approve':
                echo $this->approve_view(2);
                break;
            case 'reject':
                echo $this->approve_view(1);
                break;
            case 'approve_process':
                echo $this->approve_process();
                break;

			case 'download':
		        $this->load->helper('download');        
		        $name = $this->input->get('file');
		        $id = $_GET['id'];
		        $tempat = $_GET['path'];    
		        $path = file_get_contents('./'.$tempat.'/'.$id.'/'.$name);    
		        force_download($name, $path);
				break;

            case 'cekjnsbk':
                $id=$this->input->post('id');
                $sql='SELECT mbk.itipe_bk AS idtipe_bk FROM plc2.plc2_master_jenis_bk mbk WHERE mbk.ldeleted=0 AND mbk.ijenis_bk_id = ?';
                $dt=$this->db->query($sql, array($id))->row_array();
                $data['id']=$dt['idtipe_bk'];
                $data['value']=$id;
                echo json_encode($data);
                break;
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));
    }

    function manipulate_update_button($buttons, $rowData) { 
        $fieldpeka=$this->main_table_pk;
        $peka=$rowData[$this->main_table_pk];
        $iupb_id=$this->lib_refor->getUpbId($fieldpeka,$rowData[$fieldpeka]);

        $cNip= $this->user->gNIP;
        $data['upload'] = 'uploadCustomGrid';
        $js = $this->load->view('js/standard_js', $data, TRUE);
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="'.$this->url.'_frame" id="'.$this->url.'_frame" height="0" width="0"></iframe>';
        

        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        }
        else{ 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_refor->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?draft=true&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',this,true )"  id="button_update_draft_'.$this->url.'"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_refor->get_current_module_activities($this->modul_id,$peka);
                    $getLastStatusApprove = $this->lib_refor->getLastStatusApprove($this->modul_id,$peka);

                    foreach ($activities as $act) {
                        $update_draft = '<button onclick="javascript:update_draft_btn(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?draft=true&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',this,true )"  id="button_update_draft_'.$this->url.'"  class="ui-button-text icon-save" >Update As Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?company_id='.$this->input->get('company_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_'.$this->url.'"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/'.$this->urlpath.'?action=approve&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$fieldpeka.'='.$rowData[$fieldpeka].'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_'.$this->url.'"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/'.$this->urlpath.'?action=reject&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_'.$this->url.'"  class="ui-button-text icon-save" >Reject</button>';

                        $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/'.$this->urlpath.'?action=confirm&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$fieldpeka.'='.$rowData[$fieldpeka].'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_'.$this->url.'"  class="ui-button-text icon-save" >Confirm</button>';

                        

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
                        $upbTeamID = $this->lib_refor->upbTeam($iupb_id);

                        $cekDept = array_intersect($arrTeam, $arrDept);

                        //if(in_array($act['vDept_assigned'], $arrTeam ) || in_array($this->user->gNIP, $arrNipAssign)  ){
                        if( !empty($cekDept) || in_array($this->user->gNIP, $arrNipAssign) || $this->isAdmin==TRUE ){
                            
                            // jika Dept id yang ditunjuk ada pada team id yang dimiliki
                            $upbTeamID[$act['vDept_assigned']]=isset($upbTeamID[$act['vDept_assigned']])?$upbTeamID[$act['vDept_assigned']]:"";
                            //if(in_array($upbTeamID[$act['vDept_assigned']], $arrTeamID) || in_array($this->user->gNIP, $arrNipAssign) || $this->isAdmin==TRUE ){
                                //get manager from Team ID
                                $magrAndCief = $this->lib_refor->managerAndChief($upbTeamID[$act['vDept_assigned']]);
                                $magrAndCief=isset($magrAndCief)?$magrAndCief:'';
                                // jika activitynya approval keatas
                                if($act['iType'] > 1){
                                    // nip harus ada pada nip manager atau chief dari Dept, atau nip yang ditunjuk di table modul activity
                                    $arrmgrAndCief = explode(',', $magrAndCief);
                                    if(in_array($this->user->gNIP, $arrmgrAndCief) ||in_array($this->user->gNIP, $arrNipAssign ) || $this->isAdmin==TRUE){
                                        
                                    }else{
                                        $sButton = '<span style="color:red;">You\'re not Authorized to Approve</span>';
                                    }
                                }

                            // }else{
                            //     $sButton = '<span style="color:red;" arrTeamID="'.$this->teamID.'" title="'.$upbTeamID[$act['vDept_assigned']].'" >You\'re Team not Authorized </span>';
                            // }

                        }else{
                            $sButton = '<span style="color:red;" title="'.$act['vDept_assigned'].'">You\'re Dept not Authorized</span>';
                            
                        }
                    }
                }
                $buttons['update'] = $sButton; 
        }

        //Load Javascript In Here 
       
        // $buttons["update"]=$iupb_id;
        return $buttons;
    }

	function manipulate_insert_button($buttons){
		$cNip= $this->user->gNIP;
        $data['upload'] = 'uploadCustomGrid';
        $js = $this->load->view('js/standard_js', $data, TRUE);
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="'.$this->url.'_frame" id="'.$this->url.'_frame" height="0" width="0"></iframe>';
        
        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?draft=true&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',this,true )"  id="button_save_draft_'.$this->url.'"  class="ui-button-text icon-save" >Save as Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_save_submit_'.$this->url.'"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

        $AuthModul = $this->lib_refor->getAuthorModul($this->modul_id);
        $arrTeam = explode(',',$this->team);
        $nipAuthor = explode(',', $AuthModul['vNip_author']);

        if( in_array($AuthModul['vDept_author'],$arrTeam )  || in_array($this->user->gNIP, $nipAuthor) || $this->isAdmin==TRUE  ){

            $buttons['save'] = $iframe.$save_draft.$save.$js;
        }else{
            unset($buttons['save']);
            $buttons['save'] = '<span style="color:red;" title="'.$AuthModul['vDept_author'].'">You\'re Dept not Authorized</span>';
        }
        
        
        return $buttons;
	}

	function listBox_Action($row, $actions) {
        $row                = get_object_vars($row);
        $peka               = $row[$this->main_table_pk];
        $getLastactivity    = $this->lib_refor->getLastactivity($this->modul_id,$peka);
        $isOpenEditing      = $this->lib_refor->getOpenEditing($this->modul_id,$peka);

        if ( $getLastactivity == 0 ) { 
                
        }else{
            if ($isOpenEditing){

            } else {
                unset($actions['edit']);    
            }
            
        }

        return $actions;
    }

	/*List Box*/
	function listBox_v3_export_draft_soi_bb_cPIC_AD($value, $pk, $name, $rowData) {
		$sql="select em.cNip, em.vName from hrd.employee em where em.cNip='".$value."'";
		$qq=$this->db_plc0->query($sql);
		$return = "-";
		if($qq->num_rows()>0){
			$row=$qq->row_array();
			$return=$row["cNip"]." - ".$row["vName"];
		}
		return $return;
	}
	function listBox_v3_export_draft_soi_bb_dossier_upd_iteampd_id($value, $pk, $name, $rowData) {
		$sql="select * from reformulasi.dossier_upd_team where iteam_id='".$value."'";
		$qq=$this->db_plc0->query($sql);
		$return = "-";
		if($qq->num_rows()>0){
			$row=$qq->row_array();
			$return=$row["vteam"];
		}
		return $return;
	}

	/*Manipulate Insert/Update Form*/
	function insertBox_v3_export_draft_soi_bb_form_detail($field,$id){
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

        function updateBox_v3_export_draft_soi_bb_form_detail($field,$id,$value,$rowData){
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

    function before_insert_processor($row, $postData) {
        if($postData['isdraft']==true){
            $postData['isubmit']=0;
        } 
        else{
            $postData['isubmit']=1;
        } 
        $postData['ijenis_bk'] = 1;
        return $postData;

    }
    function before_update_processor($row, $postData) {
        if($postData['isdraft']==true){
            $postData['isubmit']=0;
        } 
        else{
            $postData['isubmit']=1;
        }
        $postData['ijenis_bk'] = 1;
        return $postData;
    }

    /*After Insert*/
    function after_insert_processor($fields, $id, $postData) {
        $modul_id 					= $this->modul_id;
        $post 						= $this->input->post(); 
        $vjenis_bk 					= $post['vjenis_bk']; 
        $tketerangan_bk 			= $post['tketerangan_bk']; 
        $iexport_bk_primer_detail 	= $post['iexport_bk_primer_detail']; 
        $nip 						= $this->user->gNIP;
        $now 						= date('Y-m-d H:i:s');

        foreach ($iexport_bk_primer_detail as $key => $value) {
        	if (intval($value) == 0){
        		if (!empty($vjenis_bk[$key])){
	                $insert['iexport_bk_id'] 	= $id;
	                $insert['vjenis_bk'] 		= $vjenis_bk[$key];
	                $insert['tketerangan_bk']	= $tketerangan_bk[$key];
	                $insert['dcreate']			= $now;
	                $insert['ccreate']			= $nip;
	                $insert['ldeleted'] 		= 0;
	                $this->db->insert('reformulasi.export_bk_primer_detail', $insert);
        		}
        	}
        }

        if($postData['isubmit']){
            $this->lib_refor->InsertActivityModule($this->ViewUPD($id),$modul_id,$id,1,1);
        }
    }

    /*After Update*/
    function after_update_processor($fields, $id, $postData) { 
        $modul_id 					= $this->modul_id;
        $post 						= $this->input->post(); 
        $vjenis_bk 					= $post['vjenis_bk']; 
        $tketerangan_bk 			= $post['tketerangan_bk']; 
        $iexport_bk_primer_detail 	= $post['iexport_bk_primer_detail']; 
        $nip 						= $this->user->gNIP;
        $now 						= date('Y-m-d H:i:s');

        $eRows 						= $this->db->get_where('reformulasi.export_bk_primer_detail', array('iexport_bk_id' => $id, 'ldeleted'=>0))->result_array(); 
        
        foreach($eRows as $k => $v) {
            if(in_array($v['iexport_bk_primer_detail'], $iexport_bk_primer_detail)) {
                $key = array_search($v['iexport_bk_primer_detail'], $iexport_bk_primer_detail);
                $this->db->where('iexport_bk_primer_detail', $v['iexport_bk_primer_detail']);
                $update['vjenis_bk'] 		= $vjenis_bk[$key];
                $update['tketerangan_bk'] 	= $tketerangan_bk[$key];
                $update['dupdate'] 			= $now;
                $update['cupdate'] 			= $nip;
                $this->db->update('reformulasi.export_bk_primer_detail', $update);
            } else {
                $this->db->where('iexport_bk_primer_detail', $v['iexport_bk_primer_detail']);
                $delete['dupdate'] 	= $now;
                $delete['cupdate'] 	= $nip;
                $delete['ldeleted'] = 1;
                $this->db->update('reformulasi.export_bk_primer_detail', $delete);
            }
        }
        
        foreach ($iexport_bk_primer_detail as $key => $value) {
        	if (intval($value) == 0){
        		if (!empty($vjenis_bk[$key])){
	                $insert['iexport_bk_id'] 	= $id;
	                $insert['vjenis_bk'] 		= $vjenis_bk[$key];
	                $insert['tketerangan_bk']	= $tketerangan_bk[$key];
	                $insert['dcreate']			= $now;
	                $insert['ccreate']			= $nip;
	                $insert['ldeleted'] 		= 0;
	                $this->db->insert('reformulasi.export_bk_primer_detail', $insert);
        		}
        	}
        }

        if ($postData['isubmit'] == 1){
            $this->lib_refor->InsertActivityModule($this->ViewUPD($id),$modul_id,$id,1,1);
        }
    }


    /*Confirm View*/

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
                                        var url = "'.base_url().'processor/'.$this->urlpath.'";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_'.$this->url.'").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_'.$this->url.'");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_'.$this->url.'_confirm" action="'.base_url().'processor/'.$this->urlpath.'?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_'.$this->url.'_confirm\')">Confirm</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 

     function confirm_process() {
        $post 			= $this->input->post();
        $cNip 			= $this->user->gNIP;
        $vName 			= $this->user->gName;
        $pk  			= $post[$this->main_table_pk];
        $vRemark     	= $post['vRemark'];
        $modul_id 		= $post['modul_id'];
        $iM_modul_activity = $post['iM_modul_activity'];

        $activity 		= $this->db->get_where('erp_privi.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

        $field 			= $activity['vFieldName'];
        $update 		= array($field => 2);
        $this->db->where($this->main_table_pk, $pk);
        $this->db->update($this->main_table, $update);

        $this->lib_refor->InsertActivityModule($this->ViewUPD($pk),$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);
        
        $data['status']  	= true;
        $data['last_id'] 	= $post[$this->main_table_pk];
        $data['group_id'] 	= $post['group_id'];
        $data['modul_id'] 	= $post['modul_id'];
        return json_encode($data);
    }


    /*Confirm View*/

    function approve_view($id=0) { 
    	$lblbutton="-";
    	if($id==1){
    		$lblbutton="Reject";
    	}
    	if($id==2){
    		$lblbutton="Approve";
    	}
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
                                var url = "'.base_url().'processor/'.$this->urlpath.'";                             
                                if(o.status == true) { 
                                    $("#alert_dialog_form").dialog("close");
                                         $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                         $("div#form_'.$this->url.'").html(data);
                                         
                                    });
                                    
                                }
                                    reload_grid("grid_'.$this->url.'");
                            }
                            
                         })
                     }
                 </script>';
        $echo .= '<h1>'.$lblbutton.'</h1><br />';
        $echo .= '<form id="form_'.$this->url.'_approve" action="'.base_url().'processor/'.$this->urlpath.'?action=approve_process" method="post">';
        $echo .= '<div style="vertical-align: top;">';
        $echo .= 'Remark : 
                <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                <input type="hidden" name="iapprove" value="'.$id.'" />
                <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                
                <textarea name="vRemark"></textarea>
        <button type="button" onclick="submit_ajax(\'form_'.$this->url.'_approve\')">'.$lblbutton.'</button>';
            
        $echo .= '</div>';
        $echo .= '</form>';
        return $echo;
    } 

     function approve_process() {
        $post 				= $this->input->post();
        $cNip 				= $this->user->gNIP;
        $vName 				= $this->user->gName;
        $pk 				= $post[$this->main_table_pk];
        $vRemark 			= $post['vRemark'];
        $modul_id 			= $post['modul_id'];
        $iapprove 			= $post['iapprove'];
        $iM_modul_activity 	= $post['iM_modul_activity'];

        $activity 			= $this->db->get_where('erp_privi.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

        $field 				= $activity['vFieldName'];
        $update 			= array($field => $iapprove);
        $this->db->where($this->main_table_pk, $pk);
        $this->db->update($this->main_table, $update);

        $this->lib_refor->InsertActivityModule($this->ViewUPD($pk),$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,$iapprove);
        
        $data['status']  	= true;
        $data['last_id'] 	= $post[$this->main_table_pk];
        $data['group_id'] 	= $post['group_id'];
        $data['modul_id'] 	= $post['modul_id'];
        return json_encode($data);
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

                $hate_emel .= $this->lib_refor->getHistoryActivity($this->modul_id,$aidi);

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

                    $path = 'files/reformulasi/dok_tambah';
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

                if ($form_field['iM_jenis_field'] == 8){
	            	$hate_emel .=' </label>
                                <div class="">'.$return_field.'</div>
                            </div>';
                    $hate_emel .= '<script>
                        $("label[for=\''.$this->url.'_form_detail_'.$form_field['vNama_field'].'\']").hide();
                    </script>';
                } else {
	            	$hate_emel .=' </label>
                                <div class="rows_input">'.$return_field.'</div>
                            </div>';
                }

            }

        }else{
            $hate_emel .='Field belum disetting';
        }

        $hate_emel .= '<input type="hidden" name="isdraft" id="isdraft">';
        
        $data["html"] .= $hate_emel;
        return json_encode($data);
    }

    function get_data_prev(){
    	/* $post=$this->input->post();
    	$get=$this->input->get();
    	$nmTable=isset($post["nmTable"])?$post["nmTable"]:"0";
    	$grid=isset($post["grid"])?$post["grid"]:"0";
    	$grid=isset($post["grid"])?$post["grid"]:"0";
    	$namefield=isset($post["namefield"])?$post["namefield"]:"0";

    	$this->db_plc0->select("*")
    				->from("reformulasi.sys_masterdok")
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
        return json_encode($data); */
        $post=$this->input->post();
    	$get=$this->input->get();
    	$nmTable=isset($post["nmTable"])?$post["nmTable"]:"0";
    	$grid=isset($post["grid"])?$post["grid"]:"0";
    	$grid=isset($post["grid"])?$post["grid"]:"0";
    	$namefield=isset($post["namefield"])?$post["namefield"]:"0";

    	$this->db_plc0->select("*")
    				->from("reformulasi.sys_masterdok")
    				->where("filename",$namefield);
        $row=$this->db_plc0->get()->row_array();
		
		$where=array('iDeleted'=>0,'idHeader_File'=>$post["id"],'iM_modul_fields'=>$row['iM_modul_fields']);
		$this->db_plc0->where($where);
		$q=$this->db_plc0->get('reformulasi.group_file_upload');
		$rsel=array('vFilename','tKeterangan','iact');
		$data = new StdClass;
		$data->records=$q->num_rows();
		$i=0;
		foreach ($q->result() as $k) {
			$data->rows[$i]['id']=$i;
			$z=0;

			$value=$k->vFilename_generate;
			$id=$k->idHeader_File;
			$linknya = 'No File';
			if($value != '') {
				if (file_exists('./'.$row["filepath"].'/'.$id.'/'.$value)) {
					$link = base_url().'processor/'.$this->urlpath.'?action=download&id='.$id.'&file='.$value.'&path='.$row['filename'];
					$linknya = '<a class="ui-button-text" href="javascript:;" onclick="window.location=\''.$link.'\'">[Download]</a>&nbsp;&nbsp;&nbsp;';
				}
			}
			$linknya=$linknya.'<a class="ui-button-text" href="javascript:;" onclick="javascript:hapus_row_'.$nmTable.'('.$i.')">[Hapus]</a><input type="hidden" class="num_rows_'.$nmTable.'" value="'.$i.'" /><input type="hidden" name="'.$post["namefield"].'_iFile[]" value="'.$k->iFile.'" />';


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

    private function ViewUPD ($id=0){
    	$sql = 'SELECT u.idossier_upd_id FROM reformulasi.export_bahan_kemas k 
				JOIN reformulasi.export_req_refor r ON k.iexport_req_refor = r.iexport_req_refor
				JOIN dossier.dossier_upd u ON r.idossier_upd_id = u.idossier_upd_id
				WHERE k.ldeleted = 0 AND r.lDeleted = 0 AND u.lDeleted = 0 AND k.iexport_bk_id = ?';
        $upb = $this->db->query($sql, array($id))->result_array();
        $arrUPD = array();
        foreach ($upb as $u) {
            array_push($arrUPD, $u['idossier_upd_id']);
        }
        return $arrUPD;
    }


}