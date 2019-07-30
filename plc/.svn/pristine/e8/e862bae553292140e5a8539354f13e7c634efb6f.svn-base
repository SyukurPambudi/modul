<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cek_dokumen extends MX_Controller {
	var $_url;
	var $dbset;
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->load->library('biz_process');
		$this->load->library('lib_utilitas');
		$this->user = $this->auth->user(); 
		$this->dbset = $this->load->database('plc', true);
		$this->_table = 'plc2.plc2_upb';
		$this->_url = 'cek_dokumen';
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setFormUpload(TRUE);
		$grid->setTitle('Cek Dokumen Pra Registrasi');		
		$grid->setTable($this->_table);		
		$grid->setUrl('cek_dokumen');
		$grid->addList('vupb_nomor','vupb_nama','iconfirm_dok');
		$grid->setSortBy('iupb_id');
		$grid->setSortOrder('desc');
		$grid->setSearch('vupb_nomor','vupb_nama');
		$grid->addFields('iupb_id','vupb_nama','DMF','coars','ws','coabb','lsa'); //dokumen bahan baku
		$grid->addFields('file_spek','file_formula','prosprod','lpp','form_valpro','lapprot_valpro','coaex','lsaex','soiex','coafg','file_soifg','lapport_valmoa'); //dokumen basic formula
		$grid->addFields('lapori','lapprot_udt','file_bahankemas','protaccel','protreal','dokstab','kube','vnip_confirm_dok'); //dokumen produksi pilot
		$grid->setRequired('iupb_id','plc2_upb.vupb_nomor');
	
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setWidth('vupb_nomor', '73');
		$grid->setLabel('iupb_id', 'UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setWidth('vupb_nama', '189');
		
		$grid->setLabel('DMF','File DMF');
		$grid->setLabel('coars','File CoA RS');
		$grid->setLabel('ws','File CoA WS');
		$grid->setLabel('lsa','File LSA Zat Aktif');
		$grid->setLabel('coabb','File COA Bahan Baku');
		$grid->setLabel('file_spek','File Spesifikasi FG');
		$grid->setLabel('file_soifg','File SOI FG');
		$grid->setLabel('file_formula','File Formula');
		$grid->setLabel('prosprod','File Proses Produksi');
		$grid->setLabel('lpp','Laporan Pengembangan Produk');
		$grid->setLabel('form_valpro','Form Validasi Proses');
		$grid->setLabel('coafg','CoA FG');
		$grid->setLabel('lapport_valmoa','Laporan & Protokol Validasi MoA');
		$grid->setLabel('lapori','Laporan Originator');
		$grid->setLabel('lapprot_valpro','Laporan & Protokol Validasi Proses');
		$grid->setLabel('coaex','CoA Excipients');
		$grid->setLabel('lsaex','LSA Excipients');
		$grid->setLabel('soiex','SOI Excipients');
		$grid->setLabel('lapprot_udt','Laporan & Protokol UDT');
		$grid->setLabel('file_bahankemas','File Bahan Kemas');
		$grid->setLabel('protaccel','File Protocol Stabilita Accelerated');
		$grid->setLabel('protreal','File Protocol Stabilita Real Time');
		$grid->setLabel('dokstab','File Dokumen Stabilita (Tambahan)');
		$grid->setLabel('kube','File Kajian Uji BE');
		$grid->setLabel('iconfirm_dok','Konfirmasi Busdev Manager');
		$grid->setLabel('vnip_confirm_dok','Konfirmasi Busdev Manager');

		$grid->setQuery('plc2_upb.ihold', 0);
		$grid->setQuery('plc2_upb.iupb_id IN (select fo.iupb_id from plc2.plc2_upb_formula fo where fo.ibest=2 and fo.iapppd_basic=2 and fo.ldeleted=0 )', null); //sudah pny basic formula
		$grid->setQuery('plc2_upb.iupb_id IN (select distinct(bk.iupb_id) from plc2.plc2_upb_bahan_kemas bk where bk.iappqa=2 and bk.ldeleted=0)', null); //sudah approve bahan kemas
		$grid->setQuery('plc2_upb.iupb_id IN (select distinct(bk.iupb_id) from plc2.plc2_upb_spesifikasi_fg bk where bk.iappqa=2 and bk.ldeleted=0)', null); //sudah approve spesifikasi FG

		
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			 if(in_array('PD', $manager)){
				 $type='PD';
				//print_r($this->auth->my_teams(true));
				//echo $this->auth->my_teams();
				if(in_array('2',$this->auth->my_teams(true))){}
				else{$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);}
			}
			 elseif(in_array('QA', $manager)){
				 $type='QA';
				 $grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth->my_teams().')', null);
			 }
			 elseif(in_array('QC', $manager)){
				 $type='QC';
				 $grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth->my_teams().')', null);
			 }
			elseif(in_array('BD', $manager)){
				$type='BD';
				$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			 if(in_array('PD', $team)){
				 $type='PD';
					//cek untuk PD ulujami, iteam_id=2
					if(in_array('2',$this->auth->my_teams(true))){}
					else{$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);}
			 }
			 elseif(in_array('QA', $team)){
				 $type='QA';
				 $grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth->my_teams().')', null);
			 }
			 elseif(in_array('QC', $team)){
				 $type='QC';
				 $grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth->my_teams().')', null);
			 }
			elseif(in_array('BD', $team)){
				$type='BD';
				$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		
		//$grid->changeFieldType('itipe','combobox','',array('' => '-', 1=>'Primer', 2=>'Sekunder', 3=>'Leaflet'));		
		//$grid->changeFieldType('itipe','combobox','',array('' => '-',  1=>'Primer', 2=>'UB (Sekunder)',3=>'MB (Sekunder)', 4=>'Label (Sekunder)', 5=>'Leaflet (Sekunder)'));		
		
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
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				//print_r($this->input->post());
				$isUpload = $this->input->get('isUpload');
				
				$iupb_id=$this->input->post('cek_dokumen_iupb_id');
				//cari ifor_id
				$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
						order by fo.ifor_id desc limit 1";
				$q_for=$this->db_plc0->query($sql_for)->row_array();
				$ifor_id=$q_for['ifor_id'];
				//print_r($q_for);
				
				//cari ibk_id
				$sql_bk="select bk.* from plc2.plc2_upb_bahan_kemas bk where bk.iappqa=2 and bk.iupb_id='$iupb_id'
							order by bk.ibk_id desc limit 1";
				$q_bk=$this->db_plc0->query($sql_bk)->row_array();
				$ibk_id=$q_bk['ibk_id'];
				
				//cari ispekfg_id
				$sql_spek="select fg.* from plc2.plc2_upb_spesifikasi_fg fg 
							where fg.iappqa=2 and fg.iupb_id='$iupb_id' and fg.ldeleted=0
							order by fg.ispekfg_id desc limit 1";
				$q_spek=$this->db_plc0->query($sql_spek)->row_array();
				$ispek_id=$q_spek['ispekfg_id'];
				//print_r($q_bk);
				
				//cari isoi_id
				$sql_soi="select fg.* from plc2.plc2_upb_soi_fg fg 
							where fg.iappqa=2 and fg.iupb_id='$iupb_id' and fg.ldeleted=0
								order by fg.isoi_id desc limit 1";
				$q_soi=$this->db_plc0->query($sql_soi)->row_array();
				if($q_soi){
					$isoi_id=$q_soi['isoi_id'];
				}else{
					$sql_in="INSERT INTO plc2.plc2_upb_soi_fg (iupb_id, filename, itype, vkode_surat, vnip_qc, vnip_qa, iapppd, iappqa, iappqc, istatus, isOldVersion) VALUES ('".$iupb_id."', 'xxxxxxxxxx', 1, 'xxxxxxxxxx', 'N07026', 'N13840', 2, 2, 2, 3, 1)";
					$this->dbset->query($sql_in);
					$sql_soi="select fg.* from plc2.plc2_upb_soi_fg fg 
							where fg.iappqa=2 and fg.iupb_id='$iupb_id' and fg.ldeleted=0
								order by fg.isoi_id desc limit 1";
					$q_soi=$this->db_plc0->query($sql_soi)->row_array();
					$isoi_id=$q_soi['isoi_id'];
				}
				//print_r($q_bk);
				
				$sql1 = array();
				$file_name1= "";
				$fileId1 = array();
				$confirm1 = array();
				$sqld = array();
				$file_named= "";
				$fileIdd = array();
				$confirm2 = array();
				$sqlc = array();
				$file_namec= "";
				$fileIdc = array();
				$confirm3 = array();
				$sqll = array();
				$file_namel= "";
				$fileIdl = array();
				$confirml = array();
				$sqlw = array();
				$file_namew= "";
				$fileIdw = array();
				$confirmw = array();
				$sql6 = array();
				$file_name6= "";
				$fileId6 = array();
				$confirm6 = array();
				$sql7 = array();
				$file_name7= "";
				$fileId7 = array();
				$confirm7 = array();
				$sql8 = array();
				$file_name8= "";
				$fileId8 = array();
				$confirm8 = array();
				$sql9 = array();
				$file_name9= "";
				$fileId9 = array();
				$confirm9 = array();
				$sql10 = array();
				$file_name10= "";
				$fileId10 = array();
				$confirm10 = array();
				$sql11 = array();
				$file_name11= "";
				$fileId11 = array();
				$confirm11 = array();
				$sql12 = array();
				$file_name12= "";
				$fileId12 = array();
				$confirm12 = array();
				$sql14 = array();
				$file_name14= "";
				$fileId14 = array();
				$confirm14 = array();
				
				$sql13 = array();
				$file_name13= "";
				$fileId13 = array();
				$confirm13 = array();
				
				$sql15 = array();
				$file_name15= "";
				$fileId15 = array();
				$confirm15 = array();
				$sql16 = array();
				$file_name16= "";
				$fileId16 = array();
				$confirm16 = array();
				$sql17 = array();
				$file_name17= "";
				$fileId17 = array();
				$confirm17 = array();
				$sql18 = array();
				$file_name18= "";
				$fileId18 = array();
				$confirm18 = array();
				$sql19 = array();
				$file_name19= "";
				$fileId19 = array();
				$confirm19 = array();
				//stabilita pilot
				$sqlsa = array();
				$file_namesa= "";
				$fileIdsa = array();
				$confirmsa = array();
				$sqlsr = array();
				$file_namesr= "";
				$fileIdsr = array();
				$confirmsr = array();
				$sqlsd = array();
				$file_namesd= "";
				$fileIdsd = array();
				$confirmsd = array();
				$sqlbb = array();
				$file_namebb= "";
				$fileIdbb = array();
				$confirmbb = array();
				$sqlbe = array();
				$file_namebe= "";
				$fileIdbe = array();
				$confirmbe = array();

					$path = realpath("files/plc/bahan_kemas");
					$pathd = realpath("files/plc/dmf");
					$pathc = realpath("files/plc/coars");
					$pathw = realpath("files/plc/ws");
					$pathl = realpath("files/plc/lsa");
					$pathbb = realpath("files/plc/coabb");
					$path6 = realpath("files/plc/lpp");
					$path7 = realpath("files/plc/lapprot_valpro");
					$path8 = realpath("files/plc/coaex/");
					$path9 = realpath("files/plc/lsaex/");
					$path10 = realpath("files/plc/soiex/");
					$path11 = realpath("files/plc/coafg/");
					$path12 = realpath("files/plc/lapori/");
					$path14 = realpath("files/plc/udt/");
					$path13 = realpath("files/plc/lapprot_valmoa/");
					$path15 = realpath("files/plc/form_valpro/");
					$path16 = realpath("files/plc/spek_fg/");
					$path17 = realpath("files/plc/spek_soi_fg/");
					$path18 = realpath("files/plc/product_trial/skala_trial/filename/");
					$path19 = realpath("files/plc/product_trial/basic_formula/pros_prod/");
					$pathsa = realpath("files/plc/prot_accel");
					$pathsr = realpath("files/plc/prot_real");
					$pathsd= realpath("files/plc/dokstab");
					$pathbe= realpath("files/plc/kube");
					
					if (!file_exists($path."/".$ibk_id)) { 
						mkdir($path."/".$ibk_id, 0777, true);					    
					}
					if (!file_exists($pathbb."/".$iupb_id)) { 
						mkdir($pathbb."/".$iupb_id, 0777, true);					    
					}
					if (!file_exists($pathd."/".$iupb_id)) { 
						mkdir($pathd."/".$iupb_id, 0777, true);					    
					}
					if (!file_exists($pathc."/".$iupb_id)) { 
						mkdir($pathc."/".$iupb_id, 0777, true);					    
					}
					if (!file_exists($pathw."/".$iupb_id)) { 
						mkdir($pathw."/".$iupb_id, 0777, true);					    
					}
					if (!file_exists($pathl."/".$iupb_id)) { 
						mkdir($pathl."/".$iupb_id, 0777, true);					    
					}
					if (!file_exists($path6."/".$ifor_id)) { 
						mkdir($path6."/".$ifor_id, 0777, true);					    
					}
					if (!file_exists($path7."/".$ifor_id)) { 
						mkdir($path7."/".$ifor_id, 0777, true);					    
					}
					if (!file_exists($path8."/".$ifor_id)) { 
						mkdir($path8."/".$ifor_id, 0777, true);					    
					}
					if (!file_exists($path9."/".$ifor_id)) { 
						mkdir($path9."/".$ifor_id, 0777, true);					    
					}
					if (!file_exists($path10."/".$ifor_id)) { 
						mkdir($path10."/".$ifor_id, 0777, true);					    
					}
					if (!file_exists($path11."/".$ifor_id)) { 
						mkdir($path11."/".$ifor_id, 0777, true);					    
					}
					if (!file_exists($path12."/".$ifor_id)) { 
						mkdir($path12."/".$ifor_id, 0777, true);					    
					}
					if (!file_exists($path14."/".$ifor_id)) { 
						mkdir($path14."/".$ifor_id, 0777, true);					    
					}
					if (!file_exists($path13."/".$ifor_id)) { 
						mkdir($path13."/".$ifor_id, 0777, true);					    
					}
					if (!file_exists($path15."/".$ifor_id)) { 
						mkdir($path15."/".$ifor_id, 0777, true);					    
					}
					if (!file_exists($path16."/".$ispek_id)) { 
						mkdir($path16."/".$ispek_id, 0777, true);					    
					}
					if (!file_exists($path17."/".$isoi_id)) { 
						mkdir($path17."/".$isoi_id, 0777, true);					    
					}
					if (!file_exists($path18."/".$ifor_id)) { 
						mkdir($path18."/".$ifor_id, 0777, true);					    
					}
					if (!file_exists($path19."/".$ifor_id)) { 
						mkdir($path19."/".$ifor_id, 0777, true);					    
					}
					if (!file_exists( $pathsa."/".$ifor_id)) { 
					mkdir($pathsa."/".$ifor_id, 0777, true);					    
					}
					if (!file_exists( $pathsr."/".$ifor_id)) { 
						mkdir($pathsr."/".$ifor_id, 0777, true);					    
					}
					if (!file_exists( $pathsd."/".$ifor_id)) { 
						mkdir($pathsd."/".$ifor_id, 0777, true);					    
					}
					if (!file_exists( $pathbe."/".$iupb_id)) { 
						mkdir($pathbe."/".$iupb_id, 0777, true);					    
					}
				
					$file_keterangan = array();
					$ijenis_bk_id = array();
					$file_keterangand = array();
					$file_keteranganc = array();
					$file_keteranganw = array();
					$file_keteranganl = array();
					$file_keterangan6 = array();
					$file_keterangan7 = array();
					$file_keterangan8 = array();
					$file_keterangan9 = array();
					$file_keterangan10 = array();
					$file_keterangan11 = array();
					$file_keterangan12 = array();
					$file_keterangan14 = array();
					
					$file_keterangan13 = array();
					
					$file_keterangan15 = array();
					$file_keterangan16 = array();
					$file_keterangan17 = array();
					$file_keterangan18 = array();
					$file_keterangan19 = array();
					$file_keterangansa = array();
					$file_keterangansd = array();
					$file_keterangansr = array();
					$file_keteranganbb = array();
					$file_keteranganbe = array();
				
				//print_r($_POST);
				foreach($_POST as $key=>$value) {
					if ($key == 'fileketerangan') {
						foreach($value as $y=>$u) {
							$file_keterangan[$y] = $u;
						}
					}
					if ($key == 'ijenis_bk_id') {
						foreach($value as $k=>$v) {
							$ijenis_bk_id[$k] = $v;
						}
					}
					if ($key == 'namafile') {
						foreach($value as $k=>$v) {
							$file_name1[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid') {
						foreach($value as $k=>$v) {
							$fileId1[$k] = $v;
						}
					}
					if ($key == 'confirm') {
						foreach($value as $k=>$v) {
							$confirm1[$k] = $v;
						}
					}
					if ($key == 'fileketerangand') {
						foreach($value as $y=>$u) {
							$file_keterangand[$y] = $u;
						}
					}
					if ($key == 'namafiled') {
						foreach($value as $k=>$v) {
							$file_named[$k] = $v;
						}
					}					
					//
					if ($key == 'fileidd') {
						foreach($value as $k=>$v) {
							$fileIdd[$k] = $v;
						}
					}
					if ($key == 'confirm2') {
						foreach($value as $k=>$v) {
							$confirm2[$k] = $v;
						}
					}
					if ($key == 'fileketeranganc') {
						foreach($value as $y=>$u) {
							$file_keteranganc[$y] = $u;
						}
					}
					if ($key == 'namafilec') {
						foreach($value as $k=>$v) {
							$file_namec[$k] = $v;
						}
					}					
					//
					if ($key == 'fileidc') {
						foreach($value as $k=>$v) {
							$fileIdc[$k] = $v;
						}
					}
					if ($key == 'confirm3') {
						foreach($value as $k=>$v) {
							$confirm3[$k] = $v;
						}
					}
					if ($key == 'fileketeranganl') {
						foreach($value as $y=>$u) {
							$file_keteranganl[$y] = $u;
						}
					}
					if ($key == 'namafilel') {
						foreach($value as $k=>$v) {
							$file_namel[$k] = $v;
						}
					}					
					//
					if ($key == 'fileidl') {
						foreach($value as $k=>$v) {
							$fileIdl[$k] = $v;
						}
					}
					if ($key == 'confirml') {
						foreach($value as $k=>$v) {
							$confirml[$k] = $v;
						}
					}
					if ($key == 'fileketeranganw') {
						foreach($value as $y=>$u) {
							$file_keteranganw[$y] = $u;
						}
					}
					if ($key == 'namafilew') {
						foreach($value as $k=>$v) {
							$file_namew[$k] = $v;
						}
					}					
					//
					if ($key == 'fileidw') {
						foreach($value as $k=>$v) {
							$fileIdw[$k] = $v;
						}
					}
					if ($key == 'confirmw') {
						foreach($value as $k=>$v) {
							$confirmw[$k] = $v;
						}
					}
					if ($key == 'fileketerangan6') {
						foreach($value as $y=>$u) {
							$file_keterangan6[$y] = $u;
						}
					}
					if ($key == 'namafile6') {
						foreach($value as $k=>$v) {
							$file_name6[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid6') {
						foreach($value as $k=>$v) {
							$fileId6[$k] = $v;
						}
					}
					if ($key == 'confirm6') {
						foreach($value as $k=>$v) {
							$confirm6[$k] = $v;
						}
					}
					if ($key == 'fileketerangan7') {
						foreach($value as $y=>$u) {
							$file_keterangan7[$y] = $u;
						}
					}
					if ($key == 'namafile7') {
						foreach($value as $k=>$v) {
							$file_name7[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid7') {
						foreach($value as $k=>$v) {
							$fileId7[$k] = $v;
						}
					}
					if ($key == 'confirm7') {
						foreach($value as $k=>$v) {
							$confirm7[$k] = $v;
						}
					}
					if ($key == 'fileketerangan8') {
						foreach($value as $y=>$u) {
							$file_keterangan8[$y] = $u;
						}
					}
					if ($key == 'namafile8') {
						foreach($value as $k=>$v) {
							$file_name8[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid8') {
						foreach($value as $k=>$v) {
							$fileId8[$k] = $v;
						}
					}
					if ($key == 'confirm8') {
						foreach($value as $k=>$v) {
							$confirm8[$k] = $v;
						}
					}
					if ($key == 'fileketerangan9') {
						foreach($value as $y=>$u) {
							$file_keterangan9[$y] = $u;
						}
					}
					if ($key == 'namafile9') {
						foreach($value as $k=>$v) {
							$file_name9[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid9') {
						foreach($value as $k=>$v) {
							$fileId9[$k] = $v;
						}
					}
					if ($key == 'confirm9') {
						foreach($value as $k=>$v) {
							$confirm9[$k] = $v;
						}
					}
					if ($key == 'fileketerangan10') {
						foreach($value as $y=>$u) {
							$file_keterangan10[$y] = $u;
						}
					}
					if ($key == 'namafile10') {
						foreach($value as $k=>$v) {
							$file_name10[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid10') {
						foreach($value as $k=>$v) {
							$fileId10[$k] = $v;
						}
					}
					if ($key == 'confirm10') {
						foreach($value as $k=>$v) {
							$confirm10[$k] = $v;
						}
					}
					if ($key == 'fileketerangan11') {
						foreach($value as $y=>$u) {
							$file_keterangan11[$y] = $u;
						}
					}
					if ($key == 'namafile11') {
						foreach($value as $k=>$v) {
							$file_name11[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid11') {
						foreach($value as $k=>$v) {
							$fileId11[$k] = $v;
						}
					}
					if ($key == 'confirm11') {
						foreach($value as $k=>$v) {
							$confirm11[$k] = $v;
						}
					}
					if ($key == 'fileketerangan12') {
						foreach($value as $y=>$u) {
							$file_keterangan12[$y] = $u;
						}
					}
					if ($key == 'namafile12') {
						foreach($value as $k=>$v) {
							$file_name12[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid12') {
						foreach($value as $k=>$v) {
							$fileId12[$k] = $v;
						}
					}
					if ($key == 'confirm12') {
						foreach($value as $k=>$v) {
							$confirm12[$k] = $v;
						}
					}
					if ($key == 'fileketerangan13') {
						foreach($value as $y=>$u) {
							$file_keterangan13[$y] = $u;
						}
					}
					if ($key == 'namafile13') {
						foreach($value as $k=>$v) {
							$file_name13[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid13') {
						foreach($value as $k=>$v) {
							$fileId13[$k] = $v;
						}
					}
					if ($key == 'confirm13') {
						foreach($value as $k=>$v) {
							$confirm13[$k] = $v;
						}
					}
					if ($key == 'fileketerangan14') {
						foreach($value as $y=>$u) {
							$file_keterangan14[$y] = $u;
						}
					}
					if ($key == 'namafile14') {
						foreach($value as $k=>$v) {
							$file_name14[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid14') {
						foreach($value as $k=>$v) {
							$fileId14[$k] = $v;
						}
					}
					if ($key == 'confirm14') {
						foreach($value as $k=>$v) {
							$confirm14[$k] = $v;
						}
					}
					if ($key == 'fileketerangan15') {
						foreach($value as $y=>$u) {
							$file_keterangan15[$y] = $u;
						}
					}
					if ($key == 'namafile15') {
						foreach($value as $k=>$v) {
							$file_name15[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid15') {
						foreach($value as $k=>$v) {
							$fileId15[$k] = $v;
						}
					}
					if ($key == 'confirm15') {
						foreach($value as $k=>$v) {
							$confirm15[$k] = $v;
						}
					}
					if ($key == 'fileketerangan16') {
						foreach($value as $y=>$u) {
							$file_keterangan16[$y] = $u;
						}
					}
					if ($key == 'namafile16') {
						foreach($value as $k=>$v) {
							$file_name16[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid16') {
						foreach($value as $k=>$v) {
							$fileId16[$k] = $v;
						}
					}
					if ($key == 'confirm16') {
						foreach($value as $k=>$v) {
							$confirm16[$k] = $v;
						}
					}
					if ($key == 'fileketerangan17') {
						foreach($value as $y=>$u) {
							$file_keterangan17[$y] = $u;
						}
					}
					if ($key == 'namafile17') {
						foreach($value as $k=>$v) {
							$file_name17[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid17') {
						foreach($value as $k=>$v) {
							$fileId17[$k] = $v;
						}
					}
					if ($key == 'confirm17') {
						foreach($value as $k=>$v) {
							$confirm17[$k] = $v;
						}
					}
					if ($key == 'fileketerangan18') {
						foreach($value as $y=>$u) {
							$file_keterangan18[$y] = $u;
						}
					}
					if ($key == 'namafile18') {
						foreach($value as $k=>$v) {
							$file_name18[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid18') {
						foreach($value as $k=>$v) {
							$fileId18[$k] = $v;
						}
					}
					if ($key == 'confirm18') {
						foreach($value as $k=>$v) {
							$confirm18[$k] = $v;
						}
					}
					if ($key == 'fileketerangan19') {
						foreach($value as $y=>$u) {
							$file_keterangan19[$y] = $u;
						}
					}
					if ($key == 'namafile19') {
						foreach($value as $k=>$v) {
							$file_name19[$k] = $v;
						}
					}					
					//
					if ($key == 'fileid19') {
						foreach($value as $k=>$v) {
							$fileId19[$k] = $v;
						}
					}
					if ($key == 'confirm19') {
						foreach($value as $k=>$v) {
							$confirm19[$k] = $v;
						}
					}
					//////
					if ($key == 'fileketerangansa') {
						foreach($value as $y=>$u) {
							$file_keterangansa[$y] = $u;
						}
					}
					if ($key == 'namafilesa') {
						foreach($value as $k=>$v) {
							$file_namesa[$k] = $v;
						}
					}					
					//
					if ($key == 'fileidsa') {
						foreach($value as $k=>$v) {
							$fileIdsa[$k] = $v;
						}
					}
					if ($key == 'confirmsa') {
						foreach($value as $k=>$v) {
							$confirmsa[$k] = $v;
						}
					}
					if ($key == 'fileketerangansd') {
						foreach($value as $y=>$u) {
							$file_keterangansd[$y] = $u;
						}
					}
					if ($key == 'namafilesd') {
						foreach($value as $k=>$v) {
							$file_namesd[$k] = $v;
						}
					}					
					//
					if ($key == 'fileidsd') {
						foreach($value as $k=>$v) {
							$fileIdsd[$k] = $v;
						}
					}
					if ($key == 'confirmsd') {
						foreach($value as $k=>$v) {
							$confirmsd[$k] = $v;
						}
					}
					if ($key == 'fileketerangansr') {
						foreach($value as $y=>$u) {
							$file_keterangansr[$y] = $u;
						}
					}
					if ($key == 'namafilesr') {
						foreach($value as $k=>$v) {
							$file_namesr[$k] = $v;
						}
					}					
					//
					if ($key == 'fileidsr') {
						foreach($value as $k=>$v) {
							$fileIdsr[$k] = $v;
						}
					}
					if ($key == 'confirmsr') {
						foreach($value as $k=>$v) {
							$confirmsr[$k] = $v;
						}
					}
					if ($key == 'fileketeranganbb') {
						foreach($value as $y=>$u) {
							$file_keteranganbb[$y] = $u;
						}
					}
					if ($key == 'namafilebb') {
						foreach($value as $k=>$v) {
							$file_namebb[$k] = $v;
						}
					}					
					//
					if ($key == 'fileidbb') {
						foreach($value as $k=>$v) {
							$fileIdbb[$k] = $v;
						}
					}
					if ($key == 'confirmbb') {
						foreach($value as $k=>$v) {
							$confirmbb[$k] = $v;
						}
					}
					if ($key == 'fileketeranganbe') {
						foreach($value as $y=>$u) {
							$file_keteranganbe[$y] = $u;
						}
					}
					if ($key == 'namafilebe') {
						foreach($value as $k=>$v) {
							$file_namebe[$k] = $v;
						}
					}					
					//
					if ($key == 'fileidbe') {
						foreach($value as $k=>$v) {
							$fileIdbe[$k] = $v;
						}
					}
					if ($key == 'confirmbe') {
						foreach($value as $k=>$v) {
							$confirmbe[$k] = $v;
						}
					}
				}

				$last_index1 = 0;
				$last_indexd = 0;
				$last_indexc = 0;
				$last_indexl = 0;
				$last_indexw = 0;
				$last_index6 = 0;
				$last_index7 = 0;
				$last_index8 = 0;
				$last_index9 = 0;
				$last_index10 = 0;
				$last_index11 = 0;
				$last_index12 = 0;
				$last_index13 = 0;
				$last_index14 = 0;
				$last_index15 = 0;
				$last_index16 = 0;
				$last_index17 = 0;
				$last_index18 = 0;
				$last_index19 = 0;
				$last_indexsa = 0;
				$last_indexsd = 0;
				$last_indexsr = 0;
				$last_indexbb = 0;
				$last_indexbe = 0;
				
				if($isUpload) {			
					$a = $last_index1;	
					//upload form 2
					if (isset($_FILES['fileupload'])) {
						
						$this->hapusfile($path, $file_name1, 'plc2_upb_file_bahan_kemas',$ibk_id, 'ibk_id');
						foreach ($_FILES['fileupload']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name1 = $_FILES['fileupload']["tmp_name"][$key];
								$name1 = $_FILES['fileupload']["name"][$key];
								$data1['filename'] = $name1;
								$data1['id']=$ibk_id;
								$data1['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data1['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name1, $path."/".$ibk_id."/".$name1)) 
				 				{
									$sql1[] = "INSERT INTO plc2_upb_file_bahan_kemas(ibk_id, ijenis_bk_id, filename, dInsertDate, vketerangan,cInsert, iconfirm_busdev) 
										VALUES ('".$data1['id']."','".$ijenis_bk_id[$a]."', '".$data1['filename']."','".$data1['dInsertDate']."','".$file_keterangan[$a]."','".$data1['nip']."','0')";
									$a++;																			
								//print_r($sql1);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
					foreach($confirm1 as $xkey=>$xx){
						$idnya=$fileId1[$xkey];
						$sqlc1="update plc2_upb_file_bahan_kemas bk set bk.iconfirm_busdev='$xx' where bk.id='$idnya' ";
						$this->dbset->query($sqlc1);
					}
					foreach($sql1 as $q1) {
						try {
							$this->dbset->query($q1);
						}catch(Exception $e) {
							die($e);
						}
					}
					
					//upload dmf
					$d = $last_indexd;	
					if (isset($_FILES['fileuploadd'])) {
						
						$this->hapusfile($pathd, $file_named, 'plc2_upb_file_bk_dmf',$iupb_id, 'iupb_id');
						foreach ($_FILES['fileuploadd']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_named = $_FILES['fileuploadd']["tmp_name"][$key];
								$named = $_FILES['fileuploadd']["name"][$key];
								$datad['filename'] = $named;
								$datad['id']=$iupb_id;
								$datad['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$datad['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_named, $pathd."/".$iupb_id."/".$named)) 
				 				{
									$sqld[] = "INSERT INTO plc2_upb_file_bk_dmf(iupb_id, filename, dInsertDate, vketerangan,cInsert, iconfirm_busdev) 
										VALUES ('".$datad['id']."', '".$datad['filename']."','".$datad['dInsertDate']."','".$file_keterangand[$d]."','".$datad['nip']."','0')";
									$d++;																			
								//print_r($sql1);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sqld as $qd) {
						try {
							$this->dbset->query($qd);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm2 as $xkeyd=>$xxd){
						$idnyad=$fileIdd[$xkeyd];
						$sqlcd="update plc2_upb_file_bk_dmf bk set bk.iconfirm_busdev='$xxd' where bk.id='$idnyad' ";
						$this->dbset->query($sqlcd);
					}
					
					//upload coars
					$c = $last_indexc;	
					if (isset($_FILES['fileuploadc'])) {
						
						$this->hapusfile($pathc, $file_namec, 'plc2_upb_file_bk_coars',$iupb_id, 'iupb_id');
						foreach ($_FILES['fileuploadc']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_namec = $_FILES['fileuploadc']["tmp_name"][$key];
								$namec = $_FILES['fileuploadc']["name"][$key];
								$datac['filename'] = $namec;
								$datac['id']=$iupb_id;
								$datac['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$datac['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_namec, $pathc."/".$iupb_id."/".$namec)) 
				 				{
									$sqlc[] = "INSERT INTO plc2_upb_file_bk_coars(iupb_id, filename, dInsertDate, vketerangan,cInsert,iconfirm_busdev) 
										VALUES ('".$datac['id']."', '".$datac['filename']."','".$datac['dInsertDate']."','".$file_keteranganc[$c]."','".$datac['nip']."','0')";
									$c++;																			
								//print_r($sql1);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sqlc as $qc) {
						try {
							$this->dbset->query($qc);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm3 as $xkeyc=>$xxc){
						$idnyac=$fileIdc[$xkeyc];
						$sqlc3="update plc2_upb_file_bk_coars bk set bk.iconfirm_busdev='$xxc' where bk.id='$idnyac' ";
						$this->dbset->query($sqlc3);
					}
					
					//upload ls
					$l = $last_indexl;	
					if (isset($_FILES['fileuploadl'])) {
						
						$this->hapusfile($pathl, $file_namel, 'plc2_upb_file_bk_lsa',$iupb_id,'iupb_id');
						foreach ($_FILES['fileuploadl']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_namel = $_FILES['fileuploadl']["tmp_name"][$key];
								$namel = $_FILES['fileuploadl']["name"][$key];
								$datal['filename'] = $namel;
								$datal['id']=$iupb_id;
								$datal['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$datal['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_namel, $pathl."/".$iupb_id."/".$namel)) 
				 				{
									$sqll[] = "INSERT INTO plc2_upb_file_bk_lsa(iupb_id, filename, dInsertDate, vketerangan,cInsert, iconfirm_busdev) 
										VALUES ('".$datal['id']."', '".$datal['filename']."','".$datal['dInsertDate']."','".$file_keteranganl[$c]."','".$datal['nip']."','0')";
									$l++;																			
								//print_r($sql1);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sqll as $ql) {
						try {
							$this->dbset->query($ql);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirml as $xkeyl=>$xxl){
						$idnyal=$fileIdl[$xkeyl];
						$sqlcl="update plc2_upb_file_bk_lsa bk set bk.iconfirm_busdev='$xxl' where bk.id='$idnyal' ";
						$this->dbset->query($sqlcl);
					}
					//upload ws
					$w = $last_indexw;	
					if (isset($_FILES['fileuploadw'])) {
						
						$this->hapusfile($pathw, $file_namew, 'plc2_upb_file_bk_ws',$iupb_id, 'iupb_id');
						foreach ($_FILES['fileuploadw']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_namew = $_FILES['fileuploadw']["tmp_name"][$key];
								$namew = $_FILES['fileuploadw']["name"][$key];
								$dataw['filename'] = $namew;
								$dataw['id']=$iupb_id;
								$dataw['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$dataw['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_namew, $pathw."/".$iupb_id."/".$namew)) 
				 				{
									$sqlw[] = "INSERT INTO plc2_upb_file_bk_ws(iupb_id, filename, dInsertDate, vketerangan,cInsert, iconfirm_busdev) 
										VALUES ('".$dataw['id']."', '".$dataw['filename']."','".$dataw['dInsertDate']."','".$file_keteranganw[$c]."','".$dataw['nip']."','0')";
									$w++;																			
								//print_r($sql1);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sqlw as $qw) {
						try {
							$this->dbset->query($qw);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirmw as $xkeyw=>$xxw){
						$idnyaw=$fileIdw[$xkeyw];
						$sqlcw="update plc2_upb_file_bk_ws bk set bk.iconfirm_busdev='$xxw' where bk.id='$idnyaw' ";
						$this->dbset->query($sqlcw);
					}
					
					//upload coabb
					$bb = $last_indexbb;	
					if (isset($_FILES['fileuploadbb'])) {
						
						$this->hapusfile($pathbb, $file_namebb, 'plc2_upb_file_bk_coabb',$iupb_id, 'iupb_id');
						foreach ($_FILES['fileuploadbb']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_namebb = $_FILES['fileuploadbb']["tmp_name"][$key];
								$namebb = $_FILES['fileuploadbb']["name"][$key];
								$databb['filename'] = $namebb;
								$databb['id']=$iupb_id;
								$databb['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$databb['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_namebb, $pathbb."/".$iupb_id."/".$namebb)) 
				 				{
									$sqlbb[] = "INSERT INTO plc2_upb_file_bk_coabb(iupb_id, filename, dInsertDate, vketerangan,cInsert, iconfirm_busdev) 
										VALUES ('".$databb['id']."', '".$databb['filename']."','".$databb['dInsertDate']."','".$file_keteranganbb[$c]."','".$databb['nip']."','0')";
									$w++;																			
								//print_r($sql1);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sqlbb as $qbb) {
						try {
							$this->dbset->query($qbb);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirmbb as $xkeybb=>$xxbb){
						$idnyabb=$fileIdbb[$xkeybb];
						$sqlcbb="update plc2_upb_file_bk_coabb bk set bk.iconfirm_busdev='$xxbb' where bk.id='$idnyabb' ";
						$this->dbset->query($sqlcbb);
					}
					
					//upload kajian uji BE
					$be = $last_indexbe;	
					if (isset($_FILES['fileuploadbe'])) {
						
						$this->hapusfile($pathbe, $file_namebe, 'plc2_upb_file_kube',$iupb_id, 'iupb_id');
						foreach ($_FILES['fileuploadbe']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_namebe = $_FILES['fileuploadbe']["tmp_name"][$key];
								$namebe = $_FILES['fileuploadbe']["name"][$key];
								$databe['filename'] = $namebe;
								$databe['id']=$iupb_id;
								$databe['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$databe['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_namebe, $pathbe."/".$iupb_id."/".$namebe)) 
				 				{
									$sqlbe[] = "INSERT INTO plc2_upb_file_kube(iupb_id, filename, dInsertDate, vketerangan,cInsert, iconfirm_busdev) 
										VALUES ('".$databe['id']."', '".$databe['filename']."','".$databe['dInsertDate']."','".$file_keteranganbe[$c]."','".$databe['nip']."','0')";
									$be++;																			
								//print_r($sql1);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sqlbe as $qbe) {
						try {
							$this->dbset->query($qbe);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirmbe as $xkeybe=>$xxbe){
						$idnyabe=$fileIdbe[$xkeybe];
						$sqlcbe="update plc2_upb_file_kube bk set bk.iconfirm_busdev='$xxbe' where bk.id='$idnyabe' ";
						$this->dbset->query($sqlcbe);
					}
					
					//upload lpp
					$i6 = $last_index6;	
					if (isset($_FILES['fileupload6'])) {
						$this->hapusfile($path6, $file_name6, 'plc2_upb_file_lpp',$ifor_id, 'ifor_id');
						foreach ($_FILES['fileupload6']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name6 = $_FILES['fileupload6']["tmp_name"][$key];
								$name6 = $_FILES['fileupload6']["name"][$key];
								$data6['filename'] = $name6;
								$data6['id']=$ifor_id;
								$data6['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data6['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name6, $path6."/".$ifor_id."/".$name6)) 
				 				{
									$sql6[] = "INSERT INTO plc2_upb_file_lpp(ifor_id, filename, dInsertDate, keterangan,cInsert, iconfirm_busdev) 
										VALUES ('".$data6['id']."', '".$data6['filename']."','".$data6['dInsertDate']."','".$file_keterangan6[$c]."','".$data6['nip']."','0')";
									$i6++;																			
								//print_r($sql6);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
					//upload 
					foreach($sql6 as $q6) {
						try {
							$this->dbset->query($q6);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm6 as $xkey6=>$xx6){
						$idnya6=$fileId6[$xkey6];
						$sqlc6="update plc2_upb_file_lpp bk set bk.iconfirm_busdev='$xx6' where bk.id='$idnya6' ";
						$this->dbset->query($sqlc6);
					}
					
					//file spek fg
					$i16 = $last_index16;	
					if (isset($_FILES['fileupload16'])) {
						$this->hapusfile($path16, $file_name16, 'plc2_upb_file_spesifikasi_fg',$ispek_id, 'ispekfg_id');
						foreach ($_FILES['fileupload16']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name16 = $_FILES['fileupload16']["tmp_name"][$key];
								$name16 = $_FILES['fileupload16']["name"][$key];
								$data16['filename'] = $name16;
								$data16['id']=$ispek_id;
								$data16['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data16['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name16, $path16."/".$ispek_id."/".$name16)) 
				 				{
									$sql16[] = "INSERT INTO plc2_upb_file_spesifikasi_fg(ispekfg_id, filename, dUpdateDate, vKeterangan, cInsert, iconfirm_busdev) 
										VALUES ('".$data16['id']."', '".$data16['filename']."','".$data16['dInsertDate']."','".$file_keterangan16[$c]."','".$data16['nip']."','0')";
									$i16++;																			
								//print_r($sql6);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
					//upload 
					foreach($sql16 as $q16) {
						try {
							$this->dbset->query($q16);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm16 as $xkey16=>$xx16){
						$idnya16=$fileId16[$xkey16];
						$sqlc16="update plc2_upb_file_spesifikasi_fg bk set bk.iconfirm_busdev='$xx16' where bk.id='$idnya16' ";
						$this->dbset->query($sqlc16);
					}
					
					//file soi fg
					$i17 = $last_index17;	
					if (isset($_FILES['fileupload17'])) {
						$this->hapusfile($path17, $file_name17, 'plc2_upb_file_soi_fg', $isoi_id, 'isoi_id');
						foreach ($_FILES['fileupload17']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name17 = $_FILES['fileupload17']["tmp_name"][$key];
								$name17 = $_FILES['fileupload17']["name"][$key];
								$data17['filename'] = $name17;
								$data17['id']=$isoi_id;
								$data17['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data17['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name17, $path17."/".$isoi_id."/".$name17)) 
				 				{
									$sql17[] = "INSERT INTO plc2_upb_file_soi_fg(isoi_id, filename, dUpdateDate, vKeterangan, cInsert, iconfirm_busdev) 
										VALUES ('".$data17['id']."', '".$data17['filename']."','".$data17['dInsertDate']."','".$file_keterangan17[$c]."','".$data17['nip']."','0')";
									$i17++;																			
								//print_r($sql6);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
					//upload 
					foreach($sql17 as $q17) {
						try {
							$this->dbset->query($q17);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm17 as $xkey17=>$xx17){
						$idnya17=$fileId17[$xkey17];
						$sqlc17="update plc2_upb_file_soi_fg bk set bk.iconfirm_busdev='$xx17' where bk.id='$idnya17' ";
						$this->dbset->query($sqlc17);
					}
					
					//file formula
					$i18 = $last_index18;
					//print_r($confirm18);
					if (isset($_FILES['fileupload18'])) {
						$this->hapusfile($path18, $file_name18, 'plc2_upb_file_skala_trial_filename', $ifor_id, 'ifor_id');
						foreach ($_FILES['fileupload18']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name18 = $_FILES['fileupload18']["tmp_name"][$key];
								$name18 = $_FILES['fileupload18']["name"][$key];
								$data18['filename'] = $name18;
								$data18['id']=$ifor_id;
								$data18['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data18['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name18, $path18."/".$ifor_id."/".$name18)) 
				 				{
									$sql18[] = "INSERT INTO plc2_upb_file_skala_trial_filename(ifor_id, filename, dUpdateDate, keterangan, cInsert, iconfirm_busdev) 
										VALUES ('".$data18['id']."', '".$data18['filename']."','".$data18['dInsertDate']."','".$file_keterangan18[$i18]."','".$data18['nip']."','0')";
									$i18++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
					//upload 
					foreach($sql18 as $q18) {
						try {
							$this->dbset->query($q18);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm18 as $xkey18=>$xx18){
						$idnya18=$fileId18[$xkey18];
						//echo $idnya18.' -> '.$xx18;
						$sqlc18="update plc2_upb_file_skala_trial_filename bk set bk.iconfirm_busdev='$xx18' where bk.id='$idnya18' ";
						$this->dbset->query($sqlc18);
					}
					
					//file proses produksi
					$i19 = $last_index19;
					//print_r($confirm18);
					if (isset($_FILES['fileupload19'])) {
						$this->hapusfile($path19, $file_name19, 'plc2_upb_file_proses_produksi', $ifor_id, 'ifor_id');
						foreach ($_FILES['fileupload19']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name19 = $_FILES['fileupload19']["tmp_name"][$key];
								$name19 = $_FILES['fileupload19']["name"][$key];
								$data19['filename'] = $name19;
								$data19['id']=$ifor_id;
								$data19['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data19['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name19, $path19."/".$ifor_id."/".$name19)) 
				 				{
									$sql19[] = "INSERT INTO plc2_upb_file_proses_produksi(ifor_id, filename, dUpdateDate, keterangan, cInsert, iconfirm_busdev) 
										VALUES ('".$data19['id']."', '".$data19['filename']."','".$data19['dInsertDate']."','".$file_keterangan19[$i19]."','".$data19['nip']."','0')";
									$i19++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
					//upload 
					foreach($sql19 as $q19) {
						try {
							$this->dbset->query($q19);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm19 as $xkey19=>$xx19){
						$idnya19=$fileId19[$xkey19];
						//echo $idnya18.' -> '.$xx18;
						$sqlc19="update plc2_upb_file_proses_produksi bk set bk.iconfirm_busdev='$xx19' where bk.id='$idnya19' ";
						$this->dbset->query($sqlc19);
					}
					
					//file form valpro
					$i15 = $last_index15;
					//print_r($confirm18);
					if (isset($_FILES['fileupload15'])) {
						$this->hapusfile($path15, $file_name15, 'plc2_upb_file_form_valpro', $ifor_id, 'ifor_id');
						foreach ($_FILES['fileupload15']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name15 = $_FILES['fileupload15']["tmp_name"][$key];
								$name15 = $_FILES['fileupload15']["name"][$key];
								$data15['filename'] = $name15;
								$data15['id']=$ifor_id;
								$data15['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data15['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name15, $path15."/".$ifor_id."/".$name15)) 
				 				{
									$sql15[] = "INSERT INTO plc2_upb_file_form_valpro(ifor_id, filename, dUpdateDate, keterangan, cInsert, iconfirm_busdev) 
										VALUES ('".$data15['id']."', '".$data15['filename']."','".$data15['dInsertDate']."','".$file_keterangan15[$i15]."','".$data15['nip']."','0')";
									$i15++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
					//upload 
					foreach($sql15 as $q15) {
						try {
							$this->dbset->query($q15);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm15 as $xkey15=>$xx15){
						$idnya15=$fileId15[$xkey15];
						$sqlc15="update plc2_upb_file_form_valpro bk set bk.iconfirm_busdev='$xx15' where bk.id='$idnya15' ";
						$this->dbset->query($sqlc15);
					}
					
					//file laporan udt
					$i14 = $last_index14;
					//print_r($confirm18);
					if (isset($_FILES['fileupload14'])) {
						$this->hapusfile($path14, $file_name14, 'plc2_upb_file_lapprot_udt', $ifor_id, 'ifor_id');
						foreach ($_FILES['fileupload14']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name14 = $_FILES['fileupload14']["tmp_name"][$key];
								$name14 = $_FILES['fileupload14']["name"][$key];
								$data14['filename'] = $name14;
								$data14['id']=$ifor_id;
								$data14['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data14['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name14, $path14."/".$ifor_id."/".$name14)) 
				 				{
									$sql14[] = "INSERT INTO plc2_upb_file_lapprot_udt(ifor_id, filename, dUpdateDate, keterangan, cInsert, iconfirm_busdev) 
										VALUES ('".$data14['id']."', '".$data14['filename']."','".$data14['dInsertDate']."','".$file_keterangan14[$i14]."','".$data14['nip']."','0')";
									$i14++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
					//upload 
					foreach($sql14 as $q14) {
						try {
							$this->dbset->query($q14);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm14 as $xkey14=>$xx14){
						$idnya14=$fileId14[$xkey14];
						$sqlc14="update plc2_upb_file_lapprot_udt bk set bk.iconfirm_busdev='$xx14' where bk.id='$idnya14' ";
						$this->dbset->query($sqlc14);
					}
					
					//file coa ex
					$i8 = $last_index8;
					//print_r($confirm18);
					if (isset($_FILES['fileupload8'])) {
						$this->hapusfile($path8, $file_name8, 'plc2_upb_file_coa_ex', $ifor_id, 'ifor_id');
						foreach ($_FILES['fileupload8']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name8 = $_FILES['fileupload8']["tmp_name"][$key];
								$name8 = $_FILES['fileupload8']["name"][$key];
								$data8['filename'] = $name8;
								$data8['id']=$ifor_id;
								$data8['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data8['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name8, $path8."/".$ifor_id."/".$name8)) 
				 				{
									$sql8[] = "INSERT INTO plc2_upb_file_coa_ex(ifor_id, filename, dUpdateDate, keterangan, cInsert, iconfirm_busdev) 
										VALUES ('".$data8['id']."', '".$data8['filename']."','".$data8['dInsertDate']."','".$file_keterangan8[$i8]."','".$data8['nip']."','0')";
									$i8++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
					//upload 
					foreach($sql8 as $q8) {
						try {
							$this->dbset->query($q8);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm8 as $xkey8=>$xx8){
						$idnya8=$fileId8[$xkey8];
						$sqlc8="update plc2_upb_file_coa_ex bk set bk.iconfirm_busdev='$xx8' where bk.id='$idnya8' ";
						$this->dbset->query($sqlc8);
					}
					
					//file lsa ex
					$i9 = $last_index9;
					//print_r($confirm18);
					if (isset($_FILES['fileupload9'])) {
						$this->hapusfile($path9, $file_name9, 'plc2_upb_file_lsa_ex', $ifor_id, 'ifor_id');
						foreach ($_FILES['fileupload9']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name9 = $_FILES['fileupload9']["tmp_name"][$key];
								$name9 = $_FILES['fileupload9']["name"][$key];
								$data9['filename'] = $name9;
								$data9['id']=$ifor_id;
								$data9['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data9['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name9, $path9."/".$ifor_id."/".$name9)) 
				 				{
									$sql9[] = "INSERT INTO plc2_upb_file_lsa_ex(ifor_id, filename, dUpdateDate, keterangan, cInsert, iconfirm_busdev) 
										VALUES ('".$data9['id']."', '".$data9['filename']."','".$data9['dInsertDate']."','".$file_keterangan9[$i9]."','".$data9['nip']."','0')";
									$i9++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
					//upload 
					foreach($sql9 as $q9) {
						try {
							$this->dbset->query($q9);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm9 as $xkey9=>$xx9){
						$idnya9=$fileId9[$xkey9];
						$sqlc9="update plc2_upb_file_lsa_ex bk set bk.iconfirm_busdev='$xx9' where bk.id='$idnya9' ";
						$this->dbset->query($sqlc9);
					}
					
					//file soi ex
					$i10 = $last_index10;
					//print_r($confirm18);
					if (isset($_FILES['fileupload10'])) {
						$this->hapusfile($path10, $file_name10, 'plc2_upb_file_soi_ex', $ifor_id, 'ifor_id');
						foreach ($_FILES['fileupload10']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name10 = $_FILES['fileupload10']["tmp_name"][$key];
								$name10 = $_FILES['fileupload10']["name"][$key];
								$data10['filename'] = $name10;
								$data10['id']=$ifor_id;
								$data10['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data10['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name10, $path10."/".$ifor_id."/".$name10)) 
				 				{
									$sql10[] = "INSERT INTO plc2_upb_file_soi_ex(ifor_id, filename, dUpdateDate, keterangan, cInsert, iconfirm_busdev) 
										VALUES ('".$data10['id']."', '".$data10['filename']."','".$data10['dInsertDate']."','".$file_keterangan10[$i10]."','".$data10['nip']."','0')";
									$i10++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
					//upload 
					foreach($sql10 as $q10) {
						try {
							$this->dbset->query($q10);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm10 as $xkey10=>$xx10){
						$idnya10=$fileId10[$xkey10];
						$sqlc10="update plc2_upb_file_soi_ex bk set bk.iconfirm_busdev='$xx10' where bk.id='$idnya10' ";
						$this->dbset->query($sqlc10);
					}
					
					//file laporan originator
					$i12 = $last_index12;
					//print_r($confirm18);
					if (isset($_FILES['fileupload12'])) {
						$this->hapusfile($path12, $file_name12, 'plc2_upb_file_lap_ori', $ifor_id, 'ifor_id');
						foreach ($_FILES['fileupload12']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name12 = $_FILES['fileupload12']["tmp_name"][$key];
								$name12 = $_FILES['fileupload12']["name"][$key];
								$data12['filename'] = $name12;
								$data12['id']=$ifor_id;
								$data12['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data12['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name12, $path12."/".$ifor_id."/".$name12)) 
				 				{
									$sql12[] = "INSERT INTO plc2_upb_file_lap_ori(ifor_id, filename, dUpdateDate, keterangan, cInsert, iconfirm_busdev) 
										VALUES ('".$data12['id']."', '".$data12['filename']."','".$data12['dInsertDate']."','".$file_keterangan12[$i12]."','".$data12['nip']."','0')";
									$i12++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
					//upload 
					foreach($sql12 as $q12) {
						try {
							$this->dbset->query($q12);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm12 as $xkey12=>$xx12){
						$idnya12=$fileId12[$xkey12];
						$sqlc12="update plc2_upb_file_lap_ori bk set bk.iconfirm_busdev='$xx12' where bk.id='$idnya12' ";
						$this->dbset->query($sqlc12);
					}
					
					//file laporan protokol validasi proses
					$i7 = $last_index7;
					//print_r($confirm18);
					if (isset($_FILES['fileupload7'])) {
						$this->hapusfile($path7, $file_name7, 'plc2_upb_file_lapprot_valpro', $ifor_id, 'ifor_id');
						foreach ($_FILES['fileupload7']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name7 = $_FILES['fileupload7']["tmp_name"][$key];
								$name7 = $_FILES['fileupload7']["name"][$key];
								$data7['filename'] = $name7;
								$data7['id']=$ifor_id;
								$data7['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data7['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name7, $path7."/".$ifor_id."/".$name7)) 
				 				{
									$sql7[] = "INSERT INTO plc2_upb_file_lapprot_valpro(ifor_id, filename, dUpdateDate, keterangan, cInsert, iconfirm_busdev) 
										VALUES ('".$data7['id']."', '".$data7['filename']."','".$data7['dInsertDate']."','".$file_keterangan7[$i7]."','".$data7['nip']."','0')";
									$i7++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
					//upload 
					foreach($sql7 as $q7) {
						try {
							$this->dbset->query($q7);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm7 as $xkey7=>$xx7){
						$idnya7=$fileId7[$xkey7];
						$sqlc7="update plc2_upb_file_lapprot_valpro bk set bk.iconfirm_busdev='$xx7' where bk.id='$idnya7' ";
						$this->dbset->query($sqlc7);
					}
					
					//file coafg
					$i11 = $last_index11;
					//print_r($confirm18);
					if (isset($_FILES['fileupload11'])) {
						$this->hapusfile($path11, $file_name11, 'plc2_upb_file_coa_fg', $ifor_id, 'ifor_id');
						foreach ($_FILES['fileupload11']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name11 = $_FILES['fileupload11']["tmp_name"][$key];
								$name11 = $_FILES['fileupload11']["name"][$key];
								$data11['filename'] = $name11;
								$data11['id']=$ifor_id;
								$data11['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data11['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name11, $path11."/".$ifor_id."/".$name11)) 
				 				{
									$sql11[] = "INSERT INTO plc2_upb_file_coa_fg(ifor_id, filename, dUpdateDate, keterangan, cInsert, iconfirm_busdev) 
										VALUES ('".$data11['id']."', '".$data11['filename']."','".$data11['dInsertDate']."','".$file_keterangan11[$i11]."','".$data11['nip']."','0')";
									$i11++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
					//upload 
					foreach($sql11 as $q11) {
						try {
							$this->dbset->query($q11);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm11 as $xkey11=>$xx11){
						$idnya11=$fileId11[$xkey11];
						$sqlc11="update plc2_upb_file_coa_fg bk set bk.iconfirm_busdev='$xx11' where bk.id='$idnya11' ";
						$this->dbset->query($sqlc11);
					}
					//file laporan validasi MoA
					$i13 = $last_index13;
					//print_r($confirm18);
					if (isset($_FILES['fileupload13'])) {
						$this->hapusfile($path13, $file_name13, 'plc2_upb_file_valmoa', $ifor_id, 'ifor_id');
						foreach ($_FILES['fileupload13']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name13 = $_FILES['fileupload13']["tmp_name"][$key];
								$name13 = $_FILES['fileupload13']["name"][$key];
								$data13['filename'] = $name13;
								$data13['id']=$ifor_id;
								$data13['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$data13['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_name13, $path13."/".$ifor_id."/".$name13)) 
				 				{
									$sql13[] = "INSERT INTO plc2_upb_file_valmoa(ifor_id, filename, dUpdateDate, keterangan, cInsert, iconfirm_busdev) 
										VALUES ('".$data13['id']."', '".$data13['filename']."','".$data13['dInsertDate']."','".$file_keterangan13[$i13]."','".$data13['nip']."','0')";
									$i13++;																			
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
					//upload 
					foreach($sql13 as $q13) {
						try {
							$this->dbset->query($q13);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirm13 as $xkey13=>$xx13){
						$idnya13=$fileId13[$xkey13];
						$sqlc13="update plc2_upb_file_valmoa bk set bk.iconfirm_busdev='$xx13' where bk.id='$idnya13' ";
						$this->dbset->query($sqlc13);
					}
					
					//upload accelerated
					$sa = $last_indexsa;	
					if (isset($_FILES['fileuploadsa'])) {
						$this->hapusfile($pathsa, $file_namesa, 'plc2_upb_file_protaccel',$ifor_id, 'ifor_id');
						foreach ($_FILES['fileuploadsa']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_namesa = $_FILES['fileuploadsa']["tmp_name"][$key];
								$namesa = $_FILES['fileuploadsa']["name"][$key];
								$datasa['filename'] = $namesa;
								$datasa['id']=$ifor_id;
								$datasa['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$datasa['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_namesa, $pathsa."/".$ifor_id."/".$namesa)) 
				 				{
									$sqlsa[] = "INSERT INTO plc2_upb_file_protaccel(ifor_id, filename, dInsertDate, keterangan,cInsert,iconfirm_busdev) 
										VALUES ('".$datasa['id']."', '".$datasa['filename']."','".$datasa['dInsertDate']."','".$file_keterangansa[$a]."','".$datasa['nip']."','0')";
									$sa++;																			
								//print_r($sql1);
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sqlsa as $qsa) {
						try {
							$this->dbset->query($qsa);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirmsa as $xkeysa=>$xxsa){
						$idnyasa=$fileIdsa[$xkeysa];
						$sqlcsa="update plc2_upb_file_protaccel bk set bk.iconfirm_busdev='$xxsa' where bk.id='$idnyasa' ";
						$this->dbset->query($sqlcsa);
					}
					
					//upload protokol realtime
					$sr = $last_indexsr;	
					if (isset($_FILES['fileuploadsr'])) {
						
						$this->hapusfile($pathsr, $file_namesr, 'plc2_upb_file_protreal',$ifor_id,'ifor_id');
						foreach ($_FILES['fileuploadsr']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_namesr = $_FILES['fileuploadsr']["tmp_name"][$key];
								$namesr = $_FILES['fileuploadsr']["name"][$key];
								$datasr['filename'] = $namesr;
								$datasr['id']=$ifor_id;
								$datasr['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$datasr['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_namesr, $pathsr."/".$ifor_id."/".$namesr)) 
				 				{
									$sqlsr[] = "INSERT INTO plc2_upb_file_protreal(ifor_id, filename, dInsertDate, keterangan,cInsert,iconfirm_busdev) 
										VALUES ('".$datasr['id']."', '".$datasr['filename']."','".$datasr['dInsertDate']."','".$file_keterangansr[$sr]."','".$datasr['nip']."','0')";
									$sr++;																			
								//print_r($sqlsr);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sqlsr as $qsr) {
						try {
							$this->dbset->query($qsr);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirmsr as $xkeysr=>$xxsr){
						$idnyasr=$fileIdsr[$xkeysr];
						$sqlcsr="update plc2_upb_file_protreal bk set bk.iconfirm_busdev='$xxsr' where bk.id='$idnyasr' ";
						$this->dbset->query($sqlcsr);
					}
					
					//upload dokumen stabilita pilot
					$sd = $last_indexsd;	
					if (isset($_FILES['fileuploadsd'])) {
						
						$this->hapusfile($pathsd, $file_namesd, 'plc2_upb_file_stabpilot',$ifor_id,'ifor_id');
						foreach ($_FILES['fileuploadsd']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_namesd = $_FILES['fileuploadsd']["tmp_name"][$key];
								$namesd = $_FILES['fileuploadsd']["name"][$key];
								$datasd['filename'] = $namesd;
								$datasd['id']=$ifor_id;
								$datasd['nip']=$this->user->gNIP;
								//$data['iupb_id'] = $insertId;
								$datasd['dInsertDate'] = date('Y-m-d H:i:s');
				 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
				 				if(move_uploaded_file($tmp_namesd, $pathsd."/".$ifor_id."/".$namesd)) 
				 				{
									$sqlsd[] = "INSERT INTO plc2_upb_file_stabpilot(ifor_id, filename, dInsertDate, keterangan,cInsert,iconfirm_busdev) 
										VALUES ('".$datasd['id']."', '".$datasd['filename']."','".$datasd['dInsertDate']."','".$file_keterangansd[$sd]."','".$datasd['nip']."','0')";
									$sd++;																			
								//print_r($sqlsd);
								}
								else{
								echo "Upload ke folder gagal";	
								}
							}
						}
					}
										
					foreach($sqlsd as $qsd) {
						try {
							$this->dbset->query($qsd);
						}catch(Exception $e) {
							die($e);
						}
					}
					foreach($confirmsd as $xkeysd=>$xxsd){
						$idnyasd=$fileIdsd[$xkeysd];
						$sqlcsd="update plc2_upb_file_stabpilot bk set bk.iconfirm_busdev='$xxsd' where bk.id='$idnyasd' ";
						$this->dbset->query($sqlcsd);
					}
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->post('cek_dokumen_iupb_id');					
					echo json_encode($r);
					exit();
				} else {
					foreach($confirmbe as $xkeybe=>$xxbe){
						$idnyabe=$fileIdbe[$xkeybe];
						$sqlcbe="update plc2_upb_file_kube bk set bk.iconfirm_busdev='$xxbe' where bk.id='$idnyabe' ";
						$this->dbset->query($sqlcbe);
					}
					foreach($confirmsd as $xkeysd=>$xxsd){
						$idnyasd=$fileIdsd[$xkeysd];
						$sqlcsd="update plc2_upb_file_stabpilot bk set bk.iconfirm_busdev='$xxsd' where bk.id='$idnyasd' ";
						$this->dbset->query($sqlcsd);
					}
					foreach($confirmsa as $xkeysa=>$xxsa){
						$idnyasa=$fileIdsa[$xkeysa];
						$sqlcsa="update plc2_upb_file_protaccel bk set bk.iconfirm_busdev='$xxsa' where bk.id='$idnyasa' ";
						$this->dbset->query($sqlcsa);
					}
					foreach($confirmsr as $xkeysr=>$xxsr){
						$idnyasr=$fileIdsr[$xkeysr];
						$sqlcsr="update plc2_upb_file_protreal bk set bk.iconfirm_busdev='$xxsr' where bk.id='$idnyasr' ";
						$this->dbset->query($sqlcsr);
					}
					foreach($confirm13 as $xkey13=>$xx13){
						$idnya13=$fileId13[$xkey13];
						$sqlc13="update plc2_upb_file_valmoa bk set bk.iconfirm_busdev='$xx13' where bk.id='$idnya13' ";
						$this->dbset->query($sqlc13);
					}
					foreach($confirm11 as $xkey11=>$xx11){
						$idnya11=$fileId11[$xkey11];
						$sqlc11="update plc2_upb_file_coa_fg bk set bk.iconfirm_busdev='$xx11' where bk.id='$idnya11' ";
						$this->dbset->query($sqlc11);
					}
					foreach($confirm7 as $xkey7=>$xx7){
						$idnya7=$fileId7[$xkey7];
						$sqlc7="update plc2_upb_file_lapprot_valpro bk set bk.iconfirm_busdev='$xx7' where bk.id='$idnya7' ";
						$this->dbset->query($sqlc7);
					}
					foreach($confirm12 as $xkey12=>$xx12){
						$idnya12=$fileId12[$xkey12];
						$sqlc12="update plc2_upb_file_lap_ori bk set bk.iconfirm_busdev='$xx12' where bk.id='$idnya12' ";
						$this->dbset->query($sqlc12);
					}
					foreach($confirm14 as $xkey14=>$xx14){
						$idnya14=$fileId14[$xkey14];
						$sqlc14="update plc2_upb_file_lapprot_udt bk set bk.iconfirm_busdev='$xx14' where bk.id='$idnya14' ";
						$this->dbset->query($sqlc14);
					}
					foreach($confirm8 as $xkey8=>$xx8){
						$idnya8=$fileId8[$xkey8];
						$sqlc8="update plc2_upb_file_coa_ex bk set bk.iconfirm_busdev='$xx8' where bk.id='$idnya8' ";
						$this->dbset->query($sqlc8);
					}
					foreach($confirm9 as $xkey9=>$xx9){
						$idnya9=$fileId9[$xkey9];
						$sqlc9="update plc2_upb_file_lsa_ex bk set bk.iconfirm_busdev='$xx9' where bk.id='$idnya9' ";
						$this->dbset->query($sqlc9);
					}
					foreach($confirm10 as $xkey10=>$xx10){
						$idnya10=$fileId10[$xkey10];
						$sqlc10="update plc2_upb_file_soi_ex bk set bk.iconfirm_busdev='$xx10' where bk.id='$idnya10' ";
						//echo $sqlc10;
						$this->dbset->query($sqlc10);
					}
					//update confirm file 1
					foreach($confirm1 as $xkey=>$xx){
						$idnya=$fileId1[$xkey];
						$sqlc1="update plc2_upb_file_bahan_kemas bk set bk.iconfirm_busdev='$xx' where bk.id='$idnya' ";
						$this->dbset->query($sqlc1);
					}
					foreach($confirm3 as $xkeyc=>$xxc){
						$idnyac=$fileIdc[$xkeyc];
						$sqlc3="update plc2_upb_file_bk_coars bk set bk.iconfirm_busdev='$xxc' where bk.id='$idnyac' ";
						$this->dbset->query($sqlc3);
					}
					foreach($confirm2 as $xkeyd=>$xxd){
						$idnyad=$fileIdd[$xkeyd];
						$sqlcd="update plc2_upb_file_bk_dmf bk set bk.iconfirm_busdev='$xxd' where bk.id='$idnyad'";
						$this->dbset->query($sqlcd);
					}
					foreach($confirmw as $xkeyw=>$xxw){
						$idnyaw=$fileIdw[$xkeyw];
						$sqlw="update plc2_upb_file_bk_ws bk set bk.iconfirm_busdev='$xxw' where bk.id='$idnyaw' ";
						$this->dbset->query($sqlw);
					}
					foreach($confirmbb as $xkeybb=>$xxbb){
						$idnyabb=$fileIdbb[$xkeybb];
						$sqlbb="update plc2_upb_file_bk_coabb bk set bk.iconfirm_busdev='$xxbb' where bk.id='$idnyabb' ";
						$this->dbset->query($sqlbb);
					}
					foreach($confirml as $xkeyl=>$xxl){
						$idnyal=$fileIdl[$xkeyl];
						$sqlcl="update plc2_upb_file_bk_lsa bk set bk.iconfirm_busdev='$xxl' where bk.id='$idnyal' ";
						$this->dbset->query($sqlcl);
					}
					foreach($confirm6 as $xkey6=>$xx6){
						$idnya6=$fileId6[$xkey6];
						$sqlc6="update plc2_upb_file_lpp bk set bk.iconfirm_busdev='$xx6' where bk.id='$idnya6' ";
						$this->dbset->query($sqlc6);
					}
					foreach($confirm16 as $xkey16=>$xx16){
						$idnya16=$fileId16[$xkey16];
						$sqlc16="update plc2_upb_file_spesifikasi_fg bk set bk.iconfirm_busdev='$xx16' where bk.id='$idnya16' ";
						$this->dbset->query($sqlc16);
					}
					foreach($confirm17 as $xkey17=>$xx17){
						$idnya17=$fileId17[$xkey17];
						$sqlc17="update plc2_upb_file_soi_fg bk set bk.iconfirm_busdev='$xx17' where bk.id='$idnya17' ";
						$this->dbset->query($sqlc17);
					}
					foreach($confirm18 as $xkey18=>$xx18){
						$idnya18=$fileId18[$xkey18];
						$sqlc18="update plc2_upb_file_skala_trial_filename bk set bk.iconfirm_busdev='$xx18' where bk.id='$idnya18' ";
						$this->dbset->query($sqlc18);
					}
					foreach($confirm19 as $xkey19=>$xx19){
						$idnya19=$fileId19[$xkey19];
						$sqlc19="update plc2_upb_file_proses_produksi bk set bk.iconfirm_busdev='$xx19' where bk.id='$idnya19' ";
						$this->dbset->query($sqlc19);
					}
					foreach($confirm15 as $xkey15=>$xx15){
						$idnya15=$fileId15[$xkey15];
						$sqlc15="update plc2_upb_file_form_valpro bk set bk.iconfirm_busdev='$xx15' where bk.id='$idnya15' ";
						$this->dbset->query($sqlc15);
					}
					if (is_array($file_name1)) {									
						$this->hapusfile($path, $file_name1, 'plc2_upb_file_bahan_kemas',$ibk_id,'ibk_id');
					}
					if (is_array($file_named)) {									
						$this->hapusfile($pathd, $file_named, 'plc2_upb_file_bk_dmf',$iupb_id,'iupb_id');
					}
					if (is_array($file_namec)) {									
						$this->hapusfile($pathc, $file_namec, 'plc2_upb_file_bk_coars',$iupb_id,'iupb_id');
					}
					if (is_array($file_namel)) {									
						$this->hapusfile($pathl, $file_namel, 'plc2_upb_file_bk_lsa',$iupb_id,'iupb_id');
					}
					if (is_array($file_namew)) {									
						$this->hapusfile($pathw, $file_namew, 'plc2_upb_file_bk_ws',$iupb_id,'iupb_id');
					}
					if (is_array($file_namebb)) {									
						$this->hapusfile($pathbb, $file_namebb, 'plc2_upb_file_bk_coabb',$iupb_id,'iupb_id');
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
			case 'downloadn':
				$this->downloadn($this->input->get('file'));
			break;
			case 'dokDone':
				echo $this->dokDone_view();
			break;
			case 'dokDone_process':
				echo $this->dokDone_process();
			break;
			case 'approve':
				echo $this->approve_view();
				break;
			case 'approve_process':
				echo $this->approve_process();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }
	function listBox_cek_dokumen_iconfirm_dok($value) {
    	if($value==0){$vstatus='Waiting for confirmation';}
    	elseif($value==1){$vstatus='Confirmed';}
    	return $vstatus;
    }
	//Keterangan approval 
	function updateBox_cek_dokumen_vnip_confirm_dok($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($rowData['iconfirm_dok'] ==1)){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_confirm_dok']))->row_array();
			$ret= 'Confirmed by '.$row['vName'].' ( '.$rowData['vnip_confirm_dok'].' )'.' on '.$rowData['tconfirm_dok'];
		}
		else{
			$ret='Waiting for confirmation';
		}
		
		return $ret;
	}
	//
	function updateBox_cek_dokumen_iupb_id($field, $id, $value) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$value))->row_array();
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" value="'.$value.'" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" value="'.$row['vupb_nomor'].'" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="7" />';
		//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/cekdok?field=cek_dokumen\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	//FUNGSI DOWNLOAD UNTUK dokumen baru (proses produksi)
	function downloadn($filename) {
		$this->load->helper('download');		
		$name = $filename;
		$id = $_GET['id'];
		$tempat = $_GET['path'];
		$path = file_get_contents('./files/plc/'.$tempat.'/'.$id.'/'.$name);	
		force_download($name, $path);
	}
	//
	function dokDone_view() {
		$iupb_id=$this->input->get('upb_id');
		$jenis_dok=$this->input->get('dok');
		
		//jenis dokumen
		if($jenis_dok=='dmf'){$tampil="Dokumen DMF";}
		elseif($jenis_dok=='coabb'){$tampil="Dokumen COA Bahan Baku";}
		elseif($jenis_dok=='coars'){$tampil="Dokumen COA RS";}
		elseif($jenis_dok=='coaws'){$tampil="Dokumen COA WS";}
		elseif($jenis_dok=='ls'){$tampil="Dokumen LSA Zat Aktif";}
		elseif($jenis_dok=='spekfg'){$tampil="Dokumen Spesifikasi FG";}
		elseif($jenis_dok=='formu'){$tampil="Dokumen Formula";}
		elseif($jenis_dok=='prosprod'){$tampil="Dokumen Proses Produksi";}
		elseif($jenis_dok=='lpp'){$tampil="Dokumen Laporan Pengembangan Produk";}
		elseif($jenis_dok=='fvalpro'){$tampil="Dokumen Form Validasi Proses";}
		elseif($jenis_dok=='lvalpro'){$tampil="Dokumen Laporan dan Protokol Validasi Proses";}
		elseif($jenis_dok=='coaex'){$tampil="Dokumen COA Excipient";}
		elseif($jenis_dok=='lsaex'){$tampil="Dokumen LSA Excipient";}
		elseif($jenis_dok=='soiex'){$tampil="Dokumen SOI Excipient";}
		elseif($jenis_dok=='coafg'){$tampil="Dokumen COA FG";}
		elseif($jenis_dok=='soifg'){$tampil="Dokumen SOI FG";}
		elseif($jenis_dok=='valmoa'){$tampil="Dokumen Validasi MOA";}
		elseif($jenis_dok=='lapori'){$tampil="Dokumen Laporan Originator";}
		elseif($jenis_dok=='udt'){$tampil="Dokumen Laporan & Protokol UDT";}
		elseif($jenis_dok=='bk'){$tampil="Dokumen Bahan Kemas";}
		elseif($jenis_dok=='accel'){$tampil="Dokumen Protocol Stabilita Accelerated";}
		elseif($jenis_dok=='real'){$tampil="Dokumen Protocol Stabilita RealTime";}
		elseif($jenis_dok=='stab'){$tampil="Dokumen Stabilita (Tambahan) ";}
		elseif($jenis_dok=='kube'){$tampil="Dokumen Kajian Uji BE ";}
		
		$qupb="select u.vupb_nomor, u.vupb_nama, u.cnip
					from plc2.plc2_upb u where u.iupb_id=$iupb_id";
		$rupb = $this->db_plc0->query($qupb)->row_array();
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
						return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var header = "Info";
								var info = "Info";
								var url = "'.base_url().'processor/plc/cek/dokumen";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_cek_dokumen").html(data);
									});
									
								}
									_custom_alert("Data Berhasil Disimpan ! ",header,info,"grid_cek_dokumen", 1, 20000);
									reload_grid("grid_cek_dokumen");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Done '.$tampil.'</h1><br />';
		$echo .= '<form id="form_cek_dokumen_dokDone" action="'.base_url().'processor/plc/cek/dokumen?action=dokDone_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= '<input type="hidden" name="iupb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<input type="hidden" name="idnya" value="'.$this->input->get('id').'" />
				<input type="hidden" name="jenis_dok" value="'.$jenis_dok.'" />
				<table class="hover_table" cellspacing="0" cellpadding="1" style="width: 45%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
					<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>Nomor UPB</b></td>
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nomor'].'</td>
					</tr>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7;"><b>Nama Usulan</b></td>
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['vupb_nama'].'</td>
					</tr><tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: center; background: #b4cef7; "><b>NIP Pengusul</b></td>
						<td style="font-size:120%; border: 1px solid #dddddd; width: 3%; text-align: left;">&nbsp;'.$rupb['cnip'].'</td>
					</tr>
				</table>
				</br>
		<button type="button" onclick="submit_ajax(\'form_cek_dokumen_dokDone\')">Simpan</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function dokDone_process() {
		$team=$this->auth->my_teams(TRUE);
		$post = $this->input->post();
		$jenis_dok=$post['jenis_dok'];
		$iupb_id =$post['iupb_id'];
		$user = $this->auth->user();
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		
		$qupb="select *	from plc2.plc2_upb u where u.iupb_id=$iupb_id";
		$rupb = $this->db_plc0->query($qupb)->row_array();
		
		//jenis dokumen
		if($jenis_dok=='dmf'){$tabelnya="plc2_upb_file_bk_dmf"; $pknya='iupb_id';}
		elseif($jenis_dok=='coabb'){$tabelnya="plc2_upb_file_bk_coabb"; $pknya='iupb_id';}
		elseif($jenis_dok=='coars'){$tabelnya="plc2_upb_file_bk_coars"; $pknya='iupb_id';}
		elseif($jenis_dok=='coaws'){$tabelnya="plc2_upb_file_bk_ws"; $pknya='iupb_id';}
		elseif($jenis_dok=='ls'){$tabelnya="plc2_upb_file_bk_lsa"; $pknya='iupb_id';}
		elseif($jenis_dok=='spekfg'){$tabelnya="plc2_upb_file_spesifikasi_fg"; $pknya='ispekfg_id';}
		elseif($jenis_dok=='formu'){$tabelnya="plc2_upb_file_skala_trial_filename"; $pknya='ifor_id';}
		elseif($jenis_dok=='prosprod'){$tabelnya="plc2_upb_file_proses_produksi"; $pknya='ifor_id';}
		elseif($jenis_dok=='lpp'){$tabelnya="plc2_upb_file_lpp"; $pknya='ifor_id';}
		elseif($jenis_dok=='fvalpro'){$tabelnya="plc2_upb_file_form_valpro"; $pknya='ifor_id';}
		elseif($jenis_dok=='lvalpro'){$tabelnya="plc2_upb_file_lapprot_valpro"; $pknya='ifor_id';}
		elseif($jenis_dok=='coaex'){$tabelnya="plc2_upb_file_coa_ex"; $pknya='ifor_id';}
		elseif($jenis_dok=='lsaex'){$tabelnya="plc2_upb_file_lsa_ex"; $pknya='ifor_id';}
		elseif($jenis_dok=='soiex'){$tabelnya="plc2_upb_file_soi_ex"; $pknya='ifor_id';}
		elseif($jenis_dok=='coafg'){$tabelnya="plc2_upb_file_coa_fg"; $pknya='ifor_id';}
		elseif($jenis_dok=='soifg'){$tabelnya="plc2_upb_file_soi_fg"; $pknya='isoi_id';}
		elseif($jenis_dok=='valmoa'){$tabelnya="plc2_upb_file_valmoa"; $pknya='ifor_id';}
		elseif($jenis_dok=='lapori'){$tabelnya="plc2_upb_file_lap_ori"; $pknya='ifor_id';}
		elseif($jenis_dok=='udt'){$tabelnya="plc2_upb_file_lapprot_udt"; $pknya='ifor_id';}
		elseif($jenis_dok=='bk'){$tabelnya="plc2_upb_file_bahan_kemas"; $pknya='ibk_id';}
		elseif($jenis_dok=='accel'){$tabelnya="plc2_upb_file_protaccel"; $pknya='ifor_id';}
		elseif($jenis_dok=='real'){$tabelnya="plc2_upb_file_protreal"; $pknya='ifor_id';}
		elseif($jenis_dok=='stab'){$tabelnya="plc2_upb_file_stabpilot"; $pknya='ifor_id';}
		elseif($jenis_dok=='kube'){$tabelnya="plc2_upb_file_kube"; $pknya='iupb_id';}
		
		$filenya=$this->db_plc0->get_where('plc2.'.$tabelnya, array($pknya=>$post['idnya']))->result_array();
		foreach($filenya as $k=>$v){
			$this->db_plc0->where($pknya,$post['idnya']);
			$this->db_plc0->update('plc2.'.$tabelnya,array('iDone'=>1,'dDoneDate'=>$skg,'cDone'=>$nip));
		}
		
		$data['status']  = true;
		$data['last_id'] = $post['iupb_id'];
		return json_encode($data);
	}
	function updateBox_cek_dokumen_file_bahankemas($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE);
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ibk_id
		$sql_bk="select bk.* from plc2.plc2_upb_bahan_kemas bk where bk.iappqa=2 and bk.iupb_id='$iupb_id'
				order by bk.ibk_id desc limit 1";
		$q_bk=$this->db_plc0->query($sql_bk)->row_array();
		$ibk_id=$q_bk['ibk_id'];
		$sql = "select mbk.ijenis_bk_id,mbk.vjenis_bk,
				(case
					when mbk.itipe_bk=1 then 'Primer'
					when mbk.itipe_bk=2 then 'Sekunder'
					else 'Tersier'
				end) as itipe_bk from plc2.plc2_master_jenis_bk mbk where mbk.ldeleted=0 
				";
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_bahan_kemas u where u.ibk_id=$ibk_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_bahan_kemas u where u.ibk_id=$ibk_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;} //jika tidak ada filenya
		$data['jenis_bk'] = $this->db_plc0->query($sql)->result_array();
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_bahan_kemas', array('ibk_id'=>$ibk_id))->result_array();
		$data['team']=$this->auth->my_teams(true);
		$data['teamupb']=$rowData['iteampd_id'];
		return $this->load->view('cek_dokumen_file_bahankemas',$data,TRUE);
	}
	function updateBox_cek_dokumen_dmf($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_bk_dmf u where u.iupb_id=$iupb_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_bk_dmf u where u.iupb_id=$iupb_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;} //jika tidak ada filenya
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_bk_dmf', array('iupb_id'=>$iupb_id))->result_array();
		return $this->load->view('cek_dokumen_file_dmf',$data,TRUE); 			
	}
	function updateBox_cek_dokumen_coars($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_bk_coars u where u.iupb_id=$iupb_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_bk_coars u where u.iupb_id=$iupb_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_bk_coars', array('iupb_id'=>$iupb_id))->result_array();
		return $this->load->view('cek_dokumen_file_coars',$data,TRUE);			
	}
	function updateBox_cek_dokumen_lsa($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_bk_lsa u where u.iupb_id=$iupb_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_bk_lsa u where u.iupb_id=$iupb_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_bk_lsa', array('iupb_id'=>$iupb_id))->result_array();
		return $this->load->view('cek_dokumen_file_ls',$data,TRUE);			
	}
	function updateBox_cek_dokumen_ws($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_bk_ws u where u.iupb_id=$iupb_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_bk_ws u where u.iupb_id=$iupb_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_bk_ws', array('iupb_id'=>$iupb_id))->result_array();
		return $this->load->view('cek_dokumen_file_ws',$data,TRUE);			
	}
	function updateBox_cek_dokumen_coabb($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_bk_coabb u where u.iupb_id=$iupb_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_bk_coabb u where u.iupb_id=$iupb_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_bk_coabb', array('iupb_id'=>$iupb_id))->result_array();
		return $this->load->view('cek_dokumen_file_coabb',$data,TRUE);			
	}
	function updateBox_cek_dokumen_kube($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_kube u where u.iupb_id=$iupb_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_kube u where u.iupb_id=$iupb_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_kube', array('iupb_id'=>$iupb_id))->result_array();
		$data['team']=$this->auth->my_teams(true);
		$data['teamupb']=$rowData['iteampd_id'];
		return $this->load->view('cek_dokumen_file_kube',$data,TRUE);			
	}
	function updateBox_cek_dokumen_lpp($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ifor_id
		$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
				order by fo.ifor_id desc limit 1";
		$q_for=$this->db_plc0->query($sql_for)->row_array();
		$ifor_id=$q_for['ifor_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_lpp u where u.ifor_id=$ifor_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_lpp u where u.ifor_id=$ifor_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_lpp', array('ifor_id'=>$ifor_id))->result_array();
		$data['team']=$this->auth->my_teams(true);
		$data['teamupb']=$rowData['iteampd_id'];
		return $this->load->view('cek_dokumen_file_lpp',$data,TRUE);			
	}
	function updateBox_cek_dokumen_coafg($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ifor_id
		$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
				order by fo.ifor_id desc limit 1";
		$q_for=$this->db_plc0->query($sql_for)->row_array();
		$ifor_id=$q_for['ifor_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_coa_fg u where u.ifor_id=$ifor_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_coa_fg u where u.ifor_id=$ifor_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_coa_fg', array('ifor_id'=>$ifor_id))->result_array();
		return $this->load->view('cek_dokumen_file_coafg',$data,TRUE);			
	}
	function updateBox_cek_dokumen_lapport_valmoa($field, $id, $value, $rowData) {
		//print_r($rowData);
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ifor_id
		$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
				order by fo.ifor_id desc limit 1";
		$q_for=$this->db_plc0->query($sql_for)->row_array();
		$ifor_id=$q_for['ifor_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_valmoa u where u.ifor_id=$ifor_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_valmoa u where u.ifor_id=$ifor_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_valmoa', array('ifor_id'=>$ifor_id))->result_array();
		$data['team']=$this->auth->my_teams(true);
		$data['teamupb']=$rowData['iteampd_id'];
		return $this->load->view('cek_dokumen_file_valmoa',$data,TRUE);			
	}
	function updateBox_cek_dokumen_file_spek($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ispekfg_id
		$sql_spek="select fg.* from plc2.plc2_upb_spesifikasi_fg fg 
					where fg.iappqa=2 and fg.iupb_id='$iupb_id' and fg.ldeleted=0
					order by fg.ispekfg_id desc limit 1";
		$q_spek=$this->db_plc0->query($sql_spek)->row_array();
		$ispek_id=$q_spek['ispekfg_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_spesifikasi_fg u where u.ispekfg_id=$ispek_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_spesifikasi_fg u where u.ispekfg_id=$ispek_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_spesifikasi_fg', array('ispekfg_id'=>$ispek_id))->result_array();
		$data['team']=$this->auth->my_teams(true);
		$data['teamupb']=$rowData['iteampd_id'];
		return $this->load->view('cek_dokumen_file_spekfg',$data,TRUE);			
	}
	function updateBox_cek_dokumen_file_soifg($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari isoi_id
		$sql_soi="select fg.* from plc2.plc2_upb_soi_fg fg 
					where fg.iappqa=2 and fg.iupb_id='$iupb_id' and fg.ldeleted=0
						order by fg.isoi_id desc limit 1";
		$q_soi=$this->db_plc0->query($sql_soi)->row_array();
		if($q_soi){
		$isoi_id=$q_soi['isoi_id'];
		}else{$isoi_id=0;}
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_soi_fg u where u.isoi_id=$isoi_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_soi_fg u where u.isoi_id=$isoi_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_soi_fg', array('isoi_id'=>$isoi_id))->result_array();
		$data['team']=$this->auth->my_teams(true);
		$data['teamupb']=$rowData['iteampd_id'];
		return $this->load->view('cek_dokumen_file_soifg',$data,TRUE);			
	}
	function updateBox_cek_dokumen_file_formula($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $iupb_id;
		//cari ifor_id
		$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
					order by fo.ifor_id desc limit 1";
		$q_for=$this->db_plc0->query($sql_for)->row_array();
		$ifor_id=$q_for['ifor_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_skala_trial_filename u where u.ifor_id=$ifor_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_skala_trial_filename u where u.ifor_id=$ifor_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_skala_trial_filename', array('ifor_id'=>$ifor_id))->result_array();
		$data['team']=$this->auth->my_teams(true);
		$data['teamupb']=$rowData['iteampd_id'];
		return $this->load->view('cek_dokumen_file_formula',$data,TRUE);			
	}
	function updateBox_cek_dokumen_prosprod($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ifor_id
		$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
					order by fo.ifor_id desc limit 1";
		$q_for=$this->db_plc0->query($sql_for)->row_array();
		$ifor_id=$q_for['ifor_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_proses_produksi u where u.ifor_id=$ifor_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_proses_produksi u where u.ifor_id=$ifor_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_proses_produksi', array('ifor_id'=>$ifor_id))->result_array();
		$data['team']=$this->auth->my_teams(true);
		$data['teamupb']=$rowData['iteampd_id'];
		return $this->load->view('cek_dokumen_file_prosprod',$data,TRUE);			
	}
	function updateBox_cek_dokumen_form_valpro($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ifor_id
		$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
					order by fo.ifor_id desc limit 1";
		$q_for=$this->db_plc0->query($sql_for)->row_array();
		$ifor_id=$q_for['ifor_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_form_valpro u where u.ifor_id=$ifor_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_form_valpro u where u.ifor_id=$ifor_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_form_valpro', array('ifor_id'=>$ifor_id))->result_array();
		return $this->load->view('cek_dokumen_file_formvalpro',$data,TRUE);			
	}
	function updateBox_cek_dokumen_lapprot_udt($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ifor_id
		$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
					order by fo.ifor_id desc limit 1";
		$q_for=$this->db_plc0->query($sql_for)->row_array();
		$ifor_id=$q_for['ifor_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_lapprot_udt u where u.ifor_id=$ifor_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_lapprot_udt u where u.ifor_id=$ifor_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_lapprot_udt', array('ifor_id'=>$ifor_id))->result_array();
		$data['team']=$this->auth->my_teams(true);
		$data['teamupb']=$rowData['iteampd_id'];
		return $this->load->view('cek_dokumen_file_udt',$data,TRUE);			
	}
	function updateBox_cek_dokumen_coaex($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ifor_id
		$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
					order by fo.ifor_id desc limit 1";
		$q_for=$this->db_plc0->query($sql_for)->row_array();
		$ifor_id=$q_for['ifor_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_coa_ex u where u.ifor_id=$ifor_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_coa_ex u where u.ifor_id=$ifor_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_coa_ex', array('ifor_id'=>$ifor_id))->result_array();
		return $this->load->view('cek_dokumen_filecoaex',$data,TRUE);			
	}
	function updateBox_cek_dokumen_lsaex($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ifor_id
		$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
					order by fo.ifor_id desc limit 1";
		$q_for=$this->db_plc0->query($sql_for)->row_array();
		$ifor_id=$q_for['ifor_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_lsa_ex u where u.ifor_id=$ifor_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_lsa_ex u where u.ifor_id=$ifor_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_lsa_ex', array('ifor_id'=>$ifor_id))->result_array();
		return $this->load->view('cek_dokumen_filelsaex',$data,TRUE);			
	}
	function updateBox_cek_dokumen_soiex($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ifor_id
		$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
					order by fo.ifor_id desc limit 1";
		$q_for=$this->db_plc0->query($sql_for)->row_array();
		$ifor_id=$q_for['ifor_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_soi_ex u where u.ifor_id=$ifor_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_soi_ex u where u.ifor_id=$ifor_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_soi_ex', array('ifor_id'=>$ifor_id))->result_array();
		return $this->load->view('cek_dokumen_filesoiex',$data,TRUE);			
	}
	function updateBox_cek_dokumen_lapori($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ifor_id
		$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
					order by fo.ifor_id desc limit 1";
		$q_for=$this->db_plc0->query($sql_for)->row_array();
		$ifor_id=$q_for['ifor_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_lap_ori u where u.ifor_id=$ifor_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_lap_ori u where u.ifor_id=$ifor_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_lap_ori', array('ifor_id'=>$ifor_id))->result_array();
		$data['team']=$this->auth->my_teams(true);
		$data['teamupb']=$rowData['iteampd_id'];
		return $this->load->view('cek_dokumen_file_lapori',$data,TRUE);			
	}
	function updateBox_cek_dokumen_lapprot_valpro($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ifor_id
		$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
					order by fo.ifor_id desc limit 1";
		$q_for=$this->db_plc0->query($sql_for)->row_array();
		$ifor_id=$q_for['ifor_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_lapprot_valpro u where u.ifor_id=$ifor_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_lapprot_valpro u where u.ifor_id=$ifor_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_lapprot_valpro', array('ifor_id'=>$ifor_id))->result_array();
		return $this->load->view('cek_dokumen_file_laprot_valpro',$data,TRUE);			
	}
	function updateBox_cek_dokumen_protaccel($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ifor_id
		$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
					order by fo.ifor_id desc limit 1";
		$q_for=$this->db_plc0->query($sql_for)->row_array();
		$ifor_id=$q_for['ifor_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_protaccel u where u.ifor_id=$ifor_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_protaccel u where u.ifor_id=$ifor_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_protaccel', array('ifor_id'=>$ifor_id))->result_array();
		$data['team']=$this->auth->my_teams(true);
		$data['teamupb']=$rowData['iteampd_id'];
		return $this->load->view('cek_dokumen_file_accel',$data,TRUE);			
	}
	function updateBox_cek_dokumen_protreal($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ifor_id
		$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
					order by fo.ifor_id desc limit 1";
		$q_for=$this->db_plc0->query($sql_for)->row_array();
		$ifor_id=$q_for['ifor_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_protreal u where u.ifor_id=$ifor_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_protreal u where u.ifor_id=$ifor_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_protreal', array('ifor_id'=>$ifor_id))->result_array();
		return $this->load->view('cek_dokumen_file_real',$data,TRUE);			
	}
	function updateBox_cek_dokumen_dokstab($field, $id, $value, $rowData) {
		$data['mydept'] = $this->auth->my_depts(TRUE); 
		$iupb_id = $rowData['iupb_id'];
		$data['iupb_id'] = $rowData['iupb_id'];
		//cari ifor_id
		$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
					order by fo.ifor_id desc limit 1";
		$q_for=$this->db_plc0->query($sql_for)->row_array();
		$ifor_id=$q_for['ifor_id'];
		$qupb="select distinct(u.iDone) from plc2.plc2_upb_file_stabpilot u where u.ifor_id=$ifor_id";
		$cupb = $this->db_plc0->query($qupb)->num_rows();
		if($cupb >0){
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$data['iDone']=$rupb['iDone'];
			$qconf="select * from plc2.plc2_upb_file_stabpilot u where u.ifor_id=$ifor_id and u.iconfirm_busdev=0";
			$rconf = $this->db_plc0->query($qconf)->num_rows();
			$data['cekconf']=$rconf;
		}
		else{$data['iDone']=2;$data['cekconf']=2;}
		$data['rows'] = $this->db_plc0->get_where('plc2.plc2_upb_file_stabpilot', array('ifor_id'=>$ifor_id))->result_array();
		$data['team']=$this->auth->my_teams(true);
		$data['teamupb']=$rowData['iteampd_id'];
		return $this->load->view('cek_dokumen_file_dokstab',$data,TRUE);			
	}
	function updateBox_cek_dokumen_vupb_nama($field, $id, $value, $rowData) {
		$iupb_id = $rowData['iupb_id'];
		$sql = "SELECT u.vupb_nama FROM plc2.plc2_upb u WHERE u.iupb_id='$iupb_id'";
		$row = $this->db_plc0->query($sql)->row_array();
		//$row=$this->db_plc0->get_where('plc2.plc2_upb_formula', array('ifor_id'=> $rowData['ifor_id']))->row_array();
		return '<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" value="'.$row['vupb_nama'].'" class="input_rows1" />';
	}
	function before_update_processor($row, $postData) {
    	unset($postData['vupb_nama']);
		return $postData;
    }
	function after_update_processor($row, $post, $postData) {
		$x=$this->auth->dept();
			if($this->auth->is_manager()){
				$x=$this->auth->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){$type='PD';}
				elseif(in_array('BD', $manager)){$type='BD';}
				elseif(in_array('PR', $manager)){$type='PR';}
				elseif(in_array('QA', $manager)){$type='QA';}
				elseif(in_array('QC', $manager)){$type='QC';}
				else{$type='';}
			}
			else{
				$x=$this->auth->dept();
				$team=$x['team'];
				if(in_array('BD', $team)){$type='BD';}
				elseif(in_array('PD', $team)){$type='PD';}
				elseif(in_array('PR', $team)){$type='PR';}
				elseif(in_array('QA', $team)){$type='QA';}
				elseif(in_array('QC', $team)){$type='QC';}
				else{$type='';}
			}
			
			$iupb_id=$postData['iupb_id'];
			
			//cari ifor_id
				$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
						order by fo.ifor_id desc limit 1";
				$q_for=$this->db_plc0->query($sql_for)->row_array();
				$ifor_id=$q_for['ifor_id'];
				//print_r($q_for);
				
			//cari ibk_id
				$sql_bk="select bk.* from plc2.plc2_upb_bahan_kemas bk where bk.iappqa=2 and bk.iupb_id='$iupb_id'
							order by bk.ibk_id desc limit 1";
				$q_bk=$this->db_plc0->query($sql_bk)->row_array();
				$ibk_id=$q_bk['ibk_id'];
				
			//cari ispekfg_id
				$sql_spek="select fg.* from plc2.plc2_upb_spesifikasi_fg fg 
							where fg.iappqa=2 and fg.iupb_id='$iupb_id' and fg.ldeleted=0
							order by fg.ispekfg_id desc limit 1";
				$q_spek=$this->db_plc0->query($sql_spek)->row_array();
				$ispek_id=$q_spek['ispekfg_id'];
				//echo $ispek_id;
				//print_r($q_bk);
				
			//cari isoi_id
				$sql_soi="select fg.* from plc2.plc2_upb_soi_fg fg 
							where fg.iappqa=2 and fg.iupb_id='$iupb_id' and fg.ldeleted=0
								order by fg.isoi_id desc limit 1";
				$q_soi=$this->db_plc0->query($sql_soi)->row_array();
				$isoi_id=$q_soi['isoi_id'];
			
			//cek status dokumen all done?
			$tabelPD=array('plc2_upb_file_spesifikasi_fg','plc2_upb_file_skala_trial_filename','plc2_upb_file_proses_produksi','plc2_upb_file_lpp'
						,'plc2_upb_file_valmoa','plc2_upb_file_lap_ori','plc2_upb_file_lapprot_udt','plc2_upb_file_bahan_kemas',
						'plc2_upb_file_protaccel','plc2_upb_file_stabpilot','plc2_upb_file_kube');
			$tampilPD=array('Dokumen Spesifikasi FG','Dokumen Formula','Dokumen Proses Produksi','Dokumen Laporan Pengembangan Produk'
						,'Dokumen Validasi MOA','Dokumen Laporan Originator','Dokumen Laporan & Protokol UDT','Dokumen Bahan Kemas'
						,'Dokumen Protokol Accelerated','Dokumen Stabilita Pilot','Dokumen Kajian Uji BE');
			$pknyaPD=array('ispekfg_id','ifor_id','ifor_id','ifor_id','ifor_id','ifor_id'
						,'ifor_id','ibk_id','ifor_id','ifor_id','iupb_id');
			$idnyaPD=array($ispek_id,$ifor_id,$ifor_id,$ifor_id,$ifor_id,$ifor_id
						,$ifor_id,$ibk_id,$ifor_id,$ifor_id,$iupb_id);
						
			$tabelPR=array('plc2_upb_file_bk_dmf','plc2_upb_file_bk_coabb','plc2_upb_file_bk_coars','plc2_upb_file_bk_ws','plc2_upb_file_coa_ex');
			$tampilPR=array('Dokumen DMF','Dokumen CoA Bahan Baku','Dokumen CoA RS','Dokumen CoA WS','Dokumen CoA Excipient');
			$pknyaPR=array('iupb_id','iupb_id','iupb_id','iupb_id','ifor_id');
			$idnyaPR=array($iupb_id,$iupb_id,$iupb_id,$iupb_id,$ifor_id);
			
			$tabelQC=array('plc2_upb_file_bk_lsa','plc2_upb_file_lsa_ex','plc2_upb_file_soi_ex','plc2_upb_file_protreal');
			$tampilQC=array('Dokumen LSA Zat Aktif','Dokumen LSA Excipient','Dokumen SOI Excipient','Dokumen Protocol Realtime');
			$pknyaQC=array('iupb_id','ifor_id','ifor_id','ifor_id');
			$idnyaQC=array($iupb_id,$ifor_id,$ifor_id,$ifor_id);
			
			$tabelQA=array('plc2_upb_file_form_valpro','plc2_upb_file_lapprot_valpro','plc2_upb_file_coa_fg');
			$tampilQA=array('Dokumen Form Validasi Proses','Dokumen Laporan & Protokol Validasi Proses','Dokumen CoA FG');
			$pknyaQA=array('ifor_id','ifor_id','ifor_id');
			$idnyaQA=array($ifor_id,$ifor_id,$ifor_id);
		
	 if($type=='BD'){
			$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
					u.iteambusdev_id as bd,
					u.iteampd_id as pd,
					u.iteamqa_id as qa,
					u.iteamqc_id as qc
					from plc2.plc2_upb u where u.iupb_id='$iupb_id'";
			$rupb = $this->db_plc0->query($qupb)->row_array();
			//echo $qupb;
			$pdteam=$rupb['pd'];
			$qateam=$rupb['qa'];
			$qcteam=$rupb['qc'];
			//$to = "";
			
			$qemailPD="select e.vEmail from hrd.employee e 
							where e.cNip in (select te.vnip from plc2.plc2_upb_team te where te.iteam_id=$pdteam) 
							or e.cNip in (select ti.vnip from plc2.plc2_upb_team_item ti where ti.iteam_id=$pdteam and ti.ldeleted=0)";
			$remailPD = $this->db_plc0->query($qemailPD)->result_array();
			$qemailQA="select e.vEmail from hrd.employee e 
							where e.cNip in (select te.vnip from plc2.plc2_upb_team te where te.iteam_id=$qateam) 
							or e.cNip in (select ti.vnip from plc2.plc2_upb_team_item ti where ti.iteam_id=$qateam and ti.ldeleted=0)";
			$remailQA = $this->db_plc0->query($qemailQA)->result_array();
			$qemailQC="select e.vEmail from hrd.employee e 
							where e.cNip in (select te.vnip from plc2.plc2_upb_team te where te.iteam_id=$qcteam) 
							or e.cNip in (select ti.vnip from plc2.plc2_upb_team_item ti where ti.iteam_id=$qcteam and ti.ldeleted=0)";
			$remailQC = $this->db_plc0->query($qemailQC)->result_array();
			
			$toPD="";
			$toQA="";
			$toQC="";
			foreach($remailPD as $toemailPD){
				$toPD.=$toemailPD['vEmail'].', ';
			} 
			foreach($remailQA as $toemailQA){
				$toQA.=$toemailQA['vEmail'].', ';
			} 
			foreach($remailQC as $toemailQC){
				$toQC.=$toemailQC['vEmail'].', ';
			}
			
			//$to.="Rugun.Clara-gp@novellpharm.com; tika@novellpharm.com"; //PR
			$toPR = "dinny.rachma@novellpharm.com";
			$cc = "";
			
			//send email PD
			$xPD=0;$x2PD=0;$noPD="";$nullPD="";
			foreach($tabelPD as $kPD=>$vPD){
				//cek minimal ada satu dokumen per jenis dokumen
				$queryPD = $this->db_plc0->query("select * from plc2.".$vPD." where ".$pknyaPD[$kPD]." =".$idnyaPD[$kPD]);
				$jumlahPD = $queryPD->num_rows();
				$xPD = $jumlahPD+$xPD;
				if($jumlahPD==0){
					$nullPD.=$tampilPD[$kPD].',';
				}
				else{
					//cek jumlah yg blm done
					$query2PD = $this->db_plc0->query("select * from plc2.".$vPD." where iDone=0 and iconfirm_busdev=3 and ".$pknyaPD[$kPD]." =".$idnyaPD[$kPD]);
					$jumlah2PD = $query2PD->num_rows();
					$x2PD = $jumlah2PD+$x2PD;
					if($jumlah2PD > 0){
						$noPD.=$tampilPD[$kPD].',';
					}
				}
			}
			$subjectPD="Document need to be follow-up".$rupb['vupb_nomor']." ( ".$rupb['vupb_nama']." )";
			$contentPD="
				Diberitahukan kepada Departemen PD bahwa ada dokumen untuk Praregistrasi UPB yang dinyatakan PERLU PERBAIKAN oleh Busdev, pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
				<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
				<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
						<tr>
							<td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
						</tr>
						<tr>
							<td><b>Nama Usulan</b></td><td> : </td><td>".$rupb['vupb_nama']."</td>
						</tr>
						<tr>
							<td><b>Nama Generik</b></td><td> : </td><td>".$rupb['vgenerik']."</td>
						</tr>
						<tr>
							<td><b>Dokumen yang belum diupload</b></td><td> : </td><td>".$nullPD."</td>
						</tr>
						<tr><td></td><td></td></tr>
						<tr>
							<td><b>Dokumen yang perlu diperbaiki</b></td><td> : </td><td>".$noPD."</td>
						</tr>
						<tr><td></td><td></td></tr><tr><td></td><td></td></tr><tr><td></td><td></td></tr>
						<tr><td colspan='3'>Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
				Post Master</td></tr>
				</table>
				</div>
				<br/>";
		
			if($x2PD >0){$this->lib_utilitas->send_email($toPD, $cc, $subjectPD, $contentPD);}
						
			//end send email PD
			
			//send email QA
			$xQA=0;$x2QA=0;$noQA="";$nullQA="";
			foreach($tabelQA as $kQA=>$vQA){
				//cek minimal ada satu dokumen per jenis dokumen
				$queryQA = $this->db_plc0->query("select * from plc2.".$vQA." where ".$pknyaQA[$kQA]." =".$idnyaQA[$kQA]);
				$jumlahQA = $queryQA->num_rows();
				$xQA = $jumlahQA+$xQA;
				if($jumlahQA==0){
					$nullQA.=$tampilQA[$kQA].',';
				}
				else{
					//cek jumlah yg blm done
					$query2QA = $this->db_plc0->query("select * from plc2.".$vQA." where iDone=0 and iconfirm_busdev=3 and ".$pknyaQA[$kQA]." =".$idnyaQA[$kQA]);
					$jumlah2QA = $query2QA->num_rows();
					$x2QA = $jumlah2QA+$x2QA;
					if($jumlah2QA > 0){
						$noQA.=$tampilQA[$kQA].',';
					}
				}
			}
			$subjectQA="Document need to be follow-up".$rupb['vupb_nomor']." ( ".$rupb['vupb_nama']." )";
			$contentQA="
				Diberitahukan kepada Departemen QA bahwa ada dokumen untuk Praregistrasi UPB yang dinyatakan PERLU PERBAIKAN oleh Busdev, pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
				<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
				<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
						<tr>
							<td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
						</tr>
						<tr>
							<td><b>Nama Usulan</b></td><td> : </td><td>".$rupb['vupb_nama']."</td>
						</tr>
						<tr>
							<td><b>Nama Generik</b></td><td> : </td><td>".$rupb['vgenerik']."</td>
						</tr>
						<tr>
							<td><b>Dokumen yang belum diupload</b></td><td> : </td><td>".$nullQA."</td>
						</tr>
						<tr><td></td><td></td></tr>
						<tr>
							<td><b>Dokumen yang perlu diperbaiki</b></td><td> : </td><td>".$noQA."</td>
						</tr>
					<tr><td></td><td></td></tr><tr><td></td><td></td></tr><tr><td></td><td></td></tr>
						<tr><td colspan='3'>Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
				Post Master</td></tr>
				</table>
				</div>
				<br/>";
		
			if($x2QA >0){$this->lib_utilitas->send_email($toQA, $cc, $subjectQA, $contentQA);}
			//end send email QA
			
			//send email QC
			$xQC=0;$x2QC=0;$noQC="";$nullQC="";
			foreach($tabelQC as $kQC=>$vQC){
				//cek minimal ada satu dokumen per jenis dokumen
				$queryQC = $this->db_plc0->query("select * from plc2.".$vQC." where ".$pknyaQC[$kQC]." =".$idnyaQC[$kQC]);
				$jumlahQC = $queryQC->num_rows();
				$xQC = $jumlahQC+$xQC;
				if($jumlahQC==0){
					$nullQC.=$tampilQC[$kQC].',';
				}
				else{
					//cek jumlah yg blm done
					$query2QC = $this->db_plc0->query("select * from plc2.".$vQC." where iDone=0 and iconfirm_busdev=3 and ".$pknyaQC[$kQC]." =".$idnyaQC[$kQC]);
					$jumlah2QC = $query2QC->num_rows();
					$x2QC = $jumlah2QC+$x2QC;
					if($jumlah2QC > 0){
						$noQC.=$tampilQC[$kQC].',';
					}
				}
			}
			$subjectQC="Document need to be follow-up".$rupb['vupb_nomor']." ( ".$rupb['vupb_nama']." )";
			$contentQC="
				Diberitahukan kepada Departemen QC bahwa ada dokumen untuk Praregistrasi UPB yang dinyatakan PERLU PERBAIKAN oleh Busdev, pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
				<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
				<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
						<tr>
							<td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
						</tr>
						<tr>
							<td><b>Nama Usulan</b></td><td> : </td><td>".$rupb['vupb_nama']."</td>
						</tr>
						<tr>
							<td><b>Nama Generik</b></td><td> : </td><td>".$rupb['vgenerik']."</td>
						</tr>
						<tr>
							<td><b>Dokumen yang belum diupload</b></td><td> : </td><td>".$nullQA."</td>
						</tr>
						<tr><td></td><td></td></tr>
						<tr>
							<td><b>Dokumen yang perlu diperbaiki</b></td><td> : </td><td>".$noQA."</td>
						</tr>
						<tr><td></td><td></td></tr><tr><td></td><td></td></tr><tr><td></td><td></td></tr>
						<tr><td colspan='3'>Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
				Post Master</td></tr>
				</table>
				</div>
				<br/>";
		
			if($x2QC >0){$this->lib_utilitas->send_email($toQC, $cc, $subjectQC, $contentQC);} //echo "aa";}
			//end send email QC
			
			//send email PR
			$xPR=0;$x2PR=0;$noPR="";$nullPR="";
			foreach($tabelPR as $kPR=>$vPR){
				//cek minimal ada satu dokumen per jenis dokumen
				$queryPR = $this->db_plc0->query("select * from plc2.".$vPR." where ".$pknyaPR[$kPR]." =".$idnyaPR[$kPR]);
				$jumlahPR = $queryPR->num_rows();
				$xPR = $jumlahPR+$xPR;
				if($jumlahPR==0){
					$nullPR.=$tampilPR[$kPR].',';
				}
				else{
					//cek jumlah yg blm done
					$query2PR = $this->db_plc0->query("select * from plc2.".$vPR." where iDone=0 and iconfirm_busdev=3 and ".$pknyaPR[$kPR]." =".$idnyaPR[$kPR]);
					$jumlah2PR = $query2PR->num_rows();
					$x2PR = $jumlah2PR+$x2PR;
					if($jumlah2PR > 0){
						$noPR.=$tampilPR[$kPR].',';
					}
				}
			}
			$subjectPR="Document need to be follow-up".$rupb['vupb_nomor']." ( ".$rupb['vupb_nama']." )";
			$contentPR="
				Diberitahukan kepada Departemen Purchasing-PD bahwa ada dokumen untuk Praregistrasi UPB yang dinyatakan PERLU PERBAIKAN oleh Busdev, pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
				<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
				<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
						<tr>
							<td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
						</tr>
						<tr>
							<td><b>Nama Usulan</b></td><td> : </td><td>".$rupb['vupb_nama']."</td>
						</tr>
						<tr>
							<td><b>Nama Generik</b></td><td> : </td><td>".$rupb['vgenerik']."</td>
						</tr>
						<tr>
							<td><b>Dokumen yang belum diupload</b></td><td> : </td><td>".$nullQA."</td>
						</tr>
						<tr><td></td><td></td></tr>
						<tr>
							<td><b>Dokumen yang perlu diperbaiki</b></td><td> : </td><td>".$noQA."</td>
						</tr>
						<tr><td></td><td></td></tr><tr><td></td><td></td></tr><tr><td></td><td></td></tr>
						<tr><td colspan='3'>Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
				Post Master</td></tr>
				</table>
				</div>
				<br/>";
		
			if($x2PR >0){$this->lib_utilitas->send_email($toPR, $cc, $subjectPR, $contentPR);}
			//end send email PR
			
			
		}
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
								var url = "'.base_url().'processor/plc/cek/dokumen";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_cek_dokumen").html(data);
									});
					
								}
									reload_grid("grid_cek_dokumen");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Konfirmasi Dokumen Praregistrasi UPB</h1><br />';
    	$echo .= '<form id="form_cek_dokumen_approve" action="'.base_url().'processor/plc/cek/dokumen?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="upb_id" value="'.$this->input->get('upb_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_cek_dokumen_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {
    	$post = $this->input->post();
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		
		$iapprove ='iconfirm_dok';$vapprove ='vnip_confirm_dok';$tapprove ='tconfirm_dok';
		$this->db_plc0->where('iupb_id', $post['upb_id']);
		$this->db_plc0->update('plc2.plc2_upb', array($iapprove=>1,$vapprove=>$nip,$tapprove=>$skg));
		$iupb_id=$post['upb_id'];
		
		//send email notifikasi to PD
		$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,iteampd_id,iteamqa_id,iteamqc_id,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
					from plc2.plc2_upb u where u.iupb_id='".$post['upb_id']."'";
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$pdteam=$rupb['iteampd_id'];
			$qateam=$rupb['iteamqa_id'];
			$qcteam=$rupb['iteamqc_id'];
			//$to = "";
			$qemail="select e.vEmail from hrd.employee e 
							where e.cNip in (select te.vnip from plc2.plc2_upb_team te where te.iteam_id=$pdteam or te.iteam_id=$qateam or te.iteam_id=$qcteam) 
							or e.cNip in (select ti.vnip from plc2.plc2_upb_team_item ti where (ti.iteam_id=$pdteam or ti.iteam_id=$qateam or ti.iteam_id=$qcteam) and ti.ldeleted=0)";
			$remail = $this->db_plc0->query($qemail)->result_array();
			$to="";
			foreach($remail as $toemail){
				$to.=$toemail['vEmail'].', ';
			} 
			//$to = "dinny.rachma@novellpharm.com";
			$cc = "";
			$subject="Documents has been confirmed : UPB ".$rupb['vupb_nomor']." ( ".$rupb['vupb_nama']." )";
			$content="
				Diberitahukan bahwa Busdev Manager atau Associate Busdev Manager <b>telah melakukan konfirmasi kelengkapan dokumen praregistrasi UPB ".$rupb['vupb_nomor']."</b> pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
				<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
					<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
						<tr>
							<td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
						</tr>
						<tr>
							<td><b>Nama Usulan</b></td><td> : </td><td>".$rupb['vupb_nama']."</td>
						</tr>
						<tr>
							<td><b>Nama Generik</b></td><td> : </td><td>".$rupb['vgenerik']."</td>
						</tr>
						<tr>
							<td><b>Team Busdev</b></td><td> : </td><td>".$rupb['bd']."</td>
						</tr>
						<tr>
							<td><b>Team PD</b></td><td> : </td><td>".$rupb['pd']."</td>
						</tr>
						<tr>
							<td><b>Team QA</b></td><td> : </td><td>".$rupb['qa']."</td>
						</tr>
						<tr>
							<td><b>Team QC</b></td><td> : </td><td>".$rupb['qc']."</td>
						</tr>
					</table>
				</div>
				<br/> 
				Demikian. Terimakasih.<br><br><br>
				Post Master";
			$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		
		$data['status']  = true;
    	$data['last_id'] = $iupb_id;
    	return json_encode($data);
    }
	
    function manipulate_update_button($buttons, $rowData) {
		if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			unset($buttons['update']);
			unset($buttons['update_back']);
			
			//print_r($rowData);
			//echo $rowData['vnip_formulator']."<br>".$this->user->gNIP;
			$user = $this->auth->user();
		
			$x=$this->auth->dept();
			if($this->auth->is_manager()){
				$x=$this->auth->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){$type='PD';}
				elseif(in_array('BD', $manager)){$type='BD';}
				elseif(in_array('PR', $manager)){$type='PR';}
				elseif(in_array('QA', $manager)){$type='QA';}
				elseif(in_array('QC', $manager)){$type='QC';}
				else{$type='';}
			}
			else{
				$x=$this->auth->dept();
				$team=$x['team'];
				if(in_array('BD', $team)){$type='BD';}
				elseif(in_array('PD', $team)){$type='PD';}
				elseif(in_array('PR', $team)){$type='PR';}
				elseif(in_array('QA', $team)){$type='QA';}
				elseif(in_array('QC', $team)){$type='QC';}
				else{$type='';}
			}
			
			//echo $type;
			//cek status konfirmasi dokumen
			$qupb="select * from plc2.plc2_upb u where u.iupb_id='".$rowData['iupb_id']."'";
			$rupb = $this->db_plc0->query($qupb)->row_array();
			$iconfirm=$rupb['iconfirm_dok'];
			//
			//cek status ass busdev manager
			$usnip=$this->user->gNIP;
			$qabm="select e.cNip, e.vName, p.vDescription, p.iLvlemp from hrd.employee e 
						inner join hrd.position p on p.iPostId=e.iPostID 
					where e.cNip='$usnip'";
			$rabm = $this->db_plc0->query($qabm)->row_array();
			//
			
			//cek status dokumen all done?
			$tabel=array('plc2_upb_file_bk_dmf','plc2_upb_file_bk_coabb','plc2_upb_file_bk_coars','plc2_upb_file_bk_ws','plc2_upb_file_bk_lsa'
						,'plc2_upb_file_spesifikasi_fg','plc2_upb_file_skala_trial_filename'
						,'plc2_upb_file_proses_produksi','plc2_upb_file_lpp','plc2_upb_file_form_valpro','plc2_upb_file_lapprot_valpro'
						,'plc2_upb_file_coa_ex','plc2_upb_file_lsa_ex','plc2_upb_file_soi_ex','plc2_upb_file_coa_fg','plc2_upb_file_soi_fg'
						,'plc2_upb_file_valmoa','plc2_upb_file_lap_ori','plc2_upb_file_lapprot_udt','plc2_upb_file_bahan_kemas'
						,'plc2_upb_file_protaccel','plc2_upb_file_protreal','plc2_upb_file_stabpilot','plc2_upb_file_kube');
		
			$pknya=array('iupb_id','iupb_id','iupb_id','iupb_id','iupb_id','ispekfg_id','ifor_id','ifor_id','ifor_id','ifor_id','ifor_id'
						,'ifor_id','ifor_id','ifor_id','ifor_id','isoi_id','ifor_id','ifor_id','ifor_id','ibk_id','ifor_id','ifor_id'
						,'ifor_id','iupb_id');
			
			$iupb_id=$rowData['iupb_id'];
			//print_r($rowData);exit();
			//cari ifor_id
				$sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
						order by fo.ifor_id desc limit 1";
				$q_for=$this->db_plc0->query($sql_for)->row_array();
				$ifor_id=$q_for['ifor_id'];
				//print_r($q_for);
				
			//cari ibk_id
				$sql_bk="select bk.* from plc2.plc2_upb_bahan_kemas bk where bk.iappqa=2 and bk.iupb_id='$iupb_id'
							order by bk.ibk_id desc limit 1";
				$q_bk=$this->db_plc0->query($sql_bk)->row_array();
				$ibk_id=$q_bk['ibk_id'];
				
			//cari ispekfg_id
				$sql_spek="select fg.* from plc2.plc2_upb_spesifikasi_fg fg 
							where fg.iappqa=2 and fg.iupb_id='$iupb_id' and fg.ldeleted=0
							order by fg.ispekfg_id desc limit 1";
				$q_spek=$this->db_plc0->query($sql_spek)->row_array();
				$ispek_id=$q_spek['ispekfg_id'];
				//print_r($q_bk);
				
			//cari isoi_id
				$isoi_id=0;
				$sql_soi="select fg.* from plc2.plc2_upb_soi_fg fg 
							where fg.iappqa=2 and fg.iupb_id='$iupb_id' and fg.ldeleted=0
								order by fg.isoi_id desc limit 1";
				$q_soi=$this->db_plc0->query($sql_soi)->row_array();
				if($q_soi){
				$isoi_id=$q_soi['isoi_id'];
			}else{$isoi_id=0;}
			
			$idnya=array($iupb_id, $iupb_id, $iupb_id, $iupb_id, $iupb_id, $ispek_id, $ifor_id, $ifor_id, $ifor_id, $ifor_id, $ifor_id
						,$ifor_id, $ifor_id, $ifor_id, $ifor_id, $isoi_id, $ifor_id, $ifor_id, $ifor_id, $ibk_id, $ifor_id, $ifor_id
						,$ifor_id, $iupb_id);			
		$xx=0;$xx2=0;
		foreach($tabel as $k=>$v){
			//cek minimal ada satu dokumen per jenis dokumen
			$query = $this->db_plc0->query("select * from plc2.".$v." where ".$pknya[$k]." =".$idnya[$k]);
			$jumlah = $query->num_rows();
			$xx = $jumlah+$xx;
			//echo "query  ="."select * from plc2.".$v." where ".$pknya[$k]." =".$idnya[$k];
			
			//cek jumlah yg blm done
			$query2 = $this->db_plc0->query("select * from plc2.".$v." where iDone=0 and ".$pknya[$k]." =".$idnya[$k]);
			$jumlah2 = $query2->num_rows();
			$xx2 = $jumlah2+$xx2;
			//echo "query 2 ="."select * from plc2.".$v." where iDone=0 and ".$pknya[$k]." =".$idnya[$k];
			//echo "<br>";
		}
		//
		//echo $xx2.'  '.$xx;
		// cek status upb, klao upb 
				unset($buttons['update_back']);
				unset($buttons['update']);
				
				//echo $this->auth->my_teams();
				$upb_id=$rowData['iupb_id'];
				//$ibk_id=$rowData['ibk_id'];
				
				// print_r($rowData);exit();
				$js = $this->load->view('cek_dokumen_js');
				
				$x=$this->auth->my_teams();
				//print_r($x);
				//echo "check var ".'icon = '.$iconfirm.'xx ='.$xx.'xx2='.$xx2;
				$arrhak=$this->biz_process->get(3, $this->auth->my_teams(),$this->input->get('modul_id')); // 3 input data
				if(empty($arrhak)){
					if($this->auth->is_manager()){ //jika manager BD
							if(($type=='BD')&&($iconfirm==0) &&($xx2==0) && ($xx >0)){
								//$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/cek/dokumen?action=approve&upb_id='.$upb_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_cek_dokumen">Confirm</button>';
								$buttons['update'] = $approve;
							}
							elseif(($type=='BD')&&($iconfirm==0) &&($xx2<>0)){
								$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$buttons['update'] = $update.$js;
							}
							elseif(($type=='BD')&&($iconfirm==0) &&($xx2==0) && ($xx==0)){ //blm ada file sama sekali
								$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$buttons['update'] = $update.$js;
							}
							elseif((($type=='PD')||($type=='PR')||($type=='QA')||($type=='QC'))&&($iconfirm==0)){
								$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$buttons['update'] = $update.$js;
							}
							else{}
					}
					else{
						if(($type=='BD')&&($iconfirm==0)&&($rabm['iLvlemp']==5)&&($xx2==0)&&($xx>0)){ //abdm
								//$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/cek/dokumen?action=approve&upb_id='.$upb_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_cek_dokumen">Confirm</button>';
								$buttons['update'] = $approve;
						}
						elseif(($type=='BD')&&($iconfirm==0)&&($rabm['iLvlemp']==5)&&($xx2<>0)){ //abdm
								$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$buttons['update'] = $update.$js;
						}
						elseif(($type=='BD')&&($iconfirm==0)&&($rabm['iLvlemp']==5)&&($xx2==0)&&($xx==0)){ //abdm
								$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$buttons['update'] = $update.$js;
						}
						elseif(((($type=='PD')||($type=='PR')||($type=='QA')||($type=='QC'))&&($iconfirm==0)) || (($type=='BD')&&($iconfirm==0)&&($rabm['iLvlemp']<5))){
								$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$buttons['update'] = $update.$js;
						}
					}
				}else{
					if($this->auth->is_manager()){ //jika manager BD
							if(($type=='BD')&&($iconfirm==0)&&($xx2==0)&&($xx>0)){
								//$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/cek/dokumen?action=approve&upb_id='.$upb_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_cek_dokumen">Confirm</button>';
								$buttons['update'] = $approve;
							}
							elseif(($type=='BD')&&($iconfirm==0) &&($xx2==0) && ($xx==0)){ //blm ada file sama sekali
								$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$buttons['update'] = $update.$js;
							}
							elseif(($type=='BD')&&($iconfirm==0)&&($xx2<>0)){
								$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$buttons['update'] = $update.$js;
							}
							elseif((($type=='PD')||($type=='PR')||($type=='QA')||($type=='QC'))&&($iconfirm==0)){
								$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$buttons['update'] = $update.$js;
							}
							else{}
					}
					else{
						if(($type=='BD')&&($iconfirm==0)&&($rabm['iLvlemp']==5)&&($xx2==0) && ($xx >0)){ //abdm
								//$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/cek/dokumen?action=approve&upb_id='.$upb_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_cek_dokumen">Confirm</button>';
								$buttons['update'] = $approve;
						}
						elseif(($type=='BD')&&($iconfirm==0)&&($rabm['iLvlemp']==5)&&($xx2<>0)){ //abdm
								$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$buttons['update'] = $update.$js;
						}
						elseif(($type=='BD')&&($iconfirm==0)&&($rabm['iLvlemp']==5)&&($xx2==0)&&($xx==0)){ //abdm
								$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$buttons['update'] = $update.$js;
						}
						elseif(((($type=='PD')||($type=='PR')||($type=='QA')||($type=='QC'))&&($iconfirm==0)) || (($type=='BD')&&($iconfirm==0)&&($rabm['iLvlemp']<5))){
								$update = '<button onclick="javascript:update_btn_back(\'cek_dokumen\', \''.base_url().'processor/plc/cek/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_cek_dokumen">Update</button>';
								$buttons['update'] = $update.$js;
						}
					}
				}
		}
   
    	return $buttons;
		
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
	
	function hapusfile($path, $file_name, $table, $lastId, $namafield){
		$path = $path."/".$lastId;
		$path = str_replace("\\", "/", $path);
		
		if (is_array($file_name)) {			
			$list_dir  = $this->readDirektory($path);
			$list_sql  = $this->readSQL($table, $lastId,'',$namafield);
			asort($file_name);		
			asort($list_dir);		
			asort($list_sql);
			
			//$del = array();
			foreach($list_dir as $v) {				
				if (!in_array($v, $file_name)) {				
					unlink($path.'/'.$v);	
					//echo "a";
				}			
			}
			foreach($list_sql as $v) {
				if (!in_array($v, $file_name)) {				
					$del = "delete from plc2.".$table." where ".$namafield." = {$lastId} and filename= '{$v}'";
					mysql_query($del);	
				}
				
			}
		} else {
			$this->readDirektory($path, 1);
			$this->readSQL($table, $lastId, 1, $namafield);
		}
	} 
	
	function readSQL($table, $lastId, $empty="", $namafield) {
		$list_file = array();
		if (empty($empty)) {
			$sql = "SELECT filename from plc2.".$table." where ".$namafield."=".$lastId;
			$query = mysql_query($sql);
			//echo $sql;
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {	
				$list_file[] = $row['filename'];
			}
			
			$x = $list_file;
		} else {			
			$sql = "SELECT filename from plc2.".$table." where ".$namafield."=".$lastId;
			$query = mysql_query($sql);
			$sql2 = array();
			while($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
				$sql2[] = "DELETE FROM plc2.".$table." where ".$namafield."=".$lastId." and filename='".$row['filename']."'";			
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