<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_upd_komparator extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->load->library('lib_utilitas');
		$this->_field = $this->input->get('field');
		$this->dbset = $this->load->database('dosier', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPD Komparator');		
		$grid->setTable('dossier.dossier_upd');		
		$grid->setUrl('browse_upd_komparator');
		$grid->addList('pilih','vUpd_no','vNama_usulan','itemas.C_ITENO','itemas.C_ITNAM','tabmas02.c_nmlisen','cNip_pengusul','plc2_upb_team.vteam');
		$grid->setSortBy('vUpd_no');
		$grid->setSortOrder('DESC');
		$grid->setWidth('vUpd_no', '70');
		$grid->setWidth('itemas.C_ITENO', '70');
		$grid->setWidth('plc2_upb_team.vteam', '150');
		$grid->setWidth('pilih', '50');

	
		$grid->setLabel('vUpd_no', 'No Dossier');
		$grid->setLabel('vNama_usulan', 'Nama Usulan');
		$grid->setLabel('itemas.C_ITENO', 'Kode Produk');
		$grid->setLabel('cNip_pengusul', 'NIP Pengusul');
		$grid->setLabel('plc2_upb_team.vteam', 'Team Andev');
		$grid->setLabel('itemas.C_ITNAM', 'Nama Produk');
		$grid->setLabel('tabmas02.c_nmlisen', 'Lisensi');

		$grid->setAlign('pilih', 'center');

		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setSearch('vUpd_no','vNama_usulan');
		$grid->setJoinTable('plc2.plc2_upb_team', 'plc2.plc2_upb_team.iteam_id = dossier.dossier_upd.iTeam_andev', 'inner');
		$grid->setJoinTable('plc2.itemas','dossier_upd.iupb_id=itemas.C_ITENO','inner');
		$grid->setJoinTable('plc2.tabmas02', 'tabmas02.c_lisensi = itemas.c_lisensi', 'inner');	
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_upd.lDeleted', 0);

		$nip=$this->user->gNIP;
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('AD', $manager)){
				$type='AD';
				$grid->setQuery('dossier_upd.iTeam_andev IN ('.$this->auth->my_teams().')', null);
			}elseif(in_array('TD', $manager)){
				$type='TD';
				$sqlcek='select * from plc2.plc2_upb_team te where te.vnip="'.$nip.'" and vtipe="TD"';
				$r=$this->dbset->query($sql);
				if($r->num_rows>=1){
					$d=$r->row_array();
					if($d['iteam_id']==81){
						$grid->setQuery('dossier_upd.iTeam_andev IN (17)', null);
					}elseif ($d['iteam_id']==83) {
						$grid->setQuery('dossier_upd.iTeam_andev IN (40)', null);
					}
				}
			}else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('AD', $team)){
				$type='AD';
				$grid->setQuery('dossier_upd.iTeam_andev IN ('.$this->auth->my_teams().')', null);
			}elseif(in_array('TD', $manager)){
				$type='TD';
				$sqlcek='select * from plc2.plc2_upb_team_item ite
					join plc2.plc2_upb_team te on te.iteam_id=ite.iteam_id
					where ite.ldeleted=0 and te.ldeleted=0 and te.vtipe="TD" and ite.vnip="'.$nip.'"';
				$r=$this->dbset->query($sql);
				if($r->num_rows>=1){
					$d=$r->row_array();
					if($d['iteam_id']==81){
						$grid->setQuery('dossier_upd.iTeam_andev IN (17)', null);
					}elseif ($d['iteam_id']==83) {
						$grid->setQuery('dossier_upd.iTeam_andev IN (40)', null);
					}
				}
			}else{$type='';}
		}
		//Tidak muncul jika sudah di input di komparator
		$grid->setQuery('dossier_upd.idossier_upd_id not in (select kom.idossier_upd_id from dossier.dossier_komparator kom where kom.lDeleted=0)',NULL);

		//Approval review_dokumen
		$grid->setQuery('dossier_upd.idossier_upd_id in (select rev.idossier_upd_id from dossier.dossier_review rev where rev.lDeleted=0 and rev.iApprove_review=2)',NULL);

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
	
    /*Modify main grid output */
    function listBox_browse_upd_komparator_cNip_pengusul($value, $pk, $name, $rowData){
    	$sql="select * from hrd.employee em where em.cNip='".$value."'";
    	$d=$this->dbset->query($sql)->row_array();
    	return $d['cNip'].' - '.$d['vName'];
    }

	function listBox_browse_upd_komparator_pilih($value, $pk, $name, $r) {
		$url_header = base_url()."processor/plc/permintaan/komparator?action=getdetil"; 
			$o = '<input type="radio" name="pilih" onClick="javascript:pilih_komparator_detail('.$pk.',\''.$r->vUpd_no.'\',\''.$r->vNama_usulan.'\',\''.$r->itemas__C_ITENO.'\',\''.$r->itemas__C_ITNAM.'\',\''.$r->tabmas02__c_nmlisen.'\') ;" />
		<script type="text/javascript">
			function pilih_komparator_detail (id, Upd_no, vNama_usulan,no_produk,name_produk,lisensi){				
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_idossier_upd_id").val(id);
				$("#'.$this->input->get('field').'_idossier_upd_id_dis").val(Upd_no);
				$("#'.$this->input->get('field').'_vNama_usulan").text(vNama_usulan);
				$("#'.$this->input->get('field').'_no_produk").text(no_produk);
				$("#'.$this->input->get('field').'_name_produk").text(name_produk);
				$("#'.$this->input->get('field').'_lisensi").text(lisensi);
				$("#alert_dialog_form").dialog("close");
			});
			}
		</script>';
		return $o;
	}
}
