<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class report_kill_upi extends MX_Controller {
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
        $this->url = 'report_kill_upi'; 
		$this->dbset = $this->load->database('plc', true);
		$this->report = $this->load->library('report');
    }
    function index($action = '') {		
    	//Bikin Object Baru Nama nya $grid
    	$action = $this->input->get('action') ? $this->input->get('action') : 'create';		
		$grid = new Grid;		
		$grid->setTitle('Laporan Kill UPI');		
		$grid->setTable('plc2.daftar_upi');		
		$grid->setUrl('report_kill_upi');		

		$grid->addFields('dateKill','iupi_id','format');

		$grid->setLabel('dateKill', 'Periode UPI Kill');
		$grid->setLabel('iupi_id', 'Nomor UPI');
		$grid->setLabel('vNama_usulan', 'Nama Usulan');
	
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
	public function insertBox_report_kill_upi_dateKill($field, $id) {
		$o = '
			<input type="text" class="input_tgl datepicker" id="'.$id.'_1" name="'.$field.'_1"/> s/d 
			<input type="text" class="input_tgl datepicker" id="'.$id.'_2" name="'.$field.'_2"/> 
		';
		
		return $o;
	}
	public function insertBox_report_kill_upi_iupi_id($field, $id) {
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upi/detail?field=report_kill_upi\',\'List UPI\')" type="button">&nbsp;</button>';
		
		return $return;
	}

	
	public function insertBox_report_kill_upi_format($field, $id) {
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
					var iupb = $("#'.$this->url.'_iupi_id").val();
					
					var format = $("#'.$this->url.'_format option:selected").val();

					var tanggal1 = ($("#report_kill_upi_dateKill_1").val()).split("-");
					var tanggal2 = ($("#report_kill_upi_dateKill_2").val()).split("-");
					
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
						alert("Pilih Nomor UPI atau Periode !!");
						$("#'.$this->url.'_iupi_id").focus();
						
						return false;
					}
					if (format == "") {
						alert("Pilih Format Laporan !!");
						$("#'.$this->url.'_format").focus();
						
						return false;
					} else {	
						document.getElementById("iframe_preview_'.$this->url.'").src = "'.base_url().'processor/plc/report/kill/upi?action=get_preview_report&iupb="+iupb+"&format="+format+"&tanggal1="+tanggal1_+"&tanggal2="+tanggal2_;
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
		$this->load->library('m_pdf');
		$pdf = $this->m_pdf->load('c', 'A4-L');

		foreach($_GET as $key=>$value) {			

			if ($key == 'iupb') {
				$iupi = $value;
			}
			
			if ($key == 'format') {
				$format = $value;
			}

			
			if ($key == 'tanggal1') {
				$tgl1 = $value;
			}

			if ($key == 'tanggal2') {
				$tgl2 = $value;
			}
		}


		$html  = "<div>";
		$html  .= "<style>
					        body {
						            background-color: #FFFFFF;
						            color: #333333;
						            font-family: 'Calibri';
						            font-size: 10px;
						            margin: 0;
						            -moz-transform:rotate(90deg);
						        }
						        .box_pdf {
						            padding: 0px; margin: 0 auto; width: 100%;
						        }
						        .head_teks {
						            padding: 0px 0px 0px 0px; font-size: 12px; font-weight: bold; border-bottom: 4px double #000000;  margin-bottom: 2px;
						        }
						        .nama_kat {
						            color: #f82c04;
						        }
						        table {
						            background-color: transparent;
						            border-collapse: collapse;
						            border-spacing: 0;
						        }
						                .table {
						            margin-bottom: 18px;
						            width: 100%;
						        }
						                    .table-bordered {
						            border: 1px solid #000000;
						        }
						        .table-bordered th {
						            background-color: #89b9e0;
						            text-transform: uppercase; font-weight: bold; font-size: 10px; color: #FFFFFF;
						        }
						        .table-bordered th, .table-bordered tr {
						            border-left: 2px solid #000000; 
						        }
						        .table-bordered th, .table-bordered td {
						            border-left: 1px solid #000000; 
						        }
						        .table th, .table td {
						            border-top: 1px solid #000000;
						            line-height: 15px;
						            padding: 1px;
						            vertical-align: middle;
						        }
						        table .p_product {
						    background-color: #0E870B;
						}
				</style>";
		$html .= '<table autosize="2.4" align="center" width="100%" border="0" cellspacing="0" cellpadding="4">';
		$html .= '<tr>';
		$html .= '<td style="text-align:center;font-size:18px;font-weight:bold;" colspan="5" class="judul">Report KILL UPI</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		//if($iupi==""){
			$html .= '<td style="text-align:center;font-size:14px;font-weight:bold;" colspan="5" class="judul">Periode : '.$tgl1.' - '.$tgl2.'</td>';
		//}else{
		//	$html .= '<td style="text-align:center;font-size:14px;font-weight:bold;" colspan="8" class="judul"></td>';
		//}
		$html .= '</tr>';
		$html .= '</table>';	
		if($iupi==""){
			$sql = "Select * from plc2.`daftar_upi` where `iStatusKill` = 1 and `dateKill` between '".$tgl1."' and '".$tgl2."'";
		}else{
			$sql = "Select * from plc2.`daftar_upi` where `iStatusKill` = 1 and `iupi_id` = '".$iupi."'";
		}
		

		$datas = $this->db_plc0->query($sql)->result_array();
		if ( $format == 1 ) {
			$html .= '<table border="1" style="border-collapse:collapse;font-family:Tahoma;font-size:12px;"  align="center" width="100%" >';
		}else{
			$html .= '<table  style="font-family:Tahoma;font-size:10px;" width="100%" border="1" style="border:1px solid #000000;border-collapse:collapse;">';

		}

		$html .= "<thead>
						<tr>
						<th width='5%'>No</th>
						<th width='15%'>No UPI</th>
						<th width='25%'>Nama Usulan</th>
						<th width='25%'>Tanggal Kill</th>
						<th width='30%'>NIP - Nama pengkill</th>
						</tr>
				</thead>";
		
		if ( !empty($datas)) {
			$i = 1;
			
			foreach ($datas as $rx) {

				$sq = "select * FROM hrd.`employee` where `cNip`='".$rx['cnipKill']."'";
				$row = $this->db_plc0->query($sq)->row_array();

				$html .= "<tr>";
				$html .= "<td style='text-align:right; '>".$i."</td>";
				$html .= "<td style='text-align:center; '>".$rx['vNo_upi']."</td>";
				$html .= "<td style='text-align:left; '>".$rx['vNama_usulan']."</td>";
				$html .= "<td style='text-align:left; '>".$rx['dateKill']."</td>";
				$html .= "<td style='text-align:left; '>".$rx['cnipKill']." - ".$row['vName']."</td>";
				$html .= "</tr>";
				$i++; 
			}
			

		}

		$html .= "</table>";
		$html .= "</div>";
		$html .= "<br>";
		
		$t = date('Y-m-d');
		if ( $format == 1 ) {
					$pdffile = "report_kill_upi_".$t.".pdf";
					$pdf->AddPage('P', // L - landscape, P - portrait
					'', '', '', '',
					2, // margin_left
					2, // margin right
					5, // margin top
					0, // margin bottom
					5, // margin header
					5); // margin footer
					$pdf->shrink_tables_to_fit = 0;
					$pdf->WriteHTML($html);
	 
					//download it.				
					$pdf ->Output($pdffile, "D");
		} else {
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=report_kill_upi_".$t.".xls");
			echo $html;
		}
		exit;


	}

	/**/
}
?>
