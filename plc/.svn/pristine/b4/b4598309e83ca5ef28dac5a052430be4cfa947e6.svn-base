<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class report_history_upb_new extends MX_Controller {
	private $sess_auth;
	private $dbset;
	private $urutan = 0;
	private $report;
			
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('auth');
		$this->user = $this->auth->user();
		$this->load->library('biz_process');
		$this->load->helper('tanggal');
		$this->load->model('user_model');
        $this->url = 'report_history_upb_new'; 
		$this->dbset = $this->load->database('plc', true);
		$this->report = $this->load->library('report');
    }
    function index($action = '') {		
    	//Bikin Object Baru Nama nya $grid
    	$action = $this->input->get('action') ? $this->input->get('action') : 'create';		
		$grid = new Grid;		
		$grid->setTitle('Laporan History UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('report_history_upb_new');		
		$grid->addFields('iteambusdev_id','imonth','iyear','iteampd_id','format');
		//$grid->addFields('ttanggal','iupb_id','format');
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
			default:
				$grid->render_grid();
				break;
		}
    }
	public function output(){
		$this->index('create');
	}
	
	public function insertBox_report_history_upb_new_imonth($field, $id) {
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--All--</option>';
		for($i=1; $i<=2; $i++) {
			$echo .= '<option value="'.$i.'">Semester '.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	
	public function insertBox_report_history_upb_new_iyear($field, $id){
		$thn_sekarang = date('Y');
		$mulai = $thn_sekarang-3; //dari -2 diganti -3
		$sampai = $thn_sekarang+7;
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--All--</option>';
		for($i=$mulai; $i<=$sampai; $i++) {
			$echo .= '<option value="'.$i.'">'.$i.'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	public function insertBox_report_history_upb_new_iteambusdev_id($field, $id){
		$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'BD'  AND d.ldeleted = 0 ORDER BY d.vteam ASC ";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--All--</option>';
		foreach($teams as $t) {
			 $echo .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
		}
		 $echo .= '</select>';
		 return $echo;
	 }
	public function insertBox_report_history_upb_new_iteampd_id($field, $id){
		$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'PD' AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
		$teams = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="required" id="'.$id.'" name="'.$id.'">';
		$echo .= '<option value="">--All--</option>';
		foreach($teams as $t) {
			$echo .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
		}
		$echo .= '</select>';
		return $echo;
	}
	public function insertBox_report_history_upb_new_format($field, $id) {
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
		$btn_preview  = '
			<script type="text/javascript">
				$(document).ready(function() {					
				});		
				
				function print_'.$this->url.'()	{
					var iteampd_id = $("#'.$this->url.'_iteampd_id option:selected").val();
					var imonth = $("#'.$this->url.'_imonth option:selected").val();
					var iyear = $("#'.$this->url.'_iyear option:selected").val();
					var iteambusdev_id = $("#'.$this->url.'_iteambusdev_id option:selected").val(); 
					var format = $("#'.$this->url.'_format option:selected").val();
					
					if (format == "") {
						alert("Pilih Format Laporan !!");
						$("#'.$this->url.'_format").focus(); 
						return false;
					} else {	
						//document.getElementById("iframe_preview_'.$this->url.'").src = "'.base_url().'processor/plc/report/history/upb/new?action=get_preview_report&iupb="+iupb+"&format="+format+"&tanggal1="+tanggal1_+"&tanggal2="+tanggal2_;
						document.getElementById("iframe_preview_'.$this->url.'").src = "'.base_url().'processor/plc/report/history/upb/new?action=get_preview_report&imonth="+imonth+"&format="+format+"&iyear="+iyear+"&iteampd_id="+iteampd_id+"&iteambusdev_id="+iteambusdev_id;
					}
				}		
			</script>
		';
		 
		$btn_preview .= '<button onclick="javascript:print_'.$this->url.'();" class="ui-button-text icon-save" id="button_preview_'.$this->url.'">Preview</button>
						<iframe height="0" width="0" id="iframe_preview_'.$this->url.'"></iframe> ';
		
		$button['save'] = $btn_preview;
		return $button;
	}

	
	function preview_report() {
		$this->load->helper('download');
		
		$bulan='';
		$tahun ='';
		$bede ='';
		$pede = '';

		if ($this->input->get('iteampd_id') != '') {
			$pede=intval($this->input->get('iteampd_id'));
		}

		if ($this->input->get('iteambusdev_id') != '') {
			$bede=intval($this->input->get('iteambusdev_id'));
		}

		if ($this->input->get('iyear') != '') {
			$tahun=intval($this->input->get('iyear'));
		}
		
		if ($this->input->get('imonth') != '') {
			$bulan=intval($this->input->get('imonth'));
		}


		$path = $this->config->item('report_path');
		$path .= 'plc/laporan/';
		$params = new Java("java.util.HashMap");
		

			$params->put('timpd', $pede);
			$params->put('timbd', $bede);
			$params->put('tahun', $tahun  );
			$params->put('semester', $bulan );
			$params->put('SUBREPORT_DIR', $path);
			$reportAsal   = "rpt_history_upb_all_new.jrxml";
			$reportTujuan = "Rpt_History_UPB_".intval($this->input->get('iyear'))."_".intval($this->input->get('imonth')).".".(intval($this->input->get('format')) == 1 ? "pdf" : "xls");
		//echo $reportTujuan;
		$nama_file = explode('.', $reportAsal);		
		
		//echo $path;
		$this->report->showReport($path, $reportAsal, $reportTujuan, $params, $this->input->get('format'));	
		$open_file = file_get_contents($path.$reportTujuan);

		force_download($nama_file[0], $open_file);			
	}
}
?>
