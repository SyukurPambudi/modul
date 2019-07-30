<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_soi_mikro_fg extends MX_Controller {
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
        $this->isAdmin=$this->lib_plc->isAdmin($this->user->gNIP);

		$this->title = 'SOI Mikro FG';
		$this->url = 'v3_soi_mikro_fg';
		$this->urlpath = 'plc/'.str_replace("_","/", $this->url);

		$this->maintable = 'plc2.mikro_fg';	
		$this->main_table = $this->maintable;	
        $this->main_table_pk = 'imikro_fg_id';	
        $this->setGroupBy = 'plc2_upb_formula.iFormula_process';
		$datagrid['islist'] = array(
			'ini_nilai' => array('label'=>'No Formula','width'=>100,'align'=>'left','search'=>true)
			,'plc2_upb.vupb_nomor' => array('label'=>'No UPB','width'=>75,'align'=>'center','search'=>true)
			,'plc2_upb.vupb_nama' => array('label'=>'Nama Usulan','width'=>250,'align'=>'left','search'=>true)
			,'plc2_upb.vgenerik' => array('label'=>'Nama Generik','width'=>250,'align'=>'left','search'=>false)
			,'study_literatur_pd.ijenis_sediaan' => array('label'=>'Jenis Sediaan','width'=>150,'align'=>'left','search'=>false)
			,'mikro_fg.istatus' => array('label'=>'Status Standarisasi','width'=>100,'align'=>'left','search'=>false)
			,'mikro_fg.isubmit_soi' => array('label'=>'Submit','width'=>100,'align'=>'left','search'=>false)
			,'mikro_fg.iappqa_soi' => array('label'=>'Approval QA','width'=>100,'align'=>'left','search'=>false)
		);
		$datagrid['shortBy']=array('plc2_upb_formula.ifor_id'=>'Desc');
		

		$datagrid['setQuery']=array(
								0=>array('vall'=>'plc2_upb_formula.lDeleted','nilai'=>0)
								);
		$datagrid['jointableinner']=array(
									0=>array('plc2.plc2_upb'=>'plc2.plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id')
                                    ,1=>array('plc2.study_literatur_pd'=>'plc2.study_literatur_pd.iupb_id = plc2.plc2_upb.iupb_id')
                                    ,2=>array('pddetail.formula_process'=>'formula_process.iFormula_process=plc2_upb_formula.iFormula_process')
                                    ,3=>array('(SELECT a.*
                                                FROM pddetail.formula a
                                                join pddetail.formula_process b on b.iFormula_process=a.iFormula_process
                                                WHERE a.iFormula IN (
                                                    SELECT MAx(b1.iFormula)
                                                    FROM pddetail.formula b1
                                                    join pddetail.formula_process c1 on c1.iFormula_process=b1.iFormula_process
                                                    where c1.iMaster_flow=1
                                                    GROUP BY c1.iupb_id
                                                )) as formula '=>'formula.iFormula_process=formula_process.iFormula_process')
                                                                        
									#,2=>array('pddetail.formula'=>'plc2.plc2_upb_formula.iFormula_process = pddetail.formula.iFormula_process')
								);
        /* $datagrid['jointableleft']=array(
            0=>array('plc2.mikro_fg'=>'plc2.plc2_upb_formula.iupb_id = plc2.mikro_fg.iupb_id')
        ); */
		$this->datagrid=$datagrid;
    }

    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle($this->title);		
		$grid->setTable('plc2.plc2_upb_formula');
		$grid->setUrl($this->url);

		$grid->setGroupBy($this->setGroupBy);
		/*Untuk Field*/
		$grid->addFields('form_detail');
        $grid->setJoinTable('plc2.mikro_fg', 'mikro_fg.ifor_id = plc2_upb_formula.ifor_id', 'left');
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
			/* if($kv=='jointableleft'){
				foreach ($vv as $list => $vlist) {
					foreach ($vlist as $tbjoin => $onjoin) {
						$grid->setJoinTable($tbjoin, $onjoin, 'left');
					}
				}
			} */
			if($kv=='setQuery'){
				foreach ($vv as $list => $vlist) {
					$grid->setQuery($vlist['vall'], $vlist['nilai']);
				}
			}

        }
        
        /* Main Grid Filter */
        $dataModule=$this->lib_plc->getDataFilterMainGrid($this->iModul_id);
        if(count($dataModule)>0 ){
            foreach ($dataModule as $km => $vm) {
               if(strlen($vm)>0){
                    $grid->setQuery($vm,NULL);
               }
            }
        }
		$grid->setGridView('grid');

		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;	
			case 'create':
				$grid->render_form();
				break;
            case 'createproses':
                /* echo 'kesini';
                exit; */
                $grid->setTable('plc2.mikro_fg');
                echo $grid->saved_form();
                break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				$post=$this->input->post();
                $get=$this->input->get();

                $ifor_id=isset($post[$this->url."_ifor_id"])?$post[$this->url."_ifor_id"]:"0";
                $whereget=array('ifor_id'=>$ifor_id,'lDeleted'=>0);
                $this->db_plc0->where($whereget);
                $rowsss=$this->db_plc0->get('plc2.mikro_fg')->row_array();
                $lastId=isset($rowsss['imikro_fg_id'])?$rowsss['imikro_fg_id']:'0';

				$dataFieldUpload=$this->lib_plc->getUploadFileFromField($this->input->get('modul_id'));

                if(count($dataFieldUpload) > 0 && $lastId != "0" && $lastId != ""){
                    foreach ($dataFieldUpload as $kf => $vUpload) {
                        $pathf      = $vUpload['filepath'];
                        $iddetails  = $vUpload['filename'].'_iFile';

                        $validdetails = array();

                        foreach ($post as $kk => $vv) {
                            if($kk==$iddetails){
                                foreach ($vv as $kv2 => $vv2) {
                                    $validdetails[]=$vv2;
                                }
                                
                            }
                        }
                        $dataupdate['iDeleted']     = 1;
                        $dataupdate['dUpdate']      = date("Y-m-d H:i:s");
                        $dataupdate['cUpdate']      = $this->user->gNIP;
                        if(count($validdetails) > 0){
                            $this->db_plc0->where('idHeader_File',$ifor_id)
                                            ->where_not_in('iFile',$validdetails)
                                            ->where('iM_modul_fileds',$vUpload['iM_modul_fileds'])
                                            ->update('plc2.group_file_upload',$dataupdate);
                        }else{
                            $this->db_plc0->where('idHeader_File',$ifor_id)
                                            ->where('iM_modul_fileds',$vUpload['iM_modul_fileds'])
                                            ->update('plc2.group_file_upload',$dataupdate);
                        }

                        // Delete File
                        $where  = array('iDeleted'=>1,'idHeader_File'=>$lastId,'iM_modul_fileds'=>$vUpload['iM_modul_fileds']);
                        $this->db_plc0->where($where);
                        $qq     = $this->db_plc0->get('plc2.group_file_upload');

                        if($qq->num_rows() > 0){
                            $result = $qq->result_array();
                            foreach ($result as $kr => $vr) {
                                if(isset($vr["vFilename_generate"])){
                                    $pathf  = $vUpload['filepath'];
                                    $path   = realpath($pathf);
                                    if(file_exists($path."/".$lastId."/".$vr["vFilename_generate"])){
                                        unlink($path."/".$lastId."/".$vr["vFilename_generate"]);
                                    }
                                }
                            }

                        }
                    }
                }
                
                $datainsert['vPIC_soi']=$post['vPIC_soi'];
                $isdrafft=0;
                if($post['isdraft']==true){
                    $datainsert['isubmit_soi']=0;
                    $isdrafft=0;
                } 
                else{
                    $datainsert['isubmit_soi']=1;
                    $isdrafft=1;
                }
                $datainsert['dupdate']=date('Y-m-d H:i:s');
                $datainsert['cUpdate']=$this->user->gNIP;
                $r['foreign_key']=$get['foreign_key'];
                $r['company_id']=$get['company_id'];
                $r['group_id']=$get['group_id'];
                $r['modul_id']=$get['modul_id'];
                $this->db_plc0->where('imikro_fg_id',$lastId);
                if($this->db_plc0->update('plc2.mikro_fg',$datainsert)){

                    $peka=$this->main_table_pk;
                    
                    $iupb_id[]=$this->lib_plc->getUpbId($peka,$lastId);
                    $modul_id=$this->input->get("modul_id");
                    $iKey_id=$lastId;
                    $iM_activity=0;
                    $iSort=1;
                    $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$lastId);
                    foreach ($activities as $kk => $vv) {
                        $iM_activity=isset($vv['iM_activity'])?$vv['iM_activity']:$iM_activity;
                    }
                    if($isdrafft==1){
                        $this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$iKey_id,$iM_activity,$iSort);
                    }

                    $r['message']="Data Berhasil Disimpan";
                    $r['status'] = TRUE;
                    $r['last_id'] = $ifor_id;
                }else{
                    $r['message']="Failed Insert";
                    $r['status'] = FALSE;
                    $r['last_id'] = $ifor_id;
                }	
                echo json_encode($r);
				break;	
			case 'delete':
				echo $grid->delete_row();
				break;

			/*Option Case*/
			case 'getFormDetail':
				echo $this->getFormDetail();
				break;
            case 'get_data_prev':
				echo $this->lib_plc->get_data_prev($this->urlpath);
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
            
            case 'confirm':
                echo $this->approve_view(2);
                break;
            case 'confirm_process':
                echo $this->approve_process();
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
                $sql="select * from plc2.mikro_fg m where m.lDeleted=0 and m.ifor_id=".$this->input->get('lastId');
                $row=$this->db_plc0->query($sql)->row_array();
                $lastId= isset($row['imikro_fg_id'])?$row['imikro_fg_id']:'0';

                $dataFieldUpload    = $this->lib_plc->getUploadFileFromField($this->input->get('modul_id'));
                if(count($dataFieldUpload) > 0){
                    foreach ($dataFieldUpload as $kf => $vUpload) {
                        $pathf  = $vUpload['filepath'];
                        $path   = realpath($pathf);

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
                        if(isset($_FILES['plc2_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file'])){
                            foreach ($_FILES['plc2_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file']["error"] as $key => $error) {
                                if ($error == UPLOAD_ERR_OK) {
                                    $tmp_name           = $_FILES['plc2_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file']["tmp_name"][$key];
                                    $name               = $_FILES['plc2_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file']["name"][$key];
                                    $data['filename']   = $name;
                                    $data['dInsertDate']= date('Y-m-d H:i:s');
                                    $filenameori        = $name;
                                    $now_u              = date('Y_m_d__H_i_s');
                                    $name_generate      = $this->lib_plc->generateFilename($name, $i);

                                    if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name_generate)) {
                                        $datainsert                         = array();
                                        $datainsert['idHeader_File']        = $lastId;
                                        $datainsert['iM_modul_fileds']      = $vUpload['iM_modul_fileds'];
                                        $datainsert['dCreate']              = date('Y-m-d H:i:s');
                                        $datainsert['cCreate']              = $this->user->gNIP;
                                        $datainsert['vFilename']            = $name;
                                        $datainsert['vFilename_generate']   = $name_generate;
                                        $datainsert['tKeterangan']          = $fKeterangan[$i];
                                        $this->db_plc0->insert('plc2.group_file_upload',$datainsert);
                                        $i++;   

                                    } else {
                                        echo "Upload ke folder gagal";
                                    }
                                }
                            }
                        }
                    }

                    $r['message']   = "Data Berhasil Disimpan";
                    $r['status']    = TRUE;
                    $r['last_id']   = $this->input->get('lastId');                  
                    echo json_encode($r);
                } else {
                    $r['message']   = "Data Upload Not Found";
                    $r['status']    = TRUE;
                    $r['last_id']   = $this->input->get('lastId');                  
                    echo json_encode($r);
                }
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
        /* Modifkasi untuk main PK */
        $array=array('lDeleted'=>0,'ifor_id'=>$rowData['ifor_id']);
        $this->db_plc0->where($array);
        $que=$this->db_plc0->get('plc2.mikro_fg');
        $fieldpeka=$this->main_table_pk;
        $peka=0;
        $new=0;
        if($que->num_rows()==0){
            $new=0;
            $fieldpeka='ifor_id';
            $peka=isset($rowData[$fieldpeka])?$rowData[$fieldpeka]:0;
        }else{
            $row=$que->row_array();
            $fieldpeka=$this->main_table_pk;
            $peka=$row[$fieldpeka];
            $new=1;
        }
        $iupb_id=$this->lib_plc->getUpbId($fieldpeka,$peka);

        $cNip= $this->user->gNIP;
        $data['upload']='upload_custom_grid';
       	$js = $this->load->view('js/standard_js',$data,TRUE);
        //$js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="'.$this->url.'_frame" id="'.$this->url.'_frame" height="0" width="0"></iframe>';
        

        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        }
        else{ 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?draft=true&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',this,true )"  id="button_update_draft_'.$this->url.'"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$peka);
                    $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,$peka);

                    foreach ($activities as $act) {
                        $update_draft = '<button onclick="javascript:update_draft_btn(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?draft=true&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',this,true )"  id="button_update_draft_'.$this->url.'"  class="ui-button-text icon-save" >Update as Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?company_id='.$this->input->get('company_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_'.$this->url.'"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/'.$this->urlpath.'?action=approve&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$fieldpeka.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_'.$this->url.'"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/'.$this->urlpath.'?action=reject&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_'.$this->url.'"  class="ui-button-text icon-save" >Reject</button>';

                        $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/'.$this->urlpath.'?action=confirm&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$fieldpeka.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_'.$this->url.'"  class="ui-button-text icon-save" >Confirm</button>';

                        $grid='v3_soi_mikro_fg';
                        $save = '<button onclick="javascript:save_btn_multiupload_'.$grid.'(\''.$this->url.'\', \' '.base_url().'processor/'.$this->url.'?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_save_submit_'.$this->url.'"  class="ui-button-text icon-save" >Update &amp; Submit</button>';
                        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload_'.$grid.'(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?draft=true&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',this,true )"  id="button_save_draft_'.$this->url.'"  class="ui-button-text icon-save" >Save as Draft</button>';


                        switch ($act['iType']) {
                            case '1':
                                # Update
                                if($new==1){
                                    $sButton .= $update_draft.$update;
                                }else{
                                    $databutton['grid']=$grid;
                                    $get=$this->input->get();
                                    foreach ($get as $kget => $vget) {
                                        if($kget!="action"){
                                            $in[]=$kget."=".$vget;
                                        }
                                        if($kget=="action"){
                                            $in[]="action=createproses";
                                        }
                                    }
                                    $g=implode("&", $in);
                                    $databutton['pathget']=base_url().'processor/'.$this->urlpath.'?'.$g;
                                    $databutton['upload']='upload_custom_grid';
                                    $databutton['ifor_id']=$rowData['ifor_id'];
                                    $sButton .= $this->load->view('js/custom_js_button',$databutton,TRUE);
                                    $sButton .= $save_draft;

                                    //$sButton .= $databutton['pathget'];
                                }
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
                        if( !empty($cekDept) || in_array($this->user->gNIP, $arrNipAssign) || $this->isAdmin==TRUE ){
                            
                            // jika Dept id yang ditunjuk ada pada team id yang dimiliki
                            $upbTeamID[$act['vDept_assigned']]=isset($upbTeamID[$act['vDept_assigned']])?$upbTeamID[$act['vDept_assigned']]:"";
                            if(in_array($upbTeamID[$act['vDept_assigned']], $arrTeamID) || in_array($this->user->gNIP, $arrNipAssign) || $this->isAdmin==TRUE ){
                                //get manager from Team ID
                                $magrAndCief = $this->lib_plc->managerAndChief($upbTeamID[$act['vDept_assigned']]);
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

        //Load Javascript In Here 
       
        // $buttons["update"]=$iupb_id;
        return $buttons;
    }

	function manipulate_insert_button($buttons){
		$cNip= $this->user->gNIP;
		$data['upload']='upload_custom_grid';
        $js = $this->load->view('js/standard_js',$data,TRUE);
        //$js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="'.$this->url.'_frame" id="'.$this->url.'_frame" height="0" width="0"></iframe>';
        
        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?draft=true&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',this,true )"  id="button_save_draft_'.$this->url.'"  class="ui-button-text icon-save" >Save as Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\''.$this->url.'\', \' '.base_url().'processor/'.$this->url.'?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_save_submit_'.$this->url.'"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

        $AuthModul = $this->lib_plc->getAuthorModul($this->modul_id);
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

	/*List Box*/
	function listBox_v3_soi_mikro_fg_mikro_fg_iappqa_soi($value) {
		if($value==0){$vstatus='Waiting for approval';}
		elseif($value==1){$vstatus='Rejected';}
		elseif($value==2){$vstatus='Approved';}
        else{$vstatus='-';}
		return $vstatus;
	}
	function listBox_v3_soi_mikro_fg_study_literatur_pd_ijenis_sediaan($value) {
		if($value==0){$vstatus='Steril';}
		elseif($value==1){$vstatus='Non Steril';}
		return $vstatus;
	}
	function listBox_v3_soi_mikro_fg_mikro_fg_isubmit_soi($value) {
		if($value==0){$vstatus='Need Submit';}
		elseif($value==1){$vstatus='Submited';}
		return $vstatus;
	}

	function listBox_v3_soi_mikro_fg_ini_nilai($value, $pk, $name, $rowData) {
		$this->db_plc0->select("formula.vNo_formula");
		$this->db_plc0->from("pddetail.formula");
		$this->db_plc0->join("pddetail.formula_process","formula_process.iFormula_process=formula.iFormula_process");
		$this->db_plc0->join("plc2.plc2_upb_formula","plc2_upb_formula.iupb_id=formula_process.iupb_id");
		$this->db_plc0->where("plc2_upb_formula.ifor_id",$rowData->ifor_id);
		$this->db_plc0->order_by("formula.iFormula","DESC");
		$ggg=$this->db_plc0->get();
		$return="-";
		if($ggg->num_rows()>0){
			$row=$ggg->row_array();
			$return=$row['vNo_formula'];
		}
		return $return;
	}

	/*Manipulate Insert/Update Form*/
	function insertBox_v3_soi_mikro_fg_form_detail($field,$id){
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

        function updateBox_v3_soi_mikro_fg_form_detail($field,$id,$value,$rowData){
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
            /* $array=array('lDeleted'=>0,'ifor_id'=>$rowData['ifor_id']);
            $this->db_plc0->where($array);
            $que=$this->db_plc0->get('plc2.mikro_fg');
            $fieldpeka=$this->main_table_pk;
            $peka=0;
            if($que->num_rows()==0){
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
            } */
            return $return;
        }
    /*Function Tambahan*/
    function getFormDetail(){
    	$post=$this->input->post();
        $get=$this->input->get();
        $data['html']="";

        $sqlFields = 'select * from plc3.m_modul_fileds a where a.lDeleted=0 and  a.iM_modul='.$this->iModul_id.' order by a.iSort ASC';
        $dFields = $this->db->query($sqlFields)->result_array();

        $hate_emel = "";

        if($get['formaction']=='update'){
                $aidi = $get['id'];
                $ifor_id=isset($get["id"])?$get["id"]:"0";
                $whereget=array('ifor_id'=>$ifor_id,'lDeleted'=>0);
                $this->db_plc0->where($whereget);
                $rowsss=$this->db_plc0->get('plc2.mikro_fg')->row_array();
                $aidi=isset($rowsss['imikro_fg_id'])?$rowsss['imikro_fg_id']:'0';
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
                $data_field['get']= $get;
                $data_field['post']= $post;
                $data_field['get']= $get;


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

                    /* $sqlGetMainvalue= 'select * from '.$this->main_table.' where lDeleted=0 and '.$this->main_table_pk.'= '.$id.'   ';
                    $dataHead = $this->db->query($sqlGetMainvalue)->row_array(); */

                    $arraywhere=array('plc2_upb_formula.ldeleted'=>0, 'plc2_upb_formula.ifor_id'=>$id);
                    $this->db->select('mikro_fg.*,plc2_upb_formula.ifor_id as ifor_id,plc2_upb_formula.iupb_id as iupb_id')
                            ->from('plc2.plc2_upb_formula')
                            ->join($this->main_table,'mikro_fg.ifor_id=plc2_upb_formula.ifor_id','left')
                            ->where($arraywhere); 
                    $dataHead = $this->db->get()->row_array();
                    $data_field['dataHead']= $dataHead;
                    $data_field['main_table_pk']= $this->main_table_pk;
                    $iniget=$this->input->get();
                    $iniget['id']=$dataHead['imikro_fg_id'];
                    $data_field['get']=$iniget;
                    
                    if($form_field['iM_jenis_field'] == 6){
                        $data_field['vSource_input']= $form_field['vSource_input_edit'] ;
                    } else if ($form_field['iM_jenis_field'] == 19){
                        if ($form_field['vNama_field'] == 'iJenis_pengujian'){
                            $arrJenis = explode(',', $dataHead[$form_field['vNama_field']]);
                            if (count($arrJenis) > 0){
                                $label = '';
                                $no = 1;
                                foreach ($arrJenis as $aj) {
                                    if (!empty($aj)){
                                        $jenis = $this->db->get_where('plc2.plc2_master_jenis_uji_mikro', array('ijenis_mikro' => $aj, 'ldeleted' => 0))->row_array();
                                        if (!empty($jenis)){
                                            $label .= '<h4>'.$no.'. '.$jenis['vjenis_mikro'].'</h4>';
                                            $no ++;
                                        }
                                    }
                                }
                            } else {
                                $label = '-';
                            }
                            $data_field['label'] = $label;
                            $data_field['default'] = $dataHead[$form_field['vNama_field']];
                        } else {
                            $data_field['label'] = $dataHead[$form_field['vNama_field']];
                            $data_field['default'] = $dataHead[$form_field['vNama_field']];
                        }
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
            }

        }else{
            $hate_emel .='Field belum disetting';
        }

        $hate_emel .= '<input type="hidden" name="isdraft" id="isdraft">';
        
        $data["html"] .= $hate_emel;
        return json_encode($data);
    }

    function before_insert_processor($row, $postData) {
        unset($postData['iJenis_pengujian']);
        if($postData['isdraft']==true){
            $postData['isubmit_soi']=0;
        } 
        else{
            $postData['isubmit_soi']=1;
        } 
        return $postData;

    }
    function before_update_processor($row, $postData) {
        unset($postData['iJenis_pengujian']);
        if($postData['isdraft']==true){
            $postData['isubmit_soi']=0;
        } 
        else{
            $postData['isubmit_soi']=1;
        }
        return $postData;
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
        if($id==3){
    		$lblbutton="Confirm";
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
        $post = $this->input->post();
        $cNip= $this->user->gNIP;
        $vName= $this->user->gName;
        $pk = $post[$this->main_table_pk];
        $vRemark = $post['vRemark'];
        $modul_id = $post['modul_id'];
        $iapprove = $post['iapprove'];
        $iM_modul_activity = $post['iM_modul_activity'];

        $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

        $field = $activity['vFieldName'];
        $update = array($field => $iapprove);
        $this->db->where($this->main_table_pk, $pk);
        $this->db->update($this->main_table, $update);

        $peka=$this->main_table_pk;
        $iupb_id[]=$this->lib_plc->getUpbId($peka,$pk);

        $this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,$iapprove);
        
        $data['status']  = true;
        $data['last_id'] = $post[$this->main_table_pk];
        $data['group_id'] = $post['group_id'];
        $data['modul_id'] = $post['modul_id'];
        return json_encode($data);
    }

    /*After Update*/
    function after_update_processor($fields, $id, $postData) {
        $peka=$this->main_table_pk;
        $ifor_id=isset($postData[$this->url."_ifor_id"])?$postData[$this->url."_ifor_id"]:"0";
        $whereget=array('ifor_id'=>$ifor_id,'lDeleted'=>0);
        $this->db_plc0->where($whereget);
        $rowsss=$this->db_plc0->get('plc2.mikro_fg')->row_array();
        $lastId=isset($rowsss['imikro_fg_id'])?$rowsss['imikro_fg_id']:'0';

        $id=$lastId;

        $iupb_id[]=$this->lib_plc->getUpbId($peka,$id);
        $modul_id=$this->input->get("modul_id");
        $iKey_id=$id;
        $iM_activity=0;
        $iSort=1;
        $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$id);
        foreach ($activities as $kk => $vv) {
        	$iM_activity=isset($vv['iM_activity'])?$vv['iM_activity']:$iM_activity;
        }
        if($postData['isubmit_soi']){
        	$this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$iKey_id,$iM_activity,$iSort);
        }
    }

    function get_data_prev(){
        $post       = $this->input->post(); 
        $get        = $this->input->get(); 
        $nmTable    = isset($post["nmTable"])?$post["nmTable"]:"0";
        $grid       = isset($post["grid"])?$post["grid"]:"0";
        $grid       = isset($post["grid"])?$post["grid"]:"0";
        $namefield  = isset($post["namefield"])?$post["namefield"]:"0";

        $row        = $this->db_plc0->get_where('plc2.sys_masterdok', array('filename' => $namefield))->row_array();

        $where      = array('iDeleted'=>0,'idHeader_File'=>$get["id"],'iM_modul_fileds'=>$row['iM_modul_fileds']);
        $q          = $this->db_plc0->get_where('plc2.group_file_upload', $where);
        
        $rsel       = array('vFilename','tKeterangan','iact');
        $data       = new StdClass;
        $data->records = $q->num_rows();
        $i          = 0;

        foreach ($q->result() as $k) {
            $data->rows[$i]['id']   = $i;
            $z                      = 0;
            $value                  = $k->vFilename_generate;
            $id                     = $k->idHeader_File;
            $linknya                = 'No File';

            if($value != '') {
                if (file_exists('./'.$row["filepath"].'/'.$id.'/'.$value)) {
                    $link       = base_url().'processor/'.$this->urlpath.'?action=download&id='.$id.'&file='.$value.'&path='.$row['filename'];
                    $linknya    = '<a class="ui-button-text" href="javascript:;" onclick="window.location=\''.$link.'\'">[Download]</a>&nbsp;&nbsp;&nbsp;';
                }
            }

            $linknya = $linknya.'<a class="ui-button-text" href="javascript:;" onclick="javascript:hapus_row_'.$nmTable.'('.$i.')">[Hapus]</a><input type="hidden" class="num_rows_'.$nmTable.'" value="'.$i.'" /><input type="hidden" name="'.$post["namefield"].'_iFile[]" value="'.$k->iFile.'" />';

            foreach ($rsel as $dsel => $vsel) {
                if($vsel == "iact"){
                    $dataar[$dsel]  = $linknya;
                }else{
                    $dataar[$dsel]  = $k->{$vsel};
                }
                $z++;
            }

            $data->rows[$i]['cell']     = $dataar;
            $i++;

        }

        return json_encode($data);
    }


}