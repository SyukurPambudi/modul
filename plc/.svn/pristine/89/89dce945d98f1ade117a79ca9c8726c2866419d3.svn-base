<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Partial_view_export extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
    }

    function index($action = '') {
    	$action = $this->input->get('action');

    	switch ($action) {
			case 'getreviewdokumen':
				echo $this->getreviewdokumen();
				break;
			case 'gethistorytd':
				echo $this->gethistorytd();
				break;
			case 'getdokwithkat':
				echo $this->getdokwithkat();
				break;
			case 'getuploadfile_dokumentd':
				echo $this->getuploadfile_dokumentd();
				break;
			case 'gethistoy_detailtd':
				echo $this->gethistoy_detailtd();
				break;
			default:
				echo $this->getreviewdokumen();
				break;
		}

    }
	function getreviewdokumen(){

		$idossier_upd_id =$_POST['idossier_upd_id']; 
		$iSediaan =$_POST['iSediaan'];
		$data['iSediaan'] = $iSediaan;
		$data['idossier_upd_id'] =  $idossier_upd_id;

		$sql_doc='select * 
					from dossier.dossier_dokumen a 
					join dossier.dossier_kat_dok b on b.idossier_kat_dok_id=a.idossier_kat_dok_id
					where a.lDeleted ="0"';
		$data['docs'] = $this->db_plc0->query($sql_doc)->result_array();
		$sql_negara="select * from dossier.dossier_upd_negara ne 
		inner join dossier.dossier_negara neg on neg.idossier_negara_id = ne.idossier_negara_id
		where ne.lDeleted=0 and ne.idossier_upd_id=".$idossier_upd_id;
		$data['mnnegara'] = $this->db_plc0->query($sql_negara)->result_array();
		$sql_jenis='select * from dossier.dossier_upd up 
				inner join dossier.dossier_jenis_dok jn on up.iSediaan=jn.ijenis_dok_id
				where up.lDeleted=0 and jn.lDeleted=0 and up.idossier_upd_id='.$idossier_upd_id;
		$data['upd']=$this->db_plc0->query($sql_jenis)->row_array();
		$view=$this->load->view('review_kebutuhan_dokumen',$data,TRUE);
		/*
		if ( $iSediaan == 1) {
			//solid

			$view = $this->load->view('review_export_solid',$data,TRUE);
		}else{
			//non solid
			 $view = $this->load->view('review_export_non_solid',$data,TRUE);
		}*/

		return $view;
		
	}


	function gethistorytd(){
		$idossier_review_id = $_POST['idossier_review_id'];

		//$sql_doc='	select * from dossier.dossier_dok_td a where a.lDeleted = 0 and a.idossier_review_id = "'.$idossier_review_id.'" ';
		$sql_doc='select td.*,up.*,td.cCreated as pengusul from dossier.dossier_dok_td td 
			inner join dossier.dossier_review rev on rev.idossier_review_id=td.idossier_review_id
			inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
			where td.lDeleted=0 and rev.lDeleted=0 and up.lDeleted=0 and td.iapp_dok_td_cek4=2
			and td.idossier_review_id='.$idossier_review_id;

		$data['rows'] = $this->db_plc0->query($sql_doc)->result_array();
		
		$view = $this->load->view('dossier_history_dok_td',$data,TRUE);

		return $view;
		
	}

	function getdokwithkat(){
		$iKat_dok = $_POST['iKat_dok'];
		$idossier_upd_id=$_POST['idossier_upd_id'];
		$idossier_review_id=$_POST['idossier_review_id'];

		$rows = $this->db_plc0->get_where('dossier.dossier_upd', array('idossier_upd_id'=>$idossier_upd_id))->row_array();

		//$return1= print_r($rows);
		$data['iTeam_andev']	=$rows['iTeam_andev'];
		$data['rows'] = $rows;
		$data['iSediaan'] = $rows['iSediaan'];
		$data['idossier_upd_id'] =  $rows['idossier_upd_id'];

		$sql_negara="select * from dossier.dossier_upd_negara ne 
		inner join dossier.dossier_negara neg on neg.idossier_negara_id = ne.idossier_negara_id
		where ne.lDeleted=0 and ne.idossier_upd_id=".$rows['idossier_upd_id'];
		$data['mnnegara'] = $this->db_plc0->query($sql_negara)->result_array();

		$sql_doc='	select * ,b.idossier_dok_list_id as id_doklis,d.iSubmit_upload,b.vKeterangan_review
					from dossier.dossier_dokumen a 
					left join dossier.dossier_dok_list b on b.idossier_dokumen_id=a.idossier_dokumen_id 
					join dossier.dossier_review d on d.idossier_review_id=b.idossier_review_id
					left join dossier.dossier_dok_list_file c on c.idossier_dok_list_id =b.idossier_dok_list_id
					join dossier.dossier_kat_dok_details det on det.idossier_kat_dok_details_id=a.idossier_kat_dok_details_id
					join dossier.dossier_kat_dok e on e.idossier_kat_dok_id = det.idossier_kat_dok_id
					join dossier.dossier_upd u on d.idossier_upd_id=u.idossier_upd_id
					where a.lDeleted=0
					and b.lDeleted=0
					and e.lDeleted=0
					and u.lDeleted=0
					and if(c.idossier_dok_list_file_id is not null,c.lDeleted = 0,b.lDeleted=0)
					and b.idossier_review_id="'.$idossier_review_id.'"';
		if($iKat_dok!=''){
			$sql_doc.='and e.idossier_kat_dok_id = "'.$iKat_dok.'" ';
		}
		$sql_doc .=' group by b.idossier_dok_list_id
					order by det.vsubmodul_kategori, a.iurut_dokumen ASC';
		//$data['rows'] = $this->db_plc0->query($sql_doc)->result_array();
		$dt = $this->db_plc0->query($sql_doc)->result_array();
		$dat=array();
		foreach ($dt as $kdt => $vdt) {
			$dat[$kdt][$vdt['idossier_negara_id']]=$vdt;
		}
		$data['datadok']=$dat;
		
		$view = $this->load->view('dossier_upload_dokumen',$data,TRUE);

		return $view;
		
	}

	public function getuploadfile_dokumentd(){
		$post=$this->input->post();
		$sql_negara="select * from dossier.dossier_upd_negara ne 
		inner join dossier.dossier_negara neg on neg.idossier_negara_id = ne.idossier_negara_id
		where ne.lDeleted=0 and ne.idossier_upd_id=".$post['idossier_upd_id'];
		$data['mnnegara'] = $this->dbset->query($sql_negara)->result_array();

		$sqlteam="select em.* from plc2.plc2_upb_team_item ite
			inner join plc2.plc2_upb_team te on ite.iteam_id=te.iteam_id
			inner join hrd.employee em on em.cNip=ite.vnip
			where ite.ldeleted=0 and te.ldeleted=0 and (te.vtipe='AD' OR te.vtipe='TD')";

		$data['pic']=$this->dbset2->query($sqlteam)->result_array();
		$return = $this->load->view('dossier_dokumen_td_insert',$data,TRUE);
		return $return;
	}

	function gethistoy_detailtd(){
		$post=$this->input->post();
		$sql_negara="select * from dossier.dossier_upd_negara ne 
		inner join dossier.dossier_negara neg on neg.idossier_negara_id = ne.idossier_negara_id
		inner join dossier.dossier_review rev on rev.idossier_upd_id=ne.idossier_upd_id
		inner join dossier.dossier_dok_td doktd on doktd.idossier_review_id=rev.idossier_review_id
		where ne.lDeleted=0 and doktd.idossier_dok_td_id=".$post['idossier_dok_td_id'];
		$data['mnnegara'] = $this->dbset->query($sql_negara)->result_array();

		$sqlteam="select em.* from plc2.plc2_upb_team_item ite
			inner join plc2.plc2_upb_team te on ite.iteam_id=te.iteam_id
			inner join hrd.employee em on em.cNip=ite.vnip
			where ite.ldeleted=0 and te.ldeleted=0 and (te.vtipe='AD' OR te.vtipe='TD')";
		$data['pic']=$this->dbset->query($sqlteam)->result_array();

		$sql_docs="select mem.*,det.idossier_negara_id,det.cpic,det.drequest from dossier.dossier_dok_td_memo mem
				inner join dossier.dossier_dok_td_detail det on det.idossier_dok_td_detail_id=mem.idossier_dok_td_detail_id
				inner join dossier.dossier_dok_td dok on dok.idossier_dok_td_id=det.idossier_dok_td_id
				where det.lDeleted=0 and mem.lDeleted=0 and dok.lDeleted=0 and dok.idossier_dok_td_id=".$post['idossier_dok_td_id'];
		$data['docs']=$this->dbset->query($sql_docs);
		$return = $this->load->view('dossier_dokumen_td_details_history',$data,TRUE);
		return $return;
	}

	
	public function output(){
		$this->index($this->input->get('action'));
	}

}

