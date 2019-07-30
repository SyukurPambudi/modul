<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class import_praregistrasi_upi extends MX_Controller {
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
		$grid->setTitle('Pra Registrasi');
		//dc.m_vendor  database.tabel
		$grid->setTable('plc2.praregistrasi_upi');		
		$grid->setUrl('import_praregistrasi_upi');
		$grid->addList('daftar_upi.vNo_upi','daftar_upi.vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori','iSubmit_prareg','iApprove_bdirm');
		$grid->setSortBy('ipraregistrasi_upi_id');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('iApprove_bdirm','iupi_id','vNama_usulan','vKekuatan','vDosis','vNama_generik','vIndikasi','ikategori_id','ikategoriupi_id');
		$grid->addFields('isediaan_id','tpacking');
		//$grid->addFields('dTerima_dok_reg','vNo_or_prareg','dCap_lengkap','dTgl_spb','dPrareg','dTambahan_data','dSubmit_td');
		$grid->addFields('dTerima_dok_reg','vNo_or_prareg','dCap_lengkap','dTgl_spb','dPrareg');//,'iBentuk_td');
		$grid->addFields('dokumen_bahan_baku','dokumen_standar_mutu');

		//setting widht grid
		$grid->setLabel('iSubmit_prareg','Status'); 
		$grid ->setWidth('iSubmit_prareg', '100'); 
		$grid->setAlign('iSubmit_prareg', 'center'); 

		$grid->setLabel('iApprove_bdirm','Approval BDIRM'); 
		$grid ->setWidth('iApprove_bdirm', '100'); 
		$grid->setAlign('iApprove_bdirm', 'center'); 

		$grid->setLabel('iApprove_dir','Approval Direksi'); 
		$grid ->setWidth('iApprove_dir', '150'); 
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



		$grid->setLabel('iSubmit_prareg','Status Submit'); 
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
		$grid->setLabel('fSales_upbk','Total Sales di UPB (+000000)');
		$grid->setLabel('fSales_upb','Total Sales di UPB');
		$grid->setLabel('fSales_newk','Total Sales Terbaru (+000000)');
		$grid->setLabel('fSales_new','Total Sales Terbaru');
		$grid->setLabel('iForcast_year1','Forcast Untuk Aggrement Year 1');
		$grid->setLabel('iForcast_year2','Forcast Untuk Aggrement Year 2');
		$grid->setLabel('iForcast_year3','Forcast Untuk Aggrement Year 3');	


		$grid->setLabel('dTerima_dok_reg','Tgl Terima Dok. Registrasi dari Principal');
		$grid->setLabel('vNo_or_prareg','No OR Prareg');
		$grid->setLabel('dCap_lengkap','Tgl Cap Lengkap');
		$grid->setLabel('dTgl_spb','Tgl SPB');
		$grid->setLabel('dPrareg','Tgl Prareg');
		$grid->setLabel('dTambahan_data','Tgl Tambahan Data');
		$grid->setLabel('dSubmit_td','Tgl Submit TD');	
		$grid->setLabel('iBentuk_td','Bentuk TD ?');	

		
		//search 
		$grid->setSearch('daftar_upi.vNo_upi','daftar_upi.vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori');
		
		
		$grid->setLabel('dupdate','Tgl Update'); 
		$grid->setLabel('cUpdate','Update By'); 
		
		$grid->setFormUpload(TRUE);
		
		//Field yg mandatori
		$grid->setRequired('vNo_upi','dTgl_upi','cPengusul_upi','vNama_usulan','vKekuatan','vDosis','vNama_generik','vIndikasi','ikategori_id','ikategoriupi_id');//,'history','dupdate','cUpdate');
		$grid->setRequired('itipe_id','ibe','ipatent','iregister');//,'history','dupdate','cUpdate');
		// kondisi datatable
		//$grid->setQuery('istatus = "0" ', null);	

		$grid->setQuery('daftar_upi.iStatusKill = "0" ', null);
		$grid->setJoinTable('plc2.daftar_upi', 'daftar_upi.iupi_id = praregistrasi_upi.iupi_id', 'inner');
		$grid->setJoinTable('hrd.mnf_kategori', 'mnf_kategori.ikategori_id = daftar_upi.ikategori_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_master_kategori_upb', 'plc2_upb_master_kategori_upb.ikategori_id = daftar_upi.ikategoriupi_id', 'inner');
	
		//$grid->setMultiSelect(true);


		$grid->changeFieldType('itipe_id','combobox','',array(''=>'Select One',1=>'Lokal', 2=>'Import',3=>'Export'));
		$grid->changeFieldType('ibe','combobox','',array(''=>'Select One',1=>'BE', 2=>'Non BE'));
		$grid->changeFieldType('ipatent','combobox','',array(''=>'Select One',1=>'Indonesia', 2=>'International', 3=>'Off Patent'));
		$grid->changeFieldType('iregister','combobox','',array(''=>'Select One',3=>'PT. Novell Pharm', 5=>'PT. Etercon Pharm'));
		$grid->changeFieldType('iSubmit_prareg','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submitted'));


		$grid->changeFieldType('iBentuk_td','combobox','',array(''=>'Select One',1=>'Ya', 0=>'Tidak'));
		
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
			case 'cariproduk':
				$this->cariproduk();
				break;				
			case 'cariapplicant':
				$this->cariapplicant();
				break;
			case 'cariprinsipal':
				$this->cariprinsipal();
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
			case 'gethistkomposisi':
				echo $this->gethistkomposisi();
				break;	
			case 'getdetil':
				$this->getdetil();
				break;	
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }

    function getdetil(){
	$iupi_id=$_POST['iupi_id'];
	$data = array();

	$sql2 = "select *
		from plc2.daftar_upi a 
		join hrd.employee b on b.cNip=a.cPengusul_upi
		where a.ldeleted = 0 and a.iupi_id='".$iupi_id."'";
	$data2 = $this->dbset->query($sql2)->row_array();
 	
 	$row_array['vNo_upi'] = trim($data2['vNo_upi']);
	$row_array['dTgl_upi'] = trim($data2['dTgl_upi']);
	$row_array['cPengusul_upi'] = trim($data2['vName']);
	$row_array['vNama_usulan'] = trim($data2['vNama_usulan']);
	$row_array['vKekuatan'] = trim($data2['vKekuatan']);

	$row_array['vDosis'] = trim($data2['vDosis']);
	$row_array['vNama_generik'] = trim($data2['vNama_generik']);
	$row_array['vIndikasi'] = trim($data2['vIndikasi']);
	$row_array['vIndikasi'] = trim($data2['vIndikasi']);



	$row_array['ikategori_id'] = trim($data2['ikategori_id']);
	$row_array['ikategoriupi_id'] = trim($data2['ikategoriupi_id']);
	$row_array['isediaan_id'] = trim($data2['isediaan_id']);

	$row_array['itipe_id'] = trim($data2['itipe_id']);
	$row_array['ibe'] = trim($data2['ibe']);



	$row_array['vhpp_target'] = trim($data2['vhpp_target']);
	

	$row_array['tunique'] = trim($data2['tunique']);
	$row_array['tpacking'] = trim($data2['tpacking']);
	$row_array['ttarget_prareg'] = trim($data2['ttarget_prareg']);
	$row_array['ipatent'] = trim($data2['ipatent']);
	$row_array['tinfo_paten'] = trim($data2['tinfo_paten']);
	$row_array['patent_year'] = trim($data2['patent_year']);
	$row_array['iteammarketing_id'] = trim($data2['iteammarketing_id']);
	$row_array['iregister'] = trim($data2['iregister']);



	$row_array['tmemo_bde'] = trim($data2['tmemo_bde']);

	$row_array['fMkt_forcast'] = trim($data2['fMkt_forcast']);
	$row_array['fSales_upbk'] = trim($data2['fSales_upbk']);
	$row_array['fSales_upb'] = trim($data2['fSales_upb']);
	$row_array['fSales_newk'] = trim($data2['fSales_newk']);
	$row_array['fSales_new'] = trim($data2['fSales_new']);
	$row_array['iForcast_year1'] = trim($data2['iForcast_year1']);
	$row_array['iForcast_year2'] = trim($data2['iForcast_year2']);
	$row_array['iForcast_year3'] = trim($data2['iForcast_year3']);

	

	

	

	
 	array_push($data, $row_array);
 	echo json_encode($data);
    exit;
}


	function listBox_import_praregistrasi_upi_iApprove_bdirm($value) {
		/* $appd = $this->db_plc0->get_where('plc2.plc2_status', array('idplc2_status' => $value))->row_array();
		if($value==0){$appd['vCaption']="Waiting For Approval";} */
		if($value==0){$vstatus='Waiting for approval';}
		elseif($value==1){$vstatus='Rejected';}
		elseif($value==2){$vstatus='Approved';}
		return $vstatus;
	}
    function searchBox_import_praregistrasi_upi_mnf_kategori_vkategori($rowData, $id) {
		$teams = $this->db_plc0->get_where('hrd.mnf_kategori', array('ldeleted' => 0))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['vkategori'].'">'.$t['vkategori'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    } 

    function searchBox_import_praregistrasi_upi_plc2_upb_master_kategori_upb_vkategori($rowData, $id) {
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
		

	 	if ($row->iSubmit_prareg<>0) {
	 		// status sudah diapprove or reject , button edit hide 
	 		 	if ($row->iApprove_bdirm<>0) {
	 		 		unset($actions['edit']);
		 		 	unset($actions['delete']);
	 		 	}else{

		 		 	if((in_array('BDI', $mydept))) {
						if($this->auth->is_manager()){
							//$buttons['update'] = $approve_bdirm.$reject_bdirm.$js;	
						}else{
							unset($actions['edit']);
		 		 			unset($actions['delete']);
						}
					}
	 		 	}
	 	}
	 	
		 return $actions;
	}

/*manipulasi view object form start*/

	function insertBox_import_praregistrasi_upi_iApprove_bdirm($field, $id) {
		return '-';
	}

	function updateBox_import_praregistrasi_upi_iApprove_bdirm($field, $id, $value, $rowData) {
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = 'select * 
						from plc2.praregistrasi_upi a 
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

	function insertBox_import_praregistrasi_upi_iApprove_dir($field, $id) {
		return '-';
	}

	function updateBox_import_praregistrasi_upi_iApprove_dir($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = 'select * 
						from plc2.praregistrasi_upi a 
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


	function insertBox_import_praregistrasi_upi_iupi_id($field, $id) {
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
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="10" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/import/browse/upi/prareg/?field=import_praregistrasi_upi\',\'List UPI\')" type="button">&nbsp;</button>';                
		
		return $return;
	}

	function updateBox_import_praregistrasi_upi_iupi_id($field, $id, $value, $rowData) {
		$sql = 'select a.iupi_id,a.vNo_upi,a.vNama_usulan from plc2.daftar_upi a where a.iupi_id ="'.$value.'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vNo_upi'];

		}else{
			
			if ($rowData['iSubmit_prareg'] == 0) {
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
			$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="10" value="'.$data_upb['vNo_upi'].'"/>';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/import/browse/upi/prareg/?field=import_praregistrasi_upi\',\'List UPI\')" type="button">&nbsp;</button>';                
			

			
			}else{
				$return= $data_upb['vNo_upi'];
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			}
			
			//$return= $data_upb['vNo_upi'];
		}
		
		return $return;
	}


	function insertBox_import_praregistrasi_upi_dTgl_upi($field, $id) {
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="8" />
					<input type="hidden" name="isdraft" id="isdraft">
		';
		return $return;
	}

    function updateBox_import_praregistrasi_upi_dTgl_upi($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['dTgl_upi'];

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="8" readonly="readonly" id="'.$id.'" value="'.$rows['dTgl_upi'].'" class="input_rows1 required" size="10" />
					<input type="hidden" name="isdraft" id="isdraft">
				';

		}
		
		return $return;
	}


	function insertBox_import_praregistrasi_upi_cPengusul_upi($field, $id) {
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="35" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_cPengusul_upi($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
    	$rowss = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rows['cPengusul_upi']))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rowss['vName'];

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="35" readonly="readonly" id="'.$id.'" value="'.$rowss['vName'].'" class="input_rows1 required" size="10" />';

		}
		
		return $return;
	}


	function insertBox_import_praregistrasi_upi_vNama_usulan($field, $id) {
		$return = '<input type="text" name="'.$field.'"  disabled="true" id="'.$id.'" class="input_rows1 required" size="35" />
					<input type="hidden" name="isdraft" id="isdraft">';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_vNama_usulan($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vNama_usulan'];

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="35" disabled="true" id="'.$id.'" value="'.$rows['vNama_usulan'].'" class="input_rows1 required" size="10" />
				<input type="hidden" name="isdraft" id="isdraft">';

		}
		
		return $return;
	}

	function insertBox_import_praregistrasi_upi_vKekuatan($field, $id) {
		$return = '<input type="text" name="'.$field.'" style="text-align:right;" disabled="true" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_vKekuatan($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vKekuatan'];

		}
		else{
				$return = '<input type="text" style="text-align:right;" name="'.$field.'" size="8" disabled="true" id="'.$id.'" value="'.$rows['vKekuatan'].'" class="input_rows1 required"/>';

		}
		
		return $return;
	}

	function insertBox_import_praregistrasi_upi_vDosis($field, $id) {
		$return = '<input type="text" style="text-align:right;" name="'.$field.'"  disabled="true" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_vDosis($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vDosis'];

		}
		else{
				$return = '<input style="text-align:right;" type="text" name="'.$field.'" size="8" disabled="true" id="'.$id.'" value="'.$rows['vDosis'].'" class="input_rows1 required"  />';

		}
		
		return $return;
	}

	function insertBox_import_praregistrasi_upi_vNama_generik($field, $id) {
		$return = '<input type="text" name="'.$field.'"  disabled="true" id="'.$id.'" class="input_rows1 required" size="35" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_vNama_generik($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vNama_generik'];

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="35" disabled="true" id="'.$id.'" value="'.$rows['vNama_generik'].'" class="input_rows1 required" size="10" />';

		}
		
		return $return;
	}

	function insertBox_import_praregistrasi_upi_vIndikasi($field, $id) {
		$o 	= "<textarea name='".$id."' id='".$id."' class='required' disabled style='width: 240px; height: 50px;'size='250'></textarea>";		
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

	function updateBox_import_praregistrasi_upi_vIndikasi($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Note'>".nl2br($rows['vIndikasi'])."</label>";
		
		}else{
			$o 	= "<textarea name='".$id."' id='".$id."' class='required' disabled   style='width: 240px; height: 50px;'size='250'>".nl2br($rows['vIndikasi'])."</textarea>";		
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

	function insertBox_import_praregistrasi_upi_ikategori_id($field, $id) {
        
            $o  = "<select name='".$field."' id='".$id."' class='required' disabled='true'>";
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

    function updateBox_import_praregistrasi_upi_ikategori_id($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
        if ($this->input->get('action') == 'view') {
            $sql = 'select a.ikategori_id,a.vkategori from hrd.mnf_kategori a where a.ikategori_id= "'.$rows['ikategori_id'].'"';
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $o = $row->vkategori;
            }
        } else {

            $o  = "<select name='".$field."' id='".$id."' class='required' disabled='true'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.ikategori_id,a.vkategori from hrd.mnf_kategori a where a.ldeleted=0";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($rows['ikategori_id'] == $row['ikategori_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected} value='".$row['ikategori_id']."'>".$row['vkategori']."</option>";
                }
            }
        }   

            $o .= "</select>";
            
            return $o;
    } 

    function insertBox_import_praregistrasi_upi_ikategoriupi_id($field, $id) {
        
            $o  = "<select name='".$field."' id='".$id."' class='required' disabled='true'>";
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

    function updateBox_import_praregistrasi_upi_ikategoriupi_id($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
        if ($this->input->get('action') == 'view') {
            $sql = 'select a.ikategori_id,a.vkategori from plc2.plc2_upb_master_kategori_upb a where a.ikategori_id= "'.$rows['ikategoriupi_id'].'"';
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $o = $row->vkategori;
            }
        } else {

            $o  = "<select name='".$field."' id='".$id."' class='required' disabled='true'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.ikategori_id,a.vkategori from plc2.plc2_upb_master_kategori_upb a where a.ldeleted=0";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($rows['ikategoriupi_id'] == $row['ikategori_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected} value='".$row['ikategori_id']."'>".$row['vkategori']."</option>";
                }
            }
        }   

            $o .= "</select>";
            
            return $o;
    }


    function insertBox_import_praregistrasi_upi_isediaan_id($field, $id) {
        $o  = "<select name='".$field."' id='".$id."' class='required' disabled='true'>";
        $o .= "<option value=''>Pilih</option>";
        $sql = "select a.isediaan_id,a.vsediaan from hrd.mnf_sediaan a where a.ldeleted=0";
        $query = $this->dbset->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach($result as $row) {
                   $o .= "<option value='".$row['isediaan_id']."'>".$row['vsediaan']."</option>";
            }
        }
        $o .= "</select>";
        
        return $o;
    }  

    function updateBox_import_praregistrasi_upi_isediaan_id($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
        if ($this->input->get('action') == 'view') {
            $sql = 'select a.isediaan_id,a.vsediaan from hrd.mnf_sediaan a where a.ldeleted=0 and a.isediaan_id= "'.$rows['isediaan_id'].'"';
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $o = $row->vsediaan;
            }else{
            	$o='Select One';
            }
        } else {

            $o  = "<select name='".$field."' id='".$id."' class='required' disabled='true'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.isediaan_id,a.vsediaan from hrd.mnf_sediaan a where a.ldeleted=0";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($rows['isediaan_id'] == $row['isediaan_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected} value='".$row['isediaan_id']."'>".$row['vsediaan']."</option>";
                }
            }
        }   

            $o .= "</select>";
            
            return $o;
    }  

	function updatebox_import_praregistrasi_upi_itipe_id($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();

        $lmarketing = array(''=>'Select One',1=>'Lokal', 2=>'Import',3=>'Export');
        if ($this->input->get('action') == 'view') {
            $o = $lmarketing[$rows['itipe_id']];
        } else {
            $o  = "<select name='".$field."' id='".$id."'>";            
            foreach($lmarketing as $k=>$v) {
                if ($k == $rows['itipe_id']) $selected = " selected";
                else $selected = "";
                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
            }            
            $o .= "</select>";
        }
        return $o;
    }

    function updatebox_import_praregistrasi_upi_ibe($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();

        $lmarketing = array(''=>'Select One',1=>'BE', 2=>'Non BE');
        if ($this->input->get('action') == 'view') {
            $o = $lmarketing[$rows['ibe']];
        } else {
            $o  = "<select name='".$field."' id='".$id."'>";            
            foreach($lmarketing as $k=>$v) {
                if ($k == $rows['ibe']) $selected = " selected";
                else $selected = "";
                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
            }            
            $o .= "</select>";
        }
        return $o;
    }

    function updatebox_import_praregistrasi_upi_ipatent($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();

        $lmarketing = array(''=>'Select One',1=>'Indonesia', 2=>'International', 3=>'Off Patent');
        if ($this->input->get('action') == 'view') {
            $o = $lmarketing[$rows['ipatent']];
        } else {
            $o  = "<select name='".$field."' id='".$id."'>";            
            foreach($lmarketing as $k=>$v) {
                if ($k == $rows['ipatent']) $selected = " selected";
                else $selected = "";
                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
            }            
            $o .= "</select>";
        }
        return $o;
    }

    function updatebox_import_praregistrasi_upi_iregister($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();

        $lmarketing = array(''=>'Select One',1=>'Indonesia', 2=>'International', 3=>'Off Patent');
        if ($this->input->get('action') == 'view') {
            $o = $lmarketing[$rows['iregister']];
        } else {
            $o  = "<select name='".$field."' id='".$id."'>";            
            foreach($lmarketing as $k=>$v) {
                if ($k == $rows['iregister']) $selected = " selected";
                else $selected = "";
                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
            }            
            $o .= "</select>";
        }
        return $o;
    }
 

	function insertBox_import_praregistrasi_upi_vhpp_target($field, $id) {
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_vhpp_target($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
    	if ($this->input->get('action') == 'view') {
           if ($rows['vhpp_target'] != '') {
           		$return =$rows['vhpp_target'];
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'" readonly="readonly" id="'.$id.'" value="'.$rows['vhpp_target'].'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function insertBox_import_praregistrasi_upi_tunique($field, $id) {
		$o 	= "<textarea name='".$id."' id='".$id."' class='required' style='width: 240px; height: 50px;'size='250'></textarea>";		
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

	function updateBox_import_praregistrasi_upi_tunique($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Note'>".nl2br($rows['tunique'])."</label>";
		
		}else{
			$o 	= "<textarea name='".$id."' id='".$id."' class='required' readonly   style='width: 240px; height: 50px;'size='250'>".nl2br($rows['tunique'])."</textarea>";		
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

	function insertBox_import_praregistrasi_upi_tpacking($field, $id) {
		$o 	= "<textarea name='".$id."' id='".$id."' class='required' disabled='true' style='width: 240px; height: 50px;'size='250'></textarea>";		
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

	function updateBox_import_praregistrasi_upi_tpacking($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Note'>".nl2br($rows['tpacking'])."</label>";
		
		}else{
			$o 	= "<textarea name='".$id."' id='".$id."' class='required' readonly  disabled='true' style='width: 240px; height: 50px;'size='250'>".nl2br($rows['tpacking'])."</textarea>";		
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

	function insertBox_import_praregistrasi_upi_ttarget_prareg($field, $id) {
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_ttarget_prareg($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
    	if ($this->input->get('action') == 'view') {
           if ($rows['ttarget_prareg'] != '') {
           		$return =$rows['ttarget_prareg'];
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'" readonly="readonly" id="'.$id.'" value="'.$rows['ttarget_prareg'].'"  align="right" class="input_rows1 required" size="8" />';
			
        }   


		

		return $return;
	}

	function insertBox_import_praregistrasi_upi_tinfo_paten($field, $id) {
		$o 	= "<textarea name='".$id."' id='".$id."' class='required' style='width: 240px; height: 50px;'size='250'></textarea>";		
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

	function updateBox_import_praregistrasi_upi_tinfo_paten($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Note'>".nl2br($rows['tinfo_paten'])."</label>";
		
		}else{
			$o 	= "<textarea name='".$id."' id='".$id."' class='required'  readonly style='width: 240px; height: 50px;'size='250'>".nl2br($rows['tinfo_paten'])."</textarea>";		
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

	function insertBox_import_praregistrasi_upi_patent_year($field, $id) {
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_patent_year($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
    	if ($this->input->get('action') == 'view') {
           if ($rows['patent_year'] != '') {
           		$return =$rows['patent_year'];
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'" readonly="readonly" id="'.$id.'" value="'.$rows['patent_year'].'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function insertBox_import_praregistrasi_upi_iteammarketing_id($field, $id) {

            $o  = "<select name='".$field."' id='".$id."' class='required'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = 'MR' AND t.ldeleted = '0'";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       $o .= "<option  value='".$row['iteam_id']."'>".$row['vteam']."</option>";
                }
            }
            $o .= "</select>";
            
            return $o;
    }  


	function updateBox_import_praregistrasi_upi_iteammarketing_id($field, $id, $value, $rowData) {
        $rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
        if ($this->input->get('action') == 'view') {
            $sql = 'SELECT t.* FROM plc2.plc2_upb_team t
				WHERE t.vtipe = "MR" AND t.ldeleted = 0 and t.iteam_id= "'.$rows['iteammarketing_id'].'"';
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
                       if ($rows['iteammarketing_id'] == $row['iteam_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected} value='".$row['iteam_id']."'>".$row['vteam']."</option>";
                }
            }
        }   

            $o .= "</select>";
            
            return $o;
    }  


	function insertBox_import_praregistrasi_upi_tmemo_bde($field, $id) {
		$o 	= "<textarea name='".$id."' id='".$id."' class='required' style='width: 240px; height: 50px;'size='250'></textarea>";		
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

	function updateBox_import_praregistrasi_upi_tmemo_bde($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Note'>".nl2br($rows['tmemo_bde'])."</label>";
		
		}else{
			$o 	= "<textarea name='".$id."' id='".$id."' class='required' readonly   style='width: 240px; height: 50px;'size='250'>".nl2br($rows['tmemo_bde'])."</textarea>";		
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


	function insertBox_import_praregistrasi_upi_fMkt_forcast($field, $id) {
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_fMkt_forcast($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
    	if ($this->input->get('action') == 'view') {
           if ($rows['fMkt_forcast'] != '') {
           		$return =$rows['fMkt_forcast'];
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'" readonly="readonly" id="'.$id.'" value="'.$rows['fMkt_forcast'].'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function insertBox_import_praregistrasi_upi_fSales_upbk($field, $id) {
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_fSales_upbk($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
    	if ($this->input->get('action') == 'view') {
           if ($rows['fSales_upbk'] != '') {
           		$return =$rows['fSales_upbk'];
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'" readonly="readonly" id="'.$id.'" value="'.$rows['fSales_upbk'].'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function insertBox_import_praregistrasi_upi_fSales_upb($field, $id) {
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_fSales_upb($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
    	if ($this->input->get('action') == 'view') {
           if ($rows['fSales_upb'] != '') {
           		$return =$rows['fSales_upb'];
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'" readonly="readonly" id="'.$id.'" value="'.$rows['fSales_upb'].'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function insertBox_import_praregistrasi_upi_fSales_newk($field, $id) {
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_fSales_newk($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
    	if ($this->input->get('action') == 'view') {
           if ($rows['fSales_newk'] != '') {
           		$return =$rows['fSales_newk'];
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'" readonly="readonly" id="'.$id.'" value="'.$rows['fSales_upb'].'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function insertBox_import_praregistrasi_upi_fSales_new($field, $id) {
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_fSales_new($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
    	if ($this->input->get('action') == 'view') {
           if ($rows['fSales_new'] != '') {
           		$return =$rows['fSales_new'];
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'" readonly="readonly" id="'.$id.'" value="'.$rows['fSales_new'].'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function insertBox_import_praregistrasi_upi_iForcast_year1($field, $id) {
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_iForcast_year1($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
    	if ($this->input->get('action') == 'view') {
           if ($rows['iForcast_year1'] != '') {
           		$return =$rows['iForcast_year1'];
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'" readonly="readonly" id="'.$id.'" value="'.$rows['iForcast_year1'].'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function insertBox_import_praregistrasi_upi_iForcast_year2($field, $id) {
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_iForcast_year2($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
    	if ($this->input->get('action') == 'view') {
           if ($rows['iForcast_year2'] != '') {
           		$return =$rows['iForcast_year2'];
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'" readonly="readonly" id="'.$id.'" value="'.$rows['iForcast_year2'].'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function insertBox_import_praregistrasi_upi_iForcast_year3($field, $id) {
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_iForcast_year3($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
    	if ($this->input->get('action') == 'view') {
           if ($rows['iForcast_year3'] != '') {
           		$return =$rows['iForcast_year3'];
           }else{
           		$return ='-';
           }
            
        } else {

            $return = '<input type="text" style="text-align:right;" name="'.$field.'" readonly="readonly" id="'.$id.'" value="'.$rows['iForcast_year3'].'"  align="right" class="input_rows1 required" size="8" />';
			$return .='<script>
						 $("#'.$id.'").keyup(function(){
						 		this.value = this.value.replace(/[^0-9\.]/g,"");
                        });
					</script>';
        }   


		

		return $return;
	}

	function insertBox_import_praregistrasi_upi_dTerima_dok_reg($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly" class="input_rows1 required" size="8" />';
		$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		return $return;
	}

    function updateBox_import_praregistrasi_upi_dTerima_dok_reg($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			if ($rowData['iSubmit_prareg'] == 0) {
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

	function insertBox_import_praregistrasi_upi_dCap_lengkap($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly" class="input_rows1 required" size="8" />';
		$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		return $return;
	}

    function updateBox_import_praregistrasi_upi_dCap_lengkap($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			if ($rowData['iSubmit_prareg'] == 0) {
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

	function insertBox_import_praregistrasi_upi_dTgl_spb($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly" class="input_rows1 required" size="8" />';
		$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		return $return;
	}

    function updateBox_import_praregistrasi_upi_dTgl_spb($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			if ($rowData['iSubmit_prareg'] == 0) {
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

	function insertBox_import_praregistrasi_upi_dPrareg($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly" class="input_rows1 required" size="8" />';
		$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		return $return;
	}

    function updateBox_import_praregistrasi_upi_dPrareg($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			if ($rowData['iSubmit_prareg'] == 0) {
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

	function insertBox_import_praregistrasi_upi_dTambahan_data($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly" class="input_rows1 required" size="8" />';
		$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		return $return;
	}

    function updateBox_import_praregistrasi_upi_dTambahan_data($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			if ($rowData['iSubmit_prareg'] == 0) {
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

	function insertBox_import_praregistrasi_upi_dSubmit_td($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly" class="input_rows1 required" size="8" />';
		$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		return $return;
	}

    function updateBox_import_praregistrasi_upi_dSubmit_td($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			if ($rowData['iSubmit_prareg'] == 0) {
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

	function insertBox_import_praregistrasi_upi_vNo_or_prareg($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="35" />';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_vNo_or_prareg($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="35" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';

		}
		
		return $return;
	}



	function insertBox_import_praregistrasi_upi_dokumen_bahan_baku($field, $id) {
	/*
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('vdokumen', 'ASC');
		$data['docs'] = $this->db_plc0->get('plc2.plc2_upb_master_dokumen_bb')->result_array();
		return $this->load->view('import/prareg_upi_dokumen_bb',$data,TRUE);
	*/
		$return ='<div id="upi_prareg_dok_bb">-</div>';
		return $return;
	}

	function updateBox_import_praregistrasi_upi_dokumen_bahan_baku($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();

		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('vdokumen', 'ASC');
		$data['docs'] = $this->db_plc0->get('plc2.plc2_upb_master_dokumen_bb')->result_array();
		$data['isi'] = $rows['txtDocBB'];
		//return $this->load->view('import/test',$data,TRUE);
		return $this->load->view('import/prareg_upi_dokumen_bb_edit',$data,TRUE);
	}

	function insertBox_import_praregistrasi_upi_dokumen_standar_mutu($field, $id) {
		/*
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('vdokumen', 'ASC');
		$data['docs'] = $this->db_plc0->get('plc2.plc2_upb_master_dokumen_sm')->result_array();
		return $this->load->view('import/prareg_upi_dokumen_sm',$data,TRUE);
		*/
		$return ='<div id="upi_prareg_dok_sm">-</div>';
		return $return;

	}

	function updateBox_import_praregistrasi_upi_dokumen_standar_mutu($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('vdokumen', 'ASC');
		$data['isi'] = $rows['txtDocSM'];
		$data['docs'] = $this->db_plc0->get('plc2.plc2_upb_master_dokumen_sm')->result_array();
		return $this->load->view('import/prareg_upi_dokumen_sm_edit',$data,TRUE);
	}

/*manipulasi view object form end*/

/*manipulasi proses object form start*/


function before_insert_processor($row, $postData) {

	// ubah status submit
		if($postData['isdraft']==true){
			$postData['iSubmit_prareg']=0;
		} 
		else{$postData['iSubmit_prareg']=1;} 
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

function before_update_processor($row, $postData) {
	
	// ubah status submit
	if($postData['isdraft']==true){
		$postData['iSubmit_prareg']=0;
	} else{$postData['iSubmit_prareg']=1;} 

	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;

	
	return $postData;

}


function cariproduk() {
	$term = $this->input->get('term');
	$return_arr = array();
	$sqlprod = "select * 
				from plc2.plc2_produk_kompetitor a
				join plc2.plc2_manuf_kompetitor b on b.iplc2_manuf_kompetitor_id=a.iplc2_manuf_kompetitor_id
				where a.vNama_produk like '%".$term."%'
				and a.lDeleted = 0
				and b.lDeleted=0";
	$lines= $this->db_plc0->query($sqlprod)->result_array();
	//$lines = $this->db_plc0->get('plc2.plc2_produk_kompetitor')->result_array();
	$i=0;
	foreach($lines as $line) {
		$row_array["value"] = trim($line["vNama_produk"]);
		$row_array["id"] = trim($line["iplc2_produk_kompetitor_id"]);
		$row_array["manuf"] = trim($line["vNama_manuf"]);
		array_push($return_arr, $row_array);
	}
	echo json_encode($return_arr);exit();
	
}


	function manipulate_insert_button($buttons) {
		unset($buttons['save']);

		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'import_praregistrasi_upi\', \''.base_url().'processor/plc/import/praregistrasi/upi?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_import_praregistrasi_upi">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'import_praregistrasi_upi\', \''.base_url().'processor/plc/import/praregistrasi/upi?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_import_praregistrasi_upi">Save &amp; Submit</button>';
		$js = $this->load->view('import/import_praregistrasi_upi_js');
		$buttons['save'] = $save_draft.$save.$js;

		return $buttons;
	}

	function manipulate_update_button($buttons, $rowData) {
			$mydept = $this->auth->my_depts(TRUE);
			$cNip= $this->user->gNIP;
			$js = $this->load->view('import/import_praregistrasi_upi_js');

			$update = '<button onclick="javascript:update_btn_back(\'import_praregistrasi_upi\', \''.base_url().'processor/plc/import/praregistrasi/upi?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_update+upi_detail">Update & Submit</button>';
			$updatedraft = '<button onclick="javascript:update_draft_btn(\'import_praregistrasi_upi\', \''.base_url().'processor/plc/import/praregistrasi/upi?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_import_praregistrasi_upi">Update as Draft</button>';

			$approve_bdirm = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/praregistrasi/upi?action=approve&ipraregistrasi_upi_id='.$rowData['ipraregistrasi_upi_id'].'&cNip='.$cNip.'&lvl=1&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_import_praregistrasi_upi">Approve</button>';
			$reject_bdirm = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/praregistrasi/upi?action=reject&ipraregistrasi_upi_id='.$rowData['ipraregistrasi_upi_id'].'&cNip='.$cNip.'&lvl=1&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_import_praregistrasi_upi">Reject</button>';



			if ($this->input->get('action') == 'view') {unset($buttons['update']);}

			else{
				
				unset($buttons['update_back']);
				unset($buttons['update']);
				
				if ($rowData['iSubmit_prareg']== 0) {
					// jika masih draft , show button update draft & update submit 
					if (isset($mydept)) {
						// cek punya dep
						if((in_array('BDI', $mydept)) || (in_array('BDE', $mydept))) {

									$buttons['update'] = $update.$updatedraft.$js;
						}
					}

				}else{
						if (isset($mydept)) {
							if((in_array('BDI', $mydept))) {
								if($this->auth->is_manager()){
									$buttons['update'] = $approve_bdirm.$reject_bdirm.$js;	
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
								var url = "'.base_url().'processor/plc/import/praregistrasi/upi";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_import_praregistrasi_upi").html(data);
										 $("#button_approve_import_praregistrasi_upi").hide();
										 $("#button_reject_import_praregistrasi_upi").hide();
									});
									
								}
									reload_grid("grid_import_praregistrasi_upi");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_import_praregistrasi_upi_approve" action="'.base_url().'processor/plc/import/praregistrasi/upi?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="ipraregistrasi_upi_id" value="'.$this->input->get('ipraregistrasi_upi_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_import_praregistrasi_upi_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}


	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$ipraregistrasi_upi_id = $post['ipraregistrasi_upi_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove_bdirm'=>'2','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>date('Y-m-d H:i:s'), 'vRemark_bdirm'=>$vRemark);
		$this -> db -> where('ipraregistrasi_upi_id', $ipraregistrasi_upi_id);
		$updet = $this -> db -> update('plc2.praregistrasi_upi', $data);

		$data['status']  = true;
		$data['last_id'] = $post['ipraregistrasi_upi_id'];
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_import_praregistrasi_upi_remark").val();
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
								var url = "'.base_url().'processor/plc/import/praregistrasi/upi";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_import_praregistrasi_upi").html(data);
										 $("#button_approve_import_praregistrasi_upi").hide();
										 $("#button_reject_import_praregistrasi_upi").hide();
									});
									
								}
									reload_grid("grid_import_praregistrasi_upi");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_import_praregistrasi_upi_reject" action="'.base_url().'processor/plc/import/praregistrasi/upi?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="ipraregistrasi_upi_id" value="'.$this->input->get('ipraregistrasi_upi_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="reject_import_praregistrasi_upi_remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_import_praregistrasi_upi_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function reject_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$ipraregistrasi_upi_id = $post['ipraregistrasi_upi_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove_bdirm'=>'1','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>date('Y-m-d H:i:s'), 'vRemark_bdirm'=>$vRemark);
		$this -> db -> where('ipraregistrasi_upi_id', $ipraregistrasi_upi_id);
		$updet = $this -> db -> update('plc2.praregistrasi_upi', $data);

		$data['status']  = true;
		$data['last_id'] = $post['ipraregistrasi_upi_id'];
		return json_encode($data);
	}



function after_insert_processor($fields, $id, $postData) {

	$logged_nip =$this->user->gNIP;
	$qupi="select c.iSubmit_prareg,a.iupi_id,a.vNo_upi,a.dTgl_upi,a.cPengusul_upi,a.vNama_usulan,a.vKekuatan,a.vDosis,a.vNama_generik,a.vIndikasi 
			,a.iSubmit_upi,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdirm,
			b.cNip,b.vName,c.ipraregistrasi_upi_id
			from plc2.daftar_upi a 
			join plc2.praregistrasi_upi c on c.iupi_id=a.iupi_id
			join hrd.employee b on b.cNip=a.cPengusul_upi
			where a.lDeleted=0
			and c.ipraregistrasi_upi_id = '".$id."'";
	$rupd = $this->db_plc0->query($qupi)->row_array();

	$submit = $rupd['iSubmit_prareg'] ;

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

			$subject="New : Praregistrasi UPI ".$rupd['vNo_upi'];
			$content="Diberitahukan bahwa telah ada Input Pra Registrasi UPI pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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

function after_update_processor($fields, $id, $postData) {

	$logged_nip =$this->user->gNIP;
	$qupi="select c.iSubmit_prareg,a.iupi_id,a.vNo_upi,a.dTgl_upi,a.cPengusul_upi,a.vNama_usulan,a.vKekuatan,a.vDosis,a.vNama_generik,a.vIndikasi 
			,a.iSubmit_upi,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdirm,
			b.cNip,b.vName,c.ipraregistrasi_upi_id
			from plc2.daftar_upi a 
			join plc2.praregistrasi_upi c on c.iupi_id=a.iupi_id
			join hrd.employee b on b.cNip=a.cPengusul_upi
			where a.lDeleted=0
			and c.ipraregistrasi_upi_id = '".$id."'";
	$rupd = $this->db_plc0->query($qupi)->row_array();

	$submit = $rupd['iSubmit_prareg'] ;

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

			$subject="New : Praregistrasi UPI ".$rupd['vNo_upi'];
			$content="Diberitahukan bahwa telah ada Input Pra Registrasi UPI pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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

	
	

	public function output(){
		$this->index($this->input->get('action'));
	}

}

