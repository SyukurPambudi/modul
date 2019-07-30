<?php 
error_reporting(E_ALL);
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class report_detail_upb extends MX_Controller {
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
        $this->url = 'report_detail_upb'; 
		$this->dbset = $this->load->database('plc', true);
		$this->report = $this->load->library('report');
    }
    function index($action = '') {		
    	//Bikin Object Baru Nama nya $grid
    	$action = $this->input->get('action') ? $this->input->get('action') : 'create';		
		$grid = new Grid;		
		$grid->setTitle('Laporan Detail UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('report_detail_upb');		
		$grid->addFields('iupb_id','format');
		$grid->setLabel('iupb_id', 'Nomor UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
	
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
		//echo '1';
	}
	public function insertBox_report_detail_upb_iupb_id($field, $id) {
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upb/detail?field=report_detail_upb\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	
	public function insertBox_report_detail_upb_format($field, $id) {
		$o = '
			<select name="'.$id.'" id="'.$id.'">
				<option value="">--Select--</option>
				<option value="1">PDF</option>
				<option value="2">XLS</option>
			</select>
		';
		
		return $o;
	}

	public function updateBox_report_detail_upb_format($field, $id) {
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
								
					if (iupb == "") {
						alert("Pilih UPB !!");
						$("#'.$this->url.'_iupb_id").focus();
						
						return false;
					}
					if (format == "") {
						alert("Pilih Format Laporan !!");
						$("#'.$this->url.'_format").focus();
						
						return false;
					} else {	
						document.getElementById("iframe_preview_'.$this->url.'").src = "'.base_url().'processor/plc/report/detail/upb?action=get_preview_report&iupb="+iupb+"&format="+format;
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
		
		$path = $this->config->item('report_path');
		$path .= 'plc/laporan/';
		
		$params = new Java("java.util.HashMap");
		$params->put('iupb_id', intval($this->input->get('iupb')));
		$params->put('SUBREPORT_DIR', $path);
		
		$reportAsal   = "rpt_detail_upb.jrxml";
		$reportTujuan = "Rpt_Detail_UPB_".(intval($this->input->get('iupb'))).".".(intval($this->input->get('format')) == 1 ? "pdf" : "xls");
		
		
		$nama_file = explode('.', $reportAsal);		
                
                
		 //echo $path;
		 //echo intval($this->input->get('iupb'));
		// echo $reportTujuan;
		 //exit;
		 echo $this->report->showReport($path, $reportAsal, $reportTujuan, $params, $this->input->get('format'));	
		$open_file = file_get_contents($path.$reportTujuan);

		force_download($nama_file[0], $open_file);			
	}
}
?>
