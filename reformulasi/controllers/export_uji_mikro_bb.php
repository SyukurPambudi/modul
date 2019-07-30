<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class export_uji_mikro_bb extends MX_Controller {
	//private $sess_auth;
	private $dbset;
    function __construct() {
        parent::__construct();
		$this->load->library('auth_export');
        $this->load->library('lib_utilitas');
		$this->user = $this->auth_export->user(); 
		$this->dbset = $this->load->database('formulasi', false, true);
		
    }
    function index($action = '') {
    	$action = $this->input->get('action');
		
    	//Bikin Object Baru Nama nya $grid	

        $grid = new Grid;		
        $grid->setUrl('export_uji_mikro_bb');
        $grid->setTitle('Uji Mikro BB');		
        $grid->setTable('reformulasi.export_uji_mikro_bb');		
        $grid->setUrl('export_uji_mikro_bb');
        $grid->addList('export_request_sample.vRequest_no','plc2_raw_material.vnama','iJumlah_terima','iSubmit','iApprove_uji');
        $grid->addFields('iApprove_uji','iexport_request_sample_detail','no_ro','no_upb','iJumlah_terima','satuan_id','dMulai_literatur','dSelesai_literatur','dMulai_uji','dSelesai_uji','cPic_uji','iHasil_uji','iUji_spesifik','file_literatur','file_filename');
        $grid->setSortBy('iexport_uji_mikro_bb');
        $grid->setSortOrder('DESC'); //sort ordernya
		
		//align & width
		$grid->setLabel('iApprove_uji', 'Status Approval'); //Ganti Label
        $grid->setAlign('iApprove_uji', 'Center'); //Align nya
        $grid->setWidth('iApprove_uji', '50'); // width nya

        $grid->setLabel('satuan_id', 'Satuan'); //Ganti Label
        $grid->setAlign('satuan_id', 'Center'); //Align nya
        $grid->setWidth('satuan_id', '50'); // width nya

        
		
		$grid->setLabel('no_ro', 'No Penerimaan'); //Ganti Label
		$grid->setLabel('no_upb', 'No UPD'); //Ganti Label
		$grid->setLabel('file_filename', 'Upload Laporan Pengujian Mikro BB'); //Ganti Label
		$grid->setLabel('file_literatur', 'Upload Laporan Study Literatur'); //Ganti Label
		
		$grid->setLabel('export_request_sample.vRequest_no', 'No Request'); //Ganti Label
		$grid->setAlign('export_request_sample.vRequest_no', 'Center'); //Align nya
        $grid->setWidth('export_request_sample.vRequest_no', '80'); // width nya

		$grid->setLabel('plc2_raw_material.vnama', 'Nama Bahan Baku'); //Ganti Label
		$grid->setAlign('plc2_raw_material.vnama', 'left'); //Align nya
        $grid->setWidth('plc2_raw_material.vnama', '250'); // width nya




		$grid->setLabel('iexport_request_sample_detail', 'Nama Bahan Baku'); //Ganti Label
        $grid->setAlign('iexport_request_sample_detail', 'left'); //Align nya
        $grid->setWidth('iexport_request_sample_detail', '50'); // width nya
		
		$grid->setLabel('iJumlah_terima', 'Jumlah Terima'); //Ganti Label
        $grid->setAlign('iJumlah_terima', 'right'); //Align nya
        $grid->setWidth('iJumlah_terima', '100'); // width nya

        $grid->setLabel('iSubmit', 'Status Submit'); //Ganti Label
        $grid->setAlign('iSubmit', 'center'); //Align nya
        $grid->setWidth('iSubmit', '100'); // width nya

        $grid->setLabel('iApprove_uji', 'Status Approval'); //Ganti Label
        $grid->setAlign('iApprove_uji', 'center'); //Align nya
        $grid->setWidth('iApprove_uji', '150'); // width nya

        $grid->setLabel('dMulai_literatur', 'Tanggal Mulai Study Literatur '); //Ganti Label
        $grid->setAlign('dMulai_literatur', 'left'); //Align nya
        $grid->setWidth('dMulai_literatur', '50'); // width nya

        $grid->setLabel('dSelesai_literatur', 'Tanggal Selesai Study Literatur '); //Ganti Label
        $grid->setAlign('dSelesai_literatur', 'left'); //Align nya
        $grid->setWidth('dSelesai_literatur', '50'); // width nya

        $grid->setLabel('dMulai_uji', 'Tanggal Mulai Pengujian Mikro BB'); //Ganti Label
        $grid->setAlign('dMulai_uji', 'left'); //Align nya
        $grid->setWidth('dMulai_uji', '50'); // width nya

        $grid->setLabel('dSelesai_uji', 'Tanggal Selesai Pengujian Mikro BB'); //Ganti Label
        $grid->setAlign('dSelesai_uji', 'left'); //Align nya
        $grid->setWidth('dSelesai_uji', '50'); // width nya
		
		$grid->setLabel('cPic_uji', 'PIC Pengujian Mikro BB'); //Ganti Label
        $grid->setAlign('cPic_uji', 'left'); //Align nya
        $grid->setWidth('cPic_uji', '50'); // width nya        
		
		$grid->setLabel('iHasil_uji', 'Hasil Pengujian Mikro BB'); //Ganti Label
        $grid->setAlign('iHasil_uji', 'left'); //Align nya
        $grid->setWidth('iHasil_uji', '50'); // width nya

        $grid->setLabel('iUji_spesifik', 'Perlu Uji Spesifik'); //Ganti Label
		//set search
        $grid->setSearch('export_request_sample.vRequest_no', 'plc2_raw_material.vnama');
		
		//set required
        $grid->setRequired('iexport_request_sample_detail','no_ro','no_upb','dMulai_uji','dSelesai_uji','cPic_uji', 'iJumlah_terima','satuan_id','iHasil_uji','iUji_spesifik','dMulai_literatur','dSelesai_literatur');	//Field yg mandatori

        $grid->setGridView('grid');

        $grid->changeFieldType('iSubmit','combobox','',array('0'=>'Draft','1'=>'Submitted'));
        $grid->changeFieldType('iHasil_uji','combobox','',array(''=>'Select One','1'=>'Gagal','2'=>'Berhasil'));
        $grid->changeFieldType('iUji_spesifik','combobox','',array(''=>'Select One','1'=>'Ya','0'=>'Tidak'));

        
        $grid->setJoinTable('reformulasi.export_request_sample_detail', 'export_request_sample_detail.iexport_request_sample_detail = export_uji_mikro_bb.iexport_request_sample_detail', 'inner');
        $grid->setJoinTable('reformulasi.export_request_sample', 'export_request_sample.iexport_request_sample = export_request_sample_detail.iexport_request_sample', 'inner');
        $grid->setJoinTable('plc2.plc2_raw_material', 'plc2_raw_material.raw_id = export_request_sample_detail.raw_id', 'inner');
        $grid->changeFieldType('iApprove_uji','combobox','',array(''=>'--Select--',0=>'Waiting Approval',1=>'Rejected', 2=>'Approved'));

        $grid->setQuery('export_uji_mikro_bb.lDeleted', 0);	
        $grid->setFormUpload(TRUE);


        switch ($action) {
                case 'json':
                        $grid->getJsonData();
                        break;
                case 'view':
                        $grid->render_form($this->input->get('id'), true);
                        break;
                case 'create':
                        $grid->render_form();
                        break;
                case 'createproses':
                        $isUpload = $this->input->get('isUpload');
						$sql = array();
						$sql1 = array();
		   				if($isUpload) {
							$path = realpath("files/reformulasi/export/export_uji_mikro_bb/rpt_mikro_bb/");
							$path1 = realpath("files/reformulasi/export/export_uji_mikro_bb/rpt_study_literatur/");
							
							if (!mkdir($path."/".$this->input->get('lastId'), 0777, true)) {
							    die('Failed upload, try again!');
							}
							if (!mkdir($path1."/".$this->input->get('lastId'), 0777, true)) {
							    die('Failed upload, try again!');
							}
							
							$file_keterangan = array();
							foreach($_POST as $key=>$value) {						
								if ($key == 'fileketerangan') {
									foreach($value as $k=>$v) {
										$file_keterangan[$k] = $v;
									}
								}
								if ($key == 'fileketerangan1') {
									foreach($value as $k=>$v) {
										$file_keterangan1[$k] = $v;
									}
								}
								
							}
						
							$i = 0;
							//upload form 1
							foreach ($_FILES['fileupload']["error"] as $key => $error) {
								if ($error == UPLOAD_ERR_OK) {				
									$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
									$name = $_FILES['fileupload']["name"][$key];
									$data['filename'] = $name;
									$data['id']=$this->input->get('lastId');
									$data['nip']=$this->user->gNIP;
									//$data['iupb_id'] = $insertId;
									//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
									$data['dInsertDate'] = date('Y-m-d H:i:s');
									if(move_uploaded_file($tmp_name, $path."/".$this->input->get('lastId')."/".$name)) {	
										$sql[] = "INSERT INTO reformulasi.export_uji_mikro_bb_file(iexport_uji_mikro_bb, filename, dInsertDate, keterangan,cInsert) 
												VALUES ('".$data['id']."', '".$data['filename']."','".$data['dInsertDate']."','".$file_keterangan[$i]."','".$data['nip']."')";
										$i++;																			
									}
									else{
									echo "Upload ke folder gagal";	
									}
								}
								
							}			
							foreach($sql as $q) {
								try {
									$this->dbset->query($q);
								}catch(Exception $e) {
									die($e);
								}
							}
							
							//upload form 2
							if (isset($_FILES['fileupload1'])){
								$i = 0;
								foreach ($_FILES['fileupload1']["error"] as $key => $error) {
									if ($error == UPLOAD_ERR_OK) {				
										$tmp_name1 = $_FILES['fileupload1']["tmp_name"][$key];
										$name1 = $_FILES['fileupload1']["name"][$key];
										$data1['filename'] = $name1;
										$data1['id']=$this->input->get('lastId');
										$data1['nip']=$this->user->gNIP;
										//$data['iupb_id'] = $insertId;
										//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
										$data1['dInsertDate'] = date('Y-m-d H:i:s');
										if(move_uploaded_file($tmp_name1, $path1."/".$this->input->get('lastId')."/".$name1)) {	
											$sql1[] = "INSERT INTO reformulasi.export_uji_mikro_bb_file_literatur(iexport_uji_mikro_bb, filename, dInsertDate, keterangan,cInsert) 
													VALUES ('".$data1['id']."', '".$data1['filename']."','".$data1['dInsertDate']."','".$file_keterangan1[$i]."','".$data1['nip']."')";
											$i++;																			
										}
										else{
										echo "Upload ke folder gagal";	
										}
									}
								}			
								foreach($sql1 as $q1) {
									try {
										$this->dbset->query($q1);
									}catch(Exception $e) {
										die($e);
									}
								}
							}
							
							$r['status'] = TRUE;
							$r['last_id'] = $this->input->get('lastId');					
							echo json_encode($r);
							exit();
						}  else {
							echo $grid->saved_form();
						}
                        break;
                case 'update':
                        $grid->render_form($this->input->get('id'));
                        break;
                case 'updateproses':
                        $isUpload = $this->input->get('isUpload');
						$sql = array();
		   				$sql1 = array();
						$file_name= "";
						$file_name1= "";
						
						//$fileId = array();
						$path = realpath("files/reformulasi/export/export_uji_mikro_bb/rpt_mikro_bb/");
						$path1 = realpath("files/reformulasi/export/export_uji_mikro_bb/rpt_study_literatur/");
				
						if (!file_exists( $path."/".$this->input->post('export_uji_mikro_bb_iexport_uji_mikro_bb') )) {
							mkdir($path."/".$this->input->post('export_uji_mikro_bb_iexport_uji_mikro_bb'), 0777, true);						 
						}
					
						if (!file_exists( $path1."/".$this->input->post('export_uji_mikro_bb_iexport_uji_mikro_bb') )) { 
							mkdir($path1."/".$this->input->post('export_uji_mikro_bb_iexport_uji_mikro_bb'), 0777, true);					    
						}
				
						$file_keterangan = array();
						$file_keterangan1 = array();
				
						foreach($_POST as $key=>$value) {
													
							if ($key == 'fileketerangan') {
								foreach($value as $y=>$u) {
									$file_keterangan[$y] = $u;
								}
							}
							if ($key == 'fileketerangan1') {
								foreach($value as $y=>$u) {
									$file_keterangan1[$y] = $u;
								}
							}
							
							
							//
							if ($key == 'namafile') {
								foreach($value as $k=>$v) {
									$file_name[$k] = $v;
								}
							}
							if ($key == 'namafile1') {
								foreach($value as $k=>$v) {
									$file_name1[$k] = $v;
								}
							}
							
							
							//
							if ($key == 'fileid') {
								foreach($value as $k=>$v) {
									$fileId[$k] = $v;
								}
							}
							if ($key == 'fileid1') {
								foreach($value as $k=>$v) {
									$fileId1[$k] = $v;
								}
							}
							
						}
				
				
						$last_index = 0;
						$last_index1 = 0;
				
						if($isUpload) {
							$j = $last_index;				
														
							if (isset($_FILES['fileupload'])) {
								$this->hapusfile($path, $file_name, 'export_uji_mikro_bb_file', $this->input->post('export_uji_mikro_bb_iexport_uji_mikro_bb'));
								foreach ($_FILES['fileupload']["error"] as $key => $error) {	
									if ($error == UPLOAD_ERR_OK) {
										$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
										$name = $_FILES['fileupload']["name"][$key];
										$data['filename'] = $name;
										$data['id']=$this->input->post('export_uji_mikro_bb_iexport_uji_mikro_bb');
										$data['nip']=$this->user->gNIP;
										//$data['iupb_id'] = $insertId;
										$data['dInsertDate'] = date('Y-m-d H:i:s');
						 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
						 				if(move_uploaded_file($tmp_name, $path."/".$this->input->post('export_uji_mikro_bb_iexport_uji_mikro_bb')."/".$name)) 
						 				{				 					
											$sql[] = "INSERT INTO reformulasi.export_uji_mikro_bb_file(iexport_uji_mikro_bb, filename, dInsertDate, keterangan,cInsert) 
												VALUES ('".$data['id']."', '".$data['filename']."','".$data['dInsertDate']."','".$file_keterangan[$j]."','".$data['nip']."')";																		
											$j++;																			
										}
										else{
										echo "Upload ke folder gagal";	
										}
									}
									
								}						
									
														
                                foreach($sql as $q) {
                                        try {
                                                $this->dbset->query($q);
                                        }catch(Exception $e) {
                                                die($e);
                                        }
                                }
							}	
							
							$a = $last_index1;	
							//upload form 2
							if (isset($_FILES['fileupload1'])) {
								
								$this->hapusfile($path1, $file_name1, 'export_uji_mikro_bb_file_literatur', $this->input->post('export_uji_mikro_bb_iexport_uji_mikro_bb'));
								foreach ($_FILES['fileupload1']["error"] as $key => $error) {	
									if ($error == UPLOAD_ERR_OK) {
										$tmp_name1 = $_FILES['fileupload1']["tmp_name"][$key];
										$name1 = $_FILES['fileupload1']["name"][$key];
										$data1['filename'] = $name1;
										$data1['id']=$this->input->post('export_uji_mikro_bb_iexport_uji_mikro_bb');
										$data1['nip']=$this->user->gNIP;
										$data1['dInsertDate'] = date('Y-m-d H:i:s');
						 				if(move_uploaded_file($tmp_name1, $path1."/".$this->input->post('export_uji_mikro_bb_iexport_uji_mikro_bb')."/".$name1)) 
						 				{
											$sql1[] = "INSERT INTO reformulasi.export_uji_mikro_bb_file_literatur(iexport_uji_mikro_bb, filename, dInsertDate, keterangan,cInsert) 
												VALUES ('".$data1['id']."', '".$data1['filename']."','".$data1['dInsertDate']."','".$file_keterangan1[$a]."','".$data1['nip']."')";
											$a++;																			
										}
										else{
										echo "Upload ke folder gagal";	
										}
									}
								}
							
												
                                foreach($sql1 as $q1) {
                                        try {
                                                $this->dbset->query($q1);
                                        }catch(Exception $e) {
                                                die($e);
                                        }
                                }
							}
							
							
							$r['status'] = TRUE;
							$r['last_id'] = $this->input->get('lastId');					
							echo json_encode($r);
							exit();
						}  else {
							if (is_array($file_name)) {									
								$this->hapusfile($path, $file_name, 'export_uji_mikro_bb_file', $this->input->post('export_uji_mikro_bb_iexport_uji_mikro_bb'));
							}
							if (is_array($file_name1)) {									
								$this->hapusfile($path1, $file_name1, 'export_uji_mikro_bb_file_literatur', $this->input->post('export_uji_mikro_bb_iexport_uji_mikro_bb'));
							}
												
							echo $grid->updated_form();
						}
                        break;
				case 'download':
						$this->download($this->input->get('file'));
						break;
				case 'approve':
					echo $this->approve_view();
				break;
				case 'approve_process':
					echo $this->approve_process();
				break;						                        
                case 'delete':
                        echo $grid->delete_row();
                        break;
                default:
                        $grid->render_grid();
                        break;
        }
    }   

    function listBox_Action($row, $actions) {
	 	$mydept = $this->auth_export->my_depts(TRUE);
	 	$x = $this->auth_export->my_teams();
		$array = explode(',', $x);

		if (isset($mydept)) {
			if((in_array('QA', $mydept)) ) {
				if ($row->iSubmit<>0) {
					if($this->auth_export->is_manager()){
						if ($row->iApprove_uji<>0) {
							unset($actions['edit']);
		 					unset($actions['delete']);	
						}
					}
				}
			}else{
				unset($actions['edit']);
	 			unset($actions['delete']);
			}
		}else{
			unset($actions['edit']);
	 		unset($actions['delete']);
		}


		 return $actions;

	} 

// manipulate object 
	function insertBox_export_uji_mikro_bb_satuan_id($field, $id) {
    	$sq = 'select * from kanban.kbn_master_satuan a where a.iDeleted=0';
    	$teams = $this->db->query($sq)->result_array();
    	$o = '<select class="required" name="'.$field.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['satuan_id'].'">'.$t['nama_satuan'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }
    function updateBox_export_uji_mikro_bb_satuan_id($field, $id, $value, $rowData) {
    	$sq = 'select * from kanban.kbn_master_satuan a where a.iDeleted=0';
    	$teams = $this->db->query($sq)->result_array();
    	$echo = '<select class="required" name="'.$field.'" id="'.$id.'">';
    	$echo .= '<option value="">--Pilih--</option>';
    	foreach($teams as $t) {
    		$selected = $rowData['satuan_id'] == $t['satuan_id'] ? 'selected' : '';
    		$echo .= '<option '.$selected.' value="'.$t['satuan_id'].'">'.$t['nama_satuan'].'</option>';
    	}
    	$echo .= '</select>';
    	return $echo;
    }


    function insertBox_export_uji_mikro_bb_iApprove_uji($field, $id) {
		$o='-';
		$o.='
		<script type="text/javascript">
			// datepicker
			 $(".tanggal").datepicker({changeMonth:true,
										changeYear:true,
										dateFormat:"yy-mm-dd" });

			// input number
			   $(".angka").numeric();
		</script>
		';


		return $o;
	}

	function updateBox_export_uji_mikro_bb_iApprove_uji($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = 'select * 
						from reformulasi.export_uji_mikro_bb a 
						join hrd.employee b on b.cNip=a.cApproval_uji
						where
						a.lDeleted = 0
						and  a.iexport_uji_mikro_bb = "'.$rowData['iexport_uji_mikro_bb'].'"';
			$row = $this->db->query($sql_dtapp)->row_array();
			if($value==2){
				$st='<p style="color:green;font-size:120%;">Approved';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApproval_uji'].'</br> Alasan: '.$row['vRemark_uji'].'</p>';
			}
			elseif($value==1){
				$st='<p style="color:red;font-size:120%;">Rejected';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApproval_uji'].'</br> Alasan: '.$row['vRemark_uji'].'</p>';
			} 

			
			
			
		}
		else{
			$ret='Waiting for Approval';
		}
		

		$ret.='
		<script type="text/javascript">
			// datepicker
			 $(".tanggal").datepicker({changeMonth:true,
										changeYear:true,
										dateFormat:"yy-mm-dd" });

			// input number
			   $(".angka").numeric();
		</script>
		';

		return $ret;
	}

	function insertBox_export_uji_mikro_bb_iexport_request_sample_detail($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />
					';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="45" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/reformulasi/uji/mikro/bb/popup/?field=export_uji_mikro_bb\',\'List Bahan Baku\')" type="button">&nbsp;</button>';                
		
		return $return;
	}

	function updateBox_export_uji_mikro_bb_iexport_request_sample_detail($field, $id, $value, $rowData) {
		$sql = "SELECT export_request_sample.vRequest_no AS export_request_sample__vRequest_no, export_ro.vRo_no AS export_ro__vRo_no
			, plc2_raw_material.vnama AS plc2_raw_material__vnama
			, export_req_refor.vno_export_req_refor AS export_req_refor__vno_export_req_refor, dossier_upd.vUpd_no AS dossier_upd__vUpd_no, dossier_upd.vNama_usulan AS dossier_upd__vNama_usulan, 
			export_request_sample.vRequest_no,plc2_raw_material.vnama,
			/*uji_mikro_bb_popup/uji_mikro_bb_popup.php/output*/reformulasi.export_request_sample_detail.*
			FROM (`reformulasi`.`export_request_sample_detail`)
			INNER JOIN `reformulasi`.`export_request_sample` ON `export_request_sample`.`iexport_request_sample` = `export_request_sample_detail`.`iexport_request_sample`
			INNER JOIN `reformulasi`.`export_ro_detail` ON `export_ro_detail`.`iexport_request_sample_detail` = `export_request_sample_detail`.`iexport_request_sample_detail`
			INNER JOIN `reformulasi`.`export_ro` ON `export_ro`.`iexport_ro` = `export_ro_detail`.`iexport_ro`
			INNER JOIN `plc2`.`plc2_raw_material` ON `plc2_raw_material`.`raw_id` = `export_request_sample_detail`.`raw_id`
			INNER JOIN `reformulasi`.`export_req_refor` ON `export_req_refor`.`iexport_req_refor` = `export_request_sample`.`iexport_req_refor`
			INNER JOIN `dossier`.`dossier_upd` ON `dossier_upd`.`idossier_upd_id` = `export_req_refor`.`idossier_upd_id`
			WHERE `reformulasi`.`export_ro_detail`.`iUji_mikro` =  2
			and  export_request_sample_detail.iexport_request_sample_detail = '".$value."'
			GROUP BY iexport_request_sample_detail
			ORDER BY `iexport_request_sample_detail` asc
			";

		/*$sql = '
		select a.iexport_request_sample_detail,b.vRequest_no,e.vpo_nomor,f.vro_nomor,g.vnama,a.ijumlah,h.vUpd_no,h.vNama_usulan,a.* ,d.*
		from reformulasi.export_request_sample_detail a
		join reformulasi.export_request_sample b on b.ireq_id=a.ireq_id
		join plc2.plc2_upb_ro_detail d on d.ireq_id=a.ireq_id and d.raw_id=a.raw_id
		join plc2.plc2_upb_po  e on e.ipo_id=d.ipo_id
		join plc2.plc2_upb_ro f on f.iro_id=d.iro_id
		join plc2.plc2_raw_material g on g.raw_id=a.raw_id
		join plc2.plc2_upb h on h.iupb_id=b.iupb_id
		join reformulasi.export_uji_mikro_bb i on i.iexport_request_sample_detail=a.iexport_request_sample_detail
		where 
		a.ldeleted=0
		and b.ldeleted=0
		and d.ldeleted=0
		and e.ldeleted=0
		and f.ldeleted=0
		and g.ldeleted=0
		and h.ldeleted=0
		and i.lDeleted=0
		and i.iexport_request_sample_detail
		="'.$value.'" ';*/
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vRequest_no'].' - '.$data_upb['vnama'];

		}else{
			
			if ($rowData['iSubmit'] == 0) {
				$return = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />
						';
			$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="45" value="'.$data_upb['vRequest_no'].' - '.$data_upb['vnama'].'"/>';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/reformulasi/uji/mikro/bb/popup/?field=export_uji_mikro_bb\',\'List Bahan Baku\')" type="button">&nbsp;</button>';                
			

			
			}else{
				$return= $data_upb['vRequest_no'].' - '.$data_upb['vnama'];
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			}
			
			//$return= $data_upb['vNo_upi'];
		}
		
		return $return;
	}


	function insertBox_export_uji_mikro_bb_no_ro($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  disabled="disabled" class="input_rows1 required" size="15" />';
		return $return;
	}
	//,'no_po','manuf',''
	function updateBox_export_uji_mikro_bb_no_ro($field, $id, $value, $rowData) {
		$sql = "SELECT export_request_sample.vRequest_no AS export_request_sample__vRequest_no, export_ro.vRo_no AS export_ro__vRo_no
			, plc2_raw_material.vnama AS plc2_raw_material__vnama
			, export_req_refor.vno_export_req_refor AS export_req_refor__vno_export_req_refor, dossier_upd.vUpd_no AS dossier_upd__vUpd_no, dossier_upd.vNama_usulan AS dossier_upd__vNama_usulan, 
			export_request_sample.vRequest_no,plc2_raw_material.vnama,export_ro.vRo_no,
			/*uji_mikro_bb_popup/uji_mikro_bb_popup.php/output*/reformulasi.export_request_sample_detail.*
			FROM (`reformulasi`.`export_request_sample_detail`)
			INNER JOIN `reformulasi`.`export_request_sample` ON `export_request_sample`.`iexport_request_sample` = `export_request_sample_detail`.`iexport_request_sample`
			INNER JOIN `reformulasi`.`export_ro_detail` ON `export_ro_detail`.`iexport_request_sample_detail` = `export_request_sample_detail`.`iexport_request_sample_detail`
			INNER JOIN `reformulasi`.`export_ro` ON `export_ro`.`iexport_ro` = `export_ro_detail`.`iexport_ro`
			INNER JOIN `plc2`.`plc2_raw_material` ON `plc2_raw_material`.`raw_id` = `export_request_sample_detail`.`raw_id`
			INNER JOIN `reformulasi`.`export_req_refor` ON `export_req_refor`.`iexport_req_refor` = `export_request_sample`.`iexport_req_refor`
			INNER JOIN `dossier`.`dossier_upd` ON `dossier_upd`.`idossier_upd_id` = `export_req_refor`.`idossier_upd_id`
			WHERE `reformulasi`.`export_ro_detail`.`iUji_mikro` =  2
			and  export_request_sample_detail.iexport_request_sample_detail = '".$rowData['iexport_request_sample_detail']."'
			GROUP BY iexport_request_sample_detail
			ORDER BY `iexport_request_sample_detail` asc
			";

		/*$sql = '
		select a.iexport_request_sample_detail,b.vRequest_no,e.vpo_nomor,f.vro_nomor,g.vnama,a.ijumlah,h.vUpd_no,h.vNama_usulan,a.* ,d.*
		from reformulasi.export_request_sample_detail a
		join reformulasi.export_request_sample b on b.ireq_id=a.ireq_id
		join plc2.plc2_upb_ro_detail d on d.ireq_id=a.ireq_id and d.raw_id=a.raw_id
		join plc2.plc2_upb_po  e on e.ipo_id=d.ipo_id
		join plc2.plc2_upb_ro f on f.iro_id=d.iro_id
		join plc2.plc2_raw_material g on g.raw_id=a.raw_id
		join plc2.plc2_upb h on h.iupb_id=b.iupb_id
		join reformulasi.export_uji_mikro_bb i on i.iexport_request_sample_detail=a.iexport_request_sample_detail
		where 
		a.ldeleted=0
		and b.ldeleted=0
		and d.ldeleted=0
		and e.ldeleted=0
		and f.ldeleted=0
		and g.ldeleted=0
		and h.ldeleted=0
		and i.lDeleted=0
		and i.iexport_request_sample_detail
		="'.$rowData['iexport_request_sample_detail'].'" ';*/
		$data_upb = $this->dbset->query($sql)->row_array();

		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vRo_no'];

		}
		else{
			$return = '<input type="text" name="'.$field.'" disabled="disabled" id="'.$id.'" value="'.$data_upb['vRo_no'].'" class="input_rows1 required" size="10" />';
		}
		return $return;
	}

	function insertBox_export_uji_mikro_bb_no_upb($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  disabled="disabled" class="input_rows1 required" size="40" />';
		return $return;
	}
	//,'no_po','manuf','no_upb'
	function updateBox_export_uji_mikro_bb_no_upb($field, $id, $value, $rowData) {
		
		$sql = "SELECT export_request_sample.vRequest_no AS export_request_sample__vRequest_no, export_ro.vRo_no AS export_ro__vRo_no
			, plc2_raw_material.vnama AS plc2_raw_material__vnama
			, export_req_refor.vno_export_req_refor AS export_req_refor__vno_export_req_refor, dossier_upd.vUpd_no AS dossier_upd__vUpd_no, dossier_upd.vNama_usulan AS dossier_upd__vNama_usulan, 
			export_request_sample.vRequest_no,plc2_raw_material.vnama,dossier_upd.vUpd_no,dossier_upd.vNama_usulan,
			/*uji_mikro_bb_popup/uji_mikro_bb_popup.php/output*/reformulasi.export_request_sample_detail.*
			FROM (`reformulasi`.`export_request_sample_detail`)
			INNER JOIN `reformulasi`.`export_request_sample` ON `export_request_sample`.`iexport_request_sample` = `export_request_sample_detail`.`iexport_request_sample`
			INNER JOIN `reformulasi`.`export_ro_detail` ON `export_ro_detail`.`iexport_request_sample_detail` = `export_request_sample_detail`.`iexport_request_sample_detail`
			INNER JOIN `reformulasi`.`export_ro` ON `export_ro`.`iexport_ro` = `export_ro_detail`.`iexport_ro`
			INNER JOIN `plc2`.`plc2_raw_material` ON `plc2_raw_material`.`raw_id` = `export_request_sample_detail`.`raw_id`
			INNER JOIN `reformulasi`.`export_req_refor` ON `export_req_refor`.`iexport_req_refor` = `export_request_sample`.`iexport_req_refor`
			INNER JOIN `dossier`.`dossier_upd` ON `dossier_upd`.`idossier_upd_id` = `export_req_refor`.`idossier_upd_id`
			WHERE `reformulasi`.`export_ro_detail`.`iUji_mikro` =  2
			and  export_request_sample_detail.iexport_request_sample_detail = '".$rowData['iexport_request_sample_detail']."'
			GROUP BY iexport_request_sample_detail
			ORDER BY `iexport_request_sample_detail` asc
			";
		/*$sql = '
		select a.iexport_request_sample_detail,b.vRequest_no,e.vpo_nomor,f.vro_nomor,g.vnama,a.ijumlah,h.vUpd_no,h.vNama_usulan,a.* ,d.*
		from reformulasi.export_request_sample_detail a
		join reformulasi.export_request_sample b on b.ireq_id=a.ireq_id
		join plc2.plc2_upb_ro_detail d on d.ireq_id=a.ireq_id and d.raw_id=a.raw_id
		join plc2.plc2_upb_po  e on e.ipo_id=d.ipo_id
		join plc2.plc2_upb_ro f on f.iro_id=d.iro_id
		join plc2.plc2_raw_material g on g.raw_id=a.raw_id
		join plc2.plc2_upb h on h.iupb_id=b.iupb_id
		join reformulasi.export_uji_mikro_bb i on i.iexport_request_sample_detail=a.iexport_request_sample_detail
		where 
		a.ldeleted=0
		and b.ldeleted=0
		and d.ldeleted=0
		and e.ldeleted=0
		and f.ldeleted=0
		and g.ldeleted=0
		and h.ldeleted=0
		and i.lDeleted=0
		and i.iexport_request_sample_detail
		="'.$rowData['iexport_request_sample_detail'].'" ';*/
		$data_upb = $this->dbset->query($sql)->row_array();

		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vUpd_no'].' - '.$data_upb['vNama_usulan'];

		}
		else{
			$return = '<input type="text" value="'.$data_upb['vUpd_no'].' - '.$data_upb['vNama_usulan'].'" disabled="disabled" class="input_rows1 required" size="40" />';
			//$return .= '<input type="hide" name="'.$field.'" id="'.$id.'" value="'.$data_upb['vUpd_no'].' - '.$data_upb['vNama_usulan'].'" class="input_rows1 required" size="30" />';
		}
		return $return;
	}

	function insertBox_export_uji_mikro_bb_iJumlah_terima($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" angka input_rows1 required" size="8" />
		<input type="hidden" name="isdraft" id="isdraft">';
		return $return;
	}

	function updateBox_export_uji_mikro_bb_iJumlah_terima($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="angka input_rows1 required" size="8" />
			<input type="hidden" name="isdraft" id="isdraft">';
		}
		return $return;
	}


	function insertBox_export_uji_mikro_bb_dMulai_literatur($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" tanggal required input_rows1 " size="8" />';
		return $return;
	}

	function updateBox_export_uji_mikro_bb_dMulai_literatur($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="tanggal required input_rows1 " size="8" />';
		}
		return $return;
	}

	function insertBox_export_uji_mikro_bb_dSelesai_literatur($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" tanggal required input_rows1 " size="8" />';
		return $return;
	}

	function updateBox_export_uji_mikro_bb_dSelesai_literatur($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="tanggal required input_rows1 " size="8" />';
		}
		return $return;
	}

	function insertBox_export_uji_mikro_bb_dMulai_uji($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" tanggal input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_export_uji_mikro_bb_dMulai_uji($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="tanggal input_rows1 required" size="8" />';
		}
		return $return;
	}

	function insertBox_export_uji_mikro_bb_dSelesai_uji($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" tanggal input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_export_uji_mikro_bb_dSelesai_uji($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="tanggal input_rows1 required" size="8" />';
		}
		return $return;
	}		

	function insertBox_export_uji_mikro_bb_cPic_uji($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="" />
					';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="30" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/pic/?field=export_uji_mikro_bb&pic_for=export_uji_mikro_bb&idfield='.$field.'\',\'List PIC\')" type="button">&nbsp;</button>';                
		
		return $return;
	}

	function updateBox_export_uji_mikro_bb_cPic_uji($field, $id, $value, $rowData) {
		$emp = $this->db->get_where('hrd.employee', array('cNip'=>$rowData['cPic_uji']))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $emp['cNip'].' - '.$emp['vName'];

		}else{
			
			if ($rowData['iSubmit'] == 0) {
				$return = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />
						';
			$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="30" value="'.$emp['cNip'].' - '.$emp['vName'].'"/>';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/pic/?field=export_uji_mikro_bb&pic_for=export_uji_mikro_bb&idfield='.$field.'\',\'List PIC\')" type="button">&nbsp;</button>';                
			

			
			}else{
				$return= $emp['cNip'].' - '.$emp['vName'];
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			}
			
		}
		
		return $return;
	}

	function insertBox_export_uji_mikro_bb_file_filename() {
		$data['mydept'] = $this->auth_export->my_depts(TRUE);	
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('export/sample/export_uji_mikro_bb_file',$data,TRUE); 
	}

	function updateBox_export_uji_mikro_bb_file_filename($field, $id, $value, $rowData) {
		if (!empty($_GET['idnya'])) {
			$iexport_uji_mikro_bb = $_GET['idnya'];
		}else{
			$iexport_uji_mikro_bb = $rowData['iexport_uji_mikro_bb'];
		}
		$data['mydept'] = $this->auth_export->my_depts(TRUE);
		$data['rows'] = $this->db->get_where('reformulasi.export_uji_mikro_bb_file', array('iexport_uji_mikro_bb'=>$iexport_uji_mikro_bb))->result_array();
		return $this->load->view('export/sample/export_uji_mikro_bb_file',$data,TRUE);				
	}	


	function insertBox_export_uji_mikro_bb_file_literatur() {
		$data['mydept'] = $this->auth_export->my_depts(TRUE);	
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('export/sample/export_uji_mikro_bb_file_literatur',$data,TRUE); 
	}

	function updateBox_export_uji_mikro_bb_file_literatur($field, $id, $value, $rowData) {
		if (!empty($_GET['idnya'])) {
			$iexport_uji_mikro_bb = $_GET['idnya'];
		}else{
			$iexport_uji_mikro_bb = $rowData['iexport_uji_mikro_bb'];
		}
		$data['mydept'] = $this->auth_export->my_depts(TRUE);
		$data['rows'] = $this->db->get_where('reformulasi.export_uji_mikro_bb_file_literatur', array('iexport_uji_mikro_bb'=>$iexport_uji_mikro_bb))->result_array();
		return $this->load->view('export/sample/export_uji_mikro_bb_file_literatur',$data,TRUE);				
	}	

// end manipulate     

	function manipulate_insert_button($buttons) {
		unset($buttons['save']);

		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'export_uji_mikro_bb\', \''.base_url().'processor/reformulasi/export/uji/mikro/bb?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_export_uji_mikro_bb">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'export_uji_mikro_bb\', \''.base_url().'processor/reformulasi/export/uji/mikro/bb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_export_uji_mikro_bb">Save &amp; Submit</button>';
		$js = $this->load->view('export/sample/js/export_uji_mikro_bb_js');
		$js .= $this->load->view('export/sample/js/upload_js');
		$buttons['save'] = $save_draft.$save.$js;

		return $buttons;
	}

	function manipulate_update_button($buttons, $rowData) {
		//$rows = $this->db->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id'],'ldeleted'=>0))->row_array();
		//$idtim_bd =$rows['iteambusdev_id'];
		$mydept = $this->auth_export->my_depts(TRUE);
		$cNip= $this->user->gNIP;
		$js = $this->load->view('export/sample/js/export_uji_mikro_bb_js');
		$js .= $this->load->view('export/sample/js/upload_js');
		
		$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/reformulasi/export/uji/mikro/bb?action=approve&iexport_uji_mikro_bb='.$rowData['iexport_uji_mikro_bb'].'&cNip='.$cNip.'&lvl=2&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_export_uji_mikro_bb">Confirm</button>';
		$update = '<button onclick="javascript:update_btn_back(\'export_uji_mikro_bb\', \''.base_url().'processor/reformulasi/export/uji/mikro/bb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_export_uji_mikro_bb">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'export_uji_mikro_bb\', \''.base_url().'processor/reformulasi/export/uji/mikro/bb?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_export_uji_mikro_bb">Update as Draft</button>';



		if ($this->input->get('action') == 'view') {unset($buttons['update']);}

		else{
			
			unset($buttons['update_back']);
			unset($buttons['update']);
			
			if ($rowData['iSubmit']== 0) {
				// jika masih draft , show button update draft & update submit 
				if (isset($mydept)) {
					// cek punya dep
					if((in_array('QA', $mydept))) {
						$buttons['update'] = $updatedraft.$update.$js;
					}
				}

			}else{
				// sudah disubmit , show button approval 
				if ($rowData['iApprove_uji']==0) {
					// jika approval bdirm 0 
					if (isset($mydept)) {
						if((in_array('QA', $mydept))) {
							if($this->auth_export->is_manager()){
								$buttons['update'] = $approve.$js;	
							}else{
								$sqlcekapp='select * 
											from reformulasi.reformulasi_team_item i 
											join reformulasi.reformulasi_team t on t.ireformulasi_team=i.ireformulasi_team
											where i.vnip="'.$cNip.'" 
											and i.ldeleted=0 
											and cDeptId=3
											and iapprove=1';
								$qce=$this->dbset->query($sqlcekapp);
								if($qce->num_rows()>=1){
									$dce=$qce->row_array();
									if($dce['iapprove']==1){
										$buttons['update'] = $approve.$js;
									}
								}
							}
						}
					}

				}	
				
			}
		}

		return $buttons;

	}

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
								var url = "'.base_url().'processor/reformulasi/export/uji/mikro/bb";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_export_uji_mikro_bb").html(data);
										 $("#button_approve_export_uji_mikro_bb").hide();
										 $("#button_reject_export_uji_mikro_bb").hide();
									});
									
								}
									reload_grid("grid_export_uji_mikro_bb");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Confirm</h1><br />';
		$echo .= '<form id="form_export_uji_mikro_bb_approve" action="'.base_url().'processor/reformulasi/export/uji/mikro/bb?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="iexport_uji_mikro_bb" value="'.$this->input->get('iexport_uji_mikro_bb').'" />
				<input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark_uji"></textarea>
		<button type="button" onclick="submit_ajax(\'form_export_uji_mikro_bb_approve\')">Confirm</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$iexport_uji_mikro_bb = $post['iexport_uji_mikro_bb'];
		$lvl = $post['lvl'];
		$vRemark_uji = $post['vRemark_uji'];

		
		$data=array('iApprove_uji'=>'2','cApproval_uji'=>$cNip , 'dApproval_uji'=>date('Y-m-d H:i:s'), 'vRemark_uji'=>$vRemark_uji);
		$this -> db -> where('iexport_uji_mikro_bb', $iexport_uji_mikro_bb);
		$updet = $this -> db -> update('reformulasi.export_uji_mikro_bb', $data);

		/*Notifikasi jika ada yang diupdate*/
        if ($updet) {
            

            $qsql="
            		SELECT export_req_refor.iTeamPD,export_req_refor.iTeamAndev
					,a.*,b.*,export_request_sample.vRequest_no,plc2_raw_material.vnama
					FROM (`reformulasi`.`export_request_sample_detail`)
					INNER JOIN `reformulasi`.`export_request_sample` ON `export_request_sample`.`iexport_request_sample` = `export_request_sample_detail`.`iexport_request_sample`
					INNER JOIN `reformulasi`.`export_ro_detail` ON `export_ro_detail`.`iexport_request_sample_detail` = `export_request_sample_detail`.`iexport_request_sample_detail`
					INNER JOIN `reformulasi`.`export_ro` ON `export_ro`.`iexport_ro` = `export_ro_detail`.`iexport_ro`
					INNER JOIN `plc2`.`plc2_raw_material` ON `plc2_raw_material`.`raw_id` = `export_request_sample_detail`.`raw_id`
					INNER JOIN `reformulasi`.`export_req_refor` ON `export_req_refor`.`iexport_req_refor` = `export_request_sample`.`iexport_req_refor`
					INNER JOIN `dossier`.`dossier_upd` ON `dossier_upd`.`idossier_upd_id` = `export_req_refor`.`idossier_upd_id`
					join reformulasi.export_uji_mikro_bb a on a.iexport_request_sample_detail=export_request_sample_detail.iexport_request_sample_detail
					join hrd.employee b on b.cNip=a.cPic_uji
					WHERE `reformulasi`.`export_ro_detail`.`iUji_mikro` =  2
					and  a.iexport_uji_mikro_bb = '".$iexport_uji_mikro_bb."'

            ";
            $rsql = $this->db->query($qsql)->row_array();

            //echo $qsql;
            //exit;
            // kirim notifikasi message ERp
            $sqlEmpAr = 'select * from reformulasi.mailsparam a where a.cVariable="export_approve_uji_mikro_bb "';
            $dEmpAr =  $this->db->query($sqlEmpAr)->row_array();

               

            $to = $dEmpAr['vTo'];
            $cc = $dEmpAr['vCc'];

            

            $pd = $rsql['iTeamPD'];
            $andev = $rsql['iTeamAndev'];
            $qa = '10';


            $jointeam = $pd.','.$andev.','.$qa;
            $toEmail = $this->lib_utilitas->get_nip_team( $jointeam );
            $to = $to.','.$toEmail;
            $cc = $cc.','.$this->user->gNIP;                        

            $subject = 'Reformulasi - Approval Uji Mikro BB '.$rsql['vRo_no'];
            $content="
                Diberitahukan bahwa telah ada Approval Uji Mikro BB dengan rincian sebagai berikut :<br><br>  
                    <table border='0' style='width: 600px;'>
                        <tr>
                                <td style='width: 110px;'><b>Penguji</b></td><td style='width: 20px;'> : </td>
                                <td>".$rsql['cNip'].' || '.$rsql['vName']."</td>
                        </tr>
                        <tr>
                                <td><b>No Request Sample  </b></td><td> : </td>
                                <td>".$rsql['vRequest_no']."</td>
                        </tr> 
                        <tr>
                                <td><b>Nama Bahan baku  </b></td><td> : </td>
                                <td>".$rsql['vnama']."</td>
                        </tr> 
                        <tr>
                                <td><b>Tanggal Pengujian  </b></td><td> : </td>
                                <td>".$rsql['dMulai_uji']." s/d".$rsql['dSelesai_uji']."</td>
                        </tr> 
                    </table> 

                <br/> <br/>
                Demikian, mohon segera follow up  pada aplikasi ERP Reformulasi. Terimakasih.<br><br><br>
                Post Master"; 

            $this->sess_auth->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
        }




		$data['status']  = true;
		$data['last_id'] = $post['iexport_uji_mikro_bb'];
		return json_encode($data);


	}

	function before_insert_processor($row, $postData) {

		// ubah status submit
		
			if($postData['isdraft']==true){
				$postData['iSubmit']=0;
			} 
			else{
				$postData['iSubmit']=1;
				
                        


			} 
		
		$postData['dCreate'] = date('Y-m-d H:i:s');
		$postData['cCreated'] =$this->user->gNIP;
		
		return $postData;

	}

	function before_update_processor($row, $postData) {
	
		// ubah status submit
		if($postData['isdraft']==true){
			$postData['iSubmit']=0;
		} 
		else{$postData['iSubmit']=1;} 
		$postData['dupdate'] = date('Y-m-d H:i:s');
		$postData['cUpdate'] =$this->user->gNIP;
		
		return $postData;

	}

	function after_insert_processor($fields, $id, $postData) {
		$post = $this->input->post();

		
            

        $qsql="
        		SELECT export_req_refor.iTeamPD,export_req_refor.iTeamAndev
				,a.*,b.*,export_request_sample.vRequest_no,plc2_raw_material.vnama
				FROM (`reformulasi`.`export_request_sample_detail`)
				INNER JOIN `reformulasi`.`export_request_sample` ON `export_request_sample`.`iexport_request_sample` = `export_request_sample_detail`.`iexport_request_sample`
				INNER JOIN `reformulasi`.`export_ro_detail` ON `export_ro_detail`.`iexport_request_sample_detail` = `export_request_sample_detail`.`iexport_request_sample_detail`
				INNER JOIN `reformulasi`.`export_ro` ON `export_ro`.`iexport_ro` = `export_ro_detail`.`iexport_ro`
				INNER JOIN `plc2`.`plc2_raw_material` ON `plc2_raw_material`.`raw_id` = `export_request_sample_detail`.`raw_id`
				INNER JOIN `reformulasi`.`export_req_refor` ON `export_req_refor`.`iexport_req_refor` = `export_request_sample`.`iexport_req_refor`
				INNER JOIN `dossier`.`dossier_upd` ON `dossier_upd`.`idossier_upd_id` = `export_req_refor`.`idossier_upd_id`
				join reformulasi.export_uji_mikro_bb a on a.iexport_request_sample_detail=export_request_sample_detail.iexport_request_sample_detail
				join hrd.employee b on b.cNip=a.cPic_uji
				WHERE `reformulasi`.`export_ro_detail`.`iUji_mikro` =  2
				and  a.iexport_uji_mikro_bb = '".$id."'

        ";
        $rsql = $this->db->query($qsql)->row_array();
        if ($rsql['iSubmit']) {
            // kirim notifikasi message ERp
            $sqlEmpAr = 'select * from reformulasi.mailsparam a where a.cVariable="export_uji_mikro_bb_submit "';
            $dEmpAr =  $this->db->query($sqlEmpAr)->row_array();

               

            $to = $dEmpAr['vTo'];
            $cc = $dEmpAr['vCc'];

            

            $pd = $rsql['iTeamPD'];
            $andev = $rsql['iTeamAndev'];
            $qa = '10';


            $jointeam = $pd.','.$andev.','.$qa;
            $toEmail = $this->lib_utilitas->get_nip_team( $jointeam );
            $to = $to.','.$toEmail;
            $cc = $cc.','.$this->user->gNIP;                        

            $subject = 'Reformulasi - New Uji Mikro BB '.$rsql['vnama'];
            $content="
                Diberitahukan bahwa telah ada Submitted Uji Mikro BB dengan rincian sebagai berikut :<br><br>  
                    <table border='0' style='width: 600px;'>
                        <tr>
                                <td style='width: 110px;'><b>Penguji</b></td><td style='width: 20px;'> : </td>
                                <td>".$rsql['cNip'].' || '.$rsql['vName']."</td>
                        </tr>
                        <tr>
                                <td><b>No Request Sample  </b></td><td> : </td>
                                <td>".$rsql['vRequest_no']."</td>
                        </tr> 
                        <tr>
                                <td><b>Nama Bahan baku  </b></td><td> : </td>
                                <td>".$rsql['vnama']."</td>
                        </tr> 
                        <tr>
                                <td><b>Tanggal Pengujian  </b></td><td> : </td>
                                <td>".$rsql['dMulai_uji']." s/d".$rsql['dSelesai_uji']."</td>
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

		$qsql="
        		SELECT export_req_refor.iTeamPD,export_req_refor.iTeamAndev
				,a.*,b.*,export_request_sample.vRequest_no,plc2_raw_material.vnama
				FROM (`reformulasi`.`export_request_sample_detail`)
				INNER JOIN `reformulasi`.`export_request_sample` ON `export_request_sample`.`iexport_request_sample` = `export_request_sample_detail`.`iexport_request_sample`
				INNER JOIN `reformulasi`.`export_ro_detail` ON `export_ro_detail`.`iexport_request_sample_detail` = `export_request_sample_detail`.`iexport_request_sample_detail`
				INNER JOIN `reformulasi`.`export_ro` ON `export_ro`.`iexport_ro` = `export_ro_detail`.`iexport_ro`
				INNER JOIN `plc2`.`plc2_raw_material` ON `plc2_raw_material`.`raw_id` = `export_request_sample_detail`.`raw_id`
				INNER JOIN `reformulasi`.`export_req_refor` ON `export_req_refor`.`iexport_req_refor` = `export_request_sample`.`iexport_req_refor`
				INNER JOIN `dossier`.`dossier_upd` ON `dossier_upd`.`idossier_upd_id` = `export_req_refor`.`idossier_upd_id`
				join reformulasi.export_uji_mikro_bb a on a.iexport_request_sample_detail=export_request_sample_detail.iexport_request_sample_detail
				join hrd.employee b on b.cNip=a.cPic_uji
				WHERE `reformulasi`.`export_ro_detail`.`iUji_mikro` =  2
				and  a.iexport_uji_mikro_bb = '".$id."'

        ";
        $rsql = $this->db->query($qsql)->row_array();
        if ($rsql['iSubmit']) {
            // kirim notifikasi message ERp
            $sqlEmpAr = 'select * from reformulasi.mailsparam a where a.cVariable="export_uji_mikro_bb_submit "';
            $dEmpAr =  $this->db->query($sqlEmpAr)->row_array();

               

            $to = $dEmpAr['vTo'];
            $cc = $dEmpAr['vCc'];

            

            $pd = $rsql['iTeamPD'];
            $andev = $rsql['iTeamAndev'];
            $qa = '10';


            $jointeam = $pd.','.$andev.','.$qa;
            $toEmail = $this->lib_utilitas->get_nip_team( $jointeam );
            $to = $to.','.$toEmail;
            $cc = $cc.','.$this->user->gNIP;                        

            $subject = 'Reformulasi - New Uji Mikro BB '.$rsql['vnama'];
            $content="
                Diberitahukan bahwa telah ada Submitted Uji Mikro BB dengan rincian sebagai berikut :<br><br>  
                    <table border='0' style='width: 600px;'>
                        <tr>
                                <td style='width: 110px;'><b>Penguji</b></td><td style='width: 20px;'> : </td>
                                <td>".$rsql['cNip'].' || '.$rsql['vName']."</td>
                        </tr>
                        <tr>
                                <td><b>No Request Sample  </b></td><td> : </td>
                                <td>".$rsql['vRequest_no']."</td>
                        </tr> 
                        <tr>
                                <td><b>Nama Bahan baku  </b></td><td> : </td>
                                <td>".$rsql['vnama']."</td>
                        </tr> 
                        <tr>
                                <td><b>Tanggal Pengujian  </b></td><td> : </td>
                                <td>".$rsql['dMulai_uji']." s/d".$rsql['dSelesai_uji']."</td>
                        </tr> 
                    </table> 

                <br/> <br/>
                Demikian, mohon segera follow up  pada aplikasi ERP Reformulasi. Terimakasih.<br><br><br>
                Post Master"; 

            $this->sess_auth->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
        }

	}


	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$tempat = $_GET['path'];
		$path = file_get_contents('./files/reformulasi/export/export_uji_mikro_bb/'.$tempat.'/'.$id.'/'.$name);	
		force_download($name, $path);
	}

	function readDirektory($path, $empty="") {
		$filename = array();
				
		if (empty($empty)) {
			if ($handle = opendir($path)) {		
				while (false !== ($entry = readdir($handle))) {
				   if ($entry != '.' && $entry != '..' && $entry != '.svn') {			   		
						//unlink($path."/".$entry);
						$filename[] = $entry;
					}
				}		
				closedir($handle);
			}
				
			$x =  $filename;
		} else {
			if ($handle = opendir($path)) {		
				while (false !== ($entry = readdir($handle))) {
				   if ($entry != '.' && $entry != '..' && $entry != '.svn') {			   		
						//echo $path."/".$entry;
						unlink($path."/".$entry);					
					}
				}		
				closedir($handle);
			}
			
			$x = "";
		}
		
		return $x;
	}

	function hapusfile($path, $file_name, $table, $lastId){
		$path = $path."/".$lastId;
		$path = str_replace("\\", "/", $path);
		//echo 'aa : '.$file_name;
		//
		if (is_array($file_name)) {
						
			$list_dir  = $this->readDirektory($path);
			$list_sql  = $this->readSQL($table, $lastId);
			asort($file_name);		
			asort($list_dir);		
			asort($list_sql);
			
			//print_r($list_dir);
			//print_r($list_sql);
			//print_r($file_name);
			//$del = array();
			foreach($list_dir as $v) {				
				if (!in_array($v, $file_name)) {				
					unlink($path.'/'.$v);	
				}			
			}
			foreach($list_sql as $v) {
				if (!in_array($v, $file_name)) {				
					$del = "delete from plc2.".$table." where iexport_uji_mikro_bb = {$lastId} and filename= '{$v}'";
					mysql_query($del);	
				}
				
			}
			
			//print_r($del);
			//exit;
		} else {
			$this->readDirektory($path, 1);
			$this->readSQL($table, $lastId, 1);
		}
	} 

	function readSQL($table, $lastId, $empty="") {
		$list_file = array();
		if (empty($empty)) {
			$sql = "SELECT filename from plc2.".$table." where iexport_uji_mikro_bb=".$lastId;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['filename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT filename from plc2.".$table." where iexport_uji_mikro_bb=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM plc2.".$table." where iexport_uji_mikro_bb=".$lastId." and filename='".$row['filename']."'";			
			}
			
			foreach($sql2 as $q) {
				try {
					mysql_query($q);
				}catch(Exception $e) {
					die($e);
				}
			}
			
		  $x = "";
		}
		
		return $x;
	} 


    public function output(){
            $this->index($this->input->get('action'));
    }
}







