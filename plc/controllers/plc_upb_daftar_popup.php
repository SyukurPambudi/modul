<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plc_upb_daftar_popup extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('plc_upb_daftar_popup');
		$grid->addList('pilih','vupb_nomor','vupb_nama','vgenerik','iteampd_id','ikategoriupb_id','ttanggal');
		$grid->setSortBy('vupb_nomor');
		$grid->setSortOrder('DESC');
		$grid->setWidth('vupb_nomor', '55');
		$grid->setWidth('vupb_nama', '190');
		$grid->setWidth('vgenerik', '210');
		$grid->setWidth('iteambusdev_id', '80');
		$grid->setWidth('iteampd_id', '115');
		$grid->setWidth('ikategoriupb_id', '120');
		$grid->setWidth('ttanggal', '100');
		$grid->setWidth('pilih', '25');
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('ikategoriupb_id', 'Kategori UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');				
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('iteambusdev_id', 'Team Busdev');
		$grid->setLabel('iteampd_id', 'Team PD');
		$grid->setLabel('ttanggal', 'Tanggal UPB');
		$grid->setSearch('vupb_nomor','vupb_nama','vgenerik','iteampd_id','ikategoriupb_id','ttanggal');
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setInputGet('iTujuan_req', $this->input->get('iTujuan_req'));
		//$grid->setRelation('iteambusdev_id', 'plc2.plc2_div_team', 'idplc2_div_team', 'vName','bdTeamName','inner');
		$grid->setRelation('iteampd_id', 'plc2.plc2_upb_team', 'iteam_id', 'vteam','pdTeamName','inner',array('vtipe'=>'PD', 'ldeleted'=>0));
		$grid->setRelation('ikategoriupb_id', 'plc2.plc2_upb_master_kategori_upb', 'ikategori_id', 'vkategori','katUpb','inner');
		$grid->setQuery('iappdireksi', 2);
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/
		/*
		//sdh app setting prioritas prareg
		$grid->setQuery('plc2.plc2_upb.iupb_id in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd 
												inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id
										where pd.ldeleted=0 and pr.iappbusdev=2 )',null); 
		*/
		$iTujuan_req=$_GET['iTujuan_req'];
		if ($iTujuan_req==1) {
			// upb harus sudah lewat study literatur pd dan andev 
				$grid->setQuery('plc2.plc2_upb.iupb_id in (select a.iupb_id from plc2.study_literatur_pd a where a.lDeleted=0 and a.iapppd=2)',null); 
				$grid->setQuery('plc2.plc2_upb.iupb_id in (select a.iupb_id from plc2.study_literatur_ad a where a.lDeleted=0 and a.iappad=2)',null); 
			
			// dan request bb dengan uPB belum ada satupun yang diterima 
				$grid->setQuery('iupb_id not in (
										select d.iupb_id
										from plc2.plc2_upb_ro_detail  a 
										join plc2.plc2_upb_request_sample b on b.ireq_id=a.ireq_id
										join plc2.plc2_upb_ro c on c.iro_id=a.iro_id
										join plc2.plc2_upb d on d.iupb_id=b.iupb_id
										join plc2.plc2_raw_material e on e.raw_id=a.raw_id
										where 
										a.vrec_nip_qc is null
										and a.trec_date_qc is null
										and a.ldeleted=0
										and b.ldeleted=0
										and c.ldeleted=0
										and d.ldeleted=0
										and e.ldeleted=0
										

			)',null);

			//atau formula skala trial 
			//	$grid->setQuery('plc2.plc2_upb.iupb_id not in (select a.iupb_id from plc2.plc2_upb_formula a where a.ldeleted=0 )',null); 				

		}else if($iTujuan_req==2){

			


			/*// untuk PILOT I
			//sudah lewat approve formula skala trial 
			$grid->setQuery('plc2_upb.iupb_id in(
					select a.iupb_id from plc2.plc2_upb_formula a where a.ldeleted=0 and a.iformula_apppd=2 and a.iwithbb=1 )
				',null);
			// belum lewat di formula skala lab
			$grid->setQuery('plc2_upb.iupb_id not in(
					select a.iupb_id from plc2.plc2_upb_formula a where a.ldeleted=0 and a.ilab_apppd<>0 and a.iwithbb=1)
				',null);*/
			
			/*integrasi dengan PD detail, 20170510 by mansur*/
			$grid->setQuery('plc2_upb.iupb_id in(
											select fp.iupb_id 
											from pddetail.formula f 
											join pddetail.formula_process fp on fp.iFormula_process=f.iFormula_process
											where f.lDeleted=0
											and fp.lDeleted=0
											and f.iNextReqSample=1
											and f.iFinishRegSample=0
											and f.iFinishStresTest=1
												)
				',null);


		}else if($iTujuan_req==3){
			// untuk PILOT II
			// sudah lewat basic formula 
			$grid->setQuery('plc2_upb.iupb_id in(
					select a.iupb_id from plc2.plc2_upb_formula a where a.iapp_basic=2 and  a.iwithbasic=1
					)
				',null);
			// belum lewat  produksi pilot 
			$grid->setQuery('plc2_upb.iupb_id not in(
								select a1.iupb_id from plc2.plc2_upb_formula a1
								join plc2.plc2_upb_prodpilot b1 on b1.ifor_id=a1.ifor_id
								where 
								(b1.dtglmulai_prod is not null and b1.dtglmulai_prod !="0000-00-00" )
							)
				',null);
			
			

		}else{
				// untuk re-sample iTujuan=4
				$grid->setQuery('plc2_upb.iupb_id in(
											select fp.iupb_id 
											from pddetail.formula f 
											join pddetail.formula_process fp on fp.iFormula_process=f.iFormula_process
											where f.lDeleted=0
											and fp.lDeleted=0
											and f.iBackSample=1
												)
				',null);

		}

		//Query PD
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			if (count($x) > 0){
				$team=$x['team'];
				if(in_array('PD', $team)){
					$type='PD';
					$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
				}else{
					$type='';
				}
			}
		}
		
		/*$teams = $this->auth_localnon->team();
		$mteams = '';
		$tteams = '';
		$i = 1;
		if(!empty($teams['manager'])) {
			$i = 1;
			foreach($teams['manager'] as $k => $m) {
				if($i==1) {
					$mteams .= $m;
				}
				else {
					$mteams .= ','.$m;
				}
				$i++;		
			}
		}
		if(!empty($teams['team'])) {
			$i = 1;
			foreach($teams['team'] as $k => $m) {
				if($i==1) {
					$tteams .= $m;
				}
				else {
					$tteams .= ','.$m;
				}
				$i++;			
			}
		}
		$tteams = $tteams == '' ? 0 : $tteams;
		$mteams = $mteams == '' ? 0 : $mteams;
		
		$grid->setQuery('iteambusdev_id IN ('.$tteams.','.$mteams.')', NULL);*/
		//$grid->setQuery('iteampd_id', $this->input->get('pdId'));
		//$grid->setMultiSelect(TRUE);
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));
    }

	function listBox_plc_upb_daftar_popup_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_spek_fg('.$pk.',\''.$rowData->vupb_nomor.'\',\''.$rowData->vupb_nama.'\',\''.$rowData->vgenerik.'\',\''.$rowData->pdTeamName.'\') ;" />
				<script type="text/javascript">
					function pilih_upb_spek_fg (id, vupb_nomor, vupb_nama, vgenerik, pdTeam){					
						custom_confirm("Yakin ?", function(){
							$("#'.$this->input->get('field').'_iupb_id").val(id);
							$("#'.$this->input->get('field').'_iupb_id_dis").val(vupb_nomor);
							$("#'.$this->input->get('field').'_vupb_nama").val(vupb_nama);
							$("#'.$this->input->get('field').'_vupb_nama").text(vupb_nama);
							$("#'.$this->input->get('field').'_vgenerik").val(vgenerik);
							$("#'.$this->input->get('field').'_vgenerik").text(vgenerik);
							$("#'.$this->input->get('field').'_iteampd_id").val(pdTeam);
							$("#'.$this->input->get('field').'_iteampd_id").text(pdTeam);
							$("#'.$this->input->get('field').'_upb_id").val(id);
							$("#alert_dialog_form").dialog("close");
						});
					}
				</script>';
		return $o;
	}
}
