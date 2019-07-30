<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_upd_dokumen_pembagian_staff extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_plcexport');
		$this->load->library('lib_utilitas');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth_plcexport->user();
		$this->_field = $this->input->get('field');
		$this->_id=$this->input->get('idossier_upd_id');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Daftar UPD');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_upd');		
		$grid->setUrl('browse_upd_dokumen_pembagian_staff');
		$grid->addList('pilih','vUpd_no','vNama_usulan','iTeam_andev','itemas.C_ITENO','itemas.C_ITNAM','tabmas02.c_nmlisen');
		$grid->setSortBy('vUpd_no');
		$grid->setSortOrder('DESC'); //sort ordernya

		//setting widht grid
		$grid ->setWidth('vUpd_no', '100'); 
		//modif label
		$grid->setLabel('vUpd_no','No UPD');
		$grid->setLabel('vNama_usulan','Nama Usulan');
		$grid->setLabel('itemas.C_ITENO','Kode Produk');
		$grid->setLabel('itemas.C_ITNAM','Nama Produk');
		$grid->setLabel('tabmas02.c_nmlisen','Lisensi');
		$grid->setLabel('iTeam_andev','Team Andev');

		$grid->setFormUpload(TRUE);

		$grid->setSearch('vUpd_no');

		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->setInputGet('idossier_upd_id',$this->_id);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setWidth('pilih', '25');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iTeam_andev','combobox','',array(''=>'Pilih','17'=>'Andev Export 1','40'=>'Andev Export 2'));
		
		

	//Field mandatori
		$grid->setRequired('iSediaan');	
		$grid->setRequired('iTeam_andev');	
		$grid->setRequired('lDeleted');	

		
		$grid->setJoinTable('dossier.dossier_prioritas_detail', 'dossier_prioritas_detail.idossier_upd_id = dossier_upd.idossier_upd_id', 'inner');
		$grid->setJoinTable('dossier.dossier_prioritas', 'dossier_prioritas.idossier_prioritas_id = dossier_prioritas_detail.idossier_prioritas_id', 'inner');
		$grid->setJoinTable('plc2.itemas', 'itemas.C_ITENO = dossier_upd.iupb_id', 'inner');
		$grid->setJoinTable('plc2.tabmas02', 'tabmas02.c_lisensi = itemas.c_lisensi', 'inner');		
		
		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setQuery('dossier_upd.ihold', 0);
		//$grid->setQuery('dossier_upd.iappad_pembagian', 2);
		$grid->setQuery('dossier_upd.idossier_upd_id in (
				select a.idossier_upd_id 
				from dossier.dossier_upd a 
				join dossier.dossier_prioritas_detail b on b.idossier_upd_id = a.idossier_upd_id
				join dossier.dossier_prioritas c on c.idossier_prioritas_id=b.idossier_prioritas_id 
				where c.iApprove_prio= 2
				and a.lDeleted = 0
				and b.lDeleted = 0
				and c.lDeleted = 0
				#and a.iSubmit_bagi_upd=1
				group by a.idossier_upd_id

			) ', NULL);
		$grid->setQuery('dossier_upd.iSubmit_bagi_staff',0);
		$grid->setQuery('dossier_upd.iappad_produk_staff',0);
		$grid->setQuery('dossier_upd.vpic is null',NULL);
		$grid->setQuery('dossier_upd.idossier_upd_id NOT IN ('.$this->input->get('idossier_upd_id').')', null);

		//mandatori untuk team
		
		$mydept=$this->auth_plcexport->tipe();
		if($this->auth_plcexport->is_manager()){
			$q="select te.iteam_id from plc2.plc2_upb_team te where te.vnip in ('".$this->user->gNIP."') and te.iTipe=2";
			$x=$this->auth_plcexport->dept();
			$manager=$x['manager'];
			if(in_array('AD', $manager)){
				$type='AD';
				$q.=" and vtipe='".$type."'";
				$d=$this->dbset->query($q)->row_array();
				if($d['iteam_id']==17){
					$grid->setQuery('dossier_upd.iTeam_andev IN (17)', null);
				}elseif ($d['iteam_id']==40) {
					$sq='dossier_upd.iTeam_andev in (40)';
					$grid->setQuery('('.$sq.' or is_old=1)', null);
				}
			}else{$type='';}
		}else{
			$x=$this->auth_plcexport->dept();
			$q="select * from plc2.plc2_upb_team_item te 
				inner join plc2.plc2_upb_team it on it.iteam_id
				where te.vnip in ('".$this->user->gNIP."') and te.ldeleted=0 and it.ldeleted=0";
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('AD', $team)){
					$type='AD';
					if($d['iteam_id']==17){
						$grid->setQuery('dossier_upd.iTeam_andev IN (17)', null);
					}elseif ($d['iteam_id']==40) {
						$sq='dossier_upd.iTeam_andev in (40)';
						$grid->setQuery('('.$sq.' or is_old=1)', null);
					}
				}else{$type='';}
			}
		}

		$grid->setGridView('grid');

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
    	$this->index($this->input->get('action'));//test komen
    }

	function listBox_browse_upd_dokumen_pembagian_staff_pilih($value, $pk, $name, $rowData) {
		$url_rincian = base_url()."processor/plc/partial/view/export?getreviewdokumen"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upd_prio('.$pk.',\''.$rowData->vUpd_no.'\',\''.$rowData->itemas__C_ITENO.'\',\''.$rowData->itemas__C_ITNAM.'\',\''.$rowData->vNama_usulan.'\') ;" />';
		$o .= '<script type="text/javascript">
					function pilih_upd_prio (id, vUpd_no, vgenerik, vsediaan, dosis) {					
						custom_confirm("Yakin", function() {

						$("#idossier_upd_id_dis_'.$this->input->get("field").'").val(vUpd_no);
						$("#idossier_upd_id_'.$this->input->get("field").'").val(id);
						$("#vgenerik_'.$this->input->get("field").'").val(dosis);
						$("#vsediaan_'.$this->input->get("field").'").val(vgenerik);
						$("#dosis_'.$this->input->get("field").'").val(vsediaan);
						$("#alert_dialog_form").dialog("close");


						});
					}
				</script>';

		return $o;
	}
}

