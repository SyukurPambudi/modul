<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class report_prioritas_prareg extends MX_Controller {
	//private $sess_auth;
	//private $dbset;
	//private $urutan = 0;
	//private $report;
			
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('auth');
		$this->user = $this->auth->user();
		$this->load->library('biz_process');
		$this->load->helper('tanggal');
		$this->load->model('user_model');
        $this->url = 'report_prioritas_prareg'; 
		$this->dbset = $this->load->database('plc', true);
		
		$this->load->library('lib_utilitas'); 

		
    }
    function index($action = '') {		
    	//Bikin Object Baru Nama nya $grid
    	$action = $this->input->get('action') ? $this->input->get('action') : 'create';		
		$grid = new Grid;		
		$grid->setTitle('Laporan Priortitas Registrasi UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('report_prioritas_prareg');		
		$grid->addFields('iteambusdev_id','imonth','iyear','iteampd_id');
		$grid->setLabel('imonth', 'Semester');
		$grid->setLabel('iyear', 'Tahun');
		$grid->setLabel('iteambusdev_id', 'Tim Busdev');
		$grid->setLabel('iteampd_id', 'Tim PD');
	
		switch ($action) {		
			case 'create':
				$grid->render_form();
				break;
			case 'get_preview_report' :
				$this->preview_report();
				break;
			case 'print_pdf':	
				echo $this->printpdf();			
				/*
				$html = $this->preview_report();
				
				$filename=$this->url.'_1.pdf';
				$html .= '<object type="application/pdf" data="embeddedfile.pdf" width="500" height="650">';
				$this->load->library('Dompdf_lib');
				$stream=TRUE;
				$paper = 'Legal';
				$orientation = 'Landscape';
				
				echo $this->dompdf_lib->convert_html_to_pdf($html, $filename, $stream, $paper, $orientation);
				*/
				break;
			case 'print_xls':
				$html = $this->preview_report();
				
				$filename=$this->url.'_2.xls';
				$this->lib_utilitas->setExcelHeader($filename);
				print $html;
				break;
			default:
				$grid->render_grid();
				break;
		}
    }
	public function output(){
		$this->index('create');
	}
	public function insertBox_report_prioritas_prareg_imonth($field, $id) {
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=1; $i<=2; $i++) {
			$echo .= '<option value="'.$i.'">Semester '.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	public function insertBox_report_prioritas_prareg_iyear($field, $id){
		$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-3; //dari -2 diganti -3
		$sampai = $thn_sekarang+7;
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		for($i=$mulai; $i<=$sampai; $i++) {
			$echo .= '<option value="'.$i.'">'.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	 public function insertBox_report_prioritas_prareg_iteambusdev_id($field, $id){
		$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'BD'  AND d.ldeleted = 0 ORDER BY d.vteam ASC ";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		foreach($teams as $t) {
			 $echo .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
		}
		 $echo .= '</select>';
		 return $echo;
	 }
	public function insertBox_report_prioritas_prareg_iteampd_id($field, $id){
		$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'PD' AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--Pilih--</option>';
		foreach($teams as $t) {
			$echo .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	public function insertBox_report_prioritas_prareg_format($field, $id) {
		$o = '
			<select name="'.$id.'" id="'.$id.'">
				<option value="1">PDF</option>
				<option value="2">XLS</option>
			</select>
		';
		
		return $o;
	}

	public function manipulate_insert_button($button) {
		unset($button);
		$button = array();
		
		$btn_preview = '&nbsp;<button onclick="javascript:print_pdf_'.$this->url.'();" class="ui-button-text icon-save" id="button_pdf_plc_'.$this->url.'">Print PDF</button>';
		$btn_preview.= '&nbsp;<button onclick="javascript:print_xls_'.$this->url.'();" class="ui-button-text icon-save" id="button_xls_plc_'.$this->url.'">Print Excel</button>';
		$btn_preview .= '<iframe height="0" width="0" id="iframe_pdf_plc_'.$this->url.'"></iframe> ';
		$btn_preview.= '
		<script type="text/javascript">
		
			
			function print_pdf_'.$this->url.'()	{
			
			var iteampd_id = $("#'.$this->url.'_iteampd_id option:selected").val();
			var imonth = $("#'.$this->url.'_imonth option:selected").val();
			var iyear = $("#'.$this->url.'_iyear option:selected").val();
			var iteambusdev_id = $("#'.$this->url.'_iteambusdev_id option:selected").val(); 
				
				if (imonth == "") {
					alert("Pilih Semester !!");
					$("#'.$this->url.'_imonth").focus();
					return false;
				}
				if (iyear == "") {
					alert("Pilih Tahun !!");
					$("#'.$this->url.'_iyear").focus();
					return false;
				}
				if (iteampd_id == "") {
					alert("Pilih Tim PD !!");
					$("#'.$this->url.'_iteampd_id").focus();
					return false;
				}
				else {	
					document.getElementById("iframe_pdf_plc_'.$this->url.'").src = "'.base_url().'processor/plc/report/prioritas/prareg?action=print_pdf&imonth="+imonth+"&iyear="+iyear+"&iteambusdev_id="+iteambusdev_id+"&iteampd_id="+iteampd_id;
				}
			}
			function print_xls_'.$this->url.'() {
			
			var iteampd_id = $("#'.$this->url.'_iteampd_id option:selected").val();
			var imonth = $("#'.$this->url.'_imonth option:selected").val();
			var iyear = $("#'.$this->url.'_iyear option:selected").val();
			var iteambusdev_id = $("#'.$this->url.'_iteambusdev_id option:selected").val(); 
				
				if (imonth == "") {
					alert("Pilih Semester !!");
					$("#'.$this->url.'_imonth").focus();
					return false;
				}
				if (iyear == "") {
					alert("Pilih Tahun !!");
					$("#'.$this->url.'_iyear").focus();
					return false;
				}
				if (iteampd_id == "") {
					alert("Pilih Tim PD !!");
					$("#'.$this->url.'_iteampd_id").focus();
					return false;
				}
				else {	
					document.getElementById("iframe_pdf_plc_'.$this->url.'").src = "'.base_url().'processor/plc/report/prioritas/prareg?action=print_xls&imonth="+imonth+"&iyear="+iyear+"&iteambusdev_id="+iteambusdev_id+"&iteampd_id="+iteampd_id;
				}
			}
			
		</script>
		';
		$button['save'] = $btn_preview;
		return $button;
	}
	
	public function printpdf(){
		$this->load->helper('to_pdf');
		$imonth  = $this->input->get('imonth');
		$iyear = $this->input->get('iyear');
		$iteambusdev_id = $this->input->get('iteambusdev_id');
		$iteampd_id = $this->input->get('iteampd_id');
		
                $sql = "SELECT prd.iupb_id, u.vupb_nomor, u.vupb_nama, u.vgenerik,
				(SELECT ku.vkategori FROM plc2.plc2_upb_master_kategori_upb ku WHERE ku.ikategori_id=u.ikategoriupb_id) AS kategupb,
				CASE
				 WHEN u.iappbusdev_prareg=2 THEN 'Done'
				 WHEN u.iappbusdev_prareg=0 THEN 'On Progress'
				 END AS statusprareg, pr.tappbusdev as tglprioritas
				FROM plc2.plc2_upb_prioritas pr 
				INNER JOIN plc2.plc2_upb_prioritas_detail prd ON pr.iprioritas_id=prd.iprioritas_id AND prd.ldeleted=0
				INNER JOIN plc2.plc2_upb u ON u.iupb_id=prd.iupb_id
				WHERE pr.imonth='".$imonth."' AND pr.iyear='".$iyear."' AND pr.iteambusdev_id='".$iteambusdev_id."' AND pr.ldeleted=0 AND prd.iteampd_id='".$iteampd_id."'";
               

		$data['datanya'] = $this->dbset->query($sql)->result_array();
		$output = $this->load->view('report_prioritas_prareg_pdf',$data,TRUE);
		pdf_create($output,$this->url.'_1.pdf',TRUE,'landscape');


	}
	public function preview_report($cssstyle=false) {                
        $imonth  = $this->input->get('imonth');
		$iyear = $this->input->get('iyear');
		$iteambusdev_id = $this->input->get('iteambusdev_id');
		$iteampd_id = $this->input->get('iteampd_id');
		
                $sql = "SELECT prd.iupb_id, u.vupb_nomor, u.vupb_nama, u.vgenerik,
				(SELECT ku.vkategori FROM plc2.plc2_upb_master_kategori_upb ku WHERE ku.ikategori_id=u.ikategoriupb_id) AS kategupb,
				CASE
				 WHEN u.iappbusdev_prareg=2 THEN 'Done'
				 WHEN u.iappbusdev_prareg=0 THEN 'On Progress'
				 END AS statusprareg, pr.tappbusdev as tglprioritas
				FROM plc2.plc2_upb_prioritas pr 
				INNER JOIN plc2.plc2_upb_prioritas_detail prd ON pr.iprioritas_id=prd.iprioritas_id AND prd.ldeleted=0
				INNER JOIN plc2.plc2_upb u ON u.iupb_id=prd.iupb_id
				WHERE pr.imonth='".$imonth."' AND pr.iyear='".$iyear."' AND pr.iteambusdev_id='".$iteambusdev_id."' AND pr.ldeleted=0 AND prd.iteampd_id='".$iteampd_id."'";
               
		$query = $this->db_plc0->query( $sql );

		
		
		
		$html = '';
		if($query->num_rows()>0) {
			$rows = $query->result_array();
			$html .= "<div style='width:100%;text-align:center;'>";
			$html .= '<h1>Report Setting Praregistrasi UPB</h1>';
			$html.='<div class="preview_report_table">';
			$html.='<table border="1" align="center">';
			$html.='<tr style="background:#87CEFA"><td style="width:100%;">No.</td><td width="50px">No. UPB </td><td width="300px">Generik</td><td width="200px">Usulan Nama Produk</td><td width="30px">Kategori</td><td width="100px">Tgl Prioritas</td><td width="30px">Status</td></tr>';
			$no=0;
			foreach($rows as $row) {
				$no++;
				
				$no_upb = $row['vupb_nomor'];
				$generik = $row['vgenerik'];
				$usulan = $row['vupb_nama'];
				$kategori = $row['kategupb'];
				$status = $row['statusprareg'];
				$tglprioritas=date('Y-m-d',strtotime($row['tglprioritas']));
				if(($row['tglprioritas']==null) or ($row['tglprioritas']=='0000-00-00') or ($row['tglprioritas']=='1970-01-01')){
					$tglprioritas='-';
				}
				$html.='<tr>';
				$html.='<td width="15px">'.$no.'</td>';
				$html.='<td width="50px">'.$no_upb.'</td>';
				$html.='<td width="300px">'.$generik.'</td>';
				$html.='<td width="200px">'.$usulan.'</td>';
				$html.='<td width="30px">'.$kategori.'</td>';
				$html.='<td width="30px">'.$tglprioritas.'</td>';
				$html.='<td width="30px">'.$status.'</td>';
			
				$html.='</tr>';
				
			}
			$html.='</table>';
			$html.='</div></div>';
			if($cssstyle) {
				$html.=$this->load->view('csstablegenerator', array('className'=>'preview_report_table'), TRUE);
			}
		}else{
			$html .= "<div style='width:100%;text-align:center;'>";
			$html .= '<h1>Report Setting Praregistrasi UPB</h1>';
			$html.='<div class="preview_report_table">';
			$html.='<table border="1" align="center" >';
			$html.='<tr style="background:#87CEFA"><td width="15px">No.</td><td width="50px">No. UPB </td><td width="300px">Generik</td><td width="200px">Usulan Nama Produk</td><td width="30px">Kategori</td><td width="30px">Status</td></tr>';
			$html.='</table>';
			$html.='</div>';
			if($cssstyle) {
				$html.=$this->load->view('csstablegenerator', array('className'=>'preview_report_table'), TRUE);
			}
		}
		
		return $html;
		
	}
	function preview_report1() {
		$this->load->helper('download');
		$this->load->library('auth');
		$this->user = $this->auth->user();
		$this->load->library('biz_process');
		$path = $this->config->item('report_path');
		$path .= 'plc/laporan/';
		
		$params = new Java("java.util.HashMap");
		
		
		$x=$this->auth->dept();
   		if($this->auth->is_manager()){
    		$x=$this->auth->dept();
    		$manager=$x['manager'];
    		if(in_array('BD', $manager)){$type='BD';}
			elseif(in_array('PD', $manager)){$type='PD';}
			elseif(in_array('QA', $manager)){$type='QA';}
			elseif(in_array('QC', $manager)){$type='QC';}
			elseif(in_array('DR', $manager)){$type='DR';}
			
			
			elseif(in_array('AD', $manager)){$type='AD';}
			elseif(in_array('FA', $manager)){$type='FA';}
			elseif(in_array('MR', $manager)){$type='MR';}
			elseif(in_array('BIC', $manager)){$type='BIC';}
			elseif(in_array('MIS', $manager)){$type='MIS';}
			
			else{$type='';}
    	}
		else{
			$x=$this->auth->dept();
    		$team=$x['team'];
			if(in_array('BD', $team)){$type='BD';}
			elseif(in_array('PD', $team)){$type='PD';}
			elseif(in_array('QA', $team)){$type='QA';}
			elseif(in_array('QC', $team)){$type='QC';}
			elseif(in_array('DR', $team)){$type='DR';}
			
			
			elseif(in_array('AD', $manager)){$type='AD';}
			elseif(in_array('FA', $manager)){$type='FA';}
			elseif(in_array('MR', $manager)){$type='MR';}
			elseif(in_array('BIC', $manager)){$type='BIC';}
			elseif(in_array('MIS', $manager)){$type='MIS';}
			else{$type='';}
		}
		// $team=$x['team'];
		// if(in_array('BD', $team)){$type='BD';}
		// elseif(in_array('PD', $team)){$type='PD';}
		// elseif(in_array('DR', $team)){$type='DR';}
		// else{$type='';}
		
		if($type=='PD' || $type=='QA'|| $type=='QC'|| $type=='DR'){
			$params->put('imonth', intval($this->input->get('imonth')));
			$params->put('iyear', intval($this->input->get('iyear')));
			$params->put('iteampd_id', intval($this->input->get('iteampd_id')));
			$params->put('SUBREPORT_DIR', $path);
			$reportAsal   = "report_prareg_all.jrxml";
			$reportTujuan = "Rpt_Prioritas_Prareg_UPB_Tahun ".(intval($this->input->get('iyear')))." Semester ".(intval($this->input->get('imonth'))).".".(intval($this->input->get('format')) == 1 ? "pdf" : "xls");

		}
		elseif($type=='BD'){
			//echo $this->auth->my_teams();
			$timbd=$this->auth->my_teams();
			$params->put('imonth', intval($this->input->get('imonth')));
			$params->put('iyear', intval($this->input->get('iyear')));
			//$params->put('iteambusdev_id', intval($timbd[2]));
			$params->put('iteambusdev_id', intval($this->input->get('iteambusdev_id')));
			$params->put('iteampd_id', intval($this->input->get('iteampd_id')));
			$reportAsal   = "report_prareg.jrxml";
			$reportTujuan = "Rpt_Prioritas_Registrasi_UPB_Tahun ".(intval($this->input->get('iyear')))." Semester ".(intval($this->input->get('imonth'))).".".(intval($this->input->get('format')) == 1 ? "pdf" : "xls");

		}else{
			$params->put('imonth', intval($this->input->get('imonth')));
			$params->put('iyear', intval($this->input->get('iyear')));
			$params->put('iteambusdev_id', intval($this->input->get('iteambusdev_id')));
			$params->put('iteampd_id', intval($this->input->get('iteampd_id')));
			$reportAsal   = "report_prareg.jrxml";
			$reportTujuan = "Rpt_Prioritas_Registrasi_UPB_Tahun ".(intval($this->input->get('iyear')))." Semester ".(intval($this->input->get('imonth'))).".".(intval($this->input->get('format')) == 1 ? "pdf" : "xls");
		
		}
		// echo $this->report->showReport($path, $reportAsal, $reportTujuan, $params, $this->input->get('format'));	
		 $nama_file = explode('.', $reportAsal);		
         //echo $path;
		 
		 $this->report->showReport($path, $reportAsal, $reportTujuan, $params, $this->input->get('format'));	
		 $open_file = file_get_contents($path.$reportTujuan);

		 force_download($nama_file[0], $open_file);			
	}
}
?>
