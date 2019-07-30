<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_trial_stress_test extends MX_Controller {
	function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle('Stress Test');		
		$grid->setTable('plc2.plc2_upb_formula');		
		$grid->setUrl('product_trial_stress_test');
		$grid->addList('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','ikimiawi','idisolusi','imikro','istress','plc2_upb.iteampd_id');
		$grid->setSortBy('tupdate');
		$grid->setSortOrder('DESC');
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '100');
		$grid->setWidth('plc2_upb.iteampd_id', '150');
		$grid->setWidth('plc2_upb.vupb_nama', '250');
		$grid->setWidth('plc2_upb.vgenerik', '250');
		$grid->setWidth('idisolusi', '75');
		$grid->setWidth('ikimiawi', '75');
		$grid->setWidth('imikro', '75');
		$grid->setWidth('istress', '75');
		$grid->addFields('vkode_surat','ispekfg_id','iupb_id','vupb_nama','vgenerik','iteampd_id','tberlaku','filename','vrevisi','vnip_formulator');
		$grid->addFields('tstart_stress','tend_stress','tupload_stress','tstart_skimiawi','tend_skimiawi','vnip_pic_skimiawi','vhasil_skimiawi','iskimiawi','thasil_skimiawi');
		$grid->addFields('tstart_sdisolusi','tend_sdisolusi','vnip_pic_sdisolusi','vhasil_sdisolusi','isdisolusi','thasil_sdisolusi');
		$grid->addFields('tstart_smikro','tend_smikro','vnip_pic_smikro','vhasil_smikro','ismikro','thasil_smikro');
		$grid->addFields('ilab','thasil_ilab','tnote');
		//$grid->setRequired();
		$grid->setLabel('vkode_surat', 'No. Formulasi');
		$grid->setLabel('ispekfg_id', 'No. Spek FG');
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('plc2_upb.iupb_id', 'No. UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setLabel('iteampd_id', 'Team PD');		
		$grid->setLabel('plc2_upb.iteampd_id', 'Team PD');
		$grid->setLabel('tberlaku', 'Tanggal berlaku');
		$grid->setLabel('filename', 'Nama File');
		$grid->setLabel('vrevisi', 'Revisi');
		$grid->setLabel('vnip_formulator', 'Formulator');
		$grid->setLabel('tstart_stress', 'Tgl. Mulai Stress Test');
		$grid->setLabel('tend_stress', 'Tgl. Selesai Stress Test');
		$grid->setLabel('tupload_stress', 'Tgl. Update Stress Test');
		$grid->setLabel('tstart_skimiawi', 'Tgl. Mulai Analisa Kimiawi');
		$grid->setLabel('tend_skimiawi', 'Tgl. Selesai Analisa Kimiawi');
		$grid->setLabel('vnip_pic_skimiawi', 'PIC Analisa Kimiawi');
		$grid->setLabel('vhasil_skimiawi', 'Hasil Analisa Kimiawi');
		$grid->setLabel('iskimiawi', 'Kesimpulan Analisa Kimiawi');
		$grid->setLabel('thasil_skimiawi', 'Tgl. Kesimpulan Analisa Kimiawi');
		$grid->setLabel('tstart_sdisolusi', 'Tgl. Mulai Uji Disolusi');
		$grid->setLabel('tend_sdisolusi', 'Tgl. Selesai Uji Disolusi');
		$grid->setLabel('vnip_pic_sdisolusi', 'PIC Uji Disolusi');
		$grid->setLabel('vhasil_sdisolusi', 'Hasil Uji Disolusi');
		$grid->setLabel('isdisolusi', 'Kesimpulan Uji Disolusi');
		$grid->setLabel('thasil_sdisolusi', 'Tgl. Kesimpulan Uji Disolusi');
		$grid->setLabel('tstart_smikro', 'Tgl. Mulai Uji Mikrobiologi');
		$grid->setLabel('tend_smikro', 'Tgl. Selesai Uji Mikrobiologi');
		$grid->setLabel('vnip_pic_smikro', 'PIC Uji Mikrobiologi');
		$grid->setLabel('vhasil_smikro', 'Hasil Uji Mikrobiologi');
		$grid->setLabel('imikro', 'Kesimpulan Uji Mikrobiologi');
		$grid->setLabel('thasil_smikro', 'Tgl. Kesimpulan Uji Mikrobiologi');
		$grid->setLabel('ilab', 'Hasil Stress Test');
		$grid->setLabel('thasil_ilab', 'Tgl. Hasil Stress Test');
		$grid->setLabel('tnote', 'Catatan');
		
		$grid->setLabel('iskimiawi', 'Analisa Kimiawi');
		$grid->setLabel('ikimiawi', 'Analisa Kimiawi');
		$grid->setLabel('isdisolusi', 'Uji UDT');		
		$grid->setLabel('ismikro', 'Uji Mikrobiologi');
		$grid->setLabel('istress', 'Stress Test');
		//$grid->setQuery('ihold', 0);
		$grid->setQuery('plc2_upb_formula.ldeleted', 0);
		$grid->setQuery('plc2_upb_formula.istress <> 4', null);
		
		/*Start Buat Upload*/
		//Set Form Supaya ectype=multipart dan jadi iframe post
		$grid->setFormUpload(TRUE);
		//Pilih yg mau jadi file upload
		//$grid->changeFieldType('filename','upload');
		$grid->changeFieldType('vhasil_skimiawi','upload');
		$grid->changeFieldType('vhasil_sdisolusi','upload');
		$grid->changeFieldType('vhasil_smikro','upload');
		//Tentuin Pathnya
		//$grid->setUploadPath('filename', './files/plc/product_trial/formula_trial/');
		$grid->setUploadPath('vhasil_skimiawi', './files/plc/product_trial/formula_trial/');
		$grid->setUploadPath('vhasil_sdisolusi', './files/plc/product_trial/formula_trial/');
		$grid->setUploadPath('vhasil_smikro', './files/plc/product_trial/formula_trial/');
		//Tentuin filetype nya
		//$grid->setAllowedTypes('filename', 'gif|jpg|png|jpeg|pdf'); // Kalo mau semua di termima pake * (Bintang)
		$grid->setAllowedTypes('vhasil_skimiawi', 'gif|jpg|png|jpeg|pdf');
		$grid->setAllowedTypes('vhasil_sdisolusi', 'gif|jpg|png|jpeg|pdf');
		$grid->setAllowedTypes('vhasil_smikro', 'gif|jpg|png|jpeg|pdf');
		//Tentuin Max filesizenya
		//$grid->setMaxSize('filename', '1000');
		$grid->setMaxSize('vhasil_skimiawi', '1000');
		$grid->setMaxSize('vhasil_sdisolusi', '1000');
		$grid->setMaxSize('vhasil_smikro', '1000');
		/*End Buat Upload*/
		
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id', 'LEFT');
		$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));
		//$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner');
		
		$grid->changeFieldType('iskimiawi','combobox','',array(0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('ikimiawi','combobox','',array(0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('idisolusi','combobox','',array(0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('isdisolusi','combobox','',array(0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('imikro','combobox','',array(0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('ismikro','combobox','',array(0=>'-',3=>'Tidak Diuji', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('istress','combobox','',array(0=>'-',4=>'Diskontinu',3=>'Kontinu', 2=>'Berhasil', 1=>'Gagal'));
		$grid->changeFieldType('ilab','combobox','',array(0=>'-',4=>'Diskontinu',3=>'Kontinu', 2=>'Berhasil', 1=>'Gagal'));
		
		$grid->setSearch('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','ikimiawi','idisolusi','imikro','istress','plc2_upb.iteampd_id');
		
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
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'), TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'detail':
				$this->detail();
			break;
			case 'download':
				$this->download($this->input->get('file'));
			break;
			default:
				$grid->render_grid();
				break;
		}
    }

	/*function listBox_spesifikasi_fg_tentative_vgenerik($value) {
		return '<ul><li><a href="http://google.com" target="_blank">test</a></li></ul>';
	}*/
	function searchPost_product_trial_stress_test_ikimiawi($value, $name) {
		return $value == 0 ? '' : $value;
	}
	function searchPost_product_trial_stress_test_idisolusi($value, $name) {
		return $value == 0 ? '' : $value;
	}
	function searchPost_product_trial_stress_test_imikro($value, $name) {
		return $value == 0 ? '' : $value;
	}
	function searchPost_product_trial_stress_test_istress($value, $name) {
		return $value == 0 ? '' : $value;
	}
	
	function updateBox_product_trial_stress_test_vkode_surat($field, $id, $value) {
		return '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" value="'.$value.'" class="input_rows1" />';
	}
	
	
	function insertBox_product_trial_stress_test_iupb_id($field, $id) {
		$return = '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="7" />';
		return $return;
	}
	
	function updateBox_product_trial_stress_test_iupb_id($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$return = '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" value="'.$row['vupb_nomor'].'" class="input_rows1" size="7" />';
		return $return;
	}
	
	
	function insertBox_product_trial_stress_test_ispekfg_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/spek/fg/list/trial/popup?field=product_trial_stress_test\',\'List Spesifikasi FG\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	function updateBox_product_trial_stress_test_ispekfg_id($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb_spesifikasi_fg', array('ispekfg_id'=>$rowData['ispekfg_id']))->row_array();
		/*$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';*/
		//$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		$return = '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$row['vkode_surat'].'" />';
		//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/spek/fg/list/trial/popup?field=product_trial_stress_test\',\'List Spesifikasi FG\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function insertBox_product_trial_stress_test_vupb_nama($field, $id) {
		return '<input type="text" disabled name="'.$field.'" id="'.$id.'" class="input_rows1 required" size="50" />';
	}
	
	function updateBox_product_trial_stress_test_vupb_nama($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		$return = '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" value="'.$row['vupb_nama'].'" class="input_rows1" size="50" />';
		return $return;
	}
	
	function insertBox_product_trial_stress_test_vgenerik($field, $id) {
		return '<textarea disabled="TRUE" name="'.$field.'" id="'.$id.'"></textarea>';		
		return '<input type="text" disabled="TRUE" name="'.$field.'" id="'.$id.'" class="input_rows1 required" size="50" />';
	}

	function updateBox_product_trial_stress_test_vgenerik($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		return '<textarea cols="50" disabled="TRUE" name="'.$field.'" id="'.$id.'">'.$row['vgenerik'].'</textarea>';
		$return = '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" value="'.$row['vgenerik'].'" class="input_rows1" size="50" />';
		return $return;
	}
	
	function insertBox_product_trial_stress_test_iteampd_id($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$field.'" id="'.$id.'" class="input_rows1 required" size="40" />';
	}
	
	function updateBox_product_trial_stress_test_iteampd_id($field, $id, $value, $rowData) {
		$sql = "SELECT t.vteam FROM plc2.plc2_upb u INNER JOIN plc2.plc2_upb_team t ON u.iteampd_id=t.iteam_id WHERE u.iupb_id='".$rowData['iupb_id']."'";
		$row = $this->db_plc0->query($sql)->row_array();
		return '<input type="text" disabled="TRUE" name="'.$field.'" id="'.$id.'" value="'.$row['vteam'].'" class="input_rows1 required" size="40" />';
	}
	
	function updateBox_product_trial_stress_test_vrevisi($field, $id, $value) {
		return '<input type="text" name="'.$field.'" disabled="TRUE" id="'.$id.'" value="'.$value.'" class="input_rows1" />';
	}
	
	function insertBox_product_trial_stress_test_vnip_formulator($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	function updateBox_product_trial_stress_test_vnip_formulator($field, $id, $value, $rowData) {		 
		$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		$v = count($row) > 0 ? $row['cNip'].' - '.$row['vName'] : '' ;
		/*$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';*/
		//$return .= '<input type="hidden" value="'.$value.'" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />';
		$return = '<input type="text" value="'.$v.'" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function insertBox_product_trial_stress_test_vnip_pic_skimiawi($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1" />';
		$return .= '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test&col='.$field.'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	function updateBox_product_trial_stress_test_vnip_pic_skimiawi($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		$v = count($row) > 0 ? $row['cNip'].' - '.$row['vName'] : '' ;
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" value="'.$value.'" name="'.$field.'" id="'.$id.'" class="input_rows1" />';
		$return .= '<input type="text" value="'.$v.'" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test&col='.$field.'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function insertBox_product_trial_stress_test_vnip_pic_sdisolusi($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1" />';
		$return .= '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test&col='.$field.'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	function updateBox_product_trial_stress_test_vnip_pic_sdisolusi($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		$v = count($row) > 0 ? $row['cNip'].' - '.$row['vName'] : '' ;
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" value="'.$value.'" name="'.$field.'" id="'.$id.'" class="input_rows1" />';
		$return .= '<input type="text" value="'.$v.'" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test&col='.$field.'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	function insertBox_product_trial_stress_test_vnip_pic_smikro($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1" />';
		$return .= '<input type="text" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test&col='.$field.'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	function updateBox_product_trial_stress_test_vnip_pic_smikro($field, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		$v = count($row) > 0 ? $row['cNip'].' - '.$row['vName'] : '' ;
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" value="'.$value.'" name="'.$field.'" id="'.$id.'" class="input_rows1" />';
		$return .= '<input type="text" value="'.$v.'" name="'.$field.'_dis" disabled="TRUE" id="'.$id.'_dis" size="40" class="" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/spek/fg/employee/popup?field=product_trial_stress_test&col='.$field.'\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	function insertPost_product_trial_stress_test_filename($value, $name, $post) {
		$new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		return $new_name;
	}	
	function updatePost_product_trial_stress_test_filename($value, $name, $post) {
		$new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		return $new_name;
	}

	function insertPost_product_trial_stress_test_vhasil_kimiawi($value, $name, $post) {
		$new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		return $new_name;
	}	
	function updatePost_product_trial_stress_test_vhasil_kimiawi($value, $name, $post) {
		$new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		return $new_name;
	}
	
	function insertPost_product_trial_stress_test_vhasil_disolusi($value, $name, $post) {
		$new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		return $new_name;
	}	
	function updatePost_product_trial_stress_test_vhasil_disolusi($value, $name, $post) {
		$new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		return $new_name;
	}
	
	function insertPost_product_trial_stress_test_vhasil_mikro($value, $name, $post) {
		$new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		return $new_name;
	}	
	function updatePost_product_trial_stress_test_vhasil_mikro($value, $name, $post) {
		$new_name = 'forSkaTrial_file_'.$post['ispekfg_id'].'_'.date('Y-m-d_H_i_s');
		return $new_name;
	}

	function updateBox_product_trial_stress_test_tstart_stress($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl input_rows1 datepicker" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}

	function updateBox_product_trial_stress_test_tend_stress($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl input_rows1 datepicker" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}

	function updateBox_product_trial_stress_test_tupload_stress($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl input_rows1 datepicker" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	
	function updateBox_product_trial_stress_test_tberlaku($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" disabled="TRUE" class="input_tgl input_rows1 required" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}	
	function updateBox_product_trial_stress_test_tstart_skimiawi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_tend_skimiawi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_thasil_skimiawi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_tstart_sdisolusi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_tend_sdisolusi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_thasil_sdisolusi($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_tstart_smikro($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_tend_smikro($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_thasil_smikro($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	function updateBox_product_trial_stress_test_thasil_ilab($field, $id, $value, $rowData) {
		$this->load->helper('to_mysql');
		$val = $value == '' || $value == '0000-00-00' ? '' : to_mysql($value, TRUE);
		$return = '<input type="text" class="input_tgl datepicker input_rows1" name="'.$field.'" value="'.$val.'" id="'.$id.'">';
		return $return;
	}
	
	function updateBox_product_trial_stress_test_tnote($field, $id, $value) {
		return '<textarea name="'.$field.'" id="'.$id.'" disabled="TRUE">'.$value.'</textarea>';
	}
	
	
	function updateBox_product_trial_stress_test_filename($field, $id, $value, $rowData) {
		//$input = '<input type="file" name="'.$field.'" id="'.$id.'" class="" size="50" />';
		$input = '';
		if($value != '') {
			if (file_exists('./files/plc/product_trial/formula_trial/'.$value)) {
				$link = base_url().'processor/plc/product/trial/formula/skala/trial?action=download&file='.$value;
				$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			}
			else {
				$linknya = 'File sudah tidak ada!';
			}
			return 'File name : '.$value.' ['.$linknya.']<br />'.$input;
		}
		else {
			return 'No File<br />'.$input;
		}		
	}
	
	function download($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$path = file_get_contents('./files/plc/product_trial/formula_trial/'.$name);		
		force_download($name, $path);
	}
	
	function updateBox_product_trial_stress_test_vhasil_skimiawi($field, $id, $value, $rowData) {
		$input = '<input type="file" name="'.$field.'" id="'.$id.'" class="" size="50" />';
		if($value != '') {
			if (file_exists('./files/plc/product_trial/formula_trial/'.$value)) {
				$link = base_url().'processor/plc/product/trial/formula/skala/trial?action=download&file='.$value;
				$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			}
			else {
				$linknya = 'File sudah tidak ada!';
			}
			return 'File name : '.$value.' ['.$linknya.']<br />'.$input;
		}
		else {
			return 'No File<br />'.$input;
		}		
	}
	
	function updateBox_product_trial_stress_test_vhasil_sdisolusi($field, $id, $value, $rowData) {
		$input = '<input type="file" name="'.$field.'" id="'.$id.'" class="" size="50" />';
		if($value != '') {
			if (file_exists('./files/plc/product_trial/formula_trial/'.$value)) {
				$link = base_url().'processor/plc/product/trial/formula/skala/trial?action=download&file='.$value;
				$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			}
			else {
				$linknya = 'File sudah tidak ada!';
			}
			return 'File name : '.$value.' ['.$linknya.']<br />'.$input;
		}
		else {
			return 'No File<br />'.$input;
		}		
	}
	
	function updateBox_product_trial_stress_test_vhasil_smikro($field, $id, $value, $rowData) {
		$input = '<input type="file" name="'.$field.'" id="'.$id.'" class="" size="50" />';
		if($value != '') {
			if (file_exists('./files/plc/product_trial/formula_trial/'.$value)) {
				$link = base_url().'processor/plc/product/trial/formula/skala/trial?action=download&file='.$value;
				$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
			}
			else {
				$linknya = 'File sudah tidak ada!';
			}
			return 'File name : '.$value.' ['.$linknya.']<br />'.$input;
		}
		else {
			return 'No File<br />'.$input;
		}		
	}
	
	function updateBox_spesifikasi_fg_tentative_spesifikasi ($field, $id, $value, $rowData) {
		$this->db_plc0->where(array('ispekfg_id'=>$rowData['ispekfg_id'], 'ldeleted'=>0));
		$this->db_plc0->order_by('iurut','asc');
		$data['rows'] = $this->db_plc0->get('plc2.plc2_upb_spesifikasi_fg_sediaan')->result_array();
		return $this->load->view('spek_fg_spesifikasi', $data, TRUE);
	}
	
	function before_insert_processor($row, $postData) {
		$this->load->helper('to_mysql');
		$skrg = date('Y-m-d H:i:s');
		$postData['tupdate'] = $skrg;
		unset($postData['vupb_nama']);
		unset($postData['vgenerik']);
		unset($postData['iteampd_id']);
		
		$postData['tstart_stress'] = to_mysql($postData['tstart_stress']);
		$postData['tend_stress'] = to_mysql($postData['tend_stress']);
		$postData['tupload_stress'] = to_mysql($postData['tupload_stress']);
		
		$postData['tberlaku'] = to_mysql($postData['tberlaku']);
		$postData['tstart_kimiawi'] = to_mysql($postData['tstart_kimiawi']);
		$postData['tend_kimiawi'] = to_mysql($postData['tend_kimiawi']);
		$postData['tupload_kimiawi'] = to_mysql($postData['tupload_kimiawi']);
		$postData['tstart_disolusi'] = to_mysql($postData['tstart_disolusi']);
		$postData['tend_disolusi'] = to_mysql($postData['tend_disolusi']);
		$postData['tupload_disolusi'] = to_mysql($postData['tupload_disolusi']);
		$postData['tstart_smikro'] = to_mysql($postData['tstart_mikro']);
		$postData['tend_mikro'] = to_mysql($postData['tend_mikro']);
		$postData['thasil_smikro'] = to_mysql($postData['thasil_smikro']);
		$postData['thasil_istress'] = to_mysql($postData['thasil_istress']);
		$postData['thasil_ilab'] = to_mysql($postData['thasil_ilab']);
		return $postData;
	}
	
	function aafter_insert_processor($row, $insertId, $postData) {
		$upbId = $postData['iupb_id'];
		$i=1;
		$skrg = date('Y-m-d H:i:s');
		$user = $this->auth->user();
		$upb = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$upbId))->row_array();
		
		$this->db_plc0->where('isediaan_id', $upb['isediaan_id']);
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('iurut', 'asc');
		$spek = $this->db_plc0->get('plc2.plc2_upb_master_sediaan_spesifikasi_fg')->result_array();
		foreach($spek as $k => $v) {
			$dt['ispekfg_id'] = $insertId;
			$dt['isediaanspek_id'] = $v['isediaanspek_id'];
			$dt['iurut'] = $v['iurut'];
			$dt['vspesifikasi'] = $v['vspesifikasi'];
			$dt['istabilita'] = $v['istabilita'];
			$this->db_plc0->insert('plc2.plc2_upb_spesifikasi_fg_sediaan', $dt);
		}
	}
	
	function before_update_processor($row, $postData) {
		$this->load->helper('to_mysql');
		$skrg = date('Y-m-d H:i:s');
		unset($postData['vupb_nama']);
		unset($postData['vgenerik']);
		unset($postData['iteampd_id']);
		//$postData['tupdate'] = $skrg;
		//$postData['tberlaku'] = to_mysql($postData['tberlaku']);
		$postData['tstart_skimiawi'] = to_mysql($postData['tstart_skimiawi']);
		$postData['tend_skimiawi'] = to_mysql($postData['tend_skimiawi']);
		$postData['thasil_skimiawi'] = to_mysql($postData['thasil_skimiawi']);
		$postData['tstart_sdisolusi'] = to_mysql($postData['tstart_sdisolusi']);
		$postData['tend_sdisolusi'] = to_mysql($postData['tend_sdisolusi']);
		$postData['thasil_sdisolusi'] = to_mysql($postData['thasil_sdisolusi']);
		$postData['tstart_smikro'] = to_mysql($postData['tstart_smikro']);
		$postData['tend_smikro'] = to_mysql($postData['tend_smikro']);
		$postData['thasil_smikro'] = to_mysql($postData['thasil_smikro']);
		//$postData['thasil_istress'] = to_mysql($postData['thasil_istress']);
		$postData['tstart_stress'] = to_mysql($postData['tstart_stress']);
		$postData['tend_stress'] = to_mysql($postData['tend_stress']);
		$postData['tupload_stress'] = to_mysql($postData['tupload_stress']);
		$postData['thasil_ilab'] = to_mysql($postData['thasil_ilab']);
		return $postData;
	}
	
	function aafter_update_processor($row, $updateId, $postData) {
		$this->load->helper('search_array');
		$spekDetID = $postData['ispekfgsediaan_id'];
		$spek = $postData['vspesifikasi'];
		$value = $postData['vvalue'];
		$i=1;
		$skrg = date('Y-m-d H:i:s');
		$user = $this->auth->user();
		$skrg = date('Y-m-d H:i:s');
		$existData = $this->db_plc0->get_where('plc2.plc2_upb_spesifikasi_fg_sediaan', array('ispekfg_id'=>$updateId, 'ldeleted'=>0))->result_array();
		foreach($existData as $k => $v) {
			if(in_array($v['ispekfgsediaan_id'], $spekDetID)) {
				$this->db_plc0->where('ispekfgsediaan_id', $v['ispekfgsediaan_id']);
				$key = array_search($v['ispekfgsediaan_id'], $spekDetID);
				$this->db_plc0->update('plc2.plc2_upb_spesifikasi_fg_sediaan', array('vspesifikasi'=>$spek[$key], 'vvalue'=>$value[$key], 'cnip'=>$user->gNIP, 'tupdate'=>$skrg));
			}
			else {
				$this->db_plc0->where('ispekfgsediaan_id', $v['ispekfgsediaan_id']);
				$this->db_plc0->update('plc2.plc2_upb_spesifikasi_fg_sediaan', array('ldeleted'=>1, 'cnip'=>$user->gNIP, 'tupdate'=>$skrg));
			}
		}
		$this->db_plc0->where(array('ispekfg_id'=>$updateId,'ldeleted'=>0));
		$this->db_plc0->order_by('iurut', 'asc');
		$drows = $this->db_plc0->get('plc2.plc2_upb_spesifikasi_fg_sediaan')->result_array();
		$ur = 1;
		foreach($drows as $drow) {
			$this->db_plc0->where('ispekfgsediaan_id', $drow['ispekfgsediaan_id']);
			$this->db_plc0->update('plc2.plc2_upb_spesifikasi_fg_sediaan', array('iurut'=>$ur));
			$ur++;
		}
		foreach($spek as $k => $v) {
			if(empty($spekDetID[$k])) {
				$dt['ispekfg_id'] = $updateId;
				$dt['iurut'] = $ur;
				$dt['vspesifikasi'] = $v;
				$dt['vvalue'] = $value[$k];
				$dt['tupdate'] = $skrg;
				$dt['cnip'] = $user->gNIP;
				$ur++;
				$this->db_plc0->insert('plc2.plc2_upb_spesifikasi_fg_sediaan', $dt);
			}
		}
	}
	
	function output(){
    	$this->index($this->input->get('action'));
    }
}
