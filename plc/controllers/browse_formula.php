<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Browse_formula extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Formulasi');		
		$grid->setTitle('Formula Skala Trial');		
		$grid->setTable('plc2.plc2_upb_formula');		
		$grid->setUrl('browse_formula');
		$grid->addList('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','ikimiawi','idisolusi','imikro','istress','plc2_upb.iteampd_id','pilih');
		$grid->setSortBy('tupdate');
		$grid->setSortOrder('DESC');
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '100');
		$grid->setWidth('plc2_upb.iteampd_id', '150');
		$grid->setWidth('plc2_upb.vupb_nama', '250');
		$grid->setWidth('plc2_upb.vgenerik', '250');
		$grid->setWidth('idisolusi', '75');
		$grid->setWidth('ikimiawi', '75');
		$grid->setWidth('imikro', '75');
		$grid->setWidth('istress', '75');
		$grid->setWidth('vrevisi', '75');
		$grid->setWidth('pilih', '25');
		$grid->setLabel('vkode_surat', 'No. Formulasi');
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('plc2_upb.iupb_id', 'No. UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setLabel('iteampd_id', 'Team PD');		
		$grid->setLabel('plc2_upb.iteampd_id', 'Team PD');
		$grid->setLabel('ikimiawi', 'Kesimpulan Analisa Kimiawi');
		$grid->setLabel('idisolusi', 'Kesimpulan Uji Disolusi');
		$grid->setLabel('imikro', 'Kesimpulan Uji Mikrobiologi');
		$grid->setLabel('istress', 'Hasil Skala Trial');
		
		$grid->setAlign('pilih', 'center');
		
		$grid->setQuery('plc2.plc2_upb_formula.ldeleted', 0);
		$grid->setQuery('plc2_upb.ihold', 0);
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id', 'LEFT');
		$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));
		
		$grid->setSearch('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','ikimiawi','idisolusi','imikro','istress','plc2_upb.iteampd_id');
		
		
		/* //$grid->setRelation('iteambusdev_id', 'plc2.plc2_div_team', 'idplc2_div_team', 'vName','bdTeamName','inner');
		$grid->setInputGet('pdId', $this->input->get('pdId'));
		$grid->setRelation('iteampd_id', 'plc2.plc2_upb_team', 'iteam_id', 'vteam','pdTeamName','inner');
		$grid->setRelation('ikategoriupb_id', 'plc2.plc2_upb_master_kategori_upb', 'ikategori_id', 'vkategori','katUpb','inner');
		//$grid->setQuery('iteambusdev_id', $this->auth->team());
		 */
		
	/* 	$teams = $this->auth->team();
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
		
		 */
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
    	//echo $this->input->get('action');
    }

	function listBox_browse_formula_pilih($value, $pk, $name, $rowData) {
		//print_r($rowData);
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_formula('.$pk.',\''.$rowData->plc2_upb__vupb_nomor.'\',\''.$rowData->plc2_upb__vupb_nama.'\',\''.$rowData->plc2_upb__vgenerik.'\',\''.$rowData->team_pd.'\',\''.$rowData->vrevisi.'\',\''.$rowData->vkode_surat.'\') ;" />
<script type="text/javascript">
		function pilih_formula (id, vupb_nomor, vupb_nama, vgenerik, pdTeam, vrevisi, vkode_surat){					
			custom_confirm("Yakin ?", function(){
				$("#product_trial_stabilita_lab_ifor_id").val(id);
				$("#product_trial_stabilita_lab_iupb_id_dis").val(vupb_nomor);
				$("#product_trial_stabilita_lab_vupb_nomor_dis").val(vupb_nomor);
				$("#product_trial_stabilita_lab_vupb_nama").val(vupb_nama);
				$("#product_trial_stabilita_lab_vupb_nama_dis").val(vupb_nama);
				$("#product_trial_stabilita_lab_vkode_surat_dis").val(vkode_surat);
				$("#product_trial_stabilita_lab_vkode_surat").val(id);
				$("#product_trial_stabilita_lab_vgenerik").text(vgenerik);
				$("#product_trial_stabilita_lab_vgenerik").val(vgenerik);
				$("#product_trial_stabilita_lab_iteampd_id").val(pdTeam);
				$("#product_trial_stabilita_lab_iteampd_id").val(pdTeam);
				$("#product_trial_stabilita_lab_vrevisi").val(vrevisi);
				$("#alert_dialog_form").dialog("close");
			});
		}
						
		</script>';
		return $o;
	}
}
