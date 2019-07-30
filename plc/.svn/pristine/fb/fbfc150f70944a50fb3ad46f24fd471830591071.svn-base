<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plc_upb_daftar_soibb_popup extends MX_Controller {
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
		$grid->setUrl('plc_upb_daftar_soibb_popup');
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
		
		//upb yg ditampilkan hanya upb yg sudah app DR & sudah di prioritaskan & sudah app spek fg
		$grid->setQuery('iappdireksi', 2);
		//$grid->setQuery('iprioritas', 1);
		//UPB yang sudah setting prioritas
		//Buka fitur Setting Prioritas SSID No 348079
		/*$grid->setQuery('iupb_id in (select de.iupb_id from plc2.plc2_upb_prioritas_detail de 
				inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=de.iprioritas_id
				where de.ldeleted=0 and pr.ldeleted=0 and pr.iappbusdev=2)',NULL);*/
		$grid->setQuery('ihold', 0);
		// $grid->setQuery('ispekpd', 2);
		// $grid->setQuery('ispekqa', 2);

// required lama mansur was here 20160715


		$grid->setQuery('iupb_id not in (select f.iupb_id from plc2.plc2_upb_soi_bahanbaku f where f.ldeleted=0)',null); //upb yg blm pny soi bb
		$grid->setQuery('iupb_id in 
						(
							select rs.iupb_id from plc2.plc2_upb_request_sample rs 
								inner join plc2.plc2_upb_ro_detail rod on rod.ireq_id=rs.ireq_id
							where rs.iapppd=2 and rs.ldeleted=0 and rod.irelease=2  and rod.ldeleted=0
							 and rs.iTujuan_req=1
						)',null); //upb yg sudah release bb

// new required 20160715

		$grid->setQuery('iupb_id in (
				select a.iupb_id from plc2.draft_soi_bb a where a.iApprove=2
			)',null);



		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('QC', $manager)){
				$type='QC';
				$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth->my_teams().')', null);
			}
			elseif(in_array('QA', $manager)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth->my_teams().')', null);
			}
			elseif(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('QC', $team)){
				$type='QC';
				$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth->my_teams().')', null);
			}
			elseif(in_array('QA', $team)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth->my_teams().')', null);
			}
			elseif(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
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

	function listBox_plc_upb_daftar_soibb_popup_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_soibb('.$pk.',\''.$rowData->vupb_nomor.'\',\''.$rowData->vupb_nama.'\',\''.$rowData->vgenerik.'\',\''.$rowData->pdTeamName.'\') ;" />
<script type="text/javascript">
		function pilih_upb_soibb (id, vupb_nomor, vupb_nama, vgenerik, pdTeam){					
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_iupb_id").val(id);
				$("#'.$this->input->get('field').'_iupb_id_dis").val(vupb_nomor);
				$("#'.$this->input->get('field').'_vupb_nama").val(vupb_nama);
				$("#'.$this->input->get('field').'_vupb_nama").text(vupb_nama);
				$("#'.$this->input->get('field').'_vgenerik").val(vgenerik);
				$("#'.$this->input->get('field').'_vgenerik").text(vgenerik);
				$("#'.$this->input->get('field').'_iteampd_id").val(pdTeam);
				$("#'.$this->input->get('field').'_iteampd_id").text(pdTeam);
				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}
}
