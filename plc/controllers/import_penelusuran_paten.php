<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class import_penelusuran_paten extends MX_Controller {
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
		$grid->setTitle('Penelusuran Paten');
		//dc.m_vendor  database.tabel
		$grid->setTable('plc2.telusur_paten');		
		$grid->setUrl('import_penelusuran_paten');
		$grid->addList('daftar_upi.vNo_upi','daftar_upi.vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori','iSubmit_telusur');
		$grid->setSortBy('vNo_upi');
		$grid->setSortOrder('desc'); //sort ordernya

		//$grid->addFields('iApprove_bdirm','iApprove_dir','iupi_id','vNama_usulan','dBuat_surat','vNo_or','dSubmit_hki','dHasil_penelusuran','dKajian_paten','iRekomendasi_produk');
		$grid->addFields('iupi_id','vNama_usulan','dBuat_surat','vNo_or','dSubmit_hki','dHasil_penelusuran','dKajian_paten','iRekomendasi_produk');

		//setting widht grid
		$grid->setLabel('iSubmit_telusur','Status'); 
		$grid ->setWidth('iSubmit_telusur', '100'); 
		$grid->setAlign('iSubmit_telusur', 'center'); 

		$grid->setLabel('iApprove_bdirm','Approval BDIRM'); 
		$grid ->setWidth('iApprove_bdirm', '100'); 
		$grid->setAlign('iApprove_bdirm', 'center'); 

		$grid->setLabel('iApprove_dir','Approval Direksi'); 
		$grid ->setWidth('iApprove_dir', '100'); 
		$grid->setAlign('iApprove_dir', 'center'); 

		$grid->setLabel('daftar_upi.vNo_upi','No UPI'); 
		$grid->setWidth('daftar_upi.vNo_upi','80'); 
		$grid->setAlign('daftar_upi.vNo_upi','center'); 

		$grid->setLabel('iupi_id','No UPI'); 
		$grid ->setWidth('iupi_id', '100'); 
		$grid->setAlign('iupi_id', 'center'); 

		$grid->setLabel('dTgl_upi','Tanggal UPI'); 
		$grid ->setWidth('dTgl_upi', '100'); 
		$grid->setAlign('dTgl_upi', 'center'); 

		$grid->setLabel('cPengusul_upi','Nama Pengusul'); 
		$grid ->setWidth('cPengusul_upi', '250'); 
		$grid->setAlign('cPengusul_upi', 'center');

		
		$grid->setLabel('daftar_upi.vNama_usulan','Nama Usulan'); 
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


		$grid->setLabel('dBuat_surat','Tgl. Pembuatan Surat'); 
		$grid ->setWidth('dBuat_surat', '10'); 
		$grid->setAlign('dBuat_surat', 'center');

		$grid->setLabel('vNo_or','No OR Penelusuran Paten'); 
		$grid ->setWidth('vNo_or', '10'); 
		$grid->setAlign('vNo_or', 'center');

		$grid->setLabel('dSubmit_hki','Tgl Submit ke Ditjen HKI'); 
		$grid ->setWidth('dSubmit_hki', '10'); 
		$grid->setAlign('dSubmit_hki', 'center');

		$grid->setLabel('dHasil_penelusuran','Tgl Keluar Hasil Penelusuran Paten'); 
		$grid ->setWidth('dHasil_penelusuran', '10'); 
		$grid->setAlign('dHasil_penelusuran', 'center');

		$grid->setLabel('dKajian_paten','Tgl Selesai Pembuatan Kajian Paten UPI'); 
		$grid ->setWidth('dKajian_paten', '10'); 
		$grid->setAlign('dKajian_paten', 'center');

		$grid->setLabel('iRekomendasi_produk','Rekomendasi Produk Import'); 
		$grid ->setWidth('iRekomendasi_produk', '10'); 
		$grid->setAlign('iRekomendasi_produk', 'center');

		//search 
		$grid->setSearch('daftar_upi.vNo_upi','daftar_upi.vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori');
		
		
		$grid->setLabel('dupdate','Tgl Update'); 
		$grid->setLabel('cUpdate','Update By'); 
		
		$grid->setFormUpload(TRUE);
		
		//Field yg mandatori
		$grid->setRequired('daftar_upivNo_upi','dTgl_upi','cPengusul_upi','vNama_usulan','vKekuatan','vDosis','vNama_generik','vIndikasi','ikategori_id','ikategoriupi_id');//,'history','dupdate','cUpdate');
		
		$grid->setQuery('daftar_upi.lDeleted = "0" ', null);	
		$grid->setQuery('daftar_upi.iStatusKill = "0" ', null);


		// kondisi datatable
		//$grid->setQuery('istatus = "0" ', null);	
		$grid->setJoinTable('plc2.daftar_upi', 'daftar_upi.iupi_id = telusur_paten.iupi_id', 'inner');
		$grid->setJoinTable('hrd.mnf_kategori', 'mnf_kategori.ikategori_id = daftar_upi.ikategori_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_master_kategori_upb', 'plc2_upb_master_kategori_upb.ikategori_id = daftar_upi.ikategoriupi_id', 'inner');

		$grid->changeFieldType('iRekomendasi_produk','combobox','',array('--Select One--'=>'Pilih',2=>'Yes',1=>'No'));
		$grid->changeFieldType('iSubmit_telusur','combobox','',array('0'=>'Draft','1'=>'Submitted'));

		//Set View Gridnya (Default = grid)

		$mydept = $this->auth->my_depts(TRUE);
		if (isset($mydept)) 
		{
			// cek punya dep
			if((in_array('DR', $mydept))) {
				$grid->setQuery('telusur_paten.iApprove_bdirm = "2" ', null);	
			}
		}


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
					echo $grid->updated_form();
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
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }

	function listBox_Action($row, $actions) {
	 	$mydept = $this->auth->my_depts(TRUE);
	 	$x = $this->auth->my_teams();
		$array = explode(',', $x);
		// cek user bagian dari tim bd terkait
		

	 	if ($row->iSubmit_telusur<>0) {
	 		// status sudah diapprove or reject , button edit hide 
	 		 unset($actions['edit']);
	 		 unset($actions['delete']);
	 	}else{
	 		$mydept = $this->auth->my_depts(TRUE);
	 		if (isset($mydept)) 
			{
				// cek punya dep
				if((in_array('DR', $mydept))  and $row->iApprove_bdirm <> 2 ) {
					unset($actions['edit']);
	 		 		unset($actions['delete']);
				}else if( (in_array('BDI', $mydept))  and $row->iApprove_bdirm ==1 ){
					unset($actions['edit']);
	 		 		unset($actions['delete']);
				}
			}


	 	}

	 	
		 return $actions;

	} 

/*function pendukung start*/    
	
/*function pendukung end*/   
	function listBox_import_penelusuran_paten_iApprove_bdirm($value) {
		/* $appd = $this->db_plc0->get_where('plc2.plc2_status', array('idplc2_status' => $value))->row_array();
		if($value==0){$appd['vCaption']="Waiting For Approval";} */
		if($value==0){$vstatus='Waiting for approval';}
		elseif($value==1){$vstatus='Rejected';}
		elseif($value==2){$vstatus='Approved';}
		return $vstatus;
	}
	 function listBox_import_penelusuran_paten_iApprove_dir($value) {
		/* $team = $this->db_plc0->get_where('plc2.plc2_status', array('idplc2_status' => $value))->row_array();
		if($value==0){$team['vCaption']="Waiting For Approval";} */
	 	if($value==0){$vstatus='Waiting for approval';}
	 	elseif($value==1){$vstatus='Rejected';}
	 	elseif($value==2){$vstatus='Approved';}
		return $vstatus;
	} 

	function insertBox_import_penelusuran_paten_iApprove_bdirm($field, $id) {
		return '-';
	}

	function updateBox_import_penelusuran_paten_iApprove_bdirm($field, $id, $value, $rowData) {
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = 'select * 
						from plc2.telusur_paten a 
						join hrd.employee b on b.cNip=a.cApprove_bdirm
						where
						a.lDeleted = 0
						and  a.itelusur_paten_id = "'.$rowData['itelusur_paten_id'].'"';
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
		
		return $ret;
	}
	
	function insertBox_import_penelusuran_paten_iApprove_dir($field, $id) {
		return '-';
	}

	function updateBox_import_penelusuran_paten_iApprove_dir($field, $id, $value, $rowData) {
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = 'select * 
						from plc2.telusur_paten a 
						join hrd.employee b on b.cNip=a.cApprove_dir
						where
						a.lDeleted = 0
						and  a.itelusur_paten_id = "'.$rowData['itelusur_paten_id'].'"';
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
		
		return $ret;
	}

	function insertBox_import_penelusuran_paten_iupi_id($field, $id) {
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
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="10" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/import/browse/upi/penelusuran/?field=import_penelusuran_paten\',\'List UPI\')" type="button">&nbsp;</button>';                
		
		return $return;
	}

	function updateBox_import_penelusuran_paten_iupi_id($field, $id, $value, $rowData) {
		$sql = 'select a.iupi_id,a.vNo_upi,a.vNama_usulan from plc2.daftar_upi a where a.iupi_id ="'.$value.'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vNo_upi'];

		}else{
			if ($rowData['iSubmit_telusur'] == 0) {
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
			$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="10" value="'.$data_upb['vNo_upi'].'"/>';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/import/browse/upi/penelusuran/?field=import_penelusuran_paten\',\'List UPI\')" type="button">&nbsp;</button>';                
			

			
			}else{
				$return= $data_upb['vNo_upi'];
			}
		}
		
		return $return;
	}


	function insertBox_import_penelusuran_paten_vNama_usulan($field, $id) {
		$return = '<input type="text" name="'.$field.'" disabled="true"  id="'.$id.'" class="input_rows1 required" size="40" />
					<input type="hidden" name="isdraft" id="isdraft">';
		return $return;
	}

	function updateBox_import_penelusuran_paten_vNama_usulan($field, $id, $value, $rowData) {
		$sql = 'select a.iupi_id,a.vNo_upi,a.vNama_usulan from plc2.daftar_upi a where a.iupi_id ="'.$rowData['iupi_id'].'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vNama_usulan'];

		}
		else{

			if ($rowData['iSubmit_telusur'] == 0) {
				$return = '<input type="text" disabled="true" name="'.$field.'"  id="'.$id.'" value="'.$data_upb['vNama_usulan'].'" class="input_rows1 required" size="40" />
				<input type="hidden" name="isdraft" id="isdraft">';				
			}else{
				$return= $data_upb['vNama_usulan'];
			}
		
		}
		return $return;
	}


	function insertBox_import_penelusuran_paten_dBuat_surat($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="8" />';
		$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		return $return;
	}

    function updateBox_import_penelusuran_paten_dBuat_surat($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="8" readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
				$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		}
		
		return $return;
	}
	
	function insertBox_import_penelusuran_paten_vNo_or($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="20" />';
		return $return;
	}

	function updateBox_import_penelusuran_paten_vNo_or($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{

			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="20" />';
			//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/koperasi/koperasi/nip/popup?field=master_teamsvc_perasset\',\'List Employee\')" type="button">&nbsp;</button>';
		}
		return $return;
	}

	function insertBox_import_penelusuran_paten_dSubmit_hki($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="8" />';
		$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		return $return;
	}

    function updateBox_import_penelusuran_paten_dSubmit_hki($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="8" readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
				$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		}
		
		return $return;
		
	}

	function insertBox_import_penelusuran_paten_dHasil_penelusuran($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="8" />';
		$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		return $return;
	}

    function updateBox_import_penelusuran_paten_dHasil_penelusuran($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="8" readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
				$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		}
		
		return $return;
	}

	function insertBox_import_penelusuran_paten_dKajian_paten($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="8" />';
		$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		return $return;
	}

    function updateBox_import_penelusuran_paten_dKajian_paten($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="8" readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
				$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		}
		
		return $return;
	}



	function before_insert_processor($row, $postData) {

	// ubah status submit
		if($postData['isdraft']==true){
			$postData['iSubmit_telusur']=0;
		} 
		else{$postData['iSubmit_telusur']=1;} 
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreated'] =$this->user->gNIP;
	
	return $postData;

	}

	function before_update_processor($row, $postData) {
		
		// ubah status submit
		if($postData['isdraft']==true){
			$postData['iSubmit_telusur']=0;
		} 
		else{$postData['iSubmit_telusur']=1;} 
		$postData['dupdate'] = date('Y-m-d H:i:s');
		$postData['cUpdate'] =$this->user->gNIP;
		
		return $postData;

	}

	function manipulate_insert_button($buttons) {
		unset($buttons['save']);
		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'import_penelusuran_paten\', \''.base_url().'processor/plc/import/penelusuran/paten?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_import_penelusuran_paten">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'import_penelusuran_paten\', \''.base_url().'processor/plc/import/penelusuran/paten?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_import_penelusuran_paten">Save &amp; Submit</button>';
		$js = $this->load->view('import/import_penelusuran_paten_js');
		$buttons['save'] = $save_draft.$save.$js;

		return $buttons;
	}

	function manipulate_update_button($buttons, $rowData) {
		$mydept = $this->auth->my_depts(TRUE);
		$cNip= $this->user->gNIP;
		$js = $this->load->view('import/import_penelusuran_paten_js');
		$approve_bdirm = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/penelusuran/paten?action=approve&itelusur_paten_id='.$rowData['itelusur_paten_id'].'&cNip='.$cNip.'&lvl=1&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_import_penelusuran_paten">Approve</button>';
		$reject_bdirm = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/penelusuran/paten?action=reject&itelusur_paten_id='.$rowData['itelusur_paten_id'].'&cNip='.$cNip.'&lvl=1&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_import_penelusuran_paten">Reject</button>';

		$approve_dir = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/penelusuran/paten?action=approve&itelusur_paten_id='.$rowData['itelusur_paten_id'].'&cNip='.$cNip.'&lvl=2&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_import_penelusuran_paten">Approve</button>';
		$reject_dir = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/penelusuran/paten?action=reject&itelusur_paten_id='.$rowData['itelusur_paten_id'].'&cNip='.$cNip.'&lvl=2&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_import_penelusuran_paten">Reject</button>';


		$update = '<button onclick="javascript:update_btn_back(\'import_penelusuran_paten\', \''.base_url().'processor/plc/import/penelusuran/paten?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_import_penelusuran_paten">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'import_penelusuran_paten\', \''.base_url().'processor/plc/import/penelusuran/paten?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_import_penelusuran_paten">Update as Draft</button>';



		if ($this->input->get('action') == 'view') {unset($buttons['update']);}

		else{
			
			unset($buttons['update_back']);
			unset($buttons['update']);
			
			if ($rowData['iSubmit_telusur']== 0) {
				// jika masih draft , show button update draft & update submit 
				if (isset($mydept)) {
					// cek punya dep
					if((in_array('BDI', $mydept)) || (in_array('BDE', $mydept))) {
								$buttons['update'] = $update.$updatedraft.$js;
					}
				}

			}else{
				// sudah disubmit , show button approval 
				//20160427 tidak ada approval pada penelusuran paten 

				/*
				if ($rowData['iApprove_bdirm']==0) {
					// jika approval bdirm 0 
					if (isset($mydept)) {
						if((in_array('BDI', $mydept))) {
							if($this->auth->is_manager()){
								$buttons['update'] = $approve_bdirm.$reject_bdirm.$js;	
							}
						}
					}
				}else if($rowData['iApprove_dir']==0){
					if ($rowData['iApprove_bdirm']==2) {
						if (isset($mydept)) {
							if((in_array('DR', $mydept))) {
								if($this->auth->is_manager()){
									$buttons['update'] = $approve_dir.$reject_dir.$js;
								}
							}
						}
						
					}
				}
				*/
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
								var url = "'.base_url().'processor/plc/import/penelusuran/paten";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_import_penelusuran_paten").html(data);
										 $("#button_approve_import_penelusuran_paten").hide();
										 $("#button_reject_import_penelusuran_paten").hide();
									});
									
								}
									reload_grid("grid_import_penelusuran_paten");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_import_penelusuran_paten_approve" action="'.base_url().'processor/plc/import/penelusuran/paten?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="itelusur_paten_id" value="'.$this->input->get('itelusur_paten_id').'" />
				<input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_import_penelusuran_paten_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$itelusur_paten_id = $post['itelusur_paten_id'];
		$lvl = $post['lvl'];
		$vRemark = $post['vRemark'];

		if ($lvl == 2) {
			//approval direksi 
			$data=array('iApprove_dir'=>'2','cApprove_dir'=>$cNip , 'dApprove_dir'=>date('Y-m-d H:i:s'), 'vRemark_dir'=>$vRemark);
		}else{
			//bdirm
			$data=array('iApprove_bdirm'=>'2','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>date('Y-m-d H:i:s'), 'vRemark_bdirm'=>$vRemark);
		}
		$this -> db -> where('itelusur_paten_id', $itelusur_paten_id);
		$updet = $this -> db -> update('plc2.telusur_paten', $data);
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
				and a.iupi_id = '".$iupi_id."'";
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
		$data['last_id'] = $post['itelusur_paten_id'];
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_import_penelusuran_paten_remark").val();
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
								var url = "'.base_url().'processor/plc/import/penelusuran/paten";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_import_penelusuran_paten").html(data);
										 $("#button_approve_import_penelusuran_paten").hide();
										 $("#button_reject_import_penelusuran_paten").hide();
									});
									
								}
									reload_grid("grid_import_penelusuran_paten");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_import_penelusuran_paten_reject" action="'.base_url().'processor/plc/import/penelusuran/paten?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="itelusur_paten_id" value="'.$this->input->get('itelusur_paten_id').'" />
				<input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="reject_import_penelusuran_paten_remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_import_penelusuran_paten_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function reject_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$itelusur_paten_id = $post['itelusur_paten_id'];
		$lvl = $post['lvl'];
		$vRemark = $post['vRemark'];

		if ($lvl == 2) {
			//approval direksi 
			$data=array('iApprove_dir'=>'1','cApprove_dir'=>$cNip , 'dApprove_dir'=>date('Y-m-d H:i:s'), 'vRemark_dir'=>$vRemark);
		}else{
			//bdirm
			$data=array('iApprove_bdirm'=>'1','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>date('Y-m-d H:i:s'), 'vRemark_bdirm'=>$vRemark);
		}
		$this -> db -> where('itelusur_paten_id', $itelusur_paten_id);
		$updet = $this -> db -> update('plc2.telusur_paten', $data);

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
				and a.iupi_id = '".$iupi_id."'";
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
		$data['last_id'] = $post['itelusur_paten_id'];
		return json_encode($data);
	}

	function after_insert_processor($fields, $id, $post) {
		//notifikasi UPI ke BDIRM
			$logged_nip =$this->user->gNIP;
			$qupi="select a.iupi_id,a.vNo_upi,a.dTgl_upi,a.cPengusul_upi,a.vNama_usulan,a.vKekuatan,a.vDosis,a.vNama_generik,a.vIndikasi 
					,c.iSubmit_telusur,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdirm,
					b.cNip,b.vName
					from plc2.daftar_upi a 
					join hrd.employee b on b.cNip=a.cPengusul_upi
					join plc2.telusur_paten c on c.iupi_id=a.iupi_id
					where a.lDeleted=0
					and c.lDeleted=0
					and c.itelusur_paten_id = '".$id."'";
			$rupd = $this->db_plc0->query($qupi)->row_array();

			$submit = $rupd['iSubmit_telusur'] ;

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

				$subject="Submitted : Penelusuran Paten ".$rupd['vNo_upi'];
				$content="Diberitahukan bahwa telah ada Input Penelusuran Paten pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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

	function after_update_processor($fields, $id, $post) {
		$logged_nip =$this->user->gNIP;
		$qupi="select a.iupi_id,a.vNo_upi,a.dTgl_upi,a.cPengusul_upi,a.vNama_usulan,a.vKekuatan,a.vDosis,a.vNama_generik,a.vIndikasi 
				,c.iSubmit_telusur,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdirm,
				b.cNip,b.vName
				from plc2.daftar_upi a 
				join hrd.employee b on b.cNip=a.cPengusul_upi
				join plc2.telusur_paten c on c.iupi_id=a.iupi_id
				where a.lDeleted=0
				and c.lDeleted=0
				and c.itelusur_paten_id = '".$id."'";
		$rupd = $this->db_plc0->query($qupi)->row_array();

		$submit = $rupd['iSubmit_telusur'] ;

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

				$subject="Submitted : Penelusuran Paten ".$rupd['vNo_upi'];
				$content="Diberitahukan bahwa telah ada Input Penelusuran Paten pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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



	public function output(){
		$this->index($this->input->get('action'));
	}

}
