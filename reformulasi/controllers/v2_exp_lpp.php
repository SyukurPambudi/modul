<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v2_exp_lpp extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
        $this->load->library('lib_sub_core');
        $this->load->library('lib_refor');

        $this->db 			    = $this->load->database('formulasi',false, true);
        $this->db_reformulasi0  = $this->load->database('formulasi',false, true);
        
        $this->user 		    = $this->auth->user();


        $this->modul_id 	= $this->input->get('modul_id');
        $this->iModul_id 	= $this->lib_sub_core->getIModulID($this->input->get('modul_id'));


        $this->team 		= $this->lib_refor->hasTeam($this->user->gNIP);
        $this->teamID 		= $this->lib_refor->hasTeamID($this->user->gNIP);
        $this->isAdmin 		= $this->lib_refor->isAdmin($this->user->gNIP);

		$this->title 		= 'LPP';
		$this->url 			= 'v2_exp_lpp';
		$this->urlpath 		= 'reformulasi/'.str_replace("_","/", $this->url);


		$this->maintable 	= 'reformulasi.export_refor_lpp';	
		$this->main_table 	= $this->maintable;	
		$this->main_table_pk= 'iexport_refor_lpp';	
		
		$datagrid['islist'] = array(
            'export_req_refor.vno_export_req_refor'  => array('label' => 'No Req Formula','width' => 100,	'align' => 'center', 'search' => true),
            'dmulai_lpp'	=> array('label' => 'Tgl Mulai Pembuatan LPP','width' => 120,	'align' => 'center', 'search' => true),
            'dselesai_lpp' => array('label' => 'Tgl Selesai Pembuatan LPP',	'width' => 120,	'align' => 'center', 'search' => true),
			'cpicpd_lpp' => array('label' => 'PIC PD','width' => 110,	'align' => 'center', 'search' => true),
			'employee.vName' => array('label' => 'Nama PIC','width' => 200,	'align' => 'left', 'search' => false),			
			'iSubmit'=> array('label' => 'Status Submit','width' => 150,	'align' => 'left',   'search' => false),
			'iaprove' => array('label' => 'Approval','width' => 110,	'align' => 'center', 'search' => false),
		);		

		$datagrid['setQuery']=array(
			0 => array('vall' => 'export_refor_lpp.lDeleted', 'nilai' => 0),
			
		);

		$datagrid['jointableinner'] = array(
			0 => array( 'reformulasi.export_req_refor' => 'export_refor_lpp.iexport_req_refor = export_req_refor.iexport_req_refor '),
			1 => array('hrd.employee' => 'employee.cNip = export_refor_lpp.cpicpd_lpp'),
			2 => array('dossier.dossier_upd' => 'dossier_upd.idossier_upd_id = export_req_refor.idossier_upd_id'),

		);

		$datagrid['shortBy']=array("export_refor_lpp.iexport_refor_lpp" => "DESC");
		
		$this->datagrid=$datagrid;


    }



    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle($this->title);		
		$grid->setTable($this->maintable );
		$grid->setUrl($this->url);

      /*  $grid->changeSearch('dPermintaan_req_export','between');*/
		/*$grid->changeSearch('cpicpd_lpp','combobox');*/

        $grid->changeFieldType('iSubmit', 'combobox','',array(''=>'--select--',0=>'Draft - Need to be Submit', 1=>'Submited'));
		$grid->changeFieldType('iaprove', 'combobox','',array(''=>'--select--',0=>'Waiting for approval',1=>'Rejected', 2=>'Approved'));

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

        }
        
        /* validasi maingrid  */

        /* 
            1. hanya Team Andev dan IR  yang bisa akses ( ini dari privilege ) 
            2. Hanya inisator yang bisa edit requestnya
        
        */
        
		

		$grid->setGridView('grid');

		switch ($action) {
			case 'json':
				$grid->getJsonData();
                break;
            case 'uploadFile':
		
                $lastId=$this->input->get('lastId');
				$dataFieldUpload=$this->lib_sub_core->getUploadFileFromField($this->input->get('modul_id'));//print_r($this->input->get());exit();
				if(count($dataFieldUpload)>0){
					foreach ($dataFieldUpload as $kf => $vUpload) {
                        $pathf=$vUpload['filepath'];
                        // Cek Path Sub Folder
                        $patharr=explode("/",$pathf);
                        $ii=0;
                        foreach ($patharr as $kpp => $vpp) {
                            $sasa=array();
                            if($ii <> 0){
                                for ($i=0; $i <= $ii; $i++) {
                                    if($i<>0){
                                        $sasa[]=$patharr[$i];
                                    } 
                                }
                                $papat = implode("/",$sasa);
                                $path = realpath("files");
                                if(!file_exists($path."/".$papat)){
                                    if (!mkdir($path."/".$papat, 0777, true)) { 
                                        die('Failed upload, try again!'.$papat);
                                    }
                                }

                           }
                           $ii++;
                        }
                        $path   = realpath($pathf);

                        if(!file_exists($path."/".$lastId)){
                            if (!mkdir($path."/".$lastId, 0777, true)) {
                                die('Failed upload, try again!----'.$path);
                            }
                        }

						
                        $fKeterangan = array();
                        foreach($_POST as $key=>$value) {                       
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
										$datainsert['idHeader_File']=$lastId;
										$datainsert['iM_modul_fields']=$vUpload['iM_modul_fields'];
										$datainsert['dCreate']= date('Y-m-d H:i:s');
										$datainsert['cCreate']= $this->user->gNIP;
										$datainsert['vFilename']= $name;
										$datainsert['vFilename_generate']= $name_generate;
                                        $datainsert['tKeterangan']= $fKeterangan[$i];
                                        $sql1='select * from erp_privi.m_modul mo 
                                            join erp_privi.m_application ap on mo.iM_application=ap.iM_application
                                            where mo.lDeleted=0 and ap.lDeleted=0 and mo.idprivi_modules='.$this->input->get('modul_id');
                                        $row2=$this->db_reformulasi0->query($sql1)->row_array();		
										$this->db_reformulasi0->insert($row2['vTable_file'],$datainsert);
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
                $dataFieldUpload=$this->lib_sub_core->getUploadFileFromField($this->input->get('modul_id'));
                // Get upload file
                $sql1='select * from erp_privi.m_modul mo 
                    join erp_privi.m_application ap on mo.iM_application=ap.iM_application
                    where mo.lDeleted=0 and ap.lDeleted=0 and mo.idprivi_modules='.$this->input->get('modul_id');
                $row2=$this->db_reformulasi0->query($sql1)->row_array();	

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
                            $this->db_reformulasi0->where('idHeader_File',$lastId)
                                            ->where_not_in('iFile',$validdetails)
                                            ->where('iM_modul_fields',$vUpload['iM_modul_fields'])
                                            ->update($row2['vTable_file'],$dataupdate);
                        }else{
                            $this->db_reformulasi0->where('idHeader_File',$lastId)
                                            ->where('iM_modul_fields',$vUpload['iM_modul_fields'])
                                            ->update($row2['vTable_file'],$dataupdate);
                        }

                        // Delete File
                        $where  = array('iDeleted'=>1,'idHeader_File'=>$lastId,'iM_modul_fields'=>$vUpload['iM_modul_fields']);
                        $this->db_reformulasi0->where($where);
                        $qq     = $this->db_reformulasi0->get($row2['vTable_file']);

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

                echo $grid->updated_form();
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
				$name = $_GET['file'];
				$id = $_GET['id'];
				$path = $_GET['path'];

				$this->db_reformulasi0->select("*")
    				->from("erp_privi.sys_masterdok")
    				->where("filename",$path);
    			$row=$this->db_reformulasi0->get()->row_array();

    			if(count($row)>0 && isset($row["filepath"])){
    				$path = file_get_contents('./'.$row['filepath'].'/'.$id.'/'.$name);	
					force_download($name, $path);
    			}else{
    				echo "File Not Found - 0x01";
    			}

				
				break;

            case 'uploadFile':
                /* print_r($_POST);
                exit; */
				$lastId=$this->input->get('lastId');
				$dataFieldUpload=$this->lib_sub_core->getUploadFileFromField($this->input->get('modul_id'));
				if(count($dataFieldUpload)>0){
					foreach ($dataFieldUpload as $kf => $vUpload) {
                        //print_r($vUpload);
						$pathf=$vUpload['filepath'];
						$path = realpath($pathf);
						if(!file_exists($path."/".$lastId)){
							if (!mkdir($path."/".$lastId, 0777, true)) { //id review
								die('Failed upload, try again!');
							}
						}

						$fKeterangan = array();
						foreach($_POST as $key=>$value) {						
							if ($key == 'erp_privi_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['iM_modul_fields'].'_fileketerangan') {
								foreach($value as $k=>$v) {
									$fKeterangan[$k] = $v;
								}
							}
						}
						$i=0;
						foreach ($_FILES['erp_privi_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['iM_modul_fields'].'_upload_file']["error"] as $key => $error) {
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['erp_privi_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['iM_modul_fields'].'_upload_file']["tmp_name"][$key];
								$name =$_FILES['erp_privi_'.$this->url.'_'.$vUpload['vNama_field']."_".$vUpload['iM_modul_fields'].'_upload_file']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								$filenameori=$name;
								$now_u = date('Y_m_d__H_i_s');
                                $name_generate = $i.'__'.$now_u.'__'.$name;
                                
                                $datatb=explode(".", $vUpload['filetable']);
								$sql = "SELECT c.`COLUMN_NAME`,c.`COLUMN_KEY` , c.`COLUMN_TYPE`, c.`DATA_TYPE`, c.`CHARACTER_MAXIMUM_LENGTH` 
										FROM `information_schema`.`COLUMNS` c
										WHERE c.`TABLE_SCHEMA` = '".$datatb[0]."' AND c.`TABLE_NAME`='".$datatb[1]."'";

								$qq=$this->db_reformulasi0->query($sql);

								if($qq->num_rows()>0){
									$namafield=array();
									foreach ( $qq->result_array() as $kky => $vvy) {
										$namafield[$vvy['COLUMN_NAME']]=1;
									}

									if(isset($namafield['vFilename_generate'])){

									}else{
										$sqlinsert="ALTER TABLE `".$datatb[1]."`
											ADD COLUMN `vFilename_generate` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Nama Generate Upload File' AFTER ".$vUpload['ffilename'];
										$this->db_reformulasi0->query($sqlinsert);
									}


								}else{
									echo "Table File Not Found";
									exit();
                                }
                                
									if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name_generate)) {
										$datainsert=array();
										$datainsert[$vUpload['fieldheader']]=$lastId;
										$datainsert[$vUpload['fdcreate']]= date('Y-m-d H:i:s');
										$datainsert[$vUpload['fccreate']]= $this->user->gNIP;
										$datainsert[$vUpload['ffilename']]= $name;
										$datainsert['vFilename_generate']= $name_generate;
										$datainsert[$vUpload['fvketerangan']]= $fKeterangan[$i];
										$this->db_reformulasi0->insert($vUpload['filetable'],$datainsert);
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
    	$post=$this->input->post();
        $get=$this->input->get();
        $data['html']="";
        $dFields = $this->lib_sub_core->getFields($this->iModul_id);      
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

                $hate_emel .= $this->lib_sub_core->getHistoryActivity($this->modul_id,$aidi,true);

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

                $controller 					= $this->url;
                $folderpath 					= str_replace(str_replace('_', '/', $this->url), '', $this->urlpath); 
                $data_field['id'] 				= $controller.'_'.$form_field['vNama_field'];
                //$data_field['field']= $controller.'_'.$form_field['vNama_field'] ;
                $data_field['field']= $form_field['vNama_field'] ;

                $data_field['act']= $get['act'] ;
                $data_field['hasTeam']= $this->team ;
                $data_field['hasTeamID']= $this->teamID ;
                $data_field['isAdmin']= $this->isAdmin ;
                $data_field['urlpath'] 			= $this->urlpath;
                $data_field['folderpath'] 		= $folderpath;

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
                    /* echo '<pre>'.$sqlGetMainvalue;
                    exit; */
                    $dataHead = $this->db->query($sqlGetMainvalue)->row_array();

                    $data_field['dataHead']= $dataHead;
                    $data_field['main_table_pk']= $this->main_table_pk;
                    
                    if($form_field['iM_jenis_field'] == 6){
                        $data_field['vSource_input']= $form_field['vSource_input_edit'] ;
                    }else{
                        $data_field['vSource_input']= $form_field['vSource_input'] ;
                    }
                    $return_field = $this->load->view('v3_form_detail_update',$data_field,true);   
                }else{
                    $data_field['vSource_input']= $form_field['vSource_input'] ;
                    $return_field = $this->load->view('v3_form_detail',$data_field,true);    
                    /*$return_field = $this->load->view('v3_form_detail',$data_field,true);*/    
                    
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
        // print_r($hate_emel);exit();
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

    	$this->db_reformulasi0->select("*")
    				->from("erp_privi.sys_masterdok")
    				->where("filename",$namefield);
    	$row=$this->db_reformulasi0->get()->row_array();
		
		$where=array('lDeleted'=>0,$row["fieldheader"]=>$post["id"]);
		$this->db_reformulasi0->where($where);
		$q=$this->db_reformulasi0->get($row["filetable"]);
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
			$linknya=$linknya.'<a class="ui-button-text" href="javascript:;" onclick="javascript:hapus_row_'.$nmTable.'('.$i.')">[Hapus]</a><input type="hidden" class="num_rows_'.$nmTable.'" value="'.$i.'" /><input type="hidden" name="filereformulasi_'.$row["fielddetail"].'[]" value="'.$k->{$row["fielddetail"]}.'" />';


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


        function listBox_v2_exp_lpp_iapppr($value) {
            if($value==0){$vstatus='Waiting for approval';}
            elseif($value==1){$vstatus='Rejected';}
            elseif($value==2){$vstatus='Approved';}
            return $vstatus;
        }

        function listBox_Action($row, $actions) {
            
            /* Validasi Action */        
            /* 1. row hanya bisa diedit oleh inisiator */

            $peka = $row->iexport_refor_lpp;
            $getLastactivity = $this->lib_sub_core->getLastactivity($this->modul_id,$peka);
            $isOpenEditing = $this->lib_sub_core->getOpenEditing($this->modul_id,$peka);

             if ( $getLastactivity == 0 ) { 
                    
            }else{
                if($isOpenEditing){

                }else{
                    unset($actions['edit']);    
                }
                
            }

          /*  if (count($currentActivity) > 0){
            	if ($currentActivity[0]['iSort'] == 3 && $row['iuji_mikro'] == 0){
                    unset($actions['edit']); 
            	}
            }*/

/*aslinya*/
   /*         if ( $getLastactivity == 0 ) { 
                if($row->cInisiator_export==$this->user->gNIP){
                        
                }else{
                    unset($actions['edit']);    
                }
            }else{
                if($isOpenEditing){
                    if($row->cInisiator_export==$this->user->gNIP){
                        
                    }else{
                        unset($actions['edit']);    
                    }

                }else{
                    unset($actions['edit']);    
                }
                
            }*/

            return $actions;
        }


        function insertBox_v2_exp_lpp_form_detail($field,$id){
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

        function updateBox_v2_exp_lpp_form_detail($field,$id,$value,$rowData){
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
                                        var url = "'.base_url().'processor/reformulasi/v2_exp_lpp";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v2_exp_lpp").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v2_exp_lpp");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Approve</h1><br />';
                $echo .= '<form id="form_v2_exp_lpp_approve" action="'.base_url().'processor/reformulasi/v2_exp_lpp?action=approve_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v2_exp_lpp_approve\')">Approve</button>';
                    
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
    
                $data['status']  = true;
                $data['last_id'] = $post[$this->main_table_pk];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }

            function approve_processxx() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName; 
                $pk = $post[$this->main_table_pk];
                $vRemark = $post['vRemark'];
                $modul_id = $post['modul_id'];
                $iM_modul_activity = $post['iM_modul_activity'];
                $lvl = $post['lvl'];

                $activity = $this->db->get_where('erp_privi.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

                $field = $activity['vFieldName'];
                $update = array($field => 2);
                $this->db->where($this->main_table_pk, $pk);
                $this->db->update($this->_table, $update);

                $this->lib_sub_core->InsertActivityModule($this->ViewUPB($pk),$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,2);

                $getLastactivity = $this->lib_sub_core->getLastactivity($modul_id,$pk);
                /*if ($getLastactivity != 0){
                    $data = $this->db->get_where($this->_table, array($this->main_table_pk => $pk, 'lDeleted' => 0))->row_array();
                    $revisi = (count($data) > 0)?intval($data['irevisi']):0;
                    if ($revisi > 0){
                        $soi['iupb_id'] = $data['iupb_id'];
                        $soi['vrevisi'] = $revisi;
                        $soi['irevisi'] = $revisi;
                        $soi['ineed_revisi'] = 0;
                        $soi['itype'] = 1;
                        $soi['vkode_surat'] = $data['vNoDraft'].' -- After Revisi Draft';
                        $this->db->insert('reformulasi.reformulasi_upb_soi_bahanbaku', $soi);
                    }
                }
    */
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
                                        var url = "'.base_url().'processor/reformulasi/v2_exp_lpp";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v2_exp_lpp").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v2_exp_lpp");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Confirm</h1><br />';
                $echo .= '<form id="form_v2_exp_lpp_confirm" action="'.base_url().'processor/reformulasi/v2_exp_lpp?action=confirm_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v2_exp_lpp_confirm\')">Confirm</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            } 
    
            function confirm_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $pk = $post[$this->main_table_pk];
                $vRemark = $post['vRemark'];
                $lvl = $post['lvl'];
                $modul_id = $post['modul_id'];
                $iM_modul_activity = $post['iM_modul_activity'];

                $activity = $this->db->get_where('erp_privi.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

                $field = $activity['vFieldName'];
                $update = array($field => 2);
                $this->db->where($this->main_table_pk, $pk);
                $this->db->update('reformulasi.'.$this->main_table, $update);

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
                                var remark = $("#v2_exp_lpp_remark").val();
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
                                        var url = "'.base_url().'processor/reformulasi/v2_exp_lpp";                             
                                        if(o.status == true) { 
                                            $("#alert_dialog_form").dialog("close");
                                                 $.get(url+"?action=update&id="+last_id+"&foreign_key=0&company_id=3&group_id="+group_id+"&modul_id="+modul_id, function(data) {
                                                 $("div#form_v2_exp_lpp").html(data);
                                                 
                                            });
                                            
                                        }
                                            reload_grid("grid_v2_exp_lpp");
                                    }
                                    
                                 })
                             }
                         </script>';
                $echo .= '<h1>Reject</h1><br />';
                $echo .= '<form id="form_v2_exp_lpp_reject" action="'.base_url().'processor/reformulasi/v2_exp_lpp?action=reject_process" method="post">';
                $echo .= '<div style="vertical-align: top;">';
                $echo .= 'Remark : 
                        <input type="hidden" name="'.$this->main_table_pk.'" value="'.$this->input->get($this->main_table_pk).'" />
                        <input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                        <input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
                        <input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
                        <input type="hidden" name="iM_modul_activity" value="'.$this->input->get('iM_modul_activity').'" />
                        
                        <textarea name="vRemark" id="reject_v2_exp_lpp_remark"></textarea>
                <button type="button" onclick="submit_ajax(\'form_v2_exp_lpp_reject\')">Reject</button>';
                    
                $echo .= '</div>';
                $echo .= '</form>';
                return $echo;
            }
            
            function reject_process() {
                $post = $this->input->post();
                $cNip= $this->user->gNIP;
                $vName= $this->user->gName;
                $pk = $post[$this->main_table_pk];
                $vRemark = $post['vRemark'];
                $lvl = $post['lvl'];
                $modul_id = $post['modul_id'];
                $iM_modul_activity = $post['iM_modul_activity'];

                $activity = $this->db->get_where('erp_privi.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

                /* kembali ke draft jika reject */
                $update['iSubmit'] 	= 0;                
                $this->db->where($this->main_table_pk, $pk);
                $this->db->update($this->maintable, $update);

                $this->lib_sub_core->InsertActivityModule($this->ViewUPB($pk),$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],$vRemark,1);
                 
                /* reset log ke draft lagi*/
                 $getApp = $this->getApptableLog($modul_id);
                 $applogTable = $getApp ['vTable_log_activity'];
         
                 $tUpdated = date('Y-m-d H:i:s', mktime());
                 $SQL = "UPDATE erp_privi.".$applogTable." set lDeleted=1,dupdate='{$tUpdated}',cUpdate='{$cNip}' where iKey_id = '{$pk}' and idprivi_modules = '{$modul_id}' ";
                 $this->db->query($SQL);
                 /* reset log ke draft lagi*/


    
                $data['status']  = true;
                $data['last_id'] = $post[$this->main_table_pk];
                $data['group_id'] = $post['group_id'];
                $data['modul_id'] = $post['modul_id'];
                return json_encode($data);
            }

            function getApptableLog($modul_id){
                $sql='select * 
                        from erp_privi.m_application a
                        join erp_privi.m_modul b on b.iM_application=a.iM_application
                        where b.idprivi_modules = "'.$modul_id.'"  
                        limit 1';
        
                $data = $this->db->query($sql)->row_array();
                
                return $data;
            }



    //Standart Setiap table harus memiliki dCreate , cCreated, dupdate, cUpdate
    function before_insert_processor($row, $postData) {
        $postData['dCreate'] = date('Y-m-d H:i:s');
        $postData['cCreated'] = $this->user->gNIP;
        $postData['lDeleted'] = 0;

		if($postData['isdraft']==true){
        	$postData['iSubmit']=0;
        }
        else{
            $postData['iSubmit']=1;
        }


        return $postData;
    }

    function before_update_processor($row, $postData) {
        $postData['dupdate'] = date('Y-m-d H:i:s');
        $postData['cUpdate'] = $this->user->gNIP;

        if($postData['isdraft']==true){
        	$postData['iSubmit']=0;
        }
        else{
            $postData['iSubmit']=1;
        }

        return $postData;
    }    

    function after_insert_processor($fields, $id, $postData) { 
        $post = $this->input->post();

        if ($postData['iSubmit'] == 1){
            $activities = $this->lib_sub_core->get_current_module_activities($this->modul_id, $postData[$this->main_table_pk]); 
            if ($postData['isdraft'] != true && count($activities) > 0){
                $act = $activities[0];
                $this->lib_sub_core->InsertActivityModule($this->ViewUPB($id),$this->modul_id, $id, $act['iM_activity'], $act['iSort']);
            }

            $sql = "SELECT e.`vName`, e.`cUpper`, d.`vUpd_no`, r.`vno_export_req_refor`,  d.`vNama_usulan` 
                FROM reformulasi.`export_req_refor` r
                JOIN hrd.`employee` e ON e.`cNip` = r.`cInisiator_export`
                JOIN dossier.`dossier_upd` d ON d.`idossier_upd_id` = r.`idossier_upd_id` 
                WHERE r.`lDeleted` = 0 AND d.`lDeleted` = 0 AND r.`iexport_req_refor` = ".$id; 
            $mailDet = $this->db->query($sql)->row_array();  

            $sqlM = "SELECT r.`vnip` 
                    FROM `reformulasi`.`reformulasi_team` r
                    JOIN `reformulasi`.`export_req_refor` e ON e.`iTeamPD` = r.`ireformulasi_team`
                    WHERE e.`iexport_req_refor` =  '".$postData['iexport_req_refor']."' 
                    LIMIT 1";
            $tomail = $this->db->query($sqlM)->row_array();
            $to = $tomail['vnip'];


            
            $cc = $this->user->gNIP;
            $subject="Submited Laporan Pengembangan Produk: No Request ".$mailDet['vno_export_req_refor']; 
            $content="
            Diberitahukan bahwa telah ada Submited Laporan Pengembangan Produk, 
                dengan rincian sebagai berikut :<br><br>  
                <table border='0' style='width: 600px;'>
                    <tr>
                            <td style='width: 110px;'><b>No Request </b></td><td style='width: 20px;'> : </td>
                            <td>".$mailDet['vno_export_req_refor']."</td>
                    </tr>
                    <tr>
                            <td><b>No UPD  </b></td><td> : </td>
                            <td>".$mailDet['vUpd_no']."</td> 
                    </tr>  
                    <tr>
                            <td><b>Nama Produk  </b></td><td> : </td> 
                            <td>".$mailDet['vNama_usulan']."</td>
                    </tr>  
                    <tr>
                            <td><b>Nama Inisiator  </b></td><td> : </td> 
                            <td>".$mailDet['vName']."</td>
                    </tr>  
                </table>  
            <br/> <br/>
            Demikian, mohon segera follow up  pada aplikasi ERP Reformulasi. Terimakasih.<br><br><br>
            Post Master"; 
            $this->sess_auth->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);



        }
        
    }

    function after_update_processor($fields, $id, $postData) {
        $post = $this->input->post();

        if($postData['iSubmit']==1){
            $activities = $this->lib_sub_core->get_current_module_activities($this->modul_id, $postData[$this->main_table_pk]); 
            if ($postData['isdraft'] != true && count($activities) > 0){
                $act = $activities[0];
                $this->lib_sub_core->InsertActivityModule($this->ViewUPB($id),$this->modul_id, $id, $act['iM_activity'], $act['iSort']);
            }

            $sql = "SELECT e.`vName`, e.`cUpper`, d.`vUpd_no`, r.`vno_export_req_refor`,  d.`vNama_usulan` 
                FROM reformulasi.`export_req_refor` r
                JOIN hrd.`employee` e ON e.`cNip` = r.`cInisiator_export`
                JOIN dossier.`dossier_upd` d ON d.`idossier_upd_id` = r.`idossier_upd_id` 
                WHERE r.`lDeleted` = 0 AND d.`lDeleted` = 0 AND r.`iexport_req_refor` = ".$id; 
            $mailDet = $this->db->query($sql)->row_array();  

            $sqlM = "SELECT r.`vnip` 
                    FROM `reformulasi`.`reformulasi_team` r
                    JOIN `reformulasi`.`export_req_refor` e ON e.`iTeamPD` = r.`ireformulasi_team`
                    WHERE e.`iexport_req_refor` =  '".$postData['iexport_req_refor']."' 
                    LIMIT 1";
            $tomail = $this->db->query($sqlM)->row_array();
            $to = $tomail['vnip'];


            
            $cc = $this->user->gNIP;
            $subject="Submited Laporan Pengembangan Produk: No Request ".$mailDet['vno_export_req_refor']; 
            $content="
            Diberitahukan bahwa telah ada Submited Laporan Pengembangan Produk, 
                dengan rincian sebagai berikut :<br><br>  
                <table border='0' style='width: 600px;'>
                    <tr>
                            <td style='width: 110px;'><b>No Request </b></td><td style='width: 20px;'> : </td>
                            <td>".$mailDet['vno_export_req_refor']."</td>
                    </tr>
                    <tr>
                            <td><b>No UPD  </b></td><td> : </td>
                            <td>".$mailDet['vUpd_no']."</td> 
                    </tr>  
                    <tr>
                            <td><b>Nama Produk  </b></td><td> : </td> 
                            <td>".$mailDet['vNama_usulan']."</td>
                    </tr>  
                    <tr>
                            <td><b>Nama Inisiator  </b></td><td> : </td> 
                            <td>".$mailDet['vName']."</td>
                    </tr>  
                </table>  
            <br/> <br/>
            Demikian, mohon segera follow up  pada aplikasi ERP Reformulasi. Terimakasih.<br><br><br>
            Post Master"; 
            $this->sess_auth->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);

    	}

    }
    function manipulate_insert_buttond($buttons){
		unset($buttons['save']);
        $js = $this->load->view('export/js/export_studi_literatur_pd_js');
        $save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'export_studi_literatur_pd\', \''.base_url().'processor/reformulasi/export/studi/literatur/pd?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_export_studi_literatur_pd_js">Save as Draft</button>';
        $save = '<button onclick="javascript:save_btn_multiupload(\'export_studi_literatur_pd\', \''.base_url().'processor/reformulasi/export/studi/literatur/pd?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_export_studi_literatur_pd_js">Save &amp Submit</button>';

        $buttons['save'] = $save_draft.$save.$js;

        return $buttons;
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

            $buttons['save'] = $iframe.$save_draft.$save.$js;
        }else{
            unset($buttons['save']);
            $buttons['save'] = '<span style="color:red;" title="'.$AuthModul['vDept_author'].'">You\'re Dept not Authorized</span>';
        }
        
        
        return $buttons;
    }
    
   

    function manipulate_update_button($buttons, $rowData) { 
        $peka=$rowData[$this->main_table_pk];
        $iupb_id = 0;

        //Load Javascript In Here 
        $cNip= $this->user->gNIP;
        $data['upload'] = 'upload_custom_grid';
        $js = $this->load->view('js/standard_js', $data, TRUE);
        $js .= $this->load->view('js/upload_js');

        $iframe = '<iframe name="v2_exp_lpp" id="v2_exp_lpp" height="0" width="0"></iframe>';
        
        if ($this->input->get('action') == 'view') {
            unset($buttons['update']);
        }
        else{ 
            
                $sButton = $iframe.$js;

                $isOpenEditing = $this->lib_sub_core->getOpenEditing($this->modul_id,$peka);

                if($isOpenEditing){
                    $update_draft = '<button onclick="javascript:update_draft_btn(\'v2_exp_lpp\', \' '.base_url().'processor/reformulasi/v2_exp_lpp?draft=true \',this,true )"  id="button_update_draft_v2_exp_lpp"  class="ui-button-text icon-save" >Update open Editing</button>';
                    $sButton .= $update_draft;
                }else{


                    $activities = $this->lib_sub_core->get_current_module_activities($this->modul_id,$peka);
                    $getLastStatusApprove = $this->lib_sub_core->getLastStatusApprove($this->modul_id,$peka); 

                    foreach ($activities as $act) {
                        $update_draft = '<button onclick="javascript:update_draft_btn(\'v2_exp_lpp\', \' '.base_url().'processor/reformulasi/v2_exp_lpp?draft=true&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].' \',this,true )"  id="button_update_draft_v2_exp_lpp"  class="ui-button-text icon-save" >Update as Draft</button>';
                        $update = '<button onclick="javascript:update_btn_back(\'v2_exp_lpp\', \' '.base_url().'processor/reformulasi/v2_exp_lpp?company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&iM_modul_activity='.$act['iM_modul_activity'].'&group_id='.$this->input->get('group_id').'modul_id='.$this->input->get('modul_id').' \',this,false )"  id="button_update_submit_v2_exp_lpp"  class="ui-button-text icon-save" >Update &amp; Submit</button>';

                        $approve = '<button onclick="javascript:load_popup(\' '.base_url().'processor/reformulasi/v2_exp_lpp?action=approve&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v2_exp_lpp"  class="ui-button-text icon-save" >Approve</button>';
                        $reject = '<button onclick="javascript:load_popup(\' '.base_url().'processor/reformulasi/v2_exp_lpp?action=reject&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \' )"  id="button_reject_v2_exp_lpp"  class="ui-button-text icon-save" >Reject</button>';

                        $confirm = '<button onclick="javascript:load_popup(\' '.base_url().'processor/reformulasi/v2_exp_lpp?action=confirm&iM_modul_activity='.$act['iM_modul_activity'].'&iM_activity='.$act['iM_activity'].'&'.$this->main_table_pk.'='.$peka.'&iupb_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \')"  id="button_approve_v2_exp_lpp"  class="ui-button-text icon-save" >Confirm</button>';

                        

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
                        $arrTeam = explode(',',$this->team);

                        $arrTeamID = explode(',',$this->teamID);
                        $upbTeamID = $this->lib_refor->upbTeam($peka);

                        if(in_array($act['vDept_assigned'], $arrTeam ) || in_array($this->user->gNIP, $arrNipAssign)  ){
                            
                            /*// jika Dept id yang ditunjuk ada pada team id yang dimiliki
                            if(in_array($upbTeamID[$act['vDept_assigned']], $arrTeamID) || in_array($this->user->gNIP, $arrNipAssign) ){*/
                                //get manager from Team ID
                                $magrAndCief = $this->lib_refor->managerAndChief($upbTeamID[$act['vDept_assigned']]);

                                // jika activitynya approval keatas
                                if($act['iType'] > 1){
                                    // nip harus ada pada nip manager atau chief dari Dept, atau nip yang ditunjuk di table modul activity
                                    $arrmgrAndCief = explode(',', $magrAndCief);
                                    if(in_array($this->user->gNIP, $arrmgrAndCief) ||in_array($this->user->gNIP, $arrNipAssign)){
                                        
                                    }else{
                                        $sButton = '<span style="color:red;" title="'.$arrmgrAndCief.'">You\'re not Authorized to Approve</span>';
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
    function manipulate_update_buttonx($buttons, $rowData) { 
        if ($this->input->get('action') == 'view') {
            unset($buttons['update_back']);
            unset($buttons['update']);
        }
        else{
            $cNip= $this->user->gNIP;

            $js = $this->load->view('export/js/export_studi_literatur_pd_js');
            $update = '<button onclick="javascript:update_btn_back(\'export_studi_literatur_pd\', \''.base_url().'processor/reformulasi/export/studi/literatur/pd?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_update_export_studi_literatur_pd">Update & Submit</button>';
            $updatedraft = '<button onclick="javascript:update_draft_btn(\'export_studi_literatur_pd\', \''.base_url().'processor/reformulasi/export/studi/literatur/pd?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_export_studi_literatur_pd">Update as Draft</button>';

           $approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/reformulasi/export/studi/literatur/pd?action=approve&iexport_refor_lpp='.$rowData['iexport_refor_lpp'].'&cNip='.$cNip.'&lvl=1&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_export_studi_literatur_pd">Confirm</button>';
            $reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/reformulasi/export/studi/literatur/pd?action=reject&iexport_refor_lpp='.$rowData['iexport_refor_lpp'].'&cNip='.$cNip.'&lvl=1&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_export_studi_literatur_pd">Reject</button>';


            if($rowData['iSubmit']==0){
                    $buttons['update'] = $updatedraft.$update.$js;

            }else{
                if($rowData['iaprove']==0 or empty($rowData['iaprove'])){

                     $sqlM = "SELECT r.`vnip` FROM `reformulasi`.`reformulasi_team` r
                        JOIN `reformulasi`.`export_req_refor` e ON e.`iTeamAndev` = r.`ireformulasi_team`
                        WHERE e.`iexport_req_refor` =  '".$rowData['iexport_req_refor']."' LIMIT 1";
                        $tomail = $this->db->query($sqlM)->row_array();
                        if($tomail['vnip']==$cNip){
                            //$buttons['update'] = $approve.$reject.$js;
                            $buttons['update'] = $approve.$js;
                        }else{
                            unset($buttons['update_back']);
                            unset($buttons['update']);
                        }

                }else{
                    unset($buttons['update_back']);
                    unset($buttons['update']);
                }


            }

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
        
        $data = $this->db_reformulasi0->query($sql)->row_array();
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

    //Output
    public function output(){
        $this->index($this->input->get('action'));
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

    private function filterUPBByTeam($tableAlias = 'reformulasi_upb'){
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
