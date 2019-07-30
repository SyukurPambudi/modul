<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class draft_soi_bb extends MX_Controller {
	private $sess_auth;
	private $dbset;
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
        $this->load->library('biz_process');
        $this->load->library('lib_utilitas');
		$this->user = $this->auth->user(); 
		$this->dbset = $this->load->database('plc0',false, true);
		
    }
    function index($action = '') {
    	$action = $this->input->get('action');
		
    	//Bikin Object Baru Nama nya $grid	

        $grid = new Grid;		
        $grid->setUrl('draft_soi_bb');
        $grid->setTitle('Draft SOI BB');		
        $grid->setTable('plc2.draft_soi_bb');		
        $grid->setUrl('draft_soi_bb');
     //   $grid->addList('plc2_upb_request_sample.vupb_nomor','plc2_raw_material.vupb_nama','vNoDraft','iSubmit','iApprove');
	    $grid->addList('vNoDraft','plc2_upb.vupb_nomor','plc2_upb.vupb_nama');
        $grid->addFields('iApprove','ireqdet_id','iupb_id','vupb_nama','vgenerik','team_pd','vNoDraft','dMulai_draft','dSelesai_draft','file_filename','cPenyusun');//,'iHasil_uji','iUji_spesifik','file_literatur','file_filename');
        $grid->setSortBy('idraft_soi_bb');
        $grid->setSortOrder('DESC'); //sort ordernya
		
		//align & width
		$grid->setLabel('iApprove', 'Status Approval'); //Ganti Label
        $grid->setAlign('iApprove', 'Center'); //Align nya
        $grid->setWidth('iApprove', '50'); // width nya
		
		$grid->setLabel('vupb_nama', 'Nama UPB'); //Ganti Label
		$grid->setLabel('vgenerik', 'Nama Generik'); //Ganti Label
		$grid->setLabel('team_pd', 'Team PD'); //Ganti Label
		$grid->setLabel('file_filename', 'Upload Laporan '); //Ganti Label
		$grid->setLabel('file_literatur', 'Upload Laporan Study Literatur'); //Ganti Label
		
		$grid->setLabel('vNoDraft', 'No Draft'); //Ganti Label
		$grid->setAlign('vNoDraft', 'Center'); //Align nya
        $grid->setWidth('vNoDraft', '100'); // width nya
	
		$grid->setLabel('ireqdet_id', 'Bahan Baku'); //Ganti Label
		$grid->setLabel('iupb_id', 'No UPB'); //Ganti Label
		$grid->setLabel('plc2_upb.vupb_nomor', 'No UPB'); //Ganti Label
        $grid->setAlign('plc2_upb.vupb_nomor', 'center'); //Align nya
        $grid->setWidth('plc2_upb.vupb_nomor', '80'); // width nya

        $grid->setLabel('plc2_upb.vupb_nama', 'Nama UPB'); //Ganti Label
        $grid->setAlign('plc2_upb.vupb_nama', 'center'); //Align nya
        $grid->setWidth('plc2_upb.vupb_nama', '200'); // width nya
		
		$grid->setLabel('vNoDraft', 'No Draft'); //Ganti Label
        $grid->setAlign('vNoDraft', 'right'); //Align nya
        $grid->setWidth('vNoDraft', '100'); // width nya

        $grid->setLabel('iSubmit', 'Status Submit'); //Ganti Label
        $grid->setAlign('iSubmit', 'center'); //Align nya
        $grid->setWidth('iSubmit', '100'); // width nya

        $grid->setLabel('iApprove', 'Status Approval'); //Ganti Label
        $grid->setAlign('iApprove', 'center'); //Align nya
        $grid->setWidth('iApprove', '150'); // width nya

        $grid->setLabel('dMulai_literatur', 'Tanggal Mulai Study Literatur '); //Ganti Label
        $grid->setAlign('dMulai_literatur', 'left'); //Align nya
        $grid->setWidth('dMulai_literatur', '50'); // width nya

        $grid->setLabel('dSelesai_literatur', 'Tanggal Selesai Study Literatur '); //Ganti Label
        $grid->setAlign('dSelesai_literatur', 'left'); //Align nya
        $grid->setWidth('dSelesai_literatur', '50'); // width nya

        $grid->setLabel('dMulai_draft', 'Mulai Pembuatan Draft'); //Ganti Label
        $grid->setAlign('dMulai_draft', 'left'); //Align nya
        $grid->setWidth('dMulai_draft', '50'); // width nya

        $grid->setLabel('dSelesai_draft', 'Selesai Pembuatan Draft'); //Ganti Label
        $grid->setAlign('dSelesai_draft', 'left'); //Align nya
        $grid->setWidth('dSelesai_draft', '50'); // width nya
		
		$grid->setLabel('cPenyusun', 'Penyusun'); //Ganti Label
        $grid->setAlign('cPenyusun', 'left'); //Align nya
        $grid->setWidth('cPenyusun', '50'); // width nya        
		
		$grid->setLabel('iHasil_uji', 'Hasil Pengujian Mikro BB'); //Ganti Label
        $grid->setAlign('iHasil_uji', 'left'); //Align nya
        $grid->setWidth('iHasil_uji', '50'); // width nya

        $grid->setLabel('iUji_spesifik', 'Perlu Uji Spesifik'); //Ganti Label
		//set search
        $grid->setSearch('plc2_upb.vupb_nomor', 'plc2_upb.vupb_nama','vNoDraft');
		
		//set required
        $grid->setRequired('ireqdet_id', 'vNoDraft','iHasil_uji','iUji_spesifik','dMulai_draft','dSelesai_draft');	//Field yg mandatori

        $grid->setGridView('grid');

        $grid->changeFieldType('iSubmit','combobox','',array('0'=>'Draft','1'=>'Submitted'));
        $grid->changeFieldType('iHasil_uji','combobox','',array(''=>'Select One','1'=>'Gagal','2'=>'Berhasil'));
        $grid->changeFieldType('iUji_spesifik','combobox','',array(''=>'Select One','1'=>'Ya','0'=>'Tidak'));

        
        $grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = draft_soi_bb.iupb_id', 'inner');
     //   $grid->setJoinTable('plc2.plc2_upb_request_sample', 'plc2_upb_request_sample.ireq_id = plc2_upb_request_sample_detail.ireq_id', 'inner');
     //   $grid->setJoinTable('plc2.plc2_raw_material', 'plc2_raw_material.raw_id = plc2_upb_request_sample_detail.raw_id', 'inner');
        $grid->changeFieldType('iApprove','combobox','',array(''=>'--Select--',0=>'Waiting Approval',1=>'Rejected', 2=>'Approved'));

        $grid->setQuery('draft_soi_bb.lDeleted', 0);	
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
							$path = realpath("files/plc/local/draft_soi_bb/rpt_draft_soi_bb/");
							
							if (!mkdir($path."/".$this->input->get('lastId'), 0777, true)) {
							    die('Failed upload, try again!');
							}
							
							
							$file_keterangan = array();
							foreach($_POST as $key=>$value) {						
								if ($key == 'fileketerangan') {
									foreach($value as $k=>$v) {
										$file_keterangan[$k] = $v;
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
										$sql[] = "INSERT INTO draft_soi_bb_file(idraft_soi_bb, filename, dInsertDate, keterangan,cInsert) 
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
						$path = realpath("files/plc/local/draft_soi_bb/rpt_draft_soi_bb/");
				
						if (!file_exists( $path."/".$this->input->post('draft_soi_bb_idraft_soi_bb') )) {
							mkdir($path."/".$this->input->post('draft_soi_bb_idraft_soi_bb'), 0777, true);						 
						}

				
						$file_keterangan = array();
				
						foreach($_POST as $key=>$value) {
													
							if ($key == 'fileketerangan') {
								foreach($value as $y=>$u) {
									$file_keterangan[$y] = $u;
								}
							}
							
							
							
							//
							if ($key == 'namafile') {
								foreach($value as $k=>$v) {
									$file_name[$k] = $v;
								}
							}
							
							
							
							//
							if ($key == 'fileid') {
								foreach($value as $k=>$v) {
									$fileId[$k] = $v;
								}
							}
							
							
						}
				
				
						$last_index = 0;
						
				
						if($isUpload) {
							$j = $last_index;				
														
							if (isset($_FILES['fileupload'])) {
								$this->hapusfile($path, $file_name, 'draft_soi_bb_file', $this->input->post('draft_soi_bb_idraft_soi_bb'));
								foreach ($_FILES['fileupload']["error"] as $key => $error) {	
									if ($error == UPLOAD_ERR_OK) {
										$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
										$name = $_FILES['fileupload']["name"][$key];
										$data['filename'] = $name;
										$data['id']=$this->input->post('draft_soi_bb_idraft_soi_bb');
										$data['nip']=$this->user->gNIP;
										//$data['iupb_id'] = $insertId;
										$data['dInsertDate'] = date('Y-m-d H:i:s');
						 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
						 				if(move_uploaded_file($tmp_name, $path."/".$this->input->post('draft_soi_bb_idraft_soi_bb')."/".$name)) 
						 				{				 					
											$sql[] = "INSERT INTO draft_soi_bb_file(idraft_soi_bb, filename, dInsertDate, keterangan,cInsert) 
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
							
							
							$r['status'] = TRUE;
							$r['last_id'] = $this->input->get('lastId');					
							echo json_encode($r);
							exit();
						}  else {
							if (is_array($file_name)) {									
								$this->hapusfile($path, $file_name, 'draft_soi_bb_file', $this->input->post('draft_soi_bb_idraft_soi_bb'));
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
				case 'getdetilupb':
					echo $this->getdetilupb();
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
	 	$mydept = $this->auth->my_depts(TRUE);
	 	$x = $this->auth->my_teams();
		$array = explode(',', $x);

		if (isset($mydept)) {
			if((in_array('PD', $mydept)) ) {
				if ($row->iSubmit<>0) {
					if($this->auth->is_manager()){
						if ($row->iApprove<>0) {
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
    function insertBox_draft_soi_bb_iApprove($field, $id) {
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

	function updateBox_draft_soi_bb_iApprove($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = 'select * 
						from plc2.draft_soi_bb a 
						join hrd.employee b on b.cNip=a.cApproval
						where
						a.lDeleted = 0
						and  a.idraft_soi_bb = "'.$rowData['idraft_soi_bb'].'"';
			$row = $this->db_plc0->query($sql_dtapp)->row_array();
			if($value==2){
				$st='<p style="color:green;font-size:120%;">Approved';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApproval'].'</br> Alasan: '.$row['vRemark'].'</p>';
			}
			elseif($value==1){
				$st='<p style="color:red;font-size:120%;">Rejected';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApproval'].'</br> Alasan: '.$row['vRemark'].'</p>';
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

	function insertBox_draft_soi_bb_ireqdet_id($field, $id) {
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
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="25" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upb/draft/soi/?field=draft_soi_bb\',\'List UPB\')" type="button">&nbsp;</button>';                
		
		return $return;
	}

	function updateBox_draft_soi_bb_ireqdet_id($field, $id, $value, $rowData) {
		//$data_upb = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$value))->row_array();
		$sql='
			select b.vreq_nomor,c.vnama
			from plc2.plc2_upb_request_sample_detail a 
			join plc2.plc2_upb_request_sample b on b.ireq_id=a.ireq_id
			join plc2.plc2_raw_material c on c.raw_id=a.raw_id
			where a.ireqdet_id="'.$rowData['ireqdet_id'].'" ';
		$data_req = $this->dbset->query($sql)->row_array();

		if ($this->input->get('action') == 'view') {
			$return= $data_req['vreq_nomor'].' - '.$data_req['vnama'] ;

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
			$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="45" value="'.$data_req['vreq_nomor'].' - '.$data_req['vnama'].'"/>';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upb/draft/soi/?field=draft_soi_bb\',\'List Bahan Baku\')" type="button">&nbsp;</button>';                
			

			
			}else{
				$return= $data_req['vreq_nomor'].' - '.$data_req['vnama'] ;
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			}
			
			//$return= $data_upb['vNo_upi'];
		}
		
		return $return;
	}

	function insertBox_draft_soi_bb_iupb_id($field, $id) {
		//$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  disabled="disabled" class="input_rows1 required" size="35" />';
		$return = '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required"  />';
		$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="15" />';
		return $return;
	}
	//,'vupb_nama','manuf',''
	function updateBox_draft_soi_bb_iupb_id($field, $id, $value, $rowData) {
		$data_upb = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();

		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vupb_nama'];

		}
		else{
			$return = '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="15" value="'.$data_upb['vupb_nomor'].'"/>';
		}
		return $return;
	}


	function insertBox_draft_soi_bb_vupb_nama($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  disabled="disabled" class="input_rows1 required" size="35" />';
		return $return;
	}
	//,'vupb_nama','manuf',''
	function updateBox_draft_soi_bb_vupb_nama($field, $id, $value, $rowData) {
		$data_upb = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();

		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vupb_nama'];

		}
		else{
			$return = '<input type="text" name="'.$field.'" disabled="disabled" id="'.$id.'" value="'.$data_upb['vupb_nama'].'" class="input_rows1 required" size="35" />';
		}
		return $return;
	}

	function insertBox_draft_soi_bb_vgenerik($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  disabled="disabled" class="input_rows1 required" size="30" />';
		return $return;
	}
	//,'vupb_nama','manuf','vgenerik'
	function updateBox_draft_soi_bb_vgenerik($field, $id, $value, $rowData) {
		$data_upb = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();

		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vgenerik'];

		}
		else{
			$return = '<input type="text" name="'.$field.'" disabled="disabled" id="'.$id.'" value="'.$data_upb['vgenerik'].'" class="input_rows1 required" size="30" />';
		}
		return $return;
	}

	function insertBox_draft_soi_bb_team_pd($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  disabled="disabled" class="input_rows1 required" size="20" />';
		return $return;
	}
	//,'vupb_nama','manuf','vgenerik'
	function updateBox_draft_soi_bb_team_pd($field, $id, $value, $rowData) {
		$data_upb = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$data_pd = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$data_upb['iteampd_id']))->row_array();

		if ($this->input->get('action') == 'view') {
			$return= $data_pd['vteam'];

		}
		else{
			$return = '<input type="text" name="'.$field.'" disabled="disabled" id="'.$id.'" value="'.$data_pd['vteam'].'" class="input_rows1 required" size="20" />';
		}
		return $return;
	}	

	function insertBox_draft_soi_bb_vNoDraft($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" input_rows1 required" size="8" />
		<input type="hidden" name="isdraft" id="isdraft">';
		return $return;
	}

	function updateBox_draft_soi_bb_vNoDraft($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="8" />
			<input type="hidden" name="isdraft" id="isdraft">';
		}
		return $return;
	}


	function insertBox_draft_soi_bb_dMulai_draft($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" tanggal input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_draft_soi_bb_dMulai_draft($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="tanggal input_rows1 required" size="8" />';
		}
		return $return;
	}

	function insertBox_draft_soi_bb_dSelesai_draft($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" tanggal input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_draft_soi_bb_dSelesai_draft($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="tanggal input_rows1 required" size="8" />';
		}
		return $return;
	}		

	function insertBox_draft_soi_bb_cPenyusun($field, $id) {
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/pic/?field=draft_soi_bb&pic_for=draft_soi_bb&idfield='.$field.'\',\'List PIC\')" type="button">&nbsp;</button>';                
		
		return $return;
	}

	function updateBox_draft_soi_bb_cPenyusun($field, $id, $value, $rowData) {
		$emp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cPenyusun']))->row_array();
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
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/pic/?field=draft_soi_bb&pic_for=draft_soi_bb&idfield='.$field.'\',\'List PIC\')" type="button">&nbsp;</button>';                
			

			
			}else{
				$return= $emp['cNip'].' - '.$emp['vName'];
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			}
			
		}
		
		return $return;
	}

	function insertBox_draft_soi_bb_file_filename() {
		$data['mydept'] = $this->auth->my_depts(TRUE);	
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('lokal/draft_soi_bb_file',$data,TRUE); 
	}

	function updateBox_draft_soi_bb_file_filename($field, $id, $value, $rowData) {
		if (!empty($_GET['idnya'])) {
			$idraft_soi_bb = $_GET['idnya'];
		}else{
			$idraft_soi_bb = $rowData['idraft_soi_bb'];
		}
		$data['mydept'] = $this->auth->my_depts(TRUE);
		$data['rows'] = $this->db_plc0->get_where('plc2.draft_soi_bb_file', array('idraft_soi_bb'=>$idraft_soi_bb))->result_array();
		return $this->load->view('lokal/draft_soi_bb_file',$data,TRUE);				
	}	

	
// end manipulate     

	function manipulate_insert_button($buttons) {
		unset($buttons['save']);

		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'draft_soi_bb\', \''.base_url().'processor/plc/draft/soi/bb?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_draft_soi_bb">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'draft_soi_bb\', \''.base_url().'processor/plc/draft/soi/bb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_draft_soi_bb">Save &amp; Submit</button>';
		$js = $this->load->view('lokal/draft_soi_bb_js');
		$buttons['save'] = $save_draft.$save.$js;

		return $buttons;
	}

	function manipulate_update_button($buttons, $rowData) {
		$mydept = $this->auth->my_depts(TRUE);
		$cNip= $this->user->gNIP;
		$js = $this->load->view('lokal/draft_soi_bb_js');
		
		$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/draft/soi/bb?action=approve&idraft_soi_bb='.$rowData['idraft_soi_bb'].'&cNip='.$cNip.'&lvl=2&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_draft_soi_bb">Confirm</button>';
		$update = '<button onclick="javascript:update_btn_back(\'draft_soi_bb\', \''.base_url().'processor/plc/draft/soi/bb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_draft_soi_bb">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'draft_soi_bb\', \''.base_url().'processor/plc/draft/soi/bb?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_draft_soi_bb">Update as Draft</button>';



		if ($this->input->get('action') == 'view') {unset($buttons['update']);}

		else{
			
			unset($buttons['update_back']);
			unset($buttons['update']);
			
			if ($rowData['iSubmit']== 0) {
				// jika masih draft , show button update draft & update submit 
				if (isset($mydept)) {
					// cek punya dep
					if((in_array('PD', $mydept))) {
						$buttons['update'] = $update.$updatedraft.$js;
					}
				}

			}else{
				// sudah disubmit , show button approval 
				if ($rowData['iApprove']==0) {
					// jika approval bdirm 0 
					if (isset($mydept)) {
						if((in_array('PD', $mydept))) {
							if($this->auth->is_manager()){
								$buttons['update'] = $approve.$js;	
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
								var url = "'.base_url().'processor/plc/draft/soi/bb";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_draft_soi_bb").html(data);
										 $("#button_approve_draft_soi_bb").hide();
										 $("#button_reject_draft_soi_bb").hide();
									});
									
								}
									reload_grid("grid_draft_soi_bb");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Confirm</h1><br />';
		$echo .= '<form id="form_draft_soi_bb_approve" action="'.base_url().'processor/plc/draft/soi/bb?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idraft_soi_bb" value="'.$this->input->get('idraft_soi_bb').'" />
				<input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_draft_soi_bb_approve\')">Confirm</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idraft_soi_bb = $post['idraft_soi_bb'];
		$lvl = $post['lvl'];
		$vRemark = $post['vRemark'];

		
		$data=array('iApprove'=>'2','cApproval'=>$cNip , 'dApproval'=>date('Y-m-d H:i:s'), 'vRemark'=>$vRemark);
		$this -> db -> where('idraft_soi_bb', $idraft_soi_bb);
		$updet = $this -> db -> update('plc2.draft_soi_bb', $data);

		$data['status']  = true;
		$data['last_id'] = $post['idraft_soi_bb'];
		return json_encode($data);

/*
		$logged_nip =$this->user->gNIP;
		$qupi="select a.idraft_soi_bb,a.vNo_upi,a.dTgl_upi,a.cPengusul_upi,a.vupb_nama_usulan,a.vKekuatan,a.vDosis,a.vupb_nama_generik,a.vIndikasi 
				,a.iSubmit_upi,
				(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdirm,
				(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='DR' and te.ldeleted=0) as dr,
				b.cNip,b.vName
				from plc2.daftar_upi a 
				join hrd.employee b on b.cNip=a.cPengusul_upi
				where a.lDeleted=0
				and a.idraft_soi_bb = '".$id."'";
		$rupd = $this->db_plc0->query($qupi)->row_array();

		$iApprove_bdirm = $rupd['iApprove_bdirm'] ;

		if ($iApprove_bdirm == 2) {
			$bdirm = $rupd['bdirm'];
			$dr = $rupd['dr'];

		//$team = $bdirm;
			$team = $bdirm. ','.$dr;
			//$team = '81' ;

	        $toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_team( $team );
	        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
	        $arrEmail = $this->lib_utilitas->get_email_by_nip( $logged_nip );                    
	                    
			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($toEmail);
				$to = $toEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
				}
			}	

			$to = $toEmail2.';'.$toEmail;
			$cc = $arrEmail;                        

			//$to = $arrEmail;
			//$cc = $toEmail2.';'.$toEmail;                        

				$subject="Approval : Daftar UPI ".$rupd['vNo_upi'];
				$content="Diberitahukan bahwa telah ada Input Daftar UPI pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>No UPI</b></td><td style='width: 20px;'> : </td><td>".$rupd['vNo_upi']."</td>
							</tr>
							<tr>
								<td><b>Tanggal UPI</b></td><td> : </td><td>".$rupd['dTgl_upi']."</td>
							</tr>
							<tr>
								<td><b>Diinput oleh</b></td><td> : </td><td>".$rupd['cNip'].' - '.$rupd['vName']."</td>
							</tr>
							<tr>
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vupb_nama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Kekuatan</b></td><td> : </td><td>".$rupd['vKekuatan']."</td>
							</tr>
							<tr>
								<td><b>Dosis</b></td><td> : </td><td> ".$rupd['vDosis']."</td>
							</tr>
							<tr>
								<td><b>Nama Generik</b></td><td> : </td><td>".$rupd['vupb_nama_generik']."</td>
							</tr>
							<tr>
								<td><b>Indikasi</b></td><td> : </td><td><p> ".$rupd['vIndikasi']."</p></td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}
*/
	}


	function before_insert_processor($row, $postData) {

		// ubah status submit
		
			if($postData['isdraft']==true){
				$postData['iSubmit']=0;
			} 
			else{$postData['iSubmit']=1;} 
		
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

	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$tempat = $_GET['path'];
		//$path = file_get_contents('./files/plc/local/draft_soi_bb/'.$tempat.'/'.$id.'/'.$name);	
		$path = file_get_contents('./files/plc/local/draft_soi_bb/rpt_draft_soi_bb/'.$id.'/'.$name);	
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
					$del = "delete from plc2.".$table." where idraft_soi_bb = {$lastId} and filename= '{$v}'";
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
			$sql = "SELECT filename from plc2.".$table." where idraft_soi_bb=".$lastId;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['filename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT filename from plc2.".$table." where idraft_soi_bb=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM plc2.".$table." where idraft_soi_bb=".$lastId." and filename='".$row['filename']."'";			
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


	function getdetilupb(){
		$upb_id=$_POST['upb_id'];
		$data = array();

		$sql2 = "select *
			from plc2.plc2_upb a 
			where a.ldeleted = 0 and a.iupb_id='".$upb_id."'";
		$data2 = $this->dbset->query($sql2)->row_array();
	 	
	 	$row_array['vupb_nomor'] = trim($data2['vupb_nomor']);
		$row_array['vupb_nama'] = trim($data2['vupb_nama']);
		$row_array['ttanggal'] = trim($data2['ttanggal']);

		
		$rowse = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$data2['cnip'],'ldeleted'=>0))->row_array();
		$val=$rowse['cNip'].' - '.$rowse['vName'];
		$row_array['cnip'] = trim($val);

		$row_array['vupb_nama'] = trim($data2['vupb_nama']);
		$row_array['dosis'] = trim($data2['dosis']);
		$row_array['vgenerik'] = trim($data2['vgenerik']);
		

		$val=$data2['iteambusdev_id'];
		$sql = "SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = 'BD' AND t.ldeleted = '0' AND t.iteam_id  = ".$val." ";
		$teams = $this->db_plc0->query($sql)->row_array();
		$row_array['iteambusdev_id'] = trim($teams['vteam']);
		$row_array['id_teambd'] = trim($data2['iteambusdev_id']);

		$val=$data2['iteampd_id'];
		$sql = "SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = 'PD' AND t.ldeleted = '0' AND t.iteam_id  = ".$val." ";
		$teams = $this->db_plc0->query($sql)->row_array();
		$row_array['iteampd_id'] = trim($teams['vteam']);
		$row_array['id_teampd'] = trim($data2['iteampd_id']);

		$val=$data2['iteammarketing_id'];
		$sql = "SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = 'MR' AND t.ldeleted = '0' AND t.iteam_id  = ".$val." ";
		$teams = $this->db_plc0->query($sql)->row_array();
		$row_array['iteammarketing_id'] = trim($teams['vteam']);

		

	 	
	 	array_push($data, $row_array);
	 	echo json_encode($data);
	    exit;
	}


    public function output(){
            $this->index($this->input->get('action'));
    }
}







