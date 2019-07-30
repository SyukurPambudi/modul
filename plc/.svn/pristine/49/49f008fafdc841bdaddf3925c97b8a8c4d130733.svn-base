<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class report_history_sample_mikro_ad extends MX_Controller {
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
        $this->url = 'report_history_sample_mikro_ad'; 
		$this->dbset = $this->load->database('plc', true);
		$this->report = $this->load->library('report');
    }
    function index($action = '') {		
    	//Bikin Object Baru Nama nya $grid
    	$action = $this->input->get('action') ? $this->input->get('action') : 'create';		
		$grid = new Grid;		
		$grid->setTitle('History Sample, Mikrobiologi,dan Andev');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('report_history_sample_mikro_ad');		
		$grid->addFields('iupb_id','format','priview');
		$grid->setLabel('ttanggal', 'Periode UPB');
		$grid->setLabel('iupb_id', 'Nomor UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('ijenis', 'Jenis Data');
		$grid->setLabel('iteampd_id', 'Tim PD');
	
		switch ($action) {		
			case 'create':
				$grid->render_form();
				break;
			case 'get_preview_report' :
				
				$iupb_id=$this->input->get('iupb'); 
				$id=$this->input->get("id"); 
				$html = $this->form_cetak_petunjuk($this->input->get()); 
				echo $html; 
				break;
			case 'get_preview_report2':
				$iupb_id=$this->input->get('iupb');
				$this->load->library('m_pdf');
				$pdf = $this->m_pdf->load('c', 'A4');
				$id=$this->input->get("id");
				
				$format = $this->input->get('format');
				if($format==2){
					header("Content-type: application/x-msdownload");
        			header("Content-Disposition: attachment; filename=History_Pengadaan_Sample_Mikrobiologi_dan_BB_Andev_".date('Y-m-d H:i:s').".xls");
					$html = $this->form_cetak_petunjuk2($this->input->get()); 
				 	echo $html;
				}else{
					$pdffile = "History_Pengadaan_Sample_Mikrobiologi_dan_BB_Andev_".date('Y-m-d H:i:s').".pdf";
					$pdf->AddPage('L', // L - landscape, P - portrait
					'', '', '', '',
					2, // margin_left
					2, // margin right
					5, // margin top
					0, // margin bottom
					5, // margin header
					5); // margin footer
					$pdf->shrink_tables_to_fit = 0;
					$pdf->WriteHTML($this->form_cetak_petunjuk2($this->input->get())); 		
					$pdf ->Output($pdffile, "D");
				}

				break;

			default:
				$grid->render_grid();
				break;
		}
    }
	public function output(){
		$this->index('create');
	}
	public function insertBox_report_history_sample_mikro_ad_ttanggal($field, $id) {
		$o = '
			<input type="text" class="input_tgl datepicker" id="'.$id.'_1" name="'.$field.'_1"/> s/d 
			<input type="text" class="input_tgl datepicker" id="'.$id.'_2" name="'.$field.'_2"/> 
		';
		
		return $o;
	}
	public function insertBox_report_history_sample_mikro_ad_iupb_id($field, $id) {
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upb/detail?field=report_history_sample_mikro_ad\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	public function insertBox_report_history_sample_mikro_ad_iteambusdev_id($field, $id){
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
	public function insertBox_report_history_sample_mikro_ad_iteampd_id($field, $id){
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

	

	public function insertBox_report_history_sample_mikro_ad_ijenis($field, $id) {
		$o = '
			<select name="'.$id.'" id="'.$id.'"> 
				<option value="1">PD - Sourcing</option>
				<option value="2">Mikro</option>
				<option value="2">Andev - PD - QA</option>
			</select>
		';
		
		return $o;
	}
	
	public function insertBox_report_history_sample_mikro_ad_format($field, $id) {
		$o = '
			<select name="'.$id.'" id="'.$id.'">
				<option value="">--Select--</option>
				<option value="1">PDF</option>
				<option value="2">EXCEL</option>
			</select>
		';
		
		return $o;
	}

	public function insertBox_report_history_sample_mikro_ad_priview($field, $id) {
		$o = '<div id="rpt_history_upb_priview_mikro_dll" class="rpt_history_upb_priview_mikro_dll"></div>';
		$o.= '
			<script type="text/javascript">
				$("label[for=\''.$id.'\']").hide();
				$("label[for=\''.$id.'\']").next().css("margin-left",0);
			</script>
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
					var ijenis = $("#'.$this->url.'_ijenis").val();
					
				 
					if ((iupb == "")){
						alert("Pilih Nomor UPB dan Jenis !!");
						$("#'.$this->url.'_iupb_id").focus(); 
						return false;
					}
					 
						$.ajax({
							url: base_url+"processor/plc/report_history_sample_mikro_ad?action=get_preview_report&ijenis="+ijenis+"&iupb="+iupb+"&format="+format,
							beforeSend: function() {
		                    	$(".rpt_history_upb_priview_mikro_dll").html("J u s t  a m i n u t e ...");
		                  	},
							success: function(data) {
								$("#rpt_history_upb_priview_mikro_dll").html(data);
							}
						});	
						 
				}		
			</script>
		';
		$btn_download ='
			<script type="text/javascript">
				$(document).ready(function() {					
				});	 
				function print2_'.$this->url.'()	{
					var iupb = $("#'.$this->url.'_iupb_id").val();
					var format = $("#'.$this->url.'_format option:selected").val(); 
					var ijenis = $("#'.$this->url.'_ijenis").val();
					
				 
					if ((iupb == "")){
						alert("Pilih Nomor UPB dan Jenis !!");
						$("#'.$this->url.'_iupb_id").focus(); 
						return false;
					}

					if (format == "") {
						alert("Pilih Format Laporan !!");
						$("#'.$this->url.'_format").focus(); 
						return false;
					}else{	
						window.open(base_url+"processor/plc/report_history_sample_mikro_ad?action=get_preview_report2&ijenis="+ijenis+"&iupb="+iupb+"&format="+format,"_blank")
					}
				}		
			</script>
		';
		$btn_preview .= '<button onclick="javascript:print_'.$this->url.'();" class="ui-button-text icon-save" id="button_preview_'.$this->url.'">Preview</button> ';
		$btn_download .= '<button onclick="javascript:print2_'.$this->url.'();" class="ui-button-text icon-save" id="button_preview2_'.$this->url.'">Download</button> ';
		
		$button['save'] = $btn_preview.$btn_download;
		return $button;
	}


	
	public function form_cetak_petunjuk($get){
		 
		$iupb=$get['iupb'];
		$ijenis=$get['ijenis'];  
		$where=" AND p.iupb_id=".$iupb; 
		$sqlp = "SELECT p.* FROM plc2.`plc2_upb` p WHERE p.`ldeleted` = 0 AND p.`iKill` = 0 and p.ihold = 0 AND 
		p.itipe_id not in (6) ".$where;

		$data['row']=$this->dbset->query($sqlp)->row_array();
		
		$o=$this->load->view("report/nonotc/history/histori_data",$data,TRUE); 
		return $o;
	}

	public function form_cetak_petunjuk2($get){

		$iupb=$get['iupb'];
		$ijenis=$get['ijenis'];  
		$where=" AND p.iupb_id=".$iupb; 
		$sqlp = "SELECT p.* FROM plc2.`plc2_upb` p WHERE p.`ldeleted` = 0 AND p.`iKill` = 0 and p.ihold = 0 AND 
		p.itipe_id not in (6) ".$where;

		$data['row']=$this->dbset->query($sqlp)->row_array();
		
		$o=$this->load->view("report/nonotc/history/histori_data",$data,TRUE); 
		return $o; 
		 
	}
}
?>
