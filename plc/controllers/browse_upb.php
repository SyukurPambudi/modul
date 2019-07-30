<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Browse_upb extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('browse_upb');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik','iteampd_id','ttanggal','ikategoriupb_id','pilih');
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
		$grid->setSearch('vupb_nomor','vupb_nama','vgenerik','iteambusdev_id','ttanggal');
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setAlign('pilih', 'center');
		//$grid->setRelation('iteambusdev_id', 'plc2.plc2_div_team', 'idplc2_div_team', 'vName','bdTeamName','inner');
		$grid->setInputGet('pdId', $this->input->get('pdId'));
		$grid->setRelation('iteampd_id', 'plc2.plc2_upb_team', 'iteam_id', 'vteam','pdTeamName','inner');
		$grid->setRelation('ikategoriupb_id', 'plc2.plc2_upb_master_kategori_upb', 'ikategori_id', 'vkategori','katUpb','inner');
		$grid->setQuery('iappdireksi', 2); // upb yg bisa dipilih hanya upb yg sudah di app direksi
		$grid->setQuery('plc2_upb.ihold', 0);
		$teams = $this->auth->team();
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
		
		$grid->setQuery('iteambusdev_id IN ('.$tteams.','.$mteams.')', NULL);
		$grid->setQuery('iteampd_id', $this->input->get('pdId'));
		//$grid->setMultiSelect(TRUE);
		
		//echo $this->input->get('iupb_id');
		//upb yg sudah ada...
		$grid->setInputGet('_iupb_id', $this->input->get('iupb_id'));
		//echo "test : ".$this->input->get('_iupb_id');
		//if($this->input->get('_iupb_id')==""){
		
		//}
		//else{
			$grid->setQuery('plc2.plc2_upb.iupb_id not in ('.str_replace("_", ",", $this->input->get('_iupb_id')).')', null);
		//}
		
		
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

	function listBox_browse_upb_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_prio('.$pk.',\''.$rowData->vupb_nomor.'\',\''.$rowData->vgenerik.'\',\''.$rowData->katUpb.'\') ;" />
<script type="text/javascript">
	var ix = "'.$this->input->get('index').'";
	var pdId = "'.$this->input->get('pdId').'";
	function pilih_upb_prio (id, vupb_nomor, vgenerik, ikategoriupb_id) {					
		custom_confirm("Yakin", function() {
			$(".upb_set_prio_upb_id_"+pdId).eq(ix).val(id);
			$(".upb_set_prio_upbno_"+pdId).eq(ix).val(vupb_nomor);
			$(".upb_set_prio_generik_"+pdId).eq(ix).text(vgenerik);
			$(".upb_set_prio_kategori_"+pdId).eq(ix).text(ikategoriupb_id);
			$("#alert_dialog_form").dialog("close");
		});
	}
</script>';
		//'.$pk.','.$rowData->cNamaSup.'
		return $o;
	}
}
