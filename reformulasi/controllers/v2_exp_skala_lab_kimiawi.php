<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v2_exp_skala_lab_kimiawi extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
		$this->load->library('lib_sub_core');
        $this->load->library('lib_refor');

        $this->modul_id 	= $this->input->get('modul_id');
        $this->iModul_id 	= $this->lib_sub_core->getIModulID($this->input->get('modul_id'));
        $this->db 			= $this->load->database('formulasi',false, true);
        $this->user 		= $this->auth->user();

        $this->team 		= $this->lib_sub_core->hasTeam($this->user->gNIP);
        $this->teamID 		= $this->lib_sub_core->hasTeamID($this->user->gNIP);
        $this->isAdmin 		= $this->lib_sub_core->isAdmin($this->user->gNIP);

		$this->title 		= 'Skala Lab - Uji Kimiawi';
		$this->url 			= 'v2_exp_skala_lab_kimiawi';
		$this->urlpath 		= 'reformulasi/'.str_replace("_","/", $this->url);

		$this->maintable 	= 'reformulasi.export_skala_lab';	
		$this->main_table 	= $this->maintable;	
		$this->main_table_pk= 'iexport_skala_lab';	
		
		$datagrid['islist'] = array(
			'export_req_refor.vno_export_req_refor' => array('label' => 'Nomor Request Refor',	'width' => 150,	'align' => 'center', 'search' => true),
            'isubmit_fisik'                         => array('label' => 'Submit Uji Fisik',     'width' => 150, 'align' => 'center', 'search' => true),
            'isubmit_kimiawi'                       => array('label' => 'Submit Uji Kimiawi',   'width' => 150, 'align' => 'center', 'search' => true),
            'iappad_kimiawi'                        => array('label' => 'Approval Uji Kimiawi', 'width' => 150, 'align' => 'center', 'search' => false),
		);		

        $sql_check_submit = '( SELECT COUNT(*) AS submitted FROM reformulasi.export_skala_lab_formula f WHERE f.iexport_skala_lab = export_skala_lab.iexport_skala_lab AND f.isubmit_fisik = 1 AND f.ldeleted = 0 ) > 0';
		$datagrid['setQuery'] = array(
			0 => array('vall' => 'export_skala_lab.ldeleted',   'nilai' => 0),
            0 => array('vall' => 'export_req_refor.lDeleted',   'nilai' => 0),
            0 => array('vall' => $sql_check_submit,             'nilai' => null),
		);

		$datagrid['jointableinner'] = array(
			0 => array('reformulasi.export_req_refor' 	=> 'export_skala_lab.iexport_req_refor = export_req_refor.iexport_req_refor'),
		);

		$datagrid['shortBy'] = array( "export_skala_lab.iexport_skala_lab" => "DESC");
		
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
						$grid->setJoinTable($tbjoin, $onjoin, 'left');
					}
				}
			}
			if($kv=='setQuery'){
				foreach ($vv as $list => $vlist) {
					$grid->setQuery($vlist['vall'], $vlist['nilai']);
				}
			}

		}

		$grid->changeFieldType('isubmit_fisik', 'combobox','',array(''=>'--select--',0=>'Need to be Submit', 1=>'Submited'));
        $grid->changeFieldType('isubmit_kimiawi', 'combobox','',array(''=>'--select--',0=>'Need to be Submit', 1=>'Submited'));
		$grid->changeFieldType('iappad_kimiawi', 'combobox','',array(''=>'--select--',0=>'Waiting for approval',1=>'Rejected', 2=>'Approved'));

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
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
                $post           = $this->input->post();
                $get            = $this->input->get();
                $lastId         = isset($post[$this->url."_".$this->main_table_pk])?$post[$this->url."_".$this->main_table_pk]:"0";

                $check          = $this->canSubmitKimiawi($lastId);

                if ($check['status'] == true){
                    echo $grid->updated_form();
                } else {
                    echo json_encode($check);
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
				echo $this->lib_sub_core->get_data_prev($this->urlpath);
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
                echo $this->approve_view();
                break;
            case 'reject':
                echo $this->reject_view();
                break;
            case 'approve_process':
                echo $this->approve_process();
                break;
            case 'reject_process':
                echo $this->reject_process();
                break;

			case 'download':
				$this->load->helper('download');		
				$name 	= $_GET['file'];
				$id 	= $_GET['id'];
				$path 	= $_GET['path'];

				$this->db->select("*")
    				->from("erp_privi.sys_masterdok")
    				->where("filename",$path);
    			$row 	= $this->db->get()->row_array();

    			if(count($row) > 0 && isset($row["filepath"])){
    				$path = file_get_contents('./'.$row['filepath'].'/'.$id.'/'.$name);	
					force_download($name, $path);
    			}else{
    				echo "File Not Found - 0x01";
    			}
				
				break;

			case 'uploadFile':
				$lastId 			= $this->input->get('lastId');
				$dataFieldUpload  	= $this->lib_sub_core->getUploadFileFromField($this->input->get('modul_id'));//print_r($this->input->get());exit();
				if(count($dataFieldUpload) > 0){
					foreach ($dataFieldUpload as $kf => $vUpload) {
                        $pathf=$vUpload['filepath'];
                        // Cek Path Sub Folder
                        $patharr 	= explode("/",$pathf);
                        $ii 		= 0;
                        foreach ($patharr as $kpp => $vpp) {
                            $sasa 	= array();
                            if($ii <> 0){
                                for ($i = 0; $i <= $ii; $i++) {
                                    if($i <> 0){
                                        $sasa[] = $patharr[$i];
                                    } 
                                }
                                $papat 	= implode("/",$sasa);
                                $path 	= realpath("files");
                                if(!file_exists($path."/".$papat)){
                                    if (!mkdir($path."/".$papat, 0777, true)) { 
                                        die('Failed upload, try again!'.$papat);
                                    }
                                }

                           }
                           $ii++;
                        }
                        $path   	= realpath($pathf);

                        if(!file_exists($path."/".$lastId)){
                            if (!mkdir($path."/".$lastId, 0777, true)) {
                                die('Failed upload, try again!----'.$path);
                            }
                        }

						
                        $fKeterangan = array();
                        foreach($_POST as $key => $value) {                       
                            if ($key == 'erp_privi_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_fileketerangan') {
                                foreach($value as $k=>$v) {
                                    $fKeterangan[$k] = $v;
                                }
                            }
                        }

                        $i=0;
                        foreach ($_FILES['erp_privi_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name           = $_FILES['erp_privi_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file']["tmp_name"][$key];
                                $name               = $_FILES['erp_privi_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['filename'].'_upload_file']["name"][$key];
                                $data['filename']   = $name;
                                $data['dInsertDate']= date('Y-m-d H:i:s');
                                $filenameori        = $name;
                                $now_u              = date('Y_m_d__H_i_s');
                                $name_generate      = $this->lib_sub_core->generateFilename($name, $i);

								if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name_generate)) {
									$datainsert=array();
									$datainsert['idHeader_File'] 	= $lastId;
									$datainsert['iM_modul_fields']	= $vUpload['iM_modul_fields'];
									$datainsert['dCreate'] 			= date('Y-m-d H:i:s');
									$datainsert['cCreate'] 			= $this->user->gNIP;
									$datainsert['vFilename'] 		= $name;
									$datainsert['vFilename_generate']= $name_generate;
                                    $datainsert['tKeterangan'] 		= $fKeterangan[$i];

                                    $sql1	= 'SELECT * FROM erp_privi.m_modul mo 
                                        		JOIN erp_privi.m_application ap ON mo.iM_application = ap.iM_application
                                        		WHERE mo.lDeleted = 0 AND ap.lDeleted = 0 AND mo.idprivi_modules = '.$this->input->get('modul_id');
                                    $row2 	= $this->db->query($sql1)->row_array();		
									$this->db->insert($row2['vTable_file'],$datainsert);
									$i++;	

								} else {
									echo "Upload ke folder gagal";
								}
							}
						}
					}
					$r['message'] 	= "Data Berhasil Disimpan";
					$r['status'] 	= TRUE;
					$r['last_id'] 	= $this->input->get('lastId');					
					echo json_encode($r);

				}else{
					$r['message'] 	= "Data Upload Not Found";
					$r['status'] 	= TRUE;
					$r['last_id'] 	= $this->input->get('lastId');					
					echo json_encode($r);
				}
                break;
            case 'load_detail':
                echo $this->load_detail();
                break;
            case 'load_pic':
                echo $this->load_pic();
                break;
			default:
				$grid->render_grid();
				break;
		}
    }

    function load_detail(){
        $post       = $this->input->post();
        $field_id   = $post['field_id'];
        $idexp      = $post['id_refor'];
        $fieldDet   = $this->db->get_where('erp_privi.m_modul_fields', array('lDeleted' => 0, 'iM_modul_fields' => $field_id))->row_array();
        if (!empty($fieldDet)){
            $loadView       = $fieldDet['vFile_detail'];
            $sqlDet         = $fieldDet['vSource_input'];
            $sqlFile        = $fieldDet['vSource_input_edit'];

            $upload         = $this->db->query($sqlFile, array($idexp))->result_array();
            $detail         = $this->db->query($sqlDet, array($idexp))->row_array();

            $data['rows']   = $detail;
            $data['upload'] = $upload;
            $data['id']     = $post['id'];
            $viewDetail     = $this->load->view('partial/modul/'.$loadView, $data, TRUE);
            echo $viewDetail;exit();
            
        } else {
            echo "Field Tidak Ditemukan";exit();
        }
    }

    function load_pic(){
        $get        = $this->input->get();
        $term       = $get['term']; 

        $sql        = 'SELECT cNip AS id, CONCAT(cNip, " - ", vName) AS value FROM hrd.employee WHERE ( cNip LIKE "%'.$term.'%" OR vName LIKE "%'.$term.'%" ) AND dResign = "0000-00-00" ';
        $data       = $this->db->query($sql)->result_array();

        echo json_encode($data);exit();
    }

    function getFormDetail(){
    	$post 			= $this->input->post();
        $get 			= $this->input->get();
        $data['html']	= "";
        $dFields 		= $this->lib_sub_core->getFields($this->iModul_id);
        $hate_emel 		= "";

        if ($get['formaction'] == 'update') {
                $aidi = $get['id'];
        } else {
                $aidi = 0;
        }

        $hate_emel .= '
            <table class="hover_table" style="width:99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
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

                $hate_emel .= $this->lib_sub_core->getHistoryActivity($this->modul_id, $aidi, true);

        $hate_emel .='
                </tbody>
            </table>
            <br>
            <br>
            <hr>
        ';


        if(!empty($dFields)){

            foreach ($dFields as $form_field) {
            	$iM_jenis_field 				= intval($form_field['iM_jenis_field']);

            	foreach ($get as $ig => $vg) {
            		$data_field[$ig] 			= $vg;
            	}
                
                $data_field['iM_jenis_field'] 	= $form_field['iM_jenis_field'] ;
                $form_field['id_refor'] 		= 0;
                $data_field['form_field'] 		= $form_field;
                $data_field['get'] 				= $get;
                $data_field['post'] 			= $post;

                $controller 					= $this->url;
                $folderpath 					= str_replace(str_replace('_', '/', $this->url), '', $this->urlpath); 
                $data_field['id'] 				= $controller.'_'.$form_field['vNama_field'];
                // $data_field['field'] 			= $controller.'_'.$form_field['vNama_field'] ;
                $data_field['field'] 			= $form_field['vNama_field'] ;
                $data_field['urlpath'] 			= $this->urlpath;
                $data_field['folderpath'] 		= $folderpath;

                $data_field['act'] 				= $get['act'] ;
                $data_field['hasTeam'] 			= $this->team ;
                $data_field['hasTeamID'] 		= $this->teamID ;
                $data_field['isAdmin'] 			= $this->isAdmin ; 

                $return_field 					= "";

                /*untuk keperluad file upload*/
                if($form_field['iM_jenis_field'] == 7){
                    $data_field['tabel_file'] 		= $form_field['vTabel_file'] ;
                    $data_field['tabel_file_pk'] 	= $this->main_table_pk;
                    $data_field['tabel_file_pk_id'] = $form_field['vTabel_file_pk_id'] ;

                    $path  							= 'files/plc/dok_tambah';
                    $createname_space 				= $this->url;
                    $tempat 						= 'dok_tambah';
                    $FOLDER_APP 					= $folderpath;

                    $data_field['path'] 			= $path;
                    $data_field['FOLDER_APP'] 		= $FOLDER_APP;
                    $data_field['createname_space'] = $createname_space;
                    $data_field['tempat'] 			= $tempat;
                    $data_field['field_required'] 	= ( intval($form_field['iRequired']) == 1 ) ? 'required' : '';


                }
                /*untuk keperluad file upload*/ 

                if($get['formaction'] == 'update'){
                    $id 							= $get['id'];
                    $dataHead 						= $this->db->get_where($this->maintable, array('lDeleted' => 0, $this->main_table_pk => $id))->row_array();
                    $activities 					= $this->lib_sub_core->get_current_module_activities($this->modul_id, $dataHead[$this->main_table_pk]); 
                    $isort 							= ( count($activities) > 0 ) ? $activities[0]['iSort'] : 0;

                    if ($iM_jenis_field == 13){
                    	$data_field['form_field']['iRead_only_form'] = 1;
                    } else if ($iM_jenis_field == 5 && $isort > 1){
                    	$data_field['form_field']['iRead_only_form'] = 1;                    	
                    }

                    $data_field['dataHead'] 		= $dataHead;
                    $data_field['main_table_pk'] 	= $this->main_table_pk;
                    $data_field['vSource_input'] 	= ( intval($form_field['iM_jenis_field']) == 6 ) ? $form_field['vSource_input_edit'] : $form_field['vSource_input'];
                    $return_field 					= $this->load->view('partial/v3_form_detail_update',$data_field,true);   


                }else{
                    $data_field['vSource_input'] 	= $form_field['vSource_input'] ;
                    $return_field  					= $this->load->view('partial/v3_form_detail',$data_field,true);      
                    
                }
                

                $hate_emel 						.='  <div class="rows_group" style="overflow:fixed;">
                											<label for="'.$controller.'_form_detail_'.$form_field['vNama_field'].'" class="rows_label">'.$form_field['vDesciption'].'';

                $hate_emel 						.= ( $form_field['iRequired'] == 1 ) ? '<span class="required_bintang">*</span>' : '';
                $data_field['field_required'] 	= ( $form_field['iRequired'] == 1 ) ? 'required' : '';

                $hate_emel 						.= ( $form_field['vRequirement_field'] <> "" ) ? '<span style="float:right;" title="'.$form_field['vRequirement_field'].'" class="ui-icon ui-icon-info"></span>' : '';

              //   if ($iM_jenis_field == 8 && $get['formaction']=='update'){

	            	// $hate_emel 					.= '</label> <div class="">'.$return_field.'</div> </div>';
              //       $hate_emel 					.= '<script> $("label[for=\''.$this->url.'_form_detail_'.$form_field['vNama_field'].'\']").hide(); </script>';

              //   } else {

	            	$hate_emel 					.=' </label> <div class="rows_input">'.$return_field.'</div> </div>';

                // }
            }

        }else{
            $hate_emel .='Field belum disetting';
        }

        $hate_emel .= '<input type="hidden" name="isdraft" id="isdraft">';
        // print_r($hate_emel);exit();
        $data["html"] .= $hate_emel;
        return json_encode($data);
    }

        function listBox_v2_exp_skala_lab_kimiawi_iapppr($value) {
            if($value==0){$vstatus='Waiting for approval';}
            elseif($value==1){$vstatus='Rejected';}
            elseif($value==2){$vstatus='Approved';}
            return $vstatus;
        }

        function listBox_v2_exp_skala_lab_kimiawi_cRequestor($value) {
        	$employee 	= $this->db->get_where('hrd.employee', array('cNip' => $value))->row_array();
        	$emp 		= ( !empty($employee) ) ? $employee['cNip'].' - '.$employee['vName'] : $value;
            return $emp;
        }

        function listBox_Action($row, $actions) {
	        $row                = get_object_vars($row);
	        $peka               = $row[$this->main_table_pk];
            $getLastactivity 	= $this->lib_sub_core->getLastactivity($this->modul_id,$peka);
            $isOpenEditing 		= $this->lib_sub_core->getOpenEditing($this->modul_id,$peka);
            $currentActivity 	= $this->lib_sub_core->get_current_module_activities($this->modul_id, $peka); 

            if ( $getLastactivity == 0 ) { 
                    
            }else{
                if($isOpenEditing){

                }else{
                    unset($actions['edit']);    
                }
                
            }

            if (count($currentActivity) > 0){
            	if ($currentActivity[0]['iSort'] == 3 && $row['iuji_mikro'] == 0){
                    unset($actions['edit']); 
            	}
            }

            return $actions;
        }


        function insertBox_v2_exp_skala_lab_kimiawi_form_detail($field,$id){
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

        function updateBox_v2_exp_skala_lab_kimiawi_form_detail($field,$id,$value,$rowData){
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
                                        var url = "'.base_url().'processor/reformulasi/v2_exp_skala_lab_kimiawi";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v2_exp_skala_lab_kimiawi").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v2_exp_skala_lab_kimiawi");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_v2_exp_skala_lab_kimiawi_approve" action="'.base_url().'processor/reformulasi/v2_exp_skala_lab_kimiawi?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v2_exp_skala_lab_kimiawi_approve\')">Approve</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function approve_process() {
                $post 		= $this->input->post();
                $cNip 		= $this->user->gNIP;
                $vName 		= $this->user->gName; 
                $pk 		= $post[$this->main_table_pk];
                $vRemark 	= $post['vRemark'];
                $modul_id 	= $post['modul_id'];
                $id_activity= $post['iM_modul_activity'];
                $lvl 		= $post['lvl'];

                $activity = $this->db->get_where('erp_privi.m_modul_activity', array('iM_modul_activity'=>$id_activity, 'lDeleted'=>0))->row_array();
                
                //update ke main table
                $update = $this->lib_refor->getFieldUpdate($this->maintable, $id_activity, 2, $vRemark);
                $this->db->where($this->main_table_pk, $pk);
                $this->db->update($this->maintable, $update);

                $this->lib_sub_core->InsertActivityModule($this->ViewUPB($pk),$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);
                $this->sendNotifKesimpulan($pk);
    
                $data['status']  = true;
                $data['last_id'] = $post[$this->main_table_pk];
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
                                        var url = "'.base_url().'processor/reformulasi/v2_exp_skala_lab_kimiawi";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v2_exp_skala_lab_kimiawi").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v2_exp_skala_lab_kimiawi");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_v2_exp_skala_lab_kimiawi_confirm" action="'.base_url().'processor/reformulasi/v2_exp_skala_lab_kimiawi?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v2_exp_skala_lab_kimiawi_confirm\')">Confirm</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function confirm_process() {
                $post  		= $this->input->post();
                $cNip 		= $this->user->gNIP;
                $vName 		= $this->user->gName;
                $pk 		= $post[$this->main_table_pk];
                $vRemark 	= $post['vRemark'];
                $lvl 		= $post['lvl'];
                $modul_id 	= $post['modul_id'];
                $id_activity= $post['iM_modul_activity'];

                $activity 	= $this->db->get_where('erp_privi.m_modul_activity', array('iM_modul_activity'=>$id_activity, 'lDeleted'=>0))->row_array();

                //update ke main table
                $update = $this->lib_refor->getFieldUpdate($this->maintable, $id_activity, 2, $vRemark);
                $this->db->where($this->main_table_pk, $pk);
                $this->db->update($this->maintable, $update);

                $this->lib_sub_core->InsertActivityModule($this->ViewUPB($pk),$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);
                
                $data['status']  = true;
                $data['last_id'] = $post[$this->main_table_pk];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }
        
            //Ini Merupakan Standart Reject yang digunakan di erp
            function reject_view() {
                $echo = '<script type="text/javascript">
                             function submit_ajax(form_id) {
                                var remark = $("#v2_exp_skala_lab_kimiawi_remark").val();
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
                                        var url = "'.base_url().'processor/reformulasi/v2_exp_skala_lab_kimiawi";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v2_exp_skala_lab_kimiawi").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v2_exp_skala_lab_kimiawi");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_v2_exp_skala_lab_kimiawi_reject" action="'.base_url().'processor/reformulasi/v2_exp_skala_lab_kimiawi?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark" id="reject_v2_exp_skala_lab_kimiawi_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v2_exp_skala_lab_kimiawi_reject\')">Reject</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            }
            
    function reject_process() {
        $post       = $this->input->post();
        $cNip       = $this->user->gNIP;
        $vName      = $this->user->gName;
        $group_id   = $post['group_id'];
        $modul_id   = $post['modul_id'];
        $pk         = $post[$this->main_table_pk];
        $vRemark    = $post['vRemark'];
        $lvl        = $post['lvl'];
        $modul_id   = $post['modul_id'];
        $iM_modul_activity = $post['iM_modul_activity'];

        $sqlActivity = 'SELECT ap.vTable_log_activity, ac.vFieldName, ac.dFieldName, ac.cFieldName, ac.tFieldName, ac.iM_activity, ac.iSort, m.idprivi_modules
                        FROM erp_privi.m_modul_activity ac 
                        JOIN erp_privi.m_modul m ON ac.iM_modul = m.iM_modul
                        JOIN erp_privi.m_application ap ON m.iM_application = ap.iM_application
                        WHERE ac.iM_modul_activity = ? ';
        $activity   = $this->db->query($sqlActivity, array($iM_modul_activity))->row_array();

        //update ke main table
        $update = $this->lib_refor->getFieldUpdate($this->maintable, $iM_modul_activity, 0, $vRemark);
        $update['isubmit_kimiawi']       = 0;
        $this->db->where($this->main_table_pk, $pk);
        $this->db->update($this->maintable, $update);

        $this->lib_sub_core->InsertActivityModule($this->ViewUPB($pk),$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,1);

        //delete log
        $deleteLog['lDeleted']  = 1;
        $deleteLog['dupdate']   = date('Y-m-d H:i:s');
        $deleteLog['cUpdate']   = $cNip;
        $this->db->where('idprivi_modules', $modul_id);
        $this->db->where('iKey_id', $pk);
        $this->db->update('erp_privi.'.$activity['vTable_log_activity'], $deleteLog);

        //update skala trial formula jadi draft
        $resetFormula['isubmit_kimiawi']    = 0;
        $resetFormula['dsubmit_kimiawi']    = null;
        $resetFormula['csubmit_kimiawi']    = null;
        $this->db->where('iexport_skala_lab', $pk);
        $this->db->update('reformulasi.export_skala_lab_formula', $resetFormula);

        $data['status']     = true;
        $data['last_id']    = $pk;
        $data['group_id']   = $group_id;
        $data['modul_id']   = $modul_id;
        return json_encode($data);
    }



    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) { 

        $postData['dcreate'] 		= date('Y-m-d H:i:s');
        $postData['ccreate'] 		= $this->user->gNIP;
        $postData['ldeleted'] 		= 0;

        return $postData;
    }

    function before_update_processor($row, $postData) { 

        $postData['dupdate'] 	= date('Y-m-d H:i:s');
        $postData['cupdate'] 	= $this->user->gNIP;

		$activities = $this->lib_sub_core->get_current_module_activities($this->modul_id, $postData[$this->main_table_pk]); 
        if ($postData['isdraft'] != true && count($activities) > 0){
        	$act = $activities[0];
        	$postData[$act['vFieldName']] 	= 1;
        	$postData[$act['dFieldName']] 	= date('Y-m-d H:i:s');
        	$postData[$act['cFieldName']] 	= $this->user->gNIP;
        	$postData[$act['tFieldName']] 	= '-';
        }
        
        return $postData;
    }    

    function after_insert_processor($fields, $id, $postData) { 

    }

    function after_update_processor($fields, $id, $postData) { 
		$activities = $this->lib_sub_core->get_current_module_activities($this->modul_id, $postData[$this->main_table_pk]); 
        if ($postData['isdraft'] != true && count($activities) > 0){
        	$act = $activities[0];
	        $this->lib_sub_core->InsertActivityModule($this->ViewUPB($id),$this->modul_id, $id, $act['iM_activity'], $act['iSort']);
            $this->sendNotif($id);
        }

    }
    function manipulate_insert_button($buttons){
		 $cNip= $this->user->gNIP;
		 $data['upload']='upload_custom_grid';
         $js = $this->load->view('js/standard_js',$data,TRUE);
        //$js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="'.$this->url.'_frame" id="'.$this->url.'_frame" height="0" width="0"></iframe>';
        
        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?draft=true&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',this,true )"  id="button_save_draft_'.$this->url.'"  class="ui-button-text icon-save" >Save as Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_save_submit_'.$this->url.'"  class="ui-button-text icon-save" >Save &amp; Submit</button>';

        $AuthModul = $this->lib_sub_core->getAuthorModul($this->modul_id);
        $arrTeam = explode(',',$this->team);
        $nipAuthor = explode(',', $AuthModul['vNip_author']);

        if( in_array($AuthModul['vDept_author'],$arrTeam )  || in_array($this->user->gNIP, $nipAuthor) || $this->isAdmin==TRUE  ){

            $buttons['save'] = $iframe.$save_draft.$js;
        }else{
            unset($buttons['save']);
            $buttons['save'] = '<span style="color:red;" title="'.$AuthModul['vDept_author'].'">You\'re Dept not Authorized</span>';
        }
        
        
        return $buttons;
    }

    function manipulate_update_button($buttons, $rowData) { 
        $peka 			= $rowData[$this->main_table_pk];
        $iupb_id 		= 0;

        //Load Javascript In Here 
        $cNip 			= $this->user->gNIP;
        $data['upload'] = 'upload_custom_grid';
        $js 			= $this->load->view('js/standard_js', $data, TRUE);
        $js 			.= $this->load->view('js/upload_js');

        $iframe 		= '<iframe name="v2_exp_skala_lab_kimiawi_frame" id="v2_exp_skala_lab_kimiawi_frame" height="0" width="0"></iframe>';
        
        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        } else { 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_sub_core->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\'v2_exp_skala_lab_kimiawi\', \' '.base_url().'processor/reformulasi/v2_exp_skala_lab_kimiawi?draft=true \',this,true )"  id="button_update_draft_v2_exp_skala_lab_kimiawi"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_sub_core->get_current_module_activities($this->modul_id,$peka);
                    $getLastStatusApprove = $this->lib_sub_core->getLastStatusApprove($this->modul_id,$peka); 

                    foreach ($activities as $act) {
                        $update_draft = '<button onclick="javascript:update_draft_btn(\'v2_exp_skala_lab_kimiawi\', \' '.base_url().'processor/reformulasi/v2_exp_skala_lab_kimiawi?draft=true&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].' \',this,true )"  id="button_update_draft_v2_exp_skala_lab_kimiawi"  class="ui-button-text icon-save" >Update as Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\'v2_exp_skala_lab_kimiawi\', \' '.base_url().'processor/reformulasi/v2_exp_skala_lab_kimiawi?company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,false )"  id="button_update_submit_v2_exp_skala_lab_kimiawi"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/reformulasi/v2_exp_skala_lab_kimiawi?action=approve&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v2_exp_skala_lab_kimiawi"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/reformulasi/v2_exp_skala_lab_kimiawi?action=reject&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_v2_exp_skala_lab_kimiawi"  class="ui-button-text icon-save" >Reject</button>';

                        $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/reformulasi/v2_exp_skala_lab_kimiawi?action=confirm&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v2_exp_skala_lab_kimiawi"  class="ui-button-text icon-save" >Confirm</button>';

                        
                        $iSort 		= $act['iSort'];
                        $check      = $this->canSubmitKimiawi($peka);

                        switch ($act['iType']) {
                            case '1':
                                # Update
                                $sButton .= $update;
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
                                $sButton .= $update;
                                break;
                        }
                        $arrNipAssign = explode(',',$act['vNip_assigned'] );
                        $arrTeam = explode(',',$this->team);

                        $arrTeamID = explode(',',$this->teamID);
                        $upbTeamID = $this->lib_sub_core->upbTeam($peka);

                        if(in_array($act['vDept_assigned'], $arrTeam ) || in_array($this->user->gNIP, $arrNipAssign)  ){
                            
                            /*// jika Dept id yang ditunjuk ada pada team id yang dimiliki
                            if(in_array($upbTeamID[$act['vDept_assigned']], $arrTeamID) || in_array($this->user->gNIP, $arrNipAssign) ){*/
                                //get manager from Team ID
                                $magrAndCief = $this->lib_sub_core->managerAndChief(20);

                                // jika activitynya approval keatas
                                if($act['iType'] > 1){
                                    // nip harus ada pada nip manager atau chief dari Dept, atau nip yang ditunjuk di table modul activity
                                    $arrmgrAndCief = explode(',', $magrAndCief);
                                    if(in_array($this->user->gNIP, $arrmgrAndCief) ||in_array($this->user->gNIP, $arrNipAssign)){
                                        
                                    }else{
                                        $sButton = '<span style="color:red;" title="'.print_r($arrmgrAndCief).'">You\'re not Authorized to Approve</span>';
                                    }
                                }

                            /*}else{
                                $sButton = '<span style="color:red;" arrTeamID="'.$this->teamID.'" title="'.$upbTeamID[$act['vDept_assigned']].'" >You\'re Team not Authorized </span>';
                            }*/


                            

                        }else{
                            $sButton = '<span style="color:red;" title="'.$act['vDept_assigned'].'">You\'re Dept not Authorized</span>';
                            
                        }
                    }
                }


                $buttons['update'] = $sButton;        
                
            

            
        }
        
        return $buttons;
    }

    

    function whoAmI($nip) { 
        $sql = 'select b.vDescription as vdepartemen,a.*,b.*,c.iLvlemp 
                        from hrd.employee a 
                        join hrd.msdepartement b on b.iDeptID=a.iDepartementID
                        join hrd.position c on c.iPostId=a.iPostID
                        where a.cNip ="'.$nip.'"
                        ';
        
        $data = $this->db->query($sql)->row_array();
        return $data;
    }

    function download($vFilename) { 
        $this->load->helper('download');        
        $name = $vFilename;
        $id = $_GET['id'];
        $tempat = $_GET['path'];    
        $path = file_get_contents('./files/reformulasi/'.$tempat.'/'.$id.'/'.$name);    
        force_download($name, $path);
    }

    private function canSubmitKimiawi ($id){
        $status     = false;
        $message    = '';

        $trial_submit   = $this->db->get_where('reformulasi.export_skala_lab', array('iexport_skala_lab' => $id))->row_array();
        if (!empty($trial_submit)){
            $submit_fisik = $trial_submit['isubmit_fisik'];
            if (intval($submit_fisik) == 0){
                $status     = false;
                $message    = 'Skala Trial - Uji Fisik Masih Belum Di Submit';
            } else {
                $filter_submit  = array(
                    'iexport_skala_lab'   => $id,
                    'isubmit_fisik'         => 1,
                    'isubmit_kimiawi'       => 0,
                    'ldeleted'              => 0
                );
                $formula_submit = $this->db->get_where('reformulasi.export_skala_lab_formula', $filter_submit)->num_rows();
                if ($formula_submit > 0){
                    $status     = false;
                    $message    = 'Masih Ada '.$formula_submit.' Yang Belum Di Submit Di Uji Kimiawi';
                } else {
                    $status     = true;
                    $message    = 'Berhasil';
                }
            }
        }
        return array('status' => $status, 'message' => $message);
    }

    //Output
    public function output(){
        $this->index($this->input->get('action'));
    }

    private function sendNotifKesimpulan ($id){
        $sqlPD          = "SELECT i.vnip, t.vnip AS manager FROM reformulasi.reformulasi_team t
                            JOIN reformulasi.reformulasi_team_item i ON t.ireformulasi_team = i.ireformulasi_team
                            WHERE t.vtipe = 'PD' AND t.ldeleted = 0 AND i.ldeleted = 0 AND t.iTipe = 2";
        $staffPD        = $this->db->query($sqlPD)->result_array();
        $arrPD          = array();
        foreach ($staffPD as $pd) {
            $staff      = $pd['vnip'];
            $manager    = $pd['manager'];

            if ( !in_array($staff, $arrPD) ){
                array_push($arrPD, $staff);
            }

            if ( !in_array($manager, $arrPD) ){
                array_push($arrPD, $manager);
            }
        }

        if (count($arrPD) > 0){
            $sql        = 'SELECT r.vno_export_req_refor, u.vUpd_no, u.vNama_usulan, s.ccreate
                            FROM reformulasi.export_skala_lab s 
                            JOIN reformulasi.export_req_refor r ON s.iexport_req_refor = r.iexport_req_refor
                            JOIN dossier.dossier_upd u ON r.idossier_upd_id = u.idossier_upd_id
                            WHERE s.iexport_skala_lab = ? ';
            $data       = $this->db->query($sql, array($id))->row_array();

            if (!empty($data)){
                $subject  = 'Skala Lab - Uji Kimiawi Need Process';

                $content  = '<p>Kepada Yth. Bapak / Ibu</p>';
                $content .= '<p>Diberitahukan kepada PD Export untuk melakukan Proses Skala Lab - Kesimpulan dengan rincian sebagai berikut : </p>';
                $content .= '<table>';
                $content .= '    <tr>';
                $content .= '       <td> Nomor Reformulasi </td>';
                $content .= '       <td> : </td>';
                $content .= '       <td> '.$data['vno_export_req_refor'].' </td>';
                $content .= '    </tr>';
                $content .= '    <tr>';
                $content .= '       <td> Nomor UPD </td>';
                $content .= '       <td> : </td>';
                $content .= '       <td> '.$data['vUpd_no'].' </td>';
                $content .= '    </tr>';
                $content .= '    <tr>';
                $content .= '       <td> Nama Produk </td>';
                $content .= '       <td> : </td>';
                $content .= '       <td> '.$data['vNama_usulan'].' </td>';
                $content .= '    </tr>'; 
                $content .= '    <tr>';
                $content .= '       <td> Link Aplikasi </td>';
                $content .= '       <td> : </td>';
                $content .= '       <td> http://www.npl-net.com/erp </td>';
                $content .= '    </tr>';
                $content .= '</table>';
                $content .= '<p>Terima Kasih</p>';

                $to       = '';
                $cc       = $data['ccreate'];
                foreach ($arrPD as $pd) {
                    $to   = ( $to == '' ) ? $pd : $to.','.$pd;
                }

                $this->sess_auth->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
            }

        }
    }

    private function sendNotif ($id){
        $adManager      = $this->db->get_where('reformulasi.reformulasi_team', array('vtipe' => 'AD', 'iTipe' => 2, 'ldeleted' => 0))->result_array();
        if (count($adManager) > 0){
            $sql        = 'SELECT r.vno_export_req_refor, u.vUpd_no, u.vNama_usulan, s.ccreate
                            FROM reformulasi.export_skala_lab s 
                            JOIN reformulasi.export_req_refor r ON s.iexport_req_refor = r.iexport_req_refor
                            JOIN dossier.dossier_upd u ON r.idossier_upd_id = u.idossier_upd_id
                            WHERE s.iexport_skala_lab = ? ';
            $data       = $this->db->query($sql, array($id))->row_array();

            if (!empty($data)){
                $subject  = 'Skala Lab - Uji Kimiawi Need Approval';

                $content  = '<p>Kepada Yth. Bapak / Ibu</p>';
                $content .= '<p>Diberitahukan kepada AD Export Manager untuk melakukan Approval pada Modul Skala Lab - Uji Kimiawi dengan rincian sebagai berikut : </p>';
                $content .= '<table>';
                $content .= '    <tr>';
                $content .= '       <td> Nomor Reformulasi </td>';
                $content .= '       <td> : </td>';
                $content .= '       <td> '.$data['vno_export_req_refor'].' </td>';
                $content .= '    </tr>';
                $content .= '    <tr>';
                $content .= '       <td> Nomor UPD </td>';
                $content .= '       <td> : </td>';
                $content .= '       <td> '.$data['vUpd_no'].' </td>';
                $content .= '    </tr>';
                $content .= '    <tr>';
                $content .= '       <td> Nama Produk </td>';
                $content .= '       <td> : </td>';
                $content .= '       <td> '.$data['vNama_usulan'].' </td>';
                $content .= '    </tr>'; 
                $content .= '    <tr>';
                $content .= '       <td> Link Aplikasi </td>';
                $content .= '       <td> : </td>';
                $content .= '       <td> http://www.npl-net.com/erp </td>';
                $content .= '    </tr>';
                $content .= '</table>';
                $content .= '<p>Terima Kasih</p>';

                $to       = '';
                $cc       = $data['ccreate'];
                foreach ($adManager as $ad) {
                    $to   = ( $to == '' ) ? $ad['vnip'] : $to.','.$ad['vnip'];
                }

                $this->sess_auth->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
            }

        }
    }

    private function ViewUPB ($id=0){
        $upb = $this->db->get_where($this->main_table, array($this->main_table_pk=>$id, 'lDeleted'=>0))->result_array();
        $arrUPB = array();
        foreach ($upb as $u) {
            if (isset($u['iupb_id'])){
                array_push($arrUPB, $u['iupb_id']);
            }
        }
        return $arrUPB;
    }

    private function filterUPBByTeam($tableAlias = 'brosur_upb'){
        $filter = '';
        if($this->isAdmin){

        } else {
            $arrTeam = explode(',',$this->team);
            $AuthModul = $this->lib_sub_core->getAuthorModul($this->modul_id);
            $nipAuthor = explode(',', $AuthModul['vNip_author']);
            $nipParticipant = explode(',', $AuthModul['vNip_author']);

            if(in_array('PD', $arrTeam)){     
                $filter = ' AND '.$tableAlias.'.iteampd_id IN ('.$this->teamID.')';        
            }else if(in_array('AD', $arrTeam)){    
                $filter = ' AND '.$tableAlias.'.iteamad_id IN ('.$this->teamID.')';                        
            }else if(in_array('QA', $arrTeam)){    
                $filter = ' AND '.$tableAlias.'.iteamqa_id IN ('.$this->teamID.')';                        
            }else if(in_array('BD', $arrTeam)){    
                $filter = ' AND '.$tableAlias.'.iteambusdev_id IN ('.$this->teamID.')';                         
            }else if( in_array($this->user->gNIP, $nipAuthor )|| in_array($this->user->gNIP, $nipParticipant)  ){

            }
            
        } 
        return $filter;
    }

}
