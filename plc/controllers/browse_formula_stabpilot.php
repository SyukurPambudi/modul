<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Browse_formula_stabpilot extends MX_Controller {
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
		$grid->setUrl('browse_formula_stabpilot');
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
		
		$grid->setQuery('plc2.plc2_upb_formula.ldeleted', 0); // yg tidak dihapus
		$grid->setQuery('plc2.plc2_upb_formula.ibest', 2); //yg best formula
		$grid->setQuery('plc2_upb.ihold', 0);

		//yang sudah melewati produksi pilot
		$grid->setQuery('plc2_upb_formula.ifor_id in (select fo.ifor_id from plc2.plc2_upb_formula fo
						inner join plc2.plc2_upb_prodpilot pr on pr.ifor_id=fo.ifor_id
						where fo.ldeleted=0 and pr.ldeleted=0 and pr.iapppd_pp=2)',NULL);

		//yang sudah melewati buat mbr
		$grid->setQuery('plc2_upb_formula.ifor_id in (select mb.ifor_id from plc2.plc2_upb_buat_mbr mb where mb.ldeleted=0 and mb.iapppd_bm=2)',NULL);

		$grid->setQuery('plc2_upb_formula.iupb_id in (select bk.iupb_id from plc2.plc2_upb_bahan_kemas bk where bk.iapppc=2 and bk.iapppd=2 and bk.iappqa=2 and bk.iappbd=2 and bk.ldeleted=0 group by bk.iupb_id)', null); //tambah approval bahan_kemas

		
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id', 'LEFT');
		$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
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
			else{$type='';}
		}
		
		$grid->setSearch('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','ikimiawi','idisolusi','imikro','istress','plc2_upb.iteampd_id');
		
		
	
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
	function listBox_browse_formula_stabpilot_ikimiawi($value) {
    	if($value==0){$vstatus='-';}
    	elseif($value==1){$vstatus='Gagal';}
    	elseif($value==2){$vstatus='Berhasil';}
    	elseif($value==3){$vstatus='Tidak diuji';}
    	return $vstatus;
    }
	function listBox_browse_formula_stabpilot_idisolusi($value) {
    	if($value==0){$vstatus='-';}
    	elseif($value==1){$vstatus='Gagal';}
    	elseif($value==2){$vstatus='Berhasil';}
    	elseif($value==3){$vstatus='Tidak diuji';}
    	return $vstatus;
    }
	function listBox_browse_formula_stabpilot_imikro($value) {
    	if($value==0){$vstatus='-';}
    	elseif($value==1){$vstatus='Gagal';}
    	elseif($value==2){$vstatus='Berhasil';}
    	elseif($value==3){$vstatus='Tidak diuji';}
    	return $vstatus;
    }
	function listBox_browse_formula_stabpilot_istress($value) {
    	if($value==0){$vstatus='-';}
    	elseif($value==1){$vstatus='Gagal';}
    	elseif($value==2){$vstatus='Berhasil';}
    	return $vstatus;
    }
	function listBox_browse_formula_stabpilot_pilih($value, $pk, $name, $rowData) {
		//print_r($rowData);
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_formula('.$pk.',\''.$rowData->plc2_upb__vupb_nomor.'\',\''.$rowData->plc2_upb__vupb_nama.'\',\''.$rowData->plc2_upb__vgenerik.'\',\''.$rowData->team_pd.'\',\''.$rowData->vkode_surat.'\') ;" />
<script type="text/javascript">
		function pilih_formula (id, vupb_nomor, vupb_nama, vgenerik, pdTeam,vkode_surat){					
			custom_confirm("Yakin ?", function(){
				$("#product_trial_stabilita_pilot_ifor_id").val(id);
				$("#product_trial_stabilita_pilot_iupb_id_dis").val(vupb_nomor);
				$("#product_trial_stabilita_pilot_vupb_nomor_dis").val(vupb_nomor);
				$("#product_trial_stabilita_pilot_vupb_nama").val(vupb_nama);
				$("#product_trial_stabilita_pilot_vupb_nama_dis").val(vupb_nama);
				$("#product_trial_stabilita_pilot_vkode_surat_dis").val(vkode_surat);
				$("#product_trial_stabilita_pilot_vkode_surat").val(id);
				$("#product_trial_stabilita_pilot_vgenerik").text(vgenerik);
				$("#product_trial_stabilita_pilot_vgenerik").val(vgenerik);
				$("#product_trial_stabilita_pilot_iteampd_id").val(pdTeam);
				$("#alert_dialog_form").dialog("close");
			});
		}
						
		</script>';
		return $o;
	}
}
