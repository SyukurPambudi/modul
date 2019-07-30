<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Spek_fg_list_trial_popup extends MX_Controller {
	function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle('Spesifikasi FG Tentative');		
		$grid->setTable('plc2.plc2_upb_spesifikasi_fg');		
		$grid->setUrl('spek_fg_list_trial_popup');
		$grid->addList('vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','plc2_upb.iteampd_id','itype','vrevisi','pilih');
		$grid->setSortBy('ispekfg_id');
		$grid->setSortOrder('DESC');
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setAlign('vrevisi', 'center');
		$grid->setAlign('itype', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '50');
		$grid->setWidth('iteampd_id', '150');
		$grid->setWidth('vupb_nama', '250');
		$grid->setWidth('vgenerik', '250');
		$grid->setWidth('vkode_surat', '140');
		$grid->setWidth('plc2_upb.iteampd_id', '105');
		$grid->setWidth('vrevisi', '40');
		$grid->setWidth('itype', '50');
		$grid->setWidth('pilih', '25');
		$grid->addFields('iupb_id','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','plc2_upb.iteampd_id','vkode_surat','tberlaku','filename','vrevisi','itype','fmikro','vnip_formulator','spesifikasi');
		//$grid->addFields('iupb_id','vupb_nama','vgenerik','iteampd_id','vkode_surat','tberlaku','filename','vrevisi','itype','vnip_formulator');
		$grid->setRequired('iupb_id','vkode_surat','filename','tberlaku','itype','fmikro');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('vupb_nomor', 'No. UPB');
		//$grid->setLabel('iupb_id', 'No. UPB');
		//$grid->setLabel('plc2_upb.iupb_id', 'No. UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setLabel('iteampd_id', 'Team PD');		
		$grid->setLabel('plc2_upb.iteampd_id', 'Team PD');
		$grid->setLabel('vkode_surat', 'No. Surat');
		$grid->setLabel('tberlaku', 'Tanggal Berlaku');
		$grid->setLabel('filename', 'Nama File');		
		$grid->setLabel('vrevisi', 'Revisi');
		$grid->setLabel('itype', 'Status');
		$grid->setLabel('fmikro', 'Uji Mikrobiologi');		
		$grid->setLabel('vnip_formulator', 'Formulator');
		
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb_spesifikasi_fg.iupb_id = plc2.plc2_upb.iupb_id', 'inner');
		$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));
		//$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner');
		
		$grid->changeFieldType('itype','combobox','',array(''=>'--Select--',0=>'Tentative', 1=>'Final'));
		$grid->changeFieldType('fmikro','combobox','',array(''=>'--Select--',1=>'Tidak', 2=>'ya'));
		
		//query cek sorting spek fg
		$grid->setQuery('plc2_upb_spesifikasi_fg.ispekfg_id not in (select f.ispekfg_id from plc2.plc2_upb_formula f where f.istress=2 and f.istress_apppd=2)',null); //spek fg yg blm pny formula yg udah berhasil dan istresst nya sudah di approved
		$grid->setQuery('plc2_upb_spesifikasi_fg.iupb_id in (select sf.iupb_id from plc2.plc2_upb_soi_fg sf where sf.iappqa=2)',null); //spek fg yg blm pny formula yg udah berhasil
		$grid->setQuery('plc2_upb_spesifikasi_fg.itype', 0); // formula skala trial yg masih tentative
		$grid->setQuery('plc2_upb.ihold', 0);
		//$grid->setQuery('plc2_upb_spesifikasi_fg.iappqa', 2); // formula skala trial yg sudah app qa
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
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
			}
			else{$type='';}
		}
	
		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','plc2_upb.iteampd_id','vkode_surat','itype','vrevisi');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				echo $grid->saved_form();				
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'), TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'detail':
				$this->detail();
			break;
			case 'download':
				$this->download($this->input->get('file'));
			break;
			default:
				$grid->render_grid();
				break;
		}
    }

	function listBox_spek_fg_list_trial_popup_tewst($value, $pk, $name, $rowData) {
		return $rowData->vkode_surat;
	}

	function listBox_spek_fg_list_trial_popup_pilih($value, $pk, $name, $rowData) {
		//print_r($rowData);
		$u = $this->db_plc0->get_where('plc2.plc2_upb_spesifikasi_fg', array('ispekfg_id'=>$pk))->row_array();
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_spek_fg_trial('.$pk.',\''.$rowData->vkode_surat.'\',\''.$rowData->iupb_id.'\',\''.$rowData->plc2_upb__vupb_nomor.'\',\''.$rowData->plc2_upb__vupb_nama.'\',\''.$rowData->plc2_upb__vgenerik.'\',\''.$rowData->team_pd.'\') ;" />
		<script type="text/javascript">
		function pilih_spek_fg_trial (id, vkode_surat, iupb_id, vupb_nomor, vupb_nama, vgenerik, pdTeam){					
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_ispekfg_id").val(id);
				$("#'.$this->input->get('field').'_ispekfg_id_dis").val(vkode_surat);
				$("#'.$this->input->get('field').'_iupb_id").val(iupb_id);
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
	
	function output(){
    	$this->index($this->input->get('action'));
    }
}
