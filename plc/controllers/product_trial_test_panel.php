<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class product_trial_test_panel extends MX_Controller {
	private $sess_auth;
	private $dbset;
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		//$this->output->enable_profiler(TRUE);
		$this->load->library('auth');
		$this->load->library('biz_process');
        $this->load->library('lib_utilitas');
        $this->load->library('otc_lib');
		$this->user = $this->auth->user(); 
		$this->url = 'product_trial_test_panel';
		$this->dbset = $this->load->database('plc', true);
		$this->load->helper(array('tanggal','to_mysql'));
    }
    function index($action = '') {
    	$action = $this->input->get('action');
		
    	//Bikin Object Baru Nama nya $grid		
        $grid = new Grid;		
        $grid->setTitle('Test Panel');		
        $grid->setTable('plc2.plc2_upb_paneltest');		
        $grid->setUrl('product_trial_test_panel');
        $grid->addList('plc2_upb_formula.vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.iteampd_id','iSubmit','iApprove');//'lPersen', 'yPersen', 
        $grid->setSortBy('iplc2_upb_paneltest_id');
        $grid->setSortOrder('DESC'); //sort ordernya
		
		//align & width
		$grid->setLabel('nama_pd','Nama PD'); 
		$grid->setLabel('no_upb','No UPB'); 
		
		$grid->setLabel('plc2_upb_formula.vkode_surat','No Formula'); 
		$grid ->setWidth('plc2_upb_formula.vkode_surat', '100'); 
		

		$grid->setLabel('plc2_upb.vupb_nomor','No UPB'); 
		$grid ->setWidth('plc2_upb.vupb_nomor', '100'); 
		$grid->setAlign('plc2_upb.vupb_nomor', 'center'); //Align nya
		
		$grid->setLabel('plc2_upb.vupb_nama','Nama Produk'); 
		$grid ->setWidth('plc2_upb.vupb_nama', '300');
		$grid->setAlign('plc2_upb.vupb_nama', 'center'); //Align nya

		$grid->setLabel('plc2_upb.iteampd_id','Team PD '); 
		$grid ->setWidth('plc2_upb.iteampd_id', '100'); 
		$grid->setAlign('plc2_upb.iteampd_id', 'center'); //Align nya

		$grid->setLabel('iSubmit','Status Submit'); 
		$grid ->setWidth('iSubmit', '150'); 
		$grid->setAlign('iSubmit', 'center'); //Align nya

		$grid->setLabel('iApprove','Status Approval'); 
		$grid ->setWidth('iApprove', '150'); 
		$grid->setAlign('iApprove', 'center'); //Align nya

		$grid->setLabel('iupb_id', 'No UPB'); //Ganti Label
        $grid->setAlign('iupb_id', 'center'); //Align nya
        $grid->setWidth('iupb_id', '50'); // width nya

        $grid->setLabel('ifor_id', 'No Formula'); //Ganti Label
        $grid->setAlign('ifor_id', 'center'); //Align nya
        $grid->setWidth('ifor_id', '100'); // width nya

        $grid->setLabel('dTgl_kirim', 'Tgl Kirim Sample'); //Ganti Label
        $grid->setAlign('dTgl_kirim', 'center'); //Align nya
        $grid->setWidth('dTgl_kirim', '100'); // width nya

        $grid->setLabel('cNip_kirim', 'Nama Pengirim'); //Ganti Label
        $grid->setAlign('cNip_kirim', 'center'); //Align nya
        $grid->setWidth('cNip_kirim', '100'); // width nya

        $grid->setLabel('dTgl_terima', 'Tgl Terima Sample'); //Ganti Label
        $grid->setAlign('dTgl_terima', 'center'); //Align nya
        $grid->setWidth('dTgl_terima', '100'); // width nya

        $grid->setLabel('cNip_terima', 'Nama Penerima'); //Ganti Label
        $grid->setAlign('cNip_terima', 'center'); //Align nya
        $grid->setWidth('cNip_terima', '100'); // width nya

        $grid->setLabel('vKeterangan', 'Keterangan'); //Ganti Label
        $grid->setAlign('vKeterangan', 'center'); //Align nya
        $grid->setWidth('vKeterangan', '100'); // width nya

        $grid->setLabel('vFilePanel', 'Upload File'); //Ganti Label
        $grid->setLabel('vpanel', 'Jenis yang Dipanel'); //Ganti Label
        
		
		
        $grid->addFields('ifor_id','no_upb','nama_usulan','nama_generik','nama_pd','dTgl_kirim','cNip_kirim','dTgl_terima','cNip_terima','vpanel','vKeterangan','vFilePanel');
		$grid->changeFieldType('iSubmit','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submitted'));

		$grid->setJoinTable('plc2.plc2_upb_formula', 'plc2_upb_formula.ifor_id = plc2_upb_paneltest.ifor_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = plc2.plc2_upb_formula.iupb_id', 'inner');
		//set search
        $grid->setSearch('plc2_upb_formula.vkode_surat', 'plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.iteampd_id');
		
		//set required
        $grid->setRequired('ifor_id', 'iupb_id');	//Field yg mandatori
        $grid->setFormUpload(TRUE);

        $grid->setGridView('grid');

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
   				if($isUpload) {

					$path = realpath("files/plc/test_panel");
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
					foreach ($_FILES['fileupload']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {			
							$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
							$name = $_FILES['fileupload']["name"][$key];
							$data['filename'] = $name;
							$data['id']=$this->input->get('lastId');
							$data['dInsertDate'] = date('Y-m-d H:i:s');
							if(move_uploaded_file($tmp_name, $path."/".$this->input->get('lastId')."/".$name)) {

								$sql[] = "INSERT INTO plc2_upb_paneltest_file (iplc2_upb_paneltest_id, vFilename,vKeterangan, dCreated,cCreatedBy) 
										VALUES ('".$data['id']."', '".$data['filename']."','".$file_keterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
								$i++;	
							}
							else{
							echo "Upload ke folder gagal";	
							}
						}
					}
					
					//upload 
					
					foreach($sql as $q) {
						try {
							$this->dbset->query($q);
						}catch(Exception $e) {
							die($e);
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
                	$id =$_POST['product_trial_test_panel_iplc2_upb_paneltest_id'];
                	$isUpload = $this->input->get('isUpload');
					$sql = array();
	   				$file_name= "";
					$fileId = array();
					$path = realpath("files/plc/test_panel");
					
					if (!file_exists( $path."/".$id )) {
						mkdir($path."/".$id, 0777, true);						 
					}
										
					$file_keterangan = array();
					
					foreach($_POST as $key=>$value) {
												
						if ($key == 'fileketerangan') {
							foreach($value as $y=>$u) {
								$file_keterangan[$y] = $u;
							}
						}
						
					}

					$last_index = 0;	
							
	   				if($isUpload) {
						$j = $last_index;		
								
									
						if (isset($_FILES['fileupload'])) {
							//$this->hapusfile($path, $file_name, 'plc2_upb_paneltest_file', $this->input->post('iplc2_upb_paneltest_id'));
							foreach ($_FILES['fileupload']["error"] as $key => $error) {	
								if ($error == UPLOAD_ERR_OK) {
									$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
									$name = $_FILES['fileupload']["name"][$key];
									$data['filename'] = $name;
									$data['id']=$id;
									$data['nip']=$this->user->gNIP;
									//$data['iupb_id'] = $insertId;
									$data['dInsertDate'] = date('Y-m-d H:i:s');
					 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
					 				if(move_uploaded_file($tmp_name, $path."/".$id."/".$name)) 
					 				{
					 					
										$sql[] = "INSERT INTO plc2_upb_paneltest_file (iplc2_upb_paneltest_id, vFilename, dCreated, vKeterangan, cCreatedBy) 
											VALUES ('".$data['id']."', '".$data['filename']."','".$data['dInsertDate']."','".$file_keterangan[$j]."','".$data['nip']."')";
										
									$j++;																			
									}
									else{
									echo "Upload ke folder gagal";	
									}
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
						
					
						$r['status'] = TRUE;
						$r['last_id'] = $id;					
						echo json_encode($r);
						exit();
					}  else {
						
						if (is_array($file_name)) {									
							$this->hapusfile($path, $file_name, 'plc2_upb_paneltest_file', $id);
						}
														
						echo $grid->updated_form();
					}
				break;
                case 'delete':
                        echo $grid->delete_row();
                        break;
                case 'getdetilupb':
						$this->getdetilupb();
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

				case 'download':
						$this->download($this->input->get('file'));
						break;

                default:
                        $grid->render_grid();
                        break;
        }
    }   

    function listBox_Action($row, $actions) {
    	$rows1 = $this->db_plc0->get_where('plc2.plc2_upb_formula', array('ifor_id'=>$row->ifor_id,'ldeleted'=>0))->row_array();
	 	$rows = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rows1['iupb_id'],'ldeleted'=>0))->row_array();
	 	$mydept = $this->auth->my_depts(TRUE);
	 	$x = $this->auth->my_teams();
	 	$idtim_bd =$rows['iteambusdev_id'];

		$array = explode(',', $x);
		// cek user bagian dari tim bd terkait
		

	 	if ($row->iApprove<>0) {
	 		// status sudah diapprove or reject , button edit hide 
	 		 unset($actions['edit']);
	 		 unset($actions['delete']);
	 	}else{
	 		if((in_array($idtim_bd, $array))) {
				$actions['delete'];
				$actions['edit'];
			}else{
				 unset($actions['edit']);
		 		 unset($actions['delete']);
			}

	 	}

	 	
		 return $actions;

	 } 

	function listBox_product_trial_test_panel_iApprove($value) {
		 if ($value == 2) {
		 	$ret = 'Approved';
		 }else if ($value == 1){
		 	$ret = 'Rejected';
		 }else{
		 	$ret = 'Waiting Approval';
		 }
		return $ret;
	}

	function searchBox_product_trial_test_panel_plc2_upb_iteampd_id($rowData, $id) {
    	$teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('ldeleted' => 0,'vtipe' => 'PD'))->result_array();
    	$o = '<select id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }



	function listBox_product_trial_test_panel_plc2_upb_iteampd_id($value) {
		$team = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id' => $value))->row_array();
		if(isset($team['vteam'])){
			return $team['vteam'];
		}
		else{
			return $value;
		}
		
	} 

	
	function insertbox_product_trial_test_panel_ifor_id($field, $id) {
			$return = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />
						<input type="hidden" name="isdraft" id="isdraft">';
			$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="35" />';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/panel/test/upb/?field=product_trial_test_panel\',\'List UPB\')" type="button">&nbsp;</button>';                
			
			return $return;
	}

	function updatebox_product_trial_test_panel_ifor_id($field, $id, $value, $rowData) {
		$rows1 = $this->db_plc0->get_where('plc2.plc2_upb_formula', array('ifor_id'=>$rowData['ifor_id'],'ldeleted'=>0))->row_array();
		$sql = 'select pu.iupb_id , pu.vupb_nomor, pu.vupb_nama from plc2.plc2_upb pu where pu.iupb_id ="'.$rows1['iupb_id'].'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows1['vkode_surat'];

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
						<input type="hidden" name="isdraft" id="isdraft">';
			$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="35" value="'.$rows1['vkode_surat'].'"/>';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/panel/test/upb/?field=product_trial_test_panel\',\'List UPB\')" type="button">&nbsp;</button>';                
			

			
			}else{
				$return= $rows1['vkode_surat'];
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			}
		}
		
		return $return;
	}

	function insertbox_product_trial_test_panel_iupb_id($field, $id) {
    	$return = '<input type="text" name="'.$field.'" id="'.$id.'" class=" required input_rows1" size="15" />';
    	return $return;
    }

    function updatebox_product_trial_test_panel_iupb_id($field, $id, $value, $rowData) {
   	 	if ($this->input->get('action') == 'view') {
	        $return= $value;
	    } else {
			$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$value.'" class=" required input_rows1" size="15" />';
	        
	    }   

	        
       return $return;
    }

	function insertbox_product_trial_test_panel_no_upb($field, $id) {
    	$return = '<input type="text" readonly="readonly" name="'.$field.'" id="'.$id.'" class=" required input_rows1" size="30" />';
    	return $return;
    }
    function updatebox_product_trial_test_panel_no_upb($field, $id, $value, $rowData) {
    	$rows1 = $this->db_plc0->get_where('plc2.plc2_upb_formula', array('ifor_id'=>$rowData['ifor_id'],'ldeleted'=>0))->row_array();
		$rows = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rows1['iupb_id'],'ldeleted'=>0))->row_array();
    	$isi= $rows['vupb_nomor'];
   	 	if ($this->input->get('action') == 'view') {
	        $return= $isi;
	    } else {
			$return = '<input type="text" disabled="readonly" name="'.$field.'" id="'.$id.'" value="'.$isi.'" class="required input_rows1" size="30" />';
			
	        
	    }   

	        
       return $return;
    }

	function insertbox_product_trial_test_panel_nama_usulan($field, $id) {
    	$return = '<input type="text" readonly="readonly" name="'.$field.'" id="'.$id.'" class=" required input_rows1" size="30" />';
    	return $return;
    }
    function updatebox_product_trial_test_panel_nama_usulan($field, $id, $value, $rowData) {
    	$rows1 = $this->db_plc0->get_where('plc2.plc2_upb_formula', array('ifor_id'=>$rowData['ifor_id'],'ldeleted'=>0))->row_array();
		$rows = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rows1['iupb_id'],'ldeleted'=>0))->row_array();
    	$isi= $rows['vupb_nama'];
   	 	if ($this->input->get('action') == 'view') {
	        $return= $isi;
	    } else {
			$return = '<input type="text" disabled="readonly" name="'.$field.'" id="'.$id.'" value="'.$isi.'" class="required input_rows1" size="30" />';
			
	        
	    }   

	        
       return $return;
    }

    function insertbox_product_trial_test_panel_nama_generik($field, $id) {
    	$return = '<input type="text" readonly="readonly" name="'.$field.'" id="'.$id.'" class=" required input_rows1" size="30" />';
    	return $return;
    }

    function updatebox_product_trial_test_panel_nama_generik($field, $id, $value, $rowData) {
    	$rows1 = $this->db_plc0->get_where('plc2.plc2_upb_formula', array('ifor_id'=>$rowData['ifor_id'],'ldeleted'=>0))->row_array();
		$rows = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rows1['iupb_id'],'ldeleted'=>0))->row_array();
    	$isi= $rows['vgenerik'];
   	 	if ($this->input->get('action') == 'view') {
	        $return= $isi;
	    } else {
			$return = '<input type="text" readonly="readonly" name="'.$field.'" id="'.$id.'" value="'.$isi.'" class="required input_rows1" size="30" />';
			
	        
	    }   

	        
       return $return;
    }

    function insertbox_product_trial_test_panel_nama_pd($field, $id) {
    	$return = '<input type="text" readonly="readonly" name="'.$field.'" id="'.$id.'" class=" required input_rows1" size="15" />';
    	return $return;
    }

    function updatebox_product_trial_test_panel_nama_pd($field, $id, $value, $rowData) {
    	$rows1 = $this->db_plc0->get_where('plc2.plc2_upb_formula', array('ifor_id'=>$rowData['ifor_id'],'ldeleted'=>0))->row_array();
		$rows = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rows1['iupb_id'],'ldeleted'=>0))->row_array();
    	$team = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id'=>$rows['iteampd_id'],'ldeleted'=>0))->row_array();
    	$isi= $team['vteam'];
   	 	if ($this->input->get('action') == 'view') {
	        $return= $isi;
	    } else {
			$return = '<input type="text" readonly="readonly" name="'.$field.'" id="'.$id.'" value="'.$isi.'" class="required input_rows1" size="20" />';
			
	        
	    }   

	        
       return $return;
    }



    function insertbox_product_trial_test_panel_dTgl_kirim($field, $id) {
    	$return = '<input type="text" name="'.$field.'" id="'.$id.'" class="required input_rows1" size="10" />';
    	$return .='<script>
				 	$("#'.$id.'").datepicker({	changeMonth:true,
											changeYear:true,
											dateFormat:"yy-mm-dd" });
					</script>';

    	return $return;
    }

    function updatebox_product_trial_test_panel_dTgl_kirim($field, $id, $value, $rowData) {
   	 	if ($this->input->get('action') == 'view') {
	        $return= $value;
	    } else {
			$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="required input_rows1" size="10" />';
			$return .='<script>
						 $("#'.$id.'").datepicker({	changeMonth:true,
											changeYear:true,
											dateFormat:"yy-mm-dd" });
						</script>';

	        
	    }   

	        
       return $return;
    }

	function insertBox_product_trial_test_panel_cNip_kirim($field, $id) {
	        
        $o  = "<select name='".$field."' id='".$id."' class='required'>";
        $o .= "<option value=''>Pilih</option>";
        $o .= "</select>";
        
        return $o;
	} 

		
	function updatebox_product_trial_test_panel_cNip_kirim($field, $id, $value, $rowData) {
		$sql = "select a.vnip,b.vName,a.iteam_id 
				from plc2.plc2_upb_team_item a 
				join hrd.employee b on a.vnip=b.cNip
				where a.ldeleted=0
				and a.vnip='".$value."'
				order by b.vName";
		$data2 = $this->dbset->query($sql)->row_array();				


	    if ($this->input->get('action') == 'view') {
	            $o = $data2['vName'];
	    } else {

	        $o  = "<select name='".$field."' id='".$id."' class='required'>";
	        $o .= "<option value=''>Pilih</option>";
	         $sql = "select a.vnip,b.vName 
				from plc2.plc2_upb_team_item a 
				join hrd.employee b on a.vnip=b.cNip
				where a.ldeleted=0
				and a.iteam_id='".$data2['iteam_id']."'
				order by b.vName";
	        $query = $this->dbset->query($sql);
	        if ($query->num_rows() > 0) {
	            $result = $query->result_array();
	            foreach($result as $row) {
	                   if ($value == $row['vnip']) $selected = " selected";
	                   else $selected = '';
	                   $o .= "<option {$selected} value='".$row['vnip']."'>".$row['vName']."</option>";
	            }
	        }
	    }   

	        $o .= "</select>";
	        
	        return $o;
	}
	



	function insertBox_product_trial_test_panel_cNip_terima($field, $id) {
	        
        $o  = "<select name='".$field."' id='".$id."' class='required'>";
        $o .= "<option value=''>Pilih</option>";
        $o .= "</select>";
        
        return $o;
	} 

	function updatebox_product_trial_test_panel_cNip_terima($field, $id, $value, $rowData) {
		$sql = "select a.vnip,b.vName,a.iteam_id 
				from plc2.plc2_upb_team_item a 
				join hrd.employee b on a.vnip=b.cNip
				where a.ldeleted=0
				and a.vnip='".$value."'
				order by b.vName";
		$data2 = $this->dbset->query($sql)->row_array();				


	    if ($this->input->get('action') == 'view') {
	            $o = $data2['vName'];
	    } else {

	        $o  = "<select name='".$field."' id='".$id."' class='required'>";
	        $o .= "<option value=''>Pilih</option>";
	         $sql = "select a.vnip,b.vName 
				from plc2.plc2_upb_team_item a 
				join hrd.employee b on a.vnip=b.cNip
				where a.ldeleted=0
				and a.iteam_id='".$data2['iteam_id']."'
				order by b.vName";
	        $query = $this->dbset->query($sql);
	        if ($query->num_rows() > 0) {
	            $result = $query->result_array();
	            foreach($result as $row) {
	                   if ($value == $row['vnip']) $selected = " selected";
	                   else $selected = '';
	                   $o .= "<option {$selected} value='".$row['vnip']."'>".$row['vName']."</option>";
	            }
	        }
	    }   

	        $o .= "</select>";
	        
	        return $o;
	}
	




    function insertbox_product_trial_test_panel_dTgl_terima($field, $id) {
    	$return = '<input type="text" name="'.$field.'" id="'.$id.'" class="required input_rows1" size="10" />';
    	$return .='<script>
				 	$("#'.$id.'").datepicker({	changeMonth:true,
											changeYear:true,
											dateFormat:"yy-mm-dd" });
					</script>';

    	return $return;
    }

    function updatebox_product_trial_test_panel_dTgl_terima($field, $id, $value, $rowData) {
   	 	if ($this->input->get('action') == 'view') {
	        $return= $value;
	    } else {
			$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="required input_rows1" size="10" />';
			$return .='<script>
						 $("#'.$id.'").datepicker({	changeMonth:true,
											changeYear:true,
											dateFormat:"yy-mm-dd" });
						</script>';

	        
	    }   

	        
       return $return;
    }


    function insertbox_product_trial_test_panel_vFilePanel($field, $id) {
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('panel_test_file',$data,TRUE);
	}


	function updatebox_product_trial_test_panel_vFilePanel($field, $id, $value, $rowData) {
	 	$id_brosur=$rowData['iplc2_upb_paneltest_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_paneltest_file', array('iplc2_upb_paneltest_id'=>$id_brosur))->result_array();
		return $this->load->view('panel_test_file',$data,TRUE);
	}


    function insertbox_product_trial_test_panel_vKeterangan($field, $id) {
    	$return ='<textarea name="'.$field.'" id="'.$id.'" class="required input_rows1" ></textarea>';

    	return $return;
    }

    function updatebox_product_trial_test_panel_vKeterangan($field, $id, $value, $rowData) {
    	$return ='<textarea name="'.$field.'" id="'.$id.'" class="required input_rows1" >'.nl2br($value).'</textarea>';

    	return $return;
    }

   
    function insertbox_product_trial_test_panel_vpanel($field, $id) {
		$this->db_plc0->where('lDeleted', 0);
		$this->db_plc0->order_by('vNmJenis', 'ASC');
		$data['docs'] = $this->db_plc0->get('plc2.plc2_upb_jenis_panel')->result_array();
		return $this->load->view('panel_test_jenis',$data,TRUE);
	}
	
	function updatebox_product_trial_test_panel_vpanel($field, $id, $value, $rowData) {
		$this->db_plc0->where('lDeleted', 0);
		$this->db_plc0->order_by('vNmJenis', 'ASC');
		$data['docs'] = $this->db_plc0->get('plc2.plc2_upb_jenis_panel')->result_array();
		$data['isi'] = $rowData['txtJenisPanel'];
		return $this->load->view('panel_test_jenis_edit',$data,TRUE);
	}

    //function tambahan 
    function before_insert_processor($row, $postData) {
		$postData['dCreate'] = date('Y-m-d H:i:s');
		$postData['cCreated'] =$this->user->gNIP;
		if(isset($postData['bb'])) {
			$bb = $postData['bb'];
			$new_bb = '';
			$i=1;
			foreach($bb as $k => $d) {
				if($i == count($bb)) {
					$new_bb .=$d;
				}
				else {
					$new_bb .=$d.',';
				}
				$i++;
			}
			$postData['txtJenisPanel'] = $new_bb;
		}

		if($postData['isdraft']==true){
			$postData['iSubmit']=0;
		} 
		else{$postData['iSubmit']=1;} 
		

		return $postData;

	}

	function before_update_processor($row, $postData) {
		$postData['dCreate'] = date('Y-m-d H:i:s');
		$postData['cCreated'] =$this->user->gNIP;
		
		if(isset($postData['bb'])) {
			$bb = $postData['bb'];
			$new_bb = '';
			$i=1;
			foreach($bb as $k => $d) {
				if($i == count($bb)) {
					$new_bb .=$d;
				}
				else {
					$new_bb .=$d.',';
				}
				$i++;
			}
			$postData['txtJenisPanel'] = $new_bb;
		}
		
		if($postData['isdraft']==true){
			$postData['iSubmit']=0;
		} 
		else{$postData['iSubmit']=1;} 
		

		return $postData;

	}



	function getdetilupb(){
		$ifor_id=$_POST['upb_id'];
		$data = array();

		$sql = "select * from plc2.plc2_upb_formula a where a.ifor_id='".$ifor_id."'";
		$data3 = $this->dbset->query($sql)->row_array();

		$row_array['vkode_surat'] = trim($data3['vkode_surat']);


		$sql2 = "select *
			from plc2.plc2_upb a 
			where a.ldeleted = 0 and a.iupb_id='".$data3['iupb_id']."'";
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

	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		//print_r($_GET);
		//exit;
		//$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/test_panel/'.$id.'/'.$name);	
		force_download($name, $path);
	}

/*
	function manipulate_insert_button($buttons) {
		unset($buttons['save']);
		$save = '<button onclick="javascript:save_btn_multiupload(\'product_trial_test_panel\', \''.base_url().'processor/plc/product/trial/test/panel?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_test_panel">Save 11</button>';
		$js = $this->load->view('panel_test_js');
		$buttons['save'] = $save.$js;
		return $buttons;
	}
*/
	
	function manipulate_insert_button($buttons) {
		unset($buttons['save']);

		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'product_trial_test_panel\', \''.base_url().'processor/plc/product/trial/test/panel?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_panel_stress">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'product_trial_test_panel\', \''.base_url().'processor/plc/product/trial/test/panel?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_test_panel">Save &amp; Submit</button>';
		$js = $this->load->view('panel_test_js');
		//$buttons['save'] = $save.$js;
		$buttons['save'] = $save_draft.$save.$js;

		return $buttons;
	}


function manipulate_update_button($buttons, $rowData) {
	$rows1 = $this->db_plc0->get_where('plc2.plc2_upb_formula', array('ifor_id'=>$rowData['ifor_id'],'ldeleted'=>0))->row_array();
	$rows = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rows1['iupb_id'],'ldeleted'=>0))->row_array();
	$idtim_bd =$rows['iteambusdev_id'];
	$idtim_mkt =$rows['iteammarketing_id'];
	$mydept = $this->auth->my_depts(TRUE);
	$cNip= $this->user->gNIP;
	$js = $this->load->view('panel_test_js');

	$update = '<button onclick="javascript:update_btn_back(\'product_trial_test_panel\', \''.base_url().'processor/plc/product/trial/test/panel?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_ppic_memo_mkt">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'product_trial_test_panel\', \''.base_url().'processor/plc/product/trial/test/panel?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_ppic_memo_mkt">Update as Draft</button>';
	
	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/test/panel?action=approve&iplc2_upb_paneltest_id='.$rowData['iplc2_upb_paneltest_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_panel_test">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/product/trial/test/panel?action=reject&iplc2_upb_paneltest_id='.$rowData['iplc2_upb_paneltest_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_panel_test">Reject</button>';


	if ($this->input->get('action') == 'view') {unset($buttons['update']);}

	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if ($rowData['iSubmit']== 0) {
			// jika masih draft , show button update draft & update submit 
			if (isset($mydept)) {
				// cek punya dep
				if((in_array('BD', $mydept)) ) {
					//cek dep ada bd
					$x = $this->auth->my_teams();
					$array = explode(',', $x);
						// cek user bagian dari tim bd terkait
						if((in_array($idtim_bd, $array)) ) {
							$buttons['update'] = $update.$updatedraft.$js;
						}
				}
			}

		}else{
			// sudah disubmit , show button approval 
				if (isset($mydept)) {
					//cek punya dep
					if((in_array('BD', $mydept))) {
						// cek dep BD
						if($this->auth->is_managerdept_id('BD',$idtim_bd)){ 
							//cek managerterkait
							$buttons['update'] = $approve.$reject.$js;
						}
					}
				}
			
		}


		//$buttons['update'] = $update.$updatedraft.$approve.$reject.$js;
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
								var url = "'.base_url().'processor/plc/product/trial/test/panel";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_product_trial_test_panel").html(data);
										 $("#button_approve_panel_test").hide();
										 $("#button_reject_panel_test").hide();
									});
									
								}
									reload_grid("grid_product_trial_test_panel");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="product_trial_test_panel_approve" action="'.base_url().'processor/plc/product/trial/test/panel?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="iplc2_upb_paneltest_id" value="'.$this->input->get('iplc2_upb_paneltest_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'product_trial_test_panel_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$iplc2_upb_paneltest_id = $post['iplc2_upb_paneltest_id'];
		$vRemark = $post['vRemark'];

		$panel = $this->db_plc0->get_where('plc2.plc2_upb_paneltest', array('iplc2_upb_paneltest_id'=>$iplc2_upb_paneltest_id,'ldeleted'=>0))->row_array();

		$data=array('iApprove'=>'2','cApprove'=>$cNip , 'dApprove'=>date('Y-m-d H:i:s'), 'vRemark'=>$vRemark);
		$this -> db -> where('iplc2_upb_paneltest_id', $iplc2_upb_paneltest_id);
		$updet = $this -> db -> update('plc2.plc2_upb_paneltest', $data);

		$ifor_id= $panel['ifor_id'] ;
		if ($updet) {
			// jika approve maka pindah ke stabilita lab
			$data=array('istab'=>'2','iwithstabilita'=>'1' );
			$this -> db -> where('ifor_id', $ifor_id);
			$this -> db -> update('plc2.plc2_upb_formula', $data);
		}
		

/*
		$logged_nip =$this->user->gNIP;
		$qupd="select a.iSemester,a.iTahun,a.iSubmit_prio,b.cNip,b.vName,a.cCreated 
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BI' and te.ldeleted=0) as bi
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 order by te.iteam_id DESC limit 1) as ad1
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 order by te.iteam_id ASC limit 1) as ad2
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='IM' and te.ldeleted=0) as im
				from dossier.dossier_prioritas a 
				join hrd.employee b on b.cNip = a.cCreated
				where a.lDeleted = 0
				and a.iplc2_upb_paneltest_id = '".$iplc2_upb_paneltest_id."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_prio'] ;

		if ($updet) {
			$bi = $rupd['bi'];
			$ad1 = $rupd['ad1'];
			$ad2 = $rupd['ad2'];
			$im = $rupd['im'];

			//$team = $dr ;
			$team = $bi. ','.$ad1. ','.$ad2. ','.$im;
			//$team = '81' ;

	        $toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_team( $team );
	        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
	        //$arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
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

				$subject="Approval : Setting Prioritas ".$rupd['iTahun']." - Semester ".$rupd['iSemester'];
				$content="Diberitahukan bahwa telah ada approval Prioritas UPD dari Direksi pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>Tahun</b></td><td style='width: 20px;'> : </td><td>".$rupd['iTahun']."</td>
							</tr>
							<tr>
								<td><b>Semester</b></td><td> : </td><td>Semester ".$rupd['iSemester']."</td>
							</tr>
							<tr>
								<td><b>Diinput oleh</b></td><td> : </td><td>".$rupd['cNip'].' - '.$rupd['vName']."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}
*/


		$data['status']  = true;
		$data['last_id'] = $post['iplc2_upb_paneltest_id'];
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_panel_test_remark").val();
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
								var url = "'.base_url().'processor/plc/product/trial/test/panel";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_product_trial_test_panel").html(data);
										 $("#button_approve_panel_test").hide();
										 $("#button_reject_panel_test").hide();
									});
									
								}
									reload_grid("grid_product_trial_test_panel");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="product_trial_test_panel_reject" action="'.base_url().'processor/plc/product/trial/test/panel?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="iplc2_upb_paneltest_id" value="'.$this->input->get('iplc2_upb_paneltest_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="reject_panel_test_remark"></textarea>
		<button type="button" onclick="submit_ajax(\'product_trial_test_panel_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function reject_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$iplc2_upb_paneltest_id = $post['iplc2_upb_paneltest_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove'=>'1','cApprove'=>$cNip , 'dApprove'=>date('Y-m-d H:i:s'), 'vRemark'=>$vRemark);
		$this -> db -> where('iplc2_upb_paneltest_id', $iplc2_upb_paneltest_id);
		$updet = $this -> db -> update('plc2.plc2_upb_paneltest', $data);

		$ifor_id= $panel['ifor_id'] ;
		if ($updet) {
			// jika approve maka pindah proses yang dipilih, sekarang masih jump to stabilita lab
			$data=array('istab'=>'2','iwithstabilita'=>'1' );
			$this -> db -> where('ifor_id', $ifor_id);
			$this -> db -> update('plc2.plc2_upb_formula', $data);
		}

/*
		$logged_nip =$this->user->gNIP;
		$qupd="select a.iSemester,a.iTahun,a.iSubmit_prio,b.cNip,b.vName,a.cCreated 
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BI' and te.ldeleted=0) as bi
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 order by te.iteam_id DESC limit 1) as ad1
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 order by te.iteam_id ASC limit 1) as ad2
				,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='IM' and te.ldeleted=0) as im
				from dossier.dossier_prioritas a 
				join hrd.employee b on b.cNip = a.cCreated
				where a.lDeleted = 0
				and a.iplc2_upb_paneltest_id = '".$iplc2_upb_paneltest_id."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_prio'] ;

		if ($updet) {
			$bi = $rupd['bi'];
			$ad1 = $rupd['ad1'];
			$ad2 = $rupd['ad2'];
			$im = $rupd['im'];

			//$team = $dr ;
			$team = $bi. ','.$ad1. ','.$ad2. ','.$im;
			//$team = '81' ;

	        $toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_team( $team );
	        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
	        //$arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
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

				$subject="Approval : Setting Prioritas ".$rupd['iTahun']." - Semester ".$rupd['iSemester'];
				$content="Diberitahukan bahwa telah ada approval Prioritas UPD dari Direksi pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>Tahun</b></td><td style='width: 20px;'> : </td><td>".$rupd['iTahun']."</td>
							</tr>
							<tr>
								<td><b>Semester</b></td><td> : </td><td>Semester ".$rupd['iSemester']."</td>
							</tr>
							<tr>
								<td><b>Diinput oleh</b></td><td> : </td><td>".$rupd['cNip'].' - '.$rupd['vName']."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}
*/


		$data['status']  = true;
		$data['last_id'] = $post['iplc2_upb_paneltest_id'];
		return json_encode($data);
	}


	function hapusfile($path, $file_name, $table, $lastId){
		
		$path = $path."/".$lastId;
		//$path = $path."/".$lastId;
		$path = str_replace("\\", "/", $path);
		
		if (is_array($file_name)) {			
			$list_dir  = $this->readDirektory($path);
			$list_sql  = $this->readSQL($table, $lastId);
			asort($file_name);		
			asort($list_dir);		
			asort($list_sql);
			/*
			foreach($list_dir as $v) {				
				if (!in_array($v, $file_name)) {				
					unlink($path.'/'.$v);	
				}			
			}
			*/
			foreach($list_sql as $v) {
				if (!in_array($v, $file_name)) {
					$del = "delete from plc2.".$table." where iplc2_upb_paneltest_id = {$lastId} and vFilename= '{$v}'";
					mysql_query($del);	
				}
				
			}
		} else {
			$this->readDirektory($path, 1);
			$this->readSQL($table, $lastId, 1);
		}
	}
	function readDirektory($path, $empty="") {
		$filename = array();
				
		if (empty($empty)) {
			if ($handle = opendir($path)) {		
				while (false !== ($entry = readdir($handle))) {
				   if ($entry != '.' && $entry != '..' && $entry != '.svn') {			   		
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
						unlink($path."/".$entry);					
					}
				}		
				closedir($handle);
			}
			
			$x = "";
		}
		
		return $x;
	}
	function readSQL($table, $lastId, $empty="") {
		$list_file = array();
		if (empty($empty)) {
			$sql = "SELECT vFilename from plc2.".$table." where iplc2_upb_paneltest_id=".$lastId;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['vFilename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT vFilename from plc2.".$table." where iplc2_upb_paneltest_id=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM plc2.".$table." where iplc2_upb_paneltest_id=".$lastId." and vFilename='".$row['vFilename']."'";			
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







