<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_brosur extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->db_brosur0 = $this->load->database('brosur',false, true);
		$this->load->library('auth');
		//$this->dbset = $this->load->database('brosur', false, true);
		$this->user = $this->auth->user();
    }
    /*ini edit */
    /*ini dari tunk test agar conflict dengan branches */
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid('brosur');
		$grid->setTitle('Upload Brosur');
		//dc.m_vendor  database.tabel
		$grid->setTable('brosur.brochure');		
		$grid->setUrl('master_brosur');
		$grid->addList('vBrosur_no','vSupplierName','vTags','dCreated','vNote','cCreatedBy','iStatus');
		$grid->setSortBy('dCreated');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vBrosur_no','dCreated','vSupplierName','vTags','vNote','iStatus','vFileBrosur');

		//setting widht grid
		$grid ->setWidth('vBrosur_no', '100'); 

		$grid->setWidth('vSupplierName', '200'); 
		$grid->setWidth('vTags', '230'); 
		$grid->setWidth('dCreated', '100'); 
		$grid->setWidth('vNote', '220'); 
		$grid->setWidth('cCreatedBy', '220'); 
		$grid->setWidth('iStatus', '100'); 

		
		//modif label
		$grid->setLabel('vBrosur_no','No Brosur'); //Ganti Label
		$grid->setLabel('vSupplierName','Nama Supplier'); //Ganti Label
		$grid->setLabel('dCreated','Tgl Brosur');
		$grid->setLabel('vNote','Noted'); //Ganti Label
		$grid->setLabel('cCreatedBy','Created By');
		$grid->setLabel('iStatus','Status');
		$grid->setLabel('vFileBrosur','File Brosur');
		$grid->setLabel('vTags','Tags');
		$grid->setSearch('vTags','vSupplierName');
		$grid->setRequired('vSupplierName');	//Field yg mandatori
		$grid->setRequired('vTags');	//Field yg mandatori
		$grid->setRequired('iStatus');	//Field yg mandatori
		$grid->setFormUpload(TRUE);
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iStatus','combobox','',array(''=>'Pilih',1=>'Aktif',0=>'Tidak aktif'));

	//	$grid->setQuery('asset.asset_sparepart.ldeleted', 0);
		//$grid->setMultiSelect(true);
		
		//Set View Gridnya (Default = grid)
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				$isUpload = $this->input->get('isUpload');
				$sql = array();
   				if($isUpload) {

					$path = realpath("files/brosur/");
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

								$sql[] = "INSERT INTO brochure_file (id_brochure, vFilename,vKeterangan, dCreated,cCreatedBy) 
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
								$this->db_brosur0->query($q);
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
			case 'download':
				$this->download($this->input->get('file'));
				break;

			case 'delete':
				echo $grid->delete_row();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'getspname':
				echo $this->getSpname();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				$isUpload = $this->input->get('isUpload');
				$sql = array();
   				$file_name= "";
				$fileId = array();
				$path = realpath("files/brosur/");
				
				if (!file_exists( $path."/".$this->input->post('master_brosur_id') )) {
					mkdir($path."/".$this->input->post('master_brosur_id'), 0777, true);						 
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
						$this->hapusfile($path, $file_name, 'brochure_file', $this->input->post('master_brosur_id'));
						foreach ($_FILES['fileupload']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
								$name = $_FILES['fileupload']["name"][$key];
								$data['filename'] = $name;
								$data['id']=$this->input->post('master_brosur_id');
								$data['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name, $path."/".$this->input->post('master_brosur_id')."/".$name)) 
				 				{
				 					
									$sql[] = "INSERT INTO brochure_file (id_brochure, vFilename, dCreated, vKeterangan, cCreatedBy) 
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
							$this->db_brosur0->query($q);
						}catch(Exception $e) {
							die($e);
						}
					}
					
				
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->post('master_brosur_id');					
					echo json_encode($r);
					exit();
				}  else {
					
					if (is_array($file_name)) {									
						$this->hapusfile($path, $file_name, 'brochure_file', $this->input->post('master_brosur_id'));
					}
													
					echo $grid->updated_form();
				}
				break;
				
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }

    /*Maniupulasi Gird Start*/

    function listBox_master_brosur_cCreatedBy($value, $pk, $name, $rowData) {
    	$sql = "SELECT a.vName from hrd.employee a where a.cNip = '{$value}'";
		$query = $this->db_brosur0->query($sql);
		$nama_group = '-';
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$nama_group = $row->vName;
		}
		
		return $nama_group;
	}

	function listBox_master_brosur_dCreated($value, $pk, $name, $rowData) {
		$o= date('d-m-Y',strtotime($value));
		return $o;
	}

/*Maniupulasi Gird end*/

/*manipulasi view object form start*/
 	function insertBox_master_brosur_vSupplierName($field, $id) {
		$url = base_url().'processor/brosur/master/brosur/?action=getspname';
		$o = '
			  <script language="text/javascript">
					
						var config = {
							source: function( request, response) {
								$.ajax({
									url: "'.$url.'",
									dataType: "json",
									data: {
										term: request.term,
									},
									success: function( data ) {
										response( data );
									}
								});
							},
							minLength: 2,
							autoFocus: true,
						};
	
						$( "#master_brosur_vSupplierName" ).livequery(function() {
						 	$( this ).autocomplete(config);
						});
		      </script>
			  
			 	  <input name="'.$id.'" id="'.$id.'" type="text"  class="required" data-validation="required" data-validation-error-msg="Nama sudah melebihi 50 karakter atau kosong sama sekali"/>
			 ';
		$o .= "<script>
                   $('#".$id."').restrictLength($('#maxlengthsupplier'));
               </script>";
        $o .= '<br/>tersisa <span id="maxlengthsupplier">50</span> karakter<br/>';
        $this->load->validator(1);
		$o .= "<div id='l_pic'></div>";
	
		return $o;
	}


	function updateBox_master_brosur_vSupplierName($field, $id, $value, $rowData) {

		if ($this->input->get('action') == 'view') {
			$o=$value;

		}else{
			$url = base_url().'processor/brosur/master/brosur/?action=getspname';
			$o = '
				  <script language="text/javascript">
						$(document).ready(function() {
							var config = {
								source: function( request, response) {
									$.ajax({
										url: "'.$url.'",
										dataType: "json",
										data: {
											term: request.term,
										},
										success: function( data ) {
											response( data );
										}
									});
								},
								minLength: 2,
								autoFocus: true,
							};
		
							$( "#master_brosur_vSupplierName" ).livequery(function() {
							 	$( this ).autocomplete(config);
							});
		
						});
						
			      </script>
				  
				   <input name="'.$id.'" id="'.$id.'" size="" class="required" value="'.$value.'"type="text" data-validation="required" data-validation-error-msg="Nama sudah melebihi 50 karakter atau kosong sama sekali" />
				 ';
				 $o .= "<script>
                   			$('#".$id."').restrictLength($('#maxlengthsupplier'));
               			</script>";
        		$o .= '<br/>tersisa <span id="maxlengthsupplier">50</span> karakter<br/>';
        		$this->load->validator(1);
			
			$o .= "<div id='l_pic'></div>";

			
		}
		return $o;
	
		
	}
	
	function insertbox_master_brosur_vTags($field, $id) {
		//$o = "<input type='text' name='".$id."' id='".$id."'  size='50' data-validation='required' data-validation-error-msg='Nama sudah melebihi 250 karakter atau kosong sama sekali'  />";
		$o 	= "<textarea name='".$id."' id='".$id."' class='required' data-validation='required' data-validation-error-msg='Tags tidak boleh kosong'   style='width: 240px; height: 50px;'size='250'></textarea>";		

		$o .= '<br/>';
        $this->load->validator(1);
        
                                                
		return $o;
	}

	function updatebox_master_brosur_vTags($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Tags'>".$value."</label>";
		
		}else{
			$o 	= "<textarea name='".$id."' id='".$id."' class='required' data-validation='required' data-validation-error-msg='Tags tidak boleh kosong'   style='width: 240px; height: 50px;'size='250'>".nl2br($value)."</textarea>";
	        $o .= '<br/>';
	        $this->load->validator(1);
		}

		
		return $o;
	}

	function insertbox_master_brosur_vNote($field, $id) {
		$o 	= "<textarea name='".$id."' id='".$id."' style='width: 240px; height: 50px;'size='250'></textarea>";		
		$o .= "	<script>
				$('#".$id."').keyup(function() {
				var len = this.value.length;
				if (len >= 250) {
				this.value = this.value.substring(0, 250);
				}
				$('#maxlengthnote').text(250 - len);
				});
			</script>";
	    $o .= '<br/>tersisa <span id="maxlengthnote">250</span> karakter<br/>';
	    
	                                            
		return $o;
	}

	function updatebox_master_brosur_vNote($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Note'>".nl2br($value)."</label>";
		
		}else{
			//$o 	= '<textarea name="'.$id.'" id="'.$id.'" class="required">'.$value.'</textarea>';
			$o 	= "<textarea name='".$id."' id='".$id."'   style='width: 240px; height: 50px;'size='250'>".nl2br($value)."</textarea>";		
			$o .= "	<script>
				$('#".$id."').keyup(function() {
				var len = this.value.length;
				if (len >= 250) {
				this.value = this.value.substring(0, 250);
				}
				$('#maxlengthnote').text(250 - len);
				});
			</script>";
	    	$o .= '<br/>tersisa <span id="maxlengthnote">250</span> karakter<br/>';
	    
		}

		return $o;
	}
	
	function insertbox_master_brosur_vBrosur_no($field, $id) {
	//	$o = "<input type='hidden' name='".$id."' id='".$id."' readonly='readonly' value='".$today."'/>";
		$o = '<label title="Auto Number">Auto Generate</label>';
		return $o;
	}



	function updatebox_master_brosur_vBrosur_no($field, $id, $value, $rowData) {
		$o = "<input type='hidden' name='".$id."' id='".$id."' readonly='readonly' value='".$value."'/>";
		$o .= "<label title='Auto Number'>".$value."</label>";
		return $o;
	}



     function insertbox_master_brosur_dCreated($field, $id) {
		$today = date('d-m-Y', mktime());
		$current_date2 = date('d M Y', strtotime($today));
		//$today = realpath("files/plc/spek_soi_fg/");
		$o = "<input type='hidden' name='".$id."' id='".$id."' readonly='readonly' value='".$today."'/>";
		$o .= $current_date2;
		return $o;
	}

	function updatebox_master_brosur_dCreated($field, $id, $value, $rowData) {
		$today = date('d-m-Y', mktime());
		$current_date2 = date('d M Y', strtotime($value));
		//$today = realpath("files/plc/spek_soi_fg/");
		$o = "<input type='hidden' name='".$id."' id='".$id."' readonly='readonly' value='".$value."'/>";
		$o .= $current_date2;
		return $o;
	}



    function insertBox_master_brosur_vFileBrosur($field, $id) {
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('master_brosur_file',$data,TRUE);
	}

	 function updateBox_master_brosur_vFileBrosur($field, $id, $value, $rowData) {

	 	$id_brosur=$rowData['id'];
		$data['rows'] = $this->db_brosur0->get_where('brosur.brochure_file', array('id_brochure'=>$id_brosur))->result_array();
		return $this->load->view('master_brosur_file',$data,TRUE);
	}


/*manipulasi view object form end*/

/*manipulasi proses object form start*/
    function manipulate_insert_button($buttons) {
		unset($buttons['save']);
		$save_draft = '<button onclick="javascript:save_draft_btn(\'master_brosur\', \''.base_url().'master_brosur\', this)" class="ui-button-text icon-save" id="button_save_draft_soi_mikrobiologi">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'master_brosur\', \''.base_url().'processor/brosur/master/brosur?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_Master_brosur">Save</button>';
		$js = $this->load->view('master_brosur_js');
		$buttons['save'] = $save.$js;
		//$buttons['save'] = $save_draft.$save.$js;
		return $buttons;
	}
	
	 function manipulate_update_button($buttons) {
	 	if ($this->input->get('action') == 'view') {unset($buttons['update']);}

		else{
			unset($buttons['update']);
			$update = '<button onclick="javascript:update_btn_back(\'master_brosur\', \''.base_url().'processor/brosur/master/brosur?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_Master_brosur">Update</button>';
			$js = $this->load->view('master_brosur_js');
			$buttons['update'] = $update.$js;


		}
		$this->load->validator(1);
		
		return $buttons;
	}
   
/*manipulasi proses object form end*/    

/*function pendukung start*/    
	function getSpname() {
		$term = $this->input->get('term');		
		$data = array();
		$sql = "select distinct vSupplierName from brochure where vSupplierName like '%".$term."%'";
		$query = $this->db_brosur0->query($sql);
		if ($query->num_rows > 0) {
			foreach($query->result_array() as $line) {
				$row_array['value'] = trim($line['vSupplierName']);
				$row_array['id']    = $line['vSupplierName'];
				array_push($data, $row_array);
			}
		}
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
		$path = file_get_contents('./files/brosur/'.$id.'/'.$name);	
		force_download($name, $path);
	}

	public function after_insert_processor($fields, $id, $post) {

		$cNip = $this->user->gNIP;
		//$tgl = date('Y-m-d', mktime());
		$tUpdated = date('Y-m-d H:i:s', mktime());
		$SQL = "UPDATE brosur.brochure set cCreatedBy='{$cNip}', dCreated='{$tUpdated}' where id = '{$id}'";
		$this->db_brosur0->query($SQL);
		
		//update service_request autonumber No Brosur
		$nomor = "BR".str_pad($id, 8, "0", STR_PAD_LEFT);
		$sql = "UPDATE brosur.brochure SET vBrosur_no = '".$nomor."' WHERE id=$id LIMIT 1";
		$query = $this->db_brosur0->query( $sql );
		
		

	}
	public function after_update_processor($fields, $id, $post) {

		$cNip = $this->user->gNIP;
		$tUpdated = date('Y-m-d H:i:s', mktime());
		$SQL = "UPDATE brosur.brochure set cUpdatedBy='{$cNip}', dUpdated='{$tUpdated}' where id = '{$id}'";
		$this->db_brosur0->query($SQL);

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
			
			foreach($list_dir as $v) {				
				if (!in_array($v, $file_name)) {				
					unlink($path.'/'.$v);	
				}			
			}
			foreach($list_sql as $v) {
				if (!in_array($v, $file_name)) {
					$del = "delete from brosur.".$table." where id_brochure = {$lastId} and vFilename= '{$v}'";
					mysql_query($del);	
				}
				
			}
		} else {
			$this->readDirektory($path, 1);
			$this->readSQL($table, $lastId, 1);
		}
	} 

	function readSQL($table, $lastId, $empty="") {
		$list_file = array();
		if (empty($empty)) {
			$sql = "SELECT vFilename from brosur.".$table." where id_brochure=".$lastId;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['vFilename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT vFilename from brosur.".$table." where id_brochure=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM brosur.".$table." where id_brochure=".$lastId." and vFilename='".$row['vFilename']."'";			
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
/*function pendukung end*/    	

	
	




	

	
	

	public function output(){
		$this->index($this->input->get('action'));
	}

}
