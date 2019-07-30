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
		$grid->addFields('iteambusdev_id','imonth','iyear','iteampd_id','format','priview');

		$grid->setLabel('imonth', 'Semester');
		$grid->setLabel('iyear', 'Tahun');
		$grid->setLabel('iteambusdev_id', 'Tim Busdev');
		$grid->setLabel('iteampd_id', 'Tim PD');
	
	
		switch ($action) {		
			case 'create':
				$grid->render_form();
				break;
			case 'get_preview_report' :
				
				//$iupb_id=$this->input->get('iupb');
				//$this->load->library('m_pdf');
				//$pdf = $this->m_pdf->load('c', 'A4');
				$id=$this->input->get("id");
				
				$html = $this->form_cetak_petunjuk($this->input->get());
				echo $html;

				//$this->preview_report();
				break;
			case 'get_preview_report2':
				//$iupb_id=$this->input->get('iupb');
				$this->load->library('m_pdf');
				$pdf = $this->m_pdf->load('c', 'A4');
				$id=$this->input->get("id");
				
				$format = $this->input->get('format');
				if($format==2){
					header("Content-type: application/vnd-ms-excel");
        			header("Content-Disposition: attachment; filename=report_history_upb_new_oke.xls");
					$html = $this->form_cetak_petunjuk2($this->input->get()); 
				 	echo $html;
				}else{
					$pdffile = "report_history_upb_new_".date('Y-m-d H:i:s').".pdf";
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
				<option value="">--Select--</option>
				<option value="1">PDF</option>
				<option value="2">EXCEL</option>
			</select>
		';
		
		return $o;
	}

	public function insertBox_report_history_upb_new_priview($field, $id) {
		$o = '<div id="rpt_history_upb_priview_new" class="rpt_history_upb_priview_new"></div>';
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
					var iteampd_id = $("#'.$this->url.'_iteampd_id option:selected").val();
					var imonth = $("#'.$this->url.'_imonth option:selected").val();
					var iyear = $("#'.$this->url.'_iyear option:selected").val();
					var iteambusdev_id = $("#'.$this->url.'_iteambusdev_id option:selected").val(); 
 					
 					if(imonth == ""){
						alert("Pilih Semester !!");
						$("#'.$this->url.'_imonth").focus(); 
						return false;
					}else if(iyear == ""){
						alert("Pilih Semester !!");
						$("#'.$this->url.'_imonth").focus(); 
						return false;
					} else{
						$.ajax({
							url: base_url+"processor/plc/report/history/upb/new?action=get_preview_report&imonth="+imonth+"&iyear="+iyear+"&iteampd_id="+iteampd_id+"&iteambusdev_id="+iteambusdev_id,
							beforeSend: function() {
		                    	$(".rpt_history_upb_priview_new").html("J u s t  a m i n u t e ...");
		                  	},
							success: function(data) { 
								$(".rpt_history_upb_priview_new").html(data);
							}
						});	 
					}

					 
						 
				}		
			</script>
		';
		$btn_download ='
			<script type="text/javascript">
				$(document).ready(function() {					
				});	 
				function print2_'.$this->url.'()	{
					var iteampd_id = $("#'.$this->url.'_iteampd_id option:selected").val();
					var imonth = $("#'.$this->url.'_imonth option:selected").val();
					var iyear = $("#'.$this->url.'_iyear option:selected").val();
					var iteambusdev_id = $("#'.$this->url.'_iteambusdev_id option:selected").val(); 
					var format = $("#'.$this->url.'_format option:selected").val(); 

					if (format == "") {
						alert("Pilih Format Laporan !!");
						$("#'.$this->url.'_format").focus(); 
						return false;
					}else if(imonth == ""){
						alert("Pilih Semester !!");
						$("#'.$this->url.'_imonth").focus(); 
						return false;
					}else if(iyear == ""){
						alert("Pilih Semester !!");
						$("#'.$this->url.'_imonth").focus(); 
						return false;
					} else{ 
						window.open(base_url+"processor/plc/report/history/upb/new?action=get_preview_report2&imonth="+imonth+"&iyear="+iyear+"&iteampd_id="+iteampd_id+"&iteambusdev_id="+iteambusdev_id+"&format="+format,"_blank")
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
		$imonth=$get['imonth'];
		$iyear=$get['iyear'];
		$iteampd_id=$get['iteampd_id'];
		$iteambusdev_id=$get['iteambusdev_id'];  

		$where="";
		if($iteampd_id!=""){
			$where.=" AND p.iteampd_id = ".$iteampd_id;
		}
		if($iteambusdev_id!=""){
			$where.=" AND p.iteambusdev_id = ".$iteambusdev_id;
		} 

		$where2="";
		$where1="";
		if($imonth!=""){
			$where1.=" AND p2.`imonth` = ".$imonth;
		}
		if($iyear!=""){
			$where2.=" AND p2.`iyear` = ".$iyear;
		} 

		// $sqlIN = "SELECT DISTINCT(pd.`iupb_id`) FROM plc2.`plc2_upb_prioritas` p JOIN
		// 	plc2.`plc2_upb_prioritas_detail` pd ON pd.`iprioritas_id` = p.`iprioritas_id` 
		// 	WHERE p.`ldeleted` = 0 AND p.`imonth` = 1 AND p.`iyear` = 2017 
		// 	AND p.`iappbusdev` = 2 AND p.`ldeleted` = 0";

		$sqlp = "SELECT p.* FROM plc2.`plc2_upb` p WHERE p.`ldeleted` = 0 AND p.`iKill` = 0 and p.ihold = 0 AND 
			p.itipe_id not in (6) AND p.iupb_id IN(SELECT DISTINCT(pd.`iupb_id`) 
				FROM plc2.`plc2_upb_prioritas` p2 JOIN
					plc2.`plc2_upb_prioritas_detail` pd ON pd.`iprioritas_id` = p2.`iprioritas_id` 
					WHERE p2.`ldeleted` = 0 ".$where1." ".$where2." AND p2.`iappbusdev` = 2 AND p2.`ldeleted` = 0 AND pd.`ldeleted`= 0) 
				".$where;
		
		// echo $sqlp;
		// exit;
		$data['iyear'] = $iyear;
		$data['imonth'] = $imonth;
		$data['row']=$this->dbset->query($sqlp)->result_array();
		$o=$this->load->view("report/nonotc/new/report_history_upb",$data,TRUE);
		return $o;
	}

	public function form_cetak_petunjuk2($get){
		$imonth=$get['imonth'];
		$iyear=$get['iyear'];
		$iteampd_id=$get['iteampd_id'];
		$iteambusdev_id=$get['iteambusdev_id']; 
	 	$where="";
		if($iteampd_id!=""){
			$where.=" AND p.iteampd_id = ".$iteampd_id;
		}
		if($iteambusdev_id!=""){
			$where.=" AND p.iteambusdev_id = ".$iteambusdev_id;
		} 

		$where2="";
		$where1="";
		if($imonth!=""){
			$where1.=" AND p2.`imonth` = ".$imonth;
		}
		if($iyear!=""){
			$where2.=" AND p2.`iyear` = ".$iyear;
		} 

		// $sqlp = "SELECT p.* FROM plc2.`plc2_upb` p WHERE p.`ldeleted` = 0 AND p.`iKill` = 0 and p.ihold = 0 AND 
		// p.itipe_id not in (6) ".$where;

		$sqlp = "SELECT p.* FROM plc2.`plc2_upb` p WHERE p.`ldeleted` = 0 AND p.`iKill` = 0 and p.ihold = 0 AND 
			p.itipe_id not in (6) AND p.iupb_id IN(SELECT DISTINCT(pd.`iupb_id`) 
				FROM plc2.`plc2_upb_prioritas` p2 JOIN
					plc2.`plc2_upb_prioritas_detail` pd ON pd.`iprioritas_id` = p2.`iprioritas_id` 
					WHERE p2.`ldeleted` = 0 ".$where1." ".$where2." AND p2.`iappbusdev` = 2 AND p2.`ldeleted` = 0 AND pd.`ldeleted`= 0) 
				".$where;
		$data['iyear'] = $iyear;
		$data['imonth'] = $imonth;
		$data['row']=$this->dbset->query($sqlp)->result_array();
		$o=$this->load->view("report/nonotc/new/report_history_upb_print",$data,TRUE);
		return $o;
	}
}
?>
