<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bahan_baku_release_bb extends MX_Controller {
  		var $url;
		var $dbset;
	function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->user = $this->auth->user();
		$this->load->library('biz_process');
		$this->_table = 'plc2.plc2_upb_ro_detail';
		$this->_table2 = 'plc2.plc2_upb_request_sample';
		$this->_table3 = 'plc2.plc2_upb';
		$this->_table4 = 'plc2.plc2_upb_ro';
		$this->_table5 = 'plc2.plc2_raw_material';
		$this->_table6 = 'hrd.employee';
		$this->load->helper('to_mysql');
		$this->url = 'bahan_baku_release_bb';
		$this->dbset = $this->load->database('plc', true);
		
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('Release Bahan Baku');		
		$grid->setTable($this->_table);		
		$grid->setUrl('bahan_baku_release_bb');
		$grid->addList('plc2_upb_ro.vro_nomor','plc2_upb_request_sample.vreq_nomor','plc2_upb.vupb_nomor','plc2_raw_material.vnama','iapppd_rls');
		$grid->setWidth('plc2_upb_request_sample.vreq_nomor', 100);
		$grid->setWidth('plc2_upb_ro.vro_nomor', 100);
		$grid->setWidth('plc2_upb.vupb_nomor', 70);
		$grid->setJoinTable($this->_table2, $this->_table2.'.ireq_id = '.$this->_table.'.ireq_id', 'inner');
		$grid->setJoinTable($this->_table4, $this->_table4.'.iro_id = '.$this->_table.'.iro_id', 'inner');
		$grid->setJoinTable($this->_table3, $this->_table3.'.iupb_id = '.$this->_table2.'.iupb_id', 'inner');
		$grid->setJoinTable($this->_table5, $this->_table5.'.raw_id = '.$this->_table.'.raw_id', 'inner');
		$grid->setSortBy('irodet_id');
		$grid->setSortOrder('desc');
		//$grid->setRelation($this->_table_plc_upb.'.iteampd_id', $this->_table_plc_team, 'iteam_id', 'vteam', 'bdteam','inner', array('vtipe'=>'PD','ldeleted'=>0), array('vteam'=>'asc'));		
		
		$grid->setFormUpload(TRUE);

		$grid->changeFieldType('isyarat', 'combobox','',array(''=>'--select--', 0=>'-', 1=>'TMS', 2=>'MS'));
		$grid->changeFieldType('itujuan', 'combobox','',array(1=>'Bahan Baku Murah', 2=>'Sumber Supplier Baru', 3=>'Harga Murah', 4=>'Lain-lain'));
		$grid->changeFieldType('iprioritas', 'combobox','',array(4=>'Urgent', 1=>'#1', 2=>'#2', 3=>'#3'));
		$grid->changeFieldType('iappmoa', 'combobox','',array(''=>'-', 1=>'Tidak', 2=>'Baik'));
		$grid->changeFieldType('iappmutu', 'combobox','',array(''=>'-', 1=>'Tidak', 2=>'Ada'));
		$grid->changeFieldType('iappinspeksi', 'combobox','',array(''=>'-', 1=>'Tidak', 2=>'Sesuai'));
		$grid->changeFieldType('iapptrial', 'combobox','',array(''=>'-', 1=>'Tidak', 2=>'Sesuai'));
		$grid->changeFieldType('irelease', 'combobox','',array(''=>'-', 1=>'Tidak', 2=>'Ya'));
		$grid->changeFieldType('istatus', 'combobox','',array(1=>'Has been Approved (Final)', 2=>'Need to be Approved'));
		
		$grid->addFields('ipo_id','imanufacture_id','raw_id','vnama_produk','vbatch_no','texp_date','vrec_jum_pd','vwadah');
		$grid->addFields('irelease','vfilename_release');
		$grid->addFields('vsatuan','vreq_nomor','vro_nomor','iupb_id','vnip_apppd_rls');		
		
		$grid->setLabel('ipo_id','No. PO');
		$grid->setLabel('imanufacture_id','Manufacturer');
		$grid->setLabel('raw_id','Bahan Baku');
		$grid->setLabel('vnama_produk','Nama Produk');
		$grid->setLabel('vbatch_no','No. Batch');
		$grid->setLabel('texp_date','Tanggal expired');
		$grid->setLabel('vrec_jum_pd','Jumlah Terima PD');
		$grid->setLabel('vwadah','Jumlah Wadah');
		$grid->setLabel('vsample','Jumlah Sample yang diterima AD');
		$grid->setLabel('vnip_inspektor','Analyst');
		$grid->setLabel('vpembanding','Sample Pembanding');
		$grid->setLabel('isyarat','Kesimpulan');
		$grid->setLabel('plc2_upb_ro_detail.isyarat','Kesimpulan');
		
		$grid->setLabel('plc2_upb_ro_detail.irelease','Release');
		$grid->setLabel('irelease','Release');
		$grid->setLabel('plc2_upb_ro_detail.vfilename_release','Filename Release');
		$grid->setLabel('vfilename_release','Filename Release');
		$grid->setLabel('iapppd_rls','Approval PD');
		$grid->setLabel('vnip_apppd_rls','Approval PD');
		
		$grid->setLabel('vrujukan','Rujukan');
		$grid->setLabel('vfilename_moa','Upload File');
		$grid->setLabel('vfilename_mikro','Uji Mikrobiologi');
		$grid->setLabel('vnip_suppd','Supervisor');
		$grid->setLabel('tapp_suppd','Tanggal');
		$grid->setLabel('tapp_qc','Tanggal');
		$grid->setLabel('tcatatan','Catatan');
		$grid->setLabel('vsatuan','Satuan');
		$grid->setLabel('vreq_nomor','No. Permintaan');
		$grid->setLabel('vro_nomor','No. Terima');
		$grid->setLabel('iupb_id','No. UPB');
		$grid->setLabel('plc2_upb_ro.vro_nomor','No. Terima');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('plc2_upb_request_sample.vreq_nomor','No. Permintaan');
		$grid->setLabel('plc2_raw_material.vnama','Bahan Baku');
		//$grid->setLabel('detail_uji_bb','Pemeriksaan Bahan Baku');
		$grid->setLabel('iapppd_analisa','Approval PD');
		$grid->setLabel('vnip_apppd_analisa','Approval PD');
		$grid->setSearch('plc2_raw_material.vnama');
		$grid->setQuery('plc2_upb.ihold', 0);
		$grid->setQuery('plc2_upb_ro_detail.ldeleted', 0);	
		$grid->setQuery('plc2_upb_ro.iclose_po', 1);
		$grid->setQuery('vrec_jum_pd is not null',null);
		$grid->setQuery('vrec_jum_qa is not null',null);
		$grid->setQuery('vrec_jum_qc is not null',null);
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		//$grid->setGridView('grid');
		
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
				$sql1 = array();
				if($isUpload) {
					$path = realpath("files/plc/bahan_baku/release");
					
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
								$sql[] = "INSERT INTO plc2_upb_file_bahan_baku_release(irodet_id, filename, dInsertDate, vketerangan,cInsert) 
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
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				$isUpload = $this->input->get('isUpload');
				$sql = array();
   				$sql1 = array();
				$file_name= "";
				$file_name1= "";
				
				$fileId = array();
				
				$path = realpath("files/plc/bahan_baku/release");
				
				if (!file_exists( $path."/".$this->input->post('bahan_baku_release_bb_irodet_id') )) {
					mkdir($path."/".$this->input->post('bahan_baku_release_bb_irodet_id'), 0777, true);						 
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
						$this->hapusfile($path, $file_name, 'plc2_upb_file_bahan_baku_release', $this->input->post('bahan_baku_release_irodet_id'));
						foreach ($_FILES['fileupload']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
								$name = $_FILES['fileupload']["name"][$key];
								$data['filename'] = $name;
								$data['id']=$this->input->post('bahan_baku_release_bb_irodet_id');
								$data['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name, $path."/".$this->input->post('bahan_baku_release_bb_irodet_id')."/".$name)) 
				 				{				 					
									$sql[] = "INSERT INTO plc2_upb_file_bahan_baku_release(irodet_id, filename, dInsertDate, vketerangan,cInsert) 
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
					$r['last_id'] = $this->input->post('bahan_baku_release_bb_irodet_id');					
					echo json_encode($r);
					exit();
				}  else {
					if (is_array($file_name)) {									
						$this->hapusfile($path, $file_name, 'plc2_upb_file_bahan_baku_release', $this->input->post('bahan_baku_release_bb_irodet_id'));
					}
					echo $grid->updated_form();
				}
				break;
			case 'delete':
				echo $grid->delete_row();
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
			case 'reject':
				echo $this->reject_view();
				break;
			case 'reject_process':
				echo $this->reject_process();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }
	public function listBox_Action($row, $actions) {
    	//print_r($row);
		//cek apakah sudah diapprove,
		if($row->iapppd_rls!=0){
			unset($actions['edit']);
			unset($actions['delete']);
		}
		return $actions;
    }
	function listBox_bahan_baku_release_bb_iapppd_rls($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	function updateBox_bahan_baku_release_bb_ipo_id($name, $id, $value, $rowData) {
		//print_r($rowData);	
		$row = $this->db_plc0->get_where('plc2.plc2_upb_po', array('ipo_id'=>$rowData['ipo_id']))->row_array();
		return '<input type="hidden" value="'.$rowData['ipo_id'].'" name="'.$id.'" id="'.$id.'" class="" /><span id="'.$id.'">'.$row['vpo_nomor'].'</span>';
	}
	function updateBox_bahan_baku_release_bb_imanufacture_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('hrd.mnf_manufacturer', array('imanufacture_id'=>$rowData['imanufacture_id']))->row_array();
		if(sizeOf($row) > 0){
			return '<span id="'.$id.'">'.$row['vnmmanufacture'].'</span>';
		}
		else{
			return '<span id="'.$id.'">' - '</span>';
		}
	}
	
	function updateBox_bahan_baku_release_bb_raw_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_raw_material', array('raw_id'=>$rowData['raw_id']))->row_array();
		return '<span id="'.$id.'">'.$row['vnama'].'</span>
		<input type="hidden" name="iraw_id" value="'.$rowData['raw_id'].'" />
		';
	}
	function updateBox_bahan_baku_release_bb_vnama_produk($name, $id, $value, $rowData) {
		return '<span id="'.$id.'">'.$value.'</span>';
	}
	function updateBox_bahan_baku_release_bb_vbatch_no($name, $id, $value, $rowData) {
		return '<span id="'.$id.'">'.$value.'</span>';
	}
	function updateBox_bahan_baku_release_bb_texp_date($name, $id, $value, $rowData) {
		if($value != '' && $value != '0000-00-00') {
			$value = date('d M Y', strtotime($value));
		}
		else {
			$value = '';
		}		
		return '<span id="'.$id.'">'.$value.'</span>';
	}
	function updateBox_bahan_baku_release_bb_vrec_jum_pd($name, $id, $value, $rowData) {
		return '<span id="'.$id.'">'.$value.' '.$rowData['vsatuan'].'</span>';
	}
	function updateBox_bahan_baku_release_bb_vwadah($name, $id, $value, $rowData) {
		return '<span id="'.$id.'">'.$value.'</span>';
	}
	
	function updateBox_bahan_baku_release_bb_irelease($name, $id, $value, $rowData) {
		$mydept = $this->auth->my_depts(TRUE);
		$array = array(0=>'-', 1=>'Tidak', 2=>'Ya');
		if(is_array($mydept)){
			if(in_array('PD', $mydept)) {
				return form_dropdown($name, $array, $value);
			}
			else {
				return '<span id="'.$id.'">'.$array[$value].'</span>';
			}
		}
		else {
			return '<span id="'.$id.'">'.$array[$value].'</span>';
		} 		
	}
	function updateBox_bahan_baku_release_bb_vfilename_release($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE);	
		$idrodet = $rowData['irodet_id'];
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_bahan_baku_release', array('irodet_id'=>$idrodet))->result_array();
		return $this->load->view('bahan_baku_release_file',$data,TRUE);
	}
	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/bahan_baku/release/'.$id.'/'.$name);	
		force_download($name, $path);
	}
	
	function updateBox_bahan_baku_release_bb_vsatuan($name, $id, $value, $rowData) {
		return '<span id="'.$id.'">'.$value.'</span>';
	}
	
	function updateBox_bahan_baku_release_bb_vreq_nomor($name, $id, $value, $rowData) {
		$sql = "SELECT vreq_nomor FROM ".$this->_table2." r WHERE r.ireq_id = '".$rowData['ireq_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		return '<span id="'.$id.'">'.$row['vreq_nomor'].'</span>';
	}
	function updateBox_bahan_baku_release_bb_vro_nomor($name, $id, $value, $rowData) {
		$sql = "SELECT vro_nomor FROM ".$this->_table4." r WHERE r.iro_id = '".$rowData['iro_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		return '<span id="'.$id.'">'.$row['vro_nomor'].'</span>';
	}
	function updateBox_bahan_baku_release_bb_iupb_id($name, $id, $value, $rowData) {
		$sql = "SELECT vupb_nomor FROM ".$this->_table2." r INNER JOIN ".$this->_table3." u ON r.iupb_id = u.iupb_id WHERE r.ireq_id = '".$rowData['ireq_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		return '<span id="'.$id.'">'.$row['vupb_nomor'].'</span>';
	}
	//Keterangan approval 
	function insertBox_bahan_baku_release_bb_vnip_apppd_rls($field, $id) {
		return '-';
	}
	function updateBox_bahan_baku_release_bb_vnip_apppd_rls($field, $id, $value, $rowData) {
		//print_r($rowData);
		if($rowData['vnip_apppd_rls'] != null){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_apppd_rls']))->row_array();
			if($rowData['iapppd_rls']==2){$st="Approved";}elseif($rowData['iapppd_rls']==1){$st="Rejected";
				// $rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// if(isset($rowa)){$reason=$rowa['treason'];}
				
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_apppd_rls'].' )'.' pada '.$rowData['tapppd_rls'];
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	//
	function before_update_processor($row, $post, $postData) {
		//print_r($postData);
		return $postData;
	}
	
	function after_update_processor($row, $insertId, $postData, $old_data) {
		$this->load->helper(array('search_array','mydb'));
		$this->plcdb = mydb('plc');
		$post = $this->input->post();
		
		$ipo_id = $postData['ipo_id'];
		//get upb_id
		$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
					select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		
		foreach($riu as $xx){
			$iupb_id=$xx['iupb_id'];
			$getbp=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // activity 3 input data
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
			$hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,7); // status 7 => submit
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//update last log
					$this->biz_process->update_last_log($iupb_id, $bizsup, 7);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($iupb_id, $bizsup, 7);
			}
		}
	}
	function manipulate_update_button($buttons, $rowData) {
    	unset($buttons['update_back']);
    	unset($buttons['update']);
		//print_r($rowData);
		//echo $rowData['vnip_formulator']."<br>".$this->user->gNIP;
    	$user = $this->auth->user();
    
    	$x=$this->auth->dept();
    	if($this->auth->is_manager()){
    		$x=$this->auth->dept();
    		$manager=$x['manager'];
    		if(in_array('PD', $manager)){$type='PD';}
    		else{$type='';}
    	}
		else{
			$x=$this->auth->dept();
    		$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';}
			else{$type='';}
		}
		
		//echo $type;
		// cek status upb, klao upb 
			unset($buttons['update_back']);
    		unset($buttons['update']);
			
			//echo $this->auth->my_teams();
			
    		$ipo_id=$rowData['ipo_id'];
    		$irodet_id=$rowData['irodet_id'];
    		
			//get upb_id
			$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
						select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
			$riu = $this->db_plc0->query($qiupb)->result_array();
			//print_r($riu);

			$qcek="select * from plc2.plc2_upb_ro_detail f where f.irodet_id=$irodet_id";
			$rcek = $this->db_plc0->query($qcek)->row_array();
			$js = $this->load->view('bahan_baku_release_js');
			
			$x=$this->auth->my_teams();
			//print_r($x);
			$arrhak=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
		//print_r($arrhak);
			if(empty($arrhak)){
				$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
				if(empty($getbp)){}
				else{
					if($this->auth->is_manager()){ //jika manager PR
						if(($type=='PD')&&($rcek['iapppd_rls']==0)){
							$update = '<button onclick="javascript:update_btn_back(\'bahan_baku_release_bb\', \''.base_url().'processor/plc/bahan/baku/release/bb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_bb_analisa_sample">Update</button>';
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/baku/release/bb?action=approve&ipo_id='.$ipo_id.'&irodet_id='.$irodet_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bb_release">Approve</button>';
							$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/baku/release/bb?action=reject&ipo_id='.$ipo_id.'&irodet_id='.$irodet_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bb_release">Reject</button>';
								
							$buttons['update'] = $update.$approve.$reject.$js;
						}
						else{}
					}
					else{
						if(($type=='PD')&&($rcek['iapppd_rls']==0)){
							$update = '<button onclick="javascript:update_btn_back(\'bahan_baku_release_bb\', \''.base_url().'processor/plc/bahan/baku/release/bb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_bb_release">Update</button>';
							$buttons['update'] = $update.$js;
						}
					}
				}
			}else{
				if($this->auth->is_manager()){ //jika manager PR
					if(($type=='PD')&&($rcek['iapppd_rls']==0)){
							$update = '<button onclick="javascript:update_btn_back(\'bahan_baku_release_bb\', \''.base_url().'processor/plc/bahan/baku/release/bb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_bb_release">Update</button>';
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/baku/release/bb?action=approve&ipo_id='.$ipo_id.'&irodet_id='.$irodet_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bb_release">Approve</button>';
							$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/baku/release/bb?action=reject&ipo_id='.$ipo_id.'&irodet_id='.$irodet_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bb_release">Reject</button>';
								
							$buttons['update'] = $update.$approve.$reject.$js;
						}
					else{}
					//array_unshift($buttons, $reject, $approve, $revise);
				}
				else{
					if(($type=='PD')&&($rcek['iapppd_rls']==0)){
						$update = '<button onclick="javascript:update_btn_back(\'bahan_baku_release_bb\', \''.base_url().'processor/plc/bahan/baku/release/bb?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_bb_analisa_sample">Update</button>';
						$buttons['update'] = $update.$js;
					}
					else{}
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
								var url = "'.base_url().'processor/plc/bahan/baku/release/bb";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_bahan_baku_release_bb").html(data);
									});
					
								}
									reload_grid("grid_bahan_baku_release_bb");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_bahan_baku_release_bb_approve" action="'.base_url().'processor/plc/bahan/baku/release/bb?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="ipo_id" value="'.$this->input->get('ipo_id').'" />
				<input type="hidden" name="irodet_id" value="'.$this->input->get('irodet_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_bahan_baku_release_bb_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$this->db_plc0->where('irodet_id', $post['irodet_id']);
		$this->db_plc0->update('plc2.plc2_upb_ro_detail', array('iapppd_rls'=>2,'vnip_apppd_rls'=>$nip,'tapppd_rls'=>$skg));
    
    	$ipo_id = $post['ipo_id'];
    	$irodet_id = $post['irodet_id'];
		//get upb_id
		$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
					select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		
		foreach($riu as $xx){
			$ins['iupb_id'] = $xx['iupb_id'];
			$ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
			$ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
			$ins['idiv_id'] = '';
			$ins['vtipe'] = $post['type'];
			$ins['iapprove'] = '2';
			$ins['cnip'] = $this->user->gNIP;
			$ins['treason'] = $post['remark'];
			$ins['tupdate'] = date('Y-m-d H:i:s');
		
			$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
		
			$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$post['modul_id']); // 1 approval
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
			$hacek=$this->biz_process->cek_last_status($xx['iupb_id'],$bizsup,1); // status 1 => app
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($xx['iupb_id'], $bizsup, 1); // status 1 => app
				//update last log
					$this->biz_process->update_last_log($xx['iupb_id'], $bizsup, 1);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($xx['iupb_id'], $bizsup, 1); // status 1 => app
				//insert last log
					$this->biz_process->insert_last_log($xx['iupb_id'], $bizsup, 1);
			}
		}
    	
		$data['status']  = true;
    	$data['last_id'] = $irodet_id;
    	return json_encode($data);
    }
    
    function reject_view() {
    	$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	if($("#remark").val()==""){
							alert("Isi alasan! ");
							return false;
						}
						 else{
							return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/bahan/baku/release/bb";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_bahan_baku_release_bb").html(data);
									});
					
								}
									reload_grid("grid_bahan_baku_release_bb");
							}
							})
						 }
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_bahan_baku_release_bb_reject" action="'.base_url().'processor/plc/bahan/baku/release/bb?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="ipo_id" value="'.$this->input->get('ipo_id').'" />
				<input type="hidden" name="irodet_id" value="'.$this->input->get('irodet_id').'" />
    			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark" id="remark" required></textarea><button type="button" onclick="submit_ajax(\'form_bahan_baku_release_bb_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process () {
    	$post = $this->input->post();
    	$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
	 	$this->db_plc0->where('irodet_id', $post['irodet_id']);
		$this->db_plc0->update('plc2.plc2_upb_ro_detail', array('iapppd_rls'=>1,'vnip_apppd_rls'=>$nip,'tapppd_rls'=>$skg));
    
		$ipo_id = $post['ipo_id'];
		$irodet_id = $post['irodet_id'];
		//get upb_id
		$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
					select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		
		foreach($riu as $xx){
			$ins['iupb_id'] = $xx['iupb_id'];
			$ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
			$ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
			$ins['idiv_id'] = '';
			$ins['vtipe'] = $post['type'];
			$ins['iapprove'] = '2';
			$ins['cnip'] = $this->user->gNIP;
			$ins['treason'] = $post['remark'];
			$ins['tupdate'] = date('Y-m-d H:i:s');
		
			$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
		
			$getbp=$this->biz_process->get(1, $this->auth->my_teams(),$post['modul_id']); // 1 approval
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
				
			$hacek=$this->biz_process->cek_last_status($xx['iupb_id'],$bizsup,2); // status 2 => reject
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($xx['iupb_id'], $bizsup, 2); // status 2 => reject
				//update last log
					$this->biz_process->update_last_log($xx['iupb_id'], $bizsup, 2);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($xx['iupb_id'], $bizsup, 2); // status 2 => reject
				//insert last log
					$this->biz_process->insert_last_log($xx['iupb_id'], $bizsup, 2);
			}
		}
		
    	$data['status']  = true;
    	$data['last_id'] = $irodet_id;
    	return json_encode($data);
    }
	function output(){		
    	$this->index($this->input->get('action'));
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
					$del = "delete from plc2.".$table." where irodet_id = {$lastId} and filename= '{$v}'";
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
			$sql = "SELECT filename from plc2.".$table." where irodet_id=".$lastId;
			//echo $sql;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['filename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT filename from plc2.".$table." where irodet_id=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM plc2.".$table." where irodet_id=".$lastId." and filename='".$row['filename']."'";			
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
}