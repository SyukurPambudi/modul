<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plc_upb_daftar_fst_popup extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('plc_upb_daftar_fst_popup');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik','iteampd_id','ikategoriupb_id','ttanggal','pilih');
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
		//$grid->setRelation('iteambusdev_id', 'plc2.plc2_div_team', 'idplc2_div_team', 'vName','bdTeamName','inner');
		$grid->setRelation('iteampd_id', 'plc2.plc2_upb_team', 'iteam_id', 'vteam','pdTeamName','inner',array('vtipe'=>'PD', 'ldeleted'=>0));
		$grid->setRelation('ikategoriupb_id', 'plc2.plc2_upb_master_kategori_upb', 'ikategori_id', 'vkategori','katUpb','inner');
		
		//upb yg ditampilkan hanya upb yg sudah app DR & sudah di prioritaskan prareg
		$grid->setQuery('iappdireksi', 2);
		//$grid->setQuery('iprioritas', 1);
		$grid->setQuery('ihold', 0);
		$grid->setQuery('iappbusdev_prareg <> 2',null);
		//sdh app setting prioritas prareg
		//Buka fitur Setting Prioritas SSID No 348079
		/*$grid->setQuery('iupb_id in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd 
												inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id
										where pd.ldeleted=0 and pr.iappbusdev=2 )',null); */

		// upb sudah melewati terima sample BB
	/*
		$grid->setQuery('iupb_id in (
										select d.iupb_id
										from plc2.plc2_upb_ro_detail  a 
										join plc2.plc2_upb_request_sample b on b.ireq_id=a.ireq_id
										join plc2.plc2_upb_ro c on c.iro_id=a.iro_id
										join plc2.plc2_upb d on d.iupb_id=b.iupb_id
										join plc2.plc2_raw_material e on e.raw_id=a.raw_id
										where 
										a.vrec_nip_qc is not null
										and a.trec_date_qc is not null
										and a.ldeleted=0
										and b.ldeleted=0
										and c.ldeleted=0
										and d.ldeleted=0
										and e.ldeleted=0
										

			)',null);
	*/
		// semua request BB sudah diterima sesuai jumlah yang direquest 
		$grid->setQuery('(
					#terima 
						(
							select 
							count(b.raw_id)
							from plc2.plc2_upb_ro a 
							join plc2.plc2_upb_ro_detail b on b.iro_id=a.iro_id
							join plc2.plc2_upb_request_sample c on c.ireq_id=b.ireq_id
							where a.ldeleted=0
							and b.ldeleted=0
							and c.iupb_id =  `plc2`.`plc2_upb`.iupb_id
						)
					>=
					#minta
					(
						select IFNULL(count(bb.raw_id),0)
							from plc2.plc2_upb_request_sample aa
							join plc2.plc2_upb_request_sample_detail bb on bb.ireq_id=aa.ireq_id
							where aa.ldeleted=0
							and bb.ldeleted=0
							and aa.iupb_id= `plc2`.`plc2_upb`.iupb_id
							#group by aa.iupb_id
					)
					

				)

			',null);

	
		// tidak ada skala trial UPB yang masih aktif menunggu approval , dan tidak ada juga yang sudah pernah diapprove skala trial UPB nya 

		$grid->setQuery('iupb_id not in (
										select a.iupb_id from plc2.plc2_upb_formula a where a.iformula_apppd=0 and a.ldeleted=0
										union
										select a.iupb_id from plc2.plc2_upb_formula a where a.iformula_apppd=2  and a.istress=2 and a.ldeleted=0
						)',null);


		
		//$grid->setQuery('iupb_id not in (select f.iupb_id from plc2.plc2_upb_spesifikasi_fg f where f.itype=1)',null);
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
			}
			elseif(in_array('QA', $manager)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
			}
			elseif(in_array('QA', $team)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
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

	function listBox_plc_upb_daftar_fst_popup_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_fst('.$pk.',\''.$rowData->vupb_nomor.'\',\''.$rowData->vupb_nama.'\',\''.$rowData->vgenerik.'\',\''.$rowData->pdTeamName.'\',\''.$rowData->vkat_originator.'\') ;" />
		<script type="text/javascript">
	//	$("#kat_upb").val("");
		$("#iwithstress").val("");
		$("#cekbok").hide();
		$("#iwithori").attr("checked", false);
		$("#iwithbb").attr("checked", false);

		function pilih_upb_fst (id, vupb_nomor, vupb_nama, vgenerik, pdTeam,vkat_originator){					
			custom_confirm("Yakin ?", function(){


				$("#'.$this->input->get('field').'_iupb_id").val(id);
				$("#'.$this->input->get('field').'_iupb_id_dis").val(vupb_nomor);
				$("#'.$this->input->get('field').'_vupb_nama").val(vupb_nama);
				$("#'.$this->input->get('field').'_vgenerik").val(vgenerik);
				$("#'.$this->input->get('field').'_iteampd_id").val(pdTeam);
				$("#kat_upb").val(vkat_originator);
				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}
}
