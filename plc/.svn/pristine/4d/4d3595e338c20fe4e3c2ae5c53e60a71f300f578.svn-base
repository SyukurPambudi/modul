<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class report_history_upb_new_prioritas extends MX_Controller {
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
        $this->url = 'report_history_upb_new_prioritas'; 
		$this->dbset = $this->load->database('plc', true);
		$this->report = $this->load->library('report');
    }
    function index($action = '') {		
    	//Bikin Object Baru Nama nya $grid
    	$action = $this->input->get('action') ? $this->input->get('action') : 'create';		
		$grid = new Grid;		
		$grid->setTitle('Laporan History Setting Prioritas');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('report_history_upb_new_prioritas');		
		$grid->addFields('ttanggal','iteambusdev_id','iupb_id','format','priview');
		$grid->setLabel('ttanggal', 'Periode Approval Setting Prioritas');
		$grid->setLabel('iupb_id', 'Nomor UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('iteambusdev_id', 'Tim Busdev');
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
					header("Content-type: application/vnd-ms-excel");
        			header("Content-Disposition: attachment; filename=report_history_upb_new_prioritas_oke.xls");
					$html = $this->form_cetak_petunjuk2($this->input->get()); 
				 	echo $html;
				}else{
					$pdffile = "report_history_upb_new_prioritas_".date('Y-m-d H:i:s').".pdf";
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
	public function insertBox_report_history_upb_new_prioritas_ttanggal($field, $id) {
		$o = '
			<input type="text" class="input_tgl datepicker" id="'.$id.'_1" name="'.$field.'_1"/> s/d 
			<input type="text" class="input_tgl datepicker" id="'.$id.'_2" name="'.$field.'_2"/> 
		';
		
		return $o;
	}
	public function insertBox_report_history_upb_new_prioritas_iupb_id($field, $id) {
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upb/detail?field=report_history_upb_new_prioritas\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	public function insertBox_report_history_upb_new_prioritas_iteambusdev_id($field, $id){
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
	public function insertBox_report_history_upb_new_prioritas_iteampd_id($field, $id){
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
	
	public function insertBox_report_history_upb_new_prioritas_format($field, $id) {
		$o = '
			<select name="'.$id.'" id="'.$id.'">
				<option value="">--Select--</option>
				<option value="1">PDF</option> 
				<option value="2">Excel</option> 
			</select>
		';
		
		return $o;
	}

	public function insertBox_report_history_upb_new_prioritas_priview($field, $id) {
		$o = '<div id="rpt_history_upb_priview" class="rpt_history_upb_priview"></div>';
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
					var tanggal1 = ($("#report_history_upb_new_prioritas_ttanggal_1").val()).split("-");
					var tanggal2 = ($("#report_history_upb_new_prioritas_ttanggal_2").val()).split("-"); 
					var iteambusdev_id = $("#'.$this->url.'_iteambusdev_id option:selected").val(); 

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
					 
						$.ajax({
							url: base_url+"processor/plc/report/history/upb/new/prioritas?action=get_preview_report&iupb="+iupb+"&iteambusdev_id="+iteambusdev_id+"&format="+format+"&tanggal1="+tanggal1_+"&tanggal2="+tanggal2_,
							beforeSend: function() {
		                    	$(".rpt_history_upb_priview").html("J u s t  a m i n u t e ...");
		                  	},
							success: function(data) {
								$("#rpt_history_upb_priview").html(data);
							}
						});	
						//document.getElementById("iframe_preview_'.$this->url.'").src = "'.base_url().'processor/plc/report/history/upb/new/prioritas?action=get_preview_report&iteampd_id="+pede+"&iteambusdev_id="+bede+"&iupb="+iupb+"&format="+format+"&tanggal1="+tanggal1_+"&tanggal2="+tanggal2_; 
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
					var tanggal1 = ($("#report_history_upb_new_prioritas_ttanggal_1").val()).split("-");
					var tanggal2 = ($("#report_history_upb_new_prioritas_ttanggal_2").val()).split("-"); 
					var iteambusdev_id = $("#'.$this->url.'_iteambusdev_id option:selected").val(); 
					
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
					}else{	
						window.open(base_url+"processor/plc/report/history/upb/new/prioritas?action=get_preview_report2&iupb="+iupb+"&iteambusdev_id="+iteambusdev_id+"&format="+format+"&tanggal1="+tanggal1_+"&tanggal2="+tanggal2_,"_blank")
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
		
		$tgl1=$get['tanggal1'];
		$tgl2=$get['tanggal2']; 
		$iupb=$get['iupb'];
		$iteambusdev_id=$get['iteambusdev_id']; 

		$where2="";
		$where1="";
		$where3="";
		if($iupb!=''){
			$where1 =" AND p.iupb_id=".$iupb;
		}

		if($tgl1=='undefined-undefined-'){
			$tgl1='';
		}
		if($tgl2=='undefined-undefined-'){
			$tgl2='';
		}

		if($iteambusdev_id!=""){
			$where3 =" AND p2.iteambusdev_id = ".$iteambusdev_id;
		} 

		if($tgl1!='' and $tgl2!=''){
			$where2 =" AND(date(p2.`tappbusdev`) BETWEEN '".$tgl1."' AND '".$tgl2."')";
		}

		$sqlp1 = "SELECT p.`iupb_id`, p2.`tappbusdev`, p2.`iteambusdev_id`, p2.`iyear`, p2.`imonth`
		FROM plc2.`plc2_upb` p 
		JOIN plc2.`plc2_upb_prioritas_detail` p1 ON p.`iupb_id` = p1.`iupb_id`
		JOIN plc2.`plc2_upb_prioritas` p2 ON p2.`iprioritas_id` = p1.`iprioritas_id`
		WHERE p1.`ldeleted` = 0 AND p2.`ldeleted` = 0 AND p.`ldeleted` = 0 AND p.`iKill` = 0 ".$where2." ".$where3." "; 

		$sqlp2 = "SELECT p.`iupb_id`, COUNT(p.`vupb_nomor`) as row, p.`vupb_nomor`, p.`vupb_nama`
		FROM plc2.`plc2_upb` p 
		JOIN plc2.`plc2_upb_prioritas_detail` p1 ON p.`iupb_id` = p1.`iupb_id`
		JOIN plc2.`plc2_upb_prioritas` p2 ON p2.`iprioritas_id` = p1.`iprioritas_id`
		WHERE p1.`ldeleted` = 0 AND p2.`ldeleted` = 0 AND p.`ldeleted` = 0 AND p.`iKill` = 0  ".$where1." ".$where3." ".$where2."
		GROUP BY p.`iupb_id` "; 

		

		$data['query']=$sqlp1;
		$data['rowdata']=$this->dbset->query($sqlp2)->result_array();

		$o=$this->load->view("report/nonotc/report_history_upb_new_prioritas",$data,TRUE);
		return $o;
	}

	public function form_cetak_petunjuk2($get){  
		$tgl1=$get['tanggal1'];
		$tgl2=$get['tanggal2']; 
		$iupb=$get['iupb']; 
		$iteambusdev_id=$get['iteambusdev_id']; 

		$where2="";
		$where1="";
		$where3="";
		if($iupb!=''){
			$where1 =" AND p.iupb_id=".$iupb;
		}

		if($iteambusdev_id!=""){
			$where3 =" AND p2.iteambusdev_id = ".$iteambusdev_id;
		} 

		if($tgl1=='undefined-undefined-'){
			$tgl1='';
		}
		if($tgl2=='undefined-undefined-'){
			$tgl2='';
		}

		if($tgl1!='' and $tgl2!=''){
			$where2 =" AND(date(p2.`tappbusdev`) BETWEEN '".$tgl1."' AND '".$tgl2."')";
		} 

		$sqlp1 = "SELECT p.`iupb_id`, p2.`tappbusdev`, p2.`iteambusdev_id`, p2.`iyear`, p2.`imonth`
		FROM plc2.`plc2_upb` p 
		JOIN plc2.`plc2_upb_prioritas_detail` p1 ON p.`iupb_id` = p1.`iupb_id`
		JOIN plc2.`plc2_upb_prioritas` p2 ON p2.`iprioritas_id` = p1.`iprioritas_id`
		WHERE p1.`ldeleted` = 0 AND p2.`ldeleted` = 0 AND p.`ldeleted` = 0 AND p.`iKill` = 0 ".$where2." ".$where3." "; 

		$sqlp2 = "SELECT p.`iupb_id`, COUNT(p.`vupb_nomor`) as row, p.`vupb_nomor`, p.`vupb_nama`
		FROM plc2.`plc2_upb` p 
		JOIN plc2.`plc2_upb_prioritas_detail` p1 ON p.`iupb_id` = p1.`iupb_id`
		JOIN plc2.`plc2_upb_prioritas` p2 ON p2.`iprioritas_id` = p1.`iprioritas_id`
		WHERE p1.`ldeleted` = 0 AND p2.`ldeleted` = 0 AND p.`ldeleted` = 0 AND p.`iKill` = 0  ".$where1." ".$where3." ".$where2."
		GROUP BY p.`iupb_id` "; 

		$data['query']=$sqlp1;
		$data['rowdata']=$this->dbset->query($sqlp2)->result_array();

		$o=$this->load->view("report/nonotc/report_history_upb_new_prioritas",$data,TRUE); 
		return $o;
	}
}
?>
