<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_study_literatur_pd extends MX_Controller {
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
        $this->main_table='study_literatur_pd';
        $this->main_table_pk='istudy_pd_id';


        $this->title = 'Study Literatur PD';
        $this->url = 'v3_study_literatur_pd';
        $this->urlpath = 'plc/'.str_replace("_","/", $this->url);

        $this->maintable = 'plc2.study_literatur_pd';  
        
        

        $datagrid['islist'] = array(
                                        'plc2_upb.vupb_nomor' => array('label'=>'No UPB','width'=>75,'align'=>'center','search'=>true)
                                        ,'plc2_upb.vupb_nama' => array('label'=>'Nama Usulan','width'=>300,'align'=>'left','search'=>true)
                                        ,'cPIC' => array('label'=>'PIC','width'=>100,'align'=>'center','search'=>true)
                                        ,'dmulai_study' => array('label'=>'Tanggal Mulai','width'=>100,'align'=>'center','search'=>true)
                                        ,'dselesai_study' => array('label'=>'Tanggal Selesai','width'=>100,'align'=>'center','search'=>false)
                                        ,'iuji_mikro' => array('label'=>'Uji Mikro FG','width'=>100,'align'=>'center','search'=>false)
                                        ,'ijenis_sediaan' => array('label'=>'Jenis Sediaan','width'=>150,'align'=>'center','search'=>false)
                                        ,'iSubmit' => array('label'=>'Status Submit','width'=>100,'align'=>'center','search'=>false)
                                        ,'iapppd' => array('label'=>'Status Approval','width'=>100,'align'=>'center','search'=>false)
                                    );
        $datagrid['shortBy']=array('istudy_pd_id'=>'Desc');

        

        $datagrid['setQuery']=array(
                                0=>array('vall'=>'plc2_upb.ldeleted','nilai'=>0)
                               , 1=>array('vall'=>'study_literatur_pd.ldeleted','nilai'=>0)
                                
                                );

        $datagrid['jointableinner']=array(
                                    #0=>array('plc2.plc2_upb_formula'=>'plc2_upb_formula.ifor_id=mikro_fg.ifor_id')
                                    0=>array('plc2.plc2_upb'=>'plc2.study_literatur_pd.iupb_id = plc2.plc2_upb.iupb_id')
                                );
        


        $this->datagrid=$datagrid;
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
                foreach ($vv as $kv => $vlist) {
                    $grid->setQuery($vlist['vall'], $vlist['nilai']);


                    
                }

                if($this->isAdmin){

                }else{
                    $grid->setQuery('plc2_upb.iteampd_id in ('.$this->teamID.')', NULL);                        
                }
            }

        }


        $grid->changeFieldType('iuji_mikro','combobox','',array(''=>'-- Pilih --',0=>'No',1=>'Yes'));
        $grid->changeFieldType('ijenis_sediaan','combobox','',array(''=>'-- Pilih --',0=>'Khusus Produk Steril',1=>'Khusus Produk Non Steril'));
        $grid->changeFieldType('iapppd','combobox','',array(0=>'Waiting Approval',1=>'Rejected',2=>'Approved'));
        $grid->changeFieldType('iSubmit','combobox','',array(0=>'Need to Submit',1=>'Submited'));


        
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
            case 'get_data_prev':
				echo $this->lib_plc->get_data_prev($this->urlpath);
                break;
            case 'createproses':
                    /* $isUpload = $this->input->get('isUpload');
                    $lastId = $this->input->get('lastId');

                    if($isUpload) {
                        $lastId = $_GET["lastId"];
                        $path = realpath("files/plc/study_literatur_pd");

                        if(!file_exists($path.'/'.$lastId)){
                            if (!mkdir($path.'/'.$lastId, 0777, true)) { 
                                die('Failed upload, try again!');
                            }
                        }
                                        

                        $file_name_file= '';
                        $file_vKeterangan_file = array();
                        $fileId_file = array();

                
                        foreach($_POST as $key=>$value) {

                            if ($key == 'file_vKeterangan_file') {
                                foreach($value as $y=>$u) {
                                    $file_vKeterangan_file[$y] = $u;
                                }
                            }

                        }

                        $i=0;
                        foreach ($_FILES['fileupload_file']['error'] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['fileupload_file']['tmp_name'][$key];
                                $name = $_FILES['fileupload_file']['name'][$key];
                                
                                $now_u = date('Y_m_d__H_i_s');
                                $name_generate = $i.'__'.$now_u.'__'.$_FILES['fileupload_file']['name'][$key];

                                $now = date('Y-m-d H:i:s');
                                $logged_nip = $this->user->gNIP;
                                $tabel_file = 'study_literatur_pd_file';
                                $tabel_file_pk = 'istudy_pd_id';
                                


                                if(move_uploaded_file($tmp_name, $path.'/'.$lastId.'/'.$name_generate)) {
                                    $sql[]= '
                                        insert into plc2.study_literatur_pd_file('.$tabel_file_pk.', vFilename, vFilename_generate, vKeterangan, dCreate, cCreate)
                                        values('.$lastId.'
                                        ,"'.$name.'" 
                                        ,"'.$name_generate.'" 
                                        , "'.$file_vKeterangan_file[$i].'" 
                                        ,"'.$now.'" 
                                        ,"'.$logged_nip.'" 
                                        )

                                    
                                    ';
                                    $i++;   

                                }else{

                                    echo 'Upload ke folder gagal';  
                                }


                            }

                        }

                        foreach($sql as $q) {
                            try {
                                $this->db_plc0->query($q);
                            }catch(Exception $e) {
                                die($e);
                            }
                        }
                        
                        $r['message']='Data Berhasil Disimpan';
                        $r['status'] = TRUE;
                        $r['last_id'] = $this->input->get('lastId');                    
                        echo json_encode($r);

                    }else{ */
                        echo $grid->saved_form();
                  // }
                    
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
				$lastId=isset($post[$this->url."_".$this->main_table_pk])?$post[$this->url."_".$this->main_table_pk]:"0";
				$dataFieldUpload=$this->lib_plc->getUploadFileFromField($this->input->get('modul_id'));
				if(count($dataFieldUpload)>0 && $lastId!="0" && $lastId!=""){
					foreach ($dataFieldUpload as $kf => $vUpload) {
						$pathf=$vUpload['filepath'];
						$iddetails=$vUpload['filename'].'_iFile';

						$validdetails=array();

						foreach ($post as $kk => $vv) {
							if($kk==$iddetails){
								foreach ($vv as $kv2 => $vv2) {
									$validdetails[]=$vv2;
								}
								
							}
						}
						$dataupdate['iDeleted']=1;
						$dataupdate['dUpdate']=date("Y-m-d H:i:s");
						$dataupdate['cUpdate']=$this->user->gNIP;
						if(count($validdetails)>0){
							$this->db_plc0->where('idHeader_File',$lastId)
                                            ->where_not_in('iFile',$validdetails)
                                            ->where('iM_modul_fileds',$vUpload['iM_modul_fileds'])
											->update('plc2.group_file_upload',$dataupdate);
						}else{
                            $this->db_plc0->where('idHeader_File',$lastId)
                                            ->where('iM_modul_fileds',$vUpload['iM_modul_fileds'])
											->update('plc2.group_file_upload',$dataupdate);
						}

						// Delete File
						$where=array('iDeleted'=>1,'idHeader_File'=>$lastId,'iM_modul_fileds'=>$vUpload['iM_modul_fileds']);
						$this->db_plc0->where($where);
						$qq=$this->db_plc0->get('plc2.group_file_upload');
						if($qq->num_rows() > 0){
							$result=$qq->result_array();
							foreach ($result as $kr => $vr) {
								if(isset($vr["vFilename_generate"])){
									$pathf=$vUpload['filepath'];
									$path = realpath($pathf);
									if(file_exists($path."/".$lastId."/".$vr["vFilename_generate"])){
										unlink($path."/".$lastId."/".$vr["vFilename_generate"]);
									}
								}
							}

						}
					}
				}
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

            case 'uploadFile':
		
                $lastId=$this->input->get('lastId');
				$dataFieldUpload=$this->lib_plc->getUploadFileFromField($this->input->get('modul_id'));//print_r($this->input->get());exit();
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
                                $name_generate = $i.'__'.$now_u.'__'.$name;
									if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name_generate)) {
										$datainsert=array();
										$datainsert['idHeader_File']=$lastId;
										$datainsert['iM_modul_fileds']=$vUpload['iM_modul_fileds'];
										$datainsert['dCreate']= date('Y-m-d H:i:s');
										$datainsert['cCreate']= $this->user->gNIP;
										$datainsert['vFilename']= $name;
										$datainsert['vFilename_generate']= $name_generate;
										$datainsert['tKeterangan']= $fKeterangan[$i];
										$this->db_plc0->insert('plc2.group_file_upload',$datainsert);
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

    function listBox_Action($row, $actions) {
        /* $peka=$row->istudy_pd_id;
        $getLastactivity = $this->lib_plc->getLastactivity($this->modul_id,$peka);
        $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

        if ( $getLastactivity == 0 ) { 
               if($row->iappbusdev <> 0){
                    // approval DR lewat setting prioritas
                    unset($actions['edit']);    

               } 
        }else{
            if($isOpenEditing){

            }else{
                unset($actions['edit']);    
            }
            
        } */


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
                                        var url = "'.base_url().'processor/plc/v3_study_literatur_pd";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_study_literatur_pd").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_study_literatur_pd");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_v3_study_literatur_pd_approve" action="'.base_url().'processor/plc/v3_study_literatur_pd?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="istudy_pd_id" value="'.$this->input->get('istudy_pd_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_study_literatur_pd_approve\')">Approve</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function approve_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $istudy_pd_id = $post['istudy_pd_id'];
                $iupb_id = $post['iupb_id'];
                
                $vRemark = $post['vRemark'];
                $modul_id = $post['modul_id'];


                //Letakan Query Update approve disini
                $data=array('iapppd'=>'2');
                $this -> db -> where('istudy_pd_id', $istudy_pd_id);
                $updet = $this -> db -> update('plc2.study_literatur_pd', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_activity = $isAndSort['iM_activity'];
                $iSort = $isAndSort['iSort'];

                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$istudy_pd_id,$iM_activity,$iSort,$vRemark,2);
    
                $data['status']  = true;
                $data['last_id'] = $post['istudy_pd_id'];
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
                                        var url = "'.base_url().'processor/plc/v3_study_literatur_pd";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_study_literatur_pd").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_study_literatur_pd");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_v3_study_literatur_pd_confirm" action="'.base_url().'processor/plc/v3_study_literatur_pd?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="istudy_pd_id" value="'.$this->input->get('istudy_pd_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_study_literatur_pd_confirm\')">Confirm</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function confirm_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $istudy_pd_id = $post['istudy_pd_id'];
                $iupb_id = $post['iupb_id'];
                $vRemark = $post['vRemark'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $modul_id = $post['modul_id'];

                $now            = date('Y-m-d H:i:s');

                //Letakan Query Update approve disini
                $data=array('iapppd'=>'2');
                $this -> db -> where('istudy_pd_id', $istudy_pd_id);
                $updet = $this -> db -> update('plc2.study_literatur_pd', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_activity = $isAndSort['iM_activity'];
                $iSort = $isAndSort['iSort'];
                
                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$istudy_pd_id,$iM_activity,$iSort,$vRemark,2);

                /* masuk ke skala trial  */
                    /* syaratnya masuk skala trial terbaru
                        1. confirm study literatur PD
                        2. confirm study literatur AD
                        3. terima input sample originator oleh QA
                        4. terima bb oleh PD

                    */

                    $stPD = 'select *
                            from plc3.m_modul a 
                            join plc3.m_modul_log_activity b on b.idprivi_modules=a.idprivi_modules
                            join plc3.m_modul_log_upb c on c.iM_modul_log_activity=b.iM_modul_log_activity
                            where 
                            a.iM_modul in (3)
                            and b.iM_activity = 4
                            and c.iupb_id="'.$iupb_id.'" ';

                    $stAD = 'select *
                            from plc3.m_modul a 
                            join plc3.m_modul_log_activity b on b.idprivi_modules=a.idprivi_modules
                            join plc3.m_modul_log_upb c on c.iM_modul_log_activity=b.iM_modul_log_activity
                            where 
                            
                            a.iM_modul in (4)
                            and b.iM_activity = 4
                            and c.iupb_id="'.$iupb_id.'" ';

                    $inpQA = 'select *
                            from plc3.m_modul a 
                            join plc3.m_modul_log_activity b on b.idprivi_modules=a.idprivi_modules
                            join plc3.m_modul_log_upb c on c.iM_modul_log_activity=b.iM_modul_log_activity
                            where 
                            
                            a.iM_modul in (11)
                            and b.iSort = 4
                            and c.iupb_id="'.$iupb_id.'" ';

                    $terimaPD = 'select *
                            from plc3.m_modul a 
                            join plc3.m_modul_log_activity b on b.idprivi_modules=a.idprivi_modules
                            join plc3.m_modul_log_upb c on c.iM_modul_log_activity=b.iM_modul_log_activity
                            where 
                            a.iM_modul in (25)
                            and b.iSort = 2
                            and c.iupb_id="'.$iupb_id.'" ';

                    $cPD = $this->db->query($stPD)->num_rows();
                    $cAD = $this->db->query($stAD)->num_rows();
                    $cQA = $this->db->query($inpQA)->num_rows();
                    $cTPD = $this->db->query($terimaPD)->num_rows();

                    
                    if( $cPD > 0 and $cAD > 0 and $cQA > 0 and $cTPD > 0){

                        $cek_form = "SELECT * FROM pddetail.formula_process fp WHERE fp.lDeleted = 0 AND fp.iMaster_flow = 1 AND fp.iupb_id IN (".$iupb_id.")";
                        $dcek = $this->db->query($cek_form)->result_array();

                        if (count($dcek) == 0){             
                            //Insert Formula Proses
                            $sqlto_Back     = "INSERT pddetail.formula_process (iupb_id,iMaster_flow,cCreated,dCreate) VALUES (?, ?, ?, ?)"; 
                            $this->db->query($sqlto_Back, array($iupb_id, '1', $cNip, $now));
                            $iFormula_process = $this->db->insert_id();

                            //Insert Formula Proses Detail
                            $pn = "INSERT INTO pddetail.formula_process_detail(iFormula_process, cPic, iProses_id, is_proses, dStart_time, cCreated, dCreate) VALUES (?,?,'1','1',?,?,?)";
                            $this->db->query($pn, array($iFormula_process, $cNip, $now, $cNip, $now));

                            //Insert Formula Awal
                            $ver = 0;
                            $iFd ='INSERT INTO pddetail.formula (iFormula_process,iVersi,dCreate,cCreated) VALUES(?,?,?,?)';
                            $this->db->query($iFd, array($iFormula_process, $ver, $now, $cNip));
                        }

                        $cek_fromPD = 'SELECT f.iFormula FROM pddetail.formula_process fp 
                                        JOIN pddetail.formula f ON f.iFormula_process = fp.iFormula_process
                                        WHERE fp.lDeleted = 0 AND f.lDeleted = 0
                                            AND fp.iupb_id = ? ';
                        $dFormula = $this->db_plc0->query($cek_fromPD, array($iupb_id))->result_array(); 

                        if (count($dFormula) > 0) {
                            foreach ($dFormula as $forfor) {
                                $this->db->where('iFormula', $forfor['iFormula']);
                                $this->db->update('pddetail.formula', array('iBackSample'=>0));                                            
                            }
                                
                        }
                    }

                /* masuk ke skala trial  */

                $data['status']  = true;
                $data['last_id'] = $post['istudy_pd_id'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }
    
        
            //Ini Merupakan Standart Reject yang digunakan di erp
            function reject_view() {
                $echo = '<script type="text/javascript">
                             function submit_ajax(form_id) {
                                var remark = $("#v3_study_literatur_pd_remark").val();
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
                                        var url = "'.base_url().'processor/plc/v3_study_literatur_pd";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v3_study_literatur_pd").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v3_study_literatur_pd");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_v3_study_literatur_pd_reject" action="'.base_url().'processor/plc/v3_study_literatur_pd?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="istudy_pd_id" value="'.$this->input->get('istudy_pd_id').'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark" id="reject_v3_study_literatur_pd_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v3_study_literatur_pd_reject\')">Reject</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            }
    
    
            
            function reject_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $istudy_pd_id = $post['istudy_pd_id'];
                $iupb_id = $post['iupb_id'];
                $vRemark = $post['vRemark'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $modul_id = $post['modul_id'];
    
                //Letakan Query Update reject disini
                $data=array('iapppd'=>'1');
                $this -> db -> where('istudy_pd_id', $istudy_pd_id);
                $updet = $this -> db -> update('plc2.study_literatur_pd', $data);

                $iM_modul_activity = $post['iM_modul_activity'];
                $isAndSort = $this->lib_plc->getIDActivityAndSort($iM_modul_activity);
                $iM_activity = $isAndSort['iM_activity'];
                $iSort = $isAndSort['iSort'];
                
                $arrUPB['iupb_id'] = $iupb_id;
                $this->lib_plc->InsertActivityModule($arrUPB,$modul_id,$istudy_pd_id,$iM_activity,$iSort,$vRemark,1);
    
                $data['status']  = true;
                $data['last_id'] = $post['istudy_pd_id'];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }


    function getHistory($iupb_id,$iTujuan_req){

        $sql = 'select a.vreq_ori_no , date(a.tcreate) as tcreate , a.tapppd as tapppd,a.vnip_apppd  
                from plc2.study_literatur_pd a 
                where 
                a.ldeleted=0
                and a.iupb_id= "'.$iupb_id.'"  
                and a.iTujuan_req= "'.$iTujuan_req.'"  
                order by istudy_pd_id
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
      

        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } else{
            $postData['iSubmit']=1;
            $arrUPB['iupb_id'] = $postData['iupb_id'];
            

            $this->lib_plc->InsertActivityModule($arrUPB,$this->modul_id,$id,1,1);
        }

            $iupb_id = $postData['iupb_id'];
            $imaster_delivery = $postData['imaster_delivery'];
            $SQL = "UPDATE plc2.plc2_upb set imaster_delivery='{$imaster_delivery}' where iupb_id = '{$iupb_id}'";
            $this->db_plc0->query($SQL);


        
    }


    function before_update_processor($row, $postData) {
        $postData['dUpdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;

        $controller_name ='v3_study_literatur_pd';
        $pk_field = 'istudy_pd_id';
        $gabung = $controller_name."_".$pk_field;
        $peka=$postData[$gabung];

        if($postData['isdraft']==true){
            $postData['iSubmit']=0;
        } else{
            

            $postData['iSubmit']=1;
            $arrUPB['iupb_id'] = $postData['iupb_id'];
            $this->lib_plc->InsertActivityModule($arrUPB,$this->modul_id,$peka,1,1);
        } 

        $iupb_id = $postData['iupb_id'];
        $imaster_delivery = $postData['imaster_delivery'];
        $SQL = "UPDATE plc2.plc2_upb set imaster_delivery='{$imaster_delivery}' where iupb_id = '{$iupb_id}'";
        $this->db_plc0->query($SQL);


        return $postData; 
    }




    function manipulate_update_button($buttons, $rowData) { 
        $peka=$rowData['istudy_pd_id'];
        $iupb_id=$rowData['iupb_id'];


        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $data['upload']='upload_custom_grid';
        $js = $this->load->view('js/standard_js',$data,TRUE);
     //$js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="v3_study_literatur_pd_frame" id="v3_study_literatur_pd_frame" height="0" width="0"></iframe>';
        

        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        }
        else{ 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_plc->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_study_literatur_pd\', \' '.base_url().'processor/plc/v3_study_literatur_pd?draft=true \',this,true )"  id="button_update_draft_v3_study_literatur_pd"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_plc->get_current_module_activities($this->modul_id,$peka);
                    $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,$peka);

                    foreach ($activities as $act) {
                        $update_draft = '<button onclick="javascript:update_draft_btn(\'v3_study_literatur_pd\', \' '.base_url().'processor/plc/v3_study_literatur_pd?draft=true \',this,true )"  id="button_update_draft_v3_study_literatur_pd"  class="ui-button-text icon-save" >Update as Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\'v3_study_literatur_pd\', \' '.base_url().'processor/plc/v3_study_literatur_pd?company_id='.$this->input->get('company_id').'&iM_modul_activity='.$act['iM_modul_activity'].'group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_v3_study_literatur_pd"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_study_literatur_pd?action=approve&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&istudy_pd_id='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_study_literatur_pd"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_study_literatur_pd?action=reject&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&istudy_pd_id='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_v3_study_literatur_pd"  class="ui-button-text icon-save" >Reject</button>';

                        $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/plc/v3_study_literatur_pd?action=confirm&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&istudy_pd_id='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v3_study_literatur_pd"  class="ui-button-text icon-save" >Confirm</button>';

                        

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
        $data['upload']='upload_custom_grid';
        $js = $this->load->view('js/standard_js',$data,TRUE);
     //$js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="v3_study_literatur_pd_frame" id="v3_study_literatur_pd_frame" height="0" width="0"></iframe>';
        
        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'v3_study_literatur_pd\', \' '.base_url().'processor/plc/v3_study_literatur_pd?draft=true \',this,true )"  id="button_save_draft_v3_study_literatur_pd"  class="ui-button-text icon-save" >Save as Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\'v3_study_literatur_pd\', \' '.base_url().'processor/plc/v3_study_literatur_pd?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_save_submit_v3_study_literatur_pd"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

        $AuthModul = $this->lib_plc->getAuthorModul($this->modul_id);
        $arrTeam = explode(',',$this->team);
        $nipAuthor = explode(',', $AuthModul['vNip_author']);

        if( in_array($AuthModul['vDept_author'],$arrTeam )  || in_array($this->user->gNIP, $nipAuthor)  ){

            $buttons['save'] = $iframe.$save_draft.$save.$js;
        }else{
            unset($buttons['save']);
            $buttons['save'] = '<span style="color:red;" title="'.$AuthModul['vDept_author'].'">You\'re Dept not Authorized</span>';
        }
        
        
        return $buttons;
    }

    /*Manipulate Insert/Update Form*/
    function insertBox_v3_study_literatur_pd_form_detail($field,$id){
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

    function updateBox_v3_study_literatur_pd_form_detail($field,$id,$value,$rowData){
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

                    $path = 'files/plc/study_literatur_pd';
                    $createname_space =$this->url;
                    $tempat = 'study_literatur_pd';
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
            }

        }else{
            $hate_emel .='Field belum disetting';
        }

        $hate_emel .= '<input type="hidden" name="isdraft" id="isdraft">';
       // print_r($hate_emel);
        
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
		
		$where=array('iDeleted'=>0,'idHeader_File'=>$post["id"],'iM_modul_fileds'=>$row['iM_modul_fileds']);
		$this->db_plc0->where($where);
		$q=$this->db_plc0->get('plc2.group_file_upload');
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


    function download($vFilename) { 
        $this->load->helper('download');        
        $name = $vFilename;
        $id = $_GET['id'];
        $tempat = $_GET['path'];    
        $path = file_get_contents('./files/plc/'.$tempat.'/'.$id.'/'.$name);    
        force_download($name, $path);


    }


}
