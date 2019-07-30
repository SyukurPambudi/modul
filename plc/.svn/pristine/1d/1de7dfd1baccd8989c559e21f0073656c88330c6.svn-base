<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class import_daftar_upi_detail extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
        $this->load->library('biz_process');
        $this->load->library('lib_utilitas');
		$this->user = $this->auth->user(); 
		$this->dbset = $this->load->database('plc', true);
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Daftar UPI Detail');
		//dc.m_vendor  database.tabel
		$grid->setTable('plc2.daftar_upi');		
		$grid->setUrl('import_daftar_upi_detail');
		$grid->addList('vNo_upi','vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori','iSubmit_upi_detail');
		$grid->setSortBy('vNo_upi');
		$grid->setSortOrder('desc'); //sort ordernya

		$grid->addFields('iApprove_bdirm','iApprove_dir','vNo_upi','dTgl_upi','cPengusul_upi','vNama_usulan','vKekuatan','vDosis','vNama_generik','vIndikasi','ikategori_id','ikategoriupi_id');
		$grid->addFields('isediaan_id','itipe_id','ibe','vhpp_target','tunique','tpacking','ttarget_prareg');
		$grid->addFields('ipatent','tinfo_paten','patent_year','iteammarketing_id');
		$grid->addFields('iregister','tmemo_bde','dokumen_tambahan');
		$grid->addFields('dokumen_bahan_baku','dokumen_standar_mutu','komposisi_upi');
		$grid->addFields('fMkt_forcast','fSales_upbk','fSales_upb','fSales_newk','fSales_new','iForcast_year1','iForcast_year2','iForcast_year3');

		//setting widht grid
		$grid->setLabel('iSubmit_upi_detail','Status'); 
		$grid ->setWidth('iSubmit_upi_detail', '100'); 
		$grid->setAlign('iSubmit_upi_detail', 'center'); 		

		$grid->setLabel('iApprove_bdirm','Approval BDIRM'); 
		$grid ->setWidth('iApprove_bdirm', '150'); 
		$grid->setAlign('iApprove_bdirm', 'center'); 

		$grid->setLabel('iApprove_dir','Approval Direksi'); 
		$grid ->setWidth('iApprove_dir', '150'); 
		$grid->setAlign('iApprove_dir', 'center'); 

		$grid->setLabel('vNo_upi','No UPI'); 
		$grid ->setWidth('vNo_upi', '100'); 
		$grid->setAlign('vNo_upi', 'center'); 

		$grid->setLabel('dTgl_upi','Tanggal UPI'); 
		$grid ->setWidth('dTgl_upi', '100'); 
		$grid->setAlign('dTgl_upi', 'center'); 

		$grid->setLabel('cPengusul_upi','Nama Pengusul'); 
		$grid ->setWidth('cPengusul_upi', '250'); 
		$grid->setAlign('cPengusul_upi', 'center');

		$grid->setLabel('vNama_usulan','Nama Usulan'); 
		$grid ->setWidth('vNama_usulan', '250'); 
		$grid->setAlign('vNama_usulan', 'left');

		$grid->setLabel('vKekuatan','Kekuatan'); 
		$grid ->setWidth('vKekuatan', '10'); 
		$grid->setAlign('vKekuatan', 'center');

		$grid->setLabel('vDosis','Dosis'); 
		$grid ->setWidth('vDosis', '10'); 
		$grid->setAlign('vDosis', 'center');

		$grid->setLabel('vNama_generik','Nama Generik'); 
		$grid ->setWidth('vNama_generik', '10'); 
		$grid->setAlign('vNama_generik', 'center');

		$grid->setLabel('vIndikasi','Indikasi'); 
		$grid ->setWidth('vIndikasi', '10'); 
		$grid->setAlign('vIndikasi', 'center');
		
		$grid->setLabel('mnf_kategori.vkategori','Kategori Produk'); 
		$grid->setLabel('ikategori_id','Kategori Produk'); 
		$grid ->setWidth('ikategori_id', '150'); 
		$grid->setAlign('ikategori_id', 'center');

		$grid->setLabel('plc2_upb_master_kategori_upb.vkategori','Kategori UPI'); 
		$grid->setWidth('plc2_upb_master_kategori_upb.vkategori','50'); 
		$grid->setAlign('plc2_upb_master_kategori_upb.vkategori','center'); 
		
		$grid->setLabel('ikategoriupi_id','Kategori UPI'); 
		$grid ->setWidth('ikategoriupi_id', '150'); 
		$grid->setAlign('ikategoriupi_id', 'center');



		$grid->setLabel('vNama_usulan','Nama Usulan'); 
		$grid ->setWidth('vNama_usulan', '300'); 


		$grid->setLabel('isediaan_id','Sediaan Produk'); 
		$grid->setLabel('itipe_id','Type Produk'); 
		$grid->setLabel('ibe','Tipe BE'); 
		$grid->setLabel('vhpp_target','Target HPP'); 
		$grid->setLabel('tunique','Keunggulan Produk');
		$grid->setLabel('tpacking','Spesifikasi Kemasan');
		$grid->setLabel('ttarget_prareg','Estimasi Pra Registrasi');
		$grid->setLabel('ipatent','Tipe Hak Paten');
		$grid->setLabel('tinfo_paten','Informasi Hak Paten');
		$grid->setLabel('patent_year','Paten Exp');
		$grid->setLabel('iteammarketing_id','Team Marketing');

		$grid->setLabel('iregister','Registrasi Untuk');
		$grid->setLabel('tmemo_bde','Memo');

		$grid->setLabel('fMkt_forcast','Marketing Forecast');
		$grid->setLabel('fSales_upbk','Total Sales Unit di UPB (+000000)');
		$grid->setLabel('fSales_upb','Total Sales Unit di UPB');
		$grid->setLabel('fSales_newk','Total Sales Unit Terbaru (+000000)');
		$grid->setLabel('fSales_new','Total Sales Unit Terbaru');
		$grid->setLabel('iForcast_year1','Forcast Untuk Aggrement Year 1');
		$grid->setLabel('iForcast_year2','Forcast Untuk Aggrement Year 2');
		$grid->setLabel('iForcast_year3','Forcast Untuk Aggrement Year 3');		

		//search 
		$grid->setSearch('vNo_upi','vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori');
		
		
		$grid->setLabel('dupdate','Tgl Update'); 
		$grid->setLabel('cUpdate','Update By'); 
		
		$grid->setFormUpload(TRUE);
		
		//Field yg mandatori
		$grid->setRequired('vNo_upi','dTgl_upi','cPengusul_upi','vNama_usulan','vKekuatan','vDosis','vNama_generik','vIndikasi','ikategori_id','ikategoriupi_id');//,'history','dupdate','cUpdate');
		$grid->setRequired('itipe_id','ibe','ipatent','iregister');//,'history','dupdate','cUpdate');
		//$grid->setRequired('vNo_upi','vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori');
		//$grid->setRequired('vNo_upi','vNama_usulan');	
		//$grid->setRequired('vNama_usulan');	
		$grid->setQuery('daftar_upi.lDeleted = "0" ', null);	
		$grid->setQuery('daftar_upi.iApprove_dir = "2" ', null);	
		$grid->setQuery('daftar_upi.iStatusKill = "0" ', null);	
		// rekomendasi paten Yes
		$grid->setQuery('telusur_paten.iRekomendasi_produk = "2" ', null);
		//$grid->setQuery('setting_prioritas_upi.iApprove_dir = "2" ', null);	
		
		// kondisi datatable
		//$grid->setQuery('istatus = "0" ', null);	
		$grid->setJoinTable('hrd.mnf_kategori', 'mnf_kategori.ikategori_id = daftar_upi.ikategori_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_master_kategori_upb', 'plc2_upb_master_kategori_upb.ikategori_id = daftar_upi.ikategoriupi_id', 'inner');
		$grid->setJoinTable('plc2.telusur_paten', 'telusur_paten.iupi_id = daftar_upi.iupi_id', 'inner');
		//$grid->setJoinTable('plc2.setting_prioritas_upi_detail', 'setting_prioritas_upi_detail.iupi_id = daftar_upi.iupi_id', 'inner');
		//$grid->setJoinTable('plc2.setting_prioritas_upi', 'setting_prioritas_upi.isetting_prioritas_upi_id = setting_prioritas_upi_detail.isetting_prioritas_upi_id', 'inner');
	//	$grid->setQuery('asset.asset_sparepart.history', 0);
		//$grid->setMultiSelect(true);


		$grid->changeFieldType('itipe_id','combobox','',array(''=>'Select One',1=>'Lokal', 2=>'Import',3=>'Export'));
		$grid->changeFieldType('ibe','combobox','',array(''=>'Select One',1=>'BE', 2=>'Non BE'));
		$grid->changeFieldType('ipatent','combobox','',array(''=>'Select One',1=>'Indonesia', 2=>'International', 3=>'Off Patent'));
		$grid->changeFieldType('iregister','combobox','',array(''=>'Select One',3=>'PT. Novell Pharm', 5=>'PT. Etercon Pharm'));
		$grid->changeFieldType('iSubmit_upi_detail','combobox','',array('0'=>'Draft','1'=>'Submitted'));

		
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
					echo $grid->saved_form();
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
				$path = realpath("files/plc/import/upi/dok_tambah/");
				
				if (!file_exists( $path."/".$this->input->post('import_daftar_upi_detail_iupi_id') )) {
					mkdir($path."/".$this->input->post('import_daftar_upi_detail_iupi_id'), 0777, true);						 
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
						$this->hapusfile($path, $file_name, 'upi_file_dokumen_tambah', $this->input->post('import_daftar_upi_detail_iupi_id'));
						foreach ($_FILES['fileupload']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
								$name = $_FILES['fileupload']["name"][$key];
								$data['filename'] = $name;
								$data['id']=$this->input->post('import_daftar_upi_detail_iupi_id');
								$data['nip']=$this->user->gNIP;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
				 				if(move_uploaded_file($tmp_name, $path."/".$this->input->post('import_daftar_upi_detail_iupi_id')."/".$name)) 
				 				{
				 					
									$sql[] = "INSERT INTO upi_file_dokumen_tambah (iupi_id, vFilename, dCreated, vKeterangan, cCreatedBy) 
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
					$r['last_id'] = $this->input->post('import_daftar_upi_detail_iupi_id');					
					echo json_encode($r);
					exit();
				}  else {
					
					if (is_array($file_name)) {									
						$this->hapusfile($path, $file_name, 'upi_file_dokumen_tambah', $this->input->post('import_daftar_upi_detail_iupi_id'));
					}
													
					echo $grid->updated_form();
				}
				break;
				/*
					echo $grid->updated_form();
				break;
				*/
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
			case 'gethistkomposisi':
				echo $this->gethistkomposisi();
				break;	
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }

    function gethistkomposisi(){
	    $raw_id=$_POST['raw_id'];
		$data = array();
		$row_array = '';
		$sql2 = "select b.vNo_upi
				from plc2.upi_komposisi a
				join plc2.daftar_upi b on b.iupi_id=a.iupi_id
				where  a.ldeleted=0 and b.ldeleted=0 and a.raw_id='".$raw_id."'";
		$results = $this->dbset->query($sql2)->result_array();

		$i=1;
		foreach ($results as $item ) {
			if ($i==1) {
				$row_array .= trim($item['vNo_upi']);	
			}else{
				$row_array .= ','.trim($item['vNo_upi']);		
			}
			

			$i++;
		}
	 	
	 	
	 	
	 	array_push($data, $row_array);
	 	echo json_encode($data);
	    exit;

    }


    function searchBox_import_daftar_upi_detail_mnf_kategori_vkategori($rowData, $id) {
		$teams = $this->db_plc0->get_where('hrd.mnf_kategori', array('ldeleted' => 0))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['vkategori'].'">'.$t['vkategori'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    } 

    function searchBox_import_daftar_upi_detail_plc2_upb_master_kategori_upb_vkategori($rowData, $id) {
		$teams = $this->db_plc0->get_where('plc2.plc2_upb_master_kategori_upb', array('ldeleted' => 0))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['vkategori'].'">'.$t['vkategori'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }   

   
	function listBox_Action($row, $actions) {

	 	$mydept = $this->auth->my_depts(TRUE);
	 	$x = $this->auth->my_teams();
		$array = explode(',', $x);
		// cek user bagian dari tim bd terkait
		

	 	if ($row->iSubmit_upi_detail<>0) {
	 		// status sudah diapprove or reject , button edit hide 
	 		 unset($actions['edit']);
	 		 unset($actions['delete']);
	 	}else{
	 		$mydept = $this->auth->my_depts(TRUE);
	 		if (isset($mydept)) 
			{
				if((!in_array('BDE', $mydept)) && (!in_array('BDI', $mydept))) {
					unset($actions['edit']);
	 		 		unset($actions['delete']);
				}
			}
	 		
	 	}


	 	
		 return $actions;
	}

/*manipulasi view object form start*/

	function insertBox_import_daftar_upi_detail_iApprove_bdirm($field, $id) {
		return '-';
	}

	function updateBox_import_daftar_upi_detail_iApprove_bdirm($field, $id, $value, $rowData) {
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = 'select * 
						from plc2.daftar_upi a 
						join hrd.employee b on b.cNip=a.cApprove_bdirm
						where
						a.lDeleted = 0
						and  a.iupi_id = "'.$rowData['iupi_id'].'"';
			$row = $this->db_plc0->query($sql_dtapp)->row_array();
			if($value==2){
				$st='<p style="color:green;font-size:120%;">Approved';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_bdirm'].'</br> Alasan: '.$row['vRemark_bdirm'].'</p>';
			}
			elseif($value==1){
				$st='<p style="color:red;font-size:120%;">Rejected';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_bdirm'].'</br> Alasan: '.$row['vRemark_bdirm'].'</p>';
			} 

			
			
			
		}
		else{
			$ret='Waiting for Approval';
		}
		$ret .= "<input type='hidden' name='".$field."' id='".$id."'  value='".$value."'/>";
		return $ret;
	}

	function insertBox_import_daftar_upi_detail_iApprove_dir($field, $id) {
		return '-';
	}

	function updateBox_import_daftar_upi_detail_iApprove_dir($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = 'select * 
						from plc2.daftar_upi a 
						join hrd.employee b on b.cNip=a.cApprove_dir
						where
						a.lDeleted = 0
						and  a.iupi_id = "'.$rowData['iupi_id'].'"';
			$row = $this->db_plc0->query($sql_dtapp)->row_array();
			if($value==2){
				$st='<p style="color:green;font-size:120%;">Approved';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_dir'].'</br> Alasan: '.$row['vRemark_dir'].'</p>';
			}
			elseif($value==1){
				$st='<p style="color:red;font-size:120%;">Rejected';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_dir'].'</br> Alasan: '.$row['vRemark_dir'].'</p>';
			} 

			
			
			
		}
		else{
			$ret='Waiting for Approval';
		}
		$ret .= "<input type='hidden' name='".$field."' id='".$id."'  value='".$value."'/>";
		return $ret;
	}


	function insertBox_import_daftar_upi_detail_vNo_upi($field, $id) {
		$o = '<label title="Auto Number">Auto Generate</label>';
		return $o;
	}



	function updateBox_import_daftar_upi_detail_vNo_upi($field, $id, $value, $rowData) {
		$o = "<input type='hidden' name='".$field."' id='".$id."'  value='".$value."'/>";
		$o .= "<label title='Auto Number'>".$value."</label>";
		return $o;
	}


	function insertBox_import_daftar_upi_detail_cPengusul_upi($field, $id) {
		$cNip = $this->user->gNIP;
		$emp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$cNip))->row_array();

		$o = "<input type='hidden' name='".$field."' id='".$id."'   value='".$emp['cNip']."'/>
				<input type='hidden' name='isdraft' id='isdraft'>
			";
		$o .= "<label title='Auto Number'>".$emp['cNip'].' | '.$emp['vName']."</label>";
		return $o;
	}
	
	
	function updateBox_import_daftar_upi_detail_cPengusul_upi($field, $id, $value, $rowData) {
		$vcNip = $value;
		$vemp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$vcNip))->row_array();

		$cNip = $this->user->gNIP;
		$emp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$cNip))->row_array();

		if ($this->input->get('action') == 'view') {
			$return= $vemp['cNip'].' | '.$vemp['vName'];

		}
		else{
			$return = "<input type='hidden' name='".$field."' id='".$id."'   value='".$vemp['cNip']."'/>
						<input type='hidden' name='isdraft' id='isdraft'>
					";
			$return .= "<label title='Auto Number'>".$vemp['cNip'].' | '.$vemp['vName']."</label>";

		}

		return $return;
	
	}

	function insertBox_import_daftar_upi_detail_vNama_usulan($field, $id) {
		$return = '<input type="text" disabled="true" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="40" />';
		return $return;
	}

	function updateBox_import_daftar_upi_detail_vNama_usulan($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = $value;
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="40" />';
			//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/koperasi/koperasi/nip/popup?field=master_teamsvc_perasset\',\'List Employee\')" type="button">&nbsp;</button>';
		}
		return $return;
	}


	function insertBox_import_daftar_upi_detail_vKekuatan($field, $id) {
		$return = '<input type="text" disabled="true" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_daftar_upi_detail_vKekuatan($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{

			$return = $value;
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="40" />';
		}
		return $return;
	}

	function insertBox_import_daftar_upi_detail_vDosis($field, $id) {
		$return = '<input type="text" disabled="true" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_daftar_upi_detail_vDosis($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{

			$return = $value;
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="40" />';
		}
		return $return;
	}

	function insertBox_import_daftar_upi_detail_vNama_generik($field, $id) {
		$return = '<input type="text" disabled="true" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="40" />';
		return $return;
	}

	function updateBox_import_daftar_upi_detail_vNama_generik($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{

			$return = $value;
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="40" />';
		}
		return $return;
	}

	function insertBox_import_daftar_upi_detail_vIndikasi($field, $id) {
		$o 	= "<textarea disabled='true' name='".$id."' id='".$id."' class='required' style='width: 240px; height: 50px;'size='250'></textarea>";		
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

	function updateBox_import_daftar_upi_detail_vIndikasi($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Note'>".nl2br($value)."</label>";
		
		}else{
			$o = nl2br($value);
			$o .= '<input type="hidden" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="40" />';
	    
		}

		return $o;
	}

    function insertBox_import_daftar_upi_detail_ikategori_id($field, $id) {
        
            $o  = "<select name='".$field."' id='".$id."' class='required'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.ikategori_id,a.vkategori from hrd.mnf_kategori a where a.ldeleted=0";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($id == $row['ikategori_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected}  value='".$row['ikategori_id']."'>".$row['vkategori']."</option>";
                }
            }
            $o .= "</select>";
            
            return $o;
    } 

    function updateBox_import_daftar_upi_detail_ikategori_id($field, $id, $value) {
    	$sql = 'select a.ikategori_id,a.vkategori from hrd.mnf_kategori a where a.ikategori_id= "'.$value.'"';
        $query = $this->dbset->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $o = $row->vkategori;
        }
        $o .= "<input type='hidden' name='".$field."' id='".$id."'  value='".$value."'/>";

            
        return $o;
    }  

    function insertBox_import_daftar_upi_detail_ikategoriupi_id($field, $id) {
        
            $o  = "<select name='".$field."' id='".$id."' class='required'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.ikategori_id,a.vkategori from plc2.plc2_upb_master_kategori_upb a where a.ldeleted=0";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($id == $row['ikategori_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected}  value='".$row['ikategori_id']."'>".$row['vkategori']."</option>";
                }
            }
            $o .= "</select>";
            
            return $o;
    } 

    function updateBox_import_daftar_upi_detail_ikategoriupi_id($field, $id, $value) {
    	$sql = 'select a.ikategori_id,a.vkategori from plc2.plc2_upb_master_kategori_upb a where a.ikategori_id= "'.$value.'"';
        $query = $this->dbset->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $o = $row->vkategori;
        }
        $o .= "<input type='hidden' name='".$field."' id='".$id."'  value='".$value."'/>";
        return $o;
    }

    function insertBox_import_daftar_upi_detail_dTgl_upi($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="8" />';
		$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		return $return;
	}

    function updateBox_import_daftar_upi_detail_dTgl_upi($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			if ($rowData['iSubmit_upi'] == 0) {
				$return = '<input type="text" name="'.$field.'" size="8" readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
				$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
			}else{
				$return = $value;
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';	
			}
			
		}
		
		return $return;
	} 


	// upi detail
	function updateBox_import_daftar_upi_detail_isediaan_id($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
            $sql = 'select a.isediaan_id,a.vsediaan from hrd.mnf_sediaan a where a.ldeleted=0 and a.isediaan_id= "'.$value.'"';
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $o = $row->vsediaan;
            }else{
            	$o='Select One';
            }
        } else {

            $o  = "<select name='".$field."' id='".$id."' class='required'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.isediaan_id,a.vsediaan from hrd.mnf_sediaan a where a.ldeleted=0";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($value == $row['isediaan_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected} value='".$row['isediaan_id']."'>".$row['vsediaan']."</option>";
                }
            }
        }   

            $o .= "</select>";
            
            return $o;
    }  

    function updateBox_import_daftar_upi_detail_vhpp_target($field, $id, $value, $rowData) {

    	if ($this->input->get('action') == 'view') {
           if ($value != '') {
           		$return =$value;
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'"  id="'.$id.'" value="'.$value.'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function updateBox_import_daftar_upi_detail_tunique($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Note'>".nl2br($value)."</label>";
		
		}else{
			$o 	= "<textarea name='".$id."' id='".$id."' class='required'   style='width: 240px; height: 50px;'size='250'>".nl2br($value)."</textarea>";		
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

	function updateBox_import_daftar_upi_detail_tpacking($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Note'>".nl2br($value)."</label>";
		
		}else{
			$o 	= "<textarea name='".$id."' id='".$id."' class='required'   style='width: 240px; height: 50px;'size='250'>".nl2br($value)."</textarea>";		
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

	function updateBox_import_daftar_upi_detail_ttarget_prareg($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").datepicker({changeMonth: true,
    											changeYear: true,
    											dateFormat:"yy-mm-dd" });
					</script>';
		}
		
		return $return;

	}

	function updateBox_import_daftar_upi_detail_tinfo_paten($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Note'>".nl2br($value)."</label>";
		
		}else{
			$o 	= "<textarea name='".$id."' id='".$id."' class='required'   style='width: 240px; height: 50px;'size='250'>".nl2br($value)."</textarea>";		
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

	function updateBox_import_daftar_upi_detail_patent_year($field, $id, $value, $rowData) {

    	if ($this->input->get('action') == 'view') {
           if ($value != '') {
           		$return =$value;
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'"  id="'.$id.'" value="'.$value.'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function updateBox_import_daftar_upi_detail_iteammarketing_id($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
            $sql = 'SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = "MR" AND t.ldeleted = 0 and t.iteam_id= "'.$value.'"';
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $o = $row->vteam;
            }else{
            	$o='Select One';
            }
        } else {

            $o  = "<select name='".$field."' id='".$id."' class='required'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = 'MR' AND t.ldeleted = '0'";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($value == $row['iteam_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected} value='".$row['iteam_id']."'>".$row['vteam']."</option>";
                }
            }
        }   

            $o .= "</select>";
            
            return $o;
    }  

    function updateBox_import_daftar_upi_detail_tmemo_bde($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Note'>".nl2br($value)."</label>";
		
		}else{
			$o 	= "<textarea name='".$id."' id='".$id."' class='required'   style='width: 240px; height: 50px;'size='250'>".nl2br($value)."</textarea>";		
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

	function updateBox_import_daftar_upi_detail_dokumen_tambahan($field, $id, $value, $rowData) {
		if (isset($_GET['iupi_idnya'])) {
			$idupi = $_GET['iupi_idnya'];
		}else{
			$idupi = $rowData['iupi_id'];
		}

		$data['rows'] = $this->db_plc0->get_where('plc2.upi_file_dokumen_tambah', array('iupi_id'=>$idupi))->result_array();
		return $this->load->view('import/daftar_upi_dokumen_tambah',$data,TRUE);
	}


	function updateBox_import_daftar_upi_detail_dokumen_bahan_baku($field, $id, $value, $rowData) {
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('vdokumen', 'ASC');
		$data['docs'] = $this->db_plc0->get('plc2.plc2_upb_master_dokumen_bb')->result_array();
		$data['isi'] = $rowData['txtDocBB'];
		//return $this->load->view('import/test',$data,TRUE);
		return $this->load->view('import/daftar_upi_dokumen_bb_edit',$data,TRUE);
	}

	function updateBox_import_daftar_upi_detail_dokumen_standar_mutu($field, $id, $value, $rowData) {
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('vdokumen', 'ASC');
		$data['isi'] = $rowData['txtDocSM'];
		$data['docs'] = $this->db_plc0->get('plc2.plc2_upb_master_dokumen_sm')->result_array();
		return $this->load->view('import/daftar_upi_dokumen_sm_edit',$data,TRUE);
	}

	function updateBox_import_daftar_upi_detail_komposisi_upi($field, $id, $value, $rowData) {
		$team=$this->auth->my_teams(TRUE);
		$iupi_id=$rowData['iupi_id'];
		$sql="select k.ikomposisi_id, k.ijumlah, k.vsatuan, k.vketerangan, r.raw_id, r.vraw, r.vnama 
				from plc2.upi_komposisi k 
					inner join plc2.plc2_raw_material r on r.raw_id=k.raw_id
				where k.iupi_id=$iupi_id and k.ldeleted=0	";
		$data['kompos'] =$this->db_plc0->query($sql)->result_array();
		$data['iupi_id']=$iupi_id;
		return $this->load->view('daftar_upi_komposisi_upi',$data,TRUE);
	}


	function updateBox_import_daftar_upi_detail_fMkt_forcast($field, $id, $value, $rowData) {

    	if ($this->input->get('action') == 'view') {
           if ($value != '') {
           		$return =$value;
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'"  id="'.$id.'" value="'.$value.'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function updateBox_import_daftar_upi_detail_fSales_upbk($field, $id, $value, $rowData) {

    	if ($this->input->get('action') == 'view') {
           if ($value != '') {
           		$return =$value;
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'"  id="'.$id.'" value="'.$value.'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function updateBox_import_daftar_upi_detail_fSales_upb($field, $id, $value, $rowData) {

    	if ($this->input->get('action') == 'view') {
           if ($value != '') {
           		$return =$value;
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'"  id="'.$id.'" value="'.$value.'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function updateBox_import_daftar_upi_detail_fSales_newk($field, $id, $value, $rowData) {

    	if ($this->input->get('action') == 'view') {
           if ($value != '') {
           		$return =$value;
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'"  id="'.$id.'" value="'.$value.'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function updateBox_import_daftar_upi_detail_fSales_new($field, $id, $value, $rowData) {

    	if ($this->input->get('action') == 'view') {
           if ($value != '') {
           		$return =$value;
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'"  id="'.$id.'" value="'.$value.'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function updateBox_import_daftar_upi_detail_iForcast_year1($field, $id, $value, $rowData) {

    	if ($this->input->get('action') == 'view') {
           if ($value != '') {
           		$return ='-';
           }else{
           		$return ='-';
           }
            
        } else {
        	/*
            $return = '<input type="text" style="text-align:right;" name="'.$field.'"  id="'.$id.'" value="'.$value.'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
			*/					
			$return ='-';
        }   


		

		return $return;
	}

	function updateBox_import_daftar_upi_detail_iForcast_year2($field, $id, $value, $rowData) {

    	if ($this->input->get('action') == 'view') {
           if ($value != '') {
           		$return ='-';
           }else{
           		$return ='-';
           }
            
        } else {
        	/*
            $return = '<input type="text" style="text-align:right;" name="'.$field.'"  id="'.$id.'" value="'.$value.'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
			*/					
			$return ='-';
        }    


		

		return $return;
	}

	function updateBox_import_daftar_upi_detail_iForcast_year3($field, $id, $value, $rowData) {

    	if ($this->input->get('action') == 'view') {
           if ($value != '') {
           		$return ='-';
           }else{
           		$return ='-';
           }
            
        } else {
        	/*
            $return = '<input type="text" style="text-align:right;" name="'.$field.'"  id="'.$id.'" value="'.$value.'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
			*/					
			$return ='-';
        }     


		

		return $return;
	}








	function manipulate_update_button($buttons, $rowData) {
		//$rows = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id'],'ldeleted'=>0))->row_array();
		//$idtim_bd =$rows['iteambusdev_id'];
		$mydept = $this->auth->my_depts(TRUE);
		$cNip= $this->user->gNIP;
		$js = $this->load->view('import/import_daftar_upi_detail_js');

		$update = '<button onclick="javascript:update_btn_back(\'import_daftar_upi_detail\', \''.base_url().'processor/plc/import/daftar/upi/detail?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_update+upi_detail">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'import_daftar_upi_detail\', \''.base_url().'processor/plc/import/daftar/upi/detail?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_import_daftar_upi_detail">Update as Draft</button>';



		if ($this->input->get('action') == 'view') {unset($buttons['update']);}

		else{
			
			unset($buttons['update_back']);
			unset($buttons['update']);
			
			if ($rowData['iSubmit_upi_detail']== 0) {
				// jika masih draft , show button update draft & update submit 
				if (isset($mydept)) {
					// cek punya dep
					if((in_array('BDI', $mydept)) || (in_array('BDE', $mydept))) {

								$buttons['update'] = $update.$updatedraft.$js;
					}
				}

			}
			

			//$buttons['update'] = $update.$updatedraft.$approve.$reject.$js;
			//$buttons['update'] = $update.$updatedraft.$approve_dir.$reject_dir.$js;
		}

		return $buttons;

	}




/*manipulasi view object form end*/

/*manipulasi proses object form start*/

function before_update_processor($row, $postData) {
	
	// ubah status submit
	if($postData['isdraft']==true){
		$postData['iSubmit_upi_detail']=0;
	} 
	else{$postData['iSubmit_upi_detail']=1;} 
	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;


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
		$postData['txtDocBB'] = $new_bb;
	}

	if(isset($postData['sm'])) {
			$sm = $postData['sm'];
			$new_sm = '';
			$i=1;
			foreach($sm as $k => $d) {
				if($i == count($sm)) {
					$new_sm .=$d;
				}
				else {
					$new_sm .=$d.',';
				}
				$i++;
			}
			$postData['txtDocSM'] = $new_sm;
	}	

	
	return $postData;

}



function after_insert_processor($fields, $id, $post) {
		if(($postData['kom_bahan_id'][0])!=""){
			foreach($postData['kom_bahan_id'] as $k=>$v){
				$kom['iupi_id']=$postData['import_daftar_upi_detail_iupi_id'];
				$kom['raw_id']=$v;
				$kom['ijumlah']=$postData['kom_kekuatan'][$k];
				$kom['vsatuan']=$postData['kom_satuan'][$k];
				$kom['ibobot']=$k+1;
				$kom['vketerangan']=$postData['kom_fungsi'][$k];
				$this->db_plc0->insert('plc2.upi_komposisi', $kom);
			}
			//exit;
		}	
}

function after_update_processor($fields, $id, $postData) {
	$sql="select k.ikomposisi_id, r.raw_id
	from plc2.upi_komposisi k
	inner join plc2.plc2_raw_material r on r.raw_id=k.raw_id
	where k.iupi_id=$id and k.ldeleted=0";
	$kompos =$this->db_plc0->query($sql)->result_array();

	if(isset($postData['kom_bahan_id'])){
		if(($postData['kom_bahan_id'][0])!=""){
			foreach($kompos as $k=>$v){
				$this->db_plc0->where('ikomposisi_id', $v['ikomposisi_id']);
				$this->db_plc0->update('plc2.upi_komposisi',array('ldeleted'=>1));
			}
			foreach($postData['kom_bahan_id'] as $k=>$v){
				$kom['iupi_id']=$postData['import_daftar_upi_detail_iupi_id'];
				$kom['raw_id']=$v;
				$kom['ijumlah']=$postData['kom_kekuatan'][$k];
				$kom['vsatuan']=$postData['kom_satuan'][$k];
				$kom['ibobot']=$k+1;
				$kom['vketerangan']=$postData['kom_fungsi'][$k];
				$this->db_plc0->insert('plc2.upi_komposisi', $kom);
			}
			//exit;
		}
	}

		$logged_nip =$this->user->gNIP;
	$qupi="select a.iupi_id,a.vNo_upi,a.dTgl_upi,a.cPengusul_upi,a.vNama_usulan,a.vKekuatan,a.vDosis,a.vNama_generik,a.vIndikasi 
			,a.iSubmit_upi,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdirm,
			b.cNip,b.vName
			from plc2.daftar_upi a 
			join hrd.employee b on b.cNip=a.cPengusul_upi
			where a.lDeleted=0
			and a.iupi_id = '".$id."'";
	$rupd = $this->db_plc0->query($qupi)->row_array();

	$submit = $rupd['iSubmit_upi'] ;

	if ($submit == 1) {
		$bdirm = $rupd['bdirm'];

		$team = $bdirm;
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

			$subject="Update : Daftar UPI Detail ".$rupd['vNo_upi'];
			$content="Diberitahukan bahwa telah ada Input Daftar UPI Detail pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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



}





/*manipulasi proses object form end*/    

/*function pendukung start*/    
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
					$del = "delete from plc2.".$table." where iupi_id = {$lastId} and vFilename= '{$v}'";
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
			$sql = "SELECT vFilename from plc2.".$table." where iupi_id=".$lastId;
			$query = mysql_query($sql);
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['vFilename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT vFilename from plc2.".$table." where iupi_id=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM plc2.".$table." where iupi_id=".$lastId." and vFilename='".$row['vFilename']."'";			
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

	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/import/upi/dok_tambah/'.$id.'/'.$name);	
		force_download($name, $path);
	}	
/*function pendukung end*/    	

	
	




	

	
	

	public function output(){
		$this->index($this->input->get('action'));
	}

}

