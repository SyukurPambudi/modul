<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class report_history_upb extends MX_Controller {
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
        $this->url = 'report_history_upb'; 
		$this->dbset = $this->load->database('plc', true);
		$this->report = $this->load->library('report');
    }
    function index($action = '') {		
    	//Bikin Object Baru Nama nya $grid
    	$action = $this->input->get('action') ? $this->input->get('action') : 'create';		
		$grid = new Grid;		
		$grid->setTitle('Laporan History UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('report_history_upb');		
		$grid->addFields('ttanggal','iupb_id','iteambusdev_id','iteampd_id','format');
		$grid->setLabel('ttanggal', 'Periode UPB');
		$grid->setLabel('iupb_id', 'Nomor UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
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
	public function insertBox_report_history_upb_ttanggal($field, $id) {
		$o = '
			<input type="text" class="input_tgl datepicker" id="'.$id.'_1" name="'.$field.'_1"/> s/d 
			<input type="text" class="input_tgl datepicker" id="'.$id.'_2" name="'.$field.'_2"/> 
		';
		
		return $o;
	}
	public function insertBox_report_history_upb_iupb_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="35" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upb/detail?field=report_history_upb\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	public function insertBox_report_history_upb_iteambusdev_id($field, $id){
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
	public function insertBox_report_history_upb_iteampd_id($field, $id){
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
	
	public function insertBox_report_history_upb_format($field, $id) {
		$o = '
			<select name="'.$id.'" id="'.$id.'">
				<option value="">--Select--</option>
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
					var iupb = $("#'.$this->url.'_iupb_id").val();
					var format = $("#'.$this->url.'_format option:selected").val();
					var tanggal1 = ($("#report_history_upb_ttanggal_1").val()).split("-");
					var tanggal2 = ($("#report_history_upb_ttanggal_2").val()).split("-");
					var pede = $("#'.$this->url.'_iteampd_id").val();
					var bede = $("#'.$this->url.'_iteambusdev_id").val();
					
					var tanggal1_ = tanggal1[2]+"-"+tanggal1[1]+"-"+tanggal1[0];
					var tanggal2_ = tanggal2[2]+"-"+tanggal2[1]+"-"+tanggal2[0];
								
					if (tanggal1_.length != 10 && tanggal1_!="undefined-undefined-") { //jika tgl diisi
						alert("Periode I tidak valid"+tanggal1_);
						return false;
					}
					
					if (tanggal2_.length != 10 && tanggal2_!="undefined-undefined-") { //jika tgl diisi
						alert("Periode II tidak valid");
						return false;
					}
							
					if (tanggal2_ < tanggal1_) {
						alert("Rentang Periode tidak valid");
						return false;
					}
					if ((tanggal2_ == "undefined-undefined-")&&(iupb == "")&&(tanggal1_ == "undefined-undefined-")){
						alert("Pilih Nomor UPB atau Periode !!");
						$("#'.$this->url.'_iupb_id").focus();
						
						return false;
					}
					if (format == "") {
						alert("Pilih Format Laporan !!");
						$("#'.$this->url.'_format").focus();
						
						return false;
					} else {	
						document.getElementById("iframe_preview_'.$this->url.'").src = "'.base_url().'processor/plc/report/history/upb?action=get_preview_report&iteampd_id="+pede+"&iteambusdev_id="+bede+"&iupb="+iupb+"&format="+format+"&tanggal1="+tanggal1_+"&tanggal2="+tanggal2_;
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
		$bede ='';
		$pede = '';
		if ($this->input->get('iteampd_id') != '') {
			$pede=intval($this->input->get('iteampd_id'));
		}

		if ($this->input->get('iteambusdev_id') != '') {
			$bede=intval($this->input->get('iteambusdev_id'));
		}

		$path = $this->config->item('report_path');
		$path .= 'plc/laporan/';
		
		//echo $this->input->get('iupb');
		$params = new Java("java.util.HashMap");
		if($this->input->get('iupb')==null || $this->input->get('iupb')==0){
			$params->put('iteampd', $pede);
			$params->put('iteambd', $bede);
			$params->put('tanggal1', date('Y-m-d', strtotime($this->input->get('tanggal1'))));
			$params->put('tanggal2', date('Y-m-d', strtotime($this->input->get('tanggal2'))));
			$params->put('SUBREPORT_DIR', $path);
			$reportAsal   = "rpt_history_upb_all.jrxml";
			$reportTujuan = "Rpt_History_UPB_".date('Y-m-d', strtotime($this->input->get('tanggal1')))."_".date('Y-m-d', strtotime($this->input->get('tanggal2'))).".".(intval($this->input->get('format')) == 1 ? "pdf" : "xls");
		}
		else{
			$params->put('iteampd', $pede);
			$params->put('iteambusdev', $bede);
			$params->put('iupb_id', intval($this->input->get('iupb')));
			$params->put('SUBREPORT_DIR', $path);
			$reportAsal   = "rpt_history_upb.jrxml";
			$reportTujuan = "Rpt_History_UPB_".(intval($this->input->get('iupb'))).".".(intval($this->input->get('format')) == 1 ? "pdf" : "xls");
		}
		//echo $reportTujuan;
		$nama_file = explode('.', $reportAsal);		
		
		//echo $path;
		$this->report->showReport($path, $reportAsal, $reportTujuan, $params, $this->input->get('format'));	
		$open_file = file_get_contents($path.$reportTujuan);

		force_download($nama_file[0], $open_file);			
	}
}
?>
