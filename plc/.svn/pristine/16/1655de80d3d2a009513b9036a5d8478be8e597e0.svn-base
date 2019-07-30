<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class study_literatur_ad_popup extends MX_Controller {
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
		$grid->setUrl('study_literatur_ad_popup');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik','iteampd_id','ikategoriupb_id','ttanggal','pilih');
		$grid->setSortBy('vupb_nomor');
		$grid->setSortOrder('DESC');
		$grid->setWidth('vupb_nomor', '55');
		$grid->setWidth('vupb_nama', '190');
		$grid->setWidth('vgenerik', '210');
		$grid->setWidth('iteambusdev_id', '80');
		$grid->setWidth('iteampd_id', '100');
		$grid->setWidth('ikategoriupb_id', '80');
		$grid->setWidth('ttanggal', '100');
		$grid->setWidth('pilih', '25');
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('ikategoriupb_id', 'Kategori');
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
		/*$grid->setQuery('master_flow_id in (select fl.iUrutan from plc2.master_proses pros
inner join plc2.master_proses_parent pa on pros.master_proses_id=pa.master_proses_id
inner join plc2.master_flow_detail de on pa.master_proses_parent_id=de.master_proses_parent_id
inner join plc2.master_flow fl on de.master_flow_id=fl.master_flow_id
where pros.idprivi_modules='.$this->input->get('modul_id').')',NULL);*/
		//sdh app setting prioritas prareg
		//Buka fitur Setting Prioritas SSID No 348079
		/*$grid->setQuery('plc2.plc2_upb.iupb_id in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd 
												inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id
										where pd.ldeleted=0 and pr.iappbusdev=2 )',null);*/ 

		/*$grid->setQuery('(CASE WHEN plc2_upb.vkat_originator=3 THEN plc2.plc2_upb.iupb_id in (select ro.iupb_id from plc2.plc2_upb_request_originator ro where ro.ldeleted=0 and ro.isent_status=1)
						else plc2.`plc2_upb`.`iupb_id` in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id where pd.ldeleted=0 and pr.iappbusdev=2)
						END)', NULL);*/
						
		//Buka fitur Setting Prioritas SSID No 348079				
		$grid->setQuery('(CASE WHEN plc2_upb.vkat_originator=3 THEN plc2.plc2_upb.iupb_id in (select ro.iupb_id from plc2.plc2_upb_request_originator ro where ro.ldeleted=0 and ro.isent_status=1)
						else plc2.`plc2_upb`.`ldeleted` = 0
						END)', NULL);
		$grid->setQuery('iupb_id not in (select iupb_id from plc2.study_literatur_ad where ldeleted=0 and iappad !=1)',null); 
		
		//$grid->setQuery('iupb_id not in (select f.iupb_id from plc2.plc2_upb_spesifikasi_fg f where f.itype=1)',null);
		
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/
		
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
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
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

	function listBox_study_literatur_ad_popup_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_fst('.$pk.',\''.$rowData->vupb_nomor.'\',\''.$rowData->vupb_nama.'\',\''.$rowData->vgenerik.'\',\''.$rowData->pdTeamName.'\') ;" />
		<script type="text/javascript">
		function pilih_upb_fst (id, vupb_nomor, vupb_nama, vgenerik, pdTeam){					
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_iupb_id").val(id);
				$("#'.$this->input->get('field').'_iupb_id_dis").val(vupb_nomor);
				$("#'.$this->input->get('field').'_vupb_nama").val(vupb_nama);
				$("#'.$this->input->get('field').'_vgenerik").val(vgenerik);
				$("#'.$this->input->get('field').'_iteampd_id").val(pdTeam);
				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}
}
