<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class report_export_progress_dokumen extends MX_Controller {
	private $sess_auth;
   	private $dbset;
   	var $ThisCompany;
   	var $BaseLimit0;
    
  	public function __construct() {
	   	parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
	   	$this->dbset 			   = $this->load->database('dosier', true);
	   	$this->url 				   = 'report_export_progress_dokumen';
	   	$this->sess_auth 		 = new Zend_Session_Namespace('auth');
	   	$this->ThisCompany	 = $this->input->get('company_id');
	   	$this->BaseLimit0	   = 2000;
   }
    
   function index($action = '') {
	    $action = $this->input->get('action')? $this->input->get('action') : 'create';
        
        switch ($action) {
        case 'json':
            $grid->getJsonData();
            break;
        case 'view':
            $grid->render_form($this->input->get('id'), true);
            break;
        case 'create':
          	$data['caption']='Filter Report';
          	$data['grid']=$this->url;
          	$data['rfilter']=array('idossier_upd_id'=>'Nomor UPD');
          	$data['button']='<button onclick="javascript:priview_'.$this->url.'(\'preview_'.$this->url.'\', \''.base_url().'processor/plc/report_export_progress_dokumen?action=preview\')" class="ui-button-text icon-save" id="btn_preview">Preview</button>';
            $sa=$this->render_search_report($data);
            echo $sa;
            break;
        case 'createproses':
            echo $grid->saved_form();
            break;
        case 'update':
            $grid->render_form($this->input->get('id'));
            break;
        case 'updateproses':
            echo $grid->updated_form();
            break;
        case 'print_pdf':
        	$post=$this->input->get();
			$html=$this->render_pdf($post);
			$this->load->library('m_pdf');
			$pdf = $this->m_pdf->load('c', 'A4-L');
			$t=date('Y-m-d_H-i-s');
			$pdffile = "report_export_progress_dokumen_".$post['id']."_".$t.".pdf";
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
            break;
        case 'print_xls':
			$post=$this->input->get();
			$html=$this->render_pdf($post);
			$date=date('Y-m-d_H:i:s');
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=report_export_progress_dokumen_".$post['id']."_".$date.".xls");
			echo $html;
			break;
			break;
		case 'preview':
		$post=$this->input->post();
		$s=$this->preview_form($post);
		//print_r($post);exit();
		echo $s;
		break;
        
        case 'get_data_prev':
			echo $this->getdetailsprev();
			break;
        break;
        default:
        	$grid->render_grid();
            break;
        }
    }

    function render_pdf($post){
	   $app=" AND doklist.iStatus_kelengkapan3=2";
    	$sql_data="select doklist.*,kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen,dok.ijml_dok,dok.ibobot,
					divi.vDescription,doklist.istatus_keberadaan,em.vName,rev.*,det.vsubmodul_kategori
					from dossier.dossier_dok_list doklist
					inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=doklist.idossier_dokumen_id
					inner join dossier.dossier_kat_dok_details det on dok.idossier_kat_dok_details_id=det.idossier_kat_dok_details_id
					inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=det.idossier_kat_dok_id
					inner join dossier.dossier_review rev on doklist.idossier_review_id=rev.idossier_review_id
					inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
					left join hrd.employee em on em.cNip=up.vpic
					left join hrd.msdivision divi on divi.iDivID=dok.idivisionId
					where doklist.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0 and up.lDeleted=0 and (divi.lDeleted=0 or divi.lDeleted is null)
					and up.idossier_upd_id=".$post['id'];
		$data['id']=$post['search_grid_report_export_progress_dokumen_idossier_upd_id'];
		$sql_det="Select *, 
				if(st.ijenis_dok_id=1,concat(js.vjenis_dok,' - ',(select ne.vNama_Negara from dossier.dossier_negara as ne where ne.lDeleted=0 and ne.idossier_negara_id=st.idossier_negara_id)), js.vjenis_dok) as jenis 
				from dossier.dossier_upd up
				inner join plc2.itemas ite on ite.C_ITENO=up.iupb_id
				inner join dossier.dossier_standar_dok st on st.istandar_dok_id=up.istandar_dok_id
				inner join dossier.dossier_jenis_dok js on st.ijenis_dok_id=js.ijenis_dok_id
					where up.idossier_upd_id=".$post['id']." and up.lDeleted=0
					";
		$data['dataupd']=$this->dbset->query($sql_det)->row_array();
		$data['qdatall']=$this->dbset->query($sql_data);
		$data['qdataapp']=$this->dbset->query($sql_data.$app);
    	$data['grid']=$this->url;
    	$r=$this->load->view('export/rpt/print_report_export_progress_dokumen',$data,TRUE);
    	return $r;
    }

    function get_data_print($post){
    	$data['post']=$post;
    	$data['url']=base_url()."processor/report_export_progress_dokumen?action=get_data_prev";
    	$s="";
    	$p=array();
    	foreach ($post as $kp => $vp) {
    		$p[$kp]=$vp==""?0:$vp;
    	}
    	$post=$p;
    	$where="";
    	if($post['search_grid_report_export_progress_dokumen_vnip']!="0"){
    		$where.=" AND c.vNIP = '".$post['search_grid_report_export_progress_dokumen_vnip']."'";
    		$t="sasa";
    	}
    	if($post['search_grid_report_export_progress_dokumen_ttarget']!=0){
    		$where.=" AND c.itarget_kunjungan_id = ".$post['search_grid_report_export_progress_dokumen_ttarget'];
    	}
    	if($post['search_grid_report_export_progress_dokumen_from']!="0" && $post['search_grid_report_export_progress_dokumen_to']!="0"){
    		$where.=" AND (DATE (i.tReceived) BETWEEN ('".$post['search_grid_report_export_progress_dokumen_from']."') AND ('".$post['search_grid_report_export_progress_dokumen_to']."'))";
    	}
		$sql_data="select * from kartu_call.call_card c 
			inner join kartu_call.master_target_kunjungan m on m.itarget_kunjungan_id=c.itarget_kunjungan_id
			inner join gps_msg.inbox i on i.ID=c.igpsm_id
			where c.lDeleted=0 and m.lDeleted=0".$where;
		$q=$this->dbset->query($sql_data);
		return $q;
    }

    function getdetailsprev(){
    	$where="";
    	$post=$this->input->post();
    	$t='s';
    	if($post['search_grid_report_export_progress_dokumen_vnip']!="0"){
    		$where.=" AND c.vNIP = '".$post['search_grid_report_export_progress_dokumen_vnip']."'";
    		$t="sasa";
    	}
    	if($post['search_grid_report_export_progress_dokumen_ttarget']!=0){
    		$where.=" AND c.itarget_kunjungan_id = ".$post['search_grid_report_export_progress_dokumen_ttarget'];
    	}
    	if($post['search_grid_report_export_progress_dokumen_from']!="0" && $post['search_grid_report_export_progress_dokumen_to']!="0"){
    		$where.=" AND (DATE (i.tReceived) BETWEEN ('".$post['search_grid_report_export_progress_dokumen_from']."') AND ('".$post['search_grid_report_export_progress_dokumen_to']."'))";
    	}
		$sql_data="select * from kartu_call.call_card c 
			inner join kartu_call.master_target_kunjungan m on m.itarget_kunjungan_id=c.itarget_kunjungan_id
			inner join gps_msg.inbox i on i.ID=c.igpsm_id
			where c.lDeleted=0 and m.lDeleted=0".$where;
		$q=$this->dbset->query($sql_data);
		$rsel=array('tReceived','vNIP','vtarget_kunjungan','vpejabat','thasil');
		$data = new StdClass;
		$data->records=$q->num_rows();
		$i=0;
		foreach ($q->result() as $k) {
			$data->rows[$i]['id']=$k->icall_id;
			$z=0;
			foreach ($rsel as $dsel => $vsel) {
				if($vsel=="tReceived"){
					$dataar[$dsel]=date('Y-m-d',strtotime($k->{$vsel}));
				}else{
					$dataar[$z]=$k->{$vsel};
				}
				$z++;
			}
			$data->rows[$i]['cell']=$dataar;
			$i++;
		}
		return json_encode($data);
	 }

    public function preview_form($post){
    	$app=" AND doklist.iStatus_kelengkapan3=2";
    	$sql_data="select doklist.*,kat.vmodul_kategori,kat.vNama_Kategori,dok.vNama_Dokumen,dok.ijml_dok,dok.ibobot,
					divi.vDescription,doklist.istatus_keberadaan,em.vName,rev.*,det.vsubmodul_kategori
					from dossier.dossier_dok_list doklist
					inner join dossier.dossier_dokumen dok on dok.idossier_dokumen_id=doklist.idossier_dokumen_id
					inner join dossier.dossier_kat_dok_details det on dok.idossier_kat_dok_details_id=det.idossier_kat_dok_details_id
					inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id=det.idossier_kat_dok_id
					inner join dossier.dossier_review rev on doklist.idossier_review_id=rev.idossier_review_id
					inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
					left join hrd.employee em on em.cNip=up.vpic
					left join hrd.msdivision divi on divi.iDivID=dok.idivisionId
					where doklist.lDeleted=0 and dok.lDeleted=0 and kat.lDeleted=0 and rev.lDeleted=0 and up.lDeleted=0 and (divi.lDeleted=0 or divi.lDeleted is null)
					and up.idossier_upd_id=".$post['search_grid_report_export_progress_dokumen_idossier_upd_id'];
		$data['id']=$post['search_grid_report_export_progress_dokumen_idossier_upd_id'];
		$sql_det="Select *, 
				if(st.ijenis_dok_id=1,concat(js.vjenis_dok,' - ',(select ne.vNama_Negara from dossier.dossier_negara as ne where ne.lDeleted=0 and ne.idossier_negara_id=st.idossier_negara_id)), js.vjenis_dok) as jenis 
				from dossier.dossier_upd up
				inner join plc2.itemas ite on ite.C_ITENO=up.iupb_id
				inner join dossier.dossier_standar_dok st on st.istandar_dok_id=up.istandar_dok_id
				inner join dossier.dossier_jenis_dok js on st.ijenis_dok_id=js.ijenis_dok_id
					where up.idossier_upd_id=".$post['search_grid_report_export_progress_dokumen_idossier_upd_id']." and up.lDeleted=0
					";
		$data['dataupd']=$this->dbset->query($sql_det)->row_array();
		$data['qdatall']=$this->dbset->query($sql_data);
		$data['qdataapp']=$this->dbset->query($sql_data.$app);
    	$data['grid']=$this->url;
    	$r=$this->load->view('export/rpt/preview_report_export_progress_dokumen',$data,TRUE);
    	return $r;
    }
    
    public function output(){
            $this->index($this->input->get('action'));
    }
	
	
 /*------------------------------------------------------------------------------------
							InsertBox AND UpdateBox 
	------------------------------------------------------------------------------------*/	
	
 
    	
 /*
	------------------------------------------------------------------------------------
						Before, After and Manipulate Button
	------------------------------------------------------------------------------------
*/

	function render_search_report($data){
		$grid='report_export_progress_dokumen';
		$d=$data['rfilter'];
		$rd=array();
		foreach ($d as $kd => $vd) {
			$func="searchBox_".$kd;
			if(!method_exists($grid,$func)){
				$fi='<input name="search_grid_'.$grid.'_'.$kd.'" label="'.$vd.'" ftype="varchar" id="search_grid_'.$grid.'_'.$kd.'" type="text" class="search_box_'.$grid.'">';
				$rd[$kd]=$fi;
			}else{
				$rd[$kd]=$this->$func($grid,$kd);
			}
		}
		$data['rinput']=$rd;
		$sa=$this->load->view('export/rpt/src_report_export_progress_dokumen',$data,TRUE);
		return $sa;
	}
	function searchBox_iformat(){
		$o='<select name="search_grid_report_export_progress_dokumen_iformat" id="search_grid_report_export_progress_dokumen_iformat">
			<option value="0">---Pilih---</option>
			<option value="1">PDF</option>
			<option value="1">Excel</option>
		</select>';
		return $o;
	}
	function searchBox_idossier_upd_id($grid,$kd){
		$r = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$r .= '<input type="hidden" name="isdraft" id="isdraft">';
		$r .= '<input type="hidden"name="search_grid_'.$grid.'_'.$kd.'" id="search_grid_'.$grid.'_'.$kd.'" class="input_rows1 required search_box_'.$grid.'" />';
		$r .= '<input type="text" name="search_grid_'.$grid.'_'.$kd.'_dis" disabled="TRUE" id="search_grid_'.$grid.'_'.$kd.'_dis" class="input_rows1" size="20" />';
		$r .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse_export_rpt_browse_upd_progress?field='.$grid.'&modul_id='.$this->input->get('modul_id').'\',\'List UPD\')" type="button">&nbsp;</button>';
		
		return $r;
	}
}

