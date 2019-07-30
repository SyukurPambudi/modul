<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class draft_soi_mikro_bb extends MX_Controller {
	private $sess_auth_localnon;
	private $dbset;
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
        $this->load->library('biz_process');
        $this->load->library('lib_utilitas');
		$this->user = $this->auth_localnon->user(); 
		$this->dbset = $this->load->database('plc', true);
		
    }
    function index($action = '') {
    	$action = $this->input->get('action');
		
    	//Bikin Object Baru Nama nya $grid	

        $grid = new Grid;		
        $grid->setUrl('draft_soi_mikro_bb');
        $grid->setTitle('Draft SOI Mikro BB');		
        $grid->setTable('plc2.uji_mikro_bb');		
        $grid->setUrl('draft_soi_mikro_bb');
        $grid->addList('plc2_upb_request_sample.vreq_nomor','plc2_raw_material.vnama','iJumlah_terima','iSubmit','iApprove_draft');
        $grid->addFields('iApprove_draft','ireqdet_id','no_po','no_upb','iJumlah_terima','dMulai_literatur','dSelesai_literatur','dMulai_uji','dSelesai_uji','cPic_uji','iHasil_uji','iUji_spesifik','dMulai_draft_soi','dSelesai_draft_soi','cPic_draft_soi','draft_soi_mikro');
        $grid->setSortBy('iuji_mikro_bb');
        $grid->setSortOrder('DESC'); //sort ordernya
		
		//align & width
		$grid->setLabel('iApprove_draft', 'Status Approval'); //Ganti Label
        $grid->setAlign('iApprove_draft', 'Center'); //Align nya
        $grid->setWidth('iApprove_draft', '50'); // width nya
		
		$grid->setLabel('no_po', 'No PO'); //Ganti Label
		$grid->setLabel('no_upb', 'No UPB'); //Ganti Label
		$grid->setLabel('file_filename', 'Upload Laporan Pengujian Mikro BB'); //Ganti Label
		$grid->setLabel('file_literatur', 'Upload Laporan Study Literatur'); //Ganti Label
		$grid->setLabel('draft_soi_mikro', 'Upload Draft SOI Mikro BB Spesifik'); //Ganti Label
		$grid->setLabel('dMulai_draft_soi', 'Tanggal Mulai Pembuatan draft SOI BB Spesifik'); //Ganti Label
		$grid->setLabel('dSelesai_draft_soi', 'Tanggal Selesai Pembuatan draft SOI BB Spesifik'); //Ganti Label
		$grid->setLabel('cPic_draft_soi', 'PIC Pembuatan draft SOI Mikro BB Spesifik'); //Ganti Label
		
		
		$grid->setLabel('plc2_upb_request_sample.vreq_nomor', 'No Request'); //Ganti Label
		$grid->setAlign('plc2_upb_request_sample.vreq_nomor', 'Center'); //Align nya
        $grid->setWidth('plc2_upb_request_sample.vreq_nomor', '80'); // width nya

		$grid->setLabel('plc2_raw_material.vnama', 'Nama Bahan Baku'); //Ganti Label
		$grid->setAlign('plc2_raw_material.vnama', 'left'); //Align nya
        $grid->setWidth('plc2_raw_material.vnama', '250'); // width nya




		$grid->setLabel('ireqdet_id', 'Nama Bahan Baku'); //Ganti Label
        $grid->setAlign('ireqdet_id', 'left'); //Align nya
        $grid->setWidth('ireqdet_id', '50'); // width nya
		
		$grid->setLabel('iJumlah_terima', 'Jumlah Terima'); //Ganti Label
        $grid->setAlign('iJumlah_terima', 'right'); //Align nya
        $grid->setWidth('iJumlah_terima', '100'); // width nya

        $grid->setLabel('iSubmit', 'Status Submit'); //Ganti Label
        $grid->setAlign('iSubmit', 'center'); //Align nya
        $grid->setWidth('iSubmit', '100'); // width nya

        $grid->setLabel('iApprove_draft', 'Status Approval'); //Ganti Label
        $grid->setAlign('iApprove_draft', 'center'); //Align nya
        $grid->setWidth('iApprove_draft', '150'); // width nya

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
        $grid->setSearch('plc2_upb_request_sample.vreq_nomor', 'plc2_raw_material.vnama');
		
		//set required
        $grid->setRequired('ireqdet_id', 'iJumlah_terima','iHasil_uji','iUji_spesifik');	//Field yg mandatori

        $grid->setGridView('grid');

        $grid->changeFieldType('iSubmit','combobox','',array('0'=>'Draft','1'=>'Submitted'));
        $grid->changeFieldType('iHasil_uji','combobox','',array(''=>'Select One','1'=>'Gagal','2'=>'Berhasil'));
        $grid->changeFieldType('iUji_spesifik','combobox','',array(''=>'Select One','1'=>'Ya','0'=>'Tidak'));

        
        $grid->setJoinTable('plc2.plc2_upb_request_sample_detail', 'plc2_upb_request_sample_detail.ireqdet_id = uji_mikro_bb.ireqdet_id', 'inner');
        $grid->setJoinTable('plc2.plc2_upb_request_sample', 'plc2_upb_request_sample.ireq_id = plc2_upb_request_sample_detail.ireq_id', 'inner');
        $grid->setJoinTable('plc2.plc2_raw_material', 'plc2_raw_material.raw_id = plc2_upb_request_sample_detail.raw_id', 'inner');
        $grid->changeFieldType('iApprove_draft','combobox','',array(''=>'--Select--',0=>'Waiting Approval',1=>'Rejected', 2=>'Approved'));

        $grid->setQuery('uji_mikro_bb.lDeleted', 0);	

        // yang butuh uji spesifik
        $grid->setQuery('uji_mikro_bb.iUji_spesifik', 1);	
        // sudah approval uji mikro bb
        $grid->setQuery('uji_mikro_bb.iApprove_uji', 2);	

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
							$path = realpath("files/plc/local/draft_soi_mikro_bb/rpt_mikro_bb/");
							$path1 = realpath("files/plc/local/draft_soi_mikro_bb/rpt_draft_soi_mikro/");
							
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
										$sql[] = "INSERT INTO uji_mikro_bb_file(iuji_mikro_bb, filename, dInsertDate, keterangan,cInsert) 
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
											$sql1[] = "INSERT INTO file_draft_soi_mikro(iuji_mikro_bb, filename, dInsertDate, keterangan,cInsert) 
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
						$path1 = realpath("files/plc/local/draft_soi_mikro_bb/rpt_draft_soi_mikro/");
					
						if (!file_exists( $path1."/".$this->input->post('draft_soi_mikro_bb_iuji_mikro_bb') )) { 
							mkdir($path1."/".$this->input->post('draft_soi_mikro_bb_iuji_mikro_bb'), 0777, true);					    
						}
				
						$file_keterangan = array();
						$file_keterangan1 = array();
				
						foreach($_POST as $key=>$value) {
													
							
							if ($key == 'fileketerangan1') {
								foreach($value as $y=>$u) {
									$file_keterangan1[$y] = $u;
								}
							}
							
							
						
							if ($key == 'namafile1') {
								foreach($value as $k=>$v) {
									$file_name1[$k] = $v;
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
														
							$a = $last_index1;	
							//upload form 2
							if (isset($_FILES['fileupload1'])) {
								
								$this->hapusfile($path1, $file_name1, 'file_draft_soi_mikro', $this->input->post('draft_soi_mikro_bb_iuji_mikro_bb'));
								foreach ($_FILES['fileupload1']["error"] as $key => $error) {	
									if ($error == UPLOAD_ERR_OK) {
										$tmp_name1 = $_FILES['fileupload1']["tmp_name"][$key];
										$name1 = $_FILES['fileupload1']["name"][$key];
										$data1['filename'] = $name1;
										$data1['id']=$this->input->post('draft_soi_mikro_bb_iuji_mikro_bb');
										$data1['nip']=$this->user->gNIP;
										$data1['dInsertDate'] = date('Y-m-d H:i:s');
						 				if(move_uploaded_file($tmp_name1, $path1."/".$this->input->post('draft_soi_mikro_bb_iuji_mikro_bb')."/".$name1)) 
						 				{
											$sql1[] = "INSERT INTO file_draft_soi_mikro(iuji_mikro_bb, filename, dInsertDate, keterangan,cInsert) 
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
							if (is_array($file_name1)) {									
								$this->hapusfile($path1, $file_name1, 'file_draft_soi_mikro', $this->input->post('draft_soi_mikro_bb_iuji_mikro_bb'));
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
	 	$mydept = $this->auth_localnon->my_depts(TRUE);
	 	$x = $this->auth_localnon->my_teams();
		$array = explode(',', $x);

		if (isset($mydept)) {
			if((in_array('QA', $mydept)) ) {
				if ($row->iSubmit_draft_soi<>0) {
					if($this->auth_localnon->is_manager()){
						if ($row->iApprove_draft<>0) {
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
    function insertBox_draft_soi_mikro_bb_iApprove_draft($field, $id) {
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

	function updateBox_draft_soi_mikro_bb_iApprove_draft($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = 'select * 
						from plc2.uji_mikro_bb a 
						join hrd.employee b on b.cNip=a.cApproval_draft
						where
						a.lDeleted = 0
						and  a.iuji_mikro_bb = "'.$rowData['iuji_mikro_bb'].'"';
			$row = $this->db_plc0->query($sql_dtapp)->row_array();
			if($value==2){
				$st='<p style="color:green;font-size:120%;">Approved';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApproval_draft'].'</br> Alasan: '.$row['vRemark_draft'].'</p>';
			}
			elseif($value==1){
				$st='<p style="color:red;font-size:120%;">Rejected';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApproval_draft'].'</br> Alasan: '.$row['vRemark_draft'].'</p>';
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

	function insertBox_draft_soi_mikro_bb_ireqdet_id($field, $id) {
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/draft/soi/mikro/bb/popup/?field=draft_soi_mikro_bb\',\'List Bahan Baku\')" type="button">&nbsp;</button>';                
		
		return $return;
	}

	function updateBox_draft_soi_mikro_bb_ireqdet_id($field, $id, $value, $rowData) {
		$sql = '
		select a.ireqdet_id,b.vreq_nomor,e.vpo_nomor,f.vro_nomor,g.vnama,a.ijumlah,h.vupb_nomor,h.vupb_nama,a.* ,d.*
		from plc2.plc2_upb_request_sample_detail a
		join plc2.plc2_upb_request_sample b on b.ireq_id=a.ireq_id
		join plc2.plc2_upb_ro_detail d on d.ireq_id=a.ireq_id and d.raw_id=a.raw_id
		join plc2.plc2_upb_po  e on e.ipo_id=d.ipo_id
		join plc2.plc2_upb_ro f on f.iro_id=d.iro_id
		join plc2.plc2_raw_material g on g.raw_id=a.raw_id
		join plc2.plc2_upb h on h.iupb_id=b.iupb_id
		join plc2.uji_mikro_bb i on i.ireqdet_id=a.ireqdet_id
		where 
		a.ldeleted=0
		and b.ldeleted=0
		and d.ldeleted=0
		and e.ldeleted=0
		and f.ldeleted=0
		and g.ldeleted=0
		and h.ldeleted=0
		and i.lDeleted=0
		and i.ireqdet_id
		="'.$value.'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vreq_nomor'].' - '.$data_upb['vnama'];

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
			$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="45" value="'.$data_upb['vreq_nomor'].' - '.$data_upb['vnama'].'"/>';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/draft/soi/mikro/bb/popup/?field=draft_soi_mikro_bb\',\'List Bahan Baku\')" type="button">&nbsp;</button>';                
			

			
			}else{
				$return= $data_upb['vreq_nomor'].' - '.$data_upb['vnama'];
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			}
			
			//$return= $data_upb['vNo_upi'];
		}
		
		return $return;
	}


	function insertBox_draft_soi_mikro_bb_no_po($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  disabled="disabled" class="input_rows1 required" size="8" />';
		return $return;
	}
	//,'no_po','manuf',''
	function updateBox_draft_soi_mikro_bb_no_po($field, $id, $value, $rowData) {
		$sql = '
		select a.ireqdet_id,b.vreq_nomor,e.vpo_nomor,f.vro_nomor,g.vnama,a.ijumlah,h.vupb_nomor,h.vupb_nama,a.* ,d.*
		from plc2.plc2_upb_request_sample_detail a
		join plc2.plc2_upb_request_sample b on b.ireq_id=a.ireq_id
		join plc2.plc2_upb_ro_detail d on d.ireq_id=a.ireq_id and d.raw_id=a.raw_id
		join plc2.plc2_upb_po  e on e.ipo_id=d.ipo_id
		join plc2.plc2_upb_ro f on f.iro_id=d.iro_id
		join plc2.plc2_raw_material g on g.raw_id=a.raw_id
		join plc2.plc2_upb h on h.iupb_id=b.iupb_id
		join plc2.uji_mikro_bb i on i.ireqdet_id=a.ireqdet_id
		where 
		a.ldeleted=0
		and b.ldeleted=0
		and d.ldeleted=0
		and e.ldeleted=0
		and f.ldeleted=0
		and g.ldeleted=0
		and h.ldeleted=0
		and i.lDeleted=0
		and i.ireqdet_id
		="'.$rowData['ireqdet_id'].'" ';
		$data_upb = $this->dbset->query($sql)->row_array();

		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vpo_nomor'];

		}
		else{
			$return = '<input type="text" name="'.$field.'" disabled="disabled" id="'.$id.'" value="'.$data_upb['vpo_nomor'].'" class="input_rows1 required" size="8" />';
		}
		return $return;
	}

	function insertBox_draft_soi_mikro_bb_no_upb($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  disabled="disabled" class="input_rows1 required" size="30" />';
		return $return;
	}
	//,'no_po','manuf','no_upb'
	function updateBox_draft_soi_mikro_bb_no_upb($field, $id, $value, $rowData) {
		$sql = '
		select a.ireqdet_id,b.vreq_nomor,e.vpo_nomor,f.vro_nomor,g.vnama,a.ijumlah,h.vupb_nomor,h.vupb_nama,a.* ,d.*
		from plc2.plc2_upb_request_sample_detail a
		join plc2.plc2_upb_request_sample b on b.ireq_id=a.ireq_id
		join plc2.plc2_upb_ro_detail d on d.ireq_id=a.ireq_id and d.raw_id=a.raw_id
		join plc2.plc2_upb_po  e on e.ipo_id=d.ipo_id
		join plc2.plc2_upb_ro f on f.iro_id=d.iro_id
		join plc2.plc2_raw_material g on g.raw_id=a.raw_id
		join plc2.plc2_upb h on h.iupb_id=b.iupb_id
		join plc2.uji_mikro_bb i on i.ireqdet_id=a.ireqdet_id
		where 
		a.ldeleted=0
		and b.ldeleted=0
		and d.ldeleted=0
		and e.ldeleted=0
		and f.ldeleted=0
		and g.ldeleted=0
		and h.ldeleted=0
		and i.lDeleted=0
		and i.ireqdet_id
		="'.$rowData['ireqdet_id'].'" ';
		$data_upb = $this->dbset->query($sql)->row_array();

		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vupb_nomor'].' - '.$data_upb['vupb_nama'];

		}
		else{
			$return = '<input type="text" name="'.$field.'" disabled="disabled" id="'.$id.'" value="'.$data_upb['vupb_nomor'].' - '.$data_upb['vupb_nama'].'" class="input_rows1 required" size="30" />';
		}
		return $return;
	}

	function insertBox_draft_soi_mikro_bb_iJumlah_terima($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" angka input_rows1 required" size="8" />
		<input type="hidden" name="isdraft" id="isdraft">';
		return $return;
	}

	function updateBox_draft_soi_mikro_bb_iJumlah_terima($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="isdraft" id="isdraft">';
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		}
		return $return;
	}


	function insertBox_draft_soi_mikro_bb_dMulai_literatur($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" tanggal input_rows1 " size="8" />';
		return $return;
	}

	function updateBox_draft_soi_mikro_bb_dMulai_literatur($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		}
		return $return;
	}

	function insertBox_draft_soi_mikro_bb_dSelesai_literatur($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" tanggal input_rows1 " size="8" />';
		return $return;
	}

	function updateBox_draft_soi_mikro_bb_dSelesai_literatur($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		}
		return $return;
	}

	function insertBox_draft_soi_mikro_bb_dMulai_uji($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" tanggal input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_draft_soi_mikro_bb_dMulai_uji($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		}
		return $return;
	}

	function insertBox_draft_soi_mikro_bb_dSelesai_uji($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" tanggal input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_draft_soi_mikro_bb_dSelesai_uji($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		}
		return $return;
	}		

	function insertBox_draft_soi_mikro_bb_cPic_uji($field, $id) {
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/pic/?field=draft_soi_mikro_bb&pic_for=draft_soi_mikro_bb&idfield='.$field.'\',\'List PIC\')" type="button">&nbsp;</button>';                
		
		return $return;
	}

	function updateBox_draft_soi_mikro_bb_cPic_uji($field, $id, $value, $rowData) {
		$emp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cPic_uji']))->row_array();
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
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/pic/?field=draft_soi_mikro_bb&pic_for=draft_soi_mikro_bb&idfield='.$field.'\',\'List PIC\')" type="button">&nbsp;</button>';                
			

			
			}else{
				$return= $emp['cNip'].' - '.$emp['vName'];
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			}
			
		}
		
		return $return;
	}

	function updateBox_draft_soi_mikro_bb_iHasil_uji($field, $id, $value, $rowData) {
		
		if ($this->input->get('action') == 'view') {
			$return=$value;

		}else{
			$data=array(''=>'Select One','1'=>'Gagal','2'=>'Berhasil');
			$return=$data[$value];	
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';		
			
		}
		
		return $return;
	}

	function updateBox_draft_soi_mikro_bb_iUji_spesifik($field, $id, $value, $rowData) {
		
		if ($this->input->get('action') == 'view') {
			$return=$value;

		}else{
			$data=array(''=>'Select One','1'=>'Ya','0'=>'Tidak');
			$return=$data[$value];			
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		}
		
		return $return;
	}


	function updateBox_draft_soi_mikro_bb_draft_soi_mikro($field, $id, $value, $rowData) {
		if (!empty($_GET['idnya'])) {
			$iuji_mikro_bb = $_GET['idnya'];
		}else{
			$iuji_mikro_bb = $rowData['iuji_mikro_bb'];
		}
		$data['mydept'] = $this->auth_localnon->my_depts(TRUE);
		$data['rows'] = $this->db_plc0->get_where('plc2.file_draft_soi_mikro', array('iuji_mikro_bb'=>$iuji_mikro_bb))->result_array();
		return $this->load->view('lokal/draft_soi_mikro_file',$data,TRUE);				
	}	

	function updateBox_draft_soi_mikro_bb_dMulai_draft_soi($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="tanggal input_rows1 " size="8" />';
		}
		return $return;
	}

	function updateBox_draft_soi_mikro_bb_dSelesai_draft_soi($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="tanggal input_rows1 " size="8" />';
		}
		return $return;
	}

	function updateBox_draft_soi_mikro_bb_cPic_draft_soi($field, $id, $value, $rowData) {
		$emp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cPic_draft_soi']))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $emp['cNip'].' - '.$emp['vName'];

		}else{
			
			if ($rowData['iSubmit_draft_soi'] == 0) {
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
			if (!empty($emp)) {
				$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="30" value="'.$emp['cNip'].' - '.$emp['vName'].'"/>';	
			}else{
				$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="30" value="'.$value.'"/>';
			}
			
			
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/pic/?field=draft_soi_mikro_bb&pic_for=draft_soi_mikro_bb&idfield='.$field.'\',\'List PIC\')" type="button">&nbsp;</button>';                
			

			
			}else{
				$return= $emp['cNip'].' - '.$emp['vName'];
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			}
			
		}
		
		return $return;
	}	

// end manipulate     

	function manipulate_insert_button($buttons) {
		unset($buttons['save']);

		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'draft_soi_mikro_bb\', \''.base_url().'processor/plc/draft/soi/mikro/bb?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_draft_soi_mikro_bb">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'draft_soi_mikro_bb\', \''.base_url().'processor/plc/draft/soi/mikro/bb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_draft_soi_mikro_bb">Save &amp; Submit</button>';
		$js = $this->load->view('lokal/draft_soi_mikro_bb_js');
		$buttons['save'] = $save_draft.$save.$js;

		return $buttons;
	}

	function manipulate_update_button($buttons, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		$cNip= $this->user->gNIP;
		$js = $this->load->view('lokal/draft_soi_mikro_bb_js');
		
		$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/draft/soi/mikro/bb?action=approve&iuji_mikro_bb='.$rowData['iuji_mikro_bb'].'&cNip='.$cNip.'&lvl=2&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_draft_soi_mikro_bb">Confirm</button>';
		$update = '<button onclick="javascript:update_btn_back(\'draft_soi_mikro_bb\', \''.base_url().'processor/plc/draft/soi/mikro/bb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_draft_soi_mikro_bb">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'draft_soi_mikro_bb\', \''.base_url().'processor/plc/draft/soi/mikro/bb?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_draft_soi_mikro_bb">Update as Draft</button>';



		if ($this->input->get('action') == 'view') {unset($buttons['update']);}

		else{
			
			unset($buttons['update_back']);
			unset($buttons['update']);
			
			if ($rowData['iSubmit_draft_soi']== 0) {
				// jika masih draft , show button update draft & update submit 
				if (isset($mydept)) {
					// cek punya dep
					if((in_array('QA', $mydept))) {
						$buttons['update'] = $update.$updatedraft.$js;
					}
				}

			}else{
				// sudah disubmit , show button approval 
				if ($rowData['iApprove_draft']==0) {
					// jika approval bdirm 0 
					if (isset($mydept)) {
						if((in_array('QA', $mydept))) {
							if($this->auth_localnon->is_manager()){
								$buttons['update'] = $approve.$js;	
							}else{
								$sqlcekapp='select * from plc2.plc2_upb_team_item i where i.vnip="'.$cNip.'" and i.ldeleted=0';
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
								var url = "'.base_url().'processor/plc/draft/soi/mikro/bb";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_draft_soi_mikro_bb").html(data);
										 $("#button_approve_draft_soi_mikro_bb").hide();
										 $("#button_reject_draft_soi_mikro_bb").hide();
									});
									
								}
									reload_grid("grid_draft_soi_mikro_bb");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Confirm</h1><br />';
		$echo .= '<form id="form_draft_soi_mikro_bb_approve" action="'.base_url().'processor/plc/draft/soi/mikro/bb?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="iuji_mikro_bb" value="'.$this->input->get('iuji_mikro_bb').'" />
				<input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark_draft"></textarea>
		<button type="button" onclick="submit_ajax(\'form_draft_soi_mikro_bb_approve\')">Confirm</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$iuji_mikro_bb = $post['iuji_mikro_bb'];
		$lvl = $post['lvl'];
		$vRemark_draft = $post['vRemark_draft'];

		
		$data=array('iApprove_draft'=>'2','cApproval_draft'=>$cNip , 'dApproval_draft'=>date('Y-m-d H:i:s'), 'vRemark_draft'=>$vRemark_draft);
		$this -> db -> where('iuji_mikro_bb', $iuji_mikro_bb);
		$updet = $this -> db -> update('plc2.uji_mikro_bb', $data);

		$data['status']  = true;
		$data['last_id'] = $post['iuji_mikro_bb'];
		return json_encode($data);

/*
		$logged_nip =$this->user->gNIP;
		$qupi="select a.iuji_mikro_bb,a.vNo_upi,a.dTgl_upi,a.cPengusul_upi,a.vNama_usulan,a.vKekuatan,a.vDosis,a.vNama_generik,a.vIndikasi 
				,a.iSubmit_upi,
				(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdirm,
				(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='DR' and te.ldeleted=0) as dr,
				b.cNip,b.vName
				from plc2.daftar_upi a 
				join hrd.employee b on b.cNip=a.cPengusul_upi
				where a.lDeleted=0
				and a.iuji_mikro_bb = '".$id."'";
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
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Kekuatan</b></td><td> : </td><td>".$rupd['vKekuatan']."</td>
							</tr>
							<tr>
								<td><b>Dosis</b></td><td> : </td><td> ".$rupd['vDosis']."</td>
							</tr>
							<tr>
								<td><b>Nama Generik</b></td><td> : </td><td>".$rupd['vNama_generik']."</td>
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
			$postData['iSubmit_draft_soi']=0;
		} 
		else{$postData['iSubmit_draft_soi']=1;} 
		$postData['dupdate'] = date('Y-m-d H:i:s');
		$postData['cUpdate'] =$this->user->gNIP;
		
		return $postData;

	}

	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/local/draft_soi_mikro_bb/'.$tempat.'/'.$id.'/'.$name);	
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
					$del = "delete from plc2.".$table." where iuji_mikro_bb = {$lastId} and filename= '{$v}'";
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
			$sql = "SELECT filename from plc2.".$table." where iuji_mikro_bb=".$lastId;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['filename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT filename from plc2.".$table." where iuji_mikro_bb=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM plc2.".$table." where iuji_mikro_bb=".$lastId." and filename='".$row['filename']."'";			
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







