<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class plc_upb_daftar_monitoring extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
		//print_r($this->_field);
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('plc_upb_daftar_monitoring');
		$grid->addList('vupb_nomor','vupb_nama','iteambusdev_id','vgenerik','iteampd_id','ikategoriupb_id','ttanggal','pilih');
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
		$grid->setSearch('vupb_nomor','vupb_nama','vgenerik','ikategoriupb_id','ttanggal','iteambusdev_id','iteampd_id');
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		//$grid->setRelation('iteambusdev_id', 'plc2.plc2_div_team', 'idplc2_div_team', 'vName','bdTeamName','inner');
		$grid->setRelation('iteampd_id', 'plc2.plc2_upb_team', 'iteam_id', 'vteam','pdTeamName','inner');
		$grid->setRelation('ikategoriupb_id', 'plc2.plc2_upb_master_kategori_upb', 'ikategori_id', 'vkategori','katUpb','inner');
		$grid->setQuery('plc2_upb.ldeleted',0);
	//	$grid->setQuery('plc2_upb.ihpp', 2); // hpp approve
		$grid->setQuery('plc2_upb.ihold', 0);
		$grid->changeFieldType('iteampd_id','combobox','',array(''=>'--Select--',1=>'Gunung Putri', 2=>'Ulujami PD', 3=>'Etercon'));
		
		/*
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
			elseif(in_array('BD', $manager)){
				$type='BD';
				$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth->my_teams().')', null);
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
			elseif(in_array('BD', $team)){
				$type='BD';
				$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
		// upb yg sudah approved basic formula
		//$grid->setQuery('iupb_id in (select f.iupb_id from plc2.plc2_upb_formula f where f.iapppd_basic=2 and f.ldeleted=0)',null); 
		
		
		//$grid->setQuery('iteambusdev_id', $this->auth->team()); iapppd_basic
		/*$teams = $this->auth->team();
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
	
	function searchBox_plc_upb_daftar_monitoring_iteambusdev_id($rowData, $id) {
    	$teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('ldeleted' => 0,'vtipe' => 'BD'))->result_array();
    	$o = '<select id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }    
	 function listBox_plc_upb_daftar_monitoring_iteambusdev_id($value) {
    	$team = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id' => $value))->row_array();
    	if(isset($team['vteam'])){
			return $team['vteam'];
		}
		else{
			return $value;
		}
		
    } 

	function listBox_plc_upb_daftar_monitoring_pilih($value, $pk, $name, $rowData) {
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
				$("#alert_dialog_form").dialog("close");
				
			});
		}
		</script>';
		return $o;
	}
}
