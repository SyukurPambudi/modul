<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_upd_prio_export extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_plcexport');
		$this->_field = $this->input->get('field');
		$this->dbset = $this->load->database('plc', true);
		$this->user = $this->auth_plcexport->user();
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPD');		
		$grid->setTable('dossier.dossier_upd');		
		$grid->setUrl('browse_upd_prio_export');
		$grid->addList('pilih','vUpd_no','dTanggal_upd','itemas.C_ITENO','vNama_usulan','iTeam_andev');
		$grid->setSortBy('vUpd_no');
		$grid->setSortOrder('DESC');
		$grid->setWidth('vUpd_no', '55');
		$grid->setWidth('dTanggal_upd', '190');
		$grid->setWidth('itemas.C_ITENO', '210');
		$grid->setWidth('vNama_usulan', '300');
		$grid->setWidth('pilih', '25');

		$grid->setLabel('vUpd_no', 'No. UPD');
		$grid->setLabel('itemas.C_ITENO', 'No. Produk');
		$grid->setLabel('dTanggal_upd', 'Tanggal UPD');	
		$grid->setLabel('vNama_usulan', 'Nama Usulan');
		$grid->setLabel('iTeam_andev','Team Andev'); 
		
		$grid->setSearch('vUpd_no','dTanggal_upd');
		
		$grid->setAlign('vUpd_no', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');

		$grid->setInputGet('_iupd_id', $this->input->get('iupd_id'));
		//echo "test : ".$this->input->get('_iupb_id');

		$grid->changeFieldType('iTeam_andev','combobox','',array(''=>'Pilih', 17=>'Andev Export 1', 40=>'Andev Export 2'));

		// join table
		$grid->setJoinTable('plc2.itemas', 'itemas.C_ITENO = dossier_upd.iupb_id', 'inner');
		$grid->setQuery('idossier_upd_id not in ('.str_replace("_", ",", $this->input->get('_iupd_id')).')', null);

		if($this->auth_plcexport->is_manager()){
			$x=$this->auth_plcexport->dept();
			$manager=$x['manager'];
			$q="select te.iteam_id from plc2.plc2_upb_team te where te.vnip in ('".$this->user->gNIP."')";
			
			if(in_array('BDI', $manager)){
				$type='BDI';
				$q.=" and vtipe='".$type."'";
				$d=$this->dbset->query($q)->row_array();
				if($d['iteam_id']==91){//BDIRM 2
					$sq='iTeam_andev in (17)';
					$grid->setQuery($sq, null);
				}elseif ($d['iteam_id']==78) {
					$sq='iTeam_andev in (40)';
					$grid->setQuery($sq.' or is_old=1', null);
				}
			}
		}else{
			$x=$this->auth_plcexport->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				$q="select * from plc2.plc2_upb_team_item te 
				inner join plc2.plc2_upb_team it on it.iteam_id
				where te.vnip in ('".$this->user->gNIP."') and te.ldeleted=0 and it.ldeleted=0";
				if(in_array('BDI', $team)){
					$type='BDI';
					$q.=" and vtipe='".$type."'";
					$d=$this->dbset->query($q)->row_array();
					$sq='iTeam_andev in ('.$d['iteam_id'].')';
					if($d['iteam_id']==91){//BDIRM 2
						$grid->setQuery($sq, null);
					}elseif ($d['iteam_id']==78) {
						$grid->setQuery($sq.' or is_old=1', null);
					}
				}
			}
		}

		$grid->setQuery('iApprove_upd = "2" ', null);
		$grid->setQuery('dossier_upd.ihold', 0);
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

	function listBox_browse_upd_prio_export_pilih($value, $pk, $name, $rowData) {
		$url_header = base_url()."processor/plc/daftar/upd/export/?action=getdetil"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upd_prio('.$pk.',\''.$rowData->vUpd_no.'\',\''.$rowData->dTanggal_upd.'\',\''.$rowData->itemas__C_ITENO.'\',\''.$rowData->vNama_usulan.'\') ;" />';
		$o .= '<script type="text/javascript">
					var ix = "'.$this->input->get('index').'";
					function pilih_upd_prio (id, vUpd_no, dTanggal_upd, iupb_id,vNama_usulan) {					
						custom_confirm("Yakin", function() {
							$(".upd_prio_upd_id").eq(ix).val(id);
							$(".upd_prio_upd_no").eq(ix).val(vUpd_no);
							$(".upd_prio_nama_usulan").eq(ix).text(vNama_usulan);
							$(".upd_prio_tgl").eq(ix).text(dTanggal_upd);
							$(".upd_prio_iupb_id").eq(ix).text(iupb_id);

							//$(".upd_prio_kategori_"+pdId).eq(ix).text(ikategoriupb_id);
							$("#alert_dialog_form").dialog("close");
						});
					}
				</script>';

		return $o;
	}
}
