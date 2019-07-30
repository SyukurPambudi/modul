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
		$this->id='plcotc_report_detail_upb';
        $this->load->library('auth');
		$this->user = $this->auth->user();
		$this->load->library('biz_process');
		$this->load->helper('tanggal');
		$this->load->model('user_model');
        $this->url = 'report_detail_upb'; 
		// $this->dbset = $this->load->database('plc', true);
		$this->report = $this->load->library('report');
    }
    function index($action = '') {		
    	//Bikin Object Baru Nama nya $grid
    	$action = $this->input->get('action') ? $this->input->get('action') : 'create';		
		$grid = new Grid;		
		$grid->setTitle('Laporan Detail UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('report_detail_upb');		
		$grid->addFields('iupb_id','format','priview');
		$grid->setLabel('iupb_id', 'Nomor UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
	
		switch ($action) {		
			case 'create':
				$grid->render_form();
				break;
			case 'get_preview_report' :
				$iupb_id=$this->input->get('iupb');
				$this->load->library('m_pdf');
				$pdf = $this->m_pdf->load('c', 'A4');
				$id=$this->input->get("id");
				
				$html = $this->form_cetak_petunjuk($iupb_id);$date=date('YmdHis');
				$pdffile = "report_detail_upb_".$iupb_id."_".$date.".pdf";
				$pdf->setFooter("Page {PAGENO}");
				$pdf->AddPage('P', // L - landscape, P - portrait
				'', '', '', '',
				20, // margin_left
				20, // margin right
				20, // margin top
				20, // margin bottom
				10, // margin header
				20); // margin footer
				$pdf->shrink_tables_to_fit = 0;
				$pdf->WriteHTML($html);
 				
				//download it.				
				$pdf ->Output($pdffile, "D");
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
			</select>
		';
		
		return $o;
	}
	public function insertBox_report_detail_upb_priview($field, $id) {
		$o = '<div id="priview"></div>';
		$o.= '
			<script type="text/javascript">
				$("label[for=\''.$id.'\']").hide();
				$("label[for=\''.$id.'\']").next().css("margin-left",0);
			</script>
		';
		
		return $o;
	}

	public function updateBox_report_detail_upb_format($field, $id) {
		$o = '
			<select name="'.$id.'" id="'.$id.'">
				<option value="">--Select--</option>
				<option value="1">PDF</option>
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
						_custom_alert("Pilih UPB !","Info","Info","report_detail_upb",1,5000);
						$("#'.$this->url.'_iupb_id").focus();
						
						return false;
					}
					if (format == "") {
						_custom_alert("Pilih Format Laporan !","Info","Info","report_detail_upb",1,5000);
						$("#'.$this->url.'_format").focus();
						
						return false;
					} else {	
						//$.ajax({
						//	url: base_url+"processor/plc/report/detail/upb?action=get_preview_report&iupb="+iupb+"&format="+format,
						//	success: function(data) {
						//		$("#priview").html(data);
						//	}
						//});

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
	public function form_cetak_petunjuk($id){
		$sql="
			select u.*, e.vName, k.vkategori, ku.vkategori as katupb, s.vsediaan,
			 (select te.vteam from plc2.plc2_upb_team te where te.iteam_id in (select tei.iteam_id from plc2.plc2_upb_team_item tei where tei.vnip=u.cnip) limit 1) as vteamm,
			 (case 
			  when u.itipe_id=1 then 'Local'
			  when u.itipe_id=2 then 'Import' 
			 else 'Export'
			 end) as tipe,
			 (case 
			  when u.ibe=1 then 'BE'
			  when u.ibe=2 then 'Non BE' 
			 end) as be,
			 ifnull(u.vhpp_target,'-') as hpp,
			 (case 
			  when u.ipatent=1 then 'Indonesia'
			  when u.ipatent=2 then 'Internasional' 
			 end) as patent,
			 case
			  when u.iteambusdev_id=0 then '-'
			  else (select vteam from plc2.plc2_upb_team where iteam_id=u.iteambusdev_id)
			 end as bd,
			 case
			  when u.iteampd_id=0 then '-'
			  else (select vteam from plc2.plc2_upb_team where iteam_id=u.iteampd_id)
			 end as pd,
			 case
			  when u.iteamqa_id=0 then '-'
			  else (select vteam from plc2.plc2_upb_team where iteam_id=u.iteamqa_id)
			 end as qa,
			 case
			  when u.iteamqc_id=0 then '-'
			  else (select vteam from plc2.plc2_upb_team where iteam_id=u.iteamqc_id)
			 end as qc,
			 case
			  when u.iteammarketing_id=0 then '-'
			  else (select vteam from plc2.plc2_upb_team where iteam_id=u.iteammarketing_id)
			 end as mk,
			 (case 
			  when u.iregister=3 then 'PT. NOVELL PHARMACEUTICAL LABORATORIES'
			  when u.iregister=5 then 'PT. ETERCON PHARMA' 
			 end) as reg,
			  (case 
			  when u.idevelop=3 then 'PT. NOVELL PHARMACEUTICAL LABORATORIES'
			  when u.idevelop=5 then 'PT. ETERCON PHARMA' 
			  when u.idevelop=100 then 'TOLL'
			 end) as dev,
			 (case 
			  when u.ihold=0 then 'Tidak'
			  when u.ihold=1 then 'Ya' 
			 end) as cancel
			from plc2.plc2_upb u 
				inner join hrd.employee e on e.cNip=u.cnip
			        left join hrd.mnf_kategori k on k.ikategori_id=u.ikategori_id
				left join plc2.plc2_upb_master_kategori_upb ku on ku.ikategori_id=ikategoriupb_id
				left join hrd.mnf_sediaan s on s.isediaan_id=u.isediaan_id 
			where u.iupb_id =".$id;
		$data['row']=$this->db_plc0->query($sql)->row_array();
		$data['rl']=array("vupb_nomor"=>"No. UPB","vupb_nama"=>"Nama Usulan","vgenerik"=>"Nama Generik","ttanggal"=>"Tanggal");
		$data['r2']=array("voriginator"=>"Originator","voriginator_price"=>"Harga Originator","voriginator_kemasan"=>"Kemasan Originator","vkategori"=>"Kategori Produk","katUpb"=>"kategori UPB","vsediaan"=>"Sediaan Produk","tipe"=>"Type Produk","be"=>"Type BE","hpp"=>"Target HPP","tunique"=>"Keunggulan Produk","tpacking"=>"Spesifikasi Kemasan","ttarget_prareg"=>"Estimasi Praregistrasi","patent"=>"Tipe Hak Patent","tinfo_paten"=>"Informasi Hak Patent","bd"=>"Team Busdev","pd"=>"Team PD","qa"=>"Team QA","qc"=>"Team QC","mk"=>"Team Marketing","reg"=>"Registrasi Untuk","dev"=>"Produksi Oleh","tmemo_busdev"=>"Catatan Busdev","cancel"=>"Cancel UPB");
		$d=$data['row'];
		if($d['txtDocBB']!=""){
			$sa=$d['txtDocBB'];
		}else{
			$sa=0;
		}
		$sqlbb="select * from plc2.plc2_upb_master_dokumen_bb a where a.ldeleted=0 and a.idoc_id in (".$sa.")";
		$data['txtDocBB']=$this->db_plc0->query($sqlbb)->result_array();
		$m=$data['row'];
		if($m['txtDocSM']!=""){
			$ma=$m['txtDocSM'];
		}else{
			$ma=0;
		}
		$sqlsm="select * from plc2.plc2_upb_master_dokumen_sm a where a.ldeleted=0 and a.idoc_id in (".$ma.")";
		
		$data['txtDocSM']=$this->db_plc0->query($sqlsm)->result_array();
		$sqlkom="select k.ikomposisi_id, k.ijumlah, k.vsatuan, k.vketerangan, r.raw_id, r.vraw, r.vnama 
				from plc2.plc2_upb_komposisi k 
					inner join plc2.plc2_raw_material r on r.raw_id=k.raw_id
				where k.iupb_id=".$id." and k.ldeleted=0";
		$data['datakom']=$this->db_plc0->query($sqlkom)->result_array();

		$data['forecast']["r1"] = $this->db_plc0->get_where('plc2.plc2_upb_forecast', array('iupb_id' => $id, 'ino'=>1, 'ldeleted'=>0))->row_array();
		$data['forecast']["r2"] = $this->db_plc0->get_where('plc2.plc2_upb_forecast', array('iupb_id' => $id, 'ino'=>2, 'ldeleted'=>0))->row_array();
		$data['forecast']["r3"] = $this->db_plc0->get_where('plc2.plc2_upb_forecast', array('iupb_id' => $id, 'ino'=>3, 'ldeleted'=>0))->row_array();
		$o=$this->load->view("report/nonotc/prnt/report_detail_upb",$data,TRUE);
		return $o;
	}
}
?>
